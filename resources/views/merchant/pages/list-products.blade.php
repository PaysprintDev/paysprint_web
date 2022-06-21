<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from laravel.pixelstrap.com/viho/ecommerce/list-products by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 03 Nov 2021 16:30:46 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="viho admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities. laravel/framework: ^8.40">
    <meta name="keywords"
        content="admin template, viho admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">
    <link rel="icon" href="../assets/images/favicon.png" type="image/x-icon">
    <link rel="shortcut icon" href="../assets/images/favicon.png" type="image/x-icon">
    <title>Product list
        | Viho - Premium Admin Template
    </title>
    <!-- Google font-->
    <link rel="preconnect" href="https://fonts.gstatic.com/">
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&amp;display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap"
        rel="stylesheet">
    <!-- Font Awesome-->
    <link rel="stylesheet" type="text/css" href="../assets/css/fontawesome.css">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="../assets/css/icofont.css">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="../assets/css/themify.css">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="../assets/css/flag-icon.css">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="../assets/css/feather-icon.css">
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="../assets/css/datatables.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/owlcarousel.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/rating.css">
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
    <link id="color" rel="stylesheet" href="../assets/css/color-1.css" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="../assets/css/responsive.css">
</head>

<body>
    <!-- Loader starts-->
    <div class="loader-wrapper">
        <div class="theme-loader"></div>
    </div>
    <!-- Loader ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-sidebar" id="pageWrapper">
        <!-- Page Header Start-->
        <div class="page-main-header">
            <div class="main-header-right row m-0">
                <div class="main-header-left">
                    <div class="logo-wrapper"><a href="../{{ route('dashboard') }}"><img class="img-fluid"
                                src="../assets/images/logo/logo.png" alt=""></a></div>
                    <div class="dark-logo-wrapper"><a href="../{{ route('dashboard') }}"><img class="img-fluid"
                                src="../assets/images/logo/dark-logo.png" alt=""></a></div>
                    <div class="toggle-sidebar"><i class="status_toggle middle" data-feather="align-center"
                            id="sidebar-toggle"> </i></div>
                </div>
                <div class="left-menu-header col">
                    <ul>
                        <li>
                            <form class="form-inline search-form">
                                <div class="search-bg"><i class="fa fa-search"></i>
                                    <input class="form-control-plaintext" placeholder="Search here.....">
                                </div>
                            </form>
                            <span class="d-sm-none mobile-search search-bg"><i class="fa fa-search"></i></span>
                        </li>
                    </ul>
                </div>
                <div class="nav-right col pull-right right-menu p-0">
                    <ul class="nav-menus">
                        <li><a class="text-dark" href="#!" onclick="javascript:toggleFullScreen()"><i
                                    data-feather="maximize"></i></a></li>
                        <li class="onhover-dropdown">
                            <div class="bookmark-box"><i data-feather="star"></i></div>
                            <div class="bookmark-dropdown onhover-show-div">
                                <div class="form-group mb-0">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i
                                                    class="fa fa-search"></i></span></div>
                                        <input class="form-control" type="text" placeholder="Search for bookmark...">
                                    </div>
                                </div>
                                <ul>
                                    <li class="add-to-bookmark"><i class="bookmark-icon"
                                            data-feather="inbox"></i>Email<span class="pull-right"><i
                                                data-feather="star"></i></span></li>
                                    <li class="add-to-bookmark"><i class="bookmark-icon"
                                            data-feather="message-square"></i>Chat<span class="pull-right"><i
                                                data-feather="star"></i></span></li>
                                    <li class="add-to-bookmark"><i class="bookmark-icon"
                                            data-feather="command"></i>Feather Icon<span class="pull-right"><i
                                                data-feather="star"></i></span></li>
                                    <li class="add-to-bookmark"><i class="bookmark-icon"
                                            data-feather="airplay"></i>Widgets<span class="pull-right"><i
                                                data-feather="star"> </i></span></li>
                                </ul>
                            </div>
                        </li>
                        <li class="onhover-dropdown">
                            <div class="notification-box"><i data-feather="bell"></i><span
                                    class="dot-animated"></span></div>
                            <ul class="notification-dropdown onhover-show-div">
                                <li>
                                    <p class="f-w-700 mb-0">You have 3 Notifications<span
                                            class="pull-right badge badge-primary badge-pill">4</span></p>
                                </li>
                                <li class="noti-primary">
                                    <div class="media">
                                        <span class="notification-bg bg-light-primary"><i data-feather="activity">
                                            </i></span>
                                        <div class="media-body">
                                            <p>Delivery processing </p>
                                            <span>10 minutes ago</span>
                                        </div>
                                    </div>
                                </li>
                                <li class="noti-secondary">
                                    <div class="media">
                                        <span class="notification-bg bg-light-secondary"><i data-feather="check-circle">
                                            </i></span>
                                        <div class="media-body">
                                            <p>Order Complete</p>
                                            <span>1 hour ago</span>
                                        </div>
                                    </div>
                                </li>
                                <li class="noti-success">
                                    <div class="media">
                                        <span class="notification-bg bg-light-success"><i data-feather="file-text">
                                            </i></span>
                                        <div class="media-body">
                                            <p>Tickets Generated</p>
                                            <span>3 hour ago</span>
                                        </div>
                                    </div>
                                </li>
                                <li class="noti-danger">
                                    <div class="media">
                                        <span class="notification-bg bg-light-danger"><i data-feather="user-check">
                                            </i></span>
                                        <div class="media-body">
                                            <p>Delivery Complete</p>
                                            <span>6 hour ago</span>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <div class="mode"><i class="fa fa-moon-o"></i></div>
                        </li>
                        <li class="onhover-dropdown">
                            <i data-feather="message-square"></i>
                            <ul class="chat-dropdown onhover-show-div">
                                <li>
                                    <div class="media">
                                        <img class="img-fluid rounded-circle me-3" src="../assets/images/user/4.jpg"
                                            alt="">
                                        <div class="media-body">
                                            <span>Ain Chavez</span>
                                            <p class="f-12 light-font">Lorem Ipsum is simply dummy...</p>
                                        </div>
                                        <p class="f-12">32 mins ago</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="media">
                                        <img class="img-fluid rounded-circle me-3" src="../assets/images/user/1.jpg"
                                            alt="">
                                        <div class="media-body">
                                            <span>Erica Hughes</span>
                                            <p class="f-12 light-font">Lorem Ipsum is simply dummy...</p>
                                        </div>
                                        <p class="f-12">58 mins ago</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="media">
                                        <img class="img-fluid rounded-circle me-3" src="../assets/images/user/2.jpg"
                                            alt="">
                                        <div class="media-body">
                                            <span>Kori Thomas</span>
                                            <p class="f-12 light-font">Lorem Ipsum is simply dummy...</p>
                                        </div>
                                        <p class="f-12">1 hr ago</p>
                                    </div>
                                </li>
                                <li class="text-center"> <a class="f-w-700" href="javascript:void(0)">See All
                                    </a></li>
                            </ul>
                        </li>
                        <li class="onhover-dropdown p-0">
                            <button class="btn btn-primary-light" type="button"><i data-feather="log-out"></i>Log
                                out</button>
                        </li>
                    </ul>
                </div>
                <div class="d-lg-none mobile-toggle pull-right w-auto"><i data-feather="more-horizontal"></i></div>
            </div>
        </div>
        <!-- Page Header Ends -->
        <!-- Page Body Start-->
        <div class="page-body-wrapper sidebar-icon">
            <!-- Page Sidebar Start-->
            <header class="main-nav">
                <div class="sidebar-user text-center">
                    <a class="setting-primary" href="javascript:void(0)"><i data-feather="settings"></i></a><img
                        class="img-90 rounded-circle" src="../assets/images/dashboard/1.png" alt="" />
                    <div class="badge-bottom"><span class="badge badge-primary">New</span></div>
                    <a href="user-profile.html">
                        <h6 class="mt-3 f-14 f-w-600">Emay Walter</h6>
                    </a>
                    <p class="mb-0 font-roboto">Human Resources Department</p>
                    <ul>
                        <li>
                            <span><span class="counter">19.8</span>k</span>
                            <p>Follow</p>
                        </li>
                        <li>
                            <span>2 year</span>
                            <p>Experince</p>
                        </li>
                        <li>
                            <span><span class="counter">95.2</span>k</span>
                            <p>Follower</p>
                        </li>
                    </ul>
                </div>
                <nav>
                    <div class="main-navbar">
                        <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
                        <div id="mainnav">
                            <ul class="nav-menu custom-scrollbar">
                                <li class="back-btn">
                                    <div class="mobile-back text-end"><span>Back</span><i
                                            class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
                                </li>
                                <li class="sidebar-main-title">
                                    <div>
                                        <h6>General</h6>
                                    </div>
                                </li>
                                <li class="dropdown">
                                    <a class="nav-link menu-title " href="javascript:void(0)"><i
                                            data-feather="home"></i><span>Dashboard</span></a>
                                    <ul class="nav-submenu menu-content" style="display: none;">
                                        <li><a href="../{{ route('dashboard') }}" class="">Default</a>
                                        </li>
                                        <li><a href="../dashboard/dashboard-02.html"
                                                class="">Ecommerce</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a class="nav-link menu-title " href="javascript:void(0)"><i
                                            data-feather="airplay"></i><span>Widgets</span></a>
                                    <ul class="nav-submenu menu-content" style="display: none;">
                                        <li><a href="../widgets/general-widget.html" class="">General</a>
                                        </li>
                                        <li><a href="../widgets/chart-widget.html" class="">Chart</a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="sidebar-main-title">
                                    <div>
                                        <h6>Components</h6>
                                    </div>
                                </li>
                                <li class="dropdown">
                                    <a class="nav-link menu-title " href="javascript:void(0)"><i
                                            data-feather="box"></i><span>Ui Kits</span></a>
                                    <ul class="nav-submenu menu-content" style="display: none;">
                                        <li><a href="../ui-kits/state-color.html" class="">State
                                                color</a></li>
                                        <li><a href="../ui-kits/typography.html" class="">Typography</a>
                                        </li>
                                        <li><a href="../ui-kits/avatars.html" class="">Avatars</a></li>
                                        <li><a href="../ui-kits/helper-classes.html" class="">helper
                                                classes</a></li>
                                        <li><a href="../ui-kits/grid.html" class="">Grid</a></li>
                                        <li><a href="../ui-kits/tag-pills.html" class="">Tag & pills</a>
                                        </li>
                                        <li><a href="../ui-kits/progress-bar.html" class="">Progress</a>
                                        </li>
                                        <li><a href="../ui-kits/modal.html" class="">Modal</a></li>
                                        <li><a href="../ui-kits/alert.html" class="">Alert</a></li>
                                        <li><a href="../ui-kits/popover.html" class="">Popover</a></li>
                                        <li><a href="../ui-kits/tooltip.html" class="">Tooltip</a></li>
                                        <li><a href="../ui-kits/loader.html" class="">Spinners</a></li>
                                        <li><a href="../ui-kits/dropdown.html" class="">Dropdown</a></li>
                                        <li><a href="../ui-kits/according.html" class="">Accordion</a>
                                        </li>
                                        <li>
                                            <a class="submenu-title  " href="javascript:void(0)">
                                                Tabs<span class="sub-arrow"><i
                                                        class="fa fa-chevron-right"></i></span>
                                            </a>
                                            <ul class="nav-sub-childmenu submenu-content" style="display: none;">
                                                <li><a href="../ui-kits/tab-bootstrap.html"
                                                        class="">Bootstrap Tabs</a></li>
                                                <li><a href="../ui-kits/tab-material.html" class="">Line
                                                        Tabs</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="../ui-kits/navs.html" class="">Navs</a></li>
                                        <li><a href="../ui-kits/box-shadow.html" class="">Shadow</a></li>
                                        <li><a href="../ui-kits/list.html" class="">Lists</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a class="nav-link menu-title " href="javascript:void(0)"><i
                                            data-feather="folder-plus"></i><span>Bonus Ui</span></a>
                                    <ul class="nav-submenu menu-content" style="display: none;">
                                        <li><a href="../bonus-ui/scrollable.html" class="">Scrollable</a>
                                        </li>
                                        <li><a href="../bonus-ui/tree.html" class="">Tree view</a></li>
                                        <li><a href="../bonus-ui/bootstrap-notify.html"
                                                class="">Bootstrap Notify</a></li>
                                        <li><a href="../bonus-ui/rating.html" class="">Rating</a></li>
                                        <li><a href="../bonus-ui/dropzone.html" class="">dropzone</a>
                                        </li>
                                        <li><a href="../bonus-ui/tour.html" class="">Tour</a></li>
                                        <li><a href="../bonus-ui/sweet-alert2.html"
                                                class="">SweetAlert2</a></li>
                                        <li><a href="../bonus-ui/modal-animated.html" class="">Animated
                                                Modal</a></li>
                                        <li><a href="../bonus-ui/owl-carousel.html" class="">Owl
                                                Carousel</a></li>
                                        <li><a href="../bonus-ui/ribbons.html" class="">Ribbons</a></li>
                                        <li><a href="../bonus-ui/pagination.html" class="">Pagination</a>
                                        </li>
                                        <li><a href="../bonus-ui/steps.html" class="">Steps</a></li>
                                        <li><a href="../bonus-ui/breadcrumb.html" class="">Breadcrumb</a>
                                        </li>
                                        <li><a href="../bonus-ui/range-slider.html" class="">Range
                                                Slider</a></li>
                                        <li><a href="../bonus-ui/image-cropper.html" class="">Image
                                                cropper</a></li>
                                        <li><a href="../bonus-ui/sticky.html" class="">Sticky </a></li>
                                        <li><a href="../bonus-ui/basic-card.html" class="">Basic Card</a>
                                        </li>
                                        <li><a href="../bonus-ui/creative-card.html" class="">Creative
                                                Card</a></li>
                                        <li><a href="../bonus-ui/tabbed-card.html" class="">Tabbed
                                                Card</a></li>
                                        <li><a href="../bonus-ui/dragable-card.html" class="">Draggable
                                                Card</a></li>
                                        <li>
                                            <a class="submenu-title " href="javascript:void(0)">
                                                Timeline<span class="sub-arrow"><i
                                                        class="fa fa-chevron-right"></i></span>
                                            </a>
                                            <ul class="nav-sub-childmenu submenu-content" style="display: none;">
                                                <li><a href="../bonus-ui/timeline-v-1.html"
                                                        class="">Timeline 1</a></li>
                                                <li><a href="../bonus-ui/timeline-v-2.html"
                                                        class="">Timeline 2</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a class="nav-link menu-title " href="javascript:void(0)"><i
                                            data-feather="edit-3"></i><span>Builders</span></a>
                                    <ul class="nav-submenu menu-content" style="display: none;">
                                        <li><a href="../builders/form-builder-1.html" class="">Form
                                                Builder 1</a></li>
                                        <li><a href="../builders/form-builder-2.html" class="">Form
                                                Builder 2</a></li>
                                        <li><a href="../builders/pagebuild.html" class="">Page
                                                Builder</a></li>
                                        <li><a href="../builders/button-builder.html" class="">Button
                                                Builder</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a class="nav-link menu-title " href="javascript:void(0)"><i
                                            data-feather="cloud-drizzle"></i><span>Animation</span></a>
                                    <ul class="nav-submenu menu-content" style="display: none;">
                                        <li><a href="../animation/animate.html" class="">Animate</a></li>
                                        <li><a href="../animation/scroll-reval.html" class="">Scroll
                                                Reveal</a></li>
                                        <li><a href="../animation/aos.html" class="">AOS animation</a>
                                        </li>
                                        <li><a href="../animation/tilt.html" class="">Tilt Animation</a>
                                        </li>
                                        <li><a href="../animation/wow.html" class="">Wow Animation</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a class="nav-link menu-title " href="javascript:void(0)"><i
                                            data-feather="command"></i><span>Icons</span></a>
                                    <ul class="nav-submenu menu-content" style="display: none;">
                                        <li><a href="../icons/flag-icon.html" class="">Flag icon</a></li>
                                        <li><a href="../icons/font-awesome.html" class="">Fontawesome
                                                Icon</a></li>
                                        <li><a href="../icons/ico-icon.html" class="">Ico Icon</a></li>
                                        <li><a href="../icons/themify-icon.html" class="">Thimify
                                                Icon</a></li>
                                        <li><a href="../icons/feather-icon.html" class="">Feather
                                                icon</a></li>
                                        <li><a href="../icons/whether-icon.html" class="">Whether Icon
                                            </a></li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a class="nav-link menu-title " href="javascript:void(0)"><i
                                            data-feather="cloud"></i><span>Buttons</span></a>
                                    <ul class="nav-submenu menu-content" style="display: none;">
                                        <li><a href="../buttons/buttons.html" class="">Default Style</a>
                                        </li>
                                        <li><a href="../buttons/buttons-flat.html" class="">Flat
                                                Style</a></li>
                                        <li><a href="../buttons/buttons-edge.html" class="">Edge
                                                Style</a></li>
                                        <li><a href="../buttons/raised-button.html" class="">Raised
                                                Style</a></li>
                                        <li><a href="../buttons/button-group.html" class="">Button
                                                Group</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a class="nav-link menu-title " href="javascript:void(0)"><i
                                            data-feather="bar-chart"></i><span>Charts</span></a>
                                    <ul class="nav-submenu menu-content" style="display: none;">
                                        <li><a href="../charts/chart-apex.html" class="">Apex Chart</a>
                                        </li>
                                        <li><a href="../charts/chart-google.html" class="">Google
                                                Chart</a></li>
                                        <li><a href="../charts/chart-sparkline.html" class="">Sparkline
                                                chart</a></li>
                                        <li><a href="../charts/chart-flot.html" class="">Flot Chart</a>
                                        </li>
                                        <li><a href="../charts/chart-knob.html" class="">Knob Chart</a>
                                        </li>
                                        <li><a href="../charts/chart-morris.html" class="">Morris
                                                Chart</a></li>
                                        <li><a href="../charts/chartjs.html" class="">Chatjs Chart</a>
                                        </li>
                                        <li><a href="../charts/chartist.html" class="">Chartist Chart</a>
                                        </li>
                                        <li><a href="../charts/chart-peity.html" class="">Peity Chart</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="sidebar-main-title">
                                    <div>
                                        <h6>Forms</h6>
                                    </div>
                                </li>
                                <li class="dropdown">
                                    <a class="nav-link menu-title " href="javascript:void(0)"><i
                                            data-feather="sliders"></i><span>Form Controls </span></a>
                                    <ul class="nav-submenu menu-content" style="display: none;">
                                        <li><a href="../form-controls/form-validation.html" class="">Form
                                                Validation</a></li>
                                        <li><a href="../form-controls/base-input.html" class="">Base
                                                Inputs</a></li>
                                        <li><a href="../form-controls/radio-checkbox-control.html"
                                                class="">Checkbox & Radio</a></li>
                                        <li><a href="../form-controls/input-group.html" class="">Input
                                                Groups</a></li>
                                        <li><a href="../form-controls/megaoptions.html" class="">Mega
                                                Options </a></li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a class="nav-link menu-title " href="javascript:void(0)"><i
                                            data-feather="package"></i><span>Form Widgets</span></a>
                                    <ul class="nav-submenu menu-content" style="display: none;">
                                        <li><a href="../form-widgets/datepicker.html"
                                                class="">Datepicker</a></li>
                                        <li><a href="../form-widgets/time-picker.html"
                                                class="">Timepicker</a></li>
                                        <li><a href="../form-widgets/datetimepicker.html"
                                                class="">Datetimepicker</a></li>
                                        <li><a href="../form-widgets/daterangepicker.html"
                                                class="">Daterangepicker</a></li>
                                        <li><a href="../form-widgets/touchspin.html"
                                                class="">Touchspin</a></li>
                                        <li><a href="../form-widgets/select2.html" class="">Select2</a>
                                        </li>
                                        <li><a href="../form-widgets/switch.html" class="">Switch</a>
                                        </li>
                                        <li><a href="../form-widgets/typeahead.html"
                                                class="">Typeahead</a></li>
                                        <li><a href="../form-widgets/clipboard.html" class="">Clipboard
                                            </a></li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a class="nav-link menu-title " href="javascript:void(0)"><i
                                            data-feather="layout"></i><span>Form layout</span></a>
                                    <ul class="nav-submenu menu-content" style="display: none;">
                                        <li><a href="../form-layout/default-form.html" class="">Default
                                                Forms</a></li>
                                        <li><a href="../form-layout/form-wizard.html" class="">Form
                                                Wizard 1</a></li>
                                        <li><a href="../form-layout/form-wizard-two.html" class="">Form
                                                Wizard 2</a></li>
                                        <li><a href="../form-layout/form-wizard-three.html" class="">Form
                                                Wizard 3</a></li>
                                    </ul>
                                </li>
                                <li class="sidebar-main-title">
                                    <div>
                                        <h6>Table</h6>
                                    </div>
                                </li>
                                <li class="dropdown">
                                    <a class="nav-link menu-title " href="javascript:void(0)"><i
                                            data-feather="server"></i><span>Bootstrap Tables </span></a>
                                    <ul class="nav-submenu menu-content" style="display: none;">
                                        <li><a href="../bootstrap-tables/bootstrap-basic-table.html"
                                                class="">Basic Tables</a></li>
                                        <li><a href="../bootstrap-tables/bootstrap-sizing-table.html"
                                                class="">Sizing Tables</a></li>
                                        <li><a href="../bootstrap-tables/bootstrap-border-table.html"
                                                class="">Border Tables</a></li>
                                        <li><a href="../bootstrap-tables/bootstrap-styling-table.html"
                                                class="">Styling Tables</a></li>
                                        <li><a href="../bootstrap-tables/table-components.html"
                                                class="">Table components</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a class="nav-link menu-title " href="javascript:void(0)"><i
                                            data-feather="database"></i><span>Data Tables </span></a>
                                    <ul class="nav-submenu menu-content" style="display: none;">
                                        <li><a href="../data-tables/datatable-basic-init.html"
                                                class="">Basic Init</a></li>
                                        <li><a href="../data-tables/datatable-advance.html"
                                                class="">Advance Init</a></li>
                                        <li><a href="../data-tables/datatable-styling.html"
                                                class="">Styling</a></li>
                                        <li><a href="../data-tables/datatable-AJAX.html"
                                                class="">AJAX</a></li>
                                        <li><a href="../data-tables/datatable-server-side.html"
                                                class="">Server Side</a></li>
                                        <li><a href="../data-tables/datatable-plugin.html"
                                                class="">Plug-in</a></li>
                                        <li><a href="../data-tables/datatable-API.html" class="">API</a>
                                        </li>
                                        <li><a href="../data-tables/datatable-data-source.html"
                                                class="">Data Sources</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a class="nav-link menu-title " href="javascript:void(0)"><i
                                            data-feather="hard-drive"></i><span>Ex. Data Tables </span></a>
                                    <ul class="nav-submenu menu-content" style="display: none;">
                                        <li><a href="../ex-data-tables/datatable-ext-autofill.html"
                                                class="">Auto Fill</a></li>
                                        <li><a href="../ex-data-tables/datatable-ext-basic-button.html"
                                                class="">Basic Button</a></li>
                                        <li><a href="../ex-data-tables/datatable-ext-col-reorder.html"
                                                class="">Column Reorder</a></li>
                                        <li><a href="../ex-data-tables/datatable-ext-fixed-header.html"
                                                class="">Fixed Header</a></li>
                                        <li><a href="../ex-data-tables/datatable-ext-key-table.html"
                                                class="">Key Table</a></li>
                                        <li><a href="../ex-data-tables/datatable-ext-responsive.html"
                                                class="">Responsive</a></li>
                                        <li><a href="../ex-data-tables/datatable-ext-row-reorder.html"
                                                class="">Row Reorder</a></li>
                                        <li><a href="../ex-data-tables/datatable-ext-scroller.html"
                                                class="">Scroller </a></li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a class="nav-link menu-title link-nav " href="../jsgrid-table.html"><i
                                            data-feather="file-text"></i><span>Js Grid Table</span></a>
                                </li>
                                <li class="sidebar-main-title">
                                    <div>
                                        <h6>Applications</h6>
                                    </div>
                                </li>
                                <li class="dropdown">
                                    <a class="nav-link menu-title " href="javascript:void(0)"><i
                                            data-feather="box"></i><span>Project </span></a>
                                    <ul class="nav-submenu menu-content" style="display: none;">
                                        <li><a href="../project/projects.html" class="">Project List</a>
                                        </li>
                                        <li><a href="../project/projectcreate.html" class="">Create new
                                            </a></li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a class="nav-link menu-title link-nav " href="../file-manager.html"><i
                                            data-feather="git-pull-request"></i><span>File manager</span></a>
                                </li>
                                <li class="dropdown">
                                    <a class="nav-link menu-title link-nav " href="../kanban.html"><i
                                            data-feather="monitor"></i><span>Kanban Board</span></a>
                                </li>
                                <li class="dropdown">
                                    <a class="nav-link menu-title active" href="javascript:void(0)"><i
                                            data-feather="shopping-bag"></i><span>Ecommerce</span></a>
                                    <ul class="nav-submenu menu-content" style="display: block;">
                                        <li><a href="product.html" class="">Product</a></li>
                                        <li><a href="product-page.html" class="">Product page</a></li>
                                        <li><a href="list-products.html" class="active">Product list</a></li>
                                        <li><a href="payment-details.html" class="">Payment Details</a>
                                        </li>
                                        <li><a href="order-history.html" class="">Order History</a></li>
                                        <li><a href="invoice-template.html" class="">Invoice</a></li>
                                        <li><a href="cart.html" class="">Cart</a></li>
                                        <li><a href="list-wish.html" class="">Wishlist</a></li>
                                        <li><a href="checkout.html" class="">Checkout</a></li>
                                        <li><a href="pricing.html" class="">Pricing</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a class="nav-link menu-title " href="javascript:void(0)"><i
                                            data-feather="mail"></i><span>Email</span></a>
                                    <ul class="nav-submenu menu-content" style="display: none;">
                                        <li><a href="../email/email_inbox.html" class="">Mail Inbox</a>
                                        </li>
                                        <li><a href="../email/email_read.html" class="">Read mail</a>
                                        </li>
                                        <li><a href="../email/email_compose.html" class="">Compose</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a class="nav-link menu-title " href="javascript:void(0)"><i
                                            data-feather="message-circle"></i><span>Chat</span></a>
                                    <ul class="nav-submenu menu-content" style="display: none;">
                                        <li><a href="../chat/chat.html" class="">Chat App</a></li>
                                        <li><a href="../chat/chat-video.html" class="">Video chat</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a class="nav-link menu-title " href="javascript:void(0)"><i
                                            data-feather="users"></i><span>Users</span></a>
                                    <ul class="nav-submenu menu-content" style="display: none;">
                                        <li><a href="../users/user-profile.html" class="">Users
                                                Profile</a></li>
                                        <li><a href="../users/edit-profile.html" class="">Users Edit</a>
                                        </li>
                                        <li><a href="../users/user-cards.html" class="">Users Cards</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a class="nav-link menu-title link-nav " href="../bookmark.html"><i
                                            data-feather="heart"></i><span>Bookmarks</span></a>
                                </li>
                                <li class="dropdown">
                                    <a class="nav-link menu-title link-nav " href="../contacts.html"><i
                                            data-feather="list"></i><span>Contacts</span></a>
                                </li>
                                <li class="dropdown">
                                    <a class="nav-link menu-title link-nav " href="../task.html"><i
                                            data-feather="check-square"></i><span>Tasks</span></a>
                                </li>
                                <li class="dropdown">
                                    <a class="nav-link menu-title link-nav " href="../calendar-basic.html"><i
                                            data-feather="calendar"></i><span>Calender </span></a>
                                </li>
                                <li class="dropdown">
                                    <a class="nav-link menu-title link-nav " href="../social-app.html"><i
                                            data-feather="zap"></i><span>Social App</span></a>
                                </li>
                                <li class="dropdown">
                                    <a class="nav-link menu-title link-nav " href="../to-do.html"><i
                                            data-feather="clock"></i><span>To-Do</span></a>
                                </li>
                                <li class="dropdown">
                                    <a class="nav-link menu-title link-nav " href="../search.html"><i
                                            data-feather="search"></i><span>Search Result</span></a>
                                </li>
                                <li class="sidebar-main-title">
                                    <div>
                                        <h6>Pages</h6>
                                    </div>
                                </li>
                                <li>

                                </li>
                                <li>
                                    <a class="nav-link menu-title link-nav " href="../sample-page.html"><i
                                            data-feather="file"></i><span>Sample page</span></a>
                                </li>
                                <li class="dropdown">
                                    <a class="nav-link menu-title link-nav " href="../internationalization.html"><i
                                            data-feather="aperture"></i><span>Internationalization</span></a>
                                </li>
                                <li class="mega-menu">
                                    <a class="nav-link menu-title " href="javascript:void(0)"><i
                                            data-feather="layers"></i><span>Others</span></a>
                                    <div class="mega-menu-container menu-content" style="display: none;">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col mega-box">
                                                    <div class="link-section">
                                                        <div class="submenu-title">
                                                            <h5>Error Page</h5>
                                                        </div>
                                                        <div class="submenu-content opensubmegamenu">
                                                            <ul>
                                                                <li><a href="../error-page1.html"
                                                                        class="" target="_blank">Error
                                                                        page 1</a></li>
                                                                <li><a href="../error-page2.html"
                                                                        class="" target="_blank">Error
                                                                        page 2</a></li>
                                                                <li><a href="../error-page3.html"
                                                                        class="" target="_blank">Error
                                                                        page 3</a></li>
                                                                <li><a href="../error-page4.html"
                                                                        class="" target="_blank">Error
                                                                        page 4 </a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col mega-box">
                                                    <div class="link-section">
                                                        <div class="submenu-title">
                                                            <h5>Authentication</h5>
                                                        </div>
                                                        <div class="submenu-content opensubmegamenu">
                                                            <ul>
                                                                <li><a href="../login.html" class=""
                                                                        target="_blank">Login Simple</a></li>
                                                                <li><a href="../login_one.html" class=""
                                                                        target="_blank">Login with bg image</a></li>
                                                                <li><a href="../login_two.html" class=""
                                                                        target="_blank">Login with image two </a></li>
                                                                <li><a href="../login-bs-validation.html"
                                                                        class="" target="_blank">Login
                                                                        With validation</a></li>
                                                                <li><a href="../login-bs-tt-validation.html"
                                                                        class="" target="_blank">Login
                                                                        with tooltip</a></li>
                                                                <li><a href="../login-sa-validation.html"
                                                                        class="" target="_blank">Login
                                                                        with sweetalert</a></li>
                                                                <li><a href="../sign-up.html" class=""
                                                                        target="_blank">Register Simple</a></li>
                                                                <li><a href="../sign-up-one.html"
                                                                        class="" target="_blank">Register
                                                                        with Bg Image </a></li>
                                                                <li><a href="../sign-up-two.html"
                                                                        class="" target="_blank">Register
                                                                        with Bg video </a></li>
                                                                <li><a href="../unlock.html"
                                                                        class="">Unlock User</a></li>
                                                                <li><a href="../forget-password.html"
                                                                        class="">Forget Password</a></li>
                                                                <li><a href="../creat-password.html"
                                                                        class="">Creat Password</a></li>
                                                                <li><a href="../maintenance.html"
                                                                        class="">Maintenance</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col mega-box">
                                                    <div class="link-section">
                                                        <div class="submenu-title">
                                                            <h5>Coming Soon</h5>
                                                        </div>
                                                        <div class="submenu-content opensubmegamenu">
                                                            <ul>
                                                                <li><a href="../comingsoon.html"
                                                                        class="">Coming Simple</a></li>
                                                                <li><a href="../comingsoon-bg-video.html"
                                                                        class="">Coming with Bg video</a>
                                                                </li>
                                                                <li><a href="../comingsoon-bg-img.html"
                                                                        class="">Coming with Bg Image</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col mega-box">
                                                    <div class="link-section">
                                                        <div class="submenu-title">
                                                            <h5>Email templates</h5>
                                                        </div>
                                                        <div class="submenu-content opensubmegamenu">
                                                            <ul>
                                                                <li><a href="../basic-template.html"
                                                                        class="">Basic Email</a></li>
                                                                <li><a href="../email-header.html"
                                                                        class="">Basic With Header</a>
                                                                </li>
                                                                <li><a href="../template-email.html"
                                                                        class="">Ecomerce Template</a>
                                                                </li>
                                                                <li><a href="../template-email-2.html"
                                                                        class="">Email Template 2</a>
                                                                </li>
                                                                <li><a href="../ecommerce-templates.html"
                                                                        class="">Ecommerce Email</a></li>
                                                                <li><a href="../email-order-success.html"
                                                                        class="">Order Success </a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="sidebar-main-title">
                                    <div>
                                        <h6>Miscellaneous</h6>
                                    </div>
                                </li>
                                <li class="dropdown">
                                    <a class="nav-link menu-title " href="javascript:void(0)"><i
                                            data-feather="image"></i><span>Gallery</span></a>
                                    <ul class="nav-submenu menu-content" style="display: none;">
                                        <li><a href="../gallery.html" class="">Gallery Grid</a></li>
                                        <li><a href="../gallery/gallery-with-description.html"
                                                class="">Gallery Grid Desc</a></li>
                                        <li><a href="../gallery/gallery-masonry.html" class="">Masonry
                                                Gallery</a></li>
                                        <li><a href="../gallery/masonry-gallery-with-disc.html"
                                                class="">Masonry with Desc</a></li>
                                        <li><a href="../gallery/gallery-hover.html" class="">Hover
                                                Effects</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a class="nav-link menu-title " href="javascript:void(0)"><i
                                            data-feather="edit"></i><span>Blog</span></a>
                                    <ul class="nav-submenu menu-content" style="display: none;">
                                        <li><a href="../blog.html" class="">Blog Details</a></li>
                                        <li><a href="../blog/blog-single.html" class="">Blog Single</a>
                                        </li>
                                        <li><a href="../blog/add-post.html" class="">Add Post</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a class="nav-link menu-title link-nav " href="../faq.html"><i
                                            data-feather="help-circle"></i><span>FAQ</span></a>
                                </li>
                                <li class="dropdown">
                                    <a class="nav-link menu-title " href="javascript:void(0)"><i
                                            data-feather="user-check"></i><span>Job Search</span></a>
                                    <ul class="nav-submenu menu-content" style="display: none;">
                                        <li><a href="../job-search/job-cards-view.html" class="">Cards
                                                view</a></li>
                                        <li><a href="../job-search/job-list-view.html" class="">List
                                                View</a></li>
                                        <li><a href="../job-search/job-details.html" class="">Job
                                                Details</a></li>
                                        <li><a href="../job-search/job-apply.html" class="">Apply</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a class="nav-link menu-title " href="javascript:void(0)"><i
                                            data-feather="layers"></i><span>Learning</span></a>
                                    <ul class="nav-submenu menu-content" style="display: none;">
                                        <li><a href="../learning/learning-list-view.html"
                                                class="">Learning List</a></li>
                                        <li><a href="../learning/learning-detailed.html"
                                                class="">Detailed Course</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a class="nav-link menu-title " href="javascript:void(0)"><i
                                            data-feather="map"></i><span>Maps</span></a>
                                    <ul class="nav-submenu menu-content" style="display: none;">
                                        <li><a href="../maps/map-js.html" class="">Maps JS</a></li>
                                        <li><a href="../maps/vector-map.html" class="">Vector Maps</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a class="nav-link menu-title " href="javascript:void(0)"><i
                                            data-feather="git-pull-request"></i><span>Editors</span></a>
                                    <ul class="nav-submenu menu-content" style="display: none;">
                                        <li><a href="../editors/summernote.html" class="">Summer Note</a>
                                        </li>
                                        <li><a href="../editors/ckeditor.html" class="">CK editor</a>
                                        </li>
                                        <li><a href="../editors/simple-MDE.html" class="">MDE editor</a>
                                        </li>
                                        <li><a href="../editors/ace-code-editor.html" class="">ACE code
                                                editor</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a class="nav-link menu-title link-nav " href="../knowledgebase.html"><i
                                            data-feather="database"></i><span>Knowledgebase</span></a>
                                </li>
                            </ul>
                        </div>
                        <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
                    </div>
                </nav>
            </header>
            <!-- Page Sidebar Ends-->
            <div class="page-body">
                <!-- Container-fluid starts-->
                <div class="container-fluid">
                    <div class="page-header">
                        <div class="row">
                            <div class="col-lg-6">
                                <h3>Product list</h3>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="../{{ route('dashboard') }}">Home</a></li>
                                    <li class="breadcrumb-item">Pages</li>
                                    <li class="breadcrumb-item">Ecommerce</li>
                                    <li class="breadcrumb-item active">Product list</li>
                                </ol>
                            </div>
                            <div class="col-lg-6">
                                <!-- Bookmark Start-->
                                <div class="bookmark">
                                    <ul>
                                        <li><a href="javascript:void(0)" data-container="body" data-bs-toggle="popover"
                                                data-placement="top" title="" data-original-title="Tables"><i
                                                    data-feather="inbox"></i></a></li>
                                        <li><a href="javascript:void(0)" data-container="body" data-bs-toggle="popover"
                                                data-placement="top" title="" data-original-title="Chat"><i
                                                    data-feather="message-square"></i></a></li>
                                        <li><a href="javascript:void(0)" data-container="body" data-bs-toggle="popover"
                                                data-placement="top" title="" data-original-title="Icons"><i
                                                    data-feather="command"></i></a></li>
                                        <li><a href="javascript:void(0)" data-container="body" data-bs-toggle="popover"
                                                data-placement="top" title="" data-original-title="Learning"><i
                                                    data-feather="layers"></i></a></li>
                                        <li>
                                            <a href="javascript:void(0)"><i class="bookmark-search"
                                                    data-feather="star"></i></a>
                                            <form class="form-inline search-form">
                                                <div class="form-group form-control-search">
                                                    <input type="text" placeholder="Search..">
                                                </div>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                                <!-- Bookmark Ends-->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid list-products">
                    <div class="row">
                        <!-- Individual column searching (text inputs) Starts-->
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header pb-0">
                                    <h5>Individual column searching (text inputs)</h5>
                                    <span>
                                        The searching functionality provided by DataTables is useful for quickly search
                                        through the information in the table - however the search is global, and you may
                                        wish to present controls that search on specific
                                        columns.
                                    </span>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive product-table">
                                        <table class="display" id="basic-1">
                                            <thead>
                                                <tr>
                                                    <th>Image</th>
                                                    <th>Details</th>
                                                    <th>Amount</th>
                                                    <th>Stock</th>
                                                    <th>Start date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <a href="#"><img
                                                                src="../assets/images/ecommerce/product-table-1.png"
                                                                alt="" /></a>
                                                    </td>
                                                    <td>
                                                        <a href="#">
                                                            <h6>Red Lipstick</h6>
                                                        </a><span>Interchargebla lens Digital Camera with APS-C-X Trans
                                                            CMOS Sens</span>
                                                    </td>
                                                    <td>$10</td>
                                                    <td class="font-success">In Stock</td>
                                                    <td>2011/04/25</td>
                                                    <td>
                                                        <button class="btn btn-danger btn-xs" type="button"
                                                            data-original-title="btn btn-danger btn-xs"
                                                            title="">Delete</button>
                                                        <button class="btn btn-primary btn-xs" type="button"
                                                            data-original-title="btn btn-danger btn-xs"
                                                            title="">Edit</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <a href="#"><img
                                                                src="../assets/images/ecommerce/product-table-2.png"
                                                                alt="" /></a>
                                                    </td>
                                                    <td>
                                                        <a href="#">
                                                            <h6>Pink Lipstick</h6>
                                                        </a>
                                                        <p>Interchargebla lens Digital Camera with APS-C-X Trans CMOS
                                                            Sens</p>
                                                    </td>
                                                    <td>$10</td>
                                                    <td class="font-primary">Low Stock</td>
                                                    <td>2011/04/25</td>
                                                    <td>
                                                        <button class="btn btn-danger btn-xs" type="button"
                                                            data-original-title="btn btn-danger btn-xs"
                                                            title="">Delete</button>
                                                        <button class="btn btn-primary btn-xs" type="button"
                                                            data-original-title="btn btn-danger btn-xs"
                                                            title="">Edit</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <a href="#"><img
                                                                src="../assets/images/ecommerce/product-table-3.png"
                                                                alt="" /></a>
                                                    </td>
                                                    <td>
                                                        <a href="#">
                                                            <h6>Gray Lipstick</h6>
                                                        </a>
                                                        <p>Interchargebla lens Digital Camera with APS-C-X Trans CMOS
                                                            Sens</p>
                                                    </td>
                                                    <td>$10</td>
                                                    <td class="font-danger">out of stock</td>
                                                    <td>2011/04/25</td>
                                                    <td>
                                                        <button class="btn btn-danger btn-xs" type="button"
                                                            data-original-title="btn btn-danger btn-xs"
                                                            title="">Delete</button>
                                                        <button class="btn btn-primary btn-xs" type="button"
                                                            data-original-title="btn btn-danger btn-xs"
                                                            title="">Edit</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <a href="#"><img
                                                                src="../assets/images/ecommerce/product-table-4.png"
                                                                alt="" /></a>
                                                    </td>
                                                    <td>
                                                        <a href="#">
                                                            <h6>Green Lipstick</h6>
                                                        </a>
                                                        <p>Interchargebla lens Digital Camera with APS-C-X Trans CMOS
                                                            Sens</p>
                                                    </td>
                                                    <td>$10</td>
                                                    <td class="font-primary">Low Stock</td>
                                                    <td>2011/04/25</td>
                                                    <td>
                                                        <button class="btn btn-danger btn-xs" type="button"
                                                            data-original-title="btn btn-danger btn-xs"
                                                            title="">Delete</button>
                                                        <button class="btn btn-primary btn-xs" type="button"
                                                            data-original-title="btn btn-danger btn-xs"
                                                            title="">Edit</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <a href="#"><img
                                                                src="../assets/images/ecommerce/product-table-5.png"
                                                                alt="" /></a>
                                                    </td>
                                                    <td>
                                                        <a href="#">
                                                            <h6>Black Lipstick</h6>
                                                        </a>
                                                        <p>Interchargebla lens Digital Camera with APS-C-X Trans CMOS
                                                            Sens</p>
                                                    </td>
                                                    <td>$10</td>
                                                    <td class="font-success">In Stock</td>
                                                    <td>2011/04/25</td>
                                                    <td>
                                                        <button class="btn btn-danger btn-xs" type="button"
                                                            data-original-title="btn btn-danger btn-xs"
                                                            title="">Delete</button>
                                                        <button class="btn btn-primary btn-xs" type="button"
                                                            data-original-title="btn btn-danger btn-xs"
                                                            title="">Edit</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <a href="#"><img
                                                                src="../assets/images/ecommerce/product-table-6.png"
                                                                alt="" /></a>
                                                    </td>
                                                    <td>
                                                        <a href="#">
                                                            <h6>White Lipstick</h6>
                                                        </a>
                                                        <p>Interchargebla lens Digital Camera with APS-C-X Trans CMOS
                                                            Sens</p>
                                                    </td>
                                                    <td>$10</td>
                                                    <td class="font-primary">Low Stock</td>
                                                    <td>2011/04/25</td>
                                                    <td>
                                                        <button class="btn btn-danger btn-xs" type="button"
                                                            data-original-title="btn btn-danger btn-xs"
                                                            title="">Delete</button>
                                                        <button class="btn btn-primary btn-xs" type="button"
                                                            data-original-title="btn btn-danger btn-xs"
                                                            title="">Edit</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <a href="#"><img
                                                                src="../assets/images/ecommerce/product-table-1.png"
                                                                alt="" /></a>
                                                    </td>
                                                    <td>
                                                        <a href="#">
                                                            <h6>light Lipstick</h6>
                                                        </a>
                                                        <p>Interchargebla lens Digital Camera with APS-C-X Trans CMOS
                                                            Sens</p>
                                                    </td>
                                                    <td>$10</td>
                                                    <td class="font-danger">out of stock</td>
                                                    <td>2011/04/25</td>
                                                    <td>
                                                        <button class="btn btn-danger btn-xs" type="button"
                                                            data-original-title="btn btn-danger btn-xs"
                                                            title="">Delete</button>
                                                        <button class="btn btn-primary btn-xs" type="button"
                                                            data-original-title="btn btn-danger btn-xs"
                                                            title="">Edit</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <a href="#"><img
                                                                src="../assets/images/ecommerce/product-table-2.png"
                                                                alt="" /></a>
                                                    </td>
                                                    <td>
                                                        <a href="#">
                                                            <h6>Gliter Lipstick</h6>
                                                        </a>
                                                        <p>Interchargebla lens Digital Camera with APS-C-X Trans CMOS
                                                            Sens</p>
                                                    </td>
                                                    <td>$10</td>
                                                    <td class="font-danger">out of stock</td>
                                                    <td>2011/04/25</td>
                                                    <td>
                                                        <button class="btn btn-danger btn-xs" type="button"
                                                            data-original-title="btn btn-danger btn-xs"
                                                            title="">Delete</button>
                                                        <button class="btn btn-primary btn-xs" type="button"
                                                            data-original-title="btn btn-danger btn-xs"
                                                            title="">Edit</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <a href="#"><img
                                                                src="../assets/images/ecommerce/product-table-3.png"
                                                                alt="" /></a>
                                                    </td>
                                                    <td>
                                                        <a href="#">
                                                            <h6>green Lipstick</h6>
                                                        </a>
                                                        <p>Interchargebla lens Digital Camera with APS-C-X Trans CMOS
                                                            Sens</p>
                                                    </td>
                                                    <td>$10</td>
                                                    <td class="font-success">In Stock</td>
                                                    <td>2011/04/25</td>
                                                    <td>
                                                        <button class="btn btn-danger btn-xs" type="button"
                                                            data-original-title="btn btn-danger btn-xs"
                                                            title="">Delete</button>
                                                        <button class="btn btn-primary btn-xs" type="button"
                                                            data-original-title="btn btn-danger btn-xs"
                                                            title="">Edit</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <a href="#"><img
                                                                src="../assets/images/ecommerce/product-table-4.png"
                                                                alt="" /></a>
                                                    </td>
                                                    <td>
                                                        <a href="#">
                                                            <h6>Yellow Lipstick</h6>
                                                        </a>
                                                        <p>Interchargebla lens Digital Camera with APS-C-X Trans CMOS
                                                            Sens</p>
                                                    </td>
                                                    <td>$10</td>
                                                    <td class="font-danger">out of stock</td>
                                                    <td>2011/04/25</td>
                                                    <td>
                                                        <button class="btn btn-danger btn-xs" type="button"
                                                            data-original-title="btn btn-danger btn-xs"
                                                            title="">Delete</button>
                                                        <button class="btn btn-primary btn-xs" type="button"
                                                            data-original-title="btn btn-danger btn-xs"
                                                            title="">Edit</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Individual column searching (text inputs) Ends-->
                    </div>
                </div>


                <!-- Container-fluid Ends-->
            </div>
            <!-- footer start-->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6 footer-copyright">
                            <p class="mb-0">Copyright 2021-22 © viho All rights reserved.</p>
                        </div>
                        <div class="col-md-6">
                            <p class="pull-right mb-0">Hand crafted & made with <i
                                    class="fa fa-heart font-secondary"></i></p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <!-- latest jquery-->
    <script src="../assets/js/jquery-3.5.1.min.js"></script>
    <!-- feather icon js-->
    <script src="../assets/js/icons/feather-icon/feather.min.js"></script>
    <script src="../assets/js/icons/feather-icon/feather-icon.js"></script>
    <!-- Sidebar jquery-->
    <script src="../assets/js/sidebar-menu.js"></script>
    <script src="../assets/js/config.js"></script>
    <!-- Bootstrap js-->
    <script src="../assets/js/bootstrap/popper.min.js"></script>
    <script src="../assets/js/bootstrap/bootstrap.min.js"></script>
    <!-- Plugins JS start-->
    <script src="../assets/js/datatable/datatables/jquery.dataTables.min.js"></script>
    <script src="../assets/js/rating/jquery.barrating.js"></script>
    <script src="../assets/js/rating/rating-script.js"></script>
    <script src="../assets/js/owlcarousel/owl.carousel.js"></script>
    <script src="../assets/js/ecommerce.js"></script>
    <script src="../assets/js/product-list-custom.js"></script>
    <!-- Plugins JS Ends-->
    <!-- Theme js-->
    <script src="../assets/js/script.js"></script>
    <script src="../assets/js/theme-customizer/customizer.js"></script>
    <!-- Plugin used-->
</body>

<!-- Mirrored from laravel.pixelstrap.com/viho/ecommerce/list-products by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 03 Nov 2021 16:30:48 GMT -->

</html>
