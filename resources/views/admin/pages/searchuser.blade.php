@extends('layouts.dashboard')

@section('dashContent')


<?php use \App\Http\Controllers\User; ?>
<?php use App\Http\Controllers\Admin; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
          User Information
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active"> User Information</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">User Information</h3>

            </div>
            <!-- /.box-header -->
            <div class="box-body table table-responsive">

              <table class="table table-bordered table-striped" @if(session('role') == 'Customer Success') id="example1" @else id="example3" @endif>

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
                          <th>Address</th>
                          <th>Account Type</th>
                          <th>Identification</th>
                          <th>Platform</th>
                          <th>Date Joined</th>
                          <th>Status</th>
                          <th>Action</th>
                      </tr>
                  </thead>
                  <tbody>


                      @if ($allusersdata = \App\User::where('country', Request::get('country'))->paginate(100))


                          @if (count($searchuser) > 0)
                              <?php $i = 1; ?>
                              @foreach ($searchuser as $item)
                                  <tr>
                                      <td>{{ $i++ }}</td>

                                      <td style="color: green; font-weight: bold;">{{ $item->ref_code }}
                                      </td>
                                      <td>{{ $item->name }}</td>
                                      @if ($user = \App\Admin::where('email', $item->email)->first())
                                          <td style="color: navy; font-weight: bold;">{{ $user->username }}
                                          </td>
                                      @else
                                          <td>-</td>
                                      @endif
                                      <td>{{ $item->email }}</td>
                                      <td>{{ $item->telephone }}</td>
                                      <td>{{ $item->address }}</td>
                                      <td>{{ $item->accountType }}</td>
                                      <td>
                                          @if ($item->avatar != null)
                                              <small style="font-weight: bold;">
                                                  Selfie : @if ($item->avatar != null)
                                                      <a href="{{ $item->avatar }}"
                                                          target="_blank">View Avatar</a>
                                                  @endif
                                              </small>
                                              <hr>
                                          @endif


                                          @if ($item->nin_front != null || $item->nin_back != null)
                                              <small style="font-weight: bold;">
                                                  Govnt. issued photo ID : @if ($item->nin_front != null)
                                                      <a href="{{ $item->nin_front }}"
                                                          target="_blank">Front view</a>
                                                      @endif | @if ($item->nin_back != null)
                                                          <a href="{{ $item->nin_back }}"
                                                              target="_blank">Back view</a>
                                                      @endif
                                              </small>
                                              <hr>
                                          @endif

                                          @if ($item->drivers_license_front != null || $item->drivers_license_back != null)
                                              <small style="font-weight: bold;">
                                                  Driver's License : @if ($item->drivers_license_front != null)
                                                      <a href="{{ $item->drivers_license_front }}"
                                                          target="_blank">Front view</a>
                                                      @endif | @if ($item->drivers_license_back != null)
                                                          <a href="{{ $item->drivers_license_back }}"
                                                              target="_blank">Back view</a>
                                                      @endif
                                              </small>
                                              <hr>
                                          @endif


                                          @if ($item->international_passport_front != null || $item->international_passport_back != null)
                                              <small style="font-weight: bold;">
                                                  International Passport : @if ($item->international_passport_front != null)
                                                      <a href="{{ $item->international_passport_front }}"
                                                          target="_blank">Front view</a>
                                                      @endif | @if ($item->international_passport_back != null)
                                                          <a href="{{ $item->international_passport_back }}"
                                                              target="_blank">Back view</a>
                                                      @endif
                                              </small>
                                              <hr>
                                          @endif


                                          @if ($item->incorporation_doc_front != null)
                                              <small style="font-weight: bold;">
                                                  Document : @if ($item->incorporation_doc_front != null)
                                                      <a href="{{ $item->incorporation_doc_front }}"
                                                          target="_blank">View Document</a>
                                                  @endif
                                              </small>
                                              <hr>
                                          @endif

                                          @if ($item->idvdoc != null)
                                                  <small style="font-weight: bold;">
                                                      Other Document : @if ($item->idvdoc != null)
                                                          <a href="{{ $item->idvdoc }}"
                                                              target="_blank">View Document</a>
                                                          @endif
                                                  </small>
                                                  <hr>
                                              @endif





                                      </td>

                                      <td>{{ $item->platform }}</td>

                                      <td>
                                          {{ date('d/M/Y h:i:a', strtotime($item->created_at)) }}
                                      </td>


                                      @if ($item->approval == 2 && $item->accountLevel > 0 && $item->account_check == 2)
                                          <td style="color: green; font-weight: bold;" align="center">Approved
                                          </td>
                                      @elseif ($item->approval == 2 && $item->accountLevel > 0 && $item->account_check == 1)
                                          <td style="color: darkorange; font-weight: bold;" align="center">
                                              Awaiting Approval</td>
                                      @elseif ($item->approval == 2 && $item->accountLevel > 0 && $item->account_check == 0)
                                          <td style="color: darkorange; font-weight: bold;" align="center">
                                              Awaiting Approval</td>
                                      @elseif ($item->approval == 1 && $item->accountLevel > 0)
                                          <td style="color: darkorange; font-weight: bold;" align="center">
                                              Awaiting Approval</td>
                                      @elseif ($item->approval == 0 && $item->accountLevel > 0)
                                          <td style="color: navy; font-weight: bold;" align="center">Override
                                              Level 1</td>
                                      @else
                                          <td style="color: red; font-weight: bold;" align="center">Not
                                              Approved</td>
                                      @endif



                                      <td align="center">

                                          <a href="{{ route('user more detail', $item->id) }}"><i
                                                  class="far fa-eye text-primary" style="font-size: 20px;"
                                                  title="More details"></i></strong></a>

                                          @if ($item->approval == 1 && $item->accountLevel > 0)
                                              <a href="javascript:void()"
                                                  onclick="approveaccount('{{ $item->id }}')"
                                                  class="text-danger"><i
                                                      class="fas fa-power-off text-danger"
                                                      style="font-size: 20px;" title="Disapprove"></i> <img
                                                      class="spin{{ $item->id }} disp-0"
                                                      src="https://i.ya-webdesign.com/images/loading-gif-png-5.gif"
                                                      style="width: 20px; height: 20px;"></a>
                                          @elseif ($item->approval == 0 && $item->accountLevel > 0)
                                              <a href="javascript:void()"
                                                  onclick="approveaccount('{{ $item->id }}')"
                                                  class="text-danger"><i
                                                      class="fas fa-power-off text-danger"
                                                      style="font-size: 20px;" title="Disapprove"></i> <img
                                                      class="spin{{ $item->id }} disp-0"
                                                      src="https://i.ya-webdesign.com/images/loading-gif-png-5.gif"
                                                      style="width: 20px; height: 20px;"></a>
                                          @else
                                              <a href="javascript:void()"
                                                  onclick="approveaccount('{{ $item->id }}')"
                                                  class="text-primary"><i
                                                      class="far fa-lightbulb text-success"
                                                      style="font-size: 20px;" title="Approve"></i> <img
                                                      class="spin{{ $item->id }} disp-0"
                                                      src="https://i.ya-webdesign.com/images/loading-gif-png-5.gif"
                                                      style="width: 20px; height: 20px;"></a>
                                          @endif

                                           <a href="javascript:void(0)"
                                              onclick="$('#launchButton{{ $item->id }}').click()"
                                              class="text-info"><i class="fas fa-paperclip"
                                                  style="font-size: 20px;" title="Attachment"></i> </a>

                                          <a href="{{ route('send message', 'id=' . $item->id . '&route=') }}"
                                              class="text-info"><i class="far fa-envelope text-success"
                                                  style="font-size: 20px;" title="Send Mail"></i></a>

                                          <a href="javascript:void()"
                                              onclick="closeAccount('{{ $item->id }}')"
                                              class="text-danger"><i class="far fa-trash-alt text-danger"
                                                  style="font-size: 20px;" title="Close Account"></i> <img
                                                  class="spinclose{{ $item->id }} disp-0"
                                                  src="https://i.ya-webdesign.com/images/loading-gif-png-5.gif"
                                                  style="width: 20px; height: 20px;"></a>

                                      </td>


                                  </tr>

                                  {{-- @include('admin.uploaddocmodal') --}}

                              @endforeach
                          @else
                              <tr>
                                  <td colspan="11" align="center">No record available</td>
                              </tr>
                          @endif
                      @else
                          @if (count($allusers) > 0)
                              <?php $i = 1; ?>
                              @foreach ($allusers as $data)

                                  <tr>
                                      <td>{{ $i++ }}</td>

                                      <td>{{ $data->ref_code }}</td>
                                      <td>{{ $data->name }}</td>
                                      <td>{{ $data->email }}</td>
                                      <td>{{ $data->accountType }}</td>
                                      <td>
                                          @if ($data->nin_front != null || $data->nin_back != null)
                                              <small style="font-weight: bold;">
                                                  Govnt. issued photo ID : @if ($data->nin_front != null)
                                                      <a href="{{ $data->nin_front }}"
                                                          target="_blank">Front view</a>
                                                      @endif | @if ($data->nin_back != null)
                                                          <a href="{{ $data->nin_back }}"
                                                              target="_blank">Back view</a>
                                                      @endif
                                              </small>
                                              <hr>
                                          @endif

                                          @if ($data->drivers_license_front != null || $data->drivers_license_back != null)
                                              <small style="font-weight: bold;">
                                                  Driver's License : @if ($data->drivers_license_front != null)
                                                      <a href="{{ $data->drivers_license_front }}"
                                                          target="_blank">Front view</a>
                                                      @endif | @if ($data->drivers_license_back != null)
                                                          <a href="{{ $data->drivers_license_back }}"
                                                              target="_blank">Back view</a>
                                                      @endif
                                              </small>
                                              <hr>
                                          @endif


                                          @if ($data->international_passport_front != null || $data->international_passport_back != null)
                                              <small style="font-weight: bold;">
                                                  International Passport : @if ($data->international_passport_front != null)
                                                      <a href="{{ $data->international_passport_front }}"
                                                          target="_blank">Front view</a>
                                                      @endif | @if ($data->international_passport_back != null)
                                                          <a href="{{ $data->international_passport_back }}"
                                                              target="_blank">Back view</a>
                                                      @endif
                                              </small>
                                              <hr>
                                          @endif


                                          @if ($data->idvdoc != null || $data->incorporation_doc_front != null)
                                              <small style="font-weight: bold;">
                                                  Other Document : @if ($data->idvdoc != null)
                                                      <a href="{{ $data->idvdoc }}"
                                                          target="_blank">View Doc 1</a>
                                                      @endif | @if ($data->incorporation_doc_front != null)
                                                          <a href="{{ $data->incorporation_doc_front }}"
                                                              target="_blank">View Doc 2</a>
                                                      @endif
                                              </small>
                                              <hr>
                                          @endif



                                      </td>

                                      <td>
                                          {{ date('d/M/Y h:i:a', strtotime($data->created_at)) }}
                                      </td>

                                      <td style="color: {{ $data->approval == 1 ? 'green' : 'red' }}; font-weight: bold;"
                                          align="center">
                                          {{ $data->approval == 1 ? 'Approved' : 'Not approved' }}</td>

                                      <td align="center">

                                          <a href="{{ route('user more detail', $data->id) }}"><i
                                                  class="far fa-eye text-primary" style="font-size: 20px;"
                                                  title="More details"></i></strong></a>
                                          <a href="javascript:void()"
                                              onclick="checkverification('{{ $data->id }}')"><i
                                                  class="fas fa-user-check text-success"
                                                  title="Check verification"></i> <img
                                                  class="spinvery{{ $data->id }} disp-0"
                                                  src="https://i.ya-webdesign.com/images/loading-gif-png-5.gif"
                                                  style="width: 20px; height: 20px;"></a>
                                          @if ($data->approval == 1)
                                              <a href="javascript:void()"
                                                  onclick="approveaccount('{{ $data->id }}')"
                                                  class="text-danger"><i
                                                      class="fas fa-power-off text-danger"
                                                      style="font-size: 20px;" title="Disapprove"></i> <img
                                                      class="spin{{ $data->id }} disp-0"
                                                      src="https://i.ya-webdesign.com/images/loading-gif-png-5.gif"
                                                      style="width: 20px; height: 20px;"></a>
                                          @else
                                              <a href="javascript:void()"
                                                  onclick="approveaccount('{{ $data->id }}')"
                                                  class="text-primary"><i
                                                      class="far fa-lightbulb text-success"
                                                      style="font-size: 20px;" title="Approve"></i> <img
                                                      class="spin{{ $data->id }} disp-0"
                                                      src="https://i.ya-webdesign.com/images/loading-gif-png-5.gif"
                                                      style="width: 20px; height: 20px;"></a>
                                          @endif

                        

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

              <nav aria-label="...">
                          <ul class="pagination pagination-md">

                              <li class="page-item">
                                  {{ $allusersdata->appends(['country' => Request::get('country')])->links() }}

                              </li>
                          </ul>
                      </nav>
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


