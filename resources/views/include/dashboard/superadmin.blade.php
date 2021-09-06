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


          <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-purple">
            <div class="inner">
              <h3>&nbsp;</h3>

              <p>Merchant Bank Details</p>

            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ route('merchant banking details', 'users=Merchant') }}" class="small-box-footer">View details <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
          <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-blue">
            <div class="inner">
              <h3>&nbsp;</h3>

              <p>Consumers Bank Details</p>

            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ route('merchant banking details', 'users=Individual') }}" class="small-box-footer">View details <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        
        <!-- ./col -->