@extends('layouts.dashboard')

@section('dashContent')


<?php use \App\Http\Controllers\User; ?>
<?php use \App\Http\Controllers\FxPayment; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         Escrow Funding List
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Escrow Funding List</li>
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
                  <th>Reference No.</th>
                  <th>ES Account Number</th>
                  <th>Amount Funded</th>
                  <th>Payment Method</th>
                  <th>Bank Name</th>
                  <th>Bank Account Number</th>
                  <th>Bank Account Name</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    @if (count($data['getescrow']) > 0)
                    <?php $i = 1;?>
                        @foreach ($data['getescrow'] as $data)
                        <tr>

                            @if($money = \App\FxPayment::where('escrow_id', $data->user_id)->first())

                              @php
                                  $referenceno = $money->reference_number;
                                  $escrowNumber = $money->escrow_id;
                                  $amount = $money->amount;
                                  $paymentMethod = $money->payment_method;
                                  $bankName = $money->bank_name;
                                  $accountNumber = $money->account_number;
                                  $accountName = $money->account_name;
                                  $currencyCode = $money->currencyCode;
                              @endphp

                            <td>{{ $i++ }}</td>


                            <td>{{ $referenceno }}</td>
                            <td>{{ $escrowNumber }}</td>
                            <td>{{ $currencyCode." ".number_format($amount, 2) }}</td>
                            <td>{{ $paymentMethod }}</td>
                            <td>{{ $bankName }}</td>
                            <td>{{ $accountNumber }}</td>
                            <td>{{ $accountName }}</td>
                            <td>{{ strtoupper($data->confirmation) }}</td>


                            <td>

                                <form action="{{ route('confirm es pay', 'escrow_id='.$escrowNumber) }}" method="post" id="thisform{{ $escrowNumber }}" style="visibility: hidden;">@csrf</form>

                                <a type="button" href="javascript:void()" onclick="confirmEsPay('{{ $escrowNumber }}')" class="btn btn-primary">Confirm Payment</a>
                            </td>


                            @endif


                             

                            

                        </tr>
                        @endforeach

                    @else
                    <tr>
                        <td colspan="10" align="center">No record available</td>
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


