<?php

namespace App\Notifications\Variation;

use App\Models\User;
use Illuminate\Notifications\Notification;

class VariationBecomeUnavailable extends Notification
{
    public function via()
    {
        return ['database'];
    }

    public function toDatabase(User $user)
    {
        return [
            'message' => "Dear user $user->fullname, the variation you want now became unavailable.",
        ];
    }
}
