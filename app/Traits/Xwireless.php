<?php


namespace App\Traits;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\User as User;


trait Xwireless{


    public $x_url = "http://154.16.202.38:6005/api/v2";
    public $x_curlPost;
    public $x_baseUrl;



    // This module is to send SMS to users... Majorly Nigeria.

    public function sendSms($message, $phone){
        $this->x_baseUrl = $this->x_url."/SendSMS";

        $this->x_curlPost = json_encode([
                "SenderId" => env('X_WIRELESS_SENDER_ID'),
                "Is_Unicode" => true,
                "Is_Flash" => true,
                "Message" => $message,
                "MobileNumbers" => $phone,
                "ApiKey" => env('X_WIRELESS_API_KEY'),
                "ClientId" => env('X_WIRELESS_CLIENT_ID')
            ]);

        $data = $this->thisPostCurl();
        

        return $data;
    }


    // Get sent SMS
    public function getSentSmsList(){

        $this->x_baseUrl = $this->x_url."/SMS?ApiKey=".env('X_WIRELESS_API_KEY')."&ClientId=".env('X_WIRELESS_CLIENT_ID')."&start=1&length=100&fromdate=".date("2021-08-d")."&enddate=".date('Y-m-d');

        $data = $this->thisGetCurl();
        
        

        return $data;
    }


    // Get My Credit balance
    public function getCreditBalance(){

        $this->x_baseUrl = $this->x_url."/Balance?ApiKey=".env('X_WIRELESS_API_KEY')."&ClientId=".env('X_WIRELESS_CLIENT_ID');

        $data = $this->thisGetCurl();
        

        return $data;
    }

    // Manage SMS Groups 

    // - GET Group List
    public function getGroupList(){

        $this->x_baseUrl = $this->x_url."/Group?ApiKey=".env('X_WIRELESS_API_KEY')."&ClientId=".env('X_WIRELESS_CLIENT_ID');

        $data = $this->thisGetCurl();
        

        return $data;
    }


    // - CREATE New Group
    public function createNewGroup($groupName){

        $this->x_baseUrl = $this->x_url."/Group";

        $this->x_curlPost = json_encode([
                "GroupName" => $groupName,
                "ApiKey" => env('X_WIRELESS_API_KEY'),
                "ClientId" => env('X_WIRELESS_CLIENT_ID')
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