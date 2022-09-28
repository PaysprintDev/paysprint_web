<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <!-- Favicon -->
    <link rel="icon" href="https://res.cloudinary.com/paysprint/image/upload/v1651130089/assets/paysprint_jpeg_black_bk_2_w4hzub_ioffkg.jpg" type="image/x-icon" />

    <link rel="stylesheet" type="text/css" href="{{ asset('pace/themes/orange/pace-theme-flash.css') }}" />
    <script src="https://kit.fontawesome.com/384ade21a6.js"></script>


    @if ($data['paymentgateway']->gateway == 'Stripe')
    <script src="https://js.stripe.com/v3/"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?version=3.52.1&features=fetch"></script>
    @endif

    @if ($data['paymentgateway']->gateway == 'PayPal')

    @if (env('APP_ENV') == 'local')
    <script src="https://www.paypal.com/sdk/js?client-id={{ env('PAYPAL_LOCAL_CLIENT_ID') }}&currency={{ Auth::user()->currencyCode }}">
    </script>
    @else
    <script src="https://www.paypal.com/sdk/js?client-id={{ env('PAYPAL_CLIENT_ID') }}&currency={{ Auth::user()->currencyCode }}">
    </script>
    @endif


    @endif

    <title>PaySprint | Payment</title>

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
                                <li class="nav-item"> <a data-toggle="pill" href="{{ route('my account') }}" class="nav-link active "> <i class="fas fa-home"></i> Go Back </a> </li>
                            </ul>
                        </div> <!-- End -->
                        <!-- Credit card form content -->
                        <div class="tab-content">


                            <!-- credit card info-->
                            <div id="credit-card" class="tab-pane fade show active pt-3">
                                <form role="form" action="#" method="POST" id="formElem">
                                    @csrf

                                    @php
                                        $receiveCode = $data['paymentgateway']->code.'_'.uniqid();
                                    @endphp

                                    <div class="alert alert-info">


                                        You can Top up your wallet with PaySprint using Partner's Platform by following these Steps:
                                        <ul>
                                        <hr>
                                            <li>
                                                Identify the Partner's Nearby: <a href="{{ route('partner list') }}" target="_blank" style="font-weight: bold;">Click here to view</a>
                                            </li>
                                            <br>
                                            <li>
                                                Send money to PaySprint using the following details:
                                            </li>

                                        </ul>

                                        <div class="alert alert-primary">
                                                    <h4>Receiver's Details</h4>
                                                    <hr>
                                                    <table class="table table-hover table-responsive">
                                                        <tr>
                                                            <td>Receiver's ID: </td>
                                                            <td><strong>{{ $receiveCode }}</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Receiver's Name: </td>
                                                            <td><strong>PaySprint Inc.</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Receiver's Firstname: </td>
                                                            <td><strong>PaySprint Inc.</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Receiver's Lastname: </td>
                                                            <td><strong></strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Receiver's Address: </td>
                                                            <td><strong>PaySprint International, <br>10 George St. North, <br>Brampton. ON. L6X1R2. Canada</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Receiver's City: </td>
                                                            <td><strong>Brampton, Ontario</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Receiver's Country: </td>
                                                            <td><strong>Canada</strong></td>
                                                        </tr>
                                                    </table>
                                                </div>

                                            <ul>
                                            <hr>
                                               <h3>
                                                 <strong>After sending the money to PaySprint</strong>
                                               </h3>
                                            <br>
                                            <li>
                                                Scroll down and select the partner option you paid from, type the Transaction ID and Amount sent to PaySprint
                                            </li>
                                            <br>
                                            <li>
                                                Submit
                                            </li>
                                            <hr>

                                            Please allow up to 24 hours for the funds to show in your wallet
                                        </ul>
                                    </div>


                                    <div class="form-group">
                                        <label for="gateway">
                                            <h6>Select Partner</h6>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-append"> <span class="input-group-text text-muted">
                                                    <img src="https://img.icons8.com/cotton/20/000000/money--v4.png" />
                                                </span> </div>
                                            <select name="gateway" id="gateway" class="form-control" required>
                                                <option value="PaySprint">Select option</option>

                                                @foreach ($data['partner'] as $partners)
                                                <option value="{{ $partners }}">{{ $partners }}</option>
                                                @endforeach

                                            </select>

                                        </div>
                                    </div>


                                     <div class="form-group"> <label for="amount">
                                            <h6>Transaction ID</h6>
                                        </label>
                                        <div class="input-group">
                                             <input type="number" step="{{ time() }}" min="{{ time() }}" name="transaction_id" id="transaction_id" class="form-control" required>
                                             <input type="hidden" name="receiver_code" id="receiver_code" class="form-control" value="{{ $receiveCode }}">
                                        </div>

                                    </div>

                                        <div class="moexResponse"></div>


                                     <div class="form-group"> <label for="amount">
                                            <h6>Description</h6>
                                        </label>
                                        <div class="input-group">
                                             <input type="text" name="description" id="description" class="form-control">
                                        </div>
                                    </div>


                                    <div class="form-group"> <label for="amount">
                                            <h6>Amount to add to wallet</h6>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-append"> <span class="input-group-text text-muted">
                                                    {{ $data['currencyCode']->currencySymbol }} </span> </div> <input type="number" min="0.00" step="0.01" name="amount" id="transfer_amount" class="form-control" required readonly>

                                            <input type="hidden" name="currencyCode" class="form-control" id="curCurrency" value="{{ $data['currencyCode']->currencyCode }}" readonly>
                                            <input type="hidden" name="name" class="form-control" id="nameInput" value="{{ Auth::user()->name }}" readonly>
                                            <input type="hidden" name="phone" class="form-control" id="phoneInput" value="{{ Auth::user()->telephone }}" readonly>
                                            <input type="hidden" name="api_token" class="form-control" id="apiTokenInput" value="{{ Auth::user()->api_token }}" readonly>
                                            <input type="hidden" name="email" class="form-control" id="emailInput" value="{{ Auth::user()->email }}" readonly>

                                            <input type="hidden" name="paymentToken" class="form-control" id="paymentToken" value="" readonly>

                                            <input type="hidden" name="mode" class="form-control" id="mode" value="live" readonly>

                                        </div>
                                    </div>


                                    <div class="card-footer"> <button type="button" onclick="handShake('partneraddmoney')" class="subscribe btn btn-info btn-block shadow-sm cardSubmit">
                                            Submit
                                        </button></div>


                            </form>
                        </div>



                    </div> <!-- End -->

                </div>
            </div>
        </div>
    </div>


    <script src="{{ asset('js/jquery-1.12.0.min.js') }}"></script>

    @include('include.message')


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous">
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.26.1/axios.min.js"
    integrity="sha512-bPh3uwgU5qEMipS/VOmRqynnMXGGSRv+72H/N260MQeXZIK4PG48401Bsby9Nq5P5fz7hy5UGNmC/W1Z51h2GQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="{{ asset('pace/pace.min.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.25.0/axios.min.js"></script>


    <script>
        function handShake(val) {

            var route;

            var formData;

            if (val == 'partneraddmoney') {
                formData = new FormData(formElem);
                route = "{{ URL('/api/v1/partneraddmoneytowallet') }}";

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
                            console.log(result);

                            $('.cardSubmit').text('Submit');

                            if (result.status == 200) {
                                swal("Success", result.message, "success");
                                setTimeout(function() {
                                    location.href = "{{ route('my account') }}";
                                }, 2000);
                            } else {
                                swal("Oops", result.message, "error");
                            }

                        },
                        error: function(err) {
                            $('.cardSubmit').text('Submit');
                            swal("Oops", err.responseJSON.message, "error");

                        }

                    });
                });

            }


        }

        $('#transaction_id').keyup(async function() {

            $('.moexResponse').html('');

            try {
                const transactionId = $('#transaction_id').val();

                if (transactionId !== null && transactionId.length > 5) {

                    var config = {
                    method: 'post',
                    url: "{{ URL('/api/v1/confirmtransaction') }}",
                    data: {transactionId}
                };


                const response = await axios(config);

                $('.moexResponse').removeClass('disp-0');

                if(response.data.data.length === 0){
                    $('.moexResponse').removeClass('alert alert-info');
                        $('.moexResponse').addClass('alert alert-danger');
                    $('.moexResponse').html('<b>Invalid Transaction ID!</b>. Please check your transaction ID and try again.');
                }
                else{
                    $('.moexResponse').removeClass('alert alert-danger');
                    $('.moexResponse').addClass('alert alert-info');
                    $('.moexResponse').html(`
                        <ul>
                            <li><b>Transaction ID:</b> ${response.data.data.transactionId}</li>
                            <li><b>Name:</b> ${response.data.data.sender}</li>
                            <li><b>Bank Deposit:</b> ${response.data.data.bankDeposit}</li>
                            <li><b>Amount Sent:</b> ${response.data.data.currencySent+' '+Number(response.data.data.amountSent).toFixed(4)}</li>
                        </ul>
                    `);

                    $('#transfer_amount').val(Number(response.data.data.amountSent).toFixed(4));

                }


                }

            } catch (error) {
                $('.moexResponse').addClass('alert alert-danger');
                $('.moexResponse').removeClass('disp-0');
                console.log(error);
            }







        });


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
