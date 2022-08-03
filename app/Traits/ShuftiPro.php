<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait ShuftiPro
{

    public $shuftiProUrl;
    public $shuftiProPost;


    public function amlBackgroundCheck(String $dob, Object $name)
    {

        $dob = "1995-10-10";
        $name = json_encode([
            'first_name' => 'John',
            'middle_name' => 'Carter',
            'last_name' => 'Doe',
        ]);

        $this->shuftiProUrl = config("constants.shuftipro.baseurl");
        $this->shuftiProPost = json_encode([
            "dob" => $dob,
            "name" => $name
        ]);
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
