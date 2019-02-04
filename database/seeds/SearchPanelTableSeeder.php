<?php

use App\Models\Tag;
use App\Models\Product;
use App\Models\Taxonomy;
use App\Models\SearchPanel;
use Illuminate\Database\Seeder;

class SearchPanelTableSeeder extends Seeder
{
    public function run()
    {
        SearchPanel::create([
            'title' => 'تلفن های همراه',
            'slug' => 'mobiles',
            'description' => 'lorem ipsum',
            'model' => Product::class,
            'options' => [
                'order' => [
                    'label' => 'مرتب سازی',
                    'query' => 'order',
                    'order' => [
                        ['label' => 'برحسب عنوان', 'column' => 'title', 'dir' => 'asc'],
                        ['label' => 'جدیدترین', 'column' => 'created_at', 'dir' => 'desc'],
                        ['label' => 'قدیمی ترین', 'column' => 'created_at', 'dir' => 'asc'],
                        ['label' => 'ارزانترین', 'column' => 'price', 'dir' => 'asc'],
                        ['label' => 'گرانترین', 'column' => 'price', 'dir' => 'desc'],
                    ],
                ],
                'name' => [
                    'label' => 'جستجو در عنوان کالا یا نام برند',
                    'query' => 'like',
                    'like' => 'title,',
                ],
                'brands' => [
                    'label' => 'انتخاب برند',
                    'query' => 'tag',
                    'tag' => Taxonomy::whereSlug('brands')
                        ->first()
                        ->tags()
                        ->select(['id', 'label'])
                        ->get()
                        ->toArray(),
                ],
                'colors' => [
                    'label' => 'انتخاب رنگ',
                    'query' => 'tag',
                    'tag' => Taxonomy::whereSlug('colors')
                        ->first()
                        ->tags()
                        ->select(['id', 'label'])
                        ->get()
                        ->toArray(),
                ],
            ],
            'filters' => [
                'forms' => [
                    'label' => 'انتخاب نوع کالا',
                    'query' => 'tag',
                    'tag' => Tag::select(['id', 'label'])
                        ->whereSlug('mobiles')
                        ->get()
                        ->toArray(),
                ],
            ],
        ]);

        SearchPanel::create([
            'title' => 'تلفن های همراه',
            'slug' => 'laptops',
            'description' => 'lorem ipsum',
            'model' => Product::class,
            'options' => [
                'brands' => [
                    'label' => 'انتخاب برند',
                    'query' => 'tag',
                    'tag' => Taxonomy::whereSlug('brands')
                        ->first()
                        ->tags()
                        ->select(['id', 'label'])
                        ->get()
                        ->toArray(),
                ],
                'colors' => [
                    'label' => 'انتخاب رنگ',
                    'query' => 'tag',
                    'tag' => Taxonomy::whereSlug('colors')
                        ->first()
                        ->tags()
                        ->select(['id', 'label'])
                        ->get()
                        ->toArray(),
                ],
            ],
            'filters' => [
                'forms' => [
                    'label' => 'انتخاب نوع کالا',
                    'query' => 'tag',
                    'tag' => Tag::select(['id', 'label'])
                        ->whereSlug('laptops')
                        ->get()
                        ->toArray(),
                ],
            ],
        ]);
    }
}
