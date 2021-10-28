@extends('layouts.dashboard')

@section('dashContent')


<?php use \App\Http\Controllers\User; ?>
<?php use \App\Http\Controllers\Statement; ?>
<?php use \App\Http\Controllers\MonthlyFee; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         Invoice Commission
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Invoice Commission</li>
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

              <h3 class="box-title">&nbsp;</h3> <br>

              
            </div>
            <!-- /.box-header -->

            <div class="box-body table table-responsive">

              <table class="table table-bordered table-striped" id="example3">
                  
                <thead>
                    <tr>
                        <td>#</td>
                        <td>Invoice Ref.</td>
                        <td>Sender</td>
                        <td>Receiver</td>
                        <td>Invoice Amount</td>
                        <td>Profit</td>
                        <td>Profit Currency</td>
                        <td>Date & Time</td>
                        
                    </tr>
                </thead>


                @if (count($data['invcommission']) > 0)

                <?php $i=1;?>

                @foreach ($data['invcommission'] as $item)
                    <tr>

                        <td>{{ $i++ }}</td>
                        <td>{{ $item->invoice_no }}</td>
                        <td>{{ $item->sender }}</td>
                        <td>{{ $item->receiver }}</td>
                        <td>{{ number_format($item->invoice_amount, 2)." ".$item->invoiced_currency }}</td>
                        <td>{{ number_format($item->profit_sender, 2) }}</td>
                        <td>{{ $item->sender_currency }}</td>
                        <td>{{ date('d/M/Y h:i a', strtotime($item->created_at)) }}</td>

                    </tr>
                @endforeach

                @else

                <tr>
                    <td colspan="8" align="center">No record</td>
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


