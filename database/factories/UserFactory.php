<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10)
    ];
});

$factory->defineAs(App\Status::class, 'user', function ()
{
    return [
        'name' => 'registered',
    ];
});

$factory->defineAs(App\User::class, 'admin', function (Faker $faker)
{
    return [
        'name'              => 'admin',
        'email'             => 'admin@test.loc',
        'password'          => bcrypt('admin'),
        'registration_date' => \Carbon\Carbon::now(),
        'remember_token'    => str_random(10),
        ];
});

$factory->defineAs(App\Role::class, 'admin', function ()
{
    return [
        'name'          => 'admin',
        'description'   => 'Main Admin',
    ];
});

$factory->defineAs(App\User::class, 'user', function (Faker $faker)
{
    $faker = \Faker\Factory::create();
    return [
        'name'              => $faker->name,
        'email'             => $faker->unique()->safeEmail,
        'password'          => bcrypt('user'),
        'registration_date' => \Carbon\Carbon::now(),
        'remember_token'    => str_random(10),
    ];
});

$factory->defineAs(App\Role::class, 'user', function ()
{
    return [
        'name'              => 'user',
        'description'       => 'Author',
    ];
});

$factory->defineAs(App\User::class, 'guest', function (Faker $faker)
{
    $faker = \Faker\Factory::create();
    return [
        'name'              => $faker->name,
        'email'             => $faker->unique()->safeEmail,
        'password'          => bcrypt('qwerty'),
        'registration_date' => \Carbon\Carbon::now(),
        'remember_token'    => str_random(10)
    ];
});

