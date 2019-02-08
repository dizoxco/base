<?php

namespace App\Http\Controllers\Web;

use App\Models\Business;
use App\Http\Controllers\Controller;
use App\Repositories\Facades\BusinessRepo;

class BusinessController extends Controller
{
    public function show(Business $business)
    {
        $recent = BusinessRepo::getRecent();
        return view('web.businesses.show', compact('business', 'recent'));
    }
}
