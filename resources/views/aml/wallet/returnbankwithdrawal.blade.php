@extends('layouts.dashboard')

@section('dashContent')

<?php use \App\Http\Controllers\User; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Refund Withdrawal Request
        <small>Refund Withdrawal Request to User</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Refund Withdrawal Request</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        
        <div class="box-body">


          {{-- Provide Form --}}
            <form role="form" action="{{ route('act on return refund money', $data['returnRequest']->reference_code) }}" method="POST">
                @csrf
                <div class="box-body">
                    
                    <div class="form-group has-success">
                        <label class="control-label" for="send_to"> Customer Email</label>
                        <input name="send_to" id="send_to" class="form-control" value="{{ $data['returnRequest']->user_id }}" readonly>
                    </div>


                    @if($thisuser = \App\User::where('email', $data['returnRequest']->user_id)->first()) 

                        <div class="form-group has-success">
                            <label class="control-label" for="receiver_name"> Customer Name</label>

                            @if ($thisuser->accountType == "Merchant")
                                <input name="receiver_name" id="receiver_name" class="form-control" value="{{ $thisuser->businessname }}" readonly>
                            @else
                                <input name="receiver_name" id="receiver_name" class="form-control" value="{{ $thisuser->name }}" readonly>
                            @endif

                            
                        </div>



                        <div class="form-group has-success">
                            <label class="control-label" for="message"> Reason for Refund</label>
                            
                            <textarea name="message" id="message" cols="30" rows="10" class="form-control">Your request to {{ $data['returnRequest']->activity }} will be returned because;</textarea>

                        </div>

                    @endif



                </div>
                <!-- /.box-body -->
  
                <div class="box-footer">
                  <button type="submit" class="btn btn-primary btn-block">Refund Money</button>
                </div>
              </form>
              

          
            


        </div>
        <!-- /.box-body -->
        
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection