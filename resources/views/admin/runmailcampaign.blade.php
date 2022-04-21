@extends('layouts.dashboard')

@section('dashContent')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Send Mail Campaign
        <small>Send Mail Campaign to User</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Send Mail Campaign</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        
        <div class="box-body">
          
            {{-- Provide Form --}}
            <form role="form" action="{{ route('run mail campaign to users') }}" method="POST">
                @csrf
                <div class="box-body">
                    
                    <div class="form-group has-success">
                        <label class="control-label" for="category"> Send Campaign To Users</label>
                        <select name="category" id="category" class="form-control" required>
                            <option value="">Select Accounts</option>
                            <option value="New Consumers">New Consumers</option>
                            <option value="Existing Consumers">Existing Consumers</option>
                            <option value="New Merchants">New Merchants</option>
                            <option value="Existing Merchants">Existing Merchants</option>
                            <option value="Archived Consumers">Archived Consumers</option>
                            <option value="Archived Merchants">Archived Merchants</option>
                            <option value="Quick Setup">Quick Setup</option>
                            <option value="Special Information">Special Information</option>
                        </select>
                    </div>


                    <div class="form-group has-success">
                        <label class="control-label" for="subject"> Subject</label>
                        <input name="subject" id="subject" class="form-control" required>
                    </div>


                    <div class="form-group has-success">
                        <label class="control-label" for="message"> Message</label>
                        
                        <textarea name="message" id="message" cols="30" rows="10" class="form-control" required></textarea>

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
                  <th>S/N</th>
                  <th>Subject</th>
                  <th>Caategory</th>
                  <th>Message</th>
                  <th>Date Sent</th>
                </tr>
                </thead>
                <tbody>
                    @if (count($data['mailcampaign']) > 0)
                    @php
                        $i = 1;
                    @endphp
                        @foreach ($data['mailcampaign'] as $item)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $item->subject }}</td>
                                <td>{{ $item->category }}</td>
                                <td>{!! $item->message !!}</td>
                                <td>{{ date('d/M/Y', strtotime($item->created_at)) }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" align="center">No record</td>
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