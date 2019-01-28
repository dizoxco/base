<?php

use Faker\Factory;
use App\Models\MediaGroup;
use Illuminate\Database\Seeder;

class MediaGroupSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('fa_IR');
        $mgp = MediaGroup::create(['name' => 'posts', 'collection_name' => 'posts', 'description' => '']);
        foreach (range(1,20) as $key) {
            $mgp->addMediaFromUrl(
                base_path('resources/seed/blog-images/'.$key.'.jpg')
            )->toMediaCollection($mgp->name);
        }

        // factory(MediaGroup::class, 1)->create(['name' => 'posts', 'collection_name' => 'posts'])->each(function (MediaGroup $mediaGroup) use ($faker) {
            
        // });
    }
}
