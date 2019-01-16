<?php

namespace App\Http\Controllers\Api;

use App\Models\MediaGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MediaGroupController extends Controller
{
    public function show(MediaGroup $medium)
    {
        return $medium->getMedia('media_group_'.$medium->name);
    }

    public function store(Request $request, MediaGroup $medium)
    {
        $medium->addMediaFromRequest('media')->toMediaCollection('media_group_'.$medium->name);
    }
}
