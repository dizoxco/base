<?php

use App\Models\Tag;
use App\Models\User;
use App\Models\Product;
use App\Models\Business;
use App\Models\Taxonomy;
use App\Models\Variation;
use Illuminate\Database\Seeder;

class BusinessesTableSeeder extends Seeder
{
    public function run()
    {
        Business::insert(factory(Business::class, 100)->make()->toArray());

        $users = User::all();
        $businesses = Business::all();
        $faker = Faker\Factory::create();
        $mobile_tag = Tag::whereSlug('mobiles')->first()->id;
        $business_types = Taxonomy::whereSlug('types')->first()->tags->pluck('id')->toArray();
        $business_fields = Taxonomy::whereSlug('fields')->first()->tags->pluck('id')->toArray();
        $business_contracts = Taxonomy::whereSlug('contracts')->first()->tags->pluck('id')->toArray();

        foreach ($businesses as $business) {
            // Give business tags in type and fields and contract
            $tags = [
                $business_types[array_rand($business_types)],
                $business_fields[array_rand($business_fields)],
                $business_contracts[array_rand($business_contracts)],
            ];
            /* @var Business $business */
            $business->tags()->sync($tags);

            // Introduces multiple users as business owners.
            $business->users()->attach($users->random(3));

            // A logo is dedicated to the business.
            $business->addMediaFromUrl(
                resource_path('seed/logo-images/'.rand(1, 20).'.png')
            )->toMediaCollection(enum('media.business.logo'));

            // Between 0 to 10 random items are assigned to the business.
            $products = $business->products()->createMany(
                factory(Product::class, random_int(0, 10))->make()->toArray()
            );

            foreach ($products as $product) {
                // Assign random tags to each product
                $product->tags()->sync(Tag::inRandomOrder()->take(3)->pluck('id')->toArray());

                // Assigns an image as index to the product.
                $product->addMediaFromUrl(
                    resource_path('seed/product-images/'.rand(1, 20).'.jpg')
                )->toMediaCollection(enum('media.product.banner'));

                // Make several different types of that product.
                $variations = $product->relatedVariations()->createMany(factory(Variation::class, 10)->make(
                    [
                        'business_id' => $business->id,
                        'product_id' => $product->id,
                    ]
                )->toArray());

                // and save that
                $product->update([
                    'variations' => $variations->pluck('id')->toJson(),
                ]);

                // Assigns multiple image as gallery to the product.
                foreach (range(1, 3) as $item) {
                    $product->addMediaFromUrl(
                        resource_path('seed/product-images/'.rand(1, 20).'.jpg')
                    )->toMediaCollection(enum('media.product.gallery'));
                }

                if ($faker->boolean()) {
                    // By chance of 50% product get the mobile tag
                    $product->tags()->sync($mobile_tag, false);
                    // By chance of 50% product give users that like it and added to their wish lists
                    $product->users()->sync($users->random(10)->pluck('id')->toArray(), false);
                }
            }
        }
    }
}
