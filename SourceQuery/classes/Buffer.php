<?php

namespace KM\SourceQuery;

class Buffer 
{
    private $buffer_;
    private $length_;
    private $position_;

    public function __construct($buffer = "")
    {
        $this->copyBuffer($buffer);
    }

    public function copyBuffer($buffer)
    {
        $this->buffer_ = $buffer;
        $this->length_ = strlen($buffer);
        $this->position_ = 0;
    }

    public function bytesUnread()
    {
        return $this->length_ - $this->position_;

    }

    public function getRawBytes($length = 1)
    {
        // Return an empty string if either negative length or 
        // trying to read more bytes than there are to read.
        // Perhaps an Exception would be in place but can't be bothered.
        if($length > $this->bytesUnread() || $length <= 0)
            return '';
        
        $data = substr($this->buffer_, $this->position_, $length);
        $this->position_ += $length;
        
        return $data;
    }

    // returns byte as a number
    public function getByte()
    {
        return ord($this->getRawBytes(1));
    }

    public function getShort()
    {
        $data = unpack('S', $this->getRawBytes(2));
        return $data[1];
    }

    public function getLong()
    {
        $data = unpack('L', $this->getRawBytes(4));
        return $data[1];
    }

    // assuming that we are working on a 64-bit PHP
    public function getLongLong()
    {
        $data = unpack('Q', $this->getRawBytes(8));
        return $data[1];
    }

    public function getFloat()
    {
        $data = unpack('f', $this->getRawBytes(4));
        return $data[1];
    }

    public function getString()
    {
        $pos = strpos($this->buffer_, "\0", $this->position_);

        // NULL Byte not found
        if($pos === false)
            return '';
        
        $data = $this->getRawBytes($pos - $this->position_);

        $this->position_++; // Omit NULL Byte

        return $data;
    }
}