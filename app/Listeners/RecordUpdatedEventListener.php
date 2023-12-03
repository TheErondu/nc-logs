<?php

namespace App\Listeners;

use App\Mail\RecordUpdatedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class RecordUpdatedEventListener
//implements ShouldQueue
{
    //
    // public $retries = 5;

    // public $retry_after = 10;
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
         Mail::to($email)->send(new RecordUpdatedMail($event->details));
    }
}
