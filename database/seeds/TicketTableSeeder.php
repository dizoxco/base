<?php

use App\Models\Chat;
use App\Models\User;

class TicketTableSeeder extends CustomSeeder
{
    public function run()
    {
        parent::execute('tickets');
    }

    protected function createFromConfigFile($tickets)
    {
        $this->create($tickets['amount']);
    }

    protected function createAndSaveToConfigFile()
    {
        $amount = (int) $this->command->ask('How many tickets do you want?', 1);

        $this->create($amount);

        $config_tickets['tickets'] = ['amount' => $amount];

        $this->saveToFile($config_tickets);
    }

    protected function create($amount): void
    {
        Chat::insert(factory(Chat::class, $amount)->states('ticket')->make([
            'attribute' => json_encode(['title' => str_random()]),
        ])->toArray());

        $sql = [];
        $ids = Chat::all(['id']);
        $user_ids = User::pluck('id')->random($amount)->all();
        foreach ($ids as $id) {
            $sql[] = [
                'chat_id' => $id->id,
                'user_id' => array_shift($user_ids),
            ];
            $sql[] = [
                'chat_id' => $id->id,
                'user_id' => enum('chat.responder.organ'),
            ];
        }
        DB::table('chat_users')->insert($sql);
    }
}
