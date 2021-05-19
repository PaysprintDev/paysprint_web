@extends('layouts.dashboard')

@section('dashContent')


<?php use \App\Http\Controllers\User; ?>
<?php use \App\Http\Controllers\Statement; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         Withdrawal Report
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Withdrawal Report</li>
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
              
            </div>
            <!-- /.box-header -->
            <div class="box-body table table-responsive">

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
                  <th>Country</th>
                  <th>Total Amount</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    @if (count($data['getwithdrawalbycountry']) > 0)
                    <?php $i = 1; $totalPaid = 0; $remtoPay = 0; $totalinv = 0;?>
                        @foreach ($data['getwithdrawalbycountry'] as $data)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $data->country }}</td>

                            @if($amount = \App\Statement::where('country', $data->country)->where('activity', 'LIKE', '%Withdraw%')->sum('debit'))

                                @php
                                    $totalAmount = $amount;
                                @endphp

                            @endif

                            @if($currency = \App\User::where('country', $data->country)->first())

                                @php
                                    $currencyCode = $currency->currencyCode;
                                @endphp

                            @endif

                            <td style="font-weight: 700;">{{ $currencyCode.' '.number_format($totalAmount, 2) }}</td>

                            <td>
                                <a href="{{ route('withdrawal by country', 'country='.$data->country) }}" type="button" class="btn btn-primary">View details</a>
                            </td>
                        </tr>


                        @endforeach

                        

                    @else
                    <tr>
                        <td colspan="4" align="center">No record available</td>
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


