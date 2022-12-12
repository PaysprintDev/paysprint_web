<?php

namespace App\Http\Controllers;

use Session;

use App\AllCountries;


use App\User as User;

use App\Classes\axRef;

use App\Classes\axTxi;

use App\Classes\mcTax;

use App\EscrowAccount;


use App\Mail\sendEmail;

use App\Classes\CofInfo;

use App\Classes\MCPRate;

use App\MoexTransaction;

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
use App\Traits\Xwireless;
use App\Classes\axIt1Loop;
use App\Classes\httpsPost;
use App\AddCard as AddCard;
use App\Classes\mpgAchInfo;
use App\Classes\mpgAvsInfo;
use App\Classes\mpgCvdInfo;
use App\Classes\mpgGlobals;
use App\Classes\mpgRequest;
use App\Classes\MpiRequest;
use App\Classes\mpgCustInfo;
use App\Classes\mpgResponse;
use App\Classes\MpiResponse;
use App\Classes\riskRequest;
use Illuminate\Http\Request;
use App\Classes\mpgAxLevel23;
use App\Classes\mpgHttpsPost;
use App\Classes\mpgMcLevel23;
use App\Classes\mpgVsLevel23;
use App\Classes\MpiHttpsPost;
use App\Classes\riskResponse;
use App\Classes\riskHttpsPost;
use App\Classes\vsTripLegInfo;
use App\Traits\PaymentGateway;
use App\Traits\PaysprintPoint;
use App\AnonUsers as AnonUsers;
use App\Classes\mpgAxRaLevel23;
use App\Classes\mpgConvFeeInfo;
use App\Classes\mpgTransaction;
use App\Classes\MpiTransaction;
use App\Statement as Statement;
use App\Traits\SecurityChecker;
use App\Classes\riskTransaction;
use App\ClientInfo as ClientInfo;
use App\ReceivePay as ReceivePay;
use Illuminate\Support\Facades\DB;
use App\Classes\mpgHttpsPostStatus;
use App\CreateEvent as CreateEvent;
use App\ImportExcel as ImportExcel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Epaywithdraw as Epaywithdraw;

use App\SetupBilling as SetupBilling;
use App\Classes\mpgSessionAccountInfo;
use App\PaycaWithdraw as PaycaWithdraw;
use App\Classes\mpgAttributeAccountInfo;
use App\InvoicePayment as InvoicePayment;
use Illuminate\Support\Facades\Validator;
use App\OrganizationPay as OrganizationPay;

class GooglePaymentController extends Controller
{

    use PaymentGateway, Xwireless, PaysprintPoint, IDVCheck, SecurityChecker;

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




    public function orgPaymentInvoice(Request $req)
    {



        if ($req->amount < 0) {
            $resData = ['res' => 'Please enter a positive amount to send', 'message' => 'error', 'title' => 'Oops!'];

            $response = 'Please enter a positive amount to send';
            $respaction = 'error';

            return redirect()->back()->with($respaction, $response);
        } else {
            // dd($req->all());

            $validator = Validator::make($req->all(), [
                'payment_method' => 'required',
                'service' => 'required',
                'amount' => 'required',
                'transaction_pin' => 'required',
            ]);

            if ($validator->passes()) {

                // Get User Info
                $user = User::where('api_token', $req->api_token)->first();



                if (isset($user)) {

                    // Do IDV

                    $checking = $this->checkUsersPassAccount($user->id);


                    if ($req->type === 'international') {
                        $debitAmount = floatval($req->totalcharge);
                        $creditAmount = floatval($req->amount);
                    } else {
                        $debitAmount = floatval($req->totalcharge);
                        $creditAmount = floatval($req->totalcharge);
                    }


                    if ($user->wallet_balance < $debitAmount) {
                        $resData = ['res' => 'Insufficient wallet balance', 'message' => 'error', 'title' => 'Oops!'];

                        $response = 'Insufficient wallet balance';
                        $respaction = 'error';

                        return redirect()->back()->with($respaction, $response);
                    }



                    if (in_array("send money", $checking['access'])) {
                        // $client = ClientInfo::where('user_id', $req->user_id)->get();

                        $withdrawLimit = $this->getWithdrawalLimit($user->country, $user->id);


                        if ($debitAmount > $withdrawLimit['withdrawal_per_day']) {



                            $message = "Transaction limit per day is " . $user->currencyCode . ' ' . number_format($withdrawLimit['withdrawal_per_day'], 2) . ". Please try a lesser amount";

                            $resData = ['res' => $message, 'message' => 'error', 'title' => 'Oops!'];

                            $response = $message;
                            $respaction = 'error';

                            return redirect()->back()->with($respaction, $response);
                        } elseif ($debitAmount > $withdrawLimit['withdrawal_per_week']) {

                            $message = "You have reached your limit for the week. Transaction limit per week is " . $user->currencyCode . ' ' . number_format($withdrawLimit['withdrawal_per_week'], 2) . ". Please try again the next week";

                            $resData = ['res' => $message, 'message' => 'error', 'title' => 'Oops!'];

                            $response = $message;
                            $respaction = 'error';

                            return redirect()->back()->with($respaction, $response);
                        } elseif ($debitAmount > $withdrawLimit['withdrawal_per_month']) {

                            $message = "You have reached your limit for the week. Transaction limit per month is " . $user->currencyCode . ' ' . number_format($withdrawLimit['withdrawal_per_week'], 2) . ". Please try again the next month";

                            $resData = ['res' => $message, 'message' => 'error', 'title' => 'Oops!'];

                            $response = $message;
                            $respaction = 'error';

                            return redirect()->back()->with($respaction, $response);
                        } else {


                            // Check Transaction PIN
                            if ($user->transaction_pin != null) {
                                // Validate Transaction PIN
                                if (Hash::check($req->transaction_pin, $user->transaction_pin)) {
                                    // Check User

                                    if ($user->ref_code == $req->user_id) {
                                        $resData = ['res' => 'You cannot send money to yourself.', 'message' => 'error', 'title' => 'Oops!'];

                                        $response = 'You cannot send money to yourself.';
                                        $respaction = 'error';

                                        return redirect()->back()->with($respaction, $response);
                                    } else {

                                        $client = User::where('ref_code', $req->user_id)->first();

                                        $imtCountry = AllCountries::where('name', $client->country)->first();

                                        // Check for Wallet Balance

                                        if ($debitAmount > $user->wallet_balance) {


                                            $checkForOverDraft = $this->overDraftInfo($user->wallet_balance, $debitAmount, $user->ref_code);

                                            if ($checkForOverDraft['status'] === false) {

                                                $resData = ['res' => $checkForOverDraft['message'] . ". Please add money to continue transaction", 'message' => 'error', 'title' => 'Oops!'];

                                                $response = $checkForOverDraft['message'] . ". Please add money to continue transaction";
                                                $respaction = 'error';

                                                return redirect()->back()->with($respaction, $response);
                                            } else {

                                                if ($req->commission == "on") {
                                                    $amount = number_format($debitAmount, 2);
                                                    $approve_commission = "Yes";
                                                } else {

                                                    $amount = number_format($debitAmount + $req->commissiondeduct, 2);
                                                    $approve_commission = "No";
                                                }


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

                                                $statement_route = "wallet";

                                                if ($req->localcurrency != $req->currency) {
                                                    // $dataInfo = $this->convertCurrencyRate($req->localcurrency, $req->currency, $req->amounttosend);
                                                    $dataInfo = $req->conversionamount;
                                                } else {
                                                    $dataInfo = $req->totalcharge;
                                                }



                                                if (env('APP_ENV') == "local") {
                                                    $mode = "test";
                                                } else {
                                                    $mode = "live";
                                                }


                                                $wallet_balance = $user->wallet_balance - $debitAmount;

                                                $withdrawal_per_day = $user->withdrawal_per_day + $debitAmount;
                                                $withdrawal_per_week = $user->withdrawal_per_week + $withdrawal_per_day;
                                                $withdrawal_per_month = $user->withdrawal_per_month + $withdrawal_per_week;

                                                $paymentToken = "wallet-" . date('dmY') . time();
                                                $status = "Delivered";
                                                $action = "Wallet debit";
                                                $requestReceive = 2;



                                                $insertPay = OrganizationPay::insert(['transactionid' => $paymentToken, 'coy_id' => $req->user_id, 'user_id' => $userID, 'purpose' => $service, 'amount' => $req->localcurrency . ' ' . $req->amount, 'withdraws' => $req->localcurrency . ' ' . $req->amount, 'state' => 1, 'payer_id' => $payerID, 'amount_to_send' => $dataInfo, 'commission' => $req->commissiondeduct, 'approve_commission' => $approve_commission, 'amountindollars' => $req->currency . ' ' . $req->conversionamount, 'request_receive' => $requestReceive]);



                                                if ($insertPay == true) {

                                                    // Update Wallet
                                                    User::where('email', $user->email)->update([
                                                        'withdrawal_per_day' => $withdrawal_per_day,
                                                        'withdrawal_per_week' => $withdrawal_per_week,
                                                        'withdrawal_per_month' => $withdrawal_per_month
                                                    ]);
                                                    // Send mail to both parties

                                                    // $this->to = "bambo@vimfile.com";
                                                    $this->to = $client->email;
                                                    $this->name = $user->name;
                                                    $this->coy_name = ($client->accountType == "Individual" ? $client->name : $client->businessname);
                                                    // $this->email = "bambo@vimfile.com";
                                                    $this->email = $user->email;
                                                    $this->amount = $req->currency . ' ' . number_format($dataInfo, 2);
                                                    $this->paypurpose = $service;
                                                    $this->subject = "Payment Received from " . $user->name . " for " . $service;
                                                    $this->subject2 = "Your Payment to " . $this->coy_name . " was successfull";



                                                    // Mail to receiver
                                                    $this->sendEmail($this->to, "Payment Received");

                                                    // Mail from Sender

                                                    $this->sendEmail($this->email, "Payment Successful");


                                                    // Insert Statement
                                                    // $activity = $req->payment_method." transfer of ".$req->currency.' '.number_format($req->amount, 2)." to ".$this->coy_name." for ".$service;
                                                    $activity = $req->payment_method . " transfer of " . $req->currency . ' ' . number_format($dataInfo, 2) . " to " . $this->coy_name . " for " . $service;
                                                    $credit = 0;
                                                    // $debit = $req->conversionamount + $req->commissiondeduct;
                                                    // $debit = $dataInfo;
                                                    $debit = $debitAmount;
                                                    $reference_code = $paymentToken;
                                                    $balance = 0;
                                                    $trans_date = date('Y-m-d');

                                                    $regards = $req->user_id;


                                                    $recWallet = $client->wallet_balance + $dataInfo;

                                                    if ($client->auto_deposit == 'on') {

                                                        $recWallet = $client->wallet_balance + $creditAmount;
                                                        $walletstatus = "Delivered";

                                                        $recMsg = "Hi " . $this->coy_name . ", You have received " . $req->localcurrency . ' ' . number_format($creditAmount, 2) . " in your PaySprint wallet for " . $service . " from " . $user->name . ". You now have " . $req->localcurrency . ' ' . number_format($recWallet, 2) . " balance in your wallet. PaySprint Team";
                                                    } else {
                                                        $recWallet = $client->wallet_balance;
                                                        $walletstatus = "Pending";

                                                        $recMsg = "Hi " . $this->coy_name . ", You have received " . $req->localcurrency . ' ' . number_format($creditAmount, 2) . " for " . $service . " from " . $user->name . ". Your wallet balance is " . $req->localcurrency . ' ' . number_format($recWallet, 2) . ". Kindly login to your wallet account to receive money. PaySprint Team " . route('my account');
                                                    }



                                                    User::where('ref_code', $req->user_id)->update(['wallet_balance' => $recWallet]);

                                                    // Senders statement
                                                    $this->insStatement($userID, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $walletstatus, $action, $regards, 1, $statement_route, 'on', $user->country);


                                                    // Receiver
                                                    $this->insStatement($client->email, $reference_code, "Received " . $req->localcurrency . ' ' . number_format($creditAmount, 2) . " in wallet for " . $service . " from " . $user->name, $creditAmount, 0, $balance, $trans_date, $walletstatus, "Wallet credit", $client->ref_code, 1, $statement_route, $client->auto_deposit, $client->country);


                                                    $newBalance = User::where('api_token', $req->api_token)->first();

                                                    $sendMsg = "Hi " . $user->name . ", You have made a " . $activity . ". Your new wallet balance is " . $req->currency . ' ' . number_format($newBalance->wallet_balance, 2) . ". If you did not make this transfer, kindly login to your PaySprint Account to change your Transaction PIN and report the issue to PaySprint Admin using Contact Us. PaySprint Team";

                                                    $usersPhone = User::where('email', $user->email)->where('telephone', 'LIKE', '%+%')->first();

                                                    if (isset($usersPhone)) {

                                                        $sendPhone = $user->telephone;
                                                    } else {
                                                        $sendPhone = "+" . $user->code . $user->telephone;
                                                    }


                                                    $merchantPhone = User::where('email', $client->email)->where('telephone', 'LIKE', '%+%')->first();

                                                    if (isset($merchantPhone)) {

                                                        $recPhone = $client->telephone;
                                                    } else {
                                                        $recPhone = "+" . $client->code . $client->telephone;
                                                    }





                                                    $this->createNotification($user->ref_code, $sendMsg, $user->playerId, $sendMsg, "Wallet Transaction");

                                                    $this->createNotification($client->ref_code, $recMsg, $client->playerId, $recMsg, "Wallet Transaction");

                                                    $this->updatePoints($user->id, 'Send money');
                                                    $this->updatePoints($client->id, 'Receive money');


                                                    $resData = ['res' => 'Money sent successfully', 'message' => 'success', 'title' => 'Good!'];

                                                    $response = 'Money sent successfully';
                                                    $respaction = 'success';


                                                    if ($user->country == "Nigeria") {

                                                        $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                                                        $this->sendSms($sendMsg, $correctPhone);
                                                    } else {
                                                        $this->sendMessage($sendMsg, $sendPhone);
                                                    }


                                                    if ($client->country == "Nigeria") {

                                                        $correctPhone = preg_replace("/[^0-9]/", "", $recPhone);
                                                        $this->sendSms($recMsg, $correctPhone);
                                                    } else {
                                                        $this->sendMessage($recMsg, $recPhone);
                                                    }





                                                    // Log::info($sendMsg);
                                                    // Log::info($recMsg);

                                                    $this->slack($sendMsg, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));
                                                    $this->slack($recMsg, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));

                                                    $monerisactivity = $sendMsg;

                                                    $this->keepRecord($reference_code, "WALLET APPROVED", $monerisactivity, "PaySprint", $user->country);


                                                    // dd($monerisactivity);


                                                    try {

                                                        $resData = ['res' => 'Money sent successfully', 'message' => 'success', 'title' => 'Good!'];

                                                        $response = 'Money sent successfully';
                                                        $respaction = 'success';

                                                        if ($user->accountType == "Individual") {
                                                            return redirect()->route('my account')->with($respaction, $response);
                                                        } else {
                                                            return redirect()->back()->with($respaction, $response);
                                                        }
                                                    } catch (\Throwable $th) {

                                                        $resData = ['res' => 'Money sent successfully. However, we are unable to send you a notification through a text message because we detected there is no phone number or you have an invalid phone number on your PaySprint Account. Kindly update your phone number to receive notification via text on your next transaction.', 'message' => 'success', 'title' => 'Good!'];

                                                        $response = 'Money sent successfully. However, we are unable to send you a notification through a text message because we detected there is no phone number or you have an invalid phone number on your PaySprint Account. Kindly update your phone number to receive notification via text on your next transaction.';
                                                        $respaction = 'success';


                                                        if ($user->accountType == "Individual") {
                                                            return redirect()->route('my account')->with($respaction, $response);
                                                        } else {
                                                            return redirect()->back()->with($respaction, $response);
                                                        }
                                                    }
                                                } else {
                                                    $resData = ['res' => 'Something went wrong', 'message' => 'info', 'title' => 'Oops!'];

                                                    $response = 'Something went wrong';
                                                    $respaction = 'error';

                                                    return redirect()->back()->with($respaction, $response);
                                                }
                                            }
                                        } elseif ((isset($imtCountry) && $imtCountry->imt == "false" && $client->country != $user->country) || (isset($imtCountry) && $imtCountry->outbound == "false" && $client->country != $user->country)) {
                                            $resData = ['res' => 'International money transfer is not yet available to ' . $imtCountry->name, 'message' => 'error', 'title' => 'Oops!'];

                                            $response = 'International money transfer is not yet available to ' . $imtCountry->name;
                                            $respaction = 'error';

                                            return redirect()->back()->with($respaction, $response);
                                        } else {


                                            if ($req->commission == "on") {
                                                $amount = number_format($debitAmount, 2);
                                                $approve_commission = "Yes";
                                            } else {

                                                $amount = number_format($debitAmount + $req->commissiondeduct, 2);
                                                $approve_commission = "No";
                                            }


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

                                            $statement_route = "wallet";

                                            if ($req->localcurrency != $req->currency) {
                                                // $dataInfo = $this->convertCurrencyRate($req->localcurrency, $req->currency, $req->amounttosend);
                                                $dataInfo = $req->conversionamount;
                                            } else {
                                                $dataInfo = $req->totalcharge;
                                            }



                                            if (env('APP_ENV') == "local") {
                                                $mode = "test";
                                            } else {
                                                $mode = "live";
                                            }





                                            if ($req->payment_method == "Wallet") {

                                                $wallet_balance = $user->wallet_balance - $debitAmount;

                                                $withdrawal_per_day = $user->withdrawal_per_day + $debitAmount;
                                                $withdrawal_per_week = $user->withdrawal_per_week + $withdrawal_per_day;
                                                $withdrawal_per_month = $user->withdrawal_per_month + $withdrawal_per_week;

                                                $paymentToken = "wallet-" . date('dmY') . time();
                                                $status = "Delivered";
                                                $action = "Wallet debit";
                                                $requestReceive = 2;
                                            } else {

                                                if ($req->localcurrency != $req->currency) {

                                                    // $monerisDeductamount = $this->currencyConvert($req->localcurrency, $req->totalcharge);
                                                    $monerisDeductamount = $req->conversionamount;
                                                } else {

                                                    $monerisDeductamount = $req->totalcharge;
                                                }






                                                $response = $this->monerisWalletProcess($user->api_token, $req->card_id, $monerisDeductamount, "purchase", "PaySprint Send Money to the Wallet of " . $client->name, $mode);

                                                if ($response->responseData['ResponseCode'] == "000" || $response->responseData['ResponseCode'] == "001" || $response->responseData['ResponseCode'] == "002" || $response->responseData['ResponseCode'] == "003" || $response->responseData['ResponseCode'] == "004" || $response->responseData['ResponseCode'] == "005" || $response->responseData['ResponseCode'] == "006" || $response->responseData['ResponseCode'] == "007" || $response->responseData['ResponseCode'] == "008" || $response->responseData['ResponseCode'] == "009" || $response->responseData['ResponseCode'] == "010" || $response->responseData['ResponseCode'] == "023" || $response->responseData['ResponseCode'] == "024" || $response->responseData['ResponseCode'] == "025" || $response->responseData['ResponseCode'] == "026" || $response->responseData['ResponseCode'] == "027" || $response->responseData['ResponseCode'] == "028" || $response->responseData['ResponseCode'] == "029") {

                                                    $reference_code = $response->responseData['ReceiptId'];



                                                    $wallet_balance = $user->wallet_balance;

                                                    $paymentToken = $reference_code;
                                                    $status = "Delivered";
                                                    $action = "Payment";
                                                    $requestReceive = 0;
                                                } else {

                                                    $message = $response->responseData['Message'];

                                                    $resData = ['res' => $message, 'message' => 'info', 'title' => 'Oops!'];

                                                    $response = $message;
                                                    $respaction = 'error';

                                                    return redirect()->back()->with($respaction, $response);
                                                }
                                            }




                                            $insertPay = OrganizationPay::insert(['transactionid' => $paymentToken, 'coy_id' => $req->user_id, 'user_id' => $userID, 'purpose' => $service, 'amount' => $req->localcurrency . ' ' . $req->amount, 'withdraws' => $req->localcurrency . ' ' . $req->amount, 'state' => 1, 'payer_id' => $payerID, 'amount_to_send' => $dataInfo, 'commission' => $req->commissiondeduct, 'approve_commission' => $approve_commission, 'amountindollars' => $req->currency . ' ' . $req->conversionamount, 'request_receive' => $requestReceive]);



                                            // Do FX Exchange if localcurrency != currency... Receiver receives money to the FX of the sender localcurrency...

                                            if ($req->localcurrency != $req->currency) {
                                                // Check Receiver for the FX currency and add money, else create and add money..
                                                $currencyFX = new CurrencyFxController();

                                                // Check Escrow wallet
                                                $checkAccount = EscrowAccount::where('user_id', $client->id)->where('currencyCode', $req->localcurrency)->first();

                                                // Create New Wallet
                                                if (!$checkAccount) {
                                                    // Create the wallet
                                                    $escrowID = 'ES_' . uniqid() . '_' . strtoupper(date('D'));
                                                    // Check if ID exists
                                                    $checkExists = EscrowAccount::where('escrow_id', $escrowID)->first();

                                                    if (isset($checkExists)) {
                                                        $escrowID = 'ES_' . uniqid() . '_' . strtoupper(date('D'));
                                                    }

                                                    $query = [
                                                        'user_id' => $client->id,
                                                        'escrow_id' => $escrowID,
                                                        'currencyCode' => $req->localcurrency,
                                                        'currencySymbol' => $user->currencySymbol,
                                                        'wallet_balance' => "0.00",
                                                        'country' => $user->country,
                                                        'active' => "false"
                                                    ];

                                                    EscrowAccount::insert($query);
                                                }

                                                // Fund Wallet
                                                $myaccount = EscrowAccount::where('user_id', $client->id)->where('currencyCode', $req->localcurrency)->first();

                                                $transaction_id = "es-wallet-" . date('dmY') . time();


                                                $activity = "Received " . $req->localcurrency . '' . number_format($creditAmount, 2) . " from {$user->name} to your PaySprint FX Wallet.";
                                                $credit = $creditAmount;
                                                $debit = 0;
                                                $reference_code = $transaction_id;
                                                $balance = 0;
                                                $trans_date = date('Y-m-d');
                                                $status = "Delivered";
                                                $action = "Escrow Wallet credit";
                                                $regards = $client->ref_code;
                                                $statement_route = "escrow wallet";
                                                $statement_route2 = "wallet";

                                                $fxBalance = $myaccount->wallet_balance + $creditAmount;


                                                EscrowAccount::where('user_id', $client->id)->where('currencyCode', $myaccount->currencyCode)->update(['wallet_balance' => $fxBalance]);

                                                $currencyFX->insFXStatement($myaccount->escrow_id, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, 'on', $myaccount->country, 'confirmed');

                                                $currencyFX->insStatement($client->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route2, $client->country);

                                                // Sender Statement


                                                $sendMsg = "Hi " . $client->name . ", You have " . $activity . " Your current {$myaccount->currencyCode} fx wallet balance is " . $myaccount->currencyCode . ' ' . number_format($fxBalance, 2) . ".";

                                                $usergetPhone = User::where('email', $client->email)->where('telephone', 'LIKE', '%+%')->first();

                                                if (isset($usergetPhone)) {

                                                    $sendPhone = $client->telephone;
                                                } else {
                                                    $sendPhone = "+" . $client->code . $client->telephone;
                                                }

                                                if ($client->country == "Nigeria") {

                                                    $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                                                    $currencyFX->sendSms($sendMsg, $correctPhone);
                                                } else {
                                                    $currencyFX->sendMessage($sendMsg, $sendPhone);
                                                }

                                                // Update Wallet
                                                User::where('email', $user->email)->update([
                                                    'wallet_balance' => $wallet_balance,
                                                    'withdrawal_per_day' => $withdrawal_per_day,
                                                    'withdrawal_per_week' => $withdrawal_per_week,
                                                    'withdrawal_per_month' => $withdrawal_per_month
                                                ]);


                                                // Log Activities here
                                                $currencyFX->createNotification($client->ref_code, $sendMsg, $client->playerId, $sendMsg, "Wallet Transaction");

                                                $currencyFX->slack('Congratulations!, ' . $client->name . ' ' . $sendMsg, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));

                                                $this->to = $client->email;
                                                $this->name = $user->name;
                                                $this->coy_name = ($client->accountType == "Individual" ? $client->name : $client->businessname);
                                                // $this->email = "bambo@vimfile.com";
                                                $this->email = $user->email;
                                                $this->amount = $myaccount->currencyCode . ' ' . number_format($debitAmount, 2);
                                                $this->paypurpose = $service;
                                                $this->subject = "Payment Received from " . $user->name . " for " . $service;
                                                $this->subject2 = "Your Payment to " . $this->coy_name . " was successfull";

                                                $activity2 = $req->payment_method . " transfer of " . $req->currency . ' ' . number_format($debitAmount, 2) . " to " . $this->coy_name . " for " . $service;
                                                $credit2 = 0;
                                                // $debit = $req->conversionamount + $req->commissiondeduct;
                                                // $debit = $dataInfo;
                                                $debit2 = $debitAmount;
                                                $reference_code = $paymentToken;
                                                $balance2 = 0;
                                                $trans_date2 = date('Y-m-d');
                                                $walletstatus = "Delivered";
                                                $action2 = "Wallet debit";
                                                $regards2 = $req->user_id;

                                                // Senders statement
                                                $this->insStatement($userID, $reference_code, $activity2, $credit2, $debit2, $balance2, $trans_date2, $walletstatus, $action2, $regards2, 1, "wallet", 'on', $user->country);


                                                // Mail to receiver
                                                $this->sendEmail($this->to, "Payment Received");

                                                // Mail from Sender

                                                $this->sendEmail($this->email, "Payment Successful");

                                                $sendMsg2 = "Hi " . $user->name . ", You have made a " . $activity2 . ". Your new wallet balance is " . $req->currency . ' ' . number_format($wallet_balance, 2) . ". If you did not make this transfer, kindly login to your PaySprint Account to change your Transaction PIN and report the issue to PaySprint Admin using Contact Us. PaySprint Team";

                                                $usersPhone = User::where('email', $user->email)->where('telephone', 'LIKE', '%+%')->first();

                                                if (isset($usersPhone)) {

                                                    $sendPhone = $user->telephone;
                                                } else {
                                                    $sendPhone = "+" . $user->code . $user->telephone;
                                                }

                                                $this->createNotification($user->ref_code, $sendMsg2, $user->playerId, $sendMsg2, "Wallet Transaction");

                                                $this->updatePoints($user->id, 'Send money');
                                                $this->updatePoints($client->id, 'Receive money');

                                                if ($user->country == "Nigeria") {

                                                    $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                                                    $this->sendSms($sendMsg2, $correctPhone);
                                                } else {
                                                    $this->sendMessage($sendMsg2, $sendPhone);
                                                }


                                                $this->slack($sendMsg2, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));

                                                $monerisactivity = $sendMsg2;

                                                $this->keepRecord($reference_code, "WALLET APPROVED", $monerisactivity, "PaySprint", $user->country);




                                                $resData = ['res' => 'Money sent successfully', 'message' => 'success', 'title' => 'Good!'];

                                                $response = 'Money sent successfully';
                                                $respaction = 'success';

                                                if ($user->accountType == "Individual") {
                                                    return redirect()->route('my account')->with($respaction, $response);
                                                } else {
                                                    return redirect()->back()->with($respaction, $response);
                                                }
                                            } else {


                                                if ($insertPay == true) {

                                                    // Update Wallet
                                                    User::where('email', $user->email)->update([
                                                        'wallet_balance' => $wallet_balance,
                                                        'withdrawal_per_day' => $withdrawal_per_day,
                                                        'withdrawal_per_week' => $withdrawal_per_week,
                                                        'withdrawal_per_month' => $withdrawal_per_month
                                                    ]);
                                                    // Send mail to both parties

                                                    // $this->to = "bambo@vimfile.com";
                                                    $this->to = $client->email;
                                                    $this->name = $user->name;
                                                    $this->coy_name = ($client->accountType == "Individual" ? $client->name : $client->businessname);
                                                    // $this->email = "bambo@vimfile.com";
                                                    $this->email = $user->email;
                                                    $this->amount = $req->currency . ' ' . number_format($dataInfo, 2);
                                                    $this->paypurpose = $service;
                                                    $this->subject = "Payment Received from " . $user->name . " for " . $service;
                                                    $this->subject2 = "Your Payment to " . $this->coy_name . " was successfull";



                                                    // Mail to receiver
                                                    $this->sendEmail($this->to, "Payment Received");

                                                    // Mail from Sender

                                                    $this->sendEmail($this->email, "Payment Successful");


                                                    // Insert Statement
                                                    // $activity = $req->payment_method." transfer of ".$req->currency.' '.number_format($req->amount, 2)." to ".$this->coy_name." for ".$service;
                                                    $activity = $req->payment_method . " transfer of " . $req->currency . ' ' . number_format($dataInfo, 2) . " to " . $this->coy_name . " for " . $service;
                                                    $credit = 0;
                                                    // $debit = $req->conversionamount + $req->commissiondeduct;
                                                    // $debit = $dataInfo;
                                                    $debit = $req->amount;
                                                    $reference_code = $paymentToken;
                                                    $balance = 0;
                                                    $trans_date = date('Y-m-d');

                                                    $regards = $req->user_id;


                                                    $recWallet = $client->wallet_balance + $dataInfo;

                                                    if ($client->auto_deposit == 'on') {

                                                        $recWallet = $client->wallet_balance + $dataInfo;
                                                        $walletstatus = "Delivered";

                                                        $recMsg = "Hi " . $this->coy_name . ", You have received " . $req->currency . ' ' . number_format($dataInfo, 2) . " in your PaySprint wallet for " . $service . " from " . $user->name . ". You now have " . $req->currency . ' ' . number_format($recWallet, 2) . " balance in your wallet. PaySprint Team";
                                                    } else {
                                                        $recWallet = $client->wallet_balance;
                                                        $walletstatus = "Pending";

                                                        $recMsg = "Hi " . $this->coy_name . ", You have received " . $req->currency . ' ' . number_format($dataInfo, 2) . " for " . $service . " from " . $user->name . ". Your wallet balance is " . $req->currency . ' ' . number_format($recWallet, 2) . ". Kindly login to your wallet account to receive money. PaySprint Team " . route('my account');
                                                    }



                                                    User::where('ref_code', $req->user_id)->update(['wallet_balance' => $recWallet]);

                                                    // Senders statement
                                                    $this->insStatement($userID, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $walletstatus, $action, $regards, 1, $statement_route, 'on', $user->country);


                                                    // Receiver
                                                    $this->insStatement($client->email, $reference_code, "Received " . $req->currency . ' ' . number_format($dataInfo, 2) . " in wallet for " . $service . " from " . $user->name, $dataInfo, 0, $balance, $trans_date, $walletstatus, "Wallet credit", $client->ref_code, 1, $statement_route, $client->auto_deposit, $client->country);



                                                    $sendMsg = "Hi " . $user->name . ", You have made a " . $activity . ". Your new wallet balance is " . $req->localcurrency . ' ' . number_format($wallet_balance, 2) . ". If you did not make this transfer, kindly login to your PaySprint Account to change your Transaction PIN and report the issue to PaySprint Admin using Contact Us. PaySprint Team";

                                                    $usersPhone = User::where('email', $user->email)->where('telephone', 'LIKE', '%+%')->first();

                                                    if (isset($usersPhone)) {

                                                        $sendPhone = $user->telephone;
                                                    } else {
                                                        $sendPhone = "+" . $user->code . $user->telephone;
                                                    }


                                                    $merchantPhone = User::where('email', $client->email)->where('telephone', 'LIKE', '%+%')->first();

                                                    if (isset($merchantPhone)) {

                                                        $recPhone = $client->telephone;
                                                    } else {
                                                        $recPhone = "+" . $client->code . $client->telephone;
                                                    }





                                                    $this->createNotification($user->ref_code, $sendMsg, $user->playerId, $sendMsg, "Wallet Transaction");

                                                    $this->createNotification($client->ref_code, $recMsg, $client->playerId, $recMsg, "Wallet Transaction");

                                                    $this->updatePoints($user->id, 'Send money');
                                                    $this->updatePoints($client->id, 'Receive money');


                                                    $resData = ['res' => 'Money sent successfully', 'message' => 'success', 'title' => 'Good!'];

                                                    $response = 'Money sent successfully';
                                                    $respaction = 'success';


                                                    if ($user->country == "Nigeria") {

                                                        $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                                                        $this->sendSms($sendMsg, $correctPhone);
                                                    } else {
                                                        $this->sendMessage($sendMsg, $sendPhone);
                                                    }


                                                    if ($client->country == "Nigeria") {

                                                        $correctPhone = preg_replace("/[^0-9]/", "", $recPhone);
                                                        $this->sendSms($recMsg, $correctPhone);
                                                    } else {
                                                        $this->sendMessage($recMsg, $recPhone);
                                                    }





                                                    // Log::info($sendMsg);
                                                    // Log::info($recMsg);

                                                    $this->slack($sendMsg, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));
                                                    $this->slack($recMsg, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));

                                                    $monerisactivity = $sendMsg;

                                                    $this->keepRecord($reference_code, "WALLET APPROVED", $monerisactivity, "PaySprint", $user->country);


                                                    // dd($monerisactivity);


                                                    try {

                                                        $resData = ['res' => 'Money sent successfully', 'message' => 'success', 'title' => 'Good!'];

                                                        $response = 'Money sent successfully';
                                                        $respaction = 'success';

                                                        if ($user->accountType == "Individual") {
                                                            return redirect()->route('my account')->with($respaction, $response);
                                                        } else {
                                                            return redirect()->back()->with($respaction, $response);
                                                        }
                                                    } catch (\Throwable $th) {

                                                        $resData = ['res' => 'Money sent successfully. However, we are unable to send you a notification through a text message because we detected there is no phone number or you have an invalid phone number on your PaySprint Account. Kindly update your phone number to receive notification via text on your next transaction.', 'message' => 'success', 'title' => 'Good!'];

                                                        $response = 'Money sent successfully. However, we are unable to send you a notification through a text message because we detected there is no phone number or you have an invalid phone number on your PaySprint Account. Kindly update your phone number to receive notification via text on your next transaction.';
                                                        $respaction = 'success';


                                                        if ($user->accountType == "Individual") {
                                                            return redirect()->route('my account')->with($respaction, $response);
                                                        } else {
                                                            return redirect()->back()->with($respaction, $response);
                                                        }
                                                    }
                                                } else {
                                                    $resData = ['res' => 'Something went wrong', 'message' => 'info', 'title' => 'Oops!'];

                                                    $response = 'Something went wrong';
                                                    $respaction = 'error';

                                                    return redirect()->back()->with($respaction, $response);
                                                }
                                            }
                                        }
                                    }
                                } else {
                                    // Incorrect Transaction PIN
                                    $message = "Invalid transaction pin";

                                    $resData = ['res' => $message, 'message' => 'error', 'title' => 'Oops!'];

                                    $response = $message;
                                    $respaction = 'error';

                                    return redirect()->back()->with($respaction, $response);
                                }
                            } else {
                                // Redirect to route to setup transaction Pin
                                $message = "Kindly setup transaction pin in your profile settings";

                                $resData = ['res' => $message, 'message' => 'error', 'title' => 'Oops!'];

                                $response = $message;
                                $respaction = 'error';

                                return redirect()->back()->with($respaction, $response);
                            }
                        }
                    } else {
                        $resData = ['res' => $checking["response"], 'message' => 'error', 'title' => 'Oops!'];

                        $response = $checking["response"];
                        $respaction = 'error';

                        return redirect()->back()->with($respaction, $response);
                    }
                } else {
                    $resData = ['res' => 'Cannot find your account record, to confirm payment.', 'message' => 'error', 'title' => 'Oops!'];

                    $response = 'Cannot find your account record, to confirm payment.';
                    $respaction = 'error';

                    return redirect()->back()->with($respaction, $response);
                }
            } else {

                $error = implode(",", $validator->messages()->all());

                $resData = ['res' => $error, 'message' => 'error', 'title' => 'Oops!'];

                $response = $error;
                $respaction = 'error';

                return redirect()->back()->with($respaction, $response);
            }
        }
    }


    // Send Money to Anonymous
    public function sendMoneyToAnonymous(Request $req)
    {


        if ($req->amount < 0) {
            $response = 'Please enter a positive amount to send';
            $data = [];
            $message = $response;
            $status = 403;

            $resData = ['data' => $data, 'message' => $message, 'status' => $status, 'link' => '#'];

            return $this->returnJSON($resData, $status);
        } else {

            try {


                // Get User Info
                $thisuser = User::where('api_token', $req->bearerToken())->first();

                if ($thisuser->flagged === 1) {
                    $data = [];
                    $message = 'Hello ' . $thisuser->name . ', Access to the account is not currently available. Kindly contact the Admin using this link: https://paysprint.ca/contact.';
                    $status = 400;
                } else {

                    if (isset($req->paymentMode) && $req->paymentMode === "Partner") {

                        $getCountry = AllCountries::where('name', $thisuser->country)->first();
                        $transaction_id = "ps-" . date('dmY') . time();

                        $validator = Validator::make($req->all(), [
                            'country' => 'required',
                            'payment_method' => 'required',
                            'amount' => 'required',
                            'transaction_pin' => 'required',
                        ]);


                        if ($validator->passes()) {

                            // Get User Info
                            $thisuser = User::where('api_token', $req->bearerToken())->first();

                            $imtCountry = AllCountries::where('name', $req->country)->first();

                            if (isset($thisuser)) {

                                // Do IDV

                                $checking = $this->checkUsersPassAccount($thisuser->id);


                                if (in_array("send money", $checking['access'])) {

                                    $minBal = $this->minimumWithdrawal($thisuser->country);

                                    // Check Anon user existence
                                    $checkExist = User::where('email', $req->email)->first();


                                    if (isset($req->paymentWallet) && $req->paymentWallet === "fx_wallet") {

                                        // Temporary update
                                        $data = [];
                                        $message = 'Payment with FX is currently not available';
                                        $status = 400;

                                        $resData = ['data' => $data, 'message' => $message, 'status' => $status];


                                        return $this->returnJSON($resData, $status);

                                        // Get wallet balance for the selected wallet...

                                        $fxCurrency = new CurrencyFxController();

                                        $walletResult = $fxCurrency->getFxWalletsFromController($thisuser->id, $req->paymentFxWallet);


                                        // Check for wallet Balance...
                                        if ((float)$walletResult->wallet_balance < (float)$req->amount) {

                                            $response = "Insufficient PaySprint FX Wallet balance";
                                            $data = [];
                                            $message = $response;
                                            $status = 400;


                                            $resData = ['data' => $data, 'message' => $message, 'status' => $status];

                                            return $this->returnJSON($resData, $status);
                                        }


                                        // Check Transaction PIN
                                        if ($thisuser->transaction_pin != null) {

                                            if (Hash::check($req->transaction_pin, $thisuser->transaction_pin)) {

                                                if ($thisuser->approval < 2 && $thisuser->accountLevel <= 2) {
                                                    $response = 'You cannot send money at the moment because your account is still on review.';
                                                    $data = [];
                                                    $message = $response;
                                                    $status = 403;


                                                    $resData = ['data' => $data, 'message' => $message, 'status' => $status];

                                                    return $this->returnJSON($resData, $status);
                                                } else {




                                                    $approve_commission = "No";

                                                    $foreigncurrency = $this->getCountryCode($req->country);


                                                    if ($walletResult->country != $req->country) {

                                                        // Get Country Currency code

                                                        // COnvert Currency for Wallet credit to receiver
                                                        $amount = $this->convertCurrencyRate($foreigncurrency->currencyCode, $walletResult->currencyCode, $req->amount);
                                                    } else {
                                                        $amount = $req->amount;
                                                    }

                                                    $dob = $thisuser->yearOfBirth . '' . ($thisuser->monthOfBirth <= 9 ? "0" . $thisuser->monthOfBirth : $thisuser->monthOfBirth) . '' . ($thisuser->dayOfBirth <= 9 ? "0" . $thisuser->dayOfBirth : $thisuser->dayOfBirth);

                                                    // Do MOEX MEAddTransaction....
                                                    $moexProperties = array(
                                                        'sender' => $thisuser->name,
                                                        'senderName' => explode(' ', $thisuser->name)[0],
                                                        'senderLastName' => explode(' ', $thisuser->name)[1],
                                                        'senderAddress' => $thisuser->address,
                                                        'senderCountry' => $getCountry->cca3,
                                                        'senderIdDocumentNumber' => $req->compulsory_id_Number,
                                                        'senderIdDocumentType' => $req->compulsory_id_Type,
                                                        'receiver' => $req->mandatory_surname,
                                                        'phoneNumber' => $req->mandatory_phoneNumber,
                                                        'receiverName' => $req->mandatory_fullname,
                                                        'receiverLastName' => $req->mandatory_surname,
                                                        'receiverCountry' => $foreigncurrency->cca3,
                                                        'bankDeposit' => $req->card_type == "Bank Account" ? 'TRUE' : 'FALSE',
                                                        'bankName' => isset($req->bank_code) ? explode("__", $req->bank_code)[1] : $req->mandatory_bankName,
                                                        'bankAddress' => isset($req->bank_code) ? explode("__", $req->bank_code)[0] : $req->mandatory_bankName . ' ' . $thisuser->country,
                                                        'bankAccount' => isset($req->banking_account_number) ? $req->banking_account_number : $req->mandatory_accountNumber,
                                                        'branchCode' => isset($req->branchCode) ? $req->branchCode : '',
                                                        'amountToPay' => $amount,
                                                        'currencyToPay' => $foreigncurrency->currencyCode,
                                                        'amountSent' => $req->totalcharge,
                                                        'currencySent' => $getCountry->currencyCode,
                                                        'originCountry' => $getCountry->cca3,
                                                        'auxiliaryInfo' => [
                                                            'SenderBirthDate' => $dob,
                                                            'SenderBirthPlace' => "",
                                                            'SenderBirthCountry' => $getCountry->cca3,
                                                            'SenderGender' => $req->gender
                                                        ],
                                                        'reference' => $transaction_id
                                                    );

                                                    // Go to MOEX Endpoint....
                                                    $moexControllerPs = new MoexController();

                                                    $doMoex = $moexControllerPs->moexPS($moexProperties);


                                                    if (array_key_exists('error', $doMoex)) {

                                                        $data = [];
                                                        $message = $doMoex['error'];
                                                        $status = 400;

                                                        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

                                                        return $this->returnJSON($resData, $status);
                                                    }


                                                    MoexTransaction::insert(['user_id' => $thisuser->id, 'transaction' => json_encode($doMoex), 'amount' => $req->amount, 'currency' => $thisuser->currencyCode, 'status' => 'initiated', 'transactionMessage' => "Transaction initiated"]);



                                                    // Getting the payer
                                                    $userID = $thisuser->email;
                                                    $payerID = $thisuser->ref_code;

                                                    // $req->user_id is for the receiver::

                                                    // Do Insert
                                                    if ($req->service != "Others") {
                                                        $service = $req->service;
                                                    } else {
                                                        $service = $req->purpose;
                                                    }

                                                    $statement_route = "wallet";


                                                    $wallet_balance = $walletResult->wallet_balance - $req->amount;
                                                    $paymentToken = "es-wallet-" . date('dmY') . time();
                                                    $paystatus = "Delivered";
                                                    $action = "Escrow Wallet debit";
                                                    $requestReceive = 2;


                                                    $insertPay = OrganizationPay::insert(['transactionid' => $paymentToken, 'coy_id' => $thisuser->ref_code, 'user_id' => $userID, 'purpose' => $service, 'amount' => $foreigncurrency->currencyCode . ' ' . $req->amount, 'withdraws' => $foreigncurrency->currencyCode . ' ' . $req->amount, 'state' => 1, 'payer_id' => $payerID, 'amount_to_send' => $amount, 'commission' => $req->commissiondeduct, 'approve_commission' => $approve_commission, 'amountindollars' => $foreigncurrency->currencyCode . ' ' . $amount, 'request_receive' => $requestReceive]);

                                                    if ($insertPay == true) {


                                                        EscrowAccount::where('user_id', $thisuser->id)->where('currencyCode', $walletResult->currencyCode)->update(['wallet_balance' => $wallet_balance]);



                                                        // Notification to Sender
                                                        $this->name = $thisuser->name;
                                                        // $this->email = "bambo@vimfile.com";

                                                        $this->email = $thisuser->email;
                                                        $this->subject = $walletResult->currencyCode . ' ' . number_format($req->amount, 2) . " has been sent through Text-To-Transfer Platform from your Wallet with PaySprint.";

                                                        $this->message = '<p>You have sent <strong>' . $walletResult->currencyCode . ' ' . number_format($req->amount, 2) . '</strong> to ' . $req->mandatory_fullname . '. Payout fee of <strong>' . $walletResult->currencyCode . ' ' . number_format($req->commissiondeduct, 2) . '</strong> is charged. You now have <strong>' . $walletResult->currencyCode . ' ' . number_format($wallet_balance, 2) . '</strong> balance in your ' . $walletResult->currencyCode . ' FX wallet account</p>';

                                                        $sendMsg = 'You have sent ' . $walletResult->currencyCode . ' ' . number_format($req->amount, 2) . ' to ' . $req->mandatory_fullname . '. Payout fee of ' . $walletResult->currencyCode . ' ' . number_format($req->commissiondeduct, 2) . ' is charged. You now have ' . $walletResult->currencyCode . ' ' . number_format($wallet_balance, 2) . ' balance in your ' . $walletResult->currencyCode . ' FX wallet account';

                                                        $userPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

                                                        if (isset($userPhone)) {

                                                            $sendPhone = $thisuser->telephone;
                                                        } else {
                                                            $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
                                                        }


                                                        $this->sendEmail($this->email, "Fund remittance");

                                                        if ($thisuser->country == "Nigeria") {

                                                            $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                                                            $this->sendSms($sendMsg, $correctPhone);
                                                        } else {
                                                            $this->sendMessage($sendMsg, $sendPhone);
                                                        }



                                                        // Notification for receiver
                                                        $this->name = $req->mandatory_fullname;
                                                        // $this->to = "bambo@vimfile.com";
                                                        $this->to = $req->mandatory_emailAddress;
                                                        $this->subject = $thisuser->name . " has sent you " . $foreigncurrency->currencyCode . ' ' . number_format($amount, 2) . " on PaySprint";

                                                        $bankNameRecord = isset($req->bank_code) ? explode("__", $req->bank_code)[1] : $req->mandatory_bankName;
                                                        $bankNumberRecord = isset($req->banking_account_number) ? $req->banking_account_number : $req->mandatory_accountNumber;

                                                        $this->message = '<p>You have received <strong>' . $foreigncurrency->currencyCode . ' ' . number_format($amount, 2) . '</strong> from ' . $thisuser->name . '. Here is the transaction ID: <strong>' . $doMoex['transactionId'] . '</strong>. Your fund will be processed to <strong>'.$bankNameRecord.' - '.$bankNumberRecord.'</strong>. You can also get paid at <strong>' . $req->remittance . '</strong> of your choice. Kindly have your means of identification match your identity to receive fund.</p>';

                                                        $recMesg = 'You have received ' . $foreigncurrency->currencyCode . ' ' . number_format($amount, 2) . ' from ' . $thisuser->name . '. Here is the transaction ID: ' . $doMoex['transactionId'] . '. Your fund will be processed to '.$bankNameRecord.' - '.$bankNumberRecord.' You can also get paid at ' . $req->remittance . ' of your choice. Kindly have your means of identification match your identity to receive fund.';


                                                        $recPhone = "+" . $req->countryCode . $req->phone;


                                                        $this->sendEmail($this->to, "Fund remittance");



                                                        if ($req->country == "Nigeria") {

                                                            $correctPhone = preg_replace("/[^0-9]/", "", $recPhone);
                                                            $this->sendSms($recMesg, $correctPhone);
                                                        } else {
                                                            $this->sendMessage($recMesg, $recPhone);
                                                        }





                                                        // Insert Statement
                                                        $activity = $req->payment_method . " transfer of " . $thisuser->currencyCode . ' ' . number_format($req->amount, 2) . " to " . $req->fname . ' ' . $req->lname . " for " . $service.". Payout fee of " . $walletResult->currencyCode . " " . number_format($req->commissiondeduct, 2) . " is charged";
                                                        $credit = 0;
                                                        // $debit = $req->conversionamount + $req->commissiondeduct;
                                                        $debit = $req->amount;
                                                        $reference_code = $paymentToken;
                                                        $balance = 0;
                                                        $trans_date = date('Y-m-d');

                                                        $regards = $thisuser->ref_code;

                                                        // Senders statement
                                                        $this->insStatement($userID, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $paystatus, $action, $regards, 1, $statement_route, 'on', $thisuser->country);

                                                        $fxCurrency->insFXStatement($walletResult->escrow_id, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $paystatus, $action, $regards, 1, $statement_route, 'on', $thisuser->country, 'confirmed');



                                                        $response = 'Money sent successfully';

                                                        // $data = $insertPay;
                                                        $data = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol')->where('api_token', $req->bearerToken())->first();
                                                        $status = 200;
                                                        $message = $response;


                                                        $this->createNotification($thisuser->ref_code, $sendMsg, $thisuser->playerId, $sendMsg, "Wallet Transaction");

                                                        $this->updatePoints($thisuser->id, 'Send money');

                                                        // Log::info("Congratulations!, ".$thisuser->name." ".$sendMsg);
                                                        // Log::info("Congratulations!, ".$this->name." ".$recMesg);

                                                        $this->slack("Congratulations!, " . $thisuser->name . " " . $sendMsg, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));
                                                    } else {

                                                        $response = 'Something went wrong';
                                                        $data = [];
                                                        $message = $response;
                                                        $status = 400;
                                                    }
                                                }
                                            } else {
                                                // Incorrect Transaction PIN
                                                $response = 'Invalid transaction pin';
                                                $data = [];
                                                $message = $response;
                                                $status = 400;
                                            }
                                        } else {
                                            // Redirect to route to setup transaction Pin
                                            $response = 'Kindly setup transaction pin in your profile settings';
                                            $data = [];
                                            $message = $response;
                                            $status = 400;
                                        }
                                    } else {

                                        if (($thisuser->wallet_balance - $minBal) <= $req->totalcharge) {

                                            $response = "Your minimum wallet balance is " . $thisuser->currencyCode . ' ' . number_format($minBal, 2) . ". Please add money to continue transaction";
                                            $data = [];
                                            $message = $response;
                                            $status = 403;


                                            $resData = ['data' => $data, 'message' => $message, 'status' => $status];

                                            return $this->returnJSON($resData, $status);
                                        } else {

                                            // Check Transaction PIN
                                            if ($thisuser->transaction_pin != null) {

                                                if (Hash::check($req->transaction_pin, $thisuser->transaction_pin)) {

                                                    if ($thisuser->approval < 2 && $thisuser->accountLevel <= 2) {
                                                        $response = 'You cannot send money at the moment because your account is still on review.';
                                                        $data = [];
                                                        $message = $response;
                                                        $status = 403;


                                                        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

                                                        return $this->returnJSON($resData, $status);
                                                    } else {


                                                        $approve_commission = "No";

                                                        $foreigncurrency = $this->getCountryCode($req->country);


                                                        if ($thisuser->country != $req->country) {

                                                            // Get Country Currency code

                                                            // COnvert Currency for Wallet credit to receiver
                                                            $amount = $this->convertCurrencyRate($foreigncurrency->currencyCode, $thisuser->currencyCode, $req->amount);
                                                        } else {
                                                            $amount = $req->amount;
                                                        }


                                                        // Getting the payer
                                                        $userID = $thisuser->email;
                                                        $payerID = $thisuser->ref_code;

                                                        // $req->user_id is for the receiver::

                                                        // Do Insert
                                                        if ($req->service != "Others") {
                                                            $service = $req->service;
                                                        } else {
                                                            $service = $req->purpose;
                                                        }




                                                        if ($req->totalcharge > ($thisuser->wallet_balance - $minBal)) {

                                                            $response = "Your minimum wallet balance is " . $thisuser->currencyCode . ' ' . number_format($minBal, 2) . ". Please add money to continue transaction";
                                                            $data = [];
                                                            $message = $response;
                                                            $status = 400;
                                                        } else {

                                                            $dob = $thisuser->yearOfBirth . '' . ($thisuser->monthOfBirth <= 9 ? "0" . $thisuser->monthOfBirth : $thisuser->monthOfBirth) . '' . ($thisuser->dayOfBirth <= 9 ? "0" . $thisuser->dayOfBirth : $thisuser->dayOfBirth);




                                                            // Do MOEX MEAddTransaction....
                                                            $moexProperties = array(
                                                                'sender' => $thisuser->name,
                                                                'senderName' => explode(' ', $thisuser->name)[0],
                                                                'senderLastName' => explode(' ', $thisuser->name)[1],
                                                                'senderAddress' => $thisuser->address,
                                                                'senderCountry' => $getCountry->cca3,
                                                                'senderIdDocumentNumber' => $req->compulsory_id_Number,
                                                                'senderIdDocumentType' => $req->compulsory_id_Type,
                                                                'receiver' => $req->mandatory_surname,
                                                                'phoneNumber' => $req->mandatory_phoneNumber,
                                                                'receiverName' => $req->mandatory_fullname,
                                                                'receiverLastName' => $req->mandatory_surname,
                                                                'receiverCountry' => $foreigncurrency->cca3,
                                                                'bankDeposit' => $req->payment_type == "Bank Account" ? 'TRUE' : ($req->payment_type == "Instant" ? 'TRUE' : 'FALSE'),
                                                                'bankName' => isset($req->bank_code) ? explode("__", $req->bank_code)[1] : $req->mandatory_bankName,
                                                                'bankAddress' => isset($req->bank_code) ? explode("__", $req->bank_code)[0] : $req->mandatory_bankName . ' ' . $thisuser->country,
                                                                'bankAccount' => isset($req->banking_account_number) ? $req->banking_account_number : $req->mandatory_accountNumber,
                                                                'branchCode' => isset($req->branchCode) ? $req->branchCode : '',
                                                                'amountToPay' => $amount,
                                                                'currencyToPay' => $foreigncurrency->currencyCode,
                                                                'amountSent' => $req->totalcharge,
                                                                'currencySent' => $getCountry->currencyCode,
                                                                'originCountry' => $getCountry->cca3,
                                                                'auxiliaryInfo' => [
                                                                    'SenderBirthDate' => $dob,
                                                                    'SenderBirthPlace' => "",
                                                                    'SenderBirthCountry' => $getCountry->cca3,
                                                                    'SenderGender' => $req->gender
                                                                ],
                                                                'reference' => $transaction_id
                                                            );



                                                            // Go to MOEX Endpoint....
                                                            $moexControllerPs = new MoexController();

                                                            $doMoex = $moexControllerPs->moexPS($moexProperties);

                                                            if (array_key_exists('error', $doMoex)) {

                                                                $data = [];
                                                                $message = $doMoex['error'];
                                                                $status = 400;

                                                                $resData = ['data' => $data, 'message' => $message, 'status' => $status];

                                                                return $this->returnJSON($resData, $status);
                                                            }


                                                            MoexTransaction::insert(['user_id' => $thisuser->id, 'transaction' => json_encode($doMoex), 'amount' => $req->amount, 'currency' => $thisuser->currencyCode, 'status' => 'initiated', 'transactionMessage' => "Transaction initiated"]);


                                                            $statement_route = "wallet";


                                                            $wallet_balance = $thisuser->wallet_balance - $req->totalcharge;
                                                            $withdrawal_per_day = $thisuser->withdrawal_per_day + $req->totalcharge;
                                                            $withdrawal_per_week = $thisuser->withdrawal_per_week + $withdrawal_per_day;
                                                            $withdrawal_per_month = $thisuser->withdrawal_per_month + $withdrawal_per_week;
                                                            $paymentToken = "wallet-" . date('dmY') . time();
                                                            $paystatus = "Delivered";
                                                            $action = "Wallet debit";
                                                            $requestReceive = 2;


                                                            $insertPay = OrganizationPay::insert(['transactionid' => $paymentToken, 'coy_id' => $thisuser->ref_code, 'user_id' => $userID, 'purpose' => $service, 'amount' => $foreigncurrency->currencyCode . ' ' . $req->totalcharge, 'withdraws' => $foreigncurrency->currencyCode . ' ' . $req->totalcharge, 'state' => 1, 'payer_id' => $payerID, 'amount_to_send' => $amount, 'commission' => $req->commissiondeduct, 'approve_commission' => $approve_commission, 'amountindollars' => $foreigncurrency->currencyCode . ' ' . $amount, 'request_receive' => $requestReceive]);

                                                            if ($insertPay == true) {


                                                                // Update Wallet
                                                                User::where('api_token', $req->bearerToken())->update([
                                                                    'wallet_balance' => $wallet_balance,
                                                                    'withdrawal_per_day' => $withdrawal_per_day,
                                                                    'withdrawal_per_week' => $withdrawal_per_week,
                                                                    'withdrawal_per_month' => $withdrawal_per_month
                                                                ]);


                                                                // Send mail to both parties

                                                                // Notification to Sender
                                                                $this->name = $thisuser->name;
                                                                // $this->email = "bambo@vimfile.com";
                                                                $this->email = $thisuser->email;
                                                                $this->subject = $thisuser->currencyCode . ' ' . number_format($req->amount, 2) . " has been sent through Text-To-Transfer Platform from your Wallet with PaySprint.";

                                                                $this->message = '<p>You have sent <strong>' . $thisuser->currencyCode . ' ' . number_format($req->amount, 2) . '</strong> to ' . $req->mandatory_fullname . '. Payout fee of <strong>' . $thisuser->currencyCode . ' ' . number_format($req->commissiondeduct, 2) . '</strong> is charged. You now have <strong>' . $thisuser->currencyCode . ' ' . number_format($wallet_balance, 2) . '</strong> balance in your account</p>';

                                                                $sendMsg = 'You have sent ' . $thisuser->currencyCode . ' ' . number_format($req->amount, 2) . ' to ' . $req->mandatory_fullname . ' Payout fee of ' . $thisuser->currencyCode . ' ' . number_format($req->commissiondeduct, 2) . ' is charged. You now have ' . $thisuser->currencyCode . ' ' . number_format($wallet_balance, 2) . ' balance in your account';

                                                                $userPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

                                                                if (isset($userPhone)) {

                                                                    $sendPhone = $thisuser->telephone;
                                                                } else {
                                                                    $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
                                                                }


                                                                $this->sendEmail($this->email, "Fund remittance");

                                                                if ($thisuser->country == "Nigeria") {

                                                                    $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                                                                    $this->sendSms($sendMsg, $correctPhone);
                                                                } else {
                                                                    $this->sendMessage($sendMsg, $sendPhone);
                                                                }




                                                                // Notification for receiver
                                                                $this->name = $req->mandatory_fullname;
                                                                // $this->to = "bambo@vimfile.com";
                                                                $this->to = $req->mandatory_emailAddress;
                                                                $this->subject = $thisuser->name . " has sent you " . $foreigncurrency->currencyCode . ' ' . number_format($amount, 2) . " on PaySprint";


                                                                $bankNameRecord = isset($req->bank_code) ? explode("__", $req->bank_code)[1] : $req->mandatory_bankName;
                                                                $bankNumberRecord = isset($req->banking_account_number) ? $req->banking_account_number : $req->mandatory_accountNumber;


                                                                $this->message = '<p>You have received <strong>' . $foreigncurrency->currencyCode . ' ' . number_format($amount, 2) . '</strong> from ' . $thisuser->name . '. Here is the transaction ID: <strong>' . $doMoex['transactionId'] . '</strong>.
                                                                Your fund will be processed to
                                                                <strong>'.$bankNameRecord.' - '.$bankNumberRecord.'</strong>.
                                                                You can also get paid at <strong>' . $req->remittance . '</strong> of your choice. Kindly have your means of identification match your identity to receive fund.</p>';

                                                                $recMesg = 'You have received ' . $foreigncurrency->currencyCode . ' ' . number_format($amount, 2) . ' from ' . $thisuser->name . '. Here is the transaction ID: ' . $doMoex['transactionId'] . '. Your fund will be processed to '.$bankNameRecord.' - '.$bankNumberRecord.' You can also get paid at ' . $req->remittance . ' of your choice. Kindly have your means of identification match your identity to receive fund.';







                                                                $recPhone = "+" . $req->countryCode . $req->phone;


                                                                $this->sendEmail($this->to, "Fund remittance");


                                                                if ($req->country == "Nigeria") {

                                                                    $correctPhone = preg_replace("/[^0-9]/", "", $recPhone);
                                                                    $this->sendSms($recMesg, $correctPhone);
                                                                } else {
                                                                    $this->sendMessage($recMesg, $recPhone);
                                                                }





                                                                // Insert Statement
                                                                $activity = $req->payment_method . " transfer of " . $thisuser->currencyCode . ' ' . number_format($req->amount, 2) . " to " . $req->mandatory_fullname . " for " . $service.". Payout fee of " . $thisuser->currencyCode . " " . number_format($req->commissiondeduct, 2) . " is charged";
                                                                $credit = 0;
                                                                // $debit = $req->conversionamount + $req->commissiondeduct;
                                                                $debit = $req->amount;
                                                                $reference_code = $paymentToken;
                                                                $balance = 0;
                                                                $trans_date = date('Y-m-d');

                                                                $regards = $thisuser->ref_code;

                                                                // Senders statement
                                                                $this->insStatement($userID, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $paystatus, $action, $regards, 1, $statement_route, 'on', $thisuser->country);




                                                                $response = 'Money sent successfully';

                                                                // $data = $insertPay;
                                                                $data = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol')->where('api_token', $req->bearerToken())->first();
                                                                $status = 200;
                                                                $message = $response;


                                                                $this->createNotification($thisuser->ref_code, $sendMsg, $thisuser->playerId, $sendMsg, "Wallet Transaction");

                                                                $this->updatePoints($thisuser->id, 'Send money');

                                                                // Log::info("Congratulations!, ".$thisuser->name." ".$sendMsg);
                                                                // Log::info("Congratulations!, ".$this->name." ".$recMesg);

                                                                $this->slack("Congratulations!, " . $thisuser->name . " " . $sendMsg, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));
                                                            } else {

                                                                $response = 'Something went wrong';
                                                                $data = [];
                                                                $message = $response;
                                                                $status = 400;
                                                            }
                                                        }
                                                    }
                                                } else {
                                                    // Incorrect Transaction PIN
                                                    $response = 'Invalid transaction pin';
                                                    $data = [];
                                                    $message = $response;
                                                    $status = 400;
                                                }
                                            } else {
                                                // Redirect to route to setup transaction Pin
                                                $response = 'Kindly setup transaction pin in your profile settings';
                                                $data = [];
                                                $message = $response;
                                                $status = 400;
                                            }
                                        }
                                    }
                                } else {
                                    $response = $checking["response"];

                                    $data = [];
                                    $message = $response;
                                    $status = 400;
                                }
                            } else {
                                $response = 'Cannot find your account record, to continue payment.';

                                $data = [];
                                $message = $response;
                                $status = 400;
                            }
                        } else {

                            $error = implode(",", $validator->messages()->all());

                            $data = [];
                            $status = 400;
                            $message = $error;
                        }
                    } else {

                        if (isset($req->mode) && $req->mode == "test") {

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
                                'transaction_pin' => 'required',
                            ]);


                            if ($validator->passes()) {



                                if (isset($thisuser)) {


                                    $minBal = $this->minimumWithdrawal($thisuser->country);


                                    // Check Anon user existence
                                    $checkExist = User::where('email', $req->email)->first();

                                    if (isset($checkExist) == true) {
                                        $response = 'This user already exist on PaySprint.';
                                        $data = [];
                                        $message = $response;
                                        $status = 403;


                                        $resData = ['data' => $data, 'message' => $message, 'status' => $status, 'link' => URL('payment/sendmoney/' . $checkExist->ref_code . '?country=' . $thisuser->country)];

                                        return $this->returnJSON($resData, $status);
                                    } elseif ($thisuser->country != $req->country) {
                                        $response = 'International money transfer is not available at the moment';
                                        $data = [];
                                        $message = $response;
                                        $status = 403;

                                        $resData = ['data' => $data, 'message' => $message, 'status' => $status, 'link' => '#'];

                                        return $this->returnJSON($resData, $status);
                                    } else {

                                        if ($thisuser->approval < 2 && $thisuser->accountLevel <= 2) {
                                            $response = 'You cannot send money at the moment because your account is still on review.';
                                            $data = [];
                                            $message = $response;
                                            $status = 403;


                                            $resData = ['data' => $data, 'message' => $message, 'status' => $status];

                                            return $this->returnJSON($resData, $status);
                                        } elseif (($thisuser->wallet_balance - $minBal) <= $req->amount) {

                                            $response = "Your minimum wallet balance is " . $thisuser->currencyCode . ' ' . number_format($minBal, 2) . ". Please add money to continue transaction";
                                            $data = [];
                                            $message = $response;
                                            $status = 403;


                                            $resData = ['data' => $data, 'message' => $message, 'status' => $status];

                                            return $this->returnJSON($resData, $status);
                                        } else {

                                            $ref_code = mt_rand(0000000, 9999999);

                                            // Get all ref_codes
                                            $ref = User::all();

                                            if (count($ref) > 0) {
                                                foreach ($ref as $key => $value) {
                                                    if ($value->ref_code == $ref_code) {
                                                        $newRefcode = mt_rand(0000000, 9999999);
                                                    } else {
                                                        $newRefcode = $ref_code;
                                                    }
                                                }
                                            } else {
                                                $newRefcode = $ref_code;
                                            }

                                            $newcustomer = AnonUsers::where('email', $req->email)->first();


                                            $approve_commission = "No";

                                            $foreigncurrency = $this->getCountryCode($req->country);


                                            if ($thisuser->country != $req->country) {

                                                // Get Country Currency code


                                                // COnvert Currency for Wallet credit to receiver
                                                $amount = $this->convertCurrencyRate($foreigncurrency->currencyCode, $thisuser->currencyCode, $req->amount);
                                            } else {
                                                $amount = $req->amount;
                                            }


                                            // Getting the payer
                                            $userID = $thisuser->email;
                                            $payerID = $thisuser->ref_code;

                                            // $req->user_id is for the receiver::

                                            // Do Insert
                                            if ($req->service != "Others") {
                                                $service = $req->service;
                                            } else {
                                                $service = $req->purpose;
                                            }


                                            if ($req->amount > ($thisuser->wallet_balance - $minBal)) {
                                                $response = "Your minimum wallet balance is " . $thisuser->currencyCode . ' ' . number_format($minBal, 2) . ". Please add money to continue transaction";
                                                $data = [];
                                                $message = $response;
                                                $status = 400;
                                            } else {
                                                $statement_route = "wallet";


                                                $wallet_balance = $thisuser->wallet_balance - $req->amount;
                                                $withdrawal_per_day = $thisuser->withdrawal_per_day + $req->amount;
                                                $withdrawal_per_week = $thisuser->withdrawal_per_week + $withdrawal_per_day;
                                                $withdrawal_per_month = $thisuser->withdrawal_per_month + $withdrawal_per_week;
                                                $paymentToken = "wallet-" . date('dmY') . time();
                                                $paystatus = "Pending";
                                                $action = "Wallet debit";
                                                $requestReceive = 2;


                                                $insertPay = 1;

                                                if ($insertPay == 1) {


                                                    // Update Wallet
                                                    // User::where('api_token', $req->bearerToken())->update(['wallet_balance' => $wallet_balance]);


                                                    // Create or update Other party account
                                                    if (isset($newcustomer)) {

                                                        $ref_code = $newcustomer->ref_code;
                                                        // Update account
                                                        $newwalletBal = $newcustomer->wallet_balance + $amount;
                                                        // AnonUsers::where('email', $newcustomer->email)->update(['wallet_balance' => $newwalletBal]);
                                                    } else {
                                                        $ref_code = $newRefcode;
                                                        // Create account
                                                        $newwalletBal = $amount;
                                                        // AnonUsers::insert(['code' => $req->countryCode, 'ref_code' => $newRefcode, 'name' => $req->fname.' '.$req->lname, 'email' => $req->email, 'telephone' => $req->phone, 'country' => $req->country, 'wallet_balance' => $newwalletBal, 'accountType' => $thisuser->accountType]);
                                                    }


                                                    $getInviteType = AnonUsers::where('email', $req->email)->first();
                                                    // Send mail to both parties

                                                    // Notification to Sender
                                                    $this->name = $thisuser->name;
                                                    // $this->email = "bambo@vimfile.com";
                                                    $this->email = $thisuser->email;
                                                    $this->subject = $foreigncurrency->currencyCode . ' ' . number_format($req->amount, 2) . " has been sent through Text-To-Transfer Platform from your Wallet with PaySprint.";

                                                    $this->message = '<p>You have sent <strong>' . $foreigncurrency->currencyCode . ' ' . number_format($req->amount, 2) . '</strong> to ' . $req->fname . ' ' . $req->lname . '. You now have <strong>' . $foreigncurrency->currencyCode . ' ' . number_format($wallet_balance, 2) . '</strong> balance in your account</p>';

                                                    $sendMsg = 'You have sent ' . $foreigncurrency->currencyCode . ' ' . number_format($req->amount, 2) . ' to ' . $req->fname . ' ' . $req->lname . '. You now have ' . $foreigncurrency->currencyCode . ' ' . number_format($wallet_balance, 2) . ' balance in your account';

                                                    $userPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

                                                    if (isset($userPhone)) {

                                                        $sendPhone = $thisuser->telephone;
                                                    } else {
                                                        $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
                                                    }


                                                    // $this->sendEmail($this->email, "Fund remittance");

                                                    // $this->sendMessage($sendMsg, $sendPhone);



                                                    // Notification for receiver
                                                    $this->name = $req->fname . ' ' . $req->lname;
                                                    // $this->to = "bambo@vimfile.com";
                                                    $this->to = $req->email;
                                                    $this->subject = $thisuser->name . " has sent you " . $foreigncurrency->currencyCode . ' ' . number_format($amount, 2) . " on PaySprint";


                                                    if ($thisuser->accountType == "Individual" || $getInviteType->accountType == "Individual") {
                                                        $route = route('register', 'user=' . $ref_code);
                                                    } else {
                                                        $route = route('AdminRegister', 'user=' . $ref_code);
                                                    }

                                                    $this->message = '<p>You have received <strong>' . $foreigncurrency->currencyCode . ' ' . number_format($amount, 2) . '</strong> from ' . $thisuser->name . '. You now have <strong>' . $foreigncurrency->currencyCode . ' ' . number_format($newwalletBal, 2) . '</strong> balance in your account</p><hr><p>To access your funds, please download PaySprint App on Google Play Store or App Store or Sign up for FREE </p><p><a href="' . $route . '">' . $route . '</a></p>';

                                                    $recMesg = 'You have received ' . $foreigncurrency->currencyCode . ' ' . number_format($amount, 2) . ' from ' . $thisuser->name . '. You now have ' . $foreigncurrency->currencyCode . ' ' . number_format($newwalletBal, 2) . ' balance in your account. To access your funds, please download PaySprint App on Google Play Store or App Store or Sign up for FREE ' . $route;
                                                    $recPhone = "+" . $req->countryCode . $req->phone;


                                                    // $this->sendEmail($this->to, "Fund remittance");

                                                    // $this->sendMessage($recMesg, $recPhone);





                                                    // Insert Statement
                                                    $activity = $req->payment_method . " transfer of " . $thisuser->currencyCode . ' ' . number_format($req->amount, 2) . " to " . $req->fname . ' ' . $req->lname . " for " . $service;
                                                    $credit = 0;
                                                    // $debit = $req->conversionamount + $req->commissiondeduct;
                                                    $debit = $amount;
                                                    $reference_code = $paymentToken;
                                                    $balance = 0;
                                                    $trans_date = date('Y-m-d');

                                                    $regards = $ref_code;

                                                    // Senders statement
                                                    $this->insStatement($userID, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $paystatus, $action, $regards, 1, $statement_route, 'on', $thisuser->country);

                                                    // Receiver Statement
                                                    $this->insStatement($req->email, $reference_code, "Received " . $foreigncurrency->currencyCode . '' . $amount . " in wallet for " . $service . " from " . $thisuser->name, $amount, 0, $balance, $trans_date, $paystatus, "Wallet credit", $ref_code, 1, $statement_route, 'on', $req->country);



                                                    $response = 'Money sent successfully';

                                                    // $data = $insertPay;
                                                    $data = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol')->where('api_token', $req->bearerToken())->first();
                                                    $status = 200;
                                                    $message = $response;


                                                    // $this->createNotification($thisuser->ref_code, $sendMsg);

                                                    // $this->createNotification($ref_code, $recMesg);

                                                    // Log::info("Congratulations!, ".$thisuser->name." ".$sendMsg.". This is a test environment");
                                                    // Log::info("Congratulations!, ".$this->name." ".$recMesg.". This is a test environment");

                                                    $this->slack("Congratulations!, " . $thisuser->name . " " . $sendMsg . ". This is a test environment", $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));

                                                    $this->slack("Congratulations!, " . $this->name . " " . $recMesg . ". This is a test environment", $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));
                                                } else {

                                                    $response = 'Something went wrong';
                                                    $data = [];
                                                    $message = $response;
                                                    $status = 400;
                                                }
                                            }
                                        }
                                    }
                                } else {
                                    $response = 'Cannot find your account record, to continue payment.';

                                    $data = [];
                                    $message = $response;
                                    $status = 400;
                                }
                            } else {

                                $error = implode(",", $validator->messages()->all());

                                $data = [];
                                $status = 400;
                                $message = $error;
                            }
                        } else {
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
                                'transaction_pin' => 'required',
                            ]);


                            if ($validator->passes()) {

                                // Get User Info
                                $thisuser = User::where('api_token', $req->bearerToken())->first();

                                $imtCountry = AllCountries::where('name', $req->country)->first();

                                if (isset($thisuser)) {


                                    // Do IDV

                                    $checking = $this->checkUsersPassAccount($thisuser->id);


                                    if (in_array("send money", $checking['access'])) {

                                        $minBal = $this->minimumWithdrawal($thisuser->country);

                                        // Check Anon user existence
                                        $checkExist = User::where('email', $req->email)->first();

                                        if (isset($req->paymentWallet) && $req->paymentWallet === "fx_wallet") {

                                            // Get wallet balance for the selected wallet...

                                            $fxCurrency = new CurrencyFxController();

                                            $walletResult = $fxCurrency->getFxWalletsFromController($thisuser->id, $req->paymentFxWallet);


                                            // Check for wallet Balance...
                                            if ((float)$walletResult->wallet_balance < (float)$req->amount) {

                                                $response = "Insufficient PaySprint FX Wallet balance";
                                                $data = [];
                                                $message = $response;
                                                $status = 400;


                                                $resData = ['data' => $data, 'message' => $message, 'status' => $status];

                                                return $this->returnJSON($resData, $status);
                                            }


                                            // Check Transaction PIN
                                            if ($thisuser->transaction_pin != null) {

                                                if (Hash::check($req->transaction_pin, $thisuser->transaction_pin)) {

                                                    if ($thisuser->approval < 2 && $thisuser->accountLevel <= 2) {
                                                        $response = 'You cannot send money at the moment because your account is still on review.';
                                                        $data = [];
                                                        $message = $response;
                                                        $status = 403;


                                                        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

                                                        return $this->returnJSON($resData, $status);
                                                    } else {

                                                        $ref_code = mt_rand(00000, 99999);

                                                        // Get all ref_codes
                                                        $ref = User::all();

                                                        if (count($ref) > 0) {
                                                            foreach ($ref as $key => $value) {
                                                                if ($value->ref_code == $ref_code) {
                                                                    $newRefcode = mt_rand(000000, 999999);
                                                                } else {
                                                                    $newRefcode = $ref_code;
                                                                }
                                                            }
                                                        } else {
                                                            $newRefcode = $ref_code;
                                                        }

                                                        $newcustomer = AnonUsers::where('email', $req->email)->first();


                                                        $approve_commission = "No";

                                                        $foreigncurrency = $this->getCountryCode($req->country);


                                                        if ($walletResult->country != $req->country) {

                                                            // Get Country Currency code


                                                            // COnvert Currency for Wallet credit to receiver
                                                            $amount = $this->convertCurrencyRate($foreigncurrency->currencyCode, $walletResult->currencyCode, $req->amount);
                                                        } else {
                                                            $amount = $req->amount;
                                                        }


                                                        // Getting the payer
                                                        $userID = $thisuser->email;
                                                        $payerID = $thisuser->ref_code;

                                                        // $req->user_id is for the receiver::

                                                        // Do Insert
                                                        if ($req->service != "Others") {
                                                            $service = $req->service;
                                                        } else {
                                                            $service = $req->purpose;
                                                        }

                                                        $statement_route = "wallet";


                                                        $wallet_balance = $walletResult->wallet_balance - $req->amount;
                                                        $paymentToken = "es-wallet-" . date('dmY') . time();
                                                        $paystatus = "Delivered";
                                                        $action = "Escrow Wallet debit";
                                                        $requestReceive = 2;


                                                        $insertPay = OrganizationPay::insert(['transactionid' => $paymentToken, 'coy_id' => $newRefcode, 'user_id' => $userID, 'purpose' => $service, 'amount' => $foreigncurrency->currencyCode . ' ' . $req->amount, 'withdraws' => $foreigncurrency->currencyCode . ' ' . $req->amount, 'state' => 1, 'payer_id' => $payerID, 'amount_to_send' => $amount, 'commission' => $req->commissiondeduct, 'approve_commission' => $approve_commission, 'amountindollars' => $foreigncurrency->currencyCode . ' ' . $amount, 'request_receive' => $requestReceive]);

                                                        if ($insertPay == true) {


                                                            EscrowAccount::where('user_id', $thisuser->id)->where('currencyCode', $walletResult->currencyCode)->update(['wallet_balance' => $wallet_balance]);


                                                            // Create or update Other party account
                                                            if (isset($newcustomer)) {

                                                                $ref_code = $newcustomer->ref_code;
                                                                // Update account
                                                                $newwalletBal = $newcustomer->wallet_balance + $amount;
                                                                AnonUsers::where('email', $newcustomer->email)->update(['wallet_balance' => $newwalletBal]);
                                                            } else {
                                                                $ref_code = $newRefcode;
                                                                // Create account
                                                                $newwalletBal = $amount;
                                                                AnonUsers::insert(['code' => $req->countryCode, 'ref_code' => $newRefcode, 'name' => $req->fname . ' ' . $req->lname, 'email' => $req->email, 'telephone' => $req->phone, 'country' => $req->country, 'wallet_balance' => $newwalletBal, 'accountType' => $thisuser->accountType]);
                                                            }


                                                            $getInviteType = AnonUsers::where('email', $req->email)->first();
                                                            // Send mail to both parties

                                                            // Notification to Sender
                                                            $this->name = $thisuser->name;
                                                            // $this->email = "bambo@vimfile.com";

                                                            $this->email = $thisuser->email;
                                                            $this->subject = $walletResult->currencyCode . ' ' . number_format($req->amount, 2) . " has been sent through Text-To-Transfer Platform from your Wallet with PaySprint.";

                                                            $this->message = '<p>You have sent <strong>' . $walletResult->currencyCode . ' ' . number_format($req->amount, 2) . '</strong> to ' . $req->fname . ' ' . $req->lname . '. You now have <strong>' . $walletResult->currencyCode . ' ' . number_format($wallet_balance, 2) . '</strong> balance in your ' . $walletResult->currencyCode . ' FX wallet account</p>';

                                                            $sendMsg = 'You have sent ' . $walletResult->currencyCode . ' ' . number_format($req->amount, 2) . ' to ' . $req->fname . ' ' . $req->lname . '. You now have ' . $walletResult->currencyCode . ' ' . number_format($wallet_balance, 2) . ' balance in your ' . $walletResult->currencyCode . ' FX wallet account';

                                                            $userPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

                                                            if (isset($userPhone)) {

                                                                $sendPhone = $thisuser->telephone;
                                                            } else {
                                                                $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
                                                            }


                                                            $this->sendEmail($this->email, "Fund remittance");

                                                            if ($thisuser->country == "Nigeria") {

                                                                $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                                                                $this->sendSms($sendMsg, $correctPhone);
                                                            } else {
                                                                $this->sendMessage($sendMsg, $sendPhone);
                                                            }





                                                            // Notification for receiver
                                                            $this->name = $req->fname . ' ' . $req->lname;
                                                            // $this->to = "bambo@vimfile.com";
                                                            $this->to = $req->email;
                                                            $this->subject = $thisuser->name . " has sent you " . $foreigncurrency->currencyCode . ' ' . number_format($amount, 2) . " on PaySprint";


                                                            if ($thisuser->accountType == "Individual" || $getInviteType->accountType == "Individual") {
                                                                $route = route('register', 'user=' . $ref_code);
                                                            } else {
                                                                $route = route('AdminRegister', 'user=' . $ref_code);
                                                            }

                                                            $this->message = '<p>You have received <strong>' . $foreigncurrency->currencyCode . ' ' . number_format($amount, 2) . '</strong> from ' . $thisuser->name . '. You now have <strong>' . $foreigncurrency->currencyCode . ' ' . number_format($newwalletBal, 2) . '</strong> balance in your account</p><hr><p>To access your funds, please download PaySprint App on Google Play Store or App Store or Sign up for FREE </p><p><a href="' . $route . '">' . $route . '</a></p>';

                                                            $recMesg = 'You have received ' . $foreigncurrency->currencyCode . ' ' . number_format($amount, 2) . ' from ' . $thisuser->name . '. You now have ' . $foreigncurrency->currencyCode . ' ' . number_format($newwalletBal, 2) . ' balance in your account. To access your funds, please download PaySprint App on Google Play Store or App Store or Sign up for FREE ' . $route;

                                                            $recPhone = "+" . $req->countryCode . $req->phone;


                                                            $this->sendEmail($this->to, "Fund remittance");



                                                            if ($req->country == "Nigeria") {

                                                                $correctPhone = preg_replace("/[^0-9]/", "", $recPhone);
                                                                $this->sendSms($recMesg, $correctPhone);
                                                            } else {
                                                                $this->sendMessage($recMesg, $recPhone);
                                                            }





                                                            // Insert Statement
                                                            $activity = $req->payment_method . " transfer of " . $thisuser->currencyCode . ' ' . number_format($req->amount, 2) . " to " . $req->fname . ' ' . $req->lname . " for " . $service;
                                                            $credit = 0;
                                                            // $debit = $req->conversionamount + $req->commissiondeduct;
                                                            $debit = $req->amount;
                                                            $reference_code = $paymentToken;
                                                            $balance = 0;
                                                            $trans_date = date('Y-m-d');

                                                            $regards = $ref_code;

                                                            // Senders statement
                                                            $this->insStatement($userID, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $paystatus, $action, $regards, 1, $statement_route, 'on', $thisuser->country);

                                                            $fxCurrency->insFXStatement($walletResult->escrow_id, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $paystatus, $action, $regards, 1, $statement_route, 'on', $thisuser->country, 'confirmed');

                                                            // Receiver Statement
                                                            $this->insStatement($req->email, $reference_code, "Received " . $foreigncurrency->currencyCode . '' . $amount . " in wallet for " . $service . " from " . $thisuser->name, $amount, 0, $balance, $trans_date, $paystatus, "Wallet credit", $ref_code, 1, $statement_route, 'on', $req->country);



                                                            $response = 'Money sent successfully';

                                                            // $data = $insertPay;
                                                            $data = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol')->where('api_token', $req->bearerToken())->first();
                                                            $status = 200;
                                                            $message = $response;


                                                            $this->createNotification($thisuser->ref_code, $sendMsg, $thisuser->playerId, $sendMsg, "Wallet Transaction");

                                                            $this->createNotification($ref_code, $recMesg);

                                                            $this->updatePoints($thisuser->id, 'Send money');

                                                            // Log::info("Congratulations!, ".$thisuser->name." ".$sendMsg);
                                                            // Log::info("Congratulations!, ".$this->name." ".$recMesg);

                                                            $this->slack("Congratulations!, " . $thisuser->name . " " . $sendMsg, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));
                                                            $this->slack("Congratulations!, " . $this->name . " " . $recMesg, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));
                                                        } else {

                                                            $response = 'Something went wrong';
                                                            $data = [];
                                                            $message = $response;
                                                            $status = 400;
                                                        }
                                                    }
                                                } else {
                                                    // Incorrect Transaction PIN
                                                    $response = 'Invalid transaction pin';
                                                    $data = [];
                                                    $message = $response;
                                                    $status = 400;
                                                }
                                            } else {
                                                // Redirect to route to setup transaction Pin
                                                $response = 'Kindly setup transaction pin in your profile settings';
                                                $data = [];
                                                $message = $response;
                                                $status = 400;
                                            }
                                        } else {

                                            if (isset($imtCountry) && $imtCountry->imt == "false" && $req->country != $thisuser->country || isset($imtCountry) && $imtCountry->outbound == "false" && $req->country != $thisuser->country) {

                                                $response = 'International money transfer is not yet available to ' . $imtCountry->name;
                                                $data = [];
                                                $message = $response;
                                                $status = 403;

                                                $resData = ['data' => $data, 'message' => $message, 'status' => $status, 'link' => '#'];
                                                return $this->returnJSON($resData, $status);
                                            } elseif (($thisuser->wallet_balance - $minBal) <= $req->amount) {

                                                $response = "Your minimum wallet balance is " . $thisuser->currencyCode . ' ' . number_format($minBal, 2) . ". Please add money to continue transaction";
                                                $data = [];
                                                $message = $response;
                                                $status = 403;


                                                $resData = ['data' => $data, 'message' => $message, 'status' => $status];

                                                return $this->returnJSON($resData, $status);
                                            } else {
                                                // Check Transaction PIN
                                                if ($thisuser->transaction_pin != null) {

                                                    if (Hash::check($req->transaction_pin, $thisuser->transaction_pin)) {

                                                        if ($thisuser->approval < 2 && $thisuser->accountLevel <= 2) {
                                                            $response = 'You cannot send money at the moment because your account is still on review.';
                                                            $data = [];
                                                            $message = $response;
                                                            $status = 403;


                                                            $resData = ['data' => $data, 'message' => $message, 'status' => $status];

                                                            return $this->returnJSON($resData, $status);
                                                        } else {

                                                            $ref_code = mt_rand(00000, 99999);

                                                            // Get all ref_codes
                                                            $ref = User::all();

                                                            if (count($ref) > 0) {
                                                                foreach ($ref as $key => $value) {
                                                                    if ($value->ref_code == $ref_code) {
                                                                        $newRefcode = mt_rand(000000, 999999);
                                                                    } else {
                                                                        $newRefcode = $ref_code;
                                                                    }
                                                                }
                                                            } else {
                                                                $newRefcode = $ref_code;
                                                            }

                                                            $newcustomer = AnonUsers::where('email', $req->email)->first();


                                                            $approve_commission = "No";

                                                            $foreigncurrency = $this->getCountryCode($req->country);


                                                            if ($thisuser->country != $req->country) {

                                                                // Get Country Currency code


                                                                // COnvert Currency for Wallet credit to receiver
                                                                $amount = $this->convertCurrencyRate($foreigncurrency->currencyCode, $thisuser->currencyCode, $req->amount);
                                                            } else {
                                                                $amount = $req->amount;
                                                            }


                                                            // Getting the payer
                                                            $userID = $thisuser->email;
                                                            $payerID = $thisuser->ref_code;

                                                            // $req->user_id is for the receiver::

                                                            // Do Insert
                                                            if ($req->service != "Others") {
                                                                $service = $req->service;
                                                            } else {
                                                                $service = $req->purpose;
                                                            }


                                                            if ($req->amount > ($thisuser->wallet_balance - $minBal)) {
                                                                $response = "Your minimum wallet balance is " . $thisuser->currencyCode . ' ' . number_format($minBal, 2) . ". Please add money to continue transaction";
                                                                $data = [];
                                                                $message = $response;
                                                                $status = 400;
                                                            } else {
                                                                $statement_route = "wallet";


                                                                $wallet_balance = $thisuser->wallet_balance - $req->amount;
                                                                $withdrawal_per_day = $thisuser->withdrawal_per_day + $req->amount;
                                                                $withdrawal_per_week = $thisuser->withdrawal_per_week + $withdrawal_per_day;
                                                                $withdrawal_per_month = $thisuser->withdrawal_per_month + $withdrawal_per_week;
                                                                $paymentToken = "wallet-" . date('dmY') . time();
                                                                $paystatus = "Pending";
                                                                $action = "Wallet debit";
                                                                $requestReceive = 2;


                                                                $insertPay = OrganizationPay::insert(['transactionid' => $paymentToken, 'coy_id' => $newRefcode, 'user_id' => $userID, 'purpose' => $service, 'amount' => $foreigncurrency->currencyCode . ' ' . $req->amount, 'withdraws' => $foreigncurrency->currencyCode . ' ' . $req->amount, 'state' => 1, 'payer_id' => $payerID, 'amount_to_send' => $amount, 'commission' => $req->commissiondeduct, 'approve_commission' => $approve_commission, 'amountindollars' => $foreigncurrency->currencyCode . ' ' . $amount, 'request_receive' => $requestReceive]);

                                                                if ($insertPay == true) {


                                                                    // Update Wallet
                                                                    User::where('api_token', $req->bearerToken())->update([
                                                                        'wallet_balance' => $wallet_balance,
                                                                        'withdrawal_per_day' => $withdrawal_per_day,
                                                                        'withdrawal_per_week' => $withdrawal_per_week,
                                                                        'withdrawal_per_month' => $withdrawal_per_month
                                                                    ]);


                                                                    // Create or update Other party account
                                                                    if (isset($newcustomer)) {

                                                                        $ref_code = $newcustomer->ref_code;
                                                                        // Update account
                                                                        $newwalletBal = $newcustomer->wallet_balance + $amount;
                                                                        AnonUsers::where('email', $newcustomer->email)->update(['wallet_balance' => $newwalletBal]);
                                                                    } else {
                                                                        $ref_code = $newRefcode;
                                                                        // Create account
                                                                        $newwalletBal = $amount;
                                                                        AnonUsers::insert(['code' => $req->countryCode, 'ref_code' => $newRefcode, 'name' => $req->fname . ' ' . $req->lname, 'email' => $req->email, 'telephone' => $req->phone, 'country' => $req->country, 'wallet_balance' => $newwalletBal, 'accountType' => $thisuser->accountType]);
                                                                    }


                                                                    $getInviteType = AnonUsers::where('email', $req->email)->first();
                                                                    // Send mail to both parties

                                                                    // Notification to Sender
                                                                    $this->name = $thisuser->name;
                                                                    // $this->email = "bambo@vimfile.com";
                                                                    $this->email = $thisuser->email;
                                                                    $this->subject = $thisuser->currencyCode . ' ' . number_format($req->amount, 2) . " has been sent through Text-To-Transfer Platform from your Wallet with PaySprint.";

                                                                    $this->message = '<p>You have sent <strong>' . $thisuser->currencyCode . ' ' . number_format($req->amount, 2) . '</strong> to ' . $req->fname . ' ' . $req->lname . '. You now have <strong>' . $thisuser->currencyCode . ' ' . number_format($wallet_balance, 2) . '</strong> balance in your account</p>';

                                                                    $sendMsg = 'You have sent ' . $thisuser->currencyCode . ' ' . number_format($req->amount, 2) . ' to ' . $req->fname . ' ' . $req->lname . '. You now have ' . $thisuser->currencyCode . ' ' . number_format($wallet_balance, 2) . ' balance in your account';

                                                                    $userPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

                                                                    if (isset($userPhone)) {

                                                                        $sendPhone = $thisuser->telephone;
                                                                    } else {
                                                                        $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
                                                                    }


                                                                    $this->sendEmail($this->email, "Fund remittance");

                                                                    if ($thisuser->country == "Nigeria") {

                                                                        $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                                                                        $this->sendSms($sendMsg, $correctPhone);
                                                                    } else {
                                                                        $this->sendMessage($sendMsg, $sendPhone);
                                                                    }





                                                                    // Notification for receiver
                                                                    $this->name = $req->fname . ' ' . $req->lname;
                                                                    // $this->to = "bambo@vimfile.com";
                                                                    $this->to = $req->email;
                                                                    $this->subject = $thisuser->name . " has sent you " . $foreigncurrency->currencyCode . ' ' . number_format($amount, 2) . " on PaySprint";


                                                                    if ($thisuser->accountType == "Individual" || $getInviteType->accountType == "Individual") {
                                                                        $route = route('register', 'user=' . $ref_code);
                                                                    } else {
                                                                        $route = route('AdminRegister', 'user=' . $ref_code);
                                                                    }

                                                                    $this->message = '<p>You have received <strong>' . $foreigncurrency->currencyCode . ' ' . number_format($amount, 2) . '</strong> from ' . $thisuser->name . '. You now have <strong>' . $foreigncurrency->currencyCode . ' ' . number_format($newwalletBal, 2) . '</strong> balance in your account</p><hr><p>To access your funds, please download PaySprint App on Google Play Store or App Store or Sign up for FREE </p><p><a href="' . $route . '">' . $route . '</a></p>';

                                                                    $recMesg = 'You have received ' . $foreigncurrency->currencyCode . ' ' . number_format($amount, 2) . ' from ' . $thisuser->name . '. You now have ' . $foreigncurrency->currencyCode . ' ' . number_format($newwalletBal, 2) . ' balance in your account. To access your funds, please download PaySprint App on Google Play Store or App Store or Sign up for FREE ' . $route;

                                                                    $recPhone = "+" . $req->countryCode . $req->phone;


                                                                    $this->sendEmail($this->to, "Fund remittance");



                                                                    if ($req->country == "Nigeria") {

                                                                        $correctPhone = preg_replace("/[^0-9]/", "", $recPhone);
                                                                        $this->sendSms($recMesg, $correctPhone);
                                                                    } else {
                                                                        $this->sendMessage($recMesg, $recPhone);
                                                                    }





                                                                    // Insert Statement
                                                                    $activity = $req->payment_method . " transfer of " . $thisuser->currencyCode . ' ' . number_format($req->amount, 2) . " to " . $req->fname . ' ' . $req->lname . " for " . $service;
                                                                    $credit = 0;
                                                                    // $debit = $req->conversionamount + $req->commissiondeduct;
                                                                    $debit = $req->amount;
                                                                    $reference_code = $paymentToken;
                                                                    $balance = 0;
                                                                    $trans_date = date('Y-m-d');

                                                                    $regards = $ref_code;

                                                                    // Senders statement
                                                                    $this->insStatement($userID, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $paystatus, $action, $regards, 1, $statement_route, 'on', $thisuser->country);

                                                                    // Receiver Statement
                                                                    $this->insStatement($req->email, $reference_code, "Received " . $foreigncurrency->currencyCode . '' . $amount . " in wallet for " . $service . " from " . $thisuser->name, $amount, 0, $balance, $trans_date, $paystatus, "Wallet credit", $ref_code, 1, $statement_route, 'on', $req->country);



                                                                    $response = 'Money sent successfully';

                                                                    // $data = $insertPay;
                                                                    $data = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol')->where('api_token', $req->bearerToken())->first();
                                                                    $status = 200;
                                                                    $message = $response;


                                                                    $this->createNotification($thisuser->ref_code, $sendMsg, $thisuser->playerId, $sendMsg, "Wallet Transaction");

                                                                    $this->createNotification($ref_code, $recMesg);

                                                                    $this->updatePoints($thisuser->id, 'Send money');

                                                                    // Log::info("Congratulations!, ".$thisuser->name." ".$sendMsg);
                                                                    // Log::info("Congratulations!, ".$this->name." ".$recMesg);

                                                                    $this->slack("Congratulations!, " . $thisuser->name . " " . $sendMsg, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));
                                                                    $this->slack("Congratulations!, " . $this->name . " " . $recMesg, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));
                                                                } else {

                                                                    $response = 'Something went wrong';
                                                                    $data = [];
                                                                    $message = $response;
                                                                    $status = 400;
                                                                }
                                                            }
                                                        }
                                                    } else {
                                                        // Incorrect Transaction PIN
                                                        $response = 'Invalid transaction pin';
                                                        $data = [];
                                                        $message = $response;
                                                        $status = 400;
                                                    }
                                                } else {
                                                    // Redirect to route to setup transaction Pin
                                                    $response = 'Kindly setup transaction pin in your profile settings';
                                                    $data = [];
                                                    $message = $response;
                                                    $status = 400;
                                                }
                                            }
                                        }
                                    } else {
                                        $response = $checking["response"];

                                        $data = [];
                                        $message = $response;
                                        $status = 400;
                                    }
                                } else {
                                    $response = 'Cannot find your account record, to continue payment.';

                                    $data = [];
                                    $message = $response;
                                    $status = 400;
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
            } catch (\Throwable $th) {

                $data = [];
                $status = 400;
                $message = $th->getMessage();
            }



            $resData = ['data' => $data, 'message' => $message, 'status' => $status];


            return $this->returnJSON($resData, $status);
        }
    }


    public function convertCurrencyRate($foreigncurrency, $localcurrency, $amount)
    {


        // Get Markup
        $markuppercent = $this->markupPercentage();

        $markValue = (1 + ($markuppercent[0]->percentage / 100));



        $currency = 'USD' . $foreigncurrency;
        $amount = $amount;
        $localCurrency = 'USD' . $localcurrency;

        Log::info("Foreign: " . $currency . " | Local Currency: " . $localCurrency);

        $access_key = '6173fa628b16d8ce1e0db5cfa25092ac';

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://api.currencylayer.com/live?access_key=' . $access_key,
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




        if ($result->success == true) {


            if ($localCurrency === 'USDUSD') {
                $localConv = 1;
            } else {
                $localConv = $result->quotes->$localCurrency *  $markValue;
            }


            if ($localCurrency === $currency) {
                $convertLocal = $amount / $localConv;
            } elseif ($localCurrency !== 'USDUSD' && $currency !== 'USDUSD') {
                $convertLocal = ($amount / $localConv) * $markValue;
            } else {
                $convertLocal = $amount / $localConv;
            }


            // Conversion Rate USD to Local currency
            // $convertLocal = ($amount / $result->quotes->$localCurrency) * $markValue;

            $convRate = ($currency !== 'USDUSD' ? ($result->quotes->$currency *  $markValue) : 1) * $convertLocal;
        } else {
            $convRate = "Sorry we can not process your transaction this time, try again later!.";
        }

        $this->slack($convRate, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));


        // dd($convRate);

        return $convRate;
    }


    public function insStatement($email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, $state, $statement_route, $auto_deposit, $country)
    {
        Statement::insert(['user_id' => $email, 'reference_code' => $reference_code, 'activity' => $activity, 'credit' => $credit, 'debit' => $debit, 'balance' => $balance, 'trans_date' => $trans_date, 'status' => $status, 'action' => $action, 'regards' => $regards, 'state' => $state, 'statement_route' => $statement_route, 'auto_deposit' => $auto_deposit, 'country' => $country]);
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
            $objDemo->to = $this->to;
            $objDemo->subject = $this->subject;
            $objDemo->message = $this->message;
        }

        Mail::to($objDemoa)
            ->send(new sendEmail($objDemo));
    }


    public function monerisWalletProcess($bearer, $card_id, $dollaramount, $type, $description, $mode)
    {

        $thisuser = User::where('api_token', $bearer)->first();


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








        // Get Card Details
        $cardDetails = AddCard::where('id', $card_id)->where('user_id', $thisuser->id)->first();


        $type = $type;
        $cust_id = $thisuser->ref_code;
        $order_id = 'ord-' . date("dmy-Gis");
        // $amount= number_format($dollaramount, 2);
        $amount = $dollaramount;



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
}
