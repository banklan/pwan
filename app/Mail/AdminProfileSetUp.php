<?php

namespace App\Mail;

use App\Admin;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AdminProfileSetUp extends Mailable
{
    use Queueable, SerializesModels;

    protected $theme = 'my-theme';
    public $admin;
    public $url;

    public function __construct(Admin $admin, $url)
    {
        $this->$admin = $admin;
        $this->$url = $url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.admin_profile_has_been_set_up');
    }
}
