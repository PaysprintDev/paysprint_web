@extends('layouts.app')

@section('title', 'Invoice')
<?php use \App\Http\Controllers\User; ?>
<?php use \App\Http\Controllers\InvoicePayment; ?>

@show

@section('text/css')

<style>
    .billingIns{
    margin-bottom: 10px;
}
.billingIns > input{
    padding: 20px 15px;
}
.billingIns > select{
    padding: 5px 15px;
    line-height: 10;
}
.billingIns > .billinginput_box_input{
    padding: 5px !important;
}
.tab-menu{
    font-weight: bold;
    color: navy;
}
</style>


@show


@section('content')
    <!-- Banner area -->
    <section class="banner_area" data-stellar-background-ratio="0.5">
        <h2>{{ $pages }}</h2>
        <ol class="breadcrumb">
            <li><a href="{{ route('home') }}">Home</a></li>
            <li><a href="#" class="active">{{ $pages }}</a></li>
        </ol>
    </section>
    <!-- End Banner area -->

    <!-- Our Services Area -->
    <section class="our_services_tow">
        <div class="container">
            <div class="architecture_area services_pages">
                <div class="portfolio_item portfolio_2">
                   <div class="grid-sizer-2"></div>
                    <div class="single_facilities col-md-12 payment">

                        @if(session()->has('message'))
                            <div class="alert alert-success">
                                {{ session()->get('message') }}
                            </div>

                            @elseif(session()->has('error'))

                            <div class="alert alert-danger">
                                {{ session()->get('error') }}
                            </div>

                        @endif


                        <ul class="nav nav-tabs">
                        <li class="tab-menu active"><a data-toggle="tab" href="#home">Maintenance Invoice</a></li>
                        <li class="tab-menu"><a data-toggle="tab" href="#menu1">Options</a></li>
                        </ul>

                        <div class="tab-content">
                        <div id="home" class="tab-pane fade in active">
                        <div class="who_we_area">

                            <div class="subtittle">
                                <h2>Maintenance Invoice</h2>
                            </div>

                            <div class="table table-responsive">
                                <input type="search" name="search" id="search_field" class="form-control" placeholder="Search by Invoice number, Reference number, Service, Description, Invoice by...">
                                <br>
                            <table class="table table-striped table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <td>#</td>
                                        <td>Transaction Date</td>
                                        <td>Invoice No.</td>
                                        <td>Reference No.</td>
                                        <td>Service</td>
                                        <td>Description</td>
                                        <td>Payment Due Date</td>
                                        <td>Invoice by</td>
                                        <td style="text-align: center">Action</td>
                                    </tr>
                                </thead>
                                <tbody id="myTable">
                                    @if (count($statuschecker) > 0)

                                    <?php $i = 1;?>
                                    @foreach ($statuschecker as $item)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ date('d/M/Y', strtotime($item->transaction_date)) }}</td>
                                            <td>{{ $item->invoice_no }}</td>
                                            <td>{{ $item->payee_ref_no }}</td>
                                            <td>{{ $item->service }}</td>
                                            <td>{!! $item->description !!}</td>
                                            <td>{{ date('d/M/Y', strtotime($item->payment_due_date)) }}</td>
                                            <td>
                                                @if($user = \App\User::where('email', $item->uploaded_by)->get())

                                                    @if(count($user) > 0)
                                                        {{ $user[0]->name }}
                                                    @else
                                                        -
                                                    @endif

                                                @endif
                                            </td>
                                            <td align="center">
                                            @if($leftOver = \App\InvoicePayment::where('invoice_no', $item->invoice_no)->get())

                                            @if(count($leftOver) > 0)

                                                <a type="button" class="btn btn-success" title="Pay Invoice" style="cursor: not-allowed" disabled><i class="fa fa-credit-card"></i> Invoice Paid</a>
                                            @else
                                                <input type="hidden" name="payemail" id="payemail" value="{{ $item->payee_email }}">
                                                <a type="button" onclick="makePays('{{ $item->invoice_no }}')" class="btn btn-danger" title="Pay Invoice"><i class="fa fa-credit-card"></i> Pay Invoice</a>

                                            @endif

                                            @endif
                                            </td>


                                        </tr>
                                    @endforeach

                                    @else
                                        <tr>
                                            <td colspan="9" align="center">No record available for your request</td>
                                        </tr>
                                    @endif

                                </tbody>
                            </table>
                        </div>



                        </div>
                        </div>
                        <div id="menu1" class="tab-pane fade">
                        <br>
                            <div class="selector">
                            <div class="subtittle">
                                <h3>Please select an option below</h3>
                                <select name="perform_action" id="perform_action" class="form-control">
                                    <option value="">Select other options</option>
                                    <option value="admin_menu">Rental Property Management Dashboard</option>
                                    <option value="request_submitted">Request Received</option>
                                    <option value="request_opened">Request Open</option>
                                    <option value="request_cancelled">Request Cancelled</option>
                                    <option value="request_closed">Request Closed</option>
                                    <option value="request_completed">Request Completed</option>
                                    <option value="view_quotes">View Quotes</option>
                                    <option value="view_invoices">View Invoices</option>
                                </select>
                            </div>
                        </div>
                        </div>
                        </div>



                    </div>
                    <br>

                </div>
            </div>
        </div>
    </section>
    <!-- End Our Services Area -->



@endsection
