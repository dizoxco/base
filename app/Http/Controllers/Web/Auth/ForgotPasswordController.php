<?php

namespace App\Http\Controllers\Web\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    private $service_type;

    use SendsPasswordResetEmails;

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);

        $response = Password::broker()->sendResetLink(
            request()->merge([
                $this->service_type => $request->input('service'),
                'service' => $this->service_type,
            ])->toArray()
        );

        return $response == Password::RESET_LINK_SENT
            ? redirect()->route('password.token.get')->with('status', trans($response))
            : back()->withErrors(['email' => trans($response)]);
    }

    public function validateEmail(Request $request)
    {
        if ($this->service_type = service_type($request->input('service'))) {
            $config = config('auth.via.'.$this->service_type);
            if ($config['enabled']) {
                return Validator::make($request->all(), [
                    'service'   =>  'required|string',
                ]);
            }
        }

        return service_disabled();
    }

    public function getToken()
    {
        return view('auth.passwords.token');
    }

    public function validateToken(Request $request)
    {
        return view('auth.passwords.reset')->with(
            ['token' => $request->input('token'), 'email' => $request->email]
        );
    }
}
