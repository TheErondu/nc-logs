<?php

namespace App\Listeners;

use App\Mail\LogEditedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class LogEditedEventListener
{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)

    {
       $email = $event->details['email'];
         Mail::to($email)->send(new LogEditedMail($event->details));
    }
}
