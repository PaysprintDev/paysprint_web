<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use Rap2hpoutre\FastExcel\FastExcel;
//Session
use Session;

use DateTime;

use App\Mail\sendEmail;

use App\User as User;

use App\CreateEvent as CreateEvent;

use App\Admin as Admin;

use App\SuperAdmin as SuperAdmin;

use App\ImportExcel as ImportExcel;

use App\ClientInfo as ClientInfo;

use App\InvoicePayment as InvoicePayment;

use App\OrganizationPay as OrganizationPay;

use App\Epaywithdraw as Epaywithdraw;

use App\PaycaWithdraw as PaycaWithdraw;

use App\TransactionCost as TransactionCost;

use App\CollectionFee as CollectionFee;

use App\ServiceType as ServiceType;

use App\Statement as Statement;



class AdminController extends Controller
{

    public $to = "info@exbc.ca";
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


    



    public function index(Request $req){


        if($req->session()->has('username') == true){
            // dd(Session::all());

            if(session('role') == "Super"){
                $adminUser = Admin::orderBy('created_at', 'DESC')->get();
                $invoiceImport = ImportExcel::orderBy('created_at', 'DESC')->get();
                $payInvoice = DB::table('client_info')
            ->join('invoice_payment', 'client_info.user_id', '=', 'invoice_payment.client_id')
            ->orderBy('invoice_payment.created_at', 'DESC')
            ->get();

                $otherPays = OrganizationPay::orderBy('created_at', 'DESC')->get();


            }
            else{
                $adminUser = Admin::where('username', session('username'))->get();
                $invoiceImport = ImportExcel::where('uploaded_by', session('user_id'))->orderBy('created_at', 'DESC')->get();
                $payInvoice = InvoicePayment::where('client_id', session('user_id'))->orderBy('created_at', 'DESC')->get();
                $otherPays = OrganizationPay::where('coy_id', session('user_id'))->orderBy('created_at', 'DESC')->get();

                $this->recurBills(session('user_id'));
            }


            // dd($payInvoice);

            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();
            $transCost = $this->transactionCost();
            $allusers = $this->allUsers();

            return view('admin.index')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'transCost' => $transCost, 'allusers' => $allusers]);
        }
        else{
            return redirect()->route('AdminLogin');
        }

    }
    public function Otherpay(Request $req){

        if($req->session()->has('username') == true){
            // dd(Session::all());

            if(session('role') == "Super"){
                $adminUser = Admin::orderBy('created_at', 'DESC')->get();
                $invoiceImport = ImportExcel::orderBy('created_at', 'DESC')->get();
                $payInvoice = DB::table('client_info')
            ->join('invoice_payment', 'client_info.user_id', '=', 'invoice_payment.client_id')
            ->orderBy('invoice_payment.created_at', 'DESC')
            ->get();

                $otherPays = DB::table('organization_pay')
                ->join('users', 'organization_pay.user_id', '=', 'users.email')
                ->orderBy('organization_pay.created_at', 'DESC')
                ->get();
            }
            else{
                $adminUser = Admin::where('username', session('username'))->get();
                $invoiceImport = ImportExcel::where('uploaded_by', session('user_id'))->orderBy('created_at', 'DESC')->get();
                $payInvoice = InvoicePayment::where('client_id', session('user_id'))->orderBy('created_at', 'DESC')->get();
                $otherPays = DB::table('organization_pay')
                ->join('users', 'organization_pay.user_id', '=', 'users.email')
                ->where('organization_pay.coy_id', session('user_id'))
                ->orderBy('organization_pay.created_at', 'DESC')
                ->get();
            }

            // dd($payInvoice);

            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();
            $transCost = $this->transactionCost();
            return view('admin.otherpays')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'transCost' => $transCost]);
        }
        else{
            return redirect()->route('AdminLogin');
        }

    }    

    public function remittance(Request $req){

        if($req->session()->has('username') == true){
            // dd(Session::all());

            if(session('role') == "Super"){
                $adminUser = Admin::orderBy('created_at', 'DESC')->get();
                $invoiceImport = ImportExcel::orderBy('created_at', 'DESC')->get();
                $payInvoice = DB::table('client_info')
            ->join('invoice_payment', 'client_info.user_id', '=', 'invoice_payment.client_id')
            ->orderBy('invoice_payment.created_at', 'DESC')
            ->get();

                $otherPays = DB::table('organization_pay')
                ->join('users', 'organization_pay.user_id', '=', 'users.email')
                ->orderBy('organization_pay.created_at', 'DESC')
                ->get();
            }
            else{
                $adminUser = Admin::where('username', session('username'))->get();
                $invoiceImport = ImportExcel::where('uploaded_by', session('user_id'))->orderBy('created_at', 'DESC')->get();
                $payInvoice = InvoicePayment::where('client_id', session('user_id'))->orderBy('created_at', 'DESC')->get();
                $otherPays = DB::table('organization_pay')
                ->join('users', 'organization_pay.user_id', '=', 'users.email')
                ->where('organization_pay.coy_id', session('user_id'))
                ->orderBy('organization_pay.created_at', 'DESC')
                ->get();
            }

            // dd($payInvoice);

            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();

            $transCost = $this->transactionCost();

            $getwithdraw = $this->withdrawRemittance();
            return view('admin.remittance')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost]);
        }
        else{
            return redirect()->route('AdminLogin');
        }

    }    



    public function clientfeereport(Request $req){

        if($req->session()->has('username') == true){
            // dd(Session::all());

            if(session('role') == "Super"){
                $adminUser = Admin::orderBy('created_at', 'DESC')->get();
                $invoiceImport = ImportExcel::orderBy('created_at', 'DESC')->get();
                $payInvoice = DB::table('client_info')
            ->join('invoice_payment', 'client_info.user_id', '=', 'invoice_payment.client_id')
            ->orderBy('invoice_payment.created_at', 'DESC')
            ->get();

                $otherPays = DB::table('organization_pay')
                ->join('users', 'organization_pay.user_id', '=', 'users.email')
                ->orderBy('organization_pay.created_at', 'DESC')
                ->get();
            }
            else{
                $adminUser = Admin::where('username', session('username'))->get();
                $invoiceImport = ImportExcel::where('uploaded_by', session('user_id'))->orderBy('created_at', 'DESC')->get();
                $payInvoice = InvoicePayment::where('client_id', session('user_id'))->orderBy('created_at', 'DESC')->get();
                $otherPays = DB::table('organization_pay')
                ->join('users', 'organization_pay.user_id', '=', 'users.email')
                ->where('organization_pay.coy_id', session('user_id'))
                ->orderBy('organization_pay.created_at', 'DESC')
                ->get();
            }

            // dd($payInvoice);

            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();

            $transCost = $this->transactionCost();

            $getwithdraw = $this->withdrawRemittance();
            $collectfee = $this->allcollectionFee();

            return view('admin.clientfeereport')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee]);
        }
        else{
            return redirect()->route('AdminLogin');
        }

    } 



    public function collectionfee(Request $req){

        if($req->session()->has('username') == true){
            // dd(Session::all());

            if(session('role') == "Super"){
                $adminUser = Admin::orderBy('created_at', 'DESC')->get();
                $invoiceImport = ImportExcel::orderBy('created_at', 'DESC')->get();
                $payInvoice = DB::table('client_info')
            ->join('invoice_payment', 'client_info.user_id', '=', 'invoice_payment.client_id')
            ->orderBy('invoice_payment.created_at', 'DESC')
            ->get();

                $otherPays = DB::table('organization_pay')
                ->join('users', 'organization_pay.user_id', '=', 'users.email')
                ->orderBy('organization_pay.created_at', 'DESC')
                ->get();
            }
            else{
                $adminUser = Admin::where('username', session('username'))->get();
                $invoiceImport = ImportExcel::where('uploaded_by', session('user_id'))->orderBy('created_at', 'DESC')->get();
                $payInvoice = InvoicePayment::where('client_id', session('user_id'))->orderBy('created_at', 'DESC')->get();
                $otherPays = DB::table('organization_pay')
                ->join('users', 'organization_pay.user_id', '=', 'users.email')
                ->where('organization_pay.coy_id', session('user_id'))
                ->orderBy('organization_pay.created_at', 'DESC')
                ->get();
            }

            // dd($payInvoice);

            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();

            $transCost = $this->transactionCost();

            $getwithdraw = $this->withdrawRemittance();
            $collectfee = $this->allcollectionFee();

            return view('admin.collectionfee')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee]);
        }
        else{
            return redirect()->route('AdminLogin');
        }

    }     


    public function comissionreport(Request $req){

        if($req->session()->has('username') == true){
            // dd(Session::all());

            if(session('role') == "Super"){
                $adminUser = Admin::orderBy('created_at', 'DESC')->get();
                $invoiceImport = ImportExcel::orderBy('created_at', 'DESC')->get();
                $payInvoice = DB::table('client_info')
            ->join('invoice_payment', 'client_info.user_id', '=', 'invoice_payment.client_id')
            ->orderBy('invoice_payment.created_at', 'DESC')
            ->get();

                $otherPays = DB::table('organization_pay')
                ->join('users', 'organization_pay.user_id', '=', 'users.email')
                ->orderBy('organization_pay.created_at', 'DESC')
                ->get();
            }
            else{
                $adminUser = Admin::where('username', session('username'))->get();
                $invoiceImport = ImportExcel::where('uploaded_by', session('user_id'))->orderBy('created_at', 'DESC')->get();
                $payInvoice = InvoicePayment::where('client_id', session('user_id'))->orderBy('created_at', 'DESC')->get();
                $otherPays = DB::table('organization_pay')
                ->join('users', 'organization_pay.user_id', '=', 'users.email')
                ->where('organization_pay.coy_id', session('user_id'))
                ->orderBy('organization_pay.created_at', 'DESC')
                ->get();
            }

            // dd($payInvoice);

            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();

            $transCost = $this->transactionCost();

            $getwithdraw = $this->withdrawRemittance();
            $collectfee = $this->allcollectionFee();
            $getClient = $this->getallClient();

            return view('admin.comissionreport')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient]);
        }
        else{
            return redirect()->route('AdminLogin');
        }

    } 


    public function customer(Request $req){

        if($req->session()->has('username') == true){
            // dd(Session::all());

            if(session('role') == "Super"){
                $adminUser = Admin::orderBy('created_at', 'DESC')->get();
                $invoiceImport = ImportExcel::orderBy('created_at', 'DESC')->get();
                $payInvoice = DB::table('client_info')
            ->join('invoice_payment', 'client_info.user_id', '=', 'invoice_payment.client_id')
            ->orderBy('invoice_payment.created_at', 'DESC')
            ->get();

                $otherPays = DB::table('organization_pay')
                ->join('users', 'organization_pay.user_id', '=', 'users.email')
                ->orderBy('organization_pay.created_at', 'DESC')
                ->get();
            }
            else{
                $adminUser = Admin::where('username', session('username'))->get();
                $invoiceImport = ImportExcel::where('uploaded_by', session('user_id'))->orderBy('created_at', 'DESC')->get();
                $payInvoice = InvoicePayment::where('client_id', session('user_id'))->orderBy('created_at', 'DESC')->get();
                $otherPays = DB::table('organization_pay')
                ->join('users', 'organization_pay.user_id', '=', 'users.email')
                ->where('organization_pay.coy_id', session('user_id'))
                ->orderBy('organization_pay.created_at', 'DESC')
                ->get();
            }

            // dd($payInvoice);

            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();

            $transCost = $this->transactionCost();

            $getwithdraw = $this->withdrawRemittance();
            $collectfee = $this->allcollectionFee();
            $getClient = $this->getallClient();
            $getCustomer = $this->getCustomer($req->route('id'));

            return view('admin.customer')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '']);
        }
        else{
            return redirect()->route('AdminLogin');
        }

    }



    public function xpaytrans(Request $req){

        if($req->session()->has('username') == true){
            // dd(Session::all());

            if(session('role') == "Super"){
                $adminUser = Admin::orderBy('created_at', 'DESC')->get();
                $invoiceImport = ImportExcel::orderBy('created_at', 'DESC')->get();
                $payInvoice = DB::table('client_info')
            ->join('invoice_payment', 'client_info.user_id', '=', 'invoice_payment.client_id')
            ->orderBy('invoice_payment.created_at', 'DESC')
            ->get();

                $otherPays = DB::table('organization_pay')
                ->join('users', 'organization_pay.user_id', '=', 'users.email')
                ->orderBy('organization_pay.created_at', 'DESC')
                ->get();
            }
            else{
                $adminUser = Admin::where('username', session('username'))->get();
                $invoiceImport = ImportExcel::where('uploaded_by', session('user_id'))->orderBy('created_at', 'DESC')->get();
                $payInvoice = InvoicePayment::where('client_id', session('user_id'))->orderBy('created_at', 'DESC')->get();
                $otherPays = DB::table('organization_pay')
                ->join('users', 'organization_pay.user_id', '=', 'users.email')
                ->where('organization_pay.coy_id', session('user_id'))
                ->orderBy('organization_pay.created_at', 'DESC')
                ->get();
            }

            // dd($payInvoice);

            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();

            $transCost = $this->transactionCost();

            $getwithdraw = $this->withdrawRemittance();
            $collectfee = $this->allcollectionFee();
            $getClient = $this->getallClient();
            $getCustomer = $this->getCustomer($req->route('id'));


            // Get all xpaytransactions where state = 1;

            $getxPay = $this->getxpayTrans();


            return view('admin.xpaytrans')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay]);
        }
        else{
            return redirect()->route('AdminLogin');
        }

    }


    public function allPlatformUsers(Request $req){

        if($req->session()->has('username') == true){
            // dd(Session::all());

            if(session('role') == "Super"){
                $adminUser = Admin::orderBy('created_at', 'DESC')->get();
                $invoiceImport = ImportExcel::orderBy('created_at', 'DESC')->get();
                $payInvoice = DB::table('client_info')
            ->join('invoice_payment', 'client_info.user_id', '=', 'invoice_payment.client_id')
            ->orderBy('invoice_payment.created_at', 'DESC')
            ->get();

                $otherPays = DB::table('organization_pay')
                ->join('users', 'organization_pay.user_id', '=', 'users.email')
                ->orderBy('organization_pay.created_at', 'DESC')
                ->get();
            }
            else{
                $adminUser = Admin::where('username', session('username'))->get();
                $invoiceImport = ImportExcel::where('uploaded_by', session('user_id'))->orderBy('created_at', 'DESC')->get();
                $payInvoice = InvoicePayment::where('client_id', session('user_id'))->orderBy('created_at', 'DESC')->get();
                $otherPays = DB::table('organization_pay')
                ->join('users', 'organization_pay.user_id', '=', 'users.email')
                ->where('organization_pay.coy_id', session('user_id'))
                ->orderBy('organization_pay.created_at', 'DESC')
                ->get();
            }

            // dd($payInvoice);

            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();

            $transCost = $this->transactionCost();

            $getwithdraw = $this->withdrawRemittance();
            $collectfee = $this->allcollectionFee();
            $getClient = $this->getallClient();
            $getCustomer = $this->getCustomer($req->route('id'));


            // Get all xpaytransactions where state = 1;

            $getxPay = $this->getxpayTrans();
            $allusers = $this->allUsers();


            return view('admin.allusers')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers]);
        }
        else{
            return redirect()->route('AdminLogin');
        }

    }



    public function xreceivemoney(Request $req){

        if($req->session()->has('username') == true){

            if(session('role') == "Super"){
                $adminUser = Admin::orderBy('created_at', 'DESC')->get();
                $invoiceImport = ImportExcel::orderBy('created_at', 'DESC')->get();
                $payInvoice = DB::table('client_info')
            ->join('invoice_payment', 'client_info.user_id', '=', 'invoice_payment.client_id')
            ->orderBy('invoice_payment.created_at', 'DESC')
            ->get();

                $otherPays = DB::table('organization_pay')
                ->join('users', 'organization_pay.user_id', '=', 'users.email')
                ->orderBy('organization_pay.created_at', 'DESC')
                ->get();
            }
            else{
                $adminUser = Admin::where('username', session('username'))->get();
                $invoiceImport = ImportExcel::where('uploaded_by', session('user_id'))->orderBy('created_at', 'DESC')->get();
                $payInvoice = InvoicePayment::where('client_id', session('user_id'))->orderBy('created_at', 'DESC')->get();
                $otherPays = DB::table('organization_pay')
                ->join('users', 'organization_pay.user_id', '=', 'users.email')
                ->where('organization_pay.coy_id', session('user_id'))
                ->orderBy('organization_pay.created_at', 'DESC')
                ->get();
            }

            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();

            $transCost = $this->transactionCost();

            $getwithdraw = $this->withdrawRemittance();
            $collectfee = $this->allcollectionFee();
            $getClient = $this->getallClient();

            $getxPay = $this->getxReceive();

            // dd($getxPay);


            return view('admin.xreceivemoney')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'status' => '', 'message' => '', 'xpayRec' => $getxPay]);
        }
        else{
            return redirect()->route('AdminLogin');
        }

    }

    public function updateinvoice(Request $req){
        if(session('role') == "Super"){
                $adminUser = Admin::orderBy('created_at', 'DESC')->get();
                $invoiceImport = ImportExcel::orderBy('created_at', 'DESC')->get();
                $payInvoice = DB::table('client_info')
            ->join('invoice_payment', 'client_info.user_id', '=', 'invoice_payment.client_id')
            ->orderBy('invoice_payment.created_at', 'DESC')
            ->get();

                $otherPays = DB::table('organization_pay')
                ->join('users', 'organization_pay.user_id', '=', 'users.email')
                ->orderBy('organization_pay.created_at', 'DESC')
                ->get();
            }
            else{
                $adminUser = Admin::where('username', session('username'))->get();
                $invoiceImport = ImportExcel::where('uploaded_by', session('user_id'))->orderBy('created_at', 'DESC')->get();
                $payInvoice = InvoicePayment::where('client_id', session('user_id'))->orderBy('created_at', 'DESC')->get();
                $otherPays = DB::table('organization_pay')
                ->join('users', 'organization_pay.user_id', '=', 'users.email')
                ->where('organization_pay.coy_id', session('user_id'))
                ->orderBy('organization_pay.created_at', 'DESC')
                ->get();
            }

            // dd($payInvoice);

            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();

            $transCost = $this->transactionCost();

            $getwithdraw = $this->withdrawRemittance();
            $collectfee = $this->allcollectionFee();
            $getClient = $this->getallClient();

            // Update User
            $update = ImportExcel::where('id', $req->id)->update(['transaction_date' => $req->transaction_date, 'payee_ref_no' => $req->payee_ref_no, 'name' => $req->name, 'description' => $req->description, 'amount' => $req->amount, 'remaining_balance' => $req->remaining_balance, 'payment_due_date' => $req->payment_due_date, 'payee_email' => $req->payee_email, 'service' => $req->service, 'installpay' => $req->installpay, 'installlimit' => $req->installlimit, 'recurring' => $req->recurring, 'reminder' => $req->reminder, 'created_at' => date('Y-m-d H:i:s', strtotime($req->created_at))]);
            

            if($update ==  1){
                $message = 'Updated Successfully';
                $status = 'success';

                $getCustomer = $this->getCustomer($req->id);
            }
            else{

                $message = 'Something went wrong';
                $status = 'error';

                $getCustomer = $this->getCustomer($req->id);
            }

            return view('admin.customer')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => $status, 'message' => $message]);

        
    } 


    public function paycaremittance(Request $req){

        if($req->session()->has('username') == true){
            // dd(Session::all());

            if(session('role') == "Super"){
                $adminUser = Admin::orderBy('created_at', 'DESC')->get();
                $invoiceImport = ImportExcel::orderBy('created_at', 'DESC')->get();
                $payInvoice = DB::table('client_info')
            ->join('invoice_payment', 'client_info.user_id', '=', 'invoice_payment.client_id')
            ->orderBy('invoice_payment.created_at', 'DESC')
            ->get();

                $otherPays = DB::table('organization_pay')
                ->join('users', 'organization_pay.user_id', '=', 'users.email')
                ->orderBy('organization_pay.created_at', 'DESC')
                ->get();
            }
            else{
                $adminUser = Admin::where('username', session('username'))->get();
                $invoiceImport = ImportExcel::where('uploaded_by', session('user_id'))->orderBy('created_at', 'DESC')->get();
                $payInvoice = InvoicePayment::where('client_id', session('user_id'))->orderBy('created_at', 'DESC')->get();
                $otherPays = DB::table('organization_pay')
                ->join('users', 'organization_pay.user_id', '=', 'users.email')
                ->where('organization_pay.coy_id', session('user_id'))
                ->orderBy('organization_pay.created_at', 'DESC')
                ->get();
            }

            // dd($payInvoice);

            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();

            $getwithdraw = $this->withdrawpaycaRemittance();

            $transCost = $this->transactionCost();

            return view('admin.paycaremittance')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost]);
        }
        else{
            return redirect()->route('AdminLogin');
        }

    }

    public function remittanceepayreport(Request $req){

        if($req->session()->has('username') == true){
            // dd(Session::all());

            if(session('role') == "Super"){
                $adminUser = Admin::orderBy('created_at', 'DESC')->get();
                $invoiceImport = ImportExcel::orderBy('created_at', 'DESC')->get();
                $payInvoice = DB::table('client_info')
            ->join('invoice_payment', 'client_info.user_id', '=', 'invoice_payment.client_id')
            ->orderBy('invoice_payment.created_at', 'DESC')
            ->get();

                $otherPays = DB::table('organization_pay')
                ->join('users', 'organization_pay.user_id', '=', 'users.email')
                ->orderBy('organization_pay.created_at', 'DESC')
                ->get();
            }
            else{
                $adminUser = Admin::where('username', session('username'))->get();
                $invoiceImport = ImportExcel::where('uploaded_by', session('user_id'))->orderBy('created_at', 'DESC')->get();
                $payInvoice = InvoicePayment::where('client_id', session('user_id'))->orderBy('created_at', 'DESC')->get();
                $otherPays = DB::table('organization_pay')
                ->join('users', 'organization_pay.user_id', '=', 'users.email')
                ->where('organization_pay.coy_id', session('user_id'))
                ->orderBy('organization_pay.created_at', 'DESC')
                ->get();
            }

            // dd($payInvoice);

            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();

            $getreport = $this->remittancereportepayAdmin();

            $transCost = $this->transactionCost();

            return view('admin.remittanceepayreport')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getreport' => $getreport, 'transCost' => $transCost]);
        }
        else{
            return redirect()->route('AdminLogin');
        }

    }

    public function remittancepaycareport(Request $req){

        if($req->session()->has('username') == true){
            // dd(Session::all());

            if(session('role') == "Super"){
                $adminUser = Admin::orderBy('created_at', 'DESC')->get();
                $invoiceImport = ImportExcel::orderBy('created_at', 'DESC')->get();
                $payInvoice = DB::table('client_info')
            ->join('invoice_payment', 'client_info.user_id', '=', 'invoice_payment.client_id')
            ->orderBy('invoice_payment.created_at', 'DESC')
            ->get();

                $otherPays = DB::table('organization_pay')
                ->join('users', 'organization_pay.user_id', '=', 'users.email')
                ->orderBy('organization_pay.created_at', 'DESC')
                ->get();
            }
            else{
                $adminUser = Admin::where('username', session('username'))->get();
                $invoiceImport = ImportExcel::where('uploaded_by', session('user_id'))->orderBy('created_at', 'DESC')->get();
                $payInvoice = InvoicePayment::where('client_id', session('user_id'))->orderBy('created_at', 'DESC')->get();
                $otherPays = DB::table('organization_pay')
                ->join('users', 'organization_pay.user_id', '=', 'users.email')
                ->where('organization_pay.coy_id', session('user_id'))
                ->orderBy('organization_pay.created_at', 'DESC')
                ->get();
            }

            // dd($payInvoice);

            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();

            $getreport = $this->remittancereportpaycaAdmin();

            $transCost = $this->transactionCost();

            return view('admin.remittancepaycareport')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getreport' => $getreport, 'transCost' => $transCost]);
        }
        else{
            return redirect()->route('AdminLogin');
        }

    }    

    public function getStatement(Request $req){

        if($req->session()->has('username') == true){
            // dd(Session::all());

            if(session('role') == "Super"){
                $adminUser = Admin::orderBy('created_at', 'DESC')->get();
                $invoiceImport = ImportExcel::orderBy('created_at', 'DESC')->get();
                $payInvoice = DB::table('client_info')
            ->join('invoice_payment', 'client_info.user_id', '=', 'invoice_payment.client_id')
            ->orderBy('invoice_payment.created_at', 'DESC')
            ->get();

                $otherPays = DB::table('organization_pay')
                ->join('users', 'organization_pay.user_id', '=', 'users.email')
                ->orderBy('organization_pay.created_at', 'DESC')
                ->get();
            }
            else{
                $adminUser = Admin::where('username', session('username'))->get();
                $invoiceImport = ImportExcel::where('uploaded_by', session('user_id'))->orderBy('created_at', 'DESC')->get();
                $payInvoice = InvoicePayment::where('client_id', session('user_id'))->orderBy('created_at', 'DESC')->get();

                $otherPays = DB::table('invoice_payment')
                     ->select(DB::raw('invoice_payment.transactionid, invoice_payment.name, invoice_payment.email, import_excel.amount as invoice_amount, invoice_payment.invoice_no, invoice_payment.service, invoice_payment.created_at as transaction_date, import_excel.description as description, invoice_payment.remaining_balance as runningbalance, invoice_payment.amount as amount_paid, import_excel.status, invoice_payment.mystatus'))->distinct()
                     ->join('import_excel', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')
                    ->where('import_excel.uploaded_by', session('user_id'))
                    ->orderBy('invoice_payment.created_at', 'DESC')->get();
            }

            // dd($otherPays);

            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();

            $transCost = $this->transactionCost();

            return view('admin.statement')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'transCost' => $transCost]);
        }
        else{
            return redirect()->route('AdminLogin');
        }

    }    


    public function payreport(Request $req){
    
        if($req->session()->has('username') == true){
            // dd(Session::all());

            if(session('role') == "Super"){
                $adminUser = Admin::orderBy('created_at', 'DESC')->get();
                $invoiceImport = ImportExcel::orderBy('created_at', 'DESC')->get();
                $payInvoice = DB::table('client_info')
            ->join('invoice_payment', 'client_info.user_id', '=', 'invoice_payment.client_id')
            ->orderBy('invoice_payment.created_at', 'DESC')
            ->get();

                $otherPays = DB::table('organization_pay')
                ->join('users', 'organization_pay.user_id', '=', 'users.email')
                ->orderBy('organization_pay.created_at', 'DESC')
                ->get();
            }
            else{
                $adminUser = Admin::where('username', session('username'))->get();
                $invoiceImport = ImportExcel::where('uploaded_by', session('user_id'))->orderBy('created_at', 'DESC')->get();
                $payInvoice = InvoicePayment::where('client_id', session('user_id'))->orderBy('created_at', 'DESC')->get();

                $report = DB::table('invoice_payment')
                     ->select(DB::raw('invoice_payment.transactionid, invoice_payment.name, invoice_payment.email, import_excel.amount as invoice_amount, invoice_payment.invoice_no, invoice_payment.service, invoice_payment.created_at as transaction_date, import_excel.description as description, invoice_payment.remaining_balance as runningbalance, invoice_payment.opening_balance, invoice_payment.amount as amount_paid, import_excel.status, import_excel.payment_due_date, invoice_payment.mystatus, import_excel.payee_ref_no, import_excel.transaction_ref'))->distinct()
                     ->join('import_excel', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')
                    ->where('import_excel.uploaded_by', session('user_id'))
                    ->orderBy('invoice_payment.created_at', 'DESC')->get();
            }

            // dd($report);

            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();
            
            $transCost = $this->transactionCost();
            
            return view('admin.report')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'report' => $report, 'transCost' => $transCost]);
        }
        else{
            return redirect()->route('AdminLogin');
        }

    }    

    public function epayreport(Request $req){


        if($req->session()->has('username') == true){
            // dd(Session::all());

            if(session('role') == "Super"){
                $adminUser = Admin::orderBy('created_at', 'DESC')->get();
                $invoiceImport = ImportExcel::orderBy('created_at', 'DESC')->get();
                $payInvoice = DB::table('client_info')
            ->join('invoice_payment', 'client_info.user_id', '=', 'invoice_payment.client_id')
            ->orderBy('invoice_payment.created_at', 'DESC')
            ->get();

                $otherPays = DB::table('organization_pay')
                ->join('users', 'organization_pay.user_id', '=', 'users.email')
                ->orderBy('organization_pay.created_at', 'DESC')
                ->get();
            }
            else{
                $adminUser = Admin::where('username', session('username'))->get();
                $invoiceImport = ImportExcel::where('uploaded_by', session('user_id'))->orderBy('created_at', 'DESC')->get();
                $payInvoice = InvoicePayment::where('client_id', session('user_id'))->orderBy('created_at', 'DESC')->get();

                $report = OrganizationPay::where('coy_id', session('user_id'))->get();
            }

            // dd($report);

            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();
            
            $transCost = $this->transactionCost();
            
            return view('admin.epayreport')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'report' => $report, 'transCost' => $transCost]);
        }
        else{
            return redirect()->route('AdminLogin');
        }

    }

    public function payremittancereport(Request $req){


        if($req->session()->has('username') == true){
            // dd(Session::all());

            if(session('role') == "Super"){
                $adminUser = Admin::orderBy('created_at', 'DESC')->get();
                $invoiceImport = ImportExcel::orderBy('created_at', 'DESC')->get();
                $payInvoice = DB::table('client_info')
            ->join('invoice_payment', 'client_info.user_id', '=', 'invoice_payment.client_id')
            ->orderBy('invoice_payment.created_at', 'DESC')
            ->get();

                $otherPays = DB::table('organization_pay')
                ->join('users', 'organization_pay.user_id', '=', 'users.email')
                ->orderBy('organization_pay.created_at', 'DESC')
                ->get();
            }
            else{
                $adminUser = Admin::where('username', session('username'))->get();
                $invoiceImport = ImportExcel::where('uploaded_by', session('user_id'))->orderBy('created_at', 'DESC')->get();
                $payInvoice = InvoicePayment::where('client_id', session('user_id'))->orderBy('created_at', 'DESC')->get();

            }

            // dd($report);

            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();
            
            $report = $this->paycareportRemittance(session('email'));

            $transCost = $this->transactionCost();
            
            return view('admin.payremittancereport')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'report' => $report, 'transCost' => $transCost]);
        }
        else{
            return redirect()->route('AdminLogin');
        }

    }

    public function epayremittancereport(Request $req){


        if($req->session()->has('username') == true){
            // dd(Session::all());

            if(session('role') == "Super"){
                $adminUser = Admin::orderBy('created_at', 'DESC')->get();
                $invoiceImport = ImportExcel::orderBy('created_at', 'DESC')->get();
                $payInvoice = DB::table('client_info')
            ->join('invoice_payment', 'client_info.user_id', '=', 'invoice_payment.client_id')
            ->orderBy('invoice_payment.created_at', 'DESC')
            ->get();

                $otherPays = DB::table('organization_pay')
                ->join('users', 'organization_pay.user_id', '=', 'users.email')
                ->orderBy('organization_pay.created_at', 'DESC')
                ->get();
            }
            else{
                $adminUser = Admin::where('username', session('username'))->get();
                $invoiceImport = ImportExcel::where('uploaded_by', session('user_id'))->orderBy('created_at', 'DESC')->get();
                $payInvoice = InvoicePayment::where('client_id', session('user_id'))->orderBy('created_at', 'DESC')->get();
            }

            // dd($report);

            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();

            $report = $this->epayreportRemittance(session('email'));

            $transCost = $this->transactionCost();
            
            
            return view('admin.epayremittancereport')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'report' => $report, 'transCost' => $transCost]);
        }
        else{
            return redirect()->route('AdminLogin');
        }

    }



    public function adminlogin(Request $req){

        return view('admin.adminlogin');
    }
    public function adminregister(){
        return view('admin.adminregister');
    }


        public function ajaxcreateEvent(Request $req){
        // Create events

        if($req->purpose == "ticket"){

            if($req->file('event_file'))
            {
                //Get filename with extension
                $filenameWithExt = $req->file('event_file')->getClientOriginalName();
                // Get just filename
                $filename = pathinfo($filenameWithExt , PATHINFO_FILENAME);
                // Get just extension
                $extension = $req->file('event_file')->getClientOriginalExtension();
                // Filename to store
                $fileNameToStore = rand().'_'.time().'.'.$extension;
                //Upload Image
                // $path = $req->file('event_file')->storeAs('public/eventticket', $fileNameToStore);

                // $path = $req->file('event_file')->move(public_path('/eventticket/'), $fileNameToStore);

                $path = $req->file('event_file')->move(public_path('../../eventticket/'), $fileNameToStore);

            }
            else
            {
                $fileNameToStore = 'noImage.png';
            }

                // Insert Rec
                $insRec = CreateEvent::insert(['user_id' => $req->user_id,'event_id' => $req->ticket_id, 'event_title' => $req->event_title, 'event_location' => $req->event_location, 'event_start_date' => $req->datepicker_start, 'event_start_time' => $req->ticket_timeStarts, 'event_end_date' => $req->datepicker_end, 'event_end_time' => $req->ticket_timeEnds, 'upload_ticket' => $fileNameToStore, 'event_description' => $req->event_description, 'ticket_name' => $req->ticket_free_name, 'quantity_available' => $req->ticket_free_qty, 'price' => $req->ticket_free_price, 'ticket_paid_name' => $req->ticket_paid_name, 'quantity_paid_available' => $req->ticket_paid_qty, 'paid_price' => $req->ticket_paid_price, 'ticket_donate_name' => $req->ticket_donate_name, 'quantity_donate_available' => $req->ticket_donate_qty, 'donate_price' => $req->ticket_donate_price]);

                if($insRec == true){
                    $resData = ['res' => 'Event Saved', 'message' => 'success', 'action' => 'ticket', 'link' => 'Admin'];
                }
                else{
                    $resData = ['res' => 'Something went wrong!', 'message' => 'error', 'action' => 'ticket'];
                }
        }
        elseif ($req->purpose == "uploadExcel") {
            // Do some Uploads here
            if($req->file('excel_file'))
            {

                //Get filename with extension
                $filenameWithExt = $req->file('excel_file')->getClientOriginalName();
                // Get just filename
                $filename = pathinfo($filenameWithExt , PATHINFO_FILENAME);
                // Get just extension
                $extension = $req->file('excel_file')->getClientOriginalExtension();


                if($extension == "xlsx" || $extension == "xls"){

                    $path = $req->file('excel_file')->getRealPath();

                    // $data = Excel::import($path)->get();
                    $data = (new FastExcel)->import($path);

                    // Get Client Name & Address


                    $getClient = ClientInfo::where('user_id', $req->user_id)->get();

                    if(count($getClient) > 0){
                        $clientname = $getClient[0]->business_name;
                        $clientaddress = $getClient[0]->address;
                        $client_realname = $getClient[0]->firstname.' '.$getClient[0]->lastname;
                        $city = $getClient[0]->city;
                        $state = $getClient[0]->state;
                        $zipcode = $getClient[0]->zip_code;
                    }
                    else{
                        $clientname = "PaySprint (EXBC)";
                        $client_realname = "PaySprint (EXBC)";
                        $clientaddress = "EXBC, by Express Ca Corp, 10 George St. North, Brampton. ON. L6X1R2. Canada";
                        $city = "Brampton";
                        $state = "Ontario";
                        $zipcode = "L6X1R2";
                    }



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

                                
                                

                                if($key['Customer Email'] == "" || $key['Customer Email'] == null){

                                    $resData = ['res' => 'This excel sheet may contain some empty fields. Kindly download and use the test sample to make a copy of your file.', 'message' => 'response'];
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
                                    'uploaded_by' => $req->user_id
                                );

                                    // Insert Statement
                                    $activity = "Invoice on ".$req->service;
                                    $credit = $key['Amount'];
                                    $debit = 0;
                                    $balance = 0;
                                    $reference_code = $invoice_no;
                                    $status = "Delivered";
                                    $action = "Invoice";
                                    $trans_date = date('Y-m-d', strtotime($UNIX_DATE1));
                                    $regards = $req->user_id;
                                    
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
                                $this->amount = $key['Amount'];
                                $this->address = $clientaddress;
                                $this->service = $req->service;
                                $this->clientname = $clientname;
                                $this->client_realname = $client_realname;
                                $this->city = $city;
                                $this->state = $state;
                                $this->zipcode = $zipcode;

                                $this->subject = $this->clientname.' sends you an invoice on PaySprint';

                                $this->sendEmail($this->to, $this->subject);

                                }

                        }

                        if(!empty($insert_data)){

                            DB::table('import_excel')->insert($insert_data);
                        }
                    }

                    // Filename to store
                $fileNameToStore = rand().'_'.time().'.'.$extension;

                // $req->file('excel_file')->move(public_path('/excelUpload/'), $fileNameToStore);

                $req->file('excel_file')->move(public_path('../../excelUpload/'), $fileNameToStore);

                $resData = ['res' => 'Upload Successfull', 'message' => 'success', 'action' => 'uploadExcel'];
                }
                else{
                    $resData = ['res' => 'Invalid worksheet', 'message' => 'error'];
                }
            }
            else{
                $resData = ['res' => 'Kindly upload an excel document', 'message' => 'error'];
            }
        }
        elseif($req->purpose == "setRecur"){
            // Get Data
            $getData = ImportExcel::where('uploaded_by', $req->user_id)->get();

            if(count($getData) > 0){
                // Update
                $updateData = ImportExcel::where('uploaded_by', $req->user_id)->update(['recurring' => $req->recurring, 'reminder' => $req->reminder]);

                if($updateData){
                    $resData = ['res' => 'Upload Successfull', 'message' => 'success', 'action' => 'setRecur'];
                }
                else{
                    $resData = ['res' => 'Something went wrong', 'message' => 'error'];
                }
            }
            else{
                $resData = ['res' => 'Data was lost!', 'message' => 'error'];
            }
        }
        elseif($req->purpose == "single1_upload"){
            // Get Data
            $checkifData = ImportExcel::where('invoice_no', $req->invoice_no)->get();

            if(count($checkifData) > 0){
                // Already exist
                 $resData = ['res' => 'Invoice already created for this user', 'message' => 'info'];
            }
            else{

                if($req->service == "others"){
                    $service = $req->service_specify;

                    // Insert
                    $this->serviceType($req->service_specify);
                }
                else{
                    $service = $req->service;
                }

                // Insert data
                $insData = ImportExcel::insert(['name' => $req->firstname.' '.$req->lastname, 'payee_email' => $req->payee_email, 'service' => $service, 'invoice_no' => $req->invoice_no, 'uploaded_by' => $req->user_id, 'installpay' => $req->installpay, 'installlimit' => $req->installlimit]);

                if($insData ==  true){



                    $resData = ['res' => 'Success', 'message' => 'success', 'action' => 'single1_upload', 'email' => $req->payee_email, 'invoice_no' => $req->invoice_no];
                }
                else{
                    $resData = ['res' => 'Something went wrong', 'message' => 'error'];
                }
            }
        }
        elseif($req->purpose == "single2_upload"){
            // Get Data
            $getData = ImportExcel::where('invoice_no', $req->invoice_no)->get();



            if(count($getData) > 0){
                // Update
                $updateData = ImportExcel::where('invoice_no', $req->invoice_no)->update(['payee_ref_no' => $req->payee_ref_no, 'transaction_ref' => $req->transaction_ref, 'transaction_date' => $req->transaction_date, 'description' => $req->description]);

                // dd($updateData);

                if($updateData){
                    $resData = ['res' => 'Success', 'message' => 'success', 'action' => 'single2_upload', 'email' => $req->payee_email, 'invoice_no' => $req->invoice_no];
                }
                else{
                    $resData = ['res' => 'Something went wrong', 'message' => 'error'];
                }
            }
            else{
                $resData = ['res' => 'Data not found!', 'message' => 'error'];
            }
        }
        elseif($req->purpose == "single3_upload"){
            // Get Data
            $getData = ImportExcel::where('invoice_no', $req->invoice_no)->get();

            if(count($getData) > 0){
                // Update
                $updateData = ImportExcel::where('invoice_no', $req->invoice_no)->update(['amount' => $req->amount, 'payment_due_date' => $req->payment_due_date, 'recurring' => $req->recurring, 'reminder' => $req->reminder, 'customer_id' => session('user_id')]);
                
                // dd($updateData);

                if($updateData){

                    $getClient = ClientInfo::where('user_id', session('user_id'))->get();

                    if(count($getClient) > 0){
                        $clientname = $getClient[0]->business_name;
                        $clientaddress = $getClient[0]->address;
                        $client_realname = $getClient[0]->firstname.' '.$getClient[0]->lastname;
                        $city = $getClient[0]->city;
                        $state = $getClient[0]->state;
                        $zipcode = $getClient[0]->zip_code;
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
                    $activity = "Invoice on ".$getData[0]->service;
                    $credit = $req->amount;
                    $debit = 0;
                    $balance = 0;
                    $reference_code = $req->invoice_no;
                    $status = "Delivered";
                    $action = "Invoice";

                    $trans_date = date('Y-m-d', strtotime($getData[0]->transaction_date));

                    $regards = session('user_id');

                    $this->insStatement($req->payee_email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 0);


                    $this->to = $req->payee_email;
                    // $this->to = "adenugaadebambo41@gmail.com";
                    $this->name = $getData[0]->name;
                    $this->transaction_date = $getData[0]->transaction_date;
                    $this->invoice_no = $getData[0]->invoice_no;
                    $this->payee_ref_no = $getData[0]->payee_ref_no;
                    $this->transaction_ref = $getData[0]->transaction_ref;
                    $this->description = $getData[0]->description;
                    $this->payment_due_date = $getData[0]->payment_due_date;
                    $this->amount = $req->amount;
                    $this->address = $clientaddress;
                    $this->service = $getData[0]->service;
                    $this->clientname = $clientname;
                    $this->client_realname = $client_realname;
                    $this->city = $city;
                    $this->state = $state;
                    $this->zipcode = $zipcode;
                    $this->customer_id = session('user_id');

                    $this->subject = $this->clientname.' sends you an invoice on PaySprint';

                    $this->sendEmail($this->to, $this->subject);


                    $resData = ['res' => 'Successfully saved', 'message' => 'success', 'action' => 'single3_upload'];
                }
                else{
                    $resData = ['res' => 'Something went wrong', 'message' => 'error'];
                }
            }
            else{
                $resData = ['res' => 'Data not found!', 'message' => 'error'];
            }
        }

        return $this->returnJSON($resData, 200);
    }


    // Client Login
    public function ajaxadminlogin(Request $req){
        // Check user exist
        $adminCheck = Admin::where('username', $req->username)->get();

        if(count($adminCheck) > 0){
            // COnfirm Password
            if(Hash::check($req->password, $adminCheck[0]['password'])){
                // Set session
                $req->session()->put(['user_id' => $adminCheck[0]['user_id'], 'firstname' => $adminCheck[0]['firstname'], 'lastname' => $adminCheck[0]['lastname'], 'username' => $adminCheck[0]['username'], 'role' => 'Client', 'email' => $adminCheck[0]['email']]);

                $resData = ['res' => 'Logging in...', 'message' => 'success', 'link' => 'Admin'];
            }
            else{
                 $resData = ['res' => 'Incorrect Password!', 'message' => 'info'];
            }
        }
        else{
            // Check if Super Admin
            $superCheck = SuperAdmin::where('username', $req->username)->get();

            if(count($superCheck) > 0){
            // COnfirm Password
            if(Hash::check($req->password, $superCheck[0]['password'])){
                // Set session
                $req->session()->put(['user_id' => $superCheck[0]['user_id'], 'firstname' => $superCheck[0]['firstname'], 'lastname' => $superCheck[0]['lastname'], 'username' => $superCheck[0]['username'], 'role' => 'Super', 'email' => $superCheck[0]['email']]);

                $resData = ['res' => 'Logging in...', 'message' => 'success', 'link' => 'Admin'];
            }
            else{
                 $resData = ['res' => 'Incorrect Password!', 'message' => 'info'];
            }
        }
        else{
            $resData = ['res' => 'Unrecognized authentication!', 'message' => 'info'];
        }

        }

        return $this->returnJSON($resData, 200);
    }

    // Client Login
    public function ajaxAdminspeciallogin(Request $req){
        // Check user exist
        $adminCheck = Admin::where('username', $req->username)->get();

        if(count($adminCheck) > 0){
                // Set session
                $req->session()->put(['user_id' => $adminCheck[0]['user_id'], 'firstname' => $adminCheck[0]['firstname'], 'lastname' => $adminCheck[0]['lastname'], 'username' => $adminCheck[0]['username'], 'role' => 'Client', 'email' => $adminCheck[0]['email']]);

                $resData = ['res' => 'Logging in...', 'message' => 'success', 'link' => 'Admin'];

        }
        else{
            $resData = ['res' => 'Unrecognized login!', 'message' => 'info'];
        }

        return $this->returnJSON($resData, 200);
    }

    // Client Register
    public function ajaxadminregister(Request $req){
        // Check client record
        $checkClient = ClientInfo::where('email', $req->email)->get();
        if(count($checkClient) > 0){
            // Check Admin table
            $checkAdmin = Admin::where('username', $req->username)->get();
            if(count($checkAdmin) > 0){
                $resData = ['res' => 'Username already chosen', 'message' => 'error'];
            }
            // User already exist
            $resData = ['res' => 'User with this email already exist', 'message' => 'error'];
        }
        else{
            // Insert
            $insClient = ClientInfo::insert(['user_id' => $req->user_id, 'business_name' => $req->business_name, 'address' => $req->address, 'corporate_type' => $req->corporate_type, 'firstname' => $req->firstname, 'lastname' => $req->lastname, 'email' => $req->email, 'country' => $req->country, 'state' => $req->state, 'city' => $req->city, 'zip_code' => $req->zip_code]);

            $insAdmin = Admin::insert(['user_id' => $req->user_id, 'firstname' => $req->firstname, 'lastname' => $req->lastname, 'username' => $req->username, 'password' => Hash::make($req->password), 'role' => 'Client', 'email' => $req->email]);

            if($insAdmin == 1){
                // Set session
            $req->session()->put(['user_id' => $req->user_id, 'firstname' => $req->firstname, 'lastname' => $req->lastname, 'username' => $req->username, 'role' => 'Client', 'email' => $req->email]);

            $resData = ['res' => 'Logging in...', 'message' => 'success', 'link' => 'Admin'];
            }
            else{
                $resData = ['res' => 'Something went wrong', 'message' => 'error'];
            }

            }

        return $this->returnJSON($resData, 200);
    }



    public function ajaxgetmyStatement(Request $req){
        // Get Where UserID is session

        $from = $req->start_date;
        $nextDay = $req->end_date;

        $payment = DB::table('invoice_payment')
                     ->select(DB::raw('invoice_payment.transactionid, invoice_payment.name, invoice_payment.email, import_excel.amount as invoice_amount, invoice_payment.invoice_no, invoice_payment.service, invoice_payment.created_at as transaction_date, import_excel.description as description, invoice_payment.remaining_balance as runningbalance, invoice_payment.amount as amount_paid, import_excel.status, invoice_payment.mystatus'))->distinct()
                     ->join('import_excel', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')
                    ->where('import_excel.uploaded_by', session('user_id'))
                    ->where('invoice_payment.service', $req->service)
                    ->whereBetween('invoice_payment.created_at', [$from, $nextDay])
                    ->orderBy('invoice_payment.created_at', 'DESC')->get();


        if(count($payment) > 0){
            $myStatement = $payment;
            $status = "payment";
           }
           else{


                $getInvoice = DB::table('statement')
                     ->select(DB::raw('statement.reference_code as transactionid, statement.trans_date as transaction_date, statement.activity as description, statement.credit as invoice_amount, statement.debit as amount_paid'))->distinct()
                    ->where('statement.regards', session('user_id'))
                    ->whereBetween('statement.trans_date', [$from, $nextDay])
                    ->orderBy('statement.created_at', 'DESC')->get();

                

                if(count($getInvoice) > 0){
                    $myStatement = $getInvoice;
                    $status = "invoice";
                }
                else{
                    $myStatement = array('0' => ['error' => 'No statement record', 'info' => 'no_exist']);
                    $status = "none";
                }
           }

        if(count($myStatement) > 0){
            // Check For If Invoice belongs to USer
            $resData = ['res' => 'Fetching Data', 'message' => 'success', 'data' => json_encode($myStatement), 'title' => 'Good', 'status' => $status];
        }
        else{
            $resData = ['res' => 'You do not have record for this service', 'message' => 'error', 'title' => 'Oops!', 'info' => 'no_exist'];
        }



        return $this->returnJSON($resData, 200);
    }
    


    public function ajaxgetmyreportStatement(Request $req){
        // Get Where UserID is session

        $from = $req->start_date;
        $nextDay = $req->end_date;

        $payment = DB::table('invoice_payment')
                     ->select(DB::raw('invoice_payment.transactionid, invoice_payment.name, invoice_payment.email, import_excel.amount as invoice_amount, invoice_payment.invoice_no, invoice_payment.service, invoice_payment.created_at as transaction_date, import_excel.description as description, invoice_payment.remaining_balance as runningbalance, invoice_payment.amount as amount_paid, import_excel.status, invoice_payment.mystatus, users.address, import_excel.payee_ref_no as transaction_ref, import_excel.payment_due_date as due_date, invoice_payment.opening_balance'))->distinct()
                     ->join('import_excel', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')
                     ->join('users', 'invoice_payment.email', '=', 'users.email')
                    ->where('import_excel.uploaded_by', session('user_id'))
                    ->where('invoice_payment.service', $req->service)
                    ->whereBetween('invoice_payment.created_at', [$from, $nextDay])
                    ->orderBy('invoice_payment.created_at', 'DESC')->get();

        if(count($payment) > 0){
            $myStatement = $payment;
            $status = "payment";
           }
           else{

                $getInvoice = DB::table('import_excel')
                     ->select(DB::raw('import_excel.transaction_ref, import_excel.invoice_no, users.name, users.address, import_excel.payment_due_date as due_date, import_excel.amount as invoice_amount, import_excel.description'))->distinct()
                     ->join('users', 'import_excel.payee_email', '=', 'users.email')
                    ->where('import_excel.uploaded_by', session('user_id'))
                    ->where('import_excel.service', $req->service)
                    ->whereBetween('import_excel.created_at', [$from, $nextDay])
                    ->orderBy('import_excel.created_at', 'DESC')->get();

                    

                if(count($getInvoice) > 0){
                    $myStatement = $getInvoice;
                    $status = "invoice";
                }
                else{
                    $myStatement = array('0' => ['error' => 'No statement record', 'info' => 'no_exist']);
                    $status = "none";
                }
           }

        if(count($myStatement) > 0){
            // Check For If Invoice belongs to USer
            $resData = ['res' => 'Fetching Data', 'message' => 'success', 'data' => json_encode($myStatement), 'title' => 'Good', 'status' => $status];
        }
        else{
            $resData = ['res' => 'You do not have record for this service', 'message' => 'error', 'title' => 'Oops!', 'info' => 'no_exist'];
        }



        return $this->returnJSON($resData, 200);
    }


    public function ajaxWithdrawCash(Request $req){

        // Update payment info
        $getUser = ClientInfo::where('user_id', $req->user_id)->get();

        if(count($getUser) > 0){
            $updt = ClientInfo::where('user_id', $req->user_id)->update(['user_id' => $req->user_id, 'card_balance' => $req->amount]);
            $this->url = "https://exbc.ca/api/cardUpdate";
            $this->curl_data = array(
                    'platform' => 'payca',
                    'ref_code' => $req->user_id,
                    'email' => session('email'),
                    'action' => 'update_balance',
                    'card_balance' => $req->amount
                );

            $resp = $this->doCurl();

            if($updt == 1){
                // Send Mail
                // update invoice pay
                InvoicePayment::where('client_id', $req->user_id)->update(['amount' => 0]);

                $this->name = session('firstname').' '.session('lastname');
                $this->to = session('email');
                

                $this->info = "Account is credited";
                $this->message = 'We are glad to notify you that your withdrawal request of <b>$'.$req->amount.'</b> has been received. Your money is transferred to your EXBC account where you can withdraw to you EXBC Card. Thanks';

                $this->sendEmail($this->to, "Account is credited");



                $resData = ['res' => 'Cash withdrawal of $'.$req->amount.' is Successfull', 'message' => 'success', 'title' => 'Good'];
            }
            else{
                $resData = ['res' => 'Something went wrong', 'message' => 'error', 'title' => 'Oops!'];
            }
        }
        else{
            $resData = ['res' => 'Record not found', 'message' => 'error', 'title' => 'Oops!'];
        }


        

        return $this->returnJSON($resData, 200);
    }


    public function ajaxepaywithdraw(Request $req){
        // Insert Record
        // Update collection
        

        if($req->amount != 0){
            $ins = Epaywithdraw::insert(['withdraw_id' => uniqid(), 'client_id' => $req->user_id, 'client_name' => session('firstname').' '.session('lastname'), 'card_method' => $req->card_method, 'client_email' => session('email'), 'amount_to_withdraw' => $req->amount]);


        if($ins == true){
            // Send Mail on the transaction
                OrganizationPay::where('coy_id', $req->user_id)->update(['withdraws' => 0]);

                $this->name = session('firstname').' '.session('lastname');
                $this->email = session('email');
                $this->admin = "Admin";
                $this->info = "Fund remittance";
                $this->info2 = "Cash withdrawal request";

                $this->infomessage = 'A client of PaySprint has requested for a withdrawal of <b>$'.$req->amount.'</b> using the '.$req->card_method.' method. <br><br> Details is as stated below: <hr><br> Organization name: '.$this->name.' <br> Amount to Withdraw: '.$req->amount.' <br> Payment Method: '.$req->card_method.' <br><hr>.Thanks';



                $this->message = 'You request for funds withdrawal is being processed. You will receive fund through the payment option selected within the next 24 hours';
                
                // dd($this->to);

                $this->sendEmail($this->email, "Fund remittance");
                $this->sendEmail($this->to, "Cash withdrawal request");



            $resData = ['res' => 'Withdrawal request of $'.$req->amount.' is successfull', 'message' => 'success', 'title' => 'Good'];
        }
        else{
            $resData = ['res' => 'Something went wrong', 'message' => 'error', 'title' => 'Oops!'];
        }
        }
        else{
            $resData = ['res' => 'Insufficient amount to withdraw. You have $'.$req->amount.' available.', 'message' => 'error', 'title' => 'Oops!'];
        }


        return $this->returnJSON($resData, 200);
        
    }


    public function ajaxremitdetailsCash(Request $req){

        if($req->val == "epayca"){

            // Update Information
            // $getClient = OrganizationPay::where('coy_id', $req->user_id)->get();
            $getClient = DB::table('organization_pay')
                     ->select(DB::raw('organization_pay.transactionid, organization_pay.coy_id as client_id, organization_pay.user_id as payee_email, organization_pay.amount as amount_paid, organization_pay.purpose as service, organization_pay.created_at as transaction_date, users.name as name, organization_pay.amount as amount_paid'))->distinct()
                     ->join('users', 'organization_pay.user_id', '=', 'users.email')
                        ->where('organization_pay.coy_id', $req->user_id)
                    ->orderBy('organization_pay.created_at', 'DESC')
                        ->get();


            // Get Client Details
            $client = ClientInfo::where('user_id', $req->user_id)->get();

            $transaction_cost = TransactionCost::all();

            if(count($transaction_cost) > 0){
                $fixed = $transaction_cost[0]->fixed;
                $variable = $transaction_cost[0]->variable;
            }
            else{
                $fixed = 0;
                $variable = 0;
            }

            // dd($req->user_id);
            if(count($getClient) > 0){
                
                $resData = ['res' => 'Retrieval...', 'message' => 'success', 'title' => 'Great', 'data' => json_encode($getClient), 'action' => 'epayca', 'client' => json_encode($client), 'fixed' => $fixed, 'variable' => $variable];
            }
            else{
                $resData = ['res' => 'Record not found', 'message' => 'error', 'title' => 'Oops!'];
            }

        }
        elseif($req->val == "payca"){
            // Update Information
            $getClient = DB::table('invoice_payment')
                     ->select(DB::raw('invoice_payment.transactionid, invoice_payment.name, invoice_payment.email, import_excel.amount as invoice_amount, invoice_payment.invoice_no, invoice_payment.service, invoice_payment.created_at as transaction_date, import_excel.description as description, invoice_payment.remaining_balance as runningbalance, invoice_payment.opening_balance, invoice_payment.amount as amount_paid, import_excel.status, import_excel.payment_due_date, invoice_payment.mystatus, import_excel.payee_ref_no, import_excel.transaction_ref'))->distinct()
                     ->join('import_excel', 'invoice_payment.client_id', '=', 'import_excel.uploaded_by')
                        ->where('invoice_payment.client_id', $req->user_id)
                    ->orderBy('invoice_payment.created_at', 'DESC')
                        ->get();

                        
            

            // InvoicePayment::where('client_id', $req->user_id)->get();


            // Get Client Details
            $client = ClientInfo::where('user_id', $req->user_id)->get();

            $transaction_cost = TransactionCost::all();

            if(count($transaction_cost) > 0){
                $fixed = $transaction_cost[0]->fixed;
                $variable = $transaction_cost[0]->variable;
            }
            else{
                $fixed = 0;
                $variable = 0;
            }

            if(count($getClient) > 0){
                $resData = ['res' => 'Retrieval...', 'message' => 'success', 'title' => 'Great', 'data' => json_encode($getClient), 'action' => 'payca', 'client' => json_encode($client), 'fixed' => $fixed, 'variable' => $variable];
            }
            else{
                $resData = ['res' => 'Record not found', 'message' => 'error', 'title' => 'Oops!'];
            }
        }
        

        return $this->returnJSON($resData, 200);
    }

    public function ajaxgetmremittance(Request $req){

        $from = $req->start_date;
        $nextDay = $req->end_date;
            

        if($req->val == "payca"){
            // Update Information
            // $getClient = InvoicePayment::where('client_id', $req->client_id)->where('service', $req->service)->whereBetween('created_at', [$from, $nextDay])->get();

            if($req->service == "all"){
                $getClient = DB::table('invoice_payment')
                     ->select(DB::raw('invoice_payment.transactionid, invoice_payment.name, invoice_payment.email, import_excel.amount as invoice_amount, invoice_payment.invoice_no, invoice_payment.service, invoice_payment.created_at as transaction_date, import_excel.description as description, invoice_payment.remaining_balance as runningbalance, invoice_payment.opening_balance, invoice_payment.amount as amount_paid, import_excel.status, import_excel.payment_due_date, invoice_payment.mystatus, import_excel.payee_ref_no, import_excel.transaction_ref, users.address'))->distinct()
                     ->join('import_excel', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')
                     ->join('users', 'invoice_payment.email', '=', 'users.email')
                    ->where('import_excel.uploaded_by', $req->client_id)
                    ->orderBy('invoice_payment.created_at', 'DESC')->get();
            }
            else{
                $getClient = DB::table('invoice_payment')
                     ->select(DB::raw('invoice_payment.transactionid, invoice_payment.name, invoice_payment.email, import_excel.amount as invoice_amount, invoice_payment.invoice_no, invoice_payment.service, invoice_payment.created_at as transaction_date, import_excel.description as description, invoice_payment.remaining_balance as runningbalance, invoice_payment.opening_balance, invoice_payment.amount as amount_paid, import_excel.status, import_excel.payment_due_date, invoice_payment.mystatus, import_excel.payee_ref_no, import_excel.transaction_ref'))->distinct()
                     ->join('import_excel', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')
                    ->where('import_excel.uploaded_by', $req->client_id)
                    ->where('invoice_payment.service', $req->service)->whereBetween('invoice_payment.created_at', [$from, $nextDay])
                    ->orderBy('invoice_payment.created_at', 'DESC')->get();
            }

            $withdraw_id = PaycaWithdraw::where('client_id', $req->client_id)->get();
            
            if(count($withdraw_id) > 0){
                $withID = $withdraw_id[0]->withdraw_id;
            }
            else{
                $withID = 0;
            }


            $transaction_cost = TransactionCost::all();

            if(count($transaction_cost) > 0){
                $fixed = $transaction_cost[0]->fixed;
                $variable = $transaction_cost[0]->variable;
            }
            else{
                $fixed = 0;
                $variable = 0;
            }


            if(count($getClient) > 0){
                $resData = ['res' => 'Retrieval...', 'message' => 'success', 'title' => 'Great', 'data' => json_encode($getClient), 'action' => 'payca', 'withdraw_id' => $withID, 'fixed' => $fixed, 'variable' => $variable];
            }
            else{
                $resData = ['res' => 'Record not found', 'message' => 'error', 'title' => 'Oops!'];
            }
        }

        elseif($req->val == "comission"){

            // Update Information
            // $getClient = InvoicePayment::where('client_id', $req->client_id)->where('service', $req->service)->whereBetween('created_at', [$from, $nextDay])->get();

            if($req->service == "all"){
                $getClient = DB::table('invoice_payment')
                     ->select(DB::raw('invoice_payment.transactionid, invoice_payment.name, invoice_payment.email, import_excel.amount as invoice_amount, invoice_payment.invoice_no, invoice_payment.service, invoice_payment.created_at as transaction_date, import_excel.description as description, invoice_payment.remaining_balance as runningbalance, invoice_payment.opening_balance, invoice_payment.amount as amount_paid, import_excel.status, import_excel.payment_due_date, invoice_payment.mystatus, import_excel.payee_ref_no, import_excel.transaction_ref, users.address'))->distinct()
                     ->join('import_excel', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')
                     ->join('users', 'invoice_payment.email', '=', 'users.email')
                    ->where('import_excel.uploaded_by', $req->client_id)
                    ->orderBy('invoice_payment.created_at', 'DESC')->get();
            }
            else{
                $getClient = DB::table('invoice_payment')
                     ->select(DB::raw('invoice_payment.transactionid, invoice_payment.name, invoice_payment.email, import_excel.amount as invoice_amount, invoice_payment.invoice_no, invoice_payment.service, invoice_payment.created_at as transaction_date, import_excel.description as description, invoice_payment.remaining_balance as runningbalance, invoice_payment.opening_balance, invoice_payment.amount as amount_paid, import_excel.status, import_excel.payment_due_date, invoice_payment.mystatus, import_excel.payee_ref_no, import_excel.transaction_ref'))->distinct()
                     ->join('import_excel', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')
                    ->where('import_excel.uploaded_by', $req->client_id)
                    ->where('invoice_payment.service', $req->service)->whereBetween('invoice_payment.created_at', [$from, $nextDay])
                    ->orderBy('invoice_payment.created_at', 'DESC')->get();
            }

            $withdraw_id = PaycaWithdraw::where('client_id', $req->client_id)->get();
            
            if(count($withdraw_id) > 0){
                $withID = $withdraw_id[0]->withdraw_id;
            }
            else{
                $withID = 0;
            }


            $transaction_cost = TransactionCost::all();

            if(count($transaction_cost) > 0){
                $fixed = $transaction_cost[0]->fixed;
                $variable = $transaction_cost[0]->variable;
            }
            else{
                $fixed = 0;
                $variable = 0;
            }


            if(count($getClient) > 0){
                $resData = ['res' => 'Retrieval...', 'message' => 'success', 'title' => 'Great', 'data' => json_encode($getClient), 'action' => 'comission', 'withdraw_id' => $withID, 'fixed' => $fixed, 'variable' => $variable];
            }
            else{
                $resData = ['res' => 'Record not found', 'message' => 'error', 'title' => 'Oops!'];
            }
        }

        elseif($req->val == "epayca"){

            if($req->service == "All"){
                // Update Information
            $getClient = DB::table('users')
                    ->join('organization_pay', 'organization_pay.user_id', '=', 'users.email')
                    ->join('epaywithdraw', 'epaywithdraw.client_id', '=', 'organization_pay.coy_id')
                    ->where('organization_pay.coy_id', $req->client_id)->whereBetween('organization_pay.created_at', [$from, $nextDay])
                    ->orderBy('organization_pay.created_at', 'DESC')
                    ->get();
            }
            else{
                // Update Information
            $getClient = DB::table('users')
                    ->join('organization_pay', 'organization_pay.user_id', '=', 'users.email')
                    ->join('epaywithdraw', 'epaywithdraw.client_id', '=', 'organization_pay.coy_id')
                    ->where('organization_pay.coy_id', $req->client_id)
                    ->where('organization_pay.purpose', 'LIKE', $req->service)->whereBetween('organization_pay.created_at', [$from, $nextDay])
                    ->orderBy('organization_pay.created_at', 'DESC')
                    ->get();
            }


            // dd($getClient);
            
            $withdraw_id = Epaywithdraw::where('client_id', $req->client_id)->get();
            
            if(count($withdraw_id) > 0){
                $withID = $withdraw_id[0]->withdraw_id;
            }
            else{
                $withID = 0;
            }
            


            $transaction_cost = TransactionCost::all();

                        if(count($transaction_cost) > 0){
                            $fixed = $transaction_cost[0]->fixed;
                            $variable = $transaction_cost[0]->variable;
                        }
                        else{
                            $fixed = 0;
                            $variable = 0;
                        }


            // dd($req->user_id);
            if(count($getClient) > 0){
                
                $resData = ['res' => 'Retrieval...', 'message' => 'success', 'title' => 'Great', 'data' => json_encode($getClient), 'action' => 'epayca', 'withdraw_id' => $withID, 'fixed' => $fixed, 'variable' => $variable];
            }
            else{
                $resData = ['res' => 'Record not found', 'message' => 'error', 'title' => 'Oops!'];
            }


        }

        

        return $this->returnJSON($resData, 200);
    }


    public function ajaxremitCash(Request $req){

        if($req->val == "epayca"){

            // Update Information
            $getClient = Epaywithdraw::where('withdraw_id', $req->withdraw_id)->get();
            if(count($getClient) > 0){

                $updt = Epaywithdraw::where('client_email', $getClient[0]->client_email)->update(['remittance' => 1, 'amount_paid' => $req->amount]);

                $this->saveCollectionfee($req->withdraw_id, date('Y-m-d'), $getClient[0]->client_name, $getClient[0]->client_email, $getClient[0]->amount_to_withdraw, $req->amount, $req->amount, $getClient[0]->created_at, date('Y-m-d H:i:s'), 'epayca');


                Epaywithdraw::where('client_email', $getClient[0]->client_email)->update(['amount_to_withdraw' => 0]);


                if($updt == 1){

                // Send Mail
                    $this->name = $getClient[0]->client_name;
                        $this->email = $getClient[0]->client_email;
                        $this->info = "Fund remittance";

                        $this->message = 'The fund withdrawal request has been successfully processed and fund transferred to '.$getClient[0]->card_method;

                        $this->sendEmail($this->email, "Fund remittance");
                    $resData = ['res' => 'Cash remitted successfully', 'message' => 'success', 'title' => 'Great'];
                }
                else{
                    $resData = ['res' => 'Something went wrong', 'message' => 'error', 'title' => 'Oops!'];
                }
            }
            else{
                $resData = ['res' => 'Record not found', 'message' => 'error', 'title' => 'Oops!'];
            }

        }
        elseif($req->val == "payca"){
            // Update Information
            $getClient = PaycaWithdraw::where('withdraw_id', $req->withdraw_id)->get();
            if(count($getClient) > 0){
                
                

                $updt = PaycaWithdraw::where('client_email', $getClient[0]->client_email)->update(['remittance' => 1, 'amount_paid' => $req->amount]);
                
                

                $this->saveCollectionfee($req->withdraw_id, date('Y-m-d'), $getClient[0]->client_name, $getClient[0]->client_email, $getClient[0]->amount_to_withdraw, $req->amount, $req->amount, $getClient[0]->created_at, date('Y-m-d H:i:s'), 'payca');

                PaycaWithdraw::where('client_email', $getClient[0]->client_email)->update(['amount_to_withdraw' => 0]);

                // Update invoice_payment
                InvoicePayment::where('client_id', $getClient[0]->client_id)->update(['withdraws' => 0]);

                if($updt == 2){
                // Send Mail
                    $this->name = $getClient[0]->client_name;
                        $this->email = $getClient[0]->client_email;
                        $this->info = "Fund remittance";

                        $this->message = 'The fund withdrawal request has been successfully processed and fund transferred to '.$getClient[0]->card_method;

                        $this->sendEmail($this->email, "Fund remittance");
                    $resData = ['res' => 'Cash remitted successfully', 'message' => 'success', 'title' => 'Great'];
                }
                else{
                    $resData = ['res' => 'Something went wrong', 'message' => 'error', 'title' => 'Oops!'];
                }
            }
            else{
                $resData = ['res' => 'Record not found', 'message' => 'error', 'title' => 'Oops!'];
            }
        }

        
        

        return $this->returnJSON($resData, 200);
    }


    public function ajaxcheckfeeReport(Request $req){

        $from = $req->start_date;
        $nextDay = $req->end_date;

        if($req->platform == "all"){
            $getreport = CollectionFee::where('client_email', $req->client_email)
                    ->whereBetween('end_date', [$from, $nextDay])
                    ->orderBy('created_at', 'DESC')->get();

        }
        elseif($req->platform == "payca"){
            $getreport = CollectionFee::where('client_email', $req->client_email)
                    ->where('platform', 'payca')
                    ->whereBetween('end_date', [$from, $nextDay])
                    ->orderBy('created_at', 'DESC')->get();
        }
        elseif($req->platform == "epayca"){
            $getreport = CollectionFee::where('client_email', $req->client_email)
                    ->where('platform', 'epayca')
                    ->whereBetween('end_date', [$from, $nextDay])
                    ->orderBy('created_at', 'DESC')->get();
        }

        $transaction_cost = TransactionCost::all();

            if(count($transaction_cost) > 0){
                $fixed = $transaction_cost[0]->fixed;
                $variable = $transaction_cost[0]->variable;
            }
            else{
                $fixed = 0;
                $variable = 0;
            }



        if(count($getreport)){
            $resData = ['res' => 'Fetching Data', 'message' => 'success', 'data' => json_encode($getreport), 'title' => 'Good', 'start_date' => $req->start_date, 'end_date' => $req->end_date, 'fixed' => $fixed, 'variable' => $variable];
        }
        else{
            $resData = ['res' => 'No record found', 'message' => 'info', 'title' => 'Oops!'];
        }

        return $this->returnJSON($resData, 200);
    }



    public function ajaxsetupTrans(Request $req){

        // Update or Create
        $setup = TransactionCost::updateOrCreate([
            'id' => 1,
        ], [
            'variable' => $req->variable,
            'fixed' => $req->fixed
        ]);

        if($setup){
            $resData = ['res' => 'Saved', 'message' => 'success', 'title' => 'Great'];
        }
        else{
            $resData = ['res' => 'Something went wrong', 'message' => 'error', 'title' => 'Oops!'];
        }

        return $this->returnJSON($resData, 200);
    }

    public function ajaxinvoiceVisit(Request $req){
        if($req->val == "delete"){
            $getInv = ImportExcel::where('id', $req->id)->get();

            if(count($getInv) > 0){
                // Delete
                ImportExcel::where('id', $req->id)->delete();

                $resData = ['res' => 'Deleted!', 'message' => 'success', 'title' => 'Great'];
            }
            else{
                $resData = ['res' => 'Something went wrong', 'message' => 'error', 'title' => 'Oops!'];
            }
        }

        return $this->returnJSON($resData, 200);
    }

    public function ajaxconfirmpayment(Request $req){

        
        // Get Transaction
        $getTrans = OrganizationPay::where('transactionid', $req->transactionid)->get();

        if(count($getTrans) > 0){
            $sender = User::where('email', $req->user_id)->get();
            $receiver = User::where('ref_code', $req->coy_id)->get();

            // Update Record
            OrganizationPay::where('transactionid', $req->transactionid)->update(['state' => 0, 'request_receive' => 2]);

        
            

            // Senders statement
            $this->insStatement($req->user_id, $req->transactionid, "Payment to ".$receiver[0]->name." on ".$getTrans[0]->purpose, 0, $getTrans[0]->amount_to_send, 0, date('Y-m-d', strtotime($getTrans[0]->created_at)), "Processed", "Payment", $sender[0]->ref_code, 0);

            // Admin Charge on Receiver

            $this->insStatement($receiver[0]->email, $req->transactionid, "Admin charge of $".$getTrans[0]->commission, 0, $getTrans[0]->commission, 0, date('Y-m-d'), "Processed", "Payment", $req->coy_id, 0);

            
            // Receiver Statement for remaining amount
            $rem = $getTrans[0]->amount_to_send;

            $this->insStatement($receiver[0]->email, $req->transactionid, "Received Payment for ".$getTrans[0]->purpose." from ".$sender[0]->name, $rem, 0, 0, date('Y-m-d'), "Processed", "Invoice", $req->coy_id, 0);


            // Send Mail to Receiver
            $this->name = $receiver[0]->name;
            $this->email = $receiver[0]->email;
            // $this->email = "bambo@vimfile.com";
            $this->info = "Fund remittance";

            $this->message = "You have received a payment on PaySprint via send money. <br> Payment made by ".$sender[0]->name." for the purpose of ".$getTrans[0]->purpose.". <br><br> Below is the transaction details; <br><br> Amount sent: ".number_format($getTrans[0]->amount_to_send, 2)." <br><br> Admin Charge: ".$getTrans[0]->commission." <br><br> Amount received: ".number_format($rem, 2)." <br><br> Thanks <br> PaySprint Team" ;
            


            $this->sendEmail($this->email, "Fund remittance");

            $resData = ['res' => 'Payment Confirmed', 'message' => 'success', 'title' => 'Great'];
        }
        else{
            $resData = ['res' => 'Transaction not found', 'message' => 'error', 'title' => 'Oops!'];
        } 

        return $this->returnJSON($resData, 200);
    }


    public function ajaxapproveUser(Request $req, User $user){

        $data = $user->where('id', $req->id)->first();

        if($data->approval == 1){
            $user->where('id', $req->id)->update(['approval' => 0]);

            $resData = ['res' => 'Account information disapproved', 'message' => 'success', 'title' => 'Great'];
        }
        else{
            $user->where('id', $req->id)->update(['approval' => 1]);

            $resData = ['res' => 'Account information approved', 'message' => 'success', 'title' => 'Great'];
        }


        return $this->returnJSON($resData, 200);

    }

    




    public function ajaxadminLogout(Request $req){

        $getAdmin = Admin::where('username', $req->username)->get();
        // dd($getAdmin);
        if(count($getAdmin) > 0){
          Session::flush();
          $site = "AdminLogin";
          $resData = ['res' => 'Login out', 'message' => 'success', 'link' => $site];

        }
        else{
            // Logout Super Admin
            $superAdmin = SuperAdmin::where('username', $req->username)->get();

            if(count($superAdmin) > 0){
            Session::flush();
            $site = "AdminLogin";
            $resData = ['res' => 'Login out', 'message' => 'success', 'link' => $site];

            }

        }

          return $this->returnJSON($resData, 200);

    }


    public function withdrawRemittance(){

        $getAll = Epaywithdraw::where('remittance', 0)->orderBy('created_at', 'DESC')->get();

        return $getAll;

    }

    public function withdrawpaycaRemittance(){

        $getAll = PaycaWithdraw::where('remittance', 0)->orderBy('created_at', 'DESC')->get();

        return $getAll;

    }

    public function epayreportRemittance($email){

        $getAll = Epaywithdraw::where('remittance', 1)->where('client_email', $email)->orderBy('created_at', 'DESC')->get();

        return $getAll;

    }

    public function paycareportRemittance($email){

        $getAll = PaycaWithdraw::where('remittance', 1)->where('client_email', $email)->orderBy('created_at', 'DESC')->get();

        return $getAll;

    }

    public function remittancereportepayAdmin(){

        $getAll = Epaywithdraw::where('remittance', 1)->orderBy('created_at', 'DESC')->get();

        return $getAll;

    }

    public function remittancereportpaycaAdmin(){

        $getAll = PaycaWithdraw::where('remittance', 1)->orderBy('created_at', 'DESC')->get();

        return $getAll;

    }



    public function allcollectionFee(){

        $getAll = CollectionFee::orderBy('created_at', 'DESC')->get();

        return $getAll;

    }

    public function getCustomer($id){

        $getcustomer = ImportExcel::where('id', $id)->get();

        return $getcustomer;

    }

    public function saveCollectionfee($collection_id, $remittance_date, $client_name, $client_email, $total_amount, $total_remittance, $total_fee, $start_date, $end_date, $platform){

        CollectionFee::insert(['collection_id' => $collection_id, 'remittance_date' => $remittance_date, 'client_name' => $client_name, 'client_email' => $client_email, 'total_amount' => $total_amount, 'total_remittance' => $total_remittance, 'total_fee' => $total_fee, 'start_date' => $start_date, 'end_date' => $end_date, 'platform'=> $platform]);

    }


    public function insStatement($email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, $state){
        Statement::insert(['user_id' => $email, 'reference_code' => $reference_code, 'activity' => $activity, 'credit' => $credit, 'debit' => $debit, 'balance' => $balance, 'trans_date' => $trans_date, 'status' => $status, 'action' => $action, 'regards' => $regards, 'state' => $state]);
    }

    public function serviceType($name){
        ServiceType::insert(['name' => $name]);
    }


    public function getallClient(){
        $getClient = ClientInfo::orderBy('created_at', 'DESC')->get();

        return $getClient;
    }

    public function getxpayTrans(){
        $getxpayrec = OrganizationPay::where('state', 1)->where('request_receive', '!=', 2)->orderBy('created_at', 'DESC')->get();

        return $getxpayrec;
    }


    public function getxReceive(){
        $data = OrganizationPay::select('organization_pay.*','receive_pay.*')->join('receive_pay', 'receive_pay.pay_id', '=', 'organization_pay.id')->where('organization_pay.request_receive', '!=', 0)->orderBy('organization_pay.created_at', 'DESC')->get();

        return $data;
    }


    // Get Tranasaction cost
    public function transactionCost(){
        $getCost = TransactionCost::all();

        return $getCost;
    }
    public function allUsers(){
        $data = User::orderBy('created_at', 'DESC')->get();

        return $data;
    }


    // Platform API
    public function doCurl(){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $this->url,
            CURLOPT_USERAGENT => 'Exbc cURL Request',
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $this->curl_data
        ));

        // Send the request & save response to $resp
        $resp = curl_exec($curl);

        // Close request to clear up some resources
        curl_close($curl);

        // dd($resp);
        // dd($this->url);
        // dd($this->curl_data);
        return json_decode($resp);

        // exit();
    }


    public function recurBills($user_id){
        // Get Statements

        $today = date('Y-m-d');

        $getimport = ImportExcel::where('payment_due_date', '<', $today)->where('uploaded_by', $user_id)->orderBy('created_at')->get();

        if(count($getimport) > 0){
            // Loop through information


            foreach ($getimport as $key => $value) {
                $recur = $value->recurring;
                $trans_date = $value->transaction_date;
                $due_date = $value->payment_due_date;
                $email = $value->payee_email;

                if($recur == "Weekly"){
                    $period = date('Y-m-d', strtotime($trans_date. ' + 7 days'));
                    $due_period = date('Y-m-d', strtotime($due_date. ' + 7 days'));
                }
                elseif($recur == "Bi-Monthly"){
                    $period = date('Y-m-d', strtotime($trans_date. ' + 14 days'));
                    $due_period = date('Y-m-d', strtotime($due_date. ' + 14 days'));
                }
                elseif($recur == "Monthly"){
                    $period = date('Y-m-d', strtotime($trans_date. ' + 30 days'));
                    $due_period = date('Y-m-d', strtotime($due_date. ' + 30 days'));
                }
                elseif($recur == "Quaterly"){
                    $period = date('Y-m-d', strtotime($trans_date. ' + 90 days'));
                    $due_period = date('Y-m-d', strtotime($due_date. ' + 90 days'));
                }
                elseif($recur == "Half Yearly"){
                    $period = date('Y-m-d', strtotime($trans_date. ' + 180 days'));
                    $due_period = date('Y-m-d', strtotime($due_date. ' + 180 days'));
                }
                elseif($recur == "Yearly"){
                    $period = date('Y-m-d', strtotime($trans_date. ' + 365 days'));
                    $due_period = date('Y-m-d', strtotime($due_date. ' + 365 days'));
                }

                if($due_period > $today){


                    // Update
                    $updt = ImportExcel::where('payee_email', $email)->where('uploaded_by', $user_id)->update(['transaction_date' => $period, 'payment_due_date' => $due_period, 'installcount' => 0]);

                    // Send mail


                    // Insert Statement
                    $activity = "Invoice on ".$value->service;
                    $credit = $value->amount;
                    $debit = 0;
                    $balance = 0;
                    $reference_code = $value->invoice_no;
                    $status = "Delivered";
                    $action = "Invoice";
                    $trans_date = $period;
                    $regards = $user_id;
                    
                    $this->insStatement($email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 0);

                    $getClient = ClientInfo::where('user_id', $user_id)->get();


                    if(count($getClient) > 0){
                        $clientname = $getClient[0]->business_name;
                        $clientaddress = $getClient[0]->address;
                        $client_realname = $getClient[0]->firstname.' '.$getClient[0]->lastname;
                        $city = $getClient[0]->city;
                        $state = $getClient[0]->state;
                        $zipcode = $getClient[0]->zip_code;
                    }
                    else{
                        $clientname = "PaySprint (EXBC)";
                        $client_realname = "PaySprint (EXBC)";
                        $clientaddress = "EXBC, by Express Ca Corp, 10 George St. North, Brampton. ON. L6X1R2. Canada";
                        $city = "Brampton";
                        $state = "Ontario";
                        $zipcode = "L6X1R2";
                    }

                    $this->to = $email;
                    // $this->to = "bambo@vimfile.com";
                    $this->name = $value->name;
                    $this->transaction_date = $period;
                    $this->invoice_no = $value->invoice_no;
                    $this->payee_ref_no = $value->payee_ref_no;
                    $this->transaction_ref = $value->transaction_ref;
                    $this->description = $value->description;
                    $this->payment_due_date = $due_period;
                    $this->customer_id = $value->customer_id;
                    $this->amount = $value->amount;
                    $this->address = $clientaddress;
                    $this->service = $value->service;
                    $this->clientname = $clientname;
                    $this->client_realname = $client_realname;
                    $this->city = $city;
                    $this->state = $state;
                    $this->zipcode = $zipcode;

                    $this->subject = $this->clientname.' sends you recurring invoice on PaySprint';

                    $this->sendEmail($this->to, $this->subject);



                }
                else{
                    // Do nothing
                }
            }


        }
        else{
            // Do nothing
        }
    }


    public function sendEmail($objDemoa, $purpose){
      $objDemo = new \stdClass();
      $objDemo->purpose = $purpose;
      
      

      if($purpose == 'Account is credited'){
            $objDemo->name = $this->name;
            $objDemo->subject = $this->subject;
            $objDemo->message = $this->message;
        }
        elseif($purpose == 'Fund remittance'){
            $objDemo->name = $this->name;
            $objDemo->email = $this->email;
            $objDemo->subject = $this->info;
            $objDemo->message = $this->message;
        }
        elseif($purpose == 'Cash withdrawal request'){
            $objDemo->name = $this->admin;
            $objDemo->email = $this->to;
            $objDemo->subject = $this->info2;
            $objDemo->message = $this->infomessage;
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
