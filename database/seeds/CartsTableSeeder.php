<?php

use App\Models\User;
use App\Models\Variation;
use Illuminate\Database\Seeder;

class CartsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        foreach ($users as $user) {
            $variations = Variation::inRandomOrder()
                ->select(['id as variation_id', 'quantity'])
                ->take(2)
                ->get()
                ->toArray();

            $user->cart()->createMany($variations);
        }
    }
}
