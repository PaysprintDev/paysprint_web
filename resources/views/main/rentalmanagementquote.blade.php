@extends('layouts.app')

@section('title', 'Invoice')

<?php use \App\Http\Controllers\User; ?>
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
.importantfield{
    font-weight: bold;
    color: red;
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
                    <div class="single_facilities col-sm-10 payment">

                        @if(session()->has('success'))
                            <div class="alert alert-success">
                                {{ session()->get('success') }}
                            </div>

                            @elseif(session()->has('error'))

                            <div class="alert alert-danger">
                                {{ session()->get('error') }}
                            </div>

                        @endif


                        <ul class="nav nav-tabs">
                    <li class="tab-menu active"><a data-toggle="tab" href="#home">Generate Quote</a></li>
                    <li class="tab-menu "><a data-toggle="tab" href="#menu1">Options</a></li>
                    </ul>

                    <div class="tab-content">
                    <div id="home" class="tab-pane fade in active">
                        <br>
                        <div class="who_we_area">
                            <div class="subtittle">
                                <h2>Generate Quote</h2>
                            </div>

                            <form method="POST" action="{{ route('generateQuote') }}" id="quote_form">

                            @csrf

                            <input type="hidden" name="post_id" id="post_id" value="{{ $maintdetail[0]->post_id }}">
                            <input type="hidden" name="consultant_name" id="consultant_name" value="{{ $name }}">
                            <input type="hidden" name="consultant_email" id="consultant_email" value="{{ $email }}">



                            @if($owner = \App\User::select('users.*', 'client_info.*')->join('client_info', 'users.ref_code', '=', 'client_info.user_id')->where('users.ref_code', $maintdetail[0]->owner_id)->get())

                            @if (count($owner) > 0)


                            <div class="billingIns">
                                <?php $a = explode(" ", $owner[0]->name);?>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="property_owner">Firstname <span class="importantfield">*</span></label>
                                        <input type="text" name="firstname" id="firstname" class="form-control billinginput_box" placeholder="Firstname*" value="{{ $a[0] }}" readonly required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="property_owner">Lastname <span class="importantfield">*</span></label>
                                        <input type="text" name="lastname" id="lastname" class="form-control billinginput_box" placeholder="Lastname*" value="{{ $a[1] }}" readonly required>
                                    </div>
                                </div>


                            </div>


                                <div class="billingIns">
                                    <label for="company">Company <span class="importantfield">*</span></label>
                                    <input type="text" name="company" id="company" class="form-control billinginput_box" placeholder="Company Name*" value="{{ $owner[0]->business_name }}" required>
                                </div>

                                <div class="billingIns">
                                    <div class="row">
                                        {{--  <div class="col-md-3">
                                            <label for="street_number">Street Number <span class="importantfield">*</span></label>
                                            <input type="text" name="street_number" id="street_number" class="form-control billinginput_box" placeholder="Street Number*" required>
                                        </div>  --}}
                                        <div class="col-md-12">
                                            <label for="address">Street Number & Name <span class="importantfield">*</span></label>
                                        <input type="text" name="address" id="address" class="form-control billinginput_box" placeholder="Street Name*" value="{{ $owner[0]->address }}" required>
                                        </div>
                                    </div>

                                </div>

                                <div class="billingIns">

                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="email_address">Email Address <span class="importantfield">*</span></label>
                                        <input type="text" name="email_address" id="email_address" class="form-control billinginput_box" placeholder="Email Address*" value="{{ $owner[0]->email }}" readonly required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="type_of_service">Type of Service <span class="importantfield">*</span></label>
                                        <select class="form-control billinginput_box" id="type_of_service" name="type_of_service" required>
                                            <option value="Rent">Rent</option>
                                            <option value="Property Tax">Property Tax</option>
                                            <option value="Utility Bills">Utility Bills</option>
                                            <option value="Traffic Ticket">Traffic Ticket</option>
                                            <option value="Tax Bills">Tax Bills</option>
                                            <option value="Others"> Others</option>
                                        </select>
                                    </div>
                                </div>


                            </div>

                            @endif



                            @endif







                            <div class="if_Others disp-0">
                                <label for="specify_type_of_service">Specify Service Type</label>
                                <input type="text" name="specify_type_of_service" id="specify_type_of_service" class="form-control billinginput_box" placeholder="Specify Service Type">
                            </div>

                            <hr>



                            <div class="billingIns">

                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="reference_number">Reference Number <span class="importantfield">*</span></label>
                                        <input type="text" name="reference_number" id="reference_number" class="form-control" value="{{ $maintdetail[0]->post_id }}" readonly required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="transaction_ref">Transaction Ref. <span class="importantfield">*</span></label>
                                        <input type="text" name="transaction_ref" id="transaction_ref" class="form-control" value="{{ mt_rand(000, 999)."".$maintdetail[0]->post_id }}" readonly required>
                                    </div>
                                </div>


                            </div>

                            <div class="billingIns">

                                <label for="description">Description <span class="importantfield">*</span></label>
                                <textarea class="form-control" id="description" name="description" rows="4" cols="50" required></textarea>


                            </div>

                            <div class="billingIns">
                                <label for="amount">Quote Amount <span class="importantfield">*</span></label>
                                <input type="number" name="amount" id="amount" class="form-control" placeholder="0.00" required>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">Submit Quote</button>

                            <br>
                    <br>


                            </form>



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
