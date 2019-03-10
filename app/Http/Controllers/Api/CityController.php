<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CityCollection;
use App\Models\City;

class CityController extends Controller
{
    public function __invoke()
    {
        return new CityCollection(City::with('county', 'province')->get());
    }
}
