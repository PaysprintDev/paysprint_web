<!DOCTYPE html>
<html class="no-js" lang="zxx">


<!-- Mirrored from htmldemo.net/mitech/index-processing.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 08 Jun 2022 09:14:09 GMT -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>

        @isset($data['myServiceStore'])
        {{ $data['user']->businessname }}
        @else
        PaySprint | Merchant Service
        @endisset


    </title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->

    @isset($data['myServiceStore']->businessLogo)
        <link rel="icon" href="{{ $data['myServiceStore']->businessLogo }}">
        @else
       <link rel="icon" href="{{ asset('merchantassets/service/assets/images/favicon.webp') }}">
        @endisset



    <!-- CSS
        ============================================ -->

    <!-- Vendor & Plugins CSS (Please remove the comment from below vendor.min.css & plugins.min.css for better website load performance and remove css files from avobe) -->

    <link rel="stylesheet" href="{{ asset('merchantassets/service/assets/css/vendor/vendor.min.css') }}">
    <link rel="stylesheet" href="{{ asset('merchantassets/service/assets/css/plugins/plugins.min.css') }}">

    <!-- Main Style CSS -->
    <link rel="stylesheet" href="{{ asset('merchantassets/service/assets/css/style.css') }}">

</head>

<body>
