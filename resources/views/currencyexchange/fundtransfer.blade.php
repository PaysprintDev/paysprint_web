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
    <link rel="icon" href="https://res.cloudinary.com/pilstech/image/upload/v1618251695/paysprint_icon_new_kg2h3j.png"
        type="image/x-icon" />

    <link rel="stylesheet" type="text/css" href="{{ asset('pace/themes/orange/pace-theme-flash.css') }}" />
    <script src="https://kit.fontawesome.com/384ade21a6.js"></script>


    @if ($data['mycountry']->gateway == 'Stripe')

        <script src="https://js.stripe.com/v3/"></script>
        <script src="https://polyfill.io/v3/polyfill.min.js?version=3.52.1&features=fetch"></script>

    @endif

    @if ($data['mycountry']->gateway == 'PayPal')

        @if (env('APP_ENV') == 'local')
            <script
                        src="https://www.paypal.com/sdk/js?client-id={{ env('PAYPAL_LOCAL_CLIENT_ID') }}&currency={{ Auth::user()->currencyCode }}">
            </script>

        @else
            <script
                        src="https://www.paypal.com/sdk/js?client-id={{ env('PAYPAL_CLIENT_ID') }}&currency={{ Auth::user()->currencyCode }}">
            </script>

        @endif


    @endif

    <title>PaySprint | {{ $pages }}</title>

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
                <h1 class="display-4">{{ $pages }}</h1>
            </div>
        </div> <!-- End -->
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card ">
                    <div class="card-header">
                        <div class="bg-white shadow-sm pt-4 pl-2 pr-2 pb-2">
                            <!-- Credit card form tabs -->
                            <ul role="tablist" class="nav bg-light nav-pills rounded nav-fill mb-3">
                                <li class="nav-item"> <a data-toggle="pill"
                                        href="{{ route('paysprint currency exchange') }}" class="nav-link active "> <i
                                            class="fas fa-home"></i> Go Back </a> </li>
                            </ul>
                        </div> <!-- End -->
                        <!-- Credit card form content -->
                        <div class="tab-content">


                            <!-- credit card info-->
                            <div id="credit-card" class="tab-pane fade show active pt-3">
                                <form role="form" action="#" method="POST" id="formElem">
                                    @csrf

                                    @php
                                        $refNumber = 'TO-' . date('dmY') . '-' . mt_rand(0000, 9999);
                                    @endphp


                                    <input type="hidden" name="reference_number" value="{{ $refNumber }}">

                                    <div class="form-group"> <label for="fx_wallet">
                                            <h6>Transfer From</h6>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-append"> <span class="input-group-text text-muted">
                                                    <img src="https://img.icons8.com/cotton/20/000000/money--v4.png" />
                                                </span> </div>
                                            <select name="fx_wallet_from" id="fx_wallet_from" class="form-control"
                                                required>
                                                @foreach ($data['mywallet'] as $mywallet)
                                                    <option value="{{ $mywallet->escrow_id }}"
                                                        {{ Request::get('currency') == $mywallet->escrow_id ? 'selected' : '' }}>
                                                        {{ 'Wallet Balance: ' . $mywallet->currencySymbol . $mywallet->wallet_balance . ' | Currency ' . $mywallet->currencyCode }}
                                                    </option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>


                                    <div class="form-group"> <label for="fx_wallet">
                                            <h6>Transfer To</h6>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-append"> <span class="input-group-text text-muted">
                                                    <img
                                                        src="https://img.icons8.com/ios/20/000000/data-in-both-directions.png" />
                                                </span> </div>
                                            <select name="fx_wallet_to" id="fx_wallet_to" class="form-control"
                                                required>

                                            </select>


                                        </div>
                                    </div>


                                    <div class="form-group"> <label for="amount">
                                            <h6>Amount</h6>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-append"> <span
                                                    class="input-group-text text-muted symbolSpace">

                                                </span> </div>
                                            <input type="number" min="0.00" step="0.01" name="amount" id="amount"
                                                class="form-control" placeholder="Amount" value="1.00">
                                        </div>

                                        <p class="text-error text-danger disp-0"><strong>Please type amount to
                                                send!</strong>
                                        </p>
                                    </div>



                                    <div class="form-group converter"> <label for="netwmount">
                                            <h6>Currency Conversion <br><small class="text-info"><b>Exchange rate
                                                    </b> <br> <span id="rateToday"></span> </small></h6>


                                            <table class="table table-bordered table-striped" width="100%">
                                                <tbody>
                                                    <tr style="font-weight: bold;">
                                                        <td id="fromCurrency"></td>
                                                        <td id="toCurrency"></td>
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
                                                    name="convertRate" id="convertRate" onchange="checkBoxConfirm()">
                                                Accept conversion rate</p>

                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <div class="alert alert-info sendingInfo"></div>
                                    </div>



                                    <div class="form-group"> <label for="transaction_pin">
                                            <h6>Transaction Pin</h6>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-append"> <span class="input-group-text text-muted">
                                                    <img
                                                        src="https://img.icons8.com/pastel-glyph/20/000000/lock--v3.png" />
                                                </span> </div>
                                            <input type="password" name="transaction_pin" id="transaction_pin"
                                                class="form-control" placeholder="Transaction Pin">


                                        </div>
                                    </div>





                                    <div class="form-group btnPay">
                                        <div class="row">

                                            <div class="col-md-12 mb-3">
                                                <button type="button" onclick="handShake('transferfxfund')"
                                                    class="btn btn-primary btn-block cardSubmit">Make Transfer</button>
                                            </div>

                                        </div>
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


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js"
                integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous">
        </script>

        <script src="{{ asset('pace/pace.min.js') }}"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script src="https://js.paystack.co/v1/inline.js"></script>





        <script>
            var route;

            var formData;


            $(() => {

                $(".cardSubmit").attr("disabled", true);

                if ($('#fx_wallet_from').val() != "") {
                    // Do Ajax
                    const fromWallet = $('#fx_wallet_from').val();

                    $('.sendingInfo').html("");
                    $('.symbolSpace').text("");
                    // $('#amount').val("");




                    formData = new FormData();

                    formData.append('fromWallet', fromWallet);

                    route = "{{ URL('/api/v1/getotherwallets') }}";



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

                                $('#fx_wallet_to').html(
                                    `<option value=""> Please wait ...</option>`);
                            },
                            success: function(result) {

                                $('#fx_wallet_to').html("");

                                if (result.status == 200) {

                                    var res = result.data;

                                    $('.symbolSpace').text(result.thiswallet);

                                    $.each(res, (v, k) => {

                                        $('#fx_wallet_to').append(
                                            `<option value="${k.escrow_id}"> Wallet Balance: ${k.currencySymbol} ${k.wallet_balance} | Currency ${k.currencyCode}</option>`
                                        );


                                    });

                                    currencyConvert();


                                } else {

                                    $('#fx_wallet_to').html(
                                        `<option value=""> You do not have other wallets</option>`
                                    );
                                }

                            },
                            error: function(err) {
                                swal("Oops", err.responseJSON.message, "error");

                            }

                        });
                    });
                }
            });


            $('#fx_wallet_from').change(function() {


                $('.sendingInfo').html("");
                $('.symbolSpace').text("");
                // $('#amount').val("");
                // Do Ajax
                const fromWallet = $('#fx_wallet_from').val();


                formData = new FormData();

                formData.append('fromWallet', fromWallet);

                route = "{{ URL('/api/v1/getotherwallets') }}";



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
                            $('#fx_wallet_to').html(
                                `<option value=""> Please wait ...</option>`);
                        },
                        success: function(result) {

                            $('#fx_wallet_to').html("");

                            if (result.status == 200) {

                                var res = result.data;
                                $('.symbolSpace').text(result.thiswallet);

                                $.each(res, (v, k) => {

                                    $('#fx_wallet_to').append(
                                        `<option value="${k.escrow_id}"> Wallet Balance: ${k.currencySymbol} ${k.wallet_balance} | Currency ${k.currencyCode}</option>`
                                    );

                                });


                                currencyConvert();




                            } else {
                                $('#fx_wallet_to').html(
                                    `<option value="">You do not have other wallets</option>`);
                            }

                        },
                        error: function(err) {
                            swal("Oops", err.responseJSON.message, "error");

                        }

                    });
                });

            });


            $('#fx_wallet_to').change(function() {
                $('.sendingInfo').html("");
                // $('#amount').val("");
                currencyConvert();
            });


            $('#amount').on('keyup keydown', () => {

                $('.sendingInfo').html("");

                var amount = $('#amount').val();
                const fromWallet = $('#fx_wallet_from').val();
                const toWallet = $('#fx_wallet_to').val();

                if (amount == "") {
                    return $('.text-error').removeClass('disp-0');
                }

                $('.text-error').addClass('disp-0');


                formData = new FormData();

                formData.append('fromWallet', fromWallet);
                formData.append('toWallet', toWallet);
                formData.append('amount', amount);

                route = "{{ URL('/api/v1/convertmoneytosend') }}";

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

                        success: function(result) {



                            if (result.status == 200) {
                                $('.sendingInfo').html(
                                    `<strong>Amount to be transferred to your ${result.data.toCurrency} wallet is : ${result.data.toCurrency} ${parseFloat(result.data.convamount).toFixed(4)}</strong>`
                                );

                                currencyConvert();

                            } else {
                                swal("Oops", result.message, "error");
                            }

                        },
                        error: function(err) {
                            console.error(err.statusText);
                            // swal("Oops", err.responseJSON.message, "error");

                        }

                    });
                });


            });


            function currencyConvert() {



                var fromCurr = $('#fx_wallet_from option:selected').text();
                var localfrom = fromCurr.split("| Currency ");
                $('#fromCurrency').text(localfrom[1]);

                var someCurr = $('#fx_wallet_to option:selected').text();
                var localto = someCurr.split("| Currency ");
                $('#toCurrency').text(localto[1]);


                var today = new Date();
                var dd = String(today.getDate()).padStart(2, '0');
                var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
                var yyyy = today.getFullYear();

                today = dd + '/' + mm + '/' + yyyy;

                var route = "{{ URL('/api/v1/convertmoneytosend') }}";

                var amount = $('#amount').val();
                const fromWallet = $('#fx_wallet_from').val();
                const toWallet = $('#fx_wallet_to').val();

                var formData = new FormData();

                formData.append('fromWallet', fromWallet);
                formData.append('toWallet', toWallet);
                formData.append('amount', amount);


                setHeaders();
                jQuery.ajax({
                    url: route,
                    method: 'post',
                    // data: thisdata,
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    dataType: 'JSON',
                    success: function(result) {

                        if (amount == "") {
                            $('#typedAmount').text("0.0000");
                        } else {
                            $('#typedAmount').text(parseFloat(amount).toFixed(4));

                        }




                        var todayRate = result.data.convamount;
                        var newConv;

                        if (!todayRate) {
                            todayRate = 0;
                            newConv = result.data.convamount;

                        } else {
                            todayRate = todayRate;
                            newConv = todayRate;
                        }

                        // console.log("New Conversion: " + newConv);

                        $('#convertedAmount').text((newConv).toFixed(4));


                        // Put Exchange rate
                        $('#rateToday').html("<span class='text-danger'><strong>1" + localfrom[1] + " = " +
                            todayRate.toFixed(4) + '' + localto[1] + "</strong></span>");


                    }

                });
            }

            // RUN Ajax
            function handShake(val) {


                if (val == 'transferfxfund') {
                    formData = new FormData(formElem);
                    route = "{{ URL('/api/v1/transferfxfund') }}";

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
                                $('.cardSubmit').text('Please wait...');
                            },
                            success: function(result) {

                                $('.cardSubmit').text('Make Transfer');

                                if (result.status == 200) {
                                    swal("Success", result.message, "success");
                                    setTimeout(function() {
                                        location.href =
                                            "{{ route('paysprint currency exchange') }}";
                                    }, 2000);
                                } else {
                                    swal("Oops", result.message, "error");
                                }

                            },
                            error: function(err) {
                                $('.cardSubmit').text('Make Transfer');
                                swal("Oops", err.responseJSON.message, "error");

                            }

                        });
                    });

                }
            }

            function checkBoxConfirm() {


                var convertRate = $('#convertRate').prop("checked");


                if (convertRate == true) {
                    // Enable button
                    $(".cardSubmit").attr("disabled", false);
                } else {
                    // Disable button
                    $(".cardSubmit").attr("disabled", true);

                }

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
