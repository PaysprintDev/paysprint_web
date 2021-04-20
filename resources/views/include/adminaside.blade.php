 <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="https://res.cloudinary.com/pilstech/image/upload/v1618251695/paysprint_icon_new_kg2h3j.png" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{ session('firstname').' '.session('lastname') }}</p>
          @if (session('role') != "Super")
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
        <li class="header">MAIN NAVIGATION</li>
        <li class="active treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Menu</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="active"><a href="{{ route('Admin') }}"><i class="fa fa-circle-o text-red"></i> Dashboard</a></li>
            <li class="active"><a href="{{ route('home') }}"><i class="fa fa-circle-o text-primary"></i> Main Page</a></li>
            {{-- <li><a href="index2.html"><i class="fa fa-circle-o"></i> Dashboard v2</a></li> --}}
          </ul>
        </li>

        @if(session('role') == "Super")

        <li class="treeview disp-0">
          <a href="#">
            <i class="fa fa-book"></i>
            <span>Statement & Invoicing</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li onclick="openModal('singleDoc1')"><a href="#"><i class="fa fa-circle-o text-green"></i> Single Invoice </a></li>
            <li onclick="openModal('uploadDoc')"><a href="#"><i class="fa fa-circle-o text-red"></i> Bulk Invoice</a></li>
            
            {{-- <li><a href="#"><i class="fa fa-circle-o text-warning"></i> Check Event Status</a></li> --}}
          </ul>
        </li>

        <li class="treeview disp-0">
          <a href="#">
            <i class="fa fa-book"></i>
            <span>Remittance Report</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('paycaremittance') }}"><i class="fa fa-circle-o text-green"></i> Invoice </a></li>
            <li><a href="{{ route('remittance') }}"><i class="fa fa-circle-o text-red"></i> Money Transfer</a></li>
            {{-- <li><a href="#"><i class="fa fa-circle-o text-warning"></i> Check Event Status</a></li> --}}
          </ul>
        </li>

        <li class="treeview disp-0">
          <a href="#">
            <i class="fa fa-book"></i>
            <span>Remitted Report</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('remittancepaycareport') }}"><i class="fa fa-circle-o text-green"></i> Invoice </a></li>
            <li><a href="{{ route('remittanceepayreport') }}"><i class="fa fa-circle-o text-red"></i> Money Transfer</a></li>

            {{-- <li><a href="#"><i class="fa fa-circle-o text-warning"></i> Check Event Status</a></li> --}}
          </ul>
        </li>

        <li class="treeview disp-0">
          <a href="#">
            <i class="fa fa-book"></i>
            <span>In-house Report</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('clientfeereport') }}"><i class="fa fa-circle-o text-red"></i> Client Fee Report</a></li>
            <li><a href="{{ route('collectionfee') }}"><i class="fa fa-circle-o text-red"></i> General Fee Report</a></li>
            <li><a href="{{ route('comissionreport') }}"><i class="fa fa-circle-o text-red"></i> Commission Report</a></li>

            {{-- <li><a href="#"><i class="fa fa-circle-o text-warning"></i> Check Event Status</a></li> --}}
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fas fa-money-bill"></i>
            <span>Fee Structure</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li title="Set up Fee Structure"><a href="{{ route('fee structure') }}"><i class="fa fa-circle-o text-red"></i> Set up Fee Structure</a></li>
            <li title="Structure by Country"><a href="{{ route('fee structure by country') }}"><i class="fa fa-circle-o text-red"></i> Structure by Country</a></li>

          </ul>
        </li>


        <li class="treeview">
          <a href="#">
            <i class="fas fa-wallet"></i>
            <span>Wallet</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li title="Wallet Balance"><a href="{{ route('wallet balance') }}"><i class="fa fa-circle-o text-red"></i> Wallet Balance</a></li>
            <li title="Processed Payment"><a href="{{ route('processed payment') }}"><i class="fa fa-circle-o text-red"></i> Processed Payment</a></li>
            <li title="Credit Card Withdrawal"><a href="#"><i class="fa fa-circle-o text-red"></i> Credit Card Withdrawal</a></li>
            <li title="Refund Request"><a href="#"><i class="fa fa-circle-o text-red"></i> Refund Request</a></li>
            <li title="Maintenance Fee"><a href="#"><i class="fa fa-circle-o text-red"></i> Maintenance Fee</a></li>

          </ul>
        </li>


        <li class="treeview">
          <a href="#">
            <i class="far fa-handshake"></i>
            <span>Withdrawal</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li title="Credit Card"><a href="#"><i class="fa fa-circle-o text-red"></i> Credit Card</a></li>
            <li title="Prepaid Card"><a href="#"><i class="fa fa-circle-o text-red"></i> Prepaid Card</a></li>
            <li title="Bank Account"><a href="{{ route('bank request withdrawal') }}"><i class="fa fa-circle-o text-red"></i> Bank Account</a></li>

          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="far fa-money-bill-alt"></i>
            <span>Refund</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li title="To Wallet"><a href="#"><i class="fa fa-circle-o text-red"></i> To Wallet</a></li>
            <li title="To Bank Account"><a href="#"><i class="fa fa-circle-o text-red"></i> To Bank Account</a></li>

          </ul>
        </li>


        <li class="treeview">
          <a href="#">
            <i class="fa fa-credit-card"></i>
            <span>Card</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li title="Card Issuer"><a href="{{ route('card issuer') }}"><i class="fa fa-circle-o text-red"></i> Card Issuer</a></li>
            <li title="Added Cards"><a href="{{ route('all added cards') }}"><i class="fa fa-circle-o text-red"></i> Added Cards</a></li>
            <li title="Red Flagged"><a href="{{ route('red flagged account') }}"><i class="fa fa-circle-o text-red"></i> Red Flagged</a></li>

          </ul>
        </li>

        <li onclick="openModal('transactioncost')" class="disp-0">
          <a href="#">
            <i class="fa fa-laptop"></i>
            <span>Transaction Cost</span>
          </a>
        </li>

        <li class="treeview disp-0">
          <a href="#">
            <i class="fa fa-laptop"></i>
            <span>Money Transfer Trans...</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('xreceivemoney') }}"><i class="fa fa-circle-o text-red"></i> Receive Money</a></li>
            <li><a href="{{ route('xpaytrans') }}"><i class="fa fa-circle-o text-red"></i> Send Money</a></li>

          </ul>
        </li>
{{-- 
        <li>
          <a href="{{ route('xpaytrans') }}">
            <i class="fa fa-laptop"></i>
            <span>Money Transfer Trans...</span>
          </a>
        </li> --}}



        @else
        <li class="treeview" title="Create and Send Invoice">
          <a href="#">
            <i class="fa fa-book"></i>
            <span> Create and Send Invoi..</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li onclick="openModal('create single invoice')"><a href="#"><i class="fa fa-circle-o text-green"></i> Single Invoice </a></li>
            <li onclick="openModal('uploadDoc')"><a href="#"><i class="fa fa-circle-o text-red"></i> Bulk Invoice</a></li>
            {{-- <li><a href="#"><i class="fa fa-circle-o text-info"></i> Check Sold Tickets</a></li>
            <li><a href="#"><i class="fa fa-circle-o text-warning"></i> Check Event Status</a></li> --}}
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-book"></i>
            <span>Statement</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('getStatement') }}"><i class="fa fa-circle-o text-info"></i> Check Statement</a></li>
            <li><a href="{{ route('getwalletStatement') }}"><i class="fa fa-circle-o text-info"></i> Wallet Statement</a></li>
            {{-- <li><a href="#"><i class="fa fa-circle-o text-info"></i> Check Sold Tickets</a></li>
            <li><a href="#"><i class="fa fa-circle-o text-warning"></i> Check Event Status</a></li> --}}
          </ul>
        </li>


        <li>
          <a href="{{ route('create service types') }}">
            <i class="fa fa-book"></i>
            <span>Create Service Type</span>
          </a>
        </li>


        <li>
          <a href="{{ route('api integration') }}">
            <i class="fa fa-book"></i>
            <span>API Integration</span>
          </a>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-wrench"></i>
            <span>Settings</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-circle-o text-info"></i> Profile</a></li>
            
          </ul>
        </li>


        <li class="treeview disp-0">
          <a href="#">
            <i class="fa fa-book"></i>
            <span>Report</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('payreport') }}"><i class="fa fa-circle-o text-info"></i> PaySprint Collection Report</a></li>
            <li><a href="{{ route('epayreport') }}"><i class="fa fa-circle-o text-info"></i> Send Money Collection Report</a></li>
            <li><a href="{{ route('payremittancereport') }}"><i class="fa fa-circle-o text-info"></i> PaySprint Remittance Report</a></li>
            <li><a href="{{ route('epayremittancereport') }}"><i class="fa fa-circle-o text-info"></i> Send Money Remittance Report</a></li>
            {{-- <li><a href="#"><i class="fa fa-circle-o text-info"></i> Check Sold Tickets</a></li>
            <li><a href="#"><i class="fa fa-circle-o text-warning"></i> Check Event Status</a></li> --}}
          </ul>
        </li>

        
          <li class="treeview disp-0">
          <a href="#">
            <i class="fa fa-book"></i>
            <span>Event Ticket</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li onclick="openModal('create_event')"><a href="#"><i class="fa fa-circle-o text-red"></i> Create Ticket</a></li>
            <li><a href="#"><i class="fa fa-circle-o text-info"></i> Check Sold Tickets</a></li>
            <li><a href="#"><i class="fa fa-circle-o text-warning"></i> Check Event Status</a></li>
          </ul>
        </li>

        <li class="treeview disp-0">
          <a href="#">
            <i class="fa fa-laptop"></i>
            <span>Billings</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-circle-o text-purple"></i> Upload Billings</a></li>
            <li><a href="#"><i class="fa fa-circle-o text-success"></i> view All Billings</a></li>

          </ul>
        </li>
        @endif




      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

