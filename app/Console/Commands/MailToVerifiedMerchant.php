<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MailToVerifiedMerchant extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mailtoverfiedmerchants:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mail to Verified Merchants';

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
         $checkSetup = new SendgridController();

        $checkSetup->claimBusiness();

        $this->info("Mail to Verified Merchants completed successfully");
    }
}
