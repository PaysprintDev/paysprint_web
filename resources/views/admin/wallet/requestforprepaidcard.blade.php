@extends('layouts.dashboard')

@section('dashContent')


<?php use \App\Http\Controllers\User; ?>
<?php use \App\Http\Controllers\AddCard; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         Prepaid Card Request
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Prepaid Card Request</li>
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
                  <th>Name on Card</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Address</th>
                  <th>Location</th>
                  <th>Amount</th>
                  <th>Card Status</th>
                  <th>Date Paid</th>
                </tr>
                </thead>
                <tbody>
                    @if (count($data['cardrequest']->data) > 0 && $data['cardrequest']->status == 200)
                    <?php $i = 1;?>
                        @foreach ($data['cardrequest']->data as $items)
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
                            <td>{{ $items->name_on_card }}</td>
                            <td>{{ $items->email }}</td>
                            <td>{{ $items->phone }}</td>
                            <td>{{ $items->address }}</td>
                            <td>{{ $currencySymbol.' '.number_format($items->amount, 2) }}</td>
                            <td>{{ $items->city.', '.$items->province.' '.$items->country }}</td>

                            <td style="font-weight: bold; color: @if($items->card_status == "PENDING") darkorange; @else green; @endif">{{ $items->card_status }}</td>

                            <td>{{ date('d-m-Y', strtotime($items->created_at)) }}</td>

                        </tr>
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


