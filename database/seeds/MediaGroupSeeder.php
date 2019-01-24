<?php

use App\Models\MediaGroup;
use Faker\Factory;
use Illuminate\Database\Seeder;

class MediaGroupSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('fa_IR');
        factory(MediaGroup::class, 50)->create()->each(function (MediaGroup $mediaGroup) use ($faker) {
            $mediaGroup->addMediaFromUrl(
                $faker->image(storage_path('app/tmp'))
            )->toMediaCollection('banner');
        });
    }
}
