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
        Wallet Credit Report
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Wallet Credit Report</li>
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
            {!! session('msg') !!}


            <!--report table-->
            <div class="container-fluid">
                <table class="table table-striped table-responsiveness" id="promousers">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Country</th>
                            <th>Total Amount Spent</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php
                        $counter=1;
                        // $total = 0;
                    @endphp
                    @if (isset($data['report']))
                    @foreach ( $data['report'] as $promoreport )
                    {{-- @foreach ( $data['total'] as $totalsum ) --}}
                        {{-- @php
                            $total += $promoreport->wallet_credit_amount;
                        @endphp --}}

                        @if($code= \App\AllCountries::where('name', $promoreport->country)->first())
                          
                       

                        <tr>
                            <td>{{ $counter++}}</td>
                            <td>{{ $promoreport->country}}</td>
                            <td>{{ $code->currencyCode.' '.number_format($data['total'][$promoreport->country], 2)}}</td>
                            <td><a class="btn btn-primary" href="{{route('view report', 'country='.$promoreport->country.'&start_date=null&end_date=null&topup_type=null')}}">View Report</a></td>
                        </tr>
                        @endif
                     {{-- @endforeach --}}
                    @endforeach
                    @endif
                    <!-- modal -->
                    <!-- Button trigger modal -->

                  
  
                    </tbody>
                </table>
            </div>
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


