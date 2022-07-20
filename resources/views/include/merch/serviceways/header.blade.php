<!--====================  header area ====================-->
<div class="header-area">



    <div class="header-bottom-wrap header-sticky bg-white">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="header position-relative">
                        <!-- brand logo -->
                        <div class="header__logo">




                            <a href="{{ route('merchant service now', $data['user']->businessname) }}">

                                @isset($data['myServiceStore']->businessLogo)
                                    <img src="{{ $data['myServiceStore']->businessLogo }}"
                                        style="width: 60px; height: 60px; border-radius: 10px" class="img-fluid"
                                        alt="">
                                @else
                                    <img src="https://res.cloudinary.com/paysprint/image/upload/v1650628016/assets/pay_sprint_black_horizotal_fwqo6q_ekpq1g.png"
                                        style="width: 60px; height: 60px; border-radius: 10px" class="img-fluid"
                                        alt="">
                                    @endif

                                </a>



                            </div>

                            <div class="header-right">

                                <!-- navigation menu -->
                                <div class="header__navigation menu-style-three d-none d-xl-block">
                                    <nav class="navigation-menu">

                                        <ul>
                                            <li class="">
                                                <a href="{{ route('merchant service now', $data['user']->businessname) }}"><span>Home</span></a>

                                            </li>
                                            <li class="">
                                                <a href="#"><span>Our Services</span></a>
                                            </li>
                                            <li class="">
                                                <a href="#"><span>Plan & pricing </span></a>

                                            </li>
                                            <li class="">
                                                <a href="#"><span>Order</span></a>

                                            </li>
                                            <li class=" ">
                                                <a href="#"><span>Check Out</span></a>
                                            </li>

                                        </ul>
                                    </nav>
                                </div>

                                {{-- <div class="header-search-form-two">
                                <form action="#" class="search-form-top-active">
                                    <div class="search-icon" id="search-overlay-trigger">
                                        <a href="javascript:void(0)">
                                            <i class="fa fa-search"></i>
                                        </a>
                                    </div>
                                </form>
                            </div> --}}

                                <div class="header-search-form-two d-none">
                                    <form action="#" class="search-form-top-active">
                                        <div class="search-icon">
                                            <a href="javascript:void(0)" class="position-relative">
                                                <i class="fa fa-heart"></i>
                                                <span
                                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                                    1
                                                </span>
                                            </a>
                                        </div>
                                    </form>
                                </div>

                                <div class="header-search-form-two d-none">
                                    <form action="#" class="search-form-top-active">
                                        <div class="search-icon">
                                            <a href="javascript:void(0)" class="position-relative">
                                                <i class="fa fa-shopping-cart"></i>
                                                <span
                                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success">
                                                    9
                                                </span>
                                            </a>
                                        </div>
                                    </form>
                                </div>




                                <!-- mobile menu -->
                                <div class="mobile-navigation-icon d-block d-xl-none" id="mobile-menu-trigger">
                                    <i></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <!--====================  End of header area  ====================-->
