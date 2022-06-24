<?php

namespace App\Mail;

use App\Enquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EnquirySent extends Mailable
{
    use Queueable, SerializesModels;

    protected $theme = 'my-theme';
    public $enquiry;

    public function __construct(Enquiry $enquiry)
    {
        $this->enquiry = $enquiry;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.enquiry_sent');
    }
}
