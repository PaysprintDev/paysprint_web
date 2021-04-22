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
            <li><a href="{{ route('statement') }}" class="active">{{ $pages }}</a></li>
        </ol>
    </section>
    <!-- End Banner area -->

    <!-- Our Services Area -->
    <section class="our_services_tow">
        <div class="container">
            <div class="architecture_area services_pages">
                <div class="portfolio_filter portfolio_filter_2">
                    <ul>
                        <li data-filter="*" class="active"><a href=""><i class="fa fa-file" aria-hidden="true"></i>Generate Statement</a></li>
                        {{-- <li data-filter=".payment"><a href=""><img src="https://p7.hiclipart.com/preview/40/409/113/letter-alphabet-patrol-others.jpg" style="width: 50px; height: 50px"><br>Make Payment</a></li> --}}
                    </ul>
                </div>
                <div class="portfolio_item portfolio_2">
                   <div class="grid-sizer-2"></div>

                    <div class="single_facilities col-sm-12 invoice">
                        <div class="who_we_area">
                            <div class="subtittle">
                                <h2>GENERATE STATEMENT</h2>
                            </div>
                            <div class="billingIns">
                                <input type="hidden" name="invname" id="invname" value="{{ $name }}">
                                <input type="hidden" name="invemail" id="invemail" value="{{ $email }}">
                                <label for="invoiceService">Type of Statement</label>
                                <select name="invoiceService" class="form-control billinginput_box" id="invoiceService">
                                    <option value="">--Select Statement--</option>
                                    <option value="Wallet">Wallet</option>
                                    @if(count($data['service']) > 0)
                                        @foreach($data['service'] as $services)
                                            <option value="{{ $services->name }}">{{ $services->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="billingIns">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="start_date">Start Date</label>
                                        <input type="date" name="start_date" id="start_date" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="end_date">End Date</label>
                                        <input type="date" name="end_date" id="end_date" class="form-control">
                                    </div>
                                </div>
                                {{-- <input type="text" name="reference" id="invoiceReference" class="form-control billinginput_box" placeholder="Type Invoice Reference Number*"> --}}
                            </div>
                            <button class="button_all" onclick="getStatement()" id="invoice_check">Submit</button>
                        </div>
                    </div>

                    {{-- <div class="single_facilities col-sm-5 payment">
                        <div class="who_we_area">
                            <div class="subtittle">
                                <h2>MAKE PAYMENT</h2>
                            </div>

                            <div class="billingIns">
                                <input type="hidden" name="payemail" id="payemail" value="{{ $email }}">
                                <input type="text" name="invoiceNumber" id="invoiceNumber" class="form-control billinginput_box" placeholder="Type Invoice # *">
                            </div>
                            <button class="button_all" onclick="makePay()" id="pay_invoice">Submit</button>
                        </div>
                    </div> --}}
                    {{-- <div class="single_facilities col-sm-5 painting webdesign">
                        <img src="images/feature-man-4.jpg" alt="">
                    </div> --}}


                </div>



                <br>
                <div class="table table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Transaction Date</th>
                                <th>Description</th>
                                <th>Reference Code</th>
                                <th>Amount</th>
                                <th>Click to View</th>
                            </tr>
                        </thead>
                        <tbody id="statementRec">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <!-- End Our Services Area -->


@endsection
