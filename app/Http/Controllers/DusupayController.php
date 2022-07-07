<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

use App\AllCountries;

use App\Traits\DusuPay;

class DusupayController extends Controller
{
    use DusuPay;

    public function getDusuBankCode(Request $req, $id){
            $user=User::where('id', $id)->first();
            $usercountry=$user->currencyCode;
            $countrycode=AllCountries::where('currencyCode', $usercountry)->first();
            $code=$countrycode->code;
           $data= $this->getBankCode($code);
           dd($data);

    }
}
