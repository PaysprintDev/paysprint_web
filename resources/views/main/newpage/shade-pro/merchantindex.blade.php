@extends('layouts.newpage.merchantapp')

@section('content')
<style>
    .circle-xxxl {
        max-width: 300px;
        min-width: 300px;
        max-height: 300px;
        min-height: 300px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

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

    .tab-menu {
        margin-top: 34px;
    }

    .tab-menu ul {
        margin: 0;
        padding: 0;
        list-style: none;
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
    }

    .tab-menu ul li {
        -ms-flex-preferred-size: 0;
        flex-basis: 0;
        -ms-flex-positive: 1;
        flex-grow: 1;
        max-width: 100%;
        text-align: center;
    }

    .tab-menu ul li a {
        color: #fff;
        text-transform: uppercase;
        letter-spacing: 0.44px;

        font-weight: bold;
        display: inline-block;
        padding: 18px 26px;
        display: block;
        text-decoration: none;
        transition: 0.5s all;
        background: #e8aa07;
        border: 2px solid #e8aa07;
        border-bottom: 0;
    }

    .tab-menu ul li a:hover {
        background: #e8aa07;
        color: #fff;
        text-decoration: none;
    }

    .tab-menu ul li a.active {
        background: #f2f2f2;
        color: #000;
        text-decoration: none;
    }

    .tab-box {
        display: none;
    }

    */.tab-teaser {
        max-width: 100%;
        width: 100%;
        margin: 0 auto;

    }

    .tab-main-box {
        background: ##f2f2f2;
        padding: 10px 30px;
        border: 2px solid #f8ca56;
        margin-top: -2px */
    }

    .hero-imgs {
        top: -15.456rem;
    }
</style>

<!-- Hero Area -->
<div class="position-relative bg-default-2 bg-pattern pattern-2 pt-27 pt-lg-32 pb-15 pb-lg-27">
    <div class="container">
        {{-- <p style="background: aquamarine;padding: 10px;border-radius: 10px;font-size: 20px;font-weight: 700;">
            <marquee behavior="" direction="">You are at the right website, Paypinn.com is same as Paysprint.ca!!!
            </marquee>
        </p> --}}
        <div class="row justify-content-center align-items-center">
            <div class="col-9 col-md-7 col-lg-5 offset-xl-1 align-self-sm-end order-lg-2">
                <div class="hero-imgs position-relative" data-aos="fade-left" data-aos-duration="500"
                    data-aos-once="true">
                    <img class="w-100"
                        src="https://res.cloudinary.com/paysprint/image/upload/v1651130089/assets/paysprint_jpeg_black_bk_ft8qly_frobtx.jpg"
                        alt="" style="border-radius: 100%;">
                    <div class="gr-abs-tl gr-z-index-n1" data-aos="zoom-in" data-aos-delay="600" data-aos-duration="800"
                        data-aos-once="true">
                        <img src="{{ asset('newpage/image/l5/png/l5-dot-shape.png') }}" alt="">
                    </div>
                </div>
            </div>
            <div class="col-11 col-md-10 col-lg-7 col-xl-6 order-lg-1" data-aos="fade-right" data-aos-duration="500"
                data-aos-once="true">
                <div class="hero-content mt-11 mt-lg-0">
                    <h4 class="pre-title gr-text-12 text-red text-uppercase mb-7" style="font-size: 22px;">Let???s lift
                        your business</h4>
                    <h1 class="title gr-text-2 mb-8" style="font-size:60px">Save up to 90% on fees when you accept
                        payments from Customers with PaySprint</h1>
                    <p class="gr-text-8 mb-11 pr-md-12">Accept Payments on any mobile device (for In-Store Sales) and on
                        Website (for Online Sales) with no transaction fees.</p>



                    <div class="hero-btn">

                        @guest
                        <a href="{{ route('AdminLogin') }}" class="btn btn-warning with-icon gr-hover-y">Get Started<i
                                class="icon icon-tail-right font-weight-bold"></i></a>
                        @endguest


                    </div>

                    <a data-fancybox href="https://youtu.be/ptsmEYFJMx4"
                        class="video-link gr-text-color mt-8 gr-flex-y-center justify-content-center justify-content-lg-start">
                        <span class="mr-2 gr-text-color circle-18 border border-black-dynamic">
                            <i class="icon icon-triangle-right-17-2 gr-text-14"></i>
                        </span>
                        <span class="gr-text-12 font-weight-bold text-uppercase" style="font-size: 16px;">How PaySprint
                            works</span>
                    </a>

                    <p class="gr-text-9 gr-text-color pr-md-7 font-weight-bold">
                        <br>
                        <hr>
                    <h5 class="font-weight-bold">Secure Environment</h5>
                    <i class="fas fa-circle" style="font-size: 12px; color: #f64b4b;"></i> Identity Verification <i
                        class="fas fa-circle" style="font-size: 12px; color: #f64b4b;"></i> Multi-level authentication
                    <i class="fas fa-circle" style="font-size: 12px; color: #f64b4b;"></i> Full Encryption
                    </p>


                </div>
            </div>


        </div>
    </div>
</div>


<!-- Featured On -->


<div class="brand-section pt-13 pt-lg-17 pb-11 border-bottom bg-default-6">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-8">
                {{-- <p class="gr-text-9 text-center mb-7">Trusted and Featured on:
                </p> --}}
                <h2 class="gr-text-4 text-center mb-8">Featured on</h2>
            </div>
            <div class="col-12">
                <div
                    class="brand-logos d-flex justify-content-center justify-content-xl-between align-items-center mx-n9 flex-wrap">
                    <div class="single-brand mx-9 py-6 gr-opacity-8 gr-hover-opacity-full" data-aos="zoom-in-right"
                        data-aos-duration="500" data-aos-once="true">
                        <img src="https://res.cloudinary.com/paysprint/image/upload/v1651130250/assets/featuredon/questrade_znhne7_ua01kw.png"
                            alt="" class="w-100" width="80" height="80">
                    </div>
                    <div class="single-brand mx-9 py-6 gr-opacity-8 gr-hover-opacity-full" data-aos="zoom-in-right"
                        data-aos-duration="500" data-aos-delay="600" data-aos-once="true">
                        <img src="https://res.cloudinary.com/paysprint/image/upload/v1651130250/assets/featuredon/YahooFinanceLogo_geieeb_gpqual.png"
                            alt="" class="w-100" width="60" height="60">
                    </div>
                    <div class="single-brand mx-9 py-6 gr-opacity-8 gr-hover-opacity-full" data-aos="zoom-in-right"
                        data-aos-duration="800" data-aos-delay="800" data-aos-once="true">
                        <img src="https://res.cloudinary.com/paysprint/image/upload/v1651130249/assets/featuredon/private_capital_lxc1jr_kkswzw.png"
                            alt="" class="w-100" width="60" height="60">
                    </div>
                    <div class="single-brand mx-9 py-6 gr-opacity-8 gr-hover-opacity-full" data-aos="zoom-in-right"
                        data-aos-duration="800" data-aos-delay="800" data-aos-once="true">
                        <img src="https://res.cloudinary.com/paysprint/image/upload/v1651130250/assets/featuredon/benzinga_qpr7ot_kdvvtl.png"
                            alt="" class="w-100" width="100" height="100">
                    </div>
                    <div class="single-brand mx-9 py-6 gr-opacity-8 gr-hover-opacity-full" data-aos="zoom-in-right"
                        data-aos-duration="800" data-aos-delay="800" data-aos-once="true">
                        <img src="https://res.cloudinary.com/paysprint/image/upload/v1651130250/assets/featuredon/reuters_o3wnje_rmf94n.png"
                            alt="" class="w-100" width="100" height="100">
                    </div>
                    <div class="single-brand mx-9 py-6 gr-opacity-8 gr-hover-opacity-full" data-aos="zoom-in-right"
                        data-aos-duration="500" data-aos-delay="400" data-aos-once="true">
                        <img src="https://res.cloudinary.com/paysprint/image/upload/v1651130249/assets/featuredon/canadianbusinessjournal_e3mobm_lllwjj.png"
                            alt="" class="w-100" width="100" height="100">
                    </div>
                    <div class="single-brand mx-9 py-6 gr-opacity-8 gr-hover-opacity-full" data-aos="zoom-in-right"
                        data-aos-duration="500" data-aos-delay="200" data-aos-once="true">
                        <img src="https://res.cloudinary.com/paysprint/image/upload/v1651130250/assets/featuredon/magazinetoday_nsudvk_bjnihr.jpg"
                            alt="" class="w-100" width="80" height="80">
                    </div>
                    <div class="single-brand mx-9 py-6 gr-opacity-8 gr-hover-opacity-full" data-aos="zoom-in-right"
                        data-aos-duration="500" data-aos-delay="200" data-aos-once="true">
                        <img src="https://res.cloudinary.com/paysprint/image/upload/v1651130250/assets/featuredon/morningstar_ehxgue_mkpsrd.png"
                            alt="" class="w-100" width="100" height="100">
                    </div>
                    <div class="single-brand mx-9 py-6 gr-opacity-8 gr-hover-opacity-full" data-aos="zoom-in-right"
                        data-aos-duration="500" data-aos-delay="200" data-aos-once="true">
                        <img src="https://res.cloudinary.com/paysprint/image/upload/v1651130250/assets/featuredon/1280px-The_Globe_and_Mail__2019-10-31_.svg_ph46rz_qo87pl.png"
                            alt="" class="w-100" style="width: 300px !important;">
                    </div>






                </div>
            </div>
        </div>
    </div>
</div>


<!-- End Featured On -->


<!-- Service section  -->
<div class="service-section bg-default-4 pt-15 pb-13 py-lg-25 disp-0">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-7 col-md-9">
                <div class="section-title text-center mb-11 mb-lg-19 px-lg-3">
                    <h4 class="pre-title gr-text-12 text-red text-uppercase mb-7">Our services</h4>
                    <h2 class="title gr-text-4">We provide great services that meet your business needs</h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-center position-relative gr-z-index-1">





            <div class="col-md-6 col-lg-4 mb-9 mb-lg-0" data-aos="fade-up" data-aos-duration="800" data-aos-once="true">
                <div
                    class="service-card rounded-10 gr-hover-shadow-4 d-flex flex-column text-center pt-15 px-9 pb-11 dark-mode-texts bg-blue h-100">
                    <div class="card-img mb-11">
                        <img src="{{ asset('newpage/image/l5/png/l5-service-card2.png') }}" alt="...">
                    </div>
                    <h3 class="card-title gr-text-6 mb-6">Accept and Receive Payments at No Cost</h3>
                    <p class="gr-text-9 mb-11">Accept Payments. You have the option of accepting payments to your
                        PaySprint Merchant???s Wallet through mobile app (In-Store) or on your website (Online Sale).
                        Connect your bank account and have your payments ready for direct deposits. </p>
                    <a href="{{ route('AdminLogin') }}" class="gr-text-9 btn-link with-icon text-white mt-auto">Get
                        Started <i class="icon icon-tail-right"></i></a>
                </div>
            </div>

            <div class="col-md-6 col-lg-4 mb-9 mb-lg-0" data-aos="fade-right" data-aos-duration="800"
                data-aos-once="true">
                <div
                    class="service-card rounded-10 gr-hover-shadow-4 d-flex flex-column text-center pt-15 px-9 pb-11 dark-mode-texts bg-green h-100">
                    <div class="card-img mb-11">
                        <img src="{{ asset('newpage/image/l5/png/l5-service-card1.png') }}" alt="...">
                    </div>
                    <h3 class="card-title gr-text-6 mb-6">Create and Send Invoice with Ease</h3>
                    <p class="gr-text-9 mb-11">Professional Invoicing, Simplified! Create and send professional invoices
                        with a click of a button. You can create and send a single invoice or send batch invoices and
                        set up recurring payments, instalments and pay taxes!</p>
                    <a href="{{ route('AdminLogin') }}" class="gr-text-9 btn-link with-icon text-white mt-auto">Get
                        Started <i class="icon icon-tail-right"></i></a>
                </div>
            </div>

            <div class="col-md-6 col-lg-4 mb-9 mb-lg-0" data-aos="fade-left" data-aos-duration="800"
                data-aos-once="true">
                <div
                    class="service-card rounded-10 gr-hover-shadow-4 d-flex flex-column text-center pt-15 px-9 pb-11 dark-mode-texts bg-red h-100">
                    <div class="card-img mb-11">
                        <img src="{{ asset('newpage/image/l5/png/l5-service-card3.png') }}" alt="...">
                    </div>
                    <h3 class="card-title gr-text-6 mb-6">Connect Your Business with Customers</h3>
                    <p class="gr-text-9 mb-11">Its easier to grow your business when you open a Merchant Account on
                        PaySprint. Connect your business with customers and close more sales than ever!</p>
                    <a href="{{ route('AdminLogin') }}" class="gr-text-9 btn-link with-icon text-white mt-auto">Get
                        Started <i class="icon icon-tail-right"></i></a>
                </div>
                <div class="gr-abs-br-custom gr-z-index-n1" data-aos="zoom-in-right" data-aos-delay="600"
                    data-aos-duration="800" data-aos-once="true">
                    <img src="{{ asset('newpage/image/l5/png/l5-dot-shape2.png') }}" alt="">
                </div>
            </div>
        </div>


    </div>
</div>
<!-- Testimonial section-1  -->
<div class="testimonial-section1 bg-default-4 ">
    <div class="container">

        <div class="review-wrapper pt-9 pb-lg-25 pb-14 border-bottom">

            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-7 col-md-9">
                    <div class="section-title text-center mb-11 mb-lg-19 px-lg-3">
                        <h4 class="pre-title gr-text-12 text-red text-uppercase mb-7" style="font-size: 28px;">
                            <strong>Our services</strong>
                        </h4>
                        <h2 class="title gr-text-4">We provide great services that meet your business needs</h2>
                    </div>
                </div>
            </div>


            <div class="row justify-content-center align-items-center">

                <div class="col-xl-11 col-lg-12">
                    <div class="review-widget media align-items-center px-lg-7 flex-column flex-sm-row">
                        <div class="widget-image mr-12 mr-lg-19 mb-9 mb-md-0">
                            <img class="circle-xxxl"
                                src="https://res.cloudinary.com/paysprint/image/upload/v1651130086/assets/create_invoice_icljdw_zrz9jh.png"
                                alt="">
                        </div>
                        <div class="widget-text">
                            <img class="rating mb-11" src="{{ asset('newpage/image/l5/png/5-stars.png') }}" alt="">
                            <h4 class="review-text gr-text-6 font-weight-bold mb-9">Create and Send Invoice with Ease
                            </h4>
                            <div class="reviewer-block d-flex flex-wrap">
                                <h5 class="name gr-text-9 mr-7 mb-md-0">Professional Invoicing, Simplified! Create and
                                    send professional invoices with a click of a button. You can create and send a
                                    single invoice or send batch invoices and set up recurring payments, instalments and
                                    pay taxes!</h5>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row justify-content-center align-items-center pt-15">

                <div class="col-xl-11 col-lg-12">
                    <div class="review-widget media align-items-center px-lg-7 flex-column flex-sm-row">

                        <div class="widget-text">
                            <img class="rating mb-11" src="{{ asset('newpage/image/l5/png/5-stars.png') }}" alt="">
                            <h4 class="review-text gr-text-6 font-weight-bold mb-9">Accept and Receive Payments at No
                                Cost</h4>
                            <div class="reviewer-block d-flex flex-wrap">
                                <h5 class="name gr-text-9 mr-7 mb-md-0">Accept Payments. You have the option of
                                    accepting payments to your PaySprint Merchant???s Wallet through mobile app (In-Store)
                                    or on your website (Online Sale). Connect your bank account and have your payments
                                    ready for direct deposits. </h5>
                            </div>
                        </div>

                        <div class="widget-image mr-12 mr-lg-19 mb-9 mb-md-0">
                            <img class="circle-xxxl"
                                src="https://res.cloudinary.com/paysprint/image/upload/v1651130084/assets/Accept_more_payments_aao3ta_xplqth.png"
                                alt="">
                        </div>

                    </div>
                </div>

            </div>


            <div class="row justify-content-center align-items-center pt-15">

                <div class="col-xl-11 col-lg-12">
                    <div class="review-widget media align-items-center px-lg-7 flex-column flex-sm-row">
                        <div class="widget-image mr-12 mr-lg-19 mb-9 mb-md-0">
                            <img class="circle-xxxl"
                                src="https://res.cloudinary.com/paysprint/image/upload/v1651130084/assets/Additional_feature_bd4ib0_ztsdsh.png"
                                alt="">
                        </div>
                        <div class="widget-text">
                            <img class="rating mb-11" src="{{ asset('newpage/image/l5/png/5-stars.png') }}" alt="">
                            <h4 class="review-text gr-text-6 font-weight-bold mb-9">Connect Your Business with
                                Customers
                            </h4>
                            <div class="reviewer-block d-flex flex-wrap">
                                <h5 class="name gr-text-9 mr-7 mb-md-0">Its easier to grow your business when you open
                                    a Merchant Account on PaySprint. Connect your business with customers and close more
                                    sales than ever!</h5>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row justify-content-center align-items-center pt-15">

                <div class="col-xl-11 col-lg-12">
                    <div class="review-widget media align-items-center px-lg-7 flex-column flex-sm-row">

                        <div class="widget-text">
                            <img class="rating mb-11" src="{{ asset('newpage/image/l5/png/5-stars.png') }}" alt="">
                            <h4 class="review-text gr-text-6 font-weight-bold mb-9">eStore (Your Personalised Online
                                Store)</h4>
                            <div class="reviewer-block d-flex flex-wrap">
                                <h5 class="name gr-text-9 mr-7 mb-md-0">Sell More Online. PaySprint eStore is enables
                                    you to sell more, online. With easy to set up tools and easy to use content
                                    management features, small business owners can set up own online store and sell more
                                    on social media. Even, if your business already have a website, PaySprint eStore
                                    provides you with additional outlets to sell more to customers!


                                </h5>



                            </div>
                        </div>

                        <div class="widget-image mr-12 mr-lg-19 mb-9 mb-md-0">
                            <img class="circle-xxxl"
                                src="https://res.cloudinary.com/paysprint/image/upload/v1651130084/assets/Additional_feature_bd4ib0_ztsdsh.png"
                                alt="">
                        </div>

                    </div>
                </div>

            </div>



            <div class="row justify-content-center align-items-center pt-15">

                <div class="col-xl-11 col-lg-12">
                    <div class="review-widget media align-items-center px-lg-7 flex-column flex-sm-row">
                        <div class="widget-image mr-12 mr-lg-19 mb-9 mb-md-0">
                            <img class="circle-xxxl"
                                src="https://res.cloudinary.com/paysprint/image/upload/v1651130084/assets/Additional_feature_bd4ib0_ztsdsh.png"
                                alt="">
                        </div>
                        <div class="widget-text">
                            <img class="rating mb-11" src="{{ asset('newpage/image/l5/png/5-stars.png') }}" alt="">
                            <h4 class="review-text gr-text-6 font-weight-bold mb-9">Cross Border Business Payments
                            </h4>
                            <div class="reviewer-block d-flex flex-wrap">
                                <h5 class="name gr-text-9 mr-7 mb-md-0">Pay Bills in other Currencies. We have helped
                                    many merchants to overcome the hurdles in making payments in other currencies. With
                                    PaySprint CBBP, merchants are now able to meet foreign financial obligations without
                                    hassles.


                                </h5>
                            </div>
                        </div>
                    </div>
                </div>

            </div>



            <div class="row justify-content-center align-items-center pt-15">

                <div class="col-xl-11 col-lg-12">
                    <div class="review-widget media align-items-center px-lg-7 flex-column flex-sm-row">

                        <div class="widget-text">
                            <img class="rating mb-11" src="{{ asset('newpage/image/l5/png/5-stars.png') }}" alt="">
                            <h4 class="review-text gr-text-6 font-weight-bold mb-9">Merchant Cash Advance</h4>
                            <div class="reviewer-block d-flex flex-wrap">
                                <h5 class="name gr-text-9 mr-7 mb-md-0">Supporting Businesses with Finance. Our
                                    Merchant Cash Advance is built to support small businesses like yours with much
                                    needed financing with little requirements. Whatever may be the need, our merchant
                                    cash advance program is available to you!


                                </h5>



                            </div>
                        </div>

                        <div class="widget-image mr-12 mr-lg-19 mb-9 mb-md-0">
                            <img class="circle-xxxl"
                                src="https://res.cloudinary.com/paysprint/image/upload/v1651130084/assets/Additional_feature_bd4ib0_ztsdsh.png"
                                alt="">
                        </div>

                    </div>
                </div>

            </div>


        </div>
    </div>
</div>
<!-- Content About section  -->
<div class="content-section bg-default-4 pt-lg-25 pt-15 pb-10 pb-lg-15 disp-0">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 col-lg-7 col-md-8">
                <div class="section-title mb-13">
                    <h4 class="pre-title gr-text-12 text-red text-uppercase mb-9">Our Story</h4>
                    <h2 class="title gr-text-4">We know how everything works and why your business is failing over and
                        over again.</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-5">
                <div class="about-image img-big pt-lg-13" data-aos="fade-right" data-aos-duration="800"
                    data-aos-once="true">
                    <img class="w-100 rounded-10" src="{{ asset('') }}newpage/image/l5/jpg/l5-about-big.jpg" alt="">
                </div>
            </div>
            <div class="col-lg-7">
                <div class="row justify-content-between align-items-center pl-lg-13">
                    <div class="col-md-6">
                        <div class="about-image img-mid mt-9 mt-lg-0" data-aos="fade-up" data-aos-duration="900"
                            data-aos-once="true">
                            <img class="w-100 rounded-10" src="{{ asset('') }}newpage/image/l5/jpg/l5-about-mid.jpg"
                                alt="">
                            <div class="abs-pattern gr-abs-tr-custom" data-aos="zoom-in" data-aos-duration="800"
                                data-aos-delay="300" data-aos-once="true">
                                <img src="{{ asset('') }}newpage/image/l5/png/l5-about-pattern.png" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="about-image img-sm mt-9 mt-lg-0" data-aos="fade-left" data-aos-duration="1000"
                            data-aos-once="true">
                            <img class="rounded-10" src="{{ asset('') }}newpage/image/l5/jpg/l5-about-sm.jpg" alt="">
                        </div>
                    </div>
                    <div class="col-xl-10">
                        <div class="about-content mt-12 mt-lg-23">
                            <p class="gr-text-9">We share common trends and strategies for improving your rental
                                income and making sure you stay in high demand. With lots of unique blocks, you can
                                easily build a page without coding. Build your next landing page.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Fact Counter section -->
<div class="fact-section bg-default-4 pt-lg-15 pb-7 pb-lg-24 disp-0">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 col-sm-6 mb-9 mb-lg-0">
                <div class="single-fact text-center px-xl-6">
                    <h3 class="title mb-7 gr-text-3">1M+</h3>
                    <p class="gr-text-8 mb-0">Customers visit Albino every month to get their service done.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 mb-9 mb-lg-0">
                <div class="single-fact text-center px-xl-6">
                    <h3 class="title mb-7 gr-text-3"><span class="counter">92</span>%</h3>
                    <p class="gr-text-8 mb-0">Satisfaction rate comes from our awesome customers.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 mb-9 mb-lg-0">
                <div class="single-fact text-center px-xl-6">
                    <h3 class="title mb-7 gr-text-3"><span class="counter">4.9</span>/5.0</h3>
                    <p class="gr-text-8 mb-0">Average customer ratings we have got all over internet.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Feature section -->
<div class="feature-section pt-14 pt-lg-25 pb-7 pb-lg-11 bg-default-2 disp-0">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-7 col-md-8">
                <div class="section-title text-center mb-13 mb-lg-23">
                    <h4 class="pre-title gr-text-12 text-red text-uppercase mb-7">Why choose us</h4>
                    <h2 class="title gr-text-4">People choose us because we serve the best for everyone</h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="row align-items-center justify-content-center">
                    <div class="col-lg-6 col-md-10 mb-11 mb-lg-19" data-aos="fade-left" data-aos-duration="800"
                        data-aos-delay="200" data-aos-once="true">
                        <div class="feature-widget media">
                            <div class="widget-icon p-7 rounded-15 mr-9 gr-bg-blue-opacity-1">
                                <img src="{{ asset('') }}newpage/image/svg/l5-feature-icon1.svg" alt="">
                            </div>
                            <div class="widget-text">
                                <h3 class="title gr-text-7 mb-6">Dedicated project manager</h3>
                                <p class="gr-text-9 mb-0 pr-11">With lots of unique blocks, you can easily build a page
                                    without coding. Build your next landing page.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-10 mb-11 mb-lg-19" data-aos="fade-left" data-aos-duration="800"
                        data-aos-delay="400" data-aos-once="true">
                        <div class="feature-widget media">
                            <div class="widget-icon p-7 rounded-15 mr-9 gr-bg-red-opacity-1">
                                <img src="{{ asset('') }}newpage/image/svg/l5-feature-icon2.svg" alt="">
                            </div>
                            <div class="widget-text">
                                <h3 class="title gr-text-7 mb-6">Organized tasks</h3>
                                <p class="gr-text-9 mb-0 pr-11">With lots of unique blocks, you can easily build a page
                                    without coding. Build your next landing page.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-10 mb-11 mb-lg-19" data-aos="fade-right" data-aos-duration="800"
                        data-aos-delay="600" data-aos-once="true">
                        <div class="feature-widget media">
                            <div class="widget-icon p-7 rounded-15 mr-9 gr-bg-green-opacity-1">
                                <img src="{{ asset('') }}newpage/image/svg/l5-feature-icon3.svg" alt="">
                            </div>
                            <div class="widget-text">
                                <h3 class="title gr-text-7 mb-6">Easy feedback sharing</h3>
                                <p class="gr-text-9 mb-0 pr-11">With lots of unique blocks, you can easily build a page
                                    without coding. Build your next landing page.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-10 mb-11 mb-lg-19" data-aos="fade-right" data-aos-duration="800"
                        data-aos-delay="800" data-aos-once="true">
                        <div class="feature-widget media">
                            <div class="widget-icon p-7 rounded-15 mr-9 gr-bg-blackish-blue-opacity-1">
                                <img src="{{ asset('') }}newpage/image/svg/l5-feature-icon4.svg" alt="">
                            </div>
                            <div class="widget-text">
                                <h3 class="title gr-text-7 mb-6">Never miss deadline</h3>
                                <p class="gr-text-9 mb-0 pr-11">With lots of unique blocks, you can easily build a page
                                    without coding. Build your next landing page.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- CTA section -->
<div class="cta-section bg-default-2 disp-0">
    <div class="container">
        <div class="cta-wrapper pt-13 pb-14 py-lg-19 border-top ">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-6 col-md-10">
                    <div class="cta-text section-title">
                        <h2 class="title gr-text-5 mb-7">Ready to launch your next project?</h2>
                        <p class="gr-text-8 mb-8 mb-lg-0">With lots of unique blocks, you can easily build a page
                            without coding. Build your next landing page.</p>
                    </div>
                </div>
                <div class="col-lg-4 offset-lg-2 col-md-10">
                    <div class="cta-btn text-lg-right">
                        <a href="#" class="btn gr-hover-y btn-primary rounded-8">Get started on a project</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Case Studies section  -->
<div class="case-section pt-15 pb-14 py-lg-25 disp-0">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-7 col-md-8">
                <div class="section-title text-center mb-11 mb-lg-21">
                    <h3 class="sub-badge gr-text-12 text-uppercase text-red mb-7">Case studies</h3>
                    <h2 class="title gr-text-4 mb-0">Our works describe why we are the best in the business</h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card-columns mb-lg-9">
                    <div class="single-case d-inline-block px-md-6 mb-3 mb-lg-9 gr-hover-rotate-img">
                        <div class="case-img overflow-hidden">
                            <img src="{{ asset('') }}newpage/image/l5/jpg/l5-case1.jpg" alt="" class="w-100 rounded-10">
                        </div>
                        <div class="case-content px-5 px-md-9 py-9">
                            <span class="case-category gr-text-11 mb-2 d-inline-block gr-text-color-opacity">Graphic
                                Design</span>
                            <h3 class="case-title gr-text-6 mb-0">Aura Branding Design</h3>
                        </div>
                    </div>
                    <div class="single-case d-inline-block px-md-6 mb-3 mb-lg-9 gr-hover-rotate-img">
                        <div class="case-img overflow-hidden">
                            <img src="{{ asset('') }}newpage/image/l5/jpg/l5-case2.jpg" alt="" class="w-100 rounded-10">
                        </div>
                        <div class="case-content px-5 px-md-9 py-9">
                            <span class="case-category gr-text-11 mb-2 d-inline-block gr-text-color-opacity">Web
                                Development</span>
                            <h3 class="case-title gr-text-6 mb-0">Gradient Website Development</h3>
                        </div>
                    </div>
                    <div class="single-case d-inline-block px-md-6 mb-3 mb-lg-9 gr-hover-rotate-img">
                        <div class="case-img overflow-hidden">
                            <img src="{{ asset('') }}newpage/image/l5/jpg/l5-case3.jpg" alt="" class="w-100 rounded-10">
                        </div>
                        <div class="case-content px-5 px-md-9 py-9">
                            <span class="case-category gr-text-11 mb-2 d-inline-block gr-text-color-opacity">Graphic
                                Design</span>
                            <h3 class="case-title gr-text-6 mb-0">AB.S Snack Packaging</h3>
                        </div>
                    </div>
                    <div class="single-case d-inline-block px-md-6 mb-3 mb-lg-9 gr-hover-rotate-img">
                        <div class="case-img overflow-hidden">
                            <img src="{{ asset('') }}newpage/image/l5/jpg/l5-case4.jpg" alt="" class="w-100 rounded-10">
                        </div>
                        <div class="case-content px-5 px-md-9 py-9">
                            <span class="case-category gr-text-11 mb-2 d-inline-block gr-text-color-opacity">Content
                                Writing</span>
                            <h3 class="case-title gr-text-6 mb-0">Magazine Content Writing</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="more-btn case-btn text-center">
                    <a href="#" class="btn-link with-icon mb-0 gr-text-7 font-weight-bold">See all works<i
                            class="icon icon-tail-right font-weight-bold"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Testimonial section 2 -->
<div
    class="testimonial-section2 position-relative bg-blue dark-mode-texts bg-pattern pattern-4 pt-14 pt-lg-26 pb-14 pb-lg-26 disp-0">
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
                    <h3 class="review-text gr-text-5 mb-11">???Simply the best. Better than all the rest. I???d recommend
                        this product to beginners and advanced users.???</h3>
                    <div class="reviewer-img mb-7">
                        <img class="circle-lg mx-auto" src="{{ asset('') }}newpage/image/l5/jpg/l5-testimonial2.jpg"
                            alt="">
                    </div>
                    <h3 class="username gr-text-9 mb-1">Ian Klein</h3>
                    <span class="rank gr-text-11 gr-text-color-opacity">Digital Marketer</span>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="content-section pt-13 pt-lg-12 pb-11 pb-lg-22 hover-tilt bg-default-8 disp-0">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            {{-- <div class="col-sm-10 col-md-9 col-lg-6 col-xl-5 mb-n7 mb-lg-0">
                <div class="double-image-group position-relative" data-aos="fade-right" data-aos-duration="1000"
                    data-aos-once="true">
                    <img class="main-img w-100 w-lg-auto" src="newpage/image/telemedicine/png/content-3-img.png"
                        alt="" />
                    <div class="gr-abs-img-custom-2 animation-tilt">
                        <img src="newpage/image/telemedicine/png/content3-img-sub.png" alt=""
                            class="responsive-scaling">
                    </div>
                </div>
            </div> --}}
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 offset-xl-1">
                <div class="content-text pr-lg-7" data-aos="fade-left" data-aos-duration="1200" data-aos-once="true">
                    <h2 class="gr-text-4 mb-8">Unique Features</h2>
                    {{-- <p class="gr-text-9 mb-0">We've made telemedicine simple and easy for you. Create your
                        personal room and start practicing telemedicine today. </p> --}}
                    <div class="content-widget mt-8">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="single-widget d-flex align-items-center py-2">
                                    <div class="widget-icon text-primary mr-6 gr-text-8 d-flex align-items-center">
                                        <i class="icon icon-check-simple"></i>
                                    </div>
                                    <h3 class="w-title gr-text-8 mb-0">Unlimited transactions.</h3>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="single-widget d-flex align-items-center py-2">
                                    <div class="widget-icon text-primary mr-6 gr-text-8 d-flex align-items-center">
                                        <i class="icon icon-check-simple"></i>
                                    </div>
                                    <h3 class="w-title gr-text-8 mb-0">Add money to your PaySprint Wallet from debit or
                                        credit cards.</h3>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="single-widget d-flex align-items-center py-2">
                                    <div class="widget-icon text-primary mr-6 gr-text-8 d-flex align-items-center">
                                        <i class="icon icon-check-simple"></i>
                                    </div>
                                    <h3 class="w-title gr-text-8 mb-0">Withdraw money to your EXBC pre-paid Mastercard
                                        for Free.</h3>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="single-widget d-flex align-items-center py-2">
                                    <div class="widget-icon text-primary mr-6 gr-text-8 d-flex align-items-center">
                                        <i class="icon icon-check-simple"></i>
                                    </div>
                                    <h3 class="w-title gr-text-8 mb-0">Send money locally and abroad.</h3>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="single-widget d-flex align-items-center py-2">
                                    <div class="widget-icon text-primary mr-6 gr-text-8 d-flex align-items-center">
                                        <i class="icon icon-check-simple"></i>
                                    </div>
                                    <h3 class="w-title gr-text-8 mb-0">Pay invoice at a click of a button.</h3>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="single-widget d-flex align-items-center py-2">
                                    <div class="widget-icon text-primary mr-6 gr-text-8 d-flex align-items-center">
                                        <i class="icon icon-check-simple"></i>
                                    </div>
                                    <h3 class="w-title gr-text-8 mb-0">Create and send professional invoices on the go.
                                    </h3>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="single-widget d-flex align-items-center py-2">
                                    <div class="widget-icon text-primary mr-6 gr-text-8 d-flex align-items-center">
                                        <i class="icon icon-check-simple"></i>
                                    </div>
                                    <h3 class="w-title gr-text-8 mb-0">Fast-track how you get paid as a merchant.</h3>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="single-widget d-flex align-items-center py-2">
                                    <div class="widget-icon text-primary mr-6 gr-text-8 d-flex align-items-center">
                                        <i class="icon icon-check-simple"></i>
                                    </div>
                                    <h3 class="w-title gr-text-8 mb-0">Safe and secure, multi-level security
                                        authentication features.</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- {{-- Box tab --}}
@include('include.newpage.currencyconversion')

{{-- End of tab box --}} -->

{{-- Avalable country --}}
<div class="container mt-8 mb-5">
    <div class="row justify-content-center align-items-center">
        <div class="">
            <h2 class="title gr-text-4 mb-4">Cross Border Business Payments from {{($data['country'])}} to
                {{count($data['availablecountry'] )}} Countries</h2><br>
        </div>
    </div>
    <div class="row mx-auto">

        @if (count($data['availablecountry']))

        @foreach ($data['availablecountry'] as $country)
        <div id="eclipse6">
            <div class="eclipse-slider">
                <div> <img src="{{$country->logo}}" alt="{{$country->name}}" title="{{$country->name}}"></div>

            </div>
        </div>
        @endforeach

        @endif

    </div>
</div>


<!-- CTA section -->
<div class="cta-section pt-15 pt-lg-30 pb-5 pb-lg-5 bg-pattern pattern-7" style="background-color: #f2f2f2 !important;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="text-center dark-mode-texts">
                    <h2 class="gr-text-4 mb-7" style="color: #433d3d;">DOWNLOAD OUR APP</h2>

                    <a href="https://play.google.com/store/apps/details?id=com.fursee.damilare.sprint_mobile"
                        target="_blank" class="btn text-white gr-hover-y px-lg-9">
                        <img src="https://res.cloudinary.com/paysprint/image/upload/v1651130088/assets/l6-download-gplay_o9rcfj_l6erwf.png"
                            alt="play store">
                    </a>
                    <a href="https://apps.apple.com/gb/app/paysprint/id1567742130" target="_blank"
                        class="btn text-white gr-hover-y px-lg-9">
                        <img src="https://res.cloudinary.com/paysprint/image/upload/v1651130088/assets/l6-download-appstore_odcskf_atgygf.png"
                            alt="apple store">
                    </a>
                    <p class="gr-text-11 mb-0 mt-6" style="color: #433d3d;">It takes only 2 mins!</p>
                </div>

                <div class="hero-img" data-aos="fade-left" data-aos-duration="500" data-aos-once="true">
                    <div class="hero-video-thumb position-relative gr-z-index-1">
                        <center>
                            <img src="https://res.cloudinary.com/paysprint/image/upload/v1651130089/assets/paysprint_jpeg_black_bk_ft8qly_frobtx.jpg"
                                alt="" class="w-100 rounded-8"
                                style="height: 350px !important;width: 350px !important;">
                        </center>
                        <a class="video-play-trigger gr-abs-center bg-white circle-xl gr-flex-all-center gr-abs-hover-y focus-reset"
                            data-fancybox="" href="https://youtu.be/ptsmEYFJMx4" tabindex="-1"><i
                                class="icon icon-triangle-right-17-2"></i></a>
                        {{-- <div class="abs-shape gr-abs-tr-custom gr-z-index-n1">
                            <img src="{{ asset('newpage/image/l4/png/l4-hero-shape.png') }}" alt="" class="w-100"
                                data-aos="zoom-in" data-aos-delay="400" data-aos-duration="800" data-aos-once="true">
                        </div> --}}
                    </div>
                </div>

            </div>

            <div class="col-md-3">
                <center>
                    <img class="shadow-lg"
                        src="https://res.cloudinary.com/paysprint/image/upload/v1651130089/assets/image_zuxln4_kzk3zb.png"
                        alt="mobile app"
                        style="width: 100%; height: 500px; border-radius: 10px; position: relative; z-index: 1000;">
                    {{-- <img class="shadow-lg"
                        src="https://res.cloudinary.com/paysprint/image/upload/v1651130089/assets/paysprint_front_v55thg_gjjpzj.jpg"
                        alt="mobile app" style="width: 80%; border-radius: 10px; position: relative; z-index: 1000;">
                    --}}
                </center>
            </div>

        </div>
    </div>
</div>

@endsection