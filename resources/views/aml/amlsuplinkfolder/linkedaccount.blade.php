@extends('layouts.dashboard')

@section('dashContent')


<?php use \App\Http\Controllers\User; ?>
<?php use \App\Http\Controllers\AddCard; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Linked Account
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active"> Linked Account</li>
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
                
                </thead>
               
                    <tbody>

                      @if($data['link_accounts'] !== NULL)
                        
                        
                      <tr>
                        <td><strong>Link Ref Code:</strong></td>
                        <td>
                            {{ $data['link_accounts']->link_ref_code }} 
                        </td>
                        

      
                        @if ($merchant = \App\User::where('ref_code', $data['link_accounts']->link_ref_code)->first())

                        @php
                          $userid = $merchant->id
                        @endphp

                        @elseif ($merchant = \App\User::where('ref_code', $data['link_accounts']->link_ref_code)->NULL)

                        @else{
                          No record
                        }
                        
                        @endif


                        <td> <a type="button" href="{{route('user more detail', $userid)}}" class="btn btn-primary btn-block">View details</a></td>

                                         
                      </tr>


                      @else

                      <tr>
                        <td colspan="3" align="center">No linked account</td>
                      </tr>

                      @endif
                     
                     
                    </tbody>
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


