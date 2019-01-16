<?php

namespace App\Channels;

use Exception;
use Illuminate\Notifications\Notification;
use Ipecompany\Smsirlaravel\Smsirlaravel as Smsir;
use Prophecy\Exception\Doubler\MethodNotFoundException;

class SMSChannel
{
    public function send($notifiable, Notification $notification)
    {
        throw_unless(
            method_exists($notification, 'toSMS'),
            new MethodNotFoundException(
                'Notification is missing toSMS method.',
                get_class($notification),
                'toSMS'
            )
        );

        $message = $notification->toSMS($notifiable);

        throw_if(
            ! is_array($message),
            new Exception(
                'Type error: Return value of toSMS() must be of the type array returned '.gettype($message)
            )
        );

        extract($message);
        if (count($message) == 2) {
            if (! $receiver = $notifiable->getAttributeValue('mobile')) {
                if (! $receiver = $notifiable->routeNotificationFor('sms')) {
                    return;
                }
            }

            return Smsir::ultraFastSend(
                $parameters,
                $template_id,
                $receiver
            );
        }

        if (count($message) == 3) {
            return Smsir::ultraFastSend(
                $parameters,
                $template_id,
                $number
            );
        }
    }
}
