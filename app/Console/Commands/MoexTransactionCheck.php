<?php

namespace App\Console\Commands;

use App\Http\Controllers\MoexController;
use Illuminate\Console\Command;

class MoexTransactionCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'moextransactioncheck:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Moex Transaction Checker';

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
        $checkSetup = new MoexController();

        $checkSetup->paymentConfirmation();

        $this->info("Moex Transaction Checker completed successfully");
    }
}
