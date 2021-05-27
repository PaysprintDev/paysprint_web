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
use App\LinkAccount as LinkAccount;
use App\Mail\sendEmail;

use App\Traits\Trulioo;
use App\Traits\AccountNotify;


class UserController extends Controller
{

    use Trulioo;
    use AccountNotify;

    // User Registration

    public function userRegistration(Request $request, User $user){

        $validator = Validator::make($request->all(), [
            'ref_code' => 'unique:users',
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:users',
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

        if($validator->passes()){

            $ref_code = mt_rand(00000, 99999);

            $mycode = $this->getCountryCode($request->country);


            // Get all ref_codes
            $ref = User::all();

            if(count($ref) > 0){
                foreach($ref as $key => $value){
                    if($value->ref_code == $ref_code){
                        $newRefcode = mt_rand(000000, 999999);
                    }
                    else{
                        $newRefcode = $ref_code;
                    }
                }
            }
            else{
                $newRefcode = $ref_code;
            }


            // Check Anon Users
            $newcustomer = AnonUsers::where('email', $request->email)->first();

            if(isset($newcustomer)){

                    $user = User::create(['code' => $newcustomer->code, 'ref_code' => $newcustomer->ref_code, 'name' => $newcustomer->name, 'email' => $newcustomer->email, 'password' => Hash::make($request->password), 'address' => $newcustomer->address, 'city' => $request->city, 'state' => $request->state, 'country' => $newcustomer->country, 'accountType' => 'Individual', 'api_token' => uniqid().md5($request->email), 'telephone' => $newcustomer->telephone, 'wallet_balance' => $newcustomer->wallet_balance, 'approval' => 0, 'currencyCode' => $mycode[0]->currencies[0]->code, 'currencySymbol' => $mycode[0]->currencies[0]->symbol, 'dayOfBirth' => $request->dayOfBirth, 'monthOfBirth' => $request->monthOfBirth, 'yearOfBirth' => $request->yearOfBirth, 'cardRequest' => 0, 'platform' => 'mobile']);

                    $getMoney = Statement::where('user_id', $newcustomer->email)->get();

                    if(count($getMoney) > 0){
                        foreach($getMoney as $key => $value){
                            Statement::where('reference_code', $value->reference_code)->update(['status' => 'Delivered']);
                        }
                    }
                    else{
                        // Do nothing
                    }

                    AnonUsers::where('ref_code', $newcustomer->ref_code)->delete();

            }
            else{
                $user = User::create([
                    'ref_code' => $newRefcode,
                    'name' => $request->firstname.' '.$request->lastname,
                    'code' => $mycode[0]->callingCodes[0],
                    'email' => $request->email,
                    'address' => $request->address,
                    'telephone' => $request->telephone,
                    'city' => $request->city,
                    'state' => $request->state,
                    'country' => $request->country,
                    'accountType' => 'Individual',
                    'currencyCode' => $mycode[0]->currencies[0]->code,
                    'currencySymbol' => $mycode[0]->currencies[0]->symbol,
                    'api_token' => uniqid().md5($request->email),
                    'password' => Hash::make($request->password),
                    'approval' => 0, 
                    'dayOfBirth' => $request->dayOfBirth, 
                    'monthOfBirth' => $request->monthOfBirth, 
                    'yearOfBirth' => $request->yearOfBirth, 
                    'cardRequest' => 0, 
                    'platform' => 'mobile'
                ]);
            }

            $getcurrentUser = User::where('ref_code', $newRefcode)->first();

            Log::info($getcurrentUser);

            $url = 'https://api.globaldatacompany.com/verifications/v1/verify';

            $minimuAge = date('Y') - $request->yearOfBirth;


            $countryApproval = AllCountries::where('name', $request->country)->where('approval', 1)->first();

            if(isset($countryApproval)){
                $info = $this->identificationAPI($url, $request->firstname, $request->lastname, $request->dayOfBirth, $request->monthOfBirth, $request->yearOfBirth, $minimuAge, $request->address, $request->city, $request->country, null, $request->telephone, $request->email, $mycode[0]->alpha2Code);


                    if(isset($info->TransactionID) == true){

                        $result = $this->transStatus($info->TransactionID);
                        
                        

                        // $res = $this->getTransRec($result->TransactionRecordId);
                            
                            
                            

                        if($info->Record->RecordStatus == "nomatch"){
                        
                            $message = "error";
                            $title = "Oops!";
                            $link = "contact";
                            $data = [];
                            $statusCode = 400;
                            
                            $resInfo = strtoupper($info->Record->RecordStatus).", Our system is unable to complete your registration. Kindly contact the admin using the contact us for further assistance.";

                            User::where('id', $getcurrentUser->id)->update(['accountLevel' => 0, 'countryapproval' => 1]);

                            
                        }
                        else{
                            $message = "success";
                            $title = "Great";
                            $link = "/";
                            $resInfo = strtoupper($info->Record->RecordStatus).", Congratulations!!!. Your account has been approved. Please complete the Quick Set up to enjoy PaySprint.";
                            $data = $user;
                            $statusCode = 200;

                            // Udpate User Info
                            User::where('id', $getcurrentUser->id)->update(['accountLevel' => 1, 'countryapproval' => 1]);

                            $this->createNotification($newRefcode, "Hello ".$request->firstname.", PaySprint is the fastest and affordable method of Sending and Receiving money, Paying Invoice and Getting Paid at anytime!. Welcome on board.");
                        }

                    }
                    else{
                        $message = "error";
                        $title = "Oops!";
                        $link = "contact";
                        $resInfo = "Our system is unable to complete your registration. Kindly contact the admin using the contact us for further assistance.";
                        $data = [];
                        $statusCode = 400;

                        User::where('id', $getcurrentUser->id)->update(['accountLevel' => 0, 'countryapproval' => 1]);

                        // $resp = $info->Message;
                    }
            }
            else{

                $message = "error";
                $title = "Oops!";
                $link = "contact";
                $resInfo = "PaySprint is not yet available for use in your country. You can contact our Customer Service Executives for further assistance";
                $data = [];
                $statusCode = 400;

                User::where('id', $getcurrentUser->id)->update(['accountLevel' => 0, 'countryapproval' => 0]);
            }

            


                    Log::info("New user registration via mobile app by: ".$request->firstname.' '.$request->lastname." from ".$request->state.", ".$request->country." \n\n STATUS: ".$resInfo);

                    // $message = "success";
                    // $title = "Great";
                    // $link = "/";
                    // $resInfo = "Hello ".$request->firstname."!, Welcome to PaySprint!";
                    // $data = $user;
                    // $statusCode = 200;
            
                    $status = $statusCode;

                    $resData = ['data' => $data, 'message' => $resInfo, 'status' => $status];

            

        }
        else{

            $error = implode(",",$validator->messages()->all());
            
            $resData = ['data' => [], 'message' => $error, 'status' => 400];
            $status = 400;
        }

        
        
        return $this->returnJSON($resData, $status);
    }


    public function userLogin(Request $request, User $user){

        // Validate Login

        $validator = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if(!Auth::attempt($validator)){
            $status = 400;
            $data = [];
            $message = 'Invalid email or password';
        }
        else{
            $token = Auth::user()->createToken('authToken')->accessToken;


            $getUser = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol', 'accountLevel', 'flagged')->where('email', $request->email)->first();

            if(Hash::check($request->password, $getUser->password)){


                $countryApproval = AllCountries::where('name', $getUser->country)->where('approval', 1)->first();

                    if(isset($countryApproval)){

                        if($getUser->flagged == 1){
                            $data = [];
                            $status = 400;
                            $message = 'Hello '.$getUser->name.', Access to the account is not currently available. Kindly contact the Admin using this link: https://paysprint.net/contact';

                            $this->createNotification($getUser->refCode, $message);
                        }
                        elseif($getUser->accountLevel == 0){
                            $data = [];
                            $status = 400;
                            $message = 'Hello '.$getUser->name.', Our system is unable to complete your registration. Kindly contact the admin using the contact us for further assistance.';

                            $this->createNotification($getUser->refCode, $message);
                        }
                        else{

                            $countryInfo = $this->getCountryCode($getUser->country);

                            $currencyCode = $countryInfo[0]->currencies[0]->code;
                            $currencySymbol = $countryInfo[0]->currencies[0]->symbol;


                            // Update User API Token
                            User::where('email', $request->email)->update(['api_token' => $token, 'currencyCode' => $currencyCode, 'currencySymbol' => $currencySymbol]);

                            $userData = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol', 'accountLevel', 'cardRequest', 'flagged')->where('email', $request->email)->first();

                            $data = $userData;
                            $status = 200;
                            $message = 'Login successful';

                            $this->createNotification($userData->refCode, "Hello ".$getUser->name.", Your login was successful. Welcome back");

                            $usercity = $this->myLocation()->city;
                            $usercountry = $this->myLocation()->country;
                            $userip = $this->myLocation()->query;

                            $this->checkLoginInfo($userData->refCode, $usercity, $usercountry, $userip);

                        }

                        User::where('email', $request->email)->update(['countryapproval' => 1]);
                }
                else{

                    $data = [];
                    $status = 400;
                    $message = 'Hello '.$getUser->name.', PaySprint is currently not available in your country. You can contact our Customer Service Executives for further enquiries. Thanks';

                    User::where('email', $request->email)->update(['countryapproval' => 0]);

                }



            }
            else{
                $data = [];
                $status = 400;
                $message = 'Incorrect password';

                $this->createNotification($getUser->ref_code, "You tried to login with an incorrect password");
            }


        }

        

        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

        return $this->returnJSON($resData, $status);
    }


    public function updateProfile(Request $request, User $user){

        $user = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'nin_front as ninFront', 'drivers_license_front as driversLicenseFront', 'international_passport_front as internationalPassportFront', 'nin_back as ninBack', 'drivers_license_back as driversLicenseBack', 'international_passport_back as internationalPassportBack', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol', 'dayOfBirth', 'monthOfBirth', 'yearOfBirth', 'cardRequest')->where('api_token', $request->bearerToken())->first();
        

        User::where('id', $user->id)->update($request->all());

        if($request->hasFile('nin_front')){
            $this->uploadDocument($user->id, $request->file('nin_front'), 'document/nin_front', 'nin_front');

            $this->createNotification($user->refCode, "Hello ".$user->name.", You have successfully uploaded the front page of your national identity card.");
        }
        if($request->hasFile('nin_back')){
            $this->uploadDocument($user->id, $request->file('nin_back'), 'document/nin_back', 'nin_back');
            $this->createNotification($user->refCode, "Hello ".$user->name.", You have successfully uploaded the back page of your national identity card.");
        }
        if($request->hasFile('drivers_license_front')){
            $this->uploadDocument($user->id, $request->file('drivers_license_front'), 'document/drivers_license_front', 'drivers_license_front');
            $this->createNotification($user->refCode, "Hello ".$user->name.", You have successfully uploaded the front page of your drivers license.");
        }
        if($request->hasFile('drivers_license_back')){
            $this->uploadDocument($user->id, $request->file('drivers_license_back'), 'document/drivers_license_back', 'drivers_license_back');
            $this->createNotification($user->refCode, "Hello ".$user->name.", You have successfully uploaded the back page of your drivers license.");
        }
        if($request->hasFile('international_passport_front')){
            $this->uploadDocument($user->id, $request->file('international_passport_front'), 'document/international_passport_front', 'international_passport_front');
            $this->createNotification($user->refCode, "Hello ".$user->name.", You have successfully uploaded your international passport.");
        }
        if($request->hasFile('international_passport_back')){
            $this->uploadDocument($user->id, $request->file('international_passport_back'), 'document/international_passport_back', 'international_passport_back');
            $this->createNotification($user->refCode, "Hello ".$user->name.", You have successfully uploaded your international passport.");
        }
        if($request->hasFile('incorporation_doc_front')){
            $this->uploadDocument($user->id, $request->file('incorporation_doc_front'), 'document/incorporation_doc_front', 'incorporation_doc_front');
            $this->createNotification($user->refCode, "Incorporation document successfully uploaded");
            $this->createNotification($user->refCode, "Hello ".$user->name.", You have successfully uploaded the front page of your incorporation document.");
        }
        if($request->hasFile('incorporation_doc_back')){
            $this->uploadDocument($user->id, $request->file('incorporation_doc_back'), 'document/incorporation_doc_back', 'incorporation_doc_back');
            $this->createNotification($user->refCode, "Hello ".$user->name.", You have successfully uploaded the back page of your incorporation document.");
        }
        if($request->hasFile('avatar')){
            $this->uploadDocument($user->id, $request->file('avatar'), 'profilepic/avatar', 'avatar');
            $this->createNotification($user->refCode, "Hello ".$user->name.", You have successfully updated your profile picture.");
        }


        $data = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'accountType', 'nin_front as ninFront', 'drivers_license_front as driversLicenseFront', 'international_passport_front as internationalPassportFront', 'nin_back as ninBack', 'drivers_license_back as driversLicenseBack', 'international_passport_back as internationalPassportBack', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol', 'dayOfBirth', 'monthOfBirth', 'yearOfBirth', 'cardRequest')->where('api_token', $request->bearerToken())->first();

        $status = 200;

        $resData = ['data' => $data, 'message' => 'Profile updated', 'status' => $status];

        return $this->returnJSON($resData, $status);
    }



    public function updateMerchantProfile(Request $request, Admin $admin, ClientInfo $clientinfo){

        $user = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'nin_front as ninFront', 'drivers_license_front as driversLicenseFront', 'international_passport_front as internationalPassportFront', 'nin_back as ninBack', 'drivers_license_back as driversLicenseBack', 'international_passport_back as internationalPassportBack', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol', 'dayOfBirth', 'monthOfBirth', 'yearOfBirth', 'cardRequest')->where('api_token', $request->bearerToken())->first();
        

        User::where('id', $user->id)->update($request->all());

        $adminName = explode(" ", $request->name); 

        $admin->where('email', $user->email)->update(['firstname' => $adminName[0], 'lastname' => $adminName[1]]);

        $clientinfo->where('email', $user->email)->update(['firstname' => $adminName[0], 'lastname' => $adminName[1], 'telephone' => $request->telephone, 'country' => $request->country, 'state' => $request->state, 'city' => $request->city, 'zip_code' => $request->zip]);

        if($request->hasFile('nin_front')){
            $this->uploadDocument($user->id, $request->file('nin_front'), 'document/nin_front', 'nin_front');

            $this->createNotification($user->refCode, "Hello ".$user->name.", You have successfully uploaded the front page of your national identity card.");
        }
        if($request->hasFile('nin_back')){
            $this->uploadDocument($user->id, $request->file('nin_back'), 'document/nin_back', 'nin_back');
            $this->createNotification($user->refCode, "Hello ".$user->name.", You have successfully uploaded the back page of your national identity card.");
        }
        if($request->hasFile('drivers_license_front')){
            $this->uploadDocument($user->id, $request->file('drivers_license_front'), 'document/drivers_license_front', 'drivers_license_front');
            $this->createNotification($user->refCode, "Hello ".$user->name.", You have successfully uploaded the front page of your drivers license.");
        }
        if($request->hasFile('drivers_license_back')){
            $this->uploadDocument($user->id, $request->file('drivers_license_back'), 'document/drivers_license_back', 'drivers_license_back');
            $this->createNotification($user->refCode, "Hello ".$user->name.", You have successfully uploaded the back page of your drivers license.");
        }
        if($request->hasFile('international_passport_front')){
            $this->uploadDocument($user->id, $request->file('international_passport_front'), 'document/international_passport_front', 'international_passport_front');
            $this->createNotification($user->refCode, "Hello ".$user->name.", You have successfully uploaded your international passport.");
        }
        if($request->hasFile('international_passport_back')){
            $this->uploadDocument($user->id, $request->file('international_passport_back'), 'document/international_passport_back', 'international_passport_back');
            $this->createNotification($user->refCode, "Hello ".$user->name.", You have successfully uploaded your international passport.");
        }
        if($request->hasFile('avatar')){
            $this->uploadDocument($user->id, $request->file('avatar'), 'profilepic/avatar', 'avatar');
            $this->createNotification($user->refCode, "Hello ".$user->name.", You have successfully updated your profile picture.");
        }


        $data = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'accountType', 'nin_front as ninFront', 'drivers_license_front as driversLicenseFront', 'international_passport_front as internationalPassportFront', 'nin_back as ninBack', 'drivers_license_back as driversLicenseBack', 'international_passport_back as internationalPassportBack', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol', 'dayOfBirth', 'monthOfBirth', 'yearOfBirth', 'cardRequest')->where('api_token', $request->bearerToken())->first();

        $status = 200;

        $resData = ['data' => $data, 'message' => 'Profile updated', 'status' => $status];

        return $this->returnJSON($resData, $status);
    }


    public function updateMerchantBusinessProfile(Request $request, Admin $admin, ClientInfo $clientinfo){

        $user = User::where('api_token', $request->bearerToken())->first();

        $clientinfo->where('email', $user->email)->update(['business_name' => $request->businessName, 'address' => $request->businessAddress, 'corporate_type' => $request->corporate_type, 'industry' => $request->industry, 'website' => $request->businessWebsite, 'type_of_service' => $request->type_of_service]);

        if($request->hasFile('incorporation_doc_front')){
            $this->uploadDocument($user->id, $request->file('incorporation_doc_front'), 'document/incorporation_doc_front', 'incorporation_doc_front');
            $this->createNotification($user->ref_code, "Incorporation document successfully uploaded");
            $this->createNotification($user->ref_code, "Hello ".$user->name.", You have successfully uploaded the front page of your incorporation document.");
        }
        if($request->hasFile('incorporation_doc_back')){
            $this->uploadDocument($user->id, $request->file('incorporation_doc_back'), 'document/incorporation_doc_back', 'incorporation_doc_back');
            $this->createNotification($user->ref_code, "Hello ".$user->name.", You have successfully uploaded the back page of your incorporation document.");
        }


        $data = $clientinfo->where('email', $user->email)->first();

        $status = 200;

        $resData = ['data' => $data, 'message' => 'Profile updated', 'status' => $status];

        return $this->returnJSON($resData, $status);
    }



    public function merchantsByServiceTypes(Request $req){

        $thisuser = User::where('api_token', $req->bearerToken())->first();

        $data = ClientInfo::select('industry')->where('industry', '!=', null)->where('country', $thisuser->country)->orderBy('created_at', 'DESC')->groupBy('industry')->get();

        Log::info($data);

        $status = 200;

        $resData = ['data' => $data, 'message' => 'success', 'status' => $status];

        return $this->returnJSON($resData, $status);
    }


    public function listMerchantsByServiceTypes(Request $req){

        $thisuser = User::where('api_token', $req->bearerToken())->first();

        $query = ClientInfo::select('id', 'user_id as userId', 'business_name as businessName', 'address', 'corporate_type as corporateType', 'industry', 'type_of_service as typeOfService', 'website', 'firstname', 'lastname', 'telephone', 'country', 'state', 'city', 'zip_code as zipCode')->where('industry', $req->get('industry'))->where('country', $thisuser->country)->orderBy('created_at', 'DESC')->orderBy('created_at', 'DESC')->get();

        if(count($query) > 0){ 

            $data = $query;
            $status = 200;
            $message = 'success';

        }
        else{
            $data = [];
            $status = 400;
            $message = 'No record';
        }

        // Log::info($data);


        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

        return $this->returnJSON($resData, $status);

    }

    public function getMerchantData(Request $req, $id){

        $query = ClientInfo::select('id', 'user_id as userId', 'business_name as businessName', 'address', 'corporate_type as corporateType', 'industry', 'type_of_service as typeOfService', 'website', 'firstname', 'lastname', 'telephone', 'country', 'state', 'city', 'zip_code as zipCode')->where('id', $id)->first();

        if(isset($query)){ 

            $data = $query;
            $status = 200;
            $message = 'success';

        }
        else{
            $data = [];
            $status = 400;
            $message = 'No record';
        }


        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

        return $this->returnJSON($resData, $status);
    }




    public function updatePassword(Request $req){


        $validator = Validator::make($req->all(), [
                     'oldpassword' => 'required|string',
                     'newpassword' => 'required|string',
                     'confirmpassword' => 'required|string',
                ]);

                if($validator->passes()){

                    if($req->newpassword != $req->confirmpassword){
                        $data = [];
                        $message = "Confirm password does not match";
                        $status = 400;
                    }
                    else{
                        $thisuser = User::where('api_token', $req->bearerToken())->first();


                        if(Hash::check($req->oldpassword, $thisuser->password)){
                            // Update
                            $resp = User::where('api_token', $req->bearerToken())->update(['password' => Hash::make($req->newpassword)]);

                            Admin::where('email', $thisuser->email)->update(['password' => Hash::make($req->newpassword)]);

                            $data = $resp;
                            $message = "Saved";
                            $status = 200;

                            $this->createNotification($thisuser->ref_code, "Hello ".strtoupper($thisuser->name).", You have successfully updated your password.");
                        }
                        else{
                            $data = [];
                            $message = "Your old password is incorrect";
                            $status = 400;
                        }
                    }

                    

                }
                else{

                    $error = implode(",",$validator->messages()->all());

                    $data = [];
                    $status = 400;
                    $message = $error;
                }

                $resData = ['data' => $data, 'message' => $message, 'status' => $status];

                return $this->returnJSON($resData, $status);

    }


    public function createTransactionPin(Request $req){
        

        $validator = Validator::make($req->all(), [
                     'newpin' => 'required|string',
                     'confirmpin' => 'required|string',
                ]);

                if($validator->passes()){

                    if($req->newpin != $req->confirmpin){
                        $data = [];
                        $message = "The confirm pin does not match";
                        $status = 400;
                    }
                    else{
                        $thisuser = User::where('api_token', $req->bearerToken())->first();

                        // Update
                        $resp = User::where('api_token', $req->bearerToken())->update(['transaction_pin' => Hash::make($req->newpin)]);

                        $data = $resp;
                        $message = "Saved";
                        $status = 200;

                        $this->createNotification($thisuser->ref_code, "Hello ".strtoupper($thisuser->name).", You have successfully created your transaction pin. Keep it SAFE!.");
                    
                    }

                    

                }
                else{

                    $error = implode(",",$validator->messages()->all());

                    $data = [];
                    $status = 400;
                    $message = $error;
                }

                $resData = ['data' => $data, 'message' => $message, 'status' => $status];

                return $this->returnJSON($resData, $status);

    }


    public function updateSecurity(Request $req){
        

        $validator = Validator::make($req->all(), [
                     'securityQuestion' => 'required|string',
                     'securityAnswer' => 'required|string',
                ]);

                if($validator->passes()){

                        $thisuser = User::where('api_token', $req->bearerToken())->first();

                        // Update
                        $resp = User::where('api_token', $req->bearerToken())->update(['securityQuestion' => $req->securityQuestion, 'securityAnswer' => strtolower($req->securityAnswer)]);

                        $data = $resp;
                        $message = "Saved";
                        $status = 200;

                        Log::notice("Hello ".strtoupper($thisuser->name).", You have successfully set up your security question and answer.");

                        $this->createNotification($thisuser->ref_code, "Hello ".strtoupper($thisuser->name).", You have successfully set up your security question and answer.");

                }
                else{

                    $error = implode(",",$validator->messages()->all());

                    $data = [];
                    $status = 400;
                    $message = $error;
                }

                $resData = ['data' => $data, 'message' => $message, 'status' => $status];

                return $this->returnJSON($resData, $status);

    }



    public function linkAccount(Request $req){
        

        $validator = Validator::make($req->all(), [
                     'account_number' => 'required|string',
                     'transaction_pin' => 'required|string',
                ]);

                if($validator->passes()){

                        $thisuser = User::where('api_token', $req->bearerToken())->first();

                        // Update
                        $getAccount = User::where('ref_code', $req->account_number)->first();

                        if(isset($getAccount)){

                            if(Hash::check($req->transaction_pin, $getAccount->transaction_pin)){

                                // Link Account
                                $resp = LinkAccount::updateOrInsert(['ref_code' => $thisuser->ref_code, 'link_ref_code' => $getAccount->ref_code], ['ref_code' => $thisuser->ref_code, 'link_ref_code' => $req->account_number, 'user_id' => $thisuser->id]);

                                $info = "Hello ".strtoupper($thisuser->name).", You have linked your account ".$req->account_number." (".$getAccount->currencyCode.") with your primary account ".$thisuser->ref_code." (".$thisuser->currencyCode.")";

                                $data = $resp;
                                $message = "Successfull";
                                $status = 200;


                                Log::notice($info);

                                $this->createNotification($thisuser->ref_code, $info);

                            }
                            else{

                                $error = "Invalid transaction pin";

                                $data = [];
                                $status = 400;
                                $message = $error;

                            }

                        }
                        else{
                            $error = "Account number not found";

                            $data = [];
                            $status = 400;
                            $message = $error;
                        }

                        

                        

                }
                else{

                    $error = implode(",",$validator->messages()->all());

                    $data = [];
                    $status = 400;
                    $message = $error;
                }

                $resData = ['data' => $data, 'message' => $message, 'status' => $status];

                return $this->returnJSON($resData, $status);

    }



    public function otherAccount(Request $req){
        

        $validator = Validator::make($req->all(), [
                     'account_number' => 'required|string',
                ]);

                if($validator->passes()){

                        $thisuser = User::where('api_token', $req->bearerToken())->first();

                        // Update
                        $getAccount = User::where('ref_code', $req->account_number)->first();

                        if(isset($getAccount)){

                            $link = route('sign out', $getAccount->id);

                            $info = "Hello ".strtoupper($thisuser->name).", You have switched account to ".$req->account_number." (".$getAccount->currencyCode.") from your primary account ".$thisuser->ref_code." (".$thisuser->currencyCode.")";

                            $data = $link;
                            $message = "Successfull";
                            $status = 200;


                            Log::notice($info);

                            $this->createNotification($thisuser->ref_code, $info);
                            
                        }
                        else{
                            $error = "Account number not found";

                            $data = [];
                            $status = 400;
                            $message = $error;
                        }

                        

                        

                }
                else{

                    $error = implode(",",$validator->messages()->all());

                    $data = [];
                    $status = 400;
                    $message = $error;
                }

                $resData = ['data' => $data, 'message' => $message, 'status' => $status];

                return $this->returnJSON($resData, $status);

    }

    public function updateAutoDeposit(Request $req){
        

        $validator = Validator::make($req->all(), [
                     'auto_deposit' => 'required|string',
                ]);

                if($validator->passes()){

                        $thisuser = User::where('api_token', $req->bearerToken())->first();

                        // Update
                        $resp = User::where('api_token', $req->bearerToken())->update(['auto_deposit' => $req->auto_deposit]);

                        // send Mail and SMS

                        $recMsg = "Hi ".$thisuser->name.", You have successfully turned ".$req->auto_deposit." your Auto Deposit Status.  PaySprint Team";
                        $recPhone = "+".$thisuser->code.$thisuser->telephone;
                        

                        $this->name = $thisuser->name;
                        // $this->email = "bambo@vimfile.com";
                        $this->email = $thisuser->email;
                        $this->subject = "You have successfully turned ".$req->auto_deposit." your Auto Deposit Status.";

                        if($req->auto_deposit == "ON"){
                            $message = "The Auto Deposit feature on PaySprint is turned ON. You can now enjoy a stress-free transaction deposit on your PaySprint Account. <br><br> Thanks, PaySprint Team";
                        }
                        else{
                            $message = "The Auto Deposit feature on PaySprint is turned OFF. You will need to manually accept all transfers made to your PaySprint wallet. If you want to enjoy a stress-free transaction deposit, you may have visit your profile on PaySprint Account to turn ON the feature. <br><br> Thanks, PaySprint Team";
                        }

                        $this->message = '<p>'.$message.'</p>';


                        $this->sendEmail($this->email, "Fund remittance");
                        $this->sendMessage($recMsg, $recPhone);

                        $data = $resp;
                        $message = "Saved";
                        $status = 200;

                        Log::info("Hello ".strtoupper($thisuser->name).", You have successfully turned ".$req->auto_deposit." your Auto Deposit Status.");


                        $this->createNotification($thisuser->ref_code, "Hello ".strtoupper($thisuser->name).", You have successfully turned ".$req->auto_deposit." your Auto Deposit Status.");

                }
                else{

                    $error = implode(",",$validator->messages()->all());

                    $data = [];
                    $status = 400;
                    $message = $error;
                }

                $resData = ['data' => $data, 'message' => $message, 'status' => $status];

                return $this->returnJSON($resData, $status);

    }



    public function resetPassword(Request $req){
        

        $validator = Validator::make($req->all(), [
                     'securityQuestion' => 'required|string',
                     'securityAnswer' => 'required|string',
                     'newpassword' => 'required|string',
                     'confirmpassword' => 'required|string',
                ]);

                if($validator->passes()){

                        $thisuser = User::where('api_token', $req->bearerToken())->first();

                        // Check if Security Answer is correct
                        if(strtolower($req->securityAnswer) != $thisuser->securityAnswer){
                            // You have provided a wrong answer to your security question

                            $error = "You have provided a wrong answer to your security question";

                            $data = [];
                            $status = 400;
                            $message = $error;
                        }
                        else{

                            // Check Password Match

                            if($req->newpassword != $req->confirmpassword){
                                $data = [];
                                $message = "Confirm password does not match";
                                $status = 400;
                            }
                            else{

                                    $resp = User::where('api_token', $req->bearerToken())->update(['password' => Hash::make($req->newpassword)]);

                                    Admin::where('email', $thisuser->email)->update(['password' => Hash::make($req->newpassword)]);

                                    $data = $resp;
                                    $message = "Saved";
                                    $status = 200;

                                    $this->createNotification($thisuser->ref_code, "Hello ".strtoupper($thisuser->name).", You have successfully reset your password.");

                            }


                        }

                        

                }
                else{

                    $error = implode(",",$validator->messages()->all());

                    $data = [];
                    $status = 400;
                    $message = $error;
                }

                $resData = ['data' => $data, 'message' => $message, 'status' => $status];

                return $this->returnJSON($resData, $status);

    }


    public function resetTransactionPin(Request $req){
        

        $validator = Validator::make($req->all(), [
                     'securityQuestion' => 'required|string',
                     'securityAnswer' => 'required|string',
                     'newpin' => 'required|string',
                     'confirmpin' => 'required|string',
                ]);

                if($validator->passes()){

                        $thisuser = User::where('api_token', $req->bearerToken())->first();

                        // Check if Security Answer is correct
                        if(strtolower($req->securityAnswer) != $thisuser->securityAnswer){
                            // You have provided a wrong answer to your security question

                            $error = "You have provided a wrong answer to your security question";

                            $data = [];
                            $status = 400;
                            $message = $error;
                        }
                        else{

                            if($req->newpin != $req->confirmpin){
                                $data = [];
                                $message = "The confirm pin does not match";
                                $status = 400;
                            }
                            else{

                                // Update
                                $resp = User::where('api_token', $req->bearerToken())->update(['transaction_pin' => Hash::make($req->newpin)]);

                                $data = $resp;
                                $message = "Saved";
                                $status = 200;

                                $this->createNotification($thisuser->ref_code, "Transaction pin updated");

                                $this->createNotification($thisuser->ref_code, "Hello ".strtoupper($thisuser->name).", You have successfully changed your transaction pin. Keep it SAFE!.");


                            
                            }


                        }

                        

                }
                else{

                    $error = implode(",",$validator->messages()->all());

                    $data = [];
                    $status = 400;
                    $message = $error;
                }

                $resData = ['data' => $data, 'message' => $message, 'status' => $status];

                return $this->returnJSON($resData, $status);

    }


    public function updateTransactionPin(Request $req){
        

        $validator = Validator::make($req->all(), [
                     'oldpin' => 'required|string',
                     'newpin' => 'required|string',
                     'confirmpin' => 'required|string',
                ]);

                if($validator->passes()){

                    if($req->newpin != $req->confirmpin){
                        $data = [];
                        $message = "The confirm pin does not match";
                        $status = 400;
                    }
                    else{
                        $thisuser = User::where('api_token', $req->bearerToken())->first();

                    if(Hash::check($req->oldpin, $thisuser->transaction_pin)){
                        // Update
                        $resp = User::where('api_token', $req->bearerToken())->update(['transaction_pin' => Hash::make($req->newpin)]);

                        $data = $resp;
                        $message = "Saved";
                        $status = 200;

                        $this->createNotification($thisuser->ref_code, "Hello ".strtoupper($thisuser->name).", You have successfully updated your transaction pin. Keep it SAFE!.");
                    }
                    else{
                        $data = [];
                        $message = "Your old transaction pin is incorrect";
                        $status = 400;
                    }
                    }

                    

                }
                else{

                    $error = implode(",",$validator->messages()->all());

                    $data = [];
                    $status = 400;
                    $message = $error;
                }

                $resData = ['data' => $data, 'message' => $message, 'status' => $status];

                return $this->returnJSON($resData, $status);

    }



    public function uploadDocument($id, $file, $pathWay, $rowName){


        //Get filename with extension
        $filenameWithExt = $file->getClientOriginalName();
        // Get just filename
        $filename = pathinfo($filenameWithExt , PATHINFO_FILENAME);
        // Get just extension
        $extension = $file->getClientOriginalExtension();
        // Filename to store
        $fileNameToStore = rand().'_'.time().'.'.$extension;

        
        $path = $file->move(public_path('../../'.$pathWay.'/'), $fileNameToStore);


        $docPath = "http://".$_SERVER['HTTP_HOST']."/".$pathWay."/".$fileNameToStore;


        User::where('id', $id)->update([''.$rowName.'' => $docPath]);

    }


    public function logout(Request $request, $id) {
        $user = User::where('id', $id)->first();

        User::where('id', $id)->update(['api_token' => encrypt($user->email)]);

        Auth::login($user);

        return redirect('/home');
    }


    
    public function sendEmail($objDemoa, $purpose){
        $objDemo = new \stdClass();
        $objDemo->purpose = $purpose;
          if($purpose == "Payment Received"){
  
              $objDemo->name = $this->name;
              $objDemo->email = $this->email;
              $objDemo->amount = $this->amount;
              $objDemo->paypurpose = $this->paypurpose;
              $objDemo->coy_name = $this->coy_name;
              $objDemo->subject = $this->subject;
  
          }
          elseif($purpose == "Payment Successful"){
  
              $objDemo->name = $this->name;
              $objDemo->email = $this->email;
              $objDemo->amount = $this->amount;
              $objDemo->paypurpose = $this->paypurpose;
              $objDemo->coy_name = $this->coy_name;
              $objDemo->subject = $this->subject2;
  
          }
  
          elseif($purpose == 'Fund remittance'){
              $objDemo->name = $this->name;
              $objDemo->email = $this->email;
              $objDemo->subject = $this->subject;
              $objDemo->message = $this->message;
          }
  
        Mail::to($objDemoa)
              ->send(new sendEmail($objDemo));
     }



}
