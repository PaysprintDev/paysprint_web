<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CurrencyConverterApiController extends Controller
{




    public function currencyConverter(Request $req){

        $currency = 'USD'.$req->currency;
        $amount = $req->amount;
        $localCurrency = 'USD'.$req->localcurrency;

        $access_key = 'c9e62dd9e7af596a2e955a8d324f0ca6';

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://api.currencylayer.com/live?access_key='.$access_key,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Cookie: __cfduid=d430682460804be329186d07b6e90ef2f1616160177'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $result = json_decode($response);


        


        if($result->success == true){
        
            if($req->val == "send"){
                // Conversion Rate Local to USD currency ie Y = 4000NGN / 380NGN(1 USD to Naira)
                $convertLocal = $amount / $result->quotes->$localCurrency;

                // Converting your USD value to other currency ie CAD * Y 
                $convRate = $result->quotes->$currency * $convertLocal;

            }
            else{
                // This amount is the amount in dollars
                $convRate = $result->quotes->$currency * $amount;
            }

            $message = 'success';

        }
        else{
            $convRate = "Sorry we can not process your transaction this time, try again later!.";
            $message = 'failed';
        }

        

        $amountConvert = $convRate;






        $resData = ['res' => 'Fetching Data', 'message' => $message, 'data' => $amountConvert];


        return $this->returnJSON($resData, 200);

    }


    // APP Currency conversion
        public function mycurrencyConvert(Request $req){

        $currency = 'USD'.$req->currencyCode;
        $cadconvert = 'USDCAD';
        $amount = $req->amount;

        $access_key = 'c9e62dd9e7af596a2e955a8d324f0ca6';

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://api.currencylayer.com/live?access_key='.$access_key,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Cookie: __cfduid=d430682460804be329186d07b6e90ef2f1616160177'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $result = json_decode($response);

        if($result->success == true){
            // This amount is in dollars
            $convRate = $amount / $result->quotes->$currency;

            $data = $convRate * $result->quotes->$cadconvert;

            $message = "success";
            
            $status = 200;
        }
        else{
            $data = [];
            $message = "Sorry we can not process your transaction this time, try again later!.";
            $status = 400;
        }

        

        $resData = ['data' => $data, 'message' => $message, 'status' => $status];


        return $this->returnJSON($resData, 200);

    }

}


