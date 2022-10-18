<?php

namespace App\Traits;

trait OneSignal
{

    public $onesignalUrl;
    public $onesignalPost;


    public function notifyOneUser(String $playerId, String $content, String $heading)
    {
        $this->onesignalUrl = config("constants.onesignal.url") . "/notifications";
        $this->onesignalPost = json_encode([
            "app_id" => config("constants.onesignal.appId"),
            "include_player_ids" => [ $playerId ],
            "contents" => [
                "en" => $content
            ],
            "headings" => [
                "en" => $heading
            ]
        ]);


        $result = $this->oneSignalPostCurl();

        return $result;

    }

        // CURL Option...

    public function oneSignalPostCurl()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->onesignalUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $this->onesignalPost,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Basic ' . config("constants.onesignal.api_key")
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response);
    }

}

