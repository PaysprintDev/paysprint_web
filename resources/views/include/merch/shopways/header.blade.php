        <!-- header area start -->
        <section class="top-5">
            <!-- top notificationbar start -->
            <div class="container">
                <div class="row">
                    <div class="col">
                        <ul class="top-home">
                            <!-- offer text start -->
                            <li class="top-home-li t-content">
                                <p><span class="shop-offer">Welcome to</span> {{ $pages }}</p>
                            </li>
                            <!-- offer text end -->
                            <li class="top-home-li">
                                <ul class="top-dropdown">
                                    <!-- login start -->
                                    <li class="top-dropdown-li">
                                        <a href="javascript:void(0)">Account</a>
                                        <i class="ion-ios-arrow-down"></i>
                                        <ul class="account">

                                            @guest
                                                <li><a href="{{ route('login') }}">log in</a></li>
                                                <li><a href="{{ route('register') }}">register</a></li>
                                            @endguest

                                            <li><a href="#">checkout</a></li>
                                            <li><a href="#">my wishlist</a></li>
                                            <li><a href="#">order history</a></li>
                                            <li><a href="#">my cart</a></li>
                                        </ul>
                                    </li>
                                    <!-- login end -->

                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- top notificationbar start -->
            <!-- header start -->
            <header class="header-area">
                <div class="header-main-area">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <div class="header-main">
                                    <!-- logo start -->

                                    <div class="header-element logo">
                                        <a href="{{ route('merchant shop now', $data['user']->businessname) }}">
                                            <img src="{{ $data['mystore']->businessLogo }}" alt="logo-image"
                                                class="img-fluid" style="width: 70px; height: 70px;">
                                        </a>
                                    </div>
                                    <!-- logo end -->
                                    <!-- menu start -->
                                    <div class="menu-area">
                                        <div class="header-element header-menu">
                                            <div class="top-menu">
                                                <div class="header-element megamenu-content">
                                                    <div class="mainwrap">
                                                        <ul class="main-menu">
                                                            <li class="menu-link parent">
                                                                <a href="{{ route('merchant shop now', $data['user']->businessname) }}"
                                                                    class="link-title">
                                                                    <span class="sp-link-title">Home</span>
                                                                </a>

                                                            </li>
                                                            <li class="menu-link parent">
                                                                <a href="javascript:void(0)" class="link-title">
                                                                    <span class="sp-link-title">Shop</span>
                                                                    {{-- <i class="fa fa-angle-down"></i> --}}
                                                                </a>
                                                                <a href="#collapse-top-mega-menu"
                                                                    data-bs-toggle="collapse"
                                                                    class="link-title link-title-lg disp-0">
                                                                    <span class="sp-link-title">Shop</span>
                                                                    {{-- <i class="fa fa-angle-down"></i> --}}
                                                                </a>
                                                                <ul class="dropdown-submenu mega-menu collapse disp-0"
                                                                    id="collapse-top-mega-menu">
                                                                    <li class="megamenu-li parent">
                                                                        <h2 class="sublink-title">Fresh food</h2>
                                                                        <a href="#collapse-top-sub-mega-menu"
                                                                            data-bs-toggle="collapse"
                                                                            class="sublink-title sublink-title-lg">
                                                                            <span>Fresh food</span>
                                                                            <i class="fa fa-angle-down"></i>
                                                                        </a>
                                                                        <ul class="dropdown-supmenu collapse"
                                                                            id="collapse-top-sub-mega-menu">
                                                                            <li class="supmenu-li"><a href="#">Fruit
                                                                                    &
                                                                                    nut</a></li>
                                                                            <li class="supmenu-li"><a href="#">Snack
                                                                                    food</a></li>
                                                                            <li class="supmenu-li"><a
                                                                                    href="#">Organics
                                                                                    nut gifts</a></li>
                                                                            <li class="supmenu-li"><a
                                                                                    href="#">Non-dairy</a>
                                                                            </li>
                                                                            <li class="supmenu-li"><a
                                                                                    href="#">Mayonnaise</a>
                                                                            </li>
                                                                            <li class="supmenu-li"><a href="#">Milk
                                                                                    almond</a></li>
                                                                        </ul>
                                                                    </li>
                                                                    <li class="megamenu-li parent">
                                                                        <h2 class="sublink-title">Mixedfruits</h2>
                                                                        <a href="#collapse-top-fruits-menu"
                                                                            data-bs-toggle="collapse"
                                                                            class="sublink-title sublink-title-lg">
                                                                            <span>Mixedfruits</span>
                                                                            <i class="fa fa-angle-down"></i>
                                                                        </a>
                                                                        <ul class="dropdown-supmenu collapse"
                                                                            id="collapse-top-fruits-menu">
                                                                            <li class="supmenu-li"><a
                                                                                    href="#">Oranges</a>
                                                                            </li>
                                                                            <li class="supmenu-li"><a
                                                                                    href="#">Coffee
                                                                                    creamers</a></li>
                                                                            <li class="supmenu-li"><a href="#">Ghee
                                                                                    beverages</a></li>
                                                                            <li class="supmenu-li"><a href="#">Ranch
                                                                                    salad</a></li>
                                                                            <li class="supmenu-li"><a href="#">Hemp
                                                                                    milk</a></li>
                                                                            <li class="supmenu-li"><a href="#">Nuts
                                                                                    &
                                                                                    seeds</a></li>
                                                                        </ul>
                                                                    </li>
                                                                    <li class="megamenu-li parent">
                                                                        <h2 class="sublink-title">Bananas & plantains
                                                                        </h2>
                                                                        <a href="#collapse-top-banana-menu"
                                                                            data-bs-toggle="collapse"
                                                                            class="sublink-title sublink-title-lg">
                                                                            <span>Bananas & plantains</span>
                                                                            <i class="fa fa-angle-down"></i>
                                                                        </a>
                                                                        <ul class="dropdown-supmenu collapse"
                                                                            id="collapse-top-banana-menu">
                                                                            <li class="supmenu-li"><a href="#">Fresh
                                                                                    gala</a></li>
                                                                            <li class="supmenu-li"><a href="#">Fresh
                                                                                    berries</a></li>
                                                                            <li class="supmenu-li"><a href="#">Fruit
                                                                                    &
                                                                                    nut</a></li>
                                                                            <li class="supmenu-li"><a href="#">Fifts
                                                                                    mixed fruits</a></li>
                                                                            <li class="supmenu-li"><a
                                                                                    href="#">Oranges</a>
                                                                            </li>
                                                                            <li class="supmenu-li"><a
                                                                                    href="#">Oranges</a>
                                                                            </li>
                                                                        </ul>
                                                                    </li>
                                                                    <li class="megamenu-li parent">
                                                                        <h2 class="sublink-title">Apples berries</h2>
                                                                        <a href="#collapse-top-apple-menu"
                                                                            data-bs-toggle="collapse"
                                                                            class="sublink-title sublink-title-lg">
                                                                            <span>Apples berries</span>
                                                                            <i class="fa fa-angle-down"></i>
                                                                        </a>
                                                                        <ul class="dropdown-supmenu collapse"
                                                                            id="collapse-top-apple-menu">
                                                                            <li class="supmenu-li"><a href="#">Pears
                                                                                    produce</a></li>
                                                                            <li class="supmenu-li"><a
                                                                                    href="#">Bananas</a>
                                                                            </li>
                                                                            <li class="supmenu-li"><a
                                                                                    href="#">Natural
                                                                                    grassbeab</a></li>
                                                                            <li class="supmenu-li"><a href="#">Fresh
                                                                                    green orange</a></li>
                                                                            <li class="supmenu-li"><a href="#">Fresh
                                                                                    organic reachter</a></li>
                                                                            <li class="supmenu-li"><a
                                                                                    href="#">Balckberry
                                                                                    100%organic</a></li>
                                                                        </ul>
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                            <li class="menu-link parent">
                                                                <a href="javascript:void(0)" class="link-title">
                                                                    <span class="sp-link-title">Orders</span>
                                                                    {{-- <i class="fa fa-angle-down"></i> --}}
                                                                </a>
                                                                <a href="#collapse-top-banner-menu"
                                                                    data-bs-toggle="collapse"
                                                                    class="link-title link-title-lg disp-0">
                                                                    <span class="sp-link-title">Collection</span>
                                                                    <i class="fa fa-angle-down"></i>
                                                                </a>
                                                                <ul class="dropdown-submenu banner-menu collapse disp-0"
                                                                    id="collapse-top-banner-menu">
                                                                    <li class="menu-banner">
                                                                        <a href="#" class="menu-banner-img"><img
                                                                                src="image/menu-banner01.jpg"
                                                                                alt="menu-image"
                                                                                class="img-fluid"></a>
                                                                        <a href="#"
                                                                            class="menu-banner-title"><span>Bestseller</span></a>
                                                                    </li>
                                                                    <li class="menu-banner">
                                                                        <a href="#" class="menu-banner-img"><img
                                                                                src="image/menu-banner02.jpg"
                                                                                alt="menu-image"
                                                                                class="img-fluid"></a>
                                                                        <a href="#"
                                                                            class="menu-banner-title"><span>Special
                                                                                product</span></a>
                                                                    </li>
                                                                    <li class="menu-banner">
                                                                        <a href="#" class="menu-banner-img"><img
                                                                                src="image/menu-banner03.jpg"
                                                                                alt="mneu image"
                                                                                class="img-fluid"></a>
                                                                        <a href="#"
                                                                            class="menu-banner-title"><span>Featured
                                                                                product</span></a>
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                            <li class="menu-link parent">
                                                                <a href="javascript:void(0)" class="link-title">
                                                                    <span class="sp-link-title">My Wishlist</span>
                                                                    {{-- <i class="fa fa-angle-down"></i> --}}
                                                                </a>
                                                                <a href="#collapse-top-banner-menu"
                                                                    data-bs-toggle="collapse"
                                                                    class="link-title link-title-lg disp-0">
                                                                    <span class="sp-link-title">Collection</span>
                                                                    <i class="fa fa-angle-down"></i>
                                                                </a>
                                                                <ul class="dropdown-submenu banner-menu collapse disp-0"
                                                                    id="collapse-top-banner-menu">
                                                                    <li class="menu-banner">
                                                                        <a href="#" class="menu-banner-img"><img
                                                                                src="image/menu-banner01.jpg"
                                                                                alt="menu-image"
                                                                                class="img-fluid"></a>
                                                                        <a href="#"
                                                                            class="menu-banner-title"><span>Bestseller</span></a>
                                                                    </li>
                                                                    <li class="menu-banner">
                                                                        <a href="#" class="menu-banner-img"><img
                                                                                src="image/menu-banner02.jpg"
                                                                                alt="menu-image"
                                                                                class="img-fluid"></a>
                                                                        <a href="#"
                                                                            class="menu-banner-title"><span>Special
                                                                                product</span></a>
                                                                    </li>
                                                                    <li class="menu-banner">
                                                                        <a href="#" class="menu-banner-img"><img
                                                                                src="image/menu-banner03.jpg"
                                                                                alt="mneu image"
                                                                                class="img-fluid"></a>
                                                                        <a href="#"
                                                                            class="menu-banner-title"><span>Featured
                                                                                product</span></a>
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                            <li class="menu-link parent">
                                                                <a href="javascript:void(0)" class="link-title">
                                                                    <span class="sp-link-title">Checkout</span>
                                                                </a>
                                                                <a href="#collapse-top-page-menu"
                                                                    data-bs-toggle="collapse"
                                                                    class="link-title link-title-lg disp-0">
                                                                    <span class="sp-link-title">Pages</span>
                                                                    <i class="fa fa-angle-down"></i>
                                                                </a>
                                                                <ul class="dropdown-submenu sub-menu collapse disp-0"
                                                                    id="collapse-top-page-menu">
                                                                    <li class="submenu-li">
                                                                        <a href="#" class="submenu-link">About us</a>
                                                                    </li>
                                                                    <li class="submenu-li">
                                                                        <a href="javascript:void(0)"
                                                                            class="g-l-link"><span>Account</span>
                                                                            <i class="fa fa-angle-right"></i></a>
                                                                        <a href="#account-menu01"
                                                                            data-bs-toggle="collapse"
                                                                            class="sub-link"><span>Account</span>
                                                                            <i class="fa fa-angle-down"></i></a>
                                                                        <ul class="collapse blog-style-1"
                                                                            id="account-menu01">
                                                                            <li>
                                                                                <a href="#"
                                                                                    class="sub-style"><span>Order</span></a>
                                                                                <a href="#"
                                                                                    class="blog-sub-style"><span>Order</span></a>
                                                                                <a href="#"
                                                                                    class="sub-style"><span>Profile</span></a>
                                                                                <a href="#"
                                                                                    class="blog-sub-style"><span>Profile</span></a>
                                                                                <a href="#"
                                                                                    class="sub-style"><span>Address</span></a>
                                                                                <a href="#"
                                                                                    class="blog-sub-style"><span>Address</span></a>
                                                                                <a href="#"
                                                                                    class="sub-style"><span>Wishlist</span></a>
                                                                                <a href="#"
                                                                                    class="blog-sub-style"><span>Wishlist</span></a>
                                                                                <a href="#"
                                                                                    class="sub-style"><span>My
                                                                                        tickets</span></a>
                                                                                <a href="#"
                                                                                    class="blog-sub-style"><span>My
                                                                                        tickets</span></a>
                                                                            </li>
                                                                        </ul>
                                                                    </li>
                                                                    <li class="submenu-li">
                                                                        <a href="#" class="submenu-link">Billing
                                                                            info</a>
                                                                    </li>
                                                                    <li class="submenu-li">
                                                                        <a href="#"
                                                                            class="submenu-link">Cancellation</a>
                                                                    </li>
                                                                    <li class="submenu-li">
                                                                        <a href="#" class="submenu-link">Cart
                                                                            page</a>
                                                                    </li>
                                                                    <li class="submenu-li">
                                                                        <a href="#"
                                                                            class="submenu-link">Coming-soon</a>
                                                                    </li>
                                                                    <li class="submenu-li">
                                                                        <a href="#" class="submenu-link">Faq's</a>
                                                                    </li>
                                                                    <li class="submenu-li">
                                                                        <a href="#" class="submenu-link">Forgot
                                                                            passowrd</a>
                                                                    </li>
                                                                    <li class="submenu-li">
                                                                        <a href="#" class="submenu-link">Order
                                                                            complete</a>
                                                                    </li>
                                                                    <li class="submenu-li">
                                                                        <a href="#" class="submenu-link">Track
                                                                            page</a>
                                                                    </li>
                                                                    <li class="submenu-li">
                                                                        <a href="contact.html"
                                                                            class="submenu-link">Contact us</a>
                                                                    </li>
                                                                    <li class="submenu-li">
                                                                        <a href="payment-policy.html"
                                                                            class="submenu-link">Payment policy</a>
                                                                    </li>
                                                                    <li class="submenu-li">
                                                                        <a href="privacy-policy.html"
                                                                            class="submenu-link">privacy policy</a>
                                                                    </li>
                                                                    <li class="submenu-li">
                                                                        <a href="return-policy.html"
                                                                            class="submenu-link">Return policy</a>
                                                                    </li>
                                                                    <li class="submenu-li">
                                                                        <a href="#" class="submenu-link">Terms &
                                                                            conditions</a>
                                                                    </li>
                                                                    <li class="submenu-li">
                                                                        <a href="#" class="submenu-link">Wishlist</a>
                                                                    </li>
                                                                    <li class="submenu-li">
                                                                        <a href="#" class="submenu-link">Sitemap</a>
                                                                    </li>
                                                                    <li class="submenu-li">
                                                                        <a href="#" class="submenu-link">4 not 4</a>
                                                                    </li>
                                                                </ul>
                                                            </li>


                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- menu end -->
                                    <!-- header icon start -->
                                    <div class="header-element right-block-box">
                                        <ul class="shop-element">
                                            <li class="side-wrap nav-toggler">
                                                <button class="navbar-toggler" type="button" data-toggle="collapse"
                                                    data-target="#navbarContent">
                                                    <span class="line"></span>
                                                </button>
                                            </li>
                                            <li class="side-wrap search-wrap">
                                                <div class="search-rap">
                                                    <a href="#search-modal" class="search-popuup"
                                                        data-bs-toggle="modal"><i
                                                            class="ion-ios-search-strong"></i></a>
                                                </div>
                                            </li>





                                            @auth


                                                <li class="side-wrap wishlist-wrap">
                                                    <a href="#" class="header-wishlist">
                                                        <span class="wishlist-icon"><i class="icon-heart"></i></span>
                                                        <span
                                                            class="wishlist-counter">{{ count($data['mywishlist']) }}</span>
                                                    </a>
                                                </li>

                                                <li class="side-wrap cart-wrap">
                                                    <div class="shopping-widget">
                                                        <div class="shopping-cart">
                                                            <a href="javascript:void(0)" class="cart-count">
                                                                <span class="cart-icon-wrap">
                                                                    <span class="cart-icon"><i
                                                                            class="icon-handbag"></i></span>
                                                                    <span id="cart-total"
                                                                        class="bigcounter">{{ count($data['mycartlist']) }}</span>
                                                                </span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endauth


                                            @guest

                                                <li class="side-wrap wishlist-wrap">
                                                    <a href="#" class="header-wishlist">
                                                        <span class="wishlist-icon"><i class="icon-heart"></i></span>
                                                    </a>
                                                </li>

                                                <li class="side-wrap cart-wrap">
                                                    <div class="shopping-widget">
                                                        <div class="shopping-cart">
                                                            <a href="javascript:void(0)" class="cart-count">
                                                                <span class="cart-icon-wrap">
                                                                    <span class="cart-icon"><i
                                                                            class="icon-handbag"></i></span>
                                                                </span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </li>

                                                <li class="side-wrap wishlist-wrap">
                                                    <a href="{{ route('login') }}" class="header-wishlist">
                                                        <span class="wishlist-icon"><i class="icon-user"></i></span>
                                                    </a>
                                                </li>
                                            @endguest



                                        </ul>
                                    </div>
                                    <!-- header icon end -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <!-- header end -->
        </section>
        <!-- header area end -->


        <!-- mobile menu start -->
        <div class="header-bottom-area">
            <div class="main-menu-area">
                <div class="main-navigation navbar-expand-xl">
                    <div class="box-header menu-close">
                        <button class="close-box" type="button"><i class="ion-close-round"></i></button>
                    </div>
                    <div class="navbar-collapse" id="navbarContent">
                        <!-- main-menu start -->
                        <div class="megamenu-content">
                            <div class="mainwrap">
                                <ul class="main-menu">
                                    <li class="menu-link parent">
                                        <a href="javascript:void(0)" class="link-title">
                                            <span class="sp-link-title">Home</span>
                                            <i class="fa fa-angle-down"></i>
                                        </a>
                                        <a href="#collapse-home" data-bs-toggle="collapse"
                                            class="link-title link-title-lg">
                                            <span class="sp-link-title">Home</span>
                                            <i class="fa fa-angle-down"></i>
                                        </a>
                                        <ul class="dropdown-submenu sub-menu collapse" id="collapse-home">
                                            <li class="submenu-li">
                                                <a href="index1.html" class="submenu-link">Vegist home 01</a>
                                            </li>
                                            <li class="submenu-li">
                                                <a href="https://spacingtech.com/html/vegist-final/vegist-rtl/index1.html"
                                                    class="submenu-link">Vegist home 01 (RTL)</a>
                                            </li>
                                            <li class="submenu-li">
                                                <a href="https://spacingtech.com/html/vegist-final/vegist-box/index1.html"
                                                    class="submenu-link">Vegist home 01 (BOX)</a>
                                            </li>
                                            <li class="submenu-li">
                                                <a href="index2.html" class="submenu-link">Vegist home 02</a>
                                            </li>
                                            <li class="submenu-li">
                                                <a href="index3.html" class="submenu-link">Vegist home 03</a>
                                            </li>
                                            <li class="submenu-li">
                                                <a href="index4.html" class="submenu-link">Vegist home 04</a>
                                            </li>
                                            <li class="submenu-li">
                                                <a href="{{ route('merchant shop now', $pages) }}"
                                                    class="submenu-link">Vegist home 05</a>
                                            </li>
                                            <li class="submenu-li">
                                                <a href="index6.html" class="submenu-link">Vegist home 06</a>
                                            </li>
                                            <li class="submenu-li">
                                                <a href="index7.html" class="submenu-link">Vegist home 07</a>
                                            </li>
                                            <li class="submenu-li">
                                                <a href="index8.html" class="submenu-link">Vegist home 08</a>
                                            </li>
                                            <li class="submenu-li">
                                                <a href="index9.html" class="submenu-link">Vegist home 09</a>
                                            </li>
                                            <li class="submenu-li">
                                                <a href="index10.html" class="submenu-link">Vegist home 10</a>
                                            </li>
                                            <li class="submenu-li">
                                                <a href="index11.html" class="submenu-link">Vegist home 11</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="menu-link parent">
                                        <a href="javascript:void(0)" class="link-title">
                                            <span class="sp-link-title">Shop</span>
                                            <i class="fa fa-angle-down"></i>
                                        </a>
                                        <a href="#collapse-mega-menu" data-bs-toggle="collapse"
                                            class="link-title link-title-lg">
                                            <span class="sp-link-title">Shop</span>
                                            <i class="fa fa-angle-down"></i>
                                        </a>
                                        <ul class="dropdown-submenu mega-menu collapse" id="collapse-mega-menu">
                                            <li class="megamenu-li parent">
                                                <h2 class="sublink-title">Fresh food</h2>
                                                <a href="#collapse-sub-mega-menu" data-bs-toggle="collapse"
                                                    class="sublink-title sublink-title-lg">
                                                    <span>Fresh food</span>
                                                    <i class="fa fa-angle-down"></i>
                                                </a>
                                                <ul class="dropdown-supmenu collapse" id="collapse-sub-mega-menu">
                                                    <li class="supmenu-li"><a href="#">Fruit &
                                                            nut</a></li>
                                                    <li class="supmenu-li"><a href="#">Snack
                                                            food</a></li>
                                                    <li class="supmenu-li"><a href="#">Organics
                                                            nut gifts</a></li>
                                                    <li class="supmenu-li"><a href="#">Non-dairy</a></li>
                                                    <li class="supmenu-li"><a href="#">Mayonnaise</a></li>
                                                    <li class="supmenu-li"><a href="#">Milk
                                                            almond</a></li>
                                                </ul>
                                            </li>
                                            <li class="megamenu-li parent">
                                                <h2 class="sublink-title">Mixedfruits</h2>
                                                <a href="#collapse-fruits-menu" data-bs-toggle="collapse"
                                                    class="sublink-title sublink-title-lg">
                                                    <span>Mixedfruits</span>
                                                    <i class="fa fa-angle-down"></i>
                                                </a>
                                                <ul class="dropdown-supmenu collapse" id="collapse-fruits-menu">
                                                    <li class="supmenu-li"><a href="#">Oranges</a></li>
                                                    <li class="supmenu-li"><a href="#">Coffee
                                                            creamers</a></li>
                                                    <li class="supmenu-li"><a href="#">Ghee
                                                            beverages</a></li>
                                                    <li class="supmenu-li"><a href="#">Ranch
                                                            salad</a></li>
                                                    <li class="supmenu-li"><a href="#">Hemp
                                                            milk</a></li>
                                                    <li class="supmenu-li"><a href="#">Nuts &
                                                            seeds</a></li>
                                                </ul>
                                            </li>
                                            <li class="megamenu-li parent">
                                                <h2 class="sublink-title">Bananas & plantains</h2>
                                                <a href="#collapse-banana-menu" data-bs-toggle="collapse"
                                                    class="sublink-title sublink-title-lg">
                                                    <span>Bananas & plantains</span>
                                                    <i class="fa fa-angle-down"></i>
                                                </a>
                                                <ul class="dropdown-supmenu collapse" id="collapse-banana-menu">
                                                    <li class="supmenu-li"><a href="#">Fresh
                                                            gala</a></li>
                                                    <li class="supmenu-li"><a href="#">Fresh
                                                            berries</a></li>
                                                    <li class="supmenu-li"><a href="#">Fruit &
                                                            nut</a></li>
                                                    <li class="supmenu-li"><a href="#">Fifts
                                                            mixed fruits</a></li>
                                                    <li class="supmenu-li"><a href="#">Oranges</a></li>
                                                    <li class="supmenu-li"><a href="#">Oranges</a></li>
                                                </ul>
                                            </li>
                                            <li class="megamenu-li parent">
                                                <h2 class="sublink-title">Apples berries</h2>
                                                <a href="#collapse-apple-menu" data-bs-toggle="collapse"
                                                    class="sublink-title sublink-title-lg">
                                                    <span>Apples berries</span>
                                                    <i class="fa fa-angle-down"></i>
                                                </a>
                                                <ul class="dropdown-supmenu collapse" id="collapse-apple-menu">
                                                    <li class="supmenu-li"><a href="#">Pears
                                                            produce</a></li>
                                                    <li class="supmenu-li"><a href="#">Bananas</a></li>
                                                    <li class="supmenu-li"><a href="#">Natural
                                                            grassbeab</a></li>
                                                    <li class="supmenu-li"><a href="#">Fresh
                                                            green orange</a></li>
                                                    <li class="supmenu-li"><a href="#">Fresh
                                                            organic reachter</a></li>
                                                    <li class="supmenu-li"><a href="#">Balckberry 100%organic</a>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="menu-link parent">
                                        <a href="javascript:void(0)" class="link-title">
                                            <span class="sp-link-title">Collection</span>
                                            <i class="fa fa-angle-down"></i>
                                        </a>
                                        <a href="#collapse-banner-menu" data-bs-toggle="collapse"
                                            class="link-title link-title-lg">
                                            <span class="sp-link-title">Collection</span>
                                            <i class="fa fa-angle-down"></i>
                                        </a>
                                        <ul class="dropdown-submenu banner-menu collapse" id="collapse-banner-menu">
                                            <li class="menu-banner">
                                                <a href="#" class="menu-banner-img"><img src="image/menu-banner01.jpg"
                                                        alt="menu-image" class="img-fluid"></a>
                                                <a href="#" class="menu-banner-title"><span>Bestseller</span></a>
                                            </li>
                                            <li class="menu-banner">
                                                <a href="#" class="menu-banner-img"><img src="image/menu-banner02.jpg"
                                                        alt="menu-image" class="img-fluid"></a>
                                                <a href="#" class="menu-banner-title"><span>Special
                                                        product</span></a>
                                            </li>
                                            <li class="menu-banner">
                                                <a href="#" class="menu-banner-img"><img src="image/menu-banner03.jpg"
                                                        alt="mneu image" class="img-fluid"></a>
                                                <a href="#" class="menu-banner-title"><span>Featured
                                                        product</span></a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="menu-link parent">
                                        <a href="javascript:void(0)" class="link-title">
                                            <span class="sp-link-title">Pages</span>
                                            <i class="fa fa-angle-down"></i>
                                        </a>
                                        <a href="#collapse-page-menu" data-bs-toggle="collapse"
                                            class="link-title link-title-lg">
                                            <span class="sp-link-title">Pages</span>
                                            <i class="fa fa-angle-down"></i>
                                        </a>
                                        <ul class="dropdown-submenu sub-menu collapse" id="collapse-page-menu">
                                            <li class="submenu-li">
                                                <a href="#" class="submenu-link">About us</a>
                                            </li>
                                            <li class="submenu-li">
                                                <a href="javascript:void(0)"
                                                    class="g-l-link"><span>Account</span> <i
                                                        class="fa fa-angle-right"></i></a>
                                                <a href="#account-menu" data-bs-toggle="collapse"
                                                    class="sub-link"><span>Account</span> <i
                                                        class="fa fa-angle-down"></i></a>
                                                <ul class="collapse blog-style-1" id="account-menu">
                                                    <li>
                                                        <a href="#" class="sub-style"><span>Order</span></a>
                                                        <a href="#" class="blog-sub-style"><span>Order</span></a>
                                                        <a href="#" class="sub-style"><span>Profile</span></a>
                                                        <a href="#" class="blog-sub-style"><span>Profile</span></a>
                                                        <a href="#" class="sub-style"><span>Address</span></a>
                                                        <a href="#" class="blog-sub-style"><span>Address</span></a>
                                                        <a href="#" class="sub-style"><span>Wishlist</span></a>
                                                        <a href="#" class="blog-sub-style"><span>Wishlist</span></a>
                                                        <a href="#" class="sub-style"><span>My
                                                                tickets</span></a>
                                                        <a href="#" class="blog-sub-style"><span>My
                                                                tickets</span></a>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li class="submenu-li">
                                                <a href="#" class="submenu-link">Billing info</a>
                                            </li>
                                            <li class="submenu-li">
                                                <a href="#" class="submenu-link">Cancellation</a>
                                            </li>
                                            <li class="submenu-li">
                                                <a href="#" class="submenu-link">Cart page</a>
                                            </li>
                                            <li class="submenu-li">
                                                <a href="#" class="submenu-link">Coming-soon</a>
                                            </li>
                                            <li class="submenu-li">
                                                <a href="#" class="submenu-link">Faq's</a>
                                            </li>
                                            <li class="submenu-li">
                                                <a href="#" class="submenu-link">Forgot
                                                    passowrd</a>
                                            </li>
                                            <li class="submenu-li">
                                                <a href="#" class="submenu-link">Order complete</a>
                                            </li>
                                            <li class="submenu-li">
                                                <a href="#" class="submenu-link">Track page</a>
                                            </li>
                                            <li class="submenu-li">
                                                <a href="contact.html" class="submenu-link">Contact us</a>
                                            </li>
                                            <li class="submenu-li">
                                                <a href="payment-policy.html" class="submenu-link">Payment policy</a>
                                            </li>
                                            <li class="submenu-li">
                                                <a href="privacy-policy.html" class="submenu-link">privacy policy</a>
                                            </li>
                                            <li class="submenu-li">
                                                <a href="return-policy.html" class="submenu-link">Return policy</a>
                                            </li>
                                            <li class="submenu-li">
                                                <a href="#" class="submenu-link">Terms &
                                                    conditions</a>
                                            </li>
                                            <li class="submenu-li">
                                                <a href="#" class="submenu-link">Wishlist</a>
                                            </li>
                                            <li class="submenu-li">
                                                <a href="#" class="submenu-link">Sitemap</a>
                                            </li>
                                            <li class="submenu-li">
                                                <a href="#" class="submenu-link">4 not 4</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="menu-link parent">
                                        <a href="javascript:void(0)" class="link-title">
                                            <span class="sp-link-title">Blogs</span>
                                            <i class="fa fa-angle-down"></i>
                                        </a>
                                        <a href="#blog-grid-style01" data-bs-toggle="collapse"
                                            class="link-title link-title-lg">
                                            <span class="sp-link-title">Blogs</span>
                                            <i class="fa fa-angle-down"></i>
                                        </a>
                                        <ul class="dropdown-submenu sub-menu collapse" id="blog-grid-style01">
                                            <li class="submenu-li">
                                                <a href="javascript:void(0)" class="g-l-link"><span>Blog
                                                        grid</span> <i class="fa fa-angle-right"></i></a>
                                                <a href="#blog-style-03" data-bs-toggle="collapse"
                                                    class="sub-link"><span>Blog grid</span> <i
                                                        class="fa fa-angle-down"></i></a>
                                                <ul class="collapse blog-style-1" id="blog-style-03">
                                                    <li>
                                                        <a href="javascript:void(0)" class="sub-style"><span>Blog
                                                                style 1</span><i class="fa fa-angle-right"></i></a>
                                                        <a href="#grid-1" data-bs-toggle="collapse"
                                                            class="blog-sub-style"><span>Blog style 1</span><i
                                                                class="fa fa-angle-right"></i></a>
                                                        <ul class="grid-style collapse" id="grid-1">
                                                            <li><a href="blog-style-1-3-grid.html">Blog 3 grid</a></li>
                                                            <li><a href="blog-style-1-left-3-grid.html">Left blog 3
                                                                    grid</a></li>
                                                            <li><a href="blog-style-1-right-3-grid.html">Right blog 3
                                                                    grid</a></li>
                                                        </ul>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0)" class="sub-style"><span>Blog
                                                                style 2</span><i class="fa fa-angle-right"></i></a>
                                                        <a href="#grid-2" data-bs-toggle="collapse"
                                                            class="blog-sub-style"><span>Blog style 2</span><i
                                                                class="fa fa-angle-right"></i></a>
                                                        <ul class="grid-style collapse" id="grid-2">
                                                            <li><a href="blog-style-2-3-grid.html">Blog 3 grid</a></li>
                                                            <li><a href="blog-style-2-left-3-grid.html">Left blog 3
                                                                    grid</a></li>
                                                            <li><a href="blog-style-2-right-3-grid.html">Right blog 3
                                                                    grid</a></li>
                                                        </ul>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0)" class="sub-style"><span>Blog
                                                                style 3</span><i class="fa fa-angle-right"></i></a>
                                                        <a href="#grid-3" data-bs-toggle="collapse"
                                                            class="blog-sub-style"><span>Blog style 3</span><i
                                                                class="fa fa-angle-right"></i></a>
                                                        <ul class="grid-style collapse" id="grid-3">
                                                            <li><a href="blog-style-3-grid.html">Blog 3 grid</a></li>
                                                            <li><a href="blog-style-3-left-grid-blog.html">Left blog 3
                                                                    grid</a></li>
                                                            <li><a href="blog-style-3-right-grid-blog.html">Right blog 3
                                                                    grid</a></li>
                                                        </ul>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0)" class="sub-style"><span>Blog
                                                                style 4</span><i class="fa fa-angle-right"></i></a>
                                                        <a href="#grid-4" data-bs-toggle="collapse"
                                                            class="blog-sub-style"><span>Blog style 4</span><i
                                                                class="fa fa-angle-right"></i></a>
                                                        <ul class="grid-style collapse" id="grid-4">
                                                            <li><a href="blog-style-5-3-grid.html">Blog 3 grid</a></li>
                                                            <li><a href="blog-style-5-left-3-grid.html">Left blog 3
                                                                    grid</a></li>
                                                            <li><a href="blog-style-5-right-3-grid.html">Right blog 3
                                                                    grid</a></li>
                                                        </ul>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0)" class="sub-style"><span>Blog
                                                                style 5</span><i class="fa fa-angle-right"></i></a>
                                                        <a href="#grid-5" data-bs-toggle="collapse"
                                                            class="blog-sub-style"><span>Blog style 5</span><i
                                                                class="fa fa-angle-right"></i></a>
                                                        <ul class="grid-style collapse" id="grid-5">
                                                            <li><a href="blog-style-6-3-grid.html">Blog 3 grid</a></li>
                                                            <li><a href="blog-style-6-left-3-grid.html">Left blog 3
                                                                    grid</a></li>
                                                            <li><a href="blog-style-6-right-3-grid.html">Right blog 3
                                                                    grid</a></li>
                                                        </ul>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0)" class="sub-style"><span>Blog
                                                                style 6</span><i class="fa fa-angle-right"></i></a>
                                                        <a href="#grid-6" data-bs-toggle="collapse"
                                                            class="blog-sub-style"><span>Blog style 6</span><i
                                                                class="fa fa-angle-right"></i></a>
                                                        <ul class="grid-style collapse" id="grid-6">
                                                            <li><a href="blog-style-7-3-grid.html">Blog 3 grid</a></li>
                                                            <li><a href="blog-style-7-left-grid-blog.html">Left blog 3
                                                                    grid</a></li>
                                                            <li><a href="blog-style-7-right-grid-blog.html">Right blog 3
                                                                    grid</a></li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li class="submenu-li">
                                                <a href="javascript:void(0)" class="g-l-link"><span>Blog
                                                        list</span> <i class="fa fa-angle-right"></i></a>
                                                <a href="#blog-list-style" data-bs-toggle="collapse"
                                                    class="sub-link"><span>Blog list</span> <i
                                                        class="fa fa-angle-down"></i></a>
                                                <ul class="collapse blog-style-1" id="blog-list-style">
                                                    <li>
                                                        <a href="javascript:void(0)" class="sub-style"><span>Blog
                                                                style 1</span><i class="fa fa-angle-right"></i></a>
                                                        <a href="#blog-list-1" data-bs-toggle="collapse"
                                                            class="blog-sub-style"><span>Blog style 1</span><i
                                                                class="fa fa-angle-right"></i></a>
                                                        <ul class="grid-style collapse" id="blog-list-1">
                                                            <li><a href="blog-style-1-list.html">Blog list</a></li>
                                                            <li><a href="blog-style-1-left-list.html">Left blog list</a>
                                                            </li>
                                                            <li><a href="blog-style-1-right-list.html">Right blog
                                                                    list</a></li>
                                                        </ul>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0)" class="sub-style"><span>Blog
                                                                style 2</span><i class="fa fa-angle-right"></i></a>
                                                        <a href="#blog-list-2" data-bs-toggle="collapse"
                                                            class="blog-sub-style"><span>Blog style 2</span><i
                                                                class="fa fa-angle-right"></i></a>
                                                        <ul class="grid-style collapse" id="blog-list-2">
                                                            <li><a href="blog-style-2-list.html">Blog list</a></li>
                                                            <li><a href="blog-style-2-left-list.html">Left blog list</a>
                                                            </li>
                                                            <li><a href="blog-style-2-right-list.html">Right blog
                                                                    list</a></li>
                                                        </ul>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0)" class="sub-style"><span>Blog
                                                                style 3</span><i class="fa fa-angle-right"></i></a>
                                                        <a href="#blog-list-3" data-bs-toggle="collapse"
                                                            class="blog-sub-style"><span>Blog style 3</span><i
                                                                class="fa fa-angle-right"></i></a>
                                                        <ul class="grid-style collapse" id="blog-list-3">
                                                            <li><a href="blog-style-3-list.html">Blog list</a></li>
                                                            <li><a href="blog-style-3-left-list-blog.html">Left blog
                                                                    list</a></li>
                                                            <li><a href="blog-style-3-right-list-blog.html">Right blog
                                                                    list</a></li>
                                                        </ul>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0)" class="sub-style"><span>Blog
                                                                style 4</span><i class="fa fa-angle-right"></i></a>
                                                        <a href="#blog-list-4" data-bs-toggle="collapse"
                                                            class="blog-sub-style"><span>Blog style 4</span><i
                                                                class="fa fa-angle-right"></i></a>
                                                        <ul class="grid-style collapse" id="blog-list-4">
                                                            <li><a href="blog-style-5-list-blog.html">Blog list</a></li>
                                                            <li><a href="blog-style-5-left-list.html">Left blog list</a>
                                                            </li>
                                                            <li><a href="blog-style-5-right-list.html">Right blog
                                                                    list</a></li>
                                                        </ul>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0)" class="sub-style"><span>Blog
                                                                style 5</span><i class="fa fa-angle-right"></i></a>
                                                        <a href="#blog-list-5" data-bs-toggle="collapse"
                                                            class="blog-sub-style"><span>Blog style 5</span><i
                                                                class="fa fa-angle-right"></i></a>
                                                        <ul class="grid-style collapse" id="blog-list-5">
                                                            <li><a href="blog-style-6-list-blog.html">Blog list</a></li>
                                                            <li><a href="blog-style-6-left-list-blog.html">Left blog
                                                                    list</a></li>
                                                            <li><a href="blog-style-6-right-list-blog.html">Right blog
                                                                    list</a></li>
                                                        </ul>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0)" class="sub-style"><span>Blog
                                                                style 6</span><i class="fa fa-angle-right"></i></a>
                                                        <a href="#blog-list-6" data-bs-toggle="collapse"
                                                            class="blog-sub-style"><span>Blog style 6</span><i
                                                                class="fa fa-angle-right"></i></a>
                                                        <ul class="grid-style collapse" id="blog-list-6">
                                                            <li><a href="blog-style-7-list-blog.html">Blog list</a></li>
                                                            <!--list-->
                                                            <li><a href="blog-style-7-left-list-blog.html">Left blog
                                                                    list</a></li>
                                                            <!--list-->
                                                            <li><a href="blog-style-7-right-list-blog.html">Right blog
                                                                    list</a></li>
                                                            <!--list-->
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li class="submenu-li">
                                                <a href="javascript:void(0)" class="g-l-link"><span>Blog
                                                        details</span> <i class="fa fa-angle-right"></i></a>
                                                <a href="#blog-details-style" data-bs-toggle="collapse"
                                                    class="sub-link"><span>Blog Details</span> <i
                                                        class="fa fa-angle-down"></i></a>
                                                <ul class="collapse blog-style-1 ex-width" id="blog-details-style">
                                                    <li>
                                                        <a href="javascript:void(0)" class="sub-style"><span>Blog
                                                                details style 1</span><i
                                                                class="fa fa-angle-right"></i></a>
                                                        <a href="#blog-details-1" data-bs-toggle="collapse"
                                                            class="blog-sub-style"><span>Blog details style 1</span><i
                                                                class="fa fa-angle-right"></i></a>
                                                        <ul class="grid-style collapse" id="blog-details-1">
                                                            <li><a href="blog-style-1-details.html">Blog details</a>
                                                            </li>
                                                            <li><a href="blog-style-1-left-details.html">Left blog
                                                                    details</a></li>
                                                            <li><a href="blog-style-1-right-details.html">Right blog
                                                                    details</a></li>
                                                        </ul>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0)" class="sub-style"><span>Blog
                                                                details style 2</span><i
                                                                class="fa fa-angle-right"></i></a>
                                                        <a href="#blog-details-2" data-bs-toggle="collapse"
                                                            class="blog-sub-style"><span>Blog details style 2</span><i
                                                                class="fa fa-angle-right"></i></a>
                                                        <ul class="grid-style collapse" id="blog-details-2">
                                                            <li><a href="blog-style-2-details.html">Blog details</a>
                                                            </li>
                                                            <li><a href="blog-style-2-left-details.html">Left blog
                                                                    details</a></li>
                                                            <li><a href="blog-style-2-right-details.html">Right blog
                                                                    details</a></li>
                                                        </ul>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0)" class="sub-style"><span>Blog
                                                                details style 3</span><i
                                                                class="fa fa-angle-right"></i></a>
                                                        <a href="#blog-details-3" data-bs-toggle="collapse"
                                                            class="blog-sub-style"><span>Blog details style 3</span><i
                                                                class="fa fa-angle-right"></i></a>
                                                        <ul class="grid-style collapse" id="blog-details-3">
                                                            <li><a href="blog-style-3-details.html">Blog details</a>
                                                            </li>
                                                            <li><a href="blog-style-3-left-blog-details.html">Left blog
                                                                    details</a></li>
                                                            <li><a href="blog-style-3-right-blog-details.html">Right
                                                                    blog details</a></li>
                                                        </ul>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0)" class="sub-style"><span>Blog
                                                                details style 4</span><i
                                                                class="fa fa-angle-right"></i></a>
                                                        <a href="#blog-details-4" data-bs-toggle="collapse"
                                                            class="blog-sub-style"><span>Blog details style 4</span><i
                                                                class="fa fa-angle-right"></i></a>
                                                        <ul class="grid-style collapse" id="blog-details-4">
                                                            <li><a href="blog-style-5-details.html">Blog details</a>
                                                            </li>
                                                            <li><a href="blog-style-5-left-details.html">Left blog
                                                                    details</a></li>
                                                            <li><a href="blog-style-5-right-details.html">Right blog
                                                                    details</a></li>
                                                        </ul>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0)" class="sub-style"><span>Blog
                                                                details style 5</span><i
                                                                class="fa fa-angle-right"></i></a>
                                                        <a href="#blog-details-5" data-bs-toggle="collapse"
                                                            class="blog-sub-style"><span>Blog details style 5</span><i
                                                                class="fa fa-angle-right"></i></a>
                                                        <ul class="grid-style collapse" id="blog-details-5">
                                                            <li><a href="blog-style-6-details.html">Blog details</a>
                                                            </li>
                                                            <li><a href="blog-style-6-left-details-blog.html">Left blog
                                                                    details</a></li>
                                                            <li><a href="blog-style-6-right-details-blog.html">Right
                                                                    blog details</a></li>
                                                        </ul>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0)" class="sub-style"><span>Blog
                                                                details style 6</span><i
                                                                class="fa fa-angle-right"></i></a>
                                                        <a href="#blog-details-6" data-bs-toggle="collapse"
                                                            class="blog-sub-style"><span>Blog details style 6</span><i
                                                                class="fa fa-angle-right"></i></a>
                                                        <ul class="grid-style collapse" id="blog-details-6">
                                                            <li><a href="blog-style-7-details.html">Blog details</a>
                                                            </li>
                                                            <li><a href="blog-style-7-left-details.html">Left blog
                                                                    details</a></li>
                                                            <li><a href="blog-style-7-right-details.html">Right blog
                                                                    details</a></li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li class="submenu-li">
                                                <a href="javascript:void(0)" class="g-l-link"><span>Center
                                                        blog</span> <i class="fa fa-angle-right"></i></a>
                                                <a href="#center-b" data-bs-toggle="collapse"
                                                    class="sub-link"><span>Center blog</span> <i
                                                        class="fa fa-angle-down"></i></a>
                                                <ul class="collapse blog-style-1" id="center-b">
                                                    <li>
                                                        <a href="blog-style-1-center-blog.html"
                                                            class="sub-style"><span>Blog style 1</span></a>
                                                        <a href="blog-style-1-center-blog.html"
                                                            class="blog-sub-style"><span>Blog style 1</span></a>
                                                        <a href="blog-style-2-center-blog.html"
                                                            class="sub-style"><span>Blog style 2</span></a>
                                                        <a href="blog-style-2-center-blog.html"
                                                            class="blog-sub-style"><span>Blog style 2</span></a>
                                                        <a href="blog-style-3-center-blog.html"
                                                            class="sub-style"><span>Blog style 3</span></a>
                                                        <a href="blog-style-3-center-blog.html"
                                                            class="blog-sub-style"><span>Blog style 3</span></a>
                                                        <a href="blog-style-5-center-blog.html"
                                                            class="sub-style"><span>Blog style 4</span></a>
                                                        <a href="blog-style-5-center-blog.html"
                                                            class="blog-sub-style"><span>Blog style 4</span></a>
                                                        <a href="blog-style-6-center-blog.html"
                                                            class="sub-style"><span>Blog style 5</span></a>
                                                        <a href="blog-style-6-center-blog.html"
                                                            class="blog-sub-style"><span>Blog style 5</span></a>
                                                        <a href="blog-style-7-center-blog.html"
                                                            class="sub-style"><span>Blog style 6</span></a>
                                                        <a href="blog-style-7-center-blog.html"
                                                            class="blog-sub-style"><span>Blog style 6</span></a>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="menu-link parent">
                                        <a href="javascript:void(0)" class="link-title">
                                            <span class="sp-link-title">Feature</span>
                                            <i class="fa fa-angle-down"></i>
                                        </a>
                                        <a href="#feature10" data-bs-toggle="collapse"
                                            class="link-title link-title-lg">
                                            <span class="sp-link-title">Feature</span>
                                            <i class="fa fa-angle-down"></i>
                                        </a>
                                        <ul class="dropdown-submenu mega-menu collapse" id="feature10">
                                            <li class="megamenu-li parent">
                                                <h2 class="sublink-title">Header style</h2>
                                                <a href="#feature08" data-bs-toggle="collapse"
                                                    class="sublink-title sublink-title-lg">
                                                    <span>Header style</span>
                                                    <i class="fa fa-angle-down"></i>
                                                </a>
                                                <ul class="dropdown-supmenu collapse" id="feature08">
                                                    <li class="supmenu-li"><a href="header-style-1.html">Header
                                                            style 1</a></li>
                                                    <li class="supmenu-li"><a href="header-style-2.html">Header
                                                            style 2</a></li>
                                                    <li class="supmenu-li"><a href="header-style-3.html">Header
                                                            style 3</a></li>
                                                    <li class="supmenu-li"><a href="header-style-4.html">Header
                                                            style 4</a></li>
                                                    <li class="supmenu-li"><a href="header-style-5.html">Header
                                                            style 5</a></li>
                                                    <li class="supmenu-li"><a href="header-style-6.html">Header
                                                            style 6</a></li>
                                                    <li class="supmenu-li"><a href="header-style-7.html">Header
                                                            style 7</a></li>
                                                </ul>
                                            </li>
                                            <li class="megamenu-li parent">
                                                <h2 class="sublink-title">Footer style</h2>
                                                <a href="#feature07" data-bs-toggle="collapse"
                                                    class="sublink-title sublink-title-lg">
                                                    <span>Footer style</span>
                                                    <i class="fa fa-angle-down"></i>
                                                </a>
                                                <ul class="dropdown-supmenu collapse" id="feature07">
                                                    <li class="supmenu-li"><a href="footer-style-1.html">Footer
                                                            style 1</a></li>
                                                    <li class="supmenu-li"><a href="footer-style-2.html">Footer
                                                            style 2</a></li>
                                                    <li class="supmenu-li"><a href="footer-style-3.html">Footer
                                                            style 3</a></li>
                                                    <li class="supmenu-li"><a href="footer-style-4.html">Footer
                                                            style 4</a></li>
                                                    <li class="supmenu-li"><a href="footer-style-5.html">Footer
                                                            style 5</a></li>
                                                    <li class="supmenu-li"><a href="footer-style-6.html">Footer
                                                            style 6</a></li>
                                                    <li class="supmenu-li"><a href="footer-style-7.html">Footer
                                                            style 7</a></li>
                                                </ul>
                                            </li>
                                            <li class="megamenu-li parent">
                                                <h2 class="sublink-title">Product details</h2>
                                                <a href="#feature06" data-bs-toggle="collapse"
                                                    class="sublink-title sublink-title-lg">
                                                    <span>Product details</span>
                                                    <i class="fa fa-angle-down"></i>
                                                </a>
                                                <ul class="dropdown-supmenu collapse" id="feature06">
                                                    <li class="supmenu-li"><a href="product.html">Product details
                                                            style 1</a></li>
                                                    <li class="supmenu-li"><a href="product-style-2.html">Product
                                                            details style 2</a></li>
                                                    <li class="supmenu-li"><a href="product-style-3.html">Product
                                                            details style 3</a></li>
                                                    <li class="supmenu-li"><a href="product-style-4.html">Product
                                                            details style 4</a></li>
                                                    <li class="supmenu-li"><a href="product-style-5.html">Product
                                                            details style 5</a></li>
                                                    <li class="supmenu-li"><a href="#">Product
                                                            details style 6</a></li>
                                                    <li class="supmenu-li"><a href="product-style-7.html">Product
                                                            details style 7</a></li>
                                                </ul>
                                            </li>
                                            <li class="megamenu-li parent">
                                                <h2 class="sublink-title">Other style</h2>
                                                <a href="#feature05" data-bs-toggle="collapse"
                                                    class="sublink-title sublink-title-lg">
                                                    <span>Other style</span>
                                                    <i class="fa fa-angle-down"></i>
                                                </a>
                                                <ul class="dropdown-supmenu collapse" id="feature05">
                                                    <li class="supmenu-li"><a href="checkout-1.html">Checkout style
                                                            1</a></li>
                                                    <li class="supmenu-li"><a href="checkout-2.html">Checkout style
                                                            2</a></li>
                                                    <li class="supmenu-li"><a href="checkout-3.html">Checkout style
                                                            3</a></li>
                                                    <li class="supmenu-li"><a href="#">Cart style 1</a>
                                                    </li>
                                                    <li class="supmenu-li"><a href="cart-2.html">Cart style 2</a>
                                                    </li>
                                                    <li class="supmenu-li"><a href="cart-3.html">Cart style 3</a>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- mobile menu end -->
