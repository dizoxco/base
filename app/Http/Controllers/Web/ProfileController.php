<?php

namespace App\Http\Controllers\Web;

use Hash;
use App\Http\Controllers\Controller;
use App\Repositories\Facades\UserRepo;
use App\Http\Requests\Profile\UpdateInfoRequest;
use App\Http\Requests\Profile\UpdateCredentialRequest;

class ProfileController extends Controller
{
    public function orders()
    {
        $orders = auth()->user()->orders()->with('city', 'variations', 'variations.product')->get();

        return view('profile.orders', compact('orders'));
    }

    public function chats()
    {
        $chats = auth()->user()->chats;

        return view('profile.chats', compact('chats'));
    }

    public function credentials()
    {
        $user = auth()->user();

        return view('profile.credentials', compact('user'));
    }

    public function updateCredentials(UpdateCredentialRequest $request)
    {
        if ($request->has('password')) {
            if (Hash::check($request->input('old_password'), auth()->user()->password)) {
                $request->merge([
                    'password' => Hash::make($request->input('password')),
                ]);
            } else {
                return redirect()->route('profile.credentials.update')->withErrors([
                        'error' => 'old password is wrong',
                    ]);
            }
        }

        if (UserRepo::update(auth()->user(), $request->all())) {
            return redirect()->route('profile.credentials.update');
        } else {
            return redirect()->route('profile.credentials.update')
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
}
