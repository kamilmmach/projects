<?php

namespace KM\SourceQuery;

class ServerQueryException extends \Exception 
{
    const MULTIPACKET_NOT_SUPPORTED = 1;
    const SERVER_ENGINE_NOT_SUPPORTED = 2;
    const INVALID_PACKET = 3;
}