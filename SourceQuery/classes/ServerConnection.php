<?php

namespace KM\SourceQuery;

class ServerConnection
{
    private $stream_;
    public $connected;

    private $ip_;
    private $port_;
    private $timeout_;

    public function __construct($ip, $port)
    {
        $this->ip_ = $ip;
        $this->port_ = $port;
        $this->connected = false;
    }

    public function __toString()
    {
        return $this->ip_ . '_' . $this->port_;
    }

    public function connect($timeout = 2)
    {
        $this->timeout_ = $timeout;
        
        $uri = 'udp://' . $this->ip_ . ':' . $this->port_;

        $this->stream_ = stream_socket_client($uri, $errno, $errstr, $this->timeout_);
        if($this->stream_ === false)
        {
            throw new ServerConnectionException("Could not create a stream: $errstr", 
                                                ServerConnectionException::STREAM_CREATION_FAILED);
        }

        stream_set_timeout($this->stream_, $this->timeout_);
        $this->connected = true;

        return true;
    }

    public function disconnect()
    {
        if($this->connected === false)
        {
            throw new ServerConnectionException("Not connected to the server!", 
            ServerConnectionException::STREAM_NOT_CONNECTED);
        }
        
        fclose($this->stream_);
        $this->stream_ = null;
        $this->connected = false;

        return true;
    }

    public function writeRaw($data)
    {
        if($this->connected === false)
        {
            throw new ServerConnectionException("Not connected to the server!", 
            ServerConnectionException::STREAM_NOT_CONNECTED);
        }

        return strlen($data) === fwrite($this->stream_, $data);
    }

    public function read($length = 1400)
    {
        if($this->connected === false)
        {
            throw new ServerConnectionException("Not connected to the server!", 
            ServerConnectionException::STREAM_NOT_CONNECTED);
        }

        $buffer = new Buffer(fread($this->stream_, $length));
        return $buffer;
    }
}