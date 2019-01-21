<?php

use App\Models\Business;
use App\Models\Product;
use App\Models\User;

class BusinessesTableSeeder extends CustomSeeder
{
    public function run()
    {
        parent::execute('business');
    }

    protected function createFromConfigFile($business)
    {
        $this->create($business);
    }

    protected function createAndSaveToConfigFile()
    {
        $business   =   (int) $this->command->ask('How many business do you want?', 1);
        $owners     =   (int) $this->command->ask('Each business belongsTo at most how many owners?', 1);
        $products   =   (int) $this->command->ask('Each business have how many products?', 1);

        $this->create($business, $owners, $products);

        $config_business['business'] = [
            'amount'=> $business,
            'owners'=> $owners,
            'products'=> $products,
        ];

        $this->saveToFile($config_business);
    }

    protected function create($config): void
    {
        Business::insert(factory(Business::class, $config['amount'])->make()->toArray());

        $users = User::all();
        Business::all()->each(function ($business) use ($users, $config) {
            $business->users()->sync($users->random($config['owners']));
            $business->products()->createMany(
                factory(Product::class, random_int(0,$config['products']))->make()->toArray()
            );
        });
    }
}
