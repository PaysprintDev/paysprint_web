<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait youverify
{

    public $youverifyBaseUrl = "https://api.sandbox.youverify.co/v2/api/";
    public $Youverifyurl;
    public $YouverifyCurlPost;

    public function verifyGhanaPassport($id)
    {
        $this->Youverifyurl = $this->youverifyBaseUrl . "identity/gh/passport";

        $this->YouverifyCurlPost = json_encode([
            "id" => $id,
            "IsSubjectConsent" => true,
        ]);

        $data = $this->youverifyPassport();

        return $data;
    }

    public function youverifyPassport()
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->Youverifyurl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $this->YouverifyCurlPost,
            CURLOPT_HTTPHEADER => array(
                'token: ' . env('YOUVERIFY_PUB_KEY'),
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return json_decode($response);
    }
}