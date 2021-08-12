<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Log;

use App\User as User;

use App\MonthlyFee as MonthlyFee;

use App\TransactionCost as TransactionCost;

use App\Statement as Statement;

use App\Mail\sendEmail;

class MaintenanceFeeCharge extends Controller
{
    public function monthlyMaintenaceFee(Request $req){

        $getUser = User::where('disableAccount', 'off')->inRandomOrder()->get();

        foreach($getUser as $key => $value){


            // Get wallet balnace for users
            if($value->wallet_balance >= 5){
                
                $getTranscost = TransactionCost::where('structure', 'Wallet Maintenance fee')->where('country', $value->country)->first();

                if(isset($getTranscost)){



                    $walletBalance = $value->wallet_balance - $getTranscost->fixed;

                    User::where('id', $value->id)->update(['wallet_balance' => $walletBalance]);

                    // Send Mail
                    $transaction_id = "wallet-".date('dmY').time();

                    $activity = "Monthly maintenance fee of ".$value->currencyCode.''.number_format($getTranscost->fixed, 2)." for ".date('F/Y')." was deducted from Wallet";
                    $credit = 0;
                    $debit = number_format($getTranscost->fixed, 2);
                    $reference_code = $transaction_id;
                    $balance = 0;
                    $trans_date = date('Y-m-d');
                    $status = "Delivered";
                    $action = "Wallet debit";
                    $regards = $value->ref_code;
                    $statement_route = "wallet";


                    $sendMsg = 'Hello '.strtoupper($value->name).', '.$activity.'. You now have '.$value->currencyCode.' '.number_format($walletBalance, 2).' balance in your account';
                    $sendPhone = "+".$value->code.$value->telephone;


                    // Senders statement
                    $this->insStatement($value->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route);

                    $this->createNotification($value->ref_code, "Hello ".strtoupper($value->name).", ".$sendMsg);

                    $this->name = $value->name;
                    $this->email = $value->email;
                    $this->subject = $activity;

                    $this->message = '<p>'.$activity.'</p><p>You now have <strong>'.$value->currencyCode.' '.number_format($walletBalance, 2).'</strong> balance in your account</p>';


                    // Log::info($sendMsg);

                    $this->slack($sendMsg, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));

                    // $this->sendMessage($sendMsg, $sendPhone);

                    // $this->sendEmail($this->email, "Fund remittance");

                    $this->monthlyChargeInsert($value->ref_code, $value->country, $getTranscost->fixed, $value->currencyCode);


                    echo "Sent to ".$this->name."<hr>";

                }
                else{
                    // Log::info($value->name." was not charged because they are in ".$value->country." and the fee charge is not yet available");

                    $this->slack($value->name." was not charged because they are in ".$value->country." and the fee charge is not yet available", $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));
                }
            }
            else{
                // This is a new user account
                // Log::info($value->name." was not charged because account has ".$value->wallet_balance." in their wallet");

                $this->slack($value->name." was not charged because account has ".$value->wallet_balance." in their wallet", $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));
            }

            
        }

    }



    public function insStatement($email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, $state, $statement_route){
        Statement::insert(['user_id' => $email, 'reference_code' => $reference_code, 'activity' => $activity, 'credit' => $credit, 'debit' => $debit, 'balance' => $balance, 'trans_date' => $trans_date, 'status' => $status, 'action' => $action, 'regards' => $regards, 'state' => $state, 'statement_route' => $statement_route]);
    }


    public function monthlyChargeInsert($ref_code, $country, $amount, $currency){
        MonthlyFee::insert(['ref_code' => $ref_code, 'country' => $country, 'amount' => $amount, 'currency' => $currency]);
    }
    
    
    public function sendEmail($objDemoa, $purpose){
      $objDemo = new \stdClass();
      $objDemo->purpose = $purpose;
        if($purpose == 'Fund remittance'){
            $objDemo->name = $this->name;
            $objDemo->email = $this->email;
            $objDemo->subject = $this->subject;
            $objDemo->message = $this->message;
        }

      Mail::to($objDemoa)
            ->send(new sendEmail($objDemo));
   }



}
