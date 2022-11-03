@extends('layouts.newpage.app')

<style>
    .eclipse-slider img {
        width: 60px;
        height: 60px;
        object-fit: contain;
        margin-left: 3px;
        margin-bottom: 3px;
        padding: 10px;
        border-radius: 20px;
        background-color: rgb(213, 213, 213);
        cursor: pointer;
    }

    .topnav .search-container {
        float: right;
    }

    .topnav input[type=text] {
        padding: 6px;
        margin-top: 8px;
        font-size: 17px;
        border: 1px;
    }

    .topnav .search-container button {
        float: right;
        padding: 6px 10px;
        margin-top: 8px;
        margin-right: 16px;
        background: #ddd;
        font-size: 17px;
        border: 1px;
        cursor: pointer;
    }

    .topnav .search-container button:hover {
        background: #ffe29f;
    }

    @media screen and (max-width: 600px) {
        .topnav .search-container {
            float: none;
        }

        .topnav a,
        .topnav input[type=text],
        .topnav .search-container button {
            float: none;
            display: block;
            text-align: left;
            width: 100%;
            margin: 0;
            padding: 14px;
        }

        .topnav input[type=text] {
            border: 1px solid #ffe29f;
        }
    }
    .hero-imgs{
 top:-15.456rem;
}
</style>

@section('content')
<!-- Hero Area -->
<!-- Hero Area -->
<div class="bg-default-8 pb-15 pt-24 pt-lg-32 pb-lg-28" id="hero-area-animation" style="background: #f2f2f2 !important;">


    <div class="container" id="animation-area-1">
        {{-- <p style="background: aquamarine;padding: 10px;border-radius: 10px;font-size: 20px;font-weight: 700;"><marquee behavior="" direction="">You are at the right website, Paypinn.com is same as Paysprint.ca!!!</marquee></p> --}}

        <div class="row align-items-center justify-content-center">
            <div class="col-9 col-md-7 col-lg-5 offset-xl-1 align-self-sm-end order-lg-2">
                <div class="hero-imgs image-group-p12 position-relative mb-9 mb-sm-15 mb-lg-0" data-aos="fade-left" data-aos-duration="500" data-aos-once="true">
                    <img class="w-100" src="https://res.cloudinary.com/paysprint/image/upload/v1651130089/assets/paysprint_jpeg_black_bk_ft8qly_frobtx.jpg" alt="https://res.cloudinary.com/paysprint/image/upload/v1651130089/assets/paysprint_jpeg_black_bk_ft8qly_frobtx.jpg" style="border-radius: 100%">
                    <div class="image-bg-positioning">
                        <img src="{{ asset('newpage/image/telemedicine/png/hero-img-sub.png') }}" alt="hero-img-sub.png">
                    </div>
                </div>
                <div class=" hero-sm-card-1">
                    <div class="px-7 py-6 d-flex bg-white shadow-10 rounded-15 w-xs-75 w-lg-76 w-xl-68 hero-card-1-animation" id="an-item-1p1">
                        <p class="gr-text-11 mb-0 text-mirage-2">“I want to send money to my family and friends, but they
                            are not on PaySprint.”</p>
                        <div class="small-card-img ml-6">
                            <img src="https://img.icons8.com/bubbles/50/000000/night-man.png" alt="night-man.png" class="circle-42">
                        </div>
                    </div>

                </div>
                <div class="animation-item">
                    <div class="px-7 py-6 d-flex shadow-9 rounded-15 w-xs-80 w-xl-68 hero-sm-card-2 hero-card-2-animation" id="an-item-1p2" style="background-color: #bc8900 !important;">
                        <div class="small-card-img mr-6 text-white">
                            <img src="https://img.icons8.com/bubbles/50/000000/happy-woman.png" alt="happy-woman.png" class="circle-42">
                        </div>
                        <p class="gr-text-11 mb-0 text-white">“Don’t worry! With PaySprint, you can send money through
                            text message or email for Free!”</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-9 col-lg-7 col-xl-6 order-lg-1" data-aos="fade-right" data-aos-duration="500" data-aos-once="true">
                <div class="hero-content section-title text-center text-lg-left">
                    <h1 class="gr-text-2 font-weight-bold mb-8" style="font-size:60px">Safe and Secure <br class="">Way to Send and Receive Money from over 100 Countries at no cost.</h1>
                    <p class="gr-text-9 gr-text-color pr-md-7" style="font-size: 25px">Money Received Instantly, No hidden fees.</p>


                    <div class="hero-btns mt-11">

                        @guest
                        <a href="{{ route('login') }}" class="btn btn-warning with-icon gr-hover-y">Get Started<i class="icon icon-tail-right font-weight-bold"></i></a>
                        @endguest


                        @auth
                        <a href="{{ route('my account') }}" class="btn btn-warning with-icon gr-hover-y">Wallet
                            balance -
                            {{ Auth::user()->currencySymbol . '' . number_format(Auth::user()->wallet_balance, 4) }}<i class="icon icon-tail-right font-weight-bold"></i></a>
                        @endauth



                    </div>



                    <a data-fancybox href="https://youtu.be/txfp2Pzbzrg" class="video-link gr-text-color mt-8 gr-flex-y-center justify-content-center justify-content-lg-start">
                        <span class="mr-2  border border-black-dynamic">
                            <i class="icon icon-triangle-right-17-2 gr-text-14"></i>
                            {{-- <img src='{{asset('images/paysprint_logo/Video.png')}}' alt="icon" height="50px" width="60px"/> --}}
                        </span>
                        <span class="gr-text-12 font-weight-bold text-uppercase" style="font-size: 16px;">How PaySprint
                            works</span>
                    </a>

                    <p class="gr-text-9 gr-text-color pr-md-7 font-weight-bold">
                        <br>
                        <hr>
                    <h5 class="font-weight-bold">Secure Environment</h5>
                    <i class="fas fa-circle" style="font-size: 12px; color: #f64b4b;"></i> Identity Verification <i class="fas fa-circle" style="font-size: 12px; color: #f64b4b;"></i> Multi-level authentication
                    <i class="fas fa-circle" style="font-size: 12px; color: #f64b4b;"></i> Full Encryption
                    </p>


                </div>
            </div>
        </div>
    </div>
</div>
<!-- Brand section -->

<!-- currency converter -->
{{-- Box tab --}}
@include('include.newpage.currencyconversion')

{{-- End of tab box --}}

<!-- end of currency converter -->

<!-- unique features -->
<div class="content-section pt-13 pt-lg-12 pb-11 pb-lg-22 hover-tilt bg-default-6">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            {{-- <div class="col-sm-10 col-md-9 col-lg-6 col-xl-5 mb-n7 mb-lg-0">
                <div class="double-image-group position-relative" data-aos="fade-right" data-aos-duration="1000"
                    data-aos-once="true">
                    <img class="main-img w-100 w-lg-auto" src="newpage/image/telemedicine/png/content-3-img.png" alt="" />
                    <div class="gr-abs-img-custom-2 animation-tilt">
                        <img src="newpage/image/telemedicine/png/content3-img-sub.png" alt="" class="responsive-scaling">
                    </div>
                </div>
            </div> --}}
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 ">
                <div class="content-text pr-lg-7" data-aos="fade-left" data-aos-duration="1200" data-aos-once="true">
                    <h5 class="gr-text-4 mb-8">Unique Features</h5>
                    {{-- <p class="gr-text-9 mb-0">We've made telemedicine simple and easy for you. Create your
                        personal room and start practicing telemedicine today. </p> --}}
                    <div class="content-widget mt-8">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="single-widget d-flex align-items-center py-2">
                                    <div class="widget-icon text-primary mr-6 gr-text-8 d-flex align-items-center">
                                        <i class="icon icon-check-simple"></i>
                                    </div>
                                    <h5 class="w-title gr-text-8 mb-0">Unlimited Transactions.</h5>
                                </div>
                            </div>


                            @if ($data['country'] == 'Canada')
                            <div class="col-md-8">
                                <div class="single-widget d-flex align-items-center py-2">
                                    <div class="widget-icon text-primary mr-6 gr-text-8 d-flex align-items-center">
                                        <i class="icon icon-check-simple"></i>
                                    </div>
                                    <h5 class="w-title gr-text-8 mb-0">Add money to Wallet from Debit or Credit Cards, Interac(R) eTransfer or Electronic fund transfer.
                                    </h5>
                                </div>
                            </div>
                            @else
                            <div class="col-md-8">
                                <div class="single-widget d-flex align-items-center py-2">
                                    <div class="widget-icon text-primary mr-6 gr-text-8 d-flex align-items-center">
                                        <i class="icon icon-check-simple"></i>
                                    </div>
                                    <h5 class="w-title gr-text-8 mb-0">Add money to Wallet from Debit or Credit Cards.
                                    </h5>
                                </div>
                            </div>
                            @endif

                            <div class="col-md-8">
                                <div class="single-widget d-flex align-items-center py-2">
                                    <div class="widget-icon text-primary mr-6 gr-text-8 d-flex align-items-center">
                                        <i class="icon icon-check-simple"></i>
                                    </div>
                                    <h5 class="w-title gr-text-8 mb-0">Send money Locally and Abroad.</h5>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="single-widget d-flex align-items-center py-2">
                                    <div class="widget-icon text-primary mr-6 gr-text-8 d-flex align-items-center">
                                        <i class="icon icon-check-simple"></i>
                                    </div>
                                    <h5 class="w-title gr-text-8 mb-0">Pay Invoice at a click of button.</h5>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="single-widget d-flex align-items-center py-2">
                                    <div class="widget-icon text-primary mr-6 gr-text-8 d-flex align-items-center">
                                        <i class="icon icon-check-simple"></i>
                                    </div>
                                    <h5 class="w-title gr-text-8 mb-0">Safe and Secure- multi-level security
                                        authentications features.</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end of unique features -->

<!-- How paysprint works -->
<div class="feature-section pt-14 pt-lg-21 pb-7 bg-default-8">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-8">
                <div class="section-title text-left mb-13 mb-lg-21">
                    <h5 class="title gr-text-4 mb-6" style="text-align:left;">How does it work?</h5>
                    <p class="gr-text-9 mb-0" style="text-align:left;">We've made PaySprint simple and easy for you.</p>
                </div>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-lg-4 col-md-6 mb-11 mb-lg-19 px-xs-6 px-md-6 px-lg-0 px-xl-8" data-aos="fade-right" data-aos-duration="800" data-aos-once="true">
                <div class="feature-widget text-center">
                    <div class="widget-icon square-80 rounded-15 mx-auto mb-9 mb-lg-12 bg-blue shadow-blue">
                        <img src="newpage/image/svg/feature8-icon1.svg" alt="image/svg/feature8-icon1.svg">
                    </div>
                    <div class="widget-text">
                        <h3 class="title gr-text-6 mb-7">Get Started</h3>
                        <p class="gr-text-11 mb-0">Login/Sign Up for Free.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-11 mb-lg-19 px-xs-6 px-md-6 px-lg-0 px-xl-8" data-aos="fade-right" data-aos-duration="800" data-aos-delay="400" data-aos-once="true">
                <div class="feature-widget text-center">
                    <div class="widget-icon square-80 rounded-15 mx-auto mb-9 mb-lg-12 bg-green shadow-green">
                        {{-- <img src="newpage/image/svg/feature8-icon2.svg" alt=""> --}}
                        <img src="https://img.icons8.com/cotton/50/000000/money.png" />
                    </div>
                    <div class="widget-text">
                        <h3 class="title gr-text-6 mb-7">Add Money to Wallet</h3>
                        <p class="gr-text-11 mb-0">We've prepared your wallet for you to add money.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-11 mb-lg-19 px-xs-6 px-md-6 px-lg-0 px-xl-8" data-aos="fade-right" data-aos-duration="800" data-aos-delay="600" data-aos-once="true">
                <div class="feature-widget text-center">
                    <div class="widget-icon square-80 rounded-15 mx-auto mb-9 mb-lg-12 bg-red shadow-red">
                        <img src="newpage/image/svg/feature8-icon3.svg" alt="feature8-icon3.svg">
                    </div>
                    <div class="widget-text">
                        <h3 class="title gr-text-6 mb-7">Send Money</h3>
                        <p class="gr-text-11 mb-0">Send money anytime, anywhere for Free!!.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end of how paysprint works -->

<!-- Download App -->
<!-- CTA section -->
<div class="cta-section pt-15 pt-lg-20 pb-5 pb-lg-5 bg-pattern pattern-7" style="background-color: #f2f2f2 !important;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="text-center dark-mode-texts">
                    <h2 class="gr-text-4 mb-7" style="color: #433d3d;">DOWNLOAD OUR APP</h2>

                    <a href="https://play.google.com/store/apps/details?id=com.fursee.damilare.sprint_mobile" target="_blank" class="btn text-white gr-hover-y px-lg-9">
                        <img src="https://res.cloudinary.com/paysprint/image/upload/v1651130088/assets/l6-download-gplay_o9rcfj_l6erwf.png" alt="play store">
                    </a>
                    <a href="https://apps.apple.com/gb/app/paysprint/id1567742130" target="_blank" class="btn text-white gr-hover-y px-lg-9">
                        <img src="https://res.cloudinary.com/paysprint/image/upload/v1651130088/assets/l6-download-appstore_odcskf_atgygf.png" alt="apple store">
                    </a>
                    <p class="gr-text-11 mb-0 mt-6" style="color: #433d3d;">It takes only 2 mins!</p>
                </div>

                <div class="hero-img" data-aos="fade-left" data-aos-duration="500" data-aos-once="true">
                    <div class="hero-video-thumb position-relative gr-z-index-1">
                        <center>
                            <img src="https://res.cloudinary.com/paysprint/image/upload/v1651130089/assets/paysprint_jpeg_black_bk_ft8qly_frobtx.jpg" alt="paysprint_jpeg_black_bk_ft8qly.jpg" class="w-100 rounded-8" style="height: 350px !important;width: 350px !important;">
                        </center>
                        <a class="video-play-trigger gr-abs-center bg-white circle-xl gr-flex-all-center gr-abs-hover-y focus-reset" data-fancybox="" href="https://youtu.be/txfp2Pzbzrg" tabindex="-1"><i class="icon icon-triangle-right-17-2"></i></a>
                        {{-- <div class="abs-shape gr-abs-tr-custom gr-z-index-n1">
                        <img src="{{ asset('newpage/image/l4/png/l4-hero-shape.png') }}" alt="" class="w-100" data-aos="zoom-in" data-aos-delay="400" data-aos-duration="800" data-aos-once="true">
                    </div> --}}
                </div>
            </div>

        </div>

        <div class="col-md-3">
            <center>
                <img class="shadow-lg" src="https://res.cloudinary.com/paysprint/image/upload/v1651130089/assets/paysprint_front_v55thg_gjjpzj.jpg" alt="mobile app" style="width: 80%; border-radius: 10px; position: relative; z-index: 1000;">
            </center>
        </div>

    </div>
</div>
</div><br>
<!-- end of download App -->

<!-- Available countries -->
<div class="container mt-8 mb-5">
    <div class="row justify-content-center align-items-center">
        <div class="">
            <h2 class="title gr-text-4 mb-8">Money Transfer from {{($data['country'])}} to {{count($data['availablecountry'] )}} Countries</h2>
        </div>
    </div>
    <div class="row mx-auto">

        @if (count($data['availablecountry']))

        @foreach ($data['availablecountry'] as $country)
        <div id="eclipse6">
            <div class="eclipse-slider">
                <div class="countrylist"> <img src="{{$country->logo}}" alt="{{$country->name}}" title="{{$country->name}}"></div>
            </div>
        </div>
        @endforeach

        @endif

    </div>
</div>
<br>
<br>
<hr>

<!-- end of available countries -->

<div class="brand-section pt-13 pt-lg-17 pb-11 border-bottom bg-default-6">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-8">
                {{-- <p class="gr-text-9 text-center mb-7">Trusted and Featured on:
                </p> --}}
                <h2 class="gr-text-4 text-center mb-8">As Featured on</h2>
            </div>
            <div class="col-12">
                <div class="brand-logos d-flex justify-content-center justify-content-xl-between align-items-center mx-n9 flex-wrap">
                    <div class="single-brand mx-9 py-6 gr-opacity-8 gr-hover-opacity-full" data-aos="zoom-in-right" data-aos-duration="500" data-aos-once="true">
                        <img src="https://res.cloudinary.com/paysprint/image/upload/v1651130250/assets/featuredon/questrade_znhne7_ua01kw.png" alt="" class="w-100" width="80" height="80">
                    </div>
                    <div class="single-brand mx-9 py-6 gr-opacity-8 gr-hover-opacity-full" data-aos="zoom-in-right" data-aos-duration="500" data-aos-delay="600" data-aos-once="true">
                        <img src="https://res.cloudinary.com/paysprint/image/upload/v1651130250/assets/featuredon/YahooFinanceLogo_geieeb_gpqual.png" alt="" class="w-100" width="60" height="60">
                    </div>
                    <div class="single-brand mx-9 py-6 gr-opacity-8 gr-hover-opacity-full" data-aos="zoom-in-right" data-aos-duration="800" data-aos-delay="800" data-aos-once="true">
                        <img src="https://res.cloudinary.com/paysprint/image/upload/v1651130249/assets/featuredon/private_capital_lxc1jr_kkswzw.png" alt="" class="w-100" width="60" height="60">
                    </div>
                    <div class="single-brand mx-9 py-6 gr-opacity-8 gr-hover-opacity-full" data-aos="zoom-in-right" data-aos-duration="800" data-aos-delay="800" data-aos-once="true">
                        <img src="https://res.cloudinary.com/paysprint/image/upload/v1651130250/assets/featuredon/benzinga_qpr7ot_kdvvtl.png" alt="" class="w-100" width="100" height="100">
                    </div>
                    <div class="single-brand mx-9 py-6 gr-opacity-8 gr-hover-opacity-full" data-aos="zoom-in-right" data-aos-duration="800" data-aos-delay="800" data-aos-once="true">
                        <img src="https://res.cloudinary.com/paysprint/image/upload/v1651130250/assets/featuredon/reuters_o3wnje_rmf94n.png" alt="" class="w-100" width="100" height="100">
                    </div>
                    <div class="single-brand mx-9 py-6 gr-opacity-8 gr-hover-opacity-full" data-aos="zoom-in-right" data-aos-duration="500" data-aos-delay="400" data-aos-once="true">
                        <img src="https://res.cloudinary.com/paysprint/image/upload/v1651130249/assets/featuredon/canadianbusinessjournal_e3mobm_lllwjj.png" alt="" class="w-100" width="100" height="100">
                    </div>
                    <div class="single-brand mx-9 py-6 gr-opacity-8 gr-hover-opacity-full" data-aos="zoom-in-right" data-aos-duration="500" data-aos-delay="200" data-aos-once="true">
                        <img src="https://res.cloudinary.com/paysprint/image/upload/v1651130250/assets/featuredon/magazinetoday_nsudvk_bjnihr.jpg" alt="" class="w-100" width="80" height="80">
                    </div>
                    <div class="single-brand mx-9 py-6 gr-opacity-8 gr-hover-opacity-full" data-aos="zoom-in-right" data-aos-duration="500" data-aos-delay="200" data-aos-once="true">
                        <img src="https://res.cloudinary.com/paysprint/image/upload/v1651130250/assets/featuredon/morningstar_ehxgue_mkpsrd.png" alt="" class="w-100" width="100" height="100">
                    </div>
                    <div class="single-brand mx-9 py-6 gr-opacity-8 gr-hover-opacity-full" data-aos="zoom-in-right" data-aos-duration="500" data-aos-delay="200" data-aos-once="true">
                        <img src="https://res.cloudinary.com/paysprint/image/upload/v1651130250/assets/featuredon/1280px-The_Globe_and_Mail__2019-10-31_.svg_ph46rz_qo87pl.png" alt="" class="w-100" style="width: 300px !important;">
                    </div>






                </div>
            </div>
        </div>
    </div>
</div>



{{-- Box tab --}}
{{-- <nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
      <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Home</button>
      <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Profile</button>
      <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Contact</button>
    </div>
  </nav>
  <div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">qswadesfrgthy</div>
    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">bola</div>
    <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">..dgfhj.</div>
  </div>
--}}

{{-- End of tab box --}}




<!-- Feature section -->





<!-- Content section 1 -->
<div class="content-section pt-11 pt-lg-20 pb-11 pb-lg-20 bg-default-6 disp-0" id=animation-area-2>
    <div class="container">

        <div class="row justify-content-center disp-0">
            <div class="col-xl-5 col-lg-6 col-md-8">
                <div class="section-title text-center mb-13 mb-lg-21">
                    <h2 class="title gr-text-4 mb-6">Services</h2>
                    <p class="gr-text-9 mb-0">We've made PaySprint simple and easy for you.</p>
                </div>
            </div>
        </div>

        <div class="row align-items-center justify-content-center">
            <div class="col-xs-11 col-sm-10 col-md-9 col-lg-6 col-xl-6 mb-6 mb-md-13 mb-lg-0">
                <div class="tel-content-image-group-1" data-aos="zoom-in" data-aos-duration="1200" data-aos-once="true">
                    <div class="abs-image-1 responsive-scaling-2">
                        <div class="animation-item">
                            <img class="main-img" src="https://res.cloudinary.com/pilstech/image/upload/v1620204676/paysprint_asset/seattle_apartmentbuildings_krjuam_ku2nsv.webp" alt="seattle_apartmentbuildings_krjuam_ku2nsv.webp" id="an-item-2p1" style="width: 100%; border-radius: 10px;">
                        </div>
                    </div>
                    {{-- <div class="abs-image-2 responsive-scaling-2">
                        <div class="animation-item">
                            <img class="main-img" src="https://images.unsplash.com/photo-1596716587659-a922cc68513f?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=750&q=80" alt=""
                                id="an-item-2p2" style="width: 40%; border-radius: 10px;" />
                        </div>
                    </div> --}}
                    <div class="gr-abs-center gr-z-index-n1">
                        <img src="{{ asset('newpage/image/telemedicine/png/content1-img-sub.png') }}" alt="content1-img-sub.png" class="responsive-scaling-2">
                    </div>
                </div>
            </div>
            <div class="col-sm-10 col-md-9 col-lg-6 col-xl-5 offset-xl-1">
                <div class="content-text pr-lg-10">
                    <h2 class="gr-text-4 mb-9">Rental Property Management</h2>
                    <p class="gr-text-9 mb-0">Are you a Property Manager or a Landlord looking for a good tool to
                        manage end-to-end process of your business or property? With PaySprint, you are able to manage
                        every aspect of the business or property ranging from managing maintenance to booking amenities
                        or invoicing tenants. Request for a Demo Today </p>
                    @guest
                    <a href="{{ route('login') }}" class="btn-link with-icon gr-text-blue gr-text-9 font-weight-bold mt-10">Check
                        available Rental Property Management <i class="fas fa-arrow-right"></i></a>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Content section 2 -->
<div class="content-section pt-11 pt-lg-22 pb-13 pb-lg-26 bg-default-6 hover-shadow-up disp-0">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-sm-10 col-md-7 col-lg-6 col-xl-5 offset-xl-2 order-lg-2 mb-9 mb-lg-0">
                <div class="double-image-group tel-content-image-group-2" data-aos="fade-left" data-aos-duration="1200" data-aos-once="true">
                    <img class="main-img" src="https://res.cloudinary.com/pilstech/image/upload/v1620147888/paysprint_asset/photo-1565514417878-a66a6b0f2c7f_hypubo.jpg" alt="photo-1565514417878-a66a6b0f2c7f_hypubo.jpg" style="width: 150%; border-radius: 10px;" />
                    <div class="abs-image-1 gr-z-index-n1" data-aos="zoom-in" data-aos-duration="1000" data-aos-delay="800" data-aos-once="true">
                        <img src="{{ asset('newpage/image/telemedicine/png/content2-img-sub-1.png') }}" alt="content2-img-sub-1.png" class="h-sm-100  anim-shadow-up rounded-10">
                    </div>
                    <div class="abs-image-2" data-aos="zoom-in" data-aos-duration="1000" data-aos-delay="800" data-aos-once="true">
                        <img src="{{ asset('newpage/image/telemedicine/png/content2-img-sub.png') }}" alt="content2-img-sub.png">
                    </div>
                </div>
            </div>
            <div class="col-sm-10 col-md-9 col-lg-6 col-xl-5 order-lg-1">
                <div class="content-text">
                    <h2 class="gr-text-4 mb-8">Utility Bill</h2>
                    <p class="gr-text-9 mb-0 pr-lg-10">Do you want to pay a utility bill to the landlord or government?
                        Do you want to be receiving electronic copy (eCopy) of the bills, Open a Free PaySprint Account
                        Today</p>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- Content section 3 -->
<div class="content-section pt-11 pt-lg-20 pb-11 pb-lg-20 bg-default-6 disp-0" id=animation-area-2>
    <div class="container">

        <div class="row align-items-center justify-content-center">
            <div class="col-xs-11 col-sm-10 col-md-9 col-lg-6 col-xl-6 mb-6 mb-md-13 mb-lg-0">
                <div class="tel-content-image-group-1" data-aos="zoom-in" data-aos-duration="1200" data-aos-once="true">
                    <div class="abs-image-1 responsive-scaling-2">
                        <div class="animation-item">
                            <img class="main-img" src="https://res.cloudinary.com/pilstech/image/upload/v1620147595/paysprint_asset/photo-1554224155-8d04cb21cd6c_d8e2wn.jpg" alt="photo-1554224155-8d04cb21cd6c_d8e2wn.jpg" id="an-item-2p1" style="width: 100%; border-radius: 10px;">
                        </div>
                    </div>
                    {{-- <div class="abs-image-2 responsive-scaling-2">
                        <div class="animation-item">
                            <img class="main-img" src="{{ asset('newpage/image/telemedicine/png/content-1-img2.png') }}" alt=""
                    id="an-item-2p2" />
                </div>
            </div> --}}
            <div class="gr-abs-center gr-z-index-n1">
                <img src="{{ asset('newpage/image/telemedicine/png/content1-img-sub.png') }}" alt="content1-img-sub.png" class="responsive-scaling-2">
            </div>
        </div>
    </div>
    <div class="col-sm-10 col-md-9 col-lg-6 col-xl-5 offset-xl-1">
        <div class="content-text pr-lg-10">
            <h2 class="gr-text-4 mb-9">Property Tax</h2>
            <p class="gr-text-9 mb-0">Do you have a bill to pay, or want to check if there is any outstanding
                on your property tax account with government?
                PaySprint is all you need.</p>
            <a href="javascript:void()" class="btn-link with-icon gr-text-blue gr-text-9 font-weight-bold mt-9">COMING SOON</a>
        </div>
    </div>
</div>
</div>
</div>
<!-- Content section 4 -->
<div class="content-section pt-11 pt-lg-22 pb-13 pb-lg-26 bg-default-6 hover-shadow-up disp-0">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-sm-10 col-md-7 col-lg-6 col-xl-5 offset-xl-2 order-lg-2 mb-9 mb-lg-0">
                <div class="double-image-group tel-content-image-group-2" data-aos="fade-left" data-aos-duration="1200" data-aos-once="true">
                    <img class="main-img" src="https://images.unsplash.com/photo-1613314188851-2c04697535ab?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=648&q=80" alt="https://images.unsplash.com/photo-1613314188851-2c04697535ab?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=648&q=80" style="width: 150%; border-radius: 10px;" />
                    <div class="abs-image-1 gr-z-index-n1" data-aos="zoom-in" data-aos-duration="1000" data-aos-delay="800" data-aos-once="true">
                        <img src="{{ asset('newpage/image/telemedicine/png/content2-img-sub-1.png') }}" alt="content2-img-sub-1.png" class="h-sm-100  anim-shadow-up rounded-10">
                    </div>
                    <div class="abs-image-2" data-aos="zoom-in" data-aos-duration="1000" data-aos-delay="800" data-aos-once="true">
                        <img src="{{ asset('newpage/image/telemedicine/png/content2-img-sub.png') }}" alt="content2-img-sub.png">
                    </div>
                </div>
            </div>
            <div class="col-sm-10 col-md-9 col-lg-6 col-xl-5 order-lg-1">
                <div class="content-text">
                    <h2 class="gr-text-4 mb-8">Parking Tickets</h2>
                    <p class="gr-text-9 mb-0 pr-lg-10">You can pay the City parking tickets and most other Provincial
                        Offences Act (POA) violations by telephone, in person or by mail.
                        <br>
                        <a href="javascript:void()" class="btn-link with-icon gr-text-blue gr-text-9 font-weight-bold mt-9">COMING SOON</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Team section -->
<div class="team-section pt-13 pt-lg-24 pb-3 pb-lg-20  bg-default-2 disp-0">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-7 col-md-9">
                <div class="section-title text-center mb-13 mb-lg-23 px-lg-7">
                    <h2 class="title gr-text-4 mb-6">Meet our doctors</h2>
                    <p class="gr-text-8 mb-0">With lots of unique blocks, you can easily build a page without
                        coding. Build your next landing page.</p>
                </div>
            </div>
        </div>
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-4 col-xs-9 col-md-6 mb-13 mb-lg-17 px-xs-6 px-md-6 px-lg-0 px-xl-8" data-aos="fade-right" data-aos-duration="800" data-aos-once="true">
                <div class="team-widget media">
                    <a href="#" class="widget-img mr-7">
                        <img src="../image/telemedicine/png/team-1.html" alt="team-1.html" class=" circle-96">
                    </a>
                    <div class="widget-text">
                        <a href="#">
                            <h3 class="name gr-text-7 mb-6">Dr. Eugene Tucker</h3>
                        </a>
                        <p class="gr-text-11 mb-0">MBBS, MD (Cardiology) <br>Senior Consultant</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-xs-9 col-md-6 mb-13 mb-lg-17 px-xs-6 px-md-6 px-lg-0 px-xl-8" data-aos="fade-right" data-aos-duration="800" data-aos-once="true">
                <div class="team-widget media">
                    <a href="#" class="widget-img mr-7">
                        <img src="../image/telemedicine/png/team-2.html" alt="team-2.html" class=" circle-96">
                    </a>
                    <div class="widget-text">
                        <a href="#">
                            <h3 class="name gr-text-7 mb-6">Dr. Nannie Roberts</h3>
                        </a>
                        <p class="gr-text-11 mb-0">MBBS, MD (Cardiology) <br>Senior Consultant</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-xs-9 col-md-6 mb-13 mb-lg-17 px-xs-6 px-md-6 px-lg-0 px-xl-8" data-aos="fade-right" data-aos-duration="800" data-aos-once="true">
                <div class="team-widget media">
                    <a href="#" class="widget-img mr-7">
                        <img src="../image/telemedicine/png/team-3.html" alt="telemedicine/png/team-3.html" class=" circle-96">
                    </a>
                    <div class="widget-text">
                        <a href="#">
                            <h3 class="name gr-text-7 mb-6">Dr. Henry Hampton</h3>
                        </a>
                        <p class="gr-text-11 mb-0">MBBS, MD (Cardiology) <br>Senior Consultant</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-xs-9 col-md-6 mb-13 mb-lg-17 px-xs-6 px-md-6 px-lg-0 px-xl-8" data-aos="fade-right" data-aos-duration="800" data-aos-once="true">
                <div class="team-widget media">
                    <a href="#" class="widget-img mr-7">
                        <img src="../image/telemedicine/png/team-4.html" alt="telemedicine/png/team-4.html" class=" circle-96">
                    </a>
                    <div class="widget-text">
                        <a href="#">
                            <h3 class="name gr-text-7 mb-6">Dr. Hannah Stanley</h3>
                        </a>
                        <p class="gr-text-11 mb-0">MBBS, MD (Cardiology) <br>Senior Consultant</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-xs-9 col-md-6 mb-13 mb-lg-17 px-xs-6 px-md-6 px-lg-0 px-xl-8" data-aos="fade-right" data-aos-duration="800" data-aos-once="true">
                <div class="team-widget media">
                    <a href="#" class="widget-img mr-7">
                        <img src="../image/telemedicine/png/team-5.html" alt="telemedicine/png/team-5.html" class=" circle-96">
                    </a>
                    <div class="widget-text">
                        <a href="#">
                            <h3 class="name gr-text-7 mb-6">Dr. Melvin Carpenter</h3>
                        </a>
                        <p class="gr-text-11 mb-0">MBBS, MD (Cardiology) <br>Senior Consultant</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-xs-9 col-md-6 mb-13 mb-lg-17 px-xs-6 px-md-6 px-lg-0 px-xl-8" data-aos="fade-right" data-aos-duration="800" data-aos-once="true">
                <div class="team-widget media">
                    <a href="#" class="widget-img mr-7">
                        <img src="../image/telemedicine/png/team-6.html" alt="telemedicine/png/team-6.html" class=" circle-96">
                    </a>
                    <div class="widget-text">
                        <a href="#">
                            <h3 class="name gr-text-7 mb-6">Dr. Nancy Watkins</h3>
                        </a>
                        <p class="gr-text-11 mb-0">MBBS, MD (Cardiology) <br>Senior Consultant</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-xs-9 col-md-6 mb-13 mb-lg-17 px-xs-6 px-md-6 px-lg-0 px-xl-8" data-aos="fade-right" data-aos-duration="800" data-aos-once="true">
                <div class="team-widget media">
                    <a href="#" class="widget-img mr-7">
                        <img src="../image/telemedicine/png/team-7.png" alt="telemedicine/png/team-7.png" class=" circle-96">
                    </a>
                    <div class="widget-text">
                        <a href="#">
                            <h3 class="name gr-text-7 mb-6">Dr. Roger McDonald</h3>
                        </a>
                        <p class="gr-text-11 mb-0">MBBS, MD (Cardiology) <br>Senior Consultant</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-xs-9 col-md-6 mb-13 mb-lg-17 px-xs-6 px-md-6 px-lg-0 px-xl-8" data-aos="fade-right" data-aos-duration="800" data-aos-once="true">
                <div class="team-widget media">
                    <a href="#" class="widget-img mr-7">
                        <img src="../image/telemedicine/png/team-8.html" alt="telemedicine/png/team-8.html" class=" circle-96">
                    </a>
                    <div class="widget-text">
                        <a href="#">
                            <h3 class="name gr-text-7 mb-6">Dr. Ella Gonzales</h3>
                        </a>
                        <p class="gr-text-11 mb-0">MBBS, MD (Cardiology) <br>Senior Consultant</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-xs-9 col-md-6 mb-13 mb-lg-17 px-xs-6 px-md-6 px-lg-0 px-xl-8" data-aos="fade-right" data-aos-duration="800" data-aos-once="true">
                <div class="team-widget media">
                    <a href="#" class="widget-img mr-7">
                        <img src="../image/telemedicine/png/team-9.png" alt="telemedicine/png/team-9.png" class=" circle-96">
                    </a>
                    <div class="widget-text">
                        <a href="#">
                            <h3 class="name gr-text-7 mb-6">Dr. Olive Farmer</h3>
                        </a>
                        <p class="gr-text-11 mb-0">MBBS, MD (Cardiology) <br>Senior Consultant</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Content section 3 -->





<!-- Testimonial section 2 -->
<div class="testimonial-section2 position-relative bg-dark dark-mode-texts bg-pattern pattern-4 pt-14 pt-lg-26 pb-14 pb-lg-26 disp-0">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-7 col-xl-6">
                <div class="section-title text-center mb-9">
                    <h4 class="pre-title gr-text-12 text-green text-uppercase mb-0">Testimonial</h4>
                </div>
            </div>
        </div>
        <div class="row align-items-center justify-content-around">
            <div class="col-lg-7 col-md-9">
                <div class="single-testimonial text-center">
                    <h3 class="review-text gr-text-5 mb-11">“Simply the best. Better than all the rest. I’d recommend
                        this product to beginners and advanced users.”</h3>
                    <div class="reviewer-img mb-7">
                        <img class="circle-lg mx-auto" src="{{ asset('newpage/image/l5/jpg/l5-testimonial2.jpg') }}" alt="">
                    </div>
                    <h3 class="username gr-text-9 mb-1">Ian Klein</h3>
                    <span class="rank gr-text-11 gr-text-color-opacity">Digital Marketer</span>
                </div>
            </div>
        </div>
    </div>
</div>







<!--What people are saying -->
<section class="container">
    <div class="row d-flex justify-content-center">
        <div class="col-md-10 col-xl-8 text-center">
            <!-- <h3 class="mb-4">What People are saying</h3> -->
            <!-- <p class="mb-4 pb-2 mb-md-5 pb-md-0">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugit, error amet
                numquam iure provident voluptate esse quasi, veritatis totam voluptas nostrum
                quisquam eum porro a pariatur veniam.
            </p> -->
        </div>
    </div>
    <br>
    <br>
    <div class="row text-center">
        <div class="col-md-4 mb-5 mb-md-0">
            <div class="d-flex justify-content-center mb-4">
                <!-- <img src="{{asset('images/testimonial1.png')}}" width="100%" height="100%" style="object-fit: cover;" /> -->
            </div>
            <h5 class="mb-3">Taiwo .A.</h5>
            <!-- <h6 class="text-primary mb-3">Web Developer</h6> -->
            <p class="px-xl-3">
                Paysprint is great and very easy to use. I can send and receive payments instantly without any problems and the best part is that i can make transactions from anywhere in the world. its really a great App.
            </p>
            <ul class="list-unstyled d-flex justify-content-center mb-0">
                <li>
                    <i class="fas fa-star fa-sm text-success"></i>
                </li>
                <li>
                    <i class="fas fa-star fa-sm text-success"></i>
                </li>
                <li>
                    <i class="fas fa-star fa-sm text-success"></i>
                </li>
                <li>
                    <i class="fas fa-star fa-sm text-success"></i>
                </li>
                <li>
                    <i class="fas fa-star fa-sm text-success"></i>
                </li>
            </ul>
        </div>
        <div class="col-md-4 mb-5 mb-md-0">
            <div class="d-flex justify-content-center mb-4">
                <!-- <img src="{{asset('images/testimonial2.png')}}" width="100%" height="100%" style="object-fit: cover;" /> -->
            </div>
            <h5 class="mb-3">David O.</h5>
            <!-- <h6 class="text-primary mb-3">Graphic Designer</h6> -->
            <p class="px-xl-3">
                Really good App. Wallet is so easy to use and good USDT/ETH rates too.
            </p>
            <ul class="list-unstyled d-flex justify-content-center mb-0">
                <li>
                    <i class="fas fa-star fa-sm text-success"></i>
                </li>
                <li>
                    <i class="fas fa-star fa-sm text-success"></i>
                </li>
                <li>
                    <i class="fas fa-star fa-sm text-success"></i>
                </li>
                <li>
                    <i class="fas fa-star fa-sm text-success"></i>
                </li>
                <li>
                    <i class="fas fa-star fa-sm text-success"></i>
                </li>
            </ul>
        </div>
        <div class="col-md-4 mb-0">
            <div class="d-flex justify-content-center mb-4">
                <!-- <img src="{{ asset('images/tesimonial3.png') }}" width="100%" height="100%" style="object-fit: cover;" /> -->
            </div>
            <h5 class="mb-3">I. Ahmed</h5>
            <!-- <h6 class="text-primary mb-3">Marketing Specialist</h6> -->
            <p class="px-xl-3">
                This is really a great App for money transfers and Invoices.
            </p>
            <ul class="list-unstyled d-flex justify-content-center mb-0">
                <li>
                    <i class="fas fa-star fa-sm text-success"></i>
                </li>
                <li>
                    <i class="fas fa-star fa-sm text-success"></i>
                </li>
                <li>
                    <i class="fas fa-star fa-sm text-success"></i>
                </li>
                <li>
                    <i class="fas fa-star fa-sm text-success"></i>
                </li>
                <li>
                    <i class="fas fa-star fa-sm text-success"></i>
                </li>
            </ul>
        </div>
    </div>
</section>


@endsection
