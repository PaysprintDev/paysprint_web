@extends('layouts.dashboard')

@section('dashContent')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Edit Referrer Agent
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Edit Referrer Agent</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">

                <div class="box-body">

                    {{-- Provide Form --}}
                    <form role="form" action="{{ route('edit account for referrer') }}" method="POST">
                        @csrf
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group has-success">
                                        <label class="control-label" for="inputSuccess"> Name</label>
                                        <input type="hidden" class="form-control" name="ref_code" id="inputSuccess"
                                            value="{{ $data['user']->ref_code }}">
                                        <input type="text" class="form-control" name="name" id="inputSuccess"
                                            value="{{ $data['user']->name }}">
                                    </div>
                                </div>

                            </div>


                            <div class="form-group has-success">
                                <label class="control-label" for="inputSuccess"> Email</label>
                                <input type="email" class="form-control" name="email" id="inputSuccess"
                                    value="{{ $data['user']->email }}">

                            </div>


                            <div class="form-group has-success">
                                <label class="control-label" for="inputSuccess"> Country</label>
                                <select class="form-control" name="country" id="inputSuccess">
                                    <option value="">Select Country</option>
                                    @if (count($data['allthecountries']) > 0)
                                        @foreach ($data['allthecountries'] as $countries)
                                            <option value="{{ $countries->name }}"
                                                {{ $data['user']->country == $countries->name ? 'selected' : '' }}>
                                                {{ $countries->name }}</option>
                                        @endforeach
                                    @else
                                        <option value="">No available country</option>
                                    @endif

                                </select>

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
