@extends('layouts.newpage.app')

@section('content')
<!-- navbar- -->
<?php

use App\Http\Controllers\TransactionCost; ?>


<div style="overflow-y: auto !important;">

    <div class="inner-banner pt-29 pt-lg-30 pb-9 pb-lg-12 bg-default-6">
        <div class="container">
            <div class="row  justify-content-center pt-5">
                <div class="col-xl-8 col-lg-9">
                    <div class="px-md-15 text-center">
                        <h2 class="title gr-text-2 mb-8 mb-lg-10">{{ $pages }}</h2>
                        {{-- <p class="gr-text-7 mb-0 mb-lg-13">Full Time, Remote</p> --}}



                    </div>
                </div>

                <div class="col-12">
                    <table class="table table-striped table-bordered">

                        <tbody>
                            <tr>
                                <td>
                                    <p class="gr-text-7 font-weight-bold mb-9">Select Country</p>

                                    <select name="country" id="pricing_country" class="form-control" style="overflow-y: auto">
                                        <option value="">Select Country</option>
                                        @foreach ($data['activecountries'] as $country)
                                        <option value="{{ $country->name }}" {{ $country->name == Request::get('country') ? 'selected' : '' }}>
                                            {{ $country->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                        </tbody>

                    </table>
                </div>


            </div>
        </div>
    </div>
    <div class="main-block pb-6 pb-lg-17 bg-default-6">
        <div class="container">



            <div class="row justify-content-center">

                <div class="table table-responsive">

                    <table class="table table-striped table-bordered">
                        <tbody>

                            <tr>
                                <td>
                                    <p class="gr-text-6 font-weight-bold mb-9"></p>
                                </td>
                                <td align="center">
                                    <p class="gr-text-6 font-weight-bold mb-9">Free Plan (Free Forever)</p>
                                    <p class="text-danger">{{ $data['currency'] . '0.00' }} Fee</p>
                                </td>

                                @if ($thisprices = \App\TransactionCost::where('country', $data['country'])->where('structure', 'Consumer Monthly Subscription')->first())

                                @php
                                $monthlyBased = $thisprices->fixed;
                                $yearlyBased = $thisprices->fixed * 10;
                                @endphp

                                @else
                                @php
                                $monthlyBased = 0;
                                $yearlyBased = 0;
                                @endphp
                                @endif

                                <td align="center">
                                    <p class="gr-text-6 font-weight-bold mb-9">Classic</p>
                                    <p class="text-danger">
                                        {{ $data['currency'] . number_format($monthlyBased, 2) }}
                                        Monthly
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="gr-text-9 mb-0">No Charge Money Transfer (Local & Intl.)</p>
                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/checked.png" />
                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/checked.png" />
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <p class="gr-text-9 mb-0">Pay Invoice to PaySprint Merchants</p>
                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/checked.png" />
                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/checked.png" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="gr-text-9 mb-0">Pay Invoice to Non-PaySprint Merchants (Globally)</p>
                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/cancel.png" />

                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/checked.png" />

                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="gr-text-9 mb-0">Access PaySprint Foreign Exchange</p>
                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/cancel.png" />

                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/checked.png" />

                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="gr-text-9 mb-0 text-danger">Minimum balance of {{ $data['currency'].number_format($monthlyBased, 2) }} in Wallet Applies</p>
                                </td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <p class="text-center text-danger">30days Free Subscription. Cancel Subscription at any time.</p>
                                </td>
                                <!-- <td></td>
                                <td></td> -->
                            </tr>

                            @if (Request::get('country') == 'Canada' || Request::get('country') == 'United States')
                            <tr>
                                <td>
                                    <p class="gr-text-9 mb-0">Access to Currency Exchange</p>
                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/cancel.png" />

                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/checked.png" />

                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="gr-text-9 mb-0">Personal Cash Advance</p>
                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/cancel.png" />

                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/checked.png" />

                                </td>
                            </tr>

                            @endif





                        </tbody>
                    </table>


                </div>

            </div>
        </div>
    </div>
</div>
@endsection