<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\DB;

use App\User as User;

use App\Mail\sendEmail;

use App\CreateEvent as CreateEvent;

use App\SetupBilling as SetupBilling;

use App\InvoicePayment as InvoicePayment;

use App\ImportExcel as ImportExcel;

use App\ClientInfo as ClientInfo;

use App\OrganizationPay as OrganizationPay;

use App\PaycaWithdraw as PaycaWithdraw;

use App\Epaywithdraw as Epaywithdraw;

use App\Statement as Statement;

use App\ReceivePay as ReceivePay;

use App\TransactionCost as TransactionCost;

class MoneyTransferController extends Controller
{


    public $to;
    public $name;
    public $email;
    public $transaction_date;
    public $invoice_no;
    public $payee_ref_no;
    public $transaction_ref;
    public $description;
    public $payment_due_date;
    public $amount;
    public $address;
    public $clientname;
    public $subject;
    public $paypurpose;
    public $service;
    public $city;
    public $state;
    public $zipcode;
    public $coy_name;
    public $url = "https://exbc.ca/api/v1/points/earnpoint";
    // public $url = "http://localhost:4000/api/v1/points/earnpoint";
    public $curl_data;


    public function commissionFee(Request $req){
        $amount = $req->get('amount');

        if($amount != ""){
            // Get Commission

            $data = TransactionCost::first();

            $fixed = $amount * ($data->fixed / 100);

            $variable = $data->fixed * 1;

            $collection = $fixed + $variable;

            $status = 200;

            $resData = ['data' => $collection,'message' => 'success', 'status' => $status];

        }
        else{
            $status = 400;

            $resData = ['message' => 'Type an amount', 'status' => $status];
        }


        return $this->returnJSON($resData, $status);
    }

    public function getReceiver(Request $req){

        $accountno = $req->get('accountNumber');

        $user = User::where('api_token', $req->bearerToken())->first();

        if(isset($user)){


            if($user->approval == 0){

                $status = 400;
    
                $resData = ['message' => 'You cannot send or receive money now, because your account is not yet approved. Kindly update means of identification in your profile', 'status' => $status];
            }
            else{
                if($user->ref_code != $accountno){
                    // Get User Information
                    $getUser = User::select('name', 'ref_code as accountNumber', 'address', 'city', 'state', 'country')->where('ref_code', $accountno)->first();
    
                    if(isset($getUser)){
                        $status = 200;
    
                        $resData = ['data' => $getUser, 'message' => 'success', 'status' => $status];
                    }
                    else{
                        $status = 404;
    
                        $resData = ['message' => 'No record found', 'status' => $status];
                    }
    
                }
                else{
                    $status = 400;
    
                    $resData = ['message' => 'You cannot send money to yourself', 'status' => $status];
                }
            }


        }
        else{
            $status = 400;

            $resData = ['message' => 'Token mismatch', 'status' => $status];
        }

        return $this->returnJSON($resData, $status);

    }

    public function getSender(Request $req){
        $accountno = $req->get('accountNumber');

        $user = User::where('api_token', $req->bearerToken())->first();

        if(isset($user)){

            if($user->approval == 0){

                $status = 400;
    
                $resData = ['message' => 'You cannot send or receive money now, because your account is not yet approved. Kindly update means of identification in your profile', 'status' => $status];
            }
            else{
                if($user->ref_code != $accountno){
                    // Get User Information
                    $getUser = DB::table('organization_pay')
                    ->select(DB::raw('organization_pay.id as itemId, organization_pay.purpose, organization_pay.amount_to_send as amountToReceive, users.ref_code as accountNumber, users.name, users.address, users.city, users.state, users.country'))
                    ->join('users', 'organization_pay.payer_id', '=', 'users.ref_code')->
                    where('organization_pay.payer_id', $accountno)->where('organization_pay.coy_id', $user->ref_code)->where('organization_pay.state', 1)->where('organization_pay.request_receive', '!=', 2)->get();
    
                    if(isset($getUser)){
                        $status = 200;
    
                        $resData = ['data' => $getUser, 'message' => 'success', 'status' => $status];
                    }
                    else{
                        $status = 404;
    
                        $resData = ['message' => 'No record found', 'status' => $status];
                    }
    
                }
                else{
                    $status = 400;
    
                    $resData = ['message' => 'You can not receive money from yourself', 'status' => $status];
                }
            }


        }
        else{
            $status = 400;

            $resData = ['message' => 'Token mismatch', 'status' => $status];
        }

        return $this->returnJSON($resData, $status);
    }

    public function sendMoney(Request $req){
        
        // Get Sender in User
        $sender = User::where('api_token', $req->bearerToken())->first();

        if(isset($sender)){

        // Get Receivers Details
        $receiver = User::where('ref_code', $req->accountNumber)->first();


        if(isset($receiver)){

            if($req->approveCommission == "Yes"){
                $amount= number_format($req->amount, 2);
                $approve_commission = "Yes";
            }
            else{
            
                $amount= number_format($req->amount+$req->commission, 2);
                $approve_commission = "No";
            
            }

            if($req->purposeOfPayment != "Others"){
                $service = $req->purposeOfPayment;
            }
            else{
                $service = $req->specifyPurpose;
            }

            // Getting the sender
            $userID = $sender->email;
            $payerID = $sender->ref_code;

            $insertPay = OrganizationPay::insert(['transactionid' => $req->paymentToken, 'coy_id' => $req->accountNumber, 'user_id' => $userID, 'purpose' => $service, 'amount' => $req->amount, 'withdraws' => $req->amount, 'state' => 1, 'payer_id' => $payerID, 'amount_to_send' => $req->amountToSend, 'commission' => $req->commission, 'approve_commission' => $approve_commission]);


            if($insertPay == true){

                try {

                // Send mail to both parties

                // $this->to = "bambo@vimfile.com";
                $this->to = $receiver->email;
                $this->name = $sender->name;
                $this->coy_name = $receiver->name;
                // $this->email = "bambo@vimfile.com";
                $this->email = $sender->email;
                $this->amount = $req->amountToSend;
                $this->paypurpose = $service;

                // Mail to receiver
                $this->sendEmail($this->to, "Payment Received");

                // Mail from Sender

                $this->sendEmail($this->email, "Payment Successful");


                // Insert Statement
                $activity = "Payment to ".$receiver->name." on ".$service;
                $credit = 0;
                $debit = $req->amount + $req->commission;
                $reference_code = $req->paymentToken;
                $balance = 0;
                $trans_date = date('Y-m-d');
                $status = "Pending";
                $action = "Payment";
                $regards = $receiver->ref_code;

                // Senders statement
                $this->insStatement($userID, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1);
                
                // Receiver Statement
                $this->insStatement($receiver->email, $reference_code, "Received money for ".$service." from ".$sender->name, $req->amount, 0, $balance, $trans_date, $status, "Invoice", $receiver->ref_code, 1);

                $data = OrganizationPay::where('transactionid', $req->paymentToken)->first();

                $status = 200;

                $resData = ['data' => $data, 'message' => 'Payment Sent Successfully', 'status' => $status];
                    
                } catch (\Throwable $th) {
                    $status = 400;

                $resData = ['message' => 'Error: '.$th, 'status' => $status];
                }

            }

        }
        else{
            $status = 404;

            $resData = ['message' => 'Receiver not found', 'status' => $status];
        }


        }
        else{
            $status = 400;

            $resData = ['message' => 'Token mismatch', 'status' => $status];
        }


        return $this->returnJSON($resData, $status);
    }


    public function receiveMoney(Request $req){

        // Get User in token
        $user = User::where('api_token', $req->bearerToken())->first();

        if(isset($user)){

            // Get Payment Details
            $payDetails = OrganizationPay::where('id', $req->itemId)->first();

            if(isset($payDetails)){

                ReceivePay::updateOrInsert(['pay_id' => $req->itemId], ['_token' => uniqid(), 'pay_id' => $req->itemId, 'sender_id' => $payDetails->payer_id, 'receiver_id' => $payDetails->coy_id, 'payment_method' => $req->paymentMethod, 'account_number' => $req->bankAccountNumber, 'accountname' => $req->accountName, 'amount_to_receive' => $req->amountToReceive, 'bank_name' => $req->bankName, 'creditcard_no' => $req->exbcCardNumber, 'currency' => $req->currency, 'purpose' => $payDetails->purpose]);

                OrganizationPay::where('id', $req->itemId)->update(['request_receive' => 1]);


                $dataDetails = OrganizationPay::where('id', $req->itemId)->first();


                if($dataDetails->request_receive == 1){
                    $data = "Processing payment";
                    $message = 'Success. It may take up to two (2) business days for money to reflect in your '.$req->paymentMethod;
                }
                elseif($dataDetails->request_receive == 2){
                    $data = "Payment already processed";
                    $message = 'Success. Payment already made, kindly check your financial institution for complaint.';
                }
                else{
                    $data = "Request not yet made";
                    $message = 'Success. You have not made request yet';
                }


                $status = 200;

                $resData = ['data' => $data, 'message' => $message, 'status' => $status];

            }
            else{
                $status = 400;

                $resData = ['message' => 'Payment detail not found', 'status' => $status];
            }

        }
        else{
            $status = 400;

            $resData = ['message' => 'Token mismatch', 'status' => $status];
        }



        return $this->returnJSON($resData, $status);

    }

    public function insStatement($email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, $state){
        Statement::insert(['user_id' => $email, 'reference_code' => $reference_code, 'activity' => $activity, 'credit' => $credit, 'debit' => $debit, 'balance' => $balance, 'trans_date' => $trans_date, 'status' => $status, 'action' => $action, 'regards' => $regards, 'state' => $state]);
    }


    public function sendEmail($objDemoa, $purpose){
        $objDemo = new \stdClass();
        $objDemo->purpose = $purpose;
          if($purpose == "Payment Received"){
  
              $objDemo->name = $this->name;
              $objDemo->email = $this->email;
              $objDemo->amount = $this->amount;
              $objDemo->paypurpose = $this->paypurpose;
              $objDemo->coy_name = $this->coy_name;
  
          }
          elseif($purpose == "Payment Successful"){
  
              $objDemo->name = $this->name;
              $objDemo->email = $this->email;
              $objDemo->amount = $this->amount;
              $objDemo->paypurpose = $this->paypurpose;
              $objDemo->coy_name = $this->coy_name;
  
          }
  
          elseif($purpose == 'Fund remittance'){
              $objDemo->name = $this->name;
              $objDemo->email = $this->email;
              $objDemo->subject = $this->subject;
              $objDemo->message = $this->message;
          }
  
        Mail::to($objDemoa)
              ->send(new sendEmail($objDemo));
     }
}
