<?php

namespace App\Traits;

use Illuminate\Support\Facades\Mail;

use App\User as User;
use App\Mail\sendEmail;


trait IDVCheck
{

    private $touser;
    private $nameuser;
    private $subjectuser;
    private $messageuser;

    public function checkUsersPassAccount($id)
    {

        $thisuser = User::where('id', $id)->first();

        if ($thisuser->accountLevel == 0 && $thisuser->approval == 0) {
            $data = "Level 0";
            $access = ['0' => 'receive money', '1' => 'withdraw money'];
            $response = "Kindly upload a Selfie of yourself, Government Issued Photo ID (Drivers license or International Passport or National ID card), Utility Bill ( Electricity, Hydro etc. Note that Bank or Credit Card Statements are not accepted) for verification.";
            $this->generateMail($thisuser->name, $thisuser->email, $data);
        } elseif ($thisuser->accountLevel == 2 && $thisuser->approval == 0) {
            $data = "Level 1";
            $access = ['0' => 'receive money', '1' => 'withdraw money'];
            $response = "Kindly upload a Selfie of yourself, Utility Bill ( Electricity, Hydro etc. Note that Bank or Credit Card Statements are not accepted) for verification.";
            $this->generateMail($thisuser->name, $thisuser->email, $data);
        } elseif ($thisuser->accountLevel == 2 && $thisuser->approval == 1 && $thisuser->bvn_verification >= 1) {
            $data = "Level 2";
            $access = ['0' => 'receive money', '1' => 'withdraw money', '2' => 'send money'];
            $response = "Kindly upload a Utility Bill ( Electricity, Hydro etc. Note that Bank or Credit Card Statements are not accepted) for verification.";
            $this->generateMail($thisuser->name, $thisuser->email, $data);
        } elseif ($thisuser->accountLevel == 3 && $thisuser->approval > 0) {
            $data = "Approved";
            $access = ['0' => 'receive money', '1' => 'withdraw money', '2' => 'send money', '3' => 'add money'];
            $response = "";
        } else {
            $data = "Level 0";
            $access = ['0' => 'receive money', '1' => 'withdraw money'];
            $response = "Kindly upload a Selfie of yourself, Government Issued Photo ID (Drivers license or International Passport or National ID card), Utility Bill ( Electricity, Hydro etc. Note that Bank or Credit Card Statements are not accepted) for verification.";
            $this->generateMail($thisuser->name, $thisuser->email, $data);
        }

        $result = [
            'data' => $data,
            'response' => $response,
            'access' => $access

        ];


        return $result;
    }


    public function generateMail($name, $email, $data)
    {

        if ($data == "Level 0") {
            $message = "<p>We are glad to have you on PaySprint.</p><p>Your PaySprint wallet has been prepared and ready for use.</p><p>However, you can only <strong>RECEIVE</strong> and <strong>WITHDRAW</strong> funds from your wallet until you have completed the required identity verification process that would enable you <em>'to Add Money/Top Up Wallet' and 'Send Money from Wallet'</em></p><br><p>To Complete the identity verification processes, kindly follow these steps:</p><p>a. Login to your PaySprint Account on your mobile app or at: www.paysprint.ca</p><p>b. Go to Profile section and upload the following:</p><p>1. Selfie of yourself</p><p>2. Government Issued Photo ID (Drivers license or International Passport or National ID card)</p><p>3. Utility Bill ( Electricity, Hydro etc. Note that Bank or Credit Card Statements are not accepted)</p><br><p>Thank you for choosing us.</p>";
        } elseif ($data == "Level 1") {
            $message = "<p>Your PaySprint wallet has been prepared and ready for use.</p><p>However, you can only <strong>RECEIVE</strong> and <strong>WITHDRAW</strong> funds from your wallet until you have completed the required identity verification process that would enable you <em>'to Add Money/Top Up Wallet' and 'Send Money from Wallet'</em></p><br><p>To Complete the identity verification processes, kindly follow these steps:</p><p>a. Login to your PaySprint Account on your mobile app or at: www.paysprint.ca</p><p>b. Go to Profile section and upload the following:</p><p>1. Selfie of yourself</p><p>2. Utility Bill ( Electricity, Hydro etc. Note that Bank or Credit Card Statements are not accepted)</p><br><p>Thank you for choosing us.</p>";
        } elseif ($data == "Level 2") {
            $message = "<p>Your PaySprint wallet has been prepared and ready for use.</p><p>However, you can <strong>SEND</strong>, <strong>RECEIVE</strong> and <strong>WITHDRAW</strong> funds from your wallet until you have completed the required identity verification process that would enable you <em>'to Add Money/Top Up Wallet'</em></p><br><p>To Complete the identity verification processes, kindly follow these steps:</p><p>a. Login to your PaySprint Account on your mobile app or at: www.paysprint.ca</p><p>b. Go to Profile section and upload the following:</p><p>1. Utility Bill ( Electricity, Hydro etc. Note that Bank or Credit Card Statements are not accepted)</p><br><p>Thank you for choosing us.</p>";
        }


        $this->nameuser = $name;
        $this->touser = $email;
        $this->subjectuser = "Account Verification";
        $this->messageuser = $name . ", " . $message;

        $this->sendEmail($this->touser, $this->subjectuser);
    }


    private function sendEmail($objDemoa, $purpose)
    {
        $objDemo = new \stdClass();
        $objDemo->purpose = $purpose;
        if ($purpose == $this->subjectuser) {
            $objDemo->name = $this->nameuser;
            $objDemo->to = $this->touser;
            $objDemo->subject = $this->subjectuser;
            $objDemo->message = $this->messageuser;
        }

        Mail::to($objDemoa)
            ->send(new sendEmail($objDemo));
    }
}