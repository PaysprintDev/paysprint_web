<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\MaintenanceFeeCharge;

class RenewSub extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'renewsub:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'PaySprint renew subscription';

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
        $checkSetup = new MaintenanceFeeCharge();

        $checkSetup->renewSubscription();

        $this->info("PaySprint renew subscription completed successfully");
    }
}
