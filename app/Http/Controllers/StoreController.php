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

use App\BVNVerificationList as BVNVerificationList;

use App\AnonUsers as AnonUsers;



use App\RequestRefund as RequestRefund;

use App\MonthlyFee as MonthlyFee;

use App\Tax as Tax;

use App\AllCountries as AllCountries;
use App\EscrowAccount;
use App\FxStatement;
use App\InAppMessage as InAppMessage;


use App\InvoiceCommission;
use App\StoreMainShop;
use App\StoreCategory;
use App\MonerisActivity as MonerisActivity;

use App\SupportActivity as SupportActivity;


use App\UserClosed as UserClosed;

use App\PricingSetup as PricingSetup;

use App\MailCampaign as MailCampaign;
use App\MarkUp;

use App\Aml_compliance_guide;

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

class StoreController extends Controller
{
    //
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
                // 'listbank' => $this->getBankList(),
                // 'escrowfund' => $this->getEscrowFunding(),
            );





            return view('estore.index')->with(['pages' => 'Estore Dashboard', 'data' => $data, 'received' => $received, 'withdraws' => $withdraws, 'pending' => $pending, 'refund' => $refund, 'allusers' => $allusers, 'invoiceImport' => $invoiceImport , 'payInvoice' => $payInvoice, 'invoiceLinkImport' => $invoiceLinkImport, 'transCost' => $transCost]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }

    // Get Tranasaction cost
    public function transactionCost()
    {
        $getCost = TransactionCost::orderBy('created_at', 'DESC')->get();

        return $getCost;
    }

    //review e-store
    public function reviewStore(Request $req)
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
                'stores' => $this->getStores(),
                // 'listbank' => $this->getBankList(),
                // 'escrowfund' => $this->getEscrowFunding(),
            );





            return view('estore.reviewstore')->with(['pages' => 'Estore Dashboard', 'data' => $data, 'received' => $received, 'withdraws' => $withdraws, 'pending' => $pending, 'refund' => $refund, 'allusers' => $allusers, 'invoiceImport' => $invoiceImport , 'payInvoice' => $payInvoice, 'invoiceLinkImport' => $invoiceLinkImport, 'transCost' => $transCost]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }

    public function getStores(){
        $store=StoreMainShop::get();
        return $store;

    }

    //store products
    public function productsCategory(Request $req)
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
                'products' => $this->getEstoreCategory(),
                // 'listbank' => $this->getBankList(),
                // 'escrowfund' => $this->getEscrowFunding(),
            );





            return view('estore.storeproducts')->with(['pages' => 'Estore Dashboard', 'data' => $data, 'received' => $received, 'withdraws' => $withdraws, 'pending' => $pending, 'refund' => $refund, 'allusers' => $allusers, 'invoiceImport' => $invoiceImport , 'payInvoice' => $payInvoice, 'invoiceLinkImport' => $invoiceLinkImport, 'transCost' => $transCost]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }

    //EDIT Store
    public function editStore(Request $req, $id)
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
                'store'=> StoreMainShop::where('id',$id)->first(),
                // 'listbank' => $this->getBankList(),
                // 'escrowfund' => $this->getEscrowFunding(),
            );





            return view('estore.editstore')->with(['pages' => 'Estore Dashboard', 'data' => $data, 'received' => $received, 'withdraws' => $withdraws, 'pending' => $pending, 'refund' => $refund, 'allusers' => $allusers, 'invoiceImport' => $invoiceImport , 'payInvoice' => $payInvoice, 'invoiceLinkImport' => $invoiceLinkImport, 'transCost' => $transCost]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }

        //update Store
    
    public function updateStore(Request $req, $id){
        $getStore = StoreMainShop::where('id', $id)->first();
            
        $docPath = $getPost;

        if($req->hasFile('businesslogo')){
            //Get filename with extension
        $filenameWithExt = $req->file('businesslogo')->getClientOriginalName();
        // Get just filename
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        // Get just extension
        $extension = $req->file('businesslogo')->getClientOriginalExtension();
        // Filename to store
        $fileNameToStore = rand() . '_' . time() . '.' . $extension;


        $path = $req->file('businesslogo')->move(public_path('../../investorreldocs/'), $fileNameToStore);


        $docPath = "http://" . $_SERVER['HTTP_HOST'] . "/investorreldocs/" . $fileNameToStore;
        }

        $post=StoreMainShop::where('id', $id)->update([
        'ref_code' => $req->reference_code,
       'post_title' => $req->post_title,
        'description' => $req->description,
        'minimum_acount' => $req->minimum_amount,
        'locked_in_return' => $req->locked_return,
        'term' => $req->term,
        'liquidation_amouunt' => $req->liquidation_amouunt,
        'offer_open_date' => $req->offer_open_date,
        'offer_end_date' => $req->offer_end_date,
        'investment_activation_date' => $req->investment_activation_date,
        'investment_document' => $docPath
        ]);

        return back()->with("msg", "<div class='alert alert-success'>Post Updated Successfully</div>");

    }
    public function getEstoreCategory(){
        $products=StoreCategory::all();
        return $products;
    }
    //feedback
     public function feedback(Request $req)
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
                 // 'listbank' => $this->getBankList(),
                 // 'escrowfund' => $this->getEscrowFunding(),
             );
 
 
 
 
 
             return view('estore.feedback')->with(['pages' => 'Estore Dashboard', 'data' => $data, 'received' => $received, 'withdraws' => $withdraws, 'pending' => $pending, 'refund' => $refund, 'allusers' => $allusers, 'invoiceImport' => $invoiceImport , 'payInvoice' => $payInvoice, 'invoiceLinkImport' => $invoiceLinkImport, 'transCost' => $transCost]);
         } else {
             return redirect()->route('AdminLogin');
         }
     }

     //Refund and Dispute
     public function refundDisputeReport(Request $req)
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
                 // 'listbank' => $this->getBankList(),
                 // 'escrowfund' => $this->getEscrowFunding(),
             );
 
 
 
 
 
             return view('estore.refundanddispute')->with(['pages' => 'Estore Dashboard', 'data' => $data, 'received' => $received, 'withdraws' => $withdraws, 'pending' => $pending, 'refund' => $refund, 'allusers' => $allusers, 'invoiceImport' => $invoiceImport , 'payInvoice' => $payInvoice, 'invoiceLinkImport' => $invoiceLinkImport, 'transCost' => $transCost]);
         } else {
             return redirect()->route('AdminLogin');
         }
     }

        //expiredotp
      public function expiredOtp(Request $req)
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
                  // 'listbank' => $this->getBankList(),
                  // 'escrowfund' => $this->getEscrowFunding(),
              );
  
  
  
  
  
              return view('estore.expiredotp')->with(['pages' => 'Estore Dashboard', 'data' => $data, 'received' => $received, 'withdraws' => $withdraws, 'pending' => $pending, 'refund' => $refund, 'allusers' => $allusers, 'invoiceImport' => $invoiceImport , 'payInvoice' => $payInvoice, 'invoiceLinkImport' => $invoiceLinkImport, 'transCost' => $transCost]);
          } else {
              return redirect()->route('AdminLogin');
          }
      }
        //All Users
    public function allUsers()
    {
        $data = User::orderBy('created_at', 'DESC')->get();

        return $data;
    }

    //Get my personal details
    public function getmyPersonalDetail($ref_code)
    {
        $data = User::where('ref_code', $ref_code)->first();

        return $data;
    }

    //Get User Card
    public function getUserCard($id)
    {

        $data = AddCard::where('user_id', $id)->orderBy('created_at', 'DESC')->get();

        return $data;
    }

    //Get User Bank
    public function getUserBank($id)
    {

        $data = AddBank::where('user_id', $id)->orderBy('created_at', 'DESC')->get();

        return $data;
    }

        //Get Tax
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

    public function pendingTransferTransactions()
    {

        $data = Statement::where('status', 'Pending')->where('country', '!=', null)->orderBy('created_at', 'DESC')->groupBy('country')->get();

        return $data;
    }

    public function textToTransferUsers()
    {

        $data = AnonUsers::orderBy('created_at', 'DESC')->groupBy('country')->get();

        return $data;
    }

    public function requestForAllRefund()
    {

        $data = RequestRefund::where('status', '!=', 'PROCESSED')->orderBy('created_at', 'DESC')->get();

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


}
