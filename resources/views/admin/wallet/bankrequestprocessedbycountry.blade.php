@extends('layouts.dashboard')

@section('dashContent')


<?php use \App\Http\Controllers\User; ?>
<?php use \App\Http\Controllers\AddBank; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         Processed Withdrawals to Bank Account
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Processed Withdrawals to Bank Account</li>
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
                  <th>Name</th>
                  <th>Bank Name</th>
                  <th>Account Number</th>
                  <th>Transit Number</th>
                  <th>Branch Code</th>
                  <th>Amount To Send</th>
                  <th>Status</th>
                  <th>Request Date</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    @if (count($data['bankRequestProceesedbycountry']) > 0)
                    <?php $i = 1;?>
                        @foreach ($data['bankRequestProceesedbycountry'] as $data)
                        <tr>
                            <td>{{ $i++ }}</td>

                            @if($user = \App\User::where('ref_code', $data->ref_code)->first())

                            @php
                                $currencyCode = $user->currencyCode;
                            @endphp

                            <td>{{ $user->name }}</td>

                            @endif

                            @if($bank = \App\AddBank::where('id', $data->bank_id)->first())

                            <td>{{ $bank->bankName }}</td>
                            <td>{{ $bank->accountNumber }}</td>
                            <td>{{ $bank->transitNumber }}</td>
                            <td>{{ $bank->branchCode }}</td>
                            <td style="font-weight: 700;">{{ $currencyCode.' '.number_format($data->amountToSend, 2) }}</td>
                            <td style="font-weight: bold; color: {{ $data->status == "PENDING" ? "red" : "green" }}">{{ $data->status }}</td>

                            @endif
                            
                            
                            <td>
                                {{ date('d/M/Y h:i:a', strtotime($data->created_at)) }}
                            </td>
                            <td>
                                @php
                                    if($data->status == "PENDING"){
                                        $btnClass = "btn btn-primary btn-block";
                                        $btnVal = "Process Payment";
                                        $disabled = "";
                                    }
                                    else{
                                        $btnClass = "btn btn-success btn-block";
                                        $btnVal = "Account Paid";
                                        $disabled = "disabled";
                                    }
                                @endphp
                                <button class="{{ $btnClass }}" {{ $disabled }} onclick="payBank('{{ $data->id }}')">{{ $btnVal }} <img class="spin{{ $data->id }} disp-0" src="https://i.ya-webdesign.com/images/loading-gif-png-5.gif" style="width: 20px; height: 20px;"></button>
                            </td>

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


