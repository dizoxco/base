<?php

use App\Models\SearchPanel;
use Faker\Factory as Faker;

$faker = Faker::create('fa_IR');
$factory->define(SearchPanel::class, function () use ($faker) {
    $title = $faker->words(3, true);

    return [
        'title'     =>  omidFaker(),
        'slug'      =>  str_slug($title),
        'description'   =>  $faker->sentences(3, true),
        'model'         =>  null,
        'options'       =>  null,
        'filters'       =>  null,
    ];
});
