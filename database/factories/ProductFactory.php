<?php

use Faker\Factory as Faker;

$faker = Faker::create('fa_IR');

$factory->define(App\Models\Product::class, function () use ($faker) {
    return [
        'title'     =>  $faker->sentence,
        'slug'      =>  $faker->slug,
        'abstract'  =>  $faker->sentence,
        'body'      =>  $faker->paragraphs(4, true),
        'attributes'=>  json_encode($faker->paragraphs()),
        'variations'=>  json_encode($faker->paragraphs()),
        'single'    =>  $faker->boolean(),
    ];
});
