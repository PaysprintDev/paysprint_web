<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

use App\AllCountries;
use App\DusuProviders;

use App\Traits\DusuPay;

class DusupayController extends Controller
{
    use DusuPay;

    public function getDusuBankCode(Request $req, $id)
    {
        $user = User::where('id', $id)->first();
        $usercountry = $user->currencyCode;
        $countrycode = AllCountries::where('currencyCode', $usercountry)->first();
        $code = $countrycode->code;
        $data = $this->getBankCode($code);
        $provider = $this->getProviders($code, $usercountry);
        // dd($provider);
    }

    public function mobileMoneyProviders()
    {
        $code = 'cm';
        $data = $this->mobileMoney($code);

        DusuProviders::updateOrCreate(['country_code' => $code], ['country_code' => $code, 'result' => json_encode($data->data)]);

        $newResult = DusuProviders::all();


        dd(json_decode($newResult[0]->result));

        // DusuEnd::updateOrCreate(['country' => $code], ['country' => $code, 'data' => json_encode($data)]);

    }
}
