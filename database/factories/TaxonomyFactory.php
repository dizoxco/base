<?php

use App\Models\Taxonomy;
use Faker\Factory as Faker;

$faker = Faker::create('fa_IR');
$factory->define(Taxonomy::class, function () use ($faker) {
    $label = $faker->words(3, true);

    return [
        'label' =>  $label,
        'slug'  =>  str_slug($label),
    ];
});
