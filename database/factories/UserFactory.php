<?php

use App\Models\User;
use Faker\Factory as Faker;

$faker      =   Faker::create('fa_IR');
$password   =   bcrypt(123456);
$factory->define(User::class, function () use ($faker, $password) {
    return [
        'name'              =>  $faker->name,
        'email'             =>  $faker->unique()->safeEmail,
        'password'          =>  $password,
        'activation_token'  =>  str_random(30),
    ];
});

$factory->state(User::class, 'creation', function () use ($password) {
    return [
        'password_confirmation' =>  $password,  //  Can be replaced with any other password.
    ];
});
