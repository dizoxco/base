<?php

namespace App\Repositories\Facades;

use Illuminate\Support\Facades\Facade;
use App\Repositories\VariationRepository;

class VariationRepo extends Facade
{
    protected static function getFacadeAccessor()
    {
        return VariationRepository::class;
    }
}
