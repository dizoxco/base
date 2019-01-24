<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\MediaCollection;
use App\Http\Resources\MediaGroupCollection;
use App\Models\MediaGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MediaGroupController extends Controller
{
    public function index()
    {
        return new MediaGroupCollection(MediaGroup::all());
    }
    public function show(MediaGroup $medium)
    {
        return new MediaCollection($medium->getMedia('media_group_'.$medium->name));
    }

    public function store(Request $request, MediaGroup $medium)
    {
        $medium->addMediaFromRequest('media')->toMediaCollection('media_group_'.$medium->name);
    }
}
