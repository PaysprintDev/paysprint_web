<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

use App\User as User;

class MerchantPageController extends Controller
{

    public function __construct(){
        
    }

    public function index()
    {

        return view('merchant.pages.dashboard')->with(['pages' => 'dashboard']);
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
}