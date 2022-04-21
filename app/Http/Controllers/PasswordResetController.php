<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Http\RedirectResponse;

use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Hash;

//Mail

use App\Mail\sendEmail;

use App\Admin as Admin;
use App\SuperAdmin as SuperAdmin;
use App\User as User;

class PasswordResetController extends Controller
{
        public function index(){

        return view('admin.adminpasswordreset');
    }


    public function adminpasswordreset(Request $req){

        // Check user email
        $email = Admin::where('email', $req->email)->orWhere('username', $req->email)->first();

        if(isset($email)){

            $this->to = $req->email;
            // $this->to = "bambo@vimfile.com";
            $this->name = $email->firstname;
            $this->subject = 'Password Reset';
            $this->message = 'Hi, <br><br> Kindly click on the link below to reset your password <br> https://'.$_SERVER['HTTP_HOST'].'/reset/newpassword/'.$email->user_id;
            

            $this->sendEmail($this->to, 'Password Reset');

            return redirect()->back()->with('success', 'Reset password link sent to your mail');
        }
        else{

            // Check Super Admin
            $email = SuperAdmin::where('username', $req->email)->orWhere('email', $req->email)->first();

            if(isset($email)){

                $this->to = $req->email;
                // $this->to = "bambo@vimfile.com";
                $this->name = $email->firstname;
                $this->subject = 'Password Reset';
                $this->message = 'Hi, <br><br> Kindly click on the link below to reset your password <br> https://'.$_SERVER['HTTP_HOST'].'/reset/newpassword/'.$email->user_id;
                

                $this->sendEmail($this->to, 'Password Reset');

                return redirect()->back()->with('success', 'Reset password link sent to your mail');
            }
            else{
                    return redirect()->back()->with('error', 'Username or Email address does not exist');

            }

        }

        
    }


    public function adminpasswordresetnew(Request $req, $userid){
        // Reset Password
        $check = Admin::where('user_id', $userid)->first();

        if(isset($check)){

            return view('admin.adminpasswordresetnew')->with(['data' => $userid]);
        }
        else{

            // Check Super
            $check = SuperAdmin::where('user_id', $userid)->first();

            if(isset($check)){
                return view('admin.adminpasswordresetnew')->with(['data' => $userid]);
            }
            else{
                
                return redirect('reset/mypassword')->with('error', 'Invalid Username or Email Address');
            }

        }
        
    }
    
    
    public function changepassword(Request $req){
        // Reset Password
        $check = Admin::where('user_id', $req->userid)->first();

        if(isset($check)){

            Admin::where('user_id', $req->userid)->update(['password' => Hash::make($req->newpassword)]);
            User::where('email', $check->email)->update(['password' => Hash::make($req->newpassword)]);

            // Send Mail

            $this->to = $check->email;
            // $this->to = "bambo@vimfile.com";
            $this->name = $check->firstname;
            $this->subject = 'Password Reset';
            $this->message = '<br><strong>Congratulations!!</strong>, <br><br> <p>Here is your new login details:</p><p>Username: '.$check->username.'</p><p>Password: '.$req->newpassword.'</p>';
            

            $this->sendEmail($this->to, 'Password Reset');

            return redirect('AdminLogin')->with('success', 'Password updated. Login to account');
        }
        else{

            // Check Super Admin
            $check = SuperAdmin::where('user_id', $req->userid)->first();

            if(isset($check)){

                SuperAdmin::where('user_id', $req->userid)->update(['password' => Hash::make($req->newpassword)]);

                // Send Mail
                $this->to = $check->email;
                // $this->to = "bambo@vimfile.com";
                $this->name = $check->firstname;
                $this->subject = 'Password Reset';
                $this->message = '<br><strong>Congratulations!!</strong>, <br><br> <p>Here is your new login details:</p><p>Username: '.$check->username.'</p><p>Password: '.$req->newpassword.'</p>';
                

                $this->sendEmail($this->to, 'Password Reset');

                return redirect('AdminLogin')->with('success', 'Password updated. Login to account');
            }
            else{
                
                return redirect('reset/mypassword')->with('error', 'Unable to update password!');
            }

        }
        
    }



    public function sendEmail($objDemoa, $purpose){
      $objDemo = new \stdClass();
      $objDemo->purpose = $purpose;
      
      

      if($purpose == 'Password Reset'){
            $objDemo->name = $this->name;
            $objDemo->subject = $this->subject;
            $objDemo->message = $this->message;
        }

      Mail::to($objDemoa)
            ->send(new sendEmail($objDemo));
   }

}
