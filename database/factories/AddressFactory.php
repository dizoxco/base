<?php

use Faker\Factory as Faker;

$faker = Faker::create('fa_IR');
$factory->define(App\Models\Address::class, function () use ($faker) {
    return [
        'user_id' => null,
        'receiver' => $faker->name,
        'mobile' => $faker->mobileNumber,
        'province' => \faker()->province->first(),
        'city' => \faker()->city->first(),
        'address' => $faker->address,
        'postal_code' => $faker->numerify('###########'),
    ];
});
