<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

        <!-- Favicon -->
<link rel="icon" href="https://res.cloudinary.com/pilstech/image/upload/v1618251695/paysprint_icon_new_kg2h3j.png" type="image/x-icon" />

<link rel="stylesheet" type="text/css" href="{{ asset('pace/themes/orange/pace-theme-flash.css') }}" />
<script src="https://kit.fontawesome.com/384ade21a6.js"></script>

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


                                    <div class="form-group"> <label for="gateway">
                                            {{--  <h6>Select Card Type/ Bank Account</h6>  --}}
                                            <h6>Select Payment Gateway</h6>
                                        </label>
                                        <div class="input-group"> 
                                            <div class="input-group-append"> <span class="input-group-text text-muted"> <img src="https://img.icons8.com/cotton/20/000000/money--v4.png"/> </span> </div>
                                            <select name="gateway" id="gateway" class="form-control" required>
                                                <option value="">Select option</option>
                                                <option value="PaySprint">PaySprint</option>
                                                 {{-- <option value="Google Pay">Google Pay</option>  --}}
                                                {{-- <option value="Prepaid Card">Prepaid Card</option> --}}
                                                {{-- <option value="Bank Account">Bank Account</option> --}}
                                            </select>
                                            
                                        </div>
                                    </div>

                                    <div class="form-group"> <label for="card_type">
                                            <h6>Select Card Type/ Bank Account</h6>
                                        </label>
                                        <div class="input-group"> 
                                            <div class="input-group-append"> <span class="input-group-text text-muted"> <img src="https://img.icons8.com/cotton/20/000000/money--v4.png"/> </span> </div>
                                            <select name="card_type" id="card_type" class="form-control" required>
                                                <option value="">Select option</option>
                                                <option value="Credit Card">Credit Card</option>
                                                <option value="Debit Card">Debit VISA/Mastercard</option>
                                                 {{-- <option value="Google Pay">Google Pay</option>  --}}
                                                {{-- <option value="Prepaid Card">Prepaid Card</option> --}}
                                                {{-- <option value="Bank Account">Bank Account</option> --}}
                                            </select>
                                            
                                        </div>
                                    </div>


                                    <div class="form-group selectCard"> <label for="card_id">
                                            <h6>Select Card</h6>
                                        </label>
                                        <div class="input-group"> 
                                            <div class="input-group-append"> <span class="input-group-text text-muted"> <img src="https://img.icons8.com/fluent/20/000000/bank-card-back-side.png"/> </span> </div>
                                            <select name="card_id" id="card_id" class="form-control" required>
                                                {{-- @if (count($data['getCard']) > 0)
                                                
                                                    @foreach ($data['getCard'] as $mycard)
                                                    <option value="{{ $mycard->id }}">{!! wordwrap($mycard->card_number, 4, '-', true).' - ['.$mycard->card_provider.']' !!}</option>
                                                    @endforeach

                                                @else
                                                    <option value="">Add a new card</option>
                                                @endif --}}
                                                
                                            </select>
                                            
                                        </div>
                                    </div>


                                    
                                    
                                    <div class="form-group"> <label for="amount">
                                            <h6>Amount</h6>
                                        </label>
                                        <div class="input-group"> <div class="input-group-append"> <span class="input-group-text text-muted"> {{ $data['currencyCode'][0]->currencies[0]->symbol }} </span> </div> <input type="number" min="0.00" step="0.01" name="amount" id="amount" class="form-control" required>

                                        <input type="hidden" name="currencyCode" class="form-control" id="curCurrency" value="{{ $data['currencyCode'][0]->currencies[0]->code }}" readonly>

                                        <input type="hidden" name="paymentToken" class="form-control" id="paymentToken" value="" readonly>

                                        <input type="hidden" name="mode" class="form-control" id="mode" value="live" readonly>
                                            
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group"> 
                                            <p style="color: red; font-weight: bold;"><input type="checkbox" name="commission" id="commission"> Include fee</p>
                                            
                                        </div>
                                    </div>


                                    


                                    <div class="form-group"> <label for="netwmount">
                                        <h6>Net Amount <br><small class="text-success disp-0"><b>This is the total amount to be received</b></small></h6>
                                        
                                    </label>
                                    <div class="input-group"> 
                                        <input type="text" name="amounttosend" class="form-control" id="amounttosend" value="" placeholder="0.00" readonly>
                                    </div>
                                </div>
                                    <div class="form-group"> <label for="netwmount">
                                        <h6>Fee</h6>
                                    </label>
                                    <div class="input-group"> 
                                        <input type="text" name="commissiondeduct" class="form-control" id="commissiondeduct" value="" placeholder="0.00" readonly>

                                        <input type="hidden" name="totalcharge" class="form-control" id="totalcharge" value="" placeholder="0.00" readonly>

                                    </div>
                                </div>


                                <div class="form-group disp-0"> <label for="netwmount">
                                        <h6>Currency Conversion <br><small class="text-info"><b>Exchange rate today according to currencylayer.com</b></small></h6>
                                        <p style="font-weight: bold;">
                                            {{ $data['currencyCode'][0]->currencies[0]->code }} <=> CAD
                                        </p>
                                    </label>
                                    <div class="input-group"> 
                                        <input type="text" name="conversionamount" class="form-control" id="conversionamount" value="" placeholder="0.00" readonly>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <div class="commissionInfo"></div>
                                </div>

                                
                                    
                                    
                                    <div class="card-footer"> <button type="button" onclick="handShake('addmoney')" class="subscribe btn btn-info btn-block shadow-sm cardSubmit"> Confirm </button></div>

                                    <div class="col-md-12 withCardGoogle disp-0">
                                        <center>
                                                <div id="container"></div>
                                                <div id="moneris-google-pay" store-id="monca04155" web-merchant-key="55DAF4F744E7C36461258B79F750BC5D9D653C7D022FDB2DFC6A3309720C6D06"></div>
                                        </center>
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


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous"></script>

    <script src="{{ asset('pace/pace.min.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>




        <script>

            $(function() {

                $("#amount").on("keyup", function() {
                    runCommission();
                });

                });


$('#commission').click(function(){
    runCommission();
});


$('#card_type').change(function(){

    if($('#card_type').val() != "Google Pay"){
        $(".selectCard").removeClass('disp-0');
        $(".card-footer").removeClass('disp-0');
        $(".withCardGoogle").addClass('disp-0');
        runCardType();
    }
    else{
        // Change to google pay button
        $(".selectCard").addClass('disp-0');
        $(".card-footer").addClass('disp-0');
        $(".withCardGoogle").removeClass('disp-0');
    }
    
});


function runCardType(){

    $('#card_id').html("");

    var route = "{{ URL('/api/v1/getmycarddetail') }}";
    var thisdata = {card_provider: $('#card_type').val()};


    Pace.restart();
    Pace.track(function(){

        setHeaders();
        
        jQuery.ajax({
        url: route,
        method: 'get',
        data: thisdata,
        dataType: 'JSON',
        
        success: function(result){
            if(result.message == "success"){
                var res = result.data;


                $.each(res, function(v, k){
                    $('#card_id').append(`<option value="${k.id}">${k.card_number} - ${k.card_type}</option>`);
                });

            }
            else{
                $('#card_id').append(`<option value="">${$('#card_type').val()} not available</option>`);
            }

        },
        error: function(err) {
            $('#card_id').append(`<option value="">${$('#card_type').val()} not available</option>`);
            // swal("Oops", err.responseJSON.message, "error");
        } 

    });

    });

}


function runCommission(){
    
    $('.commissionInfo').html("");
    var amount = $("#amount").val();
    // var amount = $("#conversionamount").val();


    var route = "{{ URL('Ajax/getCommission') }}";
    var thisdata = {check: $('#commission').prop("checked"), amount: amount, pay_method: $("#card_type").val(), localcurrency: "{{ $data['currencyCode'][0]->currencies[0]->code }}", foreigncurrency: "USD", structure: "Add Funds/Money", structureMethod: $("#card_type").val()};


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

            var totalCharge;

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

                    var chargeAmount = $("#amount").val();

                    $('.commissionInfo').addClass('alert alert-success');
                    $('.commissionInfo').removeClass('alert alert-danger');

                    $('.commissionInfo').html("<ul><li><span style='font-weight: bold;'>Kindly note that a total amount of: {{ $data['currencyCode'][0]->currencies[0]->symbol }}"+chargeAmount+" will be charged from your Credit/Debit Card.</span></li></li></ul>");

                    $("#amounttosend").val(result.data);
                    $("#commissiondeduct").val(result.collection);

                    $("#totalcharge").val(chargeAmount);

                    totalCharge = $("#totalcharge").val();

                    currencyConvert(totalCharge);


                }
                else{

                    $('.commissionInfo').addClass('alert alert-danger');
                    $('.commissionInfo').removeClass('alert alert-success');

                    $('.commissionInfo').html("<ul><li><span style='font-weight: bold;'>Kindly note that a total amount of: {{ $data['currencyCode'][0]->currencies[0]->symbol }}"+(+result.data + +result.collection).toFixed(2)+" will be charged from your Credit/Debit Card.</span></li></li></ul>");

                    $("#amounttosend").val(result.data);
                    $("#commissiondeduct").val(result.collection);
                    $("#totalcharge").val((+result.data + +result.collection));

                    totalCharge = $("#totalcharge").val();


                    currencyConvert(totalCharge);

                }


            }


        }

    });

    });
}


function currencyConvert(amount){

    $("#conversionamount").val("");

    var currency = "CAD";
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


function handShake(val){

var route;

var formData;

if(val == 'addmoney'){
    formData = new FormData(formElem);
    route = "{{ URL('/api/v1/addmoneytowallet') }}";

        Pace.restart();
    Pace.track(function(){
        setHeaders();
        jQuery.ajax({
        url: route,
        method: 'post',
        data: formData,
        cache: false,
        processData: false,
        contentType: false,
        dataType: 'JSON',
        beforeSend: function(){
            $('.cardSubmit').text('Please wait...');
        },
        success: function(result){
            console.log(result);

            $('.cardSubmit').text('Confirm');

            if(result.status == 200){
                    swal("Success", result.message, "success");
                    setTimeout(function(){ location.href="{{ route('my account') }}"; }, 2000);
                }
                else{
                    swal("Oops", result.message, "error");
                }

        },
        error: function(err) {
            $('.cardSubmit').text('Confirm');
            swal("Oops", err.responseJSON.message, "error");

        } 

    });
    });

}
else if(val == 'addcard'){
    formData = new FormData();

    formData.append('card_number', $("#card_number").val());
    formData.append('month', $("#month").val());
    formData.append('year', $("#year").val());
    formData.append('cvv', $("#cvv").val());

        route = "{{ URL('/api/v1/addnewcard') }}";

        Pace.restart();
    Pace.track(function(){
        setHeaders();
        jQuery.ajax({
        url: route,
        method: 'post',
        data: formData,
        cache: false,
        processData: false,
        contentType: false,
        dataType: 'JSON',
        beforeSend: function(){
            $('#cardSubmit').text('Please wait...');
        },
        success: function(result){
            console.log(result);

            $('#cardSubmit').text('Submit');

            if(result.status == 200){
                    swal("Success", result.message, "success");
                    setTimeout(function(){ location.reload(); }, 2000);
                }
                else{
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

function goBack() {
  window.history.back();
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
            'gateway': 'moneris',
            'gatewayMerchantId': 'monca04155'
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
            // merchantId: 'BCR2DN6T2PJ3FJ37',
            merchantId: '0030211465333',
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
            paymentsClient = new google.payments.api.PaymentsClient({environment: 'TEST'});
            // paymentsClient = new google.payments.api.PaymentsClient({environment: 'PRODUCTION'});
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
            var totalcharge = $('#totalcharge').val();

            var charge = ParseFloat(totalcharge, 2);

          return {
            countryCode: "{{ $data['currencyCode'][0]->alpha2Code }}",
            currencyCode: "{{ $data['currencyCode'][0]->currencies[0]->code }}",
            totalPriceStatus: "FINAL",
            // set to cart total
            totalPrice: ""+charge+""
          };
        }

        
        function ParseFloat(str,val) {
            str = str.toString();
            str = str.slice(0, (str.indexOf(".")) + val + 1); 
            return Number(str);   
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
            var d = new Date();

            var totalcharge = $('#totalcharge').val();

            var charge = ParseFloat(totalcharge, 2);

                // Run System Payment Complete
                $('#paymentToken').val('');

            // show returned data in developer console for debugging
                // console.log(paymentData);
                // @todo pass payment token to your gateway to process payment
                paymentToken = paymentData.paymentMethodData.tokenizationData.token;


                // var thistoken = JSON.parse(paymentToken);


                
            var orderId = "ord-"+d.getTime();
            var ticket = "wallet-"+d.getTime();


                paymentData["orderId"] = orderId;
                paymentData["ticket"] = ticket;
                paymentData["amount"] = ""+charge+"";

                MonerisGooglePay.purchase(paymentData, function(response)
                {

                if ( response && response.receipt && response.receipt.ResponseCode &&
                !isNaN(response.receipt.ResponseCode) )
                {
                    if ( parseInt(response.receipt.ResponseCode) < 50 )
                    {
                        $('#paymentToken').val(orderId);

                        // alert("Looks like the transaction is approved.");
                            setTimeout(() => {
                                handShake('addmoney');
                            }, 1000);

                    }
                    else
                    {
                        alert("Looks like the transaction is declined.");
                    }
                }
                else
                {
                    throw ("Error processing receipt.");
                }
                });

            
                

            

        }



// Gpay Ends


function setHeaders(){

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': "{{csrf_token()}}",
            'Authorization': "Bearer "+"{{ Auth::user()->api_token }}"
        }
        });

}


        </script>



        {{-- Google Pay API --}}
        
<script async
  src="https://pay.google.com/gp/p/js/pay.js"
  onload="onGooglePayLoaded()"></script>
  <script async src="{{ asset('js/moneris-googlepay.js') }}" onload="MonerisGooglePay.onReady()"></script>


  

  </body>
</html>