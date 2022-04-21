<?php

namespace App\Http\Controllers;

//Session
use Session;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;

use App\User as User;

use App\Admin as Admin;

use App\CreateEvent as CreateEvent;

use App\ImportExcel as ImportExcel;

use App\SetupBilling as SetupBilling;

use App\InvoicePayment as InvoicePayment;

use App\ClientInfo as ClientInfo;

use App\Statement as Statement;


class ExbcController extends Controller
{
    public $page;
    public $email;
    public $name;

    public $valid = 0;
    public $platform = "payca";
    public $useragent = "Exbc cURL Request";
    public $ref_code = "";
    public $username = "";



    public function __construct(Request $req){
        // dd(1);
    //   dd($req->all());
    // return $req->all();
      // dd($_SERVER['DOCUMENT_ROOT']);
        $this->gettrust($req);
    }

    public function index(Request $req){
        // return 1;
    // dd(12);
    // return $this->returnJSON($req->all());
    // return $req->action;
    
    // if($this->valid != 0)
    // {
        
        //Proceed
        switch($req->action){
            case 'fetch_all':
                return $this->returnJSON($this->getUser($req->email, $req->platform, $req->username, $req->firstname, $req->lastname, $req->address, $req->city, $req->province, $req->country, $req->postal_code, $req->ref_code, $req->accountType, $req->password, $req->companyname, $req->phone, $req->card_balance), 200);
                
                return $this->returnJSON($this->getstatement($req->email, $req->platform, $req->username, $req->ref_code, $req->accountType, $req->start_date, $req->end_date), 200);
            break;

            case 'rpm_tenant':


                return $this->returnJSON($this->getRPM($req->email, $req->platform, $req->username, $req->firstname, $req->lastname, $req->address, $req->city, $req->province, $req->country, $req->postal_code, $req->ref_code, $req->accountType, $req->password, $req->companyname, $req->phone, $req->card_balance), 200);
            break;

            case 'rpm_property_owner':
                return $this->returnJSON($this->getRPM($req->email, $req->platform, $req->username, $req->firstname, $req->lastname, $req->address, $req->city, $req->province, $req->country, $req->postal_code, $req->ref_code, $req->accountType, $req->password, $req->companyname, $req->phone, $req->card_balance), 200);
            break;

            case 'rpm_service_provider':
                return $this->returnJSON($this->getRPM($req->email, $req->platform, $req->username, $req->firstname, $req->lastname, $req->address, $req->city, $req->province, $req->country, $req->postal_code, $req->ref_code, $req->accountType, $req->password, $req->companyname, $req->phone, $req->card_balance), 200);
            break;


            case 'getstatement':
                
                return $this->returnJSON($this->getstatement($req->email, $req->platform, $req->username, $req->ref_code, $req->accountType, $req->start_date, $req->end_date), 200);
            break;

            case 'getinvoice':
                
                return $this->returnJSON($this->getinvoice($req->email, $req->platform, $req->invoice_no), 200);
            break;

            default:
                return $this->returnJSON($req->all(), 200);
                break;
        }
    // }
    // else{
    //     //Terminate
    //     $this->returnJSON(array('action', 'Failed to connect'));
    //     }
    }

    
        
        public function getUser($email, $platform, $username, $firstname, $lastname, $address, $city, $state, $country, $postal_code, $ref_code, $accountType, $password, $companyname, $phone, $card_balance){
            
            // return($ref_code);
            
            // return $platform;
            
            if($platform == "payca" && $username != "" || $email != ""){

                if($accountType == "user"){
                    $getUser = User::where('email', $email)->get();
                    // Update card balance
                    User::where('email', $email)->update(['ref_code' => $ref_code, 'card_balance' => $card_balance, 'password' => $password]);

                if(count($getUser) > 0){
                    $info = "success";
                    $linkdirect = $this->domainUrl()."login?user=".$email;

                }
                else{

                    // Insert Record
                    $insRec = User::insert(['ref_code' => $ref_code, 'name' => $firstname.' '.$lastname, 'email' => $email, 'address' => $address, 'city' => $city, 'state' =>$state, 'country' => $country, 'accountType' => 'Individual', 'zip' => $postal_code, 'ref_code' => $ref_code, 'card_balance' => $card_balance, 'password' => $password]);

                    if($insRec == true){
                        $info = "success";
                        $linkdirect = $this->domainUrl()."login?user=".$email;
                    }
                    else{
                        $info = "fail";
                        $linkdirect = "https://exbc.com/Product";
                    }
                }
                }
                elseif($accountType == "client"){
                    $getUser = Admin::where('username', $username)->get();

                    // Update card balance
                    ClientInfo::where('email', $email)->update(['user_id' => $ref_code, 'card_balance' => $card_balance]);

                if(count($getUser) > 0){
                    $info = "success";
                    $linkdirect = $this->domainUrl()."AdminLogin?user=".$username;

                }
                else{

                    // Insert Record
                    $insRec = Admin::insert(['user_id' => $ref_code, 'firstname' => $firstname, 'lastname' => $lastname, 'username' => $username, 'password' => $password, 'role' => 'Client', 'email' => $email]);

                    if($insRec == true){
                        // Insert CLient Info
                        $clientInfo = ClientInfo::insert(['user_id' => $ref_code, 'business_name' => $companyname, 'address' => $address, 'firstname' => $firstname, 'lastname' => $lastname, 'email' => $email, 'country' => $country, 'state' => $state, 'city' => $city, 'zip_code' => $postal_code, 'card_balance' => $card_balance]);

                        $info = "success";
                        $linkdirect = $this->domainUrl()."AdminLogin?user=".$username;
                    }
                    else{
                        $info = "fail";
                        $linkdirect = "https://exbc.com/Product";
                    }
                }
                }

                

                // $result = 1;
                $result = array('action' => $info, 'data' => $linkdirect);
            }
            else{
                $result = array('action' => "Unknown action", 'data' => 0);

            }

            return $this->returnJSON($result, 200);

        }


        public function getRPM($email, $platform, $username, $firstname, $lastname, $address, $city, $state, $country, $postal_code, $ref_code, $accountType, $password, $companyname, $phone, $card_balance){


            switch ($platform) {
                case 'tenant':

                    if($accountType == "user"){
                    $getUser = User::where('email', $email)->get();
                    // Update card balance
                    User::where('email', $email)->update(['ref_code' => $ref_code, 'card_balance' => $card_balance, 'password' => $password]);

                if(count($getUser) > 0){
                    $info = "success";
                    $linkdirect = $this->domainUrl()."login?tenant=".$email;

                }
                else{

                    // Insert Record
                    $insRec = User::insert(['ref_code' => $ref_code, 'name' => $firstname.' '.$lastname, 'email' => $email, 'address' => $address, 'city' => $city, 'state' =>$state, 'country' => $country, 'accountType' => 'Individual', 'zip' => $postal_code, 'ref_code' => $ref_code, 'card_balance' => $card_balance, 'password' => $password]);

                    if($insRec == true){
                        $info = "success";
                        $linkdirect = $this->domainUrl()."login?tenant=".$email;
                    }
                    else{
                        $info = "fail";
                        $linkdirect = "https://exbc.com/Product";
                    }
                }
                }
                elseif($accountType == "client"){
                    $getUser = Admin::where('username', $username)->get();

                    // Update card balance
                    ClientInfo::where('email', $email)->update(['user_id' => $ref_code, 'card_balance' => $card_balance]);

                    User::where('email', $email)->update(['ref_code' => $ref_code, 'card_balance' => $card_balance, 'password' => $password]);

                if(count($getUser) > 0){
                    $info = "success";
                    $linkdirect = $this->domainUrl()."login?tenant=".$email;

                }
                else{

                    // Insert Record
                    $insRec = Admin::insert(['user_id' => $ref_code, 'firstname' => $firstname, 'lastname' => $lastname, 'username' => $username, 'password' => $password, 'role' => 'Client', 'email' => $email]);

                    if($insRec == true){
                        // Insert CLient Info
                        $clientInfo = ClientInfo::insert(['user_id' => $ref_code, 'business_name' => $companyname, 'address' => $address, 'firstname' => $firstname, 'lastname' => $lastname, 'email' => $email, 'country' => $country, 'state' => $state, 'city' => $city, 'zip_code' => $postal_code, 'card_balance' => $card_balance]);

                        User::insert(['ref_code' => $ref_code, 'name' => $firstname.' '.$lastname, 'email' => $email, 'address' => $address, 'city' => $city, 'state' =>$state, 'country' => $country, 'accountType' => 'Individual', 'zip' => $postal_code, 'ref_code' => $ref_code, 'card_balance' => $card_balance, 'password' => $password]);

                        $info = "success";
                        $linkdirect = $this->domainUrl()."login?tenant=".$email;
                    }
                    else{
                        $info = "fail";
                        $linkdirect = "https://exbc.com/Product";
                    }
                }
                }

                

                // $result = 1;
                $result = array('action' => $info, 'data' => $linkdirect);
                    break;

                case 'property_owner':

                    if($accountType == "user"){
                    $getUser = User::where('email', $email)->get();
                    // Update card balance
                    User::where('email', $email)->update(['ref_code' => $ref_code, 'card_balance' => $card_balance, 'password' => $password]);

                if(count($getUser) > 0){
                    $info = "success";
                    $linkdirect = $this->domainUrl()."login?property_owner=".$email;

                }
                else{

                    // Insert Record
                    $insRec = User::insert(['ref_code' => $ref_code, 'name' => $firstname.' '.$lastname, 'email' => $email, 'address' => $address, 'city' => $city, 'state' =>$state, 'country' => $country, 'accountType' => 'Individual', 'zip' => $postal_code, 'ref_code' => $ref_code, 'card_balance' => $card_balance, 'password' => $password]);

                    if($insRec == true){
                        $info = "success";
                        $linkdirect = $this->domainUrl()."login?property_owner=".$email;
                    }
                    else{
                        $info = "fail";
                        $linkdirect = "https://exbc.com/Product";
                    }
                }
                }
                elseif($accountType == "client"){
                    $getUser = Admin::where('username', $username)->get();

                    // Update card balance
                    ClientInfo::where('email', $email)->update(['user_id' => $ref_code, 'card_balance' => $card_balance]);

                    User::where('email', $email)->update(['ref_code' => $ref_code, 'card_balance' => $card_balance, 'password' => $password]);

                if(count($getUser) > 0){
                    $info = "success";
                    $linkdirect = $this->domainUrl()."login?property_owner=".$email;

                }
                else{

                    // Insert Record
                    $insRec = Admin::insert(['user_id' => $ref_code, 'firstname' => $firstname, 'lastname' => $lastname, 'username' => $username, 'password' => $password, 'role' => 'Client', 'email' => $email]);

                    if($insRec == true){
                        // Insert CLient Info
                        $clientInfo = ClientInfo::insert(['user_id' => $ref_code, 'business_name' => $companyname, 'address' => $address, 'firstname' => $firstname, 'lastname' => $lastname, 'email' => $email, 'country' => $country, 'state' => $state, 'city' => $city, 'zip_code' => $postal_code, 'card_balance' => $card_balance]);

                        User::insert(['ref_code' => $ref_code, 'name' => $firstname.' '.$lastname, 'email' => $email, 'address' => $address, 'city' => $city, 'state' =>$state, 'country' => $country, 'accountType' => 'Individual', 'zip' => $postal_code, 'ref_code' => $ref_code, 'card_balance' => $card_balance, 'password' => $password]);

                        $info = "success";
                        $linkdirect = $this->domainUrl()."login?property_owner=".$email;
                    }
                    else{
                        $info = "fail";
                        $linkdirect = "https://exbc.com/Product";
                    }
                }
                }

                

                // $result = 1;
                $result = array('action' => $info, 'data' => $linkdirect);
                    break;

                case 'service_provider':
                   
                    if($accountType == "user"){
                    $getUser = User::where('email', $email)->get();
                    // Update card balance
                    User::where('email', $email)->update(['ref_code' => $ref_code, 'card_balance' => $card_balance, 'password' => $password]);

                if(count($getUser) > 0){
                    $info = "success";
                    $linkdirect = $this->domainUrl()."login?service_provider=".$email;

                }
                else{

                    // Insert Record
                    $insRec = User::insert(['ref_code' => $ref_code, 'name' => $firstname.' '.$lastname, 'email' => $email, 'address' => $address, 'city' => $city, 'state' =>$state, 'country' => $country, 'accountType' => 'Individual', 'zip' => $postal_code, 'ref_code' => $ref_code, 'card_balance' => $card_balance, 'password' => $password]);

                    if($insRec == true){
                        $info = "success";
                        $linkdirect = $this->domainUrl()."login?service_provider=".$email;
                    }
                    else{
                        $info = "fail";
                        $linkdirect = "https://exbc.com/Product";
                    }
                }
                }
                elseif($accountType == "client"){
                    $getUser = Admin::where('username', $username)->get();

                    // Update card balance
                    ClientInfo::where('email', $email)->update(['user_id' => $ref_code, 'card_balance' => $card_balance]);

                    User::where('email', $email)->update(['ref_code' => $ref_code, 'card_balance' => $card_balance, 'password' => $password]);

                if(count($getUser) > 0){
                    $info = "success";
                    $linkdirect = $this->domainUrl()."login?service_provider=".$email;

                }
                else{

                    // Insert Record
                    $insRec = Admin::insert(['user_id' => $ref_code, 'firstname' => $firstname, 'lastname' => $lastname, 'username' => $username, 'password' => $password, 'role' => 'Client', 'email' => $email]);

                    if($insRec == true){
                        // Insert CLient Info
                        $clientInfo = ClientInfo::insert(['user_id' => $ref_code, 'business_name' => $companyname, 'address' => $address, 'firstname' => $firstname, 'lastname' => $lastname, 'email' => $email, 'country' => $country, 'state' => $state, 'city' => $city, 'zip_code' => $postal_code, 'card_balance' => $card_balance]);

                        User::insert(['ref_code' => $ref_code, 'name' => $firstname.' '.$lastname, 'email' => $email, 'address' => $address, 'city' => $city, 'state' =>$state, 'country' => $country, 'accountType' => 'Individual', 'zip' => $postal_code, 'ref_code' => $ref_code, 'card_balance' => $card_balance, 'password' => $password]);

                        $info = "success";
                        $linkdirect = $this->domainUrl()."login?service_provider=".$email;
                    }
                    else{
                        $info = "fail";
                        $linkdirect = "https://exbc.com/Product";
                    }
                }
                }

                

                // $result = 1;
                $result = array('action' => $info, 'data' => $linkdirect);

                    break;
                
                default:
                    $result = array('action' => "Unknown action", 'data' => 0);
                    break;
            }


            return $this->returnJSON($result, 200);

        }


        public function getstatement($email, $platform, $username, $ref_code, $accountType, $start_date, $end_date){
        

        // $getInvs =  DB::table('invoice_payment')
        //              ->select(DB::raw('invoice_payment.transactionid as trans_id, invoice_payment.name, invoice_payment.email, import_excel.amount as invoice_amount, invoice_payment.invoice_no as loan_number, invoice_payment.service, invoice_payment.created_at as transaction_date, import_excel.description as description, invoice_payment.remaining_balance as runningbalance, invoice_payment.amount as payedAmount, invoice_payment.mystatus as status, invoice_payment.created_at as trans_date'))->distinct()
        //              ->join('import_excel', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')
        //             ->where('invoice_payment.email', $email)
        //             ->whereBetween('invoice_payment.created_at', [$start_date, $end_date])
        //             ->orderBy('invoice_payment.created_at', 'DESC')->get();


                   $getInvs = Statement::where('user_id', $email)->whereBetween('trans_date', [$start_date, $end_date])->orderBy('created_at', 'DESC')->get();



    
        // dd($getInvs);

            if(count($getInvs) > 0){
                $info = "success";
                $mydata = $getInvs;

                $result = array('action' => $info, 'data' => $mydata, 'platform' => $platform);

            }
            else{

                $result = array('action' => "You do not have record for this service", 'data' => 0);

                // $getInvs = DB::table('import_excel')
                //      ->select(DB::raw('import_excel.amount as payedAmount, import_excel.invoice_no as loan_number, import_excel.description as description, import_excel.status as status, import_excel.service, import_excel.created_at as trans_date'))->distinct()
                //     ->where('import_excel.payee_email', $email)
                //     ->whereBetween('import_excel.created_at', [$start_date, $end_date])
                //     ->orderBy('import_excel.created_at', 'DESC')->get();

                // if(count($getInvs) > 0){
                //     $info = "success";
                //     $mydata = $getInvs;

                //     $result = array('action' => $info, 'data' => $mydata, 'platform' => $platform);

                // }
                // else{
                //         $result = array('action' => "You do not have record for this service", 'data' => 0);

                // }

            }


            return $this->returnJSON($result, 200);
        }


        public function getinvoice($email, $platform, $ref_code){
            $getInvs = Statement::where('user_id', $email)->where('reference_code', $ref_code)->orderBy('created_at', 'DESC')->get();

            if(count($getInvs) > 0){
                $mydata = $getInvs;

                $result = array('action' => "success", 'data' => $mydata, 'platform' => $platform);
            }
            else{
                $result = array('action' => "You do not have record for this service", 'data' => 0);
            }

            return $this->returnJSON($result, 200);
        }
        

        // //Verify platform originator and domain
    public function gettrust($platform){
        $useragent = $platform->headers->all()['user-agent'][0];
        $theplatform = $platform['platform'];

        if($theplatform == $this->platform && $useragent == $this->useragent)
        {
            $this->valid = 1;
            $this->userid = $platform['userid'];
        }
        else{
            $this->valid = 0;
        }
    }


    public function domainUrl(){
        $domain = "https://".$_SERVER['HTTP_HOST']."/";

        return $domain;
    }

    



}
