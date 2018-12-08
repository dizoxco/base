<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    public function users()
    {
        return $this->hasManyThrough(User::class, ChatUser::class);
    }
}
