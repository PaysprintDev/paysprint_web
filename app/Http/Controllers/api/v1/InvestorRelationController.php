<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\InvestorPost;
use App\Createpost;
use App\ExpressInterest;
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

    public function investorInterestPayload (Request $req)
    {   
        try {
        $validator=Validator::make($req->all(),[
              'button' => 'required'
        ]);

         if ($validator -> passes()) {
             $post=CreatePost::get();
        $data=$post->investment_document;
        $message='success';
        $status=200;
              

         }else{
             $data=[];
             $message="error";
             $status=400;
         }

        } catch (\Throwable $th){
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

       public function investorGetSpecificPost(Request $req)
    {

        // TODO 3: Query the Express Interest model with the postId and the userID from TODO 2...
        // TODO 4:: Check if TODO 3 exists with DATA...
        // TODO 5:: If exists with data, Make file accessible and disable express interest button in the view
        // TODO 6:: Else Do not make file accessible
      

        try {
            $users=InvestorRelation::where('apiToken', $req->apiToken)->first();

            dd($users);
          

            if(!$users){
                $resData = ['data' => [], 'message' => 'Invalid authorization. Please login', 'status' => 400];

        return $this->returnJSON($resData, 400);
            }

            $userId=$users->id;

            // dd($userId);

            $getInterest = ExpressInterest::where('id', $req->postId)->where('userId', $userId)->first();
                
            if(isset($getInterest)){

                $data = $getInterest->investment_document;
                $message = 'Available';
                $status = 200;
            }
            else{
                $data = [];
                $message = 'Not Available';
                $status = 200;
            }
            


            
            
        } catch (\Throwable $th) {
            //throw $th;
            $data = [];
            $message = $th->getMessage();
            $status = 400;
        }
        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

        return $this->returnJSON($resData, $status);
        

    }


    public function investorExpressInteret(Request $req)
{
    $users=InvestorRelation::where('apiToken', $req->apiToken)->first();

    if(isset($users)){
        ExpressInterest::insert([
            'userId' => $users->id, 'postId' => $req->postId
        ]);

        $data = true;
        $message = 'Request successfully processed';
        $status = 200;
    }
    else{
        $data = [];
        $message = 'Not found';
        $status = 404;
    }


    $resData = ['data' => $data, 'message' => $message, 'status' => $status];

    return $this->returnJSON($resData, $status);

  
  }
  
   
      
   

 
   
}

