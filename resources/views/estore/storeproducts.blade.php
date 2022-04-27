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
                Products Category
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active"> Products Category</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            {!! session('msg') !!}
                            <h3 class="box-title"> Products Category</h3>

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
                                        <th>Category Name</th>
                                        <th>Date Added</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($data['products']) > 0)
                                        @foreach ( $data['products'] as $products )
                                            
                                        
                                    <tr>
                                        <td>{{ $counter ++ }}</td>
                                        <td>{{ $products['category']}}</td>
                                        <td>{{ $products['created_at']}}</td>
                                        <td><a href="" class="btn btn-success">Accept</a></td>
                                        <td><a href="" class="btn btn-primary">Edit</a></td>
                                        <td><a href="" class="btn btn-danger">Delete</a></td>
                                    </tr>
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
