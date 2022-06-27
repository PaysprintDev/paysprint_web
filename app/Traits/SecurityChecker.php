<?php 

namespace App\Traits;
// use App\MonerisActivity as MonerisActivity;
// use App\Statement as Statement;
use App\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\sendEmail;


trait SecurityChecker {

   public $subject;
   public $message;
   public $name;
   public $email;


   public $flagged;

    public function checkTransaction($user_id, $respMessage){
        $details=User::where('id', $user_id)->first();

        $walletbalance=$details->wallet_balance;

        $flagcount = $details->flagcount + 1;

        

         if($flagcount >= 2 && $walletbalance >= 25){ 
           $this->flagged = 1;
           $userSubject =  "Your PaySprint Account is Temporarily Suspended.";
           $userMessage=  "Your PaySprint Account is temporarily suspended as our system is unable to process the source of funding to your wallet. In order to remove the temporary suspension on your account, Kindly Send us a copy of a Utility Bill with address that matches the address on your profile. Please send the copy of utility bill to: info@paysprint.ca";
          
           $adminSubject= "Flagged account";
           $adminMessage= "The user's account has being flagged. Details below <br>. Name: ".$details->name.". <br> Email : ".$details->email." <br> Phone : ".$details->telephone." <br> Amount : ".$details->wallet_balance." <br> Reason for flag : ".$respMessage." <br> Country : ".$details->country." <br> Paysprint Account Number : ".$details->ref_code;

         
        

         }elseif($flagcount <= 1 && $walletbalance >= 25){
            $this->flagged = 0;
            
         }
         else{

            $this->flagged = 1;
            
            $userSubject =  "Your PaySprint Account is Temporarily Suspended.";
            $userMessage=  "Your PaySprint Account is temporarily suspended as our system is unable to process the source of funding to your wallet. In order to remove the temporary suspension on your account, Kindly Send us a copy of a Utility Bill with address that matches the address on your profile. Please send the copy of utility bill to: info@paysprint.ca";
           
            $adminSubject= "Flagged account";
            $adminMessage= "The user's account has being flagged. Details below <br>. Name: ".$details->name.". <br> Email : ".$details->email." <br> Phone : ".$details->telephone." <br> Amount : ".$details->wallet_balance." <br> Reason for flag : ".$respMessage." <br> Country : ".$details->country." <br> Paysprint Account Number : ".$details->ref_code;
         }

         $data = User::where ('id', $user_id)->update(['flagged' => $this->flagged, 'flagcount' => $flagcount]);

        //  $this->dothisflag($transaction_id);

         $this->notifyUser($userSubject,$userMessage,$user_id);
         $this->notifyThisAdmin($adminSubject,$adminMessage);

         return $data;
    }

    // public function dothisflag($transaction_id)
    // {

    //     // dd($transaction_id);

    //     $data = MonerisActivity::where('transaction_id', $transaction_id)->first();

    //     if ($data->flag_state ==  1) {
    //         $flag = 0;
    //     } else {
    //         $flag = 1;
    //     }

    //     MonerisActivity::where('transaction_id', $transaction_id)->update(['flag_state' => $flag]);
    //     Statement::where('reference_code', $transaction_id)->update(['flag_state' => $flag]);

    //     $getUser = Statement::where('reference_code', $transaction_id)->first();

    //     User::where('email', $getUser->user_id)->update(['flagged' => $flag]);

    //     $getAccount = User::where('email', $getUser->user_id)->first();

    //     return $getAccount;
    // }


    public function notifyUser($userSubject, $userMessage,$user_id)
    { 
      $details=User::where('id', $user_id)->first();

        $this->name = $details->user_id;
        $this->email = $details->email;
        $this->subject = $userSubject;

        $this->message = $userMessage;


        $this->emailSender($this->email, "Fund remittance");
    }
    public function notifyThisAdmin($adminSubject, $adminMessage)
    {

        $this->name = 'Administrator';
        $this->email = 'accounting@paysprint.ca';
        $this->subject = $adminSubject;

        $this->message = $adminMessage;


        $this->emailSender($this->email, "Fund remittance");
    }

    public function emailSender($objDemoa, $purpose)
    {
        $objDemo = new \stdClass();
        $objDemo->purpose = $purpose;

        if ($purpose == "New Login" || $purpose == 'Fund remittance') {
            $objDemo->name = $this->name;
            $objDemo->email = $this->email;
            $objDemo->subject = $this->subject;
            $objDemo->message = $this->message;
        }


        Mail::to($objDemoa)
            ->send(new sendEmail($objDemo));
    }


    

};


