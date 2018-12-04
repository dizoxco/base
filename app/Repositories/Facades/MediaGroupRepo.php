<?php

namespace App\Repositories\Facades;

use App\Repositories\MediaGroupRepository;
use Illuminate\Support\Facades\Facade;

class MediaGroupRepo extends Facade
{
    protected static function getFacadeAccessor()
    {
        return MediaGroupRepository::class;
    }
}