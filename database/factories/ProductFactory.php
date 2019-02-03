<?php

use Faker\Factory as Faker;

$faker = Faker::create('fa_IR');

$factory->define(App\Models\Product::class, function () use ($faker) {
    return [
        'title'     =>  $title = \faker('sentence')->first(),
        'slug'      =>  str_slug($title),
        'abstract'  =>  \faker('paragraph')->first(),
        'body'      =>  implode(PHP_EOL, \faker('paragraph',4)->toArray()),
        'attributes'=>  json_encode($faker->paragraphs()),
        'variations'=>  json_encode($faker->paragraphs()),
        'single'    =>  $faker->boolean(),
        'price'     =>  rand(10000, 10000000),
        'created_at'=>  $faker->dateTimeBetween('-5 years', 'now'),
    ];
});
