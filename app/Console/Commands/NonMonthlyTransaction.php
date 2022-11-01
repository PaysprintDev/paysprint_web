<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\CheckSetupController;

class NonMonthlyTransaction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nonmonthlytransaction:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'PaySprint non monthly transaction statement completed successfully';

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

        $checkSetup->nonMonthlyTransactionHistory();

        $this->info("PaySprint non monthly transaction statement completed successfully");
    }
}
