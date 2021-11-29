@extends('layouts.dashboard')

@section('dashContent')


<?php use \App\Http\Controllers\MonthlyFee; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         Monthly Maintenance Fee
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Monthly Maintenance Fee</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Monthly Maintenance Fee</h3>
              
            </div>
            <!-- /.box-header -->
            <div class="box-body table table-responsive">

              <table class="table table-bordered table-striped" id="example3">

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
                  <th>Country</th>
                  <th>Amount</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    @if (count($data['allmaintenanceFeedetail']) > 0)
                    <?php $i = 1; $totPay  = 0;?>
                        @foreach ($data['allmaintenanceFeedetail'] as $data)
                        

                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $data->country }}</td>

                             @if($totPay = \App\MonthlyFee::where('country', $data->country)->sum('amount'))
                                <td style="font-weight: 700;">{{ $data->currency.' '.number_format($totPay, 2) }}</td>
                            @endif
                            <td>
                                <a href="{{ route('maintenance fee by country', 'country='.$data->country) }}" class="btn btn-primary" type="button">View details</a>
                            </td>

                        </tr>
                        @endforeach

                    @else
                    <tr>
                        <td colspan="4" align="center">No record available</td>
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


