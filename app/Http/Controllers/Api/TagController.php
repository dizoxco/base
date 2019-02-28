<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Tag\StoreTagRequest;
use App\Http\Resources\TagCollection;
use App\Models\Tag;
use App\Repositories\Facades\TagRepo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
    public function index()
    {
        return new TagCollection(TagRepo::getAll());
    }

    public function store(StoreTagRequest $request)
    {
//        $createdTag = TagRepo::
        $createdUser = UserRepo::create($data);
        if ($createdUser === 0) {
            return new EffectedRows($createdUser);
        }

        if ($request->hasFile('avatar')) {
            $createdUser->addMediaFromRequest('avatar')->toMediaCollection(enum('media.user.avatar'));
        }

        event(new UserStoreEvent($createdUser));

        return new UserResource($createdUser);
    }

    public function show(Tag $tag)
    {
        //
    }

    public function update(Request $request, Tag $tag)
    {
        //
    }

    public function destroy(Tag $tag)
    {
        //
    }
}
