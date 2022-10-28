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
        href="https://res.cloudinary.com/paysprint/image/upload/v1651130089/assets/paysprint_jpeg_black_bk_2_w4hzub_ioffkg.jpg"
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
                                            <h6>Select Wallet to Fund</h6>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-append"> <span class="input-group-text text-muted">
                                                    <img src="https://img.icons8.com/cotton/20/000000/money--v4.png" />
                                                </span> </div>
                                            <select name="fx_wallet" id="fx_wallet" class="form-control" required>
                                                @foreach ($data['mywallet'] as $mywallet)
                                                    <option value="{{ $mywallet->escrow_id }}"
                                                        {{ Request::get('currency') == $mywallet->escrow_id ? 'selected' : '' }}>
                                                        {{ 'Wallet Balance: ' . $mywallet->currencySymbol . $mywallet->wallet_balance . ' | Currency ' . $mywallet->currencyCode }}
                                                    </option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>

                                    <div class="form-group"> <label for="fx_payment_method">
                                            <h6>Select Payment Method</h6>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-append"> <span class="input-group-text text-muted">
                                                    <img
                                                        src="https://img.icons8.com/external-wanicon-two-tone-wanicon/20/000000/external-transfer-currency-wanicon-two-tone-wanicon.png" />
                                                </span> </div>
                                            <select name="fx_payment_method" id="fx_payment_method"
                                                class="form-control" required>
                                                <option value="">-- Select Payment Method --</option>
                                                <option value="PaySprint Wallet">PaySprint Wallet</option>
                                                <option value="Wire Transfer">Wire Transfer</option>
                                            </select>

                                        </div>
                                    </div>


                                    <div class="walletTransfer disp-0">
                                        <div class="alert alert-warning">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h4>
                                                        Wallet Balance
                                                    </h4>
                                                </div>
                                                <div class="col-md-12">
                                                    <h4>
                                                        {{ Auth::user()->currencySymbol . '' . number_format(Auth::user()->wallet_balance, 4) }}
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>

                                    </div>


                                    <div class="form-group"> <label for="fx_amount">
                                            <h6>Amount to Add</h6>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-append"> <span class="input-group-text text-muted">
                                                    <img
                                                        src="https://img.icons8.com/external-wanicon-two-tone-wanicon/20/000000/external-transfer-currency-wanicon-two-tone-wanicon.png" />
                                                </span> </div>
                                            <input type="number" min="0.00" step="0.01" name="fx_amount" id="fx_amount"
                                                class="form-control" placeholder="Amount">

                                        </div>
                                    </div>



                                    {{-- Details if Wire Transfer is Selected --}}

                                    <div class="wiredTransfer disp-0">
                                        <div class="form-group">

                                            <div class="input-group">
                                                <p><img src="https://img.icons8.com/color/25/000000/info--v1.png" />
                                                    Please transfer the amount mentioned below to PaySprint and provide
                                                    the transaction details for the transfer.</p>
                                                <div class="alert alert-info" style="width: 100%;">
                                                    <h5>PaySprint Account Details</h5>
                                                    <hr>

                                                    <div class="row">


                                                        <div class="col-md-12">
                                                            <p>Reference Number</p>
                                                            <h4>{{ $refNumber }}</h4>

                                                            <em>Please do not forget to add this Reference Number in the
                                                                notes of your transaction. This will help us quickly
                                                                process your funds</em>
                                                            <hr>
                                                        </div>


                                                        <div class="col-md-12">
                                                            <p>Account Name</p>
                                                            <h5>PaySprint Inc.</h5>
                                                            <hr>
                                                        </div>


                                                        <div class="col-md-12">
                                                            <p>Account Number</p>
                                                            <h5>21205247594</h5>
                                                            <hr>
                                                        </div>



                                                        <div class="col-md-12">
                                                            <p>Bank Name</p>
                                                            <h5>TD CANADA TRUST</h5>
                                                            <hr>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <p>SWIFT Code</p>
                                                            <h5>TDOMCATTTOR</h5>

                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="form-group">

                                            <div class="input-group">
                                                <h5><img src="https://img.icons8.com/fluency/25/000000/check-all.png" />
                                                    Your Transaction details</h5>


                                            </div>
                                        </div>

                                        <div class="form-group"> <label for="fx_payment_bank_name">
                                                <h6>Bank Name</h6>
                                                <small><em>This is the bank name where you made the transaction
                                                        from</em></small>
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-append"> <span
                                                        class="input-group-text text-muted">
                                                        <img
                                                            src="https://img.icons8.com/external-itim2101-flat-itim2101/20/000000/external-bank-fintech-itim2101-flat-itim2101.png" />
                                                    </span> </div>
                                                <input type="text" name="fx_payment_bank_name" id="fx_payment_bank_name"
                                                    class="form-control" placeholder="Bank Name">

                                            </div>
                                        </div>

                                        <div class="form-group"> <label for="fx_account_number">
                                                <h6>Account Number</h6>
                                                <small><em>Your bank account number</em></small>
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-append"> <span
                                                        class="input-group-text text-muted">
                                                        <img src="https://img.icons8.com/ios/20/000000/hashtag.png" />
                                                    </span> </div>
                                                <input type="number" min="0" step="0" name="fx_account_number"
                                                    id="fx_account_number" class="form-control"
                                                    placeholder="Account Number">

                                            </div>
                                        </div>


                                        <div class="form-group"> <label for="fx_account_name">
                                                <h6>Account Name</h6>
                                                <small><em>Account name where the transaction was processed</em></small>
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-append"> <span
                                                        class="input-group-text text-muted">
                                                        <img
                                                            src="https://img.icons8.com/external-kiranshastry-lineal-color-kiranshastry/20/000000/external-user-advertising-kiranshastry-lineal-color-kiranshastry-2.png" />
                                                    </span> </div>
                                                <input type="text" name="fx_account_name" id="fx_account_name"
                                                    class="form-control" placeholder="Account Name">

                                            </div>
                                        </div>







                                    </div>






                                    {{-- Details of wallet if Wallet Transfer --}}




                                    <div class="form-group btnPay disp-0">
                                        <div class="row">

                                            <div class="col-md-12 mb-3">
                                                <button type="button" onclick="handShake('fundfx')"
                                                    class="btn btn-primary btn-block cardSubmit">I have transferred the
                                                    fund</button>
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
        <script src="https://js.paystack.co/v1/inline.js"></script>





        <script>
            $('#fx_payment_method').change(function() {
                if ($('#fx_payment_method').val() == "Wire Transfer") {
                    $('.wiredTransfer').removeClass('disp-0');
                    $('.btnPay').removeClass('disp-0');
                    $('.walletTransfer').addClass('disp-0');
                } else if (($('#fx_payment_method').val() == "Wallet Transfer")) {
                    $('.walletTransfer').removeClass('disp-0');
                    $('.btnPay').removeClass('disp-0');
                    $('.wiredTransfer').addClass('disp-0');
                } else if (($('#fx_payment_method').val() == "PaySprint Wallet")) {
                    $('.walletTransfer').removeClass('disp-0');
                    $('.btnPay').removeClass('disp-0');
                    $('.wiredTransfer').addClass('disp-0');
                } else {
                    $('.wiredTransfer').addClass('disp-0');
                    $('.walletTransfer').addClass('disp-0');
                    $('.btnPay').addClass('disp-0');
                }
            });


            // RUN Ajax


            function handShake(val) {

                var route;

                var formData;

                if (val == 'fundfx') {
                    formData = new FormData(formElem);
                    route = "{{ URL('/api/v1/fundfx') }}";

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
                                console.log(result);

                                $('.cardSubmit').text('I have transferred the fund');

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
                                $('.cardSubmit').text('I have transferred the fund');
                                swal("Oops", err.responseJSON.message, "error");

                            }

                        });
                    });

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
