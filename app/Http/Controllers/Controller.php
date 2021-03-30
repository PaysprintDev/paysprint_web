<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function getUserIpAddr(){
        if(!empty($_SERVER['HTTP_CLIENT_IP'])){
            //ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            //ip pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }else{
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        
        return $ip;
    }



    // Get My current country

    public function myLocation(){
        // $ip_server = $_SERVER['SERVER_ADDR'];

        $userIP = $this->getUserIpAddr();
        // $userIP = "129.205.113.93";

        
        try {

            if(env('APP_ENV') === "local"){
                // Test Data
                $ip_response = '{"status":"success", "country":"Nigeria", "countryCode":"NG", "region":"LA", "regionName":"Lagos", "city":"Ikeja", "zip":"", "lat":6.4474, "lon":3.3903, "timezone":"Africa/Lagos", "isp":"Globacom Limited", "org":"Glomobile Gprs", "as":"AS37148 Globacom Limited", "query":"129.205.113.93"}';
            }
            else{
                    $ip_response = file_get_contents('http://ip-api.com/json/'.$userIP);

            }

            
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
        }


        $ip_array=json_decode($ip_response);

        // dd($ip_array);

        return  $ip_array;
    }



    public function currencyConvert($curCurrency, $curAmount){

        $currency = 'USD'.$curCurrency;
        $amount = $curAmount;

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
            $convRate = $amount / $result->quotes->$currency;

        }
        else{
            $convRate = "Sorry we can not process your transaction this time, try again later!.";
        }

        

        return $convRate;

    }


    public function getCountryCode($country){

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://restcountries.eu/rest/v2/name/'.$country,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Cookie: __cfduid=d423c6237ed02a0f8118fec1c27419ab81613795899'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return json_decode($response);

    }


    public function returnJSON($data, $status){
        return response()->json($data, $status);
    }


}
