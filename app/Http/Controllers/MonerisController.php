<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session;

// Moneris
use CraigPaul\Moneris\Moneris;

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

use App\Classes\mpgGlobals;
use App\Classes\httpsPost;
use App\Classes\mpgHttpsPost;
use App\Classes\mpgHttpsPostStatus;
use App\Classes\mpgResponse;
use App\Classes\mpgRequest;
use App\Classes\mpgCustInfo;
use App\Classes\mpgRecur;
use App\Classes\mpgAvsInfo;
use App\Classes\mpgCvdInfo;
use App\Classes\mpgAchInfo;
use App\Classes\mpgConvFeeInfo;
use App\Classes\mpgTransaction;
use App\Classes\MpiHttpsPost;
use App\Classes\MpiResponse;
use App\Classes\MpiRequest;
use App\Classes\MpiTransaction;
use App\Classes\riskHttpsPost;
use App\Classes\riskResponse;
use App\Classes\riskRequest;
use App\Classes\mpgSessionAccountInfo;
use App\Classes\mpgAttributeAccountInfo;
use App\Classes\riskTransaction;
use App\Classes\mpgAxLevel23;
use App\Classes\axN1Loop;
use App\Classes\axRef;
use App\Classes\axIt1Loop;
use App\Classes\axIt106s;
use App\Classes\axTxi;
use App\Classes\mpgAxRaLevel23;
use App\Classes\mpgVsLevel23;
use App\Classes\vsPurcha;
use App\Classes\vsPurchl;
use App\Classes\vsCorpai;
use App\Classes\vsCorpas;
use App\Classes\vsTripLegInfo;
use App\Classes\mpgMcLevel23;
use App\Classes\mcCorpac;
use App\Classes\mcCorpai;
use App\Classes\mcCorpas;
use App\Classes\mcCorpal;
use App\Classes\mcCorpar;
use App\Classes\mcTax;
use App\Classes\CofInfo;
use App\Classes\MCPRate;


class MonerisController extends Controller
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

	public function __construct(Request $request){

		// $id = 'monca04155';
		// $token = 'KvTMr066FKlJm9rD3i71';

		// optional
		// $params = [
		//   'environment' => Moneris::ENV_TESTING, // default: Moneris::ENV_LIVE
		//   'avs' => true, // default: false
		//   'cvd' => true, // default: false
		//   'cof' => true, // default: false
		// ];

		// (new Moneris($id, $token, $params))->connect();
		// $gateway = Moneris::create($id, $token, $params);

		// dd($gateway);
	}


	public function purchase(Request $req){

		/**************************** Request Variables *******************************/

/************************* Transactional Variables ****************************/

// Test API
// $store_id='monca04155';
// $api_token='KvTMr066FKlJm9rD3i71';

// Live API
$store_id='gwca026583';
$api_token='sssLFi2U8VFO0oWvPWax';

// $type='purchase';
// $cust_id='cust id';
// $order_id='ord-'.date("dmy-Gis");
// $amount='1.00';
// $pan='4242424242424242';
// $expiry_date='2011';
// $crypt='7';
// $dynamic_descriptor='123';
// $status_check = 'false';

if($req->typepayamount != 0){
	$amount = $req->typepayamount;

}
else{
	$amount = $req->amount;
}


$month = $req->month;

$type='purchase';
$cust_id= $req->invoice_no;
$order_id='ord-'.date("dmy-Gis");
$amount= number_format($amount, 2);

$pan= $req->creditcard_no;
$expiry_date= $req->expirydate.$month;
$crypt='7';
$dynamic_descriptor= 'Invoice Payment for PaySprint platform of EXBC';
$status_check = 'false';


/*********************** Transactional Associative Array **********************/
$txnArray=array('type'=>$type,
     		    'order_id'=>$order_id,
     		    'cust_id'=>$cust_id,
    		    'amount'=>$amount,
   			    'pan'=>$pan,
   			    'expdate'=>$expiry_date,
   			    'crypt_type'=>$crypt,
   			    'dynamic_descriptor'=>$dynamic_descriptor
				//,'wallet_indicator' => '' //Refer to documentation for details
				//,'cm_id' => '8nAK8712sGaAkls56' //set only for usage with Offlinx - Unique max 50 alphanumeric characters transaction id generated by merchant
   		       );
/**************************** Transaction Object *****************************/



$mpgTxn = new mpgTransaction($txnArray);


/******************* Credential on File **********************************/
$cof = new CofInfo();
$cof->setPaymentIndicator("U");
$cof->setPaymentInformation("2");
$cof->setIssuerId("168451306048014");
$mpgTxn->setCofInfo($cof);

/****************************** Request Object *******************************/
$mpgRequest = new mpgRequest($mpgTxn);
$mpgRequest->setProcCountryCode("CA"); //"US" for sending transaction to US environment
$mpgRequest->setTestMode(false); //false or comment out this line for production transactions
/***************************** HTTPS Post Object *****************************/
/* Status Check Example
$mpgHttpPost  =new mpgHttpsPostStatus($store_id,$api_token,$status_check,$mpgRequest);
*/
$mpgHttpPost = new mpgHttpsPost($store_id,$api_token,$mpgRequest);
/******************************* Response ************************************/
$mpgResponse=$mpgHttpPost->getMpgResponse();

// dd($mpgResponse);


if($mpgResponse->responseData['Message'] == "APPROVED           *                    ="){

		// Insert Record to DB...
		$insPay = InvoicePayment::updateOrCreate(['invoice_no' => $req->invoice_no],['transactionid' => $mpgResponse->responseData['ReceiptId'], 'name' => $req->name, 'email' => $req->email, 'amount' => $mpgResponse->responseData['TransAmount'], 'invoice_no' => $req->invoice_no, 'service'=> $req->service, 'client_id' => $req->user_id, 'payment_method' => $req->payment_method]);


		if($insPay){
			// Update Import Excel Record
			$getInv = ImportExcel::where('invoice_no', $req->invoice_no)->get();

			if(count($getInv) > 0){
				// Get Amount
				$prevAmount = $getInv[0]->amount;

				$paidAmount = $req->amount;

				$newAmount = $prevAmount - $paidAmount;

                $instcount = $getInv[0]->installcount + 1;

                if($getInv[0]->installlimit > $instcount){
                    $installcounter = $getInv[0]->installlimit;
                }
                else{
                    $installcounter = $instcount;
                }

                ImportExcel::where('invoice_no', $req->invoice_no)->update(['installcount' => $installcounter, 'payment_status' => 1]);

				// Update Price Record
				$updtPrice = InvoicePayment::where('transactionid', $mpgResponse->responseData['ReceiptId'])->update(['remaining_balance' => $newAmount, 'opening_balance' => $prevAmount, 'payment_method' => $req->payment_method]);

				if($updtPrice == 1){

                    $client = ClientInfo::where('user_id', $req->user_id)->get();

                    // Insert PAYCAWithdraw
                    PaycaWithdraw::insert(['withdraw_id' => $mpgResponse->responseData['ReceiptId'], 'client_id' => $req->user_id, 'client_name' => $req->name, 'card_method' => $req->payment_method, 'client_email' => $req->email, 'amount_to_withdraw' => $mpgResponse->responseData['TransAmount'], 'remittance' => 0]);


                    // Insert Statement
                        $activity = "Payment on ".$req->service;
                        $credit = 0;
                        $debit = $req->amount;
                        $balance = $newAmount;
                        $status = "Paid";
                        $action = "Payment";
                        $regards = $req->user_id;
                        $reference_code = $mpgResponse->responseData['ReceiptId'];
                        $trans_date = date('Y-m-d');
                        
                        $this->insStatement($req->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 0);


                        // $this->url = "";
                        // $this->curl_data = array(
                        //     'platform' => 'PaySprint',
                        //     'email' => $req->email,
                        //     'points' => 1100,
                        // );

                        // $resp = $this->doCurl();

                        // if($resp->status == 200){

                        //     $this->name = $req->name;
                        //     $this->to = $req->email;
                        //     $this->coy_name = $client[0]->business_name;
                        //     $this->subject = "Fund sent to ".$this->coy_name;

                        //     $this->message = 'Fund sent to <b>'.$this->coy_name.'</b> has been credited to '.$this->coy_name.' account';

                        //     $this->sendEmail($this->to, "Fund remittance");
                        // }
                        // else{
                        //     $this->name = $req->name;
                        //     $this->to = $req->email;
                        //     $this->coy_name = $client[0]->business_name;
                        //     $this->subject = "Fund sent to ".$this->coy_name;

                        //     $this->message = 'Fund sent to <b>'.$this->coy_name.'</b> has been credited to '.$this->coy_name.' account';

                        //     $this->sendEmail($this->to, "Fund remittance");
                        // }


                        



                    $resData = ['res' => 'Payment Successful', 'message' => 'success', 'title' => 'Good!'];
                    
                    $response = 'Payment Successful';
                    $action = 'success';
				}
				else{
                    $resData = ['res' => 'Something went wrong', 'message' => 'info', 'title' => 'Oops!'];
                    
                    $response = 'Something went wrong';
                    $action = 'error';

				}

			}
			else{
                $resData = ['res' => 'Invoice not found', 'message' => 'error', 'title' => 'Oops!'];
                
                $response = 'Invoice not found';
            $action = 'error';

			}

		}
		else{
            $resData = ['res' => 'Information not documented, contact Admin', 'message' => 'info', 'title' => 'Oops!'];
            
            $response = 'Information not documented, contact Admin';
            $action = 'error';

        }
        
        
}
else{
    $resData = ['res' => $mpgResponse->responseData['Message'], 'message' => 'error', 'title' => 'Oops!'];
    
    $response = $mpgResponse->responseData['Message'];
    $action = 'error';
}

    // return $this->returnJSON($resData);

    return redirect()->route('invoice')->with($action, $response);

}



public function orgPaymentInvoice(Request $req){


		/**************************** Request Variables *******************************/

/************************* Transactional Variables ****************************/

// Test API
// $store_id='monca04155';
// $api_token='KvTMr066FKlJm9rD3i71';

// Live API
$store_id='gwca026583';
$api_token='sssLFi2U8VFO0oWvPWax';

// $type='purchase';
// $cust_id='cust id';
// $order_id='ord-'.date("dmy-Gis");
// $amount='1.00';
// $pan='4242424242424242';
// $expiry_date='2011';
// $crypt='7';
// $dynamic_descriptor='123';
// $status_check = 'false';

$type='purchase';
$cust_id= $req->user_id;
$order_id='ord-'.date("dmy-Gis");


if($req->commission == "on"){
    $amount= number_format($req->amount, 2);
    $approve_commission = "Yes";
}
else{

    $amount= number_format($req->amount+$req->commissiondeduct, 2);
    $approve_commission = "No";

}




$month = $req->month;

$pan= $req->creditcard_no;
$expiry_date= $req->expirydate.$month;
$crypt='7';
$dynamic_descriptor= 'PaySprint Send Money';
$status_check = 'false';


/*********************** Transactional Associative Array **********************/
$txnArray=array('type'=>$type,
     		    'order_id'=>$order_id,
     		    'cust_id'=>$cust_id,
    		    'amount'=>$amount,
   			    'pan'=>$pan,
   			    'expdate'=>$expiry_date,
   			    'crypt_type'=>$crypt,
   			    'dynamic_descriptor'=>$dynamic_descriptor
				//,'wallet_indicator' => '' //Refer to documentation for details
				//,'cm_id' => '8nAK8712sGaAkls56' //set only for usage with Offlinx - Unique max 50 alphanumeric characters transaction id generated by merchant
   		       );

// dd($txnArray);
/**************************** Transaction Object *****************************/
$mpgTxn = new mpgTransaction($txnArray);


/******************* Credential on File **********************************/
$cof = new CofInfo();
$cof->setPaymentIndicator("U");
$cof->setPaymentInformation("2");
$cof->setIssuerId("168451306048014");
$mpgTxn->setCofInfo($cof);

/****************************** Request Object *******************************/
$mpgRequest = new mpgRequest($mpgTxn);
$mpgRequest->setProcCountryCode("CA"); //"US" for sending transaction to US environment
$mpgRequest->setTestMode(false); //false or comment out this line for production transactions
/***************************** HTTPS Post Object *****************************/
/* Status Check Example
$mpgHttpPost  =new mpgHttpsPostStatus($store_id,$api_token,$status_check,$mpgRequest);
*/
$mpgHttpPost = new mpgHttpsPost($store_id,$api_token,$mpgRequest);
/******************************* Response ************************************/
$mpgResponse=$mpgHttpPost->getMpgResponse();

// dd($mpgResponse);



if($mpgResponse->responseData['Message'] == "APPROVED           *                    ="){


    // Get User Info
    $user = User::where('email', $req->orgpayemail)->first();
    

    

    if(isset($user)){
        
        // $client = ClientInfo::where('user_id', $req->user_id)->get();

        $client = User::where('ref_code', $req->user_id)->first();


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

        $insertPay = OrganizationPay::insert(['transactionid' => $mpgResponse->responseData['ReceiptId'], 'coy_id' => $req->user_id, 'user_id' => $userID, 'purpose' => $service, 'amount' => $req->amount, 'withdraws' => $req->amount, 'state' => 1, 'payer_id' => $payerID, 'amount_to_send' => $req->amounttosend, 'commission' => $req->commissiondeduct, 'approve_commission' => $approve_commission]);

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
            $reference_code = $mpgResponse->responseData['ReceiptId'];
            $balance = 0;
            $trans_date = date('Y-m-d');
            $status = "Pending";
            $action = "Payment";
            $regards = $req->user_id;

            // Senders statement
            $this->insStatement($req->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1);
            
            // Receiver Statement
            $this->insStatement($client->email, $reference_code, "Received Payment for ".$service." from ".$user->name, $req->amount, 0, $balance, $trans_date, $status, $action, $client->ref_code, 1);

            // $this->url = "";
            // $this->curl_data = array(
            //     'platform' => 'PaySprint',
            //     'email' => $req->email,
            //     'points' => 1100,
            // );

            // $resp = $this->doCurl();

            // if($resp->status == 200){

            //     $this->name = $req->name;
            //     $this->to = $req->email;
            //     $this->coy_name = $client[0]->business_name;
            //     $this->subject = "Fund sent to ".$this->coy_name;

            //     $this->message = 'Fund sent to <b>'.$this->coy_name.'</b> has been credited to '.$this->coy_name.' account';

            //     $this->sendEmail($this->to, "Fund remittance");
            // }
            // else{
            //     $this->name = $req->name;
            //     $this->to = $req->email;
            //     $this->coy_name = $client[0]->business_name;
            //     $this->subject = "Fund sent to ".$this->coy_name;

            //     $this->message = 'Fund sent to <b>'.$this->coy_name.'</b> has been credited to '.$this->coy_name.' account';

            //     $this->sendEmail($this->to, "Fund remittance");
            // }
            

            

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
        $resData = ['res' => 'Cannot Process Payment', 'message' => 'error', 'title' => 'Oops!'];

        $response = 'Cannot Process Payment';
        $action = 'error';

        return redirect()->back()->with($action, $response);
    }


}
else{
    $resData = ['res' => $mpgResponse->responseData['Message'], 'message' => 'error', 'title' => 'Oops!'];
    
    $response = $mpgResponse->responseData['Message'];
    $action = 'error';

    return redirect()->back()->with($action, $response);

}

    // return $this->returnJSON($resData);


}


public function receivemoneyProcess(Request $req){

    // Insert Record
    $data = ReceivePay::updateOrInsert(['pay_id' => $req->pay_id], $req->all());

    // Update OrganozationPay

    OrganizationPay::where('id', $req->pay_id)->update(['request_receive' => 1]);

    $response = 'Request Sent!';
    $action = 'success';

    return redirect()->route('payorganization')->with($action, $response);

}

	public function returnJSON($data){
        return response()->json($data);
    }


    public function insStatement($email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, $state){
        Statement::insert(['user_id' => $email, 'reference_code' => $reference_code, 'activity' => $activity, 'credit' => $credit, 'debit' => $debit, 'balance' => $balance, 'trans_date' => $trans_date, 'status' => $status, 'action' => $action, 'regards' => $regards, 'state' => $state]);
    }


    // Platform API
    public function doCurl(){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $this->url,
            CURLOPT_USERAGENT => 'PaySprint cURL Request',
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $this->curl_data
        ));

        // Send the request & save response to $resp
        $resp = curl_exec($curl);

        // Close request to clear up some resources
        curl_close($curl);

        // dd($resp);
        // dd($this->url);
        // dd($this->curl_data);
        return json_decode($resp);

        // exit();
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

