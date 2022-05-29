<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\StaffEmailVerification;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class StaffEmailVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $conf;
    public $url;

    public function __construct(User $user, StaffEmailVerification $conf, $url)
    {
        $this->user = $user;
        $this->conf = $conf;
        $this->url = $url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.staff_email_verification_mail');
    }
}
