<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\CheckSetupController;

class NumberOfWithdrawals extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'numberofwithdrawals:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'PaySprint number of withdrawals';

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

        $checkSetup->updateNumberofWithdrawal();

        $this->info("PaySprint number of withdrawals completed successfully");
    }
}
