<?php

namespace App\Traits;

use Illuminate\Http\Request;


use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Mail;

use App\User as User;

use App\Mail\sendEmail;
use Razorpay\Api\Api;

trait Razor{


    public function createPayment($amount, $name, $description){
         
        
        $api = $this->initConfig();

        // Create payment

        $data = [
            'receipt' => 'PSINR_'.time(), 'amount' => $amount, 'currency' => 'INR', 'notes'=> ['name'=> $name,'description'=> $description]];

       $result = $api->order->create($data);


       return $result;

    }

    public function razorPayment($paymentId, $amount){
        $api = $this->initConfig();

        $result = $api->payment->fetch($paymentId)->capture(array('amount'=>$amount,'currency' => 'INR'));;

        return $result;
    }


    public function initConfig(){
        $razor_api_key = env('APP_ENV') == 'local' ? env('RAZOR_PAY_DEV_KEY_ID') : env('RAZOR_PAY_PROD_KEY_ID');

         $razor_api_secret = env('APP_ENV') == 'local' ? env('RAZOR_PAY_DEV_SECRET_KEY') : env('RAZOR_PAY_PROD_SECRET_KEY');

        $config = new Api($razor_api_key, $razor_api_secret);

        return $config;
    }
}