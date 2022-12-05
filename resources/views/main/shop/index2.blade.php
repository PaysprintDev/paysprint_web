<?php use App\Http\Controllers\User; ?>
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


    {{-- Add Payment Gateway here --}}

    @if ($data['paymentgateway']->gateway == 'Stripe')
        <script src="https://js.stripe.com/v3/"></script>
        <script src="https://polyfill.io/v3/polyfill.min.js?version=3.52.1&features=fetch"></script>
    @endif

    @if ($data['paymentgateway']->gateway == 'PayPal')

        @if (env('APP_ENV') == 'local')
            <script
                src="https://www.paypal.com/sdk/js?client-id={{ env('PAYPAL_LOCAL_CLIENT_ID') }}&currency={{ $data['currencyCode']->currencyCode }}">
            </script>
        @else
            <script
                src="https://www.paypal.com/sdk/js?client-id={{ env('PAYPAL_CLIENT_ID') }}&currency={{ $data['currencyCode']->currencyCode }}">
            </script>
        @endif


    @endif

    <title>PaySprint | Checkout</title>

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
            <div class="col-lg-10 mx-auto text-center">
                <h1 class="display-4">{{ $data['pages'] }}</h1>
            </div>
        </div> <!-- End -->
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="card ">
                    <div class="card-header">
                        <div class="bg-white shadow-sm pt-4 pl-2 pr-2 pb-2">
                            <!-- Credit card form tabs -->
                            <ul role="tablist" class="nav bg-light nav-pills rounded nav-fill mb-3">
                                <li class="nav-item" onclick="location.href='{{ url()->previous() }}'">
                                    <a data-toggle="pill" href="{{ url()->previous() }}" class="nav-link active "> <i
                                            class="fas fa-home"></i> Go Back </a>
                                </li>
                                {{-- <li class="nav-item"> <a data-toggle="pill" href="#paypal" class="nav-link "> <i class="fab fa-paypal mr-2"></i> Debit Card </a> </li>
                                <li class="nav-item"> <a data-toggle="pill" href="#net-banking" class="nav-link "> <i class="fas fa-mobile-alt mr-2"></i> EXBC Card </a> </li> --}}
                            </ul>
                        </div> <!-- End -->
                        <!-- Credit card form content -->
                        <div class="tab-content">

                            @if ($merchant = \App\User::where('ref_code', Request::segment(3))->first())
                                @php
                                    $currencySymb = $merchant->currencySymbol;
                                    $currencycod = $merchant->currencyCode;
                                    $countryBase = $merchant->country;
                                @endphp
                            @endif



                            <!-- credit card info-->
                            <div id="credit-card" class="tab-pane fade show active pt-3">

                                {{-- Cart Information --}}

                                <div class="alert alert-info">
                                    <div class="row">
                                        <div class="col-md-12">

                                            <table class="table table-hover">
                                                <tbody>
                                                    <tr>
                                                        <td>Receiver's Name</td>
                                                        <td><b>{{ $data['paymentorg']->businessname }}</b></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Address</td>
                                                        <td><b>{{ $data['paymentorg']->address }}</b></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Telephone</td>
                                                        <td><b>{{ $data['paymentorg']->telephone }}</b></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Location</td>
                                                        <td><b>{{ $data['paymentorg']->city . ', ' . $data['paymentorg']->state . ' ' . $data['paymentorg']->country }}</b>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>


                                        </div>

                                    </div>
                                </div>

                                <h4>Pay with:</h4>
                                <hr>
                                <ul class="nav nav-tabs" id="myTab" role="tablist">

                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="dontHaveAccount" data-toggle="tab"
                                            data-target="#profile" type="button" role="tab" aria-controls="profile"
                                            aria-selected="false" onclick="setCardType('Debit Card')">
                                            <img src="https://img.icons8.com/color/25/000000/mastercard-logo.png" />
                                            Debit/Credit Card (Fee applies)</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="haveAccount" data-toggle="tab"
                                            data-target="#home" type="button" role="tab" aria-controls="home"
                                            aria-selected="true" onclick="setCardType('Wallet')"><img
                                                src="https://res.cloudinary.com/paysprint/image/upload/v1651130089/assets/paysprint_icon_png_rhxm1e_sqhgj0.png"
                                                style="width:25px; height: 25px;" />
                                            PaySprint Wallet (No fee)</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="paysprintpoint" data-toggle="tab"
                                            data-target="#pointtab" type="button" role="tab" aria-controls="pointtab"
                                            aria-selected="false">
                                            <img src="https://img.icons8.com/external-flat-icons-inmotus-design/25/000000/external-Dot-basic-ui-navigation-elements-flat-icons-inmotus-design.png"/>
                                            PaySprint Points (Coming soon)</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="createAccount" data-toggle="tab"
                                            data-target="#contact" type="button" role="tab" aria-controls="contact"
                                            aria-selected="false"><img
                                                src="https://img.icons8.com/external-ui-website-adri-ansyah/25/000000/external-create-basic-ui-ui-website-adri-ansyah.png" />
                                            Create a PaySprint Account</button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade" id="home" role="tabpanel"
                                        aria-labelledby="haveAccount">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="mt-3">
                                                    <form action="#" method="post" id="forCustomers">
                                                        @csrf

                                                        <input type="hidden" name="invoice_no" id="payinvoiceRef"
                                                            value="{{ 'Shop_' . uniqid() }}">
                                                        <input type="hidden" name="paymentToken" id="paymentToken" value="">
                                                        <input type="hidden" name="currencyCode" id="currencyCode" value="{{ $data['currencyCode']->currencyCode }}">
                                                        <input type="hidden" name="payType" id="payType" value="ps_user">
                                                        <input type="hidden" name="merchant_id" id="payuser_id"
                                                       value="{{ Request::segment(3) }}">

                                                        <div class="form-group"> <label for="enter_account_number">
                                                                <h6><span style="color: red;">*</span> Please enter your
                                                                    PaySprint Account Number</h6>
                                                            </label>
                                                            <div class="input-group">

                                                                <div class="input-group-append"> <span
                                                                        class="input-group-text text-muted">
                                                                        <img
                                                                            src="https://img.icons8.com/emoji/25/000000/keycap-number-sign-emoji.png" /></span>
                                                                </div> <input type="text" name="accountNumber"
                                                                    id="accountNumber" class="form-control"
                                                                    placeholder="11111" required>

                                                                <input type="hidden" name="route" value="estore">
                                                                <input type="hidden" name="mode"
                                                                    value="{{ env('APP_ENV') == 'local' ? 'test' : 'live' }}">
                                                            </div>

                                                            <small class="text-danger errorBalance"></small>

                                                        </div>


                                                        <div class="alert alert-warning">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <h4>
                                                                        Wallet Balance
                                                                    </h4>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <h4 class='mywalletBalance'>
                                                                    </h4>
                                                                </div>
                                                            </div>
                                                        </div>



                                                        <div
                                                            class="form-group @if ($data['currencyCode']->currencyCode != $data['paymentorg']->currencyCode) disp-0 @endif">
                                                            <label for="amount">
                                                                <h6><span style="color: red;">*</span> Amount</h6>
                                                            </label>
                                                            <div class="input-group">

                                                                <div class="input-group-append"> <span
                                                                        class="input-group-text text-muted">
                                                                        {{ $data['currencyCode']->currencySymbol }}</span>
                                                                </div>
                                                                <input type="text" name="amount"
                                                                    class="form-control" id="amounttosend"
                                                                    placeholder="{{ sprintf('%.2f', 0) }}">
                                                            </div>
                                                        </div>


                                                        <div
                                                            class="form-group @if ($data['currencyCode']->currencyCode == $data['paymentorg']->currencyCode) disp-0 @endif">
                                                            <label for="amount">
                                                                <h6><span style="color: red;">*</span>Amount</h6>
                                                            </label>
                                                            <div class="input-group">

                                                                <div class="input-group-append"> <span
                                                                        class="input-group-text text-muted">
                                                                        {{ $data['currencyCode']->currencySymbol }}</span>
                                                                </div>

                                                                <input type="text" name="conversionamount"
                                                                    class="form-control conversionamount"
                                                                    id="conversionamount"
                                                                    placeholder="{{ sprintf('%.2f', 0) }}">
                                                            </div>
                                                        </div>

                                                        <div class="form-group"> <label for="commissiondeduct">
                                                                <h6>Fee Charge</h6>
                                                            </label>
                                                            <div class="input-group">
                                                                <input type="text" name="commissiondeduct"
                                                                    class="form-control commissiondeduct"
                                                                    id="commissiondeduct" value=""
                                                                    placeholder="0.00" readonly>

                                                                <input type="hidden" name="totalcharge"
                                                                    class="form-control" id="totalcharge"
                                                                    value="" placeholder="0.00" readonly>

                                                            </div>
                                                        </div>


                                                        <div class="form-group"> <label for="purpose">
                                                                <h6><span style="color: red;">*</span> Purpose of
                                                                    Payment</h6>
                                                            </label>
                                                            <div class="input-group">

                                                                <div class="input-group-append"> <span
                                                                        class="input-group-text text-muted">
                                                                        <img
                                                                            src="https://img.icons8.com/nolan/25/shopping-cart-promotion.png" /></span>
                                                                </div>
                                                                <input type="text" name="purpose"
                                                                    class="form-control" id="purpose">
                                                            </div>
                                                        </div>

                                                        <div class="form-group"> <label for="transactionPin">
                                                                <h6><span style="color: red;">*</span> Transaction Pin
                                                                </h6>
                                                            </label>
                                                            <div class="input-group">

                                                                <div class="input-group-append"> <span
                                                                        class="input-group-text text-muted">
                                                                        <img
                                                                            src="https://img.icons8.com/emoji/25/000000/keycap-number-sign-emoji.png" /></span>
                                                                </div> <input type="password" name="transactionPin"
                                                                    id="transactionPin" class="form-control"
                                                                    placeholder="Transaction Pin:" required>
                                                            </div>
                                                        </div>


                                                        <input type="hidden" name="cardType" id="cardType"
                                                            value="Wallet">

                                                        <div class="form-group">
                                                            <strong><span
                                                                    class="text-danger wallet-info"></span></strong>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="commissionInfo"></div>
                                                        </div>

                                                        <div class="form-group mt-4 withWallet">

                                                            <button type="button" onclick="payLinkInShop('pay_as_customer')"
                                                                class="subscribe btn btn-primary btn-block shadow-sm sendmoneyBtn">
                                                                Make Payment </button>
                                                        </div>

                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="tab-pane fade show active" id="profile" role="tabpanel"
                                        aria-labelledby="dontHaveAccount">


                                        {{-- Check if validated account --}}
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="mt-3">
                                                    <form role="form" action="#" method="POST" id="forVisitors" novalidate>
                                    @csrf
                                    <input type="hidden" name="invoice_no" id="payinvoiceRef"
                                        value="{{ 'Shop_' . uniqid() }}">
                                    <input type="hidden" name="paymentToken" id="paymentToken" value="">


                                    <input type="hidden" name="merchant_id" id="payuser_id"
                                        value="{{ Request::segment(3) }}">

                                        <input type="hidden" name="cardType" id="cardType"
                                        value="">
                                    <div class="form-group"> <label for="currency">
                                            <h6>Full Name</h6>
                                        </label>

                                        <div class="input-group"> <span class="input-group-text text-muted"> <img
                                                    src="https://img.icons8.com/small/24/000000/user.png" /></span>
                                            <input type="text" name="fullname" id="fullname" class="form-control"
                                                value="">
                                            <div class="input-group-append"> </div>
                                        </div>
                                    </div>


                                    <div class="form-group"> <label for="currency">
                                            <h6>Email Address</h6>
                                        </label>

                                        <div class="input-group"> <span class="input-group-text text-muted"><img
                                                    src="https://img.icons8.com/fluency/24/000000/email.png" /></span>
                                            <input type="email" name="email_address" id="email_address"
                                                class="form-control" value="">
                                            <div class="input-group-append"> </div>
                                        </div>
                                    </div>


                                    <div class="form-group"> <label for="currency">
                                            <h6>Purpose of Payment</h6>
                                        </label>

                                        <div class="input-group"> <span class="input-group-text text-muted"><img
                                                    src="https://img.icons8.com/external-bearicons-flat-bearicons/24/000000/external-Target-business-and-marketing-bearicons-flat-bearicons.png" /></span>
                                            <input type="text" name="purpose" id="purpose" class="form-control"
                                                value="">
                                            <div class="input-group-append"> </div>
                                        </div>
                                    </div>


                                    <div class="form-group disp-0"> <label for="currency">
                                            <h6>Currency</h6>
                                        </label>
                                        <div class="input-group">
                                            <select name="currency" id="currency" class="form-control">
                                                <option value="{{ $data['currencyCode']->currencySymbol }}">
                                                    {{ $data['currencyCode']->currencySymbol }}</option>
                                            </select>

                                        </div>
                                    </div>




                                    @if ($countryBase != $data['currencyCode']->name)
                                        <div class="form-group converter"> <label for="netwmount">
                                                <h6>Currency Conversion <br><small class="text-info"><b>Exchange
                                                            rate </b> <br> <span id="rateToday"></span> </small></h6>


                                                <table class="table table-bordered table-striped" width="100%">
                                                    <tbody>
                                                        <tr style="font-weight: bold;">
                                                            <td>{{ $data['currencyCode']->currencyCode }}</td>
                                                            <td>{{ $currencycod }}</td>
                                                        </tr>
                                                        <tr style="font-weight: bold;">
                                                            <td class="text-success" id="typedAmount"></td>
                                                            <td class="text-primary" id="convertedAmount"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                            </label>



                                        </div>

                                        <div class="form-group">
                                            <div class="input-group">
                                                <p style="color: red; font-weight: bold;"><input type="checkbox"
                                                        name="convertRate" id="convertRate"
                                                        onchange="checkBoxConfirm()"> Accept conversion rate</p>

                                            </div>
                                        </div>
                                    @else
                                        <div class="form-group disp-0">
                                            <div class="input-group">
                                                <p style="color: red; font-weight: bold;"><input type="checkbox"
                                                        checked name="convertRate" id="convertRate"> Accept
                                                    conversion rate</p>

                                            </div>
                                        </div>
                                    @endif



                                    @if ($countryBase == $data['currencyCode']->name)
                                        <div class="form-group disp-0">
                                            <div class="input-group">
                                                <p style="color: red; font-weight: bold;"><input type="checkbox"
                                                        checked name="convertRate" id="convertRate"> Accept
                                                    conversion rate</p>

                                            </div>
                                        </div>



                                        <div class="form-group topay"> <label for="currency">
                                                <h6>Amount to Pay</h6>
                                            </label>
                                            <input type="hidden" value="{{ $data['currencyCode']->currencyCode }}"
                                                name="currencyCode">
                                            <div class="input-group"> <span class="input-group-text text-muted">
                                                    {{ $data['currencyCode']->currencySymbol }} </span>
                                                <input type="number" min="0.00" step="0.01" name="amount"
                                                    id="typepayamount" placeholder="50.00" class="form-control"
                                                    value="">
                                                <div class="input-group-append"> </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="form-group topay"> <label for="currency">
                                                <h6>Amount to Pay</h6>
                                            </label>
                                            <input type="hidden" value="{{ $data['currencyCode']->currencyCode }}"
                                                name="currencyCode">
                                            <div class="input-group"> <span class="input-group-text text-muted">
                                                    {{ $data['currencyCode']->currencySymbol }} </span> <input
                                                    type="number" min="0.00" step="0.01" name="amount"
                                                    id="typepayamount" placeholder="50.00" class="form-control"
                                                    value="1.00">
                                                <div class="input-group-append"> </div>
                                            </div>
                                        </div>
                                    @endif


                                    <div class="form-group"> <label for="netwmount">
                                            Fee
                                        </label>
                                        <input type="text" name="commissiondeduct" class="form-control commissiondeduct"
                                            id="commissiondeduct" value="" placeholder="0.00" readonly>

                                        <input type="hidden" name="totalcharge" class="form-control"
                                            id="totalcharge" value="" placeholder="0.00" readonly>

                                    </div>



                                    <div class="form-group">
                                        <div class="commissionInfo"></div>
                                    </div>

                                    <hr>


                                    {{-- Pay Using Moneris --}}

                                    @if ($data['currencyCode']->gateway == 'Moneris')
                                        <div class="form-group"> <label for="paycreditcard">
                                                <h6>Card number</h6>
                                            </label>
                                            <div class="input-group"> <input type="number" name="creditcard_no"
                                                    id="paycreditcard" placeholder="5199392421005430"
                                                    class="form-control" maxlength="16" required>
                                                <div class="input-group-append"> <span
                                                        class="input-group-text text-muted"> <i
                                                            class="fab fa-cc-visa mx-1"></i> <i
                                                            class="fab fa-cc-mastercard mx-1"></i> <i
                                                            class="fab fa-cc-amex mx-1"></i> </span> </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group"> <label><span class="hidden-xs">
                                                            <h6>Month</h6>
                                                        </span></label>
                                                    <div class="input-group"> <select name='month' id="paymonth"
                                                            class='form-control'>
                                                            <option selected value='01'>January</option>
                                                            <option value='02'>February</option>
                                                            <option value='03'>March</option>
                                                            <option value='04'>April</option>
                                                            <option value='05'>May</option>
                                                            <option value='06'>June</option>
                                                            <option value='07'>July</option>
                                                            <option value='08'>August</option>
                                                            <option value='09'>September</option>
                                                            <option value='10'>October</option>
                                                            <option value='11'>November</option>
                                                            <option value='12'>December</option>
                                                        </select>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label><span class="hidden-xs">
                                                            <h6>Year</h6>
                                                        </span></label>
                                                    <div class="input-group">
                                                        <select name='expirydate' id="payyear"
                                                            class='form-control'>
                                                            @for ($i = 21; $i <= 50; $i++)
                                                                <option value='{{ $i }}'>
                                                                    {{ $i }}</option>
                                                            @endfor

                                                        </select>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="col-sm-4">
                                                <div class="form-group mb-4"> <label data-toggle="tooltip"
                                                        title="Three digit CV code on the back of your card">
                                                        <h6>CVV <i class="fa fa-question-circle d-inline"></i></h6>
                                                    </label> <input type="number" required class="form-control"
                                                        name="cvv" placeholder="435"> </div>
                                            </div>
                                        </div>


                                        <div class="card-footer"> <button type="button"
                                                onclick="handShake('payinshop')"
                                                class="subscribe btn btn-primary btn-block shadow-sm {{ $countryBase == $data['currencyCode']->name ? 'cardSubmit' : 'sendmoneyBtn' }}">
                                                Make Payment </button></div>

                                    @endif


                                    {{-- Pay Using Stripe --}}

                                    @if ($data['currencyCode']->gateway == 'Stripe')
                                        <input type="hidden" name="name" class="form-control" id="nameInput"
                                            value="{{ $data['name'] }}" readonly>

                                        <input type="hidden" name="email" class="form-control" id="emailInput"
                                            value="{{ $data['email'] }}" readonly>

                                        <div class="form-group"> <label for="card-elemet">
                                                <h6>Card Detail</h6>
                                            </label>
                                            <div id="card-element"></div>
                                        </div>



                                        <div class="card-footer"> <button type="submit"
                                                class="subscribe btn btn-info btn-block shadow-sm {{ $countryBase == $data['currencyCode']->name ? 'cardSubmit' : 'sendmoneyBtn' }}">
                                                Make Payment</button></div>
                                    @endif


                                    {{-- Pay Using PayPal --}}

                                    @if ($data['currencyCode']->gateway == 'PayPal')
                                        <div class="card-footer" id="paypal-button-container"></div>
                                    @endif


                                    {{-- Pay Using PayStack --}}
                                    @if ($data['currencyCode']->gateway == 'PayStack' || $data['currencyCode']->gateway == 'Express Payment Solution')
                                        <div class="form-group topay disp-0"> <label for="currency">
                                                <h6>Amount to Pay</h6>
                                            </label>
                                            <input type="hidden" value="{{ $data['currencyCode']->currencyCode }}"
                                                name="currencyCode">
                                            <div class="input-group"> <span class="input-group-text text-muted">
                                                    {{ $data['currencyCode']->currencySymbol }} </span> <input
                                                    type="number" min="0.00" step="0.01" name="amount"
                                                    id="typepayamount" placeholder="50.00" class="form-control"
                                                    value="">
                                                <div class="input-group-append"> </div>
                                            </div>
                                        </div>


                                        <div class="card-footer"> <button type="button" onclick="payWithEPS()"
                                                class="subscribe btn btn-info btn-block shadow-sm {{ $countryBase == $data['currencyCode']->name ? 'cardSubmit' : 'sendmoneyBtn' }}">
                                                Make Payment </button></div>
                                    @endif




                                </form>
                                </div>
                                </div>
                                </div>


                                    </div>
                                    <div class="tab-pane fade" id="contact" role="tabpanel"
                                        aria-labelledby="createAccount">

                                        <div class="mt-3">

                                            <div class="card">
                                                <div class="card-body">
                                                    <center>
                                                        <p>Create a PaySprint account to save on processing fees.</p>


                                                        <p>
                                                            <a type="button" class="btn btn-primary"
                                                                href="{{ route('register') }}" target="_blank">Create
                                                                Consumer Account</a> <a type="button"
                                                                class="btn btn-success"
                                                                href="{{ route('AdminRegister') }}"
                                                                target="_blank">Create Merchant Account</a>
                                                        </p>



                                                        <p>
                                                            or
                                                        </p>

                                                        <p>DOWNLOAD OUR APP</p>

                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <a href="https://play.google.com/store/apps/details?id=com.fursee.damilare.sprint_mobile"
                                                                    target="_blank"
                                                                    class="btn text-white gr-hover-y px-lg-9">
                                                                    <img src="https://res.cloudinary.com/paysprint/image/upload/v1651130088/assets/l6-download-gplay_o9rcfj_l6erwf.png"
                                                                        alt="play store" width="100%">
                                                                </a>
                                                                <a href="https://apps.apple.com/gb/app/paysprint/id1567742130"
                                                                    target="_blank"
                                                                    class="btn text-white gr-hover-y px-lg-9">
                                                                    <img src="https://res.cloudinary.com/paysprint/image/upload/v1651130088/assets/l6-download-appstore_odcskf_atgygf.png"
                                                                        alt="apple store" width="100%">
                                                                </a>
                                                            </div>
                                                        </div>

                                                    </center>
                                                </div>
                                            </div>



                                        </div>
                                    </div>


                                </div>
                            </div>

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.26.1/axios.min.js"></script>

    <script src="{{ asset('pace/pace.min.js') }}"></script>
    <script src="{{ asset('js/country-state-select.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <script language="javascript">
        populateCountries("country", "state");
    </script>


    @if ($data['paymentgateway']->gateway == 'Stripe')
        <script>
            // Stripe Integration Starts



            document.addEventListener('DOMContentLoaded', async () => {

                // var stripe = Stripe('{{ env('STRIPE_LIVE_PUBLIC_KEY') }}');
                var stripe = Stripe('{{ env('STRIPE_LOCAL_PUBLIC_KEY') }}');

                var elements = stripe.elements();

                var cardElement = elements.create('card');
                cardElement.mount('#card-element');


                var form = document.querySelector('#forVisitors');

                form.addEventListener('submit', async (e) => {
                    e.preventDefault();

                    var netamount = $('#conversionamount').val();
                    var feeamount = $('.commissiondeduct').val();
                    var amount = (+netamount + +feeamount).toFixed(2);

                    var route = '/create-payment-intent';

                    var formData = new FormData(forVisitors);

                    formData.append('paymentMethodType', 'card');
                    formData.append('amount', amount);
                    formData.append('amounttosend', amount);
                    formData.append('commissiondeduct', $('.commissiondeduct').val());
                    formData.append('currencyCode', `{{ $data['currencyCode']->currencyCode }}`);

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

                                if (result.status == 200) {

                                    // swal("Success", result.message, "success");
                                    // setTimeout(function(){ location.reload(); }, 2000);

                                    var firstNameInput = document.querySelector(
                                        '#firstname');
                                    var lastNameInput = document.querySelector(
                                        '#lastname');
                                    var emailInput = document.querySelector(
                                        '#email');

                                    var paymentIntent = stripe.confirmCardPayment(
                                        result.res.clientSecret, {
                                            payment_method: {
                                                card: cardElement,
                                                billing_details: {
                                                    name: firstNameInput.value +
                                                        ' ' + lastNameInput
                                                        .value,
                                                    email: emailInput.value,
                                                }
                                            }
                                        }
                                    ).then(function(result) {
                                        $('.sendmoneyBtn').text('Pay Now');

                                        if (result.error) {
                                            swal("Oops", result.error
                                                .message, "error");
                                        } else {

                                            $('#paymentToken').val(result
                                                .paymentIntent.id);

                                            setTimeout(() => {
                                                handShake(
                                                    'payinshop'
                                                );
                                            }, 1000);

                                        }

                                    });


                                } else {
                                    swal("Oops", result.message, "error");
                                }



                            },
                            error: function(err) {
                                $('.sendmoneyBtn').text('Pay Now');
                                swal("Oops", err.responseJSON.message, "error");

                            }

                        });
                    });


                    // Create PaymentIntent on the server
                    //   var {clientSecret} = await fetch('/create-payment-intent', {
                    //     method: 'POST',
                    //     headers: {
                    //       'Content-Type': 'application/json',
                    //       'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    //     },
                    //     body: JSON.stringify({
                    //       paymentMethodType: 'card',
                    //       currency: $('#curCurrency').val(),
                    //       amount: amount,
                    //     }),

                    //   }).then(resp=>resp.json);





                    //   console.log(paymentIntent);

                });

            });



            // Stripe Integration Ends
        </script>
    @endif


    @if ($data['paymentgateway']->gateway == 'PayPal')
        <script>
            // Paypal Integration Start

            paypal.Buttons({

                createOrder: function(data, actions) {

                    var netamount = $('#conversionamount').val();
                    var feeamount = $('.commissiondeduct').val();
                    var amount = (+netamount + +feeamount).toFixed(2);

                    // Set up the transaction
                    return actions.order.create({
                        purchase_units: [{
                            amount: {
                                value: amount
                            }
                        }]
                    });
                },
                onApprove: function(data, actions) {
                    // This function captures the funds from the transaction.
                    return actions.order.capture().then(function(details) {

                        if (details.status == "COMPLETED") {
                            $('#paymentToken').val(data.orderID);

                            // alert("Looks like the transaction is approved.");
                            setTimeout(() => {
                                handShake('payinshop');
                            }, 1000);
                        }

                        // This function shows a transaction success message to your buyer.
                        // alert('Transaction completed by ' + details.payer.name.given_name);
                    });
                },
                onCancel: function(data) {
                    alert("Transaction cancelled for " + data.orderID);
                },
                onError: function(err) {
                    alert(err);
                }
            }).render('#paypal-button-container');


            // PayPal Integration End
        </script>
    @endif

    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip();

            setCardType('Debit Card');
        });



        function setCardType(value) {
            if (value != null) {

                if (value == "Debit Card") {
                    $('#cardType').val(value);

                    $('#commission').prop("checked", false);

                    $('.processFee').removeClass('disp-0');



                } else {
                    $('#cardType').val(value);
                    $('.processFee').addClass('disp-0');

                    $('#commission').prop("checked", true);
                }
                runCommission();

            } else {
                $('#cardType').val('Wallet');

            }

        }




        function restriction(val, name) {
            if (val == "sendmoney") {
                swal('Hello ' + name, 'Your account needs to be verified before you can send money', 'info');
            }
        }



        $('#accountNumber').on('keyup', async function() {

            if ($('#accountNumber').val() != '') {

                $('.mywalletBalance').text('');
                $('.errorBalance').text('');

                try {


                    let data = {
                        accountNumber: $('#accountNumber').val(),
                        platform: 'estore'
                    }
                    let result = await axios({
                        method: 'POST',
                        url: "{{ route('check customer wallet balance') }}",
                        headers: {},
                        data: data
                    });


                    $('.errorBalance').text('');

                    if (result.status === 200) {
                        $('.mywalletBalance').text(
                            `${result.data.data.currencyCode+' '+parseFloat(result.data.data.wallet_balance).toFixed(2)}`
                        );
                    }

                    runCommission();


                } catch (error) {

                    $('.mywalletBalance').text('');

                    if (error.response) {
                        $('.errorBalance').text(
                            `${error.response.data.message}`);
                    } else {
                        $('.errorBalance').text(
                            `${error.message}`);
                    }


                }



            }


        });



                    function payLinkInShop(val) {

                var route;

                var formData;

                if (val == 'pay_as_customer') {
                    formData = new FormData(forCustomers);
                    route = "{{ URL('/api/v1/payinshop') }}";

                    Pace.restart();
                    Pace.track(function() {
                        authHeaders();
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
                                $('.cardSubmit').text('Please wait...');
                            },
                            success: function(result) {

                                $('.sendmoneyBtn').text('Make Payment');
                                $('.cardSubmit').text('Make Payment');

                                if (result.status == 200) {
                                    swal("Success", result.message, "success");
                                    setTimeout(function() {
                                        location.href = "{{ route('home') }}";
                                    }, 2000);
                                } else {
                                    swal("Oops", result.message, "error");
                                }

                            },
                            error: function(err) {
                                $('.sendmoneyBtn').text('Make Payment');
                                $('.cardSubmit').text('Make Payment');
                                swal("Oops", err.responseJSON.message, "error");

                            }

                        });
                    });

                }

            }





                    function handShake(val) {

                var route;

                var formData;

                if (val == 'payinshop') {
                    formData = new FormData(forVisitors);
                    route = "{{ URL('/api/v1/payinshop') }}";

                    Pace.restart();
                    Pace.track(function() {
                        authHeaders();
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
                                $('.cardSubmit').text('Please wait...');
                            },
                            success: function(result) {

                                $('.sendmoneyBtn').text('Make Payment');
                                $('.cardSubmit').text('Make Payment');

                                if (result.status == 200) {
                                    swal("Success", result.message, "success");
                                    setTimeout(function() {
                                        location.href = "{{ route('home') }}";
                                    }, 2000);
                                } else {
                                    swal("Oops", result.message, "error");
                                }

                            },
                            error: function(err) {
                                $('.sendmoneyBtn').text('Make Payment');
                                $('.cardSubmit').text('Make Payment');
                                swal("Oops", err.responseJSON.message, "error");

                            }

                        });
                    });

                }

            }

        // Axios to process the payment...

        async function payForOrder() {
            try {


                $('.sendmoneyBtn').text('Processing...');

                var data = new FormData(forCustomers);
                var headers = {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    'Authorization': 'Bearer {{ $data['merchantApiKey'] }}'
                };

                const config = {
                    method: 'POST',
                    url: "{{ URL('/api/v1/customers') }}",
                    headers: headers,
                    data: data
                }



                $('.sendmoneyBtn').text('Make Payment');


                const response = await axios(config);


                swal("Great", response.data.message, "success");

                setTimeout(function() {
                    location.href =
                        "{{ route('merchant shop now', $data['paymentorg']->businessname) }}";
                }, 2000);



            } catch (error) {

                $('.sendmoneyBtn').text('Make Payment');

                if (error.response) {
                    swal("Oops", error.response.data.message, "error");
                } else {
                    swal("Oops", error.message, "error");
                }
            }
        }


        //setup before functions
var typingTimer;                //timer identifier
var doneTypingInterval = 2000;  //time in ms, 5 seconds for example
var $input = $('#amounttosend, #typepayamount');

//on keyup, start the countdown
$input.on('keyup', function () {
  clearTimeout(typingTimer);
  typingTimer = setTimeout(doneTyping, doneTypingInterval);
});

//on keydown, clear the countdown
$input.on('keydown', function () {
  clearTimeout(typingTimer);
});

//user is "finished typing," do something
function doneTyping () {
  runCommission();
}





        function runCommission() {


            $('.commissionInfo').html("");
            $(".convertedCommission").html("");
            var amount = ($('#cardType').val() === 'Debit Card') ? $("#typepayamount").val() : $("#amounttosend").val();
            // var amount = $("#conversionamount").val();
            var card_type = $('#cardType').val();
            var refCode = $('#accountNumber').val();
            var country = `{{ $data['paymentgateway']->name }}`;


            var route = "{{ URL('Ajax/getlinkCommission') }}";
            var thisdata = {
                check: $('#commission').prop("checked"),
                amount: amount,
                pay_method: card_type,
                localcurrency: "{{ $data['paymentorg']->currencyCode }}",
                foreigncurrency: "USD",
                structure: "Add Funds/Money",
                structureMethod: card_type,
                refCode,
                country
            };






            Pace.restart();
            Pace.track(function() {

                authHeaders();

                jQuery.ajax({
                    url: route,
                    method: 'post',
                    data: thisdata,
                    dataType: 'JSON',
                    beforeSend: function() {
                        $('.commissionInfo').addClass('');
                    },


                    success: function(result) {

                        console.log(result);



                        var totalCharge;

                        if (result.message == "success") {



                            $(".wallet-info").html(result.walletCheck);
                            $('.withWallet').removeClass('disp-0');




                            if (result.walletCheck != "") {
                                $(".sendmoneyBtn").attr("disabled", true);
                                checkBoxConfirm();

                            } else {
                                $(".sendmoneyBtn").attr("disabled", false);
                                checkBoxConfirm();
                            }


                            if ($('#cardType').val() == "Debit Card") {
                                $(".sendmoneyBtn").attr("disabled", false);
                            }


                            if (result.state == "commission available") {

                                var chargeAmount = $("#amounttosend").val();

                                $('.commissionInfo').addClass('alert alert-success');
                                $('.commissionInfo').removeClass('alert alert-danger');



                                $("#amounttosend").val(result.data);
                                $(".commissiondeduct").val(result.collection);

                                $("#totalcharge").val(chargeAmount);

                                totalCharge = $("#totalcharge").val();

                                currencyConvert(totalCharge);

                                $('.processFee').html(
                                    "<strong class='text-danger'>Processing Fees: {{ $data['paymentorg']->currencySymbol }}" +
                                    parseFloat(result.collection).toFixed(2) +
                                    "</strong><p>(You can save on Processing Fees by Opening  a PaySprint Account)</p>"
                                );



                                $('.commissionInfo').html(
                                    "<ul><li><span style='font-weight: bold;'>Kindly note that a total amount of: {{ $data['paymentorg']->currencySymbol }}" +
                                    chargeAmount +
                                    " <span class='convertedCommission'></span> will be charged.</span></li></li></ul>"
                                );


                            } else {

                                $('.commissionInfo').addClass('alert alert-danger');
                                $('.commissionInfo').removeClass('alert alert-success');



                                $("#amounttosend").val(result.data);
                                $(".commissiondeduct").val(result.collection);
                                $("#totalcharge").val((+result.data + +result.collection));

                                totalCharge = $("#totalcharge").val();


                                currencyConvert(totalCharge);

                                $('.processFee').html(
                                    "<strong class='text-danger'>Processing Fees: {{ $data['paymentorg']->currencySymbol }}" +
                                    parseFloat(result.collection).toFixed(2) +
                                    "</strong><p>(You can save on Processing Fees by Opening  a PaySprint Account)</p>"
                                );


                                $('.commissionInfo').html(
                                    "<ul><li><span style='font-weight: bold;'>Kindly note that a total amount of: {{ $data['paymentorg']->currencySymbol }}" +
                                    (+result.data + +result.collection).toFixed(2) +
                                    " <span class='convertedCommission'></span> will be charged.</span></li></li></ul>"
                                );

                            }




                        }


                    }

                });

            });
        }

        function currencyConvert(amount) {

            $(".conversionamount").val("");
            $(".convertedCommission").html("");

            var currency = "{{ $data['currencyCode']->currencyCode }}";
            var localcurrency = "{{ $data['paymentorg']->currencyCode }}";
            var route = "{{ URL('Ajax/getconversion') }}";
            var thisdata = {
                currency: currency,
                amount: amount,
                val: "pay",
                localcurrency: localcurrency
            };



            mainHeaders();
            jQuery.ajax({
                url: route,
                method: 'post',
                data: thisdata,
                dataType: 'JSON',
                success: function(result) {


                    if (result.message == "success") {
                        $(".conversionamount").val(parseFloat(result.data).toFixed(2));
                        $(".convertedCommission").html("({{ $data['currencyCode']->currencySymbol }}" +
                            parseFloat(result.data).toFixed(2) + ")");

                    } else {
                        $(".conversionamount").val("");
                        $(".convertedCommission").html("");
                    }



                }

            });
        }




        // EPS Integration...

            async function payWithEPS() {
                $('.cardSubmit').text('Please wait...');
                $('.sendmoneyBtn').text('Please wait...');

                try {

                    var callbackUrl;

                    var netamount = $('#typepayamount').val();
                    var feeamount = $('.commissiondeduct').val();
                    var amount = (+netamount + +feeamount).toFixed(2);
                    var paymentToken = '' + Math.floor((Math.random() * 1000000000) + 1);
                    var publicKey =
                        `{{ env('APP_ENV') == 'local' ? env('EPXRESS_PAYMENT_KEY_DEV') : env('EPXRESS_PAYMENT_KEY_PROD') }}`;
                    var commission = $('#conversionamount').val();
                    var currencyCode = `{{ $data['currencyCode']->currencyCode }}`;
                    var conversionamount = $('#conversionamount').val();
                    var ref_code = `{{ $data['refCode'] }}`;

                    if (`{{ env('APP_ENV') }}` != "local") {
                        callbackUrl =
                            `{{ env('APP_URL') }}/expresspay/business?paymentToken=${paymentToken}&commission=${commission}&amount=${amount}&commissiondeduct=${feeamount}&currencyCode=${currencyCode}&conversionamount=${conversionamount}&amounttosend=${netamount}&ref_code=${ref_code}`;
                    } else {
                        callbackUrl =
                            `http://localhost:9090/expresspay/business?paymentToken=${paymentToken}&commission=${commission}&amount=${amount}&commissiondeduct=${feeamount}&currencyCode=${currencyCode}&conversionamount=${conversionamount}&amounttosend=${netamount}&ref_code=${ref_code}`;
                    }

                    var productId = paymentToken;
                    var description = "Paid {{ $currencySymb }}" + netamount +
                        " to {{ $data['name'] }} for " + $('#purpose').val();

                    var data = JSON.stringify({
                        "amount": amount,
                        "transactionId": paymentToken,
                        "email": $('#email_address').val(),
                        "publicKey": publicKey,
                        "currency": "NGN",
                        "mode": "Debug",
                        "callbackUrl": callbackUrl,
                        "productId": productId,
                        "applyConviniencyCharge": true,
                        "productDescription": description,
                        "bodyColor": "#0000",
                        "buttonColor": "#0000",
                        "footerText": "Powered by Pro-filr Nig. LTD",
                        "footerLink": "https://paysprint.ca",
                        "footerLogo": "https://res.cloudinary.com/paysprint/image/upload/v1650628016/assets/pay_sprint_black_horizotal_fwqo6q_ekpq1g.png",
                        "metadata": [{
                            "name": "name",
                            "value": "{{ $data['name'] }}"
                        }, {
                            "name": "description",
                            "value": "Paid {{ $currencySymb }}" + netamount +
                                " to {{ $data['name'] }} for " + $('#purpose').val()
                        }]
                    });


                    var config = {
                        method: 'post',
                        url: `{{ env('APP_ENV') == 'local' ? env('EPXRESS_PAYMENT_URL_DEV') : env('EPXRESS_PAYMENT_URL_PROD') }}api/Payments/Initialize`,
                        headers: {
                            'Authorization': `bearer {{ env('APP_ENV') == 'local' ? env('EPXRESS_PAYMENT_KEY_DEV') : env('EPXRESS_PAYMENT_KEY_PROD') }}`,
                            'Content-Type': 'application/json'
                        },
                        data: data
                    };

                    // console.log(config);

                    const response = await axios(config);

                    // console.log(response);

                    $('.cardSubmit').text('Make Payment');
                    $('.sendmoneyBtn').text('Make Payment');


                    setTimeout(() => {
                        location.href = response.data.data.paymentUrl;
                    }, 1000);

                } catch (error) {
                    $('.cardSubmit').text('Make Payment');
                    $('.sendmoneyBtn').text('Make Payment');
                    console.log(error);

                    if (error.response) {
                        swal('Oops!', error.response.data.responseMessage, 'error');

                    } else {

                        swal("Oops", error.responseJSON.message, "error");

                    }

                }


            }



            function checkBoxConfirm() {


                var convertRate = $('#convertRate').prop("checked");


                if (convertRate == true) {
                    // Enable button
                    $(".sendmoneyBtn").attr("disabled", false);
                } else {
                    // Disable button
                    $(".sendmoneyBtn").attr("disabled", true);

                }

            }



        //Set CSRF HEADERS
        function setHeaders() {
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    'Authorization': 'Bearer {{ $data['merchantApiKey'] }}'
                }
            });
        }


        function mainHeaders() {
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    'Authorization': 'Bearer {{ $data['merchantMainApiKey'] }}'
                }
            });
        }


        function authHeaders() {
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    'Authorization': "Bearer " + "{{ env('APP_KEY') }}"
                }
            });
        }
    </script>


</body>

</html>
