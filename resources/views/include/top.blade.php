<?php use App\Http\Controllers\LinkAccount; ?>
<?php use App\Http\Controllers\User; ?>
<!--Top Header_Area -->
<section class="top_header_area">
    <div class="container">
        <ul class="nav navbar-nav top_nav">
            {{-- <li><a href="#"><i class="fa fa-phone"></i>+1 (168) 314 5016</a></li>
                <li><a href="#"><i class="fa fa-envelope-o"></i>info@thethemspro.com</a></li>
                <li><a href="#"><i class="fa fa-clock-o"></i>Mon - Sat 12:00 - 20:00</a></li> --}}

            @if ($name == '')

                <li>
                    <a href="{{ route('login') }}">
                        {{ __('Login') }}
                    </a>
                </li>

                <li>
                    <a href="{{ route('register') }}">
                        {{ __('Sign Up for FREE') }}
                    </a>
                </li>

            @else



            @endif

        </ul>
        <ul class="nav navbar-nav navbar-right social_nav">
            <li><a href="https://www.facebook.com/EXPRESSCANADA2014/?modal=admin_todo_tour" target="_blank"><i
                        class="fa fa-facebook" aria-hidden="true"></i></a></li>
            <li><a href="https://twitter.com/EXBC2" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>
            </li>
            <li><a href="https://instagram.com/exbc2014" target="_blank"><i class="fa fa-instagram"
                        aria-hidden="true"></i></a></li>
            <li><a href="https://www.linkedin.com/company/exbc-canada/?viewAsMember=true" target="_blank"><i
                        class="fa fa-linkedin" aria-hidden="true"></i></a></li>

        </ul>
    </div>
</section>
<!-- End Top Header_Area -->

<!-- Header_Area -->
<nav class="navbar navbar-default header_aera" id="main_navbar">
    <div class="container">
        <!-- searchForm -->
        <div class="searchForm">
            <form action="#" class="row m0">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-search"></i></span>
                    <input type="search" name="search" class="form-control" placeholder="Type & Hit Enter">
                    <span class="input-group-addon form_hide"><i class="fa fa-times"></i></span>
                </div>
            </form>
        </div><!-- End searchForm -->
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="col-md-2 p0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#min_navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                {{-- <a class="navbar-brand" href="{{ route('home') }}"><p style="font-weight: bold; font-size: 30px; color: #f6b60b;"><span style="color: #111f29">Pay</span>Sprint</p></a> --}}
                <a class="navbar-brand" @guest href="{{ route('home') }}" @endguest @auth
                href="{{ route('user home') }}" @endauth><img
                    src="https://res.cloudinary.com/pilstech/image/upload/v1603726392/pay_sprint_black_horizotal_fwqo6q.png"
                    style="top: -13px; position: relative;  width: 200px; height: inherit;"></a>

        </div>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="col-md-10 p0">
        <div class="collapse navbar-collapse" id="min_navbar">
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown submenu">
                    @guest
                        <a href="{{ route('home') }}">Home</a>
                    @endguest

                    @auth

                        <a
                            {{ Auth::user()->accountType != 'Individual' ? 'href=' . route('Admin') : 'href=' . route('user home') }}>Home</a>


                    @endauth

                </li>

                {{-- <li class="dropdown submenu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Services</a>
                            <ul class="dropdown-menu other_dropdwn">
                                <li><a href="#">Property Tax</a></li>
                                <li><a href="#">Utility Bill</a></li>
                                <li><a href="#">Tickets</a></li>
                                <li><a href="#">Others</a></li>
                            </ul>
                        </li> --}}

                @if ($name == '')

                    {{-- <li class="dropdown submenu">
                            <a href="{{ route('service') }}">Services</a>
                        </li> --}}
                    <li class="dropdown submenu">
                        <a href="{{ route('about') }}">About Us</a>
                    </li>
                    {{-- <li class="dropdown submenu">
                            <a href="#">What We Offer</a>
                        </li>
                        <li class="dropdown submenu">
                            <a href="#">Our Patners</a>
                        </li> --}}

                    {{-- <li class="dropdown submenu" onclick="getBronchure('{{ $email }}')">
                            <a href="#">Brochure</a>

                        </li>
                        <a href="{{ url('/bronchure/PAYca_Brochure.pdf') }}" download="" id="downloaddoc" style="display: none;">Brochure</a> --}}

                    <li class="dropdown submenu">
                        <a href="{{ route('contact') }}">Contact</a>
                    </li>

                    <li class="dropdown submenu">
                        <a href="{{ route('login') }}">Login</a>
                        {{-- <a href="https://exbc.ca/login">Login</a> --}}
                    </li>
                    <li class="dropdown submenu">
                        <a href="{{ route('register') }}">Sign Up for FREE</a>
                        {{-- <a href="https://exbc.ca/Newaccount">Sign Up for FREE</a> --}}
                    </li>

                @else

                    @auth
                        <li class="dropdown submenu">

                            <a
                                {{ Auth::user()->accountType != 'Individual' ? 'href=' . route('Admin') : 'href=' . route('my account') }}>My
                                Wallet</a>
                        </li>
                    @endauth

                    <li class="dropdown submenu">
                        {{-- <a href="{{ route('payorganization') }}">Send Money</a> --}}
                        {{-- COnver to Modal popup --}}
                        @if (Auth::check() == true)
                            @if (Auth::user()->accountType != 'Individual')
                                <a href="{{ route('merchant send money', 'type=local') }}">Money Transfer</a>
                            @else
                                <a href="javascript:void()" onclick="$('#sendMoney').click()">Money Transfer</a>
                            @endif
                        @else
                            <a href="javascript:void()" onclick="$('#sendMoney').click()">Money Transfer</a>
                        @endif



                    </li>

                    <li class="dropdown submenu">

                        <a
                            {{ Auth::user()->accountType != 'Individual' ? 'href=' . route('create single invoice') : 'href=' . route('invoice') }}>Invoice</a>

                    </li>

                    <li class="dropdown submenu">
                        <a
                            {{ Auth::user()->accountType != 'Individual' ? 'href=' . route('getStatement') : 'href=' . route('statement') }}>Transaction</a>
                    </li>





                    @auth
                        <li class="dropdown submenu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">SWITCH ACCOUNT<span
                                    class="caret"></span></a>

                            <ul class="dropdown-menu other_dropdwn">

                                @php
                                    $account = \App\LinkAccount::where('ref_code', Auth::user()->ref_code)->get();
                                @endphp

                                @if (count($account) > 0)
                                    @foreach ($account as $item)

                                        @php
                                            $useraccount = \App\User::where('ref_code', $item->link_ref_code)->first();
                                        @endphp

                                        <li><a href="{{ route('sign out', $useraccount->id) }}">ACCOUNT NO:
                                                {{ $item->link_ref_code }}</a></li>
                                    @endforeach
                                @else

                                    @php
                                        $account = \App\LinkAccount::where('link_ref_code', Auth::user()->ref_code)->get();
                                    @endphp

                                    @if (count($account) > 0)

                                        @foreach ($account as $item)
                                            @php
                                                $useraccount = \App\User::where('ref_code', $item->ref_code)->first();
                                            @endphp
                                            <li><a href="{{ route('sign out', $useraccount->id) }}">ACCOUNT NO:
                                                    {{ $item->ref_code }}</a></li>
                                        @endforeach

                                    @else

                                        <li><a href="{{ route('profile') }}">SET UP</a></li>

                                    @endif
                                @endif
                            </ul>
                        </li>
                    @endauth





                    <li class="dropdown submenu">
                        @php
                            $username = explode(' ', $name);
                        @endphp
                        <a href="#" class="dropdown-toggle"
                            data-toggle="dropdown">{{ strlen($username[0]) < 10 ? $username[0] : substr($username[0], 0, 10) . '...' }}<span
                                class="caret"></span></a>

                        <ul class="dropdown-menu other_dropdwn">
                            <li><a href="javascript:void()">Account NO: {{ Auth::user()->ref_code }}</a></li>
                            <li>
                                <a
                                    {{ Auth::user()->accountType != 'Individual' ? 'href=' . route('merchant profile') : 'href=' . route('profile') }}>Profile</a>
                            </li>
                            {{-- <li><a href="https://exbc.ca/Product">Goto EXBC</a></li> --}}
                            <li><a href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                            </li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                        </ul>
                    </li>

                    <li class="dropdown submenu">
                        <a href="{{ route('notifications') }}"><img
                                src="https://img.icons8.com/ios/25/000000/appointment-reminders--v1.png"
                                class="notificationImage" /> @if (count($data['getfiveNotifications']) > 0 && $data['getfiveNotifications'][0]->notify == 0) <i class="fas fa-circle fa-blink" style="color: rgb(129, 6, 6)"></i> @endif</a>
                    </li>

                @endif

                <li><a href="#" class="nav_searchFroms"><i class="fa fa-searchs"></i></a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div>
</div><!-- /.container -->
</nav>
<!-- End Header_Area
