<?php

namespace App\Mail\User;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailVerificationMailable extends Mailable
{
    use Queueable, SerializesModels;

    /** @var User $user */
    public $user;

    /** @var string $token */
    private $token;

    public function __construct(string $token, User $user)
    {
        $this->user = $user;
        $this->token = $token;
    }

    public function build()
    {
        return $this->view('email.user.verification')
            ->with('token', $this->token)
            ->to($this->user->email)
            ->subject('تایید ایمیل');
    }
}
