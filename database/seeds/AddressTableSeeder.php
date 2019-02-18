<?php

use App\Models\Address;
use Illuminate\Database\Seeder;

class AddressTableSeeder extends Seeder
{
    public function run()
    {
        $addresses = factory(Address::class, 1000)->make()->toArray();
        $addresses = array_chunk($addresses, 500);
        foreach ($addresses as $address) {
            Address::insert($address);
        }
    }
}
