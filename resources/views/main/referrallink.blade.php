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
                                {{ $data['currencyCode']->currencySymbol . '' . number_format(Auth::user()->wallet_balance, 4) }}
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
            <!-- ShareThis BEGIN -->
           <p><strong>Share link to invite your friends:</strong></p>
            <div class="sharethis-inline-share-buttons mb-3"
            data-url="{{ route('home') . '/register?ref_code='. Auth::user()->ref_code }}">
            </div><!-- ShareThis END -->
            <br>
            <br>
            <div class="col-md-12 mt-3">
                <p class="text-center"><strong>Invite your friends and families to sign up for free on PaySprint App. Send and receive money in minutes and for free .</strong></p>
            </div>
            <br>
            <br>
            {{-- <div class="col-md-12 mt-3">
                <h4 class="text-center mt-4"><strong><u>WHY SHOULD YOU REFER YOUR FREINDS TO USE PAYSPRINT</u></strong></h4>
            </div> --}}
    </div>
    </div>
</section>
<!-- End Our Services Area -->


@endsection
