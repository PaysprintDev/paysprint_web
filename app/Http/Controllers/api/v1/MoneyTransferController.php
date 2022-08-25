<?php

namespace App\Http\Controllers\api\v1;

use App\AllCountries;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Hash;

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
use App\FxStatement as FxStatement;

use App\ReceivePay as ReceivePay;

use App\TransactionCost as TransactionCost;

use App\CardRequest as CardRequest;
use App\EscrowAccount;
use App\MarketPlace as AppMarketPlace;
use App\RequestRefund as RequestRefund;

use App\Traits\Xwireless;
use App\Traits\PaymentGateway;
use App\Traits\PaysprintPoint;
use App\Traits\IDVCheck;
use Twilio\Rest\Preview\Marketplace;

class MoneyTransferController extends Controller
{

    use Xwireless, PaymentGateway, PaysprintPoint, IDVCheck;

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





    public function getTransactionStructure()
    {
        $resp = TransactionCost::select('id', 'structure', 'method', 'country')->get();

        $data = $resp;
        $status = 200;

        $resData = ['data' => $data, 'message' => 'success', 'status' => $status];

        return $this->returnJSON($resData, $status);
    }

    public function commissionFee(Request $req)
    {

        try {

            $thisuser = User::where('api_token', $req->bearerToken())->first();

            $amount = $req->amount;
            // Get Commission

            if ($req->method == "Debit Card/Bank") {
                $method = "Debit Card";
            } elseif ($req->method == "CC/Bank") {
                $method = "Bank Account";
            } else {
                $method = "Debit Card";
            }

            Log::info("Structure: " . $req->structure . " \nMethod: " . $method . " \nCountry: " . $thisuser->country);

            $data = TransactionCost::where('structure', $req->structure)->where('method', $method)->where('country', $thisuser->country)->first();

            if (isset($data) == true) {

                if ($thisuser->country == "Nigeria" && $req->amount <= 2500) {
                    $x = ($data->variable / 100) * $req->amount;

                    $y = 0 + $x;

                    $collection = $y;
                } else {

                    if ($thisuser->country == "Canada") {

                        $x = ($data->variable / 100) * $req->amount;

                        $y = $data->fixed + $x;

                        $collection = $y;
                    } else {
                        $data = TransactionCost::where('structure', $req->structure)->where('method', "Debit Card")->where('country', $thisuser->country)->first();

                        if (isset($data)) {
                            $x = ($data->variable / 100) * $req->amount;

                            $y = $data->fixed + $x;

                            $collection = $y;
                        } else {
                            $x = (3.00 / 100) * $req->amount;

                            $y = 0.33 + $x;

                            $collection = $y;
                        }
                    }
                }
            } else {

                $data = TransactionCost::where('structure', $req->structure)->where('method', $method)->first();

                $x = ($data->variable / 100) * $req->amount;

                $y = $data->fixed + $x;

                $collection = $y;
            }

            $status = 200;
            $message = "success";
        } catch (\Throwable $th) {
            $collection = [];
            $message = "Oops!. Please ensure you have set up your card and bank details";
            $status = 400;
        }


        $resData = ['data' => $collection, 'message' => $message, 'status' => $status];



        return $this->returnJSON($resData, $status);
    }


    public function requestPrepaidCard(Request $req)
    {

        $thisuser = User::where('api_token', $req->bearerToken())->first();

        if (env('APP_ENV') == "local") {
            $url = "http://localhost:4000/api/v1/paysprint/requestcard";
        } else {
            $url = "https://exbc.ca/api/v1/paysprint/requestcard";
        }

        if ($thisuser->country == "Canada") {
            if ($req->amount > $thisuser->wallet_balance) {

                $data = [];
                $message = "Insufficient wallet balance";
                $status = 400;


                $resData = ['data' => $data, 'message' => $message, 'status' => $status];
            } else {

                $data = $req->all();

                $token = "base64:HgMO6FDHGziGl01OuLH9mh7CeP095shB6uuDUUClhks=";


                $response = $this->curlPost($url, $data, $token);

                if ($response->status == 200) {
                    $resData = $this->debitWalletForCard($req->ref_code, $req->card_provider);
                    $status = $resData['status'];
                    $data = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol', 'cardRequest')->where('api_token', $req->bearerToken())->first();

                    User::where('api_token', $req->bearerToken())->update(['cardRequest' => 2]);

                    $message = $response->message;
                    $resData = ['data' => $data, 'message' => $message, 'status' => $status];
                } else {
                    $status = $response->status;
                    $data = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol', 'cardRequest')->where('api_token', $req->bearerToken())->first();

                    User::where('api_token', $req->bearerToken())->update(['cardRequest' => 2]);

                    $message = $response->message;
                    $resData = ['data' => $data, 'message' => $message, 'status' => $status];
                }


                Log::info("Request for Exbc prepaid card  by " . $thisuser->name);

                $this->createNotification($thisuser->ref_code, "Hello " . strtoupper($thisuser->name) . ", " . $message);
            }
        } else {

            $data = [];
            $message = "Prepaid Card Request not yet available for " . $thisuser->country;
            $status = 400;


            $resData = ['data' => $data, 'message' => $message, 'status' => $status];
        }




        return $this->returnJSON($resData, $status);
    }

    public function requestForRefund(Request $req)
    {

        $validator = Validator::make($req->all(), [
            'transaction_id' => 'required|string',
            'reason' => 'required|string',
        ]);

        if ($validator->passes()) {
            $thisuser = User::where('api_token', $req->bearerToken())->first();

            // Check if invoice
            $getStatement = Statement::where('reference_code', $req->transaction_id)->where('activity', 'LIKE', '%Payment for %')->where('activity', 'LIKE', '%Invoice on %')->first();

            if (isset($getStatement) == true) {
                $error = "You cannot request for refund on this transaction. Kindly contact your merchant for refund";

                $data = [];
                $status = 400;
                $message = $error;
            } else {
                // Check if its a fund debit
                $getStatement = Statement::where('reference_code', $req->transaction_id)->where('credit', '!=', '0')->where('status', 'Delivered')->first();

                if (isset($getStatement) == true) {
                    $error = "You can request for refund of debit transfer when its a pending deposit or not accepted by the receiver. Thanks";

                    $data = [];
                    $status = 400;
                    $message = $error;
                } else {

                    // check if its monthly maintenance

                    $getStatement = Statement::where('reference_code', $req->transaction_id)->where('activity', 'LIKE', '%Monthly maintenance fee %')->first();



                    if (isset($getStatement) == true) {
                        $error = "This is a monthly maintenance charge fee. Request for refund not allowed on this transaction";

                        $data = [];
                        $status = 400;
                        $message = $error;
                    } else {

                        // Then check if money is accepted
                        $getStatement = Statement::where('reference_code', $req->transaction_id)->where('auto_deposit', 'on')->where('status', 'Delivered')->first();

                        if (isset($getStatement) == true) {
                            $error = "You cannot request for refund on this transaction. Kindly contact receiver for refund";

                            $data = [];
                            $status = 400;
                            $message = $error;
                        } else {

                            $getStatement = Statement::where('reference_code', $req->transaction_id)->first();

                            if (isset($getStatement) == true) {

                                // Check if RequestRefund not processed
                                $checkRefund = RequestRefund::where('transaction_id', $req->transaction_id)->first();

                                if (isset($checkRefund)) {

                                    if ($checkRefund->status == "PROCESSED") {
                                        $error = "This transaction request had already been processed back to your wallet. Thanks";

                                        $data = [];
                                        $status = 400;
                                        $message = $error;
                                    } else {

                                        $error = "Your request has been received and will be processed. Thanks";

                                        $data = [];
                                        $status = 400;
                                        $message = $error;
                                    }
                                } else {

                                    RequestRefund::insert(['user_id' => $thisuser->id, 'transaction_id' => $req->transaction_id, 'reason' => $req->reason]);

                                    $data = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol', 'cardRequest')->where('api_token', $req->bearerToken())->first();

                                    $status = 200;
                                    $message = 'You have successfully made request for refund. Kindly note that refund takes up to 5 days for review.';
                                }

                                $this->createNotification($thisuser->ref_code, "Hello " . strtoupper($thisuser->name) . ", " . $message);

                                Log::info("Request for refund by " . $thisuser->name);
                            } else {
                                $error = "Invalid Transaction ID!";

                                $data = [];
                                $status = 400;
                                $message = $error;
                            }
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



        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

        return $this->returnJSON($resData, $status);
    }


    public function debitWalletForCard($ref_code, $card_provider)
    {


        $myWallet = User::where('ref_code', $ref_code)->first();

        // Deduct $20 for EXBC Card
        $wallet_balance = $myWallet->wallet_balance - 20;

        // Update walllet balance
        User::where('ref_code', $ref_code)->update(['wallet_balance' => $wallet_balance]);

        CardRequest::insert(['ref_code' => $ref_code, 'card_provider' => $card_provider, 'status' => 0]);

        $data = User::where('ref_code', $ref_code)->first();

        $status = 200;

        $resData = ['data' => $data, 'message' => 'success', 'status' => $status];

        // Send SMS
        $sendMsg = "Hi " . $data->name . ", " . $data->currencyCode . " 20.00 was deducted from your PaySprint wallet for " . $card_provider . " request. Your new wallet balance is " . $data->currencyCode . ' ' . number_format($wallet_balance, 2) . ". If you did not make this transfer, kindly login to your PaySprint Account to change your Transaction PIN and report the issue to PaySprint Admin using Contact Us.";

        $usergetPhone = User::where('email', $data->email)->where('telephone', 'LIKE', '%+%')->first();

        if (isset($usergetPhone)) {

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

        $this->createNotification($ref_code, $sendMsg);

        // Wallet Statement

        $transaction_id = "wallet-" . date('dmY') . time();

        // Insert Statement
        $activity = "Debited " . $data->currencyCode . " " . number_format(20, 2) . " for " . $card_provider . " request from PaySprint Wallet.";
        $credit = 0;
        $debit = 20;
        $reference_code = $transaction_id;
        $balance = 0;
        $trans_date = date('Y-m-d');
        $status = "Delivered";
        $action = "Wallet debit";
        $regards = $ref_code;

        $statement_route = "wallet";

        // Senders statement
        $this->insStatement($data->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, 'on', $data->country);


        // Create Statement And Credit EXBC account holder
        $exbcMerchant = User::where('email', 'prepaidcard@exbc.ca')->first();

        if (isset($exbcMerchant)) {

            $activity = "Added " . $data->currencyCode . '' . number_format(20, 2) . " to your Wallet for EXBC Prepaid Card Request";
            $credit = 20;
            $debit = 0;
            $reference_code = $transaction_id;
            $balance = 0;
            $trans_date = date('Y-m-d');
            $transstatus = "Delivered";
            $action = "Wallet credit";
            $regards = $exbcMerchant->ref_code;
            $statement_route = "wallet";

            $merchantwalletBal = $exbcMerchant->wallet_balance + 20;

            User::where('email', 'prepaidcard@exbc.ca')->update([
                'wallet_balance' => $merchantwalletBal
            ]);

            // Senders statement
            $this->insStatement($exbcMerchant->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $transstatus, $action, $regards, 1, $statement_route, $exbcMerchant->country);

            $sendMerchantMsg = "Hi " . $exbcMerchant->name . ", " . $data->currencyCode . " 20.00 was added to your wallet for " . $card_provider . " request from " . $data->name . ". Your new wallet balance is " . $data->currencyCode . ' ' . number_format($merchantwalletBal, 2) . ". Thanks.";


            $usergetPhone = User::where('email', 'prepaidcard@exbc.ca')->where('telephone', 'LIKE', '%+%')->first();

            if (isset($usergetPhone)) {

                $sendPhone = $exbcMerchant->telephone;
            } else {
                $sendPhone = "+" . $exbcMerchant->code . $exbcMerchant->telephone;
            }

            if ($exbcMerchant->country == "Nigeria") {

                $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                $this->sendSms($sendMerchantMsg, $correctPhone);
            } else {
                $this->sendMessage($sendMerchantMsg, $sendPhone);
            }



            $this->createNotification($exbcMerchant->ref_code, $sendMerchantMsg);
        } else {
            // Do nothing
        }


        return $resData;
    }

    public function getReceiver(Request $req)
    {

        $accountno = $req->get('accountNumber');

        $user = User::where('api_token', $req->bearerToken())->first();

        if (isset($user)) {


            if ($user->approval == 0) {

                $status = 400;

                $resData = ['data' => [], 'message' => 'You cannot send or receive money now, because your account is not yet approved. Kindly update means of identification in your profile', 'status' => $status];
            } else {
                if ($user->ref_code != $accountno) {
                    // Get User Information
                    $getUser = User::select('name', 'ref_code as accountNumber', 'businessname', 'accountType', 'address', 'city', 'state', 'country')->where('ref_code', $accountno)->first();

                    if (isset($getUser)) {
                        $status = 200;

                        $getUser['name'] = ($getUser->accountType == 'Individual' ? $getUser->name : $getUser->businessname);

                        $resData = ['data' => $getUser, 'message' => 'success', 'status' => $status];
                    } else {
                        $status = 404;

                        $resData = ['data' => [], 'message' => 'No record found', 'status' => $status];
                    }
                } else {
                    $status = 400;

                    $resData = ['data' => [], 'message' => 'You cannot send money to yourself', 'status' => $status];
                }
            }
        } else {
            $status = 400;

            $resData = ['data' => [], 'message' => 'Token mismatch', 'status' => $status];
        }

        return $this->returnJSON($resData, $status);
    }

    public function getSender(Request $req)
    {
        $accountno = $req->get('accountNumber');

        $user = User::where('api_token', $req->bearerToken())->first();

        if (isset($user)) {

            if ($user->approval == 0) {

                $status = 400;

                $resData = ['data' => [], 'message' => 'You cannot send or receive money now, because your account is not yet approved. Kindly update means of identification in your profile', 'status' => $status];
            } else {
                if ($user->ref_code != $accountno) {
                    // Get User Information
                    $getUser = DB::table('organization_pay')
                        ->select(DB::raw('organization_pay.id as itemId, organization_pay.purpose, organization_pay.amount_to_send as amountToReceive, users.ref_code as accountNumber, users.name, users.address, users.city, users.state, users.country'))
                        ->join('users', 'organization_pay.payer_id', '=', 'users.ref_code')->where('organization_pay.payer_id', $accountno)->where('organization_pay.coy_id', $user->ref_code)->where('organization_pay.state', 1)->where('organization_pay.request_receive', '!=', 2)->get();

                    if (isset($getUser)) {
                        $status = 200;

                        $resData = ['data' => $getUser, 'message' => 'success', 'status' => $status];
                    } else {
                        $status = 404;

                        $resData = ['data' => [], 'message' => 'No record found', 'status' => $status];
                    }
                } else {
                    $status = 400;

                    $resData = ['data' => [], 'message' => 'You can not receive money from yourself', 'status' => $status];
                }
            }
        } else {
            $status = 400;

            $resData = ['data' => [], 'message' => 'Token mismatch', 'status' => $status];
        }

        return $this->returnJSON($resData, $status);
    }

    public function sendMoney(Request $req)
    {

        try {

            $sender = User::where('api_token', $req->bearerToken())->first();

            if ($sender->flagged === 1) {
            $message = 'Hello ' . $sender->name . ', Access to the account is not currently available. Kindly contact the Admin using this link: https://paysprint.ca/contact.';

            $status = 400;

                $resData = ['data' => [], 'message' => $message, 'status' => $status];

        }
        else{
            if ($req->amount < 0) {
                $status = 404;

                $resData = ['data' => [], 'message' => "Please enter a positive amount to send", 'status' => $status];
            } else {

                if (isset($req->mode) && $req->mode == "test") {

                    // Get Sender in User


                    if (isset($sender)) {

                        $minBal = $this->minimumWithdrawal($sender->country);

                        // Get Receivers Details
                        $receiver = User::where('ref_code', $req->accountNumber)->first();


                        if (isset($receiver)) {

                            if ($req->amount > ($sender->wallet_balance - $minBal)) {

                                $status = 404;

                                $resData = ['data' => [], 'message' => "Your minimum wallet balance is " . $sender->currencyCode . ' ' . number_format($minBal, 2) . ". Please add money to continue transaction", 'status' => $status];
                            } elseif (($sender->wallet_balance - $minBal) <= $req->amount) {
                                $status = 404;

                                $resData = ['data' => [], 'message' => "Your minimum wallet balance is " . $sender->currencyCode . ' ' . number_format($minBal, 2) . ". Please add money to continue transaction", 'status' => $status];
                            } else {


                                if ($sender->approval < 2 && $sender->accountLevel <= 2) {

                                    $status = 404;

                                    $resData = ['data' => [], 'message' => 'You cannot send money at the moment because your account is still on review.', 'status' => $status];
                                } elseif ($receiver->country != $sender->country) {
                                    $status = 404;

                                    $resData = ['data' => [], 'message' => 'International money transfer is not available at the moment', 'status' => $status];

                                    Log::info("International Transfer  between " . $sender->name . " and " . $receiver->name . ". Not available This is a test environment");
                                } else {

                                    $amount = number_format($req->amount, 2);

                                    $approve_commission = "Yes";


                                    if ($req->purposeOfPayment != "Others") {
                                        $service = $req->purposeOfPayment;
                                    } else {
                                        $service = $req->specifyPurpose;
                                    }




                                    // Getting the sender
                                    $userID = $sender->email;
                                    $payerID = $sender->ref_code;

                                    $paymentToken = "wallet-" . date('dmY') . time();

                                    $wallet_balance = $sender->wallet_balance - $req->amount;

                                    $insertPay = 1;


                                    if ($insertPay == 1) {

                                        try {

                                            // Update Wallet
                                            // User::where('api_token', $req->bearerToken())->update(['wallet_balance' => $wallet_balance]);

                                            // Send mail to both parties

                                            // $this->to = "bambo@vimfile.com";
                                            $this->to = $receiver->email;
                                            $this->name = $sender->name;
                                            $this->coy_name = ($receiver->accountType == 'Individual' ? $receiver->name : $receiver->businessname);
                                            // $this->email = "bambo@vimfile.com";
                                            $this->email = $sender->email;
                                            $this->amount = $req->currency . " " . $req->amount;
                                            $this->paypurpose = $service;
                                            $this->subject = "Payment Received from " . $sender->name . " for " . $service;
                                            $this->subject2 = "Your Payment to " . $this->coy_name . " was successfull";

                                            // Mail to receiver
                                            $this->sendEmail($this->to, "Payment Received");

                                            // Mail from Sender

                                            $this->sendEmail($this->email, "Payment Successful");


                                            // Insert Statement
                                            $activity = "Transfer of " . $req->currency . " " . number_format($req->amount, 2) . " to " . $this->coy_name . " for " . $service . " on PaySprint Wallet.";
                                            $credit = 0;
                                            $debit = $req->amount;
                                            $reference_code = $paymentToken;
                                            $balance = 0;
                                            $trans_date = date('Y-m-d');
                                            $status = "Delivered";
                                            $action = "Wallet debit";
                                            $regards = $receiver->ref_code;


                                            $statement_route = "wallet";


                                            if ($receiver->auto_deposit == 'on') {
                                                $recWallet = $receiver->wallet_balance + $req->amount;
                                                $walletstatus = "Delivered";

                                                $recMsg = "Hi " . $this->coy_name . ", You have received " . $req->currency . ' ' . number_format($req->amount, 2) . " in your PaySprint wallet for " . $service . " from " . $sender->name . ". You now have " . $req->currency . ' ' . number_format($recWallet, 2) . " balance in your wallet. PaySprint Team";
                                            } else {
                                                $recWallet = $receiver->wallet_balance;
                                                $walletstatus = "Pending";

                                                $recMsg = "Hi " . $this->coy_name . ", You have received " . $req->currency . ' ' . number_format($req->amount, 2) . " for " . $service . " from " . $sender->name . ". Your wallet balance is " . $req->currency . ' ' . number_format($recWallet, 2) . ". Kindly login to your wallet account to receive money. PaySprint Team " . route('my account');
                                            }

                                            // User::where('ref_code', $req->accountNumber)->update(['wallet_balance' => $recWallet]);




                                            $sendMsg = "Hi " . $sender->name . ", You have made a " . $activity . " Your new Wallet balance is " . $req->currency . ' ' . number_format($wallet_balance, 2) . ". If you did not make this transfer, kindly login to your PaySprint Account to change your Transaction PIN and report the issue to PaySprint Admin using Contact Us. PaySprint Team";

                                            $usergetPhone = User::where('email', $sender->email)->where('telephone', 'LIKE', '%+%')->first();

                                            if (isset($usergetPhone)) {

                                                $sendPhone = $sender->telephone;
                                            } else {
                                                $sendPhone = "+" . $sender->code . $sender->telephone;
                                            }

                                            if ($sender->country == "Nigeria") {

                                                $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                                                $this->sendSms($sendMsg, $correctPhone);
                                            } else {
                                                $this->sendMessage($sendMsg, $sendPhone);
                                            }


                                            $merchantPhone = User::where('email', $receiver->email)->where('telephone', 'LIKE', '%+%')->first();

                                            if (isset($merchantPhone)) {

                                                $recPhone = $receiver->telephone;
                                            } else {
                                                $recPhone = "+" . $receiver->code . $receiver->telephone;
                                            }

                                            if ($receiver->country == "Nigeria") {

                                                $correctPhone = preg_replace("/[^0-9]/", "", $recPhone);
                                                $this->sendSms($recMsg, $correctPhone);
                                            } else {
                                                $this->sendMessage($recMsg, $recPhone);
                                            }

                                            // Senders statement
                                            // $this->insStatement($userID, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, 'on');

                                            // Receiver Statement
                                            // $this->insStatement($receiver->email, $reference_code, "Received ".$req->currency.' '.number_format($req->amount, 2)." in wallet for ".$service." from ".$sender->name, number_format($req->amount, 2), 0, $balance, $trans_date, $walletstatus, "Wallet credit", $receiver->ref_code, 1, $statement_route, $receiver->auto_deposit);

                                            // $data = OrganizationPay::where('transactionid', $paymentToken)->first();
                                            $data = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol', 'cardRequest')->where('api_token', $req->bearerToken())->first();

                                            $status = 200;

                                            $resData = ['data' => $data, 'message' => 'Money Sent Successfully', 'status' => $status];

                                            $this->updatePoints($sender->id, 'Send money');


                                            Log::info("Sent money from " . $sender->name . " to " . $this->coy_name . ". This is a test environment");

                                            // $this->createNotification($receiver->ref_code, $recMsg);

                                            // $this->createNotification($sender->ref_code, $sendMsg);

                                        } catch (\Throwable $th) {
                                            $status = 400;

                                            $resData = ['data' => [], 'message' => 'Error: ' . $th, 'status' => $status];
                                        }
                                    }
                                }
                            }
                        } else {
                            $status = 404;

                            $resData = ['data' => [], 'message' => 'Receiver not found', 'status' => $status];
                        }
                    } else {
                        $status = 400;

                        $resData = ['data' => [], 'message' => 'Token mismatch', 'status' => $status];
                    }
                } else {

                    $withdrawLimit = $this->getWithdrawalLimit($sender->country, $sender->id);

                    if ($req->amount > $withdrawLimit['withdrawal_per_transaction']) {

                        $message = "Transaction limit for per transaction is " . $sender->currencyCode . ' ' . number_format($withdrawLimit['withdrawal_per_transaction'], 2) . ". Please withdraw a lesser amount";

                        $status = 404;

                        $resData = ['data' => [], 'message' => $message, 'status' => $status];
                    } elseif ($req->amount > $withdrawLimit['withdrawal_per_day']) {

                        $message = "Transaction limit for per transaction is " . $sender->currencyCode . ' ' . number_format($withdrawLimit['withdrawal_per_day'], 2) . ". Please try again the next day";

                        $status = 404;

                        $resData = ['data' => [], 'message' => $message, 'status' => $status];
                    } elseif ($req->amount > $withdrawLimit['withdrawal_per_week']) {

                        $message = "You have reached your limit for the week. Transaction limit per week is " . $sender->currencyCode . ' ' . number_format($withdrawLimit['withdrawal_per_week'], 2) . ". Please try again the next week";

                        $status = 404;

                        $resData = ['data' => [], 'message' => $message, 'status' => $status];
                    } elseif ($req->amount > $withdrawLimit['withdrawal_per_month']) {

                        $message = "You have reached your limit for the week. Transaction limit per month is " . $sender->currencyCode . ' ' . number_format($withdrawLimit['withdrawal_per_week'], 2) . ". Please try again the next month";

                        $status = 404;

                        $resData = ['data' => [], 'message' => $message, 'status' => $status];
                    } else {


                        // Check Transaction PIN
                        if ($sender->transaction_pin != null) {
                            if (Hash::check($req->transaction_pin, $sender->transaction_pin)) {
                                if (isset($sender)) {

                                    $minBal = $this->minimumWithdrawal($sender->country);

                                    // Get Receivers Details
                                    $receiver = User::where('ref_code', $req->accountNumber)->first();

                                    $imtCountry = AllCountries::where('name', $receiver->country)->first();


                                    if (isset($receiver)) {

                                        if ($req->amount > ($sender->wallet_balance - $minBal)) {

                                            $status = 404;

                                            $resData = ['data' => [], 'message' => "Your minimum wallet balance is " . $sender->currencyCode . ' ' . number_format($minBal, 2) . ". Please add money to continue transaction", 'status' => $status];
                                        } elseif (($sender->wallet_balance - $minBal) <= $req->amount) {
                                            $status = 404;

                                            $resData = ['data' => [], 'message' => "Your minimum wallet balance is " . $sender->currencyCode . ' ' . number_format($minBal, 2) . ". Please add money to continue transaction", 'status' => $status];
                                        } else {


                                            if ($sender->approval < 2 && $sender->accountLevel <= 2) {

                                                $status = 404;

                                                $resData = ['data' => [], 'message' => 'You cannot send money at the moment because your account is still on review.', 'status' => $status];
                                            } elseif (isset($imtCountry) && $imtCountry->imt == "false" && $receiver->country != $sender->country || isset($imtCountry) && $imtCountry->outbound == "false" && $receiver->country != $sender->country) {
                                                $status = 404;

                                                $resData = ['data' => [], 'message' => 'International money transfer is not yet available to ' . $imtCountry->name, 'status' => $status];

                                                Log::info("International Transfer  between " . $sender->name . " and " . $receiver->name . ". Not available.");
                                            }


                                            // elseif ($receiver->country != $sender->country) {
                                            //     $status = 404;

                                            //     $resData = ['data' => [], 'message' => 'International money transfer is not available at the moment', 'status' => $status];

                                            //     Log::info("International Transfer  between " . $sender->name . " and " . $receiver->name . ". Not available.");
                                            // }

                                            else {

                                                $amount = number_format($req->amount, 2);

                                                $approve_commission = "Yes";


                                                if ($req->purposeOfPayment != "Others") {
                                                    $service = $req->purposeOfPayment;
                                                } else {
                                                    $service = $req->specifyPurpose;
                                                }

                                                if ($req->currency != $receiver->currencyCode) {
                                                    $dataInfo = $this->convertCurrencyRate($receiver->currencyCode, $req->currency, $req->amount, 'send');
                                                    // $dataInfo = $req->conversionamount;
                                                } else {
                                                    $dataInfo = $req->amount;
                                                }




                                                // Getting the sender
                                                $userID = $sender->email;
                                                $payerID = $sender->ref_code;

                                                $paymentToken = "wallet-" . date('dmY') . time();

                                                $wallet_balance = $sender->wallet_balance - $req->amount;
                                                $withdrawal_per_day = $sender->withdrawal_per_day + $req->amount;
                                                $withdrawal_per_week = $sender->withdrawal_per_week + $withdrawal_per_day;
                                                $withdrawal_per_month = $sender->withdrawal_per_month + $withdrawal_per_week;
                                                $requestReceive = 2;

                                                // $insertPay = OrganizationPay::insert(['transactionid' => $paymentToken, 'coy_id' => $req->accountNumber, 'user_id' => $userID, 'purpose' => $service, 'amount' => $req->amount, 'withdraws' => $req->amount, 'state' => 1, 'payer_id' => $payerID, 'amount_to_send' => $req->amount, 'commission' => 0, 'approve_commission' => $approve_commission, 'request_receive' => 0]);

                                                $insertPay = OrganizationPay::insert(['transactionid' => $paymentToken, 'coy_id' => $req->accountNumber, 'user_id' => $userID, 'purpose' => $service, 'amount' => $receiver->currencyCode . ' ' . $req->amount, 'withdraws' => $receiver->currencyCode . ' ' . $req->amount, 'state' => 1, 'payer_id' => $payerID, 'amount_to_send' => $dataInfo, 'commission' => 0, 'approve_commission' => $approve_commission, 'amountindollars' => $req->currency . ' ' . $dataInfo, 'request_receive' => $requestReceive]);


                                                if ($insertPay == true) {

                                                    try {

                                                        // Update Wallet
                                                        User::where('api_token', $req->bearerToken())->update([
                                                            'wallet_balance' => $wallet_balance,
                                                            'withdrawal_per_day' => $withdrawal_per_day,
                                                            'withdrawal_per_week' => $withdrawal_per_week,
                                                            'withdrawal_per_month' => $withdrawal_per_month
                                                        ]);

                                                        // Send mail to both parties

                                                        // $this->to = "bambo@vimfile.com";
                                                        $this->to = $receiver->email;
                                                        $this->name = $sender->name;
                                                        $this->coy_name = ($receiver->accountType == 'Individual' ? $receiver->name : $receiver->businessname);
                                                        // $this->email = "bambo@vimfile.com";
                                                        $this->email = $sender->email;
                                                        $this->amount = $receiver->currencyCode . " " . $dataInfo;
                                                        $this->paypurpose = $service;
                                                        $this->subject = "Payment Received from " . $sender->name . " for " . $service;
                                                        $this->subject2 = "Your Payment to " . $this->coy_name . " was successfull";

                                                        // Mail to receiver
                                                        $this->sendEmail($this->to, "Payment Received");

                                                        // Mail from Sender

                                                        $this->sendEmail($this->email, "Payment Successful");


                                                        // Insert Statement
                                                        $activity = "Transfer of " . $receiver->currencyCode . " " . number_format($dataInfo, 2) . " to " . $this->coy_name . " for " . $service . " on PaySprint Wallet.";
                                                        $credit = 0;
                                                        $debit = $req->amount;
                                                        $reference_code = $paymentToken;
                                                        $balance = 0;
                                                        $trans_date = date('Y-m-d');
                                                        $status = "Delivered";
                                                        $action = "Wallet debit";
                                                        $regards = $receiver->ref_code;


                                                        $statement_route = "wallet";


                                                        if ($receiver->auto_deposit == 'on') {
                                                            $recWallet = $receiver->wallet_balance + $dataInfo;
                                                            $walletstatus = "Delivered";

                                                            $recMsg = "Hi " . $this->coy_name . ", You have received " . $receiver->currencyCode . ' ' . number_format($dataInfo, 2) . " in your PaySprint wallet for " . $service . " from " . $sender->name . ". You now have " . $receiver->currencyCode . ' ' . number_format($recWallet, 2) . " balance in your wallet. PaySprint Team";
                                                        } else {
                                                            $recWallet = $receiver->wallet_balance;
                                                            $walletstatus = "Pending";

                                                            $recMsg = "Hi " . $this->coy_name . ", You have received " . $receiver->currencyCode . ' ' . number_format($dataInfo, 2) . " for " . $service . " from " . $sender->name . ". Your wallet balance is " . $receiver->currencyCode . ' ' . number_format($recWallet, 2) . ". Kindly login to your wallet account to receive money. PaySprint Team " . route('my account');
                                                        }

                                                        User::where('ref_code', $req->accountNumber)->update(['wallet_balance' => $recWallet]);




                                                        $sendMsg = "Hi " . $sender->name . ", You have made a " . $activity . " Your new Wallet balance is " . $req->currency . ' ' . number_format($wallet_balance, 2) . ". If you did not make this transfer, kindly login to your PaySprint Account to change your Transaction PIN and report the issue to PaySprint Admin using Contact Us. PaySprint Team";

                                                        $usergetPhone = User::where('email', $sender->email)->where('telephone', 'LIKE', '%+%')->first();

                                                        if (isset($usergetPhone)) {

                                                            $sendPhone = $sender->telephone;
                                                        } else {
                                                            $sendPhone = "+" . $sender->code . $sender->telephone;
                                                        }

                                                        if ($sender->country == "Nigeria") {

                                                            $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                                                            $this->sendSms($sendMsg, $correctPhone);
                                                        } else {
                                                            $this->sendMessage($sendMsg, $sendPhone);
                                                        }


                                                        $merchantPhone = User::where('email', $receiver->email)->where('telephone', 'LIKE', '%+%')->first();

                                                        if (isset($merchantPhone)) {

                                                            $recPhone = $receiver->telephone;
                                                        } else {
                                                            $recPhone = "+" . $receiver->code . $receiver->telephone;
                                                        }

                                                        if ($receiver->country == "Nigeria") {

                                                            $correctPhone = preg_replace("/[^0-9]/", "", $recPhone);
                                                            $this->sendSms($recMsg, $correctPhone);
                                                        } else {
                                                            $this->sendMessage($recMsg, $recPhone);
                                                        }

                                                        // Senders statement
                                                        $this->insStatement($userID, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, 'on', $sender->country);

                                                        // Receiver Statement
                                                        // $this->insStatement($receiver->email, $reference_code, "Received " . $receiver->currencyCode . ' ' . number_format($dataInfo, 2) . " in wallet for " . $service . " from " . $sender->name, number_format($req->amount, 2), 0, $balance, $trans_date, $walletstatus, "Wallet credit", $receiver->ref_code, 1, $statement_route, $receiver->auto_deposit);

                                                        $this->insStatement($receiver->email, $reference_code, "Received " . $receiver->currencyCode . ' ' . number_format($dataInfo, 2) . " in wallet for " . $service . " from " . $sender->name, $dataInfo, 0, $balance, $trans_date, $walletstatus, "Wallet credit", $receiver->ref_code, 1, $statement_route, $receiver->auto_deposit, $receiver->country);


                                                        // $data = OrganizationPay::where('transactionid', $paymentToken)->first();
                                                        $data = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol', 'cardRequest')->where('api_token', $req->bearerToken())->first();

                                                        $status = 200;

                                                        $resData = ['data' => $data, 'message' => 'Money Sent Successfully', 'status' => $status];


                                                        Log::info("Sent money from " . $sender->name . " to " . $receiver->name);

                                                        $this->createNotification($receiver->ref_code, $recMsg);

                                                        $this->createNotification($sender->ref_code, $sendMsg);

                                                        $this->updatePoints($sender->id, 'Send money');
                                                    } catch (\Throwable $th) {
                                                        $status = 400;

                                                        $resData = ['data' => [], 'message' => 'Error: ' . $th, 'status' => $status];
                                                    }
                                                }
                                            }
                                        }
                                    } else {
                                        $status = 404;

                                        $resData = ['data' => [], 'message' => 'Receiver not found', 'status' => $status];
                                    }
                                } else {
                                    $status = 400;

                                    $resData = ['data' => [], 'message' => 'Token mismatch', 'status' => $status];
                                }
                            } else {
                                $status = 404;

                                $resData = ['data' => [], 'message' => "Invalid transaction pin", 'status' => $status];
                            }
                        } else {
                            $status = 404;

                            $resData = ['data' => [], 'message' => "Kindly setup transaction pin in your profile settings", 'status' => $status];
                        }
                    }
                }
            }
        }


        } catch (\Throwable $th) {
            $status = 400;

            $resData = ['data' => [], 'message' => $th->getMessage(), 'status' => $status];
        }



        return $this->returnJSON($resData, $status);
    }


    public function claimMoney(Request $req)
    {

        // Get Sender in User
        $thisuser = User::where('api_token', $req->bearerToken())->first();

        if (isset($thisuser)) {
            // Get Money fro Statement
            $getMoney = Statement::where('reference_code', $req->reference_code)->first();

            if (isset($getMoney)) {
                // Get Credit and Add to Wallet
                $credit = $getMoney->debit;

                $wallet_balance = $thisuser->wallet_balance + $credit;

                User::where('api_token', $req->bearerToken())->update(['wallet_balance' => $wallet_balance]);
                Statement::where('reference_code', $req->reference_code)->update(['auto_deposit' => 'on', 'status' => 'Delivered']);


                $query = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol', 'cardRequest')->where('api_token', $req->bearerToken())->first();

                // Send Message

                $recMsg = "Hi " . $thisuser->name . ", You have added a pending transfer of " . $thisuser->currencyCode . ' ' . number_format($credit, 2) . " to your PaySprint wallet. You now have " . $thisuser->currencyCode . ' ' . number_format($wallet_balance, 2) . " balance in your wallet. PaySprint Team";

                $merchantPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

                if (isset($merchantPhone)) {

                    $recPhone = $thisuser->telephone;
                } else {
                    $recPhone = "+" . $thisuser->code . $thisuser->telephone;
                }


                $this->name = $thisuser->name;
                // $this->email = "bambo@vimfile.com";
                $this->email = $thisuser->email;
                $this->subject = $thisuser->currencyCode . $credit . " added to your PaySprint wallet";

                $this->message = '<p>You have added a pending transfer of <strong>' . $thisuser->currencyCode . ' ' . number_format($credit, 2) . '</strong> to your PaySprint wallet. You now have <strong>' . $thisuser->currencyCode . ' ' . number_format($wallet_balance, 2) . '</strong> balance in your account</p>';


                $this->sendEmail($this->email, "Fund remittance");

                if ($thisuser->country == "Nigeria") {

                    $correctPhone = preg_replace("/[^0-9]/", "", $recPhone);
                    $this->sendSms($recMsg, $correctPhone);
                } else {
                    $this->sendMessage($recMsg, $recPhone);
                }


                $this->createNotification($thisuser->ref_code, $recMsg);

                $data = $query;
                $message = $thisuser->currencyCode . $credit . " added to wallet";
                $status = 200;
            } else {
                $data = [];
                $message = "This reference number does not match our record";
                $status = 400;
            }
        } else {
            $data = [];
            $message = "Token mismatch";
            $status = 400;
        }


        $resData = ['data' => $data, 'message' => $message, 'status' => $status];
        return $this->returnJSON($resData, $status);
    }


    public function receiveMoney(Request $req)
    {

        // Get User in token
        $user = User::where('api_token', $req->bearerToken())->first();

        if (isset($user)) {

            // Get Payment Details
            $payDetails = OrganizationPay::where('id', $req->itemId)->first();

            if (isset($payDetails)) {

                ReceivePay::updateOrInsert(['pay_id' => $req->itemId], ['_token' => uniqid(), 'pay_id' => $req->itemId, 'sender_id' => $payDetails->payer_id, 'receiver_id' => $payDetails->coy_id, 'payment_method' => $req->paymentMethod, 'account_number' => $req->bankAccountNumber, 'accountname' => $req->accountName, 'amount_to_receive' => $req->amountToReceive, 'bank_name' => $req->bankName, 'creditcard_no' => $req->exbcCardNumber, 'currency' => $req->currency, 'purpose' => $payDetails->purpose]);

                OrganizationPay::where('id', $req->itemId)->update(['request_receive' => 1]);


                $dataDetails = OrganizationPay::where('id', $req->itemId)->first();


                if ($dataDetails->request_receive == 1) {
                    $data = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol', 'cardRequest')->where('api_token', $req->bearerToken())->first();
                    $message = 'Success. It may take up to two (2) business days for money to reflect in your ' . $req->paymentMethod;
                } elseif ($dataDetails->request_receive == 2) {
                    $data = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol', 'cardRequest')->where('api_token', $req->bearerToken())->first();
                    $message = 'Success. Payment already made, kindly check your financial institution for complaint.';
                } else {
                    $data = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol', 'cardRequest')->where('api_token', $req->bearerToken())->first();
                    $message = 'Success. You have not made request yet';
                }


                $status = 200;

                $resData = ['data' => $data, 'message' => $message, 'status' => $status];
            } else {
                $status = 400;

                $resData = ['data' => [], 'message' => 'Payment detail not found', 'status' => $status];
            }
        } else {
            $status = 400;

            $resData = ['data' => [], 'message' => 'Token mismatch', 'status' => $status];
        }



        return $this->returnJSON($resData, $status);
    }



    // POST ROUTES
    public function createNewOrder(Request $req)
    {


        $thisuser = User::where('api_token', $req->bearerToken())->first();

        if (isset($thisuser)) {

            // Do Validate
            $validator = Validator::make($req->all(), [
                "sellCurrency" => "required|string",
                "sellAmount" => "required|string",
                "buyCurrency" => "required|string",
                "buyAmount" => "required|string",
                "desiredSellRate" => "required|string",
                "desiredSellCurrency" => "required|string",
                "desiredBuyCurrency" => "required|string",
                "desiredBuyRate" => "required|string",
                "expiryDate" => "required|string"
            ]);


            if ($validator->fails() == true) {

                $error = implode(",", $validator->messages()->all());

                $status = 400;

                $resData = ['data' => [], 'message' => $error, 'status' => $status];
            } else {

                $getescrow = EscrowAccount::where('currencyCode', $req->sellCurrency)->where('user_id', $thisuser->id)->first();

                // $minBal = $this->minimumWithdrawal($thisuser->country);

                $walletBal = $getescrow->wallet_balance;
                // Check if User has sufficient sell
                if ($walletBal < $req->sellAmount) {
                    $status = 400;

                    $resData = ['data' => [], 'message' => 'You do not have sufficient balance for this transaction', 'status' => $status];
                } elseif ($req->sellAmount < 0) {
                    $status = 400;

                    $resData = ['data' => [], 'message' => 'You cannot enter a negative value', 'status' => $status];
                } elseif ($walletBal <= 0) {
                    $status = 400;

                    $resData = ['data' => [], 'message' => 'You do not have sufficient balance for this transaction', 'status' => $status];
                } else {
                    // Debit Wallet
                    $debitWallet = $walletBal - $req->sellAmount;

                    EscrowAccount::where('user_id', $thisuser->id)->where('currencyCode', $req->sellCurrency)->update(['wallet_balance' => $debitWallet]);

                    // Continue insert here
                    $query = [
                        'user_id' => $thisuser->id,
                        'order_id' => 'PS-' . mt_rand(000000000, 999999999) . '-' . strtoupper(date('dm')),
                        'sell' => $req->sellAmount,
                        'buy' => $req->buyAmount,
                        'default_currencyCode' => $thisuser->currencyCode,
                        'sell_currencyCode' => $req->sellCurrency,
                        'buy_currencyCode' => $req->buyCurrency,
                        'rate' => $req->rateVal,
                        'expiry' => date('d M Y', strtotime($req->expiryDate)),
                        'bid_amount' => $req->sellAmount,
                        'status' => "Bid Pending",
                        'color' => "red"
                    ];

                    AppMarketPlace::insert($query);


                    // Escrow Wallet Statement

                    $transaction_id = "es-wallet-" . date('dmY') . time();

                    // Insert Escrow Statement
                    $activity = "Wallet debit of " . $thisuser->currencyCode . " " . number_format($req->sellAmount, 2) . " from PaySprint wallet for Currency Exchange.";
                    $credit = 0;
                    $debit = $req->sellAmount;
                    $reference_code = $transaction_id;
                    $balance = 0;
                    $trans_date = date('Y-m-d');
                    $status = "Delivered";
                    $action = "Wallet debit";
                    $regards = $thisuser->ref_code;

                    $statement_route = "wallet";

                    // Senders Escrow statement
                    $this->insFXStatement($getescrow->escrow_id, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, 'on', $thisuser->country, "confirmed");

                    $getWallet = EscrowAccount::where('user_id', $thisuser->id)->where('currencyCode', $req->sellCurrency)->first();


                    $sendMsg = "Hi " . $thisuser->name . ", You have made a " . $activity . " Your new Wallet balance is " . $getWallet->currencyCode . ' ' . number_format($getWallet->wallet_balance, 2) . ".";

                    $usergetPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

                    if (isset($usergetPhone)) {

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

                    Log::info("Currency exchange transaction of " . $getWallet->currencyCode . " " . number_format($req->sellAmount, 2) . " by " . $thisuser->name);

                    $this->createNotification($thisuser->ref_code, "Hello " . strtoupper($thisuser->name) . ", " . $sendMsg);

                    // Return Success
                    $myBid = AppMarketPlace::where('user_id', $thisuser->id)->get();

                    $status = 200;

                    $resData = ['data' => $myBid, 'message' => 'success', 'status' => $status];
                }
            }
        } else {
            $status = 400;

            $resData = ['data' => [], 'message' => 'Token mismatch', 'status' => $status];
        }


        return $this->returnJSON($resData, $status);
    }

    public function insStatement($email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, $state, $statement_route, $auto_deposit, $country = null)
    {
        Statement::insert(['user_id' => $email, 'reference_code' => $reference_code, 'activity' => $activity, 'credit' => $credit, 'debit' => $debit, 'balance' => $balance, 'trans_date' => $trans_date, 'status' => $status, 'action' => $action, 'regards' => $regards, 'state' => $state, 'statement_route' => $statement_route, 'auto_deposit' => $auto_deposit, 'country' => $country]);
    }


    public function insFXStatement($email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, $state, $statement_route, $auto_deposit, $country = null, $confirmation = "confirmed")
    {
        FxStatement::insert(['user_id' => $email, 'reference_code' => $reference_code, 'activity' => $activity, 'credit' => $credit, 'debit' => $debit, 'balance' => $balance, 'trans_date' => $trans_date, 'status' => $status, 'action' => $action, 'regards' => $regards, 'state' => $state, 'statement_route' => $statement_route, 'auto_deposit' => $auto_deposit, 'country' => $country, 'confirmation' => $confirmation]);
    }

    public function convertCurrencyRate($foreigncurrency, $localcurrency, $amount, $route)
    {

        // Get Markup
        $markuppercent = $this->markupPercentage();

        $markValue = (1 + ($markuppercent[0]->percentage / 100));

        $currency = 'USD' . $foreigncurrency;
        $amount = $amount;
        $localCurrency = 'USD' . $localcurrency;

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

            if ($route == "send") {

                if($localCurrency === 'USDUSD'){
                $localConv = 1;
            }
            else{
                $localConv = $result->quotes->$localCurrency;
            }

            $convertLocal = $amount / $localConv;

                // Conversion Rate USD to Local currency

                $actualRate = ($currency !== 'USDUSD' ? $result->quotes->$currency : 1) * $convertLocal;
                $convRate = $actualRate * 95/100;


                $this->calculateBufferedTransaction($actualRate, $convRate, $route."invoice/money");


            } elseif ($route == "pay") {

                // Conversion Rate USD to Local currency
                // $convertLocal = ($amount / $result->quotes->$localCurrency) * $markValue;
                $convertLocal = ($amount / $result->quotes->$localCurrency);

                $actualRate = $result->quotes->$currency * $convertLocal;
                $convRate = $actualRate * 95/100;


                $this->calculateBufferedTransaction($actualRate, $convRate, $route."invoice/money");

            } else {
            }
        } else {
            $convRate = "Sorry we can not process your transaction this time, try again later!.";
        }



        return $convRate;
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
