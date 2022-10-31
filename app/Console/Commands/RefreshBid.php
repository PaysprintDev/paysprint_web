<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\CurrencyFxController;

class RefreshBid extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'refreshbid:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'PaySprint refresh fx bids';

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
        $checkSetup = new CurrencyFxController();

        $checkSetup->refreshBids();

        $this->info("PaySprint refresh fx bids completed successfully");
    }
}
