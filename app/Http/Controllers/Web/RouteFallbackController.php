<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RouteFallbackController extends Controller
{
    public function __invoke(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            return response()->json([
                'route' => trans('http.not_found'),
            ]);
        }

        return redirect()->to('/')->withErrors([
            'route' => trans('http.not_found'),
        ]);
    }
}
