<?php


namespace App\Traits;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Mail;

use App\User as User;

use App\Mail\sendEmail;

use Twilio\Rest\Client;


trait AccountNotify{

    public $subject;
    public $message;
    public $name;
    public $email;

    public function checkLoginInfo($ref_code, $city, $country, $ip){
        

        $thisuser = User::where('ref_code', $ref_code)->first();

        $date = date('F d, Y');
        $OS = php_uname();

        try{

            if(isset($thisuser)){


                if($city != $thisuser->city){

                    $message = "We detected a login into your account from an unrecognized device on ".date('l', strtotime($date)).", ".$date." at ".date('h:ia')."<br><br><br> Operating System: ".$OS." <br><br> Location: ".$city.", ".$country." (IP: ".$ip."). <br><br> Note: Location is based on internet service provider information. <br><br> If it was you, please disregard this email. <br> If it wasn't you, please <a href='https://paysprint.net/password/reset'>secure your account</a>, as someone else may be accessing it. <br><br> Thanks <br> The PaySprint Security Team <br><br> Please note, PaySprint will never request your login information through email.";


                    $sms = "We detected a login into your account from an unrecognized device on ".date('l', strtotime($date)).", ".$date." at ".date('h:ia')."\n\nOperating System: ".$OS." \n\nLocation: ".$city.", ".$country." (IP: ".$ip."). \n\nNote: Location is based on internet service provider information. \n\nIf it was you, please disregard this email. If it wasn't you, please click the link https://paysprint.net/password/reset to secure your account, as someone else may be accessing it. \n\nThanks \n\nThe PaySprint Security Team \n\nPlease note, PaySprint will never request your login information through email.";
                }
                else{
                    // Send Mail

                    $message = "We noticed a recent login to your PaySprint account on ".date('l', strtotime($date)).", ".$date." at ".date('h:ia')."<br><br><br> Operating System: ".$OS." <br><br> Location: ".$city.", ".$country." (IP: ".$ip."). <br><br> Note: Location is based on internet service provider information. <br><br> If it was you, please disregard this email. <br> If it wasn't you, please <a href='https://paysprint.net/password/reset'>secure your account</a>, as someone else may be accessing it. <br><br> Thanks <br> The PaySprint Security Team <br><br> Please note, PaySprint will never request your login information through email.";


                    $sms = "We noticed a recent login to your PaySprint account on ".date('l', strtotime($date)).", ".$date." at ".date('h:ia')."\n\nOperating System: ".$OS." \n\nLocation: ".$city.", ".$country." (IP: ".$ip."). \n\nNote: Location is based on internet service provider information. \n\nIf it was you, please disregard this email. If it wasn't you, please click the link https://paysprint.net/password/reset to secure your account, as someone else may be accessing it. \n\nThanks. \n\nThe PaySprint Security Team \n\nPlease note, PaySprint will never request your login information through email.";

                }



                    $this->name = $thisuser->name;
                    $this->email = $thisuser->email;
                    // $this->email = "bambo@vimfile.com";
                    $this->subject = "We detected a login in your account";

                    $this->message = $message;

                    $userPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();
                                                    
                    if(isset($userPhone)){

                        $recPhone = $thisuser->telephone;
                    }
                    else{
                        $recPhone = "+".$thisuser->code.$thisuser->telephone;
                    }

                    $this->sendMessage($sms, $recPhone);

                    $this->myEmailSender($thisuser->email, "New Login");

            }
            else{
                // Do nothing
            }
        }
        catch (\Throwable $th) {

            Log::error("Error Message: ".$th->getMessage());
        }

    }


        public function sendMessage($message, $recipients)
    {

        try {
            $account_sid = env("TWILIO_SID");
        $auth_token = env("TWILIO_AUTH_TOKEN");
        $twilio_number = env("TWILIO_NUMBER");
        $client = new Client($account_sid, $auth_token);
        $client->messages->create($recipients, 
                ['from' => $twilio_number, 'body' => $message] );

        } catch (\Throwable $th) {
            Log::error('Error: '.$th->getMessage());
        }
        
        

    }


    public function myEmailSender($objDemoa, $purpose){
      $objDemo = new \stdClass();
      $objDemo->purpose = $purpose;
        
      if($purpose == "New Login"){
            $objDemo->name = $this->name;
            $objDemo->email = $this->email;
            $objDemo->subject = $this->subject;
            $objDemo->message = $this->message;
        }


      Mail::to($objDemoa)
            ->send(new sendEmail($objDemo));
   }
    


}