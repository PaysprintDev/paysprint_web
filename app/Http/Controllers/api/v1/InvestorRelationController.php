<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\InvestorPost;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;

use App\InvestorRelation as InvestorRelation;

class InvestorRelationController extends Controller
{
    public function investorDetails(Request $req)
    {
        try {

            $validator = Validator::make($req->all(), [
                'name' => 'required|string',
                'email' => 'required|string',
                'password' => 'required|string',
                'phoneNumber' => 'required|string',
                'country' => 'required|string',
                'state' => 'required|string',
                'city' => 'required|string',
            ]);

            if ($validator->passes()) {
                // Update or Insert Investors record
                $doUpdate = InvestorRelation::updateOrInsert([
                    'email' => $req->email
                ], [
                    'name' => $req->name,
                    'email' => $req->email,
                    'name' => $req->name,
                    'password' => Hash::make($req->password),
                    'phoneNumber' => $req->phoneNumber,
                    'country' => $req->country,
                    'state' => $req->state,
                    'city' => $req->city
                ] 
            
                
            );

                // Get Data
                $data = InvestorRelation::where('email', $req->email)->first();
                $message = 'Success';
                $status = 200;
            } else {
                $error = implode(", ", $validator->messages()->all());

                $data = [];
                $status = 400;
                $message = $error;
            }
        } catch (\Throwable $th) {
            $data = [];
            $message = $th->getMessage();
            $status = 400;
        }

        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

        return $this->returnJSON($resData, $status);
    }



    public function investorLogin(Request $req){


        try {

            $validator = Validator::make($req->all(), [
                'email' => 'required|string',
                'password' => 'required|string',
            ]);

            if ($validator->passes()) {

                // Check if email exist
                $checkEmail = InvestorRelation::where('email', $req->email)->first();


                if(isset($checkEmail)){

                    if (Hash::check($req->password, $checkEmail->password)){

                        // Update Token
                        $apiToken = Crypt::encryptString($req->email);

                        InvestorRelation::where('email', $req->email)->update(['apiToken' => $apiToken]);

                        
                        $data = InvestorRelation::where('email', $req->email)->first();
                        $status = 200;
                        $message = "Success";
                        

                    }
                    else{
                        $data = [];
                        $status = 400;
                        $message = "Invalid email address or password";
                        $apiToken = '';
                    }

                }
                else{
                    
                    $data = [];
                    $status = 400;
                    $message = "Invalid email address or password";
                    $apiToken = '';
                }

            } else {
                $error = implode(", ", $validator->messages()->all());

                $data = [];
                $status = 400;
                $message = $error;
                $apiToken = '';
            }
        } catch (\Throwable $th) {
            $data = [];
            $message = $th->getMessage();
            $status = 400;
            $apiToken = '';
        }

        $resData = ['data' => $data, 'message' => $message, 'status' => $status, 'apiToken' => $apiToken];

        return $this->returnJSON($resData, $status);

        

    }

    public function investorNews(Request $req)
    {

        try {
            // Get Posts

            $data = InvestorPost::orderBy('created_at', 'DESC')->paginate(3);

            if (count($data) > 0) {
                $status = 200;
                $message = 'Success';
            } else {
                $status = 200;
                $message = 'No record available';
            }
        } catch (\Throwable $th) {
            $data = [];
            $message = $th->getMessage();
            $status = 400;
        }

        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

        return $this->returnJSON($resData, $status);
    }


    public function investorSpecificNews(Request $req, $id)
    {

        try {
            // Get Posts

            $data = InvestorPost::where('id', $id)->first();

            $status = 200;
            $message = 'Success';
        } catch (\Throwable $th) {
            $data = [];
            $message = $th->getMessage();
            $status = 400;
        }

        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

        return $this->returnJSON($resData, $status);
    }
}