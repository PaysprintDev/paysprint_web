@extends('layouts.dashboard')

@section('dashContent')


<?php use \App\Http\Controllers\User; ?>
<?php use \App\Http\Controllers\Statement; ?>
<?php use \App\Http\Controllers\AllCountries; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         Currency FX Report
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Currency FX Report</li>
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

              <form action="{{ route('paysprint fx report') }}" method="GET">
                  @csrf
            <div class="row">

                <div class="col-md-12">
                    <label for="start">Select Month</label>
                  <select class="form-control" id="month" name="month">
                    <option value="01" {{ Request::get('month') == '01' ? 'selected' : '' }}>January</option>
                    <option value="02" {{ Request::get('month') == '02' ? 'selected' : '' }}>February</option>
                    <option value="03" {{ Request::get('month') == '03' ? 'selected' : '' }}>March</option>
                    <option value="04" {{ Request::get('month') == '04' ? 'selected' : '' }}>April</option>
                    <option value="05" {{ Request::get('month') == '05' ? 'selected' : '' }}>May</option>
                    <option value="06" {{ Request::get('month') == '06' ? 'selected' : '' }}>June</option>
                    <option value="07" {{ Request::get('month') == '07' ? 'selected' : '' }}>July</option>
                    <option value="08" {{ Request::get('month') == '08' ? 'selected' : '' }}>August</option>
                    <option value="09" {{ Request::get('month') == '09' ? 'selected' : '' }}>September</option>
                    <option value="10" {{ Request::get('month') == '10' ? 'selected' : '' }}>October</option>
                    <option value="11" {{ Request::get('month') == '11' ? 'selected' : '' }}>November</option>
                    <option value="12" {{ Request::get('month') == '12' ? 'selected' : '' }}>December</option>
                  </select>
                </div>

            </div>
              <br>
              <div class="row">
                <div class="col-md-12">
                  <button class="btn btn-primary btn-block" type="submit">Submit </button>
                </div>
              </div>
              </form>
            </div>
            <br>
            <!-- /.box-header -->

            <div class="box-body table table-responsive">

                <h4>Currency Daily Summary Table</h4>

                <table class="table table-bordered table-striped" id="example3">
                    <thead>
                    <tr>
                        <th>Period</th>
                        <th>Currency</th>
                        <th>Send (Supply)</th>
                        <th>Receive (Demand)</th>
                        <th>Balance</th>
                        <th>Cum. Balance</th>
                        <th>Trading Balance (%)</th>
                        <th>Trading Balance (%) Cum.</th>
                        <th>Adj. Buy Rate</th>
                        <th>Adj. Sell Rate</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                    @if (count($data['statement']) > 0)

                    @foreach ($data['statement'] as $item)

                    @if ($item->country != null)

                    @if ($countryRec = \App\AllCountries::where('name', $item->country)->first())
                        @php
                            $currencyCode = $countryRec->currencyCode;
                        @endphp
                    @endif

                    {{-- Statement Record for Today --}}

                    @if($moneyReceived = \App\Statement::where('country', $item->country)->where('action', "Wallet credit")->whereMonth('created_at', Request::get('month'))->sum('credit'))

                            @php
                                $moneyReceived = $moneyReceived;
                            @endphp

                            @else

                            @php
                                $moneyReceived = 0;
                            @endphp
                        @endif


                        @if($withdrawMoney = \App\Statement::where('country', $item->country)->where('action', "Wallet debit")->whereMonth('created_at', Request::get('month'))->sum('debit'))
                            @php
                                $withdrawMoney = $withdrawMoney;
                            @endphp

                            @else

                            @php
                                $withdrawMoney = 0;
                            @endphp
                        @endif


                        @php
                            $sendSupply = $moneyReceived;
                            $receiveDemand = $withdrawMoney;
                            $balance = $sendSupply - $receiveDemand;

                            if($sendSupply == 0 || $balance == 0){
                                $tradingBalance = 0;
                            }
                            else{
                                $tradingBalance = $sendSupply / $balance;
                            }

                        @endphp

                    <tr>
                        <td>{{ date('m/Y', strtotime($item->created_at)).' - '.date('m/Y') }}</td>
                        <td>{{ $item->country.' ('.$currencyCode.')' }}</td>
                        <td>{{ number_format($sendSupply, 2) }}</td>
                        <td>{{ number_format($receiveDemand, 2) }}</td>
                        <td>{{ number_format($balance, 2) }}</td>
                        <td>{{ number_format($balance, 2) }}</td>
                        <td>{{ number_format($tradingBalance, 2) }}%</td>
                        <td>{{ number_format($tradingBalance, 2) }}%</td>
                        <td>35%</td>
                        <td>65%</td>
                        <td>
                            <a type="button" class="btn btn-primary" href="{{ route('fx report by country', 'country='.$item->country.'&month='.Request::get('month').'&currency='.$currencyCode) }}">View details</a>
                        </td>
                    </tr>

                    @endif




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


