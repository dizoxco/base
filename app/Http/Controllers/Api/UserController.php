<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\DBResource;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\Facades\UserRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class UserController extends Controller
{
    public function index()
    {
        return new UserCollection( UserRepo::getAll() );
    }

    public function store(StoreUserRequest $request)
    {
        return new UserResource( UserRepo::store($request->all()) );
    }

    public function show(User $user)
    {
        return new UserResource( $user );
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        return new DBResource( UserRepo::update(1, $request->all()) );
    }

    public function delete(User $user)
    {
        return new UserResource( UserRepo::delete($user, $request->all()) );
    }

    public function posts(USer $user)
    {
        return new PostCollection( UserRepo::posts($user) );
    }

    public function comments(User $user)
    {
        return new CommentCollection( UserRepo::comments($user) );
    }

    public function roles(User $user)
    {
        return new RoleCollection( UserRepo::roles($user) );
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

    public function permissions(User $user)
    {
        return new PermissionCollection( UserRepo::roles($user) );
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
