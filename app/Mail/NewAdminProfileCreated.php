<?php

namespace App\Mail;

use App\Admin;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewAdminProfileCreated extends Mailable
{
    use Queueable, SerializesModels;

    protected $theme = 'my-theme';
    public $admin;

    public function __construct(Admin $admin)
    {
        $this->$admin = $admin;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.new_admin_profile_has_been_created');
    }
}
