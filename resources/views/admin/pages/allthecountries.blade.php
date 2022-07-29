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
         All Countries
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">All Countries</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">All Countries</h3>

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
                  <th>Countries</th>
                  <th>Code</th>
                  <th>Gateway</th>
                  <th>Inbound</th>
                  <th>Outbound</th>
                  <th>Both IMT Enabled</th>
                  <th>Status</th>
                  <th>Action</th>
                  <th>&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                    @if (count($data['allthecountries']) > 0)
                    <?php $i = 1;?>
                        @foreach ($data['allthecountries'] as $data)
                        <tr>
                            <td>{{ $i++ }}</td>

                            <td>{{ $data->name }}</td>
                            <td>{{ $data->code }}</td>
                            <td>{{ $data->gateway }}</td>
                            <td>{{ strtoupper($data->inbound) }}</td>
                            <td>{{ strtoupper($data->outbound) }}</td>
                            <td>{{ strtoupper($data->imt) }}</td>
                            <td style="{{ ($data->approval == 1) ? "color: green;" : "color: red;" }} font-weight: bold;">{{ ($data->approval == 1) ? "Access Granted" : "Not Granted Access" }}</td>

                            <form action="{{ route('grant country') }}" method="POST" id="grantform{{ $data->id }}">
                                @csrf
                                <input type="hidden" value="{{ $data->id }}" name="country_id">

                                <td>
                                    <button type="button" class="btn {{ ($data->approval == 1) ? 'btn-danger' : 'btn-primary' }}" onclick="grantCountry('{{ $data->id }}')">{{ ($data->approval == 1) ? "Disable Access" : "Grant Access" }}</button>
                                </td>

                            </form>


                            <form action="{{ route('grant imt') }}" method="POST" id="grantimtform{{ $data->id }}">
                            @csrf
                            <input type="hidden" value="{{ $data->id }}" name="country_id">
                            <input type="hidden" value="both" name="imt_state">
                            <td>
                                <button type="button" class="btn {{ ($data->imt == "true") ? 'btn-danger' : 'btn-primary' }}" onclick="grantImt('{{ $data->id }}')">{{ ($data->imt == "true") ? "Disable IMT" : "Grant IMT" }}</button>
                            </td>

                            </form>


                        </tr>
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


