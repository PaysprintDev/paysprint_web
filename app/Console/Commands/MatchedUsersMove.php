<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\CheckSetupController;

class MatchedUsersMove extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'matchedusersmove:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'PaySprint matched users account';

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

        $checkSetup->matchedUsersAccount();

        $this->info("PaySprint matched users account completed successfully");
    }
}
