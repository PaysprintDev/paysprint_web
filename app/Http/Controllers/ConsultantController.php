<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;

use Session;

use App\Mail\sendEmail;

use App\Consultant as Consultant;

use App\MaintenanceRequest as MaintenanceRequest;

use App\RentalMessage as RentalMessage;

use App\Workorder as Workorder;

use App\ImportExcel as ImportExcel;

use App\Statement as Statement;

use App\User as User;

use App\RentalQuote as RentalQuote;

class ConsultantController extends Controller
{

    public $name;
    public $email;
    public $subject;
    public $message;
    public $file;
    public $to = "info@paysprint.net";
    public $admin;
    public $transaction_date;
    public $invoice_no;
    public $payee_ref_no;
    public $transaction_ref;
    public $description;
    public $payment_due_date;
    public $amount;
    public $address;
    public $clientname;
    public $service;
    public $city;
    public $state;
    public $zipcode;
    public $info;
    public $info2;
    public $infomessage;
    public $customer_id;

    public function store(Request $req, Consultant $consultant){

        $checkExist = $consultant->where('owner_email', session('email'))->where('consultant_email', $req->consultant_email)->get();

        if(count($checkExist) > 0){
            $resData = "You have already created this consultant";
            $resp = "error";
        }
        else{

            $consultant->owner_name = $req->owner_name;
            $consultant->owner_email = $req->owner_email;
            $consultant->consultant_name = $req->consultant_name;
            $consultant->consultant_email = $req->consultant_email;
            $consultant->consultant_telephone = $req->consultant_phone;
            $consultant->consultant_address = $req->consultant_address;
            $consultant->consultant_specialization = $req->consultant_specialization;

            $result = $consultant->save();

            if($result == true){

                // Send Mail

                $this->name = $req->consultant_name;
                $this->email = $req->consultant_email;
                $this->subject = $req->owner_name. " registered you on PaySprint as one of their consultant";
                $this->message = "Hi ".$this->name.", <br><br> <b>".$req->owner_name."</b> registered you as one of their consultant on PaySprint.<br>. <br><br> Kindly follow these steps to manage the Request: <br> a. Click on this link <a href='https://exbc.ca/login'>https://exbc.ca/login</a> to login to EXBC Account. <br> b. Go to Manage Rental Property on Free Business App and Select Service Provider <br><br> Thanks <br> PaySprint Management.";

                $this->file = "noImage.png";
                $this->sendEmail($this->email, "Maintenace Request");


                $resData = "Created Successfully";
                $resp = "success";
            }
            else{
                $resData = "Something went wrong!";
                $resp = "error";
            }

        }

        return redirect()->back()->with($resp, $resData);
    }


    public function editconsultant(Request $req, Consultant $consultant){

        $checkExist = $consultant->where('id', $req->id)->update(['consultant_name' => $req->consultant_name, 'consultant_email' => $req->consultant_email, 'consultant_telephone' => $req->consultant_phone, 'consultant_address' => $req->consultant_address, 'consultant_specialization' => $req->consultant_specialization]);

            if($checkExist == 1){

                // Send Mail

                $this->name = $req->consultant_name;
                $this->email = $req->consultant_email;
                $this->subject = $req->owner_name. " registered you on PaySprint as one of their consultant";
                $this->message = "Hi ".$this->name.", <br><br> <b>".$req->owner_name."</b> registered you as one of their consultant on PaySprint.<br>. <br><br> Kindly follow these steps to manage the Request: <br> a. Click on this link <a href='https://exbc.ca/login'>https://exbc.ca/login</a> to login to EXBC Account. <br> b. Go to Manage Rental Property on Free Business App and Select Service Provider <br><br> Thanks <br> PaySprint Management.";

                $this->file = "noImage.png";
                $this->sendEmail($this->email, "Maintenace Request");


                $resData = "Updated Successfully";
                $resp = "success";
            }
            else{
                $resData = "Something went wrong!";
                $resp = "error";
            }


        return redirect()->route('viewconsultant')->with($resp, $resData);
    }


    public function consultantdelete(Request $req, Consultant $consultant){

        $checkExist = $consultant->where('id', $req->id)->delete();

            if($checkExist == 1){
                $resData = "Deleted Successfully";
                $resp = "success";
            }
            else{
                $resData = "Something went wrong!";
                $resp = "error";
            }


        return redirect()->back()->with($resp, $resData);
    }


    public function assignConsultant(Request $req, Consultant $consultant, MaintenanceRequest $maintenance, RentalMessage $message, Workorder $workorder){

        $getmaintenance = $maintenance->where('post_id', $req->post_id)->get();

        if(count($getmaintenance) > 0){
            // Update Information and send mail to Consultant
            $maintenance->where('post_id', $req->post_id)->update(['status' => $req->maintenance_status_update, 'assigned_staff' => $req->assign_consultant]);

            $message->post_id = $req->post_id;
            $message->tenant_email = $req->tenant_email;
            $message->owner_email = $req->owner_email;
            $message->maintenance_status = $req->maintenance_status_update;
            $message->consultant_id = $req->assign_consultant;
            $message->response_note = $req->response_note;
            $message->maintenance_deadline = $req->maintenance_deadline;

            $result = $message->save();

            if($result == true){



                // Mail Consultant
                $getconsultant = $consultant->where('id', $req->assign_consultant)->get();

                $workorder->maintenance_id = $req->post_id;
                $workorder->consultant_email = $getconsultant[0]->consultant_email;
                $workorder->status = 'received';

                $workorder->save();

                $this->name = $getconsultant[0]->consultant_name;
                $this->email = $getconsultant[0]->consultant_email;
                $this->subject = $getconsultant[0]->owner_name." assigned a maintenance request to you.";

                $this->message = "Hi ".$this->name.", <br><br> Your client, <b>".$getconsultant[0]->owner_name."</b>, assigned a maintenance request to you. <br><br> <table style='font-family: arial, sans-serif; border-collapse: collapse; width: 100%;'><tbody><tr><td>Maintenance Request #</td><td>".$req->post_id."</td></tr><tr><td>Unit</td><td>".$getmaintenance[0]->unit."</td></tr><tr><td>Tenant</td><td>".$getmaintenance[0]->tenant_name."</td></tr><tr><td>Status</td><td>".$req->maintenance_status_update."</td></tr><tr><td>Priority</td><td>".$getmaintenance[0]->priority."</td></tr><tr><td>Is the problem in the unit?</td><td>".$getmaintenance[0]->problem_in_unit."</td></tr><tr><td>Permission granted to enter unit alone?</td><td>".$getmaintenance[0]->problem_in_unit.", ".$getmaintenance[0]->describe_event."</td></tr><tr><td>Subject</td><td>".$getmaintenance[0]->subject."</td></tr><tr><td>Details</td><td>".$getmaintenance[0]->details."</td></tr><tr><td>Additional Info.</td><td>".$getmaintenance[0]->additional_info."</td></tr><tr><td>Deadline Date</td><td>".date('d/F/Y', strtotime($req->maintenance_deadline))."</td></tr></tbody></table> <br><br> Kindly follow these steps to manage the Request: <br> a. Click on this link <a href='https://exbc.ca/login'>https://exbc.ca/login</a> to login to EXBC Account. <br> b. Go to Manage Rental Property on Free Business App and Select Service Provider <br><br> Thanks <br> PaySprint Management.";


                if($getmaintenance[0]->add_file == "noImage.png"){
                    $filename = "noImage.png";
                }
                else{
                    $file = explode(",", $getmaintenance[0]->add_file);
                    $filename = $file[0];
                }

                $this->file = $filename;

                $this->sendEmail($this->email, "Maintenace Request");


                $resData = "Successfull";
                $resp = "success";
            }
            else{
                $resData = "Something went wrong!";
                $resp = "error";
            }

        }
        else{
           $resData = "Record not found";
            $resp = "error";
        }



        return redirect()->back()->with($resp, $resData);
    }

    public function completedworkorder(Request $req, MaintenanceRequest $maintenance, RentalMessage $rentalmessage, Workorder $workorder){
        // Update Information
        $maintenance->where('post_id', $req->post_id)->update(['status' => 'complete']);
        $rentalmessage->where('post_id', $req->post_id)->update(['maintenance_status' => 'complete']);
        $workorder->where('maintenance_id', $req->post_id)->update(['status' => 'complete']);

        $provider = $maintenance->where('post_id', $req->post_id)->get();

        $clientinfo = User::where('ref_code', $provider[0]->owner_id)->get();

        $serviceprovider = Consultant::where('id', $provider[0]->assigned_staff)->get();

        // Send Mail


        $this->name = $clientinfo[0]->name;
        $this->email = $clientinfo[0]->email;
        $this->subject = $serviceprovider[0]->consultant_name." completed maintenance request.";

        $this->message = "Hi ".$this->name.", <br><br> Your service provider, <b>".$serviceprovider[0]->consultant_name."</b> has completed maintenance request. <br><br> <table style='font-family: arial, sans-serif; border-collapse: collapse; width: 100%;'><tbody><tr><td>Maintenance Request #</td><td>".$req->post_id."</td></tr><tr><td>Unit</td><td>".$provider[0]->unit_id."</td></tr><tr><td>Tenant Name</td><td>".$provider[0]->ten_name."</td></tr><tr><td>Tenant Phone</td><td>".$provider[0]->phone_number."</td></tr><tr><td>Priority</td><td>".$provider[0]->priority."</td></tr><tr><td>Is the problem in the unit?</td><td>".$provider[0]->problem_in_unit."</td></tr><tr><td>Permission granted to enter unit alone?</td><td>".$provider[0]->problem_in_unit."</td></tr><tr><td>Subject</td><td>".$provider[0]->subject."</td></tr><tr><td>Details</td><td>".$provider[0]->details."</td></tr><tr><td>Additional Info.</td><td>".$provider[0]->additional_info."</td></tr></tbody></table> <br><br> Kindly follow these steps to manage the Request: <br> a. Click on this link <a href='https://exbc.ca/login'>https://exbc.ca/login</a> to login to EXBC Account. <br> b. Go to Manage Rental Property on Free Business App and Select Property Manager/Owner <br><br> Thanks <br> PaySprint Management.";


        $this->file = "noImage.png";

        $this->sendEmail($this->email, "Maintenace Request");


        $resData = "Successfull";
        $resp = "success";


        return redirect()->route('consultantMymaintnenance', ['id' => $provider[0]->assigned_staff])->with($resp, $resData);

    }


    public function generateInvoice(Request $req, ImportExcel $invoice){

        if($req->type_of_service != ""){
            $service = $req->type_of_service;
        }
        else{
            $service = $req->specify_type_of_service;
        }

        // Insert Record
        $invoice->transaction_date = $req->transaction_date;
        $invoice->invoice_no = $req->invoice_number;
        $invoice->payee_ref_no = $req->reference_number;
        $invoice->name = $req->firstname.' '.$req->lastname;
        $invoice->transaction_ref = $req->transaction_ref;
        $invoice->description = $req->description;
        $invoice->amount = $req->amount;
        $invoice->remaining_balance = 0;
        $invoice->payment_due_date = $req->payment_due_date;
        $invoice->payee_email = $req->email_address;
        $invoice->address = $req->address;
        $invoice->customer_id = $req->reference_number;
        $invoice->service = $service;
        $invoice->installpay = $req->installment;
        $invoice->installlimit = $req->installment_limit;
        $invoice->installcount = 0;
        $invoice->status = "invoice";
        $invoice->uploaded_by = $req->consultant_email;
        $invoice->recurring = $req->recurring_service;
        $invoice->reminder = $req->reminder_service;

        $response = $invoice->save();

        if($response == true){

            // Send Mail

            $getClient = Consultant::where('consultant_email', $req->consultant_email)->get();

                    if(count($getClient) > 0){

                        $getuserData = User::where('email', $req->consultant_email)->get();

                        $clientname = $getClient[0]->consultant_specialization.' - '.$getClient[0]->consultant_name;
                        $clientaddress = $getClient[0]->consultant_address;
                        $client_realname = $getClient[0]->consultant_name;
                        $city = $getuserData[0]->city;
                        $state = $getuserData[0]->state;
                        $zipcode = $getuserData[0]->zip_code;
                    }
                    else{
                        $clientname = "PaySprint (EXBC)";
                        $client_realname = "PaySprint (EXBC)";
                        $clientaddress = "EXBC, by Express Ca Corp, 10 George St. North, Brampton. ON. L6X1R2. Canada";
                        $city = "Brampton";
                        $state = "Ontario";
                        $zipcode = "L6X1R2";
                    }




                    // Insert Statement
                    $activity = "Invoice on ".$service;
                    $credit = $req->amount;
                    $debit = 0;
                    $balance = 0;
                    $reference_code = $req->invoice_number;
                    $status = "Delivered";
                    $action = "Invoice";

                    $trans_date = date('Y-m-d', strtotime($req->transaction_date));

                    $regards = session('ref_code');

                    $this->insStatement($req->email_address, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 0);


                    $this->to = $req->email_address;
                    // $this->to = "adenugaadebambo41@gmail.com";
                    $this->name = $req->firstname.' '.$req->lastname;
                    $this->transaction_date = $req->transaction_date;
                    $this->invoice_no = $req->invoice_number;
                    $this->payee_ref_no = $req->reference_number;
                    $this->transaction_ref = $req->transaction_ref;
                    $this->description = $req->description;
                    $this->payment_due_date = $req->payment_due_date;
                    $this->amount = number_format($req->amount, 2);
                    $this->address = $clientaddress;
                    $this->service = $service;
                    $this->clientname = $clientname;
                    $this->client_realname = $client_realname;
                    $this->city = $city;
                    $this->state = $state;
                    $this->zipcode = $zipcode;
                    $this->customer_id = session('ref_code');

                    $this->subject = $this->clientname.' sends you an invoice on PaySprint';

                    $this->sendEmail($this->to, $this->subject);


                $resData = "Invoice generated successfully";
                $resp = "success";
        }
        else{
            $resData = "Something went wrong, Try Again!";
            $resp = "error";
        }

        return redirect()->route('consultantMaintenance', ['id' => $req->reference_number])->with($resp, $resData);
    }

    public function generateQuote(Request $req, RentalQuote $invoice){

        if($req->type_of_service != ""){
            $service = $req->type_of_service;
        }
        else{
            $service = $req->specify_type_of_service;
        }
        // Insert Record
        $invoice->maintenance_id = $req->reference_number;
        $invoice->property_owner = $req->email_address;
        $invoice->maintenance_description = $req->description;
        $invoice->maintenance_price = $req->amount;
        $invoice->maintenance_service = $service;
        $invoice->service_provider = $req->consultant_email;
        $invoice->status = 0;

        $response = $invoice->save();

        if($response == true){

            // Send Mail

            $getClient = Consultant::where('consultant_email', $req->consultant_email)->get();

                    if(count($getClient) > 0){

                        $getuserData = User::where('email', $req->consultant_email)->get();

                        $clientname = $getClient[0]->consultant_specialization.' - '.$getClient[0]->consultant_name;
                        $clientaddress = $getClient[0]->consultant_address;
                        $client_realname = $getClient[0]->consultant_name;
                        $city = $getuserData[0]->city;
                        $state = $getuserData[0]->state;
                        $zipcode = $getuserData[0]->zip_code;
                    }
                    else{
                        $clientname = "PaySprint (EXBC)";
                        $client_realname = "PaySprint (EXBC)";
                        $clientaddress = "EXBC, by Express Ca Corp, 10 George St. North, Brampton. ON. L6X1R2. Canada";
                        $city = "Brampton";
                        $state = "Ontario";
                        $zipcode = "L6X1R2";
                    }


                    $this->email = $req->email_address;
                    // $this->to = "adenugaadebambo41@gmail.com";
                    $this->name = $req->firstname.' '.$req->lastname;
                    $this->clientname = $clientname;
                    $this->client_realname = $client_realname;

                    $this->subject = $this->clientname.' sends you a quote on PaySprint';

                    $this->message = "Hi ".$this->name.", <br><br> Your service provider, <b>".$this->client_realname."</b>, sends you a quote to maintenance request. <br><br> <table style='font-family: arial, sans-serif; border-collapse: collapse; width: 100%;'><tbody><tr><td>Reference Number #</td><td>".$req->reference_number."</td></tr><tr><td>Type of Service</td><td>".$service."</td></tr><tr><td>Description</td><td>".$req->description."</td></tr><tr><td>Amount</td><td style='font-weight: bold; font-size: 24px;'>".number_format($req->amount, 2)."</td></tr></tbody></table> <br><br> Kindly follow these steps to manage the Request: <br> a. Click on this link <a href='https://exbc.ca/login'>https://exbc.ca/login</a> to login to EXBC Account. <br> b. Go to Manage Rental Property on Free Business App and Select Service Provider <br><br> Thanks <br> PaySprint Management.";

                    $this->file = "noImage.png";

                    $this->sendEmail($this->email, "Maintenace Request");


                $resData = "Quote generated successfully";
                $resp = "success";
        }
        else{
            $resData = "Something went wrong, Try Again!";
            $resp = "error";
        }

        return redirect()->route('consultantMaintenance', ['id' => $req->reference_number])->with($resp, $resData);
    }


    public function insStatement($email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, $state){
        Statement::insert(['user_id' => $email, 'reference_code' => $reference_code, 'activity' => $activity, 'credit' => $credit, 'debit' => $debit, 'balance' => $balance, 'trans_date' => $trans_date, 'status' => $status, 'action' => $action, 'regards' => $regards, 'state' => $state]);
    }


    // Ajax Request

    public function ajaxquotedecision(Request $req, RentalQuote $rental){

        $getitem = $rental->where('maintenance_id', $req->maintenance_id)->get();

        if(count($getitem) > 0){

            if($req->action == "accept"){

                $rental->where('maintenance_id', $req->maintenance_id)->update(['status' => 4]);

                $action = "accepted";
            }
            elseif($req->action == "reject"){
                $rental->where('maintenance_id', $req->maintenance_id)->update(['status' => 3]);
                $action = "rejected";
            }
            elseif($req->action == "acceptjobdone"){
                $rental->where('maintenance_id', $req->maintenance_id)->update(['status' => 1]);
                $action = "confirmed job done on";
            }

            // Send Mail
            $getUser = User::where('email', $getitem[0]->service_provider)->get();
            $getAdmin = User::where('email', $getitem[0]->property_owner)->get();

            $this->email = $getitem[0]->service_provider;
            $this->name = $getUser[0]->name;
            $this->clientname = $getAdmin[0]->name;
            $this->subject = $this->clientname.' '.$req->action.' your quote';

            $this->message = "Hi ".$this->name.", <br><br> <b>".$this->clientname."</b>, ".$action." your quote. <br><br> Kindly follow these steps to manage the Request: <br> a. Click on this link <a href='https://exbc.ca/login'>https://exbc.ca/login</a> to login to EXBC Account. <br> b. Go to Manage Rental Property on Free Business App and Select Service Provider <br><br> Thanks <br> PaySprint Management.";

            $this->file = "noImage.png";

            $this->sendEmail($this->email, "Maintenace Request");

            $resData = ['res' => 'Successfull', 'message' => 'success', 'title' => 'Thanks!'];

        }
        else{
            $resData = ['res' => 'This request is not found or deleted by the sender', 'message' => 'info', 'title' => 'Oops!'];
        }


        return $this->returnJSON($resData);
    }


    public function ajaxquotedecisionmaker(Request $req, RentalQuote $rental){

        $getitem = $rental->where('maintenance_id', $req->maintenance_id)->get();

        if(count($getitem) > 0){

            if($req->action == "jobdone"){

                $rental->where('maintenance_id', $req->maintenance_id)->update(['status' => 5]);
            }

            // Send Mail
            $getUser = User::where('email', $getitem[0]->service_provider)->get();
            $getAdmin = User::where('email', $getitem[0]->property_owner)->get();

            $this->name = $getUser[0]->name;
            $this->clientname = $getAdmin[0]->name;
            $this->email = $getAdmin[0]->email;
            $this->subject = "Maintenance Job Done by ".$this->name;

            $this->message = "Hi ".$this->clientname.", <br><br> <b>".$this->name."</b>, has completed the job assigned to them.<br><br> Thanks <br> PaySprint Management.";

            $this->file = "noImage.png";

            $this->sendEmail($this->email, "Maintenace Request");

            $resData = ['res' => 'Successfull', 'message' => 'success', 'title' => 'Thanks!'];

        }
        else{
            $resData = ['res' => 'This request is not found or deleted by the sender', 'message' => 'info', 'title' => 'Oops!'];
        }


        return $this->returnJSON($resData);
    }


    public function ajaxnegotiatequote(Request $req, RentalQuote $rental){

        $getitem = $rental->where('maintenance_id', $req->maintenance_id)->get();

        if(count($getitem) > 0){

            $rental->where('maintenance_id', $req->maintenance_id)->update(['status' => 2, 'negotiation_price' => $req->negotiation_price, 'negotiation_reason' => $req->negotiation_reason]);

            // Send Mail
            $getUser = User::where('email', $getitem[0]->service_provider)->get();
            $getAdmin = User::where('email', $getitem[0]->property_owner)->get();

            $this->email = $getitem[0]->service_provider;
            $this->name = $getUser[0]->name;
            $this->clientname = $getAdmin[0]->name;
            $this->subject = $this->clientname.' negotiates on your quote';

            $this->message = "Hi ".$this->name.", <br><br> <b>".$this->clientname."</b>, negotiates on your quote. <br><br> <hr> <p style='font-weight: bold;'> Negotiation Price: ".number_format($req->negotiation_price, 2)."</p> <br> <p style='font-weight: bold;'>Reason: ".$req->negotiation_reason." </p> <br><br> Kindly follow these steps to manage the Request: <br> a. Click on this link <a href='https://exbc.ca/login'>https://exbc.ca/login</a> to login to EXBC Account. <br> b. Go to Manage Rental Property on Free Business App and Select Service Provider <br><br> Thanks <br> PaySprint Management.";

            $this->file = "noImage.png";

            $this->sendEmail($this->email, "Maintenace Request");

            $resData = "Successfull";
            $resp = "success";

        }
        else{
            $resData = "Something went wrong, Try Again!";
            $resp = "error";
        }


        return redirect()->route('viewquotes')->with($resp, $resData);
    }


    public function ajaxrespondquote(Request $req, RentalQuote $rental){

        $getitem = $rental->where('maintenance_id', $req->maintenance_id)->get();

        if(count($getitem) > 0){

            $rental->where('maintenance_id', $req->maintenance_id)->update(['status' => 1, 'maintenance_price' => $req->negotiation_price]);

            // Send Mail
            $getUser = User::where('email', $getitem[0]->service_provider)->get();
            $getAdmin = User::where('email', $getitem[0]->property_owner)->get();

            $this->email = $getitem[0]->property_owner;
            $this->name = $getAdmin[0]->name;
            $this->clientname = $getUser[0]->name;
            $this->subject = $this->clientname.' accepts your negotiation price';

            $this->message = "Hi ".$this->name.", <br><br> <b>".$this->clientname."</b>, accepts your negotiation price. <br><br> <hr> <p style='font-weight: bold;'>Quotable Price: ".number_format($req->maintenance_price, 2)."</p> <br> <p style='font-weight: bold;'>Negotiation Price: ".number_format($req->negotiation_price, 2)."</p> <br><br> Kindly follow these steps to manage the Request: <br> a. Click on this link <a href='https://exbc.ca/login'>https://exbc.ca/login</a> to login to EXBC Account. <br> b. Go to Manage Rental Property on Free Business App and Select Property Owner/Manager <br><br> Thanks <br> PaySprint Management.";

            $this->file = "noImage.png";

            $this->sendEmail($this->email, "Maintenace Request");

            $resData = "Successfull";
            $resp = "success";

        }
        else{
            $resData = "Something went wrong, Try Again!";
            $resp = "error";
        }


        return redirect()->route('consultantMaintenance', ['id' => $req->maintenance_id])->with($resp, $resData);
    }



    public function returnJSON($data){
        return response()->json($data);
    }


    public function sendEmail($objDemoa, $purpose){
      $objDemo = new \stdClass();
      $objDemo->purpose = $purpose;

        if($purpose == "Maintenace Request"){

            $objDemo->name = $this->name;
            $objDemo->email = $this->email;
            $objDemo->subject = $this->subject;
            $objDemo->file = $this->file;
            $objDemo->message = $this->message;
        }
        elseif($purpose == $this->subject){

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

        }

      Mail::to($objDemoa)
            ->send(new sendEmail($objDemo));
   }

}
