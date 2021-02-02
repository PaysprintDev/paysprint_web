@extends('layouts.app')

@section('title', 'Invoice')


@show
<?php use \App\Http\Controllers\ClientInfo; ?>

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
                            <li class="tab-menu active"><a data-toggle="tab" href="#home">Maintenance Request</a></li>
                            <li class="tab-menu"><a data-toggle="tab" href="#menu1">Options</a></li>
                        </ul>

                        
                        <div class="tab-content">

                        <div id="home" class="tab-pane fade in active">
                        <div class="who_we_area">
                            <div class="subtittle">
                                <h2>Maintenance Request</h2>
                            </div>

                            <div class="table table-responsive">
                            <table class="table table-striped table-hover table-bordered">

                                <tbody>
                                    @if (count($maintdetail) > 0)
                                    <tr>
                                        <td>Maintenance Request #:</td>
                                        <td>{{ $maintdetail[0]->post_id }}</td>
                                    </tr>

                                    <tr>
                                        <td>Tenant Unit and Address:</td>
                                        <td>{{ $maintdetail[0]->unit }}</td>
                                    </tr>

                                    <tr>
                                        <td>Tenant Name:</td>
                                        <td>{{ $maintdetail[0]->tenant_name }}</td>
                                    </tr>

                                    <tr>
                                        <td>Tenant Phone Number:</td>
                                        <td>{{ $maintdetail[0]->phone_number }}</td>
                                    </tr>

                                    <tr>
                                        <td>Status:</td>
                                        <td>{{ $maintdetail[0]->status }}</td>
                                    </tr>

                                    <tr>
                                        <td>Priority:</td>
                                        <td>{{ $maintdetail[0]->priority }}</td>
                                    </tr>

                                    <tr>
                                        <td>Is the problem in the unit:</td>
                                        <td>{{ $maintdetail[0]->problem_in_unit }}</td>
                                    </tr>

                                    <tr>
                                        <td>Permission granted to enter unit alone:</td>
                                        <td>{{ $maintdetail[0]->problem_in_unit }}</td>
                                    </tr>


                                    <tr>
                                        <td>What do you want done?:</td>
                                        <td>{{ $maintdetail[0]->subject }}</td>
                                    </tr>

                                    <tr>
                                        <td>Full description of what you want done:</td>
                                        <td>{!! $maintdetail[0]->details !!}</td>
                                    </tr>

                                    <tr>
                                        <td>Additional Info:</td>
                                        <td>{!! $maintdetail[0]->additional_info !!}</td>
                                    </tr>

                                    <tr>
                                        <td>Attachment:</td>
                                        <td>
                                            @if ($maintdetail[0]->add_file != "noImage.png")

                                            @php
                                                $file = explode(",", $maintdetail[0]->add_file)
                                            @endphp
                                            <ul>

                                                @foreach ($file as $files)
                                                    @if ($files != "")
                                                        <li style="display: inline-flex; list-style: none; border-radius: 1px solid grey; background: #ffffff; border-radius: 10px; margin-right: 5px;">
                                                            <a href="{{ asset('maintenancefile')."/".$files }}" title="{{ $files }}" target="_blank"><img src="{{ asset('maintenancefile')."/".$files }}" alt="{{ $files }}" style="width: 100px; height: 100px;"></a>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>

                                            @else
                                                No file attached
                                            @endif
                                        </td>
                                    </tr>


                                    @else
                                        <tr>
                                            <td align="center">No open maintenance request</td>
                                        </tr>
                                    @endif

                                </tbody>
                            </table>



                            <a type="button" href="/rentalmanagement/admin/maintenance/assignconsultant/{{ $maintdetail[0]->post_id }}" class="btn btn-primary">Assign Service Provider</a>


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

                        <br>
                        <br>
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
