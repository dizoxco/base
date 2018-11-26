<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    protected $seeds = [
        'migrate',
        'users'
    ];

    public function run()
    {
        foreach ($this->seeds as $seed) {
            $this->command->line("Processing: {$seed}");
            call_user_func([$this, $seed]);
        }
    }

    public function migrate()
    {
        $this->command->call('migrate:reset');
        $this->command->call('migrate');
        $this->command->line('Migrated tables.');
        $this->command->call('passport:install');
    }

    public function users()
    {
        $this->users = factory(\App\Models\User::class, 10)->create();
    }

}
