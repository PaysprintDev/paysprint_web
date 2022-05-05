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

    <title>PaySprint | Rental Property Management</title>

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
                <h1 class="display-4">Rental Property Management</h1>
            </div>
        </div> <!-- End -->
        <div class="row">
            <div class="col-lg-12 mx-auto">

                <div class="card ">
                    <div class="card-header">
                        <div class="bg-white shadow-sm pt-4 pl-2 pr-2 pb-2">


                            <!-- Credit card form tabs -->
                            <ul role="tablist" class="nav bg-light nav-pills rounded nav-fill mb-3">
                                <li class="nav-item"> <a data-toggle="pill" href="{{ route('user home') }}"
                                        class="nav-link active "> <i class="fas fa-home"></i> Go Home </a> </li>
                                {{-- <li class="nav-item"> <a data-toggle="pill" href="#paypal" class="nav-link "> <i class="fab fa-paypal mr-2"></i> Debit Card </a> </li>
                                <li class="nav-item"> <a data-toggle="pill" href="#net-banking" class="nav-link "> <i class="fas fa-mobile-alt mr-2"></i> EXBC Card </a> </li> --}}
                            </ul>
                        </div> <!-- End -->
                        <!-- Credit card form content -->
                        <div class="tab-content">

                            <!-- credit card info-->
                            <div id="credit-card" class="tab-pane fade show active pt-3">

                                <div class="table table-responsive">
                                    <caption>
                                        <a href="{{ route('facility') }}" class="btn btn-success mb-3">Create
                                            Property</a>
                                    </caption>
                                    <table class="table table-striped table-bordered" id="myTableAll">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Building Location</th>
                                                <th>Building Type</th>
                                                <th>Action</th>
                                                <th>&nbsp;</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @if (count($data['getmyfacility']) > 0)

                                                @php
                                                    $i = 1;
                                                @endphp

                                                @foreach ($data['getmyfacility'] as $data)
                                                    <tr>
                                                        <td>{{ $i++ }}</td>

                                                        <td>
                                                            {{ $data->buildinglocation_street_number . ' ' . $data->buildinglocation_street_name . ' ' . $data->buildinglocation_city . ' ' . $data->buildinglocation_zipcode . ' ' . $data->buildinglocation_state }}
                                                        </td>

                                                        <td>
                                                            {{ $data->building_type }}
                                                        </td>

                                                        <td>
                                                            <a href="{{ route('rentalManagementAdmin') }}"
                                                                type="button" class="btn btn-primary btn-block">Manage
                                                                Property</a>
                                                        </td>
                                                        <td>
                                                            <form action="{{ route('delete property') }}"
                                                                method="post" class="disp-0"
                                                                id="deleteproperty{{ $data->id }}">@csrf <input
                                                                    type="hidden" value="{{ $data->id }}"
                                                                    name="facilityid"></form>
                                                            <a href="javascript:void(0)" type="button"
                                                                class="btn btn-danger btn-block"
                                                                onclick="handShake('deleteproperty', {{ $data->id }})">Delete
                                                                Property</a>
                                                        </td>

                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td align="center" colspan="5">
                                                        No record
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="center" colspan="5">
                                                        <a href="{{ route('facility') }}"
                                                            class="btn btn-danger btn-block">Create Property Location
                                                            You Manage</a>
                                                    </td>
                                                </tr>

                                            @endif


                                        </tbody>

                                    </table>
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


            <script>
                function handShake(val, id) {


                    var route;

                    if (val == "deleteproperty") {

                        // Ask Are you sure

                        swal({
                                title: "Are you sure you want to delete property?",
                                text: "This property will be deleted and can not be recovered!",
                                icon: "warning",
                                buttons: true,
                                dangerMode: true,
                            })
                            .then((willDelete) => {
                                if (willDelete) {

                                    $("#" + val + '' + id).submit();

                                } else {
                                    swal('', 'Canceled', 'info');
                                }
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
