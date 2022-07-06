<?php

namespace App\Http\Controllers;

use App\FlutterwaveModel;

use \App\Traits\Flutterwave;
use App\User;
use Illuminate\Http\Request;

class FlutterwaveController extends Controller
{
    use Flutterwave;

    public function initiateNewAccountNumber($email, $bvn, $phone, $firstName, $lastName, $ref_code){

        try {
            $response = $this->createVirtualAccountNumber($email, $bvn, $phone, $firstName, $lastName);

            FlutterwaveModel::updateOrCreate([
                "userId" => $ref_code,
                "account_number" => $response->data->account_number,
                "order_ref" => $response->data->order_ref,
                "bank_name" => $response->data->bank_name,
                "accountName" => "{$firstName} {$lastName}",
                "status" => $response->message,
            ]);

            User::where('ref_code', $ref_code)->update(['virtual_account' => $response->data->account_number]);


            return $response;

        } catch (\Throwable $th) {
            FlutterwaveModel::updateOrCreate([
                "userId" => $ref_code,
                "account_number" => "",
                "order_ref" => "",
                "accountName" => "",
                "status" => $th->getMessage()
            ]);

            return $th->getMessage();
        }


    }
    public function initiategetVirtualAccountNumber($refCode)
    {
        try {
        $getfluttewaveAccount = FlutterwaveModel::where('userId', $refCode)->first();

        if(isset($getfluttewaveAccount) && $getfluttewaveAccount->account_number != ""){
            $result = $this->getVirtualAccountNumber($getfluttewaveAccount->order_ref);

            $response = $result->data;
        }
        else{
            $response = [
                "data" => [],
            ];
        }

        } catch (\Throwable $th) {
            $response = [
                "data" => $th->getMessage()
            ];
        }

        return $response;


    }

    public function flutterwaveWebhook(Request $req)
    {
        dd($req->all());
    }
}