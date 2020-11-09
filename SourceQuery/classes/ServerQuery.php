<?php

namespace KM\SourceQuery;

class ServerQuery
{
    // header response, -1 means it's not split and as of now the only supported type
    const SIMPLE_HEADER = 0xffffffff;

    private $server_connection_;
    private $challenge_;
    private $cache_;

    public $server;
    public $players;

    public function __construct($ip, $port)
    {
        $this->server_connection_ = new ServerConnection($ip, $port);

        $this->server = [];

        $this->cache_ = new Cache();
    }

    public function connect()
    {
        return $this->server_connection_->connect();
    }

    public function disconnect()
    {
        return $this->server_connection_->disconnect();
    }

    public function getServerInfo()
    {
        $this->server = $this->cache_->retrieveOrCallback('server_' . $this->server_connection_, function() {
            if($this->server_connection_->connected === false)
            {
                throw new ServerConnectionException("Not connected to the server!",
                                                    ServerConnectionException::STREAM_NOT_CONNECTED);
            }
                                                
            $this->writeFormatted(PacketType::A2S_INFO, "Source Engine Query\0");

            $buffer = $this->server_connection_->read();

            $header = $buffer->getLong();
            
            if($header !== self::SIMPLE_HEADER)
            {
                throw new ServerQueryException("Multipacket data not yet supported!",
                                                ServerQueryException::MULTIPACKET_NOT_SUPPORTED);
            }

            $type = $buffer->getByte();

            if($type != PacketType::S2A_INFO)
            {
                throw new ServerQueryException("Server engine not supported!",
                ServerQueryException::SERVER_ENGINE_NOT_SUPPORTED);
            }

            $server = [];
            $server['protocol_version'] = $buffer->getByte();
            $server['name'] = $buffer->getString();
            // Get map
            $server['map'] = $buffer->getString();
            // Get Folder
            $server['folder'] = $buffer->getString();
            // Get game
            $server['gamename'] = $buffer->getString();
            // Get AppID
            $server['appid'] = $buffer->getShort();
            // Get Players
            $server['num_players'] = $buffer->getByte();
            
            // Get MaxPlayers
            $server['max_players'] = $buffer->getByte();
            
            $server['num_bots'] = $buffer->getByte();

            $type = chr($buffer->getByte());
            switch($type)
            {
                case 'd':
                    $server['server_type'] = ServerType::DEDICATED;
                    break;
                case 'l':
                    $server['server_type'] = ServerType::LISTEN;
                    break;
                case 'p':
                    $server['server_type'] = ServerType::SOURCETV;
                    break;
                default:
                    $server['server_type'] = ServerType::UNKNOWN;
            }
            
            $environment = chr($buffer->getByte());
            switch($environment)
            {
                case 'w':
                    $server['environment'] = ServerEnvironment::WINDOWS;
                    break;
                case 'l':
                    $server['environment'] = ServerEnvironment::LINUX;
                    break;
                case 'm':
                case 'o':
                    $server['environment'] = ServerEnvironment::MAC;
                    break;
                default:
                    $server['environment'] = ServerEnvironment::UNKNOWN;
            }

            $server['password_required'] = ($buffer->getByte() === 1);
            $server['secured'] = ($buffer->getByte() === 1);

            $server['version'] = $buffer->getString();
            if ($buffer->bytesUnread() > 0)
            {
                $server['edf'] = $buffer->getByte();
                if($server['edf'] & 0x80)
                    $server['port'] = $buffer->getShort();
                if($server['edf'] & 0x10)
                    $server['steamid'] = $buffer->getLongLong();
                if($server['edf'] & 0x40)
                {
                    $server['sourcetv_port'] = $buffer->getShort();
                    $server['sourcetv_name'] = $buffer->getString();
                }
                if($server['edf']& 0x20)
                    $server['keywords'] = $buffer->getString();
                if($server['edf']& 0x01)
                    $server['gameid'] = $buffer->getLongLong();
            }
            
            if($server['num_players'] === 0)
            {
                $server['num_players_connecting'] = $server['num_players'];
            }
            else
            {
               $this->getPlayers();
               $server['num_players_connecting'] = $this->getNumberOfConnectingPlayers();
               $server['num_players'] -= $server['num_players_connecting'];
            }

            return $server;
        }, 30);

        return $this->server;
    }

    public function getPlayers()
    {
        $this->players = $this->cache_->retrieveOrCallback('players', function() {
            if($this->server_connection_->connected === false)
            {
                throw new ServerConnectionException("Not connected to the server!",
                                                    ServerConnectionException::STREAM_NOT_CONNECTED);
            }

            $this->getChallenge(PacketType::A2S_PLAYER);

            $this->writeFormatted(PacketType::A2S_PLAYER, $this->challenge_);
            $buffer = $this->server_connection_->read();

            $header = $buffer->getLong();
            if($header !== 0xffffffff)
            {
                throw new ServerQueryException("Multipacket data not yet supported!",
                                                ServerQueryException::MULTIPACKET_NOT_SUPPORTED);
            }

            $type = $buffer->getByte();

            if($type != PacketType::S2A_PLAYER)
            {
                throw new ServerQueryException("Invalid challenge packet type.", ServerQueryException::INVALID_PACKET);
            }

            $count = $buffer->getByte();

            $players = [];
            while($count-- > 0)
            {
                $buffer->getByte(); // uid, but is always 0

                $player = [
                    'nickname' =>  $buffer->getString(),
                    'score' => $buffer->getLong(), 
                    'duration' => $buffer->getFloat()
                ];

                $players[] = $player;
            }

            return $players;
        }, 30);

        return $this->players;
    }

    private function writeFormatted($header, $data = '')
    {
        $packet = pack("ICa*", ServerQuery::SIMPLE_HEADER, $header, $data);
        $this->server_connection_->writeRaw($packet);
    }

    private function getChallenge($header)
    {
        if($this->challenge_ !== null)
            return;
        
        if($this->server_connection_->connected === false)
        {
            throw new ServerConnectionException("Not connected to the server!",
                                                ServerConnectionException::STREAM_NOT_CONNECTED);
        }

        $this->writeFormatted($header, '\xff\xff\xff\xff');
        $buffer = $this->server_connection_->read();

        $header = $buffer->getLong();
        if($header !== self::SIMPLE_HEADER)
        {
            throw new ServerQueryException("Multipacket data not yet supported!",
                                            ServerQueryException::MULTIPACKET_NOT_SUPPORTED);
        }

        $type = $buffer->getByte();
        if($type !== PacketType::S2A_CHALLENGE)
        {
            throw new ServerQueryException("Invalid challenge packet type.", ServerQueryException::INVALID_PACKET);
        }

        $this->challenge_ = $buffer->getRawBytes(4); // I need a string for formattedWrite
    }

    private function getNumberOfConnectingPlayers()
    {
        $connecting = 0;
        foreach($this->players as $player)
        {
            if($player['nickname'] == '')
                $connecting++;
        }
        return $connecting;
    }
}

abstract class PacketType
{
    // Basic information about the server.
    const A2S_INFO = 0x54;
    const S2A_INFO = 0x49;
    // Details about each player on the server.
    const A2S_PLAYER = 0x55;
    const S2A_PLAYER = 0x44;
    // The rules the server is using.
    const A2S_RULES = 0x56;
    const S2A_RULES = 0x45;
    // Ping the server. (DEPRECATED)
    const A2A_PING = 0x69; // 69, hehe
    const S2A_PING = 0x6A;

    // Challenge number header
    const S2A_CHALLENGE = 0x41;
}