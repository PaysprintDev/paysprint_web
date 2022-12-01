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
            $documentRecord = new api\v1\UserController();


            // Get bearer...
            $bearer = ClientInfo::where('api_secrete_key', $req->bearerToken())->first();

            $ref_code = mt_rand(0000000, 9999999);
            $avatar = 'https://res.cloudinary.com/paysprint/image/upload/v1651130089/assets/paysprint_jpeg_black_bk_2_w4hzub_ioffkg.jpg';

            $dummy = [
                'id'   => 1,
                'name' => $req->firstname . ' ' . $req->lastname,
                'email' => $req->email,
                'ref_code' => $ref_code,
                'country' => $req->country,
                'telephone' => $req->telephone,
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


            // $transCost = TransactionCost::where('method', "Merchant Minimum Withdrawal")->where('country', $req->country)->first();
            $transCost = TransactionCost::where('method', "Consumer Minimum Withdrawal")->where('country', $req->country)->first();

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

                        $mycode = $this->getCountryCode($req->country);

                        $currencyCode = $mycode->currencyCode;
                        $currencySymbol = $mycode->currencySymbol;


                        $data = ['code' => $mycode->callingCode, 'ref_code' => $ref_code, 'name' => $getanonuser->name, 'email' => $getanonuser->email, 'password' => $generatedPassword, 'address' => '', 'telephone' => $getanonuser->telephone, 'city' => '', 'state' => '', 'country' => $getanonuser->country, 'currencyCode' => $currencyCode, 'currencySymbol' => $currencySymbol, 'accountType' => "Individual", 'corporationType' => '', 'zip' => '', 'wallet_balance' => $getanonuser->wallet_balance, 'dayOfBirth' => '', 'monthOfBirth' => '', 'yearOfBirth' => '', 'platform' => $bearer->business_name . ' api', 'approval' => 1, 'accountLevel' => 2, 'withdrawal_per_transaction' => $transactionLimit, 'referred_by' => $bearer->user_id, 'knowAboutUs' => $bearer->business_name . ' api', 'accountPurpose' => $bearer->business_name . ' api transaction', 'transactionSize' => '', 'sourceOfFunding' => $bearer->business_name . ' api', 'avatar' => $avatar, 'nin_front' => $req->national_id_card, 'drivers_license_front' => $req->drivers_license, 'international_passport_front' => $req->international_passport, 'incorporation_doc_front' => $req->utility_bill];

                        if (getallheaders()["dev_mode"] != 'test') {
                            User::updateOrCreate(['email' => $getanonuser->email], $data);

                            // Update file upload...
                            $user = User::where('email', $getanonuser->email)->first();

                            if ($req->hasFile('national_id_card')) {
                                $documentRecord->uploadDocument($user->id, $req->file('national_id_card'), 'document/' . $bearer->business_name . '/nin_front', 'nin_front');

                                $documentRecord->createNotification($user->ref_code, "Hello " . $user->name . ", You have successfully uploaded your national identity card.", $bearer->business_name . ' api');
                            }

                            if ($req->hasFile('drivers_license')) {
                                $documentRecord->uploadDocument($user->id, $req->file('drivers_license'), 'document/' . $bearer->business_name . '/drivers_license_front', 'drivers_license_front');
                                $documentRecord->createNotification($user->ref_code, "Hello " . $user->name . ", You have successfully uploaded your drivers license.", $bearer->business_name . ' api');
                            }

                            if ($req->hasFile('international_passport')) {
                                $documentRecord->uploadDocument($user->id, $req->file('international_passport'), 'document/' . $bearer->business_name . '/international_passport_front', 'international_passport_front');
                                $documentRecord->createNotification($user->ref_code, "Hello " . $user->name . ", You have successfully uploaded your international passport.", $bearer->business_name . ' api');
                            }

                            if ($req->hasFile('utility_bill')) {
                                $documentRecord->uploadDocument($user->id, $req->file('utility_bill'), 'document/' . $bearer->business_name . '/incorporation_doc_front', 'incorporation_doc_front');
                                $documentRecord->createNotification($user->ref_code, "Document successfully uploaded");
                                $documentRecord->createNotification($user->ref_code, "Hello " . $user->name . ", You have successfully uploaded your document.", $bearer->business_name . ' api');
                            }
                        }


                        // if (isset($insAdmin)) {
                        // Set session
                        $getMerchant = User::where('ref_code', $ref_code)->first();

                        $getMoney = Statement::where('user_id', $getanonuser->email)->get();

                        if (count($getMoney) > 0) {
                            foreach ($getMoney as $key => $value) {

                                Statement::where('reference_code', $value->reference_code)->update(['status' => 'Delivered']);
                            }
                        }


                        AnonUsers::where('ref_code', $ref_code)->delete();

                        $this->slack("New consumer registration via " . $bearer->business_name . " api as: " . $req->firstname . ' ' . $req->lastname . " from " . $req->country, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));


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

                            $message = "Welcome to PaySprint, World's #1 Affordable Payment Method that enables you to send and receive money, pay Invoice and bills and getting paid at anytime. <br><br> You will be able to add money to your wallet, Create and Send Invoice, Accept and Receive payment from all the channels, Pay received Invoice or Utility bills and Withdraw money as soon as the Compliance Team verifies your information. <br><br> Login to PaySprint Account on Mobile App or Web app at <a href='https://paysprint.ca/login'>www.paysprint.ca/login</a> with the information below <hr><br> Email: <strong>" . $req->email . "</strong> <br> Password: <strong>" . $req->firstname . "</strong> <hr> <br> Thank you for your interest in PaySprint. <br><br> Compliance Team @PaySprint <br> info@paysprint.ca";


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

                            // Send Message to 3rd party Account...

                            $record->name = $bearer->business_name;
                            //  $record->email = "bambo@paysprint.ca";
                            $record->to = $bearer->email;
                            $record->subject = "PaySprint handshake successfull";

                            $message = "You have successfully made an handshake with PaySprint, confirm the user information below: <hr><br> Name: " . $req->firstname . " " . $req->lastname . '<br> Email: ' . $req->email . '<br> Mode: <b>' . getallheaders()["dev_mode"] . ' mode</b>. <br><br> Please note that for <b>test mode</b>, records are only for test cases and no actual data is created on PaySprint.';

                            $record->message = '<p>' . $message . '</p>';


                            $record->sendEmail($record->to, "Refund Request");



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

                        $this->slack("New consumer registration via " . $bearer->business_name . " api as: " . $req->firstname . ' ' . $req->lastname . " from " . $req->country, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));
                        // } else {

                        //     $data = [];
                        //     $message = 'Can not create user account';
                        //     $status = 400;
                        // }
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

                        $data = ['code' => $phoneCode, 'ref_code' => $newRefcode, 'name' => $req->firstname . ' ' . $req->lastname, 'email' => $req->email, 'password' => $generatedPassword, 'address' => '', 'telephone' => $req->telephone, 'city' => '', 'state' => '', 'country' => $req->country, 'currencyCode' => $currencyCode, 'currencySymbol' => $currencySymbol, 'accountType' => "Individual", 'corporationType' => '', 'zip' => '', 'dayOfBirth' => '', 'monthOfBirth' => '', 'yearOfBirth' => '', 'platform' => $bearer->business_name . ' api', 'approval' => 1, 'accountLevel' => 2, 'withdrawal_per_transaction' => $transactionLimit, 'referred_by' => $bearer->user_id, 'knowAboutUs' => $bearer->business_name . ' api', 'accountPurpose' => $bearer->business_name . ' api transaction', 'transactionSize' => '', 'sourceOfFunding' => $bearer->business_name . ' api', 'avatar' => $avatar, 'nin_front' => $req->national_id_card, 'drivers_license_front' => $req->drivers_license, 'international_passport_front' => $req->international_passport, 'incorporation_doc_front' => $req->utility_bill];

                        if (getallheaders()["dev_mode"] != 'test') {
                            User::updateOrCreate(['email' => $req->email], $data);
                        }



                        $getMerchant = User::where('ref_code', $newRefcode)->first();


                        $this->slack("New consumer registration via " . $bearer->business_name . " api as: " . $req->firstname . ' ' . $req->lastname . " from " . $req->country, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));

                        $countryApproval = AllCountries::where('name', $req->country)->where('approval', 1)->first();


                        if (isset($countryApproval)) {

                            $message = "success";

                            if (getallheaders()["dev_mode"] != 'test') {
                                User::where('id', $getMerchant->id)->update(['accountLevel' => 2, 'countryapproval' => 1, 'bvn_verification' => 1, 'transactionRecordId' => NULL]);


                                // Update file upload...
                                $user = User::where('email', $req->email)->first();


                                if ($req->hasFile('national_id_card')) {
                                    $documentRecord->uploadDocument($user->id, $req->file('national_id_card'), 'document/' . $bearer->business_name . '/nin_front', 'nin_front');

                                    $documentRecord->createNotification($user->ref_code, "Hello " . $user->name . ", You have successfully uploaded your national identity card.", $bearer->business_name . ' api');
                                }

                                if ($req->hasFile('drivers_license')) {
                                    $documentRecord->uploadDocument($user->id, $req->file('drivers_license'), 'document/' . $bearer->business_name . '/drivers_license_front', 'drivers_license_front');
                                    $documentRecord->createNotification($user->ref_code, "Hello " . $user->name . ", You have successfully uploaded your drivers license.", $bearer->business_name . ' api');
                                }

                                if ($req->hasFile('international_passport')) {
                                    $documentRecord->uploadDocument($user->id, $req->file('international_passport'), 'document/' . $bearer->business_name . '/international_passport_front', 'international_passport_front');
                                    $documentRecord->createNotification($user->ref_code, "Hello " . $user->name . ", You have successfully uploaded your international passport.", $bearer->business_name . ' api');
                                }

                                if ($req->hasFile('utility_bill')) {
                                    $documentRecord->uploadDocument($user->id, $req->file('utility_bill'), 'document/' . $bearer->business_name . '/incorporation_doc_front', 'incorporation_doc_front');
                                    $documentRecord->createNotification($user->ref_code, "Document successfully uploaded");
                                    $documentRecord->createNotification($user->ref_code, "Hello " . $user->name . ", You have successfully uploaded your document.", $bearer->business_name . ' api');
                                }
                            }




                            $record->name = $req->firstname . ' ' . $req->lastname;
                            //  $record->email = "bambo@paysprint.ca";
                            $record->to = $req->email;
                            $record->subject = "Welcome to PaySprint";

                            $message = "Welcome to PaySprint, World's #1 Affordable Payment Method that enables you to send and receive money, pay Invoice and bills and getting paid at anytime. <br><br> You will be able to add money to your wallet, Create and Send Invoice, Accept and Receive payment from all the channels, Pay received Invoice or Utility bills and Withdraw money as soon as the Compliance Team verifies your information. <br><br> Login to PaySprint Account on Mobile App or Web app at <a href='https://paysprint.ca/login'>www.paysprint.ca/login</a> with the information below <hr><br> Email: <strong>" . $req->email . "</strong> <br> Password: <strong>" . $req->firstname . "</strong> <hr> <br> Thank you for your interest in PaySprint. <br><br> Compliance Team @PaySprint <br> info@paysprint.ca";


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

                            // Send Message to 3rd party Account...

                            $record->name = $bearer->business_name;
                            //  $record->email = "bambo@paysprint.ca";
                            $record->to = $bearer->email;
                            $record->subject = "PaySprint handshake successfull";

                            $message = "You have successfully made an handshake with PaySprint, confirm the user information below: <hr><br> Name: " . $req->firstname . " " . $req->lastname . '<br> Email: ' . $req->email . '<br> Mode: <b>' . getallheaders()["dev_mode"] . ' mode</b>. <br><br> Please note that for <b>test mode</b>, records are only for test cases and no actual data is created on PaySprint.';

                            $record->message = '<p>' . $message . '</p>';


                            $record->sendEmail($record->to, "Refund Request");

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

    public function transactionFeeCharge(Request $req)
    {
        try {
            $record = new AdminController();

            $data = $record->transactionChargeFees($req->country, 'Add Funds/Money', $req->method);
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


    public function merchantFeeCharge(String $country, String $method)
    {
        try {
            $record = new AdminController();

            $data = $record->transactionChargeFees($country, 'Add Funds/Money', $method);
        } catch (\Throwable $th) {
            $data = [];
        }

        return $data;
    }
}
