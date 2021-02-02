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
                        <li class="tab-menu active"><a data-toggle="tab" href="#home">Create Service Provider</a></li>
                        <li class="tab-menu"><a data-toggle="tab" href="#menu1">Options</a></li>
                        </ul>

                        <div class="tab-content">
                        <div id="home" class="tab-pane fade in active">
                            <div class="who_we_area">
                            <div class="subtittle">
                                <h2>Create Service Provider</h2>
                            </div>

                            <form method="POST" action="{{ route('saveconsultant') }}">

                            @csrf
                            <div class="billingIns">
                                <input type="hidden" name="owner_name" id="owner_name" value="{{ $name }}">
                                <input type="hidden" name="owner_email" id="owner_email" value="{{ $email }}">
                                <label for="consultant_name">Full Name <span class="importantfield">*</span></label>
                                 <input type="text" name="consultant_name" id="consultant_name" class="form-control billinginput_box" placeholder="Service Provider Name*" required>
                            </div>

                            <div class="billingIns">
                                <label for="consultant_email">Email <span class="importantfield">*</span></label>
                                <input type="text" name="consultant_email" id="consultant_email" class="form-control billinginput_box" placeholder="Service Provider Email*" required>
                            </div>

                            <div class="billingIns">
                                <label for="consultant_phone">Telephone <span class="importantfield">*</span></label>
                                <input type="text" name="consultant_phone" id="consultant_phone" class="form-control billinginput_box" placeholder="Service Provider Telephone*" required>
                            </div>


                            <div class="billingIns">
                                <label for="consultant_address">Address <span class="importantfield">*</span></label>
                                <input type="text" name="consultant_address" id="consultant_address" class="form-control billinginput_box" placeholder="Service Provider Address*" required>
                            </div>


                            <div class="billingIns">
                                <label for="consultant_specialization">Specialization <span class="importantfield">*</span></label>
                                <input type="text" name="consultant_specialization" id="consultant_specialization" class="form-control billinginput_box" placeholder="Service Provider Specialization*" required>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">Submit</button>

                            </form>



                        </div>
                        </div>
                        <div id="menu1" class="tab-pane fade">
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
