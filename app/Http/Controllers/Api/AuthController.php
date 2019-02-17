<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Laravel\Passport\Token;
use Illuminate\Http\Request;
use App\Events\User\UserStoreEvent;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Facades\UserRepo;
use App\Http\Requests\User\PostLoginRequest;
use App\Http\Requests\User\StoreUserRequest;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(PostLoginRequest $request)
    {
        // Anything that user enter.
        $service = $request->input('service');
        // We guess what the user has entered. mobile, email or etc...
        $service_type = service_type($service);

        $request->merge([$service_type => $service]);

        $credentials = $request->only([$service_type, 'password']);
        if (! Auth::attempt($credentials)) {
            return response()->json(
                [
                    'errors'    =>  [
                        'email' =>  [trans('auth.failed')],
                    ],
                ],
                Response::HTTP_NOT_FOUND
            );
        }

        $tokenResult = $this->createToken($request);

        return response()->json([
            'access_token'  =>  $tokenResult->accessToken,
            'token_type'    =>  'Bearer',
            'expires_at'    =>  $tokenResult->token->expires_at->toDateTimeString(),
        ]);
    }

    public function logout(Request $request)
    {
        auth_user()->tokens()->whereRevoked(false)->update(['revoked' => true]);
        return [
            'errors'    =>  [
                'auth'  =>  [trans('auth.logout')],
            ],
        ];
    }

    public function register(StoreUserRequest $request)
    {
        // Anything that user enter.
        $service = $request->input('service');
        // We guess what the user has entered. mobile, email or etc...
        $service_name = service_type($service);

        $request->merge([
            'activation_token' => $service_name . '_' . random_int(111111, 999999),
            'password' => bcrypt($request->input('password')),
             // email => john@doe.com
            // mobile => +989123456789
             $service_name => $service
        ]);

        if ($user = UserRepo::create($request->except('avatar'))) {
            if ($request->hasFile('avatar')) {
                $user->addMediaFromRequest('avatar')->toMediaCollection(enum('media.user.avatar'));
            }

            Auth::login($user);

            event(new UserStoreEvent($user));

            return response()->json(
                [
                    'message' => trans('auth.register'),
                ],
                Response::HTTP_CREATED
            );
        } else {
            return response()->json(
                [
                    'message' =>  trans('auth.register_failed'),
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    public function activate(Request $request, $token)
    {
        if (UserRepo::activate($token)) {
            return response()->json(
                [
                    'message' => trans('auth.activated'),
                ],
                Response::HTTP_OK
            );
        } else {
            return response()->json(
                [
                    'message' => trans('auth.token_expired'),
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    protected function createToken(PostLoginRequest $request): \Laravel\Passport\PersonalAccessTokenResult
    {
        $tokenResult = Auth::user()->createToken('Personal Access Token');

        $token = $tokenResult->token;

        if ($request->filled('remember_me')) {
            $token->expires_at = now()->addWeek();
        }

        $token->save();

        return $tokenResult;
    }
}
