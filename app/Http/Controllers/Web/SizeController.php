<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Size\StoreSizeRequest;
use App\Http\Requests\Size\UpdateSizeRequest;
use App\Models\Size;

class SizeController extends Controller
{
    public function index()
    {
        return view('profile.sizes.index')->withSizes(\Auth::user()->sizes);
    }

    public function create()
    {
        return view('profile.sizes.create');
    }

    public function store(StoreSizeRequest $request)
    {
        \Auth::user()->sizes()->create($request->all());
        return redirect()->route('profile.sizes.index');
    }

    public function show(Size $size)
    {
        return view('profile.sizes.show', compact('size'));
    }

    public function edit(Size $size)
    {
        return view('profile.index', compact('size'));
    }

    public function update(UpdateSizeRequest $request, Size $size)
    {
        return $size->update($request->all());
    }

    public function destroy(Size $size)
    {
        return $size->delete();
    }
}
