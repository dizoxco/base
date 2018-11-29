<?php

namespace App\Repositories;

use Exception;
use Log;
use App\Models\User;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\QueryException;

class UserRepository extends BaseRepository
{

    const NO_ROWS_AFFECTED  =   0;

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
     * @return User|int
     */
    public function create(array $data)
    {
        try {
            return  User::create($data);
        } catch (QueryException $queryException) {
            Log::error($queryException->getMessage());
            return self::NO_ROWS_AFFECTED;
        }
    }

    /**
     * @param User|array $user
     * @return bool|int
     */
    public function delete($user)
    {
        try {
            if ($user instanceof User) {
                return  $user->delete();
            }

            $ids    =   is_array($user) ? $user : func_get_args();
            return  User::whereIn('id', $ids)->delete();

        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return self::NO_ROWS_AFFECTED;
        }
    }

    public function active(string $token)   :   int
    {
        return User::where('activation_token', '=', $token)->update([
            'active'            =>  true,
            'activation_token'  =>  null,
        ]);
    }

    public function update($user, array $data)  :   int
    {
        if ($user instanceof User) {
            return $user->update($data);
        }
        $ids    =   is_array($user)? $user: [$user];
        return  User::whereIn('id', $ids)->update($data);
    }

    public function posts($user)    :   Collection
    {
        return $user->posts;
    }
}
