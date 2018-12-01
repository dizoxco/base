<?php

use Faker\Factory as Faker;

$faker      =   Faker::create('fa_IR');
$factory->define(App\Models\Post::class, function () use ($faker) {
    return [
        'title'     =>  $faker->sentence,
        'slug'      =>  $faker->slug,
        'abstract'  =>  $faker->sentence,
        'body'      =>  $faker->paragraphs(4, true),
    ];
});
