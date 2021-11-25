@extends('layouts.dashboard')

@section('dashContent')


<?php use \App\Http\Controllers\User; ?>
<?php use \App\Http\Controllers\RequestRefund; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         Refund Request
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Refund Request</li>
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
                  <th>Country</th>
                  <th>Count</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    @if (count($data['requestforrefund']) > 0)
                    <?php $i = 1;?>
                        @foreach ($data['requestforrefund'] as $data)
                        <tr>
                            <td>{{ $i++ }}</td>

                            @if($user = \App\User::where('id', $data->user_id)->first())

                              @php
                                  $currencyCode = $user->currencyCode;
                                  $name = $user->name;
                                  $currencySymbol = $user->currencySymbol;
                              @endphp

                            @else

                              @php
                                  $currencyCode = "";
                                  $currencySymbol = "";
                                  $name = "-";
                              @endphp

                            @endif




                            <td>{{ $data->country }}</td>

                            @if($transactionInfo = \App\RequestRefund::where('country', $data->country)->where('status', '!=', 'PROCESSED')->count())
                            <td>{{ $transactionInfo }}</td>

                            @else
                            <td>0</td>
                            @endif



                            <td>
                                <a type="button" href="{{ route('refund details by country aml', 'country='.$data->country) }}" class="btn btn-primary">View details</a>
                            </td>

                        </tr>
                        @endforeach

                    @else
                    <tr>
                        <td colspan="6" align="center">No record available</td>
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



