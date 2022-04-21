@extends('layouts.dashboard')

@section('dashContent')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Pricing Set Up
        <small>Cost of Pulling and Pushing</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Pricing Set Up</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        
        <div class="box-body">
          
                <div class="box-body">
                    
                    <table class="table table-bordered table-striped">
                        <tbody>

                            <tr>
                                <td colspan="3" align="right">
                                    <a href="{{ route('edit pricing', 'country='.$data['countryprice']->country) }}" class="btn btn-primary" type="button">Edit</a>
                                </td>
                                
                            </tr>

                            <tr>
                                <td colspan="3" style="color: navy;">
                                    <h3 style="font-weight: bold;">{{ $data['countryprice']->country }}</h3>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="3">
                                    <div class="form-group has-info">
                                        <label class="control-label" for="inputSuccess"> Pricing Setup for Personal/Business & Merchant (including Charity)</label>
                                    </div>
                                </td>
                            </tr
                            
                            >
                            <tr>
                                <td>
                                    <div class="form-group has-info">
                                        <label class="control-label" for="inputSuccess">Structure</label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group has-info">
                                        <label class="control-label" for="inputSuccess">Fixed</label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group has-info">
                                        <label class="control-label" for="inputSuccess">Variable</label>
                                    </div>
                                </td>
                            </tr>




                            <tr>
                                <div class="form-group has-info">
                                <td><label class="control-label" for="inputSuccess" style="font-weight: normal;"> Add Money To Wallet</label></td>
                                <td>
                                    
                                    {{ $data['countryprice']->user_add_money_fixed }}
                                </td>
                                <td>
                                    
                                    {{ $data['countryprice']->user_add_money_variable }}
                                </td>
                                </div>
                            </tr>
                            <tr>
                                <td colspan="3">&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <div class="form-group has-info">
                                        <label class="control-label" for="inputSuccess"> Send Money: (Both PS User & Non-PS User)</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <div class="form-group has-info">
                                <td><label class="control-label" for="inputSuccess" style="font-weight: normal;"> Local-to-Local</label></td>
                                <td colspan="2">
                                    {{ $data['countryprice']->user_send_money_local }}
                                </td>
                                
                                </div>
                            </tr>
                            <tr>
                                <div class="form-group has-info">
                                <td><label class="control-label" for="inputSuccess" style="font-weight: normal;"> Local-to-International (for Currency Conversion)</label></td>
                                <td colspan="2">
                                    {{ $data['countryprice']->user_send_money_international }}
                                </td>
                                
                                </div>
                            </tr>



                             <tr>
                                <td colspan="3">&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <div class="form-group has-info">
                                        <label class="control-label" for="inputSuccess"> Receive Money: (Both PS User & Non-PS User)</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <div class="form-group has-info">
                                <td><label class="control-label" for="inputSuccess" style="font-weight: normal;"> Local-to-Local</label></td>
                                <td colspan="2">
                                    
                                    {{ $data['countryprice']->user_receive_money_local }}
                                </td>
                                
                                </div>
                            </tr>
                            <tr>
                                <div class="form-group has-info">
                                <td><label class="control-label" for="inputSuccess" style="font-weight: normal;"> Local-to-International (for Currency Conversion)</label></td>
                                <td colspan="2">
                                    
                                    {{ $data['countryprice']->user_receive_money_international }}

                                </td>
                                
                                </div>
                            </tr>



                             <tr>
                                <td colspan="3">&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <div class="form-group has-info">
                                        <label class="control-label" for="inputSuccess"> Pay Invoice (Both PS User & Non-PS User)</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <div class="form-group has-info">
                                <td><label class="control-label" for="inputSuccess" style="font-weight: normal;"> Local-to-Local</label></td>
                                <td colspan="2">
                                    
                                    {{ $data['countryprice']->user_pay_invoice_local }}
                                </td>
                                
                                </div>
                            </tr>
                            <tr>
                                <div class="form-group has-info">
                                <td><label class="control-label" for="inputSuccess" style="font-weight: normal;"> Local-to-International (for Currency Conversion)</label></td>
                                <td colspan="2">
                                    {{ $data['countryprice']->user_pay_invoice_international }}
                                </td>
                                
                                </div>
                            </tr>


                             <tr>
                                <td colspan="3">&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <div class="form-group has-info">
                                        <label class="control-label" for="inputSuccess"> Request for Refund to Wallet</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <div class="form-group has-info">
                                <td><label class="control-label" for="inputSuccess" style="font-weight: normal;"> Local-to-Local</label></td>
                                <td colspan="2">
                                    
                                    {{ $data['countryprice']->user_refund_money_local }}
                                </td>
                                
                                </div>
                            </tr>
                            <tr>
                                <div class="form-group has-info">
                                <td><label class="control-label" for="inputSuccess" style="font-weight: normal;"> Local-to-International (for Currency Conversion)</label></td>
                                <td colspan="2">
                                    
                                    {{ $data['countryprice']->user_refund_money_international }}
                                </td>
                                
                                </div>
                            </tr>

                             <tr>
                                <td colspan="3">&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <div class="form-group has-info">
                                        <label class="control-label" for="inputSuccess"> Request for Withdrawal</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <div class="form-group has-info">
                                <td><label class="control-label" for="inputSuccess" style="font-weight: normal;"> To Prepaid Card</label></td>
                                <td>
                                   
                                    {{ $data['countryprice']->user_prepaid_withdrawal_fixed }}
                                </td>
                                <td>
                                    
                                    
                                </td>
                                
                                </div>
                            </tr>
                            <tr>
                                <div class="form-group has-info">
                                <td><label class="control-label" for="inputSuccess" style="font-weight: normal;"> To Credit Card</label></td>
                                <td>
                                    
                                    {{ $data['countryprice']->user_credit_withdrawal_fixed }}
                                </td>
                                <td>
                                    {{ $data['countryprice']->user_credit_withdrawal_variable }}
                                </td>
                                
                                </div>
                            </tr>
                            <tr>
                                <div class="form-group has-info">
                                <td><label class="control-label" for="inputSuccess" style="font-weight: normal;"> To Bank Account</label></td>
                                <td>
                                    
                                    {{ $data['countryprice']->user_bank_withdrawal_fixed }}
                                </td>
                                <td>
                                    
                                    {{ $data['countryprice']->user_bank_withdrawal_variable }}
                                </td>
                                
                                </div>
                            </tr>
                            <tr>
                                <div class="form-group has-info">
                                <td><label class="control-label" for="inputSuccess" style="font-weight: normal;"> To Debit VISA/Mastercard</label></td>
                                <td>
                                    
                                    {{ $data['countryprice']->user_debit_withdrawal_fixed }}
                                </td>
                                <td>
                                    
                                    {{ $data['countryprice']->user_debit_withdrawal_variable }}
                                </td>
                                
                                </div>
                            </tr>
                            <tr>
                                <div class="form-group has-info">
                                <td><label class="control-label" for="inputSuccess" style="font-weight: normal;"> Monthly Maintenance Fee</label></td>
                                <td colspan="2">
                                    {{ $data['countryprice']->maintenance_fee }}
                                </td>
                                
                                
                                </div>
                            </tr>
                            <tr>
                                <div class="form-group has-info">
                                <td><label class="control-label" for="inputSuccess" style="font-weight: normal;"> Minimum Wallet Balance</label></td>
                                <td colspan="2">
                                    {{ $data['countryprice']->minimum_wallet_balance }}
                                </td>
                                
                                
                                </div>
                            </tr>


                             <tr>
                                <td colspan="3">&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <div class="form-group has-info">
                                        <label class="control-label" for="inputSuccess"> Withdrawal Limits</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <div class="form-group has-info">
                                <td><label class="control-label" for="inputSuccess" style="font-weight: normal;"> Per Transaction (Personal Account)</label></td>
                                <td colspan="2">
                                    
                                    {{ $data['countryprice']->withdrawal_per_transaction }}
                                </td>
                                
                                </div>
                            </tr>
                            <tr>
                                <div class="form-group has-info">
                                <td><label class="control-label" for="inputSuccess" style="font-weight: normal;"> Per Day (Personal Account)</label></td>
                                <td colspan="2">
                                    {{ $data['countryprice']->withdrawal_per_day }}
                                </td>
                                
                                </div>
                            </tr>
                            <tr>
                                <div class="form-group has-info">
                                <td><label class="control-label" for="inputSuccess" style="font-weight: normal;"> Per Week (Personal Account)</label></td>
                                <td colspan="2">
                                    
                                    {{ $data['countryprice']->withdrawal_per_week }}
                                </td>
                                
                                </div>
                            </tr>
                            <tr>
                                <div class="form-group has-info">
                                <td><label class="control-label" for="inputSuccess" style="font-weight: normal;"> Per Month (Personal Account)</label></td>
                                <td colspan="2">
                                    {{ $data['countryprice']->withdrawal_per_month }}
                                </td>
                                
                                </div>
                            </tr>
                            <tr>
                                <div class="form-group has-info">
                                <td><label class="control-label" for="inputSuccess" style="font-weight: normal;"> Per Transaction (Merchant Account)</label></td>
                                <td colspan="2">
                                    {{ $data['countryprice']->merchant_withdrawal_per_transaction }}
                                </td>
                                
                                </div>
                            </tr>
                            <tr>
                                <div class="form-group has-info">
                                <td><label class="control-label" for="inputSuccess" style="font-weight: normal;"> Per Day (Merchant Account)</label></td>
                                <td colspan="2">
                                    
                                    {{ $data['countryprice']->merchant_withdrawal_per_day }}
                                </td>
                                
                                </div>
                            </tr>
                            <tr>
                                <div class="form-group has-info">
                                <td><label class="control-label" for="inputSuccess" style="font-weight: normal;"> Per Week (Merchant Account)</label></td>
                                <td colspan="2">
                                    
                                    {{ $data['countryprice']->merchant_withdrawal_per_week }}
                                </td>
                                
                                </div>
                            </tr>
                            <tr>
                                <div class="form-group has-info">
                                <td><label class="control-label" for="inputSuccess" style="font-weight: normal;"> Per Month (Merchant Account)</label></td>
                                <td colspan="2">
                                    
                                    {{ $data['countryprice']->merchant_withdrawal_per_month }}
                                </td>
                                
                                </div>
                            </tr>


                            <tr>
                                <td colspan="3">
                                    <a href="{{ route('edit pricing', 'country='.$data['countryprice']->country) }}" class="btn btn-primary btn-block" type="button">Edit</a>
                                </td>
                                
                            </tr>
                            
                            




                        </tbody>
                    </table>


                </div>
                <!-- /.box-body -->


        </div>
        <!-- /.box-body -->
        
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection