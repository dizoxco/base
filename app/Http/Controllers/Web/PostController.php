<?php

namespace App\Http\Controllers\Web;

use App\Models\Tag;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Facades\PostRepo;

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
        $recent = PostRepo::getRecents();

        return view('posts.show', compact('post', 'recent'));
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
