<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

// Moneris
use CraigPaul\Moneris\Moneris;

use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Mail;

use App\User as User;
use App\AnonUsers as AnonUsers;
use App\ServiceType as ServiceType;
use App\Admin as Admin;
use App\ClientInfo as ClientInfo;
use App\OrganizationPay as OrganizationPay;
use App\Statement as Statement;


use App\Mail\sendEmail;

use App\Traits\Trulioo;
use App\Traits\PaymentGateway;

use App\Traits\Xwireless;


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

class MerchantApiController extends Controller
{
    use Trulioo, PaymentGateway, Xwireless;

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

    //Receive Money from Other PaySprint Customer
    public function receiveMoneyFromPaysprintCustomer(Request $req){

        $validator = Validator::make($req->all(), [
            'accountNumber' => 'required',
            'amount' => 'required',
            'purpose' => 'required',
            'mode' => 'required',
        ]);

        if($validator->passes()){

            $mode = strtoupper($req->mode);

            if($mode == strtoupper("live")){

                $merchantInfo = ClientInfo::where('api_secrete_key', $req->bearerToken())->first();

                if(isset($merchantInfo) == true){
                    $thisuser = User::where('ref_code', $req->accountNumber)->first();

                    $thismerchant = User::where('ref_code', $merchantInfo->user_id)->first();

                    if(isset($thisuser) == true){

                        if($thisuser->country == $thismerchant->country){
                            $amount = $req->amount;
                            $myCurrency = $thisuser->currencyCode;
                        }
                        else{
                            // Currency converter
                            $amount = $this->convertCurrency($thismerchant->currencyCode, $req->amount, $thisuser->currencyCode);
                            $myCurrency = $thismerchant->currencyCode;
                        }

                            if($thisuser->wallet_balance < $amount){
                                    
                                $error = "Insufficient balance!. Your current wallet balance is ".$thisuser->currencyCode." ".number_format($thisuser->wallet_balance, 2);
                
                                $status = 400;
                                $resData = ['data' => [], 'message' => $error, 'status' => $status];
                            }
                            else{
                                // Continue with payment
                                $paymentToken = "wallet-".date('dmY').time();

                                $wallet_balance = $thisuser->wallet_balance - $req->amount;

                                $approve_commission = "Yes";

                                // Getting the sender
                                $userID = $thisuser->email;
                                $payerID = $thisuser->ref_code;

                                $insertPay = OrganizationPay::insert(['transactionid' => $paymentToken, 'coy_id' => $thismerchant->ref_code, 'user_id' => $userID, 'purpose' => $req->purpose, 'amount' => $thisuser->currencyCode." ".$req->amount, 'withdraws' => $thisuser->currencyCode." ".$req->amount, 'state' => 1, 'payer_id' => $payerID, 'amount_to_send' => $req->amount, 'commission' => 0, 'approve_commission' => $approve_commission, 'request_receive' => 0, 'amountindollars' => $myCurrency." ".$amount]);

                                if($insertPay == true){

                                    try {

                                    // Update Wallet
                                    User::where('ref_code', $thisuser->ref_code)->update(['wallet_balance' => $wallet_balance]);

                                    $service = $req->purpose;

                                    


                                    // Insert Statement
                                    $activity = "Transfer of ".$thisuser->currencyCode." ".number_format($req->amount, 2)." to ".$thismerchant->businessname." for ".$service." on PaySprint Wallet.";
                                    $credit = 0;
                                    $debit = number_format($req->amount, 2);
                                    $reference_code = $paymentToken;
                                    $balance = 0;
                                    $trans_date = date('Y-m-d');
                                    $wallet_status = "Delivered";
                                    $action = "Wallet debit";
                                    $regards = $thismerchant->ref_code;


                                    $statement_route = "wallet";


                                    if($thismerchant->auto_deposit == 'on'){
                                        $recWallet = $thismerchant->wallet_balance + $amount;
                                        $walletstatus = "Delivered";
                                        
                                        $recMsg = "Hi ".$thismerchant->businessname.", You have received ".$myCurrency.' '.number_format($amount, 2)." in your PaySprint wallet for ".$service." from ".$thisuser->name.". You now have ".$myCurrency.' '.number_format($recWallet, 2)." balance in your wallet. PaySprint Team";

                                    }
                                    else{
                                        $recWallet = $thismerchant->wallet_balance;
                                        $walletstatus = "Pending";

                                        $recMsg = "Hi ".$thismerchant->businessname.", You have received ".$myCurrency.' '.number_format($amount, 2)." for ".$service." from ".$thisuser->name.". Your wallet balance is ".$myCurrency.' '.number_format($recWallet, 2).". Kindly login to your wallet account to receive money. PaySprint Team ".route('my account');

                                    }

                                    User::where('ref_code', $thismerchant->ref_code)->update(['wallet_balance' => $recWallet]);

                                    // thisusers statement
                                    $this->insStatement($userID, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $wallet_status, $action, $regards, 1, $statement_route, 'on');
                                    
                                    // thismerchant Statement
                                    $this->insStatement($thismerchant->email, $reference_code, "Received ".$myCurrency.' '.number_format($amount, 2)." in wallet for ".$service." from ".$thisuser->name, number_format($amount, 2), 0, $balance, $trans_date, $walletstatus, "Wallet credit", $thismerchant->ref_code, 1, $statement_route, $thismerchant->auto_deposit);

                                    // Send mail to both parties

                                    // $this->to = "bambo@vimfile.com";
                                    $this->to = $thismerchant->email;
                                    $this->name = $thisuser->name;
                                    $this->coy_name = $thismerchant->businessname;
                                    // $this->email = "bambo@vimfile.com";
                                    $this->email = $thisuser->email;
                                    $this->amount = $myCurrency." ".number_format($amount, 2);
                                    $this->paypurpose = $service;
                                    $this->subject = "Payment Received from ".$thisuser->name." for ".$service;
                                    $this->subject2 = "Your Payment to ".$thismerchant->businessname." was successfull";

                                    // Mail to thismerchant
                                    $this->sendEmail($this->to, "Payment Received");

                                    // Mail from thisuser

                                    $this->sendEmail($this->email, "Payment Successful");

                                    

                                    $sendMsg = "Hi ".$thisuser->name.", You have made a ".$activity." Your new Wallet balance is ".$thisuser->currencyCode.' '.number_format($wallet_balance, 2).". If you did not make this transfer, kindly login to your PaySprint Account to change your Transaction PIN and report the issue to PaySprint Admin using Contact Us. PaySprint Team";

                                    $getPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();
                                                    
                                    if(isset($getPhone)){

                                        $sendPhone = $thisuser->telephone;
                                    }
                                    else{
                                        $sendPhone = "+".$thisuser->code.$thisuser->telephone;
                                    }

                                    $this->sendMessage($sendMsg, $sendPhone);

                                    $merchantgetPhone = User::where('email', $thismerchant->email)->where('telephone', 'LIKE', '%+%')->first();
                                                    
                                    if(isset($merchantgetPhone)){

                                        $recPhone = $thismerchant->telephone;
                                    }
                                    else{
                                        $recPhone = "+".$thismerchant->code.$thismerchant->telephone;
                                    }
                                    

                                    $this->sendMessage($recMsg, $recPhone);

                                    

                                    $data = User::select('name', 'businessname as businessName', 'telephone', 'state', 'country', 'avatar')->where('ref_code', $thisuser->ref_code)->first();

                                    $data['paymentToken'] = $paymentToken;
                                    $data['amount'] = $req->amount;
                                    $data['currency'] = $thisuser->currencyCode;

                                    $status = 200;

                                    $resData = ['data' => $data, 'message' => 'Money Sent Successfully', 'status' => $status];


                                    Log::info("Sent money from ".$thisuser->name." to ".$thismerchant->businessname." using 3rd party gateway LIVE MODE");

                                    $this->createNotification($thismerchant->ref_code, $recMsg);

                                    $this->createNotification($thisuser->ref_code, $sendMsg);
                                        
                                    } catch (\Exception $th) {
                                        $status = 400;

                                        $resData = ['data' => [], 'message' => 'Error: '.$th, 'status' => $status];
                                    }

                                }
                                

                            }

                    }
                    else{

                        $error = "Incorrect account number";
                
                        $status = 400;
                        $resData = ['data' => [], 'message' => $error, 'status' => $status];
                    }
                    
                }
                else{
                    $error = "Invalid Authorization Key";
                
                    $status = 400;
                    $resData = ['data' => [], 'message' => $error, 'status' => $status];
                }
            }
            elseif($mode == strtoupper("test")){

                $merchantInfo = ClientInfo::where('api_secrete_key', $req->bearerToken())->first();

                if(isset($merchantInfo) == true){
                    $thisuser = User::where('ref_code', $req->accountNumber)->first();

                    $thismerchant = User::where('ref_code', $merchantInfo->user_id)->first();

                    if(isset($thisuser) == true){

                        if($thisuser->country == $thismerchant->country){
                            $amount = $req->amount;
                            $myCurrency = $thisuser->currencyCode;
                        }
                        else{
                            // Currency converter
                            $amount = $this->convertCurrency($thismerchant->currencyCode, $req->amount, $thisuser->currencyCode);
                            $myCurrency = $thismerchant->currencyCode;
                        }


                            if($thisuser->wallet_balance < $amount){
                                    
                                $error = "Insufficient balance!. Your current wallet balance is ".$thisuser->currencyCode." ".number_format($thisuser->wallet_balance, 2);
                
                                $status = 400;
                                $resData = ['data' => [], 'message' => $error, 'status' => $status];
                            }
                            else{
                                // Continue with payment
                                $paymentToken = "wallet-".date('dmY').time();

                                $wallet_balance = $thisuser->wallet_balance - $req->amount;

                                $approve_commission = "Yes";

                                // Getting the sender
                                $userID = $thisuser->email;
                                $payerID = $thisuser->ref_code;



                                    try {

                                    // Update Wallet

                                    $service = $req->purpose;

                                    // Send mail to both parties

                                    // $this->to = "bambo@vimfile.com";
                                    $this->to = $thismerchant->email;
                                    $this->name = $thisuser->name;
                                    $this->coy_name = $thismerchant->businessname;
                                    // $this->email = "bambo@vimfile.com";
                                    $this->email = $thisuser->email;
                                    $this->amount = $myCurrency." ".number_format($amount, 2);
                                    $this->paypurpose = $service;
                                    $this->subject = "Payment Received from ".$thisuser->name." for ".$service;
                                    $this->subject2 = "Your Payment to ".$thismerchant->businessname." was successfull";

                                    // Mail to thismerchant
                                    $this->sendEmail($this->to, "Payment Received");

                                    // Mail from thisuser

                                    $this->sendEmail($this->email, "Payment Successful");


                                    // Insert Statement
                                    $activity = "Transfer of ".$thisuser->currencyCode." ".number_format($req->amount, 2)." to ".$thismerchant->businessname." for ".$service." on PaySprint Wallet.";
                                    $credit = 0;
                                    $debit = number_format($req->amount, 2);
                                    $reference_code = $paymentToken;
                                    $balance = 0;
                                    $trans_date = date('Y-m-d');
                                    $wallet_status = "Delivered";
                                    $action = "Wallet debit";
                                    $regards = $thismerchant->ref_code;


                                    $statement_route = "wallet";


                                    if($thismerchant->auto_deposit == 'on'){
                                        $recWallet = $thismerchant->wallet_balance + $amount;
                                        $walletstatus = "Delivered";
                                        
                                        $recMsg = "Hi ".$thismerchant->businessname.", You have received ".$myCurrency.' '.number_format($amount, 2)." in your PaySprint wallet for ".$service." from ".$thisuser->name.". You now have ".$myCurrency.' '.number_format($recWallet, 2)." balance in your wallet. PaySprint Team";

                                    }
                                    else{
                                        $recWallet = $thismerchant->wallet_balance;
                                        $walletstatus = "Pending";

                                        $recMsg = "Hi ".$thismerchant->businessname.", You have received ".$myCurrency.' '.number_format($amount, 2)." for ".$service." from ".$thisuser->name.". Your wallet balance is ".$myCurrency.' '.number_format($recWallet, 2).". Kindly login to your wallet account to receive money. PaySprint Team ".route('my account');

                                    }



                                    $sendMsg = "Hi ".$thisuser->name.", You have made a ".$activity." Your new Wallet balance is ".$thisuser->currencyCode.' '.number_format($wallet_balance, 2).". If you did not make this transfer, kindly login to your PaySprint Account to change your Transaction PIN and report the issue to PaySprint Admin using Contact Us. PaySprint Team";

                                    $getPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();
                                                    
                                    if(isset($getPhone)){

                                        $sendPhone = $thisuser->telephone;
                                    }
                                    else{
                                        $sendPhone = "+".$thisuser->code.$thisuser->telephone;
                                    }

                                    $this->sendMessage($sendMsg, $sendPhone);

                                    $merchantgetPhone = User::where('email', $thismerchant->email)->where('telephone', 'LIKE', '%+%')->first();
                                                    
                                    if(isset($merchantgetPhone)){

                                        $recPhone = $thismerchant->telephone;
                                    }
                                    else{
                                        $recPhone = "+".$thismerchant->code.$thismerchant->telephone;
                                    }

                                    $this->sendMessage($recMsg, $recPhone);

                                    
                                    $data = User::select('name', 'businessname as businessName', 'telephone', 'state', 'country', 'avatar')->where('ref_code', $thisuser->ref_code)->first();

                                    $data['paymentToken'] = $paymentToken;
                                    $data['amount'] = $req->amount;
                                    $data['currency'] = $thisuser->currencyCode;

                                    $status = 200;

                                    $resData = ['data' => $data, 'message' => 'Money Sent Successfully', 'status' => $status];


                                    Log::info("Sent money from ".$thisuser->name." to ".$thismerchant->businessname." using 3rd party gateway TEST MODE");

                                    
                                        
                                    } catch (\Exception $th) {
                                        $status = 400;

                                        $resData = ['data' => [], 'message' => 'Error: '.$th, 'status' => $status];
                                    }

                                

                            }

                    }
                    else{

                        $error = "Incorrect account number";
                
                        $status = 400;
                        $resData = ['data' => [], 'message' => $error, 'status' => $status];
                    }
                    
                }
                else{
                    $error = "Invalid Authorization Key";
                
                    $status = 400;
                    $resData = ['data' => [], 'message' => $error, 'status' => $status];
                }

            }
            else{

                $error = "Access mode can either be LIVE or TEST";
                
                $status = 400;
                $resData = ['data' => [], 'message' => $error, 'status' => $status];

            }



        }
        else{

            $error = implode(",",$validator->messages()->all());
            
            $status = 400;
            $resData = ['data' => [], 'message' => $error, 'status' => $status];
        }


        return $this->returnJSON($resData, $status);

    }



    // Receive Money From Visitors
    public function receiveMoneyFromVisitors(Request $req){


        $validator = Validator::make($req->all(), [
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'amount' => 'required',
            'country' => 'required',
            'cardNumber' => 'required',
            'expiryMonth' => 'required',
            'expiryYear' => 'required',
            'cardType' => 'required',
            'purpose' => 'required',
            'mode' => 'required',
        ]);



        if($validator->passes()){



            $merchantInfo = ClientInfo::where('api_secrete_key', $req->bearerToken())->first();


            if(isset($merchantInfo) == true){



                $thismerchant = User::where('ref_code', $merchantInfo->user_id)->first();

                $mode = strtoupper($req->mode);



                $countryInfo = $this->getCountryCode($req->country);

                $myCurrency = $countryInfo[0]->currencies[0]->code;

                // Currency converter
                $amount = $this->convertCurrency($thismerchant->currencyCode, $req->amount, $myCurrency);



                if($mode == strtoupper("live")){

                    // Make Payment

                    $response = $this->monerisWalletProcess($thismerchant->ref_code, $req->cardType, $amount, $req->purpose, $mode, $req->country, $req->expiryMonth, $req->cardNumber, $req->expiryYear);
                    

                    if($response->responseData['Message'] == "APPROVED           *                    ="){

                        $reference_code = $response->responseData['ReceiptId'];

                        $paymentToken = $reference_code;




                        try {

                            // Update Wallet

                            $countryInfo = $this->getCountryCode($req->country);

                            $currencyCode = $countryInfo[0]->currencies[0]->code;
                            $currencySymbol = $countryInfo[0]->currencies[0]->symbol;

                            $code = $countryInfo[0]->callingCodes[0];

                            $service = $req->purpose;

                            if($req->country == $thismerchant->country){
                                $amount = $req->amount;
                                $myCurrency = $currencyCode;
                            }
                            else{
                                // Currency converter
                                $amount = $this->convertCurrency($thismerchant->currencyCode, $req->amount, $currencyCode);
                                $myCurrency = $thismerchant->currencyCode;
                            }

                           


                            // Insert Statement
                            $activity = "Transfer of ".$myCurrency." ".number_format($req->amount, 2)." to ".$thismerchant->businessname." for ".$service;
                            $credit = 0;
                            $debit = number_format($req->amount, 2);
                            $reference_code = $reference_code;
                            $balance = 0;
                            $trans_date = date('Y-m-d');
                            $wallet_status = "Delivered";
                            $action = "Wallet debit";
                            $regards = $thismerchant->ref_code;


                            $statement_route = "wallet";


                            if($thismerchant->auto_deposit == 'on'){
                                $recWallet = $thismerchant->wallet_balance + $amount;
                                $walletstatus = "Delivered";
                                
                                $recMsg = "Hi ".$thismerchant->businessname.", You have received ".$myCurrency.' '.number_format($amount, 2)." in your PaySprint wallet for ".$service." from ".$req->firstname." ".$req->lastname." You now have ".$myCurrency.' '.number_format($recWallet, 2)." balance in your wallet. PaySprint Team";

                            }
                            else{
                                $recWallet = $thismerchant->wallet_balance;
                                $walletstatus = "Pending";

                                $recMsg = "Hi ".$thismerchant->businessname.", You have received ".$myCurrency.' '.number_format($amount, 2)." for ".$service." from ".$req->firstname." ".$req->lastname." Your wallet balance is ".$myCurrency.' '.number_format($recWallet, 2).". Kindly login to your wallet account to receive money. PaySprint Team ".route('my account');

                            }


                            User::where('ref_code', $thismerchant->ref_code)->update(['wallet_balance' => $recWallet]);

                            // thismerchant Statement
                            $this->insStatement($thismerchant->email, $paymentToken, "Received ".$myCurrency.' '.number_format($amount, 2)." in wallet for ".$service." from ".$req->firstname." ".$req->lastname, number_format($amount, 2), 0, $balance, $trans_date, $walletstatus, "Wallet credit", $thismerchant->ref_code, 1, $statement_route, $thismerchant->auto_deposit);

                             // Send mail to both parties

                            // $this->to = "bambo@vimfile.com";
                            $this->to = $thismerchant->email;
                            $this->name = $req->firstname;
                            $this->coy_name = $thismerchant->businessname;
                            // $this->email = "bambo@vimfile.com";
                            $this->email = $req->email;
                            $this->amount = $myCurrency." ".number_format($amount, 2);
                            $this->paypurpose = $service;
                            $this->subject = "Payment Received from ".$req->firstname." ".$req->lastname." for ".$service;
                            $this->subject2 = "Your Payment to ".$thismerchant->businessname." was successfull";

                            // Mail to thismerchant
                            $this->sendEmail($this->to, "Payment Received");

                            // Mail from thisuser
                            $this->sendEmail($this->email, "Payment Successful");


                            $receiverSMS = "Transfer of ".$countryInfo[0]->currencies[0]->code." ".number_format($req->amount, 2)." to ".$thismerchant->businessname." for ".$service;


                            $sendMsg = "Hi ".$req->firstname." ".$req->lastname.", You have made a ".$receiverSMS." Do more with PaySprint. Download our mobile app from Apple Store or Google Play Store. Thanks PaySprint Team";
                            $sendPhone = "+".$code.$req->phone;

                            $this->sendMessage($sendMsg, $sendPhone);

                            
                            $recPhone = "+".$thismerchant->code.$thismerchant->telephone;

                            $this->sendMessage($recMsg, $recPhone);
                            
                                    
                            


                            $data['name'] = $req->firstname.' '.$req->lastname;
                            $data['email'] = $req->email;
                            $data['phone'] = $req->phone;
                            $data['paymentToken'] = $paymentToken;
                            $data['amount'] = $req->amount;
                            $data['currency'] = $currencyCode;

                            $status = 200;

                            $resData = ['data' => $data, 'message' => 'Money Sent Successfully', 'status' => $status];


                            Log::info("Sent money from ".$req->firstname." ".$req->lastname." to ".$thismerchant->businessname." using 3rd party gateway LIVE MODE");

                            $this->createNotification($thismerchant->ref_code, $recMsg);

                            $monerisactivity = $recMsg;
                            $this->keepRecord($paymentToken, $response->responseData['Message'], $monerisactivity, "Moneris", $req->country);


                            
                                
                        } catch (\Exception $th) {
                            $status = 400;

                            $resData = ['data' => [], 'message' => 'Error: '.$th, 'status' => $status];
                        }


                    }
                    else{

                        $message = $response->responseData['Message'];
                        $status = 400;

                        $data = [];

                        

                        $monerisactivity = "Payment not successfull";
                        
                        $this->keepRecord("", $response->responseData['Message'], $monerisactivity, "Moneris", $req->country);
                        
                        $resData = ['data' => $data, 'message' => $message, 'status' => $status];
                    }

                    
                    

                }
                elseif($mode == strtoupper("test")){



                    // Make Payment

                    $response = $this->monerisWalletProcess($thismerchant->ref_code, $req->cardType, $amount, $req->purpose, $mode, $req->country, $req->expiryMonth, $req->cardNumber, $req->expiryYear);
                    

                    if($response->responseData['Message'] == "APPROVED           *                    ="){

                        $reference_code = $response->responseData['ReceiptId'];

                        $paymentToken = $reference_code;


                        try {

                            // Update Wallet

                            $countryInfo = $this->getCountryCode($req->country);

                            $currencyCode = $countryInfo[0]->currencies[0]->code;
                            $currencySymbol = $countryInfo[0]->currencies[0]->symbol;

                            $code = $countryInfo[0]->callingCodes[0];

                            $service = $req->purpose;

                            if($req->country == $thismerchant->country){
                                $amount = $req->amount;
                                $myCurrency = $currencyCode;
                            }
                            else{
                                // Currency converter
                                $amount = $this->convertCurrency($thismerchant->currencyCode, $req->amount, $currencyCode);
                                $myCurrency = $thismerchant->currencyCode;
                            }

                            // Send mail to both parties

                            // $this->to = "bambo@vimfile.com";
                            $this->to = $thismerchant->email;
                            $this->name = $req->firstname;
                            $this->coy_name = $thismerchant->businessname;
                            // $this->email = "bambo@vimfile.com";
                            $this->email = $req->email;
                            $this->amount = $myCurrency." ".number_format($amount, 2);
                            $this->paypurpose = $service;
                            $this->subject = "Payment Received from ".$req->firstname." ".$req->lastname." for ".$service;
                            $this->subject2 = "Your Payment to ".$thismerchant->businessname." was successfull";

                            // Mail to thismerchant
                            $this->sendEmail($this->to, "Payment Received");

                            // Mail from thisuser

                            $this->sendEmail($this->email, "Payment Successful");


                            // Insert Statement
                            $activity = "Transfer of ".$thismerchant->currencyCode." ".number_format($req->amount, 2)." to ".$thismerchant->businessname." for ".$service;
                            $credit = 0;
                            $debit = number_format($req->amount, 2);
                            $reference_code = $reference_code;
                            $balance = 0;
                            $trans_date = date('Y-m-d');
                            $wallet_status = "Delivered";
                            $action = "Wallet debit";
                            $regards = $thismerchant->ref_code;


                            $statement_route = "wallet";


                            if($thismerchant->auto_deposit == 'on'){
                                $recWallet = $thismerchant->wallet_balance + $amount;
                                $walletstatus = "Delivered";
                                
                                $recMsg = "Hi ".$thismerchant->businessname.", You have received ".$myCurrency.' '.number_format($amount, 2)." in your PaySprint wallet for ".$service." from ".$req->firstname." ".$req->lastname.". You now have ".$myCurrency.' '.number_format($recWallet, 2)." balance in your wallet. PaySprint Team";

                            }
                            else{
                                $recWallet = $thismerchant->wallet_balance;
                                $walletstatus = "Pending";

                                $recMsg = "Hi ".$thismerchant->businessname.", You have received ".$myCurrency.' '.number_format($amount, 2)." for ".$service." from ".$req->firstname." ".$req->lastname.". Your wallet balance is ".$myCurrency.' '.number_format($recWallet, 2).". Kindly login to your wallet account to receive money. PaySprint Team ".route('my account');

                            }


                            $sendMsg = "Hi ".$req->firstname." ".$req->lastname.", You have made a ".$activity." Do more with PaySprint. Download our mobile app from Apple Store or Google Play Store. Thanks PaySprint Team";
                            $sendPhone = "+".$code.$req->phone;

                            $this->sendMessage($sendMsg, $sendPhone);


                            $merchantgetPhone = User::where('email', $thismerchant->email)->where('telephone', 'LIKE', '%+%')->first();
                                                    
                            if(isset($merchantgetPhone)){

                                $recPhone = $thismerchant->telephone;
                            }
                            else{
                                $recPhone = "+".$thismerchant->code.$thismerchant->telephone;
                            }


                            $this->sendMessage($recMsg, $recPhone);
                            

                            $data['name'] = $req->firstname.' '.$req->lastname;
                            $data['email'] = $req->email;
                            $data['phone'] = $req->phone;
                            $data['paymentToken'] = $paymentToken;
                            $data['amount'] = $req->amount;
                            $data['currency'] = $currencyCode;

                            $status = 200;

                            $resData = ['data' => $data, 'message' => 'Money Sent Successfully', 'status' => $status];


                            Log::info("Sent money from ".$req->firstname." ".$req->lastname." to ".$thismerchant->businessname." using 3rd party gateway TEST MODE");


                            
                                
                        } catch (\Exception $th) {
                            $status = 400;

                            $resData = ['data' => [], 'message' => 'Error: '.$th, 'status' => $status];
                        }


                    }
                    else{

                        $message = $response->responseData['Message'];
                        $status = 400;

                        $data = [];

                        $resData = ['data' => $data, 'message' => $message, 'status' => $status];
                    }

                }
                else{

                    $error = "Access mode can either be LIVE or TEST";
                    
                    $status = 400;
                    $resData = ['data' => [], 'message' => $error, 'status' => $status];

                }

            }
            else{
                $error = "Invalid Authorization Key";
            
                $status = 400;
                $resData = ['data' => [], 'message' => $error, 'status' => $status];
            }

            

        }
        else{

            $error = implode(",",$validator->messages()->all());
            
            $status = 400;
            $resData = ['data' => [], 'message' => $error, 'status' => $status];
        }






        return $this->returnJSON($resData, $status);
    }


    public function monerisWalletProcess($ref_code, $cardType, $dollaramount, $description, $mode, $country, $month, $pan, $year){

        $thisuser = User::where('ref_code', $ref_code)->first();

        $userCardType = strtoupper($cardType);
        

        if($mode == strtoupper("test")){
            // Test API
            $store_id='monca04155';
            $api_token='KvTMr066FKlJm9rD3i71';
            $indicator = "Z";
            $setMode = true;
        }
        elseif($mode == strtoupper("live")){

            if($userCardType == strtoupper("Credit Card")){
                // Live API
                $store_id=env('MONERIS_STORE_ID_VIM');
                $api_token=env('MONERIS_API_TOKEN_VIM');

                $indicator = "U";
                $setMode = false;
            }
            else{
                // Live API
                $store_id=env('MONERIS_STORE_ID');
                $api_token=env('MONERIS_API_TOKEN');

                $setMode = false;
                $indicator = "Z";
            }
        }
        else{

            $store_id='';
            $api_token='';

            $setMode = false;
            $indicator = "";

            
        }

        




        $type='purchase';
        $cust_id= "visitor-".$thisuser->ref_code.time();
        $order_id='ord-'.date("dmy-Gis");

        $amount = $dollaramount;

        if($country == "Canada"){
            $amount= number_format($dollaramount, 2);
        }
        else{
            $amount= number_format($dollaramount, 2);
        }

        


        $expiry_date= $year.$month;
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
        $cof->setPaymentIndicator($indicator);
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
        $mpgResponse = $mpgHttpPost->getMpgResponse();

        return $mpgResponse;
    }


    public function insStatement($email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, $state, $statement_route, $auto_deposit){
        Statement::insert(['user_id' => $email, 'reference_code' => $reference_code, 'activity' => $activity, 'credit' => $credit, 'debit' => $debit, 'balance' => $balance, 'trans_date' => $trans_date, 'status' => $status, 'action' => $action, 'regards' => $regards, 'state' => $state, 'statement_route' => $statement_route, 'auto_deposit' => $auto_deposit]);
    }


    public function convertCurrency($currency, $amount, $localcurrency){

        $currency = 'USD'.$currency;
        $amount = $amount;
        $localCurrency = 'USD'.$localcurrency;

        $access_key = '6173fa628b16d8ce1e0db5cfa25092ac';

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

            // Conversion Rate Local to USD currency ie Y = 4000NGN / 380NGN(1 USD to Naira)
            $convertLocal = $amount / $result->quotes->$localCurrency;

            // Converting your USD value to other currency ie CAD * Y 
            $convRate = $result->quotes->$currency * $convertLocal;
        
            $message = 'success';

        }
        else{
            $convRate = 0;
            $message = 'failed';
        }

        

        $amountConvert = $convRate;


        return $amountConvert;

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
