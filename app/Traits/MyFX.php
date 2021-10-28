<?php

namespace App\Traits;

use App\AllCountries;
use App\User;
use App\MarketPlace;

trait MyFX{

    // All Country and currency
    public function getCountryAndCurrency(){
        $data = AllCountries::where('approval', 1)->orderBy('name', 'ASC')->get();

        return $data;
    }

    public function personalCountry($country){
        $data = AllCountries::where('name', $country)->first();

        return $data;
    }
}