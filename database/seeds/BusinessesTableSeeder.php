<?php

use App\Models\Tag;
use App\Models\User;
use App\Models\Product;
use App\Models\Business;
use App\Models\Taxonomy;
use Illuminate\Database\Seeder;

class BusinessesTableSeeder extends Seeder
{
    public function run()
    {
        Business::insert(factory(Business::class, 100)->make()->toArray());
        Product::insert(factory(Product::class, 100)->make()->toArray());
        Product::insert(factory(Product::class, 100)->make()->toArray());
        Product::insert(factory(Product::class, 100)->make()->toArray());

        $users = User::all();
        $businesses = Business::all();
        $products = Product::all();

        $faker = Faker\Factory::create();
        // $mobile_tag = Tag::whereSlug('mobiles')->first()->id;
        $business_types = Taxonomy::whereSlug('types')->first()->tags;
        $business_fields = Taxonomy::whereSlug('fields')->first()->tags;
        $business_contracts = Taxonomy::whereSlug('contracts')->first()->tags;
        $taggables = [];
        $business_users = [];
        /** @deprecated No longer used by internal code and not recommended. */
        $businesses_products = [];
        foreach ($businesses as $business) {
            // Give business tags in type and fields and contract
            $taggables[] = [
                'tag_id' => $business_types->random()->id,
                'taggable_id' => $business->id,
                'taggable_type' => 'App\Models\Business',
            ];
            $taggables[] = [
                'tag_id' => $business_fields->random()->id,
                'taggable_id' => $business->id,
                'taggable_type' => 'App\Models\Business',
            ];
            $taggables[] = [
                'tag_id' => $business_contracts->random()->id,
                'taggable_id' => $business->id,
                'taggable_type' => 'App\Models\Business',
            ];

            // Introduces multiple users as business owners.
            foreach ($users->random(rand(1, 4)) as $user) {
                $business_users[] = [
                    'business_id' => $business->id,
                    'user_id' => $user->id,
                ];
            }

            // assign products to business
            foreach ($products->random(rand(1, 5)) as $product) {
                /* @deprecated No longer used by internal code and not recommended. */
                $businesses_products[] = [
                    'business_id' => $business->id,
                    'product_id' => $product->id,
                ];
            }

            // A logo is dedicated to the business.
            $business->addMediaFromUrl(resource_path('seed/logo-images/'.rand(1, 68).'.png'))->toMediaCollection(enum('media.business.logo'));
        }
        DB::table('businesses_users')->insert($business_users);

        /* @deprecated No longer used by internal code and not recommended. */
        DB::table('businesses_products')->insert($businesses_products);

        $product_tags = Tag::WhereIn(
            'taxonomy_id',
            Taxonomy::whereIn('slug', ['brands', 'colors', 'forms'])->pluck('id')->toArray()
        )->get();
        $wishlists = [];
        $variations = [];
        $carts = [];
        foreach ($products as $product) {
            // Assign random tags to each product
            foreach ($product_tags->random(6) as $tag) {
                $taggables[] = [
                    'tag_id' => $tag->id,
                    'taggable_id' => $product->id,
                    'taggable_type' => 'App\Models\Product',
                ];
            }

            // Assigns an image as index to the product.
            $product->addMediaFromUrl(resource_path('seed/product-images/'.rand(1, 20).'.jpg'))->toMediaCollection(enum('media.product.banner'));

            // Assigns multiple image as gallery to the product.
            foreach (range(1, 3) as $item) {
                $product->addMediaFromUrl(
                    resource_path('seed/product-images/'.rand(1, 20).'.jpg')
                )->toMediaCollection(enum('media.product.gallery'));
            }

            $wishlists[] = [
                'user_id' => rand(1, 1000),
                'product_id' => $product->id,
            ];

            for ($i = 0; $i < rand(3, 7); $i++) {
                $options = [];
                foreach ($product->options as $option) {
                    $options[$option['name']] = $option['values'][array_rand($option['values'])]['value'];
                }
                $variations[] = [
                    'business_id' => rand(1, 100),
                    'product_id' => $product->id,
                    'price' => rand(10000, 1000000),
                    'quantity' => rand(1, 10),
                    'options' => json_encode($options),
                ];

                if (rand(0, 1)) {
                    $carts[] = [
                        'variation_id' => count($variations),
                        'user_id' => rand(1, 1000),
                        'quantity' => rand(1, 3),
                    ];
                }
            }
        }
        DB::table('taggables')->insert($taggables);
        DB::table('variations')->insert($variations);
        DB::table('carts')->insert($carts);
        DB::table('wishlists')->insert($wishlists);
    }
}
