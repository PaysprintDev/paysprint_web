@extends('layouts.dashboard')

@section('dashContent')


    <?php use App\Http\Controllers\User; ?>
    <?php use App\Http\Controllers\OrganizationPay; ?>
    <?php use App\Http\Controllers\ClientInfo; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                All PaySprint Merchants
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active">All PaySprint Merchants</li>
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
                                        <th>Name</th>
                                        <th>Legal Entity Name</th>
                                        <th>Industry</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Category</th>
                                        <th>Country</th>
                                        <th>City</th>
                                        <th>Date of Account Opening</th>
                                        <th>PS Acct. Number</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($data) > 0)
                                        <?php $i = 1;
                                        $accountState = 'Closed account'; ?>
                                        @foreach ($data as $dataItem)
                                            @if ($archivedMerchant = \App\User::where('email', $dataItem->email)->where('countryapproval', 1)->where('archive', 1)->first())
                                                @php
                                                    $accountState = 'Archived';
                                                @endphp
                                            @endif

                                            @if ($existingMerchant = \App\User::where('email', $dataItem->email)->where('archive', 0)->where('countryapproval', 1)->where('created_at', '<', date('Y-m-d', strtotime('-30 days')))->first())
                                                @php
                                                    $accountState = 'Existing';
                                                @endphp
                                            @endif

                                            @if ($newUsers = \App\User::where('email', $dataItem->email)->where('archive', 0)->where('countryapproval', 1)->where('created_at', '>=', date('Y-m-d', strtotime('-30 days')))->first())
                                                @php
                                                    $accountState = 'New';
                                                @endphp
                                            @endif

                                            <tr>
                                                <td>{{ $i++ }}</td>

                                                <td>{{ $dataItem->firstname.' '.$dataItem->lastname }}</td>
                                                <td>{{ $dataItem->business_name }}</td>
                                                <td>{{ $dataItem->industry }}</td>
                                                <td>{{ $dataItem->email }}</td>
                                                <td>{{ $dataItem->telephone }}</td>
                                                <td>{{ $accountState }}</td>
                                                <td>{{ $dataItem->country }}</td>
                                                <td>{{ $dataItem->city }}</td>
                                                <td>{{ date('d/M/Y', strtotime($dataItem->created_at)) }}</td>
                                                <td>{{ $dataItem->user_id }}</td>

                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="11" align="center">No record available</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>





                        </div>

                        <nav aria-label="...">
                                        <ul class="pagination pagination-md">

                                            <li class="page-item">
                                                {{ $data->links() }}
                                            </li>
                                        </ul>
                                    </nav>
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
