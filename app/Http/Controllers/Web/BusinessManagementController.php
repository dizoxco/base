<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Business;
use Auth;

class BusinessManagementController extends Controller
{
    public function index()
    {
        return view('profile.businesses.index')->withBusinesses(Auth::user()->businesses);
    }

    public function create()
    {
        return view('profile.businesses.create');
    }

    public function store()
    {
        request()->merge(['contact' => [], 'status' => 0]);
        $business = auth()->user()->businesses()->create(request()->all());

        return redirect()->route('profile.businesses.show', $business->slug);
        // dd($business);
    }

    public function show(Business $business)
    {
        return view('profile.businesses.show', compact('business'));
    }
}
