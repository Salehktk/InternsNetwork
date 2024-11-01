<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use File;

class ClearLog extends Command
{
    // Define the command name and description
    protected $signature = 'log:clear';
    protected $description = 'Clear the Laravel application log file';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Get the path to the log file
        $logPath = storage_path('logs/laravel.log');

        // Clear the log file if it exists
        if (File::exists($logPath)) {
            File::put($logPath, '');
            $this->info('Laravel log file has been cleared!');
        } else {
            $this->error('Log file does not exist.');
        }
    }
}
