<?php

namespace App\Http\Controllers;

use App\AllCountries;
use App\CrossBorder;
use App\MarketPlace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\User;
use App\EscrowAccount;
use App\FxPayment;
use App\FxStatement;
use App\ImportExcel;
use App\InvoiceCommission;
use App\ClientInfo;
use App\MakeBid;
use App\Statement;
use App\Traits\Xwireless;
use App\Traits\MyFX;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

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

        if (Auth::user()->plan != 'classic') {
            return redirect()->back();
        }

        
        $checker = $this->checkImt(Auth::user()->country);

        if($checker == "false"){
            return back()->with('error', 'This feature is not yet available for your country');
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

        if (Auth::user()->plan != 'classic') {
            return redirect()->back();
        }

        $client = $this->getMyClientInfo(Auth::user()->ref_code);


        if(isset($client) && $client->accountMode == "test"){
            
            return redirect()->route('dashboard')->with('error', 'You are in test mode');
        }

        // Check if User has a forex account
        $checkUser = User::where('id', Auth::id())->first()->forexAccount;


        if (count($checkUser) <= 0) {
            // Create Escrow Account
            EscrowAccount::insert(['user_id' => Auth::id(), 'escrow_id' => 'ES_' . uniqid() . '_' . strtoupper(date('D')), 'currencyCode' => Auth::user()->currencyCode, 'currencySymbol' => Auth::user()->currencySymbol, 'wallet_balance' => "0.00", 'country' => Auth::user()->country, 'active' => "true"]);
        }


        $checker = $this->checkImt(Auth::user()->country);

        if($checker == "false"){
            return back()->with('error', 'This feature is not yet available for your country');
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

        $checker = $this->checkImt(Auth::user()->country);

        if($checker == "false"){
            return back()->with('error', 'This feature is not yet available for your country');
        }

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

        $checker = $this->checkImt(Auth::user()->country);

        if($checker == "false"){
            return back()->with('error', 'This feature is not yet available for your country');
        }

        return view('currencyexchange.fundaccount')->with(['pages' => 'Fund FX Wallet', 'data' => $data]);
    }

    // TRansfer Funds
    public function transferfundAccount(Request $req)
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

        $checker = $this->checkImt(Auth::user()->country);

        if($checker == "false"){
            return back()->with('error', 'This feature is not yet available for your country');
        }

        return view('currencyexchange.fundtransfer')->with(['pages' => 'Transfer between FX Wallet', 'data' => $data]);
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

        $checker = $this->checkImt(Auth::user()->country);

        if($checker == "false"){
            return back()->with('error', 'This feature is not yet available for your country');
        }


        return view('currencyexchange.marketplace');
    }


    public function myInvoices(Request $req)
    {
        if ($req->session()->has('email') == false) {
            if (Auth::check() == false) {
                return redirect()->route('login');
            }
        } else {

            $user = User::where('email', session('email'))->first();

            Auth::login($user);
        }


        $checker = $this->checkImt(Auth::user()->country);

        if($checker == "false"){
            return back()->with('error', 'This feature is not yet available for your country');
        }

        return view('currencyexchange.invoices');
    }

    
        // Get My Client Info
    public function getMyClientInfo($ref_code)
    {
        $data = ClientInfo::where('user_id', $ref_code)->first();

        return $data;
    }



    public function myCrossBorderPlatform(Request $req)
    {
        if ($req->session()->has('email') == false) {
            if (Auth::check() == false) {
                return redirect()->route('login');
            }
        } else {

            $user = User::where('email', session('email'))->first();

            Auth::login($user);
        }

        $checker = $this->checkImt(Auth::user()->country);

        if($checker == "false"){
            return back()->with('error', 'This feature is not yet available for your country');
        }

        return view('currencyexchange.crossborderplatform');
    }


    public function myPendingCrossBorderPayment(Request $req)
    {
        if ($req->session()->has('email') == false) {
            if (Auth::check() == false) {
                return redirect()->route('login');
            }
        } else {

            $user = User::where('email', session('email'))->first();

            Auth::login($user);
        }

        $checker = $this->checkImt(Auth::user()->country);

        if($checker == "false"){
            return back()->with('error', 'This feature is not yet available for your country');
        }

        return view('currencyexchange.pendingcrossborderpayment');
    }


    public function paidInvoices(Request $req)
    {
        if ($req->session()->has('email') == false) {
            if (Auth::check() == false) {
                return redirect()->route('login');
            }
        } else {

            $user = User::where('email', session('email'))->first();

            Auth::login($user);
        }

        $checker = $this->checkImt(Auth::user()->country);

        if($checker == "false"){
            return back()->with('error', 'This feature is not yet available for your country');
        }

        return view('currencyexchange.paidinvoices');
    }
    public function pendingInvoices(Request $req)
    {
        if ($req->session()->has('email') == false) {
            if (Auth::check() == false) {
                return redirect()->route('login');
            }
        } else {

            $user = User::where('email', session('email'))->first();

            Auth::login($user);
        }


        $checker = $this->checkImt(Auth::user()->country);

        if($checker == "false"){
            return back()->with('error', 'This feature is not yet available for your country');
        }

        return view('currencyexchange.pendinginvoices');
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

        $checker = $this->checkImt(Auth::user()->country);

        if($checker == "false"){
            return back()->with('error', 'This feature is not yet available for your country');
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

        $checker = $this->checkImt(Auth::user()->country);

        if($checker == "false"){
            return back()->with('error', 'This feature is not yet available for your country');
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

        $checker = $this->checkImt(Auth::user()->country);

        if($checker == "false"){
            return back()->with('error', 'This feature is not yet available for your country');
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

        $checker = $this->checkImt(Auth::user()->country);

        if($checker == "false"){
            return back()->with('error', 'This feature is not yet available for your country');
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

        $checker = $this->checkImt(Auth::user()->country);

        if($checker == "false"){
            return back()->with('error', 'This feature is not yet available for your country');
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

        $checker = $this->checkImt(Auth::user()->country);

        if($checker == "false"){
            return back()->with('error', 'This feature is not yet available for your country');
        }

        return view('currencyexchange.marketplacemyorder');
    }

    public function marketRecentBids(Request $req)
    {
        if ($req->session()->has('email') == false) {
            if (Auth::check() == false) {
                return redirect()->route('login');
            }
        } else {

            $user = User::where('email', session('email'))->first();

            Auth::login($user);
        }

        $checker = $this->checkImt(Auth::user()->country);

        if($checker == "false"){
            return back()->with('error', 'This feature is not yet available for your country');
        }

        return view('currencyexchange.marketplacerecentbids');
    }


    public function marketViewMyBids(Request $req)
    {
        if ($req->session()->has('email') == false) {
            if (Auth::check() == false) {
                return redirect()->route('login');
            }
        } else {

            $user = User::where('email', session('email'))->first();

            Auth::login($user);
        }

        $checker = $this->checkImt(Auth::user()->country);

        if($checker == "false"){
            return back()->with('error', 'This feature is not yet available for your country');
        }

        return view('currencyexchange.marketplaceviewmybids');
    }


    // Make Bid
    public function marketPlaceYourBid(Request $req, $orderId)
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
            'mywallet' => Auth::user()->forexAccount,
            'marketplace' => $this->getMarketBidding($orderId)
        );

        $checker = $this->checkImt(Auth::user()->country);

        if($checker == "false"){
            return back()->with('error', 'This feature is not yet available for your country');
        }

        return view('currencyexchange.placebid')->with(['pages' => 'Make Bid', 'data' => $data]);
    }

    // Accept a bid
    public function marketAcceptABid(Request $req)
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
            'mywallet' => Auth::user()->forexAccount,
            'marketplace' => $this->getMakeABid($req->get('orderId'), $req->get('buyer_id'))
        );

        $checker = $this->checkImt(Auth::user()->country);

        if($checker == "false"){
            return back()->with('error', 'This feature is not yet available for your country');
        }

        return view('currencyexchange.acceptbid')->with(['pages' => 'Make Bid', 'data' => $data]);
    }

    // Cross Border Payment
    public function crossBorder(Request $req)
    {

        if ($req->session()->has('email') == false) {
            if (Auth::check() == false) {
                return redirect()->route('login');
            }
        } else {

            $user = User::where('email', session('email'))->first();

            Auth::login($user);
        }
        
        $client = $this->getMyClientInfo(Auth::user()->ref_code);

        if(isset($client) && $client->accountMode == "test"){
            
            return redirect()->route('dashboard')->with('error', 'You are in test mode');
        }

        $data = array(
            'allcountry' => $this->getCountryAndCurrency(),
            'mycountry' => $this->personalCountry(Auth::user()->country),
            'mywallet' => Auth::user()->forexAccount,
            'allbeneficiary' => $this->getBeneficiaries()
        );

        $checker = $this->checkImt(Auth::user()->country);

        if($checker == "false"){
            return back()->with('error', 'This feature is not yet available for your country');
        }

        return view('currencyexchange.crossborder')->with(['pages' => 'Cross Border Payment', 'data' => $data]);
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


                $getactive = EscrowAccount::where('user_id', $thisuser->id)->where('active', 'true')->first();


                $data = $myaccount;
                $message = 'success';
                $status = 200;
                $activeCurrency = $getactive->escrow_id;
            } else {
                $data = [];
                $message = 'Session expired. Please re-login';
                $status = 201;
                $activeCurrency = '';
            }
        } catch (\Throwable $th) {
            $data = [];
            $message = $th->getMessage();
            $status = 400;
            $activeCurrency = '';
        }

        $resData = ['data' => $data, 'message' => $message, 'status' => $status, 'activeCurrency' => $activeCurrency];

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

            if (isset($req->country)) {
                $getmywallet = EscrowAccount::where('user_id', $thisuser->id)->where('country', $req->country)->get();
            } else {
                $getmywallet = EscrowAccount::where('user_id', $thisuser->id)->get();
            }


            if (count($getmywallet) > 0) {
                $data = $getmywallet;
                $message = 'success';
                $status = 200;
            } else {

                if (isset($req->country)) {
                    $message = 'Please create a new wallet for ' . $req->country . ' currency';
                } else {
                    $message = 'Please create a wallet';
                }

                $data = [];
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


    public function getThisFxWallets(Request $req)
    {
        try {
            $thisuser = User::where('api_token', $req->bearerToken())->first();

            $getmywallet = EscrowAccount::where('user_id', $thisuser->id)->where('escrow_id', $req->escrow_id)->first();

            if (isset($getmywallet)) {
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

                        // Check if ID exists
                        $checkExists = EscrowAccount::where('escrow_id', $req->escrow_id)->first();

                        if (isset($checkExists)) {
                            $escrowID = 'ES_' . uniqid() . '_' . strtoupper(date('D'));
                        } else {
                            $escrowID = $req->escrow_id;
                        }




                        // Create New Wallet
                        $query = [
                            'user_id' => $thisuser->id,
                            'escrow_id' => $escrowID,
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

    // FX Make A Bid
    public function makeABid(Request $req)
    {


        try {
            // Check who is in
            $thisuser = User::where('api_token', $req->bearerToken())->first();

            if (isset($thisuser)) {

                // Check if this offer doesnt belong to you

                $checkOffer = MarketPlace::where('order_id', $req->order_id)->where('user_id', $thisuser->id)->first();

                if (isset($checkOffer)) {
                    $data = [];
                    $message = 'You cannot make bid to yourself';
                    $status = 400;
                } else {

                    $market = MarketPlace::where('order_id', $req->order_id)->first();

                    // Check my wallet with this bid by checking my account against the MarketPlace

                    $mywallet = EscrowAccount::where('user_id', $thisuser->id)->where('currencyCode', $market->sell_currencyCode)->first();


                    if (isset($mywallet)) {


                        // Check if already created bid
                        $getBidder = MakeBid::where('order_id', $req->order_id)->where('buyer_id', $thisuser->id)->first();

                        if (isset($getBidder)) {

                            $data = [];
                            $message = 'You have already made a bid on this transaction';
                            $status = 400;
                        } else {

                            $mywalletCheck = EscrowAccount::where('user_id', $thisuser->id)->where('currencyCode', $market->buy_currencyCode)->first();

                            if (isset($mywalletCheck)) {


                                if ($mywalletCheck->wallet_balance >= $req->offer_amount) {

                                    // Add Record to Make a Bid
                                    $query = [
                                        'order_id' => $req->order_id,
                                        'owner_id' => $market->user_id,
                                        'buyer_id' => $thisuser->id,
                                        'bid_rate' => $req->bid_rate,
                                        'bid_amount' => $req->bid_amount,
                                        'offer_amount' => $req->offer_amount
                                    ];

                                    MakeBid::insert($query);


                                    // Debit User Account of the Offer Amount
                                    $walletBal = $mywalletCheck->wallet_balance - $req->offer_amount;
                                    $escrowBal = $mywalletCheck->escrow_balance + $req->offer_amount;

                                    EscrowAccount::where('user_id', $thisuser->id)->where('currencyCode', $market->buy_currencyCode)->update(['wallet_balance' => $walletBal, 'escrow_balance' => $escrowBal]);




                                    $transaction_id = "es-wallet-" . date('dmY') . time();

                                    $activity = "Debit of " . $mywalletCheck->currencyCode . '' . number_format($req->offer_amount, 2) . " from your FX Wallet.";
                                    $credit = 0;
                                    $debit = $req->offer_amount;
                                    $reference_code = $transaction_id;
                                    $balance = 0;
                                    $trans_date = date('Y-m-d');
                                    $status = "Delivered";
                                    $action = "Escrow Wallet debit";
                                    $regards = $thisuser->ref_code;
                                    $statement_route = "escrow wallet";


                                    $this->insFXStatement($mywalletCheck->escrow_id, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, 'on', $thisuser->country, 'confirmed');


                                    $sendMsg = "Hi " . $thisuser->name . ", You have a " . $activity . " Your current FX wallet balance is " . $mywalletCheck->currencyCode . ' ' . number_format($walletBal, 2) . ".";

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


                                    // Log Activities here
                                    $this->createNotification($thisuser->ref_code, $sendMsg);



                                    $data = true;
                                    $message = 'Bid successfully completed';
                                    $status = 200;
                                } else {
                                    $data = [];
                                    $message = 'Insufficient wallet balance!';
                                    $status = 400;
                                }
                            } else {
                                $data = [];
                                $message = 'Please create a ' . $market->buy_currencyCode . ' wallet to be able to make this bid';
                                $status = 400;
                            }
                        }
                    } else {
                        $data = [];
                        $message = 'Please create a ' . $market->sell_currencyCode . ' wallet to be able to make this bid';
                        $status = 400;
                    }
                }
            } else {
                $data = [];
                $message = 'Invalid authorization token!';
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


    public function refreshBids()
    {
        // Get all expired bids in market place...
        $today = Carbon::now()->subDay();
        $getMarkets = MarketPlace::whereDate('expiry', '<=', $today)->where('status', 'Bid Pending')->get();

        if (count($getMarkets) > 0) {

            foreach ($getMarkets as $value) {


                $thisuser = User::where('id', $value->user_id)->first();

                $getescrow = EscrowAccount::where('currencyCode', $value->sell_currencyCode)->where('user_id', $value->user_id)->first();

                $walletBal = $getescrow->wallet_balance;

                // Credit Wallet 
                $creditWallet = $walletBal + $value->sell;


                EscrowAccount::where('user_id', $value->user_id)->where('currencyCode', $value->sell_currencyCode)->update(['wallet_balance' => $creditWallet]);


                // Escrow Wallet Statement

                $transaction_id = "es-wallet-" . date('dmY') . time();

                // Insert Escrow Statement
                $activity = "Wallet credit of " . $thisuser->currencyCode . " " . number_format($value->sell, 2) . " from PaySprint wallet to FX wallet ";
                $credit = $value->sell;
                $debit = 0;
                $reference_code = $transaction_id;
                $balance = 0;
                $trans_date = date('Y-m-d');
                $status = "Delivered";
                $action = "Wallet credit";
                $regards = $thisuser->ref_code;

                $statement_route = "wallet";


                // Senders Escrow statement
                $this->insFXStatement($getescrow->escrow_id, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, 'on', $thisuser->country, "confirmed");


                MarketPlace::whereDate('expiry', '<=', $today)->where('user_id', $value->user_id)->where('status', 'Bid Pending')->delete();


                // This works even if bid is accepted but still pending...

                $getBids = MakeBid::where('order_id', $value->order_id)->get();

                if (count($getBids) > 0) {

                    foreach ($getBids as $marketItem) {

                        // Return Bidding Fee

                        $bidderAccount = EscrowAccount::where('user_id', $marketItem->buyer_id)->where('currencyCode', $value->buy_currencyCode)->first();

                        $offeramount = $bidderAccount->wallet_balance + $marketItem->offer_amount;
                        $escrowBal = $bidderAccount->escrow_balance - $marketItem->offer_amount;

                        EscrowAccount::where('user_id', $marketItem->buyer_id)->where('currencyCode', $value->buy_currencyCode)->update(['wallet_balance' => $offeramount, 'escrow_balance' => $escrowBal]);

                        $getbidders = User::where('id', $marketItem->buyer_id)->first();

                        // Do notification
                        $transaction_id2 = "es-wallet-" . date('dmY') . time();

                        $activity2 = "Reversal of " . $value->buy_currencyCode . '' . number_format($marketItem->offer_amount, 2) . " to your FX Wallet ";
                        $credit2 = $marketItem->offer_amount;
                        $debit2 = 0;
                        $reference_code2 = $transaction_id2;
                        $balance2 = 0;
                        $trans_date2 = date('Y-m-d');
                        $status2 = "Delivered";
                        $action2 = "Escrow Wallet credit";
                        $regards2 = $getbidders->ref_code;
                        $statement_route2 = "escrow wallet";


                        $this->insFXStatement($bidderAccount->escrow_id, $reference_code2, $activity2, $credit2, $debit2, $balance2, $trans_date2, $status2, $action2, $regards2, 1, $statement_route2, 'on', $bidderAccount->country, 'confirmed');
                    }
                }


                $getWallet = EscrowAccount::where('user_id', $thisuser->id)->where('currencyCode', $value->sell_currencyCode)->first();


                $sendMsg = "Hi " . $thisuser->name . ", A " . $activity . "is successfully sent. Your new wallet balance is " . $getWallet->currencyCode . ' ' . number_format($getWallet->wallet_balance, 2) . ".";

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


                Log::info("Currency exchange transaction of " . $getWallet->currencyCode . " " . number_format($value->sell, 2) . " by " . $thisuser->name . " returned back to wallet");

                $this->createNotification($thisuser->ref_code, "Hello " . strtoupper($thisuser->name) . ", " . $sendMsg);

                echo "Done";
            }
        } else {
            Log::info('No expired market today: ' . $today);

            echo 'No expired market today: ' . $today;
        }
    }



    // FX Accept A bid
    public function acceptABid(Request $req)
    {
        try {
            $thisuser = User::where('api_token', $req->bearerToken())->first();

            if (isset($thisuser)) {
                // Get Order Item
                $getOrderItem = MarketPlace::where('order_id', $req->order_id)->first();

                if (isset($getOrderItem)) {

                    // Get the bidding information
                    $biddingInfo = MakeBid::where('order_id', $req->order_id)->where('buyer_id', $req->buyer_id)->first();

                    if (isset($biddingInfo)) {


                        // Transfer Funds to their wallet and update state.
                        $myaccount = EscrowAccount::where('user_id', $req->owner_id)->where('currencyCode', $getOrderItem->buy_currencyCode)->first();
                        $buyeraccount = EscrowAccount::where('user_id', $req->buyer_id)->where('currencyCode', $getOrderItem->sell_currencyCode)->first();


                        $mywalletBalance = $myaccount->wallet_balance + $biddingInfo->offer_amount;
                        $buyerwalletBalance = $buyeraccount->wallet_balance + $biddingInfo->bid_amount;
                        $buyerescrowBalance = $buyeraccount->escrow_balance - $biddingInfo->bid_amount;

                        // Update Wallet Balance
                        EscrowAccount::where('user_id', $req->owner_id)->where('currencyCode', $getOrderItem->buy_currencyCode)->update(['wallet_balance' => $mywalletBalance]);
                        EscrowAccount::where('user_id', $req->buyer_id)->where('currencyCode', $getOrderItem->sell_currencyCode)->update(['wallet_balance' => $buyerwalletBalance, 'escrow_balance' => $buyerescrowBalance]);



                        // Return fee
                        MakeBid::where('order_id', $req->order_id)->where('buyer_id', $req->buyer_id)->update(['status' => 1]);

                        // Get Other account where not accepted
                        $getBids = MakeBid::where('order_id', $req->order_id)->where('status', 0)->get();

                        if (count($getBids) > 0) {

                            foreach ($getBids as $value) {

                                // Return Bidding Fee

                                $bidderAccount = EscrowAccount::where('user_id', $value->buyer_id)->where('currencyCode', $getOrderItem->buy_currencyCode)->first();

                                $offeramount = $bidderAccount->wallet_balance + $value->offer_amount;
                                $escrowBal = $bidderAccount->escrow_balance - $value->offer_amount;

                                EscrowAccount::where('user_id', $value->buyer_id)->where('currencyCode', $getOrderItem->buy_currencyCode)->update(['wallet_balance' => $offeramount, 'escrow_balance' => $escrowBal]);

                                $getbidders = User::where('id', $value->buyer_id)->first();

                                // Do notification
                                $transaction_id = "es-wallet-" . date('dmY') . time();

                                $activity = "Reversal of " . $getOrderItem->buy_currencyCode . '' . number_format($value->offer_amount, 2) . " to your FX Wallet.";
                                $credit = $value->offer_amount;
                                $debit = 0;
                                $reference_code = $transaction_id;
                                $balance = 0;
                                $trans_date = date('Y-m-d');
                                $status = "Delivered";
                                $action = "Escrow Wallet credit";
                                $regards = $getbidders->ref_code;
                                $statement_route = "escrow wallet";


                                $this->insFXStatement($bidderAccount->escrow_id, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, 'on', $myaccount->country, 'confirmed');
                            }
                        }

                        MakeBid::where('order_id', $req->order_id)->where('buyer_id', '!=', $req->buyer_id)->delete();

                        MarketPlace::where('order_id', $req->order_id)->update(['status' => 'Sold', 'color' => 'green']);


                        $transaction_id = "es-wallet-" . date('dmY') . time();

                        $activity1 = "Received " . $myaccount->currencyCode . '' . number_format($biddingInfo->offer_amount, 2) . " to your FX Wallet.";
                        $credit = $biddingInfo->offer_amount;
                        $debit = 0;
                        $reference_code = $transaction_id;
                        $balance = 0;
                        $trans_date = date('Y-m-d');
                        $status = "Delivered";
                        $action = "Escrow Wallet credit";
                        $regards = $thisuser->ref_code;
                        $statement_route = "escrow wallet";


                        $this->insFXStatement($myaccount->escrow_id, $reference_code, $activity1, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, 'on', $myaccount->country, 'confirmed');



                        $getthisbidders = User::where('id', $req->buyer_id)->first();

                        $transaction_id2 = "es-wallet-" . date('dmY') . time();
                        $activity2 = "Received " . $buyeraccount->currencyCode . '' . number_format($biddingInfo->bid_amount, 2) . " to your FX Wallet.";
                        $credit2 = $biddingInfo->bid_amount;
                        $debit2 = 0;
                        $reference_code2 = $transaction_id2;
                        $balance2 = 0;
                        $trans_date2 = date('Y-m-d');
                        $status2 = "Delivered";
                        $action2 = "Escrow Wallet credit";
                        $regards2 = $getthisbidders->ref_code;
                        $statement_route2 = "escrow wallet";


                        $this->insFXStatement($myaccount->escrow_id, $reference_code, $activity1, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, 'on', $myaccount->country, 'confirmed');

                        $this->insFXStatement($buyeraccount->escrow_id, $reference_code2, $activity2, $credit2, $debit2, $balance2, $trans_date2, $status2, $action2, $regards2, 1, $statement_route2, 'on', $buyeraccount->country, 'confirmed');


                        $sendMsg1 = "Hi " . $thisuser->name . ", You have a " . $activity1 . " Your current FX wallet balance is " . $myaccount->currencyCode . ' ' . number_format($mywalletBalance, 2) . ".";

                        $sendMsg2 = "Hi " . $getthisbidders->name . ", You have a " . $activity2 . " Your current FX wallet balance is " . $buyeraccount->currencyCode . ' ' . number_format($buyerwalletBalance, 2) . ".";

                        $usergetPhone = User::where('email', $thisuser->email)->where(
                            'telephone',
                            'LIKE',
                            '%+%'
                        )->first();

                        $usergetPhone2 = User::where('email', $getthisbidders->email)->where(
                            'telephone',
                            'LIKE',
                            '%+%'
                        )->first();

                        if (isset($usergetPhone) && isset($usergetPhone2)) {

                            $sendPhone = $thisuser->telephone;
                            $sendPhone2 = $getthisbidders->telephone;
                        } else {
                            $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
                            $sendPhone2 = "+" . $getthisbidders->code . $getthisbidders->telephone;
                        }

                        if ($thisuser->country == "Nigeria") {

                            $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                            $this->sendSms($sendMsg1, $correctPhone);
                        } else {
                            $this->sendMessage($sendMsg1, $sendPhone);
                        }


                        if ($getthisbidders->country == "Nigeria") {

                            $correctPhone2 = preg_replace("/[^0-9]/", "", $sendPhone2);
                            $this->sendSms($sendMsg2, $correctPhone2);
                        } else {
                            $this->sendMessage($sendMsg2, $sendPhone2);
                        }

                        // Log Activities here
                        $this->createNotification($thisuser->ref_code, $sendMsg1);
                        $this->createNotification($getthisbidders->ref_code, $sendMsg2);


                        // Send Response
                        $data = true;
                        $message = 'Transaction successfull. Funds transferred to your ' . strtoupper($getOrderItem->buy_currencyCode) . ' wallet account';
                        $status = 200;
                    } else {
                        $data = [];
                        $message = 'No record found for ORDER ID: ' . $req->order_id;
                        $status = 400;
                    }
                } else {
                    $data = [];
                    $message = 'No record found for ORDER ID: ' . $req->order_id;
                    $status = 400;
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


    public function getOtherWallets(Request $req)
    {


        try {

            $thisuser = User::where('api_token', $req->bearerToken())->first();

            if (isset($thisuser)) {

                // Get escrow wallet
                $mywallets = $this->getMyOtherWallets($req->fromWallet, $thisuser->id);

                $thiswallet = EscrowAccount::where('escrow_id', $req->fromWallet)->where('user_id', $thisuser->id)->first();

                if (count($mywallets) > 0) {

                    $data = $mywallets;
                    $message = 'success';
                    $status = 200;
                    $thiswallet = $thiswallet->currencyCode;
                } else {
                    $data = [];
                    $message = 'Kindly add other wallets';
                    $status = 400;
                    $thiswallet = '';
                }
            } else {

                $data = [];
                $message = 'Invalid Authorization token. Kindly login and try again';
                $status = 400;
                $thiswallet = '';
            }
        } catch (\Throwable $th) {
            $data = [];
            $message = $th->getMessage();
            $status = 400;
            $thiswallet = '';
        }

        $resData = ['data' => $data, 'message' => $message, 'status' => $status, 'thiswallet' => $thiswallet];

        return $this->returnJSON($resData, $status);
    }


    public function getAllInvoiceToFx(Request $req)
    {

        try {

            $thisuser = User::where('api_token', $req->bearerToken())->first();

            $mydata = ImportExcel::select('import_excel.*', 'invoice_payment.*')->join('invoice_payment', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')->where('import_excel.payee_email', $thisuser->email)->orderBy('import_excel.created_at', 'DESC')->get();

            if (count($mydata) > 0) {
                $newdata = ImportExcel::where('payee_email', $thisuser->email)->where('payment_status', 0)->orderBy('created_at', 'DESC')->get();
                $data = array_merge($mydata->toArray(), $newdata->toArray());
            } else {
                $data = ImportExcel::where('payee_email', $thisuser->email)->orderBy('created_at', 'DESC')->get();
            }

            $data = $data;
            $message = 'success';
            $status = 200;
        } catch (\Throwable $th) {
            $data = [];
            $message = $th->getMessage();
            $status = 400;
        }

        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

        return $this->returnJSON($resData, $status);
    }


    public function getPaidInvoiceToFx(Request $req)
    {

        try {

            $thisuser = User::where('api_token', $req->bearerToken())->first();

            $data = ImportExcel::where('payee_email', $thisuser->email)->where('payment_status', 1)->orderBy('created_at', 'DESC')->get();


            if (count($data) > 0) {
                $data = $data;
                $message = 'success';
                $status = 200;
            } else {

                $data = [];
                $message = 'No paid invoice';
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


    public function getPendingInvoiceToFx(Request $req)
    {

        try {

            $thisuser = User::where('api_token', $req->bearerToken())->first();

            $data = ImportExcel::where('payee_email', $thisuser->email)->where('payment_status', "!=", 1)->orderBy('created_at', 'DESC')->get();


            if (count($data) > 0) {
                $data = $data;
                $message = 'success';
                $status = 200;
            } else {

                $data = [];
                $message = 'No pending invoice';
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



    public function getAllCrossBorderPayment(Request $req)
    {

        try {

            $thisuser = User::where('api_token', $req->bearerToken())->first();


            $data = CrossBorder::where('ref_code', $thisuser->ref_code)->where('status', true)->orderBy('created_at', 'DESC')->get();


            if (count($data) > 0) {
                $data = $data;
                $message = 'success';
                $status = 200;
            } else {

                $data = [];
                $message = 'No payment made yet';
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


    public function getPendingCrossBorderPayment(Request $req)
    {

        try {

            $thisuser = User::where('api_token', $req->bearerToken())->first();


            $data = CrossBorder::where('ref_code', $thisuser->ref_code)->where('status', false)->orderBy('created_at', 'DESC')->get();


            if (count($data) > 0) {
                $data = $data;
                $message = 'success';
                $status = 200;
            } else {

                $data = [];
                $message = 'No pending payment';
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

    // Calculate currency to send
    public function convertMoneyToTransfer(Request $req)
    {


        try {
            $thisuser = User::where('api_token', $req->bearerToken())->first();

            if (isset($thisuser)) {

                // Check balance in the fromWallet

                $fromWallet = EscrowAccount::where('escrow_id', $req->fromWallet)->where('user_id', $thisuser->id)->first();

                $toWallet = EscrowAccount::where('escrow_id', $req->toWallet)->where('user_id', $thisuser->id)->first();

                $markuppercent = $this->markupPercentage();

                $markValue = (1 + ($markuppercent[0]->percentage / 100));

                if (isset($fromWallet)) {

                    if ($fromWallet->wallet_balance < $req->amount) {

                        $data = [];
                        $message = 'Insufficient wallet balance';
                        $status = 400;

                        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

                        return $this->returnJSON($resData, $status);
                    }


                    if ($toWallet->currencyCode == 'USD' || $toWallet->currencyCode == 'EUR' || $toWallet->currencyCode == 'GBP') {
                        //Convert Money
                        $getconvertion = $this->getOfficialConversionRate($toWallet->currencyCode, $fromWallet->currencyCode);

                        // Mark up here ...

                        $convInfo = $markValue * ($req->amount / $getconvertion);
                    } else {
                        //Convert Money
                        $getconvertion = $this->getOfficialConversionRate($fromWallet->currencyCode, $toWallet->currencyCode);

                        // Mark down here ...

                        $convInfo = ($getconvertion * $req->amount) / $markValue;
                    }



                    $respData = [
                        'convamount' => $convInfo,
                        'toCurrency' => $toWallet->currencyCode,
                        'rate' => $getconvertion
                    ];

                    $data = $respData;
                    $message = 'success';
                    $status = 200;
                } else {
                    $data = [];
                    $message = 'This wallet is not associated with your account';
                    $status = 400;
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


    // Fetch currency
    public function fetchCurrency()
    {

        // Get Markup
        $markuppercent = $this->markupPercentage();

        $markValue = (1 + ($markuppercent[0]->percentage / 100));

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

        // dd(response()->json($result->quotes));


        return response()->json($result->quotes);
    }

    // Transfer your fx fund
    public function transferFXFund(Request $req)
    {
        try {

            $thisuser = User::where('api_token', $req->bearerToken())->first();

            if (isset($thisuser)) {

                // check transaction pin



                if (Hash::check($req->transaction_pin, $thisuser->transaction_pin)) {

                    // Check balance in the fromWallet

                    $fromWallet = EscrowAccount::where('escrow_id', $req->fx_wallet_from)->where('user_id', $thisuser->id)->first();

                    $toWallet = EscrowAccount::where('escrow_id', $req->fx_wallet_to)->where('user_id', $thisuser->id)->first();



                    if (isset($fromWallet)) {

                        if ($fromWallet->wallet_balance < $req->amount) {

                            $data = [];
                            $message = 'Insufficient wallet balance';
                            $status = 400;

                            $resData = ['data' => $data, 'message' => $message, 'status' => $status];

                            return $this->returnJSON($resData, $status);
                        }

                        $markuppercent = $this->markupPercentage();

                        $markValue = (1 + ($markuppercent[0]->percentage / 100));


                        if ($toWallet->currencyCode == 'USD' || $toWallet->currencyCode == 'EUR' || $toWallet->currencyCode == 'GBP') {
                            //Convert Money
                            $getconvertion = $this->getOfficialConversionRate($toWallet->currencyCode, $fromWallet->currencyCode);

                            // Mark up here ...

                            $convamount = $markValue * ($req->amount / $getconvertion);
                        } else {
                            //Convert Money
                            $getconvertion = $this->getOfficialConversionRate($fromWallet->currencyCode, $toWallet->currencyCode);

                            // Mark down here ...

                            $convamount = ($getconvertion * $req->amount) / $markValue;
                        }



                        //Convert Money
                        // $getconvertion = $this->getOfficialConversionRate($fromWallet->currencyCode, $toWallet->currencyCode);

                        // $convamount = $getconvertion * $req->amount;

                        // Update Wallet Statements
                        $fromwalletBalance = $fromWallet->wallet_balance - $req->amount;
                        $towalletBalance = $toWallet->wallet_balance + $convamount;


                        EscrowAccount::where('escrow_id', $req->fx_wallet_from)->where('user_id', $thisuser->id)->update(['wallet_balance' => $fromwalletBalance]);
                        EscrowAccount::where('escrow_id', $req->fx_wallet_to)->where('user_id', $thisuser->id)->update(['wallet_balance' => $towalletBalance]);

                        // Generate Statement and Notification


                        $transaction_id = "es-wallet-" . date('dmY') . time();

                        $activity = "Added " . $toWallet->currencyCode . '' . number_format($convamount, 2) . " from " . $fromWallet->currencyCode . " wallet to your " . $toWallet->currencyCode . " wallet";
                        $credit = $convamount;
                        $debit = 0;
                        $reference_code = $transaction_id;
                        $balance = 0;
                        $trans_date = date('Y-m-d');
                        $status = "Delivered";
                        $action = "Escrow Wallet credit";
                        $regards = $thisuser->ref_code;
                        $statement_route = "escrow wallet";


                        $this->insFXStatement($toWallet->escrow_id, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, 'on', $thisuser->country, 'confirmed');



                        $transaction_id2 = "es-wallet-" . date('dmY') . time();

                        $activity2 = "Transferred " . $fromWallet->currencyCode . '' . number_format($req->amount, 2) . " from " . $fromWallet->currencyCode . " wallet to your " . $toWallet->currencyCode . " wallet";
                        $credit2 = 0;
                        $debit2 = $req->amount;
                        $reference_code2 = $transaction_id2;
                        $balance2 = 0;
                        $trans_date2 = date('Y-m-d');
                        $status2 = "Delivered";
                        $action2 = "Escrow Wallet credit";
                        $regards = $thisuser->ref_code;
                        $statement_route2 = "escrow wallet";


                        $this->insFXStatement($fromWallet->escrow_id, $reference_code2, $activity2, $credit2, $debit2, $balance2, $trans_date2, $status2, $action2, $regards, 1, $statement_route2, 'on', $thisuser->country, 'confirmed');

                        $sendMsg = "Hi " . $thisuser->name . ", You have " . $activity . " Your current fx wallet balance is " . $toWallet->currencyCode . ' ' . number_format($towalletBalance, 2) . ".";

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

                        $this->createNotification($thisuser->ref_code, $sendMsg);


                        // Markup value to sender local currency i.e USD/NGN = 584.33

                        $markedupRate = $this->getConversionRate($fromWallet->currencyCode, $toWallet->currencyCode);

                        // Customer Official rate i.e USD/CAD = 1.22
                        $officialRate = $this->getOfficialConversionRate($fromWallet->currencyCode, $toWallet->currencyCode);


                        // Get Rate to Merchant currency
                        $convertedRate = $markedupRate / $officialRate;


                        $newProfit = $markedupRate - $convertedRate;



                        $profit_sender = $markedupRate - $getconvertion;

                        $profit_receiver = $markedupRate / $profit_sender;


                        // Insert Commission Info
                        $commissionQuery = [
                            'invoice_no' => $fromWallet->escrow_id, 'sender' => $thisuser->name, 'receiver' => $thisuser->name, 'invoice_amount' => $req->amount, 'invoiced_currency' => $fromWallet->currencyCode, 'official_rate' => $getconvertion, 'markedup_rate' => $markedupRate, 'profit_sender' => $newProfit, 'sender_currency' => $thisuser->currencyCode, 'profit_receiver' => $profit_receiver, 'receiver_currency' => $thisuser->currencyCode, 'holder' => 'currency fx'
                        ];


                        InvoiceCommission::insert($commissionQuery);


                        $data = true;
                        $message = 'Transaction successful';
                        $status = 200;
                    } else {
                        $data = [];
                        $message = 'Wallet information not found. Please try again.';
                        $status = 400;
                    }
                } else {
                    $data = [];
                    $message = 'Incorrect transaction pin';
                    $status = 400;
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


                /*
                        1. Check FX wallet account currency type
                        2. If same with primary wallet currency, check (wallet balance - minimum balance) > amount to add, then proceed to debit wallet and credit fx wallet
                        3. If foreign currency, convert the amount in official rate, then deduct from the (wallet balance - minimum balance) > amount conversion, then proceed to debit wallet and credit fx wallet
                        4. Send success of failed
                        5. Send notification.
                    */

                if ($req->fx_payment_method == "PaySprint Wallet") {


                    if ($thisuser->accountType == "Individual") {
                        $subminType = "Consumer Monthly Subscription";
                    } else {
                        $subminType = "Merchant Monthly Subscription";
                    }


                    $minBal = $this->maintenanceBalanceWithdrawal($subminType, $thisuser->country);


                    if ($thisuser->currencyCode == $myaccount->currencyCode) {

                        $walletBal = $thisuser->wallet_balance - $minBal;

                        if ($walletBal < $req->fx_amount) {
                            $data = [];
                            $message = "Insufficient wallet balance";
                            $status = 400;
                        } else {

                            $amount = $thisuser->wallet_balance - $req->fx_amount;

                            User::where('api_token', $req->bearerToken())->update(['wallet_balance' => $amount]);

                            $transaction_id = "es-wallet-" . date('dmY') . time();

                            $activity = "Added " . $myaccount->currencyCode . '' . number_format($req->fx_amount, 2) . " from PaySprint wallet to your FX Wallet.";
                            $credit = $req->fx_amount;
                            $debit = 0;
                            $reference_code = $transaction_id;
                            $balance = 0;
                            $trans_date = date('Y-m-d');
                            $status = "Delivered";
                            $action = "Escrow Wallet credit";
                            $action2 = "Wallet debit";
                            $regards = $thisuser->ref_code;
                            $statement_route = "escrow wallet";
                            $statement_route2 = "wallet";

                            $fxBalance = $myaccount->wallet_balance + $req->fx_amount;

                            EscrowAccount::where('escrow_id', $req->fx_wallet)->update(['wallet_balance' => $fxBalance]);

                            $this->insFXStatement($req->fx_wallet, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, 'on', $myaccount->country, 'confirmed');


                            $this->insStatement($thisuser->email, $reference_code, $activity, $debit, $credit, $balance, $trans_date, $status, $action2, $regards, 1, $statement_route2, 'on', $thisuser->country);

                            $sendMsg = "Hi " . $thisuser->name . ", You have " . $activity . " Your current fx wallet balance is " . $myaccount->currencyCode . ' ' . number_format($fxBalance, 2) . ".";

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

                            // Log Activities here
                            $this->createNotification($thisuser->ref_code, $sendMsg);

                            $this->slack('Congratulations!, ' . $thisuser->name . ' ' . $sendMsg, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));

                            $getAccount = EscrowAccount::where('escrow_id', $req->fx_wallet)->first();

                            $data = $getAccount;
                            $message = "Success | Your " . $myaccount->currencyCode . " wallet was successfully credited";
                            $status = 200;
                        }
                    } else {
                        // Do conversion...
                        $getRate = $this->getOfficialConversionRate($myaccount->currencyCode, $thisuser->currencyCode);

                        $fxAmount = $getRate * $req->fx_amount;

                        $walletBal = $thisuser->wallet_balance - $minBal;


                        if ($walletBal < $fxAmount) {
                            $data = [];
                            $message = "Insufficient wallet balance";
                            $status = 400;
                        } else {

                            $amount = $walletBal - $fxAmount;

                            User::where('api_token', $req->bearerToken())->update(['wallet_balance' => $amount]);

                            $transaction_id = "es-wallet-" . date('dmY') . time();

                            $activity = "Added " . $myaccount->currencyCode . '' . number_format($req->fx_amount, 2) . " from PaySprint wallet to your FX Wallet.";
                            $credit = $req->fx_amount;
                            $debit = 0;
                            $reference_code = $transaction_id;
                            $balance = 0;
                            $trans_date = date('Y-m-d');
                            $status = "Delivered";
                            $action = "Escrow Wallet credit";
                            $regards = $thisuser->ref_code;
                            $statement_route = "escrow wallet";

                            $fxBalance = $myaccount->wallet_balance + $req->fx_amount;

                            EscrowAccount::where('escrow_id', $req->fx_wallet)->update(['wallet_balance' => $fxBalance]);

                            $this->insFXStatement($req->fx_wallet, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, 'on', $myaccount->country, 'confirmed');

                            $sendMsg = "Hi " . $thisuser->name . ", You have " . $activity . " Your current fx wallet balance is " . $myaccount->currencyCode . ' ' . number_format($fxBalance, 2) . ".";

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

                            // Log Activities here
                            $this->createNotification($thisuser->ref_code, $sendMsg);

                            $this->slack('Congratulations!, ' . $thisuser->name . ' ' . $sendMsg, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));

                            $getAccount = EscrowAccount::where('escrow_id', $req->fx_wallet)->first();

                            $data = $getAccount;
                            $message = "Success | Your " . $myaccount->currencyCode . " wallet was successfully credited";
                            $status = 200;
                        }
                    }
                } else {
                    if (isset($myaccount)) {

                        $transaction_id = "es-wallet-" . date('dmY') . time();

                        $activity = "Added " . $myaccount->currencyCode . '' . number_format($req->fx_amount, 2) . " to FX Wallet.";
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

                            $sendMsg = "Hi " . $thisuser->name . ", You have " . $activity . " Your transaction status is PENDING. Your current fx wallet balance is " . $myaccount->currencyCode . ' ' . number_format($myaccount->wallet_balance, 2) . ".";
                        } else {

                            $newBalance = $myaccount->wallet_balance + $req->fx_amount;

                            EscrowAccount::where('escrow_id', $req->fx_wallet)->update(['wallet_balance' => $newBalance]);

                            $myBalance = EscrowAccount::where('escrow_id', $req->fx_wallet)->first();

                            $this->insFXStatement($req->fx_wallet, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, 'on', $thisuser->country, 'confirmed');

                            $sendMsg = "Hi " . $thisuser->name . ", You have " . $activity . " Your current fx wallet balance is " . $myaccount->currencyCode . ' ' . number_format($myBalance, 2) . ".";

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

    public function getAllOrders(Request $req)
    {



        try {
            $thisuser = User::where('api_token', $req->bearerToken())->first();
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



        try {

            $thisuser = User::where('api_token', $req->bearerToken())->first();

            if (isset($thisuser)) {
                $market = MarketPlace::where('status', 'Sold')->orderBy('created_at', 'DESC')->get();

                if (count($market) > 0) {
                    $data = $market;
                    $message = 'success';
                    $status = 200;
                } else {
                    $data = [];
                    $message = 'No closed orders yet';
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



        try {

            $thisuser = User::where('api_token', $req->bearerToken())->first();
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



        try {

            $thisuser = User::where('api_token', $req->bearerToken())->first();

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




    public function getMyRecentBids(Request $req)
    {
        try {
            $thisuser = User::where('api_token', $req->bearerToken())->first();

            $newData = [];

            if (isset($thisuser)) {

                // Get Bids
                $data = MakeBid::where('owner_id', $thisuser->id)->groupBy('order_id')->get();


                foreach ($data as $value) {
                    $marketPlace = MarketPlace::where('order_id', $value->order_id)->first();
                    $thisbids = MakeBid::where('owner_id', $thisuser->id)->where('order_id', $value->order_id)->count();

                    if(isset($marketPlace->sell_currencyCode)){
                        $value['sell_currencyCode'] = $marketPlace->sell_currencyCode;
                        $value['buy_currencyCode'] = $marketPlace->buy_currencyCode;
                        $value['count'] = $thisbids;
                        $value['buying'] = $marketPlace->buy;

                        $newData[] = $value;
                    }
                    
                }


                if (count($newData) > 0) {
                    $data = $newData;
                    $message = 'success';
                    $status = 200;
                } else {
                    $data = [];
                    $message = 'No record';
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


    public function getThisParticularBids(Request $req)
    {
        try {
            $thisuser = User::where('api_token', $req->bearerToken())->first();

            $newData = [];

            if (isset($thisuser)) {

                // Get Bids
                $data = MakeBid::where('owner_id', $thisuser->id)->where('order_id', $req->get('orderId'))->get();

                foreach ($data as $value) {
                    $marketPlace = MarketPlace::where('order_id', $value->order_id)->first();

                    $value['sell_currencyCode'] = $marketPlace->sell_currencyCode;
                    $value['buy_currencyCode'] = $marketPlace->buy_currencyCode;
                    $value['buying'] = $marketPlace->buy;

                    $newData[] = $value;
                }


                if (count($newData) > 0) {
                    $data = $newData;
                    $message = 'success';
                    $status = 200;
                } else {
                    $data = [];
                    $message = 'No record';
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


    public function insStatement($email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, $state, $statement_route, $country)
    {
        Statement::insert(['user_id' => $email, 'reference_code' => $reference_code, 'activity' => $activity, 'credit' => $credit, 'debit' => $debit, 'balance' => $balance, 'trans_date' => $trans_date, 'status' => $status, 'action' => $action, 'regards' => $regards, 'state' => $state, 'statement_route' => $statement_route, 'country' => $country]);
    }


    public function insFXStatement($email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, $state, $statement_route, $auto_deposit, $country = null, $confirmation)
    {
        FxStatement::insert(['user_id' => $email, 'reference_code' => $reference_code, 'activity' => $activity, 'credit' => $credit, 'debit' => $debit, 'balance' => $balance, 'trans_date' => $trans_date, 'status' => $status, 'action' => $action, 'regards' => $regards, 'state' => $state, 'statement_route' => $statement_route, 'auto_deposit' => $auto_deposit, 'country' => $country, 'confirmation' => $confirmation]);
    }


    public function checkImt($country){
        $imtCountry = AllCountries::where('name', $country)->first();

        return $imtCountry->imt;
    }
}