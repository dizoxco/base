<?php

namespace App\Repositories;

use App\Models\Comment;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Throwable;

class CommentRepository extends BaseRepository
{
    public function getAll($params = []) : Collection
    {
        $comment = QueryBuilder::for(Comment::query())
            ->allowedFilters(['user_id', 'body', 'commentable_id', 'commentable_type', 'stat'])
            ->allowedSorts(['deleted_at', 'created_at', 'updated_at']);
        $this->applyParams($comment, $params);

        return $comment->get();
    }

    public function getTrashed() : Collection
    {
        return QueryBuilder::for(Comment::query())
            ->allowedFilters(['user_id', 'body', 'commentable_id', 'commentable_type', 'stat'])
            ->allowedSorts(['deleted_at', 'created_at', 'updated_at'])
            ->onlyTrashed()
            ->get();
    }

    public function delete($comment) : ?int
    {
        try {
            if ($comment instanceof Comment) {
                return  $comment->delete();
            }

            $ids = is_array($comment) ? $comment : func_get_args();

            return  Comment::whereIn('id', $ids)->delete();
        } catch (Throwable $throwable) {
            return null;
        }
    }

    public function restore($comment) : ?int
    {
        try {
            if ($comment instanceof Comment) {
                return  $comment->restore();
            }

            $ids = is_array($comment) ? $comment : func_get_args();

            return  Comment::whereIn('id', $ids)->restore();
        } catch (Throwable $throwable) {
            return null;
        }
    }

    public function destroy($comment) : ?int
    {
        try {
            if ($comment instanceof Comment) {
                return  $comment->forceDelete();
            }

            $ids = is_array($comment) ? $comment : func_get_args();

            return Comment::whereIn('id', $ids)->forceDelete();
        } catch (Throwable $throwable) {
            return null;
        }
    }    
}