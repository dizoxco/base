<?php

namespace App\Repositories\Facades;

use App\Repositories\TicketRepository;
use Illuminate\Support\Facades\Facade;

class TicketRepo extends Facade
{
    protected static function getFacadeAccessor()
    {
        return TicketRepository::class;
    }
}
