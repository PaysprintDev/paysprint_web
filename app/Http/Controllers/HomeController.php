<?php

namespace App\Http\Controllers;

use Session;

use App\Mail\sendEmail;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;

use Rap2hpoutre\FastExcel\FastExcel;

use Illuminate\Support\Facades\Mail;

use SimpleSoftwareIO\QrCode\Facades\QrCode;

use Illuminate\Support\Facades\Log;

use App\User as User;

use App\AnonUsers as AnonUsers;

use App\CreateEvent as CreateEvent;

use App\ImportExcel as ImportExcel;

use App\SetupBilling as SetupBilling;

use App\InvoicePayment as InvoicePayment;

use App\ClientInfo as ClientInfo;

use App\OrganizationPay as OrganizationPay;

use App\Contactus as Contactus;

use App\Bronchure as Bronchure;

use App\ServiceType as ServiceType;

use App\Statement as Statement;

use App\MaintenanceRequest as MaintenanceRequest;

use App\Consultant as Consultant;

use App\Workorder as Workorder;

use App\RentalQuote as RentalQuote;

use App\Building as Building;

use App\TransactionCost as TransactionCost;

use App\AddCard as AddCard;

use App\AddBank as AddBank;

use App\CardIssuer as CardIssuer;

use App\Notifications as Notifications;

use App\Traits\RpmApp;

class HomeController extends Controller
{

    public $to = "info@paysprint.net";
    public $page;
    public $email;
    public $name;
    public $subject;
    public $website;
    public $message;
    public $file;
    public $ref_code;

    use RpmApp;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'about', 'ajaxregister', 'ajaxlogin', 'contact', 'service', 'loginApi', 'invoice', 'statement', 'myinvoice', 'setupBills', 'checkmyBills', 'getmyInvoice', 'myreceipt', 'getPayment', 'getmystatement', 'payOrganization', 'getOrganization', 'contactus', 'ajaxgetBronchure', 'rentalManagement', 'maintenance', 'amenities', 'messages', 'paymenthistory', 'documents', 'otherservices', 'ajaxcreateMaintenance', 'maintenanceStatus', 'maintenanceView', 'maintenancedelete', 'maintenanceEdit', 'updatemaintenance', 'rentalManagementAdmin', 'rentalManagementAdminMaintenance', 'rentalManagementAdminMaintenanceview', 'rentalManagementAdminfacility', 'rentalManagementAdminconsultant', 'rentalManagementassignconsultant', 'rentalManagementConsultant', 'rentalManagementConsultantWorkorder', 'rentalManagementConsultantMaintenance', 'rentalManagementConsultantInvoice', 'rentalManagementAdminviewinvoices', 'rentalManagementAdminviewconsultant', 'rentalManagementAdmineditconsultant', 'rentalManagementConsultantQuote', 'rentalManagementAdminviewquotes', 'rentalManagementAdminnegotiate', 'rentalManagementConsultantNegotiate', 'rentalManagementConsultantMymaintnenance', 'facilityview', 'rentalManagementAdminWorkorder', 'ajaxgetFacility', 'ajaxgetbuildingaddress', 'payment', 'paymentOrganization', 'ajaxgetCommission', 'termsOfUse', 'privacyPolicy', 'ajaxnotifyupdate']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        // dd($req->session());

            if(Auth::check() == true){
                $this->page = 'Landing';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'sendReceive' => $this->sendAndReceive(Auth::user()->email),
                    'payInvoice' => $this->payInvoice(Auth::user()->email),
                    'walletTrans' => $this->sendAndReceive(Auth::user()->email),
                    'urgentnotification' => $this->urgentNotification(Auth::user()->email),
                    'currencyCode' => $this->getCurrencyCode(Auth::user()->country),
                    'getCard' => $this->getUserCard(),
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                    'getmerchantsByCategory' => $this->getMerchantsByCategory(),
                );

                $view = 'home';
            }
            else{
                $this->page = 'Home';
                $this->name = '';
                $view = 'main.index';
                $data = [];
            }

            // dd($data);


        return view($view)->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }


    public function authIndex(Request $req)
    {
        // dd($req->session());
            if(Auth::check() == true){
                $this->page = 'Landing';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'sendReceive' => $this->sendAndReceive(Auth::user()->email),
                    'payInvoice' => $this->payInvoice(Auth::user()->email),
                    'walletTrans' => $this->sendAndReceive(Auth::user()->email),
                    'urgentnotification' => $this->urgentNotification(Auth::user()->email),
                    'currencyCode' => $this->getCurrencyCode(Auth::user()->country),
                    'getCard' => $this->getUserCard(),
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                    'getmerchantsByCategory' => $this->getMerchantsByCategory(),
                );
            }
            else{
                $this->page = 'Home';
                $this->name = '';
                $this->email = '';
                $data = [];
            }





        return view('home')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }




    public function about(Request $req)
    {

        if($req->session()->has('email') == false){
            if(Auth::check() == true){
                $this->page = 'About';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;

                $data = array(
                    'sendReceive' => $this->sendAndReceive(Auth::user()->email),
                    'payInvoice' => $this->payInvoice(Auth::user()->email),
                    'walletTrans' => $this->sendAndReceive(Auth::user()->email),
                    'urgentnotification' => $this->urgentNotification(Auth::user()->email),
                    'currencyCode' => $this->getCurrencyCode(Auth::user()->country),
                    'getCard' => $this->getUserCard(),
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                );
            }
            else{
                $this->page = 'About';
                $this->name = '';
                $data = [];
            }

        }
        else{
            $this->page = 'About';
            $this->name = session('name');
            $this->email = session('email');
            $data = [];
        }

        return view('main.about')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }



    public function termsOfUse(Request $req)
    {

        if($req->session()->has('email') == false){
            if(Auth::check() == true){
                $this->page = 'Terms of Use';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                );
            }
            else{
                $this->page = 'Terms of Use';
                $this->name = '';
                $data = [];
            }

        }
        else{
            $this->page = 'Terms of Use';
            $this->name = session('name');
            $this->email = session('email');
            $data = [];
        }

        return view('main.termofuse')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }


    public function privacyPolicy(Request $req)
    {

        if($req->session()->has('email') == false){
            if(Auth::check() == true){
                $this->page = 'Privacy Policy';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                );
            }
            else{
                $this->page = 'Privacy Policy';
                $this->name = '';
                $data = [];
            }

        }
        else{
            $this->page = 'Privacy Policy';
            $this->name = session('name');
            $this->email = session('email');
            $data = [];
        }

        return view('main.privacy')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }


    public function payment(Request $req, $invoice)
    {



        if($req->session()->has('email') == false){
            if(Auth::check() == true){
                $this->page = 'Payment';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                
            }
            else{
                $this->page = 'Payment';
                $this->name = '';
            }

        }
        else{
            $this->page = 'Payment';
            $this->name = session('name');
            $this->email = session('email');
        }


        $data = array(
            'getinvoice' => $this->getthisInvoice($invoice),
            'currencyCode' => $this->getCurrencyCode(Auth::user()->country),
        );

        // dd($data);

        return view('main.payment')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }


    public function paymentOrganization(Request $req, $user_id)
    {
        

        if($req->session()->has('email') == false){
            if(Auth::check() == true){
                $this->page = 'Payment';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
            }
            else{
                $this->page = 'Payment';
                $this->name = '';
            }

        }
        else{
            $this->page = 'Payment';
            $this->name = session('name');
            $this->email = session('email');
        }

        $data = array(
            'paymentorg' => $this->getthisOrganization($user_id),
            'currencyCode' => $this->getCurrencyCode(Auth::user()->country),
            'othercurrencyCode' => $this->otherCurrencyCode($user_id),
            'getCard' => $this->getUserCard(),
        );

        // dd($data);

        return view('main.paymentorganization')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }


    public function createnewPayment(Request $req)
    {


        if($req->session()->has('email') == false){
            if(Auth::check() == true){
                $this->page = 'Payment';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
            }
            else{
                $this->page = 'Payment';
                $this->name = '';
            }

        }
        else{
            $this->page = 'Payment';
            $this->name = session('name');
            $this->email = session('email');
        }

        $data = array(
            'currencyCode' => $this->getCurrencyCode(Auth::user()->country),
            'getCard' => $this->getUserCard(),
        );

        // dd($data);


        return view('main.createnewpayment')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }


    public function getCurrencyCode($country){

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://restcountries.eu/rest/v2/name/'.$country,
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


    public function getUserCard(){

        $data = AddCard::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->get();

        return $data;

    }

    public function getCardIssuer(){

        $data = CardIssuer::orderBy('created_at', 'DESC')->get();

        return $data;

    }

    public function getUserBankDetail(){

        $data = AddBank::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->get();

        return $data;

    }

    public function getthisCard($id){

        $data = AddCard::where('id', $id)->first();

        return $data;

    }


    public function getthisBank($id){

        $data = AddBank::where('id', $id)->first();

        return $data;

    }


    public function walletStatement(){

        $data = Statement::where('user_id', Auth::user()->email)->where('statement_route', 'wallet')->orderBy('created_at', 'DESC')->get();

        return $data;

    }


    public function receiveMoney(Request $req, $id)
    {

        if($req->session()->has('email') == false){
            if(Auth::check() == true){
                $this->page = 'Receive Money';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
            }
            else{
                $this->page = 'Receive Money';
                $this->name = '';
            }

        }
        else{
            $this->page = 'Receive Money';
            $this->name = session('name');
            $this->email = session('email');
        }


        $data = array(
            'getpay' => $this->getthispayment($id),
            'currencyCode' => $this->getCurrencyCode(Auth::user()->country),
        );

        // dd($data);

        return view('main.receivepayment')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }



    public function myAccount(Request $req)
    {

        if($req->session()->has('email') == false){
            if(Auth::check() == true){
                $this->page = 'My Wallet';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
            }
            else{
                $this->page = 'My Wallet';
                $this->name = '';
            }

        }
        else{
            $this->page = 'My Wallet';
            $this->name = session('name');
            $this->email = session('email');
        }


        $data = array(
            'currencyCode' => $this->getCurrencyCode(Auth::user()->country),
            'getCard' => $this->getUserCard(),
            'getBank' => $this->getUserBankDetail(),
            'walletStatement' => $this->walletStatement(),
        );

        // dd($data);

        return view('main.myaccount')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }


    public function addCard(Request $req)
    {

        if($req->session()->has('email') == false){
            if(Auth::check() == true){
                $this->page = 'My Card';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
            }
            else{
                $this->page = 'My Card';
                $this->name = '';
            }

        }
        else{
            $this->page = 'My Card';
            $this->name = session('name');
            $this->email = session('email');
        }


        $data = array(
            'getCard' => $this->getUserCard(),
            'cardIssuer' => $this->getCardIssuer(),
        );


        return view('main.mycard')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }


    public function paymentGateway(Request $req)
    {

        if($req->session()->has('email') == false){
            if(Auth::check() == true){
                $this->page = 'Payment Gateway';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
            }
            else{
                $this->page = 'Payment Gateway';
                $this->name = '';
            }

        }
        else{
            $this->page = 'Payment Gateway';
            $this->name = session('name');
            $this->email = session('email');
        }


        $data = array(
            'getCard' => $this->getUserCard(),
            'cardIssuer' => $this->getCardIssuer(),
        );


        return view('main.gateway')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }



    public function requestExbcCard(Request $req)
    {

        if($req->session()->has('email') == false){
            if(Auth::check() == true){
                $this->page = 'Request Exbc Card';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
            }
            else{
                $this->page = 'Request Exbc Card';
                $this->name = '';
            }

        }
        else{
            $this->page = 'Request Exbc Card';
            $this->name = session('name');
            $this->email = session('email');
        }


        $data = array(
            'getCard' => $this->getUserCard(),
        );


        return view('main.requestexbccard')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }


    public function editCard(Request $req, $id)
    {

        if($req->session()->has('email') == false){
            if(Auth::check() == true){
                $this->page = 'My Card';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
            }
            else{
                $this->page = 'My Card';
                $this->name = '';
            }

        }
        else{
            $this->page = 'My Card';
            $this->name = session('name');
            $this->email = session('email');
        }


        $data = array(
            'getthisCard' => $this->getthisCard($id),
            'cardIssuer' => $this->getCardIssuer(),
        );


        return view('main.editcard')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }




    public function editBank(Request $req, $id)
    {

        if($req->session()->has('email') == false){
            if(Auth::check() == true){
                $this->page = 'My Bank Account';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
            }
            else{
                $this->page = 'My Bank Account';
                $this->name = '';
            }

        }
        else{
            $this->page = 'My Bank Account';
            $this->name = session('name');
            $this->email = session('email');
        }


        $data = array(
            'getthisBank' => $this->getthisBank($id),
        );


        return view('main.editbank')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }


    public function addMoney(Request $req)
    {

        if($req->session()->has('email') == false){
            if(Auth::check() == true){
                $this->page = 'Add Money To Wallet';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
            }
            else{
                $this->page = 'Add Money To Wallet';
                $this->name = '';
            }

        }
        else{
            $this->page = 'Add Money To Wallet';
            $this->name = session('name');
            $this->email = session('email');
        }


        $data = array(
            'currencyCode' => $this->getCurrencyCode(Auth::user()->country),
            'getCard' => $this->getUserCard(),
        );

        

        return view('main.addmoneytowallet')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }


    public function withdrawMoney(Request $req)
    {

        if($req->session()->has('email') == false){
            if(Auth::check() == true){
                $this->page = 'Withdraw Money';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
            }
            else{
                $this->page = 'Withdraw Money';
                $this->name = '';
            }

        }
        else{
            $this->page = 'Withdraw Money';
            $this->name = session('name');
            $this->email = session('email');
        }


        $data = array(
            'currencyCode' => $this->getCurrencyCode(Auth::user()->country),
            'getCard' => $this->getUserCard(),
        );


        return view('main.withdrawmoney')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }


    public function addBankDetail(Request $req)
    {

        if($req->session()->has('email') == false){
            if(Auth::check() == true){
                $this->page = 'Add Bank Detail';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
            }
            else{
                $this->page = 'Add Bank Detail';
                $this->name = '';
            }

        }
        else{
            $this->page = 'Add Bank Detail';
            $this->name = session('name');
            $this->email = session('email');
        }


        $data = array(
            'currencyCode' => $this->getCurrencyCode(Auth::user()->country),
            'getBankDetail' => $this->getUserBankDetail(),
        );


        return view('main.addbankdetail')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }



    public function requestForRefund(Request $req)
    {

        if($req->session()->has('email') == false){
            if(Auth::check() == true){
                $this->page = 'Request For Refund';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
            }
            else{
                $this->page = 'Request For Refund';
                $this->name = '';
            }

        }
        else{
            $this->page = 'Request For Refund';
            $this->name = session('name');
            $this->email = session('email');
        }


        $data = array(
            'currencyCode' => $this->getCurrencyCode(Auth::user()->country),
            'getBankDetail' => $this->getUserBankDetail(),
        );


        return view('main.requestforrefund')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }


    public function allNotifications(Request $req)
    {

        if($req->session()->has('email') == false){
            if(Auth::check() == true){
                $this->page = 'Notifications';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
            }
            else{
                $this->page = 'Notifications';
                $this->name = '';
            }

        }
        else{
            $this->page = 'Notifications';
            $this->name = session('name');
            $this->email = session('email');
        }


        $data = array(
            'currencyCode' => $this->getCurrencyCode(Auth::user()->country),
            'getNotifications' => $this->getUserNotifications(Auth::user()->ref_code),
            'updateNotification' => $this->updateNotification(Auth::user()->ref_code),
        );


        return view('main.allnotifications')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }


    public function merchantCategory(Request $req)
    {
        $service = $req->get('service');

        if($req->session()->has('email') == false){
            if(Auth::check() == true){
                $this->page = 'Merchant By Services';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
            }
            else{
                $this->page = 'Merchant By Services';
                $this->name = '';
            }

        }
        else{
            $this->page = 'Merchant By Services';
            $this->name = session('name');
            $this->email = session('email');
        }


        $data = array(
            'currencyCode' => $this->getCurrencyCode(Auth::user()->country),
            'getNotifications' => $this->getUserNotifications(Auth::user()->ref_code),
            'getMerchantHere' => $this->getMerchantHere($service),
        );


        return view('main.merchantcategory')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }


    public function getMerchantHere($service){
        $data = ClientInfo::where('type_of_service', $service)->where('country', Auth::user()->country)->orderBy('created_at', 'DESC')->get();

        return $data;
    }
    public function getUserNotifications($ref_code){
        $data = Notifications::where('ref_code', $ref_code)->orderBy('created_at', 'DESC')->get();

        return $data;
    }


    public function getfiveUserNotifications($ref_code){
        $data = Notifications::where('ref_code', $ref_code)->latest()->take(5)->get();

        return $data;
    }

    public function getMerchantsByCategory(){
        $data = ClientInfo::where('type_of_service', '!=', null)->orderBy('created_at', 'DESC')->groupBy('type_of_service')->get();

        return $data;
    }

    public function updateNotification($ref_code){
        $data = Notifications::where('ref_code', $ref_code)->update(['notify' => 1]);

        return $data;
    }

    public function getthispayment($id){

        $data = DB::table('organization_pay')
        ->select(DB::raw('organization_pay.id as orgId, organization_pay.purpose, organization_pay.amount_to_send, organization_pay.amountindollars, users.*'))
        ->join('users', 'organization_pay.payer_id', '=', 'users.ref_code')->where('organization_pay.id', $id)->where('organization_pay.request_receive', '!=', 2)->first();

        return $data;
    }


    public function getthisOrganization($user_id){

        // Get User

        // $orgDetail = ClientInfo::where('user_id', $user_id)->get();
        $orgDetail = User::where('ref_code', $user_id)->first();

        return $orgDetail;
    }

    public function otherCurrencyCode($user_id){
        $userData = User::where('ref_code', $user_id)->first();

        $data = $this->getCurrencyCode($userData->country);

        return $data;
        
    }


    public function getthisInvoice($invoice){
        $getInvoice = DB::table('import_excel')
                     ->select(DB::raw('import_excel.name as name, import_excel.payee_ref_no, import_excel.payee_email as payee_email, import_excel.service as service, invoice_payment.remaining_balance as remaining_balance, import_excel.amount as amount, import_excel.uploaded_by, import_excel.invoice_no, invoice_payment.amount as amount_paid'))
                     ->join('invoice_payment', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')
                     ->where('import_excel.invoice_no', $invoice)
                    ->orderBy('invoice_payment.created_at', 'DESC')
                    ->get();

                    if(count($getInvoice) > 0){
                        $data = $getInvoice;
                    }
                    else{
                        $data = ImportExcel::where('invoice_no', $invoice)->get();
                    }

                    return $data;
    }

    public function invoice(Request $req)
    {
        // dd($req->session());
        if($req->session()->has('email') == false){
            if(Auth::check() == true){
                $this->page = 'Invoice';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                );
            }
            else{
                $this->page = 'Invoice';
                $this->name = '';
                $data = [];
            }

        }
        else{
            $this->page = 'Invoice';
            $this->name = session('name');
            $this->email = session('email');
            $data = [];
        }

        $service = $this->myServices();

        return view('main.invoice')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'service' => $service, 'data' => $data]);
    }

    public function statement(Request $req)
    {

        if($req->session()->has('email') == false){
            if(Auth::check() == true){
                $this->page = 'Statement';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                    'service' => $this->myServices(),
                );
            }
            else{
                $this->page = 'Statement';
                $this->name = '';
                $data = [];
            }

        }
        else{
            $this->page = 'Statement';
            $this->name = session('name');
            $this->email = session('email');
            $data = [];
        }

        return view('main.statement')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }



    public function rentalManagement(Request $req)
    {

        if($req->session()->has('email') == false){
            if(Auth::check() == true){
                $this->page = 'Rental Property Management';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                );
            }
            else{
                $this->page = 'Rental Property Management';
                $this->name = '';
                $data = [];
            }


        }
        else{
            $this->page = 'Rental Property Management';
            $this->name = session('name');
            $this->email = session('email');
            $data = [];
        }

        return view('main.rentalmanagement')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }


    public function rentalManagementAdmin(Request $req)
    {

        if($req->session()->has('email') == false){
            if(Auth::check() == true){
                $this->page = 'Rental Property Management for Property Owner';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                );
            }
            else{
                $this->page = 'Rental Property Management for Property Owner';
                $this->name = '';
                $data = [];
            }

        }
        else{
            $this->page = 'Rental Property Management for Property Owner';
            $this->name = session('name');
            $this->email = session('email');
            $data = [];
        }

        return view('main.rentalmanagementadmin')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }


    public function rentalManagementConsultant(Request $req, Consultant $consultant)
    {

        if($req->session()->has('email') == false){
            if(Auth::check() == true){
                $this->page = 'Rental Property Management for Service Providers';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                );
            }
            else{
                $this->page = 'Rental Property Management for Service Providers';
                $this->name = '';
                $data = [];
            }

        }
        else{
            $this->page = 'Rental Property Management for Service Providers';
            $this->name = session('name');
            $this->email = session('email');
            $data = [];
        }

        $getId = $consultant->where('consultant_email', $this->email)->get();

        if(count($getId) > 0){
            $id = $getId[0]->id;
        }
        else{
            // Route to EXBC
            $resData = "No maintenance assigned to you yet";
            $resp = "error";
            return redirect()->back()->with($resp, $resData);
        }


        return view('main.rentalmanagementconsultant')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'id' => $id, 'data' => $data]);
    }



    public function rentalManagementConsultantWorkorder(Request $req)
    {

        if($req->session()->has('email') == false){
            if(Auth::check() == true){
                $this->page = 'Rental Property Management for Service Providers';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                );
            }
            else{
                $this->page = 'Rental Property Management for Service Providers';
                $this->name = '';
                $data = [];
            }

        }
        else{
            $this->page = 'Rental Property Management for Service Providers';
            $this->name = session('name');
            $this->email = session('email');
            $data = [];
        }


        $statuschecker = $this->workorderCheck($this->email, $req->get('s'));

        return view('main.rentalmanagementworkorder')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'statuschecker' => $statuschecker, 'data' => $data]);
    }


    public function rentalManagementConsultantMymaintnenance(Request $req, $id)
    {

        if($req->session()->has('email') == false){
            if(Auth::check() == true){
                $this->page = 'Rental Property Management for Service Providers';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                );
            }
            else{
                $this->page = 'Rental Property Management for Service Providers';
                $this->name = '';
                $data = [];
            }

        }
        else{
            $this->page = 'Rental Property Management for Service Providers';
            $this->name = session('name');
            $this->email = session('email');
            $data = [];
        }


        $maintdetail = $this->consultmaintenanceDetail($id);

        return view('main.rentalmanagementmymaintenance')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'maintdetail' => $maintdetail, 'data' => $data]);
    }


    public function rentalManagementConsultantMaintenance(Request $req, $id)
    {

        if($req->session()->has('email') == false){
            if(Auth::check() == true){
                $this->page = 'Rental Property Management for Service Providers';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                );
            }
            else{
                $this->page = 'Rental Property Management for Service Providers';
                $this->name = '';
                $data = [];
            }

        }
        else{
            $this->page = 'Rental Property Management for Service Providers';
            $this->name = session('name');
            $this->email = session('email');
            $data = [];
        }


        $statuschecker = $this->workorderCheck($this->email, $req->get('s'));
        $maintdetail = $this->maintenanceDetail($id);

        return view('main.rentalmanagementmaintenance')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'statuschecker' => $statuschecker, 'maintdetail' => $maintdetail, 'data' => $data]);
    }


    public function rentalManagementConsultantInvoice(Request $req, $id)
    {

        // dd(Session::all());

        if($req->session()->has('email') == false){
            if(Auth::check() == true){
                $this->page = 'Rental Property Management for Service Providers';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                );
            }
            else{
                $this->page = 'Rental Property Management for Service Providers';
                $this->name = '';
                $data = [];
            }

        }
        else{
            $this->page = 'Rental Property Management for Service Providers';
            $this->name = session('name');
            $this->email = session('email');
            $data = [];
        }


        $statuschecker = $this->workorderCheck($this->email, $req->get('s'));
        $maintdetail = $this->maintenanceDetail($id);

        return view('main.rentalmanagementinvoice')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'statuschecker' => $statuschecker, 'maintdetail' => $maintdetail, 'data' => $data]);
    }


    public function rentalManagementConsultantQuote(Request $req, $id)
    {

        // dd(Session::all());

        if($req->session()->has('email') == false){
            if(Auth::check() == true){
                $this->page = 'Rental Property Management for Service Providers';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                );
            }
            else{
                $this->page = 'Rental Property Management for Service Providers';
                $this->name = '';
                $data = [];
            }

        }
        else{
            $this->page = 'Rental Property Management for Service Providers';
            $this->name = session('name');
            $this->email = session('email');
            $data = [];
        }


        $statuschecker = $this->workorderCheck($this->email, $req->get('s'));
        $maintdetail = $this->maintenanceDetail($id);

        return view('main.rentalmanagementquote')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'statuschecker' => $statuschecker, 'maintdetail' => $maintdetail, 'data' => $data]);
    }


    public function rentalManagementConsultantNegotiate(Request $req, $id)
    {

        // dd(Session::all());

        if($req->session()->has('email') == false){
            if(Auth::check() == true){
                $this->page = 'Rental Property Management for Service Providers';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                );
            }
            else{
                $this->page = 'Rental Property Management for Service Providers';
                $this->name = '';
                $data = [];
            }

        }
        else{
            $this->page = 'Rental Property Management for Service Providers';
            $this->name = session('name');
            $this->email = session('email');
            $data = [];
        }


        $statuschecker = $this->workorderCheck($this->email, $req->get('s'));
        $viewquotedetail = $this->quoteDetail($id);

        return view('main.rentalmanagementnegotiate')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'statuschecker' => $statuschecker, 'viewquotedetail' => $viewquotedetail, 'data' => $data]);
    }


    public function rentalManagementAdminfacility(Request $req)
    {

        if($req->session()->has('email') == false){
            if(Auth::check() == true){
                $this->page = 'Statement';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                );
            }
            else{
                $this->page = 'Rental Property Management for Property Owner';
                $this->name = '';
                $data = [];
            }

        }
        else{
            $this->page = 'Rental Property Management for Property Owner';
            $this->name = session('name');
            $this->email = session('email');
            $data = [];
        }

        return view('main.rentalmanagementadminfacility')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }


    public function rentalManagementAdmineditconsultant(Request $req, $id)
    {

        if($req->session()->has('email') == false){
            if(Auth::check() == true){
                $this->page = 'Statement';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                );
            }
            else{
                $this->page = 'Rental Property Management for Property Owner';
                $this->name = '';
                $data = [];
            }

        }
        else{
            $this->page = 'Rental Property Management for Property Owner';
            $this->name = session('name');
            $this->email = session('email');
            $data = [];
        }

        $consultant = $this->consultantCheck($id);

        return view('main.rentalmanagementadminconsultantedit')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'consultant' => $consultant, 'data' => $data]);
    }


    public function rentalManagementAdminconsultant(Request $req)
    {

        if($req->session()->has('email') == false){
            if(Auth::check() == true){
                $this->page = 'Statement';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                );
            }
            else{
                $this->page = 'Rental Property Management for Property Owner';
                $this->name = '';
                $data = [];
            }

        }
        else{
            $this->page = 'Rental Property Management for Property Owner';
            $this->name = session('name');
            $this->email = session('email');
            $data = [];
        }

        return view('main.rentalmanagementadminconsultant')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }


    public function rentalManagementassignconsultant(Request $req, Consultant $consultant, MaintenanceRequest $maintenance, $id)
    {




        if($req->session()->has('email') == false){
            if(Auth::check() == true){
                $this->page = 'Statement';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $ref_code = Auth::user()->ref_code;
            }
            else{
                $this->page = 'Rental Property Management for Property Owner';
                $this->name = '';
                $ref_code = 0;
            }

        }
        else{
            $this->page = 'Rental Property Management for Property Owner';
            $this->name = session('name');
            $this->email = session('email');
            $ref_code = 0;
        }

        $maintreq = $maintenance->where('post_id', $id)->get();
        $consult = $consultant->where('owner_email', $this->email)->get();

        $data = array(
            'maintenance' => $maintreq,
            'consult' => $consult,
            'getfiveNotifications' => $this->getfiveUserNotifications($ref_code)
        );

        // dd($data);


        return view('main.rentalmanagementassignconsultant')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }


    public function maintenance(Request $req)
    {

        if($req->session()->has('email') == false){
            if(Auth::check() == true){
                $this->page = 'Statement';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                );
                
            }
            else{
                $this->page = 'Rental Property Maintenance';
                $this->name = '';
                $data = [];
            }

        }
        else{
            $this->page = 'Rental Property Maintenance';
            $this->name = session('name');
            $this->email = session('email');
            $data = [];
        }

        // Get Organization & Business
        $clientInfo = $this->clientsInformation();


        return view('main.maintenance')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'clientInfo' => $clientInfo, 'data' => $data]);
    }


    public function maintenanceStatus(Request $req)
    {

        if($req->session()->has('email') == false){
            if(Auth::check() == true){
                $this->page = 'Statement';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                );
            }
            else{
                $this->page = 'Rental Property Maintenance';
                $this->name = '';
                $data = [];
            }

        }
        else{
            $this->page = 'Rental Property Maintenance';
            $this->name = session('name');
            $this->email = session('email');
            $data = [];
        }


        // Get Organization & Business
        $statuschecker = $this->maintenanceCheck($this->email, $req->get('s'));

        return view('main.maintenancestatus')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'statuschecker' => $statuschecker, 'data' => $data]);
    }



    public function rentalManagementAdminMaintenance(Request $req)
    {

        if($req->session()->has('email') == false){
            if(Auth::check() == true){
                $this->page = 'Rental Property Maintenance for Property Owner';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $this->ref_code = Auth::user()->ref_code;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                );
            }
            else{
                $this->page = 'Rental Property Maintenance for Property Owner';
                $this->name = '';
                $data = [];
            }

        }
        else{
            $this->page = 'Rental Property Maintenance for Property Owner';
            $this->name = session('name');
            $this->email = session('email');
            $this->ref_code = session('ref_code');
            $data = [];
        }

        // Get Organization & Business
        $statuschecker = $this->requestmaintenanceCheck($this->ref_code, $req->get('s'));

        return view('main.requestmaintenancecheck')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'statuschecker' => $statuschecker, 'data' => $data]);
    }


    public function rentalManagementAdminWorkorder(Request $req)
    {

        if($req->session()->has('email') == false){
            if(Auth::check() == true){
                $this->page = 'Rental Property Maintenance for Property Owner';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $this->ref_code = Auth::user()->ref_code;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                );
            }
            else{
                $this->page = 'Rental Property Maintenance for Property Owner';
                $this->name = '';
                $data = [];
            }

        }
        else{
            $this->page = 'Rental Property Maintenance for Property Owner';
            $this->name = session('name');
            $this->email = session('email');
            $this->ref_code = session('ref_code');
            $data = [];
        }

        // Get Organization & Business
        $statuschecker = $this->adminworkorderCheck($this->email);

        return view('main.adminworkordercheck')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'statuschecker' => $statuschecker, 'data' => $data]);
    }


    public function rentalManagementAdminviewinvoices(Request $req)
    {

        if($req->session()->has('email') == false){
            if(Auth::check() == true){
                $this->page = 'Statement';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $this->ref_code = Auth::user()->ref_code;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                );
            }
            else{
                $this->page = 'Rental Property Maintenance for Property Owner';
                $this->name = '';
                $data = [];
            }

        }
        else{
            $this->page = 'Rental Property Maintenance for Property Owner';
            $this->name = session('name');
            $this->email = session('email');
            $this->ref_code = session('ref_code');
            $data = [];
        }

        // Get Organization & Business
        $statuschecker = $this->requestinvoiceCheck($this->email);

        return view('main.admininvoicecheck')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'statuschecker' => $statuschecker, 'data' => $data]);
    }


    public function rentalManagementAdminviewquotes(Request $req)
    {

        if($req->session()->has('email') == false){
            if(Auth::check() == true){
                $this->page = 'Statement';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $this->ref_code = Auth::user()->ref_code;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                );
            }
            else{
                $this->page = 'Rental Property Maintenance for Property Owner';
                $this->name = '';
                $data = [];
            }

        }
        else{
            $this->page = 'Rental Property Maintenance for Property Owner';
            $this->name = session('name');
            $this->email = session('email');
            $this->ref_code = session('ref_code');
            $data = [];
        }

        // Get Organization & Business
        $statuschecker = $this->requestquoteCheck($this->email);

        return view('main.adminquotecheck')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'statuschecker' => $statuschecker, 'data' => $data]);
    }


    public function rentalManagementAdminnegotiate(Request $req, $id)
    {

        if($req->session()->has('email') == false){
            if(Auth::check() == true){
                $this->page = 'Statement';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $this->ref_code = Auth::user()->ref_code;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                );
            }
            else{
                $this->page = 'Rental Property Maintenance for Property Owner';
                $this->name = '';
                $data = [];
            }

        }
        else{
            $this->page = 'Rental Property Maintenance for Property Owner';
            $this->name = session('name');
            $this->email = session('email');
            $this->ref_code = session('ref_code');
            $data = [];
        }


        $viewquotedetail = $this->quoteDetail($id);

        return view('main.adminquotenegotiate')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'viewquotedetail' => $viewquotedetail, 'data' => $data]);
    }


    public function rentalManagementAdminviewconsultant(Request $req)
    {

        if($req->session()->has('email') == false){
            if(Auth::check() == true){
                $this->page = 'Statement';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $this->ref_code = Auth::user()->ref_code;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                );
            }
            else{
                $this->page = 'Rental Property Maintenance for Property Owner';
                $this->name = '';
                $data = [];
            }

        }
        else{
            $this->page = 'Rental Property Maintenance for Property Owner';
            $this->name = session('name');
            $this->email = session('email');
            $this->ref_code = session('ref_code');
            $data = [];
        }

        // Get Organization & Business
        $providers = $this->providersCheck($this->email);

        return view('main.adminproviders')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'providers' => $providers]);
    }


    public function maintenanceView(Request $req, $id)
    {

        if($req->session()->has('email') == false){
            if(Auth::check() == true){
                $this->page = 'Statement';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                );
            }
            else{
                $this->page = 'Rental Property Maintenance';
                $this->name = '';
                $data = [];
            }

        }
        else{
            $this->page = 'Rental Property Maintenance';
            $this->name = session('name');
            $this->email = session('email');
            $data = [];
        }

        // Get Organization & Business
        $viewmaintdetail = $this->maintenanceDetail($id);

        return view('main.maintenanceview')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'maintdetail' => $viewmaintdetail, 'data' => $data]);
    }

    public function maintenanceEdit(Request $req, $id)
    {

        if($req->session()->has('email') == false){
            if(Auth::check() == true){
                $this->page = 'Statement';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                );
            }
            else{
                $this->page = 'Rental Property Maintenance';
                $this->name = '';
                $data = [];
            }

        }
        else{
            $this->page = 'Rental Property Maintenance';
            $this->name = session('name');
            $this->email = session('email');
            $data = [];
        }

        // Get Organization & Business
        $viewmaintdetail = $this->maintenanceDetail($id);
        $clientInfo = $this->clientsInformation();

        return view('main.maintenanceedit')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'maintdetail' => $viewmaintdetail, 'clientInfo' => $clientInfo, 'data' => $data]);
    }


    public function rentalManagementAdminMaintenanceview(Request $req, $id)
    {

        if($req->session()->has('email') == false){
            if(Auth::check() == true){
                $this->page = 'Statement';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                );
            }
            else{
                $this->page = 'Rental Property Maintenance for Property Owner';
                $this->name = '';
                $data = [];
            }

        }
        else{
            $this->page = 'Rental Property Maintenance for Property Owner';
            $this->name = session('name');
            $this->email = session('email');
            $data = [];
        }

        // Get Organization & Business
        $viewmaintdetail = $this->maintenanceDetail($id);

        return view('main.maintenanceadminview')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'maintdetail' => $viewmaintdetail, 'data' => $data]);
    }


    public function amenities(Request $req)
    {

        if($req->session()->has('email') == false){
            if(Auth::check() == true){
                $this->page = 'Statement';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                );
            }
            else{
                $this->page = 'Rental Property Amenities';
                $this->name = '';
                $data = [];
            }

        }
        else{
            $this->page = 'Rental Property Amenities';
            $this->name = session('name');
            $this->email = session('email');
            $data = [];
        }

        $facilities = $this->facilities();


        return view('main.amenities')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'facilities' => $facilities, 'data' => $data]);
    }

    public function facilityview(Request $req, $id)
    {

        if($req->session()->has('email') == false){
            if(Auth::check() == true){
                $this->page = 'Statement';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                );
            }
            else{
                $this->page = 'Rental Property Amenities';
                $this->name = '';
                $data = [];
            }

        }
        else{
            $this->page = 'Rental Property Amenities';
            $this->name = session('name');
            $this->email = session('email');
            $data = [];
        }

        $facilityinfo = $this->facilityInfo($id);


        return view('main.facilityview')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'facilityinfo' => $facilityinfo, 'data' => $data]);
    }

    public function messages(Request $req)
    {

        if($req->session()->has('email') == false){
            if(Auth::check() == true){
                $this->page = 'Statement';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                );
            }
            else{
                $this->page = 'Rental Property Messages';
                $this->name = '';
                $data = [];
            }

        }
        else{
            $this->page = 'Rental Property Messages';
            $this->name = session('name');
            $this->email = session('email');
            $data = [];
        }

        return view('main.messages')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }


    public function paymenthistory(Request $req)
    {

        if($req->session()->has('email') == false){
            if(Auth::check() == true){
                $this->page = 'Statement';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                );
            }
            else{
                $this->page = 'Rental Property Payment History';
                $this->name = '';
                $data = [];
            }

        }
        else{
            $this->page = 'Rental Property Payment History';
            $this->name = session('name');
            $this->email = session('email');
            $data = [];
        }


        $payhistory = $this->paymentHistoryrecord($this->email);

        return view('main.paymenthistory')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'payhistory' => $payhistory, 'data' => $data]);
    }

    public function documents(Request $req)
    {

        
        if($req->session()->has('email') == false){
            if(Auth::check() == true){
                $this->page = 'Statement';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                );
            }
            else{
                $this->page = 'Rental Property Documents';
                $this->name = '';
                $data = [];
            }

        }
        else{
            $this->page = 'Rental Property Documents';
            $this->name = session('name');
            $this->email = session('email');
            $data = [];
        }


        // Get Shared DOcuments
        $sharedDocs = $this->sharedDocs($this->email);


        return view('main.documents')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'sharedDocs' => $sharedDocs, 'data' => $data]);
    }

    public function otherservices(Request $req)
    {

        if($req->session()->has('email') == false){
            if(Auth::check() == true){
                $this->page = 'Statement';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                );
            }
            else{
                $this->page = 'Rental Property Other Services';
                $this->name = '';
                $data = [];
            }

        }
        else{
            $this->page = 'Rental Property Other Services';
            $this->name = session('name');
            $this->email = session('email');
            $data = [];
        }

        return view('main.otherservices')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }


    public function payOrganization(Request $req)
    {


        if($req->session()->has('email') == false){
            if(Auth::check() == true){
                $this->page = 'Money Transfer';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $ref_code = Auth::user()->ref_code;
                
            }
            else{
                $this->page = 'Money Transfer';
                $this->name = '';
                $ref_code = 0;
            }

        }
        else{
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
        );


        return view('main.payorganization')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'clientInfo' => $clientInfo, 'location' => $location, 'data' => $data]);
    }

    public function notification($email){

        $data = Statement::where('user_id', $email)->where('notify', 0)->count();

        return $data;
    }

    public function allnotification($email){

        $data = Statement::where('user_id', $email)->orderBy('notify', 'ASC')->orderBy('created_at', 'DESC')->get();

        return $data;
    }



    public function myinvoice(Request $req)
    {

        if($req->session()->has('email') == false){
            if(Auth::check() == true){
                $this->page = 'My Invoice';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
            }
            else{
                $this->page = 'My Invoice';
                $this->name = '';
            }

        }
        else{
            $this->page = 'My Invoice';
            $this->name = session('name');
            $this->email = session('email');
        }

        // $getBilling = ImportExcel::where('invoice_no', $req->route('key'))->get();

        $getBilling = DB::table('users')
                     ->select(DB::raw('invoice_payment.transactionid as trans_id, invoice_payment.name, invoice_payment.email, invoice_payment.amount as payedAmount, invoice_payment.invoice_no as paidinvoice_no, invoice_payment.service as paidservice, invoice_payment.remaining_balance as remaining_balance, import_excel.payee_ref_no as payee_ref_no, import_excel.description as description, import_excel.amount as invoice_amount, import_excel.transaction_ref as transaction_ref, invoice_payment.created_at, users.address, users.city, users.state, users.zip, users.country, import_excel.uploaded_by, import_excel.payment_due_date'))
                        ->join('invoice_payment', 'users.email', '=', 'invoice_payment.email')
                         ->join('import_excel', 'invoice_payment.invoice_no', '=', 'import_excel.invoice_no')
                        ->where('invoice_payment.invoice_no', $req->route('key'))
                        ->get();




            if(count($getBilling) > 0){
                $getBilling = $getBilling;
            }
            else{
                $getBilling = DB::table('users')
                     ->select(DB::raw('import_excel.payee_ref_no as trans_id, import_excel.name, import_excel.payee_email as email, import_excel.invoice_no as paidinvoice_no, import_excel.service as paidservice, import_excel.remaining_balance as remaining_balance, import_excel.payee_ref_no as payee_ref_no, import_excel.description as description, import_excel.amount as invoice_amount, import_excel.transaction_ref as transaction_ref, import_excel.created_at, users.address, users.city, users.state, users.zip, users.country, import_excel.uploaded_by, import_excel.payment_due_date'))
                         ->join('import_excel', 'users.email', '=', 'import_excel.payee_email')
                        ->where('import_excel.invoice_no', $req->route('key'))
                        ->get();


            }

            // dd($getBilling);

            




        return view('main.myinvoice')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'invoice' => $getBilling]);
    }


    public function myreceipt(Request $req)
    {

        if($req->session()->has('email') == false){
            if(Auth::check() == true){
                $this->page = 'My Receipt';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
            }
            else{
                $this->page = 'My Receipt';
                $this->name = '';
            }

        }
        else{
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

        if($req->session()->has('email') == false){
            if(Auth::check() == true){
                $this->page = 'My Receipt';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
            }
            else{
                $this->page = 'My Receipt';
                $this->name = '';
            }

        }
        else{
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

        if($req->session()->has('email') == false){
            if(Auth::check() == true){
                $this->page = 'Contact';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                );
            }
            else{
                $this->page = 'Contact';
                $this->name = '';
                $data = [];
            }

        }
        else{
            $this->page = 'Contact';
            $this->name = session('name');
            $this->email = session('email');
            $data = [];
        }

        return view('main.contact')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }


    public function service(Request $req)
    {

        if($req->session()->has('email') == false){
            if(Auth::check() == true){
                $this->page = 'Services';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                );
            }
            else{
                $this->page = 'Services';
                $this->name = '';
                $data = [];
            }

        }
        else{
            $this->page = 'Services';
            $this->name = session('name');
            $this->email = session('email');
            $data = [];
        }

        return view('main.services')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }


    public function ticket(Request $req)
    {

        if($req->session()->has('email') == false){
            if(Auth::check() == true){
                $this->page = 'Create a Ticket';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                );

                $this->getTickets = CreateEvent::where('user_id', $this->email)->orderBy('created_at', 'DESC')->get();
            }
            else{
                $this->page = 'Create a Ticket';
                $this->name = '';
                $data = [];
            }

        }
        else{
            $this->page = 'Create a Ticket';
            $this->name = session('name');
            $this->email = session('email');
            $data = [];

            $this->getTickets = CreateEvent::where('user_id', $this->email)->orderBy('created_at', 'DESC')->get();
        }

        return view('main.ticket')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'getTickets' => $this->getTickets, 'data' => $data]);
    }

    

    public function profile(Request $req)
    {

        if($req->session()->has('email') == false){
            if(Auth::check() == true){
                $this->page = 'Profile Information';
                $this->name = Auth::user()->name;
                $this->email = Auth::user()->email;
                $data = array(
                    'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
                );

            }
            else{
                $this->page = 'Profile Information';
                $this->name = '';
                $data = [];
            }

        }
        else{
            $this->page = 'Profile Information';
            $this->name = session('name');
            $this->email = session('email');
            $data = [];

        }

        return view('main.profile')->with(['pages' => $this->page, 'name' => $this->name, 'email' => $this->email, 'data' => $data]);
    }



    public function sendAndReceive($email){
        $data = Statement::where('user_id', $email)->where('statement_route', 'wallet')->orderBy('created_at', 'DESC')->limit(5)->get();
        return $data;
    }
    public function payInvoice($email){
        $mydata = ImportExcel::select('import_excel.*', 'invoice_payment.*')->join('invoice_payment', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')->where('import_excel.payee_email', $email)->orderBy('import_excel.created_at', 'DESC')->limit(5)->get();

        if(count($mydata) > 0){
            $newdata = ImportExcel::where('payee_email', $email)->orderBy('created_at', 'DESC')->limit(5)->get();
            $data = array_merge($mydata->toArray(), $newdata->toArray());
        }
        else{
            $data = ImportExcel::where('payee_email', $email)->orderBy('created_at', 'DESC')->limit(5)->get();
        }

        // dd($data);
        return json_encode($data);
        
    }
    public function urgentNotification($email){
        $data = Statement::where('user_id', $email)->orderBy('created_at', 'DESC')->limit(5)->get();
        return $data;
    }


    // Custom Ajax Request
    public function ajaxregister(Request $req){

        // Check table if user already exist
        $checkUser = User::where('email', $req->email)->get();

        if(count($checkUser) > 0){
            $resData = ['res' => 'User with email: '.$req->email.' already exist', 'message' => 'error'];
        }else{
            $name = $req->fname.' '.$req->lname;

            $ref_code = mt_rand(00000, 99999);

            $mycode = $this->getCountryCode($req->country);

                $currencyCode = $mycode[0]->currencies[0]->code;
                $currencySymbol = $mycode[0]->currencies[0]->symbol;

                        // Get all ref_codes
            $ref = User::all();

            if(count($ref) > 0){
                foreach($ref as $key => $value){
                    if($value->ref_code == $ref_code){
                        $newRefcode = mt_rand(000000, 999999);
                    }
                    else{
                        $newRefcode = $ref_code;
                    }
                }
            }
            else{
                $newRefcode = $ref_code;
            }

            if($req->ref_code != null){

                $getanonuser = AnonUsers::where('ref_code', $req->ref_code)->first();

                            // Insert User record
                if($req->accountType == "Individual"){
                    // Insert Information for Individual user
                    $insInd = User::insert(['ref_code' => $req->ref_code, 'name' => $name, 'email' => $req->email, 'password' => Hash::make($req->password), 'address' => $req->address, 'city' => $req->city, 'state' => $req->state, 'country' => $req->country, 'accountType' => $req->accountType, 'zip' => $req->zipcode, 'code' => $mycode[0]->callingCodes[0], 'api_token' => uniqid().md5($req->email).time(), 'telephone' => $getanonuser->telephone, 'wallet_balance' => $getanonuser->wallet_balance, 'currencyCode' => $currencyCode, 'currencySymbol' => $currencySymbol]);
                }
                elseif($req->accountType == "Business"){
                    // Insert Information for Business user
                    $insBus = User::insert(['ref_code' => $req->ref_code, 'businessname' => $req->busname, 'name' => $name, 'email' => $req->email, 'password' => Hash::make($req->password), 'address' => $req->address, 'city' => $req->city, 'state' => $req->state, 'country' => $req->country, 'accountType' => $req->accountType, 'zip' => $req->zipcode, 'corporationType' => $req->corporationtype, 'code' => $mycode[0]->callingCodes[0], 'api_token' => uniqid().md5($req->email).time(), 'telephone' => $getanonuser->telephone, 'wallet_balance' => $getanonuser->wallet_balance, 'currencyCode' => $currencyCode, 'currencySymbol' => $currencySymbol]);

                }


                AnonUsers::where('ref_code', $req->ref_code)->delete();

            }
            else{
                            // Insert User record
                if($req->accountType == "Individual"){
                    // Insert Information for Individual user
                    $insInd = User::insert(['ref_code' => $newRefcode, 'name' => $name, 'email' => $req->email, 'password' => Hash::make($req->password), 'address' => $req->address, 'city' => $req->city, 'state' => $req->state, 'country' => $req->country, 'accountType' => $req->accountType, 'zip' => $req->zipcode, 'code' => $mycode[0]->callingCodes[0], 'api_token' => uniqid().md5($req->email).time(), 'currencyCode' => $currencyCode, 'currencySymbol' => $currencySymbol]);

                    // $req->session()->put(['name' => $name, 'email' => $req->email, 'address' => $req->address, 'city' => $req->city, 'state' => $req->state, 'country' => $req->country, 'accountType' => $req->accountType]);
                }
                elseif($req->accountType == "Business"){
                    // Insert Information for Business user
                    $insBus = User::insert(['ref_code' => $newRefcode, 'businessname' => $req->busname, 'name' => $name, 'email' => $req->email, 'password' => Hash::make($req->password), 'address' => $req->address, 'city' => $req->city, 'state' => $req->state, 'country' => $req->country, 'accountType' => $req->accountType, 'zip' => $req->zipcode, 'corporationType' => $req->corporationtype, 'code' => $mycode[0]->callingCodes[0], 'api_token' => uniqid().md5($req->email).time(), 'currencyCode' => $currencyCode, 'currencySymbol' => $currencySymbol]);

                    // $req->session()->put(['businessname' => $req->busname, 'name' => $name, 'email' => $req->email, 'address' => $req->address, 'city' => $req->city, 'state' => $req->state, 'country' => $req->country, 'accountType' => $req->accountType, 'zip' => $req->zipcode, 'corporationType' => $req->corporationtype]);

                }
            }



            $credentials = $req->only('email', 'password');

            if (Auth::attempt($credentials)) {
                $resData = ['res' => 'Hello '.$name.' you will be redirected in 5sec', 'message' => 'success', 'link' => '/'];
            }
            else{
                $resData = ['res' => 'Credential failed', 'message' => 'error'];
            }


           
        }

        return $this->returnJSON($resData, 200);
    }

    public function ajaxlogin(Request $req){
        // Check user if exist
        $userExists = User::where('email', $req->email)->get();
        if(count($userExists) > 0){
            // Check User Password if match
            if(Hash::check($req->password, $userExists[0]['password'])){

                // Check if Flagged or not
                if($userExists[0]['flagged'] == 1){

                    $resData = ['res' => 'Hello '.$userExists[0]['name'].', Your account is restricted from login because you are flagged.', 'message' => 'error'];

                    $this->createNotification($userExists[0]['ref_code'], 'Hello '.$userExists[0]['name'].', Your account is restricted from login because you are flagged.');
                }
                else{
                    $countryInfo = $this->getCountryCode($userExists[0]['country']);

                    $currencyCode = $countryInfo[0]->currencies[0]->code;
                    $currencySymbol = $countryInfo[0]->currencies[0]->symbol;


                    if($userExists[0]['accountType'] == "Merchant"){
                        $resData = ['res' => 'Hello '.$userExists[0]['name'].', your account exists as a merchant. Kindly login on the merchant section', 'message' => 'error'];
                    }
                    else{
                        // Update API Token
                        User::where('email', $req->email)->update(['api_token' => uniqid().md5($req->email).time(), 'currencyCode' => $currencyCode, 'currencySymbol' => $currencySymbol]);

                        $resData = ['res' => 'Welcome back '.$userExists[0]['name'], 'message' => 'success'];
                    }

                    
                }

                
            }else{
                $resData = ['res' => 'Your password is not correct', 'message' => 'info'];
            }
        }
        else{
            $resData = ['res' => 'Your credential does not match our record', 'message' => 'error'];
        }

        return $this->returnJSON($resData, 200);
    }


    public function setupBills(Request $req){
        // Check if invoice number exist...
        $setBills = SetupBilling::where('invoice_no', $req->invoice_no)->get();
        if(count($setBills) > 0){
            // Already Exist, User can check the invoice to see whats there
            $resData = ['res' => 'Bill already setup for '.$req->invoice_no.' will you like to view this bill', 'message' => 'warning', 'info' => 'exist', 'title' => 'Urgh!'];
        }
        else{
            // Insert
            $insBills = SetupBilling::insert(['name' => $req->name, 'email' => $req->email, 'ref_code' => date('dmy').'_'.mt_rand(1000, 9999), 'service' => $req->service, 'invoice_no' => $req->invoice_no, 'date' => $req->date, 'description' => $req->description, 'amount' => $req->amount]);

            if($insBills == true){
                $resData = ['res' => 'You have just set up your bill for INVOICE: '.$req->invoice_no, 'message' => 'success', 'info' => 'good_insert', 'title' => 'Great'];
            }
            else{
                $resData = ['res' => 'Your bill was not properly setup, please refresh and try again', 'message' => 'error', 'info' => 'no_insert', 'title' => 'Oops!'];
            }

        }

        return $this->returnJSON($resData, 200);
    }

    public function checkmyBills(Request $req){
        // Get Bill
        $getBills = SetupBilling::where('invoice_no', $req->invoice_no)->get();

        if(count($getBills) > 0){
            $resData = ['res' => 'Fetching', 'message' => 'success', 'link' => 'Myinvoice/'.$getBills[0]->invoice_no];
        }
        else{
            $resData = ['res' => 'Something went wrong', 'message' => 'error', 'title' => 'Oops!'];
        }
        return $this->returnJSON($resData, 200);
    }

    public function getmyInvoice(Request $req){
        // Get Bill
        $getInvs = ImportExcel::where('invoice_no', $req->invoice_no)->get();

        if(count($getInvs) > 0){
            // Check For If Invoice belongs to USer
            $user = ImportExcel::where('payee_email', $req->email)->where('invoice_no', $getInvs[0]->invoice_no)->get();

            if(count($user) > 0){

                // User correct
                    $resData = ['res' => 'Fetching Data', 'message' => 'success', 'link' => 'Myinvoice/'.$user[0]->invoice_no, 'info' => 'service_correct', 'title' => 'Good'];
            }
            else{

                $resData = ['res' => 'Invoice record exist, but information does not belong to you. Click OK if you would like to continue.', 'message' => 'warning', 'link' => 'Myinvoice/'.$getInvs[0]->invoice_no, 'info' => 'user_no', 'title' => 'Hello'];
            }

        }
        else{
            $resData = ['res' => 'We do not have record for this reference number', 'message' => 'error', 'title' => 'Oops!', 'info' => 'no_exist'];
        }


        return $this->returnJSON($resData, 200);
    }



    public function getmystatement(Request $req){



        $from = $req->start_date;
        $nextDay = $req->end_date;

        // Get Bill
        // $getInvs =  DB::table('invoice_payment')
        //              ->select(DB::raw('invoice_payment.transactionid, invoice_payment.name, invoice_payment.email, import_excel.amount as invoice_amount, invoice_payment.invoice_no, invoice_payment.service, invoice_payment.created_at as transaction_date, import_excel.description as description, invoice_payment.remaining_balance as runningbalance, invoice_payment.amount as amount_paid, import_excel.status, invoice_payment.mystatus'))->distinct()
        //              ->join('import_excel', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')
        //             ->where('invoice_payment.email', $req->email)->where('invoice_payment.service', $req->service)
        //             ->whereBetween('invoice_payment.created_at', [$from, $nextDay])
        //             ->orderBy('invoice_payment.created_at', 'DESC')->get();


            $getInvs = Statement::where('user_id', $req->email)->where('activity', 'LIKE', '%'.$req->service.'%')->whereBetween('trans_date', [$from, $nextDay])->orderBy('created_at', 'DESC')->get();


           if(count($getInvs) > 0){
                $myStatement = $getInvs;
           }

           else{

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




        if(count($myStatement) > 0){
            // Check For If Invoice belongs to USer
            $resData = ['res' => 'Fetching Data', 'message' => 'success', 'data' => json_encode($myStatement), 'info' => 'mystatement', 'title' => 'Good'];
        }
        else{
            $resData = ['res' => 'You do not have record for this service', 'message' => 'error', 'title' => 'Oops!', 'info' => 'no_exist'];
        }
        


        return $this->returnJSON($resData, 200);
    }


    public function getOrganization(Request $req){

        $thisuser = User::where('api_token', $req->bearerToken())->first();

        if($req->user_id == $thisuser->ref_code){

            if($req->action == "rec"){
                $res = '<b style="color: red">You can not receive money from yourself</b>';
            }
            else{
                $res = '<b style="color: red">You can not send money to yourself</b>';
            }

            $resData = ['res' => $res, 'message' => 'error'];
        }
        elseif($thisuser->approval == 0){

            if($thisuser->approval == 0){

                $identity = "means of identification,";
            }
            else{
                $identity = "";
            }
            if($thisuser->transaction_pin == null){
                $transPin = " and your transaction Pin code.";
            }
            else{
                $transPin = "";
            }
            if($thisuser->securityQuestion == null){
                $secQuest = "your security questions and answer";
            }
            else{
                $secQuest = "";
            }

            if($thisuser->accountType == "Individual"){
                $route = route('profile');
            }
            else{
                $route = route('merchant profile');
            }


            $res = '<small><b class="text-danger">You cannot send money because your account is not yet approved and you have not set up your '.$identity.' '.$secQuest.' '.$transPin.' Kindly complete these important steps in your <a href='.$route.' class="text-primary" style="text-decoration: underline">profile.</a></b></small>';

            $resData = ['res' => $res, 'message' => 'error'];
        }
        else{


            if($req->action == "rec"){

                            // Get Users
                $data = DB::table('organization_pay')
                ->select(DB::raw('organization_pay.id as orgId, organization_pay.purpose, organization_pay.amount_to_send, users.*'))
                ->join('users', 'organization_pay.payer_id', '=', 'users.ref_code')->where('organization_pay.state', 1)->where('organization_pay.request_receive', '!=', 2)->
                where('organization_pay.payer_id', $req->user_id)->orWhere('organization_pay.payer_id', $req->code.'-'.$req->user_id)->where('organization_pay.coy_id', $thisuser->ref_code)->orderBy('organization_pay.created_at', 'DESC')->get();


                

                if(count($data) > 0){
                    // Get Sender Details

                    $resData = ['res' => 'Fetching Data', 'message' => 'success', 'data' => json_encode($data), 'title' => 'Good', 'country' => $thisuser->country];
                }
                else{
                    $resData = ['res' => 'Receiver not found', 'message' => 'error'];
                }
                
            }
            else{
                            // Get Users
                $data = User::where('ref_code', $req->user_id)->orWhere('ref_code', $req->code.'-'.$req->user_id)->get();

                
                if(count($data) > 0){

                    $resData = ['res' => 'Fetching Data', 'message' => 'success', 'data' => json_encode($data), 'title' => 'Good', 'country' => $thisuser->country];
                }
                else{

                    // Get Users
                    $result = User::where('name', 'LIKE', '%'.$req->user_id.'%')->where('name', 'NOT LIKE', '%'.$thisuser->name.'%')->get();



                    if(count($result)){

                        $resData = ['res' => 'Fetching Data', 'message' => 'success', 'data' => json_encode($result), 'title' => 'Good', 'country' => $thisuser->country];
                    }
                    else{


                    $resData = ['res' => 'Receiver not on PaySprint. <strong><a href="'.route('create new payment', 'country='.$thisuser->country).'">You can proceeed to send money</a></strong>', 'message' => 'error'];

                    }

                }
            }





        }

        


        return $this->returnJSON($resData, 200);
    }

    public function ajaxgetBronchure(Request $req){

        // Check if email exist
        $getCheck = Bronchure::where('email', $req->email)->get();

        if(count($getCheck) > 0){
            // Update
            $updt = Bronchure::where('email', $req->email)->update(['name' => $req->name, 'email' => $req->email, 'status'=> 1]);

            if($updt == 1){
                $resData = ['res' => 'Thanks.', 'message' => 'success', 'title' => 'Great!'];
            }
            else{
                $resData = ['res' => 'Something went wrong', 'message' => 'error', 'title' => 'Oops!'];
            }
        }
        else{
            // Insert
            $insert = Bronchure::insert(['name' => $req->name, 'email' => $req->email, 'status'=> 1]);

            if($insert == true){
                // Send Mail to PaySprint
                $this->name = $req->name;
                $this->email = $req->email;
                $this->subject = "Bronchure Download";
                $this->message = $req->name." just downloaded PaySprint bronchure. Email is stateted below: <br><br> Email: ".$req->email."<br><br> Thanks.";

                // $this->sendEmail($this->to, $this->subject);

                $resData = ['res' => 'Thanks.', 'message' => 'success', 'title' => 'Great!'];
            }
            else{
                $resData = ['res' => 'Something went wrong', 'message' => 'error', 'title' => 'Oops!'];
            }
        }

        return $this->returnJSON($resData, 200);
    }


    public function getPayment(Request $req){

        $getInvoice = DB::table('import_excel')
                     ->select(DB::raw('import_excel.name as name, import_excel.payee_email as payee_email, import_excel.service as service, invoice_payment.remaining_balance as remaining_balance, import_excel.amount as amount, import_excel.uploaded_by, import_excel.invoice_no, invoice_payment.amount as amount_paid'))
                     ->join('invoice_payment', 'import_excel.invoice_no', '=', 'invoice_payment.invoice_no')
                     ->where('import_excel.invoice_no', $req->invoice_no)
                    ->orderBy('invoice_payment.created_at', 'DESC')
                    ->get();


        if(count($getInvoice) > 0){
            $resData = ['res' => 'Click continue to proceed to payment', 'message' => 'success', 'title' => 'Good', 'data' => json_encode($getInvoice)];
        }
        else{
            // Do the other
            $getInvoices = ImportExcel::where('invoice_no', $req->invoice_no)->get();

            if(count($getInvoices) > 0){
                $resData = ['res' => 'Click continue to proceed to payment', 'message' => 'success', 'title' => 'Good', 'data' => json_encode($getInvoices)];
            }
            else{
                 $resData = ['res' => 'Reference number not found', 'message' => 'error', 'title' => 'Oops!'];
            }


        }

        return $this->returnJSON($resData, 200);
    }


    public function contactus(Request $req){
        // Insert Record
        $contactUs = Contactus::insert(['name' => $req->name, 'email' => $req->email, 'subject' => $req->subject, 'website' => $req->website, 'message' => $req->message]);

        if($contactUs == true){

            $this->name = $req->name;
            $this->email = $req->email;
            $this->subject = $req->subject;
            $this->website = $req->website;
            $this->message = $req->message;

            $this->sendEmail($this->to, "Contact us");

            $resData = ['res' => 'Thanks for sending us a message, we will get back to you as soon as possible', 'message' => 'success'];
        }
        else{
            $resData = ['res' => 'Something went wrong', 'message' => 'error'];
        }

        return $this->returnJSON($resData, 200);

    }


    public function ajaxcreateMaintenance(Request $req){

        // dd($req->all());


        $post_id = mt_rand(00000, 99999);
        $unit_id = $req->unit_id;
        // check if exist
        $maint_req = MaintenanceRequest::where('post_id', $post_id)->get();

        if(count($maint_req) > 0){
            // Already made request
            $resData = ['res' => 'You have already made this request', 'message' => 'error', 'title' => 'Oops!'];
        }
        else{

            $fileToStore = "";

            
            if($req->file('add_file') && count($req->file('add_file')) > 0)
            {
                $i = 0;
                foreach($req->file('add_file') as $key => $value){


                    //Get filename with extension
                    $filenameWithExt = $value->getClientOriginalName();
                    // Get just filename
                    $filename = pathinfo($filenameWithExt , PATHINFO_FILENAME);
                    // Get just extension
                    $extension = $value->getClientOriginalExtension();

                    // Filename to store
                    $fileNameToStore = rand().'_'.time().'.'.$extension;

                    $fileToStore .=  $fileNameToStore.",";


                    //Upload Image
                    // $path = $value->storeAs('public/maintenancefile', $fileNameToStore);

                    // $path = $value->move(public_path('/maintenancefile/'), $fileNameToStore);

                    $path = $value->move(public_path('../../maintenancefile/'), $fileNameToStore);
                }


            }
            else
            {
                $fileToStore = 'noImage.png';
            }


            // Insert new record

            if($req->problem_in_unit == "Yes"){
                $desc_event = $req->describe_event;
            }
            else{
                $desc_event = "NILL";
            }

            if($req->authorize == "on"){
                $permission = "Yes";
            }
            else{
                $permission = "No";
            }


            $insertRec = MaintenanceRequest::insert(['post_id' => $post_id, 'unit' => $unit_id, 'tenant_name' => $req->ten_name, 'tenant_email' => $req->ten_email, 'owner_id' => $req->property_owner, 'phone_number' => $req->phone_number, 'problem_in_unit' => $req->problem_in_unit, 'describe_event' => $desc_event, 'subject' => $req->subject, 'details' => $req->details, 'additional_info' => $req->additional_info, 'priority' => $req->priority, 'add_file' => $fileToStore, 'status' => 'submitted']);


            if($insertRec == true){
                // Send Mail

                // Get Property owner information and mail
                $clientinfo = ClientInfo::where('user_id', $req->property_owner)->get();


                if($req->ten_email != $clientinfo[0]->email){

                    $this->name = $clientinfo[0]->business_name;
                    $this->email = $clientinfo[0]->email;
                    $this->subject = "Maintenace Request";
                    $this->message = "Hi ".$this->name.", <br> A tenant, <b>".$req->ten_name."</b>, submitted Maintenance Request: -- <b>".$req->subject."</b>. <br><br> <table style='font-family: arial, sans-serif; border-collapse: collapse; width: 100%;'><tbody><tr><td>Maintenance Request #</td><td>".$post_id."</td></tr><tr><td>Unit</td><td>".$unit_id."</td></tr><tr><td>Tenant Name</td><td>".$req->ten_name."</td></tr><tr><td>Tenant Phone Number</td><td>".$req->phone_number."</td></tr><tr><td>Status</td><td>Open</td></tr><tr><td>Priority</td><td>".$req->priority."</td></tr><tr><td>Is the problem in the unit?</td><td>".$req->problem_in_unit."</td></tr><tr><td>Permission granted to enter unit alone?</td><td>".$permission."</td></tr><tr><td>Subject</td><td>".$req->subject."</td></tr><tr><td>Details</td><td>".$req->details."</td></tr><tr><td>Additional Info.</td><td>".$req->additional_info."</td></tr></tbody></table> <br><br> Kindly follow these steps to manage the Request: <br> a. Click on this link <a href='https://exbc.ca/login'>https://exbc.ca/login</a> to login to EXBC Account. <br> b. Go to Manage Rental Property on Free Business App and Select Property Manager/Owner <br><br> Thanks <br> PaySprint Management.";



                    if($fileToStore == "noImage.png"){
                        $filename = "noImage.png";
                    }
                    else{
                        $file = explode(",", $fileToStore);
                        $filename = $file[0];

                    }

                    $this->file = $filename;
                    $this->sendEmail($this->email, "Maintenace Request");

                }

                

                    $this->name = $req->ten_name;
                    $this->email = $req->ten_email;
                    $this->subject = "Maintenace Request";
                    $this->message = "Hi ".$req->ten_name.", <br> Thank you for contacting us regarding Unit Maintenance -- <b>".$req->subject."</b>. <br><br> The management department has received your maintenance request and will do its best to respond to it in a timely manner. <br><br> <table style='font-family: arial, sans-serif; border-collapse: collapse; width: 100%;'><tbody><tr><td>Maintenance Request #</td><td>".$post_id."</td></tr><tr><td>Unit</td><td>".$unit_id."</td></tr><tr><td>Tenant Name</td><td>".$req->ten_name."</td></tr><tr><td>Tenant Phone Number</td><td>".$req->phone_number."</td></tr><tr><td>Status</td><td>Open</td></tr><tr><td>Priority</td><td>".$req->priority."</td></tr><tr><td>Is the problem in the unit?</td><td>".$req->problem_in_unit."</td></tr><tr><td>Permission granted to enter unit alone?</td><td>".$permission."</td></tr><tr><td>Subject</td><td>".$req->subject."</td></tr><tr><td>Details</td><td>".$req->details."</td></tr><tr><td>Additional Info.</td><td>".$req->additional_info."</td></tr></tbody></table>";


                    if($fileToStore == "noImage.png"){
                        $filename = "noImage.png";
                    }
                    else{
                        $file = explode(",", $fileToStore);
                        $filename = $file[0];

                    }

                    $this->file = $filename;

                    $this->sendEmail($this->email, "Maintenace Request");


                // $this->sendEmail("bambo@vimfile.com", "Maintenace Request");

                $resData = "Sent Successfully";
                $resp = "success";

            }
            else{
                $resData = "Something went wrong!";
                $resp = "error";
            }

        }


        // return $this->returnJSON($resData, 200);

        return redirect('maintenance/status?s=submitted')->with($resp, $resData);
    }


    public function ajaxgetFacility(Request $req, Building $facility, ClientInfo $client){

        $getclient = $client->where('user_id', $req->user_id)->get();

        if(count($getclient) > 0){
            // Get Facility
            $ownerfacility = $facility->where('owner_email', $getclient[0]->email)->get();

            if(count($ownerfacility) > 0){

                $resData = ['data' => json_encode($ownerfacility), 'message' => 'success'];
            }
            else{
                $resData = ['message' => 'error', 'data' => 'No record'];
            }

        }
        else{
            $resData = ['message' => 'error', 'data' => 'No record'];
        }


        return $this->returnJSON($resData, 200);
    }


    public function ajaxgetbuildingaddress(Request $req, Building $facility){

        $getfacility = $facility->where('id', $req->id)->get();

        if(count($getfacility) > 0){
            // Get Facility
            $resData = ['data' => json_encode($getfacility), 'message' => 'success'];

        }
        else{
            $resData = ['message' => 'error', 'data' => 'No record'];
        }


        return $this->returnJSON($resData, 200);
    }


    public function ajaxnotifyupdate(Request $req, Statement $statement){

        $data = $statement->where('user_id', $req->user_id)->update(['notify' => 1]);

        if(isset($data)){

            // Get Facility
            $resData = ['data' => 1, 'message' => 'success'];

        }
        else{
            $resData = ['message' => 'error', 'data' => 'No record'];
        }


        return $this->returnJSON($resData, 200);
    }


    public function ajaxgetCommission(Request $req){


        $thisuser = User::where('api_token', $req->bearerToken())->first();

        if($req->pay_method != "Wallet"){

            if($req->foreigncurrency != $req->localcurrency){

            // dd($req->localcurrency);

                $dataInfo = $this->convertCurrencyRate($req->foreigncurrency, $req->localcurrency, $req->amount);
            }
            else{
                $dataInfo = $req->amount;
            }


            

            
            // dd($dataInfo);

        $data = TransactionCost::where('structure', $req->structure)->where('method', $req->structureMethod)->where('country', $thisuser->country)->first();

        /*
        
            Calculation

            x = Variable * Amount;
            y = Fixed + x;
        */ 

        if(isset($data) == true){
            $x = ($data->variable / 100) * $req->amount;

            $y = $data->fixed + $x;

            $collection = $y;
        }
        else{

            $data = TransactionCost::where('structure', $req->structure)->where('method', $req->structureMethod)->first();

            $x = ($data->variable / 100) * $req->amount;

            $y = $data->fixed + $x;

            $collection = $y;

        }



        if($req->check == "true"){

            $amountReceive = $req->amount - $collection;

            $state = "commission available";
        }

        else{
            $amountReceive = $req->amount;
            $state = "commission unavailable";

        }

        }
        else{
            $amountReceive = $req->amount;
            $state = "commission free";
            $collection = 0;
        }



        // Check if Wallet is chosen
        $walletCheck = "";

        if($req->pay_method == "Wallet"){
            $wallet = $thisuser->wallet_balance;

            if($wallet < $amountReceive){

                if($thisuser->accountType == "Individual"){
                    $route = route('Add Money');
                }
                else{
                    $route = route('merchant add money');
                }

                $walletCheck = 'Wallet Balance: <strong>'.$req->localcurrency. number_format($wallet,2).'</strong>. <br> Insufficient balance. <a href="'.$route.'">Add money <i class="fa fa-plus" style="font-size: 15px;border-radius: 100%;border: 1px solid grey;padding: 3px;" aria-hidden="true"></i></a>';
            }
        }

        

        $resData = ['data' => $amountReceive, 'message' => 'success', 'state' => $state, 'collection' => $collection, 'walletCheck' => $walletCheck];

        return $this->returnJSON($resData, 200);

    }


    public function ajaxgetwalletBalance(Request $req){

        $walletCheck = "";

        if($req->pay_method == "Wallet"){
            $wallet = Auth::user()->wallet_balance;

            if($wallet < $req->amount){
                $walletCheck = 'Wallet Balance: <strong>'.$req->currency. number_format($wallet,2).'</strong>. <br> Insufficient balance. <a href="'.route('Add Money').'">Add money <i class="fa fa-plus" style="font-size: 15px;border-radius: 100%;border: 1px solid grey;padding: 3px;" aria-hidden="true"></i></a>';
            }
        }

        $resData = ['data' => $req->amount, 'message' => 'success', 'walletCheck' => $walletCheck];

        return $this->returnJSON($resData, 200);

    }

        public function convertCurrencyRate($foreigncurrency, $localcurrency, $amount){

        $currency = 'USD'.$foreigncurrency;
        $amount = $amount;
        $localCurrency = 'USD'.$localcurrency;

        $access_key = '6173fa628b16d8ce1e0db5cfa25092ac';

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://api.currencylayer.com/live?access_key='.$access_key,
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



        if($result->success == true){
        
            // Conversion Rate USD to Local currency
            $convertLocal = $amount / $result->quotes->$localCurrency;



            $convRate = $result->quotes->$currency * $convertLocal;

        }
        else{
            $convRate = "Sorry we can not process your transaction this time, try again later!.";
        }


        return $convRate;

    }



    public function maintenancedelete(Request $req){

        // Delete Maintnencae
        $getReq = MaintenanceRequest::where('post_id', $req->post_id)->get();

        if(count($getReq) > 0){


            // Get Property owner information and mail
                $clientinfo = ClientInfo::where('user_id', $getReq[0]->owner_id)->get();

                if($getReq[0]->problem_in_unit == "Yes"){
                    $desc_event = $getReq[0]->describe_event;
                    $permission = "Yes, ".$getReq[0]->describe_event;
                }
                else{
                    $desc_event = "NILL";
                    $permission = "No";
                }

                $this->name = $clientinfo[0]->business_name;
                $this->email = $clientinfo[0]->email;
                $this->subject = "Maintenace Request Deleted";
                $this->message = "Hi ".$this->name.", <br> A tenant, <b>".$getReq[0]->tenant_name."</b>, deleted a Maintenance Request: -- <b>".$getReq[0]->subject."</b>. <br><br> <table style='font-family: arial, sans-serif; border-collapse: collapse; width: 100%;'><tbody><tr><td>Maintenance Request #</td><td>".$getReq[0]->post_id."</td></tr><tr><td>Unit</td><td>".$getReq[0]->unit_id."</td></tr><tr><td>Tenant</td><td>".$getReq[0]->tenant_name."</td></tr><tr><td>Status</td><td>Open</td></tr><tr><td>Priority</td><td>".$getReq[0]->priority."</td></tr><tr><td>Is the problem in the unit?</td><td>".$getReq[0]->problem_in_unit."</td></tr><tr><td>Permission granted to enter unit alone?</td><td>".$permission."</td></tr><tr><td>Subject</td><td>".$getReq[0]->subject."</td></tr><tr><td>Details</td><td>".$getReq[0]->details."</td></tr><tr><td>Additional Info.</td><td>".$getReq[0]->additional_info."</td></tr></tbody></table> <br><br> Kindly follow these steps to manage the Request: <br> a. Click on this link <a href='https://exbc.ca/login'>https://exbc.ca/login</a> to login to EXBC Account. <br> b. Go to Manage Rental Property on Free Business App and Select Property Manager/Owner <br><br> Thanks <br> PaySprint Management.";



                $this->file = "noImage.png";
                $this->sendEmail($this->email, "Maintenace Request");

                // Delete
                MaintenanceRequest::where('post_id', $req->post_id)->delete();

            // Send Mail to Admin

            $resData = "Deleted Successfully!";
            $resp = "success";
        }
        else{
            $resData = "Record not found";
            $resp = "error";
        }


        return redirect()->back()->with($resp, $resData);
    }

    public function updatemaintenance(Request $req){

        $fileToStore = "";


            if($req->file('add_file') && count($req->file('add_file')) > 0)
            {
                $i = 0;
                foreach($req->file('add_file') as $key => $value){
                    //Get filename with extension
                    $filenameWithExt = $value->getClientOriginalName();
                    // Get just filename
                    $filename = pathinfo($filenameWithExt , PATHINFO_FILENAME);
                    // Get just extension
                    $extension = $value->getClientOriginalExtension();

                    // Filename to store
                    $fileNameToStore = rand().'_'.time().'.'.$extension;

                    $fileToStore .=  $fileNameToStore.",";
                    //Upload Image
                    // $path = $value->storeAs('public/maintenancefile', $fileNameToStore);

                    // $path = $value->move(public_path('/maintenancefile/'), $fileNameToStore);

                    $path = $value->move(public_path('../../maintenancefile/'), $fileNameToStore);
                }

                if($req->problem_in_unit == "Yes"){
                    $desc_event = $req->describe_event;

                }
                else{
                    $desc_event = "NILL";

                }

                if($req->authorize == "on"){
                    $permission = $req->authorize;
                }
                else{
                    $permission = "No";
                }


                $insertRec = MaintenanceRequest::where('post_id', $req->post_id)->update(['post_id' => $req->post_id, 'unit' => $req->unit, 'tenant_name' => $req->ten_name, 'tenant_email' => $req->ten_email, 'owner_id' => $req->property_owner, 'phone_number' => $req->phone_number, 'problem_in_unit' => $req->problem_in_unit, 'describe_event' => $desc_event, 'subject' => $req->subject, 'details' => $req->details, 'additional_info' => $req->additional_info, 'priority' => $req->priority, 'add_file' => $fileToStore]);
            }

        else
        {
            if($req->problem_in_unit == "Yes"){
                $desc_event = $req->describe_event;
            }
            else{
                $desc_event = "NILL";
            }

            if($req->authorize == "on"){
                $permission = $req->authorize;
            }
            else{
                $permission = "No";
            }


            $insertRec = MaintenanceRequest::where('post_id', $req->post_id)->update(['post_id' => $req->post_id, 'unit' => $req->unit, 'tenant_name' => $req->ten_name, 'tenant_email' => $req->ten_email, 'owner_id' => $req->property_owner, 'phone_number' => $req->phone_number, 'problem_in_unit' => $req->problem_in_unit, 'describe_event' => $desc_event, 'subject' => $req->subject, 'details' => $req->details, 'additional_info' => $req->additional_info, 'priority' => $req->priority]);

        }




        $clientinfo = ClientInfo::where('user_id', $req->property_owner)->get();

            if($req->ten_email != $clientinfo[0]->email){

                $this->name = $clientinfo[0]->business_name;
                $this->email = $clientinfo[0]->email;
                $this->subject = "Maintenace Request";

                $this->message = "Hi ".$this->name.", <br> A tenant, <b>".$req->ten_name."</b>, submitted Maintenance Request: -- <b>".$req->subject."</b>. <br><br> <table style='font-family: arial, sans-serif; border-collapse: collapse; width: 100%;'><tbody><tr><td>Maintenance Request #</td><td>".$req->post_id."</td></tr><tr><td>Unit</td><td>".$req->unit."</td></tr><tr><td>Tenant Name</td><td>".$req->ten_name."</td></tr><tr><td>Tenant Phone Number</td><td>".$req->phone_number."</td></tr><tr><td>Status</td><td>Open</td></tr><tr><td>Priority</td><td>".$req->priority."</td></tr><tr><td>Is the problem in the unit?</td><td>".$req->problem_in_unit."</td></tr><tr><td>Permission granted to enter unit alone?</td><td>".$permission."</td></tr><tr><td>Subject</td><td>".$req->subject."</td></tr><tr><td>Details</td><td>".$req->details."</td></tr><tr><td>Additional Info.</td><td>".$req->additional_info."</td></tr></tbody></table> <br><br> Kindly follow these steps to manage the Request: <br> a. Click on this link <a href='https://exbc.ca/login'>https://exbc.ca/login</a> to login to EXBC Account. <br> b. Go to Manage Rental Property on Free Business App and Select Property Manager/Owner <br><br> Thanks <br> PaySprint Management.";


                $this->file = "noImage.png";
                $this->sendEmail($this->email, "Maintenace Request");

            }

            $this->name = $req->ten_name;
            $this->email = $req->ten_email;
            $this->subject = "Maintenace Request";
            $this->message = "Hi ".$req->ten_name.", <br> Thank you for contacting us regarding Unit Maintenance -- <b>".$req->subject."</b>. <br><br> The management department has received your maintenance request and will do its best to respond to it in a timely manner. <br><br> <table style='font-family: arial, sans-serif; border-collapse: collapse; width: 100%;'><tbody><tr><td>Maintenance Request #</td><td>".$req->post_id."</td></tr><tr><td>Unit</td><td>".$req->unit."</td></tr><tr><td>Tenant Name</td><td>".$req->ten_name."</td></tr><tr><td>Tenant Phone Number</td><td>".$req->phone_number."</td></tr><tr><td>Status</td><td>Open</td></tr><tr><td>Priority</td><td>".$req->priority."</td></tr><tr><td>Is the problem in the unit?</td><td>".$req->problem_in_unit."</td></tr><tr><td>Permission granted to enter unit alone?</td><td>".$permission."</td></tr><tr><td>Subject</td><td>".$req->subject."</td></tr><tr><td>Details</td><td>".$req->details."</td></tr><tr><td>Additional Info.</td><td>".$req->additional_info."</td></tr></tbody></table>";

            $this->file = "noImage.png";
            $this->sendEmail($req->ten_email, "Maintenace Request");

            $resData = "Updated Successfully!";
            $resp = "success";

            return redirect()->route('maintenanceview', [$req->post_id])->with($resp, $resData);
    }


    // Get all service types
    public function myServices(){
        $service = ServiceType::all();

        return $service;
    }

    public function clientsInformation(){
        // Get Organization & Businessn JOIN with Building/Facility
        $clientInfo = ClientInfo::orderBy('created_at', 'DESC')->get();

        return $clientInfo;
    }


    public function sharedDocs($email){
        

        $getdocuments = MaintenanceRequest::where('tenant_email', $email)->where('add_file', '!=', null)->orderBy('created_at', 'DESC')->get();


        return $getdocuments;
    }


    public function loginApi(Request $req){

        // Check user if exist
        $getUser = User::where('email', $req->email)->first();

        if($req->action == "login"){
            if(isset($getUser) == true){
                // Set session
                $req->session()->put(['email' => $getUser->email, 'name' => $getUser->name, 'ref_code' => $getUser->ref_code]);

                $resData = ['res' => 'Welcome '.$getUser->name, 'message' => 'success', 'link' => '/'];
            }
        }
        elseif($req->action == "rpm_tenant"){
            if(isset($getUser) == true){
                // Set session
                $req->session()->put(['email' => $getUser->email, 'name' => $getUser->name, 'ref_code' => $getUser->ref_code]);

                $resData = ['res' => 'Welcome '.$getUser->name, 'message' => 'success', 'link' => 'rentalmanagement'];
            }
        }
        elseif($req->action == "rpm_property_owner"){
            if(isset($getUser) == true){
                // Set session
                $req->session()->put(['email' => $getUser->email, 'name' => $getUser->name, 'ref_code' => $getUser->ref_code]);

                $resData = ['res' => 'Welcome '.$getUser->name, 'message' => 'success', 'link' => 'rentalmanagement/admin'];
            }
        }
        elseif($req->action == "rpm_service_provider"){
            if(isset($getUser) == true){
                // Set session
                $req->session()->put(['email' => $getUser->email, 'name' => $getUser->name, 'ref_code' => $getUser->ref_code]);

                $resData = ['res' => 'Welcome '.$getUser->name, 'message' => 'success', 'link' => 'rentalmanagement/consultant'];
            }
        }

        User::where('email', $req->email)->update(['api_token' => uniqid().time()]);
        // Do Auth here
        Auth::login($getUser);

        





        return $this->returnJSON($resData, 200);
    }


    public function maintenanceCheck($email, $status){
        $getState = MaintenanceRequest::where('tenant_email', $email)->where('status', $status)->orderBy('created_at', 'DESC')->get();

        return $getState;

    }


    public function requestmaintenanceCheck($ref_code, $status){
        $getState = MaintenanceRequest::where('owner_id', $ref_code)->where('status', $status)->orderBy('created_at', 'DESC')->get();
        return $getState;

    }


    public function requestinvoiceCheck($email){
        $getState = ImportExcel::where('payee_email', $email)->where('payment_status', 0)->orderBy('created_at', 'DESC')->get();
        return $getState;

    }

    public function requestquoteCheck($email){
        $getState = RentalQuote::where('property_owner', $email)->orderBy('created_at', 'DESC')->get();
        return $getState;

    }

    public function providersCheck($email){
        $getState = Consultant::where('owner_email', $email)->orderBy('created_at', 'DESC')->get();
        return $getState;

    }

    public function consultantCheck($id){
        $getState = Consultant::where('id', $id)->orderBy('created_at', 'DESC')->get();
        return $getState;

    }


    public function workorderCheck($ref_code, $status){
        $getState = Workorder::where('consultant_email', $ref_code)->where('status', $status)->orderBy('created_at', 'DESC')->get();
        return $getState;

    }

    public function adminworkorderCheck($email){
        // Join with Maintnenance Request

        $getState = DB::table('maintenance_request')
            ->join('rental_message', 'maintenance_request.post_id', '=', 'rental_message.post_id')
            ->where('rental_message.owner_email', $email)
            ->get();


        return $getState;

    }


    public function maintenanceDetail($id){
        $getState = MaintenanceRequest::where('post_id', $id)->get();

        return $getState;

    }

    public function consultmaintenanceDetail($id){
        $getState = MaintenanceRequest::where('assigned_staff', $id)->get();

        return $getState;

    }

    public function quoteDetail($id){
        $getState = RentalQuote::where('maintenance_id', $id)->get();

        return $getState;

    }


    public function facilities(){
        $getState = Building::orderBy('created_at', 'DESC')->get();

        return $getState;

    }

    public function facilityInfo($id){
        $getState = Building::where('id', $id)->get();

        return $getState;

    }


    public function paymentHistoryrecord($email){
        $getState = InvoicePayment::where('email', $email)->orderBy('created_at', 'DESC')->get();

        return $getState;

    }


    public function sendEmail($objDemoa, $purpose){
      $objDemo = new \stdClass();
      $objDemo->purpose = $purpose;
        if($purpose == "Contact us"){

            $objDemo->name = $this->name;
            $objDemo->email = $this->email;
            $objDemo->subject = $this->subject;
            $objDemo->website = $this->website;
            $objDemo->message = $this->message;
        }
        elseif($purpose == "Bronchure Download"){

            $objDemo->name = $this->name;
            $objDemo->email = $this->email;
            $objDemo->subject = $this->subject;
            $objDemo->message = $this->message;
        }

        elseif($purpose == "Maintenace Request"){

            $objDemo->name = $this->name;
            $objDemo->email = $this->email;
            $objDemo->subject = $this->subject;
            $objDemo->file = $this->file;
            $objDemo->message = $this->message;
        }

      Mail::to($objDemoa)
            ->send(new sendEmail($objDemo));
   }



    
}

