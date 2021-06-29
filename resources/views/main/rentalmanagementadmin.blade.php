@extends('layouts.app')

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


        <!-- What ew offer Area -->
    <section class="what_we_area row">
        <div class="container">

            <div class="row construction_iner">

                <div class="col-md-4 col-sm-6 construction">
                   <div class="cns-img">
                        <img src="https://johnisshak.com/wps/rest/57339/post/6349629/image.jpg" alt="">
                   </div>
                   <div class="cns-content">
                        <i class="fa fa-home" aria-hidden="true"></i>
                        <a href="#">CREATE PROPERTY LOCATION</a>

                        <center><a type="button" href="{{ route('facility') }}" class="button_all" style="background-color: #f8b81d !important; padding-bottom: 15px; color: #fff !important; border-radius: 5px; margin-top: 5px; cursor: pointer;">Proceed</a></center>
                   </div>
                </div>

                <div class="col-md-4 col-sm-6 construction">
                   <div class="cns-img">

                        <img src="https://get-trained.org/application/files/1214/9699/4544/maintenance.jpg" alt="">
                   </div>
                   <div class="cns-content">
                        <i class="fa fa-bolt" aria-hidden="true"></i>
                        <a href="#">MAINTENANCE REQUEST</a>

                        <center><a href="{{ url('rentalmanagement/admin/maintenance?s=submitted') }}" class="button_all" style="background-color: #f8b81d !important; padding-bottom: 15px; color: #fff !important; border-radius: 5px; margin-top: 5px; cursor: pointer;">Proceed</a></center>
                   </div>
                </div>
                <div class="col-md-4 col-sm-6 construction">
                   <div class="cns-img">
                        <img src="https://cdn.vox-cdn.com/thumbor/Z8KrY_G2RDPNiUmYqiNJId8eUqg=/0x0:1000x675/1200x800/filters:focal(420x258:580x418)/cdn.vox-cdn.com/uploads/chorus_image/image/60099277/Untitled.0.jpg" alt="">
                   </div>
                   <div class="cns-content">
                        <i class="fa fa-file" aria-hidden="true"></i>
                        <a href="#">WORK ORDER</a>

                        <center><a href="{{ route('adminworkorder') }}" class="button_all" style="background-color: #f8b81d !important; padding-bottom: 15px; color: #fff !important; border-radius: 5px; margin-top: 5px; cursor: pointer;">Proceed</a></center>
                   </div>
                </div>

            </div>


            <div class="row construction_iner disp-0">

                <div class="col-md-4 col-sm-6 construction">
                   <div class="cns-img">
                        <img src="https://www.bankinghub.eu/wp-content/uploads/sites/2/2020/03/Payments%E2%80%94an-industry-undergoing-radical-change.jpg" alt="">
                   </div>
                   <div class="cns-content">
                        <i class="fa fa-calendar" aria-hidden="true"></i>
                        <a onclick="comingSoon()" style="cursor: pointer">APP (COMING SOON)</a>


                        <center><a type="button" onclick="comingSoon()"class="button_all" style="background-color: #f8b81d !important; padding-bottom: 15px; color: #fff !important; border-radius: 5px; margin-top: 5px; cursor: pointer;">Details</a></center>
                   </div>
                </div>


            </div>


        </div>
    </section>
    <!-- End What ew offer Area -->

@endsection
