<?php

use Illuminate\Database\Seeder;

class SearchPanelTableSeeder extends Seeder
{
    public function run()
    {

        \App\Models\SearchPanel::create([
            'title' => 'تلفن های همراه',
            'slug' => 'mobiles',
            'description' => 'lorem ipsum',
            'model' => \App\Models\Product::class,
            'options' => json_encode([
                'brands' => [
                    'label' => 'انتخاب برند',
                    'query' => 'tag',
                    'tag' => App\Models\Tag::select(['id', 'label'])
                        ->get()
                        ->toArray()
                ],
                'colors' => [
                    'label' => 'انتخاب رنگ',
                    'query' => 'tag',
                    'tag' => App\Models\Tag::select(['id', 'label'])
                        ->whereIn('slug', ['red', 'blue'])
                        ->get()
                        ->toArray()
                ]
            ]),
            'filters' => json_encode([
                'forms' => [
                    'label' => 'انتخاب برند',
                    'query' => 'tag',
                    'tag' => App\Models\Tag::select(['id', 'label'])
                        ->whereSlug('mobiles')
                        ->get()
                        ->toArray()
                ]
            ]),
        ]);




        \App\Models\SearchPanel::create([
            'title' => 'تلفن های همراه',
            'slug' => 'laptop',
            'description' => 'lorem ipsum',
            'model' => \App\Models\Product::class,
            'options' => json_encode([
                'brands' => [
                    'label' => 'انتخاب برند',
                    'query' => 'tag',
                    'tag' => App\Models\Tag::select(['id', 'label'])
                        ->get()
                        ->toArray()
                ],
                'colors' => [
                    'label' => 'انتخاب رنگ',
                    'query' => 'tag',
                    'tag' => App\Models\Tag::select(['id', 'label'])
                        ->whereIn('slug', ['red', 'blue'])
                        ->get()
                        ->toArray()
                ]
            ]),
            'filters' => json_encode([
                'forms' => [
                    'label' => 'انتخاب برند',
                    'query' => 'tag',
                    'tag' => App\Models\Tag::select(['id', 'label'])
                        ->whereSlug('laptops')
                        ->get()
                        ->toArray()
                ]
            ]),
        ]);
    }
}
