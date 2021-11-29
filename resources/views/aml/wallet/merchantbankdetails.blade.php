@extends('layouts.dashboard')

@section('dashContent')


<?php use \App\Http\Controllers\User; ?>
<?php use \App\Http\Controllers\BankWithdrawal; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         Bank Details
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Bank Details</li>
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
                  <th>Business Name</th>
                  <th>Name</th>
                  <th>Bank Name</th>
                  <th>Transit No.</th>
                  <th>Branch Code</th>
                  <th>Account Name</th>
                  <th>Account Number</th>
                  <th>Date Created</th>
                </tr>
                </thead>
                <tbody>
                    @if (count($data['bankdetails']) > 0)
                    <?php $i = 1;?>
                        @foreach ($data['bankdetails'] as $data)


                        @if($user = \App\User::where('id', $data->user_id)->first())


                            @if ($user->accountType == Request::get('users'))
                                
                                <tr>
                                    <td>{{ $i++ }}</td>

                                    <td>{{ $user->businessname }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $data->bankName }}</td>
                                    <td>{{ $data->transitNumber }}</td>
                                    <td>{{ $data->branchCode }}</td>
                                    <td>{{ $data->accountName }}</td>
                                    <td>{{ $data->accountNumber }}</td>
                                    <td>{{ date('d/m/Y', strtotime($data->created_at)) }}</td>

                                </tr>
                            @endif

                        @endif
                        @endforeach

                    @else
                    <tr>
                        <td colspan="9" align="center">No record available</td>
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


