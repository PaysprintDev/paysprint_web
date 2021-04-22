@extends('layouts.app')

@section('title', 'Invoice')


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
.notificationImage{
    margin-top: 0px;
}

</style>

@show


@section('content')
    <!-- Banner area -->
    <section class="banner_area" data-stellar-background-ratio="0.5">
        <h2>{{ $pages }}</h2>
        <ol class="breadcrumb">
            <li><a href="{{ route('home') }}">Home</a></li>
            <li><a href="{{ route('invoice') }}" class="active">{{ $pages }}</a></li>
        </ol>
    </section>
    <!-- End Banner area -->

    <!-- Our Services Area -->
    <section class="our_services_tow">
        <div class="container">
            <div class="architecture_area services_pages">
                <div class="portfolio_filter portfolio_filter_2">
                    <ul>
                        {{-- <li data-filter="*" class="active"><a href=""><i class="fa fa-money" aria-hidden="true"></i>Set Up e-Billing</a></li> --}}
                        <li data-filter=".payment" class="active"><a href=""><i class="fa fa-file" aria-hidden="true"></i>Print/View Invoice</a></li>
                        <li data-filter=".payinvoice" onclick="showPayinvoice()" class="disp-0"><a href=""><img src="https://res.cloudinary.com/pilstech/image/upload/v1602676968/paysprint_uh3bux.png" style="width: 150px; height: 50px"><br>Pay Invoice</a></li>
                    </ul>
                </div>
                <div class="portfolio_item portfolio_2">

                    @include('include.message')


                   <div class="grid-sizer-2"></div>
                    <div class="single_facilities col-sm-12 payment">
                        <div class="who_we_area">
                            <div class="subtittle">
                                <h2>PRINT/VIEW INVOICE</h2>
                            </div>
                            <div class="billingIns">
                                <input type="hidden" name="invname" id="invname" value="{{ $name }}">
                                <input type="hidden" name="invemail" id="invemail" value="{{ $email }}">
                                <select name="invoiceService" class="form-control billinginput_box" id="invoiceService">
                                    <option value="">--Select Invoice--</option>
                                    @if(count($service) > 0)
                                        @foreach($service as $services)
                                            <option value="{{ $services->name }}">{{ $services->name }}</option>
                                        @endforeach
                                    @endif

                                </select>
                            </div>
                            <div class="billingIns">
                                <input type="text" name="reference" id="invoiceReference" class="form-control billinginput_box" placeholder="Type Invoice Number*">
                            </div>

                            <div class="row billingIns">
                                <div class="col-md-6"><button class="button_all" onclick="getInvoice()" id="invoice_check" style="width: 100% !important;">View Invoice</button></div>
                                <div class="col-md-6"><button class="button_all" onclick="payInv()" id="payment_check" style="width: 100% !important; background: green; color: white;">Pay Invoice</button></div>
                            </div>

                        </div>
                    </div>

                    <div class="single_facilities col-sm-12 payinvoice disp-0">
                        <div class="who_we_area">
                            <div class="subtittle">
                                <h2>2. PAY INVOICE</h2>
                            </div>

                            <div class="billingIns">
                                <input type="hidden" name="payemail" id="payemail" value="{{ $email }}">
                                <input type="text" name="invoiceNumber" id="invoiceNumber" class="form-control billinginput_box" placeholder="Type Invoice Number*">
                            </div>
                            <button class="button_all" onclick="makePay()" id="pay_invoice">Submit</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- End Our Services Area -->


@endsection

