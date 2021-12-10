<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'PaySprint') }} | Sign Up for RFEE</title>

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

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <script src="https://kit.fontawesome.com/384ade21a6.js"></script>

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

.disp-0{
    display: none !important;
}
    .reqField{
      color: red;
      font-weight: bold;
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
        <h2>Sign Up for FREE</h2>
        <ol class="breadcrumb">
            <li><a href="{{ route('home') }}">Home</a></li>
            <li><a href="{{ route('register') }}" class="active">Sign Up for FREE</a></li>
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
                    <h2>Sign Up for FREE</h2>

                    <ul class="nav nav-tabs" id="myTab" role="tablist">

  <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">User Account</a></li>

  <li class="disp-0" role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Merchant</a></li>
</ul>

<div class="tab-content" id="myTabContent">
  <div role="tabpanel" class="tab-pane active" id="home">

    {{-- Include Controller --}}

    {{-- {{ Request::get('user') }} --}}
    <?php use \App\Http\Controllers\AnonUsers; ?>


{{-- http://localhost:9090/register?user=12873 --}}

                    <form class="form-inline contact_box" action="#" method="POST">
                        @csrf

                    {{-- <div class="indselectForm animated fadeIn choice">
                        <select class="form-control input_box" style="color: #000 !important;" name="account" id="accountType">
                            <option value="">--Select account type--</option>
                            <option value="Individual">Personal</option>
                            <option value="Business">Business</option>
                        </select>
                        </div> --}}

                        @if (Request::get('user') != null)
                            @if($newuser = \App\AnonUsers::where('ref_code', Request::get('user'))->first())

                                @php
                                    $name = explode(" ", $newuser->name);
                                    $ref_code = Request::get('user');
                                    $fname = $name[0];
                                    $lname = $name[1];
                                    $email = $newuser->email;
                                @endphp

                            @endif
                        @else

                            @php
                                $ref_code = "";
                                $fname = "";
                                $lname = "";
                                $email = "";
                            @endphp
                            
                        @endif

                        <input type="hidden" name="ref_code" id="ref_code" @if($ref_code != "") value="{{ $ref_code }}" readonly @else placeholder="Ref code" @endif>

                        <div class="indForm animated rollIn">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="fname"><span class="reqField">*</span> First Name</label>
                                        

                                        <input type="text" id="fname" name="firstname" class="form-control input_box" @if($fname != "") value="{{ $fname }}" readonly @else placeholder="First Name *" required @endif >
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="lname"><span class="reqField">*</span> Last Name</label>
                                        <input type="text" id="lname" name="lastname" class="form-control input_box" @if($lname != "") value="{{ $lname }}" readonly @else placeholder="Last Name *" required @endif>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="dayOfBirth"><span class="reqField">*</span> Day of Birth</label>
                                        
                                        <select name="dayOfBirth" id="dayOfBirth" class="form-control">
                                            @for ($i = 1; $i <= 31; $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="monthOfBirth"><span class="reqField">*</span> Month of Birth</label>
                                        <select name="monthOfBirth" id="monthOfBirth" class="form-control">
                                            <option selected value='1'>January</option>
                                            <option value='2'>February</option>
                                            <option value='3'>March</option>
                                            <option value='4'>April</option>
                                            <option value='5'>May</option>
                                            <option value='6'>June</option>
                                            <option value='7'>July</option>
                                            <option value='8'>August</option>
                                            <option value='9'>September</option>
                                            <option value='10'>October</option>
                                            <option value='11'>November</option>
                                            <option value='12'>December</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="yearOfBirth"><span class="reqField">*</span> Year of Birth</label>
                                        <select name="yearOfBirth" id="yearOfBirth" class="form-control">
                                            @for ($i = 1900; $i <= date('Y'); $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <br>
                            <label for="autocomplete">Auto complete address</label>
                            <input id="autocomplete" placeholder="Enter your address" onFocus="geolocate()" type="text" class="form-control input_box">
                                    <div class="row">
                                    <div class="col-md-6">
                                        <label class="control-label"><span class="reqField">*</span> Street Number</label>
                                        <input class="form-control input_box" name="street_number" id="street_number" disabled="false" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="control-label"><span class="reqField">*</span> Street Name/Route</label>
                                        <input class="form-control input_box" name="route" id="route" disabled="false" readonly>
                                    </div>
                                    </div>
                                    <div class="row">
                                    <div class="col-md-6">
                                        <label class="control-label"><span class="reqField">*</span> City</label>
                                        <input class="form-control input_box field" name="locality" id="locality" disabled="false">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="control-label"><span class="reqField">*</span> Postal/Zip code</label>
                                        <input class="form-control input_box" name="postal_code" id="postal_code" disabled="false">
                                    </div>

                                    
                                    </div>

                            
                            <br>

                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="country"><span class="reqField">*</span> Country</label>

                                        <select name="country" id="country" class="form-control input_box countries" required></select>
                                        {{-- <input type="text" name="country" id="country" class="form-control input_box countries" placeholder="Country *" required> --}}
                                </div>
                                <div class="col-sm-6">

                                    <label for="state"><span class="reqField">*</span> Province/State</label>
                                        <select name="state" id="state" class="form-control input_box" required></select>
                                    {{-- <input type="text" name="state" id="state" class="form-control input_box" placeholder="Province/State *" required> --}}

                                    
                                </div>
                                
                            </div>

                            <label for="email"><span class="reqField">*</span> Email Address</label>
                                        <input type="email" name="email" id="email" class="form-control input_box" @if($email != "") value="{{ $email }}" readonly @else placeholder="Your Email *" required @endif>
                            
                            <label for="cemail"><span class="reqField">*</span> Confirm Email Address</label>
                                        <input type="email" name="cemail" id="cemail" class="form-control input_box" @if($email != "") value="{{ $email }}" readonly @else placeholder="Confirm Your Email *" required @endif>

                            

                            <div class="row">

                                <div class="col-sm-6">

                                    <div class="form-group">
                                        <label for="password"><span class="reqField">*</span> Password</label>
                                        <input type="password" name="password" id="password" class="form-control input_box" placeholder="Password *" required>
                                    </div>

                                    

                                </div>
                                <div class="col-sm-6">

                                    <div class="form-group">
                                        <label for="password-confirm"><span class="reqField">*</span> Confirm Password</label>
                                        <input type="password" name="confirmpassword" id="password-confirm" class="form-control input_box" placeholder="Confirm Password *" required>
                                    </div>
                                </div>
                            </div>

                                <label for="how_your_heard_about_us"><span class="reqField">*</span> How do you know about us?</label>
                                <select name="how_your_heard_about_us" id="how_your_heard_about_us" class="form-control input_box">
                                  <option value="">Select option </option>
                                  <option value="Google Ads">Google Ads</option>
                                  <option value="Facebook">Facebook </option>
                                  <option value="Youtube">Youtube </option>
                                  <option value="Twitter">Twitter</option>
                                  <option value="Search Engine">Search Engine</option>
                                  <option value="Instagram">Instagram</option>
                                  <option value="Email">Email</option>
                                  <option value="Radio">Radio</option>
                                  <option value="TV">TV</option>
                                  <option value="Newspaper">Newspaper</option>
                                  <option value="Word of mouth">Word of mouth</option>
                                  <option value="Others">Others</option>
                              </select>
                        
                              <div class="specify_know_about disp-0">
                                <label for="specify_how_your_heard_about_us">Specify how your heard about us</label>
                                <input type="text" name="specify_how_your_heard_about_us" id="specify_how_your_heard_about_us" class="form-control input_box">
                                
                              </div>
                        
                        
                                <label for=" describe_purpose">Purpose of opening the Account (please describe the purpose)</label>
                              <div class="row">
                                <div class="col-xs-12">
                                    <textarea type="text" name="describe_purpose" id="describe_purpose" class="form-control input_box" placeholder=""></textarea>
                                </div>
                              </div>
                         
                        
                        
                              
                                <label for="size_of_transaction"><span class="reqField">*</span> Size of Trancation to be expected</label>
                                <select name="size_of_transaction" id="size_of_transaction" class="form-control input_box">
                                  <option value="">Select Transaction size</option>
                                  <option value="0 - 10,000">0 - 10,000</option>
                                  <option value="10,001 - 50,000">10,001 - 50,000</option>
                                  <option value="50,000 - 500,000">50,000 - 500,000</option>
                                  <option value="Above 500,001">Above 500,001</option>
                              </select>
                              </div>
                        
                          
                                <label for="source_of_funds"><span class="reqField">*</span> Source of Funds</label>
                                <select name="source_of_funds" id="source_of_funds" class="form-control input_box">
                                  <option value="">Select Source of Funds</option>
                                  <option value="Salary, Pension, Social benefits">Salary, Pension, Social benefits</option>
                                  <option value="Directors Remuneration Share of profits">Directors Remuneration Share of profits</option>
                                  <option value="Dividend, interest on loan etc">Dividend, interest on loan etc</option>
                                  <option value="Families and Friends">Families and Friends</option>
                                  <option value="Others">Other (Please describe)</option>
                              </select>
                              
                        
                        
                              <div class="specifySourceOfFunds disp-0">
                                <label for="specify_source">Specify Source of Funds</label>
                                <input type="text" name="specify_source" id="specify_source" class="form-control input_box ">
                               
                              </div>

                            <label for="referred_by">Referred By <small class="reqField">(Optional)</small> </label>
                                        <input type="text" name="referred_by" id="referred_by" class="form-control input_box" placeholder="E.g 69212">
                            <div class="row">

                                <div class="col-sm-6">

                                    <div class="form-group">
                                        <label for="password-confirm"><a href="{{ route('terms of use') }}" target="_blank" class="text-primary"><span class="reqField">*</span> Accept Terms & Conditions</a></label>
                                        <input type="checkbox" name="checkbox" id="checkBox" required>
                                    </div>


                                </div>
                            </div>


                            {!! htmlFormSnippet() !!}

                            <br>
                            

                            <button type="button" class="btn btn-default submitBtn" onclick="register('Individual')" style="width: 100% !important">Sign Up</button>
                            <img src="https://cdn.dribbble.com/users/608059/screenshots/2032455/spinner.gif" class="spinner disp-0" style="width: auto; height: 50px;">
                        </div>


                        <div class="busForm animated rollIn disp-0">

                            <h4><strong>Business Information</strong></h4>
                            <hr>

                            <label for="busname">Business Name</label>
                            <input type="text" name="businessname" id="busname" class="form-control input_box" placeholder="Business Name *" required>
                            
                            
                            <label for="buscorporationtype">Corporation Type</label>
                            <select name="corporationtype" id="buscorporationtype" class="form-control input_box" required>
                                <option value="">Select Corporation Type</option>
                                <option value="Sole Proprietorship">Sole Proprietorship</option>
                                <option value="Partnership">Partnership</option>
                                <option value="Limited Liability Company">Limited Liability Company</option>
                                <option value="Public Company">Public Company</option>
                                <option value="Trust and Estate">Trust and Estate</option>
                            </select>
                            {{-- <input type="text" name="corporationtype" id="buscorporationtype" class="form-control input_box" placeholder="Corporation Type *" required> --}}


                            
                            <label for="busaddress">Business Address</label>
                            <input type="text" name="address" id="busaddress" class="form-control input_box" placeholder="Address *" required>

                            
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
                            <h4><strong>Contact Person</strong></h4>
                            <hr>
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="busfname">First Name</label>
                                    <input type="text" id="busfname" name="firstname" class="form-control input_box" @if($fname != "") value="{{ $fname }}" readonly @else placeholder="First Name *" required @endif>
                                </div>
                                <div class="col-sm-6">
                                    <label for="buslname">Last Name</label>
                                    <input type="text" id="buslname" name="lastname" class="form-control input_box" @if($lname != "") value="{{ $lname }}" readonly @else placeholder="Last Name *" required @endif>
                                </div>
                            </div>

                            

                            

                            <label for="busemail">Email Address</label>
                            <input type="email" name="email" id="busemail" class="form-control input_box" @if($email != "") value="{{ $email }}" readonly @else placeholder="Your Email *" required @endif>

                            <label for="buscemail">Confirm Email Address</label>
                            <input type="email" name="cemail" id="buscemail" class="form-control input_box" @if($email != "") value="{{ $email }}" readonly @else placeholder="Confirm Your Email *" required @endif>

                            

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
  <div role="tabpanel" class="tab-pane disp-0" id="profile">
      <br>
        <div class="display-3">
          <h4 class="text-center">Click the button to sign up as Merchant.</h4>
      </div>

      <br>

      <button class="btn btn-danger btn-block" onclick="gotoMerchant()">Sign Up for FREE as a Merchant</button>

  </div>
</div>








                </div>
            </div>
        </div>
    </section>
    <!-- End All contact Info -->

@include('include.bottom')


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
    <script src="{{ asset('js/auto-complete.js') }}"></script>


<script language="javascript">
    populateCountries("country", "state");
    populateCountries("buscountry", "busstate");

</script>

<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_API_KEY') }}&libraries=places&callback=initAutocomplete" async defer></script>

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


    $('#source_of_funds').change(function(){

if($('#source_of_funds').val() == "Others"){
    // Show a specify input field
    $('.specifySourceOfFunds').removeClass('disp-0');
}
else{
  // Remove the specified input field
  $('.specifySourceOfFunds').addClass('disp-0');
}

});


$('#how_your_heard_about_us').change(function(){

if($('#how_your_heard_about_us').val() == "Others"){
    // Show a specify input field
    $('.specify_know_about').removeClass('disp-0');
}
else{
  // Remove the specified input field
  $('.specify_know_about').addClass('disp-0');
}

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
var corporationtype;
var ref_code;
var dayOfBirth;
var monthOfBirth;
var yearOfBirth;
var street_number;
var street_name;
var referred_by;
var how_your_heard_about_us;
var specify_how_your_heard_about_us;
var describe_purpose;
var size_of_transaction;
var source_of_funds;
var specify_source;


    if(accountType == "Individual"){
        ref_code = $('#ref_code').val();
        fname = $('#fname').val();
        lname = $('#lname').val();
        dayOfBirth = $('#dayOfBirth').val();
        monthOfBirth = $('#monthOfBirth').val();
        yearOfBirth = $('#yearOfBirth').val();
        email = $('#email').val();
        cemail = $('#cemail').val();
        country = $('#country').val();
        state = $('#state').val();
        city = $('#locality').val();
        address = $('#autocomplete').val();
        street_number = $('#street_number').val();
        street_name = $('#route').val();
        password = $('#password').val();
        zipcode = $('#postal_code').val();
        referred_by = $('#referred_by').val();
        cpassword = $('#password-confirm').val();
        how_your_heard_about_us = $('#how_your_heard_about_us').val();
        specify_how_your_heard_about_us = $('#specify_how_your_heard_about_us').val();
        describe_purpose = $('#describe_purpose').val();
        size_of_transaction = $('#size_of_transaction').val();
        source_of_funds = $('#source_of_funds').val();
        specify_source = $('#specify_source').val();


        if (grecaptcha.getResponse() == ""){
            swal('Oops', 'Check the captcha box', 'info');
            return false;
        }
        if(fname == ""){
            swal('Oops', 'Firstname field can\'t be empty', 'info');
            return false;
        }if(lname == ""){
            swal('Oops', 'Lastname field can\'t be empty', 'info');
            return false;
        }
        if(dayOfBirth == ""){
            swal('Oops', 'Please select day of birth', 'info');
            return false;
        }
        if(monthOfBirth == ""){
            swal('Oops', 'Please select month of birth', 'info');
            return false;
        }
        if(yearOfBirth == ""){
            swal('Oops', 'Please select year of birth', 'info');
            return false;
        }
        if(email == ""){
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

        if($('#checkBox').prop('checked') == false){
            swal('Oops!', 'You have to accept terms and conditions', 'warning');
            return false;
        }
        if(how_your_heard_about_us == ""){
            swal('Oops', 'Please tell us how you know about us.', 'info');
            return false;
        }
        if(size_of_transaction == ""){
            swal('Oops', 'Please select size of transaction', 'info');
            return false;
        }
        if(source_of_funds == ""){
            swal('Oops', 'Please select the source of funds.', 'info');
            return false;
        }


        thisdata = {
            fname: fname, lname: lname, email: email,
            country: country, state: state, city: city,
            address: address, password: password, zipcode: zipcode,
            street_number: street_number, street_name: street_name,
            accountType: accountType, ref_code: ref_code, dayOfBirth: dayOfBirth, monthOfBirth: monthOfBirth, yearOfBirth: yearOfBirth, referred_by: referred_by, how_your_heard_about_us: how_your_heard_about_us,
specify_how_your_heard_about_us: specify_how_your_heard_about_us, describe_purpose: describe_purpose, size_of_transaction: size_of_transaction, source_of_funds: source_of_funds, specify_source: specify_source
        };


    }
    else if(accountType == "Business"){
        ref_code = $('#ref_code').val();
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
           accountType: accountType, ref_code: ref_code
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
              spinner.addClass('disp-0');
                submitBtn.removeClass('disp-0');
            if(result.message == 'success'){
                
            swal('Welcome', result.res, result.message);
            setTimeout(function(){ location.href = result.link; }, 5000);
            }else{
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
