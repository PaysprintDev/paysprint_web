<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\CheckSetupController;

class NumberOfWithdrawalsForMerchant extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'numberofwithdrawalsformerchant:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'PaySprint number of withdrawals for merchant';

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

        $checkSetup->updateMerchantNumberofWithdrawal();

        $this->info("PaySprint number of withdrawals for merchant completed successfully");
    }
}
