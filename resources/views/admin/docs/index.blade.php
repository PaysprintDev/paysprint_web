<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description"
        content="Fastest and affordable method of sending and receiving money, paying invoice and getting Paid at anytime!">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="images/favicon.png">
    <title>PaySprint | API Documentation</title>
    <link rel="stylesheet" href="{{ asset('api_doc/assets/css/docs.css') }}">
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-91615293-4"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-91615293-4');
    </script>
</head>

<body class="nk-body bg-lighter npc-general has-sidebar">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- sidebar @s -->
            <div class="nk-sidebar nk-sidebar-fixed is-light" data-content="sidebarMenu">
                <div class="nk-sidebar-element nk-sidebar-head">
                    <div class="nk-sidebar-brand">
                        <a href="#" class="logo-link nk-sidebar-logo">
                            <img class="logo-light logo-img"
                                src="https://res.cloudinary.com/paysprint/image/upload/v1650628016/assets/pay_sprint_black_horizotal_fwqo6q_ekpq1g.png"
                                srcset="images/logo2x.png 2x" alt="PaySprint">
                            <img class="logo-dark logo-img"
                                src="https://res.cloudinary.com/paysprint/image/upload/v1650628016/assets/pay_sprint_black_horizotal_fwqo6q_ekpq1g.png"
                                srcset="images/logo-dark2x.png 2x" alt="PaySprint">
                        </a>
                    </div>
                    <div class="nk-menu-trigger mr-n2">
                        <a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu"><em
                                class="icon ni ni-arrow-left"></em></a>
                    </div>
                </div>
                <div class="nk-sidebar-element">
                    <div class="nk-sidebar-content mt-4">
                        <div class="nk-sidebar-menu" data-simplebar>
                            <ul class="nk-menu">
                                <li class="nk-menu-heading">
                                    <h6 class="overline-title text-primary-alt">Getting Started</h6>
                                </li>
                                <li class="nk-menu-item">
                                    <a href="#introduction" class="nk-menu-link">
                                        <span class="nk-menu-text">Introduction</span>
                                    </a>
                                </li>
                                <li class="nk-menu-item">
                                    <a href="#fileFolders" class="nk-menu-link">
                                        <span class="nk-menu-text">Base Url</span>
                                    </a>
                                </li>
                                <li class="nk-menu-item">
                                    <a href="#quickStart" class="nk-menu-link">
                                        <span class="nk-menu-text">Bearer Token</span>
                                    </a>
                                </li>
                                <li class="nk-menu-item">
                                    <a href="#jsList" class="nk-menu-link">
                                        <span class="nk-menu-text">Receive Money</span>
                                    </a>
                                </li>
                                <li class="nk-menu-item">
                                    <a href="#cssList" class="nk-menu-link">
                                        <span class="nk-menu-text">Response</span>
                                    </a>
                                </li>
                                <li class="nk-menu-item">
                                    <a href="#rtl" class="nk-menu-link">
                                        <span class="nk-menu-text">Postman Reference </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- sidebar @e -->
            <!-- wrap @s -->
            <div class="nk-wrap ">
                <!-- main header @s -->
                <div class="nk-header nk-header-fixed bg-white">
                    <div class="container-fluid">
                        <div class="nk-header-wrap">
                            <div class="nk-menu-trigger d-xl-none ml-n1">
                                <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="sidebarMenu"><em
                                        class="icon ni ni-menu"></em></a>
                            </div>
                            <div class="nk-header-brand d-xl-none">
                                <a href="#" class="logo-link">
                                    <img class="logo logo-img"
                                        src="https://res.cloudinary.com/paysprint/image/upload/v1650628016/assets/pay_sprint_black_horizotal_fwqo6q_ekpq1g.png"
                                        alt="logo">
                                    <img class="logo-dark logo-img"
                                        src="https://res.cloudinary.com/paysprint/image/upload/v1650628016/assets/pay_sprint_black_horizotal_fwqo6q_ekpq1g.png"
                                        srcset="images/logo-dark2x.png 2x" alt="logo-dark">
                                </a>
                            </div>
                            <div class="nk-header-docs-nav">
                                <div class="dropdown dropdown-expand-lg">
                                    <a href="#" class="btn btn-icon btn-trigger dropdown-toggle" data-toggle="dropdown">
                                        <em class="icon ni ni-more-h"></em>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu dropdown-menu-right">
                                        <div class="dropdown-inner">
                                            <p class="lead-text text-soft pt-4 mb-0 d-lg-none">View Dashboard</p>
                                            <ul class="docs-nav">
                                                <li><a href="#introduction" class="nk-menu-link">Introduction</a></li>
                                                <li><a href="#fileFolders" class="nk-menu-link">Base Url</a></li>
                                                <li><a href="#quickStart" class="nk-menu-link">Bearer Token</a></li>
                                                <li><a href="#jsList" class="nk-menu-link">Receive Money </a></li>
                                                <li><a href="#cssList" class="nk-menu-link">Response</a></li>
                                                <li><a href="#rtl" class="nk-menu-link">Postman Reference</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- main header @e -->
                <!-- content @s -->
                <div class="nk-content ">
                    <div class="container-fluid">
                        <div class="nk-content-inner">
                            <div class="nk-content-body">
                                <div class="wide-md mx-auto">
                                    <!-- content @s -->
                                    <div class="nk-block-head wide-sm">
                                        <div class="nk-block-head-content pt-2">
                                            <h3 class="nk-block-title">PaySprint for Developers</h3>

                                        </div>
                                    </div>

                                    <div class="nk-block-head" id="introduction">
                                        <div class="nk-block-head-content pt-2">
                                            <h5 class="nk-block-title">Getting Started</h5>

                                            <div class="nk-block-des">
                                                <p>
                                                    PaySprint offers developers the ability to receive money from
                                                    third-party application directly to their paysprint wallet
                                                    leveraging on our REST API’s. Entrepreneur’s, Startup companies,
                                                    SME's (Small and Medium Enterprises), MSME’s & Enterprises deploy
                                                    with these solutions.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="hr border-light mb-4">
                                    <div class="nk-block" id="fileFolders">
                                        <div class="nk-block-head">
                                            <div class="nk-block-head-content pt-2">
                                                <h5 class="nk-block-title">BASE URL:</h5>
                                            </div>
                                        </div>


                                        <div class="code-block">
                                            <pre class="prettyprint lang-html" id="filesandfolder">https://paysprint.ca/api/v1</pre>
                                        </div>
                                    </div><!-- nk-block -->

                                    <hr class="hr border-light mt-5 mb-4">
                                    <div class="nk-block" id="quickStart">
                                        <div class="nk-block-head">
                                            <div class="nk-block-head-content pt-2">
                                                <h5 class="nk-block-title">BEARER TOKEN</h5>
                                            </div>
                                        </div>

                                        <div class="card card-bordered">
                                            <div class="card-inner">
                                                <p>Your api key is unique to your account, this has been generated
                                                    during your sign up.</p>
                                                <ul class="gy-2">
                                                    <pre
                                                        class="prettyprint lang-html"> {{ isset($data['getbusinessDetail'])? $data['getbusinessDetail']->api_secrete_key: '4d55fce450eb59d0699f33c6f42b2a73050520211620214476' }} </pre>



                                            </div>
                                        </div>
                                    </div><!-- nk-block -->

                                    <hr class="hr border-light mt-5 mb-4">
                                    <div class="nk-block" id="jsList">
                                        <div class="nk-block-head wide-sm">
                                            <div class="nk-block-head-content pt-2">
                                                <h5 class="nk-block-title">Receive Money Paysprint User <span
                                                        class="badge badge-pill badge-primary">POST</span></h5>
                                            </div>
                                        </div>

                                        <div class="card card-bordered">
                                            <div class="card-inner">
                                                <p>Receive money directly from your website using the endpoint. This is
                                                    for your
                                                    customers that have a PaySprint account</p>

                                                <pre class="prettyprint lang-html">
curl --location --request POST '{baseUrl}/customers' \
--header 'Authorization: Bearer {bearerKey}' \
--form 'accountNumber="11111"' \ //Customer's PaySprint account number
--form 'amount="50"' \ //Amount to charge
--form 'purpose="Contribution"' \ // Purpose of Payment
--form 'transactionPin="1234"' \ // PaySprint transaction pin
--form 'mode="test"' //live or test
</pre>
                                            </div>
                                        </div>


                                    </div>
                                    <hr class="hr border-light mt-5 mb-4">
                                    <div class="nk-block" id="jsList">
                                        <div class="nk-block-head wide-sm">
                                            <div class="nk-block-head-content pt-2">
                                                <h5 class="nk-block-title">Receive Money Guest <span
                                                        class="badge badge-pill badge-primary">POST</span></h5>
                                            </div>
                                        </div>


                                        <div class="card card-bordered">
                                            <div class="card-inner">
                                                <p>Receive money directly from your website using the endpoint. This is
                                                    for your
                                                    customers that does not have a PaySprint account</p>

                                                <pre class="prettyprint lang-html">
curl --location --request POST '{baseUrl}/visitors' \
--header 'Authorization: Bearer {bearerKey}'' \
--form 'firstname="Shawn"' \
--form 'lastname="Davids"' \
--form 'amount="3"' \
--form 'country="Canada"' \
--form 'cardNumber="4111111111111111"' \
--form 'expiryMonth="08"' \
--form 'expiryYear="23"' \
--form 'cardType="Debit Card"' \
--form 'purpose="Partnership"' \
--form 'mode="test"' \ //live
--form 'email="johndoe@example.com"' \
--form 'phone="123456789"'
</pre>
                                            </div>
                                        </div>




                                    </div>


                                    <hr class="hr border-light mt-5 mb-4">
                                    <div class="nk-block" id="cssList">
                                        <div class="nk-block-head wide-sm">
                                            <div class="nk-block-head-content pt-2">
                                                <h5 class="nk-block-title">RESPONSE <span
                                                        class="badge badge-pill badge-success">200</span>

                                                </h5>
                                            </div>
                                        </div>
                                        <div class="code-block">
                                            <!-- <h6 class="overline-title title">Status code</h6> -->
                                            <pre class="prettyprint lang-html">
{
    "data": {
        "name": "Shawn Davids",
        "businessName": null,
        "telephone": "123456789",
        "state": "Ontario",
        "country": "Canada",
        "avatar": "http://paysprint.ca/profilepic/avatar/2092218901_1617494018.jpg",
        "paymentToken": "wallet-140520211621004091",
        "amount": "2",
        "currency": "CAD"
    },

    "message": "Money Sent Successfully",
    "status": 200
}
</pre>
                                        </div>
                                    </div><!-- nk-block -->

                                    <hr class="hr border-light mt-5 mb-4">
                                    <div class="nk-block" id="cssList">
                                        <div class="nk-block-head wide-sm">
                                            <div class="nk-block-head-content pt-2">
                                                <h5 class="nk-block-title">RESPONSE <span
                                                        class="badge badge-pill badge-danger">400</span>

                                                </h5>
                                            </div>
                                        </div>
                                        <div class="code-block">
                                            <!-- <h6 class="overline-title title">Status code</h6> -->
                                            <pre class="prettyprint lang-html">
{
    "data": {},
    "message": "Insufficient balance!. Your current wallet balance is CAD 1.00",
    "status": 400
}
</pre>
                                        </div>
                                    </div><!-- nk-block -->


                                    <hr class="hr border-light mt-5 mb-4">
                                    <div class="nk-block" id="rtl">
                                        <div class="nk-block-head wide-sm">
                                            <div class="nk-block-head-content pt-2">
                                                <h5 class="nk-block-title">POSTMAN REFERENCE</h5>
                                            </div>
                                        </div>
                                        <div class="row g-gs">
                                            <div class="col-12">
                                                <div class="card card-bordered">
                                                    <div class="card-inner">
                                                        <h6 class="overline-title">Run it on POSTMAN
                                                        </h6>
                                                        <p>
                                                            <a href="https://documenter.getpostman.com/view/6125941/UVyswvMn"
                                                                target="_blank">https://documenter.getpostman.com/view/6125941/UVyswvMn</a>
                                                        </p>
                                                        <div class="postman-run-button"
                                                            data-postman-action="collection/import"
                                                            data-postman-var-1="7135ceea9cd86961f373"
                                                            data-postman-param="env%5BPaySprint%20Endpoint%5D=W3sia2V5IjoidXJsIiwidmFsdWUiOiJodHRwczovL3BheXNwcmludC5uZXQvYXBpL3YxIiwiZW5hYmxlZCI6dHJ1ZX0seyJrZXkiOiJhcHBrZXkiLCJ2YWx1ZSI6ImJhc2U2NDpKRk0rUEphV0QvcEJ5cFgrTmhYdWREckFtaWFuWmRHWVo0MXF6NFdoWEwwPSIsImVuYWJsZWQiOnRydWV9LHsia2V5IjoiYmVhcmVyIiwidmFsdWUiOiJleUowZVhBaU9pSktWMVFpTENKaGJHY2lPaUpTVXpJMU5pSXNJbXAwYVNJNkltTXdNV0UzTkdOaVpEaG1NalZtT1dVd1pXTmhaVEJsT1dNek1HUTNZVFJtTW1Sak16SmxPRFUyT0RJeU9HTXlaak5pTWpJd1l6TTRaRGhqTVROaE9URmpNVFkzWTJVM05qbGtNamhsT1dJMEluMC5leUpoZFdRaU9pSXhJaXdpYW5ScElqb2lZekF4WVRjMFkySmtPR1l5TldZNVpUQmxZMkZsTUdVNVl6TXdaRGRoTkdZeVpHTXpNbVU0TlRZNE1qSTRZekptTTJJeU1qQmpNemhrT0dNeE0yRTVNV014TmpkalpUYzJPV1F5T0dVNVlqUWlMQ0pwWVhRaU9qRTJNak15T1RVME5EZ3NJbTVpWmlJNk1UWXlNekk1TlRRME9Dd2laWGh3SWpveE5qVTBPRE14TkRRNExDSnpkV0lpT2lJeE15SXNJbk5qYjNCbGN5STZXMTE5LnJXZWZZQU5MaUJ0VTktdjNGQWJLamthWmhvV09hNWVCcEo2TVZnbG1IbUZrMmVzSG4yQlJ6a0lkNUo0ZTQ2V1daR1NucEFEdUZ3Y2NDbncwX1dDRmlsS256WGtMNnhnc243dzdhWXFzY0RZZEtfS3BHN0d6eGpmVzNNQk1LSmpSUU1mZWhxVDZoWHl4NnNDaWpMRFFDaWsxM3ZfRXNHVzZtX1UzNm5MZ3RRZWtmM0phckppakdyaXF5RHJEZkhiZlNzaU9UVzFtVjZsc2V1RXNyS0dPV3dhcWJrTzBMQ3FGU21VWGVfM2FXM0xwNzY1VmFzbGVabHVFcE5jbHNDMUk3alR0Z3pxVHdGUzVGVWNoQXYxNzB3R3l3enk5M3c4ejQ1bXEyeXVNV0owbFdYV1pWZ24tVmc3ZzhBNFU0VU1GeUxHRTd1dEVvTk1IR3k5bFJiWU9iUG84R3U4QXpEVVVUc2MwQm1HTzNKaTRsN1VyV3hBSG5uNWN2Ykx1YXA1SDdKaFpPSGJVWnpSdjhQUHc5cHBsc3huek5Zd2tpbER5Y3VXeFpHOUZjLWFPeHBYYnZMaDJlQTc1VFdna1ZSOUJqT1V6Qkp3bVE4UzhBR19OVmx5aTE2amdyb0g1Z3J1STl6eTU3bHNCd2JqdzBnV0Y5dXRqdFNmUnp4emNRS2xHNHBoc2dYUjlISDA4MVFNSGJodG92VGg2d1VvOHh2VGJQd0ZxSHlSSjVEOHJhbldWYjMyZDZGMjRNOUY2eUdYVmxWblVaTU0wSEhjdG9hWC1oVzhIQm5uV0otZkdXVFFSaEdTbXB1Uk1nMG0xaVFjRVFfMVpwaGRLVURxMzdvaHRwWnJyTlJiSXFIWm1pV1RNMFNXcV9jNHdjY2RyNkZPZHpLZVVlY1pLTUFjIiwiZW5hYmxlZCI6dHJ1ZX0seyJrZXkiOiJtZXJjaGFudGtleSIsInZhbHVlIjoiOTYyYzE2MGM4NzhlYWY4ZjY5NmUyZDdlNGIxZGZhNDAyOTA0MjAyMTE2MTk2ODk3NjUiLCJlbmFibGVkIjp0cnVlfV0=">
                                                        </div>
                                                        <script type="text/javascript">
                                                            (function(p, o, s, t, m, a, n) {
                                                                !p[s] && (p[s] = function() {
                                                                    (p[t] || (p[t] = [])).push(arguments);
                                                                });
                                                                !o.getElementById(s + t) && o.getElementsByTagName(
                                                                    "head")[0].appendChild((
                                                                    (n = o.createElement("script")),
                                                                    (n.id = s + t), (n.async = 1), (n.src = m),
                                                                    n
                                                                ));
                                                            }(window, document, "_pm", "PostmanRunObject",
                                                                "https://run.pstmn.io/button.js"));
                                                        </script>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- nk-block -->



                                </div><!-- nk-block -->











                            </div><!-- nk-block -->
                            <!-- content @e -->
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- content @e -->
    </div>
    <!-- wrap @e -->
    </div>
    <!-- main @e -->
    </div>
    <!-- app-root @e -->
    <!-- JavaScript -->
    <script src="{{ asset('api_doc/assets/js/bundle.js?ver=1.0.0') }}"></script>
    <script src="{{ asset('api_doc/assets/js/scripts.js?ver=1.0.0') }}"></script>
</body>

</html>
