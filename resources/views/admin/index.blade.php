@extends('layouts.dashboard')


@section('dashContent')

<?php use \App\Http\Controllers\ClientInfo; ?>
<?php use \App\Http\Controllers\User; ?>
<?php use \App\Http\Controllers\InvoicePayment; ?>
<?php use \App\Http\Controllers\AllCountries; ?>

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
              <h3>&nbsp;</h3>

              <p>Business Report</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{ route('business report') }}" class="small-box-footer">View details <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{ count($withdraws['bank']) }}</h3>

              <p>Bank Withd. Request</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{ route('bank request withdrawal') }}" class="small-box-footer">View details <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>


        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-blue">
            <div class="inner">
              <h3>{{ count($withdraws['credit']) }}</h3>

              <p>Credit Card Withd. Request</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{ route('card request withdrawal') }}" class="small-box-footer">View details <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>


        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-purple">
            <div class="inner">

              @if (isset($withdraws['prepaid']))
                <h3>{{ count($withdraws['prepaid']->data) }}</h3>
                  
              @else
                  <h3>0</h3>
              @endif


              <p>Prepaid Card Withd. Request</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{ route('prepaid request withdrawal') }}" class="small-box-footer">View details <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>{{ count($pending['transfer']) }}</h3>

              <p>Text-To-Transfer</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{ route('text to transfer') }}" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{ count($pending['texttotransfer']) }}</h3>

              <p>Pending Transfer</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{ route('pending transfer') }}" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>


        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-orange">
            <div class="inner">
              <h3>{{ count($refund['requestforrefund']) }}</h3>

              <p>Refund Request</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{ route('refund money request') }}" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        {{-- <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>{{ count($allusers) }}</h3>

              <p>All Users</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{ route('all users by country') }}" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div> --}}
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>@if($approvedCountries = \App\AllCountries::where('approval', 1)->count()) {{ $approvedCountries }} @endif</h3>

              <p>Active Countries</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="{{ route('all countries') }}" class="small-box-footer">View All <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>


          <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-purple">
            <div class="inner">
              <h3>{{ count($allusers) }}</h3>

              <p>All Users</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ route('all users by country') }}" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>


          <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>@if($approvalAccept = \App\User::where('accountLevel', 3)->count()) {{ $approvalAccept }} @endif</h3>

              <p>Matched Users</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ route('approved users by country') }}" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>


          <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>@if($approvalPending = \App\User::where('accountLevel', 0)->count()) {{ $approvalPending }} @endif</h3>

              <p>Unmatched Users</p>

            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ route('pending users by country') }}" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>


          <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-blue">
            <div class="inner">
              <h3>@if($override = \App\User::where('accountLevel', 2)->count()) {{ $override }}  @else 0 @endif</h3>

              <p>Override Level 1</p>

            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ route('override users by country') }}" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
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
              <i class="ion ion-pricetag"></i>
            </div>
            {{-- <a href="#" class="small-box-footer">View details <i class="fa fa-arrow-circle-right"></i></a> --}}
          </div>
        </div>
        <!-- ./col -->
        
        <!-- ./col -->
        <div class="col-lg-6 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">
            <h3>{{ $getUserDetail->number_of_withdrawals }}</h3>

              <p>Number of Withdrawals</p>
            </div>
            <div class="icon">
              <i class="ion ion-archive"></i>
            </div>
        {{--  <a href="{{ route('Otherpay') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>  --}}
          </div>
        </div>

        <div class="col-lg-6 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-success">
            <div class="inner">
              @if (isset($getCard) && count($getCard) > 0)
                  @php
                      $others = count($getCard) - 1;
                      $cardNo = wordwrap($getCard[0]->card_number, 4, '-', true);
                  @endphp

                @switch($getCard[0]->card_type)
                    @case("Mastercard")
                        @php
                            $cardImage = '<img src="https://img.icons8.com/color/30/000000/mastercard.png"/>';
                        @endphp
                        @break
                    @case("Visa")
                        @php
                            $cardImage = '<img src="https://img.icons8.com/color/30/000000/visa.png"/>';
                        @endphp
                        @break
                    @default
                        @php
                            $cardImage = '<img src="https://img.icons8.com/fluent/30/000000/bank-card-back-side.png"/>';
                        @endphp
                    @endswitch

                        <div class="row">
                            <div class="col-md-12">
                                <h3 style="font-size: 30px;">
                                    {{ (strlen($cardNo) < 10) ? $cardNo : substr($cardNo, 0, 10)."***" }} {{ ($others > 0) ? "& ".$others." others" : "" }}

                                    
                                </h3>
                            </div>
                            <br>
                            <div class="col-md-6">
                                <h4>
                                    Expiry: {{ $getCard[0]->month."/".$getCard[0]->year }}
                                </h4>
                            </div>
                            <div class="col-md-6">
                                <h4>
                                    CVV: ***
                                </h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h4>
                                    {{ (strlen($getCard[0]->card_name) < 18) ? strtoupper($getCard[0]->card_name) : substr(strtoupper($getCard[0]->card_name), 0, 18)."..." }}
                                </h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                {!! $cardImage !!}
                            </div>
                        </div>

              @else
                  <h3>&nbsp;</h3>

                <p>Add a new card</p>
              @endif


              
            </div>
            <div class="icon">
              <i class="ion ion-card"></i>
            </div>
            {{-- <a href="#" class="small-box-footer">View details <i class="fa fa-arrow-circle-right"></i></a> --}}
          </div>


            <div class="col-md-12">
          <h3><strong>Payment Method</strong></h3>
              <hr>
            </div>
            <div class="col-md-12">

              <p><strong>Click icon below to add card</strong></p>

                <button style="background-color: #000 !important;" class="px-2" title="PaySprint Payment Gateway" onclick="location.href='{{ route('merchant payment gateway', 'gateway=PaySprint') }}'">
                    <img src="https://res.cloudinary.com/pilstech/image/upload/v1618251695/paysprint_icon_new_kg2h3j.png" alt="PaySprint logo" width="50" height="50">
                </button>
                <button class="px-2" title="GooglePay Payment Gateway" onclick="comingSoon()"><img src="https://img.icons8.com/fluent/50/000000/google-logo.png"/></button>
                <br>
            <br>
            </div>

            <div class="col-md-4 mb-3">

              <a style="font-size: 12.5px;" type="button" href="{{ route('merchant add money') }}" class="btn btn-info btn-block">Add Money <i class="fas fa-plus"></i></a>
            </div>

            <div class="col-md-4 mb-3">
              <a style="font-size: 12.5px;" type="button" href="{{ route('merchant send money', 'type=local') }}" class="btn btn-warning btn-block">Send Money <i class="fas fa-paper-plane"></i></a>
            </div>

            <div class="col-md-4 mb-3">
              @if ($getUserDetail->approval == 1)
                  <a style="font-size: 12.5px;" type="button" href="{{ route('merchant withdrawal') }}" class="btn btn-success btn-block">Withdraw Money <i class="fas fa-credit-card"></i></a>
              @else
                      <a style="font-size: 12.5px;" type="button" href="javascript:void()" class="btn btn-success btn-block" onclick="restriction('withdrawal', '{{ $getUserDetail->name }}')">Withdraw Money <i class="fa fa-credit-card"></i></a>
                  
              @endif
            </div>






        </div>


        <div class="col-lg-6 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-danger">
            <div class="inner">

              @php
                $infoPend = 0;
              @endphp

              @if(count($invoiceImport) > 0)
                @foreach ($invoiceImport as $items)
                    @if($left = \App\InvoicePayment::where('invoice_no', $items->invoice_no)->get())
                        
                  @if(count($left) > 0)
                    @php
                        $pendPaid = count($left);

                        $infoPend += $pendPaid;
                    @endphp
                  
                  
                  @endif

                @endif
                @endforeach
              @endif

              

              <h3>{{ $infoPend }}</h3>

              <p>Paid Invoices</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            {{-- <a href="#" class="small-box-footer">View details <i class="fa fa-arrow-circle-right"></i></a> --}}
          </div>

          


          


        </div>


        
        <!-- ./col -->
      @endif

      </div>
      <br>
      <br>

      @if(session('role') != "Super")
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
                  <th>Tax Amount</th>
                  <th>Total Amount</th>
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

                      <td align="center" style="font-weight: bold; color: purple;">@if (isset($getUserDetail) == true) {{ $getUserDetail->currencySymbol.number_format($invoiceImports->tax_amount, 2) }} @else {{ number_format($invoiceImports->tax_amount, 2) }} @endif </td>

                      <td align="center" style="font-weight: bold; color: green;">@if (isset($getUserDetail) == true) {{ $getUserDetail->currencySymbol.number_format($invoiceImports->total_amount, 2) }} @else {{ number_format($invoiceImports->total_amount, 2) }} @endif </td>

                      @if ($invoiceImports->payment_status == 1)
                          <td align="center" style="font-weight: bold; color: green;">Paid</td>

                      @elseif ($invoiceImports->payment_status == 2)

                          <td align="center" style="font-weight: bold; color: purple;">Part Pay</td>

                      @else

                        <td align="center" style="font-weight: bold; color: red;">Unpaid</td>

                      @endif


                      {{-- @if($leftOver = \App\InvoicePayment::where('invoice_no', $invoiceImports->invoice_no)->get())
                        
                        @if(count($leftOver) > 0)
                        <td align="center" style="font-weight: bold; color: green;">Paid</td>

                        @else
                        <td align="center" style="font-weight: bold; color: red;">Pending</td>

                        @endif

                      @endif --}}
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

      @endif

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection
