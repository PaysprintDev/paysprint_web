<?php


namespace App\Traits;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\User as User;


trait Xwireless{


    public $x_url = "http://154.16.202.38:6005/api/v2";
    public $x_curlPost;
    public $x_baseUrl;

    public function sendSms(){
        $this->x_baseUrl = $this->x_url."/SendSMS";

        $this->x_curlPost = json_encode([
                "SenderId" => "IMPORTANT",
                "Is_Unicode" => true,
                "Is_Flash" => true,
                "Message" => "<p>This is my message from the application</p>",
                "MobileNumbers" => "23408137492316",
                "ApiKey" => "OQJBCJKZNAJv/TC8XHtmlqX4bcvOIDdbE65nEHZiJNw=",
                "ClientId" => "fdbffd06-6221-4b1c-9528-3aa63b37de6c"
            ]);

        $data = $this->thisPostCurl();
        

        return $data;
    }



    public function thisPostCurl(){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $this->x_baseUrl,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>$this->x_curlPost,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response);
    }

    public function thisGetCurl(){

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $this->x_baseUrl,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
        ));

        $response = curl_exec($curl);


        curl_close($curl);

        return json_decode($response);
    }

}