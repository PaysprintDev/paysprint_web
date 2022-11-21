@extends('layouts.dashboard')

@section('dashContent')


<?php use App\Http\Controllers\User; ?>
<?php use App\Http\Controllers\AllCountries; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Cross Border Payment List
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">
                Cross Border Payment List
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
                                    <th></th>
                                    <th>Receivers Name</th>
                                    <th>Senders Name</th>
                                    <th>Purpose</th>
                                    <th>Amount to Send</th>
                                    <th>Country</th>
                                    <th>Payment Method</th>
                                    <th>Invoice file</th>
                                    <th>Status</th>
                                    <th colspan="2">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @if (count($data['crossborder']) > 0)

                                @foreach ($data['crossborder'] as $crossborder)

                                @if ($countryData = \App\AllCountries::where('name', $crossborder->country)->first())
                                @php
                                $currencySymbol = $countryData->currencySymbol;
                                @endphp

                                @else
                                @php
                                $currencySymbol = '';
                                @endphp

                                @endif



                                <?php $i = 1; ?>
                                <tr>
                                    <td>{{ $i++ }}</td>

                                    <td>{{ $crossborder->transaction_id }}</td>
                                    <td>{{ $crossborder->receivers_name }} <br>

                                        <small>
                                            <a href="{{ route('view beneficiary detail', $crossborder->beneficiary_id) }}"
                                                target="_blank"
                                                style="font-weight: bold; color: red; text-decoration: underline;">View
                                                beneficiary details</a>
                                        </small>
                                    </td>
                                    <td>{{ $crossborder->senders_name }}</td>
                                    <td>{{ $crossborder->purpose }}</td>
                                    <td>{{ $currencySymbol . '' . number_format($crossborder->amount, 2) }}
                                    </td>
                                    <td>{{ $crossborder->country }}</td>
                                    <td>{{ $crossborder->select_wallet }}</td>
                                    <td align="center">
                                        <a href="{{ $crossborder->file }}" target="_blank"><img
                                                src="https://img.icons8.com/external-kiranshastry-lineal-color-kiranshastry/30/000000/external-invoice-advertising-kiranshastry-lineal-color-kiranshastry.png" /></a>
                                    </td>
                                    <td style="font-weight: bold;">
                                        {{ $crossborder->status == false ? 'Pending' : 'Processed' }}
                                    </td>
                                    <td>
                                        <button class="btn btn-primary btn-block spin{{ $crossborder->transaction_id }}"
                                            onclick="acceptCrossBorder('{{ $crossborder->transaction_id }}')">Process
                                            payment</button>
                                    </td>
                                    <td>
                                        <button class="btn btn-danger btn-block spins{{ $crossborder->transaction_id }}"
                                            onclick="reverseCrossBorder('{{ $crossborder->transaction_id }}')">Reverse
                                            payment</button>
                                    </td>
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