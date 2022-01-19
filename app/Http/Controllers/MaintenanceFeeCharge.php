<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Log;

use App\User as User;

use App\MonthlyFee as MonthlyFee;

use App\UpgradePlan as UpgradePlan;

use App\TransactionCost as TransactionCost;

use App\Statement as Statement;

use App\Mail\sendEmail;
use Carbon\Carbon;

use App\Traits\Xwireless;

class MaintenanceFeeCharge extends Controller
{

    use Xwireless;

    public function monthlyMaintenaceFee()
    {

        try {



            $getUser = User::where('wallet_balance', '>', 0)->where('disableAccount', 'off')->get();


            $i = 1;
            foreach ($getUser as $value) {



                if ($value->accountType == "Individual") {
                    $subType = "Consumer Monthly Subscription";
                } else {
                    $subType = "Merchant Monthly Subscription";
                }


                $minBal = $this->maintenanceBalanceWithdrawal($subType, $value->country);


                // Get wallet balnace for users
                if ($value->wallet_balance >= $minBal) {

                    $getTranscost = TransactionCost::where('structure', $subType)->where('country', $value->country)->first();

                    if (isset($getTranscost)) {


                        $getUpdate = User::where('id', $value->id)->where('wallet_balance', '>=', $minBal)->first();

                        if (isset($getUpdate)) {

                            $walletBalance = $getUpdate->wallet_balance - $getTranscost->fixed;


                            // User::where('id', $getUpdate->id)->where('wallet_balance', '>=', $minBal)->update(['wallet_balance' => $walletBalance]);

                            // Send Mail
                            $transaction_id = "wallet-" . date('dmY') . time();

                            $activity = $subType . " of " . $getUpdate->currencyCode . '' . number_format($getTranscost->fixed, 2) . " for " . date('F/Y') . " was deducted from Wallet";
                            $credit = 0;
                            $debit = $getTranscost->fixed;
                            $reference_code = $transaction_id;
                            $balance = 0;
                            $trans_date = date('Y-m-d');
                            $status = "Delivered";
                            $action = "Wallet debit";
                            $regards = $getUpdate->ref_code;
                            $statement_route = "wallet";


                            $sendMsg = 'Hello ' . strtoupper($getUpdate->name) . ', ' . $activity . '. You now have ' . $getUpdate->currencyCode . ' ' . number_format($walletBalance, 2) . ' balance in your account';
                            $sendPhone = "+" . $getUpdate->code . $getUpdate->telephone;


                            // Senders statement
                            // $this->insStatement($getUpdate->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route);

                            // $this->createNotification($getUpdate->ref_code, "Hello " . strtoupper($getUpdate->name) . ", " . $sendMsg);

                            $this->name = $getUpdate->name;
                            $this->email = $getUpdate->email;
                            $this->subject = $activity;

                            $this->message = '<p>' . $activity . '</p><p>You now have <strong>' . $getUpdate->currencyCode . ' ' . number_format($walletBalance, 2) . '</strong> balance in your account</p>';

                            // $this->monthlyChargeInsert($getUpdate->ref_code, $getUpdate->country, $getTranscost->fixed, $getUpdate->currencyCode);



                            // Log::info($sendMsg);

                            // $this->slack($sendMsg, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));

                            // $this->sendMessage($sendMsg, $sendPhone);

                            // $this->sendEmail($this->email, "Fund remittance");



                            // echo "Sent to " . $i++ . " | " . $this->name . ' - ' . $getUpdate->ref_code . " | " . $activity . " | " . $sendMsg . "<hr>";
                        }
                    } else {
                        // Log::info($value->name." was not charged because they are in ".$value->country." and the fee charge is not yet available");

                        // $this->slack($value->name . " was not charged because they are in " . $value->country . " and the fee charge is not yet available", $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));
                    }
                } else {
                    // This is a new user account
                    // Log::info($value->name." was not charged because account has ".$value->wallet_balance." in their wallet");

                    // $this->slack($value->name . " was not charged because account has " . $value->wallet_balance . " in their wallet", $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));
                }
            }
        } catch (\Throwable $th) {
            $this->slack("Error on Maintenance Fee Charge: " . $th->getMessage(), $room = "error-logs", $icon = ":longbox:", env('LOG_SLACK_WEBHOOK_URL'));
        }
    }

    // public function checkMaintenanceFeeCharge($ref_code)
    // {
    //     $checker = MonthlyFee::where('ref_code', $ref_code)->first();

    //     if (isset($checker)) {
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }


    public function renewSubscription()
    {
        try {
            $todaysDate = Carbon::now()->toDateTimeString();

            $getUsers = UpgradePlan::where('expire_date', '<=', $todaysDate)->get();


            if (count($getUsers) > 0) {

                foreach ($getUsers as $value) {

                    $users = User::where('ref_code', $value->userId)->first();

                    if ($users->accountType == "Individual") {
                        $subType = "Consumer Monthly Subscription";
                    } else {
                        $subType = "Merchant Monthly Subscription";
                    }

                    $walletBalance = $users->wallet_balance;

                    $getTranscost = TransactionCost::where('structure', $subType)->where('country', $users->country)->first();

                    $duration = "monthly";
                    $expire_date = Carbon::now()->addMonth()->toDateTimeString();


                    if ($walletBalance >= $getTranscost->fixed) {

                        $amount = $getTranscost->fixed;


                        UpgradePlan::updateOrInsert(['userId' => $users->ref_code], ['userId' => $users->ref_code, 'plan' => 'classic', 'amount' => $amount, 'duration' => $duration, 'expire_date' => $expire_date]);

                        $newBalance = $walletBalance - $amount;

                        $planName = 'classic';

                        User::where('id', $users->id)->update(['wallet_balance' => $newBalance]);


                        // Send Mail
                        $transaction_id = "wallet-" . date('dmY') . time();

                        $activity = $subType . " of " . $users->currencyCode . '' . number_format($amount, 2) . " charged from your Wallet. Your current plan is " . strtoupper($planName);
                        $credit = 0;
                        $debit = $amount;
                        $reference_code = $transaction_id;
                        $balance = 0;
                        $trans_date = date('Y-m-d');
                        $status = "Delivered";
                        $action = "Wallet debit";
                        $regards = $users->ref_code;
                        $statement_route = "wallet";


                        $sendMsg = 'Hello ' . strtoupper($users->name) . ', ' . $activity . '. You now have ' . $users->currencyCode . ' ' . number_format($newBalance, 2) . ' balance in your account';
                        $sendPhone = "+" . $users->code . $users->telephone;

                        $this->insStatement($users->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route);

                        $this->createNotification($users->ref_code, "Hello " . strtoupper($users->name) . ", " . $sendMsg);

                        $this->name = $users->name;
                        $this->email = $users->email;
                        $this->subject = $activity;

                        $this->message = '<p>' . $activity . '</p><p>You now have <strong>' . $users->currencyCode . ' ' . number_format($newBalance, 2) . '</strong> balance in your account</p>';

                        $this->monthlyChargeInsert($users->ref_code, $users->country, $amount, $users->currencyCode);

                        $this->slack($sendMsg, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));


                        $this->sendEmail($this->email, "Fund remittance");


                        $usergetPhone = User::where('email', $users->email)->where('telephone', 'LIKE', '%+%')->first();

                        if (isset($usergetPhone)) {

                            $sendPhone = $users->telephone;
                        } else {
                            $sendPhone = "+" . $users->code . $users->telephone;
                        }

                        if ($users->country == "Nigeria") {

                            $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                            $this->sendSms($sendMsg, $correctPhone);
                        } else {
                            $this->sendMessage($sendMsg, $sendPhone);
                        }
                    } else {
                        // Put account to basic plan
                        User::where('id', $users->id)->update(['plan' => 'basic']);

                        UpgradePlan::updateOrInsert(['userId' => $users->ref_code], ['userId' => $users->ref_code, 'plan' => 'basic', 'amount' => "0", 'duration' => $duration, 'expire_date' => $expire_date]);
                    }


                    echo "Done";
                }
            } else {
                $this->slack('No expired subscription today: ' . $todaysDate, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));

                echo 'No expired subscription today: ' . $todaysDate;
            }
        } catch (\Throwable $th) {

            $this->slack("Error on Renew Subscription: " . $th->getMessage(), $room = "error-logs", $icon = ":longbox:", env('LOG_SLACK_WEBHOOK_URL'));
        }
    }


    public function returnFeeCharge()
    {

        $users = User::where('wallet_balance', '<', 0)->get();


        foreach ($users as $user) {
            // Check User where walletbalance is < 0
            $checker = MonthlyFee::where('ref_code', $user->ref_code)->where('created_at', '>', date('2021-10-27'))->first();

            if (isset($checker)) {

                $walletBalance = $user->wallet_balance + $checker->amount;


                User::where('id', $user->id)->update(['wallet_balance' => $walletBalance]);

                $transaction_id = "wallet-" . date('dmY') . time();

                $activity = "Monthly maintenance fee of " . $user->currencyCode . '' . number_format($checker->amount, 2) . " for " . date('F/Y') . " was reversed back to Wallet";
                $credit = $checker->amount;
                $debit = 0;
                $reference_code = $transaction_id;
                $balance = 0;
                $trans_date = date('Y-m-d');
                $status = "Delivered";
                $action = "Wallet credit";
                $regards = $user->ref_code;
                $statement_route = "wallet";


                $sendMsg = 'Hello ' . strtoupper($user->name) . ', ' . $activity . '. You now have ' . $user->currencyCode . ' ' . number_format($walletBalance, 2) . ' balance in your account';
                $sendPhone = "+" . $user->code . $user->telephone;


                // Senders statement
                $this->insStatement($user->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route);

                $this->createNotification($user->ref_code, "Hello " . strtoupper($user->name) . ", " . $sendMsg);

                MonthlyFee::where('ref_code', $user->ref_code)->where('created_at', '>', date('2021-10-27'))->delete();


                echo "Done for " . $user->name . " | Wallet Balance: " . $walletBalance . "<hr>";
            }
        }
    }

    public function insStatement($email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, $state, $statement_route)
    {
        Statement::insert(['user_id' => $email, 'reference_code' => $reference_code, 'activity' => $activity, 'credit' => $credit, 'debit' => $debit, 'balance' => $balance, 'trans_date' => $trans_date, 'status' => $status, 'action' => $action, 'regards' => $regards, 'state' => $state, 'statement_route' => $statement_route]);
    }


    public function monthlyChargeInsert($ref_code, $country, $amount, $currency)
    {
        MonthlyFee::insert(['ref_code' => $ref_code, 'country' => $country, 'amount' => $amount, 'currency' => $currency]);
    }


    public function sendEmail($objDemoa, $purpose)
    {
        $objDemo = new \stdClass();
        $objDemo->purpose = $purpose;
        if ($purpose == 'Fund remittance') {
            $objDemo->name = $this->name;
            $objDemo->email = $this->email;
            $objDemo->subject = $this->subject;
            $objDemo->message = $this->message;
        }

        Mail::to($objDemoa)
            ->send(new sendEmail($objDemo));
    }
}