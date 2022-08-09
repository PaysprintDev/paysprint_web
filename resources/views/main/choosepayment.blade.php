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

    <title>PaySprint | Wallet</title>

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
                <h1 class="display-4">Select Add Money Method</h1>
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

                            <!-- Payment Option-->
                            <div class="row justify-content-center mt-3">
                                <div class="col-md-6">
                                    <div class="card" style="width: 100%;">
                                        <div class="card-body">
                                            <h5 class="card-title text-center">PaySprint</h5>
                                            <p class="card-text text-center"><strong>24hrs - 48hrs Deposit
                                                    Period</strong></p>
                                            <p class="card-text text-center" style="font-size: 12px; font-style:italic">
                                                ( Collection Fee:
                                                5%)</p>
                                            <a href="{{ route('Add Money') }}"
                                                class="btn btn-primary form-control">Continue</a>
                                        </div>
                                    </div>
                                </div>

                                @if(isset($data['partner']))
                                <div class="col-md-6">
                                    <div class="card" style="width: 100%;">
                                        <div class="card-body">
                                            <h5 class="card-title text-center">Partners</h5>
                                            <p class="card-text text-center"><strong>Within 24hrs Deposit
                                                    Period</strong></p>
                                            <p class="card-text text-center" style="font-size: 12px; font-style:italic">
                                                ( Collection Fee:
                                                5%)</p>
                                            <a href="{{ route('partner payment') }}"
                                                class="btn btn-primary form-control">Continue</a>
                                        </div>
                                    </div>
                                </div>
                                @endif

                            </div>

                            <!-- End Payment Option -->

                        </div>
                    </div>
                </div>
            </div>


            <script src="{{ asset('js/jquery-1.12.0.min.js') }}"></script>

            @include('include.message')


            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js"
                integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG"
                crossorigin="anonymous">
            </script>

            <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

            <script src="{{ asset('pace/pace.min.js') }}"></script>
            <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>



            {{-- <script>
                $(document).ready(function() {
                    $('#myTableAll').DataTable();
                    $('#myTableCredit').DataTable();
                    $('#myTableDebit').DataTable();

                    $('#orgpaycreditcard').attr('value', '0');
                    // Run Ajax
                    currencyConvert();
                });

                $("#payment_method").change(function() {

                    if ($("#payment_method").val() == "EXBC Card") {
                        $(".bizInfo").removeClass('disp-0');


                        $(".bank_info").addClass('disp-0');
                        $(".card_info").removeClass('disp-0');

                        $("#accountname").val("NILL");
                        $('#account_number').attr('value', '0');
                        $("#bank_name").val("NILL");

                    } else {
                        $(".bizInfo").addClass('disp-0');

                        $(".bank_info").removeClass('disp-0');
                        $(".card_info").addClass('disp-0');

                        $('#orgpaycreditcard').attr('value', '0');

                    }
                });


                function currencyConvert() {

                    $("#conversionamount").val("");

                    var currency = "{{ $data['currencyCode']->currencyCode }}";
                    var route = "{{ URL('Ajax/getconversion') }}";
                    var thisdata = {
                        currency: currency,
                        amount: $("#amount_to_receive").val(),
                        val: "receive"
                    };

                    setHeaders();
                    jQuery.ajax({
                        url: route,
                        method: 'post',
                        data: thisdata,
                        dataType: 'JSON',
                        success: function(result) {

                            if (result.message == "success") {
                                $("#conversionamount").val(result.data);
                            } else {
                                $("#conversionamount").val("");
                            }


                        }

                    });
                }


                function handShake(val, ref_code) {

                    var route;

                    if (val == 'claimmoney') {

                        var formData = new FormData();
                        var spin = $('#btn' + ref_code);

                        formData.append('reference_code', $('#reference_code').val());


                        route = "{{ URL('/api/v1/claimmoney') }}";

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
                                    spin.removeClass('disp-0');
                                },
                                success: function(result) {
                                    spin.addClass('disp-0');
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
                                    spin.addClass('disp-0');
                                    swal("Oops", err.responseJSON.message, "error");

                                }

                            });
                        });

                    }

                }


                function comingSoon(val) {
                    if (val == 'bank') {
                        swal('Feature available soon', 'Add a new bank account will be available soon', 'info');
                    } else {
                        swal('Hey', 'This feature is coming soon', 'info');

                    }
                }

                function idvResponse(response) {
                    swal('Oops!', response, 'error');
                }

                function restriction(val, name) {
                    $('.specialText').addClass("disp-0");
                    if (val == "withdrawal") {
                        swal('Hello ' + name, 'Your account need to be verified before you can make withdrawal', 'info');
                    } else if (val == "specialinfo") {
                        $('.specialText').removeClass("disp-0");
                    }
                }


                //Set CSRF HEADERS
                function setHeaders() {
                    jQuery.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}",
                            'Authorization': "Bearer " + "{{ Auth::user()->api_token }}"
                        }
                    });
                }
            </script> --}}

</body>

</html>