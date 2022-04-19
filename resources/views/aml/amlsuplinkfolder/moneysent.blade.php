@extends('layouts.dashboard')

@section('dashContent')


<?php use \App\Http\Controllers\User; ?>
<?php use \App\Http\Controllers\AddCard; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Money Sent
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active"> Money Sent</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <br>
          <button class="btn btn-secondary btn-block bg-red" onclick="goBack()"><i class="fas fa-chevron-left"></i> Go back</button>
      <br>

      <div class="row">
        <div class="col-xs-12">
          <div class="box">

            <div class="box-body">
              
                  
                <table class="table table-bordered table-striped" id="example3">
                    <thead>
                      <div class="row">
                        <div class="col-md-6">
                          <h3 id="period_start"></h3>
                        </div>
                        <div class="col-md-6">
                          <h3 id="period_stop"></h3>
                        </div>
                      </div>
                      
                    <tr>
                      
                      <th>#</th>    
                      <th>Email</th>    
                      <th>Amount</th>    
                      <th>Status</th>    
                      
                    </tr>
                    </thead>
                    <tbody>

                      @if (count($data['users']) > 0)

                      @php
                        $i = 1;
                      @endphp

                        @foreach ($data['users'] as $user)

                        @if ($userStatement = \App\Statement::where('user_id', '!=', request()->get('search'))->where('reference_code', $user->reference_code)->where('action', 'Wallet credit')->first())

                          @isset($userStatement)
                            <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $userStatement->user_id }}</td>
                            <td>{{ $userStatement->credit }}</td>
                            <td>{{ $userStatement->action }}</td>
                            
                          </tr>


                          @else
                          <tr>
                            <td colspan="4" align="center">No record</td>
                            
                          </tr>

                          @endisset

                          

                          @endif
                        @endforeach
                        
                      @else
                      <tr>
                        <td colspan="4" align="center">No record found</td>
                      </tr>
                      @endif

                      
                     
                        
                </table>

                    </div>
              
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection


