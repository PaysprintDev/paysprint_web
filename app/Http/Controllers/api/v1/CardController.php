<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use App\User as User;
use App\AddCard as AddCard;

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
            $status = 400;
            $message = "No Card Found";
        }


        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

        return $this->returnJSON($resData, $status);
    }

    public function addNewCard(Request $req){


        // Run Validation

        $validator = Validator::make($req->all(), [
                     'card_number' => 'required|string',
                     'month' => 'required|string',
                     'year' => 'required|string',
                     'cvv' => 'required|string',
                ]);

        if($validator->passes()){

            $thisuser = User::where('api_token', $req->bearerToken())->first();

            $userCardType = $this->check_cc($req->card_number, false);

            try {
                if($userCardType != false){
                    // Do Insert
                    $insertRecord = AddCard::insert(['user_id' => $thisuser->id, 'card_number' => $req->card_number, 'month' => $req->month, 'year' => $req->year, 'cvv' => Hash::make($req->cvv), 'card_type' => $userCardType]);

                    $data = $insertRecord;
                    $status = 200;
                    $message = 'You have successfully added a card';

                    $this->createNotification($thisuser->ref_code, "Great!, you added a new card");

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


        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

        return $this->returnJSON($resData, $status);

    }


    public function editCard(Request $req){


        // Run Validation

        $validator = Validator::make($req->all(), [
                     'card_number' => 'required|string',
                     'month' => 'required|string',
                     'year' => 'required|string',
                     'cvv' => 'required|string',
                ]);

        if($validator->passes()){

            $thisuser = User::where('api_token', $req->bearerToken())->first();

            $userCardType = $this->check_cc($req->card_number, false);

            try {
                if($userCardType != false){
                    // Do Insert
                    $updateRecord = AddCard::where('id', $req->id)->update(['user_id' => $thisuser->id, 'card_number' => $req->card_number, 'month' => $req->month, 'year' => $req->year, 'cvv' => Hash::make($req->cvv), 'card_type' => $userCardType]);

                    $data = $updateRecord;
                    $status = 200;
                    $message = 'You have successfully updated your card';

                    $this->createNotification($thisuser->ref_code, "Great!, you have updated your card detail");
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


        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

        return $this->returnJSON($resData, $status);

    }


    public function deleteCard(Request $req){

        $thisuser = User::where('api_token', $req->bearerToken())->first();

       $query = AddCard::where('id', $req->id)->delete();

        $data = $query;
        $status = 200;
        $message = 'Deleted successfully';

        $this->createNotification($thisuser->ref_code, "You deleted a card");

        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

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
