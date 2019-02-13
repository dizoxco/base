<?php

namespace App\Http\Controllers\Web\Auth;

use Auth;
use Google_Client;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectPath()
    {
        return session()->previousUrl() ?? route('home');
    }

    public function google(Request $request)
    {
        try {
            $client = new Google_Client([
                'client_id' => env('GOOGLE_CLIENT_ID'),
                'client_secret' => env('GOOGLE_CLIENT_SECRET'),
                'redirect_uri' => route('google'),
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
                    ]
                );
                $user->addMediaFromUrl($payload['picture'])->toMediaCollection(enum('media.user.avatar'));
                Auth::login($user);

                return response([], Response::HTTP_OK);
            } else {
                return response([], Response::HTTP_NOT_FOUND);
            }
        } catch (\Throwable $throwable) {
            return response([], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
