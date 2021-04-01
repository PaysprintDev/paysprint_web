<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session;


use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Validator;

use App\User as User;

use App\AnonUsers as AnonUsers;

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

use App\AddCard as AddCard;

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

class GooglePaymentController extends Controller
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


    public function orgPaymentInvoice(Request $req){

        // dd($req->all());

        $validator = Validator::make($req->all(), [
            'payment_method' => 'required',
            'service' => 'required',
            'amount' => 'required',
        ]);

    if($validator->passes()){
            
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

            $statement_route = "wallet";

            if($req->localcurrency != $req->currency){
                $dataInfo = $this->convertCurrencyRate($req->localcurrency, $req->currency, $req->amounttosend);
            }
            else{
                $dataInfo = $req->amounttosend;
            }



            if(env('APP_ENV') == "local"){
                $mode = "test";
            }
            else{
                $mode = "live";
            }

            

        if($req->payment_method == "Wallet"){

            $wallet_balance = Auth::user()->wallet_balance - $req->totalcharge;
            $paymentToken = "wallet-".date('dmY').time();
            $status = "Delivered";
            $action = "Wallet debit";
            $requestReceive = 2;

            
        }
        else{

            if($req->localcurrency != $req->currency){

            $monerisDeductamount = $this->currencyConvert($req->localcurrency, $req->totalcharge);

            }   
            else{

                $monerisDeductamount = $req->totalcharge;

            }



            $response = $this->monerisWalletProcess(Auth::user()->api_token, $req->card_id, $monerisDeductamount, "purchase", "PaySprint Send Money to the Wallet of ".$client->name, $mode);

            if($response->responseData['Message'] == "APPROVED           *                    ="){

                $reference_code = $response->responseData['ReceiptId'];

                $wallet_balance = Auth::user()->wallet_balance;
                $paymentToken = $reference_code;
                $status = "Delivered";
                $action = "Payment";
                $requestReceive = 0;

            }
            else{

                $message = $response->responseData['Message'];

                $resData = ['res' => $message, 'message' => 'info', 'title' => 'Oops!'];

                $response = $message;
                $respaction = 'error';

                return redirect()->back()->with($respaction, $response);
            }

            
        }

        $insertPay = OrganizationPay::insert(['transactionid' => $paymentToken, 'coy_id' => $req->user_id, 'user_id' => $userID, 'purpose' => $service, 'amount' => $req->currency.' '.$req->amount, 'withdraws' => $req->currency.' '.$req->amount, 'state' => 1, 'payer_id' => $payerID, 'amount_to_send' => $dataInfo, 'commission' => $req->commissiondeduct, 'approve_commission' => $approve_commission, 'amountindollars' => $req->localcurrency.' '.$req->conversionamount, 'request_receive' => $requestReceive]);

        if($insertPay == true){


            // Update Wallet
            User::where('email', Auth::user()->email)->update(['wallet_balance' => $wallet_balance]);
            // Send mail to both parties

            // $this->to = "bambo@vimfile.com";
            $this->to = $client->email;
            $this->name = $user->name;
            $this->coy_name = $client->name;
            // $this->email = "bambo@vimfile.com";
            $this->email = $user->email;
            $this->amount = $req->currency.' '.$dataInfo;
            $this->paypurpose = $service;

            // Mail to receiver
            $this->sendEmail($this->to, "Payment Received");

            // Mail from Sender

            $this->sendEmail($this->email, "Payment Successful");


            // Insert Statement
            $activity = $req->payment_method." transfer of ".$req->currency.''.$req->amount." to ".$client->name." for ".$service;
            $credit = 0;
            $debit = $req->conversionamount + $req->commissiondeduct;
            $reference_code = $paymentToken;
            $balance = 0;
            $trans_date = date('Y-m-d');
            
            $regards = $req->user_id;


            

            $recWallet = $client->wallet_balance + $dataInfo;



            User::where('ref_code', $req->user_id)->update(['wallet_balance' => $recWallet]);

            // Senders statement
            $this->insStatement($userID, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route);
            
            // Receiver Statement
            $this->insStatement($client->email, $reference_code, "Received ".$req->currency.''.$dataInfo." in wallet for ".$service." from ".$user->name, $req->conversionamount, 0, $balance, $trans_date, $status, "Wallet credit", $client->ref_code, 1, $statement_route);

            

            $resData = ['res' => 'Money sent successfully', 'message' => 'success', 'title' => 'Good!'];

            $response = 'Money sent successfully';
            $respaction = 'success';


            return redirect()->route('payorganization')->with($respaction, $response);

        }
        else{
            $resData = ['res' => 'Something went wrong', 'message' => 'info', 'title' => 'Oops!'];

            $response = 'Something went wrong';
            $respaction = 'error';

            return redirect()->back()->with($respaction, $response);
        }
    }
    
    else{
        $resData = ['res' => 'Cannot find your account record, to confirm payment.', 'message' => 'error', 'title' => 'Oops!'];

        $response = 'Cannot find your account record, to confirm payment.';
        $respaction = 'error';

        return redirect()->back()->with($respaction, $response);
    }

        }
        else{

            $error = implode(",",$validator->messages()->all());

            $resData = ['res' => $error, 'message' => 'error', 'title' => 'Oops!'];

        $response = $error;
        $respaction = 'error';

        return redirect()->back()->with($respaction, $response);
        }




    }


    // Send Money to Anonymous
    public function sendMoneyToAnonymous(Request $req){
        // dd($req->all());

        $validator = Validator::make($req->all(), [
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required',
            'countryCode' => 'required',
            'phone' => 'required',
            'country' => 'required',
            'payment_method' => 'required',
            'service' => 'required',
            'amount' => 'required',
        ]);


            if($validator->passes()){
            
                // Get User Info
                $thisuser = User::where('api_token', $req->bearerToken())->first();

                if(isset($thisuser)){

                    $ref_code = mt_rand(00000, 99999);

                    // Get all ref_codes
                    $ref = User::all();

                    if(count($ref) > 0){
                        foreach($ref as $key => $value){
                            if($value->ref_code == $ref_code){
                                $newRefcode = mt_rand(000000, 999999);
                            }
                            else{
                                $newRefcode = $ref_code;
                            }
                        }
                    }
                    else{
                        $newRefcode = $ref_code;
                    }
                    
                    $newcustomer = AnonUsers::where('email', $req->email)->first();

                    
                    $approve_commission = "No";

                        $foreigncurrency = $this->getCountryCode($req->country);


                    if($thisuser->country != $req->country){

                        // Get Country Currency code

                        
                        // COnvert Currency for Wallet credit to receiver
                        $amount = $this->convertCurrencyRate($foreigncurrency[0]->currencies[0]->code, $req->currency, $req->amount);


                    }
                    else{
                        $amount = $req->amount;
                    }


                    // Getting the payer
                    $userID = $thisuser->email;
                    $payerID = $thisuser->ref_code;

                    // $req->user_id is for the receiver::

                    // Do Insert
                    if($req->service != "Others"){
                        $service = $req->service;
                    }
                    else{
                        $service = $req->purpose;
                    }

                        $statement_route = "wallet";


                        $wallet_balance = $thisuser->wallet_balance - $req->amount;
                        $paymentToken = "wallet-".date('dmY').time();
                        $status = "Delivered";
                        $action = "Wallet debit";
                        $requestReceive = 2;


                    $insertPay = OrganizationPay::insert(['transactionid' => $paymentToken, 'coy_id' => $newRefcode, 'user_id' => $userID, 'purpose' => $service, 'amount' => $req->currency.' '.$req->amount, 'withdraws' => $req->currency.' '.$req->amount, 'state' => 1, 'payer_id' => $payerID, 'amount_to_send' => $amount, 'commission' => $req->commissiondeduct, 'approve_commission' => $approve_commission, 'amountindollars' => $foreigncurrency[0]->currencies[0]->code.' '.$amount, 'request_receive' => $requestReceive]);

                    if($insertPay == true){


                        // Update Wallet
                        User::where('api_token', $req->bearerToken())->update(['wallet_balance' => $wallet_balance]);


                        // Create or update Other party account
                        if(isset($newcustomer)){
                            // Update account
                            $newwalletBal = $newcustomer->wallet_balance + $amount;
                            AnonUsers::where('email', $newcustomer->email)->update(['wallet_balance' => $newwalletBal]);
                        }
                        else{
                            // Create account
                            $newwalletBal = $amount;
                            AnonUsers::insert(['code' => $req->countryCode, 'ref_code' => $newRefcode, 'name' => $req->fname.' '.$req->lname, 'email' => $req->email, 'telephone' => $req->phone, 'country' => $req->country, 'wallet_balance' => $newwalletBal]);
                        }


                        // Send mail to both parties

                        // Notification to Sender
                        $this->name = $thisuser->name;
                        // $this->email = "bambo@vimfile.com";
                        $this->email = $thisuser->email;
                        $this->subject = "Transaction Notification";

                        $this->message = '<p>You just sent <strong>'.$req->currency.' '.number_format($req->amount, 2).'</strong> to '.$req->fname.' '.$req->lname.'. You now have <strong>'.$req->currency.' '.number_format($wallet_balance, 2).'</strong> in your account</p>';

                        $this->sendEmail($this->email, "Fund remittance");

                        // Notification for receiver
                        $this->name = $req->fname.' '.$req->lname;
                        // $this->to = "bambo@vimfile.com";
                        $this->to = $req->email;
                        $this->subject = "Transaction Notification from ".$thisuser->name;

                        $this->message = '<p>You just received <strong>'.$foreigncurrency[0]->currencies[0]->code.' '.number_format($amount, 2).'</strong> from '.$thisuser->name.'. You now have <strong>'.$foreigncurrency[0]->currencies[0]->code.' '.number_format($newwalletBal, 2).'</strong> in your account</p><hr><p>Click on the link below to register your account to withdraw money</p><p><a href="'.route('register', 'user='.$newRefcode).'">'.route('register', 'user='.$newRefcode).'</a></p>';

                        $this->sendEmail($this->to, "Fund remittance");


                        // Insert Statement
                        $activity = $req->payment_method." transfer of ".$req->currency.''.$req->amount." to ".$req->fname.' '.$req->lname." for ".$service;
                        $credit = 0;
                        $debit = $req->conversionamount + $req->commissiondeduct;
                        $reference_code = $paymentToken;
                        $balance = 0;
                        $trans_date = date('Y-m-d');
                        
                        $regards = $newRefcode;

                        // Senders statement
                        $this->insStatement($userID, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route);
                        
                        // Receiver Statement
                        $this->insStatement($req->email, $reference_code, "Received ".$foreigncurrency[0]->currencies[0]->code.''.$amount." in wallet for ".$service." from ".$thisuser->name, $amount, 0, $balance, $trans_date, $status, "Wallet credit", $newRefcode, 1, $statement_route);

                        

                        $response = 'Money sent successfully';

                        $data = $insertPay;
                        $status = 200;
                        $message = $response;

                    }
                    else{

                        $response = 'Something went wrong';
                        $data = [];
                        $message = $response;
                        $status = 400;
                    }
                }
                
                else{
                    $response = 'Cannot find your account record, to continue payment.';

                    $data = [];
                    $message = $response;
                    $status = 400;
                }

        }
        else{

            $error = implode(",",$validator->messages()->all());

            $data = [];
            $status = 400;
            $message = $error;
        }



        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

        return $this->returnJSON($resData, $status);
        
    }


    public function convertCurrencyRate($foreigncurrency, $localcurrency, $amount){

        $currency = 'USD'.$foreigncurrency;
        $amount = $amount;
        $localCurrency = 'USD'.$localcurrency;

        $access_key = '89e3a2b081fb2b9d188d22516553545c';

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://api.currencylayer.com/live?access_key='.$access_key,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Cookie: __cfduid=d430682460804be329186d07b6e90ef2f1616160177'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $result = json_decode($response);


        if($result->success == true){
        
            // Conversion Rate USD to Local currency
            $convertLocal = $amount / $result->quotes->$localCurrency;


            $convRate = $result->quotes->$currency * $convertLocal;

        }
        else{
            $convRate = "Sorry we can not process your transaction this time, try again later!.";
        }

        

        return $convRate;

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
              $objDemo->to = $this->to;
              $objDemo->subject = $this->subject;
              $objDemo->message = $this->message;
          }
  
        Mail::to($objDemoa)
              ->send(new sendEmail($objDemo));
    }


    public function monerisWalletProcess($bearer, $card_id, $dollaramount, $type, $description, $mode){


        if($mode == "test"){
            if($type == "purchase"){
                // Test API
                $store_id='monca04155';
                $api_token='KvTMr066FKlJm9rD3i71';
            }
            else{
                // Test API
                $store_id='store5';
                $api_token='yesguy';
            }

            $setMode = true;
        }
        else{
            // Live API
            $store_id='gwca026583';
            $api_token='sssLFi2U8VFO0oWvPWax';

            $setMode = false;
        }

        


        


        $thisuser = User::where('api_token', $bearer)->first();

        // Get Card Details
        $cardDetails = AddCard::where('id', $card_id)->where('user_id', $thisuser->id)->first();


        $type=$type;
        $cust_id= $thisuser->ref_code;
        $order_id='ord-'.date("dmy-Gis");
        // $amount= number_format($dollaramount, 2);
        $amount= $dollaramount;

        

        $month = $cardDetails->month;

        $pan= $cardDetails->card_number;
        $expiry_date= $cardDetails->year.$month;
        $crypt='7';
        $dynamic_descriptor= $description;
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
        $mpgRequest->setTestMode($setMode); //false or comment out this line for production transactions
        /***************************** HTTPS Post Object *****************************/
        /* Status Check Example
        $mpgHttpPost  =new mpgHttpsPostStatus($store_id,$api_token,$status_check,$mpgRequest);
        */
        $mpgHttpPost = new mpgHttpsPost($store_id,$api_token,$mpgRequest);
        /******************************* Response ************************************/
        $mpgResponse=$mpgHttpPost->getMpgResponse();

        return $mpgResponse;
    }



}
