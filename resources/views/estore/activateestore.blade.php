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
                Activate E-Store
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active"> Activate E-Store</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            {!! session('msg') !!}
                            <h3 class="box-title"> Activate E-Store</h3>

                        </div>
                        <!-- /.box-header -->
                        <div class="box-body table table-responsive">
                            <table class="table table-striped table-responsive">
                                @php
                                    $counter = 1;
                                @endphp
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Store Name</th>
                                        <th>Phone Number</th>
                                        <th>Email </th>
                                        <th>Date Created</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($data['stores']) > 0)
                                        @foreach ($data['stores'] as $value)
                                            @if ($user = \App\User::where('id', $value->user_id)->first())
                                                <tr>
                                                    <td>{{ $counter++ }}</td>
                                                    <td>{{ $user->businessname }}</td>
                                                    <td>{{$user->telephone}}</td>
                                                    <td>{{$user->email}}</td>
                                                    <td>{{ date('d/M/Y', strtotime($value->created_at)) }}</td>
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
