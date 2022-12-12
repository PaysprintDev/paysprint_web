<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\MoexController;

class MoexPSAllPaid extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'moextopsallpaid:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This is to get the moex to ps all paid transactions';

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
        $checkSetup = new MoexController();

        $start = date('2022-11-28 H:i:s');
        $end = date('Y-m-d H:i:s');


        $checkSetup->getExTransactionMoexPSAllPaid($start, $end);



        $this->info("MOEX to PaySprint All Paid Transactions successfully executed");

    }
}
