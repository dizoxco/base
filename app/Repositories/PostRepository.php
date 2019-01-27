<?php

namespace App\Repositories;

use Throwable;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;

class PostRepository extends BaseRepository
{
    public function find(int $id)   :   ?Post
    {
        return Post::find($id);
    }

    public function findByTitle(string $title)  :   ?Post
    {
        return Post::whereTitle($title)->first();
    }

    public function searchBy(array $columns, string $value) :   Collection
    {
        $builder = Post::query();
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
        $posts = QueryBuilder::for(Post::query())
            ->allowedFilters(['title', 'slug'])
            ->allowedIncludes(['post', 'comments'])
            ->allowedSorts(['created_at', 'updated_at', 'deleted_at', 'published_at']);
        $this->applyParams($posts, $params);

        return $posts->get();
    }

    public function getRecents($number = 10): Collection
    {
        return Post::take($number)->latest()->get();
    }

    public function getBy(string $column, string $value)  :   Collection
    {
        return QueryBuilder::for(Post::query())
            ->allowedFilters(['title', 'slug'])
            ->allowedIncludes(['post', 'comments'])
            ->allowedSorts(['created_at', 'updated_at', 'deleted_at', 'published_at'])
            ->where($column, '=', $value)
            ->get();
    }

    public function getTrashed()    :   Collection
    {
        return QueryBuilder::for(Post::query())
            ->allowedFilters(['title', 'slug'])
            ->allowedIncludes(['post', 'comments'])
            ->allowedSorts(['created_at', 'updated_at', 'deleted_at', 'published_at'])
            ->onlyTrashed()
            ->get();
    }

    public function create(array $data)
    {
        try {
            return Post::create($data);
        } catch (Throwable $throwable) {
            return 0;
        }
    }

    public function delete($post)
    {
        try {
            if ($post instanceof Post) {
                return  $post->delete();
            }
            $ids = is_array($post) ? $post : func_get_args();

            return  Post::whereIn('id', $ids)->delete();
        } catch (Exception $exception) {
            return 0;
        }
    }

    public function restore($post)
    {
        try {
            if ($post instanceof Post) {
                return  $post->restore();
            }

            $ids = is_array($post) ? $post : func_get_args();

            return  Post::whereIn('id', $ids)->restore();
        } catch (Exception $exception) {
            return 0;
        }
    }

    public function destroy($post)
    {
        try {
            if ($post instanceof Post) {
                return  $post->forceDelete();
            }

            $ids = is_array($post) ? $post : func_get_args();

            return  Post::whereIn('id', $ids)->forceDelete();
        } catch (Exception $exception) {
            return 0;
        }
    }

    public function update($post, array $data)
    {
        try {
            if ($post instanceof Post) {
                return $post->update($data);
            }
            $ids = is_array($post) ?: [$post];

            return  Post::whereIn('id', $ids)->update($data);
        } catch (Exception $exception) {
            return 0;
        }
    }

    public function user(Post $post)    :   User
    {
        return $post->user;
    }

    public function comment(Post $post)   :   Collection
    {
        return $post->comments;
    }


}
