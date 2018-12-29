<?php

namespace App\Repositories\Facades;

use Illuminate\Support\Facades\Facade;
use App\Repositories\MediaGroupRepository;

class MediaGroupRepo extends Facade
{
    protected static function getFacadeAccessor()
    {
        return MediaGroupRepository::class;
    }
}
