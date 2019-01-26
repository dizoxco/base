<?php

use App\Models\MediaGroup;
use Faker\Generator as Faker;

$factory->define(MediaGroup::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'collection_name' => 'media_group_'.$faker->word,
        'description' => $faker->paragraph,
    ];
});
