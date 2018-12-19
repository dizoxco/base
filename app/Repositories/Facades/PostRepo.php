<?php

namespace App\Repositories\Facades;

use App\Repositories\PostRepository;
use Illuminate\Support\Facades\Facade;

class PostRepo extends Facade
{
    protected static function getFacadeAccessor()
    {
        return PostRepository::class;
    }
}
