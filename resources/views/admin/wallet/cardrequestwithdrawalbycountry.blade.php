@extends('layouts.dashboard')

@section('dashContent')


<?php use \App\Http\Controllers\User; ?>
<?php use \App\Http\Controllers\AddCard; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         Credit/Debit Card Withdrawal Request
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Credit/Debit Card Withdrawal Request</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        
        <br>
          <button class="btn btn-secondary btn-block bg-red" onclick="goBack()"><i class="fas fa-chevron-left"></i> Go back</button>
        <br>

      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            
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
                  <th>Customer ID</th>
                  <th>Card Type</th>
                  <th>Card Number</th>
                  <th>Expiry Date</th>
                  <th>Amount to Send</th>
                  <th>Request Date</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    @if (count($data['cardRequestWithdrawalbycountry']) > 0)
                    <?php $i = 1;?>
                        @foreach ($data['cardRequestWithdrawalbycountry'] as $data)
                        <tr>
                            <td>{{ $i++ }}</td>

                            @if($user = \App\User::where('ref_code', $data->ref_code)->first())

                            @php
                                $currencyCode = $user->currencyCode;
                                $currencySymbol = $user->currencySymbol;
                            @endphp

                            <td>{{ $user->name }}</td>

                            @endif

                            <td>{{ $data->transaction_id }}</td>
                            <td>{{ $data->customer_id }}</td>

                            @if($mycard = \App\AddCard::where('card_number', $data->card_number)->first())

                            <td>{{ $mycard->card_provider.'/'.$mycard->card_type }}</td>
                            <td>{{ $mycard->card_number }}</td>
                            <td>{{ $mycard->month.'/'.$mycard->year }}</td>
                            <td style="font-weight: 700;">{{ $currencySymbol.' '.number_format($data->amount, 2) }}</td>
                            <td>{{ date('d/M/Y', strtotime($data->created_at)) }}</td>
                            <td style="font-weight: bold; color: {{ $data->status == "PENDING" ? "red" : "green" }}">{{ $data->status }}</td>

                            @endif


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
                                <button class="{{ $btnClass }}" {{ $disabled }} onclick="payCard('{{ $data->id }}')">{{ $btnVal }} <img class="spin{{ $data->id }} disp-0" src="https://i.ya-webdesign.com/images/loading-gif-png-5.gif" style="width: 20px; height: 20px;"></button>
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


