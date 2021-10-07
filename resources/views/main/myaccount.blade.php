<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

        <!-- Favicon -->
<link rel="icon" href="https://res.cloudinary.com/pilstech/image/upload/v1602675914/paysprint_icon_png_ol2z3u.png" type="image/x-icon" />

<link rel="stylesheet" type="text/css" href="{{ asset('pace/themes/orange/pace-theme-flash.css') }}" />

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">

<script src="https://kit.fontawesome.com/384ade21a6.js"></script>

    <title>PaySprint | Wallet</title>

    <style>
        body {
    background: #f5f5f5
}

.rounded {
    border-radius: 1rem
}

.nav-pills .nav-link {
    color: rgb(255, 255, 255)
}

.nav-pills .nav-link.active {
    color: white
}

input[type="radio"] {
    margin-right: 5px
}

.bold {
    font-weight: bold
}
.disp-0{
    display: none !important;
}
.fas{
    font-size: 12px;
}
.nav-tabs .nav-link{
    border: 1px solid #6c757d !important;
    width: 20%;
}

.nav-link.active, .nav-pills .show>.nav-link{
    background-color: #fff3cd !important;
}
    </style>

  </head>
  <body>
    <div class="container py-5">
        <!-- For demo purpose -->
        <div class="row mb-4">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-4">My Wallet</h1>
            </div>
        </div> <!-- End -->
        <div class="row">
            <div class="col-lg-12 mx-auto">
                <div class="card ">
                    <div class="card-header">
                        <div class="bg-white shadow-sm pt-4 pl-2 pr-2 pb-2">
                            <!-- Credit card form tabs -->
                            <ul role="tablist" class="nav bg-light nav-pills rounded nav-fill mb-3">
                                <li class="nav-item" style="background-color: #007bff !important;"> <a data-toggle="pill" href="{{ route('home') }}" class="nav-link active" style="background-color: #007bff !important;"> <i class="fas fa-home"></i> Goto HomePage </a> </li>
                            </ul>
                        </div> <!-- End -->
                        <!-- Credit card form content -->
                        <div class="tab-content">

                            <!-- credit card info-->
                            <div id="credit-card" class="tab-pane fade show active pt-3">
                                    

                                    <div class="form-group row">

                                        <div class="col-md-12">
                                            {{--  <h5>Hello {{ (strlen($name) < 10) ? $name : substr($name, 0, 10)."." }},</h5>  --}}
                                            @php
                                                $username = explode(" ", $name);
                                            @endphp

                                            <h5>Hello {{ $username[0] }},</h5>
                                            <p>
                                                {{ (date('A') == "AM") ? "Good Morning! Hope you took some coffee.☕" : "Good day! Remember to wash your hands.👏" }}
                                            </p>
                                        </div>

                                        <div class="col-md-6">
                                                <div class="alert alert-warning">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h6 class="font-sm">
                                                                Wallet Balance
                                                            </h6>
                                                        </div>
                                                        <div class="col-md-7">
                                                            <h4>
                                                                {{ $data['currencyCode']->currencySymbol."".number_format(Auth::user()->wallet_balance, 2) }}
                                                            </h4>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <a href="{{ route('paysprint currency exchange') }}" style="font-weight: bold; text-decoration: none;">
                                                                Currency Exchange <img src="https://img.icons8.com/external-wanicon-two-tone-wanicon/30/000000/external-currency-stock-market-wanicon-two-tone-wanicon.png"/>
                                                            </a>
                                                        </div>
                                                    </div>
                                            </div>

                                            <p>

                                                @if (isset($data['getCard']) && count($data['getCard']) > 0)

                                                @php
                                                    $others = count($data['getCard']) - 1;
                                                    $cardNo = wordwrap($data['getCard'][0]->card_number, 4, '-', true);
                                                @endphp

                                                @switch($data['getCard'][0]->card_type)
                                                @case("Mastercard")
                                                    @php
                                                        $alertInfo = "alert-danger";
                                                        $cardImage = '<img src="https://img.icons8.com/color/30/000000/mastercard.png"/>';
                                                    @endphp
                                                    @break
                                                @case("Visa")
                                                    @php
                                                        $alertInfo = "alert-info";
                                                        $cardImage = '<img src="https://img.icons8.com/color/30/000000/visa.png"/>';
                                                    @endphp
                                                    @break
                                                @default
                                                    @php
                                                        $alertInfo = "alert-success";
                                                        $cardImage = '<img src="https://img.icons8.com/fluent/30/000000/bank-card-back-side.png"/>';
                                                    @endphp
                                                @endswitch

                                                <div class="alert {{ $alertInfo }}">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h6 class="font-sm">
                                                                {{ (strlen($cardNo) < 10) ? $cardNo : substr($cardNo, 0, 10)."***" }} {{ ($others > 0) ? "& ".$others." others" : "" }}

                                                                
                                                            </h6>
                                                        </div>
                                                        <br>
                                                        <div class="col-md-6">
                                                            <h6>
                                                               Expiry: {{ $data['getCard'][0]->month."/".$data['getCard'][0]->year }}
                                                            </h6>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h6>
                                                               CVV: ***
                                                            </h6>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h6>
                                                                {{ (strlen($data['getCard'][0]->card_name) < 18) ? strtoupper($data['getCard'][0]->card_name) : substr(strtoupper($data['getCard'][0]->card_name), 0, 18)."..." }}
                                                            </h6>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            {!! $cardImage !!}
                                                        </div>
                                                    </div>
                                            </div>


                                            {{--  Add Payment Gateway  --}}
                                                <h4>Payment Method</h4><hr>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <button style="background-color: #000 !important;" class="px-2" title="PaySprint Payment Gateway" onclick="location.href='{{ route('payment gateway', 'gateway=PaySprint') }}'">
                                                        <img src="https://res.cloudinary.com/pilstech/image/upload/v1618251695/paysprint_icon_new_kg2h3j.png" alt="PaySprint logo" width="50" height="50">
                                                    </button>
                                                    <button class="px-2" title="GooglePay Payment Gateway" onclick="comingSoon()"><img src="https://img.icons8.com/fluent/50/000000/google-logo.png"/></button>

                                                </div>
                                            </div>



                                            <div class="d-flex align-items-start disp-0">
                                                <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                                    <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true" style="background-color: #000 !important;">
                                                        <img src="https://res.cloudinary.com/pilstech/image/upload/v1618251695/paysprint_icon_new_kg2h3j.png" alt="PaySprint logo" width="50" height="50">
                                                    </button>
                                                    <br>
                                                    <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false"><img src="https://img.icons8.com/fluent/50/000000/google-logo.png"/></button>
                                                    
                                                </div>
                                                <div class="tab-content px-3" id="v-pills-tabContent">
                                                    <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">

                                                        {{--  PaySprint Card  --}}

                                                        <div class="row">
                                                            <div class="col-md-4 mb-3">
                                                                <strong>
                                                                    <a type="button" class="btn btn-warning" style="color: purple; font-weight: bold; background-color: #fff !important;" href="{{ route('Add card', 'card=Credit Card') }}"><img src="https://img.icons8.com/fluent/53/000000/credit-card-cash-withdrawal.png" title="Add Credit Card"/> <i class="fas fa-plus-square" title="Add Credit Card" style="font-size: 16px; color: black"></i></a>
                                                                </strong>
                                                            </div>
                                                            <div class="col-md-4 mb-3">
                                                                <strong>
                                                                    <a type="button" class="btn btn-warning" style="color: purple; font-weight: bold; background-color: #fff !important;" href="{{ route('Add card', 'card=Prepaid Card') }}"> <img src="https://img.icons8.com/cotton/53/000000/bank-cards--v2.png" title="Add Prepaid Card"/> <i class="fas fa-plus-square" title="Add Prepaid Card" style="font-size: 16px; color: black"></i></a>
                                                                </strong>
                                                            </div>
                                                            <div class="col-md-4 mb-3">
                                                                <strong>

                                                                    <a type="button" class="btn btn-warning" style="color: #f7f7f7; font-weight: bold; background-color: #fff !important;" href="{{ route('Add bank detail') }}"> <img src="https://img.icons8.com/dusk/53/000000/merchant-account.png" title="Add Bank Account"/> <i class="fas fa-plus-square" title="Add Bank Account" style="font-size: 16px; color: black"></i></a>
                                                                </strong>
                                                            </div>
                                                        </div>


                                                        {{--  PaySprint Card End  --}}


                                                    </div>
                                                    <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                                                        
                                                    </div>
                                                    
                                                </div>
                                                </div>

                                                {{--  End Payment Gateway  --}}

                                                    
                                                

                                                @else

                                                {{--  Add Payment Gateway  --}}
                                                <h4>Payment Method</h4><hr>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <button style="background-color: #000 !important;" class="px-2" title="PaySprint Payment Gateway" onclick="location.href='{{ route('payment gateway', 'gateway=PaySprint') }}'">
                                                        <img src="https://res.cloudinary.com/pilstech/image/upload/v1618251695/paysprint_icon_new_kg2h3j.png" alt="PaySprint logo" width="50" height="50">
                                                    </button>
                                                    <button class="px-2" title="GooglePay Payment Gateway" onclick="comingSoon()"><img src="https://img.icons8.com/fluent/50/000000/google-logo.png"/></button>

                                                </div>
                                            </div>


                                            <div class="d-flex align-items-start disp-0">
                                                <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                                    <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">
                                                        <img src="https://res.cloudinary.com/pilstech/image/upload/v1618251695/paysprint_icon_new_kg2h3j.png" alt="PaySprint logo" width="50" height="50">
                                                    </button>
                                                    <br>
                                                    <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false"><img src="https://img.icons8.com/fluent/50/000000/google-logo.png"/></button>
                                                    
                                                </div>
                                                <div class="tab-content px-3" id="v-pills-tabContent">
                                                    <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">

                                                        {{--  PaySprint Card  --}}

                                                        <div class="row">
                                                            <div class="col-md-4 mb-3">
                                                                <strong>
                                                                    <a type="button" class="btn btn-warning" style="color: purple; font-weight: bold; background-color: #fff !important;" href="{{ route('Add card', 'card=Credit Card') }}"><img src="https://img.icons8.com/fluent/53/000000/credit-card-cash-withdrawal.png" title="Add Credit Card"/> <i class="fas fa-plus-square" title="Add Credit Card" style="font-size: 16px; color: black"></i></a>
                                                                </strong>
                                                            </div>
                                                            <div class="col-md-4 mb-3">
                                                                <strong>
                                                                    <a type="button" class="btn btn-warning" style="color: purple; font-weight: bold; background-color: #fff !important;" href="{{ route('Add card', 'card=Prepaid Card') }}"> <img src="https://img.icons8.com/cotton/53/000000/bank-cards--v2.png" title="Add Prepaid Card"/> <i class="fas fa-plus-square" title="Add Prepaid Card" style="font-size: 16px; color: black"></i></a>
                                                                </strong>
                                                            </div>
                                                            <div class="col-md-4 mb-3">
                                                                <strong>

                                                                    <a type="button" class="btn btn-warning" style="color: #f7f7f7; font-weight: bold; background-color: #fff !important;" href="{{ route('Add bank detail') }}"> <img src="https://img.icons8.com/dusk/53/000000/merchant-account.png" title="Add Bank Account"/> <i class="fas fa-plus-square" title="Add Bank Account" style="font-size: 16px; color: black"></i></a>
                                                                </strong>
                                                            </div>
                                                        </div>


                                                        {{--  PaySprint Card End  --}}


                                                    </div>
                                                    <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                                                        
                                                    </div>
                                                    
                                                </div>
                                                </div>

                                                {{--  End Payment Gateway  --}}

                                                
                                                
                                                
                                                    
                                                @endif

                                                
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="alert alert-info">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h6 class="font-sm">
                                                                Number of Withdrawals
                                                            </h6>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <h4>
                                                                {{ number_format(Auth::user()->number_of_withdrawals) }}
                                                            </h4>
                                                        </div>
                                                    </div>
                                            </div>
                                            <div class="alert alert-success">
                                                    <div class="row">
                                                        

                                                        @if (isset($data['getBank']) && count($data['getBank']) > 0)
                                                        
                                                        @php
                                                            $otherBanks = count($data['getBank']) - 1;
                                                            $accountNumber = $data['getBank'][0]->accountNumber;
                                                        @endphp

                                                            <div class="col-md-12">
                                                                <h6>
                                                                    {{ (strlen($accountNumber) < 15) ? $accountNumber : substr($accountNumber, 0, 15)."***" }} {{ ($otherBanks > 0) ? "& ".$otherBanks." others" : "" }}
                                                                </h6>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <h4>
                                                                    {{ $data['getBank'][0]->bankName }}
                                                                </h4>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <h6>
                                                                Transit Number: {{ $data['getBank'][0]->transitNumber }}
                                                                </h6>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <h6>
                                                                Branch Code: {{ $data['getBank'][0]->branchCode }}
                                                                </h6>
                                                            </div>

                                                        @else

                                                        <div class="col-md-12">
                                                            <h6 class="font-sm">
                                                                Bank Account
                                                                {{--  getBank  --}}
                                                            </h6>
                                                        </div>

                                                            <div class="col-md-12">
                                                                <h4>
                                                                    {{--  {{ route('Add bank detail') }}  --}}
                                                                    <a href="{{ route('Add bank detail') }}">Add a Bank Account</a>
                                                                </h4>
                                                            </div>

                                                        @endif
                                                        
                                                        <div class="row">
                                                        <div class="col-md-6">
                                                            <img src="https://img.icons8.com/emoji/30/000000/bank-emoji.png"/>
                                                        </div>
                                                    </div>
                                                    </div>
                                            </div>

                                            <div class="alert alert-default">
                                                <a href="{{ route('request for refund') }}" type="button" class="btn btn-danger btn-block">Request For Refund To Wallet</a>
                                            </div>

                                        </div>

                                        
                                    </div>

                                    
                                    
                                    
                                    <div class="form-group row"> 
                                        <div class="col-md-6 mb-3">
                                            <a type="button" href="{{ route('Add Money') }}" class="btn btn-info btn-block">Add Money <i class="fa fa-plus"></i></a>
                                        </div>

                                        @if (Auth::user()->approval == 2 && Auth::user()->accountLevel == 3)

                                        @if (isset($data['specialInfo']))

                                        

                                            <div class="col-md-6 mb-3">
                                                <a type="button" href="javascript:void()" class="btn btn-secondary btn-block" onclick="restriction('specialinfo', '{{ Auth::user()->name }}')">Withdraw Money <i class="fa fa-credit-card"></i></a>

                                            </div>

                                            @else

                                            <div class="col-md-6 mb-3">
                                                <a type="button" href="{{ route('Withdraw Money') }}" class="btn btn-secondary btn-block">Withdraw Money <i class="fa fa-credit-card"></i></a>
                                            </div>

                                        @endif
                                        
                                            
                                        @else

                                        <div class="col-md-6 mb-3">
                                                <a type="button" href="javascript:void()" class="btn btn-secondary btn-block" onclick="restriction('withdrawal', '{{ Auth::user()->name }}')">Withdraw Money <i class="fa fa-credit-card"></i></a>
                                            </div>
                                            
                                        @endif

                                        
                                    </div>

                                    @if (isset($data['specialInfo']))

                                    <div class="alert alert-danger alert-dismissible show specialText disp-0" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="$('.specialText').addClass('disp-0')">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        {!! $data['specialInfo']->information !!}
                                    </div>

                                    @endif

                                    
                                    

                                    <div class="form-group"> 
                                        <nav>
                                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Wallet Statement <i class="fas fa-circle text-secondary"></i></button>
                                                    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Credit <i class="fas fa-circle text-success"></i></button>
                                                    <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Debit <i class="fas fa-circle text-danger"></i></button>
                                                    @if (Auth::user()->accountType == "Individual")
                                                        <button class="nav-link" data-bs-toggle="tab" type="button" role="tab" aria-selected="false" onclick="location.href='{{ url('payorganization?type='.base64_encode('local')) }}'">Send Money <i class="fas fa-circle text-warning"></i></button>
                                                    @else
                                                        <button class="nav-link" data-bs-toggle="tab" type="button" role="tab" aria-selected="false" onclick="location.href='{{ route('merchant send money', 'type='.base64_encode('local')) }}'">Send Money <i class="fas fa-circle text-warning"></i></button>
                                                    @endif
                                                    

                                                    @if (Auth::user()->country == "Canada")
                                                        <button class="nav-link" data-bs-toggle="tab" type="button" role="tab" aria-selected="false" onclick="location.href='{{ route('request exbc card') }}'">Get a Prepaid Card <i class="fas fa-circle text-info"></i></button>
                                                    @endif

                                                    
                                                </div>
                                        </nav>
                                        <br>
                                        <div class="tab-content" id="nav-tabContent">

                                            @if (count($data['walletStatement']) > 0)

                                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                                <div class="container">
                                                    <div class="table table-responsive">
                                                        <table class="table table-striped" id="myTableAll">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Description</th>
                                                                    <th>Amount</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($data['walletStatement'] as $walletstatements)

                                                                
                                                                    <tr>
                                                                        <td><i class="fas fa-circle {{ ($walletstatements->credit != 0) ? "text-success" : "text-danger" }}"></i></td>
                                                                        <td>

                                                                                <div class="row">
                                                                                    <div class="col-md-12">
                                                                                        {!! $walletstatements->activity !!}
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <small>
                                                                                            {{ $walletstatements->reference_code }}
                                                                                        </small><br>
                                                                                        <small>
                                                                                            {{ date('d/m/Y h:i a', strtotime($walletstatements->created_at)) }}
                                                                                        </small>
                                                                                        @if ($walletstatements->auto_deposit == 'off')
                                                                                            <br>
                                                                                            <small>
                                                                                                <input type="hidden" name="reference_code" id="reference_code" value="{{ $walletstatements->reference_code }}">
                                                                                                <button type="button" class="btn btn-success" onclick="handShake('claimmoney', '{{ $walletstatements->reference_code }}')">Pending - Add to wallet <img src="https://img.icons8.com/officel/25/000000/spinner-frame-4.png" class="fa-spin disp-0" id="btn{{ $walletstatements->reference_code }}"/></button>
                                                                                            </small>
                                                                                        @endif
                                                                                    </div>
                                                                                </div>

                                                                            </td>
                                                                        <td style="font-weight: 700" class="{{ ($walletstatements->credit != 0) ? "text-success" : "text-danger" }}">{{ ($walletstatements->credit != 0) ? "+".$data['currencyCode']->currencySymbol.number_format($walletstatements->credit, 2) : "-".$data['currencyCode']->currencySymbol.number_format($walletstatements->debit, 2) }} <br> <small class="{{ ($walletstatements->status == "Delivered") ? "text-primary" : "text-secondary" }}"><strong>{{ $walletstatements->status }}</strong></small> </td>
                                                                    </tr>
                                                
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                                <div class="container">
                                                    <div class="table table-responsive">
                                                        <table class="table table-striped" id="myTableCredit">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Description</th>
                                                                    <th>Amount</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($data['walletStatement'] as $walletstatements)

                                                                    @if ($walletstatements->credit != 0)
                                                                        <tr>
                                                                            <td><i class="fas fa-circle text-success"></i></td>
                                                                            <td>

                                                                                <div class="row">
                                                                                    <div class="col-md-12">
                                                                                        {!! $walletstatements->activity !!}
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <small>
                                                                                            {{ $walletstatements->reference_code }}
                                                                                        </small><br>
                                                                                        <small>
                                                                                            {{ date('d/m/Y h:i a', strtotime($walletstatements->created_at)) }}
                                                                                        </small>
                                                                                        @if ($walletstatements->auto_deposit == 'off')
                                                                                            <br>
                                                                                            <small>
                                                                                                <input type="hidden" name="reference_code" id="reference_code" value="{{ $walletstatements->reference_code }}">
                                                                                                <button type="button" class="btn btn-success" onclick="handShake('claimmoney', '{{ $walletstatements->reference_code }}')">Pending - Add to wallet <img src="https://img.icons8.com/officel/25/000000/spinner-frame-4.png" class="fa-spin disp-0" id="btn{{ $walletstatements->reference_code }}"/></button>
                                                                                            </small>
                                                                                        @endif
                                                                                    </div>
                                                                                </div>

                                                                            </td>
                                                                            <td style="font-weight: 700" class="text-success">{{ "+".$data['currencyCode']->currencySymbol.number_format($walletstatements->credit, 2) }}<br> <small class="{{ ($walletstatements->status == "Delivered") ? "text-primary" : "text-secondary" }}"><strong>{{ $walletstatements->status }}</strong></small></td>
                                                                        </tr>

                                                                    @endif
                                                                
                                                                    
                                                
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                                                <div class="container">
                                                    <div class="table table-responsive">
                                                        <table class="table table-striped" id="myTableDebit">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Description</th>
                                                                    <th>Amount</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                                @foreach ($data['walletStatement'] as $walletstatements)

                                                                    @if ($walletstatements->debit != 0)
                                                                        <tr>
                                                                            <td><i class="fas fa-circle text-danger"></i></td>
                                                                            <td>

                                                                                <div class="row">
                                                                                    <div class="col-md-12">
                                                                                        {!! $walletstatements->activity !!}
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <small>
                                                                                            {{ $walletstatements->reference_code }}
                                                                                        </small><br>
                                                                                        <small>
                                                                                            {{ date('d/m/Y h:i a', strtotime($walletstatements->created_at)) }}
                                                                                        </small>
                                                                                    </div>
                                                                                </div>

                                                                            </td>
                                                                            <td style="font-weight: 700" class="text-danger">
                                                                                {{ "-".$data['currencyCode']->currencySymbol.number_format($walletstatements->debit, 2) }}<br> <small class="{{ ($walletstatements->status == "Delivered") ? "text-primary" : "text-secondary" }}"><strong>{{ $walletstatements->status }}</strong></small>
                                                                            </td>
                                                                        </tr>

                                                                    @endif
                                                                
                                                                    
                                                
                                                                @endforeach
                                                                
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>




                                                
                                            @else

                                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                                <div class="container">
                                                    <div class="table table-responsive">
                                                        <table class="table table-striped">
                                                            <tbody>
                                                                <tr>
                                                                    <td colspan="3">No record</td>
                                                                </tr>
                                                                
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                                <div class="container">
                                                    <div class="table table-responsive">
                                                        <table class="table table-striped">
                                                            <tbody>
                                                                <tr>
                                                                    <td colspan="3">No record</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                                                <div class="container">
                                                    <div class="table table-responsive">
                                                        <table class="table table-striped">
                                                            <tbody>
                                                                
                                                                <tr>
                                                                    <td colspan="3">No record</td>
                                                                </tr>
                                                                
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                                
                                            @endif

                                            
                                            
                                        </div>
                                    </div>


                            

                        </div> <!-- End -->
                        
                    </div>
                </div>
            </div>
        </div>

    
        <script src="{{ asset('js/jquery-1.12.0.min.js') }}"></script>

        @include('include.message')


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous"></script>

        <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

    <script src="{{ asset('pace/pace.min.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>



    <script>

        $(document).ready(function(){
            $('#myTableAll').DataTable();
            $('#myTableCredit').DataTable();
            $('#myTableDebit').DataTable();

            $('#orgpaycreditcard').attr('value', '0');
            // Run Ajax
            currencyConvert();
        });

        $("#payment_method").change(function(){

            if($("#payment_method").val() == "EXBC Card"){
                $(".bizInfo").removeClass('disp-0');
                

                $(".bank_info").addClass('disp-0');
                $(".card_info").removeClass('disp-0');

                $("#accountname").val("NILL");
                $('#account_number').attr('value', '0');
                $("#bank_name").val("NILL");

            }
            else{
                $(".bizInfo").addClass('disp-0');

                $(".bank_info").removeClass('disp-0');
                $(".card_info").addClass('disp-0');

                $('#orgpaycreditcard').attr('value', '0');

            }
        });


        function currencyConvert(){

        $("#conversionamount").val("");

        var currency = "{{ $data['currencyCode']->currencyCode }}";
        var route = "{{ URL('Ajax/getconversion') }}";
        var thisdata = {currency: currency, amount: $("#amount_to_receive").val(), val: "receive"};

            setHeaders();
            jQuery.ajax({
            url: route,
            method: 'post',
            data: thisdata,
            dataType: 'JSON',
            success: function(result){

                if(result.message == "success"){
                    $("#conversionamount").val(result.data);
                }
                else{
                    $("#conversionamount").val("");
                }


            }

        });
    }


    function handShake(val, ref_code){

        var route;

if(val == 'claimmoney'){

var formData = new FormData();
var spin = $('#btn'+ref_code);

formData.append('reference_code', $('#reference_code').val());


    route = "{{ URL('/api/v1/claimmoney') }}";

        Pace.restart();
    Pace.track(function(){
        setHeaders();
        jQuery.ajax({
        url: route,
        method: 'post',
        data: formData,
        cache: false,
        processData: false,
        contentType: false,
        dataType: 'JSON',
        beforeSend: function(){
            spin.removeClass('disp-0');
        },
        success: function(result){
            spin.addClass('disp-0');
            if(result.status == 200){
                    swal("Success", result.message, "success");
                    setTimeout(function(){ location.reload(); }, 2000);
                }
                else{
                    swal("Oops", result.message, "error");
                }

        },
        error: function(err) {
            spin.addClass('disp-0');
            swal("Oops", err.responseJSON.message, "error");

        } 

    });
    });

}

    }


function comingSoon(val){
    if(val == 'bank'){
        swal('Feature available soon', 'Add a new bank account will be available soon', 'info');
    }
    else{
     swal('Hey', 'This feature is coming soon', 'info');

    }
 }

 function restriction(val, name){
     $('.specialText').addClass("disp-0");
    if(val == "withdrawal"){
        swal('Hello '+name, 'Your account need to be verified before you can make withdrawal', 'info');
    }
    else if(val == "specialinfo"){
        $('.specialText').removeClass("disp-0");
    }
 }


        //Set CSRF HEADERS
    function setHeaders(){
    jQuery.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': "{{csrf_token()}}",
            'Authorization': "Bearer "+"{{ Auth::user()->api_token }}"
      }
    });
 }

    </script>

  </body>
</html>