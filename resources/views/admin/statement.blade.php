@extends('layouts.dashboard')

@section('dashContent')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         Transaction History
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Transaction History</li>
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

              <br>

              <form action="{{ route('statement report') }}" method="GET">
                  @csrf

                  <div class="row">
                  <div class="col-md-12">
                    <select name="statement_service" class="form-control" id="statement_service">
                      @if (count($servicetypes) > 0)
                          @foreach ($servicetypes as $data)

                            <option value="{{ $data->name }}">{{ $data->name }}</option>   
                          @endforeach
                      @else
                        <option value=""> Create Service Type</option>
                      @endif
                        
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
                    {{-- onclick="checkStatement()" --}}
                    <button class="btn btn-primary" type="submit">Check Transactions <img src="https://i.ya-webdesign.com/images/loading-gif-png-5.gif" class="spinner disp-0" style="width: 40px; height: 40px;"></button>
                  </div>
                </div>

              </form>

              
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

                            @if($userInfo = \App\User::where('ref_code', session('user_id'))->first())

                              <td>{{ $userInfo->currencySymbol.number_format($items->invoice_amount, 2) }}</td>
                              <td>{{ $userInfo->currencySymbol.number_format($items->amount_paid, 2) }}</td>
                            <td><?php $inv = $items->invoice_amount; $amt = $items->amount_paid; $rem = $inv - $amt;?> {{ $userInfo->currencySymbol.number_format($rem,2) }}</td>
                              @endif

                            
                        </tr>
                        @endforeach

                    @else
                    <tr>
                        <td colspan="7" align="center">No transaction available</td>
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
