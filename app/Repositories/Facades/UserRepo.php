<?php

namespace App\Repositories\Facades;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Facade;

class UserRepo extends Facade
{
    protected static function getFacadeAccessor()
    {
        return UserRepository::class;
    }
}
