<?php 
namespace App\Traits;

use Illuminate\Http\Request;


use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Mail;

use App\User as User;

use App\AllCountries;

use App\Mail\sendEmail;


trait dusupay{

    public $DusuBaseUrl = "https://sandbox.dusupay.com/v1";
    public $Dusuurl;
    public $DusuCurlPost;

    
    public function collectPayment($currencyCode,$amount,$reason){

        $this->Dusuurl=$this->DusuBaseUrl."/collections";

        $this->DusuCurlPost = json_encode([
            'api_key' => env('DUSU_PAY_DEV_KEY_ID'),
            'currency' => $currencyCode,
            'amount' => $amount,
            'method' => 'CARD',
            'provider_id' => 'local_ngn',
            'merchant_reference' => 'Payment to Paysprint Limited',
            'narration' => $reason,
            "redirect_url" => 'https://localhost:8000'
        ]);

        $data = $this->doPost();

        return $data;

    }



    public function getProviders($code,$currencyCode){

        $this->Dusuurl= $this->DusuBaseUrl."/payment-options/collection/card/".$code."?api_key=PUBK-2022ea52d25cf3defae72e56b0d88b200";


        $this->DusuCurlPost=json_encode([
            'api_key' => env('DUSU_PAY_DEV_KEY_ID'),
            'transaction_type' => 'COLLECTION',
            'method' => 'CARD',
            'country' => $currencyCode
        ]);

        $data=$this->dusuGet();

        return $data;

    }



    public function getBankCode($code){
        $this->Dusuurl= $this->DusuBaseUrl."/payment-options/payout/bank/".$code."?api_key=PUBK-2022ea52d25cf3defae72e56b0d88b200";
        
        $this->DusuCurlPost=json_encode([
            'api_key' => env('DUSU_PAY_DEV_KEY_ID'),
            'method' => 'PAYOUT',
            'country_code' => $code
        ]);

        $data=$this->dusuGetBankCode();

        return $data;
    }



    public function doPost()
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
                'Content-Type: application/json'
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
            CURLOPT_POSTFIELDS =>$this->DusuCurlPost,
             CURLOPT_HTTPHEADER => array(
              'secret-key: SECK-2022f6da520945cbf9693f7ff0817d5d3',
              'Content-Type: application/json'
  ),
));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response);

    }














}





























?>