<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;

class UserRepository extends BaseRepository
{

    public function find(int $id)   :   ?User
    {
        return User::find($id)->first();
    }

    public function findByEmail(string $email)  :   ?User
    {
        return User::whereEmail($email)->first();
    }

    public function searchBy(array $columns, string $value) :   Collection
    {
        $builder    =   User::query();
        foreach ($columns as $column) {
            $builder->orWhere(
                function ($query) use ($column, $value) {
                    $query->where($column, 'like', '%'.$value.'%');
                }
            );
        }
        return $builder->get();
    }

    public function getAll($params = [])    :   Collection
    {
        $users = QueryBuilder::for(User::query())
            ->allowedFilters(['name', 'email'])
            ->allowedIncludes(['posts', 'comments'])
            ->allowedSorts(['created_at']);
        $this->applyParams($users, $params);
        return $users->get();
    }

    public function getBy(string $column, string $value)  :   Collection
    {
        return QueryBuilder::for(User::query())
            ->allowedFilters(['name', 'email'])
            ->allowedIncludes(['posts', 'comments'])
            ->allowedSorts(['created_at'])
            ->where($column, '=', $value)
            ->get();
    }

    public function getTrashed()    :   Collection
    {
        return QueryBuilder::for(User::query())
            ->allowedFilters(['name', 'email'])
            ->allowedIncludes(['posts', 'comments'])
            ->allowedSorts(['created_at'])
            ->onlyTrashed()
            ->get();
    }

    public function create(array $data) :   User
    {
        return  User::create($data);
    }

    public function delete($user)    :   bool
    {
        if ($user instanceof User){
            return  $user::delete();
        }
        $ids    =   is_array($user) ? $user : func_get_args();
        return  User::whereIn('id', $ids)->delete();
    }

    public function active(string $token)   :   bool
    {
        return User::where('activation_token', '=', $token)->update([
            'active'            =>  true,
            'activation_token'  =>  null,
        ]);
    }

    public function update($user, array $data)
    {
        if ($user instanceof User) {
            return $user->update($data);
        }
        $ids    =   is_array($user)? $user: [$user];
        return  User::whereIn('id', $ids)->update($data);
    }

    public function posts($user)
    {
        return $user->posts;
    }
}
