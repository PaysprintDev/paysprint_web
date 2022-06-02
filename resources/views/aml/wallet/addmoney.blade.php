@extends('layouts.dashboard')


@section('dashContent')



@if($data['paymentgateway']->gateway == "Stripe")

<script src="https://js.stripe.com/v3/"></script>
<script src="https://polyfill.io/v3/polyfill.min.js?version=3.52.1&features=fetch"></script>

@endif

@if($data['paymentgateway']->gateway == "PayPal")

<script src="https://www.paypal.com/sdk/js?client-id={{ env('PAYPAL_CLIENT_ID') }}&currency={{ $data['getuserDetail']->currencyCode }}"></script>

@endif


<?php use \App\Http\Controllers\ClientInfo; ?>
<?php use \App\Http\Controllers\User; ?>
<?php use \App\Http\Controllers\InvoicePayment; ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add Money
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Add Money</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
                <div class="col-md-2 col-md-offset-0">
                <button class="btn btn-secondary btn-block bg-red" onclick="goBack()"><i class="fas fa-chevron-left"></i> Go back</button>
                </div>
        </div>

      <div class="row">






                      <div class="box-body">

                                  <div class="col-lg-12 col-xs-12">
          <!-- small box -->
          <div class="small-box bg-warning">
            <div class="inner">
              <h3>{{ $data['getuserDetail']->currencySymbol.number_format($data['getuserDetail']->wallet_balance, 2) }}</h3>

              <p>Balance</p>
            </div>
            <div class="icon">
              <i class="ion ion-pricetag"></i>
            </div>
            {{-- <a href="#" class="small-box-footer">View details <i class="fa fa-arrow-circle-right"></i></a> --}}
          </div>
        </div>

                    <div class="form-group cardform">
                        <form role="form" action="#" method="POST" id="formElem">
                                @csrf


                                <div @if($data['paymentgateway']->gateway == "Moneris") class="form-group" @else class="form-group disp-0" @endif>
                                    <label for="card_id">

                                        Select Payment Gateway
                                        </label>
                                            <select name="gateway" id="gateway" class="form-control" required>
                                                <option value="PaySprint">Select option</option>
                                                <option value="PaySprint" selected>PaySprint</option>
                                                {{--  <option value="Google Pay">Google Pay</option>  --}}
                                            </select>

                                    </div>


                                <div  @if($data['paymentgateway']->gateway == "Moneris") class="form-group" @else class="form-group disp-0" @endif>
                                    <label for="card_id">

                                        Select Card Type/ Bank Account
                                        </label>
                                            <select name="card_type" id="card_type" class="form-control" required>
                                                <option value="Debit Card" selected>Select option</option>
                                                @if (session('country') != "Nigeria")
                                                  <option value="Credit Card">Credit Card</option>
                                                @endif
                                                <option value="Debit Card">Debit VISA/Mastercard</option>
                                                {{--  <option value="Prepaid Card">Prepaid Card</option>
                                                <option value="Bank Account">Bank Account</option>  --}}
                                            </select>

                                    </div>



                                    <div class="form-group disp-0"> <label for="card_id">
                                            Select Card/Bank
                                        </label>
                                            <select name="card_id" id="card_id" class="form-control" required>
                                              <option value="NULL" selected></option>
                                            </select>
                                    </div>





                                <div class="form-group">
                                    <label for="amount">Amount</label>

                                    <input type="number" min="0.00" max="10000.00" step="0.01" name="amount" id="amount" class="form-control" required>

                                    <input type="hidden" name="currencyCode" class="form-control" id="curCurrency" value="{{ $data['getuserDetail']->currencyCode }}" readonly>

                                    <input type="hidden" name="name" class="form-control" id="nameInput" value="{{ session('firstname').' '.session('lastname') }}" readonly>
                                         <input type="hidden" name="email" class="form-control" id="emailInput" value="{{ session('email') }}" readonly>

                                    <input type="hidden" name="paymentToken" class="form-control" id="paymentToken" value="" readonly>

                                    <input type="hidden" name="mode" class="form-control" id="mode" value="live" readonly>


                                </div>

                                <div class="form-group">
                                            <p style="color: red; font-weight: bold;"><input type="checkbox" name="commission" id="commission"> Include fee</p>
                                    </div>



                                <div class="form-group"> <label for="netwmount">
                                        Net Amount

                                    </label>
                                        <input type="text" name="amounttosend" class="form-control" id="amounttosend" value="" placeholder="0.00" readonly>
                                </div>


                                <div class="form-group"> <label for="netwmount">
                                        Fee
                                    </label>
                                        <input type="text" name="commissiondeduct" class="form-control" id="commissiondeduct" value="" placeholder="0.00" readonly>

                                        <input type="hidden" name="totalcharge" class="form-control" id="totalcharge" value="" placeholder="0.00" readonly>

                                </div>




                                <div class="form-group disp-0"> <label for="netwmount">
                                        <h6>Currency Conversion <br><small class="text-info"><b>Exchange rate today according to currencylayer.com</b></small></h6>
                                        <p style="font-weight: bold;">
                                            {{ $data['getuserDetail']->currencyCode }} <=> CAD
                                        </p>
                                    </label>
                                    <div class="input-group">
                                        <input type="text" name="conversionamount" class="form-control" id="conversionamount" value="" placeholder="0.00" readonly>
                                    </div>
                                </div>



                                @if($data['paymentgateway']->gateway == "Stripe")
                                <div class="form-group"> <label for="card-elemet">
                                            <h6>Card Detail</h6>
                                    </label>
                                    <div id="card-element"></div>
                                </div>
                                @endif


                                <div class="form-group">
                                    <div class="commissionInfo"></div>
                                </div>


                                @if ($data['paymentgateway']->gateway == "PayStack")
                                    <div class="form-group">
                                      <button type="button" class="btn btn-primary btn-block cardSubmit" onclick="payWithPaystack('{{ session('email') }}')" >Confirm</button>
                                  </div>
                                @elseif($data['paymentgateway']->gateway == "Stripe")
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-block cardSubmit"> Pay Now</button>
                                    </div>

                                  @elseif($data['paymentgateway']->gateway == "PayPal")
                                  {{--  PayPal  --}}
                                  <div class="form-group text-center" id="paypal-button-container"></div>

                                  @else

                                  <div class="form-group"> <button type="button" onclick="handShake('addmoney')" class="btn btn-primary btn-block cardSubmit"> Confirm </button></div>

                                @endif




                                <div class="col-md-12 withCardGoogle disp-0">
                                        <center>
                                            <div id="container"></div>
                                                <div id="moneris-google-pay" store-id="monca04155" web-merchant-key="8721CF195A6D59C63304681BB18FA9163808950E2743426DBF11CB7D91A74E03"></div>
                                        </center>
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
    <script src="https://js.paystack.co/v1/inline.js"></script>
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
                    $('#card_id').append(`<option value="${k.id}">${cardHide(k.card_number)} - ${k.card_type}</option>`);
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


function runCommission(){

    $('.commissionInfo').html("");
    var amount = $("#amount").val();
    // var amount = $("#conversionamount").val();
    var card_type = $("#card_type").val();

    var route = "{{ URL('Ajax/getCommission') }}";
    var thisdata = {check: $('#commission').prop("checked"), amount: amount, pay_method: $("#card_type").val(), localcurrency: "{{ $data['getuserDetail']->currencyCode }}", foreigncurrency: "USD", structure: "Add Funds/Money", structureMethod: "Debit Card"};


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

                    $('.commissionInfo').html("<ul><li><span style='font-weight: bold;'>Kindly note that a total amount of: {{ $data['getuserDetail']->currencySymbol }}"+chargeAmount+" will be charged from your "+$('#card_type').val()+".</span></li></li></ul>");

                    $("#amounttosend").val(result.data);
                    $("#commissiondeduct").val(result.collection);

                    $("#totalcharge").val(chargeAmount);

                    totalCharge = $("#totalcharge").val();

                    currencyConvert(totalCharge);


                }
                else{

                    $('.commissionInfo').addClass('alert alert-danger');
                    $('.commissionInfo').removeClass('alert alert-success');

                    $('.commissionInfo').html("<ul><li><span style='font-weight: bold;'>Kindly note that a total amount of: {{ $data['getuserDetail']->currencySymbol }}"+(+result.data + +result.collection).toFixed(2)+" will be charged from your "+$('#card_type').val()+"</span></li></li></ul>");

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

// PayStack Integration
  function payWithPaystack(email){
    var netamount = $('#amounttosend').val();
    var feeamount = $('#commissiondeduct').val();



      var amount = (+netamount + +feeamount).toFixed(2);
    var handler = PaystackPop.setup({
      key: '{{ env("PAYSTACK_PUBLIC_KEY") }}',
      email: email,
      amount: amount * 100,
      currency: "NGN",
      ref: ''+Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
      metadata: {
         custom_fields: [
            {
                display_name: "Full Name",
                variable_name: "name",
                value: "{{ session('firstname').' '.session('lastname') }}"
            },
            {
                display_name: "Description",
                variable_name: "description",
                value: "Added {{ $data['getuserDetail']->currencySymbol }}"+netamount+" to PaySprint Wallet and a Fee of "+feeamount+" inclusive."
            }
         ]
      },
      callback: function(response){

          $('#paymentToken').val(response.reference);

            setTimeout(() => {
                handShake('addmoney');
            }, 1000);

      },
      onClose: function(){
          swal('','window closed', 'info');
      }
    });
    handler.openIframe();
  }


function currencyConvert(amount){

    $("#conversionamount").val("");

    var currency = "CAD";
    var localcurrency = "{{ $data['getuserDetail']->currencyCode }}";
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
            'gateway': 'moneris',
            // 'gatewayMerchantId': 'gwca026583'
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
            countryCode: "{{ $data['alpha2Code']->code }}",
            currencyCode: "{{ $data['getuserDetail']->currencyCode }}",
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
            currencyCode: "{{ $data['getuserDetail']->currencyCode }}"
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



                paymentData["orderId"] = orderId;
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
            'Authorization': "Bearer "+"{{ session('api_token') }}"
        }
        });

}


        </script>





@if($data['paymentgateway']->gateway == "PayPal")

<script>
  // Paypal Integration Start

paypal.Buttons({

    createOrder: function(data, actions) {
    var netamount = $('#amounttosend').val();
    var feeamount = $('#commissiondeduct').val();
    var amount = (+netamount + +feeamount).toFixed(2);

      // Set up the transaction
      return actions.order.create({
        purchase_units: [{
          amount: {
            value: amount
          }
        }]
      });
    },
    onApprove: function(data, actions) {
      // This function captures the funds from the transaction.
      return actions.order.capture().then(function(details) {

          if(details.status == "COMPLETED"){
                $('#paymentToken').val(data.orderID);

                // alert("Looks like the transaction is approved.");
                setTimeout(() => {
                    handShake('addmoney');
                }, 1000);
          }

        // This function shows a transaction success message to your buyer.
        // alert('Transaction completed by ' + details.payer.name.given_name);
      });
    },
    onCancel: function (data) {
        alert("Transaction cancelled for "+data.orderID);
    },
    onError: function (err) {
        alert(err);
    }
  }).render('#paypal-button-container');


// PayPal Integration End
</script>

@endif



@if($data['paymentgateway']->gateway == "Stripe")

<script>

    // Stripe Integration Starts
document.addEventListener('DOMContentLoaded', async () => {

    var stripe = Stripe('{{ env("STRIPE_LIVE_PUBLIC_KEY") }}');
    // var stripe = Stripe('{{ env("STRIPE_LOCAL_PUBLIC_KEY") }}');

    var elements = stripe.elements();

    var cardElement = elements.create('card');
    cardElement.mount('#card-element');


    var form = document.querySelector('#formElem');

    form.addEventListener('submit', async(e) => {
      e.preventDefault();

    var netamount = $('#amounttosend').val();
    var feeamount = $('#commissiondeduct').val();
    var amount = (+netamount + +feeamount).toFixed(2);

     var route = '/create-payment-intent';

     var formData = new FormData(formElem);

     formData.append('paymentMethodType', 'card');
     formData.append('amount', amount);

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

            if(result.status == 200){

                // swal("Success", result.message, "success");
                // setTimeout(function(){ location.reload(); }, 2000);

                var nameInput = document.querySelector('#nameInput');
                var emailInput = document.querySelector('#emailInput');

                var paymentIntent = stripe.confirmCardPayment(
                    result.res.clientSecret, {
                    payment_method: {
                        card: cardElement,
                        billing_details: {
                            name: nameInput.value,
                            email: emailInput.value,
                        }
                    }
                    }
                ).then(function(result){
                    $('.cardSubmit').text('Pay Now');

                    if(result.error){
                        swal("Oops", result.error.message, "error");
                    }else{

                        $('#paymentToken').val(result.paymentIntent.id);

                        setTimeout(() => {
                            handShake('addmoney');
                        }, 1000);

                    }

                });


            }
            else{
                swal("Oops", result.message, "error");
            }



        },
        error: function(err) {
            $('.cardSubmit').text('Pay Now');
            swal("Oops", err.responseJSON.message, "error");

        }

    });
    });


      // Create PaymentIntent on the server
    //   var {clientSecret} = await fetch('/create-payment-intent', {
    //     method: 'POST',
    //     headers: {
    //       'Content-Type': 'application/json',
    //       'X-CSRF-TOKEN': "{{csrf_token()}}",
    //     },
    //     body: JSON.stringify({
    //       paymentMethodType: 'card',
    //       currency: $('#curCurrency').val(),
    //       amount: amount,
    //     }),

    //   }).then(resp=>resp.json);





    //   console.log(paymentIntent);

    });

});



// Stripe Integration Ends


</script>

@endif



        {{-- Google Pay API --}}

<script async
  src="https://pay.google.com/gp/p/js/pay.js"
  onload="onGooglePayLoaded()"></script>
  <script async src="{{ asset('js/moneris-googlepay.js') }}" onload="MonerisGooglePay.onReady()"></script>

  @endsection
