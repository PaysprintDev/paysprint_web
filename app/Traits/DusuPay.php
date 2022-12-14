<?php

namespace App\Traits;

use Illuminate\Http\Request;


use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Mail;

use App\User as User;

use App\AllCountries;

use App\Mail\sendEmail;


trait DusuPay
{

    public $DusuBaseUrl = '{(env("APP_ENV") === "local" ? env("DUSUSBASE_DEV_URL") : env("DUSUBASE_PROD_URL"))}';
    public $Dusuurl;
    public $DusuCurlPost;


    public function collectPayment($currencyCode, $amount, $reason)
    {

        $this->Dusuurl = $this->DusuBaseUrl . "/collections";

        $this->DusuCurlPost = json_encode([
            'api_key' => env("APP_ENV") == "local" ? env("DUSU_PAY_DEV_KEY_ID") : env("DUSU_PAY_PROD_KEY_ID"),
            'currency' => $currencyCode,
            'amount' => $amount,
            'method' => 'CARD',
            'provider_id' => 'local_ngn',
            'merchant_reference' => 'Payment to Paysprint Limited',
            'narration' => $reason,
            "redirect_url" => 'https://paysprint.ca'
        ]);

        $data = $this->doPost();

        return $data;
    }

    public function mobileMoneyWithdrawal($currency, $amount, $provider, $accountnumber, $accountname, $reference, $id)
    {
        $this->Dusuurl = $this->DusuBaseUrl . "/payouts";

        $this->DusuCurlPost = json_encode([
            "api_key" => env("APP_ENV") == "local" ? env("DUSU_PAY_DEV_KEY_ID") : env("DUSU_PAY_PROD_KEY_ID"),
            "currency" =>  $currency,
            "amount" => $amount,
            "method" => "MOBILE_MONEY",
            "provider_id" => $provider,
            "account_number" => $accountnumber,
            "account_name" => $accountname,
            "merchant_reference" => $reference,
            "narration" => "Payout to Mobile Money from Paysprint",
            "extra_params" => [
                "user_id" => $id
            ]
        ]);



        $data = $this->mobileMoneyWithdrawalPoint();


        return $data;
    }



    public function getProviders($code, $currencyCode)
    {

        $this->Dusuurl = $this->DusuBaseUrl . "/payment-options/collection/card/" . $code . "?api_key=" . env("APP_ENV") == "local" ? env("DUSU_PAY_DEV_KEY_ID") : env("DUSU_PAY_PROD_KEY_ID");


        $this->DusuCurlPost = json_encode([
            'api_key' => env("APP_ENV") == "local" ? env("DUSU_PAY_DEV_KEY_ID") : env("DUSU_PAY_PROD_KEY_ID"),
            'transaction_type' => 'COLLECTION',
            'method' => 'CARD',
            'country' => $currencyCode
        ]);

        $data = $this->dusuGet();

        return $data;
    }



    public function getBankCode($code)
    {
        $this->Dusuurl = $this->DusuBaseUrl . "/payment-options/payout/bank/" . $code . "?api_key=" . env("APP_ENV") == "local" ? env("DUSU_PAY_DEV_KEY_ID") : env("DUSU_PAY_PROD_KEY_ID");

        $this->DusuCurlPost = json_encode([
            'api_key' => env("APP_ENV") == "local" ? env("DUSU_PAY_DEV_KEY_ID") : env("DUSU_PAY_PROD_KEY_ID"),
            'method' => 'PAYOUT',
            'country_code' => $code
        ]);

        $data = $this->dusuGetBankCode();

        return $data;
    }

    public function mobileMoney($countrycode)
    {
        $this->Dusuurl = $this->DusuBaseUrl . "/payment-options/payout/mobile_money/" . $countrycode . "?api_key=" . env("APP_ENV") == "local" ? env("DUSU_PAY_DEV_KEY_ID") : env("DUSU_PAY_PROD_KEY_ID");

        $data = $this->mobileMoneyCode();

        return $data;
    }



    public function doDusupayPost()
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->Dusuurl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $this->DusuCurlPost,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response);
    }



    public function dusuGet()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->Dusuurl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_POSTFIELDS => $this->DusuCurlPost,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'secret-key:' . env("APP_ENV") == "local" ? env("DUSU_PAY_DEV_SECRET_KEY") : env("DUSU_PAY_PROD_SECRET_KEY"),
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response);
    }




    public function dusuGetBankCode()
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->Dusuurl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_POSTFIELDS => $this->DusuCurlPost,
            CURLOPT_HTTPHEADER => array(
                'secret-key:' . env("APP_ENV") == "local" ? env("DUSU_PAY_DEV_SECRET_KEY") : env("DUSU_PAY_PROD_SECRET_KEY"),
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response);
    }

    //get mobile money providers

    public function mobileMoneyCode()
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->Dusuurl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'secret-key:' . env("APP_ENV") == "local" ? env("DUSU_PAY_DEV_SECRET_KEY") : env("DUSU_PAY_PROD_SECRET_KEY"),
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response);
    }

    //dusu mobile money withdrawal
    public function mobileMoneyWithdrawalPoint()
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->Dusuurl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $this->DusuCurlPost,
            CURLOPT_HTTPHEADER => array(
                'secret-key:' . env("APP_ENV") == "local" ? env("DUSU_PAY_DEV_SECRET_KEY") : env("DUSU_PAY_PROD_SECRET_KEY"),
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        

        curl_close($curl);
        return json_decode($response);
    }
}
