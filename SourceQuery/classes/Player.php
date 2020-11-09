<?php

namespace KM\SourceQuery;

class Player
{
    public $nickname;
    public $score;
    public $duration;

    public function __construct($nickname, $score, $duration)
    {
        $this->nickname = $nickname;
        $this->score = $score;
        $this->duration = $duration;
    }
}