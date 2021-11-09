@extends('layouts.dashboard')

@section('dashContent')


<?php use \App\Http\Controllers\User; ?>
<?php use \App\Http\Controllers\OrganizationPay; ?>
<?php use \App\Http\Controllers\ClientInfo; ?>
<?php use \App\Http\Controllers\AnonUsers; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         Support Agents
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Support Agents</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Support Agents</h3>
              
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
                  <th>Username</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Role</th>
                  <th>Date</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    @if (count($data['activity']) > 0)
                    <?php $i = 1;?>
                        @foreach ($data['activity'] as $data)
                        <tr>
                            <td>{{ $i++ }}</td>

                            <td>{{ $data->username }}</td>
                            <td>{{ $data->firstname." ".$data->lastname }}</td>
                            <td>{{ $data->email }}</td>
                            <td>{{ $data->role }}</td>
                            <td>{{ date('d/M/Y', strtotime($data->created_at)) }}</td>
                            <td>
                                <a href="{{ route('edit support agent', $data->id) }}">Edit</a> | <form action="{{ route('delete support agent', $data->id) }}" method="post" class="disp-0" id="delSupport{{ $data->id }}">@csrf</form><a href="javascript:void(0)" onclick="delSupport('{{ $data->id }}')">Delete</a>
                            </td>
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


