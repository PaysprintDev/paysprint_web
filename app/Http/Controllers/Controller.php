<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Support\Facades\Log;

use Twilio\Rest\Client;
use App\Notifications as Notifications;
use App\FeeTransaction as FeeTransaction;
use App\TransactionCost as TransactionCost;

use App\Classes\Mobile_Detect;


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
                    $ip_response = $this->curl_get_file_contents('http://ip-api.com/json/'.$userIP);

            }

            
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
        }


        $ip_array=json_decode($ip_response);

        // dd($ip_array);

        return  $ip_array;
    }


    public function curl_get_file_contents($URL){
        $c = curl_init();
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_URL, $URL);
        $contents = curl_exec($c);
        curl_close($c);
    
        if ($contents) return $contents;
        else return FALSE;
    }



    public function currencyConvert($curCurrency, $curAmount){

        $currency = 'USD'.$curCurrency;
        $amount = $curAmount;

        $access_key = '6173fa628b16d8ce1e0db5cfa25092ac';

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
            

        }
        else{
            $convRate = "Sorry we can not process your transaction this time, try again later!.";
        }

        

        return $convRate;

    }


    public function getConversionRate($localcountry, $foreign){

        $currencyA = "USD".$foreign;
        $currencyB = "USD".$localcountry;

        $access_key = '6173fa628b16d8ce1e0db5cfa25092ac';

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
            $convRateA = $result->quotes->$currencyA;
            $convRateB = $result->quotes->$currencyB;

            $convRate = $convRateA / $convRateB;
        }
        else{
            $convRate = "Sorry we can not process your transaction this time, try again later!.";
        }


        return $convRate;
    }

    public function detectMobile(){

        $detect = new Mobile_Detect;

        return $detect;
    }

    public function minimumWithdrawal($country){

        try{
            // Get Minimum Withdrawal
            $minimumBalance = TransactionCost::where('method', 'Minimum Balance')->where('country', $country)->first();

            if(isset($minimumBalance) == true){
                $data = $minimumBalance->fixed;
            }
            else{
                $data = 0;
            }
            

            return $data;
            
        }
        catch (\Throwable $th) {
            Log::error('Error: '.$th->getMessage());
        }
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

    public function sendMessage($message, $recipients){

        try {
            $account_sid = env("TWILIO_SID");
        $auth_token = env("TWILIO_AUTH_TOKEN");
        $twilio_number = env("TWILIO_NUMBER");
        $client = new Client($account_sid, $auth_token);
        $client->messages->create($recipients, 
                ['from' => $twilio_number, 'body' => $message] );

        } catch (\Throwable $th) {
            Log::error('Error: '.$th->getMessage());

            $response = 'Money sent successfully. However, we are unable to send you a notification through a text message because we detected there is no phone number or you have an invalid phone number on your PaySprint Account. Kindly update your phone number to receive notification via text on your next transaction.';
            $respaction = 'success';

            return redirect()->route('payorganization')->with($respaction, $response);
        }
        
        

    }


    public function createNotification($ref_code, $activity, $platform = null){

        $platform = ($this->detectMobile()->isMobile() ? ($this->detectMobile()->isTablet() ? 'tablet' : 'mobile') : 'web');

        try {

            Notifications::insert(['ref_code' => $ref_code, 'activity' => $activity, 'notify' => 0, 'platform' => $platform]);

        } catch (\Throwable $th) {

            Log::error('Error: '.$th->getMessage());
        }

    }


    public function getfeeTransaction($transaction_id, $ref_code, $amount, $fee, $amounttosend){

        FeeTransaction::insert(['transaction_id' => $transaction_id, 'ref_code' => $ref_code, 'amount' => $amount, 'fee' => $fee, 'amount_to_send' => $amounttosend]);

    }


    public function curlPost($url, $data, $token){

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$token
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
