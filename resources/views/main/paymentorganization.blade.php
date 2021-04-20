<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

        <!-- Favicon -->
<link rel="icon" href="https://res.cloudinary.com/pilstech/image/upload/v1602675914/paysprint_icon_png_ol2z3u.png" type="image/x-icon" />

<link rel="stylesheet" type="text/css" href="{{ asset('pace/themes/orange/pace-theme-flash.css') }}" />

<script src="https://kit.fontawesome.com/384ade21a6.js"></script>

    <title>PaySprint | Money Transfer</title>

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
.disp-0{
    display: none !important;
}
    </style>

  </head>
  <body>
    <div class="container py-5">
        <!-- For demo purpose -->
        <div class="row mb-4">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-4">Send Money</h1>
            </div>
        </div> <!-- End -->
        <div class="row">
            <div class="col-lg-6 mx-auto">
                <div class="card ">
                    <div class="card-header">
                        <div class="bg-white shadow-sm pt-4 pl-2 pr-2 pb-2">
                            <!-- Credit card form tabs -->
                            <ul role="tablist" class="nav bg-light nav-pills rounded nav-fill mb-3">
                                <li class="nav-item" onclick="location.href='{{ route('payorganization') }}'"> <a data-toggle="pill" href="{{ route('payorganization') }}" class="nav-link active "> <i class="fas fa-home"></i> Go Back </a> </li>
                                {{-- <li class="nav-item"> <a data-toggle="pill" href="#paypal" class="nav-link "> <i class="fab fa-paypal mr-2"></i> Debit Card </a> </li>
                                <li class="nav-item"> <a data-toggle="pill" href="#net-banking" class="nav-link "> <i class="fas fa-mobile-alt mr-2"></i> EXBC Card </a> </li> --}}
                            </ul>
                        </div> <!-- End -->
                        <!-- Credit card form content -->
                        <div class="tab-content">



                            @if (isset($data) && isset($data['paymentorg']))

                            {{-- 234-90695 --}}
                            
                                
                            <!-- credit card info-->
                            <div id="credit-card" class="tab-pane fade show active pt-3">
                                <form role="form" action="{{ route('orgPaymentInvoice') }}" method="POST" id="paymentForm">

                                    @csrf
                                    <input type="hidden" class="form-control" name="user_id" id="orgpayuser_id" value="{{ $data['paymentorg']->ref_code }}">
                                    <input type="hidden" name="orgpayname" id="orgpayname" value="{{ $name }}"> 

                                    <input type="hidden" name="orgpayemail" id="orgpayemail" value="{{ $email }}">

                                    <input type="hidden" name="code" id="code" value="{{ $data['currencyCode'][0]->callingCodes[0] }}">

                                    <input type="hidden" name="paymentToken" id="paymentToken" value="">

                                    <div class="form-group">
                                        <div class="alert alert-info">
                                            <ul>
                                                <li>
                                                    Receiver's Name: <b>{{ $data['paymentorg']->name }}</b>
                                                </li>
                                                <li>
                                                    Address: <b>{{ $data['paymentorg']->address }}</b>
                                                </li>
                                                <li>
                                                    City: <b>{{ $data['paymentorg']->city }}</b> | State/Province: <b>{{ $data['paymentorg']->state }}</b>
                                                </li>
                                                <li>
                                                    Country: <b>{{ $data['paymentorg']->country }}</b>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="alert alert-warning">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h4>
                                                        Wallet Balance
                                                    </h4>
                                                </div>
                                                <div class="col-md-12">
                                                    <h4>
                                                        {{ $data['currencyCode'][0]->currencies[0]->symbol."".number_format(Auth::user()->wallet_balance, 2) }}
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>

                                        
                                    </div>

                                    <div class="form-group disp-0"> <label for="make_payment_method">
                                            <h6>Transfer Method</h6>
                                        </label>
                                        <div class="input-group"> 
                                            <select name="payment_method" id="make_payment_method" class="form-control" required>
                                                <option value="">Select Payment Method</option>
                                                <option value="Wallet" selected>Wallet</option>
                                                {{-- <option value="Credit Card">Credit Card</option> --}}
                                                {{--  <option value="Debit Card">Debit Card</option>  --}}
                                                {{-- <option value="EXBC Card">EXBC Card</option> --}}
                                            </select>
                                            
                                        </div>
                                    </div>


                                    <div class="form-group creditcard disp-0"> <label for="card_id">
                                            <h6>Select Card</h6>
                                        </label>
                                        <div class="input-group"> 
                                            <div class="input-group-append"> <span class="input-group-text text-muted"> <img src="https://img.icons8.com/fluent/20/000000/bank-card-back-side.png"/> </span> </div>
                                            <select name="card_id" id="card_id" class="form-control" required>
                                                @if (count($data['getCard']) > 0)
                                                    @foreach ($data['getCard'] as $mycard)


                                                        <option value="{{ $mycard->id }}">{!! wordwrap($mycard->card_number, 4, '-', true) !!}</option>
                                                    @endforeach
                                                @else
                                                    <option value="">Add a new card</option>
                                                @endif
                                            </select>
                                            
                                        </div>
                                    </div>

                                    
                                    
                                    
                                        <div class="form-group"> <label for="orgpayservice">
                                            <h6>Purpose of Transfer</h6>
                                        </label>
                                        <div class="input-group"> 
                                            <select name="service" id="orgpayservice" class="form-control" required>
                                                <option value="Offering">Offering</option>
                                                <option value="Tithe">Tithe</option>
                                                <option value="Seed">Seed</option>
                                                <option value="Contribution">Contribution</option>
                                                <option value="Others">Others</option>
                                            </select>
                                            
                                        </div>
                                    </div>


                                        <div class="form-group others disp-0"> <label for="orgpaypurpose">
                                            <h6>Specify Purpose</h6>
                                        </label>
                                        <div class="input-group"> 
                                            <input type="text" name="purpose" id="orgpaypurpose" placeholder="Specify Purpose" class="form-control">
                                            
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group"> <label for="currency">
                                                    <h6>Currency</h6>
                                                </label>
                                                <input type="hidden" name="localcurrency" value="{{ $data['currencyCode'][0]->currencies[0]->code }}">
                                                <div class="input-group"> 
                                                    <select name="currency" id="currency" class="form-control" readonly>
                                                        <option value="{{ $data['othercurrencyCode'][0]->currencies[0]->code }}" selected>{{ $data['othercurrencyCode'][0]->currencies[0]->code }}</option>
                                                    </select>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group"> <label for="orgpayamount">
                                                    <h6>Amount to Send</h6>
                                                </label>
                                                <div class="input-group"> <input type="number" name="amount" id="orgpayamount" placeholder="50.00" class="form-control" maxlength="16" required>
                                                    <div class="input-group-append"> <span class="input-group-text text-muted"> <i class="fas fa-money-check mx-1"></i> <i class="fab fa-cc-mastercard mx-1"></i> <i class="fab fa-cc-amex mx-1"></i> </span> </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        
                                    
                                    
                                    
                                    

                                    <div class="form-group disp-0">
                                        <div class="input-group"> 
                                            <p style="color: red; font-weight: bold;"><input type="checkbox" name="commission" id="commission"> Transfer include commission</p>
                                            
                                        </div>
                                    </div>

                                    @if (Request::get('country') != $data['paymentorg']->country)

                                        <div class="form-group"> <label for="netwmount">
                                                <h6>Currency Conversion <br><small class="text-info"><b>Exchange rate today according to currencylayer.com</b></small></h6>
                                                <p style="font-weight: bold;">
                                                    {{ $data['currencyCode'][0]->currencies[0]->code }} <=> {{ $data['othercurrencyCode'][0]->currencies[0]->code }}
                                                </p>
                                            </label>
                                            <div class="input-group"> 
                                                <input type="text" name="conversionamount" class="form-control" id="conversionamount" value="" placeholder="0.00" readonly>
                                            </div>
                                        </div>


                                        @else

                                        <div class="form-group disp-0"> <label for="netwmount">
                                                <h6>Currency Conversion <br><small class="text-info"><b>Exchange rate today according to currencylayer.com</b></small></h6>
                                                <p style="font-weight: bold;">
                                                    {{ $data['currencyCode'][0]->currencies[0]->code }} <=> {{ $data['othercurrencyCode'][0]->currencies[0]->code }}
                                                </p>
                                            </label>
                                            <div class="input-group"> 
                                                <input type="text" name="conversionamount" class="form-control" id="conversionamount" value="" placeholder="0.00" readonly>
                                            </div>
                                        </div>


                                        
                                    @endif


                                    


                                <div class="form-group"> <label for="netwmount">
                                    <h6>Net Amount <br><small class="text-success"><b>Total amount that would be received</b></small></h6>
                                    
                                </label>
                                <div class="input-group"> 
                                    <input type="text" name="amounttosend" class="form-control" id="amounttosend" value="" placeholder="0.00" readonly>
                                </div>
                            </div>
                                <div class="form-group"> <label for="netwmount">
                                    <h6>Fee <small class="text-success"><b>(FREE)</b></small></h6>
                                </label>
                                <div class="input-group"> 
                                    <input type="text" name="commissiondeduct" class="form-control" id="commissiondeduct" value="" placeholder="0.00" readonly>

                                    <input type="hidden" name="totalcharge" class="form-control" id="totalcharge" value="" placeholder="0.00" readonly>

                                </div>
                            </div>


                            @if (Request::get('country') != $data['paymentorg']->country)
                            <div class="form-group">
                                <span class="text-success">Please note that International transfer are sent in USD conversion</span>
                            </div>

                            @endif

                            
                            <hr>

                            <div class="form-group">
                                <strong><span class="text-danger wallet-info"></span></strong>
                            </div>



                                <div class="form-group">
                                    <div class="commissionInfo"></div>
                                </div>

                                    <div class="form-group disp-0"> <label for="orgpaycreditcard">
                                            <h6>Card number</h6>
                                        </label>
                                        <div class="input-group"> <input type="number" name="creditcard_no" id="orgpaycreditcard" placeholder="5199 - 3924 - 2100 - 5430" class="form-control" maxlength="16" required>
                                            <div class="input-group-append"> <span class="input-group-text text-muted"> <i class="fab fa-cc-visa mx-1"></i> <i class="fab fa-cc-mastercard mx-1"></i> <i class="fab fa-cc-amex mx-1"></i> </span> </div>
                                        </div>
                                    </div>
                                    <div class="row disp-0">
                                        <div class="col-sm-4">
                                            <div class="form-group"> <label><span class="hidden-xs">
                                                        <h6>Month</h6>
                                                    </span></label>
                                                <div class="input-group"> <select name='month' id="orgmonth" class='form-control'>
                                                    <option selected value='01'>January</option>
                                                    <option value='02'>February</option>
                                                    <option value='03'>March</option>
                                                    <option value='04'>April</option>
                                                    <option value='05'>May</option>
                                                    <option value='06'>June</option>
                                                    <option value='07'>July</option>
                                                    <option value='08'>August</option>
                                                    <option value='09'>September</option>
                                                    <option value='10'>October</option>
                                                    <option value='11'>November</option>
                                                    <option value='12'>December</option>
                                                </select>
                                            </div>

                                        </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label><span class="hidden-xs">
                                                    <h6>Year</h6>
                                                </span></label>
                                                <div class="input-group">
                                                    <select name='expirydate' id="orgpayyear" class='form-control'>
                                                        @for ($i = 21; $i <= 50; $i++)
                                                        <option value='{{ $i }}'>{{ $i }}</option>
                                                        @endfor
                                                        
                                                    </select>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        

                                        <div class="col-sm-4">
                                            <div class="form-group mb-4"> <label data-toggle="tooltip" title="Three digit CV code on the back of your card">
                                                    <h6>CVV <i class="fa fa-question-circle d-inline"></i></h6>
                                                </label> <input type="number" required class="form-control" name="cvv" placeholder="435"> </div>
                                        </div>
                                    </div>
                                    <div class="card-footer"> 
                                        
                                        

                                        <div class="row">
                                            <div class="col-md-12 withCardGoogle disp-0">
                                            <center><div id="container"></div></center>
                                            </div>

                                            <div class="col-md-12 withCard disp-0">
                                                <button type="button" onclick="orgmonerisPay()" class="subscribe btn btn-primary btn-block shadow-sm sendmoneyBtn"> Send Money </button>
                                            </div>
                                            <div class="col-md-12 withWallet">

                                                @if (Auth::user()->approval == 1)
                                                    <button type="button" onclick="orgmonerisPay()" class="subscribe btn btn-primary btn-block shadow-sm sendmoneyBtn"> Send Money </button>
                                                @else

                                                <button type="button" onclick="restriction('sendmoney', '{{ Auth::user()->name }}')" class="subscribe btn btn-primary btn-block shadow-sm sendmoneyBtn"> Send Money </button>
                                                    
                                                @endif

                                                
                                            </div>

                                            {{--  <div class="col-md-6">
                                                <button type="button" onclick="beginApplePay()" class="subscribe btn btn-primary btn-block shadow-sm disp-0"> Apple Pay </button>
                                            </div>  --}}
                                        </div>
                                    
                                    
                                    </div>

                                </form>
                            </div>

                            @else


                            <div class="alert alert-danger">
                                No record for this invoice number
                            </div>

                            @endif

                        </div> <!-- End -->
                        
                    </div>
                </div>
            </div>
        </div>

    
        <script src="{{ asset('js/jquery-1.12.0.min.js') }}"></script>

        @include('include.message')

    {{-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

    <script src="{{ asset('pace/pace.min.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

        <script>
            $(function() {
                $('[data-toggle="tooltip"]').tooltip();


                $("#orgpayamount").on("keyup", function() {
                    runCommission();
                });


                if (window.ApplePaySession) {
                var merchantIdentifier = 'simple.moneris.paysprint.exbc.ca';
                var promise = ApplePaySession.canMakePaymentsWithActiveCard(merchantIdentifier);
                promise.then(function (canMakePayments) {
                    if (canMakePayments)
                        // Display Apple Pay button here.
                        $(".shadow-sm").removeClass('disp-0');
                }); }

                });

$('#orgpayservice').change(function(){
    if($('#orgpayservice').val() == "Others"){
        $('.others').removeClass('disp-0');
    }
    else{
        $('.others').addClass('disp-0');
    }
});


$('#make_payment_method').change(function(){
    if($('#make_payment_method').val() == "Wallet"){
        $('.withWallet').removeClass('disp-0');
        $('.withCard').addClass('disp-0');
        $('.creditcard').addClass('disp-0');
        
    }
    else if($('#make_payment_method').val() == "Credit Card"){
        $('.withWallet').addClass('disp-0');
        $('.withCard').removeClass('disp-0');
        $('.creditcard').removeClass('disp-0');
    }
    else{
        $('.withWallet').addClass('disp-0');
        $('.withCard').addClass('disp-0');
        $('.creditcard').addClass('disp-0');
    }

    runCommission();
});

// Moneris Payment
function orgmonerisPay(){
    var name = $('#orgpayname').val();
    var email = $('#orgpayemail').val();
    var user_id = $('#orgpayuser_id').val();
    var service = $('#orgpayservice').val();
    var purpose = $('#orgpaypurpose').val();
    var amount = $('#orgpayamount').val();
    var month = $('#orgmonth').val();
    var expirydate = $('#orgpayyear').val();
    var payment_method = $('#make_payment_method').val();
    var creditcard_no = $('#orgpaycreditcard').val();
    

    if(service == ""){
        swal('Oops!', 'Please select payment purpose', 'info');
        return false;
    }
    else if(amount == ""){
        swal('Oops!', 'Please enter amount', 'info');
        return false;
    }
    // else if(month == ""){
    //     swal('Oops!', 'Please select month', 'info');
    //     return false;
    // }

    else if(payment_method == ""){
        swal('Oops!', 'Please select payment method', 'info');
        return false;
    }
    // else if(creditcard_no == ""){
    //     swal('Oops!', 'Please insert card number', 'info');
    //     return false;
    // }

    // else if(creditcard_no.length != 16){
    //     swal('Oops!', 'Invalid card number', 'info');
    //     return false;
    // }
    // else if(expirydate == ""){
    //     swal('Oops!', 'Please select year', 'info');
    //     return false;
    // }
    else{


        $("#paymentForm").submit();

            
    }


}





$('#commission').click(function(){
    runCommission();
});


function runCommission(){
    
    $('.commissionInfo').html("");
    var amount = $("#orgpayamount").val();
    // var amount = $("#conversionamount").val();


    var route = "{{ URL('Ajax/getCommission') }}";
    var thisdata = {check: $('#commission').prop("checked"), amount: amount, pay_method: $("#make_payment_method").val(), localcurrency: "{{ $data['currencyCode'][0]->currencies[0]->code }}", foreigncurrency: "{{ $data['othercurrencyCode'][0]->currencies[0]->code }}", structure: "Send Money/Pay Invoice", structureMethod: "Wallet"};


    Pace.restart();
    Pace.track(function(){

        setHeaders();
        
        jQuery.ajax({
        url: route,
        method: 'post',
        data: thisdata,
        dataType: 'JSON',
        beforeSend: function(){
            $('.commissionInfo').addClass('');
        },
        
        success: function(result){


            if(result.message == "success"){

                $(".wallet-info").html(result.walletCheck);
                $('.withWallet').removeClass('disp-0');

                if(result.walletCheck != ""){
                    $(".sendmoneyBtn").attr("disabled", true);
                    

                }
                else{
                    $(".sendmoneyBtn").attr("disabled", false);
                }


                if(result.state == "commission available"){

                    $('.commissionInfo').addClass('alert alert-success');
                    $('.commissionInfo').removeClass('alert alert-danger');

                    $('.commissionInfo').html("<ul><li><span style='font-weight: bold;'>Kindly note that a total amount of: {{ $data['currencyCode'][0]->currencies[0]->symbol }}"+result.data.toFixed(2)+" will be deducted from your "+$('#make_payment_method').val()+".</span></li></li></ul>");

                    $("#amounttosend").val(result.data);
                    $("#commissiondeduct").val(result.collection);

                    $("#totalcharge").val($('#conversionamount').val());

                    currencyConvert($('#orgpayamount').val());

                }
                else{

                    // $('.commissionInfo').addClass('alert alert-danger');
                    // $('.commissionInfo').removeClass('alert alert-success');

                    $('.commissionInfo').addClass('alert alert-success');
                    $('.commissionInfo').removeClass('alert alert-danger');

                    $('.commissionInfo').html("<ul><li><span style='font-weight: bold;'>Kindly note that a total amount of: {{ $data['currencyCode'][0]->currencies[0]->symbol }}"+(+result.data + +result.collection).toFixed(2)+" will be deducted from your "+$('#make_payment_method').val()+".</span></li></li></ul>");

                    $("#amounttosend").val(result.data);
                    $("#commissiondeduct").val(result.collection);
                    $("#totalcharge").val((+result.data + +result.collection));

                    currencyConvert($('#orgpayamount').val());

                }


            }


        }

    });

    });
}

function currencyConvert(amount){

    $("#conversionamount").val("");

    var currency = "{{ $data['othercurrencyCode'][0]->currencies[0]->code }}";
    var localcurrency = "{{ $data['currencyCode'][0]->currencies[0]->code }}";
    var route = "{{ URL('Ajax/getconversion') }}";
    var thisdata = {currency: currency, amount: amount, val: "send", localcurrency: localcurrency};

        setHeaders();
        jQuery.ajax({
        url: route,
        method: 'post',
        data: thisdata,
        dataType: 'JSON',
        success: function(result){

            if(result.message == "success"){
                $("#conversionamount").val(result.data);
            }
            else{
                $("#conversionamount").val("");
            }


        }

    });
}

// GPay Starts

        /**
         * Define the version of the Google Pay API referenced when creating your
         * configuration
         *
         * @see {@link https://developers.google.com/pay/api/web/reference/request-objects#PaymentDataRequest|apiVersion in PaymentDataRequest}
         */
         const baseRequest = {
          apiVersion: 2,
          apiVersionMinor: 0
        };
        
        /**
         * Card networks supported by your site and your gateway
         *
         * @see {@link https://developers.google.com/pay/api/web/reference/request-objects#CardParameters|CardParameters}
         * @todo confirm card networks supported by your site and gateway
         */
        const allowedCardNetworks = ["AMEX", "DISCOVER", "INTERAC", "JCB", "MASTERCARD", "VISA"];
        
        /**
         * Card authentication methods supported by your site and your gateway
         *
         * @see {@link https://developers.google.com/pay/api/web/reference/request-objects#CardParameters|CardParameters}
         * @todo confirm your processor supports Android device tokens for your
         * supported card networks
         */
        const allowedCardAuthMethods = ["PAN_ONLY", "CRYPTOGRAM_3DS"];
        
        /**
         * Identify your gateway and your site's gateway merchant identifier
         *
         * The Google Pay API response will return an encrypted payment method capable
         * of being charged by a supported gateway after payer authorization
         *
         * @todo check with your gateway on the parameters to pass
         * @see {@link https://developers.google.com/pay/api/web/reference/request-objects#gateway|PaymentMethodTokenizationSpecification}
         */
        const tokenizationSpecification = {
          type: 'PAYMENT_GATEWAY',
          parameters: {
            'gateway': 'example',
            'gatewayMerchantId': 'exampleGatewayMerchantId'
          }
        };
        
        /**
         * Describe your site's support for the CARD payment method and its required
         * fields
         *
         * @see {@link https://developers.google.com/pay/api/web/reference/request-objects#CardParameters|CardParameters}
         */
        const baseCardPaymentMethod = {
          type: 'CARD',
          parameters: {
            allowedAuthMethods: allowedCardAuthMethods,
            allowedCardNetworks: allowedCardNetworks
          }
        };
        
        /**
         * Describe your site's support for the CARD payment method including optional
         * fields
         *
         * @see {@link https://developers.google.com/pay/api/web/reference/request-objects#CardParameters|CardParameters}
         */
        const cardPaymentMethod = Object.assign(
          {},
          baseCardPaymentMethod,
          {
            tokenizationSpecification: tokenizationSpecification
          }
        );
        
        /**
         * An initialized google.payments.api.PaymentsClient object or null if not yet set
         *
         * @see {@link getGooglePaymentsClient}
         */
        let paymentsClient = null;
        
        /**
         * Configure your site's support for payment methods supported by the Google Pay
         * API.
         *
         * Each member of allowedPaymentMethods should contain only the required fields,
         * allowing reuse of this base request when determining a viewer's ability
         * to pay and later requesting a supported payment method
         *
         * @returns {object} Google Pay API version, payment methods supported by the site
         */
        function getGoogleIsReadyToPayRequest() {
          return Object.assign(
              {},
              baseRequest,
              {
                allowedPaymentMethods: [baseCardPaymentMethod]
              }
          );
        }
        
        /**
         * Configure support for the Google Pay API
         *
         * @see {@link https://developers.google.com/pay/api/web/reference/request-objects#PaymentDataRequest|PaymentDataRequest}
         * @returns {object} PaymentDataRequest fields
         */
        function getGooglePaymentDataRequest() {
          const paymentDataRequest = Object.assign({}, baseRequest);
          paymentDataRequest.allowedPaymentMethods = [cardPaymentMethod];
          paymentDataRequest.transactionInfo = getGoogleTransactionInfo();
          paymentDataRequest.merchantInfo = {
            // @todo a merchant ID is available for a production environment after approval by Google
            // See {@link https://developers.google.com/pay/api/web/guides/test-and-deploy/integration-checklist|Integration checklist}
            merchantId: 'BCR2DN6T2PJ3FJ37',
            merchantName: "PaySprint",
          };
          return paymentDataRequest;
        }
        
        /**
         * Return an active PaymentsClient or initialize
         *
         * @see {@link https://developers.google.com/pay/api/web/reference/client#PaymentsClient|PaymentsClient constructor}
         * @returns {google.payments.api.PaymentsClient} Google Pay API client
         */
        function getGooglePaymentsClient() {
          if ( paymentsClient === null ) {
            paymentsClient = new google.payments.api.PaymentsClient({environment: 'PRODUCTION'});
          }
          return paymentsClient;
        }
        
        /**
         * Initialize Google PaymentsClient after Google-hosted JavaScript has loaded
         *
         * Display a Google Pay payment button after confirmation of the viewer's
         * ability to pay.
         */
        function onGooglePayLoaded() {
          const paymentsClient = getGooglePaymentsClient();
          paymentsClient.isReadyToPay(getGoogleIsReadyToPayRequest())
              .then(function(response) {
                if (response.result) {
                  addGooglePayButton();
                  // @todo prefetch payment data to improve performance after confirming site functionality
                  // prefetchGooglePaymentData();
                }
              })
              .catch(function(err) {
                // show error in developer console for debugging
                console.error(err);
                alert(err.statusMessage);
              });
        }
        
        /**
         * Add a Google Pay purchase button alongside an existing checkout button
         *
         * @see {@link https://developers.google.com/pay/api/web/reference/request-objects#ButtonOptions|Button options}
         * @see {@link https://developers.google.com/pay/api/web/guides/brand-guidelines|Google Pay brand guidelines}
         */
        function addGooglePayButton() {
          const paymentsClient = getGooglePaymentsClient();
          const button =
              paymentsClient.createButton({onClick: onGooglePaymentButtonClicked, buttonType: 'plain'});
          document.getElementById('container').appendChild(button);
        }
        
        /**
         * Provide Google Pay API with a payment amount, currency, and amount status
         *
         * @see {@link https://developers.google.com/pay/api/web/reference/request-objects#TransactionInfo|TransactionInfo}
         * @returns {object} transaction info, suitable for use as transactionInfo property of PaymentDataRequest
         */
        function getGoogleTransactionInfo() {
          return {
            countryCode: "{{ $data['currencyCode'][0]->alpha2Code }}",
            currencyCode: "{{ $data['currencyCode'][0]->currencies[0]->code }}",
            totalPriceStatus: "FINAL",
            // set to cart total
            totalPrice: $("#totalcharge").val()
          };
        }
        
        /**
         * Prefetch payment data to improve performance
         *
         * @see {@link https://developers.google.com/pay/api/web/reference/client#prefetchPaymentData|prefetchPaymentData()}
         */
        function prefetchGooglePaymentData() {
          const paymentDataRequest = getGooglePaymentDataRequest();
          // transactionInfo must be set but does not affect cache
          paymentDataRequest.transactionInfo = {
            totalPriceStatus: 'NOT_CURRENTLY_KNOWN',
            currencyCode: "{{ $data['currencyCode'][0]->currencies[0]->code }}"
          };
          const paymentsClient = getGooglePaymentsClient();
          paymentsClient.prefetchPaymentData(paymentDataRequest);
        }
        
        /**
         * Show Google Pay payment sheet when Google Pay payment button is clicked
         */
        function onGooglePaymentButtonClicked() {
          const paymentDataRequest = getGooglePaymentDataRequest();
          paymentDataRequest.transactionInfo = getGoogleTransactionInfo();
        
          const paymentsClient = getGooglePaymentsClient();
          paymentsClient.loadPaymentData(paymentDataRequest)
              .then(function(paymentData) {
                // handle the response
                processPayment(paymentData);
              })
              .catch(function(err) {
                // show error in developer console for debugging
                console.error(err);
                alert(err.statusMessage);
              });
        }
        /**
         * Process payment data returned by the Google Pay API
         *
         * @param {object} paymentData response from Google Pay API after user approves payment
         * @see {@link https://developers.google.com/pay/api/web/reference/response-objects#PaymentData|PaymentData object reference}
         */
        function processPayment(paymentData) {

            // Run System Payment Complete
            $('#paymentToken').val('');

    var name = $('#orgpayname').val();
    var email = $('#orgpayemail').val();
    var user_id = $('#orgpayuser_id').val();
    var service = $('#orgpayservice').val();
    var purpose = $('#orgpaypurpose').val();
    var amount = $('#orgpayamount').val();


    if(service == ""){
        swal('Oops!', 'Please select payment purpose', 'info');
        return false;
    }
    else if(amount == ""){
        swal('Oops!', 'Please enter amount', 'info');
        return false;
    }
    
    else{

        // show returned data in developer console for debugging
        console.log(paymentData);
          // @todo pass payment token to your gateway to process payment
        paymentToken = paymentData.paymentMethodData.tokenizationData.token;

        $('#paymentToken').val(paymentToken);


        $("#paymentForm").submit();

            
    }

        }



// Gpay Ends






function beginApplePay() {
  var paymentRequest = {
    countryCode: 'US',
    currencyCode: 'USD',
    total: {
      label: 'Stripe.com',
      amount: '19.99'
    }
  };
//   var session = ...; // continued below
}




 function restriction(val, name){
    if(val == "sendmoney"){
        swal('Hello '+name, 'Your account need to be verified before you can send money', 'info');
    }
 }




    //Set CSRF HEADERS
    function setHeaders(){
    jQuery.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': "{{csrf_token()}}"
      }
    });
 }

        </script>


    {{-- Google Pay API --}}
        
        <script async
          src="https://pay.google.com/gp/p/js/pay.js"
          onload="onGooglePayLoaded()">
</script>

  </body>
</html>