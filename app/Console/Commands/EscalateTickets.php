<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use App\Models\Issue;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\TicketEscalation;

class EscalateTickets extends Command
{
    protected $signature = 'tickets:escalate';
    protected $description = 'Escalate open issues older than 1 hour to CTO and notify Head Operations after 24 hours';

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
            $this->escalateToCTO($issue);
        }

        foreach ($issuesToAdmin as $issue) {
            // Perform the escalation action for the system admin
            $this->escalateToOperations($issue);
        }

        $this->info('Ticket escalation completed.');
    }

    protected function escalateToCTO($issue)
    {
        // Perform the escalation action for the assigned user
        $issue->update(['status' => 'escalated']);

        $cto = User::role('CTO')->get()->pluck('email');
        Mail::to($cto)->send(new TicketEscalation($issue));
    }

    protected function escalateToOperations($issue)
    {
        // Perform the escalation action for the system admin
        // For example, you can log the escalation or perform a specific action

        // Send an email to the system admin (replace 'admin@example.com' with the actual admin email)
        $operationsTeam = User::permission('recieve top level escalation')->get()->pluck('email');
        Mail::to($operationsTeam)->send(new TicketEscalation($issue));
    }
}
