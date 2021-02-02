@extends('layouts.dashboard')

@section('dashContent')


<?php use \App\Http\Controllers\User; ?>
<?php use \App\Http\Controllers\InvoicePayment; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         Customer Invoice Details
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Customer Invoice Details</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Customer Invoice Details</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

              <table class="table table-bordered table-striped">
                
                <tbody>
                  @if(count($getCustomer) > 0)

                  <center>
                   @if ($status == "error")
                    <div class="alert alert-danger">{{ $message }}</div>
                    @elseif($status == "success")
                        <div class="alert alert-success">{{ $message }}</div>
                    @endif
                </center>

                  <form action="{{ route('updateinvoice') }}" method="POST">
                    @csrf

                      <tr>
                        <td>Transaction Date</td>
                        <td class="mainText">{{ date('d/F/Y', strtotime($getCustomer[0]->transaction_date)) }}</td>
                        <td class="mainInput disp-0"><input class="form-control" type="hidden" name="id" value="{{ $getCustomer[0]->id }}"><input class="form-control" type="date" name="transaction_date" value="{{ $getCustomer[0]->transaction_date }}" required=""></td>
                      </tr>
                      <tr>
                        <td>Invoice #</td>
                        <td>{{ $getCustomer[0]->invoice_no }}</td>
                      </tr>
                      <tr>
                        <td>Payee Ref. No.</td>
                        <td class="mainText">{{ $getCustomer[0]->payee_ref_no }}</td>
                        <td class="mainInput disp-0"><input class="form-control" type="text" name="payee_ref_no" value="{{ $getCustomer[0]->payee_ref_no }}" required=""></td>
                      </tr>
                      <tr>
                        <td>Payee Name</td>
                        <td class="mainText">{{ $getCustomer[0]->name }}</td>
                        <td class="mainInput disp-0"><input class="form-control" type="text" name="name" value="{{ $getCustomer[0]->name }}" required=""></td>
                      </tr>
                      <tr>
                        <td>Transaction Ref.</td>
                        <td>{{ $getCustomer[0]->transaction_ref }}</td>
                      </tr>
                      <tr>
                        <td>Invoice Description</td>
                        <td class="mainText">{{ $getCustomer[0]->description }}</td>
                        <td class="mainInput disp-0"><textarea class="form-control" name="description" required="">{!! $getCustomer[0]->description !!}</textarea></td>
                      </tr>
                      <tr>
                        <td>Invoice Amount</td>
                        <td class="mainText">${{ number_format($getCustomer[0]->amount) }}</td>
                        <td class="mainInput disp-0"><input class="form-control" type="text" name="amount" value="{{ $getCustomer[0]->amount }}" required=""></td>
                      </tr>
                      <tr>
                        <td>Remaining Balance</td>
                        <td class="mainText">{{ $getCustomer[0]->remaining_balance }}</td>
                        <td class="mainInput disp-0"><input class="form-control" type="text" name="remaining_balance" value="{{ $getCustomer[0]->remaining_balance }}" required=""></td>
                      </tr>
                      <tr>
                        <td>Payment Due Date</td>
                        <td class="mainText">{{ date('d/F/Y', strtotime($getCustomer[0]->payment_due_date)) }}</td>
                        <td class="mainInput disp-0"><input class="form-control" type="date" name="payment_due_date" value="{{ $getCustomer[0]->payment_due_date }}" required=""></td>
                      </tr>
                      <tr>
                        <td>Payee Email</td>
                        <td class="mainText">{{ $getCustomer[0]->payee_email }}</td>
                        <td class="mainInput disp-0"><input class="form-control" type="text" name="payee_email" value="{{ $getCustomer[0]->payee_email }}" required=""></td>
                      </tr>
                      <tr>
                        <td>Service</td>
                        <td class="mainText">{{ $getCustomer[0]->service }}</td>
                        <td class="mainInput disp-0"><input class="form-control" type="text" name="service" value="{{ $getCustomer[0]->service }}" required=""></td>
                      </tr>
                      <tr>
                        <td>Accept Installmental Pay</td>
                        <td class="mainText">{{ $getCustomer[0]->installpay }}</td>
                        <td class="mainInput disp-0"><input class="form-control" type="text" name="installpay" value="{{ $getCustomer[0]->installpay }}" required="" placeholder="Yes or No"></td>
                      </tr>
                      <tr>
                        <td>Status</td>
                        <td>{{ $getCustomer[0]->status }}</td>
                      </tr>
                      <tr>
                        <td>Recurring</td>
                        <td class="mainText">{{ $getCustomer[0]->recurring }}</td>
                        <td class="mainInput disp-0"><input class="form-control" type="text" name="recurring" value="{{ $getCustomer[0]->recurring }}" required=""></td>
                      </tr>
                      <tr>
                        <td>Reminder</td>
                        <td class="mainText">{{ $getCustomer[0]->reminder }}</td>
                        <td class="mainInput disp-0"><input class="form-control" type="text" name="reminder" value="{{ $getCustomer[0]->reminder }}" required=""></td>
                      </tr>
                      <tr>
                        <td>Created Date</td>
                        <td class="mainText">{{ date('d/F/Y', strtotime($getCustomer[0]->created_at)) }}</td>
                        <td class="mainInput disp-0"><input class="form-control" type="date" name="created_at" value="{{ $getCustomer[0]->created_at }}" required=""></td>
                      </tr>

                      <div>
                        <button type="button" class="btn btn-danger" onclick="invoiceVisit('{{ $getCustomer[0]->id }}', 'delete')">Delete <img src="https://i.ya-webdesign.com/images/loading-gif-png-5.gif" class="spinnerdelete disp-0" style="width: 30px; height: 30px;"></button>

                        <button class="btn btn-default edit" type="button" onclick="invoiceVisit('{{ $getCustomer[0]->id }}', 'edit')">Edit <img src="https://i.ya-webdesign.com/images/loading-gif-png-5.gif" class="spinneredit disp-0" style="width: 30px; height: 30px;"></button>
                        <button class="btn btn-default updt disp-0" type="submit">Update <img src="https://i.ya-webdesign.com/images/loading-gif-png-5.gif" class="spinnerupdate disp-0" style="width: 30px; height: 30px;"></button>
                      </div>
                      <br><br>

                    </form>

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


