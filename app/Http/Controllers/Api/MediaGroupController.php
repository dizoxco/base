<?php

namespace App\Http\Controllers\Api;

use App\Models\MediaGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MediaCollection;
use App\Http\Resources\MediaResource;
use App\Http\Resources\MediaGroupCollection;

class MediaGroupController extends Controller
{
    public function index()
    {
        return new MediaGroupCollection(MediaGroup::all());
    }

    public function show(MediaGroup $medium)
    {
        return new MediaCollection($medium->getMedia($medium->name));
    }

    public function store(Request $request, MediaGroup $medium)
    {
        return new MediaResource($medium->addMediaFromRequest('media')->toMediaCollection($medium->name));
    }
}
