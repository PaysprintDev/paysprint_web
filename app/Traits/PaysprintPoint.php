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
            $identity_verification = $pointAcquired->identity_verification;
            $business_verification = $pointAcquired->business_verification;
            $promote_business = $pointAcquired->promote_business;
            $activate_ordering_system = $pointAcquired->activate_ordering_system;
            $identify_verification = $pointAcquired->identify_verification;
            $activate_rpm = $pointAcquired->identity_verification;
            $activate_currency_exchange = $pointAcquired->activate_currency_exchange;
            $activate_cash_advance = $pointAcquired->activate_cash_advance;
            $activate_crypto_currency_account = $pointAcquired->activate_crypto_currency_account;
        } else {
            $add_money = 0;
            $send_money = 0;
            $receive_money = 0;
            $pay_invoice = 0;
            $pay_bills = 0;
            $create_and_send_invoice = 0;
            $active_rental_property = 0;
            $quick_set_up = 0;
            $identity_verification = 0;
            $business_verification = 0;
            $promote_business = 0;
            $activate_ordering_system = 0;
            $identify_verification = 0;
            $activate_rpm = 0;
            $activate_currency_exchange = 0;
            $activate_cash_advance = 0;
            $activate_crypto_currency_account = 0;
        }

        switch ($activity) {
            case 'Add money':

                $add_money = $add_money + 1;


                break;

            case 'Send money':

                $send_money = $send_money + 1;


                break;
            case 'Receive money':

                $receive_money = $receive_money + 1;


                break;
            case 'Pay invoice':

                $pay_invoice = $pay_invoice + 1;


                break;
            case 'Pay bills':

                $pay_bills = $pay_bills + 1;


                break;
            case 'Create and send invoice':

                $create_and_send_invoice = $create_and_send_invoice + 1;


                break;
            case 'Active rental property':

                $active_rental_property = $active_rental_property + 1;


                break;
            case 'Quick set up':

                $quick_set_up = $quick_set_up + 1;


                break;
            case 'Identity verification':

                $identity_verification = $identity_verification + 1;


                break;
            case 'Business verification':

                $business_verification = $business_verification + 1;


                break;
            case 'Promote business':

                $promote_business = $promote_business + 1;


                break;
            case 'Activate ordering system':

                $activate_ordering_system = $activate_ordering_system + 1;


                break;
            case 'Identify verification':

                $identify_verification = $identify_verification + 1;


                break;
            case 'Activate rpm':

                $activate_rpm = $activate_rpm + 1;


                break;
            case 'Activate currency exchange':

                $activate_currency_exchange = $activate_currency_exchange + 1;


                break;
            case 'Activate cash advance':

                $activate_cash_advance = $activate_cash_advance + 1;


                break;
            case 'Activate crypto currency account':

                $activate_crypto_currency_account = $activate_crypto_currency_account + 1;


                break;
            default:
                echo "Nothing";
                break;
        }

        Points::updateOrCreate(['user_id' => $user_id], [
            'user_id' => $user_id, 'add_money' => $add_money, 'send_money' => $send_money, 'receive_money' => $receive_money, 'pay_invoice' => $pay_invoice, 'pay_bills' => $pay_bills, 'create_and_send_invoice' => $create_and_send_invoice, 'active_rental_property' => $active_rental_property, 'quick_set_up' => $quick_set_up, 'identity_verification' => $identity_verification, 'business_verification' => $business_verification, 'promote_business' => $promote_business, 'activate_ordering_system' => $activate_ordering_system, 'identify_verification' => $identify_verification, 'activate_rpm' => $activate_rpm, 'activate_currency_exchange' => $activate_currency_exchange, 'activate_cash_advance' => $activate_cash_advance, 'activate_crypto_currency_account' => $activate_crypto_currency_account
        ]);
    }

    public function getMainPoint($country){
        $array = [];

        $data = Points::all();

        if(count($data) > 0){
            foreach ($data as $value) {
                $checkuser = User::select('users.id', 'users.name', 'users.businessname', 'users.accountType', 'paysprint_point.add_money', 'paysprint_point.send_money', 'paysprint_point.receive_money', 'paysprint_point.pay_invoice', 'paysprint_point.pay_bills', 'paysprint_point.create_and_send_invoice', 'paysprint_point.active_rental_property', 'paysprint_point.quick_set_up', 'paysprint_point.identity_verification', 'paysprint_point.business_verification', 'paysprint_point.promote_business', 'paysprint_point.activate_ordering_system', 'paysprint_point.identify_verification', 'paysprint_point.activate_rpm', 'paysprint_point.activate_currency_exchange', 'paysprint_point.activate_cash_advance', 'paysprint_point.activate_crypto_currency_account' )->join('paysprint_point', 'paysprint_point.user_id', '=', 'users.id')->where('users.country', $country)->where('users.id', $value->user_id)->first();

                $array[]=$checkuser;
            }

            return $array;
        }
        else{
            return $array;
        }

        

    }
}