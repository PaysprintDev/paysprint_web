@extends('layouts.dashboard')

@section('dashContent')


<?php use \App\Http\Controllers\User; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         xPAY Remittance Report
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">xPAY Remittance Report</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">xPAY Remittance Report</h3>
              <br>
              <div class="row">
                <div class="col-md-12">
                  <h6 style="font-weight: bold;">Client List</h6>
                  <select name="statement_client_name" class="form-control" id="statement_client_name">
                      @if (count($getwithdraw) > 0)
                      <option value="">Select client</option>
                      @foreach($getwithdraw as $clients)

                        <option value="{{ $clients->client_id }}">{{ $clients->client_name }}</option>

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
                        <option value="All">All</option>
                        <option value="Offering">Offering</option>
                        <option value="Tithe">Tithe</option>
                        <option value="Seed">Seed</option>
                        <option value="Contribution">Contribution</option>
                        <option value="Others">Others</option>
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
                  <button class="btn btn-primary" onclick="checkremittance('epayca')">Check Report <img src="https://i.ya-webdesign.com/images/loading-gif-png-5.gif" class="spinner disp-0" style="width: 40px; height: 40px;"></button>
                </div>
              </div>


            </div>
            <!-- /.box-header -->
            <div class="box-body">

              <table class="table table-bordered">
                
              </table>
              <br>

              <table id="example3" class="table table-bordered table-striped">
                <thead>
                  <h2 id="no_of_records"></h2>
                <tr>
                  <th>S/N</th>
                  <th>Name of Client</th>
                  <th>Client Email</th>
                  <th style="text-align: center;">Amount To Withdraw</th>
                  <th>Payment Method</th>
                  <th>Request Date</th>
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


