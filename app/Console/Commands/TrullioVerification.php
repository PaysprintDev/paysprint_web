<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\CheckSetupController;

class TrullioVerification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trullioverification:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'PaySprint trullio verification';

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

        $checkSetup->checkTrullioVerification();

        $this->info("PaySprint trullio verification completed successfully");
    }
}
