<?php

namespace App\Http\Controllers\Api;

use App\Repositories\Facades\TaxonomyRepo;
use App\Http\Controllers\Controller;

class TaxonomyController extends Controller
{
    public function index()
    {
        return TaxonomyRepo::getAll();
    }
}
