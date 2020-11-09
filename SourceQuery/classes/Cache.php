<?php
namespace KM\SourceQuery;

// A very simple cache class
class Cache
{
    private $dirName_;

    // A filename is a hashed cacheName
    private $filename_;

    // for debugging purposes
    private $cacheName_;

    // An array that stores time, data and expiration time in seconds
    private $storage_;

    public function __construct($cacheName = "cache", $cacheDir = "cache/")
    {
        $this->cacheName_ = $cacheName;
        $this->filename_ = $this->hashFilename($cacheName);
        $this->setDirectory($cacheDir);

        $this->storage_ = [];

        $this->loadCacheFromFile();
    }

    public function loadCacheFromFile()
    {
        $path = $this->getFilepath();

        if(!is_readable($path))
            return;
        
        $file = @file_get_contents($path);

        if(!$file)
        {
            throw new \Exception("Can't open cache file!");
        }

        $data = unserialize($file);

        if($data === false)
        {
            throw new \Exception("Can't unserialize the data!");
        }

        $this->storage_ = $data;
    }

    public function saveCacheToFile()
    {
        if (!file_exists($this->dirName_))
            @mkdir($this->dirName_);

        $this->clearExpired();
        $data = serialize($this->storage_);

        if(file_put_contents($this->getFilepath(), $data) === false)
            throw new \Exception("Cannot save to cache file!");
    }

    private function getFilepath()
    {
        return $this->dirName_ . $this->filename_ . ".php";
    }

    // Retrieves from cache or calls an external funtion to get data and
    // cache it if it does not exist or expired
    public function retrieveOrCallback($key, $retrieveCallback, $secondsToExpire)
    {
        if($this->isExpired($key))
        {
            $data = $retrieveCallback();
            $this->store($key, $data, $secondsToExpire);
            return $data;
        }
        
        return $this->storage_[$key]['data'];
    }

    public function retrieve($key, $clearExpired = false)
    {
        if($clearExpired)

        if($this->isExpired($key))
            return null;
        
        return $this->storage_[$key]['data'];    
    }

    public function store($key, $data, $secondsToExpire)
    {
        $meta = [
            'time' => time(),
            'data' => $data,
            'secondsToExpire' => $secondsToExpire
        ];

        $this->storage_[$key] = $meta;
        $this->saveCacheToFile();
    }

    public function isExpired($key)
    {
        if(!isset($this->storage_[$key]))
            return true;
        
        $data = $this->storage_[$key];

        return (time() - $data["time"] > $data["secondsToExpire"]);
    }

    public function clear()
    {
        unset($this->storage_);
        $this->storage_ = [];
    }

    public function clearExpired()
    {
        foreach($this->storage_ as $k => $v)
        {
            if((time() - $v["time"] > $v["secondsToExpire"]))
                unset($this->storage_[$k]);
        }
    }

    private function hashFilename($str)
    {
        return sha1($str);
    }

    private function setDirectory($str)
    {
        if(substr($str, -1) != '/')
            $str .= '/';

        $this->dirName_ = $str;
    }

}