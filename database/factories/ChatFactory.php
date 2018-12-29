<?php

use App\Models\Chat;
use Faker\Factory as Faker;

$faker = Faker::create('fa_IR');
$factory->define(Chat::class, function () use ($faker) {
    return [
        'type'  =>  enum('chat.type.chat'),
    ];
});
