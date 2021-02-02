@extends('layouts.app')

@section('title', 'Invoice')

<?php use \App\Http\Controllers\MaintenanceRequest; ?>
<?php use \App\Http\Controllers\RentalMessage; ?>
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
                        <li class="tab-menu active"><a data-toggle="tab" href="#home">Received Maintenance</a></li>
                        <li class="tab-menu"><a data-toggle="tab" href="#menu1">Options</a></li>
                        </ul>

                        <div class="tab-content">
                        <div id="home" class="tab-pane fade in active">
                                                    <div class="who_we_area">
                            <div class="subtittle">
                                <h2>Received Maintenance</h2>
                            </div>

                        <div class="table table-responsive">
                            <input type="search" name="search" id="search_field" class="form-control" placeholder="Search by unit, deadline date, priority, status..."> <br>

                            <table class="table table-striped table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <td>#</td>
                                        <td>Unit</td>
                                        <td>Subject</td>
                                        <td>Details</td>
                                        <td>Priority</td>
                                        <td>Status</td>
                                        <td>Deadline date</td>
                                        <td style="text-align: center">Action</td>
                                    </tr>
                                </thead>
                                <tbody id="myTable">
                                    @if (count($maintdetail) > 0)

                                    <?php $i = 1;?>
                                    @foreach ($maintdetail as $item)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $item->unit }}</td>
                                            <td>{{ $item->subject }}</td>
                                            <td>{!! \Illuminate\Support\Str::limit($item->details, 50, $end='...') !!}</td>
                                            <td>{{ $item->priority }}</td>
                                            <td>{{ $item->status }}</td>

                                            @if($dateoff = \App\RentalMessage::where('post_id', $item->post_id)->get())

                                                @if (count($dateoff) > 0)
                                                    <td>{{ date('d/M/F', strtotime($dateoff[0]->maintenance_deadline)) }}</td>
                                                @else
                                                <td>-</td>

                                                @endif

                                            @endif

                                            <td align="center">
                                                <i class="fa fa-eye" style="color: navy; font-weight: bold; cursor: pointer;" title="view details" onclick="location.href='/rentalmanagement/consultant/maintenance/{{ $item->post_id }}'"></i>


                                            </td>


                                        </tr>
                                    @endforeach

                                    @else
                                        <tr>
                                            <td colspan="8" align="center">No record available for your request</td>
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
