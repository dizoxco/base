<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\TaxonomyCollection;
use App\Models\Taxonomy;
use App\Http\Controllers\Controller;
use App\Repositories\Facades\TaxonomyRepo;

class TaxonomyController extends Controller
{
    public function index()
    {
        return new TaxonomyCollection(TaxonomyRepo::getAll());
    }
}
