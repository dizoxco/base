<?php

namespace App\Http\Controllers\Api;

use Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollection;
use App\Repositories\Facades\UserRepo;

class UserController extends Controller
{
    public function index()
    {
        return new UserCollection(UserRepo::getAll());
    }

    public function store(StoreUserRequest $request)
    {
        return new UserResource(UserRepo::store($request->all()));
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        return new DBResource(UserRepo::update($user, $request->all()));
    }

    public function delete(User $user)
    {
        return new UserResource(UserRepo::delete($user));
    }

    /**
     * Show a list of user roles
     *
     * @param User $user
     * @return RoleCollection
     */
    public function roles(User $user)
    {
        return new RoleCollection(UserRepo::roles($user));
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
        $user->syncRoles($request->all());
        return new RoleCollection(UserRepo::roles($user));
    }

    /**
     * ?
     *
     * @param User $user
     * @return PermissionCollection
     */
    public function permissions(User $user)
    {
        return new PermissionCollection(UserRepo::roles($user));
    }
}
