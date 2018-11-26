<?php

namespace App\Repositories\Repo;

use App\Models\User;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;

class UserRepository
{
    /**
     * @param int $id
     * @return User|null
     */
    public function find(int $id)   :   ?User
    {
        return User::find($id)->first();
    }

    /**
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email)  :   ?User
    {
        return User::whereEmail($email)->first();
    }

    /**
     * @param array $columns
     * @param string $value
     * @return Collection
     */
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

    /**
     * @return Collection
     */
    public function getAll()    :   Collection
    {
        return QueryBuilder::for(User::query())
            ->allowedFilters(['name', 'email'])
            ->allowedIncludes(['posts', 'comments'])
            ->allowedSorts(['created_at'])
            ->get();
    }

    /**
     * @param string $column
     * @param string $value
     * @return Collection
     */
    public function getBy(string $column, string $value)  :   Collection
    {
        return QueryBuilder::for(User::query())
            ->allowedFilters(['name', 'email'])
            ->allowedIncludes(['posts', 'comments'])
            ->allowedSorts(['created_at'])
            ->where($column, '=', $value)
            ->get();
    }

    /**
     * @return Collection
     */
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
     * @return User
     */
    public function create(array $data) :   User
    {
        return  User::create($data);
    }

    /**
     * @param $ids
     * @return bool
     * @throws \Exception
     */
    public function delete($user)    :   bool
    {
        if ($user instanceof User){
            return  $user::delete();
        }
        $ids    =   is_array($user) ? $user : func_get_args();
        return  User::whereIn('id', $ids)->delete();
    }

    /**
     * @param $user
     * @param array $data
     * @return bool
     */
    public function update($user, array $data)  :   bool
    {
        if ($user instanceof User) {
            return $user->update($data);
        }
        $ids    =   is_array($user) ?: [$user];
        return  User::whereIn('id', $user)->update($data);
    }
}
