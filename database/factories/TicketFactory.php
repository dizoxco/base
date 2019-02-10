<?php

use Faker\Factory;
use App\Models\Ticket;

$faker = Factory::create('fa_IR');

$factory->define(Ticket::class, function () use ($faker) {
    return [
        'user_id' => rand(1, 1000),
        'business_id' => $business = rand(0, 100),
        'attributes' => $business == 0 ? json_encode([
            'title' => 'This is a ticket to Modella',
        ]) : null,
    ];
});
