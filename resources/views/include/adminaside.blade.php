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

          @php
              $usersName = (strlen(session('firstname').' '.session('lastname')) < 15) ? session('firstname').' '.session('lastname') : substr(session('firstname').' '.session('lastname'), 0, 15)."***";
              $usersBusiness = (strlen(session('businessname')) < 15) ? session('businessname') : substr(session('businessname'), 0, 15)."***";
          @endphp

          <p>{{ (session('businessname') != NULL) ? $usersBusiness : $usersName }}</p>
          @if (session('role') != "Super" && session('role') != "Access to Level 1 only" && session('role') != "Access to Level 1 and 2 only" && session('role') != "Customer Marketing")
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
            <li><a href="{{ route('merchant home') }}"><i class="fa fa-circle-o text-primary"></i> Main Page</a></li>

            @if (session('role') == "Customer Marketing")
                <li title="Platform"><a href="{{ route('platform activity') }}"><i class="fa fa-circle-o text-red"></i> Platform</a></li>
                <li title="Activity Report"><a href="{{ route('activity report', 'country=Canada') }}"><i class="fa fa-circle-o text-red"></i> Activity Report</a></li>
            @endif

            @if (session('role') == "Super")

            <li class="treeview">
              <a href="#">
                <i class="fa fa-book"></i>
                <span>Special Information</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{ route('generate special information activity') }}"><i class="fa fa-circle-o"></i> Create</a></li>
              <li><a href="{{ route('special information activity') }}"><i class="fa fa-circle-o"></i> View All</a></li>

              </ul>
            </li>


            <li class="treeview">
              <a href="#">
                <i class="fa fa-book"></i>
                <span>Support Agent</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{ route('create user support agent') }}"><i class="fa fa-circle-o"></i> Create</a></li>
              <li><a href="{{ route('view user support agent') }}"><i class="fa fa-circle-o"></i> View All</a></li>

              </ul>
            </li>


            
          @endif
            
          </ul>
        </li>

        @if(session('role') == "Super" || session('role') == "Access to Level 1 and 2 only" || session('role') == "Access to Level 1 only")

        @if(session('role') == "Super" || session('role') == "Access to Level 1 and 2 only")

        <li class="treeview">
          <a href="#">
            <i class="fa fa-book"></i>
            <span>Activities</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li title="Platform"><a href="{{ route('platform activity') }}"><i class="fa fa-circle-o text-red"></i> Platform</a></li>
            <li title="Activity Report"><a href="{{ route('activity report', 'country=Canada') }}"><i class="fa fa-circle-o text-red"></i> Activity Report</a></li>
            <li title="Support"><a href="{{ route('support activity') }}"><i class="fa fa-circle-o text-red"></i> Support</a></li>


            <li class="treeview">
              <a href="#">
                <i class="fa fa-book"></i>
                <span>Gateway</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li title="Moneris"><a href="{{ route('gateway activity', 'gateway=moneris') }}"><i class="fa fa-circle-o text-red"></i> Moneris</a></li>
                <li title="PayStack"><a href="{{ route('gateway activity', 'gateway=paystack') }}"><i class="fa fa-circle-o text-red"></i> PayStack</a></li>
                <li title="Paypal"><a href="{{ route('gateway activity', 'gateway=PayPal') }}"><i class="fa fa-circle-o text-red"></i> Paypal</a></li>
                <li title="Stripe"><a href="{{ route('gateway activity', 'gateway=Stripe') }}"><i class="fa fa-circle-o text-red"></i> Stripe</a></li>

              </ul>
            </li>

          </ul>
        </li>

        <li>
          <a href="{{ route('sms wireless platform') }}">
            <i class="fa fa-book"></i>
            <span>SMS Platform</span>
          </a>
          
        </li>

        @endif

        @if(session('role') == "Super" || session('role') == "Access to Level 1 only")

        <li>
          <a href="{{ route('business report') }}">
            <i class="fa fa-book"></i>
            <span>Business Report</span>
          </a>
          
        </li>

        <li>
          <a href="{{ route('account report', 'country=Canada') }}">
            <i class="fa fa-book"></i>
            <span>Account Report</span>
          </a>
          
        </li>

        @endif


        @if(session('role') == "Super" || session('role') == "Access to Level 1 and 2 only")
        <li>
          <a href="{{ route('all countries') }}">
            <i class="fa fa-book"></i>
            <span>All Countries</span>
          </a>
          
        </li>


        


        {{-- <li class="treeview">
          <a href="#">
            <i class="fa fa-book"></i>
            <span>Business Report</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('inflow reports') }}"><i class="fa fa-circle-o text-green"></i> Inflow </a></li>
            <li><a href="{{ route('withdrawal reports') }}"><i class="fa fa-circle-o text-red"></i> Withdrawal</a></li>
            <li><a href="{{ route('charge reports') }}"><i class="fa fa-circle-o text-red"></i> Charge</a></li>
            <li><a href="{{ route('expected balance reports') }}"><i class="fa fa-circle-o text-red"></i> Expected Balance</a></li>
            <li><a href="{{ route('actual balance reports') }}"><i class="fa fa-circle-o text-red"></i> Actual Balance</a></li>
            <li><a href="{{ route('reconsilation reports') }}"><i class="fa fa-circle-o text-red"></i> Reconsilation</a></li>

          </ul>
        </li> --}}

        <li class="treeview disp-0">
          <a href="#">
            <i class="fa fa-book"></i>
            <span>Transaction History & Invoicing</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li onclick="openModal('singleDoc1')"><a href="#"><i class="fa fa-circle-o text-green"></i> Single </a></li>
            <li onclick="openModal('uploadDoc')"><a href="#"><i class="fa fa-circle-o text-red"></i> Batch</a></li>
            
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
            <i class="far fa-handshake"></i>
            <span>Withdrawal Request</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li title="Credit/Debit Card"><a href="{{ route('card request withdrawal') }}"><i class="fa fa-circle-o text-red"></i> Credit/Debit Card</a></li>
            <li title="prepaid Card"><a href="{{ route('prepaid request withdrawal') }}"><i class="fa fa-circle-o text-red"></i> Prepaid Card</a></li>
            <li title="Bank Account"><a href="{{ route('bank request withdrawal') }}"><i class="fa fa-circle-o text-red"></i> Bank Account</a></li>

          </ul>
        </li>


        <li class="treeview">
          <a href="#">
            <i class="far fa-handshake"></i>
            <span>Processed Withdrawals</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li title="Credit/Debit Card"><a href="{{ route('card processed withdrawal') }}"><i class="fa fa-circle-o text-red"></i>Credit/Debit Card</a></li>
            
            <li title="Bank Account"><a href="{{ route('bank processed withdrawal') }}"><i class="fa fa-circle-o text-red"></i> Bank Account</a></li>

            <li title="Processed Refunds"><a href="{{ route('refund processed') }}"><i class="fa fa-circle-o text-red"></i> Processed Refunds</a></li>

          </ul>
        </li>


        <li class="treeview">
          <a href="#">
            <i class="far fa-handshake"></i>
            <span>Pending Transactions</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li title="Transfers"><a href="{{ route('pending transfer') }}"><i class="fa fa-circle-o text-red"></i> Transfers</a></li>
            <li title="Text-Transfer"><a href="{{ route('text to transfer') }}"><i class="fa fa-circle-o text-red"></i>Text-Transfer</a></li>

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
            <li title="Text-to-Transfer Refund"><a href="{{ route('refund money request') }}"><i class="fa fa-circle-o text-red"></i> Text-to-Transfer</a></li>
            <li title="Wallet Purchase Refund"><a href="{{ route('purchase refund request') }}"><i class="fa fa-circle-o text-red"></i> Wallet Purchase</a></li>
            {{--  <li title="To Bank Account"><a href="#"><i class="fa fa-circle-o text-red"></i> To Bank Account</a></li>  --}}

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
            <li title="Prepaid Card Issuer"><a href="{{ route('card issuer') }}"><i class="fa fa-circle-o text-red"></i> Prepaid Card Issuer</a></li>
            <li title="Prepaid Card Request"><a href="{{ route('prepaid card request') }}"><i class="fa fa-circle-o text-red"></i> Prepaid Card Request</a></li>
            <li title="Added Cards"><a href="{{ route('all added cards') }}"><i class="fa fa-circle-o text-red"></i> Added Cards</a></li>
            <li title="Deleted Cards"><a href="{{ route('all deleted cards') }}"><i class="fa fa-circle-o text-red"></i> Deleted Cards</a></li>
          </ul>
        </li>
        @endif

        @if(session('role') == "Super" || session('role') == "Access to Level 1 only" || session('role') == "Access to Level 1 and 2 only")

        <li class="treeview">
          <a href="#">
            <i class="fas fa-wallet"></i>
            <span>Wallet</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li title="Balance"><a href="{{ route('wallet balance') }}"><i class="fa fa-circle-o text-red"></i> Balance</a></li>
            {{-- <li title="Processed Payment"><a href="{{ route('processed payment') }}"><i class="fa fa-circle-o text-red"></i> Processed Payment</a></li> --}}
            <li title="Maintenance Fee"><a href="{{ route('maintenance fee detail') }}"><i class="fa fa-circle-o text-red"></i> Maintenance Fee</a></li>

            <li title="Wallet Statement"><a href="{{ route('users wallet statement') }}"><i class="fa fa-circle-o text-red"></i> Wallet Statement</a></li>

            <li title="Wallet Purchase"><a href="{{ route('users wallet purchase') }}"><i class="fa fa-circle-o text-red"></i> Wallet Purchase</a></li>

            <li title="Purchase Statement"><a href="{{ route('user purchase statement', 'country=Nigeria&start='.date('Y-m-01').'&end='.date('Y-m-d')) }}"><i class="fa fa-circle-o text-red"></i> Purchase Statement</a></li>

          </ul>
        </li>

        @endif


        @if(session('role') == "Super" || session('role') == "Access to Level 1 and 2 only")

        <li class="treeview">
          <a href="#">
            <i class="fas fa-money-bill"></i>
            <span>Fee</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li title="Set up"><a href="{{ route('fee structure') }}"><i class="fa fa-circle-o text-red"></i> Set up</a></li>
            <li title="By Country"><a href="{{ route('fee structure by country') }}"><i class="fa fa-circle-o text-red"></i> By Country</a></li>
            <li title="Pricing Set Up"><a href="{{ route('pricing setup') }}"><i class="fa fa-circle-o text-red"></i> Pricing Set Up</a></li>
            <li title="Pricing Set Up"><a href="{{ route('pricing setup by country') }}"><i class="fa fa-circle-o text-red"></i> Pricing By Country</a></li>

          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fas fa-lock"></i>
            <span>Security</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li title="Red Flagged"><a href="{{ route('red flagged account') }}"><i class="fa fa-circle-o text-red"></i> Red Flagged</a></li>
            <li title="Added Money - Flagged"><a href="{{ route('red flagged money') }}"><i class="fa fa-circle-o text-red"></i> Added Money - Flagged</a></li>
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

        @endif



        @elseif(session('role') != "Super" && session('role') != "Access to Level 1 only" && session('role') != "Access to Level 1 and 2 only" && session('role') != "Customer Marketing")


        

        <li class="treeview createandSendInvoice" title="Create and Send Invoice">
          <a href="#">
            <i class="fa fa-book"></i>
            <span> Create and Send Invoice</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li ><a href="{{ route('create single invoice') }}"><i class="fa fa-circle-o text-green"></i> Single </a></li>
            {{-- <li ><a href="{{ route('create bulk invoice') }}"><i class="fa fa-circle-o text-red"></i> Batch</a></li> --}}
             <li onclick="comingSoon()"><a href="javascript:void()"><i class="fa fa-circle-o text-red"></i> Batch [Coming Soon]</a></li> 
            {{-- <li><a href="#"><i class="fa fa-circle-o text-info"></i> Check Sold Tickets</a></li>
            <li><a href="#"><i class="fa fa-circle-o text-warning"></i> Check Event Status</a></li> --}}
          </ul>
        </li>

        <li class="treeview transactionHistory">
          <a href="#">
            <i class="fa fa-book"></i>
            <span>Transaction History</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('getStatement') }}"><i class="fa fa-circle-o text-info"></i> Invoice</a></li>
            <li><a href="{{ route('getwalletStatement') }}"><i class="fa fa-circle-o text-info"></i> Wallet</a></li>
            {{-- <li><a href="#"><i class="fa fa-circle-o text-info"></i> Check Sold Tickets</a></li>
            <li><a href="#"><i class="fa fa-circle-o text-warning"></i> Check Event Status</a></li> --}}
          </ul>
        </li>


        <li class="treeview performanceReport">
          <a href="#">
            <i class="fa fa-book"></i>
            <span>Performance Report</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('sent invoice') }}"><i class="fa fa-circle-o text-info"></i> Sent Invoice</a></li>
            <li><a href="{{ route('paid invoice') }}"><i class="fa fa-circle-o text-info"></i> Paid Invoice</a></li>
            <li><a href="{{ route('unpaid invoice') }}"><i class="fa fa-circle-o text-info"></i> Unpaid (Pending) Invoice</a></li>
            <li><a href="{{ route('customer balance report') }}"><i class="fa fa-circle-o text-info"></i> Customer Balance Report</a></li>
            <li><a href="{{ route('tax report') }}"><i class="fa fa-circle-o text-info"></i> Taxes Report</a></li>
            <li><a href="{{ route('invoice type') }}"><i class="fa fa-circle-o text-info"></i> Invoice Type Report</a></li>
            <li><a href="{{ route('recurring invoice') }}"><i class="fa fa-circle-o text-info"></i> Recurring invoice report</a></li>
          </ul>
        </li>


        <li class="createInvoiceType">
          <a href="{{ route('create service types') }}">
            <i class="fa fa-book"></i>
            <span>Create Invoice Type</span>
          </a>
        </li>


        <li class="setupTax">
          <a href="{{ route('setup tax') }}">
            <i class="fa fa-book"></i>
            <span>Set Up Tax</span>
          </a>
        </li>


        <li class="apiIntegration">
          <a href="{{ route('api integration') }}" target="_blank">
            <i class="fa fa-book"></i>
            <span>API Integration</span>
          </a>
        </li>

        <li class="treeview accountsettings">
          <a href="#">
            <i class="fa fa-wrench"></i>
            <span>Settings</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('merchant profile') }}"><i class="fa fa-circle-o text-info"></i> Profile</a></li>
            
          </ul>
        </li>
        <br>
        <br>



            @if ($pages == "My Dashboard")
                    <li class="quicksetup">
                <div class="card" style="width: auto;">
                            <div class="card-header" style="background-color: #f6b60b; padding: 10px; font-weight: bold; border-radius: 10px 10px 0px 0px;">
                                Quick Wallet Setup
                                @if ($getUserDetail->approval == 0 || count($getCard) <= 0 && count($getBank) <= 0 || $getUserDetail->transaction_pin == null || $getUserDetail->securityQuestion == null)
                                <br>
                                    <a href="javascript:void()" type="button" class="btn btn-danger fa-blink">Incomplete</a>
                                @endif
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item" title="Upload Government issued photo ID e.g National ID, International Passport, Driver Licence">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <a href="{{ route('merchant profile') }}" style="color: navy; font-weight: 700;">Identity Verification</a>
                                        </div>
                                        <div class="col-md-2">
                                            {!! $getUserDetail->approval > 0 ? "<img src='https://img.icons8.com/fluent/20/000000/check-all.png'/>" : "<img class='fa-blink' src='https://img.icons8.com/fluent/20/000000/cancel.png'/>" !!}
                                        </div>
                                    </div>

                                    </li>
                                <li class="list-group-item" title="To add money to your wallet, you need to add a credit/debit card to your account">

                                    <div class="row">
                                        <div class="col-md-10">
                                             <a href="{{ route('merchant payment gateway', 'gateway=PaySprint') }}" style="color: navy; font-weight: 700;">Add Card/Bank Account </a>
                                        </div>
                                        <div class="col-md-2">
                                            {!! count($getCard) > 0 || count($getBank) > 0 ? "<img src='https://img.icons8.com/fluent/20/000000/check-all.png'/>" : "<img class='fa-blink' src='https://img.icons8.com/fluent/20/000000/cancel.png'/>" !!}
                                        </div>
                                    </div>

                                   
                                </li>
                                <li class="list-group-item" title="Setup transaction pin for security purpose" >

                                    <div class="row">
                                        <div class="col-md-10">
                                            <a href="{{ route('merchant profile') }}" style="color: navy; font-weight: 700;">Set Transaction Pin </a>
                                        </div>
                                        <div class="col-md-2">
                                            {!! $getUserDetail->transaction_pin != null ? "<img src='https://img.icons8.com/fluent/20/000000/check-all.png'/>" : "<img class='fa-blink' src='https://img.icons8.com/fluent/20/000000/cancel.png'/>" !!}
                                        </div>
                                    </div>
                                    
                                
                                </li>
                                <li class="list-group-item" title="Setup transaction pin for security purpose" >

                                    <div class="row">
                                        <div class="col-md-10">
                                            <a href="{{ route('merchant profile') }}" style="color: navy; font-weight: 700;">Set Security Question </a>
                                        </div>
                                        <div class="col-md-2">
                                            {!! $getUserDetail->securityQuestion != null ? "<img src='https://img.icons8.com/fluent/20/000000/check-all.png'/>" : "<img class='fa-blink' src='https://img.icons8.com/fluent/20/000000/cancel.png'/>" !!}
                                        </div>
                                    </div>
                                    
                                    
                                
                                </li>

                                @if ($getUserDetail->country == "Nigeria")
                                    <li class="list-group-item" title="Bank Verification (BVN)" >

                                    <div class="row">
                                        <div class="col-md-10">
                                            <a href="{{ route('merchant profile') }}" style="color: navy; font-weight: 700;">Bank Verification (BVN) </a>
                                        </div>
                                        <div class="col-md-2">
                                            {!! $getUserDetail->bvn_verification != null || $getUserDetail->bvn_verification != 0 ? "<img src='https://img.icons8.com/fluent/20/000000/check-all.png'/>" : "<img class='fa-blink' src='https://img.icons8.com/fluent/20/000000/cancel.png'/>" !!}
                                        </div>
                                    </div>
                                    
                                    
                                
                                </li>
                                @endif
                                
                                <li class="list-group-item" title="Set up Tax" >

                                    <div class="row">
                                        <div class="col-md-10">
                                            <a href="{{ route('setup tax') }}" style="color: navy; font-weight: 700;">Set Up Tax</a>
                                        </div>
                                        <div class="col-md-2">
                                            {!! count($getTax) > 0 ? "<img src='https://img.icons8.com/fluent/20/000000/check-all.png'/>" : "<img class='fa-blink' src='https://img.icons8.com/fluent/20/000000/cancel.png'/>" !!}
                                        </div>
                                    </div>
                                    
                                    
                                
                                </li>
                            </ul>
                    </div>


                        <div class="card utilityBills" style="width: 100%;">
                                <div class="card-header" style="background-color: #ff8a04; padding: 10px; font-weight: bold; border-radius: 10px 10px 0px 0px;">
                                    Pay Utility Bills
                                </div>
                                <ul class="list-group list-group-flush">

                                
                                    <li class="list-group-item" title="Pay Utility Bills">
                                        <div class="row">
                                            <div class="col-md-12">

                                              @if (session('country') == "Nigeria")
                                                    <a href="{{ route('utility bills') }}" style="color: navy; font-weight: 700;">Utility Payment</a>
                                                @else
                                                    <a href="{{ route('select utility bills country') }}" style="color: navy; font-weight: 700;">Utility Payment</small></a>
                                                @endif


                                                
                                            </div>
                                        </div>

                                        </li>
                                    
                                </ul>
                        </div>



                <div class="card propertyManagement" style="width: 100%;">
                            <div class="card-header" style="background-color: #5ed998; padding: 10px; font-weight: bold; border-radius: 10px 10px 0px 0px;">
                                Property Management
                                
                            </div>
                            <ul class="list-group list-group-flush">

                            
                                <li class="list-group-item" title="Rental Property Management">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <a href="{{ route('rentalManagementAdmin') }}" style="color: navy; font-weight: 700;">Rental Property Management</a>
                                        </div>
                                    </div>

                                    </li>
                                
                            </ul>
                    </div>
        </li>
        @endif


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

