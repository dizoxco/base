<?php

namespace App\Repositories\Facades;

use App\Repositories\ChatRepository;
use Illuminate\Support\Facades\Facade;

class ChatRepo extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ChatRepository::class;
    }
}
