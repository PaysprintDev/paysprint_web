<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\CheckSetupController;

class ApprovedUsersMove extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'approvedusersmove:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'PaySprint move approved users...';

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

        $checkSetup->approvedUsersAccount();

        $this->info("PaySprint move approved users completed successfully");
    }
}
