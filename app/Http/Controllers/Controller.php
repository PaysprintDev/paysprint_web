<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function getUserIpAddr(){
        if(!empty($_SERVER['HTTP_CLIENT_IP'])){
            //ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            //ip pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }else{
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        
        return $ip;
    }



    // Get My current country

    public function myLocation(){
        // $ip_server = $_SERVER['SERVER_ADDR'];

        $userIP = $this->getUserIpAddr();
        // $userIP = "129.205.113.93";

        
        try {

            if(env('APP_ENV') === "local"){
                // Test Data
                $ip_response = '{"status":"success", "country":"Nigeria", "countryCode":"NG", "region":"LA", "regionName":"Lagos", "city":"Ikeja", "zip":"", "lat":6.4474, "lon":3.3903, "timezone":"Africa/Lagos", "isp":"Globacom Limited", "org":"Glomobile Gprs", "as":"AS37148 Globacom Limited", "query":"129.205.113.93"}';
            }
            else{
                    $ip_response = file_get_contents('http://ip-api.com/json/'.$userIP);

            }

            
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
        }


        $ip_array=json_decode($ip_response);

        // dd($ip_array);

        return  $ip_array;
    }


    public function returnJSON($data, $status){
        return response()->json($data, $status);
    }


}
