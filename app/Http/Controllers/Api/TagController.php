<?php

namespace App\Http\Controllers\Api;

use App\Models\Tag;
use App\Http\Resources\TagResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\EffectedRows;
use App\Http\Resources\TagCollection;
use App\Repositories\Facades\TagRepo;
use App\Http\Requests\Tag\StoreTagRequest;
use App\Http\Requests\Tag\UpdateTagRequest;
use Symfony\Component\HttpFoundation\Response;

class TagController extends Controller
{
    public function index()
    {
        $tags = \App\Models\Taxonomy::with('tags')->get()->pluck('tags')->collapse();
        return new TagCollection($tags);
    }

    public function store(StoreTagRequest $request)
    {
        $createdTag = TagRepo::create($request->all());
        if ($createdTag === null) {
            return new EffectedRows($createdTag);
        }

        return (new TagResource($createdTag))
            ->response()->setStatusCode(Response::HTTP_CREATED);
    }

    public function update(UpdateTagRequest $request, Tag $tag)
    {
        TagRepo::update($tag, $request->all());

        return new TagResource($tag);
    }
}
