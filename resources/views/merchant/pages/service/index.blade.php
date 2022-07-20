@extends('layouts.merch.services.app')

@section('content')
    <div id="main-wrapper">
        <div class="site-wrapper-reveal">
            <!--============ Infotechno Hero Start ============-->
            <div class="processing-hero processing-hero-bg">
                <div class="container">
                    <div class="row align-items-center">
                        <!--baseline-->
                        <div class="col-lg-8 col-md-7">
                            <div class="processing-hero-text wow move-up">
                                <h6>
                                    @isset($data['myServiceStore']->businessWelcome)
                                    {{ $data['myServiceStore']->businessWelcome }}
                                    @else
                                    IT Software and design
                                    @endisset

                                     </h6>
                                <h1 class="font-weight--reguler mb-15">

                                    @isset($data['myServiceStore']->businessWhatWeAre)
                                    {{ $data['myServiceStore']->businessWhatWeAre }}
                                        @else
                                    Virtual technology in a
                                    <span
                                        class="text-color-secondary">Refined IT System</span>
                                    @endisset


                                    </h1>
                                <p>

                                    @isset($data['myServiceStore']->businessSlogan)
                                    {{ $data['myServiceStore']->businessSlogan }}
                                        @else
                                   Set the trends for desktop & server virtualization technology
                                    @endisset


                                </p>
                                <div class="hero-button mt-30">

                                    @isset($data['myServiceStore']->website)
                                    <a href="{{ $data['myServiceStore']->website }}" target="_blank" class="btn btn--secondary">Visit our website</a>
                                    @endif

                                    @isset($data['myServiceStore']->youtubeLink)
                                    <div class="hero-popup-video video-popup">
                                        <a  href="{{ $data['myServiceStore']->youtubeLink }}" class="video-link">
                                            <div class="video-content">
                                                <div class="video-play">
                                                    <span class="video-play-icon">
                                                        <i class="fa fa-play"></i>
                                                    </span>
                                                </div>
                                                <div class="video-text"> How we work</div>
                                            </div>
                                        </a>
                                    </div>
                                    @endif


                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-5 ">
                            <div class="processing-hero-images-wrap wow move-up">
                                <div class="processing-hero-images">

                                    @isset($data['myServiceStore']->aboutImportantImage)
                                        <img class="img-fluid" src="{{ asset('merchantassets/service/assets/images/hero/slider-processing-slide-01-image-01.webp') }}"
                                        alt="">
                                        @else
                                    <img class="img-fluid" src="{{ asset('merchantassets/service/assets/images/hero/slider-processing-slide-01-image-01.webp') }}"
                                        alt="">
                                        @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--============ Infotechno Hero End ============-->
            <!--====================  Accordion area ====================-->
            <div class="accordion-wrapper section-space--ptb_100">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <div class="faq-wrapper faq-custom-col">

                                <div class="section-title section-space--mb_40">
                                    <h6 class="section-sub-title mb-20">Our company</h6>



                                    <h3 class="heading">

                                        @isset($data['myServiceStore']->aboutUs)
                                        {!! $data['myServiceStore']->aboutUs !!}

                                        @else

                                        Share the joy of achieving <span class="text-color-primary">
                                            glorious moments</span> & climb up the top.
                                        @endif


                                    </h3>

                                </div>

                                <div id="accordion">

                                    @isset($data['myServiceStore']->aboutUsQ1)
                                    <div class="card">
                                        <div class="card-header" id="headingOne">
                                            <h5 class="mb-0">
                                                <button class="btn-link" data-bs-toggle="collapse"
                                                    data-bs-target="#collapseOne" aria-expanded="true"
                                                    aria-controls="collapseOne">

                                                    {{ $data['myServiceStore']->aboutUsQ1 }} <span> <i
                                                            class="fas fa-chevron-down"></i>
                                                        <i class="fas fa-chevron-up"></i> </span>
                                                </button>
                                            </h5>
                                        </div>

                                        <div id="collapseOne" class="show" aria-labelledby="headingOne"
                                            data-bs-parent="#accordion">
                                            <div class="card-body">
                                                <p>{{ $data['myServiceStore']->aboutUsA1 }} </p>
                                            </div>
                                        </div>
                                    </div>

                                    @endisset

                                    @isset($data['myServiceStore']->aboutUsQ2)
                                    <div class="card">
                                        <div class="card-header" id="headingTwo">
                                            <h5 class="mb-0">
                                                <button class="btn-link collapsed" data-bs-toggle="collapse"
                                                    data-bs-target="#collapseTwo" aria-expanded="false"
                                                    aria-controls="collapseTwo">
                                                    {{ $data['myServiceStore']->aboutUsQ2 }}<span> <i
                                                            class="fas fa-chevron-down"></i>
                                                        <i class="fas fa-chevron-up"></i> </span>
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                            data-bs-parent="#accordion">
                                            <div class="card-body">
                                                <p>{{ $data['myServiceStore']->aboutUsA2 }} </p>
                                            </div>
                                        </div>
                                    </div>
                                    @endisset

                                    @isset($data['myServiceStore']->aboutUsQ3)
                                    <div class="card">
                                        <div class="card-header" id="headingThree">
                                            <h5 class="mb-0">
                                                <button class="btn-link collapsed" data-bs-toggle="collapse"
                                                    data-bs-target="#collapseThree" aria-expanded="false"
                                                    aria-controls="collapseThree">
                                                    {{ $data['myServiceStore']->aboutUsQ3 }} <span> <i
                                                            class="fas fa-chevron-down"></i>
                                                        <i class="fas fa-chevron-up"></i> </span>
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                                            data-bs-parent="#accordion">
                                            <div class="card-body">
                                                <p>{{ $data['myServiceStore']->aboutUsA3 }} </p>
                                            </div>
                                        </div>
                                    </div>
                                    @endisset

                                </div>

                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="rv-video-section">

                                <div class="ht-banner-01 ">
                                    <img class="img-fluid border-radus-5 animation_images one wow fadeInDown"
                                        src="/merchantassets/service/assets/images/banners/home-processing-video-intro-slider-slide-01-image-02.webp"
                                        alt="">
                                </div>

                                <div class="ht-banner-02">
                                    <img class="img-fluid border-radus-5 animation_images two wow fadeInDown"
                                        src="/merchantassets/service/assets/images/banners/home-processing-video-intro-slider-slide-01-image-03.webp"
                                        alt="">
                                </div>

                                <div class="main-video-box video-popup">
                                    <a href="https://www.youtube.com/watch?v=9No-FiEInLA" class="video-link  mt-30">
                                        <div class="single-popup-wrap">
                                            <img class="img-fluid border-radus-5"
                                                src="/merchantassets/service/assets/images/banners/home-processing-video-intro-slider-slide-01-image-01.webp"
                                                alt="">
                                            <div class="ht-popup-video video-button">
                                                <div class="video-mark">
                                                    <div class="wave-pulse wave-pulse-1"></div>
                                                    <div class="wave-pulse wave-pulse-2"></div>
                                                </div>
                                                <div class="video-button__two">
                                                    <div class="video-play">
                                                        <span class="video-play-icon"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>


                                <div class="ht-banner-03">
                                    <img class="img-fluid border-radus-5 animation_images three wow fadeInDown"
                                        src="/merchantassets/service/assets/images/banners/home-processing-video-intro-slider-slide-01-image-04.webp"
                                        alt="">
                                </div>

                                <div class="ht-banner-04">
                                    <img class="img-fluid border-radus-5 animation_images four wow fadeInDown"
                                        src="/merchantassets/service/assets/images/banners/home-processing-video-intro-slider-slide-01-image-05.webp"
                                        alt="">
                                </div>


                            </div>
                        </div>



                    </div>
                </div>
            </div>
            <!--====================  Accordion area  ====================-->

            <!--===========  feature-images-wrapper  Start =============-->
            <div class="feature-images-wrapper bg-gray section-space--ptb_100">
                <div class="container">

                    <div class="row">
                        <div class="col-lg-12">
                            <!-- section-title-wrap Start -->
                            <div class="section-title-wrap text-center section-space--mb_10">
                                <h6 class="section-sub-title mb-20">Our services</h6>
                                <h3 class="heading">For your very specific industry, <br> we have <span
                                        class="text-color-primary"> highly-tailored IT solutions.</span></h3>
                            </div>
                            <!-- section-title-wrap Start -->
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="feature-images__two small-mt__10">
                                <div class="modern-grid-image-box row row--30">

                                    <div
                                        class="single-item wow move-up col-lg-4 col-md-6 section-space--mt_60  small-mt__40">
                                        <!-- ht-box-icon Start -->
                                        <a href="#" class="ht-box-images style-02">
                                            <div class="image-box-wrap">
                                                <div class="box-image">
                                                    <img class="img-fulid"
                                                        src="/merchantassets/service/assets/images/icons/mitech-processing-service-image-01-80x83.webp"
                                                        alt="">
                                                </div>
                                                <div class="content">
                                                    <h6 class="heading">Backup and recovery </h6>
                                                </div>
                                            </div>
                                        </a>
                                        <!-- ht-box-icon End -->
                                    </div>

                                    <div class="single-item wow move-up col-lg-4 col-md-6 section-space--mt_60">
                                        <!-- ht-box-icon Start -->
                                        <a href="#" class="ht-box-images style-02">
                                            <div class="image-box-wrap">
                                                <div class="box-image">
                                                    <img class="img-fulid"
                                                        src="/merchantassets/service/assets/images/icons/mitech-processing-service-image-02-80x83.webp"
                                                        alt="">
                                                </div>
                                                <div class="content">
                                                    <h6 class="heading">Cloud Managed Services</h6>
                                                </div>
                                            </div>
                                        </a>
                                        <!-- ht-box-icon End -->
                                    </div>

                                    <div class="single-item wow move-up col-lg-4 col-md-6 section-space--mt_60">
                                        <!-- ht-box-icon Start -->
                                        <a href="#" class="ht-box-images style-02">
                                            <div class="image-box-wrap">
                                                <div class="box-image">
                                                    <img class="img-fulid"
                                                        src="/merchantassets/service/assets/images/icons/mitech-processing-service-image-03-80x83.webp"
                                                        alt="">
                                                </div>
                                                <div class="content">
                                                    <h6 class="heading">IT Security & Compliance</h6>
                                                </div>
                                            </div>
                                        </a>
                                        <!-- ht-box-icon End -->
                                    </div>

                                    <div class="single-item wow move-up col-lg-4 col-md-6 section-space--mt_60">
                                        <!-- ht-box-icon Start -->
                                        <a href="#" class="ht-box-images style-02">
                                            <div class="image-box-wrap">
                                                <div class="box-image">
                                                    <img class="img-fulid"
                                                        src="/merchantassets/service/assets/images/icons/mitech-processing-service-image-04-80x83.webp"
                                                        alt="">
                                                </div>
                                                <div class="content">
                                                    <h6 class="heading">Software Development</h6>
                                                </div>
                                            </div>
                                        </a>
                                        <!-- ht-box-icon End -->
                                    </div>

                                    <div class="single-item wow move-up col-lg-4 col-md-6 section-space--mt_60">
                                        <!-- ht-box-icon Start -->
                                        <a href="#" class="ht-box-images style-02">
                                            <div class="image-box-wrap">
                                                <div class="box-image">
                                                    <img class="img-fulid"
                                                        src="/merchantassets/service/assets/images/icons/mitech-processing-service-image-05-80x83.webp"
                                                        alt="">
                                                </div>
                                                <div class="content">
                                                    <h6 class="heading">Managed IT Services</h6>
                                                </div>
                                            </div>
                                        </a>
                                        <!-- ht-box-icon End -->
                                    </div>

                                    <div class="single-item wow move-up col-lg-4 col-md-6 section-space--mt_60">
                                        <!-- ht-box-icon Start -->
                                        <a href="#" class="ht-box-images style-02">
                                            <div class="image-box-wrap">
                                                <div class="box-image">
                                                    <img class="img-fulid"
                                                        src="/merchantassets/service/assets/images/icons/mitech-processing-service-image-06-80x83.webp"
                                                        alt="">
                                                </div>
                                                <div class="content">
                                                    <h6 class="heading">IT consultancy</h6>
                                                </div>
                                            </div>
                                        </a>
                                        <!-- ht-box-icon End -->
                                    </div>

                                </div>
                            </div>

                            <div class="section-under-heading text-center section-space--mt_60">Challenges are just
                                opportunities in disguise. <a href="#">Take the challenge!</a></div>

                        </div>
                    </div>
                </div>
            </div>
            <!--===========  feature-images-wrapper  End =============-->









            <!--========= Pricing Table Area Start ==========-->
            <div class="pricing-table-area section-space--pb_70 p-5 bg-gradient">
                <div class="pricing-table-title-area position-relative">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="section-title-wrapper text-center section-space--mb_60 wow move-down">
                                    <h6 class="section-sub-title mb-20">Pricing and plan</h6>
                                    <h3 class="section-title">1 monthly fee for <span class="text-color-primary">all
                                            IT
                                            services.</span> </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pricing-table-content-area">
                    <div class="container">
                        <div class="row pricing-table-one">
                            <div class="col-12 col-md-6 col-lg-4 col-xl-4 pricing-table wow move-up">
                                <div class="pricing-table__inner">
                                    <div class="pricing-table__header">
                                        <h6 class="sub-title">Basic</h6>
                                        <div class="pricing-table__image">
                                            <img src="/merchantassets/service/assets/images/icons/mitech-pricing-box-icon-01-90x90.webp"
                                                class="img-fluid" alt="">
                                        </div>
                                        <div class="pricing-table__price-wrap">
                                            <h6 class="currency">$</h6>
                                            <h6 class="price">19</h6>
                                            <h6 class="period">/mo</h6>
                                        </div>
                                    </div>
                                    <div class="pricing-table__body">
                                        <div class="pricing-table__footer">
                                            <a href="#" class="ht-btn ht-btn-md ht-btn--outline">Order now</a>
                                        </div>
                                        <ul class="pricing-table__list text-left">
                                            <li>03 projects</li>
                                            <li>Quality &amp; Customer Experience</li>
                                            <li><span class="featured">Try for free, forever!</span></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="col-12 col-md-6 col-lg-4 col-xl-4 pricing-table pricing-table--popular wow move-up">
                                <div class="pricing-table__inner">
                                    <div class="pricing-table__feature-mark">
                                        <span>Popular Choice</span>
                                    </div>
                                    <div class="pricing-table__header">
                                        <h6 class="sub-title">Professional</h6>
                                        <div class="pricing-table__image">
                                            <img src="/merchantassets/service/assets/images/icons/mitech-pricing-box-icon-02-88x88.webp"
                                                class="img-fluid" alt="">
                                        </div>
                                        <div class="pricing-table__price-wrap">
                                            <h6 class="currency">$</h6>
                                            <h6 class="price">59</h6>
                                            <h6 class="period">/mo</h6>
                                        </div>
                                    </div>
                                    <div class="pricing-table__body">
                                        <div class="pricing-table__footer">
                                            <a href="#" class="ht-btn  ht-btn-md ">Order now</a>
                                        </div>
                                        <ul class="pricing-table__list text-left">
                                            <li>Unlimited project</li>
                                            <li>Power And Predictive Dialing</li>
                                            <li>Quality &amp; Customer Experience</li>
                                            <li>24/7 phone and email support</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4 col-xl-4 pricing-table wow move-up">
                                <div class="pricing-table__inner">
                                    <div class="pricing-table__header">
                                        <h6 class="sub-title">Professional</h6>
                                        <div class="pricing-table__image">
                                            <img src="/merchantassets/service/assets/images/icons/mitech-pricing-box-icon-03-90x90.webp"
                                                class="img-fluid" alt="">
                                        </div>
                                        <div class="pricing-table__price-wrap">
                                            <h6 class="currency">$</h6>
                                            <h6 class="price">29</h6>
                                            <h6 class="period">/mo</h6>
                                        </div>
                                    </div>
                                    <div class="pricing-table__body">
                                        <div class="pricing-table__footer">
                                            <a href="#" class="ht-btn ht-btn-md ht-btn--outline">Order now</a>
                                        </div>
                                        <ul class="pricing-table__list text-left">
                                            <li>10 projects</li>
                                            <li>Power And Predictive Dialing </li>
                                            <li>Quality &amp; Customer Experience </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--========= Pricing Table Area End ==========-->




            <!--====================  testimonial section ====================-->
            <div class="testimonial-slider-area bg-gray section-space--ptb_100">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="section-title-wrap text-center section-space--mb_40">
                                <h6 class="section-sub-title mb-20">Testimonials</h6>
                                <h3 class="heading">What do people praise about <span class="text-color-primary">
                                        Mitech?</span></h3>
                            </div>
                            <div class="testimonial-slider">
                                <div class="swiper-container testimonial-slider__container">
                                    <div class="swiper-wrapper testimonial-slider__wrapper">
                                        <div class="swiper-slide">
                                            <div class="testimonial-slider__one wow move-up">

                                                <div class="testimonial-slider--info">
                                                    <div class="testimonial-slider__media">
                                                        <img src="/merchantassets/service/assets/images/testimonial/mitech-testimonial-avata-02-90x90.webp"
                                                            class="img-fluid" alt="">
                                                    </div>

                                                    <div class="testimonial-slider__author">
                                                        <div class="testimonial-rating">
                                                            <span class="fa fa-star"></span>
                                                            <span class="fa fa-star"></span>
                                                            <span class="fa fa-star"></span>
                                                            <span class="fa fa-star"></span>
                                                            <span class="fa fa-star"></span>
                                                        </div>
                                                        <div class="author-info">
                                                            <h6 class="name">Abbie Ferguson</h6>
                                                            <span class="designation">Marketing</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="testimonial-slider__text">I’ve been working with over 35 IT
                                                    companies on more than 200 projects of our company, but @Mitech is
                                                    one of the most impressive to me.</div>

                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="testimonial-slider__one wow move-up">

                                                <div class="testimonial-slider--info">
                                                    <div class="testimonial-slider__media">
                                                        <img src="/merchantassets/service/assets/images/testimonial/mitech-testimonial-avata-03-90x90.webp"
                                                            class="img-fluid" alt="">
                                                    </div>

                                                    <div class="testimonial-slider__author">
                                                        <div class="testimonial-rating">
                                                            <span class="fa fa-star"></span>
                                                            <span class="fa fa-star"></span>
                                                            <span class="fa fa-star"></span>
                                                            <span class="fa fa-star"></span>
                                                            <span class="fa fa-star"></span>
                                                        </div>
                                                        <div class="author-info">
                                                            <h6 class="name">Monica Blews</h6>
                                                            <span class="designation">Web designer</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="testimonial-slider__text">I’ve been working with over 35 IT
                                                    companies on more than 200 projects of our company, but @Mitech is
                                                    one of the most impressive to me.</div>

                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="testimonial-slider__one wow move-up">

                                                <div class="testimonial-slider--info">
                                                    <div class="testimonial-slider__media">
                                                        <img src="/merchantassets/service/assets/images/testimonial/mitech-testimonial-avata-04-90x90.webp"
                                                            class="img-fluid" alt="">
                                                    </div>

                                                    <div class="testimonial-slider__author">
                                                        <div class="testimonial-rating">
                                                            <span class="fa fa-star"></span>
                                                            <span class="fa fa-star"></span>
                                                            <span class="fa fa-star"></span>
                                                            <span class="fa fa-star"></span>
                                                            <span class="fa fa-star"></span>
                                                        </div>
                                                        <div class="author-info">
                                                            <h6 class="name">Abbie Ferguson</h6>
                                                            <span class="designation">WEB DESIGNER</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="testimonial-slider__text">I’ve been working with over 35 IT
                                                    companies on more than 200 projects of our company, but @Mitech is
                                                    one of the most impressive to me.</div>

                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="testimonial-slider__one wow move-up">

                                                <div class="testimonial-slider--info">
                                                    <div class="testimonial-slider__media">
                                                        <img src="/merchantassets/service/assets/images/testimonial/mitech-testimonial-avata-01-90x90.webp"
                                                            class="img-fluid" alt="">
                                                    </div>

                                                    <div class="testimonial-slider__author">
                                                        <div class="testimonial-rating">
                                                            <span class="fa fa-star"></span>
                                                            <span class="fa fa-star"></span>
                                                            <span class="fa fa-star"></span>
                                                            <span class="fa fa-star"></span>
                                                            <span class="fa fa-star"></span>
                                                        </div>
                                                        <div class="author-info">
                                                            <h6 class="name">Abbie Ferguson</h6>
                                                            <span class="designation">WEB DESIGNER</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="testimonial-slider__text">I’ve been working with over 35 IT
                                                    companies on more than 200 projects of our company, but @Mitech is
                                                    one of the most impressive to me.</div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-pagination swiper-pagination-t01 section-space--mt_30"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--====================  End of testimonial section  ====================-->



            <!--============ Contact Us Area Start =================-->
            <div class="contact-us-area service-contact-bg section-space--ptb_100">
                <div class="container">
                    <div class="row align-items-center">

                        <div class="col-lg-4">
                            <div class="contact-info sytle-one service-contact text-left">

                                <div class="contact-info-title-wrap text-center">
                                    <h3 class="heading text-white mb-10">4.9/5.0</h3>
                                    <div class="ht-star-rating lg-style">
                                        <span class="fa fa-star"></span>
                                        <span class="fa fa-star"></span>
                                        <span class="fa fa-star"></span>
                                        <span class="fa fa-star"></span>
                                        <span class="fa fa-star"></span>
                                    </div>
                                    <p class="sub-text">by 700+ customers for 3200+ clients</p>
                                </div>

                                <div class="contact-list-item">
                                    <a href="tel:190068668" class="single-contact-list">
                                        <div class="content-wrap">
                                            <div class="content">
                                                <div class="icon">
                                                    <span class="fal fa-phone"></span>
                                                </div>
                                                <div class="main-content">
                                                    <h6 class="heading">Call for advice now!</h6>
                                                    <div class="text">1900 68668</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="mailto:hello@mitech.com" class="single-contact-list">
                                        <div class="content-wrap">
                                            <div class="content">
                                                <div class="icon">
                                                    <span class="fal fa-envelope"></span>
                                                </div>
                                                <div class="main-content">
                                                    <h6 class="heading">Say hello</h6>
                                                    <div class="text">hello@mitech.com</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                            </div>
                        </div>

                        <div class="col-lg-7 ms-auto">
                            <div class="contact-form-service-wrap">
                                <div class="contact-title text-center section-space--mb_40">
                                    <h3 class="mb-10">Need a hand?</h3>
                                    <p class="text">Reach out to the world’s most reliable IT services.</p>
                                </div>

                                <!-- <form class="contact-form" id="contact-form-2" action="https://whizthemes.com/mail-php/jowel/mitech/php/services-mail.php" method="post"> -->
                                <form class="contact-form" id="contact-form-2"
                                    action="https://htmldemo.net/mitech//merchantassets/service/assets/php/services-mail.php"
                                    method="post">
                                    <div class="contact-form__two">
                                        <div class="contact-input">
                                            <div class="contact-inner">
                                                <input name="con_name" type="text" placeholder="Name *">
                                            </div>
                                            <div class="contact-inner">
                                                <input name="con_email" type="email" placeholder="Email *">
                                            </div>
                                        </div>
                                        <div class="contact-select">
                                            <div class="form-item contact-inner">
                                                <span class="inquiry">
                                                    <select id="Visiting" name="Visiting">
                                                        <option disabled selected>Select Department to email</option>
                                                        <option value="Your inquiry about">Your inquiry about</option>
                                                        <option value="General Information Request">General Information
                                                            Request
                                                        </option>
                                                        <option value="Partner Relations">Partner Relations</option>
                                                        <option value="Careers">Careers</option>
                                                        <option value="Software Licencing">Software Licencing</option>
                                                    </select>

                                                </span>
                                            </div>
                                        </div>
                                        <div class="contact-inner contact-message">
                                            <textarea name="con_message" placeholder="Please describe what you need."></textarea>
                                        </div>
                                        <div class="comment-submit-btn">
                                            <button class="ht-btn ht-btn-md" type="submit">Send message</button>
                                            <p class="form-messege-2"></p>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
            <!--============ Contact Us Area End =================-->
        </div>
    </div>
    <!--====================  scroll top ====================-->
    <a href="#" class="scroll-top" id="scroll-top">
        <i class="arrow-top fal fa-long-arrow-up"></i>
        <i class="arrow-bottom fal fa-long-arrow-up"></i>
    </a>
    <!--====================  End of scroll top  ====================-->
@endsection
