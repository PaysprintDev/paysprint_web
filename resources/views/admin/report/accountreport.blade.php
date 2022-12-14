@extends('layouts.dashboard')

@section('dashContent')


<?php use \App\Http\Controllers\User; ?>
<?php use \App\Http\Controllers\Statement; ?>
<?php use \App\Http\Controllers\MonthlyFee; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         Account Report
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Account Report</li>
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

              
            </div>
            <!-- /.box-header -->

            <div class="box-body table table-responsive">

              <table class="table table-bordered table-striped" id="example3">
                  
                <thead>
                    <tr>
                        <td>#</td>
                        <td>Country</td>
                        <td>Added to Wallet</td>
                        <td>Money Received</td>
                        <td>Money Sent</td>
                        {{-- <td>Monthly Fee</td> --}}
                        <td>Fund from Invoice</td>
                        <td>Fund from Utility</td>
                        <td>Withdraw</td>
                        <td>Actual Wallet Balance</td>
                        
                    </tr>
                </thead>


                @if (count($data['activecountries']) > 0)

                <?php $expected = 0; $actual= 0; $i=1;?>

                @foreach ($data['activecountries'] as $item)
                    <tr>

                        {{-- Added Money --}}
                        @if($addedAmount = \App\Statement::where('country', $item->name)->where('report_status', 'Added to wallet')->sum('credit'))

                            @php
                                $addedAmount = $addedAmount;
                            @endphp

                            @else

                            @php
                                $addedAmount = 0;
                            @endphp
                        @endif


                        {{-- Received Money --}}
                        @if($receivedAmount = \App\Statement::where('country', $item->name)->where('report_status', 'Money received')->sum('credit'))
                            @php
                                $receivedAmount = $receivedAmount;
                            @endphp

                            @else

                            @php
                                $receivedAmount = 0;
                            @endphp
                        @endif



                            
                        {{-- Money Sent --}}
                        @if($debitedAmount = \App\Statement::where('country', $item->name)->where('report_status', 'Money sent')->sum('debit'))
                                @php
                                    $debitedAmount = $debitedAmount;
                                @endphp

                            @else

                                @php
                                    $debitedAmount = 0;
                                @endphp
                        @endif

                        {{-- Withdrawal Amount --}}
                        @if($withdrawAmount = \App\Statement::where('country', $item->name)->where('report_status', 'Withdraw from wallet')->sum('debit'))
                            @php
                                $withdrawAmount = $withdrawAmount;
                            @endphp

                            @else

                            @php
                                $withdrawAmount = 0;
                            @endphp
                        @endif


                        {{-- Monthly Fee --}}
                        @if($monthlyAmount = \App\Statement::where('country', $item->name)->where('report_status', 'Monthly fee')->sum('debit'))
                            @php
                                $monthlyAmount = $monthlyAmount;
                            @endphp

                            @else

                            @php
                                $monthlyAmount = 0;
                            @endphp
                        @endif


                        {{--  Fund from Invoice  --}}

                        @if($sendInvoice = \App\Statement::where('country', $item->name)->where('action', 'Invoice')->sum('credit'))
                            @php
                                $sendInvoice = $sendInvoice;
                            @endphp

                            @else

                            @php
                                $sendInvoice = 0;
                            @endphp
                        @endif


                        {{--  Fund for Utility  --}}

                        @if($utilityFund = \App\Statement::where('country', $item->name)->where('activity', 'LIKE', '%Success: %')->sum('debit'))
                            @php
                                $utilityFund = $utilityFund;
                            @endphp

                            @else

                            @php
                                $utilityFund = 0;
                            @endphp
                        @endif

                        @php
                          //  $debits = $debitedAmount - $monthlyAmount - $withdrawAmount;
                           $credits = $addedAmount + $receivedAmount + $sendInvoice + (- $debitedAmount - $monthlyAmount - $withdrawAmount);

                          //  $totAmountExp = $credits - $debits;
                           $totAmountExp = $credits;
                        @endphp

                        <td>{{ $i++ }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ number_format($addedAmount, 2) }}</td>
                        <td>{{ number_format($receivedAmount, 2) }}</td>
                        <td>{{ number_format($debitedAmount, 2) }}</td>
                        {{-- <td>{{ number_format($monthlyAmount,2) }}</td> --}}
                        <td>{{ number_format($sendInvoice, 2) }}</td>
                        <td>{{ number_format($utilityFund, 2) }}</td>
                        <td>{{ number_format($withdrawAmount, 2) }}</td>
                        <td>{{ number_format($item->wallet_balance, 2) }}</td>

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


