@extends('layouts.dashboard')

@section('dashContent')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Fee Structure By Country
        <small>Cost of Pulling and Pushing</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Fee Structure By Country</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        
        <div class="box-body">
          

              <div class="table-responsive">

              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>S/N</th>
                  <th>Country</th>
                  <th>Structure</th>
                  <th>Method</th>
                  <th>Fixed</th>
                  <th>Variable</th>
                  <th>Date Added</th>
                  <th>Last Updated</th>
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
                                <td>{{ $item->country }}</td>
                                <td>{{ $item->structure }}</td>
                                <td>{{ $item->method }}</td>
                                <td>{{ $item->fixed }}</td>
                                <td>{{ $item->variable }}</td>
                                <td>{{ date('d/M/Y', strtotime($item->created_at)) }}</td>
                                <td>{{ date('d/M/Y', strtotime($item->updated_at)) }}</td>
                                <td><a href="{{ route('editfee', $item->id) }}" style="color: navy; font-weight: bold;">Edit</a> | <form action="{{ route('deletefee', $item->id) }}" method="POST" id="deletefee{{ $item->id }}" class="disp-0">@csrf</form> <a href="#" style="color: red; font-weight: bold;" onclick="del('deletefee', {{ $item->id }})">Delete</a></td>
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