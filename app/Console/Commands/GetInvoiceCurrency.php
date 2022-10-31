<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\CheckSetupController;

class GetInvoiceCurrency extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'getinvoicecurrency:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'PaySprint get invoice currency';

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

        $checkSetup->updateImportExcelCurrency();

        $this->info("PaySprint get invoice currency completed successfully");
    }
}
