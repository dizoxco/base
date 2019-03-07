<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Http\Controllers\Controller;
use App\Http\Resources\EffectedRows;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostCollection;
use App\Repositories\Facades\PostRepo;
use Illuminate\Database\QueryException;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Comment\StoreCommentRequest;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    public function index()
    {
        return new PostCollection(PostRepo::getAll([
            'with'  =>  ['user'],
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

        /** @var Post $createdPost */
        $createdPost = PostRepo::create($request->all());
        if ($createdPost === 0) {
            return new EffectedRows($createdPost);
        }

        $messageBag = [];
        if ($request->has('banner')) {
            try {
                $createdPost
                    ->mediaRelation()
                    ->wherePivot('collection_name', '=', 'banner')
                    ->sync(
                        array_fill_keys(
                            array_wrap($request->input('banner')),
                            ['collection_name'  =>  'banner']
                        )
                    );
            } catch (QueryException $exception) {
                $messageBag['banner'] = "Post {$createdPost->title} created without banner.";
            }
        }

        if ($request->has('attach')) {
            try {
                $createdPost
                    ->mediaRelation()
                    ->wherePivot('collection_name', '=', 'attach')
                    ->sync(
                        array_fill_keys(
                            array_wrap($request->input('attach')),
                            ['collection_name'  =>  'attach']
                        )
                    );
            } catch (QueryException $exception) {
                $messageBag['banner'] = "Post {$createdPost->title} created without some attachments.";
            }
        }

        if ($request->filled('tags')) {
            $createdPost->tags()->sync($request->tags);
        }

        $resource = new PostResource($createdPost);

        return empty($messageBag) ? $resource : $resource->additional($messageBag);
    }

    public function show(Post $post)
    {
        return new PostResource($post);
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $updatedPost = PostRepo::update($post, $request->all());
        if ($updatedPost === 0) {
            return new EffectedRows($updatedPost);
        }

        $messageBag = [];
        if ($request->has('banner')) {
            try {
                $post
                    ->mediaRelation()
                    ->wherePivot('collection_name', '=', 'banner')
                    ->sync(
                        array_fill_keys(
                            array_wrap($request->input('banner')),
                            ['collection_name'  =>  'banner']
                        )
                    );
            } catch (QueryException $exception) {
                $messageBag['banner'] = "Post {$updatedPost->title} updated without banner.";
            }
        }

        if ($request->has('attach')) {
            try {
                $post
                    ->mediaRelation()
                    ->wherePivot('collection_name', '=', 'attach')
                    ->sync(
                        array_fill_keys(
                            array_wrap($request->input('attach')),
                            ['collection_name'  =>  'attach']
                        )
                    );
            } catch (QueryException $exception) {
                $messageBag['banner'] = "Post {$post->title} updated without some attachments.";
            }
        }

        if ($request->filled('tags')) {
            $post->tags()->sync($request->tags);
        }

        $resource = new PostResource($post);

        return empty($messageBag) ? $resource : $resource->additional($messageBag);
    }

    public function delete(Post $post)
    {
        return (new EffectedRows(PostRepo::delete($post)))->response()->setStatusCode(Response::HTTP_OK);
    }

    public function restore(string $post)
    {
        return new EffectedRows(PostRepo::restore($post));
    }

    public function destroy(string $post)
    {
        return new EffectedRows(PostRepo::destroy($post));
    }

    public function storeComment(Post $post, StoreCommentRequest $request)
    {
        return new EffectedRows(PostRepo::storeComment($post, $request->all()));
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
