<?php

namespace App\Http\Controllers;

use App\AllCountries;
use App\MarketPlace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\User;
use App\EscrowAccount;

use App\Traits\MyFX;

class CurrencyFxController extends Controller
{

    use MyFX;

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
                    'currencyCode' => 'required|string',
                ]);

                if ($validator->passes()) {

                    $allcountry = AllCountries::where('name', $req->currencyCode)->first();


                    // Check Escrow wallet
                    $checkAccount = EscrowAccount::where('user_id', $thisuser->id)->where('currencyCode', $allcountry->currencyCode)->first();

                    if (isset($checkAccount)) {
                        $data = [];
                        $message = 'You have already created a wallet in ' . $req->currencyCode . ' (' . strtoupper($allcountry->currencyCode) . ')';
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
                        $message = 'You have successfully added  ' . $req->currencyCode . '(' . $allcountry->currencyCode . ') to your FX Account. Proceed to fund your wallet';

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

    //TODO:: Pending Orders
    public function getPendingOrders(Request $req)
    {
        $thisuser = User::where('api_token', $req->bearerToken())->first();


        try {
            if (isset($thisuser)) {
                $market = MarketPlace::where('status', 'Bid Pending')->orderBy('created_at', 'DESC')->get();

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

    //TODO:: My Orders
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
}