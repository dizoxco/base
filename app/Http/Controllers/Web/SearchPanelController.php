<?php

namespace App\Http\Controllers\Web;

use App\Models\Tag;
use App\Models\Product;
use App\Models\Business;
use App\Models\SearchPanel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchPanelController extends Controller
{
    public function panel(Request $request, SearchPanel $searchPanel)
    {
        $options = $searchPanel->options;

        if ($searchPanel->model === Product::class) {
            $products = $searchPanel->result($request, ['tags', 'media']);

            return view('web.products.search', compact('options', 'products'));
        }

        if ($searchPanel->model === Business::class) {
            $businesses = $searchPanel->result($request, ['media', 'city']);

            return view('web.businesses.search', compact('options', 'businesses'));
        }
    }

    public function keyword(string $keyword)
    {
        $businesses = Business::Where('brand', 'like', '%'.$keyword.'%')->take(7)->get();
        $tags = Tag::Where('label', 'like', '%'.$keyword.'%')->take(7)->get();

        return view('components.srch', compact('businesses', 'tags'));
    }
}
