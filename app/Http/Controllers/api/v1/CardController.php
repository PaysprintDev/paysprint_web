<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Log;

use App\User as User;
use App\AddCard as AddCard;
use App\AddBank as AddBank;
use App\AddBeneficiary as AddBeneficiary;
use App\CardIssuer as CardIssuer;

class CardController extends Controller
{


    public function getCard(Request $req){
        // Get My Cards
        $thisuser = User::where('api_token', $req->bearerToken())->first();

        $data = AddCard::where('user_id', $thisuser->id)->orderBy('created_at', 'DESC')->get();

        if(count($data) > 0){

            $data = $data;
            $status = 200;
            $message = 'Success';

        }
        else{
            $data = [];
            $status = 200;
            $message = "No Card Found";
        }


        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

        return $this->returnJSON($resData, $status);
    }


    public function getPrepaidCardIssuers(Request $req){
        // Get My Cards
        $thisuser = User::where('api_token', $req->bearerToken())->first();

        $data = CardIssuer::orderBy('created_at', 'DESC')->get();


        if(count($data) > 0){

            $data = $data;
            $status = 200;
            $message = 'Success';
        }
        else{
            $data = [];
            $status = 200;
            $message = "No Card Issuer Found";
        }



        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

        return $this->returnJSON($resData, $status);
    }

    public function addNewCard(Request $req){


        // Run Validation

        $validator = Validator::make($req->all(), [
                     'card_name' => 'required|string',
                     'card_provider' => 'required|string',
                     'card_number' => 'required|string|unique:add_card',
                     'month' => 'required|string',
                     'year' => 'required|string',
                     'cvv' => 'required|string',
                ]);

        if($validator->passes()){

            $thisuser = User::where('api_token', $req->bearerToken())->first();

            $userCardType = $this->check_cc($req->card_number, false);

            try {
                if($userCardType != false){

                    // Check card year
                    if($req->year <= date('y') && $req->month < date('m')){
                        $data = [];
                        $status = 400;
                        $message = "This card is expired!";

                        Log::info($thisuser->name." tried to add an expired card with Month: ".$req->month." and year ".$req->year);
                    }
                    else{
                        // Do Insert
                    $insertRecord = AddCard::insert(['user_id' => $thisuser->id, 'card_name' => $req->card_name, 'card_number' => $req->card_number, 'month' => $req->month, 'year' => $req->year, 'cvv' => Hash::make($req->cvv), 'card_type' => $userCardType, 'card_provider' => $req->card_provider]);

                    if($req->card_provider != "Credit Card" && $req->card_provider != "Debit Card"){
                       User::where('api_token', $req->bearerToken())->update(['cardRequest' => 1]); 
                    }

                    $data = $insertRecord;
                    $status = 200;
                    $message = 'You have successfully added your '.$req->card_provider;

                    $this->createNotification($thisuser->ref_code, "Hello ".strtoupper($thisuser->name).", You have successfully added a new ".$req->card_provider.".");

                        Log::info("New ".$req->card_provider." added by :=> ".$thisuser->name);
                    }

                    
                }
                else{
                    $data = [];
                    $status = 400;
                    $message = "Invalid Card Number";
                }
            } catch (\Throwable $th) {
                $data = [];
                $status = 400;
                $message = "Error: ".$th;
            }

            

        }else{

            $error = implode(",",$validator->messages()->all());

            $data = [];
            $status = 400;
            $message = $error;

        }


        // Log::info("Add Card:=> ".$data);

        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

        return $this->returnJSON($resData, $status);

    }



    public function addNewBank(Request $req){
        // Run Validation

        $validator = Validator::make($req->all(), [
                     'bankName' => 'required|string',
                     'accountNumber' => 'required|string',
                     'accountName' => 'required|string',
                    //  'transitNumber' => 'required|string',
                    //  'branchCode' => 'required|string',
                ]);

        if($validator->passes()){

            $thisuser = User::where('api_token', $req->bearerToken())->first();


            try {
                    // Do Insert
                    $insertRecord = AddBank::insert(['user_id' => $thisuser->id, 'bankName' => $req->bankName, 'accountNumber' => $req->accountNumber, 'accountName' => $req->accountName, 'transitNumber' => $req->transitNumber, 'branchCode' => $req->branchCode]);

                    $data = $insertRecord;
                    $status = 200;
                    $message = 'You have successfully added a bank account';

                    $this->createNotification($thisuser->ref_code, "Hello ".strtoupper($thisuser->name).", You have successfully added a new bank account.");

                    Log::info("New bank added by :=> ".$thisuser->name);

                
            } catch (\Throwable $th) {
                $data = [];
                $status = 400;
                $message = "Error: ".$th;
            }
            

        }else{

            $error = implode(",",$validator->messages()->all());

            $data = [];
            $status = 400;
            $message = $error;

        }


        // Log::info("Add Bank account:=> ".$data);

        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

        return $this->returnJSON($resData, $status);

    }



    public function addUpBeneficiary(Request $req){
        // Run Validation

        $thisuser = User::where('api_token', $req->bearerToken())->first();


        // GEt Benefactor name
        $benefactor = User::where('ref_code', $req->benefactor_account_number)->first();



        if(isset($benefactor)){

            $addBeneficiary = AddBeneficiary::updateOrCreate(['user_id' => $thisuser->ref_code, 'benefactor_account_number' => $req->benefactor_account_number], ['user_id' => $thisuser->ref_code, 'benefactor_account_number' => $req->benefactor_account_number, 'benefactor_account_name' => $benefactor->name]);


            $data = $addBeneficiary;
            $status = 200;
            $message = $benefactor->name.' added as a beneficiary';

            $this->createNotification($thisuser->ref_code, "Hello ".strtoupper($thisuser->name).", You have successfully added ".$benefactor->name." as a beneficiary.");

        }
        else{
            $data = [];
            $status = 400;
            $message = "Incorrect beneficiary account number";
        }


        // Log::info("Add Bank account:=> ".$data);

        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

        return $this->returnJSON($resData, $status);

    }


    public function getBeneficiary(Request $req){
        // Run Validation

        $thisuser = User::where('api_token', $req->bearerToken())->first();


        $myBeneficiaries = AddBeneficiary::where('user_id', $thisuser->ref_code)->orderBy('benefactor_account_name', 'ASC')->get();


        if(count($myBeneficiaries) > 0){
            $data = $myBeneficiaries;
            $status = 200;
            $message = 'success';
        }
        else{
            $data = $myBeneficiaries;
            $status = 200;
            $message = 'No record';
        }


        // Log::info("Add Bank account:=> ".$data);

        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

        return $this->returnJSON($resData, $status);

    }




        public function editBank(Request $req){


        // Run Validation

        $validator = Validator::make($req->all(), [
                     'bankName' => 'required|string',
                     'accountNumber' => 'required|string',
                     'accountName' => 'required|string',
                    //  'transitNumber' => 'required|string',
                    //  'branchCode' => 'required|string',
                ]);


        if($validator->passes()){

            $thisuser = User::where('api_token', $req->bearerToken())->first();


            try {
                    // Do Insert
                    $updateRecord = AddBank::where('id', $req->id)->update(['user_id' => $thisuser->id, 'bankName' => $req->bankName, 'accountNumber' => $req->accountNumber, 'accountName' => $req->accountName, 'transitNumber' => $req->transitNumber, 'branchCode' => $req->branchCode]);

                    $data = $updateRecord;
                    $status = 200;
                    $message = 'You have successfully updated your bank account';

                    $this->createNotification($thisuser->ref_code, "Hello ".strtoupper($thisuser->name).", You have successfully updated your new bank account.");

                    Log::info("Edit bank by :=> ".$thisuser->name);

                
            } catch (\Throwable $th) {
                $data = [];
                $status = 400;
                $message = "Error: ".$th;
            }
            

        }else{

            $error = implode(",",$validator->messages()->all());

            $data = [];
            $status = 400;
            $message = $error;

        }



        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

        return $this->returnJSON($resData, $status);

    }


    public function editCard(Request $req){


        // Run Validation

        $validator = Validator::make($req->all(), [
                     'card_name' => 'required|string',
                     'card_provider' => 'required|string',
                     'card_number' => 'required|string|unique:add_card',
                     'month' => 'required|string',
                     'year' => 'required|string',
                     'cvv' => 'required|string',
                ]);


                    // Log::info($req->all());


        if($validator->passes()){

            $thisuser = User::where('api_token', $req->bearerToken())->first();

            $userCardType = $this->check_cc($req->card_number, false);

            try {
                if($userCardType != false){
                    // Do Insert
                    $updateRecord = AddCard::where('id', $req->id)->update(['user_id' => $thisuser->id, 'card_name' => $req->card_name, 'card_number' => $req->card_number, 'month' => $req->month, 'year' => $req->year, 'cvv' => Hash::make($req->cvv), 'card_type' => $userCardType, 'card_provider' => $req->card_provider]);

                    $cardData = AddCard::where('id', $req->id)->first();


                    // Log::info("Edit Card Detail :=> ".$cardData);

                    Log::info("Edit ".$req->card_provider." by :=> ".$thisuser->name);

                    $data = $cardData;
                    $status = 200;
                    $message = 'You have successfully updated your '.$req->card_provider;

                    $this->createNotification($thisuser->ref_code, "Hello ".strtoupper($thisuser->name).", You have successfully updated your ".$req->card_provider." detail.");
                }
                else{
                    $data = [];
                    $status = 400;
                    $message = "Invalid Card Number";
                }
            } catch (\Throwable $th) {
                $data = [];
                $status = 400;
                $message = "Error: ".$th;
            }

            

        }else{

            $error = implode(",",$validator->messages()->all());

            $data = [];
            $status = 400;
            $message = $error;

        }


        // Log::info("Edit Card:=> ".$data);

        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

        return $this->returnJSON($resData, $status);

    }






    public function deleteCard(Request $req){

        $thisuser = User::where('api_token', $req->bearerToken())->first();

       $query = AddCard::where('id', $req->id)->delete();

        $data = $query;
        $status = 200;
        $message = 'Deleted successfully';


        $this->createNotification($thisuser->ref_code, "Hello ".strtoupper($thisuser->name).", You have successfully deleted a card.");

        // Log::info("Delete Card:=> ".$data);

        Log::info("Delete card by :=> ".$thisuser->name);

        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

        return $this->returnJSON($resData, $status);

    }


    public function deleteBank(Request $req){


        $thisuser = User::where('api_token', $req->bearerToken())->first();

        
       $query = AddBank::where('id', $req->id)->delete();

        $data = $query;
        $status = 200;
        $message = 'Deleted successfully';


        $this->createNotification($thisuser->ref_code, "Hello ".strtoupper($thisuser->name).", You have successfully deleted a bank account.");

        // Log::info("Delete Card:=> ".$data);

        Log::info("Delete bank by :=> ".$thisuser->name);

        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

        return $this->returnJSON($resData, $status);

    }


    public function getMyCardDetail(Request $req){

        // dd($req->get('card_provider'));

        $cardDetail = $req->get('card_provider');

        $thisuser = User::where('api_token', $req->bearerToken())->first();

        if($cardDetail == "Bank Account"){
        $query = AddBank::where('user_id', $thisuser->id)->get();

        Log::info("Get bank inforamtion for :=> ".$thisuser->name);

        }
        else{
        $query = AddCard::where('user_id', $thisuser->id)->where('card_provider', 'LIKE', '%'.$cardDetail.'%')->get();

        Log::info("Get card inforamtion for :=> ".$thisuser->name);

        }



        if(count($query) > 0){
            $data = $query;
            $message = "success";
            $status = 200;
        }
        else{
            $data = [];
            $message = $cardDetail." not available";
            $status = 400;
        }

        $resData = ['data' => $data, 'message' => $message, 'status' => $status, 'action' => $cardDetail];

        return $this->returnJSON($resData, $status);

    }



    public function check_cc($cc, $extra_check = false){
        $cards = array(
            "visa" => "(4\d{12}(?:\d{3})?)",
            "amex" => "(3[47]\d{13})",
            "jcb" => "(35[2-8][89]\d\d\d{10})",
            "maestro" => "((?:5020|5038|6304|6579|6761)\d{12}(?:\d\d)?)",
            "solo" => "((?:6334|6767)\d{12}(?:\d\d)?\d?)",
            "mastercard" => "(5[1-5]\d{14})",
            "switch" => "(?:(?:(?:4903|4905|4911|4936|6333|6759)\d{12})|(?:(?:564182|633110)\d{10})(\d\d)?\d?)",
        );
        $names = array("Visa", "American Express", "JCB", "Maestro", "Solo", "Mastercard", "Switch");
        $matches = array();
        $pattern = "#^(?:".implode("|", $cards).")$#";
        $result = preg_match($pattern, str_replace(" ", "", $cc), $matches);
        // if($extra_check && $result > 0){
        //     // $result = (validatecard($cc))?1:0;
        // }
        return ($result>0)?$names[sizeof($matches)-2]:false;
    }

}
