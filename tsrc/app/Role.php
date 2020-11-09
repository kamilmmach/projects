<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name'];

    public static function getByName($name)
    {
        return Role::whereName($name)->firstOrFail();
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
