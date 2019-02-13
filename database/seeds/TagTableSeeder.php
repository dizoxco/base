<?php

use App\Models\Taxonomy;
use Illuminate\Database\Seeder;

class TagTableSeeder extends Seeder
{
    public function run()
    {
        $taxonomies = [
            [
                'name' => 'types',
                'slug' => 'types',
                'label' => 'نوع شرکت',
                'tags' => [
                    ['label' => 'شرکت', 'slug' => 'company'],
                    ['label' => 'موسسه', 'slug' => 'institute'],
                    ['label' => 'سازمان', 'slug' => 'organization'],
                    ['label' => 'بنیاد', 'slug' => 'foundation'],
                ],
            ],
            [
                'name' => 'fields',
                'slug' => 'fields',
                'label' => 'زمینه کاری',
                'tags' => [
                    ['label' => 'استخراج و اکتشاف', 'slug' => 'exploration'],
                    ['label' => 'توسعه معادن', 'slug' => 'mines'],
                    ['label' => 'راه و ساختمان', 'slug' => 'building'],
                    ['label' => 'فناوری اطلاعات', 'slug' => 'it'],
                    ['label' => 'فولاد', 'slug' => 'steel'],
                    ['label' => 'تولیدی', 'slug' => 'productive'],
                    ['label' => 'تجهیزات اداری', 'slug' => 'office_equipment'],
                    ['label' => 'کاریابی', 'slug' => 'placement'],
                    ['label' => 'نساجی', 'slug' => 'loom'],
                    ['label' => 'سرمایه گذاری', 'slug' => 'investment'],
                ],
            ],
            [
                'name' => 'contracts',
                'slug' => 'contracts',
                'label' => 'نوع قرارداد',
                'tags' => [
                    ['label' => 'رسمی', 'slug' => 'official'],
                    ['label' => 'پیمانی', 'slug' => 'contractual'],
                    ['label' => 'تمام وقت', 'slug' => 'fulltime'],
                    ['label' => 'پاره وقت', 'slug' => 'part_time'],
                    ['label' => 'پروژه ای', 'slug' => 'project'],
                    ['label' => 'ساعتی', 'slug' => 'hourly'],
                ],
            ],
            [
                'name' => 'brands',
                'slug' => 'brands',
                'label' => 'برند',
                'tags' => [
                    ['label' => 'هرمس', 'slug' => 'hermess'],
                    ['label' => 'پرادا', 'slug' => 'prada'],
                    ['label' => 'رولکس', 'slug' => 'rolex'],
                    ['label' => 'راللف لورن پولو', 'slug' => 'polo'],
                    ['label' => 'آدیداس', 'slug' => 'adidas'],
                    ['label' => 'نایک', 'slug' => 'nike'],
                    ['label' => 'زارا', 'slug' => 'zara'],
                    ['label' => 'هوگو باس', 'slug' => 'hugo_boss'],
                    ['label' => 'لوییس ویتون', 'slug' => 'lv'],
                    ['label' => 'شنل', 'slug' => 'channel'],
                    ['label' => 'دیزل', 'slug' => 'diesel'],
                ],
            ],
            [
                'name' => 'colors',
                'slug' => 'colors',
                'label' => 'رنگ',
                'tags' => [
                    ['label' => 'قرمز', 'slug' => 'red'],
                    ['label' => 'آبی', 'slug' => 'blue'],
                    ['label' => 'صورتی', 'slug' => 'pink'],
                    ['label' => 'زرد', 'slug' => 'yellow'],
                ],
            ],
            [
                'name' => 'Form Factor',
                'slug' => 'forms',
                'label' => 'انواع',
                'tags' => [
                    ['label' => 'mobile', 'slug' => 'mobiles'],
                    ['label' => 'laptop', 'slug' => 'laptops'],
                ],
            ],
        ];

        foreach ($taxonomies as $taxonomy) {
            Taxonomy::create([
                'group_name' => $taxonomy['name'],
                'slug' => $taxonomy['slug'],
                'label' => $taxonomy['label'],
            ])->tags()->createMany($taxonomy['tags']);
        }
    }
}
