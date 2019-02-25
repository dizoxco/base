<?php

use Faker\Factory as Faker;

$faker = Faker::create('fa_IR');

$factory->define(App\Models\Product::class, function () use ($faker) {
    $options = array_filter([
        [
            'name' => 'color',
            'label' => 'رنگ',
            'type' => 'color',
            'values' => array_filter([
                ['value' => 'red', 'label' => 'قرمز', 'color' => '#ff5c44'],
                ['value' => 'pink', 'label' => 'صورتی', 'color' => '#ff95aa'],
                ['value' => 'black', 'label' => 'مشکی', 'color' => '#000'],
                ['value' => 'yellow', 'label' => 'زرد', 'color' => '#f9d42b'],
            ], function () {
                return rand(0, 1);
            }),
        ],
        [
            'name' => 'size',
            'label' => 'سایز',
            'type' => 'check',
            'values' => array_filter([
                ['value' => 's', 'label' => 's'],
                ['value' => 'm', 'label' => 'm'],
                ['value' => 'l', 'label' => 'l'],
                ['value' => 'xl', 'label' => 'xl'],
            ], function () {
                return rand(0, 1);
            }),
        ],
        [
            'name' => 'capacity',
            'label' => 'ظرفیت',
            'type' => 'select',
            'values' => array_filter([
                ['value' => '8', 'label' => '8 GB'],
                ['value' => '16', 'label' => '16 GB'],
                ['value' => '32', 'label' => '32 GB'],
                ['value' => '64', 'label' => '64 GB'],
            ], function () {
                return rand(0, 1);
            }),
        ],
    ], function ($option) {
        return count($option['values']) ? rand(0, 1) : false;
    });

    return [
        'title'     =>  $title = \faker('word', 15)->implode(' '),
        'slug'      =>  str_slug($title).rand(1000, 9999),
        'abstract'  =>  \faker('paragraph')->first(),
        'body'      =>  implode(PHP_EOL, \faker('paragraph', 4)->toArray()),
        'attributes'=>  json_encode($faker->paragraphs()),
        'options'   =>  json_encode($options),
        'single'    =>  $faker->boolean(),
        'price'     =>  rand(10000, 10000000),
        'created_at'=>  $faker->dateTimeBetween('-5 years', 'now'),
    ];
});
