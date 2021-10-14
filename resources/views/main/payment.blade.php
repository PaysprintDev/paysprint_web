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
    <link rel="icon" href="https://res.cloudinary.com/pilstech/image/upload/v1602675914/paysprint_icon_png_ol2z3u.png"
        type="image/x-icon" />

    <link rel="stylesheet" type="text/css" href="{{ asset('pace/themes/orange/pace-theme-flash.css') }}" />

    <script src="https://kit.fontawesome.com/384ade21a6.js"></script>

    <title>PaySprint | Payment</title>

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
                <h1 class="display-4">PaySprint Payment</h1>
            </div>
        </div> <!-- End -->
        <div class="row">
            <div class="col-lg-6 mx-auto">
                <div class="card ">
                    <div class="card-header">
                        <div class="bg-white shadow-sm pt-4 pl-2 pr-2 pb-2">
                            <!-- Credit card form tabs -->
                            <ul role="tablist" class="nav bg-light nav-pills rounded nav-fill mb-3">
                                <li class="nav-item" onclick="location.href='{{ route('invoice') }}'"> <a
                                        data-toggle="pill" href="{{ route('invoice') }}" class="nav-link active "> <i
                                            class="fas fa-home"></i> Go Back </a> </li>
                                {{-- <li class="nav-item"> <a data-toggle="pill" href="#credit-card" class="nav-link active "> <i class="fas fa-credit-card mr-2"></i> Be Payment Ready... </a> </li> --}}

                                {{-- <li class="nav-item"> <a data-toggle="pill" href="#paypal" class="nav-link "> <i class="fab fa-paypal mr-2"></i> Debit Card </a> </li>
                                <li class="nav-item"> <a data-toggle="pill" href="#net-banking" class="nav-link "> <i class="fas fa-mobile-alt mr-2"></i> EXBC Card </a> </li> --}}
                            </ul>
                        </div> <!-- End -->
                        <!-- Credit card form content -->
                        <div class="tab-content">

                            @if (count($data['getinvoice']) > 0)

                                @if ($merchant = \App\User::where('ref_code', $data['getinvoice'][0]->uploaded_by)->first())

                                    @if ($data['getinvoice'][0]->invoiced_currency != null)
                                        @php
                                            $currencySymb = $data['getinvoice'][0]->invoiced_currency_symbol;
                                            $currencycod = $data['getinvoice'][0]->invoiced_currency;
                                        @endphp

                                    @else

                                        @php
                                            $currencySymb = $merchant->currencySymbol;
                                            $currencycod = $merchant->currencyCode;
                                        @endphp

                                    @endif

                                    @php
                                        $countryBase = $merchant->country;
                                    @endphp

                                @else

                                    @php
                                        $currencySymb = $data['currencyCode']->currencySymbol;
                                        $currencycod = $data['currencyCode']->currencyCode;
                                        $countryBase = Auth::user()->country;
                                    @endphp

                                @endif


                                <!-- credit card info-->
                                <div id="credit-card" class="tab-pane fade show active pt-3">
                                    {{-- <form role="form" action="{{ route('PaymentInvoice') }}" method="POST" id="paymentForm"> --}}
                                    <form role="form" action="#" method="POST" id="formElem">
                                        @csrf
                                        <input type="hidden" name="invoice_no" id="payinvoiceRef"
                                            value="{{ $data['getinvoice'][0]->invoice_no }}">
                                        {{-- <input type="hidden" name="amount" id="payamount" value="{{ number_format($data['getinvoice'][0]->amount, 2) }}"> --}}
                                        <input type="hidden" name="invoice_balance"
                                            value="{{ $data['getinvoice'][0]->remaining_balance }}">
                                        <input type="hidden" name="merchant_id" id="payuser_id"
                                            value="{{ $data['getinvoice'][0]->uploaded_by }}">
                                        <input type="hidden" name="email" id="payemail" value="{{ $email }}">
                                        <input type="hidden" name="service" id="payservice"
                                            value="{{ $data['getinvoice'][0]->service }}">

                                        <div class="form-group">
                                            <div class="alert alert-info">
                                                <ul>
                                                    <li>
                                                        Transaction Reference Number:
                                                        <b>{{ $data['getinvoice'][0]->payee_ref_no }}</b>
                                                    </li>
                                                    <li>
                                                        Invoice Number:
                                                        <b>{{ $data['getinvoice'][0]->invoice_no }}</b>
                                                    </li>
                                                    <li>
                                                        Invoice Amount:
                                                        <b>{{ $currencySymb . '' . number_format($data['getinvoice'][0]->amount, 2) }}</b>
                                                    </li>
                                                    <li>
                                                        Tax Amount:
                                                        <b>{{ $currencySymb . '' . number_format($data['getinvoice'][0]->tax_amount, 2) }}</b>
                                                    </li>
                                                    <li>
                                                        Total Amount:
                                                        <b>{{ $currencySymb . '' . number_format($data['getinvoice'][0]->total_amount, 2) }}</b>
                                                    </li>

                                                    <li>
                                                        Invoice Balance:
                                                        <b>{{ $currencySymb . '' . number_format($data['getinvoice'][0]->remaining_balance, 2) }}</b>
                                                    </li>
                                                    <li>
                                                        Service: <b>{{ $data['getinvoice'][0]->service }}</b>
                                                    </li>
                                                </ul>
                                            </div>

                                            @if (isset($data['getinvoice'][0]->installpay))


                                                @if ($data['getinvoice'][0]->installpay == 'Yes' && $data['getinvoice'][0]->installlimit == $data['getinvoice'][0]->installcount)

                                                    <div class='alert alert-danger'>You can not pay installmentally on
                                                        this invoice as you have exceeded the limit</div>

                                                @endif

                                            @endif

                                            <div class="alert alert-warning">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h4>
                                                            Wallet Balance
                                                        </h4>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <h4>
                                                            {{ $data['currencyCode']->currencySymbol . '' . number_format(Auth::user()->wallet_balance, 2) }}
                                                        </h4>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>


                                        <div class="form-group disp-0"> <label for="name">
                                                <h6>Card Owner</h6>
                                            </label> <input type="text" name="name" id="payname"
                                                placeholder="Card Owner Name" required class="form-control"
                                                value="{{ $name }}" readonly>
                                        </div>

                                        <div class="form-group disp-0"> <label for="make_payment_method">
                                                <h6>Payment Method</h6>
                                            </label>
                                            <div class="input-group">
                                                <select name="payment_method" id="make_payment_method"
                                                    class="form-control" required>
                                                    <option value="Wallet">Wallet</option>
                                                    {{-- <option value="EXBC Card">EXBC Card</option> --}}
                                                </select>

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


                                        @if ($countryBase != Auth::user()->country)


                                            <div class="form-group converter"> <label for="netwmount">
                                                    <h6>Currency Conversion <br><small
                                                            class="text-info"><b>Exchange rate </b> <br> <span
                                                                id="rateToday"></span> </small></h6>
                                                    {{-- <p style="font-weight: bold;">
                                                {{ $data['currencyCode']->currencyCode }} <=> {{ $data['othercurrencyCode']->currencyCode }}
                                            </p> --}}

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


                                            <div class="form-group"> <label for="currency">
                                                    <h6>Amount Invoiced</h6>
                                                </label>

                                                @php
                                                    if ($data['remaining_invoice'] > 0) {
                                                        $amountInvoiced = $data['remaining_invoice'];
                                                        $merchantPay = $data['getinvoice'][0]->remaining_balance;
                                                    } else {
                                                        $amountInvoiced = $data['total_invoice'] + $data['remaining_invoice'];
                                                        $merchantPay = $data['getinvoice'][0]->total_amount + $data['getinvoice'][0]->remaining_balance;
                                                    }
                                                @endphp





                                                <input type="hidden"
                                                    value="{{ $data['currencyCode']->currencyCode }}"
                                                    name="currencyCode">
                                                <input type="hidden" value="{{ $merchantPay }}" name="merchantpay">
                                                <div class="input-group"> <span class="input-group-text text-muted">
                                                        {{ $data['currencyCode']->currencySymbol }} </span> <input
                                                        type="number" min="0.00" step="0.01" name="amountinvoiced"
                                                        id="amountinvoiced" placeholder="50.00" class="form-control"
                                                        value="{{ $amountInvoiced }}" readonly>
                                                    <div class="input-group-append"> </div>
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


                                            <div class="form-group"> <label for="currency">
                                                    <h6>Amount Invoiced</h6>
                                                </label>

                                                @php
                                                    if ($data['getinvoice'][0]->remaining_balance > 0) {
                                                        $amountInvoiced = $data['getinvoice'][0]->remaining_balance;
                                                    } else {
                                                        $amountInvoiced = $data['getinvoice'][0]->total_amount + $data['getinvoice'][0]->remaining_balance;
                                                    }
                                                @endphp

                                                <input type="hidden"
                                                    value="{{ $data['currencyCode']->currencyCode }}"
                                                    name="currencyCode">
                                                <div class="input-group"> <span class="input-group-text text-muted">
                                                        {{ $data['currencyCode']->currencySymbol }} </span> <input
                                                        type="number" min="0.00" step="0.01" name="amountinvoiced"
                                                        id="amountinvoiced" placeholder="50.00" class="form-control"
                                                        value="{{ $amountInvoiced }}" readonly>
                                                    <div class="input-group-append"> </div>
                                                </div>
                                            </div>

                                        @endif



                                        @if ($countryBase == Auth::user()->country)


                                            <div class="form-group disp-0">
                                                <div class="input-group">
                                                    <p style="color: red; font-weight: bold;"><input type="checkbox"
                                                            checked name="convertRate" id="convertRate"> Accept
                                                        conversion rate</p>

                                                </div>
                                            </div>

                                            @if ($data['getinvoice'][0]->installpay == 'Yes')

                                                @if ($data['getinvoice'][0]->installlimit > $data['getinvoice'][0]->installcount)

                                                    <div class="form-group"> <label for="currency">
                                                            <h6>Do you want to pay intallmentally?</h6>
                                                        </label>
                                                        <div class="input-group"> <span
                                                                class="input-group-text text-muted"> <img
                                                                    src="https://img.icons8.com/office/16/000000/circled-dot.png" />
                                                            </span>
                                                            <select name="payInstallment" id="pay_installment"
                                                                class="form-control">
                                                                <option value="Yes">Yes</option>
                                                                <option value="No" selected>No</option>
                                                            </select>
                                                            <div class="input-group-append"> </div>
                                                        </div>
                                                    </div>


                                                    <div class="form-group topay disp-0"> <label for="currency">
                                                            <h6>Amount to Pay</h6>
                                                        </label>
                                                        <input type="hidden"
                                                            value="{{ $data['currencyCode']->currencyCode }}"
                                                            name="currencyCode">
                                                        <div class="input-group"> <span
                                                                class="input-group-text text-muted">
                                                                {{ $data['currencyCode']->currencySymbol }} </span>
                                                            <input type="number" min="0.00" step="0.01" name="amount"
                                                                id="typepayamount" placeholder="50.00"
                                                                class="form-control" value="{{ $amountInvoiced }}">
                                                            <div class="input-group-append"> </div>
                                                        </div>
                                                    </div>

                                                @else

                                                    <div class="form-group disp-0"> <label for="currency">
                                                            <h6>Do you want to pay intallmentally?</h6>
                                                        </label>
                                                        <div class="input-group"> <span
                                                                class="input-group-text text-muted"> <img
                                                                    src="https://img.icons8.com/office/16/000000/circled-dot.png" />
                                                            </span>
                                                            <select name="payInstallment" id="pay_installment"
                                                                class="form-control">
                                                                <option value="Yes">Yes</option>
                                                                <option value="No" selected>No</option>
                                                            </select>
                                                            <div class="input-group-append"> </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group topay disp-0"> <label for="currency">
                                                            <h6>Amount to Pay</h6>
                                                        </label>
                                                        <input type="hidden"
                                                            value="{{ $data['currencyCode']->currencyCode }}"
                                                            name="currencyCode">
                                                        <div class="input-group"> <span
                                                                class="input-group-text text-muted">
                                                                {{ $data['currencyCode']->currencySymbol }} </span>
                                                            <input type="number" min="0.00" step="0.01" name="amount"
                                                                id="typepayamount" placeholder="50.00"
                                                                class="form-control" value="{{ $amountInvoiced }}">
                                                            <div class="input-group-append"> </div>
                                                        </div>
                                                    </div>

                                                @endif

                                                {{-- @if ($data['getinvoice'][0]->installpay == 'Yes' && $data['getinvoice'][0]->installlimit == $data['getinvoice'][0]->installcount) --}}

                                            @else






                                                <div class="form-group disp-0"> <label for="currency">
                                                        <h6>Do you want to pay intallmentally?</h6>
                                                    </label>
                                                    <div class="input-group"> <span
                                                            class="input-group-text text-muted"> <img
                                                                src="https://img.icons8.com/office/16/000000/circled-dot.png" />
                                                        </span>
                                                        <select name="payInstallment" id="pay_installment"
                                                            class="form-control">
                                                            <option value="Yes">Yes</option>
                                                            <option value="No" selected>No</option>
                                                        </select>
                                                        <div class="input-group-append"> </div>
                                                    </div>
                                                </div>


                                                <div class="form-group topay disp-0"> <label for="currency">
                                                        <h6>Amount to Pay</h6>
                                                    </label>
                                                    <input type="hidden"
                                                        value="{{ $data['currencyCode']->currencyCode }}"
                                                        name="currencyCode">
                                                    <div class="input-group"> <span
                                                            class="input-group-text text-muted">
                                                            {{ $data['currencyCode']->currencySymbol }} </span>
                                                        <input type="number" min="0.00" step="0.01" name="amount"
                                                            id="typepayamount" placeholder="50.00"
                                                            class="form-control" value="{{ $amountInvoiced }}">
                                                        <div class="input-group-append"> </div>
                                                    </div>
                                                </div>


                                            @endif

                                        @else

                                            <div class="form-group disp-0"> <label for="currency">
                                                    <h6>Do you want to pay intallmentally?</h6>
                                                </label>
                                                <div class="input-group"> <span class="input-group-text text-muted">
                                                        <img
                                                            src="https://img.icons8.com/office/16/000000/circled-dot.png" />
                                                    </span>
                                                    <select name="payInstallment" id="pay_installment"
                                                        class="form-control">
                                                        <option value="Yes">Yes</option>
                                                        <option value="No" selected>No</option>
                                                    </select>
                                                    <div class="input-group-append"> </div>
                                                </div>
                                            </div>


                                            <div class="form-group topay disp-0"> <label for="currency">
                                                    <h6>Amount to Pay</h6>
                                                </label>
                                                <input type="hidden"
                                                    value="{{ $data['currencyCode']->currencyCode }}"
                                                    name="currencyCode">
                                                <div class="input-group"> <span class="input-group-text text-muted">
                                                        {{ $data['currencyCode']->currencySymbol }} </span> <input
                                                        type="number" min="0.00" step="0.01" name="amount"
                                                        id="typepayamount" placeholder="50.00" class="form-control"
                                                        value="{{ $amountInvoiced }}">
                                                    <div class="input-group-append"> </div>
                                                </div>
                                            </div>


                                        @endif



                                        <hr>

                                        <div class="form-group"> <label for="transaction_pin">
                                                <h6>Transaction Pin</h6>
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-append"> <span
                                                        class="input-group-text text-muted"> <i
                                                            class="fas fa-lock"></i> </span> </div> <input
                                                    type="password" name="transaction_pin" id="transaction_pin"
                                                    class="form-control" maxlength="4" required>

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <strong><span class="text-danger wallet-info"></span></strong>
                                        </div>

                                        <div class="form-group">
                                            <div class="commissionInfo"></div>
                                        </div>

                                        <div class="form-group disp-0"> <label for="paycreditcard">
                                                <h6>Card number</h6>
                                            </label>
                                            <div class="input-group"> <input type="number" name="creditcard_no"
                                                    id="paycreditcard" placeholder="5199 - 3924 - 2100 - 5430"
                                                    class="form-control" maxlength="16" required>
                                                <div class="input-group-append"> <span
                                                        class="input-group-text text-muted"> <i
                                                            class="fab fa-cc-visa mx-1"></i> <i
                                                            class="fab fa-cc-mastercard mx-1"></i> <i
                                                            class="fab fa-cc-amex mx-1"></i> </span> </div>
                                            </div>
                                        </div>
                                        <div class="row disp-0">
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
                                                        <select name='expirydate' id="payyear" class='form-control'>
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
                                        {{-- onclick="monerisPay()" --}}

                                        <div class="card-footer"> <button type="button"
                                                onclick="handShake('payinvoice')"
                                                class="subscribe btn btn-primary btn-block shadow-sm sendmoneyBtn"> Pay
                                                Invoice </button></div>

                                        {{-- @if (Auth::user()->approval == 2 && Auth::user()->accountLevel == 3)
                                        <div class="card-footer"> <button type="button" onclick="handShake('payinvoice')" class="subscribe btn btn-primary btn-block shadow-sm sendmoneyBtn"> Pay Invoice </button></div>
                                    @else
                                        <div class="card-footer"> <button type="button" onclick="restriction('payinvoice', '{{ Auth::user()->name }}')" class="subscribe btn btn-primary btn-block shadow-sm sendmoneyBtn"> Pay Invoice </button></div>
                                    @endif --}}



                                    </form>
                                </div>

                            @else


                                <div class="alert alert-danger">
                                    No record for this invoice number
                                </div>

                            @endif

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

        <script src="{{ asset('pace/pace.min.js') }}"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

        <script>
            $(function() {
                $('[data-toggle="tooltip"]').tooltip();

                if ($("#typepayamount").val() != "") {
                    runCommission();
                }

                $("#typepayamount").on("keyup", function() {
                    runCommission();
                });



                currencyConvert();


            })




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


            $("#pay_installment").change(function() {

                var amount = $("#amountinvoiced").val();

                if ($("#pay_installment").val() == "Yes") {
                    $('.topay').removeClass('disp-0');
                } else {
                    $("#typepayamount").val(amount);
                    runCommission();
                    $('.topay').addClass('disp-0');
                }
            });


            function currencyConvert() {



                var today = new Date();
                var dd = String(today.getDate()).padStart(2, '0');
                var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
                var yyyy = today.getFullYear();

                today = dd + '/' + mm + '/' + yyyy;

                var amount = "{{ $amountInvoiced }}";
                var currency = "{{ $currencycod }}";
                var currencySymb = "{{ $currencySymb }}";
                var localcurrency = "{{ $data['currencyCode']->currencyCode }}";
                var route = "{{ URL('Ajax/getconversion') }}";
                var merchantcountry = "{{ $countryBase }}";
                var country = "{{ Auth::user()->country }}";
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

                        // localcurrency != currency

                        if (merchantcountry != country) {
                            $('.converter').removeClass('disp-0');
                        } else {
                            $('.converter').addClass('disp-0');

                        }

                        $('#convertedAmount').text((result.data).toFixed(2));

                        var mycurrentCurrency = $('#typedAmount').text(amount);


                        var todayRate = result.data / amount;

                        // Put Exchange rate
                        $('#rateToday').html("<span class='text-danger'><strong>1" + localcurrency + " == " +
                            todayRate.toFixed(2) + '' + currency + '<br>Today: ' + today + "</strong></span>");


                    }

                });
            }








            function handShake(val) {

                var route;

                var formData = new FormData(formElem);

                if ('payinvoice') {

                    route = "{{ URL('/api/v1/payinvoice') }}";

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

                                $('.sendmoneyBtn').text('Pay Invoice');

                                if (result.status == 200) {
                                    swal("Success", result.message, "success");
                                    setTimeout(function() {
                                        location.href = "{{ route('my account') }}";
                                    }, 2000);
                                } else {
                                    swal("Oops", result.message, "error");
                                }

                            },
                            error: function(err) {
                                $('.sendmoneyBtn').text('Pay Invoice');
                                swal("Oops", err.responseJSON.message, "error");

                            }

                        });
                    });

                }

            }


            function runCommission() {

                $(".sendmoneyBtn").attr("disabled", true);

                $('.commissionInfo').html("");
                var amount = $("#typepayamount").val();

                var route = "{{ URL('Ajax/getwalletBalance') }}";
                var thisdata = {
                    amount: amount,
                    pay_method: $("#make_payment_method").val(),
                    currency: $("#currency").val()
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

                                if (result.walletCheck != "") {
                                    $(".sendmoneyBtn").attr("disabled", true);
                                    checkBoxConfirm();


                                } else {
                                    $(".sendmoneyBtn").attr("disabled", false);
                                    checkBoxConfirm();

                                }

                                $('.commissionInfo').addClass('alert alert-success');
                                $('.commissionInfo').removeClass('alert alert-danger');

                                $('.commissionInfo').html(
                                    "<ul><li><span style='font-weight: bold;'>Kindly note that a total amount of: {{ $data['currencyCode']->currencySymbol }}" +
                                    $("#typepayamount").val() + " will be deducted from your " + $(
                                        '#make_payment_method').val() + ".</span></li></li></ul>");

                            }


                        },
                        error: function(err) {
                            swal("Oops", err.responseJSON.message, "error");
                        }

                    });

                });
            }

            // Moneris Payment
            function monerisPay() {
                var name = $('#payname').val();
                var email = $('#payemail').val();
                var user_id = $('#payuser_id').val();
                var invoice_no = $('#payinvoiceRef').val();
                var service = $('#payservice').val();
                var amount = $('#payamount').val();
                var month = $('#paymonth').val();
                var expirydate = $('#payyear').val();
                var creditcard_no = $('#paycreditcard').val();
                var typepayamount = $('#typepayamount').val();
                var payment_method = $('#make_payment_method').val();

                if (typepayamount > amount) {
                    swal('Oops!', 'Please check your amount value, as this input value is higher', 'info');
                    return false;
                } else if (creditcard_no.length != 16) {
                    swal('Oops!', 'Invalid card number', 'error');
                    return false;
                } else if (payment_method == "") {
                    swal('Oops!', '"Please select payment method"', 'error');
                    return false;
                } else if (creditcard_no == "") {
                    swal('Oops!', '"Please enter card number"', 'error');
                    return false;
                } else {

                    $("#paymentForm").submit();

                }


            }


            function restriction(val, name) {
                if (val == "payinvoice") {
                    swal('Hello ' + name, 'Your account need to be verified before you can pay invoice', 'info');
                }
            }

            //Set CSRF HEADERS
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
