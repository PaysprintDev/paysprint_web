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
        href="https://res.cloudinary.com/paysprint/image/upload/v1651130089/assets/paysprint_jpeg_black_bk_2_w4hzub_ioffkg.jpg"
        type="image/x-icon" />

    <link rel="stylesheet" type="text/css" href="{{ asset('pace/themes/orange/pace-theme-flash.css') }}" />

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">

    <script src="https://kit.fontawesome.com/384ade21a6.js"></script>

    <title>PaySprint | {{ $pages }}</title>

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
                <h1 class="display-4">{{ 'PaySprint ' . $pages }}</h1>
            </div>
        </div> <!-- End -->
        <div class="row">
            <div class="col-lg-12 mx-auto">

                <div class="card ">
                    <div class="card-header">
                        <div class="bg-white shadow-sm pt-4 pl-2 pr-2 pb-2">


                            <!-- Credit card form tabs -->
                            <ul role="tablist" class="nav bg-light nav-pills rounded nav-fill mb-3">
                                <li class="nav-item"> <a data-toggle="pill" href="{{ route('home') }}"
                                        class="nav-link active "> <i class="fas fa-home"></i> Go Back Home</a> </li>
                                {{-- <li class="nav-item"> <a data-toggle="pill" href="#paypal" class="nav-link "> <i class="fab fa-paypal mr-2"></i> Debit Card </a> </li>
                                <li class="nav-item"> <a data-toggle="pill" href="#net-banking" class="nav-link "> <i class="fas fa-mobile-alt mr-2"></i> EXBC Card </a> </li> --}}
                            </ul>
                        </div> <!-- End -->
                        <!-- Credit card form content -->
                        <div class="tab-content">

                            <!-- credit card info-->
                            <div id="credit-card" class="tab-pane fade show active pt-3">


                                <div class="row">


                                    @if (count($data['activeStores']) > 0)

                                        @foreach ($data['activeStores'] as $items)
                                            @if ($user = \App\User::where('id', $items->merchantId)->first())
                                                <div class="col-md-4 mb-4">
                                                    <div class="card" style="width: 100%;">
                                                        <img src="{{ array_filter(explode(', ', $items->headerContent))[0] }}"
                                                            class="card-img-top" alt="{{ $user->businessname }}">
                                                        <div class="card-body">
                                                            <h5 class="card-title">{{ $user->businessname }}</h5>
                                                            <p class="card-text">{{ $items->headerTitle }}</p>
                                                            <a href="{{ route('merchant shop now', $user->businessname) }}"
                                                                class="btn btn-primary">Goto store</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    @else
                                        <div class="col-md-6 mx-auto">
                                            <div class="card" style="width: 100%;">
                                                <img src="https://st4.depositphotos.com/7819052/21803/v/600/depositphotos_218033152-stock-illustration-grunge-red-available-word-rubber.jpg"
                                                    class="card-img-top" alt="Not available">
                                                <div class="card-body">
                                                    <h5 class="card-title">No store available yet</h5>
                                                    <p class="card-text">Please check back after sometime.</p>
                                                    <a href="{{ route('home') }}"
                                                        class="btn btn-primary btn-block">Goto
                                                        Homepage</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif


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
            <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

            <script src="{{ asset('pace/pace.min.js') }}"></script>
            <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


</body>

</html>
