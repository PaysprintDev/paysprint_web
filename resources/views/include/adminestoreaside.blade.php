<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="https://res.cloudinary.com/paysprint/image/upload/v1651130089/assets/paysprint_jpeg_black_bk_2_w4hzub_ioffkg.jpg" class="img-circle" alt="User Image">



            </div>
            <div class="pull-left info">

                @php
                $usersName = strlen(session('firstname') . ' ' . session('lastname')) < 15 ? session('firstname') . ' ' . session('lastname') : substr(session('firstname') . ' ' . session('lastname'), 0, 15) . '***' ; $usersBusiness=strlen(session('businessname')) < 15 ? session('businessname') : substr(session('businessname'), 0, 15) . '***' ; @endphp <p>{{ session('businessname') != null ? $usersBusiness : $usersName }}</p>
                    @if (session('role') != 'Super' && session('role') != 'Access to Level 1 only' && session('role') != 'Access to Level 1 and 2 only' && session('role') != 'Customer Marketing')
                    <a href="#"><i class="fa fa-circle text-success"></i> Account No: {{ session('user_id') }}</a>
                    @endif
            </div>
        </div>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                    </button>
                </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->

        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATIONS</li>
            <li class="active treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="active"><a href="{{ route('store dashboard') }}"><i class="fa fa-circle-o text-red"></i>
                            Dashboard</a></li>

                    @if (session('role') == 'Super')
                    <li><a href="{{ route('Admin') }}"><i class="fa fa-circle-o text-primary"></i> Back to
                            Admin</a>
                    </li>
                    @endif


                </ul>
            </li>

            <li class="">
                <a href="{{ route('review e-store') }}">
                    <i class="fa fa-book"></i>
                    <span>Review E-Store</span>
                    <!-- <span class="pull-right-container"> -->
                    </span>
                </a>
            </li>
            <li class="">
                <a href="{{ route('suspended stores') }}">
                    <i class="fa fa-book"></i>
                    <span>Suspended Stores</span>
                    <!-- <span class="pull-right-container"> -->
                    </span>
                </a>
            </li>
            <li class="">
                <a href="{{ route('products category') }}">
                    <i class="fa fa-book"></i>
                    <span>Products Category</span>
                    <span class="pull-right-container">
                    </span>
                </a>
            </li>
            {{-- <li class="">
                <a href="{{ route('feedback')}}">
            <i class="fa fa-book"></i>
            <span>Feedback</span>
            <span class="pull-right-container">
            </span>
            </a>
            </li> --}}
            <li class="">
                <a href="{{ route('refund and dispute report') }}">
                    <i class="fa fa-book"></i>
                    <span>Refund and Dispute Report</span>
                    <span class="pull-right-container">
                    </span>
                </a>
            </li>
            <li class="">
                <a href="{{ route('expired otp') }}">
                    <i class="fa fa-book"></i>
                    <span>Expired OTP</span>
                    <span class="pull-right-container">
                    </span>
                </a>
            </li>
            <li class="">
                <a href="{{ route('activate e-store') }}">
                    <i class="fa fa-book"></i>
                    <span>Activate Estore</span>
                    <span class="pull-right-container">
                    </span>
                </a>
            </li>
            <li class="">
                <a href="{{ route('unverified merchants') }}">
                    <i class="fa fa-book"></i>
                    <span>Upload Unverified Merchants List</span>
                    <span class="pull-right-container">
                    </span>
                </a>
            </li>









        </ul>

    </section>
    <!-- /.sidebar -->
</aside>