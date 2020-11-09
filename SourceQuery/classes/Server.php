<?php

namespace KM\SourceQuery;

class Server
{
    public $protocol_version;
    public $name;
    public $map;
    public $folder;
    public $gamename;
    public $appid;
    public $num_players;
    public $num_players_connecting;
    public $max_players;
    public $num_bots;
    public $server_type;
    public $environment;
    public $password_required;
    public $secured;
    public $version;
    public $edf; // extra data flag

    // This data may not be filled
    public $port;
    public $steamid;
    public $sourcetv_port;
    public $sourcetv_name;
    public $keywords;
    public $gameid;

    public $players;
}

abstract class ServerType
{
    const DEDICATED = 1;
    const LISTEN = 2;
    const SOURCETV = 3;
    const UNKNOWN = 4;
}

abstract class ServerEnvironment
{
    const LINUX = 1;
    const WINDOWS = 2;
    const MAC = 3;
    const UNKNOWN = 4;
}