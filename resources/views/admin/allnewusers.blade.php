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
         All {{ strtoupper(Request::get('user')) }} Users In {{ Request::get('country') }}

        @else
         All {{ strtoupper(Request::get('user')) }} Users
            
        @endif
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">
          @if (Request::get('country') != null)
         All {{ strtoupper(Request::get('user')) }} Users In {{ Request::get('country') }}

        @else
         All {{ strtoupper(Request::get('user')) }} Users
            
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
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>

                    @if (Request::get('user') == "new")

                        @php
                            $allusersdata = \App\User::where('accountType', 'Individual')->where('country', Request::get('country'))->where('created_at', '>=', date('Y-m-d', strtotime('-30 days')))->get();
                        @endphp
                        
                    @else

                        @php
                            $allusersdata = \App\User::where('accountType', 'Individual')->where('country', Request::get('country'))->where('created_at', '<', date('Y-m-d', strtotime('-30 days')))->get()
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

                            @if ($datainfo->approval == 2 && $datainfo->accountLevel > 0)

                            <td style="color: green; font-weight: bold;" align="center">Approved</td>

                            @elseif ($datainfo->approval == 1 && $datainfo->accountLevel > 0)

                            <td style="color: darkorange; font-weight: bold;" align="center">Awaiting Approval</td>
                                
                            @elseif ($datainfo->approval == 0 && $datainfo->accountLevel > 0)
                            
                            <td style="color: navy; font-weight: bold;" align="center">Override Level 1</td>

                            @else
                            <td style="color: red; font-weight: bold;" align="center">Not Approved</td>
                                
                            @endif

                            <td align="center">

                              <a href="{{ route('user more detail', $datainfo->id) }}"><i class="far fa-eye text-primary" style="font-size: 20px;" title="More details"></i></strong></a> 

                                @if($datainfo->approval == 1 && $datainfo->accountLevel > 0) 

                                <a href="javascript:void(0)" onclick="disapproveaccount('{{ $datainfo->id }}')" class="text-danger"><i class="fas fa-power-off text-danger" style="font-size: 20px;" title="Disapprove Account"></i> <img class="spindis{{ $datainfo->id }} disp-0" src="https://i.ya-webdesign.com/images/loading-gif-png-5.gif" style="width: 20px; height: 20px;"></a>
                                
                                @elseif ($datainfo->approval == 0 && $datainfo->accountLevel > 0)

                                <a href="javascript:void(0)" onclick="disapproveaccount('{{ $datainfo->id }}')" class="text-danger"><i class="fas fa-power-off text-danger" style="font-size: 20px;" title="Disapprove Account"></i> <img class="spindis{{ $datainfo->id }} disp-0" src="https://i.ya-webdesign.com/images/loading-gif-png-5.gif" style="width: 20px; height: 20px;"></a> <br>


                                <a href="javascript:void(0)" onclick="moveaccount('{{ $datainfo->id }}')" class="text-success"><i class="fas fa-exchange-alt text-success" style="font-size: 20px;" title="Move to Level 2"></i> <img class="spinmove{{ $datainfo->id }} disp-0" src="https://i.ya-webdesign.com/images/loading-gif-png-5.gif" style="width: 20px; height: 20px;"></a>

                                @else 
                                
                                
                                <a href="javascript:void(0)" onclick="approveaccount('{{ $datainfo->id }}')" class="text-primary"><i class="fas fa-check-square text-success" style="font-size: 20px;" title="Approve Account"></i> <img class="spin{{ $datainfo->id }} disp-0" src="https://i.ya-webdesign.com/images/loading-gif-png-5.gif" style="width: 20px; height: 20px;"></a> 
                                
                                
                                @endif



                                <a href="{{ route('send message', 'id='.$datainfo->id) }}" class="text-info"><i class="far fa-envelope text-success" style="font-size: 20px;" title="Send Mail"></i></a> <br>


                                <a href="javascript:void(0)" onclick="closeAccount('{{ $datainfo->id }}')" class="text-danger"><i class="far fa-trash-alt text-danger" style="font-size: 20px;" title="Close Account"></i> <img class="spinclose{{ $datainfo->id }} disp-0" src="https://i.ya-webdesign.com/images/loading-gif-png-5.gif" style="width: 20px; height: 20px;"></a> 

                              
                            </td>



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


