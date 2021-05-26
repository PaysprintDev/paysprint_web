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
         Pending Transactions
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Pending Transactions</li>
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
                  <th>Amount</th>
                  <th>Claims</th>
                  <th>Transfer Date</th>
                </tr>
                </thead>
                <tbody>
                    @if (count($data['pendingtransferbycountry']) > 0)
                    <?php $i = 1;?>

                    @foreach($data['pendingtransferbycountry'] as $data)
                        <tr>
                            <td>{{ $i++ }}</td>

                            @if($currency = \App\User::where('country', $data->country)->first())
                                @php
                                    $currencyCode = $currency->currencyCode;
                                    $currencySymbol = $currency->currencySymbol;
                                @endphp
                            @endif

                            @if($user = \App\User::where('email', $data->user_id)->first())

                                @if (isset($user))
                                    @php
                                        $name = $user->name;
                                    @endphp
                                @else
                                    @if($anon = \App\AnonUsers::where('email', $data->user_id)->first())
                                            @php
                                                $name = $anon->name;
                                            @endphp
                                    @endif
                                @endif

                                @else

                                @php
                                    $name = "-";
                                @endphp

                            @endif

                            <td>{{ $name }}</td>

                            <td>{{ ($data->credit > 0) ? $currencySymbol.' '.number_format($data->credit, 2) : $currencySymbol.' '.number_format($data->debit, 2) }}</td>


                            <td style="font-weight: bold;">{{ ($data->credit > 0) ? "RECEIVER" : "SENDER" }}</td>

                            <td>
                                {{ date('d/M/Y', strtotime($data->trans_date)) }}
                            </td>

                            
                        </tr>
                    @endforeach

                    @else
                    <tr>
                        <td colspan="5" align="center">No record available</td>
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


