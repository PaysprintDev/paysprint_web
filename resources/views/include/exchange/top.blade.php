<!DOCTYPE html>
<html dir="ltr" lang="en">


<head>
    <title>{{ config('app.name', 'PaySprint') }} | Currency Exchange</title>
    <meta charset="UTF-8">
    <meta name="description"
        content="Fastest and affordable method of sending and receiving money, paying invoice and getting Paid at anytime!">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="https://res.cloudinary.com/pilstech/image/upload/v1618251695/paysprint_icon_new_kg2h3j.png"
        type="image/x-icon" />

    <link href="{{ asset('cfx/assets/vendor/simplebar/dist/simplebar.min.css') }}" rel="stylesheet" type="text/css"
        media="all">

    <link href="{{ asset('cfx/assets/css/theme.min.css') }}" rel="stylesheet" type="text/css" media="all">


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

<body class="bg-gray-100 project-management-template">
