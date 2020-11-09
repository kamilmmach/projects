<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    public function __construct()
    {
    }

    public function channels()
    {
        return $this->hasMany(Channel::class);
    }

    public static function getByName($name)
    {
        return Status::whereName($name)->firstOrFail();
    }

    public function getCSSClassSuffix()
    {
        switch ($this->name) {
            case 'pending':
                return 'info';
            case 'accepted':
                return 'success';
            case 'rejected':
                return 'danger';
            default:
                return 'primary';
        }
    }

    public function isPending()
    {
        return $this->name == 'pending';
    }
    public function isAccepted()
    {
        return $this->name == 'accepted';
    }
    public function isRejected()
    {
        return $this->name == 'rejected';
    }
}
