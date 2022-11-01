<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\CheckSetupController;

class RefundByCountryUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'refundbycountryupdate:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'PaySprint refund by country';

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

        $checkSetup->refundbyCountry();

        $this->info("PaySprint refund by country completed successfully");
    }
}
