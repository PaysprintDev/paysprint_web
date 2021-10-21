<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Traits\PaymentGateway;

class CurrencyConverterApiController extends Controller
{


    use PaymentGateway;

    public function currencyConverter(Request $req)
    {


        // Get Markup
        $markuppercent = $this->markupPercentage();

        $markValue = (1 + ($markuppercent[0]->percentage / 100));

        $currency = 'USD' . $req->currency;
        $amount = $req->amount;
        $localCurrency = 'USD' . $req->localcurrency;

        $access_key = '6173fa628b16d8ce1e0db5cfa25092ac';

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://api.currencylayer.com/live?access_key=' . $access_key,
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





        if ($result->success == true) {

            if ($req->val == "pay") {


                if ($req->localcurrency != $req->currency) {
                    // Conversion Rate Local to USD currency ie Y = 4000NGN / 380NGN(1 USD to Naira)
                    $convertLocal = ($amount / $result->quotes->$localCurrency) * $markValue;
                } else {
                    // Conversion Rate Local to USD currency ie Y = 4000NGN / 380NGN(1 USD to Naira)
                    $convertLocal = $amount / $result->quotes->$localCurrency;
                }

                // Converting your USD value to other currency ie CAD * Y 
                $convRate = $result->quotes->$currency * $convertLocal;
            } 
            
            elseif ($req->val == "send") {
                $convertLocal = $amount / $result->quotes->$localCurrency;

                $convRate = $result->quotes->$currency * $convertLocal;
            }
            
            else {
                // This amount is the amount in dollars
                $convRate = $result->quotes->$currency * $amount;
            }

            $message = 'success';
        } else {
            $convRate = "Sorry we can not process your transaction this time, try again later!.";
            $message = 'failed';
        }



        $amountConvert = $convRate;






        $resData = ['res' => 'Fetching Data', 'message' => $message, 'data' => $amountConvert];


        return $this->returnJSON($resData, 200);
    }


    // APP Currency conversion
    public function mycurrencyConvert(Request $req)
    {

        // Get Markup
        $markuppercent = $this->markupPercentage();

        $markValue = (1 + ($markuppercent[0]->percentage / 100));

        $currency = 'USD' . $req->currencyCode;
        $cadconvert = 'USDCAD';
        $amount = $req->amount;

        $access_key = '6173fa628b16d8ce1e0db5cfa25092ac';

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://api.currencylayer.com/live?access_key=' . $access_key,
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

        if ($result->success == true) {
            // This amount is in dollars
            $convRate = ($amount / $result->quotes->$currency) * $markValue;

            $data = $convRate * $result->quotes->$cadconvert;

            $message = "success";

            $status = 200;
        } else {
            $data = [];
            $message = "Sorry we can not process your transaction this time, try again later!.";
            $status = 400;
        }



        $resData = ['data' => $data, 'message' => $message, 'status' => $status];


        return $this->returnJSON($resData, 200);
    }
}