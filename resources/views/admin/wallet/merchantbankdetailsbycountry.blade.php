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
                  <th>Country</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                  
                    @if (count($data['bankdetails']) > 0)
                    <?php $i = 1;?>
                        @foreach ($data['bankdetails'] as $data)

                        @if ($data->country != null)
                            <tr>
                                  <td>{{ $i++ }}</td>

                                  <td>{{ $data->country }}</td>

                                  

                                  @if (Request::get('users') == "Merchant")
                                      <td>
                                          <a href="{{ route('merchant banking details', 'users=Merchant&country='.$data->country) }}" class="btn btn-primary" type="button">Merchant details</a>
                                      </td>
                                  @else
                                      <td>
                                          <a href="{{ route('merchant banking details', 'users=Individual&country='.$data->country) }}" class="btn btn-primary" type="button">Consumer details</a>
                                      </td>
                                  @endif

                                  
                                  
                              </tr>
                        @endif


                        @endforeach

                    @else
                    <tr>
                        <td colspan="3" align="center">No record available</td>
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


