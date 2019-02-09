<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use App\Events\User\UserStoreEvent;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Authenticated;
use App\Notifications\User\UserStoreNotification;

class UserEventSubscribers
{
    public function subscribe($event)
    {
        $event->listen(UserStoreEvent::class, self::class.'@onUserStore');
        $event->listen(Authenticated::class, self::class.'@onUserLoggedIn');
        $event->listen(Login::class, self::class.'@onUserLoggedIn');
        $event->listen(Registered::class, self::class.'@onUserLoggedIn');
    }

    public function onUserStore(UserStoreEvent $event)
    {
        $event->user->notify(new UserStoreNotification($event->user));
    }

    public function onUserLoggedIn($event)
    {
        $this->moveCartFromCookieToDatabase($event->user);

        $this->moveWishlistFromCookieToDatabase($event->user);
    }

    private function moveCartFromCookieToDatabase($user)
    {
        if ($cart = json_decode(\Cookie::get('cart'), true)) {
            foreach ($cart as $variation => $quantity) {
                $user->cart()->updateOrCreate(
                    [
                        'user_id' => Auth::id(),
                        'variation_id' => $variation,
                    ],
                    [
                        'variation_id' => $variation,
                        'quantity' => \DB::raw('quantity + 1'),
                    ]
                );
            }
        }
    }

    private function moveWishlistFromCookieToDatabase($user)
    {
        if ($wishlist = json_decode(\Cookie::get('wishlist'), true)) {
            $user->wishlist()->sync(array_keys($wishlist));
        }
    }
}
