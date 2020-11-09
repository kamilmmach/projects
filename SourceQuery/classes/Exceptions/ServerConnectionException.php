<?php

namespace KM\SourceQuery;

class ServerConnectionException extends \Exception 
{
    const STREAM_CREATION_FAILED = 1;
    const STREAM_NOT_CONNECTED = 2;
}