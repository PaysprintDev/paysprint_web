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
                                    $counter=1;
                                @endphp
                                <thead>
                                    <tr>
                                        <th>S/N</th>
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
                                    @if(count($data['stores']) > 0)
                                        @foreach ( $data['stores'] as $value )

                                        @if($user = \App\User::where('id', $value->merchantId)->first())

                                    <tr>
                                        <td>{{$counter++ }}</td>
                                        <td>{{ $user->businessname }}</td>
                                        <td><a href="{{ route('home').'/shop/'.$user->businessname }}" target="_blank">View store</a></td>
                                        <td>

                                            <span class="{{ $value->status == 'not active' ? 'text-danger' : 'text-success' }}">{{ $value->status}}</span>
                                            
                                        <td>
                                            <span class="{{ $value->publish == false ? 'text-danger' : 'text-success' }}">{{ $value->publish == false ? 'Not published' : 'published' }}</span>
                                               
                                        </td>
                                        <td>{{ date('d/M/Y', strtotime($value->created_at)) }}</td>
                                        <td>{{ date('d/M/Y', strtotime($value->updated_at)) }}</td>
                                        <td>
                                            <a href="" class="btn btn-success">Message</a>
                                        </td>
                                        <td>
                                            <a href="" class="btn btn-primary">Edit</a>
                                        </td>
                                        <td>
                                            <a href="" class="btn btn-danger mt-2">Delete</a>
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
