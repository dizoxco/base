<?php

namespace App\Http\Controllers\Web;

use App\Models\SearchPanel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchPanelController extends Controller
{
    public function search(Request $request, SearchPanel $searchPanel)
    {
        $products = $searchPanel->result($request);

        return view('searchpanels.index', compact('products'));
    }
}
