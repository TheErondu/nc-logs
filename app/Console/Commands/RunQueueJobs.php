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
        // Specify the queue connection and name if needed
        $queueConnection = 'database';
        $queueName = 'default';

        // Log output and errors
        $outputFile = 'storage/logs/queue.log';
        $errorFile = 'storage/logs/queue-error.log';

        // Run the queue worker in daemon mode
        Artisan::call("queue:work --daemon --queue={$queueName} --connection={$queueConnection} > {$outputFile} 2> {$errorFile}");
    }
}
