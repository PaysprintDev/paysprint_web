<?php

namespace App\Traits;


use App\SpecialInformation as SpecialInformation;

trait SpecialInfo{

    public function createInfo($query){

        $data = SpecialInformation::updateOrCreate(['country' => $query['country']],$query);

        return $data;
    }


    public function getInfo(){

        $data = SpecialInformation::orderBy('country', 'ASC')->get();

        return $data;
    }
    
    public function getthisInfo($country){

        $data = SpecialInformation::where('country', $country)->first();

        return $data;
    }
}