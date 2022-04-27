<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\InvestorPost;
use App\Createpost;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use App\Mail\sendEmail;

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


            $this->name = $req->name;
            // $this->email = "bambo@vimfile.com";
            $this->email = $req->email;
            $this->subject = "Welcome to PaySprint Investors News";

            $this->message = "<p>Welcome to PaySprint Investors News. Thanks for your interest in PaySprint Investors' News. Paysprint Investors' News  provides you with up-to-date information about the activities of the company in positioning the product in the market.</p> <p>The account also enables you to access opportunities that are presently available or in the future. We are happy to have you around, <a href='https://investor.paysprint.ca/login.html'>(Click the link to login)</a> PaySprint' Investors' Relation  team.</p>";

            $this->sendEmail($this->email, "Fund remittance");


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


    public function investorForgotPassword(Request $req){

        try {

            $validator = Validator::make($req->all(), [
                'email' => 'required',
                'url' => 'required',
            ]);

            if ($validator->passes()) {

                
            $getInvestor = InvestorRelation::where('email', $req->email)->first();

            if(isset($getInvestor)){
                // Send Mail to Investor
                $link = $req->url.'?id='.base64_encode($req->email);

                $this->name = $getInvestor->name;
                // $this->email = "bambo@vimfile.com";
                $this->email = $getInvestor->email;
                $this->subject = "Your password reset link is here";

                $this->message = '<p>Kindly click on the link below to reset your password.</p><p><a href="'.$link.'">'.$link.'</a></p>';

                $this->sendEmail($this->email, "Fund remittance");


                $data = 'Success';
                $status = 200;
                $message = "We have e-mailed your password reset link!";

            }
            else{
                $data = [];
                $status = 400;
                $message = "Invalid email address";
            }

            }
            else{
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

    public function investorResetPassword(Request $req){

        try {

            $validator = Validator::make($req->all(), [
                'email' => 'required',
                'newPassword' => 'required',
                'confirmPassword' => 'required',
            ]);

            if ($validator->passes()) {


                if($req->newPassword != $req->confirmPassword){
                    
                    $data = [];
                    $status = 400;
                    $message = "Confirm passwords do not match";
                }
                else{

                    $email = base64_decode($req->email);
                    $password = Hash::make($req->newPassword);
                    
                   InvestorRelation::where('email', $email)->update(['password' => $password]);
                   

                   // Get Data
                    $data = InvestorRelation::where('email', $email)->first();
                    $message = 'Successfully reset password. Please proceed to login';
                    $status = 200;

                }

            }
            else{
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

        public function investorActivatedPosts(Request $req){

            try {
               // Get Activated Posts

            $data = Createpost::where('activate_post', 'on')->orderBy('created_at', 'DESC')->get();

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

        public function sendEmail($objDemoa, $purpose)
    {
        $objDemo = new \stdClass();
        $objDemo->purpose = $purpose;

        if ($purpose == 'Fund remittance') {
            $objDemo->name = $this->name;
            $objDemo->email = $this->email;
            $objDemo->subject = $this->subject;
            $objDemo->message = $this->message;
        }

        Mail::to($objDemoa)
            ->send(new sendEmail($objDemo));
    }
}