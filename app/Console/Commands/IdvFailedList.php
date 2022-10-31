<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\CheckSetupController;

class IdvFailedList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'idvfailedlist:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'PaySprint idv failed users list';

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

        $checkSetup->idvFailedList();

        $this->info("PaySprint idv failed users list completed successfully");
    }
}
