<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">


    <!-- Favicon -->
    <link rel="icon"
        href="https://res.cloudinary.com/paysprint/image/upload/v1651130089/assets/paysprint_jpeg_black_bk_2_w4hzub_ioffkg.jpg"
        type="image/x-icon" />

    <link rel="stylesheet" type="text/css" href="{{ asset('pace/themes/orange/pace-theme-flash.css') }}" />
    <script src="https://kit.fontawesome.com/384ade21a6.js"></script>

    <title>PaySprint | Payment</title>
</head>

<body>


    <div class="container">
        <div class="row">
            <div class="col-md-6 mx-auto pt-5 mt-5">
                <div class="card mt-5">
                    <h5 class="card-header">System Message</h5>
                    <div class="card-body">
                        <p
                            class="card-text alert {{ Request::get('status') == 'success' ? 'alert-success' : 'alert-danger' }}">
                            {{ Request::get('message') }}
                        </p>
                        </p>

                        <div class="d-grid gap-2 col-md-12">

                            @if (Request::get('message') && Request::get('message') != 'Delivery confirmed!')
                                <a href="{{ route('my account') }}" class="btn btn-primary ">Goto Wallet</a>
                            @elseif (Request::get('message') && Request::get('message') == 'Delivery confirmed!')
                                <a href="{{ route('home') }}" class="btn btn-success ">Goto Homepage</a>
                            @else
                                <a href="{{ url()->previous() }}" class="btn btn-danger ">Go back</a>
                            @endif

                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>


</body>

</html>
