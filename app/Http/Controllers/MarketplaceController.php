<?php

namespace App\Http\Controllers;

use Session;

use App\MarkUp;
use App\Points;
use App\PromoDate;
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

use App\UnverifiedMerchant;

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

use App\ServiceType as ServiceType;

use App\Traits\MailChimpNewsLetter;

use App\UpgradePlan as UpgradePlan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Validator;

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
use App\StoreProducts;
use App\StoreMainShop;
use App\FlutterwaveModel;
use App\Traits\SendgridMail;
use Illuminate\Http\Response;

class MarketplaceController extends Controller
{
    use SendgridMail;
    //
    public function getmarketCategory(Request $req)
    {

        try {
            $clients = ClientInfo::get('industry');
            $data = $clients;

            $status = 200;

            $response = [
                'data' => $data,
                'message' => 'success'
            ];
        } catch (\Throwable $th) {

            $response = [
                'data' => [],
                'message' => $th->getMessage()
            ];

            $status = 400;
        }


        return response()->json($response, $status);
    }

    //get all business
    public function getallBusinesses(Request $req)
    {
        try {
            $clients = ClientInfo::where('accountMode', 'live')->get();
            $data = $clients;

            $status = 200;

            $response = [
                'data' => $data,
                'message' => 'success'
            ];
        } catch (\Throwable $th) {

            $response = [
                'data' => [],
                'message' => $th->getMessage()
            ];

            $status = 400;
        }


        return response()->json($response, $status);
    }

    //getting all verified business
    public function getVerifiedBusiness(Request $req)
    {
        try {
            $data = StoreProducts::get();
            $code = 200;

            $response = [
                'data' => $data,
                'message' => 'success'
            ];
        } catch (\Throwable $th) {
            //throw $th;
            $response = [
                'data' => [],
                'message' => $th->getMessage()
            ];

            $code = 400;
        }

        return response()->json($response, $code);
    }


    //latest merchant
    public function newestMerchant(Request $req)
    {
        try {
            $data = StoreMainShop::where('publish', '1')->where('status', 'active')->orderBy('created_at', 'DESC')->get();
            $code = 200;

            $response = [
                'data' => $data,
                'message' => 'success'
            ];
        } catch (\Throwable $th) {
            //throw $th;
            $response = [
                'data' => [],
                'message' => $th->getMessage()
            ];

            $code = 400;
        }

        return response()->json($response, $code);
    }


    //find product
    public function findProduct(Request $req)
    {
        $validation = Validator::make($req->all(), [
            'search' => 'required',
        ]);

        try {
            $data = StoreProducts::where('productName', 'like', '%' . $req->search . '%')->get();
            $code = 200;

            if ($data == null) {
                $response = [
                    'data' => $data,
                    'message' => 'No product or Services Found'
                ];
            }

            $response = [
                'data' => $data,
                'message' => 'success'
            ];
        } catch (\Throwable $th) {
            //throw $th;
            $response = [
                'data' => [],
                'message' => $th->getMessage()
            ];

            $code = 400;
        }

        return response()->json($response, $code);
    }


    //Get Products
    public function getProducts(Request $Req)
    {
        try {

            $data = StoreProducts::get();

            $response = [
                'data' => $data,
                'status' => 'success',
            ];

            $code = 200;
        } catch (\Throwable $th) {
            $response = [
                'data' => [],
                'message' => $th->getMessage(),
                'status' => 'error'
            ];

            $code = 400;
        }

        return response()->json($response, $code);
    }

    //getting all unverified merchants



    //opening an account for unverified merchants

    
}
