<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Throwable;

class UserRepository extends BaseRepository
{

    public function find(int $id)   :   ?User
    {
        return User::find($id);
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


    /**
     * @param array $data
     * @return User|\Illuminate\Database\Eloquent\Model|int
     */
    public function create(array $data)
    {
        try {
            return User::create($data);
        } catch (QueryException $queryException) {
            return 0;
        }
    }

    /**
     * @param User|array $user
     * @return bool|int|null
     */
    public function delete($user)
    {
        try {
            if ($user instanceof User) {
                return  $user->delete();
            }

            $ids    =   is_array($user) ? $user : func_get_args();
            return  User::whereIn('id', $ids)->delete();

        } catch (Throwable $throwable) {
            return 0;
        }
    }

    /**
     * @param User|array $user
     * @return bool|int
     */
    public function restore($user)
    {
        try {
            if ($user instanceof User) {
                return  $user->restore();
            }

            $ids    =   is_array($user) ? $user : func_get_args();
            return  User::whereIn('id', $ids)->restore();

        } catch (Throwable $throwable) {
            return 0;
        }
    }

    /**
     * @param User|array $user
     * @return bool|int
     */
    public function destroy($user)
    {
        try {
            if ($user instanceof User) {
                return  $user->forceDelete();
            }

            $ids    =   is_array($user) ? $user : func_get_args();
            return  User::whereIn('id', $ids)->forceDelete();

        } catch (Throwable $throwable) {
            return 0;
        }
    }

    public function activate(string $token)   :   int
    {
        return User::where('activation_token', '=', $token)->update([
            'active'            =>  true,
            'activation_token'  =>  null,
        ]);
    }

    public function isActive($user)
    {
        try {
            if ($user instanceof User) {
                return  $this->find($user->id)->activation_token === null;
            }

            $ids    =   is_array($user) ? $user : func_get_args();
            return  User::whereNotNull('activation_token')->whereIn('id', $ids)->count() === count($ids);
        } catch (Throwable $throwable) {
            return 0;
        }
    }

    public function update($user, array $data)  :   int
    {
        if (empty($data)) {
            return 0;
        }

        try {
            if ($user instanceof User) {
                return $user->update($data);
            }

            $ids    =   is_array($user) ? $user: [$user];
            return  User::whereIn('id', $ids)->update($data);
        } catch (Throwable $throwable) {
            return 0;
        }
    }

    public function posts($user)    :   Collection
    {
        return $user->posts;
    }
}
