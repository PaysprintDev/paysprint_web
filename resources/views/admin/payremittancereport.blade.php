@extends('layouts.dashboard')

@section('dashContent')

<?php use \App\Http\Controllers\User; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         PaySprint Remittance Report
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">PaySprint Remittance Report</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">PaySprint Remittance Report</h3> <br>
              {{-- <br>
              <div class="row">
                <div class="col-md-12">
                  <h6 style="font-weight: bold;">Service</h6>
                  <select name="statement_service" class="form-control" id="statement_service">
                      <option value="Rent">Rent</option>
                      <option value="Property Tax">Property Tax</option>
                      <option value="Utility Bills">Utility Bills</option>
                      <option value="Traffic Ticket">Traffic Ticket</option>
                      <option value="Tax Bills">Tax Bills</option>
                      <option value="Others"> Others</option>
                  </select>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-md-6">
                  <h6 style="font-weight: bold;">Start Date</h6>
                  <input type="date" name="statement_start" class="form-control" id="statement_start">
                </div>
                <div class="col-md-6">
                  <h6 style="font-weight: bold;">End Date</h6>
                  <input type="date" name="statement_end" class="form-control" id="statement_end">
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-md-12">
                  <button class="btn btn-primary" onclick="checkreportStatement('payca')">Check Report <img src="https://i.ya-webdesign.com/images/loading-gif-png-5.gif" class="spinner disp-0" style="width: 40px; height: 40px;"></button>
                </div>
              </div> --}}

            </div>


            <!-- /.box-header -->
            <div class="box-body">

              <table class="table table-bordered">
                <tbody>
                  @if (count($report) > 0)
                  <?php $i = 1; $totAmount = 0;?>
                  @foreach ($report as $items)
                  <?php  $totAmount += $items->amount_paid; ?>

                  @endforeach

                  <tr>
                    <td style="color: black; font-weight: bold;">Total Remitted</td>
                    <td style="color: green; font-weight: bold;">${{ number_format($totAmount, 2) }}</td>
                    {{-- <td><button class="btn btn-success btn-block" onclick="WithdrawCash('{{ session('user_id') }}', '{{ $totAmount }}')">Withdraw Amount <img src="https://i.ya-webdesign.com/images/loading-gif-png-5.gif" class="spinner disp-0" style="width: 30px; height: 30px;"></button></td> --}}
                  </tr>

                  @endif

                </tbody>
              </table>
              <br>

              <table id="example3" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>S/N</th>
                  <th>Withdraw ID.</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Payment Method</th>
                  <th>Remitted Amount</th>
                  <th>Date Remitted</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody id="statementtab">
                    @if (count($report) > 0)
                    <?php $i = 1; $totAmount = 0;?>
                        @foreach ($report as $items)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $items->withdraw_id }}</td>
                            
                            <td>{{ $items->client_name }}</td>
                            <td>{{ $items->client_email }}</td>
                            <td>{{ $items->card_method }}</td>
                            <td style="color: green; font-weight: bold;">${{ number_format($items->amount_paid) }}</td>
                            <td>{{ date('d/F/Y', strtotime($items->updated_at)) }}</td>
                            <td>
                              <button class="btn btn-primary btn-block" onclick="remitdetailsCash('{{ $items->client_id }}', '{{ $items->withdraw_id }}', '{{ $items->amount_paid }}', 'payca')">View Detail<img src="https://i.ya-webdesign.com/images/loading-gif-png-5.gif" class="spinner{{ $items->withdraw_id }} disp-0" style="width: 30px; height: 30px;"></button>
                            </td>
                        </tr>
                        @endforeach

                        

                    @else
                    <tr>
                        <td colspan="11" align="center">No record available</td>
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


