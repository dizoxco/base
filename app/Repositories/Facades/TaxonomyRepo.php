<?php

namespace App\Repositories\Facades;

use Illuminate\Support\Facades\Facade;
use App\Repositories\TaxonomyRepository;

class TaxonomyRepo extends Facade
{
    protected static function getFacadeAccessor()
    {
        return TaxonomyRepository::class;
    }
}