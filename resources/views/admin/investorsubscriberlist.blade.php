@extends('layouts.dashboard')

@section('dashContent')


    <?php use App\Http\Controllers\User; ?>
    <?php use App\Http\Controllers\OrganizationPay; ?>
    <?php use App\Http\Controllers\ClientInfo; ?>
    <?php use App\Http\Controllers\AnonUsers; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                All Investor Subscriber List
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active">All Investor Subscriber List</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">All Investor Subscriber List</h3>

                        </div>
                        <!-- /.box-header -->
                        <div class="box-body table table-responsive">

                            <table class="table table-bordered table-striped" id="example3">

                                <thead>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h3 id="period_start"></h3>
                                        </div>
                                        <div class="col-md-6">
                                            <h3 id="period_stop"></h3>
                                        </div>
                                    </div>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Country</th>
                                        <th>State</th>
                                        <th>City</th>
                                        <th>Date Added</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($data['investors']) > 0)
                                        <?php $i = 1; ?>
                                        @foreach ($data['investors'] as $data)
                                            <tr>
                                                <td>{{ $i++ }}</td>

                                                <td>{{ $data->name }}</td>
                                                <td>{{ $data->email }}</td>
                                                <td>{{ $data->phoneNumber }}</td>
                                                <td>{{ strtoupper($data->country) }}</td>
                                                <td>{{ $data->state }}</td>
                                                <td>{{ $data->city }}</td>
                                                <td>{{ date('d/M/Y', strtotime($data->created_at)) }}</td>

                                            </tr>
                                        @endforeach


                                    @else
                                        <tr>
                                            <td colspan="8" align="center">No record available</td>
                                        </tr>
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
