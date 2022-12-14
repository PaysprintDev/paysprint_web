@extends('layouts.app')


@section('title', 'Home')

@show

@section('content')

<?php use App\Http\Controllers\User; ?>

<!-- Professional Builde -->
<section class="professional_builders row">
    <div class="container" id="myHeader" style="background-color: #fff;">
        <br>
        <br>
        <div class="row builder_all">
            <div class="col-md-3 col-sm-6 builder walletInformation">
                <div class="alert alert-warning">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="font-sm">
                                Balance
                            </h4>
                        </div>
                        <br>
                        <div class="col-md-12">
                            <h3>
                                {{ $data['currencyCode']->currencySymbol . '' .
                                number_format(Auth::user()->wallet_balance, 4) }}
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 builder walletInformation">
                <div class="alert alert-info">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="font-sm">
                                Withdrawals
                            </h4>
                        </div>
                        <div class="col-md-12">
                            <h3>
                                {{ number_format(Auth::user()->number_of_withdrawals) }}
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 builder walletInformation">
                <div class="alert alert-success">
                    <div class="row">
                        <div class="col-md-12">
                            <small class="font-sm">
                                Total Points
                            </small>
                        </div>



                    </div>

                    <div class="row">

                        <div class="col-md-4">
                            <h3>
                                {{ isset($data['mypoints']) ? $data['mypoints']->points_acquired : 0 }}

                            </h3>
                        </div>

                        <div class="col-md-4">
                            <small>
                                <a style="font-weight: 700; font-size: 11px" href="{{ route('consumer points') }}">
                                    Earned Points
                                </a>
                            </small>
                        </div>


                        <div class="col-md-4">
                            <form action="{{ route('claim point') }}" method="POST" id="claimmypoint">
                                @csrf
                                <small><a type='button' href="javascript:void()" onclick="$('#claimmypoint').submit()"
                                        style="font-weight: 700; font-size: 11px">Redeem
                                        Points</a></small>

                            </form>
                        </div>

                    </div>

                </div>
            </div>
            <div class="col-md-3 col-sm-6 builder walletInformation">
                <div class="alert alert-success">
                    <div class="row">
                        <div class="col-md-12">
                            <small class="font-sm">
                                Number of Referred
                            </small>
                        </div>



                    </div>

                    <div class="row">

                        <div class="col-md-4">
                            <h3>



                                {{ isset($data['referred']) ? $data['referred'] : 0 }}

                            </h3>
                        </div>

                        <div class="col-md-4">
                            <small>
                                <a style="font-weight: 700; font-size: 11px" href="{{ route('referred details') }}">
                                    View More
                                </a>
                            </small>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Professional Builde -->

<!-- Our Services Area -->
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-4">
                <!-- ShareThis BEGIN -->
                <p style="text-align: center; font-size: 30px; "><strong>Check out our special Promos</strong></p>
                <hr>
                {!! session('msg') !!}
            </div>
            <div class="col-md-12">
                <table class="table table-striped table-responsive" id="promousers">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Special Promo Details</th>
                            <th>Special Promo Start-Date</th>
                            <th>Special Promo End-Date</th>
                            <th> Special Promo Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $counter=1;
                        @endphp
                        @if(count($data['specialpromo']) > 0)
                        @foreach ($data['specialpromo'] as $specialpromo )
                        @php
                        $exist = \App\SpecialPromo::where('user_id', Auth::id())->where('special_promo_id',
                        $specialpromo->id)->first();
                        @endphp
                        <tr>
                            <td>{{ $counter++ }}</td>
                            <td>{{ $specialpromo->promo_details }}</td>
                            <td>{{ $specialpromo->start_date }}</td>
                            <td>{{ $specialpromo->end_date }}</td>
                            <td>


                                @if (new DateTime(date('Y-m-d')) <= new DateTime($specialpromo->end_date))
                                    <a href="{{ route('join promo',$specialpromo->id) }}"
                                        class="btn btn-success {{ $exist ? 'disabled' : '' }}">{{ $exist ? 'Joined' :
                                        'Join Promo' }}</a>
                                    @else
                                    <a href="javascript:void()" class="btn btn-danger">Promo Ended</a>

                                    @endif

                            </td>
                        </tr>
                        @endforeach

                        @else
                        <tr>
                            <td colspan="5" style="text-align: center">
                                <div class="col-md-12 text-center"> No Promo available</div>
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
</section>
<!-- End Our Services Area -->


@endsection