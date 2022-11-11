<?php

namespace App\Http\Controllers;

use App\User;
use App\AllCountries;
use App\MonerisActivity;
use App\TransactionCost;
use App\Traits\ExpressPayment;
use Illuminate\Http\Request;

class ExpressController extends Controller
{

    use ExpressPayment;

    public function index()
    {
        return view('epstester');
    }

    public function rerunExpressCallBack(Request $req)
    {

        $email = $req->email;
        $paymentToken = $req->paymentToken;


        $thisuser = User::where('email', $email)->first();

        try {

            $monerisActions = new MonerisController();

            // Verify Payment ...
            $getVerification = $this->getVerification($paymentToken);


            $checkPayment = MonerisActivity::where('transaction_id', $paymentToken)->first();


            if ($getVerification->responseCode == "00") {

                // Check If transaction already exists...


                if(isset($checkPayment)){
                    // Update Record...
                    MonerisActivity::where('transaction_id', $paymentToken)->update(['bodydata' => json_encode($getVerification)]);
                }
                else{

                    $feeCharge = TransactionCost::where('structure', "Add Funds/Money")->where('method', "Debit Card")->where('country', $thisuser->country)->first();

                    if ($thisuser->country == "Nigeria" && $getVerification->data->amount <= 2500) {

                        $x = ($feeCharge->variable / 100) * $getVerification->data->amount;

                        $y = 0 + $x;

                        $collection = $y;
                    }
                    else{
                        $x = ($feeCharge->variable / 100) * $getVerification->data->amount;

                        $y = $feeCharge->fixed + $x;

                        $collection = $y;
                    }


                // Insert Payment Record

                $grossAmount = $getVerification->data->amount - $collection;



                $getGateway = AllCountries::where('name', $thisuser->country)->first();

                $gateway = "Express Payment Solution";


                $referenced_code = $paymentToken;


                if ($thisuser->auto_credit == 1) {
                    // Update Wallet Balance
                    $walletBal = $thisuser->wallet_balance + $grossAmount;
                    $holdBal = $thisuser->hold_balance;
                } else {
                    // Update Wallet Balance
                    $walletBal = $thisuser->wallet_balance;
                    $holdBal = $thisuser->hold_balance + $grossAmount;
                }


                User::where('email', $email)->update(['wallet_balance' => $walletBal, 'hold_balance' => $holdBal]);

                $userData = User::select('id', 'ref_code as refCode', 'name', 'email', 'telephone', 'wallet_balance as walletBalance', 'number_of_withdrawals as noOfWithdrawals')->where('email', $email)->first();

                $activity = "Added " . $thisuser->currencyCode . '' . number_format($grossAmount, 2) . " to Wallet including a fee charge of " . $thisuser->currencyCode . '' . number_format($collection, 2) . " was deducted";
                $credit = $grossAmount;
                $debit = 0;
                $reference_code = $referenced_code;
                $balance = 0;
                $trans_date = date('Y-m-d');
                $status = "Delivered";
                $action = "Wallet credit";
                $regards = $thisuser->ref_code;
                $statement_route = "wallet";





                // Senders statement
                $monerisActions->insStatement($thisuser->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, $thisuser->country, ($thisuser->auto_credit == 1 ? 0 : 1));

                $monerisActions->getfeeTransaction($reference_code, $thisuser->ref_code, $getVerification->data->amount, $collection, $grossAmount);

                // Notification


                $monerisActions->name = $thisuser->name;
                $monerisActions->email = $thisuser->email;
                $monerisActions->subject = $thisuser->currencyCode . ' ' . number_format($grossAmount, 2) . " now added to your wallet with PaySprint";

                if ($thisuser->auto_credit == 1) {

                    $monerisActions->message = '<p>You have added <strong>' . $thisuser->currencyCode . ' ' . number_format($grossAmount, 2) . '</strong> <em>(Gross Amount of ' . $thisuser->currencyCode . ' ' . number_format($grossAmount, 2) . ' less transaction fee ' . $thisuser->currencyCode . ' ' . number_format($collection, 2) . ')</em> to your wallet with PaySprint. You have <strong>' . $thisuser->currencyCode . ' ' . number_format($walletBal, 2) . '</strong> balance in your account</p>';

                    $sendMsg = 'You have added ' . $thisuser->currencyCode . ' ' . number_format($grossAmount, 2) . ' (Gross Amount of ' . $thisuser->currencyCode . ' ' . number_format($grossAmount, 2) . ' less transaction fee ' . $thisuser->currencyCode . ' ' . number_format($collection, 2) . ') to your wallet with PaySprint. You have ' . $thisuser->currencyCode . ' ' . number_format($walletBal, 2) . ' balance in your account';
                } else {

                    $monerisActions->message = '<p>You have added <strong>' . $thisuser->currencyCode . ' ' . number_format($grossAmount, 2) . '</strong> <em>(Gross Amount of ' . $thisuser->currencyCode . ' ' . number_format($grossAmount, 2) . ' less transaction fee ' . $thisuser->currencyCode . ' ' . number_format($collection, 2) . ')</em> to your wallet with PaySprint. Kindly allow up to 12-24 hours for the funds to reflect in your wallet. You have <strong>' . $thisuser->currencyCode . ' ' . number_format($walletBal, 2) . '</strong> balance in your account</p>';

                    $sendMsg = 'You have added ' . $thisuser->currencyCode . ' ' . number_format($grossAmount, 2) . ' (Gross Amount of ' . $thisuser->currencyCode . ' ' . number_format($grossAmount, 2) . ' less transaction fee ' . $thisuser->currencyCode . ' ' . number_format($collection, 2) . ') to your wallet with PaySprint. Kindly allow up to 12-24 hours for the funds to reflect in your wallet. You have ' . $thisuser->currencyCode . ' ' . number_format($walletBal, 2) . ' balance in your account';
                }



                $userPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

                if (isset($userPhone)) {

                    $sendPhone = $thisuser->telephone;
                } else {
                    $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
                }

                if ($thisuser->country == "Nigeria") {

                    $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                    $monerisActions->sendSms($sendMsg, $correctPhone);
                } else {
                    $monerisActions->sendMessage($sendMsg, $sendPhone);
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
                )->where('email', $email)->first();

                $data = $userInfo;
                $status = 200;
                $message = 'You have successfully added ' . $thisuser->currencyCode . ' ' . number_format($grossAmount, 2) . ' to your wallet. Kindly allow up to 12-24 hours for the funds to reflect in your wallet.';
                $action = 'success';
                $alert = 'alert-success';

                $monerisActions->createNotification($thisuser->ref_code, $sendMsg, $thisuser->playerId, $sendMsg, "Wallet Transaction");

                $monerisActions->keepRecord($referenced_code, $message, "Success", $gateway, $thisuser->country, ($thisuser->auto_credit == 1 ? 0 : 1), null, json_encode($getVerification));

                $monerisActions->updatePoints($thisuser->id, 'Add money');

                // Log::info('Congratulations!, '.$thisuser->name.' '.$sendMsg);

                $monerisActions->slack(
                    'Congratulations!, ' . $thisuser->name . ' ' . $sendMsg,
                    $room = "success-logs",
                    $icon = ":longbox:",
                    env('LOG_SLACK_SUCCESS_URL')
                );

                $monerisActions->sendEmail($monerisActions->email, "Fund remittance");

                $adminMessage = "<p>Transaction ID: " . $reference_code . "</p><p>Name: " . $thisuser->name . "</p><p>Account Number: " . $thisuser->ref_code . "</p><p>Country: " . $thisuser->country . "</p><p>Date: " . date('d/m/Y h:i:a') . "</p><p>Amount: " . $thisuser->currencyCode . ' ' . number_format($grossAmount, 2) . "</p><p>Status: Successful</p>";

                $monerisActions->notifyAdmin($gateway . " inflow", $adminMessage);

                }
            } else {

                if(isset($checkPayment)){
                    // Update Record...
                    MonerisActivity::where('transaction_id', $paymentToken)->update(['bodydata' => json_encode($getVerification)]);
                }
                else{
                    // Store record to database...
                $monerisActions->keepRecord($paymentToken, $getVerification->responseMessage, "Failed", "Express Payment Solution", $thisuser->country, 1, null, json_encode($getVerification));
                }
                $message = "Payment not received | " . $getVerification->responseMessage;
                $status = 400;
                $action = 'error';
                $alert = 'alert-danger';
            }



        } catch (\Throwable $th) {
            $message = "Payment not received | " . $th->getMessage();
            $status = 400;
            $action = 'error';
            $alert = 'alert-danger';
        }

        return back()->with("msg", "<div class='alert ".$alert."'>".$message."</div>");

    }
}
