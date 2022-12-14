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

    <title>PaySprint | Card</title>

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
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-4">
                    {{ Request::get('card') == 'Debit Card' ? 'Debit VISA/Mastercard' : Request::get('card') }}</h1>
            </div>
        </div> <!-- End -->
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card ">
                    <div class="card-header">
                        <div class="bg-white shadow-sm pt-4 pl-2 pr-2 pb-2">
                            <!-- Credit card form tabs -->
                            <ul role="tablist" class="nav bg-light nav-pills rounded nav-fill mb-3">
                                <li class="nav-item"> <a data-toggle="pill" href="{{ route('my account') }}"
                                        class="nav-link active "> <i class="fas fa-home"></i> Go Back </a> </li>
                                {{-- <li class="nav-item"> <a data-toggle="pill" href="#paypal" class="nav-link "> <i class="fab fa-paypal mr-2"></i> Debit Card </a> </li>
                                <li class="nav-item"> <a data-toggle="pill" href="#net-banking" class="nav-link "> <i class="fas fa-mobile-alt mr-2"></i> EXBC Card </a> </li> --}}
                            </ul>
                        </div> <!-- End -->
                        <!-- Credit card form content -->
                        <div class="tab-content">

                            <!-- credit card info-->
                            <div id="credit-card" class="tab-pane fade show active pt-3">




                                <div class="form-group row">

                                    @if (count($data['getCard']) > 0)

                                        @foreach ($data['getCard'] as $mycard)
                                            @switch($mycard->card_type)
                                                @case('Mastercard')
                                                    @php
                                                        $alertInfo = 'alert-danger';
                                                        $cardImage = '<img src="https://img.icons8.com/color/30/000000/mastercard.png"/>';
                                                    @endphp
                                                @break

                                                @case('Visa')
                                                    @php
                                                        $alertInfo = 'alert-info';
                                                        $cardImage = '<img src="https://img.icons8.com/color/30/000000/visa.png"/>';
                                                    @endphp
                                                @break

                                                @default
                                                    @php
                                                        $alertInfo = 'alert-success';
                                                        $cardImage = '<img src="https://img.icons8.com/fluent/30/000000/bank-card-back-side.png"/>';
                                                    @endphp
                                            @endswitch





                                            @if (Request::get('card') == 'Credit Card')
                                                @if ($mycard->card_provider == 'Credit Card')
                                                    <div class="col-md-6">
                                                        <div class="alert {{ $alertInfo }}">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <h4>
                                                                        {{ wordwrap(substr($mycard->card_number, 0, 4) . str_repeat('*', strlen($mycard->card_number) - 8) . substr($mycard->card_number, -4), 4, ' - ', true) }}


                                                                    </h4>
                                                                </div>
                                                                <br>
                                                                <div class="col-md-6">
                                                                    <h6>
                                                                        Expiry:
                                                                        {{ $mycard->month . '/' . $mycard->year }}
                                                                    </h6>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <h6>
                                                                        CVV: ***
                                                                    </h6>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <h5>

                                                                        {{ strlen($mycard->card_name) < 18 ? strtoupper($mycard->card_name) : substr(strtoupper($mycard->card_name), 0, 18) . '...' }}
                                                                    </h5>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <input type="hidden" name="card_id"
                                                                        value="{{ $mycard->id }}"
                                                                        id="card_id{{ $mycard->id }}">
                                                                    <a href="{{ route('Edit card', $mycard->id) }}"
                                                                        title="Edit Card"><i
                                                                            class="far fa-edit text-secondary"></i></a>
                                                                    <a href="javascript:void(0)" title="Delete Card"
                                                                        onclick="delhandShake('deletecard', '{{ $mycard->id }}')"><i
                                                                            class="far fa-trash-alt text-danger"></i></a>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    {!! $cardImage !!}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @elseif (Request::get('card') == 'Debit Card')
                                                @if ($mycard->card_provider == 'Debit Card')
                                                    <div class="col-md-6">
                                                        <div class="alert {{ $alertInfo }}">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <h4>
                                                                        {{ wordwrap(substr($mycard->card_number, 0, 4) . str_repeat('*', strlen($mycard->card_number) - 8) . substr($mycard->card_number, -4), 4, ' - ', true) }}
                                                                    </h4>
                                                                </div>
                                                                <br>
                                                                <div class="col-md-6">
                                                                    <h6>
                                                                        Expiry:
                                                                        {{ $mycard->month . '/' . $mycard->year }}
                                                                    </h6>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <h6>
                                                                        CVV: ***
                                                                    </h6>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <h5>

                                                                        {{ strlen($mycard->card_name) < 18 ? strtoupper($mycard->card_name) : substr(strtoupper($mycard->card_name), 0, 18) . '...' }}
                                                                    </h5>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <input type="hidden" name="card_id"
                                                                        value="{{ $mycard->id }}"
                                                                        id="card_id{{ $mycard->id }}">
                                                                    <a href="{{ route('Edit card', $mycard->id) }}"
                                                                        title="Edit Card"><i
                                                                            class="far fa-edit text-secondary"></i></a>
                                                                    <a href="javascript:void(0)" title="Delete Card"
                                                                        onclick="delhandShake('deletecard', '{{ $mycard->id }}')"><i
                                                                            class="far fa-trash-alt text-danger"></i></a>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    {!! $cardImage !!}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @elseif (Request::get('card') == 'Prepaid Card')
                                                @if ($mycard->card_provider != 'Credit Card')
                                                    <div class="col-md-6">

                                                        <div class="alert {{ $alertInfo }}">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <h4>
                                                                        {{ wordwrap(substr($mycard->card_number, 0, 4) . str_repeat('*', strlen($mycard->card_number) - 8) . substr($mycard->card_number, -4), 4, ' - ', true) }}
                                                                    </h4>
                                                                </div>
                                                                <br>
                                                                <div class="col-md-6">
                                                                    <h6>
                                                                        Expiry:
                                                                        {{ $mycard->month . '/' . $mycard->year }}
                                                                    </h6>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <h6>
                                                                        CVV: ***
                                                                    </h6>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <h5>

                                                                        {{ strlen($mycard->card_name) < 18 ? strtoupper($mycard->card_name) : substr(strtoupper($mycard->card_name), 0, 18) . '...' }}
                                                                    </h5>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <input type="hidden" name="card_id"
                                                                        value="{{ $mycard->id }}"
                                                                        id="card_id{{ $mycard->id }}">
                                                                    <a href="{{ route('Edit card', $mycard->id) }}"
                                                                        title="Edit Card"><i
                                                                            class="far fa-edit text-secondary"></i></a>
                                                                    <a href="javascript:void(0)" title="Delete Card"
                                                                        onclick="delhandShake('deletecard', '{{ $mycard->id }}')"><i
                                                                            class="far fa-trash-alt text-danger"></i></a>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    {!! $cardImage !!}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif
                                        @endforeach
                                    @else
                                        <div class="col-md-12">
                                            <div class="alert alert-info">
                                                <center>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h4>
                                                                No Card Found!!
                                                            </h4>
                                                            <p>
                                                                You are yet to add any card, start adding your card by
                                                                clicking the add new card below.
                                                            </p>
                                                        </div>
                                                    </div>
                                                </center>
                                            </div>
                                        </div>

                                    @endif




                                </div>




                                <div class="form-group row pickCard">
                                    <div class="col-md-12">
                                        <button class="btn btn-secondary btn-block" onclick="showForm('card')">Add new
                                            Card <i class="fa fa-credit-card"></i></button>
                                    </div>
                                </div>



                                <div class="form-group cardform disp-0">
                                    <form action="#" method="POST" id="formElem">
                                        @csrf

                                        @if (Request::get('card') == 'Prepaid Card')

                                            <div class="form-group">
                                                <label for="card_name">Card Issuer</label>

                                                <div class="input-group">
                                                    <select name="card_provider" id="card_provider"
                                                        class="form-control" required>
                                                        <option value="">Select Card Issuer</option>
                                                        @if (count($data['cardIssuer']) > 0)
                                                            @foreach ($data['cardIssuer'] as $cardIssuers)
                                                                <option value="{{ $cardIssuers->issuer_card }}">
                                                                    {{ $cardIssuers->issuer_card . ' from ' . $cardIssuers->issuer_name }}
                                                                </option>
                                                            @endforeach
                                                        @else
                                                            <option value="EXBC Prepaid Card">EXBC Prepaid Card from
                                                                EXBC</option>
                                                        @endif

                                                    </select>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text text-muted"> <i
                                                                class="fas fa-credit-card"></i></span>
                                                    </div>
                                                </div>

                                            </div>

                                        @endif

                                        <div class="form-group">
                                            <label for="card_name">Name on Card</label>

                                            <div class="input-group"> <input type="text" name="card_name"
                                                    id="card_name" class="form-control" required>
                                                <div class="input-group-append">
                                                    <span class="input-group-text text-muted"> <i
                                                            class="far fa-user"></i></span>
                                                </div>
                                            </div>

                                        </div>

                                        {{-- <div class="form-group">
                                               <label for="card_name">Card Provider</label>

                                            <div class="input-group">
                                                <select name="card_provider" id="card_provider" class="form-control" required>
                                                    <option value="">Select card provider</option>
                                                    @if (Request::get('card') == 'Prepaid Card')
                                                        <option value="EXBC Prepaid Card">EXBC Prepaid Card</option>
                                                    @else
                                                        <option value="Credit Card">Credit Card</option>
                                                    @endif
                                                </select>
                                                <div class="input-group-append">
                                                    <span class="input-group-text text-muted"> <i class="fas fa-credit-card"></i></span>
                                                </div>
                                            </div>

                                           </div> --}}

                                        @if (Request::get('card') == 'Credit Card')
                                            <div class="form-group disp-0">
                                                <label for="card_name">Card Provider</label>

                                                <div class="input-group">
                                                    <select name="card_provider" id="card_provider"
                                                        class="form-control" required>
                                                        <option value="Credit Card" selected>Credit Card</option>

                                                    </select>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text text-muted"> <i
                                                                class="fas fa-credit-card"></i></span>
                                                    </div>
                                                </div>

                                            </div>
                                        @elseif(Request::get('card') == 'Debit Card')
                                            <div class="form-group disp-0">
                                                <label for="card_name">Card Provider</label>

                                                <div class="input-group">
                                                    <select name="card_provider" id="card_provider"
                                                        class="form-control" required>
                                                        <option value="Debit Card" selected>Debit Card</option>

                                                    </select>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text text-muted"> <i
                                                                class="fas fa-credit-card"></i></span>
                                                    </div>
                                                </div>

                                            </div>
                                        @endif






                                        <div class="form-group">
                                            <label for="card_number">Card Number</label>

                                            <div class="input-group"> <input type="text" name="card_number"
                                                    id="card_number" class="form-control" maxlength="16" required>
                                                <div class="input-group-append">
                                                    <span class="input-group-text text-muted"> <i
                                                            class="fas fa-money-check mx-1"></i> <i
                                                            class="fab fa-cc-mastercard mx-1"></i> <i
                                                            class="fab fa-cc-amex mx-1"></i> </span>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="form-group">

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="month">Month</label>

                                                    <div class="input-group">
                                                        <select name="month" id="month" class="form-control"
                                                            required>
                                                            <option value="01">January</option>
                                                            <option value="02">February</option>
                                                            <option value="03">March</option>
                                                            <option value="04">April</option>
                                                            <option value="05">May</option>
                                                            <option value="06">June</option>
                                                            <option value="07">July</option>
                                                            <option value="08">August</option>
                                                            <option value="09">September</option>
                                                            <option value="10">October</option>
                                                            <option value="11">November</option>
                                                            <option value="12">December</option>
                                                        </select>
                                                        <div class="input-group-append">
                                                            <span class="input-group-text text-muted"> <i
                                                                    class="fas fa-table"></i> </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="year">Year</label>

                                                    <div class="input-group">
                                                        <select name="year" id="year" class="form-control" required>
                                                            @for ($i = date('y'); $i <= date('y') + 10; $i++)
                                                                <option value="{{ $i }}">
                                                                    {{ '20' . $i }}</option>
                                                            @endfor
                                                        </select>
                                                        <div class="input-group-append">
                                                            <span class="input-group-text text-muted"> <i
                                                                    class="fas fa-calendar-week"></i> </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="month">CVV <small class="text-danger">3 digit at the
                                                            back of your card</small></label>

                                                    <div class="input-group">
                                                        <input type="password" name="cvv" id="cvv"
                                                            class="form-control" maxlength="3" required>
                                                        <div class="input-group-append">
                                                            <span class="input-group-text text-muted"> <i
                                                                    class="fas fa-closed-captioning"></i> </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>



                                        </div>


                                        <div class="form-group">
                                            <button type="button" class="btn btn-primary btn-block"
                                                onclick="handShake('addcard')" id="cardSubmit">Submit</button>
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
            <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>



            <script>
                function handShake(val) {

                    var route;

                    if (val == 'addcard') {

                        var formData = new FormData(formElem);


                        route = "{{ URL('/api/v1/addnewcard') }}";

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

                    }




                }

                function delhandShake(val, id) {
                    if (val == "deletecard") {

                        // Ask Are you sure

                        swal({
                                title: "Are you sure you want to delete card?",
                                text: "This card will be deleted and can not be recovered!",
                                icon: "warning",
                                buttons: true,
                                dangerMode: true,
                            })
                            .then((willDelete) => {
                                if (willDelete) {

                                    // Run Ajax

                                    var thisdata = {
                                        id: $("#card_id" + id).val()
                                    };

                                    route = "{{ URL('/api/v1/deletecard') }}";

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
