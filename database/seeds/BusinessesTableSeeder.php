<?php

use App\Models\Tag;
use App\Models\User;
use App\Models\Product;
use App\Models\Business;
use App\Models\MediaGroup;
use Illuminate\Database\Seeder;

class BusinessesTableSeeder extends Seeder
{
    public function run()
    {
        Business::insert(factory(Business::class, 30)->make()->toArray());

        $users = User::all();
        $businesses = Business::all();
        $faker = Faker\Factory::create();
        $mobile_tag = Tag::whereSlug('mobiles')->first()->id;
        $banners = MediaGroup::find(1)->media;
        // $logos = MediaGroup::find(2)->media;
        $tags = Tag::all();

        foreach ($businesses as $business) {
            $business->users()->attach($users->random(3));
            // $business->logo()->sync([$logos->random()->id => ['collection_name' => enum('media.business.logo')]]);
            
            $business->addMediaFromUrl(base_path('resources/seed/logo-images/'.rand(1, 20).'.png'))->toMediaCollection('business-logo');

            $products = $business->products()->createMany(
                factory(Product::class, random_int(0, 10))->make()->toArray()
            );

            foreach ($products as $product) {
                $product->tags()->sync($tags->random(3)->pluck('id')->toArray());
                // $product->banner()->sync([$banners->random()->id => ['collection_name' => enum('media.product.banner')]]);
                $product->addMediaFromUrl(base_path('resources/seed/product-images/'.rand(1, 20).'.jpg'))->toMediaCollection('product-banner');
                // if ($faker->boolean()) {
                //     $product->tags()->sync($mobile_tag, false);
                // }
            }
        }
    }
}
