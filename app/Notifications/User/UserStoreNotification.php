<?php

namespace App\Notifications\User;

use App\Models\User;
use App\Channels\SMSChannel;
use App\Mail\User\UserStoreMailable;
use Illuminate\Notifications\Notification;

class UserStoreNotification extends Notification
{
    /** @var User $user */
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function via()
    {
        if ($this->user->mobile) {
            return [SMSChannel::class];
        }

        return ['mail'];
    }

    public function toMail()
    {
        return new UserStoreMailable($this->user);
    }

    public function toSMS()
    {
        return [
            'parameters' => [
                'VerificationCode' => explode('_', $this->user->activation_token)[1],
            ],
            'template_id' => 5561,
        ];
    }
}
