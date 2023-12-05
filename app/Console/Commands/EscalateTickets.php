<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Issue;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\TicketEscalation;

class EscalateTickets extends Command
{
    protected $signature = 'tickets:escalate';
    protected $description = 'Escalate open issues older than 1 hour and notify Head Operations after 24 hours';

    public function handle()
    {
        $issuesToAssignee = Issue::where('status', 'open')
            ->where('created_at', '<', Carbon::now()->subMinutes(1))
            ->get();

        $issuesToAdmin = Issue::where('status', 'open')
            ->where('created_at', '<', Carbon::now()->subMinutes(5))
            ->get();

        foreach ($issuesToAssignee as $issue) {
            // Perform the escalation action for the assigned user
            $this->escalateToAssignee($issue);
        }

        foreach ($issuesToAdmin as $issue) {
            // Perform the escalation action for the system admin
            $this->escalateToAdmin($issue);
        }

        $this->info('Ticket escalation completed.');
    }

    protected function escalateToCTO($issue)
    {
        // Perform the escalation action for the assigned user
        $issue->update(['status' => 'escalated']);

        // Send an email to the assigned user
        Mail::to($issue->assigned_user_email)->send(new TicketEscalation($issue));
    }

    protected function escalateToOperations($issue)
    {
        // Perform the escalation action for the system admin
        // For example, you can log the escalation or perform a specific action

        // Send an email to the system admin (replace 'admin@example.com' with the actual admin email)
        Mail::to('admin@example.com')->send(new TicketEscalation($issue));
    }
}
