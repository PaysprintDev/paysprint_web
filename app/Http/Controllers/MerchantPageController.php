<?php

namespace App\Http\Controllers;

use App\Tax;
use Session;
use App\Points;

use App\Statement;

//Session
use App\ClientInfo;

use App\ServiceType;
use App\StoreOrders;
use App\StorePickup;
use App\UpgradePlan;
use App\AllCountries;
use App\User as User;

use App\ClaimedPoints;

use App\HistoryReport;
use App\Notifications;
use App\StoreCategory;
use App\StoreDiscount;
use App\StoreMainShop;
use App\StoreProducts;
use App\StoreWishList;
use App\ActivationEstore;

use App\Traits\MyEstore;
use App\TransactionCost;
use App\Traits\SpecialInfo;
use Illuminate\Http\Request;
use App\Traits\PointsHistory;
use App\Traits\PaysprintPoint;
use App\Traits\ServiceStoreShop;
use App\ImportExcel as ImportExcel;
use Illuminate\Support\Facades\Auth;
use App\InvoicePayment as InvoicePayment;
use App\ImportExcelLink as ImportExcelLink;
use App\StoreShipping;

class MerchantPageController extends Controller
{

    use PaysprintPoint, PointsHistory, SpecialInfo, MyEstore, ServiceStoreShop;

    public function __construct()
    {
        $this->middleware('auth')->except(['businessProfile', 'merchantShop', 'merchantService']);
    }

    public function index()
    {


        $data = [
            'receivedInvoice' => $this->receivedInvoice(Auth::user()->email),
            'allPaidInvoice' => $this->allPaidInvoice(),
            'totalPaidInvoice' => $this->totalPaidInvoice(),
            'invoiceLink' => $this->invoiceLink(),
            'invoiceList' => $this->invoiceList(),
            'statementCount' => $this->statementCount(),
            'paidInvoiceCount' => $this->paidInvoiceCount(),
            'mypoints' => $this->getAcquiredPoints(Auth::user()->id),
            'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
            'clientInfo' => $this->getMyClientInfo(Auth::user()->ref_code),
            'planCost' => $this->getPlanCost(),
            'specialInfo' => $this->getthisInfo(Auth::user()->country),
            'myplan' => UpgradePlan::where('userId', Auth::user()->ref_code)->first()
        ];





        return view('merchant.pages.dashboard')->with(['pages' => 'dashboard', 'data' => $data]);
    }

    public function invoiceSingle()
    {
        $client = $this->getMyClientInfo(Auth::user()->ref_code);

        if($client->accountMode == "test"){

            return redirect()->route('dashboard')->with('error', 'You are in test mode');
        }

        $data = [
            'mypoints' => $this->getAcquiredPoints(Auth::user()->id),
            'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
            'myplan' => UpgradePlan::where('userId', Auth::user()->ref_code)->first()
        ];


        return view('merchant.pages.invoice')->with(['pages' => 'invoice single', 'data' => $data]);
    }


    public function invoiceForm()
    {

        $client = $this->getMyClientInfo(Auth::user()->ref_code);

        if($client->accountMode == "test"){

            return redirect()->route('dashboard')->with('error', 'You are in test mode');
        }

        $data = [
            'mypoints' => $this->getAcquiredPoints(Auth::user()->id),
            'getServiceType' => $this->getServiceTypes(),
            'getTax' => $this->getTax(Auth::user()->id),
            'getpersonalData' => $this->getmyPersonalDetail(Auth::user()->ref_code),
            'getimt' => $this->getActiveCountries(),
            'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
            'myplan' => UpgradePlan::where('userId', Auth::user()->ref_code)->first()
        ];



        return view('merchant.pages.singleinvoice')->with(['pages' => 'invoice form', 'data' => $data]);
    }

    public function invoiceTypes()
    {


        $data = [
            'mypoints' => $this->getAcquiredPoints(Auth::user()->id),
            'getServiceType' => $this->getServiceTypes(),
            'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
            'myplan' => UpgradePlan::where('userId', Auth::user()->ref_code)->first()
        ];

        return view('merchant.pages.createinvoicetypes')->with(['pages' => 'invoice types', 'data' => $data]);
    }

    public function setUpTax()
    {

        $data = [
            'mypoints' => $this->getAcquiredPoints(Auth::user()->id),
            'getTax' => $this->getTax(Auth::user()->id),
            'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
            'myplan' => UpgradePlan::where('userId', Auth::user()->ref_code)->first()
        ];

        return view('merchant.pages.setuptax')->with(['pages' => 'set up tax', 'data' => $data]);
    }

    public function invoiceStatement()
    {

        $client = $this->getMyClientInfo(Auth::user()->ref_code);

        if($client->accountMode == "test"){

            return redirect()->route('dashboard')->with('error', 'You are in test mode');
        }

        $data = [
            'mypoints' => $this->getAcquiredPoints(Auth::user()->id),
            'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
            'myplan' => UpgradePlan::where('userId', Auth::user()->ref_code)->first()
        ];

        return view('merchant.pages.invoicestatement')->with(['pages' => 'invoice statement', 'data' => $data]);
    }

    public function walletStatement()
    {

        $client = $this->getMyClientInfo(Auth::user()->ref_code);

        if($client->accountMode == "test"){

            return redirect()->route('dashboard')->with('error', 'You are in test mode');
        }

        $data = [
            'mypoints' => $this->getAcquiredPoints(Auth::user()->id),
            'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
            'myplan' => UpgradePlan::where('userId', Auth::user()->ref_code)->first()
        ];

        return view('merchant.pages.walletstatement')->with(['pages' => 'wallet statement', 'data' => $data]);
    }

    public function sentInvoice()
    {

        $client = $this->getMyClientInfo(Auth::user()->ref_code);

        if($client->accountMode == "test"){

            return redirect()->route('dashboard')->with('error', 'You are in test mode');
        }

        $data = [
            'mypoints' => $this->getAcquiredPoints(Auth::user()->id),
            'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
            'myplan' => UpgradePlan::where('userId', Auth::user()->ref_code)->first()
        ];

        return view('merchant.pages.sentinvoice')->with(['pages' => 'sent invoice', 'data' => $data]);
    }


    public function requestPaymentLink(Request $req){
        try {

            $today = date('Y-m-d H:i:s');

            User::where('id', $req->id)->update([
                'payment_link_access' => 1,
                'payment_link_expiry' => date('Y-m-d H:i:s', strtotime($today.'+ 1 day'))
            ]);

            $message = 'Link generated successfully';
            $status = 'success';

        } catch (\Throwable $th) {
            $message = $th->getMessage();
            $status = 'error';
        }

        return redirect()->route('dashboard')->with($status, $message);
    }


    // Setup Shop Here...
    public function merchantShop($merchant){


        // Get merchant...
        $thismerchant = ClientInfo::where('business_name', $merchant)->first();

        if(isset($thismerchant)){
                $getMerchantId = User::where('ref_code', $thismerchant->user_id)->first();


                if(Auth::check() == true){
                    $userId = Auth::id();
                }
                else{
                    $userId = 0;
                }

                if($userId == $getMerchantId->id){
                    // If Has Main Store setup
                $merchantStore = $this->checkMyStore($getMerchantId->id);
                }
                else{
                    // If Has Main Store setup
                    if(session('role')){
                        $merchantStore = $this->checkMyStore($getMerchantId->id);
                    }
                    else{
            $merchantStore = $this->getMyStore($getMerchantId->id);

                    }
                }




            if(isset($merchantStore)){



                $data = [
                    'mystore' => $merchantStore,
                    'myproduct' => $this->getProducts($getMerchantId->id),
                    'user' => $getMerchantId,
                    'mywishlist' => $this->getMyWishlist($userId),
                    'mycartlist' => $this->getMyCartlist($userId),
                ];


                // dd($data);

                return view('merchant.pages.shop.index')->with(['pages' => $merchant.' Shop', 'data' => $data]);
            }
            else{
                return view('errors.comingsoon')->with(['pages' => $merchant.' Shop']);
            }

        }
        else{
            return view('errors.comingsoon')->with(['pages' => $merchant.' Shop']);
        }




    }


    public function merchantService($merchant){

        // Get merchant...
        $thismerchant = ClientInfo::where('business_name', $merchant)->first();

        if(isset($thismerchant)){
                $getMerchantId = User::where('ref_code', $thismerchant->user_id)->first();


                if(Auth::check() == true){
                    $userId = Auth::id();
                }
                else{
                    $userId = 0;
                }

                if($userId == $getMerchantId->id){
                    // If Has Main Store setup
                $merchantStore = $this->getServiceStore($getMerchantId->id);
                }
                else{
                    // If Has Main Store setup
                    if(session('role')){
                        $merchantStore = $this->getServiceStore($getMerchantId->id);
                    }
                    else{
            $merchantStore = $this->getMyServiceStore($getMerchantId->id);

                    }
                }




            if(isset($merchantStore)){

                $data = [
                    'myproduct' => $this->getProducts($getMerchantId->id),
                    'user' => $getMerchantId,
                    'mywishlist' => $this->getMyWishlist($userId),
                    'mycartlist' => $this->getMyCartlist($userId),
                    'myServiceStore' => $merchantStore,
                    'myServiceTestimony' => $this->getServiceTestimony($userId),
                ];



                return view('merchant.pages.service.index')->with(['pages' => $merchant.' Shop', 'data' => $data]);
            }
            else{
                return view('errors.comingsoon')->with(['pages' => $merchant.' Shop']);
            }

        }
        else{
            return view('errors.comingsoon')->with(['pages' => $merchant.' Shop']);
        }




    }

    //merchant shop page
    public function merchantShopPage(Request $req){

        // Get merchant...
        $thismerchant = ClientInfo::where('business_name', $req->merchant)->first();

        if(isset($thismerchant)){
                $getMerchantId = User::where('ref_code', $thismerchant->user_id)->first();


                if(Auth::check() == true){
                    $userId = Auth::id();
                }
                else{
                    $userId = 0;
                }

                if($userId == $getMerchantId->id){
                    // If Has Main Store setup
                $merchantStore = $this->checkMyStore($getMerchantId->id);
                }
                else{
                    // If Has Main Store setup
                    if(session('role')){
                        $merchantStore = $this->checkMyStore($getMerchantId->id);
                    }
                    else{
            $merchantStore = $this->getMyStore($getMerchantId->id);

                    }
                }




            if(isset($merchantStore)){



                $data = [
                    'mystore' => $merchantStore,
                    'myproduct' => $this->getProducts($getMerchantId->id),
                    'user' => $getMerchantId,
                    'mywishlist' => $this->getMyWishlist($userId),
                    'mycartlist' => $this->getMyCartlist($userId),
                ];




                return view('merchant.pages.shop.shopindex')->with(['pages' => $req->merchant.' Shop', 'data' => $data]);
            }
            else{
                return view('errors.comingsoon')->with(['pages' => $req->merchant.' Shop']);
            }

        }
        else{
            return view('errors.comingsoon')->with(['pages' => $req->merchant.' Shop']);
        }




    }

    //merchant orders
     public function merchantOrders(Request $req){

        // Get merchant...
        $thismerchant = ClientInfo::where('business_name', $req->merchant)->first();

        if(isset($thismerchant)){
                $getMerchantId = User::where('ref_code', $thismerchant->user_id)->first();


                if(Auth::check() == true){
                    $userId = Auth::id();
                }
                else{
                    $userId = 0;
                }

                if($userId == $getMerchantId->id){
                    // If Has Main Store setup
                $merchantStore = $this->checkMyStore($getMerchantId->id);
                }
                else{
                    // If Has Main Store setup
                    if(session('role')){
                        $merchantStore = $this->checkMyStore($getMerchantId->id);
                    }
                    else{
            $merchantStore = $this->getMyStore($getMerchantId->id);

                    }
                }




            if(isset($merchantStore)){



                $data = [
                    'mystore' => $merchantStore,
                    'myproduct' => $this->getProducts($getMerchantId->id),
                    'user' => $getMerchantId,
                    'mywishlist' => $this->getMyWishlist($userId),
                    'mycartlist' => $this->getMyCartlist($userId),
                    'orders' => $this->getAllMyOrders($getMerchantId->id, $userId)
                ];



                return view('merchant.pages.shop.orders')->with(['pages' => $req->merchant.' Shop', 'data' => $data]);
            }
            else{
                return view('errors.comingsoon')->with(['pages' => $req->merchant.' Shop']);
            }

        }
        else{
            return view('errors.comingsoon')->with(['pages' => $req->merchant.' Shop']);
        }




    }

        //single merchant orders
        public function singleOrder(Request $req){

            // Get merchant...
            $thismerchant = ClientInfo::where('business_name', $req->merchant)->first();

            if(isset($thismerchant)){
                    $getMerchantId = User::where('ref_code', $thismerchant->user_id)->first();


                    if(Auth::check() == true){
                        $userId = Auth::id();
                    }
                    else{
                        $userId = 0;
                    }



                    if($userId == $getMerchantId->id){
                        // If Has Main Store setup
                    $merchantStore = $this->checkMyStore($getMerchantId->id);
                    }
                    else{
                        // If Has Main Store setup
                        if(session('role')){
                            $merchantStore = $this->checkMyStore($getMerchantId->id);
                        }
                        else{
                $merchantStore = $this->getMyStore($getMerchantId->id);

                        }
                    }




                if(isset($merchantStore)){



                    $data = [
                        'mystore' => $merchantStore,
                        'myproduct' => $this->getProducts($getMerchantId->id),
                        'user' => $getMerchantId,
                        'mywishlist' => $this->getMyWishlist($userId),
                        'mycartlist' => $this->getMyCartlist($userId),
                        'orders' => $this->getSpecificOrder($req->orderid)
                    ];




                    return view('merchant.pages.shop.singleorder')->with(['pages' => $req->merchant.' Shop', 'data' => $data]);
                }
                else{
                    return view('errors.comingsoon')->with(['pages' => $req->merchant.' Shop']);
                }

            }
            else{
                return view('errors.comingsoon')->with(['pages' => $req->merchant.' Shop']);
            }




        }

        //wishlist
        public function wishlist(Request $req){

            // Get merchant...
            $thismerchant = ClientInfo::where('business_name', $req->merchant)->first();

            if(isset($thismerchant)){
                    $getMerchantId = User::where('ref_code', $thismerchant->user_id)->first();


                    if(Auth::check() == true){
                        $userId = Auth::id();
                    }
                    else{
                        $userId = 0;
                    }



                    if($userId == $getMerchantId->id){
                        // If Has Main Store setup
                    $merchantStore = $this->checkMyStore($getMerchantId->id);
                    }
                    else{
                        // If Has Main Store setup
                        if(session('role')){
                            $merchantStore = $this->checkMyStore($getMerchantId->id);
                        }
                        else{
                $merchantStore = $this->getMyStore($getMerchantId->id);

                        }
                    }




                if(isset($merchantStore)){



                    $data = [
                        'mystore' => $merchantStore,
                        'myproduct' => $this->getProducts($getMerchantId->id),
                        'user' => $getMerchantId,
                        'mywishlist' => $this->getMyWishlist($userId),
                        'mycartlist' => $this->getMyCartlist($userId),
                    ];



                    return view('merchant.pages.shop.wishlist')->with(['pages' => $req->merchant.' Shop', 'data' => $data]);
                }
                else{
                    return view('errors.comingsoon')->with(['pages' => $req->merchant.' Shop']);
                }

            }
            else{
                return view('errors.comingsoon')->with(['pages' => $req->merchant.' Shop']);
            }




        }

        //deletewishlist item

        public function deleteWishlist(Request $req, $id){
            StoreWishList::where('id',$id)->delete();
            return back();
        }

        // Shopping Cart
    public function myCart(Request $req){

        // Get merchant...
        $thismerchant = ClientInfo::where('business_name', $req->store)->first();

        if(isset($thismerchant)){

            $getMerchantId = User::where('ref_code', $thismerchant->user_id)->first();



             if(Auth::check() == true){
                    $userId = Auth::id();
                }
                else{
                    $userId = 0;
                }


            if($userId == $getMerchantId->id){
                    // If Has Main Store setup
                $merchantStore = $this->checkMyStore($getMerchantId->id);
                }
                else{
                    // If Has Main Store setup
                    if(session('role')){
                        $merchantStore = $this->checkMyStore($getMerchantId->id);
                    }
                    else{
            $merchantStore = $this->getMyStore($getMerchantId->id);

                    }
                }


                    $data = [
                        'mystore' => $merchantStore,
                    'myproduct' => $this->getProducts($getMerchantId->id),
                    'user' => $getMerchantId,
                    'mywishlist' => $this->getMyWishlist(Auth::id()),
                    'mycartlist' => $this->getMyCartlist(Auth::id()),
                ];


        return view('merchant.pages.shop.mycart')->with(['pages' => $req->store.' Shop', 'data' => $data]);
        }
        else{
            return view('errors.comingsoon')->with(['pages' => $req->store.' Shop']);
        }


    }


    // Checkout Item ...
    public function myCheckout(Request $req){

        // Get merchant...
        $thismerchant = ClientInfo::where('business_name', $req->store)->first();

        if(isset($thismerchant)){

            $getMerchantId = User::where('ref_code', $thismerchant->user_id)->first();



            if(Auth::check() == true){
                    $userId = Auth::id();
                }
                else{
                    $userId = 0;
                }


            if($userId == $getMerchantId->id){
                    // If Has Main Store setup
                $merchantStore = $this->checkMyStore($getMerchantId->id);
                }
                else{
                    // If Has Main Store setup
                    if(session('role')){
                        $merchantStore = $this->checkMyStore($getMerchantId->id);
                    }
                    else{
            $merchantStore = $this->getMyStore($getMerchantId->id);

                    }
                }




                    $data = [
                        'mystore' => $merchantStore,
                    'myproduct' => $this->getProducts($getMerchantId->id),
                    'storeTax' => $this->getStoreTax($getMerchantId->id),
                    'user' => $getMerchantId,
                    'mywishlist' => $this->getMyWishlist(Auth::id()),
                    'mycartlist' => $this->getMyCartlist(Auth::id()),
                ];




        return view('merchant.pages.shop.mycheckout')->with(['pages' => $req->store.' Shop', 'data' => $data]);
        }
        else{
            return view('errors.comingsoon')->with(['pages' => $req->store.' Shop']);
        }


    }


    public function paidInvoice()
    {

        $client = $this->getMyClientInfo(Auth::user()->ref_code);

        if($client->accountMode == "test"){

            return redirect()->route('dashboard')->with('error', 'You are in test mode');
        }

        $data = [
            'mypoints' => $this->getAcquiredPoints(Auth::user()->id),
            'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
            'myplan' => UpgradePlan::where('userId', Auth::user()->ref_code)->first()
        ];

        return view('merchant.pages.paidinvoice')->with(['pages' => 'paid invoice', 'data' => $data]);
    }

    public function pendingInvoice()
    {

        $client = $this->getMyClientInfo(Auth::user()->ref_code);

        if($client->accountMode == "test"){

            return redirect()->route('dashboard')->with('error', 'You are in test mode');
        }

        $data = [
            'mypoints' => $this->getAcquiredPoints(Auth::user()->id),
            'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
            'myplan' => UpgradePlan::where('userId', Auth::user()->ref_code)->first()
        ];

        return view('merchant.pages.pendinginvoice')->with(['pages' => 'pending invoice', 'data' => $data]);
    }

    public function balanceReport()
    {

        $client = $this->getMyClientInfo(Auth::user()->ref_code);

        if($client->accountMode == "test"){

            return redirect()->route('dashboard')->with('error', 'You are in test mode');
        }

        $data = [
            'mypoints' => $this->getAcquiredPoints(Auth::user()->id),
            'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
            'myplan' => UpgradePlan::where('userId', Auth::user()->ref_code)->first()
        ];

        return view('merchant.pages.customerbalancereport')->with(['pages' => 'balance report', 'data' => $data]);
    }

    public function taxesReport()
    {

        $client = $this->getMyClientInfo(Auth::user()->ref_code);

        if($client->accountMode == "test"){

            return redirect()->route('dashboard')->with('error', 'You are in test mode');
        }

        $data = [
            'mypoints' => $this->getAcquiredPoints(Auth::user()->id),
            'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
            'myplan' => UpgradePlan::where('userId', Auth::user()->ref_code)->first()
        ];

        return view('merchant.pages.taxesreport')->with(['pages' => 'taxes report', 'data' => $data]);
    }

    public function invoiceTypeReport()
    {

        $client = $this->getMyClientInfo(Auth::user()->ref_code);

        if($client->accountMode == "test"){

            return redirect()->route('dashboard')->with('error', 'You are in test mode');
        }

        $data = [
            'mypoints' => $this->getAcquiredPoints(Auth::user()->id),
            'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
            'myplan' => UpgradePlan::where('userId', Auth::user()->ref_code)->first()
        ];

        return view('merchant.pages.invoicetypereport')->with(['pages' => 'invoice type report', 'data' => $data]);
    }

    public function recurringType()
    {

        $client = $this->getMyClientInfo(Auth::user()->ref_code);

        if($client->accountMode == "test"){

            return redirect()->route('dashboard')->with('error', 'You are in test mode');
        }

        $data = [
            'mypoints' => $this->getAcquiredPoints(Auth::user()->id),
            'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
            'myplan' => UpgradePlan::where('userId', Auth::user()->ref_code)->first()
        ];

        return view('merchant.pages.recurringtype')->with(['pages' => 'recurring type', 'data' => $data]);
    }

    public function profile()
    {

        $data = [
            'mypoints' => $this->getAcquiredPoints(Auth::user()->id),
            'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
            'myplan' => UpgradePlan::where('userId', Auth::user()->ref_code)->first()
        ];

        return view('merchant.pages.profile')->with(['pages' => 'profile', 'data' => $data]);
    }
    public function invoicePage()
    {

        $client = $this->getMyClientInfo(Auth::user()->ref_code);

        if($client->accountMode == "test"){

            return redirect()->route('dashboard')->with('error', 'You are in test mode');
        }

        $data = [
            'mypoints' => $this->getAcquiredPoints(Auth::user()->id),
            'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
            'myplan' => UpgradePlan::where('userId', Auth::user()->ref_code)->first()
        ];

        return view('merchant.pages.invoicepage')->with(['pages' => 'invoice page', 'data' => $data]);
    }

    public function paymentGateway()
    {

        $data = [
            'mypoints' => $this->getAcquiredPoints(Auth::user()->id),
            'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
            'myplan' => UpgradePlan::where('userId', Auth::user()->ref_code)->first()
        ];

        return view('merchant.pages.paymentmethod')->with(['pages' => 'payment gateway', 'data' => $data]);
    }

    public function orderingSystem()
    {
        // $client = $this->getMyClientInfo(Auth::user()->ref_code);


        $data = [
            'mypoints' => $this->getAcquiredPoints(Auth::user()->id),
            'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
            'myplan' => UpgradePlan::where('userId', Auth::user()->ref_code)->first(),
            'myProducts' => $this->getMyProducts(Auth::user()->id),
            'myOrders' => $this->getMyOrders(Auth::user()->id),
            'myDiscounts' => $this->getMyDiscounts(Auth::user()->id),
            'myStore' => $this->checkMyStore(Auth::user()->id),
            'myProductTax' => $this->checkMyProductTax(Auth::user()->id),
            'productcategory' => $this->getProductCategory(),
            'storepickup' => $this->getStorePickupCount(Auth::user()->id),
            'deliverypickup' => $this->getDeliveryPickupCount(Auth::user()->id),
            'activeCountry' => $this->getActiveCountries(),
            'myserviceStore' => $this->getServiceStore(Auth::user()->id)
        ];

        ActivationEstore::updateOrCreate([
            'user_id' => Auth::user()->id,
        ]);

        return view('merchant.pages.orderingsystem')->with(['pages' => 'estore', 'data' => $data]);
    }

    public function estoreService()
    {


        $data = [
            'mypoints' => $this->getAcquiredPoints(Auth::user()->id),
            'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
            'myplan' => UpgradePlan::where('userId', Auth::user()->ref_code)->first(),
            'myProducts' => $this->getMyProducts(Auth::user()->id),
            'myOrders' => $this->getMyOrders(Auth::user()->id),
            'myDiscounts' => $this->getMyDiscounts(Auth::user()->id),
            'myStore' => $this->checkMyStore(Auth::user()->id),
            'myProductTax' => $this->checkMyProductTax(Auth::user()->id),
            'productcategory' => $this->getProductCategory(),
            'storepickup' => $this->getStorePickupCount(Auth::user()->id),
            'deliverypickup' => $this->getDeliveryPickupCount(Auth::user()->id),
            'activeCountry' => $this->getActiveCountries(),
            'myserviceStore' => $this->getServiceStore(Auth::user()->id)
        ];

        return view('merchant.pages.servicesetup')->with(['pages' => 'Service setup', 'data' => $data]);
    }


    public function storepickupAddress(){

        $client = $this->getMyClientInfo(Auth::user()->ref_code);


        if(isset($client) && $client->accountMode == "test"){

            return redirect()->route('dashboard')->with('error', 'You are in test mode');
        }

        $data = [
            'mypoints' => $this->getAcquiredPoints(Auth::user()->id),
            'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
            'myplan' => UpgradePlan::where('userId', Auth::user()->ref_code)->first(),
            'myProducts' => $this->getMyProducts(Auth::user()->id),
            'myOrders' => $this->getMyOrders(Auth::user()->id),
            'myDiscounts' => $this->getMyDiscounts(Auth::user()->id),
            'myStore' => $this->checkMyStore(Auth::user()->id),
            'myProductTax' => $this->checkMyProductTax(Auth::user()->id),
            'productcategory' => $this->getProductCategory(),
            'storepickup' => $this->getStorePickup(Auth::user()->id),
            'deliverypickup' => $this->getDeliveryPickupCount(Auth::user()->id),
            'activeCountry' => $this->getActiveCountries(),
        ];


        return view('merchant.pages.storepickupaddress')->with(['pages' => 'store pickup address', 'data' => $data]);
    }

    public function deliverypickupAddress(){

        $client = $this->getMyClientInfo(Auth::user()->ref_code);


        if(isset($client) && $client->accountMode == "test"){

            return redirect()->route('dashboard')->with('error', 'You are in test mode');
        }

        $data = [
            'mypoints' => $this->getAcquiredPoints(Auth::user()->id),
            'getfiveNotifications' => $this->getfiveUserNotifications(Auth::user()->ref_code),
            'myplan' => UpgradePlan::where('userId', Auth::user()->ref_code)->first(),
            'myProducts' => $this->getMyProducts(Auth::user()->id),
            'myOrders' => $this->getMyOrders(Auth::user()->id),
            'myDiscounts' => $this->getMyDiscounts(Auth::user()->id),
            'myStore' => $this->checkMyStore(Auth::user()->id),
            'myProductTax' => $this->checkMyProductTax(Auth::user()->id),
            'productcategory' => $this->getProductCategory(),
            'storepickup' => $this->getStorePickupCount(Auth::user()->id),
            'deliverypickup' => $this->getDeliveryPickup(Auth::user()->id),
            'activeCountry' => $this->getActiveCountries(),
        ];


        return view('merchant.pages.deliverypickupaddress')->with(['pages' => 'delivery pickup address', 'data' => $data]);
    }


    // Business Profile
    public function businessProfile(Request $req, $id)
    {
        $data = [
            'businessprofile' => $this->getBusinessProfileData($id),
            'merchantbusiness' => $this->getThisMerchantBusiness($id),
            'getfiveNotifications' => $this->getfiveUserNotifications($id)
        ];


        return view('businessprofile.index')->with(['pages' => 'Business Profile', 'data' => $data]);
    }


    // Statement count
    public function statementCount()
    {
        $data = Statement::where('user_id', Auth::user()->email)->count();

        return $data;
    }

    // Invoice link
    public function invoiceLink()
    {
        $data = ImportExcelLink::where('uploaded_by', Auth::user()->ref_code)->orderBy('created_at', 'DESC')->get();

        return $data;
    }

    // Get 5 latest Notifications
    public function getfiveUserNotifications($ref_code)
    {
        $data = Notifications::where('ref_code', $ref_code)->latest()->take(5)->get();

        return $data;
    }

    // Get My Client Info
    public function getMyClientInfo($ref_code)
    {
        $data = ClientInfo::where('user_id', $ref_code)->first();

        return $data;
    }


    // Get Plan cost
    public function getPlanCost()
    {
        $data = TransactionCost::where('structure', 'Merchant Monthly Subscription')->first();

        return $data;
    }


    // Invoice list
    public function invoiceList()
    {
        $data = ImportExcel::where('uploaded_by', Auth::user()->ref_code)->orderBy('created_at', 'DESC')->get();

        return $data;
    }


    // Paid Invoice
    public function allPaidInvoice()
    {
        $data = InvoicePayment::where('client_id', Auth::user()->ref_code)->orderBy('created_at', 'DESC')->get();


        return $data;
    }


    // Get Total Paid Invoices
    public function totalPaidInvoice()
    {
        $data = InvoicePayment::where('client_id', Auth::user()->ref_code)->sum('amount');


        return $data;
    }

    // Paid Invoice count
    public function paidInvoiceCount()
    {
        $data = InvoicePayment::where('client_id', Auth::user()->ref_code)->count();


        return $data;
    }




    // Received Invoice
    public function receivedInvoice($email)
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

    // Get Personal Data
    public function getmyPersonalDetail($ref_code)
    {
        $data = User::where('ref_code', $ref_code)->first();

        return $data;
    }

    // Get Service Types
    public function getServiceTypes()
    {
        $data = ServiceType::orderBy('created_at', 'DESC')->get();

        return $data;
    }

    // Get Taxes

    public function getTax($id)
    {
        $data = Tax::where('user_id', $id)->orderBy('created_at', 'DESC')->get();

        return $data;
    }


    // Get Active Countries
    public function getActiveCountries()
    {

        $data = AllCountries::where('approval', 1)->get();

        return $data;
    }


    public function getMyProducts($merchantId){
        $data = StoreProducts::where('merchantId', $merchantId)->orderBy('created_at', 'DESC')->get();

        return $data;

    }


    public function getMyOrders($merchantId){
        $data = StoreOrders::join('estore_product', 'estore_orders.productId', '=', 'estore_product.id')->join('users', 'estore_orders.userId', '=', 'users.id')->where('estore_orders.merchantId', $merchantId)->orderBy('estore_orders.created_at', 'DESC')->get();

        return $data;

    }

    public function getMyDiscounts($merchantId){
        $data = StoreDiscount::select('estore_discount.id as discountId', 'estore_discount.userId', 'estore_discount.code', 'estore_discount.valueType', 'estore_discount.discountAmount', 'estore_discount.productId', 'estore_discount.startDate', 'estore_discount.endDate', 'estore_product.id', 'estore_product.productName')->join('estore_product', 'estore_discount.productId', '=', 'estore_product.id')->where('estore_discount.userId', $merchantId)->orderBy('estore_discount.created_at', 'DESC')->get();

        return $data;
    }

    public function getProductCategory(){
        $data = StoreCategory::orderBy('category', 'ASC')->where('state', true)->get();

        return $data;
    }


    public function getStorePickupCount($id){
        $data = StorePickup::where('merchantId', $id)->count();

        return $data;
    }

    public function getStorePickup($id){
        $data = StorePickup::where('merchantId', $id)->get();

        return $data;
    }

    public function getDeliveryPickupCount($id){
        $data = StoreShipping::where('merchantId', $id)->count();

        return $data;
    }

    public function getDeliveryPickup($id){
        $data = StoreShipping::where('merchantId', $id)->get();

        return $data;
    }
}
