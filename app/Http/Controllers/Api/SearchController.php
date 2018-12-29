<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Facades\SPRepo;

class SearchController extends Controller
{
    public function show(Request $request, $search_panel)
    {
        $search_panel = SPRepo::findBySlug($search_panel);

        return $search_panel->result($request);
    }
}
