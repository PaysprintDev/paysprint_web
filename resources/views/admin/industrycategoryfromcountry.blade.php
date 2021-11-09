@extends('layouts.dashboard')

@section('dashContent')


<?php use \App\Http\Controllers\User; ?>
<?php use \App\Http\Controllers\OrganizationPay; ?>
<?php use \App\Http\Controllers\ClientInfo; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         All Industry In {{ Request::get('country') }}
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">All Industry In {{ Request::get('country') }}</li>
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
                  <th>Ref. No</th>
                  <th>Business Name</th>
                  <th>Address</th>
                  <th>Type of Service</th>
                  <th>Industry</th>
                  <th>Email</th>
                  <th>Phone Number</th>
                </tr>
                </thead>
                <tbody>
                    @if (count($data['industryCategory']) > 0)
                    <?php $i = 1;?>
                        @foreach ($data['industryCategory'] as $data)
                        <tr>
                            <td>{{ $i++ }}</td>
                            
                            <td>{{ $data->user_id }}</td>
                            <td>{{ $data->business_name }}</td>
                            <td>{{ $data->address }}</td>
                            <td>{{ $data->type_of_service }}</td>
                            <td>{{ $data->industry }}</td>
                            <td>{{ $data->email }}</td>
                            <td>{{ $data->telephone }}</td>
                            
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


