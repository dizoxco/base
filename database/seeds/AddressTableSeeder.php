<?php

use App\Models\User;
use App\Models\Address;
use Illuminate\Database\Seeder;

class AddressTableSeeder extends Seeder
{
    public function run()
    {
        $addresses = factory(Address::class, 1000)->make()->toArray();
        $users = User::inRandomOrder()->pluck('id')->toArray();
        foreach ($addresses as $index => $address) {
            $addresses[$index]['user_id'] = array_shift($users);
        }
        Address::insert($addresses);
    }
}
