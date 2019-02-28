<?php

namespace App\Repositories\Facades;

use App\Repositories\TagRepository;
use Illuminate\Support\Facades\Facade;

class TagRepo extends Facade
{
    protected static function getFacadeAccessor()
    {
        return TagRepository::class;
    }
}