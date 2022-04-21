@extends('layouts.dashboard')


@section('dashContent')
    <?php use App\Http\Controllers\ClientInfo; ?>
    <?php use App\Http\Controllers\User; ?>
    <?php use App\Http\Controllers\UserClosed; ?>
    <?php use App\Http\Controllers\InvoicePayment; ?>
    <?php use App\Http\Controllers\AllCountries; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Dashboard
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Dashboard</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Small boxes (Stat box) -->
            <div class="row">

                @include('include.dashboard.superaml')

            </div>
            <br>
            <br>


        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
