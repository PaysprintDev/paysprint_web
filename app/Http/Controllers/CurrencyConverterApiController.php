<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CurrencyConverterApiController extends Controller
{
    public function currencyConvert(Request $req){

        $currency = 'USD'.$req->currency;
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

        if($req->val == "send"){
            // Conversion Rate USD to Local currency
            $convRate = $amount / $result->quotes->$currency;
        }
        else{
            // This amount is the amount in dollars
            $convRate = $result->quotes->$currency * $amount;
        }


        

        $amountConvert = number_format($convRate, 2);



        $resData = ['res' => 'Fetching Data', 'message' => 'success', 'data' => $amountConvert];


        return $this->returnJSON($resData, 200);

    }
}


