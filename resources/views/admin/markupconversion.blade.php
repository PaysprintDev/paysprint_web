@extends('layouts.dashboard')

@section('dashContent')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Mark Up Conversion
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Mark Up Conversion</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">

                <form action="{{ route('save markup') }}" method="post">
                    @csrf
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group has-success">
                                    <label class="control-label" for="inputSuccess"> Conversion Mark Up (%)</label>
                                    <input type="number" min="0.00" step="0.01" class="form-control" name="percentage"
                                        id="percentage" placeholder="42" required>
                                </div>

                                <p style="font-weight: bold; color: navy">Current Mark Up Value:
                                    {{ $data['percentage'][0]->percentage . '%' }}</p>
                            </div>


                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary btn-block">Submit</button>
                    </div>
                </form>

            </div>
            <!-- /.box -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

@endsection
