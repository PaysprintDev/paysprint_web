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
    <link rel="icon" href="https://res.cloudinary.com/pilstech/image/upload/v1602675914/paysprint_icon_png_ol2z3u.png"
        type="image/x-icon" />

    <link rel="stylesheet" type="text/css" href="{{ asset('pace/themes/orange/pace-theme-flash.css') }}" />

    <script src="https://kit.fontawesome.com/384ade21a6.js"></script>

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">



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
            <div class="col-lg-6 mx-auto">
                <div class="card ">
                    <div class="card-header">
                        <div class="bg-white shadow-sm pt-4 pl-2 pr-2 pb-2">
                            <!-- Credit card form tabs -->
                            <ul role="tablist" class="nav bg-light nav-pills rounded nav-fill mb-3">
                                <li class="nav-item" onclick="window.history.back()"> <a data-toggle="pill"
                                        href="{{ route('invoice') }}" class="nav-link active "> <i
                                            class="fas fa-home"></i> Go Back </a> </li>

                            </ul>
                        </div> <!-- End -->
                        <!-- Credit card form content -->
                        <div class="tab-content">


                            <!-- credit card info-->
                            <div id="credit-card" class="tab-pane fade show active pt-3">

                                <form role="form" action="#" method="POST" id="formElem">
                                    @csrf

                                    <div class="form-group">
                                        <label for="organization">
                                            <h6>Individual Name or Business Name</h6> <small> As
                                                written in the invoice</small>
                                        </label>
                                        <input type="text" class="form-control"
                                            placeholder="Individual Name or Business Name" name="receivers_name"
                                            id="receivers_name">
                                    </div>


                                    <div class="form-group">
                                        <label for="organization">
                                            <h6>Select Country</h6> <small> The country where receiver is based</small>
                                        </label>
                                        <select name="country" id="country" class="form-control">
                                            @if (count($data['allcountry']) > 0)

                                                <option value="">Select Country</option>
                                                @foreach ($data['allcountry'] as $countries)
                                                    <option value="{{ $countries->name }}">{{ $countries->name }}
                                                    </option>
                                                @endforeach

                                            @else
                                                <option value="">No available country</option>
                                            @endif
                                        </select>
                                    </div>


                                    <div class="form-group">


                                        {{-- Add FX Walllet Selection Here... --}}

                                        <div class="form-group"> <label for="select_wallet">
                                                <h6>Select Preferred Wallet</h6>
                                            </label>
                                            <div class="input-group">
                                                <select name="select_wallet" id="select_wallet" class="form-control"
                                                    required>
                                                    <option value="">Select wallet</option>
                                                    <option value="Wallet">Wallet</option>
                                                    <option value="FX Wallet">FX Wallet</option>
                                                </select>

                                            </div>
                                        </div>

                                        <div class="form-group walletList disp-0"> <label for="escrow_id">
                                                <h6>Choose Currency</h6>
                                            </label>
                                            <div class="input-group">
                                                <select name="escrow_id" id="escrow_id" class="form-control">
                                                </select>

                                            </div>
                                        </div>


                                        {{-- End Add FX Wallet --}}


                                        <div class="alert alert-warning fxuserWallet disp-0">

                                        </div>


                                        <div class="alert alert-warning userWallet disp-0">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h4>
                                                        Wallet Balance
                                                    </h4>
                                                </div>
                                                <div class="col-md-12">
                                                    <h4>
                                                        {{ Auth::user()->currencySymbol . '' . number_format(Auth::user()->wallet_balance, 2) }}
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>




                                    </div>




                                    <div class="form-group"> <label for="amount">
                                            <h6>Amount</h6>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-append"> <span
                                                    class="input-group-text text-muted currencySymb">
                                                    {{ Auth::user()->currencySymbol }} </span> </div> <input
                                                type="number" min="0.00" step="0.01" name="amount" id="amount"
                                                class="form-control" required>

                                        </div>
                                    </div>


                                    <div class="form-group"> <label for="purpose">
                                            <h6>Purpose</h6>
                                        </label>
                                        <div class="input-group">
                                            <input type="text" name="purpose" id="purpose" class="form-control"
                                                required>

                                        </div>
                                    </div>



                                    <div class="form-group"> <label for="amount">
                                            <h6>Upload Invoice Slip</h6>
                                        </label>

                                        <div class="input-group">
                                            <input type="file" name="file" id="file" class="form-control" required>
                                        </div>

                                    </div>


                                    {{-- Add Beneficiary --}}


                                    <div class="form-group"> <label for="beneficiary_id">
                                            <h6>Receiver's Account Details</h6>
                                        </label>
                                        <div class="input-group">
                                            <select name="beneficiary_id" id="beneficiary_id" class="form-control"
                                                required data-live-search="true">
                                                <option value="">Receiver's Account Details</option>

                                                @if (count($data['allbeneficiary']) > 0)
                                                    <option value="create_new">Create new receiver</option>
                                                    @foreach ($data['allbeneficiary'] as $beneficiary)
                                                        <option value="{{ $beneficiary->id }}">
                                                            {{ $beneficiary->account_name . ' (' . $beneficiary->bank_name . ' - ' . $beneficiary->account_number . ')' }}
                                                        </option>

                                                    @endforeach


                                                @else
                                                    <option value="create_new">Create new receiver</option>
                                                @endif

                                            </select>

                                        </div>
                                    </div>


                                    <div class="beneficiary_details disp-0">
                                        <div class="form-group"> <label for="account_name">
                                                <h6>Beneficiary Account Name</h6>
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-append"> <span
                                                        class="input-group-text text-muted">
                                                        <img
                                                            src="https://img.icons8.com/material-outlined/20/000000/guest-male.png" />
                                                    </span> </div> <input type="text" name="account_name"
                                                    id="account_name" class="form-control" value="">

                                            </div>
                                        </div>

                                        <div class="form-group"> <label for="account_number">
                                                <h6>Beneficiary Bank Account Number</h6>
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-append"> <span
                                                        class="input-group-text text-muted currencySymb">
                                                        <img
                                                            src="https://img.icons8.com/ios/20/000000/dialing-phone.png" />
                                                    </span> </div> <input type="text" name="account_number"
                                                    id="account_number" class="form-control" value="">

                                            </div>
                                        </div>


                                        <div class="form-group"> <label for="bank_name">
                                                <h6>Beneficiary Bank Name</h6>
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-append"> <span
                                                        class="input-group-text text-muted currencySymb">
                                                        <img
                                                            src="https://img.icons8.com/external-prettycons-lineal-prettycons/20/000000/external-bank-essentials-prettycons-lineal-prettycons.png" />
                                                    </span> </div> <input type="text" name="bank_name" id="bank_name"
                                                    class="form-control" value="">

                                            </div>
                                        </div>


                                        <div class="form-group"> <label for="sort_code">
                                                <h6>Beneficiary Bank Sort Code</h6>
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-append"> <span
                                                        class="input-group-text text-muted currencySymb">
                                                        <img
                                                            src="https://img.icons8.com/external-prettycons-lineal-prettycons/20/000000/external-bank-essentials-prettycons-lineal-prettycons.png" />
                                                    </span> </div> <input type="text" name="sort_code" id="sort_code"
                                                    class="form-control" value="">

                                            </div>
                                        </div>
                                    </div>





                                    {{-- End Beneficiary --}}


                                    <div class="form-group"> <label for="transaction_pin">
                                            <h6>Transaction Pin</h6>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-append"> <span class="input-group-text text-muted">
                                                    <i class="fas fa-lock"></i> </span> </div> <input type="password"
                                                name="transaction_pin" id="transaction_pin" class="form-control"
                                                maxlength="4" required>

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <strong><span class="text-danger wallet-info"></span></strong>
                                    </div>

                                    <div class="form-group">
                                        <div class="commissionInfo"></div>
                                    </div>

                                    {{-- Upload File --}}


                                    <div class="card-footer"> <button type="button"
                                            onclick="handShake('crossborder')"
                                            class="subscribe btn btn-primary btn-block shadow-sm sendmoneyBtn"> Pay
                                            Invoice </button></div>



                                </form>
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

        <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

        <script src="{{ asset('pace/pace.min.js') }}"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


        <script>
            $(function() {
                $('[data-toggle="tooltip"]').tooltip();
                $(".sendmoneyBtn").attr("disabled", true);
                $("#amount").on("keyup", function() {
                    runCommission();
                });


                $('#beneficiary_id').selectpicker();

            });


            $('#beneficiary_id').change(function() {
                if ($('#beneficiary_id').val() == "create_new") {
                    $('.beneficiary_details').removeClass('disp-0');
                } else {
                    $('.beneficiary_details').addClass('disp-0');
                }
            })


            $('#country').change(function() {

                if ($("#select_wallet").val() == "FX Wallet") {
                    $('.fxuserWallet').removeClass('disp-0');
                    $('.walletList').removeClass('disp-0');
                    $('.userWallet').addClass('disp-0');
                    // Do Ajax and Render Selected Wallet Balance
                    var country = $('#country').val();

                    var routeString = `/api/v1/fxwallets?country=${country}`;

                    var route = routeString;


                    setHeaders();
                    jQuery.ajax({
                        url: route,
                        method: 'get',
                        dataType: 'JSON',
                        beforeSend: function() {
                            $('#escrow_id').html(`<option value="">Please wait...</option>`);
                        },
                        success: function(result) {
                            $('#escrow_id').html(`<option value="">Select Currency</option>`);
                            // Get Result and render value
                            if (result.status == 200) {
                                // Loop Value
                                $.each(result.data, (v, k) => {
                                    $('#escrow_id').append(
                                        `<option value="${k.escrow_id}">Country: ${k.country} | Currency: ${k.currencyCode}</option>`
                                    );



                                });


                                if ($('#amount').val() != "") {
                                    runCommission();
                                }


                            } else {
                                $('#escrow_id').append(
                                    `<option value="">${result.message}</option>`);
                            }

                        },
                        error: function(error) {
                            $('#escrow_id').html(``);
                            $('#escrow_id').append(
                                `<option value="">${error.responseJSON.message}</option>`);
                        }

                    });

                } else {
                    // Return Primary wallet Balance
                    $('.userWallet').removeClass('disp-0');
                    $('.walletList').addClass('disp-0');
                    $('.fxuserWallet').addClass('disp-0');
                }

            });

            $("#select_wallet").change(function() {
                if ($("#select_wallet").val() == "FX Wallet") {
                    $('.fxuserWallet').removeClass('disp-0');
                    $('.walletList').removeClass('disp-0');
                    $('.userWallet').addClass('disp-0');
                    // Do Ajax and Render Selected Wallet Balance
                    var country = $('#country').val();

                    var routeString = `/api/v1/fxwallets?country=${country}`;

                    var route = routeString;


                    setHeaders();
                    jQuery.ajax({
                        url: route,
                        method: 'get',
                        dataType: 'JSON',
                        beforeSend: function() {
                            $('#escrow_id').html(`<option value="">Please wait...</option>`);
                        },
                        success: function(result) {
                            $('#escrow_id').html(`<option value="">Select Currency</option>`);
                            // Get Result and render value
                            if (result.status == 200) {
                                // Loop Value
                                $.each(result.data, (v, k) => {
                                    $('#escrow_id').append(
                                        `<option value="${k.escrow_id}">Country: ${k.country} | Currency: ${k.currencyCode}</option>`
                                    );



                                });


                                if ($('#amount').val() != "") {
                                    runCommission();
                                }


                            } else {
                                $('#escrow_id').append(
                                    `<option value="">${result.message}</option>`);
                            }

                        },
                        error: function(error) {
                            $('#escrow_id').html(``);
                            $('#escrow_id').append(
                                `<option value="">${error.responseJSON.message}</option>`);
                        }

                    });

                } else {
                    // Return Primary wallet Balance
                    $('.userWallet').removeClass('disp-0');
                    $('.walletList').addClass('disp-0');
                    $('.fxuserWallet').addClass('disp-0');
                }
            });


            $("#escrow_id").change(function() {

                // Do Ajax and Render Selected Wallet Balance

                var route = "{{ URL('/api/v1/getthisfxwallets') }}";

                $('.currencySymb').text("");

                setHeaders();
                jQuery.ajax({
                    url: route,
                    method: 'get',
                    data: {
                        escrow_id: $("#escrow_id").val()
                    },
                    dataType: 'JSON',
                    beforeSend: function() {
                        $('.fxuserWallet').html(
                            `<div class="row"><div class="col-md-12"><h4>Please wait...</h4></div><div class="col-md-12"><h4>-</h4></div></div>`
                        );
                    },
                    success: function(result) {

                        $('.fxuserWallet').html(
                            `<div class="row"><div class="col-md-12"><h4>Please wait...</h4></div><div class="col-md-12"><h4>-</h4></div></div>`
                        );
                        // Get Result and render value
                        if (result.status == 200) {
                            $('.fxuserWallet').html(
                                `<div class="row"><div class="col-md-12"><h4>Wallet Balance</h4></div><div class="col-md-12"><h4>${result.data.currencySymbol+' '+parseFloat(result.data.wallet_balance).toFixed(4)}</h4></div></div>`
                            );

                            $('.currencySymb').text(result.data.currencySymbol);


                        } else {
                            $('.fxuserWallet').html(
                                `<div class="row"><div class="col-md-12"><h4>Wallet Balance</h4></div><div class="col-md-12"><h4>${result.message}</h4></div></div>`
                            );
                        }
                    },
                    error: function(error) {
                        $('#escrow_id').html(``);


                        $('.fxuserWallet').html(
                            `<div class="row"><div class="col-md-12"><h4></h4></div><div class="col-md-12"><h4>${error.responseJSON.message}</h4></div></div>`
                        );
                    }

                });


            });


            function runCommission() {

                $(".sendmoneyBtn").attr("disabled", true);

                $('.commissionInfo').html("");
                var amount = $("#amount").val();

                var route = "{{ URL('Ajax/getwalletBalance') }}";
                var thisdata = {
                    amount: amount,
                    pay_method: 'Wallet',
                    currency: "{{ Auth::user()->currencyCode }}"
                };


                Pace.restart();
                Pace.track(function() {

                    setHeaders();

                    jQuery.ajax({
                        url: route,
                        method: 'post',
                        data: thisdata,
                        dataType: 'JSON',
                        beforeSend: function() {
                            $('.commissionInfo').addClass('');
                        },

                        success: function(result) {


                            if (result.message == "success") {

                                $(".wallet-info").html(result.walletCheck);

                                $(".sendmoneyBtn").attr("disabled", false);

                                $('.commissionInfo').addClass('alert alert-success');
                                $('.commissionInfo').removeClass('alert alert-danger');

                                $('.commissionInfo').html(
                                    "<ul><li><span style='font-weight: bold;'>Kindly note that a total amount of: " +
                                    $.trim($('.currencySymb').text().replace(/[\t\n]+/g, ' ')) + "" +
                                    $("#amount").val() + " will be deducted from your " + $(
                                        '#select_wallet').val() + ".</span></li></li></ul>");

                            }


                        },
                        error: function(err) {
                            swal("Oops", err.responseJSON.message, "error");
                        }

                    });

                });
            }



            function checkBoxConfirm() {


                var convertRate = $('#convertRate').prop("checked");


                if (convertRate == true) {
                    // Enable button
                    $(".sendmoneyBtn").attr("disabled", false);
                } else {
                    // Disable button
                    $(".sendmoneyBtn").attr("disabled", true);

                }

            }


            function handShake(val) {

                var route;

                var formData = new FormData(formElem);

                if ('crossborder') {

                    route = "{{ URL('/api/v1/crossborder') }}";

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
                                $('.sendmoneyBtn').text('Please wait...');
                            },
                            success: function(result) {

                                $('.sendmoneyBtn').text('Pay Invoice');

                                if (result.status == 200) {
                                    swal("Success", result.message, "success");

                                    if (result.route == "fx") {
                                        setTimeout(function() {
                                            location.href =
                                                "{{ route('paysprint currency exchange') }}";
                                        }, 7000);
                                    } else {
                                        setTimeout(function() {
                                            location.href = "{{ route('my account') }}";
                                        }, 7000);
                                    }


                                } else {
                                    swal("Oops", result.message, "error");
                                }

                            },
                            error: function(err) {
                                $('.sendmoneyBtn').text('Pay Invoice');
                                swal("Oops", err.responseJSON.message, "error");

                            }

                        });
                    });

                }

            }



            function restriction(val, name) {
                if (val == "payinvoice") {
                    swal('Hello ' + name, 'Your account need to be verified before you can pay invoice', 'info');
                }
            }

            //Set CSRF HEADERS
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
