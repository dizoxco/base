<?php

namespace App\Http\Controllers\Web;

use Auth;
use Hash;
use Session;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Facades\UserRepo;
use App\Http\Requests\Profile\UpdateInfoRequest;
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
        return view('profile.edit');
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
        UserRepo::update(Auth::user(), array_filter($request->all()));

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

    public function orders(Request $request)
    {
        $orders = Auth::user()->orders()
            ->with('city', 'variations', 'variations.product')
            ->paginate($request->input('per_page', 12));

        return view('profile.orders.index', compact('orders'));
    }

    public function orderShow(Order $order)
    {
        $order = $order->load('variations.business', 'user');

        return view('profile.orders.show', compact('order'));
    }

    public function credentials()
    {
        return view('profile.credentials.edit')->withUser(Auth::user());
    }

    public function updateCredentials(UpdateProfileRequest $request)
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
}
