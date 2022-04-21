@extends('layouts.dashboard')

@section('dashContent')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         Recurring Report
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Recurring Report</li>
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
                  <th>Recurring Type</th>
                  <th>Amount Invoiced</th>
                  <th>Amount Paid</th>
                  <th>Remaining balance</th>
                </tr>
                </thead>
                <tbody id="statementtab">
                    @if (count($data['getrecurringReport']) > 0)
                    <?php $i = 1; $totalPaid = 0; $remtoPay = 0; $totalinv = 0;?>
                        @foreach ($data['getrecurringReport'] as $items)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $items->recurring }}</td>

                              <td>{{ $data['userInfo']->currencySymbol.number_format($items->total_amount, 2) }}</td>
                              <td><?php $inv = $items->total_amount; $amt = $items->remaining_balance; $amountpaid = $inv - $amt;?> {{ $data['userInfo']->currencySymbol.number_format($amountpaid,2) }}</td>
                              <td>{{ $data['userInfo']->currencySymbol.number_format($items->remaining_balance, 2) }}</td>

                            
                        </tr>

                            @php
                                $totalinv += $items->total_amount;
                                $totalPaid += $amountpaid;
                                $remtoPay += $items->remaining_balance;
                            @endphp

                        @endforeach

                    @else
                    <tr>
                        <td colspan="5" align="center">No record</td>
                    </tr>
                    @endif
                </tbody>

                @isset($totalinv)
                    <tfoot>
                    <tr>
                        <td></td>
                        <td style="font-weight: bold; color: black;">Total: </td>
                        <td style="font-weight: bold; color: navy;">{{ $data['userInfo']->currencySymbol.number_format($totalinv, 2) }}</td>
                        <td style="font-weight: bold; color: green;">{{ '+'.$data['userInfo']->currencySymbol.number_format($totalPaid, 2) }}</td>
                        <td style="font-weight: bold; color: red;">{{ '-'.$data['userInfo']->currencySymbol.number_format($remtoPay, 2) }}</td>
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
