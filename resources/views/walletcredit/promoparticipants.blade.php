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
        Promo Date
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Promo Date</li>
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
              
            </div>
            </div>

              <h3 class="box-title">&nbsp;</h3> <br>

              
            </div>
            <!-- /.box-header -->
           
            <div class="container-fluid">
                {!! session('msg') !!}
                <!-- The tables -->
                <div class="row">
                    <div class="col-md-12 mt-4">
                        <h3 class="text-center" style="font-weight: bold">SPECIAL PROMO REPORT BETWEEN ( {{ Request::get('start') }} - {{ Request::get('end') }} )</h3>
                        <hr>
                        <table class="table table-striped table-responsive" id="promousers">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Name of Participants</th>
                                    <th>Country</th>
                                    <th>Total People Referred</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $counter=1;
                                @endphp
                                @if (count($data['promo']) > 0)
                                    @foreach ( $data['promo'] as $promo )
                                    @if($user= \App\User::where('id',$promo->user_id)->first())
                                    
                                        <tr>
                                            <td> {{ $counter++}} </td>
                                            <td> {{ $user->name}} </td>
                                            <td> {{ $user->country}} </td>

                                            @if($totalreferred= \App\User::where('referred_by', $user->ref_code)->whereBetween('created_at', [Request::get('start'), Request::get('end')])->get())
                                            <td> {{ count($totalreferred) }}  </td>
                                            <td>
                                              @if(count($totalreferred) >= $data['promodata']->amount )
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop{{ $promo->id }}">Top-up Referral Point</button>
                                                <!-- else less than 50 points -->
                                                @else
                                                <a href="javascript:void()" class="btn btn-danger">Didnt Meetup Referrals for the Promo</a>
                                            @endif
                                          </td>

                                          @endif
                                        </tr> 
                                    
                                     @endif
                                  <!-- modal starts -->
                                                       <!-- Modal -->
                  <div class="modal fade" id="staticBackdrop{{ $promo->id }}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="staticBackdropLabel">Referral Point Top-up</h5>
                        </div>
                        <div class="modal-body">
                          <form action="{{route('topup referral point')}}" method="post">
                            @csrf
                            <div class="row"> 
                          @if($user= \App\User::where('email',$promo->email)->first())
                              <div class="col-md-6 form-group">
                                <label>Name of User</label>
                                <p>{{ $user->name}}</p>
                              </div>
                              <div class="col-md-6 form-group">
                                <label class="text-danger">Country: {{ $user->country}}</label> <br>
                              </div>
                              <div class="col-md-12 form-group">
                                <label>Referral Point: {{ $user->referral_points}}</label>
                              </div>
                            
                              <div class="col-md-12 form-group">
                                <label>Top-up Referral Point</label>
                                <input type="text" name="topup_point" class="form-control"> 
                              </div>
                              <div class="col-md-12 form-group">
                                <label>Reasons for Wallet Credit</label>
                                <select name="topup_reason" class="form-control">
                                    <option value="">Select A Reason</option>
                                    <option value="super_promo" selected>Super Promo</option>
                                </select>
                              </div>
                              <input type="hidden" name="userid" value="{{ $user->id}}" >
                              <input type="hidden" name="promoid" value="{{ $promo->id}}">
                          </div>
                          @endif
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-primary">Top-up Referral Point</button>
                        </div>
                      </form>
                      </div>
                    </div>
                  </div>
                                                <!-- modal ends -->
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
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


