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
         Send Money Transactions
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Send Money Transactions</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Send Money Transactions</h3>
              
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
                  <th>Paymt. To</th>
                  <th>Paymt. From</th>
                  <th>Purpose</th>
                  <th>Amt. paid</th>
                  <th>Amt. to send</th>
                  <th>Comssn. charge</th>
                  <th>Include comssn.</th>
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

                            @if($receiver = \App\User::where('ref_code', $items->coy_id)->first())

                              @if (isset($receiver))

                                <td>{{ $receiver->name }}</td>
                                  
                                @else
                              
                                <td>-</td>
                                  
                              @endif


                            @endif


                            @if($sender = \App\User::where('email', $items->user_id)->first())

                              @if (isset($sender))

                                <td>{{ $sender->name }}</td>
                                  
                                @else
                              
                                <td>-</td>
                                  
                              @endif


                            @endif



                            <td>{{ $items->purpose }}</td>

                            <td style="color: green; font-weight: bold;" align="center">{{ $items->amount }}</td>
                            
                            <td style="color: darkorange; font-weight: bold;" align="center">{{ $items->amount_to_send }}</td>

                            <td style="color: purple; font-weight: bold;" align="center">{{ $items->commission }}</td>


                            <td style="color: navy; font-weight: bold; font-size: 11px;" align="center">{{ $items->approve_commission }}</td>
                            <td>{{ date('d/M/Y', strtotime($items->created_at)) }}</td>
                            
                            <td style="color: red; font-weight: bold; font-size: 11px;" align="center">PENDING APPROVAL</td>
                            
                            <td>
                              <button class="btn btn-danger" id="processPay" onclick="confirmPay('{{ $items->transactionid }}', '{{ $items->user_id }}', '{{ $items->coy_id }}')">Confirm Payment <img class="spin{{ $items->transactionid }} disp-0" src="https://i.ya-webdesign.com/images/loading-gif-png-5.gif" style="width: 20px; height: 20px;"></button>
                            </td>


                        </tr>
                        @endforeach

                        

                    @else
                    <tr>
                        <td colspan="12" align="center">No record available</td>
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


