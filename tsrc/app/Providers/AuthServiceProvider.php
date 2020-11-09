<?php

namespace App\Providers;

use App\Channel;
use App\ChannelMessage;
use App\User;
use App\Policies\ChannelMessagePolicy;
use App\Policies\ChannelPolicy;
use App\Policies\UserPolicy;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Channel::class => ChannelPolicy::class,
        ChannelMessage::class => ChannelMessagePolicy::class,
        User::class => UserPolicy::class
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
