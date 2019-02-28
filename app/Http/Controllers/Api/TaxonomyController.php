<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaxonomyCollection;
use App\Repositories\Facades\TaxonomyRepo;

class TaxonomyController extends Controller
{
    public function index()
    {
        return new TaxonomyCollection(TaxonomyRepo::getAll([
            'with' => ['tags']
        ]));
    }
}
