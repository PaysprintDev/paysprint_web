@extends('layouts.dashboard')

@section('dashContent')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         Tax Report
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Tax Report</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        
        <div class="col-xs-12">
          
          <div class="box">
            <div class="box-header">
              <div class="row">
                <div class="col-md-2 col-md-offset-0">
                <button class="btn btn-secondary btn-block bg-red" onclick="goBack()"><i class="fas fa-chevron-left"></i> Go back</button>
            </div>
            </div>

              <h3 class="box-title">&nbsp;</h3> <br>

              <div class="row disp-0">
                <div class="col-md-6">
                  <input type="date" name="statement_start" class="form-control" id="statement_start">
                </div>
                <div class="col-md-6">
                  <input type="date" name="statement_end" class="form-control" id="statement_end">
                </div>
              </div>
              <br>
              <div class="row disp-0">
                <div class="col-md-12">
                  <button class="btn btn-primary" onclick="checkStatement()">Check Transactions <img src="https://i.ya-webdesign.com/images/loading-gif-png-5.gif" class="spinner disp-0" style="width: 40px; height: 40px;"></button>
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
                  <th>Invoice Number</th>
                  <th>Customer</th>
                  <th>Service</th>
                  <th>Tax Amount</th>
                </tr>
                </thead>
                <tbody id="statementtab">
                    @if (count($data['gettotalTax']) > 0)
                    <?php $i = 1; $totalPaid = 0; $remtoPay = 0; $totalinv = 0;?>
                        @foreach ($data['gettotalTax'] as $items)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ date('d/F/Y', strtotime($items->transaction_date)) }}</td>
                            <td>{!! $items->invoice_no !!}</td>
                            <td>{{ $items->name }}</td>
                            <td>{{ $items->service }}</td>

                              <td>{{ $data['userInfo']->currencySymbol.number_format($items->tax_amount, 2) }}</td>

                            
                        </tr>

                            @php
                                $totalinv += $items->tax_amount;
                            @endphp

                        @endforeach

                    @else
                    <tr>
                        <td colspan="6" align="center">No record</td>
                    </tr>
                    @endif
                </tbody>

                @isset($totalinv)
                    <tfoot>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="font-weight: bold; color: black;">Total: </td>
                        <td style="font-weight: bold; color: green;">{{ '+'.$data['userInfo']->currencySymbol.number_format($totalinv, 2) }}</td>
                    </tr>
                </tfoot>
                @endisset
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
