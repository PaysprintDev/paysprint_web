<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from rstill.netlify.app/ by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 18 Sep 2020 11:51:55 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->

<head>
    <!-- Meta -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Saveon Auto Repair - Business Profile">
    <meta name="keywords" content="cv, resume, portfolio, creative, modern">
    <meta name="author" content="Hamza Gourram">
    <!-- Page Title -->
    <title>PaySprint Business Profile</title>
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('business/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('business/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('business/css/tootik.css') }}">
    <link rel="stylesheet" href="{{ asset('business/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('business/css/swiper.css') }}">
    <link rel="stylesheet" href="{{ asset('business/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('business/css/style.css') }}">
    <!-- Light & Dark Color -->
    <link rel="stylesheet" id="light-dark" href="{{ asset('business/css/colors/light.css') }}">
    <!-- Theme Color -->
    <link rel="stylesheet" id="colors" href="{{ asset('business/css/colors/color1-0487cc.css') }}">
    <!-- Responsive style -->
    <link rel="stylesheet" href="{{ asset('business/css/responsive.css') }}">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/ico"
        href="https://upload.wikimedia.org/wikipedia/commons/a/a8/Ski_trail_rating_symbol_black_circle.png">
    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Oswald:300,400,700|PT+Sans+Narrow:400,700">
    <script src="https://kit.fontawesome.com/384ade21a6.js"></script>
    <style>
        .progress {
            margin-bottom: 0px !important;
        }

        .disp-0 {
            display: none !important;
        }

        img.comphotos {
            width: 100%;
            height: 200px;
        }

    </style>
</head>

<body>

    <div class="content">
        <!-- #LOADER# -->
        <!-- other loader : http://tobiasahlin.com/spinkit/ -->
        <div class="loading-overlay">
            <div class="spinner">
                <div class="rect1"></div>
                <div class="rect2"></div>
                <div class="rect3"></div>
                <div class="rect4"></div>
                <div class="rect5"></div>
            </div>
        </div>

        <!-- #MENU# -->
        <div class="menu">
            <h2 class="logo"></h2>
            <div class="menu-content">
                <ul>
                    <li onclick="window.history.back()"><a href="#">GO BACK</a></li>
                    <li><a class="active" href="#" data-value="about">ABOUT</a></li>
                </ul>
            </div>
            <div class="open-menu">
                <i class="fa fa-bars"></i>
            </div>
        </div>

        <!-- #SCROLL-TOP# -->
        <div class="scroll-top" data-tootik="TOP" data-tootik-conf="invert no-arrow no-fading">
            <i class="fa fa-arrow-up"></i>
        </div>
        <!-- #CONTAINER# -->
        <div class="container">
            <!-- #ABOUT# -->
            <section id="about" class="section section-about wow fadeInUp">
                <div class="profile">
                    <div class="row">
                        <div class="col-sm-4">

                            <div class="photo-profile">

                                <img id="my_image"
                                    src="{{ $data['businessprofile']->avatar != null ? $data['businessprofile']->avatar : 'https://res.cloudinary.com/pilstech/image/upload/v1617797524/paysprint_asset/paysprint_jpeg_black_bk_ft8qly.jpg' }}"
                                    alt="Business Image">


                            </div>

                            <br>
                            <div class="title-skills">
                                <h3>SERVICE OFFERED</h3>
                            </div>

                            <div class="skill">
                                <b></b>
                            </div>

                            <br>
                            <div class="title-skills">
                                <h3>LOCATION</h3>
                            </div>

                            <div class="skill">
                                <iframe
                                    src="https://www.google.com/maps/embed?{{ $data['businessprofile']->address }}"
                                    width="100%" height="auto" frameborder="0" style="border:0;" allowfullscreen=""
                                    aria-hidden="false" tabindex="0"></iframe>

                                <a type="button" class="btn btn-primary btn-block"
                                    href="https://www.google.com/maps/place/{{ $data['businessprofile']->address }}"
                                    target="_blank">Visit Address</a>
                            </div>


                        </div>
                        <div class="col-sm-8">
                            <div class="info-profile">
                                <h2>{{ $data['businessprofile']->businessname }}</h2>
                                <h3>

                                    {!! $data['businessprofile']->bvn_verification > 0
    ? '<i class="fa fa-check-circle" aria-hidden="true"
                                        style="color: green; font-size: 15px;"></i> <span class="text-available"
                                        style="font-size: 15px; font-weight: bold;">Verified</span> '
    : '<i class="fa fa-check-circle" aria-hidden="true"
                                        style="color: green; font-size: 15px;"></i> <span class="text-available"
                                        style="font-size: 15px; font-weight: bold;">Not verified</span> ' !!}



                                </h3>



                                <p>


                                    {!! $data['merchantbusiness']->description !!}

                                </p>

                                <hr>
                                <h2>Company Information</h2>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <span class="title-infos"><i class="fas fa-users"></i> Nature of
                                            Business</span>
                                    </div>
                                    <div class="col-md-6">
                                        <b>{!! $data['merchantbusiness']->nature_of_business !!}</b>
                                    </div>
                                    <br><br>
                                    <div class="col-md-6">
                                        <span class="title-infos"><i class="fas fa-users"></i> Corporate
                                            Type</span>
                                    </div>
                                    <div class="col-md-6">
                                        <b>{!! $data['merchantbusiness']->corporate_type !!}</b>
                                    </div>
                                    <br><br>

                                    <div class="col-md-6">
                                        <span class="title-infos"><i class="fas fa-map-marker"></i> Business
                                            Email</span>
                                    </div>
                                    <div class="col-md-6">
                                        <b>{!! $data['merchantbusiness']->email !!}</b>
                                    </div>
                                    <br><br>


                                    <div class="col-md-6">
                                        <span class="title-infos"><i class="fas fa-map-marker"></i> Business
                                            Telephone</span>
                                    </div>
                                    <div class="col-md-6">
                                        <b>{!! $data['merchantbusiness']->telephone !!}</b>
                                    </div>
                                    <br><br>


                                    <div class="col-md-6">
                                        <span class="title-infos"><i class="fas fa-map-marker"></i> Address</span>
                                    </div>
                                    <div class="col-md-6">
                                        <b>{!! $data['merchantbusiness']->address !!}</b>
                                    </div>
                                    <br><br>


                                    <div class="col-md-6">
                                        <span class="title-infos"><i class="fas fa-city"></i> City</span>
                                    </div>
                                    <div class="col-md-6">
                                        <b> {!! $data['merchantbusiness']->city !!}</b>
                                    </div>
                                    <br><br>

                                    <div class="col-md-6">
                                        <span class="title-infos"><i class="fas fa-mail-bulk"></i> Postal/Zip
                                            code</span>
                                    </div>
                                    <div class="col-md-6">
                                        <b> {!! $data['merchantbusiness']->zip_code !!}</b>
                                    </div>
                                    <br><br>


                                    <div class="col-md-6">
                                        <span class="title-infos"><i class="fas fa-flag-usa"></i>
                                            State/Province</span>
                                    </div>
                                    <div class="col-md-6">
                                        <b> {!! $data['merchantbusiness']->state !!}</b>
                                    </div>
                                    <br><br>


                                    <div class="col-md-6">
                                        <span class="title-infos"><i class="fas fa-globe-europe"></i> Country</span>
                                    </div>
                                    <div class="col-md-6">
                                        <b>{!! $data['merchantbusiness']->country !!}</b>
                                    </div>
                                    <br><br>



                                    <div class="col-md-6">
                                        <span class="title-infos"><i class="fas fa-globe-europe"></i> Website</span>
                                    </div>
                                    <div class="col-md-6">
                                        <b>{!! $data['merchantbusiness']->website !!}</b>
                                    </div>
                                    <br><br>


                                </div>
                                <br><br>








                                <hr>
                                <h2>Contact Information</h2>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <span class="title-infos"><i class="fas fa-user"></i> Fullname</span>
                                    </div>
                                    <div class="col-md-6">
                                        <b> {{ $data['businessprofile']->name }}</b>
                                    </div>
                                    <br><br>

                                    <div class="col-md-6">
                                        <span class="title-infos"><i class="fas fa-mobile-alt"></i> Contact Email
                                            Address</span>
                                    </div>
                                    <div class="col-md-6">
                                        <b> {{ $data['businessprofile']->email }}</b>
                                    </div>

                                    <br><br>
                                    <div class="col-md-6">
                                        <span class="title-infos"><i class="fas fa-mobile-alt"></i> Contact
                                            Telephone</span>
                                    </div>
                                    <div class="col-md-6">
                                        <b> {{ $data['businessprofile']->telephone }}</b>
                                    </div>
                                    <br><br>



                                </div>
                                <br><br>








                            </div>
                        </div>

                        <!-- #JQUERY-PLUGINS# -->
                        <script src="{{ asset('business/js/jquery.min.js') }}"></script>
                        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
                        <script src="{{ asset('business/js/bootstrap.min.js') }}"></script>
                        <script src="{{ asset('business/js/jquery.magnific-popup.min.js') }}"></script>
                        <script src="{{ asset('business/js/swiper.min.js') }}"></script>
                        <script src="{{ asset('business/js/jquery.easypiechart.min.js') }}"></script>
                        <script src="{{ asset('business/js/wow.min.js') }}"></script>
                        <script src="{{ asset('business/js/validator.min.js') }}"></script>
                        <script src="{{ asset('business/js/form-scripts.js') }}"></script>
                        <script src="{{ asset('business/js/script.js') }}"></script>
                        <script>
                            /**** EasyPieChart Circle Progress ****/
                            $(function() {
                                //circle progress additional skills
                                $('.chart').easyPieChart({
                                    barColor: '#757575',
                                    trackColor: 'rgba(255,255,255,0)',
                                    scaleColor: 'rgba(255,255,255,0)',
                                    lineWidth: '10',
                                    lineCap: 'square'
                                });
                            });


                            function comingSoon() {
                                swal('Hey!', 'This feature is coming soon to your screen', 'info');
                            }
                        </script>

</body>

<!-- Mirrored from rstill.netlify.app/ by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 18 Sep 2020 11:52:26 GMT -->

</html>
