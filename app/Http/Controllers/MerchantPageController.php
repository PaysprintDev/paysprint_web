<?php

namespace App\Http\Controllers;

use App\Statement;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\User as User;
use App\ImportExcel as ImportExcel;
use App\ImportExcelLink as ImportExcelLink;
use App\InvoicePayment as InvoicePayment;

class MerchantPageController extends Controller
{

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
        ];


        return view('merchant.pages.dashboard')->with(['pages' => 'dashboard', 'data' => $data]);
    }

    public function invoiceSingle()
    {

        return view('merchant.pages.invoice')->with(['pages' => 'invoice single']);
    }

    public function invoiceForm()
    {

        return view('merchant.pages.forms')->with(['pages' => 'invoice form']);
    }

    public function invoiceTypes()
    {

        return view('merchant.pages.createinvoicetypes')->with(['pages' => 'invoice types']);
    }

    public function setUpTax()
    {

        return view('merchant.pages.setuptax')->with(['pages' => 'set up tax']);
    }

    public function invoiceStatement()
    {

        return view('merchant.pages.invoicestatement')->with(['pages' => 'invoice statement']);
    }

    public function walletStatement()
    {

        return view('merchant.pages.walletstatement')->with(['pages' => 'wallet statement']);
    }

    public function sentInvoice()
    {

        return view('merchant.pages.sentinvoice')->with(['pages' => 'sent invoice']);
    }

    public function paidInvoice()
    {

        return view('merchant.pages.paidinvoice')->with(['pages' => 'paid invoice']);
    }

    public function pendingInvoice()
    {

        return view('merchant.pages.pendinginvoice')->with(['pages' => 'pending invoice']);
    }

    public function balanceReport()
    {

        return view('merchant.pages.customerbalancereport')->with(['pages' => 'balance report']);
    }

    public function taxesReport()
    {

        return view('merchant.pages.taxesreport')->with(['pages' => 'taxes report']);
    }

    public function invoiceTypeReport()
    {

        return view('merchant.pages.invoicetypereport')->with(['pages' => 'invoice type report']);
    }

    public function recurringType()
    {

        return view('merchant.pages.recurringtype')->with(['pages' => 'recurring type']);
    }

    public function profile()
    {

        return view('merchant.pages.profile')->with(['pages' => 'profile']);
    }
    public function invoicePage()
    {

        return view('merchant.pages.invoicepage')->with(['pages' => 'invoice page']);
    }

    public function paymentGateway()
    {

        return view('merchant.pages.paymentmethod')->with(['pages' => 'invoice page']);
    }

    public function orderingSystem()
    {

        return view('merchant.pages.orderingsystem')->with(['pages' => 'invoice page']);
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
}