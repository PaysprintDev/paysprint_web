<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\DusuProviders;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Traits\DusuPay;

use CraigPaul\Moneris\Moneris;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\DB;


use Illuminate\Support\Facades\Mail;


use Illuminate\Support\Facades\Log;

use Stripe\Stripe as Stripe;
use Stripe\PaymentIntent as PaymentIntent;

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

use App\AddCard as AddCard;

use App\AddBank as AddBank;

use App\BankWithdrawal as BankWithdrawal;

use App\TransactionCost as TransactionCost;

use App\EPSVendor as EPSVendor;

use App\ChargeBack as ChargeBack;

use App\MonerisActivity as MonerisActivity;

use App\AllCountries as AllCountries;

use App\SpecialInformation as SpecialInformation;

use App\CrossBorderBeneficiary as CrossBorderBeneficiary;

use App\SupportActivity as SupportActivity;

use App\CcWithdrawal as CcWithdrawal;
use App\StoreOrders as StoreOrders;
use App\StoreCart as StoreCart;

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
use App\CrossBorder;
use App\EscrowAccount;
use App\FxStatement;
use App\ImportExcelLink;
use App\InvoiceCommission;
use App\Traits\PaymentGateway;
use App\Traits\PaystackPayment;
use App\Traits\ExpressPayment;
use App\Traits\ElavonPayment;
use App\Traits\Xwireless;
use App\Traits\PaysprintPoint;
use App\Traits\IDVCheck;
use App\Traits\SpecialInfo;
use App\Traits\AccountNotify;
use App\Traits\SecurityChecker;

class DusupayController extends Controller
{
    use DusuPay, PaymentGateway, PaystackPayment, ExpressPayment, ElavonPayment, Xwireless, PaysprintPoint, IDVCheck, SpecialInfo, AccountNotify, SecurityChecker;

    public function getDusuBankCode(Request $req, $id)
    {
        $user = User::where('id', $id)->first();
        $usercountry = $user->currencyCode;
        $countrycode = AllCountries::where('currencyCode', $usercountry)->first();
        $code = $countrycode->code;
        $data = $this->getBankCode($code);
        $provider = $this->getProviders($code, $usercountry);
        // dd($provider);
    }

    public function mobileMoneyProviders()
    {
        $code = 'ug';
        $data = $this->mobileMoney($code);

        DusuProviders::updateOrCreate(['country_code' => $code], ['country_code' => $code, 'result' => json_encode($data->data)]);

        $newResult = DusuProviders::all();


        dd(json_decode($newResult[0]->result));

        // DusuEnd::updateOrCreate(['country' => $code], ['country' => $code, 'data' => json_encode($data)]);

    }

    public function withdrawMobileMoney(Request $req)
    {
        // dd($req->all());
        if ($req->amount < 0) {
            $message = "Please enter a positive amount to withdraw";
            return back()->with("msg", "<div class='alert alert-danger alert-dismissible fade show' role='alert'>$message</div>");
        } else {
            if (isset($req->mode) && $req->mode == "test") {


                $validator = Validator::make($req->all(), [
                    'mobile_money' => 'required|string',
                    'account_number' => 'required|string',
                    'provider' => 'required|string',
                    'amount' => 'required|string',
                    'commission' => 'required|string',
                    'transaction_pin' => 'required|string',
                    'currencyCode' => 'required|string',
                    'conversionamount' => 'required|string',
                    'card_type' => 'required|string',
                    'amounttosend' => 'required|string',
                    'commissiondeduct' => 'required|string',
                    'totalcharge' => 'required|string',
                ]);

                if ($validator->passes()) {

                    $thisuser = User::where('api_token', $req->bearerToken())->first();

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

                        $specialInfo = SpecialInformation::where('country', $thisuser->country)->first();

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

                            if (isset($specialInfo) && $thisuser->accountType == "Individual") {
                                $messageOut = $specialInfo->information;

                                $data = [];
                                $message = $messageOut;
                                $status = 400;

                                // Log::info('Oops!, Though this is a test, but '.$thisuser->name.', '.$message);

                                $this->slack('Oops!, Though this is a test, but ' . $thisuser->name . ', ' . $message, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));
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


                                                // Create Statement And Credit PaySprint Account holder
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

                                                    $this->createNotification($thisuser->ref_code, "Hello " . strtoupper($thisuser->name) . ", " . $message, $thisuser->playerId, $message, "Wallet Debit");

                                                    // Log::info("Hello ".strtoupper($thisuser->name).", ".$message);


                                                    $this->slack("Hello " . strtoupper($thisuser->name) . ", " . $message, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));

                                                    // $this->getfeeTransaction($transaction_id, $thisuser->ref_code, $req->amount, $req->commissiondeduct, $req->amounttosend);
                                                    $this->getfeeTransaction($transaction_id, $thisuser->ref_code, $req->amount, $req->commissiondeduct, $req->amount);


                                                    // Create Statement And Credit PaySprint Account holder
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
                    }
                } else {

                    $error = implode(",", $validator->messages()->all());

                    $data = [];
                    $status = 400;
                    $message = $error;
                }
            } else {
                $validator = Validator::make($req->all(), [
                    'payment_type' => 'required|string',
                    'account_number' => 'required|string',
                    'provider' => 'required|string',
                    'amount' => 'required|string',
                    'commission' => 'required|string',
                    'transaction_pin' => 'required|string',
                    'currencyCode' => 'required|string',
                    'conversionamount' => 'required|string',
                    'amounttosend' => 'required|string',
                    'commissiondeduct' => 'required|string',

                ]);

                // dd($validator);

                if ($validator->passes()) {

                    $thisuser = User::where('id', Auth::id())->first();


                    $checkIdv = $this->checkUsersPassAccount($thisuser->id);


                    if (in_array('withdraw money', $checkIdv['access'])) {
                        // Check number of withdrawal
                        if ($thisuser->number_of_withdrawals >= 1) {

                            if ($thisuser->accountType == "Merchant") {
                                $message = "You have already made withdrawal this week. Try again next week";
                            } else {
                                $message = "You have already made withdrawal this month. Try again next month";
                            }

                            return back()->with("msg", "<div class='alert alert-danger alert-dismissible fade show' role='alert'>$message</div>");
                        } else {
                            $withdrawLimit = $this->getWithdrawalLimit($thisuser->country, $thisuser->id);

                            // $withdrawLimit['withdrawal_per_day']
                            // $withdrawLimit['withdrawal_per_week']
                            // $withdrawLimit['withdrawal_per_month']


                            if ($req->amount > 10000000000000000000000000000000000) {
                                $data = [];
                                $message = "Withdrawal limit per day is " . $req->currencyCode . ' ' . number_format($withdrawLimit['withdrawal_per_day'], 2) . ". Please try a lesser amount";
                                return back()->with("msg", "<div class='alert alert-danger alert-dismissible fade show' role='alert'>$message</div>");
                            } elseif ($req->amount > 10000000000000000000000000000000000) {
                                $data = [];
                                $message = "You have reached your limit for the week. Withdrawal limit per week is " . $req->currencyCode . ' ' . number_format($withdrawLimit['withdrawal_per_week'], 2) . ". Please try again the next week";
                                return back()->with("msg", "<div class='alert alert-danger alert-dismissible fade show' role='alert'>$message</div>");
                            } elseif ($req->amount > 10000000000000000000000000000000000) {
                                $data = [];
                                $message = "You have reached your limit for the month. Withdrawal limit per month is " . $req->currencyCode . ' ' . number_format($withdrawLimit['withdrawal_per_month'], 2) . ". Please try again the next month";
                                return back()->with("msg", "<div class='alert alert-danger alert-dismissible fade show' role='alert'>$message</div>");
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



                                $specialInfo = SpecialInformation::where('country', $thisuser->country)->first();






                                // Check amount in wallet
                                if ($req->amount > ($thisuser->wallet_balance - $minBal)) {
                                    // Insufficient amount for withdrawal

                                    $minWalBal = $thisuser->wallet_balance - $minBal;
                                    $data = [];
                                    $message = "Your available wallet balance is " . $req->currencyCode . ' ' . number_format($minWalBal, 2) . ". Please add money to continue transaction";

                                    return back()->with("msg", "<div class='alert alert-danger alert-dismissible fade show' role='alert'>$message</div>");

                                    // Log::info('Oops!, '.$thisuser->name.' has '.$message);

                                    $this->slack('Oops!, ' . $thisuser->name . ' has ' . $message, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));
                                } elseif ($thisuser->approval < 2 && $thisuser->accountLevel <= 2) {
                                    // Cannot withdraw minimum balance

                                    $data = [];
                                    $message = "Sorry!, Your account must be approved before you can withdraw from wallet";
                                    // dd($message);
                                    return back()->with("msg", "<div class='alert alert-danger alert-dismissible fade show' role='alert'>$message</div>");

                                    // Log::info('Oops!, '.$thisuser->name.' has '.$message);

                                    $this->slack('Oops!, ' . $thisuser->name . ' has ' . $message, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));
                                } elseif (($thisuser->wallet_balance - $minBal) <= $req->amount) {
                                    // Cannot withdraw minimum balance

                                    $minWalBal = $thisuser->wallet_balance - $minBal;
                                    // dd($minWalBal);
                                    $data = [];
                                    $message = "Your available wallet balance is " . $req->currencyCode . ' ' . number_format($minWalBal, 2) . ". Please add money to continue transaction";
                                    return back()->with("msg", "<div class='alert alert-danger alert-dismissible fade show' role='alert'>$message</div>");

                                    // Log::info('Oops!, '.$thisuser->name.' has '.$message);

                                    $this->slack('Oops!, ' . $thisuser->name . ' has ' . $message, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));
                                } else {


                                    if (isset($specialInfo) && $thisuser->accountType == "Individual") {

                                        $messageOut = $specialInfo->information;

                                        $data = [];
                                        $message = $messageOut;
                                        return back()->with("msg", "<div class='alert alert-danger alert-dismissible fade show' role='alert'>$message</div>");

                                        // Log::info('Oops!, '.$thisuser->name.', '.$message);

                                        $this->slack('Oops!, ' . $thisuser->name . ', ' . $message, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));
                                    } else {


                                        if ($req->payment_type == "Prepaid Card") {
                                            $cardType = "EXBC Prepaid Card";
                                        } else {
                                            $cardType = $req->payment_type;
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

                                                        $this->createNotification($thisuser->ref_code, "Hello " . strtoupper($thisuser->name) . ", " . $message, $thisuser->playerId, $message, "Wallet Debit");

                                                        // $this->getfeeTransaction($transaction_id, $thisuser->ref_code, $req->amount, $req->commissiondeduct, $req->amounttosend);
                                                        $this->getfeeTransaction($transaction_id, $thisuser->ref_code, $req->amount, $req->commissiondeduct, $req->amount);


                                                        // Create Statement And Credit PaySprint Account holder
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


                                                            // Log::info('Congratulations!, '.$thisuser->name.' '.$sendMsg);


                                                            $this->slack('Congratulations!, ' . $thisuser->name . ' ' . $sendMsg, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));
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
                                                        // $card_number = $cardDetails->card_number;
                                                        // $month = $cardDetails->month;
                                                        // $year = $cardDetails->year;


                                                        // $this->creditCardWithdrawalRequest($thisuser->ref_code, $transaction_id, $customer_id, $card_number, $month, $year, $req->amount, $thisuser->country);



                                                        // Proceed to Withdrawal

                                                        // $response = $this->monerisWalletProcess($req->bearerToken(), $req->card_id, $monerisDeductamount, "ind_refund", "PaySprint Withdraw from Wallet to ".$thisuser->name, $req->mode);

                                                        // if($response->responseData['ResponseCode'] == "000" || $response->responseData['ResponseCode'] == "001" || $response->responseData['ResponseCode'] == "002" || $response->responseData['ResponseCode'] == "003" || $response->responseData['ResponseCode'] == "004" || $response->responseData['ResponseCode'] == "005" || $response->responseData['ResponseCode'] == "006" || $response->responseData['ResponseCode'] == "007" || $response->responseData['ResponseCode'] == "008" || $response->responseData['ResponseCode'] == "009" || $response->responseData['ResponseCode'] == "010" || $response->responseData['ResponseCode'] == "023" || $response->responseData['ResponseCode'] == "024" || $response->responseData['ResponseCode'] == "025" || $response->responseData['ResponseCode'] == "026" || $response->responseData['ResponseCode'] == "027" || $response->responseData['ResponseCode'] == "028" || $response->responseData['ResponseCode'] == "029"){

                                                        $walletBal = $thisuser->wallet_balance - $req->amount;
                                                        $no_of_withdraw = $thisuser->number_of_withdrawals + 1;
                                                        $withdrawal_per_day = $thisuser->withdrawal_per_day + $req->amount;
                                                        $withdrawal_per_week = $thisuser->withdrawal_per_week + $withdrawal_per_day;
                                                        $withdrawal_per_month = $thisuser->withdrawal_per_month + $withdrawal_per_week;

                                                        User::where('id', Auth::id())->update([
                                                            'wallet_balance' => $walletBal,
                                                            'number_of_withdrawals' => $no_of_withdraw,
                                                            'withdrawal_per_day' => $withdrawal_per_day,
                                                            'withdrawal_per_week' => $withdrawal_per_week,
                                                            'withdrawal_per_month' => $withdrawal_per_month,
                                                        ]);
                                                        $transaction_id = "wallet-" . date('dmY') . time();

                                                        $insRec = BankWithdrawal::updateOrInsert(['transaction_id' => $transaction_id], ['transaction_id' => $transaction_id, 'ref_code' => $thisuser->ref_code, 'bank_id' => $req->payment_type, 'amountToSend' => $req->amount, 'country' => $thisuser->country]);

                                                        // Update Statement

                                                        $userData = User::select('id', 'ref_code as refCode', 'name', 'email', 'telephone', 'wallet_balance as walletBalance', 'number_of_withdrawals as noOfWithdrawals')->where('id', Auth::id())->first();

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
                                                        // $cardDetails = AddCard::where('id', $req->card_id)->where('user_id', $thisuser->id)->first();

                                                        // $cardNo = str_repeat("*", strlen($cardDetails->card_number) - 4) . substr($cardDetails->card_number, -4);


                                                        $this->name = $thisuser->name;
                                                        $this->email = $thisuser->email;
                                                        $this->subject = $req->currencyCode . ' ' . number_format($req->amount, 2) . " has been Withdrawn from your Wallet with PaySprint";

                                                        $this->message = '<p>The withdrawal of ' . $req->currencyCode . ' ' . '</strong> is successful. The withdrawal will take up to 24hrs before it reflects in your mobile money ' . ' ' . $req->account_number . ' </p><p>You have <strong>' . $req->currencyCode . ' ' . number_format($walletBal, 2) . '</strong> balance in your wallet.</p>';



                                                        $sendMsg = '<p>The withdrawal of ' . $req->currencyCode . ' ' . $req->amount . '</strong> is successful. The withdrawal will take up to 24hrs before it reflects in your mobile money ' . '' . $req->account_number . ' </p><p>You have <strong>' . $req->currencyCode . ' ' . number_format($walletBal, 2) . '</strong> balance in your wallet.</p>';

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

                                                        $data = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol')->where('id', Auth::id())->first();
                                                        $status = 200;
                                                        // $message = $req->currencyCode.' '.number_format($req->amount, 2).' is debited from your Wallet';
                                                        $message = $sendMsg;

                                                        return back()->with("msg", "<div class='alert alert-success alert-dismissible fade show' role='alert'>$message</div>");

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
                                                    return back()->with("msg", "<div class='alert alert-danger alert-dismissible fade show' role='alert'>$message</div>");
                                                }
                                            } else {
                                                // Set new transaction pin and validate

                                                if (Hash::check($req->password, $thisuser->password)) {

                                                    if ($req->transaction_pin != $req->confirm_transaction_pin) {

                                                        $data = [];
                                                        $message = "Transaction pin does not match";
                                                        return back()->with("msg", "<div class='alert alert-danger alert-dismissible fade show' role='alert'>$message</div>");
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

                                                            $this->createNotification($thisuser->ref_code, "Hello " . strtoupper($thisuser->name) . ", " . $message, $thisuser->playerId, $message, "Wallet Debit");

                                                            // Log::info("Hello ".strtoupper($thisuser->name).", ".$message);

                                                            $this->slack("Hello " . strtoupper($thisuser->name) . ", " . $message, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));

                                                            // $this->getfeeTransaction($transaction_id, $thisuser->ref_code, $req->amount, $req->commissiondeduct, $req->amounttosend);
                                                            $this->getfeeTransaction($transaction_id, $thisuser->ref_code, $req->amount, $req->commissiondeduct, $req->amount);


                                                            // Create Statement And Credit PaySprint Account holder
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

                                                            // $this->getfeeTransaction($reference_code, $thisuser->ref_code, $req->amount, $req->commissiondeduct, $req->amounttosend);
                                                            $this->getfeeTransaction($reference_code, $thisuser->ref_code, $req->amount, $req->commissiondeduct, $req->amount);


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

                                                            // Log::info("Congratulations! ".strtoupper($thisuser->name)." ".$message);

                                                            $this->slack("Congratulations! " . strtoupper($thisuser->name) . " " . $message, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));
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
                        }
                    } else {
                        $data = [];
                        $message = $checkIdv['response'];
                        return back()->with("msg", "<div class='alert alert-danger alert-dismissible fade show' role='alert'>$message</div>");
                    }
                } else {

                    $error = implode(",", $validator->messages()->all());

                    $data = [];
                    $status = 400;
                    $message = $error;
                    return back()->with("msg", "<div class='alert alert-danger alert-dismissible fade show' role='alert'>$message</div>");
                }
            }
        }


        // $resData = ['data' => $data, 'message' => $message, 'status' => $status];

        // return $this->returnJSON($resData, $status);
    }


    public function insStatement($email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, $state, $statement_route, $country, $hold_fee)
    {
        Statement::insert(['user_id' => $email, 'reference_code' => $reference_code, 'activity' => $activity, 'credit' => $credit, 'debit' => $debit, 'balance' => $balance, 'trans_date' => $trans_date, 'status' => $status, 'action' => $action, 'regards' => $regards, 'state' => $state, 'statement_route' => $statement_route, 'country' => $country, 'hold_fee' => $hold_fee]);
    }
}
