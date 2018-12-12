<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ChatCollection;
use App\Http\Resources\ChatResource;
use App\Http\Resources\DBResource;
use App\Models\Chat;
use App\Repositories\Facades\ChatRepo;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        return new ChatCollection(ChatRepo::getByUser(auth_user()));
    }

    public function store(Request $request)
    {
        $createdChat = ChatRepo::create($request->all());

        if ($createdChat === 0) {
            return new DBResource($createdChat);
        }

        return new ChatResource($createdChat);
    }

    public function show(Chat $chat)
    {
        return new ChatResource($chat->load(['comments', 'comments.media']));
    }

    public function update(Request $request, Chat $chat)
    {
        $createdComment = ChatRepo::storeComment($chat, $request->all());

        if ($createdComment === 0) {
            return new DBResource(0);
        }

        return new ChatResource($createdComment);
    }
}
