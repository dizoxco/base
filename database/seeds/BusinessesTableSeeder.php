<?php

use App\Models\Business;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class BusinessesTableSeeder extends Seeder
{
    public function run()
    {
        Business::insert(factory(Business::class, 10)->make()->toArray());

        $users = User::all();
        Business::all()->each(function ($business) use ($users) {
            $business->users()->sync($users->random(3));
            $business->products()->createMany(
                factory(Product::class, random_int(0, 10))->make()->toArray()
            );
        });
    }
}
