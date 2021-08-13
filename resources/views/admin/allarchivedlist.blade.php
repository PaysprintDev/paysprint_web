@extends('layouts.dashboard')

@section('dashContent')


<?php use \App\Http\Controllers\User; ?>
<?php use \App\Http\Controllers\UserClosed; ?>
<?php use \App\Http\Controllers\Admin; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        @if (Request::get('country') != null)
         All Archived {{ strtoupper(Request::get('user')) }} In {{ Request::get('country') }}

        @else
         All Archived {{ strtoupper(Request::get('user')) }}
            
        @endif
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">
          @if (Request::get('country') != null)
         All Archived {{ strtoupper(Request::get('user')) }} In {{ Request::get('country') }}

        @else
         All Archived {{ strtoupper(Request::get('user')) }}
            
        @endif
        </li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <div class="row">
                <div class="col-md-2 col-md-offset-0">
                <button class="btn btn-secondary btn-block bg-red" onclick="goBack()"><i class="fas fa-chevron-left"></i> Go back</button>
            </div>
            </div>
              
            </div>
            <!-- /.box-header -->
            <div class="box-body table table-responsive">

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
                  <th>S/N</th>
                  <th>Account No.</th>
                  <th>Name</th>
                  <th>Username</th>
                  <th>Email</th>
                  <th>Telephone</th>
                  <th>Account Type</th>
                  <th>Identification</th>
                  <th>Platform</th>
                </tr>
                </thead>
                <tbody>

                    @if (Request::get('user') == "consumers")

                        @php
                            $allusersdata = \App\User::where('accountType', 'Individual')->where('country', Request::get('country'))->where('archive', 1)->get();
                        @endphp
                        
                    @else

                        @php
                            $allusersdata = \App\User::where('accountType', 'Merchant')->where('country', Request::get('country'))->where('archive', 1)->get();
                        @endphp
                    @endif
                    


                    @if (count($allusersdata) > 0)
                        <?php $i = 1;?>
                        @foreach ($allusersdata as $datainfo)
                        <tr>
                            <td>{{ $i++ }}</td>
                            
                            <td style="color: green; font-weight: bold;">{{ $datainfo->ref_code }}</td>
                            <td>{{ $datainfo->name }}</td>
                            @if($user = \App\Admin::where('email', $datainfo->email)->first())
                              <td style="color: navy; font-weight: bold;">{{ $user->username }}</td>
                            @else
                              <td>-</td>
                            @endif
                            <td>{{ $datainfo->email }}</td>
                            <td>{{ $datainfo->telephone }}</td>
                            <td>{{ $datainfo->accountType }}</td>
                            <td>

                                @if (($datainfo->avatar != null))
                                <small style="font-weight: bold;">
                                    Selfie : @if($datainfo->avatar != null) <a href="{{ $datainfo->avatar }}" target="_blank">View Avatar</a> @endif
                                </small>
                                <hr>
                                    
                                @endif

                                @if (($datainfo->nin_front != null || $datainfo->nin_back != null))
                                <small style="font-weight: bold;">
                                    Govnt. issued photo ID : @if($datainfo->nin_front != null) <a href="{{ $datainfo->nin_front }}" target="_blank">Front view</a> @endif | @if($datainfo->nin_back != null) <a href="{{ $datainfo->nin_back }}" target="_blank">Back view</a> @endif
                                </small>
                                <hr>
                                    
                                @endif

                                @if (($datainfo->drivers_license_front != null || $datainfo->drivers_license_back != null))
                                <small style="font-weight: bold;">
                                    Driver's License : @if($datainfo->drivers_license_front != null) <a href="{{ $datainfo->drivers_license_front }}" target="_blank">Front view</a> @endif | @if($datainfo->drivers_license_back != null) <a href="{{ $datainfo->drivers_license_back }}" target="_blank">Back view</a> @endif
                                </small>
                                <hr>
                                    
                                @endif


                                @if (($datainfo->international_passport_front != null || $datainfo->international_passport_back != null))
                                <small style="font-weight: bold;">
                                    International Passport : @if($datainfo->international_passport_front != null) <a href="{{ $datainfo->international_passport_front }}" target="_blank">Front view</a> @endif | @if($datainfo->international_passport_back != null) <a href="{{ $datainfo->international_passport_back }}" target="_blank">Back view</a> @endif
                                </small>
                                <hr>
                                    
                                @endif


                                @if (($datainfo->incorporation_doc_front != null))
                                <small style="font-weight: bold;">
                                    Document : @if($datainfo->incorporation_doc_front != null) <a href="{{ $datainfo->incorporation_doc_front }}" target="_blank">View Document</a> @endif
                                </small>
                                <hr>
                                    
                                @endif
                                

                                
                            </td>

                            <td>{{ $datainfo->platform }}</td>



                        </tr>
                        @endforeach

                        

                    @else
                    <tr>
                        <td colspan="9" align="center">No record available</td>
                    </tr>
                    @endif




                </tbody>
              </table>
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


