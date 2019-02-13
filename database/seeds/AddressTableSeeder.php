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
        array_walk($addresses, function (&$address) use ($users) {
            $address['user_id'] = array_shift($users);
        });
        $addresses = array_chunk($addresses, 400);
        foreach ($addresses as $address) {
            Address::insert($address);
        }
    }
}
