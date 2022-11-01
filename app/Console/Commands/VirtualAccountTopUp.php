<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\CheckSetupController;

class VirtualAccountTopUp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'virtualaccounttopup:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'PaySprint virtual account top up';

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

        $checkSetup->getAllTransactionTransfers();

        $this->info("PaySprint virtual account top up completed successfully");
    }
}
