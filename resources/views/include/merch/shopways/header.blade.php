        <!-- header area start -->
        <section class="top-5" style="position: relative;">
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
                                                                <a href="{{ route('product shop', 'merchant=' . $data['user']->businessname) }}"
                                                                    class="link-title">
                                                                    <span class="sp-link-title">Shop</span>
                                                                    {{-- <i class="fa fa-angle-down"></i> --}}
                                                                </a>
                                                                <a href="{{ route('product shop', 'merchant=' . $data['user']->businessname) }}"
                                                                    data-bs-toggle="collapse"
                                                                    class="link-title link-title-lg disp-0">
                                                                    <span class="sp-link-title">Shop</span>
                                                                    {{-- <i class="fa fa-angle-down"></i> --}}
                                                                </a>
                                                                {{-- <ul class="dropdown-submenu mega-menu collapse disp-0"
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
                                                                </ul> --}}
                                                            </li>
                                                            <li class="menu-link parent">
                                                                <a href="{{ route('orders', 'merchant=' . $data['user']->businessname) }}"
                                                                    class="link-title">
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
                                                                <a href="{{ route('wishlist', 'merchant=' . $data['user']->businessname) }}"
                                                                    class="link-title">
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
                                                                <a href="{{ route('checkout item', 'store=' . $data['user']->businessname) }}"
                                                                    class="link-title">
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
                                                    <a href="{{ route('wishlist', 'merchant=' . $data['user']->businessname) }}"
                                                        class="header-wishlist">
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
                                    <li class="ms-3 mt-3 menu-banner-img" style="font-size: 14px; font-weight:lighter">
                                        <a href="{{ route('merchant shop now', $data['user']->businessname) }}" class="link-title">
                                            <span class="sp-link-title">HOME</span>
                                        </a>
                                    </li>
                                    <li class="ms-3 mt-3 menu-banner-img" style="font-size: 14px; font-weight:lighter">
                                        <a href="{{ route('product shop', 'merchant=' . $data['user']->businessname) }}" class="link-title">
                                            <span class="sp-link-title">SHOP</span>
                                        </a>
                                    </li>
                                    <li class="ms-3 mt-3 menu-banner-img" style="font-size: 14px; font-weight:lighter">
                                        <a href="{{ route('orders', 'merchant=' . $data['user']->businessname) }}" class="link-title">
                                            <span class="sp-link-title">ORDERS</span>
                                        </a>
                                    </li>
                                    <li class="ms-3 mt-3 menu-banner-img" style="font-size: 14px; font-weight:lighter">
                                        <a href="{{ route('wishlist', 'merchant=' . $data['user']->businessname) }}" class="link-title">
                                            <span class="sp-link-title">MY WISHLIST</span>
                                        </a>
                                    </li>
                                    <li class="ms-3 mt-3 menu-banner-img" style="font-size: 14px; font-weight:lighter">
                                        <a href="{{ route('checkout item', 'store=' . $data['user']->businessname) }}" class="link-title">
                                            <span>CHECKOUT</span>
                                       
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- mobile menu end -->
