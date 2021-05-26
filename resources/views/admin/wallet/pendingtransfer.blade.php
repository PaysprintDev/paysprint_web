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
         Pending Transfers
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Pending Transfers</li>
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
                  <th>Country</th>
                  <th>Total Amount</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    @if (count($data['pendingtransfer']) > 0)
                    <?php $i = 1;?>
                        @foreach ($data['pendingtransfer'] as $data)
                        <tr>
                            <td>{{ $i++ }}</td>

                            <td>{{ $data->country }}</td>

                            @if($user = \App\User::where('country', $data->country)->first())

                            @php
                                $currencyCode = $user->currencyCode;
                                $currencySymbol = $user->currencySymbol;
                            @endphp

                            @else


                            @php
                                $currencyCode = "";
                                $currencySymbol = "";
                            @endphp

                            @endif

                            @if($amount = \App\Statement::where('status', 'Pending')->where('country', $data->country)->sum('credit'))
                                <td style="font-weight: 700;">{{ $currencySymbol.' '.number_format($amount, 2) }}</td>

                                @else
                                <td style="font-weight: 700;">{{ $currencySymbol.' '.number_format(0, 2) }}</td>
                            @endif


                            <td>
                                <a type="button" href="{{ route('pending transfer by country', 'country='.$data->country) }}" class="btn btn-primary btn-block">View details</a>
                            </td>

                        </tr>
                        @endforeach

                    @else
                    <tr>
                        <td colspan="4" align="center">No record available</td>
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


