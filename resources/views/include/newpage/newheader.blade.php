
<header class="site-header site-header--menu-left pt-5 pb-5 site-header--absolute">
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
</header>        