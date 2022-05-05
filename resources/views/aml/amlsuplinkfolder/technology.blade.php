@extends('layouts.dashboard')

@section('dashContent')
    <?php use App\Http\Controllers\User; ?>
    <?php use App\Http\Controllers\Admin; ?>
    <?php use App\Http\Controllers\OrganizationPay; ?>
    <?php use App\Http\Controllers\ClientInfo; ?>
    <?php use App\Http\Controllers\AnonUsers; ?>


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
               Technology
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active"> Technology</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            {!! session('msg') !!}
                            <h3 class="box-title"> Aml Technology</h3>

                        </div>
                        <!-- /.box-header -->
                        <div class="box-body table table-responsive">
                            <form action="{{ route('gettechnology')}}" method="post">
                                @csrf
                                <div>
                                    <label class="form-label mb-4">Select a Target</label>
                                    <select name="technology" class="form-control">
                                        <option value="">Choose Below</option>
                                        <option value="paystack">Paystack</option>
                                        <option value="moneries">Moneries</option>
                                        <option value="stripe">Stripe</option>
                                        <option value="paypal">Paypal</option>
                                        <option value="bvn">Bvn</option>
                                        <option value="sms">Sms</option>
                                    </select>
                                </div>
                                <br>

                                <button class="btn btn-primary form-control mt-4" type="submit">SUBMIT</button>
                            </form>
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
