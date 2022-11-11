<?php

namespace App\Http\Controllers;

use Session;

use Throwable;

// Moneris
use App\CrossBorder;

use App\FxStatement;

use App\PayoutAgent;

use App\User as User;

use App\Classes\axRef;

use App\Classes\axTxi;

use App\Classes\mcTax;

use App\EscrowAccount;
use App\Mail\sendEmail;

use App\Classes\CofInfo;

use App\Classes\MCPRate;

use App\ImportExcelLink;

use App\Traits\IDVCheck;

use App\Classes\axIt106s;

use App\Classes\axN1Loop;

use App\Classes\mcCorpac;

use App\Classes\mcCorpai;

use App\Classes\mcCorpal;

use App\Classes\mcCorpar;

use App\Classes\mcCorpas;

use App\Classes\mpgRecur;

use App\Classes\vsCorpai;

use App\Classes\vsCorpas;

use App\Classes\vsPurcha;

use App\Classes\vsPurchl;

use App\PayoutWithdrawal;

use App\Traits\Xwireless;

use App\Classes\axIt1Loop;

use App\Classes\httpsPost;

use App\InvoiceCommission;

use App\AddBank as AddBank;

use App\AddCard as AddCard;

use App\Classes\mpgAchInfo;
use App\Classes\mpgAvsInfo;
use App\Classes\mpgCvdInfo;

use App\Classes\mpgGlobals;
use App\Classes\mpgRequest;
use App\Classes\MpiRequest;
use App\Traits\SpecialInfo;
use App\Classes\mpgCustInfo;
use App\Classes\mpgResponse;
use App\Classes\MpiResponse;
use App\Classes\riskRequest;
use Illuminate\Http\Request;
use Stripe\Stripe as Stripe;
use App\Classes\mpgAxLevel23;
use App\Classes\mpgHttpsPost;
use App\Classes\mpgMcLevel23;
use App\Classes\mpgVsLevel23;
use App\Classes\MpiHttpsPost;
use App\Classes\riskResponse;
use App\Traits\AccountNotify;
use App\Traits\ElavonPayment;
use App\Classes\riskHttpsPost;
use App\Classes\vsTripLegInfo;
use App\Traits\ExpressPayment;
use App\Traits\PaymentGateway;
use App\Traits\PaysprintPoint;
use CraigPaul\Moneris\Moneris;
use App\Classes\mpgAxRaLevel23;
use App\Classes\mpgConvFeeInfo;
use App\Classes\mpgTransaction;
use App\Classes\MpiTransaction;
use App\EPSVendor as EPSVendor;
use App\Statement as Statement;
use App\StoreCart as StoreCart;
use App\Traits\PaystackPayment;
use App\Traits\SecurityChecker;
use App\Classes\riskTransaction;
use App\ChargeBack as ChargeBack;
use App\ClientInfo as ClientInfo;
use App\ReceivePay as ReceivePay;
use Illuminate\Support\Facades\DB;
use App\Classes\mpgHttpsPostStatus;
use App\CreateEvent as CreateEvent;
use App\ImportExcel as ImportExcel;
use App\StoreOrders as StoreOrders;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\AllCountries as AllCountries;
use App\CcWithdrawal as CcWithdrawal;
use App\Epaywithdraw as Epaywithdraw;
use App\SetupBilling as SetupBilling;
use App\Classes\mpgSessionAccountInfo;
use App\PaycaWithdraw as PaycaWithdraw;
use App\Classes\mpgAttributeAccountInfo;
use App\BankWithdrawal as BankWithdrawal;
use App\InvoicePayment as InvoicePayment;
use Illuminate\Support\Facades\Validator;
use Stripe\PaymentIntent as PaymentIntent;
use App\MonerisActivity as MonerisActivity;
use App\OrganizationPay as OrganizationPay;
use App\SupportActivity as SupportActivity;

use App\TransactionCost as TransactionCost;
use App\SpecialInformation as SpecialInformation;
use App\CrossBorderBeneficiary as CrossBorderBeneficiary;

class MonerisController extends Controller
{

    use PaymentGateway, PaystackPayment, ExpressPayment, ElavonPayment, Xwireless, PaysprintPoint, IDVCheck, SpecialInfo, AccountNotify, SecurityChecker;

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


    public function testRazor()
    {

        $item = $this->createPayment(100, 'Skimma', 'Payment for test');

        $data = $this->razorPayment($item["id"], 100);

        dd($data);
    }


    public function purchase(Request $req)
    {

        /**************************** Request Variables *******************************/

        /************************* Transactional Variables ****************************/

        // Test API
        // $store_id='monca04155';
        // $api_token='KvTMr066FKlJm9rD3i71';

        // Live API
        // $store_id='gwca026583';
        // $api_token='sssLFi2U8VFO0oWvPWax';
        $store_id = env('MONERIS_STORE_ID');
        $api_token = env('MONERIS_API_TOKEN');

        // $type='purchase';
        // $cust_id='cust id';
        // $order_id='ord-'.date("dmy-Gis");
        // $amount='1.00';
        // $pan='4242424242424242';
        // $expiry_date='2011';
        // $crypt='7';
        // $dynamic_descriptor='123';
        // $status_check = 'false';

        if ($req->typepayamount != 0) {
            $amount = $req->typepayamount;
        } else {
            $amount = $req->amount;
        }


        $month = $req->month;

        $type = 'purchase';
        $cust_id = $req->invoice_no;
        $order_id = 'ord-' . date("dmy-Gis");
        $amount = number_format($amount, 2);

        $pan = $req->creditcard_no;
        $expiry_date = $req->expirydate . $month;
        $crypt = '7';
        $dynamic_descriptor = 'Invoice Payment for PaySprint platform of EXBC';
        $status_check = 'false';

        $client = ClientInfo::where('user_id', $req->user_id)->first();
        $thisuser = User::where('email', $req->email)->first();



        /*********************** Transactional Associative Array **********************/
        $txnArray = array(
            'type' => $type,
            'order_id' => $order_id,
            'cust_id' => $cust_id,
            'amount' => $amount,
            'pan' => $pan,
            'expdate' => $expiry_date,
            'crypt_type' => $crypt,
            'dynamic_descriptor' => $dynamic_descriptor
            //,'wallet_indicator' => '' //Refer to documentation for details
            //,'cm_id' => '8nAK8712sGaAkls56' //set only for usage with Offlinx - Unique max 50 alphanumeric characters transaction id generated by merchant
        );
        /**************************** Transaction Object *****************************/



        $mpgTxn = new mpgTransaction($txnArray);


        /******************* Credential on File **********************************/
        $cof = new CofInfo();
        $cof->setPaymentIndicator("Z");
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
        $mpgHttpPost = new mpgHttpsPost($store_id, $api_token, $mpgRequest);
        /******************************* Response ************************************/
        $mpgResponse = $mpgHttpPost->getMpgResponse();

        // dd($mpgResponse);


        if ($mpgResponse->responseData['ResponseCode'] == "000" || $mpgResponse->responseData['ResponseCode'] == "001" || $mpgResponse->responseData['ResponseCode'] == "002" || $mpgResponse->responseData['ResponseCode'] == "003" || $mpgResponse->responseData['ResponseCode'] == "004" || $mpgResponse->responseData['ResponseCode'] == "005" || $mpgResponse->responseData['ResponseCode'] == "006" || $mpgResponse->responseData['ResponseCode'] == "007" || $mpgResponse->responseData['ResponseCode'] == "008" || $mpgResponse->responseData['ResponseCode'] == "009" || $mpgResponse->responseData['ResponseCode'] == "010" || $mpgResponse->responseData['ResponseCode'] == "023" || $mpgResponse->responseData['ResponseCode'] == "024" || $mpgResponse->responseData['ResponseCode'] == "025" || $mpgResponse->responseData['ResponseCode'] == "026" || $mpgResponse->responseData['ResponseCode'] == "027" || $mpgResponse->responseData['ResponseCode'] == "028" || $mpgResponse->responseData['ResponseCode'] == "029") {

            // Insert Record to DB...
            $insPay = InvoicePayment::updateOrCreate(['invoice_no' => $req->invoice_no], ['transactionid' => $mpgResponse->responseData['ReceiptId'], 'name' => $req->name, 'email' => $req->email, 'amount' => $mpgResponse->responseData['TransAmount'], 'invoice_no' => $req->invoice_no, 'service' => $req->service, 'client_id' => $req->user_id, 'payment_method' => $req->payment_method]);


            if ($insPay) {
                // Update Import Excel Record
                $getInv = ImportExcel::where('invoice_no', $req->invoice_no)->get();

                if (count($getInv) > 0) {
                    // Get Amount
                    $prevAmount = $getInv[0]->amount;

                    $paidAmount = $req->amount;

                    $newAmount = $prevAmount - $paidAmount;

                    $instcount = $getInv[0]->installcount + 1;

                    if ($getInv[0]->installlimit > $instcount) {
                        $installcounter = $getInv[0]->installlimit;
                    } else {
                        $installcounter = $instcount;
                    }

                    ImportExcel::where('invoice_no', $req->invoice_no)->update(['installcount' => $installcounter, 'payment_status' => 1]);

                    // Update Price Record
                    $updtPrice = InvoicePayment::where('transactionid', $mpgResponse->responseData['ReceiptId'])->update(['remaining_balance' => $newAmount, 'opening_balance' => $prevAmount, 'payment_method' => $req->payment_method]);

                    if ($updtPrice == 1) {


                        // Insert PAYCAWithdraw
                        PaycaWithdraw::insert(['withdraw_id' => $mpgResponse->responseData['ReceiptId'], 'client_id' => $req->user_id, 'client_name' => $req->name, 'card_method' => $req->payment_method, 'client_email' => $req->email, 'amount_to_withdraw' => $mpgResponse->responseData['TransAmount'], 'remittance' => 0]);





                        // Insert Statement
                        $activity = "Payment for " . $req->service . " to " . $client->business_name;
                        $credit = 0;
                        $debit = $req->amount;
                        $balance = $newAmount;
                        $status = "Paid";
                        $action = "Payment";
                        $regards = $req->user_id;
                        $reference_code = $mpgResponse->responseData['ReceiptId'];
                        $trans_date = date('Y-m-d');
                        $statement_route = "invoice";

                        $this->insStatement($req->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 0, $statement_route, $thisuser->country, 0);



                        $resData = ['res' => 'Payment Successful', 'message' => 'success', 'title' => 'Good!'];

                        $response = 'Payment Successful';
                        $action = 'success';



                        $this->createNotification($thisuser->ref_code, "Payment successfully made for " . $req->service . " to " . $client->business_name, $thisuser->playerId, "Payment successfully made for " . $req->service . " to " . $client->business_name, "Wallet Transaction");

                        $monerisactivity = "Payment successfully made for " . $req->service . " to " . $client->business_name . " by " . $thisuser->name;
                        $this->keepRecord($mpgResponse->responseData['ReceiptId'], $mpgResponse->responseData['Message'], $monerisactivity, 'moneris', $thisuser->country, 0);
                    } else {
                        $resData = ['res' => 'Something went wrong', 'message' => 'info', 'title' => 'Oops!'];

                        $response = 'Something went wrong';
                        $action = 'error';
                    }
                } else {
                    $resData = ['res' => 'Invoice not found', 'message' => 'error', 'title' => 'Oops!'];

                    $response = 'Invoice not found';
                    $action = 'error';
                }
            } else {
                $resData = ['res' => 'Information not documented, contact Admin', 'message' => 'info', 'title' => 'Oops!'];

                $response = 'Information not documented, contact Admin';
                $action = 'error';
            }
        } else {
            $resData = ['res' => $mpgResponse->responseData['Message'], 'message' => 'error', 'title' => 'Oops!'];

            $response = $mpgResponse->responseData['Message'];
            $action = 'error';

            $monerisactivity = "Payment error for " . $req->service . " to " . $client->business_name . " by " . $thisuser->name;
            $this->keepRecord("", $mpgResponse->responseData['Message'], $monerisactivity, 'moneris', $thisuser->country, 0);
        }

        // return $this->returnJSON($resData, 200);

        return redirect()->route('invoice')->with($action, $response);
    }



    // Pay Invoice from Wallet
    public function payInvoice(Request $req)
    {

        $routing = null;

        if ($req->amount < 0) {
            $response = 'Please enter a positive amount to send';

            $data = [];
            $status = 400;
            $message = $response;
        } else {
            if (isset($req->mode) && $req->mode == "test") {

                // dd($req->all());

                $validator = Validator::make($req->all(), [
                    'invoice_no' => 'required|string',
                    'amount' => 'required|string',
                    'merchant_id' => 'required|string',
                    'service' => 'required|string',
                    'payment_method' => 'required|string',
                    'currencyCode' => 'required|string',
                    'amountinvoiced' => 'required|string',
                    'payInstallment' => 'required|string',
                    'transaction_pin' => 'required|string',
                ]);

                if ($validator->passes()) {

                    try {
                        $transactionID = "invoice-" . date('dmY') . time();

                        $thisuser = User::where('api_token', $req->bearerToken())->first();

                        $thismerchant = User::where('ref_code', $req->merchant_id)->first();

                        $imtCountry = AllCountries::where('name', $thismerchant->country)->first();

                        if ($thisuser->approval < 1 && $thisuser->accountLevel < 1) {

                            $response = 'You cannot pay invoice at the moment because your account is still on review.';

                            $data = [];
                            $status = 400;
                            $message = $response;
                        }

                        // elseif ($thisuser->country != $thismerchant->country && !isset($req->merchantpay)) {
                        //     $response = 'Please visit the website on www.paysprint.ca to pay your international invoice';

                        //     $data = [];
                        //     $status = 400;
                        //     $message = $response;
                        // }

                        // elseif (isset($imtCountry) && $imtCountry->imt == "false") {
                        //     $response = 'International money transfer is not yet available to ' . $imtCountry->name;

                        //     $data = [];
                        //     $status = 400;
                        //     $message = $response;
                        // }

                        else {
                            // Get My Wallet Balance
                            $walletBalance = $thisuser->wallet_balance - $req->amount;

                            // User::where('api_token', $req->bearerToken())->update(['wallet_balance' => $walletBalance]);

                            // Update Merchant Wallet

                            if ($thisuser->country != $thismerchant->country) {
                                $paidinvoiceamount = $req->merchantpay;
                            } else {
                                $paidinvoiceamount = $req->amount;
                            }


                            // Update Merchant Wallet Balance
                            $merchantwalletBalance = $thismerchant->wallet_balance + $paidinvoiceamount;

                            // User::where('ref_code', $req->merchant_id)->update(['wallet_balance' => $merchantwalletBalance]);

                            // Get Invoice Service

                            // $invData = ImportExcel::where('invoice_no', $req->invoice_no)->first();

                            $purpose = $req->service;


                            $insPay = 1;


                            if ($insPay == 1) {
                                // Update Import Excel Record
                                $getInv = ImportExcel::where('invoice_no', $req->invoice_no)->get();

                                if (count($getInv) > 0) {

                                    // Check if instalmental or not

                                    if ($getInv[0]->installpay == "No" && $req->payInstallment == "Yes") {

                                        $response = 'Installmental payment is not allowed for this invoice';

                                        $data = [];
                                        $status = 400;
                                        $message = $response;
                                    } else {

                                        if ($req->payInstallment == "Yes") {

                                            if ($getInv[0]->remaining_balance > 0 || $getInv[0]->remaining_balance != null) {
                                                // Get Amount
                                                $prevAmount = $getInv[0]->remaining_balance;
                                            } else {
                                                $prevAmount = $getInv[0]->amount;
                                            }

                                            $paidAmount = $req->amount;

                                            $newAmount = $prevAmount - $paidAmount;

                                            $instcount = $getInv[0]->installcount + 1;

                                            if ($getInv[0]->installlimit > $instcount) {
                                                $installcounter = $getInv[0]->installlimit;
                                            } else {
                                                $installcounter = $instcount;
                                            }
                                        } else {

                                            if ($getInv[0]->remaining_balance > 0 || $getInv[0]->remaining_balance != null) {
                                                // Get Amount
                                                $prevAmount = $getInv[0]->remaining_balance;
                                            } else {
                                                $prevAmount = $getInv[0]->amount;
                                            }

                                            $paidAmount = $req->amount;

                                            $newAmount = $prevAmount - $paidAmount;

                                            $instcount = $getInv[0]->installcount;

                                            if ($getInv[0]->installlimit > $instcount) {
                                                $installcounter = $getInv[0]->installlimit;
                                            } else {
                                                $installcounter = $instcount;
                                            }
                                        }


                                        // if payment status is 2, there sre still some pending payments to make, if 1, payments are cleared off

                                        if ($newAmount > 0) {
                                            $payment_status = 2;
                                        } elseif ($newAmount == 0) {
                                            $payment_status = 1;
                                        } else {
                                            $payment_status = 0;
                                        }


                                        // ImportExcel::where('invoice_no', $req->invoice_no)->update(['installcount' => $installcounter, 'payment_status' => $payment_status, 'remaining_balance' => $newAmount]);

                                        // Update Price Record
                                        $updtPrice = 1;

                                        if ($updtPrice == 1) {

                                            $client = ClientInfo::where('user_id', $req->merchant_id)->get();

                                            // Insert PAYCAWithdraw
                                            // PaycaWithdraw::insert(['withdraw_id' => $transactionID, 'client_id' => $req->merchant_id, 'client_name' => $req->name, 'card_method' => $req->payment_method, 'client_email' => $req->email, 'amount_to_withdraw' => $req->amount, 'remittance' => 0]);


                                            $activity = "Payment for " . $purpose . " from " . $req->payment_method;
                                            $credit = 0;
                                            $debit = $req->amount;
                                            $balance = $newAmount;
                                            $status = "Delivered";
                                            $action = "Wallet debit";
                                            $regards = $req->merchant_id;
                                            $reference_code = $transactionID;
                                            $trans_date = date('Y-m-d');
                                            $statement_route = "wallet";


                                            // My Statement
                                            // $this->insStatement($thisuser->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 0, $statement_route, $thisuser->country, 0);

                                            $this->name = $thisuser->name;
                                            $this->email = $thisuser->email;
                                            // $this->email = "bambo@vimfile.com";
                                            $this->subject = "Your Invoice # [" . $req->invoice_no . "] of " . $req->currencyCode . ' ' . number_format($req->amount, 2) . ' from ' . $thismerchant->businessname . ' ' . number_format($req->amount, 2) . " is Paid";

                                            $this->message = '<p>Hi ' . $thisuser->name . ' You have successfully paid invoice of <strong>' . $req->currencyCode . ' ' . number_format($req->amount, 2) . '</strong> to ' . $thismerchant->name . ' for ' . $purpose . '. Your balance on Invoice # [' . $req->invoice_no . '] is <strong>' . $req->currencyCode . ' ' . number_format($newAmount, 2) . '</strong>. You have <strong>' . $req->currencyCode . ' ' . number_format($walletBalance, 2) . '</strong> in PaySprint Wallet account.</p><p>Thanks PaySprint Team.</p>';

                                            $this->sendEmail($this->email, "Fund remittance");

                                            $sendMsg = 'Hi ' . $thisuser->name . ' You have successfully paid invoice of ' . $req->currencyCode . ' ' . number_format($req->amount, 2) . ' to ' . $thismerchant->name . ' for ' . $purpose . '. Your balance on Invoice # [' . $req->invoice_no . '] is ' . $req->currencyCode . ' ' . number_format($newAmount, 2) . '. You have ' . $req->currencyCode . ' ' . number_format($walletBalance, 2) . ' in PaySprint Wallet account. Thanks PaySprint Team.';

                                            $userPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

                                            if (isset($userPhone)) {

                                                $sendPhone = $thisuser->telephone;
                                            } else {
                                                $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
                                            }

                                            if ($thisuser->country == "Nigeria") {

                                                $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                                                $this->sendSms($sendMsg, $correctPhone);
                                            } else {
                                                $this->sendMessage($sendMsg, $sendPhone);
                                            }




                                            /*---------------------------------------------------------------------------------------------------------------------*/

                                            // Merchant Statement

                                            $activity = "Added " . $thismerchant->currencyCode . '' . number_format($req->amount, 2) . " to Wallet";
                                            $credit = $req->amount;
                                            $debit = 0;
                                            $reference_code = $transactionID;
                                            $balance = 0;
                                            $trans_date = date('Y-m-d');
                                            $status = "Delivered";
                                            $action = "Wallet credit";
                                            $regards = $thismerchant->ref_code;
                                            $statement_route = "wallet";

                                            // Senders statement
                                            // $this->insStatement($thismerchant->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, $thismerchant->country, 0);


                                            $this->name = $thismerchant->name;
                                            $this->email = $thismerchant->email;
                                            // $this->email = "bambo@vimfile.com";
                                            $this->subject = $thisuser->name . " has paid Invoice: [" . $req->invoice_no . "]";

                                            $this->message = '<p>You have received <strong>' . $req->currencyCode . '' . number_format($req->amount, 2) . '</strong> for <b>INVOICE # [' . $req->invoice_no . ']</b> paid by <b>' . $thisuser->name . '</b>, invoice balance left is ' . $req->currencyCode . ' ' . number_format($newAmount, 2) . '.</p> <p>You have <strong>' . $req->currencyCode . '' . number_format($merchantwalletBalance, 2) . '</strong> in your wallet account with PaySprint</p><p>Thanks PaySprint Team.</p>';

                                            $this->sendEmail($this->email, "Fund remittance");

                                            $recMesg = 'You have received ' . $req->currencyCode . ' ' . number_format($req->amount, 2) . ' for INVOICE # [' . $req->invoice_no . '] paid by ' . $thisuser->name . ', invoice balance left is ' . $req->currencyCode . ' ' . number_format($newAmount, 2) . '. You have ' . $req->currencyCode . ' ' . number_format($merchantwalletBalance, 2) . ' in your wallet account with PaySprint. Thanks PaySprint Team.';

                                            $userPhone = User::where('email', $thismerchant->email)->where('telephone', 'LIKE', '%+%')->first();

                                            if (isset($userPhone)) {

                                                $recPhone = $thismerchant->telephone;
                                            } else {
                                                $recPhone = "+" . $thismerchant->code . $thismerchant->telephone;
                                            }

                                            if ($thismerchant->country == "Nigeria") {

                                                $correctPhone = preg_replace("/[^0-9]/", "", $recPhone);
                                                $this->sendSms($recMesg, $correctPhone);
                                            } else {
                                                $this->sendMessage($recMesg, $recPhone);
                                            }



                                            $userInfo = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol', 'bvn_account_number', 'bvn_bank', 'bvn_account_name', 'bvn_verification')->where('api_token', $req->bearerToken())->first();


                                            $data = $userInfo;
                                            $status = 200;
                                            $message = 'You have successfully paid invoice of ' . $req->currencyCode . ' ' . number_format($req->amount, 2);

                                            // $this->createNotification($thisuser->ref_code, $sendMsg);
                                            // $this->createNotification($thismerchant->ref_code, $recMesg);
                                        } else {

                                            $response = 'Something went wrong';

                                            $data = [];
                                            $status = 400;
                                            $message = $response;
                                        }
                                    }
                                } else {

                                    $response = 'Invoice not found';
                                    $data = [];
                                    $status = 400;
                                    $message = $response;
                                }
                            } else {
                                $response = 'Information not documented, contact Admin';

                                $data = [];
                                $status = 400;
                                $message = $response;
                            }
                        }
                    } catch (\Throwable $th) {
                        $data = [];
                        $status = 400;
                        $message = "Error: " . $th;
                    }
                } else {

                    $error = implode(",", $validator->messages()->all());

                    $data = [];
                    $status = 400;
                    $message = $error;
                }
            } else {

                // dd($req->all());

                $validator = Validator::make($req->all(), [
                    'invoice_no' => 'required|string',
                    'amount' => 'required|string',
                    'merchant_id' => 'required|string',
                    'service' => 'required|string',
                    'payment_method' => 'required|string',
                    'currencyCode' => 'required|string',
                    'amountinvoiced' => 'required|string',
                    'payInstallment' => 'required|string',
                    'transaction_pin' => 'required|string',
                ]);


                if ($validator->passes()) {

                    try {

                        $transactionID = "invoice-" . date('dmY') . time();

                        $thisuser = User::where('api_token', $req->bearerToken())->first();

                        // Check Transaction PIn
                        if ($thisuser->transaction_pin != null) {
                            // Validate Transaction PIN
                            if (Hash::check($req->transaction_pin, $thisuser->transaction_pin)) {
                                $thismerchant = User::where('ref_code', $req->merchant_id)->first();

                                // $imtCountry = AllCountries::where('name', $thismerchant->country)->first();

                                if ($thisuser->approval < 1 && $thisuser->accountLevel < 1) {

                                    $response = 'You cannot pay invoice at the moment because your account is still on review.';

                                    $data = [];
                                    $status = 400;
                                    $message = $response;
                                } elseif ($thisuser->country != $thismerchant->country && !isset($req->merchantpay)) {
                                    $response = 'Please visit the website on www.paysprint.ca to pay your international invoice';

                                    $data = [];
                                    $status = 400;
                                    $message = $response;
                                }
                                // elseif (isset($imtCountry) && $imtCountry->imt == "false") {
                                //     $response = 'International money transfer is not yet available to ' . $imtCountry->name;

                                //     $data = [];
                                //     $status = 400;
                                //     $message = $response;
                                // }
                                else {

                                    if ($thisuser->accountType == "Individual") {
                                        $subminType = "Consumer Monthly Subscription";
                                    } else {
                                        $subminType = "Merchant Monthly Subscription";
                                    }


                                    $minBal = $this->maintenanceBalanceWithdrawal($subminType, $thisuser->country);


                                    // Check Wallet Balance if up to amount

                                    if (isset($req->make_select_wallet) && $req->make_select_wallet == "FX Wallet") {

                                        $routing = 'fx';

                                        $wallet = EscrowAccount::where('escrow_id', $req->escrow_id)->first();

                                        if ($req->amount > $wallet->wallet_balance) {
                                            // Insufficient amount for withdrawal

                                            $data = [];
                                            $message = "Insufficient wallet balance";
                                            $status = 400;

                                            // Log::info('Oops!, Though this is a test, but '.$thisuser->name.' has '.$message);

                                            $this->slack(
                                                'Oops!, ' . $thisuser->name . ' has ' . $message,
                                                $room = "success-logs",
                                                $icon = ":longbox:",
                                                env('LOG_SLACK_SUCCESS_URL')
                                            );
                                        } else {



                                            // Update Merchant Wallet
                                            $getthisinvoice = ImportExcel::where('invoice_no', $req->invoice_no)->first();


                                            if ($thisuser->country != $thismerchant->country) {


                                                // If currency is not the same, convert currency here else use same price

                                                if ($thismerchant->currencyCode != $req->currencyCode) {


                                                    if ($thisuser->currencyCode == $getthisinvoice->invoiced_currency) {
                                                        $getRate = $this->getOfficialConversionRate($req->currencyCode, $thismerchant->currencyCode, 'payinvoice');
                                                    } else {
                                                        $getRate = $this->getOfficialConversionRate($getthisinvoice->invoiced_currency, $thismerchant->currencyCode, 'payinvoice');
                                                    }



                                                    if ($getthisinvoice->remaining_balance > 0) {

                                                        // Convert Currency with amount to pay on marked up price


                                                        $paidinvoiceamount = $getthisinvoice->remaining_balance * $getRate;
                                                    } else {
                                                        $paidinvoiceamount = ($getthisinvoice->total_amount + $getthisinvoice->remaining_balance)  * $getRate;
                                                    }
                                                } else {
                                                    if ($getthisinvoice->remaining_balance > 0) {
                                                        $paidinvoiceamount = $getthisinvoice->remaining_balance;
                                                    } else {
                                                        $paidinvoiceamount = $getthisinvoice->total_amount + $getthisinvoice->remaining_balance;
                                                    }
                                                }
                                            } else {
                                                $paidinvoiceamount = $req->amount;
                                            }




                                            // Get Invoice Service

                                            // $invData = ImportExcel::where('invoice_no', $req->invoice_no)->first();

                                            $purpose = $req->service;


                                            if ($thisuser->country != $thismerchant->country) {

                                                $insPay = InvoicePayment::updateOrCreate(['invoice_no' => $req->invoice_no], ['transactionid' => $transactionID, 'name' => $thisuser->name, 'email' => $thisuser->email, 'amount' => $paidinvoiceamount, 'invoice_no' => $req->invoice_no, 'service' => $purpose, 'client_id' => $req->merchant_id, 'payment_method' => $req->payment_method]);





                                                /**
                                                 * Get Mark up rate to sender i.e localcurrency (NGN for example = 584.33) take as X
                                                 * Get Official rate to the receiver i.e currency with which payment will be made and then convert to sender's country currency take as Y
                                                 * Subtract and Get Profit value in Senders local currency i.e X-Y = Z (NGN)
                                                 **/


                                                // Markup value to sender local currency i.e USD/NGN = 584.33

                                                $markedupRate = $this->getConversionRate($getthisinvoice->invoiced_currency, $thismerchant->currencyCode);

                                                // Customer Official rate i.e USD/CAD = 1.22
                                                $officialRate = $this->getOfficialConversionRate($getthisinvoice->invoiced_currency, $thisuser->currencyCode);


                                                // Get Rate to Merchant currency
                                                $convertedRate = $markedupRate / $officialRate;


                                                $newProfit = $markedupRate - $convertedRate;



                                                $profit_sender = $markedupRate - $getRate;

                                                $profit_receiver = $markedupRate / $profit_sender;


                                                // Insert Commission Info
                                                $commissionQuery = [
                                                    'invoice_no' => $req->invoice_no, 'sender' => $getthisinvoice->merchantName, 'receiver' => $getthisinvoice->name, 'invoice_amount' => $getthisinvoice->total_amount, 'invoiced_currency' => $getthisinvoice->invoiced_currency, 'official_rate' => $getRate, 'markedup_rate' => $markedupRate, 'profit_sender' => $newProfit, 'sender_currency' => $thismerchant->currencyCode, 'profit_receiver' => $profit_receiver, 'receiver_currency' => $thisuser->currencyCode
                                                ];


                                                InvoiceCommission::insert($commissionQuery);



                                                if ($insPay) {
                                                    // Update Import Excel Record
                                                    $getInv = ImportExcel::where('invoice_no', $req->invoice_no)->get();

                                                    if (count($getInv) > 0) {

                                                        // Check if instalmental or not

                                                        if ($getthisinvoice->installpay == "No" && $req->payInstallment == "Yes") {

                                                            $response = 'Installmental payment is not allowed for this invoice';

                                                            $data = [];
                                                            $status = 400;
                                                            $message = $response;
                                                        } else {


                                                            if ($thismerchant->currencyCode != $req->currencyCode) {

                                                                if ($req->payInstallment == "Yes") {

                                                                    if ($getthisinvoice->remaining_balance > 0 || $getthisinvoice->remaining_balance != null) {
                                                                        // Get Amount
                                                                        $prevAmount = $getthisinvoice->remaining_balance;
                                                                    } else {
                                                                        $prevAmount = $getthisinvoice->amount;
                                                                    }

                                                                    if ($thisuser->currencyCode == $getthisinvoice->invoiced_currency) {
                                                                        $paidAmount = $req->amount;
                                                                    } else {
                                                                        $paidAmount = $prevAmount;
                                                                    }




                                                                    $newAmount = $prevAmount - $paidAmount;

                                                                    $instcount = $getthisinvoice->installcount + 1;

                                                                    if ($getthisinvoice->installlimit > $instcount) {
                                                                        $installcounter = $getthisinvoice->installlimit;
                                                                    } else {
                                                                        $installcounter = $instcount;
                                                                    }
                                                                } else {

                                                                    if ($getthisinvoice->remaining_balance > 0 || $getthisinvoice->remaining_balance != null) {
                                                                        // Get Amount
                                                                        $prevAmount = $getthisinvoice->remaining_balance;
                                                                    } else {
                                                                        $prevAmount = $getthisinvoice->amount;
                                                                    }

                                                                    if ($thisuser->currencyCode == $getthisinvoice->invoiced_currency) {
                                                                        $paidAmount = $req->amount;
                                                                    } else {
                                                                        $paidAmount = $prevAmount;
                                                                    }




                                                                    $newAmount = $prevAmount - $paidAmount;

                                                                    $instcount = $getthisinvoice->installcount;

                                                                    if ($getthisinvoice->installlimit > $instcount) {
                                                                        $installcounter = $getthisinvoice->installlimit;
                                                                    } else {
                                                                        $installcounter = $instcount;
                                                                    }
                                                                }
                                                            } else {

                                                                if ($req->payInstallment == "Yes") {

                                                                    if ($getthisinvoice->remaining_balance > 0 || $getthisinvoice->remaining_balance != null) {
                                                                        // Get Amount
                                                                        $prevAmount = $getthisinvoice->remaining_balance;
                                                                    } else {
                                                                        $prevAmount = $getthisinvoice->amount;
                                                                    }

                                                                    $paidAmount = $paidinvoiceamount;

                                                                    $newAmount = $prevAmount - $paidAmount;

                                                                    $instcount = $getthisinvoice->installcount + 1;

                                                                    if ($getthisinvoice->installlimit > $instcount) {
                                                                        $installcounter = $getthisinvoice->installlimit;
                                                                    } else {
                                                                        $installcounter = $instcount;
                                                                    }
                                                                } else {

                                                                    if ($getthisinvoice->remaining_balance > 0 || $getthisinvoice->remaining_balance != null) {
                                                                        // Get Amount
                                                                        $prevAmount = $getthisinvoice->remaining_balance;
                                                                    } else {
                                                                        $prevAmount = $getthisinvoice->amount;
                                                                    }

                                                                    $paidAmount = $paidinvoiceamount;

                                                                    $newAmount = $prevAmount - $paidAmount;

                                                                    $instcount = $getthisinvoice->installcount;

                                                                    if ($getthisinvoice->installlimit > $instcount) {
                                                                        $installcounter = $getthisinvoice->installlimit;
                                                                    } else {
                                                                        $installcounter = $instcount;
                                                                    }
                                                                }
                                                            }



                                                            // if payment status is 2, there sre still some pending payments to make, if 1, payments are cleared off

                                                            if ($newAmount > 0) {
                                                                $payment_status = 2;
                                                            } elseif ($newAmount == 0) {
                                                                $payment_status = 1;
                                                            } else {
                                                                $payment_status = 0;
                                                            }


                                                            ImportExcel::where('invoice_no', $req->invoice_no)->update(['installcount' => $installcounter, 'payment_status' => $payment_status, 'remaining_balance' => $newAmount]);

                                                            // Update Price Record
                                                            $updtPrice = InvoicePayment::where('transactionid', $transactionID)->update(['remaining_balance' => $newAmount, 'opening_balance' => $prevAmount, 'payment_method' => $req->payment_method]);

                                                            if (isset($updtPrice)) {

                                                                $client = ClientInfo::where('user_id', $req->merchant_id)->get();

                                                                // Insert PAYCAWithdraw
                                                                PaycaWithdraw::insert(['withdraw_id' => $transactionID, 'client_id' => $req->merchant_id, 'client_name' => $req->name, 'card_method' => $req->payment_method, 'client_email' => $req->email, 'amount_to_withdraw' => $paidinvoiceamount, 'remittance' => 0]);


                                                                $activity = "Payment of " . $thisuser->currencyCode . ' ' . $req->amount . " for " . $purpose . " from FX Wallet";
                                                                $credit = 0;
                                                                $debit = $req->amount;
                                                                $balance = $newAmount;
                                                                $status = "Delivered";
                                                                $action = "Escrow Wallet debit";
                                                                $regards = $thisuser->ref_code;
                                                                $reference_code = $transactionID;
                                                                $trans_date = date('Y-m-d');
                                                                $statement_route = "escrow wallet";


                                                                // My FX Statement

                                                                $this->insFXStatement($wallet->escrow_id, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, 'on', $thisuser->country, 'confirmed');


                                                                // Senders statement
                                                                // $this->insStatement($thisuser->email, $reference_code, $activity, $debit, $credit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, $thisuser->country, 0);



                                                                $remainingBalance = $wallet->wallet_balance;

                                                                // Get My Wallet Balance
                                                                $walletBalance = $remainingBalance - $req->amount;

                                                                EscrowAccount::where('user_id', $thisuser->id)->where('escrow_id', $wallet->escrow_id)->update(['wallet_balance' => $walletBalance]);


                                                                // Update Merchant Wallet Balance
                                                                $merchantwalletBalance = $thismerchant->wallet_balance + $paidinvoiceamount;

                                                                User::where('ref_code', $req->merchant_id)->update(['wallet_balance' => $merchantwalletBalance]);

                                                                $this->name = $thisuser->name;
                                                                $this->email = $thisuser->email;
                                                                // $this->email = "bambo@vimfile.com";
                                                                $this->subject = "Your Invoice # [" . $req->invoice_no . "] of " . $thismerchant->currencyCode . ' ' . number_format($paidinvoiceamount, 2) . ' from ' . $thismerchant->businessname .  " is Paid";

                                                                $this->message = '<p>Hi ' . $thisuser->name . ' You have successfully paid invoice of <strong>' . $thismerchant->currencyCode . ' ' . number_format($paidinvoiceamount, 2) . '</strong> to ' . $thismerchant->name . ' for ' . $purpose . '. You have <strong>' . $req->currencyCode . ' ' . number_format($walletBalance, 2) . '</strong> in PaySprint Wallet account.</p><p>Thanks PaySprint Team.</p>';

                                                                $this->sendEmail($this->email, "Fund remittance");

                                                                $sendMsg = 'Hi ' . $thisuser->name . ' You have successfully paid invoice of ' . $thismerchant->currencyCode . ' ' . number_format($paidinvoiceamount, 2) . ' to ' . $thismerchant->name . ' for ' . $purpose . '. You have ' . $req->currencyCode . ' ' . number_format($walletBalance, 2) . ' in PaySprint Wallet account. Thanks PaySprint Team.';

                                                                $userPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

                                                                if (isset($userPhone)) {

                                                                    $sendPhone = $thisuser->telephone;
                                                                } else {
                                                                    $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
                                                                }

                                                                if ($thisuser->country == "Nigeria") {

                                                                    $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                                                                    $this->sendSms($sendMsg, $correctPhone);
                                                                } else {
                                                                    $this->sendMessage($sendMsg, $sendPhone);
                                                                }



                                                                /*---------------------------------------------------------------------------------------------------------------------*/

                                                                // Merchant Statement

                                                                $activity = "Added " . $thismerchant->currencyCode . '' . number_format($paidinvoiceamount, 2) . " to Wallet";
                                                                $credit = $paidinvoiceamount;
                                                                $debit = 0;
                                                                $reference_code = $transactionID;
                                                                $balance = 0;
                                                                $trans_date = date('Y-m-d');
                                                                $status = "Delivered";
                                                                $action = "Wallet credit";
                                                                $regards = $thismerchant->ref_code;
                                                                $statement_route = "wallet";

                                                                // Senders statement
                                                                $this->insStatement($thismerchant->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, $thismerchant->country, 0);


                                                                $this->name = $thismerchant->name;
                                                                $this->email = $thismerchant->email;
                                                                // $this->email = "bambo@vimfile.com";
                                                                $this->subject = $thisuser->name . " has paid Invoice: [" . $req->invoice_no . "]";

                                                                $this->message = '<p>You have received <strong>' . $thismerchant->currencyCode . '' . number_format($paidinvoiceamount, 2) . '</strong> for <b>INVOICE # [' . $req->invoice_no . ']</b> paid by <b>' . $thisuser->name . '</b>.</p> <p>You have <strong>' . $thismerchant->currencyCode . '' . number_format($merchantwalletBalance, 2) . '</strong> in your wallet account with PaySprint</p><p>Thanks PaySprint Team.</p>';

                                                                $this->sendEmail($this->email, "Fund remittance");

                                                                $recMesg = 'You have received ' . $thismerchant->currencyCode . ' ' . number_format($paidinvoiceamount, 2) . ' for INVOICE # [' . $req->invoice_no . '] paid by ' . $thisuser->name . '. You have ' . $thismerchant->currencyCode . ' ' . number_format($merchantwalletBalance, 2) . ' in your wallet account with PaySprint. Thanks PaySprint Team.';

                                                                $userPhone = User::where('email', $thismerchant->email)->where('telephone', 'LIKE', '%+%')->first();

                                                                if (isset($userPhone)) {

                                                                    $recPhone = $thismerchant->telephone;
                                                                } else {
                                                                    $recPhone = "+" . $thismerchant->code . $thismerchant->telephone;
                                                                }

                                                                if ($thismerchant->country == "Nigeria") {

                                                                    $correctPhone = preg_replace("/[^0-9]/", "", $recPhone);
                                                                    $this->sendSms($recMesg, $correctPhone);
                                                                } else {
                                                                    $this->sendMessage($recMesg, $recPhone);
                                                                }




                                                                $userInfo = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol', 'bvn_account_number', 'bvn_bank', 'bvn_account_name', 'bvn_verification')->where('api_token', $req->bearerToken())->first();


                                                                $data = $userInfo;
                                                                $status = 200;
                                                                $message = 'You have successfully paid invoice of ' . $thismerchant->currencyCode . ' ' . number_format($paidinvoiceamount, 2);

                                                                $this->createNotification($thisuser->ref_code, $sendMsg, $thisuser->playerId, $sendMsg, "Wallet Transaction");
                                                                $this->createNotification($thismerchant->ref_code, $recMesg, $thismerchant->playerId, $recMesg, "Wallet Transaction");
                                                            } else {

                                                                $response = 'Something went wrong';

                                                                $data = [];
                                                                $status = 400;
                                                                $message = $response;
                                                            }
                                                        }
                                                    } else {

                                                        $response = 'Invoice not found';
                                                        $data = [];
                                                        $status = 400;
                                                        $message = $response;
                                                    }
                                                } else {
                                                    $response = 'Information not documented, contact Admin';

                                                    $data = [];
                                                    $status = 400;
                                                    $message = $response;
                                                }
                                            } else {
                                                $insPay = InvoicePayment::updateOrCreate(['invoice_no' => $req->invoice_no], ['transactionid' => $transactionID, 'name' => $thisuser->name, 'email' => $thisuser->email, 'amount' => $req->amount, 'invoice_no' => $req->invoice_no, 'service' => $purpose, 'client_id' => $req->merchant_id, 'payment_method' => $req->payment_method]);


                                                if ($insPay) {
                                                    // Update Import Excel Record
                                                    $getInv = ImportExcel::where('invoice_no', $req->invoice_no)->get();

                                                    if (count($getInv) > 0) {

                                                        // Check if instalmental or not

                                                        if ($getInv[0]->installpay == "No" && $req->payInstallment == "Yes") {

                                                            $response = 'Installmental payment is not allowed for this invoice';

                                                            $data = [];
                                                            $status = 400;
                                                            $message = $response;
                                                        } else {

                                                            if ($req->payInstallment == "Yes") {

                                                                if ($getInv[0]->remaining_balance > 0 || $getInv[0]->remaining_balance != null) {
                                                                    // Get Amount
                                                                    $prevAmount = $getInv[0]->remaining_balance;
                                                                } else {
                                                                    $prevAmount = $getInv[0]->amount;
                                                                }

                                                                $paidAmount = $req->amount;

                                                                $newAmount = $prevAmount - $paidAmount;

                                                                $instcount = $getInv[0]->installcount + 1;

                                                                if ($getInv[0]->installlimit > $instcount) {
                                                                    $installcounter = $getInv[0]->installlimit;
                                                                } else {
                                                                    $installcounter = $instcount;
                                                                }
                                                            } else {

                                                                if ($getInv[0]->remaining_balance > 0 || $getInv[0]->remaining_balance != null) {
                                                                    // Get Amount
                                                                    $prevAmount = $getInv[0]->remaining_balance;
                                                                } else {
                                                                    $prevAmount = $getInv[0]->amount;
                                                                }

                                                                $paidAmount = $req->amount;

                                                                $newAmount = $prevAmount - $paidAmount;

                                                                $instcount = $getInv[0]->installcount;

                                                                if ($getInv[0]->installlimit > $instcount) {
                                                                    $installcounter = $getInv[0]->installlimit;
                                                                } else {
                                                                    $installcounter = $instcount;
                                                                }
                                                            }


                                                            // if payment status is 2, there sre still some pending payments to make, if 1, payments are cleared off

                                                            if ($newAmount > 0) {
                                                                $payment_status = 2;
                                                            } elseif ($newAmount == 0) {
                                                                $payment_status = 1;
                                                            } else {
                                                                $payment_status = 0;
                                                            }


                                                            ImportExcel::where('invoice_no', $req->invoice_no)->update(['installcount' => $installcounter, 'payment_status' => $payment_status, 'remaining_balance' => $newAmount]);

                                                            // Update Price Record
                                                            $updtPrice = InvoicePayment::where('transactionid', $transactionID)->update(['remaining_balance' => $newAmount, 'opening_balance' => $prevAmount, 'payment_method' => $req->payment_method]);

                                                            if (isset($updtPrice)) {

                                                                $client = ClientInfo::where('user_id', $req->merchant_id)->get();

                                                                // Insert PAYCAWithdraw
                                                                PaycaWithdraw::insert(['withdraw_id' => $transactionID, 'client_id' => $req->merchant_id, 'client_name' => $req->name, 'card_method' => $req->payment_method, 'client_email' => $req->email, 'amount_to_withdraw' => $req->amount, 'remittance' => 0]);


                                                                $activity = "Payment " . $thisuser->currencyCode . ' ' . $req->amount . " for " . $purpose . " from FX Wallet";
                                                                $credit = 0;
                                                                $debit = $req->amount;
                                                                $balance = $newAmount;
                                                                $status = "Delivered";
                                                                $action = "Wallet debit";
                                                                $regards = $thisuser->ref_code;
                                                                $reference_code = $transactionID;
                                                                $trans_date = date('Y-m-d');
                                                                $statement_route = "wallet";


                                                                // My FX Statement

                                                                $this->insFXStatement($wallet->escrow_id, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, 'on', $thisuser->country, 'confirmed');


                                                                $remainingBalance = $wallet->wallet_balance;

                                                                // Get My Wallet Balance
                                                                $walletBalance = $remainingBalance - $req->amount;


                                                                EscrowAccount::where('user_id', $thisuser->id)->where('escrow_id', $wallet->escrow_id)->update(['wallet_balance' => $walletBalance]);


                                                                // Update Merchant Wallet Balance
                                                                $merchantwalletBalance = $thismerchant->wallet_balance + $req->amount;

                                                                User::where(
                                                                    'ref_code',
                                                                    $req->merchant_id
                                                                )->update(['wallet_balance' => $merchantwalletBalance]);

                                                                $this->name = $thisuser->name;
                                                                $this->email = $thisuser->email;
                                                                // $this->email = "bambo@vimfile.com";
                                                                $this->subject = "Your Invoice # [" . $req->invoice_no . "] of " . $req->currencyCode . ' ' . number_format($req->amount, 2) . ' from ' . $thismerchant->businessname . ' ' . number_format($req->amount, 2) . " is Paid";

                                                                $this->message = '<p>Hi ' . $thisuser->name . ' You have successfully paid invoice of <strong>' . $req->currencyCode . ' ' . number_format($req->amount, 2) . '</strong> to ' . $thismerchant->name . ' for ' . $purpose . '. You have <strong>' . $req->currencyCode . ' ' . number_format($walletBalance, 2) . '</strong> in PaySprint Wallet account.</p><p>Thanks PaySprint Team.</p>';

                                                                $this->sendEmail($this->email, "Fund remittance");

                                                                $sendMsg = 'Hi ' . $thisuser->name . ' You have successfully paid invoice of ' . $req->currencyCode . ' ' . number_format($req->amount, 2) . ' to ' . $thismerchant->name . ' for ' . $purpose . '. You have ' . $req->currencyCode . ' ' . number_format($walletBalance, 2) . ' in PaySprint Wallet account. Thanks PaySprint Team.';

                                                                $userPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

                                                                if (isset($userPhone)) {

                                                                    $sendPhone = $thisuser->telephone;
                                                                } else {
                                                                    $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
                                                                }

                                                                if ($thisuser->country == "Nigeria") {

                                                                    $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                                                                    $this->sendSms($sendMsg, $correctPhone);
                                                                } else {
                                                                    $this->sendMessage($sendMsg, $sendPhone);
                                                                }



                                                                /*---------------------------------------------------------------------------------------------------------------------*/

                                                                // Merchant Statement

                                                                $activity = "Added " . $req->currencyCode . '' . number_format($req->amount, 2) . " to Wallet";
                                                                $credit = $req->amount;
                                                                $debit = 0;
                                                                $reference_code = $transactionID;
                                                                $balance = 0;
                                                                $trans_date = date('Y-m-d');
                                                                $status = "Delivered";
                                                                $action = "Wallet credit";
                                                                $regards = $thismerchant->ref_code;
                                                                $statement_route = "wallet";

                                                                // Senders statement
                                                                $this->insStatement($thismerchant->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, $thismerchant->country, 0);


                                                                $this->name = $thismerchant->name;
                                                                $this->email = $thismerchant->email;
                                                                // $this->email = "bambo@vimfile.com";
                                                                $this->subject = $thisuser->name . " has paid Invoice: [" . $req->invoice_no . "]";

                                                                $this->message = '<p>You have received <strong>' . $req->currencyCode . '' . number_format($req->amount, 2) . '</strong> for <b>INVOICE # [' . $req->invoice_no . ']</b> paid by <b>' . $thisuser->name . '</b>.</p> <p>You have <strong>' . $req->currencyCode . '' . number_format($merchantwalletBalance, 2) . '</strong> in your wallet account with PaySprint</p><p>Thanks PaySprint Team.</p>';

                                                                $this->sendEmail($this->email, "Fund remittance");

                                                                $recMesg = 'You have received ' . $req->currencyCode . ' ' . number_format($req->amount, 2) . ' for INVOICE # [' . $req->invoice_no . '] paid by ' . $thisuser->name . '. You have ' . $req->currencyCode . ' ' . number_format($merchantwalletBalance, 2) . ' in your wallet account with PaySprint. Thanks PaySprint Team.';

                                                                $userPhone = User::where('email', $thismerchant->email)->where('telephone', 'LIKE', '%+%')->first();

                                                                if (isset($userPhone)) {

                                                                    $recPhone = $thismerchant->telephone;
                                                                } else {
                                                                    $recPhone = "+" . $thismerchant->code . $thismerchant->telephone;
                                                                }

                                                                if ($thismerchant->country == "Nigeria") {

                                                                    $correctPhone = preg_replace("/[^0-9]/", "", $recPhone);
                                                                    $this->sendSms($recMesg, $correctPhone);
                                                                } else {
                                                                    $this->sendMessage($recMesg, $recPhone);
                                                                }




                                                                $userInfo = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol', 'bvn_account_number', 'bvn_bank', 'bvn_account_name', 'bvn_verification')->where('api_token', $req->bearerToken())->first();


                                                                $data = $userInfo;
                                                                $status = 200;
                                                                $message = 'You have successfully paid invoice of ' . $req->currencyCode . ' ' . number_format($req->amount, 2);

                                                                $this->createNotification($thisuser->ref_code, $sendMsg, $thisuser->playerId, $sendMsg, "Wallet Transaction");
                                                                $this->createNotification($thismerchant->ref_code, $recMesg, $thismerchant->playerId, $recMesg, "Wallet Transaction");
                                                            } else {

                                                                $response = 'Something went wrong';

                                                                $data = [];
                                                                $status = 400;
                                                                $message = $response;
                                                            }
                                                        }
                                                    } else {

                                                        $response = 'Invoice not found';
                                                        $data = [];
                                                        $status = 400;
                                                        $message = $response;
                                                    }
                                                } else {
                                                    $response = 'Information not documented, contact Admin';

                                                    $data = [];
                                                    $status = 400;
                                                    $message = $response;
                                                }
                                            }
                                        }
                                    } else {


                                        if ($req->amount > ($thisuser->wallet_balance - $minBal)) {
                                            // Insufficient amount for withdrawal

                                            $data = [];
                                            $message = "Insufficient wallet balance";
                                            $status = 400;

                                            // Log::info('Oops!, Though this is a test, but '.$thisuser->name.' has '.$message);

                                            $this->slack(
                                                'Oops!, ' . $thisuser->name . ' has ' . $message,
                                                $room = "success-logs",
                                                $icon = ":longbox:",
                                                env('LOG_SLACK_SUCCESS_URL')
                                            );
                                        } else {



                                            // Update Merchant Wallet
                                            $getthisinvoice = ImportExcel::where('invoice_no', $req->invoice_no)->first();


                                            if ($thisuser->country != $thismerchant->country) {


                                                // If currency is not the same, convert currency here else use same price

                                                if ($thismerchant->currencyCode != $req->currencyCode) {


                                                    if ($thisuser->currencyCode == $getthisinvoice->invoiced_currency) {
                                                        $getRate = $this->getOfficialConversionRate($req->currencyCode, $thismerchant->currencyCode);
                                                    } else {
                                                        $getRate = $this->getOfficialConversionRate($getthisinvoice->invoiced_currency, $thismerchant->currencyCode);
                                                    }



                                                    if ($getthisinvoice->remaining_balance > 0) {

                                                        // Convert Currency with amount to pay on marked up price


                                                        $paidinvoiceamount = $getthisinvoice->remaining_balance * $getRate;
                                                    } else {
                                                        $paidinvoiceamount = ($getthisinvoice->total_amount + $getthisinvoice->remaining_balance)  * $getRate;
                                                    }
                                                } else {
                                                    if ($getthisinvoice->remaining_balance > 0) {
                                                        $paidinvoiceamount = $getthisinvoice->remaining_balance;
                                                    } else {
                                                        $paidinvoiceamount = $getthisinvoice->total_amount + $getthisinvoice->remaining_balance;
                                                    }
                                                }
                                            } else {
                                                $paidinvoiceamount = $req->amount;
                                            }




                                            // Get Invoice Service

                                            // $invData = ImportExcel::where('invoice_no', $req->invoice_no)->first();

                                            $purpose = $req->service;


                                            if ($thisuser->country != $thismerchant->country) {

                                                $insPay = InvoicePayment::updateOrCreate(['invoice_no' => $req->invoice_no], ['transactionid' => $transactionID, 'name' => $thisuser->name, 'email' => $thisuser->email, 'amount' => $paidinvoiceamount, 'invoice_no' => $req->invoice_no, 'service' => $purpose, 'client_id' => $req->merchant_id, 'payment_method' => $req->payment_method]);





                                                /**
                                                 * Get Mark up rate to sender i.e localcurrency (NGN for example = 584.33) take as X
                                                 * Get Official rate to the receiver i.e currency with which payment will be made and then convert to sender's country currency take as Y
                                                 * Subtract and Get Profit value in Senders local currency i.e X-Y = Z (NGN)
                                                 **/


                                                // Markup value to sender local currency i.e USD/NGN = 584.33

                                                $markedupRate = $this->getConversionRate($getthisinvoice->invoiced_currency, $thismerchant->currencyCode);

                                                // Customer Official rate i.e USD/CAD = 1.22
                                                $officialRate = $this->getOfficialConversionRate($getthisinvoice->invoiced_currency, $thisuser->currencyCode);


                                                // Get Rate to Merchant currency
                                                $convertedRate = $markedupRate / $officialRate;


                                                $newProfit = $markedupRate - $convertedRate;



                                                $profit_sender = $markedupRate - $getRate;

                                                $profit_receiver = $markedupRate / $profit_sender;


                                                // Insert Commission Info
                                                $commissionQuery = [
                                                    'invoice_no' => $req->invoice_no, 'sender' => $getthisinvoice->merchantName, 'receiver' => $getthisinvoice->name, 'invoice_amount' => $getthisinvoice->total_amount, 'invoiced_currency' => $getthisinvoice->invoiced_currency, 'official_rate' => $getRate, 'markedup_rate' => $markedupRate, 'profit_sender' => $newProfit, 'sender_currency' => $thismerchant->currencyCode, 'profit_receiver' => $profit_receiver, 'receiver_currency' => $thisuser->currencyCode
                                                ];


                                                InvoiceCommission::insert($commissionQuery);



                                                if ($insPay) {
                                                    // Update Import Excel Record
                                                    $getInv = ImportExcel::where('invoice_no', $req->invoice_no)->get();

                                                    if (count($getInv) > 0) {

                                                        // Check if instalmental or not

                                                        if ($getthisinvoice->installpay == "No" && $req->payInstallment == "Yes") {

                                                            $response = 'Installmental payment is not allowed for this invoice';

                                                            $data = [];
                                                            $status = 400;
                                                            $message = $response;
                                                        } else {


                                                            if ($thismerchant->currencyCode != $req->currencyCode) {

                                                                if ($req->payInstallment == "Yes") {

                                                                    if ($getthisinvoice->remaining_balance > 0 || $getthisinvoice->remaining_balance != null) {
                                                                        // Get Amount
                                                                        $prevAmount = $getthisinvoice->remaining_balance;
                                                                    } else {
                                                                        $prevAmount = $getthisinvoice->amount;
                                                                    }

                                                                    if ($thisuser->currencyCode == $getthisinvoice->invoiced_currency) {
                                                                        $paidAmount = $req->amount;
                                                                    } else {
                                                                        $paidAmount = $prevAmount;
                                                                    }




                                                                    $newAmount = $prevAmount - $paidAmount;

                                                                    $instcount = $getthisinvoice->installcount + 1;

                                                                    if ($getthisinvoice->installlimit > $instcount) {
                                                                        $installcounter = $getthisinvoice->installlimit;
                                                                    } else {
                                                                        $installcounter = $instcount;
                                                                    }
                                                                } else {

                                                                    if ($getthisinvoice->remaining_balance > 0 || $getthisinvoice->remaining_balance != null) {
                                                                        // Get Amount
                                                                        $prevAmount = $getthisinvoice->remaining_balance;
                                                                    } else {
                                                                        $prevAmount = $getthisinvoice->amount;
                                                                    }

                                                                    if ($thisuser->currencyCode == $getthisinvoice->invoiced_currency) {
                                                                        $paidAmount = $req->amount;
                                                                    } else {
                                                                        $paidAmount = $prevAmount;
                                                                    }




                                                                    $newAmount = $prevAmount - $paidAmount;

                                                                    $instcount = $getthisinvoice->installcount;

                                                                    if ($getthisinvoice->installlimit > $instcount) {
                                                                        $installcounter = $getthisinvoice->installlimit;
                                                                    } else {
                                                                        $installcounter = $instcount;
                                                                    }
                                                                }
                                                            } else {

                                                                if ($req->payInstallment == "Yes") {

                                                                    if ($getthisinvoice->remaining_balance > 0 || $getthisinvoice->remaining_balance != null) {
                                                                        // Get Amount
                                                                        $prevAmount = $getthisinvoice->remaining_balance;
                                                                    } else {
                                                                        $prevAmount = $getthisinvoice->amount;
                                                                    }

                                                                    $paidAmount = $paidinvoiceamount;

                                                                    $newAmount = $prevAmount - $paidAmount;

                                                                    $instcount = $getthisinvoice->installcount + 1;

                                                                    if ($getthisinvoice->installlimit > $instcount) {
                                                                        $installcounter = $getthisinvoice->installlimit;
                                                                    } else {
                                                                        $installcounter = $instcount;
                                                                    }
                                                                } else {

                                                                    if ($getthisinvoice->remaining_balance > 0 || $getthisinvoice->remaining_balance != null) {
                                                                        // Get Amount
                                                                        $prevAmount = $getthisinvoice->remaining_balance;
                                                                    } else {
                                                                        $prevAmount = $getthisinvoice->amount;
                                                                    }

                                                                    $paidAmount = $paidinvoiceamount;

                                                                    $newAmount = $prevAmount - $paidAmount;

                                                                    $instcount = $getthisinvoice->installcount;

                                                                    if ($getthisinvoice->installlimit > $instcount) {
                                                                        $installcounter = $getthisinvoice->installlimit;
                                                                    } else {
                                                                        $installcounter = $instcount;
                                                                    }
                                                                }
                                                            }



                                                            // if payment status is 2, there sre still some pending payments to make, if 1, payments are cleared off

                                                            if ($newAmount > 0) {
                                                                $payment_status = 2;
                                                            } elseif ($newAmount == 0) {
                                                                $payment_status = 1;
                                                            } else {
                                                                $payment_status = 0;
                                                            }


                                                            ImportExcel::where('invoice_no', $req->invoice_no)->update(['installcount' => $installcounter, 'payment_status' => $payment_status, 'remaining_balance' => $newAmount]);

                                                            // Update Price Record
                                                            $updtPrice = InvoicePayment::where('transactionid', $transactionID)->update(['remaining_balance' => $newAmount, 'opening_balance' => $prevAmount, 'payment_method' => $req->payment_method]);

                                                            if (isset($updtPrice)) {

                                                                $client = ClientInfo::where('user_id', $req->merchant_id)->get();

                                                                // Insert PAYCAWithdraw
                                                                PaycaWithdraw::insert(['withdraw_id' => $transactionID, 'client_id' => $req->merchant_id, 'client_name' => $req->name, 'card_method' => $req->payment_method, 'client_email' => $req->email, 'amount_to_withdraw' => $paidinvoiceamount, 'remittance' => 0]);


                                                                $activity = "Payment of " . $thisuser->currencyCode . ' ' . $req->amount . " for " . $purpose . " from " . $req->payment_method;
                                                                $credit = 0;
                                                                $debit = $req->amount;
                                                                $balance = $newAmount;
                                                                $status = "Delivered";
                                                                $action = "Wallet debit";
                                                                $regards = $thisuser->ref_code;
                                                                $reference_code = $transactionID;
                                                                $trans_date = date('Y-m-d');
                                                                $statement_route = "wallet";


                                                                // My Statement
                                                                $this->insStatement($thisuser->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 0, $statement_route, $thisuser->country, 0);


                                                                $remainingBalance = ($thisuser->wallet_balance - $minBal);

                                                                // Get My Wallet Balance
                                                                $walletBalance = $remainingBalance - $req->amount;

                                                                User::where('api_token', $req->bearerToken())->update(['wallet_balance' => $walletBalance]);


                                                                // Update Merchant Wallet Balance
                                                                $merchantwalletBalance = $thismerchant->wallet_balance + $paidinvoiceamount;

                                                                User::where('ref_code', $req->merchant_id)->update(['wallet_balance' => $merchantwalletBalance]);

                                                                $this->name = $thisuser->name;
                                                                $this->email = $thisuser->email;
                                                                // $this->email = "bambo@vimfile.com";
                                                                $this->subject = "Your Invoice # [" . $req->invoice_no . "] of " . $thismerchant->currencyCode . ' ' . number_format($paidinvoiceamount, 2) . ' from ' . $thismerchant->businessname .  " is Paid";

                                                                $this->message = '<p>Hi ' . $thisuser->name . ' You have successfully paid invoice of <strong>' . $thismerchant->currencyCode . ' ' . number_format($paidinvoiceamount, 2) . '</strong> to ' . $thismerchant->name . ' for ' . $purpose . '. You have <strong>' . $req->currencyCode . ' ' . number_format($walletBalance, 2) . '</strong> in PaySprint Wallet account.</p><p>Thanks PaySprint Team.</p>';

                                                                $this->sendEmail($this->email, "Fund remittance");

                                                                $sendMsg = 'Hi ' . $thisuser->name . ' You have successfully paid invoice of ' . $thismerchant->currencyCode . ' ' . number_format($paidinvoiceamount, 2) . ' to ' . $thismerchant->name . ' for ' . $purpose . '. You have ' . $req->currencyCode . ' ' . number_format($walletBalance, 2) . ' in PaySprint Wallet account. Thanks PaySprint Team.';

                                                                $userPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

                                                                if (isset($userPhone)) {

                                                                    $sendPhone = $thisuser->telephone;
                                                                } else {
                                                                    $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
                                                                }

                                                                if ($thisuser->country == "Nigeria") {

                                                                    $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                                                                    $this->sendSms($sendMsg, $correctPhone);
                                                                } else {
                                                                    $this->sendMessage($sendMsg, $sendPhone);
                                                                }



                                                                /*---------------------------------------------------------------------------------------------------------------------*/

                                                                // Merchant Statement

                                                                $activity = "Added " . $thismerchant->currencyCode . '' . number_format($paidinvoiceamount, 2) . " to Wallet";
                                                                $credit = $paidinvoiceamount;
                                                                $debit = 0;
                                                                $reference_code = $transactionID;
                                                                $balance = 0;
                                                                $trans_date = date('Y-m-d');
                                                                $status = "Delivered";
                                                                $action = "Wallet credit";
                                                                $regards = $thismerchant->ref_code;
                                                                $statement_route = "wallet";

                                                                // Senders statement
                                                                $this->insStatement($thismerchant->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, $thismerchant->country, 0);


                                                                $this->name = $thismerchant->name;
                                                                $this->email = $thismerchant->email;
                                                                // $this->email = "bambo@vimfile.com";
                                                                $this->subject = $thisuser->name . " has paid Invoice: [" . $req->invoice_no . "]";

                                                                $this->message = '<p>You have received <strong>' . $thismerchant->currencyCode . '' . number_format($paidinvoiceamount, 2) . '</strong> for <b>INVOICE # [' . $req->invoice_no . ']</b> paid by <b>' . $thisuser->name . '</b>.</p> <p>You have <strong>' . $thismerchant->currencyCode . '' . number_format($merchantwalletBalance, 2) . '</strong> in your wallet account with PaySprint</p><p>Thanks PaySprint Team.</p>';

                                                                $this->sendEmail($this->email, "Fund remittance");

                                                                $recMesg = 'You have received ' . $thismerchant->currencyCode . ' ' . number_format($paidinvoiceamount, 2) . ' for INVOICE # [' . $req->invoice_no . '] paid by ' . $thisuser->name . '. You have ' . $thismerchant->currencyCode . ' ' . number_format($merchantwalletBalance, 2) . ' in your wallet account with PaySprint. Thanks PaySprint Team.';

                                                                $userPhone = User::where('email', $thismerchant->email)->where('telephone', 'LIKE', '%+%')->first();

                                                                if (isset($userPhone)) {

                                                                    $recPhone = $thismerchant->telephone;
                                                                } else {
                                                                    $recPhone = "+" . $thismerchant->code . $thismerchant->telephone;
                                                                }

                                                                if ($thismerchant->country == "Nigeria") {

                                                                    $correctPhone = preg_replace("/[^0-9]/", "", $recPhone);
                                                                    $this->sendSms($recMesg, $correctPhone);
                                                                } else {
                                                                    $this->sendMessage($recMesg, $recPhone);
                                                                }




                                                                $userInfo = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol', 'bvn_account_number', 'bvn_bank', 'bvn_account_name', 'bvn_verification')->where('api_token', $req->bearerToken())->first();


                                                                $data = $userInfo;
                                                                $status = 200;
                                                                $message = 'You have successfully paid invoice of ' . $thismerchant->currencyCode . ' ' . number_format($paidinvoiceamount, 2);

                                                                $this->createNotification($thisuser->ref_code, $sendMsg, $thisuser->playerId, $sendMsg, "Wallet Transaction");
                                                                $this->createNotification($thismerchant->ref_code, $recMesg, $thismerchant->playerId, $recMesg, "Wallet Transaction");
                                                            } else {

                                                                $response = 'Something went wrong';

                                                                $data = [];
                                                                $status = 400;
                                                                $message = $response;
                                                            }
                                                        }
                                                    } else {

                                                        $response = 'Invoice not found';
                                                        $data = [];
                                                        $status = 400;
                                                        $message = $response;
                                                    }
                                                } else {
                                                    $response = 'Information not documented, contact Admin';

                                                    $data = [];
                                                    $status = 400;
                                                    $message = $response;
                                                }
                                            } else {
                                                $insPay = InvoicePayment::updateOrCreate(['invoice_no' => $req->invoice_no], ['transactionid' => $transactionID, 'name' => $thisuser->name, 'email' => $thisuser->email, 'amount' => $req->amount, 'invoice_no' => $req->invoice_no, 'service' => $purpose, 'client_id' => $req->merchant_id, 'payment_method' => $req->payment_method]);


                                                if ($insPay) {
                                                    // Update Import Excel Record
                                                    $getInv = ImportExcel::where('invoice_no', $req->invoice_no)->get();

                                                    if (count($getInv) > 0) {

                                                        // Check if instalmental or not

                                                        if ($getInv[0]->installpay == "No" && $req->payInstallment == "Yes") {

                                                            $response = 'Installmental payment is not allowed for this invoice';

                                                            $data = [];
                                                            $status = 400;
                                                            $message = $response;
                                                        } else {

                                                            if ($req->payInstallment == "Yes") {

                                                                if ($getInv[0]->remaining_balance > 0 || $getInv[0]->remaining_balance != null) {
                                                                    // Get Amount
                                                                    $prevAmount = $getInv[0]->remaining_balance;
                                                                } else {
                                                                    $prevAmount = $getInv[0]->amount;
                                                                }

                                                                $paidAmount = $req->amount;

                                                                $newAmount = $prevAmount - $paidAmount;

                                                                $instcount = $getInv[0]->installcount + 1;

                                                                if ($getInv[0]->installlimit > $instcount) {
                                                                    $installcounter = $getInv[0]->installlimit;
                                                                } else {
                                                                    $installcounter = $instcount;
                                                                }
                                                            } else {

                                                                if ($getInv[0]->remaining_balance > 0 || $getInv[0]->remaining_balance != null) {
                                                                    // Get Amount
                                                                    $prevAmount = $getInv[0]->remaining_balance;
                                                                } else {
                                                                    $prevAmount = $getInv[0]->amount;
                                                                }

                                                                $paidAmount = $req->amount;

                                                                $newAmount = $prevAmount - $paidAmount;

                                                                $instcount = $getInv[0]->installcount;

                                                                if ($getInv[0]->installlimit > $instcount) {
                                                                    $installcounter = $getInv[0]->installlimit;
                                                                } else {
                                                                    $installcounter = $instcount;
                                                                }
                                                            }


                                                            // if payment status is 2, there sre still some pending payments to make, if 1, payments are cleared off

                                                            if ($newAmount > 0) {
                                                                $payment_status = 2;
                                                            } elseif ($newAmount == 0) {
                                                                $payment_status = 1;
                                                            } else {
                                                                $payment_status = 0;
                                                            }


                                                            ImportExcel::where('invoice_no', $req->invoice_no)->update(['installcount' => $installcounter, 'payment_status' => $payment_status, 'remaining_balance' => $newAmount]);

                                                            // Update Price Record
                                                            $updtPrice = InvoicePayment::where('transactionid', $transactionID)->update(['remaining_balance' => $newAmount, 'opening_balance' => $prevAmount, 'payment_method' => $req->payment_method]);

                                                            if (isset($updtPrice)) {

                                                                $client = ClientInfo::where('user_id', $req->merchant_id)->get();

                                                                // Insert PAYCAWithdraw
                                                                PaycaWithdraw::insert(['withdraw_id' => $transactionID, 'client_id' => $req->merchant_id, 'client_name' => $req->name, 'card_method' => $req->payment_method, 'client_email' => $req->email, 'amount_to_withdraw' => $req->amount, 'remittance' => 0]);


                                                                $activity = "Payment of " . $thisuser->currencyCode . ' ' . $req->amount . " for " . $purpose . " from " . $req->payment_method;
                                                                $credit = 0;
                                                                $debit = $req->amount;
                                                                $balance = $newAmount;
                                                                $status = "Delivered";
                                                                $action = "Wallet debit";
                                                                $regards = $req->merchant_id;
                                                                $reference_code = $transactionID;
                                                                $trans_date = date('Y-m-d');
                                                                $statement_route = "wallet";


                                                                // My Statement
                                                                $this->insStatement($thisuser->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 0, $statement_route, $thisuser->country, 0);


                                                                $remainingBalance = ($thisuser->wallet_balance - $minBal);

                                                                // Get My Wallet Balance
                                                                $walletBalance = $remainingBalance - $req->amount;

                                                                User::where('api_token', $req->bearerToken())->update(['wallet_balance' => $walletBalance]);


                                                                // Update Merchant Wallet Balance
                                                                $merchantwalletBalance = $thismerchant->wallet_balance + $req->amount;

                                                                User::where(
                                                                    'ref_code',
                                                                    $req->merchant_id
                                                                )->update(['wallet_balance' => $merchantwalletBalance]);

                                                                $this->name = $thisuser->name;
                                                                $this->email = $thisuser->email;
                                                                // $this->email = "bambo@vimfile.com";
                                                                $this->subject = "Your Invoice # [" . $req->invoice_no . "] of " . $req->currencyCode . ' ' . number_format($req->amount, 2) . ' from ' . $thismerchant->businessname . ' ' . number_format($req->amount, 2) . " is Paid";

                                                                $this->message = '<p>Hi ' . $thisuser->name . ' You have successfully paid invoice of <strong>' . $req->currencyCode . ' ' . number_format($req->amount, 2) . '</strong> to ' . $thismerchant->name . ' for ' . $purpose . '. You have <strong>' . $req->currencyCode . ' ' . number_format($walletBalance, 2) . '</strong> in PaySprint Wallet account.</p><p>Thanks PaySprint Team.</p>';

                                                                $this->sendEmail($this->email, "Fund remittance");

                                                                $sendMsg = 'Hi ' . $thisuser->name . ' You have successfully paid invoice of ' . $req->currencyCode . ' ' . number_format($req->amount, 2) . ' to ' . $thismerchant->name . ' for ' . $purpose . '. You have ' . $req->currencyCode . ' ' . number_format($walletBalance, 2) . ' in PaySprint Wallet account. Thanks PaySprint Team.';

                                                                $userPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

                                                                if (isset($userPhone)) {

                                                                    $sendPhone = $thisuser->telephone;
                                                                } else {
                                                                    $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
                                                                }

                                                                if ($thisuser->country == "Nigeria") {

                                                                    $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                                                                    $this->sendSms($sendMsg, $correctPhone);
                                                                } else {
                                                                    $this->sendMessage($sendMsg, $sendPhone);
                                                                }



                                                                /*---------------------------------------------------------------------------------------------------------------------*/

                                                                // Merchant Statement

                                                                $activity = "Added " . $req->currencyCode . '' . number_format($req->amount, 2) . " to Wallet";
                                                                $credit = $req->amount;
                                                                $debit = 0;
                                                                $reference_code = $transactionID;
                                                                $balance = 0;
                                                                $trans_date = date('Y-m-d');
                                                                $status = "Delivered";
                                                                $action = "Wallet credit";
                                                                $regards = $thismerchant->ref_code;
                                                                $statement_route = "wallet";

                                                                // Senders statement
                                                                $this->insStatement($thismerchant->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, $thismerchant->country, 0);


                                                                $this->name = $thismerchant->name;
                                                                $this->email = $thismerchant->email;
                                                                // $this->email = "bambo@vimfile.com";
                                                                $this->subject = $thisuser->name . " has paid Invoice: [" . $req->invoice_no . "]";

                                                                $this->message = '<p>You have received <strong>' . $req->currencyCode . '' . number_format($req->amount, 2) . '</strong> for <b>INVOICE # [' . $req->invoice_no . ']</b> paid by <b>' . $thisuser->name . '</b>.</p> <p>You have <strong>' . $req->currencyCode . '' . number_format($merchantwalletBalance, 2) . '</strong> in your wallet account with PaySprint</p><p>Thanks PaySprint Team.</p>';

                                                                $this->sendEmail($this->email, "Fund remittance");

                                                                $recMesg = 'You have received ' . $req->currencyCode . ' ' . number_format($req->amount, 2) . ' for INVOICE # [' . $req->invoice_no . '] paid by ' . $thisuser->name . '. You have ' . $req->currencyCode . ' ' . number_format($merchantwalletBalance, 2) . ' in your wallet account with PaySprint. Thanks PaySprint Team.';

                                                                $userPhone = User::where('email', $thismerchant->email)->where('telephone', 'LIKE', '%+%')->first();

                                                                if (isset($userPhone)) {

                                                                    $recPhone = $thismerchant->telephone;
                                                                } else {
                                                                    $recPhone = "+" . $thismerchant->code . $thismerchant->telephone;
                                                                }

                                                                if ($thismerchant->country == "Nigeria") {

                                                                    $correctPhone = preg_replace("/[^0-9]/", "", $recPhone);
                                                                    $this->sendSms($recMesg, $correctPhone);
                                                                } else {
                                                                    $this->sendMessage($recMesg, $recPhone);
                                                                }




                                                                $userInfo = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol', 'bvn_account_number', 'bvn_bank', 'bvn_account_name', 'bvn_verification')->where('api_token', $req->bearerToken())->first();


                                                                $data = $userInfo;
                                                                $status = 200;
                                                                $message = 'You have successfully paid invoice of ' . $req->currencyCode . ' ' . number_format($req->amount, 2);

                                                                $this->createNotification($thisuser->ref_code, $sendMsg, $thisuser->playerId, $sendMsg, "Wallet Transaction");
                                                                $this->createNotification($thismerchant->ref_code, $recMesg, $thismerchant->playerId, $recMesg, "Wallet Transaction");
                                                            } else {

                                                                $response = 'Something went wrong';

                                                                $data = [];
                                                                $status = 400;
                                                                $message = $response;
                                                            }
                                                        }
                                                    } else {

                                                        $response = 'Invoice not found';
                                                        $data = [];
                                                        $status = 400;
                                                        $message = $response;
                                                    }
                                                } else {
                                                    $response = 'Information not documented, contact Admin';

                                                    $data = [];
                                                    $status = 400;
                                                    $message = $response;
                                                }
                                            }
                                        }
                                    }
                                }
                            } else {
                                $response = 'Invalid transaction pin!';

                                $data = [];
                                $status = 400;
                                $message = $response;
                            }
                        } else {
                            $response = 'Please provide transaction pin or login on the web www.paysprint.ca to pay invoice';

                            $data = [];
                            $status = 400;
                            $message = $response;
                        }
                    } catch (\Throwable $th) {
                        $data = [];
                        $status = 400;
                        $message = "Error: " . $th->getMessage() . ". Kindly ask your merchant to update the invoice.";
                    }
                } else {

                    $error = implode(",", $validator->messages()->all());

                    $data = [];
                    $status = 400;
                    $message = $error;
                }
            }




            $resData = ['data' => $data, 'message' => $message, 'status' => $status, 'route' => $routing];
        }



        return $this->returnJSON($resData, $status);
    }


    // Pay Cross Border from Wallet
    public function crossBorder(Request $req)
    {

        $routing = null;

        if ($req->amount < 0) {
            $response = 'Please enter a positive amount to send';

            $data = [];
            $status = 400;
            $message = $response;
        } else {
            if (isset($req->mode) && $req->mode == "test") {

                // dd($req->all());

                $validator = Validator::make($req->all(), [
                    'invoice_no' => 'required|string',
                    'amount' => 'required|string',
                    'merchant_id' => 'required|string',
                    'service' => 'required|string',
                    'payment_method' => 'required|string',
                    'currencyCode' => 'required|string',
                    'amountinvoiced' => 'required|string',
                    'payInstallment' => 'required|string',
                    'transaction_pin' => 'required|string',
                ]);

                if ($validator->passes()) {

                    try {
                        $transactionID = "invoice-" . date('dmY') . time();

                        $thisuser = User::where('api_token', $req->bearerToken())->first();

                        $thismerchant = User::where('ref_code', $req->merchant_id)->first();

                        $imtCountry = AllCountries::where('name', $thismerchant->country)->first();

                        if ($thisuser->approval < 1 && $thisuser->accountLevel < 1) {

                            $response = 'You cannot pay invoice at the moment because your account is still on review.';

                            $data = [];
                            $status = 400;
                            $message = $response;
                        }

                        // elseif ($thisuser->country != $thismerchant->country && !isset($req->merchantpay)) {
                        //     $response = 'Please visit the website on www.paysprint.ca to pay your international invoice';

                        //     $data = [];
                        //     $status = 400;
                        //     $message = $response;
                        // }

                        // elseif (isset($imtCountry) && $imtCountry->imt == "false") {
                        //     $response = 'International money transfer is not yet available to ' . $imtCountry->name;

                        //     $data = [];
                        //     $status = 400;
                        //     $message = $response;
                        // }

                        else {
                            // Get My Wallet Balance
                            $walletBalance = $thisuser->wallet_balance - $req->amount;

                            // User::where('api_token', $req->bearerToken())->update(['wallet_balance' => $walletBalance]);

                            // Update Merchant Wallet

                            if ($thisuser->country != $thismerchant->country) {
                                $paidinvoiceamount = $req->merchantpay;
                            } else {
                                $paidinvoiceamount = $req->amount;
                            }


                            // Update Merchant Wallet Balance
                            $merchantwalletBalance = $thismerchant->wallet_balance + $paidinvoiceamount;

                            // User::where('ref_code', $req->merchant_id)->update(['wallet_balance' => $merchantwalletBalance]);

                            // Get Invoice Service

                            // $invData = ImportExcel::where('invoice_no', $req->invoice_no)->first();

                            $purpose = $req->service;


                            $insPay = 1;


                            if ($insPay == 1) {
                                // Update Import Excel Record
                                $getInv = ImportExcel::where('invoice_no', $req->invoice_no)->get();

                                if (count($getInv) > 0) {

                                    // Check if instalmental or not

                                    if ($getInv[0]->installpay == "No" && $req->payInstallment == "Yes") {

                                        $response = 'Installmental payment is not allowed for this invoice';

                                        $data = [];
                                        $status = 400;
                                        $message = $response;
                                    } else {

                                        if ($req->payInstallment == "Yes") {

                                            if ($getInv[0]->remaining_balance > 0 || $getInv[0]->remaining_balance != null) {
                                                // Get Amount
                                                $prevAmount = $getInv[0]->remaining_balance;
                                            } else {
                                                $prevAmount = $getInv[0]->amount;
                                            }

                                            $paidAmount = $req->amount;

                                            $newAmount = $prevAmount - $paidAmount;

                                            $instcount = $getInv[0]->installcount + 1;

                                            if ($getInv[0]->installlimit > $instcount) {
                                                $installcounter = $getInv[0]->installlimit;
                                            } else {
                                                $installcounter = $instcount;
                                            }
                                        } else {

                                            if ($getInv[0]->remaining_balance > 0 || $getInv[0]->remaining_balance != null) {
                                                // Get Amount
                                                $prevAmount = $getInv[0]->remaining_balance;
                                            } else {
                                                $prevAmount = $getInv[0]->amount;
                                            }

                                            $paidAmount = $req->amount;

                                            $newAmount = $prevAmount - $paidAmount;

                                            $instcount = $getInv[0]->installcount;

                                            if ($getInv[0]->installlimit > $instcount) {
                                                $installcounter = $getInv[0]->installlimit;
                                            } else {
                                                $installcounter = $instcount;
                                            }
                                        }


                                        // if payment status is 2, there sre still some pending payments to make, if 1, payments are cleared off

                                        if ($newAmount > 0) {
                                            $payment_status = 2;
                                        } elseif ($newAmount == 0) {
                                            $payment_status = 1;
                                        } else {
                                            $payment_status = 0;
                                        }


                                        // ImportExcel::where('invoice_no', $req->invoice_no)->update(['installcount' => $installcounter, 'payment_status' => $payment_status, 'remaining_balance' => $newAmount]);

                                        // Update Price Record
                                        $updtPrice = 1;

                                        if ($updtPrice == 1) {

                                            $client = ClientInfo::where('user_id', $req->merchant_id)->get();

                                            // Insert PAYCAWithdraw
                                            // PaycaWithdraw::insert(['withdraw_id' => $transactionID, 'client_id' => $req->merchant_id, 'client_name' => $req->name, 'card_method' => $req->payment_method, 'client_email' => $req->email, 'amount_to_withdraw' => $req->amount, 'remittance' => 0]);


                                            $activity = "Payment for " . $purpose . " from " . $req->payment_method;
                                            $credit = 0;
                                            $debit = $req->amount;
                                            $balance = $newAmount;
                                            $status = "Delivered";
                                            $action = "Wallet debit";
                                            $regards = $req->merchant_id;
                                            $reference_code = $transactionID;
                                            $trans_date = date('Y-m-d');
                                            $statement_route = "wallet";


                                            // My Statement
                                            // $this->insStatement($thisuser->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 0, $statement_route, $thisuser->country, 0);

                                            $this->name = $thisuser->name;
                                            $this->email = $thisuser->email;
                                            // $this->email = "bambo@vimfile.com";
                                            $this->subject = "Your Invoice # [" . $req->invoice_no . "] of " . $req->currencyCode . ' ' . number_format($req->amount, 2) . ' from ' . $thismerchant->businessname . ' ' . number_format($req->amount, 2) . " is Paid";

                                            $this->message = '<p>Hi ' . $thisuser->name . ' You have successfully paid invoice of <strong>' . $req->currencyCode . ' ' . number_format($req->amount, 2) . '</strong> to ' . $thismerchant->name . ' for ' . $purpose . '. Your balance on Invoice # [' . $req->invoice_no . '] is <strong>' . $req->currencyCode . ' ' . number_format($newAmount, 2) . '</strong>. You have <strong>' . $req->currencyCode . ' ' . number_format($walletBalance, 2) . '</strong> in PaySprint Wallet account.</p><p>Thanks PaySprint Team.</p>';

                                            $this->sendEmail($this->email, "Fund remittance");

                                            $sendMsg = 'Hi ' . $thisuser->name . ' You have successfully paid invoice of ' . $req->currencyCode . ' ' . number_format($req->amount, 2) . ' to ' . $thismerchant->name . ' for ' . $purpose . '. Your balance on Invoice # [' . $req->invoice_no . '] is ' . $req->currencyCode . ' ' . number_format($newAmount, 2) . '. You have ' . $req->currencyCode . ' ' . number_format($walletBalance, 2) . ' in PaySprint Wallet account. Thanks PaySprint Team.';

                                            $userPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

                                            if (isset($userPhone)) {

                                                $sendPhone = $thisuser->telephone;
                                            } else {
                                                $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
                                            }

                                            if ($thisuser->country == "Nigeria") {

                                                $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                                                $this->sendSms($sendMsg, $correctPhone);
                                            } else {
                                                $this->sendMessage($sendMsg, $sendPhone);
                                            }




                                            /*---------------------------------------------------------------------------------------------------------------------*/

                                            // Merchant Statement

                                            $activity = "Added " . $thismerchant->currencyCode . '' . number_format($req->amount, 2) . " to Wallet";
                                            $credit = $req->amount;
                                            $debit = 0;
                                            $reference_code = $transactionID;
                                            $balance = 0;
                                            $trans_date = date('Y-m-d');
                                            $status = "Delivered";
                                            $action = "Wallet credit";
                                            $regards = $thismerchant->ref_code;
                                            $statement_route = "wallet";

                                            // Senders statement
                                            // $this->insStatement($thismerchant->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, $thismerchant->country, 0);


                                            $this->name = $thismerchant->name;
                                            $this->email = $thismerchant->email;
                                            // $this->email = "bambo@vimfile.com";
                                            $this->subject = $thisuser->name . " has paid Invoice: [" . $req->invoice_no . "]";

                                            $this->message = '<p>You have received <strong>' . $req->currencyCode . '' . number_format($req->amount, 2) . '</strong> for <b>INVOICE # [' . $req->invoice_no . ']</b> paid by <b>' . $thisuser->name . '</b>, invoice balance left is ' . $req->currencyCode . ' ' . number_format($newAmount, 2) . '.</p> <p>You have <strong>' . $req->currencyCode . '' . number_format($merchantwalletBalance, 2) . '</strong> in your wallet account with PaySprint</p><p>Thanks PaySprint Team.</p>';

                                            $this->sendEmail($this->email, "Fund remittance");

                                            $recMesg = 'You have received ' . $req->currencyCode . ' ' . number_format($req->amount, 2) . ' for INVOICE # [' . $req->invoice_no . '] paid by ' . $thisuser->name . ', invoice balance left is ' . $req->currencyCode . ' ' . number_format($newAmount, 2) . '. You have ' . $req->currencyCode . ' ' . number_format($merchantwalletBalance, 2) . ' in your wallet account with PaySprint. Thanks PaySprint Team.';

                                            $userPhone = User::where('email', $thismerchant->email)->where('telephone', 'LIKE', '%+%')->first();

                                            if (isset($userPhone)) {

                                                $recPhone = $thismerchant->telephone;
                                            } else {
                                                $recPhone = "+" . $thismerchant->code . $thismerchant->telephone;
                                            }

                                            if ($thismerchant->country == "Nigeria") {

                                                $correctPhone = preg_replace("/[^0-9]/", "", $recPhone);
                                                $this->sendSms($recMesg, $correctPhone);
                                            } else {
                                                $this->sendMessage($recMesg, $recPhone);
                                            }



                                            $userInfo = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol', 'bvn_account_number', 'bvn_bank', 'bvn_account_name', 'bvn_verification')->where('api_token', $req->bearerToken())->first();


                                            $data = $userInfo;
                                            $status = 200;
                                            $message = 'You have successfully paid invoice of ' . $req->currencyCode . ' ' . number_format($req->amount, 2);

                                            // $this->createNotification($thisuser->ref_code, $sendMsg);
                                            // $this->createNotification($thismerchant->ref_code, $recMesg);
                                        } else {

                                            $response = 'Something went wrong';

                                            $data = [];
                                            $status = 400;
                                            $message = $response;
                                        }
                                    }
                                } else {

                                    $response = 'Invoice not found';
                                    $data = [];
                                    $status = 400;
                                    $message = $response;
                                }
                            } else {
                                $response = 'Information not documented, contact Admin';

                                $data = [];
                                $status = 400;
                                $message = $response;
                            }
                        }
                    } catch (\Throwable $th) {
                        $data = [];
                        $status = 400;
                        $message = "Error: " . $th;
                    }
                } else {

                    $error = implode(",", $validator->messages()->all());

                    $data = [];
                    $status = 400;
                    $message = $error;
                }
            } else {

                // dd($req->all());'



                $validator = Validator::make($req->all(), [
                    'receivers_name' => 'required|string',
                    'amount' => 'required|string',
                    'country' => 'required|string',
                    'select_wallet' => 'required|string',
                    'file' => 'required|mimes:jpg,jpeg,png,pdf,xls,xlsx,XLS, XLSX,PDF,PNG,JPEG,JPG',
                    'transaction_pin' => 'required|string',
                    'purpose' => 'required|string',
                ]);


                if ($validator->passes()) {



                    try {

                        $transactionID = 'CB_' . date('Ymdhis');

                        $thisuser = User::where('api_token', $req->bearerToken())->first();



                        // Check Transaction PIn
                        if ($thisuser->transaction_pin != null) {
                            // Validate Transaction PIN
                            if (Hash::check($req->transaction_pin, $thisuser->transaction_pin)) {





                                if ($thisuser->approval < 1 && $thisuser->accountLevel < 1) {


                                    $response = 'You cannot make cross border transaction at the moment because your account is still on review.';

                                    $data = [];
                                    $status = 400;
                                    $message = $response;
                                } else {

                                    if ($thisuser->accountType == "Individual") {
                                        $subminType = "Consumer Monthly Subscription";
                                    } else {
                                        $subminType = "Merchant Monthly Subscription";
                                    }

                                    $invoice_no = "PS_" . date('Ymd') . time();


                                    $minBal = $this->maintenanceBalanceWithdrawal($subminType, $thisuser->country);
                                    $purpose = $req->purpose;



                                    $path = "";

                                    if ($req->hasFile('file')) {

                                        //Get filename with extension
                                        $filenameWithExt = $req->file('file')->getClientOriginalName();
                                        // Get just filename
                                        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                                        // Get just extension
                                        $extension = $req->file('file')->getClientOriginalExtension();

                                        // Filename to store
                                        $fileNameToStore = rand() . '_' . time() . '.' . $extension;

                                        //Upload Image
                                        // $path = $req->file('file')->storeAs('public/crossborderinvoices', $fileNameToStore);

                                        // $path = $req->file('file')->move(public_path('/crossborderinvoices/'), $fileNameToStore);

                                        $req->file('file')->move(public_path('../../crossborderinvoices/'), $fileNameToStore);


                                        $path = route('home') . '/crossborderinvoices/' . $fileNameToStore;
                                    }


                                    // Get beneficiary details or create new beneficiary

                                    $getCurrencyCode = AllCountries::where('name', $req->country)->first();

                                    if ($req->beneficiary_id == "create_new") {

                                        // Create Beneficiary
                                        $beneficiary = CrossBorderBeneficiary::create([
                                            'account_name' => $req->account_name,
                                            'account_number' => $req->account_number,
                                            'bank_name' => $req->bank_name,
                                            'sort_code' => $req->sort_code,
                                            'beneficiary_address' => $req->beneficiary_address,
                                            'beneficiary_city' => $req->beneficiary_city,
                                            'currencyCode' => $getCurrencyCode->currencyCode
                                        ]);
                                    } else {
                                        $beneficiary = CrossBorderBeneficiary::where('id', $req->beneficiary_id)->first();
                                    }




                                    // Check Wallet Balance if up to amount



                                    if (isset($req->select_wallet) && $req->select_wallet == "FX Wallet" || isset($req->select_wallet) && $req->select_wallet == "Fx Wallet") {

                                        $routing = 'fx';

                                        $wallet = EscrowAccount::where('escrow_id', $req->escrow_id)->first();


                                        if ($req->amount > $wallet->wallet_balance) {
                                            // Insufficient amount for withdrawal

                                            $data = [];
                                            $message = "Insufficient wallet balance";
                                            $status = 400;

                                            // Log::info('Oops!, Though this is a test, but '.$thisuser->name.' has '.$message);

                                            $this->slack(
                                                'Oops!, ' . $thisuser->name . ' has ' . $message,
                                                $room = "success-logs",
                                                $icon = ":longbox:",
                                                env('LOG_SLACK_SUCCESS_URL')
                                            );
                                        } else {





                                            $insPay = InvoicePayment::updateOrCreate(['invoice_no' => $invoice_no], ['transactionid' => $transactionID, 'name' => $thisuser->name, 'email' => $thisuser->email, 'amount' => $req->amount, 'invoice_no' => $invoice_no, 'service' => $purpose, 'client_id' => $thisuser->ref_code, 'payment_method' => $req->select_wallet]);


                                            ImportExcel::where('invoice_no', $invoice_no)->update(['installcount' => 0, 'payment_status' => 1, 'remaining_balance' => 0]);

                                            // Update Price Record
                                            $updtPrice = InvoicePayment::where('transactionid', $transactionID)->update(['remaining_balance' => 0, 'opening_balance' => 0, 'payment_method' => $req->select_wallet]);

                                            if (isset($updtPrice)) {

                                                // Insert PAYCAWithdraw
                                                PaycaWithdraw::insert(['withdraw_id' => $transactionID, 'client_id' => $thisuser->ref_code, 'client_name' => $thisuser->name, 'card_method' => $req->select_wallet, 'client_email' => $thisuser->email, 'amount_to_withdraw' => $req->amount, 'remittance' => 0]);


                                                $activity = "Payment of " . $wallet->currencyCode . ' ' . $req->amount . " for " . $purpose . " debited from FX Wallet";
                                                $credit = 0;
                                                $debit = $req->amount;
                                                $balance = 0;
                                                $status = "Delivered";
                                                $action = "Escrow Wallet debit";
                                                $regards = $thisuser->ref_code;
                                                $reference_code = $transactionID;
                                                $trans_date = date('Y-m-d');
                                                $statement_route = "escrow wallet";


                                                // Insert Cross Border Record
                                                CrossBorder::insert([
                                                    'transaction_id' => $transactionID,
                                                    'receivers_name' => $req->receivers_name,
                                                    'senders_name' => $thisuser->name,
                                                    'ref_code' => $thisuser->ref_code,
                                                    'purpose' => $purpose,
                                                    'amount' => $req->amount,
                                                    'country' => $req->country,
                                                    'select_wallet' => $req->select_wallet,
                                                    'file' => $path,
                                                    'currencySymbol' => $wallet->currencySymbol,
                                                    'beneficiary_id' => $beneficiary->id
                                                ]);


                                                // My FX Statement

                                                $this->insFXStatement($wallet->escrow_id, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, 'on', $thisuser->country, 'confirmed');


                                                // Senders statement
                                                $this->insStatement($thisuser->email, $reference_code, $activity, $debit, $credit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, $thisuser->country, 0);



                                                $remainingBalance = $wallet->wallet_balance;

                                                // Get My Wallet Balance
                                                $walletBalance = $remainingBalance - $req->amount;

                                                EscrowAccount::where('user_id', $thisuser->id)->where('escrow_id', $wallet->escrow_id)->update(['wallet_balance' => $walletBalance]);


                                                $this->name = $thisuser->name;
                                                $this->email = $thisuser->email;
                                                $this->subject = "Your Invoice # [" . $invoice_no . "] of " . $wallet->currencyCode . ' ' . number_format($req->amount, 2) . ' for ' . $purpose .  " is Paid";

                                                $this->message = '<p>Hi ' . $thisuser->name . ' You have successfully paid invoice of <strong>' . $wallet->currencyCode . ' ' . number_format($req->amount, 2) . '</strong> for ' . $purpose . '. The Direct deposit into receivers Bank account would be done within the next 72 hours. You have <strong>' . $wallet->currencyCode . ' ' . number_format($walletBalance, 2) . '</strong> in PaySprint FX Wallet account.</p><p>Thanks PaySprint Team.</p>';

                                                $this->sendEmail($this->email, "Fund remittance");

                                                $sendMsg = 'Hi ' . $thisuser->name . ' You have successfully paid invoice of ' . $wallet->currencyCode . ' ' . number_format($req->amount, 2) . ' for ' . $purpose . '. The Direct deposit into receivers Bank account would be done within the next 72 hours. You have ' . $wallet->currencyCode . ' ' . number_format($walletBalance, 2) . ' in PaySprint FX Wallet account. Thanks PaySprint Team.';

                                                $userPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

                                                if (isset($userPhone)) {

                                                    $sendPhone = $thisuser->telephone;
                                                } else {
                                                    $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
                                                }

                                                if ($thisuser->country == "Nigeria") {

                                                    $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                                                    $this->sendSms($sendMsg, $correctPhone);
                                                } else {
                                                    $this->sendMessage($sendMsg, $sendPhone);
                                                }




                                                $userInfo = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol', 'bvn_account_number', 'bvn_bank', 'bvn_account_name', 'bvn_verification')->where('api_token', $req->bearerToken())->first();


                                                $data = $userInfo;
                                                $status = 200;
                                                $message = 'You have successfully paid invoice of ' . $wallet->currencyCode . ' ' . number_format($req->amount, 2) . " | The Direct deposit into receivers Bank account would be done within the next 72 hours. Thanks";

                                                $this->createNotification($thisuser->ref_code, $sendMsg, $thisuser->playerId, $sendMsg, "Wallet Transaction");
                                            } else {

                                                $response = 'Something went wrong';

                                                $data = [];
                                                $status = 400;
                                                $message = $response;
                                            }
                                        }
                                    } else {



                                        if ($req->amount > ($thisuser->wallet_balance - $minBal)) {
                                            // Insufficient amount for withdrawal


                                            $this->slack(
                                                'Oops!, ' . $thisuser->wallet_balance . ' has ' . $minBal,
                                                $room = "success-logs",
                                                $icon = ":longbox:",
                                                env('LOG_SLACK_SUCCESS_URL')
                                            );

                                            $data = [];
                                            $message = "Insufficient wallet balance";
                                            $status = 400;

                                            // Log::info('Oops!, Though this is a test, but '.$thisuser->name.' has '.$message);

                                            $this->slack(
                                                'Oops!, ' . $thisuser->name . ' has ' . $message,
                                                $room = "success-logs",
                                                $icon = ":longbox:",
                                                env('LOG_SLACK_SUCCESS_URL')
                                            );
                                        } else {

                                            // Get Invoice Service

                                            // $invData = ImportExcel::where('invoice_no', $req->invoice_no)->first();

                                            $purpose = $req->purpose;

                                            if ($thisuser->country == $req->country) {

                                                $insPay = InvoicePayment::updateOrCreate(['invoice_no' => $invoice_no], ['transactionid' => $transactionID, 'name' => $thisuser->name, 'email' => $thisuser->email, 'amount' => $req->amount, 'invoice_no' => $invoice_no, 'service' => $purpose, 'client_id' => $thisuser->ref_code, 'payment_method' => $req->select_wallet]);


                                                ImportExcel::where('invoice_no', $invoice_no)->update(['installcount' => 0, 'payment_status' => 1, 'remaining_balance' => 0]);

                                                // Update Price Record
                                                $updtPrice = InvoicePayment::where('transactionid', $transactionID)->update(['remaining_balance' => 0, 'opening_balance' => 0, 'payment_method' => $req->select_wallet]);

                                                if (isset($updtPrice)) {

                                                    // Insert PAYCAWithdraw
                                                    PaycaWithdraw::insert(['withdraw_id' => $transactionID, 'client_id' => $thisuser->ref_code, 'client_name' => $thisuser->name, 'card_method' => $req->select_wallet, 'client_email' => $thisuser->email, 'amount_to_withdraw' => $req->amount, 'remittance' => 0]);


                                                    $activity = "Payment of " . $thisuser->currencyCode . ' ' . $req->amount . " for " . $purpose . " debited from PaySprint Wallet";
                                                    $credit = 0;
                                                    $debit = $req->amount;
                                                    $balance = 0;
                                                    $status = "Delivered";
                                                    $action = "Wallet debit";
                                                    $regards = $thisuser->ref_code;
                                                    $reference_code = $transactionID;
                                                    $trans_date = date('Y-m-d');
                                                    $statement_route = "wallet";


                                                    // Insert Cross Border Record
                                                    CrossBorder::insert([
                                                        'transaction_id' => $transactionID,
                                                        'receivers_name' => $req->receivers_name,
                                                        'senders_name' => $thisuser->name,
                                                        'ref_code' => $thisuser->ref_code,
                                                        'purpose' => $purpose,
                                                        'amount' => $req->amount,
                                                        'country' => $req->country,
                                                        'select_wallet' => $req->select_wallet,
                                                        'file' => $path,
                                                        'currencySymbol' => $thisuser->currencySymbol,
                                                        'beneficiary_id' => $beneficiary->id
                                                    ]);


                                                    // My Statement
                                                    $this->insStatement($thisuser->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 0, $statement_route, $thisuser->country, 0);


                                                    $remainingBalance = $thisuser->wallet_balance;

                                                    // Get My Wallet Balance
                                                    $walletBalance = $remainingBalance - $req->amount;

                                                    User::where('api_token', $req->bearerToken())->update(['wallet_balance' => $walletBalance]);


                                                    $this->name = $thisuser->name;
                                                    $this->email = $thisuser->email;
                                                    $this->subject = "Your Invoice # [" . $invoice_no . "] of " . $thisuser->currencyCode . ' ' . number_format($req->amount, 2) . ' for ' . $purpose .  " is Paid";

                                                    $this->message = '<p>Hi ' . $thisuser->name . ' You have successfully paid invoice of <strong>' . $thisuser->currencyCode . ' ' . number_format($req->amount, 2) . '</strong> for ' . $purpose . '. The Direct deposit into receivers Bank account would be done within the next 72 hours. You have <strong>' . $thisuser->currencyCode . ' ' . number_format($walletBalance, 2) . '</strong> in PaySprint Wallet account.</p><p>Thanks PaySprint Team.</p>';

                                                    $this->sendEmail($this->email, "Fund remittance");

                                                    $sendMsg = 'Hi ' . $thisuser->name . ' You have successfully paid invoice of ' . $thisuser->currencyCode . ' ' . number_format($req->amount, 2) . ' for ' . $purpose . '. The Direct deposit into receivers Bank account would be done within the next 72 hours. You have ' . $thisuser->currencyCode . ' ' . number_format($walletBalance, 2) . ' in PaySprint Wallet account. Thanks PaySprint Team.';

                                                    $userPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

                                                    if (isset($userPhone)) {

                                                        $sendPhone = $thisuser->telephone;
                                                    } else {
                                                        $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
                                                    }

                                                    if ($thisuser->country == "Nigeria") {

                                                        $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                                                        $this->sendSms($sendMsg, $correctPhone);
                                                    } else {
                                                        $this->sendMessage(
                                                            $sendMsg,
                                                            $sendPhone
                                                        );
                                                    }




                                                    $userInfo = User::select(
                                                        'id',
                                                        'code as countryCode',
                                                        'ref_code as refCode',
                                                        'name',
                                                        'email',
                                                        'password',
                                                        'address',
                                                        'telephone',
                                                        'city',
                                                        'state',
                                                        'country',
                                                        'zip as zipCode',
                                                        'avatar',
                                                        'api_token as apiToken',
                                                        'approval',
                                                        'accountType',
                                                        'wallet_balance as walletBalance',
                                                        'number_of_withdrawals as numberOfWithdrawal',
                                                        'transaction_pin as transactionPin',
                                                        'currencyCode',
                                                        'currencySymbol',
                                                        'bvn_account_number',
                                                        'bvn_bank',
                                                        'bvn_account_name',
                                                        'bvn_verification'
                                                    )->where('api_token', $req->bearerToken())->first();


                                                    $data = $userInfo;
                                                    $status = 200;
                                                    $message = 'You have successfully paid invoice of ' . $thisuser->currencyCode . ' ' . number_format($req->amount, 2) . " | The Direct deposit into receivers Bank account would be done within the next 72 hours. Thanks";

                                                    $this->createNotification($thisuser->ref_code, $sendMsg, $thisuser->playerId, $sendMsg, "Wallet Transaction");
                                                } else {

                                                    $response = 'Something went wrong';

                                                    $data = [];
                                                    $status = 400;
                                                    $message = $response;
                                                }
                                            } else {
                                                $data = [];
                                                $status = 400;
                                                $message = "Kindly use your FX wallet to proceed with this transaction";
                                            }
                                        }
                                    }
                                }
                            } else {
                                $data = [];
                                $status = 400;
                                $message = "Invalid transaction pin";
                            }
                        } else {
                            $data = [];
                            $status = 400;
                            $message = "Please create a transaction pin";
                        }
                    } catch (\Throwable $th) {
                        $data = [];
                        $status = 400;
                        $message = "Error: " . $th->getMessage() . ". Kindly ensure you have provided receivers account details";
                    }
                } else {

                    $error = implode(",", $validator->messages()->all());

                    $data = [];
                    $status = 400;
                    $message = $error;
                }
            }




            $resData = ['data' => $data, 'message' => $message, 'status' => $status, 'route' => $routing];
        }



        return $this->returnJSON($resData, $status);
    }



    // Pay Invoice from Gateway
    public function payInvoiceLink(Request $req)
    {


        // Get Invoice Details from Invoice link
        $getInvoice = ImportExcelLink::where('invoice_no', $req->invoice_no)->first();




        try {

            if (isset($getInvoice)) {
                $merchantId = $getInvoice->uploaded_by;
                $merchantName = $getInvoice->merchantName;
                $thisuser = User::where('ref_code', $merchantId)->where('businessname', $merchantName)->first();

                if ($req->paymentToken != null && $thisuser->country != "Canada") {


                    $amount = $req->amountinvoiced;
                    $merchantpay = $req->merchantpay;






                    // Credit Merchant Wallet and Add Statement
                    // Update Wallet Balance
                    $walletBal = $thisuser->wallet_balance + $merchantpay;
                    User::where('ref_code', $merchantId)->where('businessname', $merchantName)->update(['wallet_balance' => $walletBal]);


                    // Generate Statement

                    $activity = 'You have received ' . $thisuser->currencyCode . ' ' . number_format($merchantpay, 2) . ' for INVOICE # [' . $req->invoice_no . '] paid by ' . $req->name . '. You have ' . $thisuser->currencyCode . ' ' . number_format($walletBal, 2) . ' in your wallet account with PaySprint. Thanks PaySprint Team.';
                    $credit = $merchantpay;
                    $debit = 0;
                    $reference_code = $req->paymentToken;
                    $balance = 0;
                    $trans_date = date('Y-m-d');
                    $status = "Delivered";
                    $action = "Wallet credit";
                    $regards = $thisuser->ref_code;
                    $statement_route = "wallet";

                    // Senders statement
                    $this->insStatement($thisuser->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, $thisuser->country, 0);

                    $this->getfeeTransaction($reference_code, $thisuser->ref_code, $req->amount, $req->commissiondeduct, $req->amountinvoiced);

                    // Notification


                    $this->name = $req->name;
                    $this->email = $req->email;
                    $this->subject = "Invoice payment of " . $req->currencyCode . ' ' . number_format($req->amount, 2) . " sent to " . $thisuser->businessname;

                    $this->message = '<p>Invoice amount of <strong>' . $req->currencyCode . ' ' . number_format($req->amount, 2) . '</strong> has been sent to ' . $thisuser->businessname . '. Your debit card was charged <strong>' . $req->currencyCode . ' ' . number_format($req->amount, 2) . '</strong> successfully.</p><p>Thank you for choosing PaySprint.</p>';



                    $sendMsg = 'Invoice amount of ' . $thisuser->currencyCode . ' ' . number_format($merchantpay, 2) . ' has been sent to your wallet with PaySprint from ' . $req->name . '. You have ' . $thisuser->currencyCode . ' ' . number_format($walletBal, 2) . ' balance in your account';

                    $userPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

                    if (isset($userPhone)) {

                        $sendPhone = $thisuser->telephone;
                    } else {
                        $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
                    }

                    if ($thisuser->country == "Nigeria") {

                        $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                        $this->sendSms($sendMsg, $correctPhone);
                    } else {
                        $this->sendMessage($sendMsg, $sendPhone);
                    }

                    // Update Invoice Link Payment Status
                    ImportExcelLink::where('invoice_no', $req->invoice_no)->update(['payment_status' => 1]);

                    // Insert to Invoice Payment Page
                    $query = [
                        'transactionid' => $req->paymentToken,
                        'name' => $req->name,
                        'email' => $req->email,
                        'amount' => $req->amount,
                        'invoice_no' => $req->invoice_no,
                        'service' => $req->service,
                        'payment_method' => $req->payment_method,
                        'client_id' => time(),
                        'opening_balance' => $req->amount,
                        'remaining_balance' => 0,
                        'withdraws' => 0,
                        'mystatus' => "payment",
                    ];
                    InvoicePayment::insert($query);

                    $merchantData = User::where('ref_code', $merchantId)->where('businessname', $merchantName)->first();

                    // Send Mail to Sender



                    $this->sendEmail($req->email, "Fund remittance");

                    $data = $merchantData;
                    $message = "Payment Successfully received";
                    $status = 200;
                } else {
                    // Process payment for moneris gateway

                    $creditcard_no = $req->creditcard_no;


                    $month = $req->month;
                    $expirydate = $req->expirydate;
                    $amount = $req->amountinvoiced;
                    $merchantpay = $req->merchantpay;



                    $response = $this->paywithmonerisWalletProcessLink($merchantId, $creditcard_no, $month, $expirydate, $amount, "purchase", "PaySprint/Vimfile Pay Invoice to " . $getInvoice->merchantName);



                    if ($response->responseData['ResponseCode'] == "000" || $response->responseData['ResponseCode'] == "001" || $response->responseData['ResponseCode'] == "002" || $response->responseData['ResponseCode'] == "003" || $response->responseData['ResponseCode'] == "004" || $response->responseData['ResponseCode'] == "005" || $response->responseData['ResponseCode'] == "006" || $response->responseData['ResponseCode'] == "007" || $response->responseData['ResponseCode'] == "008" || $response->responseData['ResponseCode'] == "009" || $response->responseData['ResponseCode'] == "010" || $response->responseData['ResponseCode'] == "023" || $response->responseData['ResponseCode'] == "024" || $response->responseData['ResponseCode'] == "025" || $response->responseData['ResponseCode'] == "026" || $response->responseData['ResponseCode'] == "027" || $response->responseData['ResponseCode'] == "028" || $response->responseData['ResponseCode'] == "029") {

                        // Credit Merchants Wallet and Add Statement

                        $thisuser = User::where('ref_code', $merchantId)->where('businessname', $merchantName)->first();


                        // Credit Merchant Wallet and Add Statement
                        // Update Wallet Balance
                        $walletBal = $thisuser->wallet_balance + $merchantpay;
                        User::where('ref_code', $merchantId)->where('businessname', $merchantName)->update(['wallet_balance' => $walletBal]);


                        // Generate Statement

                        $activity = 'You have received ' . $thisuser->currencyCode . ' ' . number_format($merchantpay, 2) . ' for INVOICE # [' . $req->invoice_no . '] paid by ' . $req->name . '. You have ' . $thisuser->currencyCode . ' ' . number_format($walletBal, 2) . ' in your wallet account with PaySprint. Thanks PaySprint Team.';
                        $credit = $merchantpay;
                        $debit = 0;
                        $reference_code = $response->responseData['ReceiptId'];
                        $balance = 0;
                        $trans_date = date('Y-m-d');
                        $status = "Delivered";
                        $action = "Wallet credit";
                        $regards = $thisuser->ref_code;
                        $statement_route = "wallet";

                        // Senders statement
                        $this->insStatement(
                            $thisuser->email,
                            $reference_code,
                            $activity,
                            $credit,
                            $debit,
                            $balance,
                            $trans_date,
                            $status,
                            $action,
                            $regards,
                            1,
                            $statement_route,
                            $thisuser->country,
                            0
                        );

                        $this->getfeeTransaction($reference_code, $thisuser->ref_code, $merchantpay, "0.00", $req->amountinvoiced);

                        // Notification


                        $this->name = $req->name;
                        $this->email = $req->email;
                        $this->subject = "Invoice payment of " . $req->currencyCode . ' ' . number_format($req->amount, 2) . " sent to " . $thisuser->businessname;

                        $this->message = '<p>Invoice amount of <strong>' . $req->currencyCode . ' ' . number_format($req->amount, 2) . '</strong> has been sent to ' . $thisuser->businessname . '. Your debit card was charged <strong>' . $req->currencyCode . ' ' . number_format($req->amount, 2) . '</strong> successfully.</p><p>Thank you for choosing PaySprint.</p>';

                        $sendMsg = 'Invoice amount of ' . $thisuser->currencyCode . ' ' . number_format($merchantpay, 2) . ' has been paid to your wallet with PaySprint. You have ' . $thisuser->currencyCode . ' ' . number_format($walletBal, 2) . ' balance in your account';

                        $userPhone = User::where('email', $thisuser->email)->where(
                            'telephone',
                            'LIKE',
                            '%+%'
                        )->first();

                        if (isset($userPhone)) {

                            $sendPhone = $thisuser->telephone;
                        } else {
                            $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
                        }

                        if ($thisuser->country == "Nigeria") {

                            $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                            $this->sendSms($sendMsg, $correctPhone);
                        } else {
                            $this->sendMessage($sendMsg, $sendPhone);
                        }

                        // Update Invoice Link Payment Status
                        ImportExcelLink::where('invoice_no', $req->invoice_no)->update(['payment_status' => 1]);

                        // Insert to Invoice Payment Page
                        $query = [
                            'transactionid' => $response->responseData['ReceiptId'],
                            'name' => $req->name,
                            'email' => $req->email,
                            'amount' => $merchantpay,
                            'invoice_no' => $req->invoice_no,
                            'service' => $req->service,
                            'payment_method' => $req->payment_method,
                            'client_id' => time(),
                            'opening_balance' => $merchantpay,
                            'remaining_balance' => 0,
                            'withdraws' => 0,
                            'mystatus' => "payment",
                        ];
                        InvoicePayment::insert($query);

                        $merchantData = User::where('ref_code', $merchantId)->where('businessname', $merchantName)->first();

                        // Send Mail to Sender



                        $this->sendEmail($req->email, "Fund remittance");

                        $data = $merchantData;
                        $message = "Payment Successfully received";
                        $status = 200;
                    } else {
                        $data = [];
                        $message = $response->responseData['Message'];
                        $status = 400;
                    }
                }
            } else {
                $data = [];
                $message = "Invoice data not found. Please contact your vendor";
                $status = 400;
            }
        } catch (\Throwable $th) {

            $data = [];
            $message = $th->getMessage();
            $status = 400;
        }


        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

        return $this->returnJSON(
            $resData,
            $status
        );
    }



    // Pay Invoice from EPS Gateway
    public function epspayInvoiceLink(Request $req)
    {


        // Get Invoice Details from Invoice link
        $getInvoice = ImportExcelLink::where('invoice_no', $req->invoice_no)->first();




        try {

            if (isset($getInvoice)) {
                $merchantId = $getInvoice->uploaded_by;
                $merchantName = $getInvoice->merchantName;
                $thisuser = User::where('ref_code', $merchantId)->where('businessname', $merchantName)->first();

                $amount = $req->amountinvoiced;
                $merchantpay = $req->merchantpay;

                // Credit Merchant Wallet and Add Statement
                // Update Wallet Balance
                $walletBal = $thisuser->wallet_balance + $merchantpay;
                User::where('ref_code', $merchantId)->where('businessname', $merchantName)->update(['wallet_balance' => $walletBal]);


                // Generate Statement

                $activity = 'You have received ' . $thisuser->currencyCode . ' ' . number_format($merchantpay, 2) . ' for INVOICE # [' . $req->invoice_no . '] paid by ' . $req->name . '. You have ' . $thisuser->currencyCode . ' ' . number_format($walletBal, 2) . ' in your wallet account with PaySprint. Thanks PaySprint Team.';
                $credit = $merchantpay;
                $debit = 0;
                $reference_code = $req->paymentToken;
                $balance = 0;
                $trans_date = date('Y-m-d');
                $status = "Delivered";
                $action = "Wallet credit";
                $regards = $thisuser->ref_code;
                $statement_route = "wallet";

                // Senders statement
                $this->insStatement($thisuser->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, $thisuser->country, 0);

                $this->getfeeTransaction($reference_code, $thisuser->ref_code, $req->amount, $req->commissiondeduct, $req->amountinvoiced);

                // Notification


                $this->name = $req->name;
                $this->email = $req->email;
                $this->subject = "Invoice payment of " . $req->currencyCode . ' ' . number_format($req->amount, 2) . " sent to " . $thisuser->businessname;

                $this->message = '<p>Invoice amount of <strong>' . $req->currencyCode . ' ' . number_format($req->amount, 2) . '</strong> has been sent to ' . $thisuser->businessname . '. Your debit card was charged <strong>' . $req->currencyCode . ' ' . number_format($req->amount, 2) . '</strong> successfully.</p><p>Thank you for choosing PaySprint.</p>';



                $sendMsg = 'Invoice amount of ' . $thisuser->currencyCode . ' ' . number_format($merchantpay, 2) . ' has been sent to your wallet with PaySprint from ' . $req->name . '. You have ' . $thisuser->currencyCode . ' ' . number_format($walletBal, 2) . ' balance in your account';

                $userPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

                if (isset($userPhone)) {

                    $sendPhone = $thisuser->telephone;
                } else {
                    $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
                }

                if ($thisuser->country == "Nigeria") {

                    $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                    // $this->sendSms($sendMsg, $correctPhone);
                } else {
                    // $this->sendMessage($sendMsg, $sendPhone);
                }

                // Update Invoice Link Payment Status
                ImportExcelLink::where('invoice_no', $req->invoice_no)->update(['payment_status' => 1]);

                // Insert to Invoice Payment Page
                $query = [
                    'transactionid' => $req->paymentToken,
                    'name' => $req->name,
                    'email' => $req->email,
                    'amount' => $req->amount,
                    'invoice_no' => $req->invoice_no,
                    'service' => $req->service,
                    'payment_method' => $req->payment_method,
                    'client_id' => time(),
                    'opening_balance' => $req->amount,
                    'remaining_balance' => 0,
                    'withdraws' => 0,
                    'mystatus' => "payment",
                ];
                InvoicePayment::insert($query);

                $merchantData = User::where('ref_code', $merchantId)->where('businessname', $merchantName)->first();

                // Send Mail to Sender

                $this->sendEmail($req->email, "Fund remittance");

                $message = "Payment Successfully received";
                $action = 'success';
                $data = $merchantData;
                $status = 200;
            } else {
                $message = "Invoice data not found. Please contact your vendor";
                $action = 'error';
                $data = [];
                $status = 400;
            }
        } catch (\Throwable $th) {
            $data = [];
            $status = 400;
            $message = "Payment not received | " . $th->getMessage();
            $action = 'error';
        }

        $resData = ['res' => $data, 'message' => $message, 'status' => $status];

        return redirect()->route('epsresponseback', 'status=' . $action . '&message=' . $message)->with($action, $message);
    }





    public function expressBusinessCallback(Request $req)
    {



        try {

            $response = $this->getVerification($req->paymentToken);


            if ($response->responseCode == "00") {

                // Get merchant info
                $thisuser = User::where('ref_code', $req->ref_code)->first();

                if (isset($thisuser)) {
                    $gateway = "Express Payment Solution";


                    $referenced_code = $req->paymentToken;



                    // Update Wallet Balance
                    $walletBal = $thisuser->wallet_balance;
                    $holdBal = $thisuser->hold_balance + $req->amounttosend;
                    User::where('ref_code', $req->ref_code)->update(['wallet_balance' => $walletBal, 'hold_balance' => $holdBal]);

                    $userData = User::select('id', 'ref_code as refCode', 'name', 'email', 'telephone', 'wallet_balance as walletBalance', 'number_of_withdrawals as noOfWithdrawals')->where('ref_code', $req->ref_code)->first();

                    $activity = "Received " . $req->currencyCode . '' . number_format($req->amounttosend, 2) . " to Wallet";
                    $credit = $req->amounttosend;
                    $debit = 0;
                    $reference_code = $referenced_code;
                    $balance = 0;
                    $trans_date = date('Y-m-d');
                    $status = "Delivered";
                    $action = "Wallet credit";
                    $regards = $thisuser->ref_code;
                    $statement_route = "wallet";

                    // Senders statement
                    $this->insStatement($thisuser->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, $thisuser->country, 0);

                    $this->getfeeTransaction($reference_code, $thisuser->ref_code, $req->amounttosend, $req->commissiondeduct, $req->amounttosend);

                    // Top Up PaySprint FX account with the commission charge...



                    $currencyFX = new MonthlySubController();

                    $currencyFX->feeChargeCredit($thisuser->country, $req->commissiondeduct, $thisuser->businessname, $thisuser->accountType);




                    $this->name = $thisuser->name;
                    $this->email = $thisuser->email;
                    $this->subject = $req->currencyCode . ' ' . number_format($req->amounttosend, 2) . " now received to your wallet with PaySprint";

                    $this->message = '<p><strong>' . $req->currencyCode . ' ' . number_format($req->amounttosend, 2) . '</strong> has been received to your wallet with PaySprint. Kindly allow up to 12-24 hours for the funds to reflect in your wallet. You have <strong>' . $req->currencyCode . ' ' . number_format($walletBal, 2) . '</strong> balance in your account</p>';

                    $sendMsg = $req->currencyCode . ' ' . number_format($req->amounttosend, 2) . ' has been received to your wallet with PaySprint. Kindly allow up to 12-24 hours for the funds to reflect in your wallet. You have ' . $req->currencyCode . ' ' . number_format($walletBal, 2) . ' balance in your account';

                    $userPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

                    if (isset($userPhone)) {

                        $sendPhone = $thisuser->telephone;
                    } else {
                        $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
                    }

                    if ($thisuser->country == "Nigeria") {

                        $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                        $this->sendSms($sendMsg, $correctPhone);
                    } else {
                        $this->sendMessage($sendMsg, $sendPhone);
                    }


                    $userInfo = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol')->where('ref_code', $req->ref_code)->first();

                    $data = $userInfo;
                    $status = 200;
                    $message = 'You have successfully sent ' . $req->currencyCode . ' ' . number_format($req->amount, 2) . ' to ' . $thisuser->businessname;
                    $action = 'success';

                    $this->createNotification($thisuser->ref_code, $sendMsg, $thisuser->playerId, $sendMsg, "Wallet Transaction");

                    $this->keepRecord($referenced_code, $message, "Success", $gateway, $thisuser->country, 1);

                    $this->updatePoints($thisuser->id, 'Add money');

                    // Log::info('Congratulations!, '.$thisuser->name.' '.$sendMsg);

                    $this->slack('Congratulations!, ' . $thisuser->name . ' ' . $sendMsg, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));

                    $this->sendEmail($this->email, "Fund remittance");

                    $adminMessage = "<p>Transaction ID: " . $reference_code . "</p><p>Name: " . $thisuser->name . "</p><p>Account Number: " . $thisuser->ref_code . "</p><p>Country: " . $thisuser->country . "</p><p>Date: " . date('d/m/Y h:i:a') . "</p><p>Amount: " . $req->currencyCode . ' ' . number_format($req->amounttosend, 2) . "</p><p>Commission: " . $req->currencyCode . ' ' . number_format($req->commissiondeduct, 2) . "</p><p>Total: " . $req->currencyCode . ' ' . number_format($req->amount, 2) . "</p><p>Status: Successful</p>";

                    $this->notifyAdmin($gateway . " inflow", $adminMessage);
                } else {
                    $data = false;
                    $message = "Merchant information not found. | Contact support with payment receipt for complaint";
                    $status = 400;
                    $action = 'error';
                }
            } else {

                $data = false;
                $message = $response->responseMessage;
                $status = 400;
                $action = 'error';
            }
        } catch (\Throwable $th) {
            $data = [];
            $message = "Payment not received | " . $th->getMessage();
            $status = 400;
            $action = 'error';
        }


        $resData = ['res' => $data, 'message' => $message, 'status' => $status];


        return redirect()->route('epsresponseback', 'status=' . $action . '&message=' . $message)->with($action, $message);
    }


    public function paymentInShop(Request $req)
    {
        try {

            // Get merchant info
            $thisuser = User::where('ref_code', $req->merchant_id)->first();

            $getMerchantInfo = ClientInfo::where('user_id', $req->merchant_id)->first();

            if ($req->payType === 'ps_user') {

                if ($getMerchantInfo->accountMode === 'live') {

                    // User customers wallet...
                    // Verify Transaction Pin...
                    $customer = User::where('ref_code', $req->accountNumber)->first();

                    if (Hash::check($req->transactionPin, $customer->transaction_pin)) {

                        $referenced_code = "wallet-" . date('dmY') . time();

                       // Update Wallet Balance
                        $walletBal = $thisuser->wallet_balance + $req->amount;
                        $holdBal = $thisuser->hold_balance;

                        User::where('ref_code', $req->merchant_id)->update(['wallet_balance' => $walletBal, 'hold_balance' => $holdBal]);

                        $customerDeduct = $customer->wallet_balance - $req->amount;

                        User::where('ref_code', $req->accountNumber)->update(['wallet_balance' => $customerDeduct]);

                        $userData = User::select('id', 'ref_code as refCode', 'name', 'email', 'telephone', 'wallet_balance as walletBalance', 'number_of_withdrawals as noOfWithdrawals')->where('ref_code', $req->merchant_id)->first();

                        $activity = "Received " . $req->currencyCode . '' . number_format($req->amount, 2) . " to Wallet from ".$customer->name;
                        $credit = $req->amount;
                        $debit = 0;
                        $reference_code = $referenced_code;
                        $balance = 0;
                        $trans_date = date('Y-m-d');
                        $status = "Delivered";
                        $action = "Wallet credit";
                        $regards = $thisuser->ref_code;
                        $statement_route = "wallet";

                        // Senders statement
                        $this->insStatement($thisuser->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, $thisuser->country, 1);

                        $this->getfeeTransaction($reference_code, $thisuser->ref_code, $req->amount, "0.00", $req->amount);


                        $this->name = $thisuser->name;
                        $this->email = $thisuser->email;
                        $this->subject = $req->currencyCode . ' ' . number_format($req->amount, 2) . " now added to your wallet with PaySprint";


                        $this->message = '<p>You have received <strong>' . $req->currencyCode . ' ' . number_format($req->amount, 2) . '</strong> to your wallet with PaySprint from ' . $customer->name . '. You have <strong>' . $req->currencyCode . ' ' . number_format($walletBal, 2) . '</strong> balance in your account</p>';

                            $sendMsg = 'You have received ' . $req->currencyCode . ' ' . number_format($req->amount, 2) . ' to your wallet with PaySprint from ' . $customer->name . '. You have ' . $req->currencyCode . ' ' . number_format($walletBal, 2) . ' balance in your account';


                        $userPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

                        if (isset($userPhone)) {

                            $sendPhone = $thisuser->telephone;
                        } else {
                            $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
                        }

                        if ($thisuser->country == "Nigeria") {

                            $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                            $this->sendSms($sendMsg, $correctPhone);
                        } else {
                            $this->sendMessage($sendMsg, $sendPhone);
                        }


                        $userInfo = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol')->where('ref_code', $req->merchant_id)->first();



                        $this->createNotification($thisuser->ref_code, $sendMsg, $thisuser->playerId, $sendMsg, "Wallet Transaction");

                        $this->updatePoints($thisuser->id, 'Add money');

                        $this->sendEmail($this->email, "Fund remittance");


                        $activity = "Sent " . $req->currencyCode . '' . number_format($req->amount, 2) . " to ".$thisuser->businessname;
                        $credit = 0;
                        $debit = $req->amount;
                        $reference_code = "wallet-" . date('dmY') . time();
                        $balance = 0;
                        $trans_date = date('Y-m-d');
                        $status = "Delivered";
                        $action = "Wallet debit";
                        $regards = $customer->ref_code;
                        $statement_route = "wallet";

                        // Senders statement
                        $this->insStatement($customer->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, $customer->country, 1);

                        $this->getfeeTransaction($reference_code, $customer->ref_code, $req->amount, "0.00", $req->amount);


                        $this->name = $customer->name;
                        $this->email = $customer->email;
                        $this->subject = $req->currencyCode . ' ' . number_format($req->amount, 2) . " successfully sent to ".$thisuser->businessname;

                        $this->message = '<p>You have sent <strong>' . $req->currencyCode . ' ' . number_format($req->amount, 2) . '</strong> to '.$thisuser->businessname.'. You have <strong>' . $req->currencyCode . ' ' . number_format($customerDeduct, 2) . '</strong> balance in your account</p>';

                        $userPhone = User::where('email', $customer->email)->where('telephone', 'LIKE', '%+%')->first();

                        $sendMsgNotification = 'You have sent ' . $req->currencyCode . ' ' . number_format($req->amount, 2) . ' to '.$thisuser->businessname.'. You have ' . $req->currencyCode . ' ' . number_format($customerDeduct, 2) . ' balance in your account';

                        if (isset($userPhone)) {
                            $sendPhone = $customer->telephone;
                        } else {
                            $sendPhone = "+" . $customer->code . $customer->telephone;
                        }

                        if ($customer->country == "Nigeria") {

                            $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                            $this->sendSms($sendMsgNotification, $correctPhone);
                        } else {
                            $this->sendMessage($sendMsgNotification, $sendPhone);
                        }

                        $this->createNotification($customer->ref_code, $sendMsgNotification, $customer->playerId, $sendMsgNotification, "Wallet Transaction");

                        $this->sendEmail($customer->email, "Fund remittance");


                        $data = $userInfo;
                        $status = 200;
                        $message = 'You have successfully sent ' . $req->currencyCode . ' ' . number_format($req->amount, 2) . ' to ' . $thisuser->businessname;


                    } else {
                        // Invalid account Number
                        $data = [];
                        $message = "Incorrect transaction pin to process payment.";
                        $status = 400;
                    }
                } else {
                    $data = [];
                    $message = $thisuser->businessname . " is unable to receive payment by link because their account is still on test mode.";
                    $status = 400;
                }
            } else {

                // dd($req->all());

                if ($getMerchantInfo->accountMode === 'live') {
                    if ($req->paymentToken != null && $thisuser->country != "Canada") {

                        $getGateway = AllCountries::where('name', $thisuser->country)->first();

                        $gateway = ucfirst($getGateway->gateway);


                        $referenced_code = $req->paymentToken;


                        if ($thisuser->auto_credit == 1) {
                            // Update Wallet Balance
                            $walletBal = $thisuser->wallet_balance + $req->amount;
                            $holdBal = $thisuser->hold_balance;
                        } else {
                            // Update Wallet Balance
                            $walletBal = $thisuser->wallet_balance;
                            $holdBal = $thisuser->hold_balance + $req->amount;
                        }


                        User::where('ref_code', $req->merchant_id)->update(['wallet_balance' => $walletBal, 'hold_balance' => $holdBal]);

                        $userData = User::select('id', 'ref_code as refCode', 'name', 'email', 'telephone', 'wallet_balance as walletBalance', 'number_of_withdrawals as noOfWithdrawals')->where('ref_code', $req->merchant_id)->first();

                        $activity = "Added " . $req->currencyCode . '' . number_format($req->amount, 2) . " to Wallet";
                        $credit = $req->amount;
                        $debit = 0;
                        $reference_code = $referenced_code;
                        $balance = 0;
                        $trans_date = date('Y-m-d');
                        $status = "Delivered";
                        $action = "Wallet credit";
                        $regards = $thisuser->ref_code;
                        $statement_route = "wallet";

                        // Senders statement
                        $this->insStatement($thisuser->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, $thisuser->country, ($thisuser->auto_credit == 1 ? 0 : 1));

                        $this->getfeeTransaction($reference_code, $thisuser->ref_code, $req->amount, "0.00", $req->amount);

                        // Notification


                        $this->name = $thisuser->name;
                        $this->email = $thisuser->email;
                        $this->subject = $req->currencyCode . ' ' . number_format($req->amount, 2) . " now added to your wallet with PaySprint";


                        if ($thisuser->auto_credit == 1) {
                            $this->message = '<p>You have received <strong>' . $req->currencyCode . ' ' . number_format($req->amount, 2) . '</strong> to your wallet with PaySprint from ' . $req->fullname . '. You have <strong>' . $req->currencyCode . ' ' . number_format($walletBal, 2) . '</strong> balance in your account</p>';

                            $sendMsg = 'You have received ' . $req->currencyCode . ' ' . number_format($req->amount, 2) . ' to your wallet with PaySprint from ' . $req->fullname . '. You have ' . $req->currencyCode . ' ' . number_format($walletBal, 2) . ' balance in your account';
                        } else {
                            $this->message = '<p>You have received <strong>' . $req->currencyCode . ' ' . number_format($req->amount, 2) . '</strong> to your wallet with PaySprint from ' . $req->fullname . '. Kindly allow up to 12-24 hours for the funds to reflect in your wallet. You have <strong>' . $req->currencyCode . ' ' . number_format($walletBal, 2) . '</strong> balance in your account</p>';

                            $sendMsg = 'You have received ' . $req->currencyCode . ' ' . number_format($req->amount, 2) . ' to your wallet with PaySprint from ' . $req->fullname . '. Kindly allow up to 12-24 hours for the funds to reflect in your wallet. You have ' . $req->currencyCode . ' ' . number_format($walletBal, 2) . ' balance in your account';
                        }



                        $userPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

                        if (isset($userPhone)) {

                            $sendPhone = $thisuser->telephone;
                        } else {
                            $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
                        }

                        if ($thisuser->country == "Nigeria") {

                            $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                            $this->sendSms($sendMsg, $correctPhone);
                        } else {
                            $this->sendMessage($sendMsg, $sendPhone);
                        }


                        $userInfo = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol')->where('ref_code', $req->merchant_id)->first();

                        $data = $userInfo;
                        $status = 200;
                        $message = 'You have successfully sent ' . $req->currencyCode . ' ' . number_format($req->amount, 2) . ' to ' . $thisuser->businessname;

                        $this->createNotification($thisuser->ref_code, $sendMsg, $thisuser->playerId, $sendMsg, "Wallet Transaction");

                        $this->keepRecord($referenced_code, $message, "Success", $gateway, $thisuser->country, ($thisuser->auto_credit == 1 ? 0 : 1));

                        $this->updatePoints($thisuser->id, 'Add money');

                        $this->sendEmail($this->email, "Fund remittance");

                        // Log::info('Congratulations!, '.$thisuser->name.' '.$sendMsg);

                        $this->slack('Congratulations!, ' . $thisuser->name . ' ' . $sendMsg, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));

                        // Top Up PaySprint FX account with the commission charge...

                        $currencyFX = new MonthlySubController();

                        $currencyFX->feeChargeCredit($thisuser->country, $req->commissiondeduct, $thisuser->businessname, $thisuser->accountType);
                    } else {


                        $response = $this->monerisBusinessWalletProcess($req->merchant_id, $req->creditcard_no, $req->month, $req->expirydate, $req->amount, "purchase", "PaySprint/Vimfile Add Money to the Wallet of " . $thisuser->businessname);



                        if ($response->responseData['ResponseCode'] == "000" || $response->responseData['ResponseCode'] == "001" || $response->responseData['ResponseCode'] == "002" || $response->responseData['ResponseCode'] == "003" || $response->responseData['ResponseCode'] == "004" || $response->responseData['ResponseCode'] == "005" || $response->responseData['ResponseCode'] == "006" || $response->responseData['ResponseCode'] == "007" || $response->responseData['ResponseCode'] == "008" || $response->responseData['ResponseCode'] == "009" || $response->responseData['ResponseCode'] == "010" || $response->responseData['ResponseCode'] == "023" || $response->responseData['ResponseCode'] == "024" || $response->responseData['ResponseCode'] == "025" || $response->responseData['ResponseCode'] == "026" || $response->responseData['ResponseCode'] == "027" || $response->responseData['ResponseCode'] == "028" || $response->responseData['ResponseCode'] == "029") {

                            $reference_code = $response->responseData['ReceiptId'];



                            $cardNo = str_repeat("*", strlen($req->creditcard_no) - 4) . substr($req->creditcard_no, -4);

                            if ($thisuser->auto_credit == 1) {
                                // Update Wallet Balance
                                $walletBal = $thisuser->wallet_balance + $req->amount;
                                $holdBal = $thisuser->hold_balance;
                            } else {
                                // Update Wallet Balance
                                $walletBal = $thisuser->wallet_balance;
                                $holdBal = $thisuser->hold_balance + $req->amount;
                            }

                            User::where('ref_code', $req->merchant_id)->update(['wallet_balance' => $walletBal, 'hold_balance' => $holdBal]);

                            $userData = User::select('id', 'ref_code as refCode', 'name', 'email', 'telephone', 'wallet_balance as walletBalance', 'number_of_withdrawals as noOfWithdrawals')->where('ref_code', $req->merchant_id)->first();

                            $activity = "Added " . $req->currencyCode . '' . number_format($req->amount, 2) . " to Wallet";
                            $credit = $req->amount;
                            $debit = 0;
                            $reference_code = $response->responseData['ReceiptId'];
                            $balance = 0;
                            $trans_date = date('Y-m-d');
                            $status = "Delivered";
                            $action = "Wallet credit";
                            $regards = $thisuser->ref_code;
                            $statement_route = "wallet";

                            // Senders statement
                            $this->insStatement($thisuser->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, $thisuser->country, ($thisuser->auto_credit == 1 ? 0 : 1));

                            $this->getfeeTransaction($reference_code, $thisuser->ref_code, $req->amount, "0.00", $req->amount);


                            // Notification


                            $this->name = $thisuser->name;
                            $this->email = $thisuser->email;
                            $this->subject = $req->currencyCode . ' ' . number_format($req->amount, 2) . " now added to your wallet with PaySprint";



                            if ($thisuser->auto_credit == 1) {
                                $this->message = '<p>You have received <strong>' . $req->currencyCode . ' ' . number_format($req->amount, 2) . '</strong> to your wallet with PaySprint from ' . $req->fullname . '. You have <strong>' . $req->currencyCode . ' ' . number_format($walletBal, 2) . '</strong> balance in your account</p>';

                                $sendMsg = 'You have received ' . $req->currencyCode . ' ' . number_format($req->amount, 2) . ' to your wallet with PaySprint from ' . $req->fullname . '. You have ' . $req->currencyCode . ' ' . number_format($walletBal, 2) . ' balance in your account';
                            } else {
                                $this->message = '<p>You have received <strong>' . $req->currencyCode . ' ' . number_format($req->amount, 2) . '</strong> to your wallet with PaySprint from ' . $req->fullname . '. Kindly allow up to 12-24 hours for the funds to reflect in your wallet. You have <strong>' . $req->currencyCode . ' ' . number_format($walletBal, 2) . '</strong> balance in your account</p>';

                                $sendMsg = 'You have received ' . $req->currencyCode . ' ' . number_format($req->amount, 2) . ' to your wallet with PaySprint from ' . $req->fullname . '. Kindly allow up to 12-24 hours for the funds to reflect in your wallet. You have ' . $req->currencyCode . ' ' . number_format($walletBal, 2) . ' balance in your account';
                            }

                            $userPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

                            if (isset($userPhone)) {

                                $sendPhone = $thisuser->telephone;
                            } else {
                                $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
                            }

                            if ($thisuser->country == "Nigeria") {

                                $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                                $this->sendSms($sendMsg, $correctPhone);
                            } else {
                                $this->sendMessage($sendMsg, $sendPhone);
                            }

                            $this->sendEmail($this->email, "Fund remittance");

                            $userInfo = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol')->where('ref_code', $req->merchant_id)->first();

                            $data = $userInfo;
                            $status = 200;
                            $message = 'You have successfully sent ' . $req->currencyCode . ' ' . number_format($req->amount, 2) . ' to ' . $thisuser->businessname;

                            $this->createNotification($thisuser->ref_code, $sendMsg, $thisuser->playerId, $sendMsg, "Wallet Transaction");

                            $this->updatePoints($thisuser->id, 'Add money');

                            // Log::info('Congratulations!, '.$thisuser->name.' '.$sendMsg);

                            $this->slack('Congratulations!, ' . $thisuser->name . ' ' . $sendMsg, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));

                            $monerisactivity = $thisuser->name . ' ' . $sendMsg;
                            $this->keepRecord($reference_code, $response->responseData['Message'], $monerisactivity, 'moneris', $thisuser->country, ($thisuser->auto_credit == 1 ? 0 : 1));


                            $currencyFX = new MonthlySubController();

                            $currencyFX->feeChargeCredit($thisuser->country, $req->commissiondeduct, $thisuser->businessname, $thisuser->accountType);
                        } else {
                            $data = [];
                            $message = $response->responseData['Message'] . " If the error persists, kindly login on the web app at https://paysprint.ca to continue your transactions.";
                            $status = 400;

                            // Log::critical('Oops!! '.$thisuser->name.' '.$message);

                            $this->slack('Oops!, ' . $thisuser->name . ' ' . $message, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));

                            $monerisactivity = $thisuser->name . ' ' . $message;
                            $this->keepRecord("", $response->responseData['Message'], $monerisactivity, 'moneris', $thisuser->country, 0);
                        }
                    }
                } else {
                    $data = [];
                    $message = $thisuser->businessname . " is unable to receive payment by link because their account is still on test mode.";
                    $status = 400;
                }
            }
        } catch (\Throwable $th) {
            $data = [];
            $message = $th->getMessage();
            $status = 400;
        }

        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

        return $this->returnJSON(
            $resData,
            $status
        );
    }



    public function myInvoiceComment(Request $req, $id)
    {

        $getInvoice = ImportExcel::where('id', $req->id)->first();

        if (isset($getInvoice)) {
            try {

                $thisuser = User::where('email', $getInvoice->payee_email)->first();

                $merchantInfo = User::where('ref_code', $getInvoice->uploaded_by)->first();

                $transactionID = "invoice-" . date('dmY') . time();

                ImportExcel::where('id', $req->id)->update(['payment_status' => 1]);


                $insPay = InvoicePayment::updateOrCreate(['invoice_no' => $getInvoice->invoice_no], ['transactionid' => $transactionID, 'name' => $thisuser->name, 'email' => $thisuser->email, 'amount' => $getInvoice->total_amount, 'invoice_no' => $getInvoice->invoice_no, 'service' => $getInvoice->service, 'client_id' => $merchantInfo->ref_code, 'payment_method' => $req->payment_method]);

                // Insert Wallet Statement

                $activity = "Invoice of " . $merchantInfo->currencyCode . '' . number_format($req->amount, 2) . " paid from " . $req->payment_method . " | " . $req->comment;
                $credit = $getInvoice->total_amount;
                $debit = 0;
                $reference_code = $transactionID;
                $balance = 0;
                $trans_date = date('Y-m-d');
                $status = "Delivered";
                $action = "Invoice paid";
                $regards = $merchantInfo->ref_code;
                $statement_route = "Others";

                // Senders statement
                $this->insStatement($merchantInfo->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, $merchantInfo->country, 0);


                $this->createNotification($merchantInfo->ref_code, $activity, $merchantInfo->playerId, $activity, "Wallet Transaction");


                $resData = "Invoice marked as paid";
                $resp = "success";
            } catch (\Throwable $th) {
                $resData = $th->getMessage();
                $resp = "error";
            }
        } else {
            $resData = "Cannot find this invoice";
            $resp = "error";
        }


        return redirect()->route('Admin')->with($resp, $resData);
    }


    public function myInvoiceLinkComment(Request $req, $id)
    {

        $getInvoice = ImportExcelLink::where('id', $req->id)->first();

        if (isset($getInvoice)) {
            try {

                $merchantInfo = User::where('ref_code', $getInvoice->uploaded_by)->first();

                $transactionID = "invoice-" . date('dmY') . time();

                ImportExcelLink::where('id', $req->id)->update(['payment_status' => 1]);


                InvoicePayment::updateOrCreate(['invoice_no' => $getInvoice->invoice_no], ['transactionid' => $transactionID, 'name' => $getInvoice->name, 'email' => $getInvoice->payee_email, 'amount' => $getInvoice->total_amount, 'invoice_no' => $getInvoice->invoice_no, 'service' => $getInvoice->service, 'client_id' => $merchantInfo->ref_code, 'payment_method' => $req->payment_method]);

                // Insert Wallet Statement

                $activity = "Invoice of " . $merchantInfo->currencyCode . '' . number_format($req->amount, 2) . " paid from " . $req->payment_method . " | " . $req->comment;
                $credit = $getInvoice->total_amount;
                $debit = 0;
                $reference_code = $transactionID;
                $balance = 0;
                $trans_date = date('Y-m-d');
                $status = "Delivered";
                $action = "Invoice paid";
                $regards = $merchantInfo->ref_code;
                $statement_route = "Others";

                // Senders statement
                $this->insStatement($merchantInfo->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, $merchantInfo->country, 0);


                $this->createNotification($merchantInfo->ref_code, $activity, $merchantInfo->playerId, $activity, "Wallet Transaction");


                $resData = "Invoice marked as paid";
                $resp = "success";
            } catch (\Throwable $th) {
                $resData = $th->getMessage();
                $resp = "error";
            }
        } else {
            $resData = "Cannot find this invoice";
            $resp = "error";
        }


        return redirect()->route('Admin')->with($resp, $resData);
    }




    // Check IDV Verification
    public function checkMyIdv(Request $req)
    {

        try {
            $thisuser = User::where('api_token', $req->bearerToken())->first();


            $response = $this->checkUsersPassAccount($thisuser->id);

            $data = $response;
            $message = 'Success';
            $status = 200;
        } catch (\Throwable $th) {
            $data = [];
            $message = $th->getMessage();
            $status = 400;
        }

        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

        return $this->returnJSON($resData, $status);
    }


    // Add Money to Wallet
    public function addMoneyToWallet(Request $req)
    {


        $thisuser = User::where('api_token', $req->bearerToken())->first();

        if ($thisuser->flagged === 1) {
            $data = [];
            $message = 'Hello ' . $thisuser->name . ', Access to the account is not currently available. Kindly contact the Admin using this link: https://paysprint.ca/contact.';
            $status = 400;
        } else {
            if (isset($req->mode) && $req->mode == "test") {



                $gateway = "";

                $validator = Validator::make($req->all(), [
                    //  'card_id' => 'required|string',
                    'amount' => 'required|string',
                    'currencyCode' => 'required|string',
                    'conversionamount' => 'required|string',
                ]);

                if ($validator->passes()) {

                    if ($req->commission == "on") {
                        $grossAmount = $req->amount;
                    } else {
                        $grossAmount = $req->amount + $req->commissiondeduct;
                    }



                    // Log::info($thisuser->name." wants to add ".$req->currencyCode." ".$req->amount." to their wallet. This is a test environment nothing happens to your money");

                    $this->slack($thisuser->name . " wants to add " . $req->currencyCode . " " . $req->amount . " to their wallet. This is a test environment nothing happens to your money", $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));

                    // $monerisDeductamount = $req->conversionamount;
                    $monerisDeductamount = $req->amount;
                    // $monerisDeductamount = $this->currencyConvert($req->currencyCode, $req->amount);

                    $getGateway = AllCountries::where('name', $thisuser->country)->first();

                    if ($req->paymentToken != null && $thisuser->country != "Canada") {


                        $getTransactionCode = $this->verifyTransaction($req->paymentToken);

                        $gateway = ucfirst($getGateway->gateway);

                        if ($getTransactionCode->status == true) {

                            $referenced_code = $req->paymentToken;
                        } else {
                            $referenced_code = $req->paymentToken;
                        }


                        // Update Wallet Balance
                        $walletBal = $thisuser->wallet_balance;
                        $holdBal = $thisuser->hold_balance + $req->amounttosend;
                        // User::where('api_token', $req->bearerToken())->update(['wallet_balance' => $walletBal, 'hold_balance' => $holdBal]);

                        $userData = User::select('id', 'ref_code as refCode', 'name', 'email', 'telephone', 'wallet_balance as walletBalance', 'number_of_withdrawals as noOfWithdrawals')->where('api_token', $req->bearerToken())->first();

                        $activity = "Added " . $req->currencyCode . '' . number_format($req->amounttosend, 2) . " to Wallet including a fee charge of " . $req->currencyCode . '' . number_format($req->commissiondeduct, 2) . " was deducted from your Debit Card";
                        $credit = $req->amounttosend;
                        $debit = 0;
                        $reference_code = $referenced_code;
                        $balance = 0;
                        $trans_date = date('Y-m-d');
                        $status = "Delivered";
                        $action = "Wallet credit";
                        $regards = $thisuser->ref_code;
                        $statement_route = "wallet";

                        // Senders statement
                        // $this->insStatement($thisuser->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, $thisuser->country, 1);

                        // $this->getfeeTransaction($reference_code, $thisuser->ref_code, $req->amount, $req->commissiondeduct, $req->amounttosend);

                        // Notification




                        $this->name = $thisuser->name;
                        $this->email = $thisuser->email;
                        $this->subject = $req->currencyCode . ' ' . number_format($req->amounttosend, 2) . " now added to your wallet with PaySprint";

                        $this->message = '<p>You have added <strong>' . $req->currencyCode . ' ' . number_format($req->amounttosend, 2) . '</strong> <em>(Gross Amount of ' . $req->currencyCode . ' ' . number_format($grossAmount, 2) . ' less transaction fee ' . $req->currencyCode . ' ' . number_format($req->commissiondeduct, 2) . ')</em> to your wallet with PaySprint. Kindly allow up to 12-24 hours for the funds to reflect in your wallet. You have <strong>' . $req->currencyCode . ' ' . number_format($walletBal, 2) . '</strong> balance in your account</p>';

                        $sendMsg = 'You have added ' . $req->currencyCode . ' ' . number_format($req->amounttosend, 2) . ' (Gross Amount of ' . $req->currencyCode . ' ' . number_format($grossAmount, 2) . ' less transaction fee ' . $req->currencyCode . ' ' . number_format($req->commissiondeduct, 2) . ') to your wallet with PaySprint.  Kindly allow up to 12-24 hours for the funds to reflect in your wallet. You have ' . $req->currencyCode . ' ' . number_format($walletBal, 2) . ' balance in your account';

                        $userPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

                        if (isset($userPhone)) {

                            $sendPhone = $thisuser->telephone;
                        } else {
                            $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
                        }

                        if ($thisuser->country == "Nigeria") {

                            $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                            $this->sendSms($sendMsg, $correctPhone);
                        } else {
                            $this->sendMessage($sendMsg, $sendPhone);
                        }


                        $this->sendEmail($this->email, "Fund remittance");


                        $checkBVN = $this->bvnVerificationCharge($req->bearerToken());

                        if ($checkBVN == "charge") {

                            $getUser = User::where('api_token', $req->bearerToken())->first();


                            // Update Wallet Balance
                            $walletBalance = $getUser->wallet_balance - 15;
                            // User::where('api_token', $req->bearerToken())->update(['wallet_balance' => $walletBalance, 'bvn_verification' => 2]);

                            $activity = "Bank Verification (BVN) Charge of " . $req->currencyCode . '' . number_format(15, 2) . " was deducted from your Wallet";
                            $credit = 0;
                            $debit = 15;
                            $reference_number = "wallet-" . date('dmY') . time();
                            $balance = 0;
                            $trans_date = date('Y-m-d');
                            $status = "Delivered";
                            $action = "Wallet debit";
                            $regards = $thisuser->ref_code;
                            $statement_route = "wallet";

                            // Senders statement
                            // $this->insStatement($thisuser->email, $reference_number, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, $thisuser->country, 0);

                            // $this->getfeeTransaction($reference_number, $thisuser->ref_code, 15, 0, 15);

                            $sendMsg = $activity . '. You have ' . $req->currencyCode . ' ' . number_format($walletBalance, 2) . ' balance in your account';

                            $userPhone = User::where('email', $getUser->email)->where('telephone', 'LIKE', '%+%')->first();

                            if (isset($userPhone)) {

                                $sendPhone = $getUser->telephone;
                            } else {
                                $sendPhone = "+" . $getUser->code . $getUser->telephone;
                            }

                            if ($getUser->country == "Nigeria") {

                                $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                                $this->sendSms($sendMsg, $correctPhone);
                            } else {
                                $this->sendMessage($sendMsg, $sendPhone);
                            }
                        }

                        $userInfo = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol')->where('api_token', $req->bearerToken())->first();

                        $data = $userInfo;
                        $status = 200;
                        $message = 'You have successfully added ' . $req->currencyCode . ' ' . number_format($req->amounttosend, 2) . ' to your wallet';

                        $this->createNotification($thisuser->ref_code, $sendMsg, $thisuser->playerId, $sendMsg, "Wallet Transaction");

                        $this->updatePoints($thisuser->id, 'Add money');



                        // $this->keepRecord($referenced_code, $message, "Success", $gateway, $thisuser->country);

                        // Log::info('Congratulations!, '.$thisuser->name.' '.$sendMsg.". This is a test environment");

                        $this->slack('Congratulations!, ' . $thisuser->name . ' ' . $sendMsg . ". This is a test environment", $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));
                    } else {


                        if ($thisuser->country == "United States" || $thisuser->country == "USA" || $thisuser->country == "United States of America") {

                            // $response = $this->monerisWalletProcess($req->bearerToken(), $req->card_id, $req->amounttosend, "purchase", "PaySprint/Vimfile Add Money to the Wallet of ".$thisuser->name, $req->mode);


                            $response = $this->fortisPay($req->amounttosend, $req->card_id, $thisuser->zip, $thisuser->name, $thisuser->email, $thisuser->telephone, $thisuser->city, $thisuser->state, "test");



                            if ($response->status != 401) {

                                $responseCode = $response->transaction->reason_code_id;


                                switch ($responseCode) {
                                    case 1000:
                                        $responseMessage = "Approved";
                                        break;
                                    case 1001:
                                        $responseMessage = "AuthCompleted";
                                        break;
                                    case 1002:
                                        $responseMessage = "Forced";
                                        break;
                                    case 1003:
                                        $responseMessage = "AuthOnly Declined";
                                        break;
                                    case 1004:
                                        $responseMessage = "Validation Failure (System Run Trx)";
                                        break;
                                    case 1005:
                                        $responseMessage = "Processor Response Invalid";
                                        break;
                                    case 1200:
                                        $responseMessage = "Voided";
                                        break;
                                    case 1240:
                                        $responseMessage = "Approved, optional fields are missing (Paya ACH only)";
                                        break;
                                    case 1500:
                                        $responseMessage = "Generic Decline";
                                        break;
                                    case 1510:
                                        $responseMessage = "Call";
                                        break;
                                    case 1518:
                                        $responseMessage = "Transaction Not Permitted - Terminal";
                                        break;
                                    case 1520:
                                        $responseMessage = "Pickup Card";
                                        break;
                                    case 1530:
                                        $responseMessage = "Retry Trx";
                                        break;
                                    case 1531:
                                        $responseMessage = "Communication Error";
                                        break;
                                    case 1540:
                                        $responseMessage = "Setup Issue, contact Support";
                                        break;
                                    case 1541:
                                        $responseMessage = "Device is not signature capable";
                                        break;
                                    case 1588:
                                        $responseMessage = "Data could not be de-tokenized";
                                        break;
                                    case 1599:
                                        $responseMessage = "Other Reason";
                                        break;
                                    case 1601:
                                        $responseMessage = "Generic Decline";
                                        break;
                                    case 1602:
                                        $responseMessage = "Call";
                                        break;
                                    case 1603:
                                        $responseMessage = "No Reply";
                                        break;
                                    case 1604:
                                        $responseMessage = "Pickup Card - No Fraud";
                                        break;
                                    case 1605:
                                        $responseMessage = "Pickup Card - Fraud";
                                        break;
                                    case 1606:
                                        $responseMessage = "Pickup Card - Lost";
                                        break;
                                    case 1607:
                                        $responseMessage = "Pickup Card - Stolen";
                                        break;
                                    case 1608:
                                        $responseMessage = "Account Error";
                                        break;
                                    case 1609:
                                        $responseMessage = "Already Reversed";
                                        break;
                                    case 1610:
                                        $responseMessage = "Bad PIN";
                                        break;
                                    case 1611:
                                        $responseMessage = "Cashback Exceeded";
                                        break;
                                    case 1612:
                                        $responseMessage = "Cashback Not Available";
                                        break;
                                    case 1613:
                                        $responseMessage = "CID Error";
                                        break;
                                    case 1614:
                                        $responseMessage = "Date Error";
                                        break;
                                    case 1615:
                                        $responseMessage = "Do Not Honor";
                                        break;
                                    case 1616:
                                        $responseMessage = "NSF";
                                        break;
                                    case 1617:
                                        $responseMessage = "Exceeded Withdrawal Limit";
                                        break;
                                    case 1618:
                                        $responseMessage = "Invalid Service Code";
                                        break;
                                    case 1619:
                                        $responseMessage = "Exceeded activity limit";
                                        break;
                                    case 1620:
                                        $responseMessage = "Violation";
                                        break;
                                    case 1621:
                                        $responseMessage = "Encryption Error";
                                        break;
                                    case 1622:
                                        $responseMessage = "Card Expired";
                                        break;
                                    case 1623:
                                        $responseMessage = "Renter";
                                        break;
                                    case 1624:
                                        $responseMessage = "Security Violation";
                                        break;
                                    case 1625:
                                        $responseMessage = "Card Not Permitted";
                                        break;
                                    case 1626:
                                        $responseMessage = "Trans Not Permitted";
                                        break;
                                    case 1627:
                                        $responseMessage = "System Error";
                                        break;
                                    case 1628:
                                        $responseMessage = "Bad Merchant ID";
                                        break;
                                    case 1629:
                                        $responseMessage = "Duplicate Batch (Already Closed)";
                                        break;
                                    case 1630:
                                        $responseMessage = "Batch Rejected";
                                        break;
                                    case 1631:
                                        $responseMessage = "Account Closed";
                                        break;
                                    case 1640:
                                        $responseMessage = "Required fields are missing (ACH only)";
                                        break;
                                    case 1641:
                                        $responseMessage = "Previously declined transaction (1640)";
                                        break;
                                    case 1651:
                                        $responseMessage = "Max Sending - Throttle Limit Hit (ACH only)";
                                        break;
                                    case 1652:
                                        $responseMessage = "Max Attempts Exceeded";
                                        break;
                                    case 1653:
                                        $responseMessage = "Contact Support";
                                        break;
                                    case 1654:
                                        $responseMessage = "Voided - Online Reversal Failed";
                                        break;
                                    case 1655:
                                        $responseMessage = "Decline (AVS Auto Reversal)";
                                        break;
                                    case 1656:
                                        $responseMessage = "Decline (Partial Auth Auto Reversal)";
                                        break;
                                    case 1657:
                                        $responseMessage = "Decline (Partial Auth Auto Reversal)";
                                        break;
                                    case 1658:
                                        $responseMessage = "Expired Authorization";
                                        break;
                                    case 1659:
                                        $responseMessage = "Declined - Partial Approval not Supported";
                                        break;
                                    case 1660:
                                        $responseMessage = "Bank Account Error, please delete and re-add Account Vault";
                                        break;
                                    case 1661:
                                        $responseMessage = "Declined AuthIncrement";
                                        break;
                                    case 1662:
                                        $responseMessage = "Auto Reversal - Processor can't settle";
                                        break;
                                    case 1663:
                                        $responseMessage = "Manager Needed (Needs override transaction)";
                                        break;
                                    case 1664:
                                        $responseMessage = "Account Vault Not Found: Sharing Group Unavailable";
                                        break;
                                    case 1665:
                                        $responseMessage = "Contact Not Found: Sharing Group Unavailable";
                                        break;
                                    case 1701:
                                        $responseMessage = "Chip Reject";
                                        break;
                                    case 1800:
                                        $responseMessage = "Incorrect CVV";
                                        break;
                                    case 1801:
                                        $responseMessage = "Duplicate Transaction";
                                        break;
                                    case 1802:
                                        $responseMessage = "MID/TID Not Registered";
                                        break;
                                    case 1803:
                                        $responseMessage = "Stop Recurring";
                                        break;
                                    case 1804:
                                        $responseMessage = "No Transactions in Batch";
                                        break;
                                    case 1805:
                                        $responseMessage = "Batch Does Not Exist";
                                        break;

                                    default:
                                        $responseMessage = "N/A";
                                }


                                if ($response->transaction->reason_code_id == 1000) {

                                    $reference_code = $response->transaction->id;

                                    $gateway = "Fortispay";



                                    $cardDetails = AddCard::where('id', $req->card_id)->where('user_id', $thisuser->id)->first();

                                    $cardNo = str_repeat("*", strlen($cardDetails->card_number) - 4) . substr($cardDetails->card_number, -4);

                                    // Update Wallet Balance
                                    $walletBal = $thisuser->wallet_balance;
                                    $holdBal = $thisuser->hold_balance + $req->amounttosend;
                                    // User::where('api_token', $req->bearerToken())->update(['wallet_balance' => $walletBal, 'hold_balance' => $holdBal]);

                                    $userData = User::select('id', 'ref_code as refCode', 'name', 'email', 'telephone', 'wallet_balance as walletBalance', 'number_of_withdrawals as noOfWithdrawals')->where('api_token', $req->bearerToken())->first();

                                    $activity = "Added " . $req->currencyCode . '' . number_format($req->amounttosend, 2) . " to Wallet including fee charge of " . $req->currencyCode . '' . number_format($req->commissiondeduct, 2) . " was deducted from Card: " . wordwrap($cardNo, 4, '-', true);
                                    $credit = $req->amounttosend;
                                    $debit = 0;
                                    $reference_code = $response->transaction->id;
                                    $balance = 0;
                                    $trans_date = date('Y-m-d');
                                    $status = "Delivered";
                                    $action = "Wallet credit";
                                    $regards = $thisuser->ref_code;
                                    $statement_route = "wallet";

                                    // Senders statement
                                    // $this->insStatement($thisuser->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, $thisuser->country, 1);

                                    // $this->getfeeTransaction($reference_code, $thisuser->ref_code, $req->amount, $req->commissiondeduct, $req->amounttosend);




                                    // Notification


                                    $this->name = $thisuser->name;
                                    $this->email = $thisuser->email;
                                    $this->subject = $req->currencyCode . ' ' . number_format($req->amounttosend, 2) . " now added to your wallet with PaySprint";

                                    $this->message = '<p>You have added <strong>' . $req->currencyCode . ' ' . number_format($req->amounttosend, 2) . '</strong> <em>(Gross Amount of ' . $req->currencyCode . ' ' . number_format($grossAmount, 2) . ' less transaction fee ' . $req->currencyCode . ' ' . number_format($req->commissiondeduct, 2) . ')</em> to your wallet with PaySprint. Kindly allow up to 12-24 hours for the funds to reflect in your wallet. You have <strong>' . $req->currencyCode . ' ' . number_format($walletBal, 2) . '</strong> balance in your account</p>';

                                    $sendMsg = 'You have added ' . $req->currencyCode . ' ' . number_format($req->amounttosend, 2) . ' (Gross Amount of ' . $req->currencyCode . ' ' . number_format($grossAmount, 2) . ' less transaction fee ' . $req->currencyCode . ' ' . number_format($req->commissiondeduct, 2) . ') to your wallet with PaySprint. You have ' . $req->currencyCode . ' ' . number_format($walletBal, 2) . ' balance in your account';

                                    $userPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

                                    if (isset($userPhone)) {

                                        $sendPhone = $thisuser->telephone;
                                    } else {
                                        $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
                                    }

                                    if ($thisuser->country == "Nigeria") {

                                        $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                                        $this->sendSms($sendMsg, $correctPhone);
                                    } else {
                                        $this->sendMessage($sendMsg, $sendPhone);
                                    }


                                    $this->sendEmail($this->email, "Fund remittance");

                                    $userInfo = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol')->where('api_token', $req->bearerToken())->first();

                                    $data = $userInfo;
                                    $status = 200;
                                    $message = 'You have successfully added ' . $req->currencyCode . ' ' . number_format($req->amounttosend, 2) . ' to your wallet';

                                    // $this->createNotification($thisuser->ref_code, $sendMsg);

                                    // Log::info('Congratulations!, '.$thisuser->name.' '.$sendMsg.". This is a test environment");

                                    $this->slack('Congratulations!, ' . $thisuser->name . ' ' . $sendMsg . ". This is a test environment", $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));

                                    $monerisactivity = $thisuser->name . ' ' . $sendMsg;
                                    $this->keepRecord($reference_code, $responseCode, $monerisactivity, $gateway, $thisuser->country, 1);
                                } else {
                                    $data = [];
                                    $message = $responseCode;
                                    $status = 400;

                                    $gateway = "Fortispay";

                                    // Log::critical('Oops!! '.$thisuser->name.' '.$message);

                                    $this->slack('Oops!! ' . $thisuser->name . ' ' . $message, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));

                                    $monerisactivity = $thisuser->name . ' ' . $message;
                                    // $this->keepRecord("", $responseCode, $monerisactivity, $gateway, $thisuser->country);
                                }
                            } else {

                                $response = $this->monerisWalletProcess($req->bearerToken(), $req->card_id, $monerisDeductamount, "purchase", "PaySprint/Vimfile Add Money to the Wallet of " . $thisuser->name, $req->mode);


                                if ($response->responseData['ResponseCode'] == "000" || $response->responseData['ResponseCode'] == "001" || $response->responseData['ResponseCode'] == "002" || $response->responseData['ResponseCode'] == "003" || $response->responseData['ResponseCode'] == "004" || $response->responseData['ResponseCode'] == "005" || $response->responseData['ResponseCode'] == "006" || $response->responseData['ResponseCode'] == "007" || $response->responseData['ResponseCode'] == "008" || $response->responseData['ResponseCode'] == "009" || $response->responseData['ResponseCode'] == "010" || $response->responseData['ResponseCode'] == "023" || $response->responseData['ResponseCode'] == "024" || $response->responseData['ResponseCode'] == "025" || $response->responseData['ResponseCode'] == "026" || $response->responseData['ResponseCode'] == "027" || $response->responseData['ResponseCode'] == "028" || $response->responseData['ResponseCode'] == "029") {

                                    $reference_code = $response->responseData['ReceiptId'];



                                    $cardDetails = AddCard::where('id', $req->card_id)->where('user_id', $thisuser->id)->first();

                                    $cardNo = str_repeat("*", strlen($cardDetails->card_number) - 4) . substr($cardDetails->card_number, -4);

                                    // Update Wallet Balance
                                    $walletBal = $thisuser->wallet_balance;
                                    $holdBal = $thisuser->hold_balance + $req->amounttosend;
                                    // User::where('api_token', $req->bearerToken())->update(['wallet_balance' => $walletBal]);

                                    $userData = User::select('id', 'ref_code as refCode', 'name', 'email', 'telephone', 'wallet_balance as walletBalance', 'number_of_withdrawals as noOfWithdrawals')->where('api_token', $req->bearerToken())->first();

                                    $activity = "Added " . $req->currencyCode . '' . number_format($req->amounttosend, 2) . " to Wallet including fee charge of " . $req->currencyCode . '' . number_format($req->commissiondeduct, 2) . " was deducted from Card: " . wordwrap($cardNo, 4, '-', true);
                                    $credit = $req->amounttosend;
                                    $debit = 0;
                                    $reference_code = $response->responseData['ReceiptId'];
                                    $balance = 0;
                                    $trans_date = date('Y-m-d');
                                    $status = "Delivered";
                                    $action = "Wallet credit";
                                    $regards = $thisuser->ref_code;
                                    $statement_route = "wallet";

                                    // Senders statement
                                    // $this->insStatement($thisuser->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, $thisuser->country, 0);

                                    // $this->getfeeTransaction($reference_code, $thisuser->ref_code, $req->amount, $req->commissiondeduct, $req->amounttosend);




                                    // Notification


                                    $this->name = $thisuser->name;
                                    $this->email = $thisuser->email;
                                    $this->subject = $req->currencyCode . ' ' . number_format($req->amounttosend, 2) . " now added to your wallet with PaySprint";

                                    $this->message = '<p>You have added <strong>' . $req->currencyCode . ' ' . number_format($req->amounttosend, 2) . '</strong> <em>(Gross Amount of ' . $req->currencyCode . ' ' . number_format($grossAmount, 2) . ' less transaction fee ' . $req->currencyCode . ' ' . number_format($req->commissiondeduct, 2) . ')</em> to your wallet with PaySprint. You have <strong>' . $req->currencyCode . ' ' . number_format($walletBal, 2) . '</strong> balance in your account</p>';

                                    $sendMsg = 'You have added ' . $req->currencyCode . ' ' . number_format($req->amounttosend, 2) . ' (Gross Amount of ' . $req->currencyCode . ' ' . number_format($grossAmount, 2) . ' less transaction fee ' . $req->currencyCode . ' ' . number_format($req->commissiondeduct, 2) . ') to your wallet with PaySprint. You have ' . $req->currencyCode . ' ' . number_format($walletBal, 2) . ' balance in your account';

                                    $userPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

                                    if (isset($userPhone)) {

                                        $sendPhone = $thisuser->telephone;
                                    } else {
                                        $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
                                    }

                                    if ($thisuser->country == "Nigeria") {

                                        $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                                        $this->sendSms($sendMsg, $correctPhone);
                                    } else {
                                        $this->sendMessage($sendMsg, $sendPhone);
                                    }



                                    $this->sendEmail($this->email, "Fund remittance");

                                    $userInfo = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol')->where('api_token', $req->bearerToken())->first();

                                    $data = $userInfo;
                                    $status = 200;
                                    $message = 'You have successfully added ' . $req->currencyCode . ' ' . number_format($req->amounttosend, 2) . ' to your wallet';

                                    // $this->createNotification($thisuser->ref_code, $sendMsg);

                                    // Log::info('Congratulations!, '.$thisuser->name.' '.$sendMsg.". This is a test environment");

                                    $this->slack('Congratulations!, ' . $thisuser->name . ' ' . $sendMsg . ". This is a test environment", $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));

                                    $monerisactivity = $thisuser->name . ' ' . $sendMsg;
                                    // $this->keepRecord($reference_code, $response->responseData['Message'], $monerisactivity, 'moneris', $thisuser->country);


                                } else {
                                    $data = [];
                                    $message = $response->responseData['Message'];
                                    $status = 400;

                                    // Log::critical('Oops!! '.$thisuser->name.' '.$message.". This is a test environment");

                                    $this->slack('Oops!, ' . $thisuser->name . ' ' . $message . ". This is a test environment", $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));

                                    $monerisactivity = $thisuser->name . ' ' . $message;
                                    // $this->keepRecord("", $response->responseData['Message'], $monerisactivity, 'moneris', $thisuser->country);
                                }
                            }
                        } elseif ($thisuser->country == "Nigeria") {

                            $data = [];
                            $message = "We cannot process your transaction. Kindly update your app from the Play Store or App Store. Thanks";
                            $status = 400;

                            // Log::critical('Oops!! '.$thisuser->name.' '.$message.". This is a test environment");


                            $this->slack('Oops!, ' . $thisuser->name . ' ' . $message . ". This is a test environment", $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));
                        } else {



                            $response = $this->monerisWalletProcess($req->bearerToken(), $req->card_id, $monerisDeductamount, "purchase", "PaySprint/Vimfile Add Money to the Wallet of " . $thisuser->name, $req->mode);


                            if ($response->responseData['ResponseCode'] == "000" || $response->responseData['ResponseCode'] == "001" || $response->responseData['ResponseCode'] == "002" || $response->responseData['ResponseCode'] == "003" || $response->responseData['ResponseCode'] == "004" || $response->responseData['ResponseCode'] == "005" || $response->responseData['ResponseCode'] == "006" || $response->responseData['ResponseCode'] == "007" || $response->responseData['ResponseCode'] == "008" || $response->responseData['ResponseCode'] == "009" || $response->responseData['ResponseCode'] == "010" || $response->responseData['ResponseCode'] == "023" || $response->responseData['ResponseCode'] == "024" || $response->responseData['ResponseCode'] == "025" || $response->responseData['ResponseCode'] == "026" || $response->responseData['ResponseCode'] == "027" || $response->responseData['ResponseCode'] == "028" || $response->responseData['ResponseCode'] == "029") {

                                $reference_code = $response->responseData['ReceiptId'];



                                $cardDetails = AddCard::where('id', $req->card_id)->where('user_id', $thisuser->id)->first();

                                $cardNo = str_repeat("*", strlen($cardDetails->card_number) - 4) . substr($cardDetails->card_number, -4);

                                // Update Wallet Balance
                                $walletBal = $thisuser->wallet_balance;
                                $holdBal = $thisuser->hold_balance + $req->amounttosend;
                                // User::where('api_token', $req->bearerToken())->update(['wallet_balance' => $walletBal, 'hold_balance' => $holdBal]);

                                $userData = User::select('id', 'ref_code as refCode', 'name', 'email', 'telephone', 'wallet_balance as walletBalance', 'number_of_withdrawals as noOfWithdrawals')->where('api_token', $req->bearerToken())->first();

                                $activity = "Added " . $req->currencyCode . '' . number_format($req->amounttosend, 2) . " to Wallet including fee charge of " . $req->currencyCode . '' . number_format($req->commissiondeduct, 2) . " was deducted from Card: " . wordwrap($cardNo, 4, '-', true);
                                $credit = $req->amounttosend;
                                $debit = 0;
                                $reference_code = $response->responseData['ReceiptId'];
                                $balance = 0;
                                $trans_date = date('Y-m-d');
                                $status = "Delivered";
                                $action = "Wallet credit";
                                $regards = $thisuser->ref_code;
                                $statement_route = "wallet";

                                // Senders statement
                                // $this->insStatement($thisuser->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, $thisuser->country, 1);

                                // $this->getfeeTransaction($reference_code, $thisuser->ref_code, $req->amount, $req->commissiondeduct, $req->amounttosend);




                                // Notification


                                $this->name = $thisuser->name;
                                $this->email = $thisuser->email;
                                $this->subject = $req->currencyCode . ' ' . number_format($req->amounttosend, 2) . " now added to your wallet with PaySprint";

                                $this->message = '<p>You have added <strong>' . $req->currencyCode . ' ' . number_format($req->amounttosend, 2) . '</strong> <em>(Gross Amount of ' . $req->currencyCode . ' ' . number_format($grossAmount, 2) . ' less transaction fee ' . $req->currencyCode . ' ' . number_format($req->commissiondeduct, 2) . ')</em> to your wallet with PaySprint. Kindly allow up to 12-24 hours for the funds to reflect in your wallet. You have <strong>' . $req->currencyCode . ' ' . number_format($walletBal, 2) . '</strong> balance in your account</p>';

                                $sendMsg = 'You have added ' . $req->currencyCode . ' ' . number_format($req->amounttosend, 2) . ' (Gross Amount of ' . $req->currencyCode . ' ' . number_format($grossAmount, 2) . ' less transaction fee ' . $req->currencyCode . ' ' . number_format($req->commissiondeduct, 2) . ') to your wallet with PaySprint. You have ' . $req->currencyCode . ' ' . number_format($walletBal, 2) . ' balance in your account';

                                $userPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

                                if (isset($userPhone)) {

                                    $sendPhone = $thisuser->telephone;
                                } else {
                                    $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
                                }

                                if ($thisuser->country == "Nigeria") {

                                    $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                                    $this->sendSms($sendMsg, $correctPhone);
                                } else {
                                    $this->sendMessage($sendMsg, $sendPhone);
                                }

                                $this->sendEmail($this->email, "Fund remittance");

                                $userInfo = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol')->where('api_token', $req->bearerToken())->first();

                                $data = $userInfo;
                                $status = 200;
                                $message = 'You have successfully added ' . $req->currencyCode . ' ' . number_format($req->amounttosend, 2) . ' to your wallet';

                                // $this->createNotification($thisuser->ref_code, $sendMsg);

                                // Log::info('Congratulations!, '.$thisuser->name.' '.$sendMsg.". This is a test environment");

                                $this->slack('Congratulations!, ' . $thisuser->name . ' ' . $sendMsg . ". This is a test environment", $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));

                                $monerisactivity = $thisuser->name . ' ' . $sendMsg;
                                // $this->keepRecord($reference_code, $response->responseData['Message'], $monerisactivity, 'moneris', $thisuser->country);


                            } else {
                                $data = [];
                                $message = $response->responseData['Message'];
                                $status = 400;

                                // Log::critical('Oops!! '.$thisuser->name.' '.$message.". This is a test environment");

                                $this->slack('Oops!, ' . $thisuser->name . ' ' . $message . ". This is a test environment", $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));

                                $monerisactivity = $thisuser->name . ' ' . $message;
                                // $this->keepRecord("", $response->responseData['Message'], $monerisactivity, 'moneris', $thisuser->country);
                            }
                        }
                    }
                } else {

                    $error = implode(",", $validator->messages()->all());

                    $data = [];
                    $status = 400;
                    $message = $error;
                }
            } else {

                $gateway = "";

                $validator = Validator::make($req->all(), [
                    //  'card_id' => 'required|string',
                    'amount' => 'required|string',
                    'currencyCode' => 'required|string',
                    'conversionamount' => 'required|string',
                ]);

                if ($validator->passes()) {

                    $repayAmount = $this->repayOverdraft($thisuser->wallet_balance, $req->amounttosend, $thisuser->ref_code);

                    if ($req->commission == "on") {
                        $grossAmount = $req->amount;
                    } else {
                        $grossAmount = $req->amount + $req->commissiondeduct;
                    }

                    // Log::info($thisuser->name." wants to add ".$req->currencyCode." ".$req->amount." to their wallet.");


                    $this->slack($thisuser->name . " wants to add " . $req->currencyCode . " " . $req->amount . " to their wallet. Conversion amount " . $req->conversionamount, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));

                    // $monerisDeductamount = $req->conversionamount;
                    $monerisDeductamount = $req->amount;
                    // $monerisDeductamount = $this->currencyConvert($req->currencyCode, $req->amount);



                    $getGateway = AllCountries::where('name', $thisuser->country)->first();
                    if ($thisuser->country == "Canada" && $thisuser->approval < 2 && $thisuser->accountLevel <= 2) {

                        // If Account not approved then they cannot pay bills

                        // Cannot withdraw minimum balance

                        $data = [];
                        $message = "Please upload your Utility bill with your current address for verification";
                        $status = 400;

                        // Log::info('Oops!, '.$thisuser->name.' has '.$message);

                        $this->slack('Oops!, ' . $thisuser->name . ' has ' . $message, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));
                    } else {
                        if ($req->paymentToken != null && $thisuser->country != "Canada") {

                            $getTransactionCode = $this->verifyTransaction($req->paymentToken);

                            $gateway = ucfirst($getGateway->gateway);

                            if ($getTransactionCode->status == true) {

                                $referenced_code = $req->paymentToken;
                            } else {
                                $referenced_code = $req->paymentToken;
                            }


                            if ($thisuser->auto_credit == 1) {
                                $walletBal = $thisuser->wallet_balance + $repayAmount;
                                $holdBal = $thisuser->hold_balance;
                            } else {
                                $walletBal = $thisuser->wallet_balance;
                                $holdBal = $thisuser->hold_balance + $repayAmount;
                            }



                            // Update Wallet Balance

                            User::where('api_token', $req->bearerToken())->update(['wallet_balance' => $walletBal, 'hold_balance' => $holdBal]);


                            $userData = User::select('id', 'ref_code as refCode', 'name', 'email', 'telephone', 'wallet_balance as walletBalance', 'number_of_withdrawals as noOfWithdrawals')->where('api_token', $req->bearerToken())->first();

                            $activity = "Added " . $req->currencyCode . '' . number_format($repayAmount, 2) . " to Wallet including a fee charge of " . $req->currencyCode . '' . number_format($req->commissiondeduct, 2) . " was deducted from your Debit Card";
                            $credit = $repayAmount;
                            $debit = 0;
                            $reference_code = $referenced_code;
                            $balance = 0;
                            $trans_date = date('Y-m-d');
                            $status = "Delivered";
                            $action = "Wallet credit";
                            $regards = $thisuser->ref_code;
                            $statement_route = "wallet";

                            // Senders statement
                            $this->insStatement($thisuser->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, $thisuser->country, ($thisuser->auto_credit == 1 ? 0 : 1));

                            $this->getfeeTransaction($reference_code, $thisuser->ref_code, $req->amount, $req->commissiondeduct, $repayAmount);

                            // Notification


                            $this->name = $thisuser->name;
                            $this->email = $thisuser->email;
                            $this->subject = $req->currencyCode . ' ' . number_format($repayAmount, 2) . " now added to your wallet with PaySprint";

                            if ($thisuser->auto_credit == 1) {

                                $this->message = '<p>You have added <strong>' . $req->currencyCode . ' ' . number_format($repayAmount, 2) . '</strong> <em>(Gross Amount of ' . $req->currencyCode . ' ' . number_format($grossAmount, 2) . ' less transaction fee ' . $req->currencyCode . ' ' . number_format($req->commissiondeduct, 2) . ')</em> to your wallet with PaySprint. You have <strong>' . $req->currencyCode . ' ' . number_format($walletBal, 2) . '</strong> balance in your account</p>';

                                $sendMsg = 'You have added ' . $req->currencyCode . ' ' . number_format($repayAmount, 2) . ' (Gross Amount of ' . $req->currencyCode . ' ' . number_format($grossAmount, 2) . ' less transaction fee ' . $req->currencyCode . ' ' . number_format($req->commissiondeduct, 2) . ') to your wallet with PaySprint. You have ' . $req->currencyCode . ' ' . number_format($walletBal, 2) . ' balance in your account';
                            } else {

                                $this->message = '<p>You have added <strong>' . $req->currencyCode . ' ' . number_format($repayAmount, 2) . '</strong> <em>(Gross Amount of ' . $req->currencyCode . ' ' . number_format($grossAmount, 2) . ' less transaction fee ' . $req->currencyCode . ' ' . number_format($req->commissiondeduct, 2) . ')</em> to your wallet with PaySprint. Kindly allow up to 12-24 hours for the funds to reflect in your wallet. You have <strong>' . $req->currencyCode . ' ' . number_format($walletBal, 2) . '</strong> balance in your account</p>';

                                $sendMsg = 'You have added ' . $req->currencyCode . ' ' . number_format($repayAmount, 2) . ' (Gross Amount of ' . $req->currencyCode . ' ' . number_format($grossAmount, 2) . ' less transaction fee ' . $req->currencyCode . ' ' . number_format($req->commissiondeduct, 2) . ') to your wallet with PaySprint. Kindly allow up to 12-24 hours for the funds to reflect in your wallet. You have ' . $req->currencyCode . ' ' . number_format($walletBal, 2) . ' balance in your account';
                            }


                            $userPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

                            if (isset($userPhone)) {

                                $sendPhone = $thisuser->telephone;
                            } else {
                                $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
                            }

                            if ($thisuser->country == "Nigeria") {

                                $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                                $this->sendSms($sendMsg, $correctPhone);
                            } else {
                                $this->sendMessage($sendMsg, $sendPhone);
                            }






                            $checkBVN = $this->bvnVerificationCharge($req->bearerToken());

                            if ($checkBVN == "charge") {

                                $getUser = User::where('api_token', $req->bearerToken())->first();
                                // Update Wallet Balance
                                $walletBalance = $getUser->wallet_balance - 15;
                                User::where('api_token', $req->bearerToken())->update(['wallet_balance' => $walletBalance, 'bvn_verification' => 2]);

                                $activity = "Bank Verification (BVN) Charge of " . $req->currencyCode . '' . number_format(15, 2) . " was deducted from your Wallet";
                                $credit = 0;
                                $debit = 15;
                                $reference_number = "wallet-" . date('dmY') . time();
                                $balance = 0;
                                $trans_date = date('Y-m-d');
                                $status = "Delivered";
                                $action = "Wallet debit";
                                $regards = $getUser->ref_code;
                                $statement_route = "wallet";

                                // Senders statement
                                $this->insStatement($thisuser->email, $reference_number, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, $thisuser->country, 0);

                                $this->getfeeTransaction($reference_number, $thisuser->ref_code, 15, 0, 15);

                                $sendMsg = $activity . '. You have ' . $req->currencyCode . ' ' . number_format($walletBalance, 2) . ' balance in your account';

                                $userPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

                                if (isset($userPhone)) {

                                    $sendPhone = $thisuser->telephone;
                                } else {
                                    $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
                                }

                                if ($thisuser->country == "Nigeria") {

                                    $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                                    $this->sendSms($sendMsg, $correctPhone);
                                } else {
                                    $this->sendMessage($sendMsg, $sendPhone);
                                }
                            }




                            $userInfo = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol')->where('api_token', $req->bearerToken())->first();

                            $data = $userInfo;
                            $status = 200;
                            $message = 'You have successfully added ' . $req->currencyCode . ' ' . number_format($repayAmount, 2) . ' to your wallet';

                            $this->createNotification($thisuser->ref_code, $sendMsg, $thisuser->playerId, $sendMsg, "Wallet Transaction");

                            $this->keepRecord($referenced_code, $message, "Success", $gateway, $thisuser->country, ($thisuser->auto_credit == 1 ? 0 : 1));

                            $this->updatePoints($thisuser->id, 'Add money');

                            // Log::info('Congratulations!, '.$thisuser->name.' '.$sendMsg);

                            $this->chargeForShuftiProVerification($thisuser->ref_code, $thisuser->currencyCode);

                            $this->slack('Congratulations!, ' . $thisuser->name . ' ' . $sendMsg, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));

                            $this->sendEmail($this->email, "Fund remittance");

                            $adminMessage = "<p>Transaction ID: " . $reference_code . "</p><p>Name: " . $thisuser->name . "</p><p>Account Number: " . $thisuser->ref_code . "</p><p>Country: " . $thisuser->country . "</p><p>Date: " . date('d/m/Y h:i:a') . "</p><p>Amount: " . $req->currencyCode . ' ' . number_format($repayAmount, 2) . "</p><p>Status: Successful</p>";

                            $this->notifyAdmin($gateway . " inflow", $adminMessage);
                        } else {


                            if ($thisuser->country == "United States" || $thisuser->country == "USA" || $thisuser->country == "United States of America") {

                                // $response = $this->monerisWalletProcess($req->bearerToken(), $req->card_id, $repayAmount, "purchase", "PaySprint/Vimfile Add Money to the Wallet of ".$thisuser->name, $req->mode);


                                $response = $this->fortisPay($repayAmount, $req->card_id, $thisuser->zip, $thisuser->name, $thisuser->email, $thisuser->telephone, $thisuser->city, $thisuser->state, "live");




                                if ($response->status != 401) {


                                    $responseCode = $response->transaction->reason_code_id;


                                    switch ($responseCode) {
                                        case 1000:
                                            $responseMessage = "Approved";
                                            break;
                                        case 1001:
                                            $responseMessage = "AuthCompleted";
                                            break;
                                        case 1002:
                                            $responseMessage = "Forced";
                                            break;
                                        case 1003:
                                            $responseMessage = "AuthOnly Declined";
                                            break;
                                        case 1004:
                                            $responseMessage = "Validation Failure (System Run Trx)";
                                            break;
                                        case 1005:
                                            $responseMessage = "Processor Response Invalid";
                                            break;
                                        case 1200:
                                            $responseMessage = "Voided";
                                            break;
                                        case 1240:
                                            $responseMessage = "Approved, optional fields are missing (Paya ACH only)";
                                            break;
                                        case 1500:
                                            $responseMessage = "Generic Decline";
                                            break;
                                        case 1510:
                                            $responseMessage = "Call";
                                            break;
                                        case 1518:
                                            $responseMessage = "Transaction Not Permitted - Terminal";
                                            break;
                                        case 1520:
                                            $responseMessage = "Pickup Card";
                                            break;
                                        case 1530:
                                            $responseMessage = "Retry Trx";
                                            break;
                                        case 1531:
                                            $responseMessage = "Communication Error";
                                            break;
                                        case 1540:
                                            $responseMessage = "Setup Issue, contact Support";
                                            break;
                                        case 1541:
                                            $responseMessage = "Device is not signature capable";
                                            break;
                                        case 1588:
                                            $responseMessage = "Data could not be de-tokenized";
                                            break;
                                        case 1599:
                                            $responseMessage = "Other Reason";
                                            break;
                                        case 1601:
                                            $responseMessage = "Generic Decline";
                                            break;
                                        case 1602:
                                            $responseMessage = "Call";
                                            break;
                                        case 1603:
                                            $responseMessage = "No Reply";
                                            break;
                                        case 1604:
                                            $responseMessage = "Pickup Card - No Fraud";
                                            break;
                                        case 1605:
                                            $responseMessage = "Pickup Card - Fraud";
                                            break;
                                        case 1606:
                                            $responseMessage = "Pickup Card - Lost";
                                            break;
                                        case 1607:
                                            $responseMessage = "Pickup Card - Stolen";
                                            break;
                                        case 1608:
                                            $responseMessage = "Account Error";
                                            break;
                                        case 1609:
                                            $responseMessage = "Already Reversed";
                                            break;
                                        case 1610:
                                            $responseMessage = "Bad PIN";
                                            break;
                                        case 1611:
                                            $responseMessage = "Cashback Exceeded";
                                            break;
                                        case 1612:
                                            $responseMessage = "Cashback Not Available";
                                            break;
                                        case 1613:
                                            $responseMessage = "CID Error";
                                            break;
                                        case 1614:
                                            $responseMessage = "Date Error";
                                            break;
                                        case 1615:
                                            $responseMessage = "Do Not Honor";
                                            break;
                                        case 1616:
                                            $responseMessage = "NSF";
                                            break;
                                        case 1617:
                                            $responseMessage = "Exceeded Withdrawal Limit";
                                            break;
                                        case 1618:
                                            $responseMessage = "Invalid Service Code";
                                            break;
                                        case 1619:
                                            $responseMessage = "Exceeded activity limit";
                                            break;
                                        case 1620:
                                            $responseMessage = "Violation";
                                            break;
                                        case 1621:
                                            $responseMessage = "Encryption Error";
                                            break;
                                        case 1622:
                                            $responseMessage = "Card Expired";
                                            break;
                                        case 1623:
                                            $responseMessage = "Renter";
                                            break;
                                        case 1624:
                                            $responseMessage = "Security Violation";
                                            break;
                                        case 1625:
                                            $responseMessage = "Card Not Permitted";
                                            break;
                                        case 1626:
                                            $responseMessage = "Trans Not Permitted";
                                            break;
                                        case 1627:
                                            $responseMessage = "System Error";
                                            break;
                                        case 1628:
                                            $responseMessage = "Bad Merchant ID";
                                            break;
                                        case 1629:
                                            $responseMessage = "Duplicate Batch (Already Closed)";
                                            break;
                                        case 1630:
                                            $responseMessage = "Batch Rejected";
                                            break;
                                        case 1631:
                                            $responseMessage = "Account Closed";
                                            break;
                                        case 1640:
                                            $responseMessage = "Required fields are missing (ACH only)";
                                            break;
                                        case 1641:
                                            $responseMessage = "Previously declined transaction (1640)";
                                            break;
                                        case 1651:
                                            $responseMessage = "Max Sending - Throttle Limit Hit (ACH only)";
                                            break;
                                        case 1652:
                                            $responseMessage = "Max Attempts Exceeded";
                                            break;
                                        case 1653:
                                            $responseMessage = "Contact Support";
                                            break;
                                        case 1654:
                                            $responseMessage = "Voided - Online Reversal Failed";
                                            break;
                                        case 1655:
                                            $responseMessage = "Decline (AVS Auto Reversal)";
                                            break;
                                        case 1656:
                                            $responseMessage = "Decline (Partial Auth Auto Reversal)";
                                            break;
                                        case 1657:
                                            $responseMessage = "Decline (Partial Auth Auto Reversal)";
                                            break;
                                        case 1658:
                                            $responseMessage = "Expired Authorization";
                                            break;
                                        case 1659:
                                            $responseMessage = "Declined - Partial Approval not Supported";
                                            break;
                                        case 1660:
                                            $responseMessage = "Bank Account Error, please delete and re-add Account Vault";
                                            break;
                                        case 1661:
                                            $responseMessage = "Declined AuthIncrement";
                                            break;
                                        case 1662:
                                            $responseMessage = "Auto Reversal - Processor can't settle";
                                            break;
                                        case 1663:
                                            $responseMessage = "Manager Needed (Needs override transaction)";
                                            break;
                                        case 1664:
                                            $responseMessage = "Account Vault Not Found: Sharing Group Unavailable";
                                            break;
                                        case 1665:
                                            $responseMessage = "Contact Not Found: Sharing Group Unavailable";
                                            break;
                                        case 1701:
                                            $responseMessage = "Chip Reject";
                                            break;
                                        case 1800:
                                            $responseMessage = "Incorrect CVV";
                                            break;
                                        case 1801:
                                            $responseMessage = "Duplicate Transaction";
                                            break;
                                        case 1802:
                                            $responseMessage = "MID/TID Not Registered";
                                            break;
                                        case 1803:
                                            $responseMessage = "Stop Recurring";
                                            break;
                                        case 1804:
                                            $responseMessage = "No Transactions in Batch";
                                            break;
                                        case 1805:
                                            $responseMessage = "Batch Does Not Exist";
                                            break;

                                        default:
                                            $responseMessage = "N/A";
                                    }


                                    if ($response->transaction->reason_code_id == 1000) {

                                        $reference_code = $response->transaction->id;

                                        $gateway = "Fortispay";



                                        $cardDetails = AddCard::where('id', $req->card_id)->where('user_id', $thisuser->id)->first();

                                        $cardNo = str_repeat("*", strlen($cardDetails->card_number) - 4) . substr($cardDetails->card_number, -4);


                                        if ($thisuser->auto_credit == 1) {
                                            // Update Wallet Balance
                                            $walletBal = $thisuser->wallet_balance + $repayAmount;
                                            $holdBal = $thisuser->hold_balance;
                                        } else {
                                            // Update Wallet Balance
                                            $walletBal = $thisuser->wallet_balance;
                                            $holdBal = $thisuser->hold_balance + $repayAmount;
                                        }



                                        User::where('api_token', $req->bearerToken())->update(['wallet_balance' => $walletBal, 'hold_balance' => $holdBal]);

                                        $userData = User::select('id', 'ref_code as refCode', 'name', 'email', 'telephone', 'wallet_balance as walletBalance', 'number_of_withdrawals as noOfWithdrawals')->where('api_token', $req->bearerToken())->first();

                                        $activity = "Added " . $req->currencyCode . '' . number_format($repayAmount, 2) . " to Wallet including fee charge of " . $req->currencyCode . '' . number_format($req->commissiondeduct, 2) . " was deducted from Card: " . wordwrap($cardNo, 4, '-', true);
                                        $credit = $repayAmount;
                                        $debit = 0;
                                        $reference_code = $response->transaction->id;
                                        $balance = 0;
                                        $trans_date = date('Y-m-d');
                                        $status = "Delivered";
                                        $action = "Wallet credit";
                                        $regards = $thisuser->ref_code;
                                        $statement_route = "wallet";

                                        // Senders statement
                                        $this->insStatement($thisuser->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, $thisuser->country, ($thisuser->auto_credit == 1 ? 0 : 1));

                                        $this->getfeeTransaction($reference_code, $thisuser->ref_code, $req->amount, $req->commissiondeduct, $repayAmount);




                                        // Notification


                                        $this->name = $thisuser->name;
                                        $this->email = $thisuser->email;
                                        $this->subject = $req->currencyCode . ' ' . number_format($repayAmount, 2) . " now added to your wallet with PaySprint";


                                        if ($thisuser->auto_credit == 1) {
                                            $this->message = '<p>You have added <strong>' . $req->currencyCode . ' ' . number_format($repayAmount, 2) . '</strong> <em>(Gross Amount of ' . $req->currencyCode . ' ' . number_format($grossAmount, 2) . ' less transaction fee ' . $req->currencyCode . ' ' . number_format($req->commissiondeduct, 2) . ')</em> to your wallet with PaySprint. You have <strong>' . $req->currencyCode . ' ' . number_format($walletBal, 2) . '</strong> balance in your account</p>';

                                            $sendMsg = 'You have added ' . $req->currencyCode . ' ' . number_format($repayAmount, 2) . ' (Gross Amount of ' . $req->currencyCode . ' ' . number_format($grossAmount, 2) . ' less transaction fee ' . $req->currencyCode . ' ' . number_format($req->commissiondeduct, 2) . ') to your wallet with PaySprint. You have ' . $req->currencyCode . ' ' . number_format($walletBal, 2) . ' balance in your account';
                                        } else {
                                            $this->message = '<p>You have added <strong>' . $req->currencyCode . ' ' . number_format($repayAmount, 2) . '</strong> <em>(Gross Amount of ' . $req->currencyCode . ' ' . number_format($grossAmount, 2) . ' less transaction fee ' . $req->currencyCode . ' ' . number_format($req->commissiondeduct, 2) . ')</em> to your wallet with PaySprint. Kindly allow up to 12-24 hours for the funds to reflect in your wallet.  You have <strong>' . $req->currencyCode . ' ' . number_format($walletBal, 2) . '</strong> balance in your account</p>';

                                            $sendMsg = 'You have added ' . $req->currencyCode . ' ' . number_format($repayAmount, 2) . ' (Gross Amount of ' . $req->currencyCode . ' ' . number_format($grossAmount, 2) . ' less transaction fee ' . $req->currencyCode . ' ' . number_format($req->commissiondeduct, 2) . ') to your wallet with PaySprint. Kindly allow up to 12-24 hours for the funds to reflect in your wallet.  You have ' . $req->currencyCode . ' ' . number_format($walletBal, 2) . ' balance in your account';
                                        }



                                        $userPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

                                        if (isset($userPhone)) {

                                            $sendPhone = $thisuser->telephone;
                                        } else {
                                            $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
                                        }

                                        if ($thisuser->country == "Nigeria") {

                                            $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                                            $this->sendSms($sendMsg, $correctPhone);
                                        } else {
                                            $this->sendMessage($sendMsg, $sendPhone);
                                        }

                                        $this->sendEmail($this->email, "Fund remittance");




                                        $userInfo = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol')->where('api_token', $req->bearerToken())->first();

                                        $data = $userInfo;
                                        $status = 200;
                                        $message = 'You have successfully added ' . $req->currencyCode . ' ' . number_format($repayAmount, 2) . ' to your wallet';

                                        $this->createNotification($thisuser->ref_code, $sendMsg, $thisuser->playerId, $sendMsg, "Wallet Transaction");

                                        $this->updatePoints($thisuser->id, 'Add money');

                                        // Log::info('Congratulations!, '.$thisuser->name.' '.$sendMsg);

                                        $this->chargeForShuftiProVerification($thisuser->ref_code, $thisuser->currencyCode);

                                        $this->slack('Congratulations!, ' . $thisuser->name . ' ' . $sendMsg, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));

                                        $monerisactivity = $thisuser->name . ' ' . $sendMsg;
                                        $this->keepRecord($reference_code, $responseCode, $monerisactivity, $gateway, $thisuser->country, ($thisuser->auto_credit == 1 ? 0 : 1));

                                        $adminMessage = "<p>Transaction ID: " . $reference_code . "</p><p>Name: " . $thisuser->name . "</p><p>Account Number: " . $thisuser->ref_code . "</p><p>Country: " . $thisuser->country . "</p><p>Date: " . date('d/m/Y h:i:a') . "</p><p>Amount: " . $req->currencyCode . ' ' . number_format($repayAmount, 2) . "</p><p>Status: Successful</p>";

                                        $this->notifyAdmin($gateway . " inflow", $adminMessage);
                                    } else {
                                        $data = [];
                                        $message = $responseCode;
                                        $status = 400;

                                        $gateway = "Fortispay";

                                        // Log::critical('Oops!! '.$thisuser->name.' '.$message);

                                        $this->slack('Oops!, ' . $thisuser->name . ' ' . $message, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));

                                        $monerisactivity = $thisuser->name . ' ' . $message;
                                        $this->keepRecord("", $responseCode, $monerisactivity, $gateway, $thisuser->country, 0);
                                    }
                                } else {

                                    $response = $this->monerisWalletProcess($req->bearerToken(), $req->card_id, $monerisDeductamount, "purchase", "PaySprint/Vimfile Add Money to the Wallet of " . $thisuser->name, $req->mode);


                                    if ($response->responseData['ResponseCode'] == "000" || $response->responseData['ResponseCode'] == "001" || $response->responseData['ResponseCode'] == "002" || $response->responseData['ResponseCode'] == "003" || $response->responseData['ResponseCode'] == "004" || $response->responseData['ResponseCode'] == "005" || $response->responseData['ResponseCode'] == "006" || $response->responseData['ResponseCode'] == "007" || $response->responseData['ResponseCode'] == "008" || $response->responseData['ResponseCode'] == "009" || $response->responseData['ResponseCode'] == "010" || $response->responseData['ResponseCode'] == "023" || $response->responseData['ResponseCode'] == "024" || $response->responseData['ResponseCode'] == "025" || $response->responseData['ResponseCode'] == "026" || $response->responseData['ResponseCode'] == "027" || $response->responseData['ResponseCode'] == "028" || $response->responseData['ResponseCode'] == "029") {

                                        $reference_code = $response->responseData['ReceiptId'];



                                        $cardDetails = AddCard::where('id', $req->card_id)->where('user_id', $thisuser->id)->first();

                                        $cardNo = str_repeat("*", strlen($cardDetails->card_number) - 4) . substr($cardDetails->card_number, -4);


                                        if ($thisuser->auto_credit == 1) {
                                            // Update Wallet Balance
                                            $walletBal = $thisuser->wallet_balance + $repayAmount;
                                            $holdBal = $thisuser->hold_balance;
                                        } else {
                                            // Update Wallet Balance
                                            $walletBal = $thisuser->wallet_balance;
                                            $holdBal = $thisuser->hold_balance + $repayAmount;
                                        }


                                        User::where('api_token', $req->bearerToken())->update(['wallet_balance' => $walletBal, 'hold_balance' => $holdBal]);

                                        $userData = User::select('id', 'ref_code as refCode', 'name', 'email', 'telephone', 'wallet_balance as walletBalance', 'number_of_withdrawals as noOfWithdrawals')->where('api_token', $req->bearerToken())->first();

                                        $activity = "Added " . $req->currencyCode . '' . number_format($repayAmount, 2) . " to Wallet including fee charge of " . $req->currencyCode . '' . number_format($req->commissiondeduct, 2) . " was deducted from Card: " . wordwrap($cardNo, 4, '-', true);
                                        $credit = $repayAmount;
                                        $debit = 0;
                                        $reference_code = $response->responseData['ReceiptId'];
                                        $balance = 0;
                                        $trans_date = date('Y-m-d');
                                        $status = "Delivered";
                                        $action = "Wallet credit";
                                        $regards = $thisuser->ref_code;
                                        $statement_route = "wallet";

                                        // Senders statement
                                        $this->insStatement($thisuser->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, $thisuser->country, ($thisuser->auto_credit == 1 ? 0 : 1));

                                        $this->getfeeTransaction($reference_code, $thisuser->ref_code, $req->amount, $req->commissiondeduct, $repayAmount);




                                        // Notification


                                        $this->name = $thisuser->name;
                                        $this->email = $thisuser->email;
                                        $this->subject = $req->currencyCode . ' ' . number_format($repayAmount, 2) . " now added to your wallet with PaySprint";

                                        if ($thisuser->auto_credit == 1) {
                                            $this->message = '<p>You have added <strong>' . $req->currencyCode . ' ' . number_format($repayAmount, 2) . '</strong> <em>(Gross Amount of ' . $req->currencyCode . ' ' . number_format($grossAmount, 2) . ' less transaction fee ' . $req->currencyCode . ' ' . number_format($req->commissiondeduct, 2) . ')</em> to your wallet with PaySprint. You have <strong>' . $req->currencyCode . ' ' . number_format($walletBal, 2) . '</strong> balance in your account</p>';

                                            $sendMsg = 'You have added ' . $req->currencyCode . ' ' . number_format($repayAmount, 2) . ' (Gross Amount of ' . $req->currencyCode . ' ' . number_format($grossAmount, 2) . ' less transaction fee ' . $req->currencyCode . ' ' . number_format($req->commissiondeduct, 2) . ') to your wallet with PaySprint. You have ' . $req->currencyCode . ' ' . number_format($walletBal, 2) . ' balance in your account';
                                        } else {
                                            $this->message = '<p>You have added <strong>' . $req->currencyCode . ' ' . number_format($repayAmount, 2) . '</strong> <em>(Gross Amount of ' . $req->currencyCode . ' ' . number_format($grossAmount, 2) . ' less transaction fee ' . $req->currencyCode . ' ' . number_format($req->commissiondeduct, 2) . ')</em> to your wallet with PaySprint. Kindly allow up to 12-24 hours for the funds to reflect in your wallet.  You have <strong>' . $req->currencyCode . ' ' . number_format($walletBal, 2) . '</strong> balance in your account</p>';

                                            $sendMsg = 'You have added ' . $req->currencyCode . ' ' . number_format($repayAmount, 2) . ' (Gross Amount of ' . $req->currencyCode . ' ' . number_format($grossAmount, 2) . ' less transaction fee ' . $req->currencyCode . ' ' . number_format($req->commissiondeduct, 2) . ') to your wallet with PaySprint. Kindly allow up to 12-24 hours for the funds to reflect in your wallet.  You have ' . $req->currencyCode . ' ' . number_format($walletBal, 2) . ' balance in your account';
                                        }



                                        $userPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

                                        if (isset($userPhone)) {

                                            $sendPhone = $thisuser->telephone;
                                        } else {
                                            $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
                                        }

                                        if ($thisuser->country == "Nigeria") {

                                            $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                                            $this->sendSms($sendMsg, $correctPhone);
                                        } else {
                                            $this->sendMessage($sendMsg, $sendPhone);
                                        }

                                        $this->sendEmail($this->email, "Fund remittance");




                                        $userInfo = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol')->where('api_token', $req->bearerToken())->first();

                                        $data = $userInfo;
                                        $status = 200;
                                        $message = 'You have successfully added ' . $req->currencyCode . ' ' . number_format($repayAmount, 2) . ' to your wallet';

                                        $this->createNotification($thisuser->ref_code, $sendMsg, $thisuser->playerId, $sendMsg, "Wallet Transaction");

                                        $this->updatePoints($thisuser->id, 'Add money');


                                        $this->chargeForShuftiProVerification($thisuser->ref_code, $thisuser->currencyCode);
                                        // Log::info('Congratulations!, '.$thisuser->name.' '.$sendMsg);

                                        $this->slack('Congratulations!, ' . $thisuser->name . ' ' . $sendMsg, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));

                                        $monerisactivity = $thisuser->name . ' ' . $sendMsg;
                                        $this->keepRecord($reference_code, $response->responseData['Message'], $monerisactivity, 'moneris', $thisuser->country, ($thisuser->auto_credit == 1 ? 0 : 1));


                                        $adminMessage = "<p>Transaction ID: " . $reference_code . "</p><p>Name: " . $thisuser->name . "</p><p>Account Number: " . $thisuser->ref_code . "</p><p>Country: " . $thisuser->country . "</p><p>Date: " . date('d/m/Y h:i:a') . "</p><p>Amount: " . $req->currencyCode . ' ' . number_format($repayAmount, 2) . "</p><p>Status: Successful</p>";

                                        $this->notifyAdmin($gateway . " inflow", $adminMessage);
                                    } else {
                                        $data = [];
                                        $message = $response->responseData['Message'] . " If the error persists, kindly login on the web app at https://paysprint.ca to continue your transactions.";
                                        $status = 400;

                                        // Log::critical('Oops!! '.$thisuser->name.' '.$message);

                                        $this->slack('Oops!, ' . $thisuser->name . ' ' . $message, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));

                                        $monerisactivity = $thisuser->name . ' ' . $message;
                                        $this->keepRecord("", $response->responseData['Message'], $monerisactivity, 'moneris', $thisuser->country, 0);
                                    }
                                }
                            } elseif ($thisuser->country == "Nigeria") {

                                $data = [];
                                $message = "We cannot process your transaction. Kindly update your app from the Play Store or App Store. Thanks";
                                $status = 400;

                                // Log::critical('Oops!! '.$thisuser->name.' '.$message);

                                $this->slack('Oops!, ' . $thisuser->name . ' ' . $message, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));
                            } else {

                                $this->slack($thisuser->name . " add money to wallet access on live for:: " . $req->currencyCode . " " . $req->amount . " to their wallet.", $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));

                                $response = $this->monerisWalletProcess($req->bearerToken(), $req->card_id, $monerisDeductamount, "purchase", "PaySprint/Vimfile Add Money to the Wallet of " . $thisuser->name, $req->mode);


                                if ($response->responseData['ResponseCode'] == "000" || $response->responseData['ResponseCode'] == "001" || $response->responseData['ResponseCode'] == "002" || $response->responseData['ResponseCode'] == "003" || $response->responseData['ResponseCode'] == "004" || $response->responseData['ResponseCode'] == "005" || $response->responseData['ResponseCode'] == "006" || $response->responseData['ResponseCode'] == "007" || $response->responseData['ResponseCode'] == "008" || $response->responseData['ResponseCode'] == "009" || $response->responseData['ResponseCode'] == "010" || $response->responseData['ResponseCode'] == "023" || $response->responseData['ResponseCode'] == "024" || $response->responseData['ResponseCode'] == "025" || $response->responseData['ResponseCode'] == "026" || $response->responseData['ResponseCode'] == "027" || $response->responseData['ResponseCode'] == "028" || $response->responseData['ResponseCode'] == "029") {

                                    $reference_code = $response->responseData['ReceiptId'];



                                    $cardDetails = AddCard::where('id', $req->card_id)->where('user_id', $thisuser->id)->first();

                                    $cardNo = str_repeat("*", strlen($cardDetails->card_number) - 4) . substr($cardDetails->card_number, -4);

                                    if ($thisuser->auto_credit == 1) {
                                        // Update Wallet Balance
                                        $walletBal = $thisuser->wallet_balance + $repayAmount;
                                        $holdBal = $thisuser->hold_balance;
                                    } else {
                                        // Update Wallet Balance
                                        $walletBal = $thisuser->wallet_balance;
                                        $holdBal = $thisuser->hold_balance + $repayAmount;
                                    }


                                    User::where('api_token', $req->bearerToken())->update(['wallet_balance' => $walletBal, 'hold_balance' => $holdBal]);

                                    $userData = User::select('id', 'ref_code as refCode', 'name', 'email', 'telephone', 'wallet_balance as walletBalance', 'number_of_withdrawals as noOfWithdrawals')->where('api_token', $req->bearerToken())->first();

                                    $activity = "Added " . $req->currencyCode . '' . number_format($repayAmount, 2) . " to Wallet including fee charge of " . $req->currencyCode . '' . number_format($req->commissiondeduct, 2) . " was deducted from Card: " . wordwrap($cardNo, 4, '-', true);
                                    $credit = $repayAmount;
                                    $debit = 0;
                                    $reference_code = $response->responseData['ReceiptId'];
                                    $balance = 0;
                                    $trans_date = date('Y-m-d');
                                    $status = "Delivered";
                                    $action = "Wallet credit";
                                    $regards = $thisuser->ref_code;
                                    $statement_route = "wallet";

                                    // Senders statement
                                    $this->insStatement($thisuser->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, $thisuser->country, ($thisuser->auto_credit == 1 ? 0 : 1));

                                    $this->getfeeTransaction($reference_code, $thisuser->ref_code, $req->amount, $req->commissiondeduct, $repayAmount);




                                    // Notification


                                    $this->name = $thisuser->name;
                                    $this->email = $thisuser->email;
                                    $this->subject = $req->currencyCode . ' ' . number_format($repayAmount, 2) . " now added to your wallet with PaySprint";

                                    if ($thisuser->auto_credit == 1) {

                                        $this->message = '<p>You have added <strong>' . $req->currencyCode . ' ' . number_format($repayAmount, 2) . '</strong> <em>(Gross Amount of ' . $req->currencyCode . ' ' . number_format($grossAmount, 2) . ' less transaction fee ' . $req->currencyCode . ' ' . number_format($req->commissiondeduct, 2) . ')</em> to your wallet with PaySprint. You have <strong>' . $req->currencyCode . ' ' . number_format($walletBal, 2) . '</strong> balance in your account</p>';

                                        $sendMsg = 'You have added ' . $req->currencyCode . ' ' . number_format($repayAmount, 2) . ' (Gross Amount of ' . $req->currencyCode . ' ' . number_format($grossAmount, 2) . ' less transaction fee ' . $req->currencyCode . ' ' . number_format($req->commissiondeduct, 2) . ') to your wallet with PaySprint. You have ' . $req->currencyCode . ' ' . number_format($walletBal, 2) . ' balance in your account';
                                    } else {
                                        $this->message = '<p>You have added <strong>' . $req->currencyCode . ' ' . number_format($repayAmount, 2) . '</strong> <em>(Gross Amount of ' . $req->currencyCode . ' ' . number_format($grossAmount, 2) . ' less transaction fee ' . $req->currencyCode . ' ' . number_format($req->commissiondeduct, 2) . ')</em> to your wallet with PaySprint. Kindly allow up to 12-24 hours for the funds to reflect in your wallet. You have <strong>' . $req->currencyCode . ' ' . number_format($walletBal, 2) . '</strong> balance in your account</p>';

                                        $sendMsg = 'You have added ' . $req->currencyCode . ' ' . number_format($repayAmount, 2) . ' (Gross Amount of ' . $req->currencyCode . ' ' . number_format($grossAmount, 2) . ' less transaction fee ' . $req->currencyCode . ' ' . number_format($req->commissiondeduct, 2) . ') to your wallet with PaySprint. Kindly allow up to 12-24 hours for the funds to reflect in your wallet. You have ' . $req->currencyCode . ' ' . number_format($walletBal, 2) . ' balance in your account';
                                    }



                                    $userPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

                                    if (isset($userPhone)) {

                                        $sendPhone = $thisuser->telephone;
                                    } else {
                                        $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
                                    }

                                    if ($thisuser->country == "Nigeria") {

                                        $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                                        $this->sendSms($sendMsg, $correctPhone);
                                    } else {
                                        $this->sendMessage($sendMsg, $sendPhone);
                                    }

                                    $this->sendEmail($this->email, "Fund remittance");


                                    $userInfo = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol')->where('api_token', $req->bearerToken())->first();

                                    $data = $userInfo;
                                    $status = 200;
                                    $message = 'You have successfully added ' . $req->currencyCode . ' ' . number_format($repayAmount, 2) . ' to your wallet';

                                    $this->createNotification($thisuser->ref_code, $sendMsg, $thisuser->playerId, $sendMsg, "Wallet Transaction");

                                    $this->updatePoints($thisuser->id, 'Add money');

                                    // Log::info('Congratulations!, '.$thisuser->name.' '.$sendMsg);

                                    $this->chargeForShuftiProVerification($thisuser->ref_code, $thisuser->currencyCode);

                                    $this->slack('Congratulations!, ' . $thisuser->name . ' ' . $sendMsg, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));

                                    $monerisactivity = $thisuser->name . ' ' . $sendMsg;
                                    $this->keepRecord($reference_code, $response->responseData['Message'], $monerisactivity, 'moneris', $thisuser->country, ($thisuser->auto_credit == 1 ? 0 : 1));

                                    $adminMessage = "<p>Transaction ID: " . $reference_code . "</p><p>Name: " . $thisuser->name . "</p><p>Account Number: " . $thisuser->ref_code . "</p><p>Country: " . $thisuser->country . "</p><p>Date: " . date('d/m/Y h:i:a') . "</p><p>Amount: " . $req->currencyCode . ' ' . number_format($repayAmount, 2) . "</p><p>Status: Successful</p>";

                                    $this->notifyAdmin($gateway . " inflow", $adminMessage);
                                } else {
                                    $data = [];
                                    $message = $response->responseData['Message'] . " If the error persists, kindly login on the web app at https://paysprint.ca to continue your transactions.";
                                    $status = 400;

                                    // Log::critical('Oops!! '.$thisuser->name.' '.$message);


                                    // TODO:: Add the security checker trait module here and pass the userId...
                                    $this->checkTransaction($thisuser->id, $response->responseData['Message']);

                                    $this->slack('Oops!, ' . $thisuser->name . ' ' . $message, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));

                                    $monerisactivity = $thisuser->name . ' ' . $message;
                                    $this->keepRecord("", $response->responseData['Message'], $monerisactivity, 'moneris', $thisuser->country, 0);
                                }
                            }
                        }
                    }
                } else {

                    $error = implode(",", $validator->messages()->all());

                    $data = [];
                    $status = 400;
                    $message = $error;
                }
            }
        }

        // Write for Test




        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

        return $this->returnJSON($resData, $status);
    }

    // Charge money for shufti pro verification

    public function chargeForShuftiProVerification($ref_code, $currencyCode)
    {

        $shuftiPro = new ShuftiProController();
        $converter = new CurrencyConverterApiController();

        // Shuftipro charge in USD 4;
        $charge = 4;

        $checkStatus = $shuftiPro->shuftiProPaymentVerification($ref_code, $currencyCode);

        if ($checkStatus === false) {

            $getUser = User::where('ref_code', $ref_code)->first();
            // Update Wallet Balance

            // Convert to currency charge...

            $deductValue = $converter->randomCurrencyConverter($currencyCode, $charge);


            if ((float)$getUser->wallet_balance > $deductValue) {
                $walletBalance = $getUser->wallet_balance - $deductValue;
                User::where('ref_code', $ref_code)->update(['wallet_balance' => $walletBalance, 'shuftiproservice' => 1]);

                $activity = "Anti-Money Laundry (AML) Fee Charge of " . $currencyCode . '' . number_format($deductValue, 2) . " was deducted from your Wallet";
                $credit = 0;
                $debit = $deductValue;
                $reference_number = "wallet-" . date('dmY') . time();
                $balance = 0;
                $trans_date = date('Y-m-d');
                $status = "Delivered";
                $action = "Wallet debit";
                $regards = $getUser->ref_code;
                $statement_route = "wallet";

                // Senders statement
                $this->insStatement($getUser->email, $reference_number, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, $getUser->country, 0);

                $this->getfeeTransaction($reference_number, $getUser->ref_code, $deductValue, 0, $deductValue);

                $sendMsg = $activity . '. You have ' . $currencyCode . ' ' . number_format($walletBalance, 2) . ' balance in your account';

                $userPhone = User::where('email', $getUser->email)->where('telephone', 'LIKE', '%+%')->first();

                if (isset($userPhone)) {

                    $sendPhone = $getUser->telephone;
                } else {
                    $sendPhone = "+" . $getUser->code . $getUser->telephone;
                }

                if ($getUser->country == "Nigeria") {

                    $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                    $this->sendSms($sendMsg, $correctPhone);
                } else {
                    $this->sendMessage($sendMsg, $sendPhone);
                }
            }
        }
    }


    public function moneyWithdrawal(Request $req)
    {


        $thisuser = User::where('api_token', $req->bearerToken())->first();

        if ($req->amount < 0) {
            $data = [];
            $message = "Please enter a positive amount to withdraw";
            $status = 400;
        } else {


            if ($thisuser->flagged === 1) {
                $data = [];
                $message = 'Hello ' . $thisuser->name . ', Access to the account is not currently available. Kindly contact the Admin using this link: https://paysprint.ca/contact.';
                $status = 400;
            } else {
                if (isset($req->mode) && $req->mode == "test") {


                    $validator = Validator::make($req->all(), [
                        //  'card_id' => 'required|string',
                        'amount' => 'required|string',
                        'transaction_pin' => 'required|string',
                        'currencyCode' => 'required|string',
                        'conversionamount' => 'required|string',
                        'card_type' => 'required|string',
                        'amounttosend' => 'required|string',
                        'commissiondeduct' => 'required|string',
                    ]);

                    if ($validator->passes()) {



                        $withdrawLimit = $this->getWithdrawalLimit($thisuser->country, $thisuser->id);

                        if ($withdrawLimit['withdrawal_per_day'] > $req->amount) {
                            $data = [];
                            $message = "Withdrawal limit per day is " . $req->currencyCode . ' ' . number_format($withdrawLimit['withdrawal_per_day'], 2) . ". Please try a lesser amount";
                            $status = 400;
                        } elseif ($withdrawLimit['withdrawal_per_week'] > $req->amount) {
                            $data = [];
                            $message = "You have reached your limit for the week. Withdrawal limit per week is " . $req->currencyCode . ' ' . number_format($withdrawLimit['withdrawal_per_week'], 2) . ". Please try again the next week";
                            $status = 400;
                        } elseif ($withdrawLimit['withdrawal_per_month'] > $req->amount) {
                            $data = [];
                            $message = "You have reached your limit for the month. Withdrawal limit per month is " . $req->currencyCode . ' ' . number_format($withdrawLimit['withdrawal_per_month'], 2) . ". Please try again the next month";
                            $status = 400;
                        } else {

                            // Log::info($thisuser->name." wants to withdraw ".$req->currencyCode." ".$req->amount." from their wallet. This is a test environment");

                            $this->slack($thisuser->name . " wants to withdraw " . $req->currencyCode . " " . $req->amount . " from their wallet. This is a test environment", $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));


                            if ($thisuser->accountType == "Individual") {
                                $subminType = "Consumer Monthly Subscription";
                            } else {
                                $subminType = "Merchant Monthly Subscription";
                            }
                            $minBal = $this->maintenanceBalanceWithdrawal($subminType, $thisuser->country);

                            $minWithdrawalBal = $this->minimumAmountToWithdrawal($subminType, $thisuser->country);


                            // Check amount in wallet
                            if ($req->amount > ($thisuser->wallet_balance - $minBal)) {
                                // Insufficient amount for withdrawal

                                $minWalBal = $thisuser->wallet_balance - $minBal;

                                $data = [];
                                $message = "Your available wallet balance is " . $req->currencyCode . ' ' . number_format($minWalBal, 2) . ". Please add money to continue transaction";
                                $status = 400;

                                // Log::info('Oops!, Though this is a test, but '.$thisuser->name.' has '.$message);

                                $this->slack('Oops!, Though this is a test, but ' . $thisuser->name . ' has ' . $message, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));
                            } elseif ($thisuser->approval < 2 && $thisuser->accountLevel <= 2) {
                                // Cannot withdraw minimum balance

                                $data = [];
                                $message = "You cannot withdraw money at the moment because your account is still on review.";
                                $status = 400;

                                // Log::info('Oops!, Though this is a test, but '.$thisuser->name.' has '.$message);


                                $this->slack('Oops!, Though this is a test, but ' . $thisuser->name . ' has ' . $message, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));
                            } elseif (($thisuser->wallet_balance - $minBal) <= $req->amount) {
                                // Cannot withdraw minimum balance

                                $minWalBal = $thisuser->wallet_balance - $minBal;

                                $data = [];
                                $message = "Your available wallet balance is " . $req->currencyCode . ' ' . number_format($minWalBal, 2) . ". Please add money to continue transaction";
                                $status = 400;

                                // Log::info('Oops!, Though this is a test, but '.$thisuser->name.' has '.$message);

                                $this->slack('Oops!, Though this is a test, but ' . $thisuser->name . ' has ' . $message, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));
                            } else {


                                    if ($req->card_type == "Prepaid Card") {
                                        $cardType = "EXBC Prepaid Card";
                                    } else {
                                        $cardType = $req->card_type;
                                    }


                                    $checkTransaction = TransactionCost::where('method', $cardType)->where('country', $thisuser->country)->first();



                                    if (isset($checkTransaction) ==  true) {

                                        // Do convert amount to dollars

                                        // This 1.35 is commission charge, kindly calculate again

                                        // $monerisDeductamount = $req->conversionamount - 1.35;
                                        $monerisDeductamount = $req->conversionamount;

                                        // Get Transaction record for last money added to wallet
                                        $getTrans = Statement::where('reference_code', 'LIKE', '%ord-%')->where('reference_code', 'LIKE', '%wallet-%')->where('user_id', $thisuser->email)->latest()->first();


                                        // Check Transaction PIn
                                        if ($thisuser->transaction_pin != null) {
                                            // Validate Transaction PIN
                                            if (Hash::check($req->transaction_pin, $thisuser->transaction_pin)) {



                                                /*
                                            1. Check card detail
                                            2. If EXBC Prepaid Card, take to EXBC Endpoint to withdraw
                                            3. Return Response and Debit wallet
                                        */

                                                // Get Card Details
                                                $cardDetails = AddCard::where('id', $req->card_id)->where('user_id', $thisuser->id)->first();

                                                if (isset($cardDetails) == true && $cardDetails->card_provider == "EXBC Prepaid Card" || isset($cardDetails) == true && $cardDetails->card_provider == "Prepaid Card") {


                                                    $transaction_id = "wallet-" . date('dmY') . time();
                                                    $reference_code = "PS_" . $thisuser->ref_code;

                                                    if (env('APP_ENV') == "local") {
                                                        $url = "http://localhost:4000/api/v1/paysprint/loadcard";
                                                    } else {
                                                        $url = "https://exbc.ca/api/v1/paysprint/loadcard";
                                                    }

                                                    $mydata = array(
                                                        'transaction_id' => $transaction_id,
                                                        'reference_code' => $reference_code,
                                                        'email' => $thisuser->email,
                                                        // 'amount' => $req->amounttosend,
                                                        'amount' => $req->amount,
                                                        'card_number' => $cardDetails->card_number,
                                                        'name' => $thisuser->name,
                                                    );

                                                    $token = "base64:HgMO6FDHGziGl01OuLH9mh7CeP095shB6uuDUUClhks=";


                                                    $response = $this->curlPost($url, $mydata, $token);


                                                    if ($response->status == 200) {
                                                        $resData = $this->debitWalletForCard($thisuser->ref_code, $req->amount, $cardDetails->card_provider, $transaction_id, "test");

                                                        $status = $resData['status'];
                                                        // $data = $resData['data'];
                                                        $data = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol')->where('api_token', $req->bearerToken())->first();
                                                        $message = $response->message;
                                                    } else {
                                                        $status = $response->status;
                                                        // $data = $response->data;
                                                        $data = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol')->where('api_token', $req->bearerToken())->first();;
                                                        $message = $response->message;
                                                        $resData = ['data' => $data, 'message' => $message, 'status' => $status];
                                                    }

                                                    $activity = "Withdraw " . $req->currencyCode . '' . number_format($req->amount, 2) . " from Wallet to EXBC Prepaid Card";
                                                    $credit = 0;
                                                    $debit = $req->amount;
                                                    $reference_code = $transaction_id;
                                                    $balance = 0;
                                                    $trans_date = date('Y-m-d');
                                                    $transstatus = "Delivered";
                                                    $action = "Wallet debit";
                                                    $regards = $thisuser->ref_code;
                                                    $statement_route = "wallet";

                                                    $walletBal = $thisuser->wallet_balance - $req->amount;
                                                    $no_of_withdraw = $thisuser->number_of_withdrawals + 1;

                                                    // User::where('api_token', $req->bearerToken())->update([
                                                    //     'wallet_balance' => $walletBal,
                                                    //     'number_of_withdrawals' => $no_of_withdraw
                                                    // ]);

                                                    // Senders statement
                                                    // $this->insStatement($thisuser->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $transstatus, $action, $regards, 1, $statement_route, $thisuser->country, 0);

                                                    // $this->createNotification($thisuser->ref_code, "Hello ".strtoupper($thisuser->name).", ".$message);

                                                    // $this->getfeeTransaction($transaction_id, $thisuser->ref_code, $req->amount, $req->commissiondeduct, $req->amounttosend);


                                                    // Create Statement And Credit EXBC account holder
                                                    $exbcMerchant = User::where('email', 'prepaidcard@exbc.ca')->first();

                                                    if (isset($exbcMerchant)) {

                                                        // $activity = "Added ".$req->currencyCode.''.number_format($req->amounttosend, 2)." to your Wallet to load EXBC Prepaid Card";
                                                        // $credit = $req->amounttosend;
                                                        $activity = "Added " . $req->currencyCode . '' . number_format($req->amount, 2) . " to your Wallet to load EXBC Prepaid Card";
                                                        $credit = $req->amount;
                                                        $debit = 0;
                                                        $reference_code = $transaction_id;
                                                        $balance = 0;
                                                        $trans_date = date('Y-m-d');
                                                        $transstatus = "Delivered";
                                                        $action = "Wallet credit";
                                                        $regards = $exbcMerchant->ref_code;
                                                        $statement_route = "wallet";

                                                        // $merchantwalletBal = $exbcMerchant->wallet_balance + $req->amounttosend;
                                                        $merchantwalletBal = $exbcMerchant->wallet_balance + $req->amount;

                                                        // User::where('email', 'prepaidcard@exbc.ca')->update([
                                                        //     'wallet_balance' => $merchantwalletBal
                                                        // ]);

                                                        // Senders statement
                                                        // $this->insStatement($exbcMerchant->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $transstatus, $action, $regards, 1, $statement_route, $exbcMerchant->country, 0);

                                                        // $this->createNotification($exbcMerchant->ref_code, "Hello ".strtoupper($exbcMerchant->name).", ".$this->name." has ".$message);

                                                        $sendMsg = 'Hello ' . strtoupper($exbcMerchant->name) . ', ' . $thisuser->name . ' has ' . $activity . '. You have ' . $req->currencyCode . ' ' . number_format($merchantwalletBal, 2) . ' balance in your account';

                                                        $userPhone = User::where('email', $exbcMerchant->email)->where('telephone', 'LIKE', '%+%')->first();

                                                        if (isset($userPhone)) {

                                                            $sendPhone = $exbcMerchant->telephone;
                                                        } else {
                                                            $sendPhone = "+" . $exbcMerchant->code . $exbcMerchant->telephone;
                                                        }

                                                        if ($exbcMerchant->country == "Nigeria") {

                                                            $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                                                            $this->sendSms($sendMsg, $correctPhone);
                                                        } else {
                                                            $this->sendMessage($sendMsg, $sendPhone);
                                                        }
                                                    } else {
                                                        // DO nothing
                                                    }

                                                    $resData = ['data' => $data, 'message' => $message, 'status' => $status];
                                                } elseif ($req->card_type == "Bank Account") {

                                                    $bankDetails = AddBank::where('id', $req->card_id)->where('user_id', $thisuser->id)->first();

                                                    // Log::info("Card ID: ".$req->card_id." Type: ".$req->card_type);

                                                    $this->slack("Card ID: " . $req->card_id . " Type: " . $req->card_type, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));

                                                    if (isset($bankDetails)) {

                                                        $transaction_id = "wallet-" . date('dmY') . time();
                                                        // Save Payment for Admin
                                                        // $insRec = BankWithdrawal::updateOrInsert(['transaction_id' => $transaction_id], ['transaction_id' => $transaction_id, 'ref_code' => $thisuser->ref_code, 'bank_id' => $req->card_id, 'amountToSend' => $req->amounttosend, 'country' => $thisuser->country]);


                                                        // $mydata = BankWithdrawal::where('transaction_id', $transaction_id)->first();


                                                        $status = 200;
                                                        $data = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol')->where('api_token', $req->bearerToken())->first();
                                                        $message = "Your wallet withdrawal to Bank Account " . $bankDetails->accountNumber . " - " . $bankDetails->bankName . " has been received. The Direct deposit into your Bank account would be done within the next 5 business days. Thanks";




                                                        $walletBal = $thisuser->wallet_balance - $req->amount;
                                                        $no_of_withdraw = $thisuser->number_of_withdrawals + 1;

                                                        // User::where('api_token', $req->bearerToken())->update([
                                                        //     'wallet_balance' => $walletBal,
                                                        //     'number_of_withdrawals' => $no_of_withdraw
                                                        // ]);


                                                        $activity = "Withdraw " . $req->currencyCode . '' . number_format($req->amount, 2) . " from Wallet to Bank Account " . $bankDetails->bankName . " - " . $bankDetails->accountNumber;
                                                        $credit = 0;
                                                        $debit = $req->amount;
                                                        $reference_code = $transaction_id;
                                                        $balance = 0;
                                                        $trans_date = date('Y-m-d');
                                                        $thistatus = "Delivered";
                                                        $action = "Wallet debit";
                                                        $regards = $thisuser->ref_code;
                                                        $statement_route = "wallet";

                                                        // Senders statement
                                                        $this->insStatement($thisuser->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $thistatus, $action, $regards, 1, $statement_route, $thisuser->country, 0);


                                                        $sendMsg = 'Hello ' . strtoupper($thisuser->name) . ', The withdrawal of ' . $req->currencyCode . ' ' . number_format($req->amount, 2) . ' to your Bank Account ' . $bankDetails->bankName . ' and Account Number: ' . $bankDetails->accountNumber . ' has been received. The Direct deposit into your Bank account would be done within the next 5 business days. You have ' . $req->currencyCode . ' ' . number_format($walletBal, 2) . ' balance in your account';





                                                        $userPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

                                                        if (isset($userPhone)) {

                                                            $sendPhone = $thisuser->telephone;
                                                        } else {
                                                            $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
                                                        }

                                                        // $this->createNotification($thisuser->ref_code, $sendMsg);

                                                        // $this->getfeeTransaction($transaction_id, $thisuser->ref_code, $req->amount, $req->commissiondeduct, $req->amounttosend);


                                                        // Log::info('Congratulations!, '.$thisuser->name.' '.$sendMsg.". This is a test environment");


                                                        $this->slack('Congratulations!, ' . $thisuser->name . ' ' . $sendMsg . ". This is a test environment", $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));
                                                    } else {
                                                        $data = [];
                                                        $message = "No bank record found for your account";
                                                        $status = 400;
                                                    }




                                                    $resData = ['data' => $data, 'message' => $message, 'status' => $status];
                                                } else {

                                                    if (isset($getTrans) == true) {
                                                        $transaction_id = $getTrans->reference_code;
                                                    } else {
                                                        $transaction_id = "wallet-" . date('dmY') . time();
                                                    }

                                                    $customer_id = $thisuser->ref_code;

                                                    // Get Card Detail
                                                    $card_number = $cardDetails->card_number;
                                                    $month = $cardDetails->month;
                                                    $year = $cardDetails->year;


                                                    $this->creditCardWithdrawalRequest($thisuser->ref_code, $transaction_id, $customer_id, $card_number, $month, $year, $req->amount, $thisuser->country);



                                                    // Proceed to Withdrawal

                                                    // $response = $this->monerisWalletProcess($req->bearerToken(), $req->card_id, $monerisDeductamount, "ind_refund", "PaySprint Withdraw from Wallet to ".$thisuser->name, $req->mode);

                                                    // if($response->responseData['ResponseCode'] == "000" || $response->responseData['ResponseCode'] == "001" || $response->responseData['ResponseCode'] == "002" || $response->responseData['ResponseCode'] == "003" || $response->responseData['ResponseCode'] == "004" || $response->responseData['ResponseCode'] == "005" || $response->responseData['ResponseCode'] == "006" || $response->responseData['ResponseCode'] == "007" || $response->responseData['ResponseCode'] == "008" || $response->responseData['ResponseCode'] == "009" || $response->responseData['ResponseCode'] == "010" || $response->responseData['ResponseCode'] == "023" || $response->responseData['ResponseCode'] == "024" || $response->responseData['ResponseCode'] == "025" || $response->responseData['ResponseCode'] == "026" || $response->responseData['ResponseCode'] == "027" || $response->responseData['ResponseCode'] == "028" || $response->responseData['ResponseCode'] == "029"){

                                                    $walletBal = $thisuser->wallet_balance - $req->amount;
                                                    $no_of_withdraw = $thisuser->number_of_withdrawals + 1;

                                                    User::where('api_token', $req->bearerToken())->update([
                                                        'wallet_balance' => $walletBal,
                                                        'number_of_withdrawals' => $no_of_withdraw
                                                    ]);

                                                    // Update Statement

                                                    $userData = User::select('id', 'ref_code as refCode', 'name', 'email', 'telephone', 'wallet_balance as walletBalance', 'number_of_withdrawals as noOfWithdrawals')->where('api_token', $req->bearerToken())->first();

                                                    $activity = "Withdraw " . $req->currencyCode . '' . number_format($req->amount, 2) . " from Wallet to Credit/Debit card";
                                                    $credit = 0;
                                                    $debit = $req->amount;
                                                    // $reference_code = $response->responseData['ReceiptId'];
                                                    $reference_code = $transaction_id;
                                                    $balance = 0;
                                                    $trans_date = date('Y-m-d');
                                                    $status = "Delivered";
                                                    $action = "Wallet debit";
                                                    $regards = $thisuser->ref_code;
                                                    $statement_route = "wallet";

                                                    // Senders statement
                                                    $this->insStatement($thisuser->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, $thisuser->country, 0);

                                                    // Notification
                                                    $cardDetails = AddCard::where('id', $req->card_id)->where('user_id', $thisuser->id)->first();

                                                    $cardNo = str_repeat("*", strlen($cardDetails->card_number) - 4) . substr($cardDetails->card_number, -4);


                                                    $this->name = $thisuser->name;
                                                    $this->email = $thisuser->email;
                                                    $this->subject = $req->currencyCode . ' ' . number_format($req->amount, 2) . " has been Withdrawn from your Wallet with PaySprint";

                                                    $this->message = '<p>The withdrawal of ' . $req->currencyCode . ' ' . number_format($req->amount, 2) . ' to your card, Card Name: <strong>' . strtoupper($cardDetails->card_name) . '</strong> and Number: <strong>' . wordwrap($cardNo, 4, '-', true) . '</strong> is successful. The withdrawal will take up to 5 working days before it reflects in your bank account or credit card. </p><p>You have <strong>' . $req->currencyCode . ' ' . number_format($walletBal, 2) . '</strong> balance in your wallet.</p>';



                                                    $sendMsg = 'The withdrawal of ' . $req->currencyCode . ' ' . number_format($req->amount, 2) . ' to your card, Card Name: ' . strtoupper($cardDetails->card_name) . ' and Number: ' . wordwrap($cardNo, 4, '-', true) . ' is successful. The withdrawal will take up to 5 working days before it reflects in your bank account or credit card. You have ' . $req->currencyCode . ' ' . number_format($walletBal, 2) . ' balance in your wallet.';

                                                    $userPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

                                                    if (isset($userPhone)) {

                                                        $sendPhone = $thisuser->telephone;
                                                    } else {
                                                        $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
                                                    }


                                                    $this->createNotification($thisuser->ref_code, $sendMsg, $thisuser->playerId, $sendMsg, "Wallet Transaction");

                                                    // $this->getfeeTransaction($reference_code, $thisuser->ref_code, $req->amount, $req->commissiondeduct, $req->amounttosend);
                                                    $this->getfeeTransaction($reference_code, $thisuser->ref_code, $req->amount, $req->commissiondeduct, $req->amount);

                                                    if ($thisuser->country == "Nigeria") {

                                                        $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                                                        $this->sendSms($sendMsg, $correctPhone);
                                                    } else {
                                                        $this->sendMessage($sendMsg, $sendPhone);
                                                    }

                                                    $this->sendEmail($this->email, "Fund remittance");

                                                    $data = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol')->where('api_token', $req->bearerToken())->first();
                                                    $status = 200;
                                                    // $message = $req->currencyCode.' '.number_format($req->amount, 2).' is debited from your Wallet';
                                                    $message = $sendMsg;

                                                    // Log::info('Congratulations!, '.$thisuser->name.' '.$message);

                                                    $this->slack('Congratulations!, ' . $thisuser->name . ' ' . $message, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));



                                                    // }
                                                    // else{
                                                    //     $data = [];
                                                    //         $message = $response->responseData['Message'];
                                                    //         $status = 400;
                                                    // }
                                                }
                                            } else {
                                                $data = [];
                                                $message = "Invalid transaction pin";
                                                $status = 400;
                                            }
                                        } else {
                                            // Set new transaction pin and validate

                                            if (Hash::check($req->password, $thisuser->password)) {

                                                if ($req->transaction_pin != $req->confirm_transaction_pin) {

                                                    $data = [];
                                                    $message = "Transaction pin does not match";
                                                    $status = 400;
                                                } else {

                                                    // Update Transaction pin
                                                    User::where('api_token', $req->bearerToken())->update(['transaction_pin' => Hash::make($req->transaction_pin)]);


                                                    /*
                                            1. Check card detail
                                            2. If EXBC Prepaid Card, take to EXBC Endpoint to withdraw
                                            3. Return Response and Debit wallet
                                        */

                                                    // Get Card Details
                                                    $cardDetails = AddCard::where('id', $req->card_id)->where('user_id', $thisuser->id)->first();

                                                    if (isset($cardDetails) == true && $cardDetails->card_provider == "EXBC Prepaid Card" || isset($cardDetails) == true && $cardDetails->card_provider == "Prepaid Card") {

                                                        $transaction_id = "wallet-" . date('dmY') . time();
                                                        $reference_code = "PS_" . $thisuser->ref_code;

                                                        if (env('APP_ENV') == "local") {
                                                            $url = "http://localhost:4000/api/v1/paysprint/loadcard";
                                                        } else {
                                                            $url = "https://exbc.ca/api/v1/paysprint/loadcard";
                                                        }

                                                        $mydata = array(
                                                            'transaction_id' => $transaction_id,
                                                            'reference_code' => $reference_code,
                                                            'email' => $thisuser->email,
                                                            // 'amount' => $req->amounttosend,
                                                            'amount' => $req->amount,
                                                            'card_number' => $cardDetails->card_number,
                                                            'name' => $thisuser->name,
                                                        );

                                                        $token = "base64:HgMO6FDHGziGl01OuLH9mh7CeP095shB6uuDUUClhks=";


                                                        $response = $this->curlPost($url, $mydata, $token);


                                                        if ($response->status == 200) {
                                                            $resData = $this->debitWalletForCard($thisuser->ref_code, $req->amount, $cardDetails->card_provider, $transaction_id, "live");

                                                            $status = $resData['status'];
                                                            $data = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol')->where('api_token', $req->bearerToken())->first();
                                                            $message = $response->message;
                                                        } else {
                                                            $status = $response->status;
                                                            $data = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol')->where('api_token', $req->bearerToken())->first();
                                                            $message = $response->message;
                                                            $resData = ['data' => $data, 'message' => $message, 'status' => $status];
                                                        }

                                                        $activity = "Withdraw " . $req->currencyCode . ' ' . $req->amount . " from Wallet to EXBC Prepaid Card";
                                                        $credit = 0;
                                                        $debit = $req->amount;
                                                        $reference_code = $transaction_id;
                                                        $balance = 0;
                                                        $trans_date = date('Y-m-d');
                                                        $transstatus = "Delivered";
                                                        $action = "Wallet debit";
                                                        $regards = $thisuser->ref_code;
                                                        $statement_route = "wallet";

                                                        $walletBal = $thisuser->wallet_balance - $req->amount;
                                                        $no_of_withdraw = $thisuser->number_of_withdrawals + 1;

                                                        User::where('api_token', $req->bearerToken())->update([
                                                            'wallet_balance' => $walletBal,
                                                            'number_of_withdrawals' => $no_of_withdraw
                                                        ]);

                                                        // Senders statement
                                                        $this->insStatement($thisuser->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $transstatus, $action, $regards, 1, $statement_route, $thisuser->country, 0);

                                                        $this->createNotification($thisuser->ref_code, "Hello " . strtoupper($thisuser->name) . ", " . $message, $thisuser->playerId, $message, "Wallet Transaction");

                                                        // Log::info("Hello ".strtoupper($thisuser->name).", ".$message);


                                                        $this->slack("Hello " . strtoupper($thisuser->name) . ", " . $message, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));

                                                        // $this->getfeeTransaction($transaction_id, $thisuser->ref_code, $req->amount, $req->commissiondeduct, $req->amounttosend);
                                                        $this->getfeeTransaction($transaction_id, $thisuser->ref_code, $req->amount, $req->commissiondeduct, $req->amount);


                                                        // Create Statement And Credit EXBC account holder
                                                        $exbcMerchant = User::where('email', 'prepaidcard@exbc.ca')->first();

                                                        if (isset($exbcMerchant)) {

                                                            // $activity = "Added ".$req->currencyCode.''.number_format($req->amounttosend, 2)." to your Wallet to load EXBC Prepaid Card";
                                                            // $credit = $req->amounttosend;
                                                            $activity = "Added " . $req->currencyCode . '' . number_format($req->amount, 2) . " to your Wallet to load EXBC Prepaid Card";
                                                            $credit = $req->amount;
                                                            $debit = 0;
                                                            $reference_code = $transaction_id;
                                                            $balance = 0;
                                                            $trans_date = date('Y-m-d');
                                                            $transstatus = "Delivered";
                                                            $action = "Wallet credit";
                                                            $regards = $exbcMerchant->ref_code;
                                                            $statement_route = "wallet";

                                                            // $merchantwalletBal = $exbcMerchant->wallet_balance + $req->amounttosend;
                                                            $merchantwalletBal = $exbcMerchant->wallet_balance + $req->amount;

                                                            User::where('email', 'prepaidcard@exbc.ca')->update([
                                                                'wallet_balance' => $merchantwalletBal
                                                            ]);

                                                            // Senders statement
                                                            $this->insStatement($exbcMerchant->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $transstatus, $action, $regards, 1, $statement_route, $exbcMerchant->country, 0);

                                                            $this->createNotification($exbcMerchant->ref_code, "Hello " . strtoupper($exbcMerchant->name) . ", " . $this->name . " has " . $message, $thisuser->playerId, $message, "Wallet Transaction");

                                                            $sendMsg = 'Hello ' . strtoupper($exbcMerchant->name) . ', ' . $thisuser->name . ' has ' . $activity . '. You have ' . $req->currencyCode . ' ' . number_format($merchantwalletBal, 2) . ' balance in your account';

                                                            $userPhone = User::where('email', $exbcMerchant->email)->where('telephone', 'LIKE', '%+%')->first();

                                                            if (isset($userPhone)) {

                                                                $sendPhone = $exbcMerchant->telephone;
                                                            } else {
                                                                $sendPhone = "+" . $exbcMerchant->code . $exbcMerchant->telephone;
                                                            }

                                                            if ($exbcMerchant->country == "Nigeria") {

                                                                $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                                                                $this->sendSms($sendMsg, $correctPhone);
                                                            } else {
                                                                $this->sendMessage($sendMsg, $sendPhone);
                                                            }
                                                        } else {
                                                            // Do nothing
                                                        }


                                                        $resData = ['data' => $data, 'message' => $message, 'status' => $status];
                                                    } elseif ($req->card_type == "Bank Account") {

                                                        $bankDetails = AddBank::where('id', $req->card_id)->where('user_id', $thisuser->id)->first();
                                                        $transaction_id = "wallet-" . date('dmY') . time();
                                                        // Save Payment for Admin
                                                        // $insRec = BankWithdrawal::updateOrInsert(['transaction_id' => $transaction_id], ['transaction_id' => $transaction_id, 'ref_code' => $thisuser->ref_code, 'bank_id' => $req->card_id, 'amountToSend' => $req->amounttosend, 'country' => $thisuser->country]);
                                                        $insRec = BankWithdrawal::updateOrInsert(['transaction_id' => $transaction_id], ['transaction_id' => $transaction_id, 'ref_code' => $thisuser->ref_code, 'bank_id' => $req->card_id, 'amountToSend' => $req->amount, 'country' => $thisuser->country]);


                                                        $mydata = BankWithdrawal::where('transaction_id', $transaction_id)->first();


                                                        $status = 200;
                                                        $data = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol')->where('api_token', $req->bearerToken())->first();
                                                        $message = "Your wallet withdrawal to Bank Account " . $bankDetails->accountNumber . " - " . $bankDetails->bankName . " has been received. The Direct deposit into your Bank account would be done within the next 5 business days. Thanks";




                                                        $walletBal = $thisuser->wallet_balance - $req->amount;
                                                        $no_of_withdraw = $thisuser->number_of_withdrawals + 1;

                                                        User::where('api_token', $req->bearerToken())->update([
                                                            'wallet_balance' => $walletBal,
                                                            'number_of_withdrawals' => $no_of_withdraw
                                                        ]);


                                                        $activity = "Withdraw " . $req->currencyCode . '' . number_format($req->amount, 2) . " from Wallet to Bank Account " . $bankDetails->bankName . " - " . $bankDetails->accountNumber;
                                                        $credit = 0;
                                                        $debit = $req->amount;
                                                        $reference_code = $transaction_id;
                                                        $balance = 0;
                                                        $trans_date = date('Y-m-d');
                                                        $thistatus = "Delivered";
                                                        $action = "Wallet debit";
                                                        $regards = $thisuser->ref_code;
                                                        $statement_route = "wallet";

                                                        // Senders statement
                                                        $this->insStatement($thisuser->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $thistatus, $action, $regards, 1, $statement_route, $thisuser->country, 0);


                                                        $sendMsg = 'Hello ' . strtoupper($thisuser->name) . ', The withdrawal of ' . $req->currencyCode . ' ' . number_format($req->amount, 2) . ' to your Bank Account ' . $bankDetails->bankName . ' and Account Number: ' . $bankDetails->accountNumber . ' has been received. The Direct deposit into your Bank account would be done within the next 5 business days. You have ' . $req->currencyCode . ' ' . number_format($walletBal, 2) . ' balance in your account';




                                                        $userPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

                                                        if (isset($userPhone)) {

                                                            $sendPhone = $thisuser->telephone;
                                                        } else {
                                                            $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
                                                        }

                                                        $this->createNotification($thisuser->ref_code, $sendMsg, $thisuser->playerId, $sendMsg, "Wallet Transaction");

                                                        // $this->getfeeTransaction($transaction_id, $thisuser->ref_code, $req->amount, $req->commissiondeduct, $req->amounttosend);
                                                        $this->getfeeTransaction($transaction_id, $thisuser->ref_code, $req->amount, $req->commissiondeduct, $req->amount);


                                                        // Log::info("Congratulations! ".strtoupper($thisuser->name)." ".$sendMsg);

                                                        $this->slack("Congratulations! " . strtoupper($thisuser->name) . " " . $sendMsg, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));


                                                        $resData = ['data' => $data, 'message' => $message, 'status' => $status];
                                                    } else {

                                                        if (isset($getTrans) == true) {
                                                            $transaction_id = $getTrans->reference_code;
                                                        } else {
                                                            $transaction_id = "wallet-" . date('dmY') . time();
                                                        }

                                                        $customer_id = $thisuser->ref_code;

                                                        // Get Card Detail
                                                        $card_number = $cardDetails->card_number;
                                                        $month = $cardDetails->month;
                                                        $year = $cardDetails->year;


                                                        // $this->creditCardWithdrawalRequest($thisuser->ref_code, $transaction_id, $customer_id, $card_number, $month, $year, $req->amount, $thisuser->country);


                                                        // Proceed to Withdrawal

                                                        // $response = $this->monerisWalletProcess($req->bearerToken(), $req->card_id, $monerisDeductamount, "ind_refund", "PaySprint Withdraw from Wallet to ".$thisuser->name, $req->mode);


                                                        // if($response->responseData['ResponseCode'] == "000" || $response->responseData['ResponseCode'] == "001" || $response->responseData['ResponseCode'] == "002" || $response->responseData['ResponseCode'] == "003" || $response->responseData['ResponseCode'] == "004" || $response->responseData['ResponseCode'] == "005" || $response->responseData['ResponseCode'] == "006" || $response->responseData['ResponseCode'] == "007" || $response->responseData['ResponseCode'] == "008" || $response->responseData['ResponseCode'] == "009" || $response->responseData['ResponseCode'] == "010" || $response->responseData['ResponseCode'] == "023" || $response->responseData['ResponseCode'] == "024" || $response->responseData['ResponseCode'] == "025" || $response->responseData['ResponseCode'] == "026" || $response->responseData['ResponseCode'] == "027" || $response->responseData['ResponseCode'] == "028" || $response->responseData['ResponseCode'] == "029"){

                                                        $walletBal = $thisuser->wallet_balance - $req->amount;
                                                        $no_of_withdraw = $thisuser->number_of_withdrawals + 1;

                                                        // User::where('api_token', $req->bearerToken())->update([
                                                        //     'wallet_balance' => $walletBal,
                                                        //     'number_of_withdrawals' => $no_of_withdraw
                                                        // ]);

                                                        // Update Statement

                                                        $userData = User::select('id', 'ref_code as refCode', 'name', 'email', 'telephone', 'wallet_balance as walletBalance', 'number_of_withdrawals as noOfWithdrawals')->where('api_token', $req->bearerToken())->first();

                                                        $activity = "Withdraw " . $req->currencyCode . '' . number_format($req->amount, 2) . " from Wallet to Credit/Debit card";
                                                        $credit = 0;
                                                        $debit = $req->amount;
                                                        // $reference_code = $response->responseData['ReceiptId'];
                                                        $reference_code = $transaction_id;
                                                        $balance = 0;
                                                        $trans_date = date('Y-m-d');
                                                        $status = "Delivered";
                                                        $action = "Wallet debit";
                                                        $regards = $thisuser->ref_code;
                                                        $statement_route = "wallet";

                                                        // Senders statement
                                                        // $this->insStatement($thisuser->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, $thisuser->country, 0);

                                                        // $this->getfeeTransaction($reference_code, $thisuser->ref_code, $req->amount, $req->commissiondeduct, $req->amounttosend);


                                                        // Notification

                                                        $cardDetails = AddCard::where('id', $req->card_id)->where('user_id', $thisuser->id)->first();

                                                        $cardNo = str_repeat("*", strlen($cardDetails->card_number) - 4) . substr($cardDetails->card_number, -4);

                                                        $this->name = $thisuser->name;
                                                        $this->email = $thisuser->email;
                                                        $this->subject = $req->currencyCode . ' ' . number_format($req->amount, 2) . " has been Withdrawn from your Wallet with PaySprint";

                                                        $this->message = '<p>The withdrawal of ' . $req->currencyCode . ' ' . number_format($req->amount, 2) . ' to your card, Card Name: <strong>' . strtoupper($cardDetails->card_name) . '</strong> and Number: <strong>' . wordwrap($cardNo, 4, '-', true) . '</strong> is successful. The withdrawal will take up to 5 working days before it reflects in your bank account or credit card. </p><p>You have <strong>' . $req->currencyCode . ' ' . number_format($walletBal, 2) . '</strong> balance in your wallet.</p>';

                                                        $sendMsg = 'The withdrawal of ' . $req->currencyCode . ' ' . number_format($req->amount, 2) . ' to your card, Card Name: ' . strtoupper($cardDetails->card_name) . ' and Number: ' . wordwrap($cardNo, 4, '-', true) . ' is successful. The withdrawal will take up to 5 working days before it reflects in your bank account or credit card. You have ' . $req->currencyCode . ' ' . number_format($walletBal, 2) . ' balance in your wallet.';

                                                        $userPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

                                                        if (isset($userPhone)) {

                                                            $sendPhone = $thisuser->telephone;
                                                        } else {
                                                            $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
                                                        }


                                                        // $this->createNotification($thisuser->ref_code, $sendMsg);

                                                        if ($thisuser->country == "Nigeria") {

                                                            $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                                                            $this->sendSms($sendMsg, $correctPhone);
                                                        } else {
                                                            $this->sendMessage($sendMsg, $sendPhone);
                                                        }

                                                        $this->sendEmail($this->email, "Fund remittance");


                                                        $userInfo = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol')->where('api_token', $req->bearerToken())->first();

                                                        $data = $userInfo;
                                                        $status = 200;
                                                        $message = $sendMsg;

                                                        // Log::info("Congratulations! ".strtoupper($thisuser->name)." ".$message.". This is a test environment");

                                                        $this->slack("Congratulations! " . strtoupper($thisuser->name) . " " . $message . ". This is a test environment", $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));
                                                    }
                                                }
                                            } else {
                                                $data = [];
                                                $message = "Invalid login password";
                                                $status = 400;
                                            }
                                        }
                                    } else {

                                        $data = [];
                                        $message = "Withdrawal to " . strtoupper($req->card_type) . " not yet activated for your country.";
                                        $status = 400;

                                        // Log::info('Oops!, Though this is a test, but '.$thisuser->name.', '.$message);

                                        $this->slack('Oops!, Though this is a test, but ' . $thisuser->name . ', ' . $message, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));
                                    }

                            }
                        }
                    } else {

                        $error = implode(",", $validator->messages()->all());

                        $data = [];
                        $status = 400;
                        $message = $error;
                    }
                } else {
                    $validator = Validator::make($req->all(), [
                        //  'card_id' => 'required|string',
                        'amount' => 'required|string',
                        'transaction_pin' => 'required|string',
                        'currencyCode' => 'required|string',
                        'conversionamount' => 'required|string',
                        'card_type' => 'required|string',
                        'amounttosend' => 'required|string',
                        'commissiondeduct' => 'required|string',
                    ]);

                    if ($validator->passes()) {


                        $checkIdv = $this->checkUsersPassAccount($thisuser->id);


                        if (in_array('withdraw money', $checkIdv['access'])) {
                            // Check number of withdrawal

                            $withdrawalCharge = $this->getNumberOfWitdrawals($thisuser->id, $thisuser->country, $req->amount);

                            $chargeAmount = $req->amount + $withdrawalCharge;


                            $withdrawLimit = $this->getWithdrawalLimit($thisuser->country, $thisuser->id);
                            // $withdrawLimit['withdrawal_per_day']
                            // $withdrawLimit['withdrawal_per_week']
                            // $withdrawLimit['withdrawal_per_month']


                            if ($req->amount > 10000000000000000000000000000000000) {
                                $data = [];
                                $message = "Withdrawal limit per day is " . $req->currencyCode . ' ' . number_format($withdrawLimit['withdrawal_per_day'], 2) . ". Please try a lesser amount";
                                $status = 400;
                            } elseif ($req->amount > 10000000000000000000000000000000000) {
                                $data = [];
                                $message = "You have reached your limit for the week. Withdrawal limit per week is " . $req->currencyCode . ' ' . number_format($withdrawLimit['withdrawal_per_week'], 2) . ". Please try again the next week";
                                $status = 400;
                            } elseif ($req->amount > 10000000000000000000000000000000000) {
                                $data = [];
                                $message = "You have reached your limit for the month. Withdrawal limit per month is " . $req->currencyCode . ' ' . number_format($withdrawLimit['withdrawal_per_month'], 2) . ". Please try again the next month";
                                $status = 400;
                            } else {
                                // Log::info($thisuser->name." wants to withdraw ".$req->currencyCode." ".$req->amount." from their wallet.");

                                $this->slack($thisuser->name . " wants to withdraw " . $req->currencyCode . " " . $req->amount . " from their wallet.", $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));

                                // $minBal = $this->minimumWithdrawal($thisuser->country);

                                if ($thisuser->accountType == "Individual") {
                                    $subminType = "Consumer Monthly Subscription";
                                } else {
                                    $subminType = "Merchant Monthly Subscription";
                                }

                                $minBal = $this->maintenanceBalanceWithdrawal($subminType, $thisuser->country);

                                $minWithdrawalBal = $this->minimumAmountToWithdrawal($subminType, $thisuser->country);


                                // Check amount in wallet
                                if ($req->amount > ($thisuser->wallet_balance - $withdrawalCharge - $minBal)) {
                                    // Insufficient amount for withdrawal

                                    $minWalBal = $thisuser->wallet_balance - $withdrawalCharge - $minBal;

                                    $data = [];
                                    $message = "Your available wallet balance is " . $req->currencyCode . ' ' . number_format($minWalBal, 2) . ". Please add money to continue transaction";
                                    $status = 400;

                                    // Log::info('Oops!, '.$thisuser->name.' has '.$message);

                                    $this->slack('Oops!, ' . $thisuser->name . ' has ' . $message, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));
                                } elseif ($thisuser->approval < 2 && $thisuser->accountLevel <= 2) {
                                    // Cannot withdraw minimum balance

                                    $data = [];
                                    $message = "Sorry!, Your account must be approved before you can withdraw from wallet";
                                    $status = 400;

                                    // Log::info('Oops!, '.$thisuser->name.' has '.$message);

                                    $this->slack('Oops!, ' . $thisuser->name . ' has ' . $message, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));
                                } elseif (($thisuser->wallet_balance - $withdrawalCharge - $minBal) <= $req->amount) {
                                    // Cannot withdraw minimum balance

                                    $minWalBal = $thisuser->wallet_balance - $withdrawalCharge - $minBal;

                                    $data = [];
                                    $message = "Your available wallet balance is " . $req->currencyCode . ' ' . number_format($minWalBal, 2) . ". Please add money to continue transaction";
                                    $status = 400;

                                    // Log::info('Oops!, '.$thisuser->name.' has '.$message);

                                    $this->slack('Oops!, ' . $thisuser->name . ' has ' . $message, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));
                                } else {



                                        if ($req->card_type == "Prepaid Card") {
                                            $cardType = "EXBC Prepaid Card";
                                        } elseif ($req->card_type == "Cash") {
                                            $cardType = "Payout";
                                        } elseif ($req->card_type == "e-Transfer") {
                                            $cardType = "eTransfer";
                                        } else {
                                            $cardType = $req->card_type;
                                        }

                                        if ($cardType === "Payout" || $cardType === "eTransfer") {


                                            // Get Transaction record for last money added to wallet
                                            $getTrans = Statement::where('reference_code', 'LIKE', '%ord-%')->where('reference_code', 'LIKE', '%wallet-%')->where('user_id', $thisuser->email)->latest()->first();


                                            // Check Transaction PIn
                                            if ($thisuser->transaction_pin != null) {
                                                // Validate Transaction PIN
                                                if (Hash::check($req->transaction_pin, $thisuser->transaction_pin)) {

                                                    // Get Payout Details



                                                    if ($req->card_type == "Cash") {

                                                        $payoutagent = PayoutAgent::where('id', $req->payout_id)->first();


                                                        if (isset($payoutagent)) {

                                                            $transaction_id = "wallet-" . date('dmY') . time();

                                                            $insRec = PayoutWithdrawal::updateOrInsert(['transaction_id' => $transaction_id], ['transaction_id' => $transaction_id, 'ref_code' => $thisuser->ref_code, 'payout_id' => $req->payout_id, 'amount' => $req->amount, 'amounttosend' => $req->amounttosend, 'country' => $thisuser->country, 'commissiondeduct' => $req->commissiondeduct, 'status' => 'pending']);


                                                            $mydata = PayoutWithdrawal::where('transaction_id', $transaction_id)->first();


                                                            $status = 200;
                                                            $data = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol')->where('api_token', $req->bearerToken())->first();


                                                            $message = "Your wallet withdrawal to Payout Agent is available with " . $payoutagent->businessname . " - (" . $payoutagent->address . " " . $payoutagent->city . ", " . $payoutagent->state . "). Kindly visit the store with your means of identification for your cash. Thanks";



                                                            $walletBal = $thisuser->wallet_balance - $req->amount;
                                                            $no_of_withdraw = $thisuser->number_of_withdrawals + 1;
                                                            $withdrawal_per_day = $thisuser->withdrawal_per_day + $req->amount;
                                                            $withdrawal_per_week = $thisuser->withdrawal_per_week + $withdrawal_per_day;
                                                            $withdrawal_per_month = $thisuser->withdrawal_per_month + $withdrawal_per_week;

                                                            User::where('api_token', $req->bearerToken())->update([
                                                                'wallet_balance' => $walletBal,
                                                                'number_of_withdrawals' => $no_of_withdraw,
                                                                'withdrawal_per_day' => $withdrawal_per_day,
                                                                'withdrawal_per_week' => $withdrawal_per_week,
                                                                'withdrawal_per_month' => $withdrawal_per_month,
                                                            ]);


                                                            $activity = "Withdraw " . $req->currencyCode . '' . number_format($req->amount, 2) . " from Wallet to Payout Agent " . $payoutagent->businessname . " - (" . $payoutagent->address . " " . $payoutagent->city . ", " . $payoutagent->state . ").";
                                                            $credit = 0;
                                                            $debit = $req->amount;
                                                            $reference_code = $transaction_id;
                                                            $balance = 0;
                                                            $trans_date = date('Y-m-d');
                                                            $thistatus = "Delivered";
                                                            $action = "Wallet debit";
                                                            $regards = $thisuser->ref_code;
                                                            $statement_route = "wallet";

                                                            // Senders statement
                                                            $this->insStatement($thisuser->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $thistatus, $action, $regards, 1, $statement_route, $thisuser->country, 0);


                                                            $sendMsg = 'Hello ' . strtoupper($thisuser->name) . ', The withdrawal of ' . $req->currencyCode . ' ' . number_format($req->amount, 2) . ' to your Payout Agent ' . $payoutagent->businessname . ' and Address: ' . $payoutagent->address . ' has been received. Kindly visit the store with your means of identification for your cash. You have ' . $req->currencyCode . ' ' . number_format($walletBal, 2) . ' balance in your account';

                                                            $userPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

                                                            if (isset($userPhone)) {

                                                                $sendPhone = $thisuser->telephone;
                                                            } else {
                                                                $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
                                                            }

                                                            $this->createNotification($thisuser->ref_code, $sendMsg, $thisuser->playerId, $sendMsg, "Wallet Transaction");

                                                            $this->getfeeTransaction($transaction_id, $thisuser->ref_code, $req->amount, $req->commissiondeduct, $req->amounttosend);


                                                            $this->slack('Congratulations!, ' . $thisuser->name . ' ' . $sendMsg, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));
                                                        } else {
                                                            $data = [];
                                                            $message = "Payout Agent record not found";
                                                            $status = 400;
                                                        }


                                                        $resData = ['data' => $data, 'message' => $message, 'status' => $status];
                                                    }

                                                    if ($req->card_type == "e-Transfer") {
                                                        // Coming soon
                                                        $data = [];
                                                        $message = "Feature coming soon shortly.";
                                                        $status = 400;
                                                    }
                                                } else {
                                                    $data = [];
                                                    $message = "Invalid transaction pin";
                                                    $status = 400;
                                                }
                                            } else {
                                                // Set new transaction pin and validate

                                                if (Hash::check($req->password, $thisuser->password)) {

                                                    if ($req->transaction_pin != $req->confirm_transaction_pin) {

                                                        $data = [];
                                                        $message = "Transaction pin does not match";
                                                        $status = 400;
                                                    } else {

                                                        // Update Transaction pin
                                                        User::where('api_token', $req->bearerToken())->update(['transaction_pin' => Hash::make($req->transaction_pin)]);


                                                        if ($req->card_type == "Cash") {

                                                            $payoutagent = PayoutAgent::where('id', $req->payout_id)->first();


                                                            if (isset($payoutagent)) {

                                                                $transaction_id = "wallet-" . date('dmY') . time();

                                                                $insRec = PayoutWithdrawal::updateOrInsert(['transaction_id' => $transaction_id], ['transaction_id' => $transaction_id, 'ref_code' => $thisuser->ref_code, 'payout_id' => $req->payout_id, 'amount' => $req->amount, 'amounttosend' => $req->amounttosend, 'country' => $thisuser->country, 'commissiondeduct' => $req->commissiondeduct, 'status' => 'pending']);


                                                                $mydata = PayoutWithdrawal::where('transaction_id', $transaction_id)->first();


                                                                $status = 200;
                                                                $data = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol')->where('api_token', $req->bearerToken())->first();


                                                                $message = "Your wallet withdrawal to Payout Agent is available with " . $payoutagent->businessname . " - (" . $payoutagent->address . " " . $payoutagent->city . ", " . $payoutagent->state . "). Kindly visit the store with your means of identification for your cash. Thanks";


                                                                $walletBal = $thisuser->wallet_balance - $req->amount;
                                                                $no_of_withdraw = $thisuser->number_of_withdrawals + 1;
                                                                $withdrawal_per_day = $thisuser->withdrawal_per_day + $req->amount;
                                                                $withdrawal_per_week = $thisuser->withdrawal_per_week + $withdrawal_per_day;
                                                                $withdrawal_per_month = $thisuser->withdrawal_per_month + $withdrawal_per_week;

                                                                User::where('api_token', $req->bearerToken())->update([
                                                                    'wallet_balance' => $walletBal,
                                                                    'number_of_withdrawals' => $no_of_withdraw,
                                                                    'withdrawal_per_day' => $withdrawal_per_day,
                                                                    'withdrawal_per_week' => $withdrawal_per_week,
                                                                    'withdrawal_per_month' => $withdrawal_per_month,
                                                                ]);


                                                                $activity = "Withdraw " . $req->currencyCode . '' . number_format($req->amount, 2) . " from Wallet to Payout Agent " . $payoutagent->businessname . " - (" . $payoutagent->address . " " . $payoutagent->city . ", " . $payoutagent->state . ")";
                                                                $credit = 0;
                                                                $debit = $req->amount;
                                                                $reference_code = $transaction_id;
                                                                $balance = 0;
                                                                $trans_date = date('Y-m-d');
                                                                $thistatus = "Delivered";
                                                                $action = "Wallet debit";
                                                                $regards = $thisuser->ref_code;
                                                                $statement_route = "wallet";

                                                                // Senders statement
                                                                $this->insStatement($thisuser->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $thistatus, $action, $regards, 1, $statement_route, $thisuser->country, 0);


                                                                $sendMsg = 'Hello ' . strtoupper($thisuser->name) . ', The withdrawal of ' . $req->currencyCode . ' ' . number_format($req->amount, 2) . ' to your Payout Agent ' . $payoutagent->businessname . ' and Address: ' . $payoutagent->address . ' has been received. Kindly visit the store with your means of identification for your cash. You have ' . $req->currencyCode . ' ' . number_format($walletBal, 2) . ' balance in your account';

                                                                $userPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

                                                                if (isset($userPhone)) {

                                                                    $sendPhone = $thisuser->telephone;
                                                                } else {
                                                                    $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
                                                                }

                                                                $this->createNotification($thisuser->ref_code, $sendMsg, $thisuser->playerId, $sendMsg, "Wallet Transaction");

                                                                $this->getfeeTransaction($transaction_id, $thisuser->ref_code, $req->amount, $req->commissiondeduct, $req->amounttosend);


                                                                $this->slack('Congratulations!, ' . $thisuser->name . ' ' . $sendMsg, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));
                                                            } else {
                                                                $data = [];
                                                                $message = "Payout Agent record not found";
                                                                $status = 400;
                                                            }


                                                            $resData = ['data' => $data, 'message' => $message, 'status' => $status];
                                                        }
                                                    }
                                                } else {
                                                    $data = [];
                                                    $message = "Invalid login password";
                                                    $status = 400;
                                                }
                                            }
                                        } else {
                                            $checkTransaction = TransactionCost::where('method', $cardType)->where('country', $thisuser->country)->first();

                                            if (isset($checkTransaction) ==  true) {


                                                // Get Transaction record for last money added to wallet
                                                $getTrans = Statement::where('reference_code', 'LIKE', '%ord-%')->where('reference_code', 'LIKE', '%wallet-%')->where('user_id', $thisuser->email)->latest()->first();


                                                // Check Transaction PIn
                                                if ($thisuser->transaction_pin != null) {
                                                    // Validate Transaction PIN
                                                    if (Hash::check($req->transaction_pin, $thisuser->transaction_pin)) {



                                                        /*
                                                            1. Check card detail
                                                            2. If EXBC Prepaid Card, take to EXBC Endpoint to withdraw
                                                            3. Return Response and Debit wallet
                                                        */

                                                        // Get Card Details
                                                        $cardDetails = AddCard::where('id', $req->card_id)->where('user_id', $thisuser->id)->first();

                                                        if (isset($cardDetails) == true && $cardDetails->card_provider == "EXBC Prepaid Card" || isset($cardDetails) == true && $cardDetails->card_provider == "Prepaid Card") {


                                                            $transaction_id = "wallet-" . date('dmY') . time();
                                                            $reference_code = "PS_" . $thisuser->ref_code;

                                                            if (env('APP_ENV') == "local") {
                                                                $url = "http://localhost:4000/api/v1/paysprint/loadcard";
                                                            } else {
                                                                $url = "https://exbc.ca/api/v1/paysprint/loadcard";
                                                            }

                                                            $mydata = array(
                                                                'transaction_id' => $transaction_id,
                                                                'reference_code' => $reference_code,
                                                                'email' => $thisuser->email,
                                                                // 'amount' => $req->amounttosend,
                                                                'amount' => $req->amount,
                                                                'card_number' => $cardDetails->card_number,
                                                                'name' => $thisuser->name,
                                                            );

                                                            $token = "base64:HgMO6FDHGziGl01OuLH9mh7CeP095shB6uuDUUClhks=";


                                                            $response = $this->curlPost($url, $mydata, $token);


                                                            if ($response->status == 200) {
                                                                $resData = $this->debitWalletForCard($thisuser->ref_code, $req->amount, $cardDetails->card_provider, $transaction_id, "live");

                                                                $status = $resData['status'];
                                                                // $data = $resData['data'];
                                                                $data = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol')->where('api_token', $req->bearerToken())->first();
                                                                $message = $response->message;
                                                            } else {
                                                                $status = $response->status;
                                                                // $data = $response->data;
                                                                $data = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol')->where('api_token', $req->bearerToken())->first();;
                                                                $message = $response->message;
                                                                $resData = ['data' => $data, 'message' => $message, 'status' => $status];
                                                            }

                                                            $activity = "Withdraw " . $req->currencyCode . '' . number_format($req->amount, 2) . " from Wallet to EXBC Prepaid Card. Withdrawal fee charge of " . $req->currencyCode . '' . number_format($withdrawalCharge, 2) . " inclusive";
                                                            $credit = 0;
                                                            $debit = $req->amount + $withdrawalCharge;
                                                            $reference_code = $transaction_id;
                                                            $balance = 0;
                                                            $trans_date = date('Y-m-d');
                                                            $transstatus = "Delivered";
                                                            $action = "Wallet debit";
                                                            $regards = $thisuser->ref_code;
                                                            $statement_route = "wallet";

                                                            $walletBal = $thisuser->wallet_balance - $chargeAmount;
                                                            $no_of_withdraw = $thisuser->number_of_withdrawals + 1;
                                                            $withdrawal_per_day = $thisuser->withdrawal_per_day + $req->amount;
                                                            $withdrawal_per_week = $thisuser->withdrawal_per_week + $withdrawal_per_day;
                                                            $withdrawal_per_month = $thisuser->withdrawal_per_month + $withdrawal_per_week;

                                                            User::where('api_token', $req->bearerToken())->update([
                                                                'wallet_balance' => $walletBal,
                                                                'number_of_withdrawals' => $no_of_withdraw,
                                                                'withdrawal_per_day' => $withdrawal_per_day,
                                                                'withdrawal_per_week' => $withdrawal_per_week,
                                                                'withdrawal_per_month' => $withdrawal_per_month
                                                            ]);

                                                            // Senders statement
                                                            $this->insStatement($thisuser->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $transstatus, $action, $regards, 1, $statement_route, $thisuser->country, 0);

                                                            $this->createNotification($thisuser->ref_code, "Hello " . strtoupper($thisuser->name) . ", " . $message, $thisuser->playerId, $message, "Wallet Transaction");

                                                            // $this->getfeeTransaction($transaction_id, $thisuser->ref_code, $req->amount, $req->commissiondeduct, $req->amounttosend);
                                                            $this->getfeeTransaction($transaction_id, $thisuser->ref_code, $req->amount, $req->commissiondeduct, $req->amount);


                                                            // Create Statement And Credit EXBC account holder
                                                            $exbcMerchant = User::where('email', 'prepaidcard@exbc.ca')->first();

                                                            if (isset($exbcMerchant)) {

                                                                // $activity = "Added ".$req->currencyCode.''.number_format($req->amounttosend, 2)." to your Wallet to load EXBC Prepaid Card";
                                                                // $credit = $req->amounttosend;
                                                                $activity = "Added " . $req->currencyCode . '' . number_format($req->amount, 2) . " to your Wallet to load EXBC Prepaid Card";
                                                                $credit = $req->amount;
                                                                $debit = 0;
                                                                $reference_code = $transaction_id;
                                                                $balance = 0;
                                                                $trans_date = date('Y-m-d');
                                                                $transstatus = "Delivered";
                                                                $action = "Wallet credit";
                                                                $regards = $exbcMerchant->ref_code;
                                                                $statement_route = "wallet";

                                                                // $merchantwalletBal = $exbcMerchant->wallet_balance + $req->amounttosend;
                                                                $merchantwalletBal = $exbcMerchant->wallet_balance + $req->amount;

                                                                User::where('email', 'prepaidcard@exbc.ca')->update([
                                                                    'wallet_balance' => $merchantwalletBal
                                                                ]);

                                                                // Senders statement
                                                                $this->insStatement($exbcMerchant->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $transstatus, $action, $regards, 1, $statement_route, $exbcMerchant->country, 0);

                                                                $this->createNotification($exbcMerchant->ref_code, "Hello " . strtoupper($exbcMerchant->name) . ", " . $this->name . " has " . $message, $exbcMerchant->playerId, $message, "Wallet Transaction");

                                                                $sendMsg = 'Hello ' . strtoupper($exbcMerchant->name) . ', ' . $thisuser->name . ' has ' . $activity . '. You have ' . $req->currencyCode . ' ' . number_format($merchantwalletBal, 2) . ' balance in your account';

                                                                $userPhone = User::where('email', $exbcMerchant->email)->where('telephone', 'LIKE', '%+%')->first();

                                                                if (isset($userPhone)) {

                                                                    $sendPhone = $exbcMerchant->telephone;
                                                                } else {
                                                                    $sendPhone = "+" . $exbcMerchant->code . $exbcMerchant->telephone;
                                                                }

                                                                if ($exbcMerchant->country == "Nigeria") {

                                                                    $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                                                                    $this->sendSms($sendMsg, $correctPhone);
                                                                } else {
                                                                    $this->sendMessage($sendMsg, $sendPhone);
                                                                }
                                                            }

                                                            $resData = ['data' => $data, 'message' => $message, 'status' => $status];
                                                        } elseif ($req->card_type == "Bank Account") {

                                                            $bankDetails = AddBank::where('id', $req->card_id)->where('user_id', $thisuser->id)->first();

                                                            if (isset($bankDetails)) {

                                                                $transaction_id = "wallet-" . date('dmY') . time();
                                                                // Save Payment for Admin
                                                                // $insRec = BankWithdrawal::updateOrInsert(['transaction_id' => $transaction_id], ['transaction_id' => $transaction_id, 'ref_code' => $thisuser->ref_code, 'bank_id' => $req->card_id, 'amountToSend' => $req->amounttosend, 'country' => $thisuser->country]);
                                                                $insRec = BankWithdrawal::updateOrInsert(['transaction_id' => $transaction_id], ['transaction_id' => $transaction_id, 'ref_code' => $thisuser->ref_code, 'bank_id' => $req->card_id, 'amountToSend' => $req->amount, 'country' => $thisuser->country]);


                                                                $mydata = BankWithdrawal::where('transaction_id', $transaction_id)->first();


                                                                $status = 200;
                                                                $data = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol')->where('api_token', $req->bearerToken())->first();
                                                                $message = "Your wallet withdrawal to Bank Account " . $bankDetails->accountNumber . " - " . $bankDetails->bankName . " has been received. The Direct deposit into your Bank account would be done within the next 5 business days. Thanks";




                                                                $walletBal = $thisuser->wallet_balance - $chargeAmount;
                                                                $no_of_withdraw = $thisuser->number_of_withdrawals + 1;

                                                                User::where('api_token', $req->bearerToken())->update([
                                                                    'wallet_balance' => $walletBal,
                                                                    'number_of_withdrawals' => $no_of_withdraw
                                                                ]);


                                                                $activity = "Withdraw " . $req->currencyCode . '' . number_format($req->amount, 2) . " from Wallet to Bank Account " . $bankDetails->bankName . " - " . $bankDetails->accountNumber . ". Withdrawal fee charge of " . $req->currencyCode . '' . number_format($withdrawalCharge, 2) . " inclusive";
                                                                $credit = 0;
                                                                $debit = $req->amount + $withdrawalCharge;
                                                                $reference_code = $transaction_id;
                                                                $balance = 0;
                                                                $trans_date = date('Y-m-d');
                                                                $thistatus = "Delivered";
                                                                $action = "Wallet debit";
                                                                $regards = $thisuser->ref_code;
                                                                $statement_route = "wallet";

                                                                // Senders statement
                                                                $this->insStatement($thisuser->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $thistatus, $action, $regards, 1, $statement_route, $thisuser->country, 0);


                                                                $sendMsg = 'Hello ' . strtoupper($thisuser->name) . ', The withdrawal of ' . $req->currencyCode . ' ' . number_format($req->amount, 2) . ' to your Bank Account ' . $bankDetails->bankName . ' and Account Number: ' . $bankDetails->accountNumber . ' has been received. The Direct deposit into your Bank account would be done within the next 5 business days. Withdrawal fee charge of ' . $req->currencyCode . ' ' . number_format($withdrawalCharge, 2) . ' inclusive. You have ' . $req->currencyCode . ' ' . number_format($walletBal, 2) . ' balance in your account';



                                                                $userPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

                                                                if (isset($userPhone)) {

                                                                    $sendPhone = $thisuser->telephone;
                                                                } else {
                                                                    $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
                                                                }

                                                                $this->createNotification($thisuser->ref_code, $sendMsg, $thisuser->playerId, $sendMsg, "Wallet Transaction");


                                                                $adminMessage = "<p>Transaction ID: " . $reference_code . "</p><p>Name: " . $thisuser->name . "</p><p>Account Number: " . $thisuser->ref_code . "</p><p>Country: " . $thisuser->country . "</p><p>Date: " . date('d/m/Y h:i:a') . "</p><p>Amount to withdraw: " . $req->currencyCode . ' ' . number_format($req->amount, 2) . "</p><p>Bank Name: " . $bankDetails->bankName . "</p><p>Bank Account Number: " . $bankDetails->accountNumber . "</p><p>Status: Successful</p>";

                                                                $this->notifyAdmin("Bank withdrawal outflow", $adminMessage);

                                                                // $this->getfeeTransaction($transaction_id, $thisuser->ref_code, $req->amount, $req->commissiondeduct, $req->amounttosend);
                                                                $this->getfeeTransaction($transaction_id, $thisuser->ref_code, $req->amount, $req->commissiondeduct, $req->amount);
                                                            } else {
                                                                $data = [];
                                                                $message = "No bank record found for your account";
                                                                $status = 400;
                                                            }


                                                            $resData = ['data' => $data, 'message' => $message, 'status' => $status];
                                                        } else {

                                                            if (isset($getTrans) == true) {
                                                                $transaction_id = $getTrans->reference_code;
                                                            } else {
                                                                $transaction_id = "wallet-" . date('dmY') . time();
                                                            }

                                                            $customer_id = $thisuser->ref_code;

                                                            // Get Card Detail
                                                            $card_number = $cardDetails->card_number;
                                                            $month = $cardDetails->month;
                                                            $year = $cardDetails->year;


                                                            $this->creditCardWithdrawalRequest($thisuser->ref_code, $transaction_id, $customer_id, $card_number, $month, $year, $req->amount, $thisuser->country);


                                                            $walletBal = $thisuser->wallet_balance - $chargeAmount;
                                                            $no_of_withdraw = $thisuser->number_of_withdrawals + 1;
                                                            $withdrawal_per_day = $thisuser->withdrawal_per_day + $req->amount;
                                                            $withdrawal_per_week = $thisuser->withdrawal_per_week + $withdrawal_per_day;
                                                            $withdrawal_per_month = $thisuser->withdrawal_per_month + $withdrawal_per_week;

                                                            User::where('api_token', $req->bearerToken())->update([
                                                                'wallet_balance' => $walletBal,
                                                                'number_of_withdrawals' => $no_of_withdraw,
                                                                'withdrawal_per_day' => $withdrawal_per_day,
                                                                'withdrawal_per_week' => $withdrawal_per_week,
                                                                'withdrawal_per_month' => $withdrawal_per_month,
                                                            ]);

                                                            // Update Statement

                                                            $userData = User::select('id', 'ref_code as refCode', 'name', 'email', 'telephone', 'wallet_balance as walletBalance', 'number_of_withdrawals as noOfWithdrawals')->where('api_token', $req->bearerToken())->first();

                                                            $activity = "Withdraw " . $req->currencyCode . '' . number_format($req->amount, 2) . " from Wallet to Credit/Debit card. Withdrawal fee charge of " . $req->currencyCode . '' . number_format($withdrawalCharge, 2) . " inclusive";

                                                            $credit = 0;
                                                            $debit = $req->amount + $withdrawalCharge;
                                                            // $reference_code = $response->responseData['ReceiptId'];
                                                            $reference_code = $transaction_id;
                                                            $balance = 0;
                                                            $trans_date = date('Y-m-d');
                                                            $status = "Delivered";
                                                            $action = "Wallet debit";
                                                            $regards = $thisuser->ref_code;
                                                            $statement_route = "wallet";

                                                            // Senders statement
                                                            $this->insStatement($thisuser->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, $thisuser->country, 0);

                                                            // Notification
                                                            $cardDetails = AddCard::where('id', $req->card_id)->where('user_id', $thisuser->id)->first();

                                                            $cardNo = str_repeat("*", strlen($cardDetails->card_number) - 4) . substr($cardDetails->card_number, -4);


                                                            $this->name = $thisuser->name;
                                                            $this->email = $thisuser->email;
                                                            $this->subject = $req->currencyCode . ' ' . number_format($req->amount, 2) . " has been Withdrawn from your Wallet with PaySprint";

                                                            $this->message = '<p>The withdrawal of ' . $req->currencyCode . ' ' . number_format($req->amount, 2) . ' to your card, Card Name: <strong>' . strtoupper($cardDetails->card_name) . '</strong> and Number: <strong>' . wordwrap($cardNo, 4, '-', true) . '</strong> is successful. The withdrawal will take up to 5 working days before it reflects in your bank account or credit card. Withdrawal fee charge of ' . $req->currencyCode . '' . number_format($withdrawalCharge, 2) . ' inclusive. </p><p>You have <strong>' . $req->currencyCode . ' ' . number_format($walletBal, 2) . '</strong> balance in your wallet.</p>';



                                                            $sendMsg = 'The withdrawal of ' . $req->currencyCode . ' ' . number_format($req->amount, 2) . ' to your card, Card Name: ' . strtoupper($cardDetails->card_name) . ' and Number: ' . wordwrap($cardNo, 4, '-', true) . ' is successful. The withdrawal will take up to 5 working days before it reflects in your bank account or credit card. Withdrawal fee charge of ' . $req->currencyCode . '' . number_format($withdrawalCharge, 2) . ' inclusive. You have ' . $req->currencyCode . ' ' . number_format($walletBal, 2) . ' balance in your wallet.';

                                                            $userPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

                                                            if (isset($userPhone)) {

                                                                $sendPhone = $thisuser->telephone;
                                                            } else {
                                                                $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
                                                            }


                                                            $this->createNotification($thisuser->ref_code, $sendMsg, $thisuser->playerId, $sendMsg, "Wallet Transaction");

                                                            // $this->getfeeTransaction($reference_code, $thisuser->ref_code, $req->amount, $req->commissiondeduct, $req->amounttosend);
                                                            $this->getfeeTransaction($reference_code, $thisuser->ref_code, $req->amount, $req->commissiondeduct, $req->amount);

                                                            if ($thisuser->country == "Nigeria") {

                                                                $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                                                                $this->sendSms($sendMsg, $correctPhone);
                                                            } else {
                                                                $this->sendMessage($sendMsg, $sendPhone);
                                                            }

                                                            $this->sendEmail($this->email, "Fund remittance");

                                                            $data = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol')->where('api_token', $req->bearerToken())->first();
                                                            $status = 200;
                                                            // $message = $req->currencyCode.' '.number_format($req->amount, 2).' is debited from your Wallet';
                                                            $message = $sendMsg;
                                                        }
                                                    } else {
                                                        $data = [];
                                                        $message = "Invalid transaction pin";
                                                        $status = 400;
                                                    }
                                                } else {
                                                    // Set new transaction pin and validate

                                                    if (Hash::check($req->password, $thisuser->password)) {

                                                        if ($req->transaction_pin != $req->confirm_transaction_pin) {

                                                            $data = [];
                                                            $message = "Transaction pin does not match";
                                                            $status = 400;
                                                        } else {

                                                            // Update Transaction pin
                                                            User::where('api_token', $req->bearerToken())->update(['transaction_pin' => Hash::make($req->transaction_pin)]);


                                                            /*
                                                                1. Check card detail
                                                                2. If EXBC Prepaid Card, take to EXBC Endpoint to withdraw
                                                                3. Return Response and Debit wallet
                                                            */

                                                            // Get Card Details
                                                            $cardDetails = AddCard::where('id', $req->card_id)->where('user_id', $thisuser->id)->first();

                                                            if (isset($cardDetails) == true && $cardDetails->card_provider == "EXBC Prepaid Card" || isset($cardDetails) == true && $cardDetails->card_provider == "Prepaid Card") {

                                                                $transaction_id = "wallet-" . date('dmY') . time();
                                                                $reference_code = "PS_" . $thisuser->ref_code;

                                                                if (env('APP_ENV') == "local") {
                                                                    $url = "http://localhost:4000/api/v1/paysprint/loadcard";
                                                                } else {
                                                                    $url = "https://exbc.ca/api/v1/paysprint/loadcard";
                                                                }

                                                                $mydata = array(
                                                                    'transaction_id' => $transaction_id,
                                                                    'reference_code' => $reference_code,
                                                                    'email' => $thisuser->email,
                                                                    // 'amount' => $req->amounttosend,
                                                                    'amount' => $req->amount,
                                                                    'card_number' => $cardDetails->card_number,
                                                                    'name' => $thisuser->name,
                                                                );

                                                                $token = "base64:HgMO6FDHGziGl01OuLH9mh7CeP095shB6uuDUUClhks=";


                                                                $response = $this->curlPost($url, $mydata, $token);


                                                                if ($response->status == 200) {
                                                                    $resData = $this->debitWalletForCard($thisuser->ref_code, $req->amount, $cardDetails->card_provider, $transaction_id, "live");

                                                                    $status = $resData['status'];
                                                                    $data = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol')->where('api_token', $req->bearerToken())->first();
                                                                    $message = $response->message;
                                                                } else {
                                                                    $status = $response->status;
                                                                    $data = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol')->where('api_token', $req->bearerToken())->first();
                                                                    $message = $response->message;
                                                                    $resData = ['data' => $data, 'message' => $message, 'status' => $status];
                                                                }

                                                                $activity = "Withdraw " . $req->currencyCode . ' ' . $req->amount . " from Wallet to EXBC Prepaid Card. Withdrawal fee charge of " . $req->currencyCode . '' . number_format($withdrawalCharge, 2) . " inclusive";
                                                                $credit = 0;
                                                                $debit = $req->amount + $withdrawalCharge;
                                                                $reference_code = $transaction_id;
                                                                $balance = 0;
                                                                $trans_date = date('Y-m-d');
                                                                $transstatus = "Delivered";
                                                                $action = "Wallet debit";
                                                                $regards = $thisuser->ref_code;
                                                                $statement_route = "wallet";

                                                                $walletBal = $thisuser->wallet_balance - $chargeAmount;
                                                                $no_of_withdraw = $thisuser->number_of_withdrawals + 1;
                                                                $withdrawal_per_day = $thisuser->withdrawal_per_day + $req->amount;
                                                                $withdrawal_per_week = $thisuser->withdrawal_per_week + $withdrawal_per_day;
                                                                $withdrawal_per_month = $thisuser->withdrawal_per_month + $withdrawal_per_week;

                                                                User::where('api_token', $req->bearerToken())->update([
                                                                    'wallet_balance' => $walletBal,
                                                                    'number_of_withdrawals' => $no_of_withdraw,
                                                                    'withdrawal_per_day' => $withdrawal_per_day,
                                                                    'withdrawal_per_week' => $withdrawal_per_week,
                                                                    'withdrawal_per_month' => $withdrawal_per_month,
                                                                ]);

                                                                // Senders statement
                                                                $this->insStatement($thisuser->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $transstatus, $action, $regards, 1, $statement_route, $thisuser->country, 0);

                                                                $this->createNotification($thisuser->ref_code, "Hello " . strtoupper($thisuser->name) . ", " . $message, $thisuser->playerId, $message, "Wallet Transaction");

                                                                // $this->getfeeTransaction($transaction_id, $thisuser->ref_code, $req->amount, $req->commissiondeduct, $req->amounttosend);
                                                                $this->getfeeTransaction($transaction_id, $thisuser->ref_code, $req->amount, $req->commissiondeduct, $req->amount);


                                                                // Create Statement And Credit EXBC account holder
                                                                $exbcMerchant = User::where('email', 'prepaidcard@exbc.ca')->first();

                                                                if (isset($exbcMerchant)) {

                                                                    // $activity = "Added ".$req->currencyCode.''.number_format($req->amounttosend, 2)." to your Wallet to load EXBC Prepaid Card";
                                                                    // $credit = $req->amounttosend;
                                                                    $activity = "Added " . $req->currencyCode . '' . number_format($req->amount, 2) . " to your Wallet to load EXBC Prepaid Card";
                                                                    $credit = $req->amount;
                                                                    $debit = 0;
                                                                    $reference_code = $transaction_id;
                                                                    $balance = 0;
                                                                    $trans_date = date('Y-m-d');
                                                                    $transstatus = "Delivered";
                                                                    $action = "Wallet credit";
                                                                    $regards = $exbcMerchant->ref_code;
                                                                    $statement_route = "wallet";

                                                                    // $merchantwalletBal = $exbcMerchant->wallet_balance + $req->amounttosend;
                                                                    $merchantwalletBal = $exbcMerchant->wallet_balance + $req->amount;

                                                                    User::where('email', 'prepaidcard@exbc.ca')->update([
                                                                        'wallet_balance' => $merchantwalletBal
                                                                    ]);

                                                                    // Senders statement
                                                                    $this->insStatement($exbcMerchant->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $transstatus, $action, $regards, 1, $statement_route, $exbcMerchant->country, 0);

                                                                    $this->createNotification($exbcMerchant->ref_code, "Hello " . strtoupper($exbcMerchant->name) . ", " . $this->name . " has " . $message, $exbcMerchant->playerId, $message, "Wallet Transaction");

                                                                    $sendMsg = 'Hello ' . strtoupper($exbcMerchant->name) . ', ' . $thisuser->name . ' has ' . $activity . '. You have ' . $req->currencyCode . ' ' . number_format($merchantwalletBal, 2) . ' balance in your account';

                                                                    $userPhone = User::where('email', $exbcMerchant->email)->where('telephone', 'LIKE', '%+%')->first();

                                                                    if (isset($userPhone)) {

                                                                        $sendPhone = $exbcMerchant->telephone;
                                                                    } else {
                                                                        $sendPhone = "+" . $exbcMerchant->code . $exbcMerchant->telephone;
                                                                    }

                                                                    if ($exbcMerchant->country == "Nigeria") {

                                                                        $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                                                                        $this->sendSms($sendMsg, $correctPhone);
                                                                    } else {
                                                                        $this->sendMessage($sendMsg, $sendPhone);
                                                                    }
                                                                } else {
                                                                    // Do nothing
                                                                }


                                                                $resData = ['data' => $data, 'message' => $message, 'status' => $status];
                                                            } elseif ($req->card_type == "Bank Account") {

                                                                $bankDetails = AddBank::where('id', $req->card_id)->where('user_id', $thisuser->id)->first();
                                                                $transaction_id = "wallet-" . date('dmY') . time();
                                                                // Save Payment for Admin
                                                                // $insRec = BankWithdrawal::updateOrInsert(['transaction_id' => $transaction_id], ['transaction_id' => $transaction_id, 'ref_code' => $thisuser->ref_code, 'bank_id' => $req->card_id, 'amountToSend' => $req->amounttosend, 'country' => $thisuser->country]);
                                                                $insRec = BankWithdrawal::updateOrInsert(['transaction_id' => $transaction_id], ['transaction_id' => $transaction_id, 'ref_code' => $thisuser->ref_code, 'bank_id' => $req->card_id, 'amountToSend' => $req->amount, 'country' => $thisuser->country]);


                                                                $mydata = BankWithdrawal::where('transaction_id', $transaction_id)->first();


                                                                $status = 200;
                                                                $data = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol')->where('api_token', $req->bearerToken())->first();
                                                                $message = "Your wallet withdrawal to Bank Account " . $bankDetails->accountNumber . " - " . $bankDetails->bankName . " has been received. The Direct deposit into your Bank account would be done within the next 5 business days. Thanks";




                                                                $walletBal = $thisuser->wallet_balance - $chargeAmount;
                                                                $no_of_withdraw = $thisuser->number_of_withdrawals + 1;
                                                                $withdrawal_per_day = $thisuser->withdrawal_per_day + $req->amount;
                                                                $withdrawal_per_week = $thisuser->withdrawal_per_week + $withdrawal_per_day;
                                                                $withdrawal_per_month = $thisuser->withdrawal_per_month + $withdrawal_per_week;

                                                                User::where('api_token', $req->bearerToken())->update([
                                                                    'wallet_balance' => $walletBal,
                                                                    'number_of_withdrawals' => $no_of_withdraw,
                                                                    'withdrawal_per_day' => $withdrawal_per_day,
                                                                    'withdrawal_per_week' => $withdrawal_per_week,
                                                                    'withdrawal_per_month' => $withdrawal_per_month,
                                                                ]);


                                                                $activity = "Withdraw " . $req->currencyCode . '' . number_format($req->amount, 2) . " from Wallet to Bank Account " . $bankDetails->bankName . " - " . $bankDetails->accountNumber . ". Withdrawal fee charge of " . $req->currencyCode . '' . number_format($withdrawalCharge, 2) . " inclusive";
                                                                $credit = 0;
                                                                $debit = $req->amount + $withdrawalCharge;
                                                                $reference_code = $transaction_id;
                                                                $balance = 0;
                                                                $trans_date = date('Y-m-d');
                                                                $thistatus = "Delivered";
                                                                $action = "Wallet debit";
                                                                $regards = $thisuser->ref_code;
                                                                $statement_route = "wallet";

                                                                // Senders statement
                                                                $this->insStatement($thisuser->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $thistatus, $action, $regards, 1, $statement_route, $thisuser->country, 0);


                                                                $sendMsg = 'Hello ' . strtoupper($thisuser->name) . ', The withdrawal of ' . $req->currencyCode . ' ' . number_format($req->amount, 2) . ' to your Bank Account ' . $bankDetails->bankName . ' and Account Number: ' . $bankDetails->accountNumber . ' has been received. The Direct deposit into your Bank account would be done within the next 5 business days. Withdrawal fee charge of ' . $req->currencyCode . ' ' . number_format($withdrawalCharge, 2) . ' inclusive. You have ' . $req->currencyCode . ' ' . number_format($walletBal, 2) . ' balance in your account';



                                                                $userPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

                                                                if (isset($userPhone)) {

                                                                    $sendPhone = $thisuser->telephone;
                                                                } else {
                                                                    $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
                                                                }

                                                                $this->createNotification($thisuser->ref_code, $sendMsg, $thisuser->playerId, $sendMsg, "Wallet Transaction");

                                                                // $this->getfeeTransaction($transaction_id, $thisuser->ref_code, $req->amount, $req->commissiondeduct, $req->amounttosend);
                                                                $this->getfeeTransaction($transaction_id, $thisuser->ref_code, $req->amount, $req->commissiondeduct, $req->amount);



                                                                $resData = ['data' => $data, 'message' => $message, 'status' => $status];
                                                            } else {

                                                                if (isset($getTrans) == true) {
                                                                    $transaction_id = $getTrans->reference_code;
                                                                } else {
                                                                    $transaction_id = "wallet-" . date('dmY') . time();
                                                                }

                                                                $customer_id = $thisuser->ref_code;

                                                                // Get Card Detail
                                                                $card_number = $cardDetails->card_number;
                                                                $month = $cardDetails->month;
                                                                $year = $cardDetails->year;


                                                                $this->creditCardWithdrawalRequest($thisuser->ref_code, $transaction_id, $customer_id, $card_number, $month, $year, $req->amount, $thisuser->country);



                                                                $walletBal = $thisuser->wallet_balance - $chargeAmount;
                                                                $no_of_withdraw = $thisuser->number_of_withdrawals + 1;

                                                                User::where('api_token', $req->bearerToken())->update([
                                                                    'wallet_balance' => $walletBal,
                                                                    'number_of_withdrawals' => $no_of_withdraw
                                                                ]);

                                                                // Update Statement

                                                                $userData = User::select('id', 'ref_code as refCode', 'name', 'email', 'telephone', 'wallet_balance as walletBalance', 'number_of_withdrawals as noOfWithdrawals')->where('api_token', $req->bearerToken())->first();

                                                                $activity = "Withdraw " . $req->currencyCode . '' . number_format($req->amount, 2) . " from Wallet to Credit/Debit card. Withdrawal fee charge of " . $req->currencyCode . ' ' . number_format($withdrawalCharge, 2) . " inclusive";
                                                                $credit = 0;
                                                                $debit = $req->amount + $withdrawalCharge;
                                                                // $reference_code = $response->responseData['ReceiptId'];
                                                                $reference_code = $transaction_id;
                                                                $balance = 0;
                                                                $trans_date = date('Y-m-d');
                                                                $status = "Delivered";
                                                                $action = "Wallet debit";
                                                                $regards = $thisuser->ref_code;
                                                                $statement_route = "wallet";

                                                                // Senders statement
                                                                $this->insStatement($thisuser->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, $thisuser->country, 0);

                                                                // $this->getfeeTransaction($reference_code, $thisuser->ref_code, $req->amount, $req->commissiondeduct, $req->amounttosend);
                                                                $this->getfeeTransaction($reference_code, $thisuser->ref_code, $req->amount, $req->commissiondeduct, $req->amount);


                                                                // Notification

                                                                $cardDetails = AddCard::where('id', $req->card_id)->where('user_id', $thisuser->id)->first();

                                                                $cardNo = str_repeat("*", strlen($cardDetails->card_number) - 4) . substr($cardDetails->card_number, -4);

                                                                $this->name = $thisuser->name;
                                                                $this->email = $thisuser->email;
                                                                $this->subject = $req->currencyCode . ' ' . number_format($req->amount, 2) . " has been Withdrawn from your Wallet with PaySprint";

                                                                $this->message = '<p>The withdrawal of ' . $req->currencyCode . ' ' . number_format($req->amount, 2) . ' to your card, Card Name: <strong>' . strtoupper($cardDetails->card_name) . '</strong> and Number: <strong>' . wordwrap($cardNo, 4, '-', true) . '</strong> is successful. The withdrawal will take up to 5 working days before it reflects in your bank account or credit card. Withdrawal fee charge of ' . $req->currencyCode . ' ' . number_format($withdrawalCharge, 2) . ' inclusive. </p><p>You have <strong>' . $req->currencyCode . ' ' . number_format($walletBal, 2) . '</strong> balance in your wallet.</p>';

                                                                $sendMsg = 'The withdrawal of ' . $req->currencyCode . ' ' . number_format($req->amount, 2) . ' to your card, Card Name: ' . strtoupper($cardDetails->card_name) . ' and Number: ' . wordwrap($cardNo, 4, '-', true) . ' is successful. The withdrawal will take up to 5 working days before it reflects in your bank account or credit card. Withdrawal fee charge of ' . $req->currencyCode . ' ' . number_format($withdrawalCharge, 2) . ' inclusive. You have ' . $req->currencyCode . ' ' . number_format($walletBal, 2) . ' balance in your wallet.';

                                                                $userPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

                                                                if (isset($userPhone)) {

                                                                    $sendPhone = $thisuser->telephone;
                                                                } else {
                                                                    $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
                                                                }


                                                                $this->createNotification($thisuser->ref_code, $sendMsg, $thisuser->playerId, $sendMsg, "Wallet Transaction");

                                                                if ($thisuser->country == "Nigeria") {

                                                                    $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                                                                    $this->sendSms($sendMsg, $correctPhone);
                                                                } else {
                                                                    $this->sendMessage($sendMsg, $sendPhone);
                                                                }

                                                                $this->sendEmail($this->email, "Fund remittance");


                                                                $userInfo = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol')->where('api_token', $req->bearerToken())->first();

                                                                $data = $userInfo;
                                                                $status = 200;
                                                                $message = $sendMsg;
                                                            }
                                                        }
                                                    } else {
                                                        $data = [];
                                                        $message = "Invalid login password";
                                                        $status = 400;
                                                    }
                                                }
                                            } else {

                                                $data = [];
                                                $message = "Withdrawal to " . strtoupper($req->card_type) . " not yet activated for your country.";
                                                $status = 400;

                                                // Log::info('Oops!, '.$thisuser->name.', '.$message);

                                                $this->slack('Oops!, ' . $thisuser->name . ', ' . $message, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));
                                            }
                                        }

                                }
                            }
                        } else {
                            $data = [];
                            $status = 400;
                            $message = $checkIdv['response'];
                        }
                    } else {

                        $error = implode(",", $validator->messages()->all());

                        $data = [];
                        $status = 400;
                        $message = $error;
                    }
                }
            }
        }


        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

        return $this->returnJSON($resData, $status);
    }


    public function paymentChargeBack(Request $req)
    {


        try {
            // Get Transaction Info
            $data = Statement::where('reference_code', $req->reference_code)->first();


            // Insert Record to ChargeBack
            $query = [
                'user_id' => $data->user_id,
                'reference_code' => $data->reference_code,
                'activity' => $data->activity,
                'credit' => $data->credit,
                'debit' => $data->debit,
                'balance' => $data->balance,
                'chargefee' => $data->chargefee,
                'auto_deposit' => $data->auto_deposit,
                'trans_date' => $data->trans_date,
                'status' => $data->status,
                'comment' => $data->comment,
                'action' => $data->action,
                'regards' => $data->regards,
                'notify' => $data->notify,
                'state' => $data->state,
                'country' => $data->country,
                'statement_route' => $data->statement_route,
                'report_status' => $data->report_status
            ];

            ChargeBack::insert($query);

            $thisuser = User::where('email', $data->user_id)->first();

            if ($thisuser->accountType == "Individual") {
                $subType = "Consumer Monthly Subscription";
            } else {
                $subType = "Merchant Monthly Subscription";
            }

            $checkTransaction = TransactionCost::where('method', 'Wallet')->where('structure', $subType)->where('country', $data->country)->first();

            $transDeduct = $data->credit + $checkTransaction->fixed;

            $walletBal = $thisuser->wallet_balance - $transDeduct;


            User::where('email', $thisuser->email)->update([
                'wallet_balance' => $walletBal
            ]);


            $activity = "Charge back of " . $thisuser->currencyCode . '' . number_format($transDeduct, 2) . " (Charge back amount of " . $thisuser->currencyCode . '' . number_format($data->credit, 2) . " and " . $subType . " of " . $thisuser->currencyCode . '' . number_format($checkTransaction->fixed, 2) . " inclusive.) from PaySprint to your Bank Account has been processed.";

            $credit = 0;
            $debit = $data->credit;
            $reference_code = $data->reference_code;
            $balance = 0;
            $trans_date = date('Y-m-d');
            $thistatus = "Reversal";
            $action = "Wallet Reversal";
            $regards = $thisuser->ref_code;
            $statement_route = "wallet";

            // Senders statement
            $this->insStatement($thisuser->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $thistatus, $action, $regards, 1, $statement_route, $thisuser->country, 0);


            MonerisActivity::where('transaction_id', $req->reference_code)->update(['reversal_state' => 1]);


            $sendMsg = 'Hello ' . strtoupper($thisuser->name) . ', The charge back request of ' . $thisuser->currencyCode . ' ' . number_format($data->credit, 2) . ' from PaySprint to your Bank Account has been processed. The Direct deposit into your Bank account would be done within the next 5 business days. You have ' . $thisuser->currencyCode . ' ' . number_format($walletBal, 2) . ' balance in your account';



            $userPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

            if (isset($userPhone)) {

                $sendPhone = $thisuser->telephone;
            } else {
                $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
            }


            $this->createNotification($thisuser->ref_code, $sendMsg, $thisuser->playerId, $sendMsg, "Wallet Transaction");

            if ($thisuser->country == "Nigeria") {

                $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                $this->sendSms($sendMsg, $correctPhone);
            } else {
                $this->sendMessage($sendMsg, $sendPhone);
            }



            // Log::info("Reversal successfull! ".strtoupper($thisuser->name)." ".$sendMsg);

            $this->slack("Reversal successfull! " . strtoupper($thisuser->name) . " " . $sendMsg, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));


            $message = "Reversal successfully completed";
            $status = 200;
        } catch (\Throwable $th) {
            $message = $th->getMessage();
            $status = 400;
            $thisuser = [];
        }


        $resData = ['data' => $thisuser, 'message' => $message, 'status' => $status];


        return $this->returnJSON($resData, $status);
    }

    public function reverseCrossBorder(Request $req)
    {
   
        try {
            // Get Transaction Info
            $transaction=CrossBorder::where('transaction_id',$req->transactionid)->first();
          
            
            $country=$transaction->country;

 
            
      
            $paymentmethod=$transaction->select_wallet;

              

            if($paymentmethod == 'FX Wallet'){

             $data=FxStatement::where('reference_code',$req->transactionid)->first();
             
             
            
              $border = CrossBorder::where('transaction_id', $data->reference_code)->first();
              
             
                $escrow=EscrowAccount::where('escrow_id',$data->user_id)->first();

              
                         
              $thisuser=User::where('id',$escrow->user_id)->first();

               
               
                $currentbalance=$escrow->wallet_balance;
             
                $amount=$data->debit;
                $newamount=$currentbalance + $amount;

        
                
            EscrowAccount::where('escrow_id',$data->user_id)->update([
                        'wallet_balance' => $newamount
                    ]);
            CrossBorder::where('transaction_id',$req->transactionid)->delete();
            FxStatement::where('reference_code',$req->transactionid)->delete();

            //statement savings
            $activity = "Reversal of " . $thisuser->currencyCode . '' . number_format($amount, 2) . " (Reversal amount of " . $thisuser->currencyCode . '' . number_format($amount, 2) . " for cross border payment.";

            $credit = $amount;
            $debit = 0;
            $reference_code = $data->reference_code;
            $balance = $newamount;
            $trans_date = date('Y-m-d');
            $thistatus = "Reversal";
            $action = "Cross-Border Reversal";
            $regards = $thisuser->ref_code;
            $statement_route = "wallet";

            // Senders statement
            $this->insStatement($thisuser->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $thistatus, $action, $regards, 1, $statement_route, $thisuser->country, 0);


            // MonerisActivity::where('transaction_id', $req->reference_code)->update(['reversal_state' => 1]);


            $sendMsg = 'Hello ' . strtoupper($thisuser->name) . ', The reversal of ' . $thisuser->currencyCode . ' ' . number_format($amount, 2) . ' to your PaySprint Fx Wallet has been processed. You have ' . $thisuser->currencyCode . ' ' . number_format($newamount, 2) . ' balance in your account';



            $userPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

            if (isset($userPhone)) {

                $sendPhone = $thisuser->telephone;
            } else {
                $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
            }


            $this->createNotification($thisuser->ref_code, $sendMsg, $thisuser->playerId, $sendMsg, "Wallet Transaction");

            if ($thisuser->country == "Nigeria") {

                $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                $this->sendSms($sendMsg, $correctPhone);
            } else {
                $this->sendMessage($sendMsg, $sendPhone);
            }



            // Log::info("Reversal successfull! ".strtoupper($thisuser->name)." ".$sendMsg);

            $this->slack("Reversal successfull! " . strtoupper($thisuser->name) . " " . $sendMsg, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));


            $message = "Reversal successfully completed";
            $status = 200;

            $resData = ['data' => $thisuser, 'message' => $message, 'status' => $status];


        return $this->returnJSON($resData, $status);
                
            }elseif($paymentmethod == 'Wallet'){

            $data=Statement::where('reference_code',$req->transactionid)->first();
            dd($data);

                 
            $escrow = CrossBorder::where('transaction_id', $data->reference_code)->first();
            
             $thisuser=User::where('ref_code',$escrow->ref_code)->first();
               
             
                     $currentbalance=$thisuser->wallet_balance;
                    $amount=$data->debit;
                        $newamount=$currentbalance+$amount;
                     User::where('ref_code',$escrow->ref_code)->update([
                        'wallet_balance' => $newamount
                    ]);
          
          
            CrossBorder::where('transaction_id',$data->reference_code)->delete();
            Statement::where('reference_code',$req->transactionid)->delete();
             //statement savings
            $activity = "Reversal of " . $thisuser->currencyCode . '' . number_format($amount, 2) . " (Reversal amount of " . $thisuser->currencyCode . '' . number_format($amount, 2) . " for cross border payment.";
                   
            $credit = $amount;
            $debit = 0;
            $reference_code = $data->reference_code;
            $balance = $newamount;
            $trans_date = date('Y-m-d');
            $thistatus = "Reversal";
            $action = "Cross-Border Reversal";
            $regards = $thisuser->ref_code;
            $statement_route = "wallet";

            // Senders statement
            $this->insStatement($thisuser->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $thistatus, $action, $regards, 1, $statement_route, $thisuser->country, 0);


            // MonerisActivity::where('transaction_id', $req->reference_code)->update(['reversal_state' => 1]);


            $sendMsg = 'Hello ' . strtoupper($thisuser->name) . ', The reversal of ' . $thisuser->currencyCode . ' ' . number_format($amount, 2) . ' to your PaySprint Wallet has been processed. You have ' . $thisuser->currencyCode . ' ' . number_format($newamount, 2) . ' balance in your account';



            $userPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

            if (isset($userPhone)) {

                $sendPhone = $thisuser->telephone;
            } else {
                $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
            }


            $this->createNotification($thisuser->ref_code, $sendMsg, $thisuser->playerId, $sendMsg, "Wallet Transaction");

            if ($thisuser->country == "Nigeria") {

                $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                $this->sendSms($sendMsg, $correctPhone);
            } else {
                $this->sendMessage($sendMsg, $sendPhone);
            }



            // Log::info("Reversal successfull! ".strtoupper($thisuser->name)." ".$sendMsg);

            $this->slack("Reversal successfull! " . strtoupper($thisuser->name) . " " . $sendMsg, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));


            $message = "Reversal successfully completed";
            $status = 200;

            $resData = ['data' => $thisuser, 'message' => $message, 'status' => $status];


        return $this->returnJSON($resData, $status);
            }
        } catch (\Throwable $th) {
            $message = $th->getMessage();
            $status = 400;
            $thisuser = [];
        }


        
    }

    //softdelete for transaction
    public function deleteTransaction(Request $req)
    {

         $data = MonerisActivity::where('transaction_id', $req->transactionid)->delete();

        return back()->with("msg", "<div class='alert alert-success'>Transaction Deleted Successfully</div>");
    }

    //retore deleted transactions
    public function restoreTransaction(Request $req)
    {

         $data = MonerisActivity::withTrashed()->where('transaction_id',$req->transactionid)->restore();

        return back()->with("msg", "<div class='alert alert-success'>Transaction restored Successfully</div>");

    }


    public function paymentReleaseFeeBack(Request $req)
    {


        try {
            // Get Transaction Info
            $data = Statement::where('reference_code', $req->reference_code)->first();


            $thisuser = User::where('email', $data->user_id)->first();



            $transDeduct = $thisuser->hold_balance - $data->credit;

            $walletBal = $thisuser->wallet_balance + $data->credit;


            User::where('email', $thisuser->email)->update([
                'wallet_balance' => $walletBal,
                'hold_balance' => $transDeduct
            ]);


            Statement::where('reference_code', $req->reference_code)->update(['hold_fee' => 0]);
            MonerisActivity::where('transaction_id', $req->reference_code)->update(['hold_fee' => 0]);

            $query = [
                'user_id' => session('user_id'),
                'name' => session('firstname') . ' ' . session('lastname'),
                'activity' => 'Released hold fund for ' . $thisuser->name . ' : ' . date('d-M-Y h:i:a'),
            ];

            $this->createSupportActivity($query);



            $sendMsg = 'Hello ' . strtoupper($thisuser->name) . ', ' . $thisuser->currencyCode . ' ' . number_format($data->credit, 2) . ' processed by PaySprint to your wallet. You have ' . $thisuser->currencyCode . ' ' . number_format($walletBal, 2) . ' balance in your account';


            // Mail Customer

            $this->name = $thisuser->name;
            $this->email = $thisuser->email;
            $this->subject = $thisuser->currencyCode . ' ' . number_format($data->credit, 2) . " now added to your wallet with PaySprint";

            $this->message = '<strong>' . $thisuser->currencyCode . ' ' . number_format($data->credit, 2) . '</strong> processed by PaySprint to your wallet. You have <strong>' . $thisuser->currencyCode . ' ' . number_format($walletBal, 2) . '</strong> balance in your account</p>';

            $sendMsg = $thisuser->currencyCode . ' ' . number_format($data->credit, 2) . ' processed by PaySprint to your wallet. You have ' . $thisuser->currencyCode . ' ' . number_format($walletBal, 2) . ' balance in your account';

            $userPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

            if (isset($userPhone)) {

                $sendPhone = $thisuser->telephone;
            } else {
                $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
            }

            if ($thisuser->country == "Nigeria") {

                $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                $this->sendSms($sendMsg, $correctPhone);
            } else {
                $this->sendMessage($sendMsg, $sendPhone);
            }


            $this->sendEmail($this->email, "Fund remittance");



            // Log::info("Reversal successfull! ".strtoupper($thisuser->name)." ".$sendMsg);

            $this->slack("Processed fee successfully to " . strtoupper($thisuser->name) . " " . $sendMsg, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));


            $message = "Fund processed successfully";
            $status = 200;
        } catch (\Throwable $th) {
            $message = $th->getMessage();
            $status = 400;
            $thisuser = [];
        }


        $resData = ['data' => $thisuser, 'message' => $message, 'status' => $status];


        return $this->returnJSON($resData, $status);
    }


    public function getCommissionConversion(Request $req)
    {

        $thisuser = User::where('api_token', $req->bearerToken())->first();

        $thisData = $this->getCommissionData($req->amount, $req->billerCode, $thisuser->country);

        $resData = ['data' => $thisData, 'message' => 'success', 'status' => 200];

        return $this->returnJSON($resData, 200);
    }

    public function getProductDetails($id)
    {

        try {
            $thisData = $this->getUtilityProduct($id);
            $status = 200;
            $resData = ['data' => $thisData, 'message' => 'success', 'status' => $status];
        } catch (\Throwable $th) {

            $status = 400;
            $resData = ['data' => $th->getMessage(), 'message' => 'error', 'status' => $status];
        }

        return $this->returnJSON($resData, $status);
    }


    public function paymentLookUp(Request $req)
    {


        $thisuser = User::where('api_token', $req->bearerToken())->first();

        $thisData = $this->getLookUp($req->billerCode, $req->accountNumber);

        if ($thisData->responseCode == "0") {
            $status = 200;
            $resData = ['data' => $thisData, 'message' => 'success', 'status' => $status];
        } else {
            $status = 400;
            $resData = ['data' => $thisData, 'message' => 'error', 'status' => $status];
        }


        return $this->returnJSON($resData, $status);
    }


    public function payUtilityBills(Request $req)
    {

        $thisuser = User::where('api_token', $req->bearerToken())->first();

        if ($thisuser->flagged === 1) {
            $data = [];
            $message = 'Hello ' . $thisuser->name . ', Access to the account is not currently available. Kindly contact the Admin using this link: https://paysprint.ca/contact.';
            $status = 400;
        } else {
            if ($req->totalcharge < 0) {
                $data = [];
                $message = "Please enter a positive amount";
                $status = 400;
            } else {
                // Payment for UTILITY

                $validator = Validator::make($req->all(), [
                    'transaction_pin' => 'required|string',
                    'amounttosend' => 'required|string',
                    'commissiondeduct' => 'required|string',
                ]);



                if ($validator->passes()) {




                    // $minBal = $this->minimumWithdrawal($thisuser->country);



                    if ($thisuser->accountType == "Individual") {
                        $subminType = "Consumer Monthly Subscription";
                    } else {
                        $subminType = "Merchant Monthly Subscription";
                    }
                    $minBal = $this->maintenanceBalanceWithdrawal($subminType, $thisuser->country);

                    $vendorNames = EPSVendor::where('billerCode', $req->billerCode)->first();

                    $billerName = $vendorNames->billerName;

                    // Check amount in wallet
                    if ($req->totalcharge > $thisuser->wallet_balance) {
                        // Insufficient amount for withdrawal

                        $data = [];
                        $message = "Insufficient amount to complete transaction";
                        $status = 400;

                        // Log::info('Oops!, '.$thisuser->name.' has '.$message);

                        $this->slack('Oops!, ' . $thisuser->name . ' has ' . $message, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));
                    } elseif ($thisuser->approval < 2 && $thisuser->accountLevel <= 2) {
                        // If Account not approved then they cannot pay bills

                        // Cannot withdraw minimum balance

                        $data = [];
                        $message = "Please upload your Utility bill with your current address for verification";
                        $status = 400;

                        // Log::info('Oops!, '.$thisuser->name.' has '.$message);

                        $this->slack('Oops!, ' . $thisuser->name . ' has ' . $message, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));
                    } elseif (($thisuser->wallet_balance - $minBal) <= $req->totalcharge) {
                        // Cannot withdraw minimum balance

                        $minWalBal = $thisuser->wallet_balance - $minBal;

                        $data = [];
                        $message = "Your available wallet balance is " . $thisuser->currencyCode . ' ' . number_format($minWalBal, 2) . ". Please add money to continue transaction";
                        $status = 400;

                        // Log::info('Oops!, '.$thisuser->name.' has '.$message);

                        $this->slack('Oops!, ' . $thisuser->name . ' has ' . $message, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));
                    } else {

                        // Check Transaction PIn
                        if ($thisuser->transaction_pin != null) {
                            // Validate Transaction PIN
                            if (Hash::check($req->transaction_pin, $thisuser->transaction_pin)) {

                                // Load Utility Bill.
                                $billPayResponse = $this->processTransaction($req->all(), $req->bearerToken());


                                if ($billPayResponse->responseCode == 00 || $billPayResponse->responseCode == 0) {

                                    if (isset($billPayResponse->status) && $billPayResponse->status == 400) {

                                        $data = [];
                                        $message = $billPayResponse->responseMessage;
                                        $status = 400;

                                        // Log::info('Oops!, '.$thisuser->name.' has '.$message);

                                        $this->slack('Oops!, ' . $thisuser->name . ' has ' . $message, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));
                                    } else {

                                        if (isset($billPayResponse)) {

                                            $transaction_id = $billPayResponse->transRef;


                                            // Proceed to Withdrawal

                                            $walletBal = $thisuser->wallet_balance - $req->amounttosend;


                                            User::where('api_token', $req->bearerToken())->update([
                                                'wallet_balance' => $walletBal
                                            ]);

                                            // Update Statement

                                            $userData = User::select('id', 'ref_code as refCode', 'name', 'email', 'telephone', 'wallet_balance as walletBalance', 'number_of_withdrawals as noOfWithdrawals')->where('api_token', $req->bearerToken())->first();

                                            $activity = $billPayResponse->responseMessage . " | Withdraw " . $thisuser->currencyCode . '' . number_format($req->amounttosend, 2) . " from Wallet for " . strtoupper($billerName);
                                            $credit = 0;
                                            $debit = $req->amounttosend;
                                            // $reference_code = $response->responseData['ReceiptId'];
                                            $reference_code = $transaction_id;
                                            $balance = 0;
                                            $trans_date = date('Y-m-d');
                                            $status = "Delivered";
                                            $action = "Wallet debit";
                                            $regards = $thisuser->ref_code;
                                            $statement_route = "wallet";

                                            // Senders statement
                                            $this->insStatement($thisuser->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, $thisuser->country, 0);


                                            $this->name = $thisuser->name;
                                            $this->email = $thisuser->email;
                                            $this->subject = $thisuser->currencyCode . ' ' . number_format($req->amounttosend, 2) . " has been Withdrawn from your Wallet with PaySprint";

                                            $this->message = '<p>' . $billPayResponse->responseMessage . '</p><br><p>Recharge of ' . strtoupper($billerName) . ' for a sum of ' . $thisuser->currencyCode . ' ' . number_format($req->amounttosend, 2) . ' from your PaySprint wallet is successful. </p><p>You have <strong>' . $thisuser->currencyCode . ' ' . number_format($walletBal, 2) . '</strong> balance in your wallet.</p>';



                                            $sendMsg = $billPayResponse->responseMessage . ' .Recharge of ' . strtoupper($billerName) . ' for a sum of ' . $thisuser->currencyCode . ' ' . number_format($req->amounttosend, 2) . ' from your PaySprint wallet is successful. You have ' . $thisuser->currencyCode . ' ' . number_format($walletBal, 2) . ' balance in your wallet.';

                                            $userPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

                                            if (isset($userPhone)) {

                                                $sendPhone = $thisuser->telephone;
                                            } else {
                                                $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
                                            }


                                            $this->createNotification($thisuser->ref_code, $sendMsg, $thisuser->playerId, $sendMsg, "Wallet Transaction");

                                            $this->getfeeTransaction($reference_code, $thisuser->ref_code, $req->amounttosend, $req->commissiondeduct, $req->amounttosend);

                                            if ($thisuser->country == "Nigeria") {

                                                $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                                                $this->sendSms($sendMsg, $correctPhone);
                                            } else {
                                                $this->sendMessage($sendMsg, $sendPhone);
                                            }

                                            $this->sendEmail($this->email, "Fund remittance");

                                            $data = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol', 'bvn_account_number', 'bvn_bank', 'bvn_account_name', 'bvn_verification')->where('api_token', $req->bearerToken())->first();
                                            $status = 200;

                                            $message = $sendMsg;

                                            // Log::info('Congratulations!, '.$thisuser->name.' '.$message);

                                            $this->slack('Congratulations!, ' . $thisuser->name . ' has ' . $message, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));
                                        } else {

                                            $data = [];
                                            $message = "Something went wrong!. Please try again later.";
                                            $status = 400;

                                            // Log::critical("Check EPS end for this error!.");

                                            $this->slack("Check EPS end for this error!.", $room = "error-logs", $icon = ":longbox:", env('LOG_SLACK_WEBHOOK_URL'));
                                        }
                                    }
                                } else {

                                    $data = [];
                                    $message = $billPayResponse->responseMessage;
                                    $status = 400;

                                    // Log::info('Oops!, '.$message);

                                    $this->slack('Oops!, ' . $message, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));
                                }
                            } else {
                                $data = [];
                                $message = "Invalid transaction pin";
                                $status = 400;
                            }
                        } else {
                            // Set new transaction pin and validate

                            if (Hash::check($req->password, $thisuser->password)) {

                                if ($req->transaction_pin != $req->confirm_transaction_pin) {

                                    $data = [];
                                    $message = "Transaction pin does not match";
                                    $status = 400;
                                } else {

                                    // Update Transaction pin
                                    User::where('api_token', $req->bearerToken())->update(['transaction_pin' => Hash::make($req->transaction_pin)]);

                                    // Load Utility Bill.
                                    $billPayResponse = $this->processTransaction($req->all(), $req->bearerToken());

                                    if ($billPayResponse->responseCode == 00 || $billPayResponse->responseCode == 0) {


                                        if (isset($billPayResponse->status) && $billPayResponse->status == 400) {

                                            $data = [];
                                            $message = $billPayResponse->responseMessage;
                                            $status = 400;

                                            // Log::info('Oops!, '.$thisuser->name.' has '.$message);

                                            $this->slack('Oops!, ' . $thisuser->name . ' has ' . $message, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));
                                        } else {

                                            if (isset($billPayResponse)) {

                                                $transaction_id = $billPayResponse->transRef;


                                                $walletBal = $thisuser->wallet_balance - $req->amounttosend;

                                                User::where('api_token', $req->bearerToken())->update([
                                                    'wallet_balance' => $walletBal
                                                ]);

                                                // Update Statement

                                                $userData = User::select('id', 'ref_code as refCode', 'name', 'email', 'telephone', 'wallet_balance as walletBalance', 'number_of_withdrawals as noOfWithdrawals')->where('api_token', $req->bearerToken())->first();

                                                $activity = $billPayResponse->responseMessage . " | Withdraw " . $thisuser->currencyCode . '' . number_format($req->amounttosend, 2) . " from Wallet for " . strtoupper($billerName);
                                                $credit = 0;
                                                $debit = $req->amounttosend;
                                                // $reference_code = $response->responseData['ReceiptId'];
                                                $reference_code = $transaction_id;
                                                $balance = 0;
                                                $trans_date = date('Y-m-d');
                                                $status = "Delivered";
                                                $action = "Wallet debit";
                                                $regards = $thisuser->ref_code;
                                                $statement_route = "wallet";

                                                // Senders statement
                                                $this->insStatement($thisuser->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, $thisuser->country, 0);

                                                $this->getfeeTransaction($reference_code, $thisuser->ref_code, $req->amount, $req->commissiondeduct, $req->amounttosend);


                                                $this->name = $thisuser->name;
                                                $this->email = $thisuser->email;
                                                $this->subject = $req->currencyCode . ' ' . number_format($req->amounttosend, 2) . " has been Withdrawn from your Wallet with PaySprint";

                                                $this->message = '<p>' . $billPayResponse->responseMessage . '</p><br><p>Recharge of ' . strtoupper($billerName) . ' for a sum of ' . $thisuser->currencyCode . ' ' . number_format($req->amounttosend, 2) . ' from your PaySprint wallet is successful. </p><p>You have <strong>' . $thisuser->currencyCode . ' ' . number_format($walletBal, 2) . '</strong> balance in your wallet.</p>';

                                                $sendMsg = $billPayResponse->responseMessage . ' .Recharge of ' . strtoupper($billerName) . ' for a sum of ' . $thisuser->currencyCode . ' ' . number_format($req->amounttosend, 2) . ' from your PaySprint wallet is successful. You have ' . $thisuser->currencyCode . ' ' . number_format($walletBal, 2) . ' balance in your wallet.';

                                                $userPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

                                                if (isset($userPhone)) {

                                                    $sendPhone = $thisuser->telephone;
                                                } else {
                                                    $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
                                                }


                                                $this->createNotification($thisuser->ref_code, $sendMsg, $thisuser->playerId, $sendMsg, "Wallet Transaction");

                                                if ($thisuser->country == "Nigeria") {

                                                    $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                                                    $this->sendSms($sendMsg, $correctPhone);
                                                } else {
                                                    $this->sendMessage($sendMsg, $sendPhone);
                                                }

                                                $this->sendEmail($this->email, "Fund remittance");


                                                $userInfo = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol', 'bvn_account_number', 'bvn_bank', 'bvn_account_name', 'bvn_verification')->where('api_token', $req->bearerToken())->first();

                                                $data = $userInfo;
                                                $status = 200;
                                                $message = $sendMsg;

                                                // Log::info("Congratulations! ".strtoupper($thisuser->name)." ".$message);

                                                $this->slack("Congratulations! " . strtoupper($thisuser->name) . " " . $message, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));
                                            } else {

                                                $data = [];
                                                $message = "Something went wrong!. Please try again later.";
                                                $status = 400;

                                                // Log::critical("Check EPS end for this error!.");

                                                $this->slack("Check EPS end for this error!.", $room = "error-logs", $icon = ":longbox:", env('LOG_SLACK_WEBHOOK_URL'));
                                            }
                                        }
                                    } else {
                                        $data = [];
                                        $message = $billPayResponse->responseMessage;
                                        $status = 400;

                                        // Log::info('Oops!, '.$message);

                                        $this->slack('Oops!, ' . $message, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));
                                    }
                                }
                            } else {
                                $data = [];
                                $message = "Invalid login password";
                                $status = 400;
                            }
                        }
                    }
                } else {

                    $error = implode(",", $validator->messages()->all());

                    $data = [];
                    $status = 400;
                    $message = $error;
                }
            }
        }



        $resData = ['data' => $data, 'message' => $message, 'status' => $status];


        return $this->returnJSON($resData, $status);
    }


    public function creditCardWithdrawalRequest($ref_code, $transaction_id, $customer_id, $card_number, $month, $year, $amount, $country)
    {

        $query = ['ref_code' => $ref_code, 'transaction_id' => $transaction_id, 'customer_id' => $customer_id, 'card_number' => $card_number, 'month' => $month, 'year' => $year, 'amount' => $amount, 'status' => 'PENDING', 'country' => $country];

        CcWithdrawal::insert($query);
    }


    public function debitWalletForCard($ref_code, $amount, $purpose, $transaction_id, $mode)
    {

        if ($mode == "test") {

            $myWallet = User::where('ref_code', $ref_code)->first();

            // Deduct $20 for EXBC Card
            $wallet_balance = $myWallet->wallet_balance - $amount;

            // Update walllet balance
            User::where('ref_code', $ref_code)->update(['wallet_balance' => $wallet_balance]);


            $data = User::where('ref_code', $ref_code)->first();

            $status = 200;

            $resData = ['data' => $data, 'message' => 'success', 'status' => $status];

            // Send SMS
            $sendMsg = "Hi " . $data->name . ", " . $data->currencyCode . " " . number_format($amount, 2) . " was deducted from your PaySprint wallet for " . $purpose . " load request. Your new wallet balance is " . $data->currencyCode . ' ' . number_format($wallet_balance, 2) . ". If you did not make this transfer, kindly login to your PaySprint Account to change your Transaction PIN and report the issue to PaySprint Admin using Contact Us.";

            $userPhone = User::where('email', $data->email)->where('telephone', 'LIKE', '%+%')->first();

            if (isset($userPhone)) {

                $sendPhone = $data->telephone;
            } else {
                $sendPhone = "+" . $data->code . $data->telephone;
            }

            if ($data->country == "Nigeria") {

                $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                $this->sendSms($sendMsg, $correctPhone);
            } else {
                $this->sendMessage($sendMsg, $sendPhone);
            }

            // $this->createNotification($ref_code, $sendMsg);

            // Wallet Statement

            // Insert Statement
            $activity = "Debited " . $data->currencyCode . " " . number_format($amount, 2) . " for " . $purpose . " load request from PaySprint Wallet.";
            $credit = 0;
            $debit = $amount;
            $reference_code = $transaction_id;
            $balance = 0;
            $trans_date = date('Y-m-d');
            $status = "Delivered";
            $action = "Wallet debit";
            $regards = $ref_code;

            $statement_route = "wallet";

            // Senders statement
            // $this->insStatement($data->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, $data->country, 0);

        } else {

            $myWallet = User::where('ref_code', $ref_code)->first();

            // Deduct $20 for EXBC Card
            $wallet_balance = $myWallet->wallet_balance - $amount;

            // Update walllet balance
            User::where('ref_code', $ref_code)->update(['wallet_balance' => $wallet_balance]);


            $data = User::where('ref_code', $ref_code)->first();

            $status = 200;

            $resData = ['data' => $data, 'message' => 'success', 'status' => $status];

            // Send SMS
            $sendMsg = "Hi " . $data->name . ", " . $data->currencyCode . " " . number_format($amount, 2) . " was deducted from your PaySprint wallet for " . $purpose . " load request. Your new wallet balance is " . $data->currencyCode . ' ' . number_format($wallet_balance, 2) . ". If you did not make this transfer, kindly login to your PaySprint Account to change your Transaction PIN and report the issue to PaySprint Admin using Contact Us.";

            $userPhone = User::where('email', $data->email)->where('telephone', 'LIKE', '%+%')->first();

            if (isset($userPhone)) {

                $sendPhone = $data->telephone;
            } else {
                $sendPhone = "+" . $data->code . $data->telephone;
            }

            if ($data->country == "Nigeria") {

                $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                $this->sendSms($sendMsg, $correctPhone);
            } else {
                $this->sendMessage($sendMsg, $sendPhone);
            }

            $this->createNotification($ref_code, $sendMsg, $myWallet->playerId, $sendMsg, "Wallet Transaction");

            // Wallet Statement

            // Insert Statement
            $activity = "Debited " . $data->currencyCode . " " . number_format($amount, 2) . " for " . $purpose . " load request from PaySprint Wallet.";
            $credit = 0;
            $debit = $amount;
            $reference_code = $transaction_id;
            $balance = 0;
            $trans_date = date('Y-m-d');
            $status = "Delivered";
            $action = "Wallet debit";
            $regards = $ref_code;

            $statement_route = "wallet";

            // Senders statement
            // $this->insStatement($data->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, $data->country, 0);

        }


        return $resData;
    }





    public function monerisWalletProcess($bearer, $card_id, $dollaramount, $type, $description, $mode)
    {

        $thisuser = User::where('api_token', $bearer)->first();

        // Get Card Details
        $cardDetails = AddCard::where('id', $card_id)->where('user_id', $thisuser->id)->first();

        if (env('APP_ENV') == 'local') {
            $mode = "test";
        } else {
            $mode = "live";
        }






        if ($mode == "test") {
            if ($type == "purchase") {
                // Test API
                $store_id = 'monca04155';
                $api_token = 'KvTMr066FKlJm9rD3i71';
            } else {
                // Test API
                $store_id = 'store5';
                $api_token = 'yesguy';
            }

            $setMode = true;
            $indicator = "Z";
        } else {

            if ($thisuser->country == "Nigeria") {
                // Live API
                $store_id = env('MONERIS_STORE_ID_VIM');
                $api_token = env('MONERIS_API_TOKEN_VIM');

                $indicator = "U";
                $setMode = false;
            } else {
                if ($cardDetails->card_provider == "Credit Card") {
                    // Live API
                    $store_id = env('MONERIS_STORE_ID_VIM');
                    $api_token = env('MONERIS_API_TOKEN_VIM');

                    $indicator = "U";
                    $setMode = false;
                } else {
                    // Live API
                    $store_id = env('MONERIS_STORE_ID');
                    $api_token = env('MONERIS_API_TOKEN');

                    $setMode = false;
                    $indicator = "Z";
                }
            }
        }









        $type = $type;
        $cust_id = $thisuser->ref_code;
        $order_id = 'ord-' . date("dmy-Gis");
        // $amount= number_format($dollaramount, 2);
        $amount = $dollaramount;

        if ($thisuser->country == "Canada") {
            $amount = sprintf("%.2f", $dollaramount);
        } else {
            $amount = $dollaramount;
        }



        $month = $cardDetails->month;

        $pan = $cardDetails->card_number;
        $expiry_date = $cardDetails->year . $month;
        $crypt = '7';
        $dynamic_descriptor = $description;
        $status_check = 'false';

        /*********************** Transactional Associative Array **********************/
        $txnArray = array(
            'type' => $type,
            'order_id' => $order_id,
            'cust_id' => $cust_id,
            'amount' => $amount,
            'pan' => $pan,
            'expdate' => $expiry_date,
            'crypt_type' => $crypt,
            'dynamic_descriptor' => $dynamic_descriptor
        );


        $this->slack(json_encode($txnArray), $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));

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
        $mpgHttpPost = new mpgHttpsPost($store_id, $api_token, $mpgRequest);
        /******************************* Response ************************************/
        $mpgResponse = $mpgHttpPost->getMpgResponse();


        $this->slack("Name: " . $thisuser->name . " | Mode: " . $mode, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));



        return $mpgResponse;
    }

    public function monerisBusinessWalletProcess($ref_code, $cardNumber, $cardMonth, $cardYear, $dollaramount, $type, $description)
    {

        $thisuser = User::where('ref_code', $ref_code)->first();

        // Get Card Details

        if (env('APP_ENV') == 'local') {
            $mode = "test";
        } else {
            $mode = "live";
        }



        if ($mode == "test") {
            if ($type == "purchase") {
                // Test API
                $store_id = 'monca04155';
                $api_token = 'KvTMr066FKlJm9rD3i71';
            } else {
                // Test API
                $store_id = 'store5';
                $api_token = 'yesguy';
            }

            $setMode = true;
            $indicator = "Z";
        } else {

            if ($thisuser->country == "Nigeria") {
                // Live API
                $store_id = env('MONERIS_STORE_ID_VIM');
                $api_token = env('MONERIS_API_TOKEN_VIM');

                $indicator = "U";
                $setMode = false;
            } else {
                // Live API
                $store_id = env('MONERIS_STORE_ID');
                $api_token = env('MONERIS_API_TOKEN');

                $setMode = false;
                $indicator = "Z";
            }
        }







        $type = $type;
        $cust_id = $thisuser->ref_code;
        $order_id = 'ord-' . date("dmy-Gis");
        // $amount= number_format($dollaramount, 2);
        $amount = $dollaramount;

        if ($thisuser->country == "Canada") {
            $amount = sprintf("%.2f", $dollaramount);
        } else {
            $amount = $dollaramount;
        }



        $month = $cardMonth;

        $pan = $cardNumber;
        $expiry_date = $cardYear . $month;
        $crypt = '7';
        $dynamic_descriptor = $description;
        $status_check = 'false';

        /*********************** Transactional Associative Array **********************/
        $txnArray = array(
            'type' => $type,
            'order_id' => $order_id,
            'cust_id' => $cust_id,
            'amount' => $amount,
            'pan' => $pan,
            'expdate' => $expiry_date,
            'crypt_type' => $crypt,
            'dynamic_descriptor' => $dynamic_descriptor
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
        $mpgHttpPost = new mpgHttpsPost($store_id, $api_token, $mpgRequest);
        /******************************* Response ************************************/
        $mpgResponse = $mpgHttpPost->getMpgResponse();




        return $mpgResponse;
    }


    public function paywithmonerisWalletProcessLink($merchantId, $creditcard_no, $month, $year, $amount, $type, $description)
    {

        $thisuser = User::where('ref_code', $merchantId)->first();


        // Get Card Details

        if (env('APP_ENV') == 'local') {
            $mode = "test";
        } else {
            $mode = "live";
        }



        if ($mode == "test") {
            if ($type == "purchase") {
                // Test API
                $store_id = 'monca04155';
                $api_token = 'KvTMr066FKlJm9rD3i71';
            } else {
                // Test API
                $store_id = 'store5';
                $api_token = 'yesguy';
            }

            $setMode = true;
            $indicator = "Z";
        } else {

            if ($thisuser->country == "Nigeria") {
                // Live API
                $store_id = env('MONERIS_STORE_ID_VIM');
                $api_token = env('MONERIS_API_TOKEN_VIM');

                $indicator = "U";
                $setMode = false;
            } else {

                // Live API
                $store_id = env('MONERIS_STORE_ID');
                $api_token = env('MONERIS_API_TOKEN');

                $setMode = false;
                $indicator = "Z";
            }
        }







        $type = $type;
        $cust_id = $thisuser->ref_code;
        $order_id = 'ord-' . date("dmy-Gis");
        // $amount= number_format($dollaramount, 2);
        $amount = $amount;

        if ($thisuser->country == "Canada") {
            $amount = number_format($amount, 2);
        } else {
            $amount = $amount;
        }



        $month = $month;

        $pan = $creditcard_no;
        $expiry_date = $year . $month;
        $crypt = '7';
        $dynamic_descriptor = $description;
        $status_check = 'false';

        /*********************** Transactional Associative Array **********************/
        $txnArray = array(
            'type' => $type,
            'order_id' => $order_id,
            'cust_id' => $cust_id,
            'amount' => $amount,
            'pan' => $pan,
            'expdate' => $expiry_date,
            'crypt_type' => $crypt,
            'dynamic_descriptor' => $dynamic_descriptor
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
        $mpgHttpPost = new mpgHttpsPost($store_id, $api_token, $mpgRequest);
        /******************************* Response ************************************/
        $mpgResponse = $mpgHttpPost->getMpgResponse();




        return $mpgResponse;
    }



    public function orgPaymentInvoice(Request $req)
    {

        /**************************** Request Variables *******************************/

        /************************* Transactional Variables ****************************/

        // Test API
        // $store_id='monca04155';
        // $api_token='KvTMr066FKlJm9rD3i71';

        // Live API
        $store_id = env('MONERIS_STORE_ID');
        $api_token = env('MONERIS_API_TOKEN');

        // $type='purchase';
        // $cust_id='cust id';
        // $order_id='ord-'.date("dmy-Gis");
        // $amount='1.00';
        // $pan='4242424242424242';
        // $expiry_date='2011';
        // $crypt='7';
        // $dynamic_descriptor='123';
        // $status_check = 'false';

        $type = 'purchase';
        $cust_id = $req->user_id;
        $order_id = 'ord-' . date("dmy-Gis");


        if ($req->commission == "on") {
            $amount = number_format($req->amount, 2);
            $approve_commission = "Yes";
        } else {

            $amount = number_format($req->amount + $req->commissiondeduct, 2);
            $approve_commission = "No";
        }




        $month = $req->month;

        $pan = $req->creditcard_no;
        $expiry_date = $req->expirydate . $month;
        $crypt = '7';
        $dynamic_descriptor = 'PaySprint Send Money';
        $status_check = 'false';


        /*********************** Transactional Associative Array **********************/
        $txnArray = array(
            'type' => $type,
            'order_id' => $order_id,
            'cust_id' => $cust_id,
            'amount' => $amount,
            'pan' => $pan,
            'expdate' => $expiry_date,
            'crypt_type' => $crypt,
            'dynamic_descriptor' => $dynamic_descriptor
            //,'wallet_indicator' => '' //Refer to documentation for details
            //,'cm_id' => '8nAK8712sGaAkls56' //set only for usage with Offlinx - Unique max 50 alphanumeric characters transaction id generated by merchant
        );

        // dd($txnArray);
        /**************************** Transaction Object *****************************/
        $mpgTxn = new mpgTransaction($txnArray);


        /******************* Credential on File **********************************/
        $cof = new CofInfo();
        $cof->setPaymentIndicator("Z");
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
        $mpgHttpPost = new mpgHttpsPost($store_id, $api_token, $mpgRequest);
        /******************************* Response ************************************/
        $mpgResponse = $mpgHttpPost->getMpgResponse();

        // dd($mpgResponse);



        if ($mpgResponse->responseData['ResponseCode'] == "000" || $mpgResponse->responseData['ResponseCode'] == "001" || $mpgResponse->responseData['ResponseCode'] == "002" || $mpgResponse->responseData['ResponseCode'] == "003" || $mpgResponse->responseData['ResponseCode'] == "004" || $mpgResponse->responseData['ResponseCode'] == "005" || $mpgResponse->responseData['ResponseCode'] == "006" || $mpgResponse->responseData['ResponseCode'] == "007" || $mpgResponse->responseData['ResponseCode'] == "008" || $mpgResponse->responseData['ResponseCode'] == "009" || $mpgResponse->responseData['ResponseCode'] == "010" || $mpgResponse->responseData['ResponseCode'] == "023" || $mpgResponse->responseData['ResponseCode'] == "024" || $mpgResponse->responseData['ResponseCode'] == "025" || $mpgResponse->responseData['ResponseCode'] == "026" || $mpgResponse->responseData['ResponseCode'] == "027" || $mpgResponse->responseData['ResponseCode'] == "028" || $mpgResponse->responseData['ResponseCode'] == "029") {


            // Get User Info
            $user = User::where('email', $req->orgpayemail)->first();




            if (isset($user)) {

                // $client = ClientInfo::where('user_id', $req->user_id)->get();

                $client = User::where('ref_code', $req->user_id)->first();


                // Getting the payer
                $userID = $user->email;
                $payerID = $user->ref_code;

                // $req->user_id is for the receiver::

                // Do Insert
                if ($req->service != "Others") {
                    $service = $req->service;
                } else {
                    $service = $req->purpose;
                }

                if ($req->payment_method == "Wallet") {
                    $wallet_balance = Auth::user()->wallet_balance - $req->amount;
                } else {
                    $wallet_balance = Auth::user()->wallet_balance;
                }


                $insertPay = OrganizationPay::insert(['transactionid' => $mpgResponse->responseData['ReceiptId'], 'coy_id' => $req->user_id, 'user_id' => $userID, 'purpose' => $service, 'amount' => $req->amount, 'withdraws' => $req->amount, 'state' => 1, 'payer_id' => $payerID, 'amount_to_send' => $req->amounttosend, 'commission' => $req->commissiondeduct, 'approve_commission' => $approve_commission, 'amountindollars' => $req->conversionamount]);

                if ($insertPay == true) {

                    // Update Wallet
                    User::where('email', Auth::user()->email)->update(['wallet_balance' => $wallet_balance]);

                    // Send mail to both parties

                    // $this->to = "bambo@vimfile.com";
                    $this->to = $client->email;
                    $this->name = $user->name;
                    $this->coy_name = $client->name;
                    // $this->email = "bambo@vimfile.com";
                    $this->email = $user->email;
                    $this->amount = $req->amounttosend;
                    $this->paypurpose = $service;
                    $this->subject = "Payment Received from " . $user->name . " for " . $service;
                    $this->subject2 = "Your Payment to " . $client->name . " was successfull";

                    // Mail to receiver
                    $this->sendEmail($this->to, "Payment Received");

                    // Mail from Sender

                    $this->sendEmail($this->email, "Payment Successful");


                    // Insert Statement
                    $activity = "Payment to " . $client->name . " on " . $service;
                    $credit = 0;
                    $debit = $req->amount + $req->commissiondeduct;
                    $reference_code = $mpgResponse->responseData['ReceiptId'];
                    $balance = 0;
                    $trans_date = date('Y-m-d');
                    $status = "Pending";
                    $action = "Payment";
                    $regards = $req->user_id;
                    $statement_route = "invoice";

                    // Senders statement
                    $this->insStatement($userID, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, $user->country, 0);

                    // Receiver Statement
                    $this->insStatement($client->email, $reference_code, "Received money for " . $service . " from " . $user->name, $req->amount, 0, $balance, $trans_date, $status, "Invoice", $client->ref_code, 1, $statement_route, $client->country, 0);



                    $resData = ['res' => 'Payment Sent Successfully', 'message' => 'success', 'title' => 'Good!'];

                    $response = 'Payment Sent Successfully';
                    $action = 'success';

                    return redirect()->route('payorganization')->with($action, $response);
                } else {
                    $resData = ['res' => 'Something went wrong', 'message' => 'info', 'title' => 'Oops!'];

                    $response = 'Something went wrong';
                    $action = 'error';

                    return redirect()->back()->with($action, $response);
                }
            } else {
                $resData = ['res' => 'Cannot Process Payment', 'message' => 'error', 'title' => 'Oops!'];

                $response = 'Cannot Process Payment';
                $action = 'error';

                return redirect()->back()->with($action, $response);
            }
        } else {
            $resData = ['res' => $mpgResponse->responseData['Message'], 'message' => 'error', 'title' => 'Oops!'];

            $response = $mpgResponse->responseData['Message'];
            $action = 'error';

            return redirect()->back()->with($action, $response);
        }

        // return $this->returnJSON($resData, 200);


    }


    public function receivemoneyProcess(Request $req)
    {


        // Explode Currency

        // Insert Record
        $data = ReceivePay::updateOrInsert(['pay_id' => $req->pay_id], ['_token' => $req->_token, 'pay_id' => $req->pay_id, 'sender_id' => $req->sender_id, 'receiver_id' => $req->receiver_id, 'payment_method' => $req->payment_method, 'account_number' => $req->account_number, 'accountname' => $req->accountname, 'amount_to_receive' => $req->amount_to_receive, 'bank_name' => $req->bank_name, 'creditcard_no' => $req->creditcard_no, 'currency' => $req->currency, 'purpose' => $req->purpose]);

        // Update WALLET
        $wallet = Auth::user()->wallet + $req->amount_to_receive;

        User::where('email', Auth::user()->email)->update(['wallet_balance' => $wallet]);

        // Update OrganozationPay

        OrganizationPay::where('id', $req->pay_id)->update(['request_receive' => 2]);

        $response = 'Money successfully transferred to your ' . $req->payment_method;
        $action = 'success';

        return redirect()->route('payorganization')->with($action, $response);
    }




    public function fortisPay($amount, $card_id, $zipcode, $name, $email, $phone, $city, $state, $mode)
    {

        // Get Card Details
        $cardDetails = AddCard::where('id', $card_id)->first();
        $exp = $cardDetails->month . $cardDetails->year;

        if (env('APP_ENV') == "local") {
            $url = env('FORTIS_SANDBOX_URL');
            $developer_id = env('FORTIS_SANDBOX_DEVELOPER_ID');
        } else {

            if ($mode == "test") {
                $url = env('FORTIS_SANDBOX_URL');
                $developer_id = env('FORTIS_SANDBOX_DEVELOPER_ID');
            } else {
                $url = env('FORTIS_URL');
                $developer_id = env('FORTIS_DEVELOPER_ID');
            }
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url . '/v2/transactions',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
            "transaction": {
                "action":"sale",
                "payment_method": "cc",
                "transaction_type": "sale",
                "location_id": "' . env('FORTIS_LOCATION_ID') . '",
                "transaction_amount":"' . $amount . '",
                "account_number":"' . $cardDetails->card_number . '",
                "exp_date":"' . $exp . '",
                "billing_zip":"' . $zipcode . '",
                "account_holder_name":"' . $name . '",
                "notification_email_address":"' . $email . '",
                "billing_phone":"",
                "billing_city":"' . $city . '",
                "billing_state":"' . $state . '"
            }
            }',
            CURLOPT_HTTPHEADER => array(
                'user-id: ' . env('FORTIS_USER_ID'),
                'user-api-key: ' . env('FORTIS_USER_API_KEY'),
                'Content-Type: application/json',
                'developer-id: ' . $developer_id,
                'Cookie: visid_incap_1743271=ueu8h8bMRVWaQQpdH9ydPgEUumAAAAAAQUIPAAAAAAAR+IO6+jXIAA4xxz4b3Y7k'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return json_decode($response);
    }


    public function paymentIntent(Request $req)
    {


        if (env('APP_ENV') == "local") {
            Stripe::setApiKey(env('STRIPE_LOCAL_SECRET_KEY'));
        } else {
            Stripe::setApiKey(env('STRIPE_LIVE_SECRET_KEY'));
        }

        // This is your real test secret API key.

        header('Content-Type: application/json');

        try {

            $paymentIntent = PaymentIntent::create([
                'amount' => $req->amount * 100,
                'currency' => $req->currencyCode,
                'receipt_email' => $req->email,
                'description' => "Add " . $req->currencyCode . " " . number_format($req->amounttosend, 2) . " to PaySprint wallet, Charge fee of: " . $req->currencyCode . " " . number_format($req->commissiondeduct, 2) . " inclusive",
            ]);


            $output = [
                'clientSecret' => $paymentIntent->client_secret,
                'transactionId' => $paymentIntent->id,
            ];

            $data = $output;
            $message = 'success';
            $status = 200;
        } catch (Throwable $e) {

            $data = [];
            $message = json_encode(['error' => $e->getMessage()]);
            $status = 500;
        }


        $resData = ['res' => $data, 'message' => $message, 'status' => $status];


        return $this->returnJSON($resData, $status);
    }


    public function invoicepaymentIntent(Request $req)
    {


        if (env('APP_ENV') == "local") {
            Stripe::setApiKey(env('STRIPE_LOCAL_SECRET_KEY'));
        } else {
            Stripe::setApiKey(env('STRIPE_LIVE_SECRET_KEY'));
        }

        // This is your real test secret API key.

        header('Content-Type: application/json');

        try {

            $paymentIntent = PaymentIntent::create([
                'amount' => $req->amount * 100,
                'currency' => $req->currencyCode,
                'receipt_email' => $req->email,
                'description' => "Paid invoice of " . $req->currencyCode . " " . number_format($req->amount, 2) . " to PaySprint wallet",
            ]);


            $output = [
                'clientSecret' => $paymentIntent->client_secret,
                'transactionId' => $paymentIntent->id,
            ];

            $data = $output;
            $message = 'success';
            $status = 200;
        } catch (Throwable $e) {

            $data = [];
            $message = json_encode(['error' => $e->getMessage()]);
            $status = 400;
        }


        $resData = ['res' => $data, 'message' => $message, 'status' => $status];


        return $this->returnJSON($resData, $status);
    }


    public function expressCallback(Request $req)
    {

        try {
            // Verify Payment ...
            $getVerification = $this->getVerification($req->paymentToken);

            // dd($getVerification);

            if ($getVerification->responseCode == "00") {
                // Insert Payment Record

                if ($req->commission == "on") {
                    $grossAmount = $req->amount;
                } else {
                    $grossAmount = $req->amount + $req->commissiondeduct;
                }


                $thisuser = User::where('api_token', $req->api_token)->first();

                // Log::info($thisuser->name." wants to add ".$req->currencyCode." ".$req->amount." to their wallet.");


                $this->slack($thisuser->name . " wants to add " . $req->currencyCode . " " . $req->amount . " to their wallet.", $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));


                $getGateway = AllCountries::where('name', $thisuser->country)->first();

                if ($getGateway->gateway == "PayStack" || $getGateway->gateway == "Express Payment Solution") {
                    $gateway = "Express Payment Solution";
                } else {
                    $gateway = ucfirst($getGateway->gateway);
                }


                $referenced_code = $req->paymentToken;


                if ($thisuser->auto_credit == 1) {
                    // Update Wallet Balance
                    $walletBal = $thisuser->wallet_balance + $req->amounttosend;
                    $holdBal = $thisuser->hold_balance;
                } else {
                    // Update Wallet Balance
                    $walletBal = $thisuser->wallet_balance;
                    $holdBal = $thisuser->hold_balance + $req->amounttosend;
                }


                User::where('api_token', $req->api_token)->update(['wallet_balance' => $walletBal, 'hold_balance' => $holdBal]);

                $userData = User::select('id', 'ref_code as refCode', 'name', 'email', 'telephone', 'wallet_balance as walletBalance', 'number_of_withdrawals as noOfWithdrawals')->where('api_token', $req->api_token)->first();

                $activity = "Added " . $req->currencyCode . '' . number_format($req->amounttosend, 2) . " to Wallet including a fee charge of " . $req->currencyCode . '' . number_format($req->commissiondeduct, 2) . " was deducted";
                $credit = $req->amounttosend;
                $debit = 0;
                $reference_code = $referenced_code;
                $balance = 0;
                $trans_date = date('Y-m-d');
                $status = "Delivered";
                $action = "Wallet credit";
                $regards = $thisuser->ref_code;
                $statement_route = "wallet";

                // Senders statement
                $this->insStatement($thisuser->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, $thisuser->country, ($thisuser->auto_credit == 1 ? 0 : 1));

                $this->getfeeTransaction($reference_code, $thisuser->ref_code, $req->amount, $req->commissiondeduct, $req->amounttosend);

                // Notification


                $this->name = $thisuser->name;
                $this->email = $thisuser->email;
                $this->subject = $req->currencyCode . ' ' . number_format($req->amounttosend, 2) . " now added to your wallet with PaySprint";

                if ($thisuser->auto_credit == 1) {

                    $this->message = '<p>You have added <strong>' . $req->currencyCode . ' ' . number_format($req->amounttosend, 2) . '</strong> <em>(Gross Amount of ' . $req->currencyCode . ' ' . number_format($grossAmount, 2) . ' less transaction fee ' . $req->currencyCode . ' ' . number_format($req->commissiondeduct, 2) . ')</em> to your wallet with PaySprint. You have <strong>' . $req->currencyCode . ' ' . number_format($walletBal, 2) . '</strong> balance in your account</p>';

                    $sendMsg = 'You have added ' . $req->currencyCode . ' ' . number_format($req->amounttosend, 2) . ' (Gross Amount of ' . $req->currencyCode . ' ' . number_format($grossAmount, 2) . ' less transaction fee ' . $req->currencyCode . ' ' . number_format($req->commissiondeduct, 2) . ') to your wallet with PaySprint. You have ' . $req->currencyCode . ' ' . number_format($walletBal, 2) . ' balance in your account';
                } else {

                    $this->message = '<p>You have added <strong>' . $req->currencyCode . ' ' . number_format($req->amounttosend, 2) . '</strong> <em>(Gross Amount of ' . $req->currencyCode . ' ' . number_format($grossAmount, 2) . ' less transaction fee ' . $req->currencyCode . ' ' . number_format($req->commissiondeduct, 2) . ')</em> to your wallet with PaySprint. Kindly allow up to 12-24 hours for the funds to reflect in your wallet. You have <strong>' . $req->currencyCode . ' ' . number_format($walletBal, 2) . '</strong> balance in your account</p>';

                    $sendMsg = 'You have added ' . $req->currencyCode . ' ' . number_format($req->amounttosend, 2) . ' (Gross Amount of ' . $req->currencyCode . ' ' . number_format($grossAmount, 2) . ' less transaction fee ' . $req->currencyCode . ' ' . number_format($req->commissiondeduct, 2) . ') to your wallet with PaySprint. Kindly allow up to 12-24 hours for the funds to reflect in your wallet. You have ' . $req->currencyCode . ' ' . number_format($walletBal, 2) . ' balance in your account';
                }



                $userPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

                if (isset($userPhone)) {

                    $sendPhone = $thisuser->telephone;
                } else {
                    $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
                }

                if ($thisuser->country == "Nigeria") {

                    $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                    $this->sendSms($sendMsg, $correctPhone);
                } else {
                    $this->sendMessage($sendMsg, $sendPhone);
                }


                $checkBVN = $this->bvnVerificationCharge($req->api_token);

                if ($checkBVN == "charge") {

                    $getUser = User::where(
                        'api_token',
                        $req->api_token
                    )->first();
                    // Update Wallet Balance
                    $walletBalance = $getUser->wallet_balance - 15;
                    User::where('api_token', $req->api_token)->update(['wallet_balance' => $walletBalance, 'bvn_verification' => 2]);

                    $activity = "Bank Verification (BVN) Charge of " . $req->currencyCode . '' . number_format(15, 2) . " was deducted from your Wallet";
                    $credit = 0;
                    $debit = 15;
                    $reference_number = "wallet-" . date('dmY') . time();
                    $balance = 0;
                    $trans_date = date('Y-m-d');
                    $status = "Delivered";
                    $action = "Wallet debit";
                    $regards = $getUser->ref_code;
                    $statement_route = "wallet";

                    // Senders statement
                    $this->insStatement($thisuser->email, $reference_number, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, $thisuser->country, 0);

                    $this->getfeeTransaction($reference_number, $thisuser->ref_code, 15, 0, 15);

                    $sendMsg = $activity . '. You have ' . $req->currencyCode . ' ' . number_format($walletBalance, 2) . ' balance in your account';

                    $userPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

                    if (isset($userPhone)) {

                        $sendPhone = $thisuser->telephone;
                    } else {
                        $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
                    }

                    if ($thisuser->country == "Nigeria") {

                        $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                        $this->sendSms($sendMsg, $correctPhone);
                    } else {
                        $this->sendMessage($sendMsg, $sendPhone);
                    }
                }

                $userInfo = User::select(
                    'id',
                    'code as countryCode',
                    'ref_code as refCode',
                    'name',
                    'email',
                    'password',
                    'address',
                    'telephone',
                    'city',
                    'state',
                    'country',
                    'zip as zipCode',
                    'avatar',
                    'api_token as apiToken',
                    'approval',
                    'accountType',
                    'wallet_balance as walletBalance',
                    'number_of_withdrawals as numberOfWithdrawal',
                    'transaction_pin as transactionPin',
                    'currencyCode',
                    'currencySymbol'
                )->where('api_token', $req->api_token)->first();

                $data = $userInfo;
                $status = 200;
                $message = 'You have successfully added ' . $req->currencyCode . ' ' . number_format($req->amounttosend, 2) . ' to your wallet. Kindly allow up to 12-24 hours for the funds to reflect in your wallet.';
                $action = 'success';

                $this->createNotification($thisuser->ref_code, $sendMsg, $thisuser->playerId, $sendMsg, "Wallet Transaction");

                $this->keepRecord($referenced_code, $message, "Success", $gateway, $thisuser->country, ($thisuser->auto_credit == 1 ? 0 : 1));

                $this->updatePoints($thisuser->id, 'Add money');

                // Log::info('Congratulations!, '.$thisuser->name.' '.$sendMsg);

                $this->slack(
                    'Congratulations!, ' . $thisuser->name . ' ' . $sendMsg,
                    $room = "success-logs",
                    $icon = ":longbox:",
                    env('LOG_SLACK_SUCCESS_URL')
                );

                $this->sendEmail($this->email, "Fund remittance");

                $adminMessage = "<p>Transaction ID: " . $reference_code . "</p><p>Name: " . $thisuser->name . "</p><p>Account Number: " . $thisuser->ref_code . "</p><p>Country: " . $thisuser->country . "</p><p>Date: " . date('d/m/Y h:i:a') . "</p><p>Amount: " . $req->currencyCode . ' ' . number_format($req->amounttosend, 2) . "</p><p>Status: Successful</p>";

                $this->notifyAdmin($gateway . " inflow", $adminMessage);
            } else {
                $data = [];
                $message = "Payment not received | " . $getVerification->responseMessage;
                $status = 400;
                $action = 'error';
            }
        } catch (\Throwable $th) {
            $data = [];
            $message = "Payment not received | " . $th->getMessage();
            $status = 400;
            $action = 'error';
        }


        $resData = ['res' => $data, 'message' => $message, 'status' => $status];


        return redirect()->route('epsresponseback', 'status=' . $action . '&message=' . $message)->with($action, $message);


        // return $this->returnJSON($resData, $status);
    }

    //dusupay callback
    public function dusuPayCallback(Request $req)
    {

        // dd($req->all());

        try {
            // Verify Payment ...
            //  $getVerification = $this->getVerification($req->paymentToken);

            // dd($getVerification);

            if ($req->status == "COMPLETED") {
                // Insert Payment Record

                if ($req->commission == "on") {
                    $grossAmount = $req->amount;
                } else {
                    $grossAmount = $req->amount + $req->commissiondeduct;
                }


                $thisuser = User::where('api_token', $req->api_token)->first();

                // Log::info($thisuser->name." wants to add ".$req->currencyCode." ".$req->amount." to their wallet.");


                $this->slack($thisuser->name . " wants to add " . $req->currencyCode . " " . $req->amount . " to their wallet.", $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));


                $getGateway = AllCountries::where('name', $thisuser->country)->first();


                $gateway = ucfirst($getGateway->gateway);



                $referenced_code = $req->paymentToken;


                if ($thisuser->auto_credit == 1) {
                    // Update Wallet Balance
                    $walletBal = $thisuser->wallet_balance + $req->amounttosend;
                    $holdBal = $thisuser->hold_balance;
                } else {
                    // Update Wallet Balance
                    $walletBal = $thisuser->wallet_balance;
                    $holdBal = $thisuser->hold_balance + $req->amounttosend;
                }


                User::where('api_token', $req->api_token)->update(['wallet_balance' => $walletBal, 'hold_balance' => $holdBal]);

                $userData = User::select('id', 'ref_code as refCode', 'name', 'email', 'telephone', 'wallet_balance as walletBalance', 'number_of_withdrawals as noOfWithdrawals')->where('api_token', $req->api_token)->first();

                $activity = "Added " . $req->currencyCode . '' . number_format($req->amounttosend, 2) . " to Wallet including a fee charge of " . $req->currencyCode . '' . number_format($req->commissiondeduct, 2) . " was deducted from your Debit Card";
                $credit = $req->amounttosend;
                $debit = 0;
                $reference_code = $referenced_code;
                $balance = 0;
                $trans_date = date('Y-m-d');
                $status = "Delivered";
                $action = "Wallet credit";
                $regards = $thisuser->ref_code;
                $statement_route = "wallet";

                // Senders statement
                $this->insStatement($thisuser->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, $thisuser->country, ($thisuser->auto_credit == 1 ? 0 : 1));

                $this->getfeeTransaction($reference_code, $thisuser->ref_code, $req->amount, $req->commissiondeduct, $req->amounttosend);

                // Notification


                $this->name = $thisuser->name;
                $this->email = $thisuser->email;
                $this->subject = $req->currencyCode . ' ' . number_format($req->amounttosend, 2) . " now added to your wallet with PaySprint";

                if ($thisuser->auto_credit == 1) {
                    $this->message = '<p>You have added <strong>' . $req->currencyCode . ' ' . number_format($req->amounttosend, 2) . '</strong> <em>(Gross Amount of ' . $req->currencyCode . ' ' . number_format($grossAmount, 2) . ' less transaction fee ' . $req->currencyCode . ' ' . number_format($req->commissiondeduct, 2) . ')</em> to your wallet with PaySprint. You have <strong>' . $req->currencyCode . ' ' . number_format($walletBal, 2) . '</strong> balance in your account</p>';

                    $sendMsg = 'You have added ' . $req->currencyCode . ' ' . number_format($req->amounttosend, 2) . ' (Gross Amount of ' . $req->currencyCode . ' ' . number_format($grossAmount, 2) . ' less transaction fee ' . $req->currencyCode . ' ' . number_format($req->commissiondeduct, 2) . ') to your wallet with PaySprint. You have ' . $req->currencyCode . ' ' . number_format($walletBal, 2) . ' balance in your account';
                } else {
                    $this->message = '<p>You have added <strong>' . $req->currencyCode . ' ' . number_format($req->amounttosend, 2) . '</strong> <em>(Gross Amount of ' . $req->currencyCode . ' ' . number_format($grossAmount, 2) . ' less transaction fee ' . $req->currencyCode . ' ' . number_format($req->commissiondeduct, 2) . ')</em> to your wallet with PaySprint. Kindly allow up to 12-24 hours for the funds to reflect in your wallet. You have <strong>' . $req->currencyCode . ' ' . number_format($walletBal, 2) . '</strong> balance in your account</p>';

                    $sendMsg = 'You have added ' . $req->currencyCode . ' ' . number_format($req->amounttosend, 2) . ' (Gross Amount of ' . $req->currencyCode . ' ' . number_format($grossAmount, 2) . ' less transaction fee ' . $req->currencyCode . ' ' . number_format($req->commissiondeduct, 2) . ') to your wallet with PaySprint. Kindly allow up to 12-24 hours for the funds to reflect in your wallet. You have ' . $req->currencyCode . ' ' . number_format($walletBal, 2) . ' balance in your account';
                }



                $userPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

                if (isset($userPhone)) {

                    $sendPhone = $thisuser->telephone;
                } else {
                    $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
                }

                if ($thisuser->country == "Nigeria") {

                    $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                    $this->sendSms($sendMsg, $correctPhone);
                } else {
                    $this->sendMessage($sendMsg, $sendPhone);
                }


                $checkBVN = $this->bvnVerificationCharge($req->api_token);

                if ($checkBVN == "charge") {

                    $getUser = User::where(
                        'api_token',
                        $req->api_token
                    )->first();
                    // Update Wallet Balance
                    $walletBalance = $getUser->wallet_balance - 15;
                    User::where('api_token', $req->api_token)->update(['wallet_balance' => $walletBalance, 'bvn_verification' => 2]);

                    $activity = "Bank Verification (BVN) Charge of " . $req->currencyCode . '' . number_format(15, 2) . " was deducted from your Wallet";
                    $credit = 0;
                    $debit = 15;
                    $reference_number = "wallet-" . date('dmY') . time();
                    $balance = 0;
                    $trans_date = date('Y-m-d');
                    $status = "Delivered";
                    $action = "Wallet debit";
                    $regards = $getUser->ref_code;
                    $statement_route = "wallet";

                    // Senders statement
                    $this->insStatement($thisuser->email, $reference_number, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, $thisuser->country, 0);

                    $this->getfeeTransaction($reference_number, $thisuser->ref_code, 15, 0, 15);

                    $sendMsg = $activity . '. You have ' . $req->currencyCode . ' ' . number_format($walletBalance, 2) . ' balance in your account';

                    $userPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

                    if (isset($userPhone)) {

                        $sendPhone = $thisuser->telephone;
                    } else {
                        $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
                    }

                    if ($thisuser->country == "Nigeria") {

                        $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                        $this->sendSms($sendMsg, $correctPhone);
                    } else {
                        $this->sendMessage($sendMsg, $sendPhone);
                    }
                }

                $userInfo = User::select(
                    'id',
                    'code as countryCode',
                    'ref_code as refCode',
                    'name',
                    'email',
                    'password',
                    'address',
                    'telephone',
                    'city',
                    'state',
                    'country',
                    'zip as zipCode',
                    'avatar',
                    'api_token as apiToken',
                    'approval',
                    'accountType',
                    'wallet_balance as walletBalance',
                    'number_of_withdrawals as numberOfWithdrawal',
                    'transaction_pin as transactionPin',
                    'currencyCode',
                    'currencySymbol'
                )->where('api_token', $req->api_token)->first();

                $data = $userInfo;
                $status = 200;
                $message = 'You have successfully added ' . $req->currencyCode . ' ' . number_format($req->amounttosend, 2) . ' to your wallet. Kindly allow up to 12-24 hours for the funds to reflect in your wallet.';
                $action = 'success';

                $this->createNotification($thisuser->ref_code, $sendMsg, $thisuser->playerId, $sendMsg, "Wallet Transaction");

                $this->keepRecord($referenced_code, $message, "Success", $gateway, $thisuser->country, ($thisuser->auto_credit == 1 ? 0 : 1));

                $this->updatePoints($thisuser->id, 'Add money');

                // Log::info('Congratulations!, '.$thisuser->name.' '.$sendMsg);

                $this->slack(
                    'Congratulations!, ' . $thisuser->name . ' ' . $sendMsg,
                    $room = "success-logs",
                    $icon = ":longbox:",
                    env('LOG_SLACK_SUCCESS_URL')
                );

                $this->sendEmail($this->email, "Fund remittance");

                $adminMessage = "<p>Transaction ID: " . $reference_code . "</p><p>Name: " . $thisuser->name . "</p><p>Account Number: " . $thisuser->ref_code . "</p><p>Country: " . $thisuser->country . "</p><p>Date: " . date('d/m/Y h:i:a') . "</p><p>Amount: " . $req->currencyCode . ' ' . number_format($req->amounttosend, 2) . "</p><p>Status: Successful</p>";

                $this->notifyAdmin($gateway . " inflow", $adminMessage);
            } else {
                $data = [];
                $message = "Payment not received | " . $req->status;
                $status = 400;
                $action = 'error';
            }
        } catch (\Throwable $th) {
            $data = [];
            $message = "Payment not received | " . $th->getMessage();
            $status = 400;
            $action = 'error';
        }


        $resData = ['res' => $data, 'message' => $message, 'status' => $status];


        return redirect()->route('epsresponseback', 'status=' . $action . '&message=' . $message)->with($action, $message);
    }

    public function estoreExpressCallback(Request $req)
    {

        try {
            // Verify Payment ...
            $getVerification = $this->getVerification($req->paymentToken);

            // dd($getVerification);

            if ($getVerification->responseCode == "00") {
                // Insert Payment Record

                if ($req->commission == "on") {
                    $grossAmount = $req->amount;
                } else {
                    $grossAmount = $req->amount + $req->commissiondeduct;
                }


                $thismerchant = ClientInfo::where('api_secrete_key', $req->api_token)->first();

                $thisuser = User::where('ref_code', $thismerchant->user_id)->first();


                // Get Guest Information....
                $activeuser = User::where('ref_code', $req->ref_code)->first();



                $this->slack($req->productDescription, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));


                $getGateway = AllCountries::where('name', $thisuser->country)->first();

                if ($getGateway->gateway == "PayStack" || $getGateway->gateway == "Express Payment Solution") {
                    $gateway = "Express Payment Solution";
                } else {
                    $gateway = ucfirst($getGateway->gateway);
                }


                $referenced_code = $req->paymentToken;



                // Update Wallet Balance
                $walletBal = $thisuser->wallet_balance;




                $activity = "Transfer of " . $req->currencyCode . " " . number_format($req->amount, 2) . " to " . $thisuser->businessname . " for " . $req->purpose . " on PaySprint Wallet from " . $req->name;

                $credit = $req->amount;
                $debit = 0;
                $reference_code = $referenced_code;
                $balance = 0;
                $trans_date = date('Y-m-d');
                $status = "Delivered";
                $action = "Wallet credit";
                $regards = $thisuser->ref_code;
                $statement_route = "wallet";

                // Send Money to Escrow account and delete items in cart, also update the payment status of order
                $escrowBalance = $thisuser->escrow_balance + $req->amount;
                $disputeBalance = $thisuser->dispute_balance;

                User::where('ref_code', $thisuser->ref_code)->update(['escrow_balance' => $escrowBalance, 'dispute_balance' => $disputeBalance]);

                $this->insStatement($thisuser->email, $reference_code, $activity, $credit, 0, $balance, $trans_date, $status, "Wallet credit", $thisuser->ref_code, 1, $statement_route, $thisuser->auto_deposit, $thisuser->country);



                $sendMsg = "Hi " . $req->name . ", You have successfully transferred " . $req->currencyCode . " " . number_format($req->amount, 2) . " to " . $thisuser->businessname . " for " . $req->purpose . " and a transaction fee of " . $req->currencyCode . " " . number_format($req->commissiondeduct, 2) . " inclusively charged from your card. Open a PaySprint account today to pay at a lesser rate.";

                $sendPhone = $req->phone;

                if ($req->country == "Nigeria") {

                    $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                    $this->sendSms($sendMsg, $correctPhone);
                } else {
                    $this->sendMessage($sendMsg, $sendPhone);
                }


                $recWallet = $thisuser->escrow_balance + $req->amount;

                $recMsg = "Hi " . $thisuser->businessname . ", You have received " . $req->currencyCode . " " . number_format($req->amount, 2) . " in your PaySprint wallet for " . $req->purpose . " from " . $thisuser->name . ". You now have " . $req->currencyCode . ' ' . number_format($recWallet, 2) . " balance in your escrow wallet. PaySprint Team";


                $merchantgetPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

                if (isset($merchantgetPhone)) {

                    $recPhone = $thisuser->telephone;
                } else {
                    $recPhone = "+" . $thisuser->code . $thisuser->telephone;
                }

                if ($thisuser->country == "Nigeria") {

                    $correctPhone = preg_replace("/[^0-9]/", "", $recPhone);
                    $this->sendSms($recMsg, $correctPhone);
                } else {
                    $this->sendMessage($recMsg, $recPhone);
                }


                $myOrderDetails = StoreOrders::where('userId', $activeuser->id)->where('merchantId', $thisuser->id)->where('paymentStatus', 'not paid')->get();

                $orderIds = "";
                $orderItems = "";

                for ($i = 0; $i < count($myOrderDetails); $i++) {

                    // Get Cart Item
                    $cartItemDetails = StoreCart::where('productId', $myOrderDetails[$i]->productId)->first();

                    $orderIds .= $myOrderDetails[$i]->orderId . ", ";



                    $orderItems .= "<tr>

                    <td>" . ($i + 1) . "</td>
                    <td>
                        <img src='" . $cartItemDetails->productImage . "' />
                    </td>
                    <td>
                        " . $cartItemDetails->productName . "
                    </td>
                    <td>
                        " . $cartItemDetails->quantity . "
                    </td>
                    <td>
                        " . $thisuser->currencySymbol . " " . number_format($cartItemDetails->price, 2) . "
                    </td>
                    <td>
                        " . date('d-m-Y', strtotime($cartItemDetails->deliveryDate, 2)) . "
                    </td>

                    </tr>";
                }

                $forbuyer = "<p>You will receive an Out-for-Delivery Email and SMS Notification that contains a One-Time-Passcode (OTP) once your order is out for delivery.</p><p>When you received your order, please click on the link in the notification and use the OTP provided to confirm that you have received the ordered items.</p><p>You earn 100 reward points from PaySprint for delivery confirmation.</p><p>Thanks for your business</p><p>" . $thisuser->businessname . "</p>";


                $forseller = "<p>The Buyer will receive an Out-for-Delivery Email and SMS Notifications that contain a One-Time-Passcode (OTP) when you check mark out for delivery icon of the order.</p><p>Kindly note that the buyer will use the OTP generated  icon to confirm the delivery before funds for the order moves from your eStore Account to your Merchant Wallet.</p><p>eStore Manager</p>";

                $estoresubject = "We have Received Your Order. Your Order Confirmation Number is: [" . $orderIds . "]";

                $estoremessagebuyer = "<p>Thank you for your visit to our eStore on PaySprint. This is to confirm your order:</p><table><thead><tr><td>#</td><td>Image </td><td>Item</td><td>Qty</td><td>Amount</td><td>Expt. Delivery</td></tr></thead><tbody>" . $orderItems . "</tbody></table><hr>" . $forbuyer;


                $estoremessageseller = "<p>You have received an order for processing on PaySprint eStore. The details of the order are:</p><table><thead><tr><td>#</td><td>Image </td><td>Item</td><td>Qty</td><td>Amount</td><td>Expt. Delivery</td></tr></thead><tbody>" . $orderItems . "</tbody></table><hr>" . $forseller;


                // Send Mail to Buyer...
                $this->estoreMail($activeuser->email, $activeuser->name, $estoresubject, $estoremessagebuyer);

                // Send Mail to Seller...
                $this->estoreMail($thisuser->email, $thisuser->name, $estoresubject, $estoremessageseller);

                StoreOrders::where('userId', $activeuser->id)->where('merchantId', $thisuser->id)->where('paymentStatus', 'not paid')->update(['paymentStatus' => 'paid']);

                StoreCart::where('userId', $activeuser->id)->where('merchantId', $thisuser->id)->delete();




                $adminMessage = "<p>Transaction ID: " . $reference_code . "</p><p>Name: " . $thisuser->name . "</p><p>Business Name: " . $thisuser->businessname . "</p><p>Account Number: " . $thisuser->ref_code . "</p><p>Country: " . $thisuser->country . "</p><p>Date: " . date('d/m/Y h:i:a') . "</p><p>Amount: " . $req->currencyCode . ' ' . number_format($req->amount, 2) . "</p><p>PS Commission: " . $req->currencyCode . ' ' . number_format($req->commissiondeduct, 2) . "</p><p>Status: Successful</p>";

                $this->notifyAdmin($gateway . " inflow", $adminMessage);


                $userInfo = User::select(
                    'id',
                    'code as countryCode',
                    'ref_code as refCode',
                    'name',
                    'email',
                    'password',
                    'address',
                    'telephone',
                    'city',
                    'state',
                    'country',
                    'zip as zipCode',
                    'avatar',
                    'api_token as apiToken',
                    'approval',
                    'accountType',
                    'wallet_balance as walletBalance',
                    'number_of_withdrawals as numberOfWithdrawal',
                    'transaction_pin as transactionPin',
                    'currencyCode',
                    'currencySymbol'
                )->where('ref_code', $thismerchant->user_id)->first();

                $data = $userInfo;
                $status = 200;
                $message = 'You have successfully transferred ' . $req->currencyCode . ' ' . number_format($req->amounttosend, 2) . ' to ' . $thisuser->businessname . '.';
                $action = 'success';

                $this->createNotification($thisuser->ref_code, $sendMsg, $thisuser->playerId, $sendMsg, "Wallet Transaction");

                $this->keepRecord($referenced_code, $message, "Success", $gateway, $thisuser->country, 1);

                $this->updatePoints($thisuser->id, 'Estore Add money');
            } else {
                $data = [];
                $message = "Payment not received | " . $getVerification->responseMessage;
                $status = 400;
                $action = 'error';
            }
        } catch (\Throwable $th) {
            $data = [];
            $message = "Payment not received | " . $th->getMessage();
            $status = 400;
            $action = 'error';
        }


        $resData = ['res' => $data, 'message' => $message, 'status' => $status];


        return redirect()->route('epsresponseback', 'status=' . $action . '&message=' . $message)->with($action, $message);


        // return $this->returnJSON($resData, $status);
    }



    public function insStatement($email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, $state, $statement_route, $country, $hold_fee, $reference = null)
    {
        Statement::insert(['user_id' => $email, 'reference_code' => $reference_code, 'activity' => $activity, 'credit' => $credit, 'debit' => $debit, 'balance' => $balance, 'trans_date' => $trans_date, 'status' => $status, 'action' => $action, 'regards' => $regards, 'state' => $state, 'statement_route' => $statement_route, 'country' => $country, 'hold_fee' => $hold_fee, 'etransfer_reference' => $reference]);
    }

    public function insFXStatement($email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, $state, $statement_route, $auto_deposit, $country = null, $confirmation)
    {
        FxStatement::insert(['user_id' => $email, 'reference_code' => $reference_code, 'activity' => $activity, 'credit' => $credit, 'debit' => $debit, 'balance' => $balance, 'trans_date' => $trans_date, 'status' => $status, 'action' => $action, 'regards' => $regards, 'state' => $state, 'statement_route' => $statement_route, 'auto_deposit' => $auto_deposit, 'country' => $country, 'confirmation' => $confirmation]);
    }


    // Platform API
    public function doCurl()
    {
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


    public function sendEmail($objDemoa, $purpose)
    {
        $objDemo = new \stdClass();
        $objDemo->purpose = $purpose;
        if ($purpose == "Payment Received") {

            $objDemo->name = $this->name;
            $objDemo->email = $this->email;
            $objDemo->amount = $this->amount;
            $objDemo->paypurpose = $this->paypurpose;
            $objDemo->coy_name = $this->coy_name;
            $objDemo->subject = $this->subject;
        } elseif ($purpose == "Payment Successful") {

            $objDemo->name = $this->name;
            $objDemo->email = $this->email;
            $objDemo->amount = $this->amount;
            $objDemo->paypurpose = $this->paypurpose;
            $objDemo->coy_name = $this->coy_name;
            $objDemo->subject = $this->subject2;
        } elseif ($purpose == 'Fund remittance') {
            $objDemo->name = $this->name;
            $objDemo->email = $this->email;
            $objDemo->subject = $this->subject;
            $objDemo->message = $this->message;
        }

        Mail::to($objDemoa)
            ->send(new sendEmail($objDemo));
    }
}
