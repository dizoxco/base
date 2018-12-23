<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Chat\StoreChatRequest;
use App\Http\Requests\Chat\UpdateChatRequest;
use App\Http\Resources\ChatCollection;
use App\Http\Resources\ChatResource;
use App\Http\Resources\DBResource;
use App\Models\Chat;
use App\Repositories\Facades\ChatRepo;

class ChatController extends Controller
{
    public function index()
    {
        return new ChatCollection(ChatRepo::getByUser(auth_user()));
    }

    public function store(StoreChatRequest $request)
    {
        $createdChat = ChatRepo::create($request->all());

        if ($createdChat == null) {
            return new DBResource($createdChat);
        }

        return new ChatResource($createdChat);
    }

    public function show(Chat $chat)
    {
        $chat->load(['comments', 'comments.media']);
        return new ChatResource($chat);
    }

    public function update(UpdateChatRequest $request, Chat $chat)
    {
        $createdComment = ChatRepo::storeComment($chat, $request->all());

        if ($createdComment === null) {
            return new DBResource(0);
        }

        return new ChatResource($chat->load('users', 'comments', 'comments.media'));
    }
}
