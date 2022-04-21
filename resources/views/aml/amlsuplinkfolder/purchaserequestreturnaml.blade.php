@extends('layouts.dashboard')

@section('dashContent')


<?php use \App\Http\Controllers\User; ?>
<?php use \App\Http\Controllers\AddBank; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         Process Refund Request
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Process Refund Request</li>
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

              <table id="example3" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Date</th>
                  <th>Description</th>
                  <th>Comment</th>
                  <th>Amount</th>
                  <th>Commission</th>
                  <th>&nbsp;</th>
                </tr>
                </thead>
                <tbody id="statementtab">
                    @if (count($data['processList']) > 0)
                    @foreach ($data['processList'] as $walletstatements)
                            <tr>
                                <td>
                                    {{ date('d/m/Y', strtotime($walletstatements->created_at)) }}
                                </td>
                                <td>

                                        <div class="row">
                                            <div class="col-md-12">
                                                {!! $walletstatements->activity !!}
                                            </div>
                                            
                                            <div class="col-md-12">
                                                <small>
                                                    {{ $walletstatements->reference_code }}
                                                </small><br>
                                                <small>
                                                    {{ date('d/m/Y h:i a', strtotime($walletstatements->created_at)) }}
                                                </small>
                                            </div>
                                        </div>

                                    </td>

                                    <td>
                                        {!! $walletstatements->comment !!}
                                    </td>

                                    @if($userInfo = \App\User::where('email', $walletstatements->user_id)->first())

                                        <td style="font-weight: 700" class="{{ ($walletstatements->credit != 0) ? "text-success" : "text-danger" }}">{{ ($walletstatements->credit != 0) ? "+".$userInfo->currencySymbol.number_format($walletstatements->credit, 2) : "-".$userInfo->currencySymbol.number_format($walletstatements->debit, 2) }}</td>

                                        <td style="font-weight: 700" class="text-success">{{ "+".$userInfo->currencySymbol.number_format($walletstatements->chargefee, 2) }}</td>

                                    @endif

                                    <td>

                                        @if ($walletstatements->refund_state == 1 && $walletstatements->actedOn == 1)
                                            <a type="button" href="javascript:void()" class="btn btn-danger" disabled style="cursor: not-allowed">Purchase Refunded</a>
                                        @else
                                            <a type="button" href="{{ route('return withdrawal request', $walletstatements->reference_code) }}" class="btn btn-primary">Refund purchase</a>
                                        @endif

                                        
                                    </td>

                                
                            </tr>
        
                        @endforeach
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


