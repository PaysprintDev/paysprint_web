<?php

namespace App\Http\Controllers;

use App\AllCountries;
use App\MarketPlace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\User;
use App\EscrowAccount;
use App\FxPayment;
use App\FxStatement;

use App\Traits\Xwireless;
use App\Traits\MyFX;

class CurrencyFxController extends Controller
{

    use MyFX, Xwireless;

    public function start(Request $req)
    {


        if ($req->session()->has('email') == false) {
            if (Auth::check() == false) {
                return redirect()->route('login');
            }
        } else {

            $user = User::where('email', session('email'))->first();

            Auth::login($user);
        }



        return view('currencyexchange.start');
    }


    public function index(Request $req)
    {



        if ($req->session()->has('email') == false) {
            if (Auth::check() == false) {
                return redirect()->route('login');
            }
        } else {



            $user = User::where('email', session('email'))->first();

            Auth::login($user);
        }

        // Check if User has a forex account
        $checkUser = User::where('id', Auth::id())->first()->forexAccount;


        if (count($checkUser) <= 0) {
            // Create Escrow Account
            EscrowAccount::insert(['user_id' => Auth::id(), 'escrow_id' => 'ES_' . uniqid() . '_' . strtoupper(date('D')), 'currencyCode' => Auth::user()->currencyCode, 'currencySymbol' => Auth::user()->currencySymbol, 'wallet_balance' => "0.00", 'country' => Auth::user()->country, 'active' => "true"]);
        }



        return view('currencyexchange.index');
    }

    // Create FX Wallet
    public function createWallet(Request $req)
    {
        if ($req->session()->has('email') == false) {
            if (Auth::check() == false) {
                return redirect()->route('login');
            }
        } else {

            $user = User::where('email', session('email'))->first();

            Auth::login($user);
        }

        $data = array(
            'allcountry' => $this->getCountryAndCurrency(),
            'mycountry' => $this->personalCountry(Auth::user()->country),
            'mywallet' => Auth::user()->forexAccount
        );

        return view('currencyexchange.createwallet')->with(['pages' => 'Create FX Wallet', 'data' => $data]);
    }

    // Fund FX Account
    public function fundAccount(Request $req)
    {

        if ($req->session()->has('email') == false) {
            if (Auth::check() == false) {
                return redirect()->route('login');
            }
        } else {

            $user = User::where('email', session('email'))->first();

            Auth::login($user);
        }

        $data = array(
            'allcountry' => $this->getCountryAndCurrency(),
            'mycountry' => $this->personalCountry(Auth::user()->country),
            'mywallet' => Auth::user()->forexAccount
        );

        return view('currencyexchange.fundaccount')->with(['pages' => 'Fund FX Wallet', 'data' => $data]);
    }

    public function marketPlace(Request $req)
    {
        if ($req->session()->has('email') == false) {
            if (Auth::check() == false) {
                return redirect()->route('login');
            }
        } else {

            $user = User::where('email', session('email'))->first();

            Auth::login($user);
        }



        return view('currencyexchange.marketplace');
    }



    public function transactionHistory(Request $req)
    {
        if ($req->session()->has('email') == false) {
            if (Auth::check() == false) {
                return redirect()->route('login');
            }
        } else {

            $user = User::where('email', session('email'))->first();

            Auth::login($user);
        }



        return view('currencyexchange.transactionhistory');
    }


    public function walletHistory(Request $req)
    {
        if ($req->session()->has('email') == false) {
            if (Auth::check() == false) {
                return redirect()->route('login');
            }
        } else {

            $user = User::where('email', session('email'))->first();

            Auth::login($user);
        }



        return view('currencyexchange.wallethistory');
    }


    public function myWallet(Request $req)
    {
        if ($req->session()->has('email') == false) {
            if (Auth::check() == false) {
                return redirect()->route('login');
            }
        } else {

            $user = User::where('email', session('email'))->first();

            Auth::login($user);
        }



        return view('currencyexchange.mywallet');
    }


    public function marketPlaceOngoingTransaction(Request $req)
    {
        if ($req->session()->has('email') == false) {
            if (Auth::check() == false) {
                return redirect()->route('login');
            }
        } else {

            $user = User::where('email', session('email'))->first();

            Auth::login($user);
        }



        return view('currencyexchange.marketplaceongoing');
    }


    public function marketPlacePendingTransaction(Request $req)
    {
        if ($req->session()->has('email') == false) {
            if (Auth::check() == false) {
                return redirect()->route('login');
            }
        } else {

            $user = User::where('email', session('email'))->first();

            Auth::login($user);
        }



        return view('currencyexchange.marketplacepending');
    }


    public function marketPlaceMyOrder(Request $req)
    {
        if ($req->session()->has('email') == false) {
            if (Auth::check() == false) {
                return redirect()->route('login');
            }
        } else {

            $user = User::where('email', session('email'))->first();

            Auth::login($user);
        }



        return view('currencyexchange.marketplacemyorder');
    }


    public function getUserData(Request $req)
    {

        $thisuser = User::where('api_token', $req->bearerToken())->first();

        if (isset($thisuser)) {
            $data = $thisuser;
            $message = 'success';
            $status = 200;
        } else {
            $data = [];
            $message = 'Session expired. Please re-login';
            $status = 201;
        }

        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

        return $this->returnJSON($resData, $status);
    }


    // Get My Escrow Account
    public function getEscrow(Request $req)
    {

        try {
            $thisuser = User::where('api_token', $req->bearerToken())->first();

            if (isset($thisuser)) {

                if ($req->get('currency') != null) {

                    EscrowAccount::where('user_id', $thisuser->id)->where('currencyCode', '!=', $req->get('currency'))->update(['active' => "false"]);

                    EscrowAccount::where('user_id', $thisuser->id)->where('currencyCode', $req->get('currency'))->update(['active' => "true"]);

                    $myaccount = User::where('id', $thisuser->id)->first()->forexAccount;
                } else {
                    $myaccount = User::where('id', $thisuser->id)->first()->forexAccount;
                }


                $data = $myaccount;
                $message = 'success';
                $status = 200;
            } else {
                $data = [];
                $message = 'Session expired. Please re-login';
                $status = 201;
            }
        } catch (\Throwable $th) {
            $data = [];
            $message = $th->getMessage();
            $status = 400;
        }

        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

        return $this->returnJSON($resData, $status);
    }


    // Get FX Transaction History
    public function fxTransactionHistory(Request $req)
    {


        try {
            $thisuser = User::where('api_token', $req->bearerToken())->first();
            // Get Transaction History for this user...
            $transData = FxStatement::where('regards', $thisuser->ref_code)->where('user_id', $req->currency)->orderBy('created_at', 'DESC')->get();

            if (count($transData) > 0) {
                $data = $transData;
                $message = 'success';
                $status = 200;
            } else {
                $data = [];
                $message = 'No record';
                $status = 201;
            }
        } catch (\Throwable $th) {
            $data = [];
            $message = $th->getMessage();
            $status = 400;
        }

        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

        return $this->returnJSON($resData, $status);
    }


    public function fxWallets(Request $req)
    {
        try {
            $thisuser = User::where('api_token', $req->bearerToken())->first();

            $getmywallet = EscrowAccount::where('user_id', $thisuser->id)->get();

            if (count($getmywallet) > 0) {
                $data = $getmywallet;
                $message = 'success';
                $status = 200;
            } else {
                $data = [];
                $message = 'No record';
                $status = 201;
            }
        } catch (\Throwable $th) {
            $data = [];
            $message = $th->getMessage();
            $status = 400;
        }

        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

        return $this->returnJSON($resData, $status);
    }

    // Create New Wallet
    public function createNewWallet(Request $req)
    {
        try {
            $thisuser = User::where('api_token', $req->bearerToken())->first();

            if (isset($thisuser)) {

                $validator = Validator::make($req->all(), [
                    'country' => 'required|string',
                ]);

                if ($validator->passes()) {

                    $allcountry = AllCountries::where('name', $req->country)->first();


                    // Check Escrow wallet
                    $checkAccount = EscrowAccount::where('user_id', $thisuser->id)->where('currencyCode', $allcountry->currencyCode)->first();

                    if (isset($checkAccount)) {
                        $data = [];
                        $message = 'You have already created a wallet in ' . $req->country . ' (' . strtoupper($allcountry->currencyCode) . ')';
                        $status = 400;
                    } else {


                        // Create New Wallet
                        $query = [
                            'user_id' => $thisuser->id,
                            'escrow_id' => $req->escrow_id,
                            'currencyCode' => $allcountry->currencyCode,
                            'currencySymbol' => $allcountry->currencySymbol,
                            'wallet_balance' => "0.00",
                            'country' => $req->country,
                            'active' => "false"
                        ];

                        $createWallet = EscrowAccount::insert($query);


                        $data = $createWallet;
                        $status = 200;
                        $message = 'You have successfully added  ' . $req->country . '(' . $allcountry->currencyCode . ') to your FX Account. Proceed to fund your wallet';

                        $this->createNotification(
                            $thisuser->ref_code,
                            "Hello " . strtoupper($thisuser->name) . $message . "."
                        );

                        $this->slack("New FX Account of " . $allcountry->currencyCode . " created by :=> " . $thisuser->name, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));
                    }
                } else {
                    $error = implode(",", $validator->messages()->all());

                    $data = [];
                    $status = 400;
                    $message = $error;
                }
            } else {
                $data = [];
                $message = 'Invalid Authorization token. Kindly login and try again';
                $status = 400;
            }
        } catch (\Throwable $th) {
            $data = [];
            $message = $th->getMessage();
            $status = 400;
        }

        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

        return $this->returnJSON($resData, $status);
    }


    // Fund FX Wallet
    public function fundFXWallet(Request $req)
    {


        try {
            $thisuser = User::where('api_token', $req->bearerToken())->first();

            // Check if amount is not negative
            if ($req->fx_amount < 0) {
                $data = [];
                $message = "You cannot insert a negative value";
                $status = 400;
            } else {
                // Add Money Here and put on pending if Wired Transfer
                $myaccount = EscrowAccount::where('escrow_id', $req->fx_wallet)->first();

                if (isset($myaccount)) {

                    $transaction_id = "es-wallet-" . date('dmY') . time();

                    $activity = "Added " . $myaccount->currencyCode . '' . number_format($req->fx_amount, 2) . " to Escrow Wallet.";
                    $credit = $req->fx_amount;
                    $debit = 0;
                    $reference_code = $transaction_id;
                    $balance = 0;
                    $trans_date = date('Y-m-d');
                    $status = "Delivered";
                    $action = "Escrow Wallet credit";
                    $regards = $thisuser->ref_code;
                    $statement_route = "escrow wallet";


                    if ($req->fx_payment_method == "Wire Transfer") {

                        $this->insFXStatement($req->fx_wallet, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, 'on', $myaccount->country, 'pending');

                        $sendMsg = "Hi " . $thisuser->name . ", You have " . $activity . " Your transaction status is PENDING. Your current escrow balance is " . $myaccount->currencyCode . ' ' . number_format($myaccount->wallet_balance, 2) . ".";
                    } else {

                        $newBalance = $myaccount->wallet_balance + $req->fx_amount;

                        EscrowAccount::where('escrow_id', $req->fx_wallet)->update(['wallet_balance' => $newBalance]);

                        $myBalance = EscrowAccount::where('escrow_id', $req->fx_wallet)->first();

                        $this->insFXStatement($thisuser->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, 'on', $thisuser->country, 'confirmed');

                        $sendMsg = "Hi " . $thisuser->name . ", You have " . $activity . " Your current escrow balance is " . $myaccount->currencyCode . ' ' . number_format($myBalance, 2) . ".";

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
                    }

                    // Insert Money Payment
                    $queryRec = [
                        'user_id' => $thisuser->id, 'escrow_id' => $req->fx_wallet, 'amount' => $req->fx_amount, 'currencyCode' => $myaccount->currencyCode, 'currencySymbol' => $myaccount->currencySymbol, 'reference_number' => $transaction_id, 'payment_method' => $req->fx_payment_method, 'bank_name' => $req->fx_payment_bank_name, 'account_number'  => $req->fx_account_number, 'account_name'  => $req->fx_account_name
                    ];
                    FxPayment::insert($queryRec);

                    // Log Activities here
                    $this->createNotification($thisuser->ref_code, $sendMsg);

                    $this->slack('Congratulations!, ' . $thisuser->name . ' ' . $sendMsg, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));

                    $getAccount = EscrowAccount::where('escrow_id', $req->fx_wallet)->first();

                    $data = $getAccount;
                    $message = "Success | Your wallet will be updated within 24hrs";
                    $status = 200;
                } else {
                    $data = [];
                    $message = "Wallet not found!";
                    $status = 400;
                }
            }
        } catch (\Throwable $th) {
            $data = [];
            $message = $th->getMessage();
            $status = 400;
        }

        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

        return $this->returnJSON($resData, $status);
    }


    // All Active Orders
    public function getActiveOrders(Request $req)
    {
        $thisuser = User::where('api_token', $req->bearerToken())->first();


        try {
            if (isset($thisuser)) {
                $market = MarketPlace::where('expiry', '>=', date('d F Y'))->orderBy('created_at', 'DESC')->get();

                if (count($market) > 0) {
                    $data = $market;
                    $message = 'success';
                    $status = 200;
                } else {
                    $data = [];
                    $message = 'No active orders';
                    $status = 200;
                }
            } else {
                $data = [];
                $message = 'Session expired. Please re-login';
                $status = 201;
            }
        } catch (\Throwable $th) {
            $data = [];
            $message = $th->getMessage();
            $status = 201;
        }

        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

        return $this->returnJSON($resData, $status);
    }


    //TODO:: All Orders

    public function getAllOrders(Request $req)
    {
        $thisuser = User::where('api_token', $req->bearerToken())->first();


        try {
            if (isset($thisuser)) {
                $market = MarketPlace::orderBy('created_at', 'DESC')->get();

                if (count($market) > 0) {
                    $data = $market;
                    $message = 'success';
                    $status = 200;
                } else {
                    $data = [];
                    $message = 'No orders placed yet';
                    $status = 200;
                }
            } else {
                $data = [];
                $message = 'Session expired. Please re-login';
                $status = 201;
            }
        } catch (\Throwable $th) {
            $data = [];
            $message = $th->getMessage();
            $status = 201;
        }

        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

        return $this->returnJSON($resData, $status);
    }

    public function getSoldOrders(Request $req)
    {
        $thisuser = User::where('api_token', $req->bearerToken())->first();


        try {
            if (isset($thisuser)) {
                $market = MarketPlace::where('status', 'Sold')->orderBy('created_at', 'DESC')->get();

                if (count($market) > 0) {
                    $data = $market;
                    $message = 'success';
                    $status = 200;
                } else {
                    $data = [];
                    $message = 'No active order available';
                    $status = 200;
                }
            } else {
                $data = [];
                $message = 'Session expired. Please re-login';
                $status = 201;
            }
        } catch (\Throwable $th) {
            $data = [];
            $message = $th->getMessage();
            $status = 201;
        }

        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

        return $this->returnJSON($resData, $status);
    }


    public function getPendingOrders(Request $req)
    {
        $thisuser = User::where('api_token', $req->bearerToken())->first();


        try {
            if (isset($thisuser)) {
                $market = MarketPlace::where('status', 'Bid Pending')->where('expiry', '>=', date('d F Y'))->orderBy('created_at', 'DESC')->get();

                if (count($market) > 0) {
                    $data = $market;
                    $message = 'success';
                    $status = 200;
                } else {
                    $data = [];
                    $message = 'No pending order available';
                    $status = 200;
                }
            } else {
                $data = [];
                $message = 'Session expired. Please re-login';
                $status = 201;
            }
        } catch (\Throwable $th) {
            $data = [];
            $message = $th->getMessage();
            $status = 201;
        }

        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

        return $this->returnJSON($resData, $status);
    }

    public function getMyOrders(Request $req)
    {
        $thisuser = User::where('api_token', $req->bearerToken())->first();


        try {
            if (isset($thisuser)) {
                $market = MarketPlace::where('user_id', $thisuser->id)->orderBy('created_at', 'DESC')->get();

                if (count($market) > 0) {
                    $data = $market;
                    $message = 'success';
                    $status = 200;
                } else {
                    $data = [];
                    $message = 'No order available';
                    $status = 200;
                }
            } else {
                $data = [];
                $message = 'Session expired. Please re-login';
                $status = 201;
            }
        } catch (\Throwable $th) {
            $data = [];
            $message = $th->getMessage();
            $status = 201;
        }

        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

        return $this->returnJSON($resData, $status);
    }


    public function insFXStatement($email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, $state, $statement_route, $auto_deposit, $country = null, $confirmation)
    {
        FxStatement::insert(['user_id' => $email, 'reference_code' => $reference_code, 'activity' => $activity, 'credit' => $credit, 'debit' => $debit, 'balance' => $balance, 'trans_date' => $trans_date, 'status' => $status, 'action' => $action, 'regards' => $regards, 'state' => $state, 'statement_route' => $statement_route, 'auto_deposit' => $auto_deposit, 'country' => $country, 'confirmation' => 'pending']);
    }
}