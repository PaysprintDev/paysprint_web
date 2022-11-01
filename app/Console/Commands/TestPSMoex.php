<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use \App\Traits\Moex;

class TestPSMoex extends Command
{
    use Moex;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'psmoex:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This is to test the PaySprint Moex handshake on SOAP server';

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
        $data = $this->paysprintMoex();

        $this->info($data);
    }
}
