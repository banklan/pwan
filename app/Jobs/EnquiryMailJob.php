<?php

namespace App\Jobs;

use App\Admin;
use App\Enquiry;
use App\Mail\EnquirySent;
use App\Mail\EnquiryReceived;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class EnquiryMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $enquiry;

    public function __construct(Enquiry $enquiry)
    {
        $this->enquiry = $enquiry;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $sent_email = new EnquirySent($this->enquiry);
        $rcvd_email = new EnquiryReceived($this->enquiry);

        // send mail to sender
        Mail::to($this->enquiry['email'])->send($sent_email);

        //send mail with enquiry to homas
        Mail::to('pwanplatinumwarri@gmail.com')->send($rcvd_email);

        // send mail to all admins
        $admins = Admin::where('status', true)->get();

        foreach ($admins as $admin) {
            Mail::to($admin->email)->send($rcvd_email);
        }
    }
}
