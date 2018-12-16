<?php

namespace App\Notifications\User;

use App\Models\User;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OnUserStore extends Notification
{
    public function via()
    {
        return ['mail'];
    }

    public function toMail(User $user)
    {
        return (new MailMessage)
            ->subject('ثبت نام با موفقیت انجام شد')
            ->from('noreply@larabase.dev', 'Mohammad akbari')
            ->greeting('به Larabase خوش آمدید')
            ->line($user->full_name.'عزیز برای فعالسازی حساب کاربری خود روی دکمه زیر کلیک کنید.')
            ->action('فعالسازی حساب کاربری', route('api.auth.activate', $user->activation_token))
            ->line('از شما برای استفاده از خدمات ما متشکریم!');
    }
}
