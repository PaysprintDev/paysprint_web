<?php


namespace App\Traits;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\MonerisActivity as MonerisActivity;

use App\BankWithdrawal as BankWithdrawal;

use App\Statement as Statement;

use App\User as User;


trait PaymentGateway{

    public function keepRecord($transaction_id, $message, $activity, $gateway, $country){
        $data = MonerisActivity::insert([

            'transaction_id' => $transaction_id,
            'message' => $message,
            'activity' => $activity,
            'gateway' => $gateway,
            'country' => $country,
        ]);


    }

    public function processRefundMoney($reference_code, $reason){

        try {
            $getStatement = Statement::where('reference_code', $reference_code)->first();

            $debit = $getStatement->debit;


            // Credit User Wallet
            $getUser = User::where('email', $getStatement->user_id)->first();

            $walletBal = $getUser->wallet_balance + $debit;

            User::where('email', $getStatement->user_id)->update(['wallet_balance' => $walletBal]);

            // Delete Bank WithDrawal
            BankWithdrawal::where('transaction_id', $reference_code)->delete();

            // Update Statement
            $query = [
                "user_id" => $getUser->email,
                "reference_code" => $reference_code,
                "activity" => "Refund ".$getUser->currencyCode.''.$debit." to Wallet from PaySprint | Note: ".$reason,
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
                "flag_state" => 0
            ];

            Statement::insert($query);

            $respMessage = "Successful";


        } catch (\Throwable $th) {

            $respMessage = $th->getMessage();

            
        }

        return $respMessage;

    }
    

    

}