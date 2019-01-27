<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Tag;
use App\Repositories\Facades\PostRepo;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = PostRepo::getAll(['per_page' => 10]);
        return view('posts.index', compact('posts'));
    }

    public function tags(Tag $tag)
    {
        $posts = $tag->posts()->paginate(10);
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Post $post)
    {
        return view('posts.show')->withPost($post);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
