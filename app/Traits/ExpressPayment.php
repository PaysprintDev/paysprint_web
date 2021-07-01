<?php

namespace App\Traits;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Mail;

use App\User as User;

use App\ListOfBanks as ListOfBanks;

use App\Mail\sendEmail;

use Twilio\Rest\Client;


trait ExpressPayment{

    public $url;
    public $curlPost;

    // Get Vendors
    public function getVendors(){
        $this->url = env('EXPRESS_PAY_ENDPOINT_URL').'/billersandproductandfields';

        try {
            $data = $this->doGet();
            return $data;
        } catch (\Throwable $th) {

            return [];
        }


        
    }


    public function getUtilityProduct($id){
        $this->url = env('EXPRESS_PAY_ENDPOINT_URL').'/productfields/'.$id;

        try {
            $data = $this->doGet();
            return $data;
        } catch (\Throwable $th) {

            return [];
        }


        
    }


    // Process Transaction
    public function processTransaction($postRequest){
        $this->url = env('EXPRESS_PAY_ENDPOINT_URL').'/process-transaction';

        $this->curlPost = json_encode([
            'billerCode' => '',
            'productId' => 1,
            'transDetails' => [
                [
                    'fieldName' => '',
                    'fieldValue' => '',
                    'fieldControlType' => '',
                ]
                
            ],
        ]);

        
        $data = $this->doPost();
    }

    public function doGet(){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $this->url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'webkey: '.env('EXPRESS_PAY_WEBKEY'),
            'Authorization: Basic '.env('EXPRESS_PAY_BASIC')
        ),
        ));

        $response = curl_exec($curl);


        curl_close($curl);

        return json_decode($response);
        
    }

    public function doPost(){
        
        
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $this->url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>$this->curlPost,
        CURLOPT_HTTPHEADER => array(
            'webkey: '.env('EXPRESS_PAY_WEBKEY'),
            'accountid: '.env('EXPRESS_PAY_ACCOUNTID'),
            'Authorization: Basic '.env('EXPRESS_PAY_BASIC')
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response);
    }

}






