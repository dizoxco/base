<?php

use Faker\Factory as Faker;

$faker = Faker::create('fa_IR');

$factory->define(App\Models\Business::class, function () use ($faker) {
    return [
        'brand' => $faker->company,
        'slug' => str_slug($faker->company),
        'province' => \faker()->province->first(),
        'city' => \faker()->city->first(),
        'tell' => $faker->phoneNumber,
        'phone_code' => $faker->numerify('0##'),
        'address' => $faker->address,
        'postal_code' => $faker->numerify('##########'),
        'mobile' => $faker->mobileNumber,
        'storage_address' => $faker->address,
    ];
});
