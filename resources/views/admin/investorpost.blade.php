@extends('layouts.dashboard')

@section('dashContent')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Create Investor News
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Create Investor News</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">

                <div class="box-body">
                            {!! session('msg') !!}
                    {{-- Provide Form --}}
                    <form role="form" action="{{ route('create investor news') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="box-body">

                            <div class="form-group has-success">
                                <label class="control-label" for="inputSuccess"> Title</label>

                                <input type="text" name="title" id="title" class="form-control">

                            </div>

                            <div class="form-group has-success">
                                <label class="control-label" for="inputSuccess"> Information</label>

                                <textarea name="description" id="description" cols="30" rows="10"
                                    class="form-control"></textarea>

                            </div>

                            <div class="form-group has-success">
                                <label class="control-label" for="inputSuccess"> Upload file <small
                                        class="text-muted">(Optional)</small></label>

                                    <input type="file" name="file" id="file" class="form-control">

                            </div>


                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary btn-block">Submit and Save</button>
                        </div>
                    </form>



                    {{-- List Categories --}}
                    <hr>

                </div>
                <!-- /.box-body -->

            </div>
            <!-- /.box -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

@endsection
