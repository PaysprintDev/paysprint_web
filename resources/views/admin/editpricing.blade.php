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
          
            {{-- Provide Form --}}
            <form role="form" action="{{ route('create pricing setup') }}" method="POST">
                @csrf
                <div class="box-body">
                    
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <td colspan="3">
                                    <div class="form-group has-success">
                                        <label class="control-label" for="inputSuccess"> Country</label>
                                        <select name="country" id="country" class="form-control" required>
                                            <option value="{{ $data['countryprice']->country }}" selected>{{ $data['countryprice']->country }}</option>
                                        </select>
                                    </div>
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
                                    <input type="text" class="form-control" name="user_add_money_fixed" id="user_add_money_fixed" value="{{ $data['countryprice']->user_add_money_fixed }}" required>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="user_add_money_variable" id="user_add_money_variable" value="{{ $data['countryprice']->user_add_money_variable }}" required>
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
                                    <input type="text" class="form-control" name="user_send_money_local" id="user_send_money_local" value="{{ $data['countryprice']->user_send_money_local }}" required>
                                </td>
                                
                                </div>
                            </tr>
                            <tr>
                                <div class="form-group has-info">
                                <td><label class="control-label" for="inputSuccess" style="font-weight: normal;"> Local-to-International (for Currency Conversion)</label></td>
                                <td colspan="2">
                                    <input type="text" class="form-control" name="user_send_money_international" id="user_send_money_international" value="{{ $data['countryprice']->user_send_money_international }}" required>
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
                                    <input type="text" class="form-control" name="user_receive_money_local" id="user_receive_money_local" value="{{ $data['countryprice']->user_receive_money_local }}" required>
                                </td>
                                
                                </div>
                            </tr>
                            <tr>
                                <div class="form-group has-info">
                                <td><label class="control-label" for="inputSuccess" style="font-weight: normal;"> Local-to-International (for Currency Conversion)</label></td>
                                <td colspan="2">
                                    <input type="text" class="form-control" name="user_receive_money_international" id="user_receive_money_international" value="{{ $data['countryprice']->user_receive_money_international }}" required>
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
                                    <input type="text" class="form-control" name="user_pay_invoice_local" id="user_pay_invoice_local" value="{{ $data['countryprice']->user_pay_invoice_local }}" required>
                                </td>
                                
                                </div>
                            </tr>
                            <tr>
                                <div class="form-group has-info">
                                <td><label class="control-label" for="inputSuccess" style="font-weight: normal;"> Local-to-International (for Currency Conversion)</label></td>
                                <td colspan="2">
                                    <input type="text" class="form-control" name="user_pay_invoice_international" id="user_pay_invoice_international" value="{{ $data['countryprice']->user_pay_invoice_international }}" required>
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
                                    <input type="text" class="form-control" name="user_refund_money_local" id="user_refund_money_local" value="{{ $data['countryprice']->user_refund_money_local }}" required>
                                </td>
                                
                                </div>
                            </tr>
                            <tr>
                                <div class="form-group has-info">
                                <td><label class="control-label" for="inputSuccess" style="font-weight: normal;"> Local-to-International (for Currency Conversion)</label></td>
                                <td colspan="2">
                                    <input type="text" class="form-control" name="user_refund_money_international" id="user_refund_money_international" value="{{ $data['countryprice']->user_refund_money_international }}" required>
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
                                    <input type="text" class="form-control" name="user_prepaid_withdrawal_fixed" id="user_prepaid_withdrawal_fixed" value="{{ $data['countryprice']->user_prepaid_withdrawal_fixed }}" required>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="user_prepaid_withdrawal_variable" id="user_prepaid_withdrawal_variable" value="{{ $data['countryprice']->user_prepaid_withdrawal_variable }}" required>
                                </td>
                                
                                </div>
                            </tr>
                            <tr>
                                <div class="form-group has-info">
                                <td><label class="control-label" for="inputSuccess" style="font-weight: normal;"> To Credit Card</label></td>
                                <td>
                                    <input type="text" class="form-control" name="user_credit_withdrawal_fixed" id="user_credit_withdrawal_fixed" value="{{ $data['countryprice']->user_credit_withdrawal_fixed }}" required>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="user_credit_withdrawal_variable" id="user_credit_withdrawal_variable" value="{{ $data['countryprice']->user_credit_withdrawal_variable }}" required>
                                </td>
                                
                                </div>
                            </tr>
                            <tr>
                                <div class="form-group has-info">
                                <td><label class="control-label" for="inputSuccess" style="font-weight: normal;"> To Bank Account</label></td>
                                <td>
                                    <input type="text" class="form-control" name="user_bank_withdrawal_fixed" id="user_bank_withdrawal_fixed" value="{{ $data['countryprice']->user_bank_withdrawal_fixed }}" required>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="user_bank_withdrawal_variable" id="user_bank_withdrawal_variable" value="{{ $data['countryprice']->user_bank_withdrawal_variable }}" required>
                                </td>
                                
                                </div>
                            </tr>
                            <tr>
                                <div class="form-group has-info">
                                <td><label class="control-label" for="inputSuccess" style="font-weight: normal;"> To Debit VISA/Mastercard</label></td>
                                <td>
                                    <input type="text" class="form-control" name="user_debit_withdrawal_fixed" id="user_debit_withdrawal_fixed" value="{{ $data['countryprice']->user_debit_withdrawal_fixed }}" required>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="user_debit_withdrawal_variable" id="user_debit_withdrawal_variable" value="{{ $data['countryprice']->user_debit_withdrawal_variable }}" required>
                                </td>
                                
                                </div>
                            </tr>
                            <tr>
                                <div class="form-group has-info">
                                <td><label class="control-label" for="inputSuccess" style="font-weight: normal;"> Monthly Maintenance Fee</label></td>
                                <td colspan="2">
                                    <input type="text" class="form-control" name="maintenance_fee" id="maintenance_fee" value="{{ $data['countryprice']->maintenance_fee }}" required>
                                </td>
                                
                                
                                </div>
                            </tr>
                            <tr>
                                <div class="form-group has-info">
                                <td><label class="control-label" for="inputSuccess" style="font-weight: normal;"> Minimum Wallet Balance</label></td>
                                <td colspan="2">
                                    <input type="text" class="form-control" name="minimum_wallet_balance" id="minimum_wallet_balance" value="{{ $data['countryprice']->minimum_wallet_balance }}" required>
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
                                    <input type="text" class="form-control" name="withdrawal_per_transaction" id="withdrawal_per_transaction" value="{{ $data['countryprice']->withdrawal_per_transaction }}" required>
                                </td>
                                
                                </div>
                            </tr>
                            <tr>
                                <div class="form-group has-info">
                                <td><label class="control-label" for="inputSuccess" style="font-weight: normal;"> Per Day (Personal Account)</label></td>
                                <td colspan="2">
                                    <input type="text" class="form-control" name="withdrawal_per_day" id="withdrawal_per_day" value="{{ $data['countryprice']->withdrawal_per_day }}" required>
                                </td>
                                
                                </div>
                            </tr>
                            <tr>
                                <div class="form-group has-info">
                                <td><label class="control-label" for="inputSuccess" style="font-weight: normal;"> Per Week (Personal Account)</label></td>
                                <td colspan="2">
                                    <input type="text" class="form-control" name="withdrawal_per_week" id="withdrawal_per_week" value="{{ $data['countryprice']->withdrawal_per_week }}" required>
                                </td>
                                
                                </div>
                            </tr>
                            <tr>
                                <div class="form-group has-info">
                                <td><label class="control-label" for="inputSuccess" style="font-weight: normal;"> Per Month (Personal Account)</label></td>
                                <td colspan="2">
                                    <input type="text" class="form-control" name="withdrawal_per_month" id="withdrawal_per_month" value="{{ $data['countryprice']->withdrawal_per_month }}" required>
                                </td>
                                
                                </div>
                            </tr>
                            <tr>
                                <div class="form-group has-info">
                                <td><label class="control-label" for="inputSuccess" style="font-weight: normal;"> Per Transaction (Merchant Account)</label></td>
                                <td colspan="2">
                                    <input type="text" class="form-control" name="merchant_withdrawal_per_transaction" id="merchant_withdrawal_per_transaction" value="{{ $data['countryprice']->merchant_withdrawal_per_transaction }}" required>
                                </td>
                                
                                </div>
                            </tr>
                            <tr>
                                <div class="form-group has-info">
                                <td><label class="control-label" for="inputSuccess" style="font-weight: normal;"> Per Day (Merchant Account)</label></td>
                                <td colspan="2">
                                    <input type="text" class="form-control" name="merchant_withdrawal_per_day" id="merchant_withdrawal_per_day" value="{{ $data['countryprice']->merchant_withdrawal_per_day }}" required>
                                </td>
                                
                                </div>
                            </tr>
                            <tr>
                                <div class="form-group has-info">
                                <td><label class="control-label" for="inputSuccess" style="font-weight: normal;"> Per Week (Merchant Account)</label></td>
                                <td colspan="2">
                                    <input type="text" class="form-control" name="merchant_withdrawal_per_week" id="merchant_withdrawal_per_week" value="{{ $data['countryprice']->merchant_withdrawal_per_week }}" required>
                                </td>
                                
                                </div>
                            </tr>
                            <tr>
                                <div class="form-group has-info">
                                <td><label class="control-label" for="inputSuccess" style="font-weight: normal;"> Per Month (Merchant Account)</label></td>
                                <td colspan="2">
                                    <input type="text" class="form-control" name="merchant_withdrawal_per_month" id="merchant_withdrawal_per_month" value="{{ $data['countryprice']->merchant_withdrawal_per_month }}" required>
                                </td>
                                
                                </div>
                            </tr>


                            <tr>
                                <div class="form-group has-info">
                                
                                <td colspan="3">
                                    <button class="btn btn-primary btn-block" type="submit">Update and Save</button>
                                </td>
                                
                                </div>
                            </tr>
                            
                            




                        </tbody>
                    </table>


                </div>
                <!-- /.box-body -->
              </form>


        </div>
        <!-- /.box-body -->
        
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection