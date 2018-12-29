<?php

use App\Models\Tag;
use Faker\Factory as Faker;

$faker = Faker::create('fa_IR');
$factory->define(Tag::class, function () use ($faker) {
    $label = $faker->words(6, true);

    return [
        'parent_id'     =>  0,
        'taxonomy_id'   =>  null,
        'label'         =>  $label,
        'slug'          =>  str_slug($label),
        'metadata'      =>  json_encode(['metadata' =>  'something important']),
    ];
});
