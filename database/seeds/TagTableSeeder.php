<?php

use App\Models\Taxonomy;
use Illuminate\Database\Seeder;

class TagTableSeeder extends Seeder
{
    public function run()
    {
        $taxonomies = [
            [
                'name' => 'post',
                'slug' => 'post_cat',
                'label' => 'دسته بندی محتوا',
                'tags' => [
                    ['label' => 'مقاله', 'slug' => 'article'],
                    ['label' => 'خبر', 'slug' => 'news'],
                    ['label' => 'مد', 'slug' => 'mod'],
                ],
            ],
            [
                'name' => 'post',
                'slug' => 'post_tag',
                'label' => 'تگ های محتوا',
                'tags' => [
                    ['label' => 'ورساچه', 'slug' => 'versace'],
                    ['label' => 'خیاطی', 'slug' => 'kh'],
                    ['label' => 'طراحی', 'slug' => 'design'],
                ],
            ],
            [
                'name' => 'company',
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
                'name' => 'company',
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
                'name' => 'company',
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
                'name' => 'product',
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
                'name' => 'product',
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
                'name' => 'product',
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
