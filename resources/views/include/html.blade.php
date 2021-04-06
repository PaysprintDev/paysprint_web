<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'PaySprint') }} | {{ $pages }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Favicon -->
<link rel="icon" href="https://res.cloudinary.com/pilstech/image/upload/v1602675914/paysprint_icon_png_ol2z3u.png" type="image/x-icon" />
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweet-modal@1.3.2/dist/min/jquery.sweet-modal.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    {{-- <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet"> --}}
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&display=swap" rel="stylesheet">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

    <link rel="stylesheet" href="{{ asset('ext/plugins/countrycode/css/jquery.ccpicker.css') }}">

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

li.dropdown.submenu > a {
    font-size: 12px !important;
}
.modal-content{top: 140px;}
.cns-content{
            height: 300px !important;
        }


.disp-0{
  display: none !important;
}

.modal{
  z-index: 10500;
}

        /* .slider_inner.camera_wrap{
            height: 400px !important;
            display: block;
            background-color: black !important;
        } */


    </style>

    @if (Auth::check() == true)
        <style>
              .col-md-6.col-sm-6.builder {
                background-color: #fff !important;
                border-radius: 10px !important;
                margin-bottom: 20px !important;
                height: 450px !important;
            }
              .col-md-6.col-sm-6.builder.walletInformation {
                background-color: #fff !important;
                border-radius: 10px !important;
                height: 100px !important;
            }
            ..professional_builders{
              background: #f5f5f5 !important;
              padding-top: 80px !important;
              padding-bottom: 20px !important;
            }
            .infoRec{
              height: 300px;
              overflow-y: auto;
            }
            .fas.fa-circle{
      font-size: 12px !important;
  }
        </style>
    @endif

</head>
<body>

  @include('include.modal')
