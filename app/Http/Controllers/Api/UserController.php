<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
// use App\Http\Resources\User\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\Facades\UserRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class UserController extends Controller
{
    public function index()
    {
        $users = UserRepo::getAll();
        return UserResource::collection($users);
        return new UserCollection($users);
    }

    public function store(StoreUserRequest $request)
    {
        $user = UserRepo::store($request->all());
        return response()->json($user);
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user = UserRepo::updateUser($user, $request->all());
        return response()->json([$user]);
    }

    public function delete(User $user)
    {
        $response = UserRepo::delete($user);
        return response()->json(['action' => $response]);
    }



    public function posts(USer $user)
    {
        return response()->json($user->posts());
    }

    public function comments(User $user)
    {
        return response()->json($user->comments());
    }

    public function roles(Request $request, User $user)
    {
        return response()->json($user->getAllRoles());
    }

    public function addRoles($id, Request $request)
    {
        $roles = $request->get('roles');

        if (empty($roles) || !is_array($roles)) {
            throw new \Exception("در خواست مجاز نیست");
        }

        $user = UserRepo::findUserById($id, $request, ['id']);

        (new RoleRepository())->store($user , $roles);
    }

    public function updateRoles($id, Request $request)
    {
        $roles = $request->get('roles');

        if (empty($roles) || !is_array($roles)) {
            throw new \Exception("در خواست مجاز نیست");
        }

        $user = UserRepo::findUserById($id, $request, ['id']);

        (new RoleRepository())->update($user , $roles);
    }

    public function permissions(Request $request, User $user)
    {
        return response()->json($user->getAllPermissions());
    }

    public function addPermissions($id, Request $request)
    {
        $permissions = $request->get('permissions');

        if (empty($permissions) || !is_array($permissions)) {
            throw new \Exception("در خواست مجاز نیست");
        }

        $user = UserRepo::findUserById($id, $request, ['id']);

        (new PermissionRepository())->store($user , $permissions);
    }

    public function updatePermissions($id, Request $request)
    {
        $permissions = $request->get('permissions');

        if (empty($permissions) || !is_array($permissions)) {
            throw new \Exception("در خواست مجاز نیست");
        }

        $user = UserRepo::findUserById($id, $request, ['id']);

        (new PermissionRepository())->update($user , $permissions);
    }

}
