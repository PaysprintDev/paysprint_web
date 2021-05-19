@extends('layouts.dashboard')

@section('dashContent')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Added Cards
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Users Added Cards</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <br>
          <button class="btn btn-secondary btn-block bg-red" onclick="goBack()"><i class="fas fa-chevron-left"></i> Go back</button>
      <br>

      <!-- Default box -->
      <div class="box">
        
        <div class="box-body">

              <div class="table-responsive">

              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>S/N</th>
                  <th>Name</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>

                    @if (count($data['allAddedCards']) > 0)

                    
                    @php
                        $i = 1;
                    @endphp
                        @foreach ($data['allAddedCards'] as $data)


                                <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $data->name }}</td>
                                
                                <td>
                                    <a href="{{ route('get user card', $data->user_id) }}" type="button" class="btn btn-primary">View Cards</a>

                                    @if ($data->flagged == 0)
                                        <a href="#" type="button" class="btn btn-danger" onclick="flagAccount('{{ $data->user_id }}')">Flag Account <img class="spin{{ $data->user_id }} disp-0" src="https://i.ya-webdesign.com/images/loading-gif-png-5.gif" style="width: 20px; height: 20px;"> <i class="fas fa-flag"></i></a>
                                        
                                    @else
                                        <a href="#" type="button" class="btn btn-success" onclick="flagAccount('{{ $data->user_id }}')">Remove flag <img class="spin{{ $data->user_id }} disp-0" src="https://i.ya-webdesign.com/images/loading-gif-png-5.gif" style="width: 20px; height: 20px;"> <i class="fas fa-flag"></i></a>
                                    @endif
                                </td>
                                
                            </tr>
                            
                            
                        @endforeach
                    @else
                        <tr>
                            <td colspan="3" align="center">No record</td>
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