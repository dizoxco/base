<?php

use Faker\Factory as Faker;

$faker = Faker::create('fa_IR');

$factory->define(App\Models\Business::class, function () use ($faker) {
    return [
        'brand' => $faker->company,
        'province' => $faker->word,
        'city' => $faker->word,
        'tell' => $faker->numerify('########'),
        'phone_code' => $faker->numerify('0##'),
        'address' => $faker->address,
        'postal_code' => $faker->numerify('##########'),
        'mobile' => $faker->numerify('09#2######'),
        'storage_address' => $faker->address,
    ];
});
