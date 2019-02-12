<?php

use Illuminate\Database\Seeder;

class TicketTableSeeder extends Seeder
{
    public function run()
    {
        $tickets = array_chunk(factory(\App\Models\Ticket::class, 1000)->make()->toArray(), 400);
        foreach ($tickets as $ticket) {
            \App\Models\Ticket::insert($ticket);
        }
    }
}
