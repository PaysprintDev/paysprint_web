<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CurrencyConverterApiController extends Controller
{




    public function currencyConverter(Request $req){

        $currency = 'USD'.$req->currency;
        $amount = $req->amount;
        $localCurrency = 'USD'.$req->localcurrency;

        $access_key = '89e3a2b081fb2b9d188d22516553545c';

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
                // Conversion Rate USD to Local currency
                $convertLocal = $amount / $result->quotes->$currency;

                $convRate = $result->quotes->$localCurrency * $convertLocal;
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
}


