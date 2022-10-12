@extends('layouts.merch.merchant-dashboard')


@section('content')



<style>
    .nav-item {
        margin: 5px !important;
    }
</style>


<?php

use App\Http\Controllers\ClientInfo; ?>
<?php

use App\Http\Controllers\User; ?>
<?php

use App\Http\Controllers\UserClosed; ?>
<?php

use App\Http\Controllers\InvoicePayment; ?>
<?php

use App\Http\Controllers\AllCountries; ?>

<div class="page-body">
    <!-- Container-fluid starts-->
    <!-- Container-fluid starts-->
    <div class="container-fluid dashboard-default-sec">
        <div class="row">


            {{-- Add Test Mode Here --}}
            @if ($data['clientInfo']->accountMode == 'test')
            <div class="col-xl-12 box-col-12 des-xl-100">
                <div class="alert alert-danger" role="alert">
                    <h5 class="text-center">Your account is currently in <strong>TEST</strong> mode</h5>
                </div>
            </div>
            @endif


            <div class="col-xl-5 box-col-12 des-xl-100">



                <div class="row">


                    <div class="col-xl-6 col-md-3 col-sm-6 box-col-3 des-xl-25 rate-sec">
                        <div class="card income-card card-primary">
                            <div class="card-body text-center">
                                <div class="round-box">
                                    <p style="font-size: 30px;">{{ Auth::user()->currencySymbol }}</p>
                                </div>
                                <h5>{{ number_format(Auth::user()->wallet_balance, 4) }}</h5>
                                <p>Wallet Balance</p>

                                <hr>

                                <h5>{{ Auth::user()->currencySymbol.''.number_format(Auth::user()->overdraft_balance, 4)
                                    }}</h5>
                                <p>Overdraft Balance</p>

                                &nbsp;

                                {{-- <a class="btn-arrow arrow-primary" href="javascript:void(0)"><i
                                        class="toprightarrow-primary fa fa-arrow-up me-2"></i>{{
                                    round(Auth::user()->wallet_balance / $data['statementCount'] / 100, 2) }}%
                                </a> --}}

                                {{-- Open Link for verified merchants... --}}

                                @if (Auth::user()->account_check == 2)


                                @if ($data['clientInfo']->accountMode != 'test')
                                {{-- Check if the days still available.... --}}


                                @php
                                $expire = date('Y-m-d', strtotime(Auth::user()->payment_link_expiry));
                                $now = time();
                                $your_date = strtotime($expire);
                                $datediff = $your_date - $now;
                                @endphp


                                @if (Auth::user()->payment_link_access == 1 && $datediff > 0)
                                <!-- ShareThis BEGIN -->
                                <p class="alert alert-primary text-white"><strong>Payment Link:</strong></p>
                                <p class="text-success" style="font-weight: bold;">Link expires: <br>
                                    <span class="text-danger" style="font-weight: bold;">{{ date('d-M-Y h:i a',
                                        strtotime(Auth::user()->payment_link_expiry)) }}</span>
                                </p>

                                <a href="#" style="color: navy; font-weight: 700; text-align: left;">Click and Share
                                    your payment link with the icon below</a>


                                <br>
                                <br>

                                @php
                                $business = Auth::user()->businessname . '/' . Auth::user()->ref_code;
                                $url = str_replace(' ', '%20', $business);
                                @endphp

                                <div class="sharethis-inline-share-buttons"
                                    data-url="{{ route('home') . '/merchant/' . $url }}">

                                </div><!-- ShareThis END -->
                                @else
                                <!-- ShareThis BEGIN -->
                                <p class="alert alert-danger text-white" style="cursor: pointer"
                                    onclick="getMyPaymentLink('{{ Auth::user()->id }}')">
                                    <strong>Generate
                                        Payment Link:</strong>
                                </p>




                                {{-- Start Modal Here --}}

                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary disp-0" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal" id="paymentLinkModal{{ Auth::user()->id }}">
                                    Launch demo modal
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Accept Terms
                                                    and Conditions.</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body" style="text-align: left">
                                                <p>
                                                    PaySprint Merchant Payment link is a fast and quick
                                                    method to accept payment from customers into the
                                                    merchant account.
                                                </p>
                                                <p>
                                                    As a User, you confirm that the customers to whom the
                                                    link is shared is a verified customer and you
                                                    agree and accept to be responsible for any charge back
                                                    that may result for payment being returned.
                                                </p>
                                                <p>
                                                    You also accept that PaySprint should debit your
                                                    merchant account with the chargeback amount along with
                                                    <span class="text-danger" style="font-weight: bold">penalty of
                                                        $50.00</span> or equivalent in local currency.
                                                </p>

                                                <p>

                                                <form action="{{ route('request payment link') }}" method="POST"
                                                    id="myPaymentLinkUp">
                                                    @csrf
                                                    <input type="hidden" name="id" id="myId"
                                                        value="{{ Auth::user()->id }}">
                                                </form>

                                                <input type="checkbox" name="paylink_checkbox" id="paylink_checkbox"
                                                    style="width: 20px; height: 20px; margin-top: 3px;">
                                                <span style="font-weight: bold; color: navy;">Accept terms
                                                    and conditions before proceeding</span>
                                                </p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-success" id="acceptLinkBtn"
                                                    onclick="acceptLinkTerms()">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- End Modal Here --}}
                                @endif
                                @else
                                <!-- ShareThis BEGIN -->
                                <p class="alert alert-danger text-white" style="cursor: pointer"
                                    onclick="getMyPaymentLink('{{ Auth::user()->id }}')">
                                    <strong>Generate
                                        Payment Link:</strong>
                                </p>


                                {{-- Start Modal Here --}}

                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary disp-0" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal" id="paymentLinkModal{{ Auth::user()->id }}">
                                    Launch demo modal
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Generate Payment
                                                    Link.</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body" style="text-align: left">
                                                <p>
                                                    Payment Link would be available when your merchant account
                                                    is on LIVE mode
                                                </p>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                {{-- End Modal Here --}}
                                @endif
                                @else
                                <!-- ShareThis BEGIN -->
                                <p class="alert alert-danger text-white" style="cursor: pointer"
                                    onclick="getMyPaymentLink('{{ Auth::user()->id }}')">
                                    <strong>Generate Payment
                                        Link:</strong>
                                </p>


                                {{-- Start Modal Here --}}

                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary disp-0" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal" id="paymentLinkModal{{ Auth::user()->id }}">
                                    Launch demo modal
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Generate Payment
                                                    Link.</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body" style="text-align: left">
                                                <p>
                                                    Payment Link would be available when your merchant account is
                                                    fully verified. Kindly complete your merchant account
                                                    verification by uploading the business documents
                                                </p>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                {{-- End Modal Here --}}


                                @endif




                                <div class="parrten">
                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                        viewbox="0 0 448.057 448.057" style="enable-background:new 0 0 448.057 448.057;"
                                        xml:space="preserve">
                                        <g>
                                            <g>
                                                <path
                                                    d="M404.562,7.468c-0.021-0.017-0.041-0.034-0.062-0.051c-13.577-11.314-33.755-9.479-45.069,4.099                                            c-0.017,0.02-0.034,0.041-0.051,0.062l-135.36,162.56L88.66,11.577C77.35-2.031,57.149-3.894,43.54,7.417                                            c-13.608,11.311-15.471,31.512-4.16,45.12l129.6,155.52h-40.96c-17.673,0-32,14.327-32,32s14.327,32,32,32h64v144                                            c0,17.673,14.327,32,32,32c17.673,0,32-14.327,32-32v-180.48l152.64-183.04C419.974,38.96,418.139,18.782,404.562,7.468z">
                                                </path>
                                            </g>
                                        </g>
                                        <g>
                                            <g>
                                                <path
                                                    d="M320.02,208.057h-16c-17.673,0-32,14.327-32,32s14.327,32,32,32h16c17.673,0,32-14.327,32-32                                            S337.694,208.057,320.02,208.057z">
                                                </path>
                                            </g>
                                        </g>
                                    </svg>
                                </div>
                            </div>
                        </div>


                        {{-- Share payment link with customers on PaySprint and Not on PaySprint --}}

                    </div>
                    <div class="col-xl-6 col-md-3 col-sm-6 box-col-3 des-xl-25 rate-sec">
                        <div class="card income-card card-secondary">
                            <div class="card-body text-center">
                                <div class="round-box">
                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewbox="0 0 512 512"
                                        style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                        <g>
                                            <g>
                                                <path
                                                    d="M256,0C114.848,0,0,114.848,0,256s114.848,256,256,256s256-114.848,256-256S397.152,0,256,0z M256,480                                                      C132.48,480,32,379.52,32,256S132.48,32,256,32s224,100.48,224,224S379.52,480,256,480z">
                                                </path>
                                            </g>
                                        </g>
                                        <g>
                                            <g>
                                                <path
                                                    d="M340.688,292.688L272,361.376V96h-32v265.376l-68.688-68.688l-22.624,22.624l96,96c3.12,3.12,7.216,4.688,11.312,4.688                                                      s8.192-1.568,11.312-4.688l96-96L340.688,292.688z">
                                                </path>
                                            </g>
                                        </g>
                                    </svg>
                                </div>
                                <h5>{{ $data['paidInvoiceCount'] }}</h5>
                                <p>Paid Invoice</p>
                                <a class="btn-arrow arrow-secondary" href="javascript:void(0)">
                                    &nbsp;
                                    {{-- <i class="toprightarrow-secondary fa fa-arrow-up me-2"></i>{{
                                    count($data['invoiceList']) != 0 ? round($data['paidInvoiceCount'] /
                                    count($data['invoiceList']), 2) : 0 }}% --}}
                                </a>





                                <div class="parrten">
                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewbox="0 0 512 512"
                                        style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                        <g>
                                            <g>
                                                <path
                                                    d="M256,0C114.615,0,0,114.615,0,256s114.615,256,256,256s256-114.615,256-256S397.385,0,256,0z M96,100.16                                            c50.315,35.939,80.124,94.008,80,155.84c0.151,61.839-29.664,119.919-80,155.84C11.45,325.148,11.45,186.851,96,100.16z M256,480                                            c-49.143,0.007-96.907-16.252-135.84-46.24C175.636,391.51,208.14,325.732,208,256c0.077-69.709-32.489-135.434-88-177.6                                            c80.1-61.905,191.9-61.905,272,0c-98.174,75.276-116.737,215.885-41.461,314.059c11.944,15.577,25.884,29.517,41.461,41.461                                            C353.003,463.884,305.179,480.088,256,480z M416,412v-0.16c-86.068-61.18-106.244-180.548-45.064-266.616                                            c12.395-17.437,27.627-32.669,45.064-45.064C500.654,186.871,500.654,325.289,416,412z">
                                                </path>
                                            </g>
                                        </g>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>



                    @if ($data['clientInfo']->accountMode == 'test')

                    <div class="d-flex flex-row justify-content-start">


                        <div class="col-md-6 mb-3 addMoney">

                            <a type="button" href="javascript:void()" class="btn btn-info btn-block"
                                style="width: 100%;">Top up
                                wallet <i class="fa fa-plus" aria-hidden="true"></i></a>
                        </div>

                        <div class="col-md-6 mb-3 withdrawMoney">
                            <a type="button" href="javascript:void()" class="btn btn-success btn-block"
                                style="width: 100%;">Withdraw
                                Money to Bank <i class="fa fa-plus" aria-hidden="true"></i></a>
                        </div>


                    </div>


                    <div class="d-flex flex-row justify-content-start">

                        <div class="col-md-6 mb-3 sendMoney">
                            <a type="button" href="javascript:void()" class="btn btn-warning btn-block"
                                style="width: 100%;">Local money transfer <i class="fa fa-plus"
                                    aria-hidden="true"></i></a>
                        </div>


                        @if (Auth::check() == true)
                        @if ($imt = \App\AllCountries::where('name', Auth::user()->country)->where('imt',
                        'true')->orWhere('outbound', 'true')->first())
                        @if (isset($imt))
                        <div class="col-md-6 mb-3 sendMoney">
                            <a type="button" href="javascript:void()" class="btn btn-primary btn-block"
                                style="width: 100%;">International
                                money
                                transfer <i class="fa fa-plus" aria-hidden="true"></i></a>
                        </div>
                        @else
                        <div class="col-md-6 mb-3 sendMoney">
                            <a type="button" href="javascript:void()" onclick="comingSoon()"
                                class="btn btn-primary btn-block" style="width: 100%;">International
                                money
                                transfer <i class="fa fa-plus" aria-hidden="true"></i></a>
                        </div>
                        @endif
                        @else
                        <div class="col-md-6 mb-3 sendMoney">
                            <a type="button" href="javascript:void()" onclick="comingSoon()"
                                class="btn btn-primary btn-block" style="width: 100%;">International money
                                transfer <i class="fa fa-plus" aria-hidden="true"></i></a>
                        </div>
                        @endif
                        @else
                        <div class="col-md-6 mb-3 sendMoney">
                            <a type="button" href="javascript:void()" onclick="comingSoon()"
                                class="btn btn-primary btn-block" style="width: 100%;">International money
                                transfer <i class="fa fa-plus" aria-hidden="true"></i></a>
                        </div>
                        @endif


                    </div>



                    <div class="d-flex flex-row justify-content-center">



                        <div class="col-md-6 mb-3 payinvoiceMoney">
                            <a type="button" href="javascript:void()" class="btn btn-danger btn-block"
                                style="width: 100%;">Create
                                Invoice <i class="fa fa-plus" aria-hidden="true"></i>
                            </a>
                        </div>

                        <div class="col-md-6 mb-3 payutilityMoney">

                            @if (Auth::user()->country == 'Nigeria')
                            <a type="button" href="javascript:void()" class="btn btn-info btn-block"
                                style="width: 100%;">Pay Utility
                                Bill <i class="fa fa-plus" aria-hidden="true"></i></a>
                            @else
                            <a type="button" href="javascript:void()" class="btn btn-info btn-block"
                                style="width: 100%;">Pay Utility
                                Bill <i class="fa fa-plus" aria-hidden="true"></i></a>
                            @endif



                        </div>




                    </div>
                    @else
                    <div class="d-flex flex-row justify-content-start">


                        <div class="col-md-6 mb-3 addMoney">

                            <a type="button" href="{{ route('Add Money') }}" class="btn btn-info btn-block"
                                style="width: 100%;">Top up
                                wallet <i class="fa fa-plus" aria-hidden="true"></i></a>
                        </div>

                        <div class="col-md-6 mb-3 withdrawMoney">
                            <a type="button" href="{{ route('Withdraw Money') }}" class="btn btn-success btn-block"
                                style="width: 100%;">Withdraw
                                Money to Bank <i class="fa fa-plus" aria-hidden="true"></i></a>
                        </div>


                    </div>


                    <div class="d-flex flex-row justify-content-start">

                        <div class="col-md-6 mb-3 sendMoney">
                            <a type="button" href="{{ url('payorganization?type=' . base64_encode('local')) }}"
                                class="btn btn-warning btn-block" style="width: 100%;">Local money transfer <i
                                    class="fa fa-plus" aria-hidden="true"></i></a>
                        </div>


                        @if (Auth::check() == true)
                        @if ($imt = \App\AllCountries::where('name', Auth::user()->country)->where('imt',
                        'true')->orWhere('outbound', 'true')->first())
                        @if (isset($imt))
                        <div class="col-md-6 mb-3 sendMoney">
                            <a type="button" href="{{ url('payorganization?type=' . base64_encode('international')) }}"
                                class="btn btn-primary btn-block" style="width: 100%;">International
                                money
                                transfer <i class="fa fa-plus" aria-hidden="true"></i></a>
                        </div>
                        @else
                        <div class="col-md-6 mb-3 sendMoney">
                            <a type="button" href="javascript:void()" onclick="comingSoon()"
                                class="btn btn-primary btn-block" style="width: 100%;">International
                                money
                                transfer <i class="fa fa-plus" aria-hidden="true"></i></a>
                        </div>
                        @endif
                        @else
                        <div class="col-md-6 mb-3 sendMoney">
                            <a type="button" href="javascript:void()" onclick="comingSoon()"
                                class="btn btn-primary btn-block" style="width: 100%;">International money
                                transfer <i class="fa fa-plus" aria-hidden="true"></i></a>
                        </div>
                        @endif
                        @else
                        <div class="col-md-6 mb-3 sendMoney">
                            <a type="button" href="javascript:void()" onclick="comingSoon()"
                                class="btn btn-primary btn-block" style="width: 100%;">International money
                                transfer <i class="fa fa-plus" aria-hidden="true"></i></a>
                        </div>
                        @endif


                    </div>



                    <div class="d-flex flex-row justify-content-center">



                        <div class="col-md-6 mb-3 payinvoiceMoney">
                            <a type="button" href="{{ route('create single invoice') }}"
                                class="btn btn-danger btn-block" style="width: 100%;">Create
                                Invoice <i class="fa fa-plus" aria-hidden="true"></i>
                            </a>
                        </div>

                        <div class="col-md-6 mb-3 payutilityMoney">

                            @if (Auth::user()->country == 'Nigeria')
                            <a type="button" href="{{ route('utility bills') }}" class="btn btn-info btn-block"
                                style="width: 100%;">Pay Utility
                                Bill <i class="fa fa-plus" aria-hidden="true"></i></a>
                            @else
                            <a type="button"
                                href="{{ route('select utility bills country', 'country=' . Auth::user()->country) }}"
                                class="btn btn-info btn-block" style="width: 100%;">Pay Utility
                                Bill <i class="fa fa-plus" aria-hidden="true"></i></a>
                            @endif



                        </div>




                    </div>


                    @if (Auth::user()->country == 'Canada')

                    @if ($payout = \App\PayoutAgent::where('user_id', Auth::user()->ref_code)->first())

                    <div class="d-flex flex-row justify-content-center">
                        <div class="col-md-12 mb-3">
                            <a type="button" href="{{ route('my payout record') }}" class="btn btn-success btn-block"
                                style="width: 100%;">Visit My Payout Record <i class="fa fa-money"
                                    aria-hidden="true"></i>
                            </a>
                        </div>

                    </div>


                    @else



                    {{-- <div class="d-flex flex-row justify-content-center">
                        <div class="col-md-12 mb-3">
                            <a type="button" href="javascript:void(0)"
                                onclick="becomeAnAgent('{{ Auth::user()->ref_code }}')"
                                class="btn btn-success btn-block" style="width: 100%;">Become a Payout Agent <i
                                    class="fa fa-money" aria-hidden="true"></i>
                            </a>
                        </div>

                    </div> --}}




                    @endif


                    @endif


                    @endif



                    <div class="col-xl-12 col-md-6 box-col-6 des-xl-50">
                        <div class="card profile-greeting">
                            <div class="card-header">
                                <div class="header-top">
                                    <div class="setting-list bg-primary position-unset">
                                        <ul class="list-unstyled setting-option">
                                            <li>
                                                <div class="setting-white"><i class="icon-settings"></i></div>
                                            </li>
                                            <li><i class="view-html fa fa-code font-white"></i></li>
                                            <li><i class="icofont icofont-maximize full-card font-white"></i></li>
                                            <li><i class="icofont icofont-minus minimize-card font-white"></i></li>
                                            <li><i class="icofont icofont-refresh reload-card font-white"></i></li>
                                            <li><i class="icofont icofont-error close-card font-white"></i></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body text-center p-t-0">
                                <h3 class="font-light"
                                    style="background-color:skyblue;color:white !important; padding: 10px 10px;">{{
                                    Auth::user()->businessname }}</h3>
                                <p>{{ Auth::user()->address . ' ' . Auth::user()->city . ' ' . Auth::user()->state }}
                                </p>

                                <a type="button" class="btn btn-light mb-3"
                                    href="{{ route('merchant profile') }}">Update
                                    Profile</a>

                                <br>
                                <hr>

                                <h4
                                    style="font-weight: bold; background-color:skyblue;color:white !important; padding: 10px 5px;">
                                    Accept Online Payments</h4>

                                <p>
                                    <strong>API Token:</strong>
                                    <code>{{ $data['clientInfo']->api_secrete_key }}</code>
                                </p>

                                <a type="button" class="btn btn-light mb-3 form-control"
                                    href="{{ route('api integration') }}">API
                                    Integration</a>

                                <!-- generate payment -->

                                <!-- end -->
                            </div>

                            <!-- generate links-->

                            <!-- end --->

                            <div class="confetti">
                                <div class="confetti-piece"></div>
                                <div class="confetti-piece"></div>
                                <div class="confetti-piece"></div>
                                <div class="confetti-piece"></div>
                                <div class="confetti-piece"></div>
                                <div class="confetti-piece"></div>
                                <div class="confetti-piece"></div>
                                <div class="confetti-piece"></div>
                                <div class="confetti-piece"></div>
                                <div class="confetti-piece"></div>
                                <div class="confetti-piece"></div>
                                <div class="confetti-piece"></div>
                                <div class="confetti-piece"></div>
                                <div class="code-box-copy">
                                    <button class="code-box-copy__btn btn-clipboard"
                                        data-clipboard-target="#profile-greeting" title="Copy"><i
                                            class="icofont icofont-copy-alt" href=""></i></button>
                                    <pre><code class="language-html" id="profile-greeting">                                     &lt;div class="card profile-greeting"&gt;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          &lt;div class="card-header"&gt;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          &lt;div class="header-top"&gt;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            &lt;div class="setting-list bg-primary"&gt;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              &lt;ul class="list-unstyled setting-option"&gt;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                &lt;li&gt;&lt;div class="setting-white"&gt;&lt;i class="icon-settings"&gt;&lt;/i&gt;&lt;/div&gt;&lt;/li&gt;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                &lt;li&gt;&lt;i class="view-html fa fa-code font-white"&gt;&lt;/i&gt;&lt;/li&gt;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                &lt;li&gt;&lt;i class="icofont icofont-maximize full-card font-white"&gt;&lt;/i&gt;&lt;/li&gt;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                &lt;li&gt;&lt;i class="icofont icofont-minus minimize-card font-white"&gt;&lt;/i&gt;&lt;/li&gt;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                &lt;li&gt;&lt;i class="icofont icofont-refresh reload-card font-white"&gt;&lt;/i&gt;&lt;/li&gt;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                &lt;li&gt;&lt;i class="icofont icofont-error close-card font-white"&gt; &lt;/i&gt;&lt;/li&gt;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             &lt;/ul&gt;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            &lt;/div&gt;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          &lt;/div&gt;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          &lt;/div&gt;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          &lt;div class="card-body text-center"&gt;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          &lt;h3 class="font-light"&gt;Wellcome Back, John!!&lt;/h3&gt;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          &lt;p&gt;Lorem ipsum is simply dummy text of the printing and typesetting industry.Lorem ipsum has been&lt;/p&gt;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          &lt;button class="btn btn-light"&gt;Update &lt;/button&gt;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          &lt;/div&gt;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          &lt;/div&gt;</code></pre>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            @if ($data['clientInfo']->accountMode != 'test')
            <div class="col-xl-7 box-col-12 des-xl-100 dashboard-sec">
                <h3
                    style="font-weight: bold; text-align:center; background-color:skyblue;color:white !important; padding: 10px 5px;">
                    Rental Property Management</h3>
                <div class="row">
                    <div class="col-xl-6 col-md-3 col-sm-6 box-col-3 des-xl-25 rate-sec">
                        <div class="card income-card card-primary">
                            <div class="card-body text-center">

                                <div class="round-box">

                                    <img src="https://img.icons8.com/ios/50/000000/home--v3.png" />
                                </div>
                                <div class="row">
                                    <div class="col-md-12">

                                        <a href="javascript:void()" onclick="whatyouOffer('{{ Auth::user()->email }}')"
                                            style="color: navy; font-weight: 700;"> Click to activate Manage
                                            Rental
                                            Property, MRP</a>

                                        {{-- <a href="{{ route('rentalManagementAdmin') }}"
                                            style="color: navy; font-weight: 700;">Rental Property Management</a> --}}
                                    </div>
                                </div>

                                <div class="parrten">
                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                        viewbox="0 0 448.057 448.057" style="enable-background:new 0 0 448.057 448.057;"
                                        xml:space="preserve">
                                        <g>
                                            <g>
                                                <path
                                                    d="M404.562,7.468c-0.021-0.017-0.041-0.034-0.062-0.051c-13.577-11.314-33.755-9.479-45.069,4.099                                            c-0.017,0.02-0.034,0.041-0.051,0.062l-135.36,162.56L88.66,11.577C77.35-2.031,57.149-3.894,43.54,7.417                                            c-13.608,11.311-15.471,31.512-4.16,45.12l129.6,155.52h-40.96c-17.673,0-32,14.327-32,32s14.327,32,32,32h64v144                                            c0,17.673,14.327,32,32,32c17.673,0,32-14.327,32-32v-180.48l152.64-183.04C419.974,38.96,418.139,18.782,404.562,7.468z">
                                                </path>
                                            </g>
                                        </g>
                                        <g>
                                            <g>
                                                <path
                                                    d="M320.02,208.057h-16c-17.673,0-32,14.327-32,32s14.327,32,32,32h16c17.673,0,32-14.327,32-32                                            S337.694,208.057,320.02,208.057z">
                                                </path>
                                            </g>
                                        </g>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-3 col-sm-6 box-col-3 des-xl-25 rate-sec">
                        <div class="card income-card card-secondary">
                            <div class="card-body text-center">
                                <div class="round-box">

                                    <img src="https://img.icons8.com/pastel-glyph/50/000000/user-female.png" />
                                </div>
                                <div class="row">
                                    <div class="col-md-12">

                                        <a href="javascript:void()"
                                            onclick="viewConsultant('{{ Auth::user()->email }}')"
                                            style="color: navy; font-weight: 700;">Click to Access MRP as a
                                            Service
                                            Provider</a>

                                        {{-- <a href="{{ route('rentalManagementAdmin') }}"
                                            style="color: navy; font-weight: 700;">Rental Property Management</a> --}}
                                    </div>
                                </div>
                                <div class="parrten">
                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewbox="0 0 512 512"
                                        style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                        <g>
                                            <g>
                                                <path
                                                    d="M256,0C114.615,0,0,114.615,0,256s114.615,256,256,256s256-114.615,256-256S397.385,0,256,0z M96,100.16                                            c50.315,35.939,80.124,94.008,80,155.84c0.151,61.839-29.664,119.919-80,155.84C11.45,325.148,11.45,186.851,96,100.16z M256,480                                            c-49.143,0.007-96.907-16.252-135.84-46.24C175.636,391.51,208.14,325.732,208,256c0.077-69.709-32.489-135.434-88-177.6                                            c80.1-61.905,191.9-61.905,272,0c-98.174,75.276-116.737,215.885-41.461,314.059c11.944,15.577,25.884,29.517,41.461,41.461                                            C353.003,463.884,305.179,480.088,256,480z M416,412v-0.16c-86.068-61.18-106.244-180.548-45.064-266.616                                            c12.395-17.437,27.627-32.669,45.064-45.064C500.654,186.871,500.654,325.289,416,412z">
                                                </path>
                                            </g>
                                        </g>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if (Auth::user()->plan == 'classic')
                <div class="row">
                    <div class="col-xl-12 col-md-6 col-sm-12 box-col-6 des-xl-25 rate-sec">
                        <div class="card income-card card-secondary">
                            <div class="card-body text-center">
                                <h3
                                    style="font-weight: bold; background-color:skyblue;color:white !important; padding: 10px 5px;">
                                    PaySprint Fx</h3>
                                <div class="round-box">

                                    <img src="https://img.icons8.com/ios-filled/50/000000/exchange.png" />
                                </div>
                                <div class="row">
                                    <div class="col-md-12">

                                        <p>Trade FX with PaySprint</p>

                                        <a type="button" class="btn btn-success"
                                            href="{{ route('paysprint currency exchange') }}">Manage
                                            FX</a>


                                        <hr>

                                        <a href="#" style="color: navy; font-weight: 700;">Learn more
                                            about
                                            trading
                                            on PaySprint</a>

                                    </div>
                                </div>


                                <div class="parrten">
                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewbox="0 0 512 512"
                                        style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                        <g>
                                            <g>
                                                <path
                                                    d="M256,0C114.615,0,0,114.615,0,256s114.615,256,256,256s256-114.615,256-256S397.385,0,256,0z M96,100.16                                            c50.315,35.939,80.124,94.008,80,155.84c0.151,61.839-29.664,119.919-80,155.84C11.45,325.148,11.45,186.851,96,100.16z M256,480                                            c-49.143,0.007-96.907-16.252-135.84-46.24C175.636,391.51,208.14,325.732,208,256c0.077-69.709-32.489-135.434-88-177.6                                            c80.1-61.905,191.9-61.905,272,0c-98.174,75.276-116.737,215.885-41.461,314.059c11.944,15.577,25.884,29.517,41.461,41.461                                            C353.003,463.884,305.179,480.088,256,480z M416,412v-0.16c-86.068-61.18-106.244-180.548-45.064-266.616                                            c12.395-17.437,27.627-32.669,45.064-45.064C500.654,186.871,500.654,325.289,416,412z">
                                                </path>
                                            </g>
                                        </g>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <div class="row">
                    <div class="col-xl-12 col-md-6 col-sm-12 box-col-6 des-xl-25 rate-sec">
                        <div class="card income-card card-secondary">
                            <div class="card-body text-center">
                                {!! session('msg') !!} {!! session('msgs') !!}
                                <div class="row">
                                    <div class="col-md-12 mb-4">
                                        <h3
                                            style="font-weight: bold; background-color:skyblue;color:white !important; padding: 10px 5px;">
                                            Marketplace</h3>

                                        <p>Utilize the marketplace to sell more online to customers</p>
                                    </div>
                                    <div class="col-md-3">
                                        <!-- 
                                <p style="font-weight:bold; font-size:20px;"></p> -->
                                        <a type="button" class="btn btn-success"
                                            href="{{route('view reviews')}}">{{$data['reviews']}} <br>Manage Reviews</a>

                                    </div>
                                    <div class="col-md-3">


                                        @if ( empty($data['cashback']))
                                        <!-- <form action="{{route('cashback')}}" method="post" id="formcashback">
                                @csrf
                                <input type="hidden" name="id" value="{{Auth::id()}}">
                                <a href="javascript:void()" class="btn btn-primary" id="cashback" onclick="$('#formcashback').submit()">Click to participate in Cashback</a>
                            </form> -->
                                        <!-- Button trigger modal -->

                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#staticBackdrop">
                                            Cashback. <br> Click to participate
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static"
                                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="staticBackdropLabel">Accept Terms
                                                            and Conditions</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{route('cashback')}}" method="post">
                                                            @csrf
                                                            <p style="text-align:left">PaySprint Merchant Cashback is an
                                                                incentive program to customers to buy more from the
                                                                participating merchant eStore.</p>
                                                            <h2
                                                                style="color:black; font-size:15px; text-align:left; font-weight:bold">
                                                                How does it work?</h2>
                                                            <p style="text-align:left">Every Participating merchant
                                                                contributes 2% of every sale proceed to the Cash-Back
                                                                program (that is 2% is debited to the merchant wallet).
                                                                The customer that purchased from the merchant's eStore
                                                                receives 1% of the paid price as a cashback wallet
                                                                credit from the program. The remaining 1% is used to
                                                                cover cost of promoting participating merchant's eStore
                                                                on social media and the cost of other promotional
                                                                activities.</p>
                                                            <p style="text-align:left">Merchant can END the
                                                                participation in the program ANYTIME by simply clicking
                                                                on "End Cash Back Promo" button.</p>
                                                            <p style="text-align:left">To participate in the program,
                                                                simply checkmark the button below and click the submit
                                                                button.
                                                                Accept terms and conditions before proceeding</p>

                                                            <input type="checkbox" name="agree" value="1"><span
                                                                style="color:blue; margin-left:10px; text-align:left"
                                                                required> Accept terms and conditions before
                                                                proceeding</span>


                                                    </div>
                                                    <input type="hidden" name="merchant_id"
                                                        value="{{Auth::user()->id}}">
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-success">Yes, I
                                                            Agree</button>
                                                    </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        @else
                                        <form action="{{route('endcashback')}}" method="post" id="endformcashback">
                                            @csrf
                                            <input type="hidden" name="id" value="{{Auth::id()}}">
                                            <a href="javascript:void()" class="btn btn-danger" id="cashback"
                                                onclick="$('#endformcashback').submit()">End Cashback Promo</a>
                                        </form>
                                        @endif
                                        <!-- end of cashback -->

                                    </div>

                                    <!-- beginning of request review-->
                                    <div class="col-md-3">
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                                            data-bs-target="#staticBackdrop2">
                                            Request for Review
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="staticBackdrop2" data-bs-backdrop="static"
                                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="staticBackdropLabel">Request for
                                                            Review</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{route('request review')}}" method="post">
                                                            @csrf
                                                            <div class="form-group">
                                                                <label>Enter Email Of Customer</label>
                                                                <input type="text" name="customer_email"
                                                                    class="form-control">
                                                            </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Request
                                                            Review</button>
                                                    </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end -->

                                    <!-- manage E-store -->
                                    <div class="col-md-3">
                                        <a href="{{route('ordering system')}}" target="_blank"
                                            class="btn btn-warning">Manage <br>E-Store</a>
                                    </div>
                                    <!-- end e-store -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card income-card">
                    <div class="card-header">
                        <div class="header-top d-sm-flex align-items-center">
                            <h5>Merchant Journey</h5>
                            <div class="center-content">
                                <p class="d-sm-flex align-items-center">
                                    {{-- <span class="font-primary m-r-10 f-w-700">{{ Auth::user()->currencySymbol . ''
                                        . number_format($data['totalPaidInvoice'], 2) }}</span><i
                                        class="toprightarrow-primary fa fa-arrow-up m-r-10"></i> --}}

                                    {{-- @if ($data['totalPaidInvoice'] != 0)
                                    {{ round(($data['paidInvoiceCount'] / $data['totalPaidInvoice']) * 100, 2) }}%
                                    @else
                                    0%
                                    @endif --}}

                                    <!-- merchant journey -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="wrapper option-1 option-1-1">
                                            <ol class="c-stepper">
                                                <li
                                                    class="c-stepper__item {{ $data['merchantstatus'] ? 'c-stepper__item__active' : '' }}">
                                                    <h3 class="c-stepper__title">Activate Account</h3>
                                                    {{-- <p class="c-stepper__desc">Some desc text</p> --}}
                                                </li>
                                                <li
                                                    class="c-stepper__item {{ $data['trial'] ? 'c-stepper__item__active' : '' }}">
                                                    <h3 class="c-stepper__title">30-Days Free Trials</h3>
                                                    {{-- <p class="c-stepper__desc">Some desc text</p> --}}
                                                </li>
                                                <li
                                                    class="c-stepper__item {{ $data['myplan'] ? 'c-stepper__item__active' : '' }}">
                                                    <h3 class="c-stepper__title">Completed</h3>
                                                    <p class="c-stepper__desc"
                                                        style="font-size:20px; font-weight:bold; color:red;">
                                                        {{ $data['myplan']->plan }}
                                                    </p>
                                                </li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                                <!-- end of merchant journey -->
                                </p>
                            </div>
                            <div class="setting-list">
                                <ul class="list-unstyled setting-option">
                                    <li>
                                        <div class="setting-primary"><i class="icon-settings"></i></div>
                                    </li>
                                    <li><i class="view-html fa fa-code font-primary"></i></li>
                                    <li><i class="icofont icofont-maximize full-card font-primary"></i></li>
                                    <li><i class="icofont icofont-minus minimize-card font-primary"></i></li>
                                    <li><i class="icofont icofont-refresh reload-card font-primary"></i></li>
                                    <li><i class="icofont icofont-error close-card font-primary"></i></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-10">
                        {{-- <div id="chart-timeline-dashbord"></div> --}}

                    </div>
                </div>

            </div>
            @else
            <div class="col-xl-7 box-col-12 des-xl-100 dashboard-sec">

                <div class="row">

                    @if ($data['specialInfo'] != null)
                    <div class="col-12">
                        <div class="card income-card">
                            <div class="card-header">
                                <div class="header-top d-sm-flex align-items-center">
                                    <h5>Special Information</h5>
                                </div>
                            </div>
                            <div class="card-body p-10">
                                {!! $data['specialInfo']->information !!}
                            </div>
                        </div>
                    </div>
                    @endif


                    <div class="col-xl-6 col-md-3 col-sm-6 box-col-3 des-xl-25 rate-sec">
                        <div class="card income-card card-primary">
                            <div class="card-body text-center">

                                <div class="round-box">

                                    <img src="https://img.icons8.com/ios/50/000000/home--v3.png" />
                                </div>
                                <div class="row">
                                    <div class="col-md-12">

                                        <a href="javascript:void()" onclick="whatyouOffer('{{ Auth::user()->email }}')"
                                            style="color: navy; font-weight: 700;"> Click to activate Manage
                                            Rental
                                            Property, MRP</a>

                                        {{-- <a href="{{ route('rentalManagementAdmin') }}"
                                            style="color: navy; font-weight: 700;">Rental Property Management</a> --}}
                                    </div>
                                </div>

                                <div class="parrten">
                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                        viewbox="0 0 448.057 448.057" style="enable-background:new 0 0 448.057 448.057;"
                                        xml:space="preserve">
                                        <g>
                                            <g>
                                                <path
                                                    d="M404.562,7.468c-0.021-0.017-0.041-0.034-0.062-0.051c-13.577-11.314-33.755-9.479-45.069,4.099                                            c-0.017,0.02-0.034,0.041-0.051,0.062l-135.36,162.56L88.66,11.577C77.35-2.031,57.149-3.894,43.54,7.417                                            c-13.608,11.311-15.471,31.512-4.16,45.12l129.6,155.52h-40.96c-17.673,0-32,14.327-32,32s14.327,32,32,32h64v144                                            c0,17.673,14.327,32,32,32c17.673,0,32-14.327,32-32v-180.48l152.64-183.04C419.974,38.96,418.139,18.782,404.562,7.468z">
                                                </path>
                                            </g>
                                        </g>
                                        <g>
                                            <g>
                                                <path
                                                    d="M320.02,208.057h-16c-17.673,0-32,14.327-32,32s14.327,32,32,32h16c17.673,0,32-14.327,32-32                                            S337.694,208.057,320.02,208.057z">
                                                </path>
                                            </g>
                                        </g>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-3 col-sm-6 box-col-3 des-xl-25 rate-sec">
                        <div class="card income-card card-secondary">
                            <div class="card-body text-center">
                                <div class="round-box">

                                    <img src="https://img.icons8.com/pastel-glyph/50/000000/user-female.png" />
                                </div>
                                <div class="row">
                                    <div class="col-md-12">

                                        <a href="javascript:void()"
                                            onclick="viewConsultant('{{ Auth::user()->email }}')"
                                            style="color: navy; font-weight: 700;">Click to Access MRP as a
                                            Service
                                            Provider</a>

                                        {{-- <a href="{{ route('rentalManagementAdmin') }}"
                                            style="color: navy; font-weight: 700;">Rental Property Management</a> --}}
                                    </div>
                                </div>
                                <div class="parrten">
                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewbox="0 0 512 512"
                                        style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                        <g>
                                            <g>
                                                <path
                                                    d="M256,0C114.615,0,0,114.615,0,256s114.615,256,256,256s256-114.615,256-256S397.385,0,256,0z M96,100.16                                            c50.315,35.939,80.124,94.008,80,155.84c0.151,61.839-29.664,119.919-80,155.84C11.45,325.148,11.45,186.851,96,100.16z M256,480                                            c-49.143,0.007-96.907-16.252-135.84-46.24C175.636,391.51,208.14,325.732,208,256c0.077-69.709-32.489-135.434-88-177.6                                            c80.1-61.905,191.9-61.905,272,0c-98.174,75.276-116.737,215.885-41.461,314.059c11.944,15.577,25.884,29.517,41.461,41.461                                            C353.003,463.884,305.179,480.088,256,480z M416,412v-0.16c-86.068-61.18-106.244-180.548-45.064-266.616                                            c12.395-17.437,27.627-32.669,45.064-45.064C500.654,186.871,500.654,325.289,416,412z">
                                                </path>
                                            </g>
                                        </g>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if (Auth::user()->plan == 'classic')
                <div class="row">
                    <div class="col-xl-12 col-md-6 col-sm-12 box-col-6 des-xl-25 rate-sec">
                        <div class="card income-card card-secondary">
                            <div class="card-body text-center">
                                <div class="round-box">

                                    <img src="https://img.icons8.com/ios-filled/50/000000/exchange.png" />
                                </div>
                                <div class="row">
                                    <div class="col-md-12">

                                        <p>Trade FX with PaySprint</p>

                                        <a type="button" class="btn btn-success" href="javascript:void()">PaySprint
                                            FX</a>


                                        <hr>

                                        <a href="#" style="color: navy; font-weight: 700;">Learn more
                                            about
                                            trading
                                            on PaySprint</a>

                                    </div>
                                </div>
                                <div class="parrten">
                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewbox="0 0 512 512"
                                        style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                        <g>
                                            <g>
                                                <path
                                                    d="M256,0C114.615,0,0,114.615,0,256s114.615,256,256,256s256-114.615,256-256S397.385,0,256,0z M96,100.16                                            c50.315,35.939,80.124,94.008,80,155.84c0.151,61.839-29.664,119.919-80,155.84C11.45,325.148,11.45,186.851,96,100.16z M256,480                                            c-49.143,0.007-96.907-16.252-135.84-46.24C175.636,391.51,208.14,325.732,208,256c0.077-69.709-32.489-135.434-88-177.6                                            c80.1-61.905,191.9-61.905,272,0c-98.174,75.276-116.737,215.885-41.461,314.059c11.944,15.577,25.884,29.517,41.461,41.461                                            C353.003,463.884,305.179,480.088,256,480z M416,412v-0.16c-86.068-61.18-106.244-180.548-45.064-266.616                                            c12.395-17.437,27.627-32.669,45.064-45.064C500.654,186.871,500.654,325.289,416,412z">
                                                </path>
                                            </g>
                                        </g>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <div class="card income-card">
                    <div class="card-header">
                        <div class="header-top d-sm-flex align-items-center">


                            <h5>Sales overview</h5>
                            <div class="center-content">
                                <p class="d-sm-flex align-items-center">
                                    {{-- <span class="font-primary m-r-10 f-w-700">{{ Auth::user()->currencySymbol . ''
                                        . number_format($data['totalPaidInvoice'], 2) }}</span><i
                                        class="toprightarrow-primary fa fa-arrow-up m-r-10"></i> --}}

                                    {{-- @if ($data['totalPaidInvoice'] != 0)
                                    {{ round(($data['paidInvoiceCount'] / $data['totalPaidInvoice']) * 100, 2) }}%
                                    @else
                                    0%
                                    @endif --}}
                                    (Coming Soon)
                                </p>
                            </div>
                            <div class="setting-list">
                                <ul class="list-unstyled setting-option">
                                    <li>
                                        <div class="setting-primary"><i class="icon-settings"></i></div>
                                    </li>
                                    <li><i class="view-html fa fa-code font-primary"></i></li>
                                    <li><i class="icofont icofont-maximize full-card font-primary"></i></li>
                                    <li><i class="icofont icofont-minus minimize-card font-primary"></i></li>
                                    <li><i class="icofont icofont-refresh reload-card font-primary"></i></li>
                                    <li><i class="icofont icofont-error close-card font-primary"></i></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-10">
                        {{-- <div id="chart-timeline-dashbord"></div> --}}

                    </div>
                </div>

            </div>
            @endif





        </div>
    </div>



    @if ($data['clientInfo']->accountMode == 'test')
    {{-- Start Test Mode --}}

    <div class="alert alert-danger">
        <h5 class="mb-3 text-center"><strong>Take this steps to activate account</strong></h5>
    </div>

    <div class="card mb-3" style="max-width: 100%; cursor: pointer;"
        onclick="location.href=`{{ route('merchant profile') }}`">
        <div class="card-body border border-danger">

            <h5 class="card-title"> <img
                    src="https://img.icons8.com/external-xnimrodx-blue-xnimrodx/50/000000/external-verify-bill-and-payment-method-xnimrodx-blue-xnimrodx.png" />
                <strong>Verify Your Business</strong>

            </h5>
            <p class="card-text">Verify your business to start enjoying full access to PaySprint features.</p>
        </div>
    </div>



    <div class="card mb-3" style="max-width: 100%; cursor: pointer;"
        onclick="location.href=`{{ route('set up tax') }}`">
        <div class="card-body border border-danger">

            <h5 class="card-title"> <img
                    src="https://img.icons8.com/external-kiranshastry-lineal-color-kiranshastry/50/000000/external-file-interface-kiranshastry-lineal-color-kiranshastry-1.png" />
                <strong>Set Up Tax</strong>

            </h5>
            <p class="card-text">Set up applicable taxes to help you easily generate invoices</p>
        </div>
    </div>


    <div class="card mb-3" style="max-width: 100%; cursor: pointer;"
        onclick="location.href=`{{ route('payment gateway') }}`">
        <div class="card-body border border-danger">

            <h5 class="card-title"> <img
                    src="https://img.icons8.com/external-vitaliy-gorbachev-lineal-color-vitaly-gorbachev/50/000000/external-bank-business-vitaliy-gorbachev-lineal-color-vitaly-gorbachev.png" />
                <strong>Set Up Bank Account</strong>

            </h5>
            <p class="card-text">Set up bank account to withdraw money to bank</p>
        </div>
    </div>

    <br>
    <br>

    {{-- End Test Mode --}}
    @else
    <div class="col-xl-12 recent-order-sec">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
                            type="button" role="tab" aria-controls="profile" aria-selected="false">
                            <h6>Paid Invoice </h6>

                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link " id="home-tab" data-bs-toggle="tab" data-bs-target="#home"
                            type="button" role="tab" aria-controls="home" aria-selected="true">
                            <h6>Received Invoice</h6>
                        </button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact"
                            type="button" role="tab" aria-controls="contact" aria-selected="false">
                            <h6>Invoice to Link Customers</h6>
                        </button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button class="nav-link btn btn-default" type="button" role="tab"
                            onclick="location.href='{{ route('getwalletStatement') }}'">
                            <h6>Transaction History</h6>
                        </button>
                    </li>

                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="table-responsive">

                            <table class="table table-bordernone table-striped invoicetable">
                                <thead>
                                    <tr>
                                        <th>Transaction ID</th>
                                        <th>Pay Date</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Amount</th>
                                        <th>Invoice #</th>
                                        <th>Service</th>

                                    </tr>
                                </thead>
                                <tbody>

                                    @if (count($data['allPaidInvoice']) > 0)
                                    @foreach ($data['allPaidInvoice'] as $payInvoices)
                                    <tr>
                                        <td>
                                            <div class="media"><img class="img-fluid rounded-circle"
                                                    src=" {{ asset('merchantassets/assets/images/dashboard/icons8-invoice-30.png') }}"
                                                    alt="" data-original-title="" title="">
                                                <div class="media-body"><a href="#"><span>{{ $payInvoices->transactionid
                                                            }}</span></a>
                                                </div>
                                            </div>

                                        </td>
                                        <td>
                                            {{ date('d/M/Y', strtotime($payInvoices->created_at)) }}
                                        </td>
                                        <td>{{ $payInvoices->name }}</td>
                                        <td>{{ $payInvoices->email }}</td>
                                        <td style="font-weight: bold; color: green;">
                                            {{ Auth::user()->currencySymbol . '' . number_format($payInvoices->amount,
                                            2) }}
                                        </td>
                                        <td>{{ $payInvoices->invoice_no }}</td>
                                        <td>{{ $payInvoices->service }}</td>


                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="8" align="center">
                                            <p>No record</p>
                                        </td>
                                    </tr>
                                    @endif



                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="table-responsive">

                            <table class="table table-bordernone table-striped invoicetable">
                                <thead>
                                    <tr>


                                        <th>Description</th>
                                        <th>Invoice #</th>
                                        <th>Status</th>
                                        <th>Amount</th>
                                        <th>Created Date</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($data['receivedInvoice']))
                                    <?php $i = 1; ?>
                                    @foreach (json_decode($data['receivedInvoice']) as $payInv)
                                    {{-- Get Merchant Currency --}}

                                    @if ($merchant = \App\User::where('ref_code', $payInv->uploaded_by)->first())
                                    @if ($payInv->invoiced_currency != null)
                                    @php
                                    $currencySymb = $payInv->invoiced_currency_symbol;
                                    @endphp
                                    @else
                                    @php
                                    $currencySymb = $merchant->currencySymbol;
                                    @endphp
                                    @endif


                                    @php
                                    $countryBase = $merchant->country;
                                    @endphp
                                    @else
                                    @if ($payInv->invoiced_currency != null)
                                    @php
                                    $currencySymb = $payInv->invoiced_currency_symbol;
                                    @endphp
                                    @else
                                    @php
                                    $currencySymb = Auth::user()->currencySymbol;
                                    @endphp
                                    @endif

                                    @php
                                    $countryBase = Auth::user()->country;
                                    @endphp
                                    @endif

                                    <tr>


                                        <td>
                                            {!! 'Invoice for ' . $payInv->service . ' to ' . $payInv->merchantName !!}
                                        </td>

                                        <td>{{ $payInv->invoice_no }} {!! $countryBase != Auth::user()->country
                                            ? '<img
                                                src="https://img.icons8.com/color/30/000000/around-the-globe.png" />'
                                            : '' !!}</td>



                                        @if ($payInv->payment_status == 0)
                                        <td>
                                            <a href="{{ route('payment', $payInv->invoice_no) }}" type="button"
                                                class='btn btn-danger'>Pay Invoice</a>
                                        </td>
                                        @elseif($payInv->payment_status == 2)
                                        <td>
                                            <a href="{{ route('payment', $payInv->invoice_no) }}" type="button"
                                                class='btn btn-danger' style='cursor: pointer;'>Pay Balance</a>
                                        </td>
                                        @else
                                        <td style="font-weight: bold; color: green;">Paid</td>
                                        @endif

                                        <td style="font-weight: 700">
                                            @php
                                            if ($payInv->total_amount != null || $payInv->total_amount != 0) {
                                            $totalAmount = $payInv->total_amount;
                                            } else {
                                            $totalAmount = $payInv->amount;
                                            }
                                            @endphp

                                            @if ($payInv->payment_status == 0)
                                            {{ '+' . $currencySymb . number_format($totalAmount, 2) }}
                                            @elseif($payInv->payment_status == 2)
                                            {{ '-' . $currencySymb . number_format($payInv->remaining_balance, 2) }}
                                            @else
                                            {{ '-' . $currencySymb . number_format($totalAmount, 2) }}
                                            @endif

                                        </td>

                                        <td>{{ date('d/m/Y h:i a', strtotime($payInv->created_at)) }}
                                        </td>


                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="5" align="center"> No uploaded Invoice yet</td>
                                    </tr>
                                    @endif


                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                        <div class="table-responsive">

                            <table class="table table-bordernone invoicetable">
                                <thead>
                                    <tr>
                                        <th>Created Date</th>
                                        <th>Transx. Date</th>
                                        <th>Invoice #</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Service</th>
                                        <th>Amount</th>
                                        <th>Tax Amount</th>
                                        <th>Total Amount</th>
                                        <th>Status</th>
                                        <th>Pay Due Date</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody>

                                    @if (count($data['invoiceLink']) > 0)
                                    @foreach ($data['invoiceLink'] as $invoiceLinkImports)
                                    <tr>
                                        <td>
                                            <div class="media"><img class="img-fluid rounded-circle"
                                                    src=" {{ asset('merchantassets/assets/images/dashboard/icons8-invoice-30.png') }}"
                                                    alt="" data-original-title="" title="">
                                                <div class="media-body"><a href="#"><span>{{ date('d/M/Y',
                                                            strtotime($invoiceLinkImports->created_at)) }}</span></a>
                                                </div>
                                            </div>
                                        </td>

                                        <td>{{ date('d/M/Y', strtotime($invoiceLinkImports->transaction_date)) }}
                                        </td>
                                        <td>{{ $invoiceLinkImports->invoice_no }}</td>
                                        <td>{{ $invoiceLinkImports->name }}</td>
                                        <td title="{{ $invoiceLinkImports->payee_email }}">
                                            <?php $string = $invoiceLinkImports->payee_email;
                                        $output = strlen($string) > 10 ? substr($string, 0, 10) . '...' : $string;
                                        echo $output; ?>
                                        </td>
                                        <td title="{{ $invoiceLinkImports->service }}">
                                            <?php $string = $invoiceLinkImports->service;
                                        $output = strlen($string) > 10 ? substr($string, 0, 10) . '...' : $string;
                                        echo $output; ?>
                                        </td>
                                        <td align="center" style="font-weight: bold; color: navy;">
                                            {{ Auth::user()->currencySymbol . number_format($invoiceLinkImports->amount,
                                            2) }}
                                        </td>

                                        <td align="center" style="font-weight: bold; color: purple;">
                                            {{ Auth::user()->currencySymbol .
                                            number_format($invoiceLinkImports->tax_amount, 2) }}
                                        </td>

                                        <td align="center" style="font-weight: bold; color: green;">
                                            {{ Auth::user()->currencySymbol .
                                            number_format($invoiceLinkImports->total_amount, 2) }}
                                        </td>

                                        @if ($invoiceLinkImports->payment_status == 1)
                                        <td align="center" style="font-weight: bold; color: green;">
                                            Paid
                                        </td>
                                        @elseif ($invoiceLinkImports->payment_status == 2)
                                        <td align="center" style="font-weight: bold; color: purple;">
                                            Part
                                            Pay</td>
                                        @else
                                        <td align="center" style="font-weight: bold; color: red;">
                                            Unpaid
                                        </td>
                                        @endif
                                        <td>{{ date('d/M/Y', strtotime($invoiceLinkImports->payment_due_date)) }}
                                        </td>

                                        <td>
                                            <a href="{{ route('link customer', $invoiceLinkImports->id) }}"
                                                type="button" class="btn btn-primary text-white">details</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="11" align="right">No record</td>
                                    </tr>
                                    @endif


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div>

    <div class="col-xl-12 col-50 box-col-6 des-xl-50">
        <div class="card latest-update-sec">
            <div class="card-header">
                <div class="header-top d-sm-flex align-items-center">
                    <h5>Invoice List</h5>
                    <div class="center-content">

                    </div>
                    <div class="setting-list">
                        <ul class="list-unstyled setting-option">
                            <li>
                                <div class="setting-primary"><i class="icon-settings"></i></div>
                            </li>
                            <li><i class="icofont icofont-maximize full-card font-primary"></i>
                            </li>
                            <li><i class="icofont icofont-minus minimize-card font-primary"></i>
                            </li>
                            <li><i class="icofont icofont-refresh reload-card font-primary"></i>
                            </li>
                            <li><i class="icofont icofont-error close-card font-primary"> </i></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordernone invoicetable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Created Date</th>
                                <th>Trans. Date</th>
                                <th>Invoice #</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Service</th>
                                <th>Amount</th>
                                <th>Tax Amount</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                                <th>Pay Due Date</th>
                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            @if (count($data['invoiceList']) > 0)
                            <?php $i = 1; ?>
                            @foreach ($data['invoiceList'] as $invoiceImports)
                            @if ($invoiceImports->invoiced_currency != null)
                            @php
                            $symbolVal = $invoiceImports->invoiced_currency_symbol;
                            @endphp
                            @else
                            @php
                            $symbolVal = Auth::user()->currencySymbol;
                            @endphp
                            @endif

                            <tr>


                                <td>{{ $i++ }}</td>
                                <td>{{ date('d/M/Y', strtotime($invoiceImports->created_at)) }}</td>
                                <td>{{ date('d/M/Y', strtotime($invoiceImports->transaction_date)) }}
                                </td>
                                <td>{{ $invoiceImports->invoice_no }}</td>
                                <td>{{ $invoiceImports->name }}</td>
                                <td title="{{ $invoiceImports->payee_email }}">
                                    <?php $string = $invoiceImports->payee_email;
                                                                            $output = strlen($string) > 10 ? substr($string, 0, 10) . '...' : $string;
                                                                            echo $output; ?>
                                </td>
                                <td title="{{ $invoiceImports->service }}">
                                    <?php $string = $invoiceImports->service;
                                                                        $output = strlen($string) > 10 ? substr($string, 0, 10) . '...' : $string;
                                                                        echo $output; ?>
                                </td>
                                <td align="center" style="font-weight: bold; color: navy;">
                                    {{ $symbolVal . number_format($invoiceImports->amount, 2) }}
                                </td>

                                <td align="center" style="font-weight: bold; color: purple;">
                                    {{ $symbolVal . number_format($invoiceImports->tax_amount, 2) }}
                                </td>

                                <td align="center" style="font-weight: bold; color: green;">
                                    {{ $symbolVal . number_format($invoiceImports->total_amount, 2) }}
                                </td>

                                @if ($invoiceImports->payment_status == 1)
                                <td align="center" style="font-weight: bold; color: green;">Paid
                                </td>
                                @elseif ($invoiceImports->payment_status == 2)
                                <td align="center" style="font-weight: bold; color: purple;">Part
                                    Pay</td>
                                @else
                                <td align="center" style="font-weight: bold; color: red;">Unpaid
                                </td>
                                @endif


                                <td>{{ date('d/M/Y', strtotime($invoiceImports->payment_due_date)) }}
                                </td>
                                <td>
                                    <a href="{{ route('customer', $invoiceImports->id) }}" type="button"
                                        class="btn btn-primary text-white">details</a>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="10" align="center"> No uploaded Invoice yet</td>
                            </tr>
                            @endif


                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>


    @endif



    <!-- Container-fluid Ends-->
    <!-- Container-fluid Ends-->
</div>
@endsection