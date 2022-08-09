@extends ('layouts.app')

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
            <div class="col-md-12">
                <div class="wrapper option-1 option-1-1">
                    <ol class="c-stepper">
                        <li class="c-stepper__item {{Auth::user() ? 'c-stepper__item__active' : ''}}">
                            <h3 class="c-stepper__title">Sign Up</h3>
                            <p class="c-stepper__desc">Some desc text</p>
                        </li>
                        <li class="c-stepper__item {{ $data['userdetails'] ? 'c-stepper__item__active' : '' }}">
                            <h3 class="c-stepper__title">
                                30-Day Trial</h3>
                            <p class="c-stepper__desc">Some desc text</p>
                        </li>
                        <li class="c-stepper__item">
                            <h3 class="c-stepper__title">Account Verification-Pending</h3>
                            <p class="c-stepper__desc">Some desc text</p>
                        </li>
                        <li class="c-stepper__item">
                            <h3 class="c-stepper__title">Verified</h3>
                            <p class="c-stepper__desc">Some desc text</p>
                        </li>
                        <li class="c-stepper__item">
                            <h3 class="c-stepper__title">Completed</h3>
                            <p class="c-stepper__desc">Some desc text</p>
                        </li>
                    </ol>
                </div>
                <!-- /section -->
                <!-- /section -->
                <!-- /section -->
            </div>
        </div>
    </div>
</section>
<!-- End Our Services Area -->


@endsection