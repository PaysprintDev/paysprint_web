<!doctype html>

<?php use App\Http\Controllers\EPSVendor; ?>


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

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">

    <script src="https://kit.fontawesome.com/384ade21a6.js"></script>

    <title>PaySprint | Airtime & Utility Bills</title>

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
    </style>

</head>

<body>
    <div class="container py-5">
        <!-- For demo purpose -->
        <div class="row mb-4">
            <div class="col-lg-12 mx-auto text-center">
                <h1 class="display-4">Select Country</h1>
            </div>
        </div> <!-- End -->
        <div class="row">
            <div class="col-lg-12 mx-auto">

                <div class="card ">
                    <div class="card-header">
                        <div class="bg-white shadow-sm pt-4 pl-2 pr-2 pb-2">
                            <!-- Credit card form tabs -->
                            <ul role="tablist" class="nav bg-light nav-pills rounded nav-fill mb-3">

                                @if (Auth::user()->accountType == 'Individual')
                                    <li class="nav-item"> <a data-toggle="pill" href="{{ route('my account') }}"
                                            class="nav-link active "> <i class="fas fa-home"></i> Go Back </a> </li>
                                @else
                                    <li class="nav-item"> <a data-toggle="pill" href="{{ route('Admin') }}"
                                            class="nav-link active "> <i class="fas fa-home"></i> Go Back </a> </li>
                                @endif


                            </ul>
                        </div> <!-- End -->
                        <!-- Credit card form content -->
                        <div class="tab-content">

                            <!-- credit card info-->
                            <div id="credit-card" class="tab-pane fade show active pt-3">

                                <div class="col-md-12">
                                    <form action="{{ route('select utility bills country') }}" method="get">
                                        <select name="country" id="country" class="form-control form-select mb-3">
                                            @if (isset($data['countryApproval']))
                                                <option value="">Select Country</option>
                                                @foreach ($data['countryApproval'] as $country)
                                                    <option value="{{ $country->name }}"
                                                        {{ $country->name == Request::get('country') ? ' selected' : '' }}>
                                                        {{ $country->name }}</option>
                                                @endforeach
                                            @else
                                                <option value="">No available country</option>
                                            @endif
                                        </select>

                                        <button type="submit" class="btn btn-warning">Pay utility
                                            bill</button>
                                    </form>
                                </div>

                                <br>

                                @if (Request::get('country') == 'Nigeria')
                                    <div class="col-md-12 pb-4">

                                        <div class="card" style="width: 100%;">

                                            <img src="https://res.cloudinary.com/paysprint/image/upload/v1656590760/assets/Flag_of_Nigeria_mhpzym.svg"
                                                class="card-img-top" alt="Nigeria"
                                                style="width: 100%; height: 200px;object-fit: contain;">

                                            <div class="card-body">
                                                <h5 class="card-title text-center">Pay Utility Bills In Nigeria</h5>

                                                <a href="{{ route('utility bills', 'country=Nigeria') }}"
                                                    class="btn btn-primary btn-block">Continue</a>
                                            </div>
                                        </div>

                                    </div>
                                @else
                                    <div class="col-md-12 pb-4">

                                        <div class="card" style="width: 100%;">

                                            <img src="https://res.cloudinary.com/paysprint/image/upload/v1656591099/assets/not-available-red-rubber-stamp-over-white-background-87242466_odd8qc.jpg"
                                                class="card-img-top" alt="Nigeria"
                                                style="width: 100%; height: 200px;object-fit: contain;">

                                            <hr>

                                            <div class="card-body">
                                                <h5 class="card-title text-center">Utility Bills Not Available in
                                                    {{ Request::get('country') }}</h5>


                                            </div>
                                        </div>

                                    </div>
                                @endif



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
            <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

            <script src="{{ asset('pace/pace.min.js') }}"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>



</body>

</html>
