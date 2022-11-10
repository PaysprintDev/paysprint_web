<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>PAYSPRINT | RUN EPS</title>
        <!-- Bootstrap CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
</head>
<body>

    <div class="container">

        <br>
        <h2 class="text-center">EXPRESS RERUN PENDING TRANSACTIONS</h2>
        <br>
            <form action="{{ route('eps rerun') }}" method="get">
        @csrf
        <div>
            <label for="email">Email</label>
            <input type="email" name="email" placeholder="Email Address" class="form-control">
        </div>
        <br>
        <div>
            <label for="paymentToken">Transaction ID</label>
            <input type="text" name="paymentToken" placeholder="Transaction ID" class="form-control">
        </div>
        <br>
        <button type="submit" class="btn btn-primary btn-block">Submit</button>
    </form>


<br><br>
    {!! session('msg') !!}


    </div>

</body>
</html>
