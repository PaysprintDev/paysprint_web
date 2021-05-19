@extends('layouts.dashboard')

@section('dashContent')


<?php use \App\Http\Controllers\User; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         Maintenance Fee In {{ Request::get('country') }}
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Maintenance Fee In {{ Request::get('country') }}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Maintenance Fee In {{ Request::get('country') }}</h3>
              
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
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Account Type</th>
                  <th>Amount</th>
                </tr>
                </thead>
                <tbody>
                    @if (count($data['maintenancefeebycountry']) > 0)
                    <?php $i = 1; $totalPaid = 0; $remtoPay = 0; $totalinv = 0;?>
                        @foreach ($data['maintenancefeebycountry'] as $data)
                        <tr>
                            <td>{{ $i++ }}</td>

                            @if($user = \App\User::where('ref_code', $data->ref_code)->first())
                                @php
                                    $name = $user->name;
                                    $email = $user->email;
                                    $telephone = $user->telephone;
                                    $accountType = $user->accountType;
                                @endphp

                                
                            @endif

                            <td>@if(isset($name)) {{ $name }} @else - @endif</td>
                                <td>@if(isset($email)) {{ $email }} @else - @endif</td>
                                <td>@if(isset($telephone)) {{ $telephone }} @else - @endif</td>
                                <td>@if(isset($accountType)) {{ $accountType }} @else - @endif</td>

                            
                            <td style="font-weight: 700;">{{ $data->currency.' '.number_format($data->amount, 2) }}</td>
                        </tr>

                        @php
                                $totalPaid += $data->amount;
                            @endphp

                        @endforeach

                        

                    @else
                    <tr>
                        <td colspan="6" align="center">No record available</td>
                    </tr>
                    @endif
                </tbody>

                @isset($totalPaid)
                    <tfoot>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="font-weight: bold; color: black;">Total: </td>
                        <td style="font-weight: bold; color: green;">{{ '+'.$data->currency.' '.number_format($totalPaid, 2) }}</td>

                    </tr>
                </tfoot>
                @endisset

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

