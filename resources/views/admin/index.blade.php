@extends('layouts.dashboard')


@section('dashContent')

<?php use \App\Http\Controllers\ClientInfo; ?>
<?php use \App\Http\Controllers\User; ?>
<?php use \App\Http\Controllers\InvoicePayment; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard

        @if (session('role') != "Super")

          @if($userInfo = \App\User::where('ref_code', session('user_id'))->first())

            @if(isset($userInfo))

              <h4 style="color: green; font-weight: bold;">Account Number: {{ $userInfo->ref_code }}</h4>

            @else
              <small>Control panel</small>
            @endif

          @endif
        @endif
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">

      @if(session('role') == "Super")
      <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{ count($invoiceImport) }}</h3>

              <p>Invoice Upload</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            {{-- <a href="#" class="small-box-footer">View details <i class="fa fa-arrow-circle-right"></i></a> --}}
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>0</h3>

              <p>Invoice Payment</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            {{-- <a href="#" class="small-box-footer">View details <i class="fa fa-arrow-circle-right"></i></a> --}}
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>{{ count($allusers) }}</h3>

              <p>All Users</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ route('allusers') }}" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>@if(count($otherPays) > 0) {{ count($otherPays) }} @else 0 @endif</h3>

              <p>Other Payments</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="{{ route('Otherpay') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      @else
      <div class="col-lg-6 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-warning">
            <div class="inner">
              <h3>{{ $getUserDetail->currencySymbol.number_format($getUserDetail->wallet_balance, 2) }}</h3>

              <p>Wallet Balance</p>
            </div>
            <div class="icon">
              <i class="ion ion-card"></i>
            </div>
            {{-- <a href="#" class="small-box-footer">View details <i class="fa fa-arrow-circle-right"></i></a> --}}
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6 disp-0">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>0</h3>

              <p>Paid Invoices</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            {{-- <a href="#" class="small-box-footer">View details <i class="fa fa-arrow-circle-right"></i></a> --}}
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-6 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">
            <h3>{{ $getUserDetail->number_of_withdrawals }}</h3>

              <p>Total Withdrawal</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
        {{--  <a href="{{ route('Otherpay') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>  --}}
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-12 col-xs-12">
          <!-- small box -->
          <div class="small-box">
              <div class="col-md-4"><a type="button" href="{{ route('merchant credit card', $getUserDetail->id) }}" class="btn btn-danger btn-block">Add a new Credit Card <i class="fa fa-plus"></i></a></div>
              <div class="col-md-4"><a type="button" href="{{ route('merchant prepaid card', $getUserDetail->id) }}" class="btn btn-info btn-block">Add a new Prepaid Card <i class="fa fa-plus"></i></a></div>
              <div class="col-md-4"><a type="button" href="{{ route('merchant bank account', $getUserDetail->id) }}" class="btn btn-success btn-block">Add a new Bank Account <i class="fa fa-plus"></i></a></div>
          </div>
          <br>
        <br>
        </div>
        
        <!-- ./col -->
      @endif

      </div>
      <!-- /.row -->
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-12 connectedSortable">


          <!-- TO DO List -->
          <div class="box box-primary">
            <div class="box-header">
              <i class="ion ion-clipboard"></i>

              <h3 class="box-title">Import Invoice List</h3>

            </div>
            <!-- /.box-header -->
            <div class="box-body table table-responsive">
               <table id="example4" class="table table-bordered table-hover">
                   {{-- @if(session('role') != "Super")<caption><button type="button" class="btn btn-success" style="float:right" id="recurAll" onclick="recurring('All', {{ session('user_id') }})">Recur All</button></caption>@endif --}}
                <thead>
                <tr>
                  <th>#</th>
                  <th>Created Date</th>
                  <th>Trans. Date</th>
                  <th>Invoice #</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Service</th>
                  <th>Amount</th>
                  <th>Status</th>
                  <th>Pay Due Date</th>
                  @if(session('role') != "Super")<th>Action</th>@endif
                </tr>
                </thead>
                <tbody>
                @if(count($invoiceImport) > 0)
                <?php $i = 1;?>
                @foreach ($invoiceImport as $invoiceImports)
                    <tr>


                      <td>{{ $i++ }}</td>
                      <td>{{ date('d/M/Y', strtotime($invoiceImports->created_at)) }}</td>
                      <td>{{ date('d/M/Y', strtotime($invoiceImports->transaction_date)) }}</td>
                      <td>{{ $invoiceImports->invoice_no }}</td>
                      <td>{{ $invoiceImports->name }}</td>
                    <td title="{{ $invoiceImports->payee_email }}"><?php $string = $invoiceImports->payee_email; $output = strlen($string) > 10 ? substr($string,0,10)."..." : $string; echo $output;?></td>
                    <td title="{{ $invoiceImports->service }}"><?php $string = $invoiceImports->service; $output = strlen($string) > 10 ? substr($string,0,10)."..." : $string; echo $output;?></td>
                      <td align="center" style="font-weight: bold; color: navy;">@if (isset($getUserDetail) == true) {{ $getUserDetail->currencySymbol.number_format($invoiceImports->amount, 2) }} @else {{ number_format($invoiceImports->amount, 2) }} @endif </td>

                      @if($leftOver = \App\InvoicePayment::where('invoice_no', $invoiceImports->invoice_no)->get())
                        
                        @if(count($leftOver) > 0)
                        <td align="center" style="font-weight: bold; color: green;">Paid</td>

                        @else
                        <td align="center" style="font-weight: bold; color: red;">Pending</td>

                        @endif

                      @endif
                      <td>{{ date('d/M/Y', strtotime($invoiceImports->payment_due_date)) }}</td>

                   @if(session('role') != "Super") <td><button type="button" class="btn btn-primary" id="viewdetails{{ $invoiceImports->id }}" onclick="location.href='Admin/customer/{{ $invoiceImports->id }}'">View Details</button></td>@endif
                </tr>
                @endforeach
                @else
                  <tr>
                  <td colspan="10" align="center"> No uploaded Invoice yet</td>
                </tr>
                @endif


                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->


        </section>
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-12 connectedSortable">

          <!-- TO DO List -->
          <div class="box box-primary">
            <div class="box-header">
              <i class="ion ion-clipboard"></i>

              <h3 class="box-title">Recently Paid Invoices</h3>
            </div>

            @if(session('role') == "Super")

            <!-- /.box-header -->
            <div class="box-body table table-responsive">
               <table id="example1" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Transaction ID</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Amount</th>
                  <th>Invoice #</th>
                  <th>Service</th>
                  <th>Client</th>
                  <th>Pay Date</th>
                </tr>
                </thead>
                <tbody>

                    @if(count($payInvoice) > 0)
                    <?php $i = 1;?>
                    @foreach ($payInvoice as $payInvoices)
                        <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $payInvoices->transactionid }}</td>
                        <td>{{ $payInvoices->name }}</td>
                        <td>{{ $payInvoices->email }}</td>
                        <td style="font-weight: bold; color: green;">${{ number_format($payInvoices->amount) }}</td>
                        <td>{{ $payInvoices->invoice_no }}</td>
                        <td>{{ $payInvoices->service }}</td>
                        <td>{{ $payInvoices->business_name }}</td>
                        <td>{{ date('d/M/Y', strtotime($payInvoices->created_at)) }}</td>
                        </tr>
                    @endforeach

                    @else
                        <tr>
                            <td colspan="8" align="center">No payment made to client yet</td>
                        </tr>

                    @endif


                </tbody>
              </table>
            </div>
            <!-- /.box-body -->

            @else

            <!-- /.box-header -->
            <div class="box-body table table-responsive">
               <table id="example1" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Trans. ID</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Amount</th>
                  <th>Invoice #</th>
                  <th>Service</th>
                  <th>Pay Date</th>
                </tr>
                </thead>
                <tbody>

                    @if(count($payInvoice) > 0)
                    <?php $i = 1;?>
                    @foreach ($payInvoice as $payInvoices)
                        <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $payInvoices->transactionid }}</td>
                        <td>{{ $payInvoices->name }}</td>
                        <td>{{ $payInvoices->email }}</td>
                        <td style="font-weight: bold; color: green;">${{ number_format($payInvoices->amount) }}</td>
                        <td>{{ $payInvoices->invoice_no }}</td>
                        <td>{{ $payInvoices->service }}</td>
                        <td>{{ date('d/M/Y', strtotime($payInvoices->created_at)) }}</td>
                        </tr>
                    @endforeach

                    @else
                        <tr>
                            <td colspan="8" align="center">No Payment made yet</td>
                        </tr>

                    @endif


                </tbody>
              </table>
            </div>
            <!-- /.box-body -->

            @endif

          </div>
          <!-- /.box -->

        </section>
        <!-- right col -->
      </div>
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection
