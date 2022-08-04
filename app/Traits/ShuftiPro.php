<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait ShuftiPro
{

    public $shuftiProUrl;
    public $shuftiProPost;


    public function amlBackgroundCheck(String $dob, array $name, String $reference, String $email, String $country)
    {

        $this->shuftiProUrl = config("constants.shuftipro.baseurl");
        $this->shuftiProPost = json_encode([
            "background_checks" => [
                "dob" => $dob,
                "name" => $name
            ],
            "reference"    => $reference,
            "email" => $email,
            "country" => $country
        ]);



        $result = $this->shuftiProPostCurl();

        return $result;
    }


    public function kycCheck(String $dob, array $name, String $reference, String $email, String $country)
    {

        $this->shuftiProUrl = config("constants.shuftipro.baseurl");
        $this->shuftiProPost = json_encode([
            "reference"    => $reference,
            "email" => $email,
            "country" => $country,
            "language" => "EN",
            "verification_mode" => "any",
            "ttl" => 60,
            "background_checks" => [
                "dob" => $dob,
                "name" => $name
            ],

        ]);




        $result = $this->shuftiProPostCurl();


        return $result;
    }




    // CURL Option...

    public function shuftiProPostCurl()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->shuftiProUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $this->shuftiProPost,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Basic ' . config("constants.shuftipro.basic_auth")
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response);
    }
}
