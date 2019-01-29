<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Repositories\Facades\BusinessRepo;

class BusinessController extends Controller
{
    public function show(Business $business)
    {
        $recent = BusinessRepo::getRecents();
        return view('businesses.show', compact('business', 'recent'));
    }
}
