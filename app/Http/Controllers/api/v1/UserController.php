<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User as User;


class UserController extends Controller
{

    // User Registration

    public function userRegistration(Request $request, User $user){

        $data = 1;
        $message = "success";
        $status = 200;

        $resData = ['data' => $data, 'message' => $message];
        
        return $this->returnJSON($resData, $status);
    }


    public function userLogin(Request $request, User $user){

        $data = 1;
        $message = "success";
        $status = 200;

        $resData = ['data' => $data, 'message' => $message];

        return $this->returnJSON($resData, $status);
    }


    public function updateProfile(Request $request, User $user){

        $user = User::where('api_token', $request->bearerToken())->first();


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
