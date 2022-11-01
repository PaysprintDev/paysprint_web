<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\CheckSetupController;

class MonthlyTransaction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monthlytransaction:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'PaySprint monthly transaction';

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

        $checkSetup->monthlyTransactionHistory();

        $this->info("PaySprint monthly transaction completed successfully");
    }
}
