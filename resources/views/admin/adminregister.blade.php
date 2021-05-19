<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>PaySprint | Register</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">


  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('ext/plugins/iCheck/square/blue.css') }}">

      <!-- Favicon -->
<link rel="icon" href="https://res.cloudinary.com/pilstech/image/upload/v1618251695/paysprint_icon_new_kg2h3j.png" type="image/x-icon" />

 <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ asset('ext/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('ext/bower_components/font-awesome/css/font-awesome.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset('ext/bower_components/Ionicons/css/ionicons.min.css') }}">

  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="{{ asset('ext/plugins/iCheck/all.css') }}">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="{{ asset('ext/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
  <!-- Bootstrap time Picker -->
  <link rel="stylesheet" href="{{ asset('ext/plugins/timepicker/bootstrap-timepicker.min.css') }}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('ext/bower_components/select2/dist/css/select2.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('ext/dist/css/AdminLTE.min.css') }}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{ asset('ext/dist/css/skins/_all-skins.min.css') }}">
  <!-- Morris chart -->
  <link rel="stylesheet" href="{{ asset('ext/bower_components/morris.js/morris.css') }}">
  <!-- jvectormap -->
  <link rel="stylesheet" href="{{ asset('ext/bower_components/jvectormap/jquery-jvectormap.css') }}">
  <!-- Date Picker -->
  <link rel="stylesheet" href="{{ asset('ext/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('ext/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="{{ asset('ext/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
    <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('ext/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">

  <link rel="stylesheet" type="text/css" href="{{ asset('pace/themes/orange/pace-theme-flash.css') }}" />



  <script src="https://www.google.com/recaptcha/api.js" async defer></script>

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">

  <style>
    .disp-0{
        display: none !important;
    }
    .reqField{
      color: red;
      font-weight: bold;
    }
  </style>

</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="{{ route('AdminLogin') }}"><b>Pay</b>Sprint</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Register Account</p>

    <a href="{{ route('merchant home') }}" type="button" class="btn btn-primary btn-block">Goto Homepage</a> <br>

    <?php use \App\Http\Controllers\AnonUsers; ?>

    <form action="#" method="post">

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


        

      <div class="form-group has-feedback">
        <label for="business_name"><span class="reqField">*</span> Business Name</label>
        <input type="hidden" name="ref_code" id="ref_code" @if($ref_code != "") value="{{ $ref_code }}" readonly @else placeholder="Ref code" @endif>
        <input type="hidden" name="user_id" id="user_id" class="form-control" value="{{ 'PaySprint_'.mt_rand(1000, 9999) }}">
        <input type="text" name="business_name" id="business_name" class="form-control" placeholder="Business Name*">
        <span class="glyphicon glyphicon-briefcase form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <label for="business_telephone"><span class="reqField">*</span> Business Telephone</label>
        <input type="text" name="business_telephone" id="business_telephone" class="form-control" placeholder="Business Telephone*">
        <span class="glyphicon glyphicon-phone form-control-feedback"></span>
      </div>

      <div class="form-group has-feedback disp-0">
        <label for="business_address">Business Street Number & Name</label>
        <input type="text" name="business_address" id="business_address" class="form-control" placeholder="Business Street Number & Name*" value="">
        <span class="glyphicon glyphicon-screenshot form-control-feedback"></span>
      </div>

        <div class="form-group has-feedback disp-0">
        <div class="row">

          <div class="col-xs-6">
              <label for="business_city">City</label>
                <input type="text" name="business_city" id="business_city" class="form-control" placeholder="City*" value="">
            </div>
            <!-- /.col -->

            <div class="col-xs-6 disp-0">
              <label for="business_zip_code">Postal/Zip Code</label>
                <input type="text" name="business_zip_code" id="business_zip_code" class="form-control" placeholder="Postal/Zip Code" value="">
            </div>
            <!-- /.col -->

            
        </div>
      </div>


      <div class="form-group has-feedback disp-0">
        <label for="business_country">Country</label>
        <input type="text" name="business_country" id="business_country" value="">
      </div>


      <div class="form-group has-feedback disp-0">
        <label for="business_state">Province/State</label>
        <input name="business_state" id="business_state" class="form-control" value="">
      </div>

      <div class="form-group has-feedback disp-0">
        <label for="corporate_type">Corporation Type</label>
          <select name="corporate_type" id="corporate_type" class="form-control">
              <option value="">Select Corporation Type</option>
              <option value="Sole Proprietorship">Sole Proprietorship</option>
              <option value="Partnership">Partnership</option>
              <option value="Limited Liability Company">Limited Liability Company</option>
              <option value="Public Company">Public Company</option>
              <option value="Trust and Estate">Trust and Estate</option>
          </select>
      </div>


      <div class="form-group has-feedback disp-0">
        <label for="type_of_service"><span class="reqField">*</span> Service Offer</label>
          <select name="type_of_service" id="type_of_service" class="form-control">
              <option value="">Select Service Offer</option>
              <option value="Add Service Type">Add Service offer</option>
              @if (count($data) > 0)
                  @foreach ($data as $item)
                    <option value="{{ $item->name }}">{{ $item->name }}</option>
                  @endforeach
              @endif

          </select>
      </div>

      <div class="form-group has-feedback otherservice disp-0">
        <label for="type_of_service"><span class="reqField">*</span> Add Service offer</label>
          <input type="text" name="other_type_of_service" id="other_type_of_service" class="form-control" placeholder="Service Type*">
        <span class="glyphicon glyphicon-screenshot form-control-feedback"></span>
      </div>

      
      <div class="form-group has-feedback">
        <label for="industry"><span class="reqField">*</span> Industry</label>
        <select name="industry" id="industry" class="form-control">
          <option value="">Select Industry</option>
          <option value="Accounting">Accounting</option>
<option value="Airlines/Aviation">Airlines/Aviation</option>
<option value="Alternative Dispute Resolution">Alternative Dispute Resolution</option>
<option value="Alternative Medicine">Alternative Medicine</option>
<option value="Animation">Animation</option>
<option value="Apparel/Fashion">Apparel/Fashion</option>
<option value="Architecture/Planning">Architecture/Planning</option>
<option value="Arts/Crafts">Arts/Crafts</option>
<option value="Automotive">Automotive</option>
<option value="Aviation/Aerospace">Aviation/Aerospace</option>
<option value="Banking/Mortgage">Banking/Mortgage</option>
<option value="Biotechnology/Greentech">Biotechnology/Greentech</option>
<option value="Broadcast Media">Broadcast Media</option>
<option value="Building Materials">Building Materials</option>
<option value="Business Supplies/Equipment">Business Supplies/Equipment</option>
<option value="Capital Markets/Hedge Fund/Private Equity">Capital Markets/Hedge Fund/Private Equity</option>
<option value="Chemicals">Chemicals</option>
<option value="Civic/Social Organization">Civic/Social Organization</option>
<option value="Civil Engineering">Civil Engineering</option>
<option value="Commercial Real Estate">Commercial Real Estate</option>
<option value="Computer Games">Computer Games</option>
<option value="Computer Hardware">Computer Hardware</option>
<option value="Computer Networking">Computer Networking</option>
<option value="Computer Software/Engineering">Computer Software/Engineering</option>
<option value="Computer/Network Security">Computer/Network Security</option>
<option value="Construction">Construction</option>
<option value="Consumer Electronics">Consumer Electronics</option>
<option value="Consumer Goods">Consumer Goods</option>
<option value="Consumer Services">Consumer Services</option>
<option value="Cosmetics">Cosmetics</option>
<option value="Dairy">Dairy</option>
<option value="Defense/Space">Defense/Space</option>
<option value="Design">Design</option>
<option value="E-Learning">E-Learning</option>
<option value="Education Management">Education Management</option>
<option value="Electrical/Electronic Manufacturing">Electrical/Electronic Manufacturing</option>
<option value="Entertainment/Movie Production">Entertainment/Movie Production</option>
<option value="Environmental Services">Environmental Services</option>
<option value="Events Services">Events Services</option>
<option value="Executive Office">Executive Office</option>
<option value="Facilities Services">Facilities Services</option>
<option value="Farming">Farming</option>
<option value="Financial Services">Financial Services</option>
<option value="Fine Art">Fine Art</option>
<option value="Fishery">Fishery</option>
<option value="Food Production">Food Production</option>
<option value="Food/Beverages">Food/Beverages</option>
<option value="Fundraising">Fundraising</option>
<option value="Furniture">Furniture</option>
<option value="Gambling/Casinos">Gambling/Casinos</option>
<option value="Glass/Ceramics/Concrete">Glass/Ceramics/Concrete</option>
<option value="Government Administration">Government Administration</option>
<option value="Government Relations">Government Relations</option>
<option value="Graphic Design/Web Design">Graphic Design/Web Design</option>
<option value="Health/Fitness">Health/Fitness</option>
<option value="Higher Education/Acadamia">Higher Education/Acadamia</option>
<option value="Hospital/Health Care">Hospital/Health Care</option>
<option value="Hospitality">Hospitality</option>
<option value="Human Resources/HR">Human Resources/HR</option>
<option value="Import/Export">Import/Export</option>
<option value="Individual/Family Services">Individual/Family Services</option>
<option value="Industrial Automation">Industrial Automation</option>
<option value="Information Services">Information Services</option>
<option value="Information Technology/IT">Information Technology/IT</option>
<option value="Insurance">Insurance</option>
<option value="International Affairs">International Affairs</option>
<option value="International Trade/Development">International Trade/Development</option>
<option value="Internet">Internet</option>
<option value="Investment Banking/Venture">Investment Banking/Venture</option>
<option value="Investment Management/Hedge Fund/Private Equity">Investment Management/Hedge Fund/Private Equity</option>
<option value="Judiciary">Judiciary</option>
<option value="Law Enforcement">Law Enforcement</option>
<option value="Law Practice/Law Firms">Law Practice/Law Firms</option>
<option value="Legal Services">Legal Services</option>
<option value="Legislative Office">Legislative Office</option>
<option value="Leisure/Travel">Leisure/Travel</option>
<option value="Library">Library</option>
<option value="Logistics/Procurement">Logistics/Procurement</option>
<option value="Luxury Goods/Jewelry">Luxury Goods/Jewelry</option>
<option value="Machinery">Machinery</option>
<option value="Management Consulting">Management Consulting</option>
<option value="Maritime">Maritime</option>
<option value="Market Research">Market Research</option>
<option value="Marketing/Advertising/Sales">Marketing/Advertising/Sales</option>
<option value="Mechanical or Industrial Engineering">Mechanical or Industrial Engineering</option>
<option value="Media Production">Media Production</option>
<option value="Medical Equipment">Medical Equipment</option>
<option value="Medical Practice">Medical Practice</option>
<option value="Mental Health Care">Mental Health Care</option>
<option value="Military Industry">Military Industry</option>
<option value="Mining/Metals">Mining/Metals</option>
<option value="Motion Pictures/Film">Motion Pictures/Film</option>
<option value="Museums/Institutions">Museums/Institutions</option>
<option value="Music">Music</option>
<option value="Nanotechnology">Nanotechnology</option>
<option value="Newspapers/Journalism">Newspapers/Journalism</option>
<option value="Non-Profit/Volunteering">Non-Profit/Volunteering</option>
<option value="Oil/Energy/Solar/Greentech">Oil/Energy/Solar/Greentech</option>
<option value="Online Publishing">Online Publishing</option>
<option value="Other Industry">Other Industry</option>
<option value="Outsourcing/Offshoring">Outsourcing/Offshoring</option>
<option value="Package/Freight Delivery">Package/Freight Delivery</option>
<option value="Packaging/Containers">Packaging/Containers</option>
<option value="Paper/Forest Products">Paper/Forest Products</option>
<option value="Performing Arts">Performing Arts</option>
<option value="Pharmaceuticals">Pharmaceuticals</option>
<option value="Philanthropy">Philanthropy</option>
<option value="Photography">Photography</option>
<option value="Plastics">Plastics</option>
<option value="Political Organization">Political Organization</option>
<option value="Primary/Secondary Education">Primary/Secondary Education</option>
<option value="Printing">Printing</option>
<option value="Professional Training">Professional Training</option>
<option value="Program Development">Program Development</option>
<option value="Public Relations/PR">Public Relations/PR</option>
<option value="Public Safety">Public Safety</option>
<option value="Publishing Industry">Publishing Industry</option>
<option value="Railroad Manufacture">Railroad Manufacture</option>
<option value="Ranching">Ranching</option>
<option value="Real Estate/Mortgage">Real Estate/Mortgage</option>
<option value="Recreational Facilities/Services">Recreational Facilities/Services</option>
<option value="Religious Institutions">Religious Institutions</option>
<option value="Renewables/Environment">Renewables/Environment</option>
<option value="Research Industry">Research Industry</option>
<option value="Restaurants">Restaurants</option>
<option value="Retail Industry">Retail Industry</option>
<option value="Security/Investigations">Security/Investigations</option>
<option value="Semiconductors">Semiconductors</option>
<option value="Shipbuilding">Shipbuilding</option>
<option value="Sporting Goods">Sporting Goods</option>
<option value="Sports">Sports</option>
<option value="Staffing/Recruiting">Staffing/Recruiting</option>
<option value="Supermarkets">Supermarkets</option>
<option value="Telecommunications">Telecommunications</option>
<option value="Textiles">Textiles</option>
<option value="Think Tanks">Think Tanks</option>
<option value="Tobacco">Tobacco</option>
<option value="Translation/Localization">Translation/Localization</option>
<option value="Transportation">Transportation</option>
<option value="Utilities">Utilities</option>
<option value="Venture Capital/VC">Venture Capital/VC</option>
<option value="Veterinary">Veterinary</option>
<option value="Warehousing">Warehousing</option>
<option value="Wholesale">Wholesale</option>
<option value="Wine/Spirits">Wine/Spirits</option>
<option value="Wireless">Wireless</option>
<option value="Writing/Editing">Writing/Editing</option>
        </select>
      </div>

      <div class="form-group has-feedback">
        <label for="website">Website</label>
      <div class="row">
        <div class="col-xs-12">
            <input type="text" name="website" id="website" class="form-control" placeholder="www.example.com">
        </div>
        <!-- /.col -->
        
      </div>
      </div>


      <div class="form-group has-feedback">
        <label for="firstname"><span class="reqField">*</span> Contact Person</label>
      <div class="row">
        <div class="col-xs-6">
            <input type="text" name="firstname" id="firstname" class="form-control" @if($fname != "") value="{{ $fname }}" readonly @else placeholder="First Name *" required @endif>
        </div>
        <!-- /.col -->
        <div class="col-xs-6">
            <input type="text" name="lastname" id="lastname" class="form-control"  @if($lname != "") value="{{ $lname }}" readonly @else placeholder="Last Name *" required @endif>
        </div>
        <!-- /.col -->
      </div>
      </div>

      

      <div class="form-group has-feedback">
        <label for="country"><span class="reqField">*</span> Telephone</label>
        <input type="text" name="telephone" id="telephone" class="form-control" placeholder="Telephone*">
      </div>



        <label for="autocomplete">Auto complete address</label>
        <input id="autocomplete" placeholder="Enter your address" onFocus="geolocate()" type="text" class="form-control input_box">

        <br>

                <div class="row">
                <div class="col-md-6">
                    <label class="control-label"><span class="reqField">*</span> Street number</label>
                    <input class="form-control input_box" name="street_number" id="street_number" disabled="true" readonly>
                </div>
                <div class="col-md-6">
                    <label class="control-label"><span class="reqField">*</span> Street Name/ Route</label>
                    <input class="form-control input_box" name="route" id="route" disabled="true" readonly>
                </div>
                </div>

        <br>

                <div class="row">
                <div class="col-md-6">
                    <label class="control-label"><span class="reqField">*</span> City</label>
                    <input class="form-control input_box field" name="locality" id="locality" disabled="true">
                </div>
                <div class="col-md-6">
                    <label class="control-label"><span class="reqField">*</span> Postal/Zip code</label>
                    <input class="form-control input_box" name="postal_code" id="postal_code" disabled="true">
                </div>

                
                </div>

        

{{-- 
            <div class="form-group has-feedback">
        <label for="address"><span class="reqField">*</span> Street Number & Name</label>
        <input type="text" name="address" id="address" class="form-control" placeholder="Street Number & Name*">
        <span class="glyphicon glyphicon-screenshot form-control-feedback"></span>
      </div> --}}

        {{-- <div class="form-group has-feedback">
        <div class="row">

          <div class="col-xs-6">
              <label for="city"><span class="reqField">*</span> City</label>
                <input type="text" name="city" id="city" class="form-control" placeholder="City*">
            </div>
            <!-- /.col -->

            <div class="col-xs-6">
              <label for="zip_code"><span class="reqField">*</span> Postal/Zip Code</label>
                <input type="text" name="zip_code" id="zip_code" class="form-control" placeholder="Postal/Zip Code">
            </div>
            <!-- /.col -->

            
        </div>
      </div> --}}

      <br>


      <div class="form-group has-feedback">
        <label for="country"><span class="reqField">*</span> Country</label>
        <select name="country" id="country" class="form-control" required></select>
      </div>


      <div class="form-group has-feedback">
        <label for="state"><span class="reqField">*</span> Province/State</label>
        <select name="state" id="state" class="form-control"></select>
      </div>


          <div class="row">
        <div class="col-sm-4">
            <div class="form-group has-feedback">
                <label for="dayOfBirth"><span class="reqField">*</span> Day of Birth</label>
                
                <select name="dayOfBirth" id="dayOfBirth" class="form-control">
                    @for ($i = 1; $i <= 31; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group has-feedback">
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
            <div class="form-group has-feedback">
                <label for="yearOfBirth"><span class="reqField">*</span> Year of Birth</label>
                <select name="yearOfBirth" id="yearOfBirth" class="form-control">
                    @for ($i = 1900; $i <= date('Y'); $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>
        </div>
    </div>




      <div class="form-group has-feedback">
        <label for="username"><span class="reqField">*</span> Username</label>
        <input type="text" name="username" id="username" class="form-control" placeholder="Username*">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>

      <div class="form-group has-feedback">
        <label for="email"><span class="reqField">*</span> Email</label>
        <input type="email" name="email" id="email" class="form-control" @if($email != "") value="{{ $email }}" readonly @else placeholder="Email Address *" required @endif>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>

      <div class="form-group has-feedback">
        <label for="cemail"><span class="reqField">*</span> Confirm Email</label>
        <input type="email" name="cemail" id="cemail" class="form-control" @if($email != "") value="{{ $email }}" readonly @else placeholder="Confirm Email *" required @endif>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>

      <div class="form-group has-feedback">
        <div class="row">
            <div class="col-xs-6">
              <label for="password"><span class="reqField">*</span> Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Password*">
            </div>
            <!-- /.col -->
            <div class="col-xs-6">
              <label for="cpassword"><span class="reqField">*</span> Confirm Password</label>
                <input type="password" name="cpassword" id="cpassword" class="form-control" placeholder="Confirm Password*">
            </div>
            <!-- /.col -->
        </div>
      </div>



      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox" name="checkbox" id="checkBox"> 
            </label>
            <a href="{{ route('terms of use') }}" target="_blank"lass="text-primary"><strong>Accept Terms and Conditions</strong></a>
          </div>
        </div>

      </div>

      <div class="form-group has-feedback">
        {!! htmlFormSnippet() !!}
      </div>


      

      <div class="row">
        <div class="col-xs-8">
          <img src="https://cdn.dribbble.com/users/608059/screenshots/2032455/spinner.gif" class="spinner disp-0" style="width: auto; height: 40px;">
          <div class="checkbox icheck disp-0">
            <label>
              <input type="checkbox"> Accept Terms & Conditions
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-md-12">
          <button type="button" class="btn btn-success btn-block btn-flat" onclick="signUp()">Register</button>
          
        </div>
        <!-- /.col -->
      </div>
    </form>

    <strong><small>Already have an account? <a href="{{ route('AdminLogin') }}">Login</a></small></strong><br>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
<!-- jQuery 3 -->
<script src="{{ asset('ext/bower_components/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('js/country-state-select.js') }}"></script>
<script src="https://raw.githubusercontent.com/HubSpot/pace/v1.0.0/pace.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!-- DataTables -->
<script src="{{ asset('ext/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('ext/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>

<!-- CK Editor -->
<script src="{{ asset('ext/bower_components/ckeditor/ckeditor.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('ext/bower_components/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('ext/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>

<!-- Select2 -->
<script src="{{ asset('ext/bower_components/select2/dist/js/select2.full.min.js') }}"></script>
<!-- InputMask -->
<script src="{{ asset('ext/plugins/input-mask/jquery.inputmask.js') }}"></script>
<script src="{{ asset('ext/plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
<script src="{{ asset('ext/plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>

<!-- bootstrap color picker -->
<script src="{{ asset('ext/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
<!-- bootstrap time picker -->
<script src="{{ asset('ext/plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>

<!-- iCheck 1.0.1 -->
<script src="{{ asset('ext/plugins/iCheck/icheck.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('ext/bower_components/fastclick/lib/fastclick.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('ext/dist/js/adminlte.min.js') }}"></script>

<!-- Morris.js charts -->
<script src="{{ asset('ext/bower_components/raphael/raphael.min.js') }}"></script>
<script src="{{ asset('ext/bower_components/morris.js/morris.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('ext/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js') }}"></script>
<!-- jvectormap -->
<script src="{{ asset('ext/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script src="{{ asset('ext/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('ext/bower_components/jquery-knob/dist/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('ext/bower_components/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('ext/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<!-- datepicker -->
<script src="{{ asset('ext/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{ asset('ext/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
<!-- Slimscroll -->
<script src="{{ asset('ext/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('ext/bower_components/fastclick/lib/fastclick.js') }}"></script>

<script src="{{ asset('pace/pace.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('ext/dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('ext/dist/js/pages/dashboard.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('ext/dist/js/demo.js') }}"></script>

  <script src="{{ asset('js/auto-complete.js') }}"></script>

  <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_API_KEY') }}&libraries=places&callback=initAutocomplete" async defer></script>


<script language="javascript">
    populateCountries("country", "state");
</script>

<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });

  });



$("#type_of_service").change(function(){
  if($("#type_of_service").val() == "Add Service Type"){
    $(".otherservice").removeClass('disp-0');
  }
  else{
    $(".otherservice").addClass('disp-0');
  }
});

// Register function
function signUp(){
  var route = "{{ URL('Ajax/Adminregister') }}";
  if (grecaptcha.getResponse() == ""){
      swal('Oops', 'Check the captcha box', 'info');
      return false;
  }
  else if($('#business_name').val() == ""){
    swal('Oops!', 'Business name field can\'t be empty', 'warning');
    return false;
  }
  else if($('#business_telephone').val() == ""){
    swal('Oops!', 'Business telephone field can\'t be empty', 'warning');
    return false;
  }

  else if($('#industry').val() == ""){
    swal('Oops!', 'Select industry', 'warning');
    return false;
  }
  
  else if($('#firstname').val() == ""){
    swal('Oops!', 'Firstname field can\'t be empty', 'warning');
    return false;
  }
  else if($('#lastname').val() == ""){
    swal('Oops!', 'Lastname field can\'t be empty', 'warning');
    return false;
  }
  else if($('#dayOfBirth').val() == ""){
    swal('Oops!', 'Please select day of birth', 'warning');
    return false;
  }
  else if($('#monthOfBirth').val() == ""){
    swal('Oops!', 'Please select month of birth', 'warning');
    return false;
  }
  else if($('#yearOfBirth').val() == ""){
    swal('Oops!', 'Please select year of birth', 'warning');
    return false;
  }
  else if($('#telephone').val() == ""){
    swal('Oops!', 'Your telephone number is needed', 'warning');
    return false;
  }
  else if($('#username').val() == ""){
    swal('Oops!', 'Your username is needed for next login', 'warning');
    return false;
  }
  else if($('#email').val() == ""){
    swal('Oops!', 'Email field can\'t be empty', 'warning');
    return false;
  }
  else if($('#cemail').val() == ""){
    swal('Oops!', 'Please confirm email', 'warning');
    return false;
  }
  else if($('#country').val() == ""){
    swal('Oops!', 'Country field can\'t be empty', 'warning');
    return false;
  }
  else if($('#state').val() == ""){
    swal('Oops!', 'State field can\'t be empty', 'warning');
    return false;
  }
  else if($('#locality').val() == ""){
    swal('Oops!', 'City field can\'t be empty', 'warning');
    return false;
  }
  else if($('#postal_code').val() == ""){
    swal('Oops!', 'Postal/Zip Code field can\'t be empty', 'warning');
    return false;
  }
  else if($('#password').val() == ""){
    swal('Oops!', 'Password field can\'t be empty', 'warning');
    return false;
  }
  else if($('#cpassword').val() == ""){
    swal('Oops!', 'You have to confirm your password', 'warning');
    return false;
  }

  else if($('#email').val() != $('#cemail').val()){
    swal('Oops!', 'Your email doesn\'t match', 'info');
    return false;
  }
  else if($('#password').val() != $('#cpassword').val()){
    swal('Oops!', 'Your password doesn\'t match', 'info');
    return false;
  }


  else if($('#checkBox').prop('checked') == false){
    swal('Oops!', 'You have to accept terms and conditions', 'warning');
    return false;
  }

  var thisdata = {
    user_id: $('#user_id').val(),
    ref_code: $('#ref_code').val(),
    business_name: $('#business_name').val(),
    business_telephone: $('#business_telephone').val(),
    business_address: $('#business_address').val(),
    address: $('#autocomplete').val(),
    street_number: $('#street_number').val(),
    street_name: $('#route').val(),
    corporate_type: $('#corporate_type').val(),
    type_of_service: $('#type_of_service').val(),
    other_type_of_service: $('#other_type_of_service').val(),
    industry: $('#industry').val(),
    website: $('#website').val(),
    firstname: $('#firstname').val(),
    lastname: $('#lastname').val(),
    dayOfBirth: $('#dayOfBirth').val(),
    monthOfBirth: $('#monthOfBirth').val(),
    yearOfBirth: $('#yearOfBirth').val(),
    telephone: $('#telephone').val(),
    username: $('#username').val(),
    email: $('#email').val(),
    country: $('#country').val(),
    state: $('#state').val(),
    city: $('#locality').val(),
    business_country: $('#business_country').val(),
    business_state: $('#business_state').val(),
    business_city: $('#business_city').val(),
    password: $('#password').val(),
    business_zip_code: $('#business_zip_code').val(),
    zip_code: $('#postal_code').val(),
  };

        Pace.restart();
      Pace.track(function(){
          setHeaders();
            jQuery.ajax({
            url: route,
            method: 'post',
            data: thisdata,
            dataType: 'JSON',
            beforeSend: function(){
              $(".spinner").removeClass('disp-0');
            },
            success: function(result){
                if(result.message == 'success'){
                    swal("Saved!", result.res, result.message);
                    setTimeout(function(){ location.href = result.link; }, 3000);
                }
                else{
                    $(".spinner").addClass('disp-0');
                    swal("Oops!", result.res, result.message);
                }   

            },
            error: function(err){
              swal("Oops!", err.responseJSON.message, "error");
            }

          });
      });
}

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
