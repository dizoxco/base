<?php

namespace App\Http\Controllers\Api;

use App\Models\SearchPanel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    public function show(Request $request, SearchPanel $search_panel)
    {
        return $search_panel->result($request);
    }
}
