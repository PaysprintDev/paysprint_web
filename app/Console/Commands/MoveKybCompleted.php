<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\CheckSetupController;

class MoveKybCompleted extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'movekybcompleted:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'PaySprint move completed kyb';

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

        $checkSetup->moveKYBCompleted();

        $this->info("PaySprint move completed kyb completed successfully");
    }
}
