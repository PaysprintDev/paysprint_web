@extends('layouts.dashboard')

@section('dashContent')


    <?php use App\Http\Controllers\User; ?>
    <?php use App\Http\Controllers\BankWithdrawal; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Referral Claims Reward
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active">Referral Claims Reward</li>
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

                        <div class="box-body">
                            <div class="row">

                                @if (count($data['claim']) > 0)
                                    <?php $i = 1; ?>


                                    @foreach ($data['claim'] as $points)
                                        <div class="col-md-4">
                                            <div class="card" style="width: 100%; ">
                                                <div class="card-body"
                                                    style="background-color:#f6f6f6; padding: 10px; font-weight: bold; border-radius: 10px 10px 0px 0px;">


                                                    <h5 class="card-title">{{ $i++ }}</h5>
                                                    <h6 class="card-subtitle mb-2 text-muted">Referral Claims Reward</h6>
                                                    <table class="table table-striped table-bordered">
                                                        <tbody>

                                                            @if ($userdata = \App\User::where('id', $points->user_id)->first())

                                                                <tr>
                                                                    <td>Fullname</td>
                                                                    <td>{{ $userdata->accountType == 'Merchant' ? $userdata->businessname : $userdata->name }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Email</td>
                                                                    <td title="{{ $userdata->email }}"><?php $string = $userdata->email;
$output = strlen($string) > 10 ? substr($string, 0, 10) . '...' : $string;
echo $output; ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Phone</td>
                                                                    <td>{{ $userdata->telephone }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Date</td>
                                                                    <td>{{ date('d/M/Y', strtotime($points->created_at)) }}</td>
                                                                </tr>

                                                            @endif


                                                            <tr>
                                                                <td>Points Claimed</td>
                                                                <td>{{ $points->points_claimed }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Remaining Points</td>
                                                                <td>{{ $points->points_left }}</td>
                                                            </tr>





                                                        </tbody>
                                                    </table>
                                                    <button href="#" class="btn btn-primary btn-block">Process
                                                        claim</button>

                                                </div>
                                            </div>
                                        </div>

                                    @endforeach



                                @else

                                    <div class="col-md-12">
                                        <div class="card" style="width: 100%; ">
                                            <div class="card-body"
                                                style="background-color:#f6f6f6; padding: 10px; font-weight: bold; border-radius: 10px 10px 0px 0px;">

                                                <h5 class="card-title">&nbsp;</h5>
                                                <h6 class="card-subtitle mb-2 text-muted">&nbsp;</h6>

                                                <p class="text-center">No new record</p>

                                            </div>
                                        </div>
                                    </div>

                                @endif

                            </div>
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
