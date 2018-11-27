<?php

namespace App\Repositories\Facades;

use Illuminate\Support\Facades\Facade;

class UserRepo extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Repositories\UserRepository::class;
    }
}
