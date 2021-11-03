<?php

namespace App\Traits;

use App\AllCountries;
use App\User;
use App\MarketPlace;
use App\EscrowAccount;
use App\FxPayment;
use App\FxStatement;

trait MyFX
{

    // All Country and currency
    public function getCountryAndCurrency()
    {
        $data = AllCountries::where('approval', 1)->orderBy('name', 'ASC')->get();

        return $data;
    }

    public function personalCountry($country)
    {
        $data = AllCountries::where('name', $country)->first();

        return $data;
    }

    public function getEscrowFunding()
    {
        $data = FxStatement::where('confirmation', 'pending')->orderBy('created_at', 'DESC')->get();

        return $data;
    }
}