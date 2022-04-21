@extends('layouts.dashboard')

@section('dashContent')


<?php use \App\Http\Controllers\User; ?>
<?php use \App\Http\Controllers\InvoicePayment; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         Client Fee Report
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Client Fee Report</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Client Fee Report</h3>
              <br>
              <div class="row">
                <div class="col-md-12">
                  <h6 style="font-weight: bold;">Client List</h6>
                  <select name="feereport_client_name" class="form-control" id="feereport_client_name">
                      @if (count($collectfee) > 0)
                      <option value="">Select client</option>
                      @foreach($collectfee as $clients)

                        <option value="{{ $clients->client_email }}">{{ $clients->client_name }}</option>

                      @endforeach

                        @else

                        <option value="">No client to select at the moment</option>

                      @endif
                  </select>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-md-12">
                  <h6 style="font-weight: bold;">Service</h6>
                  <select name="feereport_service" class="form-control" id="feereport_service">
                      <option value="all">All</option>
                      <option value="payca">PaySprint</option>
                      <option value="epayca">xPAY</option>
                  </select>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-md-6">
                  <h6 style="font-weight: bold;">Start Date</h6>
                  <input type="date" name="period_start" class="form-control" id="period_start">
                </div>
                <div class="col-md-6">
                  <h6 style="font-weight: bold;">End Date</h6>
                  <input type="date" name="period_end" class="form-control" id="period_end">
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-md-12">
                  <button class="btn btn-primary" onclick="checkfeereport()">Check Report <img src="https://i.ya-webdesign.com/images/loading-gif-png-5.gif" class="spinner disp-0" style="width: 40px; height: 40px;"></button>
                </div>
              </div>

            </div>
            <!-- /.box-header -->
            <div class="box-body">

              <table class="table table-bordered table-striped" id="example3">

                <thead>
                  <div class="row">
                    <div class="col-md-6">
                      <h3 id="feeperiod_start"></h3>
                    </div>
                    <div class="col-md-6">
                      <h3 id="feeperiod_end"></h3>
                    </div>
                  </div>
                <tr>
                  <th>S/N</th>
                  <th>Remittance Date</th>
                  <th>Client Name</th>
                  <th>Total Amount</th>
                  <th>Total Remittance</th>
                  <th>Commission Fee</th>
                  <th>Platform</th>
                </tr>
                </thead>
                <tbody id="fee_report">
                    
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


