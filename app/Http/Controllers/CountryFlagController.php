<?php

namespace App\Http\Controllers;

use App\AllCountries;




class CountryFlagController extends Controller
{

    public function displayCountryFlag(){

        $countries = AllCountries::get();
     
        foreach ($countries as $country){
          
            $baseurl= "https://countryflagsapi.com/png/".$country->code;
            
            AllCountries::where('id',$country->id)->update([
                'logo' => $baseurl
            ]);
        }
      
      
      
    }
}
