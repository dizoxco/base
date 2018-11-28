<?php

namespace App\Repositories;

use App\Models\Post;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;

class PostRepository
{

    public function find(int $id)   :   ?Post
    {
        return Post::find($id)->first();
    }

    public function findByEmail(string $email)  :   ?Post
    {
        return Post::whereEmail($email)->first();
    }

    public function searchBy(array $columns, string $value) :   Collection
    {
        $builder    =   Post::query();
        foreach ($columns as $column) {
            $builder->orWhere(
                function ($query) use ($column, $value) {
                    $query->where($column, 'like', '%'.$value.'%');
                }
            );
        }
        return $builder->get();
    }

    public function getAll()    :   Collection
    {
        return QueryBuilder::for(Post::query())
            ->allowedFilters(['name', 'email'])
            ->allowedIncludes(['posts', 'comments'])
            ->allowedSorts(['created_at'])
            ->get();
    }

    public function getBy(string $column, string $value)  :   Collection
    {
        return QueryBuilder::for(Post::query())
            ->allowedFilters(['name', 'email'])
            ->allowedIncludes(['posts', 'comments'])
            ->allowedSorts(['created_at'])
            ->where($column, '=', $value)
            ->get();
    }

    public function getTrashed()    :   Collection
    {
        return QueryBuilder::for(Post::query())
            ->allowedFilters(['name', 'email'])
            ->allowedIncludes(['posts', 'comments'])
            ->allowedSorts(['created_at'])
            ->onlyTrashed()
            ->get();
    }

    public function store(array $data) :   User
    {
        return  Post::create($data);
    }

    public function delete($user)    :   bool
    {
        if ($user instanceof User) {
            return  $user::delete();
        }
        $ids    =   is_array($user) ? $user : func_get_args();
        return  Post::whereIn('id', $ids)->delete();
    }

    public function update($user, array $data)  :   bool
    {
        if ($user instanceof User) {
            return $user->update($data);
        }
        $ids    =   is_array($user) ?: [$user];
        return  Post::whereIn('id', $ids)->update($data);
    }
}
