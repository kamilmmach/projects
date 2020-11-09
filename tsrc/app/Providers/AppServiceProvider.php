<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Carbon::setLocale(config('app.locale'));

        Validator::extend('not_contains', function ($attribute, $value, $parameters) {
            // Banned words
            foreach ($parameters as $word) {
                if (stripos($value, $word) !== false) {
                    return false;
                }
            }
            return true;
        });

        Validator::replacer('not_contains', function ($message, $attribute, $rule, $parameters) {
            return 'Pole ' . $attribute . ' nie może zawierać słowa ' . $parameters[0];
        });

        Validator::extend('tsuid_exists', function ($attribute, $value, $parameters) {
            try {
                $ts3 = app('teamspeak');

                // Throws an exception if the client doesn't exist
                $ts3->clientFindDb($value, true);
            } catch (\TeamSpeak3_Exception $e) {
                if ($e->getCode() == 1281) {
                    return false;
                }
            }

            return true;
        });

        Validator::replacer('tsuid_exists', function ($message, $attribute, $rule, $parameters) {
            return 'Użytkownik o podanym TSUID nie istnieje na serwerze.';
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
