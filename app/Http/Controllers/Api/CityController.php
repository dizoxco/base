<?php

namespace App\Http\Controllers\Api;

use App\Models\City;
use App\Http\Controllers\Controller;
use App\Http\Resources\CityCollection;

class CityController extends Controller
{
    public function __invoke()
    {
        return new CityCollection(City::with('county', 'province')->get());
    }
}
