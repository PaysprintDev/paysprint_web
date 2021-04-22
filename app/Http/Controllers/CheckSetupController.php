<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;

use App\Mail\sendEmail;
use App\User as User;
use App\AddCard as AddCard;
use App\AddBank as AddBank;

class CheckSetupController extends Controller
{

    public $name;
    public $email;
    public $subject;
    public $message;
    // Check user quick wallet setup

    public function updateQuickSetup(){
        // Get User
        $user = User::inRandomOrder()->get();

        try {
            foreach($user as $key => $value){
                $info = $this->accountInfo($value->id);

                if($value->approval == 0){
                    $approval = "<li>Provide Means of Identification</li>";
                }
                else{
                    $approval = "";
                }
                if($value->transaction_pin == null){
                    $transaction = "<li>Set Up Transaction Pin</li>";
                }
                else{
                    $transaction = "";
                }
                if($value->securityQuestion == null){
                    $security = "<li>Provide Security Question and Answer</li>";
                }
                else{
                    $security = "";
                }
                if($info == 0){
                    $card = "<li>Add Credit Card/Prepaid Card/Bank Account</li>";
                }
                else{
                    $card = "";
                }

                // Send Mail

                $this->name = $value->name;
                $this->email = $value->email;
                $this->subject = "You have some incomplete information on your PaySprint account";

                $this->message = '<p>We noticed some of your information on your PaySprint account is not complete.</p><p><ul>'.$approval.''.$transaction.''.$security.''.$card.'</ul></p><p>Kindly complete these important steps in your profile. <a href=https://'.route('profile').' class="text-primary" style="text-decoration: underline">Click here to login to your account</a></p>';

                $this->sendEmail($this->email, "Incomplete Setup");


                echo "Sent to ".$this->name."<hr>";

            }

        } catch (\Throwable $th) {
            echo "Error: ".$th;
        }


    }

    public function accountInfo($id){

        $getCard = AddCard::where('user_id', $id)->first();

        if(isset($getCard) == false){
            // Check Bank
            $getBank = AddBank::where('user_id', $id)->first();

            if(isset($getBank) == false){
                $data = 0;
            }
            else{
                // Do nothing
                $data = 1;
            }
        }
        else{
            // Do nothing
            $data = 1;
        }


        return $data;

    }


    public function sendEmail($objDemoa, $purpose){
        $objDemo = new \stdClass();
        $objDemo->purpose = $purpose;
        
        if($purpose == 'Incomplete Setup'){
              $objDemo->name = $this->name;
              $objDemo->email = $this->email;
              $objDemo->subject = $this->subject;
              $objDemo->message = $this->message;
          }
  
        Mail::to($objDemoa)
              ->send(new sendEmail($objDemo));
    }
}
