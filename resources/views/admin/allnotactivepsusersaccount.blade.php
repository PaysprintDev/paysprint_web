a@extends('layouts.dashboard')

@section('dashContent')


    <?php use App\Http\Controllers\User; ?>
    <?php use App\Http\Controllers\Admin; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">




            <h1>
                @if (Request::get('country') != null)
                    All Not Active PaySprint Users In {{ Request::get('country') }}
                @else
                    All Not Active PaySprint Users
                @endif
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active">
                    @if (Request::get('country') != null)
                        All Not Active PaySprint Users In {{ Request::get('country') }}
                    @else
                        All Not Active PaySprint Users
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
                                    <button class="btn btn-secondary btn-block bg-red" onclick="goBack()"><i
                                            class="fas fa-chevron-left"></i> Go back</button>
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
                                        <th>Address</th>
                                        <th>Account Type</th>
                                        <th>Identification</th>
                                        <th>Platform</th>
                                        <th>Date Joined</th>
                                        <th>Status</th>
                                        <th>
                                            <button class="btn btn-danger btn-block" onclick="moveSelected()"
                                                id="btnSelector">Move all selected</button>
                                        </th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <form action="#" method="post" id="submitSelect" enctype="multipart/form-data">
                                    @csrf
                                    <tbody>


                                        @if ($allusersdata = \App\User::where([['country', '=', Request::get('country')], ['countryapproval', '=', 0], ['accountLevel', '=', 0]])->orderBy('nin_front', 'DESC')->get())




                                            @if (count($allusersdata) > 0)
                                                <?php $i = 1; ?>
                                                @foreach ($allusersdata as $datainfo)
                                                    <tr>
                                                        <td>{{ $i++ }}</td>

                                                        <td style="color: green; font-weight: bold;">
                                                            {{ $datainfo->ref_code }}</td>
                                                        <td>{{ $datainfo->name }}</td>
                                                        @if ($user = \App\Admin::where('email', $datainfo->email)->first())
                                                            <td style="color: navy; font-weight: bold;">
                                                                {{ $user->username }}</td>
                                                        @else
                                                            <td>-</td>
                                                        @endif
                                                        <td>{{ $datainfo->email }}</td>
                                                        <td>{{ $datainfo->telephone }}</td>
                                                        <td>{{ $datainfo->address }}</td>
                                                        <td>{{ $datainfo->accountType }}</td>
                                                        <td>

                                                            @if ($datainfo->avatar != null)
                                                                <small style="font-weight: bold;">
                                                                    Selfie : @if ($datainfo->avatar != null)
                                                                        <a href="{{ $datainfo->avatar }}"
                                                                            target="_blank">View Avatar</a>
                                                                    @endif
                                                                </small>


                                                                <hr>
                                                            @endif

                                                            @if ($datainfo->nin_front != null || $datainfo->nin_back != null)
                                                                <small style="font-weight: bold;">
                                                                    Govnt. issued photo ID : @if ($datainfo->nin_front != null)
                                                                        <a href="{{ $datainfo->nin_front }}"
                                                                            target="_blank">Front view</a>
                                                                        @endif | @if ($datainfo->nin_back != null)
                                                                            <a href="{{ $datainfo->nin_back }}"
                                                                                target="_blank">Back view</a>
                                                                        @endif
                                                                </small>



                                                                <hr>
                                                            @endif

                                                            @if ($datainfo->drivers_license_front != null || $datainfo->drivers_license_back != null)
                                                                <small style="font-weight: bold;">
                                                                    Driver's License : @if ($datainfo->drivers_license_front != null)
                                                                        <a href="{{ $datainfo->drivers_license_front }}"
                                                                            target="_blank">Front view</a>
                                                                        @endif | @if ($datainfo->drivers_license_back != null)
                                                                            <a href="{{ $datainfo->drivers_license_back }}"
                                                                                target="_blank">Back view</a>
                                                                        @endif
                                                                </small>


                                                                <hr>
                                                            @endif


                                                            @if ($datainfo->international_passport_front != null || $datainfo->international_passport_back != null)
                                                                <small style="font-weight: bold;">
                                                                    International Passport : @if ($datainfo->international_passport_front != null)
                                                                        <a href="{{ $datainfo->international_passport_front }}"
                                                                            target="_blank">Front view</a>
                                                                        @endif | @if ($datainfo->international_passport_back != null)
                                                                            <a href="{{ $datainfo->international_passport_back }}"
                                                                                target="_blank">Back view</a>
                                                                        @endif
                                                                </small>


                                                                <hr>
                                                            @endif


                                                            @if ($datainfo->incorporation_doc_front != null)
                                                                <small style="font-weight: bold;">
                                                                    Document : @if ($datainfo->incorporation_doc_front != null)
                                                                        <a href="{{ $datainfo->incorporation_doc_front }}"
                                                                            target="_blank">View Document</a>
                                                                    @endif
                                                                </small>


                                                                <hr>
                                                            @endif



                                                        </td>

                                                        <td>{{ $datainfo->platform }}</td>

                                                        <td>
                                                            {{ date('d/M/Y h:i:a', strtotime($datainfo->created_at)) }}
                                                        </td>

                                                        @if ($datainfo->approval == 2 && $datainfo->accountLevel > 0)
                                                            <td style="color: green; font-weight: bold;" align="center">
                                                                Approved</td>
                                                        @elseif ($datainfo->approval == 1 && $datainfo->accountLevel == 2)
                                                            <td style="color: darkorange; font-weight: bold;"
                                                                align="center">Awaiting Approval</td>
                                                        @elseif ($datainfo->approval == 0 && $datainfo->accountLevel > 0)
                                                            <td style="color: navy; font-weight: bold;" align="center">
                                                                Override Level 1</td>
                                                        @else
                                                            <td style="color: red; font-weight: bold;" align="center">Not
                                                                Approved</td>
                                                        @endif

                                                        <td style="color: red; font-weight: bold;" align="center">

                                                            <input type="checkbox" name="checkState" class="checkerInfo"
                                                                value="{{ $datainfo->id }}">

                                                        </td>

                                                        <td align="center">

                                                            <a href="{{ route('user more detail', $datainfo->id) }}"><i
                                                                    class="far fa-eye text-primary" style="font-size: 20px;"
                                                                    title="More details"></i></strong></a>



                                                            {{-- <a href="javascript:void(0)" onclick="checkverification('{{ $datainfo->id }}')"><i class="fas fa-user-check text-success" title="Pass Level 1"></i> <img class="spinvery{{ $datainfo->id }} disp-0" src="https://i.ya-webdesign.com/images/loading-gif-png-5.gif" style="width: 20px; height: 20px;"></a> --}}


                                                            @if ($datainfo->approval == 1 && $datainfo->accountLevel > 0)
                                                                <a href="javascript:void(0)"
                                                                    onclick="disapproveaccount('{{ $datainfo->id }}')"
                                                                    class="text-danger"><i
                                                                        class="fas fa-power-off text-danger"
                                                                        style="font-size: 20px;"
                                                                        title="Disapprove Account"></i> <img
                                                                        class="spindis{{ $datainfo->id }} disp-0"
                                                                        src="https://i.ya-webdesign.com/images/loading-gif-png-5.gif"
                                                                        style="width: 20px; height: 20px;"></a>

                                                                {{-- <a href="javascript:void(0)" onclick="approveaccount('{{ $datainfo->id }}')" class="text-danger"><i class="fas fa-check-square text-success" style="font-size: 20px;" title="Disapprove Account"></i> <img class="spin{{ $datainfo->id }} disp-0" src="https://i.ya-webdesign.com/images/loading-gif-png-5.gif" style="width: 20px; height: 20px;"></a> --}}
                                                            @elseif ($datainfo->approval == 0 && $datainfo->accountLevel > 0)
                                                                <a href="javascript:void(0)"
                                                                    onclick="disapproveaccount('{{ $datainfo->id }}')"
                                                                    class="text-danger"><i
                                                                        class="fas fa-power-off text-danger"
                                                                        style="font-size: 20px;"
                                                                        title="Disapprove Account"></i> <img
                                                                        class="spindis{{ $datainfo->id }} disp-0"
                                                                        src="https://i.ya-webdesign.com/images/loading-gif-png-5.gif"
                                                                        style="width: 20px; height: 20px;"></a> <br>

                                                                <a href="javascript:void(0)"
                                                                    onclick="moveaccount('{{ $datainfo->id }}')"
                                                                    class="text-success"><i
                                                                        class="fas fa-exchange-alt text-success"
                                                                        style="font-size: 20px;"
                                                                        title="Move to Level 2"></i> <img
                                                                        class="spinmove{{ $datainfo->id }} disp-0"
                                                                        src="https://i.ya-webdesign.com/images/loading-gif-png-5.gif"
                                                                        style="width: 20px; height: 20px;"></a>
                                                            @else
                                                                <a href="javascript:void(0)"
                                                                    onclick="approveaccount('{{ $datainfo->id }}')"
                                                                    class="text-primary"><i
                                                                        class="fas fa-check-square text-success"
                                                                        style="font-size: 20px;"
                                                                        title="Approve Account"></i> <img
                                                                        class="spin{{ $datainfo->id }} disp-0"
                                                                        src="https://i.ya-webdesign.com/images/loading-gif-png-5.gif"
                                                                        style="width: 20px; height: 20px;"></a>
                                                            @endif


                                                            <a href="{{ route('send message', 'id=' . $datainfo->id . '&route=') }}"
                                                                class="text-info"><i
                                                                    class="far fa-envelope text-success"
                                                                    style="font-size: 20px;" title="Send Mail"></i></a> <br>


                                                            <a href="javascript:void(0)"
                                                                onclick="$('#launchButton{{ $datainfo->id }}').click()"
                                                                class="text-info"><i class="fas fa-paperclip"
                                                                    style="font-size: 20px;" title="Attachment"></i> </a>



                                                            <a href="javascript:void(0)"
                                                                onclick="closeAccount('{{ $datainfo->id }}')"
                                                                class="text-danger"><i
                                                                    class="far fa-trash-alt text-danger"
                                                                    style="font-size: 20px;" title="Close Account"></i> <img
                                                                    class="spinclose{{ $datainfo->id }} disp-0"
                                                                    src="https://i.ya-webdesign.com/images/loading-gif-png-5.gif"
                                                                    style="width: 20px; height: 20px;"></a>


                                                        </td>


                                                    </tr>


                                                    {{-- Start Modal --}}


                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-primary disp-0" data-toggle="modal"
                                                        data-target="#launchFileUpload{{ $datainfo->id }}"
                                                        id="launchButton{{ $datainfo->id }}">
                                                        Launch demo modal
                                                    </button>


                                                    <form action="{{ route('upload user doc') }}" method="POST"
                                                        enctype="multipart/form-data"
                                                        id="uploadthisform{{ $datainfo->id }}">
                                                        @csrf
                                                        <!-- Modal -->
                                                        <div class="modal fade"
                                                            id="launchFileUpload{{ $datainfo->id }}" tabindex="-1"
                                                            role="dialog" aria-labelledby="launchFileUploadTitle"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered" role="document">

                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h3 class="modal-title"
                                                                            id="exampleModalLongTitle">
                                                                            {{ $datainfo->name }}</h3>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>

                                                                    <div class="modal-body">
                                                                        <input type="file" name="image"
                                                                            id="uploadContent{{ $datainfo->id }}"
                                                                            class="form-control">
                                                                        <input type="hidden" name="user_id"
                                                                            value="{{ $datainfo->id }}">
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">Close</button>
                                                                        <button type="button" class="btn btn-primary"
                                                                            id="uploadBtn{{ $datainfo->id }}"
                                                                            onclick="uploadDocsForUser('uploadthisform', '{{ $datainfo->id }}')">Upload</button>
                                                                    </div>

                                                                </div>


                                                            </div>
                                                        </div>

                                                    </form>




                                                    {{-- End Modal --}}
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



                                                        </td>

                                                        <td>
                                                            {{ date('d/M/Y h:i:a', strtotime($data->created_at)) }}
                                                        </td>

                                                        <td style="color: {{ $data->approval == 1 ? 'green' : 'red' }}; font-weight: bold;"
                                                            align="center">
                                                            {{ $data->approval == 1 ? 'Approved' : 'Not approved' }}
                                                        </td>

                                                        <td align="center">

                                                            <a href="{{ route('user more detail', $data->id) }}"><i
                                                                    class="far fa-eye text-primary" style="font-size: 20px;"
                                                                    title="More details"></i></strong></a>
                                                            <a href="javascript:void(0)"
                                                                onclick="checkverification('{{ $data->id }}')"><i
                                                                    class="fas fa-user-check text-success"
                                                                    title="Check verification"></i> <img
                                                                    class="spinvery{{ $data->id }} disp-0"
                                                                    src="https://i.ya-webdesign.com/images/loading-gif-png-5.gif"
                                                                    style="width: 20px; height: 20px;"></a>
                                                            @if ($data->approval == 1)
                                                                <a href="javascript:void(0)"
                                                                    onclick="approveaccount('{{ $data->id }}')"
                                                                    class="text-danger"><i
                                                                        class="fas fa-power-off text-danger"
                                                                        style="font-size: 20px;" title="Disapprove"></i>
                                                                    <img class="spin{{ $data->id }} disp-0"
                                                                        src="https://i.ya-webdesign.com/images/loading-gif-png-5.gif"
                                                                        style="width: 20px; height: 20px;"></a>
                                                            @else
                                                                <a href="javascript:void(0)"
                                                                    onclick="approveaccount('{{ $data->id }}')"
                                                                    class="text-primary"><i
                                                                        class="far fa-lightbulb text-success"
                                                                        style="font-size: 20px;" title="Approve"></i> <img
                                                                        class="spin{{ $data->id }} disp-0"
                                                                        src="https://i.ya-webdesign.com/images/loading-gif-png-5.gif"
                                                                        style="width: 20px; height: 20px;"></a>
                                                            @endif

                                                            {{-- @if ($data->approval == 1)
                                <button class="btn btn-danger" id="processPay" onclick="approveaccount('{{ $data->id }}')">Disapprove Identification <img class="spin{{ $data->id }} disp-0" src="https://i.ya-webdesign.com/images/loading-gif-png-5.gif" style="width: 20px; height: 20px;"></button>
                                @else
                                <button class="btn btn-primary" id="processPay" onclick="approveaccount('{{ $data->id }}')">Approve Identification <img class="spin{{ $data->id }} disp-0" src="https://i.ya-webdesign.com/images/loading-gif-png-5.gif" style="width: 20px; height: 20px;"></button>
                                @endif --}}


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

                                </form>

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
