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
            <h3>@if ($override = \App\User::where([['accountLevel', '=', 2], ['approval', '=', 0], ['bvn_verification', '=', 0], ['account_check', '=', 0]])->count()) {{ $override }}  @else 0 @endif</h3>

            <p>IDV Failed</p>

        </div>
        <div class="icon">
            <i class="ion ion-person-add"></i>
        </div>
        <a href="{{ route('override users by country') }}" class="small-box-footer">View all <i
                class="fa fa-arrow-circle-right"></i></a>
    </div>
</div>
