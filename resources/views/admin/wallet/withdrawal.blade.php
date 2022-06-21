@extends('layouts.dashboard')


@section('dashContent')
    <?php use App\Http\Controllers\ClientInfo; ?>
    <?php use App\Http\Controllers\User; ?>
    <?php use App\Http\Controllers\InvoicePayment; ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Withdraw Money
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Withdraw Money</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <div class="row">



                <div class="box-body">

                    <div class="col-lg-12 col-xs-12">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $data['getuserDetail']->currencySymbol . number_format($data['getuserDetail']->wallet_balance, 2) }}
                                </h3>

                                <p>Wallet Balance <br><br> <strong class="text-danger">Available Balance:
                                        {{ $data['getuserDetail']->currencySymbol . number_format($data['getuserDetail']->wallet_balance - $data['minimumWallet'], 2) }}</strong>
                                </p>

                            </div>
                            <div class="icon">
                                <i class="ion ion-pricetag"></i>
                            </div>
                            {{-- <a href="#" class="small-box-footer">View details <i class="fa fa-arrow-circle-right"></i></a> --}}
                        </div>
                    </div>

                    <div class="form-group cardform">
                        <form action="#" method="POST" id="formElem">
                            @csrf


                            <div class="form-group">
                                <label for="card_id">

                                    Select Card Type/ Bank Account
                                </label>
                                <select name="card_type" id="card_type" class="form-control" required>
                                    <option value="">Select option</option>
                                    {{-- <option value="Credit Card">Credit Card</option> --}}
                                    <option value="Prepaid Card">Prepaid Card</option>
                                    <option value="Bank Account">Bank Account</option>
                                </select>

                            </div>
                            <div class="form-group"> <label for="card_id">
                                    Select Card/Bank
                                </label>
                                <select name="card_id" id="card_id" class="form-control" required></select>
                            </div>



                            <div class="form-group">
                                <label for="amount">Amount to Withdraw</label>

                                <input type="number" min="0.00" max="10000.00" step="0.01" name="amount" id="amount"
                                    class="form-control" required>


                            </div>

                            <div class="form-group disp-0">
                                <p style="color: red; font-weight: bold;"><input type="checkbox" name="commission"
                                        id="commission" checked> Include fee</p>
                            </div>



                            <div class="form-group"> <label for="netwmount">
                                    Net Amount

                                </label>
                                <input type="text" name="amounttosend" class="form-control" id="amounttosend" value=""
                                    placeholder="0.00" readonly>
                            </div>


                            <div class="form-group"> <label for="netwmount">
                                    Fee
                                </label>
                                <input type="text" name="commissiondeduct" class="form-control" id="commissiondeduct"
                                    value="" placeholder="0.00" readonly>

                                <input type="hidden" name="totalcharge" class="form-control" id="totalcharge" value=""
                                    placeholder="0.00" readonly>

                            </div>


                            <div class="form-group disp-0"> <label for="netwmount">
                                    <h6>Currency Conversion <br><small class="text-info"><b>Exchange rate today
                                                according to currencylayer.com</b></small></h6>
                                    <p style="font-weight: bold;">
                                        {{ $data['getuserDetail']->currencyCode }} <=> CAD
                                    </p>
                                </label>
                                <div class="input-group">
                                    <input type="text" name="conversionamount" class="form-control" id="conversionamount"
                                        value="" placeholder="0.00" readonly>
                                </div>
                            </div>

                            <hr>

                            <div class="form-group">
                                <strong><span class="text-danger wallet-info"></span></strong>
                            </div>


                            <div class="form-group">
                                <div class="commissionInfo"></div>
                            </div>

                            @if ($data['getuserDetail']->transaction_pin != null)
                                <div class="form-group"> <label for="transaction_pin">
                                        Transaction Pin
                                    </label>
                                    <input type="password" name="transaction_pin" id="transaction_pin"
                                        class="form-control" maxlength="4" required>
                                </div>
                            @else
                                <hr>
                                <label>
                                    Set up transaction pin
                                </label>
                                <hr>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group"> <label for="new_transaction_pin">
                                                New Transaction Pin
                                            </label>
                                            <input type="password" name="transaction_pin" id="new_transaction_pin"
                                                class="form-control" maxlength="4" required>

                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group"> <label for="confirm_transaction_pin">
                                                Confirm Transaction Pin
                                            </label>
                                            <input type="password" name="confirm_transaction_pin"
                                                id="confirm_transaction_pin" class="form-control" maxlength="4" required>

                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group"> <label for="password">
                                                Provide Your Login Password <br> <small class="text-danger">We need to be
                                                    sure it's you</small>
                                            </label>
                                            <input type="password" name="password" id="password" class="form-control"
                                                required>

                                        </div>
                                    </div>
                                </div>
                            @endif

                            <input type="hidden" name="currencyCode" class="form-control" id="curCurrency"
                                value="{{ $data['getuserDetail']->currencyCode }}" readonly>

                            <input type="hidden" name="mode" class="form-control" id="mode" value="live" readonly>



                            <div class="form-group">
                                <button type="button" class="btn btn-primary btn-block withdrawmoneyBtn"
                                    onclick="handShake('withdrawmoney')">Withdraw Money</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>


        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <script src="{{ asset('js/jquery-1.12.0.min.js') }}"></script>

    @include('include.message')
    <script src="{{ asset('pace/pace.min.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $(function() {

            $("#amount").on("keyup", function() {
                runCommission();
            });


        });

        $('#card_type').change(function() {
            runCardType();
        });


        function runCardType() {

            $('#card_id').html("");

            var route = "{{ URL('/api/v1/getmycarddetail') }}";
            var thisdata = {
                card_provider: $('#card_type').val()
            };


            Pace.restart();
            Pace.track(function() {

                setHeaders();

                jQuery.ajax({
                    url: route,
                    method: 'get',
                    data: thisdata,
                    dataType: 'JSON',

                    success: function(result) {
                        if (result.message == "success") {
                            var res = result.data;

                            if (result.action == "Bank Account") {
                                $.each(res, function(v, k) {
                                    $('#card_id').append(
                                        `<option value="${k.id}">${k.bankName} - ${k.accountNumber}</option>`
                                        );
                                });
                            } else {
                                $.each(res, function(v, k) {
                                    $('#card_id').append(
                                        `<option value="${k.id}">${cardHide(k.card_number)} - ${k.card_provider}</option>`
                                        );
                                });
                            }




                        } else {
                            $('#card_id').append(
                                `<option value="">${$('#card_type').val()} not available</option>`);
                        }

                    },
                    error: function(err) {
                        $('#card_id').append(
                            `<option value="">${$('#card_type').val()} not available</option>`);
                        // swal("Oops", err.responseJSON.message, "error");
                    }

                });

            });

        }


        function cardHide(card) {
            let hideNum = [];
            for (let i = 0; i < card.length; i++) {
                if (i < card.length - 4) {
                    hideNum.push("*");
                } else {
                    hideNum.push(card[i]);
                }
            }
            return hideNum.join("");
        }

        function runCommission() {

            $('.commissionInfo').html("");
            var amount = $("#amount").val();
            // var amount = $("#conversionamount").val();


            var route = "{{ URL('Ajax/getCommission') }}";
            var thisdata = {
                check: $('#commission').prop("checked"),
                amount: amount,
                pay_method: $('#card_type').val(),
                localcurrency: "{{ $data['getuserDetail']->currencyCode }}",
                foreigncurrency: "USD",
                structure: "Withdrawal",
                structureMethod: $("#card_type").val()
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


                        var totalCharge;

                        if (result.message == "success") {

                            $(".wallet-info").html(result.walletCheck);
                            $('.withWallet').removeClass('disp-0');

                            if (result.walletCheck != "") {
                                $(".withdrawmoneyBtn").attr("disabled", true);
                                $('.commissionInfo').addClass('disp-0');
                            } else {
                                $(".withdrawmoneyBtn").attr("disabled", false);
                                $('.commissionInfo').removeClass('disp-0');
                            }


                            if (result.state == "commission available" && result.walletCheck == "") {

                                $('.commissionInfo').addClass('alert alert-success');
                                $('.commissionInfo').removeClass('alert alert-danger');

                                $('.commissionInfo').html(
                                    "<ul><li><span style='font-weight: bold;'>Kindly note that a total amount of: {{ $data['getuserDetail']->currencySymbol }}" +
                                    result.data.toFixed(2) + " will be credited to your " + $(
                                        '#card_type').val() + ".</span></li></li></ul>");

                                $("#amounttosend").val(result.data);
                                $("#commissiondeduct").val(result.collection);

                                $("#totalcharge").val(result.data);

                                totalCharge = $("#amount").val();


                                currencyConvert(totalCharge);


                            }
                            // else{

                            //     $('.commissionInfo').addClass('alert alert-danger');
                            //     $('.commissionInfo').removeClass('alert alert-success');

                            //     $('.commissionInfo').html("<ul><li><span style='font-weight: bold;'>Kindly note that a total amount of: {{ $data['getuserDetail']->currencySymbol }}"+(+result.data + +result.collection).toFixed(2)+" will be charged from your "+$('#card_type').val()+".</span></li></li></ul>");

                            //     $("#amounttosend").val(result.data);
                            //     $("#commissiondeduct").val(result.collection);
                            //     $("#totalcharge").val((+result.data + +result.collection));

                            //     totalCharge = $("#amount").val();


                            //     currencyConvert(totalCharge);

                            // }


                        }


                    }

                });

            });
        }


        function currencyConvert(amount) {

            $("#conversionamount").val("");

            var currency = "CAD";
            var localcurrency = "{{ $data['getuserDetail']->currencyCode }}";
            var route = "{{ URL('Ajax/getconversion') }}";
            var thisdata = {
                currency: currency,
                amount: amount,
                val: "send",
                localcurrency: localcurrency
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



        function goBack() {
            window.history.back();
        }


        function setHeaders() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    'Authorization': "Bearer " + "{{ session('api_token') }}"
                }
            });

        }
    </script>
@endsection
