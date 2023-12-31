<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\SerializesModels;

class TicketCreated extends Mailable
implements ShouldQueue
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
        return $this->from($from)
        ->subject('New Issue Reported!')
        ->cc($this->details['copy'])
        ->markdown('mail.TicketCreatedMail');
    }
}
