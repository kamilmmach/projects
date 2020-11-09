<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
 */

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'ts_uid' => str_random(28),
    ];
});

$factory->state(App\User::class, 'admin', function (Faker\Generator $faker) {
    return [
        'role_id' => 1,
    ];
});

$factory->state(App\User::class, 'member', function (Faker\Generator $faker) {
    return [
        'role_id' => 2,
    ];
});

$factory->defineAs(\App\ChannelMessage::class, 'user', function (Faker\Generator $faker) {
    return [
        'user_id' => 2,
        'message' => join($faker->sentences, ' '),
        'created_at' => $faker->dateTime()
    ]; 
});

$factory->defineAs(\App\ChannelMessage::class, 'admin', function (Faker\Generator $faker) {
    return [
        'user_id' => 1,
        'message' => join($faker->sentences, ' '),
        'created_at' => $faker->dateTime()
    ]; 
});

$factory->define(App\Channel::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->sentence(5, true),
        'password' => $faker->password,
        'owner_id' => 2,
    ];
});

$factory->state(App\Channel::class, 'pending', function (Faker\Generator $faker) {
    return [
        'status_id' => 1,
    ];
});

$factory->state(App\Channel::class, 'accepted', function (Faker\Generator $faker) {
    return [
            'owner_id' => 2,
            'responder_id' => 1,
            'status_id' => 2,
            'answered_at' => Carbon\Carbon::now(),
        ];
});

$factory->state(App\Channel::class, 'rejected', function (Faker\Generator $faker) {
    return [
        'owner_id' => 2,
        'responder_id' => 1,
        'status_id' => 3,
        'answered_at' => Carbon\Carbon::now(),
    ];
});
