@extends('layouts.dashboard')

@section('dashContent')


<?php use \App\Http\Controllers\User; ?>
<?php use \App\Http\Controllers\OrganizationPay; ?>
<?php use \App\Http\Controllers\ClientInfo; ?>
<?php use \App\Http\Controllers\Notifications; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         Activity Statistic Count
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Activity Statistic Count</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Activity Statistic Count</h3><br><br><br>

              <form action="{{ route('activity per day') }}" method="get">
                @csrf
                <div class="row">
                  <div class="col-md-6">
                    <label>Start Date</label>
                    <input type="date" name="start" class="form-control" id="start" required>
                  </div>
                  <div class="col-md-6">
                    <label>End Date</label>
                    <input type="date" name="end" class="form-control" id="end" required>
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col-md-12">
                    <button class="btn btn-primary">Check Activity </button>
                  </div>
                </div>
              </form>
              
            </div>
            <!-- /.box-header -->
            <div class="box-body table table-responsive">
                @php
                        $start = Request::get('start');
                        $end = Request::get('end');
                    @endphp

              <table class="table table-bordered table-striped" id="example3">
                <caption class="text-center">
                    <h3>Activity Statistic Report From {{ date('d/M/Y', strtotime($start)) }} to {{ date('d/M/Y', strtotime($end)) }}</h3>
                </caption>
                <thead>
                  <div class="row">
                    <div class="col-md-6">
                      <h3 id="period_start"></h3>
                    </div>
                    <div class="col-md-6">
                      <h3 id="period_stop"></h3>
                    </div>
                  </div>
                <tr>
                  <th>S/N</th>
                  {{-- <th>Country</th> --}}
                  <th>Date</th>
                  <th>Activity Count</th>
                </tr>
                </thead>
                <tbody>

                    

                    @if (count($data['activity']) > 0)
                    <?php $i = 1;?>
                        @foreach ($data['activity'] as $data)


                        <tr>
                            <td>{{ $i++ }}</td>

                            {{-- <td>{{ $data->country }}</td> --}}
                            <td>{{ date('d/M/Y', strtotime($data->period)) }}</td>

                            <td>@if($activityCount = \App\Notifications::where('period', 'LIKE', '%'.$data->period.'%')->where('country', $data->country)->count()) {{ $activityCount }} @else 0 @endif</td>

                        </tr>
                        @endforeach

                         
                    @else
                    <tr>
                        <td colspan="3" align="center">No record available</td>
                    </tr>
                    @endif
                </tbody>

              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection


