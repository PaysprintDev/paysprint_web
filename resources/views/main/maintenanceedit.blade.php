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
                        <li class="tab-menu active"><a data-toggle="tab" href="#home">Update Request</a></li>
                        <li class="tab-menu"><a data-toggle="tab" href="#menu1">Options</a></li>
                        </ul>

                        <div class="tab-content">
                        <div id="home" class="tab-pane fade in active">
                            <div class="who_we_area">
                            <div class="subtittle">
                                <h2>Update Request</h2>
                            </div>

                            <form method="POST" action="{{ route('updatemaintenance') }}" enctype="multipart/form-data">

                            @csrf
                            <div class="billingIns">
                                <input type="hidden" name="post_id" id="post_id" value="{{ $maintdetail[0]->post_id }}">
                                <input type="hidden" name="unit" id="unit" value="{{ $maintdetail[0]->unit }}">
                                <input type="hidden" name="ten_name" id="ten_name" value="{{ $name }}">
                                <input type="hidden" name="ten_email" id="ten_email" value="{{ $email }}">
                                <label for="property_owner">Select Property Owner <span class="importantfield">*</span></label>

                                @if($busInfo = \App\ClientInfo::where('user_id', $maintdetail[0]->owner_id)->get())

                                    @if (count($busInfo) > 0)
                                        <select name="property_owner" class="form-control billinginput_box" id="property_owner" required>
                                                <option value="{{ $busInfo[0]->user_id }}">{{ $busInfo[0]->firstname.' '.$busInfo[0]->lastname.' - ('.$busInfo[0]->address.')' }}</option>

                                        </select>
                                    @else
                                        <select name="property_owner" class="form-control billinginput_box" id="property_owner" required>
                                            @if (count($clientInfo) > 0)
                                            <option value="">Select Property Owner</option>
                                            @foreach ($clientInfo as $orgs)
                                                <option value="{{ $orgs->user_id }}">{{ $orgs->firstname.' '.$orgs->lastname.' - ('.$orgs->address.')' }}</option>
                                            @endforeach

                                            @else
                                                <option value="">No available organization</option>
                                            @endif


                                        </select>
                                    @endif

                                @endif

                            </div>


                            <div class="billingIns">
                                <label for="phone_number">Tenant Phone Number <span class="importantfield">*</span></label>
                                <input type="text" name="phone_number" id="phone_number" value="{{ $maintdetail[0]->phone_number }}" class="form-control billinginput_box" placeholder="Phone Number*" required>
                            </div>

                            <div class="billingIns">
                                <label for="unit_id">Tenant Unit and Address <span class="importantfield">*</span></label>
                                <input type="text" name="unit_id" id="unit_id" class="form-control billinginput_box" value="{{ $maintdetail[0]->unit }}"  placeholder="Tenant Unit and Address*" required>
                            </div>

                            <div class="billingIns">
                                <label for="subject">What do you want done? <span class="importantfield">*</span></label>
                                
                                <select class="form-control billinginput_box" name="subject" id="subject" required>
                                    <option value="">Unit Maintenance</option>
                                    <option value="{{ $maintdetail[0]->subject }}" selected>{{ $maintdetail[0]->subject }}</option>
                                    <option value="Unit Maintenance---Appliance - Dishwasher">Unit Maintenance---Appliance - Dishwasher</option><option value="Unit Maintenance---Appliance - Dryer">Unit Maintenance---Appliance - Dryer</option><option value="Unit Maintenance---Appliance - refrigerator">Unit Maintenance---Appliance - refrigerator</option><option value="Unit Maintenance---Appliance - Stove">Unit Maintenance---Appliance - Stove</option><option value="Unit Maintenance---Appliance - Washer">Unit Maintenance---Appliance - Washer</option><option value="Unit Maintenance---Doors">Unit Maintenance---Doors</option><option value="Unit Maintenance---Drywall">Unit Maintenance---Drywall</option><option value="Unit Maintenance---Electrical">Unit Maintenance---Electrical</option><option value="Unit Maintenance---Flooring">Unit Maintenance---Flooring</option><option value="Unit Maintenance---Heating">Unit Maintenance---Heating</option><option value="Unit Maintenance---Other">Unit Maintenance---Other</option><option value="Unit Maintenance---Painting">Unit Maintenance---Painting</option><option value="Unit Maintenance---Paster/Drywall">Unit Maintenance---Paster/Drywall</option><option value="Unit Maintenance---Pest Control">Unit Maintenance---Pest Control</option><option value="Unit Maintenance---Plumbing">Unit Maintenance---Plumbing</option><option value="Unit Maintenance---Windows">Unit Maintenance---Windows</option>
                                </select>

                            </div>


                            <div class="billingIns">
                                <label for="problem_in_unit">Is the problem in the unit? <span class="importantfield">*</span></label>
                                <select class="form-control billinginput_box" id="problem_in_unit" name="problem_in_unit" required>
                                    <option value="">Select an option</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>





                            <div class="billingIns">
                                <label for="details">Full description of what you want done <span class="importantfield">*</span></label>
                                <textarea class="form-control" id="details" name="details" rows="4" cols="50" required>{{ $maintdetail[0]->details }}</textarea>
                            </div>

                            <div class="billingIns">
                                <label for="additional_info">Additional information: (ie.pets, special entrance instructions etc)</label>
                                <textarea class="form-control" id="additional_info" name="additional_info" rows="4" cols="50">{{ $maintdetail[0]->additional_info }}</textarea>
                            </div>

                            <div class="if_yes disp-0">
                                <label for="describe_event">Describe the request to be fixed <span class="importantfield">*</span></label>
                                <textarea class="form-control" id="describe_event" name="describe_event" rows="4" cols="50">{{ $maintdetail[0]->describe_event }}</textarea>
                                <span style="font-weight: bold; color: red;"><input type="checkbox" name="authorize" id="authorize"> I authorize entry to my unit in my absence in order to attend to this request: (If you dont authourise entry to the unit, the request would be put on hold pending the authourisation)</span>
                            </div>

                            <div class="if_no disp-0">
                                <span style="font-weight: bold; color: red;">There may be a delay in fixing the problem</span>
                            </div>

                            <hr>

                            <div class="billingIns">
                                <label for="priority">Priority <span class="importantfield">*</span></label>
                                <select class="form-control billinginput_box" id="priority" name="priority" required>
                                    <option value="">Select Priority</option>
                                    <option value="High">High</option>
                                    <option value="Medium">Medium</option>
                                    <option value="Low">Low</option>
                                </select>
                            </div>


                            <div class="billingIns">
                                <label for="add_file">Add: JPEG Images (up to 10 images)</label>
                                <input type="file" name="add_file[]" id="add_file" class="form-control billinginput_box_input" multiple="">
                                <small style="color: red; font-weight: bold;">Hold ctrl + click to select multiple</small>
                            </div>

                            <button type="submit" id="invoice_check" class="btn btn-primary btn-block">Update Request</button>


                            <br>
                            <br>
                            <br>
                            <br>

                            </form>


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
