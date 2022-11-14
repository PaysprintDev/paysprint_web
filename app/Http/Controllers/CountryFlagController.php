<?php

namespace App\Http\Controllers;

use App\AllCountries;




class CountryFlagController extends Controller
{

    public $url;

    public function displayCountryFlag(){

        $countries = AllCountries::get();

        foreach ($countries as $country){

            $baseurl= "https://countryflagsapi.com/png/".$country->code;
            
          AllCountries::where('id',$country->id)->update([
                'logo' => $baseurl
            ]);
        }
        // dd($baseurl);



    }

    public function getCountrycca3()
    {

        $countries = AllCountries::where('cca3', NULL)->get();

        foreach ($countries as $country){

            $this->url= "https://restcountries.com/v3.1/alpha/".$country->code;

            $result = $this->curlPostRecord();

            if(!array_key_exists('status',$result)){
                    AllCountries::where('id',$country->id)->update([
                                    'cca3' => $result[0]['cca3']
                                ]);
            }


        }


        echo "Done";

    }


    public function curlPostRecord()
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $this->url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response, true);
    }


}
