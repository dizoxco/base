<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Http\Resources\DBResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostCollection;
use App\Repositories\Facades\PostRepo;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Http\Requests\Comment\StoreCommentRequest;

class PostController extends Controller
{
    public function index()
    {
        return new PostCollection(PostRepo::getAll());
    }

    public function store(StorePostRequest $request)
    {
        return new PostResource(PostRepo::create($request->all()));
    }

    public function show(Post $post)
    {
        return new PostResource($post);
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        return new DBResource(PostRepo::update($post, $request->all()));
    }

    public function delete(Post $post)
    {
        return new DBResource(PostRepo::delete($post));
    }

    public function restore(string $post)
    {
        return new DBResource(PostRepo::restore($post));
    }

    public function destroy(string $post)
    {
        return new DBResource(PostRepo::destroy($post));
    }

    public function storeComment(Post $post, StoreCommentRequest $request)
    {
        return new DBResource(PostRepo::storeComment($post, $request->all()));
    }
}
