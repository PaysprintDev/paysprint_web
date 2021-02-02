@extends('layouts.dashboard')

@section('dashContent')


<?php use \App\Http\Controllers\User; ?>
<?php use \App\Http\Controllers\InvoicePayment; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         General Fee Report
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">General Fee Report</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">General Fee Report</h3>
              {{-- <br>
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
                  <button class="btn btn-primary" onclick="checkremittance('payca')">Check Report <img src="https://i.ya-webdesign.com/images/loading-gif-png-5.gif" class="spinner disp-0" style="width: 40px; height: 40px;"></button>
                </div>
              </div> --}}

            </div>
            <!-- /.box-header -->
            <div class="box-body">

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
                  <th>Remittance Date</th>
                  <th>Client Name</th>
                  <th>Total Amount</th>
                  <th>Total Remittance</th>
                  <th>Commission Fee</th>
                  <th>Start Date</th>
                  <th>End Date</th>
                </tr>
                </thead>
                <tbody>
                    @if (count($collectfee) > 0)
                    <?php $i = 1; $fixed = $transCost[0]->fixed / 100; $variable = $transCost[0]->variable * count($collectfee); ?>
                        @foreach ($collectfee as $items)
                        <tr>
                            <td>{{ $i++ }}</td>
                            
                            <td>{{ date('d/F/Y', strtotime($items->remittance_date)) }}</td>
                            <td>{{ $items->client_name }}</td>
                            <td style="color: green; font-weight: bold;" align="center">${{ number_format($items->total_amount, 2) }}</td>
                            <td style="color: green; font-weight: bold;" align="center">${{ number_format($items->total_remittance, 2) }}</td>


                            <td style="color: green; font-weight: bold; display: none;">
                                    Collection Fee: ${{ $collect = $variable + ($items->total_amount * $fixed) }} <hr>
                                    Net Collection: ${{ $netFee = $items->total_amount - $collect }}
                                </td>

                            <td style="color: green; font-weight: bold;" align="center">${{ number_format($netFee, 2) }}</td>
                            <td>{{ date('d/F/Y', strtotime($items->start_date)) }}</td>
                            <td>{{ date('d/F/Y', strtotime($items->end_date)) }}</td>

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


