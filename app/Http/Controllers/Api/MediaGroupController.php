<?php

namespace App\Http\Controllers\Api;

use App\Models\MediaGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Facades\MediaGroupRepo;

class MediaGroupController extends Controller
{
    public function show(MediaGroup $medium)
    {
        return $medium->getMedia();
    }

    public function store(Request $request, MediaGroup $medium)
    {
        $medium->addMediaFromRequest('avatar')->toMediaCollection();
    }
}
