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
        Wallet Credit Report
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Wallet Credit Report</li>
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
            {!! session('msg') !!}
            <!--report filter-->
            <div class="container-fluid">
                <form action="{{route('view report')}}" method="get">
                  @csrf
                      <div class="row">
                        <div class="col-md-12" style="margin-bottom:20px;">
                          <label>Wallet-Credit Type</label>
                          <select name="topup_type" class="form-control">
                            <option value="">Select A Reason</option>
                            <option value="Promo">Promo</option>
                            <option value="Survey">Survey</option>
                            <option value="Referral">Referral</option>
                            <option value="Reward">Reward</option>
                        </select>
                        </div>
                        <div class="col-md-6" style="margin-top: 10px; ">
                          <label>Start-Date</label>
                          <input type="date" name="start_date" class="form-control">
                        </div>
                        <div class="col-md-6" style="margin-top: 10px; ">
                          <label>End-Date</label>
                          <input type="date" name="end_date" class="form-control">
                        </div>
                        <input type="hidden" name="country" value="{{ Request::get('country')}}">
                        <div class="col-md-12" style="margin-top: 20px; margin-bottom:20px ">
                          <button class="btn btn-primary form-control" type="submit" >Submit</button>
                        </div>
                      </div>
                </form>
            </div>
              <hr>
            <!-- report Table -->
              <div class="container-fluid" style="margin-top: 30px">
                  {{-- @if(isset($data['start_date']))
                  @if(isset($data['end_date']))
                    <h1>Start Date:{{$data['start_date']}} - End Date:{{$data['end_date']}} </h1>
                    <hr>
                  @endif
                  @endif --}}s
                  <table class="table table-responsive table-striped" id="promousers">
                      <thead>
                        <tr>
                          <th>S/N</th>
                          <th>Account Number</th>
                          <th>Email</th>
                          <th>Full-Name</th>
                          <th>Account Type</th>
                          <th>Amount Credited</th>
                        </tr>
                      </thead>
                      <tbody>
                        @if($data['start_date'] != "null" && $data['end_date'] != "null")
                        <p class="text-center mb-2" style="font-size: 25px; font-weight:bold"> <span>{{$data['promo_type'].' '.'Report Between '}}</span><span>{{$data['start_date']}}</span><span>  -  </span><span>{{$data['end_date']}}</span></p>
                             @else
                               <p></p>
                             @endif
                        @php
                        $counter=1;
                      @endphp


                   @if(count($data['report']) > 0)

                     @foreach ( $data['report'] as $reports)
                     {{-- User Data table... --}}
                     @if($user= \App\User::where('id',$reports->user_id)->first())
                      

                     <tr>
                      <td>{{ $counter++}}</td>
                      <td>{{$user->ref_code}}</td>
                      <td>{{$user->email}}</td>
                      <td>{{$user->name}}</td>
                      <td>{{$user->accountType}}</td>
                      <td>{{$user->currencySymbol}}{{$reports->wallet_credit_amount}}</td>
                  </tr>
                       
                     @endif


                        @endforeach 
                   @endif

                      </tbody>
                  </table>
              </div>
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


