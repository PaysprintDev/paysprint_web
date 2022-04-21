@extends('layouts.dashboard')

@section('dashContent')


<?php use \App\Http\Controllers\User; ?>
<?php use \App\Http\Controllers\InvoicePayment; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         Commission Report
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Commission Report</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Commission Report</h3>
              <br>
              <div class="row">
                <div class="col-md-12">
                  <h6 style="font-weight: bold;">Client List</h6>
                  <select name="statement_client_name" class="form-control" id="statement_client_name">
                      @if (count($getClient) > 0)
                      <option value="">Select client</option>
                      @foreach($getClient as $clients)

                        <option value="{{ $clients->user_id }}">{{ $clients->firstname.' '.$clients->lastname }}</option>

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
                  <select name="statement_service" class="form-control" id="statement_service">
                      <option value="all">All</option>
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
                  <button class="btn btn-primary" onclick="checkremittance('comission')">Check Report <img src="https://i.ya-webdesign.com/images/loading-gif-png-5.gif" class="spinner disp-0" style="width: 40px; height: 40px;"></button>
                </div>
              </div>

            </div>
            <!-- /.box-header -->
            <div class="box-body">

              <table class="table table-bordered table-striped" id="reportTable">
                <thead>
                  <h2 id="no_of_records"></h2>
                <tr>
                  <th>S/N</th>
                  <th>Name of Payee</th>
                  <th>Payee Ref.</th>
                  <th>Service</th>
                  <th>Invoice #</th>
                  <th>Amount</th>
                </tr>
                </thead>
                <tbody id="statementtab">
                  
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


