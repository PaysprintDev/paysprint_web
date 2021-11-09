@extends('layouts.dashboard')

@section('dashContent')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Deleted Card
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Deleted Card</li>
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
                  <th>Name on Card</th>
                  <th>Card Issuer</th>
                  <th>Card Number</th>
                  <th>Expiry Date</th>
                  <th>Card Type</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>

                    @if (count($data['thisuserdeletedCard']) > 0)

                    
                    @php
                        $i = 1;
                    @endphp
                        @foreach ($data['thisuserdeletedCard'] as $data)

                        @php
                            $cardNo = str_repeat("*", strlen($data->card_number)-4) . substr($data->card_number, -4);
                            
                        @endphp

                                <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $data->card_name }}</td>
                                <td>{{ $data->card_provider }}</td>
                                <td>{{ wordwrap($cardNo, 4, '-', true) }}</td>
                                <td>{{ $data->month.'/'.$data->year }}</td>
                                <td>{{ $data->card_type }}</td>
                                <td>
                                  <a type="button" class="btn btn-primary" href="{{ route('user more detail', $data->user_id) }}">User details</a>
                                </td>
                                
                                
                            </tr>
                            
                            
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7" align="center">No record</td>
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