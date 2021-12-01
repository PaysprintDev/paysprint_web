<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="https://res.cloudinary.com/pilstech/image/upload/v1618251695/paysprint_icon_new_kg2h3j.png"
                    class="img-circle" alt="User Image">



            </div>
            <div class="pull-left info">

                @php
                    $usersName = strlen(session('firstname') . ' ' . session('lastname')) < 15 ? session('firstname') . ' ' . session('lastname') : substr(session('firstname') . ' ' . session('lastname'), 0, 15) . '***';
                    $usersBusiness = strlen(session('businessname')) < 15 ? session('businessname') : substr(session('businessname'), 0, 15) . '***';
                @endphp

                <p>{{ session('businessname') != null ? $usersBusiness : $usersName }}</p>
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
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i
                            class="fa fa-search"></i>
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
                    <li class="active"><a href="{{ route('aml dashboard') }}"><i
                                class="fa fa-circle-o text-red"></i>
                            Dashboard</a></li>

                    @if (session('role') == 'Super')
                        <li><a href="{{ route('Admin') }}"><i class="fa fa-circle-o text-primary"></i> Back to
                                Admin</a>
                        </li>
                    @endif


                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-book"></i>
                    <span>Activity Log</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li title="Platform"><a href="{{ route('platform') }}"><i class="fa fa-circle-o text-red"></i>
                            Platform</a></li>
                    <li><a href="{{ route('customer service') }}"><i class="fa fa-circle-o text-red"></i> Customer
                            Service</a></li>
                    <li><a href="{{ route('technology') }}"><i class="fa fa-circle-o text-red"></i> Technology</a>
                    </li>






                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-book"></i>
                    <span>Transaction Review</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li title="Request for Withdrawal to bank"><a
                            href="{{ route('Request aml for Withdrawal to bank') }}"><i
                                class="fa fa-circle-o text-red"></i><?php $string = 'Request for Withdrawal to bank';
$output = strlen($string) > 25 ? substr($string, 0, 25) . '...' : $string;
echo $output; ?></a></li>
                    <li title="Purchase aml Refund Request"><a href="{{ route('Purchase aml Refund Request') }}"><i
                                class="fa fa-circle-o text-red"></i><?php $string = 'Purchase aml Refund Request';
$output = strlen($string) > 25 ? substr($string, 0, 25) . '...' : $string;
echo $output; ?></a></li>
                    <li title=" Credit Card Withdrawal Request"><a
                            href="{{ route('Credit Card withdrawal Request') }}"><i
                                class="fa fa-circle-o text-red"></i><?php $string = ' Credit Card Withdrawal Request';
$output = strlen($string) > 25 ? substr($string, 0, 25) . '...' : $string;
echo $output; ?></a></li>
                    <li title=" Pending Transfer"><a href="{{ route('Pending aml Transfer') }}"><i
                                class="fa fa-circle-o text-red"></i> <?php $string = 'Pending Transfer';
$output = strlen($string) > 25 ? substr($string, 0, 25) . '...' : $string;
echo $output; ?></a></li>
                    <li title="Prepaid Card Withdrawal Request"><a
                            href="{{ route('Prepaid Card withdrawal Request') }}"><i
                                class="fa fa-circle-o text-red"></i> <?php $string = 'Prepaid Card Withdrawal Request';
$output = strlen($string) > 25 ? substr($string, 0, 25) . '...' : $string;
echo $output; ?> </a></li>
                    <li title="Request for Remitance to Client"><a
                            href="{{ route('Request for Remittance to Client') }}"><i
                                class="fa fa-circle-o text-red"></i><?php $string = 'Request for Remittance to Client';
$output = strlen($string) > 25 ? substr($string, 0, 25) . '...' : $string;
echo $output; ?></a></li>
                    <li title="Request for Refund"><a href="{{ route('Request for Refund') }}"><i
                                class="fa fa-circle-o text-red"></i><?php $string = 'Request for Refund';
$output = strlen($string) > 25 ? substr($string, 0, 25) . '...' : $string;
echo $output; ?></a></li>

                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-book"></i>
                            <span>Banking Information</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li title="Platform"><a
                                    href="{{ route('merchant banking detail aml', 'users=Merchant') }}"><i
                                        class="fa fa-circle-o text-red"></i> Merchant Bank Details</a></li>
                            <li title="Activity Report"><a
                                    href="{{ route('merchant banking detail aml', 'users=Consumer') }}"><i
                                        class="fa fa-circle-o text-red"></i> Consumer Bank Details</a></li>

                        </ul>

                    <li title="Top-Up Red Flagged"><a href="{{ route('Top-Up Red Flagged') }}"><i
                                class="fa fa-circle-o text-red"></i><?php $string = 'Top-Up Red Flagged';
$output = strlen($string) > 25 ? substr($string, 0, 25) . '...' : $string;
echo $output; ?></a></li>

                </ul>

            </li>
            <li title="Transaction Analysis"><a href="{{ route('aml transaction analysis') }}"><i
                        class="fa fa-circle-o text-red"></i> Transaction Analysis</a></li>

            <li title="Compliance Desk Review"><a href="{{ route('aml compliance desk review') }}"><i
                        class="fa fa-circle-o text-red"></i> Compliance Desk Review</a></li>



            <li class="treeview">
                <a href="#">
                    <i class="fa fa-book"></i>
                    <span>Reports</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li title="Compliance"><a href="{{ route('Compliance') }}"><i
                                class="fa fa-circle-o text-red"></i> Compliance</a></li>
                    <li title="Suspicious Transaction"><a href="{{ route('Suspicious Transaction') }}"><i
                                class="fa fa-circle-o text-red"></i> Suspicious Transaction</a></li>

                </ul>

            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-book"></i>
                    <span>AML/Compliance Guide</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li title="View"><a href="{{ route('View') }}"><i class="fa fa-circle-o text-red"></i> View</a>
                    </li>
                    <li title="Upload"><a href="{{ route('Upload') }}"><i class="fa fa-circle-o text-red"></i>
                            Upload</a></li>

                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-book"></i>
                    <span>Resources</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li title="Link to FinTRAC"><a
                            href="https://www10.fintrac-canafe.gc.ca/msb-esm/public/msb-search/name-search-results/7b227072696d617279536561726368223a7b226f72674e616d65223a22706179737072696e74222c2273656172636854797065223a317d7d/"
                            target="_blank"><i class="fa fa-circle-o text-red"></i> Link to FinTRAC</a></li>
                    <li title="LInK to FINCEN"><a href="https://www.fincen.gov/msb-registrant-search" target="_blank"><i
                                class="fa fa-circle-o text-red"></i> LInK to FINCEN</a></li>
                    <li title="LInK to Trulioo"><a href="https://www.trulioo.com/" target="_blank"><i
                                class="fa fa-circle-o text-red"></i> LInK to Trulioo</a></li>

                </ul>
            </li>






        </ul>

    </section>
    <!-- /.sidebar -->
</aside>
