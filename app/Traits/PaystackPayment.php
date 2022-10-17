<?php

namespace App\Traits;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Mail;

use App\User as User;

use App\ListOfBanks as ListOfBanks;

use App\Mail\sendEmail;

use Twilio\Rest\Client;


trait PaystackPayment{

    public $baseUrl;
    public $curlPost;

    // Inititalize Transactions
    public function initTransaction(){

    }


    // Verify Transactions
    public function verifyTransaction($transaction){

        $this->baseUrl = 'https://api.paystack.co/transaction/verify/'.$transaction;

        $data = $this->doCurlGet();


        return $data;

    }


    public function verifyAccountNumber($account_number, $code){
        $this->baseUrl = "https://api.paystack.co/bank/resolve?account_number=".$account_number."&bank_code=".$code;

        $data = $this->doCurlGet();


        return $data;

    }

    // Verify BVN
    public function verifyBVN($bvn, $account_number, $bank_code, $name, $apiToken){

        $username = explode(" ", $name);

        if(is_array($username)){

            if(isset($username[0])){

                $userlastname = $username[0];
            }
            else{
                $userlastname = "";

            }

            if(isset($username[1])){
                $userfirstname = $username[1];
            }
            else{
                $userfirstname = "";
            }


            $lastname = $userfirstname;
            $firstname = $userlastname;


        }
        else{
            $firstname = $name;
            $lastname = "";
        }




        // $this->baseUrl = "https://api.paystack.co/bvn/match";

        // $this->curlPost = [
        //     "bvn" => $bvn,
        //     "account_number" => $account_number,
        //     "bank_code" => $bank_code,
        //     "first_name" => $firstname,
        //     "last_name" => $lastname
        // ];

        $userDetail = User::where('api_token', $apiToken)->first();

        $this->baseUrl = env('VERIFIED_AFRICA_URL');

        $monthNum  = $userDetail->monthOfBirth;
        $monthName = date('M', mktime(0, 0, 0, $monthNum, 10));

        $this->curlPost = json_encode([
            'searchParameter' => $bvn,
            'verificationType' => "BVN-BOOLEAN-MATCH",
            'firstName' => $lastname,
            'lastName' => $firstname,
            'phone' => $userDetail->telephone,
            'email' => $userDetail->email,
            'dob' => $userDetail->dayOfBirth.'-'.$monthName.'-'.$userDetail->yearOfBirth
        ]);



        $data = $this->verifyMyBVN();

        return $data;


        // $data = $this->doCurlPost();

        // return $data;
    }


    // BVN Verification Charge
    public function bvnVerificationCharge($api_token){

        $thisuser = User::where('api_token', $api_token)->where('country', 'Nigeria')->first();

        if(isset($thisuser) && $thisuser->wallet_balance > 15){

            if($thisuser->bvn_verification == 1){
                $data = "charge";
            }
            else{
                $data = "no charge";
            }
        }
        else{
            $data = "no charge";
        }



        return $data;
    }




    // Get List of Banks
    public function listOfBanks(){

        $this->baseUrl = 'https://api.paystack.co/bank';

        $data = $this->doCurlGet();



        if($data->status == true){
            // Insert or Create Bank Record
            $query = $data->data;

            foreach($query as $key => $value){

                $info = [
                    'name' => $value->name, 'slug' => $value->slug, 'code' => $value->code, 'longcode' => $value->longcode, 'gateway' => $value->gateway, 'pay_with_bank' => $value->pay_with_bank, 'active' => $value->active, 'is_deleted' => $value->is_deleted, 'country' => $value->country, 'currency' => $value->currency, 'type' => $value->type
                ];

                ListOfBanks::updateOrCreate(['code' => $value->code], $info);

            }

        }

        Log::info("List of Banks updated for Nigeria");

    }

    public function getBankList(){
        $data = ListOfBanks::orderBy('name', 'ASC')->get();

        return $data;
    }




    public function doCurlGet(){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $this->baseUrl,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.env('PAYSTACK_LOCAL_SECRET_KEY')
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return json_decode($response);
    }

    public function doCurlPost(){


        $fields_string = http_build_query($this->curlPost);
        //open connection
        $ch = curl_init();

        //set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL, $this->baseUrl);
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer ".env('PAYSTACK_SECRET_KEY'),
            "Cache-Control: no-cache",
        ));

        //So that curl_exec returns the contents of the cURL; rather than echoing it
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);

        //execute post
        $result = curl_exec($ch);

        return json_decode($result) ;
    }



    // Verified Africa Module
    public function verifyMyBVN(){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $this->baseUrl,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $this->curlPost,
        CURLOPT_HTTPHEADER => array(
            'apiKey: '.env('VERIFIED_AFRICA_APIKEY'),
            'userid: '.env('VERIFIED_AFRICA_USERID'),
            'Content-Type: application/json'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return json_decode($response) ;
    }

}
