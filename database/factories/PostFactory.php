<?php

use App\Models\Post;
use Faker\Factory as Faker;

$faker = Faker::create('fa_IR');
$factory->define(Post::class, function () use ($faker) {
    return [
        'title'     =>  $title = omidFaker(),
        'slug'      =>  str_slug($title.str_random()),
        'abstract'  =>  \faker('paragraph')->first(),
        'body'      =>  implode(PHP_EOL, \faker('paragraph', 4)->toArray()),
    ];
});
