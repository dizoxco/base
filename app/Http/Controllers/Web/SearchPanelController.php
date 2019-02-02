<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Product;
use App\Models\SearchPanel;
use Illuminate\Http\Request;

class SearchPanelController extends Controller
{
    public function search(Request $request, SearchPanel $searchPanel)
    {
        $options= $searchPanel->options;
        $result = $searchPanel->result($request);

        if ($searchPanel->model === Product::class) {
            return view('searchpanels.products', compact('options'))->withProducts($result);
        }

        if ($searchPanel->model === Business::class) {
            return view('searchpanels.businesses', compact('options'))->withBusinesses($result);
        }
    }
}
