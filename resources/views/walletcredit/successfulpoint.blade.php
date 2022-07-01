@extends('layouts.dashboard')

@section('dashContent')


    <?php use App\Http\Controllers\User; ?>
    <?php use App\Http\Controllers\BankWithdrawal; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Successful Referral Claims
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active">Successful Referral Claims</li>
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



                                   
                                        {{-- <div class="col-md-4">
                                            <div class="card" style="width: 100%; ">
                                                <div class="card-body"
                                                    style="background-color:#f6f6f6; padding: 10px; font-weight: bold; border-radius: 10px 10px 0px 0px;"> --}}


                                                    {!! session('msg') !!}
                                                    <h6 class="card-subtitle mb-2 text-muted">Referral Claims Reward</h6>
                                                        
                                                    <table class="table table-striped table-bordered table-responsive" id="promousers">
                                                        <thead>
                                                            <tr>
                                                                <th>S/N</th>
                                                                <th>Full Name</th>
                                                                <th>Email</th>
                                                                <th>Phone</th>
                                                                <th>Country</th>
                                                                <th>Account Type</th>
                                                                <th>Date Processed</th>
                                                                {{-- <th>Points Claimed</th> --}}
                                                                {{-- <th>Remaining Points</th> --}}
                                                                {{-- <th>Action</th> --}}
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            
                                                              @if (count($data['claim']) > 0)
                                                               <?php $i = 1; ?>
                                                            @foreach ($data['claim'] as $points)
                                                            @if ($userdata = \App\User::where('id', $points->user_id)->first())

                                                                <tr>
                                                                    <td>{{ $i++ }}</td>
                                                                    <td>{{ $userdata->accountType == 'Merchant' ? $userdata->businessname : $userdata->name }}
                                                                    </td>
                                                                    <td title="{{ $userdata->email }}"><?php $string = $userdata->email;
$output = strlen($string) > 10 ? substr($string, 0, 10) . '...' : $string;
echo $output; ?>
                                                                    </td>
                                                                    <td>{{ $userdata->telephone }}</td>
                                                                    <td>{{$userdata->country}}</td>
                                                                    <td>{{$userdata->accountType}}</td>
                                                                    <td>{{ date('d/M/Y', strtotime($points->created_at)) }}</td>
                                                                    {{-- <td>{{ $points->points_claimed }}</td> --}}
                                                                    {{-- <td>{{ $points->points_left }}</td> --}}
                                                                    {{-- <td>
                                                                        <form action="{{route('process referral claim')}}" method="post">
                                                                            @csrf
                                                                            <input type="hidden" name="id" value="{{ $points->id }}">
                                                                            <button type="submit" class="btn btn-primary btn-block">Process
                                                                                claim</button>
                                                                            </form>
                                                                    </td> --}}
                                                                </tr>

                                                            @endif
                                                            @endforeach
                                                            {{-- @else
                                                            <div class="col-md-12">
                                                                <p class="text-center">No new record</p>
                                                            </div> --}}
                                                          
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                   
{{--                                                     
                                                </div>
                                            </div>
                                        </div>

                                   --}}



                               

                                    {{-- <div class="col-md-12">
                                        <div class="card" style="width: 100%; ">
                                            <div class="card-body"
                                                style="background-color:#f6f6f6; padding: 10px; font-weight: bold; border-radius: 10px 10px 0px 0px;">

                                                <h5 class="card-title">&nbsp;</h5>
                                                <h6 class="card-subtitle mb-2 text-muted">&nbsp;</h6>

                                               

                                            </div>
                                        </div>
                                    </div> --}}

                               

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
