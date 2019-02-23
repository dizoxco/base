<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RouteFallbackController extends Controller
{
    public function __invoke()
    {
        return redirect()->to('/')->withErrors([
            'route' => trans('http.not_found')
        ]);
    }
}
