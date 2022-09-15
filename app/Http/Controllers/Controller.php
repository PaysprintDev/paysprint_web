<?php

namespace App\Http\Controllers;

use App\AllCountries;
use App\Buffer;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Support\Facades\Log;

use Twilio\Rest\Client;
use App\Notifications as Notifications;
use App\FeeTransaction as FeeTransaction;
use App\TransactionCost as TransactionCost;
use App\ConversionCountry as ConversionCountry;

use App\Classes\Mobile_Detect;

use App\User as User;
use App\Traits\PaymentGateway;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, PaymentGateway;



    public function getUserIpAddr()
    {
        try {
            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                //ip from share internet
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                //ip pass from proxy
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                $ip = $_SERVER['REMOTE_ADDR'];
            }


            return $ip;
        } catch (\Throwable $th) {
            Log::critical($th->getMessage());
        }
    }



    // Get My current country

    public function myLocation()
    {
        // $ip_server = $_SERVER['SERVER_ADDR'];


        $userIP = $this->getUserIpAddr();
        // $userIP = "129.205.113.93";

        try {

            if (env('APP_ENV') === "local") {
                // Test Data
                $ip_response = '{"status":"success", "country":"Nigeria", "countryCode":"NG", "region":"LA", "regionName":"Lagos", "city":"Ikeja", "zip":"", "lat":6.4474, "lon":3.3903, "timezone":"Africa/Lagos", "isp":"Globacom Limited", "org":"Glomobile Gprs", "as":"AS37148 Globacom Limited", "query":"129.205.113.93"}';
            } else {
                $ip_response = $this->curl_get_file_contents('http://ip-api.com/json/' . $userIP);
            }
        } catch (\Throwable $th) {
            // Log::info($th->getMessage());

            $this->slack($th->getMessage(), $room = "error-logs", $icon = ":longbox:", env('LOG_SLACK_WEBHOOK_URL'));
        }


        $ip_array = json_decode($ip_response);

        // dd($ip_array);

        return  $ip_array;
    }


    public function curl_get_file_contents($URL)
    {
        $c = curl_init();
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_URL, $URL);
        $contents = curl_exec($c);
        curl_close($c);

        if ($contents) return $contents;
        else return FALSE;
    }



    public function currencyConvert($curCurrency, $curAmount)
    {

        // Get Markup
        $markuppercent = $this->markupPercentage();

        // $markValue = (1 + ($markuppercent[0]->percentage / 100));
        // $markdownValue = (1 - ($markuppercent[0]->percentage / 100));

        $currency = 'USD' . $curCurrency;
        $amount = $curAmount;

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
            // $convRate = ($amount / $result->quotes->$currency) * $markValue;



            $convRate = ($amount / ($currency !== 'USDUSD' ? $result->quotes->$currency : 1));
        } else {
            $convRate = "Sorry we can not process your transaction this time, try again later!.";
        }



        return $convRate;
    }


    public function platformcurrencyConvert()
    {


        try {
            //code...



        // Get Markup
        $markuppercent = $this->markupPercentage();

        $markValue = (1 + ($markuppercent[0]->percentage / 100));



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


        $query = [];
        $official = [];
        $countryQuery = [];

        foreach ($result->quotes as $value) {

            if ($value == 1) {
                $query[] = $value;
            } else {
                $query[] = $value * $markValue;
            }

            $official[] = $value;
        }



        $countryRec = ConversionCountry::orderBy('id', 'ASC')->get();



        foreach ($countryRec as $country) {
            $countryQuery[] = $country->country;
        }

        $dataInfo = [
            'country' => $countryQuery,
            'query' => $query,
            'official' => $official,
        ];



        for ($i = 0; $i < count($countryQuery); $i++) {
            ConversionCountry::where('country', $dataInfo['country'][$i])->update(['rate' => $dataInfo['query'][$i], 'official' => $dataInfo['official'][$i]]);
        }

        } catch (\Throwable $th) {
            //throw $th;
        }

        $newRate = ConversionCountry::orderBy('id', 'ASC')->get();


        $data = [
            'quotes' => $newRate
        ];



        return $data;
    }


    public function getCurrenciesLive()
    {


        $access_key = '6173fa628b16d8ce1e0db5cfa25092ac';

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://api.currencylayer.com/list?access_key=' . $access_key,
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

        foreach ($result->currencies as $country) {
            ConversionCountry::insert(['country' => $country]);
        }
    }


    public function getConversionRate($localcountry, $foreign, $route = null)
    {




        // Get Markup
        $markuppercent = $this->markupPercentage();

        $markValue = (1 + ($markuppercent[0]->percentage / 100));

        $currencyA = "USD" . $foreign;
        $currencyB = "USD" . $localcountry;

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

            if($currencyA !== 'USDUSD'){
                $convRateA = $result->quotes->$currencyA;
            }
            else{
                $convRateA = 1;
            }


            if($currencyB !== 'USDUSD'){
                $convRateB = $result->quotes->$currencyB;
            }
            else{
                $convRateB = 1;
            }

            $actualRate = $convRateA / $convRateB;

            $convRate = $actualRate * 95 / 100;

            $this->calculateBufferedTransaction($actualRate, $convRate, $route);
        } else {
            $convRate = "Sorry we can not process your transaction this time, try again later!.";
        }


        return $convRate;
    }



    public function getOfficialConversionRate($localcountry, $foreign, $route = null)
    {


        // Get Markup
        $markuppercent = $this->markupPercentage();


        $markValue = (1 + ($markuppercent[0]->percentage / 100));
        $markdownValue = (1 - ($markuppercent[0]->percentage / 100));

        $currencyA = "USD" . $foreign;
        $currencyB = "USD" . $localcountry;

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


            if($currencyA !== 'USDUSD'){
                if ($result->quotes->$currencyA > 1) {

                    // $convRateA = $result->quotes->$currencyA / $markValue;
                    $convRateA = $result->quotes->$currencyA;
                } elseif ($result->quotes->$currencyA < 1) {
                    // $convRateA = $result->quotes->$currencyA * $markdownValue;
                    $convRateA = $result->quotes->$currencyA;
                } else {
                    $convRateA = $result->quotes->$currencyA;
                }
            }
            else{
                $convRateA = 1;
            }



            if($currencyB !== 'USDUSD'){
                if ($result->quotes->$currencyB > 1) {

                        // $convRateB = $result->quotes->$currencyB / $markValue;
                        $convRateB = $result->quotes->$currencyB;
                    } elseif ($result->quotes->$currencyB < 1) {
                        // $convRateB = $result->quotes->$currencyB * $markdownValue;
                        $convRateB = $result->quotes->$currencyB;
                    } else {
                        $convRateB = $result->quotes->$currencyB;
                    }
            }
            else{
                $convRateB = 1;
            }

            $actualRate = $convRateA / $convRateB;

            $convRate = $actualRate * 95 / 100;


            $this->calculateBufferedTransaction($actualRate, $convRate, $route);
        } else {
            $convRate = "Sorry we can not process your transaction this time, try again later!.";
        }



        return $convRate;
    }


    public function calculateBufferedTransaction($actualRate, $buffered, $route)
    {

        if ($route != null) {
            $profit = $actualRate - $buffered;
            Buffer::insert([
                'actualRate' => $actualRate, 'buffered' => $buffered, 'profit' => $profit, 'route' => $route, 'created_at' => now(), 'updated_at' => now()
            ]);
        }
    }

    public function detectMobile()
    {

        $detect = new Mobile_Detect;

        return $detect;
    }

    public function minimumWithdrawal($country)
    {

        try {
            // Get Minimum Wallet Balance
            $minimumBalance = TransactionCost::where('method', 'Minimum Balance')->where('country', $country)->first();

            if (isset($minimumBalance) == true) {
                $data = $minimumBalance->fixed;
            } else {
                $data = 0;
            }


            return $data;
        } catch (\Throwable $th) {
            // Log::error('Error: '.$th->getMessage());

            $this->slack('Error: ' . $th->getMessage(), $room = "error-logs", $icon = ":longbox:", env('LOG_SLACK_WEBHOOK_URL'));
        }
    }

    public function minimumAmountToWithdrawal($subType, $country)
    {

        try {
            // Get Minimum Withdrawal
            $minimumBalance = TransactionCost::where('method', $subType)->where('country', $country)->first();

            if (isset($minimumBalance) == true) {
                $data = $minimumBalance->fixed;
            } else {
                $data = 0;
            }


            return $data;
        } catch (\Throwable $th) {
            // Log::error('Error: '.$th->getMessage());

            $this->slack('Error: ' . $th->getMessage(), $room = "error-logs", $icon = ":longbox:", env('LOG_SLACK_WEBHOOK_URL'));
        }
    }

    public function maintenanceBalanceWithdrawal($subType, $country)
    {

        // Consumer Monthly Subscription
        // Merchant Monthly Subscription

        try {
            // Get Monthly Maintenance Fee
            $minimumBalance = TransactionCost::where('structure', $subType)->where('country', $country)->first();

            if (isset($minimumBalance) == true) {
                // $data = $minimumBalance->fixed;
                $data = 0;
            } else {
                $data = 0;
            }


            return $data;
        } catch (\Throwable $th) {
            // Log::error('Error: '.$th->getMessage());

            $this->slack('Error: ' . $th->getMessage(), $room = "error-logs", $icon = ":longbox:", env('LOG_SLACK_WEBHOOK_URL'));
        }
    }


    public function getCountryCoded($country)
    {

        try {
            $curl = curl_init();
            $access_key = '18c513c999bb1b77b4a8cedb938a0376';
            // $curlUrl = 'https://restcountries.eu/rest/v2/name/' . $country;
            $curlUrl = 'http://api.countrylayer.com/v2/name/' . $country;

            curl_setopt_array($curl, array(
                CURLOPT_URL => $curlUrl . "?access_key=" . $access_key,
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

            $data = json_decode($response);


            $callingCode = $data[0]->callingCodes[0];
            // $currencyCode = NULL;
            // $currencySymbol = NULL;
            $currencyCode = $data[0]->currencies[0]->code;
            $currencySymbol = $data[0]->currencies[0]->symbol;

            AllCountries::where('name', $country)->update([
                'callingCode' => $callingCode,
                'currencyCode' => $currencyCode,
                'currencySymbol' => $currencySymbol,
            ]);

            return $data;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }


    public function getCountryCode($country)
    {

        try {

            $data = AllCountries::where('name', $country)->first();

            return $data;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function sendMessage($message, $recipients)
    {

        try {
            $account_sid = env("TWILIO_SID");
            $auth_token = env("TWILIO_AUTH_TOKEN");
            $twilio_number = env("TWILIO_NUMBER");
            $client = new Client($account_sid, $auth_token);
            $client->messages->create(
                $recipients,
                ['from' => $twilio_number, 'body' => $message]
            );
        } catch (\Throwable $th) {
            // Log::error('Error: '.$th->getMessage());

            $this->slack('Error: ' . $th->getMessage(), $room = "error-logs", $icon = ":longbox:", env('LOG_SLACK_WEBHOOK_URL'));

            $response = 'Money sent successfully. However, we are unable to send you a notification through a text message because we detected there is no phone number or you have an invalid phone number on your PaySprint Account. Kindly update your phone number to receive notification via text on your next transaction.';
            $respaction = 'success';

            return redirect()->route('payorganization')->with($respaction, $response);
        }
    }



    public function createNotification($ref_code, $activity, $platform = null)
    {

        $platform = ($this->detectMobile()->isMobile() ? ($this->detectMobile()->isTablet() ? 'tablet' : 'mobile') : 'web');

        try {

            $thisuser = User::where('ref_code', $ref_code)->first();

            Notifications::insert(['ref_code' => $ref_code, 'activity' => $activity, 'notify' => 0, 'platform' => $platform, 'country' => $thisuser->country, 'period' => date('Y-m-d')]);
        } catch (\Throwable $th) {

            // Log::error('Error: '.$th->getMessage());

            $this->slack('Error: ' . $th->getMessage(), $room = "error-logs", $icon = ":longbox:", env('LOG_SLACK_WEBHOOK_URL'));
        }
    }


    public function getfeeTransaction($transaction_id, $ref_code, $amount, $fee, $amounttosend)
    {

        FeeTransaction::insert(['transaction_id' => $transaction_id, 'ref_code' => $ref_code, 'amount' => $amount, 'fee' => $fee, 'amount_to_send' => $amounttosend]);
    }


    // (string) $message - message to be passed to Slack
    // (string) $room - room in which to write the message, too
    // (string) $icon - You can set up custom emoji icons to use with each message
    public function slack($message, $room = "success-logs", $icon = ":longbox:", $webhook)
    {
        $room = ($room) ? $room : "success-logs";
        $data = "payload=" . json_encode(array(
            "channel"       =>  "#{$room}",
            "text"          =>  $message,
            "icon_emoji"    =>  $icon
        ));

        // You can get your webhook endpoint from your Slack settings
        $ch = curl_init($webhook);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }


    public function curlPost($url, $data, $token)
    {

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
                'Authorization: Bearer ' . $token
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return json_decode($response);
    }





    public function returnJSON($data, $status)
    {
        return response()->json($data, $status);
    }
}
