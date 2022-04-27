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
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Store Name</th>
                                        <th>Store Link</th>
                                        <th>Store Status</th>
                                        <th>Publish State</th>
                                        <th>Date Created</th>
                                        <th>Date Updated</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Skima Store</td>
                                        <td>paysprint.ca/store/skimastore</td>
                                        <td>Published</td>
                                        <td>Active</td>
                                        <td>27/04/2022</td>
                                        <td>27/04/2022</td>
                                        <td>
                                            <a href="" class="btn btn-success">Message</a>
                                            <br>
                                            <a href="" class="btn btn-primary">Edit</a>
                                            <a href="" class="btn btn-danger mt-2">Delete</a>
                                        </td>
                                    </tr>
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
