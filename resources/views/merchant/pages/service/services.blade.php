@extends('layouts.app')

<!-- Header Top Wrap Start -->
<div class="header-top-wrap border-bottom">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <p class="text-center top-message"><a href="#">Now Hiring:</a> Are you a driven and motivated
                    1st Line IT Support Engineer?</p>
            </div>
        </div>
    </div>
</div>
<!-- Header Top Wrap End -->

@section('content')
    <div class="preloader-activate preloader-active open_tm_preloader">
        <div class="preloader-area-wrap">
            <div class="spinner d-flex justify-content-center align-items-center h-100">
                <div class="bounce1"></div>
                <div class="bounce2"></div>
                <div class="bounce3"></div>
            </div>
        </div>
    </div>















    <!-- breadcrumb-area start -->
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_box text-center">
                        <h2 class="breadcrumb-title">Our Services </h2>
                        <!-- breadcrumb-list start -->
                        <ul class="breadcrumb-list">
                            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                            <li class="breadcrumb-item active">OUr Services</li>
                        </ul>
                        <!-- breadcrumb-list end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb-area end -->












    <div id="main-wrapper">
        <div class="site-wrapper-reveal">
            <!--===========  Projects wrapper Start =============-->
            <div class="projects-wrapper section-space--ptb_100 projects-masonary-wrapper">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="section-title-wrap text-center section-space--mb_40">
                                <h3 class="heading">Proud projects that<span class="text-color-primary"> make us
                                        stand out</span></h3>
                            </div>
                            <div class="messonry-button text-center  section-space--mb_60">
                                <button data-filter="*" class="is-checked"><span class="filter-text">All</span><span
                                        class="filter-counter">6</span></button>
                                <button data-filter=".cat--1"><span class="filter-text">Cloud Services</span> <span
                                        class="filter-counter">1</span></button>
                                <button data-filter=".cat--2"><span class="filter-text">Cyber Security</span> <span
                                        class="filter-counter">3</span></button>
                                <button data-filter=".cat--3"><span class="filter-text">IT consultancy</span> <span
                                        class="filter-counter">1</span></button>
                                <button data-filter=".cat--4"><span class="filter-text">IT Security</span> <span
                                        class="filter-counter">1</span></button>
                            </div>
                        </div>
                    </div>

                    <div class="projects-case-wrap">
                        <div class="row mesonry-list">
                            <!--<div class="resizer"></div>-->
                            <div class="col-lg-4 col-md-6 cat--2">
                                <!-- Projects Wrap Start -->
                                <a href="#" class="projects-wrap style-01">
                                    <div class="projects-image-box">
                                        <div class="projects-image">
                                            <img class="img-fluid" src="assets/images/projects/case-study-01-480x298.webp"
                                                alt="">
                                        </div>
                                        <div class="content">
                                            <h6 class="heading">Mitech-Smart Vision</h6>
                                            <div class="post-categories">Cyber Security</div>
                                            <div class="text">At Mitech, we have a holistic and integrated
                                                approach towards core modernization to experience technological
                                                evolution.
                                            </div>
                                            <div class="box-projects-arrow">
                                                <span class="button-text">View case study</span>
                                                <i class="fa fa-long-arrow-right ml-1"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <!-- Projects Wrap End -->
                            </div>

                            <div class="col-lg-4 col-md-6 cat--2 ">
                                <!-- Projects Wrap Start -->
                                <a href="#" class="projects-wrap style-01">
                                    <div class="projects-image-box">
                                        <div class="projects-image">
                                            <img class="img-fluid" src="assets/images/projects/case-study-02-480x298.webp"
                                                alt="">
                                        </div>
                                        <div class="content">
                                            <h6 class="heading">Arden-Internal Networking</h6>
                                            <div class="post-categories">Cyber Security</div>
                                            <div class="text">The prospects for a company operating in this
                                                new market are varied and exciting. The potential …
                                            </div>
                                            <div class="box-projects-arrow">
                                                <span class="button-text">View case study</span>
                                                <i class="fa fa-long-arrow-right ml-1"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <!-- Projects Wrap End -->
                            </div>

                            <div class="col-lg-4 col-md-6 cat--2">
                                <!-- Projects Wrap Start -->
                                <a href="#" class="projects-wrap style-01">
                                    <div class="projects-image-box">
                                        <div class="projects-image">
                                            <img class="img-fluid" src="assets/images/projects/case-study-03-480x298.webp"
                                                alt="">
                                        </div>
                                        <div class="content">
                                            <h6 class="heading">A Freeserve case study</h6>
                                            <div class="post-categories">Cyber Security</div>
                                            <div class="text">The prospects for a company operating in this
                                                new market are varied and exciting. The potential …
                                            </div>
                                            <div class="box-projects-arrow">
                                                <span class="button-text">View case study</span>
                                                <i class="fa fa-long-arrow-right ml-1"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <!-- Projects Wrap End -->
                            </div>

                            <div class="col-lg-4 col-md-6 cat--1">
                                <!-- Projects Wrap Start -->
                                <a href="#" class="projects-wrap style-01">
                                    <div class="projects-image-box">
                                        <div class="projects-image">
                                            <img class="img-fluid" src="assets/images/projects/case-study-04-480x298.webp"
                                                alt="">
                                        </div>
                                        <div class="content">
                                            <h6 class="heading">Aqua – Research and Energy</h6>
                                            <div class="post-categories">Cyber Security</div>
                                            <div class="text">From its founding in 1990 in Cambridge in the
                                                UK, it has grown to become a major developer of digital electronic
                                                products. The company has offices around the …
                                            </div>
                                            <div class="box-projects-arrow">
                                                <span class="button-text">View case study</span>
                                                <i class="fa fa-long-arrow-right ml-1"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <!-- Projects Wrap End -->
                            </div>

                            <div class="col-lg-4 col-md-6 cat--3">
                                <!-- Projects Wrap Start -->
                                <a href="#" class="projects-wrap style-01">
                                    <div class="projects-image-box">
                                        <div class="projects-image">
                                            <img class="img-fluid" src="assets/images/projects/case-study-05-480x298.webp"
                                                alt="">
                                        </div>
                                        <div class="content">
                                            <h6 class="heading">A Sixbase typical case study</h6>
                                            <div class="post-categories">IT consultancy</div>
                                            <div class="text">Their energy, drive, and enthusiasm laid the
                                                foundations for the development of a business, which has now become one
                                                of the UK’s leading retail chains with a unique …
                                            </div>
                                            <div class="box-projects-arrow">
                                                <span class="button-text">View case study</span>
                                                <i class="fa fa-long-arrow-right ml-1"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <!-- Projects Wrap End -->
                            </div>

                            <div class="col-lg-4 col-md-6 cat--4">
                                <!-- Projects Wrap Start -->
                                <a href="#" class="projects-wrap style-01">
                                    <div class="projects-image-box">
                                        <div class="projects-image">
                                            <img class="img-fluid" src="assets/images/projects/case-study-06-480x298.webp"
                                                alt="">
                                        </div>
                                        <div class="content">
                                            <h6 class="heading">Healsoul – Technology & Health</h6>
                                            <div class="post-categories">IT Security</div>
                                            <div class="text">This case study focuses on how Bryant Homes has
                                                used information technology. It shows how using both an Intranet and the
                                                Internet together with interactive multimedia, places Bryant …
                                            </div>
                                            <div class="box-projects-arrow">
                                                <span class="button-text">View case study</span>
                                                <i class="fa fa-long-arrow-right ml-1"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <!-- Projects Wrap End -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--===========  Projects wrapper End =============-->










            <!--========== Call to Action Area Start ============-->
            <div class="cta-image-area_one section-space--ptb_80 cta-bg-image_one">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-xl-8 col-lg-7">
                            <div class="cta-content md-text-center">
                                <h3 class="heading text-white">We run all kinds of IT services that vow your <span
                                        class="text-color-secondary"> success</span></h3>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-5">
                            <div class="cta-button-group--one text-center">
                                <a href="#" class="btn btn--white btn-one"><span class="btn-icon me-2"><i
                                            class="far fa-comment-alt-dots"></i></span> Let's talk</a>
                                <a href="#" class="btn btn--secondary  btn-two"><span class="btn-icon me-2"><i
                                            class="far fa-info-circle"></i></span> Get info</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--========== Call to Action Area End ============-->

        </div>






        @include('includes.footer')







    </div>


    </div>
    <!-- End Toolbar -->
    <!--====================  scroll top ====================-->
    <a href="#" class="scroll-top" id="scroll-top">
        <i class="arrow-top fal fa-long-arrow-up"></i>
        <i class="arrow-bottom fal fa-long-arrow-up"></i>
    </a>
    <!--====================  End of scroll top  ====================-->

    <!--====================  mobile menu overlay ====================-->
    @include('includes.mobile')
    <!--====================  End of mobile menu overlay  ====================-->
@endsection
