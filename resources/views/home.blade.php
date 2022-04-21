@extends('layouts.app')



@section('title', 'Home')

@show

@section('content')

<?php use App\Http\Controllers\User; ?>

<!-- Professional Builde -->
<section class="professional_builders row">
    <div class="container" id="myHeader" style="background-color: #fff;">
        <br>
        <br>
        <div class="row builder_all">
            <div class="col-md-4 col-sm-6 builder walletInformation">
                <div class="alert alert-warning">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="font-sm">
                                Balance
                            </h4>
                        </div>
                        <br>
                        <div class="col-md-12">
                            <h3>
                                {{ $data['currencyCode']->currencySymbol . '' . number_format(Auth::user()->wallet_balance, 2) }}
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 builder walletInformation">
                <div class="alert alert-info">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="font-sm">
                                Withdrawals
                            </h4>
                        </div>
                        <div class="col-md-12">
                            <h3>
                                {{ number_format(Auth::user()->number_of_withdrawals) }}
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 builder walletInformation">
                <div class="alert alert-success">
                    <div class="row">
                        <div class="col-md-12">
                            <small class="font-sm">
                                Total Points
                            </small>
                        </div>



                    </div>

                    <div class="row">

                        <div class="col-md-4">
                            <h3>
                                {{ isset($data['mypoints']) ? $data['mypoints']->points_acquired : 0 }}

                            </h3>
                        </div>

                        <div class="col-md-4">
                            <small>
                                <a style="font-weight: 700; font-size: 11px" href="{{ route('consumer points') }}">
                                    Earned Points
                                </a>
                            </small>
                        </div>


                        <div class="col-md-4">
                            <form action="{{ route('claim point') }}" method="POST" id="claimmypoint">
                                @csrf
                                <small><a type='button' href="javascript:void()" onclick="$('#claimmypoint').submit()"
                                        style="font-weight: 700; font-size: 11px">Redeem
                                        Points</a></small>

                            </form>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Professional Builde -->


<!-- Professional Builde -->
<section class="professional_builder row">
    <div class="container">

        @isset($data['specialInfo'])
            <div class="row">
                <div class="alert alert-success show" role="alert">
                    <strong>
                        <h5>*** Special Information ***</h5>
                    </strong>
                    <hr>
                    <p>
                        {{ $data['specialInfo']->information }}
                    </p>


                </div>
            </div>
        @endisset



        @if (Auth::user()->approval == 0 || Auth::user()->accountLevel == 0)
            <div class="row">
                <div class="alert alert-danger alert-dismissible show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                    <p>
                        <strong>Welcome {{ Auth::user()->name }}!</strong> <br> Our system is yet to complete your
                        registration. Kindly upload a copy of Government-issued Photo ID, a copy of a Utility Bill or
                        Bank Statement that matches your name with the current address and also take a Selfie of
                        yourself (if using the mobile app) and <a href="{{ route('profile') }}"
                            style="font-weight: bold; text-decoration: underline">upload in your profile setting</a> to
                        complete the verification process. <a href="{{ route('contact') }}"
                            style="font-weight: bold; text-decoration: underline">Kindly contact the admin using the
                            contact us form if you require further assistance. Thank You</a>
                    </p>



                </div>
            </div>
        @endif



        @if (Auth::user()->country == 'Canada' && Auth::user()->accountType == 'Merchant')
            <div class="row">
                <div class="alert alert-info" role="alert">

                    <p>
                        <strong>Hey {{ Auth::user()->businessname }}!</strong> <br> You are eligible for a cash
                        advance. <a href="{{ route('cash advance') }}"
                            style="font-weight: bold; text-decoration: underline">Click here to continue</a>
                    </p>

                </div>
            </div>
        @endif

        <div class="row">

            <div class="col-md-6">
                <div class="card" style="width: 100%;">

                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            Current Plan: {{ strtoupper(Auth::user()->plan) }} <br><br>

                            <form action="#" method="post" id="formElemchangeplan" class="disp-0">
                                @csrf
                                <input value="{{ Auth::id() }}" name="user_id">
                            </form>

                            @if (Auth::user()->plan == 'basic')
                                <button class="btn btn-primary" onclick="changeMyPlan('changeplan')"
                                    id="cardSubmit">Upgrade
                                    Account</button>
                            @else
                                @if (Auth::user()->country == 'Canada' || Auth::user()->country == 'United States')
                                    <button class="btn btn-danger" onclick="changeMyPlan('changeplan')"
                                        id="cardSubmit">Downgrade
                                        Account</button>

                                    @isset($data['myplan'])
                                        <br>
                                        <br>
                                        <p class="text-info">Next Renewal:
                                            {{ date('d-m-Y', strtotime($data['myplan']->expire_date)) }}</p>

                                        @php
                                            $expire = date('Y-m-d', strtotime($data['myplan']->expire_date));
                                            $now = time();
                                            $your_date = strtotime($expire);
                                            $datediff = $your_date - $now;
                                        @endphp

                                        <p class="text-danger">
                                            {{ round($datediff / (60 * 60 * 24)) > 1? round($datediff / (60 * 60 * 24)) . 'days': round($datediff / (60 * 60 * 24)) . 'day' }}
                                            left</p>
                                    @endisset
                                @else
                                    @isset($data['myplan'])
                                        <p class="text-info">Next Renewal:
                                            {{ date('d-m-Y', strtotime($data['myplan']->expire_date)) }}</p>

                                        @php
                                            $expire = date('Y-m-d', strtotime($data['myplan']->expire_date));
                                            $now = time();
                                            $your_date = strtotime($expire);
                                            $datediff = $your_date - $now;
                                        @endphp

                                        <p class="text-danger">
                                            {{ round($datediff / (60 * 60 * 24)) > 1? round($datediff / (60 * 60 * 24)) . 'days': round($datediff / (60 * 60 * 24)) . 'day' }}
                                            left</p>
                                    @endisset
                                @endif


                            @endif

                            <hr>

                            <a href="{{ route('pricing structure') }}">Do more with PaySprint. Check our
                                Pricing</a>
                        </li>

                    </ul>
                </div>
            </div>

            @if (Auth::user()->plan == 'classic')
                <div class="col-md-6">
                    <div class="card" style="width: 100%;">

                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                Trade FX with PaySprint <br><br>

                                @if ($data['imtAccess']->imt == 'false')
                                    <a type="button" class="btn btn-primary" href="javascript:void()" id="cardSubmit"
                                        disabled>PaySprint
                                        Currency FX</a>

                                    <hr>

                                    <a href="#">COMING SOON!!!</a>
                                @else
                                    <a type="button" class="btn btn-primary"
                                        href="{{ route('paysprint currency exchange') }}" id="cardSubmit">PaySprint
                                        Currency FX</a>

                                    <hr>

                                    <a href="#">Learn more about trading on PaySprint</a>
                                @endif


                            </li>

                        </ul>
                    </div>
                </div>
            @endif


            <div class="col-md-9">
                <div class="row builder_all">
                    <div class="col-md-6 col-sm-6 builder">
                        <br>
                        <div class="row">
                            <div class="col-md-8">
                                <h3 style="text-align: left !important;">5 most recent transactions</h3>
                                <h4 style="text-align: left !important;">Send & Receive</h4>
                            </div>
                            <div class="col-md-4">
                                <i class="far fa-paper-plane" title="Send Money" onclick="$('#sendMoney').click()"
                                    style="cursor: pointer"></i>
                            </div>
                        </div>
                        <div class="table table-responsive infoRec">
                            <table class="table table-striped">
                                <tbody>


                                    @if (count($data['sendReceive']) > 0)
                                        @foreach ($data['sendReceive'] as $sendRecData)
                                            <tr>
                                                <td><i
                                                        class="fas fa-circle {{ $sendRecData->credit != 0 ? 'text-success' : 'text-danger' }}"></i>
                                                </td>
                                                <td>



                                                    <div class="row">
                                                        <div class="col-md-12" style="text-align: left;">
                                                            {!! $sendRecData->activity !!}
                                                        </div>
                                                        <div class="col-md-12" style="text-align: left;">
                                                            <small>
                                                                {{ $sendRecData->reference_code }}
                                                            </small><br>
                                                            <small>
                                                                {{ date('d/m/Y h:i a', strtotime($sendRecData->created_at)) }}
                                                            </small>

                                                            @if ($sendRecData->auto_deposit == 'off')
                                                                <br>
                                                                <small>
                                                                    <input type="hidden" name="reference_code"
                                                                        id="reference_code"
                                                                        value="{{ $sendRecData->reference_code }}">

                                                                    <small><span class='badge badge-danger'
                                                                            style='cursor: pointer;'
                                                                            onclick="shakeHand('claimmoney', '{{ $sendRecData->reference_code }}')">Pending
                                                                            - Add to wallet <img
                                                                                src="https://img.icons8.com/officel/16/000000/spinner-frame-4.png"
                                                                                class="fa-spin disp-0"
                                                                                id="btn{{ $sendRecData->reference_code }}" /></span></small>


                                                                </small>
                                                            @endif

                                                        </div>
                                                    </div>

                                                </td>



                                                <td style="font-weight: 700"
                                                    class="{{ $sendRecData->credit != 0 ? 'text-success' : 'text-danger' }}">
                                                    {{ $sendRecData->credit != 0? '+' . $data['currencyCode']->currencySymbol . number_format($sendRecData->credit, 2): '-' . $data['currencyCode']->currencySymbol . number_format($sendRecData->debit, 2) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="3" align="center">No record</td>
                                        </tr>
                                    @endif



                                </tbody>
                            </table>

                            <a href="javascript:void(0)" type="button" class="btn btn-primary"
                                onclick="$('#sendMoney').click()">Send Money</a>

                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6 builder">
                        <br>
                        <div class="row">
                            <div class="col-md-8">
                                <h3 style="text-align: left !important;">5 most recent transactions</h3>
                                <h4 style="text-align: left !important;">Pay Invoice</h4>
                            </div>
                            <div class="col-md-4">
                                <i class="fas fa-file-invoice" title="Pay Invoice"
                                    onclick="location.href='{{ route('invoice') }}'" style="cursor: pointer"></i>
                            </div>
                        </div>
                        <div class="table table-responsive infoRec">
                            <table class="table table-striped">
                                <tbody>

                                    @if (isset($data['payInvoice']))

                                        @foreach (json_decode($data['payInvoice']) as $payInv)
                                            {{-- {{ dd($payInv) }} --}}


                                            {{-- Get Merchant Currency --}}

                                            @if ($merchant = \App\User::where('ref_code', $payInv->uploaded_by)->first())
                                                @if ($payInv->invoiced_currency != null)
                                                    @php
                                                        $currencySymb = $payInv->invoiced_currency_symbol;
                                                    @endphp
                                                @else
                                                    @php
                                                        $currencySymb = $merchant->currencySymbol;
                                                    @endphp
                                                @endif



                                                @php
                                                    $countryBase = $merchant->country;
                                                @endphp
                                            @else
                                                @php
                                                    $currencySymb = $data['currencyCode']->currencySymbol;
                                                    $countryBase = Auth::user()->country;
                                                @endphp
                                            @endif


                                            <tr>
                                                <td><i class="fas fa-circle"></i></td>
                                                <td>

                                                    <div class="row">
                                                        <div class="col-md-12" style="text-align: left;">

                                                            {!! 'Invoice for ' . $payInv->service . ' to ' . $payInv->merchantName !!}

                                                        </div>
                                                        <div class="col-md-12" style="text-align: left;">
                                                            <div class="row">
                                                                <div class="col-md-8">
                                                                    <small>
                                                                        {{ $payInv->invoice_no }}
                                                                        {!! $countryBase != Auth::user()->country ? '<img src="https://img.icons8.com/color/30/000000/around-the-globe.png"/>' : '' !!}
                                                                    </small>
                                                                </div>
                                                                <div class="col-md-4">

                                                                    @if ($payInv->payment_status == 0)
                                                                        <small><span class='badge badge-danger'
                                                                                style='cursor: pointer;'
                                                                                onclick=location.href='{{ route('payment', $payInv->invoice_no) }}'>Pay
                                                                                Invoice</span></small>
                                                                    @elseif($payInv->payment_status == 2)
                                                                        <small><span class='badge badge-danger'
                                                                                style='cursor: pointer;'
                                                                                onclick=location.href='{{ route('payment', $payInv->invoice_no) }}'>Pay
                                                                                Balance</span></small>
                                                                    @else
                                                                        <small><span
                                                                                class='badge badge-success'>Paid</span></small>
                                                                    @endif

                                                                    {{-- {!! ($payInv->payment_status == 0) ? "<small><span class='badge badge-danger' style='cursor: pointer;' onclick=location.href='".route('payment', $payInv->invoice_no)."'>Pay Invoice</span></small>" : "<small><span class='badge badge-success'>Paid</span></small>" !!} --}}

                                                                </div>
                                                            </div>
                                                            <small>
                                                                {{ date('d/m/Y h:i a', strtotime($payInv->created_at)) }}

                                                            </small>
                                                        </div>
                                                    </div>

                                                </td>
                                                <td style="font-weight: 700">



                                                    @php
                                                        if ($payInv->total_amount != null || $payInv->total_amount != 0) {
                                                            $totalAmount = $payInv->total_amount;
                                                        } else {
                                                            $totalAmount = $payInv->amount;
                                                        }
                                                    @endphp

                                                    @if ($payInv->payment_status == 0)
                                                        {{ '+' . $currencySymb . number_format($totalAmount, 2) }}
                                                    @elseif($payInv->payment_status == 2)
                                                        {{ '-' . $currencySymb . number_format($payInv->remaining_balance, 2) }}
                                                    @else
                                                        {{ '-' . $currencySymb . number_format($totalAmount, 2) }}
                                                    @endif

                                                    {{-- {{ ($payInv->payment_status == 0) ? "+".$currencySymb.number_format($totalAmount, 2) : "-".$currencySymb.number_format($totalAmount, 2) }} --}}


                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="3" align="center">No record</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>

                            <a href="{{ route('invoice') }}" type="button" class="btn btn-primary">Pay Invoice</a>

                        </div>
                    </div>
                </div>


                <div class="row builder_all">
                    <div class="col-md-6 col-sm-6 builder">
                        <br>
                        <div class="row">
                            <div class="col-md-8">
                                <h3 style="text-align: left !important;">5 most recent transactions</h3>
                                <h4 style="text-align: left !important;">Wallet Transactions</h4>
                            </div>
                            <div class="col-md-4">
                                <i class="fas fa-wallet" title="My Wallet"
                                    onclick="location.href='{{ route('my account') }}'" style="cursor: pointer"></i>
                            </div>
                        </div>
                        <div class="table table-responsive infoRec">
                            <table class="table table-striped">
                                <tbody>
                                    @if (count($data['sendReceive']) > 0)
                                        @foreach ($data['sendReceive'] as $sendRecData)
                                            <tr>
                                                <td><i
                                                        class="fas fa-circle {{ $sendRecData->credit != 0 ? 'text-success' : 'text-danger' }}"></i>
                                                </td>
                                                <td>

                                                    <div class="row">
                                                        <div class="col-md-12" style="text-align: left;">
                                                            {!! $sendRecData->activity !!}
                                                        </div>
                                                        <div class="col-md-12" style="text-align: left;">
                                                            <small>
                                                                {{ $sendRecData->reference_code }}
                                                            </small><br>
                                                            <small>
                                                                {{ date('d/m/Y h:i a', strtotime($sendRecData->created_at)) }}
                                                            </small>
                                                        </div>
                                                    </div>

                                                </td>
                                                <td style="font-weight: 700"
                                                    class="{{ $sendRecData->credit != 0 ? 'text-success' : 'text-danger' }}">
                                                    {{ $sendRecData->credit != 0? '+' . $data['currencyCode']->currencySymbol . number_format($sendRecData->credit, 2): '-' . $data['currencyCode']->currencySymbol . number_format($sendRecData->debit, 2) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="3" align="center">No record</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            <a href="{{ route('my account') }}" type="button" class="btn btn-primary">My Wallet</a>

                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 builder">
                        <br>
                        <div class="row">
                            <div class="col-md-8">
                                <h3 style="text-align: left !important;">5 most recent transactions</h3>
                                <h4 style="text-align: left !important;">Notifications</h4>
                            </div>
                            <div class="col-md-4">
                                <i class="far fa-bell" title="Notifications" style="cursor: pointer"
                                    onclick="location.href='{{ route('notifications') }}'"></i>
                                @if (count($data['getfiveNotifications']) > 0 && $data['getfiveNotifications'][0]->notify == 0)
                                    <i class="fas fa-circle fa-blink" style="color: rgb(129, 6, 6)"></i>
                                @endif
                            </div>
                        </div>
                        <div class="table table-responsive infoRec">
                            <table class="table table-striped">
                                <tbody>
                                    @if (count($data['getfiveNotifications']) > 0)
                                        @foreach ($data['getfiveNotifications'] as $urgentNotify)
                                            <tr>
                                                <td><i
                                                        class="fas fa-circle {{ $urgentNotify->notify == 0 ? 'text-success' : 'text-success' }}"></i>
                                                </td>
                                                <td align="left" colspan="2">

                                                    <div class="row">
                                                        <div class="col-md-12" style="text-align: left;">
                                                            {{-- {!! $urgentNotify->activity !!} --}}

                                                            {!! $urgentNotify->notify == 0 ? '<strong>' . $urgentNotify->activity . '</strong>' : $urgentNotify->activity !!}
                                                        </div>
                                                        <div class="col-md-12" style="text-align: left;">

                                                            <small>
                                                                {{ date('d/m/Y h:i a', strtotime($urgentNotify->created_at)) }}
                                                            </small>
                                                        </div>
                                                    </div>

                                                </td>

                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="3" align="center">No record</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">

                <div class="card" style="width: 100%;">
                    <div class="card-header"
                        style="background-color: #ffba01; padding: 10px; font-weight: bold; border-radius: 10px 10px 0px 0px;">
                        Quick Wallet Setup
                        @if (Auth::user()->approval == 0 || (count($data['getCard']) <= 0 && count($data['getBank']) <= 0) || Auth::user()->transaction_pin == null || Auth::user()->securityQuestion == null)
                            <a href="javascript:void()" type="button" class="btn btn-danger fa-blink">Incomplete</a>
                        @endif
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"
                            title="Upload Government issued photo ID e.g National ID, International Passport, Driver Licence">
                            <div class="row">
                                <div class="col-md-10">
                                    <a href="{{ route('profile') }}">Identity Verification</a>
                                </div>
                                <div class="col-md-2">
                                    {!! Auth::user()->approval > 0 ? "<img src='https://img.icons8.com/fluent/20/000000/check-all.png'/>" : "<img class='fa-blink' src='https://img.icons8.com/fluent/20/000000/cancel.png'/>" !!}
                                </div>
                            </div>

                        </li>
                        <li class="list-group-item"
                            title="To add money to your wallet, you need to add a credit/debit card to your account">

                            <div class="row">
                                <div class="col-md-10">
                                    <a href="{{ route('payment gateway', 'gateway=PaySprint') }}">Add Credit
                                        Card/Prepaid Card/Bank Account </a>
                                </div>
                                <div class="col-md-2">
                                    {!! count($data['getCard']) > 0 || count($data['getBank']) > 0 ? "<img src='https://img.icons8.com/fluent/20/000000/check-all.png'/>" : "<img class='fa-blink' src='https://img.icons8.com/fluent/20/000000/cancel.png'/>" !!}
                                </div>
                            </div>


                        </li>
                        <li class="list-group-item" title="Setup transaction pin for security purpose">

                            <div class="row">
                                <div class="col-md-10">
                                    <a href="{{ route('profile') }}">Set Transaction Pin </a>
                                </div>
                                <div class="col-md-2">
                                    {!! Auth::user()->transaction_pin != null ? "<img src='https://img.icons8.com/fluent/20/000000/check-all.png'/>" : "<img class='fa-blink' src='https://img.icons8.com/fluent/20/000000/cancel.png'/>" !!}
                                </div>
                            </div>


                        </li>
                        <li class="list-group-item" title="Setup transaction pin for security purpose">

                            <div class="row">
                                <div class="col-md-10">
                                    <a href="{{ route('profile') }}">Set Security Question </a>
                                </div>
                                <div class="col-md-2">
                                    {!! Auth::user()->securityQuestion != null ? "<img src='https://img.icons8.com/fluent/20/000000/check-all.png'/>" : "<img class='fa-blink' src='https://img.icons8.com/fluent/20/000000/cancel.png'/>" !!}
                                </div>
                            </div>



                        </li>


                        @if (Auth::user()->country == 'Nigeria')
                            <li class="list-group-item" title="Bank Verification (BVN)">

                                <div class="row">
                                    <div class="col-md-10">
                                        <a href="{{ route('profile') }}">Bank Verification (BVN) </a>
                                    </div>
                                    <div class="col-md-2">
                                        {!! Auth::user()->bvn_verification != null || Auth::user()->bvn_verification > 0 ? "<img src='https://img.icons8.com/fluent/20/000000/check-all.png'/>" : "<img class='fa-blink' src='https://img.icons8.com/fluent/20/000000/cancel.png'/>" !!}
                                    </div>
                                </div>



                            </li>
                        @endif


                    </ul>
                </div>

                {{-- <div class="card" style="width: 100%;">
                    
                    <ul class="list-group list-group-flush">

                        <li class="list-group-item" title="total points">
                            <div class="row">

                                <div class="col-md-12">
                                    <p class="text-center">
                                        Total Points
                                    </p>

                                    <p style=" text-align: center; font-size: 30px;">
                                        <img src="https://img.icons8.com/external-tulpahn-outline-color-tulpahn/20/000000/external-celebration-chinese-new-year-tulpahn-outline-color-tulpahn.png"
                                            class="fa-blink" />
                                        {{ isset($data['mypoints']) ? $data['mypoints']->points_acquired : 0 }}
                                        <img src="https://img.icons8.com/external-tulpahn-outline-color-tulpahn/20/000000/external-celebration-chinese-new-year-tulpahn-outline-color-tulpahn.png"
                                            class="fa-blink" />
                                    </p>
                                </div>


                            </div>

                            <br>

                            <div class="row">
                                <form action="{{ route('claim point') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="col-md-12">
                                        

                                        <button type="submit" class="btn btn-default btn-block">Claim
                                            Points</button>


                                    </div>
                                </form>
                            </div>

                        </li>

                    </ul>
                </div> --}}



                <div class="card" style="width: 100%;">
                    <div class="card-header"
                        style="background-color: #ff8a04; padding: 10px; font-weight: bold; border-radius: 10px 10px 0px 0px;">
                        Pay Utility Bills
                    </div>
                    <ul class="list-group list-group-flush">


                        <li class="list-group-item" title="Pay Utility Bills">
                            <div class="row">
                                <div class="col-md-12">

                                    @if (Auth::user()->country == 'Nigeria')
                                        <a href="{{ route('utility bills') }}">Utility Payment</small></a>
                                    @else
                                        <a
                                            href="{{ route('select utility bills country', 'country=' . Auth::user()->country) }}">Utility
                                            Payment</small></a>
                                    @endif


                                </div>
                            </div>

                        </li>

                    </ul>
                </div>



                <div class="card" style="width: 100%;">
                    <div class="card-header"
                        style="background-color:#00fd77; padding: 10px; font-weight: bold; border-radius: 10px 10px 0px 0px;">
                        Property Management

                    </div>
                    <ul class="list-group list-group-flush">


                        <li class="list-group-item" title="Rental Property Management">
                            <div class="row">
                                <div class="col-md-12">
                                    <a href="{{ route('rentalmanagement') }}">Rental Property Management</a>
                                </div>
                            </div>

                        </li>

                    </ul>
                </div>






                <div class="card" style="width: 100%;">
                    <div class="card-header"
                        style="background-color: #ffba00; padding: 10px; font-weight: bold; border-radius: 10px 10px 0px 0px;">
                        Merchant By Services

                    </div>
                    <ul class="list-group list-group-flush">

                        @if (count($data['getmerchantsByCategory']) > 0)

                            @foreach ($data['getmerchantsByCategory'] as $merchants)
                                <li class="list-group-item" title="{{ $merchants->industry }}">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <a
                                                href="{{ route('merchant category', 'service=' . $merchants->industry) }}">{{ $merchants->industry }}</a>
                                        </div>

                                    </div>

                                </li>
                            @endforeach

                            @if (count($data['getmerchantsByCategory']) == 8)
                                <a href="{{ route('all merchant') }}" type="button"
                                    class="btn btn-danger btn-block">View more <i class="fa fa-arrow-circle-o-right"
                                        aria-hidden="true"></i></a>
                            @endif
                        @else
                            <li class="list-group-item" title="No available merchant">
                                <div class="row">
                                    <div class="col-md-12">
                                        <a href="#">No available merchant</a>
                                    </div>
                                </div>

                            </li>

                        @endif


                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Professional Builde -->

@endsection
