<?php

use App\Models\Chat;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Database\Seeder;

class TicketTableSeeder extends Seeder
{
    public function run()
    {
        $this->insertChats();

        $this->insertChatUsers();
    }

    private function insertChats()
    {
        Chat::insert(factory(Chat::class, 1000)->states('ticket')->make([
            'attribute' => json_encode(['title' => faker('sentence')->first()]),
        ])->toArray());
    }

    private function insertChatUsers()
    {
        $sql = [];
        $ids = Chat::inRandomOrder()->pluck('id')->toArray();
        $user_ids = User::inRandomOrder()->pluck('id')->toArray();
        foreach ($ids as $id) {
            $sql[] = [
                'chat_id' => $id,
                'user_id' => array_shift($user_ids),
            ];
            $sql[] = [
                'chat_id' => $id,
                'user_id' => enum('chat.responder.organ'),
            ];

            $this->insertComment($id);
        }
        DB::table('chat_users')->insert($sql);
    }

    private function insertComment($id)
    {
        $users = [enum('chat.responder.organ'), $id];
        $amount = rand(1, 10);
        while ($amount) {
            $comments[] = factory(Comment::class)->make([
                'commentable_id' => $id,
                'commentable_type' => Chat::class,
                'user_id' => $users[array_rand($users)],
            ])->toArray();
            $amount--;
        }
        Comment::insert($comments);
    }
}
