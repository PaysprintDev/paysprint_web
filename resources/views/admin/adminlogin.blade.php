<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>PaySprint | Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('ext/plugins/iCheck/square/blue.css') }}">

    <!-- Favicon -->
    <link rel="icon"
        href="https://res.cloudinary.com/paysprint/image/upload/v1651130089/assets/paysprint_jpeg_black_bk_2_w4hzub_ioffkg.jpg"
        type="image/x-icon" />

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('ext/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('ext/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('ext/bower_components/Ionicons/css/ionicons.min.css') }}">

    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{ asset('ext/plugins/iCheck/all.css') }}">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet"
        href="{{ asset('ext/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
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
    <link rel="stylesheet"
        href="{{ asset('ext/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('ext/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{ asset('ext/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet"
        href="{{ asset('ext/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('pace/themes/orange/pace-theme-flash.css') }}" />

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">

    <style>
        .disp-0 {
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
            <p class="login-box-msg">Sign in</p>

            <a href="{{ route('merchant home') }}" type="button" class="btn btn-primary btn-block">Goto Homepage</a>
            <br>

            @if (session('success'))
                <div class="alert alert-success">
                    <span style="font-size: 14px; text-align: center">{{ session('success') }}</span>
                </div>
            @elseif(session('error'))
                <div class="alert alert-danger">
                    <span style="font-size: 14px; text-align: center">{{ session('error') }}</span>
                </div>
            @endif

            <form action="#" method="post">
                <div class="form-group has-feedback">
                    <label for="username">Username</label>
                    <input type="username" id="username" class="form-control" placeholder="Username">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <label for="password">Password</label>
                    <input type="password" id="password" class="form-control" placeholder="Password">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    {!! htmlFormSnippet() !!}
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <div class="checkbox icheck">
                            <label>
                                <input type="checkbox"> Remember Me
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-2">
                        <img src="https://cdn.dribbble.com/users/608059/screenshots/2032455/spinner.gif"
                            class="spinner disp-0" style="width: auto; height: 40px;">
                    </div>
                    <div class="col-xs-4">
                        <button type="button" class="btn btn-success btn-block btn-flat" onclick="signIn()">Sign In
                        </button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

            <strong><a href="{{ route('adminpasswordreset') }}">I forgot my password</a></strong><br><br>
            <a href="{{ route('AdminRegister') }}" class="text-center btn btn-danger btn-block" type="button">I don't
                have an account. Register</a>

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
    <script src="{{ asset('ext/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}">
    </script>
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
        $(function() {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' /* optional */
            });



            var url_string = window.location.href;
            var url = new URL(url_string);
            var c = url.searchParams.get("user");
            if (c != "") {
                $('#username').val(c);
                // $('#form-login').submit();
                // Do Ajax
                var route = "{{ URL('Ajax/Adminspeciallogin') }}";
                var thisdata = {
                    username: $('#username').val()
                };

                Pace.restart();
                Pace.track(function() {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        }
                    });
                    jQuery.ajax({
                        url: route,
                        method: 'post',
                        data: thisdata,
                        dataType: 'JSON',
                        beforeSend: function() {
                            $(".spinner").removeClass('disp-0');
                        },
                        success: function(result) {

                            if (result.message == "success") {
                                // $('#form-login').submit();
                                setTimeout(function() {
                                    location.href = result.link;
                                }, 1000);
                            } else {
                                $(".spinner").addClass('disp-0');
                                console.log(result.res);
                            }

                        }
                    });
                });

            }

        });

        // Register function
        function signIn() {
            var route = "{{ URL('Ajax/Adminlogin') }}";
            if (grecaptcha.getResponse() == "") {
                swal('Oops', 'Check the captcha box', 'info');
                return false;
            }
            if ($('#username').val() == "") {
                swal('Oops!', 'Your username is needed for next login', 'warning');
                return false;
            } else if ($('#password').val() == "") {
                swal('Oops!', 'Password field can\'t be empty', 'warning');
                return false;
            }

            var thisdata = {
                username: $('#username').val(),
                password: $('#password').val(),
            };

            Pace.restart();
            Pace.track(function() {
                setHeaders();
                jQuery.ajax({
                    url: route,
                    method: 'post',
                    data: thisdata,
                    dataType: 'JSON',
                    beforeSend: function() {
                        $(".spinner").removeClass('disp-0');
                    },
                    success: function(result) {
                        if (result.message == 'success') {

                            if (result.link != 'verification') {
                                swal("Welcome Back!", result.res, result.message);

                            }

                            setTimeout(function() {
                                location.href = result.link;
                            }, 2000);
                        } else {
                            $(".spinner").addClass('disp-0');
                            swal("Oops!", result.res, result.message);
                        }

                    }

                });
            });
        }

        function setHeaders() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });
        }
    </script>

    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API = Tawk_API || {},
            Tawk_LoadStart = new Date();
        (function() {
            var s1 = document.createElement("script"),
                s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/60e32cb8649e0a0a5ccaa278/1f9rmdccf';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
    <!--End of Tawk.to Script-->

</body>

</html>
