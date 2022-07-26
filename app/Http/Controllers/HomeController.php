<?php

namespace App\Http\Controllers;

use Session;

use App\Answer;
use App\Points;

use App\Community;

use App\CashAdvance;

use App\UpgradePlan;

use App\Events\Event;

use App\User as User;

use App\ClaimedPoints;

use App\HistoryReport;

use App\ReferredUsers;

use App\Traits\RpmApp;

use App\Mail\sendEmail;

use App\Traits\Trulioo;


use App\ImportExcelLink;

use App\Traits\IDVCheck;

use App\Traits\MyEstore;

use App\ReferralGenerate;

use App\ReferralClaim;

use App\Traits\Xwireless;

use App\VerificationCode;

use App\AddBank as AddBank;

use App\AddCard as AddCard;

use App\Traits\GenerateOtp;

use App\Traits\SpecialInfo;

use Illuminate\Http\Request;

use App\Building as Building;

use App\Traits\AccountNotify;

use App\Traits\PointsHistory;

use App\Traits\ExpressPayment;

use App\Traits\PaymentGateway;

use App\Traits\PaysprintPoint;

use App\AnonUsers as AnonUsers;

use App\Bronchure as Bronchure;

use App\Contactus as Contactus;

use App\Statement as Statement;


use App\Traits\PaystackPayment;

use App\Workorder as Workorder;

use App\Classes\MyCurrencyCloud;
use App\CardIssuer as CardIssuer;
use App\ClientInfo as ClientInfo;
use App\Consultant as Consultant;

use App\UserClosed as UserClosed;

use App\Exports\TransactionExport;
use Illuminate\Support\Facades\DB;

use App\CreateEvent as CreateEvent;
use App\ImportExcel as ImportExcel;



use App\RentalQuote as RentalQuote;
use App\ServiceType as ServiceType;
use App\Traits\MailChimpNewsLetter;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;


use Illuminate\Support\Facades\Mail;

use Maatwebsite\Excel\Facades\Excel;

use Rap2hpoutre\FastExcel\FastExcel;

use App\AllCountries as AllCountries;

use App\PricingSetup as PricingSetup;

use App\SetupBilling as SetupBilling;

use App\Notifications as Notifications;

use Illuminate\Support\Facades\Storage;

use App\InvoicePayment as InvoicePayment;

use App\PromoDate;

use App\SpecialPromo;

use App\OrganizationPay as OrganizationPay;
use App\TransactionCost as TransactionCost;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\MaintenanceRequest as MaintenanceRequest;

class HomeController extends Controller
{

    public $to = "info@paysprint.ca";
    public $customerserviceto = "customerserviceafrica@paysprint.ca";
    public $page;
    public $email;
    public $name;
    public $subject;
    public $website;
    public $message;
    public $file;
    public $ref_code;
    public $country;
    public $timezone;

    use RpmApp, Trulioo, AccountNotify, PaystackPayment, ExpressPayment, SpecialInfo, Xwireless, PaymentGateway, MailChimpNewsLetter, PaysprintPoint, PointsHistory, GenerateOtp, IDVCheck, MyEstore;
    /**
     * Create a new controller instance.
     *
     *  @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['homePage', 'estores', 'merchantIndex', 'index', 'about', 'ajaxregister', 'ajaxlogin', 'contact', 'service', 'loginApi', 'setupBills', 'checkmyBills', 'invoice', 'payment', 'getmyInvoice', 'myreceipt', 'getPayment', 'getmystatement', 'getOrganization', 'contactus', 'ajaxgetBronchure', 'rentalManagement', 'maintenance', 'amenities', 'messages', 'paymenthistory', 'documents', 'otherservices', 'ajaxcreateMaintenance', 'maintenanceStatus', 'maintenanceView', 'maintenancedelete', 'maintenanceEdit', 'updatemaintenance', 'rentalManagementAdmin', 'rentalManagementAdminMaintenance', 'rentalManagementAdminMaintenanceview', 'rentalManagementAdminfacility', 'rentalManagementAdminconsultant', 'rentalManagementassignconsultant', 'rentalManagementConsultant', 'rentalManagementConsultantWorkorder', 'rentalManagementConsultantMaintenance', 'rentalManagementConsultantInvoice', 'rentalManagementAdminviewinvoices', 'rentalManagementAdminviewconsultant', 'rentalManagementAdmineditconsultant', 'rentalManagementConsultantQuote', 'rentalManagementAdminviewquotes', 'rentalManagementAdminnegotiate', 'rentalManagementConsultantNegotiate', 'rentalManagementConsultantMymaintnenance', 'facilityview', 'rentalManagementAdminWorkorder', 'ajaxgetFacility', 'ajaxgetbuildingaddress', 'ajaxgetCommission', 'termsOfUse', 'privacyPolicy', 'ajaxnotifyupdate', 'feeStructure', 'feeStructure2', 'expressUtilities', 'expressBuyUtilities', 'selectCountryUtilityBills', 'myRentalManagementFacility', 'rentalManagementAdminStart', 'haitiDonation', 'paymentFromLink', 'claimedPoints', 'cashAdvance', 'consumerPoints', 'community', 'askQuestion', 'subMessage', 'storeSubMessage', 'storeAskedQuestions', 'expressResponseback']]);

        $location = $this->myLocation();

        $this->timezone = explode("/", $location->timezone);

        return $this->timezone;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */


    public function homePage()
    {
        // To get the actual link from users click

        // $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        if (Auth::check() == true) {

            if (Auth::user()->accountType == "Individual") {
                $this->page = 'Landing';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'sendReceive' => $this->sendAndReceive(Auth::user()->email),
                    'payInvoice' => $this->payInvoice(Auth::user()->email),
                    'walletTrans' => $this->sendAndReceive(Auth::user()->email),
                    'urgentnotification' => $this->urgentNotification(Auth::user()->email),
                    'currencyCode' => $this->getCountryCode(Auth::user()->country),
                    'getCard' => $this->getUserCard(),
                    'getBank' => $this->getUserBank(),
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                    'getmerchantsByCategory' => $this->getMerchantsByCategory(),
                    'specialInfo' => $this->getthisInfo(Auth::user()->country),
                    'continent' => $this->timezone[0],
                    'mypoints' => $this->getAcquiredPoints(Auth::user()->id),
                    'pointsclaim' => $this->getClaimedHistory(Auth::user()->id),
                    'myplan' => UpgradePlan::where('userId', Auth::user()->ref_code)->first(),
                    'imtAccess' => AllCountries::where('name', Auth::user()->country)->first(),
                    'referred' => $this->referral(Auth::user()->ref_code)
                );

                $view = 'home';
            } else {

                // return redirect()->route('Admin');
                return redirect()->route('dashboard');
            }
        } else {
            $this->page = 'Homepage';
            $this->name = '';
            $view = 'main.newpage.shade-pro.index';
            $data = [
                'continent' => $this->timezone[0]
            ];
        }

        // dd($data);



        return view($view)->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }


    public function estores()
    {

        if (Auth::check() == true) {
            $this->page = 'e-Store';
            $this->name = Auth::user()->name;
            $this->email = Auth::user()->email;
        } else {
            $this->page = 'e-Store';
            $this->name = '';
            $this->email = '';
        }


        $data = [
            'activeStores' => $this->activeStores(),
        ];



        return view('main.estores')->with(['pages' => 'e-Store', 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }

    public function merchantIndex()
    {

        $this->page = 'Merchant';

        return view('main.newpage.shade-pro.merchantindex')->with(['pages' => $this->page]);
    }

    public function index()
    {


        // dd($req->session());

        if (Auth::check() == true) {

            if (Auth::user()->accountType == "Individual") {
                $this->page = 'Landing';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'sendReceive' => $this->sendAndReceive(Auth::user()->email),
                    'payInvoice' => $this->payInvoice(Auth::user()->email),
                    'walletTrans' => $this->sendAndReceive(Auth::user()->email),
                    'urgentnotification' => $this->urgentNotification(Auth::user()->email),
                    'currencyCode' => $this->getCountryCode(Auth::user()->country),
                    'getCard' => $this->getUserCard(),
                    'getBank' => $this->getUserBank(),
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                    'getmerchantsByCategory' => $this->getMerchantsByCategory(),
                    'specialInfo' => $this->getthisInfo(Auth::user()->country),
                    'continent' => $this->timezone[0],
                    'mypoints' => $this->getAcquiredPoints(Auth::user()->id),
                    'pointsclaim' => $this->getClaimedHistory(Auth::user()->user_id),
                    'myplan' => UpgradePlan::where('userId', Auth::user()->ref_code)->first(),
                    'imtAccess' => AllCountries::where('name', Auth::user()->country)->first(),
                    'referred' => $this->referral(Auth::user()->ref_code)
                );

                $view = 'home';
            } else {
                // return redirect()->route('Admin');
                return redirect()->route('dashboard');
            }
        } else {
            $this->page = 'Home';
            $this->name = '';
            $view = 'main.index';
            $data = [
                'continent' => $this->timezone[0]
            ];
        }




        return view($view)->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }


    public function authIndex()
    {



        // dd($req->session());
        if (Auth::check() == true) {

            if (Auth::user()->accountType == "Individual") {
                $this->page = 'Landing';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'sendReceive' => $this->sendAndReceive(Auth::user()->email),
                    'payInvoice' => $this->payInvoice(Auth::user()->email),
                    'walletTrans' => $this->sendAndReceive(Auth::user()->email),
                    'urgentnotification' => $this->urgentNotification(Auth::user()->email),
                    'currencyCode' => $this->getCountryCode(Auth::user()->country),
                    'getCard' => $this->getUserCard(),
                    'getBank' => $this->getUserBank(),
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                    'getmerchantsByCategory' => $this->getMerchantsByCategory(),
                    'specialInfo' => $this->getthisInfo(Auth::user()->country),
                    'continent' => $this->timezone[0],
                    'mypoints' => $this->getAcquiredPoints(Auth::user()->id),
                    'pointsclaim' => $this->getClaimedHistory(Auth::user()->user_id),
                    'myplan' => UpgradePlan::where('userId', Auth::user()->ref_code)->first(),
                    'imtAccess' => AllCountries::where('name', Auth::user()->country)->first(),
                    'referred' => $this->referral(Auth::user()->ref_code)

                );
            } else {
                // return redirect()->route('Admin');
                return redirect()->route('dashboard');
            }
        } else {
            $this->page = 'Home';
            $this->name = '';
            $this->email = '';
            $data = [
                'continent' => $this->timezone[0]
            ];
        }





        return view('home')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }


    public function haitiDonation()
    {


        // dd($req->session());
        if (Auth::check() == true) {
            $pauline = User::where('email', 'jamrock29@hotmail.com')->where('country', Auth::user()->country)->first();

            $this->page = 'Supporting HAITI';
            $this->name = Auth::user()->name;
            $this->email = Auth::user()->email;
            $data = array(
                'sendReceive' => $this->sendAndReceive(Auth::user()->email),
                'payInvoice' => $this->payInvoice(Auth::user()->email),
                'walletTrans' => $this->sendAndReceive(Auth::user()->email),
                'urgentnotification' => $this->urgentNotification(Auth::user()->email),
                'currencyCode' => $this->getCountryCode(Auth::user()->country),
                'getCard' => $this->getUserCard(),
                'getBank' => $this->getUserBank(),
                'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                'getmerchantsByCategory' => $this->getMerchantsByCategory(),
                'specialInfo' => $this->getthisInfo(Auth::user()->country),
                'continent' => $this->timezone[0],
                'pauline' => $pauline
            );
        } else {
            $pauline = User::where('email', 'jamrock29@hotmail.com')->where('country', 'Canada')->first();
            $this->page = 'Supporting HAITI';
            $this->name = '';
            $this->email = '';
            $data = [
                'continent' => $this->timezone[0],
                'pauline' => $pauline
            ];
        }





        return view('main.haitidonate')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }


    public function feeStructure(Request $req)
    {



        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Pricing';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $country = Auth::user()->country;
                $data = array(
                    'country' => $country,
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                    'continent' => $this->timezone[0],
                    'activecountries' => $this->getActiveCountries()
                );
            } else {
                $country = $this->myLocation()->country;
                $this->page = 'Pricing';
                $this->name = '';
                $data = [
                    'country' => $country,
                    'continent' => $this->timezone[0],
                    'activecountries' => $this->getActiveCountries()
                ];
            }
        } else {
            $country = $this->myLocation()->country;
            $this->page = 'Pricing';
            $this->name = session('name');
            $this->email = session('email');
            $data = [
                'country' => $country,
                'continent' => $this->timezone[0],
                'activecountries' => $this->getActiveCountries()
            ];
        }

        if ($req->get('country') != null) {
            $countrys = $req->get('country');
        } else {
            $countrys = $country;
        }


        $prices = $this->pricingFees($countrys);

        if (isset($prices)) {
            $pricings = $prices;
        } else {
            $pricings = $this->pricingFees('Canada');
        }

        $currency = $this->getCountryCode($countrys);


        if (isset($currency)) {
            $myCurrency = $currency->currencySymbol;
        } else {
            $myCurrency = "$";
        }


        $data['pricing'] = $pricings;
        $data['currency'] = $myCurrency;
        $data['maintenance'] = $this->maintenanceBalanceWithdrawal('Consumer Monthly Subscription', $countrys);


        return view('main.newpage.shade-pro.pricing')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }


    public function feeStructure2(Request $req)
    {



        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Merchant Pricing';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $country = Auth::user()->country;
                $data = array(
                    'country' => $country,
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                    'continent' => $this->timezone[0],
                    'activecountries' => $this->getActiveCountries()
                );
            } else {
                $country = $this->myLocation()->country;
                $this->page = 'Merchant Pricing';
                $this->name = '';
                $data = [
                    'country' => $country,
                    'continent' => $this->timezone[0],
                    'activecountries' => $this->getActiveCountries()
                ];
            }
        } else {
            $country = $this->myLocation()->country;
            $this->page = 'Merchant Pricing';
            $this->name = session('name');
            $this->email = session('email');
            $data = [
                'country' => $country,
                'continent' => $this->timezone[0],
                'activecountries' => $this->getActiveCountries()
            ];
        }

        if ($req->get('country') != null) {
            $countrys = $req->get('country');
        } else {
            $countrys = $country;
        }


        $prices = $this->pricingFees($countrys);

        if (isset($prices)) {
            $pricings = $prices;
        } else {
            $pricings = $this->pricingFees('Canada');
        }

        $currency = $this->getCountryCode($countrys);


        if (isset($currency)) {
            $myCurrency = $currency->currencySymbol;
        } else {
            $myCurrency = "$";
        }

        $data['pricing'] = $pricings;
        $data['currency'] = $myCurrency;
        $data['maintenance'] = $this->maintenanceBalanceWithdrawal('Merchant Monthly Subscription', $countrys);




        return view('main.newpage.shade-pro.pricing2')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }


    public function pricingFees($country)
    {
        $data = PricingSetup::where('country', $country)->first();

        return $data;
    }




    public function about(Request $req)
    {

        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'About';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;

                $data = array(
                    'sendReceive' => $this->sendAndReceive(Auth::user()->email),
                    'payInvoice' => $this->payInvoice(Auth::user()->email),
                    'walletTrans' => $this->sendAndReceive(Auth::user()->email),
                    'urgentnotification' => $this->urgentNotification(Auth::user()->email),
                    'currencyCode' => $this->getCountryCode(Auth::user()->country),
                    'getCard' => $this->getUserCard(),
                    'getBank' => $this->getUserBank(),
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                    'continent' => $this->timezone[0]
                );
            } else {
                $this->page = 'About';
                $this->name = '';
                $data = [
                    'continent' => $this->timezone[0]
                ];
            }
        } else {
            $this->page = 'About';
            $this->name = session('name');
            $this->email = session('email');
            $data = [];
        }

        return view('main.about')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }



    public function termsOfUse(Request $req)
    {

        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Terms of Use';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(

                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                    'continent' => $this->timezone[0]
                );
            } else {
                $this->page = 'Terms of Use';
                $this->name = '';
                $data = [
                    'continent' => $this->timezone[0]
                ];
            }
        } else {
            $this->page = 'Terms of Use';
            $this->name = session('name');
            $this->email = session('email');
            $data = [
                'continent' => $this->timezone[0]
            ];
        }

        return view('main.termofuse')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }





    public function privacyPolicy(Request $req)
    {

        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Privacy Policy';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(

                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                    'continent' => $this->timezone[0]
                );
            } else {
                $this->page = 'Privacy Policy';
                $this->name = '';
                $data = [
                    'continent' => $this->timezone[0]
                ];
            }
        } else {
            $this->page = 'Privacy Policy';
            $this->name = session('name');
            $this->email = session('email');
            $data = [
                'continent' => $this->timezone[0]
            ];
        }

        return view('main.privacy')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }


    public function payment(Request $req, $invoice)
    {



        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Payment';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
            } else {

                return redirect()->route('login');
            }
        } else {

            $user = User::where('email', session('email'))->first();

            Auth::login($user);

            $this->page = 'Payment';
            $this->name = Auth::user()->name;
            $this->email = Auth::user()->email;
        }

        $myinvoice = $this->getthisInvoice($invoice);

        if (isset($myinvoice)) {

            // International Transaction
            $merchant = User::where('ref_code', $myinvoice[0]->uploaded_by)->first();


            // Check if Invoice currency code is not null

            if ($myinvoice[0]->invoiced_currency != NULL) {

                if ($myinvoice[0]->remaining_balance > 0) {
                    if ($myinvoice[0]->invoiced_currency == Auth::user()->currencyCode) {
                        $totalInvoice = $myinvoice[0]->remaining_balance;
                        $totalAmt = $myinvoice[0]->total_amount;
                    } else {
                        $dataInfo = $this->convertCurrencyRate(Auth::user()->currencyCode, $myinvoice[0]->invoiced_currency, $myinvoice[0]->remaining_balance);
                        $dataTot = $this->convertCurrencyRate(Auth::user()->currencyCode, $myinvoice[0]->invoiced_currency, $myinvoice[0]->total_amount);

                        $totalInvoice = $dataInfo;
                        $totalAmt = $dataTot;
                    }
                } else {
                    $remBal = $myinvoice[0]->total_amount + $myinvoice[0]->remaining_balance;

                    if ($merchant->country != Auth::user()->country) {
                        $dataInfo = $this->convertCurrencyRate(Auth::user()->currencyCode, $myinvoice[0]->invoiced_currency, $remBal);
                        $dataTot = $this->convertCurrencyRate(Auth::user()->currencyCode, $myinvoice[0]->invoiced_currency, $myinvoice[0]->total_amount);
                        $totalInvoice = $dataInfo;
                        $totalAmt = $dataTot;
                    } else {
                        $totalInvoice = $remBal;
                        $totalAmt = $myinvoice[0]->total_amount;
                    }
                }
            } else {
                if ($myinvoice[0]->remaining_balance > 0) {
                    if ($merchant->country != Auth::user()->country) {
                        $dataInfo = $this->convertCurrencyRate(Auth::user()->currencyCode, $merchant->currencyCode, $myinvoice[0]->remaining_balance);
                        $dataTot = $this->convertCurrencyRate(Auth::user()->currencyCode, $merchant->currencyCode, $myinvoice[0]->total_amount);

                        $totalInvoice = $dataInfo;
                        $totalAmt = $dataTot;
                    } else {
                        $totalInvoice = $myinvoice[0]->remaining_balance;
                        $totalAmt = $myinvoice[0]->total_amount;
                    }
                } else {

                    $remBal = $myinvoice[0]->total_amount + $myinvoice[0]->remaining_balance;

                    if ($merchant->country != Auth::user()->country) {
                        $dataInfo = $this->convertCurrencyRate(Auth::user()->currencyCode, $merchant->currencyCode, $remBal);
                        $dataTot = $this->convertCurrencyRate(Auth::user()->currencyCode, $merchant->currencyCode, $myinvoice[0]->total_amount);
                        $totalInvoice = $dataInfo;
                        $totalAmt = $dataTot;
                    } else {
                        $totalInvoice = $remBal;
                        $totalAmt = $myinvoice[0]->total_amount;
                    }
                }
            }
        } else {
            $totalInvoice = 0;
            $totalAmt = 0;
        }


        $data = array(
            'getinvoice' => $this->getthisInvoice($invoice),
            'currencyCode' => $this->getCountryCode(Auth::user()->country),
            'continent' => $this->timezone[0],
            'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
            'remaining_invoice' => $totalInvoice,
            'total_invoice' => $totalAmt

        );

        // dd($data);



        return view('main.payment')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }


    public function paymentFromLink(Request $req, $invoice, $country)
    {


        // Get Invoice Details
        $invDetails = $this->getthisLinkInvoice($invoice, $country);

        $this->page = 'Payment';
        $this->name = $invDetails[0]->name;
        $this->email = $invDetails[0]->payee_email;




        if (isset($invDetails)) {
            // Proceed



            $getCurrencyCode = $this->getPaymentGateway(base64_decode($country));


            if (isset($getCurrencyCode)) {
                // International Transaction
                $merchant = User::where('ref_code', $invDetails[0]->uploaded_by)->first();

                if (isset($merchant)) {

                    if ($invDetails[0]->remaining_balance > 0) {
                        if ($merchant->country != base64_decode($country)) {
                            $dataInfo = $this->convertCurrencyRate($getCurrencyCode->currencyCode, $merchant->currencyCode, $invDetails[0]->remaining_balance);
                            $dataTot = $this->convertCurrencyRate($getCurrencyCode->currencyCode, $merchant->currencyCode, $invDetails[0]->total_amount);

                            $totalInvoice = $dataInfo;
                            $totalAmt = $dataTot;
                        } else {
                            $totalInvoice = $invDetails[0]->remaining_balance;
                            $totalAmt = $invDetails[0]->total_amount;
                        }
                    } else {

                        $remBal = $invDetails[0]->total_amount + $invDetails[0]->remaining_balance;

                        if ($merchant->country != base64_decode($country)) {
                            $dataInfo = $this->convertCurrencyRate($getCurrencyCode->currencyCode, $merchant->currencyCode, $remBal);
                            $dataTot = $this->convertCurrencyRate($getCurrencyCode->currencyCode, $merchant->currencyCode, $invDetails[0]->total_amount);
                            $totalInvoice = $dataInfo;
                            $totalAmt = $dataTot;
                        } else {
                            $totalInvoice = $remBal;
                            $totalAmt = $invDetails[0]->total_amount;
                        }
                    }

                    $data = array(
                        'getinvoice' => $this->getthisLinkInvoice($invoice, $country),
                        'currencyCode' => $this->getCountryCode($getCurrencyCode->name),
                        'continent' => $this->timezone[0],
                        'remaining_invoice' => $totalInvoice,
                        'total_invoice' => $totalAmt

                    );



                    return view('main.paymentlink')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
                } else {
                    // Redirect to Login
                    return redirect()->route('epsresponseback')->with('error', 'Unable to detect your country. Invoice payment cannot be processed');
                }
            } else {
                // Redirect to Login
                return redirect()->route('epsresponseback')->with('error', 'Unable to detect your country. Invoice payment cannot be processed');
            }
        } else {
            // Redirect to Login
            return redirect()->route('login');
        }
    }


    public function paymentOrganization(Request $req, $user_id)
    {


        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Payment';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
            } else {

                return redirect()->route('login');
            }
        } else {

            $user = User::where('email', session('email'))->first();

            Auth::login($user);

            $this->page = 'Payment';
            $this->name = Auth::user()->name;
            $this->email = Auth::user()->email;
        }

        $data = array(
            'paymentorg' => $this->getthisOrganization($user_id),
            'currencyCode' => $this->getCountryCode(Auth::user()->country),
            'othercurrencyCode' => $this->otherCurrencyCodeOfficial($user_id),
            'getCard' => $this->getUserCard(),
            'getBank' => $this->getUserBank(),
            'continent' => $this->timezone[0]
        );





        return view('main.paymentorganization')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }


    public function estorePayment(Request $req)
    {


        $getMerchant = User::where('id', $req->merchantId)->first();
        $getMerchantKey = ClientInfo::where('user_id', $getMerchant->ref_code)->first();


        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Payment';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
            } else {

                return redirect()->route('login');
            }
        } else {

            $user = User::where('email', session('email'))->first();

            Auth::login($user);

            $this->page = 'Payment';
            $this->name = Auth::user()->name;
            $this->email = Auth::user()->email;
        }

        $data = array(
            'paymentorg' => $this->getthisOrganization($getMerchant->ref_code),
            'currencyCode' => $this->getCountryCode($req->country),
            'othercurrencyCode' => $this->otherCurrencyCodeOfficial($getMerchant->ref_code),
            'getOrder' => $this->getOrders($req->merchantId, $req->userId),
            'getCart' => $this->getPayCartList($req->userId, $req->merchantId),
            'continent' => $this->timezone[0],
            'merchantApiKey' => $getMerchantKey->api_secrete_key,
            'merchantMainApiKey' => $getMerchant->api_token,
            'paymentgateway' => $this->getPaymentGateway($req->country),
            'storeTax' => $this->getStoreTax($getMerchant->id)
        );






        return view('main.paymentestore')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }


    public function createnewPayment(Request $req)
    {


        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Payment';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
            } else {
                $this->page = 'Payment';
                $this->name = '';
            }
        } else {
            $this->page = 'Payment';
            $this->name = session('name');
            $this->email = session('email');
        }

        $data = array(
            'currencyCode' => $this->getCountryCode(Auth::user()->country),
            'getCard' => $this->getUserCard(),
            'getBank' => $this->getUserBank(),
            'continent' => $this->timezone[0]
        );

        // dd($data);


        return view('main.createnewpayment')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
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


    public function getUserCard()
    {

        $data = AddCard::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->get();

        return $data;
    }

    public function getUserBank()
    {

        $data = AddBank::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->get();

        return $data;
    }

    public function getPaymentGateway($country)
    {

        $data = AllCountries::where('name', $country)->first();

        return $data;
    }

    public function getActiveCountries()
    {
        $data = AllCountries::where('approval', 1)->orderBy('name', 'ASC')->get();

        return $data;
    }

    public function getCardIssuer()
    {

        $data = CardIssuer::orderBy('created_at', 'DESC')->get();

        return $data;
    }

    public function getUserBankDetail()
    {

        $data = AddBank::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->get();

        return $data;
    }

    public function getthisCard($id)
    {

        $data = AddCard::where('id', $id)->first();

        return $data;
    }


    public function getthisBank($id)
    {

        $data = AddBank::where('id', $id)->first();

        return $data;
    }


    public function walletStatement()
    {

        $data = Statement::where('user_id', Auth::user()->email)->where('statement_route', 'wallet')->orderBy('created_at', 'DESC')->get();

        return $data;
    }


    public function receiveMoney(Request $req, $id)
    {

        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Receive Money';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
            } else {
                $this->page = 'Receive Money';
                $this->name = '';
            }
        } else {
            $this->page = 'Receive Money';
            $this->name = session('name');
            $this->email = session('email');
        }


        $data = array(
            'getpay' => $this->getthispayment($id),
            'currencyCode' => $this->getCountryCode(Auth::user()->country),
            'continent' => $this->timezone[0]
        );

        // dd($data);

        return view('main.receivepayment')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }


    public function cashAdvance(Request $req)
    {

        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Cash Advance';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
            } else {
                $this->page = 'Cash Advance';
                $this->name = '';
            }
        } else {

            $user = User::where('email', session('email'))->first();

            Auth::login($user);

            $this->page = 'Cash Advance';
            $this->name = Auth::user()->name;
            $this->email = Auth::user()->email;
        }

        // $client = $this->getMyClientInfo(Auth::user()->ref_code);

        // Insert Record for cash advance and redirect to cash advance page

        if (Auth::user()->country != 'Canada') {

            $resData = "Your country is not eligible for this feature";
            $resp = "error";

            return redirect()->back()->with($resp, $resData);
        }

        CashAdvance::updateOrInsert([
            'merchantId' => Auth::user()->id
        ], [
            'merchantId' => Auth::user()->id
        ]);

        return redirect('https://new.merchantgrowth.com/welcome?userId=0052M000009XOtY');
    }





    public function myAccount(Request $req)
    {


        if (Auth::user()->accountType == "Individual") {
            if ($req->session()->has('email') == false) {
                if (Auth::check() == true) {
                    $this->page = 'My Wallet';
                    $this->name = Auth::user()->name;
                    $this->email = Auth::user()->email;
                } else {
                    $this->page = 'My Wallet';
                    $this->name = '';
                }
            } else {
                $this->page = 'My Wallet';
                $this->name = session('name');
                $this->email = session('email');
            }


            $data = array(
                'currencyCode' => $this->getCountryCode(Auth::user()->country),
                'getCard' => $this->getUserCard(),
                'getBank' => $this->getUserBankDetail(),
                'walletStatement' => $this->walletStatement(),
                'continent' => $this->timezone[0],
                'specialInfo' => $this->getthisInfo(Auth::user()->country),
                'idvchecks' => $this->checkUsersPassAccount(Auth::user()->id),
            );

            // dd($data);
        } else {
            return redirect()->route('dashboard');
        }



        return view('main.myaccount')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }


    public function expressResponseback(Request $req)
    {

        $data = [];

        return view('main.messages')->with(['data' => $data]);
    }


    // PaySprint Currency FX
    public function paysprintFx(Request $req)
    {


        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'My Wallet';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
            } else {
                $this->page = 'My Wallet';
                $this->name = '';
            }
        } else {
            $this->page = 'My Wallet';
            $this->name = session('name');
            $this->email = session('email');
        }


        $data = array(
            'currencyCode' => $this->getCountryCode(Auth::user()->country),
            'getCard' => $this->getUserCard(),
            'getBank' => $this->getUserBankDetail(),
            'walletStatement' => $this->walletStatement(),
            'continent' => $this->timezone[0],
            'specialInfo' => $this->getthisInfo(Auth::user()->country),
        );

        // dd($data);

        return view('main.currencyfx')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }


    public function addCard(Request $req)
    {

        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'My Card';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
            } else {
                $this->page = 'My Card';
                $this->name = '';
            }
        } else {
            $this->page = 'My Card';
            $this->name = session('name');
            $this->email = session('email');
        }


        $data = array(
            'getCard' => $this->getUserCard(),
            'getBank' => $this->getUserBank(),
            'cardIssuer' => $this->getCardIssuer(),
            'continent' => $this->timezone[0]
        );


        return view('main.mycard')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }


    public function paymentGateway(Request $req)
    {

        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Payment Gateway';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
            } else {
                $this->page = 'Payment Gateway';
                $this->name = '';
            }
        } else {
            $this->page = 'Payment Gateway';
            $this->name = session('name');
            $this->email = session('email');
        }


        $data = array(
            'getCard' => $this->getUserCard(),
            'getBank' => $this->getUserBank(),
            'cardIssuer' => $this->getCardIssuer(),
            'continent' => $this->timezone[0]
        );


        return view('main.gateway')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }



    public function requestExbcCard(Request $req)
    {

        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Request Exbc Card';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
            } else {
                $this->page = 'Request Exbc Card';
                $this->name = '';
            }
        } else {
            $this->page = 'Request Exbc Card';
            $this->name = session('name');
            $this->email = session('email');
        }


        $data = array(
            'getCard' => $this->getUserCard(),
            'getBank' => $this->getUserBank(),
            'continent' => $this->timezone[0]
        );


        return view('main.requestexbccard')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }


    public function editCard(Request $req, $id)
    {

        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'My Card';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
            } else {
                $this->page = 'My Card';
                $this->name = '';
            }
        } else {
            $this->page = 'My Card';
            $this->name = session('name');
            $this->email = session('email');
        }


        $data = array(
            'getthisCard' => $this->getthisCard($id),
            'cardIssuer' => $this->getCardIssuer(),
            'continent' => $this->timezone[0]
        );


        return view('main.editcard')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }




    public function editBank(Request $req, $id)
    {

        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'My Bank Account';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
            } else {
                $this->page = 'My Bank Account';
                $this->name = '';
            }
        } else {
            $this->page = 'My Bank Account';
            $this->name = session('name');
            $this->email = session('email');
        }


        $data = array(
            'getthisBank' => $this->getthisBank($id),
            'continent' => $this->timezone[0]
        );


        return view('main.editbank')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }


    public function addMoney(Request $req)
    {


        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Add Money To Wallet';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
            } else {
                $this->page = 'Add Money To Wallet';
                $this->name = '';
            }
        } else {
            $this->page = 'Add Money To Wallet';
            $this->name = session('name');
            $this->email = session('email');
        }


        $data = array(
            'currencyCode' => $this->getCountryCode(Auth::user()->country),
            'getCard' => $this->getUserCard(),
            'getBank' => $this->getUserBank(),
            'continent' => $this->timezone[0],
            'paymentgateway' => $this->getPaymentGateway(Auth::user()->country)
        );




        return view('main.addmoneytowallet')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }


    public function processMoney(Request $req)
    {
        dd($req->all());
        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Add Money To Wallet';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
            } else {
                $this->page = 'Add Money To Wallet';
                $this->name = '';
            }
        } else {
            $this->page = 'Add Money To Wallet';
            $this->name = session('name');
            $this->email = session('email');
        }

        $usernames = explode(" ", base64_decode($req->name));
        $encAmount = base64_decode($req->amount);
        $amount = round($encAmount, 2);
        $email = base64_decode($req->email);
        $name = base64_decode($req->name);
        $api_token = base64_decode($req->api_token);
        $transactionId = base64_decode($req->transactionId);

        $commissiondeduct = base64_decode($req->commissiondeduct);
        $conversionamount = base64_decode($req->conversionamount);
        $commission = base64_decode($req->commission);
        $amounttosend = base64_decode($req->amounttosend);
        $currencyCode = base64_decode($req->currencyCode);

        $phoneNumber = '234' . ltrim(base64_decode($req->phone), '0');

        $data = array(
            'currencyCode' => $this->getCountryCode(Auth::user()->country),
            'getCard' => $this->getUserCard(),
            'getBank' => $this->getUserBank(),
            'continent' => $this->timezone[0],
            'paymentgateway' => $this->getPaymentGateway(Auth::user()->country),
            'hash' => $this->generateHash($amount, $email, $usernames[0], $usernames[1], $transactionId, $phoneNumber, $api_token, $commissiondeduct, $amounttosend, $currencyCode, $conversionamount, $commission),
            'amount' => $amount,
            'email' => $email,
            'name' => $name,
            'transactionId' => $transactionId,
            'phone' => $phoneNumber,
            'api_token' => $api_token,
            'firstname' => $usernames[0],
            'lastname' => $usernames[1],
            'api_token' => $api_token
        );




        return view('main.processmoneytowallet')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }


    public function withdrawMoney(Request $req)
    {

        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Withdraw Money';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
            } else {
                $this->page = 'Withdraw Money';
                $this->name = '';
            }
        } else {
            $this->page = 'Withdraw Money';
            $this->name = session('name');
            $this->email = session('email');
        }

        $client = $this->getMyClientInfo(Auth::user()->ref_code);

        if (isset($client) && $client->accountMode == "test") {

            return redirect()->route('dashboard')->with('error', 'You are in test mode');
        }


        $data = array(
            'currencyCode' => $this->getCountryCode(Auth::user()->country),
            'getCard' => $this->getUserCard(),
            'getBank' => $this->getUserBank(),
            'continent' => $this->timezone[0]
        );


        return view('main.withdrawmoney')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }


    public function addBankDetail(Request $req)
    {

        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Add Bank Detail';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
            } else {
                $this->page = 'Add Bank Detail';
                $this->name = '';
            }
        } else {
            $this->page = 'Add Bank Detail';
            $this->name = session('name');
            $this->email = session('email');
        }


        $data = array(
            'currencyCode' => $this->getCountryCode(Auth::user()->country),
            'getBankDetail' => $this->getUserBankDetail(),
            'listbank' => $this->getBankList(),
            'continent' => $this->timezone[0]
        );


        return view('main.addbankdetail')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }



    public function requestForRefund(Request $req)
    {

        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Request For Refund';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
            } else {
                $this->page = 'Request For Refund';
                $this->name = '';
            }
        } else {
            $this->page = 'Request For Refund';
            $this->name = session('name');
            $this->email = session('email');
        }


        $data = array(
            'currencyCode' => $this->getCountryCode(Auth::user()->country),
            'getBankDetail' => $this->getUserBankDetail(),
            'continent' => $this->timezone[0]
        );


        return view('main.requestforrefund')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }


    public function allNotifications(Request $req)
    {

        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Notifications';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
            } else {
                $this->page = 'Notifications';
                $this->name = '';
            }
        } else {
            $this->page = 'Notifications';
            $this->name = session('name');
            $this->email = session('email');
        }


        $data = array(
            'currencyCode' => $this->getCountryCode(Auth::user()->country),
            'getNotifications' => $this->getUserNotifications(Auth::user()->ref_code),
            'updateNotification' => $this->updateNotification(Auth::user()->ref_code),
            'continent' => $this->timezone[0]
        );


        return view('main.allnotifications')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }


    public function merchantCategory(Request $req)
    {
        $service = $req->get('service');

        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Merchant By Services';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
            } else {
                $this->page = 'Merchant By Services';
                $this->name = '';
            }
        } else {
            $this->page = 'Merchant By Services';
            $this->name = session('name');
            $this->email = session('email');
        }


        $data = array(
            'currencyCode' => $this->getCountryCode(Auth::user()->country),
            'getNotifications' => $this->getUserNotifications(Auth::user()->ref_code),
            'getMerchantHere' => $this->getMerchantHere($service),
            'continent' => $this->timezone[0]
        );


        return view('main.merchantcategory')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }



    public function allMerchantCategory(Request $req)
    {
        $service = $req->get('service');

        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Merchant By Services';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
            } else {
                $this->page = 'Merchant By Services';
                $this->name = '';
            }
        } else {
            $this->page = 'Merchant By Services';
            $this->name = session('name');
            $this->email = session('email');
        }


        $data = array(
            'currencyCode' => $this->getCountryCode(Auth::user()->country),
            'getNotifications' => $this->getUserNotifications(Auth::user()->ref_code),
            'getMerchantHere' => $this->getMerchantHere($service),
            'allMerchants' => $this->getAllMerchantsByCategory(),
            'continent' => $this->timezone[0]
        );


        return view('main.allmerchantcategory')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }



    public function selectCountryUtilityBills(Request $req)
    {

        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Airtime and Utility Bills';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
            } else {
                // $this->page = 'Airtime and Utility Bills';
                // $this->name = '';

                return redirect()->route('login');
            }
        } else {

            $user = User::where('email', session('email'))->first();

            Auth::login($user);

            $this->page = 'Airtime and Utility Bills';
            $this->name = Auth::user()->name;
            $this->email = Auth::user()->email;
        }

        $client = $this->getMyClientInfo(Auth::user()->ref_code);


        if (isset($client) && $client->accountMode == "test") {

            return redirect()->route('dashboard')->with('error', 'You are in test mode');
        }



        $data = array(
            'continent' => $this->timezone[0],
            'countryApproval' => AllCountries::where('approval', 1)->orderBy('created_at', 'DESC')->get()
        );


        return view('main.selectutilitycountry')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }


    public function expressUtilities(Request $req)
    {

        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Airtime and Utility Bills';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
            } else {
                // $this->page = 'Airtime and Utility Bills';
                // $this->name = '';

                return redirect()->route('login');
            }
        } else {

            $user = User::where('email', session('email'))->first();

            Auth::login($user);

            $this->page = 'Airtime and Utility Bills';
            $this->name = Auth::user()->name;
            $this->email = Auth::user()->email;
        }

        $client = $this->getMyClientInfo(Auth::user()->ref_code);

        if (isset($client) && $client->accountMode == "test") {

            return redirect()->route('dashboard')->with('error', 'You are in test mode');
        }


        $data = array(
            'currencyCode' => $this->getCountryCode(Auth::user()->country),
            'getNotifications' => $this->getUserNotifications(Auth::user()->ref_code),
            'getvendors' => $this->getVendors(),
            'continent' => $this->timezone[0]
        );

        if ($data['getvendors'] != []) {
            return view('main.payutility')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
        } else {
            return view('errors.503page');
        }
    }



    public function expressBuyUtilities(Request $req, $id)
    {

        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Airtime and Utility Bills';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
            } else {
                $this->page = 'Airtime and Utility Bills';
                $this->name = '';
            }
        } else {
            $this->page = 'Airtime and Utility Bills';
            $this->name = session('name');
            $this->email = session('email');

            $user = User::where('email', session('email'))->first();

            Auth::login($user);
        }

        if (Auth::check() == true) {
            $data = array(
                'currencyCode' => $this->getCountryCode(Auth::user()->country),
                'getNotifications' => $this->getUserNotifications(Auth::user()->ref_code),
                'getutilityproduct' => $this->getUtilityProduct($id),
                'getCard' => $this->getUserCard(),
                'getBank' => $this->getUserBank(),
                'continent' => $this->timezone[0]
            );
        } else {
            return redirect()->route('login');
        }


        return view('main.buyutility')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }


    public function getMerchantHere($service)
    {
        $data = ClientInfo::where('industry', $service)->where('country', Auth::user()->country)->orderBy('created_at', 'DESC')->get();

        return $data;
    }
    public function getUserNotifications($ref_code)
    {
        $data = Notifications::where('ref_code', $ref_code)->orderBy('created_at', 'DESC')->get();

        return $data;
    }


    public function getfiveUserNotifications($ref_code)
    {
        $data = Notifications::where('ref_code', $ref_code)->latest()->take(5)->get();

        return $data;
    }

    public function getallRPM($country)
    {
        $data = Building::where('buildinglocation_country', $country)->orderBy('created_at', 'DESC')->get();

        return $data;
    }

    public function getMyFacility($email)
    {

        $data = Building::where('owner_email', $email)->orderBy('created_at', 'DESC')->get();

        return $data;
    }

    public function getMerchantsByCategory()
    {
        $data = ClientInfo::where('industry', '!=', null)->where('country', Auth::user()->country)->orderBy('industry', 'ASC')->groupBy('industry')->take(8)->get();

        return $data;
    }

    public function getAllMerchantsByCategory()
    {
        $data = ClientInfo::where('industry', '!=', null)->where('country', Auth::user()->country)->orderBy('industry', 'ASC')->groupBy('industry')->get();

        return $data;
    }

    public function updateNotification($ref_code)
    {
        $data = Notifications::where('ref_code', $ref_code)->update(['notify' => 1, 'platform' => 'web']);

        return $data;
    }

    public function getthispayment($id)
    {

        $data = DB::table('organization_pay')
            ->select(DB::raw('organization_pay.id as orgId, organization_pay.purpose, organization_pay.amount_to_send, organization_pay.amountindollars, users.*'))
            ->join('users', 'organization_pay.payer_id', '=', 'users.ref_code')->where('organization_pay.id', $id)->where('organization_pay.request_receive', '!=', 2)->first();

        return $data;
    }


    public function getthisOrganization($user_id)
    {

        // Get User

        // $orgDetail = ClientInfo::where('user_id', $user_id)->get();
        $orgDetail = User::where('ref_code', $user_id)->first();

        return $orgDetail;
    }

    public function otherCurrencyCode($user_id)
    {
        $userData = User::where('ref_code', $user_id)->first();

        $data = $this->getCountryCode($userData->country);

        $data['conversionrate'] = $this->getConversionRate(Auth::user()->currencyCode, $data->currencyCode);

        $resp = [
            'data' => $data,
            'conversionrate' => $data['conversionrate'],
        ];


        return $resp;
    }


    public function otherCurrencyCodeOfficial($user_id)
    {
        $userData = User::where('ref_code', $user_id)->first();

        $data = $this->getCountryCode($userData->country);

        $data['conversionrate'] = $this->getOfficialConversionRate(Auth::user()->currencyCode, $data->currencyCode);

        $resp = [
            'data' => $data,
            'conversionrate' => $data['conversionrate'],
        ];


        return $resp;
    }


    public function getthisInvoice($invoice)
    {
        $getInvoice = DB::table('import_excel')
            ->select(DB::raw('import_excel.name as name, import_excel.payee_ref_no, import_excel.payee_email as payee_email, import_excel.service as service, invoice_payment.remaining_balance as remaining_balance, import_excel.amount as amount, import_excel.uploaded_by, import_excel.invoice_no, import_excel.tax_amount, import_excel.total_amount, import_excel.installpay, import_excel.installlimit, import_excel.installcount, invoice_payment.amount as amount_paid'))
            ->join('invoice_payment', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')
            ->where('import_excel.invoice_no', $invoice)
            ->orderBy('invoice_payment.created_at', 'DESC')
            ->get();

        if (count($getInvoice) > 0) {
            $data = $getInvoice;
        } else {
            $data = ImportExcel::where('invoice_no', $invoice)->get();
        }

        return $data;
    }

    // public function getClaimedHistory($user_id)
    // {
    //     $data = HistoryReport::where('user_id', $user_id)->get();

    //     return $data;
    // }


    public function getthisLinkInvoice($invoice, $country)
    {
        $getInvoice = DB::table('import_excel_link')
            ->select(DB::raw('import_excel_link.name as name, import_excel_link.payee_ref_no, import_excel_link.payee_email as payee_email, import_excel_link.service as service, invoice_payment.remaining_balance as remaining_balance, import_excel_link.amount as amount, import_excel_link.uploaded_by, import_excel_link.invoice_no, import_excel_link.tax_amount, import_excel_link.total_amount, import_excel_link.installpay, import_excel_link.installlimit, import_excel_link.installcount, import_excel_link.merchantName, invoice_payment.amount as amount_paid'))
            ->join('invoice_payment', 'import_excel_link.invoice_no', '=', 'invoice_payment.invoice_no')
            ->where('import_excel_link.invoice_no', $invoice)
            ->where('import_excel_link.country', base64_decode($country))
            ->orderBy('invoice_payment.created_at', 'DESC')
            ->get();

        if (count($getInvoice) > 0) {
            $data = $getInvoice;
        } else {
            $data = ImportExcelLink::where('invoice_no', $invoice)->where('country', base64_decode($country))->get();
        }

        return $data;
    }

    public function invoice(Request $req)
    {
        // dd($req->session());
        if ($req->session()->has('email') == false) {

            if (Auth::check() == true) {
                $this->page = 'Invoice';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                    'continent' => $this->timezone[0]
                );
            } else {
                return redirect()->route('login');
            }
        } else {

            $user = User::where('email', session('email'))->first();

            Auth::login($user);

            $this->page = 'Invoice';
            $this->name = Auth::user()->name;
            $this->email = Auth::user()->email;

            $data = array(
                'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                'continent' => $this->timezone[0]
            );
        }



        $service = $this->myServices();

        return view('main.invoice')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'service' => $service, 'data' => $data]);
    }

    public function statement(Request $req)
    {

        

        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Statement';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                    'service' => $this->myServices(),
                    'continent' => $this->timezone[0]
                );
            } else {
                $this->page = 'Statement';
                $this->name = '';
                $data = [
                    'continent' => $this->timezone[0]
                ];
            }
        } else {
            $this->page = 'Statement';
            $this->name = session('name');
            $this->email = session('email');
            $data = [
                'continent' => $this->timezone[0]
            ];
        }

        return view('main.statement')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }



    public function rentalManagement(Request $req)
    {


        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Rental Property Management';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                    'getRPM' => $this->getallRPM(Auth::user()->country),
                    'continent' => $this->timezone[0]
                );
            } else {
                // $this->page = 'Rental Property Management';
                // $this->name = '';
                // $data = [];

                return redirect()->route('login');
            }
        } else {
            $user = User::where('email', session('email'))->first();

            Auth::login($user);

            $this->page = 'Rental Property Management';
            $this->name = Auth::user()->name;
            $this->email = Auth::user()->email;
            $data = array(
                'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                'getRPM' => $this->getallRPM(Auth::user()->country),
                'continent' => $this->timezone[0]
            );
        }

        return view('main.rentalmanagement')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }


    public function myRentalManagementFacility(Request $req, $email)
    {


        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Rental Property Management';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                    'continent' => $this->timezone[0],
                    'getmyfacility' => $this->getMyFacility(base64_decode($email)),
                );
            } else {
                // $this->page = 'Rental Property Management';
                // $this->name = '';
                // $data = [];

                return redirect()->route('login');
            }
        } else {
            $user = User::where('email', session('email'))->first();

            Auth::login($user);

            $this->page = 'Rental Property Management';
            $this->name = Auth::user()->name;
            $this->email = Auth::user()->email;
            $data = array(
                'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                'continent' => $this->timezone[0],
                'getmyfacility' => $this->getMyFacility(base64_decode($email)),
            );
        }

        return view('main.myrentalmanagementfacility')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }

    public function deleteProperty(Request $request)
    {
        try {
            $data = Building::where('id', $request->facilityid)->delete();

            if (isset($data)) {
                $resData = "Successfully deleted!";
                $resp = "success";
            } else {
                $resData = "Cannot delete property";
                $resp = "error";
            }
        } catch (\Throwable $th) {
            $resData = $th->getMessage();
            $resp = "error";
        }

        return redirect()->back()->with($resp, $resData);
    }


    public function rentalManagementStart(Request $req)
    {


        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Rental Property Management';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                    'continent' => $this->timezone[0]
                );
            } else {
                // $this->page = 'Rental Property Management';
                // $this->name = '';
                // $data = [];

                return redirect()->route('login');
            }
        } else {
            $user = User::where('email', session('email'))->first();

            Auth::login($user);

            $this->page = 'Rental Property Management';
            $this->name = Auth::user()->name;
            $this->email = Auth::user()->email;
            $data = array(
                'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                'continent' => $this->timezone[0]
            );
        }

        return view('main.rentalmanagementstart')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }


    public function rentalManagementAdminStart(Request $req)
    {


        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Rental Property Management for Property Owner';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                    'continent' => $this->timezone[0]
                );
            } else {
                // $this->page = 'Rental Property Management for Property Owner';
                // $this->name = '';
                // $data = [];

                return redirect()->route('login');
            }
        } else {
            $user = User::where('email', session('email'))->first();

            Auth::login($user);

            $this->page = 'Rental Property Management for Property Owner';
            $this->name = Auth::user()->name;
            $this->email = Auth::user()->email;
            $data = array(
                'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                'continent' => $this->timezone[0]
            );
        }

        return view('main.rentalmanagementstart')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }


    public function rentalManagementAdmin(Request $req)
    {

        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Rental Property Management for Property Owner';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                    'continent' => $this->timezone[0]
                );
            } else {
                // $this->page = 'Rental Property Management for Property Owner';
                // $this->name = '';
                // $data = [];

                return redirect()->route('login');
            }
        } else {

            $user = User::where('email', session('email'))->first();


            Auth::login($user);


            $this->page = 'Rental Property Management for Property Owner';
            $this->name = Auth::user()->name;
            $this->email = Auth::user()->email;
            $data = array(
                'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                'continent' => $this->timezone[0]
            );
        }

        return view('main.rentalmanagementadmin')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }


    public function rentalManagementConsultant(Request $req, Consultant $consultant)
    {

        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Rental Property Management for Service Providers';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                    'continent' => $this->timezone[0]
                );
            } else {
                // $this->page = 'Rental Property Management for Service Providers';
                // $this->name = '';
                // $data = [];

                return redirect()->route('login');
            }
        } else {

            $user = User::where('email', session('email'))->first();

            Auth::login($user);

            $this->page = 'Rental Property Management for Service Providers';
            $this->name = Auth::user()->name;
            $this->email = Auth::user()->email;
            $data = array(
                'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                'continent' => $this->timezone[0]
            );
        }

        $getId = $consultant->where('consultant_email', $this->email)->get();

        if (count($getId) > 0) {
            $id = $getId[0]->id;
        } else {
            // Route to EXBC
            $resData = "No maintenance assigned to you yet";
            $resp = "error";
            return redirect()->back()->with($resp, $resData);
        }


        return view('main.rentalmanagementconsultant')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'id' => $id, 'data' => $data]);
    }



    public function rentalManagementConsultantWorkorder(Request $req)
    {

        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Rental Property Management for Service Providers';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                    'continent' => $this->timezone[0]
                );
            } else {
                // $this->page = 'Rental Property Management for Service Providers';
                // $this->name = '';
                // $data = [];

                return redirect()->route('login');
            }
        } else {

            $user = User::where('email', session('email'))->first();

            Auth::login($user);

            $this->page = 'Rental Property Management for Service Providers';
            $this->name = Auth::user()->name;
            $this->email = Auth::user()->email;
            $data = array(
                'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                'continent' => $this->timezone[0]
            );
        }


        $statuschecker = $this->workorderCheck($this->email, $req->get('s'));

        return view('main.rentalmanagementworkorder')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'statuschecker' => $statuschecker, 'data' => $data]);
    }


    public function rentalManagementConsultantMymaintnenance(Request $req, $id)
    {

        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Rental Property Management for Service Providers';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                    'continent' => $this->timezone[0]
                );
            } else {
                // $this->page = 'Rental Property Management for Service Providers';
                // $this->name = '';
                // $data = [];

                return redirect()->route('login');
            }
        } else {

            $user = User::where('email', session('email'))->first();

            Auth::login($user);

            $this->page = 'Rental Property Management for Service Providers';
            $this->name = Auth::user()->name;
            $this->email = Auth::user()->email;
            $data = array(
                'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                'continent' => $this->timezone[0]
            );
        }


        $maintdetail = $this->consultmaintenanceDetail($id);

        return view('main.rentalmanagementmymaintenance')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'maintdetail' => $maintdetail, 'data' => $data]);
    }


    public function rentalManagementConsultantMaintenance(Request $req, $id)
    {

        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Rental Property Management for Service Providers';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                    'continent' => $this->timezone[0]
                );
            } else {
                // $this->page = 'Rental Property Management for Service Providers';
                // $this->name = '';
                // $data = [];

                return redirect()->route('login');
            }
        } else {

            $user = User::where('email', session('email'))->first();

            Auth::login($user);

            $this->page = 'Rental Property Management for Service Providers';
            $this->name = Auth::user()->name;
            $this->email = Auth::user()->email;
            $data = array(
                'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                'continent' => $this->timezone[0]
            );
        }


        $statuschecker = $this->workorderCheck($this->email, $req->get('s'));
        $maintdetail = $this->maintenanceDetail($id);

        return view('main.rentalmanagementmaintenance')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'statuschecker' => $statuschecker, 'maintdetail' => $maintdetail, 'data' => $data]);
    }


    public function rentalManagementConsultantInvoice(Request $req, $id)
    {

        // dd(Session::all());

        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Rental Property Management for Service Providers';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                    'continent' => $this->timezone[0]
                );
            } else {
                // $this->page = 'Rental Property Management for Service Providers';
                // $this->name = '';
                // $data = [];

                return redirect()->route('login');
            }
        } else {

            $user = User::where('email', session('email'))->first();

            Auth::login($user);

            $this->page = 'Rental Property Management for Service Providers';
            $this->name = Auth::user()->name;
            $this->email = Auth::user()->email;
            $data = array(
                'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                'continent' => $this->timezone[0]
            );
        }


        $statuschecker = $this->workorderCheck($this->email, $req->get('s'));
        $maintdetail = $this->maintenanceDetail($id);

        return view('main.rentalmanagementinvoice')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'statuschecker' => $statuschecker, 'maintdetail' => $maintdetail, 'data' => $data]);
    }


    public function rentalManagementConsultantQuote(Request $req, $id)
    {

        // dd(Session::all());

        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Rental Property Management for Service Providers';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                    'continent' => $this->timezone[0]
                );
            } else {
                // $this->page = 'Rental Property Management for Service Providers';
                // $this->name = '';
                // $data = [];

                return redirect()->route('login');
            }
        } else {

            $user = User::where('email', session('email'))->first();

            Auth::login($user);

            $this->page = 'Rental Property Management for Service Providers';
            $this->name = Auth::user()->name;
            $this->email = Auth::user()->email;
            $data = array(
                'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                'continent' => $this->timezone[0]
            );
        }


        $statuschecker = $this->workorderCheck($this->email, $req->get('s'));
        $maintdetail = $this->maintenanceDetail($id);

        return view('main.rentalmanagementquote')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'statuschecker' => $statuschecker, 'maintdetail' => $maintdetail, 'data' => $data]);
    }


    public function rentalManagementConsultantNegotiate(Request $req, $id)
    {

        // dd(Session::all());

        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Rental Property Management for Service Providers';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                    'continent' => $this->timezone[0]
                );
            } else {
                // $this->page = 'Rental Property Management for Service Providers';
                // $this->name = '';
                // $data = [];

                return redirect()->route('login');
            }
        } else {
            $user = User::where('email', session('email'))->first();

            Auth::login($user);

            $this->page = 'Rental Property Management for Service Providers';
            $this->name = Auth::user()->name;
            $this->email = Auth::user()->email;
            $data = array(
                'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                'continent' => $this->timezone[0]
            );
        }


        $statuschecker = $this->workorderCheck($this->email, $req->get('s'));
        $viewquotedetail = $this->quoteDetail($id);

        return view('main.rentalmanagementnegotiate')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'statuschecker' => $statuschecker, 'viewquotedetail' => $viewquotedetail, 'data' => $data]);
    }


    public function rentalManagementAdminfacility(Request $req)
    {

        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Rental Property Management for Property Owner';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                    'continent' => $this->timezone[0]
                );
            } else {
                // $this->page = 'Rental Property Management for Property Owner';
                // $this->name = '';
                // $data = [];

                return redirect()->route('login');
            }
        } else {

            $user = User::where('email', session('email'))->first();

            Auth::login($user);

            $this->page = 'Rental Property Management for Property Owner';
            $this->name = Auth::user()->name;
            $this->email = Auth::user()->email;
            $data = array(
                'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                'continent' => $this->timezone[0]
            );
        }

        return view('main.rentalmanagementadminfacility')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }


    public function rentalManagementAdmineditconsultant(Request $req, $id)
    {

        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Rental Property Management for Property Owner';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                    'continent' => $this->timezone[0]
                );
            } else {
                // $this->page = 'Rental Property Management for Property Owner';
                // $this->name = '';
                // $data = [];

                return redirect()->route('login');
            }
        } else {

            $user = User::where('email', session('email'))->first();

            Auth::login($user);

            $this->page = 'Rental Property Management for Property Owner';
            $this->name = Auth::user()->name;
            $this->email = Auth::user()->email;
            $data = array(
                'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                'continent' => $this->timezone[0]
            );
        }

        $consultant = $this->consultantCheck($id);

        return view('main.rentalmanagementadminconsultantedit')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'consultant' => $consultant, 'data' => $data]);
    }


    public function rentalManagementAdminconsultant(Request $req)
    {

        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Rental Property Management for Property Owner';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                    'continent' => $this->timezone[0]
                );
            } else {
                // $this->page = 'Rental Property Management for Property Owner';
                // $this->name = '';
                // $data = [];

                return redirect()->route('login');
            }
        } else {

            $user = User::where('email', session('email'))->first();

            Auth::login($user);

            $this->page = 'Rental Property Management for Property Owner';
            $this->name = Auth::user()->name;
            $this->email = Auth::user()->email;
            $data = array(
                'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                'continent' => $this->timezone[0]
            );
        }

        return view('main.rentalmanagementadminconsultant')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }


    public function rentalManagementassignconsultant(Request $req, Consultant $consultant, MaintenanceRequest $maintenance, $id)
    {




        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Rental Property Management for Property Owner';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $ref_code = Auth::user()->ref_code;
            } else {
                // $this->page = 'Rental Property Management for Property Owner';
                // $this->name = '';
                // $ref_code = 0;

                return redirect()->route('login');
            }
        } else {

            $user = User::where('email', session('email'))->first();

            Auth::login($user);

            $this->page = 'Rental Property Management for Property Owner';
            $this->name = Auth::user()->name;
            $this->email = Auth::user()->email;
            $ref_code = Auth::user()->ref_code;
        }

        $maintreq = $maintenance->where('post_id', $id)->get();
        $consult = $consultant->where('owner_email', $this->email)->get();

        $data = array(
            'maintenance' => $maintreq,
            'consult' => $consult,
            'getfiveNotifications' => $this->getfiveUserNotifications($ref_code),
            'continent' => $this->timezone[0]
        );

        // dd($data);


        return view('main.rentalmanagementassignconsultant')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }


    public function maintenance(Request $req)
    {

        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Rental Property Maintenance';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                    'continent' => $this->timezone[0]
                );
            } else {
                // $this->page = 'Rental Property Maintenance';
                // $this->name = '';
                // $data = [];

                return redirect()->route('login');
            }
        } else {
            $user = User::where('email', session('email'))->first();

            Auth::login($user);

            $this->page = 'Rental Property Maintenance';
            $this->name = Auth::user()->name;
            $this->email = Auth::user()->email;
            $data = array(
                'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                'continent' => $this->timezone[0]
            );
        }

        // Get Organization & Business
        $clientInfo = $this->thisClientsInformation($req->get('id'));
        $buildInfo = $this->thisBuildingInformation($req->get('id'));


        return view('main.maintenance')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'clientInfo' => $clientInfo, 'data' => $data, 'buildInfo' => $buildInfo]);
    }


    public function maintenanceStatus(Request $req)
    {

        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Rental Property Maintenance';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                    'continent' => $this->timezone[0]
                );
            } else {
                // $this->page = 'Rental Property Maintenance';
                // $this->name = '';
                // $data = [];

                return redirect()->route('login');
            }
        } else {

            $user = User::where('email', session('email'))->first();

            Auth::login($user);

            $this->page = 'Rental Property Maintenance';
            $this->name = Auth::user()->name;
            $this->email = Auth::user()->email;
            $data = array(
                'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                'continent' => $this->timezone[0]
            );
        }


        // Get Organization & Business
        $statuschecker = $this->maintenanceCheck($this->email, $req->get('s'));

        return view('main.maintenancestatus')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'statuschecker' => $statuschecker, 'data' => $data]);
    }



    public function rentalManagementAdminMaintenance(Request $req)
    {

        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Rental Property Maintenance for Property Owner';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $this->ref_code = Auth::user()->ref_code;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                    'continent' => $this->timezone[0]
                );
            } else {
                // $this->page = 'Rental Property Maintenance for Property Owner';
                // $this->name = '';
                // $data = [];
                return redirect()->route('login');
            }
        } else {

            $user = User::where('email', session('email'))->first();

            Auth::login($user);

            $this->page = 'Rental Property Maintenance for Property Owner';
            $this->name = Auth::user()->name;
            $this->email = Auth::user()->email;
            $this->ref_code = Auth::user()->ref_code;
            $data = array(
                'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                'continent' => $this->timezone[0]
            );
        }

        // Get Organization & Business
        $statuschecker = $this->requestmaintenanceCheck($this->ref_code, $req->get('s'));

        return view('main.requestmaintenancecheck')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'statuschecker' => $statuschecker, 'data' => $data]);
    }


    public function rentalManagementAdminWorkorder(Request $req)
    {

        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Rental Property Maintenance for Property Owner';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $this->ref_code = Auth::user()->ref_code;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                    'continent' => $this->timezone[0]
                );
            } else {
                // $this->page = 'Rental Property Maintenance for Property Owner';
                // $this->name = '';
                // $data = [];

                return redirect()->route('login');
            }
        } else {

            $user = User::where('email', session('email'))->first();

            Auth::login($user);

            $this->page = 'Rental Property Maintenance for Property Owner';
            $this->name = Auth::user()->name;
            $this->email = Auth::user()->email;
            $this->ref_code = Auth::user()->ref_code;
            $data = array(
                'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                'continent' => $this->timezone[0]
            );
        }

        // Get Organization & Business
        $statuschecker = $this->adminworkorderCheck($this->email);

        return view('main.adminworkordercheck')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'statuschecker' => $statuschecker, 'data' => $data]);
    }


    public function rentalManagementAdminviewinvoices(Request $req)
    {

        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Rental Property Maintenance for Property Owner';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $this->ref_code = Auth::user()->ref_code;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                    'continent' => $this->timezone[0]
                );
            } else {
                // $this->page = 'Rental Property Maintenance for Property Owner';
                // $this->name = '';
                // $data = [];

                return redirect()->route('login');
            }
        } else {

            $user = User::where('email', session('email'))->first();

            Auth::login($user);

            $this->page = 'Rental Property Maintenance for Property Owner';
            $this->name = Auth::user()->name;
            $this->email = Auth::user()->email;
            $this->ref_code = Auth::user()->ref_code;
            $data = array(
                'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                'continent' => $this->timezone[0]
            );
        }

        // Get Organization & Business
        $statuschecker = $this->requestinvoiceCheck($this->email);

        return view('main.admininvoicecheck')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'statuschecker' => $statuschecker, 'data' => $data]);
    }


    public function rentalManagementAdminviewquotes(Request $req)
    {

        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Rental Property Maintenance for Property Owner';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $this->ref_code = Auth::user()->ref_code;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                    'continent' => $this->timezone[0]
                );
            } else {
                // $this->page = 'Rental Property Maintenance for Property Owner';
                // $this->name = '';
                // $data = [];

                return redirect()->route('login');
            }
        } else {
            $user = User::where('email', session('email'))->first();

            Auth::login($user);

            $this->page = 'Rental Property Maintenance for Property Owner';
            $this->name = Auth::user()->name;
            $this->email = Auth::user()->email;
            $this->ref_code = Auth::user()->ref_code;
            $data = array(
                'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                'continent' => $this->timezone[0]
            );
        }

        // Get Organization & Business
        $statuschecker = $this->requestquoteCheck($this->email);

        return view('main.adminquotecheck')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'statuschecker' => $statuschecker, 'data' => $data]);
    }


    public function rentalManagementAdminnegotiate(Request $req, $id)
    {

        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Rental Property Maintenance for Property Owner';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $this->ref_code = Auth::user()->ref_code;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                    'continent' => $this->timezone[0]
                );
            } else {
                // $this->page = 'Rental Property Maintenance for Property Owner';
                // $this->name = '';
                // $data = [];

                return redirect()->route('login');
            }
        } else {

            $user = User::where('email', session('email'))->first();

            Auth::login($user);

            $this->page = 'Rental Property Maintenance for Property Owner';
            $this->name = Auth::user()->name;
            $this->email = Auth::user()->email;
            $this->ref_code = Auth::user()->ref_code;
            $data = array(
                'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                'continent' => $this->timezone[0]
            );
        }


        $viewquotedetail = $this->quoteDetail($id);

        return view('main.adminquotenegotiate')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'viewquotedetail' => $viewquotedetail, 'data' => $data]);
    }


    public function rentalManagementAdminviewconsultant(Request $req)
    {

        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Rental Property Maintenance for Property Owner';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $this->ref_code = Auth::user()->ref_code;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                    'continent' => $this->timezone[0]
                );
            } else {
                // $this->page = 'Rental Property Maintenance for Property Owner';
                // $this->name = '';
                // $data = [];

                return redirect()->route('login');
            }
        } else {
            $user = User::where('email', session('email'))->first();

            Auth::login($user);

            $this->page = 'Rental Property Maintenance for Property Owner';
            $this->name = Auth::user()->name;
            $this->email = Auth::user()->email;
            $this->ref_code = Auth::user()->ref_code;
            $data = array(
                'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                'continent' => $this->timezone[0]
            );
        }

        // Get Organization & Business
        $providers = $this->providersCheck($this->email);

        return view('main.adminproviders')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'providers' => $providers]);
    }


    public function maintenanceView(Request $req, $id)
    {

        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Rental Property Maintenance';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                    'continent' => $this->timezone[0]
                );
            } else {
                // $this->page = 'Rental Property Maintenance for Property Owner';
                // $this->name = '';
                // $data = [];

                return redirect()->route('login');
            }
        } else {
            $user = User::where('email', session('email'))->first();

            Auth::login($user);

            $this->page = 'Rental Property Maintenance';
            $this->name = Auth::user()->name;
            $this->email = Auth::user()->email;
            $data = array(
                'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                'continent' => $this->timezone[0]
            );
        }

        // Get Organization & Business
        $viewmaintdetail = $this->maintenanceDetail($id);

        return view('main.maintenanceview')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'maintdetail' => $viewmaintdetail, 'data' => $data]);
    }

    public function maintenanceEdit(Request $req, $id)
    {

        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Rental Property Maintenance';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                    'continent' => $this->timezone[0]
                );
            } else {
                // $this->page = 'Rental Property Maintenance';
                // $this->name = '';
                // $data = [];

                return redirect()->route('login');
            }
        } else {
            $user = User::where('email', session('email'))->first();

            Auth::login($user);

            $this->page = 'Rental Property Maintenance';
            $this->name = Auth::user()->name;
            $this->email = Auth::user()->email;
            $data = array(
                'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                'continent' => $this->timezone[0]
            );
        }

        // Get Organization & Business
        $viewmaintdetail = $this->maintenanceDetail($id);
        $clientInfo = $this->clientsInformation();

        return view('main.maintenanceedit')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'maintdetail' => $viewmaintdetail, 'clientInfo' => $clientInfo, 'data' => $data]);
    }


    public function rentalManagementAdminMaintenanceview(Request $req, $id)
    {

        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Rental Property Maintenance for Property Owner';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                    'continent' => $this->timezone[0]
                );
            } else {
                // $this->page = 'Rental Property Maintenance for Property Owner';
                // $this->name = '';
                // $data = [];

                return redirect()->route('login');
            }
        } else {

            $user = User::where('email', session('email'))->first();

            Auth::login($user);

            $this->page = 'Rental Property Maintenance for Property Owner';
            $this->name = Auth::user()->name;
            $this->email = Auth::user()->email;
            $data = array(
                'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                'continent' => $this->timezone[0]
            );
        }

        // Get Organization & Business
        $viewmaintdetail = $this->maintenanceDetail($id);

        return view('main.maintenanceadminview')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'maintdetail' => $viewmaintdetail, 'data' => $data]);
    }


    public function amenities(Request $req)
    {

        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Rental Property Amenities';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                    'continent' => $this->timezone[0]
                );
            } else {
                // $this->page = 'Rental Property Amenities';
                // $this->name = '';
                // $data = [];

                return redirect()->route('login');
            }
        } else {

            $user = User::where('email', session('email'))->first();

            Auth::login($user);

            $this->page = 'Rental Property Amenities';
            $this->name = Auth::user()->name;
            $this->email = Auth::user()->email;
            $data = array(
                'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                'continent' => $this->timezone[0]
            );
        }

        $facilities = $this->facilities();


        return view('main.amenities')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'facilities' => $facilities, 'data' => $data]);
    }

    public function facilityview(Request $req, $id)
    {

        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Rental Property Amenities';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                    'continent' => $this->timezone[0],
                    'currentfacility' => $id
                );
            } else {
                // $this->page = 'Rental Property Amenities';
                // $this->name = '';
                // $data = [];

                return redirect()->route('login');
            }
        } else {

            $user = User::where('email', session('email'))->first();

            Auth::login($user);

            $this->page = 'Rental Property Amenities';
            $this->name = Auth::user()->name;
            $this->email = Auth::user()->email;
            $data = array(
                'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                'continent' => $this->timezone[0],
                'currentfacility' => $id
            );
        }

        $facilityinfo = $this->facilityInfo($id);


        return view('main.facilityview')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'facilityinfo' => $facilityinfo, 'data' => $data]);
    }

    public function makeBooking(Request $req, $id)
    {

        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Rental Property Amenities';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                    'continent' => $this->timezone[0],
                    'currentfacility' => $id
                );
            } else {
                // $this->page = 'Rental Property Amenities';
                // $this->name = '';
                // $data = [];

                return redirect()->route('login');
            }
        } else {

            $user = User::where('email', session('email'))->first();

            Auth::login($user);

            $this->page = 'Rental Property Amenities';
            $this->name = Auth::user()->name;
            $this->email = Auth::user()->email;
            $data = array(
                'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                'continent' => $this->timezone[0],
                'currentfacility' => $id
            );
        }

        $facilityinfo = $this->facilityInfo($id);


        return view('main.makeabooking')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'facilityinfo' => $facilityinfo, 'data' => $data]);
    }


    public function messages(Request $req)
    {

        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Rental Property Messages';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                    'continent' => $this->timezone[0]
                );
            } else {
                // $this->page = 'Rental Property Messages';
                // $this->name = '';
                // $data = [];

                return redirect()->route('login');
            }
        } else {

            $user = User::where('email', session('email'))->first();

            Auth::login($user);

            $this->page = 'Rental Property Messages';
            $this->name = Auth::user()->name;
            $this->email = Auth::user()->email;
            $data = array(
                'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                'continent' => $this->timezone[0]
            );
        }

        return view('main.messages')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }


    public function paymenthistory(Request $req)
    {

        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Rental Property Payment History';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                    'continent' => $this->timezone[0]
                );
            } else {
                // $this->page = 'Rental Property Payment History';
                // $this->name = '';
                // $data = [];

                return redirect()->route('login');
            }
        } else {

            $user = User::where('email', session('email'))->first();

            Auth::login($user);

            $this->page = 'Rental Property Payment History';
            $this->name = Auth::user()->name;
            $this->email = Auth::user()->email;
            $data = array(
                'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                'continent' => $this->timezone[0]
            );
        }


        $payhistory = $this->paymentHistoryrecord($this->email);

        return view('main.paymenthistory')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'payhistory' => $payhistory, 'data' => $data]);
    }

    public function documents(Request $req)
    {


        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Rental Property Documents';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                    'continent' => $this->timezone[0]
                );
            } else {
                // $this->page = 'Rental Property Documents';
                // $this->name = '';
                // $data = [];

                return redirect()->route('login');
            }
        } else {

            $user = User::where('email', session('email'))->first();

            Auth::login($user);


            $this->page = 'Rental Property Documents';
            $this->name = Auth::user()->name;
            $this->email = Auth::user()->email;
            $data = array(
                'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                'continent' => $this->timezone[0]
            );
        }


        // Get Shared DOcuments
        $sharedDocs = $this->sharedDocs($this->email);


        return view('main.documents')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'sharedDocs' => $sharedDocs, 'data' => $data]);
    }

    public function otherservices(Request $req)
    {

        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Rental Property Other Services';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                    'continent' => $this->timezone[0]
                );
            } else {
                // $this->page = 'Rental Property Other Services';
                // $this->name = '';
                // $data = [];

                return redirect()->route('login');
            }
        } else {

            $user = User::where('email', session('email'))->first();

            Auth::login($user);


            $this->page = 'Rental Property Other Services';
            $this->name = Auth::user()->name;
            $this->email = Auth::user()->email;
            $data = array(
                'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                'continent' => $this->timezone[0]
            );
        }

        return view('main.otherservices')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }


    public function payOrganization(Request $req)
    {

        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Money Transfer';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $ref_code = Auth::user()->ref_code;
            } else {
                $this->page = 'Money Transfer';
                $this->name = '';
                $ref_code = 0;
            }
        } else {
            $this->page = 'Money Transfer';
            $this->name = session('name');
            $this->email = session('email');
            $ref_code = 0;
        }

        // Get Organization & Business
        $clientInfo = $this->clientsInformation();
        $location = $this->myLocation();
        $data = array(
            'newnotification' => $this->notification($this->email),
            'allnotification' => $this->allnotification($this->email),
            'getfiveNotifications' => $this->getfiveUserNotifications($ref_code),
            'continent' => $this->timezone[0]
        );


        return view('main.payorganization')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'clientInfo' => $clientInfo, 'location' => $location, 'data' => $data]);
    }

    public function notification($email)
    {

        $data = Statement::where('user_id', $email)->where('notify', 0)->count();

        return $data;
    }

    public function allnotification($email)
    {

        $data = Statement::where('user_id', $email)->orderBy('notify', 'ASC')->orderBy('created_at', 'DESC')->get();

        return $data;
    }



    public function myinvoice(Request $req)
    {

        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'My Invoice';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
            } else {
                $this->page = 'My Invoice';
                $this->name = '';
            }
        } else {
            $this->page = 'My Invoice';
            $this->name = session('name');
            $this->email = session('email');
        }

        // $getBilling = ImportExcel::where('invoice_no', $req->route('key'))->get();

        $getBilling = DB::table('users')
            ->select(DB::raw('invoice_payment.transactionid as trans_id, invoice_payment.name, invoice_payment.email, invoice_payment.amount as payedAmount, invoice_payment.invoice_no as paidinvoice_no, invoice_payment.service as paidservice, invoice_payment.remaining_balance as remaining_balance, import_excel.payee_ref_no as payee_ref_no, import_excel.description as description, import_excel.amount as invoice_amount, import_excel.transaction_ref as transaction_ref, invoice_payment.created_at, users.address, users.city, users.state, users.zip, users.country, import_excel.uploaded_by, import_excel.payment_due_date, import_excel.tax_amount, import_excel.total_amount'))
            ->join('invoice_payment', 'users.email', '=', 'invoice_payment.email')
            ->join('import_excel', 'invoice_payment.invoice_no', '=', 'import_excel.invoice_no')
            ->where('invoice_payment.invoice_no', $req->route('key'))
            ->get();




        if (count($getBilling) > 0) {
            $getBilling = $getBilling;
        } else {
            $getBilling = DB::table('users')
                ->select(DB::raw('import_excel.payee_ref_no as trans_id, import_excel.name, import_excel.payee_email as email, import_excel.invoice_no as paidinvoice_no, import_excel.service as paidservice, import_excel.remaining_balance as remaining_balance, import_excel.payee_ref_no as payee_ref_no, import_excel.description as description, import_excel.amount as invoice_amount, import_excel.transaction_ref as transaction_ref, import_excel.created_at, users.address, users.city, users.state, users.zip, users.country, import_excel.uploaded_by, import_excel.payment_due_date, import_excel.tax_amount, import_excel.total_amount'))
                ->join('import_excel', 'users.email', '=', 'import_excel.payee_email')
                ->where('import_excel.invoice_no', $req->route('key'))
                ->get();
        }

        // dd($getBilling);






        return view('main.myinvoice')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'invoice' => $getBilling]);
    }


    public function myreceipt(Request $req)
    {

        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'My Receipt';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
            } else {
                $this->page = 'My Receipt';
                $this->name = '';
            }
        } else {
            $this->page = 'My Receipt';
            $this->name = session('name');
            $this->email = session('email');
        }

        // $getBilling = ImportExcel::where('invoice_no', $req->route('key'))->get();

        $getBilling = DB::table('users')
            ->select(DB::raw('invoice_payment.transactionid as trans_id, invoice_payment.name, invoice_payment.email, invoice_payment.amount as payedAmount, invoice_payment.invoice_no as paidinvoice_no, invoice_payment.service as paidservice, invoice_payment.remaining_balance as remaining_balance, import_excel.payee_ref_no as payee_ref_no, import_excel.description as description, import_excel.amount as invoice_amount, import_excel.transaction_ref as transaction_ref, invoice_payment.created_at, users.address, users.city, users.state, users.zip, users.country, import_excel.uploaded_by, import_excel.payment_due_date'))
            ->join('import_excel', 'users.email', '=', 'import_excel.payee_email')
            ->join('invoice_payment', 'users.email', '=', 'invoice_payment.email')
            ->where('invoice_payment.email', $this->email)->where('invoice_payment.invoice_no', $req->route('key'))
            ->get();



        //  ->join('import_excel', 'users.email', '=', 'import_excel.payee_email')
        //  ->join('invoice_payment', 'users.email', '=', 'invoice_payment.email')
        //  ->where('invoice_payment.invoice_no', $req->route('key'))
        // ->orderBy('invoice_payment.created_at', 'DESC')
        // ->get();




        // dd($getBilling);

        // DB::table('users')
        //     ->join('import_excel', 'users.email', '=', 'import_excel.payee_email')
        //     ->join('invoice_payment', 'users.email', '=', 'invoice_payment.email')
        //     ->where('import_excel.invoice_no', $req->route('key'))
        //     ->orderBy('invoice_payment.created_at', 'DESC')
        //     ->get();



        return view('main.myreceipt')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'invoice' => $getBilling]);
    }



    public function mywalletStatement(Request $req, $id)
    {

        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'My Receipt';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
            } else {
                $this->page = 'My Receipt';
                $this->name = '';
            }
        } else {
            $this->page = 'My Receipt';
            $this->name = session('name');
            $this->email = session('email');
        }

        $getStatement = Statement::where('reference_code', $id)->first();

        // dd($getStatement);

        return view('main.mywalletreceipt')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'walletTrans' => $getStatement]);
    }

    public function contact(Request $req)
    {

        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Contact';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                    'continent' => $this->timezone[0]
                );
            } else {
                $this->page = 'Contact';
                $this->name = '';
                $data = [
                    'continent' => $this->timezone[0]
                ];
            }
        } else {
            $this->page = 'Contact';
            $this->name = session('name');
            $this->email = session('email');
            $data = [
                'continent' => $this->timezone[0]
            ];
        }

        return view('main.contact')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }

    public function community(Request $req)
    {


        $community = Community::orderBy('created_at', 'DESC')->paginate(5);

        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Contact';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                    'continent' => $this->timezone[0],
                    'community' => $community
                );
            } else {
                $this->page = 'community';
                $this->name = '';
                $data = [
                    'continent' => $this->timezone[0],
                    'community' => $community
                ];
            }
        } else {
            $this->page = 'community';
            $this->name = session('name');
            $this->email = session('email');
            $data = [
                'continent' => $this->timezone[0],
                'community' => $community
            ];
        }

        return view('main.developer.community')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }

    public function askQuestion(Request $req)
    {

        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Contact';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                    'continent' => $this->timezone[0]
                );
            } else {
                $this->page = 'community';
                $this->name = '';
                $data = [
                    'continent' => $this->timezone[0]
                ];
            }
        } else {
            $this->page = 'community';
            $this->name = session('name');
            $this->email = session('email');
            $data = [
                'continent' => $this->timezone[0]
            ];
        };


        return view('main.developer.askquestion')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }


    public function storeAskedQuestions(Request $request)
    {

        // dd($request->all());

        try {
            $path = NULL;

            if ($request->hasFile('file')) {

                // Do your file upload here and set $path

                //Get filename with extension
                $filenameWithExt = $request->file('file')->getClientOriginalName();
                // Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                // Get just extension
                $extension = $request->file('file')->getClientOriginalExtension();

                // Filename to store
                $fileNameToStore = rand() . '_' . time() . '.' . $extension;

                $fileToStore = $fileNameToStore;
                //Upload Image-
                $path = $request->file('file')->storeAs('public/communityfile', $fileToStore);

                // $path = $request->move(public_path('/communityfile/'), $fileNameToStore);

                $request->file('file')->move(public_path('../../communityfile/'), $fileToStore);

                $path = route('home') . '/communityfile/' . $fileNameToStore;
            }


            if ($request->categories == "others") {
                $categories = $request->specify_categories;
            } else {
                $categories = $request->categories;
            }

            Community::insert([
                'categories' => $categories, 'question' => $request->question, 'file' => $path, 'description' => $request->description, 'name' => $request->name, 'email' => $request->email
            ]);

            $resData = 'Submitted successfully';
            $resp = "success";

            return redirect()->route('community');
        } catch (\Throwable $th) {
            $resData = $th->getMessage();
            $resp = "error";

            // dd($resData);
        }



        //return redirect(route('community'));



    }

    public function subMessage(Request $req, $id)
    {

        $community = Community::where('id', $id)->first();
        $answer = Answer::where('questionid', $id)->orderBy('created_at', 'DESC')->get();

        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Contact';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                    'continent' => $this->timezone[0],
                    'community' => $community,
                    'answer' => $answer
                );
            } else {
                $this->page = 'community';
                $this->name = '';
                $data = [
                    'continent' => $this->timezone[0],
                    'community' => $community,
                    'answer' => $answer
                ];
            }
        } else {
            $this->page = 'community';
            $this->name = session('name');
            $this->email = session('email');
            $data = [
                'continent' => $this->timezone[0],
                'community' => $community,
                'answer' => $answer

            ];
        };






        return view('main.developer.submessage')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }


    public function storeSubMessage(Request $request)
    {

        // dd($request->all());

        try {

            Answer::insert([
                'questionId' => $request->questionId, 'comment' => $request->comment, 'name' => $request->name,
            ]);

            $resData = 'Success';
            $resp = "success";
        } catch (\Throwable $th) {
            $resData = $th->getMessage();
            $resp = "error";
        }



        return redirect()->route('submessage', $request->questionId);
    }

    public function service(Request $req)
    {

        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Services';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                    'continent' => $this->timezone[0]
                );
            } else {
                $this->page = 'Services';
                $this->name = '';
                $data = [
                    'continent' => $this->timezone[0]
                ];
            }
        } else {
            $this->page = 'Services';
            $this->name = session('name');
            $this->email = session('email');
            $data = [
                'continent' => $this->timezone[0]
            ];
        }

        return view('main.services')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }


    public function verifyAuthentication(Request $req)
    {

        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Create a Ticket';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'continent' => $this->timezone[0]
                );

                $this->getTickets = CreateEvent::where('user_id', $this->email)->orderBy('created_at', 'DESC')->get();
            } else {
                $this->page = 'Verification Code';
                $this->name = '';
            }
        } else {
            $this->page = 'Verification Code';
            $this->name = session('name');
            $this->email = session('email');
        }

        return view('auth.verification')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email]);
    }

    public function verifyOtp(Request $req)
    {
        // Check OTP exists and verify USER...
        $getCode = VerificationCode::where('user_id', Auth::id())->where('code', $req->code)->first();

        if (!isset($getCode)) {
            $resData = 'Invalid verification OTP';
            $resp = "error";
            return redirect()->back()->with($resp, $resData);
        }

        VerificationCode::where('user_id', Auth::id())->where('code', $req->code)->delete();
        return redirect()->route('home');
    }

    public function regenerateOtp()
    {
        $this->generateOTP(Auth::id());

        $resData = 'Successfully sent';
        $resp = "success";

        return redirect()->back()->with($resp, $resData);;
    }


    public function ticket(Request $req)
    {

        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Create a Ticket';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                    'continent' => $this->timezone[0]
                );

                $this->getTickets = CreateEvent::where('user_id', $this->email)->orderBy('created_at', 'DESC')->get();
            } else {
                $this->page = 'Create a Ticket';
                $this->name = '';
                $data = [
                    'continent' => $this->timezone[0]
                ];
            }
        } else {
            $this->page = 'Create a Ticket';
            $this->name = session('name');
            $this->email = session('email');
            $data = [
                'continent' => $this->timezone[0]
            ];

            $this->getTickets = CreateEvent::where('user_id', $this->email)->orderBy('created_at', 'DESC')->get();
        }

        return view('main.ticket')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'getTickets' => $this->getTickets, 'data' => $data]);
    }




    public function profile(Request $req)
    {

        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Profile Information';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                    'listbank' => $this->getBankList(),
                    'continent' => $this->timezone[0]
                );
            } else {
                $this->page = 'Profile Information';
                $this->name = '';
                $data = [
                    'continent' => $this->timezone[0]
                ];
            }
        } else {
            $this->page = 'Profile Information';
            $this->name = session('name');
            $this->email = session('email');
            $data = [
                'continent' => $this->timezone[0]
            ];
        }

        return view('main.profile')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }

    //Referral link

    public function referralLink()
    {
        if (Auth::check() == true) {

            if (Auth::user()->accountType == "Individual") {
                $this->page = 'Landing';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'sendReceive' => $this->sendAndReceive(Auth::user()->email),
                    'payInvoice' => $this->payInvoice(Auth::user()->email),
                    'walletTrans' => $this->sendAndReceive(Auth::user()->email),
                    'urgentnotification' => $this->urgentNotification(Auth::user()->email),
                    'currencyCode' => $this->getCountryCode(Auth::user()->country),
                    'getCard' => $this->getUserCard(),
                    'getBank' => $this->getUserBank(),
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                    'getmerchantsByCategory' => $this->getMerchantsByCategory(),
                    'specialInfo' => $this->getthisInfo(Auth::user()->country),
                    'continent' => $this->timezone[0],
                    'mypoints' => $this->getAcquiredPoints(Auth::user()->id),
                    'pointsclaim' => $this->getClaimedHistory(Auth::user()->id),
                    'myplan' => UpgradePlan::where('userId', Auth::user()->ref_code)->first(),
                    'imtAccess' => AllCountries::where('name', Auth::user()->country)->first(),
                    'referred' => $this->referral(Auth::user()->ref_code)
                );

                $view = 'home';
            } else {

                // return redirect()->route('Admin');
                return redirect()->route('dashboard');
            }
        } else {
            $this->page = 'Homepage';
            $this->name = '';
            $view = 'main.newpage.shade-pro.index';
            $data = [
                'continent' => $this->timezone[0]
            ];
        }

        // dd($data);



        return view('main.referrallink')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }

    //special promo page
    public function specialPromo()
    {
        if (
            Auth::check() == true
        ) {

            if (Auth::user()->accountType == "Individual") {
                $this->page = 'Landing';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'sendReceive' => $this->sendAndReceive(Auth::user()->email),
                    'payInvoice' => $this->payInvoice(Auth::user()->email),
                    'walletTrans' => $this->sendAndReceive(Auth::user()->email),
                    'urgentnotification' => $this->urgentNotification(Auth::user()->email),
                    'currencyCode' => $this->getCountryCode(Auth::user()->country),
                    'getCard' => $this->getUserCard(),
                    'getBank' => $this->getUserBank(),
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                    'getmerchantsByCategory' => $this->getMerchantsByCategory(),
                    'specialInfo' => $this->getthisInfo(Auth::user()->country),
                    'continent' => $this->timezone[0],
                    'mypoints' => $this->getAcquiredPoints(Auth::user()->id),
                    'pointsclaim' => $this->getClaimedHistory(Auth::user()->id),
                    'myplan' => UpgradePlan::where('userId', Auth::user()->ref_code)->first(),
                    'imtAccess' => AllCountries::where('name', Auth::user()->country)->first(),
                    'referred' => $this->referral(Auth::user()->ref_code),
                    'specialpromo' => PromoDate::latest()->get(),
                );

                $view = 'home';
            } else {

                // return redirect()->route('Admin');
                return redirect()->route('dashboard');
            }
        } else {
            $this->page = 'Homepage';
            $this->name = '';
            $view = 'main.newpage.shade-pro.index';
            $data = [
                'continent' => $this->timezone[0]
            ];
        }

        // dd($data);



        return view('main.specialpromo')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }
    //user journey
    public function userJourney()
    {
        if (
            Auth::check() == true
        ) {

            if (Auth::user()->accountType == "Individual") {
                $this->page = 'Landing';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'sendReceive' => $this->sendAndReceive(Auth::user()->email),
                    'payInvoice' => $this->payInvoice(Auth::user()->email),
                    'walletTrans' => $this->sendAndReceive(Auth::user()->email),
                    'urgentnotification' => $this->urgentNotification(Auth::user()->email),
                    'currencyCode' => $this->getCountryCode(Auth::user()->country),
                    'getCard' => $this->getUserCard(),
                    'getBank' => $this->getUserBank(),
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                    'getmerchantsByCategory' => $this->getMerchantsByCategory(),
                    'specialInfo' => $this->getthisInfo(Auth::user()->country),
                    'continent' => $this->timezone[0],
                    'mypoints' => $this->getAcquiredPoints(Auth::user()->id),
                    'pointsclaim' => $this->getClaimedHistory(Auth::user()->id),
                    'myplan' => UpgradePlan::where('userId', Auth::user()->ref_code)->first(),
                    'imtAccess' => AllCountries::where('name', Auth::user()->country)->first(),
                    'referred' => $this->referral(Auth::user()->ref_code)
                );

                $view = 'home';
            } else {

                // return redirect()->route('Admin');
                return redirect()->route('dashboard');
            }
        } else {
            $this->page = 'Homepage';
            $this->name = '';
            $view = 'main.newpage.shade-pro.index';
            $data = [
                'continent' => $this->timezone[0]
            ];
        }

        // dd($data);



        return view('main.userjourney')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }



    public function sendAndReceive($email)
    {
        $data = Statement::where('user_id', $email)->where('statement_route', 'wallet')->orderBy('created_at', 'DESC')->limit(5)->get();
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
    public function urgentNotification($email)
    {
        $data = Statement::where('user_id', $email)->orderBy('created_at', 'DESC')->limit(5)->get();
        return $data;
    }


    // Custom Ajax Request
    public function ajaxregister(Request $req)
    {


        // Check table if user already exist
        $checkUser = User::where('email', $req->email)->get();
        $checkClosedUser = UserClosed::where('email', $req->email)->get();

        $transCost = TransactionCost::where('method', "Consumer Minimum Withdrawal")->where('country', $req->country)->first();

        if (isset($transCost)) {
            $transactionLimit = $transCost->fixed;
        } else {
            $transactionLimit = 0;
        }

        // Check Referal
        $getRef = User::where('ref_code', $req->referred_by)->first();

        if (isset($getRef)) {

            $referral_points = $getRef->referral_points + 10;

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




        if (count($checkUser) > 0) {
            $resData = ['res' => 'User with email: ' . $req->email . ' already exist', 'message' => 'error'];
        } elseif (count($checkClosedUser) > 0) {
            $resData = ['res' => 'Your account has already been created but currently not active on PaySprint. Contact the Admin for more information', 'message' => 'error'];
        } else {
            $name = $req->fname . ' ' . $req->lname;

            $ref_code = mt_rand(0000000, 9999999);

            $mycode = $this->getCountryCode($req->country);

            $currencyCode = $mycode->currencyCode;
            $currencySymbol = $mycode->currencySymbol;

            // Get all ref_codes
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

            if (isset($mycode->callingCode)) {

                if ($req->country == "United States") {
                    $phoneCode = "1";
                } else {
                    $phoneCode = $mycode->callingCode;
                }
            } else {
                $phoneCode = "1";
            }

            if ($req->ref_code != null) {

                $getanonuser = AnonUsers::where('ref_code', $req->ref_code)->first();

                // Insert User record
                if ($req->accountType == "Individual") {
                    // Insert Information for Individual user
                    $insInd = User::insert(['ref_code' => $req->ref_code, 'name' => $name, 'email' => $req->email, 'password' => Hash::make($req->password), 'address' => $req->street_number . ' ' . $req->street_name . ', ' . $req->city . ' ' . $req->state . ' ' . $req->country, 'city' => $req->city, 'state' => $req->state, 'country' => $req->country, 'accountType' => $req->accountType, 'zip' => $req->zipcode, 'code' => $phoneCode, 'api_token' => uniqid() . md5($req->email) . time(), 'telephone' => $getanonuser->telephone, 'wallet_balance' => $getanonuser->wallet_balance, 'currencyCode' => $currencyCode, 'currencySymbol' => $currencySymbol, 'dayOfBirth' => $req->dayOfBirth, 'monthOfBirth' => $req->monthOfBirth, 'yearOfBirth' => $req->yearOfBirth, 'platform' => 'web', 'accountLevel' => 2, 'withdrawal_per_transaction' => $transactionLimit, 'referred_by' => $req->referred_by]);
                } elseif ($req->accountType == "Business") {
                    // Insert Information for Business user
                    $insBus = User::insert(['ref_code' => $req->ref_code, 'businessname' => $req->busname, 'name' => $name, 'email' => $req->email, 'password' => Hash::make($req->password), 'address' => $req->street_number . ' ' . $req->street_name . ', ' . $req->city . ' ' . $req->state . ' ' . $req->country, 'city' => $req->city, 'state' => $req->state, 'country' => $req->country, 'accountType' => $req->accountType, 'zip' => $req->zipcode, 'corporationType' => $req->corporationtype, 'code' => $phoneCode, 'api_token' => uniqid() . md5($req->email) . time(), 'telephone' => $getanonuser->telephone, 'wallet_balance' => $getanonuser->wallet_balance, 'currencyCode' => $currencyCode, 'currencySymbol' => $currencySymbol, 'platform' => 'web', 'accountLevel' => 2, 'withdrawal_per_transaction' => $transactionLimit, 'referred_by' => $req->referred_by]);
                }

                $getMoney = Statement::where('user_id', $req->email)->get();

                if (count($getMoney) > 0) {
                    foreach ($getMoney as $key => $value) {

                        Statement::where('reference_code', $value->reference_code)->update(['status' => 'Delivered']);
                    }
                } else {
                    // Do nothing
                }


                AnonUsers::where('ref_code', $req->ref_code)->delete();
            } else {
                // Insert User record
                if ($req->accountType == "Individual") {
                    // Insert Information for Individual user
                    $insInd = User::insert(['ref_code' => $newRefcode, 'name' => $name, 'email' => $req->email, 'password' => Hash::make($req->password), 'address' => $req->street_number . ' ' . $req->street_name . ', ' . $req->city . ' ' . $req->state . ' ' . $req->country, 'city' => $req->city, 'state' => $req->state, 'country' => $req->country, 'accountType' => $req->accountType, 'zip' => $req->zipcode, 'code' => $phoneCode, 'api_token' => uniqid() . md5($req->email) . time(), 'currencyCode' => $currencyCode, 'currencySymbol' => $currencySymbol, 'dayOfBirth' => $req->dayOfBirth, 'monthOfBirth' => $req->monthOfBirth, 'yearOfBirth' => $req->yearOfBirth, 'platform' => 'web', 'accountLevel' => 2, 'withdrawal_per_transaction' => $transactionLimit, 'referred_by' => $req->referred_by]);

                    // $req->session()->put(['name' => $name, 'email' => $req->email, 'address' => $req->address, 'city' => $req->city, 'state' => $req->state, 'country' => $req->country, 'accountType' => $req->accountType]);
                } elseif ($req->accountType == "Business") {
                    // Insert Information for Business user
                    $insBus = User::insert(['ref_code' => $newRefcode, 'businessname' => $req->busname, 'name' => $name, 'email' => $req->email, 'password' => Hash::make($req->password), 'address' => $req->street_number . ' ' . $req->street_name . ', ' . $req->city . ' ' . $req->state . ' ' . $req->country, 'city' => $req->city, 'state' => $req->state, 'country' => $req->country, 'accountType' => $req->accountType, 'zip' => $req->zipcode, 'corporationType' => $req->corporationtype, 'code' => $phoneCode, 'api_token' => uniqid() . md5($req->email) . time(), 'currencyCode' => $currencyCode, 'currencySymbol' => $currencySymbol, 'platform' => 'web', 'accountLevel' => 2, 'withdrawal_per_transaction' => $transactionLimit, 'referred_by' => $req->referred_by]);

                    // $req->session()->put(['businessname' => $req->busname, 'name' => $name, 'email' => $req->email, 'address' => $req->address, 'city' => $req->city, 'state' => $req->state, 'country' => $req->country, 'accountType' => $req->accountType, 'zip' => $req->zipcode, 'corporationType' => $req->corporationtype]);

                }
            }



            $credentials = $req->only('email', 'password');

            if (Auth::attempt($credentials)) {




                $url = 'https://api.globaldatacompany.com/verifications/v1/verify';

                $minimuAge = date('Y') - Auth::user()->yearOfBirth;

                $usersname = explode(" ", $name);

                $countryApproval = AllCountries::where('name', Auth::user()->country)->where('approval', 1)->first();

                if (isset($countryApproval)) {
                    $info = $this->identificationAPI($url, $usersname[0], $usersname[1], Auth::user()->dayOfBirth, Auth::user()->monthOfBirth, Auth::user()->yearOfBirth, $minimuAge, Auth::user()->address, Auth::user()->city, Auth::user()->country, Auth::user()->zipcode, Auth::user()->telephone, Auth::user()->email, $mycode->code);



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

                            $message = "success";
                            $title = "Great!";
                            $link = "contact";

                            $resInfo = strtoupper($info->Record->RecordStatus) . ", Welcome to PaySprint, World's #1 Affordable Payment Method that enables you to send and receive money, pay Invoice and bills and getting paid at anytime. You will be able to add money to your wallet, Pay Invoice or Utility bills, but you will not be able to send or receive money or withdraw money from your Wallet pending the verification of Government issued Photo ID and Utility bill or Bank statement uploaded. \nKindly follow these steps to upload the required information: \na. login to PaySprint Account on Mobile App or Web app at www.paysprint.ca \nb. Go to profile page, take a Selfie of yourself and upload along with a copy of Goverment Issued Photo ID, a copy of Utility bills and business documents \nAll other features would be enabled for you as soon as Compliance Team verifies your information \nThank you for your interest in PaySprint.\nCompliance Team @PaySprint \ninfo@paysprint.ca";

                            User::where('id', Auth::user()->id)->update(['accountLevel' => 2, 'countryapproval' => 1, 'transactionRecordId' => $info->TransactionID]);
                        } else {
                            $message = "success";
                            $title = "Great";
                            $link = "/";
                            $resInfo = strtoupper($info->Record->RecordStatus) . ", Congratulations!!!. Your account has been approved. Kindly complete the Quick Set up to enjoy the full benefits of  PaySprint. You will be redirected in 5sec";



                            // Udpate User Info
                            User::where('id', Auth::user()->id)->update(['accountLevel' => 2, 'approval' => 1, 'countryapproval' => 1, 'bvn_verification' => 1, 'transactionRecordId' => $info->TransactionID]);
                        }
                    } else {
                        $message = "success";
                        $title = "Great!";
                        $link = "contact";
                        $resInfo = "Welcome to PaySprint, World's #1 Affordable Payment Method that enables you to send and receive money, pay Invoice and bills and getting paid at anytime. You will be able to add money to your wallet, Pay Invoice or Utility bills, but you will not be able to send or receive money or withdraw money from your Wallet pending the verification of Government issued Photo ID and Utility bill or Bank statement uploaded. \nKindly follow these steps to upload the required information: \na. login to PaySprint Account on Mobile App or Web app at www.paysprint.ca \nb. Go to profile page, take a Selfie of yourself and upload along with a copy of Goverment Issued Photo ID, a copy of Utility bills and business documents \nAll other features would be enabled for you as soon as Compliance Team verifies your information \nThank you for your interest in PaySprint.\nCompliance Team @PaySprint \ninfo@paysprint.ca";

                        User::where('id', Auth::user()->id)->update(['accountLevel' => 2, 'countryapproval' => 1, 'transactionRecordId' => NULL]);

                        // $resp = $info->Message;
                    }

                    $this->name = Auth::user()->name;
                    // $this->email = "bambo@vimfile.com";
                    $this->email = Auth::user()->email;
                    $this->subject = "Welcome to PaySprint";

                    // $message = "Welcome to PaySprint, World's #1 Affordable Payment Method that enables you to send and receive money, pay Invoice and bills and getting paid at anytime. You can also withdraw funds from your wallet FREE of Costs. <br> Thank you for your interest in PaySprint. <br><br> Customer Success Team <br> info@paysprint.ca";

                    $infomessage = "Welcome to PaySprint, World's #1 Affordable Payment Method that enables you to send and receive money, pay Invoice and bills and getting paid at anytime. You will be able to add money to your wallet, Pay Invoice or Utility bills, but you will not be able to send or receive money or withdraw money from your Wallet pending the verification of Government issued Photo ID and Utility bill or Bank statement uploaded. <br> Kindly follow these steps to upload the required information: <br> a. login to PaySprint Account on Mobile App or Web app at www.paysprint.ca <br> b. Go to profile page, take a Selfie of yourself and upload along with a copy of Goverment Issued Photo ID, a copy of Utility bills and business documents <br> All other features would be enabled for you as soon as Compliance Team verifies your information <br> Thank you for your interest in PaySprint. <br><br> Compliance Team @PaySprint <br> info@paysprint.ca";


                    $this->message = '<p>' . $infomessage . '</p>';


                    $this->sendEmail($this->email, "Fund remittance");


                    if ($req->country == "India") {

                        $this->name = $req->fname . ' ' . $req->lname;
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
                    $resInfo = "PaySprint is not yet available for use in your country. You can contact our Customer Service Executives for further assistance";

                    User::where('id', Auth::user()->id)->update(['accountLevel' => 0, 'countryapproval' => 0, 'transactionRecordId' => NULL]);
                }



                $this->mailListCategorize($this->name, $this->email, Auth::user()->address, Auth::user()->telephone, 'New Consumers', Auth::user()->country, 'Subscription');

                // Log::info("New user registration via web by: ".$name." from ".$req->state.", ".$req->country." \n\n STATUS: ".$resInfo);

                $this->slack("New user registration via web by: " . $name . " from " . $req->state . ", " . $req->country . " \n\n STATUS: " . $resInfo, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));


                // This is the response for now until trulioo activates us to LIVE..
                // $message = "success";
                // $title = "Great";
                // $link = "/";
                // $resInfo = "Hello ".$name.", Welcome to PaySprint!";


                $resData = ['res' => $resInfo, 'message' => $message, 'link' => $link];
            } else {
                $resData = ['res' => 'Credential failed', 'message' => 'error'];
            }
        }

        return $this->returnJSON($resData, 200);
    }

    public function ajaxlogin(Request $req)
    {
        // Check user if exist
        $userExists = User::where('email', $req->email)->get();
        if (count($userExists) > 0) {
            // Check User Password if match
            if (Hash::check($req->password, $userExists[0]['password'])) {

                $countryApproval = AllCountries::where('name', $userExists[0]['country'])->where('approval', 1)->first();




                if (isset($countryApproval)) {
                    // Check if Flagged or not
                    if ($userExists[0]['flagged'] == 1) {

                        $resData = ['res' => 'Hello ' . $userExists[0]['name'] . ', Access to the account is not currently available. Kindly contact the Admin using this link: https://paysprint.ca/contact.', 'message' => 'error'];

                        $this->createNotification($userExists[0]['ref_code'], 'Hello ' . $userExists[0]['name'] . ', Access to the account is not currently available. Kindly contact the Admin using this link: https://paysprint.ca/contact.');
                    } elseif ($userExists[0]['disableAccount'] == 'on') {

                        $resData = ['res' => 'Hello ' . $userExists[0]['name'] . ', Access to the account is not currently available. Kindly contact the Admin using this link: https://paysprint.ca/contact.', 'message' => 'error'];

                        $this->createNotification($userExists[0]['ref_code'], 'Hello ' . $userExists[0]['name'] . ', Access to the account is not currently available. Kindly contact the Admin using this link: https://paysprint.ca/contact.');
                    }
                    // elseif($userExists[0]['accountLevel'] == 0){

                    //     $resData = ['res' => 'Hello '.$userExists[0]['name'].', Our system is unable to complete your Sign Up process at this time. Kindly Contact Us to submit your Name and email. One of our Customer Service Executives would contact you within the next 24 hours for further assistance.', 'message' => 'error'];

                    //     $this->createNotification($userExists[0]['ref_code'], 'Hello '.$userExists[0]['name'].', Our system is unable to complete your Sign Up process at this time. Kindly Contact Us to submit your Name and email. One of our Customer Service Executives would contact you within the next 24 hours for further assistance.');
                    // }
                    else {
                        $countryInfo = $this->getCountryCode($userExists[0]['country']);


                        $currencyCode = $countryInfo->currencyCode;
                        $currencySymbol = $countryInfo->currencySymbol;

                        $loginCount = $userExists[0]['loginCount'] + 1;


                        if ($userExists[0]['accountType'] == "Merchant") {
                            $resData = ['res' => 'Hello ' . $userExists[0]['name'] . ', your account exists as a merchant. Kindly login on the merchant section', 'message' => 'error'];
                        } else {

                            if ($userExists[0]['pass_checker'] > 0 && $userExists[0]['pass_date'] <= date('Y-m-d')) {
                                $pass_date = $userExists[0]['pass_date'];
                            } else {
                                $pass_date = date('Y-m-d');
                            }

                            // Update API Token
                            User::where('email', $req->email)->update(['api_token' => uniqid() . md5($req->email) . time(), 'currencyCode' => $currencyCode, 'currencySymbol' => $currencySymbol, 'lastLogin' => date('d-m-Y h:i A'), 'loginCount' => $loginCount, 'pass_date' => $pass_date]);

                            $city = $this->myLocation()->city;
                            $country = $this->myLocation()->country;
                            $ip = $this->myLocation()->query;

                            $this->checkLoginInfo($userExists[0]['ref_code'], $city, $country, $ip);

                            $resData = ['res' => 'Welcome back ' . $userExists[0]['name'], 'message' => 'success'];

                            if (env('APP_ENV') != 'local') {
                                $this->generateOTP($userExists[0]['id']);
                            }



                            $this->createNotification($userExists[0]['ref_code'], 'Welcome back ' . $userExists[0]['name']);
                        }
                    }

                    User::where('email', $req->email)->update(['countryapproval' => 1]);
                } else {
                    $resData = ['res' => 'Hello ' . $userExists[0]['name'] . ', PaySprint is not yet available for use in your country. You can contact our Customer Service Executives for further assistance', 'message' => 'error'];

                    User::where('email', $req->email)->update(['countryapproval' => 0]);
                }
            } else {
                $resData = ['res' => 'Your password is not correct', 'message' => 'info'];
            }
        } else {
            $resData = ['res' => 'Your credential does not match our record', 'message' => 'error'];
        }

        return $this->returnJSON($resData, 200);
    }


    public function setupBills(Request $req)
    {
        // Check if invoice number exist...
        $setBills = SetupBilling::where('invoice_no', $req->invoice_no)->get();
        if (count($setBills) > 0) {
            // Already Exist, User can check the invoice to see whats there
            $resData = ['res' => 'Bill already setup for ' . $req->invoice_no . ' will you like to view this bill', 'message' => 'warning', 'info' => 'exist', 'title' => 'Urgh!'];
        } else {
            // Insert
            $insBills = SetupBilling::insert(['name' => $req->name, 'email' => $req->email, 'ref_code' => date('dmy') . '_' . mt_rand(1000, 9999), 'service' => $req->service, 'invoice_no' => $req->invoice_no, 'date' => $req->date, 'description' => $req->description, 'amount' => $req->amount]);

            if ($insBills == true) {
                $resData = ['res' => 'You have just set up your bill for INVOICE: ' . $req->invoice_no, 'message' => 'success', 'info' => 'good_insert', 'title' => 'Great'];
            } else {
                $resData = ['res' => 'Your bill was not properly setup, please refresh and try again', 'message' => 'error', 'info' => 'no_insert', 'title' => 'Oops!'];
            }
        }

        return $this->returnJSON($resData, 200);
    }

    public function checkmyBills(Request $req)
    {
        // Get Bill
        $getBills = SetupBilling::where('invoice_no', $req->invoice_no)->get();

        if (count($getBills) > 0) {
            $resData = ['res' => 'Fetching', 'message' => 'success', 'link' => 'Myinvoice/' . $getBills[0]->invoice_no];
        } else {
            $resData = ['res' => 'Something went wrong', 'message' => 'error', 'title' => 'Oops!'];
        }
        return $this->returnJSON($resData, 200);
    }

    public function getmyInvoice(Request $req)
    {
        // Get Bill
        $getInvs = ImportExcel::where('invoice_no', $req->invoice_no)->get();

        if (count($getInvs) > 0) {
            // Check For If Invoice belongs to USer
            $user = ImportExcel::where('payee_email', $req->email)->where('invoice_no', $getInvs[0]->invoice_no)->get();

            if (count($user) > 0) {

                // User correct
                $resData = ['res' => 'Fetching Data', 'message' => 'success', 'link' => 'Myinvoice/' . $user[0]->invoice_no, 'info' => 'service_correct', 'title' => 'Good'];
            } else {

                $resData = ['res' => 'Invoice record exist, but information does not belong to you. Click OK if you would like to continue.', 'message' => 'warning', 'link' => 'Myinvoice/' . $getInvs[0]->invoice_no, 'info' => 'user_no', 'title' => 'Hello'];
            }
        } else {
            $resData = ['res' => 'We do not have record for this reference number', 'message' => 'error', 'title' => 'Oops!', 'info' => 'no_exist'];
        }


        return $this->returnJSON($resData, 200);
    }

    public function claimedPoints(Request $req)
    {

        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Claim Point';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
            } else {

                return redirect()->route('login');
            }
        } else {

            $user = User::where('email', session('email'))->first();

            Auth::login($user);

            $this->page = 'Claim Point';
            $this->name = Auth::user()->name;
            $this->email = Auth::user()->email;
        }

        // Get Bill
        $getPoint = Points::where('user_id', Auth::user()->id)->first();



        if (isset($getPoint)) {

            if (Auth::user()->accountType == "Merchant") {

                $max = 7000;
            } else {

                $max = 5000;
            }


            $totPointLeft = $getPoint->points_acquired - $max;

            $pointtoget = $max - $getPoint->points_acquired;

            // Process claims and update user

            if ($getPoint->points_acquired >= $max) {



                // This is when you can claim points...
                Points::where('user_id', Auth::user()->id)->update(['add_money' => 0, 'send_money' => 0, 'receive_money' => 0, 'pay_invoice' => 0, 'pay_bills' => 0, 'create_and_send_invoice' => 0, 'active_rental_property' => 0, 'quick_set_up' => 0, 'identity_verification' => 0, 'business_verification' => 0, 'promote_business' => 0, 'activate_ordering_system' => 0, 'identify_verification' => 0, 'activate_rpm' => 0, 'activate_currency_exchange' => 0, 'activate_cash_advance' => 0, 'activate_crypto_currency_account' => 0, 'approved_customers' => 0, 'approved_merchants' => 0, 'points_acquired' => $totPointLeft, 'current_point' => $getPoint->points_acquired]);



                ClaimedPoints::updateOrCreate(['user_id' => Auth::user()->id], [
                    'user_id' => Auth::user()->id,
                    'points_acquired' => $getPoint->points_acquired,
                    'points_left' => $totPointLeft,
                    'status' => 'pending'
                ]);

                HistoryReport::insert([
                    'user_id' => Auth::user()->id,
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



    public function claimedReferralPoints(Request $req)
    {

        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Claim Point';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
            } else {

                return redirect()->route('login');
            }
        } else {

            $user = User::where('email', session('email'))->first();

            Auth::login($user);

            $this->page = 'Claim Point';
            $this->name = Auth::user()->name;
            $this->email = Auth::user()->email;
        }

        // Get Bill
        $getPoint = User::where('id', Auth::user()->id)->first();



        if (isset($getPoint)) {

            if (Auth::user()->accountType == "Merchant") {

                $max = 500;
            } else {

                $max = 500;
            }


            $totPointLeft = $getPoint->referral_points - $max;


            $pointtoget = $max - $getPoint->referral_points;

            // Process claims and update user

            if ($getPoint->referral_points >= $max) {



                // This is when you can claim points...
                // Points::where('user_id', Auth::user()->id)->update(['add_money' => 0, 'send_money' => 0, 'receive_money' => 0, 'pay_invoice' => 0, 'pay_bills' => 0, 'create_and_send_invoice' => 0, 'active_rental_property' => 0, 'quick_set_up' => 0, 'identity_verification' => 0, 'business_verification' => 0, 'promote_business' => 0, 'activate_ordering_system' => 0, 'identify_verification' => 0, 'activate_rpm' => 0, 'activate_currency_exchange' => 0, 'activate_cash_advance' => 0, 'activate_crypto_currency_account' => 0, 'approved_customers' => 0, 'approved_merchants' => 0, 'points_acquired' => $totPointLeft, 'current_point' => $getPoint->points_acquired]);



                ReferralClaim::insert([
                    'user_id' => Auth::user()->id,
                    'country' => Auth::user()->country,
                    'user_type' => Auth::user()->accountType,
                    'points_acquired' => $getPoint->referral_points,
                    'points_claimed' => $max,
                    'points_left' => $totPointLeft,
                    'status' => 'pending'
                ]);

                HistoryReport::insert([
                    'user_id' => Auth::user()->id,
                    'points' => $getPoint->referral_points,
                    'point_activity' => "You have claimed " . $getPoint->referral_points . " points today " . date('d/m/y')

                ]);

                User::where('id', Auth::user()->id)->update([
                    'referral_points' => $totPointLeft,
                ]);

                $resData = 'Your points claimed has been submitted successfully. The reward will be processed within the next 24hrs';
                $resp = "success";
            } else {

                $resData = 'You need to have ' . $pointtoget . ' more to be able to claim reward';
                $resp = "error";
            }
        } else {

            $resData = 'You do not have any acquired points';
            $resp = "error";
        }




        return redirect()->back()->with($resp, $resData);
    }



    public function claimedHistory(Request $req)
    {

        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Claim History';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
            } else {

                return redirect()->route('login');
            }
        } else {

            $user = User::where('email', session('email'))->first();

            Auth::login($user);

            $this->page = 'Claim History';
            $this->name = Auth::user()->name;
            $this->email = Auth::user()->email;
        }

        // Get Bill
        $getPoint = Points::where('user_id', Auth::user()->id)->first();



        $data = array(
            'gethistory' => $getPoint->points_acquired,
            'mypoints' => $this->getAcquiredPoints(Auth::user()->id),
            'pointsclaim' => $this->getClaimedHistory(Auth::user()->id),

        );



        return view('main.claimpointhistory')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email,  'data' => $data]);
    }

    public function consumerPoints(Request $req)
    {



        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Consumer Points';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
            } else {
                $this->page = 'Consumer Points';
                $this->name = '';
            }
        } else {

            $user = User::where('email', session('email'))->first();

            Auth::login($user);

            $this->page = 'Consumer Points';
            $this->name = Auth::user()->name;
            $this->email = Auth::user()->email;
        }

        // Get Bill
        $getAllPoint = Points::where('user_id', Auth::user()->id)->first();



        $data = array(
            'getallpoint' => $getAllPoint,
            'mypoints' => $this->getAcquiredPoints(Auth::user()->id),

        );



        return view('main.consumerpoints')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email,  'data' => $data]);
    }

    public function referredDetails(Request $req)
    {



        if ($req->session()->has('email') == false) {
            if (Auth::check() == true) {
                $this->page = 'Consumer Points';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
            } else {
                $this->page = 'Consumer Points';
                $this->name = '';
            }
        } else {

            $user = User::where('email', session('email'))->first();

            Auth::login($user);

            $this->page = 'Consumer Points';
            $this->name = Auth::user()->name;
            $this->email = Auth::user()->email;
        }

        // Get Bill
        $getAllPoint = Points::where('user_id', Auth::user()->id)->first();



        $data = array(
            'getallpoint' => $getAllPoint,
            'mypoints' => $this->getAcquiredPoints(Auth::user()->id),
            'referred' => $this->referral(Auth::user()->ref_code),
            'referral point' => $this->referralPoints(Auth::user()->id),
            'point claimed' => $this->pointsClaimed(Auth::user()->id),
            'points_history' => $this->pointHistory(Auth::user()->id),

        );





        return view('main.referred')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email,  'data' => $data]);
    }


    public function getmystatement(Request $req)
    {



        $from = $req->start_date;
        $nextDay = $req->end_date;

        // Get Bill
        // $getInvs =  DB::table('invoice_payment')
        //              ->select(DB::raw('invoice_payment.transactionid, invoice_payment.name, invoice_payment.email, import_excel.amount as invoice_amount, invoice_payment.invoice_no, invoice_payment.service, invoice_payment.created_at as transaction_date, import_excel.description as description, invoice_payment.remaining_balance as runningbalance, invoice_payment.amount as amount_paid, import_excel.status, invoice_payment.mystatus'))->distinct()
        //              ->join('import_excel', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')
        //             ->where('invoice_payment.email', $req->email)->where('invoice_payment.service', $req->service)
        //             ->whereBetween('invoice_payment.created_at', [$from, $nextDay])
        //             ->orderBy('invoice_payment.created_at', 'DESC')->get();


        $getInvs = Statement::where('user_id', $req->email)->where('activity', 'LIKE', '%' . $req->service . '%')->whereBetween('trans_date', [$from, $nextDay])->orderBy('created_at', 'DESC')->get();


        if (count($getInvs) > 0) {
            $myStatement = $getInvs;
        } else {

            $myStatement = array('0' => ['error' => 'No statement record', 'info' => 'no_exist']);
            $status = "none";

            // $getInvoice = ImportExcel::where('payee_email', $req->email)->where('service', $req->service)->whereBetween('created_at', [$from, $nextDay])->get();

            // if(count($getInvoice) > 0){
            //     $myStatement = $getInvoice;
            //     $status = "invoice";
            // }
            // else{
            //     $myStatement = array('0' => ['error' => 'No statement record', 'info' => 'no_exist']);
            //     $status = "none";
            // }
        }




        if (count($myStatement) > 0) {
            // Check For If Invoice belongs to USer
            $resData = ['res' => 'Fetching Data', 'message' => 'success', 'data' => json_encode($myStatement), 'info' => 'mystatement', 'title' => 'Good'];
        } else {
            $resData = ['res' => 'You do not have record for this service', 'message' => 'error', 'title' => 'Oops!', 'info' => 'no_exist'];
        }



        return $this->returnJSON($resData, 200);
    }


    public function getOrganization(Request $req)
    {

        $thisuser = User::where('api_token', $req->bearerToken())->first();

        if ($req->user_id == $thisuser->ref_code) {

            if ($req->action == "rec") {
                $res = '<b style="color: red">You can not receive money from yourself</b>';
            } else {
                $res = '<b style="color: red">You can not send money to yourself</b>';
            }

            $resData = ['res' => $res, 'message' => 'error'];
        } elseif ($thisuser->approval == 0) {

            if ($thisuser->approval == 0) {

                $identity = "means of identification,";
            } else {
                $identity = "";
            }
            if ($thisuser->transaction_pin == null) {
                $transPin = " and your transaction Pin code.";
            } else {
                $transPin = "";
            }
            if ($thisuser->securityQuestion == null) {
                $secQuest = "your security questions and answer";
            } else {
                $secQuest = "";
            }

            if ($thisuser->accountType == "Individual") {
                $route = route('profile');
            } else {
                $route = route('merchant profile');
            }


            $res = '<small><b class="text-danger">You cannot send money because your account is not yet approved and you have not set up your ' . $identity . ' ' . $secQuest . ' ' . $transPin . ' Kindly complete these important steps in your <a href=' . $route . ' class="text-primary" style="text-decoration: underline">profile.</a></b></small>';

            $resData = ['res' => $res, 'message' => 'error'];
        } else {


            if ($req->action == "rec") {

                // Get Users
                $data = DB::table('organization_pay')
                    ->select(DB::raw('organization_pay.id as orgId, organization_pay.purpose, organization_pay.amount_to_send, users.*'))
                    ->join('users', 'organization_pay.payer_id', '=', 'users.ref_code')->where('organization_pay.state', 1)->where('organization_pay.request_receive', '!=', 2)->where('organization_pay.payer_id', $req->user_id)->orWhere('organization_pay.payer_id', $req->code . '-' . $req->user_id)->where('organization_pay.coy_id', $thisuser->ref_code)->orderBy('organization_pay.created_at', 'DESC')->get();




                if (count($data) > 0) {
                    // Get Sender Details

                    $resData = ['res' => 'Fetching Data', 'message' => 'success', 'data' => json_encode($data), 'title' => 'Good', 'country' => $thisuser->country];
                } else {
                    $resData = ['res' => 'Receiver not found', 'message' => 'error'];
                }
            } else {
                // Get Users
                $data = User::where('ref_code', $req->user_id)->orWhere('ref_code', $req->code . '-' . $req->user_id)->get();


                if (count($data) > 0) {

                    $resData = ['res' => 'Fetching Data', 'message' => 'success', 'data' => json_encode($data), 'title' => 'Good', 'country' => $thisuser->country];
                } else {

                    // Get Users
                    $result = User::where('name', 'LIKE', '%' . $req->user_id . '%')->where('name', 'NOT LIKE', '%' . $thisuser->name . '%')->get();



                    if (count($result)) {

                        $resData = ['res' => 'Fetching Data', 'message' => 'success', 'data' => json_encode($result), 'title' => 'Good', 'country' => $thisuser->country];
                    } else {


                        $resData = ['res' => 'Receiver not on PaySprint. <strong><a href="' . route('create new payment', 'country=' . $thisuser->country) . '">You can proceeed to send money</a></strong>', 'message' => 'error'];
                    }
                }
            }
        }




        return $this->returnJSON($resData, 200);
    }


    public function exportToExcel(Request $req)
    {

        $query = [
            'email' => Auth::user()->email,
            'currencyCode' => Auth::user()->currencyCode,
            'service' => $req->service,
            'from' => $req->start_date,
            'nextDay' => $req->end_date,
        ];


        $transExport = new TransactionExport($query);

        if ($req->type == "excel") {

            return Excel::download($transExport, mt_rand() . date('dmYhis') . '.xlsx');
        } else {

            return Excel::download($transExport, mt_rand() . date('dmYhis') . '.pdf');
        }
    }

    public function ajaxgetBronchure(Request $req)
    {

        // Check if email exist
        $getCheck = Bronchure::where('email', $req->email)->get();

        if (count($getCheck) > 0) {
            // Update
            $updt = Bronchure::where('email', $req->email)->update(['name' => $req->name, 'email' => $req->email, 'status' => 1]);

            if ($updt == 1) {
                $resData = ['res' => 'Thanks.', 'message' => 'success', 'title' => 'Great!'];
            } else {
                $resData = ['res' => 'Something went wrong', 'message' => 'error', 'title' => 'Oops!'];
            }
        } else {
            // Insert
            $insert = Bronchure::insert(['name' => $req->name, 'email' => $req->email, 'status' => 1]);

            if ($insert == true) {
                // Send Mail to PaySprint
                $this->name = $req->name;
                $this->email = $req->email;
                $this->subject = "Bronchure Download";
                $this->message = $req->name . " just downloaded PaySprint bronchure. Email is stateted below: <br><br> Email: " . $req->email . "<br><br> Thanks.";

                // $this->sendEmail($this->to, $this->subject);

                $resData = ['res' => 'Thanks.', 'message' => 'success', 'title' => 'Great!'];
            } else {
                $resData = ['res' => 'Something went wrong', 'message' => 'error', 'title' => 'Oops!'];
            }
        }

        return $this->returnJSON($resData, 200);
    }


    public function getPayment(Request $req)
    {

        $getInvoice = DB::table('import_excel')
            ->select(DB::raw('import_excel.name as name, import_excel.payee_email as payee_email, import_excel.service as service, invoice_payment.remaining_balance as remaining_balance, import_excel.amount as amount, import_excel.uploaded_by, import_excel.invoice_no, invoice_payment.amount as amount_paid'))
            ->join('invoice_payment', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')
            ->where('import_excel.invoice_no', $req->invoice_no)
            ->orderBy('invoice_payment.created_at', 'DESC')
            ->get();


        if (count($getInvoice) > 0) {
            $resData = ['res' => 'Click continue to proceed to payment', 'message' => 'success', 'title' => 'Good', 'data' => json_encode($getInvoice)];
        } else {
            // Do the other
            $getInvoices = ImportExcel::where('invoice_no', $req->invoice_no)->get();

            if (count($getInvoices) > 0) {
                $resData = ['res' => 'Click continue to proceed to payment', 'message' => 'success', 'title' => 'Good', 'data' => json_encode($getInvoices)];
            } else {
                $resData = ['res' => 'Reference number not found', 'message' => 'error', 'title' => 'Oops!'];
            }
        }

        return $this->returnJSON($resData, 200);
    }


    public function contactus(Request $req)
    {
        // Insert Record
        $contactUs = Contactus::insert(['name' => $req->name, 'email' => $req->email, 'subject' => $req->subject, 'website' => $req->website, 'message' => $req->message, 'country' => $req->country]);

        if ($contactUs == true) {

            $this->name = $req->name;
            $this->email = $req->email;
            $this->subject = $req->subject;
            $this->website = $req->website;
            $this->country = $req->country;
            $this->message = $req->message;

            // Log::notice("Name: ".$this->name."\n Email: ".$this->email."\n Subject: ".$this->subject."\n Website: ".$this->website."\n Country: ".$this->country."\n Message: ".$this->message);

            $this->slack("Name: " . $this->name . "\n Email: " . $this->email . "\n Subject: " . $this->subject . "\n Website: " . $this->website . "\n Country: " . $this->country . "\n Message: " . $this->message, $room = "contactus", $icon = ":longbox:", env('LOG_SLACK_CONTACT_URL'));

            if ($this->timezone[0] == "Africa") {

                $this->sendEmail($this->customerserviceto, "Contact us");
            } else {

                $this->sendEmail($this->to, "Contact us");
            }


            $resData = ['res' => 'Thanks for sending us a message, we will get back to you as soon as possible', 'message' => 'success'];
        } else {
            $resData = ['res' => 'Something went wrong', 'message' => 'error'];
        }

        return $this->returnJSON($resData, 200);
    }


    public function ajaxcreateMaintenance(Request $req)
    {

        // dd($req->all());


        $post_id = mt_rand(00000, 99999);
        $unit_id = $req->unit_id;
        // check if exist
        $maint_req = MaintenanceRequest::where('post_id', $post_id)->get();

        if (count($maint_req) > 0) {
            // Already made request
            $resData = ['res' => 'You have already made this request', 'message' => 'error', 'title' => 'Oops!'];
        } else {

            $fileToStore = "";


            if ($req->file('add_file') && count($req->file('add_file')) > 0) {
                $i = 0;
                foreach ($req->file('add_file') as $key => $value) {


                    //Get filename with extension
                    $filenameWithExt = $value->getClientOriginalName();
                    // Get just filename
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    // Get just extension
                    $extension = $value->getClientOriginalExtension();

                    // Filename to store
                    $fileNameToStore = rand() . '_' . time() . '.' . $extension;

                    $fileToStore .=  $fileNameToStore . ",";


                    //Upload Image
                    // $path = $value->storeAs('public/maintenancefile', $fileNameToStore);

                    // $path = $value->move(public_path('/maintenancefile/'), $fileNameToStore);

                    $path = $value->move(public_path('../../maintenancefile/'), $fileNameToStore);
                }
            } else {
                $fileToStore = 'noImage.png';
            }


            // Insert new record

            if ($req->problem_in_unit == "Yes") {
                $desc_event = $req->describe_event;
            } else {
                $desc_event = "NILL";
            }

            if ($req->authorize == "on") {
                $permission = "Yes";
            } else {
                $permission = "No";
            }


            $insertRec = MaintenanceRequest::insert(['post_id' => $post_id, 'unit' => $unit_id, 'tenant_name' => $req->ten_name, 'tenant_email' => $req->ten_email, 'owner_id' => $req->property_owner, 'phone_number' => $req->phone_number, 'problem_in_unit' => $req->problem_in_unit, 'describe_event' => $desc_event, 'subject' => $req->subject, 'details' => $req->details, 'additional_info' => $req->additional_info, 'priority' => $req->priority, 'add_file' => $fileToStore, 'status' => 'submitted']);


            if ($insertRec == true) {
                // Send Mail

                // Get Property owner information and mail
                $clientinfo = ClientInfo::where('user_id', $req->property_owner)->get();


                if ($req->ten_email != $clientinfo[0]->email) {

                    $this->name = $clientinfo[0]->business_name;
                    $this->email = $clientinfo[0]->email;
                    $this->subject = "Maintenace Request";
                    $this->message = "Hi " . $this->name . ", <br> A tenant, <b>" . $req->ten_name . "</b>, submitted Maintenance Request: -- <b>" . $req->subject . "</b>. <br><br> <table style='font-family: arial, sans-serif; border-collapse: collapse; width: 100%;'><tbody><tr><td>Maintenance Request #</td><td>" . $post_id . "</td></tr><tr><td>Unit</td><td>" . $unit_id . "</td></tr><tr><td>Tenant Name</td><td>" . $req->ten_name . "</td></tr><tr><td>Tenant Phone Number</td><td>" . $req->phone_number . "</td></tr><tr><td>Status</td><td>Open</td></tr><tr><td>Priority</td><td>" . $req->priority . "</td></tr><tr><td>Is the problem in the unit?</td><td>" . $req->problem_in_unit . "</td></tr><tr><td>Permission granted to enter unit alone?</td><td>" . $permission . "</td></tr><tr><td>Subject</td><td>" . $req->subject . "</td></tr><tr><td>Details</td><td>" . $req->details . "</td></tr><tr><td>Additional Info.</td><td>" . $req->additional_info . "</td></tr></tbody></table> <br><br> Kindly follow these steps to manage the Request: <br> a. Click on this link <a href='https://exbc.ca/login'>https://exbc.ca/login</a> to login to EXBC Account. <br> b. Go to Manage Rental Property on Free Business App and Select Property Manager/Owner <br><br> Thanks <br> PaySprint Management.";



                    if ($fileToStore == "noImage.png") {
                        $filename = "noImage.png";
                    } else {
                        $file = explode(",", $fileToStore);
                        $filename = $file[0];
                    }

                    $this->file = $filename;
                    $this->sendEmail($this->email, "Maintenace Request");
                }



                $this->name = $req->ten_name;
                $this->email = $req->ten_email;
                $this->subject = "Maintenace Request";
                $this->message = "Hi " . $req->ten_name . ", <br> Thank you for contacting us regarding Unit Maintenance -- <b>" . $req->subject . "</b>. <br><br> The management department has received your maintenance request and will do its best to respond to it in a timely manner. <br><br> <table style='font-family: arial, sans-serif; border-collapse: collapse; width: 100%;'><tbody><tr><td>Maintenance Request #</td><td>" . $post_id . "</td></tr><tr><td>Unit</td><td>" . $unit_id . "</td></tr><tr><td>Tenant Name</td><td>" . $req->ten_name . "</td></tr><tr><td>Tenant Phone Number</td><td>" . $req->phone_number . "</td></tr><tr><td>Status</td><td>Open</td></tr><tr><td>Priority</td><td>" . $req->priority . "</td></tr><tr><td>Is the problem in the unit?</td><td>" . $req->problem_in_unit . "</td></tr><tr><td>Permission granted to enter unit alone?</td><td>" . $permission . "</td></tr><tr><td>Subject</td><td>" . $req->subject . "</td></tr><tr><td>Details</td><td>" . $req->details . "</td></tr><tr><td>Additional Info.</td><td>" . $req->additional_info . "</td></tr></tbody></table>";


                if ($fileToStore == "noImage.png") {
                    $filename = "noImage.png";
                } else {
                    $file = explode(",", $fileToStore);
                    $filename = $file[0];
                }

                $this->file = $filename;

                $this->sendEmail($this->email, "Maintenace Request");


                // $this->sendEmail("bambo@vimfile.com", "Maintenace Request");

                $resData = "Sent Successfully";
                $resp = "success";
            } else {
                $resData = "Something went wrong!";
                $resp = "error";
            }
        }


        // return $this->returnJSON($resData, 200);

        return redirect('maintenance/status?s=submitted')->with($resp, $resData);
    }


    public function ajaxgetFacility(Request $req, Building $facility, ClientInfo $client)
    {

        $getclient = $client->where('user_id', $req->user_id)->get();

        if (count($getclient) > 0) {
            // Get Facility
            $ownerfacility = $facility->where('owner_email', $getclient[0]->email)->where('buildinglocation_country', Auth::user()->country)->get();

            if (count($ownerfacility) > 0) {

                $resData = ['data' => json_encode($ownerfacility), 'message' => 'success'];
            } else {
                $resData = ['message' => 'error', 'data' => 'No record'];
            }
        } else {
            $resData = ['message' => 'error', 'data' => 'No record'];
        }


        return $this->returnJSON($resData, 200);
    }


    public function ajaxgetbuildingaddress(Request $req, Building $facility)
    {

        $getfacility = $facility->where('id', $req->id)->get();

        if (count($getfacility) > 0) {
            // Get Facility
            $resData = ['data' => json_encode($getfacility), 'message' => 'success'];
        } else {
            $resData = ['message' => 'error', 'data' => 'No record'];
        }


        return $this->returnJSON($resData, 200);
    }


    public function ajaxnotifyupdate(Request $req, Statement $statement)
    {

        $data = $statement->where('user_id', $req->user_id)->update(['notify' => 1]);

        if (isset($data)) {

            // Get Facility
            $resData = ['data' => 1, 'message' => 'success'];
        } else {
            $resData = ['message' => 'error', 'data' => 'No record'];
        }


        return $this->returnJSON($resData, 200);
    }


    // Get My Client Info
    public function getMyClientInfo($ref_code)
    {
        $data = ClientInfo::where('user_id', $ref_code)->first();

        return $data;
    }




    public function ajaxgetCommission(Request $req)
    {



        $thisuser = User::where('api_token', $req->bearerToken())->first();



        if ($req->pay_method != "Wallet") {

            if ($req->foreigncurrency != $req->localcurrency) {

                // dd($req->localcurrency);

                $dataInfo = $this->convertCurrencyRate($req->foreigncurrency, $req->localcurrency, $req->amount);
            } else {
                $dataInfo = $req->amount;
            }



            // dd($dataInfo);

            if ($req->structure == "Withdrawal") {
                $data = TransactionCost::where('structure', $req->structure)->where('method', "Bank Account")->where('country', $thisuser->country)->first();
            } else {
                $data = TransactionCost::where('structure', $req->structure)->where('method', "Debit Card")->where('country', $thisuser->country)->first();
            }



            /*

                Calculation

                x = Variable * Amount;
                y = Fixed + x;
            */




            if (isset($data) == true) {

                if ($thisuser->country == "Nigeria" && $req->amount <= 2500) {

                    $x = ($data->variable / 100) * $req->amount;

                    $y = 0 + $x;

                    $collection = $y;
                } else {

                    if ($thisuser->country == "Canada") {

                        $x = ($data->variable / 100) * $req->amount;

                        $y = $data->fixed + $x;

                        $collection = $y;
                    } else {

                        if ($req->structure == "Withdrawal") {
                            $data = TransactionCost::where('structure', $req->structure)->where('method', "Bank Account")->where('country', $thisuser->country)->first();
                        } else {
                            $data = TransactionCost::where('structure', $req->structure)->where('method', "Debit Card")->where('country', $thisuser->country)->first();
                        }



                        if (isset($data)) {
                            $x = ($data->variable / 100) * $req->amount;

                            $y = $data->fixed + $x;

                            $collection = $y;
                        } else {
                            $x = (3.00 / 100) * $req->amount;

                            $y = 0.33 + $x;

                            $collection = $y;
                        }
                    }
                }
            } else {

                if ($req->structure == "Withdrawal") {
                    $data = TransactionCost::where('structure', $req->structure)->where('method', "Bank Account")->first();
                } else {
                    $data = TransactionCost::where('structure', $req->structure)->where('method', "Debit Card")->first();
                }



                if (isset($data)) {
                    $x = ($data->variable / 100) * $req->amount;

                    $y = $data->fixed + $x;

                    $collection = $y;
                } else {

                    $x = (3.00 / 100) * $req->amount;

                    $y = 0.33 + $x;

                    $collection = $y;
                }
            }



            if ($req->check == "true") {

                $amountReceive = $req->amount - $collection;

                $state = "commission available";
            } else {
                $amountReceive = $req->amount;
                $state = "commission unavailable";
            }
        } else {
            $amountReceive = $req->amount;
            $state = "commission free";
            $collection = 0;
        }

        if ($thisuser->accountType == "Individual") {
            $subminType = "Consumer Monthly Subscription";
        } else {
            $subminType = "Merchant Monthly Subscription";
        }

        // Change to Classic plan...
        // $minimumBal = TransactionCost::where('structure', $subminType)->where('country', $thisuser->country)->first();


        // if (isset($minimumBal)) {
        //     $available = $minimumBal->fixed;
        // } else {
        //     $available = 5;
        // }
        $available = 0;
        // Check if Wallet is chosen
        $walletCheck = "";

        // if($req->pay_method == "Wallet"){
        $wallet = $thisuser->wallet_balance;

        $availableWalletBalance = $thisuser->wallet_balance - $available;

        if ($availableWalletBalance <= $amountReceive) {

            if ($thisuser->accountType == "Individual") {
                $route = route('Add Money');
            } else {
                $route = route('merchant add money');
            }

            $walletCheck = 'Wallet Balance: <strong>' . $req->localcurrency . number_format($wallet, 2) . '</strong>. <br> Available Wallet Balance: <strong>' . $req->localcurrency . number_format($availableWalletBalance, 2) . '</strong>. <br> Insufficient balance. <a href="' . $route . '">Add money <i class="fa fa-plus" style="font-size: 15px;border-radius: 100%;border: 1px solid grey;padding: 3px;" aria-hidden="true"></i></a>';
        }
        // }



        $resData = ['data' => $amountReceive, 'message' => 'success', 'state' => $state, 'collection' => $collection, 'walletCheck' => $walletCheck, ''];


        return $this->returnJSON($resData, 200);
    }


    public function ajaxgetwalletBalance(Request $req)
    {

        $walletCheck = "";

        if ($req->pay_method == "Wallet") {
            $wallet = Auth::user()->wallet_balance;

            if ($wallet < $req->amount) {
                $walletCheck = 'Wallet Balance: <strong>' . $req->currency . number_format($wallet, 2) . '</strong>. <br> Insufficient balance. <a href="' . route('Add Money') . '">Add money <i class="fa fa-plus" style="font-size: 15px;border-radius: 100%;border: 1px solid grey;padding: 3px;" aria-hidden="true"></i></a>';
            }
        }

        $resData = ['data' => $req->amount, 'message' => 'success', 'walletCheck' => $walletCheck];

        return $this->returnJSON($resData, 200);
    }

    public function convertCurrencyRate($foreigncurrency, $localcurrency, $amount)
    {

        // Get Markup
        $markuppercent = $this->markupPercentage();

        $markValue = (1 + ($markuppercent[0]->percentage / 100));

        $currency = 'USD' . $foreigncurrency;
        $amount = $amount;
        $localCurrency = 'USD' . $localcurrency;

        $access_key = '6173fa628b16d8ce1e0db5cfa25092ac';

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://api.currencylayer.com/live?access_key=' . $access_key,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Cookie: __cfduid=d430682460804be329186d07b6e90ef2f1616160177'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $result = json_decode($response);



        if ($result->success == true) {

            // Conversion Rate USD to Local currency
            // $convertLocal = ($amount / $result->quotes->$localCurrency) * $markValue;
            $convertLocal = ($amount / $result->quotes->$localCurrency);



            $convRate = $result->quotes->$currency * $convertLocal;
        } else {
            $convRate = "Sorry we can not process your transaction this time, try again later!.";
        }


        return $convRate;
    }



    public function maintenancedelete(Request $req)
    {

        // Delete Maintnencae
        $getReq = MaintenanceRequest::where('post_id', $req->post_id)->get();

        if (count($getReq) > 0) {


            // Get Property owner information and mail
            $clientinfo = ClientInfo::where('user_id', $getReq[0]->owner_id)->get();

            if ($getReq[0]->problem_in_unit == "Yes") {
                $desc_event = $getReq[0]->describe_event;
                $permission = "Yes, " . $getReq[0]->describe_event;
            } else {
                $desc_event = "NILL";
                $permission = "No";
            }

            $this->name = $clientinfo[0]->business_name;
            $this->email = $clientinfo[0]->email;
            $this->subject = "Maintenace Request Deleted";
            $this->message = "Hi " . $this->name . ", <br> A tenant, <b>" . $getReq[0]->tenant_name . "</b>, deleted a Maintenance Request: -- <b>" . $getReq[0]->subject . "</b>. <br><br> <table style='font-family: arial, sans-serif; border-collapse: collapse; width: 100%;'><tbody><tr><td>Maintenance Request #</td><td>" . $getReq[0]->post_id . "</td></tr><tr><td>Unit</td><td>" . $getReq[0]->unit_id . "</td></tr><tr><td>Tenant</td><td>" . $getReq[0]->tenant_name . "</td></tr><tr><td>Status</td><td>Open</td></tr><tr><td>Priority</td><td>" . $getReq[0]->priority . "</td></tr><tr><td>Is the problem in the unit?</td><td>" . $getReq[0]->problem_in_unit . "</td></tr><tr><td>Permission granted to enter unit alone?</td><td>" . $permission . "</td></tr><tr><td>Subject</td><td>" . $getReq[0]->subject . "</td></tr><tr><td>Details</td><td>" . $getReq[0]->details . "</td></tr><tr><td>Additional Info.</td><td>" . $getReq[0]->additional_info . "</td></tr></tbody></table> <br><br> Kindly follow these steps to manage the Request: <br> a. Click on this link <a href='https://exbc.ca/login'>https://exbc.ca/login</a> to login to EXBC Account. <br> b. Go to Manage Rental Property on Free Business App and Select Property Manager/Owner <br><br> Thanks <br> PaySprint Management.";



            $this->file = "noImage.png";
            $this->sendEmail($this->email, "Maintenace Request");

            // Delete
            MaintenanceRequest::where('post_id', $req->post_id)->delete();

            // Send Mail to Admin

            $resData = "Deleted Successfully!";
            $resp = "success";
        } else {
            $resData = "Record not found";
            $resp = "error";
        }


        return redirect()->back()->with($resp, $resData);
    }

    public function updatemaintenance(Request $req)
    {

        $fileToStore = "";


        if ($req->file('add_file') && count($req->file('add_file')) > 0) {
            $i = 0;
            foreach ($req->file('add_file') as $key => $value) {
                //Get filename with extension
                $filenameWithExt = $value->getClientOriginalName();
                // Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                // Get just extension
                $extension = $value->getClientOriginalExtension();

                // Filename to store
                $fileNameToStore = rand() . '_' . time() . '.' . $extension;

                $fileToStore .=  $fileNameToStore . ",";
                //Upload Image
                // $path = $value->storeAs('public/maintenancefile', $fileNameToStore);

                // $path = $value->move(public_path('/maintenancefile/'), $fileNameToStore);

                $path = $value->move(public_path('../../maintenancefile/'), $fileNameToStore);
            }

            if ($req->problem_in_unit == "Yes") {
                $desc_event = $req->describe_event;
            } else {
                $desc_event = "NILL";
            }

            if ($req->authorize == "on") {
                $permission = $req->authorize;
            } else {
                $permission = "No";
            }


            $insertRec = MaintenanceRequest::where('post_id', $req->post_id)->update(['post_id' => $req->post_id, 'unit' => $req->unit, 'tenant_name' => $req->ten_name, 'tenant_email' => $req->ten_email, 'owner_id' => $req->property_owner, 'phone_number' => $req->phone_number, 'problem_in_unit' => $req->problem_in_unit, 'describe_event' => $desc_event, 'subject' => $req->subject, 'details' => $req->details, 'additional_info' => $req->additional_info, 'priority' => $req->priority, 'add_file' => $fileToStore]);
        } else {
            if ($req->problem_in_unit == "Yes") {
                $desc_event = $req->describe_event;
            } else {
                $desc_event = "NILL";
            }

            if ($req->authorize == "on") {
                $permission = $req->authorize;
            } else {
                $permission = "No";
            }


            $insertRec = MaintenanceRequest::where('post_id', $req->post_id)->update(['post_id' => $req->post_id, 'unit' => $req->unit, 'tenant_name' => $req->ten_name, 'tenant_email' => $req->ten_email, 'owner_id' => $req->property_owner, 'phone_number' => $req->phone_number, 'problem_in_unit' => $req->problem_in_unit, 'describe_event' => $desc_event, 'subject' => $req->subject, 'details' => $req->details, 'additional_info' => $req->additional_info, 'priority' => $req->priority]);
        }




        $clientinfo = ClientInfo::where('user_id', $req->property_owner)->get();

        if ($req->ten_email != $clientinfo[0]->email) {

            $this->name = $clientinfo[0]->business_name;
            $this->email = $clientinfo[0]->email;
            $this->subject = "Maintenace Request";

            $this->message = "Hi " . $this->name . ", <br> A tenant, <b>" . $req->ten_name . "</b>, submitted Maintenance Request: -- <b>" . $req->subject . "</b>. <br><br> <table style='font-family: arial, sans-serif; border-collapse: collapse; width: 100%;'><tbody><tr><td>Maintenance Request #</td><td>" . $req->post_id . "</td></tr><tr><td>Unit</td><td>" . $req->unit . "</td></tr><tr><td>Tenant Name</td><td>" . $req->ten_name . "</td></tr><tr><td>Tenant Phone Number</td><td>" . $req->phone_number . "</td></tr><tr><td>Status</td><td>Open</td></tr><tr><td>Priority</td><td>" . $req->priority . "</td></tr><tr><td>Is the problem in the unit?</td><td>" . $req->problem_in_unit . "</td></tr><tr><td>Permission granted to enter unit alone?</td><td>" . $permission . "</td></tr><tr><td>Subject</td><td>" . $req->subject . "</td></tr><tr><td>Details</td><td>" . $req->details . "</td></tr><tr><td>Additional Info.</td><td>" . $req->additional_info . "</td></tr></tbody></table> <br><br> Kindly follow these steps to manage the Request: <br> a. Click on this link <a href='https://exbc.ca/login'>https://exbc.ca/login</a> to login to EXBC Account. <br> b. Go to Manage Rental Property on Free Business App and Select Property Manager/Owner <br><br> Thanks <br> PaySprint Management.";


            $this->file = "noImage.png";
            $this->sendEmail($this->email, "Maintenace Request");
        }

        $this->name = $req->ten_name;
        $this->email = $req->ten_email;
        $this->subject = "Maintenace Request";
        $this->message = "Hi " . $req->ten_name . ", <br> Thank you for contacting us regarding Unit Maintenance -- <b>" . $req->subject . "</b>. <br><br> The management department has received your maintenance request and will do its best to respond to it in a timely manner. <br><br> <table style='font-family: arial, sans-serif; border-collapse: collapse; width: 100%;'><tbody><tr><td>Maintenance Request #</td><td>" . $req->post_id . "</td></tr><tr><td>Unit</td><td>" . $req->unit . "</td></tr><tr><td>Tenant Name</td><td>" . $req->ten_name . "</td></tr><tr><td>Tenant Phone Number</td><td>" . $req->phone_number . "</td></tr><tr><td>Status</td><td>Open</td></tr><tr><td>Priority</td><td>" . $req->priority . "</td></tr><tr><td>Is the problem in the unit?</td><td>" . $req->problem_in_unit . "</td></tr><tr><td>Permission granted to enter unit alone?</td><td>" . $permission . "</td></tr><tr><td>Subject</td><td>" . $req->subject . "</td></tr><tr><td>Details</td><td>" . $req->details . "</td></tr><tr><td>Additional Info.</td><td>" . $req->additional_info . "</td></tr></tbody></table>";

        $this->file = "noImage.png";
        $this->sendEmail($req->ten_email, "Maintenace Request");

        $resData = "Updated Successfully!";
        $resp = "success";

        return redirect()->route('maintenanceview', [$req->post_id])->with($resp, $resData);
    }


    // Get all service types
    public function myServices()
    {
        $service = ServiceType::all();

        return $service;
    }

    public function clientsInformation()
    {
        // Get Organization & Businessn JOIN with Building/Facility
        $clientInfo = ClientInfo::orderBy('created_at', 'DESC')->get();

        return $clientInfo;
    }


    public function thisClientsInformation($id)
    {
        // Get Organization & Businessn JOIN with Building/Facility
        $thisClient = Building::where('id', $id)->first();

        $clientInfo = ClientInfo::where('email', $thisClient->owner_email)->orderBy('created_at', 'DESC')->get();

        return $clientInfo;
    }


    public function thisBuildingInformation($id)
    {
        // Get Organization & Businessn JOIN with Building/Facility
        $thisClient = Building::where('id', $id)->where('buildinglocation_country', Auth::user()->country)->first();

        return $thisClient;
    }


    public function sharedDocs($email)
    {


        $getdocuments = MaintenanceRequest::where('tenant_email', $email)->where('add_file', '!=', null)->orderBy('created_at', 'DESC')->get();


        return $getdocuments;
    }


    public function loginApi(Request $req)
    {

        // Check user if exist
        $getUser = User::where('email', $req->email)->first();

        if ($req->action == "login") {
            if (isset($getUser) == true) {
                // Set session
                $req->session()->put(['email' => $getUser->email, 'name' => $getUser->name, 'ref_code' => $getUser->ref_code]);

                $resData = ['res' => 'Welcome ' . $getUser->name, 'message' => 'success', 'link' => '/'];
            }
        } elseif ($req->action == "rpm_tenant") {
            if (isset($getUser) == true) {
                // Set session
                $req->session()->put(['email' => $getUser->email, 'name' => $getUser->name, 'ref_code' => $getUser->ref_code]);

                $resData = ['res' => 'Welcome ' . $getUser->name, 'message' => 'success', 'link' => 'rentalmanagement'];
            }
        } elseif ($req->action == "rpm_property_owner") {
            if (isset($getUser) == true) {
                // Set session
                $req->session()->put(['email' => $getUser->email, 'name' => $getUser->name, 'ref_code' => $getUser->ref_code]);

                $resData = ['res' => 'Welcome ' . $getUser->name, 'message' => 'success', 'link' => 'rentalmanagement/admin'];
            }
        } elseif ($req->action == "rpm_service_provider") {
            if (isset($getUser) == true) {
                // Set session
                $req->session()->put(['email' => $getUser->email, 'name' => $getUser->name, 'ref_code' => $getUser->ref_code]);

                $resData = ['res' => 'Welcome ' . $getUser->name, 'message' => 'success', 'link' => 'rentalmanagement/consultant'];
            }
        }

        User::where('email', $req->email)->update(['api_token' => uniqid() . time()]);
        // Do Auth here
        Auth::login($getUser);







        return $this->returnJSON($resData, 200);
    }


    public function maintenanceCheck($email, $status)
    {
        $getState = MaintenanceRequest::where('tenant_email', $email)->where('status', $status)->orderBy('created_at', 'DESC')->get();

        return $getState;
    }


    public function requestmaintenanceCheck($ref_code, $status)
    {
        $getState = MaintenanceRequest::where('owner_id', $ref_code)->where('status', $status)->orderBy('created_at', 'DESC')->get();
        return $getState;
    }


    public function requestinvoiceCheck($email)
    {
        $getState = ImportExcel::where('payee_email', $email)->where('payment_status', 0)->orderBy('created_at', 'DESC')->get();
        return $getState;
    }

    public function requestquoteCheck($email)
    {
        $getState = RentalQuote::where('property_owner', $email)->orderBy('created_at', 'DESC')->get();
        return $getState;
    }

    public function providersCheck($email)
    {
        $getState = Consultant::where('owner_email', $email)->orderBy('created_at', 'DESC')->get();
        return $getState;
    }

    public function consultantCheck($id)
    {
        $getState = Consultant::where('id', $id)->orderBy('created_at', 'DESC')->get();
        return $getState;
    }


    public function workorderCheck($ref_code, $status)
    {
        $getState = Workorder::where('consultant_email', $ref_code)->where('status', $status)->orderBy('created_at', 'DESC')->get();
        return $getState;
    }

    public function adminworkorderCheck($email)
    {
        // Join with Maintnenance Request

        $getState = DB::table('maintenance_request')
            ->join('rental_message', 'maintenance_request.post_id', '=', 'rental_message.post_id')
            ->where('rental_message.owner_email', $email)
            ->get();


        return $getState;
    }


    public function maintenanceDetail($id)
    {
        $getState = MaintenanceRequest::where('post_id', $id)->get();

        return $getState;
    }

    public function consultmaintenanceDetail($id)
    {
        $getState = MaintenanceRequest::where('assigned_staff', $id)->get();

        return $getState;
    }

    public function quoteDetail($id)
    {
        $getState = RentalQuote::where('maintenance_id', $id)->get();

        return $getState;
    }


    public function facilities()
    {
        $getState = Building::orderBy('created_at', 'DESC')->get();

        return $getState;
    }

    public function facilityInfo($id)
    {
        $getState = Building::where('id', $id)->get();

        return $getState;
    }


    public function paymentHistoryrecord($email)
    {
        $getState = InvoicePayment::where('email', $email)->orderBy('created_at', 'DESC')->get();

        return $getState;
    }


    public function sendEmail($objDemoa, $purpose)
    {
        $objDemo = new \stdClass();
        $objDemo->purpose = $purpose;
        if ($purpose == "Contact us") {

            $objDemo->name = $this->name;
            $objDemo->email = $this->email;
            $objDemo->subject = $this->subject;
            $objDemo->website = $this->website;
            $objDemo->country = $this->country;
            $objDemo->message = $this->message;
        } elseif ($purpose == "Bronchure Download") {

            $objDemo->name = $this->name;
            $objDemo->email = $this->email;
            $objDemo->subject = $this->subject;
            $objDemo->message = $this->message;
        } elseif ($purpose == "Maintenace Request") {

            $objDemo->name = $this->name;
            $objDemo->email = $this->email;
            $objDemo->subject = $this->subject;
            $objDemo->file = $this->file;
            $objDemo->message = $this->message;
        } elseif ($purpose == 'Fund remittance') {
            $objDemo->name = $this->name;
            $objDemo->email = $this->email;
            $objDemo->subject = $this->subject;
            $objDemo->message = $this->message;
        }

        Mail::to($objDemoa)
            ->send(new sendEmail($objDemo));
    }
}
