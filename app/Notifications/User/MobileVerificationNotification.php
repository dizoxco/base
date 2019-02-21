<?php

namespace App\Notifications\User;

use Auth;
use App\Models\User;
use App\Channels\SMSChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class MobileVerificationNotification extends Notification
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
        return [SMSChannel::class];
    }

    public function toSMS()
    {
        return [
            'parameters' => [
                'VerificationCode' => $this->token,
            ],
            'template_id' => 5561,
        ];
    }
}
