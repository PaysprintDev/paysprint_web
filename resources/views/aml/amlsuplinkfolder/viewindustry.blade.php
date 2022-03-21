@extends('layouts.dashboard')

@section('dashContent')


<?php use \App\Http\Controllers\User; ?>
<?php use \App\Http\Controllers\AddCard; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        View Industry
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active"> View Industry</li>
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
                          {{-- {{ dd($data) }} --}}

                          @if($data['client_info'] !== NULL)

                          <tr>
                            <td><strong> Business Name:</strong></td>
                            <td>@if($data['client_info']){{ $data['client_info']->business_name }} @else NA @endif</td>
                          </tr>
                          <tr>
                            <td><strong>Company Registration Number:</strong></td>
                            <td>@if($data['client_info']->companyRegistrationNumber != NULL){{ $data['client_info']->companyRegistrationNumber }} @else NA @endif</td>
                          </tr>
                          <tr>
                            <td><strong>Date Of Incorporation:</strong></td>
        
                            <td>@if($data['client_info']->dateOfIncorporation != NULL){{ $data['client_info']->dateOfIncorporation }} @else NA @endif</td>
                          </tr>
                          <tr>
                            <td><strong>Industry:</strong></td>
        
                            <td>@if($data['client_info']->industry != NULL){{ $data['client_info']->industry }} @else NA @endif</td>
                          </tr>
                          <tr>
                            <td><strong>Type Of Service:</strong></td>
        
                            <td>@if($data['client_info']->type_of_service != NULL){{ $data['client_info']->type_of_service }} @else NA @endif</td>
                          </tr>
                            
                          @else

                      <tr>
                        <td colspan="3" align="center">No linked account</td>
                      </tr>

                      @endif
                            
                  
                </tbody>
              </table>

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


