<?php


namespace App\Traits;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\MonerisActivity as MonerisActivity;

use App\BankWithdrawal as BankWithdrawal;

use App\Statement as Statement;

use App\PricingSetup as PricingSetup;

use App\User as User;
use Illuminate\Support\Facades\Log;

trait PaymentGateway
{

    public function keepRecord($transaction_id, $message, $activity, $gateway, $country)
    {
        $data = MonerisActivity::insert([

            'transaction_id' => $transaction_id,
            'message' => $message,
            'activity' => $activity,
            'gateway' => $gateway,
            'country' => $country,
        ]);
    }

    public function actOnRefundMoney($reference_code, $reason)
    {

        try {
            $getStatement = Statement::where('reference_code', $reference_code)->first();

            Statement::where('reference_code', $reference_code)->update(["refund_state" => "1", "comment" => $reason]);

            $respMessage = "Successful";
        } catch (\Throwable $th) {

            $respMessage = $th->getMessage();
        }

        return $respMessage;
    }

    public function processRefundMoney($reference_code, $reason)
    {

        try {
            $getStatement = Statement::where('reference_code', $reference_code)->first();

            $debit = $getStatement->debit;


            // Credit User Wallet
            $getUser = User::where('email', $getStatement->user_id)->first();

            $walletBal = $getUser->wallet_balance + $debit;

            User::where('email', $getStatement->user_id)->update(['wallet_balance' => $walletBal]);

            // Delete Bank WithDrawal
            BankWithdrawal::where('transaction_id', $reference_code)->delete();
            Statement::where('reference_code', $reference_code)->update(["refund_state" => "1", "actedOn" => "1", "comment" => $reason]);
            // Update Statement
            $query = [
                "user_id" => $getUser->email,
                "reference_code" => $reference_code,
                "activity" => "Refund " . $getUser->currencyCode . '' . $debit . " to Wallet from PaySprint | Note: " . $reason,
                "credit" => $debit,
                "debit" => "0",
                "balance" => "0",
                "chargefee" => "0",
                "auto_deposit" => "on",
                "trans_date" => date('Y-m-d'),
                "status" => "Delivered",
                "comment" => $reason,
                "action" => "Wallet credit",
                "regards" => $getUser->ref_code,
                "country" => $getUser->country,
                "statement_route" => "wallet",
                "refund_state" => "1",
                "actedOn" => "1",
                'report_status' => 'Money received',
                "flag_state" => 0
            ];

            Statement::insert($query);



            $respMessage = "Successful";
        } catch (\Throwable $th) {

            $respMessage = $th->getMessage();
        }

        return $respMessage;
    }

    public function processPromoteBusinessRefund($email)
    {
        try {
            $getStatement = Statement::where('user_id', $email)->where('activity', 'LIKE', '%Promote Business%')->where('debit', '>', 0)->orderBy('created_at', 'DESC')->first();

            $debit = $getStatement->debit;


            // Credit User Wallet
            $getUser = User::where('email', $getStatement->user_id)->first();

            $walletBal = $getUser->wallet_balance + $debit;

            User::where('email', $getStatement->user_id)->update(['wallet_balance' => $walletBal]);

            // Delete Bank WithDrawal
            Statement::where('reference_code', $getStatement->reference_code)->update(["refund_state" => "1", "actedOn" => "1"]);
            // Update Statement
            $query = [
                "user_id" => $getUser->email,
                "reference_code" => $getStatement->reference_code,
                "activity" => "Refund " . $getUser->currencyCode . '' . $debit . " to Wallet from PaySprint for Promoted Business.",
                "credit" => $debit,
                "debit" => "0",
                "balance" => "0",
                "chargefee" => "0",
                "auto_deposit" => "on",
                "trans_date" => date('Y-m-d'),
                "status" => "Delivered",
                "comment" => "",
                "action" => "Wallet credit",
                "regards" => $getUser->ref_code,
                "country" => $getUser->country,
                "statement_route" => "wallet",
                "refund_state" => "1",
                "actedOn" => "1",
                'report_status' => 'Money received',
                "flag_state" => 0
            ];

            Statement::insert($query);



            $respMessage = "Successful";
        } catch (\Throwable $th) {

            $respMessage = $th->getMessage();
        }

        return $respMessage;
    }


    public function getWithdrawalLimit($country, $id)
    {
        try {
            $getPrice = PricingSetup::where('country', $country)->first();

            $getUser = User::where('id', $id)->first();

            if (isset($getPrice)) {
                if ($getUser->accountType == "Individual") {
                    $result = [
                        'withdrawal_per_transaction' => $getPrice->withdrawal_per_transaction,
                        'withdrawal_per_day' => $getPrice->withdrawal_per_day,
                        'withdrawal_per_week' => $getPrice->withdrawal_per_week,
                        'withdrawal_per_month' => $getPrice->withdrawal_per_month
                    ];
                } else {
                    $result = [
                        'withdrawal_per_transaction' => $getPrice->merchant_withdrawal_per_transaction,
                        'withdrawal_per_day' => $getPrice->merchant_withdrawal_per_day,
                        'withdrawal_per_week' => $getPrice->merchant_withdrawal_per_week,
                        'withdrawal_per_month' => $getPrice->merchant_withdrawal_per_month
                    ];
                }
            } else {
                if ($getUser->accountType == "Individual") {
                    $result = [
                        'withdrawal_per_transaction' => 0,
                        'withdrawal_per_day' => 0,
                        'withdrawal_per_week' => 0,
                        'withdrawal_per_month' => 0
                    ];
                } else {
                    $result = [
                        'withdrawal_per_transaction' => 0,
                        'withdrawal_per_day' => 0,
                        'withdrawal_per_week' => 0,
                        'withdrawal_per_month' => 0
                    ];
                }
            }



            return $result;
        } catch (\Throwable $th) {
            Log::alert("Get Withdrawal Limit Error, Line 188 Traits/PaymentGateway.php" . $th->getMessage());
        }
    }

    public function countryWithdrawalLimit($country)
    {
        $getPrice = PricingSetup::where('country', $country)->first();

        return $getPrice;
    }
}
