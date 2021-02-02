@extends('layouts.app')

@section('title', 'Invoice')


@show
<?php use \App\Http\Controllers\ClientInfo; ?>
<?php use \App\Http\Controllers\Consultant; ?>
<?php use \App\Http\Controllers\RentalQuote; ?>
<?php use \App\Http\Controllers\ImportExcel; ?>

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
                        <li class="tab-menu active"><a data-toggle="tab" href="#home">Assigned Maintenance Request</a></li>
                        <li class="tab-menu"><a data-toggle="tab" href="#menu1">Options</a></li>
                        </ul>

                        <div class="tab-content">
                        <div id="home" class="tab-pane fade in active">
                                                    <div class="who_we_area">
                            <div class="subtittle">
                                <h2>Assigned Maintenance Request</h2>
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
                                        <td>Unit:</td>
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
                                        <td>What you want done:</td>
                                        <td>{{ $maintdetail[0]->subject }}</td>
                                    </tr>

                                    <tr>
                                        <td>Details:</td>
                                        <td>{!! $maintdetail[0]->details !!}</td>
                                    </tr>

                                    <tr>
                                        <td>Additional Info:</td>
                                        <td>{!! $maintdetail[0]->additional_info !!}</td>
                                    </tr>

                                    @if($consultant = \App\Consultant::where('id', $maintdetail[0]->assigned_staff)->get())

                                    @if (count($consultant) > 0)

                                    <tr>
                                        <td>Assigned Service Provider:</td>
                                        <td>{!! "<b>Name:</b> ".$consultant[0]->consultant_name." <br> <b>Phone:</b> ".$consultant[0]->consultant_telephone."<br> <b>Address:</b> ".$consultant[0]->consultant_address." <br> <b>Specialization:</b> ".$consultant[0]->consultant_specialization !!}</td>
                                    </tr>

                                    @endif


                                    @endif


                                    @else
                                        <tr>
                                            <td align="center">No open maintenance request</td>
                                        </tr>
                                    @endif

                                </tbody>
                            </table>

                            @if (count($maintdetail) > 0)

                            <p>
                                We are committed to keeping your home well maintained and look forward to being of service in the future.
                            </p>

                            <p>
                                @if($busInfo = \App\ClientInfo::where('user_id', $maintdetail[0]->owner_id)->get())

                                    @if (count($busInfo) > 0)
                                        <strong>Property Owner: {{ $busInfo[0]->business_name }}</strong>
                                    @else
                                        <strong>Property Owner: PaySprint</strong>
                                    @endif

                                @endif
                            </p>

                            @if($quote = \App\RentalQuote::where('maintenance_id', $maintdetail[0]->post_id)->get())

                                @if (count($quote) > 0)

                                @if ($quote[0]->status == 2)

                                <p>
                                    <button type="submit" class="btn btn-primary" onclick="location.href='/rentalmanagement/consultant/negotiate/{{ $maintdetail[0]->post_id }}'">Negotiation</button> | <button type="button" class="btn btn-danger" onclick="goBack()">Go back</button>
                                </p>

                                @elseif($quote[0]->status == 1)


                                    @if ($payment = \App\ImportExcel::where('uploaded_by', $email)->where('payee_ref_no', $maintdetail[0]->post_id)->get())

                                        @if (count($payment) > 0)

                                            @if ($payment[0]->payment_status == 1)

                                                <p>
                                                    <form action="{{ route('completedworkorder') }}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="post_id" value="{{ $maintdetail[0]->post_id }}">
                                                        <button type="submit" class="btn btn-primary">Move to Work Order</button> | <button type="button" class="btn btn-danger" onclick="goBack()">Go back</button>
                                                    </form>

                                                </p>

                                                @elseif($payment[0]->payment_status == 0)

                                                <p>
                                                    <button type="submit" class="btn btn-primary" disabled style="cursor: not-allowed">Invoice sent, await response from client.</button> | <button type="button" class="btn btn-danger" onclick="goBack()">Go back</button>
                                                </p>

                                            

                                            @endif


                                        @else

                                        <p>
                                            <button type="submit" class="btn btn-success" onclick="location.href='/rentalmanagement/consultant/invoice/{{ $maintdetail[0]->post_id }}'">Prepare Invoice</button> | <button type="button" class="btn btn-danger" onclick="goBack()">Go back</button>
                                        </p>

                                            
                                            

                                        @endif


                                       

                                    @endif


                                
                                @elseif($quote[0]->status == 5)

                                <p>
                                    <button type="button" class="btn btn-primary" disabled style="cursor: not-allowed">Waiting to confirm job done</button> | <button type="button" class="btn btn-danger" onclick="goBack()">Go back</button>
                                </p>

                                @elseif($quote[0]->status == 4)

                                <p>
                                    <button type="submit" class="btn btn-primary" onclick="decisionmaker('jobdone', '{{ $quote[0]->maintenance_id }}')">Activate Job Done <img src="https://res.cloudinary.com/pilstech/image/upload/v1603447174/grey_style_zyxc4p.gif" style="width: 20px; height:20px" alt="spinner" class="disp-0 jobdone_{{ $quote[0]->maintenance_id }}"></button> | <button type="button" class="btn btn-danger" onclick="goBack()">Go back</button>
                                </p>




                                @else
                                <p>
                                    <button type="button" class="btn btn-primary" style="cursor: not-allowed" disabled>Await Response</button> | <button type="button" class="btn btn-danger" onclick="goBack()">Go back</button>
                                </p>

                                @endif


                                @else
                                <p>
                                    <button type="submit" class="btn btn-primary" onclick="location.href='/rentalmanagement/consultant/quote/{{ $maintdetail[0]->post_id }}'">Prepare Quote</button> | <button type="button" class="btn btn-danger" onclick="goBack()">Go back</button>
                                </p>
                                @endif

                            @endif



                            @endif




                        </div>

                        </div>
                        </div>
                        <div id="menu1" class="tab-pane fade">
                        <br>
                            <div class="selector">
                            <div class="subtittle">
                                <h3>View other options below</h3>
                                <select name="perform_action" id="perform_action" class="form-control">
                                    <option value="">Select other options</option>
                                    <option value="consultant_menu">Rental Property Management Dashboard</option>
                                    <option value="workorder_received">Received Work Order</option>
                                    <option value="workorder_completed">Completed Work Order</option>
                                    {{-- <option value="workorder_generate">Generate Invoice / Quotation</option> --}}
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
