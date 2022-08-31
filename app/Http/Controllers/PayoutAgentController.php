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
}
