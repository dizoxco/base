<?php

namespace App\Repositories\Facades;

use Illuminate\Support\Facades\Facade;
use App\Repositories\BusinessRepository;

class BusinessRepo extends Facade
{
    protected static function getFacadeAccessor()
    {
        return BusinessRepository::class;
    }
}
