<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\CheckSetupController;

class PublishArchive extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'publisharchive:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'PaySprint publish archive users';

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

        $checkSetup->publishArchiveUsers();

        $this->info("PaySprint publish archive users completed successfully");
    }
}
