<?php

use Faker\Factory;
use App\Models\MediaGroup;
use Illuminate\Database\Seeder;

class MediaGroupSeeder extends Seeder
{
    public function run()
    {
        $mgp = MediaGroup::create(['name' => 'posts', 'collection_name' => 'posts', 'description' => 'posts']);
        foreach (range(1, 20) as $key) {
            $mgp->addMediaFromUrl(resource_path('seed/blog-images/'.$key.'.jpg'))->toMediaCollection($mgp->name);
        }

        $logos = Storage::disk('local')->files('logos');
        $mgp = MediaGroup::create(['name' => 'logos', 'collection_name' => 'logos', 'description' => 'logos']);
        foreach (range(1, 20) as $key) {
            $mgp->addMediaFromUrl(storage_path('app/'.array_random($logos)))->toMediaCollection('logos');
        }
    }
}
