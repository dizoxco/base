<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Repositories\Facades\PostRepo;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        return PostResource::collection( PostRepo::getAll() );
    }

    public function show(Post $post)
    {
        return new PostResource($post);
    }
}
