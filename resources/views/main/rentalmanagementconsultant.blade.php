@extends('layouts.app')

@section('content')


    <!-- Banner area -->
    <section class="banner_area" data-stellar-background-ratio="0.5">
        <h2>{{ $pages }}</h2>
        <ol class="breadcrumb">
            <li><a href="{{ route('home') }}">Home</a></li>
            <li><a href="{{ route('rentalManagementConsultant') }}" class="active">{{ $pages }}</a></li>
        </ol>
    </section>
    <!-- End Banner area -->


        <!-- What ew offer Area -->
    <section class="what_we_area row">
        <div class="container">

            <div class="row construction_iner">

                <div class="col-md-4 col-sm-6 construction">
                   <div class="cns-img">
                        <img src="https://get-trained.org/application/files/1214/9699/4544/maintenance.jpg" alt="">
                   </div>
                   <div class="cns-content">
                        <i class="fa fa-file" aria-hidden="true"></i>
                        <a href="#">MAINTENANCE REQUEST</a>

                        <center><a href="{{ url('rentalmanagement/consultant/mymaintenance/'.$id) }}" class="button_all" style="background-color: #f8b81d !important; padding-bottom: 15px; color: #fff !important; border-radius: 5px; margin-top: 5px; cursor: pointer;">Proceed</a></center>
                   </div>
                </div>

                <div class="col-md-4 col-sm-6 construction">
                   <div class="cns-img">
                        <img src="https://cdn.vox-cdn.com/thumbor/Z8KrY_G2RDPNiUmYqiNJId8eUqg=/0x0:1000x675/1200x800/filters:focal(420x258:580x418)/cdn.vox-cdn.com/uploads/chorus_image/image/60099277/Untitled.0.jpg" alt="">
                   </div>
                   <div class="cns-content">
                        <i class="fa fa-file" aria-hidden="true"></i>
                        <a href="#">WORK ORDER</a>

                        <center><a href="{{ url('rentalmanagement/consultant/workorder?s=received') }}" class="button_all" style="background-color: #f8b81d !important; padding-bottom: 15px; color: #fff !important; border-radius: 5px; margin-top: 5px; cursor: pointer;">Proceed</a></center>
                   </div>
                </div>

            </div>


        </div>
    </section>
    <!-- End What ew offer Area -->

@endsection
