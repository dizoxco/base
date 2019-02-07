<?php

use App\Models\Variation;
use Faker\Factory as Faker;

$faker = Faker::create('fa_IR');
$factory->define(Variation::class, function () use ($faker) {
    return [
        'business_id' => null,
        'product_id' => null,
        'price' => rand(111111, 999999),
        'quantity' => rand(1, 10),
        'options' => json_encode([]),
    ];
});
