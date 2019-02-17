<?php

use Faker\Factory as Faker;

$faker = Faker::create('fa_IR');

$factory->define(App\Models\Product::class, function () use ($faker) {

    $options = array_random([
        'color' => [
            'label' => 'رنگ',
            'type' => 'color',
            'values' => array_random([
                'red' => ['label' => 'قرمز', 'color' => '#e5e5e5'],
                'pink' => ['label' => 'صورتی', 'color' => '#dddddd'],
                'black' => ['label' => 'مشکی', 'color' => '#555555'],
                'yellow' => ['label' => 'زرد', 'color' => '#aaaaaa']
            ], rand(1, 4)),
        ],
        'size' => [
            'label' => 'سایز',
            'type' => 'check',
            'values' => array_random([
                's' => ['label' => 's'],
                'm' => ['label' => 'm'],
                'l' => ['label' => 'l'],
                'xl' => ['label' => 'xl']
            ], rand(1, 4)),
        ],
        'capacity' => [
            'label' => 'ظرفیت',
            'type' => 'select',
            'values' => array_random([
                '8' => ['label' => '8 GB'],
                '16' => ['label' => '16 GB'],
                '32' => ['label' => '32 GB'],
                '64' => ['label' => '64 GB']
            ],rand(1, 4)),
        ]
    ], rand(1, 3));

    return [
        'title'     =>  $title = \faker('sentence')->first(),
        'slug'      =>  str_slug($title),
        'abstract'  =>  \faker('paragraph')->first(),
        'body'      =>  implode(PHP_EOL, \faker('paragraph', 4)->toArray()),
        'attributes'=>  json_encode($faker->paragraphs()),
        'options'   =>  json_encode($options),
        'single'    =>  $faker->boolean(),
        'price'     =>  rand(10000, 10000000),
        'created_at'=>  $faker->dateTimeBetween('-5 years', 'now'),
    ];
});
