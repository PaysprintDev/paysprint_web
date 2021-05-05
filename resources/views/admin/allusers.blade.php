@extends('layouts.dashboard')

@section('dashContent')


<?php use \App\Http\Controllers\User; ?>
<?php use \App\Http\Controllers\OrganizationPay; ?>
<?php use \App\Http\Controllers\ClientInfo; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         All Users
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">All Users</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">All Users</h3>
              
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
                  <th>Email</th>
                  <th>Identification</th>
                  <th>Date Joined</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    @if (count($allusers) > 0)
                    <?php $i = 1;?>
                        @foreach ($allusers as $data)
                        <tr>
                            <td>{{ $i++ }}</td>
                            
                            <td>{{ $data->ref_code }}</td>
                            <td>{{ $data->name }}</td>
                            <td>{{ $data->email }}</td>
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
                              {{--  <a href="javascript:void()" onclick="checkverification('{{ $data->id }}')"><i class="fas fa-user-check text-success" title="Check verification"></i> <img class="spinvery{{ $data->id }} disp-0" src="https://i.ya-webdesign.com/images/loading-gif-png-5.gif" style="width: 20px; height: 20px;"></a>  --}}
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
                        <td colspan="8" align="center">No record available</td>
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


