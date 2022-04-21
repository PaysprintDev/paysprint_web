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
    <link rel="icon" href="https://res.cloudinary.com/pilstech/image/upload/v1602675914/paysprint_icon_png_ol2z3u.png"
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
                <h1 class="display-4">Checkout Payment</h1>
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





                            <!-- credit card info-->
                            <div id="credit-card" class="tab-pane fade show active pt-3">

                                {{-- Cart Information --}}

                                <div class="alert alert-info">
                                    <div class="row">
                                        <div class="col-md-6">

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
                                                        <td>Location</td>
                                                        <td><b>{{ $data['paymentorg']->city . ', ' . $data['paymentorg']->state . ' ' . $data['paymentorg']->country }}</b>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>


                                        </div>
                                        <div class="col-md-6">

                                            @php
                                                $productCost = 0;
                                                $shipCost = 0;
                                                $taxCost = 0;
                                                $totalCost = 0;
                                            @endphp
                                            @for ($i = 0; $i < count($data['getCart']); $i++)
                                                @php
                                                    $productCost += $data['getCart'][$i]->price * $data['getCart'][$i]->quantity;
                                                    $shipCost += $data['getCart'][$i]->shippingFee;
                                                    $taxCost += $data['getCart'][$i]->taxFee * $data['getCart'][$i]->quantity;
                                                    
                                                @endphp
                                            @endfor

                                            <table class="table table-hover">
                                                <tbody>
                                                    <tr>
                                                        <td>Product Cost</td>
                                                        <td><b>{{ $data['paymentorg']->currencyCode . ' ' . number_format($productCost, 2) }}</b>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Shipping Fee</td>
                                                        <td><b>{{ $data['paymentorg']->currencyCode . ' ' . number_format($shipCost, 2) }}</b>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tax</td>

                                                        <td><b>{{ $data['paymentorg']->currencyCode . ' ' . number_format($taxCost, 2) }}</b>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="2" align="center">

                                                            @php
                                                                $totalCost = $productCost + $shipCost + $taxCost;
                                                            @endphp
                                                            <h4><img
                                                                    src="https://img.icons8.com/nolan/25/shopping-cart-promotion.png" />
                                                                {{ $data['paymentorg']->currencyCode . ' ' . number_format($totalCost, 2) }}

                                                            </h4>
                                                            <small class="processFee disp-0">

                                                            </small>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>



                                        </div>
                                    </div>
                                </div>


                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="haveAccount" data-toggle="tab"
                                            data-target="#home" type="button" role="tab" aria-controls="home"
                                            aria-selected="true" onclick="setCardType('Wallet')"><img
                                                src="https://res.cloudinary.com/pilstech/image/upload/v1602675914/paysprint_icon_png_ol2z3u.png"
                                                style="width:25px; height: 25px;" />
                                            I have a PaySprint Wallet</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="dontHaveAccount" data-toggle="tab"
                                            data-target="#profile" type="button" role="tab" aria-controls="profile"
                                            aria-selected="false" onclick="setCardType('Debit Card')">

                                            <img src="https://img.icons8.com/color/25/000000/mastercard-logo.png" /> I
                                            do not
                                            have a PaySprint Wallet</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="createAccount" data-toggle="tab"
                                            data-target="#contact" type="button" role="tab" aria-controls="contact"
                                            aria-selected="false"><img
                                                src="https://img.icons8.com/external-ui-website-adri-ansyah/25/000000/external-create-basic-ui-ui-website-adri-ansyah.png" />
                                            Create a PaySprint Wallet</button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="home" role="tabpanel"
                                        aria-labelledby="haveAccount">


                                        <div class="card">
                                            <div class="card-body">
                                                <div class="mt-3">
                                                    <form action="#" method="post" id="forCustomers">
                                                        @csrf

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
                                                                    placeholder="6921229" required>

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
                                                                <input type="text" name="amount" class="form-control"
                                                                    id="amount"
                                                                    value="{{ sprintf('%.2f', $totalCost) }}"
                                                                    placeholder="0.00" readonly>
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
                                                                    id="conversionamount" value="" placeholder="0.00"
                                                                    readonly>
                                                            </div>
                                                        </div>

                                                        <div class="form-group"> <label for="commissiondeduct">
                                                                <h6>Fee Charge</h6>
                                                            </label>
                                                            <div class="input-group">
                                                                <input type="text" name="commissiondeduct"
                                                                    class="form-control commissiondeduct"
                                                                    id="commissiondeduct" value="" placeholder="0.00"
                                                                    readonly>

                                                                <input type="hidden" name="totalcharge"
                                                                    class="form-control" id="totalcharge" value=""
                                                                    placeholder="0.00" readonly>

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
                                                                <input type="text" name="purpose" class="form-control"
                                                                    id="purpose"
                                                                    value="Purchase of {{ count($data['getCart']) }} items from {{ $data['paymentorg']->businessname }}"
                                                                    readonly>
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

                                                            <button type="button" onclick="payForOrder()"
                                                                class="subscribe btn btn-primary btn-block shadow-sm sendmoneyBtn">
                                                                Make Payment </button>
                                                        </div>

                                                    </form>
                                                </div>
                                            </div>
                                        </div>





                                    </div>
                                    <div class="tab-pane fade" id="profile" role="tabpanel"
                                        aria-labelledby="dontHaveAccount">


                                        <div class="card">
                                            <div class="card-body">
                                                <div class="mt-3">
                                                    <form action="#" method="post" id="forVisitors">
                                                        @csrf

                                                        <div class="form-group"> <label for="firstname">
                                                                <h6><span style="color: red;">*</span> Please enter your
                                                                    First Name</h6>
                                                            </label>
                                                            <div class="input-group">

                                                                <div class="input-group-append"> <span
                                                                        class="input-group-text text-muted">
                                                                        <img
                                                                            src="https://img.icons8.com/stickers/25/000000/user.png" /></span>
                                                                </div> <input type="text" name="firstname"
                                                                    id="firstname" class="form-control"
                                                                    placeholder="First Name:" required>

                                                                <input type="hidden" name="route" value="estore">
                                                                <input type="hidden" name="accountNumber"
                                                                    value="{{ Auth::user()->ref_code }}">
                                                                <input type="hidden" name="mode"
                                                                    value="{{ env('APP_ENV') == 'local' ? 'test' : 'live' }}">
                                                                <input type="hidden" name="paymentToken"
                                                                    class="form-control" id="paymentToken" value=""
                                                                    readonly>
                                                            </div>
                                                        </div>

                                                        <div class="form-group"> <label for="lastname">
                                                                <h6><span style="color: red;">*</span> Please enter your
                                                                    Last Name</h6>
                                                            </label>
                                                            <div class="input-group">

                                                                <div class="input-group-append"> <span
                                                                        class="input-group-text text-muted">
                                                                        <img
                                                                            src="https://img.icons8.com/stickers/25/000000/user.png" /></span>
                                                                </div> <input type="text" name="lastname" id="lastname"
                                                                    class="form-control" placeholder="Last Name:"
                                                                    required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group"> <label for="email">
                                                                <h6><span style="color: red;">*</span> Email Address
                                                                </h6>
                                                            </label>
                                                            <div class="input-group">

                                                                <div class="input-group-append"> <span
                                                                        class="input-group-text text-muted">
                                                                        <img
                                                                            src="https://img.icons8.com/color/25/000000/email-sign.png" /></span>
                                                                </div> <input type="email" name="email" id="email"
                                                                    class="form-control" placeholder="Email Address:"
                                                                    required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group"> <label for="phone">
                                                                <h6><span style="color: red;">*</span> Phone Number</h6>
                                                            </label>
                                                            <div class="input-group">

                                                                <div class="input-group-append"> <span
                                                                        class="input-group-text text-muted">
                                                                        <img
                                                                            src="https://img.icons8.com/external-icongeek26-flat-icongeek26/25/000000/external-phone-essentials-icongeek26-flat-icongeek26.png" /></span>
                                                                </div> <input type="text" name="phone" id="phone"
                                                                    class="form-control" placeholder="Phone Number:"
                                                                    required>
                                                            </div>
                                                        </div>



                                                        <div
                                                            class="form-group @if ($data['currencyCode']->currencyCode != $data['paymentorg']->currencyCode) disp-0 @endif ">
                                                            <label for="amount">
                                                                <h6><span style="color: red;">*</span>Amount</h6>
                                                            </label>
                                                            <div class="input-group">

                                                                <div class="input-group-append"> <span
                                                                        class="input-group-text text-muted">
                                                                        {{ $data['currencyCode']->currencySymbol }}</span>
                                                                </div>
                                                                <input type="text" name="amount" class="form-control"
                                                                    id="amounttosend"
                                                                    value="{{ sprintf('%.2f', $totalCost) }}"
                                                                    placeholder="0.00" readonly>

                                                                <input type="hidden" name="conversionamount"
                                                                    class="form-control" id="conversionamount"
                                                                    value="" placeholder="0.00" readonly>
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
                                                                    id="conversionamount" value="" placeholder="0.00"
                                                                    readonly>
                                                            </div>
                                                        </div>


                                                        <div class="form-group disp-0"> <label for="commissiondeduct">
                                                                <h6>Fee Charge</h6>
                                                            </label>
                                                            <div class="input-group">
                                                                <input type="text" name="commissiondeduct"
                                                                    class="form-control commissiondeduct"
                                                                    id="commissiondeduct" value="" placeholder="0.00"
                                                                    readonly>

                                                                <input type="hidden" name="totalcharge"
                                                                    class="form-control" id="totalcharge" value=""
                                                                    placeholder="0.00" readonly>

                                                            </div>
                                                        </div>


                                                        <div class="form-group"> <label for="country">
                                                                <h6><span style="color: red;">*</span> Country</h6>
                                                            </label>
                                                            <div class="input-group">

                                                                <div class="input-group-append"> <span
                                                                        class="input-group-text text-muted">
                                                                        <img
                                                                            src="https://img.icons8.com/external-flat-icons-inmotus-design/25/000000/external-country-globe-geography-flat-icons-inmotus-design.png" /></span>
                                                                </div>
                                                                <select name="country" id="country"
                                                                    class="form-control" required>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group"> <label for="state">
                                                                <h6><span style="color: red;">*</span> State/Province
                                                                </h6>
                                                            </label>
                                                            <div class="input-group">

                                                                <div class="input-group-append"> <span
                                                                        class="input-group-text text-muted">
                                                                        <img
                                                                            src="https://img.icons8.com/external-flat-icons-inmotus-design/25/000000/external-country-globe-geography-flat-icons-inmotus-design.png" /></span>
                                                                </div>
                                                                <select name="state" id="state" class="form-control"
                                                                    required>
                                                                </select>
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
                                                                    class="form-control" id="purpose"
                                                                    value="Purchase of {{ count($data['getCart']) }} items from {{ $data['paymentorg']->businessname }}"
                                                                    readonly>
                                                            </div>
                                                        </div>



                                                        {{-- Condition Payment Gateway --}}

                                                        @if ($data['paymentgateway']->gateway == 'Moneris')
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group"> <label for="cardType">
                                                                            <h6><span style="color: red;">*</span>
                                                                                Select
                                                                                Card Type
                                                                            </h6>
                                                                        </label>
                                                                        <div class="input-group">

                                                                            <div class="input-group-append"> <span
                                                                                    class="input-group-text text-muted">
                                                                                    <img
                                                                                        src="https://img.icons8.com/office/25/000000/mastercard-credit-card.png" /></span>
                                                                            </div>
                                                                            <select name="cardType" id="cardType"
                                                                                class="form-control" required>
                                                                                <option value="">Select Card Type
                                                                                </option>
                                                                                <option value="Credit Card">Credit Card
                                                                                </option>
                                                                                <option value="Debit Card">Debit Card
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group"> <label
                                                                            for="cardNumber">
                                                                            <h6><span style="color: red;">*</span> Card
                                                                                Number
                                                                            </h6>
                                                                        </label>
                                                                        <div class="input-group">

                                                                            <div class="input-group-append"> <span
                                                                                    class="input-group-text text-muted">
                                                                                    <img
                                                                                        src="https://img.icons8.com/external-prettycons-flat-prettycons/25/000000/external-payment-method-shopping-prettycons-flat-prettycons.png" /></span>
                                                                            </div>
                                                                            <input type="number" name="cardNumber"
                                                                                class="form-control" id="cardNumber"
                                                                                value="" placeholder="5411331234212345">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group"> <label
                                                                            for="cardMonth">
                                                                            <h6><span style="color: red;">*</span> Month
                                                                            </h6>
                                                                        </label>
                                                                        <div class="input-group">

                                                                            <div class="input-group-append"> <span
                                                                                    class="input-group-text text-muted">
                                                                                    <img
                                                                                        src="https://img.icons8.com/external-flaticons-flat-flat-icons/25/000000/external-month-morning-flaticons-flat-flat-icons-2.png" /></span>
                                                                            </div>
                                                                            <input type="number" name="cardMonth"
                                                                                class="form-control" id="cardMonth"
                                                                                value="" placeholder="Expiry Month:"
                                                                                min="01" step="01">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group"> <label for="cardYear">
                                                                            <h6><span style="color: red;">*</span> Card
                                                                                Year
                                                                            </h6>
                                                                        </label>
                                                                        <div class="input-group">

                                                                            <div class="input-group-append"> <span
                                                                                    class="input-group-text text-muted">
                                                                                    <img
                                                                                        src="https://img.icons8.com/external-flaticons-flat-flat-icons/25/000000/external-year-morning-flaticons-flat-flat-icons.png" /></span>
                                                                            </div>
                                                                            <input type="number" name="cardYear"
                                                                                class="form-control" id="cardYear"
                                                                                value="" placeholder="Expiry Year:"
                                                                                min="01" step="01">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif

                                                        @if ($data['paymentgateway']->gateway == 'Stripe')
                                                            <div class="form-group"> <label for="card-elemet">
                                                                    <h6>Card Detail</h6>
                                                                </label>
                                                                <div id="card-element"></div>
                                                            </div>
                                                        @endif




                                                        <div class="form-group">
                                                            <div class="commissionInfo"></div>
                                                        </div>


                                                        <div class="form-group disp-0">
                                                            <div class="input-group">
                                                                <p style="color: red; font-weight: bold;"><input
                                                                        type="checkbox" name="commission"
                                                                        id="commission" checked="checked"> Include fee
                                                                </p>

                                                            </div>
                                                        </div>


                                                        @if ($data['paymentgateway']->gateway == 'PayStack' || $data['paymentgateway']->gateway == 'Express Payment Solution')
                                                            <div class="form-group mt-4">

                                                                <button type="button" onclick="estoreWithEPS()"
                                                                    class="subscribe btn btn-primary btn-block shadow-sm sendmoneyBtn">
                                                                    Make Payment </button>
                                                            </div>
                                                        @elseif($data['paymentgateway']->gateway == 'Stripe')
                                                            <div class="form-group mt-4">

                                                                <button type="submit"
                                                                    class="subscribe btn btn-primary btn-block shadow-sm sendmoneyBtn">
                                                                    Make Payment </button>
                                                            </div>
                                                        @elseif($data['paymentgateway']->gateway == 'PayPal')
                                                            {{-- PayPal --}}
                                                            <div class="card-footer" id="paypal-button-container">
                                                            </div>
                                                        @else
                                                            <div class="form-group mt-4">

                                                                <button type="button"
                                                                    onclick="handShake('estore_payment')"
                                                                    class="subscribe btn btn-primary btn-block shadow-sm sendmoneyBtn">
                                                                    Make Payment </button>
                                                            </div>
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
                                                                    <img src="https://res.cloudinary.com/pilstech/image/upload/v1620148943/paysprint_asset/l6-download-gplay_o9rcfj.png"
                                                                        alt="play store" width="100%">
                                                                </a>
                                                                <a href="https://apps.apple.com/gb/app/paysprint/id1567742130"
                                                                    target="_blank"
                                                                    class="btn text-white gr-hover-y px-lg-9">
                                                                    <img src="https://res.cloudinary.com/pilstech/image/upload/v1620148943/paysprint_asset/l6-download-appstore_odcskf.png"
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
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

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
                    formData.append('currencyCode', `{{ Auth::user()->currencyCode }}`);

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
                                                    'estore_payment'
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
                                handShake('estore_payment');
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

            runCommission();


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


        async function handShake(val) {

            try {

                $('.sendmoneyBtn').text('Processing...');

                var data = new FormData(forVisitors);
                var headers = {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    'Authorization': 'Bearer {{ $data['merchantApiKey'] }}'
                };

                const config = {
                    method: 'POST',
                    url: "{{ URL('/api/v1/visitors-payment') }}",
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




        function runCommission() {

            $('.commissionInfo').html("");
            $(".convertedCommission").html("");
            var amount = $("#amounttosend").val();
            // var amount = $("#conversionamount").val();
            var card_type = $('#cardType').val();


            var route = "{{ URL('Ajax/getCommission') }}";
            var thisdata = {
                check: $('#commission').prop("checked"),
                amount: amount,
                pay_method: card_type,
                localcurrency: "{{ $data['paymentorg']->currencyCode }}",
                foreigncurrency: "USD",
                structure: "Add Funds/Money",
                structureMethod: card_type
            };




            Pace.restart();
            Pace.track(function() {

                mainHeaders();

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


                            } else {
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

        async function estoreWithEPS() {

            $('.sendmoneyBtn').text('Please wait...');

            try {


                var callbackUrl;

                var netamount = $('#conversionamount').val();
                var feeamount = $('.commissiondeduct').val();
                var amount = (+netamount + +feeamount).toFixed(2);
                var paymentToken = 'estore_' + Math.floor((Math.random() * 1000000000) + 1);
                var publicKey =
                    `{{ env('APP_ENV') == 'local' ? env('EPXRESS_PAYMENT_KEY_DEV') : env('EPXRESS_PAYMENT_KEY_PROD') }}`;
                var commission = $('#commission').val();
                var currencyCode = `{{ $data['paymentorg']->currencyCode }}`;
                var conversionamount = $('#conversionamount').val();
                var purpose = $('#purpose').val();
                var api_token = `{{ $data['merchantApiKey'] }}`;
                var customername = $('#firstname').val() + ' ' + $('#lastname').val();
                var country = `{{ request()->get('country') }}`;
                var phone = $('#phone').val();


                if (`{{ env('APP_ENV') }}` != "local") {
                    callbackUrl =
                        `{{ env('APP_URL') }}/expresspay/estoreresp?paymentToken=${paymentToken}&commission=${commission}&amount=${amount}&commissiondeduct=${feeamount}&currencyCode=${currencyCode}&conversionamount=${conversionamount}&amounttosend=${netamount}&api_token=${api_token}&purpose=${purpose}$name=${customername}&country=${country}&phone=${phone}`;
                } else {
                    callbackUrl =
                        `http://localhost:9090/expresspay/estoreresp?paymentToken=${paymentToken}&commission=${commission}&amount=${amount}&commissiondeduct=${feeamount}&currencyCode=${currencyCode}&conversionamount=${conversionamount}&amounttosend=${netamount}&api_token=${api_token}&purpose=${purpose}$name=${customername}&country=${country}&phone=${phone}`;
                }

                var productId = "{{ $data['paymentorg']->ref_code }}";
                var description = "Transfer {{ $data['paymentorg']->currencyCode }}" + netamount +
                    " for " + $('#purpose').val() + " " +
                    feeamount + " inclusive.";

                var data = JSON.stringify({
                    "amount": amount,
                    "transactionId": paymentToken,
                    "email": $('#email').val(),
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
                    "footerLogo": "https://res.cloudinary.com/pilstech/image/upload/v1603726392/pay_sprint_black_horizotal_fwqo6q.png",
                    "metadata": [{
                        "name": "name",
                        "value": customername
                    }, {
                        "name": "description",
                        "value": description
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

                const response = await axios(config);

                console.log(response);

                $('.sendmoneyBtn').text('Make Payment');




                setTimeout(() => {
                    location.href = response.data.data.paymentUrl;
                }, 1000);



            } catch (error) {

                $('.sendmoneyBtn').text('Make Payment');


                if (error.response) {
                    swal('Oops!', error.response.data.responseMessage, 'error');
                } else {
                    swal('Oops!', error.message, 'error');
                }


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
    </script>


</body>

</html>
