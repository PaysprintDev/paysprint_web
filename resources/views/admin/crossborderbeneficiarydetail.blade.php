@extends('layouts.dashboard')

@section('dashContent')


<?php use App\Http\Controllers\User; ?>
<?php use App\Http\Controllers\AllCountries; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Beneficiary Detail
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">
                Beneficiary Detail
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

                            <tbody>

                                @if (isset($data['beneficiary']))

                                <tr>
                                    <td>Account Name:</td>
                                    <td style="font-weight: bold;">{{ $data['beneficiary']->account_name }}</td>
                                </tr>

                                <tr>
                                    <td>Account Number:</td>
                                    <td style="font-weight: bold;">{{ $data['beneficiary']->account_number }}</td>
                                </tr>


                                <tr>
                                    <td>Bank Name:</td>
                                    <td style="font-weight: bold;">{{ $data['beneficiary']->bank_name }}</td>
                                </tr>


                                <tr>
                                    <td>Sort Code:</td>
                                    <td style="font-weight: bold;">{{ $data['beneficiary']->sort_code }}</td>
                                </tr>

                                <tr>
                                    <td>Currency:</td>
                                    <td style="font-weight: bold;">{{ $data['beneficiary']->currencyCode }}</td>
                                </tr>

                                <tr>
                                    <td>Address:</td>
                                    <td style="font-weight: bold;">{{ $data['beneficiary']->beneficiary_address }}</td>
                                </tr>
                                {{-- <tr>
                                    <td>Bank Address:</td>
                                    <td style="font-weight: bold;">{{ $data['beneficiary']->address }}</td>
                                </tr> --}}


                                @else
                                <tr>
                                    <td align="center">Not found</td>
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