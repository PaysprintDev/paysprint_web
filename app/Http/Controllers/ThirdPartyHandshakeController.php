<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\ThirdPartyHandshake;
use App\User;
use App\ClientInfo;
use App\Admin;
use App\TransactionCost;
use App\ReferralGenerate;
use App\ReferredUsers;
use App\UserClosed;
use App\AnonUsers;
use App\Statement;
use App\AllCountries;

class ThirdPartyHandshakeController extends Controller
{
    public function handshakeRegistration(Request $req)
    {
        try {
            $record = new AdminController();

            // Get bearer...
            $bearer = ClientInfo::where('api_secrete_key', $req->bearerToken())->first();

            $ref_code = mt_rand(0000000, 9999999);
            $businessName = $req->businessName != '' ? $req->businessName : $req->firstname . ' ' . $req->lastname;
            $avatar = 'https://res.cloudinary.com/paysprint/image/upload/v1651130089/assets/paysprint_jpeg_black_bk_2_w4hzub_ioffkg.jpg';

            $dummy = [
                'id'   => 1,
                'name' => $req->firstname . ' ' . $req->lastname,
                'email' => $req->email,
                'ref_code' => $ref_code,
                'country' => $req->country,
                'telephone' => $req->telephone,
                'businessname' => $req->businessName,
                'wallet_balance' => 0.00
            ];

            // Insert record into third party handshake...
            $req['platform'] = $bearer->business_name;
            $req['invited_userId'] = $bearer->user_id;

            if (getallheaders()["dev_mode"] != 'test') {
                ThirdPartyHandshake::updateOrCreate(['email' => $req->email], $req->all());
            }


            $checkClient = ClientInfo::where('email', $req->email)->first();

            $generatedUsername = $req->firstname . '' . time();
            $generatedPassword = Hash::make($req->firstname);
            $api_token = uniqid() . md5($req->email) . time();

            // Check Admin for existing username...
            $getUsername = Admin::where('username', $generatedUsername)->first();

            if (isset($getUsername)) {
                $generatedUsername = $req->firstname . '' . time();
            }


            $transCost = TransactionCost::where('method', "Merchant Minimum Withdrawal")->where('country', $req->country)->first();

            if (isset($transCost)) {
                $transactionLimit = $transCost->fixed;
            } else {
                $transactionLimit = 0;
            }


            $userClosedExist = UserClosed::where('email', $req->email)->first();

            if (isset($userClosedExist)) {

                $data = [];
                $message = 'This account has been closed on PaySprint due to some security reasons.';
                $status = 400;

                $resData = ['data' => $data, 'message' => $message, 'status' => $status];

                return $this->returnJSON($resData, $status);
            }



            if (isset($checkClient)) {
                $data = [];
                $message = 'User already exist on PaySprint';
                $status = 200;
            } else {
                // Check if user exist
                $userExist = User::where('email', $req->email)->first();

                if (isset($userExist)) {
                    $data = [];
                    $message = 'User already exist on PaySprint';
                    $status = 200;
                } else {

                    $getRef = User::where('ref_code', $bearer->user_id)->first();

                    $referral_points = $getRef->referral_points + 100;

                    if (getallheaders()["dev_mode"] != 'test') {
                        User::where('id', $getRef->id)->update([
                            'referral_points' => $referral_points
                        ]);
                    }






                    // Add to generate link
                    $refGen = ReferralGenerate::where('ref_code', $bearer->user_id)->first();

                    if (isset($refGen)) {
                        $ref_count = $refGen->referred_count + 1;

                        if (getallheaders()["dev_mode"] != 'test') {
                            ReferralGenerate::where('ref_code', $bearer->user_id)->update(['referred_count' => $ref_count]);
                        }
                    } else {

                        if (getallheaders()["dev_mode"] != 'test') {
                            ReferralGenerate::insert([
                                'ref_code' => $bearer->user_id,
                                'name' => $getRef->name,
                                'email' => $getRef->email,
                                'ref_link' => route('home') . '/register?ref_code=' . $bearer->user_id,
                                'referred_count' => '1',
                                'country' => $getRef->country,
                                'is_admin' => false
                            ]);
                        }
                    }

                    if (getallheaders()["dev_mode"] != 'test') {
                        ReferredUsers::insert(['ref_code' => $bearer->user_id, 'referred_user' => $req->email, 'referral_points' => 100]);
                    }




                    $getanonuser = AnonUsers::where('email', $req->email)->first();

                    if (isset($getanonuser)) {
                        // Insert

                        if (getallheaders()["dev_mode"] != 'test') {
                            $insClient = ClientInfo::insert(['user_id' => $ref_code, 'business_name' => $businessName, 'address' => '', 'corporate_type' => '', 'firstname' => $req->firstname, 'lastname' => $req->lastname, 'email' => $getanonuser->email, 'country' => $req->country, 'state' => '', 'city' => '', 'zip_code' => '', 'industry' => '', 'telephone' => $req->telephone, 'website' => '', 'api_secrete_key' => md5(uniqid($generatedUsername, true)) . date('dmY') . time(), 'type_of_service' => '']);

                            $insAdmin = Admin::insert(['user_id' => $ref_code, 'firstname' => $req->firstname, 'lastname' => $req->lastname, 'username' => $generatedUsername, 'password' => $generatedPassword, 'role' => 'Merchant', 'email' => $getanonuser->email]);
                        } else {
                            $insAdmin = ['user_id' => $ref_code, 'firstname' => $req->firstname, 'lastname' => $req->lastname, 'username' => $generatedUsername, 'password' => $generatedPassword, 'role' => 'Merchant', 'email' => $getanonuser->email];
                        }




                        $mycode = $this->getCountryCode($req->country);

                        $currencyCode = $mycode->currencyCode;
                        $currencySymbol = $mycode->currencySymbol;


                        $data = ['code' => $mycode->callingCode, 'ref_code' => $ref_code, 'businessname' => $businessName, 'name' => $getanonuser->name, 'email' => $getanonuser->email, 'password' => $generatedPassword, 'address' => '', 'telephone' => $getanonuser->telephone, 'city' => '', 'state' => '', 'country' => $getanonuser->country, 'currencyCode' => $currencyCode, 'currencySymbol' => $currencySymbol, 'accountType' => "Merchant", 'corporationType' => '', 'zip' => '', 'api_token' => $api_token, 'wallet_balance' => $getanonuser->wallet_balance, 'dayOfBirth' => '', 'monthOfBirth' => '', 'yearOfBirth' => '', 'platform' => $bearer->business_name . ' api', 'accountLevel' => 2, 'withdrawal_per_transaction' => $transactionLimit, 'referred_by' => $bearer->user_id, 'knowAboutUs' => $bearer->business_name . ' api', 'accountPurpose' => $bearer->business_name . ' api transaction', 'transactionSize' => '', 'sourceOfFunding' => $bearer->business_name . ' api', 'avatar' => $avatar];

                        if (getallheaders()["dev_mode"] != 'test') {
                            User::updateOrCreate(['email' => $getanonuser->email], $data);
                        }


                        if (isset($insAdmin)) {
                            // Set session
                            $getMerchant = User::where('ref_code', $ref_code)->first();

                            $getMoney = Statement::where('user_id', $getanonuser->email)->get();

                            if (count($getMoney) > 0) {
                                foreach ($getMoney as $key => $value) {

                                    Statement::where('reference_code', $value->reference_code)->update(['status' => 'Delivered']);
                                }
                            }


                            AnonUsers::where('ref_code', $ref_code)->delete();

                            $this->slack("New merchant registration via " . $bearer->business_name . " api as: " . $req->firstname . ' ' . $req->lastname . " from " . $req->country, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));


                            $countryApproval = AllCountries::where('name', $req->country)->where('approval', 1)->first();

                            if (isset($countryApproval)) {

                                $message = "success";

                                if (getallheaders()["dev_mode"] != 'test') {
                                    User::where('id', $getMerchant->id)->update(['accountLevel' => 2, 'countryapproval' => 1, 'bvn_verification' => 1, 'transactionRecordId' => NULL]);
                                }



                                $record->name = $req->firstname . ' ' . $req->lastname;
                                // $record->email = "bambo@vimfile.com";
                                $record->to = $req->email;
                                $record->subject = "Welcome to PaySprint";

                                $message = "Welcome to PaySprint, World's #1 Affordable Payment Method that enables you to send and receive money, pay Invoice and bills and getting paid at anytime. You will be able to add money to your wallet, Create and Send Invoice, Accept and Receive payment from all the channels, Pay received Invoice or Utility bills, but you will not be able to withdraw money from your Wallet pending the verification of Government issued Photo ID and Utility bill or Bank statement uploaded. <br> Kindly follow these steps to upload the required information: <br> a. login to PaySprint Account on Mobile App or Web app at <a href='" . route('AdminLogin') . "'>www.paysprint.ca/AdminLogin</a> with the information below <br> Username: <strong>" . $generatedUsername . "</strong> Password: <strong>" . $generatedPassword . "</strong> hr> <br> b. Go to profile page, update your profile information and upload documents required. <br> All other features would be enabled for you as soon as the Compliance Team verifies your information <br> Thank you for your interest in PaySprint. <br><br> Compliance Team @PaySprint <br> info@paysprint.ca";


                                $record->message = '<p>' . $message . '</p>';


                                $record->sendEmail($record->to, "Refund Request");


                                if ($req->country == "India") {

                                    $record->name = $req->firstname . ' ' . $req->lastname;
                                    // $record->email = "bambo@paysprint.ca";
                                    $record->email = $req->email;
                                    $record->subject = "Special Notice";

                                    $mailmessage = "Dear " . $req->fname . ", If you are presenting India Aadhaar Card as the form of identification, kindly upload your India Permanent Account Number card as well using same icon.Thanks";

                                    $record->message = '<p>' . $mailmessage . '</p>';


                                    $record->sendEmail($record->email, "Fund remittance");
                                }



                                $data =  getallheaders()["dev_mode"] != 'test' ? User::where('email', $req->email)->first() : $dummy;
                                $message = 'Successfully created account!';
                                $status = 200;
                            } else {

                                $data =  getallheaders()["dev_mode"] != 'test' ? User::where('email', $req->email)->first() : $dummy;
                                $message = 'PaySprint is currently not available in your country. Thanks';
                                $status = 200;

                                if (getallheaders()["dev_mode"] != 'test') {
                                    User::where('id', $getMerchant->id)->update(['accountLevel' => 0, 'countryapproval' => 0, 'transactionRecordId' => NULL]);
                                }
                            }

                            $this->slack("New merchant registration via " . $bearer->business_name . " api as: " . $req->firstname . ' ' . $req->lastname . " from " . $req->country, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));
                        } else {

                            $data = [];
                            $message = 'Can not create user account';
                            $status = 400;
                        }
                    } else {
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


                        if (getallheaders()["dev_mode"] != 'test') {
                            // Insert
                            $insClient = ClientInfo::insert(['user_id' => $newRefcode, 'business_name' => $businessName, 'address' => '', 'corporate_type' => '', 'firstname' => $req->firstname, 'lastname' => $req->lastname, 'email' => $req->email, 'country' => $req->country, 'state' => '', 'city' => '', 'zip_code' => '', 'industry' => '', 'telephone' => $req->telephone, 'website' => '', 'api_secrete_key' => md5(uniqid($generatedUsername, true)) . date('dmY') . time(), 'type_of_service' => '']);

                            $insAdmin = Admin::insert(['user_id' => $newRefcode, 'firstname' => $req->firstname, 'lastname' => $req->lastname, 'username' => $generatedUsername, 'password' => $generatedPassword, 'role' => 'Merchant', 'email' => $req->email]);
                        } else {
                            $insAdmin = ['user_id' => $newRefcode, 'firstname' => $req->firstname, 'lastname' => $req->lastname, 'username' => $generatedUsername, 'password' => $generatedPassword, 'role' => 'Merchant', 'email' => $req->email];
                        }




                        $mycode = $this->getCountryCode($req->country);

                        $currencyCode = $mycode->currencyCode;
                        $currencySymbol = $mycode->currencySymbol;


                        if (isset($mycode->callingCode)) {

                            if ($req->country == "United States") {
                                $phoneCode = "1";
                            } else {
                                $phoneCode = $mycode->callingCode;
                            }
                        } else {
                            $phoneCode = "1";
                        }

                        $data = ['code' => $mycode->callingCode, 'ref_code' => $newRefcode, 'businessname' => $businessName, 'name' => $req->firstname . ' ' . $req->lastname, 'email' => $req->email, 'password' => $generatedPassword, 'address' => '', 'telephone' => $req->telephone, 'city' => '', 'state' => '', 'country' => $req->country, 'currencyCode' => $currencyCode, 'currencySymbol' => $currencySymbol, 'accountType' => "Merchant", 'corporationType' => '', 'zip' => '', 'api_token' => $api_token, 'dayOfBirth' => '', 'monthOfBirth' => '', 'yearOfBirth' => '', 'platform' => $bearer->business_name . ' api', 'accountLevel' => 2, 'withdrawal_per_transaction' => $transactionLimit, 'referred_by' => $bearer->user_id, 'knowAboutUs' => $bearer->business_name . ' api', 'accountPurpose' => $bearer->business_name . ' api transaction', 'transactionSize' => '', 'sourceOfFunding' => $bearer->business_name . ' api', 'avatar' => $avatar];

                        if (getallheaders()["dev_mode"] != 'test') {
                            User::updateOrCreate(['email' => $req->email], $data);
                        }


                        if (isset($insAdmin)) {

                            $getMerchant = User::where('ref_code', $newRefcode)->first();


                            $this->slack("New merchant registration via " . $bearer->business_name . " api as: " . $req->firstname . ' ' . $req->lastname . " from " . $req->country, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));

                            $countryApproval = AllCountries::where('name', $req->country)->where('approval', 1)->first();


                            if (isset($countryApproval)) {

                                $message = "success";

                                if (getallheaders()["dev_mode"] != 'test') {
                                    User::where('id', $getMerchant->id)->update(['accountLevel' => 2, 'countryapproval' => 1, 'bvn_verification' => 1, 'transactionRecordId' => NULL]);
                                }




                                $record->name = $req->firstname . ' ' . $req->lastname;
                                //  $record->email = "bambo@paysprint.ca";
                                $record->to = $req->email;
                                $record->subject = "Welcome to PaySprint";

                                $message = "Welcome to PaySprint, World's #1 Affordable Payment Method that enables you to send and receive money, pay Invoice and bills and getting paid at anytime. You will be able to add money to your wallet, Create and Send Invoice, Accept and Receive payment from all the channels, Pay received Invoice or Utility bills, but you will not be able to withdraw money from your Wallet pending the verification of Government issued Photo ID and Utility bill or Bank statement uploaded. <br> Kindly follow these steps to upload the required information: <br> a. login to PaySprint Account on Mobile App or Web app at <a href='" . route('AdminLogin') . "'>www.paysprint.ca/AdminLogin</a> with the information below <br> Username: <strong>" . $generatedUsername . "</strong> Password: <strong>" . $generatedPassword . "</strong> hr> <br> b. Go to profile page, update your profile information and upload documents required. <br> All other features would be enabled for you as soon as the Compliance Team verifies your information <br> Thank you for your interest in PaySprint. <br><br> Compliance Team @PaySprint <br> info@paysprint.ca";


                                $record->message = '<p>' . $message . '</p>';


                                $record->sendEmail($record->to, "Refund Request");


                                if ($req->country == "India") {

                                    $record->name = $req->firstname . ' ' . $req->lastname;
                                    // $record->email = "bambo@paysprint.ca";
                                    $record->email = $req->email;
                                    $record->subject = "Special Notice";

                                    $mailmessage = "Dear " . $req->fname . ", If you are presenting India Aadhaar Card as the form of identification, kindly upload your India Permanent Account Number card as well using same icon.Thanks";

                                    $record->message = '<p>' . $mailmessage . '</p>';


                                    $record->sendEmail($record->email, "Fund remittance");
                                }



                                $data =  getallheaders()["dev_mode"] != 'test' ? User::where('email', $req->email)->first() : $dummy;
                                $message = 'Successfully created account!';
                                $status = 200;
                            } else {

                                $data =  getallheaders()["dev_mode"] != 'test' ? User::where('email', $req->email)->first() : $dummy;
                                $message = 'PaySprint is currently not available in your country. Thanks';
                                $status = 200;

                                if (getallheaders()["dev_mode"] != 'test') {
                                    User::where('id', $getMerchant->id)->update(['accountLevel' => 0, 'countryapproval' => 0, 'transactionRecordId' => NULL]);
                                }
                            }
                        }
                    }
                }
            }
        } catch (\Throwable $th) {
            $data = [];
            $message = $th->getMessage();
            $status = 400;
        }


        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

        return $this->returnJSON($resData, $status);
    }

    public function availableCountriesonPS(Request $req)
    {
        try {
            $record = new AdminController();

            $data = $record->getActiveCountriesNeededDetails();


            $message = 'Success';
            $status = 200;
        } catch (\Throwable $th) {
            $data = [];
            $message = $th->getMessage();
            $status = 400;
        }



        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

        return $this->returnJSON($resData, $status);
    }
}