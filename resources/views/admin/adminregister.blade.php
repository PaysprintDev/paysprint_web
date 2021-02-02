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

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  <style>
    .disp-0{
        display: none !important;
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

    <form action="#" method="post">
      <div class="form-group has-feedback">
        <input type="hidden" name="user_id" id="user_id" class="form-control" value="{{ 'PaySprint_'.mt_rand(1000, 9999) }}">
        <input type="text" name="business_name" id="business_name" class="form-control" placeholder="Business Name*">
        <span class="glyphicon glyphicon-briefcase form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="text" name="address" id="address" class="form-control" placeholder="Address*">
        <span class="glyphicon glyphicon-screenshot form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="text" name="corporate_type" id="corporate_type" class="form-control" placeholder="Corporate Type*">
        <span class="glyphicon glyphicon-comment form-control-feedback"></span>
      </div>

      <div class="form-group has-feedback">
      <div class="row">
        <div class="col-xs-6">
            <input type="text" name="firstname" id="firstname" class="form-control" placeholder="Firstname*">
        </div>
        <!-- /.col -->
        <div class="col-xs-6">
            <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Lastname*">
        </div>
        <!-- /.col -->
      </div>
      </div>

      <div class="form-group has-feedback">
        <input type="text" name="username" id="username" class="form-control" placeholder="Username*">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>

      <div class="form-group has-feedback">
        <input type="email" name="email" id="email" class="form-control" placeholder="Email Address*">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>

      <div class="form-group has-feedback">
        <input type="email" name="cemail" id="cemail" class="form-control" placeholder="Confirm Email*">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>

      <div class="form-group has-feedback">
        <input type="text" name="country" id="country" class="form-control" placeholder="Country*">
        <span class="glyphicon glyphicon-globe form-control-feedback"></span>
      </div>

      <div class="form-group has-feedback">
        <div class="row">

            <div class="col-xs-6">
                <input type="text" name="state" id="state" class="form-control" placeholder="Province/State*">
            </div>
            <!-- /.col -->

            <div class="col-xs-6">
                <input type="text" name="city" id="city" class="form-control" placeholder="City*">
            </div>
            <!-- /.col -->
        </div>
      </div>

      <div class="form-group has-feedback">
        <div class="row">
            <div class="col-xs-6">
                <input type="password" name="password" id="password" class="form-control" placeholder="Password*">
            </div>
            <!-- /.col -->
            <div class="col-xs-6">
                <input type="password" name="cpassword" id="cpassword" class="form-control" placeholder="Confirm Password*">
            </div>
            <!-- /.col -->
        </div>
      </div>

      <div class="form-group has-feedback">
        <input type="text" name="zip_code" id="zip_code" class="form-control" placeholder="Zip Code">
        <span class="glyphicon glyphicon-link form-control-feedback"></span>
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
        <div class="col-xs-4">
          <button type="button" class="btn btn-success btn-block btn-flat" onclick="signUp()">Register</button>
          
        </div>
        <!-- /.col -->
      </div>
    </form>

    <small>Already have an account? <a href="{{ route('AdminLogin') }}">Login</a></small><br>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
<!-- jQuery 3 -->
<script src="{{ asset('ext/bower_components/jquery/dist/jquery.min.js') }}"></script>
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

<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });

  });



// Register function
function signUp(){
  var route = "{{ URL('Ajax/Adminregister') }}";
  if($('#business_name').val() == ""){
    swal('Oops!', 'Business name field can\'t be empty', 'warning');
    return false;
  }
  else if($('#address').val() == ""){
    swal('Oops!', 'Address field can\'t be empty', 'warning');
    return false;
  }
  else if($('#corporate_type').val() == ""){
    swal('Oops!', 'Corporate type field can\'t be empty', 'warning');
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
  else if($('#city').val() == ""){
    swal('Oops!', 'City field can\'t be empty', 'warning');
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

  var thisdata = {
    user_id: $('#user_id').val(),
    business_name: $('#business_name').val(),
    address: $('#address').val(),
    corporate_type: $('#corporate_type').val(),
    firstname: $('#firstname').val(),
    lastname: $('#lastname').val(),
    username: $('#username').val(),
    email: $('#email').val(),
    country: $('#country').val(),
    state: $('#state').val(),
    city: $('#city').val(),
    password: $('#password').val(),
    zip_code: $('#zip_code').val(),
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
                    setTimeout(function(){ location.href = result.link; }, 2000);
                }
                else{
                    $(".spinner").addClass('disp-0');
                    swal("Oops!", result.res, result.message);
                }   

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
