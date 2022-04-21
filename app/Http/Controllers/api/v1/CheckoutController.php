<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Traits\Checkout;

class CheckoutController extends Controller
{
    use Checkout;
    // Intialize Transaction
    public function initialize(Request $req)
    {

        $validator = Validator::make($req->all(), [
            'email' => 'required|string|regex:/(.+)@(.+)\.(.+)/i',
            'amount' => 'required',
            'currencyCode' => 'required|string',
        ]);


        if ($validator->fails()) {

            $error = implode(",", $validator->messages()->all());

            $data = [];
            $status = 400;
            $message = $error;
        } else {

            try {

                $data = $this->getAuthUrl('initialize', $req->all(), $req->bearerToken());



                // $data = [

                //     "authorization_url" => "https://checkout.paystack.com/0peioxfhpn",
                //     "access_code" => "0peioxfhpn",
                //     "reference" => "7PVGX8MEk85tgeEpVDtD"
                // ];
                // $status = 400;
                // $message = $error;


            } catch (\Throwable $th) {
                $data = [];
                $status = 400;
                $message = $th->getMessage();
            }
        }

        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

        return $this->returnJSON($resData, $status);
    }


    // Verify Transaction
    public function verify(Request $req)
    {
    }


    // List Transaction
    public function listTranasaction(Request $req)
    {
    }


    // Fetch Transaction
    public function fetchTransaction(Request $req)
    {
    }
}
