<?php


namespace App\Traits;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\MonerisActivity as MonerisActivity;


trait PaymentGateway{

    public function keepRecord($transaction_id, $message, $activity, $gateway, $country){
        $data = MonerisActivity::insert([

            'transaction_id' => $transaction_id,
            'message' => $message,
            'activity' => $activity,
            'gateway' => $gateway,
            'country' => $country,
        ]);


    }
    

    

}