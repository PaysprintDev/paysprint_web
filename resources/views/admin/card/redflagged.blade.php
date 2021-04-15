@extends('layouts.dashboard')

@section('dashContent')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Added Card
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Added Card</li>
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
                  <th>Name</th>
                  <th>Email</th>
                  <th>Address</th>
                  <th>Wallet Balance</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>

                    @if (count($data['flaggedUsers']) > 0)

                    
                    @php
                        $i = 1;
                    @endphp
                        @foreach ($data['flaggedUsers'] as $data)

                                <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->email }}</td>
                                <td>{{ $data->address.' '.$data->city.' '.$data->state.' '.$data->country }}</td>
                                
                                <td>{{ $data->currencyCode.' '.number_format($data->wallet_balance, 2) }}</td>
                                <td>
                                    <a href="#" type="button" class="btn btn-success" onclick="flagAccount('{{ $data->id }}')">Remove flag <img class="spin{{ $data->id }} disp-0" src="https://i.ya-webdesign.com/images/loading-gif-png-5.gif" style="width: 20px; height: 20px;"> <i class="fas fa-flag"></i></a>
                                </td>
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