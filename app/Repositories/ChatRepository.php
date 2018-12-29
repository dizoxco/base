<?php

namespace App\Repositories;

use DB;
use Throwable;
use App\Models\Chat;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Collection;
use App\Repositories\Facades\UserRepo;

class ChatRepository extends BaseRepository
{
    public function getByUser($user) : Collection
    {
        $user = $user instanceof User ? $user : UserRepo::find($user);

        if ($user === null) {
            return collect();
        }

        $exceptSelfUser = function ($query) use ($user) {
            $query->whereNotIn('user_id', [$user->id]);
        };

        return $user->chats()->with(['users' =>  $exceptSelfUser, 'comments'])->get();
    }

    public function create(array $comment) : ?Chat
    {
        try {
            return DB::transaction(function () use ($comment) {
                if (auth_user()->hasChatWith($comment['user_id'])) {
                    $chat = auth_user()->getChatWith($comment['user_id']);
                } else {
                    $chat = auth_user()->chats()->create(['type' => enum('chat.type.chat')]);
                    $chat->users()->attach($comment['user_id']);
                }

                $this->storeComment($chat, $comment);

                return $chat;
            });
        } catch (Throwable $throwable) {
            return null;
        }
    }

    public function storeComment(Chat $chat, array $comment) : ?Comment
    {
        try {
            return DB::transaction(function () use ($chat, $comment) {
                $comment = $chat->comments()->create([
                    'body'      =>  $comment['body'] ?? null,
                    'user_id'   =>  auth_user()->id,
                ]);

                if (request()->hasFile('file')) {
                    $comment->addMediaFromRequest('file')->toMediaCollection();
                }

                return $comment;
            });
        } catch (Throwable $throwable) {
            return null;
        }
    }
}
