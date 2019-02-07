<?php

use App\Models\Order;
use Faker\Factory as Faker;

$faker = Faker::create('fa_IR');
$factory->define(Order::class, function () use ($faker) {
    return [
        'user_id' => null,
        'receiver' => null,
        'mobile' => null,
        'province' => null,
        'city_id' => null,
        'address' => null,
    ];
});
