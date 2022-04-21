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
            <li><a href="{{ route('invoice') }}" class="active">{{ $pages }}</a></li>
        </ol>
    </section>
    <!-- End Banner area -->

    <!-- Our Services Area -->
    <section class="our_services_tow">
        <div class="container">
            <div class="architecture_area services_pages">
                <div class="portfolio_item portfolio_2">
                   <div class="grid-sizer-2"></div>
                    <div class="single_facilities col-sm-10 payment">

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
                        <li class="tab-menu active"><a data-toggle="tab" href="#home">Payment History</a></li>
                        <li class="tab-menu"><a data-toggle="tab" href="#menu1">Option</a></li>
                        </ul>

                        <div class="tab-content">
                        <div id="home" class="tab-pane fade in active">
                            <div class="who_we_area">
                            <div class="subtittle">
                                <h2>Payment History</h2>
                            </div>

                            <div class="table table-responsive">
                                <input type="search" name="search" id="search_field" class="form-control" placeholder="Search by city, country...">
                                <br>
                                <table class="table table-striped table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <td>#</td>
                                        <td>Transaction No.</td>
                                        <td>Invoice No.</td>
                                        <td>Amount Paid</td>
                                        <td>Date Paid</td>
                                        <td style="text-align: center">Action</td>
                                    </tr>
                                </thead>
                                <tbody id="myTable">
                                    @if (count($payhistory) > 0)

                                    <?php $i = 1;?>
                                    @foreach ($payhistory as $item)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $item->transactionid }}</td>
                                            <td>{{ $item->invoice_no }}</td>
                                            <td>{{ $item->amount }}</td>
                                            <td>{{ date('d/M/Y', strtotime($item->created_at)) }}</td>
                                            <td align="center">
                                                <a href="{{ route('Myreceipt', $item->invoice_no) }}" type="button" class="btn btn-primary" target="_blank">View receipt</a>
                                            </td>
                                        </tr>
                                    @endforeach

                                    @else
                                        <tr>
                                            <td colspan="7" align="center">No record available yet</td>
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
                                    <option value="tenant_main">Rental Property Management Dashboard</option>
                                    <option value="create">Create Maintenance Requests</option>
                                    <option value="submitted">View Submittted Maintenance Requests</option>
                                    <option value="open">View Open Maintenance Requests</option>
                                    <option value="progress">View Maintenance Requests In-Progress</option>
                                    <option value="close">View Closed/Completed Maintenance Requests</option>
                                    <option value="cancel">View Canceled Maintenance Requests</option>
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
