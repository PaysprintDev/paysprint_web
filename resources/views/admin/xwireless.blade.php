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
                SMS Dashboard

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


                @if (session('role') == 'Super')
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-red">
                            <div class="inner">
                                <h3>{{ $data['smsbalance'] != null ? $data['smsbalance']->Data[0]->Credits : 'Provider error!' }}
                                </h3>

                                <p>Account Balance</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="http://154.16.202.38/Dashboard/Index" target="_blank" class="small-box-footer">View
                                details <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                @endif

            </div>
            <br>
            <br>



        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
