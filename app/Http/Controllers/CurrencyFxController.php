<?php

namespace App\Http\Controllers;

use App\MarketPlace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\User;

class CurrencyFxController extends Controller
{


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



        return view('currencyexchange.index');
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


    public function getActiveOrders(Request $req)
    {
        $thisuser = User::where('api_token', $req->bearerToken())->first();


        try {
            if (isset($thisuser)) {
                $market = MarketPlace::where('user_id', '!=', $thisuser->id)->where('expiry', '>=', date('d F Y'))->orderBy('created_at', 'DESC')->get();

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
}