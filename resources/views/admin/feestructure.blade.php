@extends('layouts.dashboard')

@section('dashContent')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Fee Structure
        <small>Cost of Pulling and Pushing</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Fee Structure</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        
        <div class="box-body">
          
            {{-- Provide Form --}}
            <form role="form" action="{{ route('create fee structure') }}" method="POST">
                @csrf
                <div class="box-body">
                    <div class="form-group has-success">
                        <label class="control-label" for="inputSuccess"> Structure</label>
                        <select name="structure" id="structure" class="form-control">
                            <option value="">Select option</option>
                            <option value="Send Money/Pay Invoice">Send Money/Pay Invoice</option>
                            <option value="Receive Money">Receive Money</option>
                            <option value="Withdrawal">Withdrawal</option>
                        </select>
                        {{-- <input type="text" class="form-control" name="name" id="inputSuccess" placeholder="E.g Belt Work"> --}}
                    </div>
                    <div class="form-group has-success">
                        <label class="control-label" for="inputSuccess"> Method</label>
                        <select name="method" id="method" class="form-control">
                            <option value="">Select option</option>
                            <option value="CC/Bank">CC/Bank</option>
                            <option value="Wallet">Wallet</option>
                            <option value="EXBC Prepaid Card">EXBC Prepaid Card</option>
                        </select>

                        {{-- <input type="text" class="form-control" name="name" id="inputSuccess" placeholder="E.g Belt Work"> --}}
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group has-success">
                                <label class="control-label" for="inputSuccess"> Fixed</label>
                                <input type="number" min="0.00" step="0.01" class="form-control" name="fixed" id="fixed" placeholder="1.35">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group has-success">
                                <label class="control-label" for="inputSuccess"> Variable</label>
                                <input type="number" min="0.00" step="0.01" class="form-control" name="variable" id="variable" placeholder="0.98%">
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.box-body -->
  
                <div class="box-footer">
                  <button type="submit" class="btn btn-primary btn-block">Submit and Save</button>
                </div>
              </form>



              {{-- List Categories --}}
              <hr>

              <div class="table-responsive">

              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>S/N</th>
                  <th>Structure</th>
                  <th>Method</th>
                  <th>Fixed</th>
                  <th>Variable</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>

                    @if (count($transCost) > 0)
                    @php
                        $i = 1;
                    @endphp
                        @foreach ($transCost as $item)

                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $item->structure }}</td>
                                <td>{{ $item->method }}</td>
                                <td>{{ $item->fixed }}</td>
                                <td>{{ $item->variable }}</td>
                                <td><a href="{{ route('editfee', $item->id) }}" style="color: navy; font-weight: bold;">Edit</a> | <form action="{{ route('deletefee', $item->id) }}" method="POST" id="deletefee" class="disp-0">@csrf</form> <a href="#" style="color: red; font-weight: bold;" onclick="del('deletefee')">Delete</a></td>
                            </tr>
                            
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" align="center">No record</td>
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