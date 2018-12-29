<?php

use App\Models\Post;
use Faker\Factory as Faker;

$faker = Faker::create('fa_IR');
$factory->define(Post::class, function () use ($faker) {
    return [
        'title'     =>  $faker->sentence,
        'slug'      =>  $faker->slug,
        'abstract'  =>  $faker->sentence,
        'body'      =>  $faker->paragraphs(4, true),
    ];
});
