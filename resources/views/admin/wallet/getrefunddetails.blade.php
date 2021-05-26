@extends('layouts.dashboard')

@section('dashContent')


<?php use \App\Http\Controllers\User; ?>
<?php use \App\Http\Controllers\Statement; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         Refund Withdrawal Request
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Refund Withdrawal Request</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Refund Withdrawal Request</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="col-md-2 col-md-offset-10">
                <button class="btn btn-secondary btn-block bg-blue" onclick="goBack()"><i class="fas fa-chevron-left"></i> Go back</button>
            </div>

              <table class="table table-bordered table-striped" id="userInvoice">
                
                <tbody>
                  @if(isset($data['getuserrefunddetails']))

                    @if($userInfo = \App\User::where('id', $data['getuserrefunddetails']->user_id)->first())
                          @php
                              $currencySymbol = $userInfo->currencySymbol;
                              $currencyCode = $userInfo->currencyCode;
                              $name = $userInfo->name;
                          @endphp
                        @endif

                      <tr>
                        <td>Customer Name</td>
                        <td class="mainText">{{ $name }}</td>
                        
                      </tr>
                      <tr>
                        <td>Transaction ID</td>
                        <td>{{ $data['getuserrefunddetails']->transaction_id }}</td>
                      </tr>


                      @if($transInfo = \App\Statement::where('reference_code', $data['getuserrefunddetails']->transaction_id)->first())
                          @php
                              $amountRef = $transInfo->debit;
                          @endphp

                      <tr>
                        <td>Amount to Refund</td>
                        <td class="mainText" style="font-weight: bold;">{{ $currencyCode.' '.number_format($amountRef, 2) }}</td>
                        
                      </tr>

                        @endif

                      <tr>
                        <td>Reason for Refund</td>
                        <td class="mainText">{{ $data['getuserrefunddetails']->reason }}</td>
                        
                      </tr>


                      <tr>
                        <td>Refund Status</td>
                        <td class="mainText" style="@if($data['getuserrefunddetails']->status == 'PROCESSED') color: green; @elseif($data['getuserrefunddetails']->status == 'DECLINED') color: red; @else color: darkorange; @endif"><strong>{{ $data['getuserrefunddetails']->status }}</strong></td>
                        
                      </tr>
                     
                      <tr>
                        <td>Date Requested</td>
                        <td class="mainText">{{ date('d/F/Y', strtotime($data['getuserrefunddetails']->created_at)) }}</td>
                      </tr>


                      <tr>
                        <td>Action</td>
                        <td class="mainText">
                            @if ($data['getuserrefunddetails']->status == "PROCESSED")

                            <button type="button" class="btn btn-success btn-block" disabled>{{ $data['getuserrefunddetails']->status }}</button>
                            
                                
                            @else

                            <button type="button" class="btn btn-success" onclick="refundMoney('{{ $data['getuserrefunddetails']->id }}', 'refund')">Refund <img src="https://i.ya-webdesign.com/images/loading-gif-png-5.gif" class="spinnerrefund{{ $data['getuserrefunddetails']->id }} disp-0" style="width: 30px; height: 30px;"></button>

                            <button class="btn btn-danger edit" type="button" onclick="refundMoney('{{ $data['getuserrefunddetails']->id }}', 'decline')">Decline <img src="https://i.ya-webdesign.com/images/loading-gif-png-5.gif" class="spinnerdecline{{ $data['getuserrefunddetails']->id }} disp-0" style="width: 30px; height: 30px;"></button>
                                
                            @endif

                            


                            

                        </td>
                      </tr>


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


