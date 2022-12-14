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

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">

    <script src="https://kit.fontawesome.com/384ade21a6.js"></script>

    <title>PaySprint | PaySprint FX</title>

    <style>
        body {
            background: #f5f5f5
        }

        .rounded {
            border-radius: 1rem
        }

        .nav-pills .nav-link {
            color: rgb(255, 255, 255)
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

        .fas {
            font-size: 12px;
        }

        .nav-tabs .nav-link {
            border: 1px solid #6c757d !important;
            width: 20%;
        }

        .nav-link.active,
        .nav-pills .show>.nav-link {
            background-color: #fff3cd !important;
        }

    </style>

</head>

<body>
    <div class="container py-5">
        <!-- For demo purpose -->
        <div class="row mb-4">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-4">My Wallet</h1>
            </div>
        </div> <!-- End -->
        <div class="row">
            <div class="col-lg-12 mx-auto">
                <div class="card ">
                    <div class="card-header">
                        <div class="bg-white shadow-sm pt-4 pl-2 pr-2 pb-2">
                            <!-- Credit card form tabs -->
                            <ul role="tablist" class="nav bg-light nav-pills rounded nav-fill mb-3">
                                <li class="nav-item" style="background-color: #007bff !important;"> <a
                                        data-toggle="pill" href="{{ route('home') }}" class="nav-link active"
                                        style="background-color: #007bff !important;"> <i class="fas fa-home"></i>
                                        Goto HomePage </a> </li>
                            </ul>
                        </div> <!-- End -->
                        <!-- Credit card form content -->
                        <div class="tab-content">

                            <!-- credit card info-->
                            <div id="credit-card" class="tab-pane fade show active pt-3">


                                <div class="form-group row">

                                    <div class="col-md-12">
                                        {{-- <h5>Hello {{ (strlen($name) < 10) ? $name : substr($name, 0, 10)."." }},</h5> --}}
                                        @php
                                            $username = explode(' ', $name);
                                        @endphp

                                        <h5>Hello {{ $username[0] }},</h5>
                                        <p>
                                            {{ date('A') == 'AM' ? 'Good Morning! Hope you took some coffee.???' : 'Good day! Remember to wash your hands.????' }}
                                        </p>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="alert alert-warning">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h6 class="font-sm">
                                                        Wallet Balance
                                                    </h6>
                                                </div>
                                                <div class="col-md-7">
                                                    <h4>
                                                        {{ $data['currencyCode']->currencySymbol . '' . number_format(Auth::user()->wallet_balance, 4) }}
                                                    </h4>
                                                </div>
                                                <div class="col-md-5">
                                                    <a href="{{ route('my account') }}"
                                                        style="font-weight: bold; text-decoration: none;">
                                                        PaySpirnt Wallet <img
                                                            src="https://img.icons8.com/external-justicon-flat-justicon/30/000000/external-wallet-ecommerce-justicon-flat-justicon.png" />
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <p>

                                        <div class="alert alert-success">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h6 class="font-sm">
                                                        Available Offers
                                                    </h6>
                                                </div>
                                                <div class="col-md-12">
                                                    <h4>
                                                        10
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>


                                        </p>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="alert alert-info">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h6 class="font-sm">
                                                        Create Offer
                                                    </h6>
                                                </div>
                                                <div class="col-md-12">
                                                    <a href="#">
                                                        Click here to proceed
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="alert alert-danger">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h6 class="font-sm">
                                                        Closed Offers
                                                    </h6>
                                                </div>
                                                <div class="col-md-12">
                                                    <h4>
                                                        6
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>

                                    </div>


                                    <div class="col-md-12">
                                        <div class="alert alert-primary">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h6 class="font-sm">
                                                        Transaction History
                                                    </h6>
                                                </div>
                                                <div class="col-md-12">
                                                    <a href="#">
                                                        Click here to proceed
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>


                                </div>




                                <div class="form-group row">
                                    <div class="col-md-6 mb-3">
                                        <a type="button" href="{{ route('Add Money') }}"
                                            class="btn btn-info btn-block">Add Money <i class="fa fa-plus"></i></a>
                                    </div>

                                    @if (Auth::user()->approval == 2 && Auth::user()->accountLevel == 3)

                                        <div class="col-md-6 mb-3">
                                                <a type="button" href="{{ route('Withdraw Money') }}"
                                                    class="btn btn-secondary btn-block">Withdraw Money <i
                                                        class="fa fa-credit-card"></i></a>
                                            </div>
                                    @else
                                        <div class="col-md-6 mb-3">
                                            <a type="button" href="javascript:void()"
                                                class="btn btn-secondary btn-block"
                                                onclick="restriction('withdrawal', '{{ Auth::user()->name }}')">Withdraw
                                                Money <i class="fa fa-credit-card"></i></a>
                                        </div>

                                    @endif


                                </div>

                                @if (isset($data['specialInfo']))
                                    <div class="alert alert-danger alert-dismissible show specialText disp-0"
                                        role="alert">
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-label="Close" onclick="$('.specialText').addClass('disp-0')">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        {!! $data['specialInfo']->information !!}
                                    </div>
                                @endif







                            </div> <!-- End -->

                        </div>
                    </div>
                </div>
            </div>


            <script src="{{ asset('js/jquery-1.12.0.min.js') }}"></script>

            <!-- Note: when deploying, replace "development.js" with "production.min.js". -->
            {{-- <script src="https://unpkg.com/react@17/umd/react.development.js" crossorigin></script>
        <script src="https://unpkg.com/react-dom@17/umd/react-dom.development.js" crossorigin></script> --}}


            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js"
                        integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous">
            </script>

            <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

            <script src="{{ asset('pace/pace.min.js') }}"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>



</body>

</html>
