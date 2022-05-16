        <!-- Page Sidebar Start-->
        <header class="main-nav">
            <div class="sidebar-user text-center">
                <a class="setting-primary" href="javascript:void(0)"><i data-feather="settings"></i></a><img
                    class="img-90 rounded-circle"
                    src="{{ Auth::user()->avatar != null ? Auth::user()->avatar : 'https://cdn.business2community.com/wp-content/uploads/2017/08/blank-profile-picture-973460_640.png' }}"
                    alt="" />
                <div class="badge-bottom"><span class="badge badge-primary"></span></div>
                <a href="{{ route('profile') }}">
                    <h6 class="mt-3 f-14 f-w-600">{{ Auth::user()->businessname }}</h6>
                </a>
                <p class="mb-0 font-roboto">{{ 'Account Number: ' . Auth::user()->ref_code }}</p>

                <ul>
                    <li>
                        <span><span class="counter">{{ Auth::user()->loginCount }}</span></span>
                        <p>Logins</p>
                    </li>
                    <li>
                        <span>{!! Auth::user()->bvn_verification > 0 ? '<img src="https://img.icons8.com/external-tal-revivo-green-tal-revivo/20/000000/external-verification-tick-mark-for-digital-certification-document-basic-green-tal-revivo.png"/>' : '<img src="https://img.icons8.com/fluency/20/000000/cancel.png"/>' !!}</span>
                        <p>&nbsp;</p>
                    </li>
                    <li>
                        <span><span class="counter">{{ Auth::user()->referral_points }}</span></span>
                        <p>Ref. Points</p>
                    </li>
                </ul>

                <br>


                <form action="#" method="post" id="formElemchangeplan" class="disp-0">
                    @csrf
                    <input value="{{ Auth::id() }}" name="user_id">
                </form>


                @if (Auth::user()->plan == 'basic')
                    <button class="btn btn-success" onclick="changeMyPlan('changeplan')" id="cardSubmit">Upgrade
                        Account</button>
                    {{-- <button class="btn btn-success" onclick="changeMyPlan('changeplan')" id="cardSubmit">Upgrade
                        Account for
                        {{ Auth::user()->currencySymbol . '' . number_format($data['planCost']->fixed, 2) }}</button> --}}
                @else
                    <button class="btn btn-danger" onclick="changeMyPlan('changeplan')" id="cardSubmit">Downgrade
                        Account</button>


                    @isset($data['myplan'])
                        <br>
                        <br>
                        @php
                            $expire = date('Y-m-d', strtotime($data['myplan']->expire_date));
                            $now = time();
                            $your_date = strtotime($expire);
                            $datediff = $your_date - $now;
                        @endphp
                        <p class="text-success" style="font-weight: bold; font-size: 16px;">Next Renewal:
                            {{ date('d-m-Y', strtotime($data['myplan']->expire_date)) }}</p>
                        <p class="text-danger" style="font-weight: bold; font-size: 16px;">
                            {{ round($datediff / (60 * 60 * 24)) > 1 ? round($datediff / (60 * 60 * 24)) . 'days' : round($datediff / (60 * 60 * 24)) . 'day' }}
                            left</p>
                    @endisset
                @endif


                <a href="{{ route('pricing structure merchant') }}" class="btn btn-info btn-block mt-3">Check out
                    Pricing</a>

            </div>
            <nav>
                <div class="main-navbar">
                    <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
                    <div id="mainnav">
                        <ul class="nav-menu custom-scrollbar">
                            <li class="back-btn">
                                <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2"
                                        aria-hidden="true"></i></div>
                            </li>



                            <li class="sidebar-main-title">
                                <div>
                                    <h6>MAIN NAVIGATION</h6>
                                </div>
                            </li>
                            <li class="dropdown">
                                <a class="nav-link menu-title active" href="javascript:void(0)"><i
                                        data-feather="home"></i><span style="color: #24695c;">Menu</span></a>
                                <ul class="nav-submenu menu-content" style="display: block;">
                                    <li><a href="{{ route('dashboard') }}" class="active">Dashboard</a></li>
                                    <li><a href="{{ route('merchant home') }}" class="">Main Page</a>
                                    </li>
                                </ul>
                            </li>


                            <li class="sidebar-main-title">
                                <div>
                                    <h6>Quick View</h6>
                                </div>
                            </li>

                            <li class="dropdown">
                                <a class="nav-link menu-title " href="javascript:void(0)"><i
                                        data-feather="shopping-bag"></i><span>Create & Send Invoice</span></a>
                                <ul class="nav-submenu menu-content">

                                    <li>
                                        <a href="{{ route('create single invoice') }}"><i
                                                class="fa fa-circle-o text-red"></i>
                                            Customer
                                            on PS</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('create link invoice') }}"><i
                                                class="fa fa-circle-o text-red"></i>
                                            Customer
                                            not on PS</a>
                                    </li>

                                    <li class="disp-0">
                                        <a class="sub-title " href="{{ route('create single invoice') }}">
                                            Single<span class="sub-arrow"><i
                                                    class="fa fa-chevron-right"></i></span>
                                        </a>
                                        <ul class="nav-sub-childmenu submenu-content">
                                            <li><a href="{{ route('create single invoice') }}"
                                                    class="">Customer
                                                    on PS
                                                </a></li>
                                            <li><a href="{{ route('create link invoice') }}"
                                                    class="">Customer
                                                    not on PS</a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li onclick="comingSoon()"><a href="javascript:void()"><i
                                                class="fa fa-circle-o text-red"></i>
                                            Batch [Coming Soon]</a></li>

                                </ul>
                            </li>



                            <li>
                                <a class="nav-link" href="{{ route('Withdraw Money') }}"><i
                                        data-feather="shopping-bag"></i><span>Withdraw Funds to Bank</span></a>
                            </li>

                            <li>
                                <a class="nav-link"
                                    href="{{ Auth::user()->country == 'Nigeria' ? route('utility bills') : route('select utility bills country', 'country=' . Auth::user()->country) }}"><i
                                        data-feather="shopping-bag"></i><span>Bill Payments</span></a>
                            </li>







                            <li class="sidebar-main-title">
                                <div>
                                    <h6>Set Up Invoice</h6>
                                </div>
                            </li>


                            <li class="dropdown">
                                <a class="nav-link menu-title link-nav " href="{{ route('invoice types') }}"><i
                                        data-feather="file-text"></i><span>Create Invoice Type</span></a>
                            </li>

                            <li class="dropdown">
                                <a class="nav-link menu-title " href="{{ route('set up tax') }}"><i
                                        data-feather="layers"></i><span>Create Taxes</span></a>
                            </li>

                            <li class="sidebar-main-title">
                                <div>
                                    <h6>Set Up Add/Withdraw Fund</h6>
                                </div>
                            </li>


                            <li class="dropdown">

                                <a class="nav-link menu-title link-nav " href="{{ route('payment gateway') }}">
                                    Credit Cards<span class="sub-arrow"><i class="fa fa-chevron-right"></i></span>
                                </a>
                            </li>
                            <li class="dropdown">

                                <a class="nav-link menu-title link-nav " href="{{ route('payment gateway') }}">
                                    Debit Visa/MasterCard<span class="sub-arrow"><i
                                            class="fa fa-chevron-right"></i></span>
                                </a>
                            </li>
                            <li class="dropdown">

                                <a class="nav-link menu-title link-nav " href="{{ route('payment gateway') }}">
                                    Bank Account<span class="sub-arrow"><i class="fa fa-chevron-right"></i></span>
                                </a>
                            </li>

                            @if (Auth::user()->country == 'Canada')
                                <li class="dropdown">

                                    <a class="nav-link menu-title link-nav " href="{{ route('payment gateway') }}">
                                        Prepaid Cards<span class="sub-arrow"><i
                                                class="fa fa-chevron-right"></i></span>
                                    </a>
                                </li>
                            @endif





                            <li class="sidebar-main-title">
                                <div>
                                    <h6>Tools to Grow Your Business</h6>
                                </div>
                            </li>


                            @if (Auth::user()->plan != 'basic')
                                <li>
                                    <a class="nav-link menu-title"
                                        href="{{ route('paysprint currency exchange') }}"><i
                                            data-feather="shopping-bag"></i><span>Currency Exchange</span></a>
                                </li>
                                <li>
                                    <a class="nav-link menu-title"
                                        href="{{ route('paysprint cross border payment') }}"><i
                                            data-feather="shopping-bag"></i><span>Cross Border Payment</span></a>
                                </li>
                            @endif


                            @if (Auth::user()->plan == 'classic')
                                <li>
                                    <a class="nav-link menu-title" href="{{ route('cash advance') }}"><i
                                            data-feather="shopping-bag"></i><span>Merchant Cash Advance</span></a>
                                </li>
                            @else
                                <li>
                                    <a class="nav-link menu-title" href="#"><i
                                            data-feather="shopping-bag"></i><span>Merchant Cash Advance <br><small
                                                class="text-danger text-center">[Upgrade account]</small></span></a>
                                </li>

                                <li>

                                    <a class="nav-link menu-title link-nav " href="javascript:void()"><i
                                            data-feather="database"></i><span>Manage eStore <br><small
                                                class="text-danger text-center">[Upgrade account]</small></span></a>

                                </li>
                            @endif


                            @if (Auth::user()->plan == 'classic')
                                <li>

                                    <a class="nav-link menu-title link-nav " href="{{ route('ordering system') }}"><i
                                            data-feather="database"></i><span>Manage eStore <br><small
                                                class="text-danger text-center">[Beta]</small></span></a>

                                </li>

                                <li>

                                    <a class="nav-link menu-title link-nav" href="javascript:void()"
                                        onclick="whatyouOffer('{{ Auth::user()->email }}')"><i
                                            data-feather="database"></i><span>Manage Rental Property </span></a>
                                </li>
                            @else
                                <li>
                                    <a class="nav-link menu-title" href="#"><i
                                            data-feather="shopping-bag"></i><span>Manage Rental Property <br><small
                                                class="text-danger text-center">[Upgrade account]</small></span></a>
                                </li>
                            @endif


                            <li class="sidebar-main-title">
                                <div>
                                    <h6>Reports</h6>
                                </div>
                            </li>

                            <li class="dropdown">
                                <a class="nav-link menu-title " href="javascript:void(0)"><i
                                        data-feather="clock"></i><span>Transaction History</span></a>
                                <ul class="nav-submenu menu-content" style="display: none;">
                                    <li><a href="{{ route('getStatement') }}" class="">Invoice</a>
                                    </li>
                                    {{-- <li><a href="{{ route('invoice statement') }}" class="">Invoice</a>
                                    </li> --}}
                                    <li><a href="{{ route('getwalletStatement') }}" class="">Wallet</a>
                                    </li>
                                    {{-- <li><a href="{{ route('wallet statement') }}" class="">Wallet</a>
                                    </li> --}}

                                </ul>
                            </li>

                            <li class="dropdown">
                                <a class="nav-link menu-title " href="javascript:void(0)"><i
                                        data-feather="aperture"></i><span>Performance</span></a>
                                <ul class="nav-submenu menu-content" style="display: none;">
                                    <li><a href="{{ route('sent invoice') }}" class="">Sent Invoice</a>
                                    </li>
                                    <li><a href="{{ route('paid invoice') }}" class="">Paid Invoice</a>
                                    </li>
                                    <li><a href="{{ route('unpaid invoice') }}" class="">Unpaid
                                            Invoice</a></li>
                                    {{-- <li><a href="{{ route('pending invoice') }}" class="">Unpaid
                                            Invoice</a></li> --}}
                                    <li><a href="{{ route('customer balance report') }}"
                                            class="">Customer
                                            Balance Report</a></li>
                                    {{-- <li><a href="{{ route('balance report') }}" class="">Customer
                                            Balance Report</a></li> --}}

                                    <li><a href="{{ route('tax report') }}" class="">Taxes Report</a>
                                    </li>
                                    {{-- <li><a href="{{ route('taxes report') }}" class="">Taxes Report</a>
                                    </li> --}}
                                    <li><a href="{{ route('invoice type') }}" class="">Invoice
                                            Type Report</a></li>
                                    {{-- <li><a href="{{ route('invoice type report') }}" class="">Invoice
                                            Type Report</a></li> --}}
                                    <li><a href="{{ route('recurring invoice') }}" class="">Recurring
                                            Invoice Report</a></li>
                                    {{-- <li><a href="{{ route('recurring type') }}" class="">Recurring
                                            Invoice Report</a></li> --}}
                                </ul>
                            </li>




                            <li class="sidebar-main-title">
                                <div>
                                    <h6>Accept Payment on Your Account</h6>
                                </div>
                            </li>

                            <li class="dropdown">
                                <a class="nav-link menu-title link-nav " href="{{ route('api integration') }}"><i
                                        data-feather="file-text"></i><span>API Integration</span></a>
                            </li>
                            <li class="dropdown">
                                <a class="nav-link menu-title link-nav " href="javascript:void(Tawk_API.toggle())"><i
                                        data-feather="file-text"></i><span>Get Support</span></a>
                                {{-- <a class="nav-link menu-title link-nav "
                                    href="https://paysprintworkspace.slack.com/archives/C02TBVDV37B" target="_blank"><i
                                        data-feather="file-text"></i><span>Get Support</span></a> --}}
                            </li>

                            <li class="sidebar-main-title">
                                <div>
                                    <h6>Settings</h6>
                                </div>
                            </li>

                            <li class="dropdown">
                                <a class="nav-link menu-title " href="{{ route('merchant profile') }}"><i
                                        data-feather="server"></i><span>Profile</span></a>
                            </li>
                            <li class="dropdown">
                                <a class="nav-link menu-title " href="{{ route('consumer points') }}"><i
                                        data-feather="server"></i><span>Refer and Earn</span></a>
                            </li>

                    </div>
                    <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
                </div>
            </nav>
        </header>
        <!-- Page Sidebar Ends-->
