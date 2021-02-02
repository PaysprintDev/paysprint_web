@extends('layouts.dashboard')

@section('dashContent')


<?php use \App\Http\Controllers\User; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         xPAY Remitted Report
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">xPAY Remitted Report</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">xPAY Remitted Report</h3> <br>

            </div>
            <!-- /.box-header -->
            <div class="box-body">

              <table class="table table-bordered">
                
              </table>
              <br>

              <table id="example3" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>S/N</th>
                  <th>Name of Client</th>
                  <th>Payment Method</th>
                  <th>Client Email</th>
                  <th>Amount</th>
                  <th>Remittance Date</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody id="statementtab">
                    @if (count($getreport) > 0)
                    <?php $i = 1;?>
                        @foreach ($getreport as $items)
                        <tr>
                            <td>{{ $i++ }}</td>
                            
                            <td>{{ $items->client_name }}</td>
                            <td>{{ $items->card_method }}</td>
                            <td>{{ $items->client_email }}</td>
                            <td style="color: green; font-weight: bold;">${{ number_format($items->amount_paid, 2) }}</td>
                            <td>{{ date('d/F/Y', strtotime($items->created_at)) }}</td>
                            <td><button class="btn btn-primary btn-block" onclick="remitdetailsCash('{{ $items->client_id }}', '{{ $items->withdraw_id }}', '{{ $items->amount_to_withdraw }}', 'epayca')">View Detail<img src="https://i.ya-webdesign.com/images/loading-gif-png-5.gif" class="spinner{{ $items->withdraw_id }} disp-0" style="width: 30px; height: 30px;"></button></td>
                            
                        </tr>
                        @endforeach

                        

                    @else
                    <tr>
                        <td colspan="11" align="center">No record available</td>
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


