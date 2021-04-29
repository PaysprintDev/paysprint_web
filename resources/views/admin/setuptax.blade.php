@extends('layouts.dashboard')

@section('dashContent')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Set Up Tax
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Set Up Tax</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        
        <div class="box-body">

          <div class="row">
                <div class="col-md-2 col-md-offset-0">
                <button class="btn btn-secondary btn-block bg-red" onclick="goBack()"><i class="fas fa-chevron-left"></i> Go back</button>
            </div>
            </div>

          
            {{-- Provide Form --}}
            <form action="#" method="POST" id="formElem">
                @csrf
                <div class="box-body">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group has-success">
                                <label class="control-label" for="inputSuccess"> Name Of Tax</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Name Of Tax">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group has-success">
                                <label class="control-label" for="inputSuccess"> Tax Rate (%)</label>
                                <input type="number" min="0.00" step="0.01" class="form-control" name="rate" id="rate" placeholder="Tax Rate (%)">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group has-success">
                                <label class="control-label" for="inputSuccess"> Name of Agency</label>
                                <input type="text" class="form-control" name="agency" id="agency" placeholder="Name of Agency">
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.box-body -->
  
                <div class="box-footer">
                  <button type="button" class="btn btn-primary btn-block" onclick="handShake('setuptax')" id="cardSubmit">Submit</button>
                </div>
              </form>



              {{-- List Categories --}}
              <hr>

              <div class="table-responsive">

              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Name of Tax</th>
                  <th>Rate</th>
                  <th>Agency</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>

                    @if (count($data['getTax']) > 0)
                    @php
                        $i = 1;
                    @endphp
                        @foreach ($data['getTax'] as $item)

                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ number_format($item->rate, 2).'%' }}</td>
                                <td>{{ $item->agency }}</td>
                                <td>
                                    <a href="{{ route('edit tax', $item->id) }}" style="color: navy; font-weight: bold;">Edit</a> | <form action="#" method="POST" class="disp-0">@csrf <input type="hidden" name="id" id="id{{ $item->id }}" value="{{ $item->id }}"></form> <a href="#" style="color: red; font-weight: bold;" onclick="delhandShake('deletetax', '{{ $item->id }}')">Delete</a>

                                </td>
                                
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