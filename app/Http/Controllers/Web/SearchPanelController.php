<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\SearchPanel;
use Illuminate\Http\Request;

class SearchPanelController extends Controller
{
    public function search(Request $request, SearchPanel $searchPanel)
    {
        $products = $searchPanel->result($request);
        return view('searchpanels.index', compact('products'));
    }
}
