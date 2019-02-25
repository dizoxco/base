<?php

use App\Models\Business;
use Faker\Factory as Faker;

$faker = Faker::create('fa_IR');

$factory->define(Business::class, function () use ($faker) {
    return [
        'brand' => $faker->company,
        'slug' => str_slug("{$faker->company}_{$faker->numerify('###')}"),
        'city_id' => \faker('city')->first()->id,
        'contact' => json_encode([]),
        'status' => 1,
        'created_at' => $created_at = $faker->dateTimeBetween('-5 years', 'now'),
        'updated_at' => $faker->dateTimeBetween($created_at, 'now'),
    ];
});
