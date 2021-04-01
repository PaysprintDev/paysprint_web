<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\User as User;


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


            $user = User::create([
                'ref_code' => $newRefcode,
                'name' => $request->firstname.' '.$request->lastname,
                'code' => $mycode[0]->callingCodes[0],
                'email' => $request->email,
                'telephone' => $request->telephone,
                'city' => $request->city,
                'state' => $request->state,
                'country' => $request->country,
                'api_token' => uniqid().md5($request->email),
                'password' => Hash::make($request->password),
                'approval' => 0
            ]);

            $resData = ['data' => $user, 'message' => 'Registration successful'];
            $status = 200;

        }
        else{

            $error = implode(",",$validator->messages()->all());
            
            $resData = ['message' => $error, 'status' => 400];
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


            $getUser = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal')->where('email', $request->email)->first();

            if(Hash::check($request->password, $getUser->password)){

                // Update User API Token
                User::where('email', $request->email)->update(['api_token' => $token]);

                $userData = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal')->where('email', $request->email)->first();

                $data = $userData;
                $status = 200;
                $message = 'Login successful';


            }
            else{
                $data = [];
                $status = 400;
                $message = 'Incorrect password';
            }


        }

        

        $resData = ['data' => $data, 'message' => $message];

        return $this->returnJSON($resData, $status);
    }


    public function updateProfile(Request $request, User $user){

        $user = User::select('id', 'code as countryCode', 'ref_code as refCode', 'name', 'email', 'password', 'address', 'telephone', 'city', 'state', 'country', 'zip as zipCode', 'avatar', 'nin_front as ninFront', 'drivers_license_front as driversLicenseFront', 'international_passport_front as internationalPassportFront', 'nin_back as ninBack', 'drivers_license_back as driversLicenseBack', 'international_passport_back as internationalPassportBack', 'api_token as apiToken', 'approval', 'accountType', 'wallet_balance as walletBalance', 'number_of_withdrawals as numberOfWithdrawal')->where('api_token', $request->bearerToken())->first();


        User::where('id', $user->id)->update($request->all());

        if($request->hasFile('nin_front')){
            $this->uploadDocument($user->id, $request->file('nin_front'), 'document/nin_front', 'nin_front');
        }
        if($request->hasFile('nin_back')){
            $this->uploadDocument($user->id, $request->file('nin_back'), 'document/nin_back', 'nin_back');
        }
        if($request->hasFile('drivers_license_front')){
            $this->uploadDocument($user->id, $request->file('drivers_license_front'), 'document/drivers_license_front', 'drivers_license_front');
        }
        if($request->hasFile('drivers_license_back')){
            $this->uploadDocument($user->id, $request->file('drivers_license_back'), 'document/drivers_license_back', 'drivers_license_back');
        }
        if($request->hasFile('international_passport_front')){
            $this->uploadDocument($user->id, $request->file('international_passport_front'), 'document/international_passport_front', 'international_passport_front');
        }
        if($request->hasFile('international_passport_back')){
            $this->uploadDocument($user->id, $request->file('international_passport_back'), 'document/international_passport_back', 'international_passport_back');
        }
        if($request->hasFile('avatar')){
            $this->uploadDocument($user->id, $request->file('avatar'), 'profilepic/avatar', 'avatar');
        }



        $status = 200;

        $resData = ['data' => $user, 'message' => 'Profile updated', 'status' => $status];

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
