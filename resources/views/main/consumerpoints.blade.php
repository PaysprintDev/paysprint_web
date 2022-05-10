<!doctype html>
<html lang="en">
<?php use App\Http\Controllers\User; ?>

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

    <title>PaySprint | {{ Request::get('service') . ' PaySprint Point' }}</title>

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
            <div class="col-lg-10 mx-auto text-center">
                <h1 class="display-4">Paysprint Point</h1>
            </div>
        </div> <!-- End -->
        <div class="row">
            <div class="col-lg-12 mx-auto">


                @if (isset($data['getallpoint']))


                    <div class="card ">
                        <div class="card-header">
                            <div class="bg-white shadow-sm pt-4 pl-2 pr-2 pb-2">


                                <!-- Credit card form tabs -->
                                <ul role="tablist" class="nav bg-light nav-pills rounded nav-fill mb-3">
                                    @if (Auth::user()->accountType == 'Merchant')
                                        <li class="nav-item"> <a data-toggle="pill" href="{{ route('Admin') }}"
                                                class="nav-link active "> <i class="fas fa-home"></i> Go Back </a>
                                        </li>
                                    @else
                                        <li class="nav-item"> <a data-toggle="pill" href="{{ route('home') }}"
                                                class="nav-link active "> <i class="fas fa-home"></i> Go Back </a>
                                        </li>
                                    @endif


                                </ul>

                                <h5 align='right' class="text-success">Point Balance
                                    {{ isset($data['mypoints']) ? $data['mypoints']->points_acquired : 0 }}</h5>
                                <h5 align='right' class="text-success">Redeemed Point:
                                    {{ isset($data['mypoints']) ? $data['mypoints']->current_point : 0 }}</h5>
                                <h5 align='right' class="text-success">Total Points:
                                    <?php

                                    $first_number = $data['mypoints']->points_acquired;
                                    $second_number = $data['mypoints']->current_point;

                                    $sum_total = $second_number + $first_number;

                                    print $sum_total;

                                    ?></td>
                                </h5>
                                <div class="row">
                                    <div class="col-md-2">
                                        {{-- <button href="#">Claim Points</button> --}}
                                        <form action="{{ route('claim point') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-primary btn-block">Redeem
                                                Points</button>

                                        </form>
                                    </div>
                                    <div class="col-md-3">


                                        <a href="{{ route('claim history') }}" class="btn btn-success btn-block">View
                                            Claim
                                            History</a>


                                    </div>
                                </div>

                            </div> <!-- End -->
                            <!-- Credit card form content -->
                            <div class="tab-content">

                                <!-- credit card info-->
                                <div id="credit-card" class="tab-pane fade show active pt-3">

                                    <div class="table table-responsive">
                                        <table class="table table-bordered table-striped" id="example3">
                                            <thead>
                                                <tr>
                                                    <td>
                                                        <h5>Action</h5>
                                                    </td>
                                                    <td>
                                                        <h5>Activity Count</h5>
                                                    </td>
                                                    <td>
                                                        <h5>Points</h5>
                                                    </td>

                                                </tr>
                                            </thead>
                                            <tbody>

                                                <tr>

                                                    <td>Add Money <br>
                                                        <small class="text-danger"><em>Add money points attracts 200
                                                                reward points</em></small>
                                                    </td>
                                                    <td>{{ $data['getallpoint']->add_money }}</td>
                                                    <td><?php

                                                    $first_number = $data['getallpoint']->add_money;
                                                    $second_number = 200;

                                                    $sum_total = $second_number * $first_number;

                                                    print $sum_total;

                                                    ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Send Money <br>
                                                        <small class="text-danger"><em>Send money points attracts 140
                                                                reward points</em></small>
                                                    </td>
                                                    <td>{{ $data['getallpoint']->send_money }}</td>
                                                    <td><?php

                                                    $first_number = $data['getallpoint']->send_money;
                                                    $second_number = 140;

                                                    $sum_total = $second_number * $first_number;

                                                    print $sum_total;

                                                    ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Receive Money <br>
                                                        <small class="text-danger"><em>Receive money points attracts
                                                                120
                                                                reward points</em></small>
                                                    </td>
                                                    <td>{{ $data['getallpoint']->receive_money }}</td>
                                                    <td><?php

                                                    $first_number = $data['getallpoint']->receive_money;
                                                    $second_number = 120;

                                                    $sum_total = $second_number * $first_number;

                                                    print $sum_total;

                                                    ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Pay Invoice <br>
                                                        <small class="text-danger"><em>Pay Invoice points attracts 50
                                                                reward points</em></small>
                                                    </td>
                                                    <td>{{ $data['getallpoint']->pay_invoice }}</td>
                                                    <td><?php

                                                    $first_number = $data['getallpoint']->pay_invoice;
                                                    $second_number = 50;

                                                    $sum_total = $second_number * $first_number;

                                                    print $sum_total;

                                                    ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Pay Bills <br>
                                                        <small class="text-danger"><em>Pay Bills points attracts 50
                                                                reward points</em></small>
                                                    </td>
                                                    <td>{{ $data['getallpoint']->pay_bills }}</td>
                                                    <td><?php

                                                    $first_number = $data['getallpoint']->pay_bills;
                                                    $second_number = 50;

                                                    $sum_total = $second_number * $first_number;

                                                    print $sum_total;

                                                    ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Create And Send Invoice <br>
                                                        <small class="text-danger"><em>Create and Send Invoice points
                                                                attracts 80
                                                                reward points</em></small>
                                                    </td>
                                                    <td>{{ $data['getallpoint']->create_and_send_invoice }}</td>
                                                    <td><?php

                                                    $first_number = $data['getallpoint']->create_and_send_invoice;
                                                    $second_number = 80;

                                                    $sum_total = $second_number * $first_number;

                                                    print $sum_total;

                                                    ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Active Rental Property <br>
                                                        <small class="text-danger"><em>Active Rental Property points
                                                                attracts 500
                                                                reward points</em></small>
                                                    </td>
                                                    <td>{{ $data['getallpoint']->active_rental_property }}</td>
                                                    <td><?php

                                                    $first_number = $data['getallpoint']->active_rental_property;
                                                    $second_number = 500;

                                                    $sum_total = $second_number * $first_number;

                                                    print $sum_total;

                                                    ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Quick Set Up <br>
                                                        <small class="text-danger"><em>Quick Set Up points attracts
                                                                200
                                                                reward points</em></small>
                                                    </td>
                                                    <td>{{ $data['getallpoint']->quick_set_up }}</td>
                                                    <td><?php

                                                    $first_number = $data['getallpoint']->quick_set_up;
                                                    $second_number = 200;

                                                    $sum_total = $second_number * $first_number;

                                                    print $sum_total;

                                                    ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Approved Customers <br>
                                                        <small class="text-danger"><em>Approved Customers points
                                                                attracts
                                                                500
                                                                reward points</em></small>
                                                    </td>
                                                    <td>{{ $data['getallpoint']->approved_customers }}</td>
                                                    <td><?php

                                                    $first_number = $data['getallpoint']->approved_customers;
                                                    $second_number = 500;

                                                    $sum_total = $second_number * $first_number;

                                                    print $sum_total;

                                                    ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Approved Merchants <br>
                                                        <small class="text-danger"><em>Approved Merchants points
                                                                attracts
                                                                700
                                                                reward points</em></small>
                                                    </td>
                                                    <td>{{ $data['getallpoint']->approved_merchants }}</td>
                                                    <td><?php

                                                    $first_number = $data['getallpoint']->approved_merchants;
                                                    $second_number = 700;

                                                    $sum_total = $second_number * $first_number;

                                                    print $sum_total;

                                                    ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Promote Business <br>
                                                        <small class="text-danger"><em>Promote Business points
                                                                attracts
                                                                150
                                                                reward points</em></small>
                                                    </td>
                                                    <td>{{ $data['getallpoint']->promote_business }}</td>
                                                    <td><?php

                                                    $first_number = $data['getallpoint']->promote_business;
                                                    $second_number = 150;

                                                    $sum_total = $second_number * $first_number;

                                                    print $sum_total;

                                                    ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Activate Ordering System</td>
                                                    <td>{{ $data['getallpoint']->activate_ordering_system }}</td>
                                                    <td><?php

                                                    $first_number = $data['getallpoint']->activate_ordering_system;
                                                    $second_number = 0;

                                                    $sum_total = $second_number * $first_number;

                                                    print $sum_total;

                                                    ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Identify Verification</td>
                                                    <td>{{ $data['getallpoint']->identify_verification }}</td>
                                                    <td><?php

                                                    $first_number = $data['getallpoint']->identify_verification;
                                                    $second_number = 0;

                                                    $sum_total = $second_number * $first_number;

                                                    print $sum_total;

                                                    ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Activate RPM</td>
                                                    <td>{{ $data['getallpoint']->activate_rpm }}</td>
                                                    <td><?php

                                                    $first_number = $data['getallpoint']->activate_rpm;
                                                    $second_number = 0;

                                                    $sum_total = $second_number * $first_number;

                                                    print $sum_total;

                                                    ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Activate Currency Exchange</td>
                                                    <td>{{ $data['getallpoint']->activate_currency_exchange }}</td>
                                                    <td><?php

                                                    $first_number = $data['getallpoint']->activate_currency_exchange;
                                                    $second_number = 0;

                                                    $sum_total = $second_number * $first_number;

                                                    print $sum_total;

                                                    ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Activate Cash Advance</td>
                                                    <td>{{ $data['getallpoint']->activate_cash_advance }}</td>
                                                    <td><?php

                                                    $first_number = $data['getallpoint']->activate_cash_advance;
                                                    $second_number = 0;

                                                    $sum_total = $second_number * $first_number;

                                                    print $sum_total;

                                                    ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Activate Crypto Currency Account</td>
                                                    <td>{{ $data['getallpoint']->activate_crypto_currency_account }}
                                                    </td>
                                                    <td><?php

                                                    $first_number = $data['getallpoint']->activate_crypto_currency_account;
                                                    $second_number = 0;

                                                    $sum_total = $second_number * $first_number;

                                                    print $sum_total;

                                                    ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Total Points</td>
                                                    <td>{{ $data['getallpoint']->add_money + $data['getallpoint']->send_money + $data['getallpoint']->receive_money + $data['getallpoint']->pay_invoice + $data['getallpoint']->pay_bills + $data['getallpoint']->create_and_send_invoice + $data['getallpoint']->active_rental_property + $data['getallpoint']->approved_customers + $data['getallpoint']->approved_merchants + $data['getallpoint']->promote_business + $data['getallpoint']->activate_ordering_system + $data['getallpoint']->identify_verification + $data['getallpoint']->activate_rpm + $data['getallpoint']->activate_currency_exchange + $data['getallpoint']->activate_cash_advance + $data['getallpoint']->activate_crypto_currency_account }}
                                                    </td>
                                                    <td>{{ $data['getallpoint']->points_acquired }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Balance Points</td>
                                                    <td>
                                                        &nbsp;
                                                    </td>
                                                    <td>{{ isset($data['mypoints']) ? $data['mypoints']->points_acquired : 0 }}
                                                    </td>
                                                </tr>

                                            </tbody>

                                            </tbody>

                                        </table>


                                    </div>




                                    <div class="row">
                                        <div class="col-md-6">
                                            {{-- <button href="#">Claim Points</button> --}}
                                            <form action="{{ route('claim point') }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-primary btn-block">Redeem
                                                    Points</button>

                                            </form>
                                        </div>
                                        <div class="col-md-6">


                                            <a href="{{ route('claim history') }}"
                                                class="btn btn-success btn-block">View
                                                Claim
                                                History</a>


                                        </div>
                                    </div>


                                </div> <!-- End -->

                            </div>
                        </div>
                    </div>


                @endif
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
                $(document).ready(function() {
                    $('#myTableAll').DataTable();
                });

                function handShake(val) {


                    var route;

                    if (val == 'requestforrefund') {

                        var formData = new FormData(formElem);


                        route = "{{ URL('/api/v1/requestforrefund') }}";

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
                                    $('#cardSubmit').text('Please wait...');
                                },
                                success: function(result) {
                                    console.log(result);

                                    $('#cardSubmit').text('Submit');

                                    if (result.status == 200) {
                                        swal("Success", result.message, "success");
                                        setTimeout(function() {
                                            location.href = "{{ route('my account') }}";
                                        }, 5000);
                                    } else {
                                        swal("Oops", result.message, "error");
                                    }

                                },
                                error: function(err) {
                                    swal("Oops", err.responseJSON.message, "error");

                                }

                            });
                        });

                    } else if (val == "deletebank") {

                        // Ask Are you sure

                        swal({
                                title: "Are you sure you want to delete bank account?",
                                text: "This bank account will be deleted and can not be recovered!",
                                icon: "warning",
                                buttons: true,
                                dangerMode: true,
                            })
                            .then((willDelete) => {
                                if (willDelete) {

                                    // Run Ajax

                                    var thisdata = {
                                        id: $("#bank_id").val()
                                    };

                                    route = "{{ URL('/api/v1/deletebank') }}";

                                    Pace.restart();
                                    Pace.track(function() {
                                        setHeaders();
                                        jQuery.ajax({
                                            url: route,
                                            method: 'post',
                                            data: thisdata,
                                            dataType: 'JSON',

                                            success: function(result) {

                                                if (result.status == 200) {
                                                    swal("Success", result.message, "success");
                                                    setTimeout(function() {
                                                        location.reload();
                                                    }, 2000);
                                                } else {
                                                    swal("Oops", result.message, "error");
                                                }

                                            },
                                            error: function(err) {
                                                swal("Oops", err.responseJSON.message, "error");

                                            }

                                        });
                                    });


                                } else {

                                }
                            });

                    }

                }


                function showForm(val) {
                    $(".cardform").removeClass('disp-0');
                    $(".pickCard").addClass('disp-0');
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
