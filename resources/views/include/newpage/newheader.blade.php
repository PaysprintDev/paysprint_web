
{{-- <header class="site-header site-header--menu-left pt-5 pb-5 site-header--absolute">
    <div class="container-fluid pr-lg-9 pl-lg-9">
        <nav class="navbar site-navbar offcanvas-active navbar-expand-lg  px-0 fixed-top"
            style="background-color: #f4f7fa;">
            <div class="brand-logo">
                <a @guest href="{{ route('merchant home') }}" @endguest @auth href="{{ route('merchant home') }}"
                    @endauth><img src="{{ asset('images/paysprint_logo/merchant.png') }}" class="light-version-logo "
                        style="width: 200px; height: inherit;"></a>
            </div>
            <div class="collapse navbar-collapse" id="mobile-menu">
                <div class="navbar-nav-wrapper">
                    <ul class="navbar-nav main-menu">

                       

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('merchant home') }}" 
                                href="{{ route('Admin') }}"role="button" aria-expanded="false">HOME</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('about') }}" role="button" aria-expanded="false">ABOUT
                                US</a>
                        </li>



                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('pricing structure merchant') }}" role="button"
                                aria-expanded="false">PRICING</a>
                        </li>


                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('display country') }}" role="button"
                                aria-expanded="false">SEARCH COUNTRY</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="https://www.paysprintmarketplace.com" target="_blank"
                                role="button" aria-expanded="false">MARKETPLACE</a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('use case')}}" role="button"
                                aria-expanded="false">USE CASES</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('AdminLogin') }}" role="button"
                                aria-expanded="false">LOGIN</a>
                        </li>

                        
                        

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('AdminRegister') }}" role="button"
                                aria-expanded="false">SIGN UP FOR FREE</a>
                        </li>


                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}"
                                style="color: #000000 !important; text-decoration: underline; background-color: #e8aa07; border-radius: 10px; font-size: 17px; padding: 5px;">{{
                                'Personal Account? ' . strtoupper(' CLICK HERE') }}</a>
                        </li>

                    </ul>
                </div>
                <button class="d-block d-lg-none offcanvas-btn-close" type="button" data-toggle="collapse"
                    data-target="#mobile-menu" aria-controls="mobile-menu" aria-expanded="true"
                    aria-label="Toggle navigation">
                    <i class="gr-cross-icon"></i>
                </button>
            </div>
        </nav>
    </div>
</header>    --}}

<header class="site-header site-header--menu-left pt-5 pb-5 site-header--absolute">
    <div class="container-fluid pr-lg-9 pl-lg-9">
        <nav class="navbar site-navbar offcanvas-active navbar-expand-lg px-0 fixed-top"
            style="background-color: #fbfbfb;">
            <!-- Brand Logo-->
            <div class="brand-logo">

                <a @guest href="{{ route('home') }}" @endguest @auth href="{{ route('user home') }}" @endauth><img
                        src="{{ asset('images/paysprint_logo/money-transfer.png') }}" class="light-version-logo "
                        style="width: 200px; height: inherit;"></a>
            </div>
            <div class="collapse navbar-collapse" id="mobile-menu">
                <div class="navbar-nav-wrapper">
                    <ul class="navbar-nav main-menu">

                        <li class="nav-item">
                            <a class="nav-link" @guest href="{{ route('home') }}" @endguest @auth
                                href="{{ route('user home') }}" @endauth role="button" aria-expanded="false">HOME</a>
                        </li>

                        @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('about') }}" role="button" aria-expanded="false">ABOUT
                                US</a>
                        </li>



                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('pricing structure') }}" role="button"
                                aria-expanded="false">PRICING</a>
                        </li>


                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('display country merchant') }}" role="button"
                                aria-expanded="false">SEARCH COUNTRY</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="https://www.paysprintmarketplace.com" target="_blank"
                                role="button" aria-expanded="false">MARKETPLACE</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{route('use case')}}" role="button"
                                aria-expanded="false">USE CASES</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('AdminLogin') }}" role="button"
                                aria-expanded="false">LOGIN</a>
                        </li>

                        
                        

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('AdminRegister') }}" role="button"
                                aria-expanded="false">SIGN UP FOR FREE</a>
                        </li>


                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}"
                                style="color: #000000 !important; text-decoration: underline; background-color: #e8aa07; border-radius: 10px; font-size: 17px; padding: 5px;">{{
                                'Personal Account? ' . strtoupper(' CLICK HERE') }}</a>
                        </li>


                        @endguest


                        @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('my account') }}" role="button" aria-expanded="false">MY
                                WALLET</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void()" onclick="$('#sendMoney').click()" role="button"
                                aria-expanded="false">MONEY TRANSFER</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('invoice') }}" role="button"
                                aria-expanded="false">INVOICE</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('statement') }}" role="button"
                                aria-expanded="false">TRANSACTION HISTORY</a>
                        </li>


                        <li class="nav-item dropdown">

                            <a class="nav-link dropdown-toggle gr-toggle-arrow" id="navbarDropdown" href="#features"
                                role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{
                                strlen(Auth::user()->name) < 10 ? Auth::user()->name : substr(Auth::user()->name, 0, 10)
                                    . '...' }}
                                    <i class="icon icon-small-down"></i></a>
                            <ul class="gr-menu-dropdown dropdown-menu" aria-labelledby="navbarDropdown">
                                <li class="drop-menu-item">
                                    <a href="javascript:void()">
                                        Account NO: {{ Auth::user()->ref_code }}
                                    </a>
                                </li>
                                <li class="drop-menu-item">
                                    <a href="{{ route('profile') }}">
                                        PROFILE
                                    </a>
                                </li>
                                <li class="drop-menu-item">
                                    <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        LOGOUT
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>


                        @endauth




                        <li class="nav-item dropdown disp-0">
                            <a class="nav-link dropdown-toggle gr-toggle-arrow" id="navbarDropdown02" href="#features"
                                role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Pages <i
                                    class="icon icon-small-down"></i></a>
                            <ul class="gr-menu-dropdown dropdown-menu" aria-labelledby="navbarDropdown02">
                                <li class="drop-menu-item">
                                    <a href="about.html">
                                        About us
                                    </a>
                                </li>
                                <li class="drop-menu-item dropdown">
                                    <a class="dropdown-toggle gr-toggle-arrow" id="navbarDropdown21" href="#"
                                        role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Career
                                        <i class="icon icon-small-down"></i>
                                    </a>
                                    <ul class="gr-menu-dropdown dropdown-menu dropdown-right"
                                        aria-labelledby="navbarDropdown21">
                                        <li class="drop-menu-item">
                                            <a href="job-opening.html">
                                                Job opening
                                            </a>
                                        </li>
                                        <li class="drop-menu-item">
                                            <a href="job-details.html">
                                                Job Details
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="drop-menu-item dropdown">
                                    <a class="dropdown-toggle gr-toggle-arrow" id="navbarDropdown24" href="#"
                                        role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Pricing
                                        <i class="icon icon-small-down"></i>
                                    </a>
                                    <ul class="gr-menu-dropdown dropdown-menu dropdown-right"
                                        aria-labelledby="navbarDropdown24">
                                        <li class="drop-menu-item">
                                            <a href="pricing-1.html">
                                                Pricing 01
                                            </a>
                                        </li>
                                        <li class="drop-menu-item">
                                            <a href="pricing-2.html">
                                                Pricing 02
                                            </a>
                                        </li>
                                        <li class="drop-menu-item">
                                            <a href="pricing-3.html">
                                                Pricing 03
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="drop-menu-item dropdown">
                                    <a class="dropdown-toggle gr-toggle-arrow" id="navbarDropdown25" href="#"
                                        role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Contact
                                        <i class="icon icon-small-down"></i>
                                    </a>
                                    <ul class="gr-menu-dropdown dropdown-menu dropdown-right"
                                        aria-labelledby="navbarDropdown25">
                                        <li class="drop-menu-item">
                                            <a href="contact.html">
                                                Contact 01
                                            </a>
                                        </li>
                                        <li class="drop-menu-item">
                                            <a href="contact-2.html">
                                                Contact 02
                                            </a>
                                        </li>
                                        <li class="drop-menu-item">
                                            <a href="contact-3.html">
                                                Contact 03
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="drop-menu-item dropdown">
                                    <a class="dropdown-toggle gr-toggle-arrow" id="navbarDropdown26" href="#"
                                        role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Account
                                        <i class="icon icon-small-down"></i>
                                    </a>
                                    <ul class="gr-menu-dropdown dropdown-menu dropdown-right"
                                        aria-labelledby="navbarDropdown26">
                                        <li class="drop-menu-item">
                                            <a href="sign-in.html">
                                                Sign In
                                            </a>
                                        </li>
                                        <li class="drop-menu-item">
                                            <a href="sign-up.html">
                                                Sign Up
                                            </a>
                                        </li>
                                        <li class="drop-menu-item">
                                            <a href="forget-pass.html">
                                                Reset Password
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="drop-menu-item dropdown">
                                    <a class="dropdown-toggle gr-toggle-arrow" id="navbarDropdown27" href="#"
                                        role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Utitlity
                                        <i class="icon icon-small-down"></i>
                                    </a>
                                    <ul class="gr-menu-dropdown dropdown-menu dropdown-right"
                                        aria-labelledby="navbarDropdown27">
                                        <li class="drop-menu-item">
                                            <a href="terms.html">
                                                Terms & Conditions
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="drop-menu-item dropdown">
                                    <a class="dropdown-toggle gr-toggle-arrow" id="navbarDropdown28" href="#"
                                        role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        E-commerce
                                        <i class="icon icon-small-down"></i>
                                    </a>
                                    <ul class="gr-menu-dropdown dropdown-menu dropdown-right"
                                        aria-labelledby="navbarDropdown28">
                                        <li class="drop-menu-item">
                                            <a href="product-details.html">Product Details</a>
                                        </li>
                                        <li class="drop-menu-item">
                                            <a href="cart.html">Cart</a>
                                        </li>
                                        <li class="drop-menu-item">
                                            <a href="checkout.html">Checkout</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                      
                    </ul>
                </div>
                <button class="d-block d-lg-none offcanvas-btn-close" type="button" data-toggle="collapse"
                    data-target="#mobile-menu" aria-controls="mobile-menu" aria-expanded="true"
                    aria-label="Toggle navigation">
                    <i class="gr-cross-icon"></i>
                </button>
            </div>




            <!-- Mobile Menu Hamburger-->
            <button class="navbar-toggler btn-close-off-canvas  hamburger-icon border-0" type="button"
                data-toggle="collapse" data-target="#mobile-menu" aria-controls="mobile-menu" aria-expanded="false"
                aria-label="Toggle navigation">
                <!-- <i class="icon icon-simple-remove icon-close"></i> -->
                <span class="hamburger hamburger--squeeze js-hamburger">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </span>
            </button>
            <!--/.Mobile Menu Hamburger Ends-->
        </nav>
    </div>
</header>
