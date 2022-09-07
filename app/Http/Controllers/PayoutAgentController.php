<?php

namespace App\Http\Controllers;

use App\User;
use App\Statement;
use App\ClientInfo;
use App\PayoutAgent;
use App\PayoutWithdrawal;
use Illuminate\Http\Request;

class PayoutAgentController extends Controller
{
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
            } else {

                $referenced_code = $req->transaction_id;

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

                $monerisAction->insStatement($thisuser->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, $thisuser->country, 1);

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
                $message = 'You have successfully added ' . $req->currencyCode . ' ' . number_format($req->amount, 2) . ' to your wallet';

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
            } else {

                $referenced_code = $req->transaction_id;

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

                $monerisAction->insStatement($thisuser->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, $thisuser->country, 1);

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
                $message = 'You have successfully added ' . $currencycode . ' ' . number_format($req->amount, 2) . ' to your wallet';

                $monerisAction->createNotification($thisuser->ref_code, $sendMsg);

                $monerisAction->keepRecord($referenced_code, $message, "Success", 'Partner', $thisuser->country, 1, $req->gateway);

                $monerisAction->updatePoints($thisuser->id, 'Add money');

                $monerisAction->chargeForShuftiProVerification($thisuser->ref_code, $thisuser->currencyCode);

                $monerisAction->slack('Congratulations!, ' . $thisuser->name . ' ' . $sendMsg, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));

                $monerisAction->sendEmail($thisuser->email, "Fund remittance");

                $adminMessage = "<p>Transaction ID: " . $reference_code . "</p><p>Name: " . $thisuser->name . "</p><p>Account Number: " . $thisuser->ref_code . "</p><p>Country: " . $thisuser->country . "</p><p>Date: " . date('d/m/Y h:i:a') . "</p><p>Amount: " . $currencycode . ' ' . number_format($req->amounttosend, 2) . "</p><p>Partner Gateway: " . "Bank/Wire/Electronic Transfer" . "</p><p>Status: Successful</p>";

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
}
