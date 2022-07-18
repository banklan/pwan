<?php

namespace App\Jobs;

use App\Newsletter;
use App\NewsletterUser;
use App\Mail\SendNewsletter;
use Illuminate\Bus\Queueable;
use App\Mail\PwanPlatinumNewsletter;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendNewsletterJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $newsletter;

    public function __construct(Newsletter $newsletter)
    {
        $this->newsletter = $newsletter;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // send mail to all subscribers
        $subscribers = NewsletterUser::all();

        // $newsletter = new SendNewsletter($this->newsletter);
        foreach($subscribers as $sub){
            $newsletter = new PwanPlatinumNewsletter($this->newsletter, $sub);
            Mail::to($sub->email)->send($newsletter);
        }

        // foreach($subscribers as $sub){
        // }
    }
}
