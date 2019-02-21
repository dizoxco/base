<?php

namespace App\Mail\User;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserStoreMailable extends Mailable
{
    use Queueable, SerializesModels;

    /** @var User */
    public $user;

    public function __construct(User $user)
    {
        //
        $this->user = $user;
    }

    public function build()
    {
        return $this->view('email.user.store')
            ->to($this->user->email)
            ->subject('ثبت نام');
    }
}
