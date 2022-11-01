<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\CheckSetupController;

class UpdateStatementCountry extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'updatestatementcountry:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'PaySprint update statement country';

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

        $checkSetup->statementCountry();

        $this->info("PaySprint update statement country completed successfully");
    }
}
