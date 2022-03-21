@extends('layouts.dashboard')

@section('dashContent')


    <?php use App\Http\Controllers\User; ?>
    <?php use App\Http\Controllers\OrganizationPay; ?>
    <?php use App\Http\Controllers\ClientInfo; ?>
    <?php use App\Http\Controllers\AnonUsers; ?>
    <?php use App\Http\Controllers\Statement; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                BVN Verification List Log
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active">BVN Verification List Log</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">BVN Verification List Log</h3>

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
                                        <th>User ID</th>
                                        <th>BVN Number</th>
                                        <th>Account Number</th>
                                        <th>Bank</th>
                                        <th>Account Name</th>
                                        <th>Status</th>
                                        <th>Description</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($data['activity']) > 0)
                                        <?php $i = 1; ?>
                                        @foreach ($data['activity'] as $data)
                                            <tr>
                                                <td>{{ $i++ }}</td>

                                                <td>{{ $data->user_id }}</td>
                                                <td>{{ $data->bvn_number }}</td>
                                                <td>{{ $data->bvn_account_number }}</td>
                                                <td>{{ $data->bvn_bank }}</td>
                                                <td>{{ $data->bvn_account_name }}</td>
                                                <td>{{ $data->status }}</td>
                                                <td>{{ $data->description }}</td>

                                                <td>{{ date('d/M/Y', strtotime($data->created_at)) }}</td>
                                                
                                            </tr>
                                        @endforeach


                                    @else
                                        <tr>
                                             <td colspan="9" align="center">No record available</td>
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
