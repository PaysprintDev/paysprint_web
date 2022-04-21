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

                            <form role="form" action="#" method="POST" id="formElem">
                                @csrf

                                <br>

                                <div class="form-group">
                                    <div class="alert alert-info">
                                        <table class="table table-bordered">

                                            <tbody>
                                                <tr>
                                                    <td><strong>Order ID:</strong> </td>
                                                    <td>{{ $data['marketplace']->order_id }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Selling:</strong> </td>
                                                    <td>{{ number_format($data['marketplace']->sell, 2) . ' ' . $data['marketplace']->sell_currencyCode }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Buying:</strong> </td>
                                                    <td>{{ number_format($data['marketplace']->buy, 2) . ' ' . $data['marketplace']->buy_currencyCode }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Rate:</strong> </td>
                                                    <td>{{ $data['marketplace']->rate }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Expiry Date:</strong> </td>
                                                    <td>{{ $data['marketplace']->expiry }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Status:</strong> </td>
                                                    <td style="color: {{ $data['marketplace']->color }}">
                                                        {{ $data['marketplace']->status }}
                                                    </td>
                                                </tr>
                                            </tbody>

                                        </table>
                                    </div>
                                </div>

                                <div class="form-group"> <label for="country">
                                        <h6>Your biding rate
                                            ({{ $data['marketplace']->sell_currencyCode . ' - ' . $data['marketplace']->buy_currencyCode }})
                                        </h6>
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-append"> <span class="input-group-text text-muted">
                                                <img src="https://img.icons8.com/cotton/20/000000/money--v4.png" />
                                            </span> </div>

                                        <input type="number" min="0.01" step="0.01" name="bid_rate" id="bid_rate"
                                            class="form-control" required
                                            placeholder="{{ $rate = explode(' ' . $data['marketplace']->sell_currencyCode, explode(' - ', $data['marketplace']->rate)[1])[0] }}">

                                    </div>
                                </div>


                                <div class="form-group"> <label for="country">
                                        <h6>Amount to pay ({{ $data['marketplace']->buy_currencyCode }})</h6>
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-append"> <span class="input-group-text text-muted">
                                                <img src="https://img.icons8.com/cotton/20/000000/money--v4.png" />
                                            </span> </div>

                                        <input type="number" min="0.01" step="0.01" name="offer_amount"
                                            id="offer_amount" class="form-control" required
                                            placeholder="{{ number_format($data['marketplace']->buy, 2) }}" readonly>

                                        <input type="hidden" name="bid_amount" id="bid_amount"
                                            value="{{ $data['marketplace']->sell }}">


                                        <input type="hidden" name="order_id" id="order_id"
                                            value="{{ $data['marketplace']->order_id }}">



                                    </div>
                                </div>


                                <div class="form-group">
                                    <div class="row">

                                        <div class="col-md-12 mb-3">
                                            <button type="button" onclick="handShake('makeabid')"
                                                class="btn btn-primary btn-block cardSubmit">Submit Bid</button>
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
        $('#bid_rate').on('keyup keydown', function() {
            const bidRate = $('#bid_rate').val();
            const selling = "{{ $data['marketplace']->sell }}";
            var amountToPay = "";


            if (bidRate <= 0 || bidRate == "") {
                amountToPay = 0;

            } else {
                amountToPay = parseFloat(selling / bidRate).toFixed(4);
            }

            $('#offer_amount').val(amountToPay);


        })

        function handShake(val) {

            var route;

            var formData;

            if (val == 'makeabid') {
                formData = new FormData(formElem);
                route = "{{ URL('/api/v1/makeabid') }}";

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

                            $('.cardSubmit').text('Submit Bid');

                            if (result.status == 200) {
                                swal("Success", result.message, "success");
                                setTimeout(function() {
                                    location.href =
                                        "{{ route('paysprint currency exchange') }}";
                                }, 4000);
                            } else {
                                swal("Oops", result.message, "error");
                            }

                        },
                        error: function(err) {
                            $('.cardSubmit').text('Submit Bid');
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
