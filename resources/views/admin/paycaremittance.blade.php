@extends('layouts.dashboard')

@section('dashContent')


<?php use \App\Http\Controllers\User; ?>
<?php use \App\Http\Controllers\InvoicePayment; ?>

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
              <h3 class="box-title">PaySprint Remittance Report</h3>
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
                  <th>Address</th>
                  <th>Payee Ref.</th>
                  <th>Service</th>
                  <th>Invoice #</th>
                  <th>Due Date</th>
                  <th>Payment Date</th>
                  <th>Payment Ref</th>
                  <th style="text-align: center;">Amount Paid</th>
                  <th id="tableaction" style="text-align: center;"></th>
                </tr>
                </thead>
                <tbody id="statementtab">
                  
                </tbody>
              </table>



              <br>

              <table class="table table-bordered table-striped disp-0">

                <thead>

                <tr>
                  <th>S/N</th>
                  <th>Name of Client</th>
                  <th>Payment Method</th>
                  <th>Client Email</th>
                  <th>Amount</th>
                  <th>Request Date</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    @if (count($getwithdraw) > 0)
                    <?php $i = 1; $fixed = $transCost[0]->fixed / 100; $variable = $transCost[0]->variable * count($getwithdraw);?>
                        @foreach ($getwithdraw as $items)
                        <tr>
                            <td>{{ $i++ }}</td>
                            
                            <td>{{ $items->client_name }}</td>
                            <td>{{ $items->card_method }}</td>
                            <td>{{ $items->client_email }}</td>

                            @if($user = \App\InvoicePayment::where('client_id', $items->client_id)->get())
                              @if(count($user) > 0)
                                <td style="color: green; font-weight: bold;">Total Amount: ${{ number_format($items->amount_to_withdraw, 2) }}<br>
                                    Collection Fee: ${{ $collect = $variable + ($items->amount_to_withdraw * $fixed) }} <hr>
                                    Net Collection: ${{ $netFee = $items->amount_to_withdraw - $collect }}
                                </td>
                                <td>{{ date('d/F/Y', strtotime($items->created_at)) }}</td>
                            <td><button class="btn btn-primary btn-block" onclick="remitdetailsCash('{{ $items->client_id }}', '{{ $items->withdraw_id }}', '{{ $netFee }}', 'payca')">View Detail<img src="https://i.ya-webdesign.com/images/loading-gif-png-5.gif" class="spinner{{ $items->withdraw_id }} disp-0" style="width: 30px; height: 30px;"></button>
                              <button class="btn btn-success btn-block" onclick="remittance('{{ $items->withdraw_id }}', '{{ $netFee }}', 'payca')" @if($items->remittance == 1) style="cursor: not-allowed;" disabled="" @endif>Remit<img src="https://i.ya-webdesign.com/images/loading-gif-png-5.gif" class="spin{{ $items->withdraw_id }} disp-0" style="width: 30px; height: 30px;"></button></td>
                              @endif
                            @endif


                            
                            
                            
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


