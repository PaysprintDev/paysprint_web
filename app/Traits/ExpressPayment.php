<?php

namespace App\Traits;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Mail;

use App\User as User;

use App\EPSVendor as EPSVendor;

use App\PSCharge as PSCharge;

use App\ListOfBanks as ListOfBanks;

use App\Mail\sendEmail;

use Twilio\Rest\Client;


trait ExpressPayment{

    public $Base_Url;
    public $curlPost;

    // Get Vendors
    public function getVendors(){
        $this->Base_Url = env('EXPRESS_PAY_ENDPOINT_URL').'/billersandproductandfields';

        try {
            $data = $this->doGet();

            foreach($data as $dataItem){

                if(isset($dataItem->productfields[0]->commission)){

                    $commission = $dataItem->productfields[0]->commission;
                }
                else{
                    $commission = 0;
                }

                if(isset($dataItem->productfields[0]->charge)){

                    $charge = $dataItem->productfields[0]->charge;
                }
                else{
                    $charge = 0;
                }

                $query = [
                    'billerCode' => $dataItem->billerCode,
                    'billerName' => $dataItem->billerName,
                    'commission' => $commission,
                    'charge' => $charge,
                ];

                EPSVendor::updateOrCreate(['billerCode' => $dataItem->billerCode], $query);

            }


            return $data;
        } catch (\Throwable $th) {

            return [];
        }


        
    }


    public function getCommissionData($amount, $billerCode, $country){

            $data = EPSVendor::where('billerCode', $billerCode)->first();
            $ourcharge = PSCharge::where('country', $country)->first();
            // Get Commision and Charge
            if($data->commission != 0){
                $commission = $data->commission;
            }
            else{
                $commission = 0;
            }

            if($data->charge != 0){
                $charge = $data->charge;
            }
            else{
                $charge = 0;
            }

            $data['commission'] = $commission;
            $data['charge'] = $charge;

            if($commission != 0){
                $newPercent = $commission * ($ourcharge->percent / 100);
            }
            else{
                $newPercent = $charge * ($ourcharge->percent / 100);
            }

            $data['discountPercent'] = $newPercent;

            $data['walletDiscount'] = $amount * $newPercent;


            $data['walletCharge'] = $amount - $data['walletDiscount'];

            // Get our charge

            return $data;
            

    }

    public function getUtilityProduct($id){
        $this->Base_Url = env('EXPRESS_PAY_ENDPOINT_URL').'/productfields/'.$id;

        try {
            $data = $this->doGet();
            return $data;
        } catch (\Throwable $th) {

            return [];
        }


        
    }

    // Process Transaction
    public function processTransaction($postRequest){


        $this->Base_Url = env('EXPRESS_PAY_ENDPOINT_URL').'/process-transaction';
        $transaction = [];

        for ($i=0; $i < count($postRequest['fieldName']); $i++) { 
                
            if($postRequest['fieldName'] != null){
                $transaction []= [
                    'fieldName' => $postRequest['fieldName'][$i],
                    'fieldValue' => $postRequest['fieldValue'][$i],
                    'fieldControlType' => $postRequest['fieldControlType'][$i],
                ];
            }
            else{
                $transaction []= [
                    'fieldName' => $postRequest['fieldName'],
                    'fieldValue' => $postRequest['fieldValue'],
                    'fieldControlType' => $postRequest['fieldControlType'],
                ];
            }
        }   



        $this->curlPost = json_encode([
            'billerCode' => $postRequest['billerCode'],
            'productId' => $postRequest['productId'],
            'transDetails' => $transaction,
        ]);


        
        $data = $this->doPost();

        return $data;
    }

    public function doGet(){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $this->Base_Url,
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
        CURLOPT_URL => $this->Base_Url,
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
            'Authorization: Basic '.env('EXPRESS_PAY_BASIC'),
            'Content-Type: application/json'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response);
    }

}






