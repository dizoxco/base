<?php

namespace App\Http\Controllers\Api;

use App\Models\MediaRelation;
use App\Models\Post;
use App\Http\Resources\DBResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostCollection;
use App\Repositories\Facades\PostRepo;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Http\Requests\Comment\StoreCommentRequest;
use DB;
use Illuminate\Database\QueryException;

class PostController extends Controller
{
    public function index()
    {
        return new PostCollection(PostRepo::getAll([
            'with'  =>  ['user','comments']
        ]));
    }

    public function store(StorePostRequest $request)
    {
        //  make post's slug unique
        $slug = $this->makeSlug($request->input('slug'));

        $request->merge([
            'slug'      =>  $slug,
            'user_id'   =>  auth_user()->id,
        ]);

        $createdPost    =   PostRepo::create($request->all());
        if (is_int($createdPost)) {
            return new DBResource($createdPost);
        }

        if ($request->hasFile('banner')) {
            $createdPost->addMediaFromRequest('banner')->toMediaCollection(enum('media.post.banner'));
        }
        if ($request->has('attach')) {
            try {
                $createdPost->mediaGroup()->sync($request->input('attach'));
            } catch (QueryException $exception) {
                return (new PostResource($createdPost))->additional([
                    'messages'  =>  "Post {$createdPost->title} has been created, but without some attachments."
                ]);
            }
        }

        return new PostResource($createdPost);
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

    private function makeSlug(string $slug)
    {
        $originalSlug = $slug;
        $slug = Post::select('slug')
            ->where('slug', 'like', "$originalSlug%")
            ->orderBy('slug', 'desc')
            ->first('slug');

        if ($slug === null) {
            return $originalSlug;
        } else {
            $slug = $slug->slug;
            $slug++;
            return $this->makeSlug($slug);
        }
    }
}
