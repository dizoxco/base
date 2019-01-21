<?php

use App\Models\Address;
use App\Models\User;

class AddressTableSeeder extends CustomSeeder
{
    public function run()
    {
        parent::execute('address');
    }

    protected function createFromConfigFile($address)
    {
        $this->create($address['amount']);
    }

    protected function createAndSaveToConfigFile()
    {
        $amount = (int) $this->command->ask('How many address do you want? ',1);

        $this->create($amount);

        $this->saveToFile(['address' => ['amount' => $amount]]);
    }

    protected function create($amount)
    {
        $users = User::all();
        while ($amount) {
            $address[] = factory(Address::class)->make([
                'user_id' => $users->random()->id
            ])->toArray();
            $amount--;
        }
        Address::insert($address);
    }
}
