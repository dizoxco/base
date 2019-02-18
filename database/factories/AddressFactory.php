<?php

use Faker\Factory as Faker;

$faker = Faker::create('fa_IR');
$factory->define(App\Models\Address::class, function () use ($faker) {
    return [
        'user_id' => rand(1 , 1000),
        'receiver' => $faker->name,
        'mobile' => $faker->mobileNumber,
        'city_id' => \faker('city')->first()->id,
        'address' => $faker->address,
        'postal_code' => $faker->numerify('###########'),
    ];
});
