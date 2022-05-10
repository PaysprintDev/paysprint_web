<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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
use App\StoreDelivery;
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





            return view('estore.index')->with(['pages' => 'Estore Dashboard', 'data' => $data, 'received' => $received, 'withdraws' => $withdraws, 'pending' => $pending, 'refund' => $refund, 'allusers' => $allusers, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'invoiceLinkImport' => $invoiceLinkImport, 'transCost' => $transCost]);
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





            return view('estore.reviewstore')->with(['pages' => 'Estore Dashboard', 'data' => $data, 'received' => $received, 'withdraws' => $withdraws, 'pending' => $pending, 'refund' => $refund, 'allusers' => $allusers, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'invoiceLinkImport' => $invoiceLinkImport, 'transCost' => $transCost]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }

    //suspended stores
    public function suspendedStores(Request $req)
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
                'stores' => StoreMainShop::onlyTrashed()->get(),
                // 'listbank' => $this->getBankList(),
                // 'escrowfund' => $this->getEscrowFunding(),
            );

               




            return view('estore.suspendedstore')->with(['pages' => 'Estore Dashboard', 'data' => $data, 'received' => $received, 'withdraws' => $withdraws, 'pending' => $pending, 'refund' => $refund, 'allusers' => $allusers, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'invoiceLinkImport' => $invoiceLinkImport, 'transCost' => $transCost]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }
        //view images
    public function viewImages(Request $req, $id){
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
                'images' => StoreMainShop::where('id',$id)->first(),
                // 'listbank' => $this->getBankList(),
                // 'escrowfund' => $this->getEscrowFunding(),
            );



            return view('estore.viewimages')->with(['pages' => 'Estore Dashboard', 'data' => $data, 'received' => $received, 'withdraws' => $withdraws, 'pending' => $pending, 'refund' => $refund, 'allusers' => $allusers, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'invoiceLinkImport' => $invoiceLinkImport, 'transCost' => $transCost]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }
        //advert images
        public function viewAdvertImages(Request $req, $id){
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
                    'images' => StoreMainShop::where('id',$id)->first(),
                    // 'listbank' => $this->getBankList(),
                    // 'escrowfund' => $this->getEscrowFunding(),
                );



                return view('estore.viewimages')->with(['pages' => 'Estore Dashboard', 'data' => $data, 'received' => $received, 'withdraws' => $withdraws, 'pending' => $pending, 'refund' => $refund, 'allusers' => $allusers, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'invoiceLinkImport' => $invoiceLinkImport, 'transCost' => $transCost]);
            } else {
                return redirect()->route('AdminLogin');
            }
        }

        //get stores
    public function getStores()
    {
        $store = StoreMainShop::get();
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





            return view('estore.storeproducts')->with(['pages' => 'Estore Dashboard', 'data' => $data, 'received' => $received, 'withdraws' => $withdraws, 'pending' => $pending, 'refund' => $refund, 'allusers' => $allusers, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'invoiceLinkImport' => $invoiceLinkImport, 'transCost' => $transCost]);
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
                'store' => StoreMainShop::where('id', $id)->first(),
                // 'listbank' => $this->getBankList(),
                // 'escrowfund' => $this->getEscrowFunding(),
            );





            return view('estore.editstore')->with(['pages' => 'Estore Dashboard', 'data' => $data, 'received' => $received, 'withdraws' => $withdraws, 'pending' => $pending, 'refund' => $refund, 'allusers' => $allusers, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'invoiceLinkImport' => $invoiceLinkImport, 'transCost' => $transCost]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }

    //delete store
    public function deleteStore(Request $req, $id){

        $data=StoreMainShop::where('id', $id)->delete();

        return back()->with("msg","<div class='alert alert-success'>Store Suspended Successfully</div>");
    }

    //restore store
    public function restoreStore(Request $req, $id){

        $data=StoreMainShop::withTrashed()->find($id)->restore();

        return back()->with("msg","<div class='alert alert-success'>Store Suspended Successfully</div>");
    }

    //delete productCategory
    public function deleteCategory(Request $req, $id){

        $data=StoreCategory::where('id', $id)->delete();

        return back()->with("msg","<div class='alert alert-success'>Category Deleted Successfully</div>");
    }

    //update Store

    public function updateStore(Request $req, $id)
    {

        try {

            // Validate
            $validator = Validator::make($req->all(), [
                'headerTitle' => 'required',
                'headerSubtitle' => 'required',
                'refundpolicy' => 'required'
            ]);





            if ($validator->passes()) {

                $storeId = StoreMainShop::where('id', $id)->first();

                $thisuser = User::where('id', $storeId->merchantId)->first();


                $routing = $thisuser->businessname . "/estore";

                $headContentImage = '';
                $advertSectionImage = '';





                if($req->hasFile('businessLogo')){
                    $businessLogo = $this->uploadImageFile($req->file('businessLogo'), $routing . "/logo");
                }
                else{
                    $businessLogo = $storeId->businessLogo;
                }


                if ($req->hasFile('headerContent') && count($req->file('headerContent')) > 0) {

                    if (count($req->file('headerContent')) > 3) {
                        return redirect()->back()->with("msg", "<div class='alert alert-danger'>Your header content file is more than 3</div>");
                    } else {
                        if (count($req->file('headerContent')) > 1) {

                            foreach ($req->file('headerContent') as $headerContentFile) {

                                $headContentImage .= $this->uploadImageFile($headerContentFile, $routing . "/headsection") . ", ";
                            }
                        } else {
                            $headContentImage = $this->uploadImageFile($req->file('headerContent'), $routing . "/headsection");
                        }
                    }
                }
                else{
                    $headContentImage = $storeId->headerContent;
                }




                if ($req->hasFile('advertimage') && count($req->file('advertimage')) > 0) {

                    if (count($req->file('advertimage')) > 3) {
                        return redirect()->back()->with("msg", "<div class='alert alert-danger'>Your header content file is more than 3</div>");
                    } else {
                        if (count($req->file('advertimage')) > 1) {

                            foreach ($req->file('advertimage') as $advertSectionFile) {

                                $advertSectionImage .= $this->uploadImageFile($advertSectionFile, $routing . "/advertsection") . ", ";
                            }
                        } else {
                            $advertSectionImage = $this->uploadImageFile($req->file('advertimage'), $routing . "/advertsection");
                        }
                    }
                }
                else{
                    $advertSectionImage = $storeId->advertSectionImage;
                }



                $data = StoreMainShop::where('id', $id)->update([
                    'businessLogo' => $businessLogo,
                    'headerContent' => $headContentImage,
                    'headerTitle' => $req->headerTitle,
                    'headerSubtitle' => $req->headerSubtitle,
                    'advertSectionImage' => $advertSectionImage,
                    'advertTitle' => $req->advertTitle,
                    'advertSubtitle' => $req->advertSubtitle,
                    'refundPolicy' => $req->refundpolicy
                ]);

                $status = 'success';
                $message = "Successfully stored";
            }
            else{
                $status = 'error';
                $message = implode(",", $validator->messages()->all());
            }

        } catch (\Throwable $th) {
            $status = 'error';
            $message = $th->getMessage();
        }

        return redirect()->route('review e-store')->with($status, $message);
    }

    public function uploadImageFile($file, $fileroute)
    {
        //Get filename with extension
        $filenameWithExt = $file->getClientOriginalName();
        // Get just filename
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        // Get just extension
        $extension = $file->getClientOriginalExtension();
        // Filename to store
        $fileNameToStore = rand() . '_' . time() . '.' . $extension;


        $file->move(public_path('../../shopstore/' . $fileroute . '/'), $fileNameToStore);


        $docPath = route('home') . "/shopstore/" . $fileroute . "/" . $fileNameToStore;

        return $docPath;
    }
    public function getEstoreCategory()
    {
        $products = StoreCategory::all();
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





            return view('estore.feedback')->with(['pages' => 'Estore Dashboard', 'data' => $data, 'received' => $received, 'withdraws' => $withdraws, 'pending' => $pending, 'refund' => $refund, 'allusers' => $allusers, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'invoiceLinkImport' => $invoiceLinkImport, 'transCost' => $transCost]);
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





            return view('estore.refundanddispute')->with(['pages' => 'Estore Dashboard', 'data' => $data, 'received' => $received, 'withdraws' => $withdraws, 'pending' => $pending, 'refund' => $refund, 'allusers' => $allusers, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'invoiceLinkImport' => $invoiceLinkImport, 'transCost' => $transCost]);
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
                'otp' => StoreDelivery::all(),
                // 'listbank' => $this->getBankList(),
                // 'escrowfund' => $this->getEscrowFunding(),
            );





            return view('estore.expiredotp')->with(['pages' => 'Estore Dashboard', 'data' => $data, 'received' => $received, 'withdraws' => $withdraws, 'pending' => $pending, 'refund' => $refund, 'allusers' => $allusers, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'invoiceLinkImport' => $invoiceLinkImport, 'transCost' => $transCost]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }

    //editing products category on e-store

    public function editCategory(Request $req, $id)
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
                'category' => storeCategory::where('id', $id)->first(),
                // 'listbank' => $this->getBankList(),
                // 'escrowfund' => $this->getEscrowFunding(),
            );





            return view('estore.editcategory')->with(['pages' => 'Estore Dashboard', 'data' => $data, 'received' => $received, 'withdraws' => $withdraws, 'pending' => $pending, 'refund' => $refund, 'allusers' => $allusers, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'invoiceLinkImport' => $invoiceLinkImport, 'transCost' => $transCost]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }

    //updating product category on e-store

    public function updateCategory(Request $req, $id)
    {

        $validator=Validator::make($req->all(), [
            'category_name' => 'required',
        ]);

        if( $validator -> passes()){

        StoreCategory::where('id', $id)->update([
         'category' => $req->category_name,
        ]);
        }else{

        }

        return back()->with("msg", "<div class='alert alert-success'> Category Name updated Successfully</div>");
    }

    //function to update category state
    public function updateState(Request $req, $id)
    {



            $catState = $req->category_state == 1 ? false : true;

            $data=StoreCategory::where('id', $id)->update(['state' => $catState]);


        return back()->with("msg", "<div class='alert alert-success'> Category State updated Successfully</div>");
    }

    //function to activate /de-activate store
    public function activateStore(Request $req, $id)
    {

            $storeStatus = $req->status == 'not active' ? 'active' : 'not active';

            $data=StoreMainShop::where('id', $id)->update(['status' => $storeStatus]);


        return back()->with("msg", "<div class='alert alert-success'> Store Status updated Successfully</div>");
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
