<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <!-- Favicon -->
    <link rel="icon" href="https://res.cloudinary.com/paysprint/image/upload/v1651130089/assets/paysprint_jpeg_black_bk_2_w4hzub_ioffkg.jpg" type="image/x-icon" />

    <link rel="stylesheet" type="text/css" href="{{ asset('pace/themes/orange/pace-theme-flash.css') }}" />

    <script src="https://kit.fontawesome.com/384ade21a6.js"></script>

    <title>PaySprint | Withdraw Money</title>

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
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-4">Withdraw from Partner</h1>
                {!! session('msg') !!}
            </div>
        </div> <!-- End -->
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card ">
                    <div class="card-header">
                        <div class="bg-white shadow-sm pt-4 pl-2 pr-2 pb-2">
                            <!-- Credit card form tabs -->
                            <ul role="tablist" class="nav bg-light nav-pills rounded nav-fill mb-3">
                                <li class="nav-item"> <a data-toggle="pill" href="{{ route('my account') }}" class="nav-link active "> <i class="fas fa-home"></i> Go Back </a> </li>
                                {{-- <li class="nav-item"> <a data-toggle="pill" href="#paypal" class="nav-link "> <i
                                            class="fab fa-paypal mr-2"></i> Debit Card </a> </li>
                                <li class="nav-item"> <a data-toggle="pill" href="#net-banking" class="nav-link "> <i
                                            class="fas fa-mobile-alt mr-2"></i> EXBC Card </a> </li> --}}
                            </ul>
                        </div> <!-- End -->
                        <!-- Credit card form content -->
                        <div class="tab-content">


                            @if (isset($data))
                            <!-- credit card info-->
                            <div id="credit-card" class="tab-pane fade show active pt-3">
                                <!-- condition for dusupay-->
                                @if($data['paymentgateway']->gateway == 'Dusupay')
                                @if(!empty($data['providers']))
                                @foreach ( $data['providers'] as $providers)
                                <form action="{{ route ('withdraw mobile') }}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <div class="alert alert-warning">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h4>
                                                        Wallet Balance
                                                    </h4>
                                                </div>
                                                <div class="col-md-12">
                                                    <h4>
                                                        {{ $data['currencyCode']->currencySymbol . '' .
                                                        number_format(Auth::user()->wallet_balance, 4) }}
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- warning -->
                                        @if(Auth::user()->plan === 'basic')

                                        <div class="row">
                                            <div class="col-md-12 text-center">
                                                <p class="text-danger" style="font-weight:bold">Note: You must have a Minimum Balance of {{$data['currencyCode']->currencySymbol.$data['subscription'] }} in your Wallet</p>
                                            </div>
                                        </div>

                                        @endif

                                    </div>
                                    <div class="form-group"> <label for="amount">
                                            <h6>Payment Method</h6>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-append"> <span class="input-group-text text-muted">
                                                    {{ $data['currencyCode']->currencySymbol }} </span> </div>
                                            <input type="text" name="payment_type" id="mobile_money" class="form-control" value="{{ $providers->account_type }}" required readonly>

                                        </div>
                                    </div>
                                    <!--Account Number -->
                                    <div class="form-group"> <label for="amount">
                                            <h6>Mobile Money Account Number</h6>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-append"> <span class="input-group-text text-muted">
                                                </span> </div>
                                            <select name="account_number" id="account_number" class="form-control">
                                                <option value="{{ $providers->account_number }}">{{
                                                    $providers->account_number }}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Mobile Money Provider -->
                                    <div class="form-group"> <label for="amount">
                                            <h6>Mobile Money Provider</h6>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-append"> <span class="input-group-text text-muted">
                                                </span> </div>
                                            <select name="provider" id="provider" class="form-control">
                                                <option value="">Select Provider</option>
                                                <option value="{{ $providers->provider }}">{{ $providers->provider }}
                                                </option>
                                            </select>

                                        </div>
                                    </div>

                                    <!-- Amount to withdraw -->
                                    <div class="form-group"> <label for="amount">
                                            <h6>Amount to Withdraw</h6>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-append"> <span class="input-group-text text-muted">
                                                    {{ $data['currencyCode']->currencySymbol }} </span> </div>
                                            <input type="number" min="0.00" max="10000.00" step="0.01" name="amount" id="amount" class="form-control" required>
                                        </div>
                                    </div>

                                    <!-- fees -->
                                    <div class="form-group disp-0">
                                        <div class="input-group">
                                            <p style="color: red; font-weight: bold;"><input type="checkbox" name="commission" id="commission" checked> Include fee</p>

                                        </div>
                                    </div>

                                    <div class="form-group"> <label for="netwmount">
                                            <h6>Net Amount <br><small class="text-success disp-0"><b>This is the
                                                        total amount to be received</b></small></h6>

                                        </label>
                                        <div class="input-group">
                                            <input type="text" name="amounttosend" class="form-control" id="amounttosend" value="" placeholder="0.00" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group disp-0"> <label for="netwmount">
                                            <h6>Fee</h6>
                                        </label>
                                        <div class="input-group">
                                            <input type="hidden" name="commissiondeduct" class="form-control" id="commissiondeduct" value="" placeholder="0.00" readonly>

                                            <input type="hidden" name="totalcharge" class="form-control" id="totalcharge" value="" placeholder="0.00" readonly>

                                        </div>
                                    </div>
                                    <div class="form-group disp-0"> <label for="netwmount">
                                            <h6>Currency Conversion <br><small class="text-info"><b>Exchange
                                                        rate today according to currencylayer.com</b></small></h6>
                                            <p style="font-weight: bold;">
                                                {{ $data['currencyCode']->currencyCode }}
                                                <=> CAD
                                            </p>
                                        </label>
                                        <div class="input-group">
                                            <input type="text" name="conversionamount" class="form-control" id="conversionamount" value="" placeholder="0.00" readonly>
                                        </div>
                                    </div>
                                    <hr>

                                    <div class="form-group">
                                        <strong><span class="text-danger wallet-info"></span></strong>
                                    </div>


                                    <div class="form-group">
                                        <div class="commissionInfo"></div>
                                    </div>
                                    <!-- transaction pin -->
                                    @if (Auth::user()->transaction_pin != null)
                                    <div class="form-group"> <label for="transaction_pin">
                                            <h6>Transaction Pin</h6>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-append"> <span class="input-group-text text-muted">
                                                    <i class="fas fa-lock"></i> </span> </div> <input type="password" name="transaction_pin" id="transaction_pin" class="form-control" maxlength="4" required>

                                        </div>
                                    </div>
                                    @else
                                    <hr>
                                    <h5>
                                        Set up transaction pin
                                    </h5>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group"> <label for="new_transaction_pin">
                                                    <h6>New Transaction Pin</h6>
                                                </label>
                                                <div class="input-group">
                                                    <div class="input-group-append"> <span class="input-group-text text-muted"> <i class="fas fa-lock"></i> </span> </div>
                                                    <input type="password" name="transaction_pin" id="new_transaction_pin" class="form-control" maxlength="4" required>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group"> <label for="confirm_transaction_pin">
                                                    <h6>Confirm Transaction Pin</h6>
                                                </label>
                                                <div class="input-group">
                                                    <div class="input-group-append"> <span class="input-group-text text-muted"> <i class="fas fa-lock"></i> </span> </div>
                                                    <input type="password" name="confirm_transaction_pin" id="confirm_transaction_pin" class="form-control" maxlength="4" required>

                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-12">
                                            <div class="form-group"> <label for="password">
                                                    <h6>Provide Your Login Password <br> <small class="text-danger">We
                                                            need to be sure it's
                                                            you</small></h6>
                                                </label>
                                                <div class="input-group">
                                                    <div class="input-group-append"> <span class="input-group-text text-muted"> <i class="fas fa-lock"></i> </span> </div>
                                                    <input type="password" name="password" id="password" class="form-control" required>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    <!-- end of transaction pin -->
                                    <input type="hidden" name="currencyCode" class="form-control" id="curCurrency" value="{{ $providers->code }}" readonly>

                                    <div class="col-md-12">
                                        <button class="btn btn-success form-control" type="submit">Submit</button>
                                    </div>
                                </form>
                                @endforeach
                                @endif
                                @else
                                <!--else starts-->
                                <form role="form" action="#" method="POST" id="formElem">
                                    @csrf
                                    <div class="form-group">
                                        <div class="alert alert-warning">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h4>
                                                        Wallet Balance
                                                    </h4>
                                                </div>
                                                <div class="col-md-12">
                                                    <h4>
                                                        {{ $data['currencyCode']->currencySymbol . '' .
                                                        number_format(Auth::user()->wallet_balance, 4) }}
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- warning -->
                                        <div class="row">
                                            <div class="col-md-12 text-center">
                                                <p class="text-danger" style="font-weight:bold">Note: You must have a Minimum Balance of {{$data['currencyCode']->currencySymbol.$data['subscription'] }} in your Wallet</p>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label for="gateway">
                                            <h6>Select Partner</h6>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-append"> <span class="input-group-text text-muted">
                                                    <img src="https://img.icons8.com/cotton/20/000000/money--v4.png" />
                                                </span> </div>
                                            <select name="gateway" id="gateway" class="form-control" required>
                                                <option value="PaySprint">Select option</option>

                                                @foreach ($data['partner'] as $partners)
                                                <option value="{{ $partners }}">{{ $partners }}</option>
                                                @endforeach

                                            </select>

                                        </div>
                                    </div>

                                    @if (count($data['getCard']) > 0 || count($data['getBank']) > 0)
                                    <div class="form-group"> <label for="card_id">
                                            {{-- <h6>Select Card Type/ Bank Account</h6> --}}
                                            <h6>Select Payment Option</h6>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-append"> <span class="input-group-text text-muted">
                                                    <img src="https://img.icons8.com/cotton/20/000000/money--v4.png" />
                                                </span> </div>
                                            <select name="card_type" id="card_type" class="form-control" required>
                                                <option value="">Select option</option>

                                                @if (Auth::user()->country === 'Canada')
                                                <option value="Cash">Cash</option>
                                                <option value="e-Transfer">e-Transfer</option>
                                                @endif

                                                {{-- <option value="Credit Card">Credit Card</option> --}}
                                                {{-- <option value="Debit Card">Debit Visa/Mastercard</option> --}}
                                                {{-- <option value="Prepaid Card">Reloadable Prepaid Card</option> --}}
                                                <option value="Cash Payment">Cash Payment</option>
                                                <option value="Bank Account">Bank Deposit</option>
                                            </select>

                                        </div>
                                    </div>



                                    {{-- Start For Cash Deposit  --}}

                                    <div class="form-group cashDeposit disp-0">
                                        <label for="payout_id">
                                            <h6>Select Payout Agent</h6>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-append"> <span class="input-group-text text-muted">
                                                    <img src="https://img.icons8.com/fluent/20/000000/bank-card-back-side.png" />
                                                </span> </div>
                                            <select name="payout_id" id="payout_id" class="form-control" required></select>

                                        </div>

                                        <br>
                                        <div class="alert alert-info ">
                                            Please note that the means of identification for the collection of cash at the payout point is the ID uploaded during the registration: <strong>@if (Auth::user()->nin_front != NULL) {{ "National Identity Card" }} @elseif (Auth::user()->drivers_license_front != NULL) {{ "Driver Licence" }} @elseif (Auth::user()->international_passport_front != NULL) {{ "International Passport" }} @elseif (Auth::user()->incorporation_doc_front != NULL || Auth::user()->idvdoc != NULL) {{ "Utility Bill" }} @endif </strong>
                                        </div>



                                    </div>



                                    {{-- End For Cash Deposit --}}


                                    {{-- Start For Card and Bank Deposit  --}}

                                    <div class="cardbankDeposit disp-0">
                                        <div class="form-group">

                                        <label for="card_id">
                                            <h6>Select Card/Bank</h6>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-append"> <span class="input-group-text text-muted">
                                                    <img src="https://img.icons8.com/fluent/20/000000/bank-card-back-side.png" />
                                                </span> </div>
                                            <select name="card_id" id="card_id" class="form-control" required></select>

                                        </div>

                                        <br>

                                        <div class="alert alert-info prepaidInfo disp-0">
                                            Loading cost of <strong>$5.00</strong> applied
                                        </div>
                                    </div>
                                        <div class="form-group">

                                        <label for="card_id">
                                            <h6>Provide Bank Branch Code</h6>
                                        </label>
                                        <div class="input-group"> <input type="text" name="branch_code" id="branch_code" class="form-control" required placeholder="058-174218">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text text-muted"> <i class="fas fa-money-check mx-1"></i></span>
                                                    </div>
                                                </div>
                                    </div>
                                    </div>



                                    {{-- End For Card and Bank Deposit --}}
                                    @else
                                    <div class="form-group"> <label for="amount">
                                            <h5>Add a new card</h5>
                                        </label>

                                        <form action="#" method="POST" id="formCardElem">
                                            @csrf

                                            <div class="form-group">
                                                <label for="card_number">Card Number</label>

                                                <div class="input-group"> <input type="text" name="card_number" id="card_number" class="form-control" maxlength="16" required>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text text-muted"> <i class="fas fa-money-check mx-1"></i> <i class="fab fa-cc-mastercard mx-1"></i> <i class="fab fa-cc-amex mx-1"></i> </span>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="form-group">

                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for="month">Month</label>

                                                        <div class="input-group">
                                                            <select name="month" id="month" class="form-control" required>
                                                                <option value="01">January</option>
                                                                <option value="02">February</option>
                                                                <option value="03">March</option>
                                                                <option value="04">April</option>
                                                                <option value="05">May</option>
                                                                <option value="06">June</option>
                                                                <option value="07">July</option>
                                                                <option value="08">August</option>
                                                                <option value="09">September</option>
                                                                <option value="10">October</option>
                                                                <option value="11">November</option>
                                                                <option value="12">December</option>
                                                            </select>
                                                            <div class="input-group-append">
                                                                <span class="input-group-text text-muted"> <i class="fas fa-table"></i> </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="year">Year</label>

                                                        <div class="input-group">
                                                            <select name="year" id="year" class="form-control" required>
                                                                @for ($i = date('y'); $i <= date('y') + 10; $i++) <option value="{{ $i }}">
                                                                    {{ '20' . $i }}</option>
                                                                    @endfor
                                                            </select>
                                                            <div class="input-group-append">
                                                                <span class="input-group-text text-muted"> <i class="fas fa-calendar-week"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="month">CVV <small class="text-danger">3
                                                                digit at the back of your card</small></label>

                                                        <div class="input-group">
                                                            <input type="password" name="cvv" id="cvv" class="form-control" maxlength="3" required>
                                                            <div class="input-group-append">
                                                                <span class="input-group-text text-muted"> <i class="fas fa-closed-captioning"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>



                                            </div>


                                            <div class="form-group">
                                                <button type="button" class="btn btn-primary btn-block" onclick="handShake('addcard')" id="cardSubmit">Submit</button>
                                            </div>

                                        </form>
                                    </div>


                                    @endif

                                    <div class="form-group"> <label for="amount">
                                            <h6>Amount to Withdraw</h6>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-append"> <span class="input-group-text text-muted">
                                                    {{ $data['currencyCode']->currencySymbol }} </span> </div>
                                            <input type="number" min="0.00" max="10000.00" step="0.01" name="amount" id="amount" class="form-control" required>

                                        </div>
                                    </div>


                                    <div class="form-group disp-0">
                                        <div class="input-group">
                                            <p style="color: red; font-weight: bold;"><input type="checkbox" name="commission" id="commission" checked> Include fee</p>

                                        </div>
                                    </div>

                                    <div class="form-group"> <label for="netwmount">
                                            <h6>Net Amount <br><small class="text-success disp-0"><b>This is the
                                                        total amount to be received</b></small></h6>

                                        </label>
                                        <div class="input-group">
                                            <input type="text" name="amounttosend" class="form-control" id="amounttosend" value="" placeholder="0.00" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group"> <label for="netwmount">
                                            <h6>(1.5%) Fee Charge</h6>
                                        </label>
                                        <div class="input-group">
                                            <input type="text" name="commissiondeduct" class="form-control" id="commissiondeduct" value="" placeholder="0.00" readonly>

                                            <input type="hidden" name="totalcharge" class="form-control" id="totalcharge" value="" placeholder="0.00" readonly>

                                        </div>
                                    </div>

                                    <div class="form-group disp-0"> <label for="netwmount">
                                            <h6>Currency Conversion <br><small class="text-info"><b>Exchange
                                                        rate today according to currencylayer.com</b></small></h6>
                                            <p style="font-weight: bold;">
                                                {{ $data['currencyCode']->currencyCode }}
                                                <=> CAD
                                            </p>
                                        </label>
                                        <div class="input-group">
                                            <input type="text" name="conversionamount" class="form-control" id="conversionamount" value="" placeholder="0.00" readonly>
                                        </div>
                                    </div>


                                    <hr>

                                    <div class="form-group">
                                        <strong><span class="text-danger wallet-info"></span></strong>
                                    </div>


                                    <div class="form-group">
                                        <div class="commissionInfo"></div>
                                    </div>

                                    @if (Auth::user()->transaction_pin != null)
                                    <div class="form-group"> <label for="transaction_pin">
                                            <h6>Transaction Pin</h6>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-append"> <span class="input-group-text text-muted">
                                                    <i class="fas fa-lock"></i> </span> </div> <input type="password" name="transaction_pin" id="transaction_pin" class="form-control" maxlength="4" required>

                                        </div>
                                    </div>
                                    @else
                                    <hr>
                                    <h5>
                                        Set up transaction pin
                                    </h5>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group"> <label for="new_transaction_pin">
                                                    <h6>New Transaction Pin</h6>
                                                </label>
                                                <div class="input-group">
                                                    <div class="input-group-append"> <span class="input-group-text text-muted"> <i class="fas fa-lock"></i> </span> </div>
                                                    <input type="password" name="transaction_pin" id="new_transaction_pin" class="form-control" maxlength="4" required>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group"> <label for="confirm_transaction_pin">
                                                    <h6>Confirm Transaction Pin</h6>
                                                </label>
                                                <div class="input-group">
                                                    <div class="input-group-append"> <span class="input-group-text text-muted"> <i class="fas fa-lock"></i> </span> </div>
                                                    <input type="password" name="confirm_transaction_pin" id="confirm_transaction_pin" class="form-control" maxlength="4" required>

                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-12">
                                            <div class="form-group"> <label for="password">
                                                    <h6>Provide Your Login Password <br> <small class="text-danger">We
                                                            need to be sure it's
                                                            you</small></h6>
                                                </label>
                                                <div class="input-group">
                                                    <div class="input-group-append"> <span class="input-group-text text-muted"> <i class="fas fa-lock"></i> </span> </div>
                                                    <input type="password" name="password" id="password" class="form-control" required>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif




                                    <input type="hidden" name="currencyCode" class="form-control" id="curCurrency" value="{{ $data['currencyCode']->currencyCode }}" readonly>

                                    <input type="hidden" name="mode" class="form-control" id="mode" value="live" readonly>

                                    <div class="card-footer">

                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="button" onclick="handShake('partnerwithdraw')" class="subscribe btn btn-primary btn-block shadow-sm withdrawmoneyBtn">
                                                    Withdraw Money </button>
                                            </div>
                                        </div>


                                    </div>

                                </form>
                                @endif
                            </div>

                            <!--ends here -->
                            @else
                            <div class="alert alert-danger">
                                Something went wrong, Please try again in 24 hours
                            </div>

                            @endif

                        </div> <!-- End -->




                    </div>
                </div>
            </div>
        </div>


        <script src="{{ asset('js/jquery-1.12.0.min.js') }}"></script>

        @include('include.message')


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous">
        </script>

        <script src="{{ asset('pace/pace.min.js') }}"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

        <script>
            $(function() {

                $("#amount").on("keyup", function() {
                    runCommission();
                });


            });

            $('#card_type').change(function() {

                if ($('#card_type').val() === 'Cash') {
                    $('.cashDeposit').removeClass('disp-0');
                    $('.cardbankDeposit').addClass('disp-0');
                    $('.prepaidInfo').addClass('disp-0');
                    runPayoutAgent();
                } else if ($('#card_type').val() === 'Prepaid Card') {
                    $('.cardbankDeposit').removeClass('disp-0');
                    $('.cashDeposit').addClass('disp-0');
                    runCardType();
                    $('.prepaidInfo').removeClass('disp-0');
                } else if ($('#card_type').val() === 'Bank Account') {
                    $('.cardbankDeposit').removeClass('disp-0');
                    $('.cashDeposit').addClass('disp-0');
                    $('.prepaidInfo').addClass('disp-0');
                    runCardType();
                } else {
                    $('.cardbankDeposit').addClass('disp-0');
                    $('.cashDeposit').addClass('disp-0');
                    $('.prepaidInfo').addClass('disp-0');
                }

                if ($("#amount").val() != "") {
                    runCommission();
                }
            });


            $('#provider').change(function() {


                if ($("#amount").val() != "") {
                    runCommission();
                }
            });




            function runCardType() {

                $('#card_id').html("");

                var route = "{{ URL('/api/v1/getmycarddetail') }}";
                var thisdata = {
                    card_provider: $('#card_type').val()
                };


                Pace.restart();
                Pace.track(function() {

                    setHeaders();

                    jQuery.ajax({
                        url: route,
                        method: 'get',
                        data: thisdata,
                        dataType: 'JSON',

                        success: function(result) {
                            if (result.message == "success") {
                                var res = result.data;

                                if (result.action == "Bank Account") {
                                    $.each(res, function(v, k) {
                                        $('#card_id').append(
                                            `<option value="${k.id}">${k.bankName} - ${k.accountNumber}</option>`
                                        );
                                    });
                                } else {
                                    $.each(res, function(v, k) {
                                        $('#card_id').append(
                                            `<option value="${k.id}">${cardHide(k.card_number)} - ${k.card_provider}</option>`
                                        );
                                    });
                                }




                            } else {
                                $('#card_id').append(
                                    `<option value="">${$('#card_type').val()} not available</option>`);
                            }

                        },
                        error: function(err) {
                            $('#card_id').append(
                                `<option value="">${$('#card_type').val()} not available - Create one in 3sec.</option>`);

                            setTimeout(() => {
                                    location.href = '/mywallet/addbank';
                                }, 3000);
                        }

                    });

                });

            }


            function runPayoutAgent() {

                $('#payout_id').html("");

                var route = "{{ URL('/api/v1/getmycarddetail') }}";
                var thisdata = {
                    card_provider: $('#card_type').val()
                };


                Pace.restart();
                Pace.track(function() {

                    setHeaders();

                    jQuery.ajax({
                        url: route,
                        method: 'get',
                        data: thisdata,
                        dataType: 'JSON',

                        success: function(result) {
                            if (result.message == "success") {
                                var res = result.data;

                                $.each(res, function(v, k) {
                                    $('#payout_id').append(
                                        `<option value="${k.id}">${k.businessname+' - ('+k.address+' '+k.city+', '+k.state+')'}</option>`
                                    );
                                });

                            } else {
                                $('#payout_id').append(
                                    `<option value="">Payout Agent not available</option>`);
                            }

                        },
                        error: function(err) {

                            if (err.responseJSON) {
                                $('#payout_id').append(
                                    `<option value="">${err.responseJSON.message}</option>`);
                            } else {
                                $('#payout_id').append(
                                    `<option value="">${err.message}</option>`);
                            }


                        }

                    });

                });

            }


            function cardHide(card) {
                let hideNum = [];
                for (let i = 0; i < card.length; i++) {
                    if (i < card.length - 4) {
                        hideNum.push("*");
                    } else {
                        hideNum.push(card[i]);
                    }
                }
                return hideNum.join("");
            }

            function runCommission() {

                $('.commissionInfo').html("");
                var amount = $("#amount").val();
                var structure;

                if ($('#card_type').val() == "Prepaid Card") {
                    structure = "EXBC Prepaid Card";
                } else if ($('#card_type').val() == "Cash") {
                    structure = "Payout";
                } else {
                    structure = $("#card_type").val();
                }




                var route = "{{ URL('Ajax/getCommission') }}";
                var thisdata = {
                    check: $('#commission').prop("checked"),
                    amount: amount,
                    pay_method: $('#card_type').val(),
                    localcurrency: "{{ $data['currencyCode']->currencyCode }}",
                    foreigncurrency: "USD",
                    structure: "Withdrawal",
                    structureMethod: structure,
                    payoutAgent: $('#payout_id').val()
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

                            var totalCharge;


                            if (result.message == "success") {
                                var commissionValue = Number(result.data * (1.5/100));

                                $(".wallet-info").html(result.walletCheck);
                                $('.withWallet').removeClass('disp-0');

                                if (result.walletCheck != "") {
                                    $(".withdrawmoneyBtn").attr("disabled", true);
                                    $('.commissionInfo').addClass('disp-0');
                                } else {
                                    $(".withdrawmoneyBtn").attr("disabled", false);
                                    $('.commissionInfo').removeClass('disp-0');
                                }


                                if (result.state == "commission available" && result.walletCheck == "") {

                                    $('.commissionInfo').addClass('alert alert-success');
                                    $('.commissionInfo').removeClass('alert alert-danger');

                                    if ($('#card_type').val() == "Cash") {
                                        $('.commissionInfo').html(
                                            "<ul><li><span style='font-weight: bold;'>Kindly note that a total amount of: {{ $data['currencyCode']->currencySymbol }}" +
                                            (Number(result.data)).toFixed(2) + " will be given to you as " + $(
                                                '#card_type').val() +
                                            ". Fee charge {{ $data['currencyCode']->currencySymbol }}"+Number(commissionValue).toFixed(2)+" inclusive</span></li></li></ul>");
                                    } else {
                                        $('.commissionInfo').html(
                                            "<ul><li><span style='font-weight: bold;'>Kindly note that a total amount of: {{ $data['currencyCode']->currencySymbol }}" +
                                            (Number(result.data)).toFixed(2) + " will be credited to your " + $(
                                                '#card_type').val() +
                                            ". Fee charge of {{ $data['currencyCode']->currencySymbol }}"+Number(commissionValue).toFixed(2)+" inclusive</span></li></li></ul>");
                                    }



                                    $("#amounttosend").val(result.data);
                                    $("#commissiondeduct").val(commissionValue);

                                    $("#totalcharge").val(Number(result.data + commissionValue));

                                    totalCharge = Number($("#amount").val()) + Number(commissionValue);

                                    currencyConvert(totalCharge);


                                }
                                // else{

                                //     $('.commissionInfo').addClass('alert alert-danger');
                                //     $('.commissionInfo').removeClass('alert alert-success');

                                //     $('.commissionInfo').html("<ul><li><span style='font-weight: bold;'>Kindly note that a total amount of: {{ $data['currencyCode']->currencySymbol }}"+(+result.data + +result.collection).toFixed(2)+" will be charged from your "+$('#card_type').val()+".</span></li></li></ul>");

                                //     $("#amounttosend").val(result.data);
                                //     $("#commissiondeduct").val(result.collection);
                                //     $("#totalcharge").val((+result.data + +result.collection));

                                //     totalCharge = $("#amount").val();


                                //     currencyConvert(totalCharge);

                                // }


                            }


                        }

                    });

                });
            }


            function currencyConvert(amount) {


                $("#conversionamount").val("");

                var currency = "CAD";
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


            function handShake(val) {

                var route;

                var formData;

                if (val == 'partnerwithdraw') {

                    formData = new FormData(formElem);

                    route = "{{ URL('/api/v1/partnerwithdrawal') }}";

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
                                $('.withdrawmoneyBtn').text('Please wait...');
                            },
                            success: function(result) {
                                console.log(result);

                                $('.withdrawmoneyBtn').text('Withdraw Money');

                                if (result.status == 200) {
                                    swal("Success", result.message, "success");
                                    setTimeout(function() {
                                        location.href = "{{ route('my account') }}";
                                    }, 15000);
                                } else {
                                    swal("Oops", result.message, "error");
                                }

                            },
                            error: function(err) {
                                $('.withdrawmoneyBtn').text('Withdraw Money');
                                swal("Oops", err.responseJSON.message, "error");

                            }

                        });
                    });

                } else if (val == 'addcard') {
                    formData = new FormData();

                    formData.append('card_number', $("#card_number").val());
                    formData.append('month', $("#month").val());
                    formData.append('year', $("#year").val());
                    formData.append('cvv', $("#cvv").val());

                    route = "{{ URL('/api/v1/addnewcard') }}";

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
                                $('#cardSubmit').text('Please wait...');
                            },
                            success: function(result) {
                                console.log(result);

                                $('#cardSubmit').text('Submit');

                                if (result.status == 200) {
                                    swal("Success", result.message, "success");
                                    setTimeout(function() {
                                        location.reload();
                                    }, 2000);
                                } else {
                                    swal("Oops", result.message, "error");
                                }

                            },
                            error: function(err) {
                                swal("Oops", err.responseJSON.message, "error");

                            }

                        });
                    });

                }

            }

            function goBack() {
                window.history.back();
            }


            function setHeaders() {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        'Authorization': "Bearer " + "{{ Auth::user()->api_token }}"
                    }
                });

            }
        </script>

</body>

</html>
