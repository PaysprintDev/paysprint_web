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
          <div class="small-box bg-blue">
            <div class="inner">
              <h3>@if($override = \App\User::where('accountLevel', 2)->where('approval', 0)->where('archive', '!=', 1)->count()) {{ $override }}  @else 0 @endif</h3>

              <p>IDV Failed</p>

            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ route('override users by country') }}" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>