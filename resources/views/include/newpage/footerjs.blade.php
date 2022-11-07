</div>


<!-- Vendor Scripts -->
<script src="{{ asset('newpage/js/vendor.min.js') }}"></script>

<!-- ajax -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.26.1/axios.min.js" integrity="sha512-bPh3uwgU5qEMipS/VOmRqynnMXGGSRv+72H/N260MQeXZIK4PG48401Bsby9Nq5P5fz7hy5UGNmC/W1Z51h2GQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- Plugin's Scripts -->
<script src="{{ asset('newpage/plugins/fancybox/jquery.fancybox.min.js') }}"></script>
<script src="{{ asset('newpage/plugins/nice-select/jquery.nice-select.min.js') }}"></script>
<script src="{{ asset('newpage/plugins/aos/aos.min.js') }}"></script>
<script src="{{ asset('newpage/plugins/slick/slick.min.js') }}"></script>
<script src="{{ asset('newpage/plugins/date-picker/js/gijgo.min.js') }}"></script>
<script src="{{ asset('newpage/plugins/counter-up/jquery.waypoints.min.js') }}"></script>
<script src="{{ asset('newpage/plugins/counter-up/jquery.counterup.min.js') }}"></script>
<script src="{{ asset('newpage/plugins/theme-mode-switcher/gr-theme-mode-switcher.js') }}"></script>
<script src="{{ asset('newpage/plugins/tilt/tilt.jquery.js') }}"></script>
<!-- Load Tilt.js library -->
<!-- Activation Script -->
<script src="{{ asset('newpage/js/custom.js') }}"></script>


<script type="module">
  // Import the functions you need from the SDKs you need
  import {
    initializeApp
  } from "https://www.gstatic.com/firebasejs/9.9.1/firebase-app.js";
  import {
    getAnalytics
  } from "https://www.gstatic.com/firebasejs/9.9.1/firebase-analytics.js";
  import {
    getMessaging,
    getToken
  } from "https://www.gstatic.com/firebasejs/9.9.1/firebase-messaging.js";

  // Your web app's Firebase configuration
  // For Firebase JS SDK v7.20.0 and later, measurementId is optional
  const firebaseConfig = {
    apiKey: '{{ env("GOOGLE_VAP_KEY") }}',
    authDomain: "paysprint-310012.firebaseapp.com",
    projectId: "paysprint-310012",
    storageBucket: "paysprint-310012.appspot.com",
    messagingSenderId: "234990613861",
    appId: "1:234990613861:web:1fe95a7ccdb540aaa1dd8c",
    measurementId: "G-HNPPS15PH6"
  };

  // Initialize Firebase
  const app = initializeApp(firebaseConfig);
  const analytics = getAnalytics(app);
  const messaging = getMessaging();





  getToken(messaging, {
    vapidKey: '{{ env("GOOGLE_SERVER_KEY") }}'
  }).then((currentToken) => {
    if (currentToken) {
      // Send the token to your server and update the UI if necessary

      console.log(currentToken);
      // ...
    } else {
      // Show permission request UI
      console.log('No registration token available. Request permission to generate one.');
      // ...
    }
  }).catch((err) => {
    console.log('An error occurred while retrieving token. ', err);
    // ...
  });
</script>


<Script>
  $('#sender_money').click(function() {
    $('#tab-1').show();
    $('#tab-2').hide();
    $('#tab-3').hide();
    $('#tab-4').hide();
    $('#tab-5').hide();
    $('#receiver_money').css({
      "background-color": "#e8aa07"
    });
    $('#sender_money').css({
      "background-color": "#f2f2f2"
    });
    $('#hold_fx').css({
      "background-color": "#e8aa07"
    });
    $('#get_fx').css({
      "background-color": "#e8aa07"
    });
    $('#cross_border').css({
      "background-color": "#e8aa07"
    });
  });

  $('#receiver_money').click(function() {
    $('#tab-2').show();
    $('#tab-1').hide();
    $('#tab-3').hide();
    $('#tab-4').hide();
    $('#tab-5').hide();
    $('#receiver_money').css({
      "background-color": "#f2f2f2"
    });
    $('#sender_money').css({
      "background-color": "#e8aa07"
    });
    $('#hold_fx').css({
      "background-color": "#e8aa07"
    });
    $('#get_fx').css({
      "background-color": "#e8aa07"
    });
    $('#cross_border').css({
      "background-color": "#e8aa07"
    });
  });

  //#f2f2f2 #e8aa07

  $('#hold_fx').click(function() {
    $('#tab-2').hide();
    $('#tab-1').hide();
    $('#tab-3').show();
    $('#tab-4').hide();
    $('#tab-5').hide();
    $('#receiver_money').css({
      "background-color": "#e8aa07"
    });
    $('#sender_money').css({
      "background-color": "#e8aa07"
    });
    $('#hold_fx').css({
      "background-color": "#f2f2f2"
    });
    $('#get_fx').css({
      "background-color": "#e8aa07"
    });
    $('#cross_border').css({
      "background-color": "#e8aa07"
    });
  });


  $('#get_fx').click(function() {
    $('#tab-2').hide();
    $('#tab-1').hide();
    $('#tab-3').hide();
    $('#tab-4').show();
    $('#tab-5').hide();
    $('#receiver_money').css({
      "background-color": "#e8aa07"
    });
    $('#sender_money').css({
      "background-color": "#e8aa07"
    });
    $('#get_fx').css({
      "background-color": "#f2f2f2"
    });
    $('#hold_fx').css({
      "background-color": "#e8aa07"
    });
    $('#cross_border').css({
      "background-color": "#e8aa07"
    });
  });

  $('#cross_border').click(function() {
    $('#tab-2').hide();
    $('#tab-1').hide();
    $('#tab-3').hide();
    $('#tab-4').hide();
    $('#tab-5').show();
    $('#receiver_money').css({
      "background-color": "#e8aa07"
    });
    $('#sender_money').css({
      "background-color": "#e8aa07"
    });
    $('#hold_fx').css({
      "background-color": "#e8aa07"
    });
    $('#get_fx').css({
      "background-color": "#e8aa07"
    });
    $('#cross_border').css({
      "background-color": "#f2f2f2"
    });
  });
</script>

<script>
  $('#pricing_country').change(function() {
    var country = $('#pricing_country').val();
    location.href = "/pricing?country=" + country;
  });

  $('#pricing_country2').change(function() {
    var country = $('#pricing_country2').val();
    location.href = "/merchant-pricing?country=" + country;

  });


  $('#eclipse6').eclipse({
    margin: 20,
    autoplay: true,
    interval: 2000,
    autoControl: true
  });




  $('#amount').keyup(function() {
    $('.currencyResult').addClass('disp-0');

    $('.currencyShow');
  });


  function convertFee(method = null) {


    const amount = $('#amount').val();
    const sending = $('#sendingcountry').val();
    // alert(sending)
    const receiving = $('#receivingcountry').val();

    const data = {
      amount,
      sending,
      receiving
    }

    $('#shift').text('Loading...');

    $.ajax({

      url: "/api/v1/conversionrate/" + sending + '/' + receiving +'?method='+method,
      method: 'GET',

      success: function(rsp) {
        $('.currencyResult').removeClass('disp-0');


        const data = rsp;
        const total = data * amount;
        const convertrate = 1 / data
        $('#result').text(total);

        $('#round').text(data);

        var sender = 1 + ' ' + sending + ' ' + '=' + '' + parseFloat(data).toFixed(4) + ' ' + receiving;

        $('#rate').text(sender);

        var exchange = 1 + ' ' + receiving + '=' + convertrate.toFixed(4) + ' ' + sending
        var amountto = 'Amount to receive:';
        $('#local').text(exchange)
        var price = amount + ' ' + sending + '' + '=' + '' + total.toFixed(4) + ' ' + receiving;
        $('#totalamount').text(amountto);
        $('#totalprice').text(price);

        $('#shift').text('Exchange Rate');



        const pay = payoutMethod(receiving);


      }
    });

  }


  function payoutMethod(code) {

    $.ajax({

      url: "/api/v1/payoutmethod/" + code,
      method: 'GET',

      success: function(rsp) {
        let result = JSON.parse(rsp.data.payoutmethod);
        var finalresult = result;
        $('#paymethod1').text('Payment Method:');
        $('#paymethod').text(finalresult);
      }
    });
  }

  function receivepayoutMethod(code) {

    $.ajax({

      url: "/api/v1/payoutmethod/" + code,
      method: 'GET',

      success: function(rsp) {
        let result = JSON.parse(rsp.data.payoutmethod);
        var finalresult = result;
        $('#paysmethod1').text('Payment Method:');
        $('#paysmethod').text(finalresult);
      }
    });
  }

  $('#paying').keyup(function() {

    $('.currencyDisplay').addClass('disp-0');
    $('.currencyShow');
  });

  function rateFee(method = null) {
    // alert(1234)


    const pay = $('#paying').val();

    const local = $('#localcountry').val();
    // alert(sending)
    const foreign = $('#foreigncountry').val();

    const data = {
      pay,
      local,
      foreign
    }
    $('#shift2').text('Loading...');

    $.ajax({

      url: "/api/v1/conversionrate/" + local + "/" + foreign + '?method='+method,
      method: 'GET',

      success: function(rsp) {
        $('.currencyDisplay').removeClass('disp-0');

        const total = rsp;

        const total_divide = total * pay;

        const payer = 1 / total;
        // alert(payer);

        $('#result').text(total);
        $('#resultrate').text(total_divide);
        $('#round').text(total);
        var sender = 1 + ' ' + local + '' + '=' + '' + parseFloat(total).toFixed(4) + ' ' + foreign;
        $('#rates').text(sender);

        var exchange = 1 + ' ' + foreign + '' + '=' + payer.toFixed(4) + ' ' + local
        $('#locals').text(exchange)

        var pricetotal = pay + ' ' + local + '' + '=' + '' + total_divide.toFixed(4) + ' ' + foreign;
        $('#totalpricerate1').text('Amount to receive:');
        $('#totalpricerate').text(pricetotal);


        $('#shift2').text('Exchange Rate');

        const pays = receivepayoutMethod(foreign);

      }
    });

  }



  // Modification to Currency Rate and Fee


  $('#amount').keyup(function() {
    $('.currencyResult').addClass('disp-0');

    $('.currencyShow');
  });


  // $('#receiver_money').click(function() {
  //   alert('Hello');
  // })


  $('#paying').keyup(function() {

    $('.currencyDisplay').addClass('disp-0');
    $('.currencyShow');
  });


  $('#receive_money').click(function() {
    $('#receive_money').show();
    $('#send_money').hide();
  })
</script>


</body>


<!-- Mirrored from uxtheme.net/demos/shade-pro/light/telemedicine.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 30 Dec 2020 17:08:05 GMT -->

</html>
