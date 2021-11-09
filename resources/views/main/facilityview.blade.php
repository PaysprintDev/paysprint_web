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
                        <li class="tab-menu active"><a data-toggle="tab" href="#home">Facility / Amenity Details</a></li>
                        <li class="tab-menu"><a data-toggle="tab" href="#menu1">Options</a></li>
                        </ul>


                        <div class="tab-content">
                            <div id="home" class="tab-pane fade in active">
                                <br>
                                <div class="who_we_area">
                            <div class="subtittle">
                                <h2>Facility / Amenity Details</h2>
                            </div>

                            <div class="table table-responsive">

                               

                                <a type="button" href="{{ route('makeabooking', $data['currentfacility']) }}" class="btn btn-primary">Make a Booking</a>

                                <br><br>
                            <table class="table table-striped table-hover table-bordered">

                                <tbody>
                                    @if (count($facilityinfo) > 0)

                                    <tr>
                                        <td colspan="2" align="center" style="font-weight: bold;">OWNER'S INFORMATION</td>
                                    </tr>

                                    <tr>
                                        <td>Fullname:</td>
                                        <td>{{ $facilityinfo[0]->owner_name }}</td>
                                    </tr>

                                    <tr>
                                        <td>Phone Number:</td>
                                        <td>{{ $facilityinfo[0]->owner_phone }}</td>
                                    </tr>

                                    <tr>
                                        <td>Email Address:</td>
                                        <td>{{ $facilityinfo[0]->owner_email }}</td>
                                    </tr>

                                    <tr>
                                        <td>Street Number:</td>
                                        <td>{{ $facilityinfo[0]->owner_street_number }}</td>
                                    </tr>

                                    <tr>
                                        <td>Street Name:</td>
                                        <td>{{ $facilityinfo[0]->owner_street_name }}</td>
                                    </tr>

                                    <tr>
                                        <td>City:</td>
                                        <td>{{ $facilityinfo[0]->owner_city }}</td>
                                    </tr>

                                    <tr>
                                        <td>Postal / Zip Code:</td>
                                        <td>{{ $facilityinfo[0]->owner_zipcode }}</td>
                                    </tr>

                                    <tr>
                                        <td>State / Province:</td>
                                        <td>{{ $facilityinfo[0]->owner_state }}</td>
                                    </tr>

                                    <tr>
                                        <td>Country:</td>
                                        <td>{{ $facilityinfo[0]->owner_country }}</td>
                                    </tr>


                                    <tr>
                                        <td colspan="2" align="center" style="font-weight: bold;">AGENT'S INFORMATION</td>
                                    </tr>

                                    <tr>
                                        <td>Fullname:</td>
                                        <td>{{ $facilityinfo[0]->agent_name }}</td>
                                    </tr>

                                    <tr>
                                        <td>Phone Number:</td>
                                        <td>{{ $facilityinfo[0]->agent_phone }}</td>
                                    </tr>

                                    <tr>
                                        <td>Email Address:</td>
                                        <td>{{ $facilityinfo[0]->agent_email }}</td>
                                    </tr>

                                    <tr>
                                        <td>Street Number:</td>
                                        <td>{{ $facilityinfo[0]->agent_street_number }}</td>
                                    </tr>

                                    <tr>
                                        <td>Street Name:</td>
                                        <td>{{ $facilityinfo[0]->agent_street_name }}</td>
                                    </tr>

                                    <tr>
                                        <td>City:</td>
                                        <td>{{ $facilityinfo[0]->agent_city }}</td>
                                    </tr>

                                    <tr>
                                        <td>Postal / Zip Code:</td>
                                        <td>{{ $facilityinfo[0]->agent_zipcode }}</td>
                                    </tr>

                                    <tr>
                                        <td>State / Province:</td>
                                        <td>{{ $facilityinfo[0]->agent_state }}</td>
                                    </tr>

                                    <tr>
                                        <td>Country:</td>
                                        <td>{{ $facilityinfo[0]->agent_country }}</td>
                                    </tr>


                                    <tr>
                                        <td colspan="2" align="center" style="font-weight: bold;">FACILITY LOCATION</td>
                                    </tr>

                                    <tr>
                                        <td>Street Number:</td>
                                        <td>{{ $facilityinfo[0]->buildinglocation_street_number }}</td>
                                    </tr>

                                    <tr>
                                        <td>Street Name:</td>
                                        <td>{{ $facilityinfo[0]->buildinglocation_street_number }}</td>
                                    </tr>

                                    <tr>
                                        <td>City:</td>
                                        <td>{{ $facilityinfo[0]->buildinglocation_city }}</td>
                                    </tr>

                                    <tr>
                                        <td>Postal / Zip Code:</td>
                                        <td>{{ $facilityinfo[0]->buildinglocation_zipcode }}</td>
                                    </tr>

                                    <tr>
                                        <td>State / Province:</td>
                                        <td>{{ $facilityinfo[0]->buildinglocation_state }}</td>
                                    </tr>

                                    <tr>
                                        <td>Country:</td>
                                        <td>{{ $facilityinfo[0]->buildinglocation_country }}</td>
                                    </tr>

                                    <tr>
                                        <td colspan="2" align="center" style="font-weight: bold;">CONTACT INFORMATION</td>
                                    </tr>

                                    <tr>
                                        <td>Contact Name:</td>
                                        <td>{{ $facilityinfo[0]->buildinginformation_name }}</td>
                                    </tr>

                                    <tr>
                                        <td>Phone Number:</td>
                                        <td>{{ $facilityinfo[0]->buildinginformation_phone }}</td>
                                    </tr>

                                    <tr>
                                        <td colspan="2" align="center" style="font-weight: bold;">CATEGORY</td>
                                    </tr>

                                    <tr>
                                        <td>Facility Type:</td>
                                        <td>{{ $facilityinfo[0]->building_type }}</td>
                                    </tr>


                                    <tr>
                                        <td>Attachment:</td>
                                        <td>
                                            @if ($facilityinfo[0]->building_image != "noImage.png")

                                            @php
                                                $file = explode(",", $facilityinfo[0]->building_image)
                                            @endphp
                                            <ul>

                                                @foreach ($file as $files)
                                                    @if ($files != "")
                                                        <li style="display: inline-flex; list-style: none; border-radius: 1px solid grey; background: #ffffff; border-radius: 10px; margin-right: 5px;">
                                                            <a href="{{ asset('facility')."/".$files }}" title="{{ $files }}" target="_blank"><img src="{{ asset('facility')."/".$files }}" alt="{{ $files }}" style="width: 100px; height: 100px;"></a>
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
                                            <td align="center">No record found</td>
                                        </tr>
                                    @endif

                                </tbody>
                            </table>



                            <a type="button" href="#" class="btn btn-primary">Make a Booking</a>


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
