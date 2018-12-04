<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\DBResource;
use App\Http\Resources\PermissionCollection;
use App\Http\Resources\RoleCollection;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\Facades\UserRepo;

class UserController extends Controller
{
    public function index()
    {
        return new UserCollection(UserRepo::getAll());
    }

    public function store(StoreUserRequest $request)
    {
        $created_user   =   UserRepo::create($request->except('avatar'));
        if ($request->hasFile('avatar')) {
            $created_user->addMediaFromRequest('avatar')->toMediaCollection(enum('media.user.avatar'));
        }
        return new UserResource($created_user);
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        if ($request->hasFile('avatar')) {
            $user->addMediaFromRequest('avatar')
                ->toMediaCollection(enum('media.user.avatar'));
        }
        return new DBResource(UserRepo::update($user, $request->except('avatar')));
    }

    public function delete(User $user)
    {
        return new DBResource(UserRepo::delete($user));
    }

    public function restore(string $user)
    {
        return new DBResource(UserRepo::restore($user));
    }

    public function destroy(string $user)
    {
        return new DBResource(UserRepo::destroy($user));
    }

    /**
     * Show a list of user roles
     *
     * @param User $user
     * @return RoleCollection
     */
    public function roles(User $user)
    {
        return new RoleCollection($user->roles);
    }

    /**
     * Sync user roles
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
     * index users permissions
     *
     * @param User $user
     * @return PermissionCollection
     */
    public function permissions(User $user)
    {
        return new PermissionCollection($user->permissions);
    }
}
