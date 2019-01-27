<?php

use Faker\Factory;
use App\Models\MediaGroup;
use Illuminate\Database\Seeder;

class MediaGroupSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('fa_IR');
        factory(MediaGroup::class, 50)->create()->each(function (MediaGroup $mediaGroup) use ($faker) {
            $mediaGroup->addMediaFromUrl(
                base_path('resources/seed/blog-images/'.rand(1, 20).'.jpg')
            )->toMediaCollection('banner');
        });
    }
}
