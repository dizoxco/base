<?php

namespace App\Repositories\Facades;

use Illuminate\Support\Facades\Facade;
use App\Repositories\ProductRepository;

class ProductRepo extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ProductRepository::class;
    }
}
