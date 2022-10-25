<?php

namespace App\Http\Controllers;

use App\User;
use App\Statement;
use App\MonthlyFee;
use App\UserClosed;
use App\FxStatement;
use App\AllCountries;
use App\EscrowAccount;

class MonthlySubController extends Controller
{

    public function ____creditSubAccount()
    {


        try {


            $currencyFX = new CurrencyFxController();

            $getMontlyFee = MonthlyFee::where('runState', '0')->get();

            $receiverMail = env('APP_ENV') === 'local' ? 'adenugaadebambo41@gmail.com' : 'merchant@paysprint.ca';

            $thisuser = User::where('email', $receiverMail)->first();
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
                    $regards = $thisuser->ref_code;
                    $statement_route = "escrow wallet";
                    $statement_route2 = "wallet";

                    $fxBalance = $myaccount->wallet_balance + $monthlyFee->amount;

                    EscrowAccount::where('user_id', $thisuser->id)->where('currencyCode', $allcountry->currencyCode)->update(['wallet_balance' => $fxBalance]);

                    $currencyFX->insFXStatement($myaccount->escrow_id, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, 'on', $myaccount->country, 'confirmed');

                    $currencyFX->insStatement($thisuser->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route2, $thisuser->country);

                    $sendMsg = "Hi " . $thisuser->name . ", You have " . $activity . " Your current fx wallet balance is " . $myaccount->currencyCode . ' ' . number_format($fxBalance, 2) . ".";

                    $usergetPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

                    if (isset($usergetPhone)) {

                        $sendPhone = $thisuser->telephone;
                    } else {
                        $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
                    }

                    if ($thisuser->country == "Nigeria") {

                        $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                        $currencyFX->sendSms($sendMsg, $correctPhone);
                    } else {
                        $currencyFX->sendMessage($sendMsg, $sendPhone);
                    }

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



    public function monthlycreditAccount($country, $amount, $name, $accountType)
    {
        try {

            $currencyFX = new CurrencyFxController();
            $maintenanceFee = new MaintenanceFeeCharge();

            $receiverMail = env('APP_ENV') === 'local' ? 'adenugaadebambo41@gmail.com' : 'merchant@paysprint.ca';

            $thisuser = User::where('email', $receiverMail)->first();


            $allcountry = AllCountries::where('name', $country)->first();

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
                    'country' => $country,
                    'active' => "false"
                ];

                EscrowAccount::insert($query);
            }


                        // Fund Wallet

            $myaccount = EscrowAccount::where('user_id', $thisuser->id)->where('currencyCode', $allcountry->currencyCode)->first();


            $transaction_id = "es-wallet-" . date('dmY') . time();


            $activity = "Added " . $myaccount->currencyCode . '' . number_format($amount, 2) . " monthly subscription fee from {$name}, with {$accountType} account to your FX Wallet.";
            $credit = $amount;
            $debit = 0;
            $reference_code = $transaction_id;
            $balance = 0;
            $trans_date = date('Y-m-d');
            $status = "Delivered";
            $action = "Escrow Wallet credit";
            $regards = $thisuser->ref_code;
            $statement_route = "escrow wallet";

            $fxBalance = $myaccount->wallet_balance + $amount;

            EscrowAccount::where('user_id', $thisuser->id)->where('currencyCode', $allcountry->currencyCode)->update(['wallet_balance' => $fxBalance]);

            $currencyFX->insFXStatement($myaccount->escrow_id, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, 'on', $myaccount->country, 'confirmed');

            $currencyFX->insStatement($thisuser->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, $country);

            $sendMsg = "Hi " . $thisuser->name . ", You have " . $activity . " Your current fx wallet balance on {$myaccount->currencyCode} is " . $myaccount->currencyCode . ' ' . number_format($fxBalance, 2) . ".";

            $usergetPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

            if (isset($usergetPhone)) {

                $sendPhone = $thisuser->telephone;
            } else {
                $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
            }

            if ($thisuser->country == "Nigeria") {

                $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                $currencyFX->sendSms($sendMsg, $correctPhone);
            } else {
                $currencyFX->sendMessage($sendMsg, $sendPhone);
            }

            $today = date('Y-m-d');


            $recMessage = "<p>This is a confirmation that your PaySprint FX wallet on {$myaccount->currencyCode} has been top-up and received from {$name}, with {$accountType} account. The subscription next renewal date is ".date('d-m-Y', strtotime($today. "+28 days")).".</p>";

            $currencyFX->createNotification($thisuser->ref_code, "Hello " . strtoupper($thisuser->name) . ", " . $sendMsg);

            $maintenanceFee->name = $thisuser->name;
            $maintenanceFee->email = $thisuser->email;
            $maintenanceFee->subject = $activity;

            $maintenanceFee->message = '<p>' . $recMessage . '</p><p>You now have <strong>' . $myaccount->currencyCode . ' ' . number_format($fxBalance, 2) . '</strong> balance in your account</p>';

            $maintenanceFee->monthlyChargeInsert($thisuser->ref_code, $myaccount->country, $amount, $myaccount->currencyCode);

            $currencyFX->slack($sendMsg, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));


            $maintenanceFee->sendEmail($thisuser->email, "Fund remittance");


            echo "Done";



        } catch (\Throwable $th) {
            throw $th;
        }
    }


    public function feeChargeCredit($country, $amount, $name, $accountType)
    {
        try {

            $currencyFX = new CurrencyFxController();
            $maintenanceFee = new MaintenanceFeeCharge();

            $receiverMail = env('APP_ENV') === 'local' ? 'adenugaadebambo41@gmail.com' : 'merchant@paysprint.ca';

            $thisuser = User::where('email', $receiverMail)->first();

            $allcountry = AllCountries::where('name', $country)->first();

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
                    'country' => $country,
                    'active' => "false"
                ];

                EscrowAccount::insert($query);
            }


                        // Fund Wallet

            $myaccount = EscrowAccount::where('user_id', $thisuser->id)->where('currencyCode', $allcountry->currencyCode)->first();


            $transaction_id = "es-wallet-" . date('dmY') . time();


            $activity = "Received " . $myaccount->currencyCode . '' . number_format($amount, 2) . " for payment link charge fee from {$name}, with {$accountType} account to your FX Wallet.";
            $credit = $amount;
            $debit = 0;
            $reference_code = $transaction_id;
            $balance = 0;
            $trans_date = date('Y-m-d');
            $status = "Delivered";
            $action = "Escrow Wallet credit";
            $regards = $thisuser->ref_code;
            $statement_route = "escrow wallet";

            $fxBalance = $myaccount->wallet_balance + $amount;

            EscrowAccount::where('user_id', $thisuser->id)->where('currencyCode', $allcountry->currencyCode)->update(['wallet_balance' => $fxBalance]);

            $currencyFX->insFXStatement($myaccount->escrow_id, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, 'on', $myaccount->country, 'confirmed');

            $currencyFX->insStatement($thisuser->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, $country);

            $sendMsg = "Hi " . $thisuser->name . ", You have " . $activity . " Your current fx wallet balance on {$myaccount->currencyCode} is " . $myaccount->currencyCode . ' ' . number_format($fxBalance, 2) . ".";

            $usergetPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

            if (isset($usergetPhone)) {

                $sendPhone = $thisuser->telephone;
            } else {
                $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
            }

            if ($thisuser->country == "Nigeria") {

                $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                $currencyFX->sendSms($sendMsg, $correctPhone);
            } else {
                $currencyFX->sendMessage($sendMsg, $sendPhone);
            }



            $recMessage = "<p>This is a confirmation that your PaySprint FX wallet on {$myaccount->currencyCode} has been top-up and received from {$name}, with {$accountType} account.</p>";

            $currencyFX->createNotification($thisuser->ref_code, "Hello " . strtoupper($thisuser->name) . ", " . $sendMsg);

            $maintenanceFee->name = $thisuser->name;
            $maintenanceFee->email = $thisuser->email;
            $maintenanceFee->subject = $activity;

            $maintenanceFee->message = '<p>' . $recMessage . '</p><p>You now have <strong>' . $myaccount->currencyCode . ' ' . number_format($fxBalance, 2) . '</strong> balance in your account</p>';

            $currencyFX->slack($sendMsg, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));


            $maintenanceFee->sendEmail($thisuser->email, "Fund remittance");


        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function ___correctStatementRecord()
    {
        try {

            $receiverMail = env('APP_ENV') === 'local' ? 'adenugaadebambo41@gmail.com' : 'merchant@paysprint.ca';

            $getStatement = Statement::where('user_id', $receiverMail)->where('reference_code', 'LIKE', '%es-wallet-%')->inRandomOrder()->get();


            foreach ($getStatement as $value) {
                $getFxstatement = FxStatement::where('activity', $value->activity)->first();

                Statement::where('activity', $getFxstatement->activity)->update([
                    'credit' => $getFxstatement->credit,
                    'debit' => $getFxstatement->debit,
                    'country' => $getFxstatement->country,
                    'action' => "Escrow Wallet credit"
                ]);

            }

            echo "Done";

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}


// UPDATE statement SET country = 'Nigeria' WHERE user_id = 'merchant@paysprint.ca' AND activity LIKE '%Added NGN%';
// UPDATE statement SET country = 'United States' WHERE user_id = 'merchant@paysprint.ca' AND activity LIKE '%Added USD%';
// UPDATE statement SET country = 'United Kingdom' WHERE user_id = 'merchant@paysprint.ca' AND activity LIKE '%Added GBP%';
// SELECT * FROM `statement` WHERE user_id = 'merchant@paysprint.ca' AND activity LIKE '%Added USD%';
