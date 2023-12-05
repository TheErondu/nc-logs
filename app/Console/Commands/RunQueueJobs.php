<?php

namespace App\Console\Commands;

use Artisan;
use Illuminate\Console\Command;

class RunQueueJobs extends Command
{
    protected $signature = 'app:run-queue-jobs';
    protected $description = 'Run the queue worker to process jobs';

    public function handle()
    {
        // Run the queue worker in daemon mode
        Artisan::call("queue:work");
    }
}
