<?php

namespace App\Http\Controllers;

use App\AllCountries;
use App\User;
use App\MonthlyFee;
use App\EscrowAccount;
use App\UserClosed;

class MonthlySubController extends Controller
{

    public function creditSubAccount()
    {


        try {


            $currencyFX = new CurrencyFxController();

            $getMontlyFee = MonthlyFee::where('runState', '0')->get();

            $thisuser = User::where('email', 'merchant@paysprint.ca')->first();
            // $thisuser = User::where('email', 'adenugaadebambo41@gmail.com')->first();

            if (count($getMontlyFee) > 0) {


                foreach ($getMontlyFee as $monthlyFee) {
                    // Credit FX wallet account, and create wallet account for not available wallets...

                    // Get My FX Wallets

                    $getOwner = User::where('ref_code', $monthlyFee->ref_code)->first();

                    if (!$getOwner) {
                        $getOwner = UserClosed::where('ref_code', $monthlyFee->ref_code)->first();
                    }


                    $allcountry = AllCountries::where('name', $monthlyFee->country)->first();
                    // Check Escrow wallet
                    $checkAccount = EscrowAccount::where('user_id', $thisuser->id)->where('currencyCode', $allcountry->currencyCode)->first();

                    // Create New Wallet
                    if (!$checkAccount) {
                        // Create the wallet
                        $escrowID = 'ES_' . uniqid() . '_' . strtoupper(date('D'));
                        // Check if ID exists
                        $checkExists = EscrowAccount::where('escrow_id', $escrowID)->first();

                        if (isset($checkExists)) {
                            $escrowID = 'ES_' . uniqid() . '_' . strtoupper(date('D'));
                        }

                        $query = [
                            'user_id' => $thisuser->id,
                            'escrow_id' => $escrowID,
                            'currencyCode' => $allcountry->currencyCode,
                            'currencySymbol' => $allcountry->currencySymbol,
                            'wallet_balance' => "0.00",
                            'country' => $monthlyFee->country,
                            'active' => "false"
                        ];

                        EscrowAccount::insert($query);
                    }


                    // Fund Wallet

                    $myaccount = EscrowAccount::where('user_id', $thisuser->id)->where('currencyCode', $allcountry->currencyCode)->first();


                    $transaction_id = "es-wallet-" . date('dmY') . time();


                    $activity = "Added " . $myaccount->currencyCode . '' . number_format($monthlyFee->amount, 2) . " monthly subscription fee from {$getOwner->name}, with {$getOwner->accountType} account to your FX Wallet.";
                    $credit = $monthlyFee->amount;
                    $debit = 0;
                    $reference_code = $transaction_id;
                    $balance = 0;
                    $trans_date = date('Y-m-d');
                    $status = "Delivered";
                    $action = "Escrow Wallet credit";
                    $action2 = "Wallet debit";
                    $regards = $thisuser->ref_code;
                    $statement_route = "escrow wallet";
                    $statement_route2 = "wallet";

                    $fxBalance = $myaccount->wallet_balance + $monthlyFee->amount;

                    EscrowAccount::where('user_id', $thisuser->id)->where('currencyCode', $allcountry->currencyCode)->update(['wallet_balance' => $fxBalance]);

                    $currencyFX->insFXStatement($myaccount->escrow_id, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, 'on', $myaccount->country, 'confirmed');

                    $currencyFX->insStatement($thisuser->email, $reference_code, $activity, $debit, $credit, $balance, $trans_date, $status, $action2, $regards, 1, $statement_route2, 'on', $thisuser->country);

                    $sendMsg = "Hi " . $thisuser->name . ", You have " . $activity . " Your current fx wallet balance is " . $myaccount->currencyCode . ' ' . number_format($fxBalance, 2) . ".";

                    // $usergetPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

                    // if (isset($usergetPhone)) {

                    //     $sendPhone = $thisuser->telephone;
                    // } else {
                    //     $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
                    // }

                    // if ($thisuser->country == "Nigeria") {

                    //     $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                    //     $currencyFX->sendSms($sendMsg, $correctPhone);
                    // } else {
                    //     $currencyFX->sendMessage($sendMsg, $sendPhone);
                    // }

                    // Log Activities here
                    $currencyFX->createNotification($thisuser->ref_code, $sendMsg);

                    $currencyFX->slack('Congratulations!, ' . $thisuser->name . ' ' . $sendMsg, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));

                    MonthlyFee::where('id', $monthlyFee->id)->update(['runState' => '1']);
                }


                $newsendMsg = 'You have new credit alert to your FX wallet. Please take a look at it.';

                $usergetPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

                if (isset($usergetPhone)) {

                    $sendPhone = $thisuser->telephone;
                } else {
                    $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
                }

                if ($thisuser->country == "Nigeria") {

                    $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                    $currencyFX->sendSms($newsendMsg, $correctPhone);
                } else {
                    $currencyFX->sendMessage($newsendMsg, $sendPhone);
                }
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
