<?php

namespace App\Console\Commands;

use App\Http\Controllers\Controller;
use Illuminate\Console\Command;

class PlatformCurrencyConvert extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'platformcurrencyconverter:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Daily conversion rate from apilayer';

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
        $checkSetup = new Controller();

        $checkSetup->platformcurrencyConvert();


        $this->info("Daily conversion rate from apilayer completed successfully");
    }
}
