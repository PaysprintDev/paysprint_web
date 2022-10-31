<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\CheckSetupController;

class IdvNotificationMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'idvnotificationmessage:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'PaySprint idv notification message';

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

        $checkSetup->idvNotifationMessage();

        $this->info("PaySprint idv notification message completed successfully");
    }
}
