<?php

use App\Models\SearchPanel;
use Faker\Factory as Faker;

$faker = Faker::create('fa_IR');
$factory->define(SearchPanel::class, function () use ($faker) {
    return [
        'title'     =>  $title = \faker('sentence')->first(),
        'slug'      =>  str_slug($title),
        'description'   =>  $faker->sentences(3, true),
        'model'         =>  null,
        'options'       =>  null,
        'filters'       =>  null,
    ];
});
