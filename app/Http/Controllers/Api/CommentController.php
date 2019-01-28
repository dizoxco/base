<?php

namespace App\Http\Controllers\Api;

use App\Models\Comment;
use App\Http\Controllers\Controller;
use App\Http\Resources\EffectedRows;
use App\Http\Resources\CommentCollection;
use App\Repositories\Facades\CommentRepo;

class CommentController extends Controller
{
    public function index()
    {
        return new CommentCollection(CommentRepo::getAll());
    }

    public function restore($comment)
    {
        return new EffectedRows(CommentRepo::restore($comment));
    }

    public function delete(Comment $comment)
    {
        return new EffectedRows(CommentRepo::delete($comment));
    }

    public function destroy(Comment $comment)
    {
        return new EffectedRows(CommentRepo::destroy($comment));
    }
}
