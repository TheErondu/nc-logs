<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketEscalation extends Mailable
implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $issue;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($issue)
    {
        $this->issue = $issue;
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
        ->subject('Ticket  Updated')
        ->cc($this->issue['copy'])
        ->markdown('mail.TicketEscalatedMail');
    }
}
