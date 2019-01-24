<?php

use App\Models\Chat;
use App\Models\User;
use Illuminate\Database\Seeder;

class TicketTableSeeder extends Seeder
{
    public function run()
    {
        Chat::insert(factory(Chat::class, 1000)->states('ticket')->make([
            'attribute' => json_encode(['title' => str_random()]),
        ])->toArray());

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
        }
        DB::table('chat_users')->insert($sql);
    }
}
