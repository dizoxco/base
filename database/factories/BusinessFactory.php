<?php

use Faker\Factory as Faker;

$faker = Faker::create('fa_IR');

$factory->define(App\Models\Business::class, function () use ($faker) {
    return [
        'brand' => $faker->company,
        'slug' => str_slug("{$faker->company}_{$faker->numerify('###')}"),
        'city_id' => \faker('city')->first()->id,
        'contact' => json_encode([
            'tel' => [
                ['label' => 'کارخانه', 'value' => $faker->phoneNumber],
                ['label' => 'دفتر', 'value' => $faker->phoneNumber]
            ],
            'instagram' => [
                ['label' => 'کارخانه', 'value' => $faker->url],
                ['label' => 'دفتر', 'value' => $faker->url],
            ],
            'address' => [
                ['label' => 'کارخانه', 'value' => $faker->address, 'extra' => [
                    'label' => 'کد پستی', 'value' => rand(1111111111, 9999999999)
                ]],
                ['label' => 'دفتر', 'value' => $faker->address, 'extra' => [
                    'label' => 'کد پستی', 'value' => rand(1111111111, 9999999999)
                ]],
            ]
        ])
    ];
});
