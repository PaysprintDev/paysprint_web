<?php

namespace App\Http\Controllers;

use Session;

use App\MarkUp;
use App\Points;
use App\PromoDate;
use App\MarketplaceNews;
use App\TrialDate;
use App\watchlist;
use App\merchantTrial;

use Carbon\Carbon;

use App\Tax as Tax;
use App\FxStatement;
use App\SurveyExcel;
//Session
use App\Traits\MyFX;
use App\Traits\UserManagement;

use App\InvestorPost;

use App\SpecialPromo;

use App\SurveyReport;

use App\User as User;

use App\Walletcredit;

use App\ClaimedPoints;

use App\EscrowAccount;

use App\HistoryReport;

use App\ReferralClaim;

use App\ReferredUsers;

use App\DusupaymentReferences;

use App\Admin as Admin;

use App\Mail\sendEmail;

use App\Traits\Trulioo;

use App\InvestorRelation;

use App\ReferralGenerate;

use App\Traits\Xwireless;

use App\InvoiceCommission;

use App\AddBank as AddBank;

use App\AddCard as AddCard;

use App\SpecialpromoReport;

use App\Traits\FlagPayment;

use App\Traits\GenerateOtp;
use App\Traits\PointsClaim;

use App\Traits\SpecialInfo;

use Illuminate\Http\Request;

use App\Imports\SurveyImport;

use App\Imports\MerchantImport;

use App\Traits\AccountNotify;

use App\Traits\PointsHistory;

use App\Traits\DusuPay;

use App\ThirdPartyIntegration;

use App\Traits\PaymentGateway;

use App\Traits\PaysprintPoint;

use App\AnonUsers as AnonUsers;

use App\PlatformPaymentGateway;

use App\Statement as Statement;

use App\Traits\PaystackPayment;

use App\CardIssuer as CardIssuer;
use App\ClientInfo as ClientInfo;
use App\Createpost as Createpost;
use App\MonthlyFee as MonthlyFee;
use App\SuperAdmin as SuperAdmin;
use App\UserClosed as UserClosed;
use Illuminate\Support\Collection;

use Illuminate\Support\Facades\DB;

use App\CashAdvance as CashAdvance;
use App\CreateEvent as CreateEvent;

use App\CrossBorder as CrossBorder;

use App\ImportExcel as ImportExcel;

use App\UnverifiedMerchant;

use App\ServiceType as ServiceType;

use App\Traits\MailChimpNewsLetter;

use App\UpgradePlan as UpgradePlan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


use Illuminate\Support\Facades\Mail;

use Maatwebsite\Excel\Facades\Excel;
use Rap2hpoutre\FastExcel\FastExcel;
use App\AllCountries as AllCountries;

use App\CcWithdrawal as CcWithdrawal;
use App\DeletedCards as DeletedCards;
use App\Epaywithdraw as Epaywithdraw;
use App\InAppMessage as InAppMessage;

use App\MailCampaign as MailCampaign;
use App\PricingSetup as PricingSetup;
use App\Exports\WalletStatementExport;

use App\MobileMoney;

use App\CollectionFee as CollectionFee;

use App\Notifications as Notifications;

use App\PaycaWithdraw as PaycaWithdraw;

use App\RequestRefund as RequestRefund;

use App\BankWithdrawal as BankWithdrawal;

use App\InvoicePayment as InvoicePayment;

use Illuminate\Support\Facades\Validation;

use App\ImportExcelLink as ImportExcelLink;

use App\MerchantService as MerchantService;

use App\MonerisActivity as MonerisActivity;

use App\OrganizationPay as OrganizationPay;

use App\SupportActivity as SupportActivity;
use App\TransactionCost as TransactionCost;
use App\BVNVerificationList as BVNVerificationList;

class AdminController extends Controller
{

    public $to = "info@paysprint.ca";
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

    use Trulioo, AccountNotify, SpecialInfo, PaystackPayment, FlagPayment, PaymentGateway, Xwireless, MailChimpNewsLetter, PaysprintPoint, PointsClaim, PointsHistory, DusuPay,  MyFX, GenerateOtp, UserManagement;


    public function index(Request $req)
    {
        //   dd($req->all);


        if (session('role') == 'Merchant') {

            return redirect()->route('dashboard');
        } elseif (session('role') == 'Aml compliance') {
            return redirect()->route('aml dashboard');
        } elseif (session('role') == 'estore manager') {
            return redirect()->route('store dashboard');
        } else {
            if ($req->session()->has('username') == true) {




                if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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


                // dd(Session::all());


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
                    'specialInfo' => $this->getthisInfo(session('country')),
                ];

                // dd($withdraws);

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
                    'pointsclaim' => $this->getClaimedPoints(),
                    'mypoints' => $this->getAcquiredPoints(session('myID')),
                    'cashadvance' => $this->getCashAdvanceCount(),
                    'crossborder' => $this->getCrossBorderCount(),
                    'paiduserscount' => $this->getPaidUsersCount(),
                    'freeuserscount' => $this->getFreeUsersCount(),
                    'transfer' => $this->electronicTransfers()

                );


                if (isset($req->q)) {

                    $details = User::where('name', 'like', '%' . $req->q . '%')->orWhere('ref_code', 'like', '%' . $req->q . '%')->orWhere('email', 'like', '%' . $req->q . '%')->get();

                    if (count($details) > 0) {
                        $details = $details;
                    } else {
                        $userdetails = UserClosed::where('name', 'like', '%' . $req->q . '%')->orWhere('ref_code', 'like', '%' . $req->q . '%')->orWhere('email', 'like', '%' . $req->q . '%')->get();

                        $details = $userdetails;
                    }



                    //  dd($details);

                    return view('admin.pages.searchuser')->with(['pages' => 'My Dashboard', 'clientPay' => $clientPay, 'searchuser' => $details, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'invoiceLinkImport' => $invoiceLinkImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'transCost' => $transCost, 'allusers' => $allusers, 'getUserDetail' => $getUserDetail, 'getCard' => $getCard, 'getBank' => $getBank, 'getTax' => $getTax, 'withdraws' => $withdraws, 'pending' => $pending, 'allcountries' => $allcountries, 'refund' => $refund, 'received' => $received, 'data' => $data]);
                }





                return view('admin.index')->with(['pages' => 'My Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'invoiceLinkImport' => $invoiceLinkImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'transCost' => $transCost, 'allusers' => $allusers, 'getUserDetail' => $getUserDetail, 'getCard' => $getCard, 'getBank' => $getBank, 'getTax' => $getTax, 'withdraws' => $withdraws, 'pending' => $pending, 'allcountries' => $allcountries, 'refund' => $refund, 'received' => $received, 'data' => $data]);
            } else {
                return redirect()->route('AdminLogin');
            }
        }
    }



    public function smsWirelessPlatform(Request $req)
    {


        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
                $adminUser = Admin::orderBy('created_at', 'DESC')->get();
                $invoiceImport = ImportExcel::orderBy('created_at', 'DESC')->get();
                $payInvoice = DB::table('client_info')
                    ->join('invoice_payment', 'client_info.user_id', '=', 'invoice_payment.client_id')
                    ->orderBy('invoice_payment.created_at', 'DESC')
                    ->get();

                $otherPays = OrganizationPay::orderBy('created_at', 'DESC')->get();
            } else {
                $adminUser = Admin::where('username', session('username'))->get();
                $invoiceImport = ImportExcel::where('uploaded_by', session('user_id'))->orderBy('created_at', 'DESC')->get();
                $payInvoice = InvoicePayment::where('client_id', session('user_id'))->orderBy('created_at', 'DESC')->get();
                $otherPays = OrganizationPay::where('coy_id', session('user_id'))->orderBy('created_at', 'DESC')->get();

                $this->recurBills(session('user_id'));
            }



            $transCost = $this->transactionCost();


            $data = [
                'smsbalance' => $this->getCreditBalance(),
            ];


            return view('admin.xwireless')->with(['pages' => 'My Dashboard', 'transCost' => $transCost, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function getCurrencyRate(Request $req)
    {


        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
                $adminUser = Admin::orderBy('created_at', 'DESC')->get();
                $invoiceImport = ImportExcel::orderBy('created_at', 'DESC')->get();
                $payInvoice = DB::table('client_info')
                    ->join('invoice_payment', 'client_info.user_id', '=', 'invoice_payment.client_id')
                    ->orderBy('invoice_payment.created_at', 'DESC')
                    ->get();

                $otherPays = OrganizationPay::orderBy('created_at', 'DESC')->get();
            } else {
                $adminUser = Admin::where('username', session('username'))->get();
                $invoiceImport = ImportExcel::where('uploaded_by', session('user_id'))->orderBy('created_at', 'DESC')->get();
                $payInvoice = InvoicePayment::where('client_id', session('user_id'))->orderBy('created_at', 'DESC')->get();
                $otherPays = OrganizationPay::where('coy_id', session('user_id'))->orderBy('created_at', 'DESC')->get();

                $this->recurBills(session('user_id'));
            }



            $transCost = $this->transactionCost();


            $data = [
                'currencyrate' => $this->platformcurrencyConvert(),
            ];



            return view('admin.getcurrencyconversion')->with(['pages' => 'My Dashboard', 'transCost' => $transCost, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }
    public function businessPromotion(Request $req)
    {


        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
                $adminUser = Admin::orderBy('created_at', 'DESC')->get();
                $invoiceImport = ImportExcel::orderBy('created_at', 'DESC')->get();
                $payInvoice = DB::table('client_info')
                    ->join('invoice_payment', 'client_info.user_id', '=', 'invoice_payment.client_id')
                    ->orderBy('invoice_payment.created_at', 'DESC')
                    ->get();

                $otherPays = OrganizationPay::orderBy('created_at', 'DESC')->get();
            } else {
                $adminUser = Admin::where('username', session('username'))->get();
                $invoiceImport = ImportExcel::where('uploaded_by', session('user_id'))->orderBy('created_at', 'DESC')->get();
                $payInvoice = InvoicePayment::where('client_id', session('user_id'))->orderBy('created_at', 'DESC')->get();
                $otherPays = OrganizationPay::where('coy_id', session('user_id'))->orderBy('created_at', 'DESC')->get();

                $this->recurBills(session('user_id'));
            }



            $transCost = $this->transactionCost();


            $data = [
                'businesspromote' => $this->getPromotedBusiness(),
            ];



            return view('admin.businesspromotion')->with(['pages' => 'My Dashboard', 'transCost' => $transCost, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }



    public function runEmailCampaign(Request $req)
    {


        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
                $adminUser = Admin::orderBy('created_at', 'DESC')->get();
                $invoiceImport = ImportExcel::orderBy('created_at', 'DESC')->get();
                $payInvoice = DB::table('client_info')
                    ->join('invoice_payment', 'client_info.user_id', '=', 'invoice_payment.client_id')
                    ->orderBy('invoice_payment.created_at', 'DESC')
                    ->get();

                $otherPays = OrganizationPay::orderBy('created_at', 'DESC')->get();
            } else {
                $adminUser = Admin::where('username', session('username'))->get();
                $invoiceImport = ImportExcel::where('uploaded_by', session('user_id'))->orderBy('created_at', 'DESC')->get();
                $payInvoice = InvoicePayment::where('client_id', session('user_id'))->orderBy('created_at', 'DESC')->get();
                $otherPays = OrganizationPay::where('coy_id', session('user_id'))->orderBy('created_at', 'DESC')->get();

                $this->recurBills(session('user_id'));
            }



            $transCost = $this->transactionCost();

            $data = [
                'mailcampaign' => $this->mycreatedMailCampaign(),
            ];


            return view('admin.runmailcampaign')->with(['pages' => 'My Dashboard', 'transCost' => $transCost, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function mycreatedMailCampaign()
    {
        $data = MailCampaign::orderBy('created_at', 'DESC')->get();

        return $data;
    }

    public function getmyPersonalDetail($ref_code)
    {
        $data = User::where('ref_code', $ref_code)->first();

        return $data;
    }



    public function usersInCountry($country)
    {
        $data = User::where('country', $country)->orderBy('created_at', 'DESC')->get();

        return $data;
    }


    public function getmyBusinessDetail($user_id)
    {
        $data = Clientinfo::where('user_id', $user_id)->first();

        return $data;
    }
    public function Otherpay(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
            return view('admin.otherpays')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'transCost' => $transCost]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }

    public function remittance(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

            return view('admin.remittance')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }



    public function clientfeereport(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

            return view('admin.clientfeereport')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }



    public function collectionfee(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

            return view('admin.collectionfee')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function comissionreport(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

            return view('admin.comissionreport')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function customer(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

            return view('admin.customer')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '']);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function linkCustomer(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
            $getCustomer = $this->getLinkCustomer($req->route('id'));

            return view('admin.linkcustomer')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '']);
        } else {
            return redirect()->route('AdminLogin');
        }
    }



    public function invoiceComment(Request $req, $id)
    {
        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
                $adminUser = Admin::orderBy('created_at', 'DESC')->get();
                $invoiceImport = ImportExcel::where('id', $id)->first();
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
                $invoiceImport = ImportExcel::where('id', $id)->first();
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

            return view('admin.invoicecomment')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '']);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function invoiceLinkComment(Request $req, $id)
    {
        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
                $adminUser = Admin::orderBy('created_at', 'DESC')->get();
                $invoiceImport = ImportExcel::where('id', $id)->first();
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
                $invoiceImport = ImportExcel::where('id', $id)->first();
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
            $getCustomer = $this->getLinkCustomer($req->route('id'));

            return view('admin.invoicelinkcomment')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '']);
        } else {
            return redirect()->route('AdminLogin');
        }
    }





    public function xpaytrans(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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


            return view('admin.xpaytrans')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function pricingSetup(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'byStructure' => TransactionCost::select('structure')->groupBy('structure')->get(),
                'byMethod' => TransactionCost::select('method')->groupBy('method')->get(),
            );




            return view('admin.pricingsetup')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }



    public function pricingSetupByCountry(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'byStructure' => TransactionCost::select('structure')->groupBy('structure')->get(),
                'byMethod' => TransactionCost::select('method')->groupBy('method')->get(),
                'pricingByCountry' => $this->getPricingByCountry(),
            );






            return view('admin.pricingsetupbycountry')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function pendingKybByCountry(Request $req)
    {
        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'merchantByCountry' => $this->getPendingMerchantByCountry(),
            );


            return view('admin.kybpending')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function pendingKyb(Request $req)
    {
        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'pendingkyb' => $this->getPendingKYB($req->get('country')),
            );


            return view('admin.kybpendingfromcountry')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function completedKyb(Request $req)
    {
        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'completedkyb' => $this->getCompletedKYB($req->get('country')),
            );


            return view('admin.kybcompletedfromcountry')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function completedKybByCountry(Request $req)
    {
        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'merchantByCountry' => $this->getCompletedMerchantByCountry(),
            );


            return view('admin.kybcompleted')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function industryCategoryByCountry(Request $req)
    {
        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'industryByCountry' => $this->getIndustryByCountry(),
            );


            return view('admin.industrycategory')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function industryCategory(Request $req)
    {
        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'industryCategory' => $this->getIndustry($req->get('country')),
            );


            return view('admin.industrycategoryfromcountry')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function markupCurrencyConversion(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'percentage' => $this->markupPercentage()
            );




            return view('admin.markupconversion')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function investorPost(Request $req)
    {
        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'users' => $this->investor_relations()
            );;
            return view('admin.investorpost')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function newInvestorPost(Request $req)
    {
        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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





            return view('admin.investorpost')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }




    public function investorSubscriber(Request $req)
    {
        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'investors' => $this->getInvestorSubscribers()
            );




            return view('admin.investorsubscriberlist')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }






    public function getInvestorSubscribers()
    {
        $data = InvestorRelation::orderBy('name', 'ASC')->get();

        return $data;
    }



    public function investorPosts(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

            $data = [

                'posts' => Createpost::orderBy('created_at', 'DESC')->paginate(2)

            ];

            return view('admin.investorposts')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }

    public function fetchInvestorNews(Request $req)
    {
        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

            $data = [

                'posts' => InvestorPost::orderBy('created_at', 'DESC')->get()

            ];

            return view('admin.investorsnews')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }





    public function createInvestorPost(Request $req)
    {

        $transCost = $this->transactionCost();

        $data = array(
            'byStructure' => TransactionCost::select('structure')->groupBy('structure')->get(),
            'byMethod' => TransactionCost::select('method')->groupBy('method')->get(),
            'countryprice' => $this->getCountryPricing($req->get('country'))

        );



        return view('admin.createpost')->with(['pages' => 'Dashboard', 'transCost' => $transCost,  'data' => $data]);
    }

    public function editInvestorPost(Request $req, $id)
    {

        $transCost = $this->transactionCost();

        $data = array(
            'byStructure' => TransactionCost::select('structure')->groupBy('structure')->get(),
            'byMethod' => TransactionCost::select('method')->groupBy('method')->get(),
            'countryprice' => $this->getCountryPricing($req->get('country')),
            'post' => Createpost::where('id', $id)->first()

        );

        return view('admin.editinvestorpost')->with(['pages' => 'Dashboard', 'transCost' => $transCost,  'data' => $data]);
    }

    public function editInvestorNews(Request $req, $id)
    {

        $transCost = $this->transactionCost();

        $data = array(
            'byStructure' => TransactionCost::select('structure')->groupBy('structure')->get(),
            'byMethod' => TransactionCost::select('method')->groupBy('method')->get(),
            'countryprice' => $this->getCountryPricing($req->get('country')),
            'post' => InvestorPost::where('id', $id)->first()

        );

        return view('admin.editinvestornews')->with(['pages' => 'Dashboard', 'transCost' => $transCost,  'data' => $data]);
    }

    public function deleteInvestorPost(Request $req, $id)
    {
        $post = Createpost::where('id', $id)->delete();
        return back()->with("msg", "<div class='alert alert-success'>Post Deleted Successfully</div>");
    }

    public function deleteInvestorNews(Request $req, $id)
    {
        $post = InvestorPost::where('id', $id)->delete();
        return back()->with("msg", "<div class='alert alert-success'>News Deleted Successfully</div>");
    }

    public function deleteMarketplaceNews(Request $req, $id)
    {
        $post = MarketplaceNews::where('id', $id)->delete();

        return back()->with("msg", "<div class='alert alert-success'>News Deleted Successfully</div>");
    }

    public function updateInvestorNews(Request $req, $id)
    {

        $getPost = InvestorPost::where('id', $id)->first();

        $docPath = $getPost->file;

        if ($req->hasFile('file')) {
            //Get filename with extension
            $filenameWithExt = $req->file('file')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just extension
            $extension = $req->file('file')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = rand() . '_' . time() . '.' . $extension;


            $path = $req->file('file')->move(public_path('../../investorrelnews/'), $fileNameToStore);


            $docPath = "http://" . $_SERVER['HTTP_HOST'] . "/investorrelnews/" . $fileNameToStore;
        }

        $post = InvestorPost::where('id', $id)->update([
            'title' => $req->title,
            'description' => $req->description,
            'file' => $docPath
        ]);

        return redirect()->route('investors news')->with("msg", "<div class='alert alert-success'>News Updated Successfully</div>");
    }

    //update marketplace news
     public function updateMarketplaceNews(Request $req, $id)
    {

        $getPost = MarketplaceNews::where('id', $id)->first();

        $docPath = $getPost->file;

        if ($req->hasFile('file')) {
            //Get filename with extension
            $filenameWithExt = $req->file('file')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just extension
            $extension = $req->file('file')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = rand() . '_' . time() . '.' . $extension;


            $path = $req->file('file')->move(public_path('../../marketplacenews/'), $fileNameToStore);


            $docPath = "http://" . $_SERVER['HTTP_HOST'] . "/marketplacerelnews/" . $fileNameToStore;
        }

        $post = MarketplaceNews::where('id', $id)->update([
            'title' => $req->title,
            'description' => $req->description,
            'file' => $docPath
        ]);

        return redirect()->route('marketplacenews')->with("msg", "<div class='alert alert-success'>News Updated Successfully</div>");
    }

    public function editInvestorPosts(Request $req, $id)
    {
        $getPost = CreatePost::where('id', $id)->first();

        $docPath = $getPost->investment_document;

        if ($req->hasFile('investment_document')) {
            //Get filename with extension
            $filenameWithExt = $req->file('investment_document')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just extension
            $extension = $req->file('investment_document')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = rand() . '_' . time() . '.' . $extension;


            $path = $req->file('investment_document')->move(public_path('../../investorreldocs/'), $fileNameToStore);


            $docPath = "http://" . $_SERVER['HTTP_HOST'] . "/investorreldocs/" . $fileNameToStore;
        }

        $post = CreatePost::where('id', $id)->update([
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
            'investment_document' => $docPath,
            'activate_post' => $req->activate_post
        ]);

        return redirect()->route('investorposts')->with("msg", "<div class='alert alert-success'>Post Updated Successfully</div>");
    }



    public function createInvestorPosts(Request $req)
    {


        $docPath = "";

        if ($req->hasFile('investment_document')) {
            //Get filename with extension
            $filenameWithExt = $req->file('investment_document')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just extension
            $extension = $req->file('investment_document')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = rand() . '_' . time() . '.' . $extension;


            $path = $req->file('investment_document')->move(public_path('../../investorreldocs/'), $fileNameToStore);


            $docPath = "http://" . $_SERVER['HTTP_HOST'] . "/investorreldocs/" . $fileNameToStore;
        }





        $post = Createpost::insert([
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
            'investment_document' => $docPath,
            'activate_post' => $req->activate_post

        ]);

        return back()->with("msg", "<div class='alert alert-success'>Post Created Successfully</div>");




        //return view('admin.createpost')->with(['pages' => 'Dashboard', 'transCost' => $transCost,  'data' => $data]);

    }

    public function createInvestorNews(Request $req)
    {


        $validation = $req->validate([
            'title' => 'required',
            'description' => 'required'
        ]);

        $docPath = "";

        if ($req->hasFile('file')) {
            //Get filename with extension
            $filenameWithExt = $req->file('file')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just extension
            $extension = $req->file('file')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = rand() . '_' . time() . '.' . $extension;


            $path = $req->file('file')->move(public_path('../../investorrelnews/'), $fileNameToStore);


            $docPath = "http://" . $_SERVER['HTTP_HOST'] . "/investorreldocs/" . $fileNameToStore;
        }

        $post = InvestorPost::insert([
            'title' => $req->title,
            'description' => $req->description,
            'file' => $docPath,

        ]);

        return back()->with("msg", "<div class='alert alert-success'>News Created Successfully</div>");
    }

    //create marketplace News
    public function createMarketplaceNews(Request $req)
    {


        $validation = $req->validate([
            'title' => 'required',
            'description' => 'required'
        ]);

        $docPath = "";

        if ($req->hasFile('file')) {
            //Get filename with extension
            $filenameWithExt = $req->file('file')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just extension
            $extension = $req->file('file')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = rand() . '_' . time() . '.' . $extension;


            $path = $req->file('file')->move(public_path('../../marketplacenews/'), $fileNameToStore);


            $docPath = "http://" . $_SERVER['HTTP_HOST'] . "/marketplacedocs/" . $fileNameToStore;
        }

        $post = MarketplaceNews::insert([
            'title' => $req->title,
            'description' => $req->description,
            'file' => $docPath,
        ]);

        return back()->with("msg", "<div class='alert alert-success'>News Created Successfully</div>");
    }





    public function saveMarkup(Request $req)
    {

        MarkUp::where('percentage', '!=', null)->update(['percentage' => $req->percentage]);


        return redirect()->back()->with('success', 'Successfully created!');
    }



    public function countryPricing(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'byStructure' => TransactionCost::select('structure')->groupBy('structure')->get(),
                'byMethod' => TransactionCost::select('method')->groupBy('method')->get(),
                'countryprice' => $this->getCountryPricing($req->get('country')),
            );





            return view('admin.countrypricing')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function editPricing(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'byStructure' => TransactionCost::select('structure')->groupBy('structure')->get(),
                'byMethod' => TransactionCost::select('method')->groupBy('method')->get(),
                'countryprice' => $this->getCountryPricing($req->get('country')),
            );



            return view('admin.editpricing')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function getPricingByCountry()
    {
        $data = PricingSetup::orderBy('country', 'ASC')->groupBy('country')->get();

        return $data;
    }

    public function getCountryPricing($country)
    {

        $data = PricingSetup::where('country', $country)->first();

        return $data;
    }

    public function getPendingMerchantByCountry()
    {
        $data = User::where('accountType', 'Merchant')->where('accountLevel', '<=', 2)->where('approval', '<=', 1)->orderBy('country', 'ASC')->groupBy('country')->get();

        return $data;
    }

    public function getPendingKYB($country)
    {
        $data = User::where('accountType', 'Merchant')->where('country', $country)->where('accountLevel', '<=', 2)->where('approval', '<=', 1)->orderBy('created_at', 'DESC')->get();

        return $data;
    }

    public function getCompletedMerchantByCountry()
    {
        $data = User::where('accountType', 'Merchant')->where('accountLevel', 3)->where('approval', 2)->orderBy('country', 'ASC')->groupBy('country')->get();

        return $data;
    }

    public function getCompletedKYB($country)
    {
        $data = User::where('accountType', 'Merchant')->where('country', $country)->where('accountLevel', 3)->where('approval', 2)->orderBy('created_at', 'DESC')->get();

        return $data;
    }

    public function getIndustryByCountry()
    {
        $data = ClientInfo::orderBy('country', 'ASC')->groupBy('country')->get();

        return $data;
    }


    public function getIndustry($country)
    {
        $data = ClientInfo::where('country', $country)->orderBy('created_at', 'DESC')->get();

        return $data;
    }



    public function feeStructure(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'byStructure' => TransactionCost::select('structure')->groupBy('structure')->get(),
                'byMethod' => TransactionCost::select('method')->groupBy('method')->get(),
            );




            return view('admin.feestructure')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }



    public function createServiceTypes(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'getServiceType' => $this->getServiceTypes(),
            );




            return view('admin.getservicetype')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }
    public function setupTax(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'getTax' => $this->getTax(session('myID')),
            );




            return view('admin.setuptax')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }
    public function editTax(Request $req, $id)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'getthisTax' => $this->getthisTax($id),
                'getTax' => $this->getTax(session('myID')),
            );




            return view('admin.edittax')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function merchantProfile(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'getuserDetail' => $this->getmyPersonalDetail(session('user_id')),
                'getbusinessDetail' => $this->getmyBusinessDetail(session('user_id')),
                'merchantservice' => $this->_merchantServices(),
                'getCard' => $this->getUserCard(session('myID')),
                'getBank' => $this->getUserBank(session('myID')),
                'getTax' => $this->getTax(session('myID')),
                'listbank' => $this->getBankList(),
            );



            return view('admin.merchant.profile')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function createSingleInvoice(Request $req)
    {

        if ($req->session()->has('username') == true) {

            $client = $this->getMyClientInfo(session('user_id'));

            if ($client->accountMode == "test") {

                return redirect()->route('dashboard')->with('error', 'You are in test mode');
            }


            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'getServiceType' => $this->getServiceTypes(),
                'getTax' => $this->getTax(session('myID')),
                'getpersonalData' => $this->getmyPersonalDetail(session('user_id')),
                'getimt' => $this->getActiveCountries()
            );



            return view('admin.invoice.single')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }
    public function createLinkInvoice(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            $client = $this->getMyClientInfo(session('user_id'));

            if ($client->accountMode == "test") {

                return redirect()->route('dashboard')->with('error', 'You are in test mode');
            }

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'getServiceType' => $this->getServiceTypes(),
                'getTax' => $this->getTax(session('myID')),
                'getpersonalData' => $this->getmyPersonalDetail(session('user_id')),
                'allthecountries' => $this->getAllCountries()
            );


            return view('admin.invoice.singlelink')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }

    public function createBulkInvoice(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'getServiceType' => $this->getServiceTypes(),
                'getTax' => $this->getTax(session('myID')),
            );




            return view('admin.invoice.bulk')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function apiDocumentation(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'getThisUser' => $this->getThisUser(session('user_id')),
                'getbusinessDetail' => $this->getmyBusinessDetail(session('user_id')),
            );




            return view('admin.docs.index')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'data' => $data]);
        } else {
            // return redirect()->route('AdminLogin');
            return view('admin.docs.index');
        }
    }

    public function earnedPoints(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'getThisUser' => $this->getThisUser(session('user_id')),
                'getbusinessDetail' => $this->getmyBusinessDetail(session('user_id')),
            );




            return view('admin.docs.index')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'data' => $data]);
        } else {
            // return redirect()->route('AdminLogin');
            return view('admin.docs.index');
        }
    }






    public function getServiceTypes()
    {
        $data = ServiceType::orderBy('created_at', 'DESC')->get();

        return $data;
    }

    public function getTax($id)
    {
        $data = Tax::where('user_id', $id)->orderBy('created_at', 'DESC')->get();

        return $data;
    }

    public function getthisTax($id)
    {
        $data = Tax::where('id', $id)->first();

        return $data;
    }


    public function allCardIssuer(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'allIssuer' => CardIssuer::orderBy('created_at', 'DESC')->get(),
            );




            return view('admin.card.cardissuer')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function allAddedCards(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'allIssuer' => CardIssuer::orderBy('created_at', 'DESC')->get(),
                'allAddedCards' => $this->cardCategory(),
            );





            return view('admin.card.addedcards')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }



    public function allDeletedCards(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'allIssuer' => CardIssuer::orderBy('created_at', 'DESC')->get(),
                'allDeletedCards' => $this->deletedCardCategory(),
            );





            return view('admin.card.deletedcards')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function getUsersCard(Request $req, $user_id)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'thisuserCard' => $this->getThisUserCard($user_id),
            );




            return view('admin.card.getusercard')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function getUsersDeletedCard(Request $req, $user_id)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'thisuserdeletedCard' => $this->getThisUserDeletedCard($user_id),
            );




            return view('admin.card.getuserdeletedcard')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function redFlaggedAccount(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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





            return view('admin.card.redflagged')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function redFlaggedMoney(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'flaggedinfo' => $this->getAllFlaggedMoney(),
            );



            return view('admin.card.redflaggedmoney')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }

    public function cardCategory()
    {
        $data = AddCard::select('users.*', 'add_card.*')->join('users', 'users.id', '=', 'add_card.user_id')->orderBy('add_card.created_at', 'DESC')->groupBy('users.name')->get();

        return $data;
    }


    public function deletedCardCategory()
    {
        $data = DeletedCards::select('users.*', 'deleted_cards.*')->join('users', 'users.id', '=', 'deleted_cards.user_id')->where('users.flagged', 0)->orderBy('deleted_cards.created_at', 'DESC')->groupBy('users.name')->get();

        return $data;
    }

    public function getThisUserCard($user_id)
    {
        $data = AddCard::where('user_id', $user_id)->orderBy('created_at', 'DESC')->get();

        return $data;
    }

    public function getThisUserDeletedCard($user_id)
    {
        $data = DeletedCards::where('user_id', $user_id)->orderBy('created_at', 'DESC')->get();

        return $data;
    }

    public function getThisUser($ref_code)
    {
        $data = User::where('ref_code', $ref_code)->first();

        return $data;
    }
    public function getFlaggedUsers()
    {

        $data = User::where('flagged', 1)->orderBy('created_at', 'DESC')->get();

        return $data;
    }


    public function feeStructureByCountry(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

            $transCost = $this->transactionCostByCountry();

            $getwithdraw = $this->withdrawRemittance();
            $collectfee = $this->allcollectionFee();
            $getClient = $this->getallClient();
            $getCustomer = $this->getCustomer($req->route('id'));


            // Get all xpaytransactions where state = 1;

            $getxPay = $this->getxpayTrans();

            // dd($transCost);



            return view('admin.feestructurebycountry')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function structureByCountry(Request $req, $country)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

            $transCost = $this->gettransactionCostByCountry($country);

            $getwithdraw = $this->withdrawRemittance();
            $collectfee = $this->allcollectionFee();
            $getClient = $this->getallClient();
            $getCustomer = $this->getCustomer($req->route('id'));




            // Get all xpaytransactions where state = 1;

            $getxPay = $this->getxpayTrans();



            return view('admin.structurebycountry')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function editFee(Request $req, $id)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
            $getTransfee = $this->getTransfee($id);



            return view('admin.editfeestructure')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'getTransfee' => $getTransfee]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function editCardIssuer(Request $req, $id)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'allIssuer' => CardIssuer::orderBy('created_at', 'DESC')->get(),
                'getCardIssuer' => $this->getCardIssuer($id),
            );



            return view('admin.card.editcardissuer')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function getTransfee($id)
    {
        $data = TransactionCost::where('id', $id)->first();

        return $data;
    }
    public function getCardIssuer($id)
    {
        $data = CardIssuer::where('id', $id)->first();

        return $data;
    }




    public function allPlatformUsers(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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


            return view('admin.allusers')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function allApprovedUsers(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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


                $query = [
                    'user_id' => session('user_id'),
                    'name' => session('firstname') . ' ' . session('lastname'),
                    'activity' => 'Access to all approved users page today: ' . date('d-M-Y h:i:a'),
                ];

                $this->createSupportActivity($query);
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
            $allusers = $this->allUsersApproved();


            return view('admin.allusersapproved')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function autoCreditApproval(Request $req)
    {
        try {


            if ($req->value === "remove") {
                User::where('id', $req->id)->update(['auto_credit' => 0]);
            } else {
                User::where('id', $req->id)->update(['auto_credit' => 1]);
            }

            $resData = 'Successfully ' . $req->value . 'd';
            $resp = "success";
        } catch (\Throwable $th) {
            $resData = $th->getMessage();
            $resp = "error";
        }

        return redirect()->back()->with($resp, $resData);
    }


    public function allUpgradedConsumers(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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


                $query = [
                    'user_id' => session('user_id'),
                    'name' => session('firstname') . ' ' . session('lastname'),
                    'activity' => 'Access to all approved users page today: ' . date('d-M-Y h:i:a'),
                ];

                $this->createSupportActivity($query);
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
            $allusers = $this->allConsumerApproved();


            return view('admin.allconsumersapproved')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function allUpgradedMerchants(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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


                $query = [
                    'user_id' => session('user_id'),
                    'name' => session('firstname') . ' ' . session('lastname'),
                    'activity' => 'Access to all approved users page today: ' . date('d-M-Y h:i:a'),
                ];

                $this->createSupportActivity($query);
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
            $allusers = $this->allMerchantApproved();


            return view('admin.allmerchantsapproved')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function allApprovedPendingUsers(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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


                $query = [
                    'user_id' => session('user_id'),
                    'name' => session('firstname') . ' ' . session('lastname'),
                    'activity' => 'Access to all approved users page today: ' . date('d-M-Y h:i:a'),
                ];

                $this->createSupportActivity($query);
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
            $allusers = $this->allUsersApprovedPending();


            return view('admin.allusersapprovedpending')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function allMatchedUsers(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $query = [
                    'user_id' => session('user_id'),
                    'name' => session('firstname') . ' ' . session('lastname'),
                    'activity' => 'Access to all matched users page today: ' . date('d-M-Y h:i:a'),
                ];

                $this->createSupportActivity($query);
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
            $allusers = $this->allUsersMatched();


            return view('admin.allusersmatched')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }

    public function addTowatchlist(Request $req, $id)
    {
        $id = $req->id;
        $user = User::where('id', $id)->first();

        watchlist::create([
            'user_id' => $user->id,
            'ref_code' => $user->ref_code,
            'name' => $user->name,
            'country' => $user->country
        ]);

        User::where('id', $user->id)->update([
            'watchlist' => '1'
        ]);

        return back()->with("msg", "<div class='alert alert-success'>User Added to Watchlist</div>");
    }

    //removefromwatchlist
    public function removeFromWatchList(Request $req, $id)
    {
        $id = $req->id;
        $user = User::where('id', $id)->first();

        watchlist::where('user_id', $req->id)->delete();

        User::where('id', $user->id)->update([
            'watchlist' => '0'
        ]);

        return back()->with("msg", "<div class='alert alert-success'>User Successfully  Removed from  Watchlist</div>");
    }


    public function allLevelTwoUsers(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $query = [
                    'user_id' => session('user_id'),
                    'name' => session('firstname') . ' ' . session('lastname'),
                    'activity' => 'Access to all matched users page today: ' . date('d-M-Y h:i:a'),
                ];

                $this->createSupportActivity($query);
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
            $allusers = $this->allUsersForLevelTwo();


            return view('admin.allusersforleveltwo')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }



    public function allPendingUsers(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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


                $query = [
                    'user_id' => session('user_id'),
                    'name' => session('firstname') . ' ' . session('lastname'),
                    'activity' => 'Access to all pending users page today: ' . date('d-M-Y h:i:a'),
                ];

                $this->createSupportActivity($query);
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
            $allusers = $this->allUsersPending();


            return view('admin.alluserspending')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }



    public function allOverrideUsers(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $query = [
                    'user_id' => session('user_id'),
                    'name' => session('firstname') . ' ' . session('lastname'),
                    'activity' => 'Access to all override users page today: ' . date('d-M-Y h:i:a'),
                ];

                $this->createSupportActivity($query);
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
            $allusers = $this->allUsersOverride();


            return view('admin.allusersoverride')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function allNotActivePsUsers(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $query = [
                    'user_id' => session('user_id'),
                    'name' => session('firstname') . ' ' . session('lastname'),
                    'activity' => 'Access to all override users page today: ' . date('d-M-Y h:i:a'),
                ];

                $this->createSupportActivity($query);
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
            $allusers = $this->allNotActivePsUsersAccount();


            return view('admin.allnotactivepsusersaccount')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }



    public function allClosedUsers(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $query = [
                    'user_id' => session('user_id'),
                    'name' => session('firstname') . ' ' . session('lastname'),
                    'activity' => 'Access to all closed users page today: ' . date('d-M-Y h:i:a'),
                ];

                $this->createSupportActivity($query);
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
            $allusers = $this->allUsersClosed();


            return view('admin.allusersclosed')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function allSuspendedUsers(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $query = [
                    'user_id' => session('user_id'),
                    'name' => session('firstname') . ' ' . session('lastname'),
                    'activity' => 'Access to all closed users page today: ' . date('d-M-Y h:i:a'),
                ];

                $this->createSupportActivity($query);
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
            $allusers = $this->allUsersSuspended();


            return view('admin.alluserssuspended')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function allNewusers(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $query = [
                    'user_id' => session('user_id'),
                    'name' => session('firstname') . ' ' . session('lastname'),
                    'activity' => 'Access to all closed users page today: ' . date('d-M-Y h:i:a'),
                ];

                $this->createSupportActivity($query);
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
            $allusers = $this->allNewUser($req->get('country'), $req->get('user'));


            return view('admin.allnewusers')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function allNewMerchants(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $query = [
                    'user_id' => session('user_id'),
                    'name' => session('firstname') . ' ' . session('lastname'),
                    'activity' => 'Access to all closed users page today: ' . date('d-M-Y h:i:a'),
                ];

                $this->createSupportActivity($query);
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
            $allusers = $this->allMerchantsNew($req->get('country'), $req->get('user'));


            return view('admin.allnewmerchants')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function archivedUsersList(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $query = [
                    'user_id' => session('user_id'),
                    'name' => session('firstname') . ' ' . session('lastname'),
                    'activity' => 'Access to all archived users page today: ' . date('d-M-Y h:i:a'),
                ];

                $this->createSupportActivity($query);
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
            $allusers = $this->allMyArchivedUserList($req->get('country'), $req->get('user'));


            return view('admin.allarchivedlist')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function allPlatformUsersByCountry(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $query = [
                    'user_id' => session('user_id'),
                    'name' => session('firstname') . ' ' . session('lastname'),
                    'activity' => 'Access to all users page today: ' . date('d-M-Y h:i:a'),
                ];

                $this->createSupportActivity($query);
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
            $allusers = $this->allUsersByCountry();


            return view('admin.allusersbycountry')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }



    public function allApprovedUsersByCountry(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $query = [
                    'user_id' => session('user_id'),
                    'name' => session('firstname') . ' ' . session('lastname'),
                    'activity' => 'Access to all approved users page today: ' . date('d-M-Y h:i:a'),
                ];

                $this->createSupportActivity($query);
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
            $allusers = $this->approvedUsersByCountry();


            return view('admin.approvedusersbycountry')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }



    public function allUpgradedConsumerByCountry(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $query = [
                    'user_id' => session('user_id'),
                    'name' => session('firstname') . ' ' . session('lastname'),
                    'activity' => 'Access to all approved users page today: ' . date('d-M-Y h:i:a'),
                ];

                $this->createSupportActivity($query);
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
            $allusers = $this->upgradedUsersByCountry('Individual');


            return view('admin.upgradedconsumerbycountry')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function allUpgradedMerchantByCountry(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $query = [
                    'user_id' => session('user_id'),
                    'name' => session('firstname') . ' ' . session('lastname'),
                    'activity' => 'Access to all approved users page today: ' . date('d-M-Y h:i:a'),
                ];

                $this->createSupportActivity($query);
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
            $allusers = $this->upgradedUsersByCountry('Merchant');


            return view('admin.upgradedmerchantsbycountry')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function merchantAccountModeByCountry(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $query = [
                    'user_id' => session('user_id'),
                    'name' => session('firstname') . ' ' . session('lastname'),
                    'activity' => 'Access to all approved users page today: ' . date('d-M-Y h:i:a'),
                ];

                $this->createSupportActivity($query);
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

            // Get all xpaytransactions where state = 1;

            $getxPay = $this->getxpayTrans();
            $allusers = $this->merchantMode($req->mode);


            return view('admin.merchantmodebycountry')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'mode' => $req->mode]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function merchantDetails(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $query = [
                    'user_id' => session('user_id'),
                    'name' => session('firstname') . ' ' . session('lastname'),
                    'activity' => 'Access to all approved users page today: ' . date('d-M-Y h:i:a'),
                ];

                $this->createSupportActivity($query);
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

            // Get all xpaytransactions where state = 1;

            $getxPay = $this->getxpayTrans();
            $allusers = $this->merchantAccountDetails($req->country, $req->mode);

            // dd($allusers);

            return view('admin.merchantdetails')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function allApprovedPendingUsersByCountry(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $query = [
                    'user_id' => session('user_id'),
                    'name' => session('firstname') . ' ' . session('lastname'),
                    'activity' => 'Access to all approved users page today: ' . date('d-M-Y h:i:a'),
                ];

                $this->createSupportActivity($query);
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
            $allusers = $this->approvedPendingUsersByCountry();


            return view('admin.approvedpendingusersbycountry')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function allMatchedUsersByCountry(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $query = [
                    'user_id' => session('user_id'),
                    'name' => session('firstname') . ' ' . session('lastname'),
                    'activity' => 'Access to all matched users page by country today: ' . date('d-M-Y h:i:a'),
                ];

                $this->createSupportActivity($query);
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
            $allusers = $this->matchedUsersByCountry();


            return view('admin.matchedusersbycountry')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function levelTwoUsersByCountry(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $query = [
                    'user_id' => session('user_id'),
                    'name' => session('firstname') . ' ' . session('lastname'),
                    'activity' => 'Access to all matched users page by country today: ' . date('d-M-Y h:i:a'),
                ];

                $this->createSupportActivity($query);
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
            $allusers = $this->level2UsersByCountry();


            return view('admin.level2usersbycountry')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }

    public function allPendingUsersByCountry(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $query = [
                    'user_id' => session('user_id'),
                    'name' => session('firstname') . ' ' . session('lastname'),
                    'activity' => 'Access to all pending users page by country today: ' . date('d-M-Y h:i:a'),
                ];

                $this->createSupportActivity($query);
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
            $allusers = $this->pendingUsersByCountry();


            return view('admin.pendingusersbycountry')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }



    public function allOverrideUsersByCountry(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $query = [
                    'user_id' => session('user_id'),
                    'name' => session('firstname') . ' ' . session('lastname'),
                    'activity' => 'Access to override level 1 user by country today: ' . date('d-M-Y h:i:a'),
                ];

                $this->createSupportActivity($query);
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
            $allusers = $this->overrideUsersByCountry();


            return view('admin.overrideusersbycountry')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function allPSUsersNotActiveByCountry(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $query = [
                    'user_id' => session('user_id'),
                    'name' => session('firstname') . ' ' . session('lastname'),
                    'activity' => 'Access to override level 1 user by country today: ' . date('d-M-Y h:i:a'),
                ];

                $this->createSupportActivity($query);
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
            $allusers = $this->psUsersNotActiveByCountry();


            return view('admin.psusersnotactivebycountry')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }



    public function allClosedUsersByCountry(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $query = [
                    'user_id' => session('user_id'),
                    'name' => session('firstname') . ' ' . session('lastname'),
                    'activity' => 'Access to all closed users page by country today: ' . date('d-M-Y h:i:a'),
                ];

                $this->createSupportActivity($query);
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
            $allusers = $this->closedUsersByCountry();


            return view('admin.closedusersbycountry')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function allSuspendedUsersByCountry(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $query = [
                    'user_id' => session('user_id'),
                    'name' => session('firstname') . ' ' . session('lastname'),
                    'activity' => 'Access to all closed users page by country today: ' . date('d-M-Y h:i:a'),
                ];

                $this->createSupportActivity($query);
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
            $allusers = $this->suspendedUsersByCountry();


            return view('admin.suspendedusersbycountry')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function newUsersByCountry(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $query = [
                    'user_id' => session('user_id'),
                    'name' => session('firstname') . ' ' . session('lastname'),
                    'activity' => 'Access to all closed users page by country today: ' . date('d-M-Y h:i:a'),
                ];

                $this->createSupportActivity($query);
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
            $allusers = $this->newaccountUsersByCountry($req->get('user'));


            return view('admin.newusersbycountry')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function newMerchantsByCountry(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $query = [
                    'user_id' => session('user_id'),
                    'name' => session('firstname') . ' ' . session('lastname'),
                    'activity' => 'Access to all closed users page by country today: ' . date('d-M-Y h:i:a'),
                ];

                $this->createSupportActivity($query);
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
            $allusers = $this->newaccountMerchantsByCountry($req->get('user'));


            return view('admin.newmerchantsbycountry')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }



    public function archivedUsersByCountry(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $query = [
                    'user_id' => session('user_id'),
                    'name' => session('firstname') . ' ' . session('lastname'),
                    'activity' => 'Access to all archived users page by country today: ' . date('d-M-Y h:i:a'),
                ];

                $this->createSupportActivity($query);
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




            $allusers = $this->archivedaccountUsersByCountry($req->get('user'));


            return view('admin.archvedusersbycountry')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function userMoreDetail(Request $req, $id)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $query = [
                    'user_id' => session('user_id'),
                    'name' => session('firstname') . ' ' . session('lastname'),
                    'activity' => 'Access to check users details today: ' . date('d-M-Y h:i:a'),
                ];

                $this->createSupportActivity($query);
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

            $getthisuser = User::where('id', $id)->first();


            return view('admin.usermoredetail')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'getthisuser' => $getthisuser]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }



    public function closedUserMoreDetail(Request $req, $id)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $query = [
                    'user_id' => session('user_id'),
                    'name' => session('firstname') . ' ' . session('lastname'),
                    'activity' => 'Access to check users details today: ' . date('d-M-Y h:i:a'),
                ];

                $this->createSupportActivity($query);
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

            $getthisuser = UserClosed::where('id', $id)->first();



            return view('admin.closedusermoredetail')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'getthisuser' => $getthisuser]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }



    public function walletBalance(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
            );



            return view('admin.wallet.walletbalance')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function userWalletStatement(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
            );



            return view('admin.wallet.userstatement')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }



    public function userWalletPurchaseStatement(Request $req)
    {


        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'result' => $this->getUserWalletPurchaseStatementRecordByCountryDate($req->get('country'), $req->get('start'), $req->get('end')),
            );





            return view('admin.wallet.userpurchasestatement')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function userWalletPurchase(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
            );



            return view('admin.wallet.userpurchase')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function balanceByCountry(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'walletByCountry' => $this->userWalletBalancebyCountry($req->get('country'))
            );



            return view('admin.wallet.walletbalancebycountry')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function maintenancefeeByCountry(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'maintenancefeebycountry' => $this->usermaintenancefeebyCountry($req->get('country'))
            );



            return view('admin.wallet.maintenancefeebycountry')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function maintenancefeeDetail(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'allmaintenanceFeedetail' => $this->allMaintenanceFeeDetail()
            );



            return view('admin.wallet.maintenancefeedetail')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function platformActivity(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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



            return view('admin.pages.activity')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function activityReport(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'activity' => $this->userActivityByCountry($req->get('country'))
            );



            return view('admin.pages.activityreport')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }

    public function paysprintPoint(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'allthecountries' => $this->getAllCountries()
            );



            return view('admin.pages.paysprintpoint')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }

    // Point acquired
    public function usersPoint(Request $req)
    {


        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'mainpoint' => $this->getMainPoint($req->get('country'))
            );




            return view('admin.pages.userspoint')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }

    public function claimedPointsAdmin(Request $req)
    {


        if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

        // Get Bill
        $getPoint = Points::where('user_id', session('myID'))->first();



        if (isset($getPoint)) {

            $max = 7000;

            $totPointLeft = $getPoint->points_acquired - $max;

            $pointtoget = $max - $getPoint->points_acquired;

            // Process claims and update user

            if ($getPoint->points_acquired >= $max) {



                // This is when you can claim points...
                Points::where('user_id', session('myID'))->update(['add_money' => 0, 'send_money' => 0, 'receive_money' => 0, 'pay_invoice' => 0, 'pay_bills' => 0, 'create_and_send_invoice' => 0, 'active_rental_property' => 0, 'quick_set_up' => 0, 'identity_verification' => 0, 'business_verification' => 0, 'promote_business' => 0, 'activate_ordering_system' => 0, 'identify_verification' => 0, 'activate_rpm' => 0, 'activate_currency_exchange' => 0, 'activate_cash_advance' => 0, 'activate_crypto_currency_account' => 0, 'approved_customers' => 0, 'approved_merchants' => 0, 'points_acquired' => $totPointLeft, 'current_point' => $getPoint->points_acquired]);



                ClaimedPoints::updateOrCreate(['user_id' => session('myID')], [
                    'user_id' => session('myID'),
                    'points_acquired' => $getPoint->points_acquired,
                    'points_left' => $totPointLeft,
                    'status' => 'pending'
                ]);

                HistoryReport::insert([
                    'user_id' => session('myID'),
                    'points' => $getPoint->points_acquired,
                    'point_activity' => "You have claimed " . $getPoint->points_acquired . " points today " . date('d/m/y')

                ]);

                $resData = 'Your points claimed has been submitted successfully. The reward will be processed within the next 24hrs';
                $resp = "success";
            } else {

                $resData = 'You need to have ' . $pointtoget . ' to be able to claim reward';
                $resp = "error";
            }
        } else {

            $resData = 'You do not have any acquired points';
            $resp = "error";
        }




        return redirect()->back()->with($resp, $resData);
    }



    public function claimedHistoryAdmin(Request $req)
    {

        if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

        // Get Bill
        $getPoint = Points::where('user_id', session('myID'))->first();



        $data = array(
            'gethistory' => $getPoint->points_acquired,
            'mypoints' => $this->getAcquiredPoints(session('myID')),
            'pointsclaim' => $this->getClaimedHistory(session('myID')),

        );



        return view('main.claimpointhistoryadmin')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email,  'data' => $data]);
    }


    public function gatewayActivity(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'activity' => $this->gatewaypayActivity($req->get('gateway'))
            );



            return view('admin.pages.monerisactivity')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function bvnCheckDetails(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'activity' => $this->bvnStatusActivity()
            );



            return view('admin.pages.bvnactivity')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function utilityAndBills(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'integration' => $this->thirdPartyIntegration()
            );



            return view('admin.pages.integration')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }

    public function checkTransaction(Request $req, $id)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'transaction' => $this->verifyTransaction($id)
            );

            return view('admin.pages.transactiondetails')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function supportPlatformActivity(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'activity' => $this->userSupportActivities()
            );



            return view('admin.pages.supportactivity')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }

    public function platformActivityPerDay(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'activity' => $this->userActivityStatistics($req->get('start'), $req->get('end'))
            );


            return view('admin.pages.activityperday')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function specialInfoActivity(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'activity' => $this->specialInformationData()
            );



            return view('admin.pages.specialinfoactivity')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function editspecialInfoActivity(Request $req, $id)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'activity' => $this->selectedInformationData($id)
            );



            return view('admin.pages.editspecialinfoactivity')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }

    public function createSpecialInfoActivity(Request $req)
    {

        $data = $this->createInfo($req->all());

        return redirect()->route('special information activity')->with('success', 'Successfully created!');
    }


    public function deleteSpecialInfoActivity(Request $req)
    {

        $data = $this->deleteInfo($req->id);

        return redirect()->route('special information activity')->with('success', 'Successfully deleted!');
    }


    public function generateSupportAgent(Request $req)
    {

        $data = $this->userSupportAgent($req->all());

        // Send Mail to the support agent
        $this->name = $req->firstname . ' ' . $req->lastname;
        $this->email = $req->email;
        $this->subject = "Role assignment on PaySprint";
        $this->info = "Fund remittance";

        $this->message = '<p>Hello ' . $this->name . ', </p><p>You have been assigned a role on PaySprint. Below are your login details;</p><p style="font-weight: bold;">Username: ' . $req->user_id . '</p><p style="font-weight: bold;">Password: ' . $req->firstname . '</p><hr><p>Login Url: <a href="https://paysprint.ca/AdminLogin">https://paysprint.ca/AdminLogin</a></p>';

        Log::info("Hello  " . $this->name . ', You have been assigned a role on PaySprint. Below are your login details; Username: ' . $req->user_id . " \n Password: " . $req->firstname);

        $this->slack("Hello  " . $this->name . ', You have been assigned a role on PaySprint. Below are your login details; Username: ' . $req->user_id . " \n Password: " . $req->firstname, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));

        $this->sendEmail($this->email, "Fund remittance");

        return redirect()->route('view user support agent')->with('success', 'Successfully created!');
    }



    public function generateReferrerAgent(Request $req)
    {

        try {
            $this->userReferrerAgent($req->all());

            // Send Mail to the support agent
            $this->name = $req->firstname . ' ' . $req->lastname;
            $this->email = $req->email;
            $this->info = "Your PaySprint Referral Account Actiavted";
            $this->subject = "Your PaySprint Referral Account Actiavted";


            $this->message = '<p>Hello ' . $this->name . ', </p><p>Thanks for joining our affiliate program. Your Business Referral code is:</p><p style="font-weight: bold;"> ' . $req->ref_code . '</p><p> and must be used by the leads when signing up in order to tag the users to your referral account.</p><p style="font-weight: bold;">Kindly use this link to  track your achievements and Referral commission earned and paid: ' . route('referrals list of users', $req->ref_code) . '</p><p>PaySprint Inc.</p>';

            Log::info("Hello  " . $this->name . ', Thanks for joining our affiliate program. Your Business Referral code is: ' . $req->ref_code . " and must be used by the leads when signing up in order to tag the users to your referral account. Kindly use this link to  track your achievements and Referral commission earned and paid: " . route('referrals list of users', $req->ref_code));

            $this->slack("Hello  " . $this->name . ', Thanks for joining our affiliate program. Your Business Referral code is: ' . $req->ref_code . " and must be used by the leads when signing up in order to tag the users to your referral account. Kindly use this link to  track your achievements and Referral commission earned and paid: " . route('referrals list of users', $req->ref_code), $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));

            // Send Send
            $sendMsg = "Hello  " . $this->name . ', Thanks for joining our affiliate program. Your Business Referral code is: ' . $req->ref_code . " and must be used by the leads when signing up in order to tag the users to your referral account. Kindly use this link to  track your achievements and Referral commission earned and paid: " . route('referrals list of users', $req->ref_code);

            $usergetPhone =
                User::where('country', $req->country)->where('code', '!=', NULL)->first();

            if (isset($usergetPhone)) {

                $countryCode = $usergetPhone->code;
            } else {
                $countryCode = "+" . $usergetPhone->code;
            }

            if ($req->country == "Nigeria") {

                $correctPhone = preg_replace("/[^0-9]/", "", $countryCode . $req->telephone);
                $this->sendSms($sendMsg, $correctPhone);
            } else {
                $this->sendMessage($sendMsg, $countryCode . $req->telephone);
            }


            $this->sendEmail($this->email, "Your PaySprint Referral Account Actiavted");


            // Send SMS

            return redirect()->route('view referrer agent')->with('success', 'Successfully created!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }


    public function editThisSupportAgent(Request $req)
    {

        $data = $this->editcurrentSupportAgent($req->all());

        // Send Mail to the support agent
        $this->name = $req->firstname . ' ' . $req->lastname;
        $this->email = $req->email;
        $this->subject = "Role assignment on PaySprint";
        $this->info = "Fund remittance";

        $this->message = '<p>Hello ' . $this->name . ', </p><p>You have been assigned a role on PaySprint. Below are your login details;</p><p style="font-weight: bold;">Username: ' . $req->user_id . '</p><p style="font-weight: bold;">Password: ' . $req->firstname . '</p><hr><p>Login Url: <a href="https://paysprint.ca/AdminLogin">https://paysprint.ca/AdminLogin</a></p>';


        Log::info("Hello  " . $this->name . ', You have been assigned a role on PaySprint. Below are your login details; Username: ' . $req->user_id . " \n Password: " . $req->firstname);

        $this->slack("Hello  " . $this->name . ', You have been assigned a role on PaySprint. Below are your login details; Username: ' . $req->user_id . " \n Password: " . $req->firstname, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));


        $this->sendEmail($this->email, "Fund remittance");

        return redirect()->route('view user support agent')->with('success', 'Successfully created!');
    }


    public function editThisReferrerAgent(Request $req)
    {

        try {
            $this->editcurrentReferrerAgent($req->all());

            // Send Mail to the support agent
            $this->name = $req->name;
            $this->email = $req->email;
            $this->info = "Your PaySprint Referral Account Actiavted";
            $this->subject = "Your PaySprint Referral Account Actiavted";


            $this->message = '<p>Hello ' . $this->name . ', </p><p>Thanks for joining our affiliate program. Your Business Referral code is:</p><p style="font-weight: bold;"> ' . $req->ref_code . '</p><p> and must be used by the leads when signing up in order to tag the users to your referral account.</p><p style="font-weight: bold;">Kindly use this link to  track your achievements and Referral commission earned and paid: ' . route('referrals list of users', $req->ref_code) . '</p><p>PaySprint Inc.</p>';

            Log::info("Hello  " . $this->name . ', Thanks for joining our affiliate program. Your Business Referral code is: ' . $req->ref_code . " and must be used by the leads when signing up in order to tag the users to your referral account. Kindly use this link to  track your achievements and Referral commission earned and paid: " . route('referrals list of users', $req->ref_code));

            $this->slack("Hello  " . $this->name . ', Thanks for joining our affiliate program. Your Business Referral code is: ' . $req->ref_code . " and must be used by the leads when signing up in order to tag the users to your referral account. Kindly use this link to  track your achievements and Referral commission earned and paid: " . route('referrals list of users', $req->ref_code), $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));

            // Send Send
            $sendMsg = "Hello  " . $this->name . ', Thanks for joining our affiliate program. Your Business Referral code is: ' . $req->ref_code . " and must be used by the leads when signing up in order to tag the users to your referral account. Kindly use this link to  track your achievements and Referral commission earned and paid: " . route('referrals list of users', $req->ref_code);

            $usergetPhone = User::where('country', $req->country)->where('code', '!=', NULL)->first();


            if (isset($usergetPhone)) {

                $countryCode = "+" . $usergetPhone->code;

                if ($req->country == "Nigeria") {

                    $correctPhone = preg_replace("/[^0-9]/", "", $countryCode . $req->telephone);
                    $this->sendSms($sendMsg, $correctPhone);
                } else {
                    $this->sendMessage($sendMsg, $countryCode . $req->telephone);
                }
            }




            $this->sendEmail($this->email, "Your PaySprint Referral Account Actiavted");

            return redirect()->route('view referrer agent')->with('success', 'Successfully created!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function deleteSupportAgent($id)
    {
        $data = $this->deletecurrentSupportAgent($id);

        return redirect()->route('view user support agent')->with('success', 'Successfully deleted!');
    }


    public function integrationAction($id)
    {
        $data = $this->integrationConclusion($id);

        return redirect()->back()->with('success', 'Successfully updated!');
    }

    public function integrationConclusion($id)
    {
        $data = ThirdPartyIntegration::where('id', $id)->first();

        if ($data->status == true) {
            $status = false;
        } else {
            $status = true;
        }


        $result = ThirdPartyIntegration::where('id', $id)->update(['status' => $status]);

        return $result;
    }


    public function deleteReferrerAgent($id)
    {
        $data = $this->deletecurrentReferrerAgent($id);

        return redirect()->route('view referrer agent')->with('success', 'Successfully deleted!');
    }


    public function flagThisMoney(Request $req)
    {

        $data = $this->dothisflag($req->transaction_id);

        // Send Mail

        // Send Mail to the support agent
        $this->name = $data->name;
        $this->email = $data->email;
        $this->subject = "Your PaySprint Account is Temporarily Suspended. Take These Steps to Resolve it!!!";

        $this->message = '<p>Hello ' . $this->name . ', </p><p>Your PaySprint Account is temporarily suspended as our system is unable to match the details on your profile with the details on the source of funding your wallet which is against our Anti Money Laundering (AML) Policy.</p><p>In order to remove the temporary suspension on your account, kindly take the following steps:</p><p>a. Desist from adding funds to your wallet from Funding Source that does not have same details with your PaySprint profile and Government issued photo ID</p><p>b. Send us a copy of a Utility Bill with address that matches the address on your profile. Please send the copy of utility bill to: info@paysprint.ca</p><p>c. Upload a selfie of yourself (if you are yet to do so)</p><p>Kindly login to www.paysprint.ca and upload Items B and C above when the suspension on your PaySprint Account is removed.</p><p>We thank you for your understanding</p><p>Compliance Team at paysprint.ca</p><p></p>';

        $this->sendEmail($this->email, "Flagged Account");

        return back()->with('success', 'Successful!');
    }


    public function generateSpecialInfoActivity(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'activity' => $this->specialInformationData()
            );



            return view('admin.pages.generatespecialinfoactivity')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function createSupportAgent(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'activity' => $this->specialInformationData(),
                'allthecountries' => $this->getAllCountries()
            );



            return view('admin.pages.createsupport')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }



    public function createReferrerAgent(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'activity' => $this->specialInformationData(),
                'allthecountries' => $this->getAllCountries()
            );



            return view('admin.pages.createreferrer')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function editSupportAgent(Request $req, $id)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'user' => $this->getthisuserinfo($id),
                'allthecountries' => $this->getAllCountries()
            );



            return view('admin.pages.editsupport')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function editReferrerAgent(Request $req, $id)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'user' => $this->getthisreferrerinfo($id),
                'allthecountries' => $this->getAllCountries()
            );


            return view('admin.pages.editreferrer')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }



    public function viewSupportAgent(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'activity' => $this->getSupportAgent()
            );



            return view('admin.pages.viewsupport')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function viewReferrerAgent(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'activity' => $this->getReferrerAgent()
            );



            return view('admin.pages.viewreferrer')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }



    public function allCountries(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'allthecountries' => $this->getAllCountries(),
                'allpaymentgateway' => $this->getAllPaymentGateway()
            );




            return view('admin.pages.allthecountries')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }



    public function allPaidUserList(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'paiduserlist' => $this->getPaidUsersList(),
            );




            return view('admin.pages.allthepaiduserlist')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }




    public function allFreeUserList(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'freeuserlist' => $this->getFreeUsersList(),
            );




            return view('admin.pages.allthefreeuserlist')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }



    public function allCountriesPaymentGateway(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'allpaymentgateway' => $this->getAllPaymentGateway()
            );



            return view('admin.pages.allgatewaylist')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }

    public function allCountriesBankInformation(Request $req)
    {
        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'allcountries' => AllCountries::get()
            );



            return view('admin.pages.bankinformation')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }

    public function storeCountryPaymentGateway(Request $req)
    {
        try {

            PlatformPaymentGateway::updateOrCreate(['name' => $req->name], ['name' => $req->name]);

            return redirect()->back()->with('success', 'Payment gateway created!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }


    public function editCountryPaymentGateway(Request $req)
    {
        try {

            PlatformPaymentGateway::where('id', $req->id)->update(['name' => $req->name]);

            return redirect()->back()->with('success', 'Payment gateway updated!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }


    public function deleteCountryPaymentGateway(Request $req)
    {
        try {

            PlatformPaymentGateway::where('id', $req->id)->delete();

            return redirect()->back()->with('success', 'Payment gateway deleted!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }


    public function updateCountryGateway(Request $req)
    {
        try {

            AllCountries::where('id', $req->countryId)->update(['gateway' => $req->paymentGateway]);

            return redirect()->back()->with('success', 'Payment gateway updated!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }






    public function sendUserMessage(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $query = [
                    'user_id' => session('user_id'),
                    'name' => session('firstname') . ' ' . session('lastname'),
                    'activity' => 'Access to send a mail to a user today: ' . date('d-M-Y h:i:a'),
                ];

                $this->createSupportActivity($query);
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
                'allthecountries' => $this->getAllCountries(),
                'messageUser' => $this->allUserMessage(),
                'user' => $this->thisparticularUser($req->get('id'), $req->get('route'))
            );



            return view('admin.pages.sendmessage')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }

    public function getAllCountries()
    {
        $data = AllCountries::orderBy('approval', 'DESC')->get();

        return $data;
    }


    public function getAllPaymentGateway()
    {
        $data = PlatformPaymentGateway::orderBy('created_at', 'DESC')->get();

        return $data;
    }


    public function allUserMessage()
    {
        $data = InAppMessage::orderBy('created_at', 'DESC')->get();

        return $data;
    }

    public function thisparticularUser($id, $route = null)
    {
        if ($route == "Closed") {
            $data = UserClosed::where('id', $id)->first();
        } else {
            $data = User::where('id', $id)->first();
        }

        return $data;
    }

    public function bankRequestWithdrawal(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'bankRequestWithdrawal' => $this->requestFromBankWithdrawal(),
            );



            return view('admin.wallet.bankrequestwithdrawal')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }

    public function mobilemoneyRequestWithdrawal(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'mobilemoneyRequestWithdrawal' => $this->mobilemoneyrequestFromBankWithdrawal(),
            );



            return view('admin.wallet.mobilemoneyrequestwithdrawal')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }



    public function merchantBanksDetails(Request $req)
    {
        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'bankdetails' => $this->userBankDetails($req->get('country')),
            );




            return view('admin.wallet.merchantbankdetails')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }

    public function merchantBankDetailsByCountry(Request $req)
    {
        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'bankdetails' => $this->userBankDetailsByCountry(),
            );



            return view('admin.wallet.merchantbankdetailsbycountry')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function bankRequestWithdrawalByCountry(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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



            return view('admin.wallet.bankrequestwithdrawalbycountry')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }

    public function mobilemoneyRequestWithdrawalByCountry(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
            // dd($data);


            return view('admin.wallet.mobilemoneyrequestwithdrawalbycountry')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function purchaseRefundReturn(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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



            return view('admin.wallet.processrefundreturn')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }



    public function returnWithdrawal(Request $req, $id)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'returnRequest' => $this->returnFromBankWithdrawal($id),
            );


            return view('admin.wallet.returnwithdrawal')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }



    public function returnBankWithdrawal(Request $req, $id)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'returnRequest' => $this->returnFromBankWithdrawal($id),
            );


            return view('admin.wallet.returnbankwithdrawal')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }



    public function cardRequestWithdrawal(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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


            return view('admin.wallet.cardrequestwithdrawal')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function cardProcessedWithdrawal(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'cardProcessedWithdrawal' => $this->processedRequestFromCard(),
            );

            // dd($data);


            return view('admin.wallet.cardprocessedwithdrawal')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }



    public function pendingTransfer(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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


            return view('admin.wallet.pendingtransfer')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }
    public function textToTransfer(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'texttotransferusers' => $this->textToTransferUsers(),
            );

            // dd($data);


            return view('admin.wallet.texttotransferusers')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function bankProcessedWithdrawal(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'bankProcessedWithdrawal' => $this->bankProcessedRequestFromCard(),
            );

            // dd($data);


            return view('admin.wallet.bankprocessedwithdrawal')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }

    public function processedMobileMoneyRequest(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'bankProcessedWithdrawal' => $this->mobilemoneyProcessedRequest(),
            );

            // dd($data);


            return view('admin.wallet.mobilemoneyprocessedwithdrawal')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function cardrequestwithdrawalbycountry(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'cardRequestWithdrawalbycountry' => $this->requestFromCardWithdrawalByCountry($req->get('country')),
            );



            return view('admin.wallet.cardrequestwithdrawalbycountry')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function cardRequestProcessedByCountry(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'cardRequestProceesedbycountry' => $this->requestFromCardProceesedByCountry($req->get('country')),
            );



            return view('admin.wallet.cardrequestprocessedbycountry')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function bankRequestProcessedByCountry(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'bankRequestProceesedbycountry' => $this->requestFromBankProceesedByCountry($req->get('country')),
            );



            return view('admin.wallet.bankrequestprocessedbycountry')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }

    public function mobilemoneyRequestProcessedByCountry(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'bankRequestProceesedbycountry' => $this->requestFromBankProceesedByCountry($req->get('country')),
            );



            return view('admin.wallet.mobilemoneyrequestprocessedbycountry')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function pendingTransferByCountry(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'pendingtransferbycountry' => $this->pendingTransferTransactionByCountry($req->get('country')),
            );



            return view('admin.wallet.pendingtransferbycountry')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }



    public function textToTransferByCountry(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'texttotransferbycountry' => $this->textToTransferUsersByCountry($req->get('country')),
            );



            return view('admin.wallet.texttotransferbycountry')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function prepaidRequestWithdrawal(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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



            return view('admin.wallet.prepaidrequestwithdrawal')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }



    public function prepaidCardRequest(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'cardrequest' => $this->requestforPrepaidCard(),
            );


            return view('admin.wallet.requestforprepaidcard')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }



    public function refundMoneyRequest(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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



            return view('admin.wallet.refundrequestwithdrawal')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function escrowFundingList(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'getescrow' => $this->getEscrowFunding(),
                'transfer' => $this->electronicTransfers()
            );


            return view('admin.escrow.fundinglist')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }

    public function electronicTransferList(Request $req)
    {
        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'transfer' => $this->electronicTransfers()
            );


            return view('admin.escrow.electronictransfer')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }



    public function electronicTransfers()
    {
        $data = MonerisActivity::where('gateway', 'partner')->orderBy('created_at', 'DESC')->get();

        return $data;
    }

    public function confirmEsPay(Request $req)
    {

        try {
            $getTrans = FxStatement::where('user_id', $req->escrow_id)->first();



            // Update Confirmation and update Wallet
            $getwallet = EscrowAccount::where('escrow_id', $getTrans->user_id)->first();



            $wallet_balance = $getwallet->wallet_balance + $getTrans->credit;


            $thisuser = User::where('id', $getwallet->user_id)->first();

            FxStatement::where('user_id', $req->escrow_id)->update(['confirmation' => 'confirmed']);

            EscrowAccount::where('escrow_id', $req->escrow_id)->update(['wallet_balance' => $wallet_balance]);

            $activity = "Added " . $getwallet->currencyCode . '' . number_format($getTrans->credit, 2) . " to Escrow Wallet.";


            $sendMsg = "Hi " . $thisuser->name . ", You have " . $activity . " Your current escrow balance is " . $getwallet->currencyCode . ' ' . number_format($wallet_balance, 2) . ".";

            $usergetPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

            if (isset($usergetPhone)) {

                $sendPhone = $thisuser->telephone;
            } else {
                $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
            }

            if ($thisuser->country == "Nigeria") {

                $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                $this->sendSms($sendMsg, $correctPhone);
            } else {
                $this->sendMessage($sendMsg, $sendPhone);
            }


            $resData = "Payment Confirmed";
            $resp = "success";
        } catch (\Throwable $th) {
            $resData = $th->getMessage();
            $resp = "error";
        }


        return redirect()->back()->with($resp, $resData);
    }

    public function deleteEsPay(Request $req)
    {

        try {
            $getTrans = FxStatement::where('user_id', $req->escrow_id)->first();



            // Update Confirmation and update Wallet
            $getwallet = EscrowAccount::where('escrow_id', $getTrans->user_id)->first();



            $wallet_balance = $getwallet->wallet_balance + 0;


            $thisuser = User::where('id', $getwallet->user_id)->first();

            FxStatement::where('user_id', $req->escrow_id)->update(['confirmation' => 'declined']);

            EscrowAccount::where('escrow_id', $req->escrow_id)->update(['wallet_balance' => $wallet_balance]);

            $activity = $getwallet->currencyCode . '' . number_format($getTrans->credit, 2) . " to Escrow Wallet is declined.";


            $sendMsg = "Hi " . $thisuser->name . ", " . $activity . " Your current escrow balance is " . $getwallet->currencyCode . ' ' . number_format($wallet_balance, 2) . ".";

            $usergetPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

            if (isset($usergetPhone)) {

                $sendPhone = $thisuser->telephone;
            } else {
                $sendPhone = "+" . $thisuser->code . $thisuser->telephone;
            }

            if ($thisuser->country == "Nigeria") {

                $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                $this->sendSms($sendMsg, $correctPhone);
            } else {
                $this->sendMessage($sendMsg, $sendPhone);
            }


            $resData = "Payment Declined Successfully";
            $resp = "success";
        } catch (\Throwable $th) {
            $resData = $th->getMessage();
            $resp = "error";
        }


        return redirect()->back()->with($resp, $resData);
    }


    public function refundMoneyRequestByCountry(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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




    public function processedRefundMoneyRequest(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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



            return view('admin.wallet.refundrequestprocessed')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function bankRequestProcessed(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'bankRequestProcessed' => $this->requestFromBankProcessed(),
            );


            return view('admin.wallet.bankrequestprocessed')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function getRefundDetails(Request $req, $transid)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'getuserrefunddetails' => $this->getuserRefundDetails($transid),
            );

            return view('admin.wallet.getrefunddetails')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function merchantWithdrawal(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'bankRequestProcessed' => $this->requestFromBankProcessed(),
                'getuserDetail' => $this->getmyPersonalDetail(session('user_id')),
                'getCard' => $this->getUserCard(session('user_id')),
                'minimumWallet' => $this->getMinimumBalance(session('country')),
            );


            return view('admin.wallet.withdrawal')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }




    public function merchantAddMoney(Request $req)
    {


        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'bankRequestProcessed' => $this->requestFromBankProcessed(),
                'getuserDetail' => $this->getmyPersonalDetail(session('user_id')),
                'getCard' => $this->getUserCard(session('user_id')),
                'alpha2Code' => $this->getCountryCode(session('country')),
                'paymentgateway' => $this->getPaymentGateway(session('country'))
            );

            // dd($data);


            return view('admin.wallet.addmoney')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function merchantSendMoney(Request $req)
    {


        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'bankRequestProcessed' => $this->requestFromBankProcessed(),
                'getuserDetail' => $this->getmyPersonalDetail(session('user_id')),
                'getCard' => $this->getUserCard(session('user_id')),
                'alpha2Code' => $this->getCountryCode(session('country')),
                'allnotification' => $this->allnotification(session('email')),
                'newnotification' => $this->notification(session('email')),
            );



            return view('admin.wallet.sendmoney')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function merchantPaymentGateway(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'bankRequestProcessed' => $this->requestFromBankProcessed(),
                'getuserDetail' => $this->getmyPersonalDetail(session('user_id')),
                'getCard' => $this->getUserCard(session('user_id')),
                'getUserDetail' => $this->getmyPersonalDetail(session('user_id'))
            );


            return view('admin.wallet.merchantpaymentgateway')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function createnewPayment(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'bankRequestProcessed' => $this->requestFromBankProcessed(),
                'getuserDetail' => $this->getmyPersonalDetail(session('user_id')),
                'getCard' => $this->getUserCard(session('user_id')),
                'getUserDetail' => $this->getmyPersonalDetail(session('user_id')),
                'currencyCode' => $this->getCountryCode(session('country')),
                'getCard' => $this->getUserCard(session('myID')),
            );


            return view('admin.wallet.createnewpayment')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function paymentOrganization(Request $req, $user_id)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'bankRequestProcessed' => $this->requestFromBankProcessed(),
                'getuserDetail' => $this->getmyPersonalDetail(session('user_id')),
                'getCard' => $this->getUserCard(session('user_id')),
                'getUserDetail' => $this->getmyPersonalDetail(session('user_id')),
                'currencyCode' => $this->getCountryCode(session('country')),
                'getCard' => $this->getUserCard(session('myID')),
                'paymentorg' => $this->getthisOrganization($user_id),
                'othercurrencyCode' => $this->otherCurrencyCode($user_id),
                'alpha2Code' => $this->getCountryCode(session('country')),
            );




            return view('admin.wallet.payment')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function merchantCreditCard(Request $req, $id)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'getmycreditCard' => $this->getMyUserCard($id),
                'getUserCard' => $this->getUserCard($id),
            );


            return view('admin.card.getcreditcard')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function merchantDebitCard(Request $req, $id)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'getmydebitCard' => $this->getMyUserDebitCard($id),
                'getUserCard' => $this->getUserCard($id),
            );


            return view('admin.card.getdebitcard')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function merchantPrepaidCard(Request $req, $id)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'getmyprepaidCard' => $this->getUserPrepaidCard($id),
                'cardIssuer' => $this->getallCardIssuer(),
            );


            return view('admin.card.getprepaidcard')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }
    public function merchantBankAccount(Request $req, $id)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'getBankDetail' => $this->getUserBankDetail($id),
                'listbank' => $this->getBankList(),
            );


            return view('admin.card.getbankaccount')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }

    public function editMerchantBankAccount(Request $req, $id)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'getthisBank' => $this->getthisBank($id),
            );


            return view('admin.card.editbankaccount')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function editMerchantCreditCard(Request $req, $id)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'getthisCard' => $this->getthisCard($id),
                'cardIssuer' => $this->getallCardIssuer(),
            );


            return view('admin.card.editcreditcard')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function editMerchantDebitCard(Request $req, $id)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'getthisCard' => $this->getthisCard($id),
                'cardIssuer' => $this->getallCardIssuer(),
            );


            return view('admin.card.editdebitcard')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function editMerchantPrepaidCard(Request $req, $id)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'getthisCard' => $this->getthisCard($id),
                'cardIssuer' => $this->getallCardIssuer(),
            );


            return view('admin.card.editprepaidcard')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function getUserBankDetail($id)
    {

        $data = AddBank::where('user_id', $id)->orderBy('created_at', 'DESC')->get();

        return $data;
    }

    public function getthisBank($id)
    {

        $data = AddBank::where('id', $id)->first();

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

    public function getMinimumBalance($country)
    {

        $data = TransactionCost::where('structure', "Wallet Balance")->where('method', "Minimum Balance")->where('country', $country)->first();

        if (isset($data)) {
            $balance = $data->fixed;
        } else {
            $balance = 5;
        }

        return $balance;
    }
    public function getMyUserCard($id)
    {

        $data = AddCard::where('user_id', $id)->where('card_provider', 'Credit Card')->orderBy('created_at', 'DESC')->get();

        return $data;
    }
    public function getMyUserDebitCard($id)
    {

        $data = AddCard::where('user_id', $id)->where('card_provider', 'Debit Card')->orderBy('created_at', 'DESC')->get();

        return $data;
    }

    public function getUserPrepaidCard($id)
    {

        $data = AddCard::where('user_id', $id)->where('card_provider', '!=', 'Credit Card')->orderBy('created_at', 'DESC')->get();

        return $data;
    }

    public function getthisCard($id)
    {

        $data = AddCard::where('id', $id)->first();

        return $data;
    }

    public function getallCardIssuer()
    {

        $data = CardIssuer::orderBy('created_at', 'DESC')->get();

        return $data;
    }

    //function to get individual wallet balance
    public function getUserBalance($id)
    {
        $data = User::where('id', $id)->first();
        return $data;
    }

    public function userWalletBalance()
    {
        $data = User::select('id', 'name', 'email', 'ref_code')->orderBy('created_at', 'DESC')->get();

        return $data;
    }


    public function userWalletBalancebyCountry($country)
    {

        $data = User::where('country', $country)->orderBy('created_at', 'DESC')->get();

        return $data;
    }


    public function usermaintenancefeebyCountry($country)
    {

        $data = MonthlyFee::where('country', $country)->orderBy('created_at', 'DESC')->get();

        return $data;
    }

    public function userWalletBalancebyCategory()
    {
        $data = User::select('country', 'currencyCode', 'wallet_balance')->orderBy('created_at', 'DESC')->groupBy('country')->get();

        return $data;
    }


    public function allMaintenanceFeeDetail()
    {
        $data = MonthlyFee::orderBy('created_at', 'DESC')->groupBy('country')->get();

        return $data;
    }

    public function requestFromBankWithdrawal()
    {

        $data = BankWithdrawal::where('status', 'PENDING')->orderBy('created_at', 'DESC')->groupBy('country')->get();

        return $data;
    }

    public function mobilemoneyrequestFromBankWithdrawal()
    {

        $data = BankWithdrawal::where('status', 'PENDING')->where('bank_id', 'Mobile Money')->orderBy('created_at', 'DESC')->groupBy('country')->get();

        return $data;
    }

    public function userBankDetails($country)
    {

        $data = AddBank::where('country', $country)->orderBy('created_at', 'DESC')->get();

        return $data;
    }

    public function userBankDetailsByCountry()
    {

        if (session('role') == 'Aml compliance') {
            $data = AddBank::where('country', 'Canada')->orWhere('country', 'United States')->orderBy('created_at', 'DESC')->groupBy('country')->get();
        } else {
            $data = AddBank::orderBy('created_at', 'DESC')->groupBy('country')->get();
        }



        return $data;
    }


    public function purchaseRefundSentback()
    {

        $data = Statement::where('refund_state', 1)->where('actedOn', 0)->orderBy('created_at', 'DESC')->get();

        return $data;
    }

    public function requestFromBankWithdrawalByCountry($country)
    {

        $data = BankWithdrawal::where('status', 'PENDING')->where('country', $country)->orderBy('created_at', 'DESC')->get();

        return $data;
    }


    public function returnFromBankWithdrawal($id)
    {

        $data = Statement::where('reference_code', $id)->first();

        return $data;
    }


    public function bankProcessedRequestFromCard()
    {

        $data = BankWithdrawal::where('status', 'PROCESSED')->orderBy('created_at', 'DESC')->groupBy('country')->get();

        return $data;
    }

    public function mobilemoneyProcessedRequest()
    {

        $data = BankWithdrawal::where('status', 'PROCESSED')->where('bank_id', 'Mobile Money')->orderBy('created_at', 'DESC')->groupBy('country')->get();

        return $data;
    }


    public function requestFromBankProceesedByCountry($country)
    {

        $data = BankWithdrawal::where('status', 'PROCESSED')->where('country', $country)->orderBy('created_at', 'DESC')->get();

        return $data;
    }


    public function pendingTransferTransactionByCountry($country)
    {

        $data = Statement::where('status', 'Pending')->where('credit', '>', 0)->where('country', $country)->orderBy('created_at', 'DESC')->get();

        return $data;
    }


    public function textToTransferUsersByCountry($country)
    {

        $data = AnonUsers::where('country', $country)->orderBy('created_at', 'DESC')->get();

        return $data;
    }


    public function requestFromCardWithdrawal()
    {

        $data = CcWithdrawal::where('status', 'PENDING')->orderBy('created_at', 'DESC')->groupBy('country')->get();

        return $data;
    }


    public function processedRequestFromCard()
    {

        $data = CcWithdrawal::where('status', 'PROCESSED')->orderBy('created_at', 'DESC')->groupBy('country')->get();

        return $data;
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





    public function requestFromCardWithdrawalByCountry($country)
    {

        $data = CcWithdrawal::where('status', 'PENDING')->where('country', $country)->orderBy('created_at', 'DESC')->get();

        return $data;
    }





    public function requestFromCardProceesedByCountry($country)
    {

        $data = CcWithdrawal::where('status', 'PROCESSED')->where('country', $country)->orderBy('created_at', 'DESC')->get();

        return $data;
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


    public function requestforPrepaidCard()
    {

        // RUN CRON GET

        // $access_key = '6173fa628b16d8ce1e0db5cfa25092ac';

        if (env('APP_ENV') == "local") {
            $url = "http://localhost:4000/api/v1/paysprint/cardrequest";
        } else {
            $url = "https://exbc.ca/api/v1/paysprint/cardrequest";
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

    public function requestFromBankProcessed()
    {

        $data = BankWithdrawal::where('status', 'PROCESSED')->orderBy('created_at', 'DESC')->get();

        return $data;
    }


    public function requestForAllRefund()
    {

        $data = RequestRefund::where('status', '!=', 'PROCESSED')->orderBy('created_at', 'DESC')->get();

        return $data;
    }

    public function requestForRefund()
    {

        $data = RequestRefund::where('status', '!=', 'PROCESSED')->groupBy('country')->orderBy('created_at', 'DESC')->get();

        return $data;
    }


    public function requestForRefundByCountry($country)
    {

        $data = RequestRefund::where('status', '!=', 'PROCESSED')->where('country', $country)->orderBy('created_at', 'DESC')->get();

        return $data;
    }

    public function processedrequestForRefund()
    {

        $data = RequestRefund::where('status', 'PROCESSED')->orderBy('created_at', 'DESC')->get();

        return $data;
    }


    public function getuserRefundDetails($transid)
    {

        $data = RequestRefund::where('transaction_id', $transid)->first();

        return $data;
    }



    public function xreceivemoney(Request $req)
    {

        if ($req->session()->has('username') == true) {

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

            $getxPay = $this->getxReceive();

            // dd($getxPay);


            return view('admin.xreceivemoney')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'status' => '', 'message' => '', 'xpayRec' => $getxPay]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }

    public function updateinvoice(Request $req)
    {
        if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

        // Update User
        $update = ImportExcel::where('id', $req->id)->update(['transaction_date' => $req->transaction_date, 'payee_ref_no' => $req->payee_ref_no, 'name' => $req->name, 'description' => $req->description, 'amount' => $req->amount, 'remaining_balance' => $req->remaining_balance, 'payment_due_date' => $req->payment_due_date, 'payee_email' => $req->payee_email, 'service' => $req->service, 'installpay' => $req->installpay, 'installlimit' => $req->installlimit, 'recurring' => $req->recurring, 'reminder' => $req->reminder, 'created_at' => date('Y-m-d H:i:s', strtotime($req->created_at))]);


        if ($update ==  1) {
            $message = 'Updated Successfully';
            $status = 'success';

            $getCustomer = $this->getCustomer($req->id);
        } else {

            $message = 'Something went wrong';
            $status = 'error';

            $getCustomer = $this->getCustomer($req->id);
        }

        return view('admin.customer')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => $status, 'message' => $message]);
    }


    public function updateinvoicelink(Request $req)
    {
        if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

        // Update User
        $update = ImportExcelLink::where('id', $req->id)->update(['transaction_date' => $req->transaction_date, 'payee_ref_no' => $req->payee_ref_no, 'name' => $req->name, 'description' => $req->description, 'amount' => $req->amount, 'remaining_balance' => $req->remaining_balance, 'payment_due_date' => $req->payment_due_date, 'payee_email' => $req->payee_email, 'service' => $req->service, 'installpay' => $req->installpay, 'installlimit' => $req->installlimit, 'recurring' => $req->recurring, 'reminder' => $req->reminder, 'created_at' => date('Y-m-d H:i:s', strtotime($req->created_at))]);


        if ($update ==  1) {
            $message = 'Updated Successfully';
            $status = 'success';

            $getCustomer = $this->getLinkCustomer($req->id);
        } else {

            $message = 'Something went wrong';
            $status = 'error';

            $getCustomer = $this->getLinkCustomer($req->id);
        }

        return view('admin.linkcustomer')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => $status, 'message' => $message]);
    }

    public function increaseTransLimit(Request $req)
    {
        $user = User::where('id', $req->id)->update(['withdrawal_per_transaction' => $req->withdrawal_per_transaction]);

        if (isset($user)) {
            $resData = "Successfully Adjusted";
            $resp = "success";
        } else {
            $resData = "Something went wrong!. Try Again";
            $resp = "error";
        }

        return redirect()->back()->with($resp, $resData);
    }


    public function increaseOverdraftLimit(Request $req)
    {

        $thisuser = User::where('id', $req->id)->first();

        if ($thisuser->wallet_balance >= 0 || $thisuser->overdraft_balance === NULL || $thisuser->wallet_balance >= $thisuser->overdraft_balance) {
            $user = User::where('id', $req->id)->update(['withdrawal_per_overdraft' => $req->withdrawal_per_overdraft, 'overdraft_balance' => $req->withdrawal_per_overdraft]);
        } else {
            $user = User::where('id', $req->id)->update(['withdrawal_per_overdraft' => $req->withdrawal_per_overdraft]);
        }



        if (isset($user)) {
            $resData = "Successfully Adjusted";
            $resp = "success";
        } else {
            $resData = "Something went wrong!. Try Again";
            $resp = "error";
        }

        return redirect()->back()->with($resp, $resData);
    }


    public function createPricingSetup(Request $req)
    {

        $insertRec = PricingSetup::updateOrCreate(['country' => $req->country], $req->all());

        if ($insertRec == true) {
            $resData = "Pricing successfully setup.";
            $resp = "success";
        } else {
            $resData = "Something went wrong!. Try Again";
            $resp = "error";
        }


        return redirect()->back()->with($resp, $resData);
    }

    public function createFeeStructure(Request $req)
    {

        if ($req->structure == "Others") {
            $structure = $req->other_structure;
        } else {
            $structure = $req->structure;
        }

        if ($req->method == "Others") {
            $method = $req->other_method;
        } else {
            $method = $req->method;
        }

        // Insert Record
        $rec = TransactionCost::insert(['_token' => $req->_token, 'variable' => $req->variable, 'fixed' => $req->fixed, 'structure' => $structure, 'method' => $method, 'country' => $req->country]);

        $resData = "Saved";
        $resp = "success";

        return redirect()->back()->with($resp, $resData);
    }


    public function editFeeStructure(Request $req, $id)
    {
        // Insert Record
        $rec = TransactionCost::where('id', $id)->update($req->all());

        $resData = "Updated successfully";
        $resp = "success";

        return redirect()->back()->with($resp, $resData);
    }


    public function deleteFee(Request $req, $id)
    {

        $rec = TransactionCost::where('id', $id)->delete();

        $resData = "Deleted";
        $resp = "success";

        return redirect()->back()->with($resp, $resData);
    }



    public function createCardIssuer(Request $req)
    {
        CardIssuer::insert($req->all());

        $resData = "Saved";
        $resp = "success";

        return redirect()->back()->with($resp, $resData);
    }

    public function editThisCardIssuer(Request $req, $id)
    {
        // Insert Record
        $rec = CardIssuer::where('id', $id)->update($req->all());

        $resData = "Updated successfully";
        $resp = "success";

        return redirect()->back()->with($resp, $resData);
    }

    public function deleteCardIssuer(Request $req, $id)
    {

        $rec = CardIssuer::where('id', $id)->delete();

        $resData = "Deleted";
        $resp = "success";

        return redirect()->back()->with($resp, $resData);
    }


    public function paycaremittance(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

            $getwithdraw = $this->withdrawpaycaRemittance();

            $transCost = $this->transactionCost();

            return view('admin.paycaremittance')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }

    public function remittanceepayreport(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

            $getreport = $this->remittancereportepayAdmin();

            $transCost = $this->transactionCost();

            return view('admin.remittanceepayreport')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getreport' => $getreport, 'transCost' => $transCost]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }

    public function remittancepaycareport(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

            $getreport = $this->remittancereportpaycaAdmin();

            $transCost = $this->transactionCost();

            return view('admin.remittancepaycareport')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getreport' => $getreport, 'transCost' => $transCost]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }

    public function getStatement(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $otherPays = DB::table('invoice_payment')
                    ->select(DB::raw('invoice_payment.transactionid, invoice_payment.name, invoice_payment.email, import_excel.amount as invoice_amount, invoice_payment.invoice_no, invoice_payment.service, invoice_payment.created_at as transaction_date, import_excel.description as description, invoice_payment.remaining_balance as runningbalance, invoice_payment.amount as amount_paid, import_excel.status, invoice_payment.mystatus'))->distinct()
                    ->join('import_excel', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')
                    ->where('import_excel.uploaded_by', session('user_id'))
                    ->orderBy('invoice_payment.created_at', 'DESC')->get();
            }

            $client = $this->getMyClientInfo(session('user_id'));

            if ($client->accountMode == "test") {

                return redirect()->route('dashboard')->with('error', 'You are in test mode');
            }


            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();

            $transCost = $this->transactionCost();

            $servicetypes = $this->getServiceTypes();



            return view('admin.statement')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'transCost' => $transCost, 'servicetypes' => $servicetypes]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }

    public function claimReward(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'allthecountries' => $this->getAllCountries(),
                'pointsclaim' => $this->getClaimedPoints()
            );



            return view('admin.claimreward')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function cashAdvanceList(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'allthecountries' => $this->getAllCountries(),
                'cashadvance' => $this->getCashAdvanceList()
            );



            return view('admin.cashadvancelist')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function crossBorderList(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'allthecountries' => $this->getAllCountries(),
                'crossborder' => $this->getCrossBorderList()
            );



            return view('admin.crossborderlist')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }



    public function crossBorderBeneficiaryDetail(Request $req, $id)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
                'allthecountries' => $this->getAllCountries(),
                'beneficiary' => $this->getThisBeneficiary($id)
            );



            return view('admin.crossborderbeneficiarydetail')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'getwithdraw' => $getwithdraw, 'transCost' => $transCost, 'collectfee' => $collectfee, 'getClient' => $getClient, 'getCustomer' => $getCustomer, 'status' => '', 'message' => '', 'xpayRec' => $getxPay, 'allusers' => $allusers, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }

    public function getCashAdvanceList()
    {
        $data = CashAdvance::orderBy('created_at', 'DESC')->get();

        return $data;
    }


    public function getCrossBorderList()
    {
        $data = CrossBorder::where('status', false)->orderBy('created_at', 'DESC')->get();

        return $data;
    }


    public function getCashAdvanceCount()
    {
        $data = CashAdvance::count();

        return $data;
    }

    public function getCrossBorderCount()
    {
        $data = CrossBorder::where('status', false)->count();

        return $data;
    }


    public function getStatementReport(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $otherPays = DB::table('invoice_payment')
                    ->select(DB::raw('invoice_payment.transactionid, invoice_payment.name, invoice_payment.email, import_excel.amount as invoice_amount, invoice_payment.invoice_no, invoice_payment.service, invoice_payment.created_at as transaction_date, import_excel.description as description, invoice_payment.remaining_balance as runningbalance, invoice_payment.amount as amount_paid, import_excel.status, invoice_payment.mystatus'))->distinct()
                    ->join('import_excel', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')
                    ->where('import_excel.uploaded_by', session('user_id'))
                    ->orderBy('invoice_payment.created_at', 'DESC')->get();
            }


            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();

            $transCost = $this->transactionCost();

            $servicetypes = $this->getServiceTypes();

            $thisdata = [
                'result' => $this->getStatementRecordByDate($req->statement_service, $req->statement_start, $req->statement_end),
            ];


            return view('admin.statementreport')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'transCost' => $transCost, 'servicetypes' => $servicetypes, 'thisdata' => $thisdata]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function sentInvoiceReport(Request $req)
    {


        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $otherPays = DB::table('invoice_payment')
                    ->select(DB::raw('invoice_payment.transactionid, invoice_payment.name, invoice_payment.email, import_excel.amount as invoice_amount, invoice_payment.invoice_no, invoice_payment.service, invoice_payment.created_at as transaction_date, import_excel.description as description, invoice_payment.remaining_balance as runningbalance, invoice_payment.amount as amount_paid, import_excel.status, invoice_payment.mystatus'))->distinct()
                    ->join('import_excel', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')
                    ->where('import_excel.uploaded_by', session('user_id'))
                    ->orderBy('invoice_payment.created_at', 'DESC')->get();
            }


            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();

            $transCost = $this->transactionCost();

            $servicetypes = $this->getServiceTypes();

            $client = $this->getMyClientInfo(session('user_id'));

            if ($client->accountMode == "test") {

                return redirect()->route('dashboard')->with('error', 'You are in test mode');
            }

            $data = [
                'getsentInvoice' => $this->getSentInvoice(session('user_id')),
                'userInfo' => $this->getmyPersonalDetail(session('user_id')),
            ];


            return view('admin.performance.sentinvoice')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'transCost' => $transCost, 'servicetypes' => $servicetypes, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function sentInvoiceReportByDate(Request $req)
    {


        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $otherPays = DB::table('invoice_payment')
                    ->select(DB::raw('invoice_payment.transactionid, invoice_payment.name, invoice_payment.email, import_excel.amount as invoice_amount, invoice_payment.invoice_no, invoice_payment.service, invoice_payment.created_at as transaction_date, import_excel.description as description, invoice_payment.remaining_balance as runningbalance, invoice_payment.amount as amount_paid, import_excel.status, invoice_payment.mystatus'))->distinct()
                    ->join('import_excel', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')
                    ->where('import_excel.uploaded_by', session('user_id'))
                    ->orderBy('invoice_payment.created_at', 'DESC')->get();
            }


            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();

            $transCost = $this->transactionCost();

            $servicetypes = $this->getServiceTypes();

            $data = [
                'getsentInvoice' => $this->getSentInvoiceByDate($req->get('start'), $req->get('end'), session('user_id')),
                'userInfo' => $this->getmyPersonalDetail(session('user_id')),
            ];


            return view('admin.performance.sentinvoicebydate')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'transCost' => $transCost, 'servicetypes' => $servicetypes, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function paidInvoiceReport(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $otherPays = DB::table('invoice_payment')
                    ->select(DB::raw('invoice_payment.transactionid, invoice_payment.name, invoice_payment.email, import_excel.amount as invoice_amount, invoice_payment.invoice_no, invoice_payment.service, invoice_payment.created_at as transaction_date, import_excel.description as description, invoice_payment.remaining_balance as runningbalance, invoice_payment.amount as amount_paid, import_excel.status, invoice_payment.mystatus'))->distinct()
                    ->join('import_excel', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')
                    ->where('import_excel.uploaded_by', session('user_id'))
                    ->orderBy('invoice_payment.created_at', 'DESC')->get();
            }


            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();

            $transCost = $this->transactionCost();

            $servicetypes = $this->getServiceTypes();

            $client = $this->getMyClientInfo(session('user_id'));

            if ($client->accountMode == "test") {

                return redirect()->route('dashboard')->with('error', 'You are in test mode');
            }

            $data = [
                'getpaidInvoice' => $this->getPaidInvoice(session('user_id')),
                'userInfo' => $this->getmyPersonalDetail(session('user_id')),
            ];


            return view('admin.performance.paidinvoice')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'transCost' => $transCost, 'servicetypes' => $servicetypes, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }

    public function paidInvoiceReportByDate(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $otherPays = DB::table('invoice_payment')
                    ->select(DB::raw('invoice_payment.transactionid, invoice_payment.name, invoice_payment.email, import_excel.amount as invoice_amount, invoice_payment.invoice_no, invoice_payment.service, invoice_payment.created_at as transaction_date, import_excel.description as description, invoice_payment.remaining_balance as runningbalance, invoice_payment.amount as amount_paid, import_excel.status, invoice_payment.mystatus'))->distinct()
                    ->join('import_excel', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')
                    ->where('import_excel.uploaded_by', session('user_id'))
                    ->orderBy('invoice_payment.created_at', 'DESC')->get();
            }


            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();

            $transCost = $this->transactionCost();

            $servicetypes = $this->getServiceTypes();

            $data = [
                'getpaidInvoice' => $this->getPaidInvoiceByDate($req->get('start'), $req->get('end'), session('user_id')),
                'userInfo' => $this->getmyPersonalDetail(session('user_id')),
            ];


            return view('admin.performance.paidinvoicebydate')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'transCost' => $transCost, 'servicetypes' => $servicetypes, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function unpaidInvoiceReport(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $otherPays = DB::table('invoice_payment')
                    ->select(DB::raw('invoice_payment.transactionid, invoice_payment.name, invoice_payment.email, import_excel.amount as invoice_amount, invoice_payment.invoice_no, invoice_payment.service, invoice_payment.created_at as transaction_date, import_excel.description as description, invoice_payment.remaining_balance as runningbalance, invoice_payment.amount as amount_paid, import_excel.status, invoice_payment.mystatus'))->distinct()
                    ->join('import_excel', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')
                    ->where('import_excel.uploaded_by', session('user_id'))
                    ->orderBy('invoice_payment.created_at', 'DESC')->get();
            }


            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();

            $transCost = $this->transactionCost();

            $servicetypes = $this->getServiceTypes();

            $client = $this->getMyClientInfo(session('user_id'));

            if ($client->accountMode == "test") {

                return redirect()->route('dashboard')->with('error', 'You are in test mode');
            }

            $data = [
                'getunpaidInvoice' => $this->getUnpaidInvoice(session('user_id')),
                'userInfo' => $this->getmyPersonalDetail(session('user_id')),
            ];


            return view('admin.performance.unpaidinvoice')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'transCost' => $transCost, 'servicetypes' => $servicetypes, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function unpaidInvoiceReportByDate(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $otherPays = DB::table('invoice_payment')
                    ->select(DB::raw('invoice_payment.transactionid, invoice_payment.name, invoice_payment.email, import_excel.amount as invoice_amount, invoice_payment.invoice_no, invoice_payment.service, invoice_payment.created_at as transaction_date, import_excel.description as description, invoice_payment.remaining_balance as runningbalance, invoice_payment.amount as amount_paid, import_excel.status, invoice_payment.mystatus'))->distinct()
                    ->join('import_excel', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')
                    ->where('import_excel.uploaded_by', session('user_id'))
                    ->orderBy('invoice_payment.created_at', 'DESC')->get();
            }


            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();

            $transCost = $this->transactionCost();

            $servicetypes = $this->getServiceTypes();

            $data = [
                'getunpaidInvoice' => $this->getUnpaidInvoiceByDate($req->get('start'), $req->get('end'), session('user_id')),
                'userInfo' => $this->getmyPersonalDetail(session('user_id')),
            ];


            return view('admin.performance.unpaidinvoicebydate')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'transCost' => $transCost, 'servicetypes' => $servicetypes, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }

    public function customerBalanceReport(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $otherPays = DB::table('invoice_payment')
                    ->select(DB::raw('invoice_payment.transactionid, invoice_payment.name, invoice_payment.email, import_excel.amount as invoice_amount, invoice_payment.invoice_no, invoice_payment.service, invoice_payment.created_at as transaction_date, import_excel.description as description, invoice_payment.remaining_balance as runningbalance, invoice_payment.amount as amount_paid, import_excel.status, invoice_payment.mystatus'))->distinct()
                    ->join('import_excel', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')
                    ->where('import_excel.uploaded_by', session('user_id'))
                    ->orderBy('invoice_payment.created_at', 'DESC')->get();
            }


            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();

            $transCost = $this->transactionCost();

            $servicetypes = $this->getServiceTypes();

            $client = $this->getMyClientInfo(session('user_id'));

            if ($client->accountMode == "test") {

                return redirect()->route('dashboard')->with('error', 'You are in test mode');
            }

            $data = [
                'getcustomerBalance' => $this->getcustomerBalance(session('user_id')),
                'userInfo' => $this->getmyPersonalDetail(session('user_id')),
            ];



            return view('admin.performance.customerbalance')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'transCost' => $transCost, 'servicetypes' => $servicetypes, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function customerBalanceReportByDate(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $otherPays = DB::table('invoice_payment')
                    ->select(DB::raw('invoice_payment.transactionid, invoice_payment.name, invoice_payment.email, import_excel.amount as invoice_amount, invoice_payment.invoice_no, invoice_payment.service, invoice_payment.created_at as transaction_date, import_excel.description as description, invoice_payment.remaining_balance as runningbalance, invoice_payment.amount as amount_paid, import_excel.status, invoice_payment.mystatus'))->distinct()
                    ->join('import_excel', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')
                    ->where('import_excel.uploaded_by', session('user_id'))
                    ->orderBy('invoice_payment.created_at', 'DESC')->get();
            }


            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();

            $transCost = $this->transactionCost();

            $servicetypes = $this->getServiceTypes();

            $data = [
                'getcustomerBalance' => $this->getcustomerBalanceByDate($req->get('start'), $req->get('end'), session('user_id')),
                'userInfo' => $this->getmyPersonalDetail(session('user_id')),
            ];



            return view('admin.performance.customerbalancebydate')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'transCost' => $transCost, 'servicetypes' => $servicetypes, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function taxReport(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $otherPays = DB::table('invoice_payment')
                    ->select(DB::raw('invoice_payment.transactionid, invoice_payment.name, invoice_payment.email, import_excel.amount as invoice_amount, invoice_payment.invoice_no, invoice_payment.service, invoice_payment.created_at as transaction_date, import_excel.description as description, invoice_payment.remaining_balance as runningbalance, invoice_payment.amount as amount_paid, import_excel.status, invoice_payment.mystatus'))->distinct()
                    ->join('import_excel', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')
                    ->where('import_excel.uploaded_by', session('user_id'))
                    ->orderBy('invoice_payment.created_at', 'DESC')->get();
            }


            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();

            $transCost = $this->transactionCost();

            $servicetypes = $this->getServiceTypes();

            $client = $this->getMyClientInfo(session('user_id'));

            if ($client->accountMode == "test") {

                return redirect()->route('dashboard')->with('error', 'You are in test mode');
            }

            $data = [
                'gettotalTax' => $this->getSentInvoice(session('user_id')),
                'userInfo' => $this->getmyPersonalDetail(session('user_id')),
            ];



            return view('admin.performance.taxreport')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'transCost' => $transCost, 'servicetypes' => $servicetypes, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function invoiceTypeReport(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $otherPays = DB::table('invoice_payment')
                    ->select(DB::raw('invoice_payment.transactionid, invoice_payment.name, invoice_payment.email, import_excel.amount as invoice_amount, invoice_payment.invoice_no, invoice_payment.service, invoice_payment.created_at as transaction_date, import_excel.description as description, invoice_payment.remaining_balance as runningbalance, invoice_payment.amount as amount_paid, import_excel.status, invoice_payment.mystatus'))->distinct()
                    ->join('import_excel', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')
                    ->where('import_excel.uploaded_by', session('user_id'))
                    ->orderBy('invoice_payment.created_at', 'DESC')->get();
            }


            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();

            $transCost = $this->transactionCost();

            $servicetypes = $this->getServiceTypes();

            $client = $this->getMyClientInfo(session('user_id'));

            if ($client->accountMode == "test") {

                return redirect()->route('dashboard')->with('error', 'You are in test mode');
            }

            $data = [
                'getinvoiceType' => $this->getinvoiceType(session('user_id')),
                'userInfo' => $this->getmyPersonalDetail(session('user_id')),
            ];



            return view('admin.performance.invoicetype')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'transCost' => $transCost, 'servicetypes' => $servicetypes, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }

    public function recurringReport(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $otherPays = DB::table('invoice_payment')
                    ->select(DB::raw('invoice_payment.transactionid, invoice_payment.name, invoice_payment.email, import_excel.amount as invoice_amount, invoice_payment.invoice_no, invoice_payment.service, invoice_payment.created_at as transaction_date, import_excel.description as description, invoice_payment.remaining_balance as runningbalance, invoice_payment.amount as amount_paid, import_excel.status, invoice_payment.mystatus'))->distinct()
                    ->join('import_excel', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')
                    ->where('import_excel.uploaded_by', session('user_id'))
                    ->orderBy('invoice_payment.created_at', 'DESC')->get();
            }


            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();

            $transCost = $this->transactionCost();

            $servicetypes = $this->getServiceTypes();

            $client = $this->getMyClientInfo(session('user_id'));

            if ($client->accountMode == "test") {

                return redirect()->route('dashboard')->with('error', 'You are in test mode');
            }

            $data = [
                'getrecurringReport' => $this->getrecurringReport(session('user_id')),
                'userInfo' => $this->getmyPersonalDetail(session('user_id')),
            ];



            return view('admin.performance.recurringreport')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'transCost' => $transCost, 'servicetypes' => $servicetypes, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }



    public function businessReport(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $otherPays = DB::table('invoice_payment')
                    ->select(DB::raw('invoice_payment.transactionid, invoice_payment.name, invoice_payment.email, import_excel.amount as invoice_amount, invoice_payment.invoice_no, invoice_payment.service, invoice_payment.created_at as transaction_date, import_excel.description as description, invoice_payment.remaining_balance as runningbalance, invoice_payment.amount as amount_paid, import_excel.status, invoice_payment.mystatus'))->distinct()
                    ->join('import_excel', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')
                    ->where('import_excel.uploaded_by', session('user_id'))
                    ->orderBy('invoice_payment.created_at', 'DESC')->get();
            }


            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();

            $transCost = $this->transactionCost();

            $servicetypes = $this->getServiceTypes();




            return view('admin.report.businessreport')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'transCost' => $transCost, 'servicetypes' => $servicetypes]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function revenueReport(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $otherPays = DB::table('invoice_payment')
                    ->select(DB::raw('invoice_payment.transactionid, invoice_payment.name, invoice_payment.email, import_excel.amount as invoice_amount, invoice_payment.invoice_no, invoice_payment.service, invoice_payment.created_at as transaction_date, import_excel.description as description, invoice_payment.remaining_balance as runningbalance, invoice_payment.amount as amount_paid, import_excel.status, invoice_payment.mystatus'))->distinct()
                    ->join('import_excel', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')
                    ->where('import_excel.uploaded_by', session('user_id'))
                    ->orderBy('invoice_payment.created_at', 'DESC')->get();
            }


            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();

            $transCost = $this->transactionCost();

            $servicetypes = $this->getServiceTypes();




            return view('admin.report.revenuereport')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'transCost' => $transCost, 'servicetypes' => $servicetypes]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }



    public function accountReport(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $otherPays = DB::table('invoice_payment')
                    ->select(DB::raw('invoice_payment.transactionid, invoice_payment.name, invoice_payment.email, import_excel.amount as invoice_amount, invoice_payment.invoice_no, invoice_payment.service, invoice_payment.created_at as transaction_date, import_excel.description as description, invoice_payment.remaining_balance as runningbalance, invoice_payment.amount as amount_paid, import_excel.status, invoice_payment.mystatus'))->distinct()
                    ->join('import_excel', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')
                    ->where('import_excel.uploaded_by', session('user_id'))
                    ->orderBy('invoice_payment.created_at', 'DESC')->get();
            }


            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();

            $transCost = $this->transactionCost();

            $servicetypes = $this->getServiceTypes();

            $data = [
                'activecountries' => $this->getActiveCountries()
            ];



            return view('admin.report.accountreport')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'transCost' => $transCost, 'servicetypes' => $servicetypes, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }

    //wallet credit promopage
    public function promoPage(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $otherPays = DB::table('invoice_payment')
                    ->select(DB::raw('invoice_payment.transactionid, invoice_payment.name, invoice_payment.email, import_excel.amount as invoice_amount, invoice_payment.invoice_no, invoice_payment.service, invoice_payment.created_at as transaction_date, import_excel.description as description, invoice_payment.remaining_balance as runningbalance, invoice_payment.amount as amount_paid, import_excel.status, invoice_payment.mystatus'))->distinct()
                    ->join('import_excel', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')
                    ->where('import_excel.uploaded_by', session('user_id'))
                    ->orderBy('invoice_payment.created_at', 'DESC')->get();
            }


            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();

            $transCost = $this->transactionCost();

            $servicetypes = $this->getServiceTypes();


            return view('walletcredit.promopage')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'transCost' => $transCost, 'servicetypes' => $servicetypes]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }

    //uploading the excel sheet of promo users
    public function uploadPromoUsers(Request $req)
    {
        $validation = $req->validate([
            'promo_docs' => 'required'
        ]);

        $query = $req->all();


        $data = Excel::import(new SurveyImport($query), $req->file('promo_docs'));


        return back()->with("msg", "<div class='alert alert-success'> Imported Successfully</div>");
    }



    //uploading the unverified merchants into database
    public function uploadUnverifiedMerchants(Request $req)
    {
        $validation = $req->validate([
            'unverified_docs' => 'required'
        ]);

        $data = Excel::import(new MerchantImport(), $req->file('unverified_docs'));


        return back()->with("msg", "<div class='alert alert-success'> Imported Successfully</div>");
    }

    //listing out the promo users from database
    public function promoUsers(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $otherPays = DB::table('invoice_payment')
                    ->select(DB::raw('invoice_payment.transactionid, invoice_payment.name, invoice_payment.email, import_excel.amount as invoice_amount, invoice_payment.invoice_no, invoice_payment.service, invoice_payment.created_at as transaction_date, import_excel.description as description, invoice_payment.remaining_balance as runningbalance, invoice_payment.amount as amount_paid, import_excel.status, invoice_payment.mystatus'))->distinct()
                    ->join('import_excel', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')
                    ->where('import_excel.uploaded_by', session('user_id'))
                    ->orderBy('invoice_payment.created_at', 'DESC')->get();
            }


            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();

            $transCost = $this->transactionCost();

            $servicetypes = $this->getServiceTypes();

            $data = [
                'promo' => SurveyExcel::get()
            ];


            return view('walletcredit.promousers')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'transCost' => $transCost, 'servicetypes' => $servicetypes, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }

    //Report for wallet credit
    public function promoReport(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $otherPays = DB::table('invoice_payment')
                    ->select(DB::raw('invoice_payment.transactionid, invoice_payment.name, invoice_payment.email, import_excel.amount as invoice_amount, invoice_payment.invoice_no, invoice_payment.service, invoice_payment.created_at as transaction_date, import_excel.description as description, invoice_payment.remaining_balance as runningbalance, invoice_payment.amount as amount_paid, import_excel.status, invoice_payment.mystatus'))->distinct()
                    ->join('import_excel', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')
                    ->where('import_excel.uploaded_by', session('user_id'))
                    ->orderBy('invoice_payment.created_at', 'DESC')->get();
            }


            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();

            $transCost = $this->transactionCost();

            $servicetypes = $this->getServiceTypes();

            $data = [
                'report' => SurveyReport::groupBy('country')->get(),
                'total' => SurveyReport::groupBy('country')->selectRaw('sum(wallet_credit_amount) as sum, country')->pluck('sum', 'country'),
            ];

            // dd($data);




            return view('walletcredit.promoreport')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'transCost' => $transCost, 'servicetypes' => $servicetypes, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }

    //total sum by country
    public function totalCountrySum()
    {
        $data = SurveyReport::groupBy('country')->get();
        if (isset($data)) {
            $result =  SurveyReport::groupBy('country')->get()->sum('wallet_credit_amount');
        } else {
            $result = 0;
        }

        return $result;
    }

    //Referral claims
    public function referralClaim(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $otherPays = DB::table('invoice_payment')
                    ->select(DB::raw('invoice_payment.transactionid, invoice_payment.name, invoice_payment.email, import_excel.amount as invoice_amount, invoice_payment.invoice_no, invoice_payment.service, invoice_payment.created_at as transaction_date, import_excel.description as description, invoice_payment.remaining_balance as runningbalance, invoice_payment.amount as amount_paid, import_excel.status, invoice_payment.mystatus'))->distinct()
                    ->join('import_excel', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')
                    ->where('import_excel.uploaded_by', session('user_id'))
                    ->orderBy('invoice_payment.created_at', 'DESC')->get();
            }


            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();

            $transCost = $this->transactionCost();

            $servicetypes = $this->getServiceTypes();

            $data = [
                'claim' => ReferralClaim::where('status', 'pending')->get(),

            ];


            return view('walletcredit.referralclaim')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'transCost' => $transCost, 'servicetypes' => $servicetypes, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }

    //suspend claim
    public function deleteClaim(Request $req, $id)
    {
        $data = ReferralClaim::where('id', $id)->delete();

        return back()->with("msg", "<div class='alert alert-success'>Claim Suspended Successfully</div>");
    }

    //suspended referral claims
    public function suspendedReferralClaim(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $otherPays = DB::table('invoice_payment')
                    ->select(DB::raw('invoice_payment.transactionid, invoice_payment.name, invoice_payment.email, import_excel.amount as invoice_amount, invoice_payment.invoice_no, invoice_payment.service, invoice_payment.created_at as transaction_date, import_excel.description as description, invoice_payment.remaining_balance as runningbalance, invoice_payment.amount as amount_paid, import_excel.status, invoice_payment.mystatus'))->distinct()
                    ->join('import_excel', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')
                    ->where('import_excel.uploaded_by', session('user_id'))
                    ->orderBy('invoice_payment.created_at', 'DESC')->get();
            }


            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();

            $transCost = $this->transactionCost();

            $servicetypes = $this->getServiceTypes();

            $data = [
                'claim' => ReferralClaim::onlyTrashed()->get()

            ];


            return view('walletcredit.suspendedclaim')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'transCost' => $transCost, 'servicetypes' => $servicetypes, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    //restore claims
    public function restoreClaim(Request $req, $id)
    {

        $data = ReferralClaim::withTrashed()->find($id)->restore();

        return back()->with("msg", "<div class='alert alert-success'>Claim restored Successfully</div>");
    }

    //successful referral claims
    public function successfulReferralClaim(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $otherPays = DB::table('invoice_payment')
                    ->select(DB::raw('invoice_payment.transactionid, invoice_payment.name, invoice_payment.email, import_excel.amount as invoice_amount, invoice_payment.invoice_no, invoice_payment.service, invoice_payment.created_at as transaction_date, import_excel.description as description, invoice_payment.remaining_balance as runningbalance, invoice_payment.amount as amount_paid, import_excel.status, invoice_payment.mystatus'))->distinct()
                    ->join('import_excel', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')
                    ->where('import_excel.uploaded_by', session('user_id'))
                    ->orderBy('invoice_payment.created_at', 'DESC')->get();
            }


            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();

            $transCost = $this->transactionCost();

            $servicetypes = $this->getServiceTypes();

            $data = [
                'claim' => ReferralClaim::where('status', 'completed')->get(),

            ];


            return view('walletcredit.successreferalclaim')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'transCost' => $transCost, 'servicetypes' => $servicetypes, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }
    // promo date
    public function promoDate(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $otherPays = DB::table('invoice_payment')
                    ->select(DB::raw('invoice_payment.transactionid, invoice_payment.name, invoice_payment.email, import_excel.amount as invoice_amount, invoice_payment.invoice_no, invoice_payment.service, invoice_payment.created_at as transaction_date, import_excel.description as description, invoice_payment.remaining_balance as runningbalance, invoice_payment.amount as amount_paid, import_excel.status, invoice_payment.mystatus'))->distinct()
                    ->join('import_excel', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')
                    ->where('import_excel.uploaded_by', session('user_id'))
                    ->orderBy('invoice_payment.created_at', 'DESC')->get();
            }


            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();

            $transCost = $this->transactionCost();

            $servicetypes = $this->getServiceTypes();

            $data = [
                'promo' => PromoDate::get(),

            ];


            return view('walletcredit.promodate')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'transCost' => $transCost, 'servicetypes' => $servicetypes, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }





    //view for special promo users
    public function specialPromoUsers(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $otherPays = DB::table('invoice_payment')
                    ->select(DB::raw('invoice_payment.transactionid, invoice_payment.name, invoice_payment.email, import_excel.amount as invoice_amount, invoice_payment.invoice_no, invoice_payment.service, invoice_payment.created_at as transaction_date, import_excel.description as description, invoice_payment.remaining_balance as runningbalance, invoice_payment.amount as amount_paid, import_excel.status, invoice_payment.mystatus'))->distinct()
                    ->join('import_excel', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')
                    ->where('import_excel.uploaded_by', session('user_id'))
                    ->orderBy('invoice_payment.created_at', 'DESC')->get();
            }


            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();

            $transCost = $this->transactionCost();

            $servicetypes = $this->getServiceTypes();

            $data = [
                'promo' => PromoDate::get(),

            ];


            return view('walletcredit.specialpromousers')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'transCost' => $transCost, 'servicetypes' => $servicetypes, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }

    //promo participants
    public function promoParticipants(Request $req, $id)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $otherPays = DB::table('invoice_payment')
                    ->select(DB::raw('invoice_payment.transactionid, invoice_payment.name, invoice_payment.email, import_excel.amount as invoice_amount, invoice_payment.invoice_no, invoice_payment.service, invoice_payment.created_at as transaction_date, import_excel.description as description, invoice_payment.remaining_balance as runningbalance, invoice_payment.amount as amount_paid, import_excel.status, invoice_payment.mystatus'))->distinct()
                    ->join('import_excel', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')
                    ->where('import_excel.uploaded_by', session('user_id'))
                    ->orderBy('invoice_payment.created_at', 'DESC')->get();
            }


            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();

            $transCost = $this->transactionCost();

            $servicetypes = $this->getServiceTypes();

            $data = [
                'promo' => SpecialPromo::where('special_promo_id', $id)->where('activated', 'yes')->get(),
                'promodata' => PromoDate::where('id', $id)->first()
            ];

            // dd($data['promo']);

            return view('walletcredit.promoparticipants')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'transCost' => $transCost, 'servicetypes' => $servicetypes, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }



    //  inserting promo date to database
    public function insertPromoDate(Request $req)
    {
        $validation = $req->validate([
            'startdate' => 'required',
            'enddate' => 'required',
            'amount' => 'required',
            'promo_details' => 'required'
        ]);

        PromoDate::insert([
            'start_date' => $req->startdate,
            'end_date' => $req->enddate,
            'amount' => $req->amount,
            'promo_details' => $req->promo_details
        ]);

        return back()->with("msg", "<div class='alert alert-success'>Promo Date Successfully Created</div> ");
    }
    //update promo page
    public function updatePromoDate(Request $req, $id)
    {

        $validation = $req->validate([
            'startdate' => 'required',
            'enddate' => 'required',
            'amount' => 'required',
            'promo_details' => 'required'
        ]);


        PromoDate::where('id', $id)->update([
            'start_date' => $req->startdate,
            'end_date' => $req->enddate,
            'amount' => $req->amount,
            'promo_details' => $req->promo_details
        ]);

        return redirect()->route('promo date')->with("msg", "<div class='alert alert-success'>Promo Date Successfully Updated</div> ");
    }

    //Delete promo

    public function deletePromoDate(Request $req, $id)
    {
        PromoDate::where('id', $id)->delete();

        return redirect()->route('promo date')->with("msg", "<div class='alert alert-success'>Promo Date Successfully Deleted</div> ");
    }

    //join Promo
    public function joinPromo(Request $req, $id)
    {

        $userid = Auth::id();
        $user = User::where('id', $userid)->first();
        $email = $user->email;
        $existinguser = SpecialPromo::where('user_id', $userid)->where('special_promo_id', $id)->first();

        //$existeduserid = $existinguser['special_promo_id'];
        //dd($existeduserid);
        if ($existinguser) {
            return back()->with("msg", "<div class='alert alert-danger'>You are already participating in the promo</div> ");
        }

        SpecialPromo::create([
            'user_id' => $userid,
            'email' => $email,
            'activated' => 'yes',
            'special_promo_id' => $id,
        ]);

        return back()->with("msg", "<div class='alert alert-success'>You have successfully joined the Special-Promo Program.  You can now start referring families and friends from today to earn additional referral points to your Refer+Earn Points Account. </div> ");
    }

    //  edit promo code
    public function editPromoDate(Request $req, $id)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $otherPays = DB::table('invoice_payment')
                    ->select(DB::raw('invoice_payment.transactionid, invoice_payment.name, invoice_payment.email, import_excel.amount as invoice_amount, invoice_payment.invoice_no, invoice_payment.service, invoice_payment.created_at as transaction_date, import_excel.description as description, invoice_payment.remaining_balance as runningbalance, invoice_payment.amount as amount_paid, import_excel.status, invoice_payment.mystatus'))->distinct()
                    ->join('import_excel', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')
                    ->where('import_excel.uploaded_by', session('user_id'))
                    ->orderBy('invoice_payment.created_at', 'DESC')->get();
            }


            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();

            $transCost = $this->transactionCost();

            $servicetypes = $this->getServiceTypes();

            $data = [
                'data' => PromoDate::where('id', $id)->first(),
            ];


            return view('walletcredit.editpromodate')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'transCost' => $transCost, 'servicetypes' => $servicetypes, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }

    //successful point claim
    public function successfulPointClaim(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $otherPays = DB::table('invoice_payment')
                    ->select(DB::raw('invoice_payment.transactionid, invoice_payment.name, invoice_payment.email, import_excel.amount as invoice_amount, invoice_payment.invoice_no, invoice_payment.service, invoice_payment.created_at as transaction_date, import_excel.description as description, invoice_payment.remaining_balance as runningbalance, invoice_payment.amount as amount_paid, import_excel.status, invoice_payment.mystatus'))->distinct()
                    ->join('import_excel', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')
                    ->where('import_excel.uploaded_by', session('user_id'))
                    ->orderBy('invoice_payment.created_at', 'DESC')->get();
            }


            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();

            $transCost = $this->transactionCost();

            $servicetypes = $this->getServiceTypes();

            $data = [
                'claim' => ClaimedPoints::where('status', 'completed')->get(),

            ];


            return view('walletcredit.successfulpoint')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'transCost' => $transCost, 'servicetypes' => $servicetypes, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    //Process Referral Claim
    public function processReferralClaim(Request $req)
    {
        $user = $req->id;
        $data = ReferralClaim::where('id', $user)->first();
        $client = $data->user_id;
        $usertype = $data->user_type;
        $usercountry = $data->country;
        $consumer = TransactionCost::where('country', $usercountry)->where('structure', 'Consumer Monthly Subscription')->first();
        $merchant = TransactionCost::where('country', $usercountry)->where('structure', 'Merchant Monthly Subscription')->first();
        $consumerfee = $consumer->fixed;
        $merchantfee = $merchant->fixed;
        $country = $consumer->country;
        $merchantcountry = $merchant->country;



        if ($usertype == 'Individual' && $country == $usercountry) {
            $referralclaim = $consumerfee / 2;
            $userinfo = User::where('id', $client)->first();
            $walletbalance = $userinfo->wallet_balance;
            $totalwalletbalance = $walletbalance + $referralclaim;

            User::where('id', $client)->update([
                'wallet_balance' => $totalwalletbalance,
            ]);

            ReferralClaim::where('id', $user)->update([
                'status' => 'Completed',
                'amount' => $referralclaim
            ]);
        }

        if ($usertype == 'Merchant' && $merchantcountry == $usercountry) {
            $referralclaim = $merchantfee / 2;
            $userinfo = User::where('id', $client)->first();
            $walletbalance = $userinfo->wallet_balance;
            $totalwalletbalance = $walletbalance + $referralclaim;
            User::where('id', $client)->update([
                'wallet_balance' => $totalwalletbalance,
            ]);
            ReferralClaim::where('id', $user)->update([
                'status' => 'Completed',
                'amount' =>   $referralclaim
            ]);
        }




        // Send SMS

        $message = 'Congratulations!, You have received a wallet credit of ' . $userinfo->currencyCode . ' ' . number_format($referralclaim, 2) . ' from PaySprint as referral bonus' . '. Your wallet balance is ' . $userinfo->currencyCode . ' ' . number_format($totalwalletbalance, 2) . '. Thanks for Choosing PaySprint.';

        $this->name = $userinfo->name;
        // $this->email = "youngskima@gmail.com";
        $this->to = $userinfo->email;
        $this->subject = "PaySprint Wallet Referral Bonus";

        $this->message = $message;


        $this->sendEmail($this->to, "Refund Request");
        $this->createNotification($userinfo->ref_code, $message);
        $activity = 'Wallet credit of ' . $userinfo->currencyCode . '' . $referralclaim . 'in wallet for referral ';
        $credit = $referralclaim;
        $debit = 0;
        $reference_number = "wallet-" . date('dmY') . time();
        $balance = 0;
        $trans_date = date('Y-m-d');
        $status = "Delivered";
        $action = "Wallet credit";
        $regards = $userinfo->ref_code;
        $statement_route = "wallet";

        // Senders statement
        $this->insStatement($userinfo->email, $reference_number, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, $userinfo->country, 0);



        $usersPhone = User::where('email', $userinfo->email)->where('telephone', 'LIKE', '%+%')->first();

        if (isset($usersPhone)) {

            $recipients = $userinfo->telephone;
        } else {
            $recipients = "+" . $userinfo->code . $userinfo->telephone;
        }



        if ($userinfo->country == "Nigeria") {

            $correctPhone = preg_replace("/[^0-9]/", "", $recipients);

            $this->sendSms($message, $correctPhone);
        } else {
            $this->sendMessage($message, $recipients);
        }


        return back()->with("msg", "<div class='alert alert-success'>Referral Claim Successful</div>");
    }



    //process point claim
    public function processPointClaim(Request $req)
    {
        $user = $req->id;
        $data = ClaimedPoints::where('id', $user)->first();
        $client = $data->user_id;
        $users = User::where('id', $client)->first();
        $usertype = $users->accountType;
        $usercountry = $users->country;
        $consumer = TransactionCost::where('country', $usercountry)->where('structure', 'Consumer Monthly Subscription')->first();
        $merchant = TransactionCost::where('country', $usercountry)->where('structure', 'Merchant Monthly Subscription')->first();
        $consumerfee = $consumer->fixed;
        $merchantfee = $merchant->fixed;
        $country = $consumer->country;
        $merchantcountry = $merchant->country;



        if ($usertype == 'Individual' && $country == $usercountry) {
            $pointclaim = $consumerfee / 2;
            $userinfo = User::where('id', $client)->first();
            $walletbalance = $userinfo->wallet_balance;
            $totalwalletbalance = $walletbalance + $pointclaim;

            User::where('id', $client)->update([
                'wallet_balance' => $totalwalletbalance,
            ]);

            ClaimedPoints::where('id', $user)->update([
                'status' => 'Completed',
                'amount' => $pointclaim,
            ]);
        }

        if ($usertype == 'Merchant' && $merchantcountry == $usercountry) {
            $referralclaim = $merchantfee / 2;
            $userinfo = User::where('id', $client)->first();
            $walletbalance = $userinfo->wallet_balance;
            $totalwalletbalance = $walletbalance + $referralclaim;
            User::where('id', $client)->update([
                'wallet_balance' => $totalwalletbalance,
            ]);
            ClaimedPoints::where('id', $user)->update([
                'status' => 'Completed',
                'amount' =>  $referralclaim,
            ]);
        }
        // Send SMS

        $message = 'Congratulations!, You have received a wallet credit of ' . $userinfo->currencyCode . ' ' . number_format($pointclaim, 2) . ' from PaySprint as claimed points bonus' . '. Your wallet balance is ' . $userinfo->currencyCode . ' ' . number_format($totalwalletbalance, 2) . '. Thanks for Choosing PaySprint.';

        $this->name = $userinfo->name;
        // $this->email = "youngskima@gmail.com";
        $this->to = $userinfo->email;
        $this->subject = "PaySprint Wallet ClaimedPoints Credit";

        $this->message = $message;


        $this->sendEmail($this->to, "Refund Request");
        $this->createNotification($userinfo->ref_code, $message);
        $activity = 'Wallet credit of ' . $userinfo->currencyCode . '' . $pointclaim . 'in wallet for claimed points  ';
        $credit = $pointclaim;
        $debit = 0;
        $reference_number = "wallet-" . date('dmY') . time();
        $balance = 0;
        $trans_date = date('Y-m-d');
        $status = "Delivered";
        $action = "Wallet credit";
        $regards = $userinfo->ref_code;
        $statement_route = "wallet";

        // Senders statement
        $this->insStatement($userinfo->email, $reference_number, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, $userinfo->country, 0);



        $usersPhone = User::where('email', $userinfo->email)->where('telephone', 'LIKE', '%+%')->first();

        if (isset($usersPhone)) {

            $recipients = $userinfo->telephone;
        } else {
            $recipients = "+" . $userinfo->code . $userinfo->telephone;
        }



        if ($userinfo->country == "Nigeria") {

            $correctPhone = preg_replace("/[^0-9]/", "", $recipients);

            $this->sendSms($message, $correctPhone);
        } else {
            $this->sendMessage($message, $recipients);
        }


        return back()->with("msg", "<div class='alert alert-success'>Point Claim Successful</div>");
    }



    //Referral Report
    public function referralReport(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $otherPays = DB::table('invoice_payment')
                    ->select(DB::raw('invoice_payment.transactionid, invoice_payment.name, invoice_payment.email, import_excel.amount as invoice_amount, invoice_payment.invoice_no, invoice_payment.service, invoice_payment.created_at as transaction_date, import_excel.description as description, invoice_payment.remaining_balance as runningbalance, invoice_payment.amount as amount_paid, import_excel.status, invoice_payment.mystatus'))->distinct()
                    ->join('import_excel', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')
                    ->where('import_excel.uploaded_by', session('user_id'))
                    ->orderBy('invoice_payment.created_at', 'DESC')->get();
            }


            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();

            $transCost = $this->transactionCost();

            $servicetypes = $this->getServiceTypes();

            $data = [
                'report' => ReferralClaim::groupBy('country')->get(),
                'total' => ReferralClaim::groupBy('country')->selectRaw('sum(points_claimed) as sum, country')->pluck('sum', 'country'),
                'userlist' => User::where('referred_by', '!=', null)->groupBy('country')->get(),

            ];



            return view('walletcredit.referralreport')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'transCost' => $transCost, 'servicetypes' => $servicetypes, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }

    //View Referral Report
    public function viewReferralReport(Request $req)
    {
        if ($req->session()->has('username') == true) {
            // dd($req->all());
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $otherPays = DB::table('invoice_payment')
                    ->select(DB::raw('invoice_payment.transactionid, invoice_payment.name, invoice_payment.email, import_excel.amount as invoice_amount, invoice_payment.invoice_no, invoice_payment.service, invoice_payment.created_at as transaction_date, import_excel.description as description, invoice_payment.remaining_balance as runningbalance, invoice_payment.amount as amount_paid, import_excel.status, invoice_payment.mystatus'))->distinct()
                    ->join('import_excel', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')
                    ->where('import_excel.uploaded_by', session('user_id'))
                    ->orderBy('invoice_payment.created_at', 'DESC')->get();
            }


            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();

            $transCost = $this->transactionCost();

            $servicetypes = $this->getServiceTypes();


            $report = User::where('referral_points', '!=', null)->where('country', $req->country)->get();

            // } else {
            //     $report = SurveyReport::where('country', $req->country)
            //         ->where('credit_reason', $promotype)
            //         ->whereBetween('created_at', [$startDate, $endDate])
            //         ->get();
            // }

            $data = [
                'report' => $report,
            ];

            // dd($data['report']);




            return view('walletcredit.viewreferralreport')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'transCost' => $transCost, 'servicetypes' => $servicetypes, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }

    //View Refferal Details
    public function viewReferralDetails(Request $req)
    {
        if ($req->session()->has('username') == true) {
            // dd($req->all());
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $otherPays = DB::table('invoice_payment')
                    ->select(DB::raw('invoice_payment.transactionid, invoice_payment.name, invoice_payment.email, import_excel.amount as invoice_amount, invoice_payment.invoice_no, invoice_payment.service, invoice_payment.created_at as transaction_date, import_excel.description as description, invoice_payment.remaining_balance as runningbalance, invoice_payment.amount as amount_paid, import_excel.status, invoice_payment.mystatus'))->distinct()
                    ->join('import_excel', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')
                    ->where('import_excel.uploaded_by', session('user_id'))
                    ->orderBy('invoice_payment.created_at', 'DESC')->get();
            }


            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();

            $transCost = $this->transactionCost();

            $servicetypes = $this->getServiceTypes();


            $report = User::where('referred_by', $req->refcode)->get();

            // } else {
            //     $report = SurveyReport::where('country', $req->country)
            //         ->where('credit_reason', $promotype)
            //         ->whereBetween('created_at', [$startDate, $endDate])
            //         ->get();
            // }

            $data = [
                'report' => $report,
            ];

            // dd($data['report']);




            return view('walletcredit.referraldetails')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'transCost' => $transCost, 'servicetypes' => $servicetypes, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    //topping the wallet
    public function topUpWallet(Request $req)
    {

        $validation = $req->validate([
            'userid' => 'required',
            'topup_credit' => 'required',
            'topup_reason' => 'required',
            'topup_description' => 'required'
        ]);

        $user = $this->getUserBalance($req->userid);
        $reason = $req->topup_reason;
        $description = $req->topup_description;
        $walletbalance = $user->wallet_balance;


        $totalwallet = $walletbalance + $req->topup_credit;

        User::where('id', $req->userid)->update([
            'wallet_balance' => $totalwallet
        ]);

        SurveyReport::insert([
            'user_id' => $req->userid,
            'country' => $user->country,
            'wallet_credit_amount' => $req->topup_credit,
            'credit_reason' => $req->topup_reason
        ]);

        Walletcredit::insert([
            'user_id' => $req->userid,
            'wallet_credit' => $req->topup_credit,
            'reason' => $req->topup_reason,
        ]);


        // Send Mail...



        // Send SMS

        $message = 'Congratulations!, You have received a wallet credit of ' . $user->currencyCode . ' ' . number_format($req->topup_credit, 2) . ' from PaySprint for ' . $reason . ' | Desc: ' . $description . '. Your wallet balance is ' . $user->currencyCode . ' ' . $totalwallet . '. Thanks for Choosing PaySprint.';

        $this->name = $user->name;
        // $this->email = "youngskima@gmail.com";
        $this->to = $user->email;
        $this->subject = "PaySprint Wallet Credit for " . $reason;

        $this->message = $message;


        $this->sendEmail($this->to, "Reward Credit");
        $this->createNotification($user->ref_code, $message);
        $activity = 'Wallet credit of ' . $user->currencyCode . '' . $req->topup_credit . 'in wallet for ' . $reason;
        $credit = $req->topup_credit;
        $debit = 0;
        $reference_number = "wallet-" . date('dmY') . time();
        $balance = 0;
        $trans_date = date('Y-m-d');
        $status = "Delivered";
        $action = "Wallet credit";
        $regards = $user->ref_code;
        $statement_route = "wallet";

        // Senders statement
        $this->insStatement($user->email, $reference_number, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, $user->country, 0);



        $usersPhone = User::where('email', $user->email)->where('telephone', 'LIKE', '%+%')->first();

        if (isset($usersPhone)) {

            $recipients = $user->telephone;
        } else {
            $recipients = "+" . $user->code . $user->telephone;
        }



        if ($user->country == "Nigeria") {

            $correctPhone = preg_replace("/[^0-9]/", "", $recipients);

            $this->sendSms($message, $correctPhone);
        } else {
            $this->sendMessage($message, $recipients);
        }


        $this->deletePromoUser($user->email);

        return redirect()->route('promo users')->with("msg", "<div class='alert alert-success'>Wallet Top-up Successfully</div>");
    }

    //topping refereral point
    public function topupReferralPoint(Request $req)
    {

        // dd($req->all());

        $validation = $req->validate([
            'userid' => 'required',
            'topup_point' => 'required',
            'topup_reason' => 'required',
            'promoid' => 'required',
        ]);

        $user = $this->getUserBalance($req->userid);
        $reason = $req->topup_reason;
        $referralpointbalance = $user->referral_points;


        $totalpoint =  $referralpointbalance + $req->topup_point;

        User::where('id', $req->userid)->update([
            'referral_points' => $totalpoint
        ]);

        SpecialPromo::where('user_id', $req->userid)->update([
            'activated' => 'Credited with Special Promo Point'
        ]);

        SpecialpromoReport::insert([
            'user_id' => $req->userid,
            'promo_id' => $req->promoid,
            'Total point credited' => $req->topup_point,
        ]);


        // Send Mail...



        // Send SMS

        $message = 'Congratulations!, You have received a Referral Point credit of ' . number_format($req->topup_point, 2) . ' from PaySprint for participating in our ' . $reason . 'Your Referral Points balance is ' . $totalpoint . '. Thanks for Choosing PaySprint.';

        $this->name = $user->name;
        // $this->email = "youngskima@gmail.com";
        $this->to = $user->email;
        $this->subject = "PaySprint Referral Point Credit for " . $reason;

        $this->message = $message;


        $this->sendEmail(
            $this->to,
            "Referral Point Credit"
        );
        $this->createNotification($user->ref_code, $message);
        $activity = 'Referral Point Credit of ' . $req->topup_point . 'added to referral point for participating in the  ' . $reason;
        $credit = $req->topup_point;
        $debit = 0;
        $reference_number = "promo-" . date('dmY') . time();
        $balance = 0;
        $trans_date = date('Y-m-d');
        $status = "Delivered";
        $action = "Referral Point Credit";
        $regards = $user->ref_code;
        $statement_route = "Promo";

        // Senders statement
        $this->insStatement($user->email, $reference_number, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, $user->country, 0);



        $usersPhone = User::where('email', $user->email)->where('telephone', 'LIKE', '%+%')->first();

        if (isset($usersPhone)) {

            $recipients = $user->telephone;
        } else {
            $recipients = "+" . $user->code . $user->telephone;
        }



        if ($user->country == "Nigeria") {

            $correctPhone = preg_replace("/[^0-9]/", "", $recipients);

            $this->sendSms(
                $message,
                $correctPhone
            );
        } else {
            $this->sendMessage($message, $recipients);
        }




        return redirect()->route('promo participant')->with("msg", "<div class='alert alert-success'>Referral Point credited Successfully</div>");
    }

    //view report
    public function viewReport(Request $req)
    {
        if ($req->session()->has('username') == true) {
            // dd($req->all());
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $otherPays = DB::table('invoice_payment')
                    ->select(DB::raw('invoice_payment.transactionid, invoice_payment.name, invoice_payment.email, import_excel.amount as invoice_amount, invoice_payment.invoice_no, invoice_payment.service, invoice_payment.created_at as transaction_date, import_excel.description as description, invoice_payment.remaining_balance as runningbalance, invoice_payment.amount as amount_paid, import_excel.status, invoice_payment.mystatus'))->distinct()
                    ->join('import_excel', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')
                    ->where('import_excel.uploaded_by', session('user_id'))
                    ->orderBy('invoice_payment.created_at', 'DESC')->get();
            }


            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();

            $transCost = $this->transactionCost();

            $servicetypes = $this->getServiceTypes();

            $startDate = $req->start_date;
            $endDate = $req->end_date;
            $promotype = $req->topup_type;



            if ($startDate == null) {
                $report = SurveyReport::where('country', $req->country)->get();
            } else {
                $report = SurveyReport::where('country', $req->country)
                    ->where('credit_reason', $promotype)
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->get();
            }

            $data = [
                'report' => $report,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'promo_type' => $promotype,
            ];





            return view('walletcredit.viewreport')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'transCost' => $transCost, 'servicetypes' => $servicetypes, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }

    public function deletePromoUser($email)
    {
        $data = SurveyExcel::where('email', $email)->delete();
        return $data;
    }

    public function invoiceCommissionReport(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $otherPays = DB::table('invoice_payment')
                    ->select(DB::raw('invoice_payment.transactionid, invoice_payment.name, invoice_payment.email, import_excel.amount as invoice_amount, invoice_payment.invoice_no, invoice_payment.service, invoice_payment.created_at as transaction_date, import_excel.description as description, invoice_payment.remaining_balance as runningbalance, invoice_payment.amount as amount_paid, import_excel.status, invoice_payment.mystatus'))->distinct()
                    ->join('import_excel', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')
                    ->where('import_excel.uploaded_by', session('user_id'))
                    ->orderBy('invoice_payment.created_at', 'DESC')->get();
            }


            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();

            $transCost = $this->transactionCost();

            $servicetypes = $this->getServiceTypes();

            $data = [
                'invcommission' => $this->getInvoiceCommission()
            ];



            return view('admin.report.invoicecommission')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'transCost' => $transCost, 'servicetypes' => $servicetypes, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }

    public function inflowReport(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $otherPays = DB::table('invoice_payment')
                    ->select(DB::raw('invoice_payment.transactionid, invoice_payment.name, invoice_payment.email, import_excel.amount as invoice_amount, invoice_payment.invoice_no, invoice_payment.service, invoice_payment.created_at as transaction_date, import_excel.description as description, invoice_payment.remaining_balance as runningbalance, invoice_payment.amount as amount_paid, import_excel.status, invoice_payment.mystatus'))->distinct()
                    ->join('import_excel', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')
                    ->where('import_excel.uploaded_by', session('user_id'))
                    ->orderBy('invoice_payment.created_at', 'DESC')->get();
            }


            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();

            $transCost = $this->transactionCost();

            $servicetypes = $this->getServiceTypes();

            $data = [
                'getinflowbycountry' => $this->getInflowByCountry(),
            ];


            return view('admin.report.inflowreport')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'transCost' => $transCost, 'servicetypes' => $servicetypes, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function withdrawalReport(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $otherPays = DB::table('invoice_payment')
                    ->select(DB::raw('invoice_payment.transactionid, invoice_payment.name, invoice_payment.email, import_excel.amount as invoice_amount, invoice_payment.invoice_no, invoice_payment.service, invoice_payment.created_at as transaction_date, import_excel.description as description, invoice_payment.remaining_balance as runningbalance, invoice_payment.amount as amount_paid, import_excel.status, invoice_payment.mystatus'))->distinct()
                    ->join('import_excel', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')
                    ->where('import_excel.uploaded_by', session('user_id'))
                    ->orderBy('invoice_payment.created_at', 'DESC')->get();
            }


            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();

            $transCost = $this->transactionCost();

            $servicetypes = $this->getServiceTypes();

            $data = [
                'getwithdrawalbycountry' => $this->getWithdrawalByCountry(),
            ];


            return view('admin.report.withdrawalreport')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'transCost' => $transCost, 'servicetypes' => $servicetypes, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function inflowByCountryReport(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $otherPays = DB::table('invoice_payment')
                    ->select(DB::raw('invoice_payment.transactionid, invoice_payment.name, invoice_payment.email, import_excel.amount as invoice_amount, invoice_payment.invoice_no, invoice_payment.service, invoice_payment.created_at as transaction_date, import_excel.description as description, invoice_payment.remaining_balance as runningbalance, invoice_payment.amount as amount_paid, import_excel.status, invoice_payment.mystatus'))->distinct()
                    ->join('import_excel', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')
                    ->where('import_excel.uploaded_by', session('user_id'))
                    ->orderBy('invoice_payment.created_at', 'DESC')->get();
            }


            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();

            $transCost = $this->transactionCost();

            $servicetypes = $this->getServiceTypes();

            $data = [
                'getinflowbycountry' => $this->getReportInflowByCountry($req->get('country')),
            ];



            return view('admin.report.inflowreportbycountry')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'transCost' => $transCost, 'servicetypes' => $servicetypes, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }



    public function withdrawalByCountryReport(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $otherPays = DB::table('invoice_payment')
                    ->select(DB::raw('invoice_payment.transactionid, invoice_payment.name, invoice_payment.email, import_excel.amount as invoice_amount, invoice_payment.invoice_no, invoice_payment.service, invoice_payment.created_at as transaction_date, import_excel.description as description, invoice_payment.remaining_balance as runningbalance, invoice_payment.amount as amount_paid, import_excel.status, invoice_payment.mystatus'))->distinct()
                    ->join('import_excel', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')
                    ->where('import_excel.uploaded_by', session('user_id'))
                    ->orderBy('invoice_payment.created_at', 'DESC')->get();
            }


            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();

            $transCost = $this->transactionCost();

            $servicetypes = $this->getServiceTypes();

            $data = [
                'getwithdrawalbycountry' => $this->getReportWithdrawalByCountry($req->get('country')),
            ];



            return view('admin.report.withdrawalreportbycountry')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'transCost' => $transCost, 'servicetypes' => $servicetypes, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function getBusinessReport(Request $req)
    {



        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $otherPays = DB::table('invoice_payment')
                    ->select(DB::raw('invoice_payment.transactionid, invoice_payment.name, invoice_payment.email, import_excel.amount as invoice_amount, invoice_payment.invoice_no, invoice_payment.service, invoice_payment.created_at as transaction_date, import_excel.description as description, invoice_payment.remaining_balance as runningbalance, invoice_payment.amount as amount_paid, import_excel.status, invoice_payment.mystatus'))->distinct()
                    ->join('import_excel', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')
                    ->where('import_excel.uploaded_by', session('user_id'))
                    ->orderBy('invoice_payment.created_at', 'DESC')->get();
            }


            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();

            $transCost = $this->transactionCost();

            $servicetypes = $this->getServiceTypes();

            $data = [
                'result' => $this->getBusinessRecordByDate($req->country, $req->start, $req->end),
            ];



            return view('admin.report.businesscollation')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'transCost' => $transCost, 'servicetypes' => $servicetypes, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }



    public function getRevenueReport(Request $req)
    {



        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $otherPays = DB::table('invoice_payment')
                    ->select(DB::raw('invoice_payment.transactionid, invoice_payment.name, invoice_payment.email, import_excel.amount as invoice_amount, invoice_payment.invoice_no, invoice_payment.service, invoice_payment.created_at as transaction_date, import_excel.description as description, invoice_payment.remaining_balance as runningbalance, invoice_payment.amount as amount_paid, import_excel.status, invoice_payment.mystatus'))->distinct()
                    ->join('import_excel', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')
                    ->where('import_excel.uploaded_by', session('user_id'))
                    ->orderBy('invoice_payment.created_at', 'DESC')->get();
            }


            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();

            $transCost = $this->transactionCost();

            $servicetypes = $this->getServiceTypes();

            $data = [
                'result' => $this->getBusinessRecordByDate($req->country, $req->start, $req->end),
            ];



            return view('admin.report.revenuecollation')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'transCost' => $transCost, 'servicetypes' => $servicetypes, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }



    public function netAmountToWallet(Request $req)
    {



        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $otherPays = DB::table('invoice_payment')
                    ->select(DB::raw('invoice_payment.transactionid, invoice_payment.name, invoice_payment.email, import_excel.amount as invoice_amount, invoice_payment.invoice_no, invoice_payment.service, invoice_payment.created_at as transaction_date, import_excel.description as description, invoice_payment.remaining_balance as runningbalance, invoice_payment.amount as amount_paid, import_excel.status, invoice_payment.mystatus'))->distinct()
                    ->join('import_excel', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')
                    ->where('import_excel.uploaded_by', session('user_id'))
                    ->orderBy('invoice_payment.created_at', 'DESC')->get();
            }


            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();

            $transCost = $this->transactionCost();

            $servicetypes = $this->getServiceTypes();

            $data = [
                'result' => $this->receivedNetamounttoWallet($req->country, $req->start, $req->end),
            ];



            return view('admin.report.netamounttowallet')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'transCost' => $transCost, 'servicetypes' => $servicetypes, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function netFxAmountToWallet(Request $req)
    {



        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $otherPays = DB::table('invoice_payment')
                    ->select(DB::raw('invoice_payment.transactionid, invoice_payment.name, invoice_payment.email, import_excel.amount as invoice_amount, invoice_payment.invoice_no, invoice_payment.service, invoice_payment.created_at as transaction_date, import_excel.description as description, invoice_payment.remaining_balance as runningbalance, invoice_payment.amount as amount_paid, import_excel.status, invoice_payment.mystatus'))->distinct()
                    ->join('import_excel', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')
                    ->where('import_excel.uploaded_by', session('user_id'))
                    ->orderBy('invoice_payment.created_at', 'DESC')->get();
            }


            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();

            $transCost = $this->transactionCost();

            $servicetypes = $this->getServiceTypes();

            $data = [
                'result' => $this->receivedNetFxamounttoWallet($req->country, $req->start, $req->end),
            ];



            return view('admin.report.netfxamounttowallet')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'transCost' => $transCost, 'servicetypes' => $servicetypes, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function chargeOnAddMoney(Request $req)
    {



        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $otherPays = DB::table('invoice_payment')
                    ->select(DB::raw('invoice_payment.transactionid, invoice_payment.name, invoice_payment.email, import_excel.amount as invoice_amount, invoice_payment.invoice_no, invoice_payment.service, invoice_payment.created_at as transaction_date, import_excel.description as description, invoice_payment.remaining_balance as runningbalance, invoice_payment.amount as amount_paid, import_excel.status, invoice_payment.mystatus'))->distinct()
                    ->join('import_excel', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')
                    ->where('import_excel.uploaded_by', session('user_id'))
                    ->orderBy('invoice_payment.created_at', 'DESC')->get();
            }


            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();

            $transCost = $this->transactionCost();

            $servicetypes = $this->getServiceTypes();

            $data = [
                'result' => $this->receivedNetamounttoWallet($req->country, $req->start, $req->end),
            ];



            return view('admin.report.chargeonaddmoney')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'transCost' => $transCost, 'servicetypes' => $servicetypes, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function amountWithdrawnFromWallet(Request $req)
    {



        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $otherPays = DB::table('invoice_payment')
                    ->select(DB::raw('invoice_payment.transactionid, invoice_payment.name, invoice_payment.email, import_excel.amount as invoice_amount, invoice_payment.invoice_no, invoice_payment.service, invoice_payment.created_at as transaction_date, import_excel.description as description, invoice_payment.remaining_balance as runningbalance, invoice_payment.amount as amount_paid, import_excel.status, invoice_payment.mystatus'))->distinct()
                    ->join('import_excel', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')
                    ->where('import_excel.uploaded_by', session('user_id'))
                    ->orderBy('invoice_payment.created_at', 'DESC')->get();
            }


            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();

            $transCost = $this->transactionCost();

            $servicetypes = $this->getServiceTypes();

            $data = [
                'result' => $this->withdrawalamountfromWallet($req->country, $req->start, $req->end),
            ];



            return view('admin.report.withdrawnfromwallet')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'transCost' => $transCost, 'servicetypes' => $servicetypes, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }

    public function chargesOnWithdrawals(Request $req)
    {



        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $otherPays = DB::table('invoice_payment')
                    ->select(DB::raw('invoice_payment.transactionid, invoice_payment.name, invoice_payment.email, import_excel.amount as invoice_amount, invoice_payment.invoice_no, invoice_payment.service, invoice_payment.created_at as transaction_date, import_excel.description as description, invoice_payment.remaining_balance as runningbalance, invoice_payment.amount as amount_paid, import_excel.status, invoice_payment.mystatus'))->distinct()
                    ->join('import_excel', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')
                    ->where('import_excel.uploaded_by', session('user_id'))
                    ->orderBy('invoice_payment.created_at', 'DESC')->get();
            }


            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();

            $transCost = $this->transactionCost();

            $servicetypes = $this->getServiceTypes();

            $data = [
                'result' => $this->withdrawalamountfromWallet($req->country, $req->start, $req->end),
            ];



            return view('admin.report.chargewithdrawnfromwallet')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'transCost' => $transCost, 'servicetypes' => $servicetypes, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }



    public function walletMaintenanceFee(Request $req)
    {



        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $otherPays = DB::table('invoice_payment')
                    ->select(DB::raw('invoice_payment.transactionid, invoice_payment.name, invoice_payment.email, import_excel.amount as invoice_amount, invoice_payment.invoice_no, invoice_payment.service, invoice_payment.created_at as transaction_date, import_excel.description as description, invoice_payment.remaining_balance as runningbalance, invoice_payment.amount as amount_paid, import_excel.status, invoice_payment.mystatus'))->distinct()
                    ->join('import_excel', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')
                    ->where('import_excel.uploaded_by', session('user_id'))
                    ->orderBy('invoice_payment.created_at', 'DESC')->get();
            }


            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();

            $transCost = $this->transactionCost();

            $servicetypes = $this->getServiceTypes();

            $data = [
                'result' => $this->maintenancefeecharge($req->country, $req->start, $req->end),
            ];



            return view('admin.report.maintenancefeecharge')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'transCost' => $transCost, 'servicetypes' => $servicetypes, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }



    public function getInflowRecord(Request $req)
    {


        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $otherPays = DB::table('invoice_payment')
                    ->select(DB::raw('invoice_payment.transactionid, invoice_payment.name, invoice_payment.email, import_excel.amount as invoice_amount, invoice_payment.invoice_no, invoice_payment.service, invoice_payment.created_at as transaction_date, import_excel.description as description, invoice_payment.remaining_balance as runningbalance, invoice_payment.amount as amount_paid, import_excel.status, invoice_payment.mystatus'))->distinct()
                    ->join('import_excel', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')
                    ->where('import_excel.uploaded_by', session('user_id'))
                    ->orderBy('invoice_payment.created_at', 'DESC')->get();
            }


            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();

            $transCost = $this->transactionCost();

            $servicetypes = $this->getServiceTypes();

            $data = [
                'result' => $this->getInflowrecordByDate($req->country, $req->statement_start, $req->statement_end),
            ];


            return view('admin.report.inflowreportbysearch')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'transCost' => $transCost, 'servicetypes' => $servicetypes, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }



    public function getWithdrawalRecord(Request $req)
    {


        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $otherPays = DB::table('invoice_payment')
                    ->select(DB::raw('invoice_payment.transactionid, invoice_payment.name, invoice_payment.email, import_excel.amount as invoice_amount, invoice_payment.invoice_no, invoice_payment.service, invoice_payment.created_at as transaction_date, import_excel.description as description, invoice_payment.remaining_balance as runningbalance, invoice_payment.amount as amount_paid, import_excel.status, invoice_payment.mystatus'))->distinct()
                    ->join('import_excel', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')
                    ->where('import_excel.uploaded_by', session('user_id'))
                    ->orderBy('invoice_payment.created_at', 'DESC')->get();
            }


            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();

            $transCost = $this->transactionCost();

            $servicetypes = $this->getServiceTypes();

            $data = [
                'result' => $this->getWithdrawalrecordByDate($req->country, $req->statement_start, $req->statement_end),
            ];


            return view('admin.report.withdrawalreportbysearch')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'transCost' => $transCost, 'servicetypes' => $servicetypes, 'data' => $data]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }



    public function getSentInvoice($user_id)
    {
        $data = ImportExcel::where('uploaded_by', $user_id)->get();

        return $data;
    }


    public function getSentInvoiceByDate($start, $end, $user_id)
    {
        $data = ImportExcel::where('uploaded_by', $user_id)->whereBetween('transaction_date', [$start, $end])->get();

        return $data;
    }


    public function getPaidInvoice($user_id)
    {
        $data = ImportExcel::where('payment_status', '!=', 0)->where('uploaded_by', $user_id)->get();

        return $data;
    }

    public function getPaidInvoiceByDate($start, $end, $user_id)
    {
        $data = ImportExcel::where('payment_status', '!=', 0)->where('uploaded_by', $user_id)->whereBetween('transaction_date', [$start, $end])->get();

        return $data;
    }


    public function getUnpaidInvoice($user_id)
    {
        $data = ImportExcel::where('payment_status', 0)->where('uploaded_by', $user_id)->get();

        return $data;
    }


    public function getUnpaidInvoiceByDate($start, $end, $user_id)
    {
        $data = ImportExcel::where('payment_status', 0)->where('uploaded_by', $user_id)->whereBetween('transaction_date', [$start, $end])->get();

        return $data;
    }


    public function getcustomerBalance($user_id)
    {
        $data = ImportExcel::where('payment_status', 2)->where('uploaded_by', $user_id)->get();

        return $data;
    }


    public function getcustomerBalanceByDate($start, $end, $user_id)
    {
        $data = ImportExcel::where('payment_status', 2)->where('uploaded_by', $user_id)->whereBetween('transaction_date', [$start, $end])->get();

        return $data;
    }

    public function getinvoiceType($user_id)
    {
        $data = ImportExcel::where('uploaded_by', $user_id)->groupBy('service')->get();

        return $data;
    }


    public function getrecurringReport($user_id)
    {
        $data = ImportExcel::where('uploaded_by', $user_id)->groupBy('recurring')->get();

        return $data;
    }


    public function getInflowByCountry()
    {
        $data = Statement::where('country', '!=', null)->where('credit', '>', 0)->orderBy('country', 'ASC')->groupBy('country')->get();

        return $data;
    }

    public function getWithdrawalByCountry()
    {
        $data = Statement::where('country', '!=', null)->where('debit', '>', 0)->where('activity', 'LIKE', '%Withdraw%')->orderBy('country', 'ASC')->groupBy('country')->get();

        return $data;
    }

    public function getBusinessRecordByDate($country, $start, $end)
    {


        $data = DB::table('statement')
            ->where('statement.country', $country)
            ->whereBetween('trans_date', [$start, $end])
            ->orderBy('statement.created_at', 'DESC')
            ->get();



        return $data;
    }


    public function receivedNetamounttoWallet($country, $start, $end)
    {


        $data = DB::table('users')
            ->join('statement', 'users.email', '=', 'statement.user_id')
            ->where('statement.country', $country)
            ->where('statement.activity', 'LIKE', '%Added%')
            ->whereBetween('trans_date', [$start, $end])
            ->orderBy('statement.created_at', 'DESC')
            ->get();



        return $data;
    }


    public function receivedNetFxamounttoWallet($country, $start, $end)
    {


        $data = DB::table('users')
            ->join('statement', 'users.email', '=', 'statement.user_id')
            ->where('statement.country', $country)
            ->where('statement.action', 'Escrow Wallet credit')
            ->whereBetween('trans_date', [$start, $end])
            ->orderBy('statement.created_at', 'DESC')
            ->get();



        return $data;
    }


    public function withdrawalamountfromWallet($country, $start, $end)
    {


        $data = DB::table('users')
            ->join('statement', 'users.email', '=', 'statement.user_id')
            ->where('statement.country', $country)
            ->where('statement.activity', 'LIKE', '%Withdraw%')
            ->whereBetween('trans_date', [$start, $end])
            ->orderBy('statement.created_at', 'DESC')
            ->get();



        return $data;
    }


    public function maintenancefeecharge($country, $start, $end)
    {

        $data = MonthlyFee::where('country', $country)
            ->whereBetween('created_at', [$start, $end])
            ->orderBy('created_at', 'DESC')
            ->get();


        return $data;
    }

    public function getInflowrecordByDate($country, $start, $end)
    {


        $data = DB::table('users')
            ->join('statement', 'users.email', '=', 'statement.user_id')
            ->where('statement.country', $country)
            ->where('statement.credit', '>', 0)
            ->whereBetween('trans_date', [$start, $end])
            ->orderBy('statement.created_at', 'DESC')
            ->get();

        return $data;
    }


    public function getWithdrawalrecordByDate($country, $start, $end)
    {


        $data = DB::table('users')
            ->join('statement', 'users.email', '=', 'statement.user_id')
            ->where('statement.country', $country)
            ->where('statement.debit', '>', 0)
            ->where('statement.activity', 'LIKE', '%Withdraw%')
            ->whereBetween('trans_date', [$start, $end])
            ->orderBy('statement.created_at', 'DESC')
            ->get();

        return $data;
    }


    public function getReportInflowByCountry($country)
    {
        $data = DB::table('users')
            ->join('statement', 'users.email', '=', 'statement.user_id')
            ->where('statement.country', $country)
            ->where('statement.credit', '>', 0)
            ->orderBy('statement.created_at', 'DESC')
            ->get();

        return $data;
    }



    public function getReportWithdrawalByCountry($country)
    {
        $data = DB::table('users')
            ->join('statement', 'users.email', '=', 'statement.user_id')
            ->where('statement.country', $country)
            ->where('statement.debit', '>', 0)
            ->where('statement.activity', 'LIKE', '%Withdraw%')
            ->orderBy('statement.created_at', 'DESC')
            ->get();

        return $data;
    }


    public function getWalletStatement(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $otherPays = Statement::where('user_id', session('email'))->orderBy('created_at', 'DESC')->get();
            }

            $client = $this->getMyClientInfo(session('user_id'));

            if ($client->accountMode == "test") {

                return redirect()->route('dashboard')->with('error', 'You are in test mode');
            }

            // dd($otherPays);

            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();

            $transCost = $this->transactionCost();

            return view('admin.walletstatement')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'transCost' => $transCost]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }



    public function getWalletStatementReport(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $otherPays = Statement::where('user_id', session('email'))->orderBy('created_at', 'DESC')->get();
            }

            // dd($otherPays);

            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();

            $transCost = $this->transactionCost();

            $thisdata = [
                'result' => $this->getWalletStatementRecordByDate($req->statement_service, $req->statement_start, $req->statement_end),
            ];


            return view('admin.walletstatementreport')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'transCost' => $transCost, 'thisdata' => $thisdata]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function getUserWalletStatementReport(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $otherPays = Statement::where('user_id', session('email'))->orderBy('created_at', 'DESC')->get();
            }

            // dd($otherPays);

            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();

            $transCost = $this->transactionCost();

            $thisdata = [
                'result' => $this->getUserWalletStatementRecordByDate($req->user_id, $req->statement_start, $req->statement_end),
                'allusers' => $this->userWalletBalance(),
            ];


            return view('admin.userwalletstatementreport')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'transCost' => $transCost, 'thisdata' => $thisdata]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function getUserWalletPurchaseStatementReport(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $otherPays = Statement::where('user_id', session('email'))->orderBy('created_at', 'DESC')->get();
            }

            // dd($otherPays);

            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();

            $transCost = $this->transactionCost();

            $thisdata = [
                'result' => $this->getUserWalletPurchaseStatementRecordByDate($req->user_id, $req->statement_start, $req->statement_end),
                'allusers' => $this->userWalletBalance(),
            ];

            return view('admin.userwalletpurchasestatementreport')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'otherPays' => $otherPays, 'transCost' => $transCost, 'thisdata' => $thisdata]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }


    public function payreport(Request $req)
    {

        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
        } else {
            return redirect()->route('AdminLogin');
        }
    }

    public function epayreport(Request $req)
    {


        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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

                $report = OrganizationPay::where('coy_id', session('user_id'))->get();
            }

            // dd($report);

            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();

            $transCost = $this->transactionCost();

            return view('admin.epayreport')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'report' => $report, 'transCost' => $transCost]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }

    public function payremittancereport(Request $req)
    {


        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
            }

            // dd($report);

            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();

            $report = $this->paycareportRemittance(session('email'));

            $transCost = $this->transactionCost();

            return view('admin.payremittancereport')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'report' => $report, 'transCost' => $transCost]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }

    public function epayremittancereport(Request $req)
    {


        if ($req->session()->has('username') == true) {
            // dd(Session::all());

            if (session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Customer Marketing" || session('role') == "Customer Success") {
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
            }

            // dd($report);

            $clientPay = InvoicePayment::orderBy('created_at', 'DESC')->get();

            $report = $this->epayreportRemittance(session('email'));

            $transCost = $this->transactionCost();


            return view('admin.epayremittancereport')->with(['pages' => 'Dashboard', 'clientPay' => $clientPay, 'adminUser' => $adminUser, 'invoiceImport' => $invoiceImport, 'payInvoice' => $payInvoice, 'report' => $report, 'transCost' => $transCost]);
        } else {
            return redirect()->route('AdminLogin');
        }
    }



    public function adminlogin(Request $req)
    {

        return view('admin.adminlogin');
    }


    public function adminregister()
    {

        $data = $this->_merchantServices();

        return view('admin.adminregister')->with(['data' => $data]);
    }

    public function claimingBusiness(Request $req)
    {
        $id = $req->id;
        $merchants = UnverifiedMerchant::where('id', $id)->first();
        $merchantservices = $this->_merchantServices();
        $data = [
            'merchants' => $merchants,
            'merchantservices' => $merchantservices,
        ];

        // dd($data);

        return view('admin.claimbusiness')->with(['data' => $data]);
    }

    public function _merchantServices()
    {
        $data = MerchantService::all();

        return $data;
    }


    public function ajaxcreateEvent(Request $req)
    {
        // Create events

        if ($req->purpose == "ticket") {

            if ($req->file('event_file')) {
                //Get filename with extension
                $filenameWithExt = $req->file('event_file')->getClientOriginalName();

                // dd($filenameWithExt);
                // Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                // Get just extension
                $extension = $req->file('event_file')->getClientOriginalExtension();
                // Filename to store
                $fileNameToStore = rand() . '_' . time() . '.' . $extension;
                //Upload Image
                // $path = $req->file('event_file')->storeAs('public/eventticket', $fileNameToStore);

                // $path = $req->file('event_file')->move(public_path('/eventticket/'), $fileNameToStore);

                $path = $req->file('event_file')->move(public_path('../../eventticket/'), $fileNameToStore);
            } else {
                $fileNameToStore = 'noImage.png';
            }

            // Insert Rec
            $insRec = CreateEvent::insert(['user_id' => $req->user_id, 'event_id' => $req->ticket_id, 'event_title' => $req->event_title, 'event_location' => $req->event_location, 'event_start_date' => $req->datepicker_start, 'event_start_time' => $req->ticket_timeStarts, 'event_end_date' => $req->datepicker_end, 'event_end_time' => $req->ticket_timeEnds, 'upload_ticket' => $fileNameToStore, 'event_description' => $req->event_description, 'ticket_name' => $req->ticket_free_name, 'quantity_available' => $req->ticket_free_qty, 'price' => $req->ticket_free_price, 'ticket_paid_name' => $req->ticket_paid_name, 'quantity_paid_available' => $req->ticket_paid_qty, 'paid_price' => $req->ticket_paid_price, 'ticket_donate_name' => $req->ticket_donate_name, 'quantity_donate_available' => $req->ticket_donate_qty, 'donate_price' => $req->ticket_donate_price]);

            if ($insRec == true) {
                $resData = ['res' => 'Event Saved', 'message' => 'success', 'action' => 'ticket', 'link' => 'Admin'];
            } else {
                $resData = ['res' => 'Something went wrong!', 'message' => 'error', 'action' => 'ticket'];
            }
        } elseif ($req->purpose == "uploadExcel") {
            // Do some Uploads here
            if ($req->file('excel_file')) {

                //Get filename with extension
                $filenameWithExt = $req->file('excel_file')->getClientOriginalName();
                // Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                // Get just extension
                $extension = $req->file('excel_file')->getClientOriginalExtension();


                if ($extension == "xlsx" || $extension == "xls") {

                    $path = $req->file('excel_file')->getRealPath();

                    // $data = Excel::import($path)->get();
                    $data = (new FastExcel)->import($path);

                    // Get Client Name & Address


                    $getClient = ClientInfo::where('user_id', $req->user_id)->get();

                    if (count($getClient) > 0) {
                        $clientname = $getClient[0]->business_name;
                        $clientaddress = $getClient[0]->address;
                        $client_realname = $getClient[0]->firstname . ' ' . $getClient[0]->lastname;
                        $city = $getClient[0]->city;
                        $state = $getClient[0]->state;
                        $zipcode = $getClient[0]->zip_code;
                        $country = $getClient[0]->country;
                    } else {
                        $clientname = "PaySprint (EXBC)";
                        $client_realname = "PaySprint (EXBC)";
                        $clientaddress = "PaySprint by Express Ca Corp, 10 George St. North, Brampton. ON. L6X1R2. Canada";
                        $city = "Brampton";
                        $state = "Ontario";
                        $zipcode = "L6X1R2";
                        $country = "Canada";
                    }



                    if ($data->count() > 0) {
                        foreach ($data->toArray() as $key) {

                            if ($key['Invoice #'] == "" || $key['Invoice #'] == null) {
                                $invoice_no = $key['Transaction Ref'] . '' . date('Ymd');
                            } else {
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




                            if ($key['Customer Email'] == "" || $key['Customer Email'] == null) {

                                $resData = ['res' => 'This excel sheet may contain some empty fields. Kindly download and use the test sample to make a copy of your file.', 'message' => 'response'];
                            } else {


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
                                    'uploaded_by' => $req->user_id,
                                    'merchantName' => $client_realname
                                );

                                // Insert Statement
                                $activity = "Invoice on " . $req->service;
                                $credit = $key['Amount'];
                                $debit = 0;
                                $balance = 0;
                                $reference_code = $invoice_no;
                                $status = "Delivered";
                                $action = "Invoice";
                                $trans_date = date('Y-m-d', strtotime($UNIX_DATE1));
                                $regards = $req->user_id;

                                $this->insStatement($key['Customer Email'], $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 0, $country);

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

                                $this->subject = 'You have an invoice from  ' . $this->clientname . ' on PaySprint';

                                $this->sendEmail($this->to, $this->subject);
                            }
                        }

                        if (!empty($insert_data)) {

                            DB::table('import_excel')->insert($insert_data);
                        }
                    }

                    // Filename to store
                    $fileNameToStore = rand() . '_' . time() . '.' . $extension;

                    // $req->file('excel_file')->move(public_path('/excelUpload/'), $fileNameToStore);

                    $req->file('excel_file')->move(public_path('../../excelUpload/'), $fileNameToStore);

                    $resData = ['res' => 'Upload Successfull', 'message' => 'success', 'action' => 'uploadExcel'];
                } else {
                    $resData = ['res' => 'Invalid worksheet', 'message' => 'error'];
                }
            } else {
                $resData = ['res' => 'Kindly upload an excel document', 'message' => 'error'];
            }
        } elseif ($req->purpose == "setRecur") {
            // Get Data
            $getData = ImportExcel::where('uploaded_by', $req->user_id)->get();

            if (count($getData) > 0) {
                // Update
                $updateData = ImportExcel::where('uploaded_by', $req->user_id)->update(['recurring' => $req->recurring, 'reminder' => $req->reminder]);

                if ($updateData) {
                    $resData = ['res' => 'Upload Successfull', 'message' => 'success', 'action' => 'setRecur'];
                } else {
                    $resData = ['res' => 'Something went wrong', 'message' => 'error'];
                }
            } else {
                $resData = ['res' => 'Data was lost!', 'message' => 'error'];
            }
        } elseif ($req->purpose == "single1_upload") {
            // Get Data
            $checkifData = ImportExcel::where('invoice_no', $req->invoice_no)->get();

            if (count($checkifData) > 0) {
                // Already exist
                $resData = ['res' => 'Invoice already created for this user', 'message' => 'info'];
            } else {

                if ($req->service == "Others") {
                    $service = $req->service_specify;

                    // Insert
                    $this->serviceType($service);
                } else {
                    $service = $req->service;
                }

                // Insert data
                $insData = ImportExcel::insert(['name' => $req->firstname . ' ' . $req->lastname, 'payee_email' => $req->payee_email, 'service' => $service, 'invoice_no' => $req->invoice_no, 'uploaded_by' => $req->user_id, 'installpay' => $req->installpay, 'installlimit' => $req->installlimit]);

                if ($insData ==  true) {



                    $resData = ['res' => 'Success', 'message' => 'success', 'action' => 'single1_upload', 'email' => $req->payee_email, 'invoice_no' => $req->invoice_no];
                } else {
                    $resData = ['res' => 'Something went wrong', 'message' => 'error'];
                }
            }
        } elseif ($req->purpose == "single2_upload") {
            // Get Data
            $getData = ImportExcel::where('invoice_no', $req->invoice_no)->get();



            if (count($getData) > 0) {
                // Update
                $updateData = ImportExcel::where('invoice_no', $req->invoice_no)->update(['payee_ref_no' => $req->payee_ref_no, 'transaction_ref' => $req->transaction_ref, 'transaction_date' => $req->transaction_date, 'description' => $req->description]);

                // dd($updateData);

                if ($updateData) {
                    $resData = ['res' => 'Success', 'message' => 'success', 'action' => 'single2_upload', 'email' => $req->payee_email, 'invoice_no' => $req->invoice_no];
                } else {
                    $resData = ['res' => 'Something went wrong', 'message' => 'error'];
                }
            } else {
                $resData = ['res' => 'Data not found!', 'message' => 'error'];
            }
        } elseif ($req->purpose == "single3_upload") {
            // Get Data
            $getData = ImportExcel::where('invoice_no', $req->invoice_no)->get();

            if (count($getData) > 0) {
                // Update
                $updateData = ImportExcel::where('invoice_no', $req->invoice_no)->update(['amount' => $req->amount, 'payment_due_date' => $req->payment_due_date, 'recurring' => $req->recurring, 'reminder' => $req->reminder, 'customer_id' => session('user_id'), 'merchantName' => session('firstname') . ' ' . session('lastname')]);

                // dd($updateData);

                if ($updateData) {

                    $getClient = ClientInfo::where('user_id', session('user_id'))->get();

                    if (count($getClient) > 0) {
                        $clientname = $getClient[0]->business_name;
                        $clientaddress = $getClient[0]->address;
                        $client_realname = $getClient[0]->firstname . ' ' . $getClient[0]->lastname;
                        $city = $getClient[0]->city;
                        $state = $getClient[0]->state;
                        $zipcode = $getClient[0]->zip_code;
                        $country = $getClient[0]->country;
                    } else {
                        $clientname = "PaySprint (EXBC)";
                        $client_realname = "PaySprint (EXBC)";
                        $clientaddress = "PaySprint by Express Ca Corp, 10 George St. North, Brampton. ON. L6X1R2. Canada";
                        $city = "Brampton";
                        $state = "Ontario";
                        $zipcode = "L6X1R2";
                        $country = "Canada";
                    }


                    // Insert Statement
                    $activity = "Invoice on " . $getData[0]->service;
                    $credit = $req->amount;
                    $debit = 0;
                    $balance = 0;
                    $reference_code = $req->invoice_no;
                    $status = "Delivered";
                    $action = "Invoice";

                    $trans_date = date('Y-m-d', strtotime($getData[0]->transaction_date));

                    $regards = session('user_id');

                    $this->insStatement($req->payee_email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 0, $country);


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

                    $this->subject = 'You have an invoice from  ' . $this->clientname . ' on PaySprint';

                    $this->sendEmail($this->to, $this->subject);


                    $resData = ['res' => 'Successfully saved', 'message' => 'success', 'action' => 'single3_upload'];
                } else {
                    $resData = ['res' => 'Something went wrong', 'message' => 'error'];
                }
            } else {
                $resData = ['res' => 'Data not found!', 'message' => 'error'];
            }
        }

        return $this->returnJSON($resData, 200);
    }


    // Client Login
    public function ajaxadminlogin(Request $req)
    {
        // Check user exist
        $adminCheck = Admin::where('username', $req->username)->get();


        if (count($adminCheck) > 0) {
            // COnfirm Password
            if (Hash::check($req->password, $adminCheck[0]['password'])) {


                // Check if API Key EXIST
                $checkApikey = ClientInfo::where('email', $adminCheck[0]['email'])->first();



                if ($checkApikey->api_secrete_key == null) {
                    // Update
                    ClientInfo::where('email', $checkApikey->email)->update(['api_secrete_key' => md5(uniqid($adminCheck[0]['username'], true)) . date('dmY') . time()]);
                }

                $mycode = $this->getCountryCode($checkApikey->country);


                $currencyCode = $mycode->currencyCode;
                $currencySymbol = $mycode->currencySymbol;

                $api_token = uniqid() . md5($adminCheck[0]['email']) . time();

                User::where('email', $adminCheck[0]['email'])->update(['code' => $mycode->callingCode, 'currencyCode' => $currencyCode, 'currencySymbol' => $currencySymbol, 'api_token' => $api_token]);

                $getMerchant = User::where('email', $adminCheck[0]['email'])->first();


                $countryApproval = AllCountries::where('name', $checkApikey->country)->where('approval', 1)->first();

                if (isset($countryApproval)) {

                    // Check if account is flagged or pass security level

                    // if (isset($getMerchant->flagged) && $getMerchant->flagged == 1) {

                    //     $resData = ['res' => 'Hello ' . $adminCheck[0]['firstname'] . ', Access to the account is not currently available. Kindly contact the Admin using this link: https://paysprint.ca/contact', 'message' => 'error'];

                    //     $this->createNotification($checkApikey->user_id, 'Hello ' . $adminCheck[0]['firstname'] . ', Access to the account is not currently available. Kindly contact the Admin using this link: https://paysprint.ca/contact');
                    // }

                    if ($getMerchant->disableAccount == 'on') {

                        $resData = ['res' => 'Hello ' . $adminCheck[0]['firstname'] . ', Access to the account is not currently available. Kindly contact the Admin using this link: https://paysprint.ca/contact', 'message' => 'error'];

                        $this->createNotification($checkApikey->user_id, 'Hello ' . $adminCheck[0]['firstname'] . ', Access to the account is not currently available. Kindly contact the Admin using this link: https://paysprint.ca/contact');
                    }
                    // elseif($getMerchant->accountLevel == 0){

                    //     $resData = ['res' => 'Hello '.$adminCheck[0]['firstname'].', Our system is yet to complete your registration. Kindly upload a copy of Government-issued Photo ID, a copy of a Utility Bill or Bank Statement that matches your name with the current address and also take a Selfie of yourself (if using the mobile app) and upload in your profile setting to complete the verification process. Kindly contact the admin using the contact us form if you require further assistance. Thank You', 'message' => 'error'];

                    //     $this->createNotification($checkApikey->user_id, 'Hello '.$adminCheck[0]['firstname'].', Our system is unable to complete your Sign Up process at this time. Kindly Contact Us to submit your Name and email. One of our Customer Service Executives would contact you within the next 24 hours for further assistance.');


                    // }
                    else {
                        // Set session
                        $loginCount = $getMerchant->loginCount + 1;

                        if ($getMerchant->pass_checker > 0 && $getMerchant->pass_date <= date('Y-m-d')) {
                            $pass_date = $getMerchant->pass_date;
                        } else {
                            $pass_date = date('Y-m-d');
                        }

                        User::where('email', $getMerchant->email)->update(['lastLogin' => date('d-m-Y h:i A'), 'loginCount' => $loginCount, 'countryapproval' => 1, 'pass_date' => $pass_date]);

                        $req->session()->put(['user_id' => $adminCheck[0]['user_id'], 'firstname' => $adminCheck[0]['firstname'], 'lastname' => $adminCheck[0]['lastname'], 'username' => $adminCheck[0]['username'], 'role' => 'Merchant', 'email' => $adminCheck[0]['email'], 'api_token' => $api_token, 'myID' => $getMerchant->id, 'country' => $getMerchant->country, 'businessname' => $getMerchant->businessname, 'loginCount' => $loginCount, 'currencyCode' => $getMerchant->currencyCode]);

                        $usercity = $this->myLocation()->city;
                        $usercountry = $this->myLocation()->country;
                        $userip = $this->myLocation()->query;

                        $this->checkLoginInfo($getMerchant->refCode, $usercity, $usercountry, $userip);

                        $user = User::where('email', $getMerchant->email)->first();

                        Auth::login($user);

                        if (env('APP_ENV') != 'local') {
                            $this->generateOTP($getMerchant->id);
                            $userLink = 'verification';
                        } else {
                            $userLink = '/merchant/dashboard';
                        }


                        $resData = ['res' => 'Logging in...', 'message' => 'success', 'link' => $userLink];

                        $this->createNotification($checkApikey->user_id, 'Welcome back ' . $adminCheck[0]['firstname']);
                    }
                } else {
                    $resData = ['res' => 'Hello ' . $adminCheck[0]['firstname'] . ', PaySprint is not yet available for use in your country. You can contact our Customer Service Executives for further assistance', 'message' => 'error'];

                    User::where('email', $getMerchant->email)->update(['countryapproval' => 0]);
                }
            } else {
                $resData = ['res' => 'Incorrect Password!', 'message' => 'info'];
            }
        } else {
            // Check if Super Admin
            $superCheck = SuperAdmin::where('username', $req->username)->get();

            if (count($superCheck) > 0) {
                // COnfirm Password
                if (Hash::check($req->password, $superCheck[0]['password'])) {
                    // Set session
                    $req->session()->put(['user_id' => $superCheck[0]['user_id'], 'firstname' => $superCheck[0]['firstname'], 'lastname' => $superCheck[0]['lastname'], 'username' => $superCheck[0]['username'], 'role' => $superCheck[0]['role'], 'email' => $superCheck[0]['email'], 'country' => $superCheck[0]['country'], 'myID' => $superCheck[0]['id'], 'loginCount' => 1, 'currencyCode' => 'USD']);

                    $query = [
                        'user_id' => $superCheck[0]['user_id'],
                        'name' => $superCheck[0]['firstname'] . ' ' . $superCheck[0]['lastname'],
                        'activity' => 'You have logged in today: ' . date('d-M-Y h:i:a'),
                    ];

                    $this->createSupportActivity($query);

                    $resData = ['res' => 'Logging in...', 'message' => 'success', 'link' => 'Admin'];
                } else {
                    $resData = ['res' => 'Incorrect Password!', 'message' => 'info'];
                }
            } else {
                $resData = ['res' => 'Unrecognized authentication!', 'message' => 'info'];
            }
        }

        return $this->returnJSON($resData, 200);
    }

    // Client Login
    public function ajaxAdminspeciallogin(Request $req)
    {
        // Check user exist
        $adminCheck = Admin::where('username', $req->username)->get();

        if (count($adminCheck) > 0) {
            // Set session



            $req->session()->put(['user_id' => $adminCheck[0]['user_id'], 'firstname' => $adminCheck[0]['firstname'], 'lastname' => $adminCheck[0]['lastname'], 'username' => $adminCheck[0]['username'], 'role' => 'Merchant', 'email' => $adminCheck[0]['email'], 'loginCount' => 1, 'currencyCode' => 'USD']);

            $resData = ['res' => 'Logging in...', 'message' => 'success', 'link' => 'Admin'];
        } else {
            $resData = ['res' => 'Unrecognized login!', 'message' => 'info'];
        }

        return $this->returnJSON($resData, 200);
    }

    // Client Register
    public function ajaxadminregister(Request $req)
    {


        // Check client record
        $checkClient = ClientInfo::where('email', $req->email)->get();
        if (count($checkClient) > 0) {
            // Check Admin table
            $checkAdmin = Admin::where('username', $req->username)->get();
            if (count($checkAdmin) > 0) {
                $resData = ['res' => 'Username already chosen', 'message' => 'error'];
            }
            // User already exist
            $resData = ['res' => 'User with this email already exist', 'message' => 'error'];
        } else {

            // Check User Account if Email
            $userExist = User::where('email', $req->email)->first();

            $transCost = TransactionCost::where('method', "Merchant Minimum Withdrawal")->where('country', $req->country)->first();

            if (isset($transCost)) {
                $transactionLimit = $transCost->fixed;
            } else {
                $transactionLimit = 0;
            }


            $getRef = User::where('ref_code', $req->referred_by)->first();

            if (isset($getRef)) {

                $referral_points = $getRef->referral_points + 100;

                User::where('id', $getRef->id)->update([
                    'referral_points' => $referral_points
                ]);

                // Add to generate link
                $refGen = ReferralGenerate::where('ref_code', $req->referred_by)->first();

                if (isset($refGen)) {
                    $ref_count = $refGen->referred_count + 1;

                    ReferralGenerate::where('ref_code', $req->referred_by)->update(['referred_count' => $ref_count]);
                } else {
                    ReferralGenerate::insert([
                        'ref_code' => $req->referred_by,
                        'name' => $getRef->name,
                        'email' => $getRef->email,
                        'ref_link' => route('home') . '/register?ref_code=' . $req->referred_by,
                        'referred_count' => '1',
                        'country' => $getRef->country,
                        'is_admin' => false
                    ]);
                }


                ReferredUsers::insert(['ref_code' => $req->referred_by, 'referred_user' => $req->email, 'referral_points' => 100]);
            } else {
                $getRef = ReferralGenerate::where('ref_code', $req->referred_by)->first();

                if (isset($getRef)) {

                    ReferredUsers::insert(['ref_code' => $req->referred_by, 'referred_user' => $req->email, 'referral_points' => 100]);

                    $ref_count = $getRef->referred_count + 1;

                    ReferralGenerate::where('ref_code', $req->referred_by)->update(['referred_count' => $ref_count]);
                }
            }


            $userClosedExist = UserClosed::where('email', $req->email)->first();

            if (isset($userExist)) {
                // User already exist
                $resData = ['res' => 'The email address already exist as an Individual account holder', 'message' => 'error'];
            } elseif (isset($userClosedExist)) {
                // User already exist
                $resData = ['res' => 'Your account has already been created but currently not active on PaySprint. Contact the Admin for more information', 'message' => 'error'];
            } else {

                if ($req->how_your_heard_about_us == "Others") {
                    $specifyHeardAbout = $req->specify_how_your_heard_about_us;
                } else {
                    $specifyHeardAbout = $req->how_your_heard_about_us;
                }


                if ($req->source_of_funds == "Others") {
                    $source_of_funds = $req->specify_source;
                } else {
                    $source_of_funds = $req->source_of_funds;
                }


                if ($req->ref_code != null) {

                    $getanonuser = AnonUsers::where('ref_code', $req->ref_code)->first();


                    if ($req->type_of_service == "Add Service Type") {
                        $merchantservice = $req->other_type_of_service;
                    } else {
                        $merchantservice = $req->type_of_service;
                    }

                    // Insert
                    $insClient = ClientInfo::insert(['user_id' => $req->ref_code, 'business_name' => $req->business_name, 'address' => $req->business_address, 'corporate_type' => $req->corporate_type, 'firstname' => $req->firstname, 'lastname' => $req->lastname, 'email' => $getanonuser->email, 'country' => $req->country, 'state' => $req->state, 'city' => $req->city, 'zip_code' => $req->zip_code, 'industry' => $req->industry, 'telephone' => $req->business_telephone, 'website' => $req->website, 'api_secrete_key' => md5(uniqid($req->username, true)) . date('dmY') . time(), 'type_of_service' => $merchantservice]);

                    $insAdmin = Admin::insert(['user_id' => $req->ref_code, 'firstname' => $req->firstname, 'lastname' => $req->lastname, 'username' => $req->username, 'password' => Hash::make($req->password), 'role' => 'Merchant', 'email' => $getanonuser->email]);


                    $mycode = $this->getCountryCode($req->country);

                    $currencyCode = $mycode->currencyCode;
                    $currencySymbol = $mycode->currencySymbol;

                    // Get all ref_codes


                    // Insert to User

                    $api_token = uniqid() . md5($req->email) . time();


                    $data = ['code' => $mycode->callingCode, 'ref_code' => $req->ref_code, 'businessname' => $req->business_name, 'name' => $getanonuser->name, 'email' => $getanonuser->email, 'password' => Hash::make($req->password), 'address' => $req->street_number . ' ' . $req->street_name . ', ' . $req->city . ' ' . $req->state . ' ' . $req->country, 'telephone' => $getanonuser->telephone, 'city' => $req->city, 'state' => $req->state, 'country' => $getanonuser->country, 'currencyCode' => $currencyCode, 'currencySymbol' => $currencySymbol, 'accountType' => "Merchant", 'corporationType' => $req->corporate_type, 'zip' => $req->zip_code, 'api_token' => $api_token, 'wallet_balance' => $getanonuser->wallet_balance, 'dayOfBirth' => $req->dayOfBirth, 'monthOfBirth' => $req->monthOfBirth, 'yearOfBirth' => $req->yearOfBirth, 'platform' => 'web', 'accountLevel' => 2, 'withdrawal_per_transaction' => $transactionLimit, 'referred_by' => $req->referred_by, 'knowAboutUs' => $specifyHeardAbout, 'accountPurpose' => $req->describe_purpose, 'transactionSize' => $req->size_of_transaction, 'sourceOfFunding' => $source_of_funds, 'shuftiproservice' => 0];


                    User::updateOrCreate(['email' => $getanonuser->email], $data);

                    if (isset($insAdmin)) {
                        // Set session
                        $getMerchant = User::where('ref_code', $req->ref_code)->first();


                        $req->session()->put(['user_id' => $req->ref_code, 'firstname' => $req->firstname, 'lastname' => $req->lastname, 'username' => $req->username, 'role' => 'Merchant', 'email' => $getanonuser->email, 'api_token' => $api_token, 'myID' => $getMerchant->id, 'country' => $getanonuser->country, 'businessname' => $getanonuser->businessname, 'loginCount' => $getMerchant->loginCount, 'currencyCode' => $getMerchant->currencyCode]);

                        $getMoney = Statement::where('user_id', $getanonuser->email)->get();

                        if (count($getMoney) > 0) {
                            foreach ($getMoney as $key => $value) {

                                Statement::where('reference_code', $value->reference_code)->update(['status' => 'Delivered']);
                            }
                        } else {
                            // Do nothing
                        }


                        AnonUsers::where('ref_code', $req->ref_code)->delete();

                        Log::info("New merchant registration via web by: " . $req->firstname . ' ' . $req->lastname . " from " . $req->state . ", " . $req->country);

                        $this->slack("New merchant registration via web by: " . $req->firstname . ' ' . $req->lastname . " from " . $req->state . ", " . $req->country, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));


                        $url = 'https://api.globaldatacompany.com/verifications/v1/verify';

                        $minimuAge = date('Y') - $req->yearOfBirth;

                        $countryApproval = AllCountries::where('name', $req->country)->where('approval', 1)->first();

                        if (isset($countryApproval)) {
                            $info = $this->identificationAPI($url, $req->firstname, $req->lastname, $req->dayOfBirth, $req->monthOfBirth, $req->yearOfBirth, $minimuAge, $req->street_number . ' ' . $req->street_name . ', ' . $req->city . ' ' . $req->state . ' ' . $req->country, $req->city, $req->country, $req->zip_code, $getanonuser->telephone, $getanonuser->email, $mycode->code);


                            if (isset($info->TransactionID) == true) {

                                $result = $this->transStatus($info->TransactionID);

                                // if (isset($result)) {

                                //     if (isset($result->TransactionRecordId)) {
                                //         $transxID = $result->TransactionRecordId;
                                //     } else {
                                //         $transxID = $result['TransactionRecordId'];
                                //     }

                                //     Log::info(json_encode($transxID));

                                //     $verifyRes = $this->getTransRec($transxID);

                                //     $verRes = $verifyRes->Record->RecordStatus;
                                // } else {
                                //     $verRes = "nomatch";
                                // }


                                if ($info->Record->RecordStatus == "nomatch") {

                                    // $message = "error";
                                    // $title = "Oops!";
                                    // $link = "contact";

                                    $message = "success";
                                    $title = "Great";
                                    // $link = "Admin";
                                    $link = "merchant/dashboard";


                                    $resInfo = strtoupper($info->Record->RecordStatus) . ", Welcome to PaySprint, World's #1 Affordable Payment Method that enables you to send and receive money, pay Invoice and bills and getting paid at anytime. You will be able to add money to your wallet, Pay Invoice or Utility bills, but you will not be able to send or receive money or withdraw money from your Wallet pending the verification of Government issued Photo ID and Utility bill or Bank statement uploaded. \nKindly follow these steps to upload the required information: \na. login to PaySprint Account on Mobile App or Web app at www.paysprint.ca \nb. Go to profile page, take a Selfie of yourself and upload along with a copy of Goverment Issued Photo ID, a copy of Utility bills and business documents \nAll other features would be enabled for you as soon as Compliance Team verifies your information \nThank you for your interest in PaySprint.\nCompliance Team @PaySprint \ninfo@paysprint.ca";
                                    User::where('id', $getMerchant->id)->update(['accountLevel' => 2, 'countryapproval' => 1, 'transactionRecordId' => $info->TransactionID]);


                                    Auth::login($getMerchant);
                                } else {
                                    $message = "success";
                                    $title = "Great";
                                    // $link = "Admin";
                                    $link = "merchant/dashboard";
                                    $resInfo = strtoupper($info->Record->RecordStatus) . ", Congratulations!!!. Your account has been approved. Kindly complete the Quick Set up to enjoy the full benefits of  PaySprint.";

                                    // Udpate User Info
                                    User::where('id', $getMerchant->id)->update(['accountLevel' => 2, 'approval' => 1, 'countryapproval' => 1, 'bvn_verification' => 1, 'transactionRecordId' => $info->TransactionID]);

                                    Auth::login($getMerchant);
                                }
                            } else {
                                $message = "success";
                                $title = "Great";
                                // $link = "Admin";
                                $link = "merchant/dashboard";
                                $resInfo = "Welcome to PaySprint, World's #1 Affordable Payment Method that enables you to send and receive money, pay Invoice and bills and getting paid at anytime. You will be able to add money to your wallet, Pay Invoice or Utility bills, but you will not be able to send or receive money or withdraw money from your Wallet pending the verification of Government issued Photo ID and Utility bill or Bank statement uploaded. \nKindly follow these steps to upload the required information: \na. login to PaySprint Account on Mobile App or Web app at www.paysprint.ca \nb. Go to profile page, take a Selfie of yourself and upload along with a copy of Goverment Issued Photo ID, a copy of Utility bills and business documents \nAll other features would be enabled for you as soon as Compliance Team verifies your information \nThank you for your interest in PaySprint.\nCompliance Team @PaySprint \ninfo@paysprint.ca";

                                User::where('id', $getMerchant->id)->update(['accountLevel' => 2, 'countryapproval' => 1, 'transactionRecordId' => NULL]);

                                Auth::login($getMerchant);

                                // $resp = $info->Message;
                            }

                            $this->name = $req->firstname . ' ' . $req->lastname;
                            // $this->email = "bambo@vimfile.com";
                            $this->to = $req->email;
                            $this->subject = "Welcome to PaySprint";

                            $message = "Welcome to PaySprint, World's #1 Affordable Payment Method that enables you to send and receive money, pay Invoice and bills and getting paid at anytime. You will be able to add money to your wallet, Create and Send Invoice, Accept and Receive payment from all the channels, Pay received Invoice or Utility bills, but you will not be able to send or receive money or withdraw money from your Wallet pending the verification of Government issued Photo ID and Utility bill or Bank statement uploaded. <br> Kindly follow these steps to upload the required information: <br> a. login to PaySprint Account on Mobile App or Web app at www.paysprint.ca <br> b. Go to profile page and upload a copy of Goverment Issued Photo ID, a copy of Utility bill and business documents. <br> All other features would be enabled for you as soon as the Compliance Team verifies your information <br> Thank you for your interest in PaySprint. <br><br> Compliance Team @PaySprint <br> info@paysprint.ca";


                            $this->message = '<p>' . $message . '</p>';


                            $this->sendEmail($this->to, "Refund Request");


                            if ($req->country == "India") {

                                $this->name = $req->firstname . ' ' . $req->lastname;
                                // $this->email = "bambo@vimfile.com";
                                $this->email = $req->email;
                                $this->subject = "Special Notice";

                                $mailmessage = "Dear " . $req->fname . ", If you are presenting India Aadhaar Card as the form of identification, kindly upload your India Permanent Account Number card as well using same icon.Thanks";

                                $this->message = '<p>' . $mailmessage . '</p>';


                                $this->sendEmail($this->email, "Fund remittance");
                            }
                        } else {
                            $message = "error";
                            $title = "Oops!";
                            $link = "contact";
                            $resInfo = "PaySprint is currently not available in your country. You can contact our Customer Service Executives for further enquiries. Thanks";

                            User::where('id', $getMerchant->id)->update(['accountLevel' => 0, 'countryapproval' => 0, 'transactionRecordId' => NULL]);
                        }


                        // TODO:: Kindly return to live when subscription live on ShuftiPro...

                        if (env('APP_ENV') !== 'local') {
                            $dob = $getMerchant->yearOfBirth . "-" . $getMerchant->monthOfBirth . "-" . $getMerchant->dayOfBirth;

                            $thisusersname = explode(" ", $getMerchant->name);

                            $getUsername = [
                                'first_name' => $thisusersname[0],
                                'middle_name' => '',
                                'last_name' => $thisusersname[1],
                            ];

                            $shuftiVerify = new ShuftiProController();

                            $checkAvalable = $shuftiVerify->shuftiAvailableCountries($getMerchant->country);

                            if ($checkAvalable === true) {
                                $checkAmlVerification = $shuftiVerify->callAmlCheck($getMerchant->ref_code, $dob, $getUsername, $getMerchant->email, $mycode->code);


                                if ($checkAmlVerification->event !== 'verification.accepted') {
                                    User::where('id', $getMerchant->id)->update(['accountLevel' => 2, 'approval' => 1, 'shuftipro_verification' => 1]);
                                } else {
                                    User::where('id', $getMerchant->id)->update(['accountLevel' => 2, 'approval' => 0, 'shuftipro_verification' => 0]);
                                }
                            }
                        }



                        $this->mailListCategorize($req->firstname . ' ' . $req->lastname, $req->email, $req->address, $req->telephone, "New Merchants", $req->country, 'Subscription');

                        Log::info("New merchant registration via web by: " . $req->firstname . ' ' . $req->lastname . " from " . $req->state . ", " . $req->country . " STATUS: " . $resInfo);

                        $this->slack("New merchant registration via web by: " . $req->firstname . ' ' . $req->lastname . " from " . $req->state . ", " . $req->country . " STATUS: " . $resInfo, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));


                        // This is the response for now until trulioo activates us to LIVE..

                        // $message = "success";
                        // $title = "Great";
                        // $link = "Admin";
                        // $link = "merchant/dashboard";
                        // $resInfo = "Hello ".$req->firstname.", Welcome to PaySprint...";



                        $resData = ['res' => $resInfo, 'message' => $message, 'link' => $link];
                    } else {
                        $resData = ['res' => 'Something went wrong', 'message' => 'error'];
                    }
                } else {

                    $ref_code = mt_rand(0000000, 9999999);


                    $ref = User::all();

                    if (count($ref) > 0) {
                        foreach ($ref as $key => $value) {
                            if ($value->ref_code == $ref_code) {
                                $newRefcode = mt_rand(0000000, 9999999);
                            } else {
                                $newRefcode = $ref_code;
                            }
                        }
                    } else {
                        $newRefcode = $ref_code;
                    }


                    if ($req->type_of_service == "Add Service Type") {
                        $merchantservice = $req->other_type_of_service;
                    } else {
                        $merchantservice = $req->type_of_service;
                    }

                    // Insert
                    $insClient = ClientInfo::insert(['user_id' => $newRefcode, 'business_name' => $req->business_name, 'address' => $req->business_address, 'corporate_type' => $req->corporate_type, 'firstname' => $req->firstname, 'lastname' => $req->lastname, 'email' => $req->email, 'country' => $req->country, 'state' => $req->state, 'city' => $req->city, 'zip_code' => $req->zip_code, 'industry' => $req->industry, 'telephone' => $req->business_telephone, 'website' => $req->website, 'api_secrete_key' => md5(uniqid($req->username, true)) . date('dmY') . time(), 'type_of_service' => $merchantservice]);

                    $insAdmin = Admin::insert(['user_id' => $newRefcode, 'firstname' => $req->firstname, 'lastname' => $req->lastname, 'username' => $req->username, 'password' => Hash::make($req->password), 'role' => 'Merchant', 'email' => $req->email]);


                    $mycode = $this->getCountryCode($req->country);

                    $currencyCode = $mycode->currencyCode;
                    $currencySymbol = $mycode->currencySymbol;

                    // Get all ref_codes


                    // Insert to User

                    $api_token = uniqid() . md5($req->email) . time();

                    if (isset($mycode->callingCode)) {

                        if ($req->country == "United States") {
                            $phoneCode = "1";
                        } else {
                            $phoneCode = $mycode->callingCode;
                        }
                    } else {
                        $phoneCode = "1";
                    }


                    $data = ['code' => $phoneCode, 'ref_code' => $newRefcode, 'businessname' => $req->business_name, 'name' => $req->firstname . ' ' . $req->lastname, 'email' => $req->email, 'password' => Hash::make($req->password), 'address' => $req->street_number . ' ' . $req->street_name . ', ' . $req->city . ' ' . $req->state . ' ' . $req->country, 'telephone' => $req->telephone, 'city' => $req->city, 'state' => $req->state, 'country' => $req->country, 'currencyCode' => $currencyCode, 'currencySymbol' => $currencySymbol, 'accountType' => "Merchant", 'corporationType' => $req->corporate_type, 'zip' => $req->zip_code, 'api_token' => $api_token, 'dayOfBirth' => $req->dayOfBirth, 'monthOfBirth' => $req->monthOfBirth, 'yearOfBirth' => $req->yearOfBirth, 'platform' => 'web', 'accountLevel' => 2, 'withdrawal_per_transaction' => $transactionLimit, 'referred_by' => $req->referred_by, 'knowAboutUs' => $specifyHeardAbout, 'accountPurpose' => $req->describe_purpose, 'transactionSize' => $req->size_of_transaction, 'sourceOfFunding' => $source_of_funds, 'shuftiproservice' => 0];


                    User::updateOrCreate(['email' => $req->email], $data);

                    if (isset($insAdmin)) {

                        $getMerchant = User::where('ref_code', $newRefcode)->first();

                        // Set session

                        $req->session()->put(['user_id' => $newRefcode, 'firstname' => $req->firstname, 'lastname' => $req->lastname, 'username' => $req->username, 'role' => 'Merchant', 'email' => $req->email, 'api_token' => $api_token, 'myID' => $getMerchant->id, 'country' => $req->country, 'loginCount' => $getMerchant->loginCount, 'currencyCode' => $getMerchant->currencyCode]);

                        Log::info("New merchant registration via web by: " . $req->firstname . ' ' . $req->lastname . " from " . $req->state . ", " . $req->country);

                        $this->slack("New merchant registration via web by: " . $req->firstname . ' ' . $req->lastname . " from " . $req->state . ", " . $req->country, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));

                        $countryApproval = AllCountries::where('name', $req->country)->where('approval', 1)->first();

                        $url = 'https://api.globaldatacompany.com/verifications/v1/verify';

                        $minimuAge = date('Y') - $req->yearOfBirth;

                        if (isset($countryApproval)) {

                            $info = $this->identificationAPI($url, $req->firstname, $req->lastname, $req->dayOfBirth, $req->monthOfBirth, $req->yearOfBirth, $minimuAge, $req->street_number . ' ' . $req->street_name . ', ' . $req->city . ' ' . $req->state . ' ' . $req->country, $req->city, $req->country, $req->zip_code, $req->telephone, $req->email, $mycode->code);


                            if (isset($info->TransactionID) == true) {

                                $result = $this->transStatus($info->TransactionID);

                                // $res = $this->getTransRec($result->TransactionRecordId);

                                // if (isset($result)) {

                                //     if (isset($result->TransactionRecordId)) {
                                //         $transxID = $result->TransactionRecordId;
                                //     } else {
                                //         $transxID = $result['TransactionRecordId'];
                                //     }

                                //     Log::info(json_encode($transxID));

                                //     $verifyRes = $this->getTransRec($transxID);

                                //     $verRes = $verifyRes->Record->RecordStatus;
                                // } else {
                                //     $verRes = "nomatch";
                                // }


                                if ($info->Record->RecordStatus == "nomatch") {

                                    $message = "success";
                                    $title = "Great";
                                    // $link = "Admin";
                                    $link = "merchant/dashboard";

                                    $resInfo = strtoupper($info->Record->RecordStatus) . ", Our system is yet to complete your registration. Kindly upload a copy of Government-issued Photo ID, a copy of a Utility Bill or Bank Statement that matches your name with the current address and also take a Selfie of yourself (if using the mobile app) and upload in your profile setting to complete the verification process. Kindly contact the admin using the contact us form if you require further assistance. Thank You";
                                    User::where('id', $getMerchant->id)->update(['accountLevel' => 0, 'countryapproval' => 1, 'transactionRecordId' => $info->TransactionID]);

                                    Auth::login($getMerchant);
                                } else {
                                    $message = "success";
                                    $title = "Great";
                                    // $link = "Admin";
                                    $link = "merchant/dashboard";
                                    $resInfo = strtoupper($info->Record->RecordStatus) . ", Congratulations!!!. Your account has been approved. Kindly complete the Quick Set up to enjoy the full benefits of PaySprint.";

                                    // Udpate User Info
                                    User::where('id', $getMerchant->id)->update(['accountLevel' => 2, 'approval' => 1, 'countryapproval' => 1, 'bvn_verification' => 1, 'transactionRecordId' => $info->TransactionID]);

                                    Auth::login($getMerchant);
                                }
                            } else {
                                $message = "success";
                                $title = "Great";
                                // $link = "Admin";
                                $link = "merchant/dashboard";
                                $resInfo = "Our system is yet to complete your registration. Kindly upload a copy of Government-issued Photo ID, a copy of a Utility Bill or Bank Statement that matches your name with the current address and also take a Selfie of yourself (if using the mobile app) and upload in your profile setting to complete the verification process. Kindly contact the admin using the contact us form if you require further assistance. Thank You";

                                User::where('id', $getMerchant->id)->update(['accountLevel' => 0, 'countryapproval' => 1, 'transactionRecordId' => NULL]);
                                // $resp = $info->Message;

                                Auth::login($getMerchant);
                            }


                            if (env('APP_ENV') !== 'local') {
                                $dob = $getMerchant->yearOfBirth . "-" . $getMerchant->monthOfBirth . "-" . $getMerchant->dayOfBirth;

                                $thisusersname = explode(" ", $getMerchant->name);

                                $getUsername = [
                                    'first_name' => $thisusersname[0],
                                    'middle_name' => '',
                                    'last_name' => $thisusersname[1],
                                ];

                                $shuftiVerify = new ShuftiProController();

                                $checkAvalable = $shuftiVerify->shuftiAvailableCountries($getMerchant->country);

                                if ($checkAvalable === true) {
                                    $checkAmlVerification = $shuftiVerify->callAmlCheck($getMerchant->ref_code, $dob, $getUsername, $getMerchant->email, $countryApproval->code);

                                    if ($checkAmlVerification->event !== 'verification.accepted') {
                                        User::where('id', $getMerchant->id)->update(['accountLevel' => 2, 'approval' => 1, 'shuftipro_verification' => 1]);
                                    } else {
                                        User::where('id', $getMerchant->id)->update(['accountLevel' => 2, 'approval' => 0, 'shuftipro_verification' => 0]);
                                    }
                                }
                            }
                        } else {

                            $message = "error";
                            $title = "Oops!";
                            $link = "contact";
                            $resInfo = "PaySprint is currently not available in your country. You can contact our Customer Service Executives for further enquiries. Thanks";

                            User::where('id', $getMerchant->id)->update(['accountLevel' => 0, 'countryapproval' => 0, 'transactionRecordId' => NULL]);
                        }





                        $this->mailListCategorize($req->firstname . ' ' . $req->lastname, $req->email, $req->address, $req->telephone, "New Merchants", $req->country, 'Subscription');

                        Log::info("New merchant registration via web by: " . $req->firstname . ' ' . $req->lastname . " from " . $req->state . ", " . $req->country . " STATUS: " . $resInfo);

                        $this->slack("New merchant registration via web by: " . $req->firstname . ' ' . $req->lastname . " from " . $req->state . ", " . $req->country . " STATUS: " . $resInfo, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));


                        // $message = "success";
                        // $title = "Great";
                        // $link = "Admin";
                        // $link = "merchant/dashboard";
                        // $resInfo = "Hello ".$req->firstname.", Welcome to PaySprint!";



                        $resData = ['res' => $resInfo, 'message' => $message, 'link' => $link];
                    } else {
                        $resData = ['res' => 'Something went wrong', 'message' => 'error'];
                    }
                }
            }
        }

        return $this->returnJSON($resData, 200);
    }

    //claim business
    public function ajaxclaimbusiness(Request $req)
    {

        // Check client record
        $checkClient = ClientInfo::where('email', $req->email)->get();
        if (count($checkClient) > 0) {
            // Check Admin table
            $checkAdmin = Admin::where('username', $req->username)->get();
            if (count($checkAdmin) > 0) {
                $resData = ['res' => 'Username already chosen', 'message' => 'error'];
            }
            // User already exist
            $resData = ['res' => 'User with this email already exist', 'message' => 'error'];
        } else {

            // Check User Account if Email
            $userExist = User::where('email', $req->email)->first();

            $transCost = TransactionCost::where('method', "Merchant Minimum Withdrawal")->where('country', $req->country)->first();

            if (isset($transCost)) {
                $transactionLimit = $transCost->fixed;
            } else {
                $transactionLimit = 0;
            }


            // $getRef = User::where('ref_code', $req->referred_by)->first();

            // if (isset($getRef)) {

            //     $referral_points = $getRef->referral_points + 100;

            //     User::where('id', $getRef->id)->update([
            //         'referral_points' => $referral_points
            //     ]);

            //     // Add to generate link
            //     $refGen = ReferralGenerate::where('ref_code', $req->referred_by)->first();

            //     if (isset($refGen)) {
            //         $ref_count = $refGen->referred_count + 1;

            //         ReferralGenerate::where('ref_code', $req->referred_by)->update(['referred_count' => $ref_count]);
            //     } else {
            //         ReferralGenerate::insert([
            //             'ref_code' => $req->referred_by,
            //             'name' => $getRef->name,
            //             'email' => $getRef->email,
            //             'ref_link' => route('home') . '/register?ref_code=' . $req->referred_by,
            //             'referred_count' => '1',
            //             'country' => $getRef->country,
            //             'is_admin' => false
            //         ]);
            //     }


            //     ReferredUsers::insert(['ref_code' => $req->referred_by, 'referred_user' => $req->email, 'referral_points' => 100]);
            // } else {
            //     $getRef = ReferralGenerate::where('ref_code', $req->referred_by)->first();

            //     if (isset($getRef)) {

            //         ReferredUsers::insert(['ref_code' => $req->referred_by, 'referred_user' => $req->email, 'referral_points' => 100]);

            //         $ref_count = $getRef->referred_count + 1;

            //         ReferralGenerate::where('ref_code', $req->referred_by)->update(['referred_count' => $ref_count]);
            //     }
            // }


            $userClosedExist = UserClosed::where('email', $req->email)->first();

            if (isset($userExist)) {
                // User already exist
                $resData = ['res' => 'The email address already exist as an Individual account holder', 'message' => 'error'];
            } elseif (isset($userClosedExist)) {
                // User already exist
                $resData = ['res' => 'Your account has already been created but currently not active on PaySprint. Contact the Admin for more information', 'message' => 'error'];
            } else {

                if ($req->how_your_heard_about_us == "Others") {
                    $specifyHeardAbout = $req->specify_how_your_heard_about_us;
                } else {
                    $specifyHeardAbout = $req->how_your_heard_about_us;
                }


                if ($req->source_of_funds == "Others") {
                    $source_of_funds = $req->specify_source;
                } else {
                    $source_of_funds = $req->source_of_funds;
                }


                if ($req->ref_code != null) {

                    $getanonuser = AnonUsers::where('ref_code', $req->ref_code)->first();


                    if ($req->type_of_service == "Add Service Type") {
                        $merchantservice = $req->other_type_of_service;
                    } else {
                        $merchantservice = $req->type_of_service;
                    }

                    // Insert
                    $insClient = ClientInfo::insert(['user_id' => $req->ref_code, 'business_name' => $req->business_name, 'address' => $req->business_address, 'corporate_type' => $req->corporate_type, 'firstname' => $req->firstname, 'lastname' => $req->lastname, 'email' => $getanonuser->email, 'country' => $req->country, 'state' => $req->state, 'city' => $req->city, 'zip_code' => $req->zip_code, 'industry' => $req->industry, 'telephone' => $req->business_telephone, 'website' => $req->website, 'api_secrete_key' => md5(uniqid($req->username, true)) . date('dmY') . time(), 'type_of_service' => $merchantservice]);

                    $insAdmin = Admin::insert(['user_id' => $req->ref_code, 'firstname' => $req->firstname, 'lastname' => $req->lastname, 'username' => $req->username, 'password' => Hash::make($req->password), 'role' => 'Merchant', 'email' => $getanonuser->email]);


                    $mycode = $this->getCountryCode($req->country);

                    $currencyCode = $mycode->currencyCode;
                    $currencySymbol = $mycode->currencySymbol;

                    // Get all ref_codes


                    // Insert to User

                    $api_token = uniqid() . md5($req->email) . time();


                    $data = ['code' => $mycode->callingCode, 'ref_code' => $req->ref_code, 'businessname' => $req->business_name, 'name' => $getanonuser->name, 'email' => $getanonuser->email, 'password' => Hash::make($req->password), 'address' => $req->street_number . ' ' . $req->street_name . ', ' . $req->city . ' ' . $req->state . ' ' . $req->country, 'telephone' => $getanonuser->telephone, 'city' => $req->city, 'state' => $req->state, 'country' => $getanonuser->country, 'currencyCode' => $currencyCode, 'currencySymbol' => $currencySymbol, 'accountType' => "Merchant", 'corporationType' => $req->corporate_type, 'zip' => $req->zip_code, 'api_token' => $api_token, 'wallet_balance' => $getanonuser->wallet_balance, 'dayOfBirth' => $req->dayOfBirth, 'monthOfBirth' => $req->monthOfBirth, 'yearOfBirth' => $req->yearOfBirth, 'platform' => 'web', 'accountLevel' => 2, 'withdrawal_per_transaction' => $transactionLimit, 'referred_by' => $req->referred_by, 'knowAboutUs' => $specifyHeardAbout, 'accountPurpose' => $req->describe_purpose, 'transactionSize' => $req->size_of_transaction, 'sourceOfFunding' => $source_of_funds, 'shuftiproservice' => 0];


                    User::updateOrCreate(['email' => $getanonuser->email], $data);

                    if (isset($insAdmin)) {
                        // Set session
                        $getMerchant = User::where('ref_code', $req->ref_code)->first();


                        $req->session()->put(['user_id' => $req->ref_code, 'firstname' => $req->firstname, 'lastname' => $req->lastname, 'username' => $req->username, 'role' => 'Merchant', 'email' => $getanonuser->email, 'api_token' => $api_token, 'myID' => $getMerchant->id, 'country' => $getanonuser->country, 'businessname' => $getanonuser->businessname, 'loginCount' => $getMerchant->loginCount, 'currencyCode' => $getMerchant->currencyCode]);

                        $getMoney = Statement::where('user_id', $getanonuser->email)->get();

                        if (count($getMoney) > 0) {
                            foreach ($getMoney as $key => $value) {

                                Statement::where('reference_code', $value->reference_code)->update(['status' => 'Delivered']);
                            }
                        } else {
                            // Do nothing
                        }


                        AnonUsers::where('ref_code', $req->ref_code)->delete();

                        Log::info("New merchant registration via web by: " . $req->firstname . ' ' . $req->lastname . " from " . $req->state . ", " . $req->country);

                        $this->slack("New merchant registration via web by: " . $req->firstname . ' ' . $req->lastname . " from " . $req->state . ", " . $req->country, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));


                        $url = 'https://api.globaldatacompany.com/verifications/v1/verify';

                        $minimuAge = date('Y') - $req->yearOfBirth;

                        $countryApproval = AllCountries::where('name', $req->country)->where('approval', 1)->first();

                        if (isset($countryApproval)) {
                            $info = $this->identificationAPI($url, $req->firstname, $req->lastname, $req->dayOfBirth, $req->monthOfBirth, $req->yearOfBirth, $minimuAge, $req->street_number . ' ' . $req->street_name . ', ' . $req->city . ' ' . $req->state . ' ' . $req->country, $req->city, $req->country, $req->zip_code, $getanonuser->telephone, $getanonuser->email, $mycode->code);


                            if (isset($info->TransactionID) == true) {

                                $result = $this->transStatus($info->TransactionID);

                                // if (isset($result)) {

                                //     if (isset($result->TransactionRecordId)) {
                                //         $transxID = $result->TransactionRecordId;
                                //     } else {
                                //         $transxID = $result['TransactionRecordId'];
                                //     }

                                //     Log::info(json_encode($transxID));

                                //     $verifyRes = $this->getTransRec($transxID);

                                //     $verRes = $verifyRes->Record->RecordStatus;
                                // } else {
                                //     $verRes = "nomatch";
                                // }


                                if ($info->Record->RecordStatus == "nomatch") {

                                    // $message = "error";
                                    // $title = "Oops!";
                                    // $link = "contact";

                                    $message = "success";
                                    $title = "Great";
                                    // $link = "Admin";
                                    $link = "merchant/dashboard";


                                    $resInfo = strtoupper($info->Record->RecordStatus) . ", Welcome to PaySprint, World's #1 Affordable Payment Method that enables you to send and receive money, pay Invoice and bills and getting paid at anytime. You will be able to add money to your wallet, Pay Invoice or Utility bills, but you will not be able to send or receive money or withdraw money from your Wallet pending the verification of Government issued Photo ID and Utility bill or Bank statement uploaded. \nKindly follow these steps to upload the required information: \na. login to PaySprint Account on Mobile App or Web app at www.paysprint.ca \nb. Go to profile page, take a Selfie of yourself and upload along with a copy of Goverment Issued Photo ID, a copy of Utility bills and business documents \nAll other features would be enabled for you as soon as Compliance Team verifies your information \nThank you for your interest in PaySprint.\nCompliance Team @PaySprint \ninfo@paysprint.ca";
                                    User::where('id', $getMerchant->id)->update(['accountLevel' => 2, 'countryapproval' => 1, 'transactionRecordId' => $info->TransactionID]);


                                    Auth::login($getMerchant);
                                } else {
                                    $message = "success";
                                    $title = "Great";
                                    // $link = "Admin";
                                    $link = "merchant/dashboard";
                                    $resInfo = strtoupper($info->Record->RecordStatus) . ", Congratulations!!!. Your account has been approved. Kindly complete the Quick Set up to enjoy the full benefits of  PaySprint.";

                                    // Udpate User Info
                                    User::where('id', $getMerchant->id)->update(['accountLevel' => 2, 'approval' => 1, 'countryapproval' => 1, 'bvn_verification' => 1, 'transactionRecordId' => $info->TransactionID]);

                                    Auth::login($getMerchant);
                                }
                            } else {
                                $message = "success";
                                $title = "Great";
                                // $link = "Admin";
                                $link = "merchant/dashboard";
                                $resInfo = "Welcome to PaySprint, World's #1 Affordable Payment Method that enables you to send and receive money, pay Invoice and bills and getting paid at anytime. You will be able to add money to your wallet, Pay Invoice or Utility bills, but you will not be able to send or receive money or withdraw money from your Wallet pending the verification of Government issued Photo ID and Utility bill or Bank statement uploaded. \nKindly follow these steps to upload the required information: \na. login to PaySprint Account on Mobile App or Web app at www.paysprint.ca \nb. Go to profile page, take a Selfie of yourself and upload along with a copy of Goverment Issued Photo ID, a copy of Utility bills and business documents \nAll other features would be enabled for you as soon as Compliance Team verifies your information \nThank you for your interest in PaySprint.\nCompliance Team @PaySprint \ninfo@paysprint.ca";

                                User::where('id', $getMerchant->id)->update(['accountLevel' => 2, 'countryapproval' => 1, 'transactionRecordId' => NULL]);

                                Auth::login($getMerchant);

                                // $resp = $info->Message;
                            }

                            $this->name = $req->firstname . ' ' . $req->lastname;
                            // $this->email = "bambo@vimfile.com";
                            $this->to = $req->email;
                            $this->subject = "Welcome to PaySprint";

                            $message = "Welcome to PaySprint, World's #1 Affordable Payment Method that enables you to send and receive money, pay Invoice and bills and getting paid at anytime. You will be able to add money to your wallet, Create and Send Invoice, Accept and Receive payment from all the channels, Pay received Invoice or Utility bills, but you will not be able to send or receive money or withdraw money from your Wallet pending the verification of Government issued Photo ID and Utility bill or Bank statement uploaded. <br> Kindly follow these steps to upload the required information: <br> a. login to PaySprint Account on Mobile App or Web app at www.paysprint.ca <br> b. Go to profile page and upload a copy of Goverment Issued Photo ID, a copy of Utility bill and business documents. <br> All other features would be enabled for you as soon as the Compliance Team verifies your information <br> Thank you for your interest in PaySprint. <br><br> Compliance Team @PaySprint <br> info@paysprint.ca";


                            $this->message = '<p>' . $message . '</p>';


                            $this->sendEmail($this->to, "Refund Request");


                            if ($req->country == "India") {

                                $this->name = $req->firstname . ' ' . $req->lastname;
                                // $this->email = "bambo@vimfile.com";
                                $this->email = $req->email;
                                $this->subject = "Special Notice";

                                $mailmessage = "Dear " . $req->fname . ", If you are presenting India Aadhaar Card as the form of identification, kindly upload your India Permanent Account Number card as well using same icon.Thanks";

                                $this->message = '<p>' . $mailmessage . '</p>';


                                $this->sendEmail($this->email, "Fund remittance");
                            }
                        } else {
                            $message = "error";
                            $title = "Oops!";
                            $link = "contact";
                            $resInfo = "PaySprint is currently not available in your country. You can contact our Customer Service Executives for further enquiries. Thanks";

                            User::where('id', $getMerchant->id)->update(['accountLevel' => 0, 'countryapproval' => 0, 'transactionRecordId' => NULL]);
                        }


                        // TODO:: Kindly return to live when subscription live on ShuftiPro...

                        if (env('APP_ENV') !== 'local') {
                            $dob = $getMerchant->yearOfBirth . "-" . $getMerchant->monthOfBirth . "-" . $getMerchant->dayOfBirth;

                            $thisusersname = explode(" ", $getMerchant->name);

                            $getUsername = [
                                'first_name' => $thisusersname[0],
                                'middle_name' => '',
                                'last_name' => $thisusersname[1],
                            ];

                            $shuftiVerify = new ShuftiProController();

                            $checkAvalable = $shuftiVerify->shuftiAvailableCountries($getMerchant->country);

                            if ($checkAvalable === true) {
                                $checkAmlVerification = $shuftiVerify->callAmlCheck($getMerchant->ref_code, $dob, $getUsername, $getMerchant->email, $mycode->code);


                                if ($checkAmlVerification->event !== 'verification.accepted') {
                                    User::where('id', $getMerchant->id)->update(['accountLevel' => 2, 'approval' => 1, 'shuftipro_verification' => 1]);
                                } else {
                                    User::where('id', $getMerchant->id)->update(['accountLevel' => 2, 'approval' => 0, 'shuftipro_verification' => 0]);
                                }
                            }
                        }



                        $this->mailListCategorize($req->firstname . ' ' . $req->lastname, $req->email, $req->address, $req->telephone, "New Merchants", $req->country, 'Subscription');

                        Log::info("New merchant registration via web by: " . $req->firstname . ' ' . $req->lastname . " from " . $req->state . ", " . $req->country . " STATUS: " . $resInfo);

                        $this->slack("New merchant registration via web by: " . $req->firstname . ' ' . $req->lastname . " from " . $req->state . ", " . $req->country . " STATUS: " . $resInfo, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));


                        // This is the response for now until trulioo activates us to LIVE..

                        // $message = "success";
                        // $title = "Great";
                        // $link = "Admin";
                        // $link = "merchant/dashboard";
                        // $resInfo = "Hello ".$req->firstname.", Welcome to PaySprint...";



                        $resData = ['res' => $resInfo, 'message' => $message, 'link' => $link];
                    } else {
                        $resData = ['res' => 'Something went wrong', 'message' => 'error'];
                    }
                } else {

                    $ref_code = mt_rand(0000000, 9999999);


                    $ref = User::all();

                    if (count($ref) > 0) {
                        foreach ($ref as $key => $value) {
                            if ($value->ref_code == $ref_code) {
                                $newRefcode = mt_rand(0000000, 9999999);
                            } else {
                                $newRefcode = $ref_code;
                            }
                        }
                    } else {
                        $newRefcode = $ref_code;
                    }


                    if ($req->type_of_service == "Add Service Type") {
                        $merchantservice = $req->other_type_of_service;
                    } else {
                        $merchantservice = $req->type_of_service;
                    }

                    // Insert
                    $insClient = ClientInfo::insert(['user_id' => $newRefcode, 'business_name' => $req->business_name, 'address' => $req->business_address, 'corporate_type' => $req->corporate_type, 'firstname' => $req->firstname, 'lastname' => $req->lastname, 'email' => $req->email, 'country' => $req->country, 'state' => $req->state, 'city' => $req->city, 'zip_code' => $req->zip_code, 'industry' => $req->industry, 'telephone' => $req->business_telephone, 'website' => $req->website, 'api_secrete_key' => md5(uniqid($req->username, true)) . date('dmY') . time(), 'type_of_service' => $merchantservice]);

                    $insAdmin = Admin::insert(['user_id' => $newRefcode, 'firstname' => $req->firstname, 'lastname' => $req->lastname, 'username' => $req->username, 'password' => Hash::make($req->password), 'role' => 'Merchant', 'email' => $req->email]);


                    $mycode = $this->getCountryCode($req->country);

                    $currencyCode = $mycode->currencyCode;
                    $currencySymbol = $mycode->currencySymbol;

                    // Get all ref_codes


                    // Insert to User

                    $api_token = uniqid() . md5($req->email) . time();

                    if (isset($mycode->callingCode)) {

                        if ($req->country == "United States") {
                            $phoneCode = "1";
                        } else {
                            $phoneCode = $mycode->callingCode;
                        }
                    } else {
                        $phoneCode = "1";
                    }


                    $data = ['code' => $phoneCode, 'ref_code' => $newRefcode, 'businessname' => $req->business_name, 'name' => $req->firstname . ' ' . $req->lastname, 'email' => $req->email, 'password' => Hash::make($req->password), 'address' => $req->street_number . ' ' . $req->street_name . ', ' . $req->city . ' ' . $req->state . ' ' . $req->country, 'telephone' => $req->telephone, 'city' => $req->city, 'state' => $req->state, 'country' => $req->country, 'currencyCode' => $currencyCode, 'currencySymbol' => $currencySymbol, 'accountType' => "Merchant", 'corporationType' => $req->corporate_type, 'zip' => $req->zip_code, 'api_token' => $api_token, 'dayOfBirth' => $req->dayOfBirth, 'monthOfBirth' => $req->monthOfBirth, 'yearOfBirth' => $req->yearOfBirth, 'platform' => 'web', 'accountLevel' => 2, 'withdrawal_per_transaction' => $transactionLimit, 'referred_by' => $req->referred_by, 'knowAboutUs' => $specifyHeardAbout, 'accountPurpose' => $req->describe_purpose, 'transactionSize' => $req->size_of_transaction, 'sourceOfFunding' => $source_of_funds, 'shuftiproservice' => 0];


                    User::updateOrCreate(['email' => $req->email], $data);

                    if (isset($insAdmin)) {

                        $getMerchant = User::where('ref_code', $newRefcode)->first();

                        // Set session

                        $req->session()->put(['user_id' => $newRefcode, 'firstname' => $req->firstname, 'lastname' => $req->lastname, 'username' => $req->username, 'role' => 'Merchant', 'email' => $req->email, 'api_token' => $api_token, 'myID' => $getMerchant->id, 'country' => $req->country, 'loginCount' => $getMerchant->loginCount, 'currencyCode' => $getMerchant->currencyCode]);

                        Log::info("New merchant registration via web by: " . $req->firstname . ' ' . $req->lastname . " from " . $req->state . ", " . $req->country);

                        $this->slack("New merchant registration via web by: " . $req->firstname . ' ' . $req->lastname . " from " . $req->state . ", " . $req->country, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));

                        $countryApproval = AllCountries::where('name', $req->country)->where('approval', 1)->first();

                        $url = 'https://api.globaldatacompany.com/verifications/v1/verify';

                        $minimuAge = date('Y') - $req->yearOfBirth;

                        if (isset($countryApproval)) {

                            $info = $this->identificationAPI($url, $req->firstname, $req->lastname, $req->dayOfBirth, $req->monthOfBirth, $req->yearOfBirth, $minimuAge, $req->street_number . ' ' . $req->street_name . ', ' . $req->city . ' ' . $req->state . ' ' . $req->country, $req->city, $req->country, $req->zip_code, $req->telephone, $req->email, $mycode->code);


                            if (isset($info->TransactionID) == true) {

                                $result = $this->transStatus($info->TransactionID);

                                // $res = $this->getTransRec($result->TransactionRecordId);

                                // if (isset($result)) {

                                //     if (isset($result->TransactionRecordId)) {
                                //         $transxID = $result->TransactionRecordId;
                                //     } else {
                                //         $transxID = $result['TransactionRecordId'];
                                //     }

                                //     Log::info(json_encode($transxID));

                                //     $verifyRes = $this->getTransRec($transxID);

                                //     $verRes = $verifyRes->Record->RecordStatus;
                                // } else {
                                //     $verRes = "nomatch";
                                // }


                                if ($info->Record->RecordStatus == "nomatch") {

                                    $message = "success";
                                    $title = "Great";
                                    // $link = "Admin";
                                    $link = "merchant/dashboard";

                                    $resInfo = strtoupper($info->Record->RecordStatus) . ", Our system is yet to complete your registration. Kindly upload a copy of Government-issued Photo ID, a copy of a Utility Bill or Bank Statement that matches your name with the current address and also take a Selfie of yourself (if using the mobile app) and upload in your profile setting to complete the verification process. Kindly contact the admin using the contact us form if you require further assistance. Thank You";
                                    User::where('id', $getMerchant->id)->update(['accountLevel' => 0, 'countryapproval' => 1, 'transactionRecordId' => $info->TransactionID]);

                                    Auth::login($getMerchant);
                                } else {
                                    $message = "success";
                                    $title = "Great";
                                    // $link = "Admin";
                                    $link = "merchant/dashboard";
                                    $resInfo = strtoupper($info->Record->RecordStatus) . ", Congratulations!!!. Your account has been approved. Kindly complete the Quick Set up to enjoy the full benefits of PaySprint.";

                                    // Udpate User Info
                                    User::where('id', $getMerchant->id)->update(['accountLevel' => 2, 'approval' => 1, 'countryapproval' => 1, 'bvn_verification' => 1, 'transactionRecordId' => $info->TransactionID]);

                                    Auth::login($getMerchant);
                                }
                            } else {
                                $message = "success";
                                $title = "Great";
                                // $link = "Admin";
                                $link = "merchant/dashboard";
                                $resInfo = "Our system is yet to complete your registration. Kindly upload a copy of Government-issued Photo ID, a copy of a Utility Bill or Bank Statement that matches your name with the current address and also take a Selfie of yourself (if using the mobile app) and upload in your profile setting to complete the verification process. Kindly contact the admin using the contact us form if you require further assistance. Thank You";

                                User::where('id', $getMerchant->id)->update(['accountLevel' => 0, 'countryapproval' => 1, 'transactionRecordId' => NULL]);
                                // $resp = $info->Message;

                                Auth::login($getMerchant);
                            }


                            if (env('APP_ENV') !== 'local') {
                                $dob = $getMerchant->yearOfBirth . "-" . $getMerchant->monthOfBirth . "-" . $getMerchant->dayOfBirth;

                                $thisusersname = explode(" ", $getMerchant->name);

                                $getUsername = [
                                    'first_name' => $thisusersname[0],
                                    'middle_name' => '',
                                    'last_name' => $thisusersname[1],
                                ];

                                $shuftiVerify = new ShuftiProController();

                                $checkAvalable = $shuftiVerify->shuftiAvailableCountries($getMerchant->country);

                                if ($checkAvalable === true) {
                                    $checkAmlVerification = $shuftiVerify->callAmlCheck($getMerchant->ref_code, $dob, $getUsername, $getMerchant->email, $countryApproval->code);

                                    if ($checkAmlVerification->event !== 'verification.accepted') {
                                        User::where('id', $getMerchant->id)->update(['accountLevel' => 2, 'approval' => 1, 'shuftipro_verification' => 1]);
                                    } else {
                                        User::where('id', $getMerchant->id)->update(['accountLevel' => 2, 'approval' => 0, 'shuftipro_verification' => 0]);
                                    }
                                }
                            }
                        } else {

                            $message = "error";
                            $title = "Oops!";
                            $link = "contact";
                            $resInfo = "PaySprint is currently not available in your country. You can contact our Customer Service Executives for further enquiries. Thanks";

                            User::where('id', $getMerchant->id)->update(['accountLevel' => 0, 'countryapproval' => 0, 'transactionRecordId' => NULL]);
                        }

                        UnverifiedMerchant::where('email', $req->email)->delete();

                        $sendgrid = new SendGridController();

                        $sendmail =$sendgrid->sendUsername($req->business_name,$req->username, $req->password);


                        $this->mailListCategorize($req->firstname . ' ' . $req->lastname, $req->email, $req->address, $req->telephone, "New Merchants", $req->country, 'Subscription');

                        Log::info("New merchant registration via web by: " . $req->firstname . ' ' . $req->lastname . " from " . $req->state . ", " . $req->country . " STATUS: " . $resInfo);

                        $this->slack("New merchant registration via web by: " . $req->firstname . ' ' . $req->lastname . " from " . $req->state . ", " . $req->country . " STATUS: " . $resInfo, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));


                        // $message = "success";
                        // $title = "Great";
                        // $link = "Admin";
                        // $link = "merchant/dashboard";
                        // $resInfo = "Hello ".$req->firstname.", Welcome to PaySprint!";



                        $resData = ['res' => $resInfo, 'message' => $message, 'link' => $link];
                    } else {
                        $resData = ['res' => 'Something went wrong', 'message' => 'error'];
                    }
                }
            }
        }

        return $this->returnJSON($resData, 200);
    }



    public function ajaxgetmyStatement(Request $req)
    {
        // Get Where UserID is session

        $from = $req->start_date;
        $nextDay = $req->end_date;

        if ($req->service == "Wallet") {

            $getInvs = Statement::where('user_id', session('email'))->where('activity', 'LIKE', '%' . $req->service . '%')->whereBetween('trans_date', [$from, $nextDay])->orderBy('created_at', 'DESC')->get();


            if (count($getInvs) > 0) {
                $myStatement = $getInvs;
                $status = "wallet";
            } else {

                $myStatement = array('0' => ['error' => 'No statement record', 'info' => 'no_exist']);
                $status = "none";
            }




            if (count($myStatement) > 0) {
                // Check For If Invoice belongs to USer
                $resData = ['res' => 'Fetching Data', 'message' => 'success', 'data' => json_encode($myStatement), 'title' => 'Good', 'status' => $status];
            } else {
                $resData = ['res' => 'You do not have record for this service', 'message' => 'error', 'title' => 'Oops!', 'info' => 'no_exist'];
            }
        } else {


            $payment = DB::table('invoice_payment')
                ->select(DB::raw('invoice_payment.transactionid, invoice_payment.name, invoice_payment.email, import_excel.amount as invoice_amount, invoice_payment.invoice_no, invoice_payment.service, invoice_payment.created_at as transaction_date, import_excel.description as description, invoice_payment.remaining_balance as runningbalance, invoice_payment.amount as amount_paid, import_excel.status, invoice_payment.mystatus'))->distinct()
                ->join('import_excel', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')
                ->where('import_excel.uploaded_by', session('user_id'))
                ->where('invoice_payment.service', $req->service)
                ->whereBetween('invoice_payment.created_at', [$from, $nextDay])
                ->orderBy('invoice_payment.created_at', 'DESC')->get();


            if (count($payment) > 0) {
                $myStatement = $payment;
                $status = "payment";
            } else {


                $getInvoice = DB::table('statement')
                    ->select(DB::raw('statement.reference_code as transactionid, statement.trans_date as transaction_date, statement.activity as description, statement.credit as invoice_amount, statement.debit as amount_paid'))->distinct()
                    ->where('statement.regards', session('user_id'))
                    ->whereBetween('statement.trans_date', [$from, $nextDay])
                    ->orderBy('statement.created_at', 'DESC')->get();



                if (count($getInvoice) > 0) {
                    $myStatement = $getInvoice;
                    $status = "invoice";
                } else {
                    $myStatement = array('0' => ['error' => 'No statement record', 'info' => 'no_exist']);
                    $status = "none";
                }
            }

            if (count($myStatement) > 0) {
                // Check For If Invoice belongs to USer
                $resData = ['res' => 'Fetching Data', 'message' => 'success', 'data' => json_encode($myStatement), 'title' => 'Good', 'status' => $status];
            } else {
                $resData = ['res' => 'You do not have record for this service', 'message' => 'error', 'title' => 'Oops!', 'info' => 'no_exist'];
            }
        }



        return $this->returnJSON($resData, 200);
    }


    public function ajaxpromotionaction(Request $req, ClientInfo $clientinfo)
    {

        $data = $clientinfo->where('id', $req->id)->first();

        if (isset($data)) {

            if ($req->val == "Remove") {
                $clientinfo->where('id', $req->id)->update(['promote_business' => 0, 'push_notification' => 0]);

                // Return Money back to User

                $businessPromote = $this->processPromoteBusinessRefund($data->email);

                if ($businessPromote == "Successful") {

                    $this->name = $data->firstname . " " . $data->lastname;
                    $this->to = $data->email;
                    $this->subject = "Withdrawal Refund";
                    $this->message = "We are sorry to inform you that your promotion request has been removed. Kindly contact the Admin if you need to review this action. Thanks";

                    $this->sendEmail($this->to, "Refund Request");

                    $respData = $businessPromote;
                    $resp = "success";
                    $title = "Good!";
                } else {

                    $respData = $businessPromote;
                    $resp = "error";
                    $title = "Oops!";
                }

                $resData = ['res' => $respData, 'message' => $resp, 'title' => $title];
            } else {
                $clientinfo->where('id', $req->id)->update(['push_notification' => 0]);
                $resData = ['res' => 'Success', 'message' => 'success', 'title' => 'Good!'];
            }
        } else {
            $resData = ['res' => 'Merchant record not found', 'message' => 'error', 'title' => 'Oops!'];
        }


        return $this->returnJSON($resData, 200);
    }


    public function ajaxacceptcrossborderpayment(Request $req, CrossBorder $crossborder)
    {

        try {
            $data = $crossborder->where('transaction_id', $req->transactionid)->update(['status' => true]);


            $res = 'Payment processed';
            $message = "success";
            $title = "Good";
        } catch (\Throwable $th) {
            $res = $th->getMessage();
            $message = "error";
            $title = "Oops";
        }

        $resData = ['res' => $res, 'message' => $message, 'title' => $title];



        return $this->returnJSON($resData, 200);
    }


    public function getWalletStatementRecordByDate($service, $from, $nextDay)
    {

        $data = Statement::where('user_id', session('email'))->where('activity', 'LIKE', '%' . $service . '%')->whereBetween('trans_date', [$from, $nextDay])->orderBy('created_at', 'DESC')->get();


        return $data;
    }

    public function getUserWalletStatementRecordByDate($user_id, $from, $nextDay)
    {

        if ($user_id == "all") {
            $data = Statement::whereBetween('trans_date', [$from, $nextDay])->orderBy('created_at', 'DESC')->get();
        } else {
            $data = Statement::where('user_id', $user_id)->whereBetween('trans_date', [$from, $nextDay])->orderBy('created_at', 'DESC')->get();
        }



        return $data;
    }


    public function getUserWalletPurchaseStatementRecordByDate($user_id, $from, $nextDay)
    {

        $data = Statement::where('reference_code', 'LIKE', '%822%')->where('report_status', 'Withdraw from wallet')->where('user_id', $user_id)->whereBetween('trans_date', [$from, $nextDay])->orderBy('created_at', 'DESC')->get();

        return $data;
    }

    public function getUserWalletPurchaseStatementRecordByCountryDate($country, $from, $nextDay)
    {

        $data = Statement::where('reference_code', 'LIKE', '%822%')->where('report_status', 'Withdraw from wallet')->where('country', $country)->whereBetween('trans_date', [$from, $nextDay])->orderBy('created_at', 'DESC')->get();

        return $data;
    }



    public function getStatementRecordByDate($service, $from, $nextDay)
    {

        $payment = DB::table('invoice_payment')
            ->select(DB::raw('invoice_payment.transactionid, invoice_payment.name, invoice_payment.email, import_excel.amount as invoice_amount, invoice_payment.invoice_no, invoice_payment.service, invoice_payment.created_at as transaction_date, import_excel.description as description, invoice_payment.remaining_balance as runningbalance, invoice_payment.amount as amount_paid, import_excel.status, invoice_payment.mystatus'))->distinct()
            ->join('import_excel', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')
            ->where('import_excel.uploaded_by', session('user_id'))
            ->where('invoice_payment.service', 'LIKE', '%' . $service . '%')
            ->whereBetween('invoice_payment.created_at', [$from, $nextDay])
            ->orderBy('invoice_payment.created_at', 'DESC')->get();




        if (isset($payment)) {
            $data = $payment;
        } else {


            $getInvoice = DB::table('statement')
                ->select(DB::raw('statement.reference_code as transactionid, statement.trans_date as transaction_date, statement.activity as description, statement.credit as invoice_amount, statement.debit as amount_paid'))->distinct()
                ->where('statement.regards', session('user_id'))
                ->whereBetween('statement.trans_date', [$from, $nextDay])
                ->orderBy('statement.created_at', 'DESC')->get();


            $data = $getInvoice;
        }


        return $data;
    }



    public function ajaxgetmyreportStatement(Request $req)
    {
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

        if (count($payment) > 0) {
            $myStatement = $payment;
            $status = "payment";
        } else {

            $getInvoice = DB::table('import_excel')
                ->select(DB::raw('import_excel.transaction_ref, import_excel.invoice_no, users.name, users.address, import_excel.payment_due_date as due_date, import_excel.amount as invoice_amount, import_excel.description'))->distinct()
                ->join('users', 'import_excel.payee_email', '=', 'users.email')
                ->where('import_excel.uploaded_by', session('user_id'))
                ->where('import_excel.service', $req->service)
                ->whereBetween('import_excel.created_at', [$from, $nextDay])
                ->orderBy('import_excel.created_at', 'DESC')->get();



            if (count($getInvoice) > 0) {
                $myStatement = $getInvoice;
                $status = "invoice";
            } else {
                $myStatement = array('0' => ['error' => 'No statement record', 'info' => 'no_exist']);
                $status = "none";
            }
        }

        if (count($myStatement) > 0) {
            // Check For If Invoice belongs to USer
            $resData = ['res' => 'Fetching Data', 'message' => 'success', 'data' => json_encode($myStatement), 'title' => 'Good', 'status' => $status];
        } else {
            $resData = ['res' => 'You do not have record for this service', 'message' => 'error', 'title' => 'Oops!', 'info' => 'no_exist'];
        }



        return $this->returnJSON($resData, 200);
    }


    public function ajaxWithdrawCash(Request $req)
    {

        // Update payment info
        $getUser = ClientInfo::where('user_id', $req->user_id)->get();

        if (count($getUser) > 0) {
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

            if ($updt == 1) {
                // Send Mail
                // update invoice pay
                InvoicePayment::where('client_id', $req->user_id)->update(['amount' => 0]);

                $this->name = session('firstname') . ' ' . session('lastname');
                $this->to = session('email');


                $this->subject = "Account is credited";
                $this->info = "Account is credited";
                $this->message = 'We are glad to notify you that your withdrawal request of <b>$' . $req->amount . '</b> has been received. Your money has been  transferred to your PaySprint Wallet where you can withdraw by available method. Thanks';

                $this->sendEmail($this->to, "Account is credited");



                $resData = ['res' => 'Cash withdrawal of $' . $req->amount . ' is Successfull', 'message' => 'success', 'title' => 'Good'];
            } else {
                $resData = ['res' => 'Something went wrong', 'message' => 'error', 'title' => 'Oops!'];
            }
        } else {
            $resData = ['res' => 'Record not found', 'message' => 'error', 'title' => 'Oops!'];
        }




        return $this->returnJSON($resData, 200);
    }


    public function ajaxepaywithdraw(Request $req)
    {
        // Insert Record
        // Update collection


        if ($req->amount != 0) {
            $ins = Epaywithdraw::insert(['withdraw_id' => uniqid(), 'client_id' => $req->user_id, 'client_name' => session('firstname') . ' ' . session('lastname'), 'card_method' => $req->card_method, 'client_email' => session('email'), 'amount_to_withdraw' => $req->amount]);


            if ($ins == true) {
                // Send Mail on the transaction
                OrganizationPay::where('coy_id', $req->user_id)->update(['withdraws' => 0]);

                $this->name = session('firstname') . ' ' . session('lastname');
                $this->email = session('email');
                $this->admin = "Admin";
                $this->info = "Fund remittance";
                $this->info2 = "Cash withdrawal request";
                $this->subject = "Cash withdrawal request";

                $this->infomessage = 'A client of PaySprint has requested for a withdrawal of <b>$' . $req->amount . '</b> using the ' . $req->card_method . ' method. <br><br> Details is as stated below: <hr><br> Organization name: ' . $this->name . ' <br> Amount to Withdraw: ' . $req->amount . ' <br> Payment Method: ' . $req->card_method . ' <br><hr>.Thanks';



                $this->message = 'Your request for funds withdrawal is being processed. You will receive fund through the payment option selected within the next 24 hours';

                // dd($this->to);

                $this->sendEmail($this->email, "Fund remittance");
                $this->sendEmail($this->to, "Cash withdrawal request");



                $resData = ['res' => 'Withdrawal request of $' . $req->amount . ' is successfull', 'message' => 'success', 'title' => 'Good'];
            } else {
                $resData = ['res' => 'Something went wrong', 'message' => 'error', 'title' => 'Oops!'];
            }
        } else {
            $resData = ['res' => 'Insufficient amount to withdraw. You have $' . $req->amount . ' available.', 'message' => 'error', 'title' => 'Oops!'];
        }


        return $this->returnJSON($resData, 200);
    }


    public function ajaxremitdetailsCash(Request $req)
    {

        if ($req->val == "epayca") {

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

            if (count($transaction_cost) > 0) {
                $fixed = $transaction_cost[0]->fixed;
                $variable = $transaction_cost[0]->variable;
            } else {
                $fixed = 0;
                $variable = 0;
            }

            // dd($req->user_id);
            if (count($getClient) > 0) {

                $resData = ['res' => 'Retrieval...', 'message' => 'success', 'title' => 'Great', 'data' => json_encode($getClient), 'action' => 'epayca', 'client' => json_encode($client), 'fixed' => $fixed, 'variable' => $variable];
            } else {
                $resData = ['res' => 'Record not found', 'message' => 'error', 'title' => 'Oops!'];
            }
        } elseif ($req->val == "payca") {
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

            if (count($transaction_cost) > 0) {
                $fixed = $transaction_cost[0]->fixed;
                $variable = $transaction_cost[0]->variable;
            } else {
                $fixed = 0;
                $variable = 0;
            }

            if (count($getClient) > 0) {
                $resData = ['res' => 'Retrieval...', 'message' => 'success', 'title' => 'Great', 'data' => json_encode($getClient), 'action' => 'payca', 'client' => json_encode($client), 'fixed' => $fixed, 'variable' => $variable];
            } else {
                $resData = ['res' => 'Record not found', 'message' => 'error', 'title' => 'Oops!'];
            }
        }


        return $this->returnJSON($resData, 200);
    }

    public function ajaxgetmremittance(Request $req)
    {

        $from = $req->start_date;
        $nextDay = $req->end_date;


        if ($req->val == "payca") {
            // Update Information
            // $getClient = InvoicePayment::where('client_id', $req->client_id)->where('service', $req->service)->whereBetween('created_at', [$from, $nextDay])->get();

            if ($req->service == "all") {
                $getClient = DB::table('invoice_payment')
                    ->select(DB::raw('invoice_payment.transactionid, invoice_payment.name, invoice_payment.email, import_excel.amount as invoice_amount, invoice_payment.invoice_no, invoice_payment.service, invoice_payment.created_at as transaction_date, import_excel.description as description, invoice_payment.remaining_balance as runningbalance, invoice_payment.opening_balance, invoice_payment.amount as amount_paid, import_excel.status, import_excel.payment_due_date, invoice_payment.mystatus, import_excel.payee_ref_no, import_excel.transaction_ref, users.address'))->distinct()
                    ->join('import_excel', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')
                    ->join('users', 'invoice_payment.email', '=', 'users.email')
                    ->where('import_excel.uploaded_by', $req->client_id)
                    ->orderBy('invoice_payment.created_at', 'DESC')->get();
            } else {
                $getClient = DB::table('invoice_payment')
                    ->select(DB::raw('invoice_payment.transactionid, invoice_payment.name, invoice_payment.email, import_excel.amount as invoice_amount, invoice_payment.invoice_no, invoice_payment.service, invoice_payment.created_at as transaction_date, import_excel.description as description, invoice_payment.remaining_balance as runningbalance, invoice_payment.opening_balance, invoice_payment.amount as amount_paid, import_excel.status, import_excel.payment_due_date, invoice_payment.mystatus, import_excel.payee_ref_no, import_excel.transaction_ref'))->distinct()
                    ->join('import_excel', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')
                    ->where('import_excel.uploaded_by', $req->client_id)
                    ->where('invoice_payment.service', $req->service)->whereBetween('invoice_payment.created_at', [$from, $nextDay])
                    ->orderBy('invoice_payment.created_at', 'DESC')->get();
            }

            $withdraw_id = PaycaWithdraw::where('client_id', $req->client_id)->get();

            if (count($withdraw_id) > 0) {
                $withID = $withdraw_id[0]->withdraw_id;
            } else {
                $withID = 0;
            }


            $transaction_cost = TransactionCost::all();

            if (count($transaction_cost) > 0) {
                $fixed = $transaction_cost[0]->fixed;
                $variable = $transaction_cost[0]->variable;
            } else {
                $fixed = 0;
                $variable = 0;
            }


            if (count($getClient) > 0) {
                $resData = ['res' => 'Retrieval...', 'message' => 'success', 'title' => 'Great', 'data' => json_encode($getClient), 'action' => 'payca', 'withdraw_id' => $withID, 'fixed' => $fixed, 'variable' => $variable];
            } else {
                $resData = ['res' => 'Record not found', 'message' => 'error', 'title' => 'Oops!'];
            }
        } elseif ($req->val == "comission") {

            // Update Information
            // $getClient = InvoicePayment::where('client_id', $req->client_id)->where('service', $req->service)->whereBetween('created_at', [$from, $nextDay])->get();

            if ($req->service == "all") {
                $getClient = DB::table('invoice_payment')
                    ->select(DB::raw('invoice_payment.transactionid, invoice_payment.name, invoice_payment.email, import_excel.amount as invoice_amount, invoice_payment.invoice_no, invoice_payment.service, invoice_payment.created_at as transaction_date, import_excel.description as description, invoice_payment.remaining_balance as runningbalance, invoice_payment.opening_balance, invoice_payment.amount as amount_paid, import_excel.status, import_excel.payment_due_date, invoice_payment.mystatus, import_excel.payee_ref_no, import_excel.transaction_ref, users.address'))->distinct()
                    ->join('import_excel', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')
                    ->join('users', 'invoice_payment.email', '=', 'users.email')
                    ->where('import_excel.uploaded_by', $req->client_id)
                    ->orderBy('invoice_payment.created_at', 'DESC')->get();
            } else {
                $getClient = DB::table('invoice_payment')
                    ->select(DB::raw('invoice_payment.transactionid, invoice_payment.name, invoice_payment.email, import_excel.amount as invoice_amount, invoice_payment.invoice_no, invoice_payment.service, invoice_payment.created_at as transaction_date, import_excel.description as description, invoice_payment.remaining_balance as runningbalance, invoice_payment.opening_balance, invoice_payment.amount as amount_paid, import_excel.status, import_excel.payment_due_date, invoice_payment.mystatus, import_excel.payee_ref_no, import_excel.transaction_ref'))->distinct()
                    ->join('import_excel', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')
                    ->where('import_excel.uploaded_by', $req->client_id)
                    ->where('invoice_payment.service', $req->service)->whereBetween('invoice_payment.created_at', [$from, $nextDay])
                    ->orderBy('invoice_payment.created_at', 'DESC')->get();
            }

            $withdraw_id = PaycaWithdraw::where('client_id', $req->client_id)->get();

            if (count($withdraw_id) > 0) {
                $withID = $withdraw_id[0]->withdraw_id;
            } else {
                $withID = 0;
            }


            $transaction_cost = TransactionCost::all();

            if (count($transaction_cost) > 0) {
                $fixed = $transaction_cost[0]->fixed;
                $variable = $transaction_cost[0]->variable;
            } else {
                $fixed = 0;
                $variable = 0;
            }


            if (count($getClient) > 0) {
                $resData = ['res' => 'Retrieval...', 'message' => 'success', 'title' => 'Great', 'data' => json_encode($getClient), 'action' => 'comission', 'withdraw_id' => $withID, 'fixed' => $fixed, 'variable' => $variable];
            } else {
                $resData = ['res' => 'Record not found', 'message' => 'error', 'title' => 'Oops!'];
            }
        } elseif ($req->val == "epayca") {

            if ($req->service == "All") {
                // Update Information
                $getClient = DB::table('users')
                    ->join('organization_pay', 'organization_pay.user_id', '=', 'users.email')
                    ->join('epaywithdraw', 'epaywithdraw.client_id', '=', 'organization_pay.coy_id')
                    ->where('organization_pay.coy_id', $req->client_id)->whereBetween('organization_pay.created_at', [$from, $nextDay])
                    ->orderBy('organization_pay.created_at', 'DESC')
                    ->get();
            } else {
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

            if (count($withdraw_id) > 0) {
                $withID = $withdraw_id[0]->withdraw_id;
            } else {
                $withID = 0;
            }



            $transaction_cost = TransactionCost::all();

            if (count($transaction_cost) > 0) {
                $fixed = $transaction_cost[0]->fixed;
                $variable = $transaction_cost[0]->variable;
            } else {
                $fixed = 0;
                $variable = 0;
            }


            // dd($req->user_id);
            if (count($getClient) > 0) {

                $resData = ['res' => 'Retrieval...', 'message' => 'success', 'title' => 'Great', 'data' => json_encode($getClient), 'action' => 'epayca', 'withdraw_id' => $withID, 'fixed' => $fixed, 'variable' => $variable];
            } else {
                $resData = ['res' => 'Record not found', 'message' => 'error', 'title' => 'Oops!'];
            }
        }



        return $this->returnJSON($resData, 200);
    }


    public function ajaxremitCash(Request $req)
    {

        if ($req->val == "epayca") {

            // Update Information
            $getClient = Epaywithdraw::where('withdraw_id', $req->withdraw_id)->get();
            if (count($getClient) > 0) {

                $updt = Epaywithdraw::where('client_email', $getClient[0]->client_email)->update(['remittance' => 1, 'amount_paid' => $req->amount]);

                $this->saveCollectionfee($req->withdraw_id, date('Y-m-d'), $getClient[0]->client_name, $getClient[0]->client_email, $getClient[0]->amount_to_withdraw, $req->amount, $req->amount, $getClient[0]->created_at, date('Y-m-d H:i:s'), 'epayca');


                Epaywithdraw::where('client_email', $getClient[0]->client_email)->update(['amount_to_withdraw' => 0]);


                if ($updt == 1) {

                    // Send Mail
                    $this->name = $getClient[0]->client_name;
                    $this->email = $getClient[0]->client_email;
                    $this->info = "Fund remittance";
                    $this->subject = "Fund successfully processed";

                    $this->message = 'The fund withdrawal request has been successfully processed and fund transferred to ' . $getClient[0]->card_method;

                    $this->sendEmail($this->email, "Fund remittance");
                    $resData = ['res' => 'Cash remitted successfully', 'message' => 'success', 'title' => 'Great'];
                } else {
                    $resData = ['res' => 'Something went wrong', 'message' => 'error', 'title' => 'Oops!'];
                }
            } else {
                $resData = ['res' => 'Record not found', 'message' => 'error', 'title' => 'Oops!'];
            }
        } elseif ($req->val == "payca") {
            // Update Information
            $getClient = PaycaWithdraw::where('withdraw_id', $req->withdraw_id)->get();
            if (count($getClient) > 0) {



                $updt = PaycaWithdraw::where('client_email', $getClient[0]->client_email)->update(['remittance' => 1, 'amount_paid' => $req->amount]);



                $this->saveCollectionfee($req->withdraw_id, date('Y-m-d'), $getClient[0]->client_name, $getClient[0]->client_email, $getClient[0]->amount_to_withdraw, $req->amount, $req->amount, $getClient[0]->created_at, date('Y-m-d H:i:s'), 'payca');

                PaycaWithdraw::where('client_email', $getClient[0]->client_email)->update(['amount_to_withdraw' => 0]);

                // Update invoice_payment
                InvoicePayment::where('client_id', $getClient[0]->client_id)->update(['withdraws' => 0]);

                if ($updt == 2) {
                    // Send Mail
                    $this->name = $getClient[0]->client_name;
                    $this->email = $getClient[0]->client_email;
                    $this->info = "Fund remittance";
                    $this->subject = "Fund successfully processed";

                    $this->message = 'The fund withdrawal request has been successfully processed and fund transferred to ' . $getClient[0]->card_method;

                    $this->sendEmail($this->email, "Fund remittance");
                    $resData = ['res' => 'Cash remitted successfully', 'message' => 'success', 'title' => 'Great'];
                } else {
                    $resData = ['res' => 'Something went wrong', 'message' => 'error', 'title' => 'Oops!'];
                }
            } else {
                $resData = ['res' => 'Record not found', 'message' => 'error', 'title' => 'Oops!'];
            }
        }




        return $this->returnJSON($resData, 200);
    }


    public function ajaxcheckfeeReport(Request $req)
    {

        $from = $req->start_date;
        $nextDay = $req->end_date;

        if ($req->platform == "all") {
            $getreport = CollectionFee::where('client_email', $req->client_email)
                ->whereBetween('end_date', [$from, $nextDay])
                ->orderBy('created_at', 'DESC')->get();
        } elseif ($req->platform == "payca") {
            $getreport = CollectionFee::where('client_email', $req->client_email)
                ->where('platform', 'payca')
                ->whereBetween('end_date', [$from, $nextDay])
                ->orderBy('created_at', 'DESC')->get();
        } elseif ($req->platform == "epayca") {
            $getreport = CollectionFee::where('client_email', $req->client_email)
                ->where('platform', 'epayca')
                ->whereBetween('end_date', [$from, $nextDay])
                ->orderBy('created_at', 'DESC')->get();
        }

        $transaction_cost = TransactionCost::all();

        if (count($transaction_cost) > 0) {
            $fixed = $transaction_cost[0]->fixed;
            $variable = $transaction_cost[0]->variable;
        } else {
            $fixed = 0;
            $variable = 0;
        }



        if (count($getreport)) {
            $resData = ['res' => 'Fetching Data', 'message' => 'success', 'data' => json_encode($getreport), 'title' => 'Good', 'start_date' => $req->start_date, 'end_date' => $req->end_date, 'fixed' => $fixed, 'variable' => $variable];
        } else {
            $resData = ['res' => 'No record found', 'message' => 'info', 'title' => 'Oops!'];
        }

        return $this->returnJSON($resData, 200);
    }



    public function ajaxsetupTrans(Request $req)
    {

        // Update or Create
        $setup = TransactionCost::updateOrCreate([
            'id' => 1,
        ], [
            'variable' => $req->variable,
            'fixed' => $req->fixed
        ]);

        if ($setup) {
            $resData = ['res' => 'Saved', 'message' => 'success', 'title' => 'Great'];
        } else {
            $resData = ['res' => 'Something went wrong', 'message' => 'error', 'title' => 'Oops!'];
        }

        return $this->returnJSON($resData, 200);
    }

    public function ajaxinvoiceVisit(Request $req)
    {
        if ($req->val == "delete") {
            $getInv = ImportExcel::where('id', $req->id)->get();

            if (count($getInv) > 0) {
                // Delete
                ImportExcel::where('id', $req->id)->delete();

                $resData = ['res' => 'Deleted!', 'message' => 'success', 'title' => 'Great'];
            } else {
                $resData = ['res' => 'Something went wrong', 'message' => 'error', 'title' => 'Oops!'];
            }
        }

        return $this->returnJSON($resData, 200);
    }


    public function ajaxinvoicelinkVisit(Request $req)
    {
        if ($req->val == "delete") {
            $getInv = ImportExcelLink::where('id', $req->id)->get();

            if (count($getInv) > 0) {
                // Delete
                ImportExcelLink::where('id', $req->id)->delete();

                $resData = ['res' => 'Deleted!', 'message' => 'success', 'title' => 'Great'];
            } else {
                $resData = ['res' => 'Something went wrong', 'message' => 'error', 'title' => 'Oops!'];
            }
        }

        return $this->returnJSON($resData, 200);
    }

    public function ajaxconfirmpayment(Request $req)
    {


        // Get Transaction
        $getTrans = OrganizationPay::where('transactionid', $req->transactionid)->get();

        if (count($getTrans) > 0) {
            $sender = User::where('email', $req->user_id)->get();
            $receiver = User::where('ref_code', $req->coy_id)->get();

            // Update Record
            OrganizationPay::where('transactionid', $req->transactionid)->update(['state' => 0, 'request_receive' => 2]);




            // Senders statement
            $this->insStatement($req->user_id, $req->transactionid, "Payment to " . $receiver[0]->name . " on " . $getTrans[0]->purpose, 0, $getTrans[0]->amount_to_send, 0, date('Y-m-d', strtotime($getTrans[0]->created_at)), "Processed", "Payment", $sender[0]->ref_code, 0, $sender[0]->country);

            // Admin Charge on Receiver

            $this->insStatement($receiver[0]->email, $req->transactionid, "Admin charge of $" . $getTrans[0]->commission, 0, $getTrans[0]->commission, 0, date('Y-m-d'), "Processed", "Payment", $req->coy_id, 0, $receiver[0]->country);


            // Receiver Statement for remaining amount
            $rem = $getTrans[0]->amount_to_send;

            $this->insStatement($receiver[0]->email, $req->transactionid, "Received Payment for " . $getTrans[0]->purpose . " from " . $sender[0]->name, $rem, 0, 0, date('Y-m-d'), "Processed", "Invoice", $req->coy_id, 0, $receiver[0]->country);


            // Send Mail to Receiver
            $this->name = $receiver[0]->name;
            $this->email = $receiver[0]->email;
            // $this->email = "bambo@vimfile.com";
            $this->info = "Fund remittance";
            $this->subject = "You have received a payment on PaySprint";

            $this->message = "You have received a payment on PaySprint via send money. <br> Payment made by " . $sender[0]->name . " for the purpose of " . $getTrans[0]->purpose . ". <br><br> Below is the transaction details; <br><br> Amount sent: " . number_format($getTrans[0]->amount_to_send, 2) . " <br><br> Admin Charge: " . $getTrans[0]->commission . " <br><br> Amount received: " . number_format($rem, 2) . " <br><br> Thanks <br> PaySprint Team";



            $this->sendEmail($this->email, "Fund remittance");

            $resData = ['res' => 'Payment Confirmed', 'message' => 'success', 'title' => 'Great'];
        } else {
            $resData = ['res' => 'Transaction not found', 'message' => 'error', 'title' => 'Oops!'];
        }

        return $this->returnJSON($resData, 200);
    }


    public function ajaxapproveUser(Request $req, User $user)
    {

        $data = $user->where('id', $req->id)->first();

        if ($data->approval == 2 && $data->account_check == 2) {

            $user->where('id', $req->id)->update(['approval' => 0, 'accountLevel' => 0, 'disableAccount' => 'on', 'plan' => 'basic']);

            $subject = 'Account information not approved';
            $message = "This is to inform you that your account information does not match the requirement for review. You will not be able to login or conduct any transaction both on the mobile app and on the web during this period. Kindly attach a copy of your Utility bill and send to compliance@paysprint.ca . We shall inform you when your PaySprint account is available for use. We regret any inconvenience this action might cause you. If you have any concern, please send us a message on : compliance@paysprint.ca";

            $query = [
                'user_id' => session('user_id'),
                'name' => session('firstname') . ' ' . session('lastname'),
                'activity' => 'User account ' . strtoupper($data->name) . ' not approved today: ' . date('d-M-Y h:i:a'),
            ];

            $this->createSupportActivity($query);

            $resData = ['res' => 'Account information disapproved', 'message' => 'success', 'title' => 'Great'];
        } elseif ($data->approval >= 1 && $data->account_check <= 1) {

            $user->where('id', $req->id)->update(['approval' => 2, 'accountLevel' => 3, 'disableAccount' => 'off', 'account_check' => 2, 'plan' => 'classic']);

            if ($data->accountType == 'Individual') {
                $subType = 'Consumer Monthly Subscription';
            } else {
                $subType = 'Merchant Monthly Subscription';
            }

            $getSub = TransactionCost::where('country', $data->country)->where('structure', $subType)->first();

            $startdate = date('Y-m-d');
            $enddate = date('Y-m-d', strtotime($startdate . ' + 30 days'));

            TrialDate::create([
                'user_id' => $req->id,
                'trial_start' => $startdate,
                'trial_end' =>  $enddate
            ]);

            $expire_date = Carbon::now()->addMonth()->toDateTimeString();

            $amount = $getSub->fixed;

            UpgradePlan::updateOrInsert(['userId' => $data->ref_code], ['userId' => $data->ref_code, 'plan' => 'classic', 'amount' => $amount, 'duration' => "monthly", 'expire_date' => $expire_date]);


            $subject = 'Account information approved';

            $message = "Your PaySprint account has been fully-enabled. You now have access to all the features on PaySprint both on the Mobile and Web platforms. Thank you for your interest in PaySprint. Compliance@paysprint.ca";

            $query = [
                'user_id' => session('user_id'),
                'name' => session('firstname') . ' ' . session('lastname'),
                'activity' => 'Approved ' . strtoupper($data->name) . ' account to level 3 today: ' . date('d-M-Y h:i:a'),
            ];

            $this->createSupportActivity($query);


            // Send Mail to Receiver
            $this->name = $data->name;
            $this->to = $data->email;

            $this->subject = $subject;
            $this->message = $message;

            $usersPhone = User::where('email', $data->email)->where('telephone', 'LIKE', '%+%')->first();

            if (isset($usersPhone)) {

                $recipients = $data->telephone;
            } else {
                $recipients = "+" . $data->code . $data->telephone;
            }

            $this->createNotification($data->ref_code, $message);

            if ($data->country == "Nigeria") {

                $correctPhone = preg_replace("/[^0-9]/", "", $recipients);

                $this->sendSms($message, $correctPhone);
            } else {
                $this->sendMessage($message, $recipients);
            }


            $this->sendEmail($this->to, "Refund Request");

            $resData = ['res' => 'Account information approved', 'message' => 'success', 'title' => 'Great'];
        } else {
            $user->where('id', $req->id)->update(['approval' => 1, 'accountLevel' => 2, 'disableAccount' => 'off', 'plan' => 'basic']);

            $subject = 'Account information approved';

            $message = "Thanks for opening a Paysprint account. Your  account is still under review; however, its already activated for your use. The account activation enables you to: \na. Add money/funds to your wallet on PaySprint\nb. Receive money/funds from other PS users\nc. Create and Send Invoice (if you are a merchant)\nd. Pay Invoice from your wallet\ne. Pay Utility Bills at discounted price from your wallet\nHowever, you will not be able to Send money or Withdrawal funds from your wallet until the review process is completed. In order to fast-track the review process, kindly upload the following documents if you are yet to do so: \na. Government Issued Photo ID like Driver Licence etc.\nb. A copy of the utility bill or bank statement to confirm your residential address\nc. Complete the BVN verification under your profile on the web app (if applicable).\nThanks for choosing PaySprint\nCompliance Team @ PaySprint";

            $query = [
                'user_id' => session('user_id'),
                'name' => session('firstname') . ' ' . session('lastname'),
                'activity' => 'Approved ' . strtoupper($data->name) . ' account to level 2 today: ' . date('d-M-Y h:i:a'),
            ];
            $startdate = date('Y-m-d');
            $enddate = date('Y-m-d', strtotime($startdate . ' + 30 days'));

            TrialDate::create([
                'user_id' => $req->id,
                'trial_start' => $startdate,
                'trial_end' =>  $enddate
            ]);

            $this->createSupportActivity($query);

            $resData = ['res' => 'Account information approved', 'message' => 'success', 'title' => 'Great'];
        }



        return $this->returnJSON($resData, 200);
    }


    public function ajaxdisapproveUser(Request $req, User $user)
    {

        $data = $user->where('id', $req->id)->first();


        $user->where('id', $req->id)->update(['approval' => 0, 'accountLevel' => 0, 'disableAccount' => 'on']);

        $subject = 'Account information not approved';
        $message = "This is to inform you that your account information does not match the requirement for review. You will not be able to conduct any transaction both on the mobile app and on the web during this period. Kindly attach a copy of your Utility bill and send to compliance@paysprint.ca . We shall inform you when your PaySprint account is available for use. We regret any inconvenience this action might cause you. If you have any concern, please send us a message on : compliance@paysprint.ca";


        // Send Mail to Receiver
        $this->name = $data->name;
        $this->to = $data->email;

        $this->subject = $subject;
        $this->message = $message;

        $usersPhone = User::where('email', $data->email)->where('telephone', 'LIKE', '%+%')->first();

        if (isset($usersPhone)) {

            $recipients = $data->telephone;
        } else {
            $recipients = "+" . $data->code . $data->telephone;
        }

        $this->createNotification($data->ref_code, $message);


        if ($data->country == "Nigeria") {

            $correctPhone = preg_replace("/[^0-9]/", "", $recipients);

            $this->sendSms($message, $correctPhone);
        } else {
            $this->sendMessage($message, $recipients);
        }

        $this->sendEmail($this->to, "Refund Request");

        $resData = ['res' => 'Success', 'message' => 'success', 'title' => 'Great'];


        return $this->returnJSON($resData, 200);
    }



    public function ajaxdowngradeaccount(Request $req, User $user)
    {

        $data = $user->where('id', $req->id)->first();

        if ($data->approval == 2) {

            $user->where('id', $req->id)->update(['approval' => 1, 'accountLevel' => 2]);

            $subject = 'Account information did not pass our level 1 check';
            $message = "This is to inform you that your account information did not pass the requirement for review. You're advised to complete your account setup in your profile. We regret any inconvenience this action might cause you. If you have any concern, please send us a message on : compliance@paysprint.ca";

            $resData = ['res' => 'Successful', 'message' => 'success', 'title' => 'Great'];
        } else {
            $resData = ['res' => 'Something went wrong', 'message' => 'error', 'title' => 'Oops'];
            return $this->returnJSON($resData, 200);
        }

        // Send Mail to Receiver
        $this->name = $data->name;
        $this->to = $data->email;

        $this->subject = $subject;
        $this->message = $message;

        $usersPhone = User::where('email', $data->email)->where('telephone', 'LIKE', '%+%')->first();

        if (isset($usersPhone)) {

            $recipients = $data->telephone;
        } else {
            $recipients = "+" . $data->code . $data->telephone;
        }

        $this->createNotification($data->ref_code, $message);

        if ($data->country == "Nigeria") {

            $correctPhone = preg_replace("/[^0-9]/", "", $recipients);

            $this->sendSms($message, $correctPhone);
        } else {
            $this->sendMessage($message, $recipients);
        }

        $this->sendEmail($this->to, "Refund Request");

        $query = [
            'user_id' => session('user_id'),
            'name' => session('firstname') . ' ' . session('lastname'),
            'activity' => 'Downgraded ' . strtoupper($data->name) . ' account to level 1 today: ' . date('d-M-Y h:i:a'),
        ];

        $this->createSupportActivity($query);


        return $this->returnJSON($resData, 200);
    }


    public function ajaxmoveUser(Request $req, User $user)
    {

        $data = $user->where('id', $req->id)->first();



        if ($data->country == "Nigeria") {

            $user->where('id', $req->id)->update(['approval' => 1, 'accountLevel' => 2, 'disableAccount' => 'off']);


            $subject = 'Your account is currently under review';

            $message = "Thanks for opening a Paysprint account. Kindly complete the BVN verification at www.paysprint.ca by following these steps: \na. Login to your accounts\nb. Go to Profile and select BVN Verification.\nc. Complete and submit.\nAll other features would be enabled for you immediately.\nThanks for choosing PaySprint.\nCompliance Team @ PaySprint";
        } else {

            $user->where('id', $req->id)->update(['approval' => 1, 'accountLevel' => 2, 'bvn_verification' => 1, 'disableAccount' => 'off']);

            $subject = 'Your PaySprint Account has been activated.';

            $message = "Your PaySprint Account has been activated. You will be able to add money to your wallet, Create and Send Invoice, Accept and Receive payment from all the channels, \nPay received Invoice or Utility bills, but you will not be able to send or receive money or withdraw money from your Wallet pending the verification of Government issued Photo ID and Utility bill or Bank statement uploaded.\nKindly follow these steps to upload the required information:\na. login to PaySprint Account on Mobile App or Web app at www.paysprint.ca\nb. Go to profile page and upload a copy of Goverment Issued Photo ID, a copy of Utility bill and business documents.\nAll other features would be enabled for you as soon as the Compliance Team verifies your information.\nThanks for choosing PaySprint\nCompliance Team @ PaySprint";
        }

        $resData = ['res' => 'Account under review', 'message' => 'success', 'title' => 'Great'];

        // Send Mail to Receiver
        $this->name = $data->name;
        $this->to = $data->email;

        $this->subject = $subject;
        $this->message = $message;

        $usersPhone = User::where('email', $data->email)->where('telephone', 'LIKE', '%+%')->first();

        if (isset($usersPhone)) {

            $recipients = $data->telephone;
        } else {
            $recipients = "+" . $data->code . $data->telephone;
        }

        $this->createNotification($data->ref_code, $message);

        if ($data->country == "Nigeria") {

            $correctPhone = preg_replace("/[^0-9]/", "", $recipients);

            $this->sendSms($message, $correctPhone);
        } else {
            $this->sendMessage($message, $recipients);
        }


        $query = [
            'user_id' => session('user_id'),
            'name' => session('firstname') . ' ' . session('lastname'),
            'activity' => 'Moved ' . strtoupper($data->name) . ' account to level 2 today: ' . date('d-M-Y h:i:a'),
        ];

        $this->createSupportActivity($query);


        return $this->returnJSON($resData, 200);
    }


    // Export to Excel
    public function exportStatementToExcel(Request $req)
    {

        $query = [
            'user_id' => $req->user_id,
            'from' => $req->start_date,
            'nextDay' => $req->end_date,
        ];


        $transExport = new WalletStatementExport($query);

        if ($req->type == "excel") {

            return Excel::download($transExport, mt_rand() . date('dmYhis') . '.xlsx');
        } else {

            return Excel::download($transExport, mt_rand() . date('dmYhis') . '.pdf');
        }
    }


    public function ajaxmoveSelectedUser(Request $req, User $user)
    {



        $data = $user->where('id', $req->id)->first();



        if ($data->country == "Nigeria") {

            $user->where('id', $req->id)->update(['approval' => 1, 'accountLevel' => 2, 'disableAccount' => 'off']);


            $subject = 'Your account is currently under review';

            $message = "Thanks for opening a Paysprint account. Kindly complete the BVN verification at www.paysprint.ca by following these steps: \na. Login to your accounts\nb. Go to Profile and select BVN Verification.\nc. Complete and submit.\nAll other features would be enabled for you immediately.\nThanks for choosing PaySprint.\nCompliance Team @ PaySprint";
        } else {

            $user->where('id', $req->id)->update(['approval' => 1, 'accountLevel' => 2, 'bvn_verification' => 1, 'disableAccount' => 'off']);

            $subject = 'Your PaySprint Account has been activated.';

            $message = "Your PaySprint Account has been activated. You will be able to add money to your wallet, Create and Send Invoice, Accept and Receive payment from all the channels, \nPay received Invoice or Utility bills, but you will not be able to send or receive money or withdraw money from your Wallet pending the verification of Government issued Photo ID and Utility bill or Bank statement uploaded.\nKindly follow these steps to upload the required information:\na. login to PaySprint Account on Mobile App or Web app at www.paysprint.ca\nb. Go to profile page and upload a copy of Goverment Issued Photo ID, a copy of Utility bill and business documents.\nAll other features would be enabled for you as soon as the Compliance Team verifies your information.\nThanks for choosing PaySprint\nCompliance Team @ PaySprint";
        }



        $resData = ['res' => 'Account under review', 'message' => 'success', 'title' => 'Great'];

        // Send Mail to Receiver
        $this->name = $data->name;
        $this->to = $data->email;

        $this->subject = $subject;
        $this->message = $message;

        $usersPhone = User::where('email', $data->email)->where('telephone', 'LIKE', '%+%')->first();

        if (isset($usersPhone)) {

            $recipients = $data->telephone;
        } else {
            $recipients = "+" . $data->code . $data->telephone;
        }

        $this->createNotification($data->ref_code, $message);

        if ($data->country == "Nigeria") {

            $correctPhone = preg_replace("/[^0-9]/", "", $recipients);

            $this->sendSms($message, $correctPhone);
        } else {
            $this->sendMessage($message, $recipients);
        }


        $query = [
            'user_id' => session('user_id'),
            'name' => session('firstname') . ' ' . session('lastname'),
            'activity' => 'Moved ' . strtoupper($data->name) . ' account to level 2 today: ' . date('d-M-Y h:i:a'),
        ];



        return $this->returnJSON($resData, 200);
    }

    public function ajaxCloseUserAccount(Request $req, User $user, UserClosed $userclosed)
    {

        $data = $user->where('id', $req->id)->first();

        if (isset($data)) {

            $dataInfo = [
                'user_id' => $data->id, '_token' => $data->_token, 'code' => $data->code, 'ref_code' => $data->ref_code, 'avatar' => $data->avatar, 'businessname' => $data->businessname, 'name' => $data->name, 'email' => $data->email, 'password' => $data->password, 'address' => $data->address, 'telephone' => $data->telephone, 'city' => $data->city, 'state' => $data->state, 'country' => $data->country, 'dayOfBirth' => $data->dayOfBirth, 'monthOfBirth' => $data->monthOfBirth, 'yearOfBirth' => $data->yearOfBirth, 'currencyCode' => $data->currencyCode, 'currencySymbol' => $data->currencySymbol, 'accountType' => $data->accountType, 'corporationType' => $data->corporationType, 'zip' => $data->zip, 'card_balance' => $data->card_balance, 'nin_front' => $data->nin_front, 'drivers_license_front' => $data->drivers_license_front, 'international_passport_front' => $data->international_passport_front, 'nin_back' => $data->nin_back, 'drivers_license_back' => $data->drivers_license_back, 'international_passport_back' => $data->international_passport_back, 'incorporation_doc_front' => $data->incorporation_doc_front, 'incorporation_doc_back' => $data->incorporation_doc_back, 'wallet_balance' => $data->wallet_balance, 'number_of_withdrawals' => $data->number_of_withdrawals, 'transaction_pin' => $data->transaction_pin, 'securityQuestion' => $data->securityQuestion, 'securityAnswer' => $data->securityAnswer, 'api_token' => $data->api_token, 'flagged' => $data->flagged, 'approval' => $data->approval, 'auto_deposit' => $data->auto_deposit, 'accountLevel' => $data->accountLevel, 'loginCount' => $data->loginCount, 'lastLogin' => $data->lastLogin, 'disableAccount' => $data->disableAccount, 'cardRequest' => $data->cardRequest, 'countryapproval' => $data->countryapproval, 'platform' => $data->platform, 'remember_token' => $data->remember_token
            ];

            $userclosed->insert($dataInfo);

            $user->where('id', $req->id)->delete();

            $thisuser = $userclosed->where('user_id', $req->id)->first();

            $subject = 'Account currently closed on PaySprint';
            $message = "This is to inform you that your account is currently closed on PaySprint. You will not be able to login or conduct any transaction both on the mobile app and on the web during this period. Kindly attach a copy of your Utility bill and send to compliance@paysprint.ca . We regret any inconvenience this action might caused you. If you have any concern, please send us a message on : compliance@paysprint.ca";

            // Send Mail to Receiver
            $this->name = $thisuser->name;
            $this->to = $thisuser->email;

            $this->subject = $subject;
            $this->message = $message;

            $usersPhone = UserClosed::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

            if (isset($usersPhone)) {

                $recipients = $thisuser->telephone;
            } else {
                $recipients = "+" . $thisuser->code . $thisuser->telephone;
            }

            $this->createNotification($thisuser->ref_code, $message);

            // if ($thisuser->country == "Nigeria") {

            //     $correctPhone = preg_replace("/[^0-9]/", "", $recipients);

            //     $this->sendSms($message, $correctPhone);
            // } else {
            //     $this->sendMessage($message, $recipients);
            // }

            $this->sendEmail($this->to, "Refund Request");

            $query = [
                'user_id' => session('user_id'),
                'name' => session('firstname') . ' ' . session('lastname'),
                'activity' => 'Closed ' . strtoupper($thisuser->name) . ' account today: ' . date('d-M-Y h:i:a'),
            ];

            $this->createSupportActivity($query);

            $resData = ['res' => 'Account is closed', 'message' => 'success', 'title' => 'Great'];
        } else {

            $resData = ['res' => 'Account information not found', 'message' => 'success', 'title' => 'Great'];
        }



        return $this->returnJSON($resData, 200);
    }


    public function ajaxOpenUserAccount(Request $req, User $user, UserClosed $userclosed)
    {

        $data = $userclosed->where('id', $req->id)->first();

        if (isset($data)) {

            $dataInfo = [
                'id' => $data->user_id, '_token' => $data->_token, 'code' => $data->code, 'ref_code' => $data->ref_code, 'avatar' => $data->avatar, 'businessname' => $data->businessname, 'name' => $data->name, 'email' => $data->email, 'password' => $data->password, 'address' => $data->address, 'telephone' => $data->telephone, 'city' => $data->city, 'state' => $data->state, 'country' => $data->country, 'dayOfBirth' => $data->dayOfBirth, 'monthOfBirth' => $data->monthOfBirth, 'yearOfBirth' => $data->yearOfBirth, 'currencyCode' => $data->currencyCode, 'currencySymbol' => $data->currencySymbol, 'accountType' => $data->accountType, 'corporationType' => $data->corporationType, 'zip' => $data->zip, 'card_balance' => $data->card_balance, 'nin_front' => $data->nin_front, 'drivers_license_front' => $data->drivers_license_front, 'international_passport_front' => $data->international_passport_front, 'nin_back' => $data->nin_back, 'drivers_license_back' => $data->drivers_license_back, 'international_passport_back' => $data->international_passport_back, 'incorporation_doc_front' => $data->incorporation_doc_front, 'incorporation_doc_back' => $data->incorporation_doc_back, 'wallet_balance' => $data->wallet_balance, 'number_of_withdrawals' => $data->number_of_withdrawals, 'transaction_pin' => $data->transaction_pin, 'securityQuestion' => $data->securityQuestion, 'securityAnswer' => $data->securityAnswer, 'api_token' => $data->api_token, 'flagged' => $data->flagged, 'approval' => $data->approval, 'auto_deposit' => $data->auto_deposit, 'accountLevel' => $data->accountLevel, 'loginCount' => $data->loginCount, 'lastLogin' => $data->lastLogin, 'disableAccount' => $data->disableAccount, 'cardRequest' => $data->cardRequest, 'countryapproval' => $data->countryapproval, 'platform' => $data->platform, 'remember_token' => $data->remember_token
            ];

            $user->insert($dataInfo);

            $thisuser = $userclosed->where('id', $req->id)->first();



            $subject = 'Account successfully Open on PaySprint';
            $message = "We are glad to notify you that your paySprint Account is back to action. Your PaySprint account has been enabled and you will be able to Send Money, Pay Invoice and Request for withdrawal of funds from your PaySprint Wallet from  the Mobile and Web platforms. Thank you for your interest in PaySprint. compliance@paysprint.ca";


            // Send Mail to Receiver
            $this->name = $thisuser->name;
            $this->to = $thisuser->email;

            $this->subject = $subject;
            $this->message = $message;

            $usersPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

            if (isset($usersPhone)) {

                $recipients = $thisuser->telephone;
            } else {
                $recipients = "+" . $thisuser->code . $thisuser->telephone;
            }

            $this->createNotification($thisuser->ref_code, $message);
            // if ($thisuser->country == "Nigeria") {

            //     $correctPhone = preg_replace("/[^0-9]/", "", $recipients);

            //     $this->sendSms($message, $correctPhone);
            // } else {
            //     $this->sendMessage($message, $recipients);
            // }


            $this->sendEmail($this->to, "Refund Request");

            $userclosed->where('id', $req->id)->delete();


            $resData = ['res' => 'Account is open', 'message' => 'success', 'title' => 'Great'];
        } else {

            $resData = ['res' => 'Account information not found', 'message' => 'success', 'title' => 'Great'];
        }



        return $this->returnJSON($resData, 200);
    }


    public function ajaxCheckVerification(Request $req, User $user)
    {

        $data = $user->where('id', $req->id)->update(['accountLevel' => 2]);
        $successmessage = "success";
        $title = "Great";

        $user = $user->where('id', $req->id)->first();

        $subject = 'Level 1 Account Approval';

        if ($user->country == "Nigeria") {

            $message = "Thanks for opening a Paysprint account. Kindly complete the BVN verification at www.paysprint.ca by following these steps: \na. Login to your accounts\nb. Go to Profile and select BVN Verification.\nc. Complete and submit.\nAll other features would be enabled for you immediately.\nThanks for choosing PaySprint.\nCompliance Team @ PaySprint";
        } else {

            $message = "Your PaySprint Account has been activated. You will be able to add money to your wallet, Create and Send Invoice, Accept and Receive payment from all the channels, \nPay received Invoice or Utility bills, but you will not be able to send or receive money or withdraw money from your Wallet pending the verification of Government issued Photo ID and Utility bill or Bank statement uploaded.\nKindly follow these steps to upload the required information:\na. login to PaySprint Account on Mobile App or Web app at www.paysprint.ca\nb. Go to profile page and upload a copy of Goverment Issued Photo ID, a copy of Utility bill and business documents.\nAll other features would be enabled for you as soon as the Compliance Team verifies your information.\nThanks for choosing PaySprint\nCompliance Team @ PaySprint";
        }



        // Send Mail to Receiver
        $this->name = $user->name;
        $this->to = $user->email;

        $this->subject = $subject;
        $this->message = $message;


        $usersPhone = User::where('email', $user->email)->where('telephone', 'LIKE', '%+%')->first();

        if (isset($usersPhone)) {

            $recipients = $user->telephone;
        } else {
            $recipients = "+" . $user->code . $user->telephone;
        }



        $this->createNotification($user->ref_code, $message);
        if ($user->country == "Nigeria") {

            $correctPhone = preg_replace("/[^0-9]/", "", $recipients);

            $this->sendSms($message, $correctPhone);
        } else {
            $this->sendMessage($message, $recipients);
        }

        $this->sendEmail($this->to, "Refund Request");

        $resData = ['res' => 'Successfully updated!', 'message' => $successmessage, 'title' => $title];

        return $this->returnJSON($resData, 200);
    }


    public function ajaxpayBankWithdrawal(Request $req, BankWithdrawal $withdrawal, User $user, AddBank $bank)
    {

        $data = $withdrawal->where('id', $req->id)->first();

        $withdrawal->where('id', $req->id)->update(['status' => 'PROCESSED']);

        // Send Mail
        $thisuser = $user->where('ref_code', $data->ref_code)->first();
        $thisbank = $bank->where('id', $data->bank_id)->first();

        $this->name = $thisuser->name;
        $this->to = $thisuser->email;
        $this->subject = "Request for Funds Withdrawal has been Processed";

        $this->info = "Account is credited";
        $this->message = 'We are glad to notify you that the request for withdrawal to your bank account ending with ' . $thisbank->accountNumber . ' has been processed. The sum of ' . $thisuser->currencySymbol . '' . number_format($data->amountToSend, 2) . ' would be credited to your bank ' . $thisbank->bankName . ' within the next 5 business days. Thanks from PaySprint Support Team';

        $usersPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

        if (isset($usersPhone)) {

            $recipients = $thisuser->telephone;
        } else {
            $recipients = "+" . $thisuser->code . $thisuser->telephone;
        }

        $this->createNotification($thisuser->ref_code, "Hello " . strtoupper($thisuser->name) . ", " . $this->message);

        if ($thisuser->country == "Nigeria") {

            $correctPhone = preg_replace("/[^0-9]/", "", $recipients);
            $this->sendSms("Hello " . strtoupper($thisuser->name) . ", " . $this->message, $correctPhone);
        } else {
            $this->sendMessage("Hello " . strtoupper($thisuser->name) . ", " . $this->message, $recipients);
        }



        $this->sendEmail($this->to, "Account is credited");

        $resData = ['res' => 'Successfully Processed', 'message' => 'success', 'title' => 'Great'];


        return $this->returnJSON($resData, 200);
    }

    public function ajaxpayMobileMoneyWithdrawal(Request $req, $id)
    {

        $data = BankWithdrawal::where('id', $req->id)->first();
        $userdetails = User::where('ref_code', $data->ref_code)->first();
        $mobiledetails = MobileMoney::where('id', $userdetails->id)->first();
        $currency = $userdetails->currencyCode;
        $amount = (float)$data->amountToSend;

        $provider = $mobiledetails->provider;
        $accountnumber = $mobiledetails->account_number;
        $accountname = $userdetails->name;
        $reference = $data->transaction_id;

        //hitting dusuPay Endpoint for withdrawal
        $payment = $this->mobileMoneyWithdrawal($currency, $amount, $provider, $accountnumber, $accountname, $reference, $userdetails->id);


        $status = $payment->status;

        if ($status == 'accepted') {
            BankWithdrawal::where('id', $req->id)->update(['status' => 'PROCESSED']);
            $paysprintdetails = BankWithdrawal::where('transaction_id', $payment->data->merchant_reference)->first();
            $paysprintuser = User::where('ref_code', $paysprintdetails->ref_code)->first();
            DusupaymentReferences::create([
                'user_id' => $paysprintuser->id,
                'dusu_id' => $payment->data->id,
                'request_amount' => $payment->data->request_amount,
                'request_currency' => $payment->data->request_currency,
                'account_amount' => $payment->data->account_amount,
                'account_currency' => $payment->data->account_currency,
                'transaction_fee' => $payment->data->transaction_fee,
                'total_debit' => $payment->data->total_debit,
                'provider_id' => $payment->data->provider_id,
                'paysprint_reference' => $payment->data->merchant_reference,
                'Dusupay_reference' => $payment->data->internal_reference,
                'transaction_status' => $payment->data->transaction_status,
                'transaction_type' => $payment->data->transaction_type
            ]);

            // Send Mail
            $thisuser = User::where('ref_code', $data->ref_code)->first();
            // $thisbank = $bank->where('id', $data->bank_id)->first();

            $this->name = $thisuser->name;
            $this->to = $thisuser->email;
            $this->subject = "Request for Funds Withdrawal has been Processed";

            $this->info = "Account is credited";
            $this->message = 'We are glad to notify you that the request for withdrawal to your mobile money ' . $accountnumber . ' has been processed. The sum of ' . $thisuser->currencySymbol . '' . number_format($data->amountToSend, 2) . ' would be credited to your mobile money ' . $data->bank_id . ' within the next 24hrs. Thanks from PaySprint Support Team';

            $usersPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

            if (isset($usersPhone)) {

                $recipients = $thisuser->telephone;
            } else {
                $recipients = "+" . $thisuser->code . $thisuser->telephone;
            }

            $this->createNotification($thisuser->ref_code, "Hello " . strtoupper($thisuser->name) . ", " . $this->message);

            if ($thisuser->country == "Nigeria") {

                $correctPhone = preg_replace("/[^0-9]/", "", $recipients);
                $this->sendSms("Hello " . strtoupper($thisuser->name) . ", " . $this->message, $correctPhone);
            } else {
                $this->sendMessage("Hello " . strtoupper($thisuser->name) . ", " . $this->message, $recipients);
            }



            $this->sendEmail($this->to, "Account is credited");

            $resData = 'Successfully Processed';


            return back()->with("msg", "<div class='alert alert-success'>$resData</div>");
        } else {
            $message = $payment->message;

            return back()->with("msg", "<div class='alert alert-danger'>$message</div>");
        }
    }

    public function ajaxpayCardWithdrawal(Request $req, CcWithdrawal $withdrawal, User $user, AddCard $card)
    {

        $data = $withdrawal->where('id', $req->id)->first();

        $withdrawal->where('id', $req->id)->update(['status' => 'PROCESSED']);

        // Send Mail
        $thisuser = $user->where('ref_code', $data->ref_code)->first();
        $thiscard = $card->where('card_number', $data->card_number)->first();

        $this->name = $thisuser->name;
        $this->to = $thisuser->email;

        $cardNo = str_repeat("*", strlen($thiscard->card_number) - 4) . substr($thiscard->card_number, -4);


        $this->subject = "Account is credited";
        $this->info = "Account is credited";
        $this->message = 'We are glad to notify you that the request for withdrawal to your ' . $thiscard->card_type . ' ending ' . wordwrap($cardNo, 4, '-', true) . ' has been processed. The sum of ' . $thisuser->currencySymbol . '' . number_format($data->amount, 2) . ' would be credited to your bank account within the next 5 business days. Thanks from PaySprint Support Team';

        $usersPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

        if (isset($usersPhone)) {

            $recipients = $thisuser->telephone;
        } else {
            $recipients = "+" . $thisuser->code . $thisuser->telephone;
        }

        $this->createNotification($thisuser->ref_code, "Hello " . strtoupper($thisuser->name) . ", " . $this->message);

        if ($thisuser->country == "Nigeria") {

            $correctPhone = preg_replace("/[^0-9]/", "", $recipients);
            $this->sendSms("Hello " . strtoupper($thisuser->name) . ", " . $this->message, $correctPhone);
        } else {
            $this->sendMessage("Hello " . strtoupper($thisuser->name) . ", " . $this->message, $recipients);
        }


        $this->sendEmail($this->to, "Account is credited");

        $resData = ['res' => 'Successfully Processed', 'message' => 'success', 'title' => 'Great'];


        return $this->returnJSON($resData, 200);
    }



    public function ajaxflagUser(Request $req, User $user)
    {

        // Send Mail
        $thisuser = $user->where('id', $req->id)->first();

        if ($thisuser->flagged == 0) {
            $user->where('id', $req->id)->update(['flagged' => 1, 'accountLevel' => 2]);
            $subject = "Your PaySprint Account is Temporarily Suspended. Take These Steps to Resolve it!!!";
            $message = "<p>Your PaySprint Account is temporarily suspended as our system is unable to match the details on your profile with the details on the Bank Card added which
is against our Anti Money Laundering (AML) Policy.</p><p>In order to remove the temporary suspension on your account, kindly take the following steps:</p><p>a.  Delete and desist from using a Bank Card with details that are different from your PaySprint profile and Government issued photo ID</p><p>b. Send us a copy of a Utility Bill with address that matches the address on your profile. Please send the copy of utility bill to: info@paysprint.ca</p><p>c. Upload a selfie of yourself (if you are yet to do so)</p><p>Kindly login to www.paysprint.ca and upload Items B and C above when the suspension on your PaySprint Account is removed.</p><p>We thank you for your understanding</p><p>Compliance Team at paysprint.ca</p>";
        } else {
            $user->where('id', $req->id)->update(['flagged' => 0, 'accountLevel' => 3, 'flagcount' => 0]);
            $subject = "Review of PaySprint Account";
            $message = "We have completed the review of your PaySprint Account. Your PaySprint account has been enabled and you will be able to access the services both on the Mobile and Web platforms. Thank you for your patience. If you have any concern, please send us a message on : compliance@paysprint.ca";
        }




        $this->name = $thisuser->name;
        $this->to = $thisuser->email;

        $this->subject = $subject;
        $this->message = $message;

        $usersPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

        if (isset($usersPhone)) {

            $recipients = $thisuser->telephone;
        } else {
            $recipients = "+" . $thisuser->code . $thisuser->telephone;
        }

        $this->createNotification($thisuser->ref_code, "Hello " . strtoupper($thisuser->name) . ", " . $message);

        if ($thisuser->country == "Nigeria") {

            $correctPhone = preg_replace("/[^0-9]/", "", $recipients);
            $this->sendSms("Hello " . strtoupper($thisuser->name) . ", " . $message, $correctPhone);
        } else {
            $this->sendMessage("Hello " . strtoupper($thisuser->name) . ", " . $message, $recipients);
        }



        $this->sendEmail($this->to, "Flagged Account");

        $resData = ['res' => 'Successful', 'message' => 'success', 'title' => 'Great'];


        return $this->returnJSON($resData, 200);
    }



    public function ajaxRefundMoneyBackToWallet(Request $req, Statement $statement, RequestRefund $refund, User $user, AnonUsers $anonuser)
    {

        $thisrefund = $refund->where('id', $req->id)->first();

        $thisstatement = $statement->where('reference_code', $thisrefund->transaction_id)->first();
        $recstatement = $statement->where('reference_code', $thisrefund->transaction_id)->where('credit', '>', 0)->first();


        $thisuser = $user->where('email', $thisstatement->user_id)->first();
        $thisreciever = $user->where('email', $recstatement->user_id)->first();

        if (isset($thisreciever)) {
            $recuser = $thisreciever;
        } else {
            $recuser = $anonuser->where('email', $recstatement->user_id)->first();
        }

        if ($req->val == "decline") {

            $refund->where('id', $req->id)->update(['status' => 'DECLINED']);

            $subject = "Your request for refund has been declined";
            $message = "Hi " . $thisuser->name . ", Your refund request was declined. Thanks PaySprint Team";
        } else {

            // Insert Statement
            $activity = "Refund of " . $thisuser->currencyCode . " " . number_format($thisstatement->debit, 2) . " (for REASON: " . $thisrefund->reason . ") has been sent to your PaySprint Wallet.";
            $credit = $thisstatement->debit;
            $debit = 0;
            $reference_code = $thisrefund->transaction_id;
            $balance = 0;
            $trans_date = date('Y-m-d');
            $status = "Refunded";
            $action = "Wallet refund";
            $regards = $thisuser->ref_code;

            $statement_route = "wallet";


            $wallet_balance = $thisuser->wallet_balance + $thisstatement->debit;

            $wallet_balance_rec = $recuser->wallet_balance - $recstatement->credit;

            $user->where('email', $thisstatement->user_id)->update(['wallet_balance' => $wallet_balance]);

            $user->where('email', $recstatement->user_id)->update(['wallet_balance' => $wallet_balance_rec]);

            $anonuser->where('email', $recstatement->user_id)->update(['wallet_balance' => $wallet_balance_rec]);

            $statement->where('reference_code', $req->id)->update(['status' => 'Refunded', 'credit' => $credit, 'debit' => $debit]);

            $refund->where('id', $req->id)->update(['status' => 'PROCESSED']);

            $recactivity = "Refund reversal of " . $thisuser->currencyCode . " " . number_format($recstatement->credit, 2) . " (for REASON: " . $thisrefund->reason . ") has been sent to " . $thisuser->name . ".";
            $reccredit = 0;
            $recdebit = $recstatement->credit;
            $recreference_code = $thisrefund->transaction_id;
            $recbalance = 0;
            $rectrans_date = date('Y-m-d');
            $recstatus = "Reversal";
            $recaction = "Wallet reversal";
            $recregards = $recuser->ref_code;

            $recstatement_route = "wallet";

            // Senders statement
            $this->insStatementRoute($thisuser->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route, 'on', $thisuser->country);

            $this->insStatementRoute($recuser->email, $recreference_code, $recactivity, $reccredit, $recdebit, $recbalance, $rectrans_date, $recstatus, $recaction, $recregards, 1, $recstatement_route, 'on', $recuser->country);

            $subject = "Your request for refund has been processed";

            $message = "Hi " . $thisuser->name . ", A " . $activity . " Your new Wallet balance " . $thisuser->currencyCode . ' ' . number_format($wallet_balance, 2) . " balance in your account. Thanks PaySprint Team";


            $subject2 = "Refund reversal of " . $thisuser->currencyCode . ' ' . number_format($wallet_balance, 2) . " made from your wallet to " . $thisuser->name;

            $message2 = "Hi " . $recuser->name . ", A " . $recactivity . " Your new Wallet balance " . $thisuser->currencyCode . ' ' . number_format($wallet_balance_rec, 2) . " balance in your account. Thanks PaySprint Team";
        }

        // Send Mail


        $this->name = $thisuser->name;
        $this->to = $thisuser->email;

        $this->subject = $subject;
        $this->message = $message;

        $usersPhone = User::where('email', $thisuser->email)->where('telephone', 'LIKE', '%+%')->first();

        if (isset($usersPhone)) {

            $recipients = $thisuser->telephone;
        } else {
            $recipients = "+" . $thisuser->code . $thisuser->telephone;
        }

        $this->createNotification($thisuser->ref_code, $message);


        if ($thisuser->country == "Nigeria") {

            $correctPhone = preg_replace("/[^0-9]/", "", $recipients);
            $this->sendSms($message, $correctPhone);
        } else {
            $this->sendMessage($message, $recipients);
        }


        $this->sendEmail($this->to, "Refund Request");

        $this->name = $recuser->name;
        $this->to = $recuser->email;

        $this->subject = $subject2;
        $this->message = $message2;

        $users2Phone = User::where('email', $recuser->email)->where('telephone', 'LIKE', '%+%')->first();

        if (isset($users2Phone)) {

            $recipients2 = $recuser->telephone;
        } else {
            $recipients2 = "+" . $recuser->code . $recuser->telephone;
        }

        $this->createNotification($recuser->ref_code, $message);

        if ($recuser->country == "Nigeria") {

            $correctPhone = preg_replace("/[^0-9]/", "", $recipients2);
            $this->sendSms($message2, $correctPhone);
        } else {
            $this->sendMessage($message2, $recipients2);
        }



        $this->sendEmail($recuser->email, "Refund Request");

        $resData = ['res' => 'Successful', 'message' => 'success', 'title' => 'Great'];


        return $this->returnJSON($resData, 200);
    }


    public function sendStaffRefundNotification(Request $req, $reference_code)
    {
        $data = $this->actOnRefundMoney($reference_code, $req->message);

        if ($data == "Successful") {

            $resData = $data;
            $resp = "success";
        } else {

            $resData = $data;
            $resp = "error";
        }

        return redirect()->route('Admin')->with($resp, $resData);
    }


    public function returnRefundMoney(Request $req, $reference_code)
    {

        $data = $this->processRefundMoney($reference_code, $req->message);

        if ($data == "Successful") {

            // Notify User

            $this->name = $req->receiver_name;
            $this->to = $req->send_to;
            $this->subject = "Withdrawal Refund";
            $this->message = $req->message;

            $this->sendEmail($this->to, "Refund Request");

            $resData = $data;
            $resp = "success";
        } else {

            $resData = $data;
            $resp = "error";
        }


        return redirect()->route('Admin')->with($resp, $resData);
        // return back()->with($resp, $resData);
    }



    public function sendNewUserMessage(Request $req)
    {


        $user = User::where('email', $req->send_to)->first();

        if (isset($user)) {

            // Send Message

            InAppMessage::insert([
                'send_to' => $req->send_to,
                'subject' => $req->subject,
                'message' => $req->message,
            ]);

            $this->name = $user->name;
            $this->to = $user->email;

            $this->subject = $req->subject;
            $this->message = $req->message;


            $this->createNotification($user->ref_code, strip_tags($req->message));


            $this->sendEmail($this->to, "Refund Request");

            $resData = "Message Sent";
            $resp = "success";
        } else {


            $user = UserClosed::where('email', $req->send_to)->first();

            if (isset($user)) {

                // Send Message

                InAppMessage::insert([
                    'send_to' => $req->send_to,
                    'subject' => $req->subject,
                    'message' => $req->message,
                ]);

                $this->name = $user->name;
                $this->to = $user->email;

                $this->subject = $req->subject;
                $this->message = $req->message;


                $this->createNotification($user->ref_code, strip_tags($req->message));


                $this->sendEmail($this->to, "Refund Request");

                $resData = "Message Sent";
                $resp = "success";
            } else {
                $resData = "We cannot locate this receiver information!";
                $resp = "error";
            }
        }


        return redirect()->back()->with($resp, $resData);
    }


    public function runMailChimpCampaign(Request $req)
    {

        $data = $this->sendCampaign($req->subject, $req->message, $req->category);

        if ($data == "Campaign sent successfully.") {

            // Send Message

            MailCampaign::insert([
                'subject' => $req->subject,
                'category' => $req->category,
                'message' => $req->message,
            ]);


            $resData = $data;
            $resp = "success";
        } else {
            $resData = $data;
            $resp = "error";
        }


        return redirect()->back()->with($resp, $resData);
    }


    public function ajaxAccessToUsePaysprint(Request $req)
    {


        $check = AllCountries::where('id', $req->country_id)->first();

        if (isset($check)) {

            if ($check->approval == 1) {
                AllCountries::where('id', $req->country_id)->update(['approval' => 0]);
                $resData = "Access Denied!";
            } else {
                AllCountries::where('id', $req->country_id)->update(['approval' => 1]);
                $resData = "Access Granted!";
            }

            $resp = "success";
        } else {
            $resData = "Not found";
            $resp = "error";
        }


        return redirect()->back()->with($resp, $resData);
    }

    public function getImtCountry()
    {
        $data = AllCountries::where('imt', "true")->get();

        return $data;
    }

    public function ajaxAccessToUsePaysprintImt(Request $req)
    {


        $check = AllCountries::where('id', $req->country_id)->first();

        if (isset($check)) {

            if ($check->imt == "true" && $req->imt_state == "both") {
                AllCountries::where('id', $req->country_id)->update(['imt' => "false", 'inbound' => 'false', 'outbound' => 'false']);
                $resData = "Access Denied!";
            } elseif ($check->inbound == "true" && $req->imt_state == "inbound") {
                AllCountries::where('id', $req->country_id)->update(['inbound' => 'false']);
                $resData = "Inbound Access Denied!";
            } elseif ($check->outbound == "true" && $req->imt_state == "outbound") {
                AllCountries::where('id', $req->country_id)->update(['outbound' => 'false']);
                $resData = "Outbound Access Denied!";
            } elseif ($check->inbound == "true") {
                AllCountries::where('id', $req->country_id)->update(['inbound' => 'false']);
                $resData = "Inbound Access Denied!";
            } elseif ($check->outbound == "true") {
                AllCountries::where('id', $req->country_id)->update(['outbound' => 'false']);
                $resData = "Outbound Access Denied!";
            } elseif ($req->imt_state == "both") {
                AllCountries::where('id', $req->country_id)->update(['imt' => "true", 'inbound' => 'true', 'outbound' => 'true']);
                $resData = "Access Granted!";
            } elseif ($req->imt_state == "inbound") {
                AllCountries::where('id', $req->country_id)->update(['imt' => "false", 'inbound' => 'true', 'outbound' => 'false']);
                $resData = "Access Granted!";
            } elseif ($req->imt_state == "outbound") {
                AllCountries::where('id', $req->country_id)->update(['imt' => "false", 'inbound' => 'false', 'outbound' => 'true']);
                $resData = "Access Granted!";
            } else {
                AllCountries::where('id', $req->country_id)->update(['imt' => "true"]);
                $resData = "Access Granted!";
            }

            $resp = "success";
        } else {
            $resData = "Not found";
            $resp = "error";
        }


        return redirect()->back()->with($resp, $resData);
    }

    public function activatemerchantaccount(Request $req)
    {

        try {
            $thisuser = ClientInfo::where('user_id', $req->id)->first();

            // Update account to live mode..
            ClientInfo::where('user_id', $req->id)->update(['accountMode' => $req->val]);
            $startdate = date('Y-m-d');
            $enddate = date('Y-m-d');

            $startdate = date('Y-m-d');
            $enddate = date('Y-m-d', strtotime($startdate . ' + 30 days'));

            merchantTrial::create([
                'user_id' => $req->id,
                'start_date' => $startdate,
                'end_date' =>  $enddate
            ]);

            // Send Mail to the support agent
            $this->name = $thisuser->business_name;
            $this->email = $thisuser->email;
            $this->info = "Fund remittance";
            $this->subject = "Account activated for live";

            if ($req->val == "live") {
                $this->message = '<p>Hello ' . $this->name . '!, </p><p>This is a confirmation that the merchant account has been activated.</p><p>The PaySprint Merchant Account default Subscription Plan is FREE Plan.</p><p>You will need to upgrade the subscription to access other features.</p><p>We welcome you to PaySprint for Merchant</p>';

                $this->sendEmail($this->email, "Fund remittance");
            }




            $message = "success";
            $res = "Account successfully moved to " . $req->val;
            $status = 200;
        } catch (\Throwable $th) {
            $message = 'error';
            $res = $th->getMessage();
            $status = 400;
        }


        $resData = ['res' => $res, 'message' => $message];

        return $this->returnJSON($resData, $status);
    }

    public function ajaxSingleInvoiceUserCheck(Request $req)
    {

        $info = $req->info;
        $title = $req->title;

        $data = User::where($title, 'LIKE', '%' . $info . '%')->first();

        if (isset($data) == true) {
            $res = strtoupper($title) . " is available. (Invoice goes to Customer's PaySprint Account)";
            $message = "success";
        } else {
            $res = strtoupper($title) . " is not available. (Invoice goes to Customer directly)";
            $message = "error";
        }

        $resData = ['res' => $res, 'message' => $message, 'title' => $title];



        return $this->returnJSON($resData, 200);
    }

    public function ajaxadminLogout(Request $req)
    {

        $getAdmin = Admin::where('username', $req->username)->get();
        // dd($getAdmin);
        if (count($getAdmin) > 0) {
            $req->session()->flush();
            $site = "merchant-home";
            $resData = ['res' => 'Login out', 'message' => 'success', 'link' => $site];
        } else {
            // Logout Super Admin
            $superAdmin = SuperAdmin::where('username', $req->username)->get();

            if (count($superAdmin) > 0) {
                $req->session()->flush();
                $site = "merchant-home";
                $resData = ['res' => 'Login out', 'message' => 'success', 'link' => $site];
            }
        }

        return $this->returnJSON($resData, 200);
    }


    public function withdrawRemittance()
    {

        $getAll = Epaywithdraw::where('remittance', 0)->orderBy('created_at', 'DESC')->get();

        return $getAll;
    }

    public function withdrawpaycaRemittance()
    {

        $getAll = PaycaWithdraw::where('remittance', 0)->orderBy('created_at', 'DESC')->get();

        return $getAll;
    }

    public function epayreportRemittance($email)
    {

        $getAll = Epaywithdraw::where('remittance', 1)->where('client_email', $email)->orderBy('created_at', 'DESC')->get();

        return $getAll;
    }

    public function paycareportRemittance($email)
    {

        $getAll = PaycaWithdraw::where('remittance', 1)->where('client_email', $email)->orderBy('created_at', 'DESC')->get();

        return $getAll;
    }

    public function remittancereportepayAdmin()
    {

        $getAll = Epaywithdraw::where('remittance', 1)->orderBy('created_at', 'DESC')->get();

        return $getAll;
    }

    public function remittancereportpaycaAdmin()
    {

        $getAll = PaycaWithdraw::where('remittance', 1)->orderBy('created_at', 'DESC')->get();

        return $getAll;
    }


    public function allnotification($email)
    {

        $data = Statement::where('user_id', $email)->orderBy('notify', 'ASC')->orderBy('created_at', 'DESC')->get();

        return $data;
    }

    public function notification($email)
    {

        $data = Statement::where('user_id', $email)->where('notify', 0)->count();

        return $data;
    }


    public function userActivity()
    {

        if (session('role') == "Customer Marketing" || session('role') == "Customer Success") {
            $data = Notifications::where('country', 'Canada')->orWhere('country', 'United States')->orderBy('created_at', 'DESC')->take(1000)->get();
        } else {
            $data = Notifications::orderBy('created_at', 'DESC')->take(1000)->get();
        }

        return $data;
    }

    public function userActivityStatistics($start, $end)
    {

        if (session('role') == "Customer Marketing" || session('role') == "Customer Success") {
            $data = Notifications::where('country', 'Canada')->orWhere('country', 'United States')->whereBetween('created_at', [$start, $end])->orderBy('period', 'DESC')->groupBy('period')->take(1000)->get();
        } else {
            $data = Notifications::whereBetween('created_at', [$start, $end])->orderBy('period', 'DESC')->groupBy('period')->take(1000)->get();
        }


        return $data;
    }


    public function userActivityByCountry($country)
    {

        if (session('role') == "Customer Marketing" || session('role') == "Customer Success") {
            $data = Notifications::where('country', 'Canada')->orWhere('country', 'United States')->orderBy('created_at', 'DESC')->get();
        } else {
            $data = Notifications::orderBy('created_at', 'DESC')->get();
        }

        return $data;
    }


    public function gatewaypayActivity($gateway)
    {

        $data = MonerisActivity::where('gateway', 'LIKE', '%' . $gateway . '%')->orderBy('created_at', 'DESC')->take(2000)->get();

        return $data;
    }

    public function bvnStatusActivity()
    {

        $data = BVNVerificationList::orderBy('created_at', 'DESC')->take(2000)->get();

        return $data;
    }


    public function thirdPartyIntegration()
    {

        $data = ThirdPartyIntegration::orderBy('created_at', 'DESC')->get();

        return $data;
    }


    public function userSupportActivities()
    {

        $data = SupportActivity::orderBy('created_at', 'DESC')->get();

        return $data;
    }


    public function specialInformationData()
    {

        $data = $this->getInfo();

        return $data;
    }

    public function selectedInformationData($id)
    {

        $data = $this->getselectedInfo($id);

        return $data;
    }


    public function allcollectionFee()
    {

        $getAll = CollectionFee::orderBy('created_at', 'DESC')->get();

        return $getAll;
    }

    public function getCustomer($id)
    {

        $getcustomer = ImportExcel::where('id', $id)->get();

        return $getcustomer;
    }


    public function getLinkCustomer($id)
    {

        $getcustomer = ImportExcelLink::where('id', $id)->get();

        return $getcustomer;
    }

    public function saveCollectionfee($collection_id, $remittance_date, $client_name, $client_email, $total_amount, $total_remittance, $total_fee, $start_date, $end_date, $platform)
    {

        CollectionFee::insert(['collection_id' => $collection_id, 'remittance_date' => $remittance_date, 'client_name' => $client_name, 'client_email' => $client_email, 'total_amount' => $total_amount, 'total_remittance' => $total_remittance, 'total_fee' => $total_fee, 'start_date' => $start_date, 'end_date' => $end_date, 'platform' => $platform]);
    }


    public function insStatement($email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, $state, $country)
    {
        Statement::insert(['user_id' => $email, 'reference_code' => $reference_code, 'activity' => $activity, 'credit' => $credit, 'debit' => $debit, 'balance' => $balance, 'trans_date' => $trans_date, 'status' => $status, 'action' => $action, 'regards' => $regards, 'state' => $state, 'country' => $country]);
    }


    public function insStatementRoute($email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, $state, $statement_route, $auto_deposit, $country)
    {
        Statement::insert(['user_id' => $email, 'reference_code' => $reference_code, 'activity' => $activity, 'credit' => $credit, 'debit' => $debit, 'balance' => $balance, 'trans_date' => $trans_date, 'status' => $status, 'action' => $action, 'regards' => $regards, 'state' => $state, 'statement_route' => $statement_route, 'auto_deposit' => $auto_deposit, 'country' => $country]);
    }

    public function serviceType($name)
    {
        ServiceType::updateOrCreate(['name' => $name], ['name' => $name]);
    }


    public function getallClient()
    {
        $getClient = ClientInfo::orderBy('created_at', 'DESC')->get();

        return $getClient;
    }

    public function getxpayTrans()
    {
        $getxpayrec = OrganizationPay::where('state', 1)->where('request_receive', '!=', 2)->orderBy('created_at', 'DESC')->get();

        return $getxpayrec;
    }


    public function getxReceive()
    {
        $data = OrganizationPay::select('organization_pay.*', 'receive_pay.*')->join('receive_pay', 'receive_pay.pay_id', '=', 'organization_pay.id')->where('organization_pay.request_receive', '!=', 0)->orderBy('organization_pay.created_at', 'DESC')->get();

        return $data;
    }


    // Get Tranasaction cost
    public function transactionCost()
    {
        $getCost = TransactionCost::orderBy('created_at', 'DESC')->get();

        return $getCost;
    }
    public function transactionCostByCountry()
    {
        $data = TransactionCost::where('country', '!=', null)->orderBy('created_at', 'DESC')->groupBy('country')->get();

        return $data;
    }
    public function gettransactionCostByCountry($country)
    {
        $data = TransactionCost::where('country', $country)->orderBy('created_at', 'DESC')->get();

        return $data;
    }
    public function allUsers()
    {
        $data = User::where('countryapproval', 1)->orderBy('created_at', 'DESC')->get();

        return $data;
    }


    public function allUsersApproved()
    {

        $data = User::where('account_check', 2)->orderBy('created_at', 'DESC')->get();

        return $data;
    }


    public function allConsumerApproved()
    {

        $data = User::where('plan', 'classic')->where('accountType', 'Individual')->orderBy('name', 'ASC')->get();

        return $data;
    }


    public function allMerchantApproved()
    {

        $data = User::where('plan', 'classic')->where('accountType', 'Merchant')->orderBy('name', 'ASC')->get();

        return $data;
    }


    public function allUsersApprovedPending()
    {

        $data = User::where('account_check', 1)->orderBy('lastUpdated', 'DESC')->get();

        return $data;
    }


    public function allUsersMatched()
    {

        $data = User::where([['accountLevel', '>=', 2], ['approval', '>=', 1], ['account_check', '=', 0]])->orderBy('created_at', 'DESC')->get();

        return $data;
    }


    public function allUsersForLevelTwo()
    {

        $data = User::where('accountLevel', 2)->where('approval', 0)->where('bvn_verification', 0)->orderBy('created_at', 'DESC')->get();

        return $data;
    }

    public function allUsersPending()
    {

        $data = User::where([['accountLevel', '=', 2], ['approval', '=', 0], ['bvn_verification', '=', 0], ['account_check', '=', 0]])->orderBy('created_at', 'DESC')->get();

        return $data;
    }


    public function allUsersOverride()
    {

        $data = User::where([['accountLevel', '=', 2], ['approval', '=', 0], ['bvn_verification', '=', 0], ['account_check', '=', 0]])->orderBy('created_at', 'DESC')->get();

        return $data;
    }


    public function allNotActivePsUsersAccount()
    {

        $data = User::where('countryapproval', 0)->where('accountLevel', 0)->orderBy('created_at', 'DESC')->get();

        return $data;
    }


    public function allUsersClosed()
    {

        $data = UserClosed::orderBy('created_at', 'DESC')->get();

        return $data;
    }


    public function allUsersSuspended()
    {

        $data = User::where('flagged', 1)->orderBy('created_at', 'DESC')->get();

        return $data;
    }

    public function allNewUser($country, $usertype)
    {

        if ($usertype == "new") {
            $data = User::where('accountType', 'Individual')->where('archive', 0)->where('country', $country)->where('created_at', '>=', date('Y-m-d', strtotime('-30 days')))->orderBy('created_at', 'DESC')->get();
        } else {
            $data = User::where('accountType', 'Individual')->where('archive', 0)->where('country', $country)->where('created_at', '<', date('Y-m-d', strtotime('-30 days')))->orderBy('created_at', 'DESC')->get();
        }



        return $data;
    }


    public function allMyArchivedUserList($country, $usertype)
    {

        if ($usertype == "consumers") {
            $data = User::where('accountType', 'Individual')->where('country', $country)->where('archive', 1)->orderBy('created_at', 'DESC')->get();
        } else {
            $data = User::where('accountType', 'Merchant')->where('country', $country)->where('archive', 1)->orderBy('created_at', 'DESC')->get();
        }



        return $data;
    }

    public function allMerchantsNew($country, $usertype)
    {

        if ($usertype == "new") {
            $data = User::where('accountType', 'Merchant')->where('archive', 0)->where('country', $country)->where('created_at', '>=', date('Y-m-d', strtotime('-30 days')))->orderBy('created_at', 'DESC')->get();
        } else {
            $data = User::where('accountType', 'Merchant')->where('archive', 0)->where('country', $country)->where('created_at', '<', date('Y-m-d', strtotime('-30 days')))->orderBy('created_at', 'DESC')->get();
        }



        return $data;
    }


    public function allUsersByCountry()
    {
        $data = User::where('countryapproval', 1)->orderBy('created_at', 'DESC')->groupBy('country')->get();

        return $data;
    }


    public function approvedUsersByCountry()
    {

        $data = User::where('account_check', 2)->orderBy('created_at', 'DESC')->groupBy('country')->get();


        return $data;
    }


    public function upgradedUsersByCountry($accountType)
    {
        $data = User::where('plan', 'classic')->where('accountType', $accountType)->groupBy('country')->get();

        return $data;
    }


    public function merchantMode($mode)
    {
        $data = ClientInfo::where('accountMode', $mode)->groupBy('country')->get();

        return $data;
    }

    public function merchantAccountDetails($country, $mode)
    {

        $data = [];
        $client = ClientInfo::where('country', $country)->where('accountMode', $mode)->get();



        for ($i = 0; $i < count($client); $i++) {
            $element = $client[$i];

            // Get the Users Info
            $users = User::where('ref_code', $element->user_id)->first();


            $data[] = [
                'users' => $users
            ];
        }


        return $data;
    }


    public function approvedPendingUsersByCountry()
    {
        $data = User::where('account_check', 1)->orderBy('lastUpdated', 'DESC')->groupBy('country')->get();

        return $data;
    }

    public function matchedUsersByCountry()
    {
        $data = User::where([['accountLevel', '>=', 2], ['approval', '>=', 1], ['account_check', '=', 0]])->orderBy('created_at', 'DESC')->groupBy('country')->get();

        return $data;
    }


    public function level2UsersByCountry()
    {
        $data = User::where('accountLevel', 2)->where('approval', 1)->where('bvn_verification', 0)->orderBy('created_at', 'DESC')->groupBy('country')->get();

        return $data;
    }

    public function pendingUsersByCountry()
    {
        $data = User::where([['accountLevel', '=', 2], ['approval', '=', 0], ['bvn_verification', '=', 0], ['account_check', '=', 0]])->orderBy('created_at', 'DESC')->groupBy('country')->get();

        return $data;
    }


    public function overrideUsersByCountry()
    {
        $data = User::where([['accountLevel', '=', 2], ['approval', '=', 0], ['bvn_verification', '=', 0], ['account_check', '=', 0]])->orderBy('created_at', 'DESC')->groupBy('country')->get();

        return $data;
    }


    public function psUsersNotActiveByCountry()
    {
        $data = User::where([['accountLevel', '=', 0], ['countryapproval', '=', 0]])->orderBy('created_at', 'DESC')->groupBy('country')->get();

        return $data;
    }


    public function getPaymentGateway($country)
    {

        $data = AllCountries::where('name', $country)->first();

        return $data;
    }


    public function getActiveCountries()
    {

        $data = AllCountries::where('approval', 1)->get();

        return $data;
    }

    public function getActiveCountriesNeededDetails()
    {

        $info = AllCountries::where('approval', 1)->get();

        $data = $info->map(function ($country) {
            return collect($country->toArray())
                ->only(['id', 'name', 'code', 'callingCode', 'currencyCode', 'currencySymbol'])
                ->all();
        });


        return $data;
    }

    public function getInvoiceCommission()
    {
        $data = InvoiceCommission::orderBy('created_at', 'DESC')->get();

        return $data;
    }


    public function closedUsersByCountry()
    {

        if (session('role') == 'Aml compliance') {
            $data = UserClosed::where('country', 'Canada')->orWhere('country', 'United States')->orderBy('created_at', 'DESC')->groupBy('country')->get();
        } else {
            $data = UserClosed::orderBy('created_at', 'DESC')->groupBy('country')->get();
        }


        return $data;
    }


    public function suspendedUsersByCountry()
    {

        if (session('role') == 'Aml compliance') {
            $data = User::where('flagged', 1)->where('country', 'Canada')->orWhere('country', 'United States')->orderBy('created_at', 'DESC')->groupBy('country')->get();
        } else {
            $data = User::where('flagged', 1)->orderBy('created_at', 'DESC')->groupBy('country')->get();
        }

        return $data;
    }

    public function newaccountUsersByCountry($usertype)
    {

        if (session('role') == 'Customer Marketing') {

            if (session('country') == 'Canada') {
                if ($usertype == "new") {
                    $data = User::where('accountType', 'Individual')->where('archive', 0)->where('country', 'Canada')->orWhere('country', 'United States')->where('created_at', '>=', date('Y-m-d', strtotime('-30 days')))->groupBy('country')->get();
                } else {
                    $data = User::where('accountType', 'Individual')->where('archive', 0)->where('country', 'Canada')->orWhere('country', 'United States')->where('created_at', '<', date('Y-m-d', strtotime('-30 days')))->groupBy('country')->get();
                }
            } else {

                if ($usertype == "new") {
                    $data = User::where('accountType', 'Individual')->where('archive', 0)->where('country', session('country'))->where('created_at', '>=', date('Y-m-d', strtotime('-30 days')))->groupBy('country')->get();
                } else {
                    $data = User::where('accountType', 'Individual')->where('archive', 0)->where('country', session('country'))->where('created_at', '<', date('Y-m-d', strtotime('-30 days')))->groupBy('country')->get();
                }
            }
        } else {
            if ($usertype == "new") {
                $data = User::where('accountType', 'Individual')->where('archive', 0)->where('created_at', '>=', date('Y-m-d', strtotime('-30 days')))->groupBy('country')->get();
            } else {
                $data = User::where('accountType', 'Individual')->where('archive', 0)->where('created_at', '<', date('Y-m-d', strtotime('-30 days')))->groupBy('country')->get();
            }
        }




        return $data;
    }


    // Get Promoted Businesses
    public function getPromotedBusiness()
    {
        $data = ClientInfo::where('promote_business', 1)->orderBy('created_at', 'DESC')->get();

        return $data;
    }


    public function newaccountMerchantsByCountry($usertype)
    {

        if (session('role') == 'Customer Marketing') {

            if (session('country') == 'Canada') {
                if ($usertype == "new") {
                    $data = User::where('accountType', 'Merchant')->where('archive', 0)->where('countryapproval', 1)->where('country', 'Canada')->orWhere('country', 'United States')->where('created_at', '>=', date('Y-m-d', strtotime('-30 days')))->groupBy('country')->get();
                } else {
                    $data = User::where('accountType', 'Merchant')->where('archive', 0)->where('countryapproval', 1)->where('country', 'Canada')->orWhere('country', 'United States')->where('created_at', '<', date('Y-m-d', strtotime('-30 days')))->groupBy('country')->get();
                }
            } else {
                if ($usertype == "new") {
                    $data = User::where('accountType', 'Merchant')->where('archive', 0)->where('countryapproval', 1)->where('country', session('country'))->where('created_at', '>=', date('Y-m-d', strtotime('-30 days')))->groupBy('country')->get();
                } else {
                    $data = User::where('accountType', 'Merchant')->where('archive', 0)->where('countryapproval', 1)->where('country', session('country'))->where('created_at', '<', date('Y-m-d', strtotime('-30 days')))->groupBy('country')->get();
                }
            }
        } else {
            if ($usertype == "new") {
                $data = User::where('accountType', 'Merchant')->where('archive', 0)->where('countryapproval', 1)->where('created_at', '>=', date('Y-m-d', strtotime('-30 days')))->groupBy('country')->get();
            } else {
                $data = User::where('accountType', 'Merchant')->where('archive', 0)->where('countryapproval', 1)->where('created_at', '<', date('Y-m-d', strtotime('-30 days')))->groupBy('country')->get();
            }
        }




        return $data;
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

    public function getthisOrganization($user_id)
    {

        $orgDetail = User::where('ref_code', $user_id)->first();

        return $orgDetail;
    }

    public function otherCurrencyCode($user_id)
    {
        $userData = User::where('ref_code', $user_id)->first();

        $data = $this->getCountryCode($userData->country);

        $data['conversionrate'] = $this->getConversionRate(session('currencyCode'), $data->currencyCode);


        $resp = [
            'data' => $data,
            'conversionrate' => $data['conversionrate'],
        ];

        return $resp;
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




    // Platform API
    public function doCurl()
    {
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


    public function getCurrencyCode($country)
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://restcountries.eu/rest/v2/name/' . $country,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Cookie: __cfduid=d423c6237ed02a0f8118fec1c27419ab81613795899'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return json_decode($response);
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


    // Get My Client Info
    public function getMyClientInfo($ref_code)
    {
        $data = ClientInfo::where('user_id', $ref_code)->first();

        return $data;
    }

    // Get Transaction Charge fee

    public function transactionChargeFees($country, $structure = null, $method)
    {
        $data = TransactionCost::select('fixed as fixedAmount', 'variable as chargePercentage', 'method', 'country')->where('country', $country)->where('method', $method)->where('structure', $structure)->first();

        return $data;
    }



    public function sendEmail($objDemoa, $purpose)
    {
        $objDemo = new \stdClass();
        $objDemo->purpose = $purpose;



        if ($purpose == 'Account is credited') {
            $objDemo->name = $this->name;
            $objDemo->subject = $this->subject;
            $objDemo->message = $this->message;
        } elseif ($purpose == 'Flagged Account') {
            $objDemo->name = $this->name;
            $objDemo->subject = $this->subject;
            $objDemo->message = $this->message;
        } elseif ($purpose == 'Fund remittance' || $purpose == 'Your PaySprint Referral Account Actiavted') {
            $objDemo->name = $this->name;
            $objDemo->email = $this->email;
            $objDemo->subject = $this->subject;
            $objDemo->info = $this->info;
            $objDemo->message = $this->message;
        } elseif ($purpose == 'Refund Request') {
            $objDemo->name = $this->name;
            $objDemo->email = $this->to;
            $objDemo->subject = $this->subject;
            $objDemo->message = $this->message;
        } elseif ($purpose == 'Cash withdrawal request') {
            $objDemo->name = $this->admin;
            $objDemo->email = $this->to;
            $objDemo->subject = $this->info2;
            $objDemo->message = $this->infomessage;
        } elseif ($purpose == $this->subject) {

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

    public function updateSubscription(Request $req)
    {
        $data = TransactionCost::where('structure', 'Consumer Monthly Subscription')->get();

        TransactionCost::where('country', 'Nigeria')->where('structure', 'Consumer Monthly Subscription',)->update([
            'fixed' => '8.41',
        ]);
        TransactionCost::where('country', 'Nigeria')->where('structure', 'Merchant Monthly Subscription',)->update([
            'fixed' => '25.23',
        ]);
        TransactionCost::where('country', 'Australia')->where('structure', 'Consumer Monthly Subscription',)->update([
            'fixed' => '4.33',
        ]);
        TransactionCost::where('country', 'Australia')->where('structure', 'Merchant Monthly Subscription',)->update([
            'fixed' => '10.83',
        ]);
        // TransactionCost::where('country', 'Austria')->where('structure', 'Consumer Monthly Subscription',)->update([
        //     'fixed' => '4.33',
        // ]);
        // TransactionCost::where('country', 'Austria')->where('structure', 'Merchant Monthly Subscription',)->update([
        //     'fixed' => '10.83',
        // ]);
        // TransactionCost::where('country', 'Belgium')->where('structure', 'Consumer Monthly Subscription',)->update([
        //     'fixed' => '4.33',
        // ]);
        // TransactionCost::where('country', 'Belgium')->where('structure', 'Merchant Monthly Subscription',)->update([
        //     'fixed' => '10.83',
        // ]);
        TransactionCost::where('country', 'Bulgaria')->where('structure', 'Consumer Monthly Subscription',)->update([
            'fixed' => '5.77',
        ]);
        TransactionCost::where('country', 'Bulgaria')->where('structure', 'Merchant Monthly Subscription',)->update([
            'fixed' => '14.41',
        ]);
        TransactionCost::where('country', 'Canada')->where('structure', 'Consumer Monthly Subscription',)->update([
            'fixed' => '3.87',
        ]);
        TransactionCost::where('country', 'Canada')->where('structure', 'Merchant Monthly Subscription',)->update([
            'fixed' => '9.68',
        ]);
        TransactionCost::where('country', 'Croatia')->where('structure', 'Consumer Monthly Subscription',)->update([
            'fixed' => '4.43',
        ]);
        TransactionCost::where('country', 'Croatia')->where('structure', 'Merchant Monthly Subscription',)->update([
            'fixed' => '11.06',
        ]);
        // TransactionCost::where('country', 'Cyprus')->where('structure', 'Consumer Monthly Subscription',)->update([
        //     'fixed' => '4.33',
        // ]);
        // TransactionCost::where('country', 'Cyprus')->where('structure', 'Merchant Monthly Subscription',)->update([
        //     'fixed' => '10.83',
        // ]);
        TransactionCost::where('country', 'Czech Republic')->where('structure', 'Consumer Monthly Subscription',)->update([
            'fixed' => '7.24',
        ]);
        TransactionCost::where('country', 'Czech Republic')->where('structure', 'Merchant Monthly Subscription',)->update([
            'fixed' => '18.10',
        ]);
        // TransactionCost::where('country', 'Denmark')->where('structure', 'Consumer Monthly Subscription',)->update([
        //     'fixed' => '4.33',
        // ]);
        // TransactionCost::where('country', 'Denmark')->where('structure', 'Merchant Monthly Subscription',)->update([
        //     'fixed' => '10.83',
        // ]);
        // TransactionCost::where('country', 'Estonia')->where('structure', 'Consumer Monthly Subscription',)->update([
        //     'fixed' => '4.33',
        // ]);
        // TransactionCost::where('country', 'Estonia')->where('structure', 'Merchant Monthly Subscription',)->update([
        //     'fixed' => '10.83',
        // ]);
        // TransactionCost::where('country', 'Finland')->where('structure', 'Consumer Monthly Subscription',)->update([
        //     'fixed' => '4.33',
        // ]);
        // TransactionCost::where('country', 'Finland')->where('structure', 'Merchant Monthly Subscription',)->update([
        //     'fixed' => '10.83',
        // ]);
        // TransactionCost::where('country', 'France')->where('structure', 'Consumer Monthly Subscription',)->update([
        //     'fixed' => '4.33',
        // ]);
        // TransactionCost::where('country', 'France')->where('structure', 'Merchant Monthly Subscription',)->update([
        //     'fixed' => '10.83',
        // ]);
        // TransactionCost::where('country', 'Germany')->where('structure', 'Consumer Monthly Subscription',)->update([
        //     'fixed' => '4.33',
        // ]);
        // TransactionCost::where('country', 'Germany')->where('structure', 'Merchant Monthly Subscription',)->update([
        //     'fixed' => '10.83',
        // ]);
        TransactionCost::where('country', 'Ghana')->where('structure', 'Consumer Monthly Subscription',)->update([
            'fixed' => '4.27',
        ]);
        TransactionCost::where('country', 'Ghana')->where('structure', 'Merchant Monthly Subscription',)->update([
            'fixed' => '10.67',
        ]);
        // TransactionCost::where('country', 'Greece')->where('structure', 'Consumer Monthly Subscription',)->update([
        //     'fixed' => '4.33',
        // ]);
        // TransactionCost::where('country', 'Greece')->where('structure', 'Merchant Monthly Subscription',)->update([
        //     'fixed' => '10.83',
        // ]);
        TransactionCost::where('country', 'Hong Kong')->where('structure', 'Consumer Monthly Subscription',)->update([
            'fixed' => '4.71',
        ]);
        TransactionCost::where('country', 'Hong Kong')->where('structure', 'Merchant Monthly Subscription',)->update([
            'fixed' => '11.76',
        ]);
        TransactionCost::where('country', 'Hungary')->where('structure', 'Consumer Monthly Subscription',)->update([
            'fixed' => '5.94',
        ]);
        TransactionCost::where('country', 'Hungary')->where('structure', 'Merchant Monthly Subscription',)->update([
            'fixed' => '14.86',
        ]);
        TransactionCost::where('country', 'India')->where('structure', 'Consumer Monthly Subscription',)->update([
            'fixed' => '4.77',
        ]);
        TransactionCost::where('country', 'India')->where('structure', 'Merchant Monthly Subscription',)->update([
            'fixed' => '11.91',
        ]);
        // TransactionCost::where('country', 'Ireland')->where('structure', 'Consumer Monthly Subscription',)->update([
        //     'fixed' => '4.33',
        // ]);
        // TransactionCost::where('country', 'Ireland')->where('structure', 'Merchant Monthly Subscription',)->update([
        //     'fixed' => '10.83',
        // ]);
        // TransactionCost::where('country', 'Israel')->where('structure', 'Consumer Monthly Subscription',)->update([
        //     'fixed' => '4.33',
        // ]);
        // TransactionCost::where('country', 'Israel')->where('structure', 'Merchant Monthly Subscription',)->update([
        //     'fixed' => '10.83',
        // ]);
        // TransactionCost::where('country', 'Italy')->where('structure', 'Consumer Monthly Subscription',)->update([
        //     'fixed' => '4.33',
        // ]);
        // TransactionCost::where('country', 'Italy')->where('structure', 'Merchant Monthly Subscription',)->update([
        //     'fixed' => '10.83',
        // ]);
        TransactionCost::where('country', 'Japan')->where('structure', 'Consumer Monthly Subscription',)->update([
            'fixed' => '4.06',
        ]);
        TransactionCost::where('country', 'Japan')->where('structure', 'Merchant Monthly Subscription',)->update([
            'fixed' => '10.15',
        ]);
        TransactionCost::where('country', 'Latvia')->where('structure', 'Consumer Monthly Subscription',)->update([
            'fixed' => '3.02',
        ]);
        TransactionCost::where('country', 'Latvia')->where('structure', 'Merchant Monthly Subscription',)->update([
            'fixed' => '9.07',
        ]);
        TransactionCost::where('country', 'Lithuania')->where('structure', 'Consumer Monthly Subscription',)->update([
            'fixed' => '4.43',
        ]);
        TransactionCost::where('country', 'Lithuania')->where('structure', 'Merchant Monthly Subscription',)->update([
            'fixed' => '13.29',
        ]);
        // TransactionCost::where('country', 'Luxembourg')->where('structure', 'Consumer Monthly Subscription',)->update([
        //     'fixed' => '4.33',
        // ]);
        // TransactionCost::where('country', 'Luxembourg')->where('structure', 'Merchant Monthly Subscription',)->update([
        //     'fixed' => '10.83',
        // ]);
        TransactionCost::where('country', 'Malaysia')->where('structure', 'Consumer Monthly Subscription',)->update([
            'fixed' => '4.47',
        ]);
        TransactionCost::where('country', 'Malaysia')->where('structure', 'Merchant Monthly Subscription',)->update([
            'fixed' => '13.40',
        ]);
        // TransactionCost::where('country', 'Malta')->where('structure', 'Consumer Monthly Subscription',)->update([
        //     'fixed' => '4.33',
        // ]);
        // TransactionCost::where('country', 'Malta')->where('structure', 'Merchant Monthly Subscription',)->update([
        //     'fixed' => '10.83',
        // ]);
        TransactionCost::where('country', 'Mexico')->where('structure', 'Consumer Monthly Subscription',)->update([
            'fixed' => '6.01',
        ]);
        TransactionCost::where('country', 'Mexico')->where('structure', 'Merchant Monthly Subscription',)->update([
            'fixed' => '15.04',
        ]);
        TransactionCost::where('country', 'Netherlands')->where('structure', 'Consumer Monthly Subscription',)->update([
            'fixed' => '5.41',
        ]);
        TransactionCost::where('country', 'Netherlands')->where('structure', 'Merchant Monthly Subscription',)->update([
            'fixed' => '13.53',
        ]);
        TransactionCost::where('country', 'NewZealand')->where('structure', 'Consumer Monthly Subscription',)->update([
            'fixed' => '3.98',
        ]);
        TransactionCost::where('country', 'NewZealand')->where('structure', 'Merchant Monthly Subscription',)->update([
            'fixed' => '11.94',
        ]);
        TransactionCost::where('country', 'Norway')->where('structure', 'Consumer Monthly Subscription',)->update([
            'fixed' => '4.85',
        ]);
        TransactionCost::where('country', 'Norway')->where('structure', 'Merchant Monthly Subscription',)->update([
            'fixed' => '27.00',
        ]);
        TransactionCost::where('country', 'Phillipines')->where('structure', 'Consumer Monthly Subscription',)->update([
            'fixed' => '8.38',
        ]);
        TransactionCost::where('country', 'Phillipines')->where('structure', 'Merchant Monthly Subscription',)->update([
            'fixed' => '20.94',
        ]);
        // TransactionCost::where('country', 'Polland')->where('structure', 'Consumer Monthly Subscription',)->update([
        //     'fixed' => '4.33',
        // ]);
        // TransactionCost::where('country', 'Polland')->where('structure', 'Merchant Monthly Subscription',)->update([
        //     'fixed' => '10.83',
        // ]);
        // TransactionCost::where('country', 'Portugal')->where('structure', 'Consumer Monthly Subscription',)->update([
        //     'fixed' => '4.33',
        // ]);
        // TransactionCost::where('country', 'Phortugal')->where('structure', 'Merchant Monthly Subscription',)->update([
        //     'fixed' => '10.83',
        // ]);
        TransactionCost::where('country', 'Romania')->where('structure', 'Consumer Monthly Subscription',)->update([
            'fixed' => '4.79',
        ]);
        TransactionCost::where('country', 'Romania')->where('structure', 'Merchant Monthly Subscription',)->update([
            'fixed' => '14.38',
        ]);
        TransactionCost::where('country', 'Singapore')->where('structure', 'Consumer Monthly Subscription',)->update([
            'fixed' => '6.92',
        ]);
        TransactionCost::where('country', 'Singapore')->where('structure', 'Merchant Monthly Subscription',)->update([
            'fixed' => '20.75',
        ]);
        // TransactionCost::where('country', 'Slovakia')->where('structure', 'Consumer Monthly Subscription',)->update([
        //     'fixed' => '4.33',
        // ]);
        // TransactionCost::where('country', 'Slovakia')->where('structure', 'Merchant Monthly Subscription',)->update([
        //     'fixed' => '10.83',
        // ]);
        // TransactionCost::where('country', 'Slovenia')->where('structure', 'Consumer Monthly Subscription',)->update([
        //     'fixed' => '4.33',
        // ]);
        // TransactionCost::where('country', 'Slovenia')->where('structure', 'Merchant Monthly Subscription',)->update([
        //     'fixed' => '10.83',
        // ]);
        TransactionCost::where('country', 'SouthAfrica')->where('structure', 'Consumer Monthly Subscription',)->update([
            'fixed' => '8.06',
        ]);
        TransactionCost::where('country', 'SouthAfrica')->where('structure', 'Merchant Monthly Subscription',)->update([
            'fixed' => '24.19',
        ]);
        // TransactionCost::where('country', 'Spain')->where('structure', 'Consumer Monthly Subscription',)->update([
        //     'fixed' => '4.33',
        // ]);
        // TransactionCost::where('country', 'Spain')->where('structure', 'Merchant Monthly Subscription',)->update([
        //     'fixed' => '10.83',
        // ]);
        TransactionCost::where('country', 'Sweden')->where('structure', 'Consumer Monthly Subscription',)->update([
            'fixed' => '5.20',
        ]);
        TransactionCost::where('country', 'Sweden')->where('structure', 'Merchant Monthly Subscription',)->update([
            'fixed' => '15.61',
        ]);
        TransactionCost::where('country', 'Switzerland')->where('structure', 'Consumer Monthly Subscription',)->update([
            'fixed' => '4.76',
        ]);
        TransactionCost::where('country', 'Switzerland')->where('structure', 'Merchant Monthly Subscription',)->update([
            'fixed' => '14.28',
        ]);
        // TransactionCost::where('country', 'Taiwan')->where('structure', 'Consumer Monthly Subscription',)->update([
        //     'fixed' => '4.33',
        // ]);
        // TransactionCost::where('country', 'Taiwan')->where('structure', 'Merchant Monthly Subscription',)->update([
        //     'fixed' => '10.83',
        // ]);
        // TransactionCost::where('country', 'Thailand')->where('structure', 'Consumer Monthly Subscription',)->update([
        //     'fixed' => '4.33',
        // ]);
        // TransactionCost::where('country', 'Thailand')->where('structure', 'Merchant Monthly Subscription',)->update([
        //     'fixed' => '10.83',
        // ]);
        TransactionCost::where('country', 'United Arab Emirates')->where('structure', 'Consumer Monthly Subscription',)->update([
            'fixed' => '5.51',
        ]);
        TransactionCost::where('country', 'United Arab Emirates')->where('structure', 'Merchant Monthly Subscription',)->update([
            'fixed' => '13.77',
        ]);
        // TransactionCost::where('country', 'United Kingdom')->where('structure', 'Consumer Monthly Subscription',)->update([
        //     'fixed' => '4.33',
        // ]);
        // TransactionCost::where('country', 'United Kingdom')->where('structure', 'Merchant Monthly Subscription',)->update([
        //     'fixed' => '10.83',
        // ]);
        TransactionCost::where('country', 'United States')->where('structure', 'Consumer Monthly Subscription',)->update([
            'fixed' => '6.02',
        ]);
        TransactionCost::where('country', 'United States')->where('structure', 'Merchant Monthly Subscription',)->update([
            'fixed' => '15.05',
        ]);

        dd('done');
    }
}
