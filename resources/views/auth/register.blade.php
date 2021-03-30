<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'PaySprint') }} | Register</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Favicon -->
    <link rel="icon" href="https://img.icons8.com/nolan/64/000000/paycheque.png" type="image/x-icon" />
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
                       {{ __('Register') }}
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
        <h2>Register</h2>
        <ol class="breadcrumb">
            <li><a href="{{ route('home') }}">Home</a></li>
            <li><a href="{{ route('register') }}" class="active">Register</a></li>
        </ol>
    </section>
    <!-- End Banner area -->

    <!-- All contact Info -->
    <section class="all_contact_info">
        <div class="container">
            <div class="row contact_row">
                <div class="col-sm-6 contact_info">
                    <img src="https://thumbs.gfycat.com/GlossyAdoredJapanesebeetle-small.gif" style="width: 100%;">
                </div>
                <div class="col-sm-6 contact_info send_message">
                    <h2>Register for FREE</h2>

                    <ul class="nav nav-tabs" id="myTab" role="tablist">

  <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Individual</a></li>

  <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Merchant</a></li>
</ul>

<div class="tab-content" id="myTabContent">
  <div role="tabpanel" class="tab-pane active" id="home">
                    <form class="form-inline contact_box" action="#" method="POST">
                        @csrf

                    <div class="indselectForm animated fadeIn choice">
                        <select class="form-control input_box" style="color: #000 !important;" name="account" id="accountType">
                            <option value="">--Select account type--</option>
                            <option value="Individual">Individual</option>
                            <option value="Business">Business</option>
                        </select>
                        </div>

                        <div class="indForm animated rollIn disp-0">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="fname">First Name</label>
                                        <input type="text" id="fname" name="firstname" class="form-control input_box" placeholder="First Name *" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="lname">Last Name</label>
                                        <input type="text" id="lname" name="lastname" class="form-control input_box" placeholder="Last Name *" required>
                                    </div>
                                </div>
                            </div>

                            <label for="email">Email Address</label>
                                        <input type="email" name="email" id="email" class="form-control input_box" placeholder="Your Email *" required>
                            
                            <label for="cemail">Confirm Email Address</label>
                                        <input type="email" name="cemail" id="cemail" class="form-control input_box" placeholder="Confirm Your Email *" required>
                            

                            

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="city">City</label>
                                        <input type="text" name="city" id="city" class="form-control input_box" placeholder="City *" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="zipcode">Postal/Zip code</label>
                                        <input type="text" name="zipcode" id="zipcode" class="form-control input_box" placeholder="Postal/Zip code">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="country">Country</label>

                                        <select name="country" id="country" class="form-control input_box countries" required></select>
                                        {{-- <input type="text" name="country" id="country" class="form-control input_box countries" placeholder="Country *" required> --}}
                                </div>
                                <div class="col-sm-6">

                                    <label for="state">Province/State</label>
                                        <select name="state" id="state" class="form-control input_box" required></select>
                                    {{-- <input type="text" name="state" id="state" class="form-control input_box" placeholder="Province/State *" required> --}}

                                    
                                </div>
                                
                            </div>


                            <label for="address">Address</label>
                                <input type="text" name="address" id="address" class="form-control input_box" placeholder="Address *" required>

                            <div class="row">

                                <div class="col-sm-6">

                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" name="password" id="password" class="form-control input_box" placeholder="Password *" required>
                                    </div>

                                    

                                </div>
                                <div class="col-sm-6">

                                    <div class="form-group">
                                        <label for="password-confirm">Confirm Password</label>
                                        <input type="password" name="confirmpassword" id="password-confirm" class="form-control input_box" placeholder="Confirm Password *" required>
                                    </div>

                                    
                                </div>
                            </div>
                            

                            <button type="button" class="btn btn-default submitBtn" onclick="register('Individual')" style="width: 100% !important">Sign Up</button>
                            <img src="https://cdn.dribbble.com/users/608059/screenshots/2032455/spinner.gif" class="spinner disp-0" style="width: auto; height: 50px;">
                        </div>


                        <div class="busForm animated rollIn disp-0">
                            <label for="busname">Business Name</label>
                            <input type="text" name="businessname" id="busname" class="form-control input_box" placeholder="Business Name *" required>
                            
                            <label for="busaddress">Business Address</label>
                            <input type="text" name="address" id="busaddress" class="form-control input_box" placeholder="Address *" required>

                            <label for="buscorporationtype">Corporation Type</label>
                            <input type="text" name="corporationtype" id="buscorporationtype" class="form-control input_box" placeholder="Corporation Type *" required>

                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="busfname">First Name</label>
                                    <input type="text" id="busfname" name="firstname" class="form-control input_box" placeholder="First Name *" required>
                                </div>
                                <div class="col-sm-6">
                                    <label for="buslname">Last Name</label>
                                    <input type="text" id="buslname" name="lastname" class="form-control input_box" placeholder="Last Name *" required>
                                </div>
                            </div>

                            <label for="busemail">Email Address</label>
                            <input type="email" name="email" id="busemail" class="form-control input_box" placeholder="Your Email *" required>

                            <label for="buscemail">Confirm Email Address</label>
                            <input type="email" name="cemail" id="buscemail" class="form-control input_box" placeholder="Confirm Your Email *" required>

                            <div class="row">

                                <div class="col-sm-6">
                                    <label for="buscity">City</label>
                                    <input type="text" name="city" id="buscity" class="form-control input_box" placeholder="City *" required>
                                </div>

                                <div class="col-sm-6">
                                    <label for="buszipcode">Postal/Zip code</label>
                                    <input type="text" name="zipcode" id="buszipcode" class="form-control input_box" placeholder="Postal/Zip code">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="buscountry">Country</label>
                                    <select name="country" id="buscountry" class="form-control input_box countries" required></select>
                                    {{-- <input type="text" name="country" id="buscountry" class="form-control input_box countries" placeholder="Country *" required> --}}
                                </div>
                                <div class="col-sm-6">
                                    <label for="busstate">Province/State</label>
                                    <select name="state" id="busstate" class="form-control input_box" required></select>
                                    {{-- <input type="text" name="state" id="busstate" class="form-control input_box" placeholder="Province/State *" required> --}}
                                </div>
                            </div>

                            

                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="buspassword">Password</label>
                                    <input type="password" name="password" id="buspassword" class="form-control input_box" placeholder="Password *" required>

                                </div>
                                <div class="col-sm-6">
                                    <label for="buspassword-confirm">Confirm Password</label>
                                    <input type="password" name="confirmpassword" id="buspassword-confirm" class="form-control input_box" placeholder="Confirm Password *" required>
                                </div>
                            </div>
                            

                            <button type="button" class="btn btn-default submitBtn" onclick="register('Business')" style="width: 100% !important">Sign Up</button>
                            <img src="https://cdn.dribbble.com/users/608059/screenshots/2032455/spinner.gif" class="spinner disp-0" style="width: auto; height: 50px;">
                        </div>


                    </form>
  </div>
  <div role="tabpanel" class="tab-pane" id="profile">
      <br>
        <div class="display-3">
          <h4 class="text-center">Click the button to register as Merchant.</h4>
      </div>

      <br>

      <button class="btn btn-danger btn-block" onclick="gotoMerchant()">Register as a Merchant</button>

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
                    <h2>ABOUT OUR COMPANY</h2>
                    <p style="font-weight: bold; font-size: 30px; color: #111f29 font-family: tahoma"><span style="color: #f6b60b">E-</span>BILLING</p>
                    <p>Electronic billing or electronic bill payment and presentment, is when a seller such as company, organization, or group sends its bills or invoices over the internet, and customers pay the bills electronically.</p>
                    <ul class="socail_icon">
                        <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>

                        <li><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                    </ul>
                </div>
                <div class="col-md-3 col-sm-6 footer_about quick">
                    <h2>Services</h2>
                    <ul class="quick_link">
                        <li><a href="#"><i class="fa fa-chevron-right"></i>Property tax</a></li>
                        <li><a href="#"><i class="fa fa-chevron-right"></i>Utility Bill</a></li>
                        <li><a href="#"><i class="fa fa-chevron-right"></i>Tickets</a></li>
                        <li><a href="#"><i class="fa fa-chevron-right"></i>Others</a></li>
                        {{-- <li><a href="#"><i class="fa fa-chevron-right"></i>Commercial Construction</a></li> --}}
                        {{-- <li><a href="#"><i class="fa fa-chevron-right"></i>Concreate Transport</a></li> --}}
                    </ul>
                </div>
                <div class="col-md-3 col-sm-6 footer_about">
                    <h2>Quick link</h2>
                    <ul class="quick_link">
                        <li><a href="{{ route('home') }}"><i class="fa fa-chevron-right"></i>Home</a></li>
                        <li><a href="{{ route('invoice') }}"><i class="fa fa-chevron-right"></i>Invoices</a></li>
                        <li><a href="{{ route('statement') }}"><i class="fa fa-chevron-right"></i>Statement</a></li>

                    </ul>
                </div>
                <div class="col-md-3 col-sm-6 footer_about">
                    <h2>CONTACT US</h2>
                    <address>
                        <p>Have questions, comments or just want to say hello:</p>
                        <ul class="my_address">
                            <li><a href="#"><i class="fa fa-envelope" aria-hidden="true"></i>info@e-billing.com</a></li>
                            <li><a href="#"><i class="fa fa-phone" aria-hidden="true"></i>+123-456-789</a></li>
                            <li><a href="#"><i class="fa fa-map-marker" aria-hidden="true"></i><span> Ontario, Canada </span></a></li>
                        </ul>
                    </address>
                </div>
            </div>
        </div>
        <div class="copyright_area">
            Copyright 2019 All rights reserved.
        </div>
    </footer>
    <!-- End Footer Area -->

    <!-- jQuery JS -->
    <script src="{{ asset('js/jquery-1.12.0.min.js') }}"></script>
    <script src="{{ asset('js/country-state-select.js') }}"></script>
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


<script language="javascript">
    populateCountries("country", "state");
    populateCountries("buscountry", "busstate");

</script>

{{-- Ajax --}}

<script>

    $(document).ready(function(){

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


    });


    function gotoMerchant(){

        swal({
        title: "Hello",
        text: "We shall be redirecting you to your registration environment. Click OK to accept",
        icon: "success",
        buttons: true,
        dangerMode: true,
        })
        .then((willDelete) => {
        if (willDelete) {
            location.href = "AdminRegister";
        } else {

        }
        });
    }


// User Registration

function register(accountType){

var route = "{{ URL('Ajax/Ajaxregister') }}";
var thisdata;
var spinner = $('.spinner');
var submitBtn = $('.submitBtn');
var fname; var lname; var email; var cemail; var city; var country;
var state; var address; var password; var cpassword; var zipcode; var busname;
var corporationtype
    if(accountType == "Individual"){
        fname = $('#fname').val();
        lname = $('#lname').val();
        email = $('#email').val();
        cemail = $('#cemail').val();
        country = $('#country').val();
        state = $('#state').val();
        city = $('#city').val();
        address = $('#address').val();
        password = $('#password').val();
        zipcode = $('#zipcode').val();
        cpassword = $('#password-confirm').val();

        if(fname == ""){
            swal('Oops', 'Firstname field can\'t be empty', 'info');
            return false;
        }if(lname == ""){
            swal('Oops', 'Lastname field can\'t be empty', 'info');
            return false;
        }if(email == ""){
            swal('Oops', 'Email field can\'t be empty', 'info');
            return false;
        }if(cemail == ""){
            swal('Oops', 'You must confirm email', 'info');
            return false;
        }if(country == ""){
            swal('Oops', 'Country field can\'t be empty', 'info');
            return false;
        }if(state == ""){
            swal('Oops', 'State field can\'t be empty', 'info');
            return false;
        }if(city == ""){
            swal('Oops', 'City field can\'t be empty', 'info');
            return false;
        }if(address == ""){
            swal('Oops', 'Address field can\'t be empty', 'info');
            return false;
        }if(password == ""){
            swal('Oops', 'Password field can\'t be empty', 'info');
            return false;
        }if(cpassword == ""){
            swal('Oops', 'You must confirm password', 'info');
            return false;
        }

        if(email != cemail){
            swal('Oops', 'Email doesn\'t match, Please check your email', 'error');
            return false;
        }

        if(password != cpassword){
            swal('Oops', 'Password doesn\'t match, Please clear password and type again', 'error');
            return false;
        }


        thisdata = {
            fname: fname, lname: lname, email: email,
            country: country, state: state, city: city,
            address: address, password: password, zipcode: zipcode,
            accountType: accountType
        };
    }
    else if(accountType == "Business"){
        busname = $('#busname').val();
        address = $('#busaddress').val();
        corporationtype = $('#buscorporationtype').val();
        email = $('#busemail').val();
        cemail = $('#buscemail').val();
        fname = $('#busfname').val();
        lname = $('#buslname').val();
        country = $('#buscountry').val();
        state = $('#busstate').val();
        city = $('#buscity').val();
        password = $('#buspassword').val();
        zipcode = $('#buszipcode').val();
        cpassword = $('#buspassword-confirm').val();

        if(busname == ""){
            swal('Oops', 'Business Name field can\'t be empty', 'info');
            return false;
        }if(corporationtype == ""){
            swal('Oops', 'Corporation Type need to be specified', 'info');
            return false;
        }if(fname == ""){
            swal('Oops', 'Firstname field can\'t be empty', 'info');
            return false;
        }if(lname == ""){
            swal('Oops', 'Lastname field can\'t be empty', 'info');
            return false;
        }if(email == ""){
            swal('Oops', 'Email field can\'t be empty', 'info');
            return false;
        }if(cemail == ""){
            swal('Oops', 'You must confirm email', 'info');
            return false;
        }if(country == ""){
            swal('Oops', 'Country field can\'t be empty', 'info');
            return false;
        }if(state == ""){
            swal('Oops', 'State field can\'t be empty', 'info');
            return false;
        }if(city == ""){
            swal('Oops', 'City field can\'t be empty', 'info');
            return false;
        }if(address == ""){
            swal('Oops', 'Address field can\'t be empty', 'info');
            return false;
        }if(password == ""){
            swal('Oops', 'Password field can\'t be empty', 'info');
            return false;
        }if(cpassword == ""){
            swal('Oops', 'You must confirm password', 'info');
            return false;
        }

        if(email != cemail){
            swal('Oops', 'E-mail doesn\'t match, Please check your email', 'error');
            return false;
        }

        if(password != cpassword){
            swal('Oops', 'Password doesn\'t match, Please clear password and type again', 'error');
            return false;
        }

        thisdata = {
           busname: busname, corporationtype: corporationtype, fname: fname,
           lname: lname, email: email, country: country,
           state: state, city: city, address: address, password: password, zipcode: zipcode,
           accountType: accountType
        };

    }


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
            if(result.message == 'success'){
                spinner.addClass('disp-0');
                submitBtn.removeClass('disp-0');
            swal('Welcome', result.res, result.message);
            setTimeout(function(){ location.href = result.link; }, 5000);
            }else{
                spinner.addClass('disp-0');
                submitBtn.removeClass('disp-0');
                swal('Oops', result.res, result.message);
            }
            },
            error: function(err) {
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
