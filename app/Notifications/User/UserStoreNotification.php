<?php

namespace App\Notifications\User;

use App\Mail\User\UserStoreMailable;
use App\Models\User;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserStoreNotification extends Notification
{
    /** @var User $user*/
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function via()
    {
        return ['mail'];
    }

    public function toMail()
    {
        return new UserStoreMailable($this->user);
    }
}
