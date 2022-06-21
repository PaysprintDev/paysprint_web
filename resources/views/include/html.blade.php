<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="description"
        content="Safe and Secure, Send Money for Free, Fastest and affordable method of sending and receiving money, paying invoice and getting Paid at anytime.">

    <meta name="keywords"
        content="Unlimited Transactions, Add money to Wallet from Debit or Credit Cards., Withdraw money to EXBC, Prepaid Mastercard for Free., Send money Locally and Abroad., Pay Invoice at a click of button., Create and send professional invoice on the Go., Fast-track how you get paid as a merchant, Safe and Secure- multi-level security authentications features, account, affordable, alert, answer, anytime, area, build, business, canada, cardiology, career, cart, check, checkout, click, clients, coming, commerce, components, conditions, confirm, consultant, contact, contents, demo, details, easy ,email, environment, family, fastest, features, footer, forms, free, friends, getting, government, headers, hero, home, invoice, landlord, launch, level, login, manage, management, mbbs, merchant, message, method, modal, money, multi, news, newsletter, opening, page, pages, paid, parking, password, paying, paysprint, pricing, product, property, question, receiving, rental, reset, safe,secure,security, send, sending, senior, services,sign, simple, soon, started, stats, submit,team, terms, testimonial, text, tickets,today, transfer, unique, utility, utitlity, video, wallet, want, works, worry">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'PaySprint') }} | {{ $pages }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Favicon -->
    <link rel="icon"
        href="https://res.cloudinary.com/paysprint/image/upload/v1651130089/assets/paysprint_jpeg_black_bk_2_w4hzub_ioffkg.jpg"
        type="image/x-icon" />
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
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

    <link rel="stylesheet" href="{{ asset('ext/plugins/countrycode/css/jquery.ccpicker.css') }}">

    <script src="https://kit.fontawesome.com/384ade21a6.js"></script>

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>


    <script>
        var appId = `${env('APP_ENV') == 'local' ? env('PUSHER_APP_KEY_DEV') : env('PUSHER_APP_KEY')}`;
        var cluster = `${env('APP_ENV') == 'local' ? env('PUSHER_APP_CLUSTER_DEV') : env('PUSHER_APP_CLUSTER')}`;

        var pusher = new Pusher(appId, {
            cluster: cluster
        });

        var channel = pusher.subscribe('my-channel');
        channel.bind('my-event', function(data) {
            console.log(JSON.stringify(data));
        });
    </script>


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

        .input_box {
            color: #000 !important;
        }

        .form-control {
            border-color: #f6b60d !important;
            width: 100% !important;
        }

        li.dropdown.submenu>a {
            font-size: 12px !important;
        }

        .modal-content {
            top: 140px;
        }

        .cns-content {
            height: 300px !important;
        }


        .disp-0 {
            display: none !important;
        }

        .modal {
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

            ..professional_builders {
                background: #f5f5f5 !important;
                padding-top: 80px !important;
                padding-bottom: 20px !important;
            }

            .infoRec {
                height: 300px;
                overflow-y: auto;
            }

            .fas.fa-circle {
                font-size: 12px !important;
            }

            .badge.badge-success {
                background-color: #2aad2d !important;
            }

            .badge.badge-danger {
                background-color: #a94442 !important;
            }

            .list-group-item {
                font-weight: bold;
            }

            /* Style the header */
            .header {
                padding: 10px 16px;
                background: #555;
                color: #f1f1f1;
            }

            /* Page content */
            .content {
                padding: 16px;
            }

            /* The sticky class is added to the header with JS when it reaches its scroll position */
            .sticky {
                position: fixed;
                top: 0;
                width: 100%;
                z-index: 10000;
                padding-left: 50px;
                padding-right: 50px;

            }

            /* Add some top padding to the page content to prevent sudden quick movement (as the header gets a new position at the top of the page (position:fixed and top:0) */
            .sticky+.content {
                padding-top: 102px;
            }

            @keyframes fa-blink {
                0% {
                    opacity: 1;
                }

                50% {
                    opacity: 0.5;
                }

                100% {
                    opacity: 0;
                }
            }

            .fa-blink {
                -webkit-animation: fa-blink .75s linear infinite;
                -moz-animation: fa-blink .75s linear infinite;
                -ms-animation: fa-blink .75s linear infinite;
                -o-animation: fa-blink .75s linear infinite;
                animation: fa-blink .75s linear infinite;
            }

        </style>
    @endif


    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-RVX8CC7GDP"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-RVX8CC7GDP');
    </script>


    <script type="text/javascript" id="zsiqchat">
        var $zoho = $zoho || {};
        $zoho.salesiq = $zoho.salesiq || {
            widgetcode: "a7ffa31136f6ab021392ea01a2816af0033ebbc69fda5e9fa38407829c8ee302",
            values: {},
            ready: function() {}
        };
        var d = document;
        s = d.createElement("script");
        s.type = "text/javascript";
        s.id = "zsiqscript";
        s.defer = true;
        s.src = "https://salesiq.zoho.com/widget";
        t = d.getElementsByTagName("script")[0];
        t.parentNode.insertBefore(s, t);
    </script>





</head>

<body>

    @include('include.modal')
