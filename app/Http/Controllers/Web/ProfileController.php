<?php

namespace App\Http\Controllers\Web;

use Auth;
use Hash;
use Session;
use App\Http\Controllers\Controller;
use App\Repositories\Facades\UserRepo;
use App\Http\Requests\Profile\UpdateProfileRequest;
use App\Notifications\User\EmailVerificationNotification;
use App\Notifications\User\MobileVerificationNotification;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index')->withUser(Auth::user());
    }

    public function edit()
    {
        return view('profile.edit')->withUser(Auth::user());
    }

    public function update(UpdateProfileRequest $request)
    {
        if ($request->filled('old_password')) {
            if (Hash::check($request->input('old_password'), Auth::user()->password)) {
                $request->merge([
                    'password' => Hash::make($request->input('password')),
                ]);
            } else {
                return redirect()->route('profile.edit')->withErrors([
                    'old_password' => 'old password is wrong',
                ]);
            }
        }

        if ($request->hasFile('avatar')) {
            Auth::user()->addMediaFromRequest('avatar')->toMediaCollection(enum('media.user.avatar'));
        }
        UserRepo::update(Auth::user(), array_filter($request->except('avatar')));

        return redirect()->route('profile.index');
    }

    public function sendEmailVerification()
    {
        if (Auth::user()->hasNotVerified('email')) {
            Session::put('token', $token = random_int(111111, 999999));
            Auth::user()->notifyNow(new EmailVerificationNotification($token));

            return redirect()->route('profile.index');
        }

        return back();
    }

    public function checkEmailVerification(string $token)
    {
        if (Auth::user()->hasVerified('email')) {
            return redirect()->route('profile.index', ['verify' => 'verified_before']);
        }

        if (is_null($stored_token = Session::pull('token'))) {
            return redirect()->route('profile.index', ['verify' => 'invalid_token']);
        }

        if ($token == $stored_token) {
            Auth::user()->update(['email_verified_at' => now()]);

            return redirect()->route('profile.index', ['verify' => 'success']);
        }

        return redirect()->route('profile.index', ['verify' => 'expired_token']);
    }

    public function sendMobileVerification()
    {
        if (Auth::user()->hasNotVerified('mobile')) {
            Session::put('token', $token = random_int(111111, 999999));
            Auth::user()->notifyNow(new MobileVerificationNotification($token));

            return redirect()->route('profile.index');
        }

        return back();
    }

    public function checkMobileVerification(string $token)
    {
        if (Auth::user()->hasVerified('mobile')) {
            return redirect()->route('profile.index', ['verify' => 'verified_before']);
        }

        if (is_null($stored_token = Session::pull('token'))) {
            return redirect()->route('profile.index', ['verify' => 'invalid_token']);
        }

        if ($token == $stored_token) {
            Auth::user()->update(['mobile_verified_at' => now()]);

            return redirect()->route('profile.index', ['verify' => 'success']);
        }

        return redirect()->route('profile.index', ['verify' => 'expired_token']);
    }
}
