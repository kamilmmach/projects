<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Request;
use Schema;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'ts_uid', 'role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Gets user's role.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Gets user's channel requests
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function channelsOwned()
    {
        return $this->hasMany(Channel::class, 'owner_id');
    }

    public function channelsRespondedTo()
    {
        return $this->hasMany(Channel::class, 'responder_id');
    }

    public function messages()
    {
        return $this->hasMany(\App\ChannelMessage::class);
    }

    public function isAdmin()
    {
        return $this->role->name === 'admin';
    }

    public function owns(Channel $channel)
    {
        return $this->id === $channel->owner_id;
    }

    public function scopeSortable($query)
    {
        if (Request::has('s') && Request::has('o') &&
            Schema::hasColumn('users', Request::get('s')) &&
            (Request::get('o') == 'asc' || Request::get('o') == 'desc')) {
            return $query->orderBy(Request::get('s'), Request::get('o'));
        } else {
            return $query;
        }
    }
}
