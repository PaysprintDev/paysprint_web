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

    <title>PaySprint | Add Money To Wallet</title>

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
                <h1 class="display-4">Add Money To Wallet</h1>
            </div>
        </div> <!-- End -->
        <div class="row">
            <div class="col-lg-6 mx-auto">
                <div class="card ">
                    <div class="card-header">
                        <div class="bg-white shadow-sm pt-4 pl-2 pr-2 pb-2">
                            <!-- Credit card form tabs -->
                            <ul role="tablist" class="nav bg-light nav-pills rounded nav-fill mb-3">
                                <li class="nav-item" onclick="window.history.back()"> <a data-toggle="pill"
                                        href="{{ route('payorganization') }}" class="nav-link active "> <i
                                            class="fas fa-home"></i> Go Back </a> </li>
                                {{-- <li class="nav-item"> <a data-toggle="pill" href="#paypal" class="nav-link "> <i class="fab fa-paypal mr-2"></i> Debit Card </a> </li>
                                <li class="nav-item"> <a data-toggle="pill" href="#net-banking" class="nav-link "> <i class="fas fa-mobile-alt mr-2"></i> EXBC Card </a> </li> --}}
                            </ul>
                        </div> <!-- End -->
                        <!-- Credit card form content -->
                        <div class="tab-content">



                            @if (isset($data))
                                {{-- 234-90695 --}}


                                <!-- credit card info-->
                                <div id="credit-card" class="tab-pane fade show active pt-3">
                                    <form role="form" action="#" method="POST" id="paymentForm">

                                        @csrf

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

                                        <input type="hidden" name="orgpayname" id="orgpayname"
                                            value="{{ $data['name'] }}">

                                        <input type="hidden" name="orgpayemail" id="orgpayemail"
                                            value="{{ $data['email'] }}">

                                        <input type="hidden" name="api_token" id="api_token"
                                            value="{{ $data['api_token'] }}">

                                        <input type="hidden" name="code" id="code"
                                            value="{{ $data['currencyCode']->callingCode }}">

                                        <input type="hidden" name="paymentToken" id="paymentToken" value="">

                                        <div class="form-group">
                                            <div class="alert alert-info">

                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <strong>Payer's Name:</strong>
                                                    </div>
                                                    <div class="col-md-8">
                                                        {{ $data['name'] }}
                                                    </div>
                                                    <div class="col-md-4">
                                                        <strong>Email Address:</strong>
                                                    </div>
                                                    <div class="col-md-8">
                                                        {{ $data['email'] }}
                                                    </div>
                                                    <div class="col-md-4">
                                                        <strong>Total Amount:</strong>
                                                    </div>
                                                    <div class="col-md-8">
                                                        {{ $data['currencyCode']->currencyCode . ' ' . number_format($data['amount'], 2) }}
                                                    </div>
                                                </div>
                                            </div>


                                        </div>




                                        <div class="card-footer">

                                            <div class="row">

                                                <div class="col-md-12 withWallet">

                                                    <button type="button" onclick="paymentOnline()"
                                                        class="subscribe btn btn-primary btn-block shadow-sm sendmoneyBtn">
                                                        Make Payment </button>

                                                </div>

                                            </div>


                                        </div>

                                    </form>
                                </div>
                            @else
                                <div class="alert alert-danger">
                                    No record
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

        <script src="https://cdnjs.cloudflare.com/ajax/libs/js-sha256/0.9.0/sha256.js"></script>
        {{-- <script src="https://xpresspayonlinepluginssandbox.xpresspayments.com/js/plugin.js"></script> --}}
        <script type="text/javascript" src="https://plugins.xpresspayonline.com/js/plugin.js"></script>

        <script>
            const publicKey = "{{ env('EXPRESS_WEB_PAY_PUBLIC_KEY') }}";

            const transactionId = "{{ $data['transactionId'] }}";

            function paymentOnline() {
                var email = "{{ $data['email'] }}";
                var amount = "{{ $data['amount'] }}";
                var phone = "{{ $data['phone'] }}";
                var firstname = "{{ $data['firstname'] }}";
                var lastname = "{{ $data['lastname'] }}";
                var hash = "{{ $data['hash'] }}";
                var apiToken = "{{ $data['api_token'] }}";

                const body = {
                    "publicKey": publicKey,
                    "logoURL": "https://res.cloudinary.com/pilstech/image/upload/v1617797525/paysprint_asset/paysprint_with_name_black_and_yellow_png_do13ha.png",
                    "transactionId": transactionId,
                    "merchantId": apiToken,
                    "amount": Math.round(amount * 100) / 100,
                    "currency": "NGN",
                    "country": "NG",
                    "email": email,
                    "phoneNumber": phone,
                    "firstName": firstname,
                    "lastName": lastname,
                    "hash": hash,
                    "callbackUrl": "{{ route('express callback') }}",
                    "meta": [{
                        "metaName": "Description",
                        "metaValue": "Added {{ $data['currencyCode']->currencyCode }}" + amount +
                            " to PaySprint Wallet, Fee Inclusive."
                    }]
                }



                console.log(body);


                xpressPayonlineSetup(body);

            }


            //Set CSRF HEADERS
            function setHeaders() {
                jQuery.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        'Authorization': "Bearer " + "{{ $data['api_token'] }}"
                    }
                });
            }
        </script>


</body>

</html>
