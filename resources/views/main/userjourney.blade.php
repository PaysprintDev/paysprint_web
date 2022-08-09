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
            <div class="col-md-12">
                <section class="wrapper bg-light">
                    <div class="container py-14 py-md-16">
                        <h2 class="display-4 mb-3">How We Do It?</h2>
                        <p class="lead fs-lg mb-8">We make your spending <span class="underline">stress-free</span> for
                            you to have the
                            perfect control.</p>
                        <div class="row gx-lg-8 gx-xl-12 gy-6 process-wrapper line">
                            <!--/column -->
                            <div class="col-md-6 col-lg-3"> <span
                                    class="icon btn btn-circle btn-lg btn-primary disabled mb-4"><span
                                        class="number">01</span></span>
                                <h4 class="mb-1">Account Verfication-Pending</h4>
                                <p class="mb-0">Vestibulum id ligula porta felis euismod semper. Sed posuere consectetur
                                    est at
                                    lobortis.</p>
                            </div>
                            <!--/column -->
                            <div class="col-md-6 col-lg-3"> <span
                                    class="icon btn btn-circle btn-lg btn-soft-primary disabled mb-4"><span
                                        class="number">02</span></span>
                                <h4 class="mb-1">Verified</h4>
                                <p class="mb-0">Integer posuere erat a ante venenatis dapibus posuere velit aliquet.
                                    Nulla vitae elit
                                    libero.</p>
                            </div>
                            <!--/column -->
                            <div class="col-md-6 col-lg-3"> <span
                                    class="icon btn btn-circle btn-lg btn-soft-primary disabled mb-4"><span
                                        class="number">03</span></span>
                                <h4 class="mb-1">30-Day Trial</h4>
                                <p class="mb-0">Integer posuere erat, consectetur adipiscing elit. Fusce dapibus, tellus
                                    ac cursus
                                    commodo.</p>
                            </div>
                            <!--/column -->
                            <div class="col-md-6 col-lg-3"> <span
                                    class="icon btn btn-circle btn-lg btn-soft-primary disabled mb-4"><span
                                        class="number">04</span></span>
                                <h4 class="mb-1">Account on Plan</h4>
                                <p class="mb-0">Integer posuere erat, consectetur adipiscing elit. Fusce dapibus, tellus
                                    ac cursus
                                    commodo.</p>
                            </div>
                        </div>
                        <!--/.row -->
                    </div>
                    <!-- /.container -->
                </section>
                <!-- /section -->
                <!-- /section -->
                <!-- /section -->
            </div>
        </div>
    </div>
</section>
<!-- End Our Services Area -->


@endsection