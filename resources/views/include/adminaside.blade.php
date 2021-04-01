 <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ asset('images/payca.png') }}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{ session('firstname').' '.session('lastname') }}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
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

        <li class="treeview">
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

        <li class="treeview">
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

        <li class="treeview">
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

        <li>
          <a href="{{ route('fee structure') }}">
            <i class="fa fa-laptop"></i>
            <span>Fee Structure</span>
          </a>
        </li>

        <li class="disp-0">
          <a href="#">
            <i class="fa fa-laptop"></i>
            <span>Wallet Report</span>
          </a>
        </li>

        <li onclick="openModal('transactioncost')" class="disp-0">
          <a href="#">
            <i class="fa fa-laptop"></i>
            <span>Transaction Cost</span>
          </a>
        </li>

        <li class="treeview">
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
        <li class="treeview">
          <a href="#">
            <i class="fa fa-book"></i>
            <span>Invoice</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li onclick="openModal('singleDoc1')"><a href="#"><i class="fa fa-circle-o text-green"></i> Single Invoice </a></li>
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
            {{-- <li><a href="#"><i class="fa fa-circle-o text-info"></i> Check Sold Tickets</a></li>
            <li><a href="#"><i class="fa fa-circle-o text-warning"></i> Check Event Status</a></li> --}}
          </ul>
        </li>

        <li class="treeview">
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

