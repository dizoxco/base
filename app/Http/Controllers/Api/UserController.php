<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Events\User\UserStoreEvent;
use App\Http\Controllers\Controller;
use App\Http\Resources\EffectedRows;
use App\Http\Resources\UserResource;
use App\Http\Resources\RoleCollection;
use App\Http\Resources\UserCollection;
use App\Repositories\Facades\UserRepo;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Resources\PermissionCollection;
use App\Http\Requests\User\UpdateUserRequest;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function index()
    {
        return new UserCollection(UserRepo::getAll());
    }

    public function trash()
    {
        return new UserCollection(UserRepo::getTrashed());
    }

    public function store(StoreUserRequest $request)
    {
        $data = $request->except('avatar');
        $data['password'] = bcrypt($data['password']);
        $data['activation_token'] = str_random(32);

        $createdUser = UserRepo::create($data);
        if ($createdUser === 0) {
            return new EffectedRows($createdUser);
        }

        if ($request->hasFile('avatar')) {
            $createdUser->addMediaFromRequest('avatar')->toMediaCollection(enum('media.user.avatar'));
        }

        // event(new UserStoreEvent($createdUser));

        return new UserResource($createdUser);
    }

    public function show(User $user)
    {
        return new UserResource($user->load('avatar'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        if ($request->hasFile('avatar')) {
            $user->addMediaFromRequest('avatar')->toMediaCollection(enum('media.user.avatar'));
        }

        if (empty($request->input('password'))) {
            unset($request['password']);
        } else {
            $request->merge([
                'password'  =>  bcrypt($request->input('password')),
            ]);
        }
        UserRepo::update($user, $request->except('avatar'));

        return new UserResource($user);
    }

    public function delete(User $user)
    {
        if (auth_user()->is($user)) {
            return response(
                [
                    'error' => [
                        'unauthorized'  =>  trans('http.unauthorized'),
                    ],
                ],
                Response::HTTP_UNAUTHORIZED,
                [
                    'Content-Type' => enum('system.response.json'),
                ]
            );
        }

        return new EffectedRows(UserRepo::delete($user));
    }

    public function restore(string $user)
    {
        if (auth_user()->id == $user) {
            return response(
                [
                    'error' => [
                        'unauthorized'  =>  trans('http.unauthorized'),
                    ],
                ],
                Response::HTTP_UNAUTHORIZED,
                [
                    'Content-Type' => enum('system.response.json'),
                ]
            );
        }

        return new EffectedRows(UserRepo::restore($user));
    }

    public function destroy(string $user)
    {
        if (auth_user()->id == $user) {
            return response(
                [
                    'error' => [
                        'unauthorized'  =>  trans('http.unauthorized'),
                    ],
                ],
                Response::HTTP_UNAUTHORIZED,
                [
                    'Content-Type' => enum('system.response.json'),
                ]
            );
        }

        return new EffectedRows(UserRepo::destroy($user));
    }

    /**
     * Show a list of user roles.
     *
     * @param User $user
     * @return RoleCollection
     */
    public function roles(User $user)
    {
        return new RoleCollection($user->roles);
    }

    /**
     * Sync user roles.
     *
     * @param User $user
     * @param Request $request
     * @return RoleCollection
     */
    public function syncRoles(User $user, Request $request)
    {
        $user->syncRoles($request->roles);

        return new RoleCollection(UserRepo::roles($user));
    }

    /**
     * index users permissions.
     *
     * @param User $user
     * @return PermissionCollection
     */
    public function permissions(User $user)
    {
        return new PermissionCollection($user->permissions);
    }
}
