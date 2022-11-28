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
        <a href="{{ route('all users by country') }}" class="small-box-footer">View all <i
                class="fa fa-arrow-circle-right"></i></a>
    </div>
</div>


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
        <a href="{{ route('bank request withdrawal') }}" class="small-box-footer">View details <i
                class="fa fa-arrow-circle-right"></i></a>
    </div>
</div>

<div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-blue">
        <div class="inner">
            <h3>{{ count($data['moextranx']) }}</h3>

            <p>MOEX Transaction</p>
        </div>
        <div class="icon">
            <i class="ion ion-stats-bars"></i>
        </div>
        <a href="{{ route('get moex transaction') }}" class="small-box-footer">View details <i class="fa fa-arrow-circle-right"></i></a>
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
        <a href="{{ route('purchase refund request') }}" class="small-box-footer">View details <i
                class="fa fa-arrow-circle-right"></i></a>
    </div>
</div>



<div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-blue">
        <div class="inner">
            <h3>
                @if ($override = \App\User::where([['accountLevel', '=', 2], ['approval', '=', 0], ['bvn_verification', '=', 0], ['account_check', '=', 0]])->count())
                    {{ $override }}
                @else
                    0
                @endif
            </h3>

            <p>IDV Failed</p>

        </div>
        <div class="icon">
            <i class="ion ion-person-add"></i>
        </div>
        <a href="{{ route('override users by country') }}" class="small-box-footer">View all <i
                class="fa fa-arrow-circle-right"></i></a>
    </div>
</div>

<div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-orange">
        <div class="inner">
            <h3>
                @if ($matchedUsers = \App\User::where([['accountLevel', '>=', 2], ['approval', '>=', 1], ['account_check', '=', 0]])->count())
                    {{ $matchedUsers }}
                @else
                    0
                @endif
            </h3>

            <p>IDV Passed - (Set restriction)</p>
        </div>
        <div class="icon">
            <i class="ion ion-person-add"></i>
        </div>
        <a href="{{ route('matched users by country') }}" class="small-box-footer">View all <i
                class="fa fa-arrow-circle-right"></i></a>
    </div>
</div>

<div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-purple">
        <div class="inner">
            {{-- <h3>@if ($approvedpendingusers = \App\User::where('accountLevel', '<=', 3)->where('approval', '<=', 2)->where('account_check', '<=', 1)->count()) {{ $approvedpendingusers }} @else 0 @endif</h3> --}}
            <h3>
                @if ($approvedpendingusers = \App\User::where('account_check', 1)->count())
                    {{ $approvedpendingusers }}
                @else
                    0
                @endif
            </h3>

            <p>IDV Completed - Pending</p>
        </div>
        <div class="icon">
            <i class="ion ion-person-add"></i>
        </div>
        <a href="{{ route('approved pending users by country') }}" class="small-box-footer">View all <i
                class="fa fa-arrow-circle-right"></i></a>
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
