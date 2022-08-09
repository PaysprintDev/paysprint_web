@extends('layouts.dashboard')

@section('dashContent')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Create Support Agent
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Create Support Agent</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">

                <div class="box-body">

                    {{-- Provide Form --}}
                    <form role="form" action="{{ route('generate account for support') }}" method="POST">
                        @csrf
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group has-success">
                                        <label class="control-label" for="inputSuccess"> First Name</label>
                                        <input type="hidden" class="form-control" name="user_id" id="inputSuccess"
                                            value="{{ 'Paysprint_' . mt_rand(0001, 9999) }}">
                                        <input type="text" class="form-control" name="firstname" id="inputSuccess">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group has-success">
                                        <label class="control-label" for="inputSuccess"> Last Name</label>
                                        <input type="text" class="form-control" name="lastname" id="inputSuccess">
                                    </div>
                                </div>
                            </div>


                            <div class="form-group has-success">
                                <label class="control-label" for="inputSuccess"> Email</label>
                                <input type="email" class="form-control" name="email" id="inputSuccess">

                            </div>

                            <div class="form-group has-success">
                                <label class="control-label" for="inputSuccess"> Role</label>
                                <select class="form-control" name="role" id="inputSuccess">
                                    <option value="">Select Role</option>
                                    <option value="Super">Super Admin</option>
                                    <option value="Access to Level 1 only">Access to Level 1 only</option>
                                    <option value="Access to Level 1 and 2 only">Access to Level 1 and 2 only</option>
                                    <option value="Customer Marketing">Customer Marketing</option>
                                    <option value="Aml compliance">Aml compliance</option>
                                    <option value="estore manager">Estore Manager</option>
                                    <option value="Customer Success">Customer Success</option>
                                </select>

                            </div>


                            <div class="form-group has-success">
                                <label class="control-label" for="inputSuccess"> Country</label>
                                <select class="form-control" name="country" id="inputSuccess">
                                    <option value="">Select Country</option>
                                    @if (count($data['allthecountries']) > 0)
                                        @foreach ($data['allthecountries'] as $countries)
                                            <option value="{{ $countries->name }}">{{ $countries->name }}</option>
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
