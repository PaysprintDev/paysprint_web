<?php


namespace App\Traits;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Twilio\Rest\Client;

use App\User as User;
use App\VerificationCode as VerificationCode;
use App\Mail\sendEmail;
use App\Traits\Xwireless;

trait GenerateOtp
{
    use Xwireless;
    public $sendToUser;
    public $nameOfUser;
    public $mailSubjectToUser;
    public $messageForUser;
    // Generate Verification OTP
    public function generateOTP($userid)
    {

        $code = mt_rand(000001, 999999);

        $thisuser = User::where('id', $userid)->first();

        VerificationCode::updateOrInsert(['user_id' => $userid], ['user_id' => $userid, 'code' => $code]);

        // Send SMS and Email

        $userPhone = User::where('id', $userid)->where('telephone', 'LIKE', '%+%')->first();

        $sendMsg = 'Please use ' . $code . ' as your PaySprint security code to log in. We will never contact you for this code. Do not reveal it to anyone else.';

        if (isset($userPhone)) {

            $sendPhone = $thisuser->telephone;
        } else {
            $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
        }

        if ($thisuser->country == "Nigeria") {

            $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
            $this->sendSms($sendMsg, $correctPhone);
        } else {
            $this->sendOTPMessage($sendMsg, $sendPhone);
        }


        $this->nameOfUser = $thisuser->name;
        $this->sendToUser = $thisuser->email;
        $this->mailSubjectToUser = "Verification OTP";
        $this->messageForUser = $thisuser->name . ", " . $sendMsg;

        $this->sendEmail($this->sendToUser, 'Verify OTP');
    }


    private function sendEmail($objDemoa, $purpose)
    {
        $objDemo = new \stdClass();
        $objDemo->purpose = $purpose;
        if ($purpose == 'Verify OTP') {
            $objDemo->name = $this->nameOfUser;
            $objDemo->to = $this->sendToUser;
            $objDemo->subject = $this->mailSubjectToUser;
            $objDemo->message = $this->messageForUser;
        }

        Mail::to($objDemoa)
            ->send(new sendEmail($objDemo));
    }

    private function sendOTPMessage($message, $recipients)
    {

        try {
            $account_sid = env("TWILIO_SID");
            $auth_token = env("TWILIO_AUTH_TOKEN");
            $twilio_number = env("TWILIO_NUMBER");
            $client = new Client($account_sid, $auth_token);
            $client->messages->create(
                $recipients,
                ['from' => $twilio_number, 'body' => $message]
            );
        } catch (\Throwable $th) {
            // Log::error('Error: '.$th->getMessage());

            $this->slack('Error: ' . $th->getMessage(), $room = "error-logs", $icon = ":longbox:", env('LOG_SLACK_WEBHOOK_URL'));

            $response = 'Money sent successfully. However, we are unable to send you a notification through a text message because we detected there is no phone number or you have an invalid phone number on your PaySprint Account. Kindly update your phone number to receive notification via text on your next transaction.';
            $respaction = 'success';

            return redirect()->route('payorganization')->with($respaction, $response);
        }
    }
}