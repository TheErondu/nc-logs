<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class LogSubmittedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $details;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()

    {
        $from = env('MAIL_FROM_ADDRESS');
        $user = $this->details['user'];
        $model = $this->details['model'];
        $cc = $this->details['cc_emails'];
        return $this->from($from)
        ->subject($user.' has added a new entry to the '.$model.'!')
        ->cc($cc)
        ->markdown('mail.LogSubmittedMail');
    }
}
