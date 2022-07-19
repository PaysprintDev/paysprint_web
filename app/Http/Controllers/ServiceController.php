<?php

namespace App\Http\Controllers;

use Intervention\Image\Facades\Image;

use App\User;
use App\StoreCart;
use App\StoreOrders;
use App\StorePickup;
use App\AllCountries;
use App\StoreCategory;
use App\StoreDelivery;
use App\StoreDiscount;
use App\StoreMainShop;
use App\StoreProducts;
use App\StoreWishList;
use App\Mail\sendEmail;
use App\ProductTax;
use App\Traits\MyEstore;
use App\Traits\Xwireless;

use App\StoreBillingDetail;
use App\StoreShipping;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    use MyEstore, Xwireless;

    public $to;
    public $name;
    public $email;
    public $subject;
    public $message;

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

        return view('main.service.index')->with(['data' => $data]);
    }


    // Show Service Page
    public function merchantPlatformService($id){
        $data = [];
        return view('merchant.pages.service.index')->with(['data' => $data]);
    }


    public function merchantPlatformPricing($id){
        $data = [];
        return view('merchant.pages.service.services')->with(['data' => $data]);
    }


    public function getPaymentGateway($country)
    {

        $data = AllCountries::where('name', $country)->first();

        return $data;
    }




    // API methods for Shop setup
    public function setupService(Request $req)
    {
        // Upload Header Content....
        dd($req->all());
    }
}