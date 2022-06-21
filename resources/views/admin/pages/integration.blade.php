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
                Third Party Integration
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active">Third Party Integration</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Third Party Integration</h3>

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
                                        <th>Platform</th>
                                        <th>Status</th>
                                        <th>Date Updated</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($data['integration']) > 0)
                                        <?php $i = 1; ?>
                                        @foreach ($data['integration'] as $data)
                                            <tr>
                                                <td>{{ $i++ }}</td>

                                                <td>{{ $data->platform }}</td>
                                                <td>{{ $data->status == true ? 'Active' : 'Disabled' }}</td>

                                                <td>{{ date('d/M/Y', strtotime($data->updated_at)) }}</td>


                                                <form action="{{ route('integration action', $data->id) }}"
                                                    id="integration{{ $data->id }}" method="post">@csrf</form>

                                                <td>{!! $data->status == true ? '<button class="btn btn-danger" onclick="integration(' . $data->id . ')">Disable</button>' : '<button class="btn btn-primary" onclick="integration(' . $data->id . ')">Activate</button>' !!}</td>

                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" align="center">No record available</td>
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
