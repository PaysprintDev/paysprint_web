<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

//Session
use Session;

use App\Notifications;
use App\Admin as Admin;
use App\ImportExcel as ImportExcel;
use App\ImportExcelLink as ImportExcelLink;
use App\InvoicePayment as InvoicePayment;
use App\Mail\sendEmail;

use App\User as User;

use App\CreateEvent as CreateEvent;



use App\SuperAdmin as SuperAdmin;



use App\ClientInfo as ClientInfo;



use App\OrganizationPay as OrganizationPay;

use App\Epaywithdraw as Epaywithdraw;

use App\PaycaWithdraw as PaycaWithdraw;

use App\TransactionCost as TransactionCost;

use App\CollectionFee as CollectionFee;

use App\ServiceType as ServiceType;

use App\Statement as Statement;

use App\BankWithdrawal as BankWithdrawal;

use App\CcWithdrawal as CcWithdrawal;

use App\AddBank as AddBank;

use App\CardIssuer as CardIssuer;

use App\AddCard as AddCard;

use App\DeletedCards as DeletedCards;

use App\MerchantService as MerchantService;

use App\AnonUsers as AnonUsers;



use App\RequestRefund as RequestRefund;

use App\MonthlyFee as MonthlyFee;

use App\Tax as Tax;

use App\AllCountries as AllCountries;
use App\EscrowAccount;
use App\FxStatement;
use App\InAppMessage as InAppMessage;


use App\InvoiceCommission;
use App\MonerisActivity as MonerisActivity;

use App\SupportActivity as SupportActivity;


use App\UserClosed as UserClosed;

use App\PricingSetup as PricingSetup;

use App\MailCampaign as MailCampaign;
use App\MarkUp;
use App\Traits\Trulioo;

use App\Traits\AccountNotify;

use App\Traits\SpecialInfo;

use App\Traits\PaystackPayment;

use App\Traits\PaymentGateway;

use App\Traits\FlagPayment;

use App\Traits\Xwireless;

use App\Traits\MailChimpNewsLetter;

use App\Traits\PaysprintPoint;

use App\Traits\MyFX;

class AmlController extends Controller
{

    use Trulioo, AccountNotify, SpecialInfo, PaystackPayment, FlagPayment, PaymentGateway, Xwireless, MailChimpNewsLetter, PaysprintPoint, MyFX;

    public function index(Request $req)
    {
        // dd(Session::all());

    

        if ($req->session()->has('username') == true) {


            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing") {
                $adminUser = Admin::orderBy('created_at', 'DESC')->get();
                $invoiceImport = ImportExcel::orderBy('created_at', 'DESC')->get();
                $invoiceLinkImport = ImportExcelLink::orderBy('created_at', 'DESC')->get();
                $payInvoice = DB::table('client_info')
                    ->join('invoice_payment', 'client_info.user_id', '=', 'invoice_payment.client_id')
                    ->orderBy('invoice_payment.created_at', 'DESC')
                    ->get();

                $otherPays = OrganizationPay::orderBy('created_at', 'DESC')->get();
            } else {
                $adminUser = Admin::where('username', session('username'))->get();
                $invoiceImport = ImportExcel::where('uploaded_by', session('user_id'))->orderBy('created_at', 'DESC')->get();
                $invoiceLinkImport = ImportExcelLink::where('uploaded_by', session('user_id'))->orderBy('created_at', 'DESC')->get();
                $payInvoice = InvoicePayment::where('client_id', session('user_id'))->orderBy('created_at', 'DESC')->get();
                $otherPays = OrganizationPay::where('coy_id', session('user_id'))->orderBy('created_at', 'DESC')->get();

                $this->recurBills(session('user_id'));
            }



            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();
            $transCost = $this->transactionCost();
            $allusers = $this->allUsers();

            $getUserDetail = $this->getmyPersonalDetail(session('user_id'));

            $getCard = $this->getUserCard(session('myID'));
            $getBank = $this->getUserBank(session('myID'));

            $getTax = $this->getTax(session('myID'));


            $withdraws = [
                'bank' => $this->requestFromBankWithdrawal(),
                'purchase' => $this->purchaseRefundSentback(),
                'credit' => $this->requestFromCardWithdrawal(),
                'prepaid' => $this->pendingRequestFromPrepaidWithdrawal(),
                // 'specialInfo' => $this->getthisInfo(session('country')),
            ];


            $pending = [
                'transfer' => $this->pendingTransferTransactions(),
                'texttotransfer' => $this->textToTransferUsers(),
            ];

            $refund = [
                'requestforrefund' => $this->requestForAllRefund(),
            ];

            $allcountries = $this->getAllCountries();

            $received = [
                'payInvoice' => $this->payInvoice(session('email')),
            ];

            $data = array(
                'getuserDetail' => $this->getmyPersonalDetail(session('user_id')),
                'getbusinessDetail' => $this->getmyBusinessDetail(session('user_id')),
                'merchantservice' => $this->_merchantServices(),
                'getCard' => $this->getUserCard(session('myID')),
                'getBank' => $this->getUserBank(session('myID')),
                'getTax' => $this->getTax(session('myID')),
                'listbank' => $this->getBankList(),
                'escrowfund' => $this->getEscrowFunding(),
            );





            return view('aml.index')->with(['pages' => 'AML Dashboard', 'data' => $data, 'received' => $received, 'withdraws' => $withdraws, 'pending' => $pending, 'refund' => $refund, 'allusers' => $allusers, 'invoiceImport' => $invoiceImport , 'payInvoice' => $payInvoice, 'invoiceLinkImport' => $invoiceLinkImport, 'transCost' => $transCost]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }

    public function recurBills($user_id)
    {
        // Get Statements

        $today = date('Y-m-d');

        $getimport = ImportExcel::where('payment_due_date', '<', $today)->where('uploaded_by', $user_id)->orderBy('created_at')->get();

        // dd($getimport);

        if (count($getimport) > 0) {
            // Loop through information


            foreach ($getimport as $key => $value) {
                $recur = $value->recurring;
                $trans_date = $value->transaction_date;
                $due_date = $value->payment_due_date;
                $email = $value->payee_email;




                if ($recur == "One Time") {
                    $period = null;
                    $due_period = null;
                } elseif ($recur == "Weekly") {
                    $period = date('Y-m-d', strtotime($trans_date . ' + 7 days'));
                    $due_period = date('Y-m-d', strtotime($due_date . ' + 7 days'));
                } elseif ($recur == "Bi-Monthly") {
                    $period = date('Y-m-d', strtotime($trans_date . ' + 14 days'));
                    $due_period = date('Y-m-d', strtotime($due_date . ' + 14 days'));
                } elseif ($recur == "Monthly") {
                    $period = date('Y-m-d', strtotime($trans_date . ' + 30 days'));
                    $due_period = date('Y-m-d', strtotime($due_date . ' + 30 days'));
                } elseif ($recur == "Quaterly") {
                    $period = date('Y-m-d', strtotime($trans_date . ' + 90 days'));
                    $due_period = date('Y-m-d', strtotime($due_date . ' + 90 days'));
                } elseif ($recur == "Half Yearly") {
                    $period = date('Y-m-d', strtotime($trans_date . ' + 180 days'));
                    $due_period = date('Y-m-d', strtotime($due_date . ' + 180 days'));
                } elseif ($recur == "Yearly") {
                    $period = date('Y-m-d', strtotime($trans_date . ' + 365 days'));
                    $due_period = date('Y-m-d', strtotime($due_date . ' + 365 days'));
                } elseif ($recur == null) {
                    $period = date('Y-m-d', strtotime($trans_date . ' + 365 days'));
                    $due_period = date('Y-m-d', strtotime($due_date . ' + 365 days'));
                }





                if ($due_period > $today) {

                    $thisuser = User::where('ref_code', $user_id)->first();

                    // Update
                    $updt = ImportExcel::where('payee_email', $email)->where('uploaded_by', $user_id)->update(['transaction_date' => $period, 'payment_due_date' => $due_period, 'installcount' => 0]);

                    // Send mail


                    // Insert Statement
                    $activity = "Invoice on " . $value->service;
                    $credit = $value->amount;
                    $debit = 0;
                    $balance = 0;
                    $reference_code = $value->invoice_no;
                    $status = "Delivered";
                    $action = "Invoice";
                    $trans_date = $period;
                    $regards = $user_id;

                    $this->insStatement($email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 0, $thisuser->country);

                    $getClient = ClientInfo::where('user_id', $user_id)->get();


                    if (count($getClient) > 0) {
                        $clientname = $getClient[0]->business_name;
                        $clientaddress = $getClient[0]->address;
                        $client_realname = $getClient[0]->firstname . ' ' . $getClient[0]->lastname;
                        $city = $getClient[0]->city;
                        $state = $getClient[0]->state;
                        $zipcode = $getClient[0]->zip_code;
                    } else {
                        $clientname = "PaySprint (EXBC)";
                        $client_realname = "PaySprint (EXBC)";
                        $clientaddress = "PaySprint by Express Ca Corp, 10 George St. North, Brampton. ON. L6X1R2. Canada";
                        $city = "Brampton";
                        $state = "Ontario";
                        $zipcode = "L6X1R2";
                    }

                    $this->to = $email;
                    // $this->to = "adenugaadebambo41@gmail.com";
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

                    $this->subject = $this->clientname . ' sends you recurring invoice on PaySprint';

                    $this->sendEmail($this->to, $this->subject);
                } else {
                    // Do nothing
                }
            }
        } else {
            // Do nothing
        }
    }

    public function textsToTransferByCountry(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing") {
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
            } else {
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

            $data = array(
                'textstotransferbycountry' => $this->textToTransferUsersByCountry($req->get('country')),
            );



            return view('aml.amlsuplinkfolder.pendingtransferbycountryaml')->with(['pages' => 'AML Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }

    public function activityLog()
    {
      

        $transCost = $this->transactionCost();
        $allusers = $this->allUsers();

        $withdraws = [
            'bank' => $this->requestFromBankWithdrawal(),
            'purchase' => $this->purchaseRefundSentback(),
            'credit' => $this->requestFromCardWithdrawal(),
            'prepaid' => $this->pendingRequestFromPrepaidWithdrawal(),
            // 'specialInfo' => $this->getthisInfo(session('country')),
        ];

        $pending = [
            'transfer' => $this->pendingTransferTransactions(),
            'texttotransfer' => $this->textToTransferUsers(),
        ];

        $refund = [
            'requestforrefund' => $this->requestForAllRefund(),
        ];

        $allcountries = $this->getAllCountries();

        $received = [
            'payInvoice' => $this->payInvoice(session('email')),
        ];

        $data = array(
            'getuserDetail' => $this->getmyPersonalDetail(session('user_id')),
            'getbusinessDetail' => $this->getmyBusinessDetail(session('user_id')),
            'merchantservice' => $this->_merchantServices(),
            'getCard' => $this->getUserCard(session('myID')),
            'getBank' => $this->getUserBank(session('myID')),
            'getTax' => $this->getTax(session('myID')),
            'listbank' => $this->getBankList(),
            'escrowfund' => $this->getEscrowFunding(),
            'activity' => $this->userActivity(),
            'supportactivity' => $this->userSupportActivities()
        );


        return view('aml.activitylog')->with(['pages' => 'AML Dashboard', 'data' => $data, 'received' => $received, 'withdraws' => $withdraws, 'pending' => $pending, 'refund' => $refund, 'allusers' => $allusers, 'transCost' => $transCost, 'data' => $data]);
    }


    public function transactionReview()
    {

        $transCost = $this->transactionCost();
        $allusers = $this->allUsers();

        $withdraws = [
            'bank' => $this->requestFromBankWithdrawal(),
            'purchase' => $this->purchaseRefundSentback(),
            'credit' => $this->requestFromCardWithdrawal(),
            'prepaid' => $this->pendingRequestFromPrepaidWithdrawal(),
            // 'specialInfo' => $this->getthisInfo(session('country')),
        ];

        $pending = [
            'transfer' => $this->pendingTransferTransactions(),
            'texttotransfer' => $this->textToTransferUsers(),
        ];

        $refund = [
            'requestforrefund' => $this->requestForAllRefund(),
        ];

        $allcountries = $this->getAllCountries();

        $received = [
            'payInvoice' => $this->payInvoice(session('email')),
        ];

        $data = array(
            'getuserDetail' => $this->getmyPersonalDetail(session('user_id')),
            'getbusinessDetail' => $this->getmyBusinessDetail(session('user_id')),
            'merchantservice' => $this->_merchantServices(),
            'getCard' => $this->getUserCard(session('myID')),
            'getBank' => $this->getUserBank(session('myID')),
            'getTax' => $this->getTax(session('myID')),
            'listbank' => $this->getBankList(),
            'escrowfund' => $this->getEscrowFunding(),
            'activity' => $this->userActivity(),
            'flaggedUsers' => $this->getFlaggedUsers()
            
        );


        return view('aml.transactionreview')->with(['pages' => 'AML Dashboard', 'data' => $data, 'received' => $received, 'withdraws' => $withdraws, 'pending' => $pending, 'refund' => $refund, 'allusers' => $allusers, 'transCost' => $transCost, 'data' => $data]);
    }



    public function reports()
    {
        $data = array(
            'activity' => $this->userActivity()
        );

        $transCost = $this->transactionCost();
        $allusers = $this->allUsers();

        $withdraws = [
            'bank' => $this->requestFromBankWithdrawal(),
            'purchase' => $this->purchaseRefundSentback(),
            'credit' => $this->requestFromCardWithdrawal(),
            'prepaid' => $this->pendingRequestFromPrepaidWithdrawal(),
            // 'specialInfo' => $this->getthisInfo(session('country')),
        ];

        $pending = [
            'transfer' => $this->pendingTransferTransactions(),
            'texttotransfer' => $this->textToTransferUsers(),
        ];

        $refund = [
            'requestforrefund' => $this->requestForAllRefund(),
        ];

        $allcountries = $this->getAllCountries();

        $invoiceImport = ImportExcel::orderBy('created_at', 'DESC')->get();

        $received = [
            'payInvoice' => $this->payInvoice(session('email')),
        ];

        $data = array(
            'getuserDetail' => $this->getmyPersonalDetail(session('user_id')),
            'getbusinessDetail' => $this->getmyBusinessDetail(session('user_id')),
            'merchantservice' => $this->_merchantServices(),
            'getCard' => $this->getUserCard(session('myID')),
            'getBank' => $this->getUserBank(session('myID')),
            'getTax' => $this->getTax(session('myID')),
            'listbank' => $this->getBankList(),
            'escrowfund' => $this->getEscrowFunding(),
        );

        


        return view('aml.reports')->with(['pages' => 'AML Dashboard', 'data' => $data, 'received' => $received, 'withdraws' => $withdraws, 'pending' => $pending, 'refund' => $refund, 'allusers' => $allusers, 'transCost' => $transCost, 'data' => $data, 'invoiceImport' => $invoiceImport]);
    }







    public function platform(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing") {
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
            } else {
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

            $data = array(
                'activity' => $this->userActivity()
            );



            return view('admin.pages.activity')->with(['pages' => 'AML Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }

    //         return redirect()->route('AdminLogin');
    //     }
    // }

    public function getCustomer($id)
    {

        $getcustomer = ImportExcel::where('id', $id)->get();

        return $getcustomer;
    }

    public function allcollectionFee()
    {

        $getAll = CollectionFee::orderBy('created_at', 'DESC')->get();

        return $getAll;
    }

    public function getxpayTrans()
    {
        $getxpayrec = OrganizationPay::where('state', 1)->where('request_receive', '!=', 2)->orderBy('created_at', 'DESC')->get();

        return $getxpayrec;
    }

    public function getallClient()
    {
        $getClient = ClientInfo::orderBy('created_at', 'DESC')->get();

        return $getClient;
    }


    public function withdrawRemittance()
    {

        $getAll = Epaywithdraw::where('remittance', 0)->orderBy('created_at', 'DESC')->get();

        return $getAll;
    }



    public function customerService(Request $req)
    {

        if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing") {
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
        } else {
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
        $getCustomer = $this->getCustomer($req->route('id'));


        // Get all xpaytransactions where state = 1;

        $getxPay = $this->getxpayTrans();
        $allusers = $this->allUsers();

        $data = array(
            'activity' => $this->userSupportActivities()
        );


        return view('aml.amlsuplinkfolder.customerservice')->with(['pages' => 'AML Dashboard', 'data' => $data, 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers]);
    }

    public function technology()
    {
        $data = array(
            'activity' => $this->userActivity()
        );


        return view('aml.amlsuplinkfolder.technology')->with(['data' => $data]);
    }

    public function userSupportActivities()
    {

        $data = SupportActivity::orderBy('created_at', 'DESC')->get();

        return $data;
    }


    public function requestForWithdrawalToBank(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing") {
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
            } else {
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

            $data = array(
                'walletBalance' => $this->userWalletBalance(),
                'walletcategoryBalance' => $this->userWalletBalancebyCategory(),
                'allusers' => $this->userWalletBalance(),
                'bankRequestWithdrawal' => $this->requestFromBankWithdrawal(),
            );



            return view('aml.amlsuplinkfolder.requestforwithdrawaltobank')->with(['pages' => 'AML Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return view('aml.amlsuplinkfolder.requestforwithdrawaltobank');
        }
    }

    public function userWalletBalance()
    {
        $data = User::select('id', 'name', 'email', 'ref_code')->orderBy('created_at', 'DESC')->get();

        return $data;
    }

    public function userWalletBalancebyCategory()
    {
        $data = User::select('country', 'currencyCode', 'wallet_balance')->orderBy('created_at', 'DESC')->groupBy('country')->get();

        return $data;
    }


    public function purchaseRequestReturnAml(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing") {
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
            } else {
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

            $data = array(
                'processList' => $this->purchaseRefundSentback(),
            );



            return view('aml.amlsuplinkfolder.purchaserequestreturnaml')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }
    // public function purchaseRefundRequestAml(Request $req)
    // {
    //     if ($req->session()->has('username') == true) {
    //         // dd(Session::all());

    //         if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing") {
    //             $adminUser = Admin::orderBy('created_at', 'DESC')->get();
    //             $invoiceImport = ImportExcel::orderBy('created_at', 'DESC')->get();
    //             $payInvoice = DB::table('client_info')
    //                 ->join('invoice_payment', 'client_info.user_id', '=', 'invoice_payment.client_id')
    //                 ->orderBy('invoice_payment.created_at', 'DESC')
    //                 ->get();

    //             $otherPays = DB::table('organization_pay')
    //                 ->join('users', 'organization_pay.user_id', '=', 'users.email')
    //                 ->orderBy('organization_pay.created_at', 'DESC')
    //                 ->get();
    //         } else {
    //             $adminUser = Admin::where('username', session('username'))->get();
    //             $invoiceImport = ImportExcel::where('uploaded_by', session('user_id'))->orderBy('created_at', 'DESC')->get();
    //             $payInvoice = InvoicePayment::where('client_id', session('user_id'))->orderBy('created_at', 'DESC')->get();
    //             $otherPays = DB::table('organization_pay')
    //                 ->join('users', 'organization_pay.user_id', '=', 'users.email')
    //                 ->where('organization_pay.coy_id', session('user_id'))
    //                 ->orderBy('organization_pay.created_at', 'DESC')
    //                 ->get();
    //         }

    //         // dd($payInvoice);

    //          $withdraws = [
    //             'bank' => $this->requestFromBankWithdrawal(),
    //             'purchase' => $this->purchaseRefundSentback(),
    //             'credit' => $this->requestFromCardWithdrawal(),
    //             'prepaid' => $this->pendingRequestFromPrepaidWithdrawal(),
    //             // 'specialInfo' => $this->getthisInfo(session('country')),
    //         ];

    //         $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();

    //         $transCost = $this->transactionCost();

    //         $getwithdraw = $this->withdrawRemittance();
    //         $collectfee = $this->allcollectionFee();
    //         $getClient = $this->getallClient();
    //         $getCustomer = $this->getCustomer($req->route('id'));


    //         // Get all xpaytransactions where state = 1;

    //         $getxPay = $this->getxpayTrans();
    //         $allusers = $this->allUsers();

    //         $data = array(
    //             'requestforrefund' => $this->requestForRefund(),
    //         );



    //         return view('aml.amlsuplinkfolder.purchaserefundrequestaml')->with(['pages' => 'AML Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'withdraws' => $withdraws, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
    //     }
    // }

    public function getRefundDetailAml(Request $req, $transid)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing") {
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
            } else {
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

            $data = array(
                'getuserrefunddetail' => $this->getuserRefundDetail($transid),
            );

            return view('aml.wallet.getrefunddetail')->with(['pages' => 'AML Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }

    public function getuserRefundDetail($transid)
    {

        $data = RequestRefund::where('transaction_id', $transid)->first();

        return $data;
    }

    public function refundMoneyRequestByCountryAml(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing") {
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
            } else {
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

            $data = array(
                'requestforrefund' => $this->requestForRefundByCountry($req->get('country')),
            );



            return view('aml.amlsuplinkfolder.refundrequestwithdrawalbycountryaml')->with(['pages' => 'AML Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function requestForRefundByCountryAml(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing") {
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
            } else {
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

            $data = array(
                'requestforrefund' => $this->requestForRefundByCountry($req->get('country')),
            );



            return view('admin.wallet.refundrequestwithdrawalbycountry')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }



    // public function requestForRefundByCountryAml($country)
    // {

    //     $data = RequestRefund::where('status', '!=', 'PROCESSED')->where('country', $country)->orderBy('created_at', 'DESC')->get();

    //     return $data;
    // }







    public function processedRefundMoneyRequest(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing") {
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
            } else {
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

            $data = array(
                'processedrequestforrefund' => $this->processedrequestForRefund(),
            );



            return view('aml.amlsuplinkfoldert.refundrequestprocessed')->with(['pages' => 'AML Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }

    // public function creditCardWithdrawalRequest(){
    //     $data = array(
    //         'activity' => $this->userActivity()
    //     );


    //     return view('aml.amlsuplinkfolder.creditcardwithdrawalrequest')->with(['data' => $data]);

    // }
    public function creditCardWithdrawalRequest(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing") {
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
            } else {
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

            $data = array(
                'cardRequestWithdrawal' => $this->requestFromCardWithdrawal(),
            );

            // dd($data);


            return view('admin.wallet.cardrequestwithdrawal')->with(['pages' => 'AML Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return view('aml.amlsuplinkfolder.creditcardwithdrawalrequest');
        }
    }

    // public function pendingTransfer(){
    //     $data = array(
    //         'activity' => $this->userActivity()
    //     );


    //     return view('aml.amlsuplinkfolder.pendingtransfer')->with(['data' => $data]);

    // }

    public function pendingTransfer(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing") {
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
            } else {
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

            $data = array(
                'pendingtransfer' => $this->pendingTransferTransactions(),
            );

            // dd($data);


            return view('aml.amlsuplinkfolder.pendingtransferaml')->with(['pages' => 'AML Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }



    // public function prepaidCardWithdrawalRequest(){
    //     $data = array(
    //         'activity' => $this->userActivity()
    //     );


    //     return view('aml.amlsuplinkfolder.prepaidcardwithdrawalrequest')->with(['data' => $data]);

    // }

    public function prepaidCardWithdrawalRequest(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing") {
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
            } else {
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

            $data = array(
                'prepaidRequestWithdrawal' => $this->requestFromPrepaidWithdrawal(),
            );



            return view('aml.amlsuplinkfolder.prepaidcardholdreturn')->with(['pages' => 'AML Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return view('aml.amlsuplinkfolder.prepaidcardholdreturn');
        }
    }

    public function requestFromPrepaidWithdrawal()
    {

        // RUN CRON GET

        // $access_key = '6173fa628b16d8ce1e0db5cfa25092ac';

        if (env('APP_ENV') == "local") {
            $url = "http://localhost:4000/api/v1/paysprint/loadrequest";
        } else {
            $url = "https://exbc.ca/api/v1/paysprint/loadrequest";
        }



        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer base64:HgMO6FDHGziGl01OuLH9mh7CeP095shB6uuDUUClhks='
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $result = json_decode($response);


        return $result;
    }

    public function requestForRemittanceToClient()
    {
        $data = array(
            'activity' => $this->userActivity()
        );


        return view('aml.amlsuplinkfolder.requestforremitancetoclient')->with(['data' => $data]);
    }

    public function requestRefund(Request $req)
    {

        if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing") {
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
        } else {
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

        $data = array(
            'requestforrefund' => $this->requestForRefund(),
        );



        return view('aml.amlsuplinkfolder.requestforrefund')->with(['pages' => 'AML Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
    }



    public function merchantBanksDetailsAml(Request $req)
    {
        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing") {
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
            } else {
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

            $data = array(
                'bankdetail' => $this->userBankDetail($req->get('country')),
            );




            return view('aml.amlsuplinkfolder.merchantbankdetail')->with(['pages' => 'AML Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }



    public function allMyArchivedUserList($country, $usertype)
    {

        if ($usertype == "consumers") {
            $data = User::where('accountType', 'Individual')->where('country', $country)->where('archive', 1)->orderBy('created_at', 'DESC')->get();
        } else {
            $data = User::where('accountType', 'Merchant')->where('country', $country)->where('archive', 1)->orderBy('created_at', 'DESC')->get();
        }
    }

    public function archivedaccountUsersByCountry($usertype)
    {

        if (session('role') == 'Customer Marketing') {

            if (session('country') == "Canada") {
                if ($usertype == "consumers") {
                    $data = User::where('accountType', 'Individual')->where('archive', 1)->where('country', 'Canada')->orWhere('country', 'United States')->groupBy('country')->get();
                } else {
                    $data = User::where('accountType', 'Merchant')->where('archive', 1)->where('country', 'Canada')->orWhere('country', 'United States')->groupBy('country')->get();
                }
            } else {
                if ($usertype == "consumers") {
                    $data = User::where('accountType', 'Individual')->where('archive', 1)->where('country', session('country'))->groupBy('country')->get();
                } else {
                    $data = User::where('accountType', 'Merchant')->where('archive', 1)->where('country', session('country'))->groupBy('country')->get();
                }
            }
        } else {
            if ($usertype == "consumers") {
                $data = User::where('accountType', 'Individual')->where('archive', 1)->groupBy('country')->get();
            } else {
                $data = User::where('accountType', 'Merchant')->where('archive', 1)->groupBy('country')->get();
            }
        }




        return $data;
    }






    public function merchantBankDetailsByCountryAml(Request $req)
    {
        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing") {
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
            } else {
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

            $data = array(
                'bankdetail' => $this->userBankDetailByCountry(),
            );



            return view('aml.wallet.merchantbankdetailbycountry')->with(['pages' => 'AML Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }



    public function bankrequestwithdrawalbycountry(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing") {
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
            } else {
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

            $data = array(
                'bankRequestWithdrawal' => $this->requestFromBankWithdrawalByCountry($req->get('country')),
            );



            return view('aml.amlsuplinkfolder.bankrequestwithdrawalbycountry')->with(['pages' => 'AML Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
            // } else {
            //     return redirect()->route('AdminLogin');
        }
    }

    public function requestFromBankWithdrawalByCountry($country)
    {

        $data = BankWithdrawal::where('status', 'PENDING')->where('country', $country)->orderBy('created_at', 'DESC')->get();

        return $data;
    }




    public function userBankDetail($country)
    {

        $data = AddBank::where('country', $country)->orderBy('created_at', 'DESC')->get();

        return $data;
    }

    public function requestForRefund()
    {

        $data = RequestRefund::where('status', '!=', 'PROCESSED')->groupBy('country')->orderBy('created_at', 'DESC')->get();

        return $data;
    }



    public function requestForAllRefund()
    {

        $data = RequestRefund::where('status', '!=', 'PROCESSED')->orderBy('created_at', 'DESC')->get();

        return $data;
    }
    public function requestForRefundByCountry($country)
    {

        $data = RequestRefund::where('status', '!=', 'PROCESSED')->where('country', $country)->orderBy('created_at', 'DESC')->get();

        return $data;
    }

    public function bankingInformation()
    {
        $data = array(
            'activity' => $this->userActivity()
        );

        $transCost = $this->transactionCost();
        $allusers = $this->allUsers();

        $withdraws = [
            'bank' => $this->requestFromBankWithdrawal(),
            'purchase' => $this->purchaseRefundSentback(),
            'credit' => $this->requestFromCardWithdrawal(),
            'prepaid' => $this->pendingRequestFromPrepaidWithdrawal(),
            // 'specialInfo' => $this->getthisInfo(session('country')),
        ];

        $pending = [
            'transfer' => $this->pendingTransferTransactions(),
            'texttotransfer' => $this->textToTransferUsers(),
        ];

        $refund = [
            'requestforrefund' => $this->requestForAllRefund(),
        ];

        $allcountries = $this->getAllCountries();

        $received = [
            'payInvoice' => $this->payInvoice(session('email')),
        ];

        $data = array(
            'getuserDetail' => $this->getmyPersonalDetail(session('user_id')),
            'getbusinessDetail' => $this->getmyBusinessDetail(session('user_id')),
            'merchantservice' => $this->_merchantServices(),
            'getCard' => $this->getUserCard(session('myID')),
            'getBank' => $this->getUserBank(session('myID')),
            'getTax' => $this->getTax(session('myID')),
            'listbank' => $this->getBankList(),
            'escrowfund' => $this->getEscrowFunding(),
        );


        return view('aml.bankinginformation')->with(['pages' => 'AML Dashboard', 'data' => $data, 'received' => $received, 'withdraws' => $withdraws, 'pending' => $pending, 'refund' => $refund, 'allusers' => $allusers, 'transCost' => $transCost, 'data' => $data]);
    }

    // public function bankingInformation()
    // {
    //     $data = array(
    //         'activity' => $this->userActivity()
    //     );


    //     return view('aml.amlsuplinkfolder.bankinginformation')->with(['data' => $data]);
    // }

    public function transactionAnalysis()
    {
        $data = array(
            'activity' => $this->userActivity()
        );

        $transCost = $this->transactionCost();



        return view('aml.amlsuplinkfolder.transactionanalysis')->with(['pages' => 'AML Dashboard', 'transCost' => $transCost, 'data' => $data]);
    }
    public function transactionAnalysisSubPage()
    {
        $data = array(
            'activity' => $this->userActivity()
        );

        $transCost = $this->transactionCost();



        return view('aml.amlsuplinkfolder.transactionanalysissubpage')->with(['pages' => 'AML Dashboard', 'transCost' => $transCost, 'data' => $data]);
    }

    public function complianceDeskReview()
    {
        $data = array(
            'activity' => $this->userActivity()
        );

        $transCost = $this->transactionCost();


        return view('aml.amlsuplinkfolder.compliancedeskreview')->with(['pages' => 'AML Dashboard', 'transCost' => $transCost, 'data' => $data]);
    }
    public function complianceDeskReviewSubPage()
    {
        $data = array(
            'activity' => $this->userActivity()
        );

        $transCost = $this->transactionCost();


        return view('aml.amlsuplinkfolder.compliancedeskreviewsubpage')->with(['pages' => 'AML Dashboard', 'transCost' => $transCost, 'data' => $data]);
    }

    public function viewDocument()
    {
        $data = array(
            'activity' => $this->userActivity()
        );

        $transCost = $this->transactionCost();

        return view('aml.amlsuplinkfolder.viewdocument')->with(['pages' => 'AML Dashboard', 'transCost' => $transCost, 'data' => $data]);
    }

    public function viewKycKybReport()
    {
        $data = array(
            'activity' => $this->userActivity()
        );

        $transCost = $this->transactionCost();

        return view('aml.amlsuplinkfolder.viewkyckybreport')->with([ 'pages' => 'AML Dashboard', 'transCost' => $transCost, 'data' => $data]);
    }

    public function viewComplianceInformation()
    {
        $data = array(
            'activity' => $this->userActivity()
        );

        $transCost = $this->transactionCost();

        return view('aml.amlsuplinkfolder.viewcomplianceinformation')->with(['pages' => 'AML Dashboard',  'transCost' => $transCost, 'data' => $data]);
    }

    public function viewIndustry()
    {
        $data = array(
            'activity' => $this->userActivity()
        );

        $transCost = $this->transactionCost();

        return view('aml.amlsuplinkfolder.viewindustry')->with(['pages' => 'AML Dashboard', 'transCost' => $transCost, 'data' => $data]);
    }

    public function linkedAccount()
    {
        $data = array(
            'activity' => $this->userActivity()
        );

        $transCost = $this->transactionCost();

        return view('aml.amlsuplinkfolder.linkedaccount')->with(['pages' => 'AML Dashboard', 'transCost' => $transCost, 'data' => $data]);
    }

    public function connectedAccounts()
    {
        $data = array(
            'activity' => $this->userActivity()
        );

        $transCost = $this->transactionCost();

        return view('aml.amlsuplinkfolder.connectedaccounts')->with(['pages' => 'AML Dashboard', 'transCost' => $transCost, 'data' => $data]);
    }

    public function compliance()
    {
        $data = array(
            'activity' => $this->userActivity()
        );


        return view('aml.amlsuplinkfolder.compliance')->with(['data' => $data]);
    }
    public function view()
    {
        $data = array(
            'activity' => $this->userActivity()
        );


        return view('aml.amlsuplinkfolder.view')->with(['data' => $data]);
    }
    public function upload()
    {
        $data = array(
            'activity' => $this->userActivity()
        );


        return view('aml.amlsuplinkfolder.upload')->with(['data' => $data]);
    }

    public function suspiciousTransaction()
    {
        $data = array(
            'activity' => $this->userActivity()
        );


        return view('aml.amlsuplinkfolder.suspicioustransaction')->with(['data' => $data]);
    }

    // public function topUpRedFlagged(){
    //     $data = array(
    //         'activity' => $this->userActivity()
    //     );


    //     return view('aml.amlsuplinkfolder.topupredflagged')->with(['data' => $data]);
    // }
    public function topUpRedFlagged(Request $req)
    {


        $data = array(
            'activity' => $this->userActivity()
        );

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing") {
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
            } else {
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

            $data = array(
                'flaggedUsers' => $this->getFlaggedUsers(),
            );





            return view('aml.amlsuplinkfolder.topupredflagged')->with(['pages' => 'AML Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'data' => $data]);
        } else {
            return view('aml.amlsuplinkfolder.topupredflagged');
        }
    }

    public function getFlaggedUsers()
    {
        $data = User::where('flagged', 1)->orderBy('created_at', 'DESC')->get();

        return $data;
    }



    public function userActivity()
    {

        if (session('role') == "Customer Marketing") {
            $data = Notifications::where('country', 'Canada')->orWhere('country', 'United States')->orderBy('created_at', 'DESC')->take(1000)->get();
        } else {
            $data = Notifications::orderBy('created_at', 'DESC')->take(1000)->get();
        }

        return $data;
    }

    // Get Tranasaction cost
    public function transactionCost()
    {
        $getCost = TransactionCost::orderBy('created_at', 'DESC')->get();

        return $getCost;
    }

    public function allUsers()
    {
        $data = User::orderBy('created_at', 'DESC')->get();

        return $data;
    }

    public function getmyPersonalDetail($ref_code)
    {
        $data = User::where('ref_code', $ref_code)->first();

        return $data;
    }

    public function getUserCard($id)
    {

        $data = AddCard::where('user_id', $id)->orderBy('created_at', 'DESC')->get();

        return $data;
    }

    public function getUserBank($id)
    {

        $data = AddBank::where('user_id', $id)->orderBy('created_at', 'DESC')->get();

        return $data;
    }

    public function getTax($id)
    {
        $data = Tax::where('user_id', $id)->orderBy('created_at', 'DESC')->get();

        return $data;
    }

    public function requestFromBankWithdrawal()
    {

        $data = BankWithdrawal::where('status', 'PENDING')->orderBy('created_at', 'DESC')->groupBy('country')->get();

        return $data;
    }

    public function purchaseRefundSentback()
    {

        $data = Statement::where('refund_state', 1)->where('actedOn', 0)->orderBy('created_at', 'DESC')->get();

        return $data;
    }

    public function requestFromCardWithdrawal()
    {

        $data = CcWithdrawal::where('status', 'PENDING')->orderBy('created_at', 'DESC')->groupBy('country')->get();

        return $data;
    }

    public function pendingRequestFromPrepaidWithdrawal()
    {

        // RUN CRON GET

        // $access_key = '6173fa628b16d8ce1e0db5cfa25092ac';

        if (env('APP_ENV') == "local") {
            $url = "http://localhost:4000/api/v1/paysprint/pendingloadcardrequest";
        } else {
            $url = "https://exbc.ca/api/v1/paysprint/pendingloadcardrequest";
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer base64:HgMO6FDHGziGl01OuLH9mh7CeP095shB6uuDUUClhks='
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $result = json_decode($response);


        return $result;
    }

    public function specialInformationData()
    {

        $data = $this->getInfo();

        return $data;
    }

    public function pendingTransferTransactions()
    {

        $data = Statement::where('status', 'Pending')->where('country', '!=', null)->orderBy('created_at', 'DESC')->groupBy('country')->get();

        return $data;
    }

    public function textToTransferUsersByCountry($country)
    {

        $data = AnonUsers::where('country', $country)->orderBy('created_at', 'DESC')->get();

        return $data;
    }



    public function getAllCountries()
    {
        $data = AllCountries::orderBy('approval', 'DESC')->get();

        return $data;
    }

    public function payInvoice($email)
    {
        $mydata = ImportExcel::select('import_excel.*', 'invoice_payment.*')->join('invoice_payment', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')->where('import_excel.payee_email', $email)->orderBy('import_excel.created_at', 'DESC')->limit(5)->get();

        if (count($mydata) > 0) {
            $newdata = ImportExcel::where('payee_email', $email)->where('payment_status', 0)->orderBy('created_at', 'DESC')->limit(5)->get();
            $data = array_merge($mydata->toArray(), $newdata->toArray());
        } else {
            $data = ImportExcel::where('payee_email', $email)->orderBy('created_at', 'DESC')->limit(5)->get();
        }

        // dd($data);
        return json_encode($data);
    }

    public function getmyBusinessDetail($user_id)
    {
        $data = Clientinfo::where('user_id', $user_id)->first();

        return $data;
    }

    public function _merchantServices()
    {
        $data = MerchantService::all();

        return $data;
    }

    public function textToTransferUsers()
    {

        $data = AnonUsers::orderBy('created_at', 'DESC')->groupBy('country')->get();

        return $data;
    }
}