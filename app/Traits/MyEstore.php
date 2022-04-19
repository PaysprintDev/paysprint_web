<?php

namespace App\Traits;

use App\AllCountries;
use App\ReferralGenerate;
use App\ReferredUsers;
use Illuminate\Support\Facades\Hash;

use App\ClientInfo as ClientInfo;

use App\SuperAdmin as SuperAdmin;
use App\User;
use App\StoreProducts;
use App\StoreOrders;
use App\StoreDiscount;
use App\StoreMainShop;
use App\StoreWishList;
use App\StoreCart;

trait MyEstore
{

    public function getMyStore($id)
    {

        $data = StoreMainShop::where('merchantId', $id)->first();

        return $data;
    }


    public function getProducts($id){
        $data = StoreProducts::where('merchantId', $id)->orderBy('created_at', 'DESC')->get();

        return $data;
    }

    public function getMyWishlist($id){

        if($id == 0) $data = [];

        $data = StoreWishList::where('userId', $id)->orderBy('created_at', 'DESC')->get();

        return $data;

        
    }
    public function getMyCartlist($id){

        if($id == 0) $data = [];

        $data = StoreCart::where('userId', $id)->orderBy('created_at', 'DESC')->get();

        return $data;

    }

    public function getPayCartList($id, $merchantId){

        $data = StoreCart::where('userId', $id)->where('merchantId', $merchantId)->orderBy('created_at', 'DESC')->get();

        return $data;

    }

    public function getThisProduct($id){
        $data = StoreProducts::where('id', $id)->first();

        return $data;
    }


    public function getOrders($merchantid, $userid){
        $data = StoreOrders::where('userId', $userid)->where('merchantId', $merchantid)->where('paymentStatus', 'not paid')->get();

        return $data;
    }


}