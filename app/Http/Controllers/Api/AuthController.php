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

    /**
     * Create user.
     *
     * @param StoreUserRequest $request
     *
     * @return \Illuminate\Http\JsonResponse [string] message
     */
    public function register(StoreUserRequest $request)
    {
        $request->merge([
            'activation_token'  =>  str_random(32),
            'password' => bcrypt($request->input('password')),
        ]);

        if ($user = UserRepo::create($request->except('avatar'))) {
            if ($request->hasFile('avatar')) {
                $user->addMediaFromRequest('avatar')->toMediaCollection(enum('media.user.avatar'));
            }
            Auth::loginUsingId($user->id);
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
                    'data' => $user,
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    /**
     * active user account | method: get.
     *
     * @param Request $request
     * @param $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
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
