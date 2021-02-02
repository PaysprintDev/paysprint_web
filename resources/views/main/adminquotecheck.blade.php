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
                        <li class="tab-menu active"><a data-toggle="tab" href="#home">Maintenance Quotes</a></li>
                        <li class="tab-menu"><a data-toggle="tab" href="#menu1">Options</a></li>
                        </ul>

                        <div class="tab-content">
                        <div id="home" class="tab-pane fade in active">
                        <div class="who_we_area">

                            <div class="subtittle">
                                <h2>Maintenance Quotes</h2>
                            </div>

                            <div class="table table-responsive">
                                <input type="search" name="search" id="search_field" class="form-control" placeholder="Search by date, reference number, service, service provider...">
                                <br>
                            <table class="table table-striped table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <td>#</td>
                                        <td>Date</td>
                                        <td>Reference No.</td>
                                        <td>Service</td>
                                        <td>Description</td>
                                        <td>Price</td>
                                        <td>Service Provider</td>
                                        <td>Status</td>
                                        <td style="text-align: center">Action</td>
                                    </tr>
                                </thead>
                                <tbody id="myTable">
                                    @if (count($statuschecker) > 0)

                                    <?php $i = 1;?>
                                    @foreach ($statuschecker as $item)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ date('d/M/Y', strtotime($item->created_at)) }}</td>
                                            <td>{{ $item->maintenance_id }}</td>
                                            <td>{{ $item->maintenance_service }}</td>
                                            <td>{!! $item->maintenance_description !!}</td>
                                            <td>{{ $item->maintenance_price }}</td>
                                            <td><a href="mailto:{{ $item->service_provider }}" title="{{ $item->service_provider }}" target="_blank">{{ \Illuminate\Support\Str::limit($item->service_provider, 15, $end='...') }}</a></td>

                                            @if ($item->status == 2)

                                            <td style="font-weight: bold; color: red">
                                                NEGOTIATION
                                            </td>

                                            <td align="center">
                                                {{-- Accept = 1 --}}
                                                <button class="btn btn-primary" type="button" onclick="decision('accept', '{{ $item->maintenance_id }}')">ACCEPT <img src="https://res.cloudinary.com/pilstech/image/upload/v1603447174/grey_style_zyxc4p.gif" style="width: 20px; height:20px" alt="spinner" class="disp-0 accept_{{ $item->maintenance_id }}"></button>

                                                {{-- Reject = 3 --}}
                                                <button class="btn btn-danger" type="button" onclick="decision('reject', '{{ $item->maintenance_id }}')" >REJECT <img src="https://res.cloudinary.com/pilstech/image/upload/v1603447174/grey_style_zyxc4p.gif" style="width: 20px; height:20px" alt="spinner" class="disp-0 reject_{{ $item->maintenance_id }}"></button>
                                            </td>

                                            @elseif($item->status == 1)

                                            <td style="font-weight: bold; color: green">
                                                ACCEPTED
                                            </td>

                                            <td align="center">
                                                <button class="btn btn-primary" type="button" disabled>ACCEPTED</button>
                                            </td>


                                            @elseif($item->status == 5)

                                            <td style="font-weight: bold; color: navy">
                                                JOB DONE
                                            </td>

                                            <td align="center">
                                                <button class="btn btn-success" type="button" onclick="decision('acceptjobdone', '{{ $item->maintenance_id }}')">CONFIRM JOB DONE <img src="https://res.cloudinary.com/pilstech/image/upload/v1603447174/grey_style_zyxc4p.gif" style="width: 20px; height:20px" alt="spinner" class="disp-0 acceptjobdone_{{ $item->maintenance_id }}"></button>
                                            </td>
                                            

                                            @else

                                            <td style="font-weight: bold; color: darkorange">
                                                PENDING
                                            </td>

                                            <td align="center">
                                                {{-- Accept = 1 --}}
                                                <button class="btn btn-primary" type="button" onclick="decision('accept', '{{ $item->maintenance_id }}')">ACCEPT <img src="https://res.cloudinary.com/pilstech/image/upload/v1603447174/grey_style_zyxc4p.gif" style="width: 20px; height:20px" alt="spinner" class="disp-0 accept_{{ $item->maintenance_id }}"></button>

                                                {{-- Negotiate = 2 --}}
                                                <button class="btn btn-danger" type="button" onclick="location.href='/rentalmanagement/admin/viewquotes/negotiate/{{ $item->maintenance_id }}'">NEGOTIATE</button>

                                            </td>

                                            @endif

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
