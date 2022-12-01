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
    <div class="small-box bg-blue">
        <div class="inner">
            <h3>{{ count($data['moextranx']) }}</h3>

            <p>PS - MOEX Transaction</p>
        </div>
        <div class="icon">
            <i class="ion ion-stats-bars"></i>
        </div>
        <a href="{{ route('get moex transaction') }}" class="small-box-footer">View details <i class="fa fa-arrow-circle-right"></i></a>
    </div>
</div>


<div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-red">
        <div class="inner">
            <h3>&nbsp;</h3>

            <p>MOEX - PS Transaction</p>
        </div>
        <div class="icon">
            <i class="ion ion-stats-bars"></i>
        </div>
        <a href="{{ route('get moex ps transaction') }}" class="small-box-footer">View details <i class="fa fa-arrow-circle-right"></i></a>
    </div>
</div>


<div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-purple">
        <div class="inner">
            <h3>{{ count($withdraws['bank']) }}</h3>

            <p>Payout Withd. Request</p>
        </div>
        <div class="icon">
            <i class="ion ion-stats-bars"></i>
        </div>
        <a href="#" class="small-box-footer">View details <i class="fa fa-arrow-circle-right"></i></a>
    </div>
</div>


<div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-red">
        <div class="inner">
            <h3>{{ count($withdraws['bank']) }}</h3>

            <p>eTransfer Withd. Request</p>
        </div>
        <div class="icon">
            <i class="ion ion-stats-bars"></i>
        </div>
        <a href="#" class="small-box-footer">View details <i class="fa fa-arrow-circle-right"></i></a>
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


<div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-navy">
        <div class="inner">
            <h3>{{ count($data['escrowfund']) }}</h3>

            <p>FX Funding Account</p>
        </div>
        <div class="icon">
            <i class="ion ion-stats-bars"></i>
        </div>
        <a href="{{ route('escrow funding list') }}" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
    </div>
</div>
<div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-navy">
        <div class="inner">
            <h3>{{ count($data['transfer']) }}</h3>

            <p>Bank/Wire/E-Transfer</p>
        </div>
        <div class="icon">
            <i class="ion ion-stats-bars"></i>
        </div>
        <a href="{{ route('electronic transfer') }}" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
    </div>
</div>

<div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-navy">
        <div class="inner">
            <h3>{{ count($data['pointsclaim']) }}</h3>

            <p>Points Claimed</p>
        </div>
        <div class="icon">
            <i class="ion ion-stats-bars"></i>
        </div>
        <a href="{{ route('claim reward') }}" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
    </div>
</div>


<div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-green">
        <div class="inner">
            <h3>{{ $data['cashadvance'] }}</h3>

            <p>Cash Advance</p>
        </div>
        <div class="icon">
            <i class="ion ion-stats-bars"></i>
        </div>
        <a href="{{ route('cash advance list') }}" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
    </div>
</div>


<div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-blue">
        <div class="inner">
            <h3>{{ $data['crossborder'] }}</h3>

            <p>Cross Border Payment</p>
        </div>
        <div class="icon">
            <i class="ion ion-stats-bars"></i>
        </div>
        <a href="{{ route('cross border list') }}" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
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
            <h3>
                @if ($approvedCountries = \App\AllCountries::where('approval', 1)->count())
                {{ $approvedCountries }}
                @endif
            </h3>

            <p>Active Countries</p>
        </div>
        <div class="icon">
            <i class="ion ion-pie-graph"></i>
        </div>
        <a href="{{ route('all countries') }}" class="small-box-footer">View All <i class="fa fa-arrow-circle-right"></i></a>
    </div>
</div>


{{-- Paid Plans --}}
<div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-blue">
        <div class="inner">
            <h3>
                {{ $data['paiduserscount'] }}
            </h3>

            <p>Paid Users</p>
        </div>
        <div class="icon">
            <i class="ion ion-pie-graph"></i>
        </div>
        <a href="{{ route('all paid user list') }}" class="small-box-footer">View All <i class="fa fa-arrow-circle-right"></i></a>
    </div>
</div>


{{-- End Paid Plans --}}


{{-- Paid Plans --}}
<div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-blue">
        <div class="inner">
            <h3>
                {{ $data['freeuserscount'] }}
            </h3>

            <p>Free Users</p>
        </div>
        <div class="icon">
            <i class="ion ion-pie-graph"></i>
        </div>
        <a href="{{ route('all free user list') }}" class="small-box-footer">View All <i class="fa fa-arrow-circle-right"></i></a>
    </div>
</div>


{{-- End Paid Plans --}}


<div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-purple">
        <div class="inner">
            <h3>
                @if ($upgradeConsumerplans = \App\User::where('plan', 'classic')->where('accountType', 'Individual')->count())
                {{ $upgradeConsumerplans }} @else 0
                @endif
            </h3>

            <p>Upgraded Plans (Consumer)</p>
        </div>
        <div class="icon">
            <i class="ion ion-person-add"></i>
        </div>
        <a href="{{ route('upgraded consumers by country') }}" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
    </div>
</div>


<div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-blue">
        <div class="inner">
            <h3>
                @if ($upgradeMerchantplans = \App\User::where('plan', 'classic')->where('accountType', 'Merchant')->count())
                {{ $upgradeMerchantplans }} @else 0
                @endif
            </h3>

            <p>Upgraded Plans (Merchant)</p>
        </div>
        <div class="icon">
            <i class="ion ion-person-add"></i>
        </div>
        <a href="{{ route('upgraded merchant by country') }}" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
    </div>
</div>


<div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-red">
        <div class="inner">
            <h3>
                @if ($testPlan = \App\ClientInfo::where('accountMode', 'test')->count())
                {{ $testPlan }} @else 0
                @endif
            </h3>

            <p>Test Mode (Merchant)</p>
        </div>
        <div class="icon">
            <i class="ion ion-person-add"></i>
        </div>
        <a href="{{ route('merchant account mode by country', 'mode=test') }}" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
    </div>
</div>


<div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-blue">
        <div class="inner">
            <h3>
                @if ($livePlan = \App\ClientInfo::where('accountMode', 'live')->count())
                {{ $livePlan }} @else 0
                @endif
            </h3>

            <p>Live Mode (Merchant)</p>
        </div>
        <div class="icon">
            <i class="ion ion-person-add"></i>
        </div>
        <a href="{{ route('merchant account mode by country', 'mode=live') }}" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
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
            <h3>
                @if ($approvedusers = \App\User::where('account_check', 2)->count())
                {{ $approvedusers }} @else 0
                @endif
            </h3>

            <p>IDV Fully Completed</p>
        </div>
        <div class="icon">
            <i class="ion ion-person-add"></i>
        </div>
        <a href="{{ route('approved users by country') }}" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
    </div>
</div>


<div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-purple">
        <div class="inner">
            {{-- <h3>@if ($approvedpendingusers = \App\User::where('accountLevel', '<=', 3)->where('approval', '<=', 2)->where('account_check', '<=', 1)->count()) {{ $approvedpendingusers }} @else 0 @endif</h3> --}}
            <h3>
                @if ($approvedpendingusers = \App\User::where('account_check', 1)->count())
                {{ $approvedpendingusers }} @else 0
                @endif
            </h3>

            <p>IDV Completed - Pending</p>
        </div>
        <div class="icon">
            <i class="ion ion-person-add"></i>
        </div>
        <a href="{{ route('approved pending users by country') }}" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
    </div>
</div>


<div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-orange">
        <div class="inner">
            <h3>
                @if ($matchedUsers = \App\User::where([['accountLevel', '>=', 2], ['approval', '>=', 1], ['account_check', '=', 0]])->count())
                {{ $matchedUsers }} @else 0
                @endif
            </h3>

            <p>IDV Passed - (Set restriction)</p>
        </div>
        <div class="icon">
            <i class="ion ion-person-add"></i>
        </div>
        <a href="{{ route('matched users by country') }}" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
    </div>
</div>

<div class="col-lg-3 col-xs-6 disp-0">
    <!-- small box -->
    <div class="small-box bg-blue">
        <div class="inner">
            <h3>
                @if ($levelTwoUsers = \App\User::where('accountLevel', 2)->where('approval', 1)->where('bvn_verification', 0)->count())
                {{ $levelTwoUsers }} @else 0
                @endif
            </h3>

            <p>Doc. Pending</p>

        </div>
        <div class="icon">
            <i class="ion ion-person-add"></i>
        </div>
        <a href="{{ route('level two users by country') }}" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
    </div>
</div>


<div class="col-lg-3 col-xs-6 disp-0">
    <!-- small box -->
    <div class="small-box bg-red">
        <div class="inner">
            <h3>
                @if ($approvalPending = \App\User::where([['accountLevel', '=', 2], ['approval', '=', 0], ['bvn_verification', '=', 0], ['account_check', '=', 0]])->count())
                {{ $approvalPending }} @else 0
                @endif
            </h3>

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
            <h3>
                @if ($override = \App\User::where([['accountLevel', '=', 2], ['approval', '=', 0], ['bvn_verification', '=', 0], ['account_check', '=', 0]])->count())
                {{ $override }} @else 0
                @endif
            </h3>

            <p>IDV Failed</p>

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
            <h3>
                @if ($psnotactive = \App\User::where([['accountLevel', '=', 0], ['countryapproval', '=', 0]])->count())
                {{ $psnotactive }} @else 0
                @endif
            </h3>

            <p>PS Not Active</p>

        </div>
        <div class="icon">
            <i class="ion ion-person-add"></i>
        </div>
        <a href="{{ route('ps not active by country') }}" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
    </div>
</div>


<div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-red">
        <div class="inner">
            <h3>
                @if ($suspended = \App\User::where('flagged', 1)->count())
                {{ $suspended }} @else 0
                @endif
            </h3>

            <p>Suspended Accounts</p>

        </div>
        <div class="icon">
            <i class="ion ion-person-add"></i>
        </div>
        <a href="{{ route('suspended users by country') }}" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
    </div>
</div>


<div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-red">
        <div class="inner">
            <h3>
                @if ($closed = \App\UserClosed::count())
                {{ $closed }} @else 0
                @endif
            </h3>

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
            <h3>
                @if ($newUsers = \App\User::where('accountType', 'Individual')->where('archive', 0)->where('countryapproval', 1)->where('created_at', '>=', date('Y-m-d', strtotime('-30 days')))->count())
                {{ $newUsers }} @else 0
                @endif
            </h3>

            <p>New Consumers</p>

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
            <h3>
                @if ($existingUsers = \App\User::where('accountType', 'Individual')->where('archive', 0)->where('countryapproval', 1)->where('created_at', '<', date('Y-m-d', strtotime('-30 days')))->count())
                    {{ $existingUsers }} @else 0
                    @endif
            </h3>

            <p>Existing Consumers</p>

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
            <h3>
                @if ($newMerchant = \App\User::where('accountType', 'Merchant')->where('archive', 0)->where('countryapproval', 1)->where('created_at', '>=', date('Y-m-d', strtotime('-30 days')))->count())
                {{ $newMerchant }} @else 0
                @endif
            </h3>

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
            <h3>
                @if ($existingMerchant = \App\User::where('accountType', 'Merchant')->where('archive', 0)->where('countryapproval', 1)->where('created_at', '<', date('Y-m-d', strtotime('-30 days')))->count())
                    {{ $existingMerchant }} @else 0
                    @endif
            </h3>

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
            <h3>
                @if ($archivedUsers = \App\User::where('accountType', 'Individual')->where('countryapproval', 1)->where('archive', 1)->count())
                {{ $archivedUsers }} @else 0
                @endif
            </h3>

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
            <h3>
                @if ($archivedMerchant = \App\User::where('accountType', 'Merchant')->where('countryapproval', 1)->where('archive', 1)->count())
                {{ $archivedMerchant }} @else 0
                @endif
            </h3>

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
        <a href="{{ route('merchant bank details by country', 'users=Merchant') }}" class="small-box-footer">View
            details <i class="fa fa-arrow-circle-right"></i></a>
        {{-- <a href="{{ route('merchant banking details', 'users=Merchant') }}" class="small-box-footer">View details <i class="fa fa-arrow-circle-right"></i></a> --}}
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
        <a href="{{ route('merchant bank details by country', 'users=Individual') }}" class="small-box-footer">View
            details <i class="fa fa-arrow-circle-right"></i></a>
        {{-- <a href="{{ route('merchant banking details', 'users=Individual') }}" class="small-box-footer">View details <i class="fa fa-arrow-circle-right"></i></a> --}}
    </div>
</div>


<div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-red">
        <div class="inner">
            <h3>&nbsp;</h3>

            <p>KYB Pending</p>

        </div>
        <div class="icon">
            <i class="ion ion-person-add"></i>
        </div>
        <a href="{{ route('kyb pending by country') }}" class="small-box-footer">View details <i class="fa fa-arrow-circle-right"></i></a>
        {{-- <a href="{{ route('merchant banking details', 'users=Individual') }}" class="small-box-footer">View details <i class="fa fa-arrow-circle-right"></i></a> --}}
    </div>
</div>


<div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-green">
        <div class="inner">
            <h3>&nbsp;</h3>

            <p>KYB Completed</p>

        </div>
        <div class="icon">
            <i class="ion ion-person-add"></i>
        </div>
        <a href="{{ route('kyb completed by country') }}" class="small-box-footer">View details <i class="fa fa-arrow-circle-right"></i></a>
        {{-- <a href="{{ route('merchant banking details', 'users=Individual') }}" class="small-box-footer">View details <i class="fa fa-arrow-circle-right"></i></a> --}}
    </div>
</div>


<div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-purple">
        <div class="inner">
            <h3>&nbsp;</h3>

            <p>Industry</p>

        </div>
        <div class="icon">
            <i class="ion ion-person-add"></i>
        </div>
        <a href="{{ route('industry category by country') }}" class="small-box-footer">View details <i class="fa fa-arrow-circle-right"></i></a>
        {{-- <a href="{{ route('merchant banking details', 'users=Individual') }}" class="small-box-footer">View details <i class="fa fa-arrow-circle-right"></i></a> --}}
    </div>
</div>


<div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-purple">
        <div class="inner">
            <h3>&nbsp;</h3>

            <p>All Merchants</p>

        </div>
        <div class="icon">
            <i class="ion ion-person-add"></i>
        </div>
        <a href="{{ route('allpsmerchants') }}" class="small-box-footer">View details <i class="fa fa-arrow-circle-right"></i></a>
        {{-- <a href="{{ route('merchant banking details', 'users=Individual') }}" class="small-box-footer">View details <i class="fa fa-arrow-circle-right"></i></a> --}}
    </div>
</div>


<!-- ./col -->
