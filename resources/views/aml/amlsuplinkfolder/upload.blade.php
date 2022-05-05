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
                Aml Compliance Upload
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active"> Aml Compliance Upload</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            {!! session('msg') !!}
                            <h3 class="box-title"> Aml Compliance Upload</h3>

                        </div>
                        <!-- /.box-header -->
                        <div class="box-body table table-responsive">
                            <form action="" method="post" enctype="multipart/form-data">
                                @csrf
                                <div>
                                    <label class="form-label">File Title:</label>
                                    <input type="text" name="file_title" id="file_title" class="form-control mt-3">
                                </div>

                                <br>

                                <div class="dropzone" id="myDropzone" name="file"></div>

                                <button class="btn btn-primary form-control mt-4" id="submit_all">Upload File</button>
                            </form>
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
