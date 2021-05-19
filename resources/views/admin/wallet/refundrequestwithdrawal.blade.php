@extends('layouts.dashboard')

@section('dashContent')


<?php use \App\Http\Controllers\User; ?>
<?php use \App\Http\Controllers\Statement; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         Refund Request
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Refund Request</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Refund Request</h3>
              
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
                  <th>Customer Name</th>
                  <th>Transaction ID</th>
                  <th>Amount to Refund</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    @if (count($data['requestforrefund']) > 0)
                    <?php $i = 1;?>
                        @foreach ($data['requestforrefund'] as $data)
                        <tr>
                            <td>{{ $i++ }}</td>

                            @if($user = \App\User::where('id', $data->user_id)->first())

                            @php
                                $currencyCode = $user->currencyCode;
                                $name = $user->name;
                                $currencySymbol = $user->currencySymbol;
                            @endphp

                            @else

                            @php
                                $currencyCode = "";
                                $currencySymbol = "";
                                $name = "-";
                            @endphp



                            @endif

                            <td>{{ $name }}</td>

                            <td>{{ $data->transaction_id }}</td>

                            @if($transactionInfo = \App\Statement::where('reference_code', $data->transaction_id)->first())
                            <td style="font-weight: 700;">{{ $currencySymbol.' '.number_format($transactionInfo->debit, 2) }}</td>

                            @else
                            <td style="font-weight: 700;">{{ $currencySymbol.' '.number_format(0, 2) }}</td>
                            @endif

                            <td style="@if($data->status == 'PROCESSED') color: green; @elseif($data->status == 'DECLINED') color: red; @else color: darkorange; @endif"><strong>{{ $data->status }}</strong></td>


                            <td>
                                <a type="button" href="{{ route('refund details', $data->transaction_id) }}" class="btn btn-primary btn-block">View details</a>
                            </td>

                        </tr>
                        @endforeach

                    @else
                    <tr>
                        <td colspan="5" align="center">No record available</td>
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


