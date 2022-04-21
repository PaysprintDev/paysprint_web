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
         Inflow Balance In {{ Request::get('country') }}
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Inflow Balance In {{ Request::get('country') }}</li>
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

              <h3 class="box-title">&nbsp;</h3> <br>

              <form action="{{ route('get inflow record') }}" method="POST">
                  @csrf
                  <div class="row">
                <div class="col-md-6">
                    <label for="start">Start Date</label>
                  <input type="hidden" name="country" class="form-control" id="country" value="{{ Request::get('country') }}">
                  <input type="date" name="statement_start" class="form-control" id="statement_start">
                </div>
                <div class="col-md-6">
                    <label for="end">End Date</label>
                  <input type="date" name="statement_end" class="form-control" id="statement_end">
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-md-12">
                  <button class="btn btn-primary btn-block" type="submit">Submit </button>
                </div>
              </div>
              </form>
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
                  <th>Date</th>
                  <th>Inflow</th>
                </tr>
                </thead>
                <tbody>
                    @if (count($data['getinflowbycountry']) > 0)
                    <?php $i = 1; $totalPaid = 0; ?>
                        @foreach ($data['getinflowbycountry'] as $data)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $data->name }}</td>
                            <td>{{ $data->accountType }}</td>
                            <td>{{ date('d-m-Y', strtotime($data->trans_date)) }}</td>
                            <td style="font-weight: 700;">{{ $data->currencyCode.' '.number_format($data->credit, 2) }}</td>
                        </tr>

                        @php
                                $totalPaid += $data->credit;
                            @endphp

                        @endforeach

                        

                    @else
                    <tr>
                        <td colspan="5" align="center">No record available</td>
                    </tr>
                    @endif
                </tbody>

                @isset($totalPaid)
                    <tfoot>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="font-weight: bold; color: black;">Total: </td>
                        <td style="font-weight: bold; color: green;">{{ '+'.$data->currencyCode.' '.number_format($totalPaid, 2) }}</td>

                    </tr>
                </tfoot>
                @endisset

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


