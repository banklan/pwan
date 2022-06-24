<?php

namespace App\Mail;

use App\User;
use App\PasswordResetRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PasswordResetRequestEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $theme = 'my-theme';

    public $user;
    public $req;

    public function __construct(User $user, PasswordResetRequest $req)
    {
        $this->user = $user;
        $this->req = $req;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.password_reset_request');
    }
}
