   @if ($pages == "Merchant")


   <div class="d-flex">
      <span class="border-3 border-blue d-flex w-100"></span>
      <span class="border-3 border-red d-flex w-100"></span>
      <span class="border-3 border-green d-flex w-100"></span>
    </div>
    <!-- Header Area -->
    
    
    <header class="site-header site-header--menu-left pt-5 pb-5 site-header--absolute">
      <div class="container-fluid pr-lg-9 pl-lg-9">
        <nav class="navbar site-navbar offcanvas-active navbar-expand-lg  px-0 fixed-top" style="background-color: #f4f7fa;">
          <!-- Brand Logo-->
          <div class="brand-logo">
              
            <a @guest href="{{ route('merchant home') }}" @endguest  @auth href="{{ route('merchant home') }}" @endauth><img src="https://res.cloudinary.com/pilstech/image/upload/v1603726392/pay_sprint_black_horizotal_fwqo6q.png" class="light-version-logo " style="width: 300px; height: inherit;"></a>  
              
            {{--  <a href="https://shade.uxtheme.net/shade-pro">
              <!-- light version logo (logo must be black)-->
              <img src="image/logo-main-black.png" alt="" class="light-version-logo ">
              <!-- Dark version logo (logo must be White)-->
              <img src="image/logo-main-white.png" alt="" class="dark-version-logo">
            </a>  --}}
        
        
        </div>
          <div class="collapse navbar-collapse" id="mobile-menu">
            <div class="navbar-nav-wrapper">
              <ul class="navbar-nav main-menu">

                

                
                @if (Session::has('username') ==  false)
                @guest

                <li class="nav-item">
                  <a class="nav-link" @guest href="{{ route('merchant home') }}" @endguest  @auth href="{{ route('Admin') }}" @endauth role="button" aria-expanded="false">HOME</a>
                </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}" role="button" aria-expanded="false">ABOUT US</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/blog" role="button" aria-expanded="false">BLOG</a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}" role="button" aria-expanded="false">CONTACT</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('AdminLogin') }}" role="button" aria-expanded="false">LOGIN</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('AdminRegister') }}" role="button" aria-expanded="false">SIGN UP FOR FREE</a>
                    </li>

                    {{-- <li class="nav-item">
                        <a class="nav-link" href="{{ route('haiti donation') }}" style="color: red !important;">DONATE TO HAITI <img src="https://img.icons8.com/color/24/000000/the-republic-of-haiti.png"/></a>
                    </li> --}}


                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}" style="color: #000000 !important; text-decoration: underline; background-color: #e8aa07; border-radius: 10px; font-size: 17px; padding: 5px;">{{ "Are you a CONSUMER? ".strtoupper(" CLICK HERE") }}</a>
                    </li>

                @endguest

                @endif


                    @if (Session::has('username') ==  true)
                        
                    <li class="nav-item">
                      <a class="nav-link" href="{{ route('Admin') }}" role="button" aria-expanded="false">DASHBOARD</a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link" href="/blog" role="button" aria-expanded="false">BLOG</a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('create single invoice') }}" role="button" aria-expanded="false">INVOICE</a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('getStatement') }}" role="button" aria-expanded="false">TRANSACTION HISTORY</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('api integration') }}" role="button" aria-expanded="false">API INTEGRATION</a>
                    </li>


                    <li class="nav-item dropdown">

                        

                    <a class="nav-link dropdown-toggle gr-toggle-arrow" id="navbarDropdown" href="#features" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ (strlen(session('firstname').' '.session('lastname')) < 10) ? session('firstname').' '.session('lastname') : substr(session('firstname').' '.session('lastname'), 0, 10)."..." }} <i class="icon icon-small-down"></i></a>
                    <ul class="gr-menu-dropdown dropdown-menu" aria-labelledby="navbarDropdown">
                    <li class="drop-menu-item">
                        <a href="javascript:void()">
                        Account NO: {{ session('user_id') }}
                        </a>
                    </li>
                    <li class="drop-menu-item">
                        <a href="{{ route('merchant profile') }}">
                        PROFILE
                        </a>
                    </li>
                    
                  </ul>
                </li>


                    @endif

                


                <li class="nav-item dropdown disp-0">
                  <a class="nav-link dropdown-toggle gr-toggle-arrow" id="navbarDropdown02" href="#features" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Pages <i class="icon icon-small-down"></i></a>
                  <ul class="gr-menu-dropdown dropdown-menu" aria-labelledby="navbarDropdown02">
                    <li class="drop-menu-item">
                      <a href="about.html">
                        About us
                      </a>
                    </li>
                    <li class="drop-menu-item dropdown">
                      <a class="dropdown-toggle gr-toggle-arrow" id="navbarDropdown21" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Career
                        <i class="icon icon-small-down"></i>
                      </a>
                      <ul class="gr-menu-dropdown dropdown-menu dropdown-right" aria-labelledby="navbarDropdown21">
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
                      <a class="dropdown-toggle gr-toggle-arrow" id="navbarDropdown24" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Pricing
                        <i class="icon icon-small-down"></i>
                      </a>
                      <ul class="gr-menu-dropdown dropdown-menu dropdown-right" aria-labelledby="navbarDropdown24">
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
                      <a class="dropdown-toggle gr-toggle-arrow" id="navbarDropdown25" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Contact
                        <i class="icon icon-small-down"></i>
                      </a>
                      <ul class="gr-menu-dropdown dropdown-menu dropdown-right" aria-labelledby="navbarDropdown25">
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
                      <a class="dropdown-toggle gr-toggle-arrow" id="navbarDropdown26" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Account
                        <i class="icon icon-small-down"></i>
                      </a>
                      <ul class="gr-menu-dropdown dropdown-menu dropdown-right" aria-labelledby="navbarDropdown26">
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
                      <a class="dropdown-toggle gr-toggle-arrow" id="navbarDropdown27" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Utitlity
                        <i class="icon icon-small-down"></i>
                      </a>
                      <ul class="gr-menu-dropdown dropdown-menu dropdown-right" aria-labelledby="navbarDropdown27">
                        <li class="drop-menu-item">
                          <a href="terms.html">
                            Terms & Conditions
                          </a>
                        </li>
                      </ul>
                    </li>
                    <li class="drop-menu-item dropdown">
                      <a class="dropdown-toggle gr-toggle-arrow" id="navbarDropdown28" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        E-commerce
                        <i class="icon icon-small-down"></i>
                      </a>
                      <ul class="gr-menu-dropdown dropdown-menu dropdown-right" aria-labelledby="navbarDropdown28">
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
                <li class="nav-item dropdown dropdown-mega disp-0">
                  <a class="nav-link dropdown-toggle gr-toggle-arrow" id="navbarDropdown90" href="#features" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Components <i class="icon icon-small-down"></i></a>
                  <div class="gr-megamenu-dropdown center dropdown-menu d-lg-flex" aria-labelledby="navbarDropdown90">
                    <div class="col-lg-5 pl-0 d-none d-lg-flex align-items-center">
                      <a href="https://shade.uxtheme.net/shade-pro" class="d-block dropdown-image-block h-100 w-100 rounded-sm bg-image overflow-hidden mr-xl-12" style="background-image: url(image/elements/menu-image.jpg)">
                      </a>
                    </div>
                    <ul class="col-lg-7 col-xl-6 row-lg list-unstyled py-lg-7">
                      <li class="col-lg-4">
                        <div class="single-dropdown-block">
                          <a href="components/elements-header.html" class="mega-drop-menu-item">Headers</a>
                          <a href="components/elements-heros.html" class="mega-drop-menu-item">Hero Area</a>
                          <a href="components/elements-content.html" class="mega-drop-menu-item">Contents</a>
                          <a href="components/elements-feature.html" class="mega-drop-menu-item">Features</a>
                          <a href="components/elements-pricing.html" class="mega-drop-menu-item">Pricing</a>
                          <a href="components/elements-counter.html" class="mega-drop-menu-item">Stats</a>
                        </div>
                      </li>
                      <li class="col-lg-4">
                        <div class="single-dropdown-block">
                          <a href="components/elements-cta.html" class="mega-drop-menu-item">CTA</a>
                          <a href="components/elements-testimonial.html" class="mega-drop-menu-item">Testimonial</a>
                          <a href="components/elements-team-area.html" class="mega-drop-menu-item">Team</a>
                          <a href="components/elements-newsletter.html" class="mega-drop-menu-item">Newsletter</a>
                          <a href="components/elements-brand-area.html" class="mega-drop-menu-item d-block">Clients</a>
                          <a href="components/elements-video.html" class="mega-drop-menu-item d-block">Video</a>
                        </div>
                      </li>
                      <li class="col-lg-4">
                        <div class="single-dropdown-block">
                          <a href="components/elements-blog-area.html" class="mega-drop-menu-item d-block">News</a>
                          <a href="components/elements-faq.html" class="mega-drop-menu-item d-block">FAQ</a>
                          <a href="components/elements-alert-area.html" class="mega-drop-menu-item d-block">Alert</a>
                          <a href="components/elements-footers.html" class="mega-drop-menu-item d-block">Footer</a>
                          <a href="components/elements-footers.html" class="mega-drop-menu-item d-block disabled pointer-none  text-storm" tabindex="-1">Forms </a>
                          <a href="components/elements-footers.html" class="mega-drop-menu-item d-block disabled pointer-none  text-storm" tabindex="-1">Tab</a>
                        </div>
                      </li>
                    </ul>
                  </div>
                </li>
              </ul>
            </div>
            <button class="d-block d-lg-none offcanvas-btn-close" type="button" data-toggle="collapse" data-target="#mobile-menu" aria-controls="mobile-menu" aria-expanded="true" aria-label="Toggle navigation">
              <i class="gr-cross-icon"></i>
            </button>
          </div>

          

          
          <!-- Mobile Menu Hamburger-->
          <button class="navbar-toggler btn-close-off-canvas  hamburger-icon border-0" type="button" data-toggle="collapse" data-target="#mobile-menu" aria-controls="mobile-menu" aria-expanded="false" aria-label="Toggle navigation">
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

    <!-- navbar- -->

       
   @elseif ($pages == "Supporting HAITI")

    <div class="d-flex">
      <span class="border-3 border-blue d-flex w-100"></span>
      <span class="border-3 border-red d-flex w-100"></span>
      <span class="border-3 border-green d-flex w-100"></span>
    </div>
    <!-- Header Area -->
    
    
    <header class="site-header site-header--menu-left pt-5 pb-5 site-header--absolute">
      <div class="container-fluid pr-lg-9 pl-lg-9">
        <nav class="navbar site-navbar offcanvas-active navbar-expand-lg  px-0 fixed-top" style="background-color: #fbfbfb;">
          <!-- Brand Logo-->
          <div class="brand-logo">
              
            <a @guest href="{{ route('home') }}" @endguest  @auth href="{{ route('user home') }}" @endauth><img src="https://res.cloudinary.com/pilstech/image/upload/v1603726392/pay_sprint_black_horizotal_fwqo6q.png" class="light-version-logo " style="width: 300px; height: inherit;"> 
            </a> 
            <span class="mx-20 text-danger" style="font-weight: 900; font-size: 18px;">Supporting HAITI <img src="https://img.icons8.com/emoji/30/000000/haiti-emoji.png"/></span> 
            
        
        
        </div>
          <div class="collapse navbar-collapse" id="mobile-menu">
            <div class="navbar-nav-wrapper">
              <ul class="navbar-nav main-menu">

                <li class="nav-item">
                  <a class="nav-link" @guest href="{{ route('home') }}" @endguest  @auth href="{{ route('user home') }}" @endauth role="button" aria-expanded="false">HOME</a>
                </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('my account') }}" role="button" aria-expanded="false">MONEY TRANSFER</a>
                    </li>

                    @isset($data['pauline'])
                        <li class="nav-item">
                          <a class="nav-link" href="{{ url('payment/sendmoney/'.$data['pauline']->ref_code.'?country=Canada') }}"  style="color: #000000 !important; text-decoration: none; background-color: #e8aa07; border-radius: 10px; font-size: 17px; padding: 5px;">{{ "DONATE TODAY " }}</a>
                      </li>
                    @endisset
                    

                    




                
              </ul>
            </div>
            <button class="d-block d-lg-none offcanvas-btn-close" type="button" data-toggle="collapse" data-target="#mobile-menu" aria-controls="mobile-menu" aria-expanded="true" aria-label="Toggle navigation">
              <i class="gr-cross-icon"></i>
            </button>
          </div>

          

          
          <!-- Mobile Menu Hamburger-->
          <button class="navbar-toggler btn-close-off-canvas  hamburger-icon border-0" type="button" data-toggle="collapse" data-target="#mobile-menu" aria-controls="mobile-menu" aria-expanded="false" aria-label="Toggle navigation">
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

    <!-- navbar- -->

   @else



   <div class="d-flex">
      <span class="border-3 border-blue d-flex w-100"></span>
      <span class="border-3 border-red d-flex w-100"></span>
      <span class="border-3 border-green d-flex w-100"></span>
    </div>
    <!-- Header Area -->
    
    
    <header class="site-header site-header--menu-left pt-5 pb-5 site-header--absolute">
      <div class="container-fluid pr-lg-9 pl-lg-9">
        <nav class="navbar site-navbar offcanvas-active navbar-expand-lg  px-0 fixed-top" style="background-color: #fbfbfb;">
          <!-- Brand Logo-->
          <div class="brand-logo">
              
            <a @guest href="{{ route('home') }}" @endguest  @auth href="{{ route('user home') }}" @endauth><img src="https://res.cloudinary.com/pilstech/image/upload/v1603726392/pay_sprint_black_horizotal_fwqo6q.png" class="light-version-logo " style="width: 300px; height: inherit;"></a>  
              
            {{--  <a href="https://shade.uxtheme.net/shade-pro">
              <!-- light version logo (logo must be black)-->
              <img src="image/logo-main-black.png" alt="" class="light-version-logo ">
              <!-- Dark version logo (logo must be White)-->
              <img src="image/logo-main-white.png" alt="" class="dark-version-logo">
            </a>  --}}
        
        
        </div>
          <div class="collapse navbar-collapse" id="mobile-menu">
            <div class="navbar-nav-wrapper">
              <ul class="navbar-nav main-menu">

                <li class="nav-item">
                  <a class="nav-link" @guest href="{{ route('home') }}" @endguest  @auth href="{{ route('user home') }}" @endauth role="button" aria-expanded="false">HOME</a>
                </li>

                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}" role="button" aria-expanded="false">ABOUT US</a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link" href="/blog" role="button" aria-expanded="false">BLOG</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}" role="button" aria-expanded="false">CONTACT</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}" role="button" aria-expanded="false">LOGIN</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}" role="button" aria-expanded="false">SIGN UP FOR FREE</a>
                    </li>

                    {{-- <li class="nav-item">
                        <a class="nav-link" href="{{ route('haiti donation') }}" style="color: red !important;">DONATE TO HAITI <img src="https://img.icons8.com/color/24/000000/the-republic-of-haiti.png"/></a>
                    </li> --}}


                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('merchant home') }}"  style="color: #000000 !important; text-decoration: underline; background-color: #e8aa07; border-radius: 10px; font-size: 17px; padding: 5px;">{{ "Are you a Merchant? ".strtoupper(" CLICK HERE") }}</a>
                    </li>

                    


                @endguest


                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('my account') }}" role="button" aria-expanded="false">MY WALLET</a>
                    </li>
                    

                    <li class="nav-item">
                        <a class="nav-link" href="javascript:void()" onclick="$('#sendMoney').click()" role="button" aria-expanded="false">MONEY TRANSFER</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('invoice') }}" role="button" aria-expanded="false">INVOICE</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('statement') }}" role="button" aria-expanded="false">TRANSACTION HISTORY</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/blog" role="button" aria-expanded="false">BLOG</a>
                    </li>


                    <li class="nav-item dropdown">

                    <a class="nav-link dropdown-toggle gr-toggle-arrow" id="navbarDropdown" href="#features" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ (strlen(Auth::user()->name) < 10) ? Auth::user()->name : substr(Auth::user()->name, 0, 10)."..." }} <i class="icon icon-small-down"></i></a>
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
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        LOGOUT
                        </a>
                      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                  </ul>
                </li>


                @endauth

                


                <li class="nav-item dropdown disp-0">
                  <a class="nav-link dropdown-toggle gr-toggle-arrow" id="navbarDropdown02" href="#features" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Pages <i class="icon icon-small-down"></i></a>
                  <ul class="gr-menu-dropdown dropdown-menu" aria-labelledby="navbarDropdown02">
                    <li class="drop-menu-item">
                      <a href="about.html">
                        About us
                      </a>
                    </li>
                    <li class="drop-menu-item dropdown">
                      <a class="dropdown-toggle gr-toggle-arrow" id="navbarDropdown21" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Career
                        <i class="icon icon-small-down"></i>
                      </a>
                      <ul class="gr-menu-dropdown dropdown-menu dropdown-right" aria-labelledby="navbarDropdown21">
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
                      <a class="dropdown-toggle gr-toggle-arrow" id="navbarDropdown24" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Pricing
                        <i class="icon icon-small-down"></i>
                      </a>
                      <ul class="gr-menu-dropdown dropdown-menu dropdown-right" aria-labelledby="navbarDropdown24">
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
                      <a class="dropdown-toggle gr-toggle-arrow" id="navbarDropdown25" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Contact
                        <i class="icon icon-small-down"></i>
                      </a>
                      <ul class="gr-menu-dropdown dropdown-menu dropdown-right" aria-labelledby="navbarDropdown25">
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
                      <a class="dropdown-toggle gr-toggle-arrow" id="navbarDropdown26" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Account
                        <i class="icon icon-small-down"></i>
                      </a>
                      <ul class="gr-menu-dropdown dropdown-menu dropdown-right" aria-labelledby="navbarDropdown26">
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
                      <a class="dropdown-toggle gr-toggle-arrow" id="navbarDropdown27" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Utitlity
                        <i class="icon icon-small-down"></i>
                      </a>
                      <ul class="gr-menu-dropdown dropdown-menu dropdown-right" aria-labelledby="navbarDropdown27">
                        <li class="drop-menu-item">
                          <a href="terms.html">
                            Terms & Conditions
                          </a>
                        </li>
                      </ul>
                    </li>
                    <li class="drop-menu-item dropdown">
                      <a class="dropdown-toggle gr-toggle-arrow" id="navbarDropdown28" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        E-commerce
                        <i class="icon icon-small-down"></i>
                      </a>
                      <ul class="gr-menu-dropdown dropdown-menu dropdown-right" aria-labelledby="navbarDropdown28">
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
                <li class="nav-item dropdown dropdown-mega disp-0">
                  <a class="nav-link dropdown-toggle gr-toggle-arrow" id="navbarDropdown90" href="#features" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Components <i class="icon icon-small-down"></i></a>
                  <div class="gr-megamenu-dropdown center dropdown-menu d-lg-flex" aria-labelledby="navbarDropdown90">
                    <div class="col-lg-5 pl-0 d-none d-lg-flex align-items-center">
                      <a href="https://shade.uxtheme.net/shade-pro" class="d-block dropdown-image-block h-100 w-100 rounded-sm bg-image overflow-hidden mr-xl-12" style="background-image: url(image/elements/menu-image.jpg)">
                      </a>
                    </div>
                    <ul class="col-lg-7 col-xl-6 row-lg list-unstyled py-lg-7">
                      <li class="col-lg-4">
                        <div class="single-dropdown-block">
                          <a href="components/elements-header.html" class="mega-drop-menu-item">Headers</a>
                          <a href="components/elements-heros.html" class="mega-drop-menu-item">Hero Area</a>
                          <a href="components/elements-content.html" class="mega-drop-menu-item">Contents</a>
                          <a href="components/elements-feature.html" class="mega-drop-menu-item">Features</a>
                          <a href="components/elements-pricing.html" class="mega-drop-menu-item">Pricing</a>
                          <a href="components/elements-counter.html" class="mega-drop-menu-item">Stats</a>
                        </div>
                      </li>
                      <li class="col-lg-4">
                        <div class="single-dropdown-block">
                          <a href="components/elements-cta.html" class="mega-drop-menu-item">CTA</a>
                          <a href="components/elements-testimonial.html" class="mega-drop-menu-item">Testimonial</a>
                          <a href="components/elements-team-area.html" class="mega-drop-menu-item">Team</a>
                          <a href="components/elements-newsletter.html" class="mega-drop-menu-item">Newsletter</a>
                          <a href="components/elements-brand-area.html" class="mega-drop-menu-item d-block">Clients</a>
                          <a href="components/elements-video.html" class="mega-drop-menu-item d-block">Video</a>
                        </div>
                      </li>
                      <li class="col-lg-4">
                        <div class="single-dropdown-block">
                          <a href="components/elements-blog-area.html" class="mega-drop-menu-item d-block">News</a>
                          <a href="components/elements-faq.html" class="mega-drop-menu-item d-block">FAQ</a>
                          <a href="components/elements-alert-area.html" class="mega-drop-menu-item d-block">Alert</a>
                          <a href="components/elements-footers.html" class="mega-drop-menu-item d-block">Footer</a>
                          <a href="components/elements-footers.html" class="mega-drop-menu-item d-block disabled pointer-none  text-storm" tabindex="-1">Forms </a>
                          <a href="components/elements-footers.html" class="mega-drop-menu-item d-block disabled pointer-none  text-storm" tabindex="-1">Tab</a>
                        </div>
                      </li>
                    </ul>
                  </div>
                </li>
              </ul>
            </div>
            <button class="d-block d-lg-none offcanvas-btn-close" type="button" data-toggle="collapse" data-target="#mobile-menu" aria-controls="mobile-menu" aria-expanded="true" aria-label="Toggle navigation">
              <i class="gr-cross-icon"></i>
            </button>
          </div>

          

          
          <!-- Mobile Menu Hamburger-->
          <button class="navbar-toggler btn-close-off-canvas  hamburger-icon border-0" type="button" data-toggle="collapse" data-target="#mobile-menu" aria-controls="mobile-menu" aria-expanded="false" aria-label="Toggle navigation">
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

    <!-- navbar- -->

       
   @endif
   
   
   
   