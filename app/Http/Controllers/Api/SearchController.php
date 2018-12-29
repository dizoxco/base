<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SearchPanel;
use App\Repositories\Facades\SPRepo;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function show(Request $request,$search_panel)
    {
        $search_panel   =   SPRepo::findBySlug($search_panel);
        return $search_panel->result($request);
    }
}
