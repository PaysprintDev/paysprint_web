<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <!-- Favicon -->
    <link rel="icon"
        href="https://res.cloudinary.com/paysprint/image/upload/v1651130089/assets/paysprint_icon_png_rhxm1e_sqhgj0.png"
        type="image/x-icon" />

    <link rel="stylesheet" type="text/css" href="{{ asset('pace/themes/orange/pace-theme-flash.css') }}" />

    <script src="https://kit.fontawesome.com/384ade21a6.js"></script>

    <title>PaySprint | Money Transfer</title>

    <style>
        body {
            background: #f5f5f5
        }

        .rounded {
            border-radius: 1rem
        }

        .nav-pills .nav-link {
            color: #555
        }

        .nav-pills .nav-link.active {
            color: white
        }

        input[type="radio"] {
            margin-right: 5px
        }

        .bold {
            font-weight: bold
        }

        .disp-0 {
            display: none !important;
        }
    </style>

</head>

<body>
    <div class="container py-5">
        <!-- For demo purpose -->
        <div class="row mb-4">
            <div class="col-lg-6 mx-auto text-center">
                <h1 class="display-4">Send Money to Non-PaySprint User</h1>
            </div>
        </div> <!-- End -->
        <div class="row">
            <div class="col-lg-6 mx-auto">
                <div class="card ">
                    <div class="card-header">
                        <div class="bg-white shadow-sm pt-4 pl-2 pr-2 pb-2">
                            <!-- Credit card form tabs -->
                            <ul role="tablist" class="nav bg-light nav-pills rounded nav-fill mb-3">
                                <li class="nav-item" onclick="location.href='{{ route('payorganization') }}'">
                                    <a data-toggle="pill" href="{{ route('payorganization') }}"
                                        class="nav-link active "> <i class="fas fa-home"></i> Go Back </a>
                                </li>
                                {{-- <li class="nav-item"> <a data-toggle="pill" href="#paypal" class="nav-link "> <i class="fab fa-paypal mr-2"></i> Debit Card </a> </li>
                                <li class="nav-item"> <a data-toggle="pill" href="#net-banking" class="nav-link "> <i class="fas fa-mobile-alt mr-2"></i> EXBC Card </a> </li> --}}
                            </ul>
                        </div> <!-- End -->
                        <!-- Credit card form content -->
                        <div class="tab-content">


                            {{-- 234-90695 --}}

                            <!-- credit card info-->
                            <div id="credit-card" class="tab-pane fade show active pt-3">



                                <form role="form" action="#" method="POST" id="formElem">
                                    @csrf



                                    <input type="hidden" name="orgpayname" id="orgpayname" value="{{ $name }}">

                                    <input type="hidden" name="orgpayemail" id="orgpayemail"
                                        value="{{ $email }}">

                                    <input type="hidden" name="code" id="code"
                                        value="{{ $data['currencyCode']->callingCode }}">

                                    <input type="hidden" name="paymentToken" id="paymentToken" value="">

                                    <div class="form-group"> <label for="fname">
                                            <h6>How do you want the beneficiary to get paid?</h6>
                                        </label>
                                        <div class="input-group">

                                            <select name="paymentMode" id="paymentMode" class="form-control">
                                                <option value="">Select option</option>
                                                <option value="PaySprint">Beneficiary to accept payment on PaySprint mobile app (No
                                                    transfer Fee)</option>
                                                <option value="Partner">Beneficiary get paid via dedicated partners
                                                    (Transfer Fee applies)</option>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="form-group"> <label for="paymentWallet">
                                            <h6>Select Payment Wallet</h6>
                                        </label>
                                        <div class="input-group">

                                            <select name="paymentWallet" id="paymentWallet" class="form-control">
                                                <option value="">Select option</option>
                                                <option value="ps_wallet">PaySprint Wallet</option>
                                                <option value="fx_wallet">PaySprint FX Wallet</option>
                                            </select>

                                        </div>
                                    </div>

                                    <div class="form-group disp-0 wallet_details">

                                        <div class="alert alert-warning">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h4>
                                                        Wallet Balance
                                                    </h4>
                                                </div>
                                                <div class="col-md-12">
                                                    <h4>
                                                        {{ $data['currencyCode']->currencySymbol . '' . number_format(Auth::user()->wallet_balance, 4) }}
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>


                                    </div>

                                    <div class="form-group disp-0 fx_wallet_details"> <label for="paymentFxWallet">
                                            <h6>Select Payment Wallet</h6>
                                        </label>
                                        <div class="input-group">

                                            <select name="paymentFxWallet" id="paymentFxWallet" class="form-control">
                                                <option value="">Select PaySprint FX wallet</option>
                                            </select>

                                        </div>
                                    </div>

                                    <div class="form-group disp-0"> <label for="make_payment_method">
                                            <h6>Transfer Method</h6>
                                        </label>
                                        <div class="input-group">
                                            <select name="payment_method" id="make_payment_method" class="form-control"
                                                required>
                                                <option value="">Select Payment Method</option>
                                                <option value="Wallet" selected>Wallet</option>
                                                {{-- <option value="Credit Card">Credit Card</option> --}}
                                                {{-- <option value="Debit Card">Debit Card</option> --}}
                                                {{-- <option value="EXBC Card">EXBC Card</option> --}}
                                            </select>

                                        </div>
                                    </div>


                                    <div class="form-group creditcard disp-0"> <label for="card_id">
                                            <h6>Select Card</h6>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-append"> <span class="input-group-text text-muted">
                                                    <img
                                                        src="https://img.icons8.com/fluent/20/000000/bank-card-back-side.png" />
                                                </span> </div>
                                            <select name="card_id" id="card_id" class="form-control" required>
                                                @if (count($data['getCard']) > 0)
                                                    @foreach ($data['getCard'] as $mycard)
                                                        <option value="{{ $mycard->id }}">{!! wordwrap(
                                                            substr($mycard->card_number, 0, 4) .
                                                                str_repeat('*', strlen($mycard->card_number) - 8) .
                                                                substr($mycard->card_number, -4),
                                                            4,
                                                            ' - ',
                                                            true,
                                                        ) !!}
                                                        </option>
                                                    @endforeach
                                                @else
                                                    <option value="">Add a new card</option>
                                                @endif
                                            </select>

                                        </div>
                                    </div>



                                    <div class="paywithpaysprint disp-0">
                                        <h4>Beneficiary's Information</h4>
                                        <hr>

                                        <div class="form-group"> <label for="orgpayservice">
                                                <h6>Country</h6>
                                            </label>
                                            <div class="input-group">
                                                <select id="country" name="country" class="form-control" readonly>
                                                    <option value="{{ Auth::user()->country }}" selected>
                                                        {{ Auth::user()->country }}</option>

                                                    @if (count($data['availablecountry']))
                                                        @foreach ($data['availablecountry'] as $country)
                                                            <option data-countryCode="{{ $country->code }}"
                                                                value="{{ $country->callingCode }}">
                                                                {{ $country->name }}</option>
                                                        @endforeach

                                                    @endif
                                                </select>


                                            </div>
                                        </div>

                                        <div class="form-group"> <label for="fname">
                                                <h6>First Name</h6>
                                            </label>
                                            <div class="input-group">
                                                <input type="text" name="fname" id="fname"
                                                    placeholder="First Name" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group"> <label for="lname">
                                                <h6>Last Name</h6>
                                            </label>
                                            <div class="input-group">
                                                <input type="text" name="lname" id="lname"
                                                    placeholder="Last Name" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group"> <label for="email">
                                                <h6>Email Address</h6>
                                            </label>
                                            <div class="input-group">
                                                <input type="email" name="email" id="email"
                                                    placeholder="Email Address" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group"> <label for="phone">
                                                <h6>Telephone</h6>
                                            </label>
                                            <div class="input-group">
                                                <select name="countryCode" id="reccountryCode"
                                                    class="form-control billinginput_box" readonly>
                                                    <option value="{{ Auth::user()->code }}" selected>
                                                        {{ Auth::user()->country }} (+{{ Auth::user()->code }})
                                                    </option>

                                                    @if (count($data['availablecountry']))
                                                        @foreach ($data['availablecountry'] as $country)
                                                            <option data-countryCode="{{ $country->code }}"
                                                                value="{{ $country->callingCode }}">
                                                                {{ $country->name }}(+{{ $country->callingCode }})
                                                            </option>
                                                        @endforeach

                                                    @endif


                                                </select>
                                                <input type="number" min="0" step="1" name="phone"
                                                    id="phone" placeholder="Telephone" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group"> <label for="orgpayservice">
                                                <h6>Purpose of Transfer</h6>
                                            </label>
                                            <div class="input-group">
                                                <select name="service" id="orgpayservice" class="form-control"
                                                    required>
                                                    <option value="Offering">Offering</option>
                                                    <option value="Tithe">Tithe</option>
                                                    <option value="Seed">Seed</option>
                                                    <option value="Contribution">Contribution</option>
                                                    <option value="Others">Others</option>
                                                </select>

                                            </div>
                                        </div>

                                        <div class="form-group others disp-0"> <label for="orgpaypurpose">
                                                <h6>Specify Purpose</h6>
                                            </label>
                                            <div class="input-group">
                                                <input type="text" name="purpose" id="orgpaypurpose"
                                                    placeholder="Specify Purpose" class="form-control">

                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group"> <label for="currency">
                                                        <h6>Currency</h6>
                                                    </label>
                                                    <input type="hidden" name="localcurrency"
                                                        value="{{ $data['currencyCode']->currencyCode }}">
                                                    <div class="input-group">
                                                        <select name="currency" id="currency" class="form-control"
                                                            readonly>
                                                            <option value="{{ $data['currencyCode']->currencyCode }}"
                                                                selected>{{ $data['currencyCode']->currencyCode }}
                                                            </option>
                                                        </select>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group"> <label for="orgpayamount">
                                                        <h6>Amount to Send</h6>
                                                    </label>
                                                    <div class="input-group"> <input type="number" name="amount"
                                                            id="orgpayamount" placeholder="50.00"
                                                            class="form-control" maxlength="16" required>
                                                        <div class="input-group-append"> <span
                                                                class="input-group-text text-muted"> <i
                                                                    class="fas fa-money-check mx-1"></i> <i
                                                                    class="fab fa-cc-mastercard mx-1"></i> <i
                                                                    class="fab fa-cc-amex mx-1"></i> </span> </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="form-group disp-0">
                                            <div class="input-group">
                                                <p style="color: red; font-weight: bold;"><input type="checkbox"
                                                        name="commission" id="commission"> Transfer include commission
                                                </p>

                                            </div>
                                        </div>

                                        <div class="form-group disp-0"> <label for="netwmount">
                                                <h6>Currency Conversion <br><small class="text-info"><b>Exchange rate
                                                            today according to currencylayer.com</b></small></h6>
                                                <p style="font-weight: bold;">
                                                    {{ $data['currencyCode']->currencyCode }} <=> USD
                                                </p>
                                            </label>
                                            <div class="input-group">
                                                <input type="text" name="conversionamount" class="form-control"
                                                    id="conversionamount" value="" placeholder="0.00" readonly>
                                            </div>
                                        </div>

                                        <div class="form-group"> <label for="netwmount">
                                                <h6>Net Amount <br><small class="text-success"><b>Total amount that
                                                            would
                                                            be received</b></small></h6>

                                            </label>
                                            <div class="input-group">
                                                <input type="text" name="amounttosend" class="form-control"
                                                    id="amounttosend" value="" placeholder="0.00" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group"> <label for="netwmount">
                                                <h6>Fee <small class="text-success"><b>(FREE)</b></small></h6>
                                            </label>
                                            <div class="input-group">
                                                <input type="text" name="commissiondeduct" class="form-control"
                                                    id="commissiondeduct" value="" placeholder="0.00" readonly>

                                                <input type="hidden" name="totalcharge" class="form-control"
                                                    id="totalcharge" value="" placeholder="0.00" readonly>

                                            </div>
                                        </div>

                                        <div class="form-group"> <label for="transaction_pin">
                                                <h6>Transaction Pin</h6>
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-append"> <span
                                                        class="input-group-text text-muted">
                                                        <i class="fas fa-lock"></i> </span> </div> <input
                                                    type="password" name="transaction_pin" id="transaction_pin"
                                                    class="form-control" maxlength="4" required>

                                            </div>
                                        </div>

                                        <div class="form-group disp-0">
                                            <span class="text-success">Please note that International transfer are sent
                                                in
                                                USD conversion</span>
                                        </div>

                                        <hr>

                                        <div class="form-group">
                                            <strong><span class="text-danger wallet-info"></span></strong>
                                        </div>

                                        <div class="form-group">
                                            <div class="commissionInfo"></div>
                                        </div>

                                        <div class="card-footer">



                                            <div class="row">
                                                <div class="col-md-12 withCardGoogle disp-0">
                                                    <center>
                                                        <div id="container"></div>
                                                    </center>
                                                </div>

                                                <div class="col-md-12 withWallet">
                                                    <button type="button" onclick="handShake('createnew')"
                                                        class="subscribe btn btn-primary btn-block shadow-sm sendmoneyBtn">
                                                        Send Money </button>
                                                </div>

                                                {{-- <div class="col-md-6">
                                                <button type="button" onclick="beginApplePay()" class="subscribe btn btn-primary btn-block shadow-sm disp-0"> Apple Pay </button>
                                            </div> --}}
                                            </div>


                                        </div>
                                    </div>

                                    <div class="paywithpatners disp-0">
                                        <h4>Beneficiary's Information</h4>
                                        <hr>

                                        <div class="form-group"> <label for="orgpayservice">
                                                <h6>Country</h6>
                                            </label>
                                            <div class="input-group">
                                                <select id="partner_country" name="country" class="form-control"
                                                    readonly>
                                                    <option value="{{ Auth::user()->country }}" selected>
                                                        {{ Auth::user()->country }}</option>

                                                    @if (count($data['availablecountry']))
                                                        @foreach ($data['availablecountry'] as $country)
                                                            <option data-countryCode="{{ $country->code }}"
                                                                value="{{ $country->name }}">
                                                                {{ $country->name }}</option>
                                                        @endforeach

                                                    @endif
                                                </select>


                                            </div>
                                        </div>


                                        <div class="paymentpolicySupport disp-0">


                                            <div class="compulsory_data disp-0">
                                            </div>
                                            <div class="mandatory_data disp-0">
                                            </div>
                                            <div class="payoutAgent_data disp-0">
                                            </div>
                                            <div class="paymentType_data disp-0">
                                            </div>
                                            <div class="remittance_company_data disp-0">
                                            </div>
                                            <div class="information_data disp-0"></div>

                                            <br>
                                           <h4>Other Information</h4>
                                        <hr>


                                        <div class="form-group"> <label for="orgpayservice">
                                                <h6>Purpose of Transfer</h6>
                                            </label>
                                            <div class="input-group">
                                                <select name="service" id="partner_orgpayservice"
                                                    class="form-control" required>
                                                    <option value="Offering">Offering</option>
                                                    <option value="Tithe">Tithe</option>
                                                    <option value="Seed">Seed</option>
                                                    <option value="Contribution">Contribution</option>
                                                    <option value="Others">Others</option>
                                                </select>

                                            </div>
                                        </div>

                                        <div class="form-group others disp-0"> <label for="orgpaypurpose">
                                                <h6>Specify Purpose</h6>
                                            </label>
                                            <div class="input-group">
                                                <input type="text" name="purpose" id="partner_orgpaypurpose"
                                                    placeholder="Specify Purpose" class="form-control">

                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group"> <label for="currency">
                                                        <h6>Currency</h6>
                                                    </label>
                                                    <input type="hidden" name="localcurrency"
                                                        value="{{ $data['currencyCode']->currencyCode }}">
                                                    <div class="input-group">
                                                        <select name="currency" id="partner_currency"
                                                            class="form-control" readonly>
                                                            <option value="{{ $data['currencyCode']->currencyCode }}"
                                                                selected>{{ $data['currencyCode']->currencyCode }}
                                                            </option>
                                                        </select>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group"> <label for="orgpayamount">
                                                        <h6>Amount to Send</h6>
                                                    </label>
                                                    <div class="input-group"> <input type="number" name="amount"
                                                            id="partner_orgpayamount" placeholder="50.00"
                                                            class="form-control" maxlength="16" required>
                                                        <div class="input-group-append"> <span
                                                                class="input-group-text text-muted"> <i
                                                                    class="fas fa-money-check mx-1"></i> <i
                                                                    class="fab fa-cc-mastercard mx-1"></i> <i
                                                                    class="fab fa-cc-amex mx-1"></i> </span> </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="form-group disp-0">
                                            <div class="input-group">
                                                <p style="color: red; font-weight: bold;"><input type="checkbox"
                                                        name="commission" id="partner_commission"> Transfer include
                                                    commission
                                                </p>

                                            </div>
                                        </div>

                                        <div class="form-group disp-0"> <label for="netwmount">
                                                <h6>Currency Conversion <br><small class="text-info"><b>Exchange rate
                                                            today according to currencylayer.com</b></small></h6>
                                                <p style="font-weight: bold;">
                                                    {{ $data['currencyCode']->currencyCode }} <=> USD
                                                </p>
                                            </label>
                                            <div class="input-group">
                                                <input type="text" name="conversionamount" class="form-control"
                                                    id="partner_conversionamount" value="" placeholder="0.00"
                                                    readonly>
                                            </div>
                                        </div>

                                        <div class="form-group"> <label for="netwmount">
                                                <h6>Net Amount <br><small class="text-success"><b>Total amount that
                                                            would
                                                            be received</b></small></h6>

                                            </label>
                                            <div class="input-group">
                                                <input type="text" name="amounttosend" class="form-control"
                                                    id="partner_amounttosend" value="" placeholder="0.00"
                                                    readonly>
                                            </div>
                                        </div>
                                        <div class="form-group"> <label for="netwmount">
                                                <h6>Fee <small class="text-success"><b>(1.5% Payout Fee)</b></small></h6>
                                            </label>
                                            <div class="input-group">
                                                <input type="text" name="commissiondeduct" class="form-control"
                                                    id="partner_commissiondeduct" value="" placeholder="0.00"
                                                    readonly>

                                                <input type="hidden" name="totalcharge" class="form-control"
                                                    id="partner_totalcharge" value="" placeholder="0.00"
                                                    readonly>

                                            </div>
                                        </div>

                                        <div class="form-group"> <label for="transaction_pin">
                                                <h6>Transaction Pin</h6>
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-append"> <span
                                                        class="input-group-text text-muted">
                                                        <i class="fas fa-lock"></i> </span> </div> <input
                                                    type="password" name="transaction_pin"
                                                    id="partner_transaction_pin" class="form-control" maxlength="4"
                                                    required>

                                            </div>
                                        </div>

                                        <div class="form-group disp-0">
                                            <span class="text-success">Please note that International transfer are sent
                                                in
                                                USD conversion</span>
                                        </div>

                                        <hr>

                                        <div class="form-group">
                                            <strong><span class="text-danger wallet-info"></span></strong>
                                        </div>

                                        <div class="form-group">
                                            <div class="commissionInfo"></div>
                                        </div>

                                        <div class="card-footer">



                                            <div class="row">
                                                <div class="col-md-12 withCardGoogle disp-0">
                                                    <center>
                                                        <div id="container"></div>
                                                    </center>
                                                </div>

                                                <div class="col-md-12 withWallet">
                                                    <button type="button" onclick="handShake('sendviapartner')"
                                                        class="subscribe btn btn-primary btn-block shadow-sm sendmoneyBtn">
                                                        Send Money </button>
                                                </div>

                                                {{-- <div class="col-md-6">
                                                <button type="button" onclick="beginApplePay()" class="subscribe btn btn-primary btn-block shadow-sm disp-0"> Apple Pay </button>
                                            </div> --}}
                                            </div>


                                        </div>

                                        </div>
                                        <div class="nonpaymentpolicySupport disp-0"></div>


                                    </div>


                                </form>
                            </div>


                        </div> <!-- End -->

                    </div>
                </div>
            </div>
        </div>


        <script src="{{ asset('js/jquery-1.12.0.min.js') }}"></script>

        @include('include.message')

        {{-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> --}}
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.1.3/axios.min.js"
            integrity="sha512-0qU9M9jfqPw6FKkPafM3gy2CBAvUWnYVOfNPDYKVuRTel1PrciTj+a9P3loJB+j0QmN2Y0JYQmkBBS8W+mbezg=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <script src="{{ asset('pace/pace.min.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

        <script>
            $(function() {
                $('[data-toggle="tooltip"]').tooltip();


                $("#orgpayamount").on("keyup", function() {
                    runCommission();
                });

                $("#partner_orgpayamount").on("keyup", function() {
                    runPartnerCommission();
                });


                if (window.ApplePaySession) {
                    var merchantIdentifier = 'simple.moneris.paysprint.exbc.ca';
                    var promise = ApplePaySession.canMakePaymentsWithActiveCard(merchantIdentifier);
                    promise.then(function(canMakePayments) {
                        if (canMakePayments)
                            // Display Apple Pay button here.
                            $(".shadow-sm").removeClass('disp-0');
                    });
                }

            });

            $('#orgpayservice').change(function() {
                if ($('#orgpayservice').val() == "Others") {
                    $('.others').removeClass('disp-0');
                } else {
                    $('.others').addClass('disp-0');
                }
            });

            $('#partner_orgpayservice').change(function() {
                if ($('#partner_orgpayservice').val() == "Others") {
                    $('.others').removeClass('disp-0');
                } else {
                    $('.others').addClass('disp-0');
                }
            });


            $('#paymentMode').change(function() {

                if ($('#paymentMode').val() === 'PaySprint') {
                    $('.paywithpaysprint').removeClass('disp-0');
                    $('.paywithpatners').addClass('disp-0');
                } else {
                    $('.paywithpaysprint').addClass('disp-0');
                    $('.paywithpatners').removeClass('disp-0');

                    // Load Payment Policy on change...
                    let country = $('#partner_country').val();

                    getPaymentPolicy(country);
                }


            });

            $('#partner_country').change(function() {
                getPaymentPolicy($('#partner_country').val());
            });


            $('#paymentWallet').change(function() {

                if ($('#paymentWallet').val() === 'ps_wallet') {
                    $('.wallet_details').removeClass('disp-0');
                    $('.fx_wallet_details').addClass('disp-0');
                } else {
                    $('.wallet_details').addClass('disp-0');
                    $('.fx_wallet_details').removeClass('disp-0');
                    fetchMyFXWallet();
                }


            });



            $('#make_payment_method').change(function() {
                if ($('#make_payment_method').val() == "Wallet") {
                    $('.withWallet').removeClass('disp-0');
                    $('.withCard').addClass('disp-0');
                    $('.creditcard').addClass('disp-0');

                } else if ($('#make_payment_method').val() == "Credit Card") {
                    $('.withWallet').addClass('disp-0');
                    $('.withCard').removeClass('disp-0');
                    $('.creditcard').removeClass('disp-0');
                } else {
                    $('.withWallet').addClass('disp-0');
                    $('.withCard').addClass('disp-0');
                    $('.creditcard').addClass('disp-0');
                }

                runCommission();
            });


            const fetchMyFXWallet = async () => {
                try {

                    $('#paymentFxWallet').html('');


                    const headers = {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        'Authorization': "Bearer " + "{{ Auth::user()->api_token }}"
                    }

                    const config = {
                        method: 'get',
                        url: "{{ route('get my wallets') }}",
                        headers
                    }

                    const result = await axios(config);

                    if (result.status === 200) {


                        const fxRecord = result.data.data;

                        $.each(fxRecord, function(v, k) {
                            $('#paymentFxWallet').append(
                                `<option value="${k.escrow_id}">${k.escrow_id} - ${k.currencyCode+''+Number(k.wallet_balance).toFixed(2)}</option>`
                            );
                        });

                    }



                } catch (error) {
                    console.log(error)
                }
            }




            function handShake(val) {

                var route;


                var formData = new FormData(formElem);

                if ('createnew') {

                    route = "{{ URL('/api/v1/sendmoneytoanonymous') }}";

                    Pace.restart();
                    Pace.track(function() {
                        setHeaders();
                        jQuery.ajax({
                            url: route,
                            method: 'post',
                            data: formData,
                            cache: false,
                            processData: false,
                            contentType: false,
                            dataType: 'JSON',
                            beforeSend: function() {
                                $('.sendmoneyBtn').text('Please wait...');
                            },
                            success: function(result) {
                                console.log(result);

                                $('.sendmoneyBtn').text('Send Money');

                                if (result.status == 200) {
                                    swal("Success", result.message, "success");
                                    setTimeout(function() {
                                        location.href = "{{ route('payorganization') }}";
                                    }, 2000);
                                } else {
                                    swal("Oops", result.message, "error");
                                }

                            },
                            error: function(err) {

                                // console.log(err);

                                if (err.responseJSON.status == 400) {

                                    $('.sendmoneyBtn').text('Send Money');
                                    swal("Oops", err.responseJSON.message, "error");
                                } else {


                                    $('.sendmoneyBtn').text('Send Money');
                                    swal("User already exist",
                                        "You'll be redirected in 3sec to continue your transfer", "info"
                                    );

                                    setTimeout(function() {
                                        location.href = err.responseJSON.link;
                                    }, 2000);
                                }



                            }

                        });
                    });

                }
                else if('sendviapartner'){
                    route = "{{ URL('/api/v1/sendmoneytoanonymous') }}";

                    Pace.restart();
                    Pace.track(function() {
                        setHeaders();
                        jQuery.ajax({
                            url: route,
                            method: 'post',
                            data: formData,
                            cache: false,
                            processData: false,
                            contentType: false,
                            dataType: 'JSON',
                            beforeSend: function() {
                                $('.sendmoneyBtn').text('Please wait...');
                            },
                            success: function(result) {
                                console.log(result);

                                $('.sendmoneyBtn').text('Send Money');

                                if (result.status == 200) {
                                    swal("Success", result.message, "success");
                                    setTimeout(function() {
                                        location.href = "{{ route('payorganization') }}";
                                    }, 2000);
                                } else {
                                    swal("Oops", result.message, "error");
                                }

                            },
                            error: function(err) {

                                // console.log(err);

                                if (err.responseJSON.status == 400) {

                                    $('.sendmoneyBtn').text('Send Money');
                                    swal("Oops", err.responseJSON.message, "error");
                                } else {


                                    $('.sendmoneyBtn').text('Send Money');
                                    swal("User already exist",
                                        "You'll be redirected in 3sec to continue your transfer", "info"
                                    );

                                    setTimeout(function() {
                                        location.href = err.responseJSON.link;
                                    }, 2000);
                                }



                            }

                        });
                    });
                }

            }








            $('#commission').click(function() {
                runCommission();
            });

            $('#partner_commission').click(function() {
                runPartnerCommission();
            });


            function runCommission() {

                $('.commissionInfo').html("");
                var amount = $("#orgpayamount").val();
                // var amount = $("#conversionamount").val();


                var route = "{{ URL('Ajax/getCommission') }}";
                var thisdata = {
                    check: $('#commission').prop("checked"),
                    amount: amount,
                    pay_method: $("#make_payment_method").val(),
                    localcurrency: "{{ $data['currencyCode']->currencyCode }}",
                    foreigncurrency: "{{ $data['currencyCode']->currencyCode }}",
                    structure: "Send Money/Pay Invoice",
                    structureMethod: "Wallet"
                };


                Pace.restart();
                Pace.track(function() {

                    setHeaders();

                    jQuery.ajax({
                        url: route,
                        method: 'post',
                        data: thisdata,
                        dataType: 'JSON',
                        beforeSend: function() {
                            $('.commissionInfo').addClass('');
                        },

                        success: function(result) {


                            if (result.message == "success") {

                                $(".wallet-info").html(result.walletCheck);
                                $('.withWallet').removeClass('disp-0');

                                if (result.walletCheck != "") {
                                    $(".sendmoneyBtn").attr("disabled", true);


                                } else {
                                    $(".sendmoneyBtn").attr("disabled", false);
                                }


                                if (result.state == "commission available") {

                                    $('.commissionInfo').addClass('alert alert-success');
                                    $('.commissionInfo').removeClass('alert alert-danger');

                                    $('.commissionInfo').html(
                                        "<ul><li><span style='font-weight: bold;'>Kindly note that a total amount of: {{ $data['currencyCode']->currencySymbol }}" +
                                        result.data.toFixed(2) + " will be deducted from your " + $(
                                            '#make_payment_method').val() + ".</span></li></li></ul>");

                                    $("#amounttosend").val(result.data);
                                    $("#commissiondeduct").val(result.collection);

                                    $("#totalcharge").val($('#conversionamount').val());

                                    currencyConvert($('#orgpayamount').val());

                                } else {

                                    // $('.commissionInfo').addClass('alert alert-danger');
                                    // $('.commissionInfo').removeClass('alert alert-success');

                                    $('.commissionInfo').addClass('alert alert-success');
                                    $('.commissionInfo').removeClass('alert alert-danger');

                                    $('.commissionInfo').html(
                                        "<ul><li><span style='font-weight: bold;'>Kindly note that a total amount of: {{ $data['currencyCode']->currencySymbol }}" +
                                        (+result.data + +result.collection).toFixed(2) +
                                        " will be deducted from your " + $('#make_payment_method')
                                        .val() + ".</span></li></li></ul>");

                                    $("#amounttosend").val(result.data);
                                    $("#commissiondeduct").val(result.collection);
                                    $("#totalcharge").val((+result.data + +result.collection));

                                    currencyConvert($('#orgpayamount').val());

                                }


                            }


                        }

                    });

                });
            }


            function runPartnerCommission() {

                $('.commissionInfo').html("");
                var amount = $("#partner_orgpayamount").val();
                // var amount = $("#conversionamount").val();


                var route = "{{ URL('Ajax/getCommission') }}";
                var thisdata = {
                    check: $('#commission').prop("checked"),
                    amount: amount,
                    pay_method: $("#make_payment_method").val(),
                    localcurrency: "{{ $data['currencyCode']->currencyCode }}",
                    foreigncurrency: "{{ $data['currencyCode']->currencyCode }}",
                    structure: "Send Money/Pay Invoice",
                    structureMethod: "Wallet"
                };


                Pace.restart();
                Pace.track(function() {

                    setHeaders();

                    jQuery.ajax({
                        url: route,
                        method: 'post',
                        data: thisdata,
                        dataType: 'JSON',
                        beforeSend: function() {
                            $('.commissionInfo').addClass('');
                        },

                        success: function(result) {


                            if (result.message == "success") {

                                $(".wallet-info").html(result.walletCheck);
                                $('.withWallet').removeClass('disp-0');

                                if (result.walletCheck != "") {
                                    $(".sendmoneyBtn").attr("disabled", true);


                                } else {
                                    $(".sendmoneyBtn").attr("disabled", false);
                                }


                                if (result.state == "commission available") {

                                    $('.commissionInfo').addClass('alert alert-success');
                                    $('.commissionInfo').removeClass('alert alert-danger');

                                    let commissionVal = Number(result.data) * 0.015;
                                    let finalDeduct = Number(result.data) + commissionVal

                                    $('.commissionInfo').html(
                                        "<ul><li><span style='font-weight: bold;'>Kindly note that a total amount of: {{ $data['currencyCode']->currencySymbol }}" +
                                        finalDeduct.toFixed(2) + " will be deducted from your " + $(
                                            '#make_payment_method').val() + ".</span></li></li></ul>");


                                    $("#partner_amounttosend").val(result.data);
                                    $("#partner_commissiondeduct").val(commissionVal);

                                    $("#partner_totalcharge").val($('#partner_conversionamount').val());

                                    currencyConvert($('#partner_orgpayamount').val());

                                } else {

                                    // $('.commissionInfo').addClass('alert alert-danger');
                                    // $('.commissionInfo').removeClass('alert alert-success');

                                    $('.commissionInfo').addClass('alert alert-success');
                                    $('.commissionInfo').removeClass('alert alert-danger');

                                    let commissionVal = Number(result.data) * 0.1;
                                    let finalDeduct = Number(result.data) + commissionVal

                                    $('.commissionInfo').html(
                                        "<ul><li><span style='font-weight: bold;'>Kindly note that a total amount of: {{ $data['currencyCode']->currencySymbol }}" +
                                        finalDeduct.toFixed(2) +
                                        " will be deducted from your " + $('#make_payment_method')
                                        .val() + ".</span></li></li></ul>");

                                    $("#partner_amounttosend").val(result.data);
                                    $("#partner_commissiondeduct").val(commissionVal);
                                    $("#partner_totalcharge").val(finalDeduct);

                                    currencyConvert($('#partner_orgpayamount').val());

                                }


                            }


                        }

                    });

                });
            }

            function currencyConvert(amount) {

                $("#conversionamount").val("");

                var currency = "{{ $data['currencyCode']->currencyCode }}";
                var localcurrency = "{{ $data['currencyCode']->currencyCode }}";
                var route = "{{ URL('Ajax/getconversion') }}";
                var thisdata = {
                    currency: currency,
                    amount: amount,
                    val: "send",
                    localcurrency: localcurrency
                };

                setHeaders();
                jQuery.ajax({
                    url: route,
                    method: 'post',
                    data: thisdata,
                    dataType: 'JSON',
                    success: function(result) {

                        if (result.message == "success") {
                            $("#conversionamount").val(result.data);
                        } else {
                            $("#conversionamount").val("");
                        }


                    }

                });
            }

            // GPay Starts

            /**
             * Define the version of the Google Pay API referenced when creating your
             * configuration
             *
             * @see {@link https://developers.google.com/pay/api/web/reference/request-objects#PaymentDataRequest|apiVersion in PaymentDataRequest}
             */
            const baseRequest = {
                apiVersion: 2,
                apiVersionMinor: 0
            };

            /**
             * Card networks supported by your site and your gateway
             *
             * @see {@link https://developers.google.com/pay/api/web/reference/request-objects#CardParameters|CardParameters}
             * @todo confirm card networks supported by your site and gateway
             */
            const allowedCardNetworks = ["AMEX", "DISCOVER", "INTERAC", "JCB", "MASTERCARD", "VISA"];

            /**
             * Card authentication methods supported by your site and your gateway
             *
             * @see {@link https://developers.google.com/pay/api/web/reference/request-objects#CardParameters|CardParameters}
             * @todo confirm your processor supports Android device tokens for your
             * supported card networks
             */
            const allowedCardAuthMethods = ["PAN_ONLY", "CRYPTOGRAM_3DS"];

            /**
             * Identify your gateway and your site's gateway merchant identifier
             *
             * The Google Pay API response will return an encrypted payment method capable
             * of being charged by a supported gateway after payer authorization
             *
             * @todo check with your gateway on the parameters to pass
             * @see {@link https://developers.google.com/pay/api/web/reference/request-objects#gateway|PaymentMethodTokenizationSpecification}
             */
            const tokenizationSpecification = {
                type: 'PAYMENT_GATEWAY',
                parameters: {
                    'gateway': 'example',
                    'gatewayMerchantId': 'exampleGatewayMerchantId'
                }
            };

            /**
             * Describe your site's support for the CARD payment method and its required
             * fields
             *
             * @see {@link https://developers.google.com/pay/api/web/reference/request-objects#CardParameters|CardParameters}
             */
            const baseCardPaymentMethod = {
                type: 'CARD',
                parameters: {
                    allowedAuthMethods: allowedCardAuthMethods,
                    allowedCardNetworks: allowedCardNetworks
                }
            };

            /**
             * Describe your site's support for the CARD payment method including optional
             * fields
             *
             * @see {@link https://developers.google.com/pay/api/web/reference/request-objects#CardParameters|CardParameters}
             */
            const cardPaymentMethod = Object.assign({},
                baseCardPaymentMethod, {
                    tokenizationSpecification: tokenizationSpecification
                }
            );

            /**
             * An initialized google.payments.api.PaymentsClient object or null if not yet set
             *
             * @see {@link getGooglePaymentsClient}
             */
            let paymentsClient = null;

            /**
             * Configure your site's support for payment methods supported by the Google Pay
             * API.
             *
             * Each member of allowedPaymentMethods should contain only the required fields,
             * allowing reuse of this base request when determining a viewer's ability
             * to pay and later requesting a supported payment method
             *
             * @returns {object} Google Pay API version, payment methods supported by the site
             */
            function getGoogleIsReadyToPayRequest() {
                return Object.assign({},
                    baseRequest, {
                        allowedPaymentMethods: [baseCardPaymentMethod]
                    }
                );
            }

            /**
             * Configure support for the Google Pay API
             *
             * @see {@link https://developers.google.com/pay/api/web/reference/request-objects#PaymentDataRequest|PaymentDataRequest}
             * @returns {object} PaymentDataRequest fields
             */
            function getGooglePaymentDataRequest() {
                const paymentDataRequest = Object.assign({}, baseRequest);
                paymentDataRequest.allowedPaymentMethods = [cardPaymentMethod];
                paymentDataRequest.transactionInfo = getGoogleTransactionInfo();
                paymentDataRequest.merchantInfo = {
                    // @todo a merchant ID is available for a production environment after approval by Google
                    // See {@link https://developers.google.com/pay/api/web/guides/test-and-deploy/integration-checklist|Integration checklist}
                    merchantId: 'BCR2DN6T2PJ3FJ37',
                    merchantName: "PaySprint",
                };
                return paymentDataRequest;
            }

            /**
             * Return an active PaymentsClient or initialize
             *
             * @see {@link https://developers.google.com/pay/api/web/reference/client#PaymentsClient|PaymentsClient constructor}
             * @returns {google.payments.api.PaymentsClient} Google Pay API client
             */
            function getGooglePaymentsClient() {
                if (paymentsClient === null) {
                    paymentsClient = new google.payments.api.PaymentsClient({
                        environment: 'PRODUCTION'
                    });
                }
                return paymentsClient;
            }

            /**
             * Initialize Google PaymentsClient after Google-hosted JavaScript has loaded
             *
             * Display a Google Pay payment button after confirmation of the viewer's
             * ability to pay.
             */
            function onGooglePayLoaded() {
                const paymentsClient = getGooglePaymentsClient();
                paymentsClient.isReadyToPay(getGoogleIsReadyToPayRequest())
                    .then(function(response) {
                        if (response.result) {
                            addGooglePayButton();
                            // @todo prefetch payment data to improve performance after confirming site functionality
                            // prefetchGooglePaymentData();
                        }
                    })
                    .catch(function(err) {
                        // show error in developer console for debugging
                        console.error(err);
                        alert(err.statusMessage);
                    });
            }

            /**
             * Add a Google Pay purchase button alongside an existing checkout button
             *
             * @see {@link https://developers.google.com/pay/api/web/reference/request-objects#ButtonOptions|Button options}
             * @see {@link https://developers.google.com/pay/api/web/guides/brand-guidelines|Google Pay brand guidelines}
             */
            function addGooglePayButton() {
                const paymentsClient = getGooglePaymentsClient();
                const button =
                    paymentsClient.createButton({
                        onClick: onGooglePaymentButtonClicked,
                        buttonType: 'plain'
                    });
                document.getElementById('container').appendChild(button);
            }

            /**
             * Provide Google Pay API with a payment amount, currency, and amount status
             *
             * @see {@link https://developers.google.com/pay/api/web/reference/request-objects#TransactionInfo|TransactionInfo}
             * @returns {object} transaction info, suitable for use as transactionInfo property of PaymentDataRequest
             */
            function getGoogleTransactionInfo() {
                return {
                    countryCode: "{{ $data['currencyCode']->code }}",
                    currencyCode: "{{ $data['currencyCode']->currencyCode }}",
                    totalPriceStatus: "FINAL",
                    // set to cart total
                    totalPrice: $("#totalcharge").val()
                };
            }

            /**
             * Prefetch payment data to improve performance
             *
             * @see {@link https://developers.google.com/pay/api/web/reference/client#prefetchPaymentData|prefetchPaymentData()}
             */
            function prefetchGooglePaymentData() {
                const paymentDataRequest = getGooglePaymentDataRequest();
                // transactionInfo must be set but does not affect cache
                paymentDataRequest.transactionInfo = {
                    totalPriceStatus: 'NOT_CURRENTLY_KNOWN',
                    currencyCode: "{{ $data['currencyCode']->currencyCode }}"
                };
                const paymentsClient = getGooglePaymentsClient();
                paymentsClient.prefetchPaymentData(paymentDataRequest);
            }

            /**
             * Show Google Pay payment sheet when Google Pay payment button is clicked
             */
            function onGooglePaymentButtonClicked() {
                const paymentDataRequest = getGooglePaymentDataRequest();
                paymentDataRequest.transactionInfo = getGoogleTransactionInfo();

                const paymentsClient = getGooglePaymentsClient();
                paymentsClient.loadPaymentData(paymentDataRequest)
                    .then(function(paymentData) {
                        // handle the response
                        processPayment(paymentData);
                    })
                    .catch(function(err) {
                        // show error in developer console for debugging
                        console.error(err);
                        alert(err.statusMessage);
                    });
            }
            /**
             * Process payment data returned by the Google Pay API
             *
             * @param {object} paymentData response from Google Pay API after user approves payment
             * @see {@link https://developers.google.com/pay/api/web/reference/response-objects#PaymentData|PaymentData object reference}
             */
            function processPayment(paymentData) {

                // Run System Payment Complete
                $('#paymentToken').val('');

                var name = $('#orgpayname').val();
                var email = $('#orgpayemail').val();
                var user_id = $('#orgpayuser_id').val();
                var service = $('#orgpayservice').val();
                var purpose = $('#orgpaypurpose').val();
                var amount = $('#orgpayamount').val();


                if (service == "") {
                    swal('Oops!', 'Please select payment purpose', 'info');
                    return false;
                } else if (amount == "") {
                    swal('Oops!', 'Please enter amount', 'info');
                    return false;
                } else {

                    // show returned data in developer console for debugging
                    console.log(paymentData);
                    // @todo pass payment token to your gateway to process payment
                    paymentToken = paymentData.paymentMethodData.tokenizationData.token;

                    $('#paymentToken').val(paymentToken);


                    $("#paymentForm").submit();


                }

            }



            // Gpay Ends






            function beginApplePay() {
                var paymentRequest = {
                    countryCode: 'US',
                    currencyCode: 'USD',
                    total: {
                        label: 'Stripe.com',
                        amount: '19.99'
                    }
                };
                //   var session = ...; // continued below
            }



            const getPaymentPolicy = async (country) => {
                try {

                    const headers = {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    }

                    const config = {
                        method: 'get',
                        url: "{{ asset('js/paymentpolicy.js') }}",
                        headers
                    }

                    const result = await axios(config);

                    if (result.status === 200) {
                        let data = filterPaymentPolicy(country, result.data);

                        let compulsoryInput = $('.compulsory_data');
                        let mandatoryInput = $('.mandatory_data');
                        let paymentTypeInput = $('.paymentType_data');
                        let informationInput = $('.information_data');
                        let payoutAgentInput = $('.payoutAgent_data');
                        let remittanceCompanyInput = $('.remittance_company_data');
                        let payoutAgentSelect = $('#payout_record');

                        compulsoryInput.addClass('disp-0');
                        mandatoryInput.addClass('disp-0');
                        paymentTypeInput.addClass('disp-0');
                        informationInput.addClass('disp-0');
                        payoutAgentInput.addClass('disp-0');
                        remittanceCompanyInput.addClass('disp-0');


                        informationInput.html('');
                        compulsoryInput.html('');
                        mandatoryInput.html('');
                        paymentTypeInput.html('');
                        payoutAgentInput.html('');
                        remittanceCompanyInput.html('');
                        payoutAgentSelect.html('');

                        if (data.length > 0){
                            $('.nonpaymentpolicySupport').addClass('disp-0');
                            $('.paymentpolicySupport').removeClass('disp-0');


                            if(data[0].compulsory_data.length > 0){
                                compulsoryInput.removeClass('disp-0');

                                compulsoryInput.html(`<br><h4>Compulsory Information - (Sender)</h4><hr>`);

                                for (let i = 0; i < data[0].compulsory_data.length; i++) {
                                    const element = data[0].compulsory_data[i];

                                    compulsoryInput.append(`

                                        <div class="form-group"> <label for="compulsory_${element+'_'+i}">
                                                <h6><span class="text-danger">* </span>${element.toUpperCase()}</h6>
                                            </label>
                                            <div class="input-group">
                                                <input type="text" name="compulsory_${element}" id="compulsory_${element+'_'+i}"
                                                     class="form-control" required>
                                            </div>
                                        </div>
                                    `);

                                }


                            }

                            if(data[0].mandatory_data.length > 0){
                                mandatoryInput.removeClass('disp-0');

                                mandatoryInput.html(`<br><h4>Mandatory Information - (Receiver)</h4><hr>`);

                                for (let i = 0; i < data[0].mandatory_data.length; i++) {
                                    const value = data[0].mandatory_data[i];

                                    mandatoryInput.append(`

                                        <div class="form-group"> <label for="mandatory_${value+'_'+i}">
                                                <h6><span class="text-danger">* </span>${value.toUpperCase()}</h6>
                                            </label>
                                            <div class="input-group">
                                                <input type="text" name="mandatory_${value}" id="mandatory_${value+'_'+i}"
                                                    class="form-control" required>
                                            </div>
                                        </div>
                                    `);

                                }
                            }


                            if(data[0].payment_type){
                                paymentTypeInput.removeClass('disp-0');

                                paymentTypeInput.html(`
                                <br><h4>Payment Type</h4><hr>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="text" name="payment_type" id="paymentType" value="${data[0].payment_type}"
                                                    class="form-control" readonly>
                                            </div>
                                        </div>
                                    `);
                            }

                            if(data[0].remittance_company !== undefined){


                                if(data[0].remittance_company.length > 0){
                                    let remittanceoptions = [];
                                remittanceCompanyInput.removeClass('disp-0');

                                $.each(data[0].remittance_company, function(v, k) {
                                    remittanceoptions.push(`<option value="${k}">${k}</option>`);
                                });

                                remittanceCompanyInput.html(`<br><h4>Mode of Remittance</h4><hr><div class="form-group"> <label for="remittance">
                                                <h6><span class="text-danger">* </span>Select Remittance Company</h6>
                                            </label>
                                            <div class="input-group">
                                                <select class="form-control" name="remittance" id="remittance" required>
                                                    ${remittanceoptions}
                                                </select>
                                            </div>
                                        </div>`);


                            }

                            }
                            if(data[0].payoutAgent !== undefined){


                                if(data[0].payoutAgent.length > 0){
                                    let options = [];
                                payoutAgentInput.removeClass('disp-0');

                                $.each(data[0].payoutAgent, function(v, k) {
                                    options.push(`<option value="${k}">${k}</option>`);
                                });

                                payoutAgentInput.html(`<br><h4>Payout Information</h4><hr><div class="form-group"> <label for="payout_agent">
                                                <h6><span class="text-danger">* </span>Select Payout</h6>
                                            </label>
                                            <div class="input-group">
                                                <select class="form-control" name="payout" id="payout_record" required>
                                                    ${options}
                                                </select>
                                            </div>
                                        </div>`);


                            }

                            }



                            informationInput.removeClass('disp-0');
                            informationInput.html(`
                                <div class="alert alert-info">
                                    <table class="table table-responsive table-striped">
                                    <tbody>
                                        <tr>
                                            <td>Max. Amount</td>
                                            <td><strong>${data[0].currency+' '+data[0].max_amount.toFixed(2)}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>Notification</td>
                                            <td><strong>${data[0].notification !== undefined ? data[0].notification : '-'}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>Payment Type</td>
                                            <td><strong>${data[0].payment_type !== undefined ? data[0].payment_type : '-'}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>Remark</td>
                                            <td class="text-danger">${data[0].remarks}</td>
                                        </tr>
                                    </tbody>
                                </table>

                                </div>
                            `);




                        }
                        else{
                            $('.nonpaymentpolicySupport').removeClass('disp-0');
                            $('.paymentpolicySupport').addClass('disp-0');

                            $('.nonpaymentpolicySupport').html(`
                            <div class="alert alert-info">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h4>
                                                       Coming Soon...
                                                    </h4>
                                                </div>
                                                <div class="col-md-12">
                                                    <p>
                                                        This feature is currently not available in ${country}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                            `);
                        }

                    }

                } catch (error) {
                    console.log(error)
                }
            }

            const filterPaymentPolicy = (nameKey, paymentcountry) => {
                    let response = [];

                paymentcountry.find((element) => {
                    if(element.country === nameKey) {
                        response.push(element);
                    }
                });


                return response;
            }







            //Set CSRF HEADERS
            function setHeaders() {
                jQuery.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        'Authorization': "Bearer " + "{{ Auth::user()->api_token }}"
                    }
                });
            }
        </script>


        {{-- Google Pay API --}}

        <script async src="https://pay.google.com/gp/p/js/pay.js" onload="onGooglePayLoaded()"></script>

</body>

</html>
