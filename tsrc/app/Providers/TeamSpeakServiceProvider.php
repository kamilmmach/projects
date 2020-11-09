<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class TeamSpeakServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('teamspeak', function ($app) {
            $username = env('TS_USERNAME', 'serveradmin');
            $password = env('TS_PASSWORD', 'password');
            $address = env('TS_ADDRESS', '127.0.0.1');
            $query_port = env('TS_QUERYPORT', '10011');
            $server_port = env('TS_SERVERPORT', '9987');
            
            return \TeamSpeak3::factory('serverquery://' . $username . ':' . $password . '@'
                . $address . ':' . $query_port . '/?server_port=' . $server_port);
        });
    }
}
