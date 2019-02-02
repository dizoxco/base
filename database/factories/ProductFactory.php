<?php

use Faker\Factory as Faker;

$faker = Faker::create('fa_IR');

$factory->define(App\Models\Product::class, function () use ($faker) {
    return [
        'title'     =>  $title = omidFaker(),
        'slug'      =>  str_slug($title),
        'abstract'  =>  omidFaker('sentence', 3),
        'body'      =>  omidFaker('sentence', 10),
        'attributes'=>  json_encode($faker->paragraphs()),
        'variations'=>  json_encode($faker->paragraphs()),
        'single'    =>  $faker->boolean(),
        'created_at'=>  $faker->dateTimeBetween('-5 years', '+5 years'),
    ];
});
