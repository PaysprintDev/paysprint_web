@extends('layouts.dashboard')

@section('dashContent')
    <?php use App\Http\Controllers\User; ?>
    <?php use App\Http\Controllers\Store; ?>
    <?php use App\Http\Controllers\Admin; ?>
    <?php use App\Http\Controllers\OrganizationPay; ?>
    <?php use App\Http\Controllers\ClientInfo; ?>
    <?php use App\Http\Controllers\AnonUsers; ?>


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
            Expired Otp
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active"> Expired Otp</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            {!! session('msg') !!}
                            <h3 class="box-title">Expired Otp</h3>
                            @php
                                $counter=1;
                            @endphp
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body table table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Product Name</th>
                                        <th>OTP</th>
                                        <th>Customer</th>
                                        <th>Merchant</th>
                                        <th>Duration</th>
                                        <th>Status</th>
                                        <th>Date Created</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($data['otp']) > 0)
                                        @foreach ( $data['otp'] as $otp )
                                        @if($user = \App\User::where('id', $otp->userId)->first())
                                        @if($user = \App\User::where('id', $otp->merchantId)->first())
                                        @if($category = \App\StoreCategory::where('id', $otp->productId)->first())
                                    <tr>
                                        <td>{{ $counter ++ }}</td>
                                        <td>{{ $category->category}}</td>
                                        <td>{{ $otp->deliveryCode}}</td>
                                        <td>{{ $user->name}}</td>
                                        <td>{{ $user->businessname}}</td>
                                        <td>
                                           @php
                                                $fdate = $otp->expiry;
                                                $tdate = $otp->created_at;
                                                $datetime1 = new DateTime($fdate);
                                                $datetime2 = new DateTime($tdate);
                                                $interval = $datetime1->diff($datetime2);
                                                $days = $interval->format('%a');
                                           @endphp

                                           {{ $days.' '.'days' }}
                                           </td>
                                        <td>{{ $otp->status }}</td>
                                        <td>{{ date('d/M/Y', strtotime( $otp->created_at))}}</td>
                                    </tr>
                                    @endif
                                    @endif
                                    @endif
                                    @endforeach
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
