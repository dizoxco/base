<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Post::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'user_id' => rand(1, 10),
        'slug' => $faker->slug,
        'body' => $faker->paragraphs(4,true),
        'abstract' => $faker->sentences(4 , true),
        'published_at' =>Carbon\Carbon::now()
    ];
});
