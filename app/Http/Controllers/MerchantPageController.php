<?php

namespace App\Http\Controllers;

use App\AllCountries;
use App\Statement;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\User as User;
use App\ImportExcel as ImportExcel;
use App\ImportExcelLink as ImportExcelLink;
use App\InvoicePayment as InvoicePayment;
use App\Points;

use App\ClaimedPoints;

use App\HistoryReport;
use App\ServiceType;
use App\Tax;
use App\Traits\PaysprintPoint;

use App\Traits\PointsHistory;

class MerchantPageController extends Controller
{

    use PaysprintPoint, PointsHistory;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $data = [
            'receivedInvoice' => $this->receivedInvoice(Auth::user()->email),
            'allPaidInvoice' => $this->allPaidInvoice(),
            'invoiceLink' => $this->invoiceLink(),
            'invoiceList' => $this->invoiceList(),
            'statementCount' => $this->statementCount(),
            'paidInvoiceCount' => $this->paidInvoiceCount(),
            'mypoints' => $this->getAcquiredPoints(Auth::user()->id),
        ];


        return view('merchant.pages.dashboard')->with(['pages' => 'dashboard', 'data' => $data]);
    }

    public function invoiceSingle()
    {

        $data = [
            'mypoints' => $this->getAcquiredPoints(Auth::user()->id)
        ];


        return view('merchant.pages.invoice')->with(['pages' => 'invoice single', 'data' => $data]);
    }

    public function invoiceForm()
    {
        $data = [
            'mypoints' => $this->getAcquiredPoints(Auth::user()->id),
            'getServiceType' => $this->getServiceTypes(),
            'getTax' => $this->getTax(Auth::user()->id),
            'getpersonalData' => $this->getmyPersonalDetail(Auth::user()->ref_code),
            'getimt' => $this->getActiveCountries()
        ];



        return view('merchant.pages.singleinvoice')->with(['pages' => 'invoice form', 'data' => $data]);
    }

    public function invoiceTypes()
    {
        $data = [
            'mypoints' => $this->getAcquiredPoints(Auth::user()->id),
            'getServiceType' => $this->getServiceTypes()
        ];

        return view('merchant.pages.createinvoicetypes')->with(['pages' => 'invoice types', 'data' => $data]);
    }

    public function setUpTax()
    {

        $data = [
            'mypoints' => $this->getAcquiredPoints(Auth::user()->id),
            'getTax' => $this->getTax(Auth::user()->id)
        ];

        return view('merchant.pages.setuptax')->with(['pages' => 'set up tax', 'data' => $data]);
    }

    public function invoiceStatement()
    {

        $data = [
            'mypoints' => $this->getAcquiredPoints(Auth::user()->id)
        ];

        return view('merchant.pages.invoicestatement')->with(['pages' => 'invoice statement', 'data' => $data]);
    }

    public function walletStatement()
    {

        $data = [
            'mypoints' => $this->getAcquiredPoints(Auth::user()->id)
        ];

        return view('merchant.pages.walletstatement')->with(['pages' => 'wallet statement', 'data' => $data]);
    }

    public function sentInvoice()
    {

        $data = [
            'mypoints' => $this->getAcquiredPoints(Auth::user()->id)
        ];

        return view('merchant.pages.sentinvoice')->with(['pages' => 'sent invoice', 'data' => $data]);
    }

    public function paidInvoice()
    {

        $data = [
            'mypoints' => $this->getAcquiredPoints(Auth::user()->id)
        ];

        return view('merchant.pages.paidinvoice')->with(['pages' => 'paid invoice', 'data' => $data]);
    }

    public function pendingInvoice()
    {

        $data = [
            'mypoints' => $this->getAcquiredPoints(Auth::user()->id)
        ];

        return view('merchant.pages.pendinginvoice')->with(['pages' => 'pending invoice', 'data' => $data]);
    }

    public function balanceReport()
    {

        $data = [
            'mypoints' => $this->getAcquiredPoints(Auth::user()->id)
        ];

        return view('merchant.pages.customerbalancereport')->with(['pages' => 'balance report', 'data' => $data]);
    }

    public function taxesReport()
    {

        $data = [
            'mypoints' => $this->getAcquiredPoints(Auth::user()->id)
        ];

        return view('merchant.pages.taxesreport')->with(['pages' => 'taxes report', 'data' => $data]);
    }

    public function invoiceTypeReport()
    {

        $data = [
            'mypoints' => $this->getAcquiredPoints(Auth::user()->id)
        ];

        return view('merchant.pages.invoicetypereport')->with(['pages' => 'invoice type report', 'data' => $data]);
    }

    public function recurringType()
    {

        $data = [
            'mypoints' => $this->getAcquiredPoints(Auth::user()->id)
        ];

        return view('merchant.pages.recurringtype')->with(['pages' => 'recurring type', 'data' => $data]);
    }

    public function profile()
    {

        $data = [
            'mypoints' => $this->getAcquiredPoints(Auth::user()->id)
        ];

        return view('merchant.pages.profile')->with(['pages' => 'profile', 'data' => $data]);
    }
    public function invoicePage()
    {

        $data = [
            'mypoints' => $this->getAcquiredPoints(Auth::user()->id)
        ];

        return view('merchant.pages.invoicepage')->with(['pages' => 'invoice page', 'data' => $data]);
    }

    public function paymentGateway()
    {

        $data = [
            'mypoints' => $this->getAcquiredPoints(Auth::user()->id)
        ];

        return view('merchant.pages.paymentmethod')->with(['pages' => 'invoice page', 'data' => $data]);
    }

    public function orderingSystem()
    {

        $data = [
            'mypoints' => $this->getAcquiredPoints(Auth::user()->id)
        ];

        return view('merchant.pages.orderingsystem')->with(['pages' => 'invoice page', 'data' => $data]);
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
}