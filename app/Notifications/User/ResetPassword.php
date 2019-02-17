<?php

namespace App\Notifications\User;

use App\Channels\SMSChannel;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPassword extends Notification
{
    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;

    /**
     * Create a notification instance.
     *
     * @param  string  $token
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's channels.
     *
     * @param  mixed  $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        if (request()->has('mobile')) {
            return SMSChannel::class;
        }
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('You are receiving this email because we received a password reset request for your account.')
            ->action($this->token, url(config('app.url').route('password.token.get')))
            ->line('If you did not request a password reset, no further action is required.');
    }

    public function toSMS($notifiable)
    {
        return [
            'parameters' => [
                'VerificationCode' => $this->token
            ],
            'template_id' => 5561,
        ];
    }
}
