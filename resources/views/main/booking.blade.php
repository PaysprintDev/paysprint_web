@extends('layouts.dashboard')

@section('dashContent')


<?php use \App\Http\Controllers\User; ?>
<?php use \App\Http\Controllers\OrganizationPay; ?>
<?php use \App\Http\Controllers\ClientInfo; ?>
<?php use \App\Traits\PaysprintPoint; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         Paysprint point by Country
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">All Override Users By Country</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <div class="row">
                <div class="col-md-2 col-md-offset-0">
                <button class="btn btn-secondary btn-block bg-red" onclick="goBack()"><i class="fas fa-chevron-left"></i> Go back</button>
            </div>
            </div>
              
            </div>
            <!-- /.box-header -->
            <div class="box-body table table-responsive">

              <table class="table table-bordered table-striped" id="example3">

                <thead>
                  
                <tr>
                  <th>S/N</th>
                  <th>Name</th>
                  <th>Add Money</th>
                  <th>Send Money</th>
                  <th>Receive Money</th>
                  <th>Pay Invoice</th>
                  <th>Pay Bills</th>
                  <th>Create And Send Invoice</th>
                  <th>Active Rental Property</th>
                  <th>Quick Set Up</th>
                  <th>Identity Verification</th>
                  <th>Business Verification</th>
                  <th>Activate Ordering System</th>
                  <th>Identify Verification</th>
                  <th>Activate RPM</th>
                  <th>Activate Currency Exchange</th>
                  <th>Activate Cash Advance</th>
                  <th>Activate Crypto Currency Account</th>
                </tr>
                </thead>
                <tbody>
                    @if (count($data['mainpoint']) > 0)
                    <?php $i = 1;?>
                        @foreach ($data['mainpoint'] as $item)
                        <tr>
                            <td>{{ $i++ }}</td>
                            
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->add_money }}</td>
                            <td>{{ $item->send_money }}</td>
                            <td>{{ $item->receive_money }}</td>
                            <td>{{ $item->pay_invoice }}</td>
                            <td>{{ $item->pay_bills }}</td>
                            <td>{{ $item->create_and_send_invoice }}</td>
                            <td>{{ $item->active_rental_property }}</td>
                            <td>{{ $item->quick_set_up }}</td>
                            <td>{{ $item->identity_verification }}</td>
                            <td>{{ $item->business_verification }}</td>
                            <td>{{ $item->promote_business }}</td>
                            <td>{{ $item->activate_ordering_system }}</td>
                            <td>{{ $item->identify_verification }}</td>
                            <td>{{ $item->activate_rpm }}</td>
                            <td>{{ $item->activate_currency_exchange }}</td>
                            <td>{{ $item->activate_cash_advance }}</td>
                            <td>{{ $item->activate_crypto_currency_account }}</td>
                            


                        </tr>
                        @endforeach

                        

                    @else
                    <tr>
                        <td colspan="20" align="center">No record available</td>
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