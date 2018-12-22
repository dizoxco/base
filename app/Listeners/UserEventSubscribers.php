<?php

namespace App\Listeners;

use App\Events\User\MadeOrderEvent;
use App\Events\User\UserStoreEvent;
use App\Notifications\User\UserStoreNotification;

class UserEventSubscribers
{
    public function onUserStore(UserStoreEvent $event)
    {
        $event->user->notify(new UserStoreNotification($event->user));
    }

    public function subscribe($event)
    {
        $event->listen(
            UserStoreEvent::class,
            self::class.'@onUserStore'
        );
    }
}
