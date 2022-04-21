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
                        <li class="tab-menu active"><a data-toggle="tab" href="#home">Negotiation Response</a></li>
                        <li class="tab-menu"><a data-toggle="tab" href="#menu1">Options</a></li>
                        </ul>

                        <div class="tab-content">
                        <div id="home" class="tab-pane fade in active">
                            <div class="who_we_area">
                            <div class="subtittle">
                                <h2>Negotiation Response</h2>
                            </div>

                            <form method="POST" action="{{ route('respondquote') }}">

                            @csrf
                            <input type="hidden" name="owner_name" id="owner_name" value="{{ $name }}">
                            <input type="hidden" name="owner_email" id="owner_email" value="{{ $email }}">
                            <input type="hidden" name="maintenance_id" id="maintenance_id" value="{{ $viewquotedetail[0]->maintenance_id }}">

                            <div class="billingIns">
                                <label for="negotiation_price">Quotable Price</label>
                                <input type="text" name="maintenance_price" id="maintenance_price" class="form-control billinginput_box" value="{{ $viewquotedetail[0]->maintenance_price }}" readonly>
                            </div>

                            <div class="billingIns">
                                <label for="negotiation_price">Negotiation Price <span class="importantfield">*</span></label>
                                <input type="number" name="negotiation_price" id="negotiation_price" class="form-control billinginput_box" value="{{ $viewquotedetail[0]->negotiation_price }}" readonly>
                            </div>

                            <button type="submit" class="btn btn-primary">ACCEPT</button> | <button class="btn btn-danger" type="button" onclick="decision('reject', '{{ $viewquotedetail[0]->maintenance_id }}')" >REJECT <img src="https://res.cloudinary.com/pilstech/image/upload/v1603447174/grey_style_zyxc4p.gif" style="width: 20px; height:20px" alt="spinner" class="disp-0 reject_{{ $viewquotedetail[0]->maintenance_id }}"></button>

                            </form>



                        </div>
                        </div>
                        <div id="menu1" class="tab-pane fade">
                            <div class="selector">
                            <div class="subtittle">
                                <h3>Please select an option below</h3>
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
