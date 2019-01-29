<?php

namespace App\Http\Controllers\Web;

use App\Models\Business;
use App\Models\Product;
use App\Models\SearchPanel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchPanelController extends Controller
{
    public function search(Request $request, SearchPanel $searchPanel)
    {
        $result = $searchPanel->result($request);

        if ($searchPanel->model === Product::class) {
            return view('searchpanels.products')->withProducts($result);
        }

        if ($searchPanel->model === Business::class) {
            return view('searchpanels.businesses')->withBusinesses($result);
        }
    }
}
