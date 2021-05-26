@extends('layouts.dashboard')

@section('dashContent')


<?php use \App\Http\Controllers\User; ?>
<?php use \App\Http\Controllers\AnonUsers; ?>
<?php use \App\Http\Controllers\Statement; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         Text-To-Transfer
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Text-To-Transfer</li>
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
                  <th>Account No.</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Account Type</th>
                  <th>Wallet Balance</th>
                  <th>Date Invited</th>
                </tr>
                </thead>
                <tbody>
                    @if (count($data['texttotransferbycountry']) > 0)
                    <?php $i = 1;?>

                    @foreach($data['texttotransferbycountry'] as $data)

                    @if($currency = \App\User::where('country', $data->country)->first())
                        @php
                            $currencyCode = $currency->currencyCode;
                            $currencySymbol = $currency->currencySymbol;
                        @endphp
                    @endif

                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $data->ref_code }}</td>
                            <td>{{ $data->name }}</td>
                            <td>{{ $data->email }}</td>
                            <td>{{ $data->telephone }}</td>
                            <td>{{ $data->accountType }}</td>
                            <td>{{ $currencySymbol.' '.number_format($data->wallet_balance, 2) }}</td>

                            <td>
                                {{ date('d/M/Y', strtotime($data->created_at)) }}
                            </td>

                            
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


