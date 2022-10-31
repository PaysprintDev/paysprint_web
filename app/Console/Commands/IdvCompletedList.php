<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\CheckSetupController;

class IdvCompletedList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'idvcompletedlist:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'PaySprint idv completed users list';

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

        $checkSetup->idvCompletedList();

        $this->info("PaySprint idv completed users list completed successfully");
    }
}
