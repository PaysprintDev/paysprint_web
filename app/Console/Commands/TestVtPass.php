<?php

namespace App\Console\Commands;

use App\Http\Controllers\VTPassController;
use Illuminate\Console\Command;

class TestVtPass extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vtpasstest:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test VTPass Configuration';

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
        $checkStatus = new VTPassController();

        $getBalance = $checkStatus->getBalance();
        $serviceCategory = $checkStatus->getServiceCategories();
        $serviceId = $checkStatus->getByServiceId('tv-subscription');
        $variationCode = $checkStatus->getVariationCodes('gotv');
        $productOption = $checkStatus->getProductOption('dstv', 'DSTV Subscription');

        $data = [
            'getBalance' => $getBalance,
            'serviceCategory' => $serviceCategory,
            'serviceId' => $serviceId,
            'variationCode' => $variationCode,
            'productOption' => $productOption
        ];

        dd($data);

    }
}
