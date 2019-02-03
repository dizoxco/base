<?php

use App\Models\Comment;
use Faker\Factory as Faker;

$faker = Faker::create('fa_IR');
$factory->define(Comment::class, function () use ($faker) {
    return [
        'body'  =>  omidFaker('sentence', 7),
        'stat'  =>  true,
    ];
});
