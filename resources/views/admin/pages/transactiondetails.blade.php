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
                  @if($data['transaction']->status == true)

                      <tr>
                        <td>ID</td>
                        <td class="mainText" colspan="2">{{ $data['transaction']->data->id }}</td>
                      </tr>
                      <tr>
                        <td>DOMAIN</td>
                        <td class="mainText" colspan="2">{{ $data['transaction']->data->domain }}</td>
                      </tr>
                      <tr>
                        <td>REFERENCE</td>
                        <td class="mainText" colspan="2">{{ $data['transaction']->data->reference }}</td>
                      </tr>
                      <tr>
                        <td>AMOUNT</td>
                        <td class="mainText" colspan="2">{{ $data['transaction']->data->currency.''.number_format($data['transaction']->data->amount / 100, 2) }}</td>
                      </tr>
                      <tr>
                        <td>PAID AT</td>
                        <td class="mainText" colspan="2">{{ $data['transaction']->data->paid_at }}</td>
                      </tr>
                      <tr>
                        <td>CREATED AT</td>
                        <td class="mainText" colspan="2">{{ $data['transaction']->data->created_at }}</td>
                      </tr>
                      <tr>
                        <td>CHANNEL</td>
                        <td class="mainText" colspan="2">{{ $data['transaction']->data->channel }}</td>
                      </tr>
                      <tr>
                        <td>IP ADDRESS</td>
                        <td class="mainText" colspan="2">{{ $data['transaction']->data->ip_address }}</td>
                      </tr>
                      <tr>
                        <td>META DATA</td>
                        @foreach ($data['transaction']->data->metadata->custom_fields as $customData)

                            <td class="mainText">
                                <div class="row">
                                    <div class="col-md-12">
                                        {!! strtoupper($customData->display_name).": <br>".$customData->value !!}
                                    </div>
                                </div>
                            </td>
                            
                        @endforeach
                      </tr>


                          <tr>
                            <td>REFERRER</td>
                            <td class="mainText" colspan="2">{{ $data['transaction']->data->metadata->referrer }}</td>
                          </tr>

                          <tr>
                        <td>LOG DATA</td>
                        @foreach ($data['transaction']->data->log->history as $historyData)

                            <td class="mainText">
                                <div class="row">
                                    <div class="col-md-12">
                                        {!! strtoupper($historyData->type).": <br>".$historyData->message !!}
                                    </div>
                                </div>
                            </td>
                            
                        @endforeach
                      </tr>

                          <tr>
                            <td>CARD AUTHORIZATION</td>
                            <td class="mainText" colspan="2">
                                <div class="row">
                                    <div class="col-md-12">
                                        AUTHORIZATION CODE: {{ $data['transaction']->data->authorization->authorization_code }}
                                    </div>
                                    <div class="col-md-12">
                                        BIN: {{ $data['transaction']->data->authorization->bin }}
                                    </div>
                                    <div class="col-md-12">
                                        LAST 4 DIGIT: {{ $data['transaction']->data->authorization->last4 }}
                                    </div>
                                    <div class="col-md-12">
                                        EXP. MONTH: {{ $data['transaction']->data->authorization->exp_month }}
                                    </div>
                                    <div class="col-md-12">
                                        EXP. YEAR: {{ $data['transaction']->data->authorization->exp_year }}
                                    </div>
                                    <div class="col-md-12">
                                        CHANNEL: {{ $data['transaction']->data->authorization->channel }}
                                    </div>
                                    <div class="col-md-12">
                                        COUNTRY CODE: {{ $data['transaction']->data->authorization->country_code }}
                                    </div>
                                    <div class="col-md-12">
                                        BRAND: {{ $data['transaction']->data->authorization->brand }}
                                    </div>
                                    <div class="col-md-12">
                                        ACCOUNT NAME: {{ $data['transaction']->data->authorization->account_name }}
                                    </div>
                                    <div class="col-md-12">
                                        ACCOUNT NUMBER: {{ $data['transaction']->data->authorization->receiver_bank_account_number }}
                                    </div>
                                    <div class="col-md-12">
                                        BANK NAME: {{ $data['transaction']->data->authorization->receiver_bank }}
                                    </div>
                                </div>
                            </td>
                          </tr>
                          

                      

                      <br><br>

                                

                  @else
                    <tr>
                      <td>No record found</td>
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


