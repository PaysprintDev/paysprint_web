@extends('layouts.dashboard')

@section('dashContent')


<?php use \App\Http\Controllers\User; ?>
<?php use \App\Http\Controllers\Admin; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        @if (Request::get('country') != null)
         All Approved In {{ Request::get('country') }}

        @else
         All Approved
            
        @endif
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">
          @if (Request::get('country') != null)
         All Approved In {{ Request::get('country') }}

        @else
         All Approved
            
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
                  <th>Account Type</th>
                  <th>Identification</th>
                  <th>Platform</th>
                  <th>Date Joined</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>

                  @if($allusersdata = \App\User::where('country', Request::get('country'))->where('accountLevel', '>', 0)->where('approval', '!=', 0)->get())


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
                            <td>{{ $datainfo->accountType }}</td>
                            <td>
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
                                

                                
                            </td>

                            <td>{{ $datainfo->platform }}</td>

                            <td>
                                {{ date('d/M/Y h:i:a', strtotime($datainfo->created_at)) }}
                            </td>

                            @if ($datainfo->approval == 1 && $datainfo->accountLevel > 0)

                            <td style="color: green; font-weight: bold;" align="center">Approved</td>
                                
                            @elseif ($datainfo->approval == 0 && $datainfo->accountLevel > 0)
                            <td style="color: navy; font-weight: bold;" align="center">Override Level 1</td>

                            @else
                            <td style="color: red; font-weight: bold;" align="center">Not Approved</td>
                                
                            @endif
                            
                            <td align="center">

                              <a href="{{ route('user more detail', $datainfo->id) }}"><i class="far fa-eye text-primary" style="font-size: 20px;" title="More details"></i></strong></a>  

                               {{-- <a href="javascript:void()" onclick="checkverification('{{ $datainfo->id }}')"><i class="fas fa-user-check text-success" title="Pass Level 1"></i> <img class="spinvery{{ $datainfo->id }} disp-0" src="https://i.ya-webdesign.com/images/loading-gif-png-5.gif" style="width: 20px; height: 20px;"></a>  --}}



                                @if($datainfo->approval == 1 && $datainfo->accountLevel > 0) 
                                
                                <a href="javascript:void()" onclick="approveaccount('{{ $datainfo->id }}')" class="text-danger"><i class="fas fa-power-off text-danger" style="font-size: 20px;" title="Disapprove Account"></i> <img class="spin{{ $datainfo->id }} disp-0" src="https://i.ya-webdesign.com/images/loading-gif-png-5.gif" style="width: 20px; height: 20px;"></a>  
                                
                                
                                @elseif ($datainfo->approval == 0 && $datainfo->accountLevel > 0)

                                <a href="javascript:void()" onclick="approveaccount('{{ $datainfo->id }}')" class="text-danger"><i class="fas fa-power-off text-danger" style="font-size: 20px;" title="Disapprove Account"></i> <img class="spin{{ $datainfo->id }} disp-0" src="https://i.ya-webdesign.com/images/loading-gif-png-5.gif" style="width: 20px; height: 20px;"></a>

                                @else 
                                
                                
                                <a href="javascript:void()" onclick="approveaccount('{{ $datainfo->id }}')" class="text-primary"><i class="far fa-lightbulb text-success" style="font-size: 20px;" title="Approve Account"></i> <img class="spin{{ $datainfo->id }} disp-0" src="https://i.ya-webdesign.com/images/loading-gif-png-5.gif" style="width: 20px; height: 20px;"></a> 
                                
                                
                                @endif


                              
                            </td>


                        </tr>
                        @endforeach

                        

                    @else
                    <tr>
                        <td colspan="9" align="center">No record available</td>
                    </tr>
                    @endif


                    @else
                    @if (count($allusers) > 0)
                    <?php $i = 1;?>
                        @foreach ($allusers as $data)
                        <tr>
                            <td>{{ $i++ }}</td>
                            
                            <td>{{ $data->ref_code }}</td>
                            <td>{{ $data->name }}</td>
                            <td>{{ $data->email }}</td>
                            <td>{{ $data->accountType }}</td>
                            <td>
                                @if (($data->nin_front != null || $data->nin_back != null))
                                <small style="font-weight: bold;">
                                    Govnt. issued photo ID : @if($data->nin_front != null) <a href="{{ $data->nin_front }}" target="_blank">Front view</a> @endif | @if($data->nin_back != null) <a href="{{ $data->nin_back }}" target="_blank">Back view</a> @endif
                                </small>
                                <hr>
                                    
                                @endif

                                @if (($data->drivers_license_front != null || $data->drivers_license_back != null))
                                <small style="font-weight: bold;">
                                    Driver's License : @if($data->drivers_license_front != null) <a href="{{ $data->drivers_license_front }}" target="_blank">Front view</a> @endif | @if($data->drivers_license_back != null) <a href="{{ $data->drivers_license_back }}" target="_blank">Back view</a> @endif
                                </small>
                                <hr>
                                    
                                @endif


                                @if (($data->international_passport_front != null || $data->international_passport_back != null))
                                <small style="font-weight: bold;">
                                    International Passport : @if($data->international_passport_front != null) <a href="{{ $data->international_passport_front }}" target="_blank">Front view</a> @endif | @if($data->international_passport_back != null) <a href="{{ $data->international_passport_back }}" target="_blank">Back view</a> @endif
                                </small>
                                <hr>
                                    
                                @endif
                                

                                
                            </td>

                            <td>
                                {{ date('d/M/Y h:i:a', strtotime($data->created_at)) }}
                            </td>

                            <td style="color: {{ ($data->approval == 1) ? 'green' : 'red' }}; font-weight: bold;" align="center">{{ ($data->approval == 1) ? 'Approved' : 'Not approved' }}</td>
                            
                            <td align="center">

                              <a href="{{ route('user more detail', $data->id) }}"><i class="far fa-eye text-primary" style="font-size: 20px;" title="More details"></i></strong></a>  
                               <a href="javascript:void()" onclick="checkverification('{{ $data->id }}')"><i class="fas fa-user-check text-success" title="Check verification"></i> <img class="spinvery{{ $data->id }} disp-0" src="https://i.ya-webdesign.com/images/loading-gif-png-5.gif" style="width: 20px; height: 20px;"></a> 
                                @if($data->approval == 1) <a href="javascript:void()" onclick="approveaccount('{{ $data->id }}')" class="text-danger"><i class="fas fa-power-off text-danger" style="font-size: 20px;" title="Disapprove"></i> <img class="spin{{ $data->id }} disp-0" src="https://i.ya-webdesign.com/images/loading-gif-png-5.gif" style="width: 20px; height: 20px;"></a>  @else <a href="javascript:void()" onclick="approveaccount('{{ $data->id }}')" class="text-primary"><i class="far fa-lightbulb text-success" style="font-size: 20px;" title="Approve"></i> <img class="spin{{ $data->id }} disp-0" src="https://i.ya-webdesign.com/images/loading-gif-png-5.gif" style="width: 20px; height: 20px;"></a>  @endif

                                {{--  @if ($data->approval == 1)
                                <button class="btn btn-danger" id="processPay" onclick="approveaccount('{{ $data->id }}')">Disapprove Identification <img class="spin{{ $data->id }} disp-0" src="https://i.ya-webdesign.com/images/loading-gif-png-5.gif" style="width: 20px; height: 20px;"></button>
                                @else
                                <button class="btn btn-primary" id="processPay" onclick="approveaccount('{{ $data->id }}')">Approve Identification <img class="spin{{ $data->id }} disp-0" src="https://i.ya-webdesign.com/images/loading-gif-png-5.gif" style="width: 20px; height: 20px;"></button>
                                @endif  --}}

                              
                            </td>


                        </tr>
                        @endforeach

                        

                    @else
                    <tr>
                        <td colspan="9" align="center">No record available</td>
                    </tr>
                    @endif


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


