@extends('layouts.dashboard')


@section('dashContent')

    <?php use App\Http\Controllers\ClientInfo; ?>
    <?php use App\Http\Controllers\User; ?>
    <?php use App\Http\Controllers\UserClosed; ?>
    <?php use App\Http\Controllers\InvoicePayment; ?>
    <?php use App\Http\Controllers\AllCountries; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Transaction Review

                @if (session('role') != 'Super' && session('role') != 'Access to Level 1 and 2 only' && session('role') != 'Access to Level 1 only')

                    @if ($userInfo = \App\User::where('ref_code', session('user_id'))->first())

                        @if (isset($userInfo))

                            <h4 class="welcome" style="color: green; font-weight: bold;">Account Number:
                                {{ $userInfo->ref_code }}</h4>

                            <a href="{{ route('merchant profile') }}" type="btutton" class="btn btn-danger">Promote your
                                business</a>

                            @if ($userInfo->approval == 0 || $userInfo->accountLevel == 0)
                                <div class="row">
                                    <div class="alert bg-danger alert-dismissible show" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>

                                        <p>
                                            <strong>Welcome {{ $userInfo->name }}!</strong> <br> Our system is yet to
                                            complete your registration. Kindly upload a copy of Government-issued Photo ID,
                                            a copy of a Utility Bill or Bank Statement that matches your name with the
                                            current address and also take a Selfie of yourself (if using the mobile app) and
                                            <a href="{{ route('merchant profile') }}"
                                                style="font-weight: bold; text-decoration: underline; color: navy">upload in
                                                your profile setting</a> to complete the verification process. <a
                                                href="{{ route('contact') }}"
                                                style="font-weight: bold; text-decoration: underline; color: navy">Kindly
                                                contact the admin using the contact us form if you require further
                                                assistance. Thank You</a>
                                        </p>



                                    </div>
                                </div>

                            @endif

                        @else
                            <small>Control panel</small>
                        @endif





                    @endif
                @endif

            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Dashboard</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Small boxes (Stat box) -->
            <div class="row">


<div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-aqua">
        <div class="inner">
            <h3>&nbsp;</h3>


            <p>Request Withdrawal to Bank</p>
        </div>
        <div class="icon">
            <i class="ion ion-stats-bars"></i>
        </div>
        <a href="{{ route('Request aml for Withdrawal to bank') }}" class="small-box-footer">View details <i
                class="fa fa-arrow-circle-right"></i></a>
    </div>
</div>
<!-- ./col -->
<div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-green">
        <div class="inner">
            <h3>{{ count($withdraws['bank']) }}</h3>

            <p>purchase aml Refund Request</p>
        </div>
        <div class="icon">
            <i class="ion ion-stats-bars"></i>
        </div>
        <a href="{{ route('Purchase aml Refund Request') }}" class="small-box-footer">View details <i class="fa fa-arrow-circle-right"></i></a>
    </div>
</div>

<div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-black">
        <div class="inner">
            <h3>{{ count($withdraws['purchase']) }}</h3>

            <p>Credit Card Withdrawal Request</p>
        </div>
        <div class="icon">
            <i class="ion ion-stats-bars"></i>
        </div>
        <a href="{{ route('Credit Card withdrawal Request') }}" class="small-box-footer">View details <i
                class="fa fa-arrow-circle-right"></i></a>
    </div>
</div>


<div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-blue">
        <div class="inner">
            <h3>{{ count($withdraws['credit']) }}</h3>

            <p>Pending Transfer</p>
        </div>
        <div class="icon">
            <i class="ion ion-stats-bars"></i>
        </div>
        <a href="{{ route('Pending aml Transfer') }} " class="small-box-footer">View details <i
                class="fa fa-arrow-circle-right"></i></a>
    </div>
</div>


<div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-purple">
        <div class="inner">

            @if (isset($withdraws['prepaid']))
                <h3>{{ count($withdraws['prepaid']->data) }}</h3>

            @else
                <h3>0</h3>
            @endif


            <p>Prepaid Card Withdrawal Request </p>
        </div>
        <div class="icon">
            <i class="ion ion-stats-bars"></i>
        </div>
        <a href="{{ route('Prepaid Card withdrawal Request') }}" class="small-box-footer">View details <i class="fa fa-arrow-circle-right"></i></a>
    </div>
</div>

<div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-purple">
        <div class="inner">

            @if (isset($withdraws['prepaid']))
                <h3>{{ count($withdraws['prepaid']->data) }}</h3>

            @else
                <h3>0</h3>
            @endif


            <p>Request Remitance to Client </p>
        </div>
        <div class="icon">
            <i class="ion ion-stats-bars"></i>
        </div>
        <a href="{{ route('Request for Remittance to Client') }}" class="small-box-footer">View details <i class="fa fa-arrow-circle-right"></i></a>
    </div>
</div>

<div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-purple">
        <div class="inner">

            @if (isset($withdraws['prepaid']))
                <h3>{{ count($withdraws['prepaid']->data) }}</h3>

            @else
                <h3>0</h3>
            @endif


            <p>Request for Refund </p>
        </div>
        <div class="icon">
            <i class="ion ion-stats-bars"></i>
        </div>
        <a href="{{ route('Request for Refund') }}" class="small-box-footer">View details <i class="fa fa-arrow-circle-right"></i></a>
    </div>
</div>



            </div>
            <br>
            <br>

            @if (session('role') != 'Super' && session('role') != 'Access to Level 1 and 2 only' && session('role') != 'Access to Level 1 only' && session('role') != 'Customer Marketing')
                <!-- /.row -->
                <!-- Main row -->
                <div class="row">


                    <!-- Left col -->
                    <section class="col-lg-12 connectedSortable">


                        <!-- TO DO List -->
                        <div class="box box-primary receivedMoney">
                            <div class="box-header">
                                <i class="ion ion-clipboard"></i>

                                <h3 class="box-title">Received Invoice</h3>

                            </div>
                            <!-- /.box-header -->
                            <div class="box-body table table-responsive">
                                <table id="example3" class="table table-bordered table-hover">
                                    {{-- @if (session('role') != 'Super')<caption><button type="button" class="btn btn-success" style="float:right" id="recurAll" onclick="recurring('All', {{ session('user_id') }})">Recur All</button></caption>@endif --}}
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Description</th>
                                            <th>Invoice #</th>
                                            <th>Status</th>
                                            <th>Amount</th>
                                            <th>Created Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (isset($received['payInvoice']))
                                            <?php $i = 1; ?>
                                            @foreach (json_decode($received['payInvoice']) as $payInv)






                                                {{-- Get Merchant Currency --}}

                                                @if ($merchant = \App\User::where('ref_code', $payInv->uploaded_by)->first())

                                                    @if ($payInv->invoiced_currency != null)
                                                        @php
                                                            $currencySymb = $payInv->invoiced_currency_symbol;
                                                        @endphp
                                                    @else
                                                        @php
                                                            $currencySymb = $merchant->currencySymbol;
                                                        @endphp
                                                    @endif


                                                    @php
                                                        $countryBase = $merchant->country;
                                                    @endphp


                                                @else

                                                    @if ($payInv->invoiced_currency != null)
                                                        @php
                                                            $currencySymb = $payInv->invoiced_currency_symbol;
                                                        @endphp
                                                    @else
                                                        @php
                                                            $currencySymb = $getUserDetail->currencySymbol;
                                                        @endphp
                                                    @endif

                                                    @php
                                                        $countryBase = session('country');
                                                    @endphp

                                                @endif

                                                <tr>


                                                    <td>{{ $i++ }}</td>
                                                    <td>
                                                        {!! 'Invoice for ' . $payInv->service . ' to ' . $payInv->merchantName !!}
                                                    </td>

                                                    <td>{{ $payInv->invoice_no }} {!! $countryBase != session('country') ? '<img src="https://img.icons8.com/color/30/000000/around-the-globe.png"/>' : '' !!}</td>



                                                    @if ($payInv->payment_status == 0)
                                                        <td>
                                                            <a href="{{ route('payment', $payInv->invoice_no) }}"
                                                                type="button" class='btn btn-danger'>Pay Invoice</a>
                                                        </td>
                                                    @elseif($payInv->payment_status == 2)
                                                        <td>
                                                            <a href="{{ route('payment', $payInv->invoice_no) }}"
                                                                type="button" class='btn btn-danger'
                                                                style='cursor: pointer;'>Pay Balance</a>
                                                        </td>
                                                    @else
                                                        <td style="font-weight: bold; color: green;">Paid</td>
                                                    @endif

                                                    <td style="font-weight: 700">
                                                        @php
                                                            if ($payInv->total_amount != null || $payInv->total_amount != 0) {
                                                                $totalAmount = $payInv->total_amount;
                                                            } else {
                                                                $totalAmount = $payInv->amount;
                                                            }
                                                        @endphp

                                                        @if ($payInv->payment_status == 0)
                                                            {{ '+' . $currencySymb . number_format($totalAmount, 2) }}
                                                        @elseif($payInv->payment_status == 2)
                                                            {{ '-' . $currencySymb . number_format($payInv->remaining_balance, 2) }}
                                                        @else
                                                            {{ '-' . $currencySymb . number_format($totalAmount, 2) }}
                                                        @endif

                                                    </td>

                                                    <td>{{ date('d/m/Y h:i a', strtotime($payInv->created_at)) }}</td>


                                                </tr>
                                            @endforeach

                                        @else
                                            <tr>
                                                <td colspan="6" align="center"> No uploaded Invoice yet</td>
                                            </tr>
                                        @endif


                                    </tbody>
                                </table>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->


                    </section>
                    <!-- /.Left col -->


                    <!-- Left col -->
                    <section class="col-lg-12 connectedSortable">


                        <!-- TO DO List -->
                        <div class="box box-primary importList">
                            <div class="box-header">
                                <i class="ion ion-clipboard"></i>

                                <h3 class="box-title">Import Invoice List</h3>

                            </div>
                            <!-- /.box-header -->
                            <div class="box-body table table-responsive">
                                <table id="example4" class="table table-bordered table-hover">
                                    {{-- @if (session('role') != 'Super')<caption><button type="button" class="btn btn-success" style="float:right" id="recurAll" onclick="recurring('All', {{ session('user_id') }})">Recur All</button></caption>@endif --}}
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Created Date</th>
                                            <th>Trans. Date</th>
                                            <th>Invoice #</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Service</th>
                                            <th>Amount</th>
                                            <th>Tax Amount</th>
                                            <th>Total Amount</th>
                                            <th>Status</th>
                                            <th>Pay Due Date</th>
                                            @if (session('role') != 'Super' && session('role') != 'Access to Level 1 and 2 only' && session('role') != 'Access to Level 1 only')<th>Action</th>@endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($invoiceImport) > 0)
                                            <?php $i = 1; ?>
                                            @foreach ($invoiceImport as $invoiceImports)

                                                @if ($invoiceImports->invoiced_currency != null)
                                                    @php
                                                        $symbolVal = $invoiceImports->invoiced_currency_symbol;
                                                    @endphp
                                                @else
                                                    @php
                                                        $symbolVal = $getUserDetail->currencySymbol;
                                                    @endphp
                                                @endif

                                                <tr>


                                                    <td>{{ $i++ }}</td>
                                                    <td>{{ date('d/M/Y', strtotime($invoiceImports->created_at)) }}</td>
                                                    <td>{{ date('d/M/Y', strtotime($invoiceImports->transaction_date)) }}
                                                    </td>
                                                    <td>{{ $invoiceImports->invoice_no }}</td>
                                                    <td>{{ $invoiceImports->name }}</td>
                                                    <td title="{{ $invoiceImports->payee_email }}"><?php $string = $invoiceImports->payee_email;
$output = strlen($string) > 10 ? substr($string, 0, 10) . '...' : $string;
echo $output; ?>
                                                    </td>
                                                    <td title="{{ $invoiceImports->service }}"><?php $string = $invoiceImports->service;
$output = strlen($string) > 10 ? substr($string, 0, 10) . '...' : $string;
echo $output; ?></td>
                                                    <td align="center" style="font-weight: bold; color: navy;">
                                                        @if (isset($getUserDetail) == true) {{ $symbolVal . number_format($invoiceImports->amount, 2) }} @else {{ number_format($invoiceImports->amount, 2) }} @endif </td>

                                                    <td align="center" style="font-weight: bold; color: purple;">
                                                        @if (isset($getUserDetail) == true) {{ $symbolVal . number_format($invoiceImports->tax_amount, 2) }} @else {{ number_format($invoiceImports->tax_amount, 2) }} @endif </td>

                                                    <td align="center" style="font-weight: bold; color: green;">
                                                        @if (isset($getUserDetail) == true) {{ $symbolVal . number_format($invoiceImports->total_amount, 2) }} @else {{ number_format($invoiceImports->total_amount, 2) }} @endif </td>

                                                    @if ($invoiceImports->payment_status == 1)
                                                        <td align="center" style="font-weight: bold; color: green;">Paid
                                                        </td>

                                                    @elseif ($invoiceImports->payment_status == 2)

                                                        <td align="center" style="font-weight: bold; color: purple;">Part
                                                            Pay</td>

                                                    @else

                                                        <td align="center" style="font-weight: bold; color: red;">Unpaid
                                                        </td>

                                                    @endif


                                                    {{-- @if ($leftOver = \App\InvoicePayment::where('invoice_no', $invoiceImports->invoice_no)->get())

                        @if (count($leftOver) > 0)
                        <td align="center" style="font-weight: bold; color: green;">Paid</td>

                        @else
                        <td align="center" style="font-weight: bold; color: red;">Pending</td>

                        @endif

                      @endif --}}
                                                    <td>{{ date('d/M/Y', strtotime($invoiceImports->payment_due_date)) }}
                                                    </td>

                                                    @if (session('role') != 'Super' && session('role') != 'Access to Level 1 and 2 only' && session('role') != 'Access to Level 1 only') <td><button type="button" class="btn btn-primary" id="viewdetails{{ $invoiceImports->id }}" onclick="location.href='Admin/customer/{{ $invoiceImports->id }}'">View Details</button></td>@endif
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="10" align="center"> No uploaded Invoice yet</td>
                                            </tr>
                                        @endif


                                    </tbody>
                                </table>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->


                    </section>
                    <!-- /.Left col -->


                    {{-- Invoice Link Customer --}}

                    <!-- Left col -->
                    <section class="col-lg-12 connectedSortable">


                        <!-- TO DO List -->
                        <div class="box box-primary importList">
                            <div class="box-header">
                                <i class="ion ion-clipboard"></i>

                                <h3 class="box-title">Invoice To Link Customers</h3>

                            </div>
                            <!-- /.box-header -->
                            <div class="box-body table table-responsive">
                                <table id="example4" class="table table-bordered table-hover">
                                    {{-- @if (session('role') != 'Super')<caption><button type="button" class="btn btn-success" style="float:right" id="recurAll" onclick="recurring('All', {{ session('user_id') }})">Recur All</button></caption>@endif --}}
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Created Date</th>
                                            <th>Trans. Date</th>
                                            <th>Invoice #</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Service</th>
                                            <th>Amount</th>
                                            <th>Tax Amount</th>
                                            <th>Total Amount</th>
                                            <th>Status</th>
                                            <th>Pay Due Date</th>
                                            @if (session('role') != 'Super' && session('role') != 'Access to Level 1 and 2 only' && session('role') != 'Access to Level 1 only')<th>Action</th>@endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($invoiceLinkImport) > 0)
                                            <?php $i = 1; ?>
                                            @foreach ($invoiceLinkImport as $invoiceLinkImports)

                                                <tr>


                                                    <td>{{ $i++ }}</td>
                                                    <td>{{ date('d/M/Y', strtotime($invoiceLinkImports->created_at)) }}
                                                    </td>
                                                    <td>{{ date('d/M/Y', strtotime($invoiceLinkImports->transaction_date)) }}
                                                    </td>
                                                    <td>{{ $invoiceLinkImports->invoice_no }}</td>
                                                    <td>{{ $invoiceLinkImports->name }}</td>
                                                    <td title="{{ $invoiceLinkImports->payee_email }}">
                                                        <?php $string = $invoiceLinkImports->payee_email;
                                                        $output = strlen($string) > 10 ? substr($string, 0, 10) . '...' : $string;
                                                        echo $output; ?></td>
                                                    <td title="{{ $invoiceLinkImports->service }}"><?php $string = $invoiceLinkImports->service;
$output = strlen($string) > 10 ? substr($string, 0, 10) . '...' : $string;
echo $output; ?>
                                                    </td>
                                                    <td align="center" style="font-weight: bold; color: navy;">
                                                        @if (isset($getUserDetail) == true) {{ $getUserDetail->currencySymbol . number_format($invoiceLinkImports->amount, 2) }} @else {{ number_format($invoiceLinkImports->amount, 2) }} @endif </td>

                                                    <td align="center" style="font-weight: bold; color: purple;">
                                                        @if (isset($getUserDetail) == true) {{ $getUserDetail->currencySymbol . number_format($invoiceLinkImports->tax_amount, 2) }} @else {{ number_format($invoiceLinkImports->tax_amount, 2) }} @endif </td>

                                                    <td align="center" style="font-weight: bold; color: green;">
                                                        @if (isset($getUserDetail) == true) {{ $getUserDetail->currencySymbol . number_format($invoiceLinkImports->total_amount, 2) }} @else {{ number_format($invoiceLinkImports->total_amount, 2) }} @endif </td>

                                                    @if ($invoiceLinkImports->payment_status == 1)
                                                        <td align="center" style="font-weight: bold; color: green;">Paid
                                                        </td>

                                                    @elseif ($invoiceLinkImports->payment_status == 2)

                                                        <td align="center" style="font-weight: bold; color: purple;">Part
                                                            Pay</td>

                                                    @else

                                                        <td align="center" style="font-weight: bold; color: red;">Unpaid
                                                        </td>

                                                    @endif


                                                    {{-- @if ($leftOver = \App\InvoicePayment::where('invoice_no', $invoiceLinkImports->invoice_no)->get())

                        @if (count($leftOver) > 0)
                        <td align="center" style="font-weight: bold; color: green;">Paid</td>

                        @else
                        <td align="center" style="font-weight: bold; color: red;">Pending</td>

                        @endif

                      @endif --}}
                                                    <td>{{ date('d/M/Y', strtotime($invoiceLinkImports->payment_due_date)) }}
                                                    </td>

                                                    @if (session('role') != 'Super' && session('role') != 'Access to Level 1 and 2 only' && session('role') != 'Access to Level 1 only') <td><button type="button" class="btn btn-primary" id="viewdetails{{ $invoiceLinkImports->id }}" onclick="location.href='Admin/linkcustomer/{{ $invoiceLinkImports->id }}'">View Details</button></td>@endif
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="10" align="center"> No uploaded Invoice yet</td>
                                            </tr>
                                        @endif


                                    </tbody>
                                </table>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->


                    </section>


                    <!-- right col (We are only adding the ID to make the widgets sortable)-->
                    <section class="col-lg-12 connectedSortable">

                        <!-- TO DO List -->
                        <div class="box box-primary receivePaid">
                            <div class="box-header">
                                <i class="ion ion-clipboard"></i>

                                <h3 class="box-title">Recently Paid Invoices</h3>
                            </div>

                            @if (session('role') == 'Super')

                                <!-- /.box-header -->
                                <div class="box-body table table-responsive">
                                    <table id="example1" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Transaction ID</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Amount</th>
                                                <th>Invoice #</th>
                                                <th>Service</th>
                                                <th>Client</th>
                                                <th>Pay Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @if (count($payInvoice) > 0)
                                                <?php $i = 1; ?>
                                                @foreach ($payInvoice as $payInvoices)
                                                    <tr>
                                                        <td>{{ $i++ }}</td>
                                                        <td>{{ $payInvoices->transactionid }}</td>
                                                        <td>{{ $payInvoices->name }}</td>
                                                        <td>{{ $payInvoices->email }}</td>
                                                        <td style="font-weight: bold; color: green;">
                                                            {{ number_format($payInvoices->amount) }}</td>
                                                        <td>{{ $payInvoices->invoice_no }}</td>
                                                        <td>{{ $payInvoices->service }}</td>
                                                        <td>{{ $payInvoices->business_name }}</td>
                                                        <td>{{ date('d/M/Y', strtotime($payInvoices->created_at)) }}</td>
                                                    </tr>
                                                @endforeach

                                            @else
                                                <tr>
                                                    <td colspan="8" align="center">No payment made to client yet</td>
                                                </tr>

                                            @endif


                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.box-body -->

                            @else

                                <!-- /.box-header -->
                                <div class="box-body table table-responsive">
                                    <table id="example1" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Trans. ID</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Amount</th>
                                                <th>Invoice #</th>
                                                <th>Service</th>
                                                <th>Pay Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @if (count($payInvoice) > 0)
                                                <?php $i = 1; ?>
                                                @foreach ($payInvoice as $payInvoices)
                                                    <tr>
                                                        <td>{{ $i++ }}</td>
                                                        <td>{{ $payInvoices->transactionid }}</td>
                                                        <td>{{ $payInvoices->name }}</td>
                                                        <td>{{ $payInvoices->email }}</td>
                                                        <td style="font-weight: bold; color: green;">
                                                            {{ $getUserDetail->currencySymbol . number_format($payInvoices->amount) }}
                                                        </td>
                                                        <td>{{ $payInvoices->invoice_no }}</td>
                                                        <td>{{ $payInvoices->service }}</td>
                                                        <td>{{ date('d/M/Y', strtotime($payInvoices->created_at)) }}</td>
                                                    </tr>
                                                @endforeach

                                            @else
                                                <tr>
                                                    <td colspan="8" align="center">No Payment made yet</td>
                                                </tr>

                                            @endif


                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.box-body -->

                            @endif

                        </div>
                        <!-- /.box -->

                    </section>
                    <!-- right col -->
                </div>
                <!-- /.row (main row) -->

            @endif

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

@endsection
