<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Validator;

use App\User as User;
use App\Tax as Tax;

class TaxController extends Controller
{
    public function setupTax(Request $req){
        $validator = Validator::make($req->all(), [
                'name' => 'required|string',
                'rate' => 'required|string',
                'agency' => 'required|string',
        ]);

        if($validator->passes()){

            $thisuser = User::where('api_token', $req->bearerToken())->first();

            Tax::insert(['user_id' => $thisuser->id, 'name' => $req->name, 'rate' => $req->rate, 'agency' => $req->agency]);

            $data = Tax::where('user_id', $thisuser->id)->orderBy('created_at', 'DESC')->get();

            $status = 200;
            $message = "Saved";


        }
        else{

            $error = implode(",",$validator->messages()->all());

            $data = [];
            $status = 400;
            $message = $error;

        }


        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

        return $this->returnJSON($resData, $status);
    }


    public function editTax(Request $req){
        $validator = Validator::make($req->all(), [
                'name' => 'required|string',
                'rate' => 'required|string',
                'agency' => 'required|string',
        ]);

        if($validator->passes()){

            $thisuser = User::where('api_token', $req->bearerToken())->first();

            Tax::where('id', $req->id)->update(['name' => $req->name, 'rate' => $req->rate, 'agency' => $req->agency]);

            $data = Tax::where('user_id', $thisuser->id)->orderBy('created_at', 'DESC')->get();

            $status = 200;
            $message = "Saved";


        }
        else{

            $error = implode(",",$validator->messages()->all());

            $data = [];
            $status = 400;
            $message = $error;

        }


        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

        return $this->returnJSON($resData, $status);
    }



    public function deleteTax(Request $req){


            $thisuser = User::where('api_token', $req->bearerToken())->first();

            Tax::where('id', $req->id)->delete();

            $data = Tax::where('user_id', $thisuser->id)->orderBy('created_at', 'DESC')->get();

            $status = 200;
            $message = "Saved";


        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

        return $this->returnJSON($resData, $status);
    }


    public function getTaxDetail(Request $req){


            $thisuser = User::where('api_token', $req->bearerToken())->first();

            $taxRec = Tax::where('id', $req->id)->first();

            // Tax amount in %...
            $taxAmount = ($taxRec->rate / 100) * $req->amount;

            $totalAmount = $req->amount + $taxAmount;

            $data['taxAmount'] = $taxAmount;
            $data['totalAmount'] = $totalAmount;
            $status = 200;
            $message = "success";

        $resData = ['data' => $data, 'message' => $message, 'status' => $status];


        return $this->returnJSON($resData, $status);
    }
}
