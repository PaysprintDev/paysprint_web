<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\AllCountries;
use App\User;

class ShopController extends Controller
{

    public function __construct()
    {
        $this->location = $this->myLocation();



        return $this->location;
    }

    public function index($shop, $id)
    {

        $timezone = explode("/", $this->location->timezone);



        $thisuser = User::where('ref_code', $id)->first();

        $getCurrencyCode = $this->getPaymentGateway($this->location->country);

        $data = array(
            'pages' => $shop . ' Shop',
            'currencyCode' => $this->getCountryCode($thisuser->country),
            'continent' => $timezone[0],
            'name' => $thisuser->businessname,
            'refCode' => $thisuser->ref_code,
            'mycurrencyCode' => $this->getCountryCode($getCurrencyCode->name),
        );


        // dd($data);


        return view('main.shop.index')->with(['data' => $data]);
    }

    public function getPaymentGateway($country)
    {

        $data = AllCountries::where('name', $country)->first();

        return $data;
    }
}