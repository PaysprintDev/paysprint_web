<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\CheckSetupController;

class AutoDepositOff extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'autodepositoff:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'PaySprint check for auto deposit users';

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

        $checkSetup->autoDepositOff();

        $this->info("PaySprint auto deposit completed successfully");
    }
}
