@extends('layouts.dashboard')

@section('dashContent')


<?php use \App\Http\Controllers\ClientInfo; ?>
<?php use \App\Http\Controllers\User; ?>
<?php use \App\Http\Controllers\Admin; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

      <h1>
         Transaction Details
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Transaction Details</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Transaction Details</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="col-md-2 col-md-offset-10">
                <button class="btn btn-secondary btn-block bg-blue" onclick="goBack()"><i class="fas fa-chevron-left"></i> Go back</button>
            </div>


              <table class="table table-bordered table-striped">

                <tbody>


                    <tr>
                        <td>TRANSACTION ID</td>
                        <td class="mainText" colspan="2" style="font-weight: bold;">{{ $data['transaction']->transaction_id }}</td>
                      </tr>
                    <tr>
                        <td>MESSAGE</td>
                        <td class="mainText" colspan="2" style="font-weight: bold;">{{ $data['transaction']->message }}</td>
                      </tr>
                    <tr>
                        <td>ACTIVITY</td>
                        <td class="mainText" colspan="2" style="font-weight: bold;">{{ $data['transaction']->activity }}</td>
                      </tr>
                    <tr>
                        <td>GATEWAY</td>
                        <td class="mainText" colspan="2" style="font-weight: bold;">{{ $data['transaction']->gateway }}</td>
                      </tr>
                    <tr>
                        <td>COUNTRY</td>
                        <td class="mainText" colspan="2" style="font-weight: bold;">{{ $data['transaction']->country }}</td>
                      </tr>

                  @if($data['transaction']->bodydata !== null)


                  @php
                      $newData = json_decode($data['transaction']->bodydata, true);
                  @endphp


                      <tr>
                        <td>RESPONSE CODE</td>
                        <td class="mainText" colspan="2" style="font-weight: bold;">{{ $newData['responseCode'] }}</td>
                      </tr>
                      <tr>
                        <td>RESPONSE MESSAGE</td>
                        <td class="mainText" colspan="2" style="font-weight: bold;">{{ $newData['responseMessage'] }}</td>
                      </tr>

                      <tr>
                        <td>DATA AMOUNT</td>
                        <td class="mainText" colspan="2" style="font-weight: bold;">{{ $newData['data']['currency'].''.number_format($newData['data']['amount'] , 2) }}</td>
                      </tr>
                      <tr>
                        <td>PAYMENT TYPE</td>
                        <td class="mainText" colspan="2" style="font-weight: bold;">{{ $newData['data']['paymentType'] }}</td>
                      </tr>
                      <tr>
                        <td>STATUS</td>
                        <td class="mainText" colspan="2" style="font-weight: bold;">{{ $newData['data']['status'] }}</td>
                      </tr>
                      <tr>
                        <td>IS SUCCESSFUL</td>
                        <td class="mainText" colspan="2" style="font-weight: bold;">{{ $newData['data']['isSuccessful'] === true ? 'TRUE' : 'FALSE' }}</td>
                      </tr>
                      <tr>
                        <td>GATEWAY RESPONSE</td>
                        <td class="mainText" colspan="2" style="font-weight: bold;">{{ $newData['data']['gatewayResponse'] }}</td>
                      </tr>


                  @else
                    <tr>
                      <td colspan="2" style="color: red; font-weight: bold;" align="center">No gateway response retrieved for this transaction</td>
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


