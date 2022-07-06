<?php

namespace App\Traits;

trait Flutterwave
{
    public $flutterUrl;
    public $flutterPost;

    public function createVirtualAccountNumber($email, $bvn, $phone, $firstname, $lastname)
    {

        $this->flutterUrl = config("constants.flutterwave.baseurl") . "/virtual-account-numbers";
        $this->flutterPost = json_encode([
            "email" => $email,
            "is_permanent" => true,
            "bvn" => $bvn,
            "tx_ref" => date('dmY') . time(),
            "phonenumber" => $phone,
            "firstname" => $firstname,
            "lastname" => $lastname,
            "narration" => $firstname . ' ' . $lastname
        ]);


        $result = $this->flutterWavePostCurl();

        return $result;
    }


    public function getVirtualAccountNumber($order_ref)
    {


        $this->flutterUrl = config("constants.flutterwave.baseurl") . "/virtual-account-numbers/{$order_ref}";


        $result = $this->flutterWaveGetCurl();

        return $result;
    }





    // CURL Option...

    public function flutterWavePostCurl()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->flutterUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $this->flutterPost,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . (env('APP_ENV') == 'production' ? config("constants.flutterwave.sec_key_prod") : config("constants.flutterwave.sec_key_dev"))
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response);
    }


    public function flutterWaveGetCurl()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->flutterUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . (env('APP_ENV') == 'production' ? config("constants.flutterwave.sec_key_prod") : config("constants.flutterwave.sec_key_dev"))
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response);
    }
}