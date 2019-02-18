<?php

namespace App\Http\Controllers\Web;

use Auth;
use Session;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\GetShippingRequest;
use App\Http\Requests\Shipping\StoreAddressRequest;

class ShippingController extends Controller
{
    public function index(GetShippingRequest $request)
    {
        return view('profile.shipping')->withAddresses(Auth::user()->addresses);
    }

    public function store(StoreAddressRequest $request)
    {
        Session::put(
            'address',
            $request->input('address') // put address in session
        );

        return redirect()->route('payment.index');
    }
}
