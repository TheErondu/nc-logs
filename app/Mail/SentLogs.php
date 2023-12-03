<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SentLogs extends Mailable
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
        $engineer_mails = \App\Models\User::where('department_id', '11')->pluck('email');
        //    dd($engineer_mails);
        return $this->subject('Logs Exported Successfully')
                    ->cc($engineer_mails)
                    ->markdown('mail.SentLogs');
    }
}
