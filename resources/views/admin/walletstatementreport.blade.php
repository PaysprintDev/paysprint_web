@extends('layouts.dashboard')

@section('dashContent')

<?php use \App\Http\Controllers\ClientInfo; ?>
<?php use \App\Http\Controllers\User; ?>
<?php use \App\Http\Controllers\InvoicePayment; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         Wallet Transaction History
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Wallet Transaction History</li>
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
              <form action="{{ route('wallet report') }}" method="GET">
                @csrf
                  <br>
                <div class="row">
                  <div class="col-md-12">
                    <select name="statement_service" class="form-control" id="statement_service">
                        <option value="Wallet">Wallet</option>
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

                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                        <td colspan="3" align="center"><strong style="font-size: 24px;">Service Type: {{ Request::get('statement_service') }} | From: {{ date('d-m-Y', strtotime(Request::get('statement_start'))) }} - To: {{ date('d-m-Y', strtotime(Request::get('statement_end'))) }} </strong></td>
                    </tr>
                    </tbody>
                </table>

                <br>
                <br>

              <table id="example3" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Date</th>
                  <th>Tranx. ID</th>
                  <th>Description</th>
                  <th>Amount</th>
                </tr>
                </thead>
                <tbody id="statementtab">
                    @if (count($thisdata['result']) > 0)
                    @foreach ($thisdata['result'] as $walletstatements)
                            <tr>
                                <td><i class="fas fa-circle {{ ($walletstatements->credit != 0) ? "text-success" : "text-danger" }}"></i></td>
                                <td>
                                  {{ date('d/m/Y', strtotime($walletstatements->created_at)) }}
                                </td>
                                <td>
                                  {{ $walletstatements->reference_code }}
                                </td>
                                <td>

                                        <div class="row">
                                            <div class="col-md-12">
                                                {!! $walletstatements->activity !!}
                                            </div>
                                            <div class="col-md-12">
                                                <small>
                                                    {{ $walletstatements->reference_code }}
                                                </small><br>
                                                <small>
                                                    {{ date('d/m/Y h:i a', strtotime($walletstatements->created_at)) }}
                                                </small>
                                            </div>
                                        </div>

                                    </td>

                                    @if($userInfo = \App\User::where('ref_code', session('user_id'))->first())

                                    <td style="font-weight: 700" class="{{ ($walletstatements->credit != 0) ? "text-success" : "text-danger" }}">{{ ($walletstatements->credit != 0) ? "+".$userInfo->currencySymbol.number_format($walletstatements->credit, 2) : "-".$userInfo->currencySymbol.number_format($walletstatements->debit, 2) }}</td>


                                    @endif

                                
                            </tr>
        
                        @endforeach
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
