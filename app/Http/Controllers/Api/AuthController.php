<?php

namespace App\Http\Controllers\Api;

use App\Events\User\UserStoreEvent;
use App\Models\User;
use Laravel\Passport\PersonalAccessTokenFactory;
use Laravel\Passport\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Repositories\Facades\UserRepo;
use App\Http\Requests\User\PostLoginRequest;
use App\Http\Requests\User\StoreUserRequest;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * @param PostLoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(PostLoginRequest $request)
    {
        $credentials    =   $request->only(['email','password']);
        if (!Auth::attempt($credentials)) {
            return response()->json(
                [
                    'errors'    =>  [
                        'email' =>  [trans('auth.failed')]
                    ]
                ],
                Response::HTTP_NOT_FOUND
            );
        }

        /** @var User $user */
        $user           =   Auth::user();
        $tokenResult    =   $user->createToken('Personal Access Token');

        /** @var Token $token */
        $token          =   $tokenResult->token;

        if ($request->filled('remember_me')) {
            $token->expires_at  =   now()->addWeek();
        }

        $token->save();
        return response()->json([
            'access_token'  =>  $tokenResult->accessToken,
            'token_type'    =>  'Bearer',
            'expires_at'    =>  $tokenResult->token->expires_at->toDateTimeString()
        ]);
    }

    /**
     * Logout user (Revoke the token)
     *
     * @param Request $request
     * @return array
     */
    public function logout(Request $request)
    {
        /** @var User $user */
        $user   =   Auth::user();
        $user->tokens()->each(function (Token $token) {
            $token->revoke();
        });
        Auth::logout();
        return [
            'errors'    =>  [
                'auth'  =>  [trans('auth.logout')]
            ]
        ];
    }

    /**
     * Get the authenticated User
     *
     * @param Request $request
     * @return UserResource
     */
    public function user(Request $request)
    {
        return new UserResource($request->user());
    }

    /**
     * Create user
     *
     * @param StoreUserRequest $request
     *
     * @return \Illuminate\Http\JsonResponse [string] message
     */
    public function register(StoreUserRequest $request)
    {
        if ($user = UserRepo::create($request->all())) {
            event(new UserStoreEvent($user));
            return response()->json(
                [
                    'message' => trans('auth.register', [
                        'full_name' =>  $request->user('api')->fullname
                    ])
                ],
                Response::HTTP_CREATED
            );
        } else {
            return response()->json(
                [
                    'message' =>  trans('auth.register_failed')
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    /**
     * active user account | method: get
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
                    'message' => trans('auth.activated')
                ],
                Response::HTTP_OK
            );
        } else {
            return response()->json(
                [
                    'message' => trans('auth.token_expired')
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
    }
}
