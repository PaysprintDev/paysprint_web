<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\SendGridController;

class MailForVirtualAccount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mailtovirtualaccount:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'PaySprint send cron to consumers on virtual account';

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

        $checkSetup->cronToCustomersOnVirtualAccount();

        $this->info("PaySprint send cron to consumers on virtual account completed successfully");
    }
}
