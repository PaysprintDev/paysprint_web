<?php


namespace App\Traits;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Mail;

use App\User as User;

use App\Notifications as Notifications;

use App\Mail\sendEmail;

use Twilio\Rest\Client;


trait AccountNotify
{

    public $subject;
    public $message;
    public $name;
    public $email;

    public function checkLoginInfo($ref_code, $city, $country, $ip)
    {


        $thisuser = User::where('ref_code', $ref_code)->first();

        $date = date('F d, Y');
        $OS = php_uname();

        try {

            if (isset($thisuser)) {

                Log::info("Detected City: " . $city . "\nRegistered City: " . $thisuser->city . "\nDetected Country: " . $country . "\nRegistered Country: " . $thisuser->country . "\nDetected IP Address: " . $ip);


                if ($ip != $thisuser->ip_address) {

                    $message = "We detected a login into your account from an unrecognized device on " . date('l', strtotime($date)) . ", " . $date . " at " . date('h:ia') . "<br><br><br> Operating System: " . $OS . " <br><br> Location: " . $city . ", " . $country . " (IP: " . $ip . "). <br><br> Note: Location is based on internet service provider information. <br><br> If it was you, please disregard this email. <br> If it wasn't you, please <a href='https://paysprint.ca/password/reset'>secure your account</a>, as someone else may be accessing it. <br><br> Thanks <br> The PaySprint Security Team <br><br> Please note, PaySprint will never request your login information through email.";


                    $sms = "We detected a login into your account from an unrecognized device on " . date('l', strtotime($date)) . ", " . $date . " at " . date('h:ia') . "\n\nOperating System: " . $OS . " \n\nLocation: " . $city . ", " . $country . " (IP: " . $ip . "). \n\nNote: Location is based on internet service provider information. \n\nIf it was you, please disregard this email. If it wasn't you, please click the link https://paysprint.ca/password/reset to secure your account, as someone else may be accessing it. \n\nThanks \n\nThe PaySprint Security Team \n\nPlease note, PaySprint will never request your login information through email.";

                    $this->name = $thisuser->name;
                    $this->email = $thisuser->email;
                    // $this->email = "bambo@vimfile.com";
                    $this->subject = "We detected a login in your account";

                    $this->message = $message;

                    User::where('email', $thisuser->email)->update(['ip_address' => $ip]);

                    $userPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();



                    if (isset($userPhone)) {

                        $recPhone = $thisuser->telephone;
                    } else {
                        $recPhone = "+" . $thisuser->code . $thisuser->telephone;
                    }

                    // $this->sendMessage($sms, $recPhone);

                    // $this->myEmailSender($thisuser->email, "New Login");

                }

                // else{
                //     // Send Mail

                //     $message = "We noticed a recent login to your PaySprint account on ".date('l', strtotime($date)).", ".$date." at ".date('h:ia')."<br><br><br> Operating System: ".$OS." <br><br> Location: ".$city.", ".$country." (IP: ".$ip."). <br><br> Note: Location is based on internet service provider information. <br><br> If it was you, please disregard this email. <br> If it wasn't you, please <a href='https://paysprint.ca/password/reset'>secure your account</a>, as someone else may be accessing it. <br><br> Thanks <br> The PaySprint Security Team <br><br> Please note, PaySprint will never request your login information through email.";


                //     $sms = "We noticed a recent login to your PaySprint account on ".date('l', strtotime($date)).", ".$date." at ".date('h:ia')."\n\nOperating System: ".$OS." \n\nLocation: ".$city.", ".$country." (IP: ".$ip."). \n\nNote: Location is based on internet service provider information. \n\nIf it was you, please disregard this email. If it wasn't you, please click the link https://paysprint.ca/password/reset to secure your account, as someone else may be accessing it. \n\nThanks. \n\nThe PaySprint Security Team \n\nPlease note, PaySprint will never request your login information through email.";

                // }





            } else {
                // Do nothing
            }
        } catch (\Throwable $th) {

            Log::error("Error Message on Account Notify: " . $th->getMessage());
        }
    }


    public function updateNotificationTable()
    {
        $users = User::all();

        try {

            if (count($users)) {
                foreach ($users as $key => $value) {
                    $ref_code = $value->ref_code;
                    $country = $value->country;

                    Notifications::where('ref_code', $ref_code)->update(['country' => $country]);
                }
            }

            Notifications::where('notify', 0)->update(['platform' => 'mobile']);
        } catch (\Throwable $th) {
            Log::info("Error updating notification table: " . $th->getMessage());
        }

        echo "done";
    }

    public function updateNotificationPeriod()
    {
        $data = Notifications::where('period', NULL)->get();

        foreach ($data as $value) {
            $period = date('Y-m-d', strtotime($value->created_at));

            Notifications::where('id', $value->id)->update(['period' => $period]);
        }

        echo "Done";
    }


    public function notifyAdmin($subject, $message)
    {

        $this->name = 'Administrator';
        $this->email = 'accounting@paysprint.ca';
        $this->email2 = 'lsuleiman@paysprint.ca';
        $this->subject = $subject;

        $this->message = $message;


        $this->myEmailSender($this->email, "Fund remittance");
        $this->myEmailSender($this->email2, "Fund remittance");
    }


    public function sendMessage($message, $recipients)
    {

        try {
            $account_sid = env("TWILIO_SID");
            $auth_token = env("TWILIO_AUTH_TOKEN");
            $twilio_number = env("TWILIO_NUMBER");
            $client = new Client($account_sid, $auth_token);


            if (env('APP_ENV') != "local") {
                $client->messages->create(
                    $recipients,
                    ['from' => $twilio_number, 'body' => $message]
                );
            }
        } catch (\Throwable $th) {
            Log::error('Error: ' . $th->getMessage());
        }
    }


    public function myEmailSender($objDemoa, $purpose)
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
}
