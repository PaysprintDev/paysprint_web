@extends('layouts.dashboard')

@section('dashContent')


<?php use \App\Http\Controllers\User; ?>
<?php use \App\Http\Controllers\BankWithdrawal; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         Withdrawal to Bank Account
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Withdrawal to Bank Account</li>
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
                    @if (count($data['bankRequestWithdrawal']) > 0)
                    <?php $i = 1;?>
                        @foreach ($data['bankRequestWithdrawal'] as $data)
                        <tr>
                            <td>{{ $i++ }}</td>

                            <td>{{ $data->country }}</td>

                            @if($user = \App\User::where('ref_code', $data->ref_code)->first())

                            @php
                                $currencyCode = $user->currencyCode;
                                $currencySymbol = $user->currencySymbol;
                            @endphp

                            @endif

                            @if($amount = \App\BankWithdrawal::where('country', $data->country)->where('status', 'PENDING')->sum('amountToSend'))
                                <td style="font-weight: 700;">{{ $currencySymbol.' '.number_format($amount, 2) }}</td>
                            @endif


                            <td>
                                <a type="button" href="{{ route('bank withdrawal by country', 'country='.$data->country) }}" class="btn btn-primary btn-block">View details</a>
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


