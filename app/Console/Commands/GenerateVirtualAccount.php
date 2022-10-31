<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\CheckSetupController;

class GenerateVirtualAccount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generatevirtualaccount:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'PaySprint generate virtual account for users in Nigeria';

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

        $checkSetup->flutterwaveVirtualAccountGenerate();

        $this->info("PaySprint generate virtual account for users in Nigeria completed successfully");
    }
}
