<?php

namespace App\Traits;

use App\AllCountries;

trait Moex{

        public function getCountryFee(String $amount, String $payoutcurrency, String $payoutMethod)
        {
            $data = AllCountries::where('currencyCode', $payoutcurrency)->first();

            return $data;
        }

}
