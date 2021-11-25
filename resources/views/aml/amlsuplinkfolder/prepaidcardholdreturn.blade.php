@extends('layouts.dashboard')

@section('dashContent')


<?php use \App\Http\Controllers\User; ?>
<?php use \App\Http\Controllers\AddCard; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         Request to Load Prepaid Card
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Request to Load Prepaid Card</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <br>
          <button class="btn btn-secondary btn-block bg-red" onclick="goBack()"><i class="fas fa-chevron-left"></i> Go back</button>
      <br>

      <div class="row">
        <div class="col-xs-12">
          <div class="box">

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
                  <th>Email</th>
                  <th>Transaction ID</th>
                  <th>Reference Code</th>
                  <th>Card Number</th>
                  <th>Amount</th>
                  <th>Request Date</th>
                  <th>Status</th>
                </tr>
                </thead>
                <tbody>
                    @if (isset($data['prepaidRequestWithdrawal']) && count($data['prepaidRequestWithdrawal']->data) > 0 && $data['prepaidRequestWithdrawal']->status == 200)
                    <?php $i = 1;?>
                        @foreach ($data['prepaidRequestWithdrawal']->data as $items)

                          @if ($items->load_status == "NOT PROCESSED" || $items->load_status == "PENDING")
                              <tr>
                              <td>{{ $i++ }}</td>

                              @if($user = \App\User::where('email', $items->email)->first())

                                @php
                                    $currencyCode = $user->currencyCode;
                                    $currencySymbol = $user->currencySymbol;
                                    $name = $user->name;
                                @endphp


                              @else

                                @php
                                    $currencyCode = '';
                                    $currencySymbol = '';
                                    $name = '-';
                                @endphp
                              @endif
                              <td>{{ $name }}</td>
                              <td>{{ $items->email }}</td>
                              <td>{{ $items->transaction_id }}</td>
                              <td>{{ $items->reference_code }}</td>
                              <td>{{ $items->card_number }}</td>

                              <td style="font-weight: 700;">{{ $currencySymbol.' '.number_format($items->amount, 2) }}</td>

                              <td>{{ date('d/M/Y', strtotime($items->created_at)) }}</td>

                              <td style="font-weight: bold; color: @if($items->load_status == "NOT PROCESSED") red; @elseif($items->load_status == "PENDING") darkorange; @else green; @endif">{{ $items->load_status }}</td>


                          </tr>
                          @endif

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


