@extends('layouts.dashboard')

@section('dashContent')


<?php use \App\Http\Controllers\User; ?>
<?php use \App\Http\Controllers\BankWithdrawal; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         Watchlist
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">View Watch List</li>
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
                  <th>Account Number</th>
                  <th>Name</th>
                  <th>Email</th>
                 <th>Phone-Number</th>
                 <th>Wallet Balance</th>
                 <th>Action</th>
                </tr>
                </thead>
                <tbody>
                  
                    @if (count($data['watchlist']) > 0)
                    <?php $i = 1;?>
                        @foreach ($data['watchlist'] as $item)
                        @if($user = \App\User::where('id', $item->user_id)->first())
                        
                            <tr>
                                  <td>{{ $i++ }}</td>
                                  <td>{{$item->ref_code}}</td>
                                  <td>{{$user->name}}</td>
                                  <td>{{$user->email}}</td>
                                  <td>{{$user->telephone}}</td>
                                  <td>{{ $user->currencyCode.number_format($user->wallet_balance, 2)}}</td>
                                  <td><a class="btn btn-primary" href="{{route('viewwatchlist', 'refcode='.$item->ref_code)}}">View Activities</a></td>
                              </tr>
                              @endif
                        @endforeach
                       
                    @else
                    <tr>
                        <td colspan="3" align="center">No record available</td>
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


