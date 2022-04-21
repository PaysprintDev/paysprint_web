@extends('layouts.dashboard')

@section('dashContent')


    <?php use App\Http\Controllers\User; ?>
    <?php use App\Http\Controllers\Admin; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Cash Advance Merchants
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active">
                    Cash Advance Merchants
                </li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <div class="row">
                                <div class="col-md-2 col-md-offset-0">
                                    <button class="btn btn-secondary btn-block bg-red" onclick="goBack()"><i
                                            class="fas fa-chevron-left"></i> Go back</button>
                                </div>
                            </div>

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
                                        <th>Account No.</th>
                                        <th>Business Name</th>
                                        <th>Name</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Telephone</th>
                                        <th>Address</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @if (count($data['cashadvance']) > 0)

                                        @foreach ($data['cashadvance'] as $user)

                                            @if ($allusersdata = \App\User::where('id', $user->merchantId)->first())


                                                <?php $i = 1; ?>
                                                <tr>
                                                    <td>{{ $i++ }}</td>

                                                    <td style="color: green; font-weight: bold;">
                                                        {{ $allusersdata->ref_code }}
                                                    </td>
                                                    <td>{{ $allusersdata->businessname }}</td>
                                                    <td>{{ $allusersdata->name }}</td>
                                                    @if ($user = \App\Admin::where('email', $allusersdata->email)->first())
                                                        <td style="color: navy; font-weight: bold;">
                                                            {{ $user->username }}
                                                        </td>
                                                    @else
                                                        <td>-</td>
                                                    @endif
                                                    <td>{{ $allusersdata->email }}</td>
                                                    <td>{{ $allusersdata->telephone }}</td>
                                                    <td>{{ $allusersdata->address }}</td>


                                                </tr>


                                            @endif

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
