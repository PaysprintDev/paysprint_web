<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\SendGridController;

class RewardPoint extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rewardpoint:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'PaySprint reward point';

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
        $checkSetup = new SendGridController();

        $checkSetup->cronToCustomersOnRewardStatement();

        $this->info("PaySprint reward point completed successfully");
    }
}
