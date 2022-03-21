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
}