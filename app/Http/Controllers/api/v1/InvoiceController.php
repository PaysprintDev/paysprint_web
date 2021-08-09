<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Rap2hpoutre\FastExcel\FastExcel;
use Maatwebsite\Excel\Facades\Excel;

use App\Imports\InvoiceImport;

use Illuminate\Support\Facades\Log;

use App\Mail\sendEmail;

use App\User as User;
use App\ImportExcel as ImportExcel;
use App\ClientInfo as ClientInfo;
use App\Statement as Statement;
use App\Tax as Tax;

use App\Traits\Xwireless;

class InvoiceController extends Controller
{   

    use Xwireless;

    public $to = "info@paysprint.net";
    public $name;
    public $admin;
    public $email;
    public $transaction_date;
    public $invoice_no;
    public $payee_ref_no;
    public $transaction_ref;
    public $description;
    public $payment_due_date;
    public $amount;
    public $address;
    public $clientname;
    public $subject;
    public $message;
    public $service;
    public $city;
    public $state;
    public $zipcode;
    public $info;
    public $info2;
    public $infomessage;
    public $customer_id;
    public $tax;
    public $tax_amount;
    public $total_amount;
    

    public function getAllInvoices(Request $req){

        $user = User::where('api_token', $req->bearerToken())->first();

        if(isset($user)){

           $data = ImportExcel::where('payee_email', $user->email)->orderBy('created_at', 'DESC')->get();

           if(count($data) > 0){
                $status = 200;
        
                $resData = ['data' => $data, 'message' => 'success', 'status' => $status];

                Log::info("Get all invoice for :=> ".$user->name);
           }
           else{
                $status = 400;
        
                $resData = ['data' => [], 'message' => 'No record found', 'status' => $status];
           }

        }
        else{
            $status = 400;

            $resData = ['data' => [], 'message' => 'Token mismatch', 'status' => $status];
        }

    return $this->returnJSON($resData, $status);

    }


    public function getSpecificInvoices(Request $req){

        $user = User::where('api_token', $req->bearerToken())->first();

        if(isset($user)){

           $data = ImportExcel::where('payee_email', $user->email)->where('invoice_no', $req->get('invoice'))->where('service', 'LIKE', '%'.$req->get('service').'%')->orderBy('created_at', 'DESC')->get();

           if(count($data) > 0){
            $status = 200;
            
            Log::info("Get specific invoice for :=> ".$user->name);

            $resData = ['data' => $data, 'message' => 'success', 'status' => $status];
       }
       else{

        // Check the invoice

        $data = ImportExcel::where('payee_email', $user->email)->where('invoice_no', $req->get('invoice'))->orderBy('created_at', 'DESC')->get();

        if(count($data) > 0){
            $status = 200;

            Log::info("Get specific invoice for :=> ".$user->name);
    
            $resData = ['data' => $data, 'message' => 'success', 'status' => $status];
       }
       else{
        $status = 400;
    
            $resData = ['data' => [], 'message' => 'No record found', 'status' => $status];
       }

            
       }

        }
        else{
            $status = 400;

            $resData = ['data' => [], 'message' => 'Token mismatch', 'status' => $status];
        }

        return $this->returnJSON($resData, $status);
    }




    public function getInvoiceByService(Request $req){

        $user = User::where('api_token', $req->bearerToken())->first();

        if(isset($user)){

           $data = ImportExcel::where('payee_email', $user->email)->where('service', 'LIKE', '%'.$req->get('service').'%')->orderBy('created_at', 'DESC')->get();

           if(count($data) > 0){
            $status = 200;

            Log::info("Get invoice by ".$req->get('service')." for :=> ".$user->name);
    
            $resData = ['data' => $data, 'message' => 'success', 'status' => $status];
       }
       else{
            $status = 400;
    
            $resData = ['data' => [], 'message' => 'No record found', 'status' => $status];
       }

        }
        else{
            $status = 400;

            $resData = ['data' => [], 'message' => 'Token mismatch', 'status' => $status];
        }

        return $this->returnJSON($resData, $status);

    }

    public function singleInvoice(Request $req){

        $validator = Validator::make($req->all(), [
                     'single_firstname' => 'required|string',
                     'single_lastname' => 'required|string',
                     'single_email' => 'required|string',
                     'single_telephone' => 'required|string',
                     'single_service' => 'required|string',
                     'single_invoiceno' => 'required|string',
                     'single_transaction_date' => 'required|string',
                     'single_amount' => 'required|string',
                     'single_payment_due_date' => 'required|string',
                     'single_tax' => 'required|string',
                     'single_tax_amount' => 'required|string',
                     'single_total_amount' => 'required|string',
                ]);


                if($validator->passes()){
                        try {
                            $thisuser = User::where('api_token', $req->bearerToken())->first();
                            
                            if(isset($thisuser) == false){
                                $status = 400;
                                $data = [];
                                $message = "Invalid authorization";
                            }
                            else{

                                // Check if invoice exist
                                $checkExist = ImportExcel::where('invoice_no', $req->single_invoiceno)->first();

                                if(isset($checkExist) == true){
                                    $status = 400;
                                    $data = [];
                                    $message = "This invoice number already exists";
                                }
                                else{

                                    $getCustomer = User::where('email', $req->single_email)->first();

                                    if(isset($getCustomer)){
                                        $address = $getCustomer->address;
                                        $customerRefcode = $getCustomer->ref_code;
                                        $telephone = "+".$getCustomer->code.$getCustomer->telephone;
                                    }
                                    else{

                                        $customerRefcode = null;
                                        $address = null;
                                        $telephone = $req->single_telephone;
                                    }

                                    $getTax = Tax::where('id', $req->single_tax)->first();

                                    // Insert Record
                                    $query = [
                                        'transaction_date' => $req->single_transaction_date, 'invoice_no' => $req->single_invoiceno, 'payee_ref_no' => $req->single_transaction_ref, 'name' => $req->single_firstname.' '.$req->single_lastname, 'transaction_ref' => $req->single_transaction_ref, 'description' => $req->single_description, 'amount' => $req->single_amount, 'payment_due_date' => $req->single_payment_due_date, 'payee_email' => $req->single_email, 'address' => $address, 'customer_id' => $thisuser->ref_code, 'service' => $req->single_service, 'installpay' => $req->single_installpay, 'installlimit' => $req->single_installlimit, 'status' => 'invoice', 'uploaded_by' => $thisuser->ref_code, 'merchantName' => $thisuser->businessname, 'recurring' => $req->single_recurring_service, 'reminder' => $req->single_reminder_service, 'telephone' => $req->single_telephone, 'tax' => $req->single_tax, 'tax_amount' => $req->single_tax_amount, 'total_amount' => $req->single_total_amount, 'remaining_balance' => $req->single_total_amount
                                    ];

                                    $insertData = ImportExcel::insert($query);

                                    // Insert Statement
                                    $activity = "Invoice on ".$req->single_service;
                                    $credit = $req->single_total_amount;
                                    $debit = 0;
                                    $balance = 0;
                                    $reference_code = $req->single_invoiceno;
                                    $status = "Delivered";
                                    $action = "Invoice";

                                    $trans_date = date('Y-m-d', strtotime($req->single_transaction_date));

                                    $regards = $thisuser->ref_code;

                                    $this->insStatement($req->single_email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 0);

                                    if($thisuser->businessname != null){
                                        $businessName = $thisuser->businessname;
                                    }
                                    else{

                                        $getClient = ClientInfo::where('user_id', $thisuser->ref_code)->first();

                                        $businessName = $getClient->business_name;
                                    }


                                    $this->to = $req->single_email;
                                    // $this->to = "adenugaadebambo41@gmail.com";
                                    $this->name = $req->single_firstname.' '.$req->single_lastname;
                                    $this->transaction_date = $req->single_transaction_date;
                                    $this->invoice_no = $req->single_invoiceno;
                                    $this->payee_ref_no = $req->single_transaction_ref;
                                    $this->transaction_ref = $req->single_transaction_ref;
                                    $this->description = $req->single_description;
                                    $this->payment_due_date = $req->single_payment_due_date;
                                    $this->amount = $thisuser->currencySymbol.number_format($req->single_amount, 2);
                                    $this->total_amount = $thisuser->currencySymbol.number_format($req->single_total_amount, 2);
                                    $this->address = $thisuser->address;
                                    $this->service = $req->single_service;
                                    $this->clientname = $businessName;
                                    $this->client_realname = $thisuser->name;
                                    $this->city = $thisuser->city;
                                    $this->state = $thisuser->state;
                                    $this->zipcode = $thisuser->zipcode;
                                    $this->customer_id = $thisuser->ref_code;
                                    $this->tax = $getTax->rate.'% '.$getTax->name;
                                    $this->tax_amount = $thisuser->currencySymbol.number_format($req->single_tax_amount, 2);

                                    $this->subject = 'You have an invoice '.$req->single_invoiceno.' from  '.$this->clientname.' on PaySprint';

                                    $this->sendEmail($this->to, $this->subject);

                                    // Send SMS
                                    $sendMsg = "Hello ".$this->name.", ".$this->subject.". Login to your PaySprint App to make payment. ".route('login');

                                    $sendPhone = $telephone;
                                    // $sendPhone = "+23408137492316";

                                    if($thisuser->country == "Nigeria"){

                                        $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                                        $this->sendSms($sendMsg, $correctPhone);
                                    }
                                    else{
                                        $this->sendMessage($sendMsg, $sendPhone);

                                    }


                                    Log::info("Single Invoice prepared by ".$this->clientname." for :=> ".$this->name);

                                    if($customerRefcode != null){

                                        $this->createNotification($customerRefcode, $sendMsg);
                                    }


                                    $getinvoiceData = ImportExcel::where('invoice_no', $req->single_invoiceno)->first();

                                    $status = 200;
                                    $data = $getinvoiceData;
                                    $message = "Invoice generated";

                                }
                            }

                        } 
                        catch (\Throwable $th) {
                            $status = 400;
                            $data = [];
                            $message = "Error: ".$th->getMessage();
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



    public function bulkInvoice(Request $req){

        // dd($req->all());

        $queryData;

        $validator = Validator::make($req->all(), [
                     'excel_file' => ['required','mimes:xls,xlsx'],
                     'service' => 'required|string',
                ]);

                try {
                    $thisuser = User::where('api_token', $req->bearerToken())->first();
                    
                    if(isset($thisuser) == false){
                        $status = 400;
                        $data = [];
                        $message = "Invalid authorization";
                    }
                    else{

                        if($req->file('excel_file')){
                                //Get filename with extension
                                $filenameWithExt = $req->file('excel_file')->getClientOriginalName();
                                // Get just filename
                                $filename = pathinfo($filenameWithExt , PATHINFO_FILENAME);
                                // Get just extension
                                $extension = $req->file('excel_file')->getClientOriginalExtension();



                                if($extension == "xlsx" || $extension == "xls"){

                                    $path = $req->file('excel_file')->getRealPath();


                                    // $data = Excel::import($path)->get();
                                    // $data = (new FastExcel)->import($path);


                                    // Get Client Name & Address

                                    $getClient = ClientInfo::where('user_id', $thisuser->ref_code)->first();

                                    if(isset($getClient)){
                                        $clientname = $getClient->business_name;
                                        $clientaddress = $getClient->address;
                                        $client_realname = $getClient->firstname.' '.$getClient->lastname;
                                        $city = $getClient->city;
                                        $state = $getClient->state;
                                        $zipcode = $getClient->zip_code;
                                    }
                                    else{
                                        $clientname = "PaySprint (EXBC)";
                                        $client_realname = "PaySprint (EXBC)";
                                        $clientaddress = "PaySprint by Express Ca Corp, 10 George St. North, Brampton. ON. L6X1R2. Canada";
                                        $city = "Brampton";
                                        $state = "Ontario";
                                        $zipcode = "L6X1R2";
                                    }


                                    $getTax = Tax::where('id', $req->single_tax)->first();


                                    $query = $req->all();
                                    $query['ref_code'] = $thisuser->ref_code;
                                    $query['client_realname'] = $client_realname;


                                    $data = Excel::import(new InvoiceImport($query), $req->file('excel_file'));

                                    dd($data);

                                    if($data->count() > 0){
                                        foreach ($data->toArray() as $key) {

                                                if($key['Invoice #'] == "" || $key['Invoice #'] == null){
                                                    $invoice_no = $key['Transaction Ref'].''.date('Ymd');
                                                }
                                                else{
                                                    $invoice_no = $key['Invoice #'];
                                                }

                                                $EXCEL_DATE1 = $key['Transaction Date'];
                                                $EXCEL_DATE2 = $key['Payment Due Date'];

                                                if ($EXCEL_DATE1 instanceof \Datetime) {
                                                    $UNIX_DATE1 = $EXCEL_DATE1->format('Y-m-d H:i:s');
                                                } elseif ($EXCEL_DATE1) {
                                                    $UNIX_DATE1 = (string) $EXCEL_DATE1;
                                                }


                                                if ($EXCEL_DATE2 instanceof \Datetime) {
                                                    $UNIX_DATE2 = $EXCEL_DATE2->format('Y-m-d H:i:s');
                                                } elseif ($EXCEL_DATE2) {
                                                    $UNIX_DATE2 = (string) $EXCEL_DATE2;
                                                }


                                                // $UNIX_DATE1 = (intval($EXCEL_DATE1) - 25569) * 86400;
                                                // $UNIX_DATE2 = (intval($EXCEL_DATE2) - 25569) * 86400;

                                                
                                                // dd($UNIX_DATE1);

                                                // Tax amount in %...
                                                $taxAmount = ($getTax->rate / 100) * $key['Amount'];

                                                $totalAmount = $key['Amount'] + $taxAmount;
                                                

                                                if($key['Customer Email'] == "" || $key['Customer Email'] == null){

                                                    $status = 400;
                                                    $data = [];
                                                    $message = "This excel sheet may contain some empty fields. Kindly download and use the test sample to make a copy of your file.";
                                                    
                                                }
                                                else{


                                                    $insert_data[] = array(
                                                    // 'transaction_date' => gmdate("d-m-Y", $UNIX_DATE1),
                                                    'transaction_date' => date('d-m-Y', strtotime($UNIX_DATE1)),
                                                    'invoice_no' => $invoice_no,
                                                    'payee_ref_no' => $key['Customer ID'],
                                                    'name' => $key['Name'],
                                                    'transaction_ref' => $key['Transaction Ref'],
                                                    'description' => $key['Description'],
                                                    'amount' => $key['Amount'],
                                                    // 'payment_due_date' => gmdate("d-m-Y", $UNIX_DATE2),
                                                    'payment_due_date' => date('d-m-Y', strtotime($UNIX_DATE2)),
                                                    'payee_email' => $key['Customer Email'],
                                                    'address' => $key['Customer Address'],
                                                    'customer_id' => $key['Customer ID'],
                                                    'service' => $req->service,
                                                    'installpay' => $req->installpay,
                                                    'installlimit' => $req->installlimit,
                                                    'uploaded_by' => $thisuser->ref_code,
                                                    'merchantName' => $client_realname,
                                                    'recurring' => $req->recurring_service,
                                                    'reminder' => $req->reminder_service,
                                                    'tax' => $req->single_tax,
                                                    'tax_amount' => $taxAmount,
                                                    'total_amount' => $totalAmount, 
                                                    'remaining_balance' => $totalAmount
                                                    
                                                );

                                                    // Insert Statement
                                                    $activity = "Invoice on ".$req->service;
                                                    $credit = $totalAmount;
                                                    $debit = 0;
                                                    $balance = 0;
                                                    $reference_code = $invoice_no;
                                                    $status = "Delivered";
                                                    $action = "Invoice";
                                                    $trans_date = date('Y-m-d', strtotime($UNIX_DATE1));
                                                    $regards = $thisuser->ref_code;
                                                    
                                                    $this->insStatement($key['Customer Email'], $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 0);

                                                $this->to = $key['Customer Email'];
                                                // $this->to = "adenugaadebambo41@gmail.com";
                                                $this->name = $key['Name'];
                                                // $this->transaction_date = gmdate("Y-m-d", $UNIX_DATE1);
                                                $this->transaction_date = date('Y-m-d', strtotime($UNIX_DATE1));
                                                $this->invoice_no = $invoice_no;
                                                $this->payee_ref_no = $key['Customer ID'];
                                                $this->transaction_ref = $key['Transaction Ref'];
                                                $this->description = $key['Description'];
                                                // $this->payment_due_date = gmdate("Y-m-d", $UNIX_DATE2);
                                                $this->payment_due_date = date('Y-m-d', strtotime($UNIX_DATE2));
                                                $this->customer_id = $key['Customer ID'];
                                                $this->amount = $thisuser->currencySymbol.number_format($key['Amount'], 2);
                                                $this->address = $clientaddress;
                                                $this->service = $req->service;
                                                $this->clientname = $clientname;
                                                $this->client_realname = $client_realname;
                                                $this->city = $city;
                                                $this->state = $state;
                                                $this->zipcode = $zipcode;
                                                $this->tax = $getTax->rate.'% '.$getTax->name;
                                                $this->tax_amount = $thisuser->currencySymbol.number_format($taxAmount, 2);
                                                $this->total_amount = $thisuser->currencySymbol.number_format($totalAmount, 2);

                                                $this->subject = 'You have an invoice '.$this->invoice_no.' from  '.$this->clientname.' on PaySprint';

                                                $this->sendEmail($this->to, $this->subject);

                                                Log::info("Bulk Invoice prepared by ".$this->clientname);

                                                $getCustomer = User::where('email', $key['Customer Email'])->first();

                                                if(isset($getCustomer)){
                                                    // Send SMS

                                                    

                                                    $sendMsg = "Hello ".$this->name.", ".$this->subject.". Login to your PaySprint App to make payment. <a href='".route('login')."'>".route('login')."</a>";

                                                    $getPhone = User::where('email', $key['Customer Email'])->where('telephone', 'LIKE', '%+%')->first();
                                                    
                                                    if(isset($getPhone)){
                                                        $sendPhone = $getCustomer->telephone;
                                                    }
                                                    else{
                                                        $sendPhone = "+".$getCustomer->code.$getCustomer->telephone;
                                                    }

                                                    if($getCustomer->country == "Nigeria"){

                                                            $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                                                            $this->sendSms($sendMsg, $correctPhone);
                                                        }
                                                        else{
                                                            $this->sendMessage($sendMsg, $sendPhone);

                                                        }
                                                    $this->createNotification($getCustomer->ref_code, $sendMsg);

                                                }
                                                


                                                }

                                        }

                                        if(!empty($insert_data)){

                                            $data = DB::table('import_excel')->insert($insert_data);

                                            
                                        }
                                    }

                                    // Filename to store
                                    // $fileNameToStore = rand().'_'.time().'.'.$extension;

                                    // $req->file('excel_file')->move(public_path('../../excelUpload/'), $fileNameToStore);


                                    $status = 200;
                                    $data = 1;
                                    $message = "Upload Successfull";

                                }
                                else{
                                    $status = 400;
                                    $data = [];
                                    $message = "Unable to process ".strtoupper($extension)." file";
                                }
                        }
                        else{
                            $status = 400;
                            $data = [];
                            $message = "Please upload a file!";
                        }

                        
                    }

                } 
                catch (\Throwable $th) {
                    $status = 400;
                    $data = [];
                    $message = "Error: ".$th->getMessage();
                }

            $resData = ['data' => $data, 'message' => $message, 'status' => $status];

        return $this->returnJSON($resData, $status);
    }


    public function insStatement($email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, $state){
        Statement::insert(['user_id' => $email, 'reference_code' => $reference_code, 'activity' => $activity, 'credit' => $credit, 'debit' => $debit, 'balance' => $balance, 'trans_date' => $trans_date, 'status' => $status, 'action' => $action, 'regards' => $regards, 'state' => $state]);
    }

    public function sendEmail($objDemoa, $purpose){
      $objDemo = new \stdClass();
      $objDemo->purpose = $purpose;

      if($purpose == $this->subject){

            $objDemo->name = $this->name;
            $objDemo->email = $this->to;
            $objDemo->transaction_date = $this->transaction_date;
            $objDemo->invoice_no = $this->invoice_no;
            $objDemo->payee_ref_no = $this->payee_ref_no;
            $objDemo->transaction_ref = $this->transaction_ref;
            $objDemo->description = $this->description;
            $objDemo->payment_due_date = $this->payment_due_date;
            $objDemo->amount = $this->amount;
            $objDemo->address = $this->address;
            $objDemo->service = $this->service;
            $objDemo->clientname = $this->clientname;
            $objDemo->client_realname = $this->client_realname;
            $objDemo->city = $this->city;
            $objDemo->state = $this->state;
            $objDemo->zipcode = $this->zipcode;
            $objDemo->customer_id = $this->customer_id;
            $objDemo->tax = $this->tax;
            $objDemo->tax_amount = $this->tax_amount;
            $objDemo->total_amount = $this->total_amount;

        }
        

      Mail::to($objDemoa)
            ->send(new sendEmail($objDemo));
   }

}
