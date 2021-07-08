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
<script src="{{ asset('newpage/plugins/tilt/tilt.jquery.js') }}"></script> <!-- Load Tilt.js library -->
<!-- Activation Script -->
<script src="{{ asset('newpage/js/custom.js') }}"></script>



<script>
    $('#pricing_country').change(function(){
        var country = $('#pricing_country').val();
        
        location.href = "/pricing?country="+country;
    });
</script>


</body>


<!-- Mirrored from uxtheme.net/demos/shade-pro/light/telemedicine.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 30 Dec 2020 17:08:05 GMT -->

</html>
