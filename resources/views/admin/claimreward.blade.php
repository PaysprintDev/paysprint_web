@extends('layouts.dashboard')

@section('dashContent')


    <?php use App\Http\Controllers\User; ?>
    <?php use App\Http\Controllers\BankWithdrawal; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Claim Reward
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active">Claim Points Reward</li>
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
                            {!! session('msg') !!}
                        <div class="box-body">
                            <div class="row">
                                <table class="table table-striped table-responsive" id="promousers">
                                    <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th>FullName</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Points Claimed</th>
                                            <th>Remaining Points</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    @php
                                        $counter=1;
                                    @endphp
                                    <tbody>
                                    @if(count($data['pointsclaim']) > 0)
                                    @foreach ( $data['pointsclaim'] as $points)
                                    @if($user=\App\User::where('id',$points->user_id)->first())
                                        <tr>
                                            <td>{{ $counter++}}</td>
                                            <td>{{ $user->name}}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->telephone}}</td>
                                            <td>{{$points->points_acquired}}</td>
                                            <td>{{$points->points_left}}</td>
                                            <td>
                                                <form action="{{route('process point claim')}}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $points->id }}">
                                                    <button type="submit" class="btn btn-primary btn-block">Process
                                                        claim</button>
                                                    </form>
                                            </td>
                                        </tr>
                                        @endif
                                     @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
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
