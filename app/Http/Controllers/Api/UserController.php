<?php

namespace App\Http\Controllers\Api;

use Request;
use App\Models\User;
use App\Http\Resources\DBResource;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\RoleCollection;
use App\Http\Resources\UserCollection;
use App\Repositories\Facades\UserRepo;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Resources\PermissionCollection;
use App\Http\Requests\User\UpdateUserRequest;

class UserController extends Controller
{
    public function index()
    {
        return new UserCollection(UserRepo::getAll());
    }

    public function store(StoreUserRequest $request)
    {
        return new UserResource(UserRepo::create($request->all()));
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
        return new DBResource(UserRepo::delete($user));
    }

    public function restore(string $user)
    {
        return new DBResource(UserRepo::delete($user));
    }

    public function destroy(string $user)
    {
        return new DBResource(UserRepo::delete($user));
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
