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

use App\CardRequest as CardRequest;

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
    public $subject2;
    public $paypurpose;
    public $service;
    public $city;
    public $state;
    public $zipcode;
    public $coy_name;
    public $url = "https://exbc.ca/api/v1/points/earnpoint";
    // public $url = "http://localhost:4000/api/v1/points/earnpoint";
    public $curl_data;





    public function getTransactionStructure(){
        $resp = TransactionCost::select('id','structure', 'method', 'country')->get();

        $data = $resp;
        $status = 200;

        $resData = ['data' => $data,'message' => 'success', 'status' => $status];

        return $this->returnJSON($resData, $status);
    }

    public function commissionFee(Request $req){
        $thisuser = User::where('api_token', $req->bearerToken())->first();

            $amount = $req->amount;
            // Get Commission

            $data = TransactionCost::where('structure', $req->structure)->where('method', $req->method)->where('country', $thisuser->country)->first();

            if(isset($data) == true){
                $x = ($data->variable / 100) * $req->amount;

                $y = $data->fixed + $x;

                $collection = $y;
            }
            else{

                $data = TransactionCost::where('structure', $req->structure)->where('method', $req->method)->first();

                $x = ($data->variable / 100) * $req->amount;

                $y = $data->fixed + $x;

                $collection = $y;

            }

            


            // $fixed = $amount * ($data->fixed / 100);

            // $variable = $data->fixed * 1;

            // $collection = $fixed + $variable;

            $status = 200;

            $resData = ['data' => $collection,'message' => 'success', 'status' => $status];



        return $this->returnJSON($resData, $status);
    }


    public function requestPrepaidCard(Request $req){

        $thisuser = User::where('api_token', $req->bearerToken())->first();

        if(env('APP_ENV') == "local"){
            $url = "http://localhost:4000/api/v1/paysprint/requestcard";
        }
        else{
            $url = "https://exbc.ca/api/v1/paysprint/requestcard";
        }

        $data = $req->all();

        $token = "base64:HgMO6FDHGziGl01OuLH9mh7CeP095shB6uuDUUClhks=";


        $response = $this->curlPost($url, $data, $token);

        if($response->status == 200){
           $resData = $this->debitWalletForCard($req->ref_code, $req->card_provider);
           $status = $resData['status'];
           $data = $resData['data'];
           $message = $response->message;
           $resData = ['data' => $data,'message' => $message, 'status' => $status];
        }
        else{
            $status = $response->status;
            $data = $response->data;
            $message = $response->message;
            $resData = ['data' => $data,'message' => $message, 'status' => $status];
        }

        $this->createNotification($thisuser->ref_code, "Hello ".strtoupper($thisuser->name).", ".$message);

        return $this->returnJSON($resData, $status);


    }


    public function debitWalletForCard($ref_code, $card_provider){


            $myWallet = User::where('ref_code', $ref_code)->first();

            // Deduct $20 for EXBC Card
            $wallet_balance = $myWallet->wallet_balance - 20;

            // Update walllet balance
            User::where('ref_code', $ref_code)->update(['wallet_balance' => $wallet_balance]);

            CardRequest::insert(['ref_code' => $ref_code, 'card_provider' => $card_provider, 'status' => 0]);

            $data = User::where('ref_code', $ref_code)->first();

            $status = 200;

            $resData = ['data' => $data,'message' => 'success', 'status' => $status];

            // Send SMS
            $sendMsg = "Hi ".$data->name.", ".$data->currencyCode." 20.00 was deducted from your PaySprint wallet for ".$card_provider." request. Your new wallet balance is ".$data->currencyCode.' '.number_format($wallet_balance, 2).". If you did not make this transfer, kindly login to your PaySprint Account to change your Transaction PIN and report the issue to PaySprint Admin using Contact Us.";

            $sendPhone = "+".$data->code.$data->telephone;

            $this->sendMessage($sendMsg, $sendPhone);

            $this->createNotification($ref_code, $sendMsg);

            // Wallet Statement

            // Insert Statement
            $activity = "Debited ".$data->currencyCode." ".number_format(20, 2)." for ".$card_provider." request from PaySprint Wallet.";
            $credit = 0;
            $debit = 20;
            $reference_code = "wallet-".date('dmY').time();
            $balance = 0;
            $trans_date = date('Y-m-d');
            $status = "Delivered";
            $action = "Wallet debit";
            $regards = $ref_code;

            $statement_route = "wallet";

            // Senders statement
            $this->insStatement($data->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route);


        return $resData;
    }

    public function getReceiver(Request $req){

        $accountno = $req->get('accountNumber');

        $user = User::where('api_token', $req->bearerToken())->first();

        if(isset($user)){


            if($user->approval == 0){

                $status = 400;
    
                $resData = ['data' => [], 'message' => 'You cannot send or receive money now, because your account is not yet approved. Kindly update means of identification in your profile', 'status' => $status];
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
    
                        $resData = ['data' => [], 'message' => 'No record found', 'status' => $status];
                    }
    
                }
                else{
                    $status = 400;
    
                    $resData = ['data' => [], 'message' => 'You cannot send money to yourself', 'status' => $status];
                }
            }


        }
        else{
            $status = 400;

            $resData = ['data' => [], 'message' => 'Token mismatch', 'status' => $status];
        }

        return $this->returnJSON($resData, $status);

    }

    public function getSender(Request $req){
        $accountno = $req->get('accountNumber');

        $user = User::where('api_token', $req->bearerToken())->first();

        if(isset($user)){

            if($user->approval == 0){

                $status = 400;
    
                $resData = ['data' => [], 'message' => 'You cannot send or receive money now, because your account is not yet approved. Kindly update means of identification in your profile', 'status' => $status];
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
    
                        $resData = ['data' => [], 'message' => 'No record found', 'status' => $status];
                    }
    
                }
                else{
                    $status = 400;
    
                    $resData = ['data' => [], 'message' => 'You can not receive money from yourself', 'status' => $status];
                }
            }


        }
        else{
            $status = 400;

            $resData = ['data' => [], 'message' => 'Token mismatch', 'status' => $status];
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

            if($req->amount > $sender->wallet_balance){
                
                $status = 404;

                $resData = ['data' => [], 'message' => 'Insufficient wallet balance', 'status' => $status];
            }
            else{
                            $amount= number_format($req->amount, 2);

                $approve_commission = "Yes";


                if($req->purposeOfPayment != "Others"){
                    $service = $req->purposeOfPayment;
                }
                else{
                    $service = $req->specifyPurpose;
                }


                

                // Getting the sender
                $userID = $sender->email;
                $payerID = $sender->ref_code;

                $paymentToken = "wallet-".date('dmY').time();

                $wallet_balance = $sender->wallet_balance - $req->amount;

                $insertPay = OrganizationPay::insert(['transactionid' => $paymentToken, 'coy_id' => $req->accountNumber, 'user_id' => $userID, 'purpose' => $service, 'amount' => $req->amount, 'withdraws' => $req->amount, 'state' => 1, 'payer_id' => $payerID, 'amount_to_send' => $req->amount, 'commission' => 0, 'approve_commission' => $approve_commission, 'request_receive' => 0]);


                if($insertPay == true){

                    try {

                    // Update Wallet
                    User::where('api_token', $req->bearerToken())->update(['wallet_balance' => $wallet_balance]);

                    // Send mail to both parties

                    // $this->to = "bambo@vimfile.com";
                    $this->to = $receiver->email;
                    $this->name = $sender->name;
                    $this->coy_name = $receiver->name;
                    // $this->email = "bambo@vimfile.com";
                    $this->email = $sender->email;
                    $this->amount = $req->currency." ".$req->amount;
                    $this->paypurpose = $service;
                    $this->subject = "Payment Received from ".$sender->name." for ".$service;
                    $this->subject2 = "Your Payment to ".$receiver->name." was successfull";

                    // Mail to receiver
                    $this->sendEmail($this->to, "Payment Received");

                    // Mail from Sender

                    $this->sendEmail($this->email, "Payment Successful");


                    // Insert Statement
                    $activity = "Transfer of ".$req->currency." ".number_format($req->amount, 2)." to ".$receiver->name." for ".$service." on PaySprint Wallet.";
                    $credit = 0;
                    $debit = number_format($req->amount, 2);
                    $reference_code = $paymentToken;
                    $balance = 0;
                    $trans_date = date('Y-m-d');
                    $status = "Delivered";
                    $action = "Wallet debit";
                    $regards = $receiver->ref_code;


                    $statement_route = "wallet";

                    $recWallet = $receiver->wallet_balance + $req->amount;

                    User::where('ref_code', $req->accountNumber)->update(['wallet_balance' => $recWallet]);


                    $sendMsg = "Hi ".$sender->name.", You have made a ".$activity." Your new Wallet balance ".$req->currency.' '.number_format($wallet_balance, 2)." balance  in your account. If you did not make this transfer, kindly login to your PaySprint Account to change your Transaction PIN and report the issue to PaySprint Admin using Contact Us. PaySprint Team";
                    $sendPhone = "+".$sender->code.$sender->telephone;

                    $this->sendMessage($sendMsg, $sendPhone);


                    $recMsg = "Hi ".$receiver->name.", You have received ".$req->currency.' '.number_format($req->amount, 2)." in your PaySprint wallet for ".$service." from ".$sender->name.". You now have ".$req->currency.' '.number_format($recWallet, 2)." balance in your wallet. PaySprint Team";
                    $recPhone = "+".$receiver->code.$receiver->telephone;

                    $this->sendMessage($recMsg, $recPhone);

                    // Senders statement
                    $this->insStatement($userID, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route);
                    
                    // Receiver Statement
                    $this->insStatement($receiver->email, $reference_code, "Received ".$req->currency.' '.number_format($req->amount, 2)." in wallet for ".$service." from ".$sender->name, number_format($req->amount, 2), 0, $balance, $trans_date, $status, "Invoice", $receiver->ref_code, 1, $statement_route);

                    $data = OrganizationPay::where('transactionid', $paymentToken)->first();

                    $status = 200;

                    $resData = ['data' => $data, 'message' => 'Money Sent Successfully', 'status' => $status];

                    $this->createNotification($receiver->ref_code, $recMsg);

                    $this->createNotification($sender->ref_code, $sendMsg);
                        
                    } catch (\Throwable $th) {
                        $status = 400;

                    $resData = ['data' => [], 'message' => 'Error: '.$th, 'status' => $status];
                    }

                }
            }



        }
        else{
            $status = 404;

            $resData = ['data' => [], 'message' => 'Receiver not found', 'status' => $status];
        }


        }
        else{
            $status = 400;

            $resData = ['data' => [], 'message' => 'Token mismatch', 'status' => $status];
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

                $resData = ['data' => [], 'message' => 'Payment detail not found', 'status' => $status];
            }

        }
        else{
            $status = 400;

            $resData = ['data' => [], 'message' => 'Token mismatch', 'status' => $status];
        }



        return $this->returnJSON($resData, $status);

    }

    public function insStatement($email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, $state, $statement_route){
        Statement::insert(['user_id' => $email, 'reference_code' => $reference_code, 'activity' => $activity, 'credit' => $credit, 'debit' => $debit, 'balance' => $balance, 'trans_date' => $trans_date, 'status' => $status, 'action' => $action, 'regards' => $regards, 'state' => $state, 'statement_route' => $statement_route]);
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
              $objDemo->subject = $this->subject;
  
          }
          elseif($purpose == "Payment Successful"){
  
              $objDemo->name = $this->name;
              $objDemo->email = $this->email;
              $objDemo->amount = $this->amount;
              $objDemo->paypurpose = $this->paypurpose;
              $objDemo->coy_name = $this->coy_name;
              $objDemo->subject = $this->subject2;
  
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
