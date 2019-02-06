<?php

use App\Models\Tag;
use App\Models\User;
use App\Models\Product;
use App\Models\Business;
use App\Models\MediaGroup;
use App\Models\Variation;
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

        foreach ($businesses as $business) {
            $business->users()->attach($users->random(3));
            $business->addMediaFromUrl(
                resource_path('seed/logo-images/'.rand(1, 20).'.png')
            )->toMediaCollection(enum('media.business.logo'));

            $products = $business->products()->createMany(
                factory(Product::class, random_int(0, 10))->make()->toArray()
            );

            foreach ($products as $product) {
                $product->tags()->sync(Tag::inRandomOrder()->take(3)->pluck('id')->toArray());

                $product->addMediaFromUrl(resource_path('seed/product-images/'.rand(1, 20).'.jpg'))
                    ->toMediaCollection(enum('media.product.banner'));

                $variations = $product->variations()->createMany(factory(Variation::class, 10)->make(
                    [
                        'business_id' => $business->id,
                        'product_id' => $product->id,
                    ]
                )->toArray());

                $product->update([
                    'variations' => $variations->pluck('id')->toJson()
                ]);

                foreach (range(1, 3) as $item) {
                    $product->addMediaFromUrl(resource_path('seed/product-images/'.rand(1, 20).'.jpg'))
                        ->toMediaCollection(enum('media.product.gallery'));
                }
                if ($faker->boolean()) {
                    $product->tags()->sync($mobile_tag, false);
                    $product->users()->sync($users->random(10)->pluck('id')->toArray(), false);
                }
            }
        }
    }
}
