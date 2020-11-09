<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChannelMessage extends Model
{
    protected $fillable = ['message'];
    
    public function channel()
    {
        return $this->belongsTo(\App\Channel::class);
    }
    
    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }
}
