<?php

namespace App\Http\Controllers\Web;

use App\Models\City;
use App\Models\Address;
use App\Http\Controllers\Controller;
use App\Http\Requests\Address\StoreAddressRequest;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = auth()->user()->addresses()->with('city')->get();

        return view('profile.address.index', compact('addresses'));
    }

    public function create()
    {
        $cities = City::select(['id', 'name'])->get()->pluck('name', 'id')->toArray();

        return view('profile.address.create', compact('cities'));
    }

    public function store(StoreAddressRequest $request)
    {
        \Auth::user()->addresses()->create($request->all());

        return redirect()->route('profile.addresses.index');
    }

    public function edit(Address $address)
    {
        $cities = City::select(['id', 'name'])->get()->pluck('name', 'id')->toArray();

        return view('profile.address.edit', compact('address', 'cities'));
    }

    public function update(StoreAddressRequest $request, Address $address)
    {
        $address->update($request->all());

        return redirect()->route('profile.addresses.index');
    }

    public function destroy(Address $address)
    {
        $address->delete();

        return redirect()->route('profile.addresses.index');
    }
}
