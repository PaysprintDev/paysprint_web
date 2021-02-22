<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session;


use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Mail;

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

class GooglePaymentController extends Controller
{
    public function orgPaymentInvoice(Request $req){

    // Get User Info
    $user = User::where('email', $req->orgpayemail)->first();

    
    

    

    if(isset($user)){
        
        // $client = ClientInfo::where('user_id', $req->user_id)->get();

        $client = User::where('ref_code', $req->user_id)->first();

        if($req->commission == "on"){
            $amount= number_format($req->amount, 2);
            $approve_commission = "Yes";
        }
        else{
        
            $amount= number_format($req->amount+$req->commissiondeduct, 2);
            $approve_commission = "No";
        
        }


        // Getting the payer
        $userID = $user->email;
        $payerID = $user->ref_code;

        // $req->user_id is for the receiver::

        // Do Insert
        if($req->service != "Others"){
            $service = $req->service;
        }
        else{
            $service = $req->purpose;
        }

        $insertPay = OrganizationPay::insert(['transactionid' => $req->paymentToken, 'coy_id' => $req->user_id, 'user_id' => $userID, 'purpose' => $service, 'amount' => $req->amount, 'withdraws' => $req->amount, 'state' => 1, 'payer_id' => $payerID, 'amount_to_send' => $req->amounttosend, 'commission' => $req->commissiondeduct, 'approve_commission' => $approve_commission]);

        if($insertPay == true){
            // Send mail to both parties

            // $this->to = "bambo@vimfile.com";
            $this->to = $client->email;
            $this->name = $user->name;
            $this->coy_name = $client->name;
            // $this->email = "bambo@vimfile.com";
            $this->email = $user->email;
            $this->amount = $req->amounttosend;
            $this->paypurpose = $service;

            // Mail to receiver
            $this->sendEmail($this->to, "Payment Received");

            // Mail from Sender

            $this->sendEmail($this->email, "Payment Successful");


            // Insert Statement
            $activity = "Payment to ".$client->name." on ".$service;
            $credit = 0;
            $debit = $req->amount + $req->commissiondeduct;
            $reference_code = $req->paymentToken;
            $balance = 0;
            $trans_date = date('Y-m-d');
            $status = "Pending";
            $action = "Payment";
            $regards = $req->user_id;

            // Senders statement
            $this->insStatement($userID, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1);
            
            // Receiver Statement
            $this->insStatement($client->email, $reference_code, "Received money for ".$service." from ".$user->name, $req->amount, 0, $balance, $trans_date, $status, "Invoice", $client->ref_code, 1);

            

            $resData = ['res' => 'Payment Sent Successfully', 'message' => 'success', 'title' => 'Good!'];

            $response = 'Payment Sent Successfully';
            $action = 'success';

            return redirect()->route('payorganization')->with($action, $response);

        }
        else{
            $resData = ['res' => 'Something went wrong', 'message' => 'info', 'title' => 'Oops!'];

            $response = 'Something went wrong';
            $action = 'error';

            return redirect()->back()->with($action, $response);
        }
    }
    
    else{
        $resData = ['res' => 'Cannot find your account record, to confirm payment.', 'message' => 'error', 'title' => 'Oops!'];

        $response = 'Cannot find your account record, to confirm payment.';
        $action = 'error';

        return redirect()->back()->with($action, $response);
    }


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
