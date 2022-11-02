<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class RunQueue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mailqueue:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Laravel command to run queue for mail';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Artisan::call('queue:work --tries=2 --timeout=60 --stop-when-empty');
        $this->info("Queue work done!");
    }
}
