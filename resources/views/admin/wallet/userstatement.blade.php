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
         Wallet Transaction History
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Wallet Transaction History</li>
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
              <form action="{{ route('user wallet report') }}" method="GET">
                @csrf
                  <br>
                <div class="row">
                  <div class="col-md-12">
                    <select data-show-subtext="true" data-live-search="true" name="user_id" class="form-control selectpicker" id="statement_service">
                        @if (count($data['allusers']) > 0)
                            @foreach ($data['allusers'] as $users)
                                <option value="{{ $users->email }}" data-subtext="- Account Number: {{ $users->ref_code }}">{{ $users->name }}</option>
                            @endforeach
                        @else
                           <option value="" data-subtext="">No Record</option> 
                        @endif
                    </select>
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col-md-6">
                    <input type="date" name="statement_start" class="form-control" id="statement_start">
                  </div>
                  <div class="col-md-6">
                    <input type="date" name="statement_end" class="form-control" id="statement_end">
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col-md-12">
                    {{-- onclick="checkStatement()" --}}

                    <button class="btn btn-primary" type="submit">Check Transactions History<img src="https://i.ya-webdesign.com/images/loading-gif-png-5.gif" class="spinner disp-0" style="width: 40px; height: 40px;"></button>
                    
                  </div>
                </div>
              </form>
              
            </div>
            <!-- /.box-header -->
            
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
