<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\CheckSetupController;

class ReportStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reportstatus:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'PaySprint report status';

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

        $checkSetup->reportStatus();

        $this->info("PaySprint report status completed successfully");
    }
}
