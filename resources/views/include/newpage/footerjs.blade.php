</div>


<!-- Vendor Scripts -->
<script src="{{ asset('newpage/js/vendor.min.js') }}"></script>
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



<script>
  $('#pricing_country').change(function() {
    var country = $('#pricing_country').val();

    $.ajax({
      url: " {{ route('merchant price') }}",
      method: 'get',
      data: country,
      success: function(data) {
      console.log(data);
    }
    });

   
    // location.href = "/pricing?country=" + country;
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
</script>


</body>


<!-- Mirrored from uxtheme.net/demos/shade-pro/light/telemedicine.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 30 Dec 2020 17:08:05 GMT -->

</html>