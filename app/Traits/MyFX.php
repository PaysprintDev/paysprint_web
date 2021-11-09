<?php

namespace App\Traits;

use App\AllCountries;
use App\User;
use App\MarketPlace;
use App\EscrowAccount;
use App\FxPayment;
use App\FxStatement;
use App\MakeBid;

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

    public function getMarketBidding($orderId)
    {
        $data = MarketPlace::where('order_id', $orderId)->first();

        return $data;
    }

    public function getMakeABid($orderId, $buyerId)
    {
        $newData = [];

        $data = MakeBid::where('order_id', $orderId)->where('buyer_id', $buyerId)->first();

        $marketPlace = MarketPlace::where('order_id', $data->order_id)->first();

        $data['sell_currencyCode'] = $marketPlace->sell_currencyCode;
        $data['buy_currencyCode'] = $marketPlace->buy_currencyCode;


        return $data;
    }
}