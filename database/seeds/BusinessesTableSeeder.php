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

        $users = User::all();
        $businesses = Business::all();
        $faker = Faker\Factory::create();
        $mobile_tag = Taxonomy::find(3)->first()->id;

        foreach ($businesses as $business) {
            $business->users()->attach($users->random(3));

            $products = $business->products()->createMany(
                factory(Product::class, random_int(0, 10))->make()->toArray()
            );

            foreach ($products as $product) {
                $product->tags()->sync(Tag::inRandomOrder()->take(3)->pluck('id')->toArray());

                // by 50% chance of getting true the product will be a mobile
                if ($faker->boolean()) {
                    $product->tags()->sync($mobile_tag, false);
                }
            }
        }
    }
}
