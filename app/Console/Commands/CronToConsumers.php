<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\CheckSetupController;

class CronToConsumers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crontoconsumer:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run crom mail to consumers';

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
        $checkSetup = new CheckSetupController();

        $checkSetup->cronToConsumers();

        $this->info("PaySprint cron to consumer completed successfully");
    }
}
