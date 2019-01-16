<?php

namespace App\Repositories;

use DB;
use Throwable;
use App\Models\Chat;
use App\Models\User;
use App\Models\Chat as Ticket;
use Spatie\QueryBuilder\QueryBuilder;
use App\Repositories\Facades\UserRepo;

class TicketRepository extends BaseRepository
{
    public function getAll()
    {
        return QueryBuilder::for(Ticket::class)
            ->allowedFields('type', 'attribute')
            ->allowedFilters('title', 'category_id')
            ->allowedSorts('created_at', 'updated_at')
            ->allowedIncludes('users', 'comments', 'comments.media')
            ->where('type', '=', enum('chat.type.ticket'));
    }

    public function getByUser($user)
    {
        $user = $user instanceof User ? $user : UserRepo::find($user);

        if ($user === null) {
            return;
        }

        return $user->tickets()->with(['users', 'comments', 'comments.media'])->get();
    }

    public function getByCategory(int $categoryId)
    {
        return Ticket::where('attribute->category_id', '=', $categoryId)->get();
    }

    public function getByTitle(string $title)
    {
        return Ticket::where('attribute->title', '=', $title)->get();
    }

    public function create(array $comment)
    {
        try {
            return DB::transaction(function () use ($comment) {
                $chat = auth_user()->chats()->create([
                    'type'      => enum('chat.type.ticket'),
                    'attribute' => json_encode([
                        'title'         =>  $comment['title'],
                        'category_id'   =>  $comment['category_id'],
                    ]),
                ]);
                $chat->users()->attach(0);
                $this->storeComment($chat, $comment);

                return $chat;
            });
        } catch (Throwable $throwable) {
            return 0;
        }
    }

    public function storeComment(Chat $chat, array $comment)
    {
        try {
            $comment = $chat->comments()->create([
                'body'      =>  $comment['body'],
                'user_id'   =>  auth_user()->id,
            ]);

            if (request()->hasFile('file')) {
                $comment->addMediaFromRequest('file')->toMediaCollection();
            }

            return $comment;
        } catch (Throwable $throwable) {
            return 0;
        }
    }
}
