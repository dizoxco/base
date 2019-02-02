<?php

use Faker\Factory as Faker;

$faker = Faker::create('fa_IR');

$factory->define(App\Models\Product::class, function () use ($faker) {
    return [
        'title'     =>  $title = \faker()->sentence->first(),
        'slug'      =>  str_slug($title),
        'abstract'  =>  \faker()->paragraph->first(),
        'body'      =>  implode(PHP_EOL, \faker(4)->paragraph->toArray()),
        'attributes'=>  json_encode($faker->paragraphs()),
        'variations'=>  json_encode($faker->paragraphs()),
        'single'    =>  $faker->boolean(),
        'created_at'=>  $faker->dateTimeBetween('-5 years','+5 years'),
    ];
});
