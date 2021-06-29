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
                        <li class="tab-menu active"><a data-toggle="tab" href="#home">Create Building</a></li>
                        <li class="tab-menu"><a data-toggle="tab" href="#menu1">Options</a></li>
                        </ul>

                        <div class="tab-content">
                        <div id="home" class="tab-pane fade in active">
                        <div class="who_we_area"><br>
                            <div class="subtittle">
                                <h2>Create Property Location</h2>
                            </div>

                            <form method="POST" action="{{ route('create_facility') }}" enctype="multipart/form-data">

                            @csrf

                            <div class="billingIns">
                                <h3 style="font-weight: bold;">PaySprint Account Information </h3>
                            </div>
                            <hr>
                            <div class="billingIns">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="owner_name">Name <span class="importantfield">*</span></label>
                                        <input type="text" name="owner_name" id="owner_name" class="form-control billinginput_box" placeholder="Owner Name*" value="{{ $name }}" readonly required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="owner_phone">Telephone <span class="importantfield">*</span></label>
                                        <input type="text" name="owner_phone" id="owner_phone" class="form-control billinginput_box" placeholder="Telephone*" required>
                                    </div>
                                </div>

                            </div>

                            <div class="billingIns">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="owner_street_number">Street No. <span class="importantfield">*</span></label>
                                        <input type="text" name="owner_street_number" id="owner_street_number" class="form-control billinginput_box" placeholder="Street Number*" required>
                                    </div>
                                    <div class="col-md-8">
                                        <label for="owner_street_name">Street Name <span class="importantfield">*</span></label>
                                        <input type="text" name="owner_street_name" id="owner_street_name" class="form-control billinginput_box" placeholder="Street Name*" required>
                                    </div>
                                </div>

                            </div>

                            <div class="billingIns">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="owner_city">City <span class="importantfield">*</span></label>
                                        <input type="text" name="owner_city" id="owner_city" class="form-control billinginput_box" placeholder="City*" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="owner_zipcode">Postal/Zip Code <span class="importantfield">*</span></label>
                                        <input type="text" name="owner_zipcode" id="owner_zipcode" class="form-control billinginput_box" placeholder="Postal/Zip Code*" required>
                                    </div>
                                </div>

                            </div>

                            <div class="billingIns">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="owner_state">State <span class="importantfield">*</span></label>
                                        <input type="text" name="owner_state" id="owner_state" class="form-control billinginput_box" placeholder="State*" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="owner_country">Country <span class="importantfield">*</span></label>
                                        <input type="text" name="owner_country" id="owner_country" class="form-control billinginput_box" placeholder="Country*" required>
                                    </div>
                                </div>

                            </div>

                            <div class="billingIns">
                                <label for="owner_email">Email Address <span class="importantfield">*</span></label>
                                <input type="email" name="owner_email" id="owner_email" class="form-control billinginput_box" placeholder="Email Address*" value="{{ $email }}" readonly required>
                            </div>

                            <br>
                            <div class="billingIns">
                                <h3 style="font-weight: bold;">Property Manager </h3>
                            </div>
                            <hr>
                            <div class="billingIns">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="agent_name">Name <span class="importantfield">*</span></label>
                                        <input type="text" name="agent_name" id="agent_name" class="form-control billinginput_box" placeholder="Owner Name*" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="agent_phone">Telephone <span class="importantfield">*</span></label>
                                        <input type="text" name="agent_phone" id="agent_phone" class="form-control billinginput_box" placeholder="Telephone*" required>
                                    </div>
                                </div>

                            </div>

                            <div class="billingIns">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="agent_street_number">Street No. <span class="importantfield">*</span></label>
                                        <input type="text" name="agent_street_number" id="agent_street_number" class="form-control billinginput_box" placeholder="Street Number*" required>
                                    </div>
                                    <div class="col-md-8">
                                        <label for="agent_street_name">Street Name <span class="importantfield">*</span></label>
                                        <input type="text" name="agent_street_name" id="agent_street_name" class="form-control billinginput_box" placeholder="Street Name*" required>
                                    </div>
                                </div>

                            </div>

                            <div class="billingIns">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="agent_city">City <span class="importantfield">*</span></label>
                                        <input type="text" name="agent_city" id="agent_city" class="form-control billinginput_box" placeholder="City*" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="agent_zipcode">Postal/Zip Code <span class="importantfield">*</span></label>
                                        <input type="text" name="agent_zipcode" id="agent_zipcode" class="form-control billinginput_box" placeholder="Postal/Zip Code*" required>
                                    </div>
                                </div>

                            </div>

                            <div class="billingIns">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="agent_state">State <span class="importantfield">*</span></label>
                                        <input type="text" name="agent_state" id="agent_state" class="form-control billinginput_box" placeholder="State*" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="agent_country">Country <span class="importantfield">*</span></label>
                                        <input type="text" name="agent_country" id="agent_country" class="form-control billinginput_box" placeholder="Country*" required>
                                    </div>
                                </div>

                            </div>

                            <div class="billingIns">
                                <label for="agent_email">Email Address <span class="importantfield">*</span></label>
                                <input type="email" name="agent_email" id="agent_email" class="form-control billinginput_box" placeholder="Email Address*" required>
                            </div>


                            <br>
                            <div class="billingIns">
                                <h3 style="font-weight: bold;">Property Address </h3>
                            </div>
                            <hr>

                            <div class="billingIns">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="buildinglocation_street_number">Street No. <span class="importantfield">*</span></label>
                                        <input type="text" name="buildinglocation_street_number" id="buildinglocation_street_number" class="form-control billinginput_box" placeholder="Street Number*" required>
                                    </div>
                                    <div class="col-md-8">
                                        <label for="buildinglocation_street_name">Street Name <span class="importantfield">*</span></label>
                                        <input type="text" name="buildinglocation_street_name" id="buildinglocation_street_name" class="form-control billinginput_box" placeholder="Street Name*" required>
                                    </div>
                                </div>

                            </div>

                            <div class="billingIns">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="buildinglocation_city">City <span class="importantfield">*</span></label>
                                        <input type="text" name="buildinglocation_city" id="buildinglocation_city" class="form-control billinginput_box" placeholder="City*" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="buildinglocation_zipcode">Postal/Zip Code <span class="importantfield">*</span></label>
                                        <input type="text" name="buildinglocation_zipcode" id="buildinglocation_zipcode" class="form-control billinginput_box" placeholder="Postal/Zip Code*" required>
                                    </div>
                                </div>

                            </div>

                            <div class="billingIns">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="buildinglocation_state">State <span class="importantfield">*</span></label>
                                        <input type="text" name="buildinglocation_state" id="buildinglocation_state" class="form-control billinginput_box" placeholder="State*" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="buildinglocation_country">Country <span class="importantfield">*</span></label>
                                        <input type="text" name="buildinglocation_country" id="buildinglocation_country" class="form-control billinginput_box" placeholder="Country*" required>
                                    </div>
                                </div>

                            </div>


                            <br>
                            <div class="billingIns">
                                <h3 style="font-weight: bold;">Property Management Contact Information </h3>
                                <span style="font-weight: bold; color: red;">Contact information for building inspection</span>
                            </div>
                            <hr>

                            <div class="billingIns">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="buildinginformation_name">Name <span class="importantfield">*</span></label>
                                        <input type="text" name="buildinginformation_name" id="buildinginformation_name" class="form-control billinginput_box" placeholder="Contact Name*" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="buildinginformation_phone">Telephone <span class="importantfield">*</span></label>
                                        <input type="text" name="buildinginformation_phone" id="buildinginformation_phone" class="form-control billinginput_box" placeholder="Telephone*" required>
                                    </div>
                                </div>

                            </div>

                            <br>
                            <div class="billingIns">
                                <h3 style="font-weight: bold;">Property Description </h3>
                            </div>
                            <hr>

                            <div class="billingIns">
                                <label for="buildinginformation_name">Type of Building <span class="importantfield">*</span></label>
                                <select name="building_type" id="building_type" class="form-control billinginput_box" required>
                                    <option value="">Select an option</option>
                                    <option value="Residential">Residential</option>
                                    <option value="Detached">Detached</option>
                                    <option value="Semi-Detached">Semi-Detached</option>
                                    <option value="High Rise">High Rise</option>
                                    <option value="Multi-Level Car Parking">Multi-Level Car Parking</option>
                                    <option value="Industrial">Industrial</option>
                                    <option value="Storage">Storage</option>
                                </select>

                            </div>

                            <div class="billingIns">
                                <label for="building_image">Add: JPEG Images (up to 10 images) <span class="importantfield">*</span></label>
                                <input type="file" name="building_image[]" id="building_image" class="form-control billinginput_box_input" multiple="" required>
                                <small style="color: red; font-weight: bold;">Hold ctrl + click to select multiple</small>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">Submit</button>

                            </form>



                        </div>
                        </div>
                        <div id="menu1" class="tab-pane fade"> <br>
                            <div class="selector">
                            <div class="subtittle">
                                <h3>Please select an option below</h3>
                                <select name="perform_action" id="perform_action" class="form-control">
                                    <option value="">Select other options</option>
                                    <option value="admin_menu">Rental Property Management Dashboard</option>
                                    <option value="create_building">Create Facility/Amenities</option>
                                    <option value="create_staff">Create Service Provider</option>
                                    <option value="view_building">View Facility/Amenities</option>
                                    <option value="view_staff">View Service Provider</option>
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
