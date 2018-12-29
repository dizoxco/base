<?php

namespace App\Repositories\Facades;

use Illuminate\Support\Facades\Facade;
use App\Repositories\SearchPanelRepository;

class SPRepo extends Facade
{
    protected static function getFacadeAccessor()
    {
        return SearchPanelRepository::class;
    }
}
