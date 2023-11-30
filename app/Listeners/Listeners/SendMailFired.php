<?php
namespace App\Listeners;
use App\Events\SendMail;
use App\Models\User ;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Support\Facades\Mail;
class SendMailFired
{
    public function __construct()
    {

    }
    public function handle(SendMail $event)
    {
        $user = User::find($event->userId)->toArray();
        Mail::send('dashboard.mail.recordUpdated', $user, function($message) use ($user) {
            $message->to($user['email']);
            $message->subject('Event Testing');
        });
    }
}
