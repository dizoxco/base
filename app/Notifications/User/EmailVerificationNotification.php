<?php

namespace App\Notifications\User;

use Auth;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Mail\User\EmailVerificationMailable;

class EmailVerificationNotification extends Notification
{
    use Queueable;

    /** @var User|null $user */
    private $user;

    /** @var string $token */
    private $token;

    public function __construct(string $token, User $user = null)
    {
        $this->user = $user === null ? Auth::user() : $user;
        $this->token = $token;
    }

    public function via()
    {
        return ['mail'];
    }

    public function toMail()
    {
        return new EmailVerificationMailable($this->token, $this->user);
    }
}
