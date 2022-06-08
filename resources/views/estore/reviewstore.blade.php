@extends('layouts.dashboard')

@section('dashContent')
    <?php use App\Http\Controllers\User; ?>
    <?php use App\Http\Controllers\Admin; ?>
    <?php use App\Http\Controllers\OrganizationPay; ?>
    <?php use App\Http\Controllers\ClientInfo; ?>
    <?php use App\Http\Controllers\AnonUsers; ?>


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Review E-Store
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active"> Review E-Store</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            {!! session('msg') !!}
                            <h3 class="box-title"> Review E-Store</h3>

                        </div>
                        <!-- /.box-header -->
                        <div class="box-body table table-responsive">
                            <table class="table table-striped">
                                @php
                                    $counter = 1;
                                @endphp
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Business Logo </th>
                                        <th>Store Name</th>
                                        <th>Store Link</th>
                                        <th>Store Status</th>
                                        <th>Publish State</th>
                                        <th>Date Created</th>
                                        <th>Date Updated</th>
                                        <th colspan="3" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($data['stores']) > 0)
                                        @foreach ($data['stores'] as $value)
                                            @if ($user = \App\User::where('id', $value->merchantId)->first())
                                                <tr>
                                                    <td>{{ $counter++ }}</td>
                                                    <td><img style="width: 45px; height:45px;"
                                                            src="{{ asset($value->businessLogo) }}"></td>
                                                    <td>{{ $user->businessname }}</td>
                                                    <td><a href="{{ route('home') . '/shop/' . $user->businessname }}"
                                                            target="_blank">View store</a></td>
                                                    <td>

                                                        <p
                                                            class="{{ $value->status == 'not active' ? 'text-danger' : 'text-success' }} text-center">
                                                            {{ $value->status }}</p>
                                                        <form action="{{ route('activate store', $value->id) }}"
                                                            method="post" id="activation" class="disp-0">
                                                            @csrf
                                                            <input type="text" name="status" value="{{ $value->status }}">
                                                        </form>
                                                        <small>
                                                            <a href="javascript:void(0)"
                                                                onclick="storeActivation('{{ $value->id }}')"
                                                                id="btns{{ $value->id }}" type="button"
                                                                style="font-weight: bold">{{ $value->status == 'not active' ? 'Click to activate' : 'Click to de-activate' }}</a>
                                                        </small>

                                                    <td>
                                                        <span
                                                            class="{{ $value->publish == false ? 'text-danger' : 'text-success' }}">{{ $value->publish == false ? 'Not published' : 'published' }}</span>

                                                    </td>
                                                    <td>{{ date('d/M/Y', strtotime($value->created_at)) }}</td>
                                                    <td>{{ date('d/M/Y', strtotime($value->updated_at)) }}</td>
                                                    <td>
                                                        <a href="{{ route('send message', 'id=' . $user->id . '&route=') }}"
                                                            class="btn btn-success">Message Merchant</a>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('edit store', $value->id) }}"
                                                            class="btn btn-primary">Edit Store</a>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-danger" id="btns{{ $value->id }}"
                                                            onclick="deleteStore('{{ $value->id }}');">Suspend
                                                            Store</button>
                                                        <form action="{{ route('delete store', $value->id) }}"
                                                            method="post" style="visibility: hidden"
                                                            id="deletestore{{ $value->id }}">
                                                            @csrf
                                                            <input type="hidden" name="storeid"
                                                                value="{{ $value->id }}">
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
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
