<?php

namespace App\Traits;

use App\User;
use App\MakeBid;
use App\FxPayment;
use App\FxStatement;
use App\MarketPlace;
use App\AllCountries;
use App\EscrowAccount;
use App\CrossBorderBeneficiary;
use App\PaySprintAccountDetails;

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

        $data = MakeBid::where('order_id', $orderId)->where('buyer_id', $buyerId)->first();

        $marketPlace = MarketPlace::where('order_id', $data->order_id)->first();

        $data['sell_currencyCode'] = $marketPlace->sell_currencyCode;
        $data['buy_currencyCode'] = $marketPlace->buy_currencyCode;


        return $data;
    }


    public function getMyWallet($escrow_id)
    {
        $data =  EscrowAccount::where('escrow_id', $escrow_id)->first();

        return $data;
    }

    public function getMyOtherWallets($escrow_id, $id)
    {

        $data =  EscrowAccount::where('escrow_id', '!=', $escrow_id)->where('user_id', $id)->get();

        return $data;
    }


    public function getBeneficiaries()
    {
        $data = CrossBorderBeneficiary::orderBy('account_name', 'ASC')->get();

        return $data;
    }

    public function getThisBeneficiary($id)
    {
        $data = CrossBorderBeneficiary::where('id', $id)->first();

        return $data;
    }

    public function getPSAccountDetails(){
        $data = PaySprintAccountDetails::first();

        return $data;
    }
}
