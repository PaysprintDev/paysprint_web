@extends('layouts.dashboard')

@section('dashContent')


<?php use \App\Http\Controllers\User; ?>
<?php use \App\Http\Controllers\Admin; ?>
<?php use \App\Http\Controllers\OrganizationPay; ?>
<?php use \App\Http\Controllers\ClientInfo; ?>
<?php use \App\Http\Controllers\AnonUsers; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         Platform Activity Log
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Platform Activity Log</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Platform Activity Log</h3>
              
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
                  <th>Acct. No</th>
                  <th>Name</th>
                  <th>Email/Username</th>
                  <th>Account Type</th>
                  <th>Activity</th>
                  <th>Country</th>
                  <th>Platform</th>
                  <th>Login Count</th>
                  <th>Date & Time</th>
                </tr>
                </thead>
                <tbody>
                    @if (count($data['activity']) > 0)
                    <?php $i = 1;?>
                        @foreach ($data['activity'] as $data)
                        <tr>
                            <td>{{ $i++ }}</td>

                            @if($user = \App\User::where('ref_code', $data->ref_code)->first())

                                @php
                                    $ref_code = $user->ref_code;
                                    $name = $user->name;
                                    $email = $user->email;
                                    $accountType = $user->accountType;
                                    $loginCount = $user->loginCount;
                                @endphp

                            @else

                                @if($annonUser = \App\AnonUsers::where('ref_code', $data->ref_code)->first())

                                    @php
                                        $ref_code = $annonUser->ref_code;
                                        $name = $annonUser->name;
                                        $email = $annonUser->email;
                                        $accountType = $annonUser->accountType;
                                        $loginCount = 0;
                                    @endphp

                                  @else

                                    @php
                                        $ref_code = "-";
                                        $name = "-";
                                        $email = "-";
                                        $accountType = "-";
                                        $loginCount = 0;
                                    @endphp

                                @endif

                              


                            @endif



                            <td>{{ $ref_code }}</td>
                            <td>{{ $name }}</td>
                            <td>{{ $email }}</td>
                            <td>{{ $accountType }}</td>
                            
                            <td>{!! $data->activity !!}</td>
                            <td>{{ strtoupper($data->country) }}</td>
                            <td>{{ strtoupper($data->platform) }}</td>
                            <td>{{ $loginCount }}</td>
                            <td>{{ date('d/M/Y h:i a', strtotime($data->created_at)) }}</td>
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


