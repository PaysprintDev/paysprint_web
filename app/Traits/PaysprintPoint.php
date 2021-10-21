<?php


namespace App\Traits;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;

use App\Points as Points;
use App\User;

trait PaysprintPoint
{

    public function updatePoints($user_id, $activity)
    {
        $pointAcquired = Points::where('user_id', $user_id)->first();

        if (isset($pointAcquired)) {

            $add_money = $pointAcquired->add_money;
            $send_money = $pointAcquired->send_money;
            $add_money = $pointAcquired->add_money;
            $receive_money = $pointAcquired->receive_money;
            $pay_invoice = $pointAcquired->pay_invoice;
            $pay_bills = $pointAcquired->pay_bills;
            $create_and_send_invoice = $pointAcquired->create_and_send_invoice;
            $active_rental_property = $pointAcquired->active_rental_property;
            $quick_set_up = $pointAcquired->quick_set_up;
            $approved_customers = $pointAcquired->approved_customers;
            $approved_merchants = $pointAcquired->approved_merchants;
            // $business_verification = $pointAcquired->business_verification;
            $promote_business = $pointAcquired->promote_business;
            $activate_ordering_system = $pointAcquired->activate_ordering_system;
            $identify_verification = $pointAcquired->identify_verification;
            $activate_rpm = $pointAcquired->activate_rpm;
            $activate_currency_exchange = $pointAcquired->activate_currency_exchange;
            $activate_cash_advance = $pointAcquired->activate_cash_advance;
            $activate_crypto_currency_account = $pointAcquired->activate_crypto_currency_account;
            $myAcquiredPoint = $pointAcquired->points_acquired;
        } else {
            $add_money = 0;
            $send_money = 0;
            $receive_money = 0;
            $pay_invoice = 0;
            $pay_bills = 0;
            $create_and_send_invoice = 0;
            $active_rental_property = 0;
            $quick_set_up = 0;
            $approved_customers = 0;
            $approved_merchants = 0;
            // $business_verification = 0;
            $promote_business = 0;
            $activate_ordering_system = 0;
            $identify_verification = 0;
            $activate_rpm = 0;
            $activate_currency_exchange = 0;
            $activate_cash_advance = 0;
            $activate_crypto_currency_account = 0;
            $myAcquiredPoint = 0;
        }

        switch ($activity) {
            case 'Add money':

                $add_money = $add_money + 1;

                if($add_money>=5){

                   $sumPoints =  $myAcquiredPoint + 1000;

                }else {

                    $sumPoints =  $myAcquiredPoint + 200;
                }

                $addedPoint = $sumPoints;


                break;

            case 'Send money':

                $send_money = $send_money + 1;

                if($send_money>=5){

                    $sumPoints =  $myAcquiredPoint + 700;

                }else {
                    
                    $sumPoints =  $myAcquiredPoint + 140;
                }

                $addedPoint = $sumPoints;


                break;
            case 'Receive money':

                $receive_money = $receive_money + 1;

                if($receive_money>=5){

                    $sumPoints =  $myAcquiredPoint + 600;

                }else {
                    
                    $sumPoints =  $myAcquiredPoint + 120;
                }

                $addedPoint = $sumPoints;


                break;
            case 'Pay invoice':

                $pay_invoice = $pay_invoice + 1;

                if($pay_invoice>=10){

                   $sumPoints =  $myAcquiredPoint + 500;

                }else {
                    
                   $sumPoints =  $myAcquiredPoint + 50;
                }

                $addedPoint = $sumPoints;


                break;
            case 'Pay bills':

                $pay_bills = $pay_bills + 1;

                if($pay_bills>=10){

                    $sumPoints = $myAcquiredPoint + 500;

                }else {

                    $sumPoints = $myAcquiredPoint + 50;
                }

                $addedPoint = $sumPoints;


                break;
            case 'Create and send invoice':

                $create_and_send_invoice = $create_and_send_invoice + 1;

                if($create_and_send_invoice>=10){

                    $sumPoints = $myAcquiredPoint + 800;

                }else {

                    $sumPoints = $myAcquiredPoint + 80;
                }

                $addedPoint = $sumPoints;


                break;
            case 'Active rental property':

                $active_rental_property = $active_rental_property + 1;

                if($create_and_send_invoice>=1){

                    $sumPoints = $myAcquiredPoint + 500;

                }else {

                    $sumPoints = $myAcquiredPoint + 500;
                }

                $addedPoint = $sumPoints;


                break;

             case 'Quick Set Up':

                $quick_set_up = $quick_set_up + 1;

                if($quick_set_up>=1){

                    $sumPoints = $myAcquiredPoint + 200;

                }else {

                    $sumPoints = $myAcquiredPoint + 200;
                }

                $addedPoint = $sumPoints;


                break;
            case 'Approved Customers':

                $approved_customers = $approved_customers + 1;


                if($approved_customers>=1){

                    $sumPoints = $myAcquiredPoint + 500;

                }else {

                    $sumPoints = $myAcquiredPoint + 500;
                }

                $addedPoint = $sumPoints;

                break;
            case 'Approved Merchants':

                $approved_merchants = $approved_merchants + 1;

                if($approved_merchants>=1){

                    $sumPoints = $myAcquiredPoint + 700;

                }else {

                    $sumPoints = $myAcquiredPoint + 700;
                }

                $addedPoint = $sumPoints;

                break;
            // case 'Business verification':

            //     $business_verification = $business_verification + 1;


            //     break;
            case 'Promote business':

                $promote_business = $promote_business + 1;

                if($promote_business>=2){

                    $sumPoints = $myAcquiredPoint + 300;

                }else {

                    $sumPoints = $myAcquiredPoint + 150;
                }

                $addedPoint = $sumPoints;


                break;
            case 'Activate ordering system':

                $activate_ordering_system = $activate_ordering_system + 1;

                $addedPoint = 0;

                break;
            case 'Identify verification':

                $identify_verification = $identify_verification + 1;

                $addedPoint = 0;


                break;
            case 'Activate rpm':

                $activate_rpm = $activate_rpm + 1;

                $addedPoint = 0;

                break;
            case 'Activate currency exchange':

                $activate_currency_exchange = $activate_currency_exchange + 1;

                $addedPoint = 0;
                break;
            case 'Activate cash advance':

                $activate_cash_advance = $activate_cash_advance + 1;
                $addedPoint = 0;

                break;
            case 'Activate crypto currency account':

                $activate_crypto_currency_account = $activate_crypto_currency_account + 1;
                $addedPoint = 0;

                break;
            default:
                echo "Nothing";
                break;
        }

        $totalPoint = $addedPoint;

        Points::updateOrCreate(['user_id' => $user_id], [
            'user_id' => $user_id, 'add_money' => $add_money, 'send_money' => $send_money, 'receive_money' => $receive_money, 'pay_invoice' => $pay_invoice, 'pay_bills' => $pay_bills, 'create_and_send_invoice' => $create_and_send_invoice, 'active_rental_property' => $active_rental_property, 'quick_set_up' => $quick_set_up, 'approved_customers' => $approved_customers, 'approved_merchants' => $approved_merchants,  'promote_business' => $promote_business, 'activate_ordering_system' => $activate_ordering_system, 'identify_verification' => $identify_verification, 'activate_rpm' => $activate_rpm, 'activate_currency_exchange' => $activate_currency_exchange, 'activate_cash_advance' => $activate_cash_advance, 'activate_crypto_currency_account' => $activate_crypto_currency_account, 'points_acquired'=> $totalPoint 
        ]);
    }

    public function getMainPoint($country){
        $array = [];

        $data = Points::all();

        if(count($data) > 0){
            foreach ($data as $value) {
                $checkuser = User::select('users.id', 'users.name', 'users.businessname', 'users.accountType', 'paysprint_point.add_money', 'paysprint_point.send_money', 'paysprint_point.receive_money', 'paysprint_point.pay_invoice', 'paysprint_point.pay_bills', 'paysprint_point.create_and_send_invoice', 'paysprint_point.active_rental_property', 'paysprint_point.approved_customers', 'paysprint_point.approved_merchants',  'paysprint_point.promote_business', 'paysprint_point.activate_ordering_system', 'paysprint_point.identify_verification', 'paysprint_point.activate_rpm', 'paysprint_point.activate_currency_exchange', 'paysprint_point.activate_cash_advance', 'paysprint_point.activate_crypto_currency_account' )->join('paysprint_point', 'paysprint_point.user_id', '=', 'users.id')->where('users.country', $country)->where('users.id', $value->user_id)->first();

                $array[]=$checkuser;
            }

            return $array;
        }
        else{
            return $array;
        }

        

    }
}