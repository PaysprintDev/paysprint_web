<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\User as User;
use App\AnonUsers as AnonUsers;


class UserController extends Controller
{

    // User Registration

    public function userRegistration(Request $request, User $user){

        $validator = Validator::make($request->all(), [
            'ref_code' => 'unique:users',
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'telephone' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
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

                    $user = User::create(['code' => $newcustomer->code, 'ref_code' => $newcustomer->ref_code, 'name' => $newcustomer->name, 'email' => $newcustomer->email, 'password' => Hash::make($request->password), 'address' => $newcustomer->address, 'city' => $request->city, 'state' => $request->state, 'country' => $newcustomer->country, 'accountType' => 'Individual', 'api_token' => uniqid().md5($request->email), 'telephone' => $newcustomer->telephone, 'wallet_balance' => $newcustomer->wallet_balance, 'approval' => 0, 'currencyCode' => $mycode[0]->currencies[0]->code, 'currencySymbol' => $mycode[0]->currencies[0]->symbol]);

                    AnonUsers::where('ref_code', $newcustomer->ref_code)->delete();

            }
            else{
                $user = User::create([
                'ref_code' => $newRefcode,
                'name' => $request->firstname.' '.$request->lastname,
                'code' => $mycode[0]->callingCodes[0],
                'email' => $request->email,
                'telephone' => $request->telephone,
                'city' => $request->city,
                'state' => $request->state,
                'country' => $request->country,
                'accountType' => 'Individual',
                'currencyCode' => $mycode[0]->currencies[0]->code,
                'currencySymbol' => $mycode[0]->currencies[0]->symbol,
                'api_token' => uniqid().md5($request->email),
                'password' => Hash::make($request->password),
                'approval' => 0
            ]);
            }


            

            $resData = ['data' => $user, 'message' => 'Registration successful'];
            $status = 200;

            $this->createNotification($newRefcode, "Hello ".$request->firstname.", PaySprint is the fastest and affordable method of Sending and Receiving money, Paying Invoice and Getting Paid at anytime!. Welcome on board.");

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


            $getUser = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol')->where('email', $request->email)->first();

            if(Hash::check($request->password, $getUser->password)){

                $countryInfo = $this->getCountryCode($getUser->country);

                $currencyCode = $countryInfo[0]->currencies[0]->code;
                $currencySymbol = $countryInfo[0]->currencies[0]->symbol;


                // Update User API Token
                User::where('email', $request->email)->update(['api_token' => $token, 'currencyCode' => $currencyCode, 'currencySymbol' => $currencySymbol]);

                $userData = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol')->where('email', $request->email)->first();

                $data = $userData;
                $status = 200;
                $message = 'Login successful';

                $this->createNotification($userData->refCode, "Hello ".$getUser->name.", Your login successful. Welcome back");


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

        $user = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'nin_front as ninFront', 'drivers_license_front as driversLicenseFront', 'international_passport_front as internationalPassportFront', 'nin_back as ninBack', 'drivers_license_back as driversLicenseBack', 'international_passport_back as internationalPassportBack', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol')->where('api_token', $request->bearerToken())->first();
        

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


        $data = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'nin_front as ninFront', 'drivers_license_front as driversLicenseFront', 'international_passport_front as internationalPassportFront', 'nin_back as ninBack', 'drivers_license_back as driversLicenseBack', 'international_passport_back as internationalPassportBack', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal', 'transaction_pin as transactionPin', 'currencyCode', 'currencySymbol')->where('api_token', $request->bearerToken())->first();

        $status = 200;

        $resData = ['data' => $data, 'message' => 'Profile updated', 'status' => $status];

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

                            $data = $resp;
                            $message = "Saved";
                            $status = 200;

                            $this->createNotification($thisuser->refCode, "Hello ".strtoupper($thisuser->name).", You have successfully updated your password.");
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

                        $this->createNotification($thisuser->refCode, "Hello ".strtoupper($thisuser->name).", You have successfully created your transaction pin. Keep it SAFE!.");
                    
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
                        $resp = User::where('api_token', $req->bearerToken())->update(['securityQuestion' => $req->securityQuestion, 'securityAnswer' => $req->securityAnswer]);

                        $data = $resp;
                        $message = "Saved";
                        $status = 200;

                        $this->createNotification($thisuser->refCode, "Hello ".strtoupper($thisuser->name).", You have successfully set up your security question and answer.");

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
                        if($req->securityAnswer != $thisuser->securityAnswer){
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

                                    $data = $resp;
                                    $message = "Saved";
                                    $status = 200;

                                    $this->createNotification($thisuser->refCode, "Hello ".strtoupper($thisuser->name).", You have successfully reset your password.");

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
                        if($req->securityAnswer != $thisuser->securityAnswer){
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

                                $this->createNotification($thisuser->refCode, "Hello ".strtoupper($thisuser->name).", You have successfully changed your transaction pin. Keep it SAFE!.");


                            
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

                        $this->createNotification($thisuser->refCode, "Hello ".strtoupper($thisuser->name).", You have successfully updated your transaction pin. Keep it SAFE!.");
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



}
