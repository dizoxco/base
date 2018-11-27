<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginUserRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * @param LoginUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginUserRequest $request)
    {
        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return response()->json(
              ['message' => 'کاربری با این مشخصات پیدا نشد.'],
              401
            );
        }

        // todo: wrap this code into repository : start
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me){
            $token->expires_at = Carbon::now()->addWeeks(1);
        }
        $token->save();
        // todo: wrap this code into repository : end

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString()
        ]);
    }

    /**
     * Logout user (Revoke the token)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json(['message' => 'از حساب کاربری خارج شدید']);
    }

    /**
     * Get the authenticated User
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse [json] user object
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
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
        $user = (new UserRepository())->storeNewUser($request);
        return response()->json([
            'message' => 'ثبت نام شما با موفقیت انجام شد.'
        ], 201);
    }

    /**
     * active user account | method: get
     *
     * @param $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function registerActive($token)
    {
        $message = "حساب کاربری شما با موفقیت فعال شد.";
        $code = 200;

        $user = (new UserRepository())->activeUser($token);

        if (empty($user)) {
            $message = "حساب کاربری پیدا نشد!";
            $code = 404;
        }

        return response()->json([
            'message' => $message
        ], $code);

    }
}
