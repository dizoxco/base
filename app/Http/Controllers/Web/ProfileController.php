<?php

namespace App\Http\Controllers\Web;

use Auth;
use Hash;
use App\Http\Controllers\Controller;
use App\Repositories\Facades\UserRepo;
use App\Http\Requests\Profile\UpdateInfoRequest;
use App\Http\Requests\Profile\UpdateCredentialRequest;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index')->withUser(Auth::user());
    }

    public function orders()
    {
        $orders = Auth::user()->orders()->with('city', 'variations', 'variations.product')->get();

        return view('profile.orders', compact('orders'));
    }

    public function credentials()
    {
        return view('profile.credentials.edit')->withUser(Auth::user());
    }

    public function updateCredentials(UpdateCredentialRequest $request)
    {
        if ($request->filled('password')) {
            if (Hash::check($request->input('old_password'), auth()->user()->password)) {
                $request->merge([
                    'password' => Hash::make($request->input('password')),
                ]);
            } else {
                return redirect()->route('profile.credentials.edit')->withErrors([
                        'old_password' => 'old password is wrong',
                    ]);
            }
        }

        if (UserRepo::update(Auth::user(), array_filter($request->all()))) {
            return redirect()->route('profile.credentials.edit');
        } else {
            return redirect()->route('profile.credentials.edit')
                ->withInput()->withErrors([
                    'error' => 'Something went wrong',
                ]);
        }
    }

    public function info()
    {
        $user = auth()->user();

        return view('profile.info', compact('user'));
    }

    public function updateInfo(UpdateInfoRequest $request)
    {
        if (UserRepo::update(auth()->user(), $request->all())) {
            return redirect()->route('profile.info.update');
        } else {
            return redirect()->route('profile.info.update')
                ->withInput()->withErrors([
                    'error' => 'Something went wrong',
                ]);
        }
    }

    public function edit()
    {
        return view('profile.form');
    }

    public function update(UpdateCredentialRequest $request)
    {
        if ($request->filled('password')) {
            if (Hash::check($request->input('old_password'), auth()->user()->password)) {
                $request->merge([
                    'password' => Hash::make($request->input('password')),
                ]);
            } else {
                return redirect()->route('profile.edit')->withErrors([
                    'old_password' => 'old password is wrong',
                ]);
            }
        }
        auth()->user()->update($request->all());

        return back();
    }
}
