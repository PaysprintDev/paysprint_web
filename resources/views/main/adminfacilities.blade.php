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
                    <div class="single_facilities col-sm-12 payment">

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
                        <li class="tab-menu active"><a data-toggle="tab" href="#home">Facilities</a></li>
                        <li class="tab-menu"><a data-toggle="tab" href="#menu1">Options</a></li>
                        </ul>

                        <div class="tab-content">
                        <div id="home" class="tab-pane fade in active">
                            <div class="who_we_area">
                            <div class="subtittle">
                                <h2>Facilities</h2>
                            </div>
                            {!! session('msg')!!}
                            <div class="table table-responsive">
                            <input type="search" name="search" id="search_field" class="form-control" placeholder="Search by name, address, specialty, phone">
                                <br>
                            <table class="table table-striped table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <td>#</td>
                                        <td>Bulilding Type</td>
                                        <td>Bulilding Location</td>
                                        <td>Contact Person</td>
                                        <td>Phone Number</td>
                                        {{-- <td>Image</td> --}}
                                        <td style="text-align: center">Action</td>
                                    </tr>
                                </thead>
                                <tbody id="myTable">
                                    @if (count($data['facility']) > 0)

                                    <?php $i = 1;?>
                                    @foreach ($data['facility'] as $item)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $item->building_type }}</td>
                                            <td>{{ $item->buildinglocation_street_number.' '.$item->buildinglocation_street_name.' '.$item->buildinglocation_city }}</td>
                                            <td>{{ $item->buildinginformation_name }}</td>
                                            <td>{{ $item->buildinginformation_phone }}</td>
                                            {{-- <td>{{ $item->building_image }}</td> --}}
                                            <td align="center">
                                                <form action="{{ route('deletefacility') }}" method="Post" id="delete_consultant">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $item->id }}">
                                                </form>

                                                <i class="fa fa-edit" style="color: navy; font-weight: bold; cursor: pointer;" title="edit details" onclick="location.href='/rentalmanagement/admin/viewfacility/edit/{{$item->id}}'"></i>

                                                <i class="fa fa-trash" style="color: red; font-weight: bold; cursor: pointer;" title="delete request" onclick="makeDel('delete_consultant')"></i>

                                            </td>
                                        </tr>
                                    @endforeach

                                    @else
                                        <tr>
                                            <td colspan="6" align="center">No record available for your request</td>
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
