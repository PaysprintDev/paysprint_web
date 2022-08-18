<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description"
        content="Safe and Secure, Send Money for Free, Fastest and affordable method of sending and receiving money, paying invoice and getting Paid at anytime.">

    <meta name="keywords"
        content="Unlimited Transactions, Add money to Wallet from Debit or Credit Cards., Withdraw money to EXBC, Prepaid Mastercard for Free., Send money Locally and Abroad., Pay Invoice at a click of button., Create and send professional invoice on the Go., Fast-track how you get paid as a merchant, Safe and Secure- multi-level security authentications features, account, affordable, alert, answer, anytime, area, build, business, canada, cardiology, career, cart, check, checkout, click, clients, coming, commerce, components, conditions, confirm, consultant, contact, contents, demo, details, easy ,email, environment, family, fastest, features, footer, forms, free, friends, getting, government, headers, hero, home, invoice, landlord, launch, level, login, manage, management, mbbs, merchant, message, method, modal, money, multi, news, newsletter, opening, page, pages, paid, parking, password, paying, paysprint, pricing, product, property, question, receiving, rental, reset, safe,secure,security, send, sending, senior, services,sign, simple, soon, started, stats, submit,team, terms, testimonial, text, tickets,today, transfer, unique, utility, utitlity, video, wallet, want, works, worry">


    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description"
        content="Fastest and affordable method of sending and receiving money, paying invoice and getting Paid at anytime!">
    <title>{{ config('app.name', 'PaySprint') }} | {{ $pages }}</title>
    <!-- Favicon -->
    <link rel="icon"
        href="https://res.cloudinary.com/paysprint/image/upload/v1651130089/assets/paysprint_jpeg_black_bk_2_w4hzub_ioffkg.jpg"
        type="image/x-icon" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">


    <style>
        li {
            font-weight: 600;
            font-size: 16px;
        }

        .body-section {
            width: 100%;
            height: 350px;
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            background-color: #fff2ca;
            /* background-image: url('https://static.vecteezy.com/system/resources/previews/003/557/257/original/abstract-blue-and-gray-wave-background-free-vector.jpg') */
        }

        .posterImage {
            width: 500px;
            height: 500px;
        }

        .posterImage img {
            width: 400px;
            height: 400px;
            border-radius: 100%;
        }

        .subtitle{
            font-size: 23px;
        }

        .text-content {
            font-size: 35px;
        }
    </style>

</head>

<body>
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('images/paysprint_logo/merchant.png') }}" alt="" width="200"
                    height="70">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <div class="mx-auto"></div>

                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">HOME</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}">ABOUT US</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">CONTACT</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pricing structure merchant') }}">PRICING</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('display country') }}">SEARCH COUNTRY</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('AdminLogin') }}">LOGIN</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('accounts') }}">GET STARTED</a>
                    </li>


                </ul>

            </div>
        </div>
    </nav>



    <section class="body-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12 mt-5">
                    <br>
                    <br>
                    <div class="col-md-7">
                        <h3>Save up to 90% on fees when you accept payments</h3>
                        <h1>from Customers with PaySprint.</h1>
                        <p>
                            Accept Payments on any mobile device (for In-Store Sales) and on Website (for Online Sales)
                            with no transaction fees.
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section class="account-section">
        <div class="container">
            <div class="mt-5 text-center">
                <h2>Let’s find the right account for your needs</h2>
                <p class="subtitle mt-3">Please select the option that describes you the best</p>
                <p class="text-content mt-4 mb-5">I'm a</p>

                <div class="row mx-auto">
                    <div class="col-md-6 mb-3">
                        <div class="card" style="cursor: pointer" onClick="location.href='{{ route('register') }}'">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <img src="https://img.icons8.com/external-flat-geotatah/64/000000/external-alone-work-life-balance-flat-flat-geotatah.png"/>
                                </h5>
                                <h5 class="card-title">Individual</h5>
                                <p>
                                    <small>(Freelancer/Sole Proprietor)</small>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="card" style="cursor: pointer" onClick="location.href='{{ route('AdminRegister') }}'">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <img src="https://img.icons8.com/external-inipagistudio-mixed-inipagistudio/64/000000/external-corporate-professional-mentorship-inipagistudio-mixed-inipagistudio.png"/>
                                </h5>
                                <h5 class="card-title">Company</h5>
                                <p>
                                    <small>(Online Store/Market Place/Small or Medium Size Businesses)</small>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

              <script src="https://unpkg.com/react@18/umd/react.development.js" crossorigin></script>
  <script src="https://unpkg.com/react-dom@18/umd/react-dom.development.js" crossorigin></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous">



    </script>
</body>

</html>
