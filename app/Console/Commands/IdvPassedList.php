<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\CheckSetupController;

class IdvPassedList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'idvpassedlist:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'PaySprint idv passed users list';

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

        $checkSetup->idvPassedList();

        $this->info("PaySprint idv passed users list completed successfully");
    }
}
