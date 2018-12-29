<?php

namespace App\Repositories\Facades;

use App\Repositories\SearchPanelRepository;
use Illuminate\Support\Facades\Facade;

class SPRepo extends Facade
{
    protected static function getFacadeAccessor()
    {
        return SearchPanelRepository::class;
    }
}

