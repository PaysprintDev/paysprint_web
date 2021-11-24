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
