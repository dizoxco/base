<?php

namespace App\Repositories\Facades;

use Illuminate\Support\Facades\Facade;

class PostRepo extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Repositories\PostRepository::class;
    }
}
