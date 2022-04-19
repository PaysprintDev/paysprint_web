<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Mail;

use App\User as User;
use App\AnonUsers as AnonUsers;
use App\Statement as Statement;
use App\ServiceType as ServiceType;
use App\Admin as Admin;
use App\ClientInfo as ClientInfo;
use App\AllCountries as AllCountries;
use App\Building;
use App\BVNVerificationList;
use App\LinkAccount as LinkAccount;
use App\ListOfBanks as ListOfBanks;
use App\Mail\sendEmail;
use App\TransactionCost as TransactionCost;
use App\MonthlyFee as MonthlyFee;

use App\Traits\Trulioo;
use App\Traits\AccountNotify;
use App\Traits\PaystackPayment;
use App\Traits\Xwireless;
use App\Traits\PaymentGateway;
use App\Traits\MailChimpNewsLetter;
use App\Traits\PaysprintPoint;
use App\UpgradePlan;
use Carbon\Carbon;

class UserController extends Controller
{

    use Trulioo, AccountNotify, PaystackPayment, Xwireless, PaymentGateway, MailChimpNewsLetter, PaysprintPoint;

    // User Registration

    public function userRegistration(Request $request, User $user)
    {

        $validator = Validator::make($request->all(), [
            'ref_code' => 'unique:users|unique:users_closed',
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:users|unique:users_closed',
            'password' => 'required',
            'telephone' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'dayOfBirth' => 'required',
            'monthOfBirth' => 'required',
            'yearOfBirth' => 'required',
        ]);

        if ($validator->passes()) {

            $ref_code = mt_rand(0000000, 9999999);

            $mycode = $this->getCountryCode($request->country);


            $transCost = TransactionCost::where('method', "Consumer Minimum Withdrawal")->where('country', $request->country)->first();

            if (isset($transCost)) {
                $transactionLimit = $transCost->fixed;
            } else {
                $transactionLimit = 0;
            }



            // Get all ref_codes
            $ref = User::all();

            if (count($ref) > 0) {
                foreach ($ref as $key => $value) {
                    if ($value->ref_code == $ref_code) {
                        $newRefcode = mt_rand(0000000, 9999999);
                    } else {
                        $newRefcode = $ref_code;
                    }
                }
            } else {
                $newRefcode = $ref_code;
            }


            // Check Anon Users
            $newcustomer = AnonUsers::where('email', $request->email)->first();

            if (isset($mycode->callingCode)) {

                if ($request->country == "United States") {
                    $phoneCode = "1";
                } else {
                    $phoneCode = $mycode->callingCode;
                }
            } else {
                $phoneCode = "1";
            }

            if (isset($newcustomer)) {

                $user = User::create(['code' => $newcustomer->code, 'ref_code' => $newcustomer->ref_code, 'name' => $newcustomer->name, 'email' => $newcustomer->email, 'password' => Hash::make($request->password), 'address' => $newcustomer->address, 'city' => $request->city, 'state' => $request->state, 'country' => $newcustomer->country, 'accountType' => 'Individual', 'api_token' => uniqid() . md5($request->email), 'telephone' => $newcustomer->telephone, 'wallet_balance' => $newcustomer->wallet_balance, 'approval' => 0, 'currencyCode' => $mycode->currencyCode, 'currencySymbol' => $mycode->currencySymbol, 'dayOfBirth' => $request->dayOfBirth, 'monthOfBirth' => $request->monthOfBirth, 'yearOfBirth' => $request->yearOfBirth, 'cardRequest' => 0, 'platform' => 'mobile', 'accountLevel' => 2, 'zip' => $request->zipcode, 'withdrawal_per_transaction' => $transactionLimit]);

                $getMoney = Statement::where('user_id', $newcustomer->email)->get();

                if (count($getMoney) > 0) {
                    foreach ($getMoney as $key => $value) {
                        Statement::where('reference_code', $value->reference_code)->update(['status' => 'Delivered']);
                    }
                } else {
                    // Do nothing
                }

                AnonUsers::where('ref_code', $newcustomer->ref_code)->delete();
            } else {




                $user = User::create([
                    'ref_code' => $newRefcode,
                    'name' => $request->firstname . ' ' . $request->lastname,
                    'code' => $phoneCode,
                    'email' => $request->email,
                    'address' => $request->address,
                    'telephone' => $request->telephone,
                    'city' => $request->city,
                    'state' => $request->state,
                    'country' => $request->country,
                    'zip' => $request->zipcode,
                    'accountType' => 'Individual',
                    'currencyCode' => $mycode->currencyCode,
                    'currencySymbol' => $mycode->currencySymbol,
                    'api_token' => uniqid() . md5($request->email),
                    'password' => Hash::make($request->password),
                    'approval' => 0,
                    'dayOfBirth' => $request->dayOfBirth,
                    'monthOfBirth' => $request->monthOfBirth,
                    'yearOfBirth' => $request->yearOfBirth,
                    'cardRequest' => 0,
                    'platform' => 'mobile',
                    'accountLevel' => 2,
                    'withdrawal_per_transaction' => $transactionLimit
                ]);
            }



            $getcurrentUser = User::where('ref_code', $user->ref_code)->first();

            // Log::info($getcurrentUser);



            $url = 'https://api.globaldatacompany.com/verifications/v1/verify';

            $minimuAge = date('Y') - $request->yearOfBirth;


            $countryApproval = AllCountries::where('name', $request->country)->where('approval', 1)->first();

            if (isset($countryApproval)) {
                $info = $this->identificationAPI($url, $request->firstname, $request->lastname, $request->dayOfBirth, $request->monthOfBirth, $request->yearOfBirth, $minimuAge, $request->address, $request->city, $request->country, $request->zipcode, $request->telephone, $request->email, $mycode->code);


                if (isset($info->TransactionID) == true) {

                    $result = $this->transStatus($info->TransactionID);

                    // $res = $this->getTransRec($result->TransactionRecordId);


                    if ($info->Record->RecordStatus == "nomatch") {

                        // $message = "error";
                        // $title = "Oops!";
                        // $link = "contact";
                        $message = "success";
                        $title = "Great";
                        $link = "/";
                        $data = $user;
                        $statusCode = 200;

                        $resInfo = strtoupper($info->Record->RecordStatus) . ", Welcome to PaySprint, World's #1 Affordable Payment Method that enables you to send and receive money, pay Invoice and bills and getting paid at anytime. You will be able to add money to your wallet, Pay Invoice or Utility bills, but you will not be able to send or receive money or withdraw money from your Wallet pending the verification of Government issued Photo ID and Utility bill or Bank statement uploaded. \nKindly follow these steps to upload the required information: \na. login to PaySprint Account on Mobile App or Web app at www.paysprint.ca \nb. Go to profile page, take a Selfie of yourself and upload along with a copy of Goverment Issued Photo ID, a copy of Utility bills and business documents \nAll other features would be enabled for you as soon as Compliance Team verifies your information \nThank you for your interest in PaySprint.\nCompliance Team @PaySprint \ninfo@paysprint.ca";

                        User::where('id', $getcurrentUser->id)->update(['accountLevel' => 2, 'countryapproval' => 1, 'transactionRecordId' => $info->TransactionID]);


                        $this->createNotification($newRefcode, "Hello " . $request->firstname . ", Welcome to PaySprint, World's #1 Affordable Payment Method that enables you to send and receive money, pay Invoice and bills and getting paid at anytime. You will be able to add money to your wallet, Pay Invoice or Utility bills, but you will not be able to send or receive money or withdraw money from your Wallet pending the verification of Government issued Photo ID and Utility bill or Bank statement uploaded. \nKindly follow these steps to upload the required information: \na. login to PaySprint Account on Mobile App or Web app at www.paysprint.ca \nb. Go to profile page, take a Selfie of yourself and upload along with a copy of Goverment Issued Photo ID, a copy of Utility bills and business documents \nAll other features would be enabled for you as soon as Compliance Team verifies your information \nThank you for your interest in PaySprint.\nCompliance Team @PaySprint \ninfo@paysprint.ca");
                    } else {
                        $message = "success";
                        $title = "Great";
                        $link = "/";
                        $resInfo = strtoupper($info->Record->RecordStatus) . ", Congratulations!!!. Your account has been approved. Please complete the Quick Set Up to enjoy PaySprint.";
                        $data = $user;
                        $statusCode = 200;

                        // Udpate User Info
                        User::where('id', $getcurrentUser->id)->update(['accountLevel' => 2, 'approval' => 1, 'countryapproval' => 1, 'bvn_verification' => 1, 'transactionRecordId' => $info->TransactionID]);

                        $this->createNotification($newRefcode, "Hello " . $request->firstname . ", PaySprint is the fastest and affordable method of Sending and Receiving money, Paying Invoice and Getting Paid at anytime!. Welcome on board.");
                    }
                } else {

                    $message = "success";
                    $title = "Great";
                    $link = "/";
                    $resInfo = "Welcome to PaySprint, World's #1 Affordable Payment Method that enables you to send and receive money, pay Invoice and bills and getting paid at anytime. You will be able to add money to your wallet, Pay Invoice or Utility bills, but you will not be able to send or receive money or withdraw money from your Wallet pending the verification of Government issued Photo ID and Utility bill or Bank statement uploaded. \nKindly follow these steps to upload the required information: \na. login to PaySprint Account on Mobile App or Web app at www.paysprint.ca \nb. Go to profile page, take a Selfie of yourself and upload along with a copy of Goverment Issued Photo ID, a copy of Utility bills and business documents \nAll other features would be enabled for you as soon as Compliance Team verifies your information \nThank you for your interest in PaySprint.\nCompliance Team @PaySprint \ninfo@paysprint.ca";
                    $data = $user;
                    $statusCode = 200;

                    User::where('id', $getcurrentUser->id)->update(['accountLevel' => 2, 'countryapproval' => 1, 'transactionRecordId' => NULL]);

                    $this->createNotification($newRefcode, "Hello " . $request->firstname . ", Welcome to PaySprint, World's #1 Affordable Payment Method that enables you to send and receive money, pay Invoice and bills and getting paid at anytime. You will be able to add money to your wallet, Pay Invoice or Utility bills, but you will not be able to send or receive money or withdraw money from your Wallet pending the verification of Government issued Photo ID and Utility bill or Bank statement uploaded. \nKindly follow these steps to upload the required information: \na. login to PaySprint Account on Mobile App or Web app at www.paysprint.ca \nb. Go to profile page, take a Selfie of yourself and upload along with a copy of Goverment Issued Photo ID, a copy of Utility bills and business documents \nAll other features would be enabled for you as soon as Compliance Team verifies your information \nThank you for your interest in PaySprint.\nCompliance Team @PaySprint \ninfo@paysprint.ca");

                    // $resp = $info->Message;
                }


                $this->name = $request->firstname . ' ' . $request->lastname;
                // $this->email = "bambo@vimfile.com";
                $this->email = $request->email;
                $this->subject = "Welcome to PaySprint";

                $mailmessage = "Welcome to PaySprint, World's #1 Affordable Payment Method that enables you to send and receive money, pay Invoice and bills and getting paid at anytime. You will be able to add money to your wallet, Pay Invoice or Utility bills, but you will not be able to send or receive money or withdraw money from your Wallet pending the verification of Government issued Photo ID and Utility bill or Bank statement uploaded. <br> Kindly follow these steps to upload the required information: <br> a. login to PaySprint Account on Mobile App or Web app at www.paysprint.ca <br> b. Go to profile page, take a Selfie of yourself and upload along with a copy of Goverment Issued Photo ID, a copy of Utility bills and business documents <br> All other features would be enabled for you as soon as Compliance Team verifies your information <br> Thank you for your interest in PaySprint. <br><br> Compliance Team @PaySprint <br> info@paysprint.ca";

                $this->message = '<p>' . $mailmessage . '</p>';


                $this->sendEmail($this->email, "Fund remittance");


                if($request->country == "India"){

                    $this->name = $request->firstname . ' ' . $request->lastname;
                    // $this->email = "bambo@vimfile.com";
                    $this->email = $request->email;
                    $this->subject = "Special Notice";

                    $mailmessage = "Dear ".$request->firstname.", If you are presenting India Aadhaar Card as the form of identification, kindly upload your India Permanent Account Number card as well using same icon.Thanks";

                    $this->message = '<p>' . $mailmessage . '</p>';


                    $this->sendEmail($this->email, "Fund remittance");



                }

            } else {

                $message = "error";
                $title = "Oops!";
                $link = "contact";
                $resInfo = "PaySprint is not yet available for use in your country. You can contact our Customer Service Executives for further assistance";
                $data = [];
                $statusCode = 400;

                User::where('id', $getcurrentUser->id)->update(['accountLevel' => 0, 'countryapproval' => 0, 'transactionRecordId' => NULL]);
            }


            $this->mailListCategorize($request->firstname . ' ' . $request->lastname, $request->email, $request->address, $request->telephone, "New Consumers", $request->country, 'Subscription');

            // Log::info("New user registration via mobile app by: ".$request->firstname.' '.$request->lastname." from ".$request->state.", ".$request->country." \n\n STATUS: ".$resInfo);

            $this->slack("New user registration via mobile app by: " . $request->firstname . ' ' . $request->lastname . " from " . $request->state . ", " . $request->country . " \n\n STATUS: " . $resInfo, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));

            // $message = "success";
            // $title = "Great";
            // $link = "/";
            // $resInfo = "Hello ".$request->firstname."!, Welcome to PaySprint!";
            // $data = $user;
            // $statusCode = 200;





            $status = $statusCode;

            $resData = ['data' => $data, 'message' => $resInfo, 'status' => $status];
        } else {

            $error = implode(",", $validator->messages()->all());

            $resData = ['data' => [], 'message' => $error, 'status' => 400];
            $status = 400;
        }




        return $this->returnJSON($resData, $status);
    }

    public function userLogin(Request $request, User $user)
    {

        try {

            // Validate Login

            $validator = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if (!Auth::attempt($validator)) {
                $status = 400;
                $data = [];
                $message = 'Invalid email or password';
            } else {
                $token = Auth::user()->createToken('authToken')->accessToken;


                $getUser = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol', 'accountLevel', 'flagged', 'bvn_number', 'bvn_account_number', 'bvn_bank', 'bvn_account_name', 'bvn_verification')->where('email', $request->email)->first();

                if (Hash::check($request->password, $getUser->password)) {


                    $countryApproval = AllCountries::where('name', $getUser->country)->where('approval', 1)->first();



                    if (isset($countryApproval)) {

                        if ($getUser->flagged == 1) {
                            $data = [];
                            $status = 400;
                            $message = 'Hello ' . $getUser->name . ', Access to the account is not currently available. Kindly contact the Admin using this link: https://paysprint.ca/contact';

                            $this->createNotification($getUser->refCode, $message);
                        }
                        // elseif($getUser->accountLevel == 0){
                        //     $data = [];
                        //     $status = 400;
                        //     $message = 'Hello '.$getUser->name.', Our system is yet to complete your registration. Kindly upload a copy of Government-issued Photo ID, a copy of a Utility Bill or Bank Statement that matches your name with the current address and also take a Selfie of yourself (if using the mobile app) and upload in your profile setting to complete the verification process. Kindly contact the admin using the contact us form if you require further assistance. Thank You';

                        //     $this->createNotification($getUser->refCode, $message);
                        // }
                        else {

                            $countryInfo = $this->getCountryCode($getUser->country);

                            $currencyCode = $countryInfo->currencyCode;
                            $currencySymbol = $countryInfo->currencySymbol;




                            // Update User API Token


                            $userData = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol', 'accountLevel', 'cardRequest', 'flagged', 'loginCount', 'pass_checker', 'pass_date', 'lastLogin', 'bvn_number', 'bvn_account_number', 'bvn_bank', 'bvn_account_name', 'bvn_verification')->where('email', $request->email)->first();

                            $loginCount = $userData->loginCount + 1;

                            if ($userData->pass_checker > 0 && $userData->pass_date <= date('Y-m-d')) {
                                $pass_date = $userData->pass_date;
                            } else {
                                $pass_date = date('Y-m-d');
                            }

                            User::where('email', $request->email)->update(['api_token' => $token, 'currencyCode' => $currencyCode, 'currencySymbol' => $currencySymbol, 'lastLogin' => date('d-m-Y h:i A'), 'pass_date' => $pass_date, 'loginCount' => $loginCount]);

                            $userInfo = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol', 'accountLevel', 'cardRequest', 'flagged', 'loginCount', 'pass_checker', 'pass_date', 'lastLogin', 'bvn_number', 'bvn_account_number', 'bvn_bank', 'bvn_account_name', 'bvn_verification')->where('email', $request->email)->first();

                            $data = $userInfo;
                            $status = 200;
                            $message = 'Login successful';

                            $this->createNotification($userInfo->refCode, "Hello " . $getUser->name . ", Your login was successful. Welcome back");

                            $usercity = $this->myLocation()->city;
                            $usercountry = $this->myLocation()->country;
                            $userip = $this->myLocation()->query;

                            $this->checkLoginInfo($userInfo->refCode, $usercity, $usercountry, $userip);
                        }

                        User::where('email', $request->email)->update(['countryapproval' => 1]);
                    } else {

                        $data = [];
                        $status = 400;
                        $message = 'Hello ' . $getUser->name . ', PaySprint is currently not available in your country. You can contact our Customer Service Executives for further enquiries. Thanks';

                        User::where('email', $request->email)->update(['countryapproval' => 0]);

                        $this->createNotification($getUser->refCode, "PaySprint is currently not available in your country. You can contact our Customer Service Executives for further enquiries. Thanks");
                    }
                } else {
                    $data = [];
                    $status = 400;
                    $message = 'Incorrect password';

                    $this->createNotification($getUser->refCode, "You tried to login with an incorrect password");
                }
            }
        } catch (\Throwable $th) {
            $data = [];
            $status = 400;
            $message = $th->getMessage();
        }


        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

        return $this->returnJSON($resData, $status);
    }


    public function updateProfile(Request $request, User $user)
    {

        $user = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'nin_front as ninFront', 'drivers_license_front as driversLicenseFront', 'international_passport_front as internationalPassportFront', 'nin_back as ninBack', 'drivers_license_back as driversLicenseBack', 'international_passport_back as internationalPassportBack', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol', 'dayOfBirth', 'monthOfBirth', 'yearOfBirth', 'cardRequest', 'bvn_number', 'bvn_account_number', 'bvn_bank', 'bvn_account_name', 'bvn_verification')->where('api_token', $request->bearerToken())->first();


        User::where('id', $user->id)->update($request->all());

        if ($request->hasFile('nin_front')) {
            $this->uploadDocument($user->id, $request->file('nin_front'), 'document/nin_front', 'nin_front');

            $this->createNotification($user->refCode, "Hello " . $user->name . ", You have successfully uploaded the front page of your national identity card.");
        }
        if ($request->hasFile('nin_back')) {
            $this->uploadDocument($user->id, $request->file('nin_back'), 'document/nin_back', 'nin_back');
            $this->createNotification($user->refCode, "Hello " . $user->name . ", You have successfully uploaded the back page of your national identity card.");
        }
        if ($request->hasFile('drivers_license_front')) {
            $this->uploadDocument($user->id, $request->file('drivers_license_front'), 'document/drivers_license_front', 'drivers_license_front');
            $this->createNotification($user->refCode, "Hello " . $user->name . ", You have successfully uploaded the front page of your drivers license.");
        }
        if ($request->hasFile('drivers_license_back')) {
            $this->uploadDocument($user->id, $request->file('drivers_license_back'), 'document/drivers_license_back', 'drivers_license_back');
            $this->createNotification($user->refCode, "Hello " . $user->name . ", You have successfully uploaded the back page of your drivers license.");
        }
        if ($request->hasFile('international_passport_front')) {
            $this->uploadDocument($user->id, $request->file('international_passport_front'), 'document/international_passport_front', 'international_passport_front');
            $this->createNotification($user->refCode, "Hello " . $user->name . ", You have successfully uploaded your international passport.");
        }
        if ($request->hasFile('international_passport_back')) {
            $this->uploadDocument($user->id, $request->file('international_passport_back'), 'document/international_passport_back', 'international_passport_back');
            $this->createNotification($user->refCode, "Hello " . $user->name . ", You have successfully uploaded your international passport.");
        }
        if ($request->hasFile('incorporation_doc_front')) {
            $this->uploadDocument($user->id, $request->file('incorporation_doc_front'), 'document/incorporation_doc_front', 'incorporation_doc_front');
            $this->createNotification($user->refCode, "Incorporation document successfully uploaded");
            $this->createNotification($user->refCode, "Hello " . $user->name . ", You have successfully uploaded your document.");
        }
        // if($request->hasFile('incorporation_doc_back')){
        //     $this->uploadDocument($user->id, $request->file('incorporation_doc_back'), 'document/incorporation_doc_back', 'incorporation_doc_back');
        //     $this->createNotification($user->refCode, "Hello ".$user->name.", You have successfully uploaded the back page of your incorporation document.");
        // }
        if ($request->hasFile('avatar')) {
            $this->uploadDocument($user->id, $request->file('avatar'), 'profilepic/avatar', 'avatar');
            $this->createNotification($user->refCode, "Hello " . $user->name . ", You have successfully updated your profile picture.");
        }


        $data = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'accountType', 'nin_front as ninFront', 'drivers_license_front as driversLicenseFront', 'international_passport_front as internationalPassportFront', 'nin_back as ninBack', 'drivers_license_back as driversLicenseBack', 'international_passport_back as internationalPassportBack', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol', 'dayOfBirth', 'monthOfBirth', 'yearOfBirth', 'cardRequest', 'bvn_number', 'bvn_account_number', 'bvn_bank', 'bvn_account_name', 'bvn_verification')->where('api_token', $request->bearerToken())->first();

        $status = 200;

        $resData = ['data' => $data, 'message' => 'Profile updated', 'status' => $status];


        return $this->returnJSON($resData, $status);
    }

    public function changePlan(Request $request)
    {
        try {
            $thisuser = User::where('api_token', $request->bearerToken())->first();


            // Check if Account is verified
            if ($thisuser->account_check < 2) {
                $data = [];
                $status = 400;
                $message = 'You account needs to be verified before continuing';
            } else {


                if ($thisuser->accountType == 'Individual') {
                    $subType = 'Consumer Monthly Subscription';
                } else {
                    $subType = 'Merchant Monthly Subscription';
                }

                $getSub = TransactionCost::where('country', $thisuser->country)->where('structure', $subType)->first();


                // Check merchant test mode
                $client = ClientInfo::where('user_id', $thisuser->ref_code)->first();

                if(isset($client) && $client->accountMode == "test"){
                    $data = [];
                    $status = 400;
                    $message = 'You are in test mode';

                    $resData = ['data' => $data, 'message' => $message, 'status' => $status];

                    return $this->returnJSON($resData, $status);
                }





                // Check my plan
                if ($thisuser->plan == "basic") {
                    $plan = 'classic';
                    $planName = 'classic paid plan';
                    $amount = $getSub->fixed;
                    $today = date('Y-m-d');

                    $recMessage = "<p>This is a confirmation that your PaySprint Account has been upgraded to a Paid Plan. Your subscription would be renewed at the next billing cycle ".date('d-m-Y', strtotime($today. "+28 days")).".</p><p>If this was a mistake, kindly login to your PaySprint Account to downgrade the Account.</p><p>Your current plan is CLASSIC PAID PLAN and </p>";

                } else {
                    $plan = 'basic';
                    $planName = 'Free Forever';
                    $amount = "0";

                    $recMessage = "<p>This is a confirmation that your PaySprint Account has been downgraded to Free Plan. Your subscription would not be renewed at the next billing cycle.</p><p>If this was a mistake, kindly login to your PaySprint Account to Upgrade the Account.</p><p>Your current plan is FREE FOREVER and </p>";
                }

                // Check wallet Balalnce


                if ($thisuser->wallet_balance >= $amount) {
                    $duration = "monthly";

                    User::where('api_token', $request->bearerToken())->update(['plan' => $plan]);

                    $expire_date = Carbon::now()->addMonth()->toDateTimeString();

                    UpgradePlan::updateOrInsert(['userId' => $thisuser->ref_code], ['userId' => $thisuser->ref_code, 'plan' => $plan, 'amount' => $amount, 'duration' => $duration, 'expire_date' => $expire_date]);

                    $walletBalance = $thisuser->wallet_balance - $amount;

                    User::where('id', $thisuser->id)->update(['wallet_balance' => $walletBalance]);

                    // Send Mail
                    $transaction_id = "wallet-" . date('dmY') . time();

                    $activity = $subType . " of " . $thisuser->currencyCode . '' . number_format($amount, 2) . " charged from your Wallet. Your current plan is " . strtoupper($planName);
                    $credit = 0;
                    $debit = $amount;
                    $reference_code = $transaction_id;
                    $balance = 0;
                    $trans_date = date('Y-m-d');
                    $status = "Delivered";
                    $action = "Wallet debit";
                    $regards = $thisuser->ref_code;
                    $statement_route = "wallet";



                    $sendMsg = 'Hello ' . strtoupper($thisuser->name) . ', ' . $activity . '. You now have ' . $thisuser->currencyCode . ' ' . number_format($walletBalance, 2) . ' balance in your account';
                    $sendPhone = "+" . $thisuser->code . $thisuser->telephone;



                    $this->insStatement($thisuser->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route);

                    $this->createNotification($thisuser->ref_code, "Hello " . strtoupper($thisuser->name) . ", " . $sendMsg);

                    $this->name = $thisuser->name;
                    $this->email = $thisuser->email;
                    $this->subject = $activity;

                    $this->message = '<p>' . $recMessage . '</p><p>You now have <strong>' . $thisuser->currencyCode . ' ' . number_format($walletBalance, 2) . '</strong> balance in your account</p>';

                    $this->monthlyChargeInsert($thisuser->ref_code, $thisuser->country, $amount, $thisuser->currencyCode);

                    $this->slack($sendMsg, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));


                    $this->sendEmail($this->email, "Fund remittance");

                    $usergetPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

                    if (isset($usergetPhone)) {

                        $sendPhone = $thisuser->telephone;
                    } else {
                        $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
                    }

                    if ($thisuser->country == "Nigeria") {

                        $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                        $this->sendSms($sendMsg, $correctPhone);
                    } else {
                        $this->sendMessage($sendMsg, $sendPhone);
                    }


                    $data = User::where('api_token', $request->bearerToken())->first();;
                    $status = 200;
                    $message = 'Account successfully updated.';
                } else {
                    $data = [];
                    $status = 400;
                    $message = 'Insufficient wallet balance to complete action';
                }
            }
        } catch (\Throwable $th) {
            $data = [];
            $status = 400;
            $message = $th->getMessage();
        }

        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

        return $this->returnJSON($resData, $status);
    }

    public function monthlyChargeInsert($ref_code, $country, $amount, $currency)
    {
        MonthlyFee::insert(['ref_code' => $ref_code, 'country' => $country, 'amount' => $amount, 'currency' => $currency]);
    }

    public function updateMerchantProfile(Request $request, Admin $admin, ClientInfo $clientinfo)
    {

        $user = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'nin_front as ninFront', 'drivers_license_front as driversLicenseFront', 'international_passport_front as internationalPassportFront', 'nin_back as ninBack', 'drivers_license_back as driversLicenseBack', 'international_passport_back as internationalPassportBack', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol', 'dayOfBirth', 'monthOfBirth', 'yearOfBirth', 'cardRequest', 'bvn_number', 'bvn_account_number', 'bvn_bank', 'bvn_account_name', 'bvn_verification')->where('api_token', $request->bearerToken())->first();


        User::where('id', $user->id)->update($request->all());

        $adminName = explode(" ", $request->name);

        $admin->where('email', $user->email)->update(['firstname' => $adminName[0], 'lastname' => $adminName[1]]);

        $clientinfo->where('email', $user->email)->update(['firstname' => $adminName[0], 'lastname' => $adminName[1], 'telephone' => $request->telephone, 'country' => $request->country, 'state' => $request->state, 'city' => $request->city, 'zip_code' => $request->zip]);

        if ($request->hasFile('nin_front')) {
            $this->uploadDocument($user->id, $request->file('nin_front'), 'document/nin_front', 'nin_front');

            $this->createNotification($user->refCode, "Hello " . $user->name . ", You have successfully uploaded the front page of your national identity card.");
        }
        if ($request->hasFile('nin_back')) {
            $this->uploadDocument($user->id, $request->file('nin_back'), 'document/nin_back', 'nin_back');
            $this->createNotification($user->refCode, "Hello " . $user->name . ", You have successfully uploaded the back page of your national identity card.");
        }
        if ($request->hasFile('drivers_license_front')) {
            $this->uploadDocument($user->id, $request->file('drivers_license_front'), 'document/drivers_license_front', 'drivers_license_front');
            $this->createNotification($user->refCode, "Hello " . $user->name . ", You have successfully uploaded the front page of your drivers license.");
        }
        if ($request->hasFile('drivers_license_back')) {
            $this->uploadDocument($user->id, $request->file('drivers_license_back'), 'document/drivers_license_back', 'drivers_license_back');
            $this->createNotification($user->refCode, "Hello " . $user->name . ", You have successfully uploaded the back page of your drivers license.");
        }
        if ($request->hasFile('international_passport_front')) {
            $this->uploadDocument($user->id, $request->file('international_passport_front'), 'document/international_passport_front', 'international_passport_front');
            $this->createNotification($user->refCode, "Hello " . $user->name . ", You have successfully uploaded your international passport.");
        }
        if ($request->hasFile('international_passport_back')) {
            $this->uploadDocument($user->id, $request->file('international_passport_back'), 'document/international_passport_back', 'international_passport_back');
            $this->createNotification($user->refCode, "Hello " . $user->name . ", You have successfully uploaded your international passport.");
        }
        if ($request->hasFile('avatar')) {
            $this->uploadDocument($user->id, $request->file('avatar'), 'profilepic/avatar', 'avatar');
            $this->createNotification($user->refCode, "Hello " . $user->name . ", You have successfully updated your profile picture.");
        }


        $data = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'accountType', 'nin_front as ninFront', 'drivers_license_front as driversLicenseFront', 'international_passport_front as internationalPassportFront', 'nin_back as ninBack', 'drivers_license_back as driversLicenseBack', 'international_passport_back as internationalPassportBack', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol', 'dayOfBirth', 'monthOfBirth', 'yearOfBirth', 'cardRequest', 'bvn_number', 'bvn_account_number', 'bvn_bank', 'bvn_account_name', 'bvn_verification')->where('api_token', $request->bearerToken())->first();

        $status = 200;

        $resData = ['data' => $data, 'message' => 'Profile updated', 'status' => $status];


        return $this->returnJSON($resData, $status);
    }


    public function updateMerchantBusinessProfile(Request $request, ClientInfo $clientinfo)
    {

        $user = User::where('api_token', $request->bearerToken())->first();

        $clientinfo->where('email', $user->email)->update(['business_name' => $request->businessName, 'address' => $request->businessAddress, 'corporate_type' => $request->corporate_type, 'industry' => $request->industry, 'website' => $request->businessWebsite, 'type_of_service' => $request->type_of_service, 'description' => $request->businessDescription, 'nature_of_business' => $request->nature_of_business, 'companyRegistrationNumber' => $request->companyRegistrationNumber, 'tradingName' => $request->tradingName, 'dateOfIncorporation' => $request->dateOfIncorporation, 'einNumber' => $request->einNumber]);

        if ($request->hasFile('incorporation_doc_front')) {
            $this->uploadDocument($user->id, $request->file('incorporation_doc_front'), 'document/incorporation_doc_front', 'incorporation_doc_front');
            $this->createNotification($user->ref_code, "Incorporation document successfully uploaded");
            $this->createNotification($user->ref_code, "Hello " . $user->name . ", You have successfully uploaded the front page of your incorporation document.");
        }
        if ($request->hasFile('incorporation_doc_back')) {
            $this->uploadDocument($user->id, $request->file('incorporation_doc_back'), 'document/incorporation_doc_back', 'incorporation_doc_back');
            $this->createNotification($user->ref_code, "Hello " . $user->name . ", You have successfully uploaded the back page of your incorporation document.");
        }
        if ($request->hasFile('directors_document')) {
            $this->uploadDocument($user->id, $request->file('directors_document'), 'document/directors_document', 'directors_document');
            $this->createNotification($user->ref_code, "Hello " . $user->name . ", You have successfully uploaded your Register of Directors");
        }
        if ($request->hasFile('shareholders_document')) {
            $this->uploadDocument($user->id, $request->file('shareholders_document'), 'document/shareholders_document', 'shareholders_document');
            $this->createNotification($user->ref_code, "Hello " . $user->name . ", You have successfully uploaded your Register of Shareholders");
        }
        if ($request->hasFile('proof_of_identity_1')) {
            $this->uploadDocument($user->id, $request->file('proof_of_identity_1'), 'document/proof_of_identity_1', 'proof_of_identity_1');
            $this->createNotification($user->ref_code, "Hello " . $user->name . ", You have successfully uploaded your Proof of Identity - 1 Director");
        }
        if ($request->hasFile('proof_of_identity_2')) {
            $this->uploadDocument($user->id, $request->file('proof_of_identity_2'), 'document/proof_of_identity_2', 'proof_of_identity_2');
            $this->createNotification($user->ref_code, "Hello " . $user->name . ", You have successfully uploaded your Proof of Identity - 1 UBO");
        }
        if ($request->hasFile('aml_policy')) {
            $this->uploadDocument($user->id, $request->file('aml_policy'), 'document/aml_policy', 'aml_policy');
            $this->createNotification($user->ref_code, "Hello " . $user->name . ", You have successfully uploaded your AML Policy and Procedures");
        }
        if ($request->hasFile('compliance_audit_report')) {
            $this->uploadDocument($user->id, $request->file('compliance_audit_report'), 'document/compliance_audit_report', 'compliance_audit_report');
            $this->createNotification($user->ref_code, "Hello " . $user->name . ", You have successfully uploaded your Latest Compliance External Audit Report");
        }
        if ($request->hasFile('organizational_chart')) {
            $this->uploadDocument($user->id, $request->file('organizational_chart'), 'document/organizational_chart', 'organizational_chart');
            $this->createNotification($user->ref_code, "Hello " . $user->name . ", You have successfully uploaded your Organizational Chart");
        }
        if ($request->hasFile('financial_license')) {
            $this->uploadDocument($user->id, $request->file('financial_license'), 'document/financial_license', 'financial_license');
            $this->createNotification($user->ref_code, "Hello " . $user->name . ", You have successfully uploaded your Proof of Financial License");
        }


        $data = $clientinfo->where('email', $user->email)->first();

        $status = 200;

        $resData = ['data' => $data, 'message' => 'Profile updated', 'status' => $status];

        $this->updatePoints($user->id, 'Promote business');

        return $this->returnJSON($resData, $status);
    }


    public function updateOwnerAndControllersProfile(Request $request, ClientInfo $clientinfo)
    {

        $user = User::where('api_token', $request->bearerToken())->first();

        $clientinfo->where('email', $user->email)->update(['shareholder' => $request->shareholder, 'directordetails' => $request->directordetails]);

        $data = $clientinfo->where('email', $user->email)->first();

        $status = 200;

        $resData = ['data' => $data, 'message' => 'Owner and Controllers Information Updated', 'status' => $status];

        return $this->returnJSON($resData, $status);
    }


    public function promoteYourBusiness(Request $request, ClientInfo $clientinfo)
    {

        try {
            $user = User::where('api_token', $request->bearerToken())->first();

            // Get Monthly charge for this country

            if ($user->accountType == "Individual") {
                $subType = "Consumer Monthly Subscription";
            } else {
                $subType = "Merchant Monthly Subscription";
            }

            $getTranscost = TransactionCost::where('structure', $subType)->where('country', $user->country)->first();

            if (isset($getTranscost)) {

                $minBal = $this->minimumWithdrawal($user->country);

                if (($user->wallet_balance - $minBal) > $getTranscost->fixed) {

                    $walletBalance = $user->wallet_balance - $getTranscost->fixed;

                    User::where('id', $user->id)->update(['wallet_balance' => $walletBalance]);

                    // Send Mail
                    $transaction_id = "wallet-" . date('dmY') . time();

                    $activity = "Withdrawal of " . $user->currencyCode . '' . number_format($getTranscost->fixed, 2) . " from Wallet to Promote Business";
                    $credit = 0;
                    $debit = $getTranscost->fixed;
                    $reference_code = $transaction_id;
                    $balance = 0;
                    $trans_date = date('Y-m-d');
                    $status = "Delivered";
                    $action = "Wallet debit";
                    $regards = $user->ref_code;
                    $statement_route = "wallet";


                    $sendMsg = 'Hello ' . strtoupper($user->name) . ', ' . $activity . '. You now have ' . $user->currencyCode . ' ' . number_format($walletBalance, 2) . ' balance in your account';
                    $sendPhone = "+" . $user->code . $user->telephone;


                    // Senders statement
                    $this->insStatement($user->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route);

                    $this->createNotification($user->ref_code, "Hello " . strtoupper($user->name) . ", " . $sendMsg);

                    $this->name = $user->name;
                    $this->email = $user->email;
                    $this->subject = $activity;

                    $this->message = '<p>' . $activity . '</p><p>You now have <strong>' . $user->currencyCode . ' ' . number_format($walletBalance, 2) . '</strong> balance in your account</p>';


                    $clientinfo->where('email', $user->email)->update(['business_name' => $request->businessName, 'address' => $request->businessAddress, 'corporate_type' => $request->corporate_type, 'industry' => $request->industry, 'website' => $request->businessWebsite, 'type_of_service' => $request->type_of_service, 'description' => $request->businessDescription, 'promote_business' => 1, 'push_notification' => 1, 'nature_of_business' => $request->nature_of_business, 'companyRegistrationNumber' => $request->companyRegistrationNumber, 'tradingName' => $request->tradingName, 'dateOfIncorporation' => $request->dateOfIncorporation, 'einNumber' => $request->einNumber]);

                    if ($request->hasFile('incorporation_doc_front')) {
                        $this->uploadDocument($user->id, $request->file('incorporation_doc_front'), 'document/incorporation_doc_front', 'incorporation_doc_front');
                        $this->createNotification($user->ref_code, "Incorporation document successfully uploaded");
                        $this->createNotification($user->ref_code, "Hello " . $user->name . ", You have successfully uploaded the front page of your incorporation document.");
                    }
                    if ($request->hasFile('incorporation_doc_back')) {
                        $this->uploadDocument($user->id, $request->file('incorporation_doc_back'), 'document/incorporation_doc_back', 'incorporation_doc_back');
                        $this->createNotification($user->ref_code, "Hello " . $user->name . ", You have successfully uploaded the back page of your incorporation document.");
                    }
                    if ($request->hasFile('directors_document')) {
                        $this->uploadDocument($user->id, $request->file('directors_document'), 'document/directors_document', 'directors_document');
                        $this->createNotification($user->ref_code, "Hello " . $user->name . ", You have successfully uploaded your Register of Directors");
                    }
                    if ($request->hasFile('shareholders_document')) {
                        $this->uploadDocument($user->id, $request->file('shareholders_document'), 'document/shareholders_document', 'shareholders_document');
                        $this->createNotification($user->ref_code, "Hello " . $user->name . ", You have successfully uploaded your Register of Shareholders");
                    }
                    if ($request->hasFile('proof_of_identity_1')) {
                        $this->uploadDocument($user->id, $request->file('proof_of_identity_1'), 'document/proof_of_identity_1', 'proof_of_identity_1');
                        $this->createNotification($user->ref_code, "Hello " . $user->name . ", You have successfully uploaded your Proof of Identity - 1 Director");
                    }
                    if ($request->hasFile('proof_of_identity_2')) {
                        $this->uploadDocument($user->id, $request->file('proof_of_identity_2'), 'document/proof_of_identity_2', 'proof_of_identity_2');
                        $this->createNotification($user->ref_code, "Hello " . $user->name . ", You have successfully uploaded your Proof of Identity - 1 UBO");
                    }
                    if ($request->hasFile('aml_policy')) {
                        $this->uploadDocument($user->id, $request->file('aml_policy'), 'document/aml_policy', 'aml_policy');
                        $this->createNotification($user->ref_code, "Hello " . $user->name . ", You have successfully uploaded your AML Policy and Procedures");
                    }
                    if ($request->hasFile('compliance_audit_report')) {
                        $this->uploadDocument($user->id, $request->file('compliance_audit_report'), 'document/compliance_audit_report', 'compliance_audit_report');
                        $this->createNotification($user->ref_code, "Hello " . $user->name . ", You have successfully uploaded your Latest Compliance External Audit Report");
                    }
                    if ($request->hasFile('organizational_chart')) {
                        $this->uploadDocument($user->id, $request->file('organizational_chart'), 'document/organizational_chart', 'organizational_chart');
                        $this->createNotification($user->ref_code, "Hello " . $user->name . ", You have successfully uploaded your Organizational Chart");
                    }
                    if ($request->hasFile('financial_license')) {
                        $this->uploadDocument($user->id, $request->file('financial_license'), 'document/financial_license', 'financial_license');
                        $this->createNotification($user->ref_code, "Hello " . $user->name . ", You have successfully uploaded your Proof of Financial License");
                    }




                    if ($user->country == "Nigeria") {

                        $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                        $this->sendSms($sendMsg, $correctPhone);
                    } else {
                        $this->sendMessage($sendMsg, $sendPhone);
                    }


                    $data = $clientinfo->where('email', $user->email)->first();

                    $status = 200;

                    $resData = ['data' => $data, 'message' => 'Business Promoted. You can see your business get listed on www.getverifiedpro.com', 'status' => $status];

                    $this->updatePoints($user->id, 'Promote Business');
                } else {

                    $data = [];

                    $message = "Your minimum wallet balance is " . $user->currencyCode . ' ' . number_format($minBal, 2) . ". Please add money to continue transaction";

                    $status = 400;


                    $resData = ['data' => $data, 'message' => $message, 'status' => $status];
                }
            } else {

                $data = [];

                $status = 400;

                $resData = ['data' => $data, 'message' => "Unable to promote business for your country. Contact Admin", 'status' => $status];
            }
        } catch (\Throwable $th) {
            $data = [];

            $status = 400;

            $resData = ['data' => $data, 'message' => $th->getMessage(), 'status' => $status];
        }

        return $this->returnJSON($resData, $status);
    }

    public function broadcastYourBusiness(Request $request, ClientInfo $clientinfo)
    {

        try {
            $user = User::where('api_token', $request->bearerToken())->first();

            // Get Monthly charge for this country

            if ($user->accountType == "Individual") {
                $subType = "Consumer Monthly Subscription";
            } else {
                $subType = "Merchant Monthly Subscription";
            }

            $getTranscost = TransactionCost::where('structure', $subType)->where('country', $user->country)->first();

            if (isset($getTranscost)) {

                $minBal = $this->minimumWithdrawal($user->country);

                if (($user->wallet_balance - $minBal) > $getTranscost->fixed) {

                    $walletBalance = $user->wallet_balance - $getTranscost->fixed;

                    User::where('id', $user->id)->update(['wallet_balance' => $walletBalance]);

                    // Send Mail
                    $transaction_id = "wallet-" . date('dmY') . time();

                    $activity = "Withdrawal of " . $user->currencyCode . '' . number_format($getTranscost->fixed, 2) . " from Wallet to Broadcast Business";
                    $credit = 0;
                    $debit = $getTranscost->fixed;
                    $reference_code = $transaction_id;
                    $balance = 0;
                    $trans_date = date('Y-m-d');
                    $status = "Delivered";
                    $action = "Wallet debit";
                    $regards = $user->ref_code;
                    $statement_route = "wallet";


                    $sendMsg = 'Hello ' . strtoupper($user->name) . ', ' . $activity . '. You now have ' . $user->currencyCode . ' ' . number_format($walletBalance, 2) . ' balance in your account';
                    $sendPhone = "+" . $user->code . $user->telephone;


                    // Senders statement
                    $this->insStatement($user->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route);

                    $this->createNotification($user->ref_code, "Hello " . strtoupper($user->name) . ", " . $sendMsg);

                    $this->name = $user->name;
                    $this->email = $user->email;
                    $this->subject = $activity;

                    $this->message = '<p>' . $activity . '</p><p>You now have <strong>' . $user->currencyCode . ' ' . number_format($walletBalance, 2) . '</strong> balance in your account</p>';


                    $clientinfo->where('email', $user->email)->update(['business_name' => $request->businessName, 'address' => $request->businessAddress, 'corporate_type' => $request->corporate_type, 'industry' => $request->industry, 'website' => $request->businessWebsite, 'type_of_service' => $request->type_of_service, 'description' => $request->businessDescription, 'promote_business' => 1, 'push_notification' => 1, 'nature_of_business' => $request->nature_of_business, 'companyRegistrationNumber' => $request->companyRegistrationNumber, 'tradingName' => $request->tradingName, 'dateOfIncorporation' => $request->dateOfIncorporation, 'einNumber' => $request->einNumber]);

                    if ($request->hasFile('incorporation_doc_front')) {
                        $this->uploadDocument($user->id, $request->file('incorporation_doc_front'), 'document/incorporation_doc_front', 'incorporation_doc_front');
                        $this->createNotification($user->ref_code, "Incorporation document successfully uploaded");
                        $this->createNotification($user->ref_code, "Hello " . $user->name . ", You have successfully uploaded the front page of your incorporation document.");
                    }
                    if ($request->hasFile('incorporation_doc_back')) {
                        $this->uploadDocument($user->id, $request->file('incorporation_doc_back'), 'document/incorporation_doc_back', 'incorporation_doc_back');
                        $this->createNotification($user->ref_code, "Hello " . $user->name . ", You have successfully uploaded the back page of your incorporation document.");
                    }
                    if ($request->hasFile('directors_document')) {
                        $this->uploadDocument($user->id, $request->file('directors_document'), 'document/directors_document', 'directors_document');
                        $this->createNotification($user->ref_code, "Hello " . $user->name . ", You have successfully uploaded your Register of Directors");
                    }
                    if ($request->hasFile('shareholders_document')) {
                        $this->uploadDocument($user->id, $request->file('shareholders_document'), 'document/shareholders_document', 'shareholders_document');
                        $this->createNotification($user->ref_code, "Hello " . $user->name . ", You have successfully uploaded your Register of Shareholders");
                    }
                    if ($request->hasFile('proof_of_identity_1')) {
                        $this->uploadDocument($user->id, $request->file('proof_of_identity_1'), 'document/proof_of_identity_1', 'proof_of_identity_1');
                        $this->createNotification($user->ref_code, "Hello " . $user->name . ", You have successfully uploaded your Proof of Identity - 1 Director");
                    }
                    if ($request->hasFile('proof_of_identity_2')) {
                        $this->uploadDocument($user->id, $request->file('proof_of_identity_2'), 'document/proof_of_identity_2', 'proof_of_identity_2');
                        $this->createNotification($user->ref_code, "Hello " . $user->name . ", You have successfully uploaded your Proof of Identity - 1 UBO");
                    }
                    if ($request->hasFile('aml_policy')) {
                        $this->uploadDocument($user->id, $request->file('aml_policy'), 'document/aml_policy', 'aml_policy');
                        $this->createNotification($user->ref_code, "Hello " . $user->name . ", You have successfully uploaded your AML Policy and Procedures");
                    }
                    if ($request->hasFile('compliance_audit_report')) {
                        $this->uploadDocument($user->id, $request->file('compliance_audit_report'), 'document/compliance_audit_report', 'compliance_audit_report');
                        $this->createNotification($user->ref_code, "Hello " . $user->name . ", You have successfully uploaded your Latest Compliance External Audit Report");
                    }
                    if ($request->hasFile('organizational_chart')) {
                        $this->uploadDocument($user->id, $request->file('organizational_chart'), 'document/organizational_chart', 'organizational_chart');
                        $this->createNotification($user->ref_code, "Hello " . $user->name . ", You have successfully uploaded your Organizational Chart");
                    }
                    if ($request->hasFile('financial_license')) {
                        $this->uploadDocument($user->id, $request->file('financial_license'), 'document/financial_license', 'financial_license');
                        $this->createNotification($user->ref_code, "Hello " . $user->name . ", You have successfully uploaded your Proof of Financial License");
                    }




                    if ($user->country == "Nigeria") {

                        $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                        $this->sendSms($sendMsg, $correctPhone);
                    } else {
                        $this->sendMessage($sendMsg, $sendPhone);
                    }


                    $data = $clientinfo->where('email', $user->email)->first();

                    $status = 200;

                    $resData = ['data' => $data, 'message' => 'Business Promoted. You can see your business get listed on www.getverifiedpro.com', 'status' => $status];

                    $this->updatePoints($user->id, 'Promote business');
                } else {

                    $data = [];

                    $message = "Your minimum wallet balance is " . $user->currencyCode . ' ' . number_format($minBal, 2) . ". Please add money to continue transaction";

                    $status = 400;


                    $resData = ['data' => $data, 'message' => $message, 'status' => $status];
                }
            } else {

                $data = [];

                $status = 400;

                $resData = ['data' => $data, 'message' => "Unable to promote business for your country. Contact Admin", 'status' => $status];
            }
        } catch (\Throwable $th) {
            $data = [];

            $status = 400;

            $resData = ['data' => $data, 'message' => $th->getMessage(), 'status' => $status];
        }

        return $this->returnJSON($resData, $status);
    }



    public function insStatement($email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, $state, $statement_route)
    {
        Statement::insert(['user_id' => $email, 'reference_code' => $reference_code, 'activity' => $activity, 'credit' => $credit, 'debit' => $debit, 'balance' => $balance, 'trans_date' => $trans_date, 'status' => $status, 'action' => $action, 'regards' => $regards, 'state' => $state, 'statement_route' => $statement_route]);
    }


    public function classifiedBusinessDirectory()
    {
        try {
            $data = ClientInfo::where('promote_business', 1)->orderBy('created_at', 'DESC')->get();

            if (count($data) > 0) {

                $status = 200;

                $resData = ['data' => $data, 'message' => 'Success', 'status' => $status];
            } else {
                $status = 200;

                $resData = ['data' => [], 'message' => 'No record', 'status' => $status];
            }
        } catch (\Throwable $th) {

            $status = 400;

            $resData = ['data' => [], 'message' => $th->getMessage(), 'status' => $status];
        }

        return $this->returnJSON($resData, $status);
    }

    public function merchantsByServiceTypes(Request $req)
    {

        $thisuser = User::where('api_token', $req->bearerToken())->first();

        $data = ClientInfo::select('industry')->where('industry', '!=', null)->where('country', $thisuser->country)->orderBy('industry', 'ASC')->groupBy('industry')->get();

        // Log::info($data);

        $status = 200;

        $resData = ['data' => $data, 'message' => 'success', 'status' => $status];

        return $this->returnJSON($resData, $status);
    }


    public function listMerchantsByServiceTypes(Request $req)
    {

        $thisuser = User::where('api_token', $req->bearerToken())->first();

        $query = ClientInfo::select('id', 'user_id as userId', 'business_name as businessName', 'address', 'corporate_type as corporateType', 'industry', 'type_of_service as typeOfService', 'website', 'firstname', 'lastname', 'telephone', 'country', 'state', 'city', 'zip_code as zipCode', 'description', 'email as businessEmail')->where('industry', $req->get('industry'))->where('country', $thisuser->country)->orderBy('created_at', 'DESC')->orderBy('business_name', 'ASC')->get();

        if (count($query) > 0) {

            $data = $query;
            $status = 200;
            $message = 'success';
        } else {
            $data = [];
            $status = 400;
            $message = 'No record';
        }

        // Log::info($data);


        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

        return $this->returnJSON($resData, $status);
    }

    public function getMerchantData(Request $req, $id)
    {

        $query = ClientInfo::select('id', 'user_id as userId', 'business_name as businessName', 'address', 'corporate_type as corporateType', 'industry', 'type_of_service as typeOfService', 'website', 'firstname', 'lastname', 'telephone', 'country', 'state', 'city', 'zip_code as zipCode', 'description')->where('id', $id)->first();

        if (isset($query)) {

            $data = $query;
            $status = 200;
            $message = 'success';
        } else {
            $data = [];
            $status = 400;
            $message = 'No record';
        }


        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

        return $this->returnJSON($resData, $status);
    }


    public function updatePassword(Request $req)
    {


        $validator = Validator::make($req->all(), [
            'oldpassword' => 'required|string',
            'newpassword' => 'required|string',
            'confirmpassword' => 'required|string',
        ]);

        if ($validator->passes()) {

            if ($req->newpassword != $req->confirmpassword) {
                $data = [];
                $message = "Confirm password does not match";
                $status = 400;
            } else {
                $thisuser = User::where('api_token', $req->bearerToken())->first();


                if (Hash::check($req->oldpassword, $thisuser->password)) {
                    // Update
                    $resp = User::where('api_token', $req->bearerToken())->update(['password' => Hash::make($req->newpassword)]);

                    Admin::where('email', $thisuser->email)->update(['password' => Hash::make($req->newpassword)]);

                    $data = $resp;
                    $message = "Saved";
                    $status = 200;

                    $this->createNotification($thisuser->ref_code, "Hello " . strtoupper($thisuser->name) . ", You have successfully updated your password.");
                } else {
                    $data = [];
                    $message = "Your old password is incorrect";
                    $status = 400;
                }
            }
        } else {

            $error = implode(",", $validator->messages()->all());

            $data = [];
            $status = 400;
            $message = $error;
        }

        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

        return $this->returnJSON($resData, $status);
    }


    public function createTransactionPin(Request $req)
    {


        $validator = Validator::make($req->all(), [
            'newpin' => 'required|string',
            'confirmpin' => 'required|string',
        ]);

        if ($validator->passes()) {

            if ($req->newpin != $req->confirmpin) {
                $data = [];
                $message = "The confirm pin does not match";
                $status = 400;
            } else {
                $thisuser = User::where('api_token', $req->bearerToken())->first();

                // Update
                $resp = User::where('api_token', $req->bearerToken())->update(['transaction_pin' => Hash::make($req->newpin)]);

                $data = $resp;
                $message = "Saved";
                $status = 200;

                $this->updatePoints($thisuser->id, 'Quick Set Up');


                $this->createNotification($thisuser->ref_code, "Hello " . strtoupper($thisuser->name) . ", You have successfully created your transaction pin. Keep it SAFE!.");
            }
        } else {

            $error = implode(",", $validator->messages()->all());

            $data = [];
            $status = 400;
            $message = $error;
        }

        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

        return $this->returnJSON($resData, $status);
    }


    public function updateSecurity(Request $req)
    {


        $validator = Validator::make($req->all(), [
            'securityQuestion' => 'required|string',
            'securityAnswer' => 'required|string',
        ]);

        if ($validator->passes()) {

            $thisuser = User::where('api_token', $req->bearerToken())->first();

            // Update
            $resp = User::where('api_token', $req->bearerToken())->update(['securityQuestion' => $req->securityQuestion, 'securityAnswer' => strtolower($req->securityAnswer)]);

            $data = $resp;
            $message = "Saved";
            $status = 200;

            // Log::notice("Hello ".strtoupper($thisuser->name).", You have successfully set up your security question and answer.");

            $this->slack("Hello " . strtoupper($thisuser->name) . ", You have successfully set up your security question and answer.", $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));

            $this->createNotification($thisuser->ref_code, "Hello " . strtoupper($thisuser->name) . ", You have successfully set up your security question and answer.");

            $this->updatePoints($thisuser->id, 'Quick Set Up');
        } else {

            $error = implode(",", $validator->messages()->all());

            $data = [];
            $status = 400;
            $message = $error;
        }

        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

        return $this->returnJSON($resData, $status);
    }


    public function bvnVerification(Request $req)
    {
        

        try {


            $thisuser = User::where('api_token', $req->bearerToken())->first();


            $response = $this->verifyBVN($req->bvn, $req->account_number, $req->bank_code, $req->account_name, $req->bearerToken());

            Log::info(json_encode($response));

            // dd($response);


            $bank = ListOfBanks::where('code', $req->bank_code)->first();



            BVNVerificationList::insert(['user_id' => $thisuser->id, 'bvn_number' => $req->bvn, 'bvn_account_number' => $req->account_number, 'bvn_account_name' => $req->account_name, 'bvn_bank' => $bank->name, 'status' => $response->transactionStatus, 'description' => $response->description]);

            if ($response->responseCode == "00" && $response->verificationStatus == "VERIFIED" || $response->responseCode == "00" && $response->transactionStatus == "SUCCESSFUL") {

                if ($thisuser->approval == 2 && $thisuser->accountLevel == 3) {
                    User::where('api_token', $req->bearerToken())->update(['bvn_number' => $req->bvn, 'bvn_verification' => 1, 'accountLevel' => 3, 'approval' => 2,  'bvn_account_number' => $req->account_number, 'bvn_account_name' => $req->account_name, 'bvn_bank' => $bank->name]);
                } else {
                    User::where('api_token', $req->bearerToken())->update(['bvn_number' => $req->bvn, 'bvn_verification' => 1, 'accountLevel' => 2, 'approval' => 1,  'bvn_account_number' => $req->account_number, 'bvn_account_name' => $req->account_name, 'bvn_bank' => $bank->name]);
                }


                $this->updatePoints($thisuser->id, 'Quick Set Up');



                $data = $response->response;
                $message = $response->transactionStatus;
                // $message = $response->description;
                $status = 200;
            } else {
                $data = [];
                $message = $response->description;
                $status = 400;
            }

            $resData = ['data' => $data, 'message' => $message, 'status' => $status];

            return $this->returnJSON($resData, $status);
        } catch (\Throwable $th) {
            // Log::critical("BVN Verification Error: ".$th->getMessage());

            $this->slack("BVN Verification Error: " . $th->getMessage(), $room = "error-logs", $icon = ":longbox:", env('LOG_SLACK_WEBHOOK_URL'));
        }
    }


    public function accountNumberVerification(Request $req)
    {
        $response = $this->verifyAccountNumber($req->account_number, $req->bank_code);

        if ($response->status == true) {
            $data = $response->data;
            $message = $response->message;
            $status = 200;
        } else {

            $data = [];
            $message = $response->message;
            $status = 400;
        }

        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

        return $this->returnJSON($resData, $status);
    }




    public function linkAccount(Request $req)
    {


        $validator = Validator::make($req->all(), [
            'account_number' => 'required|string',
            'transaction_pin' => 'required|string',
        ]);

        if ($validator->passes()) {

            $thisuser = User::where('api_token', $req->bearerToken())->first();

            // Update
            $getAccount = User::where('ref_code', $req->account_number)->first();

            if (isset($getAccount)) {

                if (Hash::check($req->transaction_pin, $getAccount->transaction_pin)) {

                    // Link Account
                    $resp = LinkAccount::updateOrInsert(['ref_code' => $thisuser->ref_code, 'link_ref_code' => $getAccount->ref_code], ['ref_code' => $thisuser->ref_code, 'link_ref_code' => $req->account_number, 'user_id' => $thisuser->id]);

                    $info = "Hello " . strtoupper($thisuser->name) . ", You have linked your account " . $req->account_number . " (" . $getAccount->currencyCode . ") with your primary account " . $thisuser->ref_code . " (" . $thisuser->currencyCode . ")";

                    $data = true;
                    $message = "Successfull";
                    $status = 200;


                    // Log::notice($info);


                    $this->slack($info, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));

                    $this->createNotification($thisuser->ref_code, $info);
                } else {

                    $error = "Invalid transaction pin";

                    $data = [];
                    $status = 400;
                    $message = $error;
                }
            } else {
                $error = "Account number not found";

                $data = [];
                $status = 400;
                $message = $error;
            }
        } else {

            $error = implode(",", $validator->messages()->all());

            $data = [];
            $status = 400;
            $message = $error;
        }

        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

        return $this->returnJSON($resData, $status);
    }



    public function otherAccount(Request $req)
    {


        $validator = Validator::make($req->all(), [
            'account_number' => 'required|string',
        ]);

        if ($validator->passes()) {

            $thisuser = User::where('api_token', $req->bearerToken())->first();

            // Update
            $getAccount = User::where('ref_code', $req->account_number)->first();

            if (isset($getAccount)) {

                $link = route('sign out', $getAccount->id);

                $info = "Hello " . strtoupper($thisuser->name) . ", You have switched account to " . $req->account_number . " (" . $getAccount->currencyCode . ") from your primary account " . $thisuser->ref_code . " (" . $thisuser->currencyCode . ")";

                $data = $link;
                $message = "Successfull";
                $status = 200;


                // Log::notice($info);

                $this->slack($info, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));

                $this->createNotification($thisuser->ref_code, $info);
            } else {
                $error = "Account number not found";

                $data = [];
                $status = 400;
                $message = $error;
            }
        } else {

            $error = implode(",", $validator->messages()->all());

            $data = [];
            $status = 400;
            $message = $error;
        }

        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

        return $this->returnJSON($resData, $status);
    }


    public function secondaryAccounts(Request $req)
    {
        $thisuser = User::where('api_token', $req->bearerToken())->first();

        if (isset($thisuser)) {

            $data = LinkAccount::where('user_id', $thisuser->id)->get();
            $message = "Success";
            $status = 200;
        } else {

            $error = "Unable to access this user";

            $data = [];
            $status = 400;
            $message = $error;
        }

        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

        return $this->returnJSON($resData, $status);
    }

    public function updateAutoDeposit(Request $req)
    {


        $validator = Validator::make($req->all(), [
            'auto_deposit' => 'required|string',
        ]);

        if ($validator->passes()) {

            $thisuser = User::where('api_token', $req->bearerToken())->first();

            // Update
            $resp = User::where('api_token', $req->bearerToken())->update(['auto_deposit' => $req->auto_deposit]);

            // send Mail and SMS

            $recMsg = "Hi " . $thisuser->name . ", You have successfully turned " . $req->auto_deposit . " your Auto Deposit Status.  PaySprint Team";

            $merchantPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

            if (isset($merchantPhone)) {

                $recPhone = $thisuser->telephone;
            } else {
                $recPhone = "+" . $thisuser->code . $thisuser->telephone;
            }



            $this->name = $thisuser->name;
            // $this->email = "bambo@vimfile.com";
            $this->email = $thisuser->email;
            $this->subject = "You have successfully turned " . $req->auto_deposit . " your Auto Deposit Status.";

            if ($req->auto_deposit == "ON") {
                $message = "The Auto Deposit feature on PaySprint is turned ON. You can now enjoy a stress-free transaction deposit on your PaySprint Account. <br><br> Thanks, PaySprint Team";
            } else {
                $message = "The Auto Deposit feature on PaySprint is turned OFF. You will need to manually accept all transfers made to your PaySprint wallet. If you want to enjoy a stress-free transaction deposit, you may have visit your profile on PaySprint Account to turn ON the feature. <br><br> Thanks, PaySprint Team";
            }

            $this->message = '<p>' . $message . '</p>';


            $this->sendEmail($this->email, "Fund remittance");

            if ($thisuser->country == "Nigeria") {

                $correctPhone = preg_replace("/[^0-9]/", "", $recPhone);
                $this->sendSms($recMsg, $correctPhone);
            } else {
                $this->sendMessage($recMsg, $recPhone);
            }

            $data = $resp;
            $message = "Saved";
            $status = 200;

            // Log::info("Hello ".strtoupper($thisuser->name).", You have successfully turned ".$req->auto_deposit." your Auto Deposit Status.");

            $this->slack("Hello " . strtoupper($thisuser->name) . ", You have successfully turned " . $req->auto_deposit . " your Auto Deposit Status.", $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));


            $this->createNotification($thisuser->ref_code, "Hello " . strtoupper($thisuser->name) . ", You have successfully turned " . $req->auto_deposit . " your Auto Deposit Status.");
        } else {

            $error = implode(",", $validator->messages()->all());

            $data = [];
            $status = 400;
            $message = $error;
        }

        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

        return $this->returnJSON($resData, $status);
    }



    public function resetPassword(Request $req)
    {


        $validator = Validator::make($req->all(), [
            'securityQuestion' => 'required|string',
            'securityAnswer' => 'required|string',
            'newpassword' => 'required|string',
            'confirmpassword' => 'required|string',
        ]);

        if ($validator->passes()) {

            $thisuser = User::where('api_token', $req->bearerToken())->first();

            // Check if Security Answer is correct
            if (strtolower($req->securityAnswer) != $thisuser->securityAnswer) {
                // You have provided a wrong answer to your security question

                $error = "You have provided a wrong answer to your security question";

                $data = [];
                $status = 400;
                $message = $error;
            } else {

                // Check Password Match

                if ($req->newpassword != $req->confirmpassword) {
                    $data = [];
                    $message = "Confirm password does not match";
                    $status = 400;
                } else {

                    $resp = User::where('api_token', $req->bearerToken())->update(['password' => Hash::make($req->newpassword)]);

                    Admin::where('email', $thisuser->email)->update(['password' => Hash::make($req->newpassword)]);

                    $data = $resp;
                    $message = "Saved";
                    $status = 200;

                    $this->createNotification($thisuser->ref_code, "Hello " . strtoupper($thisuser->name) . ", You have successfully reset your password.");
                }
            }
        } else {

            $error = implode(",", $validator->messages()->all());

            $data = [];
            $status = 400;
            $message = $error;
        }

        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

        return $this->returnJSON($resData, $status);
    }


    public function resetTransactionPin(Request $req)
    {


        $validator = Validator::make($req->all(), [
            'securityQuestion' => 'required|string',
            'securityAnswer' => 'required|string',
            'newpin' => 'required|string',
            'confirmpin' => 'required|string',
        ]);

        if ($validator->passes()) {

            $thisuser = User::where('api_token', $req->bearerToken())->first();

            // Check if Security Answer is correct
            if (strtolower($req->securityAnswer) != $thisuser->securityAnswer) {
                // You have provided a wrong answer to your security question

                $error = "You have provided a wrong answer to your security question";

                $data = [];
                $status = 400;
                $message = $error;
            } else {

                if ($req->newpin != $req->confirmpin) {
                    $data = [];
                    $message = "The confirm pin does not match";
                    $status = 400;
                } else {

                    // Update
                    $resp = User::where('api_token', $req->bearerToken())->update(['transaction_pin' => Hash::make($req->newpin)]);

                    $data = $resp;
                    $message = "Saved";
                    $status = 200;

                    $this->createNotification($thisuser->ref_code, "Transaction pin updated");

                    $this->createNotification($thisuser->ref_code, "Hello " . strtoupper($thisuser->name) . ", You have successfully changed your transaction pin. Keep it SAFE!.");
                }
            }
        } else {

            $error = implode(",", $validator->messages()->all());

            $data = [];
            $status = 400;
            $message = $error;
        }

        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

        return $this->returnJSON($resData, $status);
    }


    public function updateTransactionPin(Request $req)
    {


        $validator = Validator::make($req->all(), [
            'oldpin' => 'required|string',
            'newpin' => 'required|string',
            'confirmpin' => 'required|string',
        ]);

        if ($validator->passes()) {

            if ($req->newpin != $req->confirmpin) {
                $data = [];
                $message = "The confirm pin does not match";
                $status = 400;
            } else {
                $thisuser = User::where('api_token', $req->bearerToken())->first();

                if (Hash::check($req->oldpin, $thisuser->transaction_pin)) {
                    // Update
                    $resp = User::where('api_token', $req->bearerToken())->update(['transaction_pin' => Hash::make($req->newpin)]);

                    $data = $resp;
                    $message = "Saved";
                    $status = 200;

                    $this->createNotification($thisuser->ref_code, "Hello " . strtoupper($thisuser->name) . ", You have successfully updated your transaction pin. Keep it SAFE!.");
                } else {
                    $data = [];
                    $message = "Your old transaction pin is incorrect";
                    $status = 400;
                }
            }
        } else {

            $error = implode(",", $validator->messages()->all());

            $data = [];
            $status = 400;
            $message = $error;
        }

        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

        return $this->returnJSON($resData, $status);
    }



    public function uploadDocument($id, $file, $pathWay, $rowName)
    {



        //Get filename with extension
        $filenameWithExt = $file->getClientOriginalName();
        // Get just filename
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        // Get just extension
        $extension = $file->getClientOriginalExtension();
        // Filename to store
        $fileNameToStore = rand() . '_' . time() . '.' . $extension;


        $path = $file->move(public_path('../../' . $pathWay . '/'), $fileNameToStore);


        $docPath = "http://" . $_SERVER['HTTP_HOST'] . "/" . $pathWay . "/" . $fileNameToStore;


        User::where('id', $id)->update(['' . $rowName . '' => $docPath, 'lastUpdated' => date('Y-m-d H:i:s')]);

        $this->updatePoints($id, 'Quick Set Up');
    }


    public function logout(Request $request, $id)
    {
        $user = User::where('id', $id)->first();

        User::where('id', $id)->update(['api_token' => encrypt($user->email)]);

        Auth::login($user);

        return redirect('/home');
    }



    public function sendEmail($objDemoa, $purpose)
    {
        $objDemo = new \stdClass();
        $objDemo->purpose = $purpose;
        if ($purpose == "Payment Received") {

            $objDemo->name = $this->name;
            $objDemo->email = $this->email;
            $objDemo->amount = $this->amount;
            $objDemo->paypurpose = $this->paypurpose;
            $objDemo->coy_name = $this->coy_name;
            $objDemo->subject = $this->subject;
        } elseif ($purpose == "Payment Successful") {

            $objDemo->name = $this->name;
            $objDemo->email = $this->email;
            $objDemo->amount = $this->amount;
            $objDemo->paypurpose = $this->paypurpose;
            $objDemo->coy_name = $this->coy_name;
            $objDemo->subject = $this->subject2;
        } elseif ($purpose == 'Fund remittance') {
            $objDemo->name = $this->name;
            $objDemo->email = $this->email;
            $objDemo->subject = $this->subject;
            $objDemo->message = $this->message;
        }

        Mail::to($objDemoa)
            ->send(new sendEmail($objDemo));
    }
}