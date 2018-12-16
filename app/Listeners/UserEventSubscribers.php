<?php

namespace App\Listeners;

use App\Events\User\MadeOrderEvent;
use App\Events\User\UserStoreEvent;
use App\Notifications\User\OnUserStore;

class UserEventSubscribers
{

    public function onUserStore($event)
    {
        $event->user->notify(new OnUserStore());
    }

    public function subscribe($event)
    {
        $event->listen(
            UserStoreEvent::class,
            self::class.'@onUserStore'
        );
    }
}
