@extends('layouts.app')

@section('content')


    <!-- Banner area -->
    <section class="banner_area" data-stellar-background-ratio="0.5">
        <h2>{{ $pages }}</h2>
        <ol class="breadcrumb">
            <li><a href="{{ route('home') }}">Home</a></li>
            <li><a href="{{ route('rentalmanagement') }}" class="active">{{ $pages }}</a></li>
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
                        <i class="fa fa-home" aria-hidden="true"></i>
                        <a href="#">MAINTENANCE REQUEST</a>

                        <center><a href="{{ route('maintenance', 'id='.Request::get('id')) }}" class="button_all" style="background-color: #f8b81d !important; padding-bottom: 15px; color: #fff !important; border-radius: 5px; margin-top: 5px; cursor: pointer;">Proceed</a></center>
                   </div>
                </div>


                <div class="col-md-4 col-sm-6 construction">
                   <div class="cns-img">
                        <img src="https://johnisshak.com/wps/rest/57339/post/6349629/image.jpg" alt="">
                   </div>
                   <div class="cns-content">
                        <i class="fa fa-bolt" aria-hidden="true"></i>
                        <a href="{{ route('amenities') }}">FACILITY / AMENITIES</a>

                        <center><a href="{{ route('amenities', 'id='.Request::get('id')) }}" class="button_all" style="background-color: #f8b81d !important; padding-bottom: 15px; color: #fff !important; border-radius: 5px; margin-top: 5px;">Proceed</a></center>
                   </div>
                </div>
                <div class="col-md-4 col-sm-6 construction">
                   <div class="cns-img">
                        <img src="https://cdn.vox-cdn.com/thumbor/Z8KrY_G2RDPNiUmYqiNJId8eUqg=/0x0:1000x675/1200x800/filters:focal(420x258:580x418)/cdn.vox-cdn.com/uploads/chorus_image/image/60099277/Untitled.0.jpg" alt="">
                   </div>
                   <div class="cns-content">
                        <i class="fa fa-file" aria-hidden="true"></i>
                        {{-- <a href="{{ route('messages') }}">MESSAGES</a> --}}
                        <a onclick="comingSoon()" style="cursor: pointer">MESSAGES</a>

                        {{-- <center><a href="{{ route('messages') }}" class="button_all" style="background-color: #f8b81d !important; padding-bottom: 15px; color: #fff !important; border-radius: 5px; margin-top: 5px;">Proceed</a></center> --}}
                        <center><a onclick="comingSoon()" class="button_all" style="background-color: #f8b81d !important; padding-bottom: 15px; color: #fff !important; border-radius: 5px; margin-top: 5px; cursor: pointer">Proceed</a></center>
                   </div>
                </div>

            </div>


            <div class="row construction_iner">

                <div class="col-md-4 col-sm-6 construction">
                   <div class="cns-img">
                        <img src="https://www.bankinghub.eu/wp-content/uploads/sites/2/2020/03/Payments%E2%80%94an-industry-undergoing-radical-change.jpg" alt="">
                   </div>
                   <div class="cns-content">
                        <i class="fa fa-calendar" aria-hidden="true"></i>
                        <a href="{{ route('paymenthistory', 'id='.Request::get('id')) }}">PAYMENT HISTORY</a>


                        <center><a href="{{ route('paymenthistory', 'id='.Request::get('id')) }}" class="button_all" style="background-color: #f8b81d !important; padding-bottom: 15px; color: #fff !important; border-radius: 5px; margin-top: 5px;">Proceed</a></center>
                   </div>
                </div>

                <div class="col-md-4 col-sm-6 construction">
                   <div class="cns-img">
                        <img src="https://www.fujixerox.com.vn/-/media/0,-d-,-Global-Assets/Solutions-and-Services/Security/Document-Audit-Trail_web.jpg?h=614&w=932&la=en&hash=64E1FBE5E13B0BAA2A067030184B87CC0B2F1D3F" alt="">
                   </div>
                   <div class="cns-content">
                        <i class="fa fa-bolt" aria-hidden="true"></i>
                        <a href="{{ route('documents') }}">DOCUMENTS</a>
                        {{-- <a onclick="comingSoon()" style="cursor: pointer">DOCUMENTS</a> --}}


                        <center><a href="{{ route('documents', 'id='.Request::get('id')) }}" class="button_all" style="background-color: #f8b81d !important; padding-bottom: 15px; color: #fff !important; border-radius: 5px; margin-top: 5px;">Proceed</a></center>
                        {{-- <center><a onclick="comingSoon()" class="button_all" style="background-color: #f8b81d !important; padding-bottom: 15px; color: #fff !important; border-radius: 5px; margin-top: 5px; cursor: pointer;">Proceed</a></center> --}}

                   </div>
                </div>
                
                <div class="col-md-4 col-sm-6 construction disp-0">
                   <div class="cns-img">
                        <img src="https://www.gruberlaw-nj.com/wp-content/uploads/2017/10/family-lawyer-writing-at-desk.jpg" alt="">
                   </div>
                   <div class="cns-content">
                        <i class="fa fa-file" aria-hidden="true"></i>
                        {{-- <a href="{{ route('otherservices') }}">OTHER SERVICES</a> --}}
                        <a onclick="comingSoon()" style="cursor: pointer">OTHER SERVICES</a>

                        {{-- <center><a href="{{ route('otherservices') }}" class="button_all" style="background-color: #f8b81d !important; padding-bottom: 15px; color: #fff !important; border-radius: 5px; margin-top: 5px;">Proceed</a></center> --}}
                        <center><a onclick="comingSoon()" class="button_all" style="background-color: #f8b81d !important; padding-bottom: 15px; color: #fff !important; border-radius: 5px; margin-top: 5px; cursor: pointer;">Proceed</a></center>
                   </div>
                </div>

            </div>


        </div>
    </section>
    <!-- End What ew offer Area -->

@endsection
