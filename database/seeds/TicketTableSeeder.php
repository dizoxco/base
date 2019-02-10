<?php

use Illuminate\Database\Seeder;

class TicketTableSeeder extends Seeder
{
    public function run()
    {
        \App\Models\Ticket::insert(factory(\App\Models\Ticket::class, 1000)->make()->toArray());
    }
}
