<?php

use Faker\Factory as Faker;

$faker      =   Faker::create('fa_IR');
$factory->define(App\Models\User::class, function () use ($faker) {
    return [
        'name'              =>  $faker->name,
        'email'             =>  $faker->unique()->safeEmail,
        'password'          =>  bcrypt('123456'),
        'activation_token'  =>  str_random(30),

    ];
});
