@extends('layouts.dashboard')

@section('dashContent')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Send Message
        <small>Send Message to User</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Send Message</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        
        <div class="box-body">
          
            {{-- Provide Form --}}
            <form role="form" action="{{ route('send user message') }}" method="POST">
                @csrf
                <div class="box-body">
                    
                    <div class="form-group has-success">
                        <label class="control-label" for="send_to"> Send To</label>
                        <input name="send_to" id="send_to" class="form-control" value="{{ $data['user']->email }}" readonly>
                    </div>

                    <div class="form-group has-success">
                        <label class="control-label" for="receiver_name"> Receiver Name</label>
                        <input name="receiver_name" id="receiver_name" class="form-control" value="{{ $data['user']->name }}" readonly>
                    </div>


                    <div class="form-group has-success">
                        <label class="control-label" for="subject"> Subject</label>
                        <input name="subject" id="subject" class="form-control">
                    </div>


                    <div class="form-group has-success">
                        <label class="control-label" for="message"> Message</label>
                        
                        <textarea name="message" id="message" cols="30" rows="10" class="form-control"></textarea>

                    </div>


                </div>
                <!-- /.box-body -->
  
                <div class="box-footer">
                  <button type="submit" class="btn btn-primary btn-block">Send</button>
                </div>
              </form>



              {{-- List Categories --}}
              <hr>

              <div class="table-responsive">

              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Sent To</th>
                  <th>Subject</th>
                  <th>Message</th>
                  <th>Date Sent</th>
                </tr>
                </thead>
                <tbody>

                    @if (count($data['messageUser']) > 0)
                    @php
                        $i = 1;
                    @endphp
                        @foreach ($data['messageUser'] as $messageUsers)

                            <tr>
                                <td>{{ $messageUsers->send_to }}</td>
                                <td>{{ $messageUsers->subject }}</td>
                                <td>{!! $messageUsers->message !!}</td>
                                <td>{{ date('d/M/Y', strtotime($messageUsers->created_at)) }}</td>
                            </tr>
                            
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" align="center">No message </td>
                        </tr>
                    @endif
                  
                  
                      
                  
                </tbody>
              </table>

            </div>

        </div>
        <!-- /.box-body -->
        
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection