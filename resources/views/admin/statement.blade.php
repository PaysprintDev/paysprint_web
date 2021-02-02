@extends('layouts.dashboard')

@section('dashContent')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         Statement
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Statement</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Statement</h3> <br>

              <br>
              <div class="row">
                <div class="col-md-12">
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
                  <input type="date" name="statement_start" class="form-control" id="statement_start">
                </div>
                <div class="col-md-6">
                  <input type="date" name="statement_end" class="form-control" id="statement_end">
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-md-12">
                  <button class="btn btn-primary" onclick="checkStatement()">Check Statement <img src="https://i.ya-webdesign.com/images/loading-gif-png-5.gif" class="spinner disp-0" style="width: 40px; height: 40px;"></button>
                </div>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example3" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Transaction Date</th>
                  <th>Description</th>
                  <th>Reference Code</th>
                  <th>Invoice Amount</th>
                  <th>Amount Paid</th>
                  <th>Remaining Balance</th>
                </tr>
                </thead>
                <tbody id="statementtab">
                    @if (count($otherPays) > 0)
                    <?php $i = 1; ?>
                        @foreach ($otherPays as $items)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ date('d/F/Y', strtotime($items->transaction_date)) }}</td>
                            <td>{!! $items->description !!}</td>
                            <td>{{ $items->transactionid }}</td>
                            <td>{{ number_format($items->invoice_amount, 2) }}</td>
                            <td>{{ number_format($items->amount_paid, 2) }}</td>
                            <td><?php $inv = $items->invoice_amount; $amt = $items->amount_paid; $rem = $inv - $amt;?> {{ number_format($rem,2) }}</td>
                        </tr>
                        @endforeach

                    @else
                    <tr>
                        <td colspan="5" align="5">No statement available</td>
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
