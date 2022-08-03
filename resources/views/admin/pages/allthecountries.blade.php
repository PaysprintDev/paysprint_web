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
                  <th>&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                    @if (count($data['allthecountries']) > 0)
                    <?php $i = 1;?>
                        @foreach ($data['allthecountries'] as $item)
                        <tr>
                            <td>{{ $i++ }}</td>

                            <td>{{ $item->name }}</td>
                            <td>{{ $item->code }}</td>
                            <td>
                                <span id="currId{{ $item->id }}">{{ $item->gateway }}</span>

                                <form action="{{ route('update country gateway') }}" method="POST" id="mycountrygatewayform{{ $item->id }}" class="disp-0">
                                @csrf
                                <input type="hidden" name="countryId" value="{{ $item->id }}">
                                    <select name="paymentGateway" id="paymentGateway{{ $item->id }}" class="form-control">
                                    <option value="">Select gateway</option>
                                    @if (count($data['allpaymentgateway']) > 0)
                                        @foreach ($data['allpaymentgateway'] as $paymentGateway)
                                            <option value="{{ $paymentGateway->name }}"  {{ ($item->gateway === $paymentGateway->name) ? 'selected="selected"' : '' }}>{{ $paymentGateway->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                </form>

                            </td>
                            <td>{{ strtoupper($item->inbound) }}</td>
                            <td>{{ strtoupper($item->outbound) }}</td>
                            <td>{{ strtoupper($item->imt) }}</td>
                            <td style="{{ ($item->approval == 1) ? "color: green;" : "color: red;" }} font-weight: bold;">{{ ($item->approval == 1) ? "Access Granted" : "Not Granted Access" }}</td>

                            <form action="{{ route('grant country') }}" method="POST" id="grantform{{ $item->id }}">
                                @csrf
                                <input type="hidden" value="{{ $item->id }}" name="country_id">

                                <td>
                                    <button type="button" class="btn {{ ($item->approval == 1) ? 'btn-danger' : 'btn-primary' }}" onclick="grantCountry('{{ $item->id }}')">{{ ($item->approval == 1) ? "Disable Access" : "Grant Access" }}</button>
                                </td>

                            </form>


                            <form action="{{ route('grant imt') }}" method="POST" id="grantimtform{{ $item->id }}">
                            @csrf
                            <input type="hidden" value="{{ $item->id }}" name="country_id">
                            <input type="hidden" value="" name="imt_state" id="imt_state{{ $item->id }}">
                            <td>
                                <button type="button" class="btn {{ ($item->imt == "true" || $item->inbound == "true" || $item->outbound == "true") ? 'btn-danger' : 'btn-primary' }}" onclick="grantImt('{{ $item->id }}')">{{ ($item->imt == "true" || $item->inbound == "true" || $item->outbound == "true") ? "Disable IMT" : "Grant IMT" }}</button>
                            </td>

                            </form>

                            <td>
                                <button class="btn btn-success" onclick="changeGateway('{{ $item->id }}')" id="myBtn{{ $item->id }}">Edit Gateway</button>
                            </td>


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


