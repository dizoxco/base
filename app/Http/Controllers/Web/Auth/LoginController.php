<?php

namespace App\Http\Controllers\Web\Auth;

use Auth;
use Cookie;
use Throwable;
use Google_Client;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    private $service_type;

    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function username()
    {
        return 'service';
    }

    public function redirectPath()
    {
        return session()->previousUrl() ?? route('home');
    }

    protected function authenticated()
    {
        return redirect()->intended($this->redirectPath())
            ->withCookie(Cookie::make('cart', null))
            ->withCookie(Cookie::make('wishlist', null));
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect('/')->withCookies([Cookie::make('token', null)]);
    }

    public function google(Request $request)
    {
        try {
            $client = new Google_Client([
                'client_id' => env('GOOGLE_CLIENT_ID'),
                'client_secret' => env('GOOGLE_CLIENT_SECRET'),
                'redirect_uri' => env('GOOGLE_REDIRECT_URI'),
            ]);

            $payload = $client->verifyIdToken($request->input('token'));
            if ($payload) {
                $user = User::firstOrCreate(
                    [
                        'google_id' => $payload['sub'],
                    ],
                    [
                        'email' => $payload['email'],
                        'name' => $payload['name'],
                        'email_verified_at' => now(),
                    ]
                );

                $user->addMediaFromUrl($payload['picture'])->toMediaCollection(enum('media.user.avatar'));

                Auth::login($user);

                return response([], Response::HTTP_OK);
            } else {
                return response([], Response::HTTP_NOT_FOUND);
            }
        } catch (Throwable $throwable) {
            return response([], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    protected function credentials(Request $request)
    {
        return $request->merge([
            $this->service_type => $request->input('service'),
        ])->only($this->service_type, 'password');
    }

    protected function validateLogin(Request $request)
    {
        $data = $request->all();

        if ($this->service_type = service_type($data['service'])) {
            $config = config('auth.via.'.$this->service_type);
            if ($config['enabled']) {
                return Validator::make($data, [
                    'service'   =>  'required|string',
                    'password'  =>  'required|string|min:6',
                ]);
            }
        }

        return service_disabled();
    }
}
