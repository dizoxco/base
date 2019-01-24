<?php

use Illuminate\Database\Seeder;

class PassportTableSeeder extends Seeder
{
    public function run()
    {
        $this->command->call('passport:install', ['--force' => true]);
    }
}
