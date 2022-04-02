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
                                            aria-selected="true"><img
                                                src="https://res.cloudinary.com/pilstech/image/upload/v1602675914/paysprint_icon_png_ol2z3u.png"
                                                style="width:25px; height: 25px;" />
                                            I have a PaySprint Wallet</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="dontHaveAccount" data-toggle="tab"
                                            data-target="#profile" type="button" role="tab" aria-controls="profile"
                                            aria-selected="false">

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
                                                    <form action="#" method="post">
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
                                                            </div>
                                                        </div>


                                                        <div class="alert alert-warning">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <h4>
                                                                        Wallet Balance
                                                                    </h4>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <h4>
                                                                    </h4>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="form-group"> <label for="amounttosend">
                                                                <h6><span style="color: red;">*</span> Amount</h6>
                                                            </label>
                                                            <div class="input-group">

                                                                <div class="input-group-append"> <span
                                                                        class="input-group-text text-muted">
                                                                        {{ $data['paymentorg']->currencySymbol }}</span>
                                                                </div>
                                                                <input type="text" name="amounttosend"
                                                                    class="form-control" id="amounttosend"
                                                                    value="{{ sprintf('%.2f', $totalCost) }}"
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


                                                        <div class="form-group mt-4">

                                                            <button type="button" onclick="#"
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
                                                    <form action="#" method="post">
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



                                                        <div class="form-group"> <label for="amounttosend">
                                                                <h6><span style="color: red;">*</span>Amount</h6>
                                                            </label>
                                                            <div class="input-group">

                                                                <div class="input-group-append"> <span
                                                                        class="input-group-text text-muted">
                                                                        {{ $data['paymentorg']->currencySymbol }}</span>
                                                                </div>
                                                                <input type="text" name="amounttosend"
                                                                    class="form-control" id="amounttosend"
                                                                    value="{{ sprintf('%.2f', $totalCost) }}"
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
                                                                <input type="text" name="purpose" class="form-control"
                                                                    id="purpose"
                                                                    value="Purchase of {{ count($data['getCart']) }} items from {{ $data['paymentorg']->businessname }}"
                                                                    readonly>
                                                            </div>
                                                        </div>





                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group"> <label for="cardType">
                                                                        <h6><span style="color: red;">*</span> Select
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
                                                                            <option value="">Select Card Type</option>
                                                                            <option value="Credit Card">Credit Card
                                                                            </option>
                                                                            <option value="Debit Card">Debit Card
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group"> <label for="cardNumber">
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
                                                                <div class="form-group"> <label for="cardMonth">
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
                                                                        <h6><span style="color: red;">*</span> Card Year
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
                                                                            value="" placeholder="Expiry Year:" min="01"
                                                                            step="01">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="form-group mt-4">

                                                            <button type="button" onclick="#"
                                                                class="subscribe btn btn-primary btn-block shadow-sm sendmoneyBtn">
                                                                Make Payment </button>
                                                        </div>

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
                                                        <p>Create a PaySprint account to pay at a lesser rate.</p>
                                                        <p>
                                                            <a type="button" class="btn btn-primary"
                                                                href="{{ route('register') }}" target="_blank">Click
                                                                here
                                                                to
                                                                CREATE AN
                                                                ACCOUNT</a>
                                                        </p>

                                                        <p>
                                                            or
                                                        </p>

                                                        <p>DOWNLOAD OUR APP</p>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <a href="https://play.google.com/store/apps/details?id=com.fursee.damilare.sprint_mobile"
                                                                    target="_blank"
                                                                    class="btn text-white gr-hover-y px-lg-9">
                                                                    <img src="https://res.cloudinary.com/pilstech/image/upload/v1620148943/paysprint_asset/l6-download-gplay_o9rcfj.png"
                                                                        alt="play store" width="100%">
                                                                </a>
                                                            </div>
                                                            <div class="col-md-6">
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

    <script src="{{ asset('pace/pace.min.js') }}"></script>
    <script src="{{ asset('js/country-state-select.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script language="javascript">
        populateCountries("country", "state");
    </script>

    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip();

        });



        function restriction(val, name) {
            if (val == "sendmoney") {
                swal('Hello ' + name, 'Your account needs to be verified before you can send money', 'info');
            }
        }




        //Set CSRF HEADERS
        function setHeaders() {
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });
        }
    </script>


</body>

</html>
