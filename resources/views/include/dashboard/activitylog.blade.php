<div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-aqua">
      <div class="inner">
        <h3>&nbsp;</h3>


        <p>Activity Log</p>
      </div>
      <div class="icon">
        <i class="ion ion-stats-bars"></i>
      </div>
      <a href="#" class="small-box-footer">View details <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-green">
      <div class="inner">
        <h3>{{ count($withdraws['bank']) }}</h3>

        <p>Transaction Review</p>
      </div>
      <div class="icon">
        <i class="ion ion-stats-bars"></i>
      </div>
      <a href="{{ route('aml transaction review') }}" class="small-box-footer">View details <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>

  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-black">
      <div class="inner">
        <h3>{{ count($withdraws['purchase']) }}</h3>

        <p>Transaction Analysis</p>
      </div>
      <div class="icon">
        <i class="ion ion-stats-bars"></i>
      </div>
      <a href="#" class="small-box-footer">View details <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>


  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-blue">
      <div class="inner">
        <h3>{{ count($withdraws['credit']) }}</h3>

        <p>Compliance Desk Review</p>
      </div>
      <div class="icon">
        <i class="ion ion-stats-bars"></i>
      </div>
      <a href="#" class="small-box-footer">View details <i class="fa fa-arrow-circle-right"></i></a>
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


        <p>Reports</p>
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




  <!-- ./col -->
