<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPass extends Mailable
implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $newpassword;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($newpassword)
    {
        $this->newpassword = $newpassword;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $engineer_mails = \App\Models\User::where('department_id', '11')->pluck('email');
        return $this->subject('Your Password has been reset!')
                    ->markdown('mail.resetpass');
    }
}
