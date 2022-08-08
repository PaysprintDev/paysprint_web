@extends('layouts.dashboard')

@section('dashContent')


<?php use \App\Http\Controllers\User; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
          All Paid User List
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active"> All Paid User List</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"> All Paid User List</h3>

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
                  <th>Account Type</th>
                  <th>Country</th>
                  <th>Amount</th>
                  <th>Duration</th>
                  <th>Expiry Date</th>
                </tr>
                </thead>
                <tbody>
                    @if (count($data['paiduserlist']) > 0)
                    <?php $i = 1;?>
                        @foreach ($data['paiduserlist'] as $item)
                        <tr>
                            @if($user = \App\User::where('ref_code', $item->userId)->first())
                                <td>{{ $i++ }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->accountType }}</td>
                                <td>{{ $user->country }}</td>
                                <td>{{ $user->currencySymbol.' '.number_format($item->amount, 2) }}</td>
                                <td>{{ $item->duration }}</td>
                                <td>{{ date('d/m/Y h:i a', strtotime($item->expire_date)) }}</td>
                            @endif


                        </tr>
                        @endforeach


                    @else
                    <tr>
                        <td colspan="7" align="center">No record available</td>
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


