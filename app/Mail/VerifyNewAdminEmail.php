<?php

namespace App\Mail;

use App\Admin;
use App\AdminEmailVerification;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class VerifyNewAdminEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $theme = 'my-theme';

    public $user;
    public $conf;
    public $url;

    public function __construct(Admin $user, AdminEmailVerification $conf, $url)
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
        return $this->markdown('emails.staff_email_verification_mail')
                    ->from('pwanplatinumwarri@gmail.com');
    }
}
