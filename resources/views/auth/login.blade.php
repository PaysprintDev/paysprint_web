
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'PaySprint') }} | Login</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Favicon -->
<link rel="icon" href="https://res.cloudinary.com/pilstech/image/upload/v1618251695/paysprint_icon_new_kg2h3j.png" type="image/x-icon" />
    <!-- Bootstrap CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Animate CSS -->
    <link href="{{ asset('vendors/animate/animate.css') }}" rel="stylesheet">
    <!-- Icon CSS-->
    <link rel="stylesheet" href="{{ asset('vendors/font-awesome/css/font-awesome.min.css') }}">
    <!-- Camera Slider -->
    <link rel="stylesheet" href="{{ asset('vendors/camera-slider/camera.css') }}">
    <!-- Owlcarousel CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/owl_carousel/owl.carousel.css') }}" media="all">

    <!--Theme Styles CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}" media="all" />
    <link rel="stylesheet" type="text/css" href="{{ asset('pace/themes/orange/pace-theme-flash.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">

    <style>
    /* width */
body::-webkit-scrollbar {
  width: 6px;
}

/* Track */
body::-webkit-scrollbar-track {
  background: #f1f1f1;
}

/* Handle */
body::-webkit-scrollbar-thumb {
  background: #f6b60b;
}

/* Handle on hover */
body::-webkit-scrollbar-thumb:hover {
  background: #f6b60b;
}
.input_box{
    color: #000 !important;
}
.form-control{
    border-color: #f6b60d !important;
    width: 100% !important;
}
    </style>

</head>
<body>

    <!-- Preloader -->
    <div class="preloader"></div>

    <!-- Top Header_Area -->
    <section class="top_header_area">
        <div class="container">
            <ul class="nav navbar-nav top_nav">
                {{-- <li><a href="#"><i class="fa fa-phone"></i>+1 (168) 314 5016</a></li>
                <li><a href="#"><i class="fa fa-envelope-o"></i>info@thethemspro.com</a></li>
                <li><a href="#"><i class="fa fa-clock-o"></i>Mon - Sat 12:00 - 20:00</a></li> --}}

                <li>
                    <a href="{{ route('login') }}">
                       {{ __('Login') }}
                    </a>
                </li>

                <li>
                    <a href="{{ route('register') }}">
                       {{ __('Sign Up for FREE') }}
                    </a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right social_nav">
                <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                <li><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>

            </ul>
        </div>
    </section>
    <!-- End Top Header_Area -->

    <!-- Header_Area -->
    <nav class="navbar navbar-default header_aera" id="main_navbar">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="col-md-2 p0">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#min_navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{ route('home') }}"><p style="font-weight: bold; font-size: 30px; color: #111f29 font-family: tahoma"><span style="color: #f6b60b">Pay</span>Sprint</p></a>
                </div>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="col-md-10 p0">
                <div class="collapse navbar-collapse" id="min_navbar">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown submenu">
                            <a href="{{ route('home') }}">Home</a>

                        </li>

{{--                         <li class="dropdown submenu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Services</a>
                            <ul class="dropdown-menu other_dropdwn">
                                <li><a href="#">Property Tax</a></li>
                                <li><a href="#">Utility Bill</a></li>
                                <li><a href="#">Tickets</a></li>
                                <li><a href="#">Others</a></li>
                            </ul>
                        </li> --}}

                        
                        <li class="dropdown submenu">
                            <a href="{{ route('about') }}">About Us</a>
                        </li>
                        <li class="dropdown submenu">
                            <a href="{{ route('contact') }}">Contact</a>
                        </li>

                        <li class="dropdown submenu">
                            <a href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="dropdown submenu">
                            <a href="{{ route('register') }}">Sign Up for FREE</a>
                        </li>


                    </ul>
                </div><!-- /.navbar-collapse -->
            </div>
        </div><!-- /.container -->
    </nav>
    <!-- End Header_Area -->

    <!-- Banner area -->
    <section class="banner_area" data-stellar-background-ratio="0.5">
        <h2>Login</h2>
        <ol class="breadcrumb">
            <li><a href="{{ route('home') }}">Home</a></li>
            <li><a href="{{ route('login') }}" class="active">Login</a></li>
        </ol>
    </section>
    <!-- End Banner area -->

    <!-- All contact Info -->
    <section class="all_contact_info">
        <div class="container">
            <div class="row contact_row">
                <div class="col-sm-6 contact_info">
                    <img src="https://res.cloudinary.com/pilstech/image/upload/v1617797524/paysprint_asset/paysprint_jpeg_black_bk_ft8qly.jpg" style="width: 100%;">
                </div>
                <div class="col-sm-6 contact_info send_message">
                    <h2>Login</h2>


<ul class="nav nav-tabs" id="myTab" role="tablist">

  <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">User</a></li>

  <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Merchant</a></li>
</ul>

<div class="tab-content" id="myTabContent">
  <div role="tabpanel" class="tab-pane active" id="home">
      <form class="form-inline contact_box" action="{{ route('login') }}" method="POST" id="form-login">
        @csrf

        <div class="loginForm animated SlideIn">

            <input type="email" name="email" id="loginemail" class="form-control input_box" value="{{ old('email') }}" required autocomplete="email" placeholder="Type your email *" autofocus>

            <input type="password" name="password" id="loginpassword" class="form-control input_box" placeholder="Password *" required>



            <button type="button" class="btn btn-default loginBtn" onclick="login()">Login</button>
            <img src="https://cdn.dribbble.com/users/608059/screenshots/2032455/spinner.gif" class="spinner disp-0" style="width: auto; height: 50px;">

            @if (Route::has('password.request'))
                <a class="btn btn-link" href="{{ route('password.request') }}">
                    {{ __('Forgot Your Password?') }}
                </a>
            @endif

            <a class="btn btn-link" href="{{ route('register') }}">
                    {{ __('Don\'t have an account? Sign Up for FREE now') }}
                </a>

        </div>


    </form>
  </div>
  <div role="tabpanel" class="tab-pane" id="profile">
      <br>
        <div class="display-3">
          <h4 class="text-center">Click the button to login as Merchant.</h4>
      </div>

      <br>

      <button class="btn btn-danger btn-block" onclick="gotoMerchant()">Login as a Merchant</button>

  </div>
</div>










                    
                    
                </div>
            </div>
        </div>
    </section>
    <!-- End All contact Info -->

<!--Footer Area -->
    <footer class="footer_area">
        <div class="container">
            <div class="footer_row row">
                <div class="col-md-3 col-sm-6 footer_about">
                    <h2 style="padding-bottom: 0px !important;">ABOUT OUR COMPANY</h2>
                    {{-- <p style="font-weight: bold; font-size: 30px;">Pay<span style="color: #f6b60b">Sprint</span></p> --}}
                    <img src="https://res.cloudinary.com/pilstech/image/upload/v1603726392/pay_sprint_white_horizotal_mb5ouw.png" style="position: relative; left: -40px;">
                    {{-- <p>Payca or electronic bill payment, is when a seller such as company, organization, or group sends its bills or invoices over the internet, and customers pay the bills electronically.</p> --}}
                    <p style="padding-top: 0px !important;">PaySprint is the fastest and affordable method of Sending and Receiving money, Paying Invoice and Getting Paid at anytime!</p>
                    <ul class="socail_icon">
                        <li><a href="https://www.facebook.com/EXPRESSCANADA2014/?modal=admin_todo_tour" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                        <li><a href="https://twitter.com/EXBC2" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>

                        <li><a href="https://instagram.com/exbc2014" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>

                        <li><a href="https://www.linkedin.com/company/exbc-canada/?viewAsMember=true" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                    </ul>
                </div>
                <div class="col-md-3 col-sm-6 footer_about quick">
                    <h2>Services</h2>
                    <ul class="quick_link">
                        @guest
                        <li><a href="{{ route('my account') }}"><i class="fa fa-chevron-right"></i>Money Transfer</a></li>
                        @endguest

                        @auth
                            <li onclick="$('#sendMoney').click()"><a href="javascript:void()"><i class="fa fa-chevron-right"></i>Money Transfer</a></li>
                            
                        @endauth
                        <li><a href="{{ route('invoice') }}"><i class="fa fa-chevron-right"></i>Pay Invoice</a></li>
                        <li><a href="{{ route('my account') }}"><i class="fa fa-chevron-right"></i>Wallet</a></li>
                        {{-- <li><a href="#"><i class="fa fa-chevron-right"></i>Parking Tickets</a></li> --}}
                        {{-- <li><a href="#"><i class="fa fa-chevron-right"></i>Commercial Construction</a></li> --}}
                        {{-- <li><a href="#"><i class="fa fa-chevron-right"></i>Concreate Transport</a></li> --}}
                    </ul>
                </div>
                <div class="col-md-3 col-sm-6 footer_about">
                    <h2>Quick link</h2>
                    <ul class="quick_link">
                        <li><a href="{{ route('about') }}"><i class="fa fa-chevron-right"></i>About Us</a></li>
                        <li><a href="{{ route('contact') }}"><i class="fa fa-chevron-right"></i>Contact Us</a></li>
                        <li><a href="{{ route('terms of use') }}"><i class="fa fa-chevron-right"></i>Terms of Use</a></li>
                        <li><a href="{{ route('privacy policy') }}"><i class="fa fa-chevron-right"></i>Privacy Policy</a></li>
                        @guest
                            <li><a href="{{ route('login') }}"><i class="fa fa-chevron-right"></i>Login</a></li>
                        <li><a href="{{ route('register') }}"><i class="fa fa-chevron-right"></i>Sign Up for FREE</a></li>
                        @endguest
                        


                    </ul>
                </div>
                <div class="col-md-3 col-sm-6 footer_about">
                    <h2>CONTACT US</h2>
                    <address>
                        <ul class="my_address">
                            <li><a href="#"><i class="fa fa-envelope" aria-hidden="true"></i>info@paysprint.net</a></li><br>
                            <li><a href="#"><i class="fa fa-map-marker" aria-hidden="true"></i><span> PaySprint by Express Ca Corp, <br> 10 George St. North, Brampton. ON. L6X1R2. Canada </span></a></li>
                        </ul>
                    </address>
                </div>
            </div>
        </div>
        <div class="copyright_area">
            Copyright 2019 - {{ date('Y') }} All rights reserved.
        </div>
    </footer>
    <!-- End Footer Area -->



    <!-- jQuery JS -->
    <script src="{{ asset('js/jquery-1.12.0.min.js') }}"></script>
    <script src="{{ asset('pace/pace.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://raw.githubusercontent.com/HubSpot/pace/v1.0.0/pace.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <!-- Animate JS -->
    <script src="{{ asset('vendors/animate/wow.min.js') }}"></script>
    <!-- Camera Slider -->
    <script src="{{ asset('vendors/camera-slider/jquery.easing.1.3.js') }}"></script>
    <script src="{{ asset('vendors/camera-slider/camera.min.js') }}"></script>
    <!-- Isotope JS -->
    <script src="{{ asset('vendors/isotope/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('vendors/isotope/isotope.pkgd.min.js') }}"></script>
    <!-- Progress JS -->
    <script src="{{ asset('vendors/Counter-Up/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('vendors/Counter-Up/waypoints.min.js') }}"></script>
    <!-- Owlcarousel JS -->
    <script src="{{ asset('vendors/owl_carousel/owl.carousel.min.js') }}"></script>
    <!-- Stellar JS -->
    <script src="{{ asset('vendors/stellar/jquery.stellar.js') }}"></script>
    <!-- Theme JS -->
    <script src="{{ asset('js/theme.js') }}"></script>


    

{{-- Ajax --}}

<script>

    $(document).ready(function(){

        var url_string = window.location.href;
        var url = new URL(url_string);
        var c = url.searchParams.get("user");
        var tenant = url.searchParams.get("tenant");
        var property_owner = url.searchParams.get("property_owner");
        var service_provider = url.searchParams.get("service_provider");

        if(Boolean(c) == true){
            $('.loginForm').removeClass('disp-0');
            $('#loginemail').val(c);
            $('.loginBtn').attr('disabled', true);
            // $('#form-login').submit();
                // Do Ajax
            var route = "{{ URL('Ajax/loginApi') }}";
            var thisdata = {email: c, action: 'login'};
            setHeaders();
            jQuery.ajax({
                url: route,
                method: 'post',
                data: thisdata,
                dataType: 'JSON',
                success: function(result){
                    // $('#form-login').submit();
                    setTimeout(function(){ location.href = result.link; }, 1000);
                }
            });

        }
        else if(Boolean(tenant) == true){
            $('.loginForm').removeClass('disp-0');
            $('#loginemail').val(tenant);
            $('.loginBtn').attr('disabled', true);
            // $('#form-login').submit();
                // Do Ajax
            var route = "{{ URL('Ajax/loginApi') }}";
            var thisdata = {email: tenant, action: 'rpm_tenant'};
            setHeaders();
            jQuery.ajax({
                url: route,
                method: 'post',
                data: thisdata,
                dataType: 'JSON',
                success: function(result){
                    // $('#form-login').submit();
                    setTimeout(function(){ location.href = location.origin+"/"+result.link; }, 1000);
                }
            });

        }
        else if(Boolean(property_owner) == true){
            $('.loginForm').removeClass('disp-0');
            $('#loginemail').val(property_owner);
            $('.loginBtn').attr('disabled', true);
            // $('#form-login').submit();
                // Do Ajax
            var route = "{{ URL('Ajax/loginApi') }}";
            var thisdata = {email: property_owner, action: 'rpm_property_owner'};
            setHeaders();
            jQuery.ajax({
                url: route,
                method: 'post',
                data: thisdata,
                dataType: 'JSON',
                success: function(result){
                    // $('#form-login').submit();
                    setTimeout(function(){ location.href = location.origin+"/"+result.link; }, 1000);
                }
            });

        }
        
        else if(Boolean(service_provider) == true){
            $('.loginForm').removeClass('disp-0');
            $('#loginemail').val(service_provider);
            $('.loginBtn').attr('disabled', true);
            // $('#form-login').submit();
                // Do Ajax
            var route = "{{ URL('Ajax/loginApi') }}";
            var thisdata = {email: service_provider, action: 'rpm_service_provider'};
            setHeaders();
            jQuery.ajax({
                url: route,
                method: 'post',
                data: thisdata,
                dataType: 'JSON',
                success: function(result){
                    // $('#form-login').submit();
                    setTimeout(function(){ location.href = location.origin+"/"+result.link; }, 1000);
                }
            });

        }


        $('#services').change(function(){
            if($('#services').val() == 'Client'){
                swal({
                title: "Hello",
                text: "We shall be redirecting you to your login environment. Click OK to accept",
                icon: "success",
                buttons: true,
                dangerMode: true,
                })
                .then((willDelete) => {
                if (willDelete) {
                    location.href = "AdminLogin";
                } else {

                }
                });
            }
            else if($('#services').val() == 'User'){
                $('.loginForm').removeClass('disp-0');

            $('#accountType').change(function(){



            if($('#accountType').val() == 'Individual'){
                $('.indForm').removeClass('disp-0');
                $('.busForm').addClass('disp-0');
            }
            else if($('#accountType').val() == 'Business'){
                $('.indForm').addClass('disp-0');
                $('.busForm').removeClass('disp-0');
            }
            else{
                $('.indForm').addClass('disp-0');
                $('.busForm').addClass('disp-0');
            }
        });
            }
            else{
                $('.indForm').addClass('disp-0');
                $('.busForm').addClass('disp-0');
                $('.loginForm').addClass('disp-0');
            }
        });






    });
    



function gotoMerchant(){
    swal({
    title: "Hello",
    text: "We shall be redirecting you to your login environment. Click OK to accept",
    icon: "success",
    buttons: true,
    dangerMode: true,
    })
    .then((willDelete) => {
    if (willDelete) {
        location.href = "AdminLogin";
    } else {

    }
    });
}


// User Registration

function login(accountType){

var route = "{{ URL('Ajax/Ajaxlogin') }}";
var thisdata;
var spinner = $('.spinner');
var submitBtn = $('.loginBtn');
var email = $('#loginemail').val();
var password = $('#loginpassword').val();

if(email == ""){
    swal('Oops', 'Your email is important for login', 'info');
    return false;
}
if(password == ""){
    swal('Oops', 'Your password is important for authentication', 'info');
    return false;
}

thisdata = {email: email, password: password}
    // Initiate Ajax Call
    Pace.restart();
    Pace.track(function(){
      setHeaders();
          jQuery.ajax({
          url: route,
          method: 'post',
          data: thisdata,
          dataType: 'JSON',
          beforeSend: function(){
            spinner.removeClass('disp-0');
            submitBtn.addClass('disp-0');
          },
          success: function(result){
              spinner.addClass('disp-0');
            submitBtn.removeClass('disp-0');
            if(result.message == 'success'){
                swal('Hello', result.res, result.message);
                $('#form-login').submit();
            }
            else{
                spinner.addClass('disp-0');
                submitBtn.removeClass('disp-0');
                swal('Oops', result.res, result.message);
            }
            },
            error: function(err) {
                spinner.addClass('disp-0');
                submitBtn.removeClass('disp-0');
                swal("Oops", err.responseJSON.message, "error");

            } 

      });
    });


}

    //Set CSRF HEADERS
 function setHeaders(){
    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': "{{csrf_token()}}"
      }
    });
 }


</script>

</body>
</html>
