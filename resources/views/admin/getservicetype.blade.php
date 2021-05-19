@extends('layouts.dashboard')

@section('dashContent')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Create Invoice Types
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Create Invoice Types</li>
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
                                <label class="control-label" for="inputSuccess"> Invoice Type</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="e.g Accomodation">
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.box-body -->
  
                <div class="box-footer">
                  <button type="button" class="btn btn-primary btn-block" onclick="handShake('createservicetype')" id="cardSubmit">Submit</button>
                </div>
              </form>



              {{-- List Categories --}}
              <hr>

              <div class="table-responsive">

              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Invoice Types</th>
                </tr>
                </thead>
                <tbody>

                    @if (count($data['getServiceType']) > 0)
                    @php
                        $i = 1;
                    @endphp
                        @foreach ($data['getServiceType'] as $item)

                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $item->name }}</td>
                                
                            </tr>
                            
                        @endforeach
                    @else
                        <tr>
                            <td colspan="2" align="center">No record</td>
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