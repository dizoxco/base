<?php

use App\Models\Chat;

$factory->define(Chat::class,function () {
    return ['type'  =>  enum('chat.type.chat'),];
});

$factory->state(Chat::class, 'ticket', function () {
    return ['type'  =>  enum('chat.type.ticket'),];
});