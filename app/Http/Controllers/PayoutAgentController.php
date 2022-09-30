<?php

namespace App\Http\Controllers;

use App\User;
use App\AddBank;
use App\AddCard;
use App\Statement;
use App\ClientInfo;
use App\PayoutAgent;
use App\Traits\Moex;
use App\AllCountries;
use App\BankWithdrawal;
use App\MoexTransaction;
use App\Traits\IDVCheck;
use App\TransactionCost;
use App\PayoutWithdrawal;
use App\SpecialInformation;
use Illuminate\Http\Request;
use App\Traits\PaymentGateway;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PayoutAgentController extends Controller
{
    use IDVCheck, PaymentGateway, Moex;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PayoutAgent  $payoutAgent
     * @return \Illuminate\Http\Response
     */
    public function show(PayoutAgent $payoutAgent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PayoutAgent  $payoutAgent
     * @return \Illuminate\Http\Response
     */
    public function edit(PayoutAgent $payoutAgent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PayoutAgent  $payoutAgent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PayoutAgent $payoutAgent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PayoutAgent  $payoutAgent
     * @return \Illuminate\Http\Response
     */
    public function destroy(PayoutAgent $payoutAgent)
    {
        //
    }


    public function beAnAgent(Request $req, PayoutAgent $payoutAgent)
    {

        try {

            $thisuser = User::where('ref_code', $req->ref_code)->first();

            $thisclientInfo = ClientInfo::where('user_id', $thisuser->ref_code)->first();


            if ($thisuser->payout_agent === 1) {
                // Delete
                $payoutAgent->where('user_id', $thisuser->ref_code)->delete();
                User::where('ref_code', $req->ref_code)->update(['payout_agent' => 0]);
                $data = [];
                $message = 'Successfully removed as a payout agent in ' . $thisuser->country;
            } else {

                $payoutAgent->updateOrCreate(['user_id' => $req->ref_code], [
                    'user_id' => $req->ref_code,
                    'businessname' => $thisuser->businessname,
                    'address' => $thisclientInfo->address,
                    'city' => $thisclientInfo->city,
                    'state' => $thisclientInfo->state,
                    'country' => $thisclientInfo->country,
                    'fee' => '1.50'
                ]);

                User::where('ref_code', $req->ref_code)->update(['payout_agent' => 1]);

                $data = $payoutAgent->where('user_id', $req->ref_code)->first();

                $message = 'Successfully registered as a payout agent in ' . $thisuser->country;
            }



            $status = 200;
        } catch (\Throwable $th) {
            $data = [];

            $message = $th->getMessage();

            $status = 400;
        }


        $resData = ['data' => $data, 'message' => $message, 'status' => $status];


        return $this->returnJSON($resData, $status);
    }


    public function processPayOut(Request $req, PayoutAgent $payoutAgent)
    {
        try {

            $monerisAction = new MonerisController();

            $thisuser = User::where('api_token', $req->bearerToken())->first();

            PayoutWithdrawal::where('transaction_id', $req->transaction_id)->update(['status' => 'processed']);

            $getcommission = PayoutWithdrawal::where('transaction_id', $req->transaction_id)->first();

            $walletBalance = $thisuser->wallet_balance + $getcommission->commissiondeduct;

            User::where('api_token', $req->bearerToken())->update(['wallet_balance' => $walletBalance]);

            $receiver = User::where('ref_code', $getcommission->ref_code)->first();


            // Add to merchant Statement....
            $transaction_id = "wallet-" . date('dmY') . time();

            $activity = "Added a commission fee of " . $thisuser->currencyCode . '' . number_format($getcommission->commissiondeduct, 2) . " to Wallet for cash payout to " . $receiver->name;
            $credit = $getcommission->commissiondeduct;
            $debit = 0;
            $reference_code = $transaction_id;
            $balance = 0;
            $trans_date = date('Y-m-d');
            $status = "Delivered";
            $action = "Wallet credit";
            $regards = $thisuser->ref_code;
            $statement_route = "wallet";

            // Senders statement
            $monerisAction->insStatement($thisuser->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, $thisuser->country, 0);

            // Mail Merchant of Commission received and Cash remmitance completed successfully

            $monerisAction->name = $thisuser->name;
            $monerisAction->email = $thisuser->email;
            $monerisAction->subject = $thisuser->currencyCode . ' ' . number_format($getcommission->commissiondeduct, 2) . " now added to your wallet with PaySprint";

            $monerisAction->message = '<p>You have received <strong>' . $thisuser->currencyCode . ' ' . number_format($getcommission->commissiondeduct, 2) . '</strong> to your wallet with PaySprint as a commission received from payout with cash to ' . $receiver->name . '. You have <strong>' . $thisuser->currencyCode . ' ' . number_format($walletBalance, 2) . '</strong> balance in your account</p>';

            $monerisAction->sendEmail($monerisAction->email, "Fund remittance");

            $sendMsg = 'You have received ' . $thisuser->currencyCode . ' ' . number_format($getcommission->commissiondeduct, 2) . ' to your wallet with PaySprint as a commission received from payout with cash to ' . $receiver->name . '. You have ' . $thisuser->currencyCode . ' ' . number_format($walletBalance, 2) . ' balance in your account';


            $userPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

            if (isset($userPhone)) {

                $sendPhone = $thisuser->telephone;
            } else {
                $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
            }

            if ($thisuser->country == "Nigeria") {

                $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                $monerisAction->sendSms($sendMsg, $correctPhone);
            } else {
                $monerisAction->sendMessage($sendMsg, $sendPhone);
            }

            // Mail Receiver of Cash received...

            $monerisAction->name = $receiver->name;
            $monerisAction->email = $receiver->email;
            $monerisAction->subject = $receiver->currencyCode . ' ' . number_format($getcommission->amounttosend, 2) . " remmitted as cash by " . $thisuser->businessname;

            $monerisAction->message = '<p>You have received <strong>' . $receiver->currencyCode . ' ' . number_format($getcommission->amounttosend, 2) . '</strong> as cash from ' . $thisuser->businessname . '.  Thank you for choosing PaySprint.</p>';

            $monerisAction->sendEmail($receiver->email, "Fund remittance");

            $data = true;

            $message = "Cash remitted successfully";

            $status = 200;
        } catch (\Throwable $th) {
            $data = [];

            $message = $th->getMessage();

            $status = 400;
        }

        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

        return $this->returnJSON($resData, $status);
    }


    public function partnerAddMoneyToWallet(Request $req)
    {


        try {
            $monerisAction = new MonerisController();

            $thisuser = User::where('api_token', $req->bearerToken())->first();

            if ($thisuser->flagged === 1) {
                $data = [];
                $message = 'Hello ' . $thisuser->name . ', Access to the account is not currently available. Kindly contact the Admin using this link: https://paysprint.ca/contact.';
                $status = 400;
            } elseif ($req->amount <= 0) {
                $data = [];
                $message = 'Amount must be greater than zero.';
                $status = 400;
            } else {

                $etransfer_ref_code = $req->transaction_id;
                $referenced_code = "partner-" . $req->receiver_code . '__' . $etransfer_ref_code;

                $walletBal = $thisuser->wallet_balance;
                $holdBal = $thisuser->hold_balance + $req->amount;

                User::where('api_token', $req->bearerToken())->update(['wallet_balance' => $walletBal, 'hold_balance' => $holdBal]);

                $userData = User::select('id', 'ref_code as refCode', 'name', 'email', 'telephone', 'wallet_balance as walletBalance', 'number_of_withdrawals as noOfWithdrawals')->where('api_token', $req->bearerToken())->first();

                $activity = "Added " . $req->currencyCode . '' . number_format($req->amount, 2) . " to Wallet from our partner: " . $req->gateway;
                $credit = $req->amount;
                $debit = 0;
                $reference_code = $referenced_code;
                $balance = 0;
                $trans_date = date('Y-m-d');
                $status = "Delivered";
                $action = "Wallet credit";
                $regards = $thisuser->ref_code;
                $statement_route = "wallet";

                $monerisAction->insStatement($thisuser->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, $thisuser->country, 1, $etransfer_ref_code);

                $monerisAction->getfeeTransaction($reference_code, $thisuser->ref_code, $req->amount, 0, $req->amount);

                $monerisAction->name = $thisuser->name;
                $monerisAction->email = $thisuser->email;
                $monerisAction->subject = $req->currencyCode . ' ' . number_format($req->amount, 2) . " now submitted to PaySprint for processing";

                $monerisAction->message = '<p>You have added <strong>' . $req->currencyCode . ' ' . number_format($req->amount, 2) . '</strong> to your wallet with PaySprint. Kindly allow up to 12-24 hours for the funds to reflect in your wallet. You have <strong>' . $req->currencyCode . ' ' . number_format($walletBal, 2) . '</strong> balance in your account</p>';

                $sendMsg = 'You have added ' . $req->currencyCode . ' ' . number_format($req->amount, 2) . ' to your wallet with PaySprint. Kindly allow up to 12-24 hours for the funds to reflect in your wallet. You have ' . $req->currencyCode . ' ' . number_format($walletBal, 2) . ' balance in your account';

                $userPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

                if (isset($userPhone)) {

                    $sendPhone = $thisuser->telephone;
                } else {
                    $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
                }

                if ($thisuser->country == "Nigeria") {

                    $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                    $monerisAction->sendSms($sendMsg, $correctPhone);
                } else {
                    $monerisAction->sendMessage($sendMsg, $sendPhone);
                }

                $checkBVN = $monerisAction->bvnVerificationCharge($req->bearerToken());

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
                    $monerisAction->insStatement($thisuser->email, $reference_number, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, $thisuser->country, 0);

                    $monerisAction->getfeeTransaction($reference_number, $thisuser->ref_code, 15, 0, 15);

                    $sendMsg = $activity . '. You have ' . $req->currencyCode . ' ' . number_format($walletBalance, 2) . ' balance in your account';

                    $userPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

                    if (isset($userPhone)) {

                        $sendPhone = $thisuser->telephone;
                    } else {
                        $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
                    }

                    if ($thisuser->country == "Nigeria") {

                        $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                        $monerisAction->sendSms($sendMsg, $correctPhone);
                    } else {
                        $monerisAction->sendMessage($sendMsg, $sendPhone);
                    }
                }

                $userInfo = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol')->where('api_token', $req->bearerToken())->first();

                $data = $userInfo;
                $status = 200;
                $message = 'You have successfully added ' . $req->currencyCode . ' ' . number_format($req->amount, 2) . ' to your wallet' . '. ' . $req->description;

                $monerisAction->createNotification($thisuser->ref_code, $sendMsg);

                $monerisAction->keepRecord($referenced_code, $message, "Success", 'Partner', $thisuser->country, 1, $req->gateway);

                $monerisAction->updatePoints($thisuser->id, 'Add money');

                $monerisAction->chargeForShuftiProVerification($thisuser->ref_code, $thisuser->currencyCode);

                $monerisAction->slack('Congratulations!, ' . $thisuser->name . ' ' . $sendMsg, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));

                $monerisAction->sendEmail($thisuser->email, "Fund remittance");

                $adminMessage = "<p>Transaction ID: " . $reference_code . "</p><p>Name: " . $thisuser->name . "</p><p>Account Number: " . $thisuser->ref_code . "</p><p>Country: " . $thisuser->country . "</p><p>Date: " . date('d/m/Y h:i:a') . "</p><p>Amount: " . $req->currencyCode . ' ' . number_format($req->amounttosend, 2) . "</p><p>Partner Gateway: " . $req->gateway . "</p><p>Status: Successful</p>";

                $monerisAction->notifyAdmin($req->gateway . " inflow", $adminMessage);
            }
        } catch (\Throwable $th) {
            $data = [];
            $message = $th->getMessage();
            $status = 400;
        }


        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

        return $this->returnJSON($resData, $status);
    }

    public function addMoneyWithTransfer(Request $req)
    {
        try {
            $monerisAction = new MonerisController();

            $thisuser = User::where('api_token', $req->bearerToken())->first();
            $currencycode = $thisuser->currencyCode;


            if ($thisuser->flagged === 1) {
                $data = [];
                $message = 'Hello ' . $thisuser->name . ', Access to the account is not currently available. Kindly contact the Admin using this link: https://paysprint.ca/contact.';
                $status = 400;
            } elseif ($req->amount <= 0) {
                $data = [];
                $message = 'Amount must be greater than zero.';
                $status = 400;
            } else {

                $etransfer_ref_code = $req->transaction_id;
                $referenced_code = "partner-" . $req->receiver_code . '__' . $etransfer_ref_code;

                $walletBal = $thisuser->wallet_balance;
                $holdBal = $thisuser->hold_balance + $req->amount;

                User::where('api_token', $req->bearerToken())->update(['wallet_balance' => $walletBal, 'hold_balance' => $holdBal]);

                $userData = User::select('id', 'ref_code as refCode', 'name', 'email', 'telephone', 'wallet_balance as walletBalance', 'number_of_withdrawals as noOfWithdrawals')->where('api_token', $req->bearerToken())->first();

                $activity = "Added " . $currencycode . '' . number_format($req->amount, 2) . " to Wallet from electronic transfer";
                $credit = $req->amount;
                $debit = 0;
                $reference_code = $referenced_code;
                $balance = 0;
                $trans_date = date('Y-m-d');
                $status = "Delivered";
                $action = "Wallet credit";
                $regards = $thisuser->ref_code;
                $statement_route = "wallet";

                $monerisAction->insStatement($thisuser->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, $thisuser->country, 1, $etransfer_ref_code);

                $monerisAction->getfeeTransaction($reference_code, $thisuser->ref_code, $req->amount, 0, $req->amount);

                $monerisAction->name = $thisuser->name;
                $monerisAction->email = $thisuser->email;
                $monerisAction->subject = $currencycode . ' ' . number_format($req->amount, 2) . " now submitted to PaySprint for processing";

                $monerisAction->message = '<p>You have added <strong>' . $currencycode . ' ' . number_format($req->amount, 2) . '</strong> to your wallet with PaySprint. Kindly allow up to 12-24 hours for the funds to reflect in your wallet. You have <strong>' . $currencycode . ' ' . number_format($walletBal, 2) . '</strong> balance in your account</p>';

                $sendMsg = 'You have added ' . $currencycode . ' ' . number_format($req->amount, 2) . ' to your wallet with PaySprint. Kindly allow up to 12-24 hours for the funds to reflect in your wallet. You have ' . $currencycode . ' ' . number_format($walletBal, 2) . ' balance in your account';

                $userPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

                if (isset($userPhone)) {

                    $sendPhone = $thisuser->telephone;
                } else {
                    $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
                }

                if ($thisuser->country == "Nigeria") {

                    $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                    $monerisAction->sendSms($sendMsg, $correctPhone);
                } else {
                    $monerisAction->sendMessage($sendMsg, $sendPhone);
                }

                $checkBVN = $monerisAction->bvnVerificationCharge($req->bearerToken());

                if ($checkBVN == "charge") {

                    $getUser = User::where('api_token', $req->bearerToken())->first();
                    // Update Wallet Balance
                    $walletBalance = $getUser->wallet_balance - 15;
                    User::where('api_token', $req->bearerToken())->update(['wallet_balance' => $walletBalance, 'bvn_verification' => 2]);

                    $activity = "Bank Verification (BVN) Charge of " . $currencycode . '' . number_format(15, 2) . " was deducted from your Wallet";
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
                    $monerisAction->insStatement($thisuser->email, $reference_number, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, $thisuser->country, 0);

                    $monerisAction->getfeeTransaction($reference_number, $thisuser->ref_code, 15, 0, 15);

                    $sendMsg = $activity . '. You have ' . $currencycode . ' ' . number_format($walletBalance, 2) . ' balance in your account';

                    $userPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

                    if (isset($userPhone)) {

                        $sendPhone = $thisuser->telephone;
                    } else {
                        $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
                    }

                    if ($thisuser->country == "Nigeria") {

                        $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                        $monerisAction->sendSms($sendMsg, $correctPhone);
                    } else {
                        $monerisAction->sendMessage($sendMsg, $sendPhone);
                    }
                }

                $userInfo = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol')->where('api_token', $req->bearerToken())->first();

                $data = $userInfo;
                $status = 200;
                $message = 'You have successfully added ' . $currencycode . ' ' . number_format($req->amount, 2) . ' to your wallet' . '. ' . $req->description;

                $monerisAction->createNotification($thisuser->ref_code, $sendMsg);

                $monerisAction->keepRecord($referenced_code, $message, "Success", 'Partner', $thisuser->country, 1, $req->gateway != null ? $req->gateway : 'Moex');

                $monerisAction->updatePoints($thisuser->id, 'Add money');

                $monerisAction->chargeForShuftiProVerification($thisuser->ref_code, $thisuser->currencyCode);

                $monerisAction->slack('Congratulations!, ' . $thisuser->name . ' ' . $sendMsg, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));

                $monerisAction->sendEmail($thisuser->email, "Fund remittance");

                $adminMessage = "<p>Transaction ID: " . $reference_code . "</p><p>Name: " . $thisuser->name . "</p><p>Account Number: " . $thisuser->ref_code . "</p><p>Country: " . $thisuser->country . "</p><p>Date: " . date('d/m/Y h:i:a') . "</p><p>Amount: " . $currencycode . ' ' . number_format($req->amount, 2) . "</p><p>Partner Gateway: " . "Bank/Wire/Electronic Transfer" . "</p><p>Status: Successful</p>";

                $monerisAction->notifyAdmin($req->gateway . " inflow", $adminMessage);
            }
        } catch (\Throwable $th) {
            $data = [];
            $message = $th->getMessage();
            $status = 400;
        }


        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

        return $this->returnJSON($resData, $status);
    }


    public function partnerMoneyWithdrawal(Request $req)
    {
        $monerisAction = new MonerisController();
        $thisuser = User::where('api_token', $req->bearerToken())->first();

        $getCountry = AllCountries::where('name', $thisuser->country)->first();


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

                    $transaction_id = "wallet-" . date('dmY') . time();

                    $checkIdv = $this->checkUsersPassAccount($thisuser->id);

                    if (in_array('withdraw money', $checkIdv['access'])) {

                        $withdrawalCharge = $this->getNumberOfWitdrawals($thisuser->id, $thisuser->country, $req->amount);

                        $chargeAmount = $req->amount + $withdrawalCharge;


                        $withdrawLimit = $this->getWithdrawalLimit($thisuser->country, $thisuser->id);


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
                            $monerisAction->slack($thisuser->name . " wants to withdraw " . $req->currencyCode . " " . $req->amount . " from their wallet.", $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));

                            if ($thisuser->accountType == "Individual") {
                                $subminType = "Consumer Monthly Subscription";
                            } else {
                                $subminType = "Merchant Monthly Subscription";
                            }

                            $minBal = $this->maintenanceBalanceWithdrawal($subminType, $thisuser->country);

                            $minWithdrawalBal = $this->minimumAmountToWithdrawal($subminType, $thisuser->country);

                            $specialInfo = SpecialInformation::where('country', $thisuser->country)->first();

                            // Check amount in wallet
                            if ($req->amount > ($thisuser->wallet_balance - $withdrawalCharge - $minBal)) {
                                // Insufficient amount for withdrawal

                                $minWalBal = $thisuser->wallet_balance - $withdrawalCharge - $minBal;

                                $data = [];
                                $message = "Your available wallet balance is " . $req->currencyCode . ' ' . number_format($minWalBal, 2) . ". Please add money to continue transaction";
                                $status = 400;

                                // Log::info('Oops!, '.$thisuser->name.' has '.$message);

                                $monerisAction->slack('Oops!, ' . $thisuser->name . ' has ' . $message, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));
                            } elseif ($thisuser->approval < 2 && $thisuser->accountLevel <= 2) {
                                // Cannot withdraw minimum balance

                                $data = [];
                                $message = "Sorry!, Your account must be approved before you can withdraw from wallet";
                                $status = 400;

                                // Log::info('Oops!, '.$thisuser->name.' has '.$message);

                                $monerisAction->slack('Oops!, ' . $thisuser->name . ' has ' . $message, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));
                            } elseif (($thisuser->wallet_balance - $withdrawalCharge - $minBal) <= $req->amount) {
                                // Cannot withdraw minimum balance

                                $minWalBal = $thisuser->wallet_balance - $withdrawalCharge - $minBal;

                                $data = [];
                                $message = "Your available wallet balance is " . $req->currencyCode . ' ' . number_format($minWalBal, 2) . ". Please add money to continue transaction";
                                $status = 400;

                                // Log::info('Oops!, '.$thisuser->name.' has '.$message);

                                $monerisAction->slack('Oops!, ' . $thisuser->name . ' has ' . $message, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));
                            } else {


                                if (isset($specialInfo) && $thisuser->accountType == "Individual") {

                                    $messageOut = $specialInfo->information;

                                    $data = [];
                                    $message = $messageOut;
                                    $status = 400;

                                    // Log::info('Oops!, '.$thisuser->name.', '.$message);

                                    $monerisAction->slack('Oops!, ' . $thisuser->name . ', ' . $message, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));
                                } else {

                                    if($req->card_type == "Bank Account"){
                                        $bankDetails = AddBank::where('id', $req->card_id)->where('user_id', $thisuser->id)->first();
                                    }



                                    $dob = $thisuser->yearOfBirth.''.($thisuser->monthOfBirth <= 9 ? "0".$thisuser->monthOfBirth : $thisuser->monthOfBirth).''.$thisuser->dayOfBirth;

                                    // Do MOEX MEAddTransaction....
                                    $moexProperties = array(
                                        'sender' => 'PaySprint Financial Technology',
                                        'senderName' => 'PaySprint',
                                        'senderLastName' => 'Financial Technology',
                                        'senderAddress' => 'PaySprint International 10 George St. North, Brampton. ON. L6X1R2. Canada',
                                        'senderCountry' => 'CAN',
                                        'senderIdDocumentNumber' => config('constants.moex.sender_licence'),
                                        'senderIdDocumentType' => 'DRL',
                                        'receiver' => $thisuser->name,
                                        'receiverName' => explode(' ', $thisuser->name)[0],
                                        'receiverLastName' => explode(' ', $thisuser->name)[1],
                                        'receiverCountry' => $getCountry->cca3,
                                        'bankDeposit' => $req->card_type == "Bank Account" ? 'TRUE' : 'FALSE',
                                        'bankName' => isset($bankDetails) ? $bankDetails->bankName : '',
                                        'bankAddress' => isset($bankDetails) ? $bankDetails->bankName.' '.$thisuser->country : '',
                                        'bankAccount' => isset($bankDetails) ? $bankDetails->accountNumber : '',
                                        'amountToPay' => $req->amount,
                                        'currencyToPay' => $req->currencyCode,
                                        'amountSent' => $req->amount,
                                        'currencySent' => $req->currencyCode,
                                        'originCountry' => 'CAN',
                                        'auxiliaryInfo' => [
                                            'SenderBirthDate' => $dob,
                                            'SenderBirthPlace' => "",
                                            'SenderBirthCountry' => $getCountry->cca3
                                        ],
                                        'reference' => $transaction_id
                                    );


                                    $doMoex = $this->addTransactionToMoex($moexProperties);

                                    if(array_key_exists('error', $doMoex)){

                                        $data = [];
                                        $message = $doMoex['error'];
                                        $status = 400;
                                    }
                                    else{

                                        MoexTransaction::insert(['user_id' => $thisuser->id, 'transaction' => json_encode($doMoex)]);

                                        // Get Transaction record for last money added to wallet
                                        $getTrans = Statement::where('reference_code', 'LIKE', '%ord-%')->where('reference_code', 'LIKE', '%wallet-%')->where('user_id', $thisuser->email)->latest()->first();

                                        // Check Transaction PIn
                                        if ($thisuser->transaction_pin != null) {
                                            // Validate Transaction PIN
                                            if (Hash::check($req->transaction_pin, $thisuser->transaction_pin)) {

                                                $cardDetails = AddCard::where('user_id', $thisuser->id)->first();

                                                if ($req->card_type == "Bank Account") {

                                                    $bankDetails = AddBank::where('id', $req->card_id)->where('user_id', $thisuser->id)->first();

                                                    if (isset($bankDetails)) {



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
                                                        $monerisAction->insStatement($thisuser->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $thistatus, $action, $regards, 1, $statement_route, $thisuser->country, 0);


                                                        $sendMsg = 'Hello ' . strtoupper($thisuser->name) . ', The withdrawal of ' . $req->currencyCode . ' ' . number_format($req->amount, 2) . ' to your Bank Account ' . $bankDetails->bankName . ' and Account Number: ' . $bankDetails->accountNumber . ' has been received. The Direct deposit into your Bank account would be done within the next 5 business days. Withdrawal fee charge of ' . $req->currencyCode . ' ' . number_format($withdrawalCharge, 2) . ' inclusive. You have ' . $req->currencyCode . ' ' . number_format($walletBal, 2) . ' balance in your account';



                                                        $userPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

                                                        if (isset($userPhone)) {

                                                            $sendPhone = $thisuser->telephone;
                                                        } else {
                                                            $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
                                                        }

                                                        $monerisAction->createNotification($thisuser->ref_code, $sendMsg);


                                                        $adminMessage = "<p>Transaction ID: " . $reference_code . "</p><p>Name: " . $thisuser->name . "</p><p>Account Number: " . $thisuser->ref_code . "</p><p>Country: " . $thisuser->country . "</p><p>Date: " . date('d/m/Y h:i:a') . "</p><p>Amount to withdraw: " . $req->currencyCode . ' ' . number_format($req->amount, 2) . "</p><p>Bank Name: " . $bankDetails->bankName . "</p><p>Bank Account Number: " . $bankDetails->accountNumber . "</p><p>Status: Successful</p>";

                                                        $monerisAction->notifyAdmin("Moex withdrawal outflow", $adminMessage);

                                                        $monerisAction->getfeeTransaction($transaction_id, $thisuser->ref_code, $req->amount, $req->commissiondeduct, $req->amount);
                                                    } else {
                                                        $data = [];
                                                        $message = "No bank record found for your account";
                                                        $status = 400;
                                                    }


                                                    $resData = ['data' => $data, 'message' => $message, 'status' => $status];
                                                } else {

                                                    if (isset($getTrans) == true) {
                                                        $transaction_id = $getTrans->reference_code;
                                                    }

                                                    $customer_id = $thisuser->ref_code;

                                                    // Get Card Detail
                                                    $card_number = $cardDetails->card_number;
                                                    $month = $cardDetails->month;
                                                    $year = $cardDetails->year;


                                                    $monerisAction->creditCardWithdrawalRequest($thisuser->ref_code, $transaction_id, $customer_id, $card_number, $month, $year, $req->amount, $thisuser->country);


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

                                                    $activity = "Withdraw " . $req->currencyCode . '' . number_format($req->amount, 2) . " from Wallet to Cash Payment. Withdrawal fee charge of " . $req->currencyCode . '' . number_format($withdrawalCharge, 2) . " inclusive";

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
                                                    $monerisAction->insStatement($thisuser->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, $thisuser->country, 0);



                                                    $cardNo = str_repeat("*", strlen($cardDetails->card_number) - 4) . substr($cardDetails->card_number, -4);


                                                    $monerisAction->name = $thisuser->name;
                                                    $monerisAction->email = $thisuser->email;
                                                    $monerisAction->subject = $req->currencyCode . ' ' . number_format($req->amount, 2) . " has been Withdrawn from your Wallet with PaySprint";

                                                    $monerisAction->message = '<p>The withdrawal of ' . $req->currencyCode . ' ' . number_format($req->amount, 2) . ' as cash payment is successful. The withdrawal will take up to 5 business days before collection. Withdrawal fee charge of ' . $req->currencyCode . '' . number_format($withdrawalCharge, 2) . ' inclusive. </p><p>You have <strong>' . $req->currencyCode . ' ' . number_format($walletBal, 2) . '</strong> balance in your wallet.</p>';



                                                    $sendMsg = 'The withdrawal of ' . $req->currencyCode . ' ' . number_format($req->amount, 2) . ' as cash payment is successful. The withdrawal will take up to 5 business days before collection. Withdrawal fee charge of ' . $req->currencyCode . '' . number_format($withdrawalCharge, 2) . ' inclusive. You have ' . $req->currencyCode . ' ' . number_format($walletBal, 2) . ' balance in your wallet.';

                                                    $userPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

                                                    if (isset($userPhone)) {

                                                        $sendPhone = $thisuser->telephone;
                                                    } else {
                                                        $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
                                                    }


                                                    $monerisAction->createNotification($thisuser->ref_code, $sendMsg);

                                                    $monerisAction->getfeeTransaction($reference_code, $thisuser->ref_code, $req->amount, $req->commissiondeduct, $req->amount);

                                                    if ($thisuser->country == "Nigeria") {

                                                        $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                                                        $monerisAction->sendSms($sendMsg, $correctPhone);
                                                    } else {
                                                        $monerisAction->sendMessage($sendMsg, $sendPhone);
                                                    }

                                                    $monerisAction->sendEmail($monerisAction->email, "Fund remittance");

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
                                                    $cardDetails = AddCard::where('user_id', $thisuser->id)->first();

                                                    if ($req->card_type == "Bank Account") {

                                                        $bankDetails = AddBank::where('id', $req->card_id)->where('user_id', $thisuser->id)->first();

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
                                                        $monerisAction->insStatement($thisuser->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $thistatus, $action, $regards, 1, $statement_route, $thisuser->country, 0);


                                                        $sendMsg = 'Hello ' . strtoupper($thisuser->name) . ', The withdrawal of ' . $req->currencyCode . ' ' . number_format($req->amount, 2) . ' to your Bank Account ' . $bankDetails->bankName . ' and Account Number: ' . $bankDetails->accountNumber . ' has been received. The Direct deposit into your Bank account would be done within the next 5 business days. Withdrawal fee charge of ' . $req->currencyCode . ' ' . number_format($withdrawalCharge, 2) . ' inclusive. You have ' . $req->currencyCode . ' ' . number_format($walletBal, 2) . ' balance in your account';



                                                        $userPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

                                                        if (isset($userPhone)) {

                                                            $sendPhone = $thisuser->telephone;
                                                        } else {
                                                            $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
                                                        }

                                                        $monerisAction->createNotification($thisuser->ref_code, $sendMsg);

                                                        $monerisAction->getfeeTransaction($transaction_id, $thisuser->ref_code, $req->amount, $req->commissiondeduct, $req->amount);



                                                        $resData = ['data' => $data, 'message' => $message, 'status' => $status];
                                                    } else {

                                                        if (isset($getTrans) == true) {
                                                            $transaction_id = $getTrans->reference_code;
                                                        }

                                                        $customer_id = $thisuser->ref_code;

                                                        // Get Card Detail
                                                        $card_number = $cardDetails->card_number;
                                                        $month = $cardDetails->month;
                                                        $year = $cardDetails->year;


                                                        $monerisAction->creditCardWithdrawalRequest($thisuser->ref_code, $transaction_id, $customer_id, $card_number, $month, $year, $req->amount, $thisuser->country);



                                                        $walletBal = $thisuser->wallet_balance - $chargeAmount;
                                                        $no_of_withdraw = $thisuser->number_of_withdrawals + 1;

                                                        User::where('api_token', $req->bearerToken())->update([
                                                            'wallet_balance' => $walletBal,
                                                            'number_of_withdrawals' => $no_of_withdraw
                                                        ]);

                                                        // Update Statement

                                                        $userData = User::select('id', 'ref_code as refCode', 'name', 'email', 'telephone', 'wallet_balance as walletBalance', 'number_of_withdrawals as noOfWithdrawals')->where('api_token', $req->bearerToken())->first();

                                                        $activity = "Withdraw " . $req->currencyCode . '' . number_format($req->amount, 2) . " from Wallet to Cash Payment. Withdrawal fee charge of " . $req->currencyCode . ' ' . number_format($withdrawalCharge, 2) . " inclusive";
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
                                                        $monerisAction->insStatement($thisuser->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, $thisuser->country, 0);

                                                        // $this->getfeeTransaction($reference_code, $thisuser->ref_code, $req->amount, $req->commissiondeduct, $req->amounttosend);
                                                        $monerisAction->getfeeTransaction($reference_code, $thisuser->ref_code, $req->amount, $req->commissiondeduct, $req->amount);



                                                        $cardNo = str_repeat("*", strlen($cardDetails->card_number) - 4) . substr($cardDetails->card_number, -4);

                                                        $monerisAction->name = $thisuser->name;
                                                        $monerisAction->email = $thisuser->email;
                                                        $monerisAction->subject = $req->currencyCode . ' ' . number_format($req->amount, 2) . " has been Withdrawn from your Wallet with PaySprint";

                                                        $monerisAction->message = '<p>The withdrawal of ' . $req->currencyCode . ' ' . number_format($req->amount, 2) . ' to your card, Card Name: <strong>' . strtoupper($cardDetails->card_name) . '</strong> and Number: <strong>' . wordwrap($cardNo, 4, '-', true) . '</strong> is successful. The withdrawal will take up to 5 business days before collection. Withdrawal fee charge of ' . $req->currencyCode . ' ' . number_format($withdrawalCharge, 2) . ' inclusive. </p><p>You have <strong>' . $req->currencyCode . ' ' . number_format($walletBal, 2) . '</strong> balance in your wallet.</p>';

                                                        $sendMsg = 'The withdrawal of ' . $req->currencyCode . ' ' . number_format($req->amount, 2) . ' to your card, Card Name: ' . strtoupper($cardDetails->card_name) . ' and Number: ' . wordwrap($cardNo, 4, '-', true) . ' is successful. The withdrawal will take up to 5 business days before collection. Withdrawal fee charge of ' . $req->currencyCode . ' ' . number_format($withdrawalCharge, 2) . ' inclusive. You have ' . $req->currencyCode . ' ' . number_format($walletBal, 2) . ' balance in your wallet.';

                                                        $userPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

                                                        if (isset($userPhone)) {

                                                            $sendPhone = $thisuser->telephone;
                                                        } else {
                                                            $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
                                                        }


                                                        $monerisAction->createNotification($thisuser->ref_code, $sendMsg);

                                                        if ($thisuser->country == "Nigeria") {

                                                            $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                                                            $monerisAction->sendSms($sendMsg, $correctPhone);
                                                        } else {
                                                            $monerisAction->sendMessage($sendMsg, $sendPhone);
                                                        }

                                                        $monerisAction->sendEmail($monerisAction->email, "Fund remittance");


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

        $resData = ['data' => $data, 'message' => $message, 'status' => $status];
        return $this->returnJSON($resData, $status);
    }
}
