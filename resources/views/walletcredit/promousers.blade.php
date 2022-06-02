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
        Promo Users
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Wallet Credit</li>
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
            <div class="container-fluid">
                <table class="table table-striped table-responsiveness" id="promousers">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Date</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php
                        $counter=1;
                    @endphp
                    @if (isset($data['promo']))
                    @foreach ( $data['promo'] as $promousers )
                        <tr>
                            <td>{{ $counter++}}</td>
                            <td>{{ $promousers->date}}</td>
                            <td>{{ $promousers->email}}</td>
                            <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop{{ $promousers->id }}">Top-up</button></td>
                        </tr>

                        <!-- Modal -->
                  <div class="modal fade" id="staticBackdrop{{ $promousers->id }}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="staticBackdropLabel">Top-up Credit</h5>
                        </div>
                        <div class="modal-body">
                          <form action="{{route('top up')}}" method="post">
                            @csrf
                            <div class="row"> 
                          @if($user= \App\User::where('email',$promousers->email)->first())
                              <div class="col-md-6 form-group">
                                <label>Name of User</label>
                                <p>{{ $user->name}}</p>
                              </div>
                              <div class="col-md-6 form-group">
                                <label class="text-danger">Country: {{ $user->country}}</label> <br>
                                <label class="text-danger">Currency: {{ $user->currencyCode}}</label>
                              </div>
                              <div class="col-md-12 form-group">
                                <label>Wallet Balance: {{ $user->wallet_balance}}</label>
                              </div>
                            
                              <div class="col-md-12 form-group">
                                <label>Top-up Credit</label>
                                <input type="text" name="topup_credit" class="form-control"> 
                              </div>
                              <input type="hidden" name="userid" value="{{ $user->id}}">
                          </div>
                          @endif
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-primary">Top-up</button>
                        </div>
                      </form>
                      </div>
                    </div>
                  </div>

                    @endforeach
                    @endif
                    <!-- modal -->
                    <!-- Button trigger modal -->

                  
  
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


