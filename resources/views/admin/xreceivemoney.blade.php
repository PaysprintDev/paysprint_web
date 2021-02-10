@extends('layouts.dashboard')

@section('dashContent')


<?php use \App\Http\Controllers\User; ?>
<?php use \App\Http\Controllers\OrganizationPay; ?>
<?php use \App\Http\Controllers\ClientInfo; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         Receive Money
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Receive Money</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Receive Money</h3>
              
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
                  <th>Trans. ID</th>
                  <th>Paymt. From</th>
                  {{-- <th>Purpose</th> --}}
                  <th>Amt. Sent</th>
                  <th>Amt. to receive</th>
                  <th>Commission</th>
                  <th>Pay. Method & Info</th>
                  <th>Currency</th>
                  <th>Date</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    @if (count($xpayRec) > 0)
                    <?php $i = 1;?>
                        @foreach ($xpayRec as $items)
                        <tr>
                            <td>{{ $i++ }}</td>
                            
                            <td>{{ $items->transactionid }}</td>


                            @if($sender = \App\User::where('ref_code', $items->payer_id)->first())

                              @if (isset($sender))

                                <td>{{ $sender->name }}</td>
                                  
                                @else
                              
                                <td>-</td>
                                  
                              @endif


                            @endif



                            {{-- <td>{{ $items->purpose }}</td> --}}

                            <td style="color: green; font-weight: bold;" align="center">${{ number_format($items->amount, 2) }}</td>
                            
                            <td style="color: darkorange; font-weight: bold;" align="center">${{ number_format($items->amount_to_receive, 2) }}</td>

                            <td style="color: purple; font-weight: bold;" align="center">${{ number_format($items->commission, 2) }}</td>

                            <td>
                                <p style="color: darkorange; font-weight: bold;">{{ $items->payment_method }}</p> <hr>

                                @if ($items->payment_method == "Bank")

                                <small style="color: green;">
                                    Bank Name: <b>{{ $items->bank_name }}</b> <hr> Acct. Name: <b>{{ $items->accountname }}</b> <hr> Acct. No: <b>{{ $items->account_number }}</b>
                                </small>
                                    
                                @else

                                <small style="color: navy;">
                                    Card No: <b>{{ $items->creditcard_no }}</b>
                                </small>
                                    
                                @endif
                            
                            </td>

                            <td>{{ $items->currency }}</td>

                            
                            <td>{{ date('d/M/Y', strtotime($items->created_at)) }}</td>


                            @if ($items->request_receive == 1)
                                <td style="color: red; font-weight: bold; font-size: 11px;" align="center">PAYMENT PENDING</td>

                                @elseif($items->request_receive == 2)
                                <td style="color: green; font-weight: bold; font-size: 11px;" align="center">PAYMENT PROCESSED</td>


                            @endif

                            
                            
                            @if ($items->request_receive == 1)
                            <td>
                              <button class="btn btn-danger" id="processPay" onclick="confirmPay('{{ $items->transactionid }}', '{{ $items->user_id }}', '{{ $items->coy_id }}')">Confirm Payment <img class="spin{{ $items->transactionid }} disp-0" src="https://i.ya-webdesign.com/images/loading-gif-png-5.gif" style="width: 20px; height: 20px;"></button>
                            </td>

                            @elseif($items->request_receive == 2)
                            <td>
                                <button class="btn btn-success" disabled> Payment Processed </button>
                            </td>

                            @endif


                        </tr>
                        @endforeach

                        

                    @else
                    <tr>
                        <td colspan="8" align="center">No record available</td>
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


