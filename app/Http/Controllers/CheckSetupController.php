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
                    $approval = "<li>Upload a copy of Government Issued Photo ID</li>";
                }
                else{
                    $approval = "";
                }
                if($value->transaction_pin == null){
                    $transaction = "<li>Set Up Transaction Pin-You will need the PIN to Send Money, Pay Invoice or Withdraw Money from Your PaySprint Account</li>";
                }
                else{
                    $transaction = "";
                }
                if($value->securityQuestion == null){
                    $security = "<li>Set up Security Question and Answer-You will need this to reset your PIN code or Login Password</li>";
                }
                else{
                    $security = "";
                }
                if($info == 0){
                    $card = "<li>Add Credit Card/Prepaid Card/Bank Account-You need this to add money to your PaySprint Wallet.</li>";
                }
                else{
                    $card = "";
                }

                // Send Mail

                if($value->approval == 0 || $value->transaction_pin == null || $value->securityQuestion == null || $info == 0){

                    $this->name = $value->name;
                    $this->email = $value->email;
                    $this->subject = "You have some incomplete information on your PaySprint account";

                    $this->message = '<p>We noticed you are yet to properly set-up your PaySprint Account. You need to set up the following in order to enjoy the full benefits of a PaySprint Account.</p><p><ul>'.$approval.''.$transaction.''.$security.''.$card.'</ul></p><p>Kindly complete these important steps in your profile. <a href='.route('profile').' class="text-primary" style="text-decoration: underline">Click here to login to your account</a></p>';

                    $this->sendEmail($this->email, "Incomplete Setup");


                    echo "Sent to ".$this->name."<hr>";
                }

                

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



    public function autoDepositOff(){
        $user = User::where('auto_deposit', 'off')->inRandomOrder()->get();

        if(count($user) > 0){
            // Send mail
            foreach($user as $key => $value){
                $this->name = $value->name;
                $this->email = $value->email;
                $this->subject = "Your Auto Deposit status is OFF on PaySprint.";

                $this->message = '<p>The Auto Deposit feature on PaySprint is turned OFF. You will need to manually accept all transfers made to your PaySprint wallet. If you want to enjoy a stress-free transaction deposit, you may have visit your profile on PaySprint Account to turn ON the feature. <br><br> Thanks, PaySprint Team</p>';

                $this->sendEmail($this->email, "Incomplete Setup");

                echo "Sent to ".$this->name."<hr>";
            }
        }
        else{
            // Do nothing
        }
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
