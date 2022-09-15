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
                            <li class="tab-menu active"><a data-toggle="tab" href="#home">Assign Service Provider</a></li>
                            <li class="tab-menu"><a data-toggle="tab" href="#menu1">Options</a></li>
                        </ul>


                        <div class="tab-content">

                            <div id="home" class="tab-pane fade in active">
                                <br>
                                <div class="who_we_area">
                                    <div class="subtittle">
                                        <h2>Assign Service Provider</h2>
                                    </div>

                                    <form method="POST" action="{{ route('assignconsultant') }}">

                                    @csrf
                                    <div class="billingIns">
                                        <input type="hidden" name="post_id" id="post_id" value="{{ $data['maintenance'][0]->post_id }}">
                                        <input type="hidden" name="tenant_email" id="tenant_email" value="{{ $data['maintenance'][0]->tenant_email }}">
                                        <input type="hidden" name="owner_email" id="owner_email" value="{{ session('email') }}">

                                        <label for="maintenance_status">Current Maintenace Status </label>
                                         <input type="text" name="maintenance_status" id="maintenance_status" class="form-control billinginput_box" value="{{ $data['maintenance'][0]->status }}" readonly>
                                    </div>

                                    <div class="billingIns">
                                        <label for="maintenance_status_update">Change Maintenace Status <span class="importantfield">*</span></label>
                                        <select name="maintenance_status_update" id="maintenance_status_update" class="form-control billinginput_box" required>
                                            <option value="">Select an option</option>
                                            <option value="{{ $data['maintenance'][0]->status }}" selected>{{ $data['maintenance'][0]->status }}</option>
                                            <option value="open">Open</option>
                                            <option value="progress">In Progress</option>
                                            <option value="close">Close</option>
                                            <option value="cancel">Cancel</option>
                                        </select>
                                    </div>




                                    <div class="billingIns">


                                        <div class="alert alert-info">
                                            <ul>
                                                <li style="font-weight: bold;">What you want done: <img src="https://img.icons8.com/emoji/20/000000/hammer-and-wrench.png"/> {{ $data['maintenance'][0]->subject }}</li>
                                                <li style="font-weight: bold;">Tenant Name: <img src="https://img.icons8.com/cotton/20/000000/user-male--v1.png"/> {{ $data['maintenance'][0]->tenant_name }}</li>
                                                <li style="font-weight: bold;">Unit & Address: <img src="https://img.icons8.com/fluent/20/000000/place-marker.png"/> {{ $data['maintenance'][0]->unit }}</li>
                                                <li style="font-weight: bold;">Phone Number: <img src="https://img.icons8.com/emoji/20/000000/mobile-phone.png"/> {{ $data['maintenance'][0]->phone_number }}</li>
                                                {{--  <li style="font-weight: bold;">User description: <img src="https://img.icons8.com/color/20/000000/topic--v1.png"/> {{ $data['maintenance'][0]->details }}</li>  --}}
                                            </ul>
                                        </div>
                                    </div>




                                    <div class="billingIns">
                                        <label for="assign_consultant">Select Service Provider <span class="importantfield">*</span></label>
                                        <select name="assign_consultant" id="assign_consultant" class="form-control billinginput_box" required>

                                            @if (count($data['consult']) > 0)

                                            <option value="">Select Service Provider</option>
                                                @foreach ($data['consult'] as $consultant)
                                                    <option value="{{ $consultant->id }}">{{ $consultant->consultant_name.' (E: '.$consultant->consultant_email.' - M: '.$consultant->consultant_telephone.')' }}</option>
                                                @endforeach
                                            @else
                                                <option value="">You have not created a service provider</option>
                                            @endif
                                        </select>

                                        @if (count($data['consult']) > 0)
                                        {{--  Do nothing  --}}
                                        @else
                                            <a href="{{ route('consultant') }}" style="color:navy; font-weight: bold; text-decoration: underline" target="_blank">Click here to create service provider</a>
                                        @endif

                                    </div>

                                    <div class="billingIns">
                                        <label for="consultant_phone">Detailed Note <span class="importantfield">*</span></label>
                                        <textarea name="response_note" id="response_note" cols="30" rows="10" class="form-control" required></textarea>
                                    </div>

                                    <div class="billingIns">
                                        <label for="consultant_deadline">Deadline Date <span class="importantfield">*</span></label>
                                        <input type="date" name="maintenance_deadline" id="maintenance_deadline" class="form-control billinginput_box">
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-block">Proceed</button>

                                    <br>
                                    <br>
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
                                            <option value="admin_menu">Rental Property Management Dashboard</option>
                                            <option value="create_building">Create Building</option>
                                            <option value="create_staff">Create Service Provider</option>
                                            <option value="view_building">View Building</option>
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
