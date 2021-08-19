@extends('layouts.dashboard')


@section('dashContent')

<?php use \App\Http\Controllers\ClientInfo; ?>
<?php use \App\Http\Controllers\User; ?>
<?php use \App\Http\Controllers\UserClosed; ?>
<?php use \App\Http\Controllers\InvoicePayment; ?>
<?php use \App\Http\Controllers\AllCountries; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard

        @if (session('role') != "Super"  && session('role') != "Access to Level 1 and 2 only" && session('role') != "Access to Level 1 only")

          @if($userInfo = \App\User::where('ref_code', session('user_id'))->first())

            @if(isset($userInfo))

              <h4 class="welcome" style="color: green; font-weight: bold;">Account Number: {{ $userInfo->ref_code }}</h4>


              @if ($userInfo->approval == 0 || $userInfo->accountLevel == 0)
            <div class="row">
                <div class="alert bg-danger alert-dismissible show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                
                <p>
                    <strong>Welcome {{ $userInfo->name }}!</strong> <br> Our system is yet to complete your registration. Kindly upload a copy of Government-issued Photo ID, a copy of a Utility Bill or Bank Statement that matches your name with the current address and also take a Selfie of yourself (if using the mobile app) and <a href="{{ route('merchant profile') }}" style="font-weight: bold; text-decoration: underline; color: navy">upload in your profile setting</a> to complete the verification process. <a href="{{ route('contact') }}" style="font-weight: bold; text-decoration: underline; color: navy">Kindly contact the admin using the contact us form if you require further assistance. Thank You</a>
                </p>

                
                
                </div>
            </div>

            @endif

            @else
              <small>Control panel</small>
            @endif



            

          @endif
        @endif
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">


      @if(session('role') == "Super")

        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>&nbsp;</h3>

              <p>Business Report</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{ route('business report') }}" class="small-box-footer">View details <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{ count($withdraws['bank']) }}</h3>

              <p>Bank Withd. Request</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{ route('bank request withdrawal') }}" class="small-box-footer">View details <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-black">
            <div class="inner">
              <h3>{{ count($withdraws['purchase']) }}</h3>

              <p>Purchase Refund Request</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{ route('purchase refund request') }}" class="small-box-footer">View details <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>


        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-blue">
            <div class="inner">
              <h3>{{ count($withdraws['credit']) }}</h3>

              <p>Credit Card Withd. Request</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{ route('card request withdrawal') }}" class="small-box-footer">View details <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>


        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-purple">
            <div class="inner">

              @if (isset($withdraws['prepaid']))
                <h3>{{ count($withdraws['prepaid']->data) }}</h3>
                  
              @else
                  <h3>0</h3>
              @endif


              <p>Prepaid Card Withd. Request</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{ route('prepaid request withdrawal') }}" class="small-box-footer">View details <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>{{ count($pending['transfer']) }}</h3>

              <p>Text-To-Transfer</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{ route('text to transfer') }}" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{ count($pending['texttotransfer']) }}</h3>

              <p>Pending Transfer</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{ route('pending transfer') }}" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>


        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-orange">
            <div class="inner">
              <h3>{{ count($refund['requestforrefund']) }}</h3>

              <p>Refund Request</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{ route('refund money request') }}" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        {{-- <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>{{ count($allusers) }}</h3>

              <p>All Users</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{ route('all users by country') }}" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div> --}}
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>@if($approvedCountries = \App\AllCountries::where('approval', 1)->count()) {{ $approvedCountries }} @endif</h3>

              <p>Active Countries</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="{{ route('all countries') }}" class="small-box-footer">View All <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>


          <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-purple">
            <div class="inner">
              <h3>{{ count($allusers) }}</h3>

              <p>All Users</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ route('all users by country') }}" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>


          <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>@if($approvedusers = \App\User::where('accountLevel', 3)->where('approval', 2)->count()) {{ $approvedusers }} @else 0 @endif</h3>

              <p>Approved Users</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ route('approved users by country') }}" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>


          <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-orange">
            <div class="inner">
              <h3>@if($matchedUsers = \App\User::where('accountLevel', 2)->where('approval', 1)->where('bvn_verification', '>=', 1)->count()) {{ $matchedUsers }} @else 0 @endif</h3>

              <p>Matched Users</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ route('matched users by country') }}" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-blue">
            <div class="inner">
              <h3>@if($levelTwoUsers = \App\User::where('accountLevel', 2)->where('approval', 1)->where('bvn_verification', 0)->count()) {{ $levelTwoUsers }}  @else 0 @endif</h3>

              <p>Level 2 Account</p>

            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ route('level two users by country') }}" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>


          <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>@if($approvalPending = \App\User::where('accountLevel', 0)->count()) {{ $approvalPending }} @else 0 @endif</h3>

              <p>Unmatched Users</p>

            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ route('pending users by country') }}" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>


          <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-blue">
            <div class="inner">
              <h3>@if($override = \App\User::where('accountLevel', 2)->where('approval', 0)->where('archive', '!=', 1)->count()) {{ $override }}  @else 0 @endif</h3>

              <p>Override Level 1</p>

            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ route('override users by country') }}" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>


          <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>@if($closed = \App\UserClosed::count()) {{ $closed }}  @else 0 @endif</h3>

              <p>Closed Accounts</p>

            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ route('closed users by country') }}" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>




          <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-purple">
            <div class="inner">
              <h3>@if($newUsers = \App\User::where('accountType', 'Individual')->where('created_at', '>=', date('Y-m-d', strtotime('-30 days')))->count()) {{ $newUsers }}  @else 0 @endif</h3>

              <p>New Users</p>

            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ route('new users by country', 'user=new') }}" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
          <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-purple">
            <div class="inner">
              <h3>@if($existingUsers = \App\User::where('accountType', 'Individual')->where('created_at', '<', date('Y-m-d', strtotime('-30 days')))->count()) {{ $existingUsers }}  @else 0 @endif</h3>

              <p>Existing Users</p>

            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ route('new users by country', 'user=existing') }}" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
          <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-blue">
            <div class="inner">
              <h3>@if($newMerchant = \App\User::where('accountType', 'Merchant')->where('created_at', '>=', date('Y-m-d', strtotime('-30 days')))->count()) {{ $newMerchant }}  @else 0 @endif</h3>

              <p>New Merchants</p>

            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ route('new merchants by country', 'user=new') }}" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
          <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-blue">
            <div class="inner">
              <h3>@if($existingMerchant = \App\User::where('accountType', 'Merchant')->where('created_at', '<', date('Y-m-d', strtotime('-30 days')))->count()) {{ $existingMerchant }}  @else 0 @endif</h3>

              <p>Existing Merchants</p>

            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ route('new merchants by country', 'user=existing') }}" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>@if($archivedUsers = \App\User::where('accountType', 'Individual')->where('archive', 1)->count()) {{ $archivedUsers }}  @else 0 @endif</h3>

              <p>Archived Consumers</p>

            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ route('archived users by country', 'user=consumers') }}" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>


          <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-black">
            <div class="inner">
              <h3>@if($archivedMerchant = \App\User::where('accountType', 'Merchant')->where('archive', 1)->count()) {{ $archivedMerchant }}  @else 0 @endif</h3>

              <p>Archived Merchants</p>

            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ route('archived users by country', 'user=merchants') }}" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        
        <!-- ./col -->

        @elseif (session('role') == "Access to Level 1 and 2 only")

        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-purple">
            <div class="inner">
              <h3>{{ count($allusers) }}</h3>

              <p>All Users</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ route('all users by country') }}" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>



          <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-orange">
            <div class="inner">
              <h3>@if($matchedUsers = \App\User::where('accountLevel', 2)->where('approval', '>', 1)->where('bvn_verification', 1)->count()) {{ $matchedUsers }} @else 0 @endif</h3>

              <p>Matched Users</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ route('matched users by country') }}" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-blue">
            <div class="inner">
              <h3>@if($levelTwoUsers = \App\User::where('accountLevel', 2)->where('approval', 1)->where('bvn_verification', 0)->count()) {{ $levelTwoUsers }}  @else 0 @endif</h3>

              <p>Level 2 Account</p>

            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ route('level two users by country') }}" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>


        


          <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>@if($approvalPending = \App\User::where('accountLevel', 0)->count()) {{ $approvalPending }} @else 0 @endif</h3>

              <p>Unmatched Users</p>

            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ route('pending users by country') }}" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>


          <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-blue">
            <div class="inner">
              <h3>@if($override = \App\User::where('accountLevel', 2)->where('approval', 0)->where('archive', '!=', 1)->count()) {{ $override }}  @else 0 @endif</h3>

              <p>Override Level 1</p>

            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ route('override users by country') }}" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>





        @elseif (session('role') == "Access to Level 1 only")


        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{ count($withdraws['bank']) }}</h3>

              <p>Bank Withd. Request</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{ route('bank request withdrawal') }}" class="small-box-footer">View details <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-black">
            <div class="inner">
              <h3>{{ count($withdraws['purchase']) }}</h3>

              <p>Purchase Refund Request</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{ route('purchase refund request') }}" class="small-box-footer">View details <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>@if($approvalPending = \App\User::where('accountLevel', 0)->count()) {{ $approvalPending }} @else 0 @endif</h3>

              <p>Unmatched Users</p>

            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ route('pending users by country') }}" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>



          <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-blue">
            <div class="inner">
              <h3>@if($override = \App\User::where('accountLevel', 2)->where('approval', 0)->where('archive', '!=', 1)->count()) {{ $override }}  @else 0 @endif</h3>

              <p>Override Level 1</p>

            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ route('override users by country') }}" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        
        @elseif (session('role') == "Customer Marketing")

          <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-purple">
            <div class="inner">
              <h3>@if($newUsers = \App\User::where('accountType', 'Individual')->where('created_at', '>=', date('Y-m-d', strtotime('-30 days')))->count()) {{ $newUsers }}  @else 0 @endif</h3>

              <p>New Users</p>

            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ route('new users by country', 'user=new') }}" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
          <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-purple">
            <div class="inner">
              <h3>@if($existingUsers = \App\User::where('accountType', 'Individual')->where('created_at', '<', date('Y-m-d', strtotime('-30 days')))->count()) {{ $existingUsers }}  @else 0 @endif</h3>

              <p>Existing Users</p>

            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ route('new users by country', 'user=existing') }}" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
          <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-blue">
            <div class="inner">
              <h3>@if($newMerchant = \App\User::where('accountType', 'Merchant')->where('created_at', '>=', date('Y-m-d', strtotime('-30 days')))->count()) {{ $newMerchant }}  @else 0 @endif</h3>

              <p>New Merchants</p>

            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ route('new merchants by country', 'user=new') }}" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>


          <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-blue">
            <div class="inner">
              <h3>@if($existingMerchant = \App\User::where('accountType', 'Merchant')->where('created_at', '<', date('Y-m-d', strtotime('-30 days')))->count()) {{ $existingMerchant }}  @else 0 @endif</h3>

              <p>Existing Merchants</p>

            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ route('new merchants by country', 'user=existing') }}" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>


        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>@if($archivedUsers = \App\User::where('accountType', 'Individual')->where('archive', 1)->count()) {{ $archivedUsers }}  @else 0 @endif</h3>

              <p>Archived Consumers</p>

            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ route('archived users by country', 'user=consumers') }}" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>


          <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-black">
            <div class="inner">
              <h3>@if($archivedMerchant = \App\User::where('accountType', 'Merchant')->where('archive', 1)->count()) {{ $archivedMerchant }}  @else 0 @endif</h3>

              <p>Archived Merchants</p>

            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ route('archived users by country', 'user=merchants') }}" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>


          

      @else



      <div class="col-lg-6 col-xs-6 walletBal">
          <!-- small box -->
          <div class="small-box bg-warning">
            <div class="inner">
              <h3>{{ $getUserDetail->currencySymbol.number_format($getUserDetail->wallet_balance, 2) }}</h3>

              <p>Wallet Balance</p>
            </div>
            <div class="icon">
              <i class="ion ion-pricetag"></i>
            </div>
            {{-- <a href="#" class="small-box-footer">View details <i class="fa fa-arrow-circle-right"></i></a> --}}
          </div>
        </div>
        <!-- ./col -->
        
        <!-- ./col -->
        <div class="col-lg-6 col-xs-6 walletWithdrawal">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">
            <h3>{{ $getUserDetail->number_of_withdrawals }}</h3>

              <p>Number of Withdrawal Requests</p>
            </div>
            <div class="icon">
              <i class="ion ion-archive"></i>
            </div>
        {{--  <a href="{{ route('Otherpay') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>  --}}
          </div>
        </div>

        <div class="col-lg-6 col-xs-6 myCardInfo">
          <!-- small box -->
          <div class="small-box bg-success">
            <div class="inner">
              @if (isset($getCard) && count($getCard) > 0)
                  @php
                      $others = count($getCard) - 1;
                      $cardNo = wordwrap($getCard[0]->card_number, 4, '-', true);
                  @endphp

                @switch($getCard[0]->card_type)
                    @case("Mastercard")
                        @php
                            $cardImage = '<img src="https://img.icons8.com/color/30/000000/mastercard.png"/>';
                        @endphp
                        @break
                    @case("Visa")
                        @php
                            $cardImage = '<img src="https://img.icons8.com/color/30/000000/visa.png"/>';
                        @endphp
                        @break
                    @default
                        @php
                            $cardImage = '<img src="https://img.icons8.com/fluent/30/000000/bank-card-back-side.png"/>';
                        @endphp
                    @endswitch

                        <div class="row">
                            <div class="col-md-12">
                                <h3 style="font-size: 30px;">
                                    {{ (strlen($cardNo) < 10) ? $cardNo : substr($cardNo, 0, 10)."***" }} {{ ($others > 0) ? "& ".$others." others" : "" }}

                                    
                                </h3>
                            </div>
                            <br>
                            <div class="col-md-6">
                                <h4>
                                    Expiry: {{ $getCard[0]->month."/".$getCard[0]->year }}
                                </h4>
                            </div>
                            <div class="col-md-6">
                                <h4>
                                    CVV: ***
                                </h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h4>
                                    {{ (strlen($getCard[0]->card_name) < 18) ? strtoupper($getCard[0]->card_name) : substr(strtoupper($getCard[0]->card_name), 0, 18)."..." }}
                                </h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                {!! $cardImage !!}
                            </div>
                        </div>

              @else
                  <h3>&nbsp;</h3>

                <p>
                  <a href="{{ route('merchant payment gateway', 'gateway=PaySprint') }}">Add a new card</a>
                </p>
              @endif


              
            </div>
            <div class="icon">
              <i class="ion ion-card"></i>
            </div>
            {{-- <a href="#" class="small-box-footer">View details <i class="fa fa-arrow-circle-right"></i></a> --}}
          </div>


            <div class="col-md-12 paymentMethods">
          <h3><strong>Payment Method</strong></h3>
              <hr>
            </div>
            <div class="col-md-12">

              <p><strong>Click icon below to add card</strong></p>

                <button style="background-color: #000 !important;" class="px-2" title="PaySprint Payment Gateway" onclick="location.href='{{ route('merchant payment gateway', 'gateway=PaySprint') }}'">
                    <img src="https://res.cloudinary.com/pilstech/image/upload/v1618251695/paysprint_icon_new_kg2h3j.png" alt="PaySprint logo" width="50" height="50">
                </button>
                <button class="px-2" title="GooglePay Payment Gateway" onclick="comingSoon()"><img src="https://img.icons8.com/fluent/50/000000/google-logo.png"/></button>
                <br>
            <br>
            </div>

            <div class="col-md-4 mb-3 addMoney">

              <a style="font-size: 14px; font-weight: bold;" type="button" href="{{ route('merchant add money') }}" class="btn btn-info btn-block">Add Money <i class="fas fa-plus"></i></a>
            </div>

            <div class="col-md-4 mb-3 sendMoney">
              <a style="font-size: 14px; font-weight: bold;" type="button" href="{{ route('merchant send money', 'type='.base64_encode("local")) }}" class="btn btn-warning btn-block">Send Money <i class="fas fa-paper-plane"></i></a>
            </div>

            <div class="col-md-4 mb-3 withdrawMoney">
              @if ($getUserDetail->approval == 2 && $getUserDetail->accountLevel == 3)

                @if (isset($withdraws['specialInfo']))
                    <a style="font-size: 14px; font-weight: bold;" type="button" href="javascript:void(0)" class="btn btn-success btn-block" onclick="restriction('specialinfo', '{{ $getUserDetail->name }}')">Withdraw Money <i class="fa fa-credit-card"></i></a>
                @else
                    <a style="font-size: 14px; font-weight: bold;" type="button" href="{{ route('merchant withdrawal') }}" class="btn btn-success btn-block">Withdraw Money <i class="fas fa-credit-card"></i></a>
                @endif

                  
              @else
                      <a style="font-size: 14px; font-weight: bold;" type="button" href="javascript:void(0)" class="btn btn-success btn-block" onclick="restriction('withdrawal', '{{ $getUserDetail->name }}')">Withdraw Money <i class="fa fa-credit-card"></i></a>
                  
              @endif
              <br>
            </div>


            
            
            <div class="col-md-4 mt-5 mb-3 payinvoiceMoney">
              <a style="font-size: 14px; font-weight: bold;" type="button" href="{{ route('invoice') }}" class="btn btn-danger btn-block mt-5 mb-3">Pay Invoice <i class="fas fa-credit-card"></i></a>
            </div>

            @if ($getUserDetail->country == "Nigeria")
                <div class="col-md-4 mt-5 mb-3 payutilityMoney">
                  <a style="font-size: 14px; font-weight: bold; background: black; color: white;" type="button" href="{{ route('utility bills') }}" class="btn btn-info btn-block mt-5 mb-3">Pay Utility Bill <i class="fas fa-credit-card"></i></a>
                </div>

                @else

                <div class="col-md-4 mt-5 mb-3 payutilityMoney">
                  <a style="font-size: 14px; font-weight: bold; background: black; color: white;" type="button" href="javascript:void(0)" class="btn btn-info btn-block mt-5 mb-3" onclick="comingSoon()">Pay Utility Bill <i class="fas fa-credit-card"></i></a>
                </div>

            @endif




        </div>



        <div class="col-lg-6 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-danger paidInvoices">
            <div class="inner">

              @php
                $infoPend = 0;
              @endphp

              @if(count($invoiceImport) > 0)
                @foreach ($invoiceImport as $items)
                    @if($left = \App\InvoicePayment::where('invoice_no', $items->invoice_no)->get())
                        
                  @if(count($left) > 0)
                    @php
                        $pendPaid = count($left);

                        $infoPend += $pendPaid;
                    @endphp
                  
                  
                  @endif

                @endif
                @endforeach
              @endif

              

              <h3>{{ $infoPend }}</h3>

              <p>Paid Invoices</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            {{-- <a href="#" class="small-box-footer">View details <i class="fa fa-arrow-circle-right"></i></a> --}}
          </div>

          
          
          

          


        </div>


        
        <!-- ./col -->
      @endif

      </div>
      <br>
      <br>

      @if(session('role') != "Super" && session('role') != "Access to Level 1 and 2 only" && session('role') != "Access to Level 1 only" && session('role') != "Customer Marketing")
      <!-- /.row -->
      <!-- Main row -->
      <div class="row">
        @if (isset($withdraws['specialInfo']))

          <section class="col-lg-12 specialText disp-0">
            <div class="alert alert-danger specialText disp-0" role="alert">
                
                {!! $withdraws['specialInfo']->information !!}
            </div>
          </section>

        @endif


                <!-- Left col -->
        <section class="col-lg-12 connectedSortable">


          <!-- TO DO List -->
          <div class="box box-primary receivedMoney">
            <div class="box-header">
              <i class="ion ion-clipboard"></i>

              <h3 class="box-title">Received Invoice</h3>

            </div>
            <!-- /.box-header -->
            <div class="box-body table table-responsive">
               <table id="example3" class="table table-bordered table-hover">
                   {{-- @if(session('role') != "Super")<caption><button type="button" class="btn btn-success" style="float:right" id="recurAll" onclick="recurring('All', {{ session('user_id') }})">Recur All</button></caption>@endif --}}
                <thead>
                <tr>
                  <th>#</th>
                  <th>Description</th>
                  <th>Invoice #</th>
                  <th>Status</th>
                  <th>Amount</th>
                  <th>Created Date</th>
                </tr>
                </thead>
                <tbody>
                @if (isset($received['payInvoice']))
                <?php $i = 1;?>
                @foreach (json_decode($received['payInvoice']) as $payInv)

                    <tr>


                      <td>{{ $i++ }}</td>
                      <td>
                        {!! 'Invoice for '.$payInv->service.' to '.$payInv->merchantName !!}
                      </td>

                      <td>{{ $payInv->invoice_no }}</td>
                      
                      @if ($payInv->payment_status == 0)
                          <td>
                            <a href="{{ route('payment', $payInv->invoice_no) }}" type="button" class='btn btn-danger'>Pay Invoice</a>
                          </td>
                        @elseif($payInv->payment_status == 2)
                        <td>
                          <a href="{{ route('payment', $payInv->invoice_no) }}" type="button" class='btn btn-danger' style='cursor: pointer;'>Pay Balance</a>
                        </td>
                        @else
                          <td style="font-weight: bold; color: green;">Paid</td>
                      @endif

                      <td style="font-weight: 700">
                          @php
                            if($payInv->total_amount != null || $payInv->total_amount != 0){
                                $totalAmount = $payInv->total_amount;
                            }else{
                                $totalAmount = $payInv->amount;
                            }
                        @endphp

                        @if ($payInv->payment_status == 0)
                            {{ "+".$getUserDetail->currencySymbol.number_format($totalAmount, 2) }}
                        @elseif($payInv->payment_status == 2)
                            {{ "-".$getUserDetail->currencySymbol.number_format($payInv->remaining_balance, 2) }}
                        @else
                            {{ "-".$getUserDetail->currencySymbol.number_format($totalAmount, 2) }}
                        @endif
                      
                      </td>
                    
                    <td>{{ date('d/m/Y h:i a', strtotime($payInv->created_at)) }}</td>

                   
                </tr>
                @endforeach
                
                @else
                  <tr>
                  <td colspan="6" align="center"> No uploaded Invoice yet</td>
                </tr>
                @endif


                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->


        </section>
        <!-- /.Left col -->


        <!-- Left col -->
        <section class="col-lg-12 connectedSortable">


          <!-- TO DO List -->
          <div class="box box-primary importList">
            <div class="box-header">
              <i class="ion ion-clipboard"></i>

              <h3 class="box-title">Import Invoice List</h3>

            </div>
            <!-- /.box-header -->
            <div class="box-body table table-responsive">
               <table id="example4" class="table table-bordered table-hover">
                   {{-- @if(session('role') != "Super")<caption><button type="button" class="btn btn-success" style="float:right" id="recurAll" onclick="recurring('All', {{ session('user_id') }})">Recur All</button></caption>@endif --}}
                <thead>
                <tr>
                  <th>#</th>
                  <th>Created Date</th>
                  <th>Trans. Date</th>
                  <th>Invoice #</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Service</th>
                  <th>Amount</th>
                  <th>Tax Amount</th>
                  <th>Total Amount</th>
                  <th>Status</th>
                  <th>Pay Due Date</th>
                  @if(session('role') != "Super" && session('role') != "Access to Level 1 and 2 only" && session('role') != "Access to Level 1 only")<th>Action</th>@endif
                </tr>
                </thead>
                <tbody>
                @if(count($invoiceImport) > 0)
                <?php $i = 1;?>
                @foreach ($invoiceImport as $invoiceImports)

                    <tr>


                      <td>{{ $i++ }}</td>
                      <td>{{ date('d/M/Y', strtotime($invoiceImports->created_at)) }}</td>
                      <td>{{ date('d/M/Y', strtotime($invoiceImports->transaction_date)) }}</td>
                      <td>{{ $invoiceImports->invoice_no }}</td>
                      <td>{{ $invoiceImports->name }}</td>
                    <td title="{{ $invoiceImports->payee_email }}"><?php $string = $invoiceImports->payee_email; $output = strlen($string) > 10 ? substr($string,0,10)."..." : $string; echo $output;?></td>
                    <td title="{{ $invoiceImports->service }}"><?php $string = $invoiceImports->service; $output = strlen($string) > 10 ? substr($string,0,10)."..." : $string; echo $output;?></td>
                      <td align="center" style="font-weight: bold; color: navy;">@if (isset($getUserDetail) == true) {{ $getUserDetail->currencySymbol.number_format($invoiceImports->amount, 2) }} @else {{ number_format($invoiceImports->amount, 2) }} @endif </td>

                      <td align="center" style="font-weight: bold; color: purple;">@if (isset($getUserDetail) == true) {{ $getUserDetail->currencySymbol.number_format($invoiceImports->tax_amount, 2) }} @else {{ number_format($invoiceImports->tax_amount, 2) }} @endif </td>

                      <td align="center" style="font-weight: bold; color: green;">@if (isset($getUserDetail) == true) {{ $getUserDetail->currencySymbol.number_format($invoiceImports->total_amount, 2) }} @else {{ number_format($invoiceImports->total_amount, 2) }} @endif </td>

                      @if ($invoiceImports->payment_status == 1)
                          <td align="center" style="font-weight: bold; color: green;">Paid</td>

                      @elseif ($invoiceImports->payment_status == 2)

                          <td align="center" style="font-weight: bold; color: purple;">Part Pay</td>

                      @else

                        <td align="center" style="font-weight: bold; color: red;">Unpaid</td>

                      @endif


                      {{-- @if($leftOver = \App\InvoicePayment::where('invoice_no', $invoiceImports->invoice_no)->get())
                        
                        @if(count($leftOver) > 0)
                        <td align="center" style="font-weight: bold; color: green;">Paid</td>

                        @else
                        <td align="center" style="font-weight: bold; color: red;">Pending</td>

                        @endif

                      @endif --}}
                      <td>{{ date('d/M/Y', strtotime($invoiceImports->payment_due_date)) }}</td>

                   @if(session('role') != "Super" && session('role') != "Access to Level 1 and 2 only" && session('role') != "Access to Level 1 only") <td><button type="button" class="btn btn-primary" id="viewdetails{{ $invoiceImports->id }}" onclick="location.href='Admin/customer/{{ $invoiceImports->id }}'">View Details</button></td>@endif
                </tr>
                @endforeach
                @else
                  <tr>
                  <td colspan="10" align="center"> No uploaded Invoice yet</td>
                </tr>
                @endif


                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->


        </section>
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-12 connectedSortable">

          <!-- TO DO List -->
          <div class="box box-primary receivePaid">
            <div class="box-header">
              <i class="ion ion-clipboard"></i>

              <h3 class="box-title">Recently Paid Invoices</h3>
            </div>

            @if(session('role') == "Super")

            <!-- /.box-header -->
            <div class="box-body table table-responsive">
               <table id="example1" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Transaction ID</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Amount</th>
                  <th>Invoice #</th>
                  <th>Service</th>
                  <th>Client</th>
                  <th>Pay Date</th>
                </tr>
                </thead>
                <tbody>

                    @if(count($payInvoice) > 0)
                    <?php $i = 1;?>
                    @foreach ($payInvoice as $payInvoices)
                        <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $payInvoices->transactionid }}</td>
                        <td>{{ $payInvoices->name }}</td>
                        <td>{{ $payInvoices->email }}</td>
                        <td style="font-weight: bold; color: green;">${{ number_format($payInvoices->amount) }}</td>
                        <td>{{ $payInvoices->invoice_no }}</td>
                        <td>{{ $payInvoices->service }}</td>
                        <td>{{ $payInvoices->business_name }}</td>
                        <td>{{ date('d/M/Y', strtotime($payInvoices->created_at)) }}</td>
                        </tr>
                    @endforeach

                    @else
                        <tr>
                            <td colspan="8" align="center">No payment made to client yet</td>
                        </tr>

                    @endif


                </tbody>
              </table>
            </div>
            <!-- /.box-body -->

            @else

            <!-- /.box-header -->
            <div class="box-body table table-responsive">
               <table id="example1" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Trans. ID</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Amount</th>
                  <th>Invoice #</th>
                  <th>Service</th>
                  <th>Pay Date</th>
                </tr>
                </thead>
                <tbody>

                    @if(count($payInvoice) > 0)
                    <?php $i = 1;?>
                    @foreach ($payInvoice as $payInvoices)
                        <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $payInvoices->transactionid }}</td>
                        <td>{{ $payInvoices->name }}</td>
                        <td>{{ $payInvoices->email }}</td>
                        <td style="font-weight: bold; color: green;">${{ number_format($payInvoices->amount) }}</td>
                        <td>{{ $payInvoices->invoice_no }}</td>
                        <td>{{ $payInvoices->service }}</td>
                        <td>{{ date('d/M/Y', strtotime($payInvoices->created_at)) }}</td>
                        </tr>
                    @endforeach

                    @else
                        <tr>
                            <td colspan="8" align="center">No Payment made yet</td>
                        </tr>

                    @endif


                </tbody>
              </table>
            </div>
            <!-- /.box-body -->

            @endif

          </div>
          <!-- /.box -->

        </section>
        <!-- right col -->
      </div>
      <!-- /.row (main row) -->

      @endif

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection
